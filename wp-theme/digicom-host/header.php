<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
	// Dat che do sang/toi TRUOC khi trang ve -> khong bi nhay trang mot nhip khi khach chon dark.
	// Uu tien lua chon da luu; chua chon thi theo cai dat he dieu hanh cua khach.
	?>
	<script>(function(){try{var t=localStorage.getItem('dgc-theme');if(!t){t=window.matchMedia&&window.matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light';}document.documentElement.setAttribute('data-theme',t);}catch(e){}})();</script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php $dgc_wm_logo = dgc_logo_url(); ?>
<div class="brand-watermark" aria-hidden="true" data-brand-watermark>
	<?php if ( $dgc_wm_logo ) : ?>
		<img src="<?php echo esc_url( $dgc_wm_logo ); ?>" alt="">
	<?php else : ?>
		<span>DigicomVN</span>
	<?php endif; ?>
</div>

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
			<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">DigicomVN<span class="dot">.</span></a>
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
			<?php dgc_theme_toggle(); ?>
			<button class="burger" aria-label="Mở menu" aria-expanded="false" onclick="document.getElementById('mnav').classList.toggle('open');document.body.classList.toggle('mnav-open');this.setAttribute('aria-expanded',document.getElementById('mnav').classList.contains('open'))"><span></span><span></span><span></span></button>
		</div>
	</div>
</header>

<div class="mnav" id="mnav">
	<div class="mnav-head">
		<span>Menu</span>
		<button class="mnav-close" aria-label="Đóng menu" onclick="document.getElementById('mnav').classList.remove('open');document.body.classList.remove('mnav-open')">&times;</button>
	</div>
	<div class="mnav-list">
		<?php
		if ( has_nav_menu( 'primary' ) ) {
			wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'items_wrap' => '<ul>%3$s</ul>', 'depth' => 0 ) );
		}
		?>
	</div>
	<div class="mnav-foot-row">
		<a class="mnav-cta" href="tel:<?php echo esc_attr( dgc_tel() ); ?>" style="flex:1 1 auto">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a>
		<?php dgc_theme_toggle(); ?>
	</div>
</div>
