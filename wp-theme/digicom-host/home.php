<?php
/**
 * Template cho trang danh sach Blog (posts page).
 * Card grid co anh dai dien + excerpt, khong render full content (tranh trung H1
 * vi content da co H1 rieng - xem ghi chu trong single.php).
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<section class="sec">
	<div class="wrap">
		<div class="center" style="margin-bottom:32px">
			<span class="eyebrow">Blog</span>
			<h1>Kiến thức Backlink, Textlink, Guest Post &amp; Booking báo PR</h1>
		</div>

		<?php if ( have_posts() ) : ?>
			<div class="blog-grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<article class="blog-card">
						<a href="<?php the_permalink(); ?>" class="blog-card__thumb">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'medium_large' ); ?>
							<?php else : ?>
								<div class="blog-card__thumb-placeholder"></div>
							<?php endif; ?>
						</a>
						<div class="blog-card__body">
							<time class="blog-card__date"><?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?></time>
							<h2 class="blog-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<p class="blog-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
							<a href="<?php the_permalink(); ?>" class="blog-card__more">Đọc tiếp &rarr;</a>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
			<div class="blog-pagination">
				<?php
				echo paginate_links( array(
					'prev_text' => '&larr; Trước',
					'next_text' => 'Sau &rarr;',
				) );
				?>
			</div>
		<?php else : ?>
			<div class="center">
				<p class="muted">Chưa có bài viết nào.</p>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php get_footer(); ?>
