---
name: content-pipeline
description: >
  Quy trình content + internal link TỰ ĐỘNG cho digicomvn.com. 2 chế độ:
  (A) BỘ TỪ KHOÁ: quét SERP từng keyword -> suy intent + loại bài -> gom cluster ->
  kế hoạch nội dung topic cluster -> viết loạt bài -> tự đi internal link pillar/cluster
  theo intent + hành trình khách. (B) BÀI ĐƠN: topic -> bài live (8 bước).
  Trigger: đưa file/bộ keyword, "viết bài <topic>", "chạy pipeline content".
---

# Digicom Content Pipeline - keyword -> topic cluster -> bài live -> internal link

Config nguồn sự thật: `.claude/context/brand-info.md` (đọc TRƯỚC, không hardcode).
Quy tắc viết: skill global `content-writer` + rule `content-professional`, `typography-dash`.
Tham khảo khung generic: `~/Claude-Workspace/_shared/skills/seo-content-pipeline/SKILL.md`.

---

# CHẾ ĐỘ A - BỘ TỪ KHOÁ (quy trình chính)

Input: file/danh sách keyword từ Hiếu (csv/xlsx/paste). Output cuối: kế hoạch nội dung
đã duyệt + loạt bài live + internal link nối cluster-pillar tự động.

## A1. QUÉT SERP TỪNG KEYWORD (không đoán intent theo chữ)

Với TỪNG keyword: WebSearch/Google, đọc 10 kết quả đầu (bỏ ads, bỏ digicomvn.com), ghi vào
bảng làm việc `content/keyword-serp-<ngày>.csv`:
- **Intent thật** theo SERP: informational / commercial / transactional / local / mixed
  (căn cứ trang đang top là blog, trang dịch vụ, bảng giá, danh mục hay tool).
- **Loại bài Google đang cho lên top**: hướng dẫn A-Z, listicle, so sánh, bảng giá,
  case study, tool/calculator, trang dịch vụ.
- **Cách tiếp cận đối thủ**: section chính, độ dài, có bảng/số liệu/FAQ/video không.
- **Gap**: đối thủ thiếu gì (số liệu VN, ví dụ thật, dữ liệu giá sống, công cụ tương tác).
- SERP features: AI Overview / Featured Snippet / PAA (lấy PAA làm FAQ sau này).
Keyword nào SERP toàn trang dịch vụ/bảng giá -> đích là MONEY PAGE hiện có, KHÔNG viết blog
cạnh tranh với chính mình.

## A1b. QUÉT SITEMAP + ALLINTITLE (bắt buộc trước khi lập plan - rule Hiếu 2026-07-17)

1. **Quét bài đã có**: đọc sitemap live (`wp-sitemap.xml` + `wp post list` qua SSH) lọc mọi
   URL/bài thuộc cụm keyword. Keyword nào đã có bài phủ đúng intent -> plan ghi
   **SỬA TRÊN BÀI ĐÓ** (giữ URL, bổ sung), TUYỆT ĐỐI không tạo bài mới trùng.
2. **Check allintitle** từng keyword mục tiêu (Google `allintitle:"<keyword>"`, lấy số kết quả):
   - Allintitle THẤP (vd <10-30) = ít bài chứa đúng cụm trong title -> DỄ TOP -> ưu tiên viết trước.
   - Dùng allintitle để ĐẶT TÍT: chọn biến thể cụm có allintitle thấp nhất mà vẫn đúng
     intent + volume, đưa nguyên cụm đó vào đầu title.
   - Ghi số allintitle vào bảng plan làm cột ưu tiên.

## A2. GOM CLUSTER + KẾ HOẠCH NỘI DUNG (checkpoint duyệt)

1. Gom keyword cùng intent + cùng SERP overlap (top 10 trùng >=3 URL = cùng bài) thành cluster.
   1 bài = 1 intent riêng, không tách 1 intent thành nhiều bài (rule publish-volume-warning).
1b. Plan phân loại rõ từng dòng: **MỚI** (chưa có bài phủ) vs **SỬA** (đã có bài - ghi URL
   bài hiện có). Mỗi dòng MỚI gen sẵn **URL lý tưởng** (slug ngắn, chứa keyword chính,
   flat `/[slug]/`, không dấu, khớp cấu trúc cụm).
2. Xếp hierarchy: **Pillar** (head term, tổng quát) - **Cluster** (modifier cụ thể) -
   **Supporting** (khái niệm/quy trình phụ). Map vào pillar THẬT đang có (brand-info mục 7)
   trước khi đề xuất pillar mới.
3. Với từng bài trong plan, chốt sẵn: tiêu đề (<=58 ký tự), search intent, loại bài,
   angle khác biệt + info gain cụ thể để hơn đối thủ, widget dự kiến, URL slug,
   category (1/11 chuyên mục), đích money page sẽ link tới.
4. Vẽ **sơ đồ internal link theo hành trình khách**:
   `Supporting (học) -> Cluster (cân nhắc) -> Pillar (tổng quan) -> Money page (mua)/-> /bang-gia/`
   - Cluster -> Pillar: 1 link/bài, anchor informational.
   - Pillar -> từng Cluster: anchor chủ đề cụ thể.
   - Cluster <-> Cluster liên quan: 2-3 link, không cross-cluster sai ngữ nghĩa.
   - Bài commercial -> money page bằng anchor thương mại; bài informational KHÔNG nhét
     anchor bán hàng cứng, dẫn qua pillar trước.
5. Xuất `content/plan-<cụm>-<ngày>.md`: bảng plan + sơ đồ link + volume/cảnh báo.
   **DỪNG chờ Hiếu duyệt plan** (checkpoint duy nhất của chế độ A). Duyệt xong các bước
   sau chạy tự động hết.

## A2c. CHỐNG ĂN THỊT TỪ KHOÁ - keyword cannibalization (rule Hiếu 2026-07-17)

Áp cho CẢ lúc lập plan lẫn lúc viết từng bài (chế độ A và B):

1. **1 primary keyword = 1 URL duy nhất trên toàn site.** Trước khi viết, search
   `site:digicomvn.com "<keyword>"` + quét title/H1 bài đã có: nếu đã có trang tối ưu cho
   keyword đó -> SỬA trang đó, không viết bài thứ hai.
2. **Phân vai blog vs money page**: keyword thương mại (dịch vụ, giá, agency...) thuộc về
   money page/bảng giá; bài blog KHÔNG đặt keyword thương mại đó vào title/H1 - blog nhắm
   biến thể informational ("là gì", "chi phí ... phụ thuộc gì", "cách chọn"). Tránh blog và
   trang dịch vụ cùng đua 1 từ.
3. **Title/H1 các bài trong cùng cluster không lặp cùng một cụm tối ưu.** Mỗi bài dùng biến
   thể riêng đã chia trong plan (căn allintitle). Keyword phụ cùng intent gộp làm semantic
   trong thân bài, không bao giờ tách thành bài mới.
4. **Anchor internal link phân vai**: anchor đúng primary keyword của trang ĐÍCH (anchor
   thương mại -> money page, anchor informational -> bài blog tương ứng) - không dùng anchor
   là primary keyword của bài A để trỏ về bài B, Google sẽ lẫn vai.
5. **Khi phát hiện 2 bài cũ đang ăn thịt nhau** (cùng phủ 1 intent): đề xuất vào plan hành
   động GỘP (bài yếu 301/redirect nội dung về bài mạnh) hoặc ĐỔI HƯỚNG bài yếu sang intent
   khác - cần Hiếu duyệt, không tự gộp/xoá.

## A2d. TỶ LỆ LOẠI ANCHOR TEXT - tối ưu NGAY LÚC ĐẶT LINK, không đợi audit sau (rule Hiếu 2026-08-10)

Mỗi khi chèn 1 internal link (bài mới, refresh bài cũ, hay A4 bên dưới), PHẢI tự phân loại
anchor sắp dùng vào 1 trong 5 loại và cân đối tỷ lệ THEO TỪNG TRANG ĐÍCH (không phải theo cả
site) - kiểm bằng `/internal-link-map <cụm>` (mục "Tỷ lệ loại anchor text") trước khi coi 1
cụm là xong:

| Loại | Định nghĩa | Tỷ lệ khuyến nghị/trang đích |
|---|---|---|
| Khớp chính xác | Anchor = đúng nguyên văn tiêu đề cốt lõi trang đích (trước dấu `:`/`-`/`?`) | 10-25% |
| Mô tả tự nhiên | Cụm từ đúng ngữ cảnh câu, không phải brand/thương mại thuần | 30-60% |
| Từ khoá thương mại | Chứa "dịch vụ/giá/đặt bài/chi phí" | 10-30% |
| Thương hiệu | Chứa "DigicomVN"/"Digicom" | 5-20% |
| Chung chung | "xem thêm/tại đây/bấm vào đây"... | 0-10% |

**Bắt buộc có "khớp chính xác"** - không phải 0%, vì Google cần ít nhất một số anchor nói
đúng từ khoá trang đích để hiểu quan hệ ngữ nghĩa; nhưng KHÔNG lạm dụng >25% (thao túng anchor,
áp dụng cả cho internal link chứ không chỉ backlink ngoài).

**Không nhồi 1 anchor y hệt cho nhiều bài nguồn khác nhau trỏ về CÙNG 1 trang đích** - đặc biệt
nguy hiểm với template/CTA lặp lại (vd nhiều bài "book-bao-X" cùng nhét 1 câu CTA y hệt trỏ về
money page). Quy tắc: nếu 1 trang đích có từ 3 link đến trở lên, tối thiểu 50% trong số đó phải
dùng anchor KHÁC NHAU (đo bằng `distinct_anchor / total_inbound >= 0.5`). Ngoại lệ: anchor
ngắn (<=3 từ) trùng tên riêng của chính trang đích (vd "CafeF", "VnExpress") không tính là lỗi
- đó là nhắc đúng tên, không phải nhồi từ khoá.

**Cách áp dụng khi viết bài mới/A3**: trước khi paste 1 câu CTA/link đã dùng ở bài khác cùng
cụm, đổi cách diễn đạt (không copy y nguyên) - xem cách các anchor variant đã dùng cho cùng 1
trang đích (chạy `/internal-link-map` hoặc đọc sổ cái cụm) để không lặp lại.

**Công cụ kiểm/audit**: `tools/internal-link-map.py` + `tools/internal-link-map-render.py`
(gọi qua lệnh `/internal-link-map <cụm>`) - tính tỷ lệ 5 loại + cờ cảnh báo trang đích có
<50% anchor khác nhau. Không đạt -> tự đa dạng hoá anchor (đổi TEXT hiển thị của thẻ `<a>`,
giữ nguyên href) theo đúng quy trình backup-before-edit, không cần hỏi lại nếu số bài cần sửa
nhỏ (<10); batch lớn hơn (nhiều chục bài, vd sửa cả 1 khối CTA template lặp) -> báo Hiếu số
lượng cụ thể trước khi làm, vì đây là thay đổi diện rộng.

## A3. VIẾT + ĐĂNG LOẠT BÀI

Chạy từng bài theo plan bằng các bước 2-6 của chế độ B bên dưới (research lại SERP chi tiết
khi viết, thứ tự H1 -> SAPO -> Tóm tắt, widget, thumbnail, đăng SSH). Tối đa 3 bài/lần chạy,
đăng dần theo ưu tiên trong plan (pillar/bài volume cao trước).

## A4. INTERNAL LINK TỰ ĐỘNG (điểm khác biệt của pipeline này)

Sau khi các bài của cluster đã live:
1. Dựng link graph THẬT: quét post_content các bài liên quan trên live (wp-cli),
   liệt kê link hiện có giữa các bài.
2. So với sơ đồ ở A2 -> danh sách link THIẾU và link SAI ĐÍCH (vd trỏ `/dich-vu/...` cũ,
   trỏ bài blog trùng slug thay vì page pillar - xem cảnh báo brand-info mục 7).
3. Tự chèn link thiếu vào bài cũ + bài mới: anchor là cụm từ CÓ SẴN trong câu (không nhét),
   mỗi URL 1 lần/bài, tối đa 5 internal link/bài, >=1 money page với bài commercial.
   Backup content.raw TỪNG bài trước khi sửa (routine-backup) + manifest. Anchor phải theo
   tỷ lệ 5 loại + không lặp y hệt cho nhiều bài trỏ cùng 1 đích - xem [[A2d]] TỶ LỆ LOẠI
   ANCHOR TEXT, áp dụng NGAY khi chèn, không đợi audit riêng.
4. Verify: mỗi link mới curl 200 đúng đích; cập nhật link graph vào
   `content/linkgraph-<cụm>-<ngày>.md` để lần sau đối chiếu.

## A5. BÁO CÁO
Tổng kết: số keyword quét, số cluster, bài đã đăng (URL), link đã chèn (từ đâu -> đâu,
anchor gì), link sai đã sửa, phần còn chờ (bài chưa viết theo plan). Append LOG.md 1 dòng.

---

# CHẾ ĐỘ B - BÀI ĐƠN (topic -> bài live)

Chạy tự động một mạch, chỉ dừng ở CHECKPOINT bước 1 khi topic chưa được Hiếu duyệt.

## BƯỚC 1 - NHẬN TOPIC + GATE (checkpoint duy nhất)

1. Input: topic/keyword từ Hiếu, hoặc lấy dòng đầu `content/queue.md` (nếu có).
2. Check trùng: `wp post list --post_type=post --s="<keyword>"` trên live + đối chiếu
   cụm pillar trong brand-info mục 7. Trùng intent với bài đã có -> chuyển sang chế độ
   REFRESH bài cũ (giữ 100% + bổ sung), không viết bài mới.
3. Rule `publish-volume-warning`: topic thuộc cụm ngách, hoặc batch >3 bài cùng cụm ->
   báo số liệu volume + số intent thật, CHỜ Hiếu xác nhận. Topic Hiếu đã chỉ định
   trực tiếp trong yêu cầu = ĐÃ DUYỆT, đi tiếp không hỏi.

## BƯỚC 2 - RESEARCH SERP (không báo cáo, dùng để viết)

WebSearch keyword chính -> đọc top 3-5 (bỏ digicomvn.com, bỏ ads):
intent, SERP features, section đối thủ có, 3-5 câu PAA làm FAQ, góc khác biệt.

## BƯỚC 3 - VIẾT BÀI (theo skill content-writer + đặc thù Digicom)

- **Thứ tự đầu bài (rule Digicom 2026-07-16, GHI ĐÈ mặc định skill):**
  `H1 -> SAPO -> Tóm tắt nhanh -> mở bài -> H2...`
- **BẮT BUỘC: dòng ĐẦU TIÊN của content phải là `<h1>{tiêu đề bài}</h1>`** (khớp `post_title`).
  Đây là điểm dễ quên nhất, hậu quả nặng nhất: `single.php` CHỦ ĐỘNG không tự render H1 từ
  `post_title` (tránh trùng H1 nếu content đã có) - nếu content thiếu H1, TOÀN TRANG không
  còn H1 nào (xấu SEO/accessibility, sự cố thật 2026-08-10: bài `hieu-lam-booking-bao-chi`
  + `booking-bao-tinh` đăng thiếu H1, lọt qua vì bỏ verify ở BƯỚC 8). Trước khi ghi file
  content ra để đăng (BƯỚC 6), tự kiểm bằng mắt/`grep -c '<h1' <file>` phải ra đúng `1` -
  ra `0` thì DỪNG, thêm H1 trước khi đăng; ra `>1` thì bỏ bớt (chỉ 1 H1/trang).
- Title <=58 ký tự, KW đầu; meta 140-160; slug flat `/[slug]/` (không /blog/).
- Nội dung cốt lõi là toplist (danh sách đếm được) -> H1/title PHẢI ghi rõ dạng toplist kèm số
  thật khớp số lượng liệt kê (vd "Top 8 Đầu Báo..."), KHÔNG đặt title mô tả chung chung - xem
  `.claude/rules/do-dont.md` mục "Title/H1 phải khớp DẠNG nội dung".
- Giọng E-E-A-T tác giả Đỗ Hiếu (brand-info mục 3), thương hiệu viết là **DigicomVN**.
- KHÔNG bịa: giá, tên đầu báo hợp tác, case study, số liệu không nguồn.
- Nhắc tới giá -> KHÔNG ghi số cứng trong text, dùng widget/bảng giá live (bước 4).
- **Bài có intent tìm GIÁ** (title/keyword chứa "giá/báo giá/bảng giá/chi phí", hoặc SERP là
  trang bảng giá): ĐẨY phần giá LÊN NGAY ĐẦU BÀI (rule Hiếu 2026-07-18) - bảng giá/khoảng giá +
  widget budget_calc đặt ngay sau SAPO/tóm tắt, TRƯỚC các đoạn giải thích dài. Người tìm giá
  phải thấy giá trong 1 màn hình đầu, không phải cuộn xuống cuối.
- Gạch "-", không "—"/"–". Không câu khẩu ngữ/meta lọt vào text hiển thị.
- **Không rập khuôn dàn bài một cách máy móc (rule Hiếu 2026-08-09)**: khung
  `H1 -> SAPO -> Tóm tắt nhanh -> mở bài -> H2...` và các mục bắt buộc (interactive, FAQ,
  giá đẩy lên đầu nếu đúng intent...) là XƯƠNG SỐNG bắt buộc giữ, KHÔNG được bỏ - nhưng bên
  TRONG khung đó phải biến hoá khéo léo giữa các bài để không đọc như bản sao nhau:
  - Thứ tự các mục con trong 1 H2, cách vào đề mỗi mục (câu hỏi/tình huống/số liệu/định
    nghĩa - đổi luân phiên, không mở đầu mọi mục bằng cùng 1 công thức).
  - Độ dài đoạn văn khác nhau giữa các bài (không phải bài nào cũng 3-4 câu/đoạn đều tăm
    tắp), số lượng H2/H3 linh hoạt theo nội dung thật có gì để nói, không ép đủ số mục cho
    "đẹp cấu trúc".
  - Vị trí đặt ví dụ cụ thể, câu chuyện thực tế, góc nhìn cá nhân của tác giả - không luôn
    rơi đúng 1 chỗ cố định (vd luôn ở cuối mỗi H2) mà xen linh hoạt theo mạch bài.
  - Đây là hệ quả tất yếu của tiêu chí "giọng viết khác robot" (xem `entity-refresh`
    SKILL.md mục BƯỚC 6) áp ở cấp ĐỘ CẤU TRÚC BÀI, không chỉ cấp câu/đoạn - dàn bài giống hệt
    nhau giữa nhiều bài cùng cụm là dấu hiệu AI-generated dễ nhận ra ở cấp vĩ mô, kể cả khi
    từng câu viết đã tự nhiên.
  - Tự kiểm trước khi đăng: đặt cạnh 1-2 bài đã đăng gần đây cùng dạng (vd cùng dạng "Book
    Báo X") - nếu thứ tự H2 và cách mở mỗi mục gần như y hệt nhau chỉ đổi tên riêng, phải
    biến hoá lại trước khi publish.

## BƯỚC 4 - INTERACTIVE BẮT BUỘC MỖI BÀI (rule Hiếu 2026-07-17)

**MỌI bài viết phải có ít nhất 1 yếu tố tương tác hấp dẫn**, chèn dạng Gutenberg
`<!-- wp:shortcode -->` tại điểm nghỉ mắt (sau H2 thứ 2-3), mỗi bài 1-2 widget:
- Ưu tiên 1: widget theme CÓ SẴN khớp chủ đề (bảng dưới) - dữ liệu sống, không số chết.
- Ưu tiên 2: bài không khớp widget nào -> TẠO shortcode tương tác mới trong theme
  (inc/widgets-blog.php + main.js + main.css, bump DGC_VER, deploy) khớp đúng nội dung bài
  (vd checklist chấm điểm, mini-quiz theo bài, bảng so sánh bấm lọc). Widget mới phải
  tái dùng được cho bài cùng dạng, KHÔNG bịa số liệu.

| Widget | Dùng khi bài về |
|---|---|
| `[dgc_dr_chart bao="<domain>"]` | một đầu báo cụ thể (bài book-bao-*) |
| `[dgc_budget_calc]` | chi phí/ngân sách/giá dịch vụ off-page |
| `[dgc_offpage_quiz]` | kiến thức nền, audit, "nên làm gì trước" |

Bài thuộc nhóm dịch vụ có bảng giá -> có thể nhắc người đọc sang `/bang-gia/` thay vì
liệt kê giá trong bài.

## BƯỚC 5 - ẢNH

- **Thumbnail**: generator có sẵn `tools/blog-thumbnail/`:
  `echo '[[<post_id>,"<title>"]]' | python3 render-illus.py` -> `out/v2-<id>-*.png` 1200x675
  (đăng xong có ID mới chạy - xem bước 6).
- **Ảnh minh hoạ trong bài**: theo rule `image-sourcing` - Storyset, khớp đúng chủ đề,
  đồng bộ style site, credit storyset.com cuối bài. Không có ảnh phù hợp -> bỏ qua,
  KHÔNG chèn placeholder.

## BƯỚC 6 - ĐĂNG LIVE

**Chọn cách theo môi trường đang chạy:**
- **Có SSH key `~/.ssh/id_ed25519` (máy Mac Hiếu)** -> dùng SSH + wp-cli (rule `deploy.md`), như cũ (mục A).
- **Không có SSH key (phiên di động/cloud qua Claude Code web/mobile)** -> dùng REST API qua
  `tools/wp-rest-publish.py` (mục B). Credential: `.claude/secrets/wp_app.json` (gitignored,
  Application Password user `admin`) - phải tồn tại trong repo/mirror đang mở, nếu thiếu thì
  báo Hiếu, KHÔNG tự bịa hay xin credential qua kênh khác.

### A. SSH Hostinger (wp-cli)
1. Upload nội dung: `wp post create` (hoặc `wp post update` nếu refresh) với
   `--post_status=publish --post_author=1`, content là Gutenberg blocks.
   Escape an toàn: ghi content ra file tạm, scp lên, `wp post create ... < file` hoặc
   `wp eval-file` (tránh vỡ quote khi truyền inline).
2. Gán category đúng 1 trong 11 chuyên mục blog (menu Blog đã tách category);
   bài dịch vụ off-page thường là `backlink-offpage` (24) hoặc `booking-bao-pr`.
3. Thumbnail: render theo ID -> scp lên -> `wp media import <png> --post_id=<ID> --featured_image`.

### B. REST API (`tools/wp-rest-publish.py`)
1. Bài mới: `python3 tools/wp-rest-publish.py create --title "..." --content-file bai.html
   --category-id <id> --status publish` -> trả về `id` + `link` live.
2. Refresh bài cũ: `python3 tools/wp-rest-publish.py update --id <ID> --content-file bai.html`.
3. Thumbnail: render PNG theo ID (BƯỚC 5) rồi
   `python3 tools/wp-rest-publish.py set-thumbnail --id <ID> --image-file out/v2-<id>-*.png`.
4. Category id tra theo danh sách chuyên mục (giống mục A).

### Backup (cả 2 cách)
Refresh bài cũ -> fetch `content.raw` TRƯỚC khi update (mục A: `wp post get --field=content`;
mục B: `python3 tools/wp-rest-publish.py get-raw --id <ID>`), lưu
`~/Claude-Workspace/_backups/routines/<ngày>/content-pipeline/` + 1 dòng manifest.md
(rule routine-backup). Nếu đang ở môi trường không truy cập được thư mục Claude-Workspace
(cloud/di động) -> lưu backup vào `_backups/routines/<ngày>/content-pipeline/` NGAY TRONG
repo dự án (đã gitignore theo `.gitignore` mục `_backups/`) rồi báo rõ vị trí thay thế.
Bài mới hoàn toàn -> ghi manifest "created".

## BƯỚC 7 - INTERNAL LINK (2 chiều)

- Trong bài mới: tối đa 5 link, >=1 money page, anchor tự nhiên trong câu,
  URL GỐC theo brand-info mục 4 (vd `/booking-bao-pr/` - KHÔNG dùng `/dich-vu/...` đã 301).
  Anchor theo đúng tỷ lệ 5 loại ở [[A2d]] - KHÔNG copy y nguyên 1 câu CTA đã dùng cho bài
  khác cùng cụm trỏ về cùng đích, phải đổi cách diễn đạt.
- Chiều ngược: chọn 1-2 bài cũ cùng cụm đang mạnh, chèn 1 link trỏ về bài mới
  (backup content.raw trước khi sửa).

## BƯỚC 7b - SUBMIT GOOGLE SEARCH CONSOLE (rule Hiếu 2026-07-17, bắt buộc sau khi đăng)

Mỗi bài đăng mới/sửa lớn xong -> submit index ngay:
1. Mở GSC qua Chrome thật (claude-in-chrome, tài khoản hieudx3107@gmail.com), property
   **URL-prefix `https://digicomvn.com/`** (KHÔNG phải sc-domain).
2. URL Inspection: dán URL bài -> "Request indexing" (Yêu cầu lập chỉ mục).
3. Batch nhiều bài: submit từng URL (GSC giới hạn ~10-12 request/ngày - vượt ngưỡng thì
   ghi lại các URL chưa submit vào plan để hôm sau submit tiếp; sitemap vẫn là kênh chính).
4. Ghi kết quả (đã submit / chờ quota) vào báo cáo cuối.

> **RankMath KHÔNG active** trên digicomvn.com - `<title>` do theme (core title-tag) dựng
> từ `post_title`. Đổi SEO title mà GIỮ label menu/H1: thêm ID vào `dgc_seo_title_map()`
> trong `functions.php` (đã có cho money page 475). Ghi `rank_math_*` meta = vô tác dụng.
> Chống ăn thịt: money page giữ head-term thương mại, bài blog dùng modifier ("cách chọn"/"là gì").

## BƯỚC 8 - VERIFY + LOG (bắt buộc trước khi báo xong - KHÔNG được bỏ qua)

- **`curl -s https://digicomvn.com/<slug>/ | grep -o '<h1[^>]*>' | wc -l` PHẢI ra đúng `1`.**
  Đây là dòng lệnh bắt buộc chạy, không phải tuỳ chọn - ra `0` nghĩa là trang không có H1
  nào (sự cố đã xảy ra thật, xem BƯỚC 3), phải quay lại chèn H1 và đăng lại NGAY, chưa được
  coi là xong. Đồng thời kiểm 200, widget render (tìm class widget), không "—", không lộ
  shortcode dạng text thô, thumbnail hiện.
- Kiểm tra thứ tự H1 -> SAPO -> Tóm tắt đúng rule.
- Purge cache nếu có sửa theme/CSS (bình thường KHÔNG cần - chỉ sửa content).
- Append LOG.md: `| <ngày> | Content pipeline | <slug> đăng/refresh, category X, widget Y |`.
- Báo Hiếu 3-5 dòng: URL bài, category, widget đã chèn, link nội bộ đã đặt.

## SỔ CÁI CỤM - theo dõi tiến độ dài hạn (rule Hiếu 2026-07-17)

Mỗi cụm chủ đề có 1 file `content/cluster-<slug>.md` là "sổ cái": bảng mọi bài dự kiến +
trạng thái ✅/⏳ + URL + ngày. Bắt buộc:
- **Mỗi khi viết/sửa xong 1 bài** -> cập nhật dòng đó thành ✅ + ngày, và trong báo cáo chat
  ĐIỂM LẠI: "cụm này đã xong bài A, B; còn thiếu C, D, R1-R15".
- **Khởi động phiên/tiếp tục cụm dở** -> đọc sổ cái trước, báo ngay còn bài nào chưa viết.
- **Chuyển sang cụm MỚI** -> TỔNG KẾT cụm cũ trước (đã xong bao nhiêu/tổng, còn treo gì),
  rồi mới mở `content/cluster-<slug-mới>.md`.
- Sổ cái sinh từ file plan của cụm; plan là kế hoạch, sổ cái là trạng thái sống.
- **Báo cáo LUÔN kèm LINK LIVE bấm được** (https://digicomvn.com/<slug>/) cho mọi bài
  vừa viết/sửa, để Hiếu bấm kiểm ngay - không chỉ liệt kê tên bài (rule Hiếu 2026-07-17).

## BẢNG KIỂM CHỨNG MỖI LẦN CHẠY (rule Hiếu 2026-07-17 - để Hiếu audit được)

Mỗi lần chạy pipeline (bất kỳ chế độ nào), TRƯỚC khi báo xong phải ghi
`content/run-<YYYY-MM-DD>.md` (append nếu chạy nhiều lần/ngày): bảng từng bước đã chạy,
mỗi bước 1 dòng: `bước | làm/bỏ qua (lý do) | bằng chứng`. Bằng chứng phải KIỂM được:
- Quét SERP/allintitle: số liệu + ngày đo.
- Sitemap check: URL bài trùng tìm thấy (hoặc "không có").
- Backup: đường dẫn file backup + dòng manifest.
- Đăng/sửa: post ID + URL + kết quả curl (200, title đúng).
- Widget: tên shortcode + số phần tử render đếm được trên HTML live.
- GSC: URL đã submit + trạng thái ("Đã yêu cầu lập chỉ mục" / chờ quota).
- Internal link: link nào chèn ở đâu, anchor gì.
Báo cáo chat cuối chỉ tóm tắt; bảng đầy đủ nằm trong file run để Hiếu mở kiểm bất kỳ lúc nào.

## RANH GIỚI

- KHÔNG đụng CPT `dgc_gia` / giá (routine giá riêng quản).
- KHÔNG tạo trang dịch vụ/page mới - pipeline này chỉ cho BÀI BLOG.
- KHÔNG publish lại nhóm đang ẩn (4 nhóm media, dòng gói/chung chung).
- Batch nhiều bài: tối đa 3 bài/lần chạy, cùng cụm phải qua gate bước 1.
