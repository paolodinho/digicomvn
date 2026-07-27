# Visual coverage mỗi bài - tối thiểu 2 ảnh + mọi H2 có yếu tố trực quan (chốt 2026-07-25)

> Rule Hiếu: "bài thiếu ảnh, mỗi bài tối thiểu cần 2 ảnh và thẻ H2 nào cũng cần ảnh minh
> hoạ/info/interactive/tool - mọi cách để giữ time on site cao."

## Nguyên tắc

Mọi bài viết (mới hoặc audit/lấp gap bài cũ) trên digicomvn.com phải đạt:

1. **Tối thiểu 2 ảnh minh hoạ thật** (Storyset theo `image-sourcing.md`, hoặc ảnh chụp
   thật theo `ui-anti-slop.md` khi có sẵn) trong thân bài - không tính ảnh thumbnail đại diện.
2. **Mỗi thẻ H2 phải đi kèm ít nhất 1 yếu tố trực quan/tương tác**, chọn 1 trong 4 loại:
   - Ảnh minh hoạ (Storyset/ảnh thật)
   - Sơ đồ/bảng info (HTML bar chart, card-grid, flow diagram - theo `content-diagram-explain.md`)
   - Bảng dữ liệu (`.dgc-data-table` hoặc `wp:table`)
   - Widget tương tác (`[dgc_budget_calc]`, `[dgc_offpage_quiz]`, `[dgc_dr_chart]`, hoặc
     shortcode mới nếu cần - theo BƯỚC 4 của `content-pipeline` skill)

## Lý do

Giữ time-on-site cao, giảm bounce - mỗi H2 là 1 điểm dừng mắt, không để đoạn text dài
liên tục không có điểm nghỉ. Cũng tăng E-E-A-T (bài có dữ liệu/trực quan đọc đáng tin hơn
bài toàn chữ).

## Cách áp dụng

- Khi viết bài mới: lập dàn bài xong (theo `do-dont.md`) rồi mới gán loại visual cho từng H2
  - đừng để đến cuối mới nhét cho đủ.
- Khi audit/lấp gap bài cũ: sau khi bổ sung nội dung, RÀ LẠI toàn bộ H2 hiện có, liệt kê
  H2 nào chưa có visual, bổ sung nốt trước khi báo xong - không chỉ thêm visual cho phần
  mới viết.
- H2 dạng liệt kê link phẳng (không có gì để minh hoạ) -> chuyển thành chip-grid/card-grid
  HTML thay vì bullet list trần, vẫn tính là "info" hợp lệ.
- FAQ/Kết luận không có gì để minh hoạ tự nhiên -> có thể dùng widget interactive
  (quiz, CTA card) thay vì ảnh, miễn có ít nhất 1 yếu tố trực quan/tương tác.
- Không dùng ảnh generic không khớp chủ đề chỉ để "cho đủ số" - vẫn phải đúng
  `image-sourcing.md` (khớp chủ đề, không AI-slop).

## Pattern tham khảo

Bài `bao-gia-dang-bai-pr-theo-dau-bao` (post 1261, 2026-07-25) - 8 H2, đủ 8 loại visual:
3 ảnh Storyset, 1 bar chart, 1 bảng giá, 1 sơ đồ 2-khối, 1 chip-grid, 1 quiz widget + CTA card.

## Liên quan
- `image-sourcing.md` - nguồn ảnh, quy trình chọn.
- `content-diagram-explain.md` - kỹ thuật dựng sơ đồ HTML (tối thiểu 3 sơ đồ/bài cho đoạn phức tạp).
- `ui-mau-sac.md` - màu sắc dùng trong widget/card (tránh mảng đen lớn, dark mode).
