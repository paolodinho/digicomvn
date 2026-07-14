# Bảng giá booking / guest post / textlink - quy tắc (chốt 2026-07-14)

> Kho dữ liệu: `10-bang-gia-booking/`. Đọc `README.md` trong đó trước khi sửa.

## Quy tắc giá

- **Giá Digicom báo khách = GIÁ GỐC niêm yết của nhà cung cấp**, áp cho MỌI bên (kể cả DanaSEO). Không nhân markup.
- Giá chưa bao gồm VAT 8%.
- Cột `gia_ncc_km` (giá khuyến mãi / giá mua vào) = lợi nhuận Digicom. **Tuyệt đối không hiển thị cho khách, không đưa lên web.**

## Quy tắc lên web (digicomvn.com)

- Cùng 1 đầu báo + cùng quy cách bài -> **lấy giá RẺ NHẤT** trong số các nhà cung cấp.
- **ẨN danh tính nhà cung cấp.** Web không được lộ Digicom lấy hàng từ DanaSEO / Fame Media / bên nào.
- Không đưa cột giá mua vào, không đưa link nguồn NCC.
- Chạy `python3 export-web.py` -> sinh `gia-web.csv` (bản đã lọc, đã ẩn) rồi mới đưa lên web.

## Phạm vi dữ liệu

4 dịch vụ: `booking-pr` (PR báo lớn / báo tỉnh / báo link dofollow), `guest-post`, `textlink` (textlink bài, textlink home).

## Cập nhật

Scheduled task `booking-price-daily` chạy 8h05 mỗi ngày: quét lại nguồn, dựng lại master, ghi biến động vào `CHANGELOG.md`.
Sheet DanaSEO chỉ đọc được qua Chrome đã đăng nhập Google (Drive API chặn file, curl bị đòi login).
