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
		'hotline2'      => '0775 031 895',
		'email'         => 'info@digicomvn.com',
		'address'       => 'Số 200, Đường 3.1, KĐT Gamuda Garden, P. Trần Phú, Q. Hoàng Mai, Hà Nội',
		'address2'      => 'Tầng 3, Toà nhà Thăng Long A1 Thiên Lộc, Hà Nội (Kim Chung, Đông Anh cũ)',
		'zalo'          => '0988769317',
		'working_hours' => 'Thứ 2 - Thứ 6, 8:00 - 18:00',

		'hero_title'    => 'Backlink, Guest Post, Textlink và Booking báo PR uy tín',
		'hero_sub'      => 'Digicom cung cấp trọn gói off-page SEO: mua textlink chất lượng, dịch vụ backlink an toàn, guest post đúng chủ đề và booking đăng bài PR trên các đầu báo lớn.',

		// dich vu | gia tu | nhan (tuy chon) - hien o hero + trang bang gia
		// DEMO - gia minh hoa, can Hieu xac nhan gia that truoc khi cong khai chinh thuc
		'domain_tlds'   => "Mua Textlink | Từ 300.000đ/link | Theo DR/traffic\nDịch vụ Backlink | Từ 500.000đ/backlink | Theo khối lượng\nGuest Post | Từ 800.000đ/bài | Theo site đăng\nBooking báo & PR | Từ 700.000đ/bài | Theo đầu báo",

		// Khuyen mai noi bat (tieu de | mo ta ngan)
		'promos'        => "Báo giá theo từng đầu báo | Minh bạch, không phí ẩn\nGói combo Backlink + Guest Post | Tiết kiệm hơn khi đặt cùng lúc\nTư vấn miễn phí | Chọn đúng site/báo theo ngành hàng\nCam kết đúng tiến độ | Báo cáo link/bài đã lên sau khi hoàn thành",

		// ten goi | gia | dac diem cach nhau dau ; | noi bat(1/0)
		'hosting_plans' => "Gói Textlink | Liên hệ báo giá | Đặt link trong bài có sẵn;Chọn theo DR/traffic site;Vị trí link tự nhiên;Bàn giao vị trí đăng | 0\nGói Backlink | Liên hệ báo giá | Backlink chất lượng, đa dạng nguồn;Anchor text tự nhiên;Theo dõi index;Báo cáo chi tiết | 1\nGói Guest Post | Liên hệ báo giá | Viết bài + đăng trên site đúng chủ đề;Link dofollow tự nhiên;Duyệt nội dung trước khi đăng;Bàn giao link bài | 0\nGói Booking báo & PR | Liên hệ báo giá | Đăng bài PR trên báo điện tử;Viết bài chuẩn theo tôn chỉ báo;Hỗ trợ chọn chuyên mục;Bàn giao link bài đã lên | 0",

		// Ly do chon (tieu de | mo ta)
		'reasons'       => "Nguồn site/báo chọn lọc | Ưu tiên site có traffic thật, báo uy tín, hạn chế site rác\nBáo giá minh bạch | Niêm yết theo từng dịch vụ, không phát sinh phí ẩn\nHỗ trợ tư vấn | Chọn đúng site/báo theo ngành hàng và ngân sách\nBàn giao rõ ràng | Báo cáo link/bài đã đăng, theo dõi index sau khi lên",

		// FAQ (cau hoi | tra loi)
		'faqs'          => "Textlink khác backlink như thế nào? | Textlink là link chèn vào bài viết đã có sẵn trên site khác; backlink là link trỏ về từ nhiều nguồn khác nhau (bài mới, site, diễn đàn...) theo chiến dịch tổng thể.\nGuest Post có được viết nội dung riêng không? | Có. Digicom viết bài theo đúng chủ đề site đăng, kèm link tự nhiên, gửi Hiếu duyệt trước khi đăng.\nBooking báo PR mất bao lâu để lên bài? | Tùy đầu báo, thường 2 đến 7 ngày làm việc sau khi nội dung được duyệt.\nThanh toán và bàn giao như thế nào? | Thanh toán theo báo giá đã thống nhất, bàn giao link/bài đã lên kèm báo cáo sau khi hoàn thành.",

		// Dich vu theo nhom. Dong bat dau bang # = ten nhom; dong con lai: ten | mo ta
		'services'      => "# Mua Textlink\nTextlink theo DR/Traffic | Chèn link trong bài có sẵn trên site đã chọn lọc theo chỉ số.\nTextlink theo ngành hàng | Ưu tiên site cùng lĩnh vực để tăng độ liên quan.\n# Dịch vụ Backlink\nBacklink chất lượng | Xây dựng hệ thống backlink tự nhiên, đa nguồn.\nBacklink theo ngách | Backlink chuyên biệt cho từng lĩnh vực, ví dụ bất động sản.\n# Guest Post\nGuest Post trọn gói | Viết bài và đăng trên site đúng chủ đề, có link dofollow.\nGuest Post theo site khách chọn | Đăng trên site do khách hàng chỉ định (nếu đủ điều kiện).\n# Booking báo & PR\nBooking đăng bài PR | Đặt lịch đăng bài PR trên báo điện tử theo yêu cầu.\nViết bài PR chuẩn báo chí | Viết bài đúng văn phong, tôn chỉ từng đầu báo.",

		// Khach hang noi ve (noi dung | nguoi/vai tro | dich vu)
		'testimonials'  => "Link bàn giao đúng như báo giá, có báo cáo rõ ràng để đối chiếu. | Trưởng phòng Marketing | Dịch vụ Backlink\nBài guest post lên đúng site đã chọn, nội dung tự nhiên không lộ quảng cáo. | Chủ doanh nghiệp SME | Guest Post\nBooking báo nhanh, hỗ trợ chọn chuyên mục phù hợp ngành hàng. | Quản lý truyền thông | Booking báo & PR\nTextlink đặt đúng vị trí, site có traffic thật chứ không phải site rác. | SEO Specialist | Mua Textlink",

		// Dau bao Digicom co the dat bai/booking. Moi dong: ten bao | ten file logo trong /uploads/press-logos/ (rong = chua co logo).
		// Nguon: bang gia CPT dgc_gia that. Logo tai that tu website tung bao 2026-07-03.
		'press_partners' => "VnExpress | vnexpress.png\nDân Trí | dantri.png\nTuổi Trẻ | tuoitre.png\nThanh Niên | thanhnien.png\nVietNamNet | vietnamnet.png\nLao Động | laodong.png\nTiền Phong | tienphong.png\nVOV | vov.png\nVTV | vtv.png\nNhân Dân | nhandan.png\nKenh14 | kenh14.png\n24h | tw24h.png\nCafeF | cafef.png\nZing News | znews.png\nSoha | soha.png\nNgười Đưa Tin | nguoiduatin.png",
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
		<p>Sua thong tin lien he, gia va goi dich vu (Textlink, Backlink, Guest Post, Booking bao PR) o day. Khong can dong vao code.</p>
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

			<h2>3. Bang gia 4 dich vu (hien o trang chu + trang Bang gia)</h2>
			<table class="form-table">
				<?php
				dgc_field( 'domain_tlds', 'Bang gia rut gon', 'Moi dong: ten dich vu | gia tu | nhan. VD: Mua Textlink | Lien he bao gia | Theo DR/traffic', 'textarea' );
				dgc_field( 'promos', 'O khuyen mai', 'Moi dong: tieu de | mo ta', 'textarea' );
				?>
			</table>

			<h2>4. Goi dich vu chi tiet</h2>
			<table class="form-table">
				<?php
				dgc_field( 'hosting_plans', 'Goi dich vu', 'Moi dong 1 goi: ten | gia | dac diem (cach nhau dau ;) | noi bat 1/0', 'textarea' );
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

			<h2>7. Dau bao co the dat bai (hien o trang chu)</h2>
			<table class="form-table">
				<?php
				dgc_field( 'press_partners', 'Danh sach dau bao', 'Moi dong: ten bao | ten file logo (dat trong wp-content/uploads/press-logos/, de trong neu chua co logo). Chi liet ke bao Digicom that su dat/booking bai duoc, khong bia.', 'textarea' );
				?>
			</table>

			<?php submit_button( 'Luu thay doi' ); ?>
		</form>
	</div>
	<?php
}
