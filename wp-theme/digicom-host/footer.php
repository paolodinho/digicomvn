<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<?php /* Khoi uu dai to DA BO (Hieu 2026-07-15) - thay bang pill noi (promo-fab.php) o cuoi footer. */ ?>

<footer class="site-footer">
	<div class="wrap">
		<div class="foot-grid">
			<div>
				<?php $dgc_logo = dgc_logo_url_light(); ?>
				<?php if ( $dgc_logo ) : ?>
					<img class="footer-logo" src="<?php echo esc_url( $dgc_logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
				<?php else : ?>
					<div class="brand" style="color:#fff">DigicomVN<span class="dot" style="color:var(--action)">.</span></div>
				<?php endif; ?>
				<p>Chuyên Textlink, Backlink, Guest Post và Booking báo &amp; PR cho doanh nghiệp và agency SEO.</p>
				<p style="font-size:13px;color:#8aa0b7">Công ty TNHH DVTT Digito Combat<br>MST: 0109816406</p>
			</div>
			<div>
				<h4>Dịch vụ</h4>
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/mua-textlink/' ) ); ?>">Mua Textlink</a></li>
					<li><a href="<?php echo esc_url( home_url( '/dich-vu-backlink/' ) ); ?>">Dịch vụ Backlink</a></li>
					<li><a href="<?php echo esc_url( home_url( '/guest-post/' ) ); ?>">Guest Post</a></li>
					<li><a href="<?php echo esc_url( home_url( '/booking-bao-pr/' ) ); ?>">Booking báo &amp; PR</a></li>
						<li><a href="<?php echo esc_url( home_url( '/backlink-social-entity/' ) ); ?>">Backlink Social Entity</a></li>
				</ul>
			</div>
			<div>
				<h4>Hỗ trợ</h4>
				<ul>
					<li><a href="#faq">Câu hỏi thường gặp</a></li>
					<li><a href="<?php echo esc_url( home_url( '/bang-gia/' ) ); ?>">Bảng giá</a></li>
					<li><a href="<?php echo esc_url( home_url( '/dat-bai/' ) ); ?>">Đặt bài</a></li>
					<li><a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">Liên hệ</a></li>
				</ul>
			</div>
			<div>
				<h4>Liên hệ</h4>
				<ul>
					<li>Hotline: <a href="tel:<?php echo esc_attr( dgc_tel() ); ?>"><strong style="color:#fff"><?php echo esc_html( dgc( 'hotline' ) ); ?></strong></a><?php if ( dgc( 'hotline2' ) ) : ?> · <a href="tel:<?php echo esc_attr( dgc_tel2() ); ?>"><strong style="color:#fff"><?php echo esc_html( dgc( 'hotline2' ) ); ?></strong></a><?php endif; ?></li>
					<li>Email: <a href="mailto:<?php echo esc_attr( dgc( 'email' ) ); ?>"><?php echo esc_html( dgc( 'email' ) ); ?></a></li>
					<li><strong style="color:#fff">Trụ sở:</strong> <?php echo esc_html( dgc( 'address' ) ); ?></li>
					<?php if ( dgc( 'address2' ) ) : ?><li><strong style="color:#fff">Văn phòng:</strong> <?php echo esc_html( dgc( 'address2' ) ); ?></li><?php endif; ?>
					<li><?php echo esc_html( dgc( 'working_hours' ) ); ?></li>
				</ul>
			</div>
		</div>
		<div class="foot-bottom">
			<span>&copy; <?php echo esc_html( date( 'Y' ) ); ?> DigicomVN - Digito Combat. All rights reserved.</span>
			<span><a href="<?php echo esc_url( home_url( '/dieu-khoan-su-dung/' ) ); ?>">Điều khoản</a> &middot; <a href="<?php echo esc_url( home_url( '/chinh-sach-bao-mat/' ) ); ?>">Chính sách bảo mật</a></span>
		</div>
	</div>
</footer>

<a href="https://zalo.me/<?php echo esc_attr( preg_replace( '/[^0-9]/', '', dgc( 'zalo' ) ) ); ?>" class="fab-zalo" target="_blank" rel="noopener" aria-label="Chat Zalo với DigicomVN">
	<?php /* Bong bong bo tron + chu Zalo can giua (ban cu la hop goc vuong, chu Arial dan vao
	         -> trong nhu anh dan sai, Hieu bao 2026-07-14). */ ?>
	<?php /* Don gian: chi chu "Zalo" xanh, khong bong bong, khong vong tron (Hieu 2026-07-15). */ ?>
	<svg viewBox="0 0 44 22" fill="none" aria-hidden="true">
		<text x="22" y="17" text-anchor="middle" font-size="17" font-weight="700" fill="#0068FF"
			font-family="Montserrat,Helvetica,Arial,sans-serif" letter-spacing="-.4">Zalo</text>
	</svg>
</a>
<?php include get_template_directory() . '/inc/promo-popup.php'; ?>
<?php /* pill noi (promo-fab) DA BO - thay bang ribbon tren cung (inc/promo-bar.php trong header). */ ?>
<a href="#" class="to-top" aria-label="Lên đầu trang">
	<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
</a>
<div class="press-flash-layer" aria-hidden="true"></div>

<?php
$dgc_bottom_nav = array(
	array( 'icon' => 'home',   'label' => 'Trang chủ', 'url' => home_url( '/' ) ),
	array( 'icon' => 'layers', 'label' => 'Dịch vụ',   'sheet' => true ), // bam -> mo bottom sheet, khong dieu huong
	array( 'icon' => 'tag',    'label' => 'Bảng giá',  'url' => home_url( '/bang-gia/' ), 'feat' => true ),
	array( 'icon' => 'phone',  'label' => 'Gọi ngay',  'url' => 'tel:' . dgc_tel(), 'feat' => true ),
);
$dgc_cur_url = home_url( add_query_arg( array(), $GLOBALS['wp']->request ?? '' ) );
?>
<nav class="bottom-nav" aria-label="Menu di động">
	<?php foreach ( $dgc_bottom_nav as $bn ) :
		if ( ! empty( $bn['sheet'] ) ) : ?>
			<button type="button" class="bn-item" data-svc-sheet aria-expanded="false" aria-controls="svcSheet">
				<span class="bn-ico"><?php echo dgc_icon( $bn['icon'] ); ?></span>
				<span class="bn-label"><?php echo esc_html( $bn['label'] ); ?></span>
			</button>
		<?php else :
			$is_active = ! empty( $bn['url'] ) && untrailingslashit( $bn['url'] ) === untrailingslashit( $dgc_cur_url ); ?>
			<a class="bn-item<?php echo $is_active ? ' active' : ''; ?><?php echo ! empty( $bn['feat'] ) ? ' feat' : ''; ?>" href="<?php echo esc_url( $bn['url'] ); ?>">
				<span class="bn-ico"><?php echo dgc_icon( $bn['icon'] ); ?></span>
				<span class="bn-label"><?php echo esc_html( $bn['label'] ); ?></span>
			</a>
		<?php endif; ?>
	<?php endforeach; ?>
</nav>

<?php /* Bottom sheet "Dich vu" - bam nut Dich vu o bottom-nav mo ra 8 dich vu (khong dieu huong truc tiep). */ ?>
<div class="svc-sheet-ov" data-svc-sheet-close hidden></div>
<div class="svc-sheet" id="svcSheet" role="dialog" aria-label="Dịch vụ" aria-modal="true" hidden>
	<div class="svc-sheet-head">
		<span>Dịch vụ</span>
		<button type="button" class="svc-sheet-x" data-svc-sheet-close aria-label="Đóng">&times;</button>
	</div>
	<ul class="svc-sheet-list">
		<?php foreach ( dgc_service_links() as $sl ) : ?>
			<li><a href="<?php echo esc_url( home_url( $sl[1] ) ); ?>"><?php echo esc_html( $sl[0] ); ?></a></li>
		<?php endforeach; ?>
	</ul>
</div>

<?php wp_footer(); ?>
</body>
</html>
