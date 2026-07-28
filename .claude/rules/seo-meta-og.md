# Meta SEO + Open Graph - tự sinh trong theme, KHÔNG dùng plugin (chốt 2026-07-27)

> File nguồn: `wp-theme/digicom-host/inc/seo-meta.php`. Site không cài Rank Math/Yoast -
> mọi thẻ meta do theme tự sinh. Sửa schema thì xem `schema-markup.md`.

## Bối cảnh

Trước 2026-07-27 toàn site **không có `<meta name="description">`, không có og:/twitter: tag
nào**, và trang lưu trữ (blog, chuyên mục, phân trang) **không có canonical** (WP core chỉ tự
sinh canonical cho trang đơn). Hệ quả: share Facebook/Zalo ra thẻ trắng, Google tự bịa đoạn mô tả.

## Theme sinh những gì

| Thẻ | Áp dụng | Nguồn dữ liệu |
|---|---|---|
| `meta description` | Mọi trang | meta `dgc_seo_desc` -> excerpt -> đầu nội dung bài -> option (trang chủ) -> mô tả chuyên mục -> tiểu sử tác giả |
| `og:` đầy đủ (locale, type, site_name, title, url, description, image + w/h/alt) | Mọi trang | như trên; ảnh: ảnh đại diện -> ảnh đầu tiên trong bài -> option `og_image` -> logo |
| `article:published_time` / `modified_time` / `section` | Bài viết + case study | CSDL |
| `twitter:card` (summary_large_image), title, description, image | Mọi trang | như trên |
| `canonical` | **Chỉ trang lưu trữ** (WP đã tự lo trang đơn) | `dgc_sch_url_paged()` |
| `robots: noindex,follow` | Trang tìm kiếm + 404 | - |
| `<title>` riêng từng bài | Bài/trang có meta `dgc_seo_title` | WP Admin |

## Sửa ở đâu (không chạm code)

| Muốn đổi | Sửa ở |
|---|---|
| Tiêu đề SEO + mô tả SEO của 1 bài/trang | Ô **"SEO & Schema"** ngay dưới trình soạn thảo |
| Mô tả SEO trang chủ | WP Admin > DigicomVN > mục 0 (`meta_desc_home`) |
| Ảnh chia sẻ mặc định | WP Admin > DigicomVN > mục 0 (`og_image`) - nhận **ID ảnh hoặc URL** |
| Mô tả chuyên mục | Sửa mô tả category |

## Cạm bẫy đã dính

- **Trang chủ là một PAGE tĩnh nên `is_singular()` cũng đúng.** Phải xét `is_front_page()`
  TRƯỚC, nếu không sẽ rơi vào nhánh bài viết, đọc nội dung page trống và trả mô tả rỗng.
- **URL ảnh trong bài là bản resize** (`...-1024x671.jpg`) -> `attachment_url_to_postid()`
  không nhận ra -> mất `og:image:width/height`. Phải bỏ hậu tố `-WxH` trước khi tra.
- **Trang dùng template PHP** (`/bang-gia/`, `/lien-he/`, `/ve-digicom/`) có `post_content`
  rỗng -> không tự sinh được mô tả. Đã điền `dgc_seo_desc` thủ công theo đúng đoạn lead hiển
  thị trên trang. **Tạo trang template mới -> nhớ điền ô "Mô tả SEO"**, nếu không sẽ thiếu.
- **KHÔNG dùng file `ogimagedn.jpg` ở thư mục gốc dự án làm ảnh OG** - đó là logo Báo Đà Nẵng
  (ảnh tư liệu), không phải của Digicom. Dùng sẽ là mạo nhận thương hiệu báo khác.

## Ảnh OG mặc định (xong 2026-07-28)

Đã dựng ảnh cover riêng 1200x630 (logo thật + nền brand navy/action/teal, blend-mode
`screen` để ẩn khung nền glow sẵn có của logo, không lộ viền chữ nhật) thay cho fallback
logo 1278x363 (từng bị viền trên dưới khi share). Attachment ID **4768**
(`wp-content/uploads/2026/07/og-cover-digicomvn.jpg`), đã set vào option `dgc_settings['og_image']`
qua `wp eval` merge (không đụng field khác). Muốn đổi lại -> WP Admin > DigicomVN > mục 0
(nhận ID ảnh hoặc URL) hoặc thay ảnh mới rồi `wp media import` + update lại field này.
Backup giá trị `og_image` trước khi sửa (rỗng): `~/Claude-Workspace/_backups/routines/2026-07-28/og-image-home/dgc_settings-before.json`.

## QA bắt buộc sau khi sửa

`python3 tools/meta-qa.py` - quét toàn sitemap, kiểm mọi URL có description đủ dài, đủ og:/twitter:,
đúng 1 canonical trỏ chính nó. **Mục tiêu: 0 lỗi.**
