---
name: digicom-seo-monthly-content
description: "Digicom: hàng THÁNG (ngày 1) rà content gap + refresh bài cũ yếu, đề xuất topic mới cho Hiếu duyệt, KHÔNG tự đăng bài mới"
---

Bạn đang chạy tự động cho dự án Digicom tại:
`/Volumes/Extreme SSD/CÔNG VIỆC CỦA TÔI/Projects/digicom`

Đọc trước: `CLAUDE.md`, `.claude/rules/dich-vu.md`, `.claude/context/brand-info.md`,
rule global `publish-volume-warning.md` (QUAN TRỌNG - không đề xuất đăng vượt search volume),
`content-professional.md`, `image-sourcing.md` (ảnh minh hoạ = Storyset).

## 1. Rà content hiện có
- Lấy danh sách bài blog trên live (`wp post list --post_type=post --post_status=publish`).
- Với 5-10 bài yếu nhất (cũ nhất chưa refresh / mỏng nhất / GSC impression thấp nếu có data):
  research SERP lại keyword chính, xác định gap so top 5.

## 2. REFRESH bài cũ (được tự làm)
- Quy tắc: GIỮ NGUYÊN 100% nội dung + BỔ SUNG (không cắt), giữ slug, thêm FAQ từ PAA,
  bổ sung số liệu có nguồn, cập nhật năm. Tối đa 3-5 bài/tháng.
- Backup content.raw trước khi PUT (routine-backup.md). Verify 200 sau khi sửa.
- Giữ nguyên các widget/shortcode trong bài ([dgc_dr_chart], [dgc_budget_calc],
  [dgc_offpage_quiz], bảng giá) - không xoá, không nhân đôi.

## 3. ĐỀ XUẤT topic mới (KHÔNG tự đăng)
- Quét keyword gap: so blog Digicom với 2-3 đối thủ cùng ngách (bán textlink/guest post/booking PR).
  Dùng Ahrefs/Semrush MCP nếu khả dụng; không thì WebSearch thủ công.
- Áp rule publish-volume-warning: mỗi topic đề xuất phải là intent RIÊNG, kèm volume ước tính.
- Ghi tối đa 5 topic/tháng vào `PLAN.md` mục `## 🔔 Cần Hiếu quyết định (tự động - <ngày>)`
  dạng bảng: topic | keyword chính | volume | lý do | ưu tiên. Hiếu duyệt rồi mới viết
  (dùng skill content-writer + brand-info.md).

## 4. Báo cáo
- `seo-auto/content-review-<YYYY-MM>.md`: bài đã refresh (trước/sau), topic đề xuất, gap chính.
- Append 1 dòng LOG.md. Trả lời cuối: 5-8 dòng tiếng Việt.
