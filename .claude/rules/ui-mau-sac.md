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
| Nút Zalo nổi `.fab-zalo` | (2026-07-15) Hiếu đổi: TRẮNG hết, bong bóng viền xanh + chữ Zalo xanh | Nền `#fff` + viền `#D6E4FF` cả 2 chế độ; SVG bong bóng `stroke #0068FF fill none`, text `#0068FF` |

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

## Thanh chọn (sel-bar) - nhẹ nhàng, nền sáng phớt TEAL (chốt 2026-07-15, ghi đè bản slab xanh)

Bản slab xanh dương đặc (chữ trắng) bị Hiếu chê nặng + "xanh da trời lấn át". Thiết kế lại NHẸ NHÀNG:
- **Nền sáng phớt teal** (`linear-gradient(180deg,#F1FAF8,--surface-2)`), viền teal mảnh
  (`rgba(14,140,127,.22)`), bóng mềm, bo 16px. Chọn 1 mục -> quầng teal nhẹ (`has-picks`).
- Chữ/nhãn dùng `--ink`/`--ink-soft`/`--heading` (đọc trên nền sáng). Số **"Còn lại" màu TEAL** to.
- **CTA "Gửi yêu cầu báo giá" = nút TEAL đặc** - nút DUY NHẤT tô màu trong thanh -> điểm nhấn.
  "Chọn lại"/"Xem danh sách" = ghost trung tính nhẹ.
- Màu chọn: **teal** (`--teal #0E8C7F`, hover `#0B746A`) - khác hẳn biển xanh dương của site, thanh thoát.
- Dark mode: panel tối nhẹ (`#1B2733`) + viền teal, số/nút teal sáng (`#5FCBBE`).
- Mobile (base + `@media max-width:640`): số tổng + CTA cũng teal cho đồng bộ (`.sel-bar-total` base,
  `.sel-bar-cta` mobile). Lưu ý: nhiều rule `.sel-bar-cta`/`.sel-bar-total` rải theo breakpoint -
  đổi màu phải quét hết (grep `sel-bar-cta{`/`sel-bar-total{`).

## Phân cấp màu nút - xanh đặc chỉ cho CTA quan trọng nhất (chốt 2026-07-15)

Hiếu: "xanh da trời dùng nhiều quá, chẳng có điểm nhấn". Nguyên tắc phân cấp:

- **Xanh brand ĐẶC (`btn-primary` / band xanh) = CHỈ dành cho CTA quan trọng nhất**, mỗi màn 1-2 cái:
  "Đặt bài ngay" (header), "Gửi yêu cầu báo giá" (sel-bar), "Nhận báo giá" (hero), nút gửi form,
  nút CTA trong popup ưu đãi, pill ưu đãi nổi. Đây là các nút phải bật lên.
- **Mọi nút còn lại = cấp PHỤ, ngang nhau**: dùng **ghost** (nền sáng + viền + chữ). Gồm: "Gọi",
  "Xem thêm", "Chọn lại", "Xem site", nút pillar, và đặc biệt **"Đặt ngay" mỗi dòng bảng giá**
  (trước tô xanh đặc lặp 12+ lần/bảng -> giờ ghost chữ xanh, `.price-table-cpt .order-now`).
- Vì "Đặt ngay" lặp rất nhiều, để nó xanh đặc là thủ phạm chính làm mất điểm nhấn. Hạ xuống ghost
  chữ xanh -> vẫn rõ là nút hành động nhưng nhường sự nổi bật cho sel-bar (điểm chốt chính).

**Khi thêm nút mới:** tự hỏi "đây có phải hành động QUAN TRỌNG NHẤT của màn này không?" Nếu không -> ghost.
Không mặc định `btn-primary`.

## Nút Zalo - đơn giản chỉ chữ (2026-07-15, chốt)
`.fab-zalo` cuối cùng: **chỉ chữ "Zalo" màu xanh #0068FF**, KHÔNG bong bóng, KHÔNG nền/viền/bóng tròn
(nền `none`, border 0, box-shadow none). SVG chỉ còn `<text>Zalo</text>`. Đây là bản Hiếu chốt.
