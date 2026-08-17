#!/usr/bin/env python3
"""Tinh % anchor text cho 1 URL dich, doc tu /tmp/link-audit-full.json
(output cua tools/internal-link-audit.py). Dung o BUOC 4 cua skill internal-link-audit
de phat hien over-optimization (1 anchor chiem qua nhieu % tong inlink toi 1 URL).

Usage:
  python3 tools/internal-link-audit.py                     # sinh /tmp/link-audit-full.json truoc
  python3 tools/internal-link-anchor-check.py booking-bao-pr   # 1 slug
  python3 tools/internal-link-anchor-check.py --all            # quet toan bo URL co >=3 inlink
"""
import json, re, sys
from collections import Counter
from urllib.parse import urlparse

DATA = "/tmp/link-audit-full.json"
GENERIC = {"xem thêm", "tại đây", "bấm vào đây", "click", "xem chi tiết", "ở đây",
           "tìm hiểu thêm", "xem bảng giá", "bảng giá", "xem ngay", "read more", "click here"}
THRESHOLD_EXACT = 0.08  # 8% - nguong an toan toi da cho 1 anchor giong nhau

def norm_anchor(a):
    return re.sub(r"\s+", " ", a).strip().lower()

def report_for(target_frag, anchors_by_target):
    matches = [t for t in anchors_by_target if target_frag in t]
    if not matches:
        print(f"Khong tim thay URL chua '{target_frag}' trong du lieu.")
        return
    for tgt in matches:
        lst = anchors_by_target[tgt]
        total = len(lst)
        if total == 0:
            continue
        cnt = Counter(norm_anchor(a) for a in lst)
        print(f"\n=== {tgt} ({total} inlink) ===")
        for anchor, n in cnt.most_common(10):
            pct = n / total
            flag = ""
            if anchor in GENERIC and pct >= 0.05:
                flag = "  <-- GENERIC vuot 5%"
            elif pct >= THRESHOLD_EXACT:
                flag = f"  <-- VUOT NGUONG {THRESHOLD_EXACT:.0%} (over-optimization)"
            print(f"  {pct:5.1%}  ({n:3d})  {anchor or '(rong/chi anh)'}{flag}")

def main():
    d = json.load(open(DATA))
    anchors_raw = d["anchors"]  # key: "src -> tgt", value: [anchor,...]
    by_target = {}
    for k, lst in anchors_raw.items():
        tgt = k.split(" -> ")[1]
        by_target.setdefault(tgt, []).extend(lst)

    if len(sys.argv) < 2:
        print(__doc__)
        return
    if sys.argv[1] == "--all":
        for tgt, lst in sorted(by_target.items(), key=lambda x: -len(x[1])):
            if len(lst) >= 3:
                report_for(urlparse(tgt).path.strip("/"), by_target)
    else:
        report_for(sys.argv[1], by_target)

if __name__ == "__main__":
    main()
