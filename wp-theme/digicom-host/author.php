<?php
/**
 * Template trang tac gia (WP archive mac dinh cho /author/{nicename}/).
 * Hien thi ho so tac gia (anh, chuc danh, tieu su, mang xa hoi - sua duoc tu
 * WP Admin > Ho so, khong cham code) + danh sach bai da viet, phuc vu E-E-A-T.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

$dgc_author    = get_queried_object();
$dgc_name      = $dgc_author->display_name;
$dgc_bio       = $dgc_author->description;
$dgc_fb        = get_user_meta( $dgc_author->ID, 'dgc_facebook', true );
$dgc_li        = get_user_meta( $dgc_author->ID, 'dgc_linkedin', true );
$dgc_avatar_id = get_user_meta( $dgc_author->ID, 'dgc_avatar_id', true );
$dgc_avatar    = $dgc_avatar_id ? wp_get_attachment_image_url( (int) $dgc_avatar_id, 'medium' ) : '';
$dgc_url       = get_author_posts_url( $dgc_author->ID );

$dgc_schema = array(
	'@context'  => 'https://schema.org',
	'@type'     => 'Person',
	'name'      => $dgc_name,
	'url'       => $dgc_url,
	'jobTitle'  => 'Founder, DigicomVN',
	'worksFor'  => array( '@type' => 'Organization', 'name' => 'DigicomVN', 'url' => home_url( '/' ) ),
);
if ( $dgc_bio ) $dgc_schema['description'] = wp_strip_all_tags( $dgc_bio );
if ( $dgc_avatar ) $dgc_schema['image'] = $dgc_avatar;
$dgc_same_as = array_filter( array( $dgc_fb, $dgc_li ) );
if ( $dgc_same_as ) $dgc_schema['sameAs'] = array_values( $dgc_same_as );
?>
<script type="application/ld+json"><?php echo wp_json_encode( $dgc_schema ); ?></script>

<div class="wrap"><nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a><span class="sep">/</span> Tác giả</nav></div>

<section class="page-hero author-hero">
	<div class="wrap" style="max-width:820px">
		<div class="author-hero__row">
			<?php if ( $dgc_avatar ) : ?>
				<img class="author-avatar" src="<?php echo esc_url( $dgc_avatar ); ?>" alt="Ảnh tác giả <?php echo esc_attr( $dgc_name ); ?>" width="112" height="112">
			<?php else : ?>
				<span class="author-avatar author-avatar--fallback" aria-hidden="true"><?php echo esc_html( dgc_author_initials( $dgc_name ) ); ?></span>
			<?php endif; ?>
			<div>
				<span class="eyebrow">Tác giả</span>
				<h1><?php echo esc_html( $dgc_name ); ?></h1>
				<p class="lead" style="margin-bottom:14px">Founder DigicomVN - phụ trách nội dung &amp; chiến lược off-page SEO.</p>
				<?php if ( $dgc_fb || $dgc_li ) : ?>
				<div class="author-social">
					<?php if ( $dgc_fb ) : ?><a href="<?php echo esc_url( $dgc_fb ); ?>" target="_blank" rel="noopener me" aria-label="Facebook cá nhân"><?php echo dgc_icon( 'facebook' ); ?><span>Facebook</span></a><?php endif; ?>
					<?php if ( $dgc_li ) : ?><a href="<?php echo esc_url( $dgc_li ); ?>" target="_blank" rel="noopener me" aria-label="LinkedIn"><?php echo dgc_icon( 'linkedin' ); ?><span>LinkedIn</span></a><?php endif; ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<?php if ( $dgc_bio ) : ?>
<section class="sec-tight">
	<div class="wrap page-content" style="max-width:820px">
		<p><?php echo esc_html( $dgc_bio ); ?></p>
	</div>
</section>
<?php endif; ?>

<section class="sec" style="background:var(--surface-2);border-top:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:30px"><span class="eyebrow">Nội dung đã viết</span><h2>Bài viết của <?php echo esc_html( $dgc_name ); ?></h2></div>
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
				<?php echo paginate_links( array( 'prev_text' => '&larr; Trước', 'next_text' => 'Sau &rarr;' ) ); ?>
			</div>
		<?php else : ?>
			<div class="center"><p class="muted">Chưa có bài viết nào được xuất bản.</p></div>
		<?php endif; ?>
	</div>
</section>

<section class="sec-tight"><div class="wrap"><div class="cta-band">
	<div><h2>Cần triển khai off-page SEO thực tế?</h2><p>DigicomVN hỗ trợ Textlink, Backlink, Guest Post và Booking báo &amp; PR cho doanh nghiệp của bạn.</p></div>
	<div class="cta-actions"><a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a><a class="btn btn-navy" href="<?php echo esc_url( home_url( '/bang-gia/' ) ); ?>">Xem bảng giá</a></div>
</div></div></section>

<?php get_footer(); ?>
