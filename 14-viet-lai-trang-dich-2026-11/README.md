# Viết lại trang đích digicomvn.com - bản nháp (02/11/2026)

Trạng thái: BẢN NHÁP, chưa đăng, chưa sửa WordPress. Chờ Hiếu duyệt.

## Cấu trúc
- `nhap/<slug>.html` - 29 bản nháp Gutenberg, giữ nguyên URL. Đầu mỗi file: comment ghi URL, SEO title, meta description, H1, các khối theme giữ nguyên (`<!-- GIU KHOI THEME: ... -->`: bảng giá động, form, nút Mua ngay).
- `research/<slug>.md` - research từng trang: từ chính + GSC 90 ngày, dạng trang top 10, đối thủ đã đọc (tên/link đối thủ CHỈ nằm ở đây), gap, hướng viết. Nội bộ, không đăng.
- `research/gsc-*.tsv`, `research/live-2026-11-02/`, `research/serp-2026-11-02/serp.csv` - dữ liệu gốc.
- `banner/banner-chuong-trinh.html` + `xem-truoc-375|768|1440.png` - banner chương trình đặt dưới hero trang chủ (VPS cho dân vibe code, hosting WordPress, booking báo PR), giá lấy từ trang live 02/11/2026.
- `_backup/` - bản trước khi sửa trong quá trình QA.

## 29 trang
- Off-page: mua-textlink, dich-vu-backlink, dich-vu-backlink/bat-dong-san, guest-post, backlink-social-entity, backlink-quoc-te
- Booking: booking-bao-pr, dich-vu-toplist, booking-truyen-hinh, quang-cao-phat-thanh, booking-fanpage, booking-kol-koc
- SEO: dich-vu-seo, dich-vu-seo-ai, dich-vu-seo-local, dich-vu-seo-quoc-te, dich-vu-viet-bai-chuan-seo, phan-mem-seo, khoa-hoc-seo
- Web/hạ tầng: ten-mien, hosting, cloud-server, thiet-ke-website, cham-soc-website, email-doanh-nghiep, chung-chi-ssl, dang-ky-website-bo-cong-thuong
- Chung: trang-chu, ve-digicom

## QA đã chạy (02/11/2026)
- Em dash/en dash: 0 trong nhap/ và banner/.
- Tên/link đối thủ, tên nhà cung cấp: 0. Nhắc .gov.vn/.edu.vn chỉ ở câu từ chối hoặc link nguồn luật.
- Từ sáo trong danh sách cấm: 0.
- Banner: không tràn ngang ở 375/768/1440.

## Phát hiện trên site live (cần sửa trước hoặc cùng lúc đăng)
- Giá lệch giữa meta/title và bảng giá: hosting (16k vs 18k), tên miền (.vn 450k/.com 25k vs 495k/388k), chăm sóc web (1.620.000 vs 1.761.000), SSL (221k vs 236k).
- Khối quà tặng hosting vẫn hiện dù đã bỏ ngày 31/10.
- 8 trang web/hạ tầng mang câu miễn trừ giá sai ngữ cảnh ("bảng giá toà soạn/nhà đài").
- Đăng ký website Bộ Công Thương 2.348.000đ, cao gấp khoảng 2,5-3 lần mặt bằng 750-900k.
- GSC có truy vấn cờ bạc (dentoto, kudatoto, pg168...) trỏ vào /ve-digicom/, /case-study/, /dich-vu-toplist/: HTML live không thấy chuỗi chèn, cần kiểm Search Console (Kiểm tra URL, Liên kết).
- "báo giá backlink" đang đứng nhầm /backlink-quoc-te/ (vị trí 35); nháp chuyển trọng tâm từ này về /dich-vu-backlink/.
- Dưới 1.500 từ: toplist, phát thanh, guest post, social entity, nhóm web/hạ tầng (700-1.100 từ) - nhóm web/hạ tầng là trang bán có bảng giá, không độn chữ.

## Câu hỏi cho Hiếu (trích từ research từng trang)
Textlink nhóm C trống giá; cam kết duy trì guest post; công khai giá 4 gói social entity; có nhận VOH không; khung giá gói SEO; chi tiết khoá học; link affiliate + VAT phần mềm SEO; dự án web thật để dẫn; thời gian kích hoạt cloud + cho Docker/mở cổng; thời gian kích hoạt Workspace/M365; cấp lại SSL miễn phí; có ghi công khai "5 nhân sự"; case Dodanong 2020 trước ngày thành lập pháp nhân (11/2021); có bỏ khối trống "Điều kiện làm việc" trong template.

## Quyết định khi đăng (02/11/2026)
- Đã đăng đủ 4 nhóm (29 trang), gửi GSC qua gsc_index.py add.
- "5 nhân sự": bỏ khỏi chữ hiển thị, schema Organization giữ numberOfEmployees.
- Dodanong: ghi là dự án của đội sáng lập (trước khi có pháp nhân 11/2021).
- Phần mềm SEO: chưa có link affiliate, để form tư vấn.
- Cloud server: kích hoạt "trong giờ hành chính", không ghi số giờ.
- SSL: giữ "cấp lại trong kỳ", không ghi "miễn phí" (chưa xác nhận).
- Textlink nhóm C: báo giá theo từng site. Social entity: không công khai giá gói.
- Phát thanh: bỏ VOH. Khoá học SEO: không đăng chi tiết khoá.
- Chăm sóc website: không ghi số giờ phản hồi/tần suất backup (chờ Hiếu).
- NAP: giữ "huyện Đông Anh" như hồ sơ hiện tại (chờ Hiếu xác nhận cách ghi sau sáp nhập).
- Trang chủ: hero thành slider ưu đãi (4 chương trình, giá tự đọc bảng giá), dưới là H1 + 3 nhóm dịch vụ (SEO | Booking báo PR | Website & Hosting). Brian SỬA RỒI ĐĂNG -> đã sửa (tương phản dark/slider, nút 44px, chuyển slide không chồng chữ); Jett ĐẠT, đã đổi meta description trang chủ. Ảnh: banner/trang-chu-*.png.
