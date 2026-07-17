# Writing Rules — Viết bài digicomvn.com (Master)

> Nhân bản + adapt từ hệ writing-rules của dự án ICD (2026-07-16), bỏ phần ICD-only
> (WooCommerce/product specs/hide-price/Xilin). Áp cho MỌI bài viết của digicomvn:
> bài blog on-site, trang dịch vụ, VÀ bài PR đăng báo ngoài.
> Kế thừa: `tone-voice.md`, `dich-vu.md`, `uu-dai-cta.md`, `content-mirror-pavietnam.md`, `do-dont.md`, `seo-patent-process.md`.

## 0. HAI LOẠI BÀI — XÁC ĐỊNH TRƯỚC KHI VIẾT

| Loại | Đăng ở đâu | Mục tiêu | Khác biệt chính |
|---|---|---|---|
| **A. On-site** (blog / trang dịch vụ digicomvn.com) | chính website | rank + chuyển đổi lead | internal link về cụm dịch vụ, schema đầy đủ, CTA gọi/Zalo/bảng giá |
| **B. PR đăng báo** (booking báo & PR — đăng trên báo ngoài) | báo điện tử bên thứ 3 | backlink + phủ thương hiệu | giọng BÁO CHÍ (không quảng cáo lộ liễu), 1-2 anchor về digicomvn, **đổi anchor mỗi báo** |

Sai loại = sai toàn bộ cách cài link + tone. Chốt loại trước, rồi mới viết.

## 1. QUALITY BAR BẮT BUỘC — 4 TIÊU CHÍ

Mọi bài PHẢI đạt cả 4, không chỉ "viết xong":
1. **Tốt hơn đối thủ** — research top SERP của primary keyword; bài phải cover đủ những gì đối thủ có + thêm góc/dữ liệu họ KHÔNG có (info gain). Không đăng nếu mỏng hơn top 3.
2. **Đầy đủ nhất** — phủ hết sub-topic, câu hỏi, edge case. Có bảng, số liệu cụ thể (khoảng giá thật, chỉ số DR…), không bỏ sót khía cạnh quan trọng.
3. **Tối ưu AI/GEO** — answer-first 40-80 từ đầu, 1 claim/đoạn, có bảng dữ liệu, FAQ thật + **FAQPage JSON-LD schema** (bài on-site), entity/NAP nhất quán.
4. **Tối ưu Google** — title ≤60 ký tự, meta desc ≤160 (có số), 1 H1, primary keyword trong 100 từ đầu, internal link về cụm, mọi link 200.

## 2. CẤU TRÚC BÀI — THỨ TỰ BẮT BUỘC

**Bài A (on-site):**
```
1. H1 (WP title tự render H1 — KHÔNG thêm H1 trong body)
2. Intro answer-first (40-80 từ: định nghĩa + value)
3. Body (H2/H3, bảng, list)
4. Information Gain block (cơ chế, edge case, số liệu, bảng so sánh)
5. Internal link box về cụm dịch vụ
──── 3 phần cuối, đúng thứ tự ────
6. FAQ + JSON-LD FAQPage
7. CTA liên hệ (hotline, Zalo, link bảng giá)
8. Nguồn tham khảo (nếu có trích dẫn)
```

**Bài B (PR báo):**
```
1. Tiêu đề báo chí (chứa keyword tự nhiên, không nhồi)
2. Sapo 40-70 từ (nêu vấn đề, không bán hàng)
3. Thân bài H2/H3 (kiến thức thật, khách quan)
4. 1 đoạn gợi ý giải pháp — cài 1-2 anchor về digicomvn TỰ NHIÊN
5. Kết luận
6. Box thông tin liên hệ Digicom (cuối bài)
```
Bài B KHÔNG có FAQ schema (không kiểm soát được HTML báo), KHÔNG nhồi CTA nhiều lần.

- Thứ tự 3 phần cuối bài A: FAQ → CTA → Nguồn — **KHÔNG đảo**, mỗi phần đúng 1 lần.
- Toàn trang chỉ **1 H1**. Từ 2 trở lên = lỗi SEO nghiêm trọng.

## 3. ON-PAGE SEO

| Element | Yêu cầu |
|---|---|
| Meta Title | Primary keyword đầu tiên, ≤60 ký tự |
| Meta Description | ≤160 ký tự, có CTA + số, keyword tự nhiên |
| H2/H3 | Phân cấp logic, cover long-tail |
| Keyword density | 1-2%, KHÔNG nhồi nhét |
| Primary keyword | Trong 100 từ đầu |

**Độ dài tối thiểu:** trang dịch vụ (pillar) 1000 từ · blog long-tail 600 · blog cạnh tranh 1500 · bài PR báo 600-1000 (theo yêu cầu đầu báo). Độ sâu đo bằng THÔNG TIN, không bằng số chữ.

## 4. INTERNAL LINK & ANCHOR

**Bài A (on-site):**
- URL absolute live `https://digicomvn.com/...` — KHÔNG relative/local/chưa publish.
- 2-5 link/1000 từ. Anchor descriptive, keyword-rich, KHÔNG "click here".
- Trỏ về cụm dịch vụ (money page): `/dich-vu/mua-textlink/`, `/dich-vu/dich-vu-backlink/`, `/dich-vu/guest-post/`, `/dich-vu/booking-bao-pr/`, `/dich-vu/dich-vu-toplist/`, `/dich-vu/backlink-social-entity/`, `/dich-vu/backlink-quoc-te/`, `/dich-vu/booking-truyen-hinh/`, `/bang-gia/`.
- Cuối bài: block "Tìm hiểu thêm" link pillar dịch vụ liên quan.

**Bài B (PR báo) — QUY TẮC RIÊNG:**
- Chỉ **1-2 anchor** về digicomvn/trang dịch vụ, đặt trong body tự nhiên (không dồn cuối).
- **Đổi anchor mỗi báo** khi rải nhiều báo: "mua backlink", "dịch vụ backlink", "Digicom", "booking báo PR"… — tránh cùng 1 anchor trên nhiều báo (unnatural link profile).
- **Đa dạng câu dẫn quanh anchor** giữa các báo — không dùng chung 1 câu boilerplate.
- Hotline `tel:0988797?` → dùng **`0988 769 317`**; Email `info@digicomvn.com`.

## 5. RESEARCH TRƯỚC KHI VIẾT — TOP 15 SERP (bắt buộc)

Trước khi viết 1 chữ, research primary keyword để bài **tốt hơn + đủ hơn** top đang xếp hạng:

1. **Lấy top 15 kết quả xếp hạng cao nhất** trên Google cho primary keyword (WebSearch; bổ trợ Ahrefs/Semrush SERP overview + related/PAA nếu có).
2. Với mỗi kết quả, ghi: **họ cover gì** (heading, bảng, số liệu, FAQ) và **họ THIẾU gì**.
3. Tổng hợp: (a) union mọi sub-topic top 15 đã phủ → bài mình phải phủ ĐỦ; (b) knowledge gap không ai trả lời tốt → đây là **information gain** của mình.
4. Lấy long-tail/H2 từ autocomplete + "People also ask".
5. Xác định **≥3 yếu tố độc quyền** chỉ digicomvn viết được (khoảng giá thật, bảng so sánh dịch vụ, checklist chọn nguồn, edge case ngành BĐS/tài chính…).

**Ngưỡng đạt:** bài phải phủ đủ mọi sub-topic quan trọng của top 15 + có phần đối thủ không có. KHÔNG đăng nếu mỏng hơn top 3.

### Information Gain — RIÊNG TỪNG URL
Viết riêng cho primary keyword của URL đó, không copy template. Đạt ≥3/6: dữ liệu/khoảng giá thật, bảng so sánh, decision framework/checklist, edge case đối thủ không nói, ví dụ thực tế, mốc cập nhật. Verify: paste block sang URL khác cùng cụm mà vẫn đúng → SAI, phải unique.

## 5b. NGUYÊN LÝ PATENT GOOGLE (áp khi viết + cài link)

Đọc `seo-patent-process.md`. Tối thiểu áp 4 nguyên lý sau (đã verify quote từ patent thật):
- **Ngữ cảnh quanh anchor phải đa dạng** giữa các bài/báo cùng trỏ về digicomvn — không lặp câu dẫn boilerplate *(US8577893B1)*.
- **Đặt link trong body chính**, không cuối bài/sidebar — vị trí ảnh hưởng xác suất click thật *(US8117209B1)*.
- **Phân đoạn trực quan sạch** bằng khoảng trắng/heading, không dồn đặc, không ẩn text *(US7676745B2)*.
- **Backlink coi trọng phân phối chất lượng nguồn** (bucket DR), không chỉ đếm số lượng — phản ánh vào cách tư vấn khách trong bài *(US9002832B1)*.
- Không tuyên bố 3 loại nguồn (patent / leak / heuristic) đều là "bằng sáng chế Google" khi viết cho khách.

## 6. TONE & THUẬT NGỮ (theo tone-voice.md + rule Hiếu)

- Tiếng Việt chuẩn, không slang/miền. Đoạn ngắn 2-3 câu, active voice, số thật.
- Bài B giọng **báo chí khách quan** — nêu vấn đề/kiến thức trước, giải pháp Digicom sau, không "chốt đơn" lộ liễu.
- **KHÔNG dùng "bài chuẩn SEO"** trên toàn site. Dùng: "viết bài", "viết bài PR", hoặc "viết nội dung chuẩn SEO/GEO".
- **KHÔNG emoji** trong heading, badge, CTA, body (audience B2B).

## 7. KHÔNG BỊA (rule content-professional — FAIL nếu vi phạm)

- KHÔNG bịa tên đầu báo đã hợp tác / case study / tên khách hàng / số liệu làm sự thật.
- Số năm kinh nghiệm, % tăng traffic, số dự án: chỉ ghi nếu có nguồn thật; chưa rõ thì để chung chung.
- Khoảng giá: chỉ lấy từ bảng giá thật (`dgc_gia` / `/bang-gia/`), không ghi bừa.
- Con số ước tính hiệu quả: luôn kèm "ước tính, tuỳ ngành", không cam kết tuyệt đối.

## 8. Brand Info Digicom — KHÔNG được sai

- Pháp nhân: **Digito Combat**, MST **0109816406**, địa chỉ Gamuda Garden.
- Hotline: **0988 769 317** · Email công khai: **info@digicomvn.com** · Website: **https://digicomvn.com**
- 4 dịch vụ lõi (pivot): Mua Textlink · Dịch vụ Backlink (ngách BĐS) · Guest Post · Booking báo & PR. (Thêm: Toplist, Social Entity, Backlink quốc tế, Booking truyền hình.)
- Giai đoạn 1: form tư vấn/báo giá, KHÔNG giỏ hàng/thanh toán online.

## 9. QA CHECKLIST TRƯỚC KHI ĐĂNG

```
[ ] Đã xác định loại bài (A on-site / B PR báo) và viết đúng khung
[ ] H1 đúng 1 cái, có primary keyword (bài A); tiêu đề báo có keyword tự nhiên (bài B)
[ ] Meta title ≤60, meta desc ≤160 có số (bài A)
[ ] Primary keyword trong 100 từ đầu, density 1-2% (không nhồi)
[ ] Bài A: thứ tự cuối FAQ → CTA → Nguồn, mỗi cái 1 lần; FAQPage schema nếu có FAQ thật
[ ] Bài B: 1-2 anchor về digicomvn, đổi anchor/câu dẫn nếu rải nhiều báo
[ ] Mọi internal link URL absolute live https://digicomvn.com/... , verify 200
[ ] KHÔNG bịa đầu báo/case/số liệu; khoảng giá lấy từ bảng giá thật
[ ] KHÔNG dùng "bài chuẩn SEO"; KHÔNG emoji trong heading/CTA
[ ] Hotline 0988 769 317, email info@digicomvn.com đúng
[ ] Info gain ≥3/6 yếu tố; không mỏng hơn top 3 SERP
```

*Last updated: 2026-07-16*
