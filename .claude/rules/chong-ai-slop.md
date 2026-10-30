# Chống dấu hiệu "AI làm" ở giao diện và câu chữ (Hiếu chốt 30/10/2026)

> Hiếu: "Research xem giao diện hay nội dung mà AI làm sẽ ntn rồi làm tránh ra, làm kĩ" + "Rà toàn trang".
> Nguồn đã đọc 30/10/2026: Wikipedia "Signs of AI writing" (en.wikipedia.org/wiki/Wikipedia:Signs_of_AI_writing),
> "Anti-AI-slop ban list" (github.com/Laith0003/ux-skill/wiki/Anti-AI-slop-ban-list),
> FindSkill "AI viết content tiếng Việt tự nhiên" (findskill.ai/vi/blog/ai-viet-content-tieng-viet-tu-nhien/).

## Giao diện - không dùng
- Tiêu đề H1/H2 viết HOA toàn bộ; tô 2 màu một cụm trong tiêu đề (`<em>` đổi màu). Tiêu đề viết hoa chữ đầu câu.
- Nhãn nhỏ (eyebrow) trên MỌI section lặp lại đúng chữ của tiêu đề. Chỉ dùng khi nhãn thêm thông tin.
- Dải số liệu độn ("Audit | miễn phí", "Báo cáo | hằng tháng", "500+") và số tròn không đếm được từ dữ liệu.
- Huy hiệu nổi đè lên ảnh, khối màu xoay lệch sau ảnh, vòng tròn/chấm trang trí trên nền.
- Mục "công thức" kiểu SEO = A + B + C, "ba trụ cột"; lưới thẻ giống hệt nhau có icon trên đầu.
- 5 sao trên lời khách khi không có hệ thống đánh giá thật.
- Ảnh stock gắn nhãn "đội ngũ DigicomVN" (chỉ ảnh văn phòng thật có logo mới được gọi là đội ngũ).

## Câu chữ - không dùng
- Phép đối phủ định: "X, không Y", "không phải... mà là...", "không chỉ... mà còn...".
- Từ phóng đại/sáo: then chốt, đóng vai trò quan trọng, toàn diện, vượt trội, hàng đầu, bứt phá, nâng tầm, đồng hành, chìa khoá, minh chứng, kỷ nguyên số, trong bối cảnh, tận tâm.
- Mở/kết bài máy: "Trong thời đại...", "Tóm lại", "Có thể thấy", "Hãy cùng...", "Đừng bỏ lỡ".
- Liệt kê đều 3 ý, đoạn nào cũng dài bằng nhau, mỗi gạch đầu dòng mở bằng "**Nhãn:**".
- Emoji/biểu tượng làm định dạng (✅ ❌ ⚠ ☐ 👉) và nhãn kiểu "CẢNH BÁO CHIẾN THUẬT", "Nói thẳng".
- Lời hứa suông, khẩu hiệu ("Con người thật, làm việc thật", "làm thật, đo được").

## Thay bằng
- Câu khẳng định thẳng, có số, ngày, tên nguồn hoặc việc cụ thể.
- Tiêu đề mô tả nội dung bên dưới ("Các bước trong một dự án SEO").

## Kiểm tra
- Quét chữ: `slopscan.py` (mẫu regex ở LOG.md 30/10/2026). Quét giao diện: Playwright đếm h1/h2 có `text-transform:uppercase`, số `.sg-eyebrow`, `.tm-stars`.
- Liên quan: `do-dont.md` mục "Câu chữ kiểu văn AI", `ui-anti-slop.md` (global), `content-professional.md` (global).
