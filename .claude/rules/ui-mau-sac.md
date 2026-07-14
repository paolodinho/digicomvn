# Màu sắc UI digicomvn.com - tiết chế màu đen (rule Hiếu, 2026-07-14)

## Nguyên tắc
Màu tối/đen (`--navy`, `--navy-2`) chỉ dùng làm **điểm nhấn hiếm**, KHÔNG dùng làm nền
cho các khối nội dung lặp lại. Mảng đen lớn/lặp nhiều làm trang nặng nề, cũ.

## Được dùng nền tối (giữ nguyên)
- Footer (đang cân nhắc đổi).
- 1 band ảnh đội ngũ (`.band-navy` + ảnh nền) - điểm neo thị giác duy nhất giữa trang.
- Hero trang dịch vụ (`.page-hero`) - 1 khối/trang.
- 1 nút CTA chính trong thanh chọn (`Gửi yêu cầu báo giá`).

## KHÔNG dùng nền tối
- Card/thẻ trong lưới lặp lại (promo, feature, why, service) -> nền sáng + viền nhẹ,
  icon mang màu brand (`--action` xanh dương / `--teal`).
- Nút lặp lại nhiều lần trong 1 màn (vd "Đặt ngay" mỗi dòng bảng giá) -> dùng `--action`.

## Khi thêm section mới
Mặc định nền sáng (`--surface` / `--surface-2`), phân tách section bằng viền + đổi nền sáng,
không bằng khối đen. Muốn nhấn mạnh -> dùng màu brand, không dùng đen.
