## Đang làm dở (checkpoint)
- Task: PR kỷ niệm 10 năm A&P Việt Nam - 2 bài CafeBiz + Diễn Đàn Doanh Nghiệp (DDDN).
- Đã xong:
  - 2 bản thảo hoàn chỉnh, đúng quy cách MỚI nhất Hiếu chốt 2026-09-16: CafeBiz 1.510 từ/5 ảnh/1 link; DDDN 1.031 từ/3 ảnh/1 link (đã bỏ bớt 1 link dofollow ddiworld.com, chỉ còn link apconsulting.vn).
  - Nội dung dùng chất liệu thật từ `AP/Boc-thong-tin-phong-van-AP.docx` (phỏng vấn bà Võ Thị Thanh Loan), không bịa số liệu. 2 case study khác nhau giữa 2 bài (CafeBiz: nhà máy sản xuất/problem-solving; DDDN: tỷ lệ nghỉ việc/talent pool) để tránh trùng nội dung khi đăng 2 báo.
  - File chính (đã ghi đè, đúng vị trí): `AP/Ban-thao-CafeBiz-AP-Vietnam-10-nam-2026-09-15.docx`, `AP/Ban-thao-DienDanDoanhNghiep-AP-Vietnam-10-nam-2026-09-15.docx`.
  - Đã dọn thư mục `bai-pr/2026/09/` (rỗng, không dùng nữa - Hiếu yêu cầu gộp về AP/).
- Đang làm: chờ Hiếu quyết định cách đồng bộ 2 link Google Drive Hiếu đã gửi trước đó (docs.google.com/document/d/1ZzJvduiuh7MHJOlzhiGGK4OMr0JlgNlZ = bản DDDN, .../1aVAIVzSHFdO3QuOTeBN3GqikyljdewiQ = bản CafeBiz) - 2 link này vẫn đang là bản CŨ (chưa đủ từ, chưa đúng số link), KHÔNG tự đồng bộ được vì:
  - API Google Drive đang kết nối (mcp 260e7656...) chỉ có `create_file` (tạo mới), `update_file` không ghi đè được nội dung file đã có (đã test, báo lỗi).
  - Trình duyệt Claude chưa đăng nhập tài khoản Google của Hiếu nên không sửa qua giao diện Docs được.
- Tiếp theo: hỏi lại Hiếu chọn 1 trong 2 hướng:
  1. Tôi tạo file mới đè lên đúng 2 file đó trên Drive (cần Hiếu xác nhận trước khi trash file cũ, vì link sẽ đổi).
  2. Hiếu tự mở 2 link, copy nội dung mới từ 2 file docx trong `AP/` dán đè vào (giữ nguyên link cũ).
  Sau khi xử lý xong Drive: còn thiếu ảnh thật gắn vào vị trí [ẢNH] (đã có bộ ảnh xử lý sẵn ở `AP/anh-chi-loan-xu-ly/6-anh-giam-doc/`), và gửi A&P duyệt trước khi chuyển toà soạn (theo brief nghiệp vụ `bai-pr/2026/08/NOIBO-Brief-Phong-Vien-AP-Vietnam-2026-08-27.docx`).
- File liên quan:
  - `/Volumes/Extreme SSD/Projects/digicom/AP/Ban-thao-CafeBiz-AP-Vietnam-10-nam-2026-09-15.docx`
  - `/Volumes/Extreme SSD/Projects/digicom/AP/Ban-thao-DienDanDoanhNghiep-AP-Vietnam-10-nam-2026-09-15.docx`
  - `/Volumes/Extreme SSD/Projects/digicom/AP/Boc-thong-tin-phong-van-AP.docx` (nguồn phỏng vấn)
  - `/Volumes/Extreme SSD/Projects/digicom/AP/anh-chi-loan-xu-ly/6-anh-giam-doc/` (ảnh thật đã xử lý, chưa gắn vào bài)
  - `/Volumes/Extreme SSD/Projects/digicom/bai-pr/2026/08/NOIBO-Brief-Phong-Vien-AP-Vietnam-2026-08-27.docx` (brief nghiệp vụ)
- Lệnh đang chạy nền: không có.
- Cập nhật lúc: 2026-09-16 11:20
