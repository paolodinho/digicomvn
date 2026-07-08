<?php
/**
 * Trang Blog (posts page) - hien thi theo CUM CHU DE (category), khong phai
 * danh sach bai viet phang. Bam vao 1 cum -> sang category.php xem bai chi tiet.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

$dgc_topics = get_categories( array( 'hide_empty' => true, 'orderby' => 'count', 'order' => 'DESC' ) );
?>
<section class="sec">
	<div class="wrap">
		<div class="center" style="margin-bottom:40px">
			<span class="eyebrow">Blog</span>
			<h1>Kiến thức Backlink, Textlink, Guest Post &amp; Booking báo PR</h1>
		</div>

		<?php if ( $dgc_topics ) : ?>
			<div class="topic-grid">
				<?php foreach ( $dgc_topics as $topic ) : ?>
					<a href="<?php echo esc_url( get_category_link( $topic ) ); ?>" class="topic-card">
						<span class="topic-card__icon"><?php echo dgc_icon( 'layers' ); ?></span>
						<h2 class="topic-card__title"><?php echo esc_html( $topic->name ); ?></h2>
						<?php if ( $topic->description ) : ?>
							<p class="topic-card__desc"><?php echo esc_html( wp_trim_words( $topic->description, 20 ) ); ?></p>
						<?php endif; ?>
						<span class="topic-card__count"><?php echo (int) $topic->count; ?> bài viết</span>
						<span class="topic-card__more">Xem cụm chủ đề &rarr;</span>
					</a>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<div class="center">
				<p class="muted">Chưa có bài viết nào.</p>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php get_footer(); ?>
