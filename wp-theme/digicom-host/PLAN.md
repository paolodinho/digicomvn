# PLAN - theme digicom-host (checkpoint phụ, bản chính ở /Volumes/Extreme SSD/Projects/digicom/PLAN.md)

## Đang làm dở (checkpoint)
- Task: thêm nhóm "Booking mạng xã hội" (/booking-fanpage/ page 6974, /booking-kol-koc/ page 6975, đang DRAFT).
- Đã xong (local, CHƯA deploy, lint php sạch trên host): functions.php (dgc_service_links +2, DGC_VER 3.9.0), front-page.php (nhóm mới), assets/css/main.css (.svc-links-2), inc/ai-chat.php (mục 10-11), tpl-service.php (quy trình 4 bước riêng), inc/cpt-gia.php (dgc_svc_noprice_slugs, dgc_svc_slug), inc/svc-faq.php + inc/schema.php (FAQ/Service cho trang không bảng giá).
- Đang làm: 2 agent nền soạn content/svc-v2/booking-fanpage.html, booking-kol-koc.html + .meta.json.
- Tiếp theo: CHỜ agent nền (2 agent đang soạn nội dung, Claude tự làm tiếp khi có thông báo xong) - sau đó điền svc_faqs + SEO meta + excerpt từ meta.json, deploy 8 file, publish 2 page, thêm menu, purge, QA, file tổng quan. Chi tiết: PLAN.md gốc dự án.
- Backup live: ~/Claude-Workspace/_backups/routines/2026-10-24/booking-mxh/
- Cập nhật lúc: 2026-10-24 18:10
