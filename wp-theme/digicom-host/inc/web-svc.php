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
		'dang-ky-website-bo-cong-thuong' => "Thủ tục với Bộ Công Thương | Thông báo website thương mại điện tử bán hàng | 2160000 | /website | | Soạn hồ sơ, khai trên Cổng online.gov.vn; theo dõi tới khi được xác nhận; gắn biểu tượng đã thông báo lên website\n"
			. "Thủ tục với Bộ Công Thương | Đăng ký website cung cấp dịch vụ thương mại điện tử | | | | Sàn giao dịch, website khuyến mại trực tuyến, đấu giá trực tuyến; báo giá theo hồ sơ",
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

/** Noi dung tung trang (hero, loi ich, phan tu van, quy trinh). Sua van ban dai hon: dung o soan thao noi dung trang. */
function dgc_web_svc_conf( $slug ) {
	$c = array(
		'thiet-ke-website' => array(
			'eyebrow' => 'Thiết kế website',
			'lead'    => 'Website WordPress thiết kế riêng theo thương hiệu, chuẩn SEO từ cấu trúc, tải nhanh trên điện thoại và tự sửa được mọi nội dung trong trang quản trị. Bàn giao kèm tên miền, hosting, email, SSL và hướng dẫn vận hành.',
			'price_h' => '',
			'benefits' => array(
				array( 'Thiết kế riêng, không dùng mẫu đại trà', 'Bố cục, màu sắc, chữ dựng theo nhận diện thương hiệu; duyệt bản thiết kế trước khi lập trình.' ),
				array( 'Chuẩn SEO ngay từ cấu trúc', 'URL gọn, heading đúng thứ bậc, schema, sitemap, thẻ meta và Open Graph sinh tự động, tốc độ tải đạt Core Web Vitals.' ),
				array( 'Tự sửa nội dung không cần lập trình', 'Hotline, giá, ưu đãi, đánh giá, ảnh sản phẩm đều sửa trong trang quản trị WordPress.' ),
				array( 'Bàn giao trọn bộ', 'Tên miền, hosting, email theo tên miền, chứng chỉ SSL, đăng ký Bộ Công Thương nếu bán hàng, kèm tài liệu hướng dẫn 1 trang.' ),
			),
			'h2'   => 'Một website làm SEO được cần những gì?',
			'body' => '<p>Website đẹp chưa đủ để có khách từ Google. Phần quyết định nằm ở chỗ người dùng không nhìn thấy: cấu trúc URL và danh mục phản ánh đúng nhóm từ khoá, mỗi trang chỉ nhắm một ý định tìm kiếm, tốc độ phản hồi máy chủ thấp, và dữ liệu có cấu trúc giúp Google hiểu doanh nghiệp là ai, bán gì, ở đâu.</p><p>DigicomVN thiết kế website theo thứ tự ngược với cách làm thông thường: nghiên cứu từ khoá và trang đối thủ đang đứng top trước, dựng sơ đồ trang theo kết quả đó, rồi mới vẽ giao diện. Nhờ vậy website ra mắt đã có sẵn khung để viết nội dung và làm SEO, không phải đập đi làm lại sau vài tháng.</p><p>Tham khảo: <a href="https://developers.google.com/search/docs/fundamentals/seo-starter-guide" target="_blank" rel="noopener">hướng dẫn SEO cơ bản của Google</a>.</p>',
			'steps' => array(
				array( 'Khảo sát', 'Trao đổi mục tiêu, sản phẩm, đối thủ; nghiên cứu từ khoá để chốt sơ đồ trang.' ),
				array( 'Thiết kế', 'Dựng giao diện trang chủ và trang mẫu, sửa theo góp ý tới khi duyệt.' ),
				array( 'Lập trình', 'Dựng WordPress, nhập nội dung, cài SEO kỹ thuật, kiểm tra trên điện thoại và máy tính.' ),
				array( 'Bàn giao', 'Chuyển quyền quản trị, hướng dẫn sửa nội dung, gửi sitemap lên Google Search Console.' ),
			),
		),
		'cham-soc-website' => array(
			'eyebrow' => 'Chăm sóc website',
			'lead'    => 'Đội ngũ cập nhật nội dung, sản phẩm, banner, theo dõi bảo mật và tốc độ website mỗi tháng, để website luôn mới và không bị bỏ quên sau khi ra mắt.',
			'price_h' => 'Bảng giá chăm sóc website',
			'benefits' => array(
				array( 'Nội dung luôn mới', 'Đăng tin, cập nhật sản phẩm, giá, ưu đãi theo yêu cầu gửi qua Zalo hoặc email.' ),
				array( 'Theo dõi bảo mật, sao lưu', 'Cập nhật WordPress, plugin, kiểm tra mã độc và sao lưu định kỳ.' ),
				array( 'Giữ tốc độ tải trang', 'Nén ảnh, dọn dữ liệu thừa, kiểm tra Core Web Vitals hằng tháng.' ),
				array( 'Báo cáo hằng tháng', 'Danh sách việc đã làm, lượt truy cập, lỗi phát hiện và đề xuất tháng sau.' ),
			),
			'h2'   => 'Vì sao website cần được chăm sóc định kỳ?',
			'body' => '<p>Phần lớn website doanh nghiệp đứng yên sau khi bàn giao: tin tức dừng ở năm ra mắt, giá cũ, plugin không cập nhật. Với người dùng, đó là dấu hiệu doanh nghiệp không còn hoạt động; với Google, trang ít thay đổi và tải chậm khó giữ thứ hạng.</p><p>Plugin và mã nguồn lỗi thời là đường xâm nhập phổ biến nhất của website WordPress. Gói chăm sóc gom các việc nhỏ nhưng phải làm đều đặn vào một đầu mối, có báo cáo để bạn biết tiền đã đổi lấy việc gì.</p><p>Cần đẩy mạnh từ khoá thay vì chỉ duy trì: xem <a href="/dich-vu-seo/">dịch vụ SEO</a> và <a href="/dich-vu-viet-bai-chuan-seo/">viết bài chuẩn SEO</a>.</p>',
			'steps' => array(
				array( 'Rà soát ban đầu', 'Kiểm tra mã nguồn, plugin, tốc độ, bảo mật; báo lỗi cần sửa trước.' ),
				array( 'Chốt đầu việc', 'Thống nhất kênh gửi yêu cầu và lịch cập nhật hằng tuần.' ),
				array( 'Thực hiện', 'Cập nhật nội dung, banner, sản phẩm; sao lưu và theo dõi bảo mật.' ),
				array( 'Báo cáo', 'Gửi báo cáo cuối tháng kèm đề xuất cải thiện.' ),
			),
		),
		'dang-ky-website-bo-cong-thuong' => array(
			'eyebrow' => 'Thủ tục website',
			'lead'    => 'Soạn hồ sơ và khai thông báo website thương mại điện tử bán hàng trên Cổng online.gov.vn của Bộ Công Thương, theo dõi tới khi được xác nhận và gắn biểu tượng đã thông báo lên website.',
			'price_h' => 'Chi phí dịch vụ',
			'benefits' => array(
				array( 'Đúng quy định', 'Website có chức năng đặt hàng trực tuyến phải thông báo với Bộ Công Thương theo Nghị định 52/2013/NĐ-CP và 85/2021/NĐ-CP.' ),
				array( 'Chuẩn bị hồ sơ giúp bạn', 'Soạn quy chế, chính sách đổi trả, bảo mật, vận chuyển hiển thị trên website theo yêu cầu thẩm định.' ),
				array( 'Theo dõi tới khi xong', 'Xử lý yêu cầu bổ sung từ cơ quan thẩm định, bạn không phải tự nộp lại.' ),
				array( 'Gắn biểu tượng xác nhận', 'Gắn logo "Đã thông báo Bộ Công Thương" ở chân trang, tăng niềm tin khi khách đặt hàng.' ),
			),
			'h2'   => 'Website nào phải thông báo với Bộ Công Thương?',
			'body' => '<p>Website do doanh nghiệp, hộ kinh doanh tự lập để bán hàng hoá, dịch vụ của chính mình (có giỏ hàng, nút đặt mua hoặc form đặt hàng) thuộc diện <strong>thông báo</strong>. Website làm nền tảng cho người khác bán hàng, như sàn giao dịch, website khuyến mại hoặc đấu giá trực tuyến, thuộc diện <strong>đăng ký</strong>, hồ sơ phức tạp hơn và thẩm định lâu hơn.</p><p>Không thông báo hoặc đăng ký có thể bị xử phạt hành chính theo Nghị định 98/2020/NĐ-CP (sửa đổi bởi Nghị định 17/2022/NĐ-CP). Website chỉ giới thiệu doanh nghiệp, không có chức năng đặt hàng thì không bắt buộc.</p><p>Văn bản gốc: <a href="https://vanban.chinhphu.vn/?pageid=27160&amp;docid=167920" target="_blank" rel="noopener">Nghị định 52/2013/NĐ-CP</a>, <a href="https://online.gov.vn/" target="_blank" rel="noopener">Cổng thông tin quản lý hoạt động thương mại điện tử</a>.</p>',
			'steps' => array(
				array( 'Kiểm tra website', 'Rà các trang chính sách bắt buộc, thông tin pháp nhân ở chân trang.' ),
				array( 'Soạn hồ sơ', 'Hoàn thiện nội dung chính sách, chuẩn bị giấy phép kinh doanh.' ),
				array( 'Khai trên cổng', 'Tạo tài khoản, khai thông báo, nộp hồ sơ trực tuyến.' ),
				array( 'Xác nhận', 'Xử lý yêu cầu bổ sung, nhận xác nhận và gắn biểu tượng lên website.' ),
			),
		),
		'email-doanh-nghiep' => array(
			'eyebrow' => 'Email doanh nghiệp',
			'lead'    => 'Email theo tên miền riêng (ten@congty.vn) trên máy chủ tốc độ cao, hoặc Google Workspace, Microsoft 365 chính hãng. DigicomVN cài đặt, trỏ bản ghi và cấu hình chống vào hộp thư rác giúp bạn.',
			'price_h' => 'Bảng giá email doanh nghiệp',
			'benefits' => array(
				array( 'Tạo niềm tin với khách', 'Email theo tên miền công ty chuyên nghiệp hơn hộp thư miễn phí, khách dễ nhận ra thương hiệu.' ),
				array( 'Không vào hộp thư rác', 'Cấu hình đủ SPF, DKIM, DMARC theo yêu cầu gửi thư của Gmail và Yahoo.' ),
				array( 'Doanh nghiệp giữ quyền', 'Nhân sự nghỉ việc, hộp thư và dữ liệu vẫn thuộc công ty.' ),
				array( 'Có người cài đặt', 'Trỏ tên miền, tạo hộp thư, cài trên điện thoại, Outlook; hướng dẫn chuyển thư cũ.' ),
			),
			'h2'   => 'Chọn email máy chủ riêng, Google Workspace hay Microsoft 365?',
			'body' => '<p><strong>Email theo tên miền riêng</strong> tính giá theo gói dung lượng và số hộp thư, phù hợp doanh nghiệp nhiều nhân sự chỉ cần gửi nhận thư: 20 hộp thư dùng chung một gói rẻ hơn nhiều so với tính tiền từng người. <strong>Google Workspace</strong> hợp đội đã quen Gmail, Google Drive, Meet. <strong>Microsoft 365</strong> hợp doanh nghiệp dùng Word, Excel, Outlook và Teams hằng ngày.</p><p>Từ tháng 2/2024 Gmail và Yahoo yêu cầu thư gửi hàng loạt phải xác thực SPF, DKIM và DMARC, thiếu là thư bị chặn hoặc vào mục spam. Đây là phần DigicomVN cấu hình sẵn khi bàn giao.</p><p>Tham khảo: <a href="https://support.google.com/a/answer/81126" target="_blank" rel="noopener">hướng dẫn gửi email của Google</a>. Chưa có tên miền: <a href="/ten-mien/">đăng ký tên miền</a>.</p>',
			'steps' => array(
				array( 'Chọn gói', 'Theo số người dùng và nhu cầu: chỉ email, hay cả bộ ứng dụng văn phòng.' ),
				array( 'Đăng ký', 'Gửi yêu cầu, nhận báo giá theo số user và kỳ hạn, thanh toán chuyển khoản.' ),
				array( 'Cài đặt', 'Trỏ bản ghi MX, SPF, DKIM, DMARC; tạo hộp thư theo danh sách.' ),
				array( 'Bàn giao', 'Gửi thông tin đăng nhập, hướng dẫn cài trên điện thoại và máy tính.' ),
			),
		),
		'chung-chi-ssl' => array(
			'eyebrow' => 'Chứng chỉ SSL',
			'lead'    => 'Chứng chỉ SSL trả phí từ các tổ chức cấp phát quốc tế: xác thực tên miền, xác thực doanh nghiệp (OV) và xác thực mở rộng (EV). DigicomVN tạo CSR, xác minh và cài đặt lên website giúp bạn.',
			'price_h' => 'Bảng giá chứng chỉ SSL',
			'benefits' => array(
				array( 'Kết nối HTTPS an toàn', 'Mã hoá dữ liệu giữa trình duyệt và máy chủ, không còn cảnh báo "Không bảo mật".' ),
				array( 'Xác thực doanh nghiệp', 'Gói OV, EV ghi tên pháp nhân trong chứng chỉ, phù hợp website thanh toán, tài chính.' ),
				array( 'Bảo hiểm, con dấu tin cậy', 'Chứng chỉ trả phí có mức bảo hiểm và con dấu xác thực gắn lên website.' ),
				array( 'Cài đặt trọn gói', 'Tạo CSR, xác minh, cài trên cPanel, VPS hoặc Nginx, chuyển toàn bộ sang HTTPS.' ),
			),
			'h2'   => 'Đã có SSL miễn phí, có cần mua SSL trả phí?',
			'body' => '<p>Mọi gói hosting tại DigicomVN đều có SSL miễn phí, đủ cho blog và website giới thiệu: Google xác nhận HTTPS là một tín hiệu xếp hạng nhẹ, nhưng loại chứng chỉ (miễn phí hay trả phí) không ảnh hưởng thứ hạng. Khác biệt nằm ở mức xác thực và cam kết của tổ chức cấp phát.</p><p>Nên dùng SSL trả phí khi: website nhận thanh toán, thu thập thông tin cá nhân, cần chứng chỉ ghi tên doanh nghiệp (OV, EV) theo yêu cầu đối tác hoặc ngân hàng, cần chứng chỉ Wildcard cho nhiều tên miền phụ, hoặc máy chủ không tự gia hạn được SSL miễn phí 90 ngày.</p><p>Tham khảo: <a href="https://developers.google.com/search/docs/crawling-indexing/site-move-with-url-changes" target="_blank" rel="noopener">hướng dẫn chuyển website sang HTTPS của Google</a>.</p>',
			'steps' => array(
				array( 'Chọn loại chứng chỉ', 'Theo số tên miền và mức xác thực cần có.' ),
				array( 'Tạo CSR, xác minh', 'Xác minh qua email, bản ghi DNS hoặc tệp trên website; OV, EV cần giấy tờ doanh nghiệp.' ),
				array( 'Cài đặt', 'Cài chứng chỉ lên máy chủ, chuyển hướng HTTP sang HTTPS.' ),
				array( 'Kiểm tra', 'Kiểm tra chuỗi chứng chỉ, nội dung hỗn hợp và nhắc gia hạn trước khi hết hạn.' ),
			),
		),
		'cloud-server' => array(
			'eyebrow' => 'Cloud server',
			'lead'    => 'Máy chủ ảo (VPS) với CPU, RAM, ổ SSD riêng, IP riêng và toàn quyền quản trị. Phù hợp website lớn, nhiều website vệ tinh, công cụ tự động hoá và ứng dụng cần cấu hình riêng.',
			'price_h' => 'Bảng giá cloud server',
			'benefits' => array(
				array( 'Tài nguyên riêng', 'CPU, RAM không chia sẻ với website khác, hiệu năng ổn định giờ cao điểm.' ),
				array( 'Toàn quyền quản trị', 'Quyền root, tự cài hệ điều hành, Docker, n8n, Node.js, Python.' ),
				array( 'Mở rộng dễ dàng', 'Nâng CPU, RAM, ổ cứng khi lượng truy cập tăng, không phải chuyển dữ liệu.' ),
				array( 'Có người cài đặt', 'Cài sẵn bảng điều khiển, WordPress, chứng chỉ SSL và tường lửa khi cần.' ),
			),
			'h2'   => 'Khi nào nên chuyển từ hosting lên cloud server?',
			'body' => '<p>Hosting dùng chung tài nguyên với nhiều khách hàng nên giới hạn CPU, RAM và số tiến trình. Nên chuyển lên cloud server khi website thường xuyên báo vượt tài nguyên, chạy nhiều website vệ tinh cần IP riêng, cần cài phần mềm hosting không cho phép (Docker, n8n, công cụ crawl, bot), hoặc cửa hàng có nhiều đơn hàng đồng thời.</p><p>Cloud server đòi hỏi người quản trị: cập nhật hệ điều hành, tường lửa, sao lưu. Nếu đội của bạn chưa có người làm việc này, DigicomVN nhận cài đặt ban đầu và tư vấn gói quản trị kèm theo.</p><p>Website nhỏ chưa cần máy chủ riêng: xem <a href="/hosting/">bảng giá hosting</a>.</p>',
			'steps' => array(
				array( 'Chọn cấu hình', 'Tư vấn CPU, RAM, ổ cứng theo lượng truy cập và ứng dụng.' ),
				array( 'Khởi tạo', 'Tạo máy chủ, cài hệ điều hành theo yêu cầu.' ),
				array( 'Cài đặt', 'Cài bảng điều khiển, website, SSL, tường lửa.' ),
				array( 'Bàn giao', 'Gửi thông tin truy cập và hướng dẫn quản trị cơ bản.' ),
			),
		),
	);
	return $c[ $slug ] ?? null;
}
