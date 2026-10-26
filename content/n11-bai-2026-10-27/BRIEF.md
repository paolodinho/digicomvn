# Brief viết bài N11 (26/10/2026) - digicomvn.com

Bạn viết 1 bài blog tiếng Việt cho digicomvn.com (đơn vị booking báo & PR, guest post, textlink, backlink - Công ty TNHH DVTT Digito Combat, hotline 0988 769 317).
KHÔNG đăng gì lên site, KHÔNG gọi REST ghi, KHÔNG upload ảnh. Chỉ ghi file vào thư mục này. Phiên điều phối sẽ QA, upload ảnh và hẹn giờ đăng.

## Đọc trước (bắt buộc)
- `/Volumes/Extreme SSD/Projects/digicom/.claude/rules/do-dont.md`, `content-visual-coverage.md`, `content-diagram-explain.md`, `external-link-eeat.md`, `word-count-minimum.md`, `mobile-responsive-content.md`, `image-sourcing.md`
- `~/.claude/rules/content-seo-2026-nguoi-viet.md`, `content-van-xuoi-bang-bullet.md`, `faq-cau-hoi-the-heading.md`, `khong-link-doi-thu.md`, `content-professional.md`, `typography-dash.md`
- Bài mẫu định dạng: `curl -s -A Mozilla "https://digicomvn.com/wp-json/wp/v2/posts/7005?_fields=content" ` (đọc content.rendered để bắt chước khối Tóm tắt nhanh, card dl-card, bảng dgc-data-table, figure ảnh)
- Dữ liệu SERP top 10 đã đo ẩn danh 24/10: `serp-<MÃ>.json` cùng thư mục (dạng trang, tiêu đề, snippet, PAA, AI Overview).

## Quy trình
1. Đọc serp-<MÃ>.json. WebFetch 3-4 trang top (bài viết thật, không phải Studocu/Scribd nếu không đọc được) để biết họ phủ khía cạnh nào. Ghi gap.
2. Dàn bài: phủ đủ khía cạnh top 10 + 2-3 điểm info gain thật (quy trình thực tế từ góc nhìn đơn vị làm báo chí, checklist, mốc thời gian, số liệu có nguồn chính thống). Trả lời trực diện ở đầu mỗi mục.
3. Viết HTML Gutenberg (comment `<!-- wp:... -->` như bài mẫu):
   - Bắt đầu bằng đúng 1 `<h1>`, rồi đoạn sapo, khối "Tóm tắt nhanh", rồi các H2.
   - >= 1600 từ thân bài, đoạn <= 130 từ, văn xuôi là chính. Bảng chỉ khi so sánh (1-2 bảng). Bullet chỉ cho danh sách thật.
   - Mọi H2 có 1 yếu tố trực quan: bảng `dgc-data-table` (data-label mọi td + caption ẩn), card `<ol>/<ul>` chứa `<dl class="dl-card">`, hoặc ảnh. Dãy bước có thứ tự dùng `<ol>`.
   - Ảnh: làm 2 infographic bằng skill visual-screenshot (`/Volumes/Extreme SSD/Projects/digicom/.claude/skills/visual-screenshot/` - template `templates/infographic-base.html`, render `./render.sh in.html out 1200 675`; xem file @2x.png sau khi render). Lưu .webp vào thư mục này, tên `ig-<slug>-<chu-de>.webp`. Trong HTML đặt chỗ ảnh bằng dòng: `<!--IMG:ig-<slug>-<chu-de>.webp|alt mô tả|chú thích ngắn-->`. Số liệu trong ảnh phải thật hoặc gắn badge "MẪU MINH HOẠ".
   - FAQ: H2 "Câu hỏi thường gặp", mỗi câu H3, trả lời 40-60 từ ngay dưới. Lấy câu hỏi từ PAA/AI Overview/Suggest.
   - Cuối bài: H2 "Tài liệu tham khảo" (danh sách tên tài liệu + link nguồn chính thống: luật, cơ quan nhà nước, tổ chức quốc tế; KHÔNG link đối thủ agency/dịch vụ; trong thân bài không gắn link nguồn).
   - Link nội bộ: tối đa 5, mỗi link 1 URL khác nhau, anchor khác nhau, có ít nhất 1 money page (`https://digicomvn.com/booking-bao-pr/` hoặc trang đặt bài `https://digicomvn.com/dat-bai/`). Chọn từ danh sách gợi ý trong mục MÃ bên dưới.
   - KHÔNG em dash/en dash, KHÔNG nêu tên/link đối thủ, KHÔNG bịa số liệu, KHÔNG bịa case study/khách hàng/lời khách. Không viết "Digicom đã làm cho khách X". Không cam kết kết quả.
   - Không chèn shortcode, không script, không SVG.
4. Ghi 2 file: `<slug>.html` và `<slug>.json` = {title (<=58 ký tự, chứa từ khoá chính), slug, meta_desc (140-160 ký tự), excerpt, tu_khoa_chinh, tu_khoa_phu[], intent, gap_doi_thu[], info_gain[], nguon[], link_noi_bo[], so_tu}.
5. Tự QA: đếm từ, đúng 1 h1, không "—"/"–", mỗi H2 có trực quan, link nội bộ <=5. Báo lại 5 dòng: file, số từ, info gain, nguồn.

## MÃ C - Kịch bản họp báo xử lý khủng hoảng truyền thông
- Từ khoá: "họp báo xử lý khủng hoảng" (90/tháng), "kịch bản họp báo xử lý khủng hoảng" (20), "họp báo xử lý khủng hoảng truyền thông". Top 10 đa số là tài liệu sinh viên (Studocu, Scribd, PDF) + vài bài hướng dẫn: người tìm muốn KỊCH BẢN/mẫu + quy trình tổ chức họp báo khi khủng hoảng.
- Gợi ý slug: `hop-bao-xu-ly-khung-hoang`. Dạng: hướng dẫn + kịch bản mẫu theo phân đoạn (trước họp báo, mở đầu, phát ngôn, hỏi đáp, kết thúc, sau họp báo), câu hỏi khó phóng viên hay hỏi + cách trả lời, checklist. Có thể nêu căn cứ pháp lý về họp báo (Luật Báo chí 2016 Điều 41 họp báo, Nghị định 09/2017/NĐ-CP về phát ngôn và cung cấp thông tin cho báo chí) - kiểm lại nội dung điều luật trước khi viết.
- Link nội bộ gợi ý: `https://digicomvn.com/thong-cao-bao-chi-xu-ly-khung-hoang/` (bài anh em - thông cáo, KHÔNG lặp nội dung của nó), `https://digicomvn.com/booking-bao-pr/`, `https://digicomvn.com/dat-bai/`, `https://digicomvn.com/thong-cao-bao-chi-la-gi/`.

## MÃ F - Thông cáo báo chí ra mắt MV
- Từ khoá: "thông cáo báo chí ra mắt mv" (50/tháng). Top 10: bài thực hành sinh viên (Studocu), bài báo đưa tin ra mắt MV, 1 trang mẫu thông cáo. Người tìm muốn MẪU thông cáo ra mắt MV + cách viết.
- Gợi ý slug: `thong-cao-bao-chi-ra-mat-mv`. Dạng: mẫu hoàn chỉnh (nghệ sĩ/tên MV để trống dạng [Tên nghệ sĩ]), cấu trúc từng phần, thông tin phải có (credit ê-kíp, link phát hành, thời điểm, hình ảnh/teaser, bản quyền), mốc thời gian gửi báo trước/sau ngày phát hành, khác nhau giữa thông cáo và bài PR đăng báo. Có thể nêu lưu ý bản quyền âm nhạc (Luật Sở hữu trí tuệ) và phổ biến/cấp phép nếu có căn cứ - kiểm lại trước khi viết.
- Link nội bộ gợi ý: `https://digicomvn.com/mau-thong-cao-bao-chi/`, `https://digicomvn.com/cach-viet-thong-cao-bao-chi-chuan/`, `https://digicomvn.com/booking-bao-pr/`, `https://digicomvn.com/dat-bai/`.

## MÃ D - Các hình thức quảng cáo trên báo điện tử
- Từ khoá: "quảng cáo trên báo điện tử" (30/tháng), "quảng cáo banner trên báo điện tử". Top 10: 7/9 bài viết liệt kê các hình thức (banner, bài PR, native, video, popup...), 1 rate card báo. Người tìm muốn biết có những hình thức nào, ưu nhược, cách tính giá, chọn hình thức nào.
- Gợi ý slug: `quang-cao-tren-bao-dien-tu`. Dạng: danh sách các hình thức (toplist có số trong title nếu danh sách là trọng tâm) + bảng so sánh (cách tính giá CPM/CPD/theo bài, mục tiêu phù hợp, giá trị SEO) + cách chọn + quy định pháp luật (Luật Quảng cáo, phân biệt tin bài và quảng cáo, nhãn "quảng cáo"/"PR") - kiểm lại văn bản luật hiện hành (Luật Quảng cáo 2012 và luật sửa đổi 2025 nếu có) trước khi viết.
- KHÔNG lặp bài `https://digicomvn.com/so-sanh-booking-bao-pr-va-quang-cao-bao/` (bài đó so sánh booking PR với quảng cáo báo): link sang nó, không viết lại các tiêu chí so sánh. Digicom không bán banner: không nhận là mình bán banner, dẫn về booking báo PR.
- Link nội bộ gợi ý: bài so sánh ở trên, `https://digicomvn.com/booking-bao-pr/`, `https://digicomvn.com/dat-bai/`, `https://digicomvn.com/guest-post/`.
