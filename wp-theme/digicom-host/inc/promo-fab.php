<?php
/**
 * Pill uu dai NOI (floating) tren moi trang (Hieu 2026-07-15) - thay khoi uu dai to.
 * Hien "Uu dai den <so tien>" + dem nguoc; bam -> mo popup (#promoPop); tu popup bam tiep -> bang gia.
 * So tien (promo_saving) va dem nguoc (promo_deadline) TU tinh tuy thoi diem - sua o WP Admin.
 * KHONG hien tren bang-gia / dat-bai / cam-on (khach da o buoc chuyen doi).
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! dgc_lines( 'promos' ) ) return;
foreach ( array( 'bang-gia', 'dat-bai', 'cam-on' ) as $dgc_fab_skip ) {
	if ( is_page( $dgc_fab_skip ) ) return;
}

$dgc_fab_saving = trim( (string) dgc( 'promo_saving' ) );
$dgc_fab_end    = dgc_promo_deadline_ts();
if ( $dgc_fab_end && $dgc_fab_end <= current_time( 'timestamp' ) ) $dgc_fab_end = 0;
$dgc_fab_days   = $dgc_fab_end ? max( 0, (int) ceil( ( $dgc_fab_end - current_time( 'timestamp' ) ) / DAY_IN_SECONDS ) ) : 0;
?>
<button type="button" class="promo-fab" id="promoFab" data-pop-open aria-label="Xem ưu đãi đang áp dụng">
	<span class="promo-fab-ico" aria-hidden="true">
		<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="8" width="18" height="4" rx="1"/><path d="M12 8v13M20 12v7a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-7M7.5 8a2.5 2.5 0 0 1 0-5C11 3 12 8 12 8M16.5 8a2.5 2.5 0 0 0 0-5C13 3 12 8 12 8"/></svg>
	</span>
	<span class="promo-fab-txt">
		<span class="promo-fab-lab">Ưu đãi<?php echo $dgc_fab_saving ? ' đến <b>' . esc_html( $dgc_fab_saving ) . '</b>' : ''; ?></span>
		<?php if ( $dgc_fab_end ) : ?>
		<span class="promo-fab-count promo-count" data-promo-end="<?php echo (int) $dgc_fab_end; ?>">còn <b class="promo-count-val"><?php echo $dgc_fab_days >= 1 ? (int) $dgc_fab_days . ' ngày' : 'hôm nay'; ?></b></span>
		<?php endif; ?>
	</span>
</button>
