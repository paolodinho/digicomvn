<?php
/**
 * Ribbon uu dai TREN CUNG trang (Hieu 2026-07-15: pill noi o goc bi lot -> dua len dai tren cung).
 * Bam vao dai -> mo popup uu dai (dung [data-pop-open], JS trong main.js). Dem nguoc + so tien
 * TU tinh theo thoi diem (option promo_saving / promo_deadline, sua o WP Admin).
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! dgc_lines( 'promos' ) ) return;
/* Bam ribbon -> mo popup (#promoPop). Popup bi loai o bang-gia/dat-bai/cam-on -> ribbon cung an
   o do (tranh bam khong ra gi; khach da o buoc chot). */
foreach ( array( 'bang-gia', 'dat-bai', 'cam-on' ) as $dgc_pb_skip ) {
	if ( is_page( $dgc_pb_skip ) ) return;
}

$dgc_pb_saving = trim( (string) dgc( 'promo_saving' ) );
$dgc_pb_end    = dgc_promo_deadline_ts();
if ( $dgc_pb_end && $dgc_pb_end <= current_time( 'timestamp' ) ) $dgc_pb_end = 0;
$dgc_pb_days   = $dgc_pb_end ? max( 0, (int) ceil( ( $dgc_pb_end - current_time( 'timestamp' ) ) / DAY_IN_SECONDS ) ) : 0;
?>
<div class="promo-bar" data-pop-open role="button" tabindex="0" aria-label="Xem ưu đãi đang áp dụng">
	<span class="promo-bar-in">
		<span class="promo-bar-ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="8" width="18" height="4" rx="1"/><path d="M12 8v13M20 12v7a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-7M7.5 8a2.5 2.5 0 0 1 0-5C11 3 12 8 12 8M16.5 8a2.5 2.5 0 0 0 0-5C13 3 12 8 12 8"/></svg></span>
		<span class="promo-bar-lab">Ưu đãi<?php echo $dgc_pb_saving ? ' đến <b>' . esc_html( $dgc_pb_saving ) . '</b>/đơn' : ''; ?></span>
		<?php if ( $dgc_pb_end ) : ?>
		<span class="promo-bar-sep" aria-hidden="true">&middot;</span>
		<span class="promo-bar-count promo-count" data-promo-end="<?php echo (int) $dgc_pb_end; ?>">Kết thúc sau <b class="promo-count-val"><?php echo $dgc_pb_days >= 1 ? (int) $dgc_pb_days . ' ngày' : 'hôm nay'; ?></b></span>
		<?php endif; ?>
		<span class="promo-bar-cta">Nhận ưu đãi &rarr;</span>
	</span>
</div>
