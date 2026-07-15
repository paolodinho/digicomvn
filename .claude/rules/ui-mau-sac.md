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

## Chế độ ban đêm (dark) - lỗi hay gặp (2026-07-14)

**Không hardcode màu trong component.** Mọi `background:#fff` / `color:var(--navy)` viết cứng sẽ vỡ ở dark mode:
chữ sáng trên nền trắng, hoặc chữ tối trên nền tối - khách không đọc nổi.

Đã dính 2 lỗi ở bảng giá (đã sửa):
- `.price-table-cpt tr` (card mobile) đặt `background:#fff` -> ở dark nền vẫn trắng nhưng chữ sáng.
- `.pick-btn` ("+ Chọn báo này") đặt `color:var(--navy)` -> ở dark `--navy` là màu TỐI -> chữ tối trên nền tối.

**Quy tắc:** dùng biến semantic (`--surface`, `--surface-2`, `--heading`, `--ink`) thay vì màu cứng.
Nếu buộc dùng màu cứng -> BẮT BUỘC viết kèm block `[data-theme="dark"]` override.
**QA bắt buộc:** mỗi lần thêm component mới, bật dark mode + xem ở mobile (390px) trước khi báo xong.

## Lỗi dark mode đã gặp (2026-07-14, đợt 2)

Cùng một gốc: **màu viết cứng trong PHP/CSS không có bản override cho `[data-theme="dark"]`**.

| Chỗ | Lỗi | Cách sửa |
|---|---|---|
| Thẻ đầu báo `.press-chip` | Dark ép `background:#fff` nhưng chữ vẫn lấy `--heading` (sáng) -> chữ trắng trên nền trắng | Ép luôn `color:#1C2035` trong block dark |
| Khối bảng giá trang dịch vụ | `style="background:#fff"` inline trong `inc/service-pricing.php` | Đổi sang `var(--surface-2)` |
| Nút Zalo nổi `.fab-zalo` | Nền lấy `var(--surface-2)` -> ở dark thành nền tối, bong bóng trắng của logo nổi lổm chổm | Ép nền `#0068FF` (xanh Zalo) ở cả 2 chế độ |

**Quy tắc bổ sung:** KHÔNG viết `style="grid-template-columns:..."` inline - style inline đè cả media query, mobile vẫn giữ nhiều cột và chữ bị bóp còn 2 từ/dòng (đã dính ở `page-cam-on.php`). Dùng class + breakpoint.

## Hệ nút - chỉ 3 lớp (chốt 2026-07-15, Hiếu: "nhiều loại nút quá")

| Lớp | Class | Dùng cho |
|---|---|---|
| Chính | `btn btn-primary` (nền `--action` xanh brand) | Hành động chính, **tối đa 1 cái mỗi màn** |
| Phụ | `btn btn-ghost` (nền sáng + viền) | Gọi, Chọn lại, Xem thêm, dẫn hướng |
| Chip chọn | `.tab-btn` / `.sort-btn` - active = nền `--action` | Tab nhóm, sắp xếp, lọc |

**`btn-navy` (nền đen) CHỈ được dùng trong `.cta-band`** (band màu, là điểm nhấn hiếm).
Tuyệt đối không dùng làm nút chính trên nền sáng - vừa rối hệ nút, vừa trái rule "tiết chế màu đen".
Ngoại lệ: `btn-zalo` (xanh Zalo) chỉ cho hành động Zalo.

Hero trang dịch vụ: **tối đa 2 nút** (1 chính + 1 phụ). Đã bỏ "Nhận báo giá" vì trùng mục đích
với bảng giá (đã có nút gửi yêu cầu) và với nút Gọi.

## Thanh chọn (sel-bar) - nền xanh brand đặc (chốt 2026-07-15)

Thanh "giỏ hàng" tick chọn báo/site (`inc/sel-bar.php`) trên desktop dùng **nền xanh brand đặc**
(`linear-gradient(135deg, --action → --action-2)`), chữ trắng, tổng "Còn lại" trắng lớn, **CTA đảo màu
(nút TRẮNG chữ xanh)**. Lý do: nền cũ (gradient surface sáng) chìm hẳn trên section `--surface-2` xám -
Hiếu yêu cầu "tương phản hẳn". Đây là điểm nhấn chuyển đổi DUY NHẤT mỗi khu bảng giá nên được phép
dùng mảng màu đặc; **vẫn tuân rule tiết chế đen** (dùng xanh brand, KHÔNG dùng đen/navy). Dark mode
giữ nguyên nền xanh (xanh đặc vẫn tương phản tốt trên section tối). Mọi màu chữ con override bằng
`#fff`/`rgba(255,255,255,...)` trong block `@media(min-width:641px)` - mobile giữ bar sáng như cũ.
