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

<div class="brand-watermark" aria-hidden="true" data-brand-watermark><span>Digicom</span></div>

<div class="topbar">
	<div class="wrap">
		<div class="tb-left">Hotline: <a href="tel:<?php echo esc_attr( dgc_tel() ); ?>"><strong><?php echo esc_html( dgc( 'hotline', '0988 769 317' ) ); ?></strong></a> <span class="hide-sm">&middot; <?php echo esc_html( dgc( 'working_hours' ) ); ?></span></div>
		<div class="tb-right">
			<a href="mailto:<?php echo esc_attr( dgc( 'email' ) ); ?>" class="hide-sm"><?php echo esc_html( dgc( 'email' ) ); ?></a><span class="sep hide-sm">|</span>
			<a href="https://zalo.me/<?php echo esc_attr( preg_replace( '/[^0-9]/', '', dgc( 'zalo' ) ) ); ?>">Chat Zalo</a>
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
				wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'items_wrap' => '<ul>%3$s</ul>', 'depth' => 0 ) );
			} else {
				echo '<ul><li><a href="' . esc_url( home_url( '/' ) ) . '">Trang chủ</a></li><li><a href="' . esc_url( home_url( '/dich-vu/' ) ) . '">Dịch vụ</a></li><li><a href="' . esc_url( home_url( '/bang-gia/' ) ) . '">Bảng giá</a></li><li><a href="' . esc_url( home_url( '/lien-he/' ) ) . '">Liên hệ</a></li></ul>';
			}
			?>
		</nav>

		<div class="header-cta">
			<a class="phone" href="tel:<?php echo esc_attr( dgc_tel() ); ?>"><?php echo esc_html( dgc( 'hotline' ) ); ?></a>
			<a class="btn btn-primary btn-sm" href="<?php echo esc_url( home_url( '/dat-bai/' ) ); ?>">Đặt bài ngay</a>
			<button class="burger" aria-label="Menu" onclick="document.getElementById('mnav').classList.toggle('open')"><span></span><span></span><span></span></button>
		</div>
	</div>
</header>

<div class="mnav" id="mnav">
	<?php
	if ( has_nav_menu( 'primary' ) ) {
		wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'items_wrap' => '<ul>%3$s</ul>', 'depth' => 0 ) );
	}
	?>
	<ul class="cta-item"><li><a href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a></li></ul>
</div>
