<?php
/**
 * Template cho single blog post.
 * Khong tu render H1 tu post_title - noi dung Gutenberg cua bai da co H1 rieng
 * (content-writer skill luon xuat H1 trong than bai). Rendering ca 2 se bi trung H1.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<section class="sec">
	<div class="wrap">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'large', array( 'class' => 'single-post-thumb' ) ); ?>
			<?php endif; ?>
			<article class="page-content" style="max-width:820px;margin:0 auto 40px">
				<?php the_content(); ?>
			</article>

			<?php
			$dgc_cat_ids = wp_get_post_categories( get_the_ID() );
			if ( $dgc_cat_ids ) :
				$dgc_related = get_posts( array(
					'category__in'   => $dgc_cat_ids,
					'post__not_in'   => array( get_the_ID() ),
					'posts_per_page' => 4,
					'orderby'        => 'rand',
				) );
				$dgc_main_cat = get_the_category()[0] ?? null;
				if ( $dgc_related ) : ?>
				<div class="related-posts" style="max-width:820px;margin:0 auto 30px">
					<h3>Bài viết liên quan<?php if ( $dgc_main_cat ) : ?> <a class="related-cat-link" href="<?php echo esc_url( get_category_link( $dgc_main_cat ) ); ?>">trong <?php echo esc_html( $dgc_main_cat->name ); ?></a><?php endif; ?></h3>
					<ul class="related-list">
						<?php foreach ( $dgc_related as $rp ) : ?>
							<li><a href="<?php echo esc_url( get_permalink( $rp ) ); ?>"><?php echo esc_html( get_the_title( $rp ) ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<?php endif;
			endif;
			?>

			<div class="wrap" style="max-width:820px;margin:0 auto 40px;padding:0">
				<div class="cta-band">
					<div><h2>Cần triển khai off-page SEO thực tế?</h2><p>Digicom hỗ trợ Textlink, Backlink, Guest Post và Booking báo &amp; PR theo đúng kiến thức trong bài này.</p></div>
					<div class="cta-actions"><a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a><a class="btn btn-navy" href="<?php echo esc_url( home_url( '/bang-gia/' ) ); ?>">Xem bảng giá</a></div>
				</div>
			</div>
		<?php endwhile; endif; ?>
	</div>
</section>
<?php get_footer(); ?>
