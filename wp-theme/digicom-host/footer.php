<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<footer class="site-footer">
	<div class="wrap">
		<div class="foot-grid">
			<div>
				<?php $dgc_logo = dgc_logo_url(); ?>
				<?php if ( $dgc_logo ) : ?>
					<img class="footer-logo" src="<?php echo esc_url( $dgc_logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
				<?php else : ?>
					<div class="brand" style="color:#fff">Digicom<span class="dot" style="color:var(--action)">.</span></div>
				<?php endif; ?>
				<p>Chuyên Textlink, Backlink, Guest Post và Booking báo &amp; PR cho doanh nghiệp và agency SEO.</p>
				<p style="font-size:13px;color:#8aa0b7">Công ty TNHH DVTT Digito Combat<br>MST: 0109816406</p>
			</div>
			<div>
				<h4>Dịch vụ</h4>
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/dich-vu/mua-textlink/' ) ); ?>">Mua Textlink</a></li>
					<li><a href="<?php echo esc_url( home_url( '/dich-vu/dich-vu-backlink/' ) ); ?>">Dịch vụ Backlink</a></li>
					<li><a href="<?php echo esc_url( home_url( '/dich-vu/guest-post/' ) ); ?>">Guest Post</a></li>
					<li><a href="<?php echo esc_url( home_url( '/dich-vu/booking-bao-pr/' ) ); ?>">Booking báo &amp; PR</a></li>
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
					<li>Hotline: <a href="tel:<?php echo esc_attr( dgc_tel() ); ?>"><strong style="color:#fff"><?php echo esc_html( dgc( 'hotline' ) ); ?></strong></a></li>
					<li>Email: <a href="mailto:<?php echo esc_attr( dgc( 'email' ) ); ?>"><?php echo esc_html( dgc( 'email' ) ); ?></a></li>
					<li><?php echo esc_html( dgc( 'address' ) ); ?></li>
					<li><?php echo esc_html( dgc( 'working_hours' ) ); ?></li>
				</ul>
			</div>
		</div>
		<div class="foot-bottom">
			<span>&copy; <?php echo esc_html( date( 'Y' ) ); ?> Digicom - Digito Combat. All rights reserved.</span>
			<span><a href="<?php echo esc_url( home_url( '/dieu-khoan-su-dung/' ) ); ?>">Điều khoản</a> &middot; <a href="<?php echo esc_url( home_url( '/chinh-sach-bao-mat/' ) ); ?>">Chính sách bảo mật</a></span>
		</div>
	</div>
</footer>

<a href="#" class="to-top" aria-label="Lên đầu trang">
	<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
</a>

<?php wp_footer(); ?>
</body>
</html>
