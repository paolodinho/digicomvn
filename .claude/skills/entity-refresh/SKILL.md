---
name: entity-refresh
description: >
  Research thực thể (entity) CHI TIẾT ở mức từ/cụm từ (không phải ý chung chung) từ đối
  thủ đang top Google, đối chiếu, tự viết và đăng thẳng lên live. 2 chế độ: CHẾ ĐỘ A
  refresh bài digicomvn.com đã có sẵn (input: URL bài); CHẾ ĐỘ B viết bài MỚI hoàn toàn
  cho 1 chủ đề/từ khoá chưa có bài (input: tên chủ đề). Trigger CHẾ ĐỘ A: "entity-refresh
  <url>", "research thực thể bài <url> rồi bổ sung". Trigger CHẾ ĐỘ B: "entity-refresh
  viết bài mới <chủ đề>", "dùng entity refresh viết <chủ đề>".
---

# Entity Refresh - digicomvn.com

Quy trình 1 lệnh: research đối thủ -> trích thực thể MỨC TỪ/CỤM TỪ -> đối chiếu -> tự viết
-> đăng live -> báo cáo. Dựa trên phương pháp luận của skill global `entity-extraction-seo`
(đọc file đó nếu cần nhắc lại 6 nhóm thực thể) nhưng đóng gói thành pipeline chạy thẳng,
không dừng lại ở báo cáo. Có 2 chế độ, dùng chung BƯỚC 2/3/3B (research + trích thực thể)
và bộ 3 tiêu chí chất lượng ở BƯỚC 6 - chỉ khác ở đầu vào và nơi đăng:

| | CHẾ ĐỘ A - Refresh bài có sẵn | CHẾ ĐỘ B - Viết bài mới |
|---|---|---|
| Input | URL bài digicomvn.com đã tồn tại | Tên chủ đề/từ khoá CHƯA có bài nào |
| Research | 2 lượt WebSearch lấy thực thể (BƯỚC 2) | Research SERP ĐẦY ĐỦ top 10 + Suggest/PAA (BƯỚC B2, sâu hơn) |
| Sản phẩm | Bổ sung câu/đoạn vào bài cũ | Viết bài hoàn chỉnh từ đầu, có dàn bài |
| Đăng | `update` post ID có sẵn | `create` post mới, **đăng luôn (publish)** - Hiếu chốt 2026-08-10, không chờ duyệt draft |

**Khác biệt bắt buộc so với review chung chung**: không chấm "gap ở mức khái niệm" (kiểu
"đối thủ có nói về minh bạch giá") mà phải chỉ ra **đúng TỪ/CỤM TỪ NGẮN** đối thủ dùng
(vd `AEO`, `GEO`, `dofollow`, `VAT`, `Longform`, `E-E-A-T`, `schema`, `canonical`...) và
verify bằng cách grep/tìm trực tiếp trong bài mình xem từ đó CÓ XUẤT HIỆN CHỮ hay không -
không suy diễn "ý này chắc đã có rồi" bằng cảm tính.

## Input CHẾ ĐỘ A (refresh)

- **Bắt buộc**: URL bài trên digicomvn.com (Hiếu paste).
- **Tuỳ chọn**: từ khoá research (nếu không đưa, tự suy từ title/H1 bài, bỏ "digicomvn",
  "2026" và các từ thừa).
- **Tuỳ chọn**: số đối thủ muốn quét (mặc định 8-10 URL từ 2 lượt search).

## BƯỚC 1 - LẤY BÀI HIỆN TẠI

1. Tra post ID: `curl -s "https://digicomvn.com/wp-json/wp/v2/posts?slug=<slug-tu-URL>"`
   (thử `/pages?slug=` nếu không phải post).
2. Lấy `content.raw` làm nguồn đối chiếu:
   `python3 tools/wp-rest-publish.py get-raw --id <ID> > /tmp/entity-refresh-<ID>.json`
3. Strip HTML tag lấy bản text thuần để so khớp từ khoá (không so trên HTML thô, tag có
   thể làm vỡ so khớp cụm từ có khoảng trắng).

## BƯỚC 2 - RESEARCH SERP (2 lượt WebSearch tối thiểu)

1. Lượt 1: đúng từ khoá chính. Lượt 2: biến thể gần nghĩa (đồng nghĩa/thêm ngữ cảnh) để
   phủ rộng hơn 1 lượt search (Google trả tối đa ~7-9 kết quả tự nhiên/lượt qua WebSearch).
2. Gộp URL, loại: `digicomvn.com` (chính mình), domain không cùng ngành (từ điển, mạng xã
   hội không có nội dung thật, aggregator tin tức không viết bài gốc).
3. Với mỗi URL còn lại: `curl -s -L -A "Mozilla/5.0" --max-time 15 "<url>" -o /tmp/e_<hash>.html -w "http:%{http_code}\n"`
   - Lỗi (403/timeout/000) -> ghi vào danh sách "fetch lỗi", KHÔNG thử domain khác thay
     thế ngầm, báo rõ trong report cuối.
   - Trang fetch OK nhưng thân bài rỗng/toàn menu (kiểm bằng: số dòng text sau khi strip
     script/style/nav/footer < ~30 dòng có nghĩa) -> ghi "fetch OK, nội dung rỗng - loại".

## BƯỚC 3 - TRÍCH THỰC THỂ MỨC TỪ/CỤM TỪ (khác CHẾ ĐỘ B của entity-extraction-seo ở độ hạt mịn hơn)

Với MỖI trang đối thủ fetch được nội dung thật:
1. Strip HTML lấy text thuần đầy đủ thân bài (không chỉ H2/H3 - phải đọc cả đoạn văn,
   thực thể mức từ thường nằm trong câu, không nằm ở heading).
2. Quét theo 6 nhóm của `entity-extraction-seo` (công nghệ độc quyền, thuật ngữ kỹ thuật,
   linh kiện/thành phần, đơn vị đo/thông số, tiêu chuẩn/chứng nhận/phân khúc, hiện tượng
   được đặt tên) nhưng ĐƠN VỊ TRÍCH XUẤT LÀ 1 TỪ HOẶC CỤM 2-4 TỪ NGẮN, không phải cả câu.
   Ví dụ đúng: `AEO`, `GEO`, `E-E-A-T`, `schema markup`, `canonical tag`, `dofollow`,
   `nofollow`, `VAT`, `advertorial`, `native advertising`, `longform`, `interactive`,
   `livestream`, `KOL`, `KOC`, `backlink dofollow`, `chỉ số DR`, `Domain Rating`.
   Ví dụ SAI (quá dài, đây là Ý không phải thực thể): "minh bạch trong quy trình báo giá".
3. Ghi bảng nháp mỗi đối thủ: `thực thể | nguyên văn câu chứa nó (để hiểu ngữ cảnh dùng)`.

## BƯỚC 3B - TỪ KHOÁ CÙNG CỤM (bổ sung 2026-08-09)

Ngoài thực thể lấy từ đối thủ (BƯỚC 3), phải quét thêm **biến thể từ khoá trong CÙNG CỤM
DỊCH VỤ** mà bài đang thuộc - đây là nguồn khác hẳn (không phải thực thể/khái niệm, mà là
cách người dùng THẬT gõ tìm kiếm quanh chủ đề). Ví dụ: cụm "booking báo" có các biến thể mô
tả như `giá rẻ`, `uy tín`, `nhanh`, `chuyên nghiệp` - bài về 1 đầu báo cụ thể thiếu hẳn các
biến thể này dù nội dung đã đúng ý, vẫn là tối ưu chưa hết.

1. Xác định cụm dịch vụ bài đang thuộc (booking báo PR / guest post / textlink / backlink...).
2. Nếu cụm đó đã có sẵn file keyword phân nhóm trong dự án (vd
   `10-bang-gia-booking/book-bao-tu-khoa-phan-nhom_<ngày>.csv` cho booking báo PR) - đọc
   TOÀN BỘ Keyword trong nhóm liên quan, không chỉ nhóm "theo đầu báo cụ thể" mà cả nhóm
   "core" chứa biến thể mô tả chung (giá rẻ, uy tín, nhanh, chuyên nghiệp, tốt nhất...).
   Không có file sẵn cho cụm đó -> chạy nhanh Google Suggest cho 3-5 biến thể mô tả phổ
   biến (`giá rẻ`, `uy tín`, `nhanh`, `tốt nhất`, `chuyên nghiệp`) ghép với từ khoá chính,
   lấy kết quả thật, không tự bịa danh sách biến thể.
3. Với mỗi biến thể: verify bài hiện tại ĐÃ có cụm đó chưa bằng grep chuỗi thật (như BƯỚC 4),
   ưu tiên biến thể có volume > 0 hoặc lặp lại ở nhiều dòng trong file (dấu hiệu nhu cầu
   thật dù công cụ đo volume=0 với từ khoá dài).
4. **Chỉ chèn khi khớp ĐÚNG SỰ THẬT của bài đó** - "giá rẻ" chỉ hợp lý khi giá của báo/dịch
   vụ đó thực sự thuộc nhóm rẻ trong bảng giá thật (đối chiếu `bang-gia-booking.md`), KHÔNG
   tự ý gắn "giá rẻ" cho mọi bài bất kể giá thật cao hay thấp - đó là claim sai sự thật
   (`content-professional.md`), không phải tối ưu từ khoá.
5. Chèn tự nhiên vào câu văn có sẵn, KHÔNG liệt kê trần trụi liên tiếp kiểu "giá rẻ, uy tín,
   nhanh chóng" (dấu hiệu nhồi từ khoá/keyword stuffing). Ví dụ đúng: nếu bài đang viết "mức
   chi phí thuộc nhóm dễ tiếp cận trong các báo kinh tế" và giá đó thật sự rẻ so mặt bằng ->
   có thể diễn lại tự nhiên hơn thành câu có chứa cụm "giá rẻ"/"chi phí rẻ" ở đúng ngữ cảnh,
   không thêm thành 1 câu rời rạc chỉ để nhét từ khoá.

## BƯỚC 4 - GỘP CHECKLIST + ĐỐI CHIẾU TỪNG TỪ (bắt buộc verify bằng tìm chuỗi thật)

1. Union toàn bộ thực thể theo BƯỚC 3 VÀ biến thể từ khoá theo BƯỚC 3B, đếm tần suất (bao
   nhiêu/N đối thủ có, hoặc volume/tần suất xuất hiện trong file keyword đối với BƯỚC 3B).
2. Với MỖI thực thể trong checklist, verify sự tồn tại trong bài mình bằng tìm chuỗi trực
   tiếp trên bản text thuần đã strip ở BƯỚC 1 (không phân biệt hoa/thường, chấp nhận biến
   thể viết liền/rời gần đúng nếu cần, vd "AEO/GEO" khớp cả khi bài viết "AEO" và "GEO"
   tách rời). Ghi kết quả CÓ/KHÔNG - không suy đoán, phải thấy chuỗi thật.
3. Xuất bảng gap đầy đủ (không lọc bớt, kể cả thực thể tưởng "chắc đã có" vẫn phải liệt kê
   với kết quả verify thật):

| Thực thể | Nhóm | Tần suất đối thủ | Có trong bài (verify chuỗi)? |
|---|---|---|---|

## BƯỚC 5 - ĐỊNH TUYẾN (theo BƯỚC C của `entity-extraction-seo`)

Với mỗi thực thể THIẾU: phân loại C1 (viết thẳng vào bài, giải thích 1 câu, không cần
link) hay C2 (external link nofollow tới nguồn uy tín - chỉ khi thực thể là khái niệm nền
tảng ngoài phạm vi ngành site). Tuyệt đối không route thực thể là brand/agency đối thủ
sang C2 - áp `khong-link-doi-thu.md` (global): không nêu tên, không link đối thủ, kể cả
khi họ là nguồn gốc phát hiện ra thực thể đó.

## BƯỚC 6 - TỰ VIẾT BỔ SUNG (không dừng ở báo cáo)

1. Với mỗi thực thể C1: viết 1-2 câu biên tập chuyên nghiệp (rule `content-professional.md`
   - không liệt kê từ khoá trần trụi, phải có ngữ cảnh/ý nghĩa thật) nhét vào đúng vị trí
   logic nhất trong bài - ưu tiên thêm vào card/list/đoạn đã có sẵn cùng chủ đề nếu hợp,
   chỉ tạo H2 mới khi thực thể đủ lớn để đứng riêng 1 mục (theo tiêu chí
   `entity-content-mapping` BƯỚC 3 nếu cần tham khảo).
2. Với mỗi thực thể C2: thêm câu giải thích ngắn + `<a href="..." target="_blank"
   rel="nofollow noopener">` tới nguồn uy tín đã verify HTTP 200. Tối đa 3 external
   link/bài (đếm cả link đã có sẵn trong bài).
3. KHÔNG bịa số liệu/tên riêng không xác minh được (`content-professional.md`). Thực thể
   cần số liệu cụ thể mà không có nguồn xác nhận -> viết chung chung, không gán con số.

### 3 tiêu chí bắt buộc cho MỌI câu viết thêm (chốt 2026-08-09, cập nhật 2026-08-09 dựa trên research Google + chuyên gia SEO uy tín)

Trước khi chèn bất kỳ câu nào vào bài, tự kiểm đủ 3 tiêu chí sau - thiếu 1 trong 3 thì viết
lại, không chèn câu chỉ "nhét thêm từ khoá cho đủ". Căn cứ: hướng dẫn chính thức đầu tiên
của Google Search Central về AI Search (công bố 15/5/2026), nghiên cứu GEO của Princeton
(paper gốc formalize thuật ngữ GEO) và CMU (KDD 2024), cùng phân tích của Backlinko/Search
Engine Journal/Search Engine Land về information gain và patent "Contextual estimation of
link information gain" của Google.

**a) Tối ưu cho AI (GEO/AEO) - câu phải tự đứng được, trích dẫn được**
- Nguyên tắc gốc của Google (Search Central, 5/2026): **"Write content for your human
  audience, not for AI."** Không có trick riêng để "qua mặt" AI Overview/AI Mode - nền tảng
  vẫn là nội dung hữu ích thật, kiến trúc rõ ràng, trải nghiệm tốt. 3 tiêu chí này KHÔNG
  thay thế nguyên tắc gốc đó, chỉ là cách trình bày để nội dung hữu ích thật dễ được AI
  trích đúng hơn.
- Thiết kế mỗi đoạn/mục là **self-contained**: đọc riêng đoạn đó ra khỏi bài vẫn hiểu và trả
  lời trọn vẹn 1 câu hỏi - nêu rõ chủ ngữ cụ thể (tên báo, tên thực thể thật), không dùng
  đại từ mơ hồ ("nó", "đây", "điều này") ở câu mở đầu đoạn.
- Đặt khẳng định/câu trả lời chính NGAY ĐẦU đoạn hoặc đầu câu, giải thích/ngữ cảnh theo sau
  - không vòng vo dẫn dắt rồi mới ra ý chính ở cuối.
- Với thực thể là khái niệm/tên riêng: theo khung của CMU (KDD 2024, "impression score" cao
  hơn với nội dung có cấu trúc định nghĩa rõ), ưu tiên format **"[Thực thể] là [loại] mà
  [đặc điểm phân biệt]"** ở câu đầu tiên nhắc tới thực thể đó, thay vì mô tả rải rác.
- Theo nghiên cứu Princeton (GEO gốc): 3 đòn bẩy tăng khả năng được AI trích dẫn mạnh nhất
  là **thêm trích dẫn nguồn (citation), thêm quote/phát ngôn xác thực, và làm giàu bằng số
  liệu cụ thể (statistics)** - ưu tiên 3 loại này khi có dữ liệu thật, hơn là mô tả chung
  chung không có con số/nguồn.
- Freshness: Google xét cả ngày đăng/ngày cập nhật khi đánh giá AI Overviews - khi sửa
  thông tin quan trọng (số liệu, giấy phép, chủ quản), cân nhắc đây cũng là lý do nên cập
  nhật `modified_time` của bài (đã có sẵn qua `dgc_sch_*` - xem `schema-markup.md`).

**b) Giọng viết KHÁC ROBOT - không lặp công thức máy móc**
- Dấu hiệu robot dễ nhận biết nhất theo giới chuyên gia (Forbes Communications Council,
  các bài phân tích AI-writing 2026): câu dài đều nhau, lặp từ, giọng phẳng trung tính
  xuyên suốt, và cấu trúc liệt kê song song cứng nhắc ("Thứ nhất... Thứ hai... Thứ ba...",
  "Ngoài ra, X còn bao gồm Y, Z") lặp lại ở nhiều đoạn liên tiếp.
- Cách sửa được khuyến nghị rộng rãi: **đọc to câu vừa viết**, trộn câu ngắn xen câu dài,
  thay cụm lặp bằng cách diễn đạt khác, thêm 1-2 chi tiết cụ thể (số liệu, tên thật, hoàn
  cảnh) thay vì tính từ mô tả chung chung.

**Danh sách mẫu câu/từ AI hay dùng - RÀ và LOẠI trước khi chèn (research 2026-08-09, nguồn:
Wikipedia:Signs of AI writing, phân tích 15 triệu abstract PubMed của Science Advances,
Max Planck Institute, BRANDS Vietnam):**

| Nhóm | Dấu hiệu | Ví dụ cụ thể (tránh) |
|---|---|---|
| Editorializing - chèn lời "làm ra vẻ khách quan/trung thực" | Mở câu bằng cụm tự nhận xét thay vì đi thẳng vào fact | "Cần nói thẳng là...", "Điều quan trọng cần lưu ý là...", "Không thể phủ nhận rằng...", "`<Brand>` không giấu điều này..." (tự khen sự trung thực - đã bắt được ở bài Webtretho 2026-08-09, coi là case mẫu) |
| Chuyển đoạn máy móc | Nối đoạn bằng đúng 1 trong vài từ lặp lại | "Hơn nữa", "Thêm vào đó", "Ngoài ra" dùng liên tục làm từ mở đầu nhiều đoạn liên tiếp trong CÙNG 1 bài |
| Rule of three | Liệt kê đúng 3 vế làm "khuôn tu từ" dù nội dung không tự nhiên chia 3 | Adjective/benefit 3 vế đều nhau kiểu "toàn diện, đột phá, hiệu quả"; "Thứ nhất... Thứ hai... Thứ ba..." lặp ở nhiều đoạn |
| Ngôn ngữ thổi phồng tầm quan trọng | Gán ý nghĩa lớn lao cho chi tiết nhỏ | "đóng vai trò then chốt", "là minh chứng cho...", "khẳng định tầm quan trọng của...", tương đương "stands as a testament to", "underscores its importance", "plays a vital role" |
| Từ vựng AI tần suất cao (áp cho bản dịch/ý tương đương tiếng Việt) | Từ xuất hiện ở AI cao hơn hẳn tần suất người viết thật (delve/tapestry/pivotal/underscore/crucial/robust/leverage/comprehensive - theo Science Advances, tăng ~400% kể từ ChatGPT) | Tránh bản dịch sáo rỗng tương đương: "sâu sắc/đào sâu" dùng lặp lại, "bức tranh toàn cảnh", "bước tiến đúng hướng", "một phần nhỏ của tảng băng chìm", "tạo giá trị", "đồng bộ hoá mục tiêu" - đúng như BRANDS Vietnam liệt kê là sáo ngữ AI hay dùng |
| Kết luận rập khuôn | Chốt đoạn/bài bằng công thức lặp | "Tóm lại...", "Kết luận là..." chèn giữa bài (khác H2 "Kết luận" ở cuối bài - đó là mục có chủ đích, không tính) |
| Meta-reference (đã cấm trong `content-professional.md`, củng cố thêm ở đây) | Tự nhắc tới chính bài viết/quá trình viết | "đúng như cách bài viết này gọi...", "như đã giải thích ở phần trên", "phần dưới đây sẽ..." lặp nhiều lần |

Quy trình áp dụng: sau khi viết xong câu/đoạn mới, **grep nhanh** các cụm ở cột 3 trong bản
nháp trước khi chèn vào bài - thấy khớp thì viết lại theo hướng đi thẳng vào fact (bỏ hẳn
câu mở editorializing, không thay bằng từ đồng nghĩa sáo rỗng khác).
- Tự kiểm bằng câu hỏi: "câu này có thể xuất hiện y hệt trong bất kỳ bài SEO nào khác về
  chủ đề tương tự không?" Nếu có -> viết lại cho gắn cụ thể với chính thực thể/bối cảnh
  đang nói (tên báo, số liệu, quy định thật của bài này), không phải câu generic dùng đâu
  cũng được. Đúng tinh thần `content-professional.md` (biên tập chuyên nghiệp, không bỗ bã)
  nhưng KHÔNG đánh đổi thành văn phong công thức, sáo rỗng kiểu bài SEO đại trà.
- Chèn 1 câu/mục mới cũng đừng luôn rơi đúng cùng 1 vị trí công thức (vd luôn thêm ngay sau
  câu mở đầu H2, luôn thành FAQ cuối cùng) - đa dạng điểm chèn giữa các lần refresh khác
  nhau, cùng tinh thần "không rập khuôn dàn bài máy móc" ở cấp toàn bài
  (xem `content-pipeline` SKILL.md BƯỚC 3, rule Hiếu 2026-08-09) áp cho cả việc bổ sung nội
  dung vào bài có sẵn, không chỉ bài viết mới.

**c) Information gain - có phần ĐỘC NHẤT so với mọi đối thủ đã quét, không chỉ lấp gap**
- Căn cứ: Google có patent "Contextual estimation of link information gain" (nộp 2018,
  công bố 2022) - đo "additional information vượt ra ngoài thông tin đã có ở các tài liệu
  người dùng từng xem", dùng như một tín hiệu xếp hạng. Lấp gap (thêm thực thể đối thủ đã
  nói mà bài mình thiếu) là điều kiện CẦN nhưng CHƯA ĐỦ theo đúng định nghĩa information
  gain - phải có phần KHÔNG NẰM TRONG bất kỳ tài liệu nào đối thủ đã có mới thật sự tính là
  gain, không phải chỉ "đủ như đối thủ".
- Phân tích của Cyrus Shepard (sau Google core update 3/2026, khảo sát 400+ site): sở hữu
  **tài sản độc quyền/first-party data** ("content moat") là 1 trong 3 yếu tố dự đoán mạnh
  nhất việc giữ được traffic; site chỉ có thông tin phổ quát (ai cũng viết được) là nhóm
  mất traffic nhiều nhất. Ưu tiên các loại thông tin AI không tự tổng hợp được:
  - Verify trực tiếp từ nguồn gốc (footer/schema.org của chính site được nhắc tới) thay vì
    lặp lại điều đối thủ đã viết - nhiều lần trong session đã phát hiện đối thủ ghi SAI
    (nhầm chủ quản, nhầm số giấy phép) trong khi verify tận gốc mới ra sự thật.
  - Số liệu/dữ liệu tự đo của DigicomVN (Ahrefs DR, ngày chụp ảnh thực tế) thay vì con số
    đối thủ tự nhận không kiểm chứng được.
  - Góc phân tích/khuyến nghị thực dụng riêng (khi nào nên chọn vị trí này thay vì vị trí
    kia, cạm bẫy cụ thể cần tránh) - không chỉ liệt kê thông số như mọi bài đối thủ.
- Nếu sau khi rà cả checklist chỉ toàn là lấp gap thuần tuý (không có lớp nào độc nhất) ->
  vẫn chèn (đúng BƯỚC 4/5), nhưng ưu tiên tìm thêm 1 câu verify-gốc hoặc góc nhìn riêng để
  bài không chỉ là "chép lại đủ ý đối thủ có", tránh trùng lặp thông tin với chính các
  nguồn đã quét.

## BƯỚC 7 - BACKUP + ĐĂNG LIVE

1. Backup: `content.raw` GỐC (đã lấy ở BƯỚC 1) -> lưu
   `~/Claude-Workspace/_backups/routines/<ngày>/entity-refresh/post<ID>-BEFORE.json` +
   1 dòng manifest (rule `routine-backup.md`).
2. Đăng: `python3 tools/wp-rest-publish.py update --id <ID> --content-file <file-moi>`.
3. Verify: `curl -s "<url-bai>" | grep -o "<chuoi-dac-trung-vua-them>"` cho TỪNG thực thể
   đã thêm - phải thấy xuất hiện thật trên live, không chỉ tin đã update thành công.

## BƯỚC 8 - BÁO CÁO (bắt buộc đủ, theo `explain-after-done.md`)

1. Danh sách đối thủ đã fetch OK / fetch lỗi (nêu rõ domain nào lỗi, không im lặng bỏ qua).
2. Bảng checklist thực thể đầy đủ (BƯỚC 4) - không chỉ liệt kê thực thể đã thêm, phải cho
   thấy cả những thực thể ĐÃ CÓ SẴN (để Hiếu biết đã verify kỹ, không phải qua loa). Ghi rõ
   nguồn từng dòng là "đối thủ" (BƯỚC 3) hay "từ khoá cùng cụm" (BƯỚC 3B).
3. Bảng định tuyến C1/C2 (BƯỚC 5).
4. Trích nguyên văn từng câu đã chèn vào bài (như 2 lần chạy tay trước đó Hiếu đã yêu cầu
   "trích dẫn câu mà thực thể mới được chèn vào").
5. Link live đã verify.

## Khi bài không có gap thật

Nếu sau BƯỚC 4 không có thực thể nào verify là THIẾU thật sự (đã xảy ra với bài
`agency-booking-bao-chi` 2026-08-09) -> KHÔNG ép thêm nội dung filler. Báo rõ đã quét bao
nhiêu đối thủ, bảng đối chiếu đầy đủ, kết luận bài đã phủ đủ - dừng ở báo cáo, không sửa
bài (`quality-bar.md` - chống scope creep/filler).

---

# CHẾ ĐỘ B - VIẾT BÀI MỚI (bổ sung 2026-08-10)

Dùng khi chủ đề/từ khoá CHƯA có bài nào trên digicomvn.com (khác Chế độ A - không có bài
gốc để đối chiếu). Tái dùng nguyên BƯỚC 2 (research SERP lấy thực thể), BƯỚC 3 (trích thực
thể mức từ), BƯỚC 3B (từ khoá cùng cụm) và bộ 3 tiêu chí chất lượng ở BƯỚC 6 phía trên -
KHÔNG viết lại các phần đó, chỉ thêm phần research SÂU HƠN (do là bài mới, không phải vá 1
đoạn) và phần tạo bài/đăng mới thay vì update.

**Trả lời câu hỏi "viết nhiều bài cùng lúc có kém chất lượng hơn viết từng bài không":
KHÔNG kém hơn nếu mỗi bài vẫn đi đủ các bước B1-B7 riêng (research riêng, dàn bài riêng, QA
riêng) - rủi ro chỉ xảy ra khi dùng chung 1 vòng research/dàn bài cho nhiều bài hoặc bỏ bớt
bước để chạy nhanh. Batch nhỏ (2-3 bài) không cần cảnh báo gì thêm; batch >=5 bài cùng chủ
đề/cụm phải áp `publish-volume-warning.md` (global) trước khi viết hàng loạt.**

## BƯỚC B1 - INPUT + XÁC ĐỊNH PHẠM VI

1. Xác định: tên chủ đề, từ khoá chính dự kiến, cụm dịch vụ bài thuộc về (booking báo PR /
   guest post / textlink / backlink / toplist...), slug dự kiến (không dấu, có gạch ngang).
2. Verify CHƯA có bài nào trùng chủ đề: `curl -s "https://digicomvn.com/wp-json/wp/v2/search?search=<tu-khoa>&_fields=id,title,url"`
   - Có bài trùng/gần trùng -> DỪNG, báo Hiếu, hỏi có phải ý là refresh (Chế độ A) bài đó
     không thay vì viết bài mới (tránh trùng lặp nội dung/cannibalization).
3. Xác nhận đúng phạm vi dịch vụ thật của Digicom (`dich-vu.md`) - từ chối viết nếu chủ đề
   thuộc dịch vụ Digicom không bán (vd bố cáo doanh nghiệp, quảng cáo banner/video, booking
   gov/edu - theo `khong-ban-gov-edu.md`).

## BƯỚC B2 - RESEARCH SERP ĐẦY ĐỦ (sâu hơn BƯỚC 2 của Chế độ A)

Vì đây là bài viết từ đầu (không phải vá 1 đoạn), phải research đủ theo `do-dont.md` mục
"Research SERP + dựng dàn bài TRƯỚC khi viết", KHÔNG dừng ở 2 lượt lấy thực thể:
1. Đọc **top 10 Google** (không phải top 7) cho từ khoá chính + các biến thể sát intent.
2. Đọc hết **Google Suggest** + "Mọi người cũng hỏi" (PAA) + tìm kiếm liên quan cuối trang.
3. Từ top 10, phân loại dạng nội dung đang xếp hạng (listicle/how-to/định nghĩa/thương mại
   - theo `audit-intent-truoc.md`) để chắc chắn viết ĐÚNG DẠNG đối thủ đang được xếp hạng.
4. Thực hiện lại BƯỚC 2/3/3B (research thực thể mức từ + từ khoá cùng cụm) trên đúng bộ
   URL top 10 này - không cần research riêng 2 lần.

## BƯỚC B3 - DÀN BÀI (bắt buộc trước khi viết, theo `do-dont.md`)

1. Dàn bài phải: đủ như top 10 (không thiếu khía cạnh đối thủ đã có), có phần ĐỘC NHẤT
   (theo tiêu chí (c) information gain ở BƯỚC 6), trả lời trực diện ngay đầu mỗi mục.
2. Gán loại visual cho MỖI H2 ngay từ bước dàn bài (ảnh Storyset/ảnh thật, sơ đồ HTML, bảng
   dữ liệu, hoặc widget tương tác) - theo `content-visual-coverage.md`, tối thiểu 2 ảnh +
   mọi H2 có yếu tố trực quan. Tối thiểu 3 sơ đồ HTML cho đoạn phức tạp (`content-diagram-explain.md`).
3. Dàn ý KHÔNG được rập khuôn 1 khuôn cố định nếu viết nhiều bài liên tiếp trong cùng cụm -
   đổi thứ tự mục/cách mở bài giữa các bài để tránh đọc như 1 công thức (đúng tinh thần mục
   "giọng viết khác robot" ở BƯỚC 6b, áp cả cho cấu trúc toàn bài chứ không chỉ câu văn).

## BƯỚC B4 - VIẾT BÀI ĐẦY ĐỦ

1. Áp dụng NGUYÊN VẸN 3 tiêu chí ở BƯỚC 6 (GEO/AEO tự đứng được, giọng khác robot - rà
   bảng "dấu hiệu AI" trước khi chèn, information gain có phần độc nhất) cho TOÀN BỘ bài,
   không chỉ 1-2 câu bổ sung như Chế độ A.
2. Thực thể/số liệu/nhân vật nổi tiếng trích dẫn -> gắn nguồn + `rel="nofollow"` theo
   `external-link-eeat.md`. Không bịa số liệu (`content-professional.md`).
3. Văn phong biên tập chuyên nghiệp, không "bỗ bã" (`content-professional.md`), tiếng Việt
   có dấu đầy đủ, tránh AI-slop hình ảnh (`ui-anti-slop.md`, `image-sourcing.md` - phong
   cách Storyset cho ảnh minh hoạ khái niệm).
4. Chuẩn bị kèm: tiêu đề SEO + mô tả SEO (field `dgc_seo_title`/`dgc_seo_desc`, xem
   `seo-meta-og.md`), gán đúng category `dgc_nhom`/category 24 nếu thuộc booking báo.

## BƯỚC B5 - TẠO BÀI MỚI + ĐĂNG (khác BƯỚC 7 - không có "before" vì bài chưa tồn tại)

1. Tạo post mới qua `tools/wp-rest-publish.py` (dùng action `create` nếu script hỗ trợ, hoặc
   POST trực tiếp `wp/v2/posts` với Basic Auth) - **mặc định `status: draft`**, KHÔNG tự
   publish thẳng trừ khi Hiếu nói rõ "đăng luôn/publish thẳng".
2. Log 1 dòng vào manifest ngày hiện tại (`routine-backup.md`) với loại sửa = "created" (bài
   mới không có bản gốc để backup, chỉ cần ghi nhận đã tạo).
3. Nếu Hiếu duyệt và yêu cầu publish -> `wp-rest-publish.py update --id <ID>` đổi status.

## BƯỚC B6 - VERIFY

1. Verify bài tạo thành công: `curl -s "https://digicomvn.com/wp-json/wp/v2/posts/<ID>?_fields=id,slug,status,link"`.
2. Nếu đã publish: verify visual coverage thật trên live (đủ ảnh/sơ đồ mỗi H2, không vỡ dark
   mode - theo `content-visual-coverage.md` + `ui-mau-sac.md`), verify schema
   (`tools/schema-vocab-check.py` nếu đăng thật).

## BƯỚC B7 - BÁO CÁO

1. Chủ đề, từ khoá chính, dạng nội dung đã xác định (theo BƯỚC B2.3).
2. Danh sách 10 đối thủ đã research (fetch OK/lỗi).
3. Dàn bài đã dùng (danh sách H2 + loại visual gán cho từng H2).
4. Bảng thực thể/từ khoá cùng cụm đã chèn (như BƯỚC 4 của Chế độ A).
5. Link bài (draft hoặc live) + trạng thái hiện tại (draft/publish), hỏi Hiếu duyệt nếu còn draft.

## Liên quan
- `entity-extraction-seo` (skill global) - phương pháp luận gốc, 6 nhóm thực thể, BƯỚC C
  định tuyến C1/C2. Skill này là bản đóng gói chạy thẳng riêng cho digicomvn.com.
- `content-pipeline` (skill project) - pipeline viết bài mới đầy đủ hơn (nếu cần các bước
  ngoài phạm vi entity/từ khoá, vd nghiên cứu ảnh/case study sâu) - Chế độ B ở trên là bản
  rút gọn tái dùng hạ tầng research của entity-refresh, dùng khi trọng tâm là phủ đủ
  thực thể/từ khoá cạnh tranh; việc lớn/phức tạp hơn vẫn nên qua `content-pipeline`.
- `do-dont.md` mục "Research SERP + dựng dàn bài" - quy trình gốc BƯỚC B2/B3 tham chiếu.
- `audit-intent-truoc.md` - xác định đúng dạng nội dung trước khi viết.
- `content-visual-coverage.md`, `content-diagram-explain.md` - yêu cầu visual mỗi bài.
- `publish-volume-warning.md` (global) - cảnh báo khi viết hàng loạt (>=5 bài/cụm).
- `khong-link-doi-thu.md`, `content-professional.md`, `external-link-eeat.md` (rules
  project + global) - ràng buộc bắt buộc khi viết/link.
- `routine-backup.md` (global) - backup trước khi ghi đè.
- `tools/wp-rest-publish.py` - script đăng bài dùng ở BƯỚC 7 / BƯỚC B5.
