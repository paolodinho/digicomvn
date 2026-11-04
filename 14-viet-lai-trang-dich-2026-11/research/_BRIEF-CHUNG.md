# Brief chung: viết lại trang đích digicomvn.com (02/11/2026)

Hiếu giao (02/11/2026): "Rà lại toàn bộ nội dung các trang đích của digicomvn viết lại theo hướng tự nhiên, con người, hấp dẫn, tăng chuyển đổi, có research đối thủ."

PHẠM VI: BẢN NHÁP. KHÔNG sửa WordPress (không REST PUT/POST, không wp-cli ghi, không SSH ghi). Chỉ đọc site live + ghi file trong thư mục này.

## Đầu vào có sẵn
- Chữ hiển thị trang live (đã trích): `research/live-2026-11-02/<slug>.txt` (HTML gốc cùng tên `.html`). Slug có "/" thì đổi thành "_" (vd `dich-vu-backlink_bat-dong-san`).
- GSC 90 ngày (03/08-31/10/2026), theo trang + truy vấn: `research/gsc-page-query-90d-2026-11-02.tsv`; tóm tắt từng trang: `research/gsc-tom-tat-trang-dich.tsv`.
- SERP top 10 đã đo ẩn danh (Chrome không đăng nhập, IP VN, google.com.vn):
  - `/Volumes/Extreme SSD/Projects/digicom/06-keyword/serp-top10-2026-10-26/serp.csv` (26/10; textlink, backlink, guest post, booking báo, kol, toplist, social entity, backlink quốc tế...)
  - `/Volumes/Extreme SSD/Projects/digicom/06-keyword/serp-con-lai-2026-10-29/serp-bu.csv` (29/10; truyền hình, phát thanh, booking kol, entity, backlink giá rẻ...)
  - `/Volumes/Extreme SSD/Projects/digicom/12-chuyen-huong-seo-2026-10/serp.csv` + `research-sitemap.md` (27/10; dịch vụ seo, seo local, seo ai, seo quốc tế, viết bài chuẩn seo, mua tên miền, hosting giá rẻ, ahrefs, khoá học seo)
  - `research/serp-2026-11-02/serp.csv` (đang đo 02/11; thiết kế website, chăm sóc website, đăng ký website bộ công thương, email doanh nghiệp, chứng chỉ ssl, cloud server, thuê vps, vps giá rẻ, hosting wordpress, đăng ký tên miền, quảng cáo truyền hình, backlink bất động sản, dịch vụ toplist, booking báo chí). Nếu file chưa có thì dùng WebSearch và ghi rõ "WebSearch, không cookie".
- Thông tin doanh nghiệp: `/Volumes/Extreme SSD/Projects/digicom/.claude/context/brand-info.md`; case study thật: https://digicomvn.com/case-study/ (5 case: Bệnh viện Việt Pháp triển lãm tranh, phòng khám H Plus, ICD Việt Nam, Bệnh viện Mắt Hà Nội 2, dodanong.com). Chỉ dùng số liệu có trong các nguồn này hoặc trên trang live.
- Rule dự án: `/Volumes/Extreme SSD/Projects/digicom/.claude/rules/` (đọc tối thiểu: dich-vu.md, do-dont.md mục "văn AI", chong-ai-slop.md, lam-sau-co-trong-diem.md, khong-ban-gov-edu.md, uu-dai-cta.md mục Thuật ngữ).

## Cách làm cho MỖI trang
1. Đọc chữ live + GSC trang đó (từ khoá đang có lượt hiện, vị trí). Nhận diện từ chính.
2. Research đối thủ: lấy top 10 từ file SERP (hoặc WebSearch), phân loại dạng trang, đọc tiêu đề; mở (WebFetch) 2-3 trang đối thủ mạnh nhất cùng dạng xem họ có: bảng giá, cam kết, quy trình, case thật, CTA, FAQ, bằng chứng. Ghi gap của Digicom.
3. Ghi research vào `research/<slug>.md`: từ chính + GSC, dạng trang top 10 (đếm), đặc điểm tiêu đề, 2-3 đối thủ đã mở (URL + ngày đọc + họ có gì), gap, hướng viết lại, tiêu đề/H1 đề xuất (giữ từ khoá đang có lượt hiện). Tên/link đối thủ CHỈ được nằm trong file research này.
4. Viết bản nháp `nhap/<slug>.html` dạng Gutenberg (`<!-- wp:heading -->`, `<!-- wp:paragraph -->`, `<!-- wp:list -->`, `<!-- wp:table -->`...), giữ nguyên URL. Đầu file 1 khối comment HTML ghi: URL, SEO title đề xuất (<= 60 ký tự), meta description (<= 155 ký tự), H1, ghi chú phần nào là khối theme giữ nguyên (bảng giá động, form, nút Mua ngay...) và chèn chỗ đặt bằng comment `<!-- GIU KHOI THEME: bang gia -->`.

## Giọng viết (bắt buộc)
- Người thật nói với chủ doanh nghiệp/người làm SEO: câu khẳng định thẳng, có nhịp dài ngắn, có ví dụ cụ thể, lợi ích cho khách trước, rồi cách làm, rồi bằng chứng, rồi CTA rõ (form báo giá /dat-bai/, gọi 0988 769 317, Zalo). Landing: 1 điểm chuyển đổi chính.
- Mặc định đoạn văn; bảng chỉ khi so sánh/giá; bullet chỉ khi là danh sách thật (bước, tiêu chí). Đoạn <= 130 từ.
- FAQ: H2 "Câu hỏi thường gặp", mỗi câu hỏi là H3, câu trả lời đi thẳng 40-60 từ. Câu hỏi lấy từ PAA trong file SERP.
- CẤM: em dash (—) và en dash (–), dùng "-". Phép đối "X, không Y" / "không phải... mà là..." / "không chỉ... mà còn...". Từ sáo: then chốt, toàn diện, vượt trội, hàng đầu, bứt phá, nâng tầm, đồng hành, chìa khoá, minh chứng, kỷ nguyên số, trong bối cảnh, tận tâm, "Trong thời đại", "Tóm lại", "Hãy cùng", "Đừng bỏ lỡ". Emoji. Tiêu đề viết hoa toàn bộ. Liệt kê đều 3 ý. Câu meta nội bộ ("không bịa", "nói thẳng").
- KHÔNG nêu tên/link đối thủ trong nháp. KHÔNG lộ giá vốn, tên nhà cung cấp/đại lý (P.A Việt Nam, DanaSEO, Solann...), công thức tính giá. KHÔNG bán/nhắc bán backlink .gov.vn/.edu.vn. KHÔNG bịa số khách, năm kinh nghiệm, case, cam kết thứ hạng, số sao. Số liệu ngoài phải có nguồn (link ra nguồn chính thống được, không link đối thủ). Không dùng cụm "bài chuẩn SEO" (dùng "viết bài", "viết nội dung chuẩn SEO/GEO"; riêng tên dịch vụ /dich-vu-viet-bai-chuan-seo/ giữ từ khoá).
- Không đổi H1/title làm mất từ khoá đang có lượt hiện trong GSC.

## Tự QA trước khi xong mỗi trang
`grep -c "—\|–"` = 0; không có tên miền đối thủ trong nháp; mọi con số có nguồn (trang live, case study, hoặc link nguồn).

## Trả về cho phiên chính (ngắn)
Mỗi trang 1 dòng: URL | từ chính + GSC | thay đổi chính | điểm cần Hiếu xác nhận (nếu có). Không kể quá trình.
