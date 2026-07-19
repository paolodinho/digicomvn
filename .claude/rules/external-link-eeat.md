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

## Rẽ nhánh: external link vs icon "i" (tooltip/popup giải thích) - chốt 2026-07-19

Không phải thuật ngữ nào cũng link ra ngoài. Quyết định theo bảng sau:

| Trường hợp | Xử lý |
|---|---|
| Có 1 nguồn gốc/chính thống RÕ RÀNG, ổn định lâu dài (văn bản luật, định nghĩa chuẩn quốc tế, tổ chức cụ thể) | **External link** (mục "Loại khái niệm cần link" ở trên) |
| Thuật ngữ chuyên ngành/nội bộ Digicom, không có 1 nguồn ngoài nào "đại diện" đúng (vd cách Digicom định nghĩa "tier báo", "DR", "gói combo", quy trình riêng) | **Icon "i" + popup giải thích tại chỗ** - tự viết định nghĩa ngắn, không cần dẫn nguồn ngoài |
| Thuật ngữ phổ thông nhưng nếu link ra ngoài sẽ ĐẨY KHÁCH RỜI TRANG giữa đoạn quan trọng (đang ở phần thuyết phục/CTA) | **Icon "i" + popup** - giữ khách ở lại, vẫn giải thích được |
| Muốn định nghĩa dài, có ví dụ, số liệu riêng của Digicom (không phải giải thích chung) | **Icon "i" + popup** - external link chỉ hợp với định nghĩa CHUẨN/GỐC, không hợp nội dung tự diễn giải dài |

Nguyên tắc chọn nhanh: **link ra ngoài khi mượn uy tín nguồn khác** (luật, định nghĩa gốc quốc tế);
**icon "i" khi tự giải thích theo cách của Digicom** hoặc thuật ngữ không có nguồn ngoài xứng đáng.
Không dùng icon "i" để né việc phải link - nếu có nguồn xác tín tốt thì ưu tiên link thật (mạnh hơn cho E-E-A-T).

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

## Áp dụng

Mọi bài viết/trang dịch vụ digicomvn.com có nhắc luật, quy định, khái niệm chuyên ngành (báo chí,
SEO, backlink, PR...). Áp dụng cả bài mới lẫn khi rà soát bài cũ.

## Liên quan
- `content-professional.md` (claim phải có nguồn, không bịa số liệu).
- `image-sourcing.md` (nguyên tắc chọn nguồn tương tự, áp cho ảnh thay vì link).
