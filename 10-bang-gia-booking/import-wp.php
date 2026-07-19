<?php
/**
 * Import bang gia vao CPT dgc_gia tren digicomvn.com.
 * Chay: wp eval-file import-wp.php <file.json> [dry]
 *
 * File JSON do build-payload (trong export-web / script python) sinh ra, gom:
 *   updates: [{id, gia}]   - cap nhat gia cho ban ghi da co (da tinh san o phia python,
 *                            CO CHOT CHAN: khong bao gio thap hon gia von cua dong do)
 *   new:     [{nhom, title, vi_tri, gia, so_link, yeu_cau}] - dau bao/site moi
 *
 * Nhom backlink-social-entity KHONG bi dung toi (gia rieng theo rule 120% Solann).
 */
$args = $args ?? array();
$file = $args[0] ?? '';
$dry  = in_array( 'dry', $args, true );

if ( ! $file || ! file_exists( $file ) ) WP_CLI::error( 'Thieu file JSON: ' . $file );
$data = json_decode( file_get_contents( $file ), true );
if ( ! is_array( $data ) || ! isset( $data['updates'], $data['new'] ) ) WP_CLI::error( 'JSON khong dung dinh dang' );

$n_up = 0;
foreach ( $data['updates'] as $u ) {
	if ( get_post_type( $u['id'] ) !== 'dgc_gia' ) continue;
	if ( ! $dry ) {
		if ( isset( $u['gia'] ) ) update_post_meta( $u['id'], 'gia_km', (string) $u['gia'] );
		if ( ! empty( $u['ma_ncc'] ) ) update_post_meta( $u['id'], 'ma_ncc', (string) $u['ma_ncc'] );
	}
	$n_up++;
}

$n_new = 0;
foreach ( $data['new'] as $r ) {
	if ( $r['nhom'] === 'backlink-social-entity' ) continue;
	if ( ! $dry ) {
		$id = wp_insert_post( array(
			'post_type'   => 'dgc_gia',
			'post_status' => 'publish',
			'post_title'  => $r['title'],
		) );
		if ( ! $id || is_wp_error( $id ) ) continue;
		wp_set_object_terms( $id, $r['nhom'], 'dgc_nhom' );
		update_post_meta( $id, 'vi_tri', $r['vi_tri'] );
		update_post_meta( $id, 'gia_km', (string) $r['gia'] );
		update_post_meta( $id, 'so_link', $r['so_link'] );
		update_post_meta( $id, 'yeu_cau', $r['yeu_cau'] );
		if ( ! empty( $r['ma_ncc'] ) ) update_post_meta( $id, 'ma_ncc', (string) $r['ma_ncc'] );
	}
	$n_new++;
}

WP_CLI::log( sprintf( '%s cap nhat gia: %d | tao moi: %d', $dry ? '[DRY RUN]' : '[DA GHI]', $n_up, $n_new ) );
WP_CLI::log( sprintf( 'Tong ban ghi dgc_gia: %d', wp_count_posts( 'dgc_gia' )->publish ) );
