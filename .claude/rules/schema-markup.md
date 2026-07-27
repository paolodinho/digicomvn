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
| Bài có `[dgc_bang_gia]` (18 bài đầu báo) | + `Service` + `Offer` **giá thật của đầu báo đó**; `Article.about` trỏ về Service này |
| Trang lưu trữ phân trang | `@id`/`url` riêng theo `/page/N/` |
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
- **`inLanguage` cũng KHÔNG hợp lệ trên `EntryPoint`** (target của OrderAction/SearchAction).
  Đây là lỗi lặp lại lần 2 của cùng một thói quen "gắn inLanguage cho mọi node" -> luôn chạy
  `tools/schema-vocab-check.py` sau khi thêm bất kỳ thuộc tính mới nào.
- **Trang phân trang `/category/x/page/2/`** phải có `@id`/`url` RIÊNG (dùng `dgc_sch_url_paged()`).
  Dùng chung với trang 1 = hai trang nội dung khác nhau cùng khai là một thực thể.
- **Bài không có ảnh đại diện** vẫn phải có `Article.image` -> lấy ảnh đầu tiên trong thân bài,
  nhớ bỏ hậu tố `-WxH` để `attachment_url_to_postid()` tra được bản gốc (có width/height).

## Sửa nội dung schema ở đâu (không chạm code)

| Muốn đổi | Sửa ở |
|---|---|
| Tên/địa chỉ/hotline/email/giờ làm việc/Facebook/Zalo | WP Admin > DigicomVN |
| FAQ trang chủ | option `faqs` |
| FAQ từng trang dịch vụ | option `svc_faqs` |
| FAQ từng bài viết | Meta box **"SEO & Schema"** ngay dưới trình soạn thảo bài |
| Giá từng đầu báo trong bài | Shortcode `[dgc_bang_gia bao="..." domain="..."]` - schema tự sinh Offer khớp đúng bảng hiển thị |
| Khoảng giá dịch vụ | Sửa CPT Bảng giá - schema tự tính lại (cache 12h, tự xoá khi lưu dòng giá) |
| Hồ sơ tác giả (chức danh, tiểu sử, chuyên môn, bằng cấp, social) | WP Admin > Thành viên > Hồ sơ |

## QA bắt buộc sau mỗi lần sửa schema

1. `php -l inc/schema.php` (lint trên host, máy Hiếu không có PHP).
2. Quét toàn site: `tools/schema-qa.py` (**tối đa 3 luồng - chạy 6 luồng hoặc 2 script song song làm host quá tải, sinh HTTP 500 rải rác và báo lỗi giả**) - kiểm mỗi URL đúng 1 khối JSON-LD, JSON parse được,
   đủ thuộc tính bắt buộc, không có trường rỗng.
3. **`python3 tools/schema-vocab-check.py`** - kiểm TOÀN SITE theo từ vựng schema.org chính thức:
   mọi `@type` có thật, mọi thuộc tính có thật và đúng `domainIncludes` của kiểu node đó.
   Đây là bộ bắt lỗi chính (đã bắt được cả 2 lỗi `inLanguage`). **Mục tiêu: 0 lỗi.**
4. **`python3 tools/schema-google-check.py`** - kiểm thuộc tính BẮT BUỘC theo tài liệu Google cho
   từng loại rich result (Organization/LocalBusiness, Article, BreadcrumbList, FAQPage,
   ProfilePage, Offer/AggregateOffer, SearchAction) + **tham chiếu `@id` không được treo**
   (trỏ sang trang khác thì trang đó phải tồn tại thật). **Mục tiêu: 0 lỗi.**
5. Kiểm định chéo bằng `validator.schema.org` (script `tools/schema-validate.py`) khi cần.
   **Lưu ý: API này chặn 429 rất sớm (~10-15 lượt/giờ) và block kéo dài** - chỉ dùng đối chiếu
   vài trang mẫu, KHÔNG dùng quét cả site (đó là việc của bước 3+4). Bộ 3 script tự kiểm phủ
   rộng hơn (toàn site) nhưng không sao chép 100% bộ parser của Google - khi có nghi ngờ về
   một loại rich result cụ thể thì vẫn nên soi lại bằng Rich Results Test thủ công.
6. Sửa CSS/JS kèm theo -> vẫn phải bump `DGC_VER` (xem `deploy.md`). Sửa riêng PHP thì không cần.

## Liên quan
- `deploy.md` - quy trình đẩy file lên live + purge cache.
- `khong-ban-gov-edu.md`, `content-professional.md` (global) - không claim thứ không verify được.
