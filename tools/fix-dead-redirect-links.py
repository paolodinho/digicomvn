#!/usr/bin/env python3
"""Sua link noi bo dang tro toi trang da bi go/301 ve trang chu hoac redirect chain.
- /dich-vu-seo/ (giai doan 2, chua ban) -> /dat-bai/ (CTA chuan theo uu-dai-cta.md)
- /entity-branding/ (khong co bai/trang thuc) -> /backlink-social-entity/ (dich vu that gan nghia nhat)
- /pr-bao-chi/ (redirect chain) -> /booking-bao-pr/ (dich thang, bo redirect chain)
- /thiet-ke-website/ (giai doan 2, chua ban) -> go link, giu nguyen text (khong co trang thay the hop ly)
"""
import json, re, sys, glob

REPL = [
    (re.compile(r'href="https://digicomvn\.com/dich-vu-seo/"'), 'href="https://digicomvn.com/dat-bai/"'),
    (re.compile(r'href="/dich-vu-seo/"'), 'href="https://digicomvn.com/dat-bai/"'),
    (re.compile(r'href="https://digicomvn\.com/entity-branding/"'), 'href="https://digicomvn.com/backlink-social-entity/"'),
    (re.compile(r'href="/entity-branding/"'), 'href="https://digicomvn.com/backlink-social-entity/"'),
    (re.compile(r'href="https://digicomvn\.com/pr-bao-chi/"'), 'href="https://digicomvn.com/booking-bao-pr/"'),
    (re.compile(r'href="/pr-bao-chi/"'), 'href="https://digicomvn.com/booking-bao-pr/"'),
]
UNLINK = re.compile(r'<a\s+[^>]*href="(?:https://digicomvn\.com)?/thiet-ke-website/"[^>]*>(.*?)</a>', re.DOTALL)

def fix(html):
    out = html
    for pat, repl in REPL:
        out = pat.sub(repl, out)
    out = UNLINK.sub(lambda m: m.group(1), out)
    return out

def main():
    ids = sys.argv[1:]
    for pid in ids:
        bfile = glob.glob(f"/Users/dohieu/Claude-Workspace/_backups/routines/2026-08-12/internal-link-fix/post{pid}-BEFORE.json")[0]
        d = json.load(open(bfile))
        html = d["content_raw"]
        new = fix(html)
        if new == html:
            print(f"{pid}: KHONG DOI (khong khop pattern nao)")
            continue
        path = f"/tmp/fix-link-{pid}.html"
        open(path, "w").write(new)
        print(f"{pid}: da tao {path}")

if __name__ == "__main__":
    main()
