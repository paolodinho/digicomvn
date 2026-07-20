# Trang tác giả /author/ - landing xây tên tuổi, KHÔNG chặn index (chốt 2026-07-20)

> Hiếu: "t muốn xây dựng tên tuổi, không chặn được" - trang tác giả phải index,
> nên phải làm cho nó KHÁC hẳn /blog/ thay vì noindex cho xong.

## Nguyên tắc
Trang `/author/<nicename>/` là **landing giới thiệu cá nhân** (E-E-A-T), không phải
danh sách bài. Nếu chỉ liệt kê toàn bộ bài viết thì trùng lặp với `/blog/` và trang
chuyên mục -> Google coi là bản sao, không giúp xây thương hiệu cá nhân.

## Cấu trúc bắt buộc (template `author.php`)
1. Hero: ảnh chân dung thật, tên, chức danh, câu định vị, liên kết mạng xã hội + hotline.
2. Dải số liệu **đếm tự động từ CSDL** (số bài, số cụm chủ đề, số năm nghề nếu có khai năm bắt đầu) - không nhập tay, không bịa.
3. "Về <tên>": tiểu sử ngắn (ô Tiểu sử của WordPress) + tiểu sử dài (`dgc_bio_long`).
4. Mảng chuyên môn (`dgc_expertise`, mỗi dòng `Tên|Mô tả`). Trống thì tự lấy theo cụm chủ đề.
5. Hành trình / cột mốc (`dgc_milestones`, mỗi dòng `Năm|Nội dung`). Trống thì ẩn cả mục.
6. Bài viết tiêu biểu: **tối đa 6 bài** (`dgc_featured_posts`, ID hoặc slug). Trống thì tự lấy bài mới nhất mỗi cụm.
7. Chip cụm chủ đề dẫn sang trang chuyên mục + "Tất cả bài viết" dẫn về `/blog/`.
8. Schema `Person` đầy đủ: jobTitle, worksFor, image, knowsAbout, sameAs.

## Bắt buộc
- Mọi nội dung sửa được ở **WP Admin > Thành viên > Hồ sơ** (rule wordpress-non-code-editable).
- KHÔNG bịa số năm kinh nghiệm, cột mốc, giải thưởng. Trống thì ẩn mục đó.
- KHÔNG phân trang (`/author/x/page/N/` đã 301 về bản gốc trong `functions.php`).

## Việc còn lại của Hiếu
Điền ảnh chân dung thật (`dgc_avatar_id`), năm bắt đầu nghề, các cột mốc thật khác.
