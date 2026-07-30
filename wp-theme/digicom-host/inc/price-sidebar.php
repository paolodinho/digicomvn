<?php
/**
 * Cot doc "Nhom báo" ben trai bang gia (Hieu 2026-07-30: "thu show thanh hang doc ben trai
 * xem, cach trinh bay van roi") - thay cho dropdown <select> cu trong thanh loc ngang, giup
 * thanh loc ngang gon lai + nganh de nhin/de bam hon (giong sidebar danh muc thuong gap).
 * Bien can co truoc khi include: $pf_items (mang dong gia), $pf_show_nganh (bool).
 * Khong co du lieu nganh (1 nganh duy nhat) -> khong render gi ca (main.js van chay binh
 * thuong, chi khong co cot loc nganh).
 */
if ( ! defined( 'ABSPATH' ) ) exit;
if ( empty( $pf_items ) || empty( $pf_show_nganh ) ) return;

$ps_total = count( $pf_items );
$ps_used  = array();
foreach ( $pf_items as $ps_it ) {
	foreach ( dgc_gia_nganh_tags( $ps_it->meta['nganh'] ?? '' ) as $ps_n ) { $ps_used[ $ps_n ] = true; }
}
?>
<aside class="price-sidebar">
	<div class="side-nav-head">Nhóm báo</div>
	<nav class="side-nav">
		<button type="button" class="side-nav-item active" data-nganh-val="">
			<span>Tất cả</span><span class="side-nav-cnt"><?php echo (int) $ps_total; ?></span>
		</button>
		<?php foreach ( dgc_nganh_groups() as $ps_gname => $ps_gopts ) :
			$ps_slugs = array_filter( array_keys( $ps_gopts ), fn( $s ) => ! empty( $ps_used[ $s ] ) );
			if ( ! $ps_slugs ) continue;
		?>
		<div class="side-nav-group"><?php echo esc_html( $ps_gname ); ?></div>
		<?php foreach ( $ps_slugs as $ps_slug ) :
			$ps_n = 0;
			foreach ( $pf_items as $ps_it ) {
				if ( in_array( $ps_slug, dgc_gia_nganh_tags( $ps_it->meta['nganh'] ?? '' ), true ) ) $ps_n++;
			}
		?>
		<button type="button" class="side-nav-item" data-nganh-val="<?php echo esc_attr( $ps_slug ); ?>">
			<span><?php echo esc_html( $ps_gopts[ $ps_slug ] ); ?></span><span class="side-nav-cnt"><?php echo (int) $ps_n; ?></span>
		</button>
		<?php endforeach; endforeach; ?>
	</nav>
</aside>
