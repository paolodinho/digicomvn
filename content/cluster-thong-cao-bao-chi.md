# Sổ cái cụm "thông cáo báo chí"

> Nguồn: `content/plan-thong-cao-bao-chi-2026-07-18.md`. Category: `booking-bao-pr`.

| # | Bài | Vai trò | Trạng thái | URL dự kiến | File nội dung |
|---|---|---|---|---|---|
| 1 | Thông Cáo Báo Chí Là Gì? Định Nghĩa, Vai Trò, Ai Viết | Pillar | ⏳ Viết xong, CHƯA ĐĂNG (chờ Hiếu paste WP Admin hoặc chạy SSH) - 2026-07-18 | `/thong-cao-bao-chi-la-gi/` | `content/thong-cao-bao-chi-la-gi.html` |
| 2 | Cách Viết Thông Cáo Báo Chí Chuẩn: Cấu Trúc, 5W1H, Ví Dụ | Cluster | ⏳ Viết xong, CHƯA ĐĂNG - 2026-07-18 | `/cach-viet-thong-cao-bao-chi-chuan/` | `content/cach-viet-thong-cao-bao-chi-chuan.html` |
| 3 | Mẫu Thông Cáo Báo Chí: Tổng Hợp Theo Từng Mục Đích | Cluster | ⏳ Viết xong, CHƯA ĐĂNG - 2026-07-18 | `/mau-thong-cao-bao-chi/` | `content/mau-thong-cao-bao-chi.html` |
| 4 | Thông Cáo Báo Chí Xử Lý Khủng Hoảng: Mẫu Và Cách Viết Xin Lỗi Khách Hàng | Cluster | ⬜ Chưa viết (đợt sau, đúng giới hạn batch 3 bài/lần) | `/thong-cao-bao-chi-xu-ly-khung-hoang/` (chưa chốt) | - |

## Vì sao "viết xong" nhưng chưa đăng

Session này chạy trên môi trường cloud, không có `ssh`/`scp` và không có key
`~/.ssh/id_ed25519` của Hiếu (theo `.claude/rules/deploy.md` key chỉ có trên máy Hiếu) ->
không thể `wp post create` qua SSH như quy trình chuẩn bước 6 của skill content-pipeline.
Hiếu đã chọn phương án: viết đủ nội dung, xuất file HTML, tự đăng thủ công.

## Cách đăng thủ công (Hiếu tự làm hoặc chạy trong session có SSH)

1. Mở từng file trong `content/thong-cao-bao-chi-la-gi.html`,
   `content/cach-viet-thong-cao-bao-chi-chuan.html`, `content/mau-thong-cao-bao-chi.html`.
2. Đọc khối comment META ở đầu file (title, meta description, slug, category) - điền vào
   WP Admin khi tạo bài mới.
3. Copy phần nội dung Gutenberg (từ `<!-- wp:heading {"level":1} -->` trở xuống) dán vào
   **Code Editor** của Gutenberg (không phải Visual Editor) - tránh vỡ block.
4. Gán category `booking-bao-pr`, `post_status = publish`, `post_author = 1`.
5. Sau khi cả 3 bài live: đăng ký GSC URL Inspection từng bài (rule bước 7b của skill).
6. Chèn 1 link 2 chiều từ bài cũ `/cach-viet-bai-pr-chuan-bao-chi/` trỏ về bài 1
   `/thong-cao-bao-chi-la-gi/` (đúng sơ đồ link plan mục 4 - "link chéo") - bài này chưa
   tự sửa vì cần backup content.raw trước khi sửa bài cũ (rule routine-backup), để dành cho
   session có SSH.
7. Không có bước render thumbnail (`tools/blog-thumbnail/`) vì cần post ID sau khi đăng và
   cần chạy trong môi trường có Python/font đã cài - làm sau khi có ID thật.

## Internal link đã cài sẵn trong nội dung (chưa verify curl vì chưa live)

- Bài 1 -> bài 2 (`/cach-viet-thong-cao-bao-chi-chuan/`), bài 1 -> bài 3
  (`/mau-thong-cao-bao-chi/`), bài 1 -> bài cũ `/cach-viet-bai-pr-chuan-bao-chi/`,
  bài 1 -> money page `/booking-bao-pr/` (anchor "dịch vụ viết & đăng thông cáo báo chí").
- Bài 2 -> bài 1, bài 2 -> bài 3, bài 2 -> money page `/booking-bao-pr/`.
- Bài 3 -> bài 1, bài 3 -> bài 2, bài 3 -> money page `/booking-bao-pr/`.
- KHÔNG link tới bài 4 (chưa tồn tại) - tránh 404.

## Widget đã chèn

`[dgc_offpage_quiz]` - 1 lần/bài ở cả 3 bài (đúng gợi ý mục 5 plan, đặt sau 2-3 H2 đầu).
