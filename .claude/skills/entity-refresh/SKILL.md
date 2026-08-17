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
| Research | 2 lượt WebSearch lấy thực thể (BƯỚC 2) + đo độ dài/số ảnh đối thủ (BƯỚC 3C) | Research SERP ĐẦY ĐỦ top 10 + Suggest/PAA (BƯỚC B2, sâu hơn), gồm cả BƯỚC 3C |
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

## BƯỚC 2B - PHÂN TÍCH TIÊU ĐỀ + DẠNG BÀI GOOGLE ĐANG ƯU TIÊN (bổ sung 2026-08-10)

Trước khi trích thực thể (BƯỚC 3), phải biết Google đang xếp hạng DẠNG NỘI DUNG nào cho từ
khoá này - bổ sung thực thể vào 1 bài SAI DẠNG vẫn khó tăng hạng, theo đúng bài học của
`audit-intent-truoc.md` (case `dien-dan-di-backlink`: sửa hình thức cho bài sai dạng là công
cốc). Entity-refresh trước đây bỏ qua bước này, chỉ lo phủ thực thể - nay bắt buộc chạy trước.

1. Với MỖI trang đối thủ đã fetch OK ở BƯỚC 2, lấy **`<title>` thật** (đọc từ thẻ `<title>`
   trong HTML đã fetch, không suy đoán từ URL/snippet) và **H1 thật**, phân loại dạng theo
   `audit-intent-truoc.md`: listicle/danh sách (có số trong tiêu đề: "Top 10", "15 mẫu"...),
   how-to/hướng dẫn từng bước, định nghĩa/giải thích khái niệm ("X Là Gì"), so sánh, trang
   thương mại/dịch vụ, case study. Ghi bảng nháp:

   | Domain | Title thật | H1 thật | Dạng |
   |---|---|---|---|

2. Đếm tần suất dạng: `X/N là listicle, Y/N là how-to...`. Dạng chiếm đa số (≥50% hoặc rõ
   rệt nhất so các dạng còn lại) là **dạng Google đang ưu tiên** cho từ khoá này.
3. Trích PATTERN tiêu đề cụ thể đang lặp lại - không dừng ở tên dạng chung chung:
   - Có số trong tiêu đề không? Nếu có, số phổ biến nhất là bao nhiêu (top 10? top 15?)?
   - Có năm (2026) không - bao nhiêu % đối thủ có?
   - Cụm mở đầu/mẫu câu lặp lại: "Top...", "N Cách...", "N Mẫu/Ví dụ...", "X Là Gì?",
     "Hướng Dẫn...", "So Sánh..."?
   - Độ dài tiêu đề trung bình (số ký tự) của nhóm đang top.
4. Đối chiếu với title/H1/dạng của bài digicomvn.com hiện tại (đã lấy ở BƯỚC 1):
   - **KHỚP dạng** -> đi tiếp bình thường sang BƯỚC 3, chỉ cần bổ sung thực thể như quy trình
     cũ.
   - **LỆCH dạng** (vd bài đang là "X Là Gì" dạng định nghĩa nhưng top 10 toàn "Top N X" dạng
     listicle, hoặc ngược lại) -> đây là vấn đề LỚN HƠN thiếu thực thể. KHÔNG tự đổi
     title/cấu trúc bài ngầm trong lúc "chỉ refresh bổ sung entity" (đổi dạng bài là quyết
     định ảnh hưởng URL/SEO title/toàn bộ cấu trúc, vượt phạm vi 1 lần refresh thông thường).
     Vẫn tiếp tục refresh thực thể theo BƯỚC 3-7 như bình thường (không dừng cả pipeline), NHƯNG
     phải nêu rõ trong báo cáo (BƯỚC 8): bảng tỷ lệ dạng + pattern tiêu đề đối thủ, kèm đề xuất
     có nên viết lại toàn bộ theo dạng đang top hay không - để Hiếu quyết định riêng, tách khỏi
     việc bổ sung thực thể đang làm.

## BƯỚC 2C - RESEARCH NGUỒN QUỐC TẾ (bổ sung 2026-08-11)

Toàn bộ BƯỚC 2 chỉ research đối thủ tiếng Việt -> dễ bị bó hẹp trong những ý mà thị trường
VN đã lặp đi lặp lại lẫn nhau, bỏ lỡ thông tin/góc nhìn mới mà nguồn quốc tế (thường đi trước
VN) đã có. Hiếu chốt 2026-08-11: MỌI bài (refresh lẫn viết mới) phải research thêm ít nhất
1 lượt bằng nguồn nước ngoài trước khi chốt dàn ý/checklist bổ sung.

1. Dịch từ khoá chính sang tiếng Anh (hoặc giữ nguyên nếu đã là thuật ngữ quốc tế như PAS,
   AIDA, E-E-A-T), search bằng WebSearch KHÔNG giới hạn domain (mặc định trả kết quả toàn
   cầu, ưu tiên đọc các domain .com/.org quốc tế xuất hiện tự nhiên trong kết quả).
2. Ưu tiên đọc nguồn THUỘC LOẠI UY TÍN: cơ quan/tổ chức gốc phát minh khái niệm (Search Engine
   Journal, Search Engine Land, Google Search Central, Moz, Ahrefs, HubSpot, Copyblogger,
   Nielsen Norman Group, Princeton/CMU/đại học có paper gốc...), KHÔNG lấy nguồn spam/affiliate
   thấp chất lượng dù xếp hạng cao.
3. Mục tiêu tìm **THÔNG TIN THẬT SỰ MỚI** mà 100% nguồn tiếng Việt đã research (BƯỚC 2) chưa
   có - không phải diễn đạt lại ý đã có bằng tiếng Anh. Ví dụ loại thông tin đáng tìm:
   - Nghiên cứu/số liệu gốc (khảo sát, paper học thuật, báo cáo ngành) mà nguồn VN không trích
     dẫn hoặc trích sai/thiếu nguồn.
   - Ví dụ/case study thực tế từ thị trường quốc tế (thương hiệu lớn đã làm, có thể kiểm
     chứng qua nguồn báo chí/công bố chính thức).
   - Góc nhìn/tiêu chí mới nguồn quốc tế đã cập nhật nhưng bài tiếng Việt còn viết theo thông
     tin cũ (đặc biệt các chủ đề SEO/AI Search - nguồn quốc tế luôn đi trước VN vài tháng).
   - Định nghĩa gốc/nguồn gốc thuật ngữ chính xác hơn (nhiều bài VN dịch/diễn giải sai ý gốc).
4. KHÔNG bịa hoặc suy diễn số liệu từ nguồn quốc tế - mọi con số/claim phải đọc được trực
   tiếp trong bài đã fetch (`content-professional.md`), trích dẫn kèm tên nguồn cụ thể.
5. Không tìm được thông tin mới thực sự đáng giá (nguồn quốc tế chỉ lặp lại đúng ý nguồn VN
   đã có) -> KHÔNG cố nhét thêm cho có, ghi rõ trong báo cáo "đã research quốc tế, không có
   thông tin mới đáng bổ sung" - đây là kết quả hợp lệ, không phải làm thiếu việc.
6. Thông tin mới tìm được -> đưa vào checklist chung ở BƯỚC 4 (coi như 1 dạng "thực thể/Ý
   thiếu" cần định tuyến C1/C2 ở BƯỚC 5), viết bổ sung theo đúng 3 tiêu chí chất lượng ở
   BƯỚC 6, và transparent nguồn gốc trong báo cáo BƯỚC 8 (ghi rõ lấy từ nguồn quốc tế nào).

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

## BƯỚC 3B-USER - BỘ TỪ KHOÁ LẺ HIẾU DÁN TRỰC TIẾP VÀO CHAT (bổ sung 2026-08-11)

Khác BƯỚC 3B (skill tự tìm biến thể từ file/Google Suggest): đây là trường hợp Hiếu dán thẳng
1 danh sách từ khoá lẻ/long-tail (thường xuất từ công cụ đo volume, dạng "Google Suggest thô"
chưa lọc) kèm yêu cầu bổ sung vào ĐÚNG bài vừa refresh. Coi đây là nguồn ưu tiên cao nhất - có
sẵn, không cần research thêm - nhưng vẫn phải qua đủ các bước lọc dưới đây trước khi chèn,
KHÔNG chèn nguyên văn từng dòng theo kiểu liệt kê.

1. **Lọc nhiễu trước khi xử lý**: danh sách dạng này thường có lỗi gõ/thiếu dấu ("dđịnh nghĩa",
   "viết bài pr la gì") và cụm ghép nghĩa mơ hồ do công cụ tự động ghép 2 khái niệm không liên
   quan (vd "bài pr có chân dung quảng cáo là gì"). Với mỗi dòng: suy ra Ý/intent thật đằng sau
   (bỏ qua lỗi chính tả), rồi tự hỏi "cụm này có thể viết tự nhiên trong 1 câu tiếng Việt chuẩn
   không, hay là rác ghép từ?" - loại thẳng loại rác, không cố nhét nguyên văn cho đủ số.
2. **Verify từng Ý (không phải từng dòng thô) đã có trong bài chưa** bằng grep chuỗi thật trên
   bản text đã strip (như BƯỚC 4) - nhiều dòng khác nhau trong danh sách có thể cùng chỉ 1 Ý
   đã có sẵn trong bài (vd 3 biến thể "viết bài pr là gì/la gì/nghĩa là gì" chỉ là 1 gap).
3. **Phân loại theo đúng sự thật của bài, không ép mọi cụm thành nội dung có sẵn**:
   - Ý đúng phạm vi bài, đã verify THIẾU thật -> chèn theo đúng 3 tiêu chí chất lượng ở BƯỚC 6
     (self-contained, giọng khác robot, có thể tự nhiên) + BƯỚC 3B bước 5 (không liệt kê trần
     trụi, không stuffing).
   - Ý gần nghĩa nhưng KHÔNG khớp đúng sự thật/phạm vi bài (vd từ khoá gợi ý 1 dạng nội dung PR
     khác hẳn dạng bài đang nói, như "diễn văn/bài phát biểu" so với "bài PR báo chí") -> KHÔNG
     ép nó là cùng 1 khái niệm hay bịa thêm 1 "dạng bài PR" mới không có thật. Thay vào đó viết
     1 câu/FAQ **phân biệt rõ 2 khái niệm** - vừa đáp ứng người tìm kiếm đúng cụm đó, vừa không
     sai sự thật (`content-professional.md`).
   - Ý ngữ nghĩa quá mơ hồ/rác sau bước 1 -> bỏ qua, không chèn gì, nêu rõ trong báo cáo là đã
     loại vì lý do gì (không im lặng bỏ qua).
4. Đăng lại theo đúng BƯỚC 7, verify từng cụm đã chèn xuất hiện thật trên live (đếm cả biến thể
   viết hoa/thường, có dấu/không dấu nếu cần).
5. Trong báo cáo (BƯỚC 8), thêm 1 bảng riêng liệt kê MỌI dòng trong danh sách Hiếu đưa (không
   chỉ dòng đã chèn) kèm cách xử lý: đã có sẵn / đã chèn (trích câu) / loại vì không đúng sự
   thật / loại vì rác ngữ nghĩa - để Hiếu thấy đã xử lý hết danh sách, không sót dòng nào.

## BƯỚC 3C - ĐO ĐỘ DÀI BÀI + SỐ ẢNH ĐỐI THỦ (bổ sung 2026-08-10)

Ngoài thực thể (BƯỚC 3) và từ khoá cùng cụm (BƯỚC 3B), phải đo 2 chỉ số định lượng để căn
chỉnh "độ dày nội dung" bài mình đúng chuẩn đối thủ đang được xếp hạng cho từ khoá này - không
chỉ đủ Ý mà còn đủ KHỐI LƯỢNG nội dung. Benchmark này tính CHO CẢ CỤM dịch vụ (áp dụng mọi
bài trong cụm, không phải riêng 1 URL) - **trước khi research mới, kiểm tra bảng benchmark
trong `content-visual-coverage.md` mục "Chuẩn định lượng theo CỤM dịch vụ" xem cụm + ĐÚNG LOẠI
TRANG (hub tổng quan hay trang con theo đối tượng cụ thể - xem bước 0 dưới) này đã có dòng
chưa và còn mới (≤60 ngày) không; có rồi thì DÙNG LUÔN, chỉ research lại (bước 1-4 dưới) khi
chưa có benchmark đúng loại trang hoặc benchmark đã cũ/SERP đổi mạnh.**

0. **Xác định loại trang trước khi research** - bài đang audit/viết là trang HUB tổng quan cả
   cụm dịch vụ, hay trang CON đi sâu 1 đối tượng cụ thể (vd 1 đầu báo, 1 loại dịch vụ con)?
   2 loại có độ dài/số ảnh khác hẳn nhau, không được trộn chung.
1. **Research đúng mẫu của loại trang đó, đo TRÊN NHIỀU DOMAIN, không dừng ở 1 trang/domain**:
   - Với trang HUB: dùng lại đúng bộ URL đã fetch ở BƯỚC 2 (từ khoá dịch vụ tổng quát).
   - Với trang CON: phải tìm thêm cấu trúc trang con tương ứng của TỪNG domain đối thủ đã có ở
     BƯỚC 2 bằng `site:<domain> "<mẫu tiêu đề trang con>" <2-3 đối tượng cụ thể mẫu>` (vd
     `site:seodo.vn "báo giá bài pr trên" vnexpress`) - domain nào có cấu trúc trang con y hệt
     Digicom (đa số domain lớn trong ngành booking báo/guest post đều có) thì fetch thêm 3-5
     trang con của domain đó (không cần vét hết, đủ đại diện); domain không có cấu trúc này chỉ
     tính 1 mẫu (trang hub) của họ. Mục tiêu tối thiểu ~20-25 trang con gộp từ nhiều domain để
     trung vị đáng tin, không phải 8-10 mẫu như 1 trang/domain.
2. Với MỖI trang đã fetch (dùng lại HTML đã tải ở BƯỚC 2, chỉ fetch thêm phần trang con mới):
   - **Số từ**: dùng bản text thuần thân bài đã strip ở BƯỚC 3.1, đếm bằng tách khoảng trắng
     (`len(text.split())`) - CHỈ tính phần nội dung chính, loại bỏ header/footer/menu/sidebar/
     quảng cáo/phần lặp lại giống nhau ở nhiều trang cùng site trước khi đếm.
   - **Số ảnh**: đếm thẻ `<img>` trong CÙNG phạm vi thân bài dùng để đếm từ (không tính icon/
     logo lặp ở header/footer, banner quảng cáo rõ ràng không phải ảnh minh hoạ nội dung).
3. Lập bảng `domain | trang | số từ | số ảnh` TÁCH RIÊNG theo loại trang (hub / con), tính cho
   MỖI loại:
   - **Trung vị (median)** số từ và số ảnh - ưu tiên trung vị hơn trung bình, tránh 1 bài quá
     dài/quá nhiều ảnh kéo lệch số liệu.
   - **Giá trị cao nhất** (bài dài nhất, nhiều ảnh nhất) - biết trần thực tế đối thủ đang làm.
   - **Khoảng phổ biến nhất** (đa số đối thủ rơi vào khoảng nào, vd 1.200-1.500 từ) - đây là
     MỤC TIÊU ưu tiên áp dụng, không chạy theo giá trị cao nhất một cách máy móc (bài dài nhất
     có thể là ngoại lệ, không đại diện chuẩn chung).
4. Đếm số từ + số ảnh HIỆN TẠI của bài Digicom bằng đúng phương pháp trên (bản text đã strip
   ở BƯỚC 1) để so sánh công bằng, đối chiếu ĐÚNG dòng benchmark theo loại trang (hub/con) của
   chính bài đó. CHẾ ĐỘ B (bài chưa tồn tại) bỏ qua bước này, dùng số liệu đối thủ làm mục tiêu
   ngay khi dàn bài (xem BƯỚC B3).
5. Kết luận:
   - Bài Digicom NGẮN HƠN/ÍT ẢNH HƠN khoảng phổ biến đúng loại trang -> gap ĐỊNH LƯỢNG, ghi rõ
     số liệu (vd "đối thủ trung vị trang con 1.343 từ/18 ảnh, bài hiện có 890 từ/2 ảnh - thiếu
     ~450 từ và 16 ảnh so với mức phổ biến").
   - Bài đã BẰNG hoặc DÀI HƠN mức phổ biến -> không cần thêm cho đủ số lượng.
6. Research mới (không tái dùng benchmark cũ) -> ghi/cập nhật ĐÚNG dòng (theo loại trang) trong
   bảng benchmark của `content-visual-coverage.md` (từ khoá đại diện, số mẫu, trung vị từ/ảnh,
   ngày đo) để các bài SAU trong cùng cụm VÀ cùng loại trang dùng lại, không research trùng lặp.

### Áp dụng khi bổ sung (nối vào BƯỚC 6)

- Số từ/số ảnh thiếu theo BƯỚC 3C **không phải lý do để viết filler**. Đây chỉ là NGƯỠNG THAM
  CHIẾU để biết còn bao nhiêu dư địa nội dung THẬT có thể thêm - không bịa đoạn văn vô nghĩa
  để đạt đúng số từ mục tiêu (`quality-bar.md` - chống filler/scope creep).
  - Ưu tiên: nếu checklist BƯỚC 4 có nhiều mục C1 cần viết và bài đang thiếu độ dài so đối
    thủ -> viết ĐẦY ĐỦ các mục đó (đừng viết tắt 1 câu cho có) để tự nhiên tiệm cận mức phổ
    biến, thay vì thêm đoạn không có thực thể/thông tin mới chỉ để đủ số từ.
  - Đã viết đủ hết mục C1/C2 thật mà VẪN ngắn hơn nhiều so với đối thủ -> báo rõ cho Hiếu,
    không tự ý thêm nội dung không có nguồn/không có thực thể mới.
- Số ảnh thiếu -> đối chiếu `content-visual-coverage.md` (tối thiểu 2 ảnh/bài + mọi H2 có yếu
  tố trực quan) và `image-sourcing.md` (nguồn Storyset/ảnh thật) - thêm đúng vị trí H2 đang
  thiếu visual, không thêm ảnh không liên quan chỉ để đủ số lượng.

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

## BƯỚC 6B - MỤC "TÀI LIỆU THAM KHẢO" CUỐI BÀI (bổ sung 2026-08-11, bắt buộc mọi bài)

Hiếu chốt 2026-08-11: MỌI bài (refresh lẫn viết mới) phải có 1 mục **"Tài liệu tham khảo"**
ở CUỐI bài (ngay trước hoặc sau "Kết luận"), liệt kê link tới các nguồn liên quan/uy tín đã
dùng khi viết - không chỉ link rải rác trong thân bài như C2 ở BƯỚC 5.

1. **Nguồn đưa vào mục này**: mọi nguồn THẬT đã đọc/trích dẫn khi viết/refresh bài - gồm cả
   nguồn tiếng Việt (BƯỚC 2) lẫn nguồn quốc tế (BƯỚC 2C) đã dùng để lấy thông tin/số liệu/
   định nghĩa. KHÔNG liệt kê nguồn chưa từng đọc thật hoặc chỉ đoán tên cho có
   (`content-professional.md`).
2. **Định dạng**: danh sách `<ul>` cuối bài, mỗi dòng là 1 link `<a>` kèm tên nguồn + mô tả
   ngắn (1 câu) nội dung nguồn đó nói gì/dùng để làm gì trong bài. Ví dụ:
   ```html
   <li><a href="https://searchengineland.com/..." target="_blank" rel="nofollow noopener">Search Engine Land</a> - phân tích gốc về thay đổi thuật toán AI Overview, dùng làm căn cứ cho mục "Vì sao...".</li>
   ```
3. **`rel="nofollow noopener"`** cho MỌI link trong mục này (khác link C2 trong thân bài có
   thể dofollow nếu là nguồn luật/gov theo `external-link-eeat.md`) - đây là danh sách tham
   khảo tổng hợp, không phải trích dẫn có chủ đích 1 khái niệm cụ thể, nên mặc định nofollow
   trừ khi nguồn đó đã dofollow ở đâu đó trong thân bài rồi (không lặp lại 2 kiểu rel khác
   nhau cho cùng 1 URL trong cùng 1 bài).
4. **Số lượng**: tối thiểu 3 nguồn cho bài viết mới (Chế độ B), tối thiểu 2 nguồn khi refresh
   bài cũ (Chế độ A) nếu bài gốc chưa có mục này. Không giới hạn tối đa, nhưng chỉ liệt kê
   nguồn THỰC SỰ đã dùng - không nhồi thêm cho đủ số.
5. **Không trùng** `khong-link-doi-thu.md` - không đưa agency/brand đối thủ trực tiếp cùng
   ngành PR/backlink/booking báo vào mục này dù đã đọc bài của họ khi research SERP (BƯỚC 2);
   chỉ đưa nguồn kiến thức/dữ liệu trung lập hoặc tổ chức không cạnh tranh trực tiếp.
6. Bài ĐÃ CÓ mục "Tài liệu tham khảo" từ trước (refresh lần 2 trở đi) -> bổ sung thêm nguồn
   MỚI phát sinh trong lần refresh này (không tạo mục thứ 2, không xoá nguồn cũ trừ khi phát
   hiện nguồn đó đã chết/sai - verify HTTP 200 trước khi thêm bất kỳ link nào, theo BƯỚC 2).

## BƯỚC 7 - BACKUP + ĐĂNG LIVE

1. Backup: `content.raw` GỐC (đã lấy ở BƯỚC 1) -> lưu
   `~/Claude-Workspace/_backups/routines/<ngày>/entity-refresh/post<ID>-BEFORE.json` +
   1 dòng manifest (rule `routine-backup.md`).
2. Đăng: `python3 tools/wp-rest-publish.py update --id <ID> --content-file <file-moi>`.
3. Verify: `curl -s "<url-bai>" | grep -o "<chuoi-dac-trung-vua-them>"` cho TỪNG thực thể
   đã thêm - phải thấy xuất hiện thật trên live, không chỉ tin đã update thành công.
4. **Tự động ép Google index lại** - hook `save_post` trong theme
   (`.claude/rules/gsc-sitemap-submit.md`) tự bắt lúc `update` này và lên lịch gọi
   Indexing API cho đúng URL bài (không cần gọi tay). Chỉ cần gọi tay
   `./submit-sitemap.sh <url-bai>` khi muốn xác nhận NGAY LẬP TỨC thay vì chờ cron chạy
   (~15s-1 phút tuỳ tần suất truy cập site kích hoạt WP-Cron), hoặc khi `gsc_submit_on`
   đang tắt.

## BƯỚC 8 - BÁO CÁO (bắt buộc đủ, theo `explain-after-done.md`)

1. Danh sách đối thủ đã fetch OK / fetch lỗi (nêu rõ domain nào lỗi, không im lặng bỏ qua).
2. **Bảng dạng bài + tiêu đề đối thủ (BƯỚC 2B)**: title/H1/dạng từng đối thủ, tỷ lệ dạng
   chiếm đa số, pattern tiêu đề (số/năm/cụm mở đầu lặp lại), kết luận bài hiện tại KHỚP hay
   LỆCH dạng - nếu lệch, nêu rõ đề xuất riêng (không tự đổi).
3. Bảng checklist thực thể đầy đủ (BƯỚC 4) - không chỉ liệt kê thực thể đã thêm, phải cho
   thấy cả những thực thể ĐÃ CÓ SẴN (để Hiếu biết đã verify kỹ, không phải qua loa). Ghi rõ
   nguồn từng dòng là "đối thủ" (BƯỚC 3) hay "từ khoá cùng cụm" (BƯỚC 3B).
4. Bảng định tuyến C1/C2 (BƯỚC 5).
5. Bảng đo độ dài/số ảnh đối thủ (BƯỚC 3C): số từ + số ảnh từng đối thủ, trung vị/cao nhất/
   khoảng phổ biến, so với số từ/ảnh bài hiện tại, kết luận có bổ sung độ dài/ảnh hay không.
6. Trích nguyên văn từng câu đã chèn vào bài (như 2 lần chạy tay trước đó Hiếu đã yêu cầu
   "trích dẫn câu mà thực thể mới được chèn vào").
7. Link live đã verify.

## Khi bài không có gap thật

Nếu sau BƯỚC 4 không có thực thể nào verify là THIẾU thật sự (đã xảy ra với bài
`agency-booking-bao-chi` 2026-08-09) -> KHÔNG ép thêm nội dung filler. Báo rõ đã quét bao
nhiêu đối thủ, bảng đối chiếu đầy đủ, kết luận bài đã phủ đủ - dừng ở báo cáo, không sửa
bài (`quality-bar.md` - chống scope creep/filler).

---

# CHẾ ĐỘ B - VIẾT BÀI MỚI (bổ sung 2026-08-10)

Dùng khi chủ đề/từ khoá CHƯA có bài nào trên digicomvn.com (khác Chế độ A - không có bài
gốc để đối chiếu). Tái dùng nguyên BƯỚC 2 (research SERP lấy thực thể), BƯỚC 2C (research
nguồn quốc tế), BƯỚC 3 (trích thực thể mức từ), BƯỚC 3B (từ khoá cùng cụm), bộ 3 tiêu chí
chất lượng và BƯỚC 6B (mục "Tài liệu tham khảo" cuối bài, bắt buộc ≥3 nguồn cho bài mới) ở
BƯỚC 6 phía trên - KHÔNG viết lại các phần đó, chỉ thêm phần research SÂU HƠN (do là bài
mới, không phải vá 1 đoạn) và phần tạo bài/đăng mới thay vì update.

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
3. **Phân tích tiêu đề + dạng bài đang top (bắt buộc, dùng nguyên BƯỚC 2B của Chế độ A - đọc
   lại nếu cần chi tiết)**: với mỗi kết quả top 10, lấy `<title>` thật + H1 thật, phân loại
   dạng theo `audit-intent-truoc.md` (listicle/how-to/định nghĩa/so sánh/thương mại/case
   study), lập bảng `URL | title | H1 | dạng`. Đếm tỷ lệ dạng chiếm đa số, trích PATTERN
   tiêu đề cụ thể: có số không (số phổ biến nhất là bao nhiêu, vd "Top 10", "15 cách"), có
   năm không, cụm mở đầu lặp lại ("Top...", "N Cách...", "X Là Gì?", "Hướng Dẫn...", "So
   Sánh..."), độ dài tiêu đề trung bình. Đây KHÔNG phải bước tham khảo - kết quả này là ĐẦU
   VÀO BẮT BUỘC cho tiêu đề + cấu trúc H2 ở BƯỚC B3 (vd top 10 đa số là listicle "Top N X" ->
   bài mới cũng phải đặt tiêu đề có số + cấu trúc H2 dạng liệt kê từng mục, không viết tuyến
   tính như 1 bài định nghĩa).
4. Thực hiện lại BƯỚC 2/3/3B/3C (research thực thể mức từ + từ khoá cùng cụm + đo độ dài/số
   ảnh đối thủ) trên đúng bộ URL top 10 này - không cần research riêng 2 lần. Vì chưa có bài
   hiện tại để so sánh, BƯỚC 3C chỉ lấy trung vị/khoảng phổ biến số từ + số ảnh của đối thủ
   làm MỤC TIÊU cho bài mới (dùng ở BƯỚC B3).

## BƯỚC B2d - KHUNG ENTITY-ATTRIBUTE-VALUE GỐC (bổ sung 2026-08-12, chạy TRƯỚC BƯỚC B3)

> Lý do thêm bước này: BƯỚC 3/3B của skill trích thực thể TỪ đối thủ (lấp gap), còn BƯỚC B2.3
> dựng tiêu đề/H2 THEO dạng đối thủ đang top - cả 2 đều xuất phát từ đối thủ trước. Nếu chỉ làm
> vậy, bài vẫn là "tổng hợp lại top 10 rồi viết theo" (information gain gần 0, đúng thứ Google
> không thưởng theo nghiên cứu Ahrefs 2026-06 - xem DECISIONS/báo cáo liên quan). Bước này bắt
> bài phải có 1 khung nội dung ĐỘC LẬP dựng từ kiến thức ngành thật của Digicom TRƯỚC, rồi mới
> đối chiếu đối thủ (B2.3, B3, B4) để bổ sung - không phải ngược lại.

1. **Xác định Entity trung tâm** của bài: đúng 1 danh từ/cụm từ là chủ đề cốt lõi (vd "booking
   báo VnExpress", "textlink", "DR - Domain Rating"), lấy từ chính từ khoá chính, không suy diễn
   từ đối thủ.
2. **Liệt kê Attribute nội tại của Entity đó** - thuộc tính THẬT mà bất kỳ ai hiểu đúng ngành
   backlink/booking báo/PR đều biết phải có, dựa trên dữ liệu thật đã sẵn có trong dự án
   (KHÔNG đoán, lấy từ các nguồn đã có sẵn: `bang-gia-booking.md`/CPT `dgc_gia` cho giá-vị trí-
   quy cách, `entity-seo-checklist.md`/brand-info cho NAP/pháp lý, `dich-vu.md` cho phạm vi dịch
   vụ). Ví dụ Attribute cho Entity "1 đầu báo cụ thể": vị trí đăng (trang chủ/chuyên mục), giá,
   thời gian lên bài, loại link (dofollow/nofollow), DR, đối tượng độc giả phù hợp, hạn chế nội
   dung (không nhận ngành gì). Ví dụ cho Entity "dịch vụ Textlink": số lượng site, thời hạn đặt
   (3/6/12 tháng), vị trí (home/chuyên mục/fullsite), tiêu chí chọn site (DR/traffic).
3. **Gán Value thật** cho từng Attribute - số liệu/dữ kiện thật của Digicom (giá thật, DR thật,
   quy cách thật), không gán giá trị đối thủ hay giá trị bịa. Attribute nào Digicom chưa có dữ
   liệu thật -> để trống, KHÔNG bịa (theo `content-professional.md`).
4. Khung Entity-Attribute-Value này (bảng `Attribute | Value | Nguồn dữ liệu`) là XƯƠNG SỐNG nội
   dung - mỗi Attribute có Value thật nên trở thành 1 đoạn/H2 riêng trả lời đúng 1 câu hỏi, viết
   theo format "[Entity] có [Attribute] là [Value]" ở câu mở đoạn (khớp tiêu chí GEO/AEO đã có ở
   BƯỚC 6a - format CMU "[Thực thể] là [loại] mà [đặc điểm phân biệt]").
5. **Sau khi có khung này mới chạy BƯỚC B2.3 (dạng bài đối thủ) và B3 (dàn bài)** - lúc đó đối
   thủ chỉ dùng để: (a) kiểm khung Attribute ở bước 2 có thiếu Attribute quan trọng nào đối thủ
   đều nói mà mình bỏ sót không (bổ sung THÊM, không thay thế khung gốc), và (b) xác định
   tiêu đề/hình thức trình bày (listicle/how-to...) theo B2.3. Thứ tự đúng: khung EAV riêng
   trước -> đối chiếu đối thủ để lấp thiếu sót -> mới viết. KHÔNG được đảo ngược (đọc đối thủ
   rồi tổng hợp lại thành dàn bài, sau đó mới nghĩ thêm Attribute cho có).

## BƯỚC B3 - DÀN BÀI (bắt buộc trước khi viết, theo `do-dont.md`)

0. **Tiêu đề + cấu trúc H2 chính PHẢI khớp dạng đa số đã xác định ở BƯỚC B2.3** - đây là ưu
   tiên hàng đầu, đứng trước cả việc gán visual hay đủ thực thể. Ví dụ: đối thủ đa số là
   listicle "Top N X" -> tiêu đề bài mới cũng ở dạng liệt kê có số, H2 là từng mục trong danh
   sách (không viết tuyến tính kiểu định nghĩa/giải thích khái niệm); đối thủ đa số là how-to
   -> tiêu đề dạng "Cách..."/"Hướng dẫn...", H2 là các bước tuần tự. Số trong tiêu đề (nếu có)
   lấy theo số phổ biến nhất đã đếm được, không tự chọn số tuỳ ý. Sai dạng thì dù đủ thực thể/
   độ dài cũng khó cạnh tranh với nhóm đang top - đây chính là lý do BƯỚC B2.3 tồn tại.
0b. **Trong SỐ các biến thể tiêu đề cùng khớp đúng dạng ở bước 0, ưu tiên biến thể có
   allintitle THẤP NHẤT** (chốt Hiếu 2026-08-11) - đúng dạng chỉ là điều kiện cần, allintitle
   thấp mới quyết định độ dễ lên top thực tế (ít trang cùng nhồi đúng cụm từ đó trong title).
   Quy trình:
   1. Từ dàn bài dạng đã chọn (bước 0), liệt kê 2-4 biến thể tiêu đề khả dĩ (đổi thứ tự từ,
      từ đồng nghĩa, có/không kèm năm, có/không kèm địa danh...) - tất cả vẫn phải đúng dạng
      nội dung và đúng từ khoá chính, không đổi ý nghĩa chỉ để hạ allintitle.
   2. Check allintitle từng biến thể: `python3 tools/allintitle-check.py "<biến thể 1>" "<biến thể 2>" ...`
      (tự fallback Google CSE -> SerpApi -> Serper theo key có sẵn trong
      `.claude/secrets/allintitle-keys.json`).
   3. **Cả 3 nguồn đều lỗi/hết key** (đã xảy ra thật 2026-08-11 - CSE API chưa bật cho
      project, SerpApi/Serper thiếu key) -> KHÔNG dừng lại, tự PHÁN ĐOÁN allintitle qua 2 tín
      hiệu gián tiếp đã có sẵn từ BƯỚC B2 (Hiếu xác nhận cách làm này 2026-08-11):
      - **Volume từ khoá** (đã có trong file keyword/sheet Hiếu cung cấp, hoặc suy từ tần suất
        cụm từ lặp lại trong các trang top research được) - volume càng THẤP, allintitle có xu
        hướng càng THẤP (ít nội dung được sản xuất nhắm đúng cụm từ đó).
      - **Độ khó cạnh tranh** (số đối thủ mạnh/agency lớn đã ra bài đúng cụm từ này ở BƯỚC B2,
        và mức độ TRÙNG LẶP cụm từ trong chính title các đối thủ đó - đếm bằng
        `grep -c "<cụm từ>"` trên các file HTML đã fetch) - độ khó càng THẤP (ít đối thủ, cụm
        từ ít lặp lại y hệt trong title họ), allintitle có xu hướng càng THẤP.
      - Nguyên tắc suy luận: volume thấp + độ khó thấp -> allintitle nhiều khả năng bé (ít
        trang cạnh tranh + ít nhu cầu sản xuất nội dung đúng cụm đó). Đây là suy đoán ĐỊNH
        TÍNH thay thế tạm thời, không phải số liệu chính xác - ghi rõ trong báo cáo là "ước
        lượng qua volume/độ khó, không phải allintitle đo được thật" để Hiếu phân biệt với số
        liệu thật từ BƯỚC 2.
   4. Chọn biến thể allintitle thấp nhất (đo được thật, hoặc ước lượng theo bước 3) trong nhóm
      đã liệt kê. Allintitle bằng nhau hoặc chênh không đáng kể (< ~20% khác biệt) -> ưu tiên
      biến thể tự nhiên/đúng volume Ahrefs cao hơn thay vì chênh lệch allintitle nhỏ không
      đáng đổi.
   5. Ghi kết quả check (biến thể + số allintitle thật HOẶC ước lượng, ghi rõ loại nào) vào báo
      cáo BƯỚC B7 - không chỉ chốt tiêu đề mà không cho Hiếu thấy đã so sánh gì.
1. Dàn bài phải: đủ như top 10 (không thiếu khía cạnh đối thủ đã có), có phần ĐỘC NHẤT
   (theo tiêu chí (c) information gain ở BƯỚC 6), trả lời trực diện ngay đầu mỗi mục.
2. Gán loại visual cho MỖI H2 ngay từ bước dàn bài (ảnh Storyset/ảnh thật, sơ đồ HTML, bảng
   dữ liệu, hoặc widget tương tác) - theo `content-visual-coverage.md`, tối thiểu 2 ảnh +
   mọi H2 có yếu tố trực quan. Tối thiểu 3 sơ đồ HTML cho đoạn phức tạp (`content-diagram-explain.md`).
3. Mục tiêu độ dài bài + tổng số ảnh bám theo **khoảng phổ biến** đối thủ đã đo ở BƯỚC 3C
   (không chạy theo giá trị cao nhất một cách máy móc) - phân bổ số ảnh mục tiêu đều cho các
   H2 theo dàn bài, không dồn hết vào 1-2 mục rồi để H2 khác trống visual.
3. Dàn ý KHÔNG được rập khuôn 1 khuôn cố định nếu viết nhiều bài liên tiếp trong cùng cụm -
   đổi thứ tự mục/cách mở bài giữa các bài để tránh đọc như 1 công thức (đúng tinh thần mục
   "giọng viết khác robot" ở BƯỚC 6b, áp cả cho cấu trúc toàn bài chứ không chỉ câu văn).

## BƯỚC B4 - VIẾT BÀI ĐẦY ĐỦ

0. **BẮT BUỘC: dòng ĐẦU TIÊN của content là `<h1>{tiêu đề bài}</h1>`**, khớp `post_title`,
   TRƯỚC SAPO (thứ tự `H1 -> SAPO -> Tóm tắt nhanh -> mở bài -> H2...` như Chế độ A/`do-dont.md`).
   `single.php` KHÔNG tự render H1 từ `post_title` - thiếu bước này thì cả trang không còn
   H1 nào (sự cố thật 2026-08-10: bài `hieu-lam-booking-bao-chi` + `booking-bao-tinh` viết
   qua Chế độ B, đăng thẳng `status:publish`, thiếu H1 hoàn toàn vì BƯỚC B6 lúc đó chưa có
   dòng verify H1 tường minh - đã bổ sung ở BƯỚC B6.1 dưới). Trước khi đăng
   (BƯỚC B5), tự kiểm `grep -c '<h1' <file-content>` phải ra đúng `1`.
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
   POST trực tiếp `wp/v2/posts` với Basic Auth) - **`status: publish` ngay, đăng luôn**
   (Hiếu chốt 2026-08-10, ghi đè quyết định "mặc định draft" ban đầu 2026-08-10 - lý do:
   mỗi bài đã đi đủ BƯỚC B1-B4 (research SERP top 10, dàn bài, viết theo 3 tiêu chí chất
   lượng) trước khi tới bước này, không cần thêm 1 lớp duyệt draft nữa).
2. Log 1 dòng vào manifest ngày hiện tại (`routine-backup.md`) với loại sửa = "created" (bài
   mới không có bản gốc để backup, chỉ cần ghi nhận đã tạo).
3. Điền đủ SEO meta (`dgc_seo_title`/`dgc_seo_desc` - BƯỚC B4.4) VÀ gán category/`dgc_nhom`
   đúng cụm dịch vụ TRƯỚC khi publish - đăng thẳng nghĩa là không có bước duyệt sau để bắt
   thiếu sót này.

## BƯỚC B6 - VERIFY (KHÔNG được bỏ qua dòng 1 - đây là gate bắt buộc)

1. Verify bài đã publish thành công: `curl -s "https://digicomvn.com/wp-json/wp/v2/posts/<ID>?_fields=id,slug,status,link"`
   - PHẢI thấy `status:"publish"`, không dừng ở "tạo xong" nếu vẫn còn draft.
   - **Ngay sau đó: `curl -s <link> | grep -o '<h1[^>]*>' | wc -l` PHẢI ra đúng `1`.** Ra `0`
     -> trang không có H1 nào (xem BƯỚC B4.0) - quay lại chèn H1, update lại bài, chưa được
     báo xong. Đây là bước bắt buộc chạy thật, không phải kiểm tra qua loa bằng mắt.
2. Verify visual coverage thật trên live (đủ ảnh/sơ đồ mỗi H2, không vỡ dark mode - theo
   `content-visual-coverage.md` + `ui-mau-sac.md`), verify schema
   (`tools/schema-vocab-check.py`).
3. Verify từng thực thể/từ khoá cùng cụm đã chèn xuất hiện thật trên live (như BƯỚC 7.3 của
   Chế độ A) - không chỉ tin bản nháp.
4. **Tự động ép Google index bài mới** - hook `save_post` trong theme
   (`.claude/rules/gsc-sitemap-submit.md`) tự bắt lúc `create` này, không cần gọi tay. Muốn
   xác nhận ngay thay vì chờ cron: `./submit-sitemap.sh <url-bai-vua-tao>`.

## BƯỚC B7 - BÁO CÁO

1. Chủ đề, từ khoá chính, dạng nội dung đã xác định (theo BƯỚC B2.3).
2. Danh sách 10 đối thủ đã research (fetch OK/lỗi).
2b. **Bảng tiêu đề + dạng bài đối thủ (BƯỚC B2.3)**: title/H1/dạng từng đối thủ, tỷ lệ dạng
   chiếm đa số, pattern tiêu đề (số/năm/cụm mở đầu), và tiêu đề + dạng đã CHỌN cho bài mới -
   đối chiếu rõ đã khớp dạng đa số hay có lý do chủ động lệch (nêu lý do nếu có).
2c. **Bảng allintitle các biến thể tiêu đề đã so sánh (BƯỚC B3.0b)**: liệt kê từng biến thể +
   số allintitle, đánh dấu biến thể đã chọn + lý do (thấp nhất, hoặc gần bằng nhưng volume
   cao hơn).
3. Dàn bài đã dùng (danh sách H2 + loại visual gán cho từng H2).
4. Bảng thực thể/từ khoá cùng cụm đã chèn (như BƯỚC 4 của Chế độ A).
5. Số từ/số ảnh trung vị + khoảng phổ biến của đối thủ (BƯỚC 3C) và số từ/ảnh thực tế của
   bài mới vừa viết - đối chiếu 2 con số này để Hiếu biết bài đã đạt "độ dày" chuẩn đối thủ
   hay chưa.
6. Link bài đã LIVE (đã verify status publish) + xác nhận đã lên internal link vào cụm liên
   quan nếu phù hợp (không tạo bài mồ côi - theo tinh thần đợt internal-link 2026-08-09).

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
