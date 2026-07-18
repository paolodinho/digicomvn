# Sổ cái cụm "thông cáo báo chí"

> Nguồn: `content/plan-thong-cao-bao-chi-2026-07-18.md`. Category: `booking-bao-pr`.

| # | Bài | Vai trò | Trạng thái | URL dự kiến | File nội dung |
|---|---|---|---|---|---|
| 1 | Thông Cáo Báo Chí Là Gì? Định Nghĩa, Vai Trò, Ai Viết | Pillar | ✅ LIVE (post ID 3848) - 2026-07-18 | https://digicomvn.com/thong-cao-bao-chi-la-gi/ | `content/thong-cao-bao-chi-la-gi.html` |
| 2 | Cách Viết Thông Cáo Báo Chí Chuẩn: Cấu Trúc, 5W1H, Ví Dụ | Cluster | ✅ LIVE (post ID 3849) - 2026-07-18 | https://digicomvn.com/cach-viet-thong-cao-bao-chi-chuan/ | `content/cach-viet-thong-cao-bao-chi-chuan.html` |
| 3 | Mẫu Thông Cáo Báo Chí: Tổng Hợp Theo Từng Mục Đích | Cluster | ✅ LIVE (post ID 3850) - 2026-07-18 | https://digicomvn.com/mau-thong-cao-bao-chi/ | `content/mau-thong-cao-bao-chi.html` |
| 4 | Thông Cáo Báo Chí Xử Lý Khủng Hoảng: Mẫu Và Cách Viết Xin Lỗi Khách Hàng | Cluster | ⬜ Chưa viết (đợt sau, đúng giới hạn batch 3 bài/lần) | `/thong-cao-bao-chi-xu-ly-khung-hoang/` (chưa chốt) | - |

## Đã đăng live 2026-07-18 (session có SSH trên máy Hiếu)

3 bài đã đăng qua SSH Hostinger (`wp post create`), gán category `booking-bao-pr` (term_id 24),
thumbnail đã render (`tools/blog-thumbnail/render-illus.py`) + set featured image, cache đã purge
(`wp cache flush` + `wp litespeed-purge all`). Link 2 chiều từ bài cũ
`/cach-viet-bai-pr-chuan-bao-chi/` (post 1277) đã chèn - backup content.raw trước khi sửa tại
`~/Claude-Workspace/_backups/routines/2026-07-18/digicom-thong-cao-bao-chi/`.
Chi tiết đầy đủ từng bước xem `content/run-2026-07-18.md` phần "Đăng live".

## Internal link đã cài sẵn trong nội dung (đã verify curl 200 - 2026-07-18)

- Bài 1 -> bài 2 (`/cach-viet-thong-cao-bao-chi-chuan/`), bài 1 -> bài 3
  (`/mau-thong-cao-bao-chi/`), bài 1 -> bài cũ `/cach-viet-bai-pr-chuan-bao-chi/`,
  bài 1 -> money page `/booking-bao-pr/` (anchor "dịch vụ viết & đăng thông cáo báo chí").
- Bài 2 -> bài 1, bài 2 -> bài 3, bài 2 -> money page `/booking-bao-pr/`.
- Bài 3 -> bài 1, bài 3 -> bài 2, bài 3 -> money page `/booking-bao-pr/`.
- KHÔNG link tới bài 4 (chưa tồn tại) - tránh 404.

## Widget đã chèn

`[dgc_offpage_quiz]` - 1 lần/bài ở cả 3 bài (đúng gợi ý mục 5 plan, đặt sau 2-3 H2 đầu).
