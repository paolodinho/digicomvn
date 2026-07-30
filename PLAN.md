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
- [x] Case study: dựng CPT `dgc_case` (5 bài độc lập, archive `/case-study/` kiểu blog-card),
      mở rộng mỗi bài lên ~1800-1965 chữ, giữ fact + nguồn báo thật - 2026-07-14.
- [x] Section trang chủ: logo khách hàng (7 KH thật) + "Tại sao chọn DigicomVN" + "Báo chí nói về
      DigicomVN" (logo wall 10 báo: 2 bài thật có link, 8 logo chờ link) - 2026-07-14. Đều sửa từ WP Admin.
- [ ] Hiếu gửi FILE LOGO khách hàng (uploads/client-logos/) + gắn LINK bài thật cho 8 logo báo
      trong "Báo chí nói về DigicomVN" (hoặc bỏ báo chưa từng đăng để đúng E-E-A-T) - 2026-07-14.
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
- [ ] Hiếu gửi file logo mới có chữ "DigicomVN" (logo hiện tại - logo-digicom.png - nung
      sẵn chữ "Digicom" trong ảnh, đã đổi hết text trên site sang DigicomVN nhưng riêng
      file logo/favicon này cần ảnh mới mới thay được) - 2026-07-11.
- [x] External link E-E-A-T (`.claude/rules/external-link-eeat.md`): quét 130 bài + 17 trang live
      tìm mention luật/quy định - chỉ 2 bài khớp (post 3848, 3869, cùng chủ đề Thông cáo báo chí).
      Đã gắn link ra Luật Báo chí 2016 + Luật BVQLNTD 2023 (congbao/vanban.chinhphu.vn), đồng thời
      phát hiện + sửa luôn Nghị định 13/2023/NĐ-CP đã HẾT HIỆU LỰC (01/01/2026) -> cập nhật thành
      Nghị định 356/2025/NĐ-CP (văn bản thay thế). Backup:
      `~/Claude-Workspace/_backups/routines/2026-07-19/digicom-glossary-content/`. 2026-07-19.
- [x] Component icon "i" + popup giải thích thuật ngữ cho NỘI DUNG BÀI VIẾT (khác cơ chế
      `.intro-toggle` chỉ dùng trong bảng giá): shortcode `[thuatngu hien="..."]định nghĩa[/thuatngu]`
      trong `inc/glossary.php`, tái dùng modal `.intro-pop` có sẵn. Đã deploy live (DGC_VER 1.9.2),
      test OK. 2026-07-19.
- [x] Áp icon "i" cho 12 thuật ngữ chuyên ngành (DR, DA, Anchor Text, dofollow, nofollow, E-E-A-T,
      Core Web Vitals, Schema Markup, canonical, GEO, crawl budget, referring domain, topical
      authority) trên TOÀN BỘ 130 bài + 17 trang live - 115 bài có ít nhất 1 thuật ngữ (5 pillar +
      110 blog), lần nhắc đầu tiên/bài, loại trừ 8 bài mà chủ đề CHÍNH là định nghĩa thuật ngữ đó
      (tránh tự-giải-thích-chính-mình). 2026-07-19.
      - ⚠️ Sự cố quy trình: `rm -rf` server chạy trước khi kịp scp backup 110 bài về máy -> mất
        backup gốc batch này. Đã verify phục hồi 100% được bằng gỡ ngược shortcode (transform chỉ
        chèn thêm, không xoá) - xem `~/Claude-Workspace/_backups/routines/2026-07-19/digicom-glossary-posts/ROLLBACK-README.md`.
        Các batch sau đã cẩn thận copy backup về TRƯỚC khi dọn server.
      - Phát hiện 2 bug khi rải: (1) 23 bài bị shortcode lọt vào trong thẻ heading `<h2>/<h3>`,
        làm hỏng mục lục tự động (id neo bị garble, TOC hiện chữ thô) - đã gỡ sạch. (2) 4 bài
        (geo-generative-engine-optimization, ai-overview, bert-seo, viet-bai-seo) kích hoạt 1 BUG
        CÓ SẴN trong `inc/toc.php` (không phải do glossary gây ra) khiến 1 đoạn văn bị RENDER
        TRÙNG 2 LẦN (1 bản thô + 1 bản đã xử lý shortcode) - đã gỡ shortcode ở 4 bài này để né bug,
        NHƯNG bug gốc trong toc.php vẫn còn tồn tại, có thể tái phát với nội dung khác. **Cần Hiếu
        xác nhận ưu tiên sửa `inc/toc.php` (dgc_toc_process, priority 9 trên `the_content`) ở
        session riêng** - chưa rõ nguyên nhân chính xác gây trùng nội dung, cần điều tra kỹ hơn.
- [x] Sửa 2 vấn đề Hiếu phát hiện qua ảnh chụp (popup E-E-A-T trống) - 2026-07-19:
      1. **Bug popup rỗng**: đổi cơ chế lưu định nghĩa từ `<span hidden>` sang `data-gloss-def`
         attribute trên nút bấm - một số extension trình duyệt tự rỗng hoá nội dung element có
         `hidden` (nghi hidden-text/cloaking), giờ không còn element nào bị đánh dấu hidden.
         Verify bằng browser thật (Claude Chrome) - popup hiện đúng nội dung + screenshot xác nhận.
      2. **Ưu tiên link nội bộ hơn icon "i"**: 10/12 thuật ngữ đã có bài viết riêng trên site
         (DR, DA, E-E-A-T, Core Web Vitals, canonical, GEO, crawl budget, Schema Markup, dofollow,
         nofollow) -> chuyển 219 lượt từ icon "i" sang link nội bộ thẳng tới bài đó (98 bài đổi).
         Còn 3 thuật ngữ giữ icon "i" (chưa có bài riêng): Anchor Text, referring domain,
         topical authority. Rule cập nhật: `.claude/rules/external-link-eeat.md`.
- [x] Sửa lỗi Hiếu chụp ảnh báo (không liên quan glossary): bài `/backlink-dofollow-va-nofollow/`
      (post 231) có đoạn ví dụ code chứa markdown thô trong href: `<a href="[https://website-cua-ban.com](https://website-cua-ban.com)">`
      - bấm vào link này khiến trình duyệt điều hướng URL bị vỡ (đúng như ảnh chụp của Hiếu). Lỗi
      có sẵn từ khi viết bài (không phải do đợt sửa glossary), phát hiện được vì bài này vừa được
      219 link nội bộ trỏ tới nên lộ ra. Đã quét toàn site (130 bài + 17 trang) - chỉ 1 bài dính lỗi
      này. Sửa href về URL sạch, purge cache, verify lại link hoạt động đúng. Backup:
      `~/Claude-Workspace/_backups/routines/2026-07-19/digicom-markdown-leak-fix/`. 2026-07-19.

Ngoài ra không còn việc gấp - 4 dịch vụ đã đủ nội dung, giá, demo. Tiếp theo tuỳ Hiếu quyết định
khi nào chuyển sang giai đoạn 2 bên dưới.

- [x] Audit toàn bộ site (134 bài blog + 7 money page, không tính cụm Booking báo & PR đã xong
      riêng) qua 9 agent research song song, xác định gap so đối thủ + đề xuất phân lại cụm chủ đề
      - 2026-07-27. Kết quả: `content/audit-toanbo-2026-07-27.csv` (117 dòng chi tiết) +
      `content/audit-toanbo-2026-07-27-cum-de-xuat.md` (đề xuất 16 cụm mới + việc ưu tiên). Đây là
      RESEARCH thuần, CHƯA sửa bài nào - dùng làm cơ sở cho các đợt sửa tiếp theo.

### Backlog rút ra từ audit toàn site 2026-07-27 (chưa làm, chờ ưu tiên)
- [ ] Bổ sung trust signal (MST, năm hoạt động, testimonial thật) cho 7/7 money page - ưu tiên
      cao nhất, ảnh hưởng trực tiếp chuyển đổi.
- [ ] Quyết định số phận `/dich-vu-backlink-tong-quan/` (trang bán hàng ẩn trong category kiến
      thức, giá 3 gói không khớp `dgc_gia`) - gộp vào pillar hay xoá/redirect.
- [ ] Sửa cannibalization xác nhận: `/cach-viet-thong-cao-bao-chi-chuan/` ↔ `/thong-cao-bao-chi-la-gi/`.
- [ ] Sửa số liệu lỗi thời: `/ai-overview/` (tỷ lệ AI Overview), `/semrush/` + `/ahrefs-vs-semrush/`
      (giá gói Semrush One 2026), `/keyword-research/` (giá Ahrefs $129), `/thuat-toan-google/` +
      `/google-core-update/` (thiếu Core Update 5/2026 + Spam Update 6/2026).
- [ ] Sửa `/crawl-budget/` (ngưỡng sai lệch 10-1.000 lần + trích dẫn bịa gán cho Google).
- [ ] Sửa case study không kiểm chứng được ở `/technical-seo/` (lệch phạm vi dịch vụ thật).
- [ ] Áp dụng phân cụm mới (16 cụm) theo `content/audit-toanbo-2026-07-27-cum-de-xuat.md` khi
      làm lại sitemap/menu blog.

### Đợt viết bài lấp gap toàn site 2026-07-27 (tiếp, theo yêu cầu Hiếu "làm trên sheet, viết nốt bài chưa viết")
- Gap-scan 5 file từ khoá gốc (backlink 3752, guest-post 334, pr-báo 370, pr broad-match 14351
  dòng CHƯA từng khai thác, mua-textlink 7) + 3 file mới Hiếu thêm sáng nay (booking/pr/báo chí,
  không volume) đối chiếu 135 bài live -> phát hiện **gap lớn nhất dự án**: cụm "PR (Quan hệ công
  chúng) tổng quát" chưa có bài nào, riêng từ khoá "pr là gì" volume ~8.100 (đơn từ khoá lớn nhất
  từng thấy ở site này). Chi tiết: `content/plan-pr-tongquat-2026-07-27.md`.
- Danh sách 12 bài mới cần viết (ưu tiên booking/PR/báo chí theo yêu cầu): 4 bài cụm PR tổng quát
  (P1-P4) + 1 bài Booking báo Tiền Phong (T1, mã R16 đã ghi trong pivot-2026-07.md) + 5 bài cụm
  Backlink (B1-B5: Audit/Profile, Indexer, Disavow, Loại backlink, Social backlink) + 2 bài Guest
  Post (G1-G2). Sổ cái cụm mới: `content/cluster-pr-tongquat.md`.
- [x] Toàn bộ 12/12 bài ĐÃ ĐĂNG LIVE - 2026-07-27: P1 `/pr-la-gi/` (4722), P2 `/cac-loai-hinh-pr/`
      (4728), P3 `/case-study-chien-dich-pr/` (4732), P4 `/mo-hinh-race-pr/` (4737), T1
      `/book-bao-tien-phong/` (4720, cụm booking-báo 22/22), B1 `/backlink-audit/` (4739), B2
      `/backlink-indexer/` (4751), B3 `/disavow-backlink/` (4749), B4 `/cac-loai-backlink/`
      (4746), B5 `/backlink-mang-xa-hoi/` (4759), G1 `/guest-post-forbes/` (4763), G2
      `/pitch-guest-post/` (4761). Sổ cái: `content/cluster-pr-tongquat.md` (4/4),
      `content/cluster-backlink-gap.md` (5/5), `content/cluster-guest-post-gap.md` (2/2).
- [ ] Submit Google Search Console cho các bài chưa submit được (phần lớn B1-B5, G1-G2, T1 -
      phiên trình duyệt agent không có session Google đăng nhập sẵn) - Hiếu tự đăng nhập rồi
      submit tay, hoặc chờ sitemap tự crawl.
- [ ] Site-wide: KHÔNG có thẻ `<meta name="description">`/Open Graph ở bất kỳ trang nào (RankMath
      không active) - phát hiện khi viết P1, đã spawn task riêng cho Hiếu, chưa xử lý.

### Backlog (giai đoạn 2 - sau khi 4 dịch vụ ổn định)
- [ ] Mở lại Thiết kế website / Tên miền / Hosting / Bản quyền phần mềm (trang đang draft, giữ nguyên)
- [ ] Cổng đăng ký/thanh toán thật
- [ ] Client area / quản lý dịch vụ

### Schema toàn site (2026-07-27) - ĐÃ XONG
- [x] Dựng `inc/schema.php` - 1 khối @graph/trang, 0 lỗi trên validator.schema.org (169 URL).
- [x] Gỡ 108 khối JSON-LD nhúng trong 58 bài, chuyển 197 câu FAQ sang meta có ô sửa ở WP Admin.
- [x] Offer giá thật theo từng đầu báo (18 bài), OfferCatalog hạng mục phổ biến, fix @id trùng
      giữa trang phân trang và trang 1.
- [x] `inc/seo-meta.php`: meta description + Open Graph + Twitter Card + canonical trang lưu trữ +
      ô "SEO & Schema" sửa tiêu đề/mô tả từng bài trong WP Admin. QA 171 URL = 0 lỗi.
- [x] `tools/schema-vocab-check.py` - kiểm định theo từ vựng schema.org chính thức, quét cả site
      (thay cho validator.schema.org bị giới hạn 429). Bắt được lỗi `inLanguage` trên EntryPoint.
- [ ] **Cần Hiếu làm:** thiết kế 1 ảnh chia sẻ 1200x630 của DigicomVN rồi điền vào WP Admin >
      DigicomVN > mục 0 > "Anh chia se mac dinh". Hiện đang fallback về logo (1278x363) nên khi
      share Facebook/Zalo bị viền trên dưới. (KHÔNG dùng `ogimagedn.jpg` ở thư mục gốc - đó là
      logo Báo Đà Nẵng, không phải của Digicom.)
- [ ] Bật Review/AggregateRating khi có đánh giá khách hàng thật (tên + nội dung khách viết).

### Trang /cau-hoi-thuong-gap/ (2026-07-29) - ĐÃ DỰNG CODE, CHỜ VERIFY
- [x] `inc/faq-page.php`, `page-cau-hoi-thuong-gap.php`, hook auto-tạo page trong `functions.php`,
      option `faq_page_extra` (12 câu research SERP/PAA), schema FAQPage, link footer/menu.
- [ ] Hiếu mở Local, Start site "digicom" (session này không có công cụ điều khiển desktop để tự
      bấm) -> trang tự tạo ở lần load đầu -> mở `http://digicom.local/cau-hoi-thuong-gap/` xem
      thực tế (chỉ mới lint PHP, chưa xem trình duyệt).
- [ ] Chạy `tools/schema-qa.py` + `tools/meta-qa.py` sau khi site chạy được.
- [ ] Nếu site dùng WP Admin > Giao diện > Menu (custom nav menu) thay vì menu fallback trong
      code -> thêm link "Câu hỏi thường gặp" vào đó (menu code fallback chỉ áp dụng khi CHƯA có
      custom menu).
- [ ] Rà trùng lặp giữa `faqs`/`faq_page_extra` (mới) và nội dung `svc_faqs` hiện có trên live/DB
      thật (session này không truy cập được DB để đối chiếu).

### Audit "vị trí đăng" báo (2026-07-29) - 1 lỗi đã fix, 1 lỗi lớn hơn đang chờ quyết định
- [x] Fix lỗi gộp vị trí booking-pr (`export-web.py` KEY_CHI_TIET) - booking-pr 303 -> 568 dòng.
- [x] Wire nút "V" (ảnh minh hoạ vị trí thật) vào bảng giá - tính năng có sẵn từ 2026-07-18
      nhưng chưa từng hoạt động (chưa render ở đâu).
- [x] Xây bảng alias 123 tên báo -> domain thật (113 tự động đối chiếu với domain có sẵn trong
      data, 10 verify qua WebSearch) - khôi phục thêm 382 dòng. Tiện fix luôn bug `fold()` gốc
      (no-op "đ"->"d") ảnh hưởng mọi bộ lọc trong export-web.py.
- [x] Kết quả cuối: booking-pr 303 -> **950 dòng** (x3.1), tổng gia-web.csv 1190 -> 1837 dòng.
      Vnexpress.net: 1 -> 22 vị trí. ~40 tên còn mơ hồ (Molistar, Wow, Otofun...) CỐ Ý chưa
      alias, vẫn bị loại - an toàn hơn đoán sai domain giá.
- [x] Deploy 10 file theme + đẩy dữ liệu giá lên LIVE (digicomvn.com) - 2026-07-29.
      Backup DB + theme trước khi làm: `~/Claude-Workspace/_backups/routines/2026-07-29/
      live-deploy-vitri-fix/` (db-BEFORE.sql, theme-BEFORE.tar.gz).
      Sự cố nhỏ: thiếu `inc/post-sidebars.php` trên live gây Fatal Error ~1-2 phút, đã deploy
      nốt file và khắc phục ngay.
      Kết quả: dgc_gia publish 1175 -> 1625 (176 cập nhật giá + 450 tạo mới, 369 giữ nguyên vì
      khớp bản ghi đang draft - không hồi sinh oan, 20 mơ hồ giữ nguyên). VnExpress.net 1 -> 18 bài.
      Trang `/cau-hoi-thuong-gap/` sống (37 câu hỏi), nút "V" hiện 190 lần trên `/bang-gia/`.
- [x] Batch 2 (2026-07-30): đẩy nốt 13 alias mới xác minh lên live. Phát hiện + fix bug
      `recover-vitri.py` (nhiều dòng CSV khác quy_cách bị gộp nhầm vào 1 ID live, ghi đè giá
      cho nhau) - sau fix: 57 update sạch (không trùng ID) + 170 tạo mới. dgc_gia publish
      1625 -> 1795.
- [x] Đồng bộ dữ liệu giá vào Local WP (dev site) - dùng lại pipeline recover-vitri (bản
      local, dump qua wp-cli trực tiếp không cần SSH). Local từ 209 -> **2001 bài publish**
      (1792 tạo mới + 2 cập nhật giá), khớp dữ liệu với live để test theme đáng tin cậy hơn.
- [x] Batch 3 (2026-07-30): xác minh qua WebSearch 8/8 tên còn lại có thể xác định được domain
      thật - Sài gòn giải phóng (sggp.org.vn), Molistar (molistar.com), Viez (viez.vn),
      Phunusuckhoe (phunusuckhoe.vn), Sinh viên việt nam (svvn.tienphong.vn), Yacht Style
      (yachtstyle.vn), Men's Folio (mensfolio.vn), Wow (worldofwatches.vn - KHÔNG phải
      Wowweekend, xác minh qua cùng batch LUXUO MEDIA với Yacht Style/Men's Folio). Còn lại
      thật sự không xác định được (Blogtamsu mơ hồ 4 domain, Vnmedia đã tạm dừng, "Mua bán nhà
      đất" quá chung chung) - vẫn giữ nguyên KHÔNG alias theo rule an toàn.
      gia-web.csv 1868 -> 1880 dòng. Đẩy live: dgc_gia publish 1795 -> **1830** (35 dòng, loại
      6 dòng booking-truyen-hinh khỏi batch - phát hiện nhóm TV "tạm ẩn" theo pivot 2026-07-16
      đã bị batch đầu vô tình publish 19/33 dòng, không mở rộng thêm sai lệch này).
      Đồng bộ Local: 2001 -> **2036** bài.
- [x] Bảng giá quá dài (1212 dòng booking-bao-pr) - Hiếu chọn: đếm giới hạn theo ĐẦU BÁO
      (không theo dòng vị trí con) + thêm bộ lọc Excel (Khoảng giá, Điểm DR) cạnh bộ lọc có
      sẵn (ngành/loại link/số ảnh/độ dài). Sửa `inc/cpt-gia.php` (dgc_facet_value + 2 nhóm lọc
      mới, mode max/range) + `assets/js/main.js` (applyFilter đếm theo topRows, không mồ côi
      dòng con). Sự cố deploy: quyền file `700` sau `mv` từ thư mục scp tạm -> main.js 403,
      đã `chmod 644` + purge cache. Verify qua Browser thật: mặc định 10 báo (trước 1212),
      lọc "vnexpress" còn 2 báo, lọc "Trên 20 triệu" còn 10 báo/52 dòng - đúng thiết kế.
      DGC_VER 2.1.8 -> 2.1.9. Đã đồng bộ live + Local WP.
- [x] Đổi cây vị trí sang MẶC ĐỊNH THU GỌN (đảo ngược quyết định 2026-07-29 theo yêu cầu
      Hiếu) + thêm cột khoảng giá trên dòng gốc (min-max cả nhóm) + bộ lọc mới "Vị trí đăng"
      (Trang chủ/Chuyên mục/Tiểu mục/Doanh nghiệp viết). Verify: mặc định 10 dòng = 10 báo,
      bấm "Mở rộng vị trí" xổ đủ, lọc vị trí hoạt động đúng. DGC_VER 2.1.9 -> 2.2.0.
- [x] Nút "Xem thêm" tự nạp khi cuộn (bỏ IntersectionObserver không chắc chắn -> scroll
      listener + setTimeout). DGC_VER -> 2.2.2. Verify: cuộn tự nạp liên tục 10 -> 418/418 báo.
- [x] Fix bug bộ lọc Khoảng giá: dòng gốc hardcode data-price="0" vô tình khớp mọi filter
      "dưới X triệu" -> đổi thành giá thấp nhất thật trong nhóm. DGC_VER -> 2.2.3.
- [ ] Việc còn lại (không khẩn, cần Hiếu quyết định):
      1. 33 dòng `booking-truyen-hinh` hiện có 19 publish/14 draft không nhất quán trên live -
         chọn draft lại 19 dòng đó (giữ đúng quyết định "tạm ẩn") hay chính thức mở nhóm TV.
      2. Blogtamsu/Vnmedia/"Mua bán nhà đất" - chỉ alias nếu Hiếu cung cấp domain xác nhận.
