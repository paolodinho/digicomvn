---
description: Viết bài SEO/GEO chuẩn digicomvn (blog on-site hoặc PR đăng báo) theo writing-rules
---

Viết bài tối ưu SEO/GEO cho digicomvn.com. Bám CHÍNH XÁC `.claude/rules/writing-rules.md` + `tone-voice.md` + `dich-vu.md`. KHÔNG scope creep.

Tham số (nếu user không nêu → hỏi 1 lần bằng 2-3 phương án, không hỏi mở):
- **Primary keyword** (bắt buộc)
- **Loại bài**: A (on-site blog/trang dịch vụ) hay B (PR đăng báo ngoài)
- **Dịch vụ liên quan** để cài internal link (textlink/backlink/guest post/booking báo PR/toplist/social entity/quốc tế/truyền hình)

## Bước

1. **Xác định loại bài (A/B)** — chốt trước vì quyết định tone + cách cài link (writing-rules mục 0).
2. **Research TOP 15 SERP** (writing-rules mục 5): lấy 15 kết quả xếp hạng cao nhất của primary keyword (WebSearch + Ahrefs/Semrush SERP/PAA nếu có). Ghi mỗi kết quả cover gì / thiếu gì → union sub-topic phải phủ đủ + knowledge gap = info gain. Lấy long-tail từ autocomplete + People-also-ask.
   Áp **nguyên lý patent Google** (writing-rules mục 5b + `seo-patent-process.md`): ngữ cảnh quanh anchor đa dạng, link trong body, phân đoạn trực quan sạch, backlink coi trọng phân phối chất lượng nguồn.
3. **Lấy khoảng giá/chỉ số THẬT** nếu bài cần: từ `/bang-gia/` hoặc CPT `dgc_gia`. KHÔNG bịa số (writing-rules mục 7).
4. **Viết** đúng cấu trúc theo loại bài (writing-rules mục 2):
   - Bài A: H1(WP)/intro answer-first/body/info gain/internal link box/FAQ+FAQPage schema/CTA/nguồn.
   - Bài B: tiêu đề báo chí/sapo/thân bài khách quan/1-2 anchor tự nhiên về digicomvn/kết/box liên hệ.
5. **Cài internal link** ngay khi viết (writing-rules mục 4). Bài B: 1-2 anchor, đổi anchor mỗi báo nếu rải nhiều.
6. **Self-QA** theo checklist writing-rules mục 9 + `quality-bar.md`. Sửa tới khi PASS.
7. **Gọi qa-reviewer** (Agent tool, subagent_type `qa-reviewer`) nếu bài quan trọng.
8. **Bàn giao**: xuất bài + note (anchor đã dùng, mật độ keyword, chỗ nào cần Hiếu điền số thật). Đăng on-site qua WP Admin, KHÔNG chạm PHP.

## Tuyệt đối
- KHÔNG bịa đầu báo hợp tác / case study / số liệu / tên khách hàng.
- KHÔNG dùng cụm "bài chuẩn SEO". KHÔNG emoji trong heading/CTA.
- KHÔNG nhồi keyword. Mọi link phải 200.
