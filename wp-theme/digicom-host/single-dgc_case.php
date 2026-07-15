<?php
/** Single Case study - /case-study/<slug>/ */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
while ( have_posts() ) : the_post();
	$svc     = get_post_meta( get_the_ID(), '_dgc_svc', true );
	$client  = get_post_meta( get_the_ID(), '_dgc_client', true );
	$sources = function_exists( 'dgc_case_sources' ) ? dgc_case_sources() : array();
?>
<div class="wrap"><nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a><span class="sep">/</span> <a href="<?php echo esc_url( get_post_type_archive_link( 'dgc_case' ) ); ?>">Case study</a><span class="sep">/</span> <?php the_title(); ?></nav></div>

<section class="page-hero">
	<div class="wrap" style="max-width:840px">
		<?php if ( $svc ) : ?><span class="eyebrow"><?php echo esc_html( $svc ); ?></span><?php endif; ?>
		<h1><?php the_title(); ?></h1>
		<?php if ( $client ) : ?><p class="lead">Khách hàng: <strong><?php echo esc_html( $client ); ?></strong></p><?php endif; ?>
	</div>
</section>

<?php if ( has_post_thumbnail() ) : ?>
<div class="wrap" style="max-width:920px;margin-bottom:8px">
	<?php the_post_thumbnail( 'large', array( 'style' => 'width:100%;height:auto;border-radius:var(--r-lg);box-shadow:var(--sh-mid)' ) ); ?>
</div>
<?php endif; ?>

<section class="sec">
	<div class="wrap page-content" style="max-width:760px">
		<?php the_content(); ?>

		<?php if ( $sources ) : ?>
		<div class="cs-links" style="margin-top:26px;border-top:1px solid var(--line);padding-top:18px">
			<span class="cs-links-label">Xuất hiện trên</span>
			<div class="cs-links-row">
				<?php foreach ( $sources as $u ) : ?>
					<a href="<?php echo esc_url( $u ); ?>" target="_blank" rel="nofollow noopener"><?php echo esc_html( dgc_source_label( $u ) ); ?> &#8599;</a>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>

		<p style="margin-top:32px"><a class="btn btn-primary" href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">Nhận tư vấn cho dự án của bạn &rarr;</a> <a class="btn btn-ghost" href="<?php echo esc_url( get_post_type_archive_link( 'dgc_case' ) ); ?>">Xem case study khác</a></p>
	</div>
</section>

<?php endwhile; get_footer();
