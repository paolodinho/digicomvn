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
