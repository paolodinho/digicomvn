#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""B1 loc trang rac (2026-07-19): kiem tra domain trong gia-web.csv theo 2 lop:
  1) DNS: khong resolve duoc -> DEAD_DOMAIN (tin cay cao, ten mien thuc su chet/het han).
  2) HTTP: domain resolve duoc nhung GET loi -> phan biet BLOCKED (403/429, bot-block, site
     van song) voi LOI_KHAC (timeout/5xx/loi ket noi that su, can xem tay).
KHONG tu xoa gi - chi bao cao report-link-status.csv de Hieu doi chieu."""
import csv, os, socket, re, concurrent.futures, requests
requests.packages.urllib3.disable_warnings()

BASE = os.path.dirname(os.path.abspath(__file__))
UA = {"User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0 Safari/537.36",
      "Accept-Language": "vi-VN,vi;q=0.9,en;q=0.8"}

rows = list(csv.DictReader(open(os.path.join(BASE, "gia-web.csv"))))
raw_doms = sorted(set(r["dau_bao"] for r in rows if r["dich_vu"] != "booking-tv"))
DOMAIN_RE = re.compile(r"^[a-z0-9]([a-z0-9-]{0,61}[a-z0-9])?(\.[a-z0-9]([a-z0-9-]{0,61}[a-z0-9])?)+$", re.I)
doms = [d for d in raw_doms if DOMAIN_RE.match(d.strip())]
print(f"Kiem tra {len(doms)}/{len(raw_doms)} domain hop le (loai bo ten khong phai domain thuc)...")

def check(d):
    try:
        socket.getaddrinfo(d, 443)
    except Exception:
        return d, "DEAD_DOMAIN", "khong resolve DNS"
    for scheme in ("https", "http"):
        for attempt in range(2):
            try:
                resp = requests.get(f"{scheme}://{d}", headers=UA, timeout=12, verify=False, allow_redirects=True)
                if resp.status_code in (403, 429):
                    return d, "BLOCKED", f"HTTP {resp.status_code} (co the chan bot, khong chac chet)"
                if resp.status_code >= 400:
                    return d, "HTTP_LOI", f"HTTP {resp.status_code}"
                return d, "OK", str(resp.status_code)
            except requests.exceptions.SSLError:
                break
            except Exception as e:
                if attempt == 0:
                    continue
    return d, "LOI_KET_NOI", "timeout/loi ket noi ca https lan http"

results = []
with concurrent.futures.ThreadPoolExecutor(max_workers=20) as ex:
    for i, r in enumerate(ex.map(check, doms)):
        results.append(r)
        if (i + 1) % 150 == 0:
            print(f"  {i+1}/{len(doms)}")

with open(os.path.join(BASE, "report-link-status.csv"), "w", newline="") as f:
    w = csv.writer(f)
    w.writerow(["domain", "trang_thai", "chi_tiet"])
    w.writerows(sorted(results, key=lambda x: (x[1], x[0])))

from collections import Counter
c = Counter(r[1] for r in results)
print("\nTong hop:", dict(c))
print("\n-> Ghi report-link-status.csv. DEAD_DOMAIN la dang tin cay nhat (domain khong con ton tai).")
