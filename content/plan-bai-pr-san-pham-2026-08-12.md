# Plan cụm "bài PR sản phẩm" - 2026-08-12, cập nhật 2026-08-13

> Nguồn: 74 dòng Hiếu paste trong chat (không phải keyword tool có volume thật - nhiều dòng là
> biến thể gõ lỗi của cùng 1 ý). Đã đối chiếu sitemap live (REST API, full-text content) để biết
> đã có bài chưa - KHÔNG đoán qua tên slug. Allintitle THẬT không đo được (Google CSE API 403 -
> "This project does not have the access to Custom Search JSON API", SerpApi/Serper chưa có key) ->
> áp dụng đúng nguyên tắc ước lượng BƯỚC B3.0b của skill `entity-refresh` (chốt Hiếu 2026-08-11):
> suy qua volume ngách (càng đặc thù/hẹp -> volume càng thấp) + độ cạnh tranh NGÀNH MẸ (ngành đó
> vốn có nhiều agency SEO mạnh hay không) -> allintitle ước lượng. Đây là suy đoán ĐỊNH TÍNH, ghi
> rõ để Hiếu phân biệt với số đo thật.
>
> **QUYẾT ĐỊNH 2026-08-13 (GHI ĐÈ khuyến nghị "gộp toplist" 2026-08-12):** Hiếu xác nhận muốn bài
> có INTENT RIÊNG BIỆT trên Google (mỗi ngách 1 bài, không gộp) để tối đa số trang có thể rank,
> miễn allintitle ước lượng đủ thấp. Cluster B dưới đây đổi từ "gộp thành 1 bài toplist" sang
> "viết riêng theo thứ tự ưu tiên độ dễ".

## Bảng tổng hợp - phân nhóm + đã có bài chưa + allintitle ước lượng + hành động

| # | Cụm/chủ đề (gộp biến thể, lỗi chính tả) | Intent | Đã có bài? | Allintitle ước lượng | Hành động | Dạng bài |
|---|---|---|---|---|---|---|
| 1 | Cấu trúc/cách viết bài PR sản phẩm chung (gộp "viết bài pr sản phẩm", "cấu trúc viết", "tiêu đề bài pr giới thiệu sản phẩm", "sao cho thu hút", "cách làm 1 bài pr cho 1 sản phẩm") | Informational - how-to | **CÓ RỒI** - [bai-pr-mau](https://digicomvn.com/bai-pr-mau/), [cach-viet-bai-pr-chuan-bao-chi](https://digicomvn.com/cach-viet-bai-pr-chuan-bao-chi/), [sapo-la-gi-trong-bai-pr](https://digicomvn.com/sapo-la-gi-trong-bai-pr/), [lead-bai-pr-la-gi](https://digicomvn.com/lead-bai-pr-la-gi/) | - | **BỎ** - trùng, viết thêm sẽ cannibalize | - |
| 2 | Lý thuyết PR: công chúng, thông điệp, KOL (gộp "xác định công chúng", "xây dựng thông điệp", "cơ sở lý thuyết bài pr của kols", "bài pr của kols viết như thế nào") | Informational - academic | **CÓ RỒI** (rải trong 11-28 bài: [pr-la-gi](https://digicomvn.com/pr-la-gi/), [mo-hinh-race-pr](https://digicomvn.com/mo-hinh-race-pr/), [cac-loai-hinh-pr](https://digicomvn.com/cac-loai-hinh-pr/)) | - | **BỎ** - nghi ngờ câu hỏi tiểu luận/đồ án, không phải nhu cầu khách hàng thật, giá trị thương mại thấp | - |
| 3 | Ngày hội sách | Informational - niche event | **CÓ RỒI** - [mau-bai-pr-ngay-hoi-sach](https://digicomvn.com/mau-bai-pr-ngay-hoi-sach/) | - | **BỎ** - trùng | - |
| 4 | Nội thất cao cấp | Informational - ngành | **GẦN CÓ** - [bai-pr-cong-ty-thiet-ke-noi-that](https://digicomvn.com/bai-pr-cong-ty-thiet-ke-noi-that/) | - | **SỬA** - đọc lại bài cũ, bổ sung góc "đồ nội thất cao cấp" nếu bài cũ thiên về công ty thiết kế | Audit + bổ sung |
| 5 | Booking báo/kênh phân phối, gói bài PR cho SEO (gộp "bài pr cho page", "nên đăng báo nào", "gói bài pr cho seo") | Transactional - dịch vụ | **CÓ RỒI, rất mạnh** - 20+ trang `book-bao-*`, [booking-bao-la-gi](https://digicomvn.com/booking-bao-la-gi/), [bao-gia-dang-bai-pr-theo-dau-bao](https://digicomvn.com/bao-gia-dang-bai-pr-theo-dau-bao/) | - | **BỎ bài mới** - nếu muốn, bổ sung mục "chọn báo theo ngành" vào pillar `/booking-bao-pr/` thay vì bài riêng | Bổ sung mục nhỏ |
| 6 | Từ khoá SEO cho bài PR / các bài PR về SEO | Informational sâu, khớp dịch vụ | **CHƯA CÓ** (đã full-text check, 0 kết quả) | Vừa (ngành SEO/content cạnh tranh, nhưng compound phrase hiếm) | **MỚI - ưu tiên cao** (business-relevant dù allintitle không thấp nhất) | Hướng dẫn kỹ thuật, dẫn về `/booking-bao-pr/`/`/dich-vu-backlink/` |
| 7 | Phụ gia ngành giấy | Transactional - B2B ngách | **CHƯA CÓ** | **Rất thấp** | **MỚI - ưu tiên 1** | Bài PR mẫu theo ngành B2B |
| 8 | Cảng biển | Transactional - B2B ngách | **CHƯA CÓ** | **Rất thấp** | **MỚI - ưu tiên 1** | Bài PR mẫu theo ngành logistics |
| 9 | Muối tôm Tây Ninh | Transactional - đặc sản | **CHƯA CÓ** | **Rất thấp** | **MỚI - ưu tiên 1** | Bài PR mẫu đặc sản địa phương |
| 10 | Rong nho | Transactional - F&B ngách | **CHƯA CÓ** | **Rất thấp** | **MỚI - ưu tiên 1** | Bài PR mẫu F&B ngách |
| 11 | Nước tẩy | Transactional - hoá mỹ phẩm gia dụng | **CHƯA CÓ** | Thấp | **MỚI - ưu tiên 2** | Bài PR mẫu theo ngành |
| 12 | Phân bón | Transactional - nông nghiệp B2B | **CHƯA CÓ** | Thấp | **MỚI - ưu tiên 2** | Bài PR mẫu theo ngành |
| 13 | Nội y | Transactional - thời trang | **CHƯA CÓ** | Thấp | **MỚI - ưu tiên 2** | Bài PR mẫu theo ngành |
| 14 | Handmade | Transactional - hàng thủ công | **CHƯA CÓ** | Thấp | **MỚI - ưu tiên 2** | Bài PR mẫu theo ngành |
| 15 | Sàn văn phòng | Transactional - BĐS thương mại | **CHƯA CÓ** | Thấp-vừa | **MỚI - ưu tiên 2** | Bài PR mẫu theo ngành |
| 16 | Studio cưới | Transactional - dịch vụ cưới | **CHƯA CÓ** | Thấp-vừa | **MỚI - ưu tiên 2** | Bài PR mẫu theo ngành |
| 17 | Dầu gội trị gàu (gõ lặp 3 lần trong data gốc -> tín hiệu nhu cầu thật) | Transactional - mỹ phẩm tóc | **CHƯA CÓ** | Vừa | **MỚI - ưu tiên 2, cao trong nhóm** | Bài PR mẫu theo ngành |
| 18 | Nước uống/giải khát | Transactional - FMCG | **CHƯA CÓ** | Vừa | **MỚI - ưu tiên 3** | Bài PR mẫu theo ngành |
| 19 | Trang sức kim cương | Transactional - bán lẻ cao cấp | **CHƯA CÓ** | Vừa | **MỚI - ưu tiên 3** | Bài PR mẫu theo ngành |
| 20 | Trị mụn | Transactional - mỹ phẩm/dược | **CHƯA CÓ** | Vừa-cao | **MỚI - ưu tiên 3** | Bài PR mẫu theo ngành |
| 21 | Trung tâm tiếng Anh | Transactional - giáo dục | **CHƯA CÓ** | Cao | **MỚI - ưu tiên 4** | Bài PR mẫu theo ngành |
| 22 | Bác sĩ Hàn Quốc (thẩm mỹ) | Transactional - y tế thẩm mỹ | **CHƯA CÓ** | **Cao** (ngành cạnh tranh SEO nhất trong list) | **MỚI - ưu tiên 4** | Bài PR mẫu theo ngành |
| 23 | Brand cụ thể: Durex, Dasani, Nutiboost, Acnes, Texas (gà rán), Samsung, Now.vn | Investigational - gán brand thật | **CHƯA CÓ** | Không áp dụng | **BỎ HẲN** - không có case thật với các brand này, viết = vi phạm `content-professional.md` (bịa case). Giữ dạng khung mẫu không gán brand (đã có ở #1) | - |
| 24 | Ca sỹ/nghệ sĩ, món Nga, PG, digital marketing (ngành), người mới bắt đầu (món ăn), Nha Trang | Không rõ ràng/quá lẻ tẻ | Chưa xác định | Không đo | **CẦN HIẾU LÀM RÕ** - ý nghĩa mơ hồ (vd "bài pr cho page" là Facebook Page hay tên riêng?), không đủ tín hiệu để lên kế hoạch | - |

## Thứ tự viết đề xuất (theo ưu tiên độ dễ + business value)

1. **Batch 1 (4 bài, allintitle ước lượng rất thấp):** #7 phụ gia giấy, #8 cảng biển, #9 muối tôm Tây Ninh, #10 rong nho.
2. **Batch 2 (6 bài, allintitle thấp, ưu tiên #17 trước vì có tín hiệu nhu cầu thật):** #17 dầu gội trị gàu, #11 nước tẩy, #12 phân bón, #13 nội y, #14 handmade, #15 sàn văn phòng, #16 studio cưới.
3. **Batch 3 (allintitle vừa, cạnh tranh hơn):** #18 nước giải khát, #19 trang sức, #20 trị mụn.
4. **Batch 4 (allintitle cao nhất, để cuối hoặc cân nhắc bỏ nếu không đủ nguồn lực):** #21 trung tâm tiếng Anh, #22 bác sĩ Hàn Quốc.
5. **Song song, ưu tiên độc lập với độ khó (business-relevant):** #6 từ khoá SEO cho bài PR.
6. **Việc audit nhỏ:** #4 nội thất cao cấp (đọc lại bài cũ trước khi quyết định bổ sung).

## Vẫn cần Hiếu xác nhận trước khi viết batch 1
- Xác nhận chạy đúng thứ tự batch trên, hay muốn gộp/bỏ bớt số lượng theo `publish-volume-warning.md` (mỗi bài đều là allintitle ước lượng, chưa có volume thật - nên coi batch 1 như 1 đợt TEST nhỏ, xem hiệu quả rồi mới quyết viết tiếp batch 2-4).
- 5 chủ đề ở dòng #24 - làm rõ ý nghĩa trước khi xếp cluster.
