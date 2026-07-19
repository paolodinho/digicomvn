# Plan bộ Backlink - tiếp tục (2026-07-19)

## 0. Bối cảnh (đối chiếu trước khi lập plan)

- Cụm "Backlink & Off-page" hiện có **23 bài publish** (từ đợt 2026-07-03), chưa viết
  thêm bài nào từ đó tới nay. PLAN.md ghi "4 dịch vụ đã đủ nội dung" nhưng đối chiếu lại
  với file từ khoá thật (`backlink_broad-match_vn_2026-07-02.csv`, 3.751 dòng) vẫn còn
  khoảng trống THƯƠNG MẠI (không phải kiến thức chung) chưa viết.
- **Đã loại khỏi phạm vi** (đúng chiến lược pivot - không chạy theo kiến thức SEO chung
  chung cạnh tranh với Ahrefs/Moz): backlink checker, ahrefs backlink checker, PBN,
  disavow, "backlink là gì" (đã có bài), forum/wiki/social backlink kỹ thuật - đây là
  nhóm đã chủ động draft 73 bài kiến thức SEO tổng quát trước đó (DECISIONS.md 2026-07-03).
- **⚠️ Giới hạn phiên này**: môi trường hiện tại KHÔNG có SSH tới host (`ssh` không cài) và
  WebFetch bị site chặn bot (403) - không đối chiếu được sitemap/wp-cli trực tiếp như
  quy trình A1b chuẩn. Đã đối chiếu gián tiếp bằng `site:digicomvn.com "<keyword>"` qua
  WebSearch (Google) - không thấy bài nào trùng 4 chủ đề đề xuất bên dưới, nhưng cần
  1 lượt xác nhận nhanh qua `wp post list --s=...` (session có SSH) TRƯỚC khi viết, phòng
  trường hợp Google chưa index kịp 1 bài nào đó.

## 1. Đề xuất (4 hành động - 2 SỬA, 2 MỚI P0, 1 MỚI P1)

| # | Loại | Việc | Từ khoá chính (volume/KD) | Lý do |
|---|---|---|---|---|
| 1 | SỬA | Kiểm tra SEO `<title>` trang pillar `/dich-vu/dich-vu-backlink/` có chứa đúng cụm "dịch vụ backlink" | dịch vụ backlink (3.600, KD41) | Từ khoá volume lớn nhất cụm, đúng vai money page - không viết blog cạnh tranh (rule A2c #2), chỉ audit tiêu đề |
| 2 | SỬA | Tối ưu lại title/H1 bài `backlink-bat-dong-san` theo cụm "backlink chất lượng bất động sản" | backlink chất lượng bất động sản (320) + backlink bất động sản chất lượng (210) | Google search xác nhận digicomvn.com CHƯA xuất hiện ở 2 cụm này dù đã có bài đúng chủ đề - khả năng lệch title/H1 |
| 3 | MỚI P0 | "Có Nên Mua Backlink Không? Rủi Ro Và Cách Chọn NCC Uy Tín" | có nên mua backlink, mua backlink uy tín, mua backlink là gì, mua backlink chất lượng (~30-50/kw) | Bài trust/gỡ nghi ngại trước khi mua - hỗ trợ chuyển đổi trực tiếp, chưa có bài nào trên site |
| 4 | MỚI P0 | "Mua Backlink Báo Là Gì? Khác Gì Booking Báo & PR?" | mua backlink báo (110), backlink báo (210), bán/cho thuê backlink báo (~10-30) | Bắc cầu 2 dịch vụ (Backlink + Booking báo PR), khách hay nhầm 2 khái niệm - internal link 2 chiều tới cả 2 money page |
| 5 | MỚI P1 | "Cách Đặt Backlink Hiệu Quả Cho Website Mới Bắt Đầu" | cách đặt backlink hiệu quả, cách đi backlink, hướng dẫn đặt backlink (~20-30/kw, cộng dồn ~150) | Bài howto supporting, dẫn hành trình học -> cân nhắc -> pillar/guest-post |

## 2. Chi tiết từng bài MỚI

### Bài 3 - Có Nên Mua Backlink Không?
- Intent: informational-commercial (trust/gỡ nghi ngại).
- Loại bài Google đang ưu tiên: bài dạng "kinh nghiệm + cảnh báo rủi ro" (seotoro.vn,
  hapodigital, lptech đang top) - Digicom hơn bằng: ví dụ rủi ro cụ thể (spam score, thuật
  toán SpamBrain), tiêu chí chọn NCC uy tín áp thẳng vào cách Digicom vận hành (minh bạch
  nguồn, không PBN).
- Slug: `/co-nen-mua-backlink-khong/` - Category: Backlink & Off-page.
- Widget: `[dgc_offpage_quiz]` (kiến thức nền, "nên làm gì trước khi mua").
- Money page đích: `/dich-vu/dich-vu-backlink/` (anchor thương mại "dịch vụ backlink uy tín").

### Bài 4 - Mua Backlink Báo Là Gì?
- Intent: informational-commercial, vai trò bắc cầu.
- Góc khác biệt: bảng so sánh "Mua backlink báo (chèn link vào bài có sẵn/bài mới)" vs
  "Booking báo & PR (đặt lịch đăng bài PR)" - 2 khái niệm khách hay lẫn, chưa đối thủ nào
  làm rõ so sánh này.
- Slug: `/mua-backlink-bao-la-gi/` - Category: Backlink & Off-page.
- Widget: `[dgc_budget_calc]` (đụng tới chi phí).
- Money page đích: CẢ `/dich-vu/dich-vu-backlink/` VÀ `/dich-vu/booking-bao-pr/` (2 anchor riêng).

### Bài 5 - Cách Đặt Backlink Hiệu Quả
- Intent: informational, supporting/học.
- Slug: `/cach-dat-backlink-hieu-qua/` - Category: Backlink & Off-page.
- Link tới: pillar Backlink + Guest Post (2 cách đi link hợp pháp phổ biến).
- Widget: `[dgc_offpage_quiz]`.

## 3. Sơ đồ internal link

```
Bài 5 (Cách đặt backlink hiệu quả)  --học--> Pillar Backlink
Bài 3 (Có nên mua backlink)         --cân nhắc--> Pillar Backlink
Bài 4 (Mua backlink báo là gì)      --cân nhắc--> Pillar Backlink + Pillar Booking báo PR
Bài cũ backlink-bat-dong-san        --2 link mới trỏ về--> Bài 3, Bài 4 (liên quan)
```

## 4. Việc KHÔNG làm (ngoài phạm vi)
- Không viết bài về backlink checker/tool (ahrefs, đối thủ công cụ - KD 75-93, sai chiến lược).
- Không viết lại "backlink là gì" (đã có, ID cũ trong 23 bài).
- Không đụng CPT `dgc_gia`/giá.
- Không mở ngách mới ngoài bất động sản (dữ liệu từ khoá không cho thấy ngách thứ 2 nào
  có volume đáng kể).

## 4b. Quy trình research bắt buộc cho 3 bài MỚI (rule global 2026-07-19)

Theo rule mới (`~/.claude/CLAUDE.md` mục "SEO Content Research", áp mọi dự án): trước khi
viết bài 3/4/5, phải search từng keyword chính trên Google, đọc kỹ **10 kết quả đầu**
(không dừng ở top 3-5), xác định lại intent thật, ghi nhận domain + loại bài + gap của
top 3-5 organic, chốt info gain cụ thể - rồi mới viết. Khi báo cáo bài viết xong, PHẢI nêu
rõ 3 mục: (1) search intent kết luận gì + bằng chứng, (2) đối thủ đã đọc - domain nào, gap
gì, (3) info gain đã áp dụng vào bài. Bước sơ bộ đã làm khi lập plan này (xem mục 0 - đối
chiếu `site:digicomvn.com`) chưa thay thế được bước research đầy đủ top 10 - vẫn phải chạy
lại đúng quy trình trên khi bắt tay viết từng bài, không dùng lại kết quả sơ bộ này làm báo
cáo chính thức.

## 5. Checkpoint

Chờ Hiếu duyệt plan này trước khi viết. Duyệt xong sẽ chạy tự động bước 2 (audit 2 SEO
title) + bước 3 (viết 2 bài P0) trong 1 lần, bài P1 chạy sau nếu Hiếu OK.
