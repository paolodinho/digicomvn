<?php
/**
 * Phan "doc bang gia" cho trang dich vu dung tpl-service.php (30/10/2026, thay 4 the cam ket van mau).
 * So lieu tinh tu bang gia dgc_gia ngay 30/10/2026 (ghi ngay ro trong bai va chu thich anh).
 * Doi gia lon -> tinh lai so trong file nay + ve lai anh (.claude/skills/visual-screenshot).
 * KHONG ghi ten nha cung cap, gia von. Markup giong tpl-web.php (CSS .ws-story / .ws-extra trong sg.css).
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function dgc_svc_story_conf( $path ) {
	$spam = 'https://developers.google.com/search/docs/essentials/spam-policies?hl=vi#link-spam';
	$c = array(
		'/mua-textlink/' => array(
			'story_eyebrow' => 'Bảng giá textlink',
			'story_h'       => 'Giá thuê textlink theo vị trí và kỳ hạn',
			'story'         => '<p>Ngày 30/10/2026, bảng giá textlink trên trang này có 30 site, phần lớn là báo điện tử và trang tin có DR trung vị khoảng 64. Mỗi site bán ba vị trí: link trong một chuyên mục, link ở trang chủ và link toàn site (fullsite, hiện trên mọi trang), mỗi vị trí có kỳ hạn 3, 6 hoặc 12 tháng. Link chỉ được giữ trong kỳ hạn đã thuê.</p>'
				. '<p>Kỳ hạn càng dài, giá tính theo tháng càng thấp. Link chuyên mục 12 tháng có giá trung vị 665.000đ, chỉ gấp 1,4 lần gói 3 tháng 475.000đ dù thời gian dài gấp bốn. Link trang chủ 12 tháng 2,38 triệu so với 1,43 triệu cho 3 tháng; fullsite 4,28 triệu so với 2,38 triệu.</p>'
				. '<p>Nếu đang thử một site mới, link chuyên mục là điểm bắt đầu hợp lý: rẻ và nằm cạnh nội dung cùng chủ đề. Fullsite đắt nhất vì lặp lại trên mọi trang.</p>',
			'img'           => array( 'src' => 'svc-textlink-gia.webp', 'w' => 1600, 'h' => 853, 'alt' => 'Bảng giá trung vị thuê textlink theo vị trí chuyên mục, trang chủ, toàn site và kỳ hạn 3, 6, 12 tháng', 'cap' => 'Tính từ bảng giá DigicomVN ngày 30/10/2026, giá chưa VAT.' ),
			'extra_eyebrow' => 'Trước khi chọn site',
			'extra_h'       => 'Kiểm tra gì trước khi thuê textlink',
			'extra'         => '<p>Bảng giá ghi kèm DA, PA, DR và traffic ước tính của từng site. Các chỉ số này lấy từ công cụ đo bên thứ ba tại thời điểm nhập và đổi theo thời gian, nên với gói 12 tháng, bạn nên mở lại Ahrefs hoặc Semrush kiểm tra site trước khi chốt.</p>'
				. '<p>Nên ưu tiên site cùng chủ đề: link trong bài cùng ngành với website của bạn có giá trị hơn link ở một trang tin tổng hợp, kể cả khi trang tin có chỉ số cao hơn. Về anchor text, Google coi <a href="' . $spam . '" target="_blank" rel="noopener">mua bán liên kết cho mục đích xếp hạng</a> là vi phạm chính sách, nên dùng tên thương hiệu hoặc địa chỉ website làm anchor, hạn chế anchor khớp chính xác từ khoá.</p>'
				. '<p>Nếu không muốn gia hạn theo kỳ, có thể xem <a href="/guest-post/">guest post</a>: một bài viết mới đăng trên site, không tính theo kỳ hạn tháng.</p>',
		),
		'/guest-post/' => array(
			'story_eyebrow' => 'Bảng giá guest post',
			'story_h'       => 'Giá guest post theo nhóm site và loại link',
			'story'         => '<p>Ngày 30/10/2026, bảng giá guest post trên trang này có 26 site, hầu hết giá từ 760.000đ đến 1,14 triệu một bài. Mọi site dùng chung một quy cách: bài khoảng 1.000 từ, 3-5 ảnh, 2 link. Giá tính một lần cho mỗi bài, bài đăng như nội dung thường của site và không tính theo tháng như <a href="/mua-textlink/">textlink</a>.</p>'
				. '<p>Các site khác nhau chủ yếu ở loại link. Năm site review thành phố (Hà Nội, Sài Gòn, Đà Nẵng, Quy Nhơn, Bình Dương) cho 2 link dofollow với giá 1,14 triệu; các site còn lại cho link nofollow, đông nhất là nhóm toplist theo tỉnh giá 950.000đ. Nếu mục tiêu là SEO, nên chọn nhóm dofollow; nếu muốn người đọc ở một tỉnh biết đến thương hiệu, site toplist của tỉnh đó phù hợp hơn.</p>',
			'img'           => array( 'src' => 'svc-guestpost-gia.webp', 'w' => 1600, 'h' => 853, 'alt' => 'Biểu đồ giá một bài guest post theo nhóm site: du lịch 760.000đ, toplist theo tỉnh 950.000đ, site review dofollow 1,14 triệu', 'cap' => 'Tính từ bảng giá DigicomVN ngày 30/10/2026, giá chưa VAT.' ),
			'extra_eyebrow' => 'So với textlink',
			'extra_h'       => 'So sánh guest post và textlink',
			'extra'         => '<div class="ws-scroll"><table>'
				. '<caption style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0">So sánh guest post và textlink theo bảng giá DigicomVN ngày 30/10/2026</caption>'
				. '<thead><tr><th>Tiêu chí</th><th>Guest post</th><th>Textlink</th></tr></thead><tbody>'
				. '<tr><td data-label="Tiêu chí">Giá thấp nhất</td><td data-label="Guest post">760.000đ một bài</td><td data-label="Textlink">475.000đ cho 3 tháng</td></tr>'
				. '<tr><td data-label="Tiêu chí">Cách tính</td><td data-label="Guest post">Một lần</td><td data-label="Textlink">Theo kỳ hạn 3, 6, 12 tháng</td></tr>'
				. '<tr><td data-label="Tiêu chí">Nội dung</td><td data-label="Guest post">Bài mới khoảng 1.000 từ, 3-5 ảnh</td><td data-label="Textlink">Chèn link vào trang có sẵn</td></tr>'
				. '<tr><td data-label="Tiêu chí">Số link</td><td data-label="Guest post">2 link</td><td data-label="Textlink">1 link mỗi vị trí</td></tr>'
				. '</tbody></table></div>'
				. '<p>Guest post hợp khi bạn muốn có một bài giới thiệu dịch vụ, sản phẩm trên site cùng chủ đề, có ngữ cảnh xung quanh link. Textlink hợp khi đã có sẵn trang đích cần đẩy và chỉ cần thêm link trỏ về trong một thời gian. Với cả hai, anchor text nên là tên thương hiệu hoặc địa chỉ website: Google coi <a href="' . $spam . '" target="_blank" rel="noopener">mua bán liên kết cho mục đích xếp hạng</a> là vi phạm chính sách.</p>',
		),
		'/dich-vu-backlink/' => array(
			'story_eyebrow' => 'Các loại backlink',
			'story_h'       => 'Các loại backlink và cách kết hợp',
			'story'         => '<p>Thuê link trong chuyên mục báo, đặt bài guest post trên site cùng chủ đề và đăng bài PR trên báo điện tử khác nhau về giá, thời hạn và loại link. Bảng bên dưới ghi giá thấp nhất đang niêm yết của từng loại; bấm vào từng loại để xem giá chi tiết theo site, báo.</p>'
				. '<p>Một kế hoạch thường bắt đầu từ vài bài trên báo, site cùng ngành để có nguồn tin cậy nhắc tới thương hiệu, rồi mới thêm textlink hoặc guest post có link dofollow cho các trang cần lên hạng. Anchor text nên chủ yếu là tên thương hiệu và địa chỉ website: Google coi <a href="https://developers.google.com/search/docs/essentials/spam-policies?hl=vi#link-spam" target="_blank" rel="noopener">mua bán liên kết cho mục đích xếp hạng</a> là vi phạm chính sách, nên hạn chế anchor khớp chính xác từ khoá.</p>'
				. '<p>DigicomVN không nhận đặt link trên website cơ quan nhà nước và trường học (.gov.vn, .edu.vn). Các nơi này không bán liên kết, nên mọi nguồn rao bán loại link này đều đến từ việc xâm nhập website hoặc lạm quyền quản trị, là hành vi vi phạm pháp luật.</p>',
		),
	);
	return $c[ $path ] ?? array();
}
