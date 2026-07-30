<?php
/**
 * Dump toan bo CPT dgc_gia (MOI trang thai - any) tren live thanh JSON, dung de doi chieu
 * truoc khi tao/cap nhat hang loat (rule "doi chieu voi live o trang thai any, khong chi
 * publish" - .claude/rules/bang-gia-booking.md muc "2 CAM BAY MOI cua routine tuan").
 * Chay: wp eval-file dump-live-gia.php > live-fresh.json
 */
$q = new WP_Query( array(
	'post_type'      => 'dgc_gia',
	'post_status'    => 'any',
	'posts_per_page' => -1,
	'fields'         => 'ids',
) );
$out = array();
foreach ( $q->posts as $id ) {
	$terms = wp_get_post_terms( $id, 'dgc_nhom', array( 'fields' => 'slugs' ) );
	$out[] = array(
		'ID'          => $id,
		'post_status' => get_post_status( $id ),
		'nhom'        => $terms ? $terms[0] : '',
		'title'       => get_the_title( $id ),
		'vi_tri'      => get_post_meta( $id, 'vi_tri', true ),
		'gia_km'      => get_post_meta( $id, 'gia_km', true ),
		'so_link'     => get_post_meta( $id, 'so_link', true ),
		'yeu_cau'     => get_post_meta( $id, 'yeu_cau', true ),
	);
}
echo json_encode( $out, JSON_UNESCAPED_UNICODE );
