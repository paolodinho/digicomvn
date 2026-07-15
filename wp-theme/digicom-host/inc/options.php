<?php
/**
 * Trang cau hinh "DigicomVN" trong WP Admin.
 * Moi noi dung lien he + gia sua o day, khong cham code.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/* Default values - de trang chu day du ngay lan dau. */
function dgc_defaults() {
	return array(
		'hotline'       => '0988 769 317',
		'hotline2'      => '0775 031 895',
		'email'         => 'sales@digicomvn.com',
		'lead_email'    => 'hieudx3107@gmail.com',
		'address'       => 'Số 200, Đường 3.1, KĐT Gamuda Garden, P. Trần Phú, Q. Hoàng Mai, Hà Nội',
		'address2'      => 'Tầng 3, tòa nhà Thăng Long A1, đường Tây Cao Tốc, thôn Bầu, xã Kim Chung, huyện Đông Anh, Hà Nội',
		'zalo'          => '2806292509481772964',
		'working_hours' => 'Thứ 2 - Thứ 6, 8:00 - 18:00',

		'hero_title'    => 'Backlink, Guest Post, Textlink và Booking báo PR uy tín',
		'hero_sub'      => 'DigicomVN cung cấp trọn gói off-page SEO: mua textlink chất lượng, dịch vụ backlink an toàn, guest post đúng chủ đề và booking đăng bài PR trên các đầu báo lớn.',

		// Dai so lieu duoi hero. Moi dong: con so | nhan mo ta. Sua tu WP Admin khi mang luoi thay doi.
		'hero_stats'    => "500+ | đầu báo trong nước & quốc tế\n2.000+ | site guest post đa ngành\nBáo giá | minh bạch\nHỗ trợ | tư vấn tận tình\nXuất VAT | đầy đủ",

		// dich vu | gia tu | nhan (tuy chon) - hien o hero + trang bang gia
		// DEMO - gia minh hoa, can Hieu xac nhan gia that truoc khi cong khai chinh thuc
		'domain_tlds'   => "Mua Textlink | Từ 300.000đ/link | Theo DR/traffic\nDịch vụ Backlink | Từ 500.000đ/backlink | Theo khối lượng\nGuest Post | Từ 800.000đ/bài | Theo site đăng\nBooking báo & PR | Từ 700.000đ/bài | Theo đầu báo",

		// Chiet khau combo khi khach tick nhieu bao/site trong bang gia.
		// Moi dong: <so muc toi thieu>|<% giam>. Bac cao nhat dat duoc se duoc ap dung.
		'combo_discount' => "2|3\n4|5\n6|8\n10|12\n15|15",

		// Uu dai noi bat (tieu de | mo ta ngan | nhan uu dai). Nhan la cot thu 3, de trong duoc.
		'promos'        => "Viết bài PR miễn phí | Đặt từ 3 đầu báo trở lên, DigicomVN viết bài, bạn chỉ cần duyệt nội dung | Miễn phí trọn gói\nTư vấn và chọn báo miễn phí | Chuyên viên lên danh sách báo/site theo ngành hàng và ngân sách của bạn | Miễn phí, không ràng buộc\nƯu đãi combo nhiều đầu báo | Đặt càng nhiều mục trong một đơn, chiết khấu càng cao | Áp dụng tự động\nBáo giá minh bạch, không phí ẩn | Niêm yết theo từng đầu báo, xuất VAT đầy đủ | Cam kết bằng hợp đồng",

		// Khan hiem + gioi han thoi gian cho o uu dai (nguyen tac kich thich chuyen doi).
		// Han chot: de trong = tu lay het thang hien tai (luon con hieu luc, khong bao gio "qua han").
		'promo_title'    => 'Ưu đãi đang áp dụng',
		'promo_deadline' => '',
		'promo_slots'    => '10',

		// Quy uu dai ra TIEN (Hieu 2026-07-14) - con so phai co that, tinh duoc tu bang gia:
		// don 15 dau bao lon (gia trung binh dang ban ~8,2tr/bai) = ~123tr -> chiet khau combo bac
		// cao nhat 15% = ~18,4tr, cong 15 bai viet mien phi (~500k/bai) = ~7,5tr -> ~25tr.
		// Doi bac chiet khau hoac bang gia -> sua lai con so nay o WP Admin, khong sua PHP.
		// Ghi chu gia - hien o MOI noi co gia (bang gia, trang dich vu, bang gia rut gon trang chu).
		'price_note'        => 'Giá trên là giá tham khảo, có thể thay đổi vào phút chót theo bảng giá của toà soạn/nhà đài. Gọi hotline hoặc nhắn Zalo để nhận báo giá nhanh và chính xác nhất.',

		'promo_saving'      => '25 triệu',
		'promo_saving_note' => 'Đơn 15 đầu báo lớn: giảm 15% theo bậc combo + miễn phí viết 15 bài.',

		// ten goi | gia | dac diem cach nhau dau ; | noi bat(1/0)
		'hosting_plans' => "Gói Textlink | Liên hệ báo giá | Đặt link trong bài có sẵn;Chọn theo DR/traffic site;Vị trí link tự nhiên;Bàn giao vị trí đăng | 0\nGói Backlink | Liên hệ báo giá | Backlink chất lượng, đa dạng nguồn;Anchor text tự nhiên;Theo dõi index;Báo cáo chi tiết | 1\nGói Guest Post | Liên hệ báo giá | Viết bài + đăng trên site đúng chủ đề;Link dofollow tự nhiên;Duyệt nội dung trước khi đăng;Bàn giao link bài | 0\nGói Booking báo & PR | Liên hệ báo giá | Đăng bài PR trên báo điện tử;Viết bài chuẩn theo tôn chỉ báo;Hỗ trợ chọn chuyên mục;Bàn giao link bài đã lên | 0",

		// Ly do chon (tieu de | mo ta) - hien o section "Tai sao chon DigicomVN"
		'reasons'       => "Nguồn chọn lọc theo chỉ số thật | Chọn site và báo theo DR, traffic thật và đúng chủ đề, không đi link tràn lan.\nTextlink & backlink an toàn | Đặt link tự nhiên trong ngữ cảnh bài viết, hạn chế rủi ro thuật toán.\nGuest post đúng chủ đề | Bài viết chuẩn chủ đề, đăng trên site liên quan, link dofollow có giá trị.\nBooking báo thật | Chỉ đặt trên đầu báo, site có traffic và uy tín thật, hạn chế site rác.\nBáo giá minh bạch | Niêm yết theo từng dịch vụ, không phát sinh phí ẩn, xuất VAT đầy đủ.\nBàn giao rõ ràng | Báo cáo link/bài đã đăng kèm nguồn để đối chiếu sau khi hoàn thành.",

		// Trich dan noi bat o section "Tai sao chon DigicomVN": noi dung | ten nguoi | vai tro
		'why_quote'     => "Off-page SEO hiệu quả phải dựa trên dữ liệu và tự động hóa - AI giúp chọn đúng nguồn và đo đúng kết quả, thay vì đi link theo cảm tính. | Đỗ Xuân Hiếu | Giám đốc DigicomVN",

		// Logo khach hang tin tuong: ten thuong hieu | ten file logo trong /uploads/client-logos/ (rong = hien chu tam).
		// Ten la khach hang that (tu case study/testimonial). Logo Hieu bo sung sau.
		'clients'       => "Bệnh viện Việt Pháp Hà Nội | \nPhòng khám Đa khoa Quốc tế H Plus | \nICD Việt Nam | \nBệnh viện Mắt Hà Nội 2 | \nMagenest | \nZora | \nDodanong.com | ",

		// Bao chi noi ve DigicomVN: ten bao | link bai viet (co the de trong, bo sung sau) | ten file logo trong /uploads/press-logos/ (rong = hien chu).
		'press_mentions' => "Truyền hình An Giang | https://angiangtv.vn/tin-tuc-va-su-kien/digicomvn-ung-dung-ai-vao-dich-vu-truyen-thong-va-booking-bao-chi-giup-doanh-nghiep-tiet-kiem-chi-phi-van-hanh/ | \nBáo Đồng Nai | https://baodongnai.com.vn/doanh-nhan-doanh-nghiep/dich-vu/202607/quy-trinh-book-bao-chi-bai-ban-cach-digicomvn-dua-icd-viet-nam-tu-vang-bong-den-hien-dien-thuong-xuyen-tren-bao-chi-62102d3/ | \nVnExpress |  | vnexpress.png\nDân Trí |  | dantri.png\nTuổi Trẻ |  | tuoitre.png\nThanh Niên |  | thanhnien.png\nVietNamNet |  | vietnamnet.png\nVTV |  | vtv.png\nKenh14 |  | kenh14.png\nCafeF |  | cafef.png",

		// FAQ (cau hoi | tra loi)
		'faqs'          => "Textlink khác backlink như thế nào? | Textlink là link chèn vào bài viết đã có sẵn trên site khác; backlink là link trỏ về từ nhiều nguồn khác nhau (bài mới, site, diễn đàn...) theo chiến dịch tổng thể.\nGuest Post có được viết nội dung riêng không? | Có. DigicomVN viết bài theo đúng chủ đề site đăng, kèm link tự nhiên, gửi Hiếu duyệt trước khi đăng.\nBooking báo PR mất bao lâu để lên bài? | Tùy đầu báo, thường 2 đến 7 ngày làm việc sau khi nội dung được duyệt.\nThanh toán và bàn giao như thế nào? | Thanh toán theo báo giá đã thống nhất, bàn giao link/bài đã lên kèm báo cáo sau khi hoàn thành.",

		// Dich vu theo nhom. Dong bat dau bang # = ten nhom; dong con lai: ten | mo ta
		'services'      => "# Mua Textlink\nTextlink theo DR/Traffic | Chèn link trong bài có sẵn trên site đã chọn lọc theo chỉ số.\nTextlink theo ngành hàng | Ưu tiên site cùng lĩnh vực để tăng độ liên quan.\n# Dịch vụ Backlink\nBacklink chất lượng | Xây dựng hệ thống backlink tự nhiên, đa nguồn.\nBacklink theo ngách | Backlink chuyên biệt cho từng lĩnh vực, ví dụ bất động sản.\n# Guest Post\nGuest Post trọn gói | Viết bài và đăng trên site đúng chủ đề, có link dofollow.\nGuest Post theo site khách chọn | Đăng trên site do khách hàng chỉ định (nếu đủ điều kiện).\n# Booking báo & PR\nBooking đăng bài PR | Đặt lịch đăng bài PR trên báo điện tử theo yêu cầu.\nViết bài PR chuẩn báo chí | Viết bài đúng văn phong, tôn chỉ từng đầu báo.",

		// Khach hang noi ve (noi dung | nguoi/vai tro | dich vu). Ten chi la vi du minh hoa,
		// CHUA phai khach hang that xac nhan - can thay bang ten/feedback that khi Hieu cung cap.
		'testimonials'  => "Link bàn giao đúng như báo giá, có báo cáo rõ ràng để đối chiếu. | Anh Đức - Trưởng phòng Marketing | Dịch vụ Backlink\nBài guest post lên đúng site đã chọn, nội dung tự nhiên không lộ quảng cáo. | Chị Lan - Chủ doanh nghiệp SME | Guest Post\nBooking báo nhanh, hỗ trợ chọn chuyên mục phù hợp ngành hàng. | Chị Hoa - Quản lý truyền thông | Booking báo & PR\nTextlink đặt đúng vị trí, site có traffic thật chứ không phải site rác. | Anh Minh - SEO Specialist | Mua Textlink",

		// Case study khach hang that (tieu de | ket qua/so lieu | dich vu | ten khach hang - tuy chon).
		// RONG mac dinh - CHUA co du lieu that, KHONG bia so lieu. Hieu dien qua WP Admin khi co du lieu.
		'case_studies'  => "",

		// Dau bao DigicomVN co the dat bai/booking. Moi dong: ten bao | ten file logo trong /uploads/press-logos/ (rong = chua co logo).
		// Nguon: bang gia CPT dgc_gia that. Logo tai that tu website tung bao 2026-07-03, bo sung 5 bao 2026-07-06.
		'press_partners' => "VnExpress | vnexpress.png\nDân Trí | dantri.png\nTuổi Trẻ | tuoitre.png\nThanh Niên | thanhnien.png\nVietNamNet | vietnamnet.png\nLao Động | laodong.png\nTiền Phong | tienphong.png\nVOV | vov.png\nVTV | vtv.png\nNhân Dân | nhandan.png\nKenh14 | kenh14.png\n24h | tw24h.png\nCafeF | cafef.png\nZing News | znews.png\nSoha | soha.png\nNgười Đưa Tin | nguoiduatin.png\nAfamily | afamily.png\nEva | eva.png\nCafeBiz | cafebiz.png\nWebtretho | webtretho.png\nBáo Đầu Tư | baodautu.png",
	);
}

add_action( 'admin_menu', function () {
	add_menu_page( 'DigicomVN', 'DigicomVN', 'manage_options', 'dgc-settings', 'dgc_settings_page', 'dashicons-cloud', 59 );
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
		<h1>Cau hinh DigicomVN</h1>
		<p>Sua thong tin lien he, gia va goi dich vu (Textlink, Backlink, Guest Post, Booking bao PR) o day. Khong can dong vao code.</p>
		<form method="post" action="options.php">
			<?php settings_fields( 'dgc_group' ); ?>

			<h2>1. Lien he</h2>
			<table class="form-table">
				<?php
				dgc_field( 'hotline', 'Hotline 1' );
				dgc_field( 'hotline2', 'Hotline 2', 'De trong neu chi dung 1 hotline.' );
				dgc_field( 'email', 'Email (hien thi cong khai tren site)' );
				dgc_field( 'lead_email', 'Email nhan lead form (khong hien thi cong khai)' );
				dgc_field( 'zalo', 'So Zalo' );
				dgc_field( 'address', 'Tru so (dia chi dang ky kinh doanh)' );
				dgc_field( 'address2', 'Van phong giao dich', 'De trong neu chi co tru so.' );
				dgc_field( 'working_hours', 'Gio lam viec' );
				?>
			</table>

			<h2>2. Hero (dau trang)</h2>
			<table class="form-table">
				<?php
				dgc_field( 'hero_title', 'Tieu de lon' );
				dgc_field( 'hero_sub', 'Mo ta phu', '', 'textarea' );
				dgc_field( 'hero_stats', 'Dai so lieu duoi hero', 'Moi dong: con so | nhan mo ta (vd: 500+ | dau bao trong nuoc va quoc te). Toi da 5 dong. Chi ghi so lieu THAT.', 'textarea' );
				?>
			</table>

			<h2>3. Bang gia 4 dich vu (hien o trang chu + trang Bang gia)</h2>
			<table class="form-table">
				<?php
				dgc_field( 'domain_tlds', 'Bang gia rut gon', 'Moi dong: ten dich vu | gia tu | nhan. VD: Mua Textlink | Lien he bao gia | Theo DR/traffic', 'textarea' );
				dgc_field( 'promos', 'O uu dai', 'Moi dong: tieu de | mo ta | nhan uu dai (cot 3 co the de trong). VD: Viet bai PR mien phi | Dat tu 3 dau bao tro len | Mien phi tron goi', 'textarea' );
				dgc_field( 'promo_title', 'Tieu de khoi uu dai', 'VD: Uu dai thang 7' );
				dgc_field( 'promo_deadline', 'Han chot uu dai (yyyy-mm-dd)', 'De TRONG = tu dong lay het thang hien tai (uu dai luon con hieu luc). Dien ngay cu the neu chay dot khuyen mai co han rieng.' );
				dgc_field( 'promo_slots', 'So suat con lai trong dot', 'So suat uu dai con lai - tao cam giac khan hiem. De TRONG hoac 0 = khong hien dong nay. Chi ghi con so THAT dinh nhan.' );
				dgc_field( 'price_note', 'Ghi chu gia (hien o MOI noi co gia)', 'Bat buoc: noi ro gia la GIA THAM KHAO, co the doi vao phut chot, moi khach goi/nhan Zalo de chot gia. De TRONG = an ghi chu (khong khuyen khich).', 'textarea' );
				dgc_field( 'promo_saving', 'Uu dai quy ra tien (so tien tiet kiem toi da)', 'VD "25 trieu". Hien noi bat trong khoi uu dai + popup. De TRONG = an dong nay. Con so phai tinh duoc tu bang gia + bac chiet khau, KHONG ghi bua.' );
				dgc_field( 'promo_saving_note', 'Giai thich con so tren', 'VD: Don 15 dau bao lon: giam 15% theo bac combo + mien phi viet 15 bai.' );
				dgc_field( 'combo_discount', 'Chiet khau combo (tick nhieu bao cang giam)', 'Moi dong: <so muc toi thieu>|<% giam>. VD "4|5" = tu 4 muc tro len giam 5%. Bac cao nhat dat duoc se ap dung. De trong = khong giam.', 'textarea' );
				?>
			</table>

			<h2>4. Goi dich vu chi tiet</h2>
			<table class="form-table">
				<?php
				dgc_field( 'hosting_plans', 'Goi dich vu', 'Moi dong 1 goi: ten | gia | dac diem (cach nhau dau ;) | noi bat 1/0', 'textarea' );
				?>
			</table>

			<h2>5. Tai sao chon DigicomVN & FAQ</h2>
			<table class="form-table">
				<?php
				dgc_field( 'reasons', 'Ly do chon DigicomVN (cards)', 'Moi dong: tieu de | mo ta. Hien o section "Tai sao chon DigicomVN".', 'textarea' );
				dgc_field( 'why_quote', 'Trich dan noi bat', 'Mot dong: noi dung trich dan | ten nguoi | vai tro. De trong neu khong muon hien.', 'textarea' );
				dgc_field( 'faqs', 'Cau hoi thuong gap', 'Moi dong: cau hoi | tra loi', 'textarea' );
				?>
			</table>

			<h2>5b. Logo khach hang & Bao chi noi ve DigicomVN</h2>
			<table class="form-table">
				<?php
				dgc_field( 'clients', 'Logo khach hang tin tuong', 'Moi dong: ten thuong hieu | ten file logo (dat trong wp-content/uploads/client-logos/, de trong = hien chu tam). Chi liet ke khach hang that.', 'textarea' );
				dgc_field( 'press_mentions', 'Bao chi noi ve DigicomVN', 'Moi dong: ten bao | link bai viet (de trong neu chua co link, bo sung sau) | ten file logo (dung chung kho wp-content/uploads/press-logos/, de trong = hien chu). Co link -> bam doc bai duoc; chua link -> chi hien logo. Chi liet ke bao that su co ghi nhan/dang bai ve DigicomVN.', 'textarea' );
				?>
			</table>

			<h2>6. Dich vu & Danh gia khach hang</h2>
			<table class="form-table">
				<?php
				dgc_field( 'services', 'Dich vu theo nhom', 'Dong bat dau bang # = ten nhom. Cac dong khac: ten dich vu | mo ta ngan.', 'textarea' );
				dgc_field( 'testimonials', 'Khach hang noi ve DigicomVN', 'Moi dong: noi dung danh gia | nguoi/vai tro | dich vu', 'textarea' );
				dgc_field( 'case_studies', 'Case study khach hang that', 'Moi dong: tieu de | ket qua/so lieu | dich vu | ten khach hang (tuy chon). Chi dien khi co du lieu that, KHONG bia.', 'textarea' );
				?>
			</table>

			<h2>7. Dau bao co the dat bai (hien o trang chu)</h2>
			<table class="form-table">
				<?php
				dgc_field( 'press_partners', 'Danh sach dau bao', 'Moi dong: ten bao | ten file logo (dat trong wp-content/uploads/press-logos/, de trong neu chua co logo). Chi liet ke bao DigicomVN that su dat/booking bai duoc, khong bia.', 'textarea' );
				?>
			</table>

			<?php submit_button( 'Luu thay doi' ); ?>
		</form>
	</div>
	<?php
}
