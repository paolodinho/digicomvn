<?php
/**
 * O chon "Lĩnh vực" (nhom bao/nganh) cho bang gia - include tu inc/price-filter.php.
 * 2026-10-14 (Hieu: "bang gia lam thong tin roi qua"): bo cot doc 26 nut ben trai, gom
 * thanh 1 <select> co optgroup dat dau thanh loc ngang. price-grid.js doc `.filter-nganh`.
 * Bien can co: $pf_items (mang dong gia), $pf_show_nganh (bool).
 */
if ( ! defined( 'ABSPATH' ) ) exit;
if ( empty( $pf_items ) || empty( $pf_show_nganh ) ) return;

$ps_count = array();
foreach ( $pf_items as $ps_it ) {
	foreach ( dgc_gia_nganh_tags( $ps_it->meta['nganh'] ?? '' ) as $ps_n ) {
		$ps_count[ $ps_n ] = ( $ps_count[ $ps_n ] ?? 0 ) + 1;
	}
}
?>
<label class="filter-sel filter-sel-main">
	<span class="filter-sel-lb">Lĩnh vực</span>
	<select class="filter-nganh" aria-label="Lọc theo lĩnh vực">
		<option value="">Tất cả lĩnh vực</option>
		<?php foreach ( dgc_nganh_groups() as $ps_gname => $ps_gopts ) :
			$ps_slugs = array_filter( array_keys( $ps_gopts ), fn( $s ) => ! empty( $ps_count[ $s ] ) );
			if ( ! $ps_slugs ) continue;
		?>
		<optgroup label="<?php echo esc_attr( $ps_gname ); ?>">
			<?php foreach ( $ps_slugs as $ps_slug ) : ?>
			<option value="<?php echo esc_attr( $ps_slug ); ?>"><?php echo esc_html( $ps_gopts[ $ps_slug ] ); ?></option>
			<?php endforeach; ?>
		</optgroup>
		<?php endforeach; ?>
	</select>
</label>
