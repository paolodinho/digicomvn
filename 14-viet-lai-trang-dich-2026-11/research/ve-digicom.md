# Research https://digicomvn.com/ve-digicom/ (02/11/2026)

## 1. Từ chính + GSC (03/08-31/10/2026)
- 75 lượt hiện, 1 click. "digicomvn" 25 lượt hiện, vị trí 1,1 (1 click).
- Còn lại là truy vấn spam cờ bạc: dentoto (10 lượt hiện, vị trí 8,5), kudatoto (8, vị trí 6,4), dentoto login (6, vị trí 6,8), pg168 (5, vị trí 30,8).
- Cùng hiện tượng ở trang khác: /case-study/ "birutoto" 220 lượt hiện, vị trí 4,7, 14 click; /dat-bai/ "gengtoto", "fajar pakong 888"; /dich-vu-toplist/ "oketoto"; /advertorial-la-gi/, /ahrefs/ (nguồn: research/gsc-page-query-90d-2026-11-02.tsv).
- Kết luận intent: trang xác minh thương hiệu. Người tìm "digicomvn" muốn biết đơn vị là ai, pháp nhân, địa chỉ, ai phụ trách, làm được gì, liên hệ thế nào.

## 2. Dấu hiệu spam: đã kiểm nhanh HTML live (02/11/2026)
| Kiểm tra | Kết quả |
|---|---|
| HTML đã trích (live-2026-11-02/ve-digicom.html) tìm toto/slot/gacor/pg168/judi/togel | 0 kết quả |
| curl user-agent Googlebot | 82.553 byte, giống hệt bản thường, 0 chuỗi lạ |
| curl referer google.com (bắt cloaking theo nguồn) | 82.553 byte, 0 chuỗi lạ |
| Link ra ngoài trong trang | chỉ Zalo OA của DigicomVN |
| title / canonical | "Về DigicomVN - DigicomVN", canonical đúng chính nó |
| /?s=kudatoto+login | trang tìm kiếm in lại chữ khách gõ (5 lần) nhưng có `noindex,follow` -> không phải đường lọt index |

Nhận định: trang không bị chèn nội dung ở mức kiểm được từ bên ngoài. Vị trí 6-8 cho "dentoto/kudatoto" mà trang không chứa chữ này -> khả năng cao Google đang nhận anchor text spam từ backlink rác trỏ về (negative SEO hoặc mạng link cờ bạc dùng domain sạch làm "mồi"). Giới hạn: giả user-agent Googlebot từ IP thường không loại trừ cloaking theo IP của Google.

Việc cần kiểm tiếp (không thuộc phạm vi nháp, ghi để phiên chính giao):
1. GSC > Kiểm tra URL /ve-digicom/ và /case-study/ > "Xem trang đã thu thập" để thấy HTML Google thật sự đọc (loại trừ cloaking theo IP).
2. GSC > Liên kết > trang được liên kết nhiều nhất + văn bản liên kết hàng đầu: tìm anchor dentoto/kudatoto/birutoto, lấy danh sách domain.
3. Nếu là link rác: theo Google, thường không cần disavow vì hệ thống tự bỏ qua link spam; chỉ cân nhắc disavow khi có thao tác thủ công hoặc nhận cảnh báo (Google Search Central, "Disavow links to your site", https://developers.google.com/search/docs/crawling-indexing/disavow-links, đọc 02/11/2026: tính năng chỉ dành khi có nhiều link spam/nhân tạo và họ tin đã gây hoặc sẽ gây tác vụ thủ công).
4. Kiểm file lõi WP/plugin trên host (wp core verify-checksums, plugin verify-checksums) nếu bước 1 thấy HTML khác.

## 3. Hiện trạng chữ live
- H1 "Về DigicomVN" + 3 đoạn ngắn (~90 từ), danh sách 8 link dịch vụ, khối pháp nhân, khối liên hệ. Trang mỏng: không có người phụ trách, không có cách làm việc, không có bằng chứng (case study), không có câu hỏi thường gặp.
- Danh sách dịch vụ còn thiếu phần mềm SEO (một trong 4 nhóm chính theo lam-sau-co-trong-diem.md).

## 4. Đối thủ (trang giới thiệu)
Ba agency đọc ở research/trang-chu.md (homepage, WebFetch 02/11/2026) dùng trang giới thiệu/hero theo cùng một khuôn: số năm, số khách, logo, giải thưởng, lời founder. DigicomVN không có số liệu lớn tương đương để đọ. Gap khai thác được: thông tin xác minh được ngay (MST tra trên cổng đăng ký doanh nghiệp, 2 địa chỉ, người phụ trách có tên, quy mô thật 5 người), cách làm việc cụ thể, giá công khai, 5 case có link báo. Trang /ve-digicom/ là AboutPage (schema theme tự sinh, mainEntity -> Organization) nên nội dung cần khớp đúng thông tin schema: foundingDate 11/2021, numberOfEmployees 5.

## 5. Hướng viết lại
- Giữ H1 "Về DigicomVN" (khớp truy vấn thương hiệu, vị trí 1,1).
- Mở bằng một đoạn trả lời thẳng: DigicomVN là ai, pháp nhân, từ khi nào, làm gì.
- H2 "Ai đang làm việc với bạn": 5 nhân sự, founder Đỗ Hiếu (tiểu sử theo brand-info: hơn 10 năm làm SEO, Entity Branding, PR báo chí), link trang tác giả.
- H2 "DigicomVN làm những việc gì": 4 nhóm chính, mỗi nhóm 2-3 câu, link trang dịch vụ.
- H2 "Cách DigicomVN làm việc với khách": danh sách bước thật (audit miễn phí, báo giá từng dòng, hoá đơn VAT, gửi link bài sau khi đăng).
- H2 "Dự án đã làm": 5 case có tên, link /case-study/.
- H2 "Thông tin pháp nhân và liên hệ" (bảng).
- H2 "Câu hỏi thường gặp" 3 câu thương hiệu.
- SEO title (47 ký tự): "Về DigicomVN - Công ty Digito Combat, MST 0109816406"

## 6. Điểm cần Hiếu xác nhận
- Có muốn nêu "5 nhân sự" công khai không (đang có trong schema numberOfEmployees nhưng chưa có trên chữ trang).
- Trang tác giả founder: đã dùng https://digicomvn.com/author/do-hieu/ (redirect từ ?author=1, 02/11/2026).
- Spam anchor: cho phép phiên chính kiểm GSC Liên kết + Kiểm tra URL (mục 2).
