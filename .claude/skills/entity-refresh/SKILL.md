---
name: entity-refresh
description: >
  Research thực thể (entity) CHI TIẾT ở mức từ/cụm từ (không phải ý chung chung) từ đối
  thủ đang top Google cho 1 bài digicomvn.com, đối chiếu bài hiện có, tự bổ sung thực thể
  còn thiếu và đăng thẳng lên live. Input: 1 URL bài trên digicomvn.com (+ từ khoá tuỳ
  chọn). Trigger: "entity-refresh <url>", "research thực thể bài <url> rồi bổ sung",
  "chạy entity refresh cho <url>".
---

# Entity Refresh - digicomvn.com

Quy trình 1 lệnh: dán URL bài -> research đối thủ -> trích thực thể MỨC TỪ/CỤM TỪ ->
đối chiếu bài -> tự viết bổ sung -> đăng live -> báo cáo. Dựa trên phương pháp luận của
skill global `entity-extraction-seo` (đọc file đó nếu cần nhắc lại 6 nhóm thực thể) nhưng
đóng gói thành pipeline chạy thẳng, không dừng lại ở báo cáo.

**Khác biệt bắt buộc so với review chung chung**: không chấm "gap ở mức khái niệm" (kiểu
"đối thủ có nói về minh bạch giá") mà phải chỉ ra **đúng TỪ/CỤM TỪ NGẮN** đối thủ dùng
(vd `AEO`, `GEO`, `dofollow`, `VAT`, `Longform`, `E-E-A-T`, `schema`, `canonical`...) và
verify bằng cách grep/tìm trực tiếp trong bài mình xem từ đó CÓ XUẤT HIỆN CHỮ hay không -
không suy diễn "ý này chắc đã có rồi" bằng cảm tính.

## Input

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

## BƯỚC 4 - GỘP CHECKLIST + ĐỐI CHIẾU TỪNG TỪ (bắt buộc verify bằng tìm chuỗi thật)

1. Union toàn bộ thực thể theo BƯỚC 3, đếm tần suất (bao nhiêu/N đối thủ có).
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
   thấy cả những thực thể ĐÃ CÓ SẴN (để Hiếu biết đã verify kỹ, không phải qua loa).
3. Bảng định tuyến C1/C2 (BƯỚC 5).
4. Trích nguyên văn từng câu đã chèn vào bài (như 2 lần chạy tay trước đó Hiếu đã yêu cầu
   "trích dẫn câu mà thực thể mới được chèn vào").
5. Link live đã verify.

## Khi bài không có gap thật

Nếu sau BƯỚC 4 không có thực thể nào verify là THIẾU thật sự (đã xảy ra với bài
`agency-booking-bao-chi` 2026-08-09) -> KHÔNG ép thêm nội dung filler. Báo rõ đã quét bao
nhiêu đối thủ, bảng đối chiếu đầy đủ, kết luận bài đã phủ đủ - dừng ở báo cáo, không sửa
bài (`quality-bar.md` - chống scope creep/filler).

## Liên quan
- `entity-extraction-seo` (skill global) - phương pháp luận gốc, 6 nhóm thực thể, BƯỚC C
  định tuyến C1/C2. Skill này là bản đóng gói chạy thẳng riêng cho digicomvn.com.
- `khong-link-doi-thu.md`, `content-professional.md`, `external-link-eeat.md` (rules
  project + global) - ràng buộc bắt buộc khi viết/link.
- `routine-backup.md` (global) - backup trước khi ghi đè.
- `tools/wp-rest-publish.py` - script đăng bài dùng ở BƯỚC 7.
