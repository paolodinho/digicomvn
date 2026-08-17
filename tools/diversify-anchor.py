#!/usr/bin/env python3
"""Giam anchor over-optimization cho 2 pillar: booking-bao-pr, dich-vu-backlink.
Doc danh sach bai nguon tu /tmp/anchor-fix-sources.json (da tinh tu link-audit-full.json),
fetch content.raw qua REST, BACKUP truoc khi sua, roi thay 1 anchor lap lai qua nhieu
bien the tu nhien (round-robin) de khong bien the nao vuot 8% tong inlink cua pillar do.

Usage:
  python3 tools/diversify-anchor.py --fetch      # fetch + backup toan bo bai nguon (chay 1 lan)
  python3 tools/diversify-anchor.py --plan        # in ke hoach thay anchor (khong sua gi)
  python3 tools/diversify-anchor.py --apply       # ghi file HTML moi ra /tmp/anchor-new-{id}.html
"""
import json, re, sys, base64, urllib.request, urllib.error, html as htmlmod

ROOT = "/Volumes/Extreme SSD/Projects/digicom"
CRED = json.load(open(f"{ROOT}/.claude/secrets/wp_app.json"))
SITE = CRED["site"].rstrip("/")
AUTH = base64.b64encode(f"{CRED['username']}:{CRED['app_password']}".encode()).decode()
BACKUP_DIR = "/Users/dohieu/Claude-Workspace/_backups/routines/2026-08-13/anchor-diversify"
SOURCES = json.load(open("/tmp/anchor-fix-sources.json"))

TARGET_BBP = "https://digicomvn.com/booking-bao-pr/"
TARGET_BL = "https://digicomvn.com/dich-vu-backlink/"

# pool bien the tu nhien - moi nhom ung voi 1 cau/y nghia goc, xoay vong de khong
# bien the nao vuot 8% tong inlink cua pillar (118 cho bbp, 42 cho backlink)
POOLS_BBP = {
    # nhom "a" - link kieu "doi ngu dich vu booking bao & PR cua DigicomVN" (33 lan)
    "dịch vụ booking báo &amp; pr của digicomvn": [
        "dịch vụ booking báo &amp; PR của DigicomVN",
        "đội ngũ booking báo chí của DigicomVN",
        "team booking báo &amp; PR DigicomVN",
        "chuyên viên booking báo của DigicomVN",
        "bộ phận booking báo chí DigicomVN",
        "dịch vụ đặt bài PR trên báo của DigicomVN",
        "đội booking báo &amp; PR",
        "chuyên gia booking báo chí",
    ],
    # nhom "b" - link kieu "bang gia booking bao PR day du cua DigicomVN" (15 lan)
    "bảng giá booking báo pr đầy đủ của digicomvn": [
        "bảng giá booking báo PR đầy đủ của DigicomVN",
        "bảng giá chi tiết theo từng đầu báo",
        "báo giá booking báo &amp; PR đầy đủ",
        "danh sách giá booking báo của DigicomVN",
        "bảng giá đăng bài theo đầu báo",
    ],
    # nhom "c" - bare "booking báo & PR" (13 lan)
    "booking báo &amp; pr": [
        "booking báo &amp; PR",
        "dịch vụ đặt bài trên báo",
        "booking báo chí",
        "đăng bài PR trên báo",
        "booking báo &amp; PR chuyên nghiệp",
    ],
    # nhom "d" - bare "dịch vụ booking báo & PR" (12 lan)
    "dịch vụ booking báo &amp; pr": [
        "dịch vụ booking báo &amp; PR",
        "dịch vụ booking báo chí",
        "dịch vụ đặt lịch đăng bài PR",
        "giải pháp booking báo &amp; PR",
        "dịch vụ booking báo &amp; PR trọn gói",
    ],
}

POOLS_BL = {
    # "dich vu backlink" bare (20 lan, threshold ~3/42=7% -> can >=7 bien the)
    "dịch vụ backlink": [
        "dịch vụ backlink",
        "dịch vụ backlink của DigicomVN",
        "giải pháp backlink",
        "hệ thống backlink chất lượng",
        "dịch vụ xây dựng backlink",
        "dịch vụ mua backlink",
        "backlink chuyên nghiệp",
        "gói dịch vụ backlink",
    ],
    # "bang gia" generic (10 lan)
    "bảng giá": [
        "bảng giá dịch vụ backlink",
        "xem chi tiết bảng giá",
        "báo giá backlink",
        "bảng giá và danh sách site",
        "chi phí dịch vụ backlink",
    ],
    "dịch vụ backlink chất lượng": [
        "dịch vụ backlink chất lượng",
        "backlink chất lượng cao",
        "dịch vụ backlink uy tín",
    ],
}


def api(path):
    req = urllib.request.Request(SITE + path, headers={"Authorization": f"Basic {AUTH}"})
    with urllib.request.urlopen(req, timeout=30) as r:
        return json.loads(r.read())


def slug_from_url(u):
    return u.rstrip("/").rsplit("/", 1)[-1]


def fetch_post_by_slug(slug):
    for pt in ("posts", "pages"):
        try:
            batch = api(f"/wp-json/wp/v2/{pt}?slug={slug}&context=edit&_fields=id,link,content,type")
        except urllib.error.HTTPError:
            continue
        if batch:
            return batch[0]
    return None


def cmd_fetch():
    all_slugs = [slug_from_url(u) for u in SOURCES["bbp"] + SOURCES["bl"]]
    ok, fail = 0, []
    for slug in all_slugs:
        out = f"{BACKUP_DIR}/{slug}-BEFORE.json"
        import os
        if os.path.exists(out):
            ok += 1
            continue
        d = fetch_post_by_slug(slug)
        if not d:
            fail.append(slug)
            continue
        json.dump({
            "id": d["id"], "type": d["type"], "link": d["link"],
            "content_raw": d["content"]["raw"] if isinstance(d["content"], dict) else d["content"],
        }, open(out, "w"), ensure_ascii=False, indent=1)
        ok += 1
    print(f"OK {ok}, FAIL {fail}")


def replace_one(html, anchor_text_lower, target_url, new_anchor):
    """Thay dung 1 occurrence <a href="target_url">anchor_text</a> (case-insensitive so anchor,
    chap ca href tuyet doi lan tuong doi) bang anchor moi. Tra ve (html_moi, so_luong_thay)."""
    slug_path = "/" + target_url.split("digicomvn.com/", 1)[1]  # vd /booking-bao-pr/
    href_alt = r'(?:https://digicomvn\.com)?' + re.escape(slug_path) + r'(?:#[a-z0-9-]+)?'
    pat = re.compile(
        r'(<a\s+[^>]*href="' + href_alt + r'"[^>]*>)(' + re.escape(anchor_text_lower) + r')(</a>)',
        re.IGNORECASE,
    )
    m = pat.search(html)
    if not m:
        return html, 0
    new_html = html[:m.start(2)] + new_anchor + html[m.end(2):]
    return new_html, 1


def build_plan(pools, target_url, group_key):
    """Tra ve dict slug(list theo thu tu xuat hien trong anchors data) -> (old_anchor, new_anchor)."""
    d = json.load(open("/tmp/link-audit-full.json"))
    anchors = d["anchors"]
    plan = []  # list of (src_url, old_anchor_raw, new_anchor)
    counters = {k: 0 for k in pools}
    for k, lst in anchors.items():
        src, tgt = k.split(" -> ")
        if tgt != target_url:
            continue
        for a in lst:
            al = a.strip()
            al_low = al.lower()
            if al_low in pools:
                pool = pools[al_low]
                idx = counters[al_low] % len(pool)
                counters[al_low] += 1
                new_a = pool[idx]
                if new_a.lower() != al_low:  # bo qua neu trung chinh no (bien the dau tien = ban goc)
                    plan.append((src, al, new_a))
    return plan


def cmd_plan():
    for name, pools, tgt in [("BOOKING-BAO-PR", POOLS_BBP, TARGET_BBP), ("DICH-VU-BACKLINK", POOLS_BL, TARGET_BL)]:
        plan = build_plan(pools, tgt, name)
        print(f"\n=== {name}: {len(plan)} link se doi anchor ===")
        for src, old, new in plan[:200]:
            print(f"  {slug_from_url(src):45s} | {old[:40]:40s} -> {new}")


def cmd_apply():
    import os
    total_applied = 0
    for name, pools, tgt in [("BOOKING-BAO-PR", POOLS_BBP, TARGET_BBP), ("DICH-VU-BACKLINK", POOLS_BL, TARGET_BL)]:
        plan = build_plan(pools, tgt, name)
        by_slug = {}
        for src, old, new in plan:
            by_slug.setdefault(slug_from_url(src), []).append((old, new))
        for slug, changes in by_slug.items():
            bfile = f"{BACKUP_DIR}/{slug}-BEFORE.json"
            if not os.path.exists(bfile):
                print(f"  BO QUA {slug}: khong co backup")
                continue
            d = json.load(open(bfile))
            html = d["content_raw"]
            n_applied = 0
            for old, new in changes:
                html, n = replace_one(html, old, tgt, new)
                n_applied += n
            if n_applied:
                open(f"/tmp/anchor-new-{d['id']}.html", "w").write(html)
                print(f"  OK {slug} (id={d['id']}, type={d['type']}): {n_applied}/{len(changes)} thay doi")
                total_applied += n_applied
            else:
                print(f"  KHONG KHOP {slug}: {changes}")
    print(f"\nTong: {total_applied} link da doi anchor. File moi: /tmp/anchor-new-{{id}}.html")


if __name__ == "__main__":
    cmd = sys.argv[1] if len(sys.argv) > 1 else "--plan"
    if cmd == "--fetch":
        cmd_fetch()
    elif cmd == "--apply":
        cmd_apply()
    else:
        cmd_plan()
