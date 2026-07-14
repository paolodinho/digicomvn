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
		<div class="blog-grid">
			<?php while ( have_posts() ) : the_post();
				$svc    = get_post_meta( get_the_ID(), '_dgc_svc', true );
				$client = get_post_meta( get_the_ID(), '_dgc_client', true ); ?>
				<article class="blog-card">
					<a href="<?php the_permalink(); ?>" class="blog-card__thumb">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'medium_large' ); ?>
						<?php else : ?>
							<div class="blog-card__thumb-placeholder"></div>
						<?php endif; ?>
					</a>
					<div class="blog-card__body">
						<span class="blog-card__date"><?php echo esc_html( $svc ?: $client ); ?></span>
						<h2 class="blog-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p class="blog-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
						<a href="<?php the_permalink(); ?>" class="blog-card__more">Đọc tiếp &rarr;</a>
					</div>
				</article>
			<?php endwhile; ?>
		</div>
		<div class="blog-pagination"><?php echo paginate_links( array( 'prev_text' => '&larr; Trước', 'next_text' => 'Sau &rarr;' ) ); ?></div>
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
