<?php
/**
 * Nhom dich vu website (mo 2026-10-30, Hieu: "them dich vu lien quan den website, dich vu web/SEO
 * cua nguon dai ly co gi thi be ve"). Dung chung template tpl-web.php.
 * - Bang gia: option 'web_gia_<slug>' (WP Admin > DigicomVN > muc 12). De trong = bang mac dinh duoi day.
 *   Moi dong: nhom | ten goi | gia | don vi (vd /thang, /nam, /user/thang, /website) | gia goc gach ngang | thong so 1; thong so 2; ...
 * - Gia mac dinh tinh theo san lai 10% (Hieu 30/10): nhom dai ly chiet khau >= 10% ban bang gia niem yet ban le (+2% dem),
 *   nhom chiet khau 2-3% (cloud, Google Workspace, Microsoft 365, cham soc web, Bo Cong Thuong) = gia niem yet x 1,08.
 * - KHONG ghi ten nha cung cap o bat ky dau (rule bao-gia-khong-lo-gia-von).
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function dgc_web_svc_list() {
	return array(
		'thiet-ke-website'              => 'Thiết kế website',
		'cham-soc-website'              => 'Chăm sóc website',
		'dang-ky-website-bo-cong-thuong' => 'Đăng ký website với Bộ Công Thương',
		'email-doanh-nghiep'            => 'Email doanh nghiệp',
		'chung-chi-ssl'                 => 'Chứng chỉ SSL',
		'cloud-server'                  => 'Cloud server (VPS)',
	);
}

function dgc_web_default_rows( $slug ) {
	$d = array(
		'email-doanh-nghiep' => "Email theo tên miền riêng | Email Pro 1 | 30000 | /tháng | | 3 GB SSD; 5 hộp thư; 5 chuyển tiếp\n"
			. "Email theo tên miền riêng | Email Pro 2 | 71000 | /tháng | | 10 GB SSD; 20 hộp thư; 1 tên miền phụ\n"
			. "Email theo tên miền riêng | Email Pro 3 | 132000 | /tháng | | 25 GB SSD; 60 hộp thư; 2 tên miền phụ\n"
			. "Email theo tên miền riêng | Email Pro 4 | 234000 | /tháng | | 80 GB SSD; 120 hộp thư; 3 tên miền phụ\n"
			. "Email theo tên miền riêng | Email Pro 5 | 387000 | /tháng | | 150 GB SSD; 250 hộp thư; 4 tên miền phụ\n"
			. "Email theo tên miền riêng | Email Pro 6 | 489000 | /tháng | | 200 GB SSD; 350 hộp thư; 6 tên miền phụ\n"
			. "Email theo tên miền riêng | Email Pro 7 | 662000 | /tháng | | 250 GB SSD; 500 hộp thư; 10 tên miền phụ\n"
			. "Email theo tên miền riêng | Email Pro 8 | 815000 | /tháng | | 350 GB SSD; 700 hộp thư; 20 tên miền phụ\n"
			. "Email theo tên miền riêng | Email Pro 9 | 2040000 | /tháng | | 500 GB SSD; không giới hạn hộp thư; 40 tên miền phụ\n"
			. "Email theo tên miền riêng | Email Pro 10 | 3570000 | /tháng | | 1 TB SSD; không giới hạn hộp thư; 60 tên miền phụ\n"
			. "Google Workspace | Business Starter | 90000 | /user/tháng | | 30 GB/user; Gmail, Lịch, Meet 100 người; Docs, Sheets\n"
			. "Google Workspace | Business Standard | 238000 | /user/tháng | | 2 TB/user; Meet 150 người, ghi hình; Gemini trong Gmail, Docs\n"
			. "Microsoft 365 | Exchange Online Plan 1 | 146000 | /user/tháng | | Chỉ email Outlook; hộp thư 50 GB\n"
			. "Microsoft 365 | Business Basic | 107000 | /user/tháng | | Outlook, Teams; Word, Excel bản web; OneDrive 1 TB\n"
			. "Microsoft 365 | Business Standard | 302000 | /user/tháng | | Office cài máy tính; Outlook, Teams; OneDrive 1 TB\n"
			. "Microsoft 365 | Business Premium | 593000 | /user/tháng | | Như Standard; thêm bảo mật nâng cao, quản lý thiết bị",
		'chung-chi-ssl' => "SSL xác thực tên miền (DV) | Positive SSL | 221000 | /năm | | 1 tên miền; cấp trong vài phút; khoá bảo mật trên trình duyệt\n"
			. "SSL xác thực tên miền (DV) | Essential SSL | 551000 | /năm | | 1 tên miền; bảo hiểm cao hơn Positive\n"
			. "SSL xác thực tên miền (DV) | Positive SSL Multi Domain | 1359000 | /năm | | Nhiều tên miền trên 1 chứng chỉ\n"
			. "SSL xác thực tên miền (DV) | Positive SSL Wildcard | 2228000 | /năm | | Tên miền chính và mọi tên miền phụ *.tenmien\n"
			. "SSL xác thực tên miền (DV) | Essential SSL Wildcard | 3672000 | /năm | | Mọi tên miền phụ; bảo hiểm cao\n"
			. "SSL xác thực doanh nghiệp (OV, EV) | Instant SSL (OV) | 1922000 | /năm | | Xác thực pháp nhân; hiện tên công ty trong chi tiết chứng chỉ\n"
			. "SSL xác thực doanh nghiệp (OV, EV) | Premium SSL Wildcard (OV) | 5202000 | /năm | | Xác thực pháp nhân; mọi tên miền phụ\n"
			. "SSL xác thực doanh nghiệp (OV, EV) | EV SSL | 3733000 | /năm | | Xác thực mở rộng, mức tin cậy cao nhất cho website thanh toán\n"
			. "SSL xác thực doanh nghiệp (OV, EV) | EV SSL Multi Domain | 7344000 | /năm | | Xác thực mở rộng cho nhiều tên miền",
		'cloud-server' => "Cloud server | Cloud 0 | 98000 | /tháng | | 1 vCPU; 1 GB RAM; 20 GB SSD; băng thông không giới hạn; 1 IP riêng\n"
			. "Cloud server | Cloud 1 | 184000 | /tháng | | 2 vCPU; 1,5 GB RAM; 40 GB SSD; 1 IP riêng\n"
			. "Cloud server | Cloud 2 | 346000 | /tháng | | 4 vCPU; 4 GB RAM; 60 GB SSD; 1 IP riêng\n"
			. "Cloud server | Cloud 3 | 497000 | /tháng | | 6 vCPU; 6 GB RAM; 80 GB SSD; 1 IP riêng\n"
			. "Cloud server | Cloud 4 | 692000 | /tháng | | 8 vCPU; 8 GB RAM; 120 GB SSD; 1 IP riêng\n"
			. "Cloud server | Cloud 5 | 940000 | /tháng | | 9 vCPU; 10 GB RAM; 200 GB SSD; 1 IP riêng\n"
			. "Cloud server | Cloud 6 | 1232000 | /tháng | | 10 vCPU; 12 GB RAM; 300 GB SSD; 1 IP riêng\n"
			. "Cloud server | Cloud 7 | 1523000 | /tháng | | 11 vCPU; 14 GB RAM; 400 GB SSD; 1 IP riêng",
		'cham-soc-website' => "Gói chăm sóc website | Cơ bản | 1620000 | /tháng | | Cập nhật nội dung 10 lần/tháng; 3 banner/tháng; tối ưu SEO cơ bản; giám sát bảo mật, tốc độ hằng tháng\n"
			. "Gói chăm sóc website | Nâng cao | 2700000 | /tháng | | Cập nhật nội dung 15 lần/tháng; quản lý 100 sản phẩm/tháng; 5 banner/tháng; kiểm tra SEO, bảo mật chuyên sâu\n"
			. "Gói chăm sóc website | Toàn diện | 4320000 | /tháng | | Cập nhật nội dung 20 lần/tháng; quản lý 250 sản phẩm/tháng; 9 banner/tháng; tối ưu SEO, bảo mật hằng tuần",
		'dang-ky-website-bo-cong-thuong' => "Thủ tục website thương mại điện tử | Thông báo website bán hàng (UBND tỉnh xác nhận) | 2160000 | /website | | Rà website, sửa chân trang và trang chính sách; soạn Tờ khai Mẫu số 01; nộp trên Cổng Dịch vụ công quốc gia; xử lý yêu cầu làm rõ; gắn biểu tượng xác nhận\n"
			. "Thủ tục website thương mại điện tử | Đăng ký sàn, nền tảng trung gian với Bộ Công Thương | | | | Sàn giao dịch, nền tảng cho người khác bán hàng; báo giá theo hồ sơ",
		'thiet-ke-website' => '',
	);
	return $d[ $slug ] ?? '';
}

/** Bang gia theo nhom: option web_gia_<slug> neu co, khong thi mac dinh. */
function dgc_web_rows( $slug ) {
	$raw = trim( (string) dgc( 'web_gia_' . str_replace( '-', '_', $slug ), '' ) );
	if ( '0' === $raw ) return array();
	if ( '' === $raw ) $raw = dgc_web_default_rows( $slug );
	$out = array();
	foreach ( preg_split( '/\r\n|\r|\n/', $raw ) as $line ) {
		$l = array_map( 'trim', explode( '|', $line ) );
		if ( count( $l ) < 2 || '' === $l[1] ) continue;
		$out[ $l[0] ][] = array(
			'goi'  => $l[1],
			'gia'  => (int) preg_replace( '/\D/', '', $l[2] ?? '' ),
			'dv'   => $l[3] ?? '',
			'goc'  => (int) preg_replace( '/\D/', '', $l[4] ?? '' ),
			'spec' => array_values( array_filter( array_map( 'trim', explode( ';', $l[5] ?? '' ) ) ) ),
		);
	}
	return $out;
}

/**
 * Noi dung tung trang (de-slop 30/10/2026): hero (eyebrow, lead), phan "story" (doan van that + 1 anh/the so lieu that),
 * phan "extra" (bang so sanh, moc thoi gian, danh sach loi thuong gap). So lieu deu co nguon, link nguon nam trong doan van.
 * Anh chup nguoi la anh minh hoa, KHONG ghi "doi ngu DigicomVN" (chua co anh doi ngu that).
 */
function dgc_web_svc_conf( $slug ) {
	$c = array(
		'thiet-ke-website' => array(
			'eyebrow' => 'Thiết kế website',
			'lead'    => 'Website WordPress dựng riêng theo thương hiệu, sơ đồ trang lập từ nghiên cứu từ khoá, đo tốc độ trên điện thoại trước khi bàn giao. Mọi nội dung sửa được trong trang quản trị, tên miền đứng tên doanh nghiệp.',
			'price_h' => '',
			'story_eyebrow' => 'Cách chúng tôi làm',
			'story_h' => 'Đo tốc độ trước khi bàn giao, không hứa bằng lời',
			'story'   => '<p>Trước ngày bàn giao, chúng tôi đo website trên điện thoại theo ba chỉ số Google dùng để chấm trải nghiệm trang: nội dung chính hiện ra trong 2,5 giây (LCP), bố cục không xô lệch quá 0,1 (CLS), phản hồi thao tác bấm dưới 200 mili giây (INP). Chưa đạt thì chưa giao. Thẻ bên cạnh là số đo chính trang chủ digicomvn.com, website do chúng tôi tự dựng và vận hành.</p>'
				. '<p>Phần quyết định khách có tìm thấy bạn trên Google lại nằm ở chỗ người xem không thấy. Chúng tôi làm ngược thứ tự quen thuộc: xem các trang đang đứng top cho nhóm từ khoá của bạn trước, dựng sơ đồ trang theo đó, rồi mới vẽ giao diện. Website ra mắt đã có chỗ cho từng nhóm từ khoá, không phải đập đi làm lại sau vài tháng.</p>'
				. '<p>Ngưỡng các chỉ số theo <a href="https://web.dev/articles/vitals" target="_blank" rel="noopener">tài liệu Core Web Vitals của Google</a>.</p>',
			'img' => array( 'src' => 'ws-toc-do-digicomvn.webp', 'w' => 1600, 'h' => 853, 'alt' => 'Số đo tốc độ trang chủ digicomvn.com trên điện thoại: LCP 0,62 giây, CLS 0,003, phản hồi máy chủ 0,23 giây', 'cap' => 'Số đo thật trang chủ digicomvn.com trên điện thoại (khung 390px), trung vị 3 lần đo, ngày 30/10/2026.' ),
			'extra_eyebrow' => 'Lịch làm việc',
			'extra_h' => 'Từ buổi khảo sát tới ngày bàn giao',
			'extra'   => '<ol class="ws-time">'
				. '<li><em>Tuần 1</em><b>Khảo sát, nghiên cứu từ khoá</b>Trao đổi sản phẩm, khách hàng, đối thủ. Chúng tôi gửi sơ đồ trang kèm nhóm từ khoá cho từng trang để bạn duyệt.</li>'
				. '<li><em>Tuần 2</em><b>Hai trang mẫu</b>Dựng giao diện trang chủ và một trang con. Sửa theo góp ý tới khi bạn đồng ý mới lập trình tiếp.</li>'
				. '<li><em>Tuần 2 đến 4</em><b>Lập trình, nhập nội dung</b>Dựng toàn bộ trang, cài SEO kỹ thuật (sitemap, schema, thẻ meta), kiểm tra trên điện thoại và máy tính.</li>'
				. '<li><em>Bàn giao</em><b>Quyền quản trị thuộc về bạn</b>Tài khoản quản trị, tên miền đứng tên doanh nghiệp, bảng số đo tốc độ, sitemap đã gửi Google Search Console, tài liệu hướng dẫn sửa nội dung.</li>'
				. '</ol>'
				. '<p>Lịch trên áp dụng cho website giới thiệu khoảng 10 đến 15 trang; website bán hàng nhiều sản phẩm sẽ chốt lịch riêng trong hợp đồng. Website có giỏ hàng hoặc nút đặt mua phải thông báo với Sở Công Thương nơi đặt trụ sở, xem <a href="/dang-ky-website-bo-cong-thuong/">thủ tục thông báo website</a>.</p>',
		),
		'cham-soc-website' => array(
			'eyebrow' => 'Chăm sóc website',
			'lead'    => 'Một đầu mối nhận yêu cầu qua Zalo, cập nhật nội dung, sản phẩm, banner, giữ WordPress và plugin luôn mới, sao lưu định kỳ, gửi báo cáo cuối tháng. Nhận cả website WordPress do đơn vị khác làm.',
			'price_h' => 'Bảng giá chăm sóc website',
			'story_eyebrow' => 'Một tháng chăm sóc gồm gì',
			'story_h' => 'Phần lớn việc chăm sóc là việc nhỏ, nhưng phải làm đều',
			'story'   => '<p>Website doanh nghiệp hay đứng yên sau ngày ra mắt: tin tức dừng ở năm khai trương, giá cũ, plugin báo cập nhật hàng chục bản. Khách vào thấy vậy thường nghĩ công ty không còn hoạt động. Plugin lỗi thời cũng là cửa ngõ phổ biến để website WordPress bị chèn mã độc.</p>'
				. '<p>Trong tháng, bạn chỉ cần nhắn nội dung cần đổi. Chúng tôi đăng tin, sửa giá, thay banner, cập nhật WordPress và plugin sau khi đã sao lưu, kiểm tra tốc độ trang và chứng chỉ SSL. Cuối tháng có báo cáo liệt kê từng việc đã làm, lượt truy cập, lỗi phát hiện và đề xuất cho tháng sau, để bạn biết khoản phí đổi lấy việc gì.</p>'
				. '<p>Website đang chạy trên WordPress do đơn vị khác làm, chúng tôi vẫn nhận: tháng đầu dành thời gian rà mã nguồn, plugin và quyền truy cập trước khi bắt đầu cập nhật.</p>',
			'img' => array( 'src' => 'agency-team-5-800.webp', 'w' => 800, 'h' => 533, 'alt' => 'Hai người trao đổi kế hoạch công việc bên bảng trắng', 'cap' => '' ),
			'extra_eyebrow' => 'Chọn gói',
			'extra_h' => 'Gói nào hợp với website của bạn?',
			'extra'   => '<div class="ws-scroll"><table><thead><tr><th>Tình huống</th><th>Gói phù hợp</th><th>Lý do</th></tr></thead><tbody>'
				. '<tr><td>Website giới thiệu, vài tin tức mỗi tháng</td><td>Cơ bản</td><td>10 lần cập nhật, 3 banner mỗi tháng là đủ; ngân sách dành cho bảo mật và sao lưu.</td></tr>'
				. '<tr><td>Website bán hàng dưới 100 sản phẩm thay đổi mỗi tháng</td><td>Nâng cao</td><td>Có hạn mức quản lý 100 sản phẩm, kiểm tra SEO và bảo mật chuyên sâu.</td></tr>'
				. '<tr><td>Cửa hàng nhiều mã hàng, chạy khuyến mãi liên tục</td><td>Toàn diện</td><td>20 lần cập nhật, 250 sản phẩm, 9 banner, kiểm tra bảo mật hằng tuần thay vì hằng tháng.</td></tr>'
				. '<tr><td>Cần lên top từ khoá, không chỉ giữ website sống</td><td>Kết hợp dịch vụ SEO</td><td>Chăm sóc giữ website ổn định; tăng thứ hạng cần kế hoạch nội dung và liên kết riêng.</td></tr>'
				. '</tbody></table></div>',
		),
		'dang-ky-website-bo-cong-thuong' => array(
			'eyebrow' => 'Thủ tục website',
			'lead'    => 'Từ 01/7/2026, website bán hàng có chức năng đặt hàng trực tuyến thông báo với UBND cấp tỉnh qua Cổng Dịch vụ công quốc gia, không còn khai trên online.gov.vn như trước. Chúng tôi rà website, soạn tờ khai và theo hồ sơ tới khi có xác nhận.',
			'price_h' => 'Chi phí dịch vụ',
			'story_eyebrow' => 'Quy định mới',
			'story_h' => 'Điều gì đã thay đổi từ 01/7/2026?',
			'story'   => '<p>Nghị định 248/2026/NĐ-CP hướng dẫn Luật Thương mại điện tử có hiệu lực từ 01/7/2026, thay Nghị định 52/2013 và 85/2021. Website doanh nghiệp, hộ kinh doanh tự lập để bán hàng của mình (có giỏ hàng, nút đặt mua) nay thông báo với UBND cấp tỉnh. Hồ sơ gồm Tờ khai Mẫu số 01 và bản sao giấy phép nếu kinh doanh ngành nghề có điều kiện, nộp và nhận kết quả trên Cổng Dịch vụ công quốc gia, thời hạn xử lý 03 ngày làm việc khi hồ sơ đầy đủ.</p>'
				. '<p>Website đã được xác nhận trước 01/7/2026 vẫn hoạt động tới 30/6/2027 nhưng phải cập nhật hồ sơ theo quy định mới trong khoảng đó. Sàn giao dịch và nền tảng trung gian vẫn đăng ký với Bộ Công Thương. Website chỉ giới thiệu, không có chức năng đặt hàng thì không thuộc diện thông báo.</p>'
				. '<p>Văn bản gốc: <a href="https://vanban.chinhphu.vn/?pageid=27160&amp;docid=218747" target="_blank" rel="noopener">Nghị định 248/2026/NĐ-CP</a> (Điều 24, 25, 53).</p>',
			'img' => array( 'src' => 'ws-online-gov-vn.webp', 'w' => 1600, 'h' => 950, 'alt' => 'Trang chủ Cổng thông tin quản lý hoạt động thương mại điện tử online.gov.vn', 'cap' => 'Cổng online.gov.vn ngày 30/10/2026 ghi nhận 55.234 nền tảng đã thông báo và 1.111 nền tảng đã đăng ký, trước khi chuyển sang cơ chế mới.' ),
			'extra_eyebrow' => 'Kinh nghiệm hồ sơ',
			'extra_h' => 'Những lỗi khiến hồ sơ bị yêu cầu làm rõ',
			'extra'   => '<p>Phần lớn hồ sơ bị trả lại không phải vì giấy tờ, mà vì chính website chưa khớp với những gì khai trong tờ khai. Trước khi nộp, chúng tôi rà website theo danh sách dưới đây và sửa cùng bạn:</p>'
				. '<ul><li>Tên công ty, mã số thuế, địa chỉ ở chân trang không khớp giấy đăng ký kinh doanh.</li>'
				. '<li>Còn nội dung mẫu của giao diện (sản phẩm demo, chữ tiếng Anh, số điện thoại giả).</li>'
				. '<li>Thiếu trang chính sách đổi trả, vận chuyển, thanh toán, bảo mật thông tin.</li>'
				. '<li>Khai tên miền có www trong khi website chạy không có www, hoặc ngược lại.</li>'
				. '<li>Sản phẩm bán trên website nằm ngoài ngành nghề đã đăng ký.</li></ul>'
				. '<p>Sau khi được xác nhận, website gắn biểu tượng liên kết tới hệ thống quản lý thương mại điện tử. Khi đổi tên miền, người phụ trách, thông tin đăng ký kinh doanh hoặc chính sách công khai, phải sửa thông báo trong 20 ngày làm việc. Vi phạm về thiết lập và vận hành website thương mại điện tử bị xử phạt hành chính theo Nghị định 98/2020/NĐ-CP, xem <a href="https://moit.gov.vn/thuong-mai-dien-tu/mot-so-quy-dinh-moi-ve-xu-phat-vi-pham-hanh-chinh-trong-linh.html" target="_blank" rel="noopener">tổng hợp của Bộ Công Thương</a>.</p>',
		),
		'email-doanh-nghiep' => array(
			'eyebrow' => 'Email doanh nghiệp',
			'lead'    => 'Email theo tên miền riêng (ten@congty.vn) trên máy chủ email, hoặc Google Workspace, Microsoft 365 chính hãng. Chúng tôi tạo hộp thư, trỏ bản ghi DNS và cấu hình xác thực để thư không rơi vào mục spam.',
			'price_h' => 'Bảng giá email doanh nghiệp',
			'story_eyebrow' => 'Vì sao thư vào spam',
			'story_h' => 'Gmail đã đặt luật, thiếu bản ghi là thư bị chặn',
			'story'   => '<p>Google yêu cầu mọi người gửi thư tới tài khoản Gmail phải có xác thực SPF hoặc DKIM, máy chủ gửi có bản ghi ngược hợp lệ, dùng kết nối mã hoá và giữ tỉ lệ bị báo spam dưới 0,3%. Doanh nghiệp gửi trên 5.000 thư mỗi ngày tới Gmail phải có đủ cả SPF, DKIM và DMARC. Thư thiếu xác thực sẽ bị đẩy vào spam hoặc trả về.</p>'
				. '<p>Nhiều doanh nghiệp mua email xong vẫn để trống các bản ghi này vì không ai hướng dẫn. Khi bàn giao, chúng tôi trỏ đủ bốn bản ghi trong thẻ bên cạnh, kiểm tra bằng thư gửi thử tới Gmail và Outlook, rồi mới gửi thông tin đăng nhập. Hộp thư thuộc tài khoản doanh nghiệp, nhân sự nghỉ việc thì công ty vẫn giữ dữ liệu.</p>'
				. '<p>Nguồn: <a href="https://support.google.com/mail/answer/81126?hl=vi" target="_blank" rel="noopener">Nguyên tắc dành cho người gửi email của Google</a>.</p>',
			'img' => array( 'src' => 'ws-email-dns.webp', 'w' => 1600, 'h' => 853, 'alt' => 'Ví dụ 4 bản ghi DNS cho email doanh nghiệp: MX, SPF, DKIM, DMARC', 'cap' => 'Ví dụ minh hoạ cho tên miền congty.vn. Giá trị thật lấy từ nhà cung cấp email bạn chọn.' ),
			'extra_eyebrow' => 'So sánh',
			'extra_h' => 'Email máy chủ riêng, Google Workspace hay Microsoft 365?',
			'extra'   => '<div class="ws-scroll"><table><thead><tr><th>Tiêu chí</th><th>Email theo tên miền</th><th>Google Workspace</th><th>Microsoft 365</th></tr></thead><tbody>'
				. '<tr><td>Cách tính phí</td><td>Theo gói, nhiều hộp thư dùng chung dung lượng</td><td>Theo từng người dùng</td><td>Theo từng người dùng</td></tr>'
				. '<tr><td>Hợp với</td><td>Đội đông người, chỉ cần gửi nhận thư</td><td>Đội đã quen Gmail, Drive, Meet</td><td>Đội dùng Word, Excel, Outlook, Teams hằng ngày</td></tr>'
				. '<tr><td>Ứng dụng văn phòng</td><td>Không kèm</td><td>Docs, Sheets, Meet, Drive</td><td>Word, Excel bản web hoặc cài máy (tuỳ gói), Teams, OneDrive</td></tr>'
				. '<tr><td>Ví dụ 20 người</td><td>Một gói 20 hộp thư</td><td>20 giấy phép</td><td>20 giấy phép</td></tr>'
				. '</tbody></table></div>'
				. '<p>Chưa có tên miền thì <a href="/ten-mien/">đăng ký tên miền</a> trước, email và website dùng chung một tên miền.</p>',
		),
		'chung-chi-ssl' => array(
			'eyebrow' => 'Chứng chỉ SSL',
			'lead'    => 'Chứng chỉ SSL trả phí xác thực tên miền (DV), xác thực doanh nghiệp (OV) và xác thực mở rộng (EV). Chúng tôi tạo CSR, xác minh, cài lên máy chủ và cấp lại chứng chỉ mỗi khi tới hạn trong suốt kỳ đăng ký.',
			'price_h' => 'Bảng giá chứng chỉ SSL',
			'story_eyebrow' => 'Điều ít ai nói',
			'story_h' => 'Chứng chỉ SSL đang ngắn dần, việc cài lại mới là phần tốn công',
			'story'   => '<p>Các tổ chức cấp phát và trình duyệt đã thống nhất rút ngắn thời hạn tối đa của một chứng chỉ: 398 ngày trước 15/3/2026, còn 200 ngày từ 15/3/2026, 100 ngày từ 15/3/2027 và 47 ngày từ 15/3/2029. Gói SSL mua theo năm vì thế là một kỳ đăng ký, trong đó chứng chỉ phải được cấp lại và cài lại nhiều lần.</p>'
				. '<p>Website quên cài lại sẽ hiện cảnh báo "Kết nối không riêng tư" và khách bỏ đi ngay. Chúng tôi theo dõi ngày hết hạn của từng chứng chỉ, cấp lại và cài trước hạn. Thẻ bên cạnh là thông tin chứng chỉ đang chạy trên chính digicomvn.com: loại miễn phí, 90 ngày, không có tên tổ chức, đủ cho website giới thiệu nhưng không đáp ứng được đối tác yêu cầu chứng chỉ ghi tên doanh nghiệp.</p>'
				. '<p>Nguồn: <a href="https://cabforum.org/2025/04/11/ballot-sc081v3-introduce-schedule-of-reducing-validity-and-data-reuse-periods/" target="_blank" rel="noopener">nghị quyết SC-081v3 của CA/Browser Forum</a>.</p>',
			'img' => array( 'src' => 'ws-ssl-digicomvn.webp', 'w' => 1600, 'h' => 853, 'alt' => 'Thông tin chứng chỉ SSL của digicomvn.com: loại DV, hiệu lực 90 ngày', 'cap' => 'Chứng chỉ thật của digicomvn.com, kiểm tra ngày 30/10/2026: DV, hiệu lực 06/9 đến 05/12/2026.' ),
			'extra_eyebrow' => 'So sánh',
			'extra_h' => 'DV, OV hay EV: chọn theo việc website phải chứng minh',
			'extra'   => '<div class="ws-scroll"><table><thead><tr><th>Loại</th><th>Xác minh gì</th><th>Thời gian cấp thường gặp</th><th>Hợp với</th></tr></thead><tbody>'
				. '<tr><td>DV</td><td>Quyền quản lý tên miền (email, bản ghi DNS hoặc tệp trên website)</td><td>Khoảng 15 phút</td><td>Website giới thiệu, blog, cần chứng chỉ Wildcard cho nhiều tên miền phụ</td></tr>'
				. '<tr><td>OV</td><td>Tên miền và pháp nhân (giấy đăng ký kinh doanh, cuộc gọi xác minh)</td><td>1 đến 3 ngày làm việc</td><td>Website nhận thanh toán, thu thông tin cá nhân, đối tác yêu cầu tên doanh nghiệp trong chứng chỉ</td></tr>'
				. '<tr><td>EV</td><td>Như OV, thẩm định pháp nhân chặt hơn</td><td>Vài ngày làm việc</td><td>Ngân hàng, tài chính, website cần mức xác thực cao nhất</td></tr>'
				. '</tbody></table></div>'
				. '<p>Loại chứng chỉ không làm thay đổi thứ hạng Google; khác biệt nằm ở mức xác thực và mức bảo hiểm của tổ chức cấp phát.</p>',
		),
		'cloud-server' => array(
			'eyebrow' => 'Cloud server',
			'lead'    => 'Máy chủ ảo với CPU, RAM, ổ SSD và IP riêng, toàn quyền quản trị. Hợp website lớn, nhiều website vệ tinh, công cụ tự động hoá như n8n, Docker, bot thu thập dữ liệu.',
			'price_h' => 'Bảng giá cloud server',
			'story_eyebrow' => 'Trước khi chuyển',
			'story_h' => 'Khi nào hosting không còn đủ, và cái giá của toàn quyền',
			'story'   => '<p>Hosting dùng chung máy chủ với nhiều khách nên bị giới hạn CPU, RAM và số tiến trình. Dấu hiệu nên chuyển: website hay báo lỗi vượt tài nguyên vào giờ cao điểm, bạn cần IP riêng cho nhiều website vệ tinh, hoặc cần cài phần mềm hosting không cho phép như Docker, n8n, Node.js chạy nền.</p>'
				. '<p>Toàn quyền đi kèm toàn trách nhiệm. Trên cloud server không ai tự cập nhật hệ điều hành, dựng tường lửa hay sao lưu giúp bạn. Cũng nên hiểu đúng cam kết hoạt động: 99,9% nghe rất cao nhưng vẫn cho phép khoảng 8,8 giờ gián đoạn mỗi năm, 99,99% là khoảng 53 phút. Nếu đội của bạn chưa có người quản trị máy chủ, chúng tôi nhận cài đặt ban đầu: hệ điều hành, bảng điều khiển, website, SSL, tường lửa, lịch sao lưu.</p>',
			'img' => array( 'src' => 'agency-team-4-800.webp', 'w' => 800, 'h' => 533, 'alt' => 'Nhóm làm việc quanh bàn, xem kế hoạch triển khai trên máy tính', 'cap' => '' ),
			'extra_eyebrow' => 'So sánh',
			'extra_h' => 'Hosting hay cloud server?',
			'extra'   => '<div class="ws-scroll"><table><thead><tr><th>Tiêu chí</th><th>Hosting</th><th>Cloud server</th></tr></thead><tbody>'
				. '<tr><td>Tài nguyên</td><td>Dùng chung, có giới hạn tiến trình</td><td>CPU, RAM, ổ SSD riêng</td></tr>'
				. '<tr><td>Quyền quản trị</td><td>Bảng điều khiển cPanel</td><td>Quyền root, tự cài hệ điều hành và phần mềm</td></tr>'
				. '<tr><td>Ai lo bảo mật, cập nhật</td><td>Nhà cung cấp hosting</td><td>Người quản trị máy chủ (bạn hoặc đơn vị bạn thuê)</td></tr>'
				. '<tr><td>Hợp với</td><td>1 đến vài website doanh nghiệp, blog</td><td>Website nhiều truy cập, nhiều website vệ tinh, công cụ tự động hoá</td></tr>'
				. '</tbody></table></div>'
				. '<p>Website nhỏ chưa cần máy chủ riêng: xem <a href="/hosting/">bảng giá hosting</a>, có thể nâng lên cloud khi cần.</p>',
		),
	);
	return $c[ $slug ] ?? null;
}
