<?php
/**
 * Template cho single blog post.
 * Khong tu render H1 tu post_title - noi dung Gutenberg cua bai da co H1 rieng
 * (content-writer skill luon xuat H1 trong than bai). Rendering ca 2 se bi trung H1.
 * Layout 2 cot >=1240px: trai = muc luc, phai = noi dung (Hieu 2026-07-28: bo cot "so do noi
 * dung" accordion category, chuyen muc luc sang trai). Duoi 1240px giu nguyen 1 cot + muc luc
 * dropdown/floating nhu truoc (inc/toc.php).
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<section class="sec">
	<div class="wrap post-layout-wrap">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
			$dgc_post_id = get_the_ID();

			ob_start();
			the_content();
			$dgc_content_html = ob_get_clean();
			$dgc_toc_items    = $GLOBALS['dgc_toc_items'];
			// Luoi an toan: bai phai co H1 trong than bai (content-writer skill).
			// Neu vi ly do gi do thieu (loi quy trinh dang bai) -> tu chen H1 tu post_title,
			// tranh trang khong co H1 nao (xau cho SEO/accessibility).
			if ( stripos( $dgc_content_html, '<h1' ) === false ) {
				$dgc_content_html = '<h1>' . esc_html( get_the_title() ) . '</h1>' . $dgc_content_html;
			}
			?>
			<div class="post-layout<?php echo empty( $dgc_toc_items ) ? ' post-layout--no-toc' : ''; ?>">
				<?php dgc_toc_render_sidebar( $dgc_toc_items ); ?>

				<div class="post-main">
					<?php if ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'large', array( 'class' => 'single-post-thumb' ) ); ?>
					<?php endif; ?>

					<?php
					$dgc_author_id  = (int) get_the_author_meta( 'ID' );
					$dgc_avatar_id  = get_user_meta( $dgc_author_id, 'dgc_avatar_id', true );
					$dgc_avatar_url = $dgc_avatar_id ? wp_get_attachment_image_url( (int) $dgc_avatar_id, 'thumbnail' ) : '';
					?>
					<div class="post-byline" style="margin:0 0 24px">
						<?php if ( $dgc_avatar_url ) : ?>
							<img class="post-byline__avatar" src="<?php echo esc_url( $dgc_avatar_url ); ?>" alt="<?php the_author(); ?>" width="40" height="40">
						<?php else : ?>
							<span class="post-byline__avatar post-byline__avatar--fallback"><?php echo esc_html( dgc_author_initials( get_the_author() ) ); ?></span>
						<?php endif; ?>
						<span>Tác giả <a href="<?php echo esc_url( get_author_posts_url( $dgc_author_id ) ); ?>"><?php the_author(); ?></a> · <?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?></span>
					</div>

					<article class="page-content" style="margin:0 0 40px">
						<?php echo $dgc_content_html; ?>
					</article>

					<?php
					$dgc_cat_ids = wp_get_post_categories( $dgc_post_id );
					if ( $dgc_cat_ids ) :
						$dgc_related = get_posts( array(
							'category__in'   => $dgc_cat_ids,
							'post__not_in'   => array( $dgc_post_id ),
							'posts_per_page' => -1,
							'orderby'        => array( 'menu_order' => 'ASC', 'ID' => 'ASC' ),
						) );
						$dgc_main_cat = get_the_category()[0] ?? null;
						if ( $dgc_related ) : ?>
						<?php $dgc_rel_show = 6; $dgc_rel_first = array_slice( $dgc_related, 0, $dgc_rel_show ); $dgc_rel_rest = array_slice( $dgc_related, $dgc_rel_show ); ?>
						<div class="related-posts" style="margin:0 0 30px">
							<h3>Bài viết liên quan<?php if ( $dgc_main_cat ) : ?> <a class="related-cat-link" href="<?php echo esc_url( get_category_link( $dgc_main_cat ) ); ?>">trong <?php echo esc_html( $dgc_main_cat->name ); ?></a><?php endif; ?></h3>
							<ul class="related-list">
								<?php foreach ( $dgc_rel_first as $rp ) : ?>
									<li><a href="<?php echo esc_url( get_permalink( $rp ) ); ?>"><?php echo esc_html( get_the_title( $rp ) ); ?></a></li>
								<?php endforeach; ?>
							</ul>
							<?php if ( $dgc_rel_rest ) : ?>
							<details class="related-more">
								<summary>Xem thêm <?php echo count( $dgc_rel_rest ); ?> bài trong chuyên mục</summary>
								<ul class="related-list">
									<?php foreach ( $dgc_rel_rest as $rp ) : ?>
										<li><a href="<?php echo esc_url( get_permalink( $rp ) ); ?>"><?php echo esc_html( get_the_title( $rp ) ); ?></a></li>
									<?php endforeach; ?>
								</ul>
							</details>
							<?php endif; ?>
						</div>
						<?php endif;
					endif;
					?>

					<div class="cta-band" style="margin-top:8px">
						<div><h2>Cần triển khai off-page SEO thực tế?</h2><p>DigicomVN hỗ trợ Textlink, Backlink, Guest Post và Booking báo &amp; PR theo đúng kiến thức trong bài này.</p></div>
						<div class="cta-actions"><a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a><a class="btn btn-navy" href="<?php echo esc_url( home_url( '/dat-bai/' ) ); ?>">Gửi yêu cầu báo giá</a></div>
					</div>
				</div>
			</div>
		<?php endwhile; endif; ?>
	</div>
</section>
<?php get_footer(); ?>
