#!/usr/bin/env python3
"""Audit internal link thuc te qua REST API (thay Screaming Frog vi site chi ~190 URL).
Lay content.raw cua toan bo post/page/dgc_case dang publish, tach link noi bo trong than bai,
dung thuat toan attractor (skill internal-link-audit BUOC 2) de xac dinh pillar/cluster thuc.
"""
import json, re, base64, urllib.request, sys
from collections import defaultdict, Counter
from urllib.parse import urlparse

CRED = json.load(open("/Volumes/Extreme SSD/Projects/digicom/.claude/secrets/wp_app.json"))
SITE = CRED["site"].rstrip("/")
AUTH = base64.b64encode(f"{CRED['username']}:{CRED['app_password']}".encode()).decode()

def api(path):
    req = urllib.request.Request(SITE + path, headers={"Authorization": f"Basic {AUTH}"})
    with urllib.request.urlopen(req, timeout=30) as r:
        return json.loads(r.read())

def fetch_all(post_type):
    out = []
    page = 1
    while True:
        try:
            batch = api(f"/wp-json/wp/v2/{post_type}?per_page=100&page={page}&context=edit&status=publish&_fields=id,link,content,type")
        except urllib.error.HTTPError as e:
            if e.code == 400: break
            raise
        if not batch: break
        out.extend(batch)
        if len(batch) < 100: break
        page += 1
    return out

def norm(u):
    p = urlparse(u)
    path = p.path or "/"
    if not path.endswith("/") and "." not in path.rsplit("/", 1)[-1]:
        path += "/"
    return f"https://{p.netloc}{path}".lower()

def main():
    items = []
    for pt in ["posts", "pages", "dgc_case"]:
        items.extend(fetch_all(pt))
    print(f"Tong {len(items)} URL publish", file=sys.stderr)

    urls = {norm(it["link"]) for it in items}
    domain = urlparse(SITE).netloc

    out_links = defaultdict(set)   # source -> set(target)
    anchors = defaultdict(list)    # (source,target) -> [anchor texts]
    href_re = re.compile(r'<a\s+[^>]*href="([^"]+)"[^>]*>(.*?)</a>', re.IGNORECASE | re.DOTALL)
    tag_re = re.compile(r'<[^>]+>')

    for it in items:
        src = norm(it["link"])
        html = it["content"]["raw"] if isinstance(it["content"], dict) else it["content"]
        for m in href_re.finditer(html or ""):
            href, inner = m.group(1), tag_re.sub("", m.group(2)).strip()
            if href.startswith("/") and not href.startswith("//"):
                href = f"https://{domain}{href}"
            elif domain not in href:
                continue
            tgt = norm(href)
            if tgt == src:
                continue
            out_links[src].add(tgt)
            anchors[(src, tgt)].append(inner)

    # in-degree (content link) cho moi URL trong site
    indeg = Counter()
    for src, tgts in out_links.items():
        for t in tgts:
            if t in urls:
                indeg[t] += 1

    # attractor voting
    attractor_of = {}
    for a in urls:
        outs = [t for t in out_links.get(a, set()) if t in urls]
        if not outs:
            attractor_of[a] = None
            continue
        best = max(outs, key=lambda t: indeg.get(t, 0))
        attractor_of[a] = best if indeg.get(best, 0) > indeg.get(a, 0) else None

    votes = Counter(v for v in attractor_of.values() if v)
    pillars = {p: n for p, n in votes.items() if n >= 5}
    members = defaultdict(list)
    for a, p in attractor_of.items():
        if p in pillars:
            members[p].append(a)

    print("\n=== PILLAR THAT (>=5 vote) ===")
    for p, n in sorted(pillars.items(), key=lambda x: -x[1]):
        print(f"{n:3d}  {p}")

    orphans = [a for a in urls if attractor_of.get(a) is None and indeg.get(a, 0) == 0]
    print(f"\n=== MO COI (khong outlink toi bai khac trong site, khong ai link toi) === {len(orphans)}")
    for o in sorted(orphans)[:40]:
        print(" ", o)

    with open("/tmp/link-audit-full.json", "w") as f:
        json.dump({
            "urls": sorted(urls),
            "out_links": {k: sorted(v) for k, v in out_links.items()},
            "indeg": dict(indeg),
            "attractor_of": attractor_of,
            "pillars": pillars,
            "members": {k: sorted(v) for k, v in members.items()},
            "anchors": {f"{k[0]} -> {k[1]}": v for k, v in anchors.items()},
        }, f, ensure_ascii=False, indent=1)
    print("\nChi tiet day du: /tmp/link-audit-full.json")

if __name__ == "__main__":
    main()
