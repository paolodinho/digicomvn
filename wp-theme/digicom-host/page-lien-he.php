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
				<div class="contact-info">
					<h3>Thông tin liên hệ</h3>
					<div class="ci"><span class="ci-ico"><?php echo dgc_icon( 'phone' ); ?></span><div>Hotline<br><b><a href="tel:<?php echo esc_attr( dgc_tel() ); ?>" style="color:#fff"><?php echo esc_html( dgc( 'hotline' ) ); ?></a><?php if ( dgc( 'hotline2' ) ) : ?> · <a href="tel:<?php echo esc_attr( dgc_tel2() ); ?>" style="color:#fff"><?php echo esc_html( dgc( 'hotline2' ) ); ?></a><?php endif; ?></b></div></div>
					<div class="ci"><span class="ci-ico"><?php echo dgc_icon( 'mail' ); ?></span><div>Email<br><b><a href="mailto:<?php echo esc_attr( dgc( 'email' ) ); ?>" style="color:#fff"><?php echo esc_html( dgc( 'email' ) ); ?></a></b></div></div>
					<div class="ci"><span class="ci-ico"><?php echo dgc_icon( 'pin' ); ?></span><div>Trụ sở<br><b><?php echo esc_html( dgc( 'address' ) ); ?></b><?php if ( dgc( 'address2' ) ) : ?><br><span style="opacity:.85">Văn phòng giao dịch</span><br><b><?php echo esc_html( dgc( 'address2' ) ); ?></b><?php endif; ?></div></div>
					<div class="ci"><span class="ci-ico"><?php echo dgc_icon( 'clock' ); ?></span><div>Giờ làm việc<br><b><?php echo esc_html( dgc( 'working_hours' ) ); ?></b></div></div>
					<?php if ( dgc( 'facebook' ) ) : ?>
					<div class="ci"><span class="ci-ico"><?php echo dgc_icon( 'facebook' ); ?></span><div>Fanpage<br><b><a href="<?php echo esc_url( dgc( 'facebook' ) ); ?>" target="_blank" rel="noopener" style="color:#fff">Facebook DigicomVN</a></b></div></div>
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
