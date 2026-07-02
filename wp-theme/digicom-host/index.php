<?php
/**
 * Fallback template - dung cho moi trang chua co template rieng.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<section class="sec">
	<div class="wrap">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article style="max-width:820px;margin:0 auto 40px">
					<h1><?php the_title(); ?></h1>
					<div class="entry"><?php the_content(); ?></div>
				</article>
			<?php endwhile; ?>
			<div class="wrap"><?php posts_nav_link(); ?></div>
		<?php else : ?>
			<div class="center">
				<h1>Khong tim thay noi dung</h1>
				<p class="muted">Trang ban tim khong ton tai. Quay ve <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:var(--action)">trang chu</a>.</p>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php get_footer(); ?>
