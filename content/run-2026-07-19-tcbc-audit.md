# Run log - Rà soát + bổ sung research cụm "Thông cáo báo chí" (đăng 2026-07-18, audit 2026-07-19)

> Hiếu phát hiện batch 4 bài (thong-cao-bao-chi-la-gi, cach-viet-thong-cao-bao-chi-chuan,
> mau-thong-cao-bao-chi, thong-cao-bao-chi-xu-ly-khung-hoang) đăng 18/7 KHÔNG có file run-log +
> sổ cái cụm như quy trình bắt buộc (khác cụm "booking báo" 17/7 làm đúng). Phiên này bổ sung
> bằng chứng research + rà lỗi quy cách, không viết lại từ đầu (nội dung đã kiểm tra khớp đúng
> intent thật của từ khoá).

| Bước | Trạng thái | Bằng chứng |
|---|---|---|
| Audit tự động 130 bài live | Làm | Script curl+regex kiểm: widget, em-dash, H1 count, khối Tóm tắt, internal link nội dung, title-tag length. Kết quả: 0 bài dính em-dash; 13 bài cũ (cụm backlink, trước rule widget 17/7) thiếu widget; 4 bài TCBC ĐỀU có widget (oquiz x3, acheck x1) - lần đầu tôi báo "thiếu widget" là SAI, đã tự kiểm lại và sửa trước khi báo Hiếu |
| Research SERP retroactive (4 keyword chính) | Làm | WebSearch từng keyword, xem top kết quả thật: "thông cáo báo chí là gì" (luatvietnam.vn, vietnix.vn, careerlink.vn - toàn định nghĩa+vai trò, khớp bài 1); "cách viết thông cáo báo chí chuẩn" (nhanhoa.com, tanca.io, miccreative.vn - cấu trúc 3 phần, 5W1H/tiêu đề/ngôn ngữ, khớp bài 2); "mẫu thông cáo báo chí" (luatvietnam.vn, canva.com - listicle mẫu theo tình huống, khớp bài 3); "thông cáo báo chí xử lý khủng hoảng mẫu" (giaychungnhan.vn, imcwire.com, accgroup.vn - mẫu + quy trình pháp lý, khớp bài 4) |
| Đối chiếu target keyword vs title/H1 thật | Làm | Cả 4 bài: primary keyword đứng đầu title, đúng intent informational (không lẫn keyword thương mại) - KHÔNG phát hiện sai target |
| Spot-check nội dung vs fact tìm được qua SERP | Làm | Bài 4 (khủng hoảng): có nhắc "luật sư"/"pháp lý" trước khi phát hành - khớp khuyến nghị phổ biến. Bài 3 (mẫu): CHƯA nhắc khuyến nghị độ dài 400-800 từ mà nhiều nguồn nêu - ghi nhận info-gain còn thiếu, chưa sửa (không phải lỗi sai, chỉ là có thể bổ sung sau) |
| Kiểm title-tag length (rule <=58 ký tự) | Làm | 3/4 bài đạt (53/56/50 ký tự). **1 bài VI PHẠM**: thong-cao-bao-chi-xu-ly-khung-hoang dài 72 ký tự (post 3869) - Google sẽ cắt cụt trên SERP |
| Sửa lỗi title-tag quá dài | Làm | Backup content.raw + title gốc vào `~/Claude-Workspace/_backups/routines/2026-07-19/tcbc-title-fix/`. Đổi title "Thông Cáo Báo Chí Xử Lý Khủng Hoảng: Mẫu Và Cách Viết Xin Lỗi Khách Hàng" (72 ký tự) -> "Thông Cáo Báo Chí Xử Lý Khủng Hoảng: Mẫu Và Cách Viết" (53 ký tự), đồng bộ H1 trong content (str_replace 1 chỗ khớp). Verify curl: title 53 ký tự, H1 khớp, HTTP 200 |
| Kiểm cannibalization nội bộ | Làm | 4 bài TCBC không đấu nhau (đã phân vai theo plan: là gì/cách viết/mẫu/khủng hoảng); không trùng head-term với bài cũ "Cách Viết Bài PR Chuẩn Báo Chí" (khác ngữ cảnh - đã có link chéo 2 chiều theo plan) |
| Meta description | Phát hiện, KHÔNG sửa (ngoài scope) | Toàn site (kiểm cả bài TCBC lẫn bài cũ /backlink/) KHÔNG output thẻ `<meta name="description">` - đây là lỗi kỹ thuật theme-level toàn site, không riêng batch này, cần xử lý riêng ở cấp theme (thêm hook `wp_head` output description từ excerpt/ACF) |
| Sổ cái cụm | Làm | Tạo `content/cluster-thong-cao-bao-chi.md` (xem file riêng) |
| Purge cache | Làm | `wp cache flush` + `litespeed-purge all` sau khi sửa post 3869 |
| LOG.md | Làm | 1 dòng batch này |

## Kết luận

- Nội dung 4 bài TCBC **đúng target keyword, đúng intent, có widget** - không phải "viết bừa không research" như nghi ngờ ban đầu, nhưng đúng là **thiếu bằng chứng quy trình** (không có run-log tại thời điểm viết) nên không kiểm chứng được cho tới hôm nay.
- 1 lỗi thật đã sửa: title-tag quá dài (bài Xử Lý Khủng Hoảng).
- 1 gap nội dung nhỏ chưa sửa (độ dài khuyến nghị 400-800 từ ở bài Mẫu) - có thể bổ sung nếu Hiếu muốn.
- 1 vấn đề kỹ thuật phát hiện ngoài phạm vi cụm này: toàn site thiếu thẻ meta description - cần task riêng.

## Mở rộng: rà title-tag + intent cho TOÀN BỘ 130 bài (2026-07-19, tiếp theo)

Hiếu yêu cầu "sửa tiếp, rà cả title xem đúng intent của từng trang chưa" - mở rộng ra hết site.

| Bước | Trạng thái | Bằng chứng |
|---|---|---|
| Đo lại title-tag length CHÍNH XÁC (decode HTML entity, bỏ suffix " - DigicomVN") | Làm | Lần đo đầu tiên bị sai do đếm cả entity thô (`&#038;` = 6 ký tự thay vì 1) và bị cắt chuỗi ở 75 ký tự - đã fetch lại full title, decode entity đúng |
| Danh sách vi phạm >58 ký tự | Làm | 7 bài: chien-dich-pr-an-tuong-viet-nam (68), backlink-social (67), backlink (65), guest-post-la-gi (61), backlink-dofollow-va-nofollow (61), dich-vu-entity (59), back-link-chat-luong (59) |
| Sửa 7 bài | Làm | Rút gọn title giữ nguyên keyword chính đầu câu, đồng bộ H1 trong content (str_replace, verify 1/1 match mỗi bài). Backup content.raw + title gốc từng bài tại `~/Claude-Workspace/_backups/routines/2026-07-19/title-length-fix-7/`. Verify curl: cả 7 bài đều <=58 ký tự, H1 khớp title |
| Rà title vs H1 mismatch toàn site (nghi ngờ sai lệch nội dung) | Làm | Script so từ khoá overlap title/H1 + quét dash toàn bộ 130 <title> tag (audit lần trước chỉ quét trong nội dung, bỏ sót thẻ title) |
| Phát hiện lỗi nghiêm trọng nhất đợt này | Làm | Post 227 (dich-vu-backlink-tong-quan): title chứa **em dash "—"** (vi phạm rule toàn cục) + số liệu "Index 98%" **không khớp** nội dung thật (nội dung chỉ có "98%+ Link còn sau 12 tháng", không phải chỉ số Index) - title và H1 gần như không liên quan nhau. Đã sửa title thành "Dịch Vụ Backlink Báo Chí: Không PBN, Index Bền Vững" (khớp thông điệp H1 thật, bỏ số liệu không có nguồn, hết em dash). Backup title gốc tại `title-intent-fix/227-title.orig` |
| Mismatch nhẹ còn lại (không sửa) | Ghi nhận | Post google-panda: title "Lịch Sử, Cơ Chế và Bài Học" vs H1 "Thuật Toán Thay Đổi Mãi Mãi Cách Viết Content SEO" - khác góc nhìn nhưng cùng chủ đề, không sai lệch thông tin, không sửa |
| Kiểm cannibalization toàn site (không chỉ cụm backlink) | Làm | Nhóm theo 3 từ đầu tiêu đề (bỏ stopword) - chỉ 2 nhóm trùng, cả 2 đều là cùng cụm với modifier khác nhau đúng (TCBC là-gì/khủng-hoảng; dịch-vụ-backlink giá/tổng-quan) - KHÔNG phát hiện cannibalization thật |
| Purge cache + verify tất cả | Làm | curl từng URL đã sửa: title đúng độ dài, H1 khớp, HTTP 200 |

## Tổng kết đợt sửa 2026-07-19

**8 bài đã sửa title/H1:**
1. thong-cao-bao-chi-xu-ly-khung-hoang (title dài 72->53 ký tự)
2. chien-dich-pr-an-tuong-viet-nam (68->57)
3. backlink-social (67->49)
4. backlink (65->58)
5. guest-post-la-gi (61->50)
6. backlink-dofollow-va-nofollow (61->47)
7. dich-vu-entity (59->55)
8. back-link-chat-luong (59->54)
9. dich-vu-backlink-tong-quan (em dash + số liệu sai lệch với nội dung -> sửa nội dung + bỏ em dash)

**Không phát hiện thêm:** cannibalization keyword, sai target intent nghiêm trọng khác (ngoài đã liệt kê),
title/H1 mâu thuẫn nghiêm trọng khác.

**Còn tồn (ngoài scope đợt này, ưu tiên thấp hơn):**
- 13 bài cụm backlink cũ thiếu widget tương tác (trước rule 17/7).
- 15 bài cũ thiếu khối "Tóm tắt nhanh" đầu bài (trước rule cấu trúc mới).
- Toàn site thiếu thẻ `<meta name="description">` - vấn đề kỹ thuật cấp theme, không riêng bài nào.
