# Sơ đồ giải thích đoạn phức tạp - tối thiểu 3/bài (chốt 2026-07-20)

> Rule Hiếu, xác nhận sau bài `phan-mem-di-back-link` (223) - đây là cách làm ĐÚNG,
> áp dụng cho mọi bài viết mới VÀ khi rà soát bài cũ trong dự án digicom.

## Nguyên tắc gốc

Mỗi bài viết (mới hoặc audit lại bài cũ) phải có **tối thiểu 3 sơ đồ/hình giải thích**
cho các đoạn khó hiểu/phức tạp - KHÔNG phải ảnh minh hoạ trang trí chung chung.

## Cách chọn đoạn cần làm sơ đồ

Quét bài, tìm đoạn có đặc điểm:
- Quy trình nhiều bước (vd 4 bước vận hành bot, 5 bước audit backlink...)
- Mô hình nhiều tầng/nhiều lớp (vd kim tự tháp Tier 1/2/3)
- So sánh nhiều lựa chọn/nhiều nhóm (vd bảng phân loại white-hat vs black-hat)
- Danh sách tiêu chí/checklist dài dễ đọc lướt bỏ sót

Nếu bài không đủ 3 đoạn phức tạp thật sự - báo cho Hiếu, KHÔNG bịa ra sơ đồ vô nghĩa
để đủ số lượng (rule chống scope creep/filler, xem `quality-bar.md`).

## Kỹ thuật dựng sơ đồ

- Dùng **HTML thuần (`<div>` + inline style)**, KHÔNG dùng SVG (nặng trang, từng gây
  sự cố page 472KB ở bài 222 - xem LOG.md 2026-07-20).
- Mẫu đã dùng thành công (bài 223):
  - **Quy trình N bước**: dãy card flex-wrap, mỗi card có số thứ tự tròn màu brand + tiêu đề + mô tả ngắn.
  - **Mô hình nhiều tầng**: các khối màu khác nhau xếp chồng, độ rộng tăng dần theo tầng,
    nối bằng mũi tên `&#8595;`, mỗi khối ghi tên + số liệu + vai trò.
- Màu dùng theo `ui-mau-sac.md` (brand teal/xanh, tránh mảng đen lớn).
- Tự chứa màu nền/chữ trong từng khối (không phụ thuộc CSS site) để không vỡ dark mode.
- **Đặt NGAY SAU đoạn text/danh sách gốc liên quan** - giữ nguyên text gốc, sơ đồ chỉ
  bổ sung, không thay thế (giống nguyên tắc `content-infographics.md` global).

## QA bắt buộc

- Verify dung lượng trang sau khi thêm (curl -s | wc -c) - không được tăng bất thường.
- Verify sơ đồ hiện đúng trên live (grep text đặc trưng trong mỗi khối).

## Liên quan
- `content-infographics.md` (global) - kỹ thuật bar chart bằng table+div cho bảng giá.
- `ui-mau-sac.md` - màu sắc, tránh mảng đen lớn, dark mode.
