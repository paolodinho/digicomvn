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
				<p>Cung cấp tên miền, hosting và dịch vụ hạ tầng website cho doanh nghiệp và cá nhân.</p>
				<p style="font-size:13px;color:#8aa0b7">Công ty TNHH DVTT Digito Combat<br>MST: 0109816406</p>
			</div>
			<div>
				<h4>Dịch vụ</h4>
				<ul>
					<li><a href="#services">Lập trình website</a></li>
					<li><a href="#domains">Tên miền</a></li>
					<li><a href="#hosting">Hosting</a></li>
					<li><a href="#services">Bản quyền phần mềm</a></li>
					<li><a href="#services">Dịch vụ SEO / GEO</a></li>
					<li><a href="#services">Google Ads</a></li>
					<li><a href="#services">Automation workflow</a></li>
				</ul>
			</div>
			<div>
				<h4>Hỗ trợ</h4>
				<ul>
					<li><a href="#faq">Câu hỏi thường gặp</a></li>
					<li><a href="#">Hướng dẫn thanh toán</a></li>
					<li><a href="#">Chuyển tên miền</a></li>
					<li><a href="#">Quản lý dịch vụ</a></li>
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
			<span>Điều khoản &middot; Chính sách bảo mật</span>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
