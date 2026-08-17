# Nội dung bài viết PHẢI hiển thị đẹp trên mọi phiên bản - không tràn/vỡ (chốt 2026-08-12)

> Sự cố gốc: quét thật bằng Playwright (viewport 390px) phát hiện nhiều bài đang bị tràn ngang
> (overflow) hoặc vỡ layout trên di động - nguyên nhân chủ yếu là các khối HTML tự viết trong
> nội dung bài (card dãy, bar chart, bảng, sơ đồ theo `content-diagram-explain.md` /
> `content-infographics.md`) thiếu `max-width:100%` hoặc dùng `flex`/`grid` không wrap đúng.

## Nguyên tắc bắt buộc

Mọi khối HTML tự viết chèn vào nội dung bài (card-grid, bar chart table+div, sơ đồ quy trình,
bảng dữ liệu, widget) phải đảm bảo **KHÔNG BAO GIỜ gây tràn ngang (horizontal overflow)** ở
bất kỳ độ rộng màn hình nào, đặc biệt các mốc mobile: **360, 390, 414px**.

### Nguyên nhân tràn hay gặp - kiểm tra trước khi chèn bất kỳ khối HTML nào

| Lỗi | Cách tránh |
|---|---|
| `width:Npx` cố định (bar chart theo `content-infographics.md`) không kèm `max-width:100%` | LUÔN thêm `max-width:100%` cùng `width:Npx` |
| `display:flex` nhiều item cố định width, không `flex-wrap:wrap` | Luôn có `flex-wrap:wrap` trên container flex chứa nhiều card |
| `<table>` nhiều cột không bọc trong khối cho phép cuộn riêng | Dùng class `.dgc-data-table` (đã có CSS responsive theo `content-diagram-explain.md`) - không tự viết `<table>` trần |
| `grid-template-columns` nhiều cột cố định px, không có `@media` giảm cột | Dùng `repeat(auto-fit,minmax(...,1fr))` hoặc breakpoint giảm cột ở mobile |
| Ảnh chèn trực tiếp không qua `<img>` chuẩn WP (thiếu `max-width:100%;height:auto`) | Luôn để WP tự chèn ảnh qua block ảnh chuẩn, không tự viết `<img style="width:600px">` |
| `<pre>`/code block dài không `overflow-x:auto` | Bọc `overflow-x:auto` nếu có code/text dài không ngắt dòng |
| `white-space:nowrap` trên text dài (không phải nhãn ngắn) | Chỉ dùng `nowrap` cho cụm ngắn (số+đơn vị, tên riêng - xem `wording-orphans.md`), không dùng cho câu dài |

### Bắt buộc trước khi coi 1 bài là "xong" (bài mới HOẶC audit bài cũ có đụng HTML tự viết)

1. Mọi `width:Npx` cố định trong style inline PHẢI kèm `max-width:100%`.
2. Mọi container `display:flex` chứa từ 2 card trở lên PHẢI có `flex-wrap:wrap`.
3. Không viết `<table>` trần - dùng `.dgc-data-table` hoặc kỹ thuật table+div theo
   `content-infographics.md` (đã có cuộn riêng theo breakpoint).
4. QA thật bằng công cụ (không chỉ đọc code đoán) - xem mục "Công cụ kiểm tra" dưới đây.

## Công cụ kiểm tra - `tools/mobile-overflow-check.py`

Dùng Playwright (Chromium headless, đã cài) để đo THẬT `scrollWidth` vs viewport ở 390px trên
URL live - không đoán từ source code (source có thể trông ổn nhưng CSS thật gây vỡ).

```bash
python3 tools/mobile-overflow-check.py                    # quét toan bo URL trong /tmp/all-urls.txt
python3 tools/mobile-overflow-check.py /tmp/1-url.txt      # quet 1 URL (file 1 dong)
```

Lấy danh sách URL đầy đủ từ sitemap trước khi quét:
```bash
for s in posts-post-1 posts-page-1 posts-dgc_case-1; do curl -s "https://digicomvn.com/wp-sitemap-$s.xml" -A "Mozilla/5.0"; done | grep -oE '<loc>[^<]+</loc>' | sed 's/<[^>]*>//g' > /tmp/all-urls.txt
```

Output: in trực tiếp `OVERFLOW <N>px <url>` cho từng bài lỗi + ghi chi tiết (element/class/HTML
gây lỗi, tối đa 5 offender/trang) vào `/tmp/mobile-overflow-report.json`.

**Bắt buộc chạy sau khi:** viết bài mới có chèn khối HTML tự viết, sửa CSS ảnh hưởng
`.page-content`, hoặc audit/refresh bài cũ có đụng tới card/bảng/sơ đồ HTML.

## QA trình duyệt thật (khi cần xem trực quan, không chỉ số liệu)

DevTools/Browser tool resize về 360, 390, 414, 768px (kéo co giãn liên tục) - theo đúng mốc đã
quy định ở `menu-single-line.md` / `wording-orphans.md`, áp dụng thêm cho THÂN BÀI VIẾT (không
chỉ menu/heading).

## Liên quan
- `content-diagram-explain.md` - kỹ thuật dựng card/bảng, class `.dgc-data-table`.
- `content-infographics.md` (global) - kỹ thuật bar chart table+div, `max-width:100%`.
- `ui-mau-sac.md` - màu sắc, dark mode (lỗi tương tự do style inline không kiểm ở mọi trạng thái).
- `quality-bar.md` - "test UI trong browser trước khi báo xong" áp dụng cả cho bài viết, không
  chỉ trang code/UI.
