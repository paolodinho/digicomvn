# Sổ cái cụm Backlink & Off-page

Nguồn: `content/plan-backlink-2026-07-19.md`. 23 bài cũ (2026-07-03) không liệt kê lại ở đây
(đã publish, ổn định) - sổ cái này chỉ theo dõi phần MỚI/SỬA của đợt tiếp tục 2026-07-19.

| # | Việc | Trạng thái | File nguồn / URL | Ngày |
|---|---|---|---|---|
| 1 | Audit SEO title pillar `/dich-vu-backlink/` (page ID 268, kw "dịch vụ backlink") | ✅ Đã xác nhận qua SSH: `wp post get 268 --field=post_title` = "Dịch vụ Backlink" - ĐÚNG, không cần sửa | page ID 268 | 2026-07-19 |
| 2 | Sửa title/H1 bài "backlink bất động sản" (kw "backlink chất lượng bất động sản") | ✅ ĐÃ ĐĂNG - post ID 1276, title/H1/link nội bộ đã cập nhật, verify curl 200 | https://digicomvn.com/backlink-bat-dong-san/ | 2026-07-19 |
| 3 | Mới: Có Nên Mua Backlink Không? | ✅ ĐÃ ĐĂNG - post ID 4226, category Backlink & Off-page, widget `[dgc_offpage_quiz]` render OK, thumbnail gắn (attachment 4227) | https://digicomvn.com/co-nen-mua-backlink-khong/ | 2026-07-19 |
| 4 | Mới: Mua Backlink Báo Là Gì? Khác Gì Booking Báo & PR? | ✅ ĐÃ ĐĂNG - post ID 4228, category Backlink & Off-page, widget `[dgc_budget_calc]` render OK (class `bcalc`), thumbnail gắn (attachment 4229) | https://digicomvn.com/mua-backlink-bao-la-gi/ | 2026-07-19 |
| 5 | Mới: Cách Đặt Backlink Hiệu Quả Cho Website Mới Bắt Đầu (P1) | ✅ ĐÃ XỬ LÝ theo phương án 2 (refresh, xem mục "Cảnh báo" dưới) - bổ sung mục 3.8 "Lộ trình theo giai đoạn tuổi domain" vào post 232, không viết bài mới | https://digicomvn.com/back-link-hieu-qua/ | 2026-07-20 |

## ⚠️ Cảnh báo cannibalization - bài P1 KHÔNG viết như plan gốc (2026-07-19)

Khi research SERP cho bài 5 ("cách đặt backlink hiệu quả", "cách đi backlink", "hướng dẫn đặt
backlink"), phát hiện site ĐÃ CÓ bài **post ID 232, slug `back-link-hieu-qua`, title "Cách Đi
Backlink Hiệu Quả: 7 Kỹ Thuật Thực Chiến"** phủ gần như CHÍNH XÁC cùng intent + cùng cụm từ khoá
- thậm chí bài cũ có hẳn mục "[Thực Chiến] 7 Kỹ thuật Đi Backlink Hiệu Quả nhất **cho Website
Mới**" (khớp luôn phần "website mới bắt đầu" trong tên bài 5 dự kiến).

Bước research sơ bộ ở `content/plan-backlink-2026-07-19.md` mục 0 (search `site:digicomvn.com`)
KHÔNG phát hiện ra bài này (index Google mỏng, không hiện). Đây đúng là rủi ro plan đã tự cảnh
báo trước ("cần 1 lượt xác nhận nhanh qua wp post list TRƯỚC khi viết") nhưng bước đó chưa chạy
kịp cho bài 5 vì hết bài P0 mới đến lượt research bài này.

Theo rule `A2c` (chống ăn thịt từ khoá, `content-pipeline/SKILL.md`): "1 primary keyword = 1 URL
duy nhất" và "phát hiện 2 bài cũ đang ăn thịt nhau -> cần Hiếu duyệt, không tự gộp/xoá, không tự
viết thêm bài mới trùng". Vì vậy đã DỪNG không viết bài 5 theo đúng đề bài gốc.

**3 phương án, chờ Hiếu chọn:**
1. **Huỷ bài 5** - post 232 đã phủ đủ, không cần thêm bài informational cùng cụm.
2. **REFRESH post 232** thay vì viết mới - bổ sung riêng phần "lộ trình theo giai đoạn tuổi
   domain cho website mới" (góc info gain dự kiến của bài 5) vào bài 232 hiện có, giữ URL/SEO
   equity đã tích luỹ, có internal link 2 chiều với 2 bài mới hôm nay luôn.
3. **Viết bài 5 với góc THỰC SỰ khác** (không phải biến thể cùng ý) - vd chỉ tập trung 100% vào
   "lộ trình backlink theo mốc thời gian cho website mới" (0-3-6-12 tháng) như 1 loại nội dung
   khác hẳn dạng "7 kỹ thuật" của bài 232, đặt title/H1 rõ ràng KHÔNG trùng cụm "cách đi/đặt
   backlink hiệu quả" ở đầu, để tránh 2 bài đua cùng 1 cụm.

Khuyến nghị: phương án 2 (REFRESH) - tận dụng bài 232 đã có traffic/index, tránh pha loãng.

**Đã xử lý (2026-07-20)**: chọn phương án 2. Bổ sung mục "3.8. Lộ trình đi backlink theo giai
đoạn tuổi domain (áp dụng riêng cho website mới)" vào post 232 - đúng góc info gain "lộ trình
0-3-6-12 tháng" dự kiến ban đầu cho bài P1, có 2 internal link mới (`/guest-post/`,
`/dich-vu-backlink/`). Backup content.raw trước khi sửa
(`~/Claude-Workspace/_backups/routines/2026-07-19/content-pipeline/232-back-link-hieu-qua.raw.html`),
verify curl 200 + 2 link render đúng, submit GSC yêu cầu lập chỉ mục lại.

## Internal link 2 chiều đã chèn (2026-07-19)

- Post 1276 (backlink-bat-dong-san) → thêm 2 link tới bài 3 (`/co-nen-mua-backlink-khong/`) và
  bài 4 (`/mua-backlink-bao-la-gi/`) trong block "BÀI VIẾT LIÊN QUAN".
- Post 1260 (booking-bao-la-gi) → thêm 1 link tới bài 4 (`/mua-backlink-bao-la-gi/`) trong đoạn
  so sánh "Khi nào nên dùng booking báo thay vì các hình thức off-page khác" (anchor "mua backlink báo").
- Bài 3 và bài 4 tự link 2 chiều với nhau ngay trong nội dung gốc (không cần chèn thêm).
- Verify: curl cả 4 URL trên đều 200, href đúng đích xuất hiện trong HTML live sau khi purge cache.

## Kết quả audit mục 1 (pillar `/dich-vu-backlink/`)

Session này có SSH - chạy trực tiếp `wp post get 268 --field=post_title --allow-root` trả về
**"Dịch vụ Backlink"** - khớp chính xác keyword "dịch vụ backlink" (3.600 vol). Xác nhận 100%,
KHÔNG cần thêm entry vào `dgc_seo_title_map()`. Đóng việc.

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

## Đã hoàn tất tại session có SSH (2026-07-19, tiếp tục từ Claude Code on the web)

Toàn bộ 5 việc còn thiếu ở phiên trước đã xử lý xong: audit title (mục 1), đăng bài sửa +
2 bài mới (mục 2-4), internal link 2 chiều, submit GSC (xem `content/run-2026-07-19-backlink.md`
để có bảng kiểm chứng đầy đủ từng bước). Backup + manifest tại
`~/Claude-Workspace/_backups/routines/2026-07-19/content-pipeline/` và
`~/Claude-Workspace/_backups/routines/2026-07-19/manifest.md`.

Còn lại duy nhất: bài 5 (P1 - Cách đặt backlink hiệu quả) chưa viết.
