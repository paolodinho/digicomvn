# BRAND CONFIG - Digicom
> Nguồn duy nhất cho mọi skill generic.
> Last updated: 2026-06-10

## 1. Doanh nghiệp

| Trường | Nội dung |
|---|---|
| Thương hiệu | Digicom - Agency truyền thông số |
| Tên gọi tắt thống nhất | **DigicomVN** (dùng trong mọi nội dung PR/bài viết/anchor text, thay vì "Digicom" đơn lẻ - chốt 2026-07-11) |
| Pháp nhân | Công ty TNHH Dịch vụ Truyền thông Digito Combat |
| MST | 0109816406 |
| Domain | https://digicomvn.com |
| Trụ sở (ĐKKD, dùng cho hợp đồng/hoá đơn) | Số 200, Đường 3.1, KĐT Gamuda Garden, P. Trần Phú, Q. Hoàng Mai, Hà Nội |
| Văn phòng giao dịch (NAP dùng cho GBP/backlink/citation - chốt 2026-07-14) | Tầng 3, tòa nhà Thăng Long A1, đường Tây Cao Tốc, thôn Bầu, xã Kim Chung, huyện Đông Anh, Hà Nội |

> NAP nhất quán: mọi listing local/citation/backlink dùng ĐÚNG chuỗi "Văn phòng giao dịch" ở trên,
> không viết tắt, không đổi thứ tự. Văn phòng này dùng chung địa chỉ với ICD Việt Nam (cùng toà nhà).
> Trụ sở Gamuda Garden chỉ dùng cho hợp đồng, hoá đơn, thông tin pháp nhân.

## 2. Liên hệ

| Kênh | Giá trị |
|---|---|
| Hotline | 0988 769 317 |
| Phone tel: link | `tel:0988769317` |
| Email | info@digicomvn.com |
| Giờ làm việc | Thứ 2 - Thứ 6, 8:00 - 18:00 |
| Social | Facebook, LinkedIn, TikTok, YouTube |

## 3. Tác giả mặc định

| Trường | Nội dung |
|---|---|
| Tên | Đỗ Hiếu |
| Chức danh | Founder & Digital Marketing Strategist tại Digicom |
| Tiểu sử ngắn | Hơn 10 năm kinh nghiệm thực chiến trong lĩnh vực SEO, Entity Branding, PR báo chí và xây dựng thương hiệu. |

## 4. Sản phẩm / Dịch vụ + URL

> **FLATTEN 2026-07-16 (Hiếu quyết):** BỎ hub `/dich-vu/`, 8 pillar chuyển LÊN GỐC.
> URL cũ `/dich-vu/...` đã 301 về URL mới (handler trong theme functions.php).

| # | Dịch vụ | URL / slug (MỚI, ở gốc) |
|---|---|---|
| 1 | Mua Textlink | `/mua-textlink/` |
| 2 | Dịch vụ Backlink | `/dich-vu-backlink/` (ngách BĐS: `/dich-vu-backlink/bat-dong-san/`) |
| 3 | Guest Post | `/guest-post/` |
| 4 | Booking báo & PR | `/booking-bao-pr/` (pillar) |
| 5 | Dịch vụ Toplist | `/dich-vu-toplist/` |
| 6 | Backlink Social Entity | `/backlink-social-entity/` |
| 7 | Backlink quốc tế | `/backlink-quoc-te/` |
| 8 | Booking truyền hình | `/booking-truyen-hinh/` |

KHÔNG còn hub `/dich-vu/` (301 về trang chủ). Trang con đầu báo `/booking-bao-pr/<bao>/`
đã chuyển thành BÀI BLOG `/book-bao-<bao>/` (15 bài, 301 tự động, 2026-07-16) - bài nhúng
bảng giá động qua shortcode `[dgc_bang_gia bao="..." domain="..."]`.
Bảng giá: `/bang-gia/` (giá thật theo CPT `dgc_gia`).
Đặt bài: `/dat-bai/`. Về Digicom: `/ve-digicom/`. Liên hệ: `/lien-he/`.

**QUAN TRỌNG - URL cũ đã đổi cấu trúc (pivot 2026-07-02):** Toàn bộ URL dịch vụ cũ dạng
phẳng (`/dich-vu-backlink/`, `/pr-bao-chi/`, `/entity-branding/`, `/thiet-ke-website/`,
`/cham-soc-website/`) KHÔNG còn là money page thật. `/dich-vu-backlink/` hiện là URL của
1 bài blog cũ (post ID 227, trùng slug với page pillar mới nhưng khác cấp - page pillar
thật nằm ở `/dich-vu/dich-vu-backlink/`). Bài blog cũ nào còn link ra các URL phẳng này
cần sửa lại trỏ đúng sang `/dich-vu/...` (xem DECISIONS.md 2026-07-03).
Trang tên miền/hosting/bản quyền/automation/SEO tổng thể đã chuyển DRAFT, không dùng làm
đích internal link cho tới khi publish lại (xem `.claude/rules/pivot-2026-07.md`).

## 5. Khách hàng mục tiêu

Khách hàng B2B: Chủ doanh nghiệp SME, Marketing Manager, Brand Manager, Startup Founder, E-commerce Manager - doanh nghiệp cần PR báo chí + SEO + xây thương hiệu online.

## 6. Tagline / USP

Tagline chính thức: "Agency truyền thông số - PR báo chí, Backlink SEO, Entity Branding & Website."

Lĩnh vực: SEO (on-page, off-page, technical, local, e-commerce), Backlink, Entity Branding, PR báo chí / Digital PR, Thiết kế Website, Chăm sóc Website, Content Marketing, AI SEO / GEO, Branded SEO, Personal Branding.

## 7. Cụm chủ đề & Internal link

> Cập nhật 2026-07-03 sau audit `/internal-link-audit` (thuật toán attractor, dựa trên
> link graph thật trong post_content của 96 bài publish, không đoán theo từ khoá).
> Xem chi tiết đầy đủ DECISIONS.md 2026-07-03.

URL pattern blog: `/[slug]/` (flat, không nested `/blog/`). Tối đa 5 internal link/bài, ≥1 link money page.

**Pillar THẬT phát hiện được (≥5 bài vote làm attractor):**

| Pillar | Số bài cluster | Loại nội dung |
|---|---|---|
| `/backlink/` | 19 | Kiến thức Backlink/Off-page (kho blog cũ, agency tổng quát) |
| `/on-page-seo/` | 16 | On-page SEO |
| `/technical-seo/` | 11 | Technical SEO |
| `/schema-markup/` | 6 | Schema/Local/Entity |
| `/google-search-console/` | 5 | Đo lường GSC/GA4 |

37/96 bài (~39%) chưa thuộc pillar nào (mồ côi hoặc outlink quá yếu) - danh sách đầy đủ trong DECISIONS.md.

**Mismatch quan trọng với pivot 4 dịch vụ (2026-07-02):** 91/96 bài là kho kiến thức SEO
tổng quát từ thời agency cũ, KHÔNG map trực tiếp vào 4 dịch vụ hiện tại (Mua Textlink/
Dịch vụ Backlink/Guest Post/Booking báo & PR). Chỉ 2 bài mới (`textlink-khac-backlink-the-nao`,
`guest-post-la-gi`) link đúng ra money page mới. Money page `/dich-vu/booking-bao-pr/` và
`/dich-vu/mua-textlink/` gần như chưa có bài blog nào hỗ trợ SEO thật sự.

**Lỗi link cần sửa:** ~89 bài trong cluster `/backlink/` cũ đang link ra `/dich-vu-backlink/`
(URL phẳng, hiện là bài blog cũ post ID 227 - không phải trang dịch vụ tiền thật) thay vì
`/dich-vu/dich-vu-backlink/` (page pillar thật, ID 268). Xem mục 4.

Quy tắc (CẬP NHẬT 2026-07-16 sau flatten): link money page dùng URL GỐC theo bảng mục 4
(vd `/booking-bao-pr/`, `/mua-textlink/`). KHÔNG dùng `/dich-vu/...` nữa (đã 301).
Lưu ý slug `/dich-vu-backlink/`: sau flatten đây CHÍNH LÀ page pillar (bài blog cũ trùng slug
đã bị thay thế vị trí - kiểm tra post ID khi sửa). Không bịa URL.

## 8. WordPress / Publish

| Trường | Nội dung |
|---|---|
| Domain | https://digicomvn.com |
| CMS | WordPress (Gutenberg blocks) |
| Output | File .html Gutenberg, paste thẳng Code Editor |
| Blog post | CÓ H1 (Gutenberg không tự render H1 từ title) |
| Category/Tag | KHÔNG có H1 |
| Theme tác giả | Đã có sidebar tác giả - KHÔNG thêm box tác giả vào bài |

## 9. Backlink

(chưa có - chưa có baseline backlink riêng cho Digicom trong nguồn)

## 10. Thumbnail / Brand visual

Skill content-writer SKIP ảnh/thumbnail - không tìm ảnh, không tạo placeholder, user tự thêm sau.
(Bộ design token/màu/font riêng cho Digicom: chưa có trong nguồn.)

## 11. QA / Gotcha riêng

- Dùng (-) không dùng (—); cũng tránh en dash.
- KHÔNG box tác giả trong bài (trùng sidebar theme).
- KHÔNG dòng "Cập nhật: tháng X/2026 | Tác giả:..." inline.
- KHÔNG placeholder ảnh broken (figure/img rỗng).
- KHÔNG bịa số liệu / case study / URL. Mọi số liệu có nguồn + năm inline.
- KHÔNG dùng sáo ngữ: "giá cạnh tranh", "cam kết top 1", "tốt nhất thị trường", "giải pháp toàn diện", "không thể thiếu", "đóng vai trò quan trọng".
- Title: không (—), không ALL CAPS, keyword ở 3-4 từ đầu, khác H1.
