<?php
/**
 * Dump CPT dgc_gia dang PUBLISH (dung y het du lieu hien tren /bang-gia/) thanh JSON,
 * dung lam nguon cho sync-google-sheet.py + xuat PDF tong hop.
 * Chi lay 7 nhom dang publish tren web (KHONG lay 4 nhom tam an TV/loa phuong/phat thanh/LED).
 * Chay tren live qua SSH: wp eval-file dump-publish-gia.php > publish-gia.json
 */
$nhom_labels = array(
	'booking-bao-pr'         => 'Booking báo & PR',
	'guest-post'             => 'Guest Post',
	'dich-vu-backlink'       => 'Dịch vụ Backlink',
	'mua-textlink'           => 'Mua Textlink',
	'backlink-social-entity' => 'Backlink Social Entity',
	'dich-vu-toplist'        => 'Dịch vụ Toplist',
	'backlink-quoc-te'       => 'Backlink quốc tế',
);

$q = new WP_Query( array(
	'post_type'      => 'dgc_gia',
	'post_status'    => 'publish',
	'posts_per_page' => -1,
	'fields'         => 'ids',
	'orderby'        => 'menu_order title',
	'order'          => 'ASC',
) );

$out = array();
// Thong tin lien he that (doc tu WP Admin > DigicomVN, khong bia) - dung cho header/footer/
// watermark ben PDF (chong doi thu crop mat nguon, in generate-pdf.py).
$out['_meta'] = array(
	'hotline' => dgc( 'hotline' ),
	'email'   => dgc( 'email' ),
	'website' => home_url( '/bang-gia/' ),
);
foreach ( $nhom_labels as $slug => $label ) {
	$out[ $slug ] = array( 'label' => $label, 'rows' => array() );
}

foreach ( $q->posts as $id ) {
	$terms = wp_get_post_terms( $id, 'dgc_nhom', array( 'fields' => 'slugs' ) );
	$slug  = $terms ? $terms[0] : '';
	if ( ! isset( $out[ $slug ] ) ) continue; // bo qua nhom tam an / khong xac dinh

	$gia = get_post_meta( $id, 'gia_km', true );
	$out[ $slug ]['rows'][] = array(
		'ten'     => get_the_title( $id ),
		'vi_tri'  => get_post_meta( $id, 'vi_tri', true ),
		'gia'     => $gia,
		'so_link' => get_post_meta( $id, 'so_link', true ),
		'yeu_cau' => get_post_meta( $id, 'yeu_cau', true ),
	);
}

echo json_encode( $out, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
