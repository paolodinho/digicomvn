<?php
/**
 * Mua hosting truc tuyen (2026-10-29, Hieu chot "giong ben ten mien").
 * Luong: trang /hosting/ nut "Mua ngay" -> them vao gio chung (localStorage dgc_tm_cart, item {t:'h',k,m,d})
 * -> /thanh-toan-ten-mien/ (nhap ten mien dung cho hosting) -> don dgc_don_tm -> QR -> SePay
 * -> dgc_tm_register_order() goi dgc_tm_pa_register_hosting() (lenh register_hosting cua dai ly).
 *
 * GIA = gia ban le (hosting_gia, dong bo hang ngay). Hieu 30/10: ban moi ky han co ma goi dai ly (hosting_list,
 * cache 12 gio), KE CA ky han gia ban le thap hon gia von dai ly (chap nhan lo theo gia thi truong).
 * KHONG hien ten nha cung cap o bat ky dau (rule dich-vu.md).
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/** Gia von dai ly: khoa goi (dgc_hg_key) => so thang => array(id goi, gia von). */
function dgc_hg_cost_list( $force = false ) {
	$c = $force ? false : get_transient( 'dgc_hg_cost' );
	if ( is_array( $c ) ) return $c;
	$last = get_option( 'dgc_hg_cost_last', array() );
	if ( ! defined( 'DGC_PA_URL' ) || ! defined( 'DGC_PA_USER' ) || ! defined( 'DGC_PA_KEY' ) ) return is_array( $last ) ? $last : array();
	$r = wp_remote_get( DGC_PA_URL . '?' . http_build_query( array( 'username' => DGC_PA_USER, 'apikey' => DGC_PA_KEY, 'cmd' => 'hosting_list', 'flag' => 1, 'responsetype' => 'json' ) ), array( 'timeout' => 25 ) );
	$j = is_wp_error( $r ) ? null : json_decode( trim( wp_remote_retrieve_body( $r ) ), true );
	$out = array();
	foreach ( (array) ( $j['ReturnText'] ?? array() ) as $p ) {
		if ( ! is_array( $p ) || empty( $p['id'] ) || ! preg_match( '/([\d.]+)\s*đ\/\s*(\d+)\s*tháng/u', (string) ( $p['price_linux'] ?? '' ), $m ) ) continue;
		$out[ dgc_hg_key( (string) $p['name'] ) ][ (int) $m[2] ] = array( (int) $p['id'], (int) str_replace( '.', '', $m[1] ) );
	}
	if ( count( $out ) < 10 ) { set_transient( 'dgc_hg_cost', is_array( $last ) ? $last : array(), 30 * MINUTE_IN_SECONDS ); return is_array( $last ) ? $last : array(); }
	set_transient( 'dgc_hg_cost', $out, 12 * HOUR_IN_SECONDS );
	update_option( 'dgc_hg_cost_last', $out, false );
	return $out;
}

/**
 * Goi mua duoc online: khoa => array(n ten goi, g nhom, p => array(so thang => gia ban), l => array(so thang => gia goc), id => array(so thang => id goi)).
 * Ky han: 12 thang (cot "Dang ky 1 nam") va ky N nam (gia/thang x 12 x N). Moi ky han co ma goi dai ly deu ban.
 */
function dgc_hg_online() {
	static $out = null;
	if ( null !== $out ) return $out;
	$out  = array();
	$cost = dgc_hg_cost_list();
	if ( ! $cost ) return $out;
	foreach ( dgc_hosting_rows() as $g => $rows ) {
		foreach ( $rows as $r ) {
			$k = dgc_hg_key( $r['goi'] );
			if ( empty( $cost[ $k ] ) ) continue;
			$opt = array();
			if ( dgc_tm_num( $r['nam'] ) ) $opt[12] = array( dgc_tm_num( $r['nam'] ), max( dgc_tm_num( $r['nam'] ), dgc_tm_num( $r['goc'] ) * 12 ) );
			$ky = (int) $r['ky'];
			if ( $ky >= 1 && dgc_tm_num( $r['thang'] ) ) $opt[ $ky * 12 ] = array( dgc_tm_num( $r['thang'] ) * 12 * $ky, max( dgc_tm_num( $r['thang'] ), dgc_tm_num( $r['goc'] ) ) * 12 * $ky );
			$p = $l = $id = array();
			foreach ( $opt as $mo => $v ) {
				if ( empty( $cost[ $k ][ $mo ] ) ) continue; // Hieu 30/10: ban bang gia ban le, ke ca ky han gia ban < gia von dai ly
				$p[ $mo ] = $v[0]; $l[ $mo ] = $v[1]; $id[ $mo ] = $cost[ $k ][ $mo ][0];
			}
			if ( $p ) { ksort( $p ); ksort( $l ); $out[ $k ] = array( 'n' => $r['goi'], 'g' => $g, 'p' => $p, 'l' => $l, 'id' => $id ); }
		}
	}
	return $out;
}

/** Ban cho trinh duyet (khong co id goi, khong co gia von). */
function dgc_hg_online_public() {
	$o = array();
	foreach ( dgc_hg_online() as $k => $v ) $o[ $k ] = array( 'n' => $v['n'], 'p' => $v['p'], 'l' => $v['l'] );
	return $o;
}

/** 1 dong hosting trong don. Tra ve false neu goi/ky han khong ban online. */
function dgc_hg_quote( $key, $months, $domain ) {
	$all = dgc_hg_online();
	$key = dgc_hg_key( (string) $key );
	$mo  = (int) $months;
	if ( empty( $all[ $key ]['p'][ $mo ] ) ) return false;
	$v = $all[ $key ];
	return array( 't' => 'h', 'd' => $domain, 'k' => $key, 'n' => $v['n'], 'm' => $mo, 'y' => (int) ceil( $mo / 12 ), 'pid' => $v['id'][ $mo ], 'amount' => $v['p'][ $mo ], 'list' => $v['l'][ $mo ], 'gifts' => array(), 'combo' => 0 );
}

/** Mat khau 12 ky tu co hoa, thuong, so (yeu cau cua lenh register_hosting: 8-16 ky tu). */
function dgc_hg_password() {
	$u = 'ABCDEFGHJKLMNPQRSTUVWXYZ'; $l = 'abcdefghijkmnpqrstuvwxyz'; $d = '23456789';
	$p = array( $u[ wp_rand( 0, 23 ) ], $u[ wp_rand( 0, 23 ) ], $l[ wp_rand( 0, 23 ) ], $l[ wp_rand( 0, 23 ) ], $d[ wp_rand( 0, 7 ) ], $d[ wp_rand( 0, 7 ) ] );
	$all = $u . $l . $d;
	while ( count( $p ) < 12 ) $p[] = $all[ wp_rand( 0, strlen( $all ) - 1 ) ];
	shuffle( $p );
	return implode( '', $p );
}

/**
 * Dang ky 1 hosting qua API dai ly. Tra ve true hoac chuoi loi.
 * DGC_PA_TEST = true -> cong chay thu (khong tru tien, ma 900 = thanh cong gia lap).
 */
function dgc_tm_pa_register_hosting( $l, $o ) {
	if ( ! defined( 'DGC_PA_URL' ) || ! defined( 'DGC_PA_USER' ) || ! defined( 'DGC_PA_KEY' ) ) return 'thiếu cấu hình API';
	$test = defined( 'DGC_PA_TEST' ) && DGC_PA_TEST;
	$url  = $test ? str_replace( 'interface.php', 'interface_test.php', DGC_PA_URL ) : DGC_PA_URL;
	$org  = 'org' === ( $o['type'] ?? '' );
	$pw   = dgc_hg_password();
	$ph   = preg_replace( '/\D/', '', (string) ( $o['phone'] ?? '' ) );
	if ( 0 === strpos( $ph, '84' ) ) $ph = '0' . substr( $ph, 2 );
	$q = array(
		'username' => DGC_PA_USER, 'apikey' => DGC_PA_KEY, 'cmd' => 'register_hosting',
		'hosting' => (int) $l['pid'], 'os' => 1, 'domain' => $l['d'], 'amount' => 1, 'pwd' => $pw,
		'ownerType' => $org ? 2 : 1, 'ownerName' => $o['name'] ?? '', 'ownerEmail1' => $o['email'] ?? '', 'ownerPhone' => $ph,
		'uiName' => $o['name'] ?? '', 'uiEmail' => $o['email'] ?? '', 'uiPhone' => $ph,
		'sendmail' => 1, 'responsetype' => 'json',
	);
	foreach ( array( 'Address' => $o['addr'] ?? '', 'Ward' => $o['ward'] ?? '', 'District' => $o['ward'] ?? '', 'Province' => $o['city'] ?? '', 'Country' => 'Viet Nam' ) as $k => $v ) { $q[ 'owner' . $k ] = $v; $q[ 'ui' . $k ] = $v; } // dia gioi moi khong con quan/huyen, API van bat buoc -> dien ten phuong
	if ( $org ) { $q['ownerTaxCode'] = $o['idno'] ?? ''; $q['uiTaxCode'] = $o['idno'] ?? ''; }
	else { $q['ownerID_Number'] = $o['idno'] ?? ''; $q['uiID_Number'] = $o['idno'] ?? ''; }

	$c = curl_init( $url . '?' . http_build_query( $q ) );
	curl_setopt_array( $c, array( CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => '', CURLOPT_TIMEOUT => 60, CURLOPT_CONNECTTIMEOUT => 10 ) );
	$body = (string) curl_exec( $c ); $http = (int) curl_getinfo( $c, CURLINFO_HTTP_CODE ); curl_close( $c );
	$r = json_decode( trim( $body ), true );
	if ( ! is_array( $r ) ) return 'không nhận được phản hồi (HTTP ' . $http . '), kiểm tra trên trang đại lý trước khi thử lại';
	$code = (int) ( $r['ReturnCode'] ?? 0 );
	if ( 200 === $code || ( $test && 900 === $code ) ) {
		$id = (int) ( $GLOBALS['dgc_tm_reg_order'] ?? 0 );
		if ( $id ) {
			$info = get_post_meta( $id, '_tm_reg_info', true ) ?: array();
			$info[ 'hosting ' . $l['d'] ] = array( 'pw' => $pw, 'host' => 1, 'plan' => $l['n'], 'test' => $test ? 1 : 0, 'trans' => $r['trans_id'] ?? '', 'money' => $r['trans_money'] ?? '', 'note' => $r['trans_note'] ?? '', 'time' => current_time( 'mysql' ) );
			update_post_meta( $id, '_tm_reg_info', $info );
		}
		return true;
	}
	$msg = array( 203 => 'thiếu thông tin chủ thể', 208 => 'email không đúng', 309 => 'số điện thoại không hợp lệ', 400 => 'tài khoản đại lý không đủ tiền, cần nạp thêm', 501 => 'IP máy chủ chưa được phép gọi API', 505 => 'không tạo được hồ sơ khách hàng (kiểm tra tỉnh, phường)', 3055 => 'mã gói hosting không còn, cần cập nhật bảng giá' );
	return 'mã ' . $code . ': ' . ( $msg[ $code ] ?? sanitize_text_field( (string) ( $r['ReturnText'] ?? '' ) ) );
}

/** Khoi thong tin dang nhap gui khach sau khi dang ky xong. */
function dgc_hg_login_text( $id ) {
	$info = get_post_meta( $id, '_tm_reg_info', true ) ?: array();
	$out  = '';
	foreach ( $info as $k => $ri ) {
		if ( empty( $ri['host'] ) ) continue;
		$d = substr( $k, 8 );
		$out .= "\nHOSTING " . ( $ri['plan'] ?? '' ) . ' - ' . $d . "\n"
			. '- Trang quản trị cPanel: https://' . $d . ":2083 (dùng được sau khi tên miền trỏ về hosting; trước đó dùng đường dẫn trong email kích hoạt hosting gửi riêng)\n"
			. "- Tên đăng nhập cPanel: xem email kích hoạt hosting gửi riêng\n"
			. '- Mật khẩu: ' . ( $ri['pw'] ?? '' ) . "\n";
	}
	if ( $out ) {
		$out .= "\nLưu ý bảo mật:\n- Đăng nhập lần đầu xong, đổi mật khẩu trong cPanel (mục Password & Security) và lưu email này ở nơi an toàn.\n"
			. "- Trong cPanel có sẵn: cài WordPress, tạo email theo tên miền, sao lưu, quản lý SSL. Cần DigicomVN cài đặt giúp, trả lời email này.\n";
	}
	foreach ( $info as $k => $ri ) {
		if ( ! empty( $ri['host'] ) || empty( $ri['pw'] ) ) continue;
		$out .= "\nQUẢN LÝ TÊN MIỀN " . $k . "\n- Trang quản lý: quanly.digicomvn.com/dang-nhap\n- Tên đăng nhập: " . $k . "\n- Mật khẩu: " . $ri['pw'] . "\n";
	}
	return $out;
}
