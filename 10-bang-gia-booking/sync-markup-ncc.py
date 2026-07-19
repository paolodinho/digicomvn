#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""Dong bo LIVE (2026-07-19): markup moi (3 NCC chinh x1,03, khac x1,20) + gan ma_ncc noi bo.
Khop theo (nhom, title, vi_tri) - neu 1 vi tri co NHIEU muc gia (textlink bac thang, TV quy cach
khac nhau...) thi khop them yeu_cau/quy_cach, khong khop duoc thi GIU NGUYEN (an toan, dung
logic cua cap-nhat-gia.py)."""
import csv, json, re, unicodedata, os
from collections import defaultdict

BASE = os.path.dirname(os.path.abspath(__file__))

def fold(s):
    s = unicodedata.normalize("NFD", (s or "").strip().lower())
    s = "".join(c for c in s if unicodedata.category(c) != "Mn").replace("đ", "d")
    return re.sub(r"[^a-z0-9]+", "", s)

def num(s):
    return int(re.sub(r"[^0-9]", "", str(s) or "0") or 0)

DV_2_NHOM = {
    "booking-pr": "booking-bao-pr", "guest-post": "guest-post", "textlink": "mua-textlink",
    "toplist": "dich-vu-toplist", "backlink-quocte": "backlink-quoc-te",
    "booking-tv": "booking-truyen-hinh",
}

kho = defaultdict(list)
kho_ct = defaultdict(list)
for r in csv.DictReader(open(os.path.join(BASE, "gia-web.csv"))):
    nhom = DV_2_NHOM.get(r["dich_vu"])
    if not nhom:
        continue
    row = {"gia": int(r["gia"]), "ma_ncc": r["ma_ncc"]}
    kho[(nhom, fold(r["dau_bao"]), fold(r["vi_tri"]))].append(row)
    kho_ct[(nhom, fold(r["dau_bao"]), fold(r["vi_tri"]), fold(r["quy_cach"]))].append(row)

live = json.load(open(os.path.join(BASE, "live-now-fresh.json")))

ups, giu, khong_khop, mo_ho, bang_bac = [], 0, [], [], []
for p in live:
    if p["nhom"] == "backlink-social-entity":
        continue
    if len(re.findall(r"\d[\d.,]{4,}", str(p["gia_km"] or ""))) > 1:
        bang_bac.append(f'{p["nhom"]} | {p["title"]}')
        continue
    cu = num(p["gia_km"])
    if not cu:
        continue
    c3 = kho.get((p["nhom"], fold(p["title"]), fold(p["vi_tri"])))
    if not c3:
        khong_khop.append(f'{p["nhom"]} | {p["title"]} | {p["vi_tri"][:30]}')
        continue
    gia_set = set(x["gia"] for x in c3)
    if len(gia_set) == 1:
        best = c3[0]
    else:
        c4 = kho_ct.get((p["nhom"], fold(p["title"]), fold(p["vi_tri"]), fold(p["yeu_cau"])))
        gia_set4 = set(x["gia"] for x in c4) if c4 else set()
        if not c4 or len(gia_set4) != 1:
            mo_ho.append(f'{p["nhom"]} | {p["title"]} | {p["vi_tri"][:26]} | {sorted(gia_set)}')
            continue
        best = c4[0]
    changed = {}
    if best["gia"] != cu:
        changed["gia"] = best["gia"]
    if best["ma_ncc"] and best["ma_ncc"] != p.get("ma_ncc", ""):
        changed["ma_ncc"] = best["ma_ncc"]
    if not changed:
        giu += 1
        continue
    ups.append({"id": p["ID"], **changed})

json.dump({"updates": ups, "new": []}, open(os.path.join(BASE, "payload-sync-markup-ncc.json"), "w"), ensure_ascii=False)
print(f"Se cap nhat: {len(ups)} dong")
print(f"Giu nguyen (da dung): {giu}")
print(f"Khong khop: {len(khong_khop)}")
print(f"Mo ho: {len(mo_ho)}")
print(f"Bang bac (bo qua): {len(bang_bac)}")
