<?php
/**
 * Template trang Lien he (page slug "lien-he").
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<div class="wrap"><nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a><span class="sep">/</span> Liên hệ</nav></div>

<section class="page-hero">
	<div class="wrap" style="max-width:820px">
		<span class="eyebrow">Liên hệ</span>
		<h1><?php echo esc_html( get_the_title() ?: 'Liên hệ DigicomVN' ); ?></h1>
		<p class="lead">Để lại thông tin, đội ngũ DigicomVN sẽ liên hệ tư vấn và báo giá trong thời gian sớm nhất.</p>
	</div>
</section>

<section class="sec">
	<div class="wrap">
		<div class="row" style="gap:30px;align-items:flex-start">
			<div class="col"><?php
				$dgc_form_title = 'Gửi yêu cầu tư vấn';
				include get_template_directory() . '/inc/form-lead.php';
			?></div>
			<div class="col">
				<img
					src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/team-service-800.jpg' ); ?>"
					alt="Đội ngũ DigicomVN"
					width="800" height="533"
					style="width:100%;height:auto;border-radius:var(--r-md);box-shadow:var(--sh-low);display:block;margin-bottom:22px"
					loading="lazy"
				>
				<div class="contact-info">
					<h3>Thông tin liên hệ</h3>
					<div class="ci"><span class="ci-ico"><?php echo dgc_icon( 'phone' ); ?></span><dl><dt>Hotline</dt><dd><a href="tel:<?php echo esc_attr( dgc_tel() ); ?>"><?php echo esc_html( dgc( 'hotline' ) ); ?></a><?php if ( dgc( 'hotline2' ) ) : ?> · <a href="tel:<?php echo esc_attr( dgc_tel2() ); ?>"><?php echo esc_html( dgc( 'hotline2' ) ); ?></a><?php endif; ?></dd></dl></div>
					<div class="ci"><span class="ci-ico"><?php echo dgc_icon( 'mail' ); ?></span><dl><dt>Email</dt><dd><a href="mailto:<?php echo esc_attr( dgc( 'email' ) ); ?>"><?php echo esc_html( dgc( 'email' ) ); ?></a></dd></dl></div>
					<div class="ci"><span class="ci-ico"><?php echo dgc_icon( 'pin' ); ?></span><dl><dt>Trụ sở</dt><dd><?php echo esc_html( dgc( 'address' ) ); ?></dd><?php if ( dgc( 'address2' ) ) : ?><dt>Văn phòng giao dịch</dt><dd><?php echo esc_html( dgc( 'address2' ) ); ?></dd><?php endif; ?></dl></div>
					<div class="ci"><span class="ci-ico"><?php echo dgc_icon( 'clock' ); ?></span><dl><dt>Giờ làm việc</dt><dd><?php echo esc_html( dgc( 'working_hours' ) ); ?></dd></dl></div>
					<?php if ( dgc( 'facebook' ) ) : ?>
					<div class="ci"><span class="ci-ico"><?php echo dgc_icon( 'facebook' ); ?></span><dl><dt>Fanpage</dt><dd><a href="<?php echo esc_url( dgc( 'facebook' ) ); ?>" target="_blank" rel="noopener">Facebook DigicomVN</a></dd></dl></div>
					<?php endif; ?>
				</div>
				<div class="contact-map">
					<iframe src="https://www.google.com/maps?cid=2252645296724540673&output=embed" width="100%" height="100%" style="border:0" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Bản đồ trụ sở DigicomVN"></iframe>
				</div>
			</div>
		</div>
	</div>
</section>

<?php if ( get_the_content() ) : ?>
<section class="sec" style="background:var(--surface)"><div class="wrap page-content"><?php the_content(); ?></div></section>
<?php endif; ?>

<?php get_footer(); ?>
