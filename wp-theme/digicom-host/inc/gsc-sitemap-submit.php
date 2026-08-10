<?php
/**
 * Bao Google Search Console khi co bai/trang moi publish. 2 co che:
 *  1. Sitemap submit (sitemaps.submit) - bao Google doc lai wp-sitemap.xml, chay TU DONG
 *     moi khi publish, rate-limit 5 phut/lan.
 *  2. Indexing API (urlNotifications.publish) - ep Google index NHANH 1 URL cu the, chay
 *     TU DONG cho dung URL bai vua publish, VA co the goi thu cong cho tung URL/cum bai
 *     (xem dgc_gsc_index_urls / dgc_gsc_index_category).
 *     LUU Y: Google CHINH THUC chi cam ket Indexing API cho JobPosting/BroadcastEvent -
 *     dung cho bai blog thuong la ngoai muc dich cong bo, KHONG dam bao 100% hieu qua,
 *     co the bi Google am tham bo qua hoac gioi han quota (mac dinh 200 request/ngay).
 *
 * Can 2 constant trong wp-config.php (KHONG luu trong CSDL):
 *   define('DGC_GSC_KEY_PATH', '/duong/dan/tuyet-doi/toi/service-account.json');
 *   define('DGC_GSC_SITE_URL', 'https://digicomvn.com/'); // dung URL da verify trong Search Console
 * Bat/tat qua WP Admin > DigicomVN > muc 9 (option gsc_submit_on).
 */

function dgc_gsc_enabled() {
	$o = wp_parse_args( get_option( 'dgc_settings', array() ), dgc_defaults() );
	if ( empty( $o['gsc_submit_on'] ) || $o['gsc_submit_on'] !== '1' ) return false;
	if ( ! defined( 'DGC_GSC_KEY_PATH' ) || ! defined( 'DGC_GSC_SITE_URL' ) ) return false;
	if ( ! file_exists( DGC_GSC_KEY_PATH ) ) return false;
	return true;
}

function dgc_gsc_access_token( $scope = 'https://www.googleapis.com/auth/webmasters' ) {
	$cache_key = 'dgc_gsc_token_' . md5( $scope );
	$cached    = get_transient( $cache_key );
	if ( $cached ) return $cached;

	$key = json_decode( file_get_contents( DGC_GSC_KEY_PATH ), true );
	if ( empty( $key['private_key'] ) || empty( $key['client_email'] ) ) return false;

	$now    = time();
	$header = rtrim( strtr( base64_encode( wp_json_encode( array( 'alg' => 'RS256', 'typ' => 'JWT' ) ) ), '+/', '-_' ), '=' );
	$claim  = rtrim( strtr( base64_encode( wp_json_encode( array(
		'iss'   => $key['client_email'],
		'scope' => $scope,
		'aud'   => 'https://oauth2.googleapis.com/token',
		'iat'   => $now,
		'exp'   => $now + 3600,
	) ) ), '+/', '-_' ), '=' );

	$unsigned  = $header . '.' . $claim;
	$signature = '';
	if ( ! openssl_sign( $unsigned, $signature, $key['private_key'], 'sha256WithRSAEncryption' ) ) return false;
	$jwt = $unsigned . '.' . rtrim( strtr( base64_encode( $signature ), '+/', '-_' ), '=' );

	$resp = wp_remote_post( 'https://oauth2.googleapis.com/token', array(
		'timeout' => 15,
		'body'    => array(
			'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
			'assertion'  => $jwt,
		),
	) );
	if ( is_wp_error( $resp ) ) {
		error_log( 'DGC GSC token loi: ' . $resp->get_error_message() );
		return false;
	}
	$body = json_decode( wp_remote_retrieve_body( $resp ), true );
	if ( empty( $body['access_token'] ) ) {
		error_log( 'DGC GSC token loi: ' . wp_remote_retrieve_body( $resp ) );
		return false;
	}
	set_transient( $cache_key, $body['access_token'], (int) ( $body['expires_in'] ?? 3300 ) - 60 );
	return $body['access_token'];
}

function dgc_gsc_submit_sitemap() {
	$token = dgc_gsc_access_token( 'https://www.googleapis.com/auth/webmasters' );
	if ( ! $token ) return false;

	$site         = rawurlencode( DGC_GSC_SITE_URL );
	$sitemap_path = defined( 'DGC_GSC_SITEMAP' ) ? DGC_GSC_SITEMAP : 'wp-sitemap.xml';
	$sitemap      = rawurlencode( trailingslashit( DGC_GSC_SITE_URL ) . $sitemap_path );
	$url          = "https://www.googleapis.com/webmasters/v3/sites/{$site}/sitemaps/{$sitemap}";

	$resp = wp_remote_request( $url, array(
		'method'  => 'PUT',
		'timeout' => 15,
		'body'    => '',
		'headers' => array(
			'Authorization'  => 'Bearer ' . $token,
			'Content-Length' => '0',
		),
	) );

	$ok = ! is_wp_error( $resp ) && in_array( wp_remote_retrieve_response_code( $resp ), array( 200, 204 ), true );
	update_option( 'dgc_gsc_last_result', array(
		'time'    => current_time( 'mysql' ),
		'success' => $ok,
		'detail'  => $ok ? 'OK' : ( is_wp_error( $resp ) ? $resp->get_error_message() : wp_remote_retrieve_body( $resp ) ),
	), false );
	if ( ! $ok ) error_log( 'DGC GSC submit loi: ' . ( is_wp_error( $resp ) ? $resp->get_error_message() : wp_remote_retrieve_body( $resp ) ) );
	return $ok;
}

/**
 * Ep Google index nhanh 1 URL cu the qua Indexing API. Tra ve array( 'success' => bool, 'detail' => string ).
 */
function dgc_gsc_request_indexing( $url, $type = 'URL_UPDATED' ) {
	if ( ! dgc_gsc_enabled() ) return array( 'success' => false, 'detail' => 'GSC chua bat / thieu cau hinh' );

	$token = dgc_gsc_access_token( 'https://www.googleapis.com/auth/indexing' );
	if ( ! $token ) return array( 'success' => false, 'detail' => 'Khong lay duoc access token' );

	$resp = wp_remote_post( 'https://indexing.googleapis.com/v3/urlNotifications:publish', array(
		'timeout' => 15,
		'headers' => array(
			'Authorization' => 'Bearer ' . $token,
			'Content-Type'  => 'application/json',
		),
		'body' => wp_json_encode( array( 'url' => $url, 'type' => $type ) ),
	) );

	$ok     = ! is_wp_error( $resp ) && wp_remote_retrieve_response_code( $resp ) === 200;
	$detail = $ok ? 'OK' : ( is_wp_error( $resp ) ? $resp->get_error_message() : wp_remote_retrieve_body( $resp ) );
	if ( ! $ok ) error_log( 'DGC GSC indexing loi (' . $url . '): ' . $detail );

	$result = array( 'url' => $url, 'time' => current_time( 'mysql' ), 'success' => $ok, 'detail' => $detail );
	$log    = get_option( 'dgc_gsc_index_log', array() );
	array_unshift( $log, $result );
	update_option( 'dgc_gsc_index_log', array_slice( $log, 0, 20 ), false );

	return array( 'success' => $ok, 'detail' => $detail );
}

/** Goi indexing cho nhieu URL cung luc (cum bai). Tra ve mang [url => result]. */
function dgc_gsc_index_urls( array $urls ) {
	$results = array();
	foreach ( $urls as $url ) {
		$results[ $url ] = dgc_gsc_request_indexing( $url );
	}
	return $results;
}

/** Goi indexing cho toan bo bai PUBLISH trong 1 category (cum chu de theo slug). */
function dgc_gsc_index_category( $slug ) {
	$ids = get_posts( array(
		'category_name'  => $slug,
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'fields'         => 'ids',
	) );
	if ( ! $ids ) return array();
	return dgc_gsc_index_urls( array_map( 'get_permalink', $ids ) );
}

add_action( 'dgc_gsc_do_submit', 'dgc_gsc_submit_sitemap' );
add_action( 'dgc_gsc_do_index', 'dgc_gsc_request_indexing' );

add_action( 'transition_post_status', function ( $new_status, $old_status, $post ) {
	if ( $new_status !== 'publish' || $old_status === 'publish' ) return;
	if ( ! in_array( $post->post_type, array( 'post', 'page', 'dgc_case' ), true ) ) return;
	if ( ! dgc_gsc_enabled() ) return;

	// Sitemap: publish hang loat chi bao Google 1 lan / 5 phut, khong spam API.
	if ( ! get_transient( 'dgc_gsc_lock' ) ) {
		set_transient( 'dgc_gsc_lock', 1, 5 * MINUTE_IN_SECONDS );
		if ( ! wp_next_scheduled( 'dgc_gsc_do_submit' ) ) {
			wp_schedule_single_event( time() + 10, 'dgc_gsc_do_submit' );
		}
	}

	// Indexing rieng dung URL bai nay - khong rate-limit chung, moi bai 1 request.
	$permalink = get_permalink( $post );
	if ( $permalink && ! wp_next_scheduled( 'dgc_gsc_do_index', array( $permalink ) ) ) {
		wp_schedule_single_event( time() + 15, 'dgc_gsc_do_index', array( $permalink ) );
	}
}, 10, 3 );
