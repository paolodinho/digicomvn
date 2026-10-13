<?php
/**
 * So lieu THAT cho hero 3D trang dich vu (2026-10-13, Hieu: "xau lam, thiet ke lai, hieu ung 3D
 * khi scroll, hap dan khong the roi mat").
 * Lay tu CPT dgc_gia: so bao/site, gia thap nhat, DR cao nhat, 3 dong DR cao nhat de dung
 * "bang gia noi" trong hero. Khong bia so - nhom khong co du lieu thi tra mang rong.
 * Cache transient 6h (dgc_get_gia doc toan bo meta, khong goi lai moi lan tai trang).
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function dgc_svc_hero_data( $slug ) {
	$key  = 'dgc_svch4_' . md5( $slug );
	$data = get_transient( $key );
	if ( is_array( $data ) ) return $data;

	$items = dgc_get_gia( $slug );
	$sites = array();
	$min   = 0;
	$maxdr = 0;
	$rows  = array();
	foreach ( $items as $it ) {
		$k     = dgc_search_key( $it->post_title );
		$price = dgc_gia_to_number( (string) ( $it->meta['gia_km'] ?? '' ) );
		$dr    = (int) ( $it->meta['dr'] ?? 0 );
		$sites[ $k ] = true;
		if ( $price > 0 && ( ! $min || $price < $min ) ) $min = $price;
		$maxdr = max( $maxdr, $dr );
		/* DR chi co tren 1 dong cua site -> gom DR max + gia min theo site, loc sau */
		if ( ! isset( $rows[ $k ] ) ) $rows[ $k ] = array( 'name' => $it->post_title, 'dr' => 0, 'price' => 0 );
		$rows[ $k ]['dr'] = max( $rows[ $k ]['dr'], $dr );
		if ( $price > 0 && ( ! $rows[ $k ]['price'] || $price < $rows[ $k ]['price'] ) ) $rows[ $k ]['price'] = $price;
	}
	/* items da xep DR giam dan -> 3 nhom dau la 3 bao/site manh nhat */
	$data = array(
		'count' => count( $sites ),
		'min'   => $min,
		'maxdr' => $maxdr,
		'rows'  => array_slice( array_values( array_filter( $rows, function ( $r ) { return $r['price'] > 0; } ) ), 0, 3 ),
	);
	set_transient( $key, $data, 6 * HOUR_IN_SECONDS );
	return $data;
}

/* Xoa cache khi sua dong gia */
add_action( 'save_post_dgc_gia', function () {
	global $wpdb;
	$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '\_transient\_dgc\_svch%' OR option_name LIKE '\_transient\_timeout\_dgc\_svch%'" );
} );

function dgc_svc_money( $n ) {
	if ( $n >= 1000000 ) {
		$v = $n / 1000000;
		return rtrim( rtrim( number_format( $v, 1, ',', '.' ), '0' ), ',' ) . ' triệu';
	}
	return number_format( $n, 0, ',', '.' ) . 'đ';
}
