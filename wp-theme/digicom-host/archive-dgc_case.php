<?php
/** Archive Case study - /case-study/ */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<div class="wrap"><nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a><span class="sep">/</span> Case study</nav></div>

<section class="page-hero">
	<div class="wrap" style="max-width:860px">
		<span class="eyebrow">Case study</span>
		<h1>Câu chuyện thành công cùng DigicomVN</h1>
		<p class="lead">Những dự án booking báo, PR và định danh thương hiệu DigicomVN đã trực tiếp triển khai - kèm nguồn báo chí để bạn kiểm chứng.</p>
	</div>
</section>

<section class="sec">
	<div class="wrap">
		<?php if ( have_posts() ) : ?>
		<div class="cs-grid">
			<?php while ( have_posts() ) : the_post();
				$svc    = get_post_meta( get_the_ID(), '_dgc_svc', true );
				$client = get_post_meta( get_the_ID(), '_dgc_client', true ); ?>
				<a class="cs-card cs-card--link" href="<?php the_permalink(); ?>">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="cs-thumb"><?php the_post_thumbnail( 'medium_large' ); ?></div>
					<?php endif; ?>
					<div class="cs-card-body">
						<?php if ( $svc ) : ?><span class="cs-tag"><?php echo esc_html( $svc ); ?></span><?php endif; ?>
						<h3><?php the_title(); ?></h3>
						<p class="cs-result"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 26 ) ); ?></p>
						<?php if ( $client ) : ?><div class="cs-client"><?php echo esc_html( $client ); ?></div><?php endif; ?>
						<span class="cs-more">Xem chi tiết &rarr;</span>
					</div>
				</a>
			<?php endwhile; ?>
		</div>
		<?php the_posts_pagination( array( 'mid_size' => 1 ) ); ?>
		<?php else : ?>
			<p class="muted center">Case study đang được cập nhật.</p>
		<?php endif; ?>
	</div>
</section>

<section class="sec-tight"><div class="wrap"><div class="cta-band">
	<div><h2>Muốn có câu chuyện thành công tiếp theo?</h2><p>Để DigicomVN tư vấn chiến dịch booking báo, PR phù hợp cho thương hiệu của bạn.</p></div>
	<div class="cta-actions"><a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a><a class="btn btn-navy" href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">Nhận tư vấn</a></div>
</div></div></section>

<?php get_footer();
