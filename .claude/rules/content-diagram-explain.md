# Sơ đồ giải thích đoạn phức tạp - tối thiểu 3/bài (chốt 2026-07-20)

> Rule Hiếu, xác nhận sau bài `phan-mem-di-back-link` (223) - đây là cách làm ĐÚNG,
> áp dụng cho mọi bài viết mới VÀ khi rà soát bài cũ trong dự án digicom.

## Nguyên tắc gốc

Mỗi bài viết (mới hoặc audit lại bài cũ) phải có **tối thiểu 3 sơ đồ/hình giải thích**
cho các đoạn khó hiểu/phức tạp - KHÔNG phải ảnh minh hoạ trang trí chung chung.

## Cách chọn đoạn cần làm sơ đồ

Quét bài, tìm đoạn có đặc điểm:
- Quy trình nhiều bước (vd 4 bước vận hành bot, 5 bước audit backlink...)
- Mô hình nhiều tầng/nhiều lớp (vd kim tự tháp Tier 1/2/3)
- So sánh nhiều lựa chọn/nhiều nhóm (vd bảng phân loại white-hat vs black-hat)
- Danh sách tiêu chí/checklist dài dễ đọc lướt bỏ sót

Nếu bài không đủ 3 đoạn phức tạp thật sự - báo cho Hiếu, KHÔNG bịa ra sơ đồ vô nghĩa
để đủ số lượng (rule chống scope creep/filler, xem `quality-bar.md`).

## Kỹ thuật dựng sơ đồ

- Dùng **HTML thuần (`<div>` + inline style)**, KHÔNG dùng SVG (nặng trang, từng gây
  sự cố page 472KB ở bài 222 - xem LOG.md 2026-07-20).
- Mẫu đã dùng thành công (bài 223):
  - **Quy trình N bước**: dãy card flex-wrap, mỗi card có số thứ tự tròn màu brand + tiêu đề + mô tả ngắn.
  - **Mô hình nhiều tầng**: các khối màu khác nhau xếp chồng, độ rộng tăng dần theo tầng,
    nối bằng mũi tên `&#8595;`, mỗi khối ghi tên + số liệu + vai trò.
- Màu dùng theo `ui-mau-sac.md` (brand teal/xanh, tránh mảng đen lớn).
- Tự chứa màu nền/chữ trong từng khối (không phụ thuộc CSS site) để không vỡ dark mode.
- **Đặt NGAY SAU đoạn text/danh sách gốc liên quan** - giữ nguyên text gốc, sơ đồ chỉ
  bổ sung, không thay thế (giống nguyên tắc `content-infographics.md` global).

## Card kiểu "nhãn + mô tả" (5W1H, checklist ngắn, myth-vs-fact...) - PHẢI dùng `<dl><dt><dd>` (chốt 2026-08-10)

> Sự cố: card kiểu lưới nhỏ (5W1H, checklist, "lưu ý ngắn") hay bị viết thành
> `<div style="..."><strong>Nhãn</strong><br>Mô tả</div>` - nhãn và mô tả dính chung 1 khối text,
> Google/AI phải ĐOÁN đâu là nhãn đâu là nội dung thay vì đọc được cấu trúc thật. Đã phát hiện +
> sửa 17 card kiểu này trên 3 bài (`bai-pr-su-kien-quoc-te-thieu-nhi`, `bai-pr-mau`,
> `booking-bao-la-gi`) ngày 2026-08-10 sau khi Hiếu chỉ ra ảnh chụp màn hình card 5W1H.

**Khi 1 card/ô trong lưới chỉ có ĐÚNG 1 cặp "nhãn ngắn -> mô tả"** (What/Who/When..., hoặc tiêu đề
ngắn + giải thích 1 câu), dùng mẫu sau thay vì `<strong>...</strong><br>...`:

```html
<div style="text-align:center;background:#fff;border:1px solid #E2E8F0;border-radius:8px;padding:10px 6px;font-size:12.5px;color:#3F4A5A;">
<dl style="margin:0"><dt style="font-weight:700">What</dt><dd style="margin:0">Chủ đề, hoạt động chính</dd></dl>
</div>
```

- `<dt>` = nhãn ngắn, `<dd>` = mô tả - Google/AI đọc thẳng ra cặp nhãn/giá trị, không phải đoán.
- BẮT BUỘC `style="margin:0"` trên cả `dl` và `dd` (mặc định trình duyệt thụt lề `dd` 40px, vỡ layout card nhỏ).
- `style="font-weight:700"` trên `dt` để giữ đúng độ đậm như `<strong>` cũ (thị giác KHÔNG đổi).
- Div bọc ngoài (màu nền, viền, padding, grid cha) giữ nguyên như card thường - chỉ đổi phần NỘI DUNG bên trong.
- **KHÔNG áp dụng** cho các trường hợp KHÔNG phải cặp nhãn/mô tả đơn giản - vẫn viết bình thường,
  không cần ép về dl/dt/dd: câu hỏi/trả lời trong `<p>` liền mạch (FAQ dạng văn xuôi), tên người +
  chức danh (author bio "Tên<br>Chức danh"), câu ví dụ mẫu ("Template:<br>..."), thống kê xếp hạng
  nhiều dòng (dùng `<ol>` nếu có thứ tự thay vì `<strong>%</strong><br>` dồn 1 dòng).

## Bảng dữ liệu trong bài - dùng class `.dgc-data-table` (2026-07-20)

Mọi bảng dữ liệu trong bài viết (danh sách site, so sánh, bảng chỉ số) PHẢI dùng:
`<figure class="wp-block-table dgc-data-table">` + `data-label="<tên cột>"` trên MỌI `<td>`.

CSS đã có sẵn trong `assets/css/main.css` (cuối file), tự động responsive 4 mức:
- Desktop: bảng đầy đủ, zebra + hover, bo góc.
- <=820px: thu gọn padding + cỡ chữ.
- <=700px: ẩn cột phụ (`.col-kho`) để không bóp chữ.
- <=560px: mỗi dòng thành 1 thẻ dọc, nhãn cột lấy từ `data-label`. KHÔNG cuộn ngang.

Quy tắc bắt buộc khi làm bảng có chỉ số (DR, DA, giá...):
- Nhãn số đặt trong `<span class="dr-badge" style="background:X;color:Y">` - PHẢI khai cả
  `color`, không để mặc định (badge nền sáng + chữ trắng = không đọc được, đã dính lỗi này).
- Thang màu đã kiểm tương phản >=4.5:1: `>=60` nền `#0E8C7F` chữ trắng, `>=40` nền `#2563EB`
  chữ trắng, `>=25` nền `#5B6675` chữ trắng, `<25` nền `#E2E8F0` chữ `#3F4A5A` (đảo ngược).
- Cột chỉ số thêm `class="col-dr"`, cột phụ ẩn ở tablet thêm `class="col-kho"`.
- KHÔNG ẩn `<thead>` bằng `position:absolute;left:-9999px` (bị coi là hidden text) - CSS hiện
  dùng `display:none`, giữ nguyên.
- Sửa CSS này -> BẮT BUỘC bump `DGC_VER` trong `functions.php` rồi deploy cả 2 file
  (xem `deploy.md`), nếu không browser vẫn serve CSS cũ.

## QA bắt buộc

- Verify dung lượng trang sau khi thêm (curl -s | wc -c) - không được tăng bất thường.
- Verify sơ đồ hiện đúng trên live (grep text đặc trưng trong mỗi khối).

## Liên quan
- `content-infographics.md` (global) - kỹ thuật bar chart bằng table+div cho bảng giá.
- `ui-mau-sac.md` - màu sắc, tránh mảng đen lớn, dark mode.
