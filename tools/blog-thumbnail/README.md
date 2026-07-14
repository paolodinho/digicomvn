# Blog Thumbnail Generator - DigicomVN

Sinh thumbnail branded 1200x675 cho bài blog theo phong cách flat illustration xanh (đồng bộ hero).

## Cách dùng
```bash
# input: JSON list [[post_id, "Tiêu đề"], ...]
echo '[[123,"Tiêu đề bài"]]' | python3 render-illus.py
# output: out/v2-<id>-<slug>.png
```
- `illus_lib.py`: 10 illustration SVG (SEO, BACKLINK, CONTENT, TEXTLINK, PR, ANALYTICS, LOCAL, TECH, KEYWORD, IDEA).
- `render-illus.py`: tự phân loại badge + illustration theo keyword tiêu đề (hàm `classify`).
- Logo: `logo-real.png` (logo DigicomVN thật, blue+teal).
- Cần Chrome headless (macOS path hardcode trong script).

## Gắn lên WordPress (live, qua SSH)
```bash
scp out/*.png user@host:/tmp/dgc-thumbs/
# trên server, mỗi bài:
wp media import /tmp/dgc-thumbs/<id>.png --post_id=<id> --title="..." --alt="..." --porcelain
wp post meta update <id> _thumbnail_id <attachment_id>
```
Lưu ý: WP-CLI bản này KHÔNG hỗ trợ `--featured` -> phải set `_thumbnail_id` thủ công (2 bước).
