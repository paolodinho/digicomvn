#!/usr/bin/env python3
"""Đăng/sửa bài digicomvn.com qua WP REST API (Application Password).
Dùng khi KHÔNG có SSH key (phiên di động/cloud) - thay thế bước wp-cli trong
BƯỚC 6 của content-pipeline (deploy.md vẫn là cách chính khi chạy trên máy Mac).

Credential đọc từ .claude/secrets/wp_app.json (gitignored).

Usage:
  python3 tools/wp-rest-publish.py create --title "..." --slug "..." \
      --content-file bai.html --category-id 24 --status publish
  python3 tools/wp-rest-publish.py update --id 1234 --content-file bai.html
  python3 tools/wp-rest-publish.py get-raw --id 1234          # backup content.raw truoc khi sua
  python3 tools/wp-rest-publish.py set-thumbnail --id 1234 --image-file thumb.png
"""
import argparse
import json
import os
import sys
import urllib.request
import urllib.error

CRED_PATH = os.path.join(os.path.dirname(os.path.dirname(os.path.abspath(__file__))),
                          ".claude", "secrets", "wp_app.json")


def load_cred():
    if not os.path.exists(CRED_PATH):
        sys.exit(f"Khong tim thay credential: {CRED_PATH}")
    with open(CRED_PATH) as f:
        c = json.load(f)
    return c["site"].rstrip("/"), c["username"], c["app_password"]


def call(method, path, site, user, pw, data=None, raw_body=None, content_type=None):
    url = f"{site}/wp-json/{path}"
    body = raw_body
    headers = {}
    if data is not None:
        body = json.dumps(data).encode()
        headers["Content-Type"] = "application/json"
    elif content_type:
        headers["Content-Type"] = content_type
    req = urllib.request.Request(url, data=body, method=method, headers=headers)
    token = f"{user}:{pw}".encode()
    import base64
    req.add_header("Authorization", "Basic " + base64.b64encode(token).decode())
    try:
        with urllib.request.urlopen(req) as resp:
            return json.loads(resp.read())
    except urllib.error.HTTPError as e:
        sys.exit(f"HTTP {e.code}: {e.read().decode()}")


def cmd_create(args):
    site, user, pw = load_cred()
    content = open(args.content_file, encoding="utf-8").read()
    payload = {
        "title": args.title,
        "content": content,
        "status": args.status,
    }
    if args.slug:
        payload["slug"] = args.slug
    if args.category_id:
        payload["categories"] = [int(x) for x in args.category_id.split(",")]
    if args.author_id:
        payload["author"] = args.author_id
    res = call("POST", "wp/v2/posts", site, user, pw, data=payload)
    print(json.dumps({"id": res["id"], "link": res["link"], "status": res["status"]}, ensure_ascii=False))


def cmd_update(args):
    site, user, pw = load_cred()
    payload = {}
    if args.content_file:
        payload["content"] = open(args.content_file, encoding="utf-8").read()
    if args.title:
        payload["title"] = args.title
    if args.status:
        payload["status"] = args.status
    if args.category_id:
        payload["categories"] = [int(x) for x in args.category_id.split(",")]
    res = call("POST", f"wp/v2/posts/{args.id}", site, user, pw, data=payload)
    print(json.dumps({"id": res["id"], "link": res["link"], "status": res["status"]}, ensure_ascii=False))


def cmd_get_raw(args):
    site, user, pw = load_cred()
    res = call("GET", f"wp/v2/posts/{args.id}?context=edit", site, user, pw)
    out = {
        "id": res["id"],
        "title": res["title"]["raw"],
        "content_raw": res["content"]["raw"],
        "status": res["status"],
        "categories": res.get("categories"),
    }
    print(json.dumps(out, ensure_ascii=False))


def cmd_set_thumbnail(args):
    site, user, pw = load_cred()
    fname = os.path.basename(args.image_file)
    ext = fname.rsplit(".", 1)[-1].lower()
    ctype = {"png": "image/png", "jpg": "image/jpeg", "jpeg": "image/jpeg", "webp": "image/webp"}.get(ext, "application/octet-stream")
    with open(args.image_file, "rb") as f:
        raw = f.read()
    url = f"{site}/wp-json/wp/v2/media"
    req = urllib.request.Request(url, data=raw, method="POST")
    import base64
    token = f"{user}:{pw}".encode()
    req.add_header("Authorization", "Basic " + base64.b64encode(token).decode())
    req.add_header("Content-Type", ctype)
    req.add_header("Content-Disposition", f'attachment; filename="{fname}"')
    try:
        with urllib.request.urlopen(req) as resp:
            media = json.loads(resp.read())
    except urllib.error.HTTPError as e:
        sys.exit(f"HTTP {e.code}: {e.read().decode()}")
    media_id = media["id"]
    call("POST", f"wp/v2/posts/{args.id}", site, user, pw, data={"featured_media": media_id})
    print(json.dumps({"media_id": media_id, "post_id": args.id}, ensure_ascii=False))


def main():
    p = argparse.ArgumentParser()
    sub = p.add_subparsers(dest="cmd", required=True)

    c = sub.add_parser("create")
    c.add_argument("--title", required=True)
    c.add_argument("--slug")
    c.add_argument("--content-file", required=True)
    c.add_argument("--category-id")
    c.add_argument("--author-id", type=int)
    c.add_argument("--status", default="publish")
    c.set_defaults(func=cmd_create)

    u = sub.add_parser("update")
    u.add_argument("--id", required=True, type=int)
    u.add_argument("--content-file")
    u.add_argument("--title")
    u.add_argument("--category-id")
    u.add_argument("--status")
    u.set_defaults(func=cmd_update)

    g = sub.add_parser("get-raw")
    g.add_argument("--id", required=True, type=int)
    g.set_defaults(func=cmd_get_raw)

    t = sub.add_parser("set-thumbnail")
    t.add_argument("--id", required=True, type=int)
    t.add_argument("--image-file", required=True)
    t.set_defaults(func=cmd_set_thumbnail)

    args = p.parse_args()
    args.func(args)


if __name__ == "__main__":
    main()
