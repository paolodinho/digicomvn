#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""Xuat bang gia CONG KHAI cho digicomvn.com tu bang-gia-master.csv

Quy tac (chot 2026-07-14):
- Cung 1 dau bao + cung TANG SAN PHAM -> LAY GIA RE NHAT trong so cac NCC.
- AN danh tinh nha cung cap. An gia mua vao. Khong lo link nguon NCC.
- Gia hien thi = gia_ban_digicom, chua VAT 8%.

Tang san pham (tu dong phan loai tu vi_tri/nhom, vi moi NCC goi ten mot kieu):
  trang-chu   : vi tri noi bat trang chu (Top 1, Top Story, dac biet, home...)  -> gia cao
  chuyen-muc  : bai PR chuyen muc/tieu muc tieu chuan                            -> hang chinh
  bao-tinh    : bao dang/bao tinh
  dofollow    : bao link dofollow / bao gia re
"""
import csv, os, re, unicodedata
from collections import defaultdict, Counter

BASE = os.path.dirname(os.path.abspath(__file__))
SRC = os.path.join(BASE, "bang-gia-master.csv")
OUT = os.path.join(BASE, "gia-web.csv")

def fold(s):
    s = unicodedata.normalize("NFD", (s or "").lower())
    s = "".join(c for c in s if unicodedata.category(c) != "Mn")
    return s.replace("d", "d")

DOMAIN_RE = re.compile(r"^(https?://)?(www\.)?[a-z0-9-]+(\.[a-z0-9-]+)+(/|$)", re.I)

def domain(s):
    """Chuan hoa ve domain NEU day thuc su la ten mien. Con lai (ten goi dich vu,
    ten combo toplist...) giu nguyen - neu khong se bi cat bay (vd 'Blog/website ...' -> 'blog')."""
    s = (s or "").strip()
    if not DOMAIN_RE.match(s):
        return s
    v = s.lower()
    v = re.sub(r"^https?://", "", v)
    v = re.sub(r"^www\.", "", v)
    return v.split("/")[0].strip()

HOME_KW = ["trang chu", "trang chi", "top story", "top news", "top 1", "top 2", "top 3",
           "top 4", "top 5", "dac biet", "noi bat", "home", "tieu diem", "magazine",
           "multimedia", "emagazine", "longform", "infographic", "stream 1", "vip",
           "box doanh nghiep", "cum tin", "hot 1", "loai 1", "premium", "under cover"]

def tier(r):
    dv = r["dich_vu"]
    if dv != "booking-pr":
        return dv
    nhom, vt = fold(r["nhom"]), fold(r["vi_tri"])
    if "bao tinh" in nhom or "bao dang" in nhom:
        return "bao-tinh"
    if "dofollow" in nhom or "gia re" in nhom:
        return "dofollow"
    if any(k in vt for k in HOME_KW) or "premium" in nhom:
        return "trang-chu"
    return "chuyen-muc"

TIER_VN = {"trang-chu": "Vi tri noi bat trang chu", "chuyen-muc": "Bai PR chuyen muc",
           "bao-tinh": "Bao tinh / bao dang", "dofollow": "Bao link dofollow",
           "guest-post": "Guest post", "textlink": "Textlink", "entity": "Social entity",
           "toplist": "Toplist", "backlink-quocte": "Backlink quoc te",
           "booking-tv": "Booking truyen hinh"}

def is_soft(r):
    """Gia MEM: dai gia / 'gia tu' / gia khoi diem -> KHONG chac chan mua duoc o muc do.
    Chot 2026-07-14: LOAI khoi viec dinh gia web (van giu trong master de tham chieu thi truong).
    Ly do: BookBaoPR/Brando/SEODO chi rao 'tu X', lay muc thap nhat lam gia ban -> ban duoi gia von."""
    g = fold(r["ghi_chu"])
    v = fold(r["vi_tri"])
    return ("dai gia ncc" in g) or ('gia "tu"' in g) or ("gia mem" in g) or ("gia tu" in g) \
        or ("gia tu" in v) or ("khoi diem" in v) or ("khoang gia chung" in v)

with open(SRC) as f:
    all_rows = [r for r in csv.DictReader(f) if r["gia_ban_digicom"]]
rows = [r for r in all_rows if not is_soft(r)]
print(f"Bo qua {len(all_rows) - len(rows)} dong gia mem (gia tu / dai gia) - khong dung de dinh gia web.\n")

# Khoa gom nhom: dich vu + domain + tang.
# CHI gop 2 dong khi CHAC CHAN cung san pham. Cac dich vu duoi day co nhieu san pham RAT khac
# nhau tren cung 1 "dau bao" -> phai dua them vi_tri/nhom/quy_cach vao khoa, neu khong se gop
# nham roi lay gia re nhat -> ban duoi gia von:
#   textlink / entity     : khac thoi han (3-6-12 thang) / khac so luong social.
#   backlink-quocte       : khac tang DR/DA (DR30+ vs DR60+).
#   booking-tv (2026-07-14): cung kenh VTV1 nhung "TVC 30 giay" (105tr) khac han "phong su ban tin"
#                            (40tr) - gop lai la ban TVC bang gia phong su.
KEY_CHI_TIET = ("textlink", "entity", "backlink-quocte", "booking-tv")

groups = defaultdict(list)
for r in rows:
    t = tier(r)
    key = [r["dich_vu"], domain(r["dau_bao"]), t]
    if r["dich_vu"] in KEY_CHI_TIET:
        key += [fold(r["nhom"]), fold(r["vi_tri"]), fold(r["quy_cach"])]
    groups[tuple(key)].append(r)

web = []
for key, g in groups.items():
    best = min(g, key=lambda r: int(r["gia_ban_digicom"]))
    gia_all = sorted(int(x["gia_ban_digicom"]) for x in g)
    web.append({
        "dich_vu": best["dich_vu"],
        "dau_bao": domain(best["dau_bao"]) or best["dau_bao"],
        "hang_muc": TIER_VN.get(key[2], key[2]),
        "vi_tri": best["vi_tri"],
        "gia": int(best["gia_ban_digicom"]),
        "so_link": best["so_link"],
        "quy_cach": best["quy_cach"],
        "so_ncc": len(g),                              # noi bo
        "gia_cao_nhat_thi_truong": gia_all[-1],        # noi bo - de biet bien do
        "ngay_cap_nhat": best["ngay_cap_nhat"],
    })

web.sort(key=lambda r: (r["dich_vu"], r["hang_muc"], -r["gia"]))

with open(OUT, "w", newline="") as f:
    w = csv.DictWriter(f, fieldnames=list(web[0].keys()))
    w.writeheader()
    w.writerows(web)

print("Dong len web:", len(web))
print("Theo dich vu:", dict(Counter(r["dich_vu"] for r in web)))
canh_tranh = sorted([r for r in web if r["so_ncc"] > 1], key=lambda r: -(r["gia_cao_nhat_thi_truong"] - r["gia"]))
print(f"\nMuc co >1 NCC cung ban -> da chon RE NHAT: {len(canh_tranh)} muc")
print(f"{'DAU BAO':<26}{'HANG MUC':<26}{'GIA RE NHAT':>14}{'CAO NHAT':>14}  BEN")
for r in canh_tranh[:20]:
    print(f"{r['dau_bao']:<26}{r['hang_muc']:<26}{r['gia']:>14,}{r['gia_cao_nhat_thi_truong']:>14,}  {r['so_ncc']}")
print("\n-> Ghi:", OUT)
