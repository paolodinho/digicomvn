# Brief viết lại nội dung trang dịch vụ digicomvn.com (2026-10-13)

Hiếu: "ok hơn rồi, đa dạng cách trình bày, lắm thẻ quá, nhiều sao cho đầy đặn nội dung, research thêm đối thủ".

## Đầu vào bắt buộc đọc
- Research đối thủ: `/Volumes/Extreme SSD/Projects/digicom/content/research-trang-dich-vu-doi-thu-2026-10-13.md` (mục d có gợi ý mục riêng từng dịch vụ, mục b là khoảng trống info gain).
- Rule dự án: `.claude/rules/khong-ban-gov-edu.md`, `external-link-eeat.md`, `content-diagram-explain.md`, `mobile-responsive-content.md`, `do-dont.md`, `bang-gia-booking.md` (chỉ để hiểu dữ liệu, KHÔNG đưa giá vốn/tên NCC lên trang).

## Trang đã có gì (do template PHP tự render, KHÔNG viết lại trong post_content)
Hero (tên dịch vụ, số liệu), dải 4 cam kết, khối "X là gì" (option svc_intros), BẢNG GIÁ lọc được (#bang-gia), hướng dẫn đặt 4 bước, FAQ riêng (option svc_faqs), form báo giá, CTA. post_content nằm SAU hướng dẫn đặt hàng, TRƯỚC FAQ. Vì vậy post_content KHÔNG lặp lại: định nghĩa ngắn, quy trình đặt 4 bước, FAQ, form.

## Viết gì
- post_content mới >= 1.500 từ phần chữ (mục tiêu 1.800-2.500), 6-9 H2 RIÊNG cho dịch vụ đó theo gợi ý mục d + khoảng trống mục b.
- Mỗi H2 mở bằng câu trả lời trực diện. Văn biên tập chuyên nghiệp, tiếng Việt có dấu đủ.
- GIỮ NGUYÊN mục "Tài liệu tham khảo" hiện có ở cuối (copy lại nguyên khối, có thể bổ sung nguồn thật đã verify).
- Số liệu: chỉ dùng số THẬT. Lấy từ dữ liệu bảng giá live qua SSH (xem dưới) - ví dụ số site, khoảng giá, DR thấp/cao, số vị trí theo loại. Số liệu ngoài phải có nguồn verify (link `rel="nofollow noopener" target="_blank"` nếu là trích dẫn cá nhân/bên thứ 3; tài liệu Google/luật thì `rel="noopener"`). Không có nguồn thì không ghi số.
- KHÔNG: nêu tên/link đối thủ; bịa case study/khách hàng/testimonial; hứa thứ hạng; nhắc bán backlink .gov/.edu (nếu nhắc thì nói rõ là vi phạm pháp luật, Digicom không làm); em dash/en dash (chỉ dùng "-"); emoji; giá vốn, tên nhà cung cấp, công thức markup.
- Thuật ngữ: không dùng "bài chuẩn SEO" (dùng "viết bài PR", "nội dung chuẩn SEO/GEO").

## Trình bày: ĐA DẠNG, ÍT THẺ
Theme đã có sẵn class (CSS trong main.css khối LAYOUT KIT), dùng thẳng trong post_content HTML (không Gutenberg comment phức tạp, HTML thuần là được):
- `<div class="dgc-split">` 2 cột (chữ | bảng/sơ đồ/checklist), thêm `rev` để đảo trái phải. Cột phụ có thể bọc `<div class="dgc-panel">`.
- `<ol class="dgc-tl">` dòng thời gian dọc, mỗi `<li><b>Tiêu đề</b> mô tả</li>`.
- `<div class="dgc-stat"><div><b>số</b><span>nhãn</span></div>...</div>` dải số lớn nền navy (CHỈ số thật).
- `<div class="dgc-dd"><div><h3>Nên</h3><ul>..</ul></div><div><h3>Không nên</h3><ul>..</ul></div></div>`.
- `<ul class="dgc-check">` checklist 2 cột.
- `<blockquote class="dgc-quote">câu chốt<cite>nguồn nếu là trích dẫn</cite></blockquote>` (không bịa lời người thật).
- `<div class="dgc-sticky"><div><h2>..</h2><p>..</p></div><div>nội dung dài</div></div>` tiêu đề dính trái.
- `<div class="dgc-rows"><div><b>Nhãn</b><div>nội dung</div></div>...</div>` hàng kẻ ngang (tiêu chí, bàn giao...).
- Bảng: `<figure class="wp-block-table dgc-data-table"><table>...` có `data-label` trên mọi `<td>`, `<caption>` ẩn.
- Mỗi H2 có ít nhất 1 yếu tố trực quan; KHÔNG dùng 2 kiểu giống nhau liền kề; tối đa 1 lưới thẻ cả trang (tốt nhất 0).
- `<h2>` có `id` dạng slug không dấu. Không chèn shortcode/link trong heading.
- Mọi `width:Npx` inline phải kèm `max-width:100%`. Không `<table>` trần.
- Internal link: 3-6 link tới trang dịch vụ khác / bài blog liên quan có thật (kiểm bằng curl 200).

## Lấy dữ liệu thật
```bash
ssh -p 65002 -i ~/.ssh/id_ed25519 u704250056@145.79.26.63 "cd domains/digicomvn.com/public_html && wp eval 'foreach(dgc_get_gia(\"<nhom-slug>\") as \$it){ echo \$it->post_title.\"|\".\$it->meta[\"vi_tri\"].\"|\".\$it->meta[\"gia_km\"].\"|\".\$it->meta[\"dr\"].\"|\".\$it->meta[\"so_link\"].\"|\".\$it->meta[\"yeu_cau\"].\"\n\";}' --allow-root"
```
Chỉ đọc, KHÔNG sửa DB.

## Quy trình ghi
1. Backup: `python3 tools/wp-rest-publish.py get-raw --id <ID> --post-type pages > ~/Claude-Workspace/_backups/routines/2026-10-13/svc-v2-content/<slug>-BEFORE.json` (tạo thư mục). Không backup được -> DỪNG.
2. Soạn file `content/svc-v2/<slug>.html`.
3. Tự QA trước khi đăng: đếm từ (strip tag) >= 1500; grep không có "—" "–"; cân số thẻ mở/đóng div/ol/ul/table; không tên đối thủ.
4. Đăng: `python3 tools/wp-rest-publish.py update --id <ID> --post-type pages --content-file content/svc-v2/<slug>.html` (chạy ở thư mục /Volumes/Extreme SSD/Projects/digicom).
5. Purge: `ssh -p 65002 -i ~/.ssh/id_ed25519 u704250056@145.79.26.63 "cd domains/digicomvn.com/public_html && wp litespeed-purge all --allow-root"`.
6. Verify live: curl trang, đếm H2, `python3 tools/mobile-overflow-check.py <(echo URL)` phải 0 overflow.
7. Báo cáo ngắn (tiếng Việt): URL, số từ trước/sau, danh sách H2 + kiểu trình bày từng H2, số liệu dùng và nguồn, internal link đã chèn, kết quả QA.

## BỔ SUNG đợt 2 (sau khi Hiếu xem 6 trang đầu: "bên phải trống trơn, tìm ảnh phù hợp")
- `.dgc-rows` PHẢI viết dạng `<dl class="dgc-rows"><div><dt>Nhãn</dt><dd>Mô tả</dd></div>...</dl>`, KHÔNG dùng `<div><b>..</b><div>..</div></div>` (wpautop chèn `<p>` làm vỡ lưới).
- Không để khối nào nằm nửa trái mà bỏ trống nửa phải. Dòng thời gian / checklist / hàng kẻ dài -> bọc `<div class="dgc-split dgc-media"><div>NỘI DUNG</div><figure class="dgc-fig"><img src="URL" alt="..." width="600" height="600" loading="lazy" decoding="async"></figure></div>` (thêm `rev` để ảnh sang trái, xen kẽ). Viết `<figure>...<img ...></figure>` trên 1 dòng.
- Mỗi trang tối thiểu 2 ảnh, không trùng ảnh trong trang. Dùng ảnh Storyset có sẵn: `https://digicomvn.com/wp-content/uploads/2026/08/<tên>.webp` - các tên đã kiểm (600x600 trừ ghi chú): checklist_rafiki-teal, task-cuate, creative-writing_rafiki-teal, growth-curve-cuate, data-analysis_rafiki-teal, connected-world_rafiki-teal, choose_rafiki-teal, business-risk_rafiki-teal, business-decisions_rafiki-teal, metrics-rafiki, mind-map_rafiki-teal, connecting-teams_rafiki-teal, content-structure_rafiki-teal, voice-assistant_rafiki-teal, www_rafiki-teal, google-sitemap_rafiki-teal, data-analysis_rafiki-teal, world-teal (1024x1024), 7-agreement-amico (1024x1024). Kiểm 200 trước khi dùng; xem ảnh (Read) để chắc khớp nội dung đoạn.
- Cuối trang thêm `<p class="dgc-credit">Ảnh minh hoạ: <a href="https://storyset.com" target="_blank" rel="nofollow noopener">Storyset</a>.</p>`.
- Danh sách có ý "Không..." thì tách `<ul class="dgc-check">` (Giúp được) và `<ul class="dgc-check no">` (dấu x), mỗi nhóm có `<h3 class="dgc-check-h">`.
- Mẫu đã đạt: content/svc-v2/mua-textlink.html.

## BỔ SUNG đợt 3 - INFOGRAPHIC thay Storyset (Hiếu 13/10: "ít ảnh, ảnh xấu, bố cục khó đọc, rối rắm")
Layout đã đổi (DGC_VER 3.3.0): cột đọc 1 cột 860px, `.dgc-split`/`.dgc-media` bị phẳng hoá thành xếp dọc, ảnh Storyset nhỏ trông lạc lõng. Việc đợt này:
1. Mỗi trang 4-6 infographic thương hiệu, mỗi cái minh hoạ đúng 1 H2 (số liệu/so sánh/quy trình/tiêu chí của chính H2 đó). Không trùng nội dung giữa các ảnh.
2. Mẫu: `.claude/skills/visual-screenshot/templates/infographic-base.html` (1200x675; thành phần .kpis .hbars .cols .flow .grid2 .tagrow). Copy ra scratchpad, chỉ giữ thành phần cần, nội dung phải LẤP ĐẦY khung (không để khoảng trống lớn: bars 4-7 dòng, cols 3 cột 3-4 dòng, flow 4-5 bước...). Chữ tối thiểu 14px. Không em/en dash.
3. Số liệu: chỉ số THẬT từ bảng giá live (`dgc_get_gia`, lệnh trong mục "Lấy dữ liệu thật") hoặc số đã có sẵn trong chính nội dung trang. Ví dụ không phải số thật -> thêm `<span class="badge">MẪU MINH HOẠ</span>` vào footer. Không tên đối thủ, không tên NCC, không giá vốn/markup. Không giả giao diện công cụ bên thứ ba.
4. Render: `cd .claude/skills/visual-screenshot && ./render.sh <in.html> <scratch>/<slug>-<n> 1200 675` rồi XEM file @2x.png (Read) - chữ không tràn, không đè, không trống. Sửa tới khi đẹp.
5. Upload: `scp -P 65002 -i ~/.ssh/id_ed25519 <file>.webp u704250056@145.79.26.63:/tmp/` rồi `ssh ... "cd domains/digicomvn.com/public_html && ID=\$(wp media import /tmp/<file>.webp --title='<tiêu đề>' --alt='<alt>' --porcelain --allow-root) && wp eval \"echo wp_get_attachment_url(\$ID);\" --allow-root"`. Tên file: `ig-<slug>-<chu-de>.webp`.
6. Chèn vào content/svc-v2/<slug>.html ngay sau đoạn mở của H2 tương ứng, 1 dòng:
   `<figure class="dgc-shot"><img src="URL" alt="..." width="1600" height="900" loading="lazy" decoding="async"><figcaption>chú thích ngắn có nguồn/ngày nếu là số liệu</figcaption></figure>`
   XOÁ toàn bộ `<figure class="dgc-fig">...</figure>` Storyset; bỏ wrapper `<div class="dgc-split dgc-media...">` chỉ để lại nội dung bên trong (giữ cân thẻ div). Hết Storyset thì xoá dòng `<p class="dgc-credit">`.
7. Đăng + purge + QA như "Quy trình ghi" (backup lại BEFORE với hậu tố -BEFORE-ig.json trước khi đăng). QA bắt buộc: overflow 0; chụp full trang Playwright 1440 và 390 (script scratchpad `full.py <url> <out.png> <width>`), xem ảnh, kiểm từng infographic hiển thị đúng.
