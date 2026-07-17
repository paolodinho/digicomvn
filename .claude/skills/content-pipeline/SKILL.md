---
name: content-pipeline
description: >
  Quy trình content TỰ ĐỘNG end-to-end cho digicomvn.com: nhận topic/keyword ->
  check trùng cụm + volume -> research SERP -> viết bài -> chèn widget tương tác ->
  thumbnail -> đăng LIVE qua SSH -> internal link -> verify -> log.
  Trigger: "viết bài <topic>", "chạy pipeline content", "đăng bài về <chủ đề>".
---

# Digicom Content Pipeline - từ topic tới bài live

Mọi bước dưới đây chạy TỰ ĐỘNG một mạch, chỉ dừng ở CHECKPOINT duy nhất (bước 1)
khi topic chưa được Hiếu duyệt trước.

Config nguồn sự thật: `.claude/context/brand-info.md` (đọc TRƯỚC, không hardcode).
Quy tắc viết: skill global `content-writer` + rule `content-professional`, `typography-dash`.

## BƯỚC 1 - NHẬN TOPIC + GATE (checkpoint duy nhất)

1. Input: topic/keyword từ Hiếu, hoặc lấy dòng đầu `content/queue.md` (nếu có).
2. Check trùng: `wp post list --post_type=post --s="<keyword>"` trên live + đối chiếu
   cụm pillar trong brand-info mục 7. Trùng intent với bài đã có -> chuyển sang chế độ
   REFRESH bài cũ (giữ 100% + bổ sung), không viết bài mới.
3. Rule `publish-volume-warning`: topic thuộc cụm ngách, hoặc batch >3 bài cùng cụm ->
   báo số liệu volume + số intent thật, CHỜ Hiếu xác nhận. Topic Hiếu đã chỉ định
   trực tiếp trong yêu cầu = ĐÃ DUYỆT, đi tiếp không hỏi.

## BƯỚC 2 - RESEARCH SERP (không báo cáo, dùng để viết)

WebSearch keyword chính -> đọc top 3-5 (bỏ digicomvn.com, bỏ ads):
intent, SERP features, section đối thủ có, 3-5 câu PAA làm FAQ, góc khác biệt.

## BƯỚC 3 - VIẾT BÀI (theo skill content-writer + đặc thù Digicom)

- **Thứ tự đầu bài (rule Digicom 2026-07-16, GHI ĐÈ mặc định skill):**
  `H1 -> SAPO -> Tóm tắt nhanh -> mở bài -> H2...`
- Title <=58 ký tự, KW đầu; meta 140-160; slug flat `/[slug]/` (không /blog/).
- Giọng E-E-A-T tác giả Đỗ Hiếu (brand-info mục 3), thương hiệu viết là **DigicomVN**.
- KHÔNG bịa: giá, tên đầu báo hợp tác, case study, số liệu không nguồn.
- Nhắc tới giá -> KHÔNG ghi số cứng trong text, dùng widget/bảng giá live (bước 4).
- Gạch "-", không "—"/"–". Không câu khẩu ngữ/meta lọt vào text hiển thị.

## BƯỚC 4 - CHÈN WIDGET TƯƠNG TÁC (dữ liệu sống, không số chết)

Chọn widget khớp chủ đề, chèn dạng Gutenberg `<!-- wp:shortcode -->` tại điểm nghỉ mắt
(sau H2 thứ 2-3), mỗi bài 1-2 widget, KHÔNG nhồi cả 3:

| Widget | Dùng khi bài về |
|---|---|
| `[dgc_dr_chart bao="<domain>"]` | một đầu báo cụ thể (bài book-bao-*) |
| `[dgc_budget_calc]` | chi phí/ngân sách/giá dịch vụ off-page |
| `[dgc_offpage_quiz]` | kiến thức nền, audit, "nên làm gì trước" |

Bài thuộc nhóm dịch vụ có bảng giá -> có thể nhắc người đọc sang `/bang-gia/` thay vì
liệt kê giá trong bài.

## BƯỚC 5 - ẢNH

- **Thumbnail**: generator có sẵn `tools/blog-thumbnail/`:
  `echo '[[<post_id>,"<title>"]]' | python3 render-illus.py` -> `out/v2-<id>-*.png` 1200x675
  (đăng xong có ID mới chạy - xem bước 6).
- **Ảnh minh hoạ trong bài**: theo rule `image-sourcing` - Storyset, khớp đúng chủ đề,
  đồng bộ style site, credit storyset.com cuối bài. Không có ảnh phù hợp -> bỏ qua,
  KHÔNG chèn placeholder.

## BƯỚC 6 - ĐĂNG LIVE (SSH Hostinger - rule deploy.md)

1. Upload nội dung: `wp post create` (hoặc `wp post update` nếu refresh) với
   `--post_status=publish --post_author=1`, content là Gutenberg blocks.
   Escape an toàn: ghi content ra file tạm, scp lên, `wp post create ... < file` hoặc
   `wp eval-file` (tránh vỡ quote khi truyền inline).
2. Gán category đúng 1 trong 11 chuyên mục blog (menu Blog đã tách category);
   bài dịch vụ off-page thường là `backlink-offpage` (24) hoặc `booking-bao-pr`.
3. Thumbnail: render theo ID -> scp lên -> `wp media import <png> --post_id=<ID> --featured_image`.
4. Backup: nếu là refresh bài cũ -> fetch `content.raw` TRƯỚC khi update, lưu
   `~/Claude-Workspace/_backups/routines/<ngày>/content-pipeline/` + 1 dòng manifest.md
   (rule routine-backup). Bài mới hoàn toàn -> ghi manifest "created".

## BƯỚC 7 - INTERNAL LINK (2 chiều)

- Trong bài mới: tối đa 5 link, >=1 money page, anchor tự nhiên trong câu,
  URL GỐC theo brand-info mục 4 (vd `/booking-bao-pr/` - KHÔNG dùng `/dich-vu/...` đã 301).
- Chiều ngược: chọn 1-2 bài cũ cùng cụm đang mạnh, chèn 1 link trỏ về bài mới
  (backup content.raw trước khi sửa).

## BƯỚC 8 - VERIFY + LOG (bắt buộc trước khi báo xong)

- `curl -s https://digicomvn.com/<slug>/` : 200, có H1, widget render (tìm class widget),
  không "—", không lộ shortcode dạng text thô, thumbnail hiện.
- Kiểm tra thứ tự H1 -> SAPO -> Tóm tắt đúng rule.
- Purge cache nếu có sửa theme/CSS (bình thường KHÔNG cần - chỉ sửa content).
- Append LOG.md: `| <ngày> | Content pipeline | <slug> đăng/refresh, category X, widget Y |`.
- Báo Hiếu 3-5 dòng: URL bài, category, widget đã chèn, link nội bộ đã đặt.

## RANH GIỚI

- KHÔNG đụng CPT `dgc_gia` / giá (routine giá riêng quản).
- KHÔNG tạo trang dịch vụ/page mới - pipeline này chỉ cho BÀI BLOG.
- KHÔNG publish lại nhóm đang ẩn (4 nhóm media, dòng gói/chung chung).
- Batch nhiều bài: tối đa 3 bài/lần chạy, cùng cụm phải qua gate bước 1.
