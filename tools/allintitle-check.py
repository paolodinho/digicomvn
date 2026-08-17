#!/usr/bin/env python3
"""
Check allintitle count cho 1 hoac nhieu keyword, tu dong fallback qua 3 nguon
theo thu tu uu tien MIEN PHI truoc:
  1. Google Custom Search JSON API (free 100 query/ngay)
  2. SerpApi (free 100 query/thang)
  3. Serper.dev (tra phi, $50/50k - fallback cuoi cung)

Key doc tu .claude/secrets/allintitle-keys.json (gitignored). Thieu key nguon nao
thi tu bo qua nguon do, khong loi.

Usage:
  python3 tools/allintitle-check.py "booking báo vnexpress" "booking báo kenh14"
  python3 tools/allintitle-check.py --file content/keywords.txt
"""
import json
import sys
import os
import urllib.request
import urllib.parse
import argparse
import datetime

SCRIPT_DIR = os.path.dirname(os.path.abspath(__file__))
PROJECT_ROOT = os.path.dirname(SCRIPT_DIR)
KEYS_PATH = os.path.join(PROJECT_ROOT, ".claude", "secrets", "allintitle-keys.json")
USAGE_LOG = os.path.join(PROJECT_ROOT, ".claude", "secrets", "allintitle-usage.json")


def load_keys():
    if not os.path.exists(KEYS_PATH):
        return {}
    with open(KEYS_PATH) as f:
        return json.load(f)


def load_usage():
    if not os.path.exists(USAGE_LOG):
        return {}
    with open(USAGE_LOG) as f:
        return json.load(f)


def save_usage(usage):
    with open(USAGE_LOG, "w") as f:
        json.dump(usage, f, indent=2)


def today():
    return datetime.date.today().isoformat()


def this_month():
    return datetime.date.today().strftime("%Y-%m")


def bump_usage(usage, source, period_key):
    usage.setdefault(source, {})
    usage[source][period_key] = usage[source].get(period_key, 0) + 1
    save_usage(usage)


# ---- Nguon 1: Google Custom Search JSON API (free 100/ngay/project) ----
# Ho tro NHIEU key (nhieu project Google Cloud cung 1 tai khoan) -> tu xoay vong
# khi 1 key het quota 100/ngay, khong can tao nhieu tai khoan Google rieng.
def query_google_cse(keyword, keys, usage):
    projects = keys.get("google_cse", [])
    if not projects:
        return None
    day = today()
    usage.setdefault("google_cse", {}).setdefault(day, {})
    for proj in projects:
        api_key = proj.get("api_key")
        cx = proj.get("cx")
        label = proj.get("label", api_key[:8] if api_key else "unknown")
        if not api_key or not cx:
            continue
        used = usage["google_cse"][day].get(label, 0)
        if used >= 100:
            continue  # project nay het quota hom nay -> thu project tiep theo
        q = f'intitle:"{keyword}"'
        params = urllib.parse.urlencode({"key": api_key, "cx": cx, "q": q})
        url = f"https://www.googleapis.com/customsearch/v1?{params}"
        try:
            req = urllib.request.Request(url)
            with urllib.request.urlopen(req, timeout=15) as r:
                data = json.load(r)
            usage["google_cse"][day][label] = used + 1
            save_usage(usage)
            total = int(data.get("searchInformation", {}).get("totalResults", 0))
            return {"source": f"google_cse:{label}", "allintitle": total}
        except urllib.error.HTTPError as e:
            if e.code in (429, 403):
                continue  # project nay het quota/loi quyen -> thu project ke tiep
            raise
    return None  # het sach moi project Google CSE -> fallback sang nguon khac


# ---- Nguon 2: SerpApi (free 100/thang) ----
def query_serpapi(keyword, keys, usage):
    api_key = keys.get("serpapi_key")
    if not api_key:
        return None
    month = this_month()
    used = usage.get("serpapi", {}).get(month, 0)
    if used >= 100:
        return None
    q = f'intitle:"{keyword}"'
    params = urllib.parse.urlencode({"q": q, "api_key": api_key, "engine": "google"})
    url = f"https://serpapi.com/search.json?{params}"
    try:
        req = urllib.request.Request(url)
        with urllib.request.urlopen(req, timeout=20) as r:
            data = json.load(r)
        bump_usage(usage, "serpapi", month)
        total = data.get("search_information", {}).get("total_results", 0)
        return {"source": "serpapi", "allintitle": total}
    except urllib.error.HTTPError as e:
        if e.code in (429, 401, 403):
            return None
        raise


# ---- Nguon 3: Serper.dev (tra phi, fallback cuoi) ----
def query_serper(keyword, keys, usage):
    api_key = keys.get("serper_key")
    if not api_key:
        return None
    q = f'intitle:"{keyword}"'
    url = "https://google.serper.dev/search"
    payload = json.dumps({"q": q}).encode()
    req = urllib.request.Request(url, data=payload, method="POST")
    req.add_header("X-API-KEY", api_key)
    req.add_header("Content-Type", "application/json")
    with urllib.request.urlopen(req, timeout=20) as r:
        data = json.load(r)
    bump_usage(usage, "serper", "total")
    total = data.get("searchInformation", {}).get("totalResults", None)
    if total is None:
        total = len(data.get("organic", []))
    return {"source": "serper", "allintitle": total}


def check_keyword(keyword, keys, usage):
    for fn in (query_google_cse, query_serpapi, query_serper):
        try:
            result = fn(keyword, keys, usage)
        except Exception as e:
            result = None
            print(f"  [loi {fn.__name__}: {e}]", file=sys.stderr)
        if result:
            return result
    return {"source": "KHONG_CO_NGUON_NAO_KHA_DUNG", "allintitle": None}


def main():
    parser = argparse.ArgumentParser()
    parser.add_argument("keywords", nargs="*")
    parser.add_argument("--file", help="File .txt, moi dong 1 keyword")
    args = parser.parse_args()

    keywords = list(args.keywords)
    if args.file:
        with open(args.file, encoding="utf-8") as f:
            keywords += [line.strip() for line in f if line.strip()]

    if not keywords:
        print("Chua co keyword nao. Vi du: python3 tools/allintitle-check.py \"booking báo vnexpress\"")
        sys.exit(1)

    keys = load_keys()
    if not keys:
        print(f"CHUA CO FILE KEY: {KEYS_PATH}")
        print("Tao file theo mau .claude/secrets/allintitle-keys.example.json truoc khi chay.")
        sys.exit(1)

    usage = load_usage()

    print(f"{'Keyword':<45} {'Allintitle':>10}  Nguon")
    print("-" * 75)
    for kw in keywords:
        r = check_keyword(kw, keys, usage)
        val = r["allintitle"] if r["allintitle"] is not None else "N/A"
        print(f"{kw:<45} {str(val):>10}  {r['source']}")


if __name__ == "__main__":
    main()
