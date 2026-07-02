<?php
/**
 * Trang cau hinh "Digicom" trong WP Admin.
 * Moi noi dung lien he + gia sua o day, khong cham code.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/* Default values - de trang chu day du ngay lan dau. */
function dgc_defaults() {
	return array(
		'hotline'       => '0988 769 317',
		'email'         => 'info@digicomvn.com',
		'address'       => 'Số 200, Đường 3.1, KĐT Gamuda Garden, P. Trần Phú, Q. Hoàng Mai, Hà Nội',
		'zalo'          => '0988769317',
		'working_hours' => 'Thứ 2 - Thứ 6, 8:00 - 18:00',

		'hero_title'    => 'Đăng ký tên miền và hosting giá tốt, kích hoạt ngay',
		'hero_sub'      => 'Kiểm tra tên miền bạn muốn, chọn gói hosting phù hợp. Đội ngũ Digicom hỗ trợ kỹ thuật tận tình từ lúc đăng ký đến khi vận hành.',

		// tld | gia/nam | nhan (tuy chon)
		'domain_tlds'   => ".com | 199.000đ | Phổ biến\n.vn | 250.000đ | Uy tín VN\n.com.vn | 150.000đ | \n.net | 230.000đ | \n.org | 230.000đ | \n.info | 90.000đ | Giá tốt\n.store | 70.000đ | \n.online | 60.000đ | ",

		// Khuyen mai noi bat (tieu de | mo ta ngan)
		'promos'        => ".VN từ 250K/năm | Khi đăng ký 3 năm\n.COM.VN từ 150K | Ưu đãi giới hạn\nHosting giảm 50% | Cho tháng đầu tiên\nTrọn gói tên miền và hosting | Tiết kiệm hơn khi mua cùng",

		// ten goi | gia | dac diem cach nhau dau ; | noi bat(1/0)
		'hosting_plans' => "Khởi đầu | 39.000đ/tháng | 1 GB SSD;1 website;Băng thông không giới hạn;SSL miễn phí;Sao lưu hàng tuần | 0\nDoanh nghiệp | 79.000đ/tháng | 5 GB SSD;5 website;Băng thông không giới hạn;SSL miễn phí;Sao lưu hàng ngày | 1\nChuyên nghiệp | 149.000đ/tháng | 15 GB SSD;Website không giới hạn;LiteSpeed cache;SSL miễn phí;Sao lưu hàng ngày | 0\nWordPress | 99.000đ/tháng | 10 GB SSD;Tối ưu cho WordPress;LiteSpeed và cache;SSL miễn phí;Tự động cập nhật | 0",

		// Ly do chon (tieu de | mo ta)
		'reasons'       => "Hạ tầng ổn định | Uptime cao, máy chủ tối ưu cho website tại Việt Nam\nKích hoạt tức thì | Tên miền và hosting sẵn sàng ngay sau khi thanh toán\nHỗ trợ 24/7 | Đội ngũ kỹ thuật trực qua hotline, Zalo và email\nGiá minh bạch | Niêm yết rõ ràng, không phí ẩn, gia hạn đúng giá ưu đãi",

		// FAQ (cau hoi | tra loi)
		'faqs'          => "Đăng ký tên miền cần giấy tờ gì? | Với tên miền quốc tế (.com, .net) chỉ cần email. Tên miền .vn cần bản khai theo quy định, Digicom hướng dẫn chi tiết từng bước.\nHosting có hỗ trợ WordPress không? | Có. Tất cả các gói đều chạy tốt WordPress; riêng gói WordPress được tối ưu sẵn cache và bảo mật.\nChuyển tên miền từ nhà cung cấp khác như thế nào? | Bạn cung cấp mã EPP, Digicom xử lý chuyển về trong 5 đến 7 ngày, website không bị gián đoạn.\nThanh toán bằng những hình thức nào? | Chuyển khoản ngân hàng, ví điện tử và quẹt thẻ. Dịch vụ kích hoạt ngay sau khi xác nhận thanh toán.",

		// Dich vu theo nhom. Dong bat dau bang # = ten nhom; dong con lai: ten | mo ta
		'services'      => "# Hạ tầng & Website\nLập trình website | Thiết kế và lập trình website theo yêu cầu, chuẩn SEO.\nTên miền | Đăng ký, gia hạn và quản lý tên miền .com, .vn và nhiều đuôi khác.\nHosting | Hosting SSD tốc độ cao, tối ưu sẵn cho WordPress.\n# Bản quyền phần mềm\nGoogle Workspace | Email theo tên miền và bộ ứng dụng làm việc của Google.\nMicrosoft Office 365 | Trọn bộ Office bản quyền kèm dung lượng đám mây.\nBản quyền Windows 11 | Key Windows 11 bản quyền, kích hoạt vĩnh viễn.\nPhần mềm bản quyền khác | cPanel, DirectAdmin, CloudLinux, LiteSpeed và nhiều phần mềm khác.\n# Marketing & SEO\nDịch vụ SEO / GEO | Tối ưu thứ hạng trên Google và các công cụ tìm kiếm AI.\nBacklink & Bài PR | Đặt backlink chất lượng và bài PR trên báo uy tín.\nGoogle Ads | Thiết lập và tối ưu quảng cáo Google, tăng chuyển đổi.\n# Tự động hóa\nAutomation workflow | Xây dựng quy trình tự động cho doanh nghiệp, tiết kiệm nhân lực.",

		// Khach hang noi ve (noi dung | nguoi/vai tro | dich vu)
		'testimonials'  => "Website luôn trực tuyến, đội ngũ hỗ trợ phản hồi nhanh kể cả ngoài giờ. | Chủ cửa hàng thương mại điện tử | Web Hosting\nĐăng ký và chuyển tên miền nhanh, giá rõ ràng, không phát sinh chi phí. | Quản lý IT doanh nghiệp | Tên miền\nEmail theo tên miền riêng giúp khách hàng tin tưởng hơn khi liên hệ. | Trưởng phòng kinh doanh | Email doanh nghiệp\nChuyển hosting sang Digicom rất mượt, tốc độ website cải thiện rõ rệt. | Founder startup công nghệ | Web Hosting\nGói hosting ổn định, kích hoạt ngay, phù hợp ngân sách doanh nghiệp nhỏ. | Chủ phòng khám | Web Hosting\nChứng chỉ SSL cài đặt nhanh, website hiện khóa bảo mật chỉ trong ngày. | Quản trị viên website | SSL",
	);
}

add_action( 'admin_menu', function () {
	add_menu_page( 'Digicom', 'Digicom', 'manage_options', 'dgc-settings', 'dgc_settings_page', 'dashicons-cloud', 59 );
} );

add_action( 'admin_init', function () {
	register_setting( 'dgc_group', 'dgc_settings', 'dgc_sanitize' );
} );

function dgc_sanitize( $in ) {
	$out = is_array( $in ) ? $in : array();
	foreach ( $out as $k => $v ) {
		// Cho phep xuong dong cho textarea, lam sach nhe.
		$out[ $k ] = is_string( $v ) ? wp_kses_post( $v ) : $v;
	}
	return $out;
}

function dgc_field( $key, $label, $hint = '', $type = 'text' ) {
	$o   = wp_parse_args( get_option( 'dgc_settings', array() ), dgc_defaults() );
	$val = isset( $o[ $key ] ) ? $o[ $key ] : '';
	echo '<tr><th style="vertical-align:top"><label for="' . esc_attr( $key ) . '">' . esc_html( $label ) . '</label></th><td>';
	if ( $type === 'textarea' ) {
		echo '<textarea id="' . esc_attr( $key ) . '" name="dgc_settings[' . esc_attr( $key ) . ']" rows="6" class="large-text code">' . esc_textarea( $val ) . '</textarea>';
	} else {
		echo '<input type="text" id="' . esc_attr( $key ) . '" name="dgc_settings[' . esc_attr( $key ) . ']" value="' . esc_attr( $val ) . '" class="regular-text" style="width:480px">';
	}
	if ( $hint ) echo '<p class="description">' . esc_html( $hint ) . '</p>';
	echo '</td></tr>';
}

function dgc_settings_page() {
	?>
	<div class="wrap">
		<h1>Cau hinh Digicom</h1>
		<p>Sua thong tin lien he, gia ten mien va goi hosting o day. Khong can dong vao code.</p>
		<form method="post" action="options.php">
			<?php settings_fields( 'dgc_group' ); ?>

			<h2>1. Lien he</h2>
			<table class="form-table">
				<?php
				dgc_field( 'hotline', 'Hotline' );
				dgc_field( 'email', 'Email' );
				dgc_field( 'zalo', 'So Zalo' );
				dgc_field( 'address', 'Dia chi' );
				dgc_field( 'working_hours', 'Gio lam viec' );
				?>
			</table>

			<h2>2. Hero (dau trang)</h2>
			<table class="form-table">
				<?php
				dgc_field( 'hero_title', 'Tieu de lon' );
				dgc_field( 'hero_sub', 'Mo ta phu', '', 'textarea' );
				?>
			</table>

			<h2>3. Ten mien</h2>
			<table class="form-table">
				<?php
				dgc_field( 'domain_tlds', 'Bang gia ten mien', 'Moi dong 1 duoi: duoi | gia | nhan. VD: .com | 199.000d | Pho bien', 'textarea' );
				dgc_field( 'promos', 'O khuyen mai', 'Moi dong: tieu de | mo ta', 'textarea' );
				?>
			</table>

			<h2>4. Hosting</h2>
			<table class="form-table">
				<?php
				dgc_field( 'hosting_plans', 'Goi hosting', 'Moi dong 1 goi: ten | gia | dac diem (cach nhau dau ;) | noi bat 1/0', 'textarea' );
				?>
			</table>

			<h2>5. Ly do chon & FAQ</h2>
			<table class="form-table">
				<?php
				dgc_field( 'reasons', 'Ly do chon Digicom', 'Moi dong: tieu de | mo ta', 'textarea' );
				dgc_field( 'faqs', 'Cau hoi thuong gap', 'Moi dong: cau hoi | tra loi', 'textarea' );
				?>
			</table>

			<h2>6. Dich vu & Danh gia khach hang</h2>
			<table class="form-table">
				<?php
				dgc_field( 'services', 'Dich vu theo nhom', 'Dong bat dau bang # = ten nhom. Cac dong khac: ten dich vu | mo ta ngan.', 'textarea' );
				dgc_field( 'testimonials', 'Khach hang noi ve Digicom', 'Moi dong: noi dung danh gia | nguoi/vai tro | dich vu', 'textarea' );
				?>
			</table>

			<?php submit_button( 'Luu thay doi' ); ?>
		</form>
	</div>
	<?php
}
