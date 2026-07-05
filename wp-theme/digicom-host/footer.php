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
				<p style="font-size:13px;color:#8aa0b7">Công ty TNHH Dịch vụ Truyền thông Digito Combat<br>MST: 0109816406</p>
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
					<li>Hotline: <a href="tel:<?php echo esc_attr( dgc_tel() ); ?>"><strong style="color:#fff"><?php echo esc_html( dgc( 'hotline' ) ); ?></strong></a><?php if ( dgc( 'hotline2' ) ) : ?> &middot; <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9]/', '', dgc( 'hotline2' ) ) ); ?>"><strong style="color:#fff"><?php echo esc_html( dgc( 'hotline2' ) ); ?></strong></a><?php endif; ?></li>
					<li>Email: <a href="mailto:<?php echo esc_attr( dgc( 'email' ) ); ?>"><?php echo esc_html( dgc( 'email' ) ); ?></a></li>
					<li>VP1: <?php echo esc_html( dgc( 'address' ) ); ?></li>
					<?php if ( dgc( 'address2' ) ) : ?><li>VP2: <?php echo esc_html( dgc( 'address2' ) ); ?></li><?php endif; ?>
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
