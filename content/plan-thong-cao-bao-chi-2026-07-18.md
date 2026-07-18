# Plan cụm "thông cáo báo chí" - 2026-07-18

> Input: 394 từ khoá thô Hiếu gửi (paste trực tiếp, không qua tool volume). Phân loại rule-based
> trước khi gom cluster, KHÔNG viết bài cho từ khoá ngoài phạm vi business.

## 1. Phân loại 394 từ khoá

| Nhóm | Số lượng | Xử lý |
|---|---|---|
| **CORE** (khái niệm/cách viết/mẫu thông cáo báo chí) | ~180 (sau khi lọc tiếp noise lẫn trong CORE) | Viết bài |
| **BRAND** (thông cáo báo chí + tên hãng: Petrolimex, Vinamilk, Apple, Samsung, ACB, Grab, Unilever, Shopee, Katinat, Highlands, BIDV, EVN, Yody...) | 101 | **BỎ** - đây là người tìm ĐỌC thông cáo báo chí THẬT của hãng đó (tin tức), không phải học cách viết. Digicom viết bài "Thông cáo báo chí Samsung là gì" vừa sai intent vừa không có business nào biện minh - không phải hãng, không có tin thật để đăng. |
| **GOV/CHÍNH TRỊ** (hội nghị trung ương, quốc hội, đại hội đảng, bộ ngành, UBKT, chính phủ) | 41 | **BỎ** - ngoài phạm vi dịch vụ, nhạy cảm chính trị, không liên quan booking báo & PR doanh nghiệp. |
| **GIẢI TRÍ/SỰ KIỆN CỤ THỂ** (Anh Trai Vượt Ngàn Chông Gai, Mưa Đỏ, Negav, Miss Cosmo...) | 14 | **BỎ** - tin tức 1 sự kiện/nghệ sĩ cụ thể, không phải nhu cầu học viết TCBC. |
| **RÁC/NHIỄU** (thông cáo báo chí số 04, số 580, "4 báo cáo tài chính", "báo cáo 6/7"...) | 34 | **BỎ** - nhiễu từ công cụ quét từ khoá (văn bản hành chính/kế toán, không liên quan chủ đề). |
| **NHIỄU CÒN SÓT trong CORE** (giá xăng dầu/giá điện/giá nhiên liệu theo TCBC, TCBC y tế/PCCC/đại hội thi đua, TCBC "đồ hộp Hạ Long"/"Lemonade"/"dự án Nuôi Em"/"UFM" - brand/tổ chức lẻ không đủ nhận diện qua regex) | ~24 | **BỎ** - vẫn là tin tức/thông báo giá SOE hoặc tên tổ chức cụ thể, cùng lý do như nhóm BRAND/GOV. |

**Tổng BỎ: ~214/394 (54%).** Đây không phải cắt xén tuỳ tiện - từng nhóm đều lệch hẳn intent
"học viết thông cáo báo chí" sang "đọc tin thật của 1 tổ chức cụ thể", nằm ngoài năng lực và
phạm vi dịch vụ Digicom (rule content-professional: không bịa/không viết thay tin tức hãng khác).

## 2. Kiểm tra trùng bài đã có

Quét `wp post list -s "thông cáo báo chí"` trên live: **0 bài đã phủ đúng intent này.**
Bài gần nhất là *Cách Viết Bài PR Chuẩn Báo Chí* (ID 1277, `/cach-viet-bai-pr-chuan-bao-chi/`)
nhưng viết cho ngữ cảnh "bài PR gửi đăng báo qua Digicom" (đã có brand/giá), khác "thông cáo báo
chí" là khái niệm/định dạng văn bản PR chuẩn quốc tế - không trùng, sẽ link chéo 2 chiều.

## 3. Gom cluster (4 bài, không tách thêm để tránh cannibalize)

| # | Bài | Vai trò | Từ khoá đại diện đã gom | Ước tính KW gộp |
|---|---|---|---|---|
| 1 | **Thông Cáo Báo Chí Là Gì? Định Nghĩa, Vai Trò, Ai Viết 2026** | **Pillar** | là gì, tiếng Anh là gì/trong tiếng Anh, định nghĩa, khái niệm, thế nào là, mục đích, vai trò, ý nghĩa, đặc điểm, ai viết/viết cho ai/gửi cho ai/gửi khi nào/đăng ở đâu, dịch vụ thông cáo báo chí, lịch sử ra đời | ~35 |
| 2 | **Cách Viết Thông Cáo Báo Chí Chuẩn: Cấu Trúc, 5W1H, Ví Dụ** | Cluster | cách viết, hướng dẫn viết, quy trình/quy tắc/nguyên tắc viết, cấu trúc, bố cục, dàn ý, tháp ngược, 5W1H, 7 phần/bước, tiêu đề, trích dẫn, bao nhiêu chữ, ví dụ, lưu ý khi viết | ~30 |
| 3 | **Mẫu Thông Cáo Báo Chí: Tổng Hợp Theo Từng Mục Đích + Tải Word** | Cluster | mẫu (chuẩn/hay/word/pdf), template, các mẫu/loại/dạng, banner/bìa/poster/thiết kế, **gộp luôn** mẫu ra mắt sản phẩm/sách/phim/MV, mẫu sự kiện/lễ khởi công/ký kết/khánh thành/kỷ niệm/hội thảo/cuộc thi (không tách bài riêng - cùng là "mẫu theo tình huống", tách sẽ mỏng + đấu từ khoá với chính bài này) | ~55 |
| 4 | **Thông Cáo Báo Chí Xử Lý Khủng Hoảng: Mẫu Và Cách Viết Xin Lỗi Khách Hàng** | Cluster | xử lý khủng hoảng, khủng hoảng truyền thông, xin lỗi/xin lỗi khách hàng, đính chính, giải quyết khủng hoảng, về sự cố | ~10 |

Tổng ~130 từ khoá lõi được 4 bài phủ (phần còn lại trong 180 CORE là biến thể gần trùng/năm
tháng "2024/2025/2026" tự động rơi vào bài phù hợp theo semantic, không tách thêm).

**Không tách bài 5 riêng cho "ra mắt sản phẩm/sự kiện"** dù có ~20 từ khoá - lý do: đây vẫn là
"mẫu theo tình huống", SERP cho các cụm này thực chất là listicle mẫu tổng hợp (cùng dạng bài
với Cluster 3), tách riêng sẽ cannibalize thay vì bổ sung intent mới.

## 4. Sơ đồ internal link

```
Cluster 2 (Cách viết) ─┐
Cluster 3 (Mẫu)        ├─→ Pillar 1 (TCBC là gì) ─→ /cach-viet-bai-pr-chuan-bao-chi/ (bài cũ, link chéo)
Cluster 4 (Khủng hoảng)─┘         │
                                   └─→ /booking-bao-pr/ (money page, anchor "dịch vụ viết & đăng thông cáo báo chí")
Pillar 1 ─→ từng Cluster (anchor đúng chủ đề: "cách viết thông cáo báo chí chuẩn", "mẫu thông cáo báo chí", "xử lý khủng hoảng truyền thông")
```
- Bài informational (1,2,3) KHÔNG nhét anchor bán hàng cứng - dẫn qua Pillar trước.
- Bài 4 (khủng hoảng) có thể thêm 1 anchor thương mại nhẹ về cuối ("DigicomVN hỗ trợ soạn thảo
  và phát hành thông cáo báo chí xử lý khủng hoảng qua hệ thống booking báo") vì intent gần
  commercial hơn 3 bài kia.

## 5. Category + widget dự kiến

- Category: `booking-bao-pr` (đã có, khớp cụm PR/booking báo hiện tại của site).
- Widget: `[dgc_offpage_quiz]` cho bài 1 (kiến thức nền) hoặc bài 2 (checklist tự chấm "thông
  cáo báo chí của bạn đã đủ chuẩn chưa"). Bài 3, 4 nếu không khớp widget có sẵn → cân nhắc
  bảng so sánh mẫu bấm lọc theo mục đích (bài 3) thay vì tạo widget mới (đúng ưu tiên 1 trong
  skill trước khi build widget mới).

## 6. Xin duyệt

**Đề xuất: 4 bài mới**, batch 3 bài/lần chạy theo đúng giới hạn skill (chạy bài 1-2-3 trước,
bài 4 lần sau). Không viết cho 214 từ khoá đã loại (brand/gov/giải trí/rác).

Chờ Hiếu duyệt danh sách 4 bài + cách gộp cluster 3 trước khi viết.
