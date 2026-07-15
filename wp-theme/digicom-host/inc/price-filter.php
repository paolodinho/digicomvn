<?php
/**
 * Thanh loc NGANG phia tren bang gia - dung CHUNG cho /bang-gia/ va bang gia trong trang dich vu.
 * Thay cho cot loc doc cu (Hieu 2026-07-14: "lam cho gon hon") - 4 dropdown + chip dang loc,
 * bang gia duoc them ~220px be ngang.
 *   1. Nhom bao / nganh (meta "nganh" - admin tick trong WP Admin).
 *   2-4. Quy cach bai: loai link (do/nofollow), so anh, so tu - suy tu dong qua dgc_gia_facets().
 * Bien can set truoc khi include: $pf_items (mang dong gia), $pf_show_nganh (bool).
 */
if ( ! defined( 'ABSPATH' ) ) exit;
if ( empty( $pf_items ) ) return;

$pf_total       = count( $pf_items );
$pf_show_nganh  = ! empty( $pf_show_nganh );
$pf_show_facets = dgc_has_facet_filter( $pf_items );
if ( ! $pf_show_nganh && ! $pf_show_facets ) return;

$pf_nganh_used = array();
foreach ( $pf_items as $pf_it ) {
	foreach ( dgc_gia_nganh_tags( $pf_it->meta['nganh'] ?? '' ) as $pf_n ) { $pf_nganh_used[ $pf_n ] = true; }
}
?>
<div class="filter-bar">
	<?php if ( $pf_show_nganh ) : ?>
	<label class="filter-sel">
		<span class="filter-sel-lb">Nhóm báo</span>
		<select class="filter-nganh">
			<option value="">Tất cả (<?php echo (int) $pf_total; ?>)</option>
			<?php foreach ( dgc_nganh_groups() as $pf_gname => $pf_gopts ) :
				$pf_slugs = array_filter( array_keys( $pf_gopts ), fn( $s ) => ! empty( $pf_nganh_used[ $s ] ) );
				if ( ! $pf_slugs ) continue;
			?>
			<optgroup label="<?php echo esc_attr( $pf_gname ); ?>">
				<?php foreach ( $pf_slugs as $pf_slug ) :
					$pf_n = 0;
					foreach ( $pf_items as $pf_it ) {
						if ( in_array( $pf_slug, dgc_gia_nganh_tags( $pf_it->meta['nganh'] ?? '' ), true ) ) $pf_n++;
					}
				?>
				<option value="<?php echo esc_attr( $pf_slug ); ?>"><?php echo esc_html( $pf_gopts[ $pf_slug ] ); ?> (<?php echo (int) $pf_n; ?>)</option>
				<?php endforeach; ?>
			</optgroup>
			<?php endforeach; ?>
		</select>
	</label>
	<?php endif; ?>

	<?php if ( $pf_show_facets ) :
		foreach ( dgc_facet_groups() as $pf_gname => $pf_opts ) :
			$pf_render = array();
			foreach ( $pf_opts as $pf_opt ) {
				$pf_n = dgc_facet_count( $pf_items, $pf_opt );
				if ( $pf_n > 0 && $pf_n < $pf_total ) $pf_render[] = $pf_opt + array( 'count' => $pf_n );
			}
			if ( ! $pf_render ) continue;
	?>
	<label class="filter-sel">
		<span class="filter-sel-lb"><?php echo esc_html( $pf_gname ); ?></span>
		<select class="filter-facet" data-facet="<?php echo esc_attr( $pf_render[0]['key'] ); ?>">
			<option value="">Tất cả</option>
			<?php foreach ( $pf_render as $pf_opt ) : ?>
			<option value="<?php echo esc_attr( $pf_opt['val'] ); ?>" data-mode="<?php echo esc_attr( $pf_opt['mode'] ); ?>"><?php echo esc_html( $pf_opt['label'] ); ?> (<?php echo (int) $pf_opt['count']; ?>)</option>
			<?php endforeach; ?>
		</select>
	</label>
	<?php endforeach; endif; ?>

	<?php /* Chip cac dieu kien dang bat + nut xoa - JS tu do (main.js). */ ?>
	<div class="filter-chips" hidden></div>
	<button type="button" class="filter-clear" hidden>Xoá bộ lọc</button>
</div>
