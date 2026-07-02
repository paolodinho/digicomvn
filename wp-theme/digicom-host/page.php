<?php
/**
 * Template trang mac dinh (About, phap ly, trang noi dung chung).
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
while ( have_posts() ) : the_post(); ?>
	<div class="wrap"><nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a><span class="sep">/</span> <?php the_title(); ?></nav></div>
	<section class="page-hero">
		<div class="wrap" style="max-width:820px">
			<h1><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?><p class="lead"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
		</div>
	</section>
	<section class="sec"><div class="wrap page-content"><?php the_content(); ?></div></section>
<?php endwhile; ?>
<?php get_footer(); ?>
