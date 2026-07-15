<?php
/**
 * Popup gioi thieu chuong trinh uu dai -> dan ve trang bang gia (Hieu 2026-07-14).
 * Noi dung lay tu CUNG option "promos" / "promo_title" / "promo_slots" / "promo_deadline"
 * voi khoi uu dai (inc/promo-band.php) - sua o WP Admin, khong sua PHP.
 *
 * Quy tac hien:
 *   - Chi hien 1 lan / phien (sessionStorage), sau 7 giay hoac khi cuon qua 35% trang.
 *   - KHONG hien tren trang bang gia / dat bai / cam on - khach da o buoc chuyen doi roi.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$dgc_pp = dgc_lines( 'promos' );
if ( ! $dgc_pp ) return;

/* Trang da o cuoi phieu chuyen doi -> khong lam phien. */
foreach ( array( 'bang-gia', 'dat-bai', 'cam-on' ) as $dgc_pp_skip ) {
	if ( is_page( $dgc_pp_skip ) ) return;
}

$dgc_pp_end   = dgc_promo_deadline_ts();
$dgc_pp_slots = (int) dgc( 'promo_slots' );
$dgc_pp_days  = $dgc_pp_end ? max( 0, (int) ceil( ( $dgc_pp_end - current_time( 'timestamp' ) ) / DAY_IN_SECONDS ) ) : 0;
?>
<div class="promo-pop" id="promoPop" hidden aria-hidden="true">
	<div class="promo-pop-mask" data-pop-close></div>
	<div class="promo-pop-card" role="dialog" aria-modal="true" aria-labelledby="promoPopTitle">
		<button type="button" class="promo-pop-x" data-pop-close aria-label="Đóng">&times;</button>

		<h3 class="promo-pop-title" id="promoPopTitle"><?php echo esc_html( dgc( 'promo_title', 'Ưu đãi đang áp dụng' ) ); ?></h3>
		<?php $dgc_pp_saving = trim( (string) dgc( 'promo_saving' ) ); ?>
		<?php if ( $dgc_pp_saving ) : ?>
		<p class="promo-pop-sub">Tiết kiệm tối đa <b class="promo-pop-saving"><?php echo esc_html( $dgc_pp_saving ); ?></b> mỗi đơn.</p>
		<?php else : ?>
		<p class="promo-pop-sub">Áp dụng cho đơn đặt trong đợt này.</p>
		<?php endif; ?>

		<ul class="promo-pop-list">
			<?php foreach ( array_slice( $dgc_pp, 0, 3 ) as $dgc_pp_i ) : ?>
			<li>
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
				<span><b><?php echo esc_html( $dgc_pp_i[0] ?? '' ); ?></b><?php if ( ! empty( $dgc_pp_i[1] ) ) : ?> - <?php echo esc_html( $dgc_pp_i[1] ); ?><?php endif; ?></span>
			</li>
			<?php endforeach; ?>
		</ul>

		<?php if ( $dgc_pp_slots > 0 || $dgc_pp_days > 0 ) : ?>
		<div class="promo-pop-meta">
			<?php if ( $dgc_pp_slots > 0 ) : ?><span class="promo-slots">Còn <b><?php echo (int) $dgc_pp_slots; ?></b> suất</span><?php endif; ?>
			<?php if ( $dgc_pp_days > 0 ) : ?><span class="promo-count" data-promo-end="<?php echo (int) $dgc_pp_end; ?>">Kết thúc <?php echo esc_html( wp_date( 'd/m', $dgc_pp_end ) ); ?> - còn <b class="promo-count-val"><?php echo (int) $dgc_pp_days; ?> ngày</b></span><?php endif; ?>
		</div>
		<?php endif; ?>

		<div class="promo-pop-actions">
			<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/bang-gia/' ) ); ?>">Xem bảng giá</a>
			<button type="button" class="promo-pop-later" data-pop-close>Để sau</button>
		</div>
	</div>
</div>
