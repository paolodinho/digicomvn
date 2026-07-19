# Run log - Cụm Backlink, đợt tiếp tục 2026-07-19

Bảng kiểm chứng theo yêu cầu skill `content-pipeline` (mỗi bước 1 dòng, bằng chứng kiểm được).

| Bước | Làm/bỏ qua (lý do) | Bằng chứng |
|---|---|---|
| Đối chiếu sitemap/wp post list | BỎ QUA - không có SSH tới host trong phiên này (`ssh` không cài, WebFetch bị site chặn 403, curl trong Bash không có egress) | Test trực tiếp: `curl -s -o /dev/null -w "%{http_code}" https://digicomvn.com/...` trả `000`; `WebFetch` trả `403 Forbidden` |
| Đối chiếu gián tiếp qua Google | Làm | `site:digicomvn.com backlink báo`, `site:digicomvn.com "có nên mua backlink"...` qua WebSearch - không thấy bài trùng nội dung đề xuất (index của site rất mỏng, chỉ 1-2 kết quả mỗi query) |
| Audit title pillar `/dich-vu-backlink/` (mục 1) | Làm gián tiếp qua 3 nguồn nội bộ (không phải audit trực tiếp title live) | `dich-vu.md`, `page-dich-vu.php:18`, `functions.php dgc_seo_title_map()` - đều thống nhất tên "Dịch vụ Backlink"; kết luận khả năng cao đã đúng, cần 1 lệnh `wp post get 268 --field=post_title` để chốt 100% |
| Sửa title/H1 bài backlink bất động sản (mục 2) | Làm - tìm thấy file nguồn thật `_content-p1/backlink-bat-dong-san.html`, xác nhận title cũ thiếu cụm "chất lượng", đã sửa | Diff title cũ "Backlink Bất Động Sản: Đặc Thù Ngách..." -> mới "Backlink Chất Lượng Bất Động Sản: Tiêu Chí Chọn Site và Rủi Ro Cần Tránh"; đồng thời fix 3 link nội bộ còn dùng URL cũ `/dich-vu/dich-vu-backlink/...` (tiền-flatten 2026-07-16) sang URL flat đúng |
| Research SERP top 10 - "có nên mua backlink" | Làm | WebSearch 2 lượt, 9 kết quả tổng hợp (lptech.asia, giupbanhocnghe.com, seotoro.vn, seothetop.com, kinhtedothi.vn, baoquangnam.vn, buffseo.com, seoviet.vn, aznet.vn) - chi tiết ở `content/cluster-backlink.md` mục "Nghiên cứu + info gain" |
| Research SERP top 10 - "mua backlink báo là gì" | Làm | WebSearch, 10 kết quả (danaseo.net, hapodigital.com, backlinkaz.com, famemedia.vn, foogleseo.com, muabacklinkbao.com, buffseo.com, litado.edu.vn, mdigi.vn, prbaochi.com) |
| Allintitle check | Bỏ qua một phần - công cụ WebSearch không trả số đếm allintitle thật (không phải Google Search trực tiếp, không hỗ trợ operator allintitle đúng nghĩa) | Đã thử `allintitle: <keyword>` 3 lần, tool trả về danh sách kết quả nhưng KHÔNG có tổng số - ghi nhận định tính trong cluster-backlink.md, không bịa con số |
| Viết bài 3 - Có Nên Mua Backlink Không? | Làm | File `content/co-nen-mua-backlink-khong.html` - H1/SAPO/tóm tắt/3 H2 + FAQ + kết luận, widget `[dgc_offpage_quiz]`, 3 internal link (`/dich-vu-backlink/`, `/dich-vu-backlink-gia-bao-nhieu/`, `/bang-gia/`, `/dat-bai/`) |
| Viết bài 4 - Mua Backlink Báo Là Gì? | Làm | File `content/mua-backlink-bao-la-gi.html` - bảng so sánh 2 dịch vụ, widget `[dgc_budget_calc]`, internal link tới CẢ `/dich-vu-backlink/` và `/booking-bao-pr/` |
| Đăng lên WordPress (BƯỚC 6) | BỎ QUA - không có SSH | Cần session sau có quyền SSH Hostinger, xem checklist trong `content/cluster-backlink.md` mục "Giới hạn cần lưu ý cho session sau" |
| Internal link 2 chiều (BƯỚC 7) | Chưa làm - phụ thuộc bước đăng | - |
| Submit GSC (BƯỚC 7b) | Chưa làm - phụ thuộc bước đăng | - |
| Bài 5 (P1 - Cách đặt backlink hiệu quả) | Chưa làm - tách việc nặng ra làm đợt sau theo yêu cầu Hiếu | Cập nhật `content/cluster-backlink.md` dòng 5 |

## Tóm tắt cho Hiếu

- Đã audit xong mục 1 (khả năng cao OK, cần xác nhận 1 lệnh khi có SSH) và sửa xong mục 2
  (file sẵn sàng, chờ đăng).
- Đã research đầy đủ top 10 + viết xong 2 bài P0 (mục 3, 4), lưu file HTML sẵn sàng đăng.
- Bài 5 (P1) để đợt sau.
- Việc CÒN THIẾU duy nhất để hoàn tất đợt này: một session có SSH tới Hostinger để đăng
  3 file lên WordPress + submit GSC - phiên hiện tại không có quyền này.
