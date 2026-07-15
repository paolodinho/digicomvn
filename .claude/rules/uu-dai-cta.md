# Ưu đãi & luồng chuyển đổi (rule Hiếu, 2026-07-14)

## Ưu đãi phải nói RÕ và có sức ép

Khối ưu đãi (`inc/promo-band.php`, hiện ở trang chủ + mọi trang dịch vụ) luôn gồm:

1. **Ghi rõ ưu đãi là gì** - không nói chung chung. Hai ưu đãi cốt lõi hiện tại:
   - **Viết bài chuẩn SEO miễn phí** (đặt từ 3 đầu báo trở lên).
   - **Tư vấn và chọn báo miễn phí**, không ràng buộc.
2. **Khan hiếm** - hiển thị số suất còn lại (option `promo_slots`, WP Admin > DigicomVN). Để trống/0 = ẩn dòng này. Chỉ ghi con số Hiếu định, không tự bịa.
3. **Giới hạn thời gian** - hạn chót + đếm ngược ngày/giờ (option `promo_deadline`, yyyy-mm-dd). Để trống = tự lấy hết tháng hiện tại (ưu đãi không bao giờ hiện "đã hết hạn" nếu quên cập nhật).
4. **Nhãn ưu đãi từng ô** - cột thứ 3 trong option `promos` (`tiêu đề | mô tả | nhãn`).

Khi thêm ưu đãi mới: sửa trong WP Admin, KHÔNG sửa PHP.

## Gửi form xong -> trang cảm ơn

Form lead gửi thành công -> redirect sang **`/cam-on/`** (kèm `?dv=<dịch vụ>`), không quay lại form nữa.
- Template `page-cam-on.php` (WP tự nhận theo slug), page tự tạo khi kích hoạt theme.
- Trang cảm ơn: noindex, nêu 3 bước tiếp theo, nút gọi/Zalo, link bảng giá + blog.
- Đây cũng là mốc đo chuyển đổi (Analytics/Ads) - đừng gộp lại về form như cũ.
- Lỗi (thiếu tên/liên hệ) vẫn báo tại chỗ ở form, không chuyển trang.

## Giao diện mặc định: SÁNG

Site luôn mở ở **bản sáng**, kể cả khi máy khách đang để dark mode (`header.php` không đọc `prefers-color-scheme` nữa). Chỉ khi khách tự bấm nút mặt trăng mới chuyển tối và ghi nhớ lựa chọn đó.

## Ưu đãi quy ra TIỀN (2026-07-14)

Khối ưu đãi + popup hiển thị số tiền tiết kiệm tối đa (option `promo_saving`, mặc định **25 triệu/đơn**)
kèm dòng giải thích (`promo_saving_note`). Sửa trong WP Admin > DigicomVN.

**Con số phải tính được từ bảng giá thật, không ghi bừa.** Cách tính hiện tại:
đơn 15 đầu báo lớn (giá TB đang bán ~8,2tr/bài) = ~123tr -> chiết khấu combo bậc cao nhất 15% = ~18,4tr,
cộng 15 bài viết miễn phí (~500k/bài) = ~7,5tr -> **~25tr**. Đổi bậc chiết khấu/bảng giá -> tính lại số này.

## Popup ưu đãi (`inc/promo-popup.php`)

Hiện 1 lần/phiên (sessionStorage), sau 7 giây hoặc khi cuộn qua 35% trang. KHÔNG hiện trên
`/bang-gia/`, `/dat-bai/`, `/cam-on/` (khách đã ở bước chuyển đổi). Nút chính -> `/bang-gia/`.
**Không auto-focus nút CTA** - focus ring bao quanh nút trông như lỗi giao diện.

## Thuật ngữ

KHÔNG dùng "bài chuẩn SEO" trên toàn site. Dùng: "viết bài", "viết bài PR", hoặc "viết nội dung chuẩn SEO/GEO".

## Thiết kế lại khối ưu đãi - mềm hơn (2026-07-15)

Hiếu chê "thô cứng quá". Đã làm mềm khối `inc/promo-band.php` (CSS, không đổi markup):
- Icon 4 ô bọc **badge bo tròn nền tint** (xanh/teal xen kẽ) thay icon stroke trần.
- Nhãn ô (`.promo-tag`) đổi thành **pill mềm nền tint**, BỎ viền vuông cứng.
- Khối "Tiết kiệm tối đa" (`.promo-saving`) nền **gradient tint** bo tròn thay hộp viền + vạch trái.
- **Bỏ vạch màu cứng** chạy ngang đầu dải 4 ô (`.promo-sec .promos::before` đã xoá).
- Nền section dịu (radial nhạt) thay gradient xanh→be + bỏ viền trên 2px đặc.
- Vẫn giữ dải 4 ô liền (không tách 4 card rời - tránh AI-slop theo ui-anti-slop.md).

## Ưu đãi: pill nổi + popup thay khối to (2026-07-15)

Bỏ hẳn khối ưu đãi to (`inc/promo-band.php` KHÔNG còn được include ở đâu - giữ file để rollback).
Thay bằng **pill nổi** `inc/promo-fab.php` (góc trái dưới, mọi trang trừ bang-gia/dat-bai/cam-on):
- Hiển thị "Ưu đãi đến <promo_saving>" + đếm ngược tới `promo_deadline` (cả 2 TỰ tính theo thời điểm,
  sửa ở WP Admin). Countdown tái dùng class `.promo-count` + `.promo-count-val` nên JV đếm ngược
  giây có sẵn (main.js ~L463) tự cập nhật cả pill lẫn popup.
- Bấm pill (`[data-pop-open]`) -> mở popup `#promoPop`; popup bấm "Xem bảng giá" -> `/bang-gia/`.
- **Popup KHÔNG còn tự bật sau 7s/cuộn 35%** (bỏ auto + bỏ sessionStorage gating) - giờ người dùng
  chủ động bấm pill. Logic ở IIFE popup trong main.js.
- FAB đặt góc TRÁI dưới (z-index 81) để không đụng Zalo/back-to-top (góc phải); mobile nâng lên trên
  bottom-nav (`--bn-h`).

## Pill ưu đãi: sang phải, gọn, màu nhạt (2026-07-15)

Hiếu: "gọn hơn, cho sang bên kia, màu đừng nổi bật". Pill `inc/promo-fab.php` giờ:
- Đặt **góc PHẢI dưới, ngay trên nút Zalo** (`right:20;bottom:154` desktop; mobile `right:12;bottom:bn-h+150`).
- **Nền trắng (`--surface-2`) + viền nhẹ (`--line-2`)**, KHÔNG còn khối gradient xanh. Chỉ điểm teal nhỏ:
  icon trong vòng tròn teal nhạt + chữ số tiền teal; đếm ngược màu chữ trung tính.
- Kích thước nhỏ hơn (icon 28px, chữ 11.5/10px). Vẫn bấm -> mở popup -> bảng giá như cũ.

## Giới thiệu báo/trang: POPUP + pill màu nóng (2026-07-15)

- Khối "Giới thiệu báo này" KHÔNG xổ dọc trong dòng nữa (làm trang dài, khó theo dõi) -> mở **popup**
  (modal giữa trang, `.intro-pop` tạo bằng JS). `.intro-detail` mỗi dòng vẫn render nhưng LUÔN ẩn,
  chỉ làm nguồn nội dung; JS đổ innerHTML + tên báo (`.row-name`) vào modal chung khi bấm `.intro-toggle`.
  Trang không đổi layout khi mở.
- Pill ưu đãi (`.promo-fab`) đổi sang **màu NÓNG (gradient cam #FF7A3D -> đỏ #F0492E)**, chữ trắng,
  "25 triệu" điểm vàng nhạt (#FFE2B0). LƯU Ý: đồng hồ đếm ngược có class `.promo-count` (nền trắng sẵn)
  -> chữ đếm ngược PHẢI để màu tối (`--ink-soft`/`--heading`), không để trắng (tàng hình trên capsule trắng).

## Pill cam hết + Zalo trắng (2026-07-15, tinh chỉnh)

- Pill ưu đãi (`.promo-fab`): **CAM hết, chữ TRẮNG toàn bộ**, nhỏ gọn thêm. Đồng hồ đếm ngược:
  vì có class `.promo-count` (nền trắng sẵn) nên phải ép `background:transparent;border:0;padding:0`
  + chữ trắng để "cam hết" (nếu không sẽ còn capsule trắng lổm chổm).
- Nút Zalo nổi: **TRẮNG hết, chữ/bong bóng XANH** (`.fab-zalo` nền `#fff` viền `#D6E4FF`; SVG bong bóng
  `stroke:#0068FF;fill:none`, text `#0068FF`). Ngược với bản cũ (nền xanh chữ trắng).

## Ưu đãi: ribbon trên cùng thay pill nổi (2026-07-15)

Pill nổi góc phải bị lọt/khó thấy -> BỎ (`inc/promo-fab.php` không include nữa; giữ file rollback).
Thay bằng **ribbon trên cùng trang** `inc/promo-bar.php` (include đầu `header.php`, ngay sau wp_body_open):
- Dải ngang màu nóng (gradient cam->đỏ), chữ trắng: "Ưu đãi đến <promo_saving>/đơn · Kết thúc sau <đếm ngược> · Nhận ưu đãi →". Bấm cả dải -> mở popup (`data-pop-open`).
- Ribbon ẩn ở `bang-gia/dat-bai/cam-on` (popup bị loại ở đó -> tránh bấm không ra gì; khách đã ở bước chốt).
- Countdown tái dùng `.promo-count`/`.promo-count-val`; ép `background:none` để không dính capsule trắng.

## Thanh chọn mobile: chưa chọn thì KHÔNG hiện nút gửi (2026-07-15)
`@media(max-width:768px) .sel-bar:not(.has-picks) .sel-bar-actions{display:none}` - lúc 0 mục chỉ hiện
dòng nhắc "Tick chọn...", nút "Gửi yêu cầu báo giá" vô nghĩa nên ẩn (chỉ hiện khi đã tick >=1 mục).

## "Giới thiệu báo/trang" = chỉ icon "i" (2026-07-15)
Bỏ chữ "Giới thiệu ... này" (dài dòng) -> nút `.intro-toggle` chỉ còn **vòng tròn "i" teal** (icon-only),
tooltip qua `title`, a11y qua `aria-label`. Bấm vẫn mở popup giới thiệu như cũ.

## Cập nhật 2026-07-15 (batch UI)
- **Ribbon ưu đãi GHIM (sticky)**: `.promo-bar` `position:sticky;top:0;z-index:60`. JS (main.js đầu file) đo `offsetHeight` ribbon -> set biến `--ribbon-h`; `.site-header` `top:var(--ribbon-h,0px)` và `.sel-bar` `top:calc(84px + var(--ribbon-h))` để không chồng. Trang ẩn ribbon (bang-gia/dat-bai/cam-on) -> JS set `--ribbon-h:0px`.
- **Nút Zalo nổi = vòng tròn** (GHI ĐÈ bản "chỉ chữ" ở trên): `.fab-zalo` 58px tròn, nền trắng, viền `#D6E4FF`, chữ "Zalo" xanh `#0068FF` (SVG text giữ nguyên). Dark mode giữ trắng.
- **Icon "i" giới thiệu báo = superscript ngay sau tên** (GHI ĐÈ "chỉ icon i" đặt dòng riêng): button `.intro-toggle` nằm TRONG `.row-name`, `vertical-align:super`, 15px. Bấm vẫn mở popup giới thiệu.
- **Section dịch vụ trang chủ** (`front-page.php`): bỏ lưới nhóm-card (dgc_service_groups) bị lệch, thay bằng `.svc-links` (lưới card-link 4x2) link thẳng tới 7 trang pillar + ô "Tất cả dịch vụ" -> /dich-vu/. Danh sách pillar cố định theo sitemap (slug không đổi).
