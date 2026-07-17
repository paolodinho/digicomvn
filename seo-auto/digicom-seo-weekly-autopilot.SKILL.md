---
name: digicom-seo-weekly-autopilot
description: "Digicom: audit SEO hàng tuần toàn site digicomvn.com - crawl, kiểm on-page/schema/internal link, tự sửa lỗi an toàn qua SSH, báo cáo digest"
---

Bạn đang chạy tự động (không có Hiếu theo dõi trực tiếp) cho dự án Digicom tại thư mục:
`/Volumes/Extreme SSD/CÔNG VIỆC CỦA TÔI/Projects/digicom`

Đọc trước và tuân thủ tuyệt đối: `CLAUDE.md`, `.claude/rules/deploy.md` (SSH Hostinger,
DGC_VER, purge cache), `.claude/rules/do-dont.md`, `.claude/rules/bang-gia-booking.md`
(KHÔNG đụng giá), rule global `routine-backup.md` + `typography-dash.md` + `content-professional.md`.

Site LIVE: https://digicomvn.com (Hostinger, SSH trong deploy.md, wp-cli `--allow-root`,
WP root `domains/digicomvn.com/public_html`).

## 1. Thu thập dữ liệu

a. **Crawl toàn site** (site nhỏ, vài trăm URL): lấy URL từ `https://digicomvn.com/wp-sitemap.xml`
   (đệ quy các sitemap con), với mỗi URL fetch HTML và trích: status, title, meta description,
   H1, số H2, canonical, meta robots, số internal link, ảnh thiếu alt, có JSON-LD không.
   Viết/dùng script `seo-auto/crawl.py` (nếu chưa có thì tạo, requests + concurrent, delay nhẹ
   để không đè host). Lưu kết quả `seo-auto/data/crawl-<YYYY-MM-DD>.csv`.
b. **GSC**: nếu đã có cách pull (service account/API) thì lấy queries + pages 28 ngày về
   `seo-auto/data/gsc-*.csv`. Nếu CHƯA cấu hình được trong phiên headless -> ghi rõ trong digest
   "GSC chưa pull được - cần Hiếu mở phiên có Chrome", KHÔNG bịa số.
c. **Ahrefs MCP** (nếu khả dụng trong phiên): DR + referring domains của digicomvn.com,
   so với lần trước trong `seo-auto/data/offpage.json`. Không khả dụng -> ghi "bỏ qua - MCP
   chưa khả dụng".

## 2. Phân loại issue

Từ crawl, phân loại:
- **P0**: trang chính/pillar không 200; title/meta trùng giữa các pillar; noindex nhầm trang cần index.
- **P1**: title >60 hoặc <25 ký tự; meta description thiếu/quá dài; trùng H1; internal link gãy
  (đích 404 nhưng có URL đúng thay thế); ảnh thiếu alt ở trang dịch vụ/bài blog; thiếu
  BreadcrumbList/FAQPage schema khi trang đã có FAQ thật.
- **P2**: bài blog mỏng (<600 từ), orphan page (0 internal link trỏ tới), em dash "—" lọt trong
  nội dung hiển thị.
- Bỏ qua: 404 không có nguồn trỏ vào (không redirect bừa).

## 3. TỰ SỬA NGAY (phạm vi đã duyệt - không hỏi lại)

CHỈ các loại: title/meta dài-ngắn-trùng, thiếu alt, internal link gãy có đích đúng, em dash -> "-",
thiếu schema Breadcrumb/FAQ khi có FAQ thật.
- Mỗi sửa: **backup trước** (fetch content.raw / wp post get về
  `~/Claude-Workspace/_backups/routines/<ngày>/digicom-seo-weekly/` + ghi 1 dòng manifest.md).
- Sửa qua SSH wp-cli (`wp post update`, `wp post meta update`) - KHÔNG sửa file theme trừ khi
  lỗi nằm trong theme; nếu sửa CSS/JS theme thì BẮT BUỘC bump DGC_VER + purge cache (deploy.md).
- Verify sau sửa bằng curl (không tin browser cache).

TUYỆT ĐỐI KHÔNG tự làm (chỉ liệt kê vào mục 4):
- Viết bài mới / đăng trang mới (cần Hiếu duyệt topic - rule publish-volume-warning).
- Mọi thứ liên quan GIÁ (CPT dgc_gia do routine giá riêng quản), backlink/outreach,
  xoá bài, đổi URL, redirect mới.
- Publish lại các nhóm đang ẩn (4 nhóm media, 147 dòng gói/chung chung).

## 4. Việc cần Hiếu quyết định
Phát hiện cụm chủ đề mới nên viết, trang cần gộp/tách, hay rủi ro chính sách -> thêm vào
`PLAN.md` dưới `## 🔔 Cần Hiếu quyết định (tự động - <ngày>)`, câu hỏi cụ thể + dữ liệu,
không hỏi mở.

## 5. Xuất báo cáo
- Viết `seo-auto/digest-<YYYY-MM-DD>.md`: (a) số toàn site (tổng URL, indexable, P0/P1/P2),
  (b) so với tuần trước, (c) danh sách đã tự sửa (URL + trước/sau), (d) P0/P1 còn tồn + lý do,
  (e) mục cần Hiếu quyết định, (f) offpage (DR/RD nếu có).
- Append 1 dòng vào `LOG.md`: `| <ngày> | Weekly SEO autopilot | tóm tắt 1 câu |`.

Câu trả lời cuối: tóm tắt 5-8 dòng tiếng Việt - đã sửa gì, còn gì chờ Hiếu, số liệu chính.
Bị chặn permission ở bước nào -> dừng, ghi vào digest "bị chặn ở bước X", KHÔNG cố bypass.
