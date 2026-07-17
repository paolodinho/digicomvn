---
name: digicom-seo-daily-pulse
description: "Digicom: kiểm tra nhanh sức khoẻ SEO hàng ngày (site live digicomvn.com), cảnh báo bất thường, không sửa gì"
---

Bạn đang chạy tự động (không có Hiếu theo dõi trực tiếp) cho dự án Digicom tại thư mục:
`/Volumes/Extreme SSD/CÔNG VIỆC CỦA TÔI/Projects/digicom`

`cd` vào thư mục này. Đây là kiểm tra NHANH hàng ngày (~5 phút), KHÔNG phải audit đầy đủ
(audit đầy đủ chạy thứ Hai hàng tuần - đừng lặp lại việc đó). KHÔNG sửa nội dung, KHÔNG deploy.

## Việc cần làm

1. Spot-check các trang quan trọng trên LIVE (curl HEAD, xác nhận 200):
   - `https://digicomvn.com/` , `/bang-gia/`, `/dat-bai/`, `/blog/`, `/lien-he/`
   - 8 pillar: `/mua-textlink/`, `/dich-vu-backlink/`, `/guest-post/`, `/booking-bao-pr/`,
     `/dich-vu-toplist/`, `/backlink-social-entity/`, `/backlink-quoc-te/`,
     `/dich-vu-backlink/bat-dong-san/`
   - Trang nào KHÔNG 200 -> P0 khẩn: ghi vào đầu `PLAN.md` mục `## 🚨 KHẨN - <ngày>`
     (URL + status code), KHÔNG tự sửa (có thể host đang bảo trì).
2. Kiểm tra sitemap còn sống: `curl -sI https://digicomvn.com/wp-sitemap.xml` phải 200.
3. Kiểm tra 2-3 URL redirect 301 cũ (vd `/dich-vu/mua-textlink/` -> `/mua-textlink/`)
   vẫn trả 301 đúng đích.
4. Đọc `PLAN.md` mục `## 🔔 Cần Hiếu quyết định` - nếu có mục tồn quá 3 ngày, giữ nguyên
   (đã hiển thị qua hook đầu session), không cần làm gì thêm.

## Xuất kết quả
- KHÔNG có gì bất thường: trả lời 1 dòng "Pulse OK - <n> URL 200, sitemap OK, redirect OK."
  KHÔNG tạo file, KHÔNG ghi LOG.md (tránh spam).
- CÓ bất thường: ghi PLAN.md như trên + trả lời tóm tắt ngắn vấn đề.
