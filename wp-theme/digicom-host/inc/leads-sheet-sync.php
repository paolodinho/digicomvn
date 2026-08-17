<?php
/**
 * Day khach dang ky (dgc_lead) sang Google Sheet, song song voi email da co
 * (functions.php: dgc_handle_lead()). Dung LAI service account + JWT helper
 * cua inc/gsc-sitemap-submit.php (dgc_gsc_access_token, tham so hoa theo scope)
 * - khong can them file key/credential moi.
 *
 * Can 1 constant them trong wp-config.php (ngoai 2 constant GSC da co san):
 *   define('DGC_GSC_KEY_PATH', ...);      // da co san, dung chung
 * Sheet ID + bat/tat cau hinh o WP Admin > DigicomVN > muc 10 (option leads_sheet_id, leads_sheet_on).
 * Sheet phai duoc share quyen Editor cho dung email service account (client_email trong file key).
 */

function dgc_leads_sheet_enabled() {
	if ( ! defined( 'DGC_GSC_KEY_PATH' ) || ! file_exists( DGC_GSC_KEY_PATH ) ) return false;
	if ( ! function_exists( 'dgc_gsc_access_token' ) ) return false;
	$o = wp_parse_args( get_option( 'dgc_settings', array() ), dgc_defaults() );
	if ( empty( $o['leads_sheet_on'] ) || $o['leads_sheet_on'] !== '1' ) return false;
	if ( empty( $o['leads_sheet_id'] ) ) return false;
	return true;
}

/** Ghi 1 dong vao Sheet (values:append, tu dong noi cuoi bang). Tra ve true/false. */
function dgc_leads_sheet_append( $row ) {
	if ( ! dgc_leads_sheet_enabled() ) return false;

	$o     = wp_parse_args( get_option( 'dgc_settings', array() ), dgc_defaults() );
	$token = dgc_gsc_access_token( 'https://www.googleapis.com/auth/spreadsheets' );
	if ( ! $token ) return false;

	$sheet_id = rawurlencode( trim( $o['leads_sheet_id'] ) );
	$url      = "https://sheets.googleapis.com/v4/spreadsheets/{$sheet_id}/values/A:F:append?valueInputOption=USER_ENTERED&insertDataOption=INSERT_ROWS";

	$resp = wp_remote_post( $url, array(
		'timeout' => 15,
		'headers' => array(
			'Authorization' => 'Bearer ' . $token,
			'Content-Type'  => 'application/json',
		),
		'body' => wp_json_encode( array( 'values' => array( array_values( $row ) ) ) ),
	) );

	$ok = ! is_wp_error( $resp ) && wp_remote_retrieve_response_code( $resp ) === 200;
	if ( ! $ok ) {
		error_log( 'DGC leads-sheet append loi: ' . ( is_wp_error( $resp ) ? $resp->get_error_message() : wp_remote_retrieve_body( $resp ) ) );
	}
	return $ok;
}

/** Dam bao dong tieu de ton tai (chi goi khi bang con rong - kiem qua values:get truoc). */
function dgc_leads_sheet_ensure_header() {
	if ( ! dgc_leads_sheet_enabled() ) return;
	$o        = wp_parse_args( get_option( 'dgc_settings', array() ), dgc_defaults() );
	$token    = dgc_gsc_access_token( 'https://www.googleapis.com/auth/spreadsheets' );
	if ( ! $token ) return;
	$sheet_id = rawurlencode( trim( $o['leads_sheet_id'] ) );

	$check = wp_remote_get( "https://sheets.googleapis.com/v4/spreadsheets/{$sheet_id}/values/A1:F1", array(
		'timeout' => 15,
		'headers' => array( 'Authorization' => 'Bearer ' . $token ),
	) );
	if ( is_wp_error( $check ) ) return;
	$body = json_decode( wp_remote_retrieve_body( $check ), true );
	if ( ! empty( $body['values'] ) ) return; // da co du lieu/tieu de, khong ghi de

	dgc_leads_sheet_append( array( 'Thoi gian', 'Ho ten', 'Dien thoai', 'Email', 'Dich vu', 'Noi dung' ) );
}

/** Chay ngam (khong chan redirect form) - hook boi dgc_handle_lead() qua wp_schedule_single_event. */
add_action( 'dgc_leads_sheet_do_push', function ( $name, $phone, $email, $svc, $msg, $time ) {
	if ( ! dgc_leads_sheet_enabled() ) return;
	dgc_leads_sheet_ensure_header();
	dgc_leads_sheet_append( array( $time, $name, $phone, $email, $svc, $msg ) );
}, 10, 6 );
