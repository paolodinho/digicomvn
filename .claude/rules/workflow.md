# Workflow — Quy trình chuẩn

## Mỗi task mới
1. **Hiểu yêu cầu** — đọc lại CLAUDE.md + PLAN.md nếu chưa rõ context
2. **Plan nếu cần** — task > 3 bước → viết plan ngắn trước khi làm
3. **Làm** — bám sát yêu cầu, không scope creep
4. **Self-QA** — tự check theo `rules/quality-bar.md`
5. **Gọi qa-reviewer** — dùng Agent tool với `subagent_type` tương ứng
6. **Sửa theo QA** — fix cho đến khi PASS
7. **Auto-update** — nếu trong lúc làm Hiếu đưa thêm yêu cầu/rule/quyết định mới → update ngay vào file phù hợp (xem mục dưới)
8. **Log** — cập nhật LOG.md + PLAN.md
9. **Báo cáo** — 1-3 câu: đã làm gì, kết quả, next

## 🔄 Auto-update (NGUYÊN TẮC BẮT BUỘC)

Mỗi khi Hiếu đưa ra yêu cầu/preference/quyết định → tự động persist vào:
- Rule mới ("từ nay…", "luôn…", "đừng…") → `.claude/rules/` (file phù hợp)
- Thông tin dự án (mục tiêu, đối tượng, ràng buộc) → `CLAUDE.md`
- Task / ưu tiên / blocker → `PLAN.md`
- Quyết định quan trọng + lý do → `DECISIONS.md`
- Context brand/audience/competitor → `.claude/context/`

KHÔNG hỏi "có muốn ghi không" — ghi luôn, báo 1 dòng: `✏️ Đã update [file]: [tóm tắt]`
Chi tiết ở `~/.claude/CLAUDE.md` (global rules).

## Khi không chắc
- KHÔNG hỏi mở kiểu "anh muốn làm thế nào?"
- ĐƯA 2-3 phương án + khuyến nghị + lý do → user chọn nhanh

## Khi phát hiện vấn đề ngoài scope
- KHÔNG tự sửa
- Ghi vào PLAN.md phần "backlog" hoặc dùng `spawn_task`

## Khi xong session
- Cập nhật LOG.md
- Cập nhật PLAN.md (tick task đã xong, thêm task mới nếu có)
