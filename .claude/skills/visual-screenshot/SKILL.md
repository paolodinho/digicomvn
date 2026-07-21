---
name: visual-screenshot
description: >
  Tạo ảnh "dạng chụp màn hình" (dashboard, bảng phân tích, báo cáo công cụ) cho digicomvn.com:
  dựng HTML theo design token Digicom -> render Chrome headless -> webp nhẹ, sắc nét -> upload WP
  -> chèn vào bài. Dùng khi bài cần minh hoạ thao tác/kết quả kiểm tra (Ahrefs/Semrush/GSC), bảng
  số liệu, dashboard, "trước/sau"... thay cho ảnh minh hoạ trang trí. Trigger: "làm ảnh chụp màn
  hình", "ảnh dashboard", "ảnh này lỗi làm lại", "bài cần thêm ảnh screenshot".
---

# Visual Screenshot - ảnh dạng chụp màn hình cho digicomvn.com

> Bối cảnh: site cần NHIỀU ảnh dạng chụp màn hình để tăng độ tin cậy/chuyên nghiệp (Hiếu 2026-07-21).
> Sự cố gốc: bài anchor text từng để 1 ảnh chụp Ahrefs landing form trống (chưa bấm check) nhưng
> caption ghi "dữ liệu thật" -> vừa vô nghĩa vừa sai sự thật. Skill này chuẩn hoá cách làm ĐÚNG.

## Nguyên tắc bất di bất dịch (đọc trước khi làm)

1. **KHÔNG giả mạo UI công cụ bên thứ ba rồi caption là "dữ liệu thật".** Không dựng lại giao diện
   Ahrefs/Semrush và gán số như thể chụp thật. Vi phạm `content-professional.md` + rủi ro pháp lý/uy tín.
2. **Chỉ 2 nguồn ảnh hợp lệ:**
   - **(A) Chụp thật dữ liệu thật**: mở công cụ FREE thật (Ahrefs free checker, GSC, PageSpeed...) bằng
     trình duyệt, CHECK thật 1 domain, chụp kết quả thật. Caption ghi đúng domain + ngày.
     ⚠️ KHÔNG vượt CAPTCHA/Cloudflare bot-check (rule an toàn) - gặp là dừng, chuyển sang (B).
   - **(B) Dashboard/báo cáo TỰ DỰNG của Digicom** (mặc định, khuyến nghị): HTML mang thương hiệu
     Digicom, KHÔNG đội lốt tool khác. Nếu dùng số ví dụ -> BẮT BUỘC gắn nhãn **"MẪU MINH HOẠ"** +
     footer "Số liệu trong bảng là ví dụ minh hoạ" + dùng domain generic (`websitecuaban.vn`), KHÔNG
     bịa là số thật của 1 site cụ thể.
3. **Số/ngưỡng trong ảnh phải khớp nội dung bài + có cơ sở** (tỷ lệ, benchmark theo nguồn đã dẫn -
   Ahrefs/Moz/Google Search Central). Không tự chế con số mâu thuẫn với bài.
4. **Nhẹ trang**: ảnh cuối < ~120KB (webp). Rule page-weight trong `content-diagram-explain.md`.

## Quy trình 8 bước

### B1. Xác định chỗ cần ảnh
Quét bài tìm đoạn: mô tả thao tác trên công cụ, "cách đọc chỉ số", bảng số liệu nhiều dòng, kết quả
kiểm tra, so sánh trước/sau. Đây là nơi ảnh dạng chụp màn hình tạo giá trị (khác ảnh Storyset trang trí
ở `image-sourcing.md` - cái đó cho minh hoạ khái niệm chung).

### B2. Chọn nguồn (A) hay (B)
Ưu tiên (A) nếu có công cụ free trả dữ liệu thật SẠCH, không captcha, dữ liệu minh hoạ đúng thông điệp.
Nếu site mới/không có dữ liệu đẹp, hoặc bị bot-check -> (B). Đa số trường hợp = (B).

### B3. Dựng HTML (nguồn B)
Copy `templates/dashboard-report.html` (bảng phân tích anchor text mẫu - đã có sẵn) làm khung, sửa lại:
- Design token Digicom: teal `#0E8C7F`, xanh `#2563EB`, xám `#5B6675`, đỏ `#DC2626`, ink `#1C2035`,
  surface `#EEF2F6`/`#fff`, line `#E2E8F0`. Font `-apple-system,"Segoe UI",Roboto,Arial`.
- `body` + `.card` đặt `width` + `height` CỐ ĐỊNH = kích thước thiết kế (vd 1200x648). Nội dung phải
  vừa khít, không tràn (Chrome chỉ chụp đúng window-size, tràn sẽ bị cắt).
- Có: tiêu đề + phụ đề, hàng stat-card, bảng/biểu đồ bằng `<div>` bar (KHÔNG SVG), khối nhận định,
  footer nguồn + "Digicom · ngày". Nếu số ví dụ: thêm badge **MẪU MINH HOẠ** (vàng `#FEF3C7`/`#92400E`).
- KHÔNG dùng em/en dash (`typography-dash.md`) - chỉ `-`.

### B4. Render
```bash
./render.sh <input.html> <out_basename> <width> <height>
# vd: ./render.sh anchor-report.html anchor-report 1200 648
```
Ra `<out_basename>.webp` (1600px, ~80KB) + `<out_basename>@2x.png` (2400px, để QA). Cần Chrome + cwebp.

### B5. QA ảnh (BẮT BUỘC xem bằng mắt)
Đọc file `@2x.png` bằng Read tool. Kiểm: chữ không tràn/cắt, bar đúng tỷ lệ, không khoảng trắng thừa
lớn (chỉnh `height` render lại), có nhãn MẪU MINH HOẠ nếu là số ví dụ, không lỗi dấu tiếng Việt.

### B6. Upload WP + backup
```bash
scp -P 65002 -i ~/.ssh/id_ed25519 <out>.webp u704250056@145.79.26.63:/tmp/<out>.webp
ssh ... 'cd domains/digicomvn.com/public_html && wp media import /tmp/<out>.webp \
  --title="..." --alt="<mô tả có từ khoá>" --porcelain --allow-root'   # -> ATTACH_ID
ssh ... 'wp eval "echo wp_get_attachment_url(<ID>);" --allow-root'      # -> URL
```
Backup content bài TRƯỚC khi sửa: `wp post get <ID> --field=content` -> lưu
`~/Claude-Workspace/_backups/routines/<ngày>/<task>/` (rule `routine-backup.md`).

### B7. Chèn khối ảnh vào bài
Block Gutenberg chuẩn (thay `<ID>`/URL/alt/caption):
```html
<!-- wp:image {"id":<ID>,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="<URL>.webp" alt="<mô tả>" class="wp-image-<ID>" /><figcaption class="wp-element-caption"><caption trung thực - nếu số ví dụ ghi rõ "ví dụ minh hoạ"></figcaption></figure>
<!-- /wp:image -->
```
Đặt NGAY SAU đoạn text/danh sách liên quan. Update: `wp post update <postID> file.html` rồi
`wp cache flush && wp litespeed-purge all`.

### B8. Verify live
```bash
curl -s "<URL bài>" | grep -o '<out>.webp' | head   # ảnh đã lên
curl -s -o /dev/null -w "%{http_code} %{size_download}\n" "<URL .webp>"   # 200 + KB hợp lý
```

## Tài sản trong skill
- `render.sh` - pipeline render (Chrome headless 2x -> resize 1600 -> webp q88).
- `templates/dashboard-report.html` - khung bảng phân tích (anchor text mẫu), sửa lại cho chủ đề khác.

## Liên quan
- `content-diagram-explain.md` - sơ đồ HTML giải thích trong bài (bổ trợ, cùng ngôn ngữ thiết kế).
- `image-sourcing.md` - ảnh minh hoạ khái niệm (Storyset) - KHÁC loại với ảnh screenshot ở đây.
- `content-professional.md`, `external-link-eeat.md` (global) - không bịa số, dẫn nguồn benchmark.
- `deploy.md` - lưu ý cache-busting nếu ảnh dùng trong file theme (bài viết thì không cần).
