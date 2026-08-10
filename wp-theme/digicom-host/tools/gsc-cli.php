<?php
/**
 * Chay qua: wp eval-file tools/gsc-cli.php --allow-root -- <toan trang | cum <slug> | URL...>
 * $args do WP-CLI truyen vao (moi tham so dong lenh sau ten file).
 * Dung boi submit-sitemap.sh / lenh /submit-sitemap - KHONG require trong functions.php.
 */

$raw = trim( implode( ' ', $args ) );

if ( $raw === '' || in_array( mb_strtolower( $raw ), array( 'toan trang', 'toàn trang', 'sitemap' ), true ) ) {
	$ok = dgc_gsc_submit_sitemap();
	echo $ok ? "OK: da bao Google doc lai toan bo sitemap.\n" : ( 'FAIL sitemap: ' . print_r( get_option( 'dgc_gsc_last_result' ), true ) );
	return;
}

if ( preg_match( '/^(cum|cluster)\s+(.+)$/iu', $raw, $m ) ) {
	$slug = trim( $m[2] );
	$r    = dgc_gsc_index_category( $slug );
	if ( ! $r ) {
		echo "Khong tim thay bai publish nao trong cum '$slug'\n";
		return;
	}
	foreach ( $r as $url => $res ) {
		echo ( $res['success'] ? 'OK   ' : 'FAIL ' ) . $url . ( $res['success'] ? '' : ' - ' . $res['detail'] ) . "\n";
	}
	return;
}

$urls = preg_split( '/[\s,]+/', $raw, -1, PREG_SPLIT_NO_EMPTY );
foreach ( $urls as $u ) {
	$url = ( strpos( $u, 'http' ) === 0 ) ? $u : home_url( '/' . trim( $u, '/' ) . '/' );
	$res = dgc_gsc_request_indexing( $url );
	echo ( $res['success'] ? 'OK   ' : 'FAIL ' ) . $url . ( $res['success'] ? '' : ' - ' . $res['detail'] ) . "\n";
}
