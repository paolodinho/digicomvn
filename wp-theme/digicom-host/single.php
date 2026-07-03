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
			<article class="page-content" style="max-width:820px;margin:0 auto 40px">
				<?php the_content(); ?>
			</article>
		<?php endwhile; endif; ?>
	</div>
</section>
<?php get_footer(); ?>
