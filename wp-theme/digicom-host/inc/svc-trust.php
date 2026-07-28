<?php
/**
 * Trust signal cho 7 trang dich vu chinh (money page): 1 danh gia khach hang dung
 * dich vu nay + dai phap nhan (MST, so nam hoat dong - tinh tu 'company_since').
 * Hieu 2026-07-28: bo sung sau audit toan site phat hien 7/7 trang thieu trust signal.
 * Testimonial la NOI DUNG MAU (xem inc/blk-testimonials.php + schema-markup.md - khong
 * emit Review/AggregateRating), sua duoc o WP Admin > DigicomVN > muc 7.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$dgc_svc_tms = array_filter( dgc_lines( 'testimonials' ), fn( $t ) => ! empty( $t[0] ) && trim( $t[2] ?? '' ) === $svc_name );
$dgc_tm      = $dgc_svc_tms ? reset( $dgc_svc_tms ) : null;

$dgc_since_ts = strtotime( (string) dgc( 'company_since' ) );
$dgc_years    = $dgc_since_ts ? max( 1, (int) floor( ( current_time( 'timestamp' ) - $dgc_since_ts ) / YEAR_IN_SECONDS ) ) : 0;

if ( ! $dgc_tm && ! $dgc_years ) return;
?>
<section class="sec" style="background:var(--surface-2);border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<?php if ( $dgc_tm ) :
			$quote = $dgc_tm[0]; $who = $dgc_tm[1] ?? ''; $photo = trim( $dgc_tm[3] ?? '' );
			$who_clean = preg_replace( '/^(Ông|Bà|Anh|Chị|Cô|Chú|Mr|Ms|Mrs)\.?\s+/u', '', $who );
			$initial = function_exists( 'mb_substr' ) ? mb_strtoupper( mb_substr( $who_clean, 0, 1 ) ) : strtoupper( substr( $who_clean, 0, 1 ) ); ?>
			<figure class="tm" style="max-width:640px;margin:0 auto 28px">
				<blockquote><?php echo esc_html( $quote ); ?></blockquote>
				<figcaption>
					<span class="tm-avatar<?php echo $photo ? ' tm-avatar--img' : ''; ?>" aria-hidden="true"><?php
						if ( $photo ) { echo '<img src="' . esc_url( $photo ) . '" alt="' . esc_attr( $who ) . '" loading="lazy">'; }
						else { echo esc_html( $initial ); } ?></span>
					<span><span class="tm-who"><?php echo esc_html( $who ); ?></span></span>
				</figcaption>
			</figure>
		<?php endif; ?>

		<?php if ( $dgc_years ) : ?>
		<p class="muted" style="text-align:center;font-size:13.5px;margin:0">
			<?php echo esc_html( dgc( 'company_name' ) ); ?> · MST <?php echo esc_html( dgc( 'company_mst' ) ); ?> · Hoạt động từ <?php echo esc_html( wp_date( 'm/Y', $dgc_since_ts ) ); ?> (<?php echo (int) $dgc_years; ?>+ năm)
		</p>
		<?php endif; ?>
	</div>
</section>
