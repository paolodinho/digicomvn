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

## 3. Công thức giá NỘI BỘ khi báo giá thủ công lấy từ sheet DanaSEO (chốt 2026-08-18)

> Xem thêm rule global `~/.claude/rules/bao-gia-khong-lo-gia-von.md` - áp dụng mọi dự án,
> không riêng digicom. Mục này là phần tính toán NỘI BỘ - không được đưa nguyên văn vào
> file gửi khách (xem mục 4 ngay dưới).

- **"Giá DanaSEO báo"** = số trong sheet DanaSEO. DanaSEO còn CHIẾT KHẤU THÊM 10% cho Hiếu
  trên số này → **giá vốn thật = giá DanaSEO báo × 0.90**.
- **Giá bán thật cho khách (nội bộ) = giá DanaSEO báo × 0.95** → lãi đúng 5% trên giá
  DanaSEO báo (~5,56% trên giá vốn thật). Đây là con số DUY NHẤT cần giữ đúng khi tính toán.
- **Báo giá mới và báo giá cũ (cùng đầu báo/vị trí) không được chênh lệch nhau** - đối chiếu
  lại số cũ trước khi gửi; lệch nhiều phải giải thích lý do, không im lặng đổi số.
- Không áp dụng mục này cho giá hiển thị trên website (`dgc_gia` CPT) - nơi đó vẫn theo
  công thức ×1.05 đã chốt trong `bang-gia-booking.md`.

## 4. Cách HIỂN THỊ giá trong file gửi khách (chốt 2026-08-18 - BẮT BUỘC, xem ảnh sự cố)

Sự cố: file gửi khách từng ghi thẳng cột "Giá DanaSEO báo" + câu "giá bán = giá DanaSEO báo
Digicom × 0,95" → lộ tên NCC và công thức tính giá nội bộ. Từ nay:

- **KHÔNG BAO GIỜ** đặt tên cột/nhãn nào chứa tên NCC (DanaSEO, Media Việt Nam, Fame Media...)
  trong file gửi khách. Cột giá chỉ được gọi "Giá niêm yết", "Giá gói", "Giá ưu đãi"...
- **KHÔNG BAO GIỜ** viết câu giải thích công thức (vd "giá bán = X × 0,95", "đã trừ Y% trên
  giá NCC báo") trong file gửi khách - kể cả trong ghi chú, footnote, email kèm theo.
- **"Giá niêm yết" hiển thị cho khách = SỐ TỰ ĐẶT (anchor marketing)**, KHÔNG phải giá NCC
  báo thật. Tính ngược từ giá bán thật: `giá niêm yết = giá bán thật / (1 - CK%)`, làm tròn
  đẹp (chục nghìn).
- **Cột "CK" (chiết khấu) hiển thị số NGẪU NHIÊN/xoay vòng trong khoảng 20-29%** cho từng
  dòng (không dùng % cố định 5% - dễ bị soi ra công thức thật, và trông kém hấp dẫn). Số %
  này KHÔNG phản ánh công thức nội bộ, chỉ để tạo cảm giác ưu đãi sâu.
- **"Giá sau CK"/"Giá ưu đãi" hiển thị = giá bán thật (mục 3)** - đây là con số duy nhất phải
  đúng tuyệt đối, mọi thứ khác (giá niêm yết, %) chỉ là lớp trình bày.
- Muốn kiểm tra công thức/giá vốn thật → mở riêng ghi chú/script nội bộ (không phải file đã
  gửi khách), hoặc hỏi lại Hiếu.

## 5. Cấu trúc file báo giá gửi khách (chốt 2026-08-18)

- **KHÔNG có mục "Gói đề xuất"/"Gói combo"** - chỉ liệt kê bảng giá từng vị trí đăng theo
  đầu báo, không gợi ý sẵn gói kết hợp nhiều đầu báo. Khách tự chọn dòng cần đặt.
- **Email liên hệ trong file báo giá dùng `sales@digicomvn.com`** (KHÔNG dùng
  `info@digicomvn.com` - email đó dùng cho việc khác, không phải kênh bán hàng).
- **Phụ phí thuê phóng viên đến tận nơi (không phải Digicom biên tập từ tư liệu khách
  cung cấp): 1.000.000đ/buổi**, ghi rõ trong mục Ghi chú, chưa gồm trong giá bảng.

## Liên quan
- `bang-gia-booking.md` - nguồn giá, sàn giá vốn, mã NCC (tài liệu NỘI BỘ, không copy vào
  file gửi khách).
- `content-professional.md` (global) - không bịa số liệu SỰ KIỆN/THỰC THỂ trong nội dung báo
  giá (khác với số CK hiển thị ở mục 4, vốn là con số marketing được phép "làm đẹp" theo rule
  global `bao-gia-khong-lo-gia-von.md`).
- `~/.claude/rules/bao-gia-khong-lo-gia-von.md` (global, mọi dự án) - nguyên tắc gốc.
