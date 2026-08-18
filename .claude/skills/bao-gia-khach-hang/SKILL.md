---
name: bao-gia-khach-hang
description: >
  Làm báo giá (docx/xlsx) gửi khách hàng digicomvn.com - booking báo/PR, guest post,
  textlink, backlink... LUÔN xuất ra 2 FILE TÁCH BIỆT: 1 file NỘI BỘ (có tên nhà cung
  cấp, giá vốn, công thức tính) và 1 file GỬI KHÁCH (ẩn hết thông tin nội bộ). 2 file
  phải khác nhau rõ ràng về tên + hình thức để không gửi nhầm. Trigger: "làm báo giá
  cho khách", "báo giá gửi khách", "tổng hợp danh sách gửi khách", "báo giá booking
  báo/guest post/textlink".
---

# Báo giá khách hàng - digicomvn.com

> Quy tắc gốc về giá/chiết khấu/công thức: đọc `.claude/rules/bao-gia-khach-hang.md`
> (mục 1-6) TRƯỚC khi làm - skill này chỉ đóng gói quy trình XUẤT FILE, không lặp lại
> nguyên tắc tính giá đã có ở đó.

## Nguyên tắc gốc (chốt 2026-08-18, Hiếu: "để t ko gửi nhầm")

Mỗi lần làm báo giá, **LUÔN xuất ra ĐÚNG 2 FILE**, không bao giờ chỉ 1:

| | File NỘI BỘ | File GỬI KHÁCH |
|---|---|---|
| Chứa | Tên NCC (DanaSEO...), mã NCC, giá vốn, giá bán, % lãi thật, công thức | CHỈ giá niêm yết + CK hiển thị (20-29%) + giá ưu đãi - theo `bao-gia-khach-hang.md` mục 4 |
| Tên file | `NOIBO-<ten-bao-gia>-<ngay>.xlsx` | `Bao-Gia-<ten-bao-gia>-<ngay>.xlsx` (không có chữ NOIBO) |
| Vị trí lưu | **CÙNG thư mục** `11-bao-gia-khach/` với file gửi khách (chốt 2026-08-18: Hiếu yêu cầu 2 file nằm cùng chỗ, phân biệt bằng TÊN + MÀU, không tách thư mục con) | `11-bao-gia-khach/` |
| Header/màu | Nền ĐỎ đậm (`#B91C1C`), dòng cảnh báo to: **"⚠ FILE NỘI BỘ - TUYỆT ĐỐI KHÔNG GỬI KHÁCH"** ở dòng 1, tab sheet màu đỏ | Nền brand xanh/teal (`#1C2035` / `#0E8C7F`) như file khách hàng bình thường, tab sheet màu teal |

## Quy trình bắt buộc

1. Tính giá theo đúng công thức đang chốt (đọc `.claude/rules/bao-gia-khach-hang.md`
   mục 3, hoặc công thức Hiếu chỉ định riêng cho báo giá này nếu khác mặc định).
2. Dựng **file nội bộ trước** - đầy đủ cột: NCC, mã NCC, giá vốn (giá NCC báo), % chiết
   khấu ngầm nếu có, giá bán thật, % lãi. Lưu CÙNG thư mục `11-bao-gia-khach/`.
3. Từ file nội bộ, lọc bỏ cột NCC/giá vốn/công thức -> dựng **file gửi khách** theo
   đúng mục 4 (giá niêm yết ảo + CK 20-29% + giá ưu đãi = giá bán thật) và mục 6 (phân
   theo lĩnh vực + mục lục điều hướng nếu số lượng lớn). Lưu cùng thư mục `11-bao-gia-khach/`.
   **BẮT BUỘC** thêm 1 sheet/trang "Thông tin & Thanh toán" theo mục 7 (thông tin Digicom,
   STK, hình thức thanh toán, ngày phát hành + hạn 7 ngày) - thiếu mục này = chưa xong.
4. Khi báo cáo xong: **LUÔN đưa full path của file GỬI KHÁCH lên đầu**, rõ ràng, không
   lẫn với file nội bộ (theo rule global `output-file-path.md` + `to-chuc-file-goi-y.md`).
   Ví dụ:
   - "File gửi khách: `<path>`"
   - "File nội bộ (có giá vốn, ĐỪNG gửi khách): `<path>`" (nêu sau, phụ)
5. Chỉ gọi `SendUserFile` cho file gửi khách theo mặc định. File nội bộ chỉ gửi khi
   Hiếu yêu cầu rõ ràng ("gửi cả file nội bộ", "cho xem giá vốn").

## Template sẵn dùng - sheet/trang "Thông tin & Thanh toán" (mục 7)

Copy đúng nội dung này vào cuối MỌI file gửi khách (đổi ngày phát hành + ngày hết hạn
= ngày phát hành + 7; đổi hình thức thanh toán nếu Hiếu chỉ định khác cho đơn cụ thể):

```
1. Thông tin bên bán
   Tên công ty:        CÔNG TY TNHH DỊCH VỤ TRUYỀN THÔNG DIGITO COMBAT
   Mã số thuế:          0109816406
   Địa chỉ giao dịch:   Số nhà 200, Đường 3.1, Khu đô thị Gamuda Garden,
                        Phường Trần Phú, Quận Hoàng Mai, TP. Hà Nội
   Hotline:              0988 769 317
   Email:                sales@digicomvn.com
   Website:              digicomvn.com

2. Thông tin thanh toán
   Số tài khoản:         567898838
   Ngân hàng:            Ngân hàng TMCP Quân đội (MB Bank)
   Chủ tài khoản:        CONG TY TNHH DVTT DIGITO COMBAT
   Nội dung chuyển khoản: [Số báo giá/mã đơn] + [Họ tên người chuyển]
   Hình thức thanh toán: Thanh toán 100% giá trị đơn hàng trước khi triển khai
                        đăng bài. Đơn giá trị lớn/khách mới có thể áp dụng đặt
                        cọc 50% - liên hệ để thống nhất trước khi đặt.

3. Hiệu lực báo giá
   Ngày phát hành:       <ngày làm báo giá>
   Hiệu lực đến hết:     <ngày phát hành + 7> (7 ngày kể từ ngày phát hành)
   Lưu ý:                Sau thời hạn trên, giá có thể thay đổi theo chính sách
                        nhà cung cấp - vui lòng liên hệ để xác nhận lại giá
                        trước khi đặt.
```

- File Excel: dựng thành sheet riêng tên `Thong tin & Thanh toan`, đặt ngay sau sheet
  "Mục lục" (nếu có) để khách thấy sớm; thêm 1 dòng trong Mục lục trỏ hyperlink tới
  sheet này.
- File Word/PDF: đặt thành 1 trang/mục riêng ở cuối văn bản, có heading rõ ràng.
- Thiếu sheet/mục này = file báo giá CHƯA ĐẠT, phải bổ sung trước khi coi là xong.

## Cấm

- Không bao giờ xuất 1 file duy nhất rồi tự ý thêm/bớt cột theo ngữ cảnh - luôn tách
  vật lý thành 2 file riêng, kể cả khi số dòng ít.
- 2 file nằm CÙNG 1 thư mục (không tách thư mục con) nhưng PHẢI khác nhau rõ ràng qua
  tên (tiền tố `NOIBO-`) VÀ màu (đỏ cảnh báo vs xanh brand) để nhìn là biết ngay, tránh
  Hiếu bấm nhầm gửi file có giá vốn cho khách.

## Liên quan

- `.claude/rules/bao-gia-khach-hang.md` - toàn bộ nguyên tắc tính giá/chiết khấu/trình bày.
- `~/.claude/rules/bao-gia-khong-lo-gia-von.md` (global) - nguyên tắc gốc không lộ giá vốn,
  áp dụng mọi dự án.
- `10-bang-gia-booking/bang-gia-booking.md` (rule) - nguồn dữ liệu giá gốc, mã NCC.
