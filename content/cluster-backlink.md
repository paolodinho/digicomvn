# Sổ cái cụm Backlink & Off-page

Nguồn: `content/plan-backlink-2026-07-19.md`. 23 bài cũ (2026-07-03) không liệt kê lại ở đây
(đã publish, ổn định) - sổ cái này chỉ theo dõi phần MỚI/SỬA của đợt tiếp tục 2026-07-19.

| # | Việc | Trạng thái | File nguồn / URL | Ngày |
|---|---|---|---|---|
| 1 | Audit SEO title pillar `/dich-vu-backlink/` (page ID 268, kw "dịch vụ backlink") | ✅ Đã audit - KHÔNG cần sửa (xem mục "Kết quả audit" dưới) | page ID 268 | 2026-07-19 |
| 2 | Sửa title/H1 bài "backlink bất động sản" (kw "backlink chất lượng bất động sản") | ✅ Đã sửa file nguồn, CHỜ đăng (cần session có SSH để `wp post update` + xác nhận post ID thật) | `_content-p1/backlink-bat-dong-san.html` | 2026-07-19 |
| 3 | Mới: Có Nên Mua Backlink Không? | ✅ Đã research + viết xong, CHỜ đăng (cần session có SSH) | `content/co-nen-mua-backlink-khong.html` | 2026-07-19 |
| 4 | Mới: Mua Backlink Báo Là Gì? Khác Gì Booking Báo & PR? | ✅ Đã research + viết xong, CHỜ đăng (cần session có SSH) | `content/mua-backlink-bao-la-gi.html` | 2026-07-19 |
| 5 | Mới: Cách Đặt Backlink Hiệu Quả Cho Website Mới Bắt Đầu (P1) | ⏳ Chưa làm - đợt sau (tách việc nặng làm từ từ theo yêu cầu Hiếu) | - | - |

## Kết quả audit mục 1 (pillar `/dich-vu-backlink/`)

Không có SSH/WebFetch tới live trong phiên này nên không đọc trực tiếp được `<title>` hiện
tại của page ID 268. Tuy nhiên đối chiếu 3 nguồn độc lập trong project đều gọi đúng tên dịch
vụ là **"Dịch vụ Backlink"** (khớp chính xác keyword "dịch vụ backlink", 3.600 vol):
- `.claude/rules/dich-vu.md`: "**Dịch vụ Backlink** - hệ thống backlink chất lượng, đa nguồn."
- `wp-theme/digicom-host/page-dich-vu.php` dòng 18: `'title' => 'Dịch vụ Backlink'`.
- `functions.php` `dgc_seo_title_map()`: CHỈ có override cho page 475 (Booking báo & PR, vì
  label menu và SEO title cố tình khác nhau) - page 268 KHÔNG có override, nghĩa là lúc xây
  dựng không ai thấy cần đổi `<title>` khác `post_title`.

**Kết luận: khả năng cao title đã đúng sẵn, KHÔNG cần sửa.** Khuyến nghị: xác nhận 1 lần qua
`wp post get 268 --field=post_title` khi có SSH cho chắc chắn - nếu đúng là "Dịch vụ Backlink"
thì đóng việc này, không cần thêm entry vào `dgc_seo_title_map()`.

## Nghiên cứu + info gain đã áp dụng (bắt buộc theo rule global `~/.claude/CLAUDE.md`)

### Bài 3 - Có Nên Mua Backlink Không?

1. **Search intent**: informational-commercial (trust/gỡ nghi ngại trước khi mua). Bằng
   chứng: 9/9 kết quả tìm được (lptech.asia, giupbanhocnghe.com, seotoro.vn, seothetop.com,
   kinhtedothi.vn, baoquangnam.vn, buffseo.com, seoviet.vn, aznet.vn) đều là bài blog dạng
   "phân tích lợi ích + rủi ro + khuyến cáo", không có trang sản phẩm/landing page thuần.
2. **Phân tích đối thủ**: đã đọc toàn bộ danh sách trên (không đọc sâu từng trang bằng
   WebFetch do site ngoài không kiểm soát được, dùng snippet + summary từ WebSearch).
   Gap chung: hầu hết chỉ liệt kê lợi ích/rủi ro chung chung, KHÔNG có bảng tiêu chí cụ thể
   để tự đánh giá 1 nhà cung cấp, và không có trang nào gắn trực tiếp với quy trình vận hành
   thật của 1 đơn vị (đều nói chung chung "chọn nơi uy tín" mà không định nghĩa "uy tín" là
   gì cụ thể).
3. **Allintitle**: không lấy được số liệu chính xác qua công cụ hiện có (WebSearch không phải
   Google Search trực tiếp, không trả về số đếm allintitle thật) - quan sát định tính: nhiều
   biến thể cùng loại nội dung đã được viết ("có nên mua backlink không", "mua backlink có
   tốt không") -> KHÔNG phải từ khoá dễ top tuyệt đối, nhưng KD nguồn dữ liệu gốc (CSV) không
   ghi KD cho các biến thể này (chỉ có volume ~20-50/kw) nên rủi ro cạnh tranh thấp hơn nhóm
   "dịch vụ backlink"/"mua backlink" (KD 36-41).
4. **Info gain đã áp dụng**: (a) bảng 4 tiêu chí cụ thể chọn NCC uy tín (dấu hiệu tốt vs dấu
   hiệu rủi ro - đối thủ không ai làm bảng này), (b) gắn thẳng vào quy trình thật của Digicom
   (không PBN, cho xem site trước khi đặt) thay vì nói chung chung, (c) giải thích cơ chế kỹ
   thuật SpamBrain/link spam update thay vì chỉ nói "có thể bị phạt".

### Bài 4 - Mua Backlink Báo Là Gì?

1. **Search intent**: mixed informational + transactional. Bằng chứng: 10/10 kết quả gồm
   6 trang DỊCH VỤ của đối thủ trực tiếp (danaseo.net, hapodigital.com, backlinkaz.com,
   famemedia.vn, foogleseo.com, muabacklinkbao.com, prbaochi.com) và chỉ 2 bài định nghĩa
   thuần "là gì" (litado.edu.vn, mdigi.vn) - xác nhận đây là từ khoá cửa ngõ dẫn thẳng vào
   quyết định mua, không phải informational thuần.
2. **Phân tích đối thủ**: đã đọc toàn bộ 10 kết quả qua WebSearch. Gap: KHÔNG có đối thủ nào
   làm rõ so sánh "mua backlink báo" khác gì "booking báo & PR"/PR báo chí nói chung - tất cả
   chỉ định nghĩa 1 chiều rồi bán dịch vụ ngay, không giúp khách phân biệt 2 lựa chọn.
3. **Allintitle**: cùng hạn chế công cụ như trên - không có số đếm chính xác. Quan sát: cụm
   "mua backlink báo" bị đối thủ cạnh tranh trực tiếp (bán dịch vụ) chiếm phần lớn top 10,
   nhưng bài của Digicom nhắm góc SO SÁNH (khác nội dung bán hàng thuần) nên không cạnh tranh
   trực diện cùng 1 dạng nội dung.
4. **Info gain đã áp dụng**: bảng so sánh trực tiếp "Mua backlink báo" vs "Booking báo & PR"
   (mục đích, nội dung, loại link, phù hợp khi nào) - đây là góc nội dung KHÔNG có đối thủ nào
   làm, tận dụng đúng lợi thế Digicom đang bán cả 2 dịch vụ nên có thể so sánh trung thực.

## Giới hạn cần lưu ý cho session sau (SSH/host)

- 2 bài mới + 1 bài sửa đều mới ở dạng FILE HTML sẵn sàng (`content/*.html`,
  `_content-p1/backlink-bat-dong-san.html`) - CHƯA đăng/cập nhật lên WordPress vì phiên này
  không có SSH tới Hostinger.
- Việc cần làm khi có SSH (theo BƯỚC 6-8 skill `content-pipeline`):
  1. `wp post get 268 --field=post_title` - xác nhận mục 1, đóng việc nếu đúng.
  2. Tìm đúng post ID bài "backlink bất động sản" hiện tại (`wp post list --s="backlink bất
     động sản"`), backup content.raw, `wp post update` bằng nội dung đã sửa trong
     `_content-p1/backlink-bat-dong-san.html`.
  3. `wp post create` cho 2 bài mới từ `content/co-nen-mua-backlink-khong.html` và
     `content/mua-backlink-bao-la-gi.html` (category backlink-offpage), sau đó `wp media
     import` thumbnail theo `tools/blog-thumbnail/`.
  4. Chèn 1-2 link ngược từ bài cũ liên quan trỏ về 2 bài mới (chưa làm trong bước này).
  5. Submit Google Search Console (rule BƯỚC 7b) sau khi đăng.
  6. Cập nhật lại bảng trạng thái trong file này thành ✅ kèm URL live + ngày đăng thật.
