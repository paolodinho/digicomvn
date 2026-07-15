#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""Ra soat TOAN BO gia tren live theo du lieu MOI NHAT (Hieu 2026-07-15: "cam lay gia cu").

Kho NCC vua tang 40 -> 87 ben, nen nhieu dau bao gio co ben ban re hon -> phai ha gia theo.
Quy tac giu nguyen: gia = GIA CUOI re nhat trong so cac NCC CHAC CHAN cung san pham
(export-web.py da lo phan gop nhom + chot chan gia von + loai gia mem).

Rieng:
  - MARKUP x1,20 cho moi NCC ngoai DanaSEO da ap SAN trong gia-web.csv (export-web.py),
    gom ca booking-truyen-hinh -> o day KHONG nhan lai.
  - backlink-social-entity: KHONG dung toi (gia rieng theo rule 120% Solann).
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
    """Textlink ban theo BANG nhieu muc (Home/CM/Fullsite x 3-6-12 thang) - gia_km chua NHIEU
    con so, khong phai 1 gia don. TUYET DOI khong ghi de bang 1 so - se xoa sach bang gia bac
    thang cua dong do. (Suyt dinh 2026-07-15.)"""
    return len(re.findall(r"\d[\d.,]{4,}", str(gia_km or ""))) > 1

# nhom tren web  <-  dich_vu trong kho
DV_2_NHOM = {
    "booking-pr":      "booking-bao-pr",
    "guest-post":      "guest-post",
    "textlink":        "mua-textlink",
    "toplist":         "dich-vu-toplist",
    "backlink-quocte": "backlink-quoc-te",
    "booking-tv":      "booking-truyen-hinh",
}

# ---- Gia moi nhat tu kho ----
kho = defaultdict(list)          # (nhom, title) -> [gia]
kho_ct = defaultdict(list)       # (nhom, title, vi_tri) -> [gia]  (khoa chat hon)
for r in csv.DictReader(open(os.path.join(BASE, "gia-web.csv"))):
    nhom = DV_2_NHOM.get(r["dich_vu"])
    if not nhom:
        continue
    # gia-web.csv da co san MARKUP (NCC ngoai DanaSEO x1,20, gom ca truyen hinh) tu export-web.py
    # -> KHONG nhan lai o day, tranh x1,44.
    g = int(r["gia"])
    kho[(nhom, fold(r["dau_bao"]), fold(r["vi_tri"]))].append(g)
    # Khoa phai gom CA QUY CACH: cung vi tri "Nguoi Bi An" nhung TVC 10s/20s/30s la 3
    # san pham gia khac han nhau - thieu quy_cach se gop het ve gia TVC 10s.
    kho_ct[(nhom, fold(r["dau_bao"]), fold(r["vi_tri"]), fold(r["quy_cach"]))].append(g)

live = json.load(open(os.path.join(BASE, "live-now.json")))

ups, giu, khong_khop, tang, giam, bang_bac, mo_ho = [], 0, [], [], [], [], []
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

    # Khop theo (dau bao + vi tri).
    #  - Neu vi tri do trong kho chi ung voi DUY NHAT 1 muc gia -> chac chan cung san pham, cap nhat.
    #  - Neu vi tri do co NHIEU muc gia khac nhau (vd HTV7 "Nguoi Bi An" = TVC 10s/20s/30s)
    #    -> BAT BUOC khop them quy cach; khong khop duoc thi GIU NGUYEN, tuyet doi khong lay min
    #    (se ban TVC 30 giay bang gia TVC 10 giay).
    c3 = kho.get((nhom, fold(p["title"]), fold(p["vi_tri"])))
    if not c3:
        khong_khop.append(f'{nhom} | {p["title"]} | {p["vi_tri"][:30]}')
        continue

    if len(set(c3)) == 1:
        moi = c3[0]
    else:
        c4 = kho_ct.get((nhom, fold(p["title"]), fold(p["vi_tri"]), fold(p["yeu_cau"])))
        if not c4 or len(set(c4)) != 1:
            mo_ho.append(f'{nhom} | {p["title"]} | {p["vi_tri"][:26]} | {sorted(set(c3))}')
            continue
        moi = c4[0]
    if moi == cu:
        giu += 1
        continue
    ups.append({"id": p["ID"], "gia": moi})
    (giam if moi < cu else tang).append((p["title"], p["vi_tri"][:26], cu, moi))

json.dump({"updates": ups, "new": []},
          open(os.path.join(BASE, "payload-cap-nhat-gia.json"), "w"), ensure_ascii=False)

print(f"Doi gia: {len(ups)} dong  (GIAM {len(giam)} | TANG {len(tang)})")
print(f"Giu nguyen (da dung gia moi nhat): {giu} dong")
print(f"Khong khop duoc voi kho: {len(khong_khop)} dong -> GIU NGUYEN, khong dong vao")
print(f"Bang gia nhieu muc (textlink): {len(bang_bac)} dong -> BO QUA, khong ghi de")
print(f"Mo ho (1 vi tri nhieu muc gia, khong ro san pham nao): {len(mo_ho)} dong -> GIU NGUYEN\n")

print("-- 12 dong GIAM manh nhat (co ben re hon sau khi quet them NCC) --")
for t, v, c, m in sorted(giam, key=lambda x: -(x[2] - x[3]))[:12]:
    print(f"  {t[:22]:<24}{v:<28}{c:>13,} -> {m:>13,}   ({(m-c)/c*100:+.0f}%)")
if tang:
    print("\n-- Dong TANG (chu yeu truyen hinh +20%) --")
    for t, v, c, m in sorted(tang, key=lambda x: -(x[3] - x[2]))[:8]:
        print(f"  {t[:22]:<24}{v:<28}{c:>13,} -> {m:>13,}   ({(m-c)/c*100:+.0f}%)")
if khong_khop:
    print("\n-- Vai dong khong khop (giu nguyen) --")
    for x in khong_khop[:6]:
        print("  ", x)
