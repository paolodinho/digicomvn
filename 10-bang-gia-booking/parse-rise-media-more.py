#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""Boc 3 tab con lai cua sheet Rise Media (gid=1867970395 da lam roi o parse-rise-media.py):
- gid=240118300  BAO TINH (link dofollow)
- gid=1376249241 BAO NHO / SEO (3 bang xep ngang)
- gid=1811028651 SITE GIA RE
Bo qua gid=1545752521 BANNER (san pham quang cao banner, khac loai voi dich vu booking-pr hien tai).

Gia web = gia cuoi (da CK, hoac don gia neu khong co CK) x 1.1 (yeu cau Hieu 2026-07-24, ap dung
dong nhat cho toan bo du lieu Rise Media, khong rieng 1 tab).
"""
import csv, re, os

BASE = os.path.dirname(os.path.abspath(__file__))
OUT = os.path.join(BASE, "raw", "Rise-Media.csv")
MARKUP = 1.1

def num(s):
    if not s: return None
    s = re.sub(r"[^\d]", "", str(s).strip())
    return int(s) if s else None

def clean(s):
    return " ".join(str(s or "").replace("|", "/").split())

out_lines = []
n_ok = 0

# ---------- BAO TINH (240118300) ----------
rows = list(csv.reader(open("/tmp/rise-240118300.csv")))[1:]
cur_site = ""
for r in rows:
    if len(r) < 9:
        continue
    ten_bao = clean(r[1])
    danh_muc = clean(r[2])
    gia = num(r[3])
    dr = clean(r[4])
    traffic = clean(r[5])
    so_tu = clean(r[6])
    so_anh = clean(r[7])
    so_link = clean(r[8])
    ghi = clean(r[9]) if len(r) > 9 else ""
    if ten_bao:
        cur_site = ten_bao
    site = cur_site
    if not site or not gia or "dung nhan" in danh_muc.lower().replace("ừ","u").replace("ậ","a"):
        continue
    if danh_muc.strip().lower() in ("dừng nhận", "dung nhan"):
        continue
    gia_web = round(gia * MARKUP / 1000) * 1000
    qc = " - ".join(x for x in (so_tu, so_anh) if x)
    ghi_full = f"Gia cuoi NCC: {gia:,} d - da nhan 1.1".replace(",", ".")
    extra = " - ".join(x for x in ([f"DR {dr}" if dr else "", f"traffic {traffic}" if traffic else "", ghi]) if x)
    if extra:
        ghi_full += " - " + extra
    line = "|".join(["Rise Media", "booking-pr", site, "Bao tinh / bao dang", danh_muc,
                      str(gia_web), so_link, qc, ghi_full, ""])
    out_lines.append(line)
    n_ok += 1

# ---------- BAO NHO / SEO (1376249241), 3 bang xep ngang ----------
rows = list(csv.reader(open("/tmp/rise-1376249241.csv")))[1:]
BLOCKS = [(0, 1, 2, 3), (5, 6, 7, 8), (11, 12, 13, 14)]
for r in rows:
    for (c_stt, c_site, c_gia, c_yc) in BLOCKS:
        if len(r) <= c_yc:
            continue
        site = clean(r[c_site])
        gia = num(r[c_gia])
        yc = clean(r[c_yc])
        if not site or not gia:
            continue
        gia_web = round(gia * MARKUP / 1000) * 1000
        ghi_full = f"Gia ban NCC: {gia:,} d - da nhan 1.1".replace(",", ".")
        line = "|".join(["Rise Media", "booking-pr", site, "Bao nho / SEO", "Bai dang",
                          str(gia_web), "", yc, ghi_full, site if site.startswith("http") else ""])
        out_lines.append(line)
        n_ok += 1

# ---------- SITE GIA RE (1811028651) ----------
rows = list(csv.reader(open("/tmp/rise-1811028651.csv")))[1:]
for r in rows:
    if len(r) < 6:
        continue
    site = clean(r[1])
    vi_tri = clean(r[2])
    niem_yet = num(r[3])
    ck = clean(r[4])
    thanh_tien = num(r[5])
    ghi = clean(r[6]) if len(r) > 6 else ""
    if not site or not thanh_tien:
        continue
    gia_web = round(thanh_tien * MARKUP / 1000) * 1000
    ghi_full = (f"Gia niem yet NCC: {niem_yet:,} d - CK {ck} - gia sau CK: {thanh_tien:,} d - da nhan 1.1".replace(",", ".")
                if niem_yet else f"Gia ban NCC: {thanh_tien:,} d - da nhan 1.1".replace(",", "."))
    if ghi:
        ghi_full += " - " + ghi
    line = "|".join(["Rise Media", "booking-pr", site, "Site gia re", vi_tri or "Bai phu hop",
                      str(gia_web), "", "", ghi_full, ""])
    out_lines.append(line)
    n_ok += 1

with open(OUT, "a") as f:
    f.write("\n" + "\n".join(out_lines) + "\n")

print(f"Da them {n_ok} dong (Bao tinh + Bao nho/SEO + Site gia re) vao {OUT}.")
print("Bo qua tab BANNER (gid=1545752521) - san pham quang cao banner, khac loai voi PR bai viet.")
