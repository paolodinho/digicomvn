---
name: internal-link-audit
description: >
  Audit cấu trúc internal link toàn site digicomvn.com dựa trên DỮ LIỆU LINK THẬT
  (REST API wp/v2, content.raw), KHÔNG đoán cụm theo từ khoá/tên slug. Dùng khi
  Hiếu nhắc "audit internal link", "cụm chủ đề", "pillar/cluster", "money page
  mồ côi", "quét inlink", "over-optimization anchor", hoặc đưa 1 URL cụ thể để
  rà cluster + đề xuất bổ sung. Phát hiện pillar/cluster thật bằng phương pháp
  attractor, audit anchor text, tìm link chết/redirect chain, và quy trình lấp
  gap theo từng pillar.
---

# Digicom Internal Link Audit Skill

> Chuyển thể từ `icd-internal-link-audit` (ICD) cho digicomvn.com. Khác biệt chính:
> site chỉ ~190-250 URL (post/page/dgc_case) -> dùng **REST API** (`wp/v2`, `context=edit`)
> thay Screaming Frog, không cần crawl ngoài. Cùng nguyên tắc gốc: không đoán cụm
> theo từ khoá, chỉ tin dữ liệu link thật trong thân bài.

## Nguyên tắc gốc

1. **Không đoán cụm theo từ khoá/slug.** Gom bài theo chuỗi ký tự trùng trong
   tiêu đề tạo cụm ảo, không phản ánh cấu trúc site thật.
2. **Cả pillar lẫn cluster đều có thể có nhiều inlink** - không phân biệt được
   chỉ bằng đếm số thô. Dùng thuật toán bỏ phiếu (attractor) - xem BƯỚC 1.
3. **Chỉ tính link trong THÂN BÀI** (`content.raw`, bỏ header/footer/menu/sidebar
   - các phần này không nằm trong `content` field của REST nên tự động đã loại,
   không cần lọc `Link Position` như Screaming Frog).
4. **URL phải chuẩn hoá tuyệt đối** trước khi so sánh - `href="/slug/"` (tương
   đối) và `href="https://digicomvn.com/slug/"` (tuyệt đối) là CÙNG 1 link. Bug
   đã dính thật (2026-08-12): lọc theo `domain not in href` làm rớt 763 link
   tương đối trên toàn site trước khi sửa `norm()` để resolve relative href.

---

## BƯỚC 1 - Phát hiện pillar/cluster thật: phương pháp ATTRACTOR

```bash
cd "/Volumes/Extreme SSD/Projects/digicom" && python3 tools/internal-link-audit.py
```

Script tự:
1. Fetch toàn bộ `posts`, `pages`, `dgc_case` đang `publish` qua REST (`context=edit`
   để lấy `content.raw`).
2. Tách link nội bộ trong thân bài (`<a href="...">anchor</a>`), chuẩn hoá URL
   tuyệt đối, loại self-link.
3. Với mỗi bài A, tìm outlink có in-degree (chỉ tính content-link) **cao nhất**
   trong số outlink của A -> đó là "attractor của A" (A bỏ phiếu cho nó).
   Nếu in-degree của A đã >= mọi outlink -> A không bỏ phiếu (A tự là hub).
4. URL nhận **>= 5 vote** = pillar thật. Cluster = tập bài đã bỏ phiếu cho pillar đó.
5. Mồ côi thật = 0 outlink tới bài khác trong site VÀ 0 inlink.

Output in ra terminal (danh sách pillar + mồ côi) và ghi đầy đủ vào
`/tmp/link-audit-full.json` (`urls`, `out_links`, `indeg`, `attractor_of`,
`pillars`, `members`, `anchors`). Luôn đọc `pillars`/mồ côi TRƯỚC khi diễn giải,
không tự đoán số liệu.

**Ngưỡng 5 vote có thể chỉnh** nếu site đang giai đoạn ít bài (pivot 2026-07-02
chỉ còn ~190 URL) - báo số liệu thật (bao nhiêu URL có 3-4 vote sát ngưỡng)
trước khi tự ý đổi, đừng hạ ngưỡng âm thầm.

---

## BƯỚC 2 - Kiểm tra money page có mồ côi không

Đối chiếu `/tmp/link-audit-full.json` với danh sách 8+ trang pillar dịch vụ
(`.claude/rules/pivot-2026-07.md` mục Sitemap) - mỗi money page phải có
**>= 1-2 inlink content thật** từ bài blog liên quan (không tính menu/footer).

```bash
python3 -c "
import json
d = json.load(open('/tmp/link-audit-full.json'))
money = ['mua-textlink','dich-vu-backlink','guest-post','booking-bao-pr',
         'dich-vu-toplist','backlink-social-entity','backlink-quoc-te','booking-truyen-hinh']
for slug in money:
    urls = [u for u in d['urls'] if f'/{slug}/' in u and u.count('/') <= 4]
    for u in urls:
        print(u, '->', d['indeg'].get(u, 0), 'inlink content')
"
```

`indeg = 0` hoặc chỉ 1 -> mồ côi/gần mồ côi, cần bổ sung link (BƯỚC 3).

---

## BƯỚC 3 - Audit + vẽ sơ đồ 1 cụm cụ thể (khi Hiếu đưa 1 URL/category/từ khoá)

Dùng lệnh có sẵn **`/internal-link-map`** (không viết lại) -
`.claude/commands/internal-link-map.md` gọi `tools/internal-link-map.py` +
`tools/internal-link-map-render.py` -> dựng sơ đồ radial + bảng, publish qua
Artifact. Đây là công cụ CHỈ ĐỌC, không tự sửa link.

Sau khi xem sơ đồ, quy trình lấp gap cho pillar đó:
1. Liệt kê bài đang thật sự link về pillar (đã có trong sơ đồ).
2. Kiểm anchor text distribution (BƯỚC 4).
3. Đối chiếu từ khoá thật: research SERP theo `.claude/rules/audit-intent-truoc.md`
   + `.claude/rules/do-dont.md` (Google Suggest, PAA, top 10) - không đoán gap.
4. Viết bài lấp gap theo `content-pipeline` skill + rule viết bài của dự án
   (`content-professional.md`, `word-count-minimum.md`, `content-visual-coverage.md`).
5. Gắn internal link về pillar ngay khi viết - anchor tự nhiên, đa dạng (BƯỚC 4),
   không lặp cùng 1 anchor cho nhiều bài liên tiếp.
6. Verify: chạy lại BƯỚC 1 hoặc `/internal-link-map` để xác nhận link đã lên,
   anchor distribution vẫn trong ngưỡng an toàn.

---

## BƯỚC 4 - Ngưỡng anchor text (audit + fix over-optimization)

```bash
python3 tools/internal-link-anchor-check.py <slug-hoặc-URL>     # 1 URL đích
python3 tools/internal-link-anchor-check.py --all               # toàn site, URL >=3 inlink
```

Đọc từ `anchors` trong `/tmp/link-audit-full.json` (chạy BƯỚC 1 trước).

| Tiêu chí | Ngưỡng an toàn | Vượt ngưỡng -> xử lý |
|---|---|---|
| Exact-match anchor / tổng inlink tới 1 URL | **< 5-8%** | Viết lại anchor khác nghĩa tương đương, giữ tự nhiên |
| Anchor generic ("xem thêm", "tại đây"...) | < 5% | Viết lại thành anchor mô tả |
| Đa dạng anchor | Mỗi bài 1 anchor riêng, càng nhiều biến thể càng tốt | Gộp nhóm anchor giống nhau -> viết lại khác |

### Quy tắc cứng (chốt Hiếu 2026-08-13): **1 bài KHÔNG được link quá 1 lần tới cùng 1 đích**

Không phải ngưỡng % - là quy tắc TUYỆT ĐỐI, áp dụng bất kể tổng số inlink của đích đó cao/thấp.
Mỗi URL đích chỉ nhận **tối đa 1 link/bài nguồn**, dù bài dài, dù đích được nhắc lại nhiều lần
trong bài (CTA lặp, nhắc lại thuật ngữ nhiều đoạn...) - chỉ link ở lần nhắc ĐẦU TIÊN có ý nghĩa
nhất, các lần nhắc sau giữ plain text, không link.

Check nhanh (đọc từ `anchors` trong `/tmp/link-audit-full.json`, cần chạy BƯỚC 1 trước):
```bash
python3 -c "
import json
d = json.load(open('/tmp/link-audit-full.json'))
for k, lst in d['anchors'].items():
    if len(lst) > 1:
        src, tgt = k.split(' -> ')
        print(len(lst), src, '->', tgt)
" | sort -rn
```
Vi phạm -> xoá `<a href>` dư, giữ nguyên text, chỉ giữ 1 link ở vị trí có ngữ cảnh tốt nhất
(thường là lần nhắc đầu tiên hoặc đoạn liên quan trực tiếp nhất tới đích).

**Trạng thái 2026-08-13:** quét thấy **168 cặp (bài, đích)** đang vi phạm trên toàn site (đa số
là CTA lặp `/dat-bai/` trong bài dài, hoặc bài trong series `book-bao-*`/cụm SEO thuật ngữ nhắc
lại nhiều lần cùng 1 đích). Đây là backlog CHƯA xử lý (quy mô lớn hơn task anchor over-optimization
đã làm) - viết bài MỚI phải tuân quy tắc này ngay từ đầu; dọn 168 case cũ là việc riêng, cần Hiếu
xác nhận trước khi chạy (xem PLAN.md).

Case thật đã audit 2026-08-12: `booking-bao-pr` và `dich-vu-backlink` có anchor
exact-match chiếm 23-65% - **vượt ngưỡng nặng, chưa xử lý** (task còn tồn đọng,
xem PLAN.md).

---

## BƯỚC 5 - Link chết/redirect chain (dọn trước khi audit gap)

Trước khi tính pillar/cluster, quét trước các target đã không còn hợp lệ (dùng
kèm BƯỚC 1, so `out_links` với URL nào KHÔNG còn trong tập `urls` publish hiện tại
= link chết hoặc trỏ trang đã draft/redirect).

Nguyên tắc sửa (theo `.claude/rules/uu-dai-cta.md` + `pivot-2026-07.md`):
- Trang dịch vụ giai đoạn 2 chưa bán (`dich-vu-seo`, `thiet-ke-website`...) ->
  đổi CTA về `/dat-bai/`, hoặc gỡ link giữ nguyên text nếu không có trang thay thế hợp lý.
- Trang đã 301 sang URL khác (redirect chain, vd `/pr-bao-chi/` -> `/booking-bao-pr/`)
  -> sửa link trỏ THẲNG đích cuối, không qua redirect.
- Script mẫu đã chạy thật: `tools/fix-dead-redirect-links.py` (đọc backup JSON,
  regex remap href, xuất `/tmp/fix-link-{id}.html` để review trước khi PUT lên live).

---

## BƯỚC 6 - Chèn link còn thiếu cho money page (khi đã xác nhận anchor phù hợp)

- **Chèn tự động (TF-IDF similarity)**: `tools/internal-link-auto.py` (dry-run
  mặc định, `--apply` để chèn thật, `--max-inserts N` giới hạn). Chỉ auto-insert
  khi similarity đủ cao VÀ tìm được anchor tự nhiên có sẵn trong bài nguồn; case
  không đủ tin cậy chỉ ghi báo cáo, không đụng bài.
- **Chèn thủ công theo cặp (post_id, anchor, target) đã xác định rõ**:
  `tools/add-money-page-links.py` (khai trong dict `TASKS`, có guard
  `already_linked()` chống double-link, ghi ra `/tmp/addlink-{id}.html` để review).

**Luôn backup TRƯỚC khi PUT** (fetch `content.raw` hiện tại lưu vào
`~/Claude-Workspace/_backups/routines/<ngày>/internal-link-fix/post{id}-BEFORE.json`,
ghi manifest theo `routine-backup.md`) - cả 2 tool trên đọc backup này làm nguồn,
không fetch lại từ live mỗi lần chạy.

---

## BƯỚC 7 - Lỗi thường gặp cần tránh

1. **Đừng đếm inlink thô để xác định pillar** - cần thuật toán bỏ phiếu (BƯỚC 1),
   nếu không sẽ bị nhiễu bởi link lặp lại tự động (related-box, CTA chung).
2. **Không chèn link/shortcode vào trong thẻ heading** (H1-H6) - phá mục lục tự
   động `inc/toc.php` (đã ghi trong `external-link-eeat.md`, áp dụng chung cho
   cả internal link).
3. **CTA chuyển đổi chung trỏ `/dat-bai/`**, KHÔNG trỏ `/bang-gia/` (đã bỏ hẳn
   trang tổng hợp giá, xem `uu-dai-cta.md`) và không trỏ trang giai đoạn 2 chưa bán.
4. **Không tự tạo link tới "toplist"/"top list" khi nội dung thực chất khác nghĩa**
   (case thật: 2 lần nhắc "top list" trong bài chỉ là thuật ngữ SERP feature,
   không liên quan dịch vụ `dich-vu-toplist` - đừng ép link sai ngữ cảnh, báo gap thật).
5. **Kiểm bài đã có link gián tiếp qua bài trung gian trước khi báo "thiếu link"**
   (case thật: `booking-bao-la-gi` không link thẳng `backlink-quoc-te` vì đã link
   qua bài cụ thể hơn `booking-bao-quoc-te` - vẫn hợp lệ, không phải lỗi).
6. **Không nhắc tên/link đối thủ** khi viết bài lấp gap (`khong-link-doi-thu.md`).
7. **Backup trước khi sửa** - RULE toàn dự án (`backup-before-edit.md`,
   `routine-backup.md`), áp dụng cho MỌI lần PUT nội dung ở BƯỚC 5/6.

---

## Công cụ liên quan

| Việc | Công cụ |
|---|---|
| Phát hiện pillar/cluster/mồ côi toàn site (attractor) | `tools/internal-link-audit.py` |
| Audit anchor text 1 URL hoặc toàn site | `tools/internal-link-anchor-check.py` |
| Vẽ sơ đồ 1 cụm cụ thể (chỉ đọc) | Lệnh `/internal-link-map` -> `tools/internal-link-map.py` + `internal-link-map-render.py` |
| Auto-chèn link thiếu (TF-IDF, có ngưỡng tin cậy) | `tools/internal-link-auto.py [--apply] [--max-inserts N]` |
| Chèn link thủ công theo cặp đã xác định | `tools/add-money-page-links.py` (sửa dict `TASKS`) |
| Sửa link chết/redirect chain | `tools/fix-dead-redirect-links.py` |
| Fetch/sửa nội dung bài qua REST | `wp-json/wp/v2/{posts\|pages\|dgc_case}/{id}` (`context=edit` lấy raw), publish qua `tools/wp-rest-publish.py` |

## Liên quan
- `.claude/rules/pivot-2026-07.md` - sitemap 8 pillar dịch vụ hiện hành, tham chiếu BƯỚC 2.
- `.claude/rules/uu-dai-cta.md` - quy ước CTA `/dat-bai/`, lý do bỏ `/bang-gia/`.
- `.claude/rules/audit-intent-truoc.md`, `.claude/rules/do-dont.md` - research SERP trước khi viết bài lấp gap.
- `.claude/rules/external-link-eeat.md` - ưu tiên link nội bộ trước link ngoài khi site đã có bài riêng.
- `.claude/rules/khong-link-doi-thu.md` - không link/nhắc đối thủ trong bài lấp gap.
- `.claude/rules/routine-backup.md`, `.claude/rules/backup-before-edit.md` (global) - backup bắt buộc trước khi PUT.
- `.claude/skills/content-pipeline/SKILL.md` - quy trình viết bài đầy đủ khi lấp content gap.
- Tham khảo gốc: `icd-internal-link-audit` skill (dự án ICD) - bản Screaming Frog cho site lớn.

---

*Tạo 2026-08-13, dựa trên audit thật đã chạy (task 1 & 2 xong; task 3 - giảm
over-optimization anchor cho `booking-bao-pr`/`dich-vu-backlink` - còn tồn đọng).*
