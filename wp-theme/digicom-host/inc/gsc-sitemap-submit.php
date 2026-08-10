<?php
/**
 * Auto-submit sitemap len Google Search Console khi co bai/trang moi publish.
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

function dgc_gsc_access_token() {
	$cached = get_transient( 'dgc_gsc_token' );
	if ( $cached ) return $cached;

	$key = json_decode( file_get_contents( DGC_GSC_KEY_PATH ), true );
	if ( empty( $key['private_key'] ) || empty( $key['client_email'] ) ) return false;

	$now    = time();
	$header = rtrim( strtr( base64_encode( wp_json_encode( array( 'alg' => 'RS256', 'typ' => 'JWT' ) ) ), '+/', '-_' ), '=' );
	$claim  = rtrim( strtr( base64_encode( wp_json_encode( array(
		'iss'   => $key['client_email'],
		'scope' => 'https://www.googleapis.com/auth/webmasters',
		'aud'   => 'https://oauth2.googleapis.com/token',
		'iat'   => $now,
		'exp'   => $now + 3600,
	) ) ), '+/', '-_' ), '=' );

	$unsigned = $header . '.' . $claim;
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
	set_transient( 'dgc_gsc_token', $body['access_token'], (int) ( $body['expires_in'] ?? 3300 ) - 60 );
	return $body['access_token'];
}

function dgc_gsc_submit_sitemap() {
	$token = dgc_gsc_access_token();
	if ( ! $token ) return false;

	$site    = rawurlencode( DGC_GSC_SITE_URL );
	$sitemap_path = defined( 'DGC_GSC_SITEMAP' ) ? DGC_GSC_SITEMAP : 'wp-sitemap.xml';
	$sitemap = rawurlencode( trailingslashit( DGC_GSC_SITE_URL ) . $sitemap_path );
	$url     = "https://www.googleapis.com/webmasters/v3/sites/{$site}/sitemaps/{$sitemap}";

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

add_action( 'dgc_gsc_do_submit', 'dgc_gsc_submit_sitemap' );

add_action( 'transition_post_status', function ( $new_status, $old_status, $post ) {
	if ( $new_status !== 'publish' || $old_status === 'publish' ) return;
	if ( ! in_array( $post->post_type, array( 'post', 'page', 'dgc_case' ), true ) ) return;
	if ( ! dgc_gsc_enabled() ) return;
	// Rate-limit: publish hang loat chi bao Google 1 lan / 5 phut, khong spam API.
	if ( get_transient( 'dgc_gsc_lock' ) ) return;
	set_transient( 'dgc_gsc_lock', 1, 5 * MINUTE_IN_SECONDS );
	// Chay ngoai request publish de khong lam cham thao tac dang bai.
	if ( ! wp_next_scheduled( 'dgc_gsc_do_submit' ) ) {
		wp_schedule_single_event( time() + 10, 'dgc_gsc_do_submit' );
	}
}, 10, 3 );
