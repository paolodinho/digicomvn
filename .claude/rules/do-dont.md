# DO / DON'T

## ✅ DO
- Đọc CLAUDE.md + PLAN.md + rules/ TRƯỚC khi bắt đầu
- Dùng template trong `.claude/templates/` nếu có sẵn
- Tham khảo `.claude/context/` cho thông tin nền
- Gọi `qa-reviewer` sau khi tạo output quan trọng
- Cập nhật LOG.md + PLAN.md cuối session
- Đề xuất phương án thay vì hỏi mở
- Nói tiếng Việt với Hiếu

## ❌ DON'T
- Không hỏi thông tin đã có trong CLAUDE.md / rules / context
- Không làm ngoài yêu cầu ("tiện tay sửa luôn")
- Không dùng emoji trong output trừ khi được yêu cầu
- Không viết comment / filler thừa
- Không claim thông tin không verify được
- Không tạo file markdown mới trừ khi user yêu cầu hoặc file đã có sẵn trong template
- Không chạy lệnh phá hủy (rm -rf, force push, drop...) mà không xin phép

## ✅ DO - Research SERP + dựng dàn bài TRƯỚC khi viết (rule Hiếu, cập nhật 2026-07-24, ghi đè bản 2026-07-21)

**Chưa viết content vội.** Thứ tự bắt buộc: research → dàn bài → viết.

1. **Research top 10 Google** (không phải top 7) bằng từ khoá chính TRONG CỤM, cộng thêm các
   từ khoá liên quan sát sườn intent (biến thể, câu hỏi con). Đọc mục lục/heading từng bài trong
   top 10 để biết đối thủ đã bao phủ những khía cạnh nào.
   - Thu thập thêm: số ảnh trung bình/bài, độ dài trung bình (từ), loại anchor text/định dạng
     (bảng, sơ đồ, ví dụ...) đối thủ đang dùng nhiều nhất.
2. **Đọc hết Google Suggested** (gợi ý tự động khi gõ từ khoá, "Mọi người cũng hỏi"/PAA, tìm
   kiếm liên quan cuối trang) để biết đúng từ khoá/câu hỏi cần chèn vào bài, đáp ứng AI Search
   và intent thật của người dùng - không đoán mò.
3. **Dựng dàn bài** (tiêu đề, cấu trúc heading, cách tiếp cận) TRƯỚC khi viết nội dung, dựa trên
   2 bước trên. Dàn bài phải:
   - **Đầy đủ như đối thủ**: bao phủ mọi khía cạnh top 10 đã làm (không thiếu khía cạnh nào đối
     thủ có mà mình bỏ sót).
   - **Tốt hơn đối thủ**: có thêm thông tin ĐỘC NHẤT, mới mẻ mà người dùng không tìm được ở đâu
     ngoài digicomvn.com - nhưng thông tin đó phải liên quan sát sườn đến đúng intent search,
     không phải thêm cho có (tránh filler/scope creep, xem `quality-bar.md`).
   - **Trả lời trực diện**: mở đầu mỗi mục/đoạn phải đi thẳng vào câu trả lời để người đọc thấy
     ngay - không vòng vo dẫn dắt dài trước khi trả lời.
   - Khuyến khích (không bắt buộc) đặt heading phụ dưới dạng câu hỏi khi phù hợp với câu hỏi
     PAA/suggested đã research.
4. Chỉ sau khi có dàn bài đạt các tiêu chí trên mới bắt đầu viết nội dung đầy đủ.

Mục tiêu: đáp ứng truy vấn tốt hơn top 10 hiện tại, không chỉ đẹp hình thức mà đúng và vượt intent.
