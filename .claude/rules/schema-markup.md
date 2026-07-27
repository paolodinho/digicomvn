# Schema.org - MỘT khối @graph duy nhất toàn site (chốt 2026-07-27)

> File nguồn: `wp-theme/digicom-host/inc/schema.php`. Mọi thay đổi schema đi qua file này.

## Nguyên tắc gốc

1. **Mỗi trang chỉ có ĐÚNG 1 thẻ `<script type="application/ld+json">`** - một khối `@graph`,
   các node nối nhau bằng `@id`. TUYỆT ĐỐI không thêm khối JSON-LD rời rạc ở template hay
   chèn vào nội dung bài.
2. **Không bịa dữ liệu.** Mọi giá trị lấy từ nguồn thật: option WP Admin, CPT `dgc_gia`, CSDL
   bài viết, hồ sơ user. Không có dữ liệu thật -> bỏ trường đó, không đoán.
3. **Không emit `Review` / `AggregateRating`** - testimonial hiện là nội dung mẫu, chưa phải
   đánh giá thật có danh tính. Emit = dữ liệu sai sự thật + vi phạm policy Google.
   Khi nào có đánh giá thật (tên khách, nội dung khách viết) mới bật.
4. **Schema phải khớp nội dung NGƯỜI ĐỌC NHÌN THẤY.** FAQ chỉ được đưa vào FAQPage nếu câu hỏi
   thật sự hiển thị trong bài (đợt migrate 2026-07-27 đã loại 15 câu vi phạm điều này).

## Bản đồ node theo loại trang

| Loại trang | Node chính |
|---|---|
| Mọi trang | `Organization`+`ProfessionalService` (#organization), `WebSite` (#website), `WebPage` (#webpage), `BreadcrumbList` |
| Trang chủ | WebPage + `FAQPage`, `about` -> Organization |
| Trang dịch vụ pillar | `Service` (#service) + `AggregateOffer` (giá thật min/max từ `dgc_gia`) |
| Trang ngách con (vd /dich-vu-backlink/bat-dong-san/) | `Service` không kèm giá + `isRelatedTo` -> service cha |
| Bài viết / case study | `Article`(+`BlogPosting`), `about` -> Service của cụm (nếu cụm có money page) |
| /blog/, chuyên mục, /bang-gia/ | `CollectionPage` + `ItemList` |
| /lien-he/, /ve-digicom/ | `ContactPage` / `AboutPage`, `mainEntity` -> Organization |
| /author/... | `ProfilePage` + `Person` |
| /cam-on/ | KHÔNG có schema (trang noindex) |

## Cạm bẫy đã dính (đừng lặp lại)

- **`get_the_author_meta('ID')` LUÔN rỗng ở `wp_head`** - hàm đó đọc global `$authordata` chỉ
  được set trong vòng lặp `the_post()`. Dùng `get_post_field('post_author', get_the_ID())`.
  Sai chỗ này = `Article` mất `author` (thuộc tính bắt buộc của rich result) mà không báo lỗi gì.
- **`inLanguage` KHÔNG hợp lệ trên `Organization`** (chỉ dành cho CreativeWork) -
  validator.schema.org báo UNKNOWN_FIELD.
- **`dgc_case` có `post_author = 0`** (tạo bằng script) -> fallback `author` về Organization,
  KHÔNG gán bừa tên cá nhân.
- **Tên chuyên mục chứa `&`** -> phải chạy qua `dgc_sch_txt()` để giải mã entity, nếu không
  `keywords` sẽ ra `Backlink &amp; Off-page`.

## Sửa nội dung schema ở đâu (không chạm code)

| Muốn đổi | Sửa ở |
|---|---|
| Tên/địa chỉ/hotline/email/giờ làm việc/Facebook/Zalo | WP Admin > DigicomVN |
| FAQ trang chủ | option `faqs` |
| FAQ từng trang dịch vụ | option `svc_faqs` |
| FAQ từng bài viết | Meta box **"FAQ cho schema"** ngay dưới trình soạn thảo bài |
| Khoảng giá dịch vụ | Sửa CPT Bảng giá - schema tự tính lại (cache 12h, tự xoá khi lưu dòng giá) |
| Hồ sơ tác giả (chức danh, tiểu sử, chuyên môn, bằng cấp, social) | WP Admin > Thành viên > Hồ sơ |

## QA bắt buộc sau mỗi lần sửa schema

1. `php -l inc/schema.php` (lint trên host, máy Hiếu không có PHP).
2. Quét toàn site: `tools/schema-qa.py` - kiểm mỗi URL đúng 1 khối JSON-LD, JSON parse được,
   đủ thuộc tính bắt buộc, không có trường rỗng.
3. Kiểm định độc lập bằng `validator.schema.org` (script `tools/schema-validate.py`) cho tối
   thiểu 6 loại trang: chủ, dịch vụ, bài viết, blog, tác giả, bảng giá. **Mục tiêu: 0 lỗi, 0 cảnh báo.**
4. Sửa CSS/JS kèm theo -> vẫn phải bump `DGC_VER` (xem `deploy.md`). Sửa riêng PHP thì không cần.

## Liên quan
- `deploy.md` - quy trình đẩy file lên live + purge cache.
- `khong-ban-gov-edu.md`, `content-professional.md` (global) - không claim thứ không verify được.
