<?php
/**
 * Template Name: Dich vu SEO (landing)
 * Trang dich vu SEO chu dao: dich-vu-seo, seo-ai, seo-local, seo-quoc-te, viet-bai-chuan-seo.
 * Noi dung chi tiet = noi dung trang (sua bang trinh soan thao). Khoi "Tom tat nhanh"
 * (div.dgc-summary trong noi dung) duoc dua len the ben phai hero, khong lap lai o than bai.
 * Cam ket = option home_about_points; FAQ = option svc_faqs (theo slug); dich vu lien quan =
 * option home_solutions. Sua o WP Admin > DigicomVN, KHONG cham PHP.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
the_post();

$dgc_slug    = get_post_field( 'post_name' );
$dgc_content = apply_filters( 'the_content', get_the_content() );

/* Tach khoi Tom tat nhanh ra khoi than bai */
$dgc_sum = array();
if ( preg_match( '#<div class="dgc-summary">(.*?)</div>#s', $dgc_content, $m ) ) {
	if ( preg_match_all( '#<li>\s*<strong>(.*?)</strong>(.*?)</li>#s', $m[1], $li, PREG_SET_ORDER ) ) {
		foreach ( $li as $x ) {
			$dgc_sum[] = array( trim( wp_strip_all_tags( $x[1] ), " :\t\n" ), trim( wp_strip_all_tags( $x[2] ) ) );
		}
	}
	if ( $dgc_sum ) $dgc_content = str_replace( $m[0], '', $dgc_content );
}

/* Muc luc tu H2 co id */
$dgc_toc = array();
if ( preg_match_all( '#<h2[^>]*id="([^"]+)"[^>]*>(.*?)</h2>#s', $dgc_content, $hh, PREG_SET_ORDER ) ) {
	foreach ( $hh as $h ) $dgc_toc[] = array( $h[1], wp_strip_all_tags( $h[2] ) );
}

$dgc_points = dgc_lines( 'home_about_points' );
$dgc_faqs   = dgc_svc_faq_items( $dgc_slug );
$dgc_rel    = array();
foreach ( dgc_lines( 'home_solutions' ) as $s ) {
	if ( empty( $s[0] ) || empty( $s[1] ) ) continue;
	if ( trim( $s[1], '/' ) === $dgc_slug || ! dgc_page_live( $s[1] ) ) continue;
	$dgc_rel[] = $s;
}
$dgc_parent = ( 'dich-vu-seo' !== $dgc_slug ) ? get_page_by_path( 'dich-vu-seo' ) : null;
$dgc_check  = '<span class="sg-ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5 9-10"/></svg></span>';
?>

<!-- HERO -->
<section class="sg-phero">
	<div class="wrap">
		<nav class="sg-crumb" aria-label="Breadcrumb">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a> /
			<?php if ( $dgc_parent ) : ?><a href="<?php echo esc_url( get_permalink( $dgc_parent ) ); ?>">Dịch vụ SEO</a> /<?php endif; ?>
			<span><?php the_title(); ?></span>
		</nav>
		<div class="sg-phero-row">
			<div>
				<h1><?php the_title(); ?></h1>
				<?php if ( has_excerpt() ) : ?><p class="sg-lead"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
				<div class="sg-hero-cta">
					<a class="sg-btn sg-btn--light" href="#lien-he"><?php echo dgc_arrow(); ?>Nhận audit SEO miễn phí</a>
					<a class="sg-btn sg-btn--line" href="tel:<?php echo esc_attr( dgc_tel() ); ?>"><?php echo dgc_arrow(); ?>Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a>
				</div>
			</div>
			<?php if ( $dgc_sum ) : ?>
			<aside class="sg-phero-card" aria-label="Tóm tắt nhanh">
				<h2>Tóm tắt nhanh</h2>
				<dl>
					<?php foreach ( $dgc_sum as $x ) : ?>
						<div><dt><?php echo esc_html( $x[0] ); ?></dt><dd><?php echo esc_html( $x[1] ); ?></dd></div>
					<?php endforeach; ?>
				</dl>
			</aside>
			<?php endif; ?>
		</div>
	</div>
</section>


<!-- NOI DUNG CHI TIET -->
<section class="sg-sec">
	<div class="wrap sg-svc-main">
		<article class="page-content sg-article"><?php echo $dgc_content; // phpcs:ignore ?></article>
		<aside class="sg-aside">
			<?php if ( count( $dgc_toc ) > 2 ) : ?>
			<nav class="sg-toc" aria-label="Mục lục">
				<p class="sg-toc-h">Nội dung chính</p>
				<ol>
					<?php foreach ( $dgc_toc as $t ) : ?><li><a href="#<?php echo esc_attr( $t[0] ); ?>"><?php echo esc_html( $t[1] ); ?></a></li><?php endforeach; ?>
				</ol>
			</nav>
			<?php endif; ?>
			<div class="sg-aside-cta">
				<p class="sg-aside-h">Audit SEO miễn phí</p>
				<p>Gửi website, DigicomVN kiểm tra hiện trạng và đề xuất việc nên làm trước, kèm phạm vi và chi phí.</p>
				<a class="sg-btn sg-btn--light" href="#lien-he"><?php echo dgc_arrow(); ?>Đăng ký audit</a>
				<a class="sg-aside-tel" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Hoặc gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a>
			</div>
		</aside>
	</div>
</section>

<!-- FAQ -->
<?php if ( $dgc_faqs ) : ?>
<section class="sg-sec sg-sec--cyan" id="faq">
	<div class="wrap sg-head--split" style="align-items:start">
		<div>
			<h2 class="sg-h">Câu hỏi thường gặp</h2>
			<p class="sg-lead">Chưa thấy câu trả lời bạn cần? Gọi <a href="tel:<?php echo esc_attr( dgc_tel() ); ?>" style="color:var(--sg-blue);font-weight:700"><?php echo esc_html( dgc( 'hotline' ) ); ?></a> hoặc gửi yêu cầu ở cuối trang.</p>
		</div>
		<div class="sg-faq">
			<?php foreach ( $dgc_faqs as $f ) : ?>
				<details><summary><?php echo esc_html( $f[0] ); ?></summary><div class="a"><?php echo esc_html( $f[1] ); ?></div></details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- DICH VU SEO LIEN QUAN -->
<?php if ( $dgc_rel ) : ?>
<section class="sg-sec">
	<div class="wrap">
		<div class="sg-head">
			<h2 class="sg-h">Dịch vụ SEO liên quan</h2>
		</div>
		<div class="sg-related">
			<?php foreach ( array_slice( $dgc_rel, 0, 4 ) as $s ) : ?>
				<a class="sg-card" href="<?php echo esc_url( home_url( $s[1] ) ); ?>">
					<h3><?php echo esc_html( $s[0] ); ?></h3>
					<?php if ( ! empty( $s[2] ) ) : ?><p><?php echo esc_html( $s[2] ); ?></p><?php endif; ?>
					<span class="sg-more">Xem chi tiết <?php echo dgc_arrow(); ?></span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- LIEN HE -->
<section class="sg-sec sg-sec--grey" id="lien-he">
	<div class="wrap">
		<div class="sg-contact">
			<div class="sg-contact-media" style="background-image:url('<?php echo esc_url( get_template_directory_uri() . '/assets/images/agency-team-1-800.webp' ); ?>')">
				<h2 class="sg-h">Gửi website để nhận bản audit SEO miễn phí</h2>
				<p>Gửi địa chỉ website và mục tiêu, DigicomVN kiểm tra hiện trạng rồi đề xuất việc nên làm trước, kèm phạm vi và chi phí.</p>
				<p>Hotline: <a href="tel:<?php echo esc_attr( dgc_tel() ); ?>"><strong><?php echo esc_html( dgc( 'hotline' ) ); ?></strong></a></p>
			</div>
			<div class="sg-contact-form"><?php
				$dgc_form_title   = 'Đăng ký audit SEO miễn phí';
				$dgc_form_btn     = 'Gửi yêu cầu audit';
				$dgc_form_service = get_the_title();
				$dgc_cur_path = trailingslashit( wp_parse_url( get_permalink(), PHP_URL_PATH ) );
				foreach ( dgc_service_links() as $sl ) {
					if ( $sl[1] === $dgc_cur_path ) { $dgc_form_service = $sl[0]; break; }
				}
				include get_template_directory() . '/inc/form-lead.php';
			?></div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
