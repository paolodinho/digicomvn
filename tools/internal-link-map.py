#!/usr/bin/env python3
"""Vẽ bản đồ internal link của MỘT cụm bài digicomvn.com - gọi TAY khi cần (không tự động).

Cho biết: bài nào link tới bài nào, chiều liên kết, anchor text dùng, và số lượng
internal link trỏ VỀ từng bài (trong cụm + tổng toàn site).

Cách chọn cụm (1 trong 3):
  --category <slug>      lọc theo chuyên mục WP (xem danh sách: --list-categories)
  --search "<từ khoá>"   lọc bài có từ khoá trong tiêu đề
  --urls a.com/x/,b/y/   liệt kê URL/slug cụ thể (phân tách bởi dấu phẩy)

Output: JSON ra stdout (nodes + edges + anchor + inbound count) để dựng sơ đồ/báo cáo.
Không sửa gì lên live - chỉ đọc.

Usage:
  python3 tools/internal-link-map.py --list-categories
  python3 tools/internal-link-map.py --category backlink-offpage
  python3 tools/internal-link-map.py --search "guest post"
"""
import argparse
import base64
import html
import json
import os
import re
import sys
import urllib.error
import urllib.request

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
CRED_PATH = os.path.join(ROOT, ".claude", "secrets", "wp_app.json")


def load_cred():
    if not os.path.exists(CRED_PATH):
        sys.exit(f"Khong tim thay credential: {CRED_PATH}")
    with open(CRED_PATH) as f:
        c = json.load(f)
    return c["site"].rstrip("/"), c["username"], c["app_password"]


def call(path, site, user, pw):
    url = f"{site}/wp-json/{path}"
    req = urllib.request.Request(url, method="GET")
    token = f"{user}:{pw}".encode()
    req.add_header("Authorization", "Basic " + base64.b64encode(token).decode())
    try:
        with urllib.request.urlopen(req) as resp:
            return resp, json.loads(resp.read())
    except urllib.error.HTTPError as e:
        sys.exit(f"HTTP {e.code} GET {path}: {e.read().decode()[:400]}")


def fetch_all(site, user, pw, post_type):
    """post_type: 'posts' hoặc 'pages'. Trang (pages) = money page/pillar (vd /booking-bao-pr/),
    KHÔNG có category taxonomy nhưng vẫn phải nằm trong đồ thị link - bỏ sót sẽ làm mất đúng
    node trung tâm thật (pillar nhận link tổng lực từ mọi bài con)."""
    items = []
    page = 1
    while True:
        resp, data = call(
            f"wp/v2/{post_type}?per_page=50&page={page}&status=publish&context=edit"
            "&_fields=id,link,slug,title,content,categories",
            site, user, pw,
        )
        items.extend(data)
        total_pages = int(resp.headers.get("X-WP-TotalPages", "1"))
        if page >= total_pages:
            break
        page += 1
    for it in items:
        it["_type"] = "page" if post_type == "pages" else "post"
    return items


A_TAG_RE = re.compile(r'<a\s+[^>]*href=["\']([^"\']+)["\'][^>]*>(.*?)</a>', re.I | re.S)
TAG_RE = re.compile(r"<[^>]+>")


def strip_html(raw):
    return html.unescape(TAG_RE.sub("", raw)).strip()


def normalize_path(url):
    url = url.split("#")[0].split("?")[0]
    url = re.sub(r"^https?://[^/]+", "", url)
    if not url.startswith("/"):
        return None
    return url.rstrip("/") + "/"


def clean_title(t):
    t = html.unescape(t)
    return re.sub(r"\s*[\-–|]\s*DigicomVN.*$", "", t, flags=re.I).strip()


def build_link_map(posts):
    m = {}
    for p in posts:
        path = normalize_path(p["link"])
        if path:
            m[path] = p["id"]
    return m


def extract_edges(post, link_map):
    """Trả về list (target_id, anchor_text) cho mọi internal link trong content."""
    edges = []
    for href, inner in A_TAG_RE.findall(post["content"]["raw"]):
        path = normalize_path(href) if href.startswith(("http", "/")) else None
        if not path or path not in link_map:
            continue
        target_id = link_map[path]
        if target_id == post["id"]:
            continue
        anchor = strip_html(inner)
        edges.append((target_id, anchor))
    return edges


def select_cluster(posts, args, cats_by_id, link_map_all, all_content_by_id):
    if args.category:
        slug = args.category
        cat_id = None
        for cid, s in cats_by_id.items():
            if s == slug:
                cat_id = cid
        if cat_id is None:
            sys.exit(f"Không tìm thấy category slug '{slug}'. Dùng --list-categories để xem.")
        return [p for p in posts if cat_id in p.get("categories", [])]
    if args.search:
        kw = args.search.lower()
        return [p for p in posts if kw in strip_html(p["title"]["raw"]).lower()]
    if args.urls:
        wanted = set()
        for u in args.urls.split(","):
            u = u.strip()
            if not u.startswith("http"):
                u = "https://digicomvn.com/" + u.strip("/") + "/"
            wanted.add(normalize_path(u))
        ids = {link_map_all[w] for w in wanted if w in link_map_all}
        return [all_content_by_id[i] for i in ids if i in all_content_by_id]
    sys.exit("Cần chỉ định --category, --search hoặc --urls (xem --help).")


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("--category")
    ap.add_argument("--search")
    ap.add_argument("--urls")
    ap.add_argument("--list-categories", action="store_true")
    args = ap.parse_args()

    site, user, pw = load_cred()

    if args.list_categories:
        _, cats = call("wp/v2/categories?per_page=50&_fields=id,slug,count", site, user, pw)
        for c in cats:
            print(f"{c['id']:4d}  {c['slug']:30s}  {c['count']} bài")
        return

    posts = fetch_all(site, user, pw, "posts")
    pages = fetch_all(site, user, pw, "pages")
    all_content = posts + pages
    link_map = build_link_map(all_content)
    content_by_id = {p["id"]: p for p in all_content}

    _, cats = call("wp/v2/categories?per_page=50&_fields=id,slug", site, user, pw)
    cats_by_id = {c["id"]: c["slug"] for c in cats}

    cluster = select_cluster(posts, args, cats_by_id, link_map, content_by_id)
    if not cluster:
        sys.exit("Cụm rỗng - không tìm thấy bài nào khớp điều kiện.")
    cluster_ids = {p["id"] for p in cluster}

    # Tự kéo thêm TRANG (page) có link qua lại với cụm - vd money page pillar như
    # /booking-bao-pr/ nhận link tổng lực từ mọi bài con nhưng bản thân là 'page',
    # không có category -> không lọt vào `cluster` ở bước select, phải bù riêng.
    for pg in pages:
        if pg["id"] in cluster_ids:
            continue
        linked_out = any(t in cluster_ids for t, _ in extract_edges(pg, link_map))
        linked_in = any(
            pg["id"] in {t for t, _ in extract_edges(p, link_map)} for p in cluster
        )
        if linked_out or linked_in:
            cluster.append(pg)
            cluster_ids.add(pg["id"])

    nodes = []
    for p in cluster:
        nodes.append({
            "id": p["id"],
            "title": clean_title(p["title"]["raw"]),
            "url": p["link"],
            "type": p["_type"],
        })

    edges = []
    inbound_total = {p["id"]: 0 for p in all_content}  # tổng site
    inbound_in_cluster = {p["id"]: 0 for p in cluster}

    for p in all_content:
        for target_id, anchor in extract_edges(p, link_map):
            if target_id in inbound_total:
                inbound_total[target_id] += 1
            if p["id"] in cluster_ids and target_id in cluster_ids:
                edges.append({
                    "from_id": p["id"], "from_url": p["link"],
                    "to_id": target_id, "to_url": content_by_id[target_id]["link"],
                    "anchor": anchor,
                })
                inbound_in_cluster[target_id] += 1

    out = {
        "cluster_size": len(cluster),
        "nodes": [
            {**n, "inbound_in_cluster": inbound_in_cluster.get(n["id"], 0),
             "inbound_total_site": inbound_total.get(n["id"], 0)}
            for n in nodes
        ],
        "edges": edges,
    }
    print(json.dumps(out, ensure_ascii=False, indent=2))


if __name__ == "__main__":
    main()
