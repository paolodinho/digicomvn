# PLAN - digicomvn.com (Textlink, Backlink, Guest Post, Booking báo & PR)

## Mục tiêu tổng
Website digicomvn.com tập trung 4 dịch vụ off-page SEO (Mua Textlink, Dịch vụ Backlink,
Guest Post, Booking báo & PR), chạy trên WP Local, demo gửi khách. Mở rộng thiết kế
web/tên miền/hosting ở giai đoạn 2.

## Milestones
- [x] M1 - Wireframe trang chủ - 2026-06-27
- [x] M2 - Chốt design system + wireframe trang con
- [x] M3 - Build theme WP trên Local (định hướng tên miền/hosting ban đầu)
- [x] M3b - PIVOT sang 4 dịch vụ Textlink/Backlink/Guest Post/Booking báo PR - 2026-07-02
- [ ] M4 - Xác nhận đầu báo thật + publish trang booking-bao-pr + nội dung chi tiết
- [ ] M5 - QA responsive đầy đủ + deploy demo gửi khách

## Sprint hiện tại (từ 2026-07-02)

### Đã xong (pivot 2026-07-02)
- [x] Tải + phân cụm 5 file CSV từ khoá, chốt sitemap silo 4 pillar
- [x] Backup DB + theme `digicom-host` trước khi sửa (`_backups/2026-07-02/pivot-build/`)
- [x] Build hub `/dich-vu/` + 4 pillar (mua-textlink, dich-vu-backlink, guest-post, booking-bao-pr)
- [x] Ngách `/dich-vu/dich-vu-backlink/bat-dong-san/`
- [x] 5 trang con booking theo đầu báo (VnExpress, Kenh14, Dân Trí, 24h, CafeF) - trạng thái DRAFT
- [x] Ẩn/draft toàn bộ trang ten-mien/hosting/lap-trinh-website/ban-quyen-*/dich-vu-seo/automation cũ
- [x] Rebuild menu chính (dropdown Dịch vụ), front-page.php, options.php, page-bang-gia.php
- [x] QA: HTTP 200 tất cả URL sitemap, PHP lint sạch, desktop screenshot sạch, không lỗi console

### Sắp làm (cần Hiếu quyết định/bổ sung)
- [ ] Xác nhận danh sách đầu báo THẬT Digicom hợp tác -> publish (hoặc sửa) trang con booking-bao-pr
- [ ] Bổ sung nội dung chi tiết 4 pillar (case study thật nếu có, không bịa số liệu)
- [ ] QA mobile 390px thực tế (lần này chỉ QA desktop 1440px do giới hạn công cụ trong session)
- [ ] Trang `/blog/` nuôi từ khoá informational (backlink-la-gi, guest-post-la-gi...)

### Backlog (giai đoạn 2 - sau khi 4 dịch vụ ổn định)
- [ ] Mở lại Thiết kế website / Tên miền / Hosting / Bản quyền phần mềm (trang đang draft, giữ nguyên)
- [ ] Cổng đăng ký/thanh toán thật
- [ ] Client area / quản lý dịch vụ

## Blocker / Chờ quyết định
- Danh sách đầu báo thật Digicom hợp tác (để publish đúng, không bịa quan hệ chưa có).
