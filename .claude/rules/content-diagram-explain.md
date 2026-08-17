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

### Card dãy có thứ tự (quy trình, giai đoạn, tầng) - BẮT BUỘC bọc `<ol>`, không dùng `<div>` trần (chốt 2026-08-10)

> Sự cố: khối "6 bước viết bài PR sự kiện" (`viet-bai-pr-su-kien`) toàn bộ là `<div>` lồng
> `<div>` - Google bot vẫn đọc được chữ nhưng không có tín hiệu cấu trúc nào cho biết đây là
> danh sách 6 bước CÓ THỨ TỰ; AI (AI Overview, ChatGPT...) phải tự đoán ranh giới tiêu đề/mô
> tả. Hiếu: "trình bày lại toàn trang bằng các thẻ cho google bot/ai bot dễ hiểu nhất".

Mọi dãy card thể hiện thứ tự/trình tự thật (quy trình N bước, giai đoạn trước-trong-sau,
tầng 1-2-3-4 của mô hình) PHẢI dùng cấu trúc sau, không dùng `<div>` phẳng:

```html
<ol style="display:flex;flex-wrap:wrap;gap:14px;margin:20px 0;list-style:none;padding:0">
<li style="flex:1 1 260px;background:#F1FAF8;border:1px solid rgba(14,140,127,.22);border-radius:12px;padding:16px 18px">
<div aria-hidden="true" style="width:32px;height:32px;border-radius:50%;background:#0E8C7F;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;margin-bottom:10px">1</div>
<dl class="dl-card" style="margin:0"><dt style="font-weight:700;color:#1C2035;margin-bottom:4px">Tên bước</dt><dd style="font-size:13.5px;color:#3F4A5A;margin:0">Mô tả ngắn</dd></dl>
</li>
<!-- ... các <li> tiếp theo ... -->
</ol>
```

- `<ol>` thay `<div>` ngoài cùng: `list-style:none;padding:0` để không hiện số 1./2. mặc định
  của trình duyệt (số tròn màu brand đã có sẵn đóng vai trò hiển thị) - visual KHÔNG đổi so
  với bản `<div>` cũ, chỉ đổi ngữ nghĩa thẻ.
- Mỗi card = `<li>`, giữ nguyên style cũ.
- Số thứ tự tròn (nếu có) thêm `aria-hidden="true"` - tránh trình đọc màn hình đọc lặp số
  (vì `<ol>` đã tự có thứ tự ngữ nghĩa).
- Tên bước (dt) + mô tả (dd) gói trong `<dl class="dl-card">` theo đúng mẫu "Card kiểu nhãn +
  mô tả" ở mục dưới - vừa rõ cấu trúc cho bot, vừa được hover-tint tự động.
- **KHÔNG dùng `<h3>`** cho tên bước dù có vẻ hợp lý hơn - `inc/toc.php` tự quét MỌI `<h3>`
  trong bài vào Mục lục, một quy trình 6 bước sẽ nhồi 6 mục lục con vào TOC (đã áp dụng cho
  card 3-giai-đoạn, 4-tầng cùng lý do) làm rối mục lục, phá vỡ "đẹp đẽ dễ đọc".
- Dãy card KHÔNG có thứ tự thật (các lựa chọn/loại/nhóm song song, ví dụ 4 mẫu sapo theo loại
  sự kiện) thì dùng `<ul>` (cùng cấu trúc trên, chỉ đổi `ol`→`ul`), không ép thành `<ol>`.
- Bảng dữ liệu (`dgc-data-table`) nên thêm `<caption>` mô tả ngắn ngay sau `<table>`, ẩn thị
  giác bằng inline style visually-hidden (`position:absolute;width:1px;height:1px;padding:0;
  margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0`) - giúp bot biết
  bảng đang so sánh/liệt kê gì mà không đổi giao diện.
- Áp dụng cho bài MỚI viết. Bài cũ dùng mẫu `<div>` phẳng cũ - audit/refresh lại thì nâng cấp
  theo mẫu này (đã làm mẫu tại `viet-bai-pr-su-kien`, 2026-08-10; sau đó quét + sửa toàn site
  35+ bài cùng ngày - xem LOG.md).

### QA bắt buộc sau khi thêm/sửa card dãy - `tools/list-semantic-qa.py`

Trước khi báo bài xong (bài mới HOẶC audit bài cũ có đụng tới card dãy), chạy:
```bash
python3 tools/list-semantic-qa.py <post_id>    # 1 bài
python3 tools/list-semantic-qa.py              # toan site (172 URL, ~1-2 phut)
```
Script chỉ **PHÁT HIỆN** (không tự sửa) card-dãy còn nằm trong `<div>` phẳng chưa bọc
`<ol>`/`<ul>`. Kết quả phải là `0 khối chưa bọc list` trước khi coi là xong.

### Bài học sự cố 2026-08-10 - KHÔNG viết script tự động SỬA hàng loạt mà không test kỹ

Lần đầu quét + tự động sửa 34 bài cùng lúc bằng script đệ quy (nhiều tầng div lồng nhau),
1 lỗi trong logic đệ quy (mở tag `<ol>` nhưng đóng nhầm `</div>` do quên dùng tag MỚI sau khi
đệ quy, lại dùng tag GỐC) đã làm hỏng HTML thật trên live (3 bài) - biểu hiện là khoảng trắng
lớn bất thường giữa các mục, phát hiện qua ảnh chụp Hiếu gửi kèm "lỗi". Bài học:
- Sau khi build/sửa 1 script transform hàng loạt: **kiểm đếm số lượng mở/đóng của MỌI loại
  thẻ liên quan** (`<div`/`</div>`, `<ol`/`</ol>`, `<li`/`</li>`...) bằng regex đơn giản trên
  TOÀN BỘ HTML kết quả TRƯỚC khi push - không chỉ tin vào BeautifulSoup parse xuôi (BS4 tự
  "sửa" HTML lỗi khi parse nên có thể che mất lỗi mất cân bằng thẻ thật).
- Backup TRƯỚC khi ghi đè hàng loạt (đã làm đúng lần này) - nhờ đó rollback được ngay khi phát
  hiện lỗi, không mất nội dung gốc.
- Có `tools/list-semantic-qa.py` để dò tự động thay vì phải chờ user chụp ảnh báo lỗi.
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
  không cần ép về dl/dt/dd: tên người + chức danh (author bio "Tên<br>Chức danh" - quy ước phổ biến,
  không gây hiểu nhầm), tiêu đề mẫu thông cáo báo chí hoàn chỉnh + nội dung mẫu ("[Tên công ty] ra
  mắt..."<br>nội dung mẫu - đây là VÍ DỤ câu hoàn chỉnh, không phải nhãn ngắn, ép dt/dd sai bản chất).

### Interactive: mọi `<dl class="dl-card">` PHẢI có class này (chốt 2026-08-10, đợt 3, SỬA lại cùng ngày)

Hiếu: "các thẻ nên có interactive cho sinh động" - mọi card dạng nhãn/mô tả (`<dl><dt><dd>`)
theo 3 mẫu ở trên (5W1H/checklist, eyebrow-stat, FAQ ngắn) PHẢI thêm `class="dl-card"` vào thẻ
`<dl>` để bật **hover nhẹ** (tint nền rất nhạt khi rê chuột qua).

```html
<dl class="dl-card" style="margin:0"><dt style="font-weight:700">What</dt><dd style="margin:0">Chủ đề, hoạt động chính</dd></dl>
```

> Bản đầu (đợt 3, cùng ngày) dùng hiệu ứng **hover lật thẻ 3D** (`dl-flip`, mặt trước = dt, mặt
> sau = dd). Hiếu đổi ý ngay sau đó: "chỉ nên là hover đơn giản, đỡ rối rắm, để trải nghiệm đọc
> không bị ảnh hưởng, người đọc không bị phân tâm" - vì lật thẻ ẨN mất 1 nửa nội dung (dt hoặc dd)
> tại mọi thời điểm, người đọc phải hover mới thấy hết cả 2 phần -> gây phân tâm, không phù hợp
> văn bản cần đọc lướt nhanh. Đã đổi hẳn sang hover-tint đơn giản, dt+dd LUÔN hiện đủ cùng lúc.
> Class + CSS `dl-flip` đã bị XOÁ HẲN (không giữ song song 2 kiểu) - chỉ dùng `dl-card`.

- CSS đã có sẵn trong `assets/css/main.css` (khối `.page-content dl.dl-card`) - **KHÔNG cần style
  gì thêm ngoài class**. Chỉ đổi `background-color` rất nhạt khi hover, KHÔNG dùng transform/
  margin/padding (tránh giật trang khi lướt chuột qua nhiều card liên tiếp).
- Chỉ hoạt động trên thiết bị có chuột thật (`@media(hover:hover)`) - điện thoại/tablet không có
  gì đổi (không có hover thì không cần hiệu ứng gì thêm, nội dung vẫn hiện đủ như bình thường).
- `dt`/`dd` LUÔN hiển thị đầy đủ cùng lúc (khác bản flip cũ) - không ảnh hưởng gì tới việc đọc
  hay tới nguyên tắc `<dl><dt><dd>` semantic đã chốt ở trên.
- Bài viết MỚI viết card dạng nhãn/mô tả -> luôn thêm `class="dl-card"` ngay từ đầu.
- Card KHÔNG phải cặp nhãn/mô tả đơn giản (theo đúng phần "KHÔNG áp dụng" ở mục trên: author bio,
  mẫu thông cáo báo chí hoàn chỉnh) -> KHÔNG thêm `dl-card`.
- Quy trình nhiều bước (`<ol class="proc">` ở theme) và card liên kết dạng link (`pillar-card`)
  KHÔNG dùng hiệu ứng này - đó là nội dung tuần tự/điều hướng, khác bản chất cặp nhãn/mô tả tĩnh.
- Đã retrofit `class="dl-card"` cho toàn bộ 71 `<dl>` đã sửa trước đó (12 bài, đợt 2026-08-10)
  qua REST API (ban đầu đặt tên `dl-flip`, sau đổi tên thành `dl-card` khi đổi cơ chế), backup
  tại `~/Claude-Workspace/_backups/routines/2026-08-10/dl-flip-retrofit/` (bản gốc trước khi có
  class) và `~/Claude-Workspace/_backups/routines/2026-08-10/dl-card-simplehover/` (bản có
  `dl-flip` trước khi đổi tên thành `dl-card`).

### 2 biến thể khác cùng lỗi - cũng đã gặp và sửa (2026-08-10, đợt 2)

1. **Cặp 2 `<div>` cạnh nhau** (nhãn kiểu "eyebrow" uppercase nhỏ + div nội dung ngay dưới, VD card
   thống kê "Nguồn traffic chính" / "Tầng 1, Tầng 2..."): gộp thành 1 `<dl>`, giữ NGUYÊN toàn bộ
   inline style cũ của từng div (chỉ đổi thẻ `div`->`dt`/`dd`), thêm `margin-left:0;margin-right:0`
   vào style của `dd` (trình duyệt mặc định thụt `dd` ~40px, phải chặn). 42 cặp/6 bài đã sửa.
2. **FAQ viết trong `<p><strong>Câu hỏi</strong><br>Trả lời</p>`** (thường dưới heading "Câu hỏi
   thường gặp" nhưng không phải shortcode FAQ chuẩn `[dgc_...]`/`inc/svc-faq.php`): đổi thành
   `<dl style="margin:0 0 16px"><dt style="font-weight:700">Câu hỏi</dt><dd style="margin:.3em 0 0">Trả
   lời</dd></dl>` - margin `0 0 16px` khớp đúng `margin` mặc định của `<p>` trong `.page-content`
   (`assets/css/main.css` dòng ~2417) để không đổi khoảng cách hiển thị. 12 cặp/4 bài đã sửa.
   Bài viết MỚI có mục FAQ dạng văn xuôi (không dùng shortcode) -> viết thẳng theo mẫu `<dl>` này
   ngay từ đầu, không viết `<strong>...</strong><br>` rồi phải sửa lại sau.

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
