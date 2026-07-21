# TUYỆT ĐỐI KHÔNG bán/nhắc bán backlink .gov.vn, .edu.vn (chốt Hiếu 2026-07-20)

> Rule cứng, mức ưu tiên cao nhất trong nhóm nội dung. Không có ngoại lệ, không thương lượng
> theo từng trường hợp. Muốn thay đổi phải có ý kiến Hiếu bằng văn bản.

## Nguyên tắc

Digicom **KHÔNG bán, KHÔNG nhận triển khai, KHÔNG làm trung gian** cho bất kỳ hình thức đặt
liên kết trả tiền nào trên tên miền `.gov.vn`, `.gov`, `.edu.vn`, `.edu`.

Áp dụng cho: bảng giá (CPT `dgc_gia`), trang dịch vụ, bài blog, nội dung tư vấn của chat AI,
báo giá gửi khách, mọi kênh.

## Lý do (không phải chuyện khẩu vị - là pháp lý)

Cơ quan nhà nước và trường học **không có cơ chế bán quảng cáo/bán liên kết** cho doanh nghiệp.
Vì vậy mọi nguồn cung "backlink gov/edu" trên thị trường chỉ đến từ 2 con đường:
1. Website bị xâm nhập trái phép (hack, khai thác lỗ hổng).
2. Người được giao quản trị lạm quyền chèn link thu tiền riêng.

Cả hai là hành vi vi phạm pháp luật. Tháng 8/2024 một Phó Chánh Văn phòng UBND tỉnh Quảng Trị
bị bắt tạm giam vì chèn link quảng cáo vào các tên miền .gov.vn/.edu.vn để thu tiền (2019-2024).
Báo Thanh Niên: hơn 600 website Việt bị chèn quảng cáo cờ bạc. Bộ KH&CN đang rà soát, đã giảm
hơn 50%. Người MUA cũng chịu rủi ro: mất tiền không đòi được, vi phạm chính sách link trả tiền
của Google, và nguy cơ liên đới khi cơ quan chức năng truy vết dòng tiền.

## Chốt chặn kỹ thuật đã cài (2026-07-20)

1. **`10-bang-gia-booking/export-web.py` -> `is_gov_edu()`** loại mọi dòng có `.gov.vn`/`.edu.vn`
   trước khi xuất `gia-web.csv`. Quét trên TOÀN CHUỖI `dau_bao + vi_tri + quy_cach`.
   ⚠️ KHÔNG dùng `.split("/")[0]` khi kiểm tra - `dau_bao` có thể là
   `"https://vietnamtourism.gov.vn/ Tổng cục du lịch"`, split sẽ cắt còn `"https:"` và lọt bộ lọc
   (đã dính lỗi này đúng lần đầu triển khai, phải sửa lại).
2. **Đã draft 9 dòng `dgc_gia` đang publish** ngày 2026-07-20, gồm 3 dòng `vietnamtourism.gov.vn`
   (Cục Du lịch Quốc gia, giá 7,1-10,3 triệu - 1 dòng còn ghi "tùy thuộc vào tổng cục") và 6
   trường/trung tâm `.edu.vn`. Backup ID + giá:
   `~/Claude-Workspace/_backups/routines/2026-07-20/gov-edu-removal/dgc_gia-gov-edu-before.tsv`
3. Lưu ý false positive: `kreweduoptic.com` chứa chuỗi "edu" nhưng là domain .com thương mại
   bình thường - KHÔNG phải diện này, đừng draft nhầm.

## Nội dung bài viết phải nói RÕ

Khi bài nào chạm chủ đề này (233 back-link-gov, 1279 mua-textlink-edu-gov, 234
back-link-chat-luong), phải nêu thẳng **"hành vi vi phạm pháp luật"**, không nói giảm thành
"rủi ro", "nhạy cảm", "cần cân nhắc". Kèm nguồn báo chính thống đã verify còn sống.

Nếu khách hỏi mua: từ chối dứt khoát, giải thích lý do, điều hướng sang nguồn hợp pháp
(báo điện tử, guest post site cùng ngành, social entity, diễn đàn còn hoạt động).

## Đã dọn ngày 2026-07-20

| Nơi | Vấn đề | Xử lý |
|---|---|---|
| CPT `dgc_gia` | 9 dòng publish bán link .gov.vn/.edu.vn | Draft hết (giữ để rollback) |
| `export-web.py` | Không có filter -> routine tuần sẽ đẩy lại | Thêm `is_gov_edu()`, chặn 27 dòng |
| Bài 233 `back-link-gov` | Chào bán "mạng lưới hơn 50 cổng thông tin cấp Sở đến Bộ", "gói PR trên trang Chính phủ", "cam kết Trust > 70" + placeholder `[Tên_Thương_Hiệu_Của_Bạn]` | Viết lại toàn bộ |
| Bài 1279 `mua-textlink-edu-gov` | "nhận tư vấn theo từng trường hợp... trước khi triển khai" (để ngỏ) | Đổi thành từ chối dứt khoát |
| Bài 234 `back-link-chat-luong` | Gợi ý lấy link từ "cổng thông tin sở/ngành" là "kim bài miễn tử" | Viết lại mục, nêu rõ vi phạm pháp luật |

## Liên quan
- `dich-vu.md` - danh mục dịch vụ chính thức, KHÔNG có backlink gov/edu.
- `content-professional.md` (global) - không claim thứ không verify được.
- `bang-gia-booking.md` - quy tắc lọc chất lượng domain trước khi lên bảng giá.
