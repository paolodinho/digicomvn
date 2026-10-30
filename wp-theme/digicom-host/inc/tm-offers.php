<?php
/**
 * Uu dai ten mien + tu dong dong bo gia (2026-10-29, Hieu chot "gia bang gia ban le cua nha cung cap, ap du qua tang").
 *  - tm_uu_dai: moi dong "duoi | qua tang 1; qua tang 2; ..." (WP Admin > DigicomVN muc 11).
 *  - tm_combo : 1 dong "duoi1, duoi2, duoi3 | gia nam dau ca bo | nhan". Khach them ca bo cung ten -> gia combo nam dau.
 *  - So nam toi thieu de huong gia nam dau: doc tu cot "luu y" cua ten_mien_gia, mau "tu 3 nam".
 *    Dang ky it hon so nam do -> nam dau tinh theo gia goc (giong cach ban le).
 *  - Dong bo gia: WP-Cron 6 gio/lan doc bang gia ban le cong khai, chi cap nhat gia cac duoi DA CO trong ten_mien_gia.
 *    Nguon bang gia dat trong wp-config: define('DGC_TM_SYNC_URL','...'); (khong ghi ten nha cung cap trong ma/giao dien).
 *    Doc loi / qua it dong -> giu nguyen gia cu. Ban truoc luu option dgc_tm_gia_bak de khoi phuc.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function dgc_tm_default_gifts() {
	$g = 'Tặng gói email theo tên miền 1 năm, trị giá 348k; Tặng tên miền .cloud cùng tên năm đầu, trị giá 719k; Tặng gói bảo mật tên miền (ẩn thông tin, DNSSEC), trị giá 100k';
	return ".vn | $g\n.com | $g";
}

/** duoi => mang qua tang. */
function dgc_tm_gifts_map() {
	/* Hieu 31/10 (khong ban lo): bo qua tang mac dinh (email, .cloud, bao mat) vi dai ly khong tang kem, Digicom phai tu tra.
	   Chi hien qua ghi tay o WP Admin (tm_uu_dai) khi da tinh vao gia. */
	$raw = trim( (string) dgc( 'tm_uu_dai' ) );
	if ( '0' === $raw ) $raw = '';
	$m = array();
	foreach ( preg_split( '/\r\n|\r|\n/', $raw ) as $line ) {
		$p = array_map( 'trim', explode( '|', $line, 2 ) );
		if ( empty( $p[0] ) || empty( $p[1] ) ) continue;
		$m[ '.' . ltrim( strtolower( $p[0] ), '.' ) ] = array_values( array_filter( array_map( 'trim', explode( ';', $p[1] ) ) ) );
	}
	return $m;
}

/** Bo combo: array( tlds => [...], price => so, label => chuoi ) hoac false. */
function dgc_tm_combo() {
	$raw = trim( (string) dgc( 'tm_combo' ) );
	if ( '' === $raw ) $raw = '.xyz, .site, .click | 30000 | Kết hợp 3 đuôi, tiết kiệm';
	if ( '0' === $raw ) return false;
	$p = array_map( 'trim', explode( '|', $raw ) );
	$t = array();
	foreach ( preg_split( '/[\s,]+/', $p[0] ) as $x ) { $x = strtolower( trim( $x ) ); if ( $x ) $t[] = '.' . ltrim( $x, '.' ); }
	$price = (int) preg_replace( '/\D/', '', $p[1] ?? '' );
	if ( count( $t ) < 2 || ! $price ) return false;
	/* Hieu 31/10: combo chi chay khi gia ca bo >= tong von dang ky x 1,1, thieu von 1 duoi -> tat. */
	$von = 0;
	foreach ( $t as $x ) { $v = function_exists( 'dgc_tm_reg_cost' ) ? dgc_tm_reg_cost( $x ) : 0; if ( ! $v ) return false; $von += $v; }
	if ( $price < $von * 1.1 ) return false;
	return array( 'tlds' => array_values( array_unique( $t ) ), 'price' => $price, 'label' => $p[2] ?? 'Kết hợp và tiết kiệm' );
}

/** So nam toi thieu de huong gia nam dau (doc "tu N nam" trong cot luu y). */
function dgc_tm_min_years( $row ) {
	return preg_match( '/từ\s*0*(\d)\s*năm/u', (string) ( $row['note'] ?? '' ), $m ) ? max( 1, (int) $m[1] ) : 1;
}

/* ---------- Dong bo gia ---------- */

/** Doc bang gia ban le -> duoi => array(gia, goc, han, min). */
function dgc_tm_parse_retail( $html ) {
	$t = html_entity_decode( preg_replace( '/<[^>]+>/', '|', $html ), ENT_QUOTES, 'UTF-8' );
	$t = preg_replace( '/\s*\|[\s|]*/u', '|', $t );
	$tok = explode( '|', $t );
	$num = function ( $s ) { return (int) preg_replace( '/\D/', '', $s ); };
	$isTld = function ( $s ) { return (bool) preg_match( '/^\.[a-z]{2,}(\.[a-z]{2,})?$/', $s ); };
	$out = array();
	$n = count( $tok );
	$iVN = array_search( 'BẢNG GIÁ TÊN MIỀN VIỆT NAM', $tok, true );
	$iQT = false;
	for ( $i = 0; $i < $n; $i++ ) { if ( 0 === stripos( $tok[ $i ], 'Bảng giá tên miền Quốc tế' ) && ( $tok[ $i + 1 ] ?? '' ) === 'Đăng ký' ) { $iQT = $i; break; } }
	if ( false === $iVN || false === $iQT ) return array();
	/* Ten mien Viet Nam: nhom duoi -> "Giam ..." -> goc, gia -> 2 dong "Tong:" (nam dau, gia han da gom VAT). */
	$pend = array();
	for ( $i = $iVN; $i < $iQT; $i++ ) {
		$s = $tok[ $i ];
		if ( $isTld( $s ) ) { $pend[] = $s; continue; }
		if ( 0 === strpos( $s, 'Giảm' ) && $pend ) {
			$goc = $num( $tok[ $i + 1 ] ?? '' ); $gia = $num( $tok[ $i + 2 ] ?? '' ); $tong = array();
			for ( $j = $i + 3; $j < $iQT && count( $tong ) < 2; $j++ ) { if ( 'Tổng:' === $tok[ $j ] ) $tong[] = $num( $tok[ $j + 1 ] ?? '' ); }
			if ( $gia && 2 === count( $tong ) ) foreach ( $pend as $d ) $out[ $d ] = array( 'gia' => $tong[0], 'goc' => max( $goc, $tong[0] ), 'han' => $tong[1], 'min' => 1 );
			$pend = array(); $i = $j - 1;
		}
	}
	/* Quoc te: duoi -> [goc] gia [ghi chu "tu N nam"] gia_han chuyen_ve. */
	$cur = ''; $nums = array(); $min = 1;
	$flush = function () use ( &$cur, &$nums, &$min, &$out ) {
		if ( $cur && count( $nums ) >= 3 && ! isset( $out[ $cur ] ) ) {
			if ( count( $nums ) >= 4 ) $out[ $cur ] = array( 'goc' => $nums[0], 'gia' => $nums[1], 'han' => $nums[2], 'min' => $min );
			else $out[ $cur ] = array( 'goc' => $nums[0], 'gia' => $nums[0], 'han' => $nums[1], 'min' => 1 );
		}
		$cur = ''; $nums = array(); $min = 1;
	};
	for ( $i = $iQT + 1; $i < $n; $i++ ) {
		$s = $tok[ $i ];
		if ( $isTld( $s ) ) { $flush(); $cur = $s; continue; }
		if ( ! $cur ) continue;
		if ( preg_match( '/^\d{1,3}(\.\d{3})+đ?$/u', $s ) ) $nums[] = $num( $s );
		elseif ( preg_match( '/từ\s*0*(\d)\s*năm/u', $s, $m ) ) $min = (int) $m[1];
	}
	$flush();
	return $out;
}

function dgc_tm_sync_prices( $force = false ) {
	$url = defined( 'DGC_TM_SYNC_URL' ) ? DGC_TM_SYNC_URL : '';
	$log = array( 'time' => current_time( 'mysql' ), 'ok' => 0, 'msg' => '' );
	if ( ! $url ) { $log['msg'] = 'Chưa khai báo nguồn bảng giá (DGC_TM_SYNC_URL trong wp-config).'; update_option( 'dgc_tm_sync_last', $log, false ); return $log; }
	$r = wp_remote_get( $url, array( 'timeout' => 30, 'user-agent' => 'Mozilla/5.0' ) );
	if ( is_wp_error( $r ) || 200 !== wp_remote_retrieve_response_code( $r ) ) { $log['msg'] = 'Không tải được bảng giá.'; update_option( 'dgc_tm_sync_last', $log, false ); return $log; }
	$src = dgc_tm_parse_retail( wp_remote_retrieve_body( $r ) );
	if ( count( $src ) < 20 || empty( $src['.com'] ) || empty( $src['.vn'] ) ) { $log['msg'] = 'Đọc được quá ít dòng (' . count( $src ) . '), giữ nguyên giá cũ.'; update_option( 'dgc_tm_sync_last', $log, false ); return $log; }

	$opt   = get_option( 'dgc_settings', array() );
	$lines = preg_split( '/\r\n|\r|\n/', (string) ( $opt['ten_mien_gia'] ?? '' ) );
	$chg   = array(); $new = array();
	foreach ( $lines as $line ) {
		$p = array_map( 'trim', explode( '|', $line ) );
		$d = strtolower( $p[0] ?? '' );
		if ( '' === trim( $line ) || ! isset( $src[ $d ] ) ) { $new[] = $line; continue; }
		$s = $src[ $d ];
		$p = array_pad( $p, 6, '' );
		$old = array( (int) $p[2], (int) $p[3], (int) $p[4] );
		/* Chan so bat thuong: gia moi lech qua 5 lan so voi gia cu -> bo qua dong nay. */
		if ( $old[0] && ( $s['gia'] > $old[0] * 5 || $s['gia'] * 5 < $old[0] ) ) { $new[] = $line; continue; }
		$p[2] = $s['gia']; $p[3] = $s['goc'] > $s['gia'] ? $s['goc'] : ''; $p[4] = $s['han'];
		$note = trim( preg_replace( '/Giá năm đầu áp dụng khi đăng ký từ \d+ năm\.?/u', '', $p[5] ) );
		if ( $s['min'] > 1 ) $note = trim( 'Giá năm đầu áp dụng khi đăng ký từ ' . $s['min'] . ' năm. ' . $note );
		$p[5] = $note;
		if ( array( (int) $p[2], (int) $p[3], (int) $p[4] ) !== $old ) $chg[] = $d . ': ' . implode( '/', $old ) . ' -> ' . $p[2] . '/' . (int) $p[3] . '/' . $p[4];
		$new[] = implode( ' | ', array_slice( $p, 0, 6 ) );
	}
	$txt = implode( "\n", $new );
	if ( $txt !== ( $opt['ten_mien_gia'] ?? '' ) ) {
		update_option( 'dgc_tm_gia_bak', array( 'time' => current_time( 'mysql' ), 'val' => $opt['ten_mien_gia'] ?? '' ), false );
		$opt['ten_mien_gia'] = $txt;
		update_option( 'dgc_settings', $opt );
		if ( function_exists( 'litespeed_purge_url' ) ) do_action( 'litespeed_purge_all' );
	}
	$log['ok']  = 1;
	$log['msg'] = $chg ? 'Đổi giá ' . count( $chg ) . ' đuôi: ' . implode( '; ', $chg ) : 'Giá không đổi (' . count( $src ) . ' đuôi đã đối chiếu).';
	update_option( 'dgc_tm_sync_last', $log, false );
	if ( $chg ) wp_mail( dgc( 'lead_email', get_option( 'admin_email' ) ), '[DigicomVN] Giá tên miền vừa cập nhật', $log['msg'] . "\n\nBản trước lưu ở option dgc_tm_gia_bak." );
	return $log;
}
add_action( 'dgc_tm_sync_daily', 'dgc_tm_sync_prices' );
// 6 gio/lan (Hieu 29/10): ten hook giu nguyen de khong vo cac noi goi; lich cu 'daily' tu doi sang 'dgc_6h'.
add_filter( 'cron_schedules', function ( $s ) {
	$s['dgc_6h'] = array( 'interval' => 6 * HOUR_IN_SECONDS, 'display' => '6 giờ/lần' );
	return $s;
} );
add_action( 'init', function () {
	if ( 'dgc_6h' !== wp_get_schedule( 'dgc_tm_sync_daily' ) ) {
		wp_clear_scheduled_hook( 'dgc_tm_sync_daily' );
		wp_schedule_event( time() + 10 * MINUTE_IN_SECONDS, 'dgc_6h', 'dgc_tm_sync_daily' );
	}
} );
add_action( 'admin_post_dgc_tm_sync', function () {
	if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Không có quyền.' );
	check_admin_referer( 'dgc_tm_sync' );
	dgc_tm_sync_prices( true );
	wp_safe_redirect( wp_get_referer() ?: admin_url() );
	exit;
} );
