# Quy trình SEO dựa trên bằng sáng chế Google thật (verified)

> Nhân bản từ dự án ICD (2026-07-16). Nguồn gốc: 2 vòng deep-research adversarial
> (fan-out search + verify chéo 3-vote), tháng 7/2026. Nguyên tắc: chỉ đưa vào quy trình
> cơ chế có **quote nguyên văn từ patent + assignee xác nhận Google + corroborated ≥2 nguồn
> độc lập**. KHÔNG dùng tài liệu leak nội bộ (NavBoost, siteFocusScore, contentEffort...) làm
> bằng sáng chế — khác loại nguồn (xem mục 3).
>
> Áp cho digicomvn: dùng làm "luật chơi" nền tảng khi viết bài + xây backlink/PR. Nguyên lý
> patent không phụ thuộc loại site nên giữ nguyên; phần ví dụ đã Việt hoá theo digicomvn.

---

## 0. Bảng patent đã verify (căn cứ DUY NHẤT cho quy trình)

| # | Patent | Assignee | Cơ chế đã CONFIRM (quote-verified) | Tin cậy |
|---|---|---|---|---|
| 1 | **US8117209B1** — Reasonable Surfer | Google Inc. | Không phải link nào trên trang cũng có xác suất click như nhau; rank kết hợp feature (font, vị trí) + user behavior (click thật) | High |
| 2 | **US8577893B1** — Ranking based on reference contexts | Google Inc. | Phân tích "rare word" 2 bên trái/phải 1 hyperlink tạo "context identifier" để rank trang đích — **ngữ cảnh quanh anchor** quan trọng hơn chỉ anchor text | High |
| 3 | **US8719276B1** — Ranking nodes based on node independence | Google Inc. | Node chung tổ chức/không độc lập → gom "affiliated cluster" → **DEEMPHASIZE** (giảm) giá trị link giữa các node này | High — chỉ phần deemphasize; claim "cap cứng theo ngưỡng" đã bị BÁC BỎ |
| 4 | **US20070033168A1 + US7565358B2** — Agent Rank | Google Inc. | Digital signature gắn tác giả/publisher với content → tính điểm reputation SỐ cho tác giả | High — chỉ phần tính điểm; KHÔNG suy ra "ký tên = tự động rank cao" |
| 5 | **US20060149774A1** (+US7801897B2) — Geographic indexing | Google Inc. | Mỗi tài liệu index với nhiều location identifier gộp thành "aggregate geographic region" | High |
| 6 | **US9031929B1** — Site Quality Score | Google Inc. | Tỷ lệ user quan tâm tới CẢ site so với từng resource → tín hiệu chất lượng cấp DOMAIN, tách biệt cấp trang | High |
| 7 | **US9002832B1** — Classifying sites as low quality | Google Inc. | Đếm resource TRỎ VÀO site theo bucket điểm chất lượng (phân phối, không phải trung bình) → dưới ngưỡng = low quality. **Là backlink-quality classifier** | High |
| 8 | **US7676745B2** — Document segmentation (visual gaps) | Google Inc. | Dùng khoảng trắng giữa phần tử xây "visual model" → phân đoạn cấu trúc tài liệu | High |
| 9 | **US7797316B2** — Document freshness | Google (inventor M. Henzinger) | Freshness LAN TRUYỀN qua inbound link — trang có backlink từ trang cũ vẫn bị chấm freshness thấp dù tự nó vừa sửa | Medium |

**Misattribution — KHÔNG bao giờ trích là patent Google:** US9081857B1 (thật ra Amazon/A9), US8015172B1 (thật ra eBridge Inc.).

---

## 1. Nguyên lý áp vào VIẾT BÀI + BACKLINK/PR digicomvn

| # | Nguyên lý hành động | Patent |
|---|---|---|
| 1 | **Đặt link ở vùng nội dung chính**, không sidebar/footer — vị trí + font + ngữ cảnh ảnh hưởng xác suất click thật → giá trị truyền qua link | US8117209B1 |
| 2 | **Đa dạng từ ngữ NGỮ CẢNH quanh anchor**, không chỉ đổi anchor text. Nhiều báo/bài cùng trỏ về digicomvn → câu dẫn trước/sau link mỗi nơi phải KHÁC nhau, không lặp boilerplate | US8577893B1 |
| 3 | **Không bơm link chéo giữa các site cùng chủ**; hiểu đúng: bị GIẢM trọng số (không cắt về 0 theo ngưỡng cứng) | US8719276B1 |
| 4 | **Author entity nhất quán** (byline, Person schema, sameAs) — có cơ sở, nhưng KHÔNG suy thành "ký tên = rank cao" | US20070033168A1 |
| 5 | **Backlink: coi trọng PHÂN PHỐI chất lượng** referring domain (bucket DR), không chỉ đếm tổng RD | US9002832B1 |
| 6 | **Theo dõi tín hiệu chất lượng cấp DOMAIN** riêng với cấp trang — trang tốt trên domain yếu vẫn bị kéo | US9031929B1 |
| 7 | **Refresh nội dung phải kèm backlink MỚI** — sửa ngày không đủ, backlink cũ kéo freshness xuống | US7797316B2 |
| 8 | **Phân đoạn trực quan bằng khoảng trắng/spacing sạch** giữa các block, không dồn đặc, không ẩn text | US7676745B2 |
| 9 | (cụm geo/local) Tổ chức theo **vùng gộp**, không rải landing rời rạc từng tỉnh | US20060149774A1 |

## 2. Chỉ số tracking bổ sung từ patent

- Phân phối DR của referring domains (không chỉ tổng RD) — *US9002832B1*
- Tỷ lệ branded/direct search traffic vs tổng resource — proxy site quality cấp domain — *US9031929B1*
- % coverage author byline + Person schema toàn site — *US20070033168A1*
- Ngày backlink mới nhất trỏ vào mỗi URL quan trọng (không chỉ ngày sửa content) — *US7797316B2*

## 3. Ghi chú nguồn — KHÔNG trộn lẫn

- **Patent thật** (mục 0): có số US/WO, assignee Google xác nhận — "luật chơi" nền tảng; phần lớn nộp 2003-2015, không chắc phản ánh 100% thuật toán live 2026.
- **Tài liệu leak nội bộ 2024** (NavBoost, siteFocusScore...): KHÔNG phải patent, tin cậy thấp hơn — tham khảo được nhưng luôn gắn nhãn rõ khi trích.
- **Rule/heuristic tự xây của dự án**: kinh nghiệm thực chiến, không tuyên bố là patent/leak.

KHÔNG gọi cả 3 loại trên là "bằng sáng chế Google" khi báo cáo/trình bày cho khách. Fetch trực tiếp patents.google.com có thể bị chặn trong sandbox → re-verify thủ công trước khi trích dẫn ra ngoài dự án (khách, báo cáo public).

*Last updated: 2026-07-16*
