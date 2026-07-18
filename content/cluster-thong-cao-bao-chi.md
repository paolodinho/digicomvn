# Sổ cái cụm "thông cáo báo chí"

> Nguồn: `content/plan-thong-cao-bao-chi-2026-07-18.md`. Category: `booking-bao-pr`.

| # | Bài | Vai trò | Trạng thái | URL dự kiến | File nội dung |
|---|---|---|---|---|---|
| 1 | Thông Cáo Báo Chí Là Gì? Định Nghĩa, Vai Trò, Ai Viết | Pillar | ✅ LIVE (post ID 3848) - 2026-07-18 | https://digicomvn.com/thong-cao-bao-chi-la-gi/ | `content/thong-cao-bao-chi-la-gi.html` |
| 2 | Cách Viết Thông Cáo Báo Chí Chuẩn: Cấu Trúc, 5W1H, Ví Dụ | Cluster | ✅ LIVE (post ID 3849) - 2026-07-18 | https://digicomvn.com/cach-viet-thong-cao-bao-chi-chuan/ | `content/cach-viet-thong-cao-bao-chi-chuan.html` |
| 3 | Mẫu Thông Cáo Báo Chí: Tổng Hợp Theo Từng Mục Đích | Cluster | ✅ LIVE (post ID 3850) - 2026-07-18 | https://digicomvn.com/mau-thong-cao-bao-chi/ | `content/mau-thong-cao-bao-chi.html` |
| 4 | Thông Cáo Báo Chí Xử Lý Khủng Hoảng: Mẫu Và Cách Viết Xin Lỗi Khách Hàng | Cluster | ✅ LIVE (post ID 3869) - 2026-07-19 | https://digicomvn.com/thong-cao-bao-chi-xu-ly-khung-hoang/ | `content/thong-cao-bao-chi-xu-ly-khung-hoang.html` |

**Cụm đã xong 4/4 bài.**

## Đã đăng live 2026-07-18/19 (session có SSH trên máy Hiếu)

4 bài đã đăng qua SSH Hostinger (`wp post create`), gán category `booking-bao-pr` (term_id 24),
thumbnail đã render (`tools/blog-thumbnail/render-illus.py`) + set featured image, cache đã purge
(`wp cache flush` + `wp litespeed-purge all`). Link 2 chiều từ bài cũ
`/cach-viet-bai-pr-chuan-bao-chi/` (post 1277) đã chèn - backup content.raw trước khi sửa tại
`~/Claude-Workspace/_backups/routines/2026-07-18/digicom-thong-cao-bao-chi/`.
Chi tiết đầy đủ từng bước xem `content/run-2026-07-18.md` phần "Đăng live" và
`content/run-2026-07-19.md`.

**Bài 4 - đợt research lại sau phản hồi Hiếu ("chưa research, thua bài top"):** research SERP
đầu (WebSearch chung) không đủ sâu - fetch trực tiếp top 5-6 URL thật cho thấy top rank nhờ
(a) 3-5 mẫu theo tình huống thay vì 1 mẫu chung, (b) trích dẫn luật cụ thể (luatvietnam,
giaychungnhan, accgroup, thuvienphapluat.vn đều có lớp pháp lý). Đã sửa bài: 1 mẫu -> 3 mẫu
(xin lỗi/thu hồi SP, đính chính, sự cố kỹ thuật), thêm mục "Cơ sở pháp lý" với 3 căn cứ đã
verify qua nguồn thật (Luật Báo chí 2016 số 103/2016/QH13, Luật Bảo vệ quyền lợi người tiêu
dùng 2023 số 19/2023/QH15, Nghị định 13/2023/NĐ-CP bảo vệ dữ liệu cá nhân - mốc 72 giờ báo Bộ
Công an khi rò rỉ dữ liệu), thêm 1 FAQ liên quan. Không trích số liệu mức phạt (Nghị định
87/2026/NĐ-CP quá mới, chưa đọc được toàn văn để xác nhận chi tiết) và không bịa case study
thật hay file .docx tải về (rule content-professional + rule đã có ở bài 3). Từ ~2.360 từ lên
~3.200 từ. Không có case study thật thì top cũng không có (kể cả top cũng dùng case giả lập ghi
rõ minh hoạ) - không phải chỗ cần đầu tư thêm.

## Internal link đã cài sẵn trong nội dung (đã verify curl 200 - 2026-07-19)

- Bài 1 -> bài 2 (`/cach-viet-thong-cao-bao-chi-chuan/`), bài 1 -> bài 3
  (`/mau-thong-cao-bao-chi/`), bài 1 -> bài 4 (`/thong-cao-bao-chi-xu-ly-khung-hoang/`), bài 1
  -> bài cũ `/cach-viet-bai-pr-chuan-bao-chi/`, bài 1 -> money page `/booking-bao-pr/` (anchor
  "dịch vụ viết & đăng thông cáo báo chí").
- Bài 2 -> bài 1, bài 2 -> bài 3, bài 2 -> bài 4, bài 2 -> money page `/booking-bao-pr/`.
- Bài 3 -> bài 1, bài 3 -> bài 2, bài 3 -> bài 4, bài 3 -> money page `/booking-bao-pr/`.
- Bài 4 -> bài 1, bài 4 -> bài 2, bài 4 -> bài 3, bài 4 -> money page `/booking-bao-pr/`.

## Widget đã chèn

`[dgc_offpage_quiz]` - bài 1, 2, 3 (đúng gợi ý mục 5 plan, đặt sau 2-3 H2 đầu).
`[dgc_agency_check]` - bài 4 (checklist chấm điểm agency, phù hợp intent gần commercial hơn
khi doanh nghiệp cần thuê ngoài xử lý khủng hoảng gấp).

## Đợt research lại sâu bài 1-3 (2026-07-19, sau phản hồi "3 bài trước cũng thế, thua đối thủ")

Hiếu chỉ ra bài 4 không phải trường hợp cá biệt - cả 3 bài đầu cũng viết trước khi research đủ
sâu (chỉ WebSearch snippet, không WebFetch full nội dung top). Chạy lại đúng quy trình cho cả 3:

- **Bài 1 (Pillar)**: research xác nhận vietnix.vn (~2.900 từ) hơn hẳn draft cũ (~700 từ) -
  thiếu khái niệm "boilerplate", thiếu mục lỗi thường gặp, 0 trích luật trong khi 2/3 đối thủ
  (luatvietnam, careerlink) đều trích Điều 38 Luật Báo chí 2016. Đã sửa: thêm cách gọi tên 6
  phần chuẩn PR (headline/dateline/lead/body/quote/boilerplate), thêm H2 "Lỗi thường gặp" (5
  lỗi), thêm trích dẫn Điều 38 Luật Báo chí 2016 (số 103/2016/QH13) - đã verify nội dung thật
  qua nguồn (Điều 38 = "Cung cấp thông tin cho báo chí", không trực tiếp về TCBC nhưng có liên
  quan, diễn đạt đúng mức độ liên quan, không thổi phồng). ~700 -> ~1.840 từ.
- **Bài 2 ("Cách viết")**: research xác nhận tanca.io (~2.300 từ) và miccreative.vn (~2.800 từ)
  đều có khung thứ 2 (SOLAADS của Frank Jefkins) + cấu trúc 6 phần đặt tên chuẩn, draft cũ chỉ
  có 5W1H + cấu trúc 3 phần chung chung. Đã sửa: thêm khung SOLAADS (7 yếu tố, đã verify qua
  nguồn - Subject/Organisation/Location/Advantages/Applications/Details/Source, tác giả Frank
  Jefkins xác nhận là người thật, cựu Trưởng phòng PR Rentokil), đổi cấu trúc "3 phần" thành "6
  phần" có tên riêng (khớp cách gọi ở bài 1), thêm chuẩn độ dài tiêu đề 8-12 từ. KHÔNG thêm
  nhiều mẫu theo tình huống dù đối thủ có - tránh cannibalize với bài 3 (đã có sẵn, đúng rule
  A2c chống ăn thịt từ khoá). ~950 -> ~1.780 từ.
- **Bài 3 ("Mẫu")**: research xác nhận miccreative.vn phủ 9 tình huống, draft cũ chỉ có 5. File
  .docx tải về (luatvietnam có) KHÔNG phải điều kiện cứng để rank - miccreative dài/sâu nhất
  nhưng không có file, chỉ hướng dẫn tự dùng Canva/Google Docs. Đã sửa: thêm 4 mẫu mới (bổ
  nhiệm nhân sự cấp cao, công bố vòng gọi vốn/đầu tư, hoạt động CSR/cộng đồng, nhận giải
  thưởng/chứng nhận) - đủ 9/9 tình huống, thêm 1 đoạn hướng dẫn dùng Canva/Google Docs để tự
  trình bày (thành thật, không claim có file tải sẵn - đúng rule đã ghi trong META bài này).
  KHÔNG thêm case thương hiệu thật (Samsung/FIFA/Vinamilk như miccreative) - vi phạm rule
  do-dont.md "không nhắc tên công ty/đối thủ trong bài". ~700 -> ~2.036 từ.
- **Gap phát hiện thêm khi sửa**: cả bài 1 và bài 3 bị MẤT link tới bài 4 khi đăng lại lần đầu
  ở đợt 2026-07-19 sáng - lý do: link đó trước đó chỉ được chèn vào 1 bản backup riêng
  (`~/Claude-Workspace/_backups/...`), không lưu lại vào file nguồn trong `content/`, nên lần
  đăng lại từ file nguồn đã ghi đè mất link. Đã phát hiện qua QA link ngay sau khi đăng và sửa
  lại kịp thời (chưa để lâu trên live). Bài học: MỌI edit chèn link phải áp trực tiếp vào file
  nguồn trong `content/`, không sửa riêng bản backup rồi quên đồng bộ ngược.
- Cả 3 bài đã purge cache, verify curl (H1/thumbnail/internal link 200/0 dash lỗi), và **re-submit
  GSC URL Inspection** (Google đã index từ lần đăng trước, lần này bấm "Yêu cầu lập chỉ mục" để
  yêu cầu crawl lại nội dung mới).
