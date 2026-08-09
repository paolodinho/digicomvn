#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""Dong bo live theo pricing MOI (Hieu 2026-08-09): CHI con DanaSEO + lai 5%.

Khac cap-nhat-gia.py (chi cap nhat gia, khong bao gio draft): script nay THEM buoc DRAFT
cho nhung dong live tung thuoc NCC vua bi loai (Media Viet Nam / Fame Media / Rise Media)
- nhan dien bang cach doi chieu 2 ban snapshot gia-web.csv (TRUOC/SAU khi doi CHI_NCC trong
export-web.py), khong dua vao meta 'ma_ncc' vi ~745/1837 dong live chua tung duoc gan ma
(rows tao truoc 2026-07-19) nen khong du tin cay de tu quyet dinh draft/giu.

  - Khop key (nhom, dau_bao, vi_tri) [+ quy_cach neu vi_tri co nhieu muc gia] trong ban SAU
    (chi DanaSEO) -> CAP NHAT gia (khong bao gio draft).
  - Khong khop trong ban SAU nhung khop trong ban TRUOC (4 NCC cu) -> tung la NCC vua bi loai
    -> DRAFT.
  - Khong khop trong CA HAI ban -> giu nguyen, ghi vao log de xem tay (co the sai chinh ta/
    da doi ten - khong tu dong dong vao du lieu mo ho).
"""
import csv, json, re, unicodedata, os
from collections import defaultdict

BASE = os.path.dirname(os.path.abspath(__file__))
BO_QUA_NHOM = {"backlink-social-entity"}

def fold(s):
    s = unicodedata.normalize("NFD", (s or "").strip().lower())
    s = "".join(c for c in s if unicodedata.category(c) != "Mn").replace("đ", "d")
    return re.sub(r"[^a-z0-9]+", "", s)

def num(s):
    return int(re.sub(r"[^0-9]", "", str(s) or "0") or 0)

def la_bang_nhieu_muc(gia_km):
    return len(re.findall(r"\d[\d.,]{4,}", str(gia_km or ""))) > 1

DV_2_NHOM = {
    "booking-pr":      "booking-bao-pr",
    "guest-post":      "guest-post",
    "textlink":        "mua-textlink",
    "toplist":         "dich-vu-toplist",
    "backlink-quocte": "backlink-quoc-te",
    "booking-tv":      "booking-truyen-hinh",
}

def load_kho(path):
    kho, kho_ct = defaultdict(list), defaultdict(list)
    keys3 = set()
    for r in csv.DictReader(open(path)):
        nhom = DV_2_NHOM.get(r["dich_vu"])
        if not nhom:
            continue
        g = (int(r["gia"]), r.get("ma_ncc", ""))
        k3 = (nhom, fold(r["dau_bao"]), fold(r["vi_tri"]))
        kho[k3].append(g)
        keys3.add(k3)
        kho_ct[(nhom, fold(r["dau_bao"]), fold(r["vi_tri"]), fold(r["quy_cach"]))].append(g)
    return kho, kho_ct, keys3

kho_new, kho_ct_new, keys_new = load_kho(os.path.join(BASE, "gia-web.csv"))
# duong dan backup ban gia-web.csv TRUOC khi doi CHI_NCC, truyen qua bien moi truong
# (khong hardcode ngay thang trong code).
BEFORE_CSV = os.environ.get("GIA_WEB_BEFORE")
if not BEFORE_CSV or not os.path.exists(BEFORE_CSV):
    raise SystemExit("Thieu bien moi truong GIA_WEB_BEFORE tro toi ban gia-web.csv TRUOC khi doi CHI_NCC")
_kho_old, _kho_ct_old, keys_old = load_kho(BEFORE_CSV)

live = json.load(open(os.path.join(BASE, "live-now.json")))

ups, drafts, giu, khong_khop, tang, giam, bang_bac, mo_ho = [], [], 0, [], [], [], [], []
for p in live:
    nhom = p["nhom"]
    if nhom in BO_QUA_NHOM:
        continue
    if la_bang_nhieu_muc(p["gia_km"]):
        bang_bac.append(f'{nhom} | {p["title"]}')
        continue
    cu = num(p["gia_km"])
    if not cu:
        continue

    k3 = (nhom, fold(p["title"]), fold(p["vi_tri"]))
    c3 = kho_new.get(k3)
    if not c3:
        if k3 in keys_old:
            drafts.append({"id": p["ID"], "title": p["title"], "nhom": nhom, "vi_tri": p["vi_tri"][:30]})
        else:
            khong_khop.append(f'{nhom} | {p["title"]} | {p["vi_tri"][:30]}')
        continue

    gia_set = set(g for g, _ in c3)
    if len(gia_set) == 1:
        moi, ma_ncc = c3[0]
    else:
        c4 = kho_ct_new.get((nhom, fold(p["title"]), fold(p["vi_tri"]), fold(p["yeu_cau"])))
        c4_set = set(g for g, _ in c4) if c4 else set()
        if not c4 or len(c4_set) != 1:
            mo_ho.append(f'{nhom} | {p["title"]} | {p["vi_tri"][:26]} | {sorted(gia_set)}')
            continue
        moi, ma_ncc = c4[0]
    if moi == cu:
        giu += 1
        continue
    ups.append({"id": p["ID"], "gia": moi, "ma_ncc": ma_ncc})
    (giam if moi < cu else tang).append((p["title"], p["vi_tri"][:26], cu, moi))

json.dump({"updates": ups, "new": [], "drafts": [d["id"] for d in drafts]},
          open(os.path.join(BASE, "payload-danaseo-only.json"), "w"), ensure_ascii=False)

print(f"CAP NHAT GIA: {len(ups)} dong (GIAM {len(giam)} | TANG {len(tang)})")
print(f"DRAFT (tung thuoc NCC bi loai - Media VN/Fame/Rise): {len(drafts)} dong")
print(f"Giu nguyen (da dung gia moi nhat): {giu} dong")
print(f"Khong khop ca 2 ban (giu nguyen, can xem tay): {len(khong_khop)} dong")
print(f"Bang gia nhieu muc (textlink, bo qua): {len(bang_bac)} dong")
print(f"Mo ho (nhieu muc gia, khong ro san pham): {len(mo_ho)} dong\n")

by_nhom = defaultdict(int)
for d in drafts:
    by_nhom[d["nhom"]] += 1
print("-- Draft theo nhom --")
for k, v in sorted(by_nhom.items(), key=lambda x: -x[1]):
    print(f"  {k:<22}{v}")

if khong_khop:
    print("\n-- Mau khong khop (xem tay) --")
    for x in khong_khop[:15]:
        print("  ", x)
