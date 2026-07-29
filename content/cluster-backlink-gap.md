# Sổ cái cụm CONTENT: Backlink gap (đợt 2026-07-27) - digicomvn.com

> Nguồn kế hoạch: `plan-pr-tongquat-2026-07-27.md` mục "Ưu tiên CAO - cụm Backlink" (B1-B5).
> Khác `content/cluster-backlink.md` (sổ cái cụm Backlink cũ, tạo 2026-07-20) - file đó theo
> dõi gap phát hiện đợt trước (anchor text, toxic, disavow, audit, referring domain...). B1
> ở đây trùng đúng dòng #6 "Backlink Audit" của sổ cái cũ - đã cập nhật chéo cả 2 file khi B1
> xong, tránh 2 nơi lệch trạng thái.

## Trạng thái tổng: 5/5 bài - CỤM HOÀN THÀNH

| # | Bài | URL | Volume | Trạng thái | Ngày | Ghi chú |
|---|---|---|---|---|---|---|
| B1 | Backlink Audit: Cách Phân Tích Backlink Profile Đối Thủ Và Website | `/backlink-audit/` | 610 | ✅ Xong | 2026-07-27 | Post ID 4739, category `backlink-offpage` (14). 9 H2, 7 H3. 3 sơ đồ HTML (4 trigger "khi nào cần audit", quy trình 7 bước, so sánh 2 cột lành mạnh/khả nghi) + 1 bảng `.dgc-data-table` (7 chỉ số kèm ngưỡng) + 2 ảnh Storyset (storyset-analysis.png, storyset-datareport.png, tái dùng ảnh đã có sẵn trên site, credit đủ) + widget `[dgc_offpage_quiz]` + chip-grid công cụ + chip-grid FAQ. Internal link (5, đúng giới hạn, mỗi URL 1 lần): `/dich-vu-backlink/` (money page), `/kiem-tra-backlink/`, `/co-nen-mua-backlink-khong/`, `/ty-le-anchor-text-chuan/`, `/backlink-dofollow-va-nofollow/`. Link ngược đã thêm vào 224 (kiem-tra-backlink) và 4226 (co-nen-mua-backlink-khong); bổ sung 2026-07-27 (khi làm B3): thêm link ngược tới `/disavow-backlink/` (thay câu "sẽ có hướng dẫn riêng" bằng link thật). Thumbnail đã gắn (attachment 4740). GSC: KHÔNG submit được - phiên trình duyệt không có sẵn session Google đã đăng nhập, không tự động đăng nhập hộ (rule bảo mật). |
| B2 | Backlink Indexer: Cách Index Backlink Nhanh Nhất 2026 | `/backlink-indexer/` | 350 | ✅ Xong | 2026-07-27 | Post ID 4751, category `backlink-offpage` (14). 8 H2, 7 H3. 1 card-grid (4 lý do Google không tự index) + 1 card-grid quy trình 4 bước Digicom + 1 card-grid cảnh báo 2 cột (nên dùng/nên tránh) + 1 bảng `.dgc-data-table` (6 phương pháp index kèm tốc độ/rủi ro) + 2 ảnh Storyset MỚI tải trực tiếp từ storyset.com (File Searching - Rafiki, Connected World - Rafiki, màu #407bff khớp brand, credit đủ; upload thẳng vào `wp-content/uploads/2026/07/` không qua media import, giống cách B1 đã làm) + widget `[dgc_offpage_quiz]` + 2 chip-grid (cách kiểm tra index, FAQ). Internal link (5, mỗi URL 1 lần): `/dich-vu-backlink/` (money page), `/backlink-audit/` (B1), `/kiem-tra-backlink/`, `/co-nen-mua-backlink-khong/`, `/backlink-dofollow-va-nofollow/`. Thumbnail đã gắn (attachment 4754, `wp media import --featured_image`) - phải chạy `wp cache flush` + `litespeed-purge all` sau khi gắn, nếu không og:image LiteSpeed cache vẫn trả ảnh cũ. GSC: KHÔNG submit được - không có session Google đăng nhập sẵn trong trình duyệt phiên này (cùng tình trạng B1/B4). |
| B3 | Disavow Backlink: Cách Xử Lý Backlink Xấu, Toxic, Spam | `/disavow-backlink/` | 270 | ✅ Xong | 2026-07-27 | Post ID 4749, category `backlink-offpage` (14). 10 H2 (định nghĩa toxic/spammy/manipulative, dấu hiệu nhận biết, Disavow Tool là gì, định dạng file .txt, quy trình 6 bước, NÊN/KHÔNG NÊN, sai lầm thường gặp, tự làm hay thuê, FAQ, tổng kết), 5 H3 FAQ. Visual: 1 bảng `.dgc-data-table` (7 dấu hiệu x mức rủi ro x hành động), 1 sơ đồ HTML quy trình 6 bước, 1 sơ đồ breadcrumb vị trí công cụ trong GSC, 1 code-block ví dụ file disavow.txt, 1 bảng so sánh 2 cột NÊN/KHÔNG NÊN, 2 chip-grid (sai lầm thường gặp, tự làm/thuê), 2 ảnh Storyset tái dùng (storyset-agency-warning-1.webp ID 4618, analysis-rafiki.webp ID 4736, credit chung storyset.com cuối bài) + widget `[dgc_offpage_quiz]`. Glossary icon "i" cho PBN (`[thuatngu]`, chưa có bài riêng trên site). External link E-E-A-T: support.google.com/webmasters/answer/2648487 (dofollow, trích nguyên văn điều kiện disavow của Google) + ahrefs.com/blog/toxic-backlinks/ (nofollow, trích John Mueller + Marie Haynes). Internal link (5, mỗi URL 1 lần): `/dich-vu-backlink/` (money page), `/backlink-audit/` (B1), `/co-nen-mua-backlink-khong/`, `/kiem-tra-backlink/`, `/google-penguin/`. Link ngược đã thêm vào 4739 (backlink-audit) và 224 (kiem-tra-backlink, thay đoạn tóm tắt 3 bước cũ bằng link sang bài đầy đủ). Thumbnail đã gắn (attachment 4750). Verify: curl 200, 1 H1, 0 em/en dash, 6 internal link 200, widget/table/glossary render đúng trên live. GSC: KHÔNG submit được - phiên trình duyệt không có session Google đăng nhập (search.google.com/search-console redirect ra landing page marketing, không phải console thật). |
| B4 | Các Loại Backlink: Tier 1/2/3, PBN, Thủ Công Và Công Cụ | `/cac-loai-backlink/` | 360 | ✅ Xong | 2026-07-27 | Post ID 4746, category `backlink-offpage` (14). 10 H2, 8 H3. 3 sơ đồ HTML (kim tự tháp Tier 1/2/3, PBN lợi ích ngắn hạn/rủi ro thật 2 cột, quy trình 3 bước chọn backlink an toàn) + 1 quy trình 3 bước HARO + 1 bảng `.dgc-data-table` (7 loại backlink kèm độ an toàn/khuyến nghị) + 2 ảnh Storyset tái dùng (storyset-booking-quocte-network.webp id 4626 credit connected-world/bro, storyset-agency-warning-1.webp id 4618 credit warning/rafiki) + widget `[dgc_offpage_quiz]` (giữa bài, sau PBN) + 3 chip-grid (tiêu chí phân loại, nền tảng Web 2.0, FAQ). PBN và GSA viết theo tinh thần giải thích + cảnh báo rủi ro, KHÔNG hướng dẫn triển khai (external link dẫn Google Search Central Spam Policies). Internal link (5, đúng giới hạn, mỗi URL 1 lần): `/backlink-audit/`, `/kiem-tra-backlink/`, `/backlink-quoc-te/`, `/guest-post/`, `/dich-vu-backlink/` (money page). Link ngược đã thêm vào post 4226 (co-nen-mua-backlink-khong, backup trước khi sửa tại `~/Claude-Workspace/_backups/routines/2026-07-27/backlink-cluster-B4/post-4226-before.html`). Thumbnail đã gắn (attachment 4747). GSC: KHÔNG submit được - phiên trình duyệt không có sẵn session Google đã đăng nhập (kiểm tra search.google.com/search-console ra trang landing chưa đăng nhập), không tự động đăng nhập hộ (rule bảo mật). |
| B5 | Backlink Từ Mạng Xã Hội: Facebook/YouTube/Pinterest Có Tính SEO Không | `/backlink-mang-xa-hoi/` | 260 | ✅ Xong | 2026-07-27 | Post ID 4759, category `backlink-offpage` (14). 9 H2, 5 H3. Visual: 1 sơ đồ 2-khối (backlink truyền thống vs mạng xã hội), 1 sơ đồ timeline nofollow (2005/2019/2020), 1 sơ đồ funnel 5 bước (chia sẻ MXH → backlink dofollow biên tập thật), 1 quy trình 4 bước "tận dụng đúng cách", 1 card-grid so sánh (tự đăng MXH vs Social Entity) - tổng 5 sơ đồ/card-grid (vượt mức tối thiểu 3). 2 bảng `.dgc-data-table` (8 nền tảng dofollow/nofollow; case study DA Pinterest 3 website) + 2 ảnh Storyset MỚI tải trực tiếp từ storyset.com (Social Media - Rafiki id 4757, Social Growth - Rafiki id 4758, giữ nguyên màu gốc #407BFF khớp brand, credit đủ, upload qua `wp media import` nên có wp-image-id chuẩn) + widget `[dgc_offpage_quiz]` (giữa bài, sau quy trình 4 bước) + 2 chip-grid (timeline nofollow, FAQ). Phân biệt rõ với trang dịch vụ `/backlink-social-entity/` (đã đọc live trước khi viết): bài này là nội dung KIẾN THỨC "MXH có tính SEO không", trang kia là DỊCH VỤ bán gói social entity - bài dẫn về dịch vụ ở mục "khi nào nên đầu tư bài bản" thay vì trùng lặp nội dung. Internal link (5, đúng giới hạn, mỗi URL 1 lần): `/dich-vu-backlink/` (money page), `/cac-loai-backlink/` (B4, liên kết vai trò Tier), `/backlink-indexer/` (B2, index nhanh hơn), `/kiem-tra-backlink/` (theo dõi hiệu quả), `/backlink-social-entity/` (dịch vụ, kết luận) - cả 5 verify HTTP 200. External link: Wikipedia Nofollow (dofollow, lịch sử 2005) + Google Search Central blog chính thức 9/2019 (dofollow, xác nhận nofollow thành "hint" từ 3/2020) + MarketingLad (nofollow, bảng nền tảng) + The Comma Mama Co. (nofollow, case study Pinterest DA - có số liệu cụ thể theo rule trích dẫn). Thumbnail đã gắn (attachment 4760, `dgc-thumb-4759.png`), đã `wp cache flush` + `litespeed-purge all`. Verify: curl 200, 1 H1, 0 em/en dash, 2 bảng, 1 widget quiz, 2 ảnh Storyset render đúng, wordCount 3013. GSC: KHÔNG submit được - search.google.com/search-console redirect ra landing page marketing, không có session Google đăng nhập sẵn trong phiên trình duyệt (cùng tình trạng B1-B4). |

**CỤM BACKLINK GAP HOÀN THÀNH 5/5 BÀI (2026-07-27).** Toàn bộ B1-B5 đã publish, đủ visual coverage,
internal link nối vào money page `/dich-vu-backlink/` và liên kết chéo giữa các bài trong cụm
(B1↔B3, B1→B4→B5 qua mô hình Tier, B2↔B5 qua chủ đề index). GSC submit: không bài nào submit được
trong 5 phiên làm việc do thiếu session Google đăng nhập trong trình duyệt - cần Hiếu tự submit
sitemap hoặc đăng nhập Google trong trình duyệt trước khi chạy batch content tiếp theo nếu muốn
tự động submit GSC.

## Research SERP - B1 (bắt buộc theo `seo-content-report.md`)

- **Search intent**: Informational/how-to. WebSearch "backlink audit là gì" + "cách audit
  backlink profile" + "how to audit backlink profile step by step" - top kết quả VN
  (vietmoz.edu.vn, seothetop.com, vidcogroup.com) và quốc tế (backlinko.com, ahrefs.com) đều
  là bài hướng dẫn quy trình nhiều bước, không phải trang dịch vụ hay listicle.
- **Đã research SERP**: WebFetch đầy đủ backlinko.com/step-by-step-backlink-audit (quy trình 5
  bước + bảng 5 công cụ) và ahrefs.com/blog/backlink-audit/ (chỉ số Referring Domains, DR,
  Anchor Text branded ratio, TLD phân bố, dấu hiệu spam). Đối chiếu thêm bài đã có trên site
  (224 kiem-tra-backlink) để xác định góc KHÁC BIỆT bắt buộc (rule `audit-intent-truoc.md`):
  224 là review công cụ + hướng dẫn thao tác GSC/Ahrefs + 3 bước gỡ backlink xấu/disavow; B1
  là QUY TRÌNH audit 7 bước + bảng chỉ số kèm ngưỡng - không lặp lại phần thao tác công cụ hay
  hướng dẫn disavow chi tiết (để dành cho B3).
- **Allintitle**: KHÔNG check được - không có công cụ nào trong phiên này trả về số đếm
  allintitle thật (Ahrefs/Semrush MCP kết nối không hỗ trợ operator này, đây vốn là toán tử
  riêng của Google không có trong API của các công cụ SEO). Không bịa số.
- **Info gain**: (1) Bảng 7 chỉ số kèm ngưỡng tốt/cần chú ý - cả bài 224 lẫn 2 nguồn quốc tế
  đã fetch đều không có bảng ngưỡng tổng hợp dạng này; (2) phân biệt rõ vai trò với bài công cụ
  đã có trên site (điều đối thủ không cần làm vì họ không có 2 bài riêng biệt); (3) số liệu
  anchor text dẫn nhất quán về bài `/ty-le-anchor-text-chuan/` đã có sẵn trên site thay vì bịa
  số mới có thể mâu thuẫn.

## Research SERP - B3 (bắt buộc theo `seo-content-report.md`)

- **Search intent**: Informational/how-to. WebSearch "disavow backlink là gì" + "cách sử dụng
  Google Disavow Tool" + "toxic backlink checker cách disavow" + "how to disavow backlinks
  google search console 2026" - top kết quả VN (sapo.vn, seongon.com, vietnix.vn, vinalink.edu.vn,
  nhanhoa.com) và quốc tế (wedevs.com, t-ranks.com, themeisle.com) đều là bài hướng dẫn thao tác
  từng bước, không phải trang dịch vụ.
- **Đã research SERP**: WebFetch trực tiếp trang chính thức Google Search Central
  (support.google.com/webmasters/answer/2648487 - lấy đúng URL công cụ, định dạng file, điều
  kiện nên/không nên dùng nguyên văn) + Ahrefs (ahrefs.com/blog/toxic-backlinks/ - phân biệt
  spammy/manipulative/toxic link, quote John Mueller và Marie Haynes, case mất 60% traffic vì
  disavow bừa bãi) + seongon.com (đối chiếu cấu trúc bài đối thủ VN: 5 mục, ~10 phút đọc, nhiều
  ảnh chụp màn hình thao tác). Đối chiếu bài đã có trên site (224 kiem-tra-backlink, đang có sẵn
  mini-section 3 bước disavow rất ngắn) để xác định góc KHÁC BIỆT (rule `audit-intent-truoc.md`):
  224 chỉ tóm tắt 3 bước cơ bản; B3 đào sâu phần 224 KHÔNG có - định dạng file .txt đầy đủ
  (domain: vs URL, giới hạn 2.048 ký tự/100k dòng/2MB), ranh giới NÊN/KHÔNG NÊN theo đúng tuyên
  bố của Google, và các sai lầm thường gặp khi disavow.
- **Allintitle**: KHÔNG check được - không có công cụ nào trong phiên trả về số đếm allintitle
  thật (toán tử riêng của Google, không có trong API Ahrefs/Semrush MCP). Không bịa số.
- **Info gain**: (1) Bảng dấu hiệu x mức rủi ro x hành động cụ thể (7 dòng) - đối thủ VN đã đọc
  chỉ liệt kê dấu hiệu chung chung, không phân tầng rủi ro rõ ràng; (2) trích dẫn CÓ NGUỒN tuyên
  bố chính thức của Google "hầu hết website không cần dùng disavow" - phần lớn bài VN không nêu
  rõ điều này, dễ khiến người đọc disavow quá tay; (3) cảnh báo case thật (60% traffic drop, dẫn
  nguồn Ahrefs) làm bằng chứng cụ thể cho rủi ro lạm dụng, thay vì chỉ nói chung chung "cẩn thận".

## Research SERP - B4 (bắt buộc theo `seo-content-report.md`)

- **Search intent**: Informational, dạng bài phân loại/giải thích khái niệm (không phải listicle
  domain cụ thể, không phải trang dịch vụ). WebSearch "các loại backlink là gì", "backlink tier
  1 2 3 là gì", "pbn là gì rủi ro seo" - top kết quả VN (mona.media, gtvseo.com, connecttech.vn,
  seosona.com, seothanhcong.vn) và quốc tế (loganix.com, blackhatworld.com) đều là bài giải
  thích/phân loại khái niệm off-page, đúng dạng bài đã viết.
- **Đã research SERP**: WebFetch loganix.com/tiered-link-building (cấu trúc Tier 1/2/3, DR
  benchmark từng tầng, rủi ro tiered link building) và gtvseo.com/pbn-la-gi (dấu hiệu Google
  phát hiện PBN qua SpamBrain, hậu quả bị phạt). Đối chiếu bài đã có trên site (4226
  co-nen-mua-backlink-khong đã nhắc PBN/SpamBrain ở góc độ rủi ro khi MUA; B4 khác góc: phân
  loại đầy đủ TẤT CẢ loại backlink theo tầng + cách tạo, không chỉ PBN) - tránh trùng lặp theo
  rule `audit-intent-truoc.md`.
- **Allintitle**: KHÔNG check được - không có công cụ nào trong phiên này trả về số đếm
  allintitle thật (Ahrefs/Semrush MCP không hỗ trợ operator này). Không bịa số.
- **Info gain**: (1) Bảng so sánh 7 loại backlink kèm độ an toàn + khuyến nghị trong CÙNG một
  bài - đối thủ VN đã fetch/search chỉ liệt kê danh sách phẳng, không có ma trận an toàn; (2)
  gộp đúng cụm kỹ thuật nâng cao ít ai viết tiếng Việt đầy đủ (GSA, ping, HARO) cùng khung phân
  loại Tier, thay vì tách rời từng khái niệm; (3) PBN/GSA viết theo hướng cảnh báo có dẫn nguồn
  chính sách spam của Google (thay vì chỉ liệt kê chung chung "rủi ro" như đa số bài đối thủ).

## Research SERP - B2 (bắt buộc theo `seo-content-report.md`)

- **Search intent**: Informational/how-to. WebSearch "backlink indexer là gì cách index backlink
  nhanh nhất" + "free backlink indexer tool 2026" - top kết quả VN (vinalink.edu.vn, idigi.vn,
  minhduongads.com, tungphat.com, danaseo.net) đều là bài liệt kê phương pháp/cách làm (dạng
  "X cách index backlink"), khớp đúng dạng bài đã viết (liệt kê phương pháp + bảng so sánh).
- **Đã research SERP**: WebFetch vinalink.edu.vn/thu-vien-kien-thuc/cach-index-backlink-nhanh-nhat
  (8 phương pháp: social bookmark, social share, web 2.0, satellite site, tool ép index có tên
  cụ thể Sinbyte/1HPing/Larindex, ping, quảng cáo, Google News - bài KHÔNG đề cập bất kỳ cảnh báo
  rủi ro nào cho auto-index), indexbolt.com/blog/free-backlink-indexer-tools (cảnh báo rõ: free
  mass indexing tools "most are spam-based", "harm your SEO", "no reliable free method for bulk
  indexing in 2026"), schemawriter.ai/6-budget-friendly-backlink-indexing-tools (tên công cụ trả
  phí thật: PrimeIndexer, Linklicious, OneHourIndexing, Indexification - dùng làm dẫn chứng tên
  tool có thật, không bịa).
- **Allintitle**: KHÔNG check được - không có công cụ nào trong phiên này trả về số đếm allintitle
  thật (Ahrefs/Semrush MCP không hỗ trợ operator này). Không bịa số.
- **Info gain**: (1) Cảnh báo rủi ro auto-index hàng loạt CÓ DẪN CHỨNG cụ thể (spam footprint,
  nguồn quốc tế) - đối chiếu vinalink.edu.vn (đối thủ top đầu) hoàn toàn không có cảnh báo này;
  (2) bảng so sánh 6 phương pháp kèm CẢ tốc độ lẫn rủi ro trong cùng 1 bảng - đối thủ VN chỉ liệt
  kê phẳng không đánh giá; (3) làm rõ kỹ thuật "xây thêm 1 tầng link trỏ tới trang chứa backlink"
  (tier link building thu nhỏ) - phương pháp bền vững nhất nhưng đối thủ VN không giải thích cơ
  chế, chỉ liệt kê tên; (4) không lặp lại phần thao tác chi tiết GSC/Ahrefs đã có ở bài 224
  (kiem-tra-backlink), chỉ dẫn link sang đó theo rule `audit-intent-truoc.md`.

## Money page đích của cụm
`/dich-vu-backlink/` (dịch vụ chính, page ID 268).

## Liên quan
`content/cluster-backlink.md` - sổ cái gốc cụm Backlink (2026-07-20), theo dõi các bài gap khác
(anchor text đã xong, referring domain/disavow/toxic/PBN chưa viết). B2/B4/B5 ở đây là gap MỚI
phát hiện đợt gap-scan toàn site 2026-07-27, chưa từng có trong sổ cái cũ.
