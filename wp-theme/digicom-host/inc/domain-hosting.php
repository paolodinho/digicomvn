<?php
/**
 * Ten mien + Hosting (mo 2026-10-27). Bang gia doc tu 2 option sua duoc o WP Admin > DigicomVN muc 11:
 *  - ten_mien_gia: moi dong "duoi | vn/qt | gia nam dau | gia goc | gia han | ghi chu"
 *  - hosting_gia:  moi dong "nhom | goi | dung luong | so website | cpu/ram | gia thang | gia thang goc | ky han uu dai (nam) | gia 1 nam"
 * KHONG hien ten nha cung cap o bat ky dau (rule dich-vu.md). Khach dat qua form lead.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function dgc_vnd( $n ) {
	$n = (float) preg_replace( '/[^\d]/', '', (string) $n );
	return $n > 0 ? number_format( $n, 0, ',', '.' ) . 'đ' : 'Liên hệ';
}

/** Trang co dang publish khong (link trang chu chi tro toi trang da mo). */
function dgc_page_live( $path ) {
	$p = get_page_by_path( trim( $path, '/' ) );
	return $p && 'publish' === $p->post_status;
}

/** Gia thap nhat (so) trong 1 cot, de hien "tu Xd" o trang chu. */
function dgc_min_price( $rows, $key ) {
	$m = 0;
	foreach ( $rows as $r ) { $v = (float) preg_replace( '/[^\d]/', '', (string) ( $r[ $key ] ?? '' ) ); if ( $v > 0 && ( ! $m || $v < $m ) ) $m = $v; }
	return $m;
}

function dgc_ten_mien_rows( $nhom = '' ) {
	$out = array();
	foreach ( dgc_lines( 'ten_mien_gia' ) as $l ) {
		if ( empty( $l[0] ) ) continue;
		$r = array( 'duoi' => $l[0], 'nhom' => $l[1] ?? '', 'gia' => $l[2] ?? '', 'goc' => $l[3] ?? '', 'han' => $l[4] ?? '', 'note' => $l[5] ?? '' );
		if ( $nhom && $r['nhom'] !== $nhom ) continue;
		$out[] = $r;
	}
	return $out;
}

function dgc_hosting_rows() {
	$out = array();
	foreach ( dgc_lines( 'hosting_gia' ) as $l ) {
		if ( empty( $l[1] ) ) continue;
		$out[ $l[0] ][] = array( 'goi' => $l[1], 'dl' => $l[2] ?? '', 'web' => $l[3] ?? '', 'cpu' => $l[4] ?? '', 'thang' => $l[5] ?? '', 'goc' => $l[6] ?? '', 'ky' => $l[7] ?? '', 'nam' => $l[8] ?? '' );
	}
	return $out;
}

/** Kiem tra ten mien con trong: gTLD qua RDAP cong khai (404 = chua ai dang ky). .vn khong co RDAP cong khai -> kiem tay. */
/**
 * Tra ten mien nhieu duoi 1 lan (2026-10-28).
 * Nguon 1: API whois cua nha cung cap (dai ly) - tra duoc ca .vn. Thong tin truy cap dat trong
 * wp-config.php (KHONG commit): define('DGC_PA_URL','<dia chi interface API>'); define('DGC_PA_USER','...'); define('DGC_PA_KEY','...');
 * IP may chu phai nam trong danh sach IP cho phep o trang quan ly dai ly. API key doi khi doi mat khau.
 * Nguon 2 (du phong): RDAP cho ten mien quoc te. Khong tra duoc -> 'manual' (khach gui yeu cau).
 * Danh sach duoi goi y: option tm_suggest (WP Admin > DigicomVN muc 11), moi duoi cach nhau dau phay.
 */
function dgc_tm_suggest_tlds() {
	$raw = trim( (string) dgc( 'tm_suggest' ) );
	if ( '' === $raw ) $raw = '.vn, .com.vn, .com, .net, .net.vn, .io.vn, .id.vn, .org, .online, .xyz';
	$out = array();
	foreach ( preg_split( '/[\s,|]+/', $raw ) as $t ) { $t = strtolower( trim( $t ) ); if ( $t ) $out[] = '.' . ltrim( $t, '.' ); }
	return array_values( array_unique( $out ) );
}

function dgc_tm_price_map() {
	$m = array();
	foreach ( dgc_ten_mien_rows() as $r ) {
		$k = strtolower( trim( $r['duoi'] ) );
		if ( '.' === substr( $k, 0, 1 ) ) $m[ $k ] = $r;
	}
	return $m;
}

/** Kiem tra nhieu ten mien song song. Tra ve mang domain => free|taken|manual. Cache 10 phut. */
function dgc_tm_check_many( $domains ) {
	$res = array(); $need = array();
	foreach ( $domains as $d ) {
		$c = get_transient( 'dgc_tm_' . md5( $d ) );
		if ( $c ) $res[ $d ] = $c; else $need[] = $d;
	}
	if ( ! $need ) return $res;
	/* API khong phan hoi (vd tuong lua chua mo IP) -> tam bo qua 15 phut de khach khong phai cho. */
	$pa = defined( 'DGC_PA_URL' ) && defined( 'DGC_PA_USER' ) && defined( 'DGC_PA_KEY' ) && DGC_PA_URL && DGC_PA_USER && DGC_PA_KEY && ! get_transient( 'dgc_pa_down' );
	$reqs = array();
	foreach ( $need as $d ) {
		if ( $pa ) {
			$reqs[ $d ] = array( 'url' => DGC_PA_URL . '?' . http_build_query( array( 'username' => DGC_PA_USER, 'apikey' => DGC_PA_KEY, 'cmd' => 'check_whois', 'domain' => $d ) ), 'type' => 'GET' );
		}
	}
	$pa_out = array();
	if ( $reqs && function_exists( 'curl_multi_init' ) ) {
		/* Goi curl truc tiep: API tra body gzip "0", lop giai nen cua WP Requests coi "0" la rong -> mat ket qua. */
		$mh = curl_multi_init(); $hs = array();
		foreach ( $reqs as $d => $q ) {
			$c = curl_init( $q['url'] );
			curl_setopt_array( $c, array( CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => '', CURLOPT_TIMEOUT => 8, CURLOPT_CONNECTTIMEOUT => 5 ) );
			curl_multi_add_handle( $mh, $c ); $hs[ $d ] = $c;
		}
		do { $st = curl_multi_exec( $mh, $run ); if ( $run ) curl_multi_select( $mh, 1 ); } while ( $run && CURLM_OK === $st );
		foreach ( $hs as $d => $c ) {
			$b = trim( (string) curl_multi_getcontent( $c ) );
			if ( 200 === (int) curl_getinfo( $c, CURLINFO_HTTP_CODE ) ) {
				if ( '1' === $b ) $pa_out[ $d ] = 'free';
				elseif ( '0' === $b ) $pa_out[ $d ] = 'taken';
			}
			curl_multi_remove_handle( $mh, $c ); curl_close( $c );
		}
		curl_multi_close( $mh );
		if ( ! $pa_out ) set_transient( 'dgc_pa_down', 1, 15 * MINUTE_IN_SECONDS );
		else delete_transient( 'dgc_pa_down' );
	}
	/* Du phong RDAP (song song, HEAD): mot so may chu RDAP dong ket noi SSL khi tra 404 cho GET. */
	$rd = array();
	foreach ( $need as $d ) {
		if ( isset( $pa_out[ $d ] ) || preg_match( '/\.vn$/', $d ) ) continue;
		$tld = substr( strrchr( $d, '.' ), 1 );
		$rd[ $d ] = array( 'type' => 'HEAD', 'url' => in_array( $tld, array( 'com', 'net' ), true )
			? 'https://rdap.verisign.com/' . $tld . '/v1/domain/' . rawurlencode( $d )
			: 'https://rdap.org/domain/' . rawurlencode( $d ) );
	}
	if ( $rd && class_exists( '\WpOrg\Requests\Requests' ) ) {
		try {
			$rr = \WpOrg\Requests\Requests::request_multiple( $rd, array( 'timeout' => 7, 'connect_timeout' => 5, 'follow_redirects' => true ) );
			foreach ( $rr as $d => $r ) {
				if ( $r instanceof \WpOrg\Requests\Response ) {
					if ( 404 === (int) $r->status_code ) $pa_out[ $d ] = 'free';
					elseif ( 200 === (int) $r->status_code ) $pa_out[ $d ] = 'taken';
				}
			}
		} catch ( \Exception $e ) { /* bo qua */ }
	}
	foreach ( $need as $d ) {
		$s = $pa_out[ $d ] ?? 'manual';
		if ( 'manual' !== $s ) set_transient( 'dgc_tm_' . md5( $d ), $s, 10 * MINUTE_IN_SECONDS );
		$res[ $d ] = $s;
	}
	return $res;
}

function dgc_domain_check_ajax() {
	check_ajax_referer( 'dgc_dc', 'n' );
	$q = strtolower( trim( sanitize_text_field( wp_unslash( $_POST['d'] ?? '' ) ) ) );
	$q = preg_replace( '#^https?://|^www\.|/.*$#', '', $q );
	$q = preg_replace( '/\s+/', '', $q );
	if ( ! preg_match( '/^[a-z0-9\p{L}][a-z0-9\-\p{L}]*(\.[a-z0-9\-]+)*$/u', $q ) ) wp_send_json( array( 's' => 'bad' ) );
	$ip = $_SERVER['REMOTE_ADDR'] ?? '';
	$k  = 'dgc_dc_' . md5( $ip );
	$n  = (int) get_transient( $k );
	if ( $n > 40 ) wp_send_json( array( 's' => 'limit' ) );
	set_transient( $k, $n + 1, HOUR_IN_SECONDS );

	$dot  = strpos( $q, '.' );
	$name = false === $dot ? $q : substr( $q, 0, $dot );
	$ext  = false === $dot ? '' : substr( $q, $dot );
	if ( '' === $name || strlen( $name ) > 63 ) wp_send_json( array( 's' => 'bad' ) );
	$prices = dgc_tm_price_map();
	$tlds   = dgc_tm_suggest_tlds();
	if ( $ext ) $tlds = array_values( array_unique( array_merge( array( $ext ), $tlds ) ) );
	$tlds = array_slice( $tlds, 0, 12 );
	$doms = array();
	foreach ( $tlds as $t ) $doms[] = $name . $t;
	$st  = dgc_tm_check_many( $doms );
	$out = array();
	foreach ( $tlds as $i => $t ) {
		$p = $prices[ $t ] ?? null;
		$out[] = array(
			'd'   => $doms[ $i ],
			's'   => $st[ $doms[ $i ] ],
			'gia' => $p ? dgc_vnd( $p['gia'] ) : '',
			'goc' => ( $p && (float) preg_replace( '/\D/', '', $p['goc'] ) > (float) preg_replace( '/\D/', '', $p['gia'] ) ) ? dgc_vnd( $p['goc'] ) : '',
			'han' => $p && $p['han'] ? dgc_vnd( $p['han'] ) : '',
		);
	}
	wp_send_json( array( 's' => 'ok', 'q' => $doms[0], 'list' => $out ) );
}
add_action( 'wp_ajax_dgc_domain_check', 'dgc_domain_check_ajax' );
add_action( 'wp_ajax_nopriv_dgc_domain_check', 'dgc_domain_check_ajax' );
