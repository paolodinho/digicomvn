#!/usr/bin/env python3
"""Quét toàn bộ post (publish) qua WP REST, tìm bài dùng LẶP cùng 1 ảnh (cùng src)
nhiều lần trong thân bài. In báo cáo, KHÔNG sửa gì.
"""
import json
import os
import re
import sys
import urllib.request
import urllib.parse

CRED_PATH = os.path.join(os.path.dirname(os.path.dirname(os.path.abspath(__file__))),
                          ".claude", "secrets", "wp_app.json")


def load_cred():
    with open(CRED_PATH) as f:
        c = json.load(f)
    return c["site"].rstrip("/"), c["username"], c["app_password"]


def get(site, user, pw, path):
    url = f"{site}/wp-json/{path}"
    req = urllib.request.Request(url)
    import base64
    token = f"{user}:{pw}".encode()
    req.add_header("Authorization", "Basic " + base64.b64encode(token).decode())
    with urllib.request.urlopen(req) as resp:
        return json.loads(resp.read()), dict(resp.headers)


def norm_src(src):
    # bo query string (?ver=, ?resize=...) va bo hau to -WxH truoc khi so sanh
    src = src.split("?")[0]
    src = re.sub(r"-(\d+)x(\d+)(?=\.\w+$)", "", src)
    return src


def find_dupes_in_html(html):
    srcs = re.findall(r'<img[^>]+src=["\']([^"\']+)["\']', html)
    norm = [norm_src(s) for s in srcs]
    counts = {}
    for s in norm:
        counts[s] = counts.get(s, 0) + 1
    return {s: c for s, c in counts.items() if c > 1}


def main():
    site, user, pw = load_cred()
    page = 1
    per_page = 50
    results = []
    while True:
        data, headers = get(site, user, pw,
                             f"wp/v2/posts?per_page={per_page}&page={page}&status=publish&context=edit&_fields=id,slug,link,content")
        if not data:
            break
        for post in data:
            html = post.get("content", {}).get("raw") or post.get("content", {}).get("rendered", "")
            dupes = find_dupes_in_html(html)
            if dupes:
                results.append({
                    "id": post["id"],
                    "slug": post["slug"],
                    "link": post["link"],
                    "dupes": dupes,
                })
        total_pages = int(headers.get("X-WP-TotalPages", "1"))
        if page >= total_pages:
            break
        page += 1

    print(f"Tong so bai co anh lap: {len(results)}\n")
    for r in results:
        print(f"[{r['id']}] {r['slug']}")
        print(f"  {r['link']}")
        for src, c in r["dupes"].items():
            print(f"  lap {c} lan: {src}")
        print()

    with open("/tmp/duplicate-images-report.json", "w") as f:
        json.dump(results, f, ensure_ascii=False, indent=2)
    print("Da luu bao cao: /tmp/duplicate-images-report.json")


if __name__ == "__main__":
    main()
