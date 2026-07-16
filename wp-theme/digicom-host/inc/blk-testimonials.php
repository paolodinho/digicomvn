<?php
/**
 * Block testimonials + link case study - dung chung trang chu + trang dich vu.
 * Doc option 'testimonials'. Carousel owl (main.js da init .tm-carousel).
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$dgc_tms = array_filter( dgc_lines( 'testimonials' ), fn( $t ) => ! empty( $t[0] ) );
if ( ! $dgc_tms ) return;
?>
<section class="sec" id="danh-gia">
	<div class="wrap">
		<div class="center" style="margin-bottom:26px">
			<span class="eyebrow">Khách hàng</span>
			<h2>Khách hàng nói về DigicomVN</h2>
		</div>
		<div class="tm-carousel owl-carousel">
			<?php foreach ( $dgc_tms as $t ) :
				$quote = $t[0] ?? ''; $who = $t[1] ?? ''; $svc = $t[2] ?? ''; $photo = trim( $t[3] ?? '' );
				if ( $quote === '' ) continue;
				$who_clean = preg_replace( '/^(Ông|Bà|Anh|Chị|Cô|Chú|Mr|Ms|Mrs)\.?\s+/u', '', $who );
				$initial = function_exists( 'mb_substr' ) ? mb_strtoupper( mb_substr( $who_clean, 0, 1 ) ) : strtoupper( substr( $who_clean, 0, 1 ) ); ?>
				<figure class="tm">
					<div class="tm-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
					<blockquote><?php echo esc_html( $quote ); ?></blockquote>
					<figcaption>
						<span class="tm-avatar<?php echo $photo ? ' tm-avatar--img' : ''; ?>" aria-hidden="true"><?php
							if ( $photo ) {
								echo '<img src="' . esc_url( $photo ) . '" alt="' . esc_attr( $who ) . '" loading="lazy">';
							} else {
								echo esc_html( $initial );
							} ?></span>
						<span>
							<span class="tm-who"><?php echo esc_html( $who ); ?></span>
							<?php if ( $svc ) : ?><span class="tm-svc"><?php echo esc_html( $svc ); ?></span><?php endif; ?>
						</span>
					</figcaption>
				</figure>
			<?php endforeach; ?>
		</div>

		<div class="center" style="margin-top:34px">
			<a class="btn btn-ghost" href="<?php echo esc_url( get_post_type_archive_link( 'dgc_case' ) ?: home_url( '/case-study/' ) ); ?>">Xem case study thực tế của DigicomVN &rarr;</a>
		</div>
	</div>
</section>
