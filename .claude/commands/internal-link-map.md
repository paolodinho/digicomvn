---
description: Vẽ sơ đồ internal link (radial + bảng) của 1 cụm bài digicomvn.com - chỉ đọc, không sửa gì lên live
argument-hint: [slug category | "từ khoá" | url1,url2,...]
---

Cụm cần audit: `$ARGUMENTS`

## Bước 1 - Xác định cách gọi `tools/internal-link-map.py`

Không chắc `$ARGUMENTS` là gì -> chạy trước:
```bash
cd "/Users/dohieu/My Drive/Projects/digicom" && python3 tools/internal-link-map.py --list-categories
```
Rồi chọn đúng 1 trong 3 cách theo `$ARGUMENTS`:
- Khớp đúng 1 slug trong danh sách category -> `--category "$ARGUMENTS"`
- Chứa dấu phẩy hoặc bắt đầu bằng `http`/chứa `.com` -> `--urls "$ARGUMENTS"`
- Còn lại (cụm từ tiếng Việt tự do) -> `--search "$ARGUMENTS"`

## Bước 2 - Lấy dữ liệu

```bash
cd "/Users/dohieu/My Drive/Projects/digicom" && python3 tools/internal-link-map.py <cờ đã chọn> "<giá trị>" > /tmp/il-data.json
```
Kiểm `cluster_size` > 0 trong file JSON trước khi đi tiếp; rỗng thì báo Hiếu ngay, không dựng sơ đồ rỗng.

## Bước 3 - Dựng file HTML sơ đồ

```bash
cd "/Users/dohieu/My Drive/Projects/digicom" && python3 tools/internal-link-map-render.py /tmp/il-data.json "<Tên cụm dễ đọc>" /tmp/il-map.html
```
`<Tên cụm dễ đọc>` = tên category/từ khoá viết hoa tự nhiên (vd "Cụm Guest Post", "Cụm Booking Báo & PR").

## Bước 4 - Publish Artifact

Dùng tool `Artifact` với `file_path=/tmp/il-map.html`, `favicon="🔗"`, `description` ngắn nêu tên cụm.
Nếu đã từng publish sơ đồ cho ĐÚNG cụm này trong phiên hiện tại -> gọi lại với cùng `file_path` để cập nhật link cũ; cụm khác/lần đầu -> publish mới.

## Bước 5 - Báo cáo ngắn kèm link Artifact

Không lặp lại toàn bộ dữ liệu trong chat (đã có trong sơ đồ) - chỉ nêu:
- Link Artifact.
- Số bài, số link nội bộ, số bài "mồ côi" (chưa được link tới).
- Top 2-3 bài hub (được link tới nhiều nhất).
- Gợi ý ngắn nếu thấy bất thường (vd 1 bài quan trọng đang mồ côi, hoặc quá nhiều bài dồn link về 1 chỗ).

KHÔNG tự chèn/sửa link nào lên live ở lệnh này - đây là công cụ CHỈ ĐỌC. Muốn chèn link thật, dùng riêng `tools/internal-link-auto.py --apply` sau khi Hiếu xem sơ đồ và chỉ định.
