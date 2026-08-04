# Nguyên tắc làm file báo giá cho khách (chốt 2026-08-04)

> Hiếu: "Cực kì kĩ càng, và luôn có tính chiết khấu thật hấp dẫn để khách hàng bị thuyết phục."

## 1. Cực kỳ kỹ càng

- Đối chiếu giá vốn thật từ `10-bang-gia-booking/gia-web.csv` / `bang-gia-master.csv`
  (KHÔNG áng chừng, không nhớ nhầm giá cũ).
- Trước khi loại bỏ 1 dòng giá vì mã NCC (`ma_ncc`) lạ/không khớp bảng mã đã biết
  (1=DanaSEO, 2=Media Việt Nam, 3=Fame Media, 9=Khác) - **tra lại trong `raw/` hoặc
  `parse-*.py`** xem có phải NCC hợp lệ mới thêm sau (vd mã 4 = Rise Media, thêm
  2026-07-24) trước khi kết luận "không xác minh được". Đừng loại bỏ nhầm option rẻ hơn
  chỉ vì mã chưa quen mặt - sự cố thực tế 2026-08-04 (bỏ sót giá VnExpress 6,6tr vì tưởng
  mã "4" không rõ nguồn, thực ra là Rise Media).
- Luôn lấy phương án RẺ NHẤT hợp lệ trong các NCC đã xác minh cho mỗi đầu báo/vị trí,
  không mặc định chọn dòng đầu tiên tìm thấy.
- Verify lại bằng cách render PDF xem trước khi gửi (theo hướng dẫn skill `docx`).

## 2. Luôn có chiết khấu/ưu đãi thật hấp dẫn

- Mỗi báo giá gửi khách phải có ít nhất 1 yếu tố tạo cảm giác lợi ích rõ ràng: giá đã tối
  ưu theo combo, so sánh mức tiết kiệm so với phương án cao hơn, hoặc ưu đãi kèm theo.
- **Không được lỗi vốn** - chiết khấu/khuyến mãi phải nằm trong sàn giá vốn thật của NCC
  (xem `bang-gia-booking.md` mục "SÀN GIÁ VỐN cho chiết khấu combo" - markup hiện tại chỉ
  ~3%, combo giảm tối đa an toàn ~2,9%).
- Khi báo giá có nhiều phương án theo hạng mục (thời hạn đăng, vị trí chuyên mục...) -
  trình bày rõ bảng so sánh mức giá + mức tiết kiệm bằng số tiền cụ thể, không chỉ nói
  chung chung "giá tốt".
- Đánh đổi (hạ vị trí, rút ngắn thời hạn để giảm giá) phải giải thích RÕ cho khách hiểu
  đang đổi gì lấy gì - không giấu diếm để giá trông rẻ hơn bản chất.

## Liên quan
- `bang-gia-booking.md` - nguồn giá, sàn giá vốn, mã NCC.
- `content-professional.md` (global) - không bịa số liệu trong nội dung báo giá.
