# Plan cụm Backlink - 2026-07-20 (v2, sau khi gom nhóm bộ từ Hiếu đưa)

Nguồn: 485 từ khoá Hiếu paste trực tiếp (broad-match "backlink", không kèm volume/intent -
khác file CSV `backlink_broad-match_vn_2026-07-02.csv` đã dùng ở v1) + đối chiếu 34 bài đang
publish category `backlink-offpage` trên live (check qua `wp post list --s=...`).

## A. LOẠI KHỎI PHẠM VI - 291/485 từ (60%), có lý do rõ, không bịa

| Nhóm | Số từ | Lý do loại |
|---|---|---|
| Tool/brand ngoại (Ahrefs, Semrush, Ubersuggest, Moz, Majestic, Mangools, Linkody, RankWatch, SearchAtlas...) | 30 | Digicom là đơn vị BÁN backlink, không phải reviewer công cụ. 5 tool đã có bài riêng ở cụm SEO tổng quát (ahrefs, ahrefs-vs-semrush, semrush, majestic-seo, trust-flow) - không viết thêm. |
| "backlink checker/check backlink..." (mọi biến thể tool kiểm tra) | 34 | Đã có bài `kiem-tra-backlink` (ID 224) phủ đúng intent - viết thêm là tự cannibal. |
| Blackhat/spam tool (rapid url indexer, tier 1/2 backlinks, web 2.0, backlink generator/automation/builder ai, money robot, bulk backlink...) | 43 | Trái whitehat position của Digicom ("Không PBN" - đã tuyên bố ở bài 227). Không dạy kỹ thuật spam/tự động hoá. Đã có bài cảnh báo tool tự động (`phan-mem-di-back-link` ID223). |
| Ngoại ngữ khác (Pháp/Bồ/Tây Ban Nha/Ý/Hindi/Indonesia/Đức/Thổ...) | 30 | Site chỉ phục vụ thị trường VN. |
| Nền tảng khác (YouTube/Instagram/TikTok/Pinterest/LinkedIn/Reddit/Amazon/Etsy/podcast) | 20 | Ngoài phạm vi backlink báo chí/guest post/textlink - đã có bài Social Entity (230) cho mảng social. |
| Obsidian/Notion/OneNote "backlink" | 14 | **False positive** - đây là tính năng liên kết ghi chú trong app, không phải backlink SEO. |
| Số/rác (100/1000/5000 backlink, backlink 301, backlink 3d, backlink com, tier...) | 19 | Query rác/domain thương hiệu khác, không phải nhu cầu nội dung thật. |
| Còn lại trong nhóm "rest" - tool feature lẻ (backlink sheet/repository/tracker/monitor/mint/masterminds/io, backlink html code, backlink icon...), MCQ/quiz nước ngoài, framework code (nextjs backlink)... | ~101 | Rác kỹ thuật/không xác định được nhu cầu content thật, không tách bài riêng. |

## B. ĐÃ CÓ BÀI PHỦ ĐÚNG (194/485 từ) - không viết thêm, chỉ là biến thể đồng nghĩa

| Cụm ý nghĩa | Bài đã có (ID - URL) | Từ khoá gộp vào (ví dụ) |
|---|---|---|
| Định nghĩa backlink | `backlink` (235) | backlink là gì, backlinks, what is backlink, backlink definition, backlink meaning, backlink ví dụ, backlink vs hyperlink... |
| Mua/bán backlink | `co-nen-mua-backlink-khong` (4226) | mua backlink, mua backlink chất lượng, bán backlink, buy backlink, backlink price, backlink marketplace... |
| Backlink báo | `mua-backlink-bao-la-gi` (4228), `dich-vu-backlink-tong-quan` (227) | backlink báo, backlink báo chí, dịch vụ backlink báo chí |
| Đi backlink / xây dựng | `back-link-hieu-qua` (232), `back-link-chat-luong` (234) | đi backlink, đặt backlink, xây dựng backlink, cách tạo backlink, backlink strategy... |
| Diễn đàn backlink | `dien-dan-di-backlink` (225) | diễn đàn đi backlink, danh sách diễn đàn backlink |
| Dofollow/nofollow | `backlink-dofollow-va-nofollow` (231) | backlink dofollow, backlink nofollow, high pr backlink |
| Gov/Edu | `back-link-gov` (233) | edu gov backlink, backlink edu |
| Bất động sản | `backlink-bat-dong-san` (1276) | backlink bất động sản, backlink chất lượng bất động sản |
| Social/Entity | `backlink-social` (230), `dich-vu-entity` (226) | backlink mạng xã hội, social backlink, entity backlink |
| Guest post | `guest-post-la-gi` (544), `quy-trinh-trien-khai-guest-post` (1281) | guest post backlink |
| Kiểm tra backlink | `kiem-tra-backlink` (224) | check backlink, kiểm tra backlink website |
| Tool tự động | `phan-mem-di-back-link` (223) | backlink generator/builder/automation (phần liên quan tool) |

## C. GAP THẬT - CHƯA có bài, đúng intent dịch vụ, đã verify qua SERP + WP-CLI search live

| # | Cụm từ khoá | Tiêu đề đề xuất | Intent (SERP) | Cạnh tranh | Ưu tiên |
|---|---|---|---|---|---|
| 1 | backlink profile, backlink profile meaning/list, good backlink profile, natural backlink profile, backlink quality/quantity/ranking/placement/platform | Backlink Profile Là Gì? Cách Xây Dựng Hồ Sơ Backlink Lành Mạnh | Informational | SERP ít true-match (chỉ DGM Asia, DanaSEO đúng chủ đề) - **dễ top nhất trong 3** | **P0** |
| 2 | pbn backlink | PBN Là Gì? Vì Sao Digicom Chọn Backlink Báo/Guest Post Thay Vì PBN | Informational | Nhiều agency lớn đã viết (GTV SEO, SEODO, SEOViP...) - cạnh tranh cao, nhưng góc "đơn vị bán dịch vụ giải thích vì sao né PBN" là differentiator riêng, khớp tuyên bố có sẵn ở bài 227 | P0 |
| 3 | backlink anchor text | Anchor Text Là Gì? Tỷ Lệ Anchor Chuẩn Khi Mua Backlink/Guest Post | Informational | Rất nhiều agency SEO viết (Vietnix, GTV SEO, SeONGon...) - cạnh tranh cao nhất trong nhóm, cần góc thực chiến (áp dụng khi mua dịch vụ) mới có info gain | P0 (kèm lợi ích phụ: nâng cấp 1/3 thuật ngữ đang chỉ có icon "i" chưa có bài riêng, theo `external-link-eeat.md`) |
| 4 | backlink xấu, backlink xấu là gì, toxic backlink, backlink spam, spam backlink, backlink bẩn là gì | Backlink Xấu (Toxic Backlink) Là Gì? Dấu Hiệu Và Cách Xử Lý | Informational | Chưa research SERP riêng - làm ở batch 2 | P1 |
| 5 | backlink disavow tool, disavow backlink, how to disavow a backlink | Disavow Backlink Là Gì? Khi Nào Cần Dùng Google Disavow Tool | Informational | Chưa research SERP riêng - làm ở batch 2 | P1 |
| 6 | audit backlink, backlink gap/gap analysis/research/report/overview/history | Backlink Audit Là Gì? Quy Trình Tự Kiểm Tra Hồ Sơ Backlink Định Kỳ | Informational | Cần phân biệt rõ với `kiem-tra-backlink` (224, dạng tool-list 1 lần) - góc mới: quy trình audit định kỳ. Rủi ro cannibal nếu không tách rõ - cần thận trọng khi viết | P2 |
| 7 | backlink vs referring domain | Referring Domain Là Gì? Khác Backlink Như Thế Nào? | Informational | Chưa research SERP riêng | P2 (nâng cấp glossary term thứ 2/3) |
| 8 | backlink quốc tế, backlink báo quốc tế | (chờ quyết định: bài blog hỗ trợ trang dịch vụ `/backlink-quoc-te/` mới mở 14/7 - đã verify live CHƯA có bài nào) | - | Chưa research | P2 - hỏi Hiếu có muốn đưa vào cụm này không, vì đây là dịch vụ khác (Backlink quốc tế), không thuộc 4 dịch vụ giai đoạn 1 |

## Batch đề xuất

**Batch 1 (P0, ĐÃ DUYỆT 2026-07-20 - viết theo thứ tự này):**
Áp rule `feedback_allintitle-heuristic.md` (không đo được allintitle thật → ưu tiên title
dài/cụ thể, né head-term ngắn đông đối thủ):
1. **Tỷ Lệ Anchor Text Chuẩn Khi Mua Backlink/Guest Post Là Bao Nhiêu?** (thay vì "Anchor Text
   Là Gì" - né head-term ngắn 2-3 từ đông agency lớn)
2. **Vì Sao Backlink Báo Và Guest Post An Toàn Hơn PBN?** (thay vì "PBN Là Gì" - né head-term
   đông đối thủ, đi thẳng góc differentiator riêng của Digicom)
3. **Cách Xây Dựng Hồ Sơ Backlink (Backlink Profile) Lành Mạnh**

**Batch 2 (P1/P2, CHƯA research SERP - phải research trước khi viết):** #4 Backlink xấu/Toxic,
#5 Disavow, #6 Backlink Audit (cẩn thận cannibal với `kiem-tra-backlink`), #7 Referring Domain.
#8 Backlink quốc tế - CHỜ Hiếu xác nhận có thuộc phạm vi cụm này không (dịch vụ ngoài 4 dịch
vụ giai đoạn 1).

## Checkpoint
Batch 1 đã duyệt 2026-07-20 - sẵn sàng chạy bước 2-8 (chế độ B) cho từng bài, tối đa 3 bài/lượt.
Batch 2 cần research SERP đầy đủ (WebSearch top kết quả, không có allintitle thật) trước khi
trình lại cho Hiếu duyệt.
