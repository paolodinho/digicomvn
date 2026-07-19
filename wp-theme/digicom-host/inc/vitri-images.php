<?php
/**
 * Anh minh hoa VI TRI dang bai (Hieu 2026-07-18): chup thuc te tung dau bao, khoanh vung
 * vi tri tuong ung gia. Hien qua nut "V" tron canh chip vi tri trong bang gia - bam
 * mo popup xem toan bo anh minh hoa cua dau bao do. Chi co du lieu cho 15 dau bao lon
 * da chup thu cong; dau bao khac khong hien nut nay.
 * Domain la KEY khop voi dgc_gia_vitri_domain_of() - so voi post_title cua dong gia.
 */
function dgc_gia_vitri_images_map() {
	return array(
		'vnexpress.net' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/vnexpress-vt-trangchu.png',
				'alt' => 'Minh hoạ vị trí trang chủ Kinh doanh vnexpress.net cho bài PR',
				'caption' => 'Toàn cảnh trang chủ vnexpress.net, chụp thực tế 18/07/2026. Trang chủ Top 2 Kinh doanh: 72.000.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/vnexpress-vt-chuyenmuc.png',
				'alt' => 'Minh hoạ vị trí chuyên mục Giáo dục vnexpress.net cho bài PR',
				'caption' => 'Toàn cảnh chuyên mục Giáo dục vnexpress.net, chụp thực tế 18/07/2026. Mục phù hợp (Giáo dục, số hoá...): 9.200.000đ - Doanh nghiệp viết 1/2/3 (tồn tại 6-24 tháng hoặc theo domain): 7.800.000đ - 15.300.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'24h.com.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/24h-vt-tttdkd.png',
				'alt' => 'Minh hoạ vị trí Thị trường tiêu dùng Kinh doanh 24h.com.vn cho bài PR',
				'caption' => 'Toàn cảnh chuyên mục Kinh doanh 24h.com.vn, chụp thực tế 18/07/2026. Bài PR loại 2 (TTTD, KD): 4.500.000đ - PR loại 2 mục còn lại: 3.700.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/24h-vt-trangchu.png',
				'alt' => 'Minh hoạ vị trí PR loại 1 trang chủ 24h.com.vn cho bài PR',
				'caption' => 'Toàn cảnh trang chủ 24h.com.vn, chụp thực tế 18/07/2026. PR loại 1 (2h trang chủ): 7.300.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'afamily.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/afamily-vt-chuyenmuc.png',
				'alt' => 'Minh hoạ vị trí chuyên mục Đẹp afamily.vn cho bài PR',
				'caption' => 'Toàn cảnh chuyên mục Đẹp afamily.vn, chụp thực tế 18/07/2026. Chuyên mục: 3.800.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/afamily-vt-trangchu.png',
				'alt' => 'Minh hoạ vị trí bài thứ 5 stream trang chủ afamily.vn cho bài PR',
				'caption' => 'Toàn cảnh trang chủ afamily.vn, chụp thực tế 18/07/2026. Bài thứ 5 stream trang chủ: 12.960.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'baodautu.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/baodautu-vt-ttdn.png',
				'alt' => 'Minh hoạ vị trí Thông tin doanh nghiệp baodautu.vn cho bài PR',
				'caption' => 'Toàn cảnh mục Thông tin doanh nghiệp baodautu.vn, chụp thực tế 18/07/2026. TT doanh nghiệp: 3.900.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'cafebiz.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/cafebiz-vt-chuyenmuc-1.png',
				'alt' => 'Vị trí chuyên mục trên cafebiz.vn',
				'caption' => 'Chuyên mục Kinh doanh cafebiz.vn, chụp thực tế 18/07/2026. Vị trí chuyên mục: 4.500.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/cafebiz-vt-baithuonghieu-1.png',
				'alt' => 'Vị trí bài thương hiệu trên cafebiz.vn',
				'caption' => 'Khối nội dung thương hiệu trên trang chủ cafebiz.vn, chụp thực tế 18/07/2026. Vị trí bài thương hiệu: 7.000.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/cafebiz-vt-trangchu-1.png',
				'alt' => 'Vị trí trang chủ trên cafebiz.vn',
				'caption' => 'Trang chủ cafebiz.vn, chụp thực tế 18/07/2026. Vị trí trang chủ: 7.300.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'cafef.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/cafef-vt-trangchu.png',
				'alt' => 'Vị trí trang chủ trên cafef.vn',
				'caption' => 'Toàn cảnh trang chủ cafef.vn, chụp thực tế 18/07/2026. Box thông cáo báo chí trang chủ 1 ngày: 5.400.000đ - Tin doanh nghiệp trang chủ 1 ngày: 6.600.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/cafef-vt-chuyenmuc.png',
				'alt' => 'Vị trí chuyên mục trên cafef.vn',
				'caption' => 'Toàn cảnh chuyên mục Doanh nghiệp cafef.vn, chụp thực tế 18/07/2026. Chuyên mục 1 (BĐS, Doanh nghiệp, Tài chính-Ngân hàng, Chứng khoán, Smart Money): 10.400.000đ - Chuyên mục nhóm 2 (mục còn lại): 7.100.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'dantri.com.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/dantri-vt-tieumuc.png',
				'alt' => 'Minh hoạ vị trí tiểu mục dantri.com.vn cho bài PR',
				'caption' => 'Toàn cảnh chuyên mục Kinh doanh dantri.com.vn, chụp thực tế 18/07/2026. Tiểu mục nhóm 1: 10.500.000đ - Tiểu mục nhóm 2: 9.200.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/dantri-vt-trangchu.png',
				'alt' => 'Minh hoạ vị trí trang chủ Link Top 1 dantri.com.vn cho bài PR',
				'caption' => 'Toàn cảnh trang chủ dantri.com.vn, chụp thực tế 18/07/2026. Trang chủ - Link Top 1: 84.000.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'eva.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/eva-vt-tieumuc.png',
				'alt' => 'Minh hoạ vị trí bài hot tiểu mục eva.vn cho bài PR',
				'caption' => 'Toàn cảnh chuyên mục Đẹp eva.vn, chụp thực tế 18/07/2026. Bài hot tiểu mục: 3.700.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/eva-vt-trangchu.png',
				'alt' => 'Minh hoạ vị trí đặc biệt Home eva.vn cho bài PR',
				'caption' => 'Toàn cảnh trang chủ eva.vn, chụp thực tế 18/07/2026. Đặc biệt - Home: 72.000.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'kenh14.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/kenh14-vt-tieumuc.png',
				'alt' => 'Minh hoạ vị trí Xem Ăn Chơi và Tiểu mục kenh14.vn cho bài PR',
				'caption' => 'Toàn cảnh chuyên mục Ăn - Chơi - Đi kenh14.vn, chụp thực tế 18/07/2026. Xem - Ăn - Chơi: 6.100.000đ - Tiểu mục (Học đường/Công nghệ/Sao/Âm nhạc/Phim): 3.700.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/kenh14-vt-trangchu.png',
				'alt' => 'Minh hoạ vị trí trang chủ kenh14.vn cho bài PR',
				'caption' => 'Toàn cảnh trang chủ kenh14.vn, chụp thực tế 18/07/2026. Vị trí Trang chủ: 9.980.000đ - Xem-Mua-Luôn/Ăn-Quẩy-Đi/Beauty&amp;Fashion: 6.800.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'soha.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/soha-vt-stream.png',
				'alt' => 'Minh hoạ vị trí stream trang chủ soha.vn cho bài PR',
				'caption' => 'Toàn cảnh trang chủ soha.vn, chụp thực tế 18/07/2026. Bài stream trên trang chủ: 4.600.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/soha-vt-chuyenmuc.png',
				'alt' => 'Minh hoạ vị trí chuyên mục phù hợp soha.vn cho bài PR',
				'caption' => 'Toàn cảnh chuyên mục Đời sống soha.vn, chụp thực tế 18/07/2026. Chuyên mục phù hợp: 6.480.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'thanhnien.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/thanhnien-vt-canbiet.png',
				'alt' => 'Minh hoạ vị trí PR cần biết thanhnien.vn cho bài PR',
				'caption' => 'Toàn cảnh chuyên mục Bạn cần biết thanhnien.vn, chụp thực tế 18/07/2026. PR cần biết: 3.700.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/thanhnien-vt-tieumuc.png',
				'alt' => 'Minh hoạ vị trí tiểu mục chuyên mục thanhnien.vn cho bài PR',
				'caption' => 'Toàn cảnh chuyên mục Đời sống thanhnien.vn, chụp thực tế 18/07/2026. Tiểu mục phù hợp: 15.500.000đ - PR bài đăng chuyên mục (không lên trang chủ): 30.000.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'tuoitre.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/tuoitre-vt-canbiet.png',
				'alt' => 'Minh hoạ vị trí Cần biết tuoitre.vn cho bài PR',
				'caption' => 'Toàn cảnh chuyên mục Cần biết tuoitre.vn, chụp thực tế 18/07/2026. Cần biết: 5.980.000đ - Chuyên mục Cần biết chỉ trang chuyên mục: 8.400.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'vietnamnet.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/vnn-vt-top1.png',
				'alt' => 'Minh hoạ vị trí Top 1 tiểu mục vietnamnet.vn cho bài PR',
				'caption' => 'Toàn cảnh chuyên mục Đời sống vietnamnet.vn, chụp thực tế 18/07/2026. Top 1 tiểu mục: 11.820.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/vnn-vt-tieumuc.png',
				'alt' => 'Minh hoạ vị trí Tiểu mục vietnamnet.vn cho bài PR',
				'caption' => 'Toàn cảnh chuyên mục Đời sống vietnamnet.vn, chụp thực tế 18/07/2026. Tiểu mục: 4.880.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'webtretho.com' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/wtt-vt-phuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp Webtretho cho bài PR',
				'caption' => 'Toàn cảnh trang chủ Webtretho, chụp thực tế 18/07/2026 - bài gắn nhãn Tài trợ trong mục Chăm con minh hoạ đúng vị trí đăng bài PR. Mục phù hợp: 5.000.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'znews.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/znews-vt-tieumuc.png',
				'alt' => 'Minh hoạ vị trí Tiểu mục A B znews.vn cho bài PR',
				'caption' => 'Toàn cảnh chuyên mục Đời sống znews.vn, chụp thực tế 18/07/2026. Tiểu mục A: 7.400.000đ - Tiểu mục B: 9.400.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/znews-vt-magazine.png',
				'alt' => 'Minh hoạ vị trí Magazine 1 znews.vn cho bài PR',
				'caption' => 'Toàn cảnh trang chủ znews.vn, chụp thực tế 18/07/2026 - bài dạng dàn trang lớn tương tự định dạng Magazine. Magazine 1: 72.000.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		/* Dot 2 - 2026-07-18, uu tien gia cao nhat truoc (12 dau bao, con lai xu ly dot sau). */
		'vietcetera.com' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/vietcetera-vt-tranghome.png',
				'alt' => 'Minh hoạ vị trí Pr Home vietcetera.com cho bài PR',
				'caption' => 'Khu vực trang chủ Vietcetera.com, chụp thực tế 18/07/2026. Vị trí Pr Home - 2h: 42.750.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'vietnamplus.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/vietnamplus-vt-baitrangHome.png',
				'alt' => 'Minh hoạ vị trí Bài trang Home vietnamplus.vn cho bài PR',
				'caption' => 'Khu vực trang chủ Vietnamplus.vn, chụp thực tế 18/07/2026. Vị trí Bài trang Home: 19.400.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'vnreview.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/vnreview-vt-top3tieudiem.png',
				'alt' => 'Minh hoạ vị trí Top 3 tin tiêu điểm vnreview.vn cho bài PR',
				'caption' => 'Khu vực Bài viết đề xuất - trang chủ Vnreview.vn, chụp thực tế 18/07/2026. Vị trí Top 3 tin tiêu điểm: 15.810.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'cand.com.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/cand-vt-noibatchuyenmuc.png',
				'alt' => 'Minh hoạ vị trí bài nổi bật chuyên mục cand.com.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật chuyên mục trên trang chủ Cand.com.vn (Báo Công an nhân dân), chụp thực tế 18/07/2026. Vị trí Bài nổi bật chuyên mục: 15.000.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'techrum.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/techrum-vt-noibatchuyenmuc.png',
				'alt' => 'Minh hoạ vị trí nổi bật chuyên mục techrum.vn cho bài PR',
				'caption' => 'Khu vực Nhiều người xem (nổi bật chuyên mục) trên trang chủ Techrum.vn, chụp thực tế 18/07/2026. Vị trí Nổi bật chuyên mục: 13.950.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'vov.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/vov-vt-noibatchuyenmuc.png',
				'alt' => 'Minh hoạ vị trí nổi bật chuyên mục vov.vn cho bài PR',
				'caption' => 'Khu vực nổi bật chuyên mục trên trang chủ Vov.vn (Đài Tiếng nói Việt Nam), chụp thực tế 18/07/2026. Vị trí Nổi bật chuyên mục: 12.750.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'vir.com.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/vir-vt-highlighttrangchu.png',
				'alt' => 'Minh hoạ vị trí bài Highlight trang chủ vir.com.vn cho bài PR',
				'caption' => 'Khu vực bài Highlight trang chủ Vir.com.vn (Vietnam Investment Review), chụp thực tế 18/07/2026. Vị trí Bài Highlight - Trang chủ: 12.000.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'nhipcaudautu.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/nhipcaudautu-vt-skdn.png',
				'alt' => 'Minh hoạ vị trí SKDN trang chủ nhipcaudautu.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Nhipcaudautu.vn, chụp thực tế 18/07/2026. Vị trí SKDN: 11.500.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'tieudung.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/tieudung-vt-trangchu.png',
				'alt' => 'Minh hoạ vị trí hiển thị trang chủ tieudung.vn cho bài PR',
				'caption' => 'Khu vực trang chủ Tieudung.vn, chụp thực tế 18/07/2026. Vị trí Hiện thị trên trang chủ: 11.400.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'tinhte.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/tinhte-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp trang chủ tinhte.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Tinhte.vn, chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 10.900.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'genk.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/genk-vt-trangchu.png',
				'alt' => 'Minh hoạ vị trí trang chủ genk.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Genk.vn, chụp thực tế 18/07/2026. Vị trí Trang chủ: 10.100.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'doanhnhan.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/doanhnhan-vt-noibattrangchu.png',
				'alt' => 'Minh hoạ vị trí nổi bật trang chủ chuyên mục doanhnhan.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Doanhnhan.vn, chụp thực tế 18/07/2026. Vị trí Pr 1-1 - Nổi bật trang chủ chuyên mục: 9.960.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		/* Dot 3 - 2026-07-18, tiep tuc uu tien gia cao nhat (14 dau bao). */
		'baophapluat.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/baophapluat-vt-top1chuyenmuc.png',
				'alt' => 'Minh hoạ vị trí Pr Top1 chuyên mục Trang chủ baophapluat.vn cho bài PR',
				'caption' => 'Khu vực bài PR Top 1 chuyên mục trên trang chủ Baophapluat.vn (Pháp Luật Việt Nam), chụp thực tế 18/07/2026. Vị trí Pr Top1 chuyên mục - Trang chủ: 9.000.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'autopro.com.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/autopro-vt-trangchu.png',
				'alt' => 'Minh hoạ vị trí trang chủ autopro.com.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Autopro.com.vn, chụp thực tế 18/07/2026. Vị trí Trang chủ: 8.600.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'tapchikientruc.com.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/tapchikientruc-vt-tieudiem.png',
				'alt' => 'Minh hoạ vị trí bài Pr tiêu điểm trang chủ tapchikientruc.com.vn cho bài PR',
				'caption' => 'Khu vực bài PR tiêu điểm trang chủ Tapchikientruc.com.vn (Tạp chí Kiến trúc), chụp thực tế 18/07/2026. Vị trí Bài pr tiêu điểm trang chủ (treo 1 ngày): 8.000.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'ngoisao.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/ngoisaovn-vt-trangchuloai3.png',
				'alt' => 'Minh hoạ vị trí trang chủ Loại 3 ngoisao.vn cho bài PR',
				'caption' => 'Khu vực trang chủ Ngoisao.vn, chụp thực tế 18/07/2026. Vị trí Trang chủ - Loại 3: 8.000.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'nld.com.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/nld-vt-noibatchuyenmuc.png',
				'alt' => 'Minh hoạ vị trí nổi bật chuyên mục Home nld.com.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Nld.com.vn (Báo Người Lao Động), chụp thực tế 18/07/2026. Vị trí Nổi bật chuyên mục - home: 7.656.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'vneconomy.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/vneconomy-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp vneconomy.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Vneconomy.vn, chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 7.500.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'phunuvietnam.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/phunuvietnam-vt-bailoai2.png',
				'alt' => 'Minh hoạ vị trí bài nổi bật chuyên mục trang chủ phunuvietnam.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Phunuvietnam.vn (Báo Phụ nữ Việt Nam), chụp thực tế 18/07/2026. Vị trí Bài loại 2-Nổi bật CM - TC: 7.225.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'tinthethao.com.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/tinthethao-vt-trangchucm1.png',
				'alt' => 'Minh hoạ vị trí trang chủ Chuyên mục 1 tinthethao.com.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Tinthethao.com.vn, chụp thực tế 18/07/2026. Vị trí Trang chủ - Chuyên mục 1: 6.305.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'nhandan.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/nhandan-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp trang chủ nhandan.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Nhandan.vn (Báo Nhân Dân), chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 6.200.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'vtv.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/vtv-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp trang chủ vtv.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Vtv.vn (Đài Truyền hình Việt Nam), chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 5.880.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'gamek.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/gamek-vt-chuyenmuc.png',
				'alt' => 'Minh hoạ vị trí chuyên mục trang chủ gamek.vn cho bài PR',
				'caption' => 'Khu vực bài chuyên mục trang chủ Gamek.vn, chụp thực tế 18/07/2026. Vị trí Chuyên mục: 5.300.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'wiki.batdongsan.com.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/wikibds-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp Wiki BĐS batdongsan.com.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật Wiki BĐS - Batdongsan.com.vn, chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 5.200.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'laodong.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/laodong-vt-thongtindn.png',
				'alt' => 'Minh hoạ vị trí thông tin doanh nghiệp laodong.vn cho bài PR',
				'caption' => 'Khu vực tin tức trang chủ Laodong.vn (Báo Lao Động), chụp thực tế 18/07/2026. Vị trí Thông tin doanh nghiệp: 4.900.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'congan.com.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/congan-vt-baichuyenmuc.png',
				'alt' => 'Minh hoạ vị trí bài chuyên mục Home congan.com.vn cho bài PR',
				'caption' => 'Khu vực bài chuyên mục trang chủ Congan.com.vn (Báo Công an TP.HCM), chụp thực tế 18/07/2026. Vị trí Bài chuyên mục - Home: 7.760.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		/* Dot 4 - 2026-07-18, tiep tuc uu tien gia cao nhat (16 dau bao). */
		'diendandoanhnghiep.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/diendandoanhnghiep-vt-top4.png',
				'alt' => 'Minh hoạ vị trí Top 4 nổi bật chuyên mục diendandoanhnghiep.vn cho bài PR',
				'caption' => 'Khu vực Top 4 nổi bật chuyên mục trên trang chủ Diendandoanhnghiep.vn, chụp thực tế 18/07/2026. Vị trí Top 4 - Nổi bật chuyên mục: 4.800.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'thesaigontimes.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/thesaigontimes-vt-ttdn.png',
				'alt' => 'Minh hoạ vị trí TTDN thesaigontimes.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Thesaigontimes.vn (Kinh tế Sài Gòn), chụp thực tế 18/07/2026. Vị trí TTDN: 4.650.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'doisongphapluat.com.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/doisongphapluat-vt-trangchu.png',
				'alt' => 'Minh hoạ vị trí hiển thị trang chủ doisongphapluat.com.vn cho bài PR',
				'caption' => 'Khu vực trang chủ Doisongphapluat.com.vn, chụp thực tế 18/07/2026. Vị trí Hiện thị trên trang chủ: 4.620.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'marry.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/marry-vt-trangchu.png',
				'alt' => 'Minh hoạ vị trí hiển thị trang chủ marry.vn cho bài PR',
				'caption' => 'Khu vực quảng cáo trang chủ Marry.vn (nền tảng dịch vụ cưới), chụp thực tế 18/07/2026. Vị trí Hiện thị Trang chủ (2 tuần - 1 tháng): 4.500.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'yan.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/yan-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp yan.vn cho bài PR',
				'caption' => 'Khu vực Bài mới nhất trang chủ Yan.vn, chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 4.500.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'thethao247.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/thethao247-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp thethao247.vn cho bài PR',
				'caption' => 'Khu vực tin tức trang chủ Thethao247.vn, chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 4.500.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'tienphong.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/tienphong-vt-baichuyenmuc.png',
				'alt' => 'Minh hoạ vị trí bài chuyên mục phù hợp tienphong.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Tienphong.vn (Báo Tiền Phong), chụp thực tế 18/07/2026. Vị trí Bài chuyên mục phù hợp: 4.400.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'giadinh.suckhoedoisong.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/giadinhsuckhoe-vt-bailoai3.png',
				'alt' => 'Minh hoạ vị trí bài loại 3 link trang chủ giadinh.suckhoedoisong.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Giadinh.suckhoedoisong.vn (Gia đình và Xã hội), chụp thực tế 18/07/2026. Vị trí Bài loại 3 - Link Trang chủ: 4.150.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'www.24h.com.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/24h-vt-prloai2.png',
				'alt' => 'Minh hoạ vị trí bài PR loại 2 mục phù hợp 24h.com.vn cho bài PR',
				'caption' => 'Khu vực Tin tức trong ngày trên trang chủ 24h.com.vn, chụp thực tế 18/07/2026. Vị trí Bài PR loại 2 (TTTD,KD) - Mục phù hợp: 4.100.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'vtcnews.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/vtcnews-vt-trangchuyenmuc.png',
				'alt' => 'Minh hoạ vị trí trang chuyên mục vtcnews.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Vtcnews.vn, chụp thực tế 18/07/2026. Vị trí Trang chuyên mục: 4.000.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'congluan.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/congluan-vt-chuyenmucphuhop.png',
				'alt' => 'Minh hoạ vị trí chuyên mục phù hợp congluan.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Congluan.vn (Nhà báo và Công luận), chụp thực tế 18/07/2026. Vị trí Chuyên mục phù hợp: 4.000.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'suckhoedoisong.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/suckhoedoisong-vt-chuyenmuc.png',
				'alt' => 'Minh hoạ vị trí chuyên mục suckhoedoisong.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Suckhoedoisong.vn (Sức khỏe và Đời sống), chụp thực tế 18/07/2026. Vị trí Chuyên mục: 3.880.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'thitruong.nld.com.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/thitruongnld-vt-tinngan.png',
				'alt' => 'Minh hoạ vị trí tin ngắn thitruong.nld.com.vn cho bài PR',
				'caption' => 'Khu vực Thị trường - Thitruong.nld.com.vn (chuyên trang Người Lao Động), chụp thực tế 18/07/2026. Vị trí Tin ngắn: 3.600.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'yeah1.com' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/yeah1-vt-tinchuyenmuc.png',
				'alt' => 'Minh hoạ vị trí tin chuyên mục yeah1.com cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Yeah1.com, chụp thực tế 18/07/2026. Vị trí Tin chuyên mục: 3.500.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'phunutoday.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/phunutoday-vt-toppchuyenmuc.png',
				'alt' => 'Minh hoạ vị trí bài PR top chuyên mục Home phunutoday.vn cho bài PR',
				'caption' => 'Khu vực bài PR top chuyên mục trang chủ Phunutoday.vn, chụp thực tế 18/07/2026. Vị trí Bài PR ở top chuyên mục_Home: 4.895.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'thethaovanhoa.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/thethaovanhoa-vt-cotnoibat.png',
				'alt' => 'Minh hoạ vị trí cột nổi bật chuyên mục thethaovanhoa.vn cho bài PR',
				'caption' => 'Khu vực cột nổi bật trang chủ Thethaovanhoa.vn, chụp thực tế 18/07/2026. Vị trí Cột nổi bật - CM: 4.750.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		/* Dot 5 - 2026-07-18, tiep tuc uu tien gia cao nhat (16 dau bao). */
		'phunuvagiadinh.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/phunuvagiadinh-vt-tinmoi6.png',
				'alt' => 'Minh hoạ vị trí Tin mới 6 trang chủ phunuvagiadinh.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Phunuvagiadinh.vn, chụp thực tế 18/07/2026. Vị trí Tin mới 6 - Trang chủ: 3.400.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'saostar.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/saostar-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp saostar.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Saostar.vn, chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 3.200.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'kenhtuyensinh.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/kenhtuyensinh-vt-11-20bai.png',
				'alt' => 'Minh hoạ vị trí trang chủ kenhtuyensinh.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Kenhtuyensinh.vn, chụp thực tế 18/07/2026. Vị trí 11-20 bài (gói đăng nhiều bài): 3.150.000đ/bài (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'doanhnghiepvn.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/doanhnghiepvn-vt-bailaylink.png',
				'alt' => 'Minh hoạ vị trí bài đi lấy link doanhnghiepvn.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Doanhnghiepvn.vn (Tạp chí Doanh nghiệp Việt Nam), chụp thực tế 18/07/2026. Vị trí Bài đi lấy link: 3.150.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'kinhtemoitruong.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/kinhtemoitruong-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp kinhtemoitruong.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Kinhtemoitruong.vn (Tạp chí Kinh tế Môi trường), chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 3.000.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'danviet.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/danviet-vt-doanhnghiep.png',
				'alt' => 'Minh hoạ vị trí chuyên mục Doanh Nghiệp danviet.vn cho bài PR',
				'caption' => 'Khu vực tin tức trang chủ Danviet.vn (Báo Dân Việt), chụp thực tế 18/07/2026. Vị trí Doanh Nghiệp: 2.980.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'baoquocte.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/baoquocte-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp baoquocte.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Baoquocte.vn (Báo Thế giới và Việt Nam), chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 2.800.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'phapluat.suckhoedoisong.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/phapluatsuckhoe-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp phapluat.suckhoedoisong.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật Phapluat.suckhoedoisong.vn (chuyên trang Pháp luật và Bạn đọc), chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 2.700.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'suckhoecongdongonline.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/suckhoecongdong-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp suckhoecongdongonline.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Suckhoecongdongonline.vn, chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 2.700.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'doisongvietnam.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/doisongvietnam-vt-chuyenmuc.png',
				'alt' => 'Minh hoạ vị trí chuyên mục phù hợp nội dung doisongvietnam.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Doisongvietnam.vn, chụp thực tế 18/07/2026. Vị trí Chuyên Mục Phù Hợp Nội Dung: 2.600.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'tiin.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/tiin-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp tiin.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Tiin.vn, chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 2.600.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'baoxaydung.com.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/baoxaydung-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp baoxaydung.com.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Baoxaydung.com.vn (Báo Xây dựng), chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 2.550.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'baonghean.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/baonghean-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp baonghean.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Baonghean.vn (Báo Nghệ An), chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 2.450.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'vietq.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/vietq-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp vietq.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Vietq.vn (Tạp chí Chất lượng Việt Nam), chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 2.450.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'petrotimes.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/petrotimes-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp petrotimes.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Petrotimes.vn (Tạp chí Năng lượng Mới), chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 2.400.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'nguoihanoi.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/nguoihanoi-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp nguoihanoi.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Nguoihanoi.vn (Tạp chí Người Hà Nội), chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 2.400.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		/* Dot 6 - 2026-07-18, tiep tuc uu tien gia cao nhat (14 dau bao). */
		'suckhoeviet.org.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/suckhoeviet-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp suckhoeviet.org.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Suckhoeviet.org.vn (Tạp chí Sức khỏe Việt), chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 2.250.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'xahoi.com.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/xahoicomvn-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp xahoi.com.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Xahoi.com.vn, chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 2.250.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'vietnammoi.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/vietnammoi-vt-canbiet.png',
				'alt' => 'Minh hoạ vị trí Cần biết vietnammoi.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Vietnammoi.vn, chụp thực tế 18/07/2026. Vị trí Cần biết: 2.150.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'doanhnhanvn.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/doanhnhanvn-vt-chuyenmuc.png',
				'alt' => 'Minh hoạ vị trí chuyên mục doanhnhanvn.vn cho bài PR',
				'caption' => 'Khu vực tin tức trang chủ Doanhnhanvn.vn (Tạp chí Doanh nhân Việt Nam), chụp thực tế 18/07/2026. Vị trí Chuyên mục: 2.150.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'tapchixaydung.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/tapchixaydung-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp tapchixaydung.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Tapchixaydung.vn (Tạp chí Xây dựng - Bộ Xây dựng), chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 2.100.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'golfviet.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/golfviet-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp golfviet.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Golfviet.vn, chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 2.100.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'vnfinance.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/vnfinance-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp vnfinance.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Vnfinance.vn, chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 2.100.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'xaluannews.com' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/xaluan-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp xaluannews.com cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Xaluannews.com (Xã Luận), chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 2.000.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'techz.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/techz-vt-tieumucpr4.png',
				'alt' => 'Minh hoạ vị trí tiểu mục phù hợp Bài PR4 techz.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Techz.vn, chụp thực tế 18/07/2026. Vị trí Thông tin khuyến mãi / Tiểu mục phù hợp (Bài PR4): 1.980.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'baoxaydung.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/baoxaydungvn-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp baoxaydung.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Baoxaydung.vn (Báo Xây dựng), chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 1.900.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'phunusuckhoe.giadinhonline.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/phunusuckhoegd-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp phunusuckhoe.giadinhonline.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Phunusuckhoe.giadinhonline.vn, chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 1.800.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'vietnambiz.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/vietnambiz-vt-chuyendong.png',
				'alt' => 'Minh hoạ vị trí Chuyển động thị trường vietnambiz.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Vietnambiz.vn, chụp thực tế 18/07/2026. Vị trí Chuyển động thị trường: 2.150.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'thitruongbiz.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/thitruongbiz-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp thitruongbiz.vn cho bài PR',
				'caption' => 'Khu vực Tin mới trang chủ Thitruongbiz.vn, chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 2.100.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'thanhnienviet.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/thanhnienviet-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp thanhnienviet.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Thanhnienviet.vn (Tạp chí Thanh niên Việt), chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 2.000.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		/* Dot 7 - 2026-07-18, tiep tuc uu tien gia cao nhat (14 dau bao). */
		'baocaobang.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/baocaobang-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp baocaobang.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Baocaobang.vn (Báo Cao Bằng), chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 1.800.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'suckhoephapluat.nguoiduatin.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/suckhoephapluat-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp suckhoephapluat.nguoiduatin.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Suckhoephapluat.nguoiduatin.vn, chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 1.750.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'thuonghieuvaphapluat.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/thuonghieuvaphapluat-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp thuonghieuvaphapluat.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Thuonghieuvaphapluat.vn (Tạp chí Thương hiệu và Pháp luật), chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 1.700.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'hoinhap.vanhoavaphattrien.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/hoinhap-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp hoinhap.vanhoavaphattrien.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật Hoinhap.vanhoavaphattrien.vn (chuyên trang Hội nhập - Văn hoá và Phát triển), chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 1.700.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'cafedautu.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/cafedautu-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp cafedautu.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Cafedautu.vn, chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 1.700.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'giadinhvaphapluat.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/giadinhvaphapluat-vt-phapluatkd.png',
				'alt' => 'Minh hoạ vị trí chuyên mục Pháp luật Kinh doanh giadinhvaphapluat.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Giadinhvaphapluat.vn (Gia đình và Pháp luật), chụp thực tế 18/07/2026. Vị trí phapluatkinhdoanh: 1.650.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'tuoitrexahoi.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/tuoitrexahoi-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp tuoitrexahoi.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Tuoitrexahoi.vn (Tuổi trẻ và Xã hội), chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 1.600.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'nongthonvaphattrien.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/nongthonvaphattrien-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp nongthonvaphattrien.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật Nongthonvaphattrien.vn (Tạp chí Nông thôn và Phát triển), chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 1.600.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'emdep.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/emdep-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp emdep.vn cho bài PR',
				'caption' => 'Khu vực Tin nổi bật trang chủ Emdep.vn, chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 1.600.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'nguoiduatin.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/nguoiduatin-vt-canbiet.png',
				'alt' => 'Minh hoạ vị trí Cần biết nguoiduatin.vn cho bài PR',
				'caption' => 'Khu vực Cần biết trên trang chủ Nguoiduatin.vn (Tạp chí Người Đưa Tin), chụp thực tế 18/07/2026. Vị trí Cần biết: 1.580.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'sohuutritue.net.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/sohuutritue-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp sohuutritue.net.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Sohuutritue.net.vn (Tạp chí Sở hữu trí tuệ và Sáng tạo), chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 1.550.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'giaoducthudo.giaoducthoidai.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/giaoducthudo-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp giaoducthudo.giaoducthoidai.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật Giaoducthudo.giaoducthoidai.vn (chuyên trang Giáo dục Thủ đô), chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 1.500.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'baolamdong.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/baolamdong-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp baolamdong.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Baolamdong.vn (Báo Lâm Đồng), chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 1.490.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'tapchivietduc.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/tapchivietduc-vt-mucphuhop.png',
				'alt' => 'Minh hoạ vị trí mục phù hợp tapchivietduc.vn cho bài PR',
				'caption' => 'Khu vực bài nổi bật trang chủ Tapchivietduc.vn (Tạp chí Việt - Đức), chụp thực tế 18/07/2026. Vị trí Mục phù hợp: 1.450.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),

		/* Dot 8 - 2026-07-19, tiep tuc uu tien gia cao nhat trong nhom booking-bao-pr/mua-textlink. */
		'congthuong.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/congthuong.vn-final.png',
				'alt' => 'Vị trí đăng bài PR tại mục tin trang chủ Báo Công Thương (congthuong.vn)',
				'caption' => 'Vị trí đăng: mục tin trên trang chủ Báo Công Thương (congthuong.vn). Giá tham khảo: 7.500.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'cafeland.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/cafeland.vn-final.png',
				'alt' => 'Vị trí đăng tin ngắn trên trang chủ CafeLand (cafeland.vn)',
				'caption' => 'Vị trí đăng: tin ngắn trên trang chủ CafeLand (cafeland.vn). Giá tham khảo: 4.800.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'hanoimoi.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/hanoimoi.vn-final.png',
				'alt' => 'Textlink fullsite trên báo Hànộimới (hanoimoi.vn)',
				'caption' => 'Hình thức: Textlink fullsite trên Hànộimới (hanoimoi.vn) (đặt tại menu/footer toàn trang, không cố định 1 vị trí). Thời hạn 12 tháng, giá tham khảo: 6.000.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'anninhthudo.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/anninhthudo.vn-final.png',
				'alt' => 'Textlink fullsite trên báo An ninh Thủ đô (anninhthudo.vn)',
				'caption' => 'Hình thức: Textlink fullsite trên An ninh Thủ đô (anninhthudo.vn) (đặt tại menu/footer toàn trang, không cố định 1 vị trí). Thời hạn 12 tháng, giá tham khảo: 5.556.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'baodongnai.com.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/baodongnai.com.vn-final.png',
				'alt' => 'Textlink fullsite trên Báo Đồng Nai (baodongnai.com.vn)',
				'caption' => 'Hình thức: Textlink fullsite trên Báo Đồng Nai (baodongnai.com.vn) (đặt tại menu/footer toàn trang, không cố định 1 vị trí). Thời hạn 12 tháng, giá tham khảo: 5.556.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'baodanang.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/baodanang.vn-final.png',
				'alt' => 'Textlink fullsite trên Báo Đà Nẵng (baodanang.vn)',
				'caption' => 'Hình thức: Textlink fullsite trên Báo Đà Nẵng (baodanang.vn) (đặt tại menu/footer toàn trang, không cố định 1 vị trí). Thời hạn 12 tháng, giá tham khảo: 5.556.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'home.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/home.vn-final.png',
				'alt' => 'Textlink fullsite trên Home mạng xã hội (home.vn)',
				'caption' => 'Hình thức: Textlink fullsite trên Home - mạng xã hội (home.vn) (đặt tại menu/footer toàn trang, không cố định 1 vị trí). Thời hạn 12 tháng, giá tham khảo: 5.556.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'congly.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/congly.vn-final.png',
				'alt' => 'Textlink fullsite trên báo Công lý (congly.vn)',
				'caption' => 'Hình thức: Textlink fullsite trên Công lý (congly.vn) (đặt tại menu/footer toàn trang, không cố định 1 vị trí). Thời hạn 12 tháng, giá tham khảo: 5.556.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'giaoducthoidai.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/giaoducthoidai.vn-final.png',
				'alt' => 'Textlink fullsite trên báo Giáo dục và Thời đại (giaoducthoidai.vn)',
				'caption' => 'Hình thức: Textlink fullsite trên Giáo dục & Thời đại (giaoducthoidai.vn) (đặt tại menu/footer toàn trang, không cố định 1 vị trí). Thời hạn 12 tháng, giá tham khảo: 5.556.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'baolaocai.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/baolaocai.vn-final.png',
				'alt' => 'Textlink fullsite trên Báo Lào Cai (baolaocai.vn)',
				'caption' => 'Hình thức: Textlink fullsite trên Báo Lào Cai (baolaocai.vn) (đặt tại menu/footer toàn trang, không cố định 1 vị trí). Thời hạn 12 tháng, giá tham khảo: 4.444.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'baodongthap.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/baodongthap.vn-final.png',
				'alt' => 'Textlink fullsite trên Báo Đồng Tháp (baodongthap.vn)',
				'caption' => 'Hình thức: Textlink fullsite trên Báo Đồng Tháp (baodongthap.vn) (đặt tại menu/footer toàn trang, không cố định 1 vị trí). Thời hạn 12 tháng, giá tham khảo: 4.444.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'truyenhinhnghean.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/truyenhinhnghean.vn-final.png',
				'alt' => 'Textlink fullsite trên Truyền hình Nghệ An (truyenhinhnghean.vn)',
				'caption' => 'Hình thức: Textlink fullsite trên Truyền hình Nghệ An (truyenhinhnghean.vn) (đặt tại menu/footer toàn trang, không cố định 1 vị trí). Thời hạn 12 tháng, giá tham khảo: 4.444.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),

		/* Dot 9 - 2026-07-19, tiep tuc uu tien gia cao nhat trong nhom booking-bao-pr/mua-textlink. */
		'baodaklak.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/baodaklak.vn-final.png',
				'alt' => 'Vị trí đăng bài trên trang chủ Báo Đắk Lắk (baodaklak.vn)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên trang Báo Đắk Lắk (baodaklak.vn). Giá tham khảo: 4.500.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'thethaovietnam.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/thethaovietnam.vn-final.png',
				'alt' => 'Vị trí đăng tin mới trên Thể thao Việt Nam (thethaovietnam.vn)',
				'caption' => 'Vị trí đăng: tin mới trên Thể thao Việt Nam (thethaovietnam.vn). Giá tham khảo: 2.375.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'baocamau.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/baocamau.vn-final.png',
				'alt' => 'Textlink fullsite trên Báo Cà Mau (baocamau.vn)',
				'caption' => 'Hình thức: Textlink fullsite trên Báo Cà Mau (baocamau.vn) (đặt tại menu/footer toàn trang, không cố định 1 vị trí). Thời hạn 12 tháng, giá tham khảo: 4.444.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'baoangiang.com.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/baoangiang.com.vn-final.png',
				'alt' => 'Textlink fullsite trên Báo An Giang (baoangiang.com.vn)',
				'caption' => 'Hình thức: Textlink fullsite trên Báo An Giang (baoangiang.com.vn) (đặt tại menu/footer toàn trang, không cố định 1 vị trí). Thời hạn 12 tháng, giá tham khảo: 4.444.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'baotuyenquang.com.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/baotuyenquang.com.vn-final.png',
				'alt' => 'Textlink fullsite trên Báo Tuyên Quang (baotuyenquang.com.vn)',
				'caption' => 'Hình thức: Textlink fullsite trên Báo Tuyên Quang (baotuyenquang.com.vn) (đặt tại menu/footer toàn trang, không cố định 1 vị trí). Thời hạn 12 tháng, giá tham khảo: 4.444.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'nguoidothi.net.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/nguoidothi.net.vn-final.png',
				'alt' => 'Textlink fullsite trên Người Đô Thị (nguoidothi.net.vn)',
				'caption' => 'Hình thức: Textlink fullsite trên Người Đô Thị (nguoidothi.net.vn) (đặt tại menu/footer toàn trang, không cố định 1 vị trí). Thời hạn 12 tháng, giá tham khảo: 4.444.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'huengaynay.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/huengaynay.vn-final.png',
				'alt' => 'Textlink fullsite trên Huế Ngày Nay (huengaynay.vn)',
				'caption' => 'Hình thức: Textlink fullsite trên Huế Ngày Nay (huengaynay.vn) (đặt tại menu/footer toàn trang, không cố định 1 vị trí). Thời hạn 12 tháng, giá tham khảo: 4.444.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'baolangson.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/baolangson.vn-final.png',
				'alt' => 'Textlink fullsite trên Báo Lạng Sơn (baolangson.vn)',
				'caption' => 'Hình thức: Textlink fullsite trên Báo Lạng Sơn (baolangson.vn) (đặt tại menu/footer toàn trang, không cố định 1 vị trí). Thời hạn 12 tháng, giá tham khảo: 4.444.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'baothainguyen.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/baothainguyen.vn-final.png',
				'alt' => 'Textlink fullsite trên Báo Thái Nguyên (baothainguyen.vn)',
				'caption' => 'Hình thức: Textlink fullsite trên Báo Thái Nguyên (baothainguyen.vn) (đặt tại menu/footer toàn trang, không cố định 1 vị trí). Thời hạn 12 tháng, giá tham khảo: 4.444.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'thuonghieucongluan.com.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/thuonghieucongluan.com.vn-final.png',
				'alt' => 'Textlink fullsite trên Thương hiệu và Công luận (thuonghieucongluan.com.vn)',
				'caption' => 'Hình thức: Textlink fullsite trên Thương hiệu và Công luận (thuonghieucongluan.com.vn) (đặt tại menu/footer toàn trang, không cố định 1 vị trí). Thời hạn 12 tháng, giá tham khảo: 4.444.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'doanhnghiephoinhap.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/doanhnghiephoinhap.vn-final.png',
				'alt' => 'Textlink fullsite trên Doanh nghiệp Hội nhập (doanhnghiephoinhap.vn)',
				'caption' => 'Hình thức: Textlink fullsite trên Doanh nghiệp Hội nhập (doanhnghiephoinhap.vn) (đặt tại menu/footer toàn trang, không cố định 1 vị trí). Thời hạn 12 tháng, giá tham khảo: 4.444.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),

		/* Dot 10 - 2026-07-19, tiep tuc uu tien gia cao nhat trong nhom booking-bao-pr/mua-textlink. */
		'baothuathienhue.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/baothuathienhue.vn-final.png',
				'alt' => 'Vị trí đăng bài trên Báo Thừa Thiên Huế (baothuathienhue.vn)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Báo Thừa Thiên Huế (baothuathienhue.vn). Giá tham khảo: 2.100.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'vanhoavaphattrien.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/vanhoavaphattrien.vn-final.png',
				'alt' => 'Vị trí đăng bài trên Tạp chí Văn hoá và Phát triển (vanhoavaphattrien.vn)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Tạp chí Văn hoá và Phát triển (vanhoavaphattrien.vn). Giá tham khảo: 2.100.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'bienphong.com.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/bienphong.com.vn-final.png',
				'alt' => 'Vị trí đăng bài trên Báo Biên Phòng (bienphong.com.vn)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Báo Biên Phòng (bienphong.com.vn). Giá tham khảo: 2.050.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'baotayninh.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/baotayninh.vn-final.png',
				'alt' => 'Vị trí đăng bài trên Báo Tây Ninh (baotayninh.vn)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Báo Tây Ninh (baotayninh.vn). Giá tham khảo: 1.450.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'vanhoavadoisong.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/vanhoavadoisong.vn-final.png',
				'alt' => 'Vị trí đăng bài trên Văn hoá và Đời sống (vanhoavadoisong.vn)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Văn hoá và Đời sống (vanhoavadoisong.vn). Giá tham khảo: 1.450.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'songdep.com.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/songdep.com.vn-final.png',
				'alt' => 'Vị trí đăng bài trên Sống Đẹp (songdep.com.vn)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Sống Đẹp (songdep.com.vn). Giá tham khảo: 1.400.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'khoahocvacuocsong.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/khoahocvacuocsong.vn-final.png',
				'alt' => 'Vị trí đăng bài trên Khoa học và Cuộc sống (khoahocvacuocsong.vn)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Khoa học và Cuộc sống (khoahocvacuocsong.vn). Giá tham khảo: 1.400.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'vanhoathoidai.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/vanhoathoidai.vn-final.png',
				'alt' => 'Vị trí đăng bài trên Văn hoá Thời đại (vanhoathoidai.vn)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Văn hoá Thời đại (vanhoathoidai.vn). Giá tham khảo: 1.400.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'vietnamhuongsac.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/vietnamhuongsac.vn-final.png',
				'alt' => 'Vị trí đăng bài trên Việt Nam Hương Sắc (vietnamhuongsac.vn)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Việt Nam Hương Sắc (vietnamhuongsac.vn). Giá tham khảo: 1.400.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'datnuoc.com.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/datnuoc.com.vn-final.png',
				'alt' => 'Vị trí đăng bài trên Đất Nước (datnuoc.com.vn)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Đất Nước (datnuoc.com.vn). Giá tham khảo: 1.400.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'truyenthongvaphattrien.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/truyenthongvaphattrien.vn-final.png',
				'alt' => 'Vị trí đăng bài trên Truyền thông và Phát triển (truyenthongvaphattrien.vn)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Truyền thông và Phát triển (truyenthongvaphattrien.vn). Giá tham khảo: 1.400.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'phapluatvacuocsong.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/phapluatvacuocsong.vn-final.png',
				'alt' => 'Vị trí đăng bài trên Pháp luật và Cuộc sống (phapluatvacuocsong.vn)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Pháp luật và Cuộc sống (phapluatvacuocsong.vn). Giá tham khảo: 1.400.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'giadinhmoi.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/giadinhmoi.vn-final.png',
				'alt' => 'Vị trí đăng bài trên Gia Đình Mới (giadinhmoi.vn)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Gia Đình Mới (giadinhmoi.vn). Giá tham khảo: 1.400.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'baoquangninh.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/baoquangninh.vn-final.png',
				'alt' => 'Vị trí đăng bài trên Báo Quảng Ninh (baoquangninh.vn)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Báo Quảng Ninh (baoquangninh.vn). Giá tham khảo: 1.390.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'baothanhhoa.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/baothanhhoa.vn-final.png',
				'alt' => 'Vị trí đăng bài trên Báo Thanh Hoá (baothanhhoa.vn)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Báo Thanh Hoá (baothanhhoa.vn). Giá tham khảo: 1.350.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'phunumoi.net.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/phunumoi.net.vn-final.png',
				'alt' => 'Textlink fullsite trên Tạp chí Phụ nữ Mới (phunumoi.net.vn)',
				'caption' => 'Hình thức: Textlink fullsite trên Tạp chí Phụ nữ Mới (phunumoi.net.vn) (đặt tại menu/footer toàn trang, không cố định 1 vị trí). Thời hạn 12 tháng, giá tham khảo: 1.296.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'reatimes.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/reatimes.vn-final.png',
				'alt' => 'Textlink fullsite trên Reatimes - Tạp chí Bất động sản Việt Nam (reatimes.vn)',
				'caption' => 'Hình thức: Textlink fullsite trên Reatimes - Tạp chí Bất động sản Việt Nam (reatimes.vn) (đặt tại menu/footer toàn trang, không cố định 1 vị trí). Thời hạn 12 tháng, giá tham khảo: 1.296.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),

		/* Dot 11 - 2026-07-19, hoan tat nhom booking-bao-pr/mua-textlink con lai. */
		'thieunien.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/thieunien.vn-final.png',
				'alt' => 'Textlink fullsite trên Báo Thiếu niên Tiền phong (thieunien.vn)',
				'caption' => 'Hình thức: Textlink fullsite trên Báo Thiếu niên Tiền phong (thieunien.vn) (đặt tại menu/footer toàn trang, không cố định 1 vị trí). Thời hạn 12 tháng, giá tham khảo: 1.296.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'tapchinghiencuuphathoc.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/tapchinghiencuuphathoc.vn-final.png',
				'alt' => 'Textlink fullsite trên Tạp chí Nghiên cứu Phật học (tapchinghiencuuphathoc.vn)',
				'caption' => 'Hình thức: Textlink fullsite trên Tạp chí Nghiên cứu Phật học (tapchinghiencuuphathoc.vn) (đặt tại menu/footer toàn trang, không cố định 1 vị trí). Thời hạn 12 tháng, giá tham khảo: 1.296.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'doanhnghiepkinhtexanh.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/doanhnghiepkinhtexanh.vn-final.png',
				'alt' => 'Textlink fullsite trên Tạp chí Doanh nghiệp & Kinh tế xanh (doanhnghiepkinhtexanh.vn)',
				'caption' => 'Hình thức: Textlink fullsite trên Tạp chí Doanh nghiệp & Kinh tế xanh (doanhnghiepkinhtexanh.vn) (đặt tại menu/footer toàn trang, không cố định 1 vị trí). Thời hạn 12 tháng, giá tham khảo: 1.296.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'phunuhiendai.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/phunuhiendai.vn-final.png',
				'alt' => 'Vị trí đăng bài trên Phụ nữ Hiện đại (phunuhiendai.vn)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Phụ nữ Hiện đại (phunuhiendai.vn). Giá tham khảo: 1.200.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'baovinhlong.com.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/baovinhlong.com.vn-final.png',
				'alt' => 'Vị trí đăng bài trên Báo Vĩnh Long (baovinhlong.com.vn)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Báo Vĩnh Long (baovinhlong.com.vn). Giá tham khảo: 1.160.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'baodienbienphu.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/baodienbienphu.vn-final.png',
				'alt' => 'Vị trí đăng bài trên Báo Điện Biên Phủ (baodienbienphu.vn)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Báo Điện Biên Phủ (baodienbienphu.vn). Giá tham khảo: 1.120.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'baohungyen.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/baohungyen.vn-final.png',
				'alt' => 'Vị trí đăng bài trên Báo Hưng Yên (baohungyen.vn)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Báo Hưng Yên (baohungyen.vn). Giá tham khảo: 1.120.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'daklak24h.com.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/daklak24h.com.vn-final.png',
				'alt' => 'Vị trí đăng bài trên Đắk Lắk 24h (daklak24h.com.vn)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Đắk Lắk 24h (daklak24h.com.vn). Giá tham khảo: 1.100.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'kinhtethoidai.net' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/kinhtethoidai.net-final.png',
				'alt' => 'Vị trí đăng bài trên Kinh tế Thời đại (kinhtethoidai.net)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Kinh tế Thời đại (kinhtethoidai.net). Giá tham khảo: 1.100.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'hanghoathuonghieu.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/hanghoathuonghieu.vn-final.png',
				'alt' => 'Vị trí đăng bài trên Hàng hoá và Thương hiệu (hanghoathuonghieu.vn)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Hàng hoá và Thương hiệu (hanghoathuonghieu.vn). Giá tham khảo: 1.000.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'tieudungtiepthi.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/tieudungtiepthi.vn-final.png',
				'alt' => 'Vị trí đăng bài trên Tiêu dùng và Tiếp thị (tieudungtiepthi.vn)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Tiêu dùng và Tiếp thị (tieudungtiepthi.vn). Giá tham khảo: 1.000.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'baohatinh.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/baohatinh.vn-final.png',
				'alt' => 'Vị trí đăng bài trên Báo Hà Tĩnh (baohatinh.vn)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Báo Hà Tĩnh (baohatinh.vn). Giá tham khảo: 930.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'baophutho.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/baophutho.vn-final.png',
				'alt' => 'Vị trí đăng bài trên Báo Phú Thọ (baophutho.vn)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Báo Phú Thọ (baophutho.vn). Giá tham khảo: 930.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'khoahoccuocsong.com' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/khoahoccuocsong.com-final.png',
				'alt' => 'Vị trí đăng bài trên Khoa học Cuộc sống (khoahoccuocsong.com)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Khoa học Cuộc sống (khoahoccuocsong.com). Giá tham khảo: 900.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'thitruongngaynay.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/thitruongngaynay.vn-final.png',
				'alt' => 'Vị trí đăng bài trên Thị trường Ngày nay (thitruongngaynay.vn)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Thị trường Ngày nay (thitruongngaynay.vn). Giá tham khảo: 700.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'suckhoegiadinhvietnam.com' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/suckhoegiadinhvietnam.com-final.png',
				'alt' => 'Vị trí đăng bài trên Sức khoẻ Gia đình Việt Nam (suckhoegiadinhvietnam.com)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Sức khoẻ Gia đình Việt Nam (suckhoegiadinhvietnam.com). Giá tham khảo: 700.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'thuonghieuphattrien.com' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/thuonghieuphattrien.com-final.png',
				'alt' => 'Vị trí đăng bài trên Thương hiệu Phát triển (thuonghieuphattrien.com)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Thương hiệu Phát triển (thuonghieuphattrien.com). Giá tham khảo: 700.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'camnangsuckhoeso.net' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/camnangsuckhoeso.net-final.png',
				'alt' => 'Vị trí đăng bài trên Cẩm nang Sức khoẻ Số (camnangsuckhoeso.net)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Cẩm nang Sức khoẻ Số (camnangsuckhoeso.net). Giá tham khảo: 700.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),

		/* Dot 12 - 2026-07-19, retry nhom timeout/ssl (2 domain thanh cong). */
		'baovanhoa.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/baovanhoa.vn-final.png',
				'alt' => 'Textlink fullsite trên Báo Văn hoá (baovanhoa.vn)',
				'caption' => 'Hình thức: Textlink fullsite trên Báo Văn hoá (baovanhoa.vn) (đặt tại menu/footer toàn trang, không cố định 1 vị trí). Thời hạn 12 tháng, giá tham khảo: 4.444.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
		'angiangtv.vn' => array(
			array(
				'url' => 'https://digicomvn.com/wp-content/uploads/2026/07/angiangtv.vn-final.png',
				'alt' => 'Vị trí đăng trên Đài PT-TH An Giang (angiangtv.vn)',
				'caption' => 'Vị trí đăng: chuyên mục phù hợp trên Đài PT-TH An Giang (angiangtv.vn). Giá tham khảo: 1.120.000đ (giá tham khảo tại thời điểm đăng bài, xem giá mới nhất trong bảng phía trên).',
			),
		),
	);
}

/**
 * Tim domain khop voi post_title cua dong gia (vd "Cafebiz.vn" -> "cafebiz.vn",
 * "znews.vn (Zing)" -> "znews.vn"). Tra ve chuoi rong neu khong khop dau bao nao co anh.
 *
 * QUAN TRONG (fix 2026-07-18): domain phai khop DUNG RANH GIOI - khong duoc tinh la khop
 * neu no la CHUYEN TRANG/subdomain khac cua chinh site do (vd "Ngoisao.vnexpress.net" la
 * chuyen trang rieng cua VnExpress, vi tri dang khac han trang chu vnexpress.net -> KHONG
 * duoc gan anh minh hoa cua "vnexpress.net" cho dong nay). Nhan biet bang ky tu ngay TRUOC
 * vi tri khop: neu la dau cham (".") tuc dang la subdomain khac -> loai.
 */
function dgc_gia_vitri_domain_of( $title ) {
	static $domains = null;
	if ( null === $domains ) {
		$domains = array_keys( dgc_gia_vitri_images_map() );
		usort( $domains, function( $a, $b ) { return strlen( $b ) - strlen( $a ); } );
	}
	$t = mb_strtolower( trim( (string) $title ) );
	foreach ( $domains as $d ) {
		$pos = strpos( $t, $d );
		if ( false === $pos ) continue;
		$before = $pos > 0 ? substr( $t, $pos - 1, 1 ) : '';
		$after  = substr( $t, $pos + strlen( $d ), 1 );
		if ( '.' === $before ) continue;                      // subdomain cua site khac -> loai
		if ( $before && ctype_alnum( $before ) ) continue;     // dinh lien vao 1 tu khac -> loai
		if ( $after && ( ctype_alnum( $after ) || '.' === $after ) ) continue;
		return $d;
	}
	return '';
}

/**
 * True neu it nhat 1 dong trong danh sach $items co anh minh hoa vi tri - dung de
 * chi hien chi dan "an chu V" khi bang do THAT co nut V (tranh chi dan suong khong dong).
 */
function dgc_gia_items_have_vitri( $items ) {
	foreach ( (array) $items as $it ) {
		if ( dgc_gia_vitri_domain_of( $it->post_title ) ) return true;
	}
	return false;
}
