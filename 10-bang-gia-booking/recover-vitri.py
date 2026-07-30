#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""Sinh payload updates/new de dong bo gia-web.csv (da fix loi gop vi tri + alias domain,
2026-07-29) len live, dua tren snapshot live MOI FETCH (live-fresh.json, trang thai ANY -
khong chi publish, tranh hoi sinh nham dong da chu dich draft - rule bang-gia-booking.md).
"""
import csv, json, re, unicodedata, os
from collections import defaultdict

BASE = os.path.dirname(os.path.abspath(__file__))

def fold(s):
    s = (s or "").strip().lower()
    s = unicodedata.normalize("NFD", s)
    s = "".join(c for c in s if unicodedata.category(c) != "Mn").replace("đ", "d")
    return re.sub(r"[^a-z0-9]+", "", s)

DV_2_NHOM = {
    "booking-pr":      "booking-bao-pr",
    "guest-post":      "guest-post",
    "textlink":        "mua-textlink",
    "toplist":         "dich-vu-toplist",
    "backlink-quocte": "backlink-quoc-te",
    "booking-tv":      "booking-truyen-hinh",
}

live = json.load(open(os.path.join(BASE, "live-fresh.json")))
by_key = defaultdict(list)     # (nhom, title, vi_tri) -> [rec]
by_key2 = defaultdict(list)    # (nhom, title, vi_tri, yeu_cau) -> [rec] - khoa chat hon (quy cach)
for r in live:
    k = (r["nhom"], fold(r["title"]), fold(r["vi_tri"]))
    by_key[k].append(r)
    k2 = (r["nhom"], fold(r["title"]), fold(r["vi_tri"]), fold(r["yeu_cau"]))
    by_key2[k2].append(r)

web_rows = list(csv.DictReader(open(os.path.join(BASE, "gia-web.csv"))))

# Dem so dong CSV chia se cung 1 khoa THO (nhom,title,vi_tri) - neu >1 dong (nhieu quy_cach
# khac nhau) ma live chi co DUY NHAT 1 ban ghi, khong duoc phep khop ca 2+ dong vao cung 1 id
# (se ghi de gia lan luot, sai du lieu). Phai khop theo yeu_cau (quy_cach), khong khop duoc
# thi coi la vi tri MOI (rieng), khong dung chung id voi dong khac.
coarse_count = defaultdict(int)
for w in web_rows:
    nhom = DV_2_NHOM.get(w["dich_vu"])
    if not nhom:
        continue
    coarse_count[(nhom, fold(w["dau_bao"]), fold(w["vi_tri"]))] += 1

updates, new, ambiguous, skip_draft_only = [], [], [], []
n_same = 0
used_ids = set()
for w in web_rows:
    nhom = DV_2_NHOM.get(w["dich_vu"])
    if not nhom:
        continue
    key = (nhom, fold(w["dau_bao"]), fold(w["vi_tri"]))
    cands = by_key.get(key)
    if not cands:
        new.append({
            "nhom": nhom, "title": w["dau_bao"], "vi_tri": w["vi_tri"],
            "gia": int(w["gia"]), "so_link": w["so_link"], "yeu_cau": w["quy_cach"],
        })
        continue
    if len(cands) > 1 or coarse_count[key] > 1:
        key2 = (nhom, fold(w["dau_bao"]), fold(w["vi_tri"]), fold(w["quy_cach"]))
        c2 = by_key2.get(key2)
        if not c2 or len(c2) > 1:
            # CSV co nhieu quy_cach cho cung 1 vi tri nhung khong khop duoc yeu_cau voi live
            # -> day la 1 quy_cach RIENG chua co tren live, tao moi thay vi doan om vao 1 id.
            if coarse_count[key] > 1:
                new.append({
                    "nhom": nhom, "title": w["dau_bao"], "vi_tri": w["vi_tri"],
                    "gia": int(w["gia"]), "so_link": w["so_link"], "yeu_cau": w["quy_cach"],
                })
            else:
                ambiguous.append(w)
            continue
        cands = c2
    rec = cands[0]
    if rec["ID"] in used_ids:
        # Id nay da duoc 1 dong CSV khac (cung nhom key) nhan roi - khong doan them, tao moi.
        new.append({
            "nhom": nhom, "title": w["dau_bao"], "vi_tri": w["vi_tri"],
            "gia": int(w["gia"]), "so_link": w["so_link"], "yeu_cau": w["quy_cach"],
        })
        continue
    used_ids.add(rec["ID"])
    if rec["post_status"] != "publish":
        skip_draft_only.append({"nhom": nhom, "title": w["dau_bao"], "vi_tri": w["vi_tri"], "status": rec["post_status"]})
        continue
    cu = int(re.sub(r"[^0-9]", "", str(rec["gia_km"]) or "0") or 0)
    moi = int(w["gia"])
    if cu == moi:
        n_same += 1
        continue
    updates.append({"id": rec["ID"], "gia": moi})

print(f"Tong dong gia-web.csv (co nhom hop le): {sum(1 for w in web_rows if DV_2_NHOM.get(w['dich_vu']))}")
print(f"Da dung gia (khong doi): {n_same}")
print(f"Can UPDATE gia: {len(updates)}")
print(f"Can TAO MOI: {len(new)}")
print(f"Mo ho (nhieu ung vien, khong ro san pham nao): {len(ambiguous)}")
print(f"Bo qua (khop voi ban ghi DANG DRAFT - khong hoi sinh): {len(skip_draft_only)}")

json.dump({"updates": updates, "new": new}, open(os.path.join(BASE, "payload-vitri-recover.json"), "w"), ensure_ascii=False)
json.dump(ambiguous, open(os.path.join(BASE, "_vitri-ambiguous.json"), "w"), ensure_ascii=False, indent=2)
json.dump(skip_draft_only, open(os.path.join(BASE, "_vitri-skip-draft.json"), "w"), ensure_ascii=False, indent=2)
print("\nDa ghi payload-vitri-recover.json")
