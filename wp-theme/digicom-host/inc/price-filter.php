<?php
/**
 * Thanh loc NGANG phia tren bang gia trang dich vu.
 * 2026-10-14 (Hieu: "bang gia lam thong tin roi qua"): chi hien san 3 o - Linh vuc (nganh,
 * inc/price-sidebar.php), Khoang gia, Diem DR. Cac facet quy cach con lai (vi tri, loai link,
 * so anh, do dai) gom vao nut "Lọc thêm" (<details>). Bo dem so luong sau tung lua chon.
 * Facet suy tu dong qua dgc_gia_facets()/dgc_facet_value().
 * Bien can set truoc khi include: $pf_items (mang dong gia), $pf_show_nganh (bool).
 */
if ( ! defined( 'ABSPATH' ) ) exit;
if ( empty( $pf_items ) ) return;

$pf_total       = count( $pf_items );
$pf_show_facets = dgc_has_facet_filter( $pf_items );
if ( ! $pf_show_facets && empty( $pf_show_nganh ) ) return;

$pf_primary = array( 'Khoảng giá', 'Điểm DR (uy tín)' );
$pf_main    = array();
$pf_more    = array();
if ( $pf_show_facets ) {
	foreach ( dgc_facet_groups() as $pf_gname => $pf_opts ) {
		$pf_render = array();
		foreach ( $pf_opts as $pf_opt ) {
			$pf_n = dgc_facet_count( $pf_items, $pf_opt );
			if ( $pf_n > 0 && $pf_n < $pf_total ) $pf_render[] = $pf_opt;
		}
		if ( ! $pf_render ) continue;
		if ( in_array( $pf_gname, $pf_primary, true ) ) $pf_main[ $pf_gname ] = $pf_render;
		else $pf_more[ $pf_gname ] = $pf_render;
	}
}
$pf_select = function ( $gname, $opts, $cls = '' ) {
	?>
	<label class="filter-sel <?php echo esc_attr( $cls ); ?>">
		<span class="filter-sel-lb"><?php echo esc_html( str_replace( ' (uy tín)', '', $gname ) ); ?></span>
		<select class="filter-facet" data-facet="<?php echo esc_attr( $opts[0]['key'] ); ?>">
			<option value="">Tất cả</option>
			<?php foreach ( $opts as $o ) : ?>
			<option value="<?php echo esc_attr( $o['val'] ); ?>" data-mode="<?php echo esc_attr( $o['mode'] ); ?>"><?php echo esc_html( $o['label'] ); ?></option>
			<?php endforeach; ?>
		</select>
	</label>
	<?php
};
?>
<div class="filter-bar">
	<div class="filter-row">
		<?php include get_template_directory() . '/inc/price-sidebar.php'; ?>
		<?php foreach ( $pf_main as $g => $o ) $pf_select( $g, $o, 'filter-sel-main' ); ?>
		<?php if ( $pf_more ) : ?>
		<details class="filter-more">
			<summary>Lọc thêm</summary>
			<div class="filter-more-body">
				<?php foreach ( $pf_more as $g => $o ) $pf_select( $g, $o ); ?>
			</div>
		</details>
		<?php endif; ?>
	</div>
	<?php /* Chip cac dieu kien dang bat + nut xoa - JS tu do (price-grid.js). */ ?>
	<div class="filter-chips" hidden></div>
	<button type="button" class="filter-clear" hidden>Xoá bộ lọc</button>
</div>
