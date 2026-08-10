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

## Chuẩn định lượng theo CỤM dịch vụ (bổ sung 2026-08-10)

Ngoài chuẩn tối thiểu ở trên (2 ảnh + mọi H2 có visual), mỗi **cụm dịch vụ** (booking báo PR,
guest post, textlink, backlink...) có thêm 1 CHUẨN SỐ LƯỢNG riêng - độ dài + số ảnh trung vị
đối thủ đang top cho keyword đại diện cụm đó (đo theo BƯỚC 3C của skill `entity-refresh`).
Chuẩn này áp dụng cho **MỌI bài trong cụm** (trang hub tổng quan + toàn bộ trang con theo
từng đối tượng cụ thể, vd từng đầu báo) - không phải chỉ 1 URL riêng lẻ, và không cần research
lại mỗi lần đụng tới 1 bài trong cùng cụm - chỉ research lại khi benchmark dưới đây quá cũ
(>60 ngày) hoặc SERP có dấu hiệu đổi mạnh (đối thủ mới top, dạng nội dung đổi).

**QUAN TRỌNG - đo theo TOÀN BỘ trang trong cụm của đối thủ, không phải 1 trang/domain**: mỗi
domain đối thủ thường có 1 trang hub tổng quan + NHIỀU trang con theo từng đối tượng cụ thể
(vd từng đầu báo) - phải fetch hết các trang con tìm được (`site:<domain> <từ khoá đại diện
từng đối tượng>`), không chỉ trang hub, rồi tách riêng benchmark theo 2 loại trang (hub và
trang con có bản chất nội dung khác nhau, gộp chung sẽ sai lệch).

| Cụm | Loại trang | Từ khoá đại diện | Số mẫu đối thủ đã đo | Trung vị số từ | Trung vị số ảnh | Ngày đo |
|---|---|---|---|---|---|---|
| Booking báo PR | Hub tổng quan (`/booking-bao-pr/`) | "dịch vụ booking báo PR" + "booking báo PR giá rẻ uy tín" | 10 domain (Mona Media, SEO Đà Nẵng, SEOViP, MIC Creative, Hapo Digital, PRBaoChi, BookBaoPR, ITIFY, SEODO, VietQuangCao) | ~2.050 từ (dải 946-4.225) | ~41-42 ảnh (dải 11-119; 2 domain SEODO/Mona Media 96-119 ảnh có lẫn icon menu do theme không tách `<header>` chuẩn, cần xem tay nếu muốn số chính xác hơn) | 2026-08-10 |
| Booking báo PR | Trang con theo từng đầu báo (`/booking-bao-pr/[ten-bao]/`) | "báo giá đăng bài PR trên [tên báo]" x 6 domain có cấu trúc trang con (Hapo Digital, MIC Creative, SEODO, SEOViP, BookBaoPR, SEO Đà Nẵng) | 23 trang (VnExpress, 24h, CafeF, Dân Trí, Kênh14, Tuổi Trẻ, VietNamNet, Thanh Niên, Eva, Ninh Bình...) | ~1.343 từ (dải 758-4.650) | ~18 ảnh (dải 10-38) | 2026-08-10 |

**Cách áp dụng cho từng bài trong cụm:**
- Xác định bài đang audit/viết thuộc loại TRANG NÀO (hub tổng quan hay trang con theo đối
  tượng cụ thể) - lấy đúng dòng benchmark tương ứng, KHÔNG dùng lẫn 2 dòng cho nhau (bản chất
  nội dung khác hẳn: hub liệt kê tổng quan nhiều đầu báo, trang con đi sâu 1 đầu báo).
- Đếm số từ + số ảnh HIỆN TẠI của bài đang audit/viết (cùng phương pháp BƯỚC 3C: strip
  header/footer/menu/comment, chỉ tính thân bài).
- So với trung vị đúng loại trang - thiếu về SỐ LƯỢNG không phải lý do viết filler/thêm ảnh vô
  nghĩa (`quality-bar.md`); ưu tiên lấp bằng nội dung/visual THẬT còn thiếu (thực thể, từ khoá
  cùng cụm, H2 chưa có visual) trước, xem gần đạt mức trung vị chưa mới dừng.
- Ví dụ đã đối chiếu (2026-08-10): `/booking-bao-pr/` (hub) hiện có 2.586 từ/9 ảnh - chữ đã đủ
  (>2.050) nhưng ảnh thiếu nặng (9 so với ~41). `/booking-bao-pr/vnexpress/` (trang con) hiện
  có 5.884 từ/12 ảnh - chữ đã vượt xa (>1.343, gấp ~4 lần) nhưng ảnh vẫn thiếu (12 so với ~18).

**Khi làm cụm MỚI chưa có dòng trong bảng trên:** chạy đúng BƯỚC 3C của `entity-refresh`, sau
đó thêm 1 dòng vào bảng này (không lưu riêng lẻ theo từng bài) để các bài sau trong cùng cụm
tái dùng luôn, không research lại.

## Liên quan
- `image-sourcing.md` - nguồn ảnh, quy trình chọn.
- `content-diagram-explain.md` - kỹ thuật dựng sơ đồ HTML (tối thiểu 3 sơ đồ/bài cho đoạn phức tạp).
- `ui-mau-sac.md` - màu sắc dùng trong widget/card (tránh mảng đen lớn, dark mode).
- `entity-refresh` (skill) - BƯỚC 3C, nguồn phương pháp đo độ dài/số ảnh đối thủ.
