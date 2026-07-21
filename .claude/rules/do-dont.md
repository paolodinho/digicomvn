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

## ✅ DO - Research SERP trước khi viết (rule Hiếu 2026-07-21)
- Research 7 kết quả đầu Google bằng từ khoá chính trong cụm
- Thu thập: (1) số ảnh trung bình/bài, (2) độ dài trung bình (từ), (3) mục lục từng bài để biết các khía cạnh đã được đề cập
- **Làm TỐT NHẤT trong top 7.** Nếu top 7 thằng nhiều nhất có 12 loại anchor text thì mình phải làm 12 loại, không thể chỉ 6. Nếu thằng nhiều ảnh nhất có 10 ảnh thì mình phải làm 10 ảnh.
- Sau đó: tìm chi tiết đúng intent khách hàng để viết THÊM - tạo information gain
- Mục tiêu: đáp ứng truy vấn tốt hơn top 7 hiện tại
