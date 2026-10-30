<?php
/**
 * Mua online email doanh nghiep, SSL, cloud server (Hieu duyet 30/10/2026).
 * Dung chung gio + thanh toan QR cua ten mien (item {t:'w', s:slug, k:goi, m:thang, u:so user, d:ten mien}).
 * Gia lay tu bang gia trang dich vu (dgc_web_rows), tinh lai o server.
 * Email Pro 1-10: tu dang ky qua lenh register_mailserver (ma goi tu mailserver_list, cache 12 gio) khi gia ban >= gia von x1,1.
 * Google Workspace, Microsoft 365, SSL, cloud: API dai ly khong co lenh -> email Hieu kich hoat tay -> "Da dang ky xong" trong WP Admin.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function dgc_ws_slugs() { return array( 'email-doanh-nghiep', 'chung-chi-ssl', 'cloud-server' ); }

/** Ky han ban online theo don vi gia. */
function dgc_ws_terms( $slug, $dv ) {
	if ( '/năm' === $dv ) return array( 12, 24 );
	if ( '/user/tháng' === $dv ) return array( 12 );
	if ( '/tháng' === $dv ) return 'cloud-server' === $slug ? array( 1, 3, 6, 12 ) : array( 12, 24, 36 );
	return array();
}

/** Danh muc goi mua online: [slug:key] => n, g, s, k, unit (gia/thang hoac /nam), per (1 = tinh theo user), nd (can ten mien), p[m]. */
function dgc_ws_catalog() {
	static $cache = null;
	if ( null !== $cache ) return $cache;
	$out = array();
	foreach ( dgc_ws_slugs() as $s ) {
		if ( ! function_exists( 'dgc_web_rows' ) ) break;
		foreach ( dgc_web_rows( $s ) as $g => $rows ) {
			foreach ( $rows as $r ) {
				$terms = dgc_ws_terms( $s, $r['dv'] );
				if ( $r['gia'] <= 0 || ! $terms ) continue;
				$k = sanitize_title( $g . '-' . $r['goi'] );
				$p = array();
				foreach ( $terms as $m ) $p[ $m ] = '/năm' === $r['dv'] ? $r['gia'] * $m / 12 : $r['gia'] * $m;
				$n = $r['goi'];
				if ( 'email-doanh-nghiep' === $s && 0 !== strpos( $g, 'Email' ) ) $n = $g . ' ' . $n;
				if ( 'chung-chi-ssl' === $s && false === stripos( $n, 'SSL' ) ) $n = 'SSL ' . $n;
				$out[ $s . ':' . $k ] = array( 's' => $s, 'k' => $k, 'n' => $n, 'g' => $g, 'per' => '/user/tháng' === $r['dv'] ? 1 : 0, 'nd' => 'cloud-server' === $s ? 0 : 1, 'p' => $p );
			}
		}
	}
	return $cache = $out;
}

/** Ma goi + gia von mail server: 'email pro N' => so thang => array(id, gia von). */
function dgc_ws_mail_cost() {
	$c = get_transient( 'dgc_ws_mail_cost' );
	if ( is_array( $c ) ) return $c;
	$last = get_option( 'dgc_ws_mail_cost_last', array() );
	if ( ! defined( 'DGC_PA_URL' ) || ! defined( 'DGC_PA_USER' ) || ! defined( 'DGC_PA_KEY' ) ) return is_array( $last ) ? $last : array();
	$r = wp_remote_get( DGC_PA_URL . '?' . http_build_query( array( 'username' => DGC_PA_USER, 'apikey' => DGC_PA_KEY, 'cmd' => 'mailserver_list', 'flag' => 1, 'responsetype' => 'json' ) ), array( 'timeout' => 25 ) );
	$j = is_wp_error( $r ) ? null : json_decode( trim( wp_remote_retrieve_body( $r ) ), true );
	$out = array();
	foreach ( (array) ( $j['ReturnText'] ?? array() ) as $p ) {
		if ( ! is_array( $p ) || empty( $p['id'] ) || ! preg_match( '/^Email Pro #?(\d+)$/i', trim( (string) ( $p['name'] ?? '' ) ), $n ) ) continue;
		if ( ! preg_match( '/([\d.]+)\s*đ\/\s*(\d+)\s*tháng/u', (string) ( $p['price_linux'] ?? '' ), $m ) ) continue;
		$out[ 'email pro ' . (int) $n[1] ][ (int) $m[2] ] = array( (int) $p['id'], (int) str_replace( '.', '', $m[1] ) );
	}
	if ( count( $out ) < 5 ) { set_transient( 'dgc_ws_mail_cost', is_array( $last ) ? $last : array(), 30 * MINUTE_IN_SECONDS ); return is_array( $last ) ? $last : array(); }
	set_transient( 'dgc_ws_mail_cost', $out, 12 * HOUR_IN_SECONDS );
	update_option( 'dgc_ws_mail_cost_last', $out, false );
	return $out;
}

/** Ma goi dai ly cho 1 dong email (0 = kich hoat tay). Chi tu dong khi gia ban >= gia von x1,1. */
function dgc_ws_pid( $v, $m, $amount ) {
	if ( 'email-doanh-nghiep' !== $v['s'] || $v['per'] ) return 0;
	$k = strtolower( preg_replace( '/\s+/', ' ', trim( $v['n'] ) ) );
	$c = dgc_ws_mail_cost()[ $k ][ $m ] ?? null;
	return ( $c && $amount >= $c[1] * 1.1 ) ? (int) $c[0] : 0;
}

function dgc_ws_public() {
	$o = array();
	foreach ( dgc_ws_catalog() as $id => $v ) $o[ $id ] = array( 'n' => $v['n'], 'g' => $v['g'], 'p' => $v['p'], 'per' => $v['per'], 'nd' => $v['nd'] );
	return $o;
}

function dgc_ws_label( $s ) {
	return array( 'email-doanh-nghiep' => 'Email', 'chung-chi-ssl' => 'SSL', 'cloud-server' => 'Cloud server' )[ $s ] ?? 'Dịch vụ';
}

/** 1 dong trong don. false neu goi/ky han khong ban online. */
function dgc_ws_quote( $s, $k, $m, $u, $d ) {
	$all = dgc_ws_catalog();
	$id  = sanitize_key( (string) $s ) . ':' . sanitize_title( (string) $k );
	$m   = (int) $m;
	if ( empty( $all[ $id ]['p'][ $m ] ) ) return false;
	$v = $all[ $id ];
	$u = $v['per'] ? max( 1, min( 300, (int) $u ) ) : 1;
	$a = (int) $v['p'][ $m ] * $u;
	return array( 't' => 'w', 's' => $v['s'], 'k' => $v['k'], 'n' => $v['n'], 'pid' => dgc_ws_pid( $v, $m, $a ), 'g' => $v['g'], 'm' => $m, 'u' => $u, 'per' => $v['per'], 'd' => $d, 'y' => (int) ceil( $m / 12 ), 'amount' => $a, 'list' => $a, 'gifts' => array(), 'combo' => 0 );
}

/** Mo ta 1 dong cho email/tom tat don. */
function dgc_ws_line_text( $l ) {
	$t = $l['n'] . ( $l['d'] ? ' cho ' . $l['d'] : '' ) . ' (' . ( $l['m'] % 12 ? $l['m'] . ' tháng' : ( $l['m'] / 12 ) . ' năm' );
	if ( ! empty( $l['per'] ) ) $t .= ', ' . (int) $l['u'] . ' người dùng';
	return $t . ')';
}
