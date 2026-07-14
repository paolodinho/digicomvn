#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""Tra cuu gia booking bao theo dau bao / nha cung cap.

Dung:
  python3 tra-cuu.py vnexpress          # moi ben co gia cho vnexpress
  python3 tra-cuu.py kenh14 --ncc danaseo
  python3 tra-cuu.py --ncc "fame media" # xem toan bo bang gia 1 ben
  python3 tra-cuu.py --duoi 5000000     # cac dau bao duoi 5 trieu
"""
import csv, os, sys, argparse, unicodedata

CSV = os.path.join(os.path.dirname(os.path.abspath(__file__)), "bang-gia-master.csv")

def fold(s):
    s = unicodedata.normalize("NFD", s or "")
    s = "".join(c for c in s if unicodedata.category(c) != "Mn")
    return s.lower().replace("đ", "d").replace("Đ", "d")

def vnd(v):
    try: return f"{int(v):,}".replace(",", ".") + " d"
    except: return str(v or "-")

def main():
    p = argparse.ArgumentParser()
    p.add_argument("bao", nargs="?", default="", help="ten dau bao (khong dau cung duoc)")
    p.add_argument("--ncc", default="", help="loc theo nha cung cap")
    p.add_argument("--duoi", type=int, default=0, help="gia ban <= X")
    a = p.parse_args()

    with open(CSV) as f:
        rows = list(csv.DictReader(f))

    hits = []
    for r in rows:
        if a.bao and fold(a.bao) not in fold(r["dau_bao"]): continue
        if a.ncc and fold(a.ncc) not in fold(r["nha_cung_cap"]): continue
        if a.duoi:
            try:
                if int(r["gia_ban_digicom"]) > a.duoi: continue
            except: continue
        hits.append(r)

    if not hits:
        print("Khong tim thay. Thu tu khoa ngan hon (vd: 'vnexpress', 'dantri', 'cafe').")
        return

    hits.sort(key=lambda r: (r["nha_cung_cap"], int(r["gia_ban_digicom"] or 0)))
    cur = None
    for r in hits:
        key = (r["nha_cung_cap"], r["dau_bao"])
        if key != cur:
            cur = key
            print(f"\n== {r['dau_bao']}  [{r['nha_cung_cap']}]  ({r['nhom']})")
        vt = r["vi_tri"] or "-"
        line = f"   {vt:<45} {vnd(r['gia_ban_digicom']):>15}"
        if r["so_link"]: line += f"  | {r['so_link'].strip()}"
        if r["quy_cach"]: line += f"  | {r['quy_cach']}"
        print(line)

    print(f"\n-- {len(hits)} dong. Gia BAN cho khach (chua VAT 8%). Cap nhat: {hits[0]['ngay_cap_nhat']}")
    print("-- Gia mua vao (gia_ncc_km) xem truc tiep trong bang-gia-master.csv")

if __name__ == "__main__":
    main()
