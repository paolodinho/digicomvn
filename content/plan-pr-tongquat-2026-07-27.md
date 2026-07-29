# Kế hoạch: bài viết còn thiếu trên toàn site - 2026-07-27 (tiếp /goal)

> Input: gap-scan 4 agent song song + rà tay 3 file mới ("Keyword Tool Export... booking/pr/báo
> chí" + Adtima) đối chiếu 135 bài + 7 trang dịch vụ đang live. Ưu tiên "làm đậm" cụm booking/PR/
> báo chí theo yêu cầu Hiếu 2026-07-27.

## Kết luận gap-scan theo từng nguồn

| Nguồn (dòng gốc) | Gap thật còn lại |
|---|---|
| `backlink_broad-match...csv` (3752) | 5 cụm (Audit/Profile, Indexer, Disavow, Loại backlink, Social backlink) |
| `guest-post_broad-match...csv` (334) + `mua-textlink...csv` (7) | 2 cụm nhỏ (Guest Post quốc tế, Pitch/Outreach DIY) |
| `pr-báo_broad-match...csv` (370, riêng booking-báo) | **Không còn gap đáng kể** - 21 bài + N1/N2 đã phủ kín. Chỉ còn R16 Tiền Phong (đã biết từ trước, chưa build trang) |
| `pr_broad-match...csv` (14351, CHƯA từng khai thác) | **Gap lớn nhất dự án**: cụm "PR/Quan hệ công chúng" tổng quát - 111/14351 dòng liên quan thật sau lọc nhiễu, tổng volume quy về 5 cụm ~14.500 |
| 3 file mới sáng nay (booking/pr/báo chí, ~2076 dòng, không volume) | Xác nhận chéo cùng kết luận trên (không có volume nhưng cùng cụm từ "PR khác gì marketing/PR nội bộ"); booking.csv + phần lớn báo chí.csv là nhiễu (khách sạn, học viện báo chí) |

## DANH SÁCH BÀI MỚI (đã gộp theo rule chống cannibalization + publish-volume-warning)

### Ưu tiên CAO - cụm PR tổng quát (làm đậm theo yêu cầu, volume lớn nhất từng thấy ở dự án này)

| Mã | Tiêu đề dự kiến | Slug | Volume | Info gain hướng tới |
|---|---|---|---|---|
| P1 | PR (Quan Hệ Công Chúng) Là Gì? Vai Trò, Lịch Sử Và Khác Biệt Với Marketing | `/pr-la-gi/` | ~12.080 (gộp PR là gì + vai trò + PR vs Marketing + xu hướng) | Pillar mới, phân biệt RÕ với `/bai-pr-la-gi/` (định dạng bài viết) - link chéo 2 chiều |
| P2 | Các Loại Hình PR: Nội Bộ, Đối Ngoại, Cộng Đồng, Online, Khủng Hoảng | `/cac-loai-hinh-pr/` | ~520 | ✅ Xong 2026-07-28 - `https://digicomvn.com/cac-loai-hinh-pr/` (post 4728). Bài đã được một phiên khác dựng sơ bộ 2026-07-27 nhưng thiếu internal link + external EEAT link; phiên này research SERP lại, viết đè nội dung mới (giữ nguyên slug/ID/URL) với 3 internal link (pillar, booking-bao-pr, thông cáo khủng hoảng), 3 external link EEAT (PRSA, Wikipedia CSR, Wikipedia crisis communication), 2 ảnh Storyset mới, 3 sơ đồ HTML, bảng so sánh, quiz widget, FAQ schema 4 câu. Bài trùng do lỗi slug tự thêm hậu tố (`cac-loai-hinh-pr-2`, post 4790) đã chuyển trash, không còn URL trùng. |
| P3 | Case Study Chiến Dịch PR Nổi Bật Của Các Thương Hiệu Lớn | `/case-study-chien-dich-pr/` | ~500 | Case thật có nguồn công khai (Coca-Cola, Grab, Viettel, Vinamilk...), KHÔNG bịa chi tiết |
| P4 | Mô Hình RACE Trong PR: Lập Kế Hoạch Và Đo Lường Hiệu Quả | `/mo-hinh-race-pr/` | ~510 (gộp kế hoạch + đo lường KPI) | Framework RACE + chỉ số đo lường, chưa site nào có |

Gộp không tách bài riêng: Agency PR full-service (230 vol, rủi ro cannibal với `agency-booking-bao-chi`) và Công cụ/kênh PR (130 vol) → làm mục nhỏ trong P1/P2.

### Ưu tiên nhanh - booking cluster (entity còn thiếu, dữ liệu giá đã có sẵn)

| Mã | Bài | Ghi chú |
|---|---|---|
| T1 | Booking báo Tiền Phong | ✅ Xong 2026-07-28 - post 4720, `https://digicomvn.com/book-bao-tien-phong/`. Trang đã có sẵn từ trước (theo mẫu R1); phiên này phát hiện + dọn 3 dòng giá `dgc_gia` trùng lặp (post 1032/4716/4717, draft giữ rollback) để bảng giá chỉ còn đúng 5 vị trí thật (4.378.000đ → 52.530.000đ), cập nhật lại nội dung bài khớp 5 vị trí, và bổ sung link 2 chiều từ pillar `/booking-bao-pr/` (post 475). |

### Ưu tiên CAO - cụm Backlink

| Mã | Bài | Slug | Volume |
|---|---|---|---|
| B1 | Backlink Audit: Cách Phân Tích Backlink Profile Đối Thủ Và Website | `/backlink-audit/` | 610 |
| B2 | Backlink Indexer: Cách Index Backlink Nhanh Nhất 2026 | `/backlink-indexer/` | 350 |
| B3 | Disavow Backlink: Cách Xử Lý Backlink Xấu, Toxic, Spam | `/disavow-backlink/` | 270 |
| B4 | Các Loại Backlink: Tier 1/2/3, PBN, Thủ Công Và Công Cụ | `/cac-loai-backlink/` | 360 (gộp kỹ thuật nâng cao GSA/HARO/Web2.0) |
| B5 | Backlink Từ Mạng Xã Hội: Facebook/YouTube/Pinterest Có Tính SEO Không | `/backlink-mang-xa-hoi/` | 260 (✅ Xong 2026-07-27, post 4759, chi tiết `content/cluster-backlink-gap.md`) |

### Ưu tiên TB - cụm Guest Post

| Mã | Bài | Slug | Volume |
|---|---|---|---|
| G1 | Guest Post Forbes/Báo Quốc Tế: Sự Thật Và Cách Nhận Biết Lừa Đảo | `/guest-post-forbes/` | 50 |
| G2 | Cách Viết Email Pitch Guest Post (Outreach) Và Khi Nào Nên Thuê Dịch Vụ | `/pitch-guest-post/` | 120 |

## Tổng: 12 bài mới

Thứ tự viết: P1→P4 (PR tổng quát, ưu tiên cao nhất theo yêu cầu "làm đậm") → T1 (Tiền Phong,
quick win) → B1→B5 (backlink) → G1→G2 (guest post). Batch tối đa 3 bài/lần chạy theo rule
content-pipeline, mỗi bài qua đủ quy trình: research SERP 10 đối thủ, dàn bài đầy đủ+hơn info
gain, viết trực diện (AEO), widget bắt buộc, ảnh Storyset, deploy SSH, internal link 2 chiều,
submit GSC.

## Việc từ 3 file mới sáng nay (không phải content gap, ghi chú riêng)

- `Adtima_Báo giá.xlsx` - Adtima là mạng quảng cáo VNG (Báo Mới, Zing...) - dữ liệu GIÁ tham
  khảo, không phải keyword content. Không xử lý trong plan này (thuộc phạm vi `bang-gia-booking.md`,
  routine giá riêng quản) - nếu Hiếu muốn đưa Adtima vào 3 NCC chính thức, cần quyết định riêng.
- `Bảng tính không có tiêu đề - Trang tính1.csv` - file rỗng (0 dòng), bỏ qua.

## Sheet chung (link Hiếu chỉ định)

https://docs.google.com/spreadsheets/d/1IYqgL0Yl5iB5jVc4w6Ql50drzfOXU9cWTvN44ytDeAs/edit

Lưu ý kỹ thuật: công cụ Drive hiện có (`create_file`) chỉ tạo file MỚI, KHÔNG có quyền
update/append trực tiếp vào Sheet đã tồn tại (không có Sheets API write trong bộ công cụ phiên
này). Vì vậy: audit gốc (117 dòng) vẫn nằm nguyên trong Sheet trên; kế hoạch + tiến độ 12 bài
mới này theo dõi tại file này + `content/cluster-*.md` (đúng quy ước sổ cái sẵn có của dự án) -
sẽ báo lại đầy đủ để Hiếu đối chiếu, và có thể xuất thêm 1 Sheet mới nếu Hiếu muốn có bản trên
Drive.
