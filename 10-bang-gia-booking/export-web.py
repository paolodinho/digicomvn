#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""Xuat bang gia CONG KHAI cho digicomvn.com tu bang-gia-master.csv

Quy tac (chot 2026-07-14):
- Cung 1 dau bao + cung quy cach bai -> LAY GIA RE NHAT trong so cac NCC.
- AN danh tinh nha cung cap (khach khong duoc biet Digicom lay hang tu dau).
- An luon gia mua vao (gia_ncc_km).
- Gia hien thi = gia_ban_digicom, chua VAT 8%.

Output: gia-web.csv  (san sang import vao WP / dung cho page bang gia)
"""
import csv, os, re, unicodedata
from collections import defaultdict

BASE = os.path.dirname(os.path.abspath(__file__))
SRC = os.path.join(BASE, "bang-gia-master.csv")
OUT = os.path.join(BASE, "gia-web.csv")

def domain(s):
    """Chuan hoa ten dau bao ve domain de gom nhom giua cac NCC."""
    s = (s or "").strip().lower()
    s = re.sub(r"^https?://", "", s)
    s = re.sub(r"^www\.", "", s)
    s = s.split("/")[0].strip()
    return s or (s or "")

def fold(s):
    s = unicodedata.normalize("NFD", (s or "").lower())
    s = "".join(c for c in s if unicodedata.category(c) != "Mn")
    return re.sub(r"[^a-z0-9]+", " ", s).strip()

def spec_key(r):
    """Khoa 'cung quy cach': vi tri + so link + quy cach bai."""
    return (fold(r["vi_tri"]), fold(r["so_link"]), fold(r["quy_cach"]))

with open(SRC) as f:
    rows = [r for r in csv.DictReader(f) if r["gia_ban_digicom"]]

# Gom theo: dich vu + domain + quy cach -> chon gia re nhat
groups = defaultdict(list)
for r in rows:
    groups[(r["dich_vu"], domain(r["dau_bao"])) + spec_key(r)].append(r)

web = []
for key, g in groups.items():
    best = min(g, key=lambda r: int(r["gia_ban_digicom"]))
    web.append({
        "dich_vu": best["dich_vu"],
        "dau_bao": domain(best["dau_bao"]) or best["dau_bao"],
        "nhom": best["nhom"],
        "vi_tri": best["vi_tri"],
        "gia": int(best["gia_ban_digicom"]),
        "so_link": best["so_link"],
        "quy_cach": best["quy_cach"],
        "ghi_chu": best["ghi_chu"],
        "so_ncc_co_gia": len(g),          # noi bo: bao nhieu ben cung ban muc nay
        "ngay_cap_nhat": best["ngay_cap_nhat"],
    })

web.sort(key=lambda r: (r["dich_vu"], r["nhom"], r["dau_bao"], r["gia"]))

with open(OUT, "w", newline="") as f:
    w = csv.DictWriter(f, fieldnames=list(web[0].keys()))
    w.writeheader()
    w.writerows(web)

# Thong ke
from collections import Counter
print("Dong len web:", len(web))
print("Theo dich vu:", dict(Counter(r["dich_vu"] for r in web)))
canh_tranh = [r for r in web if r["so_ncc_co_gia"] > 1]
print(f"Muc co >1 NCC cung ban (da chon re nhat): {len(canh_tranh)}")
for r in canh_tranh[:15]:
    print(f"   {r['dau_bao']:<28} {r['vi_tri'][:32]:<34} {r['gia']:>12,} d  ({r['so_ncc_co_gia']} ben)")
print("\n-> Ghi:", OUT)
