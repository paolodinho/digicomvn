---
name: "source-command-status"
description: "Báo cáo trạng thái dự án ngắn gọn"
---

# source-command-status

Use this skill when the user asks to run the migrated source command `status`.

## Command Template

Đọc AGENTS.md, PLAN.md, LOG.md (3 entry gần nhất) và báo cáo:

```
## 📊 Status [tên dự án]

**Mục tiêu**: ...
**Deadline gần nhất**: ... (còn N ngày)

### Tiến độ
- ✅ Đã xong: ...
- 🔥 Đang làm: ...
- 📋 Sắp làm: ...

### Blocker
- ...

### Gợi ý next action
1. ...
```

Giữ ≤ 200 từ.
