<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="topbar">
	<div class="wrap">
		<div class="tb-left">Hotline: <a href="tel:<?php echo esc_attr( dgc_tel() ); ?>"><strong><?php echo esc_html( dgc( 'hotline', '0988 769 317' ) ); ?></strong></a> <span class="hide-sm">&middot; <?php echo esc_html( dgc( 'working_hours' ) ); ?></span></div>
		<div class="tb-right">
			<a href="#" class="hide-sm">Đăng nhập</a><span class="sep hide-sm">|</span>
			<a href="#" class="hide-sm">Hỗ trợ</a><span class="sep hide-sm">|</span>
			<a href="#">Giỏ hàng</a><span class="sep">|</span>
			<a href="#">VI</a>
		</div>
	</div>
</div>

<header class="site-header">
	<div class="wrap">
		<?php if ( has_custom_logo() ) : the_custom_logo(); else : ?>
			<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">Digicom<span class="dot">.</span></a>
		<?php endif; ?>

		<nav class="nav">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'items_wrap' => '%3$s', 'depth' => 1 ) );
			} else {
				echo '<a href="#services">Lập trình web</a><a href="#domains">Tên miền</a><a href="#hosting">Hosting</a><a href="#services">Bản quyền PM</a><a href="#services">Marketing</a><a href="#services">Automation</a><a href="#faq">Liên hệ</a>';
			}
			?>
		</nav>

		<div class="header-cta">
			<a class="phone" href="tel:<?php echo esc_attr( dgc_tel() ); ?>"><?php echo esc_html( dgc( 'hotline' ) ); ?></a>
			<a class="btn btn-primary btn-sm" href="#domains">Tư vấn ngay</a>
			<button class="burger" aria-label="Menu" onclick="document.getElementById('mnav').classList.toggle('open')"><span></span><span></span><span></span></button>
		</div>
	</div>
</header>

<div class="mnav" id="mnav">
	<a href="#domains">Tên miền</a>
	<a href="#hosting">Hosting</a>
	<a href="<?php echo esc_url( home_url( '/dich-vu/' ) ); ?>">Dịch vụ</a>
	<a href="#faq">Câu hỏi thường gặp</a>
	<a href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a>
</div>
