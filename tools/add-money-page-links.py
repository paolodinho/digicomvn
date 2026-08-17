#!/usr/bin/env python3
"""Chen internal link INLINE vao anchor da co san trong cau (khong them chu moi),
cho 2 money page dang thieu inlink: mua-textlink, backlink-quoc-te.
Chi chen 1 lan/bai, bo qua neu doan da nam trong the <a> co san."""
import json, re, sys

TASKS = {
    # id: (anchor_regex, target_url)
    4720: (r'\btextlink\b', 'mua-textlink'),
    2205: (r'\btextlink\b', 'mua-textlink'),
    2204: (r'\btextlink\b', 'mua-textlink'),
    2203: (r'\btextlink\b', 'mua-textlink'),
    2202: (r'\btextlink\b', 'mua-textlink'),
    2201: (r'\btextlink\b', 'mua-textlink'),
    2200: (r'\btextlink\b', 'mua-textlink'),
    2199: (r'\btextlink\b', 'mua-textlink'),
    2198: (r'\btextlink\b', 'mua-textlink'),
    2197: (r'\btextlink\b', 'mua-textlink'),
    2196: (r'\btextlink\b', 'mua-textlink'),
    2195: (r'\btextlink\b', 'mua-textlink'),
    2194: (r'\btextlink\b', 'mua-textlink'),
    2193: (r'\btextlink\b', 'mua-textlink'),
    2192: (r'\btextlink\b', 'mua-textlink'),
    2189: (r'\btextlink\b', 'mua-textlink'),
    1278: (r'\btextlink\b', 'mua-textlink'),
    544: (r'Textlink\b', 'mua-textlink'),
    232: (r'\bTextlink\b', 'mua-textlink'),
    1260: (r'booking báo quốc tế', 'backlink-quoc-te'),
    1275: (r'đặt bài trên các đầu báo quốc tế', 'backlink-quoc-te'),
}

def already_linked(html, pos):
    before = html[max(0, pos - 200):pos]
    return before.rfind('<a ') > before.rfind('</a>')

def process(pid, pattern, target_slug):
    d = json.load(open(f"/Users/dohieu/Claude-Workspace/_backups/routines/2026-08-12/internal-link-fix/post{pid}-BEFORE.json"))
    html = d["content_raw"]
    target = f"https://digicomvn.com/{target_slug}/"
    if target in html:
        print(f"{pid}: DA CO LINK toi {target_slug} roi, bo qua")
        return
    rx = re.compile(pattern)
    for m in rx.finditer(html):
        if already_linked(html, m.start()):
            continue
        # kiem tra khong nam trong 1 tag html khac (vd href attr)
        tag_ctx = html[max(0, m.start()-30):m.start()]
        if '="' in tag_ctx and tag_ctx.rfind('"') < tag_ctx.rfind('='):
            continue
        new = html[:m.start()] + f'<a href="{target}">{m.group(0)}</a>' + html[m.end():]
        open(f"/tmp/addlink-{pid}.html", "w").write(new)
        print(f"{pid}: OK -> {target_slug} (anchor: '{m.group(0)}')")
        return
    print(f"{pid}: KHONG TIM THAY anchor phu hop")

if __name__ == "__main__":
    for pid, (pat, slug) in TASKS.items():
        process(pid, pat, slug)
