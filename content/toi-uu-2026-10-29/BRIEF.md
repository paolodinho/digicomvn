# Brief tối ưu trang cũ 29/10/2026 - CHỈ CỘNG THÊM

Thư mục: `/Volumes/Extreme SSD/Projects/digicom/content/toi-uu-2026-10-29/`
Bản gốc live (post_content, lấy 29/10): `goc/<slug>.html`. KHÔNG sửa file trong `goc/`.

## Việc
Với mỗi trang được giao: tạo `<slug>.html` = TOÀN BỘ nội dung gốc giữ NGUYÊN từng byte + các khối MỚI chèn vào giữa các khối có sẵn (giữa 2 block Gutenberg / 2 thẻ cấp cao nhất). Không xoá, không sửa câu cũ, không đổi tiêu đề/H1/slug, không đổi heading cũ. Script kiểm tra sẽ so: mọi dòng gốc phải còn nguyên và đúng thứ tự - lệch là hỏng.
Kèm `<slug>.them.md`: liệt kê từng khối thêm (vị trí chèn - sau heading nào, từ khoá/PAA nó phục vụ, nguồn căn cứ nếu có số liệu/sự kiện), số từ thêm.

## Dữ liệu SERP đã đo (ẩn danh, 24-27/10)
JSONL: `/Volumes/Extreme SSD/Projects/digicom/06-keyword/serp-top10-2026-10-26/serp.csv.partial.jsonl` và `/Volumes/Extreme SSD/Projects/digicom/06-keyword/serp-kp43-2026-10-24/serp.csv.partial.jsonl` (mỗi dòng: keyword, paa, serp_titles, serp_pages có ai_overview). Grep theo từ khoá của trang để lấy PAA + tiêu đề top 10. Câu hỏi FAQ lấy từ PAA/tiêu đề thật, không tự nghĩ.

## Quy tắc nội dung (bắt buộc)
- Đọc trước: `/Volumes/Extreme SSD/Projects/digicom/.claude/rules/content-diagram-explain.md`, `external-link-eeat.md`, `khong-ban-gov-edu.md`, `mobile-responsive-content.md`.
- Mỗi H2 MỚI phải có 1 yếu tố trực quan HTML ngay dưới (card `<ol>`/`<ul>` có `list-style:none;padding:0;display:flex;flex-wrap:wrap` chứa `<li>` + `<dl class="dl-card" style="margin:0"><dt style="font-weight:700">..</dt><dd style="margin:0">..</dd></dl>`, hoặc bảng `<figure class="wp-block-table dgc-data-table"><table><caption style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0">..</caption>` với `data-label` trên MỌI td). Không ảnh mới (không upload được). Không SVG. Mọi `width:Npx` kèm `max-width:100%`.
- Không thẻ `<h3>` trong card. `<h3>` chỉ cho câu hỏi FAQ. FAQ: nếu trang đã có mục "Câu hỏi thường gặp" thì chèn câu mới VÀO CUỐI mục đó theo đúng định dạng câu hỏi đang dùng ở mục đó (nếu mục cũ dùng H3 thì H3; nếu dùng `<dl>`/strong thì dùng H3 cho câu mới vẫn được). Chưa có mục FAQ thì thêm H2 "Câu hỏi thường gặp" trước phần tài liệu tham khảo/kết bài, mỗi câu là H3, trả lời ngay dưới 40-60 từ, câu đầu trả lời thẳng.
- Định nghĩa đặt đầu bài (khi được yêu cầu): 1 đoạn `<p>` 40-60 từ trả lời thẳng "X là gì", chèn ngay sau khối Tóm tắt nhanh / đoạn mở đầu đầu tiên, trước H2 đầu tiên.
- Block Gutenberg: bọc khối mới bằng comment như nội dung xung quanh nếu nội dung gốc dùng `<!-- wp:... -->`; nếu gốc là HTML trần thì viết HTML trần.
- Không em dash "—", không en dash "–" (dùng "-"). Không nêu tên/link agency đối thủ. Không giá vốn, không tên nhà cung cấp (cấm tuyệt đối "P.A Việt Nam", "pavietnam", "DanaSEO", "Fame", "Media Việt Nam", "Rise Media"). Không bịa số liệu, case study, lời khách, không cam kết thứ hạng. Không link nguồn ngoài trong thân bài mới (nguồn chính thống nếu cần thì thêm vào mục tài liệu tham khảo cuối bài nếu bài đã có mục đó). Link nội bộ mới tối đa 2/trang, chỉ tới URL digicomvn.com đang publish (kiểm `curl -s -o /dev/null -w "%{http_code}"` = 200). KHÔNG link tới /pr-va-quang-cao-khac-nhau/ (chưa đăng).
- Giá: chỉ dùng con số đã có trong chính trang gốc hoặc nói cách tính theo yếu tố (DR, lượng truy cập, chủ đề, vị trí, có viết bài không, loại link, thời hạn); không tự đưa giá mới.
- Văn biên tập chuyên nghiệp, viết đoạn văn là chính, bullet/bảng chỉ khi đúng loại. Đoạn <= 130 từ.
- Lượng thêm: vừa đủ trả lời intent/PAA, thường 250-700 từ/trang. Không filler.

## Tự QA trước khi báo
1. `python3 - ` kiểm: mọi dòng của `goc/<slug>.html` có trong `<slug>.html` theo đúng thứ tự (difflib, chỉ có dòng '+').
2. Không "—" "–", không tên cấm ở trên, đếm `<h1>` không tăng.
3. Mọi `<ol>/<ul>` mới có `list-style:none` + `flex-wrap:wrap`; mọi td trong bảng mới có data-label.
4. Báo lại mỗi trang 1 dòng: slug, số từ thêm, các heading mới, PAA đã dùng.
Không đăng gì lên site, không gọi REST ghi, không sửa file ngoài thư mục này.
