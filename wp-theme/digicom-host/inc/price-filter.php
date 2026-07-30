<?php
/**
 * Thanh loc NGANG phia tren bang gia - dung CHUNG cho /bang-gia/ va bang gia trong trang dich vu.
 * Quy cach bai: khoang gia, diem DR, vi tri dang, loai link (do/nofollow), so anh, so tu - suy
 * tu dong qua dgc_gia_facets()/dgc_facet_value(). Bo loc "Nhóm báo" (nganh) da TACH ra cot doc
 * rieng ben trai (`inc/price-sidebar.php`, Hieu 2026-07-30: "roi qua, cho sang cot doc") - file
 * nay gio CHI con cac facet quy cach, gon hon han truoc.
 * Bien can set truoc khi include: $pf_items (mang dong gia).
 */
if ( ! defined( 'ABSPATH' ) ) exit;
if ( empty( $pf_items ) ) return;

$pf_total       = count( $pf_items );
$pf_show_facets = dgc_has_facet_filter( $pf_items );
if ( ! $pf_show_facets ) return;
?>
<div class="filter-bar">
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
