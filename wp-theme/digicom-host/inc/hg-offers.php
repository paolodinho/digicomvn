<?php
/**
 * Uu dai hosting + tu dong dong bo gia hosting (2026-10-29, Hieu: "gia theo gia ban le nhu ten mien").
 *  - hosting_uu_dai: moi dong "tieu de | dieu kien" (WP Admin > DigicomVN muc 11). Ghi 0 de an khoi.
 *  - Dong bo: chay cung cron dgc_tm_sync_daily. Doc trang bang gia ban le (cung may chu voi DGC_TM_SYNC_URL),
 *    chi cap nhat gia/thang, gia goc, ky han cua cac goi DA CO trong hosting_gia (khop theo ten goi).
 *    Khong ghi ten nha cung cap trong giao dien.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function dgc_hg_default_offers() {
	return "Tặng 1 năm tên miền .vn, .com.vn, .net hoặc .com (hoặc chứng chỉ SSL trả phí trị giá 219k) | Đăng ký mới gói Enterprise, Super, WordPress Pro hoặc WordPress Super từ 1 năm\n"
		. "Tặng combo 1 năm tên miền .cloud, .online, .store, .one (trị giá đến 3,4 triệu) | Đăng ký mới gói hosting bất kỳ\n"
		. "Chuyển dữ liệu website cũ sang hosting mới miễn phí (trị giá 949k) | Đăng ký mới hosting, trừ nhóm giá rẻ Unlimited\n"
		. "Hơn 1.000 giao diện WordPress có bản quyền | Đăng ký gói hosting WordPress bất kỳ";
}

/** Mang array( tieu de, dieu kien ). */
function dgc_hg_offers() {
	$raw = trim( (string) dgc( 'hosting_uu_dai' ) );
	if ( '0' === $raw ) return array();
	if ( '' === $raw ) $raw = dgc_hg_default_offers();
	$out = array();
	foreach ( preg_split( '/\r\n|\r|\n/', $raw ) as $line ) {
		$p = array_map( 'trim', explode( '|', $line, 2 ) );
		if ( ! empty( $p[0] ) ) $out[] = array( $p[0], $p[1] ?? '' );
	}
	return $out;
}

/** Ten goi -> khoa so sanh ("WordPress #1" -> "wordpress business 1", "Superhost #2" -> "super 2"). */
function dgc_hg_key( $n ) {
	$n = strtolower( trim( preg_replace( '/[#\s]+/', ' ', $n ) ) );
	$n = preg_replace( '/^superhost /', 'super ', $n );
	if ( preg_match( '/^wordpress (\d)$/', $n, $m ) ) $n = 'wordpress business ' . $m[1];
	return $n;
}

/** Doc 1 trang ban le -> khoa => array(thang, goc, ky). */
function dgc_hg_parse_retail( $html ) {
	$t = preg_replace( '#<(script|style)\b.*?</\1>#is', '', $html );
	$t = html_entity_decode( preg_replace( '/<[^>]+>/', '|', $t ), ENT_QUOTES, 'UTF-8' );
	$t = preg_replace( '/\s*\|[\s|]*/u', '|', $t );
	$out = array();
	preg_match_all( '/\|([^|]{3,30})\|\1\|Giảm \d+%\|([\d.]+)đ\|.*?\|([\d.]+)\|đ\|\/tháng\|.*?với thời hạn (\d+) năm/u', $t, $m, PREG_SET_ORDER );
	foreach ( $m as $x ) {
		$k = dgc_hg_key( $x[1] );
		if ( ! isset( $out[ $k ] ) ) $out[ $k ] = array( 'thang' => (int) str_replace( '.', '', $x[3] ), 'goc' => (int) str_replace( '.', '', $x[2] ), 'ky' => (int) $x[4] );
	}
	return $out;
}

function dgc_hg_sync_prices() {
	$log = array( 'time' => current_time( 'mysql' ), 'ok' => 0, 'msg' => '' );
	$u   = defined( 'DGC_TM_SYNC_URL' ) ? wp_parse_url( DGC_TM_SYNC_URL ) : array();
	if ( empty( $u['host'] ) ) { $log['msg'] = 'Chưa khai báo nguồn bảng giá.'; update_option( 'dgc_hg_sync_last', $log, false ); return $log; }
	$base = ( $u['scheme'] ?? 'https' ) . '://' . $u['host'] . '/vn/hosting/';
	$src  = array();
	foreach ( array( 'unlimited-hosting', 'business-hosting', 'enterprise-hosting', 'super-hosting', 'wordpress', 'wordpress-hosting', 'wordpress-super' ) as $slug ) {
		$r = wp_remote_get( $base . $slug, array( 'timeout' => 25, 'user-agent' => 'Mozilla/5.0' ) );
		if ( ! is_wp_error( $r ) && 200 === wp_remote_retrieve_response_code( $r ) ) $src += dgc_hg_parse_retail( wp_remote_retrieve_body( $r ) );
	}
	if ( count( $src ) < 15 ) { $log['msg'] = 'Đọc được quá ít gói (' . count( $src ) . '), giữ nguyên giá cũ.'; update_option( 'dgc_hg_sync_last', $log, false ); return $log; }

	$opt = get_option( 'dgc_settings', array() );
	$chg = array(); $new = array();
	foreach ( preg_split( '/\r\n|\r|\n/', (string) ( $opt['hosting_gia'] ?? '' ) ) as $line ) {
		$p = array_pad( array_map( 'trim', explode( '|', $line ) ), 9, '' );
		$k = dgc_hg_key( $p[1] );
		if ( '' === trim( $line ) || ! isset( $src[ $k ] ) ) { $new[] = $line; continue; }
		$s   = $src[ $k ];
		$old = array( (int) $p[5], (int) $p[6], (int) $p[7] );
		if ( $old[0] && ( $s['thang'] > $old[0] * 5 || $s['thang'] * 5 < $old[0] ) ) { $new[] = $line; continue; }
		$p[5] = $s['thang']; $p[6] = $s['goc']; $p[7] = $s['ky'];
		if ( array( $s['thang'], $s['goc'], $s['ky'] ) !== $old ) $chg[] = $p[1] . ': ' . implode( '/', $old ) . ' -> ' . $s['thang'] . '/' . $s['goc'] . '/' . $s['ky'];
		$new[] = implode( ' | ', $p );
	}
	if ( $chg ) {
		update_option( 'dgc_hg_gia_bak', array( 'time' => current_time( 'mysql' ), 'val' => $opt['hosting_gia'] ?? '' ), false );
		$opt['hosting_gia'] = implode( "\n", $new );
		update_option( 'dgc_settings', $opt );
		do_action( 'litespeed_purge_all' );
		wp_mail( dgc( 'lead_email', get_option( 'admin_email' ) ), '[DigicomVN] Giá hosting vừa cập nhật', implode( "\n", $chg ) . "\n\nBản trước lưu ở option dgc_hg_gia_bak." );
	}
	$log['ok']  = 1;
	$log['msg'] = $chg ? 'Đổi giá ' . count( $chg ) . ' gói: ' . implode( '; ', $chg ) : 'Giá không đổi (' . count( $src ) . ' gói đã đối chiếu).';
	update_option( 'dgc_hg_sync_last', $log, false );
	return $log;
}
add_action( 'dgc_tm_sync_daily', 'dgc_hg_sync_prices', 20 );
add_action( 'admin_post_dgc_tm_sync', function () {
	if ( current_user_can( 'manage_options' ) && check_admin_referer( 'dgc_tm_sync' ) ) dgc_hg_sync_prices();
}, 5 );
