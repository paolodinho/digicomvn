#!/usr/bin/env python3
"""Auto-detect cụm bài (theo độ tương đồng nội dung TF-IDF) + tự động chèn internal
link còn thiếu trên digicomvn.com. Chỉ CHÈN THẬT khi đủ tin cậy (similarity cao +
tìm được cụm từ anchor tự nhiên có sẵn trong bài nguồn); trường hợp không đủ tin cậy
thì CHỈ ghi vào báo cáo, KHÔNG đụng vào bài (theo yêu cầu Hiếu 2026-08-10).

Credential: .claude/secrets/wp_app.json (gitignored, giống tools/wp-rest-publish.py).

Usage:
  python3 tools/internal-link-auto.py                 # dry-run mặc định, chỉ in báo cáo
  python3 tools/internal-link-auto.py --apply          # chèn thật lên live (có backup)
  python3 tools/internal-link-auto.py --apply --max-inserts 20   # giới hạn số link chèn/lần chạy

Ngưỡng similarity (điều chỉnh ở đầu file nếu cần):
  SIM_CANDIDATE = 0.15  -> đủ để ghi vào báo cáo "có thể liên quan"
  SIM_AUTO      = 0.28  -> đủ tin cậy để cân nhắc auto-insert (VẪN cần tìm được anchor thật)
"""
import argparse
import base64
import datetime
import html
import json
import os
import re
import sys
import urllib.error
import urllib.request

import numpy as np
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
CRED_PATH = os.path.join(ROOT, ".claude", "secrets", "wp_app.json")
MAX_LINKS_PER_POST = 5
SIM_CANDIDATE = 0.15
SIM_AUTO = 0.28
MIN_WORDS = 200  # bỏ qua bài quá ngắn (trang giới thiệu, thin content)


def load_cred():
    if not os.path.exists(CRED_PATH):
        sys.exit(f"Khong tim thay credential: {CRED_PATH}")
    with open(CRED_PATH) as f:
        c = json.load(f)
    return c["site"].rstrip("/"), c["username"], c["app_password"]


def call(method, path, site, user, pw, data=None):
    url = f"{site}/wp-json/{path}"
    body = None
    headers = {}
    if data is not None:
        body = json.dumps(data).encode()
        headers["Content-Type"] = "application/json"
    req = urllib.request.Request(url, data=body, method=method, headers=headers)
    token = f"{user}:{pw}".encode()
    req.add_header("Authorization", "Basic " + base64.b64encode(token).decode())
    try:
        with urllib.request.urlopen(req) as resp:
            return resp, json.loads(resp.read())
    except urllib.error.HTTPError as e:
        sys.exit(f"HTTP {e.code} {method} {path}: {e.read().decode()[:500]}")


def fetch_all_posts(site, user, pw):
    posts = []
    page = 1
    while True:
        resp, data = call(
            "GET",
            f"wp/v2/posts?per_page=50&page={page}&status=publish&context=edit"
            "&_fields=id,link,slug,title,content,categories",
            site, user, pw,
        )
        posts.extend(data)
        total_pages = int(resp.headers.get("X-WP-TotalPages", "1"))
        if page >= total_pages:
            break
        page += 1
    return posts


TAG_RE = re.compile(r"<[^>]+>")
HREF_RE = re.compile(r'href=["\']([^"\']+)["\']', re.I)
PARA_RE = re.compile(r"<p[^>]*>.*?</p>", re.I | re.S)


def strip_html(raw):
    text = TAG_RE.sub(" ", raw)
    return html.unescape(text)


def normalize_path(url, site_host):
    url = url.split("#")[0].split("?")[0]
    url = re.sub(r"^https?://[^/]+", "", url)
    if not url.startswith("/"):
        return None
    return url.rstrip("/") + "/"


def build_link_map(posts, site):
    site_host = re.sub(r"^https?://", "", site)
    m = {}
    for p in posts:
        path = normalize_path(p["link"], site_host)
        if path:
            m[path] = p["id"]
    return m


def existing_internal_links(raw_content, link_map):
    targets = set()
    for href in HREF_RE.findall(raw_content):
        if href.startswith("http") and "digicomvn.com" not in href:
            continue
        path = normalize_path(href, "digicomvn.com") if href.startswith("http") else \
            (href.rstrip("/") + "/" if href.startswith("/") else None)
        if path and path in link_map:
            targets.add(link_map[path])
    return targets


def count_outbound_internal(raw_content, link_map):
    return len(existing_internal_links(raw_content, link_map))


def clean_title(t):
    t = html.unescape(t)
    return re.sub(r"\s*[\-–|]\s*DigicomVN.*$", "", t, flags=re.I).strip()


def find_anchor_paragraph(raw_content, phrase):
    """Tìm đoạn <p>...</p> chứa nguyên văn phrase (không phân biệt hoa/thường),
    đoạn đó CHƯA có sẵn thẻ <a>. Trả về (đoạn gốc, vị trí bắt đầu/kết thúc phrase
    trong đoạn văn bản thuần) hoặc None nếu không tìm được ứng viên an toàn."""
    for m in PARA_RE.finditer(raw_content):
        para = m.group(0)
        if "<a " in para.lower() or "<a>" in para.lower():
            continue
        plain = strip_html(para)
        idx = plain.lower().find(phrase.lower())
        if idx == -1:
            continue
        before = plain[idx - 1] if idx > 0 else " "
        after_idx = idx + len(phrase)
        after = plain[after_idx] if after_idx < len(plain) else " "
        if before.isalnum() or after.isalnum():
            continue  # tránh cắt giữa từ/cụm dài hơn
        return m.start(), m.end(), para, plain, idx
    return None


def insert_link_in_paragraph(para, plain, idx, phrase, url):
    """Thay lần xuất hiện đầu tiên của `phrase` (theo vị trí trong bản plain-text)
    bằng thẻ <a> ngay trong HTML gốc của đoạn `para`, giữ nguyên mọi thẻ khác."""
    # Dò lại vị trí tương ứng trong HTML gốc bằng cách đếm ký tự văn bản thực
    out = []
    text_pos = 0
    i = 0
    inserted = False
    n = len(para)
    target_start = idx
    target_end = idx + len(phrase)
    while i < n:
        if para[i] == "<":
            j = para.find(">", i)
            if j == -1:
                out.append(para[i:])
                break
            out.append(para[i:j + 1])
            i = j + 1
            continue
        ch = para[i]
        if not inserted and text_pos == target_start:
            out.append(f'<a href="{url}">')
            out.append(ch)
            text_pos += 1
            i += 1
            # tiếp tục copy ký tự thô cho tới hết phrase
            while text_pos < target_end and i < n:
                if para[i] == "<":
                    break
                out.append(para[i])
                text_pos += 1
                i += 1
            out.append("</a>")
            inserted = True
            continue
        out.append(ch)
        text_pos += 1
        i += 1
    return "".join(out)


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("--apply", action="store_true", help="Chèn link thật lên live (mặc định chỉ dry-run báo cáo)")
    ap.add_argument("--max-inserts", type=int, default=15, help="Giới hạn số link chèn 1 lần chạy (an toàn)")
    args = ap.parse_args()

    site, user, pw = load_cred()
    print(f"Đang tải toàn bộ bài publish từ {site} ...")
    posts = fetch_all_posts(site, user, pw)
    print(f"Tải xong {len(posts)} bài.")

    link_map = build_link_map(posts, site)

    docs = []
    meta = []
    for p in posts:
        raw = p["content"]["raw"]
        plain = strip_html(raw)
        if len(plain.split()) < MIN_WORDS:
            continue
        docs.append(plain.lower())
        meta.append({
            "id": p["id"], "link": p["link"], "title": clean_title(p["title"]["raw"]),
            "raw": raw, "categories": p.get("categories", []),
        })

    if len(docs) < 3:
        print("Không đủ bài đạt độ dài tối thiểu để phân tích cụm.")
        return

    vec = TfidfVectorizer(token_pattern=r"(?u)\b\w+\b", min_df=2, max_df=0.6)
    X = vec.fit_transform(docs)
    sim = cosine_similarity(X)

    today = datetime.date.today().isoformat()
    backup_dir = os.path.join(ROOT, "_backups", "routines", today, "internal-link-auto")
    os.makedirs(backup_dir, exist_ok=True)
    manifest_path = os.path.join(backup_dir, "manifest.md")

    report_rows = []
    inserted = 0
    # gom theo bài nguồn để không sửa raw content nhiều lần cùng 1 request cho 1 bài trong 1 vòng
    pending_by_source = {}

    n = len(meta)
    for i in range(n):
        for j in range(n):
            if i == j:
                continue
            s = sim[i][j]
            if s < SIM_CANDIDATE:
                continue
            src, dst = meta[i], meta[j]
            existing = existing_internal_links(src["raw"], link_map)
            if dst["id"] in existing:
                continue
            outbound_now = len(existing) + pending_by_source.get(src["id"], {}).get("count", 0)
            if outbound_now >= MAX_LINKS_PER_POST:
                report_rows.append((src["link"], dst["link"], round(s, 3), "BỎ QUA", "đã đủ 5 internal link"))
                continue
            if s < SIM_AUTO:
                report_rows.append((src["link"], dst["link"], round(s, 3), "GHI NHẬN", "similarity chưa đủ tin cậy để auto"))
                continue
            found = find_anchor_paragraph(src["raw"], dst["title"])
            if not found:
                report_rows.append((src["link"], dst["link"], round(s, 3), "GHI NHẬN", "similarity cao nhưng không thấy anchor tự nhiên trong bài"))
                continue
            report_rows.append((src["link"], dst["link"], round(s, 3), "AUTO-INSERT", f'anchor: "{dst["title"]}"'))
            pending_by_source.setdefault(src["id"], {"count": 0, "items": []})
            pending_by_source[src["id"]]["count"] += 1
            pending_by_source[src["id"]]["items"].append((dst, found))

    print("\n=== BÁO CÁO ===")
    for row in report_rows:
        print(f"[{row[3]:11s}] {row[0]}  ->  {row[1]}   sim={row[2]}   {row[4]}")

    auto_count = sum(v["count"] for v in pending_by_source.values())
    print(f"\nTổng: {len(report_rows)} cặp xét, {auto_count} link đủ điều kiện auto-insert.")

    if not args.apply:
        print("\n(DRY-RUN - chưa chèn gì lên live. Chạy lại kèm --apply để thực thi.)")
        return

    with open(manifest_path, "a", encoding="utf-8") as mf:
        if os.path.getsize(manifest_path) == 0 if os.path.exists(manifest_path) else True:
            mf.write("| giờ | post_id | url | link chèn | backup |\n|---|---|---|---|---|\n")

        for src_id, pend in pending_by_source.items():
            if inserted >= args.max_inserts:
                print(f"Đã đạt giới hạn --max-inserts={args.max_inserts}, dừng lại.")
                break
            src = next(m for m in meta if m["id"] == src_id)
            raw = src["raw"]
            changed = False
            for dst, found in pend["items"]:
                if inserted >= args.max_inserts:
                    break
                start, end, para, plain, idx = found
                new_para = insert_link_in_paragraph(para, plain, idx, dst["title"], dst["link"])
                if new_para == para:
                    continue
                raw = raw[:start] + new_para + raw[end:]
                changed = True
                inserted += 1
                now = datetime.datetime.now().strftime("%H:%M")
                mf.write(f"| {now} | {src_id} | {src['link']} | -> {dst['link']} | {backup_dir}/{src_id}-before.html |\n")

            if not changed:
                continue

            backup_file = os.path.join(backup_dir, f"{src_id}-before.html")
            with open(backup_file, "w", encoding="utf-8") as bf:
                bf.write(src["raw"])

            call("POST", f"wp/v2/posts/{src_id}", site, user, pw, data={"content": raw})
            print(f"OK: cập nhật bài {src_id} ({src['link']}) - đã chèn {pend['count']} link.")

    print(f"\nĐã chèn {inserted} link thật. Backup tại: {backup_dir}")


if __name__ == "__main__":
    main()
