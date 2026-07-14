<?php
/**
 * Template danh sach bai viet theo Cum chu de (category archive).
 * Tai su dung blog-card grid tu home.php + thanh dieu huong sang cum khac (so do cum chu de)
 * + CTA dan ve dich vu off-page SEO cua DigicomVN.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

$dgc_cur_cat  = get_queried_object();
$dgc_all_cats = get_categories( array( 'hide_empty' => true, 'orderby' => 'name' ) );
?>
<div class="wrap"><nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a><span class="sep">/</span> <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ) ); ?>">Blog</a><span class="sep">/</span> <?php single_cat_title(); ?></nav></div>

<section class="page-hero">
	<div class="wrap" style="max-width:820px">
		<span class="eyebrow">Cụm chủ đề</span>
		<h1><?php single_cat_title(); ?></h1>
		<?php if ( $dgc_cur_cat && $dgc_cur_cat->description ) : ?>
			<p class="lead"><?php echo esc_html( $dgc_cur_cat->description ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php if ( count( $dgc_all_cats ) > 1 ) : ?>
<section class="sec-tight" style="background:var(--surface-2);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<div class="tab-bar" role="tablist" aria-label="Các cụm chủ đề SEO">
			<?php foreach ( $dgc_all_cats as $cat ) :
				$is_current = $dgc_cur_cat && $cat->term_id === $dgc_cur_cat->term_id;
			?>
				<a href="<?php echo esc_url( get_category_link( $cat ) ); ?>" class="tab-btn<?php echo $is_current ? ' active' : ''; ?>"><?php echo esc_html( $cat->name ); ?></a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<section class="sec">
	<div class="wrap">
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
			<div class="center"><p class="muted">Chưa có bài viết nào trong cụm chủ đề này.</p></div>
		<?php endif; ?>
	</div>
</section>

<section class="sec-tight"><div class="wrap"><div class="cta-band">
	<div><h2>Cần triển khai off-page SEO thực tế?</h2><p>DigicomVN hỗ trợ Textlink, Backlink, Guest Post và Booking báo &amp; PR - áp dụng đúng kiến thức trên vào website của bạn.</p></div>
	<div class="cta-actions"><a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a><a class="btn btn-navy" href="<?php echo esc_url( home_url( '/bang-gia/' ) ); ?>">Xem bảng giá</a></div>
</div></div></section>

<?php get_footer(); ?>
