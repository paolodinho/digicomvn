# Research intent TRƯỚC khi sửa bài - bắt buộc (chốt 2026-07-20)

> Sự cố gốc: bài `dien-dan-di-backlink` (225). Đã bỏ công thêm sơ đồ, internal link, fix bảng
> markdown - nhưng bài chỉ có 25 diễn đàn không chỉ số, trong khi 10/10 kết quả top là DANH SÁCH
> 100-200+ diễn đàn kèm DA/PA. Sửa hình thức cho một bài SAI DẠNG = công cốc.
> Hiếu: "viết vẫn đéo chịu research gì cả... intent rõ ràng của nó là danh sách diễn đàn".

## Nguyên tắc gốc

**Bước ĐẦU TIÊN khi động vào bất kỳ bài cũ nào (audit, thêm sơ đồ, sửa internal link, refresh)
là research SERP xác định intent - TRƯỚC khi đọc/sửa nội dung.**

Không được đi thẳng vào việc "làm đẹp" bài. Đẹp mà sai dạng thì vẫn không xếp hạng được.

## Quy trình bắt buộc (3 bước, không bỏ bước nào)

### Bước 1: Xác định dạng nội dung đang xếp hạng
Search chính xác từ khoá chính của bài. Đọc **toàn bộ 10 kết quả đầu**, phân loại từng cái:
- Listicle/danh sách (có bảng, có số lượng trong tiêu đề: "200+", "Top 15")
- Hướng dẫn thao tác từng bước (how-to)
- Bài định nghĩa/giải thích khái niệm (what-is)
- Trang dịch vụ/bán hàng (commercial)
- So sánh/review sản phẩm

Ghi rõ tỷ lệ, vd: "8/10 là trang dịch vụ" hoặc "10/10 là listicle danh sách".

### Bước 2: So dạng bài hiện tại với dạng đang top
- **Khớp dạng** -> tiếp tục audit nội dung bình thường (thêm sơ đồ, internal link, info gain).
- **Lệch dạng** -> DỪNG việc làm đẹp. Báo Hiếu ngay: bài đang dạng X, SERP đang ăn dạng Y,
  đề xuất viết lại/chuyển hướng. Không tự ý sửa vặt rồi báo "xong".

### Bước 3: Chỉ khi khớp dạng mới xét đến chất lượng
Đọc ít nhất 2 bài top thật (WebFetch, không đoán từ snippet) để tìm gap thật sự -
phần nào bài mình thiếu, phần nào đã đủ tốt thì GIỮ NGUYÊN (không sửa cho có).

## Dấu hiệu từ khoá có intent DANH SÁCH (dễ bị làm sai nhất)

Từ khoá chứa hoặc ngụ ý: "danh sách", "diễn đàn", "site", "trang web", "tool", "phần mềm",
"công cụ", "top", "nguồn", "địa chỉ", "ở đâu" -> khả năng cao intent là LIỆT KÊ có bảng,
không phải bài văn giải thích dài dòng.

Với dạng này, bài phải có **bảng dữ liệu thật, đủ số lượng, có chỉ số kiểm chứng được** -
không phải 3-5 dòng ví dụ minh hoạ.

## Info gain cho bài dạng danh sách - cách vượt đối thủ

Đối thủ VN chép danh sách của nhau và không ai kiểm tra lại. Đây là gap khai thác được:

1. **Verify link sống/chết** - script DNS + HTTP (mẫu: `tools/forum-audit/check.py`).
   Đợt 225 phát hiện 12/73 domain đối thủ vẫn liệt kê nhưng đã chết.
2. **Đo chỉ số thật** - Domain Rating qua Ahrefs free API (MCP tool
   `public-domain-rating-free`), KHÔNG chép DA từ bài khác. Đợt 225 phát hiện DA đối thủ ghi
   mâu thuẫn nhau (tinhte.vn: 82 / 77 / 65+ ở 3 bài khác nhau; DR thật = 79).
   Lưu ý: endpoint free yêu cầu API key từ 2026-08-01, cần đăng ký trước mốc đó.
3. **Công bố phần bị loại kèm lý do** - gần như không đối thủ nào dám làm (lộ dữ liệu họ cũ).
   Đây vừa là info gain vừa là tín hiệu E-E-A-T mạnh.
4. **Ghi rõ ngày đo** trong bài, để người đọc biết dữ liệu tươi.
5. **Loại thẳng những mục không đúng bản chất** - vd trong danh sách diễn đàn, loại các trang
   báo/thương mại điện tử không cho đăng bài (laodong.vn, genk.vn, chotot.com...) dù DR cao,
   và nói rõ vì sao loại.

## Liên quan
- `do-dont.md` mục "Research SERP + dựng dàn bài TRƯỚC khi viết" (2026-07-24) - quy trình đầy đủ:
  top 10 (không phải top 7), đọc Google Suggested/PAA, dựng dàn bài trả lời trực diện trước khi
  viết. Rule này (audit-intent-truoc.md) tập trung riêng cho việc XÁC ĐỊNH DẠNG khi audit bài cũ;
  áp dụng cùng lúc với quy trình dàn bài ở do-dont.md.
- `seo-content-report.md` (global) - 4 mục bắt buộc trong báo cáo: intent, research SERP,
  allintitle, info gain. Rule này là bước THỰC THI để có dữ liệu điền vào báo cáo đó.
- `content-diagram-explain.md` - sơ đồ giải thích, áp SAU khi đã xác nhận đúng intent.
- `content-professional.md` (global) - không bịa số liệu, mọi con số phải đo được.
