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
