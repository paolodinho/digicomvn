#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""Bóc bảng giá Rise Media (Pinnexa Rise Media) từ rise-media-raw.csv (gviz export)
-> raw/Rise-Media.csv (định dạng pipe giống ncc-khac.csv).

Nguồn: https://docs.google.com/spreadsheets/d/1uOvzvsZ-3clQR0bCPtr2JoCPJ3RyuTGF (public, gid=1867970395)
Giá web = giá THÀNH TIỀN (đã chiết khấu) x 1.1 (theo yêu cầu Hiếu 2026-07-24).
"""
import csv, re, os

BASE = os.path.dirname(os.path.abspath(__file__))
SRC = os.path.join(BASE, "rise-media-raw.csv")
OUT = os.path.join(BASE, "raw", "Rise-Media.csv")
MARKUP = 1.1

def num(s):
    if not s: return None
    s = re.sub(r"[^\d]", "", str(s).strip())
    return int(s) if s else None

def clean(s):
    """Bo xuong dong/khoang trang thua va ky tu '|' trong tung o - tranh vo dinh dang pipe."""
    return " ".join(str(s or "").replace("|", "/").split())

rows = list(csv.reader(open(SRC)))[1:]  # bo dong header

out_lines = [
    "# Bang gia Rise Media (Pinnexa Rise Media) - nap 2026-07-24.",
    "# Nguon: Google Sheet cong khai (gviz export). Gia = THANH TIEN (da chiet khau) x 1.1 (yeu cau Hieu).",
    "# Cot: nha_cung_cap|dich_vu|dau_bao|nhom|vi_tri|gia_vnd|so_link|quy_cach|ghi_chu|nguon_url",
]

cur_site, cur_url = "", ""
n_ok, n_skip = 0, 0
for r in rows:
    if len(r) < 9:
        continue
    site = clean(r[1])
    url = clean(r[2])
    vi_tri = clean(r[3])
    niem_yet = num(r[5])
    chiet_khau = clean(r[6])
    thanh_tien = num(r[7])
    so_link = clean(r[8])
    ghi_chu = clean(r[9]) if len(r) > 9 else ""

    if site:
        cur_site, cur_url = site, url
    site_eff = cur_site

    # bo dong footer/ghi chu chung (khong co ten site dang xet, hoac khong co gia)
    if not site_eff or not vi_tri:
        n_skip += 1
        continue
    if not thanh_tien:  # gia 0 hoac trong -> chua co bao gia that (vd Banner, Elleman)
        n_skip += 1
        continue

    gia_web = round(thanh_tien * MARKUP / 1000) * 1000
    # KHONG dung ky tu '|' trong noi dung field - build_master.py split ca dong theo '|'
    ghi = f"Gia goc niem yet NCC: {niem_yet:,} d - CK {chiet_khau} - gia sau CK: {thanh_tien:,} d - da nhan 1.1".replace(",", ".") if niem_yet else \
          f"Gia sau CK (NCC): {thanh_tien:,} d - da nhan 1.1".replace(",", ".")
    if ghi_chu:
        ghi = ghi + " - " + clean(ghi_chu)

    line = "|".join([
        "Rise Media", "booking-pr", site_eff, "PR bao dien tu", vi_tri,
        str(gia_web), so_link, "", ghi, cur_url,
    ])
    out_lines.append(line)
    n_ok += 1

with open(OUT, "w") as f:
    f.write("\n".join(out_lines) + "\n")

print(f"Da ghi {n_ok} dong vao {OUT} (bo qua {n_skip} dong khong co gia/site).")
