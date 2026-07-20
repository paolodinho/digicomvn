# External link tới nguồn uy tín - tăng E-E-A-T (rule Hiếu, 2026-07-19)

> Case gốc: nhắc "Điều 38 Luật Báo chí 2016" trong bài booking báo & PR - phải link ra văn bản luật thật.

## Nguyên tắc

Khi nội dung nhắc tới **khái niệm/thuật ngữ/quy định quan trọng** mà có nguồn tham chiếu công khai,
uy tín - PHẢI gắn external link ra nguồn đó, không để tên trần (bôi đậm suông) hoặc bịa số liệu không dẫn được.

**Lý do:** Google/AI đánh giá độ uy tín 1 phần qua "công ty này link đi đâu" (outbound link quality) -
link tới nguồn chính thống (.gov, tổ chức quốc tế, luật/định nghĩa gốc) là tín hiệu cho thấy site
HIỂU đúng lĩnh vực, không tự phịa, kiểm chứng được. Đây là 1 dạng E-E-A-T (Expertise/Trust) qua outbound link.

## Loại khái niệm cần link

| Loại | Nguồn ưu tiên |
|---|---|
| Luật/Nghị định/Thông tư VN | Cổng thông tin Chính phủ (vanban.chinhphu.vn), Thư viện Pháp luật, Cổng TTĐT Quốc hội |
| Cơ quan/tổ chức nhà nước | Trang chính thức cơ quan đó (.gov.vn) |
| Khái niệm SEO/kỹ thuật quốc tế | Trang gốc phát minh khái niệm (Google Search Central, Moz, Ahrefs blog) hoặc Wikipedia bản tiếng Anh nếu khái niệm bắt nguồn nước ngoài |
| Định nghĩa chung, thuật ngữ phổ quát | Wikipedia (ưu tiên bản tiếng Việt nếu đủ chất lượng, không thì bản tiếng Anh) |
| Số liệu/thống kê ngành | Nguồn công bố gốc (Bộ TT&TT, tổ chức nghiên cứu, báo cáo chính thức) - KHÔNG bịa số |

## Rẽ nhánh: link thật (ngoài HOẶC nội bộ) vs icon "i" (tooltip/popup) - chốt 2026-07-19

Không phải thuật ngữ nào cũng cần popup. Thứ tự ưu tiên xử lý mỗi thuật ngữ:

1. **Site TỰ MÌNH đã có 1 bài viết riêng giải thích đúng thuật ngữ đó** (dạng "X Là Gì?") -> LINK
   NỘI BỘ THẲNG tới bài đó ngay tại lần nhắc đầu tiên (không icon "i"). Đây là ưu tiên SỐ 1 - mượn
   uy tín/độ sâu nội dung sẵn có của chính site, đồng thời tăng internal link tới bài pillar.
   Bài chính là bài định nghĩa thuật ngữ đó thì KHÔNG tự link về chính mình.
2. Không có bài riêng, nhưng có 1 nguồn gốc/chính thống RÕ RÀNG bên ngoài (văn bản luật, định nghĩa
   chuẩn quốc tế, tổ chức cụ thể) -> **External link** (mục "Loại khái niệm cần link" ở trên).
3. Không có cả 2 trên (thuật ngữ chuyên ngành không có bài riêng, không có nguồn ngoài xứng đáng,
   hoặc cần diễn giải theo cách riêng của Digicom) -> **Icon "i" + popup giải thích tại chỗ**.

Nguyên tắc chọn nhanh: **link thật (nội bộ hoặc ngoài) luôn mạnh hơn icon "i"** - popup chỉ là
phương án cuối khi không có nơi nào để link tới. Không dùng icon "i" để né việc phải link.

### Kỹ thuật: popup dùng data-attribute, KHÔNG dùng span/div `hidden`

Sự cố 2026-07-19: ban đầu để định nghĩa trong `<span class="gloss-def" hidden>...</span>`, một số
trình duyệt/extension (adblock, privacy) tự động rỗng hoá nội dung element có attribute `hidden`
(nghi ngờ là hidden-text/cloaking) -> popup hiện trống dù server trả HTML đúng. Đã sửa: định nghĩa
đặt trong `data-gloss-def="..."` ngay trên nút bấm (`inc/glossary.php`), JS đọc qua `getAttribute` -
không có element nào bị đánh dấu `hidden` nữa nên không bị extension can thiệp.

### Cách làm - external link
1. Khi viết/rà bài có nhắc thuật ngữ/luật/định nghĩa quan trọng -> tìm nguồn gốc thật (không đoán URL).
2. Gắn link ngay tại lần nhắc đầu tiên trong bài, thuộc tính `target="_blank" rel="noopener"`.
   - Nguồn .gov/luật: thêm `rel="noopener"` thôi (không cần nofollow - đang chủ động dẫn nguồn xác tín).
3. Không lạm dụng - chỉ link khái niệm THỰC SỰ quan trọng/cốt lõi của đoạn đó, không link tràn lan
   mọi từ khoá (tránh loãng, giống spam).
4. Không link tới nguồn thương mại đối thủ, blog cá nhân không kiểm chứng được.
5. Nếu không tìm được nguồn xác tín cho 1 con số/luật -> KHÔNG bịa, để chung chung hoặc bỏ số đó
   (rule content-professional: không claim thông tin không verify được).

### Cách làm - icon "i" + popup
1. Đặt icon nhỏ hình chữ "i" trong vòng tròn, **ngay sau từ/cụm cần giải thích** (superscript, không tách dòng riêng)
   - đã có pattern y hệt trong `bang-gia-booking.md` mục "Icon 'i' giới thiệu báo/trang" (`.intro-toggle`,
     đặt trong `.row-name`, `vertical-align:super`) - tái dùng đúng kỹ thuật này (JS mở modal `.intro-pop`
     chung, đổ nội dung theo data-attribute, không tạo popup riêng lẻ từng chỗ để đỡ phình code).
2. Nội dung popup: định nghĩa ngắn (2-4 câu), có thể kèm ví dụ cụ thể của Digicom. Không bịa số liệu
   (vẫn theo `content-professional.md`).
3. `aria-label` mô tả rõ ("Giải thích thuật ngữ: <tên>") cho a11y; `title` dự phòng.
4. Nếu về sau thuật ngữ đó CÓ nguồn ngoài xác tín -> nâng cấp thành external link, không giữ mãi icon "i".
5. **KHÔNG bao giờ chèn shortcode/link vào bên trong thẻ heading (`<h1>-<h6>`)** - site có tính năng
   mục lục tự động (`inc/toc.php`) đọc text heading để làm id neo + link mục lục; chèn shortcode vào
   đó làm garble id và lộ chữ thô ra mục lục (sự cố thực tế 2026-07-19, xem PLAN.md). Nếu thuật ngữ
   chỉ xuất hiện trong heading ở lần nhắc đầu, bỏ qua bài đó hoặc chờ lần nhắc tiếp theo trong đoạn văn.
6. Bài nào chủ đề CHÍNH là định nghĩa thuật ngữ đó (tiêu đề dạng "X Là Gì?") -> KHÔNG tự gắn icon "i"
   giải thích X trong chính bài đó (trùng lặp, cả bài đã là định nghĩa).

## Trích số liệu/nhân vật nổi tiếng - bắt buộc nguồn + nofollow (chốt 2026-07-20)

> Case gốc: bài `kiem-tra-backlink` nhắc "John Mueller", "Marie Haynes", "Brian Dean" kèm số liệu
> cụ thể (65%, 70%...) nhưng KHÔNG có link nguồn - Hiếu: "mọi kiến giải cần thông số, số liệu,
> trích nguồn, nhân vật nổi tiếng" -> không kiểm chứng được, đọc như bịa.

**Nguyên tắc:** Mọi câu văn nêu SỐ LIỆU CỤ THỂ (%, thống kê) hoặc TRÍCH LỜI/QUAN ĐIỂM một nhân vật
có tên thật (chuyên gia SEO, đại diện Google...) PHẢI có:
1. Nguồn thật kiểm chứng được - không bịa số liệu, không gán phát ngôn không xác thực (theo `content-professional.md`).
2. External link gắn ngay tại tên nhân vật hoặc câu trích dẫn, trỏ THẲNG tới bài viết/phát ngôn gốc
   (không trỏ trang chủ chung chung, không đoán URL - phải tìm được nguồn thật).
3. `rel="nofollow noopener" target="_blank"` - KHÁC với link luật/định nghĩa gốc ở trên (dofollow):
   đây là trích dẫn cá nhân/bên thứ ba, Digicom không "bảo chứng" toàn bộ nội dung trang đó.
4. Không tìm được nguồn thật cho câu đã lỡ viết (bài cũ) -> BỎ tên/số liệu đó hoặc viết lại chung
   chung không gán nguồn cụ thể - KHÔNG giữ nguyên kiểu "chuyên gia X từng nói..." mà không có link.

Áp dụng hồi tố: rà lại các bài cũ có nhắc tên chuyên gia/số liệu chưa link (vd `kiem-tra-backlink`
đang có Marie Haynes/Brian Dean/John Mueller/Ahrefs/Semrush chưa link) khi xử lý internal-link.

## Áp dụng

Mọi bài viết/trang dịch vụ digicomvn.com có nhắc luật, quy định, khái niệm chuyên ngành (báo chí,
SEO, backlink, PR...). Áp dụng cả bài mới lẫn khi rà soát bài cũ.

## Liên quan
- `content-professional.md` (claim phải có nguồn, không bịa số liệu).
- `image-sourcing.md` (nguyên tắc chọn nguồn tương tự, áp cho ảnh thay vì link).
