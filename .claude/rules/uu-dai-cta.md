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
