<?php
/**
 * Khoi uu dai - dung chung trang chu + trang dich vu.
 * Ap 2 nguyen tac kich thich chuyen doi:
 *   - Gioi han thoi gian: han chot (option promo_deadline; de trong = het thang hien tai) + dem nguoc.
 *   - Khan hiem: so suat con lai (option promo_slots; de trong/0 = an).
 * Noi dung uu dai sua o WP Admin (option "promos": tieu de | mo ta | nhan).
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/* Uu dai hien tren MOI trang (Hieu 2026-07-14). Trang chu / trang dich vu goi truc tiep file nay;
   cac trang con lai duoc footer.php goi bo sung. Co dau hieu nay de khong render 2 lan. */
if ( ! empty( $GLOBALS['dgc_promo_done'] ) ) return;
$GLOBALS['dgc_promo_done'] = true;

$dgc_promos = dgc_lines( 'promos' );
if ( ! $dgc_promos ) return;

$dgc_promo_end   = dgc_promo_deadline_ts();
$dgc_promo_slots = (int) dgc( 'promo_slots' );
$dgc_promo_icons = array(
	'M12 20h9M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z',           // but viet - viet bai
	'M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z', // khung chat - tu van
	'M20 6 9 17l-5-5',                                                // tick - combo
	'M12 2 4 6v6c0 5 3.4 8.4 8 10 4.6-1.6 8-5 8-10V6z',              // khien - minh bach
);
?>
<section class="sec-tight promo-sec">
	<div class="wrap">
		<div class="promo-head">
			<div>
				<span class="eyebrow eyebrow-hot">Ưu đãi</span>
				<h2><?php echo esc_html( dgc( 'promo_title', 'Ưu đãi đang áp dụng' ) ); ?></h2>
			</div>
			<div class="promo-meta">
				<?php if ( $dgc_promo_slots > 0 ) : ?>
				<span class="promo-slots">Còn <b><?php echo (int) $dgc_promo_slots; ?></b> suất trong đợt này</span>
				<?php endif; ?>
				<?php if ( $dgc_promo_end ) : ?>
				<span class="promo-count" data-promo-end="<?php echo (int) $dgc_promo_end; ?>">
					Kết thúc <?php echo esc_html( wp_date( 'd/m', $dgc_promo_end ) ); ?> - còn <b class="promo-count-val"><?php echo esc_html( max( 0, (int) ceil( ( $dgc_promo_end - current_time( 'timestamp' ) ) / DAY_IN_SECONDS ) ) ); ?> ngày</b>
				</span>
				<?php endif; ?>
			</div>
		</div>

		<?php $dgc_saving = trim( (string) dgc( 'promo_saving' ) ); ?>
		<?php if ( $dgc_saving ) : ?>
		<div class="promo-saving">
			<span class="promo-saving-lab">Tiết kiệm tối đa</span>
			<span class="promo-saving-num"><?php echo esc_html( $dgc_saving ); ?><span class="promo-saving-unit">/đơn</span></span>
			<?php if ( dgc( 'promo_saving_note' ) ) : ?>
			<span class="promo-saving-note"><?php echo esc_html( dgc( 'promo_saving_note' ) ); ?></span>
			<?php endif; ?>
		</div>
		<?php endif; ?>

		<div class="promos">
			<?php $pi = 0; foreach ( $dgc_promos as $p ) : ?>
			<div class="promo">
				<span class="pico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="<?php echo esc_attr( $dgc_promo_icons[ $pi % count( $dgc_promo_icons ) ] ); ?>"/></svg></span>
				<div class="pt"><?php echo esc_html( $p[0] ?? '' ); ?></div>
				<div class="pd"><?php echo esc_html( $p[1] ?? '' ); ?></div>
				<?php if ( ! empty( $p[2] ) ) : ?><span class="promo-tag"><?php echo esc_html( $p[2] ); ?></span><?php endif; ?>
			</div>
			<?php $pi++; endforeach; ?>
		</div>

		<?php $dgc_combo_txt = dgc_combo_tiers_text(); ?>
		<div class="promo-foot-row">
			<?php if ( $dgc_combo_txt ) : ?>
			<p class="promo-foot">Chiết khấu combo áp dụng tự động khi tick nhiều mục trong bảng giá: <?php echo esc_html( $dgc_combo_txt ); ?>.</p>
			<?php endif; ?>
			<a class="btn btn-primary promo-cta" href="<?php echo esc_url( home_url( '/bang-gia/' ) ); ?>">Xem bảng giá &amp; nhận ưu đãi</a>
		</div>
	</div>
</section>
