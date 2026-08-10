---
description: Submit thủ công sitemap / ép index 1 URL / ép index 1 cụm bài lên Google Search Console
argument-hint: [trống = toàn trang | "cum <slug-category>" | URL hoặc slug bài]
---

Dựa vào $ARGUMENTS chạy đúng lệnh sau (nếu $ARGUMENTS trống → không truyền gì thêm):

```bash
cd "/Users/dohieu/My Drive/Projects/digicom" && ./submit-sitemap.sh $ARGUMENTS
```

Quy tắc:
- Trống hoặc "toàn trang" → submit lại toàn bộ sitemap.
- "cum <slug-category>" (vd `cum seo-local`) → ép Google index tất cả bài publish trong cụm đó.
- 1 hoặc nhiều URL/slug (vd `mua-textlink` hoặc `https://digicomvn.com/mua-textlink/`) → ép index từng URL riêng.

Báo lại kết quả ngắn gọn (OK/FAIL từng dòng).
