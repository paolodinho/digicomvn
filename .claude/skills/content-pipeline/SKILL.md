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

## A2. GOM CLUSTER + KẾ HOẠCH NỘI DUNG (checkpoint duyệt)

1. Gom keyword cùng intent + cùng SERP overlap (top 10 trùng >=3 URL = cùng bài) thành cluster.
   1 bài = 1 intent riêng, không tách 1 intent thành nhiều bài (rule publish-volume-warning).
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
   Backup content.raw TỪNG bài trước khi sửa (routine-backup) + manifest.
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
- Title <=58 ký tự, KW đầu; meta 140-160; slug flat `/[slug]/` (không /blog/).
- Giọng E-E-A-T tác giả Đỗ Hiếu (brand-info mục 3), thương hiệu viết là **DigicomVN**.
- KHÔNG bịa: giá, tên đầu báo hợp tác, case study, số liệu không nguồn.
- Nhắc tới giá -> KHÔNG ghi số cứng trong text, dùng widget/bảng giá live (bước 4).
- Gạch "-", không "—"/"–". Không câu khẩu ngữ/meta lọt vào text hiển thị.

## BƯỚC 4 - CHÈN WIDGET TƯƠNG TÁC (dữ liệu sống, không số chết)

Chọn widget khớp chủ đề, chèn dạng Gutenberg `<!-- wp:shortcode -->` tại điểm nghỉ mắt
(sau H2 thứ 2-3), mỗi bài 1-2 widget, KHÔNG nhồi cả 3:

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

## BƯỚC 6 - ĐĂNG LIVE (SSH Hostinger - rule deploy.md)

1. Upload nội dung: `wp post create` (hoặc `wp post update` nếu refresh) với
   `--post_status=publish --post_author=1`, content là Gutenberg blocks.
   Escape an toàn: ghi content ra file tạm, scp lên, `wp post create ... < file` hoặc
   `wp eval-file` (tránh vỡ quote khi truyền inline).
2. Gán category đúng 1 trong 11 chuyên mục blog (menu Blog đã tách category);
   bài dịch vụ off-page thường là `backlink-offpage` (24) hoặc `booking-bao-pr`.
3. Thumbnail: render theo ID -> scp lên -> `wp media import <png> --post_id=<ID> --featured_image`.
4. Backup: nếu là refresh bài cũ -> fetch `content.raw` TRƯỚC khi update, lưu
   `~/Claude-Workspace/_backups/routines/<ngày>/content-pipeline/` + 1 dòng manifest.md
   (rule routine-backup). Bài mới hoàn toàn -> ghi manifest "created".

## BƯỚC 7 - INTERNAL LINK (2 chiều)

- Trong bài mới: tối đa 5 link, >=1 money page, anchor tự nhiên trong câu,
  URL GỐC theo brand-info mục 4 (vd `/booking-bao-pr/` - KHÔNG dùng `/dich-vu/...` đã 301).
- Chiều ngược: chọn 1-2 bài cũ cùng cụm đang mạnh, chèn 1 link trỏ về bài mới
  (backup content.raw trước khi sửa).

## BƯỚC 8 - VERIFY + LOG (bắt buộc trước khi báo xong)

- `curl -s https://digicomvn.com/<slug>/` : 200, có H1, widget render (tìm class widget),
  không "—", không lộ shortcode dạng text thô, thumbnail hiện.
- Kiểm tra thứ tự H1 -> SAPO -> Tóm tắt đúng rule.
- Purge cache nếu có sửa theme/CSS (bình thường KHÔNG cần - chỉ sửa content).
- Append LOG.md: `| <ngày> | Content pipeline | <slug> đăng/refresh, category X, widget Y |`.
- Báo Hiếu 3-5 dòng: URL bài, category, widget đã chèn, link nội bộ đã đặt.

## RANH GIỚI

- KHÔNG đụng CPT `dgc_gia` / giá (routine giá riêng quản).
- KHÔNG tạo trang dịch vụ/page mới - pipeline này chỉ cho BÀI BLOG.
- KHÔNG publish lại nhóm đang ẩn (4 nhóm media, dòng gói/chung chung).
- Batch nhiều bài: tối đa 3 bài/lần chạy, cùng cụm phải qua gate bước 1.
