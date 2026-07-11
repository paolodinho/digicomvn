<?php
/**
 * Template trang Dat bai (page slug "dat-bai") - form dat hang/tu van tap trung.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<div class="wrap"><nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a><span class="sep">/</span> Đặt bài</nav></div>

<section class="page-hero">
	<div class="wrap" style="max-width:820px">
		<span class="eyebrow">Đặt bài</span>
		<h1><?php echo esc_html( get_the_title() ?: 'Đặt bài Textlink, Backlink, Guest Post, Booking PR' ); ?></h1>
		<p class="lead">Cho DigicomVN biết bạn cần dịch vụ nào, DigicomVN sẽ tư vấn site/báo phù hợp và gửi báo giá chi tiết trong thời gian sớm nhất.</p>
	</div>
</section>

<section class="sec">
	<div class="wrap">
		<div class="row" style="gap:30px;align-items:flex-start">
			<div class="col"><?php
				$dgc_form_title = 'Gửi yêu cầu đặt bài';
				$dgc_form_btn   = 'Gửi yêu cầu';
				include get_template_directory() . '/inc/form-lead.php';
			?></div>
			<div class="col">
				<div class="contact-info">
					<h3>Quy trình xử lý</h3>
					<div class="ci"><span>1</span><div>Tiếp nhận yêu cầu, xác nhận dịch vụ và ngân sách</div></div>
					<div class="ci"><span>2</span><div>Tư vấn site/báo phù hợp, gửi báo giá chi tiết</div></div>
					<div class="ci"><span>3</span><div>Xác nhận, triển khai và bàn giao link/bài kèm báo cáo</div></div>
				</div>
				<div class="contact-info" style="margin-top:16px">
					<h3>Liên hệ nhanh</h3>
					<div class="ci"><span class="ci-ico"><?php echo dgc_icon( 'phone' ); ?></span><div>Hotline<br><b><a href="tel:<?php echo esc_attr( dgc_tel() ); ?>" style="color:#fff"><?php echo esc_html( dgc( 'hotline' ) ); ?></a><?php if ( dgc( 'hotline2' ) ) : ?> · <a href="tel:<?php echo esc_attr( dgc_tel2() ); ?>" style="color:#fff"><?php echo esc_html( dgc( 'hotline2' ) ); ?></a><?php endif; ?></b></div></div>
					<div class="ci"><span class="ci-ico"><?php echo dgc_icon( 'mail' ); ?></span><div>Email<br><b><a href="mailto:<?php echo esc_attr( dgc( 'email' ) ); ?>" style="color:#fff"><?php echo esc_html( dgc( 'email' ) ); ?></a></b></div></div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php if ( get_the_content() ) : ?>
<section class="sec" style="background:var(--surface)"><div class="wrap page-content"><?php the_content(); ?></div></section>
<?php endif; ?>

<?php get_footer(); ?>
