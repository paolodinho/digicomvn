#!/usr/bin/env python3
"""
Quet main.css tim bien CSS custom property (--ten-bien) duoc DUNG qua var(--x)
nhung CHUA TUNG duoc DINH NGHIA (--x: ...) o bat ky dau trong file - nguyen nhan
gay loi "phan tu vo hinh" (nen/mau roi ve trang suot vi bien khong ton tai).

Sinh ra sau su co 2026-08-18: badge DR trong bang gia (price-grid.js) dung
background:var(--dr-hi/--dr-mid/--dr-lo/--dr-none) nhung 4 bien nay chua duoc
khai bao trong main.css -> nen trong suot + chu trang = 1 o vuong trang rong,
Hieu tuong nham la checkbox chon bao. Xem .claude/rules/ui-mau-sac.md.

Dung:
    python3 tools/css-var-lint.py
"""
import re
import sys
from pathlib import Path

CSS_PATH = Path(__file__).resolve().parent.parent / "wp-theme" / "digicom-host" / "assets" / "css" / "main.css"


def main():
    if not CSS_PATH.exists():
        print(f"Khong tim thay {CSS_PATH}")
        sys.exit(1)
    css = CSS_PATH.read_text(encoding="utf-8")

    used = set(re.findall(r"var\(\s*(--[a-zA-Z0-9-]+)", css))
    defined = set(re.findall(r"(--[a-zA-Z0-9-]+)\s*:", css))

    missing = sorted(used - defined)
    if not missing:
        print(f"OK - {len(used)} bien CSS custom property deu da duoc dinh nghia.")
        return

    print(f"THIEU DINH NGHIA ({len(missing)}/{len(used)} bien dang dung nhung chua khai bao):")
    for name in missing:
        # tim vai dong dung bien nay de de doi chieu
        lines = [i + 1 for i, l in enumerate(css.splitlines()) if f"var({name}" in l]
        preview = ", ".join(f"dong {n}" for n in lines[:5])
        more = f" (+{len(lines)-5} nua)" if len(lines) > 5 else ""
        print(f"  {name}  -> dung o {preview}{more}")
    sys.exit(1)


if __name__ == "__main__":
    main()
