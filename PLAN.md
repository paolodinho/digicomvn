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
- [x] M3c - Đảo lại lần 2: bỏ hẳn tên miền/hosting (Hiếu đổi ý), phục hồi backlink-focus - 2026-07-02/03
- [x] M4a - Audit internal link (attractor), draft 73 bài kiến thức SEO không liên quan,
      giữ 23 bài cluster Backlink, sửa link chết - 2026-07-03
- [x] M4b - Bảng giá đầy đủ 209 dòng (CPT `dgc_gia`) + tool tra cứu/ước tính trên `/bang-gia/` - 2026-07-03
- [x] M4c - Đối chiếu 6 file từ khoá thật, viết + đăng 12 bài blog mới cho 4 dịch vụ
      (4 P0 + 8 P1/P2), sửa lỗi trùng H1 toàn site - 2026-07-03
- [x] M4d - Xác nhận đầu báo hợp tác thật (Hiếu confirm), publish 5 trang con booking-bao-pr,
      thêm mục "Đầu báo hỗ trợ đặt bài" trên trang chủ với 16 logo thật (15 tải trực tiếp từ
      website báo, 1 từ Wikimedia Commons vì laodong.vn chặn bot) - 2026-07-03
- [x] M5 - Duyệt giá, gắn ảnh 12 bài blog, build lại template blog/single, fix CSS demo tĩnh,
      re-export + push gh-pages, QA mobile - 2026-07-03

- [x] M6 - Thêm 10 trang con booking-bao-pr (Vietnamnet, Thanh Niên, Tuổi Trẻ, Znews, Soha,
      Afamily, Eva, CafeBiz, Webtretho, Báo Đầu Tư - tổng 15 trang con), fix trang pillar
      booking-bao-pr mồ côi (thêm link tới cả 15 trang con), gắn thumbnail cho 23 bài blog cũ
      còn lại (35/35 bài blog đều có ảnh thật) - 2026-07-03

- [x] M7 - Redesign toàn bộ giao diện theme digicom-host theo template GrowMark (màu xanh dương
      #4761FF, font Roboto+Montserrat, icon tròn, testimonial carousel, nút back-to-top) -
      2026-07-06. Backup theme cũ trước khi sửa.

- [x] M8 - Marquee logo báo chạy vô hạn + thêm 5 đầu báo thật (Afamily, Eva, CafeBiz, Webtretho,
      Báo Đầu Tư); xoá hub `/dich-vu/` không style (chuyển menu thành dropdown-only, không xoá
      dữ liệu) - 2026-07-06.
- [x] M9 - Đẩy bảng giá lên từng trang dịch vụ + tool ước tính chi phí (`inc/service-pricing.php`,
      `dgc_current_nhom()`), định dạng giá có phân cách hàng nghìn (`dgc_format_price()`), chuyển
      calculator từ giá trung bình (mean) sang trung vị (median) sau khi phát hiện nhóm Dịch vụ
      Backlink chỉ có gói cao cấp làm mean bị lệch - 2026-07-06.
- [x] M10 - Viết đầy đủ Điều khoản sử dụng + Chính sách bảo mật (chuẩn EEAT), gắn link footer
      (trước đó là text không bấm được); phát hiện và dọn 2 trang trùng lặp do tạo nhầm - 2026-07-06.
- [x] M11 - Republish 73 bài kiến thức SEO tổng quát đã draft trước đó, dọn dẹp category trùng
      lặp từ phiên làm việc cũ, tổ chức lại theo cụm chủ đề (category.php mới: tab-bar chuyển cụm
      + CTA cuối trang), thêm block "Bài viết liên quan" + CTA off-page SEO trên single.php - 2026-07-06.
- [x] M12 - Thay icon emoji (phông chữ hệ điều hành, trông rẻ tiền) trong contact-info bằng SVG
      inline riêng (`dgc_icon()`) - 2026-07-06.
- [x] M13 - Dọn trang chủ theo feedback: bỏ hero quick-link chips, bỏ 2 section liệt kê giá/gói
      trùng với `/bang-gia/`, gộp "Chúng tôi là ai" vào section "Vì sao chọn Digicom", fix
      khoảng cách contact-info box - 2026-07-06.
- [x] M14 - Phát hiện + gỡ ảnh đội ngũ SAI (watermark "Integrity" của công ty khác, sót lại từ
      placeholder GrowMark) khỏi hero + section "Chúng tôi là ai", thay bằng placeholder trung
      tính chờ ảnh thật; thêm chú thích "ví dụ minh hoạ" cho tên trong testimonial (theo lựa
      chọn của Hiếu, tránh vi phạm rule content-professional); dựng khung tab "Case study"
      (rỗng, chờ Hiếu gửi số liệu thật); thêm hiệu ứng đèn flash phóng viên toàn site (tắt khi
      trình duyệt bật prefers-reduced-motion) - 2026-07-06.
- [x] M15 - Bảng giá Booking báo & PR (118 dòng) thêm sidebar lọc theo nhóm báo: Báo lớn (23),
      Báo tỉnh (23), Đài truyền hình (8), Kinh tế - Tài chính (19), Giải trí - Đời sống (20),
      Công nghệ - Ô tô (9), An ninh - Pháp luật (6), Bất động sản - Xây dựng (4), Y tế (2),
      Giáo dục (2), Thể thao (2) - phân loại thủ công dựa trên bản chất thật của từng đầu báo
      (không đoán/bịa), lưu vào postmeta `nganh` sửa được qua WP Admin. Thêm hiệu ứng con trỏ
      chuột hình ngòi bút nhà báo toàn site (SVG inline, không ảnh hưởng UX) - 2026-07-06.

### Sắp làm
- [ ] Hiếu tự submit sitemap `https://digicomvn.com/wp-sitemap.xml` lên Google Search Console
      (Sitemaps > Add a new sitemap) - Claude không có kết nối GSC trong phiên này nên không
      submit hộ được. Đã dọn xong 25 trang thừa (draft + 301) trước khi submit - 2026-07-11.
- [x] Hiếu xác nhận 15 đầu báo trong `/dich-vu/booking-bao-pr/[bao]/` (vnexpress, kenh14,
      dan-tri, 24h, cafef, vietnamnet, thanh-nien, tuoi-tre, znews, soha, afamily, eva,
      cafebiz, webtretho, bao-dau-tu) là hợp tác THẬT - giữ nguyên publish, không cần draft
      lại. Ghi chú này thay thế cảnh báo trong pivot-2026-07.md (M4 đã xong) - 2026-07-11.
- [ ] Internal-link audit (skill `/internal-link-audit`): phát hiện ~89 bài cũ đang link về URL
      cũ dạng blog (`/dich-vu-backlink/`, `/pr-bao-chi/`...) thay vì money page thật
      (`/dich-vu/[slug]/`) - CHƯA sửa, cần crawl Screaming Frog để xác nhận trước khi fix hàng loạt.
- [ ] Gửi ảnh đội ngũ Digicom THẬT để thay placeholder hero + "Chúng tôi là ai" (ảnh cũ dùng
      nhầm là ảnh stock có watermark công ty khác, đã gỡ 2026-07-06).
- [ ] Xác nhận vị trí file logo khách hàng thật (Hiếu nói đã gửi nhưng chưa tìm thấy trong WP
      media/Downloads) để dựng section logo giữa phần "Đầu báo" và "Testimonial".
- [ ] Gửi nội dung/số liệu case study thật để điền vào tab Case study (khung đã dựng sẵn, đang rỗng).
- [ ] Hiếu tự mở digicom.local kiểm tra giao diện mới, xác nhận màu #4761FF ưng ý.
Ngoài ra không còn việc gấp - 4 dịch vụ đã đủ nội dung, giá, demo. Tiếp theo tuỳ Hiếu quyết định
khi nào chuyển sang giai đoạn 2 bên dưới.

### Backlog (giai đoạn 2 - sau khi 4 dịch vụ ổn định)
- [ ] Mở lại Thiết kế website / Tên miền / Hosting / Bản quyền phần mềm (trang đang draft, giữ nguyên)
- [ ] Cổng đăng ký/thanh toán thật
- [ ] Client area / quản lý dịch vụ
