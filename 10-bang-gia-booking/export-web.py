#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""Xuat bang gia CONG KHAI cho digicomvn.com tu bang-gia-master.csv

Quy tac (chot 2026-07-14):
- Cung 1 dau bao + cung TANG SAN PHAM -> LAY GIA RE NHAT trong so cac NCC.
- AN danh tinh nha cung cap. An gia mua vao. Khong lo link nguon NCC.
- Gia hien thi = gia_ban_digicom co MARKUP, chua VAT 8%.

MARKUP (Hieu 2026-07-15): moi NCC TRU DanaSEO -> gia web = gia von x 1,20.
  DanaSEO giu nguyen gia cuoi (khong markup). Markup ap O CAP DONG, TRUOC khi chon
  min giua cac NCC -> DanaSEO (khong markup) va ben khac (x1,20) canh tranh song phang,
  van lay re nhat. Bao trum ca rule cu "truyen hinh +20%" (TV deu la NCC ngoai DanaSEO).

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

MARKUP = 1.20  # Hieu 2026-07-15: NCC ngoai 3 ben duoi -> gia web = gia von x 1,20.
# Hieu 2026-07-19: 3 NCC nguon chinh (DanaSEO, Media Viet Nam, Fame Media) markup NHE x1,03
# (truoc la giu nguyen 1.0) - "de chac" co bien loi nhuan toi thieu, van re hon han NCC khac.
MARKUP_CHINH = 1.03
KHONG_MARKUP = {"danaseo", "media viet nam", "fame media"}

# Ma NCC noi bo (Hieu 2026-07-19: "danh dau de do phai tra lai") - CHI hien trong WP Admin
# (cot rieng + field an), KHONG BAO GIO dua ra front-end/public (van AN danh tinh NCC voi khach).
NCC_MA = {"danaseo": "1", "media viet nam": "2", "fame media": "3"}

# Hieu 2026-07-18: TAM THOI CHI dung 3 NCC nay len web (danaseo, media viet nam, fame media).
# Cac NCC khac VAN LUU trong bang-gia-master.csv (du lieu tham khao), nhung KHONG xuat ra
# gia-web.csv / khong dua len site. Bo rong lai -> xoa/sua CHI_NCC ben duoi.
CHI_NCC = {"danaseo", "media viet nam", "fame media"}
# NGOAI LE (Hieu 2026-07-18): Toplist va Backlink quoc te KHONG co du lieu tu 3 NCC tren
# -> se trong trang neu ap dung CHI_NCC. Giu nguyen hanh vi CU (moi NCC, co markup 1.2x)
# CHI cho 2 dich_vu nay, de trang khong bi trong bang gia.
DICH_VU_NGOAI_LE_CHI_NCC = {"toplist", "backlink-quocte"}

def web_gia(r):
    """Gia hien thi len web tu 1 dong master: 3 NCC chinh x 1,03; NCC khac x 1,20 (lam tron nghin)."""
    g = int(r["gia_ban_digicom"])
    he_so = MARKUP_CHINH if fold(r["nha_cung_cap"]) in KHONG_MARKUP else MARKUP
    return int(round(g * he_so / 1000) * 1000)

with open(SRC) as f:
    all_rows = [r for r in csv.DictReader(f) if r["gia_ban_digicom"]]

n_before_ncc = len(all_rows)
all_rows = [r for r in all_rows if fold(r["nha_cung_cap"]) in CHI_NCC or r["dich_vu"] in DICH_VU_NGOAI_LE_CHI_NCC]
print(f"Chi dung {len(all_rows)}/{n_before_ncc} dong tu 3 NCC {sorted(CHI_NCC)} (Toplist + Backlink quoc te ngoai le, giu moi NCC) - cac NCC khac luu trong master nhung khong len web (Hieu 2026-07-18).\n")

rows = [r for r in all_rows if not is_soft(r)]
print(f"Bo qua {len(all_rows) - len(rows)} dong gia mem (gia tu / dai gia) - khong dung de dinh gia web.\n")

# Ten mien cua chinh cac NCC - khong duoc phep xuat hien tren bang gia cong khai.
NCC_DOMAIN = {
    "famemedia.vn", "danaseo.net", "danaseo.vn", "seovip.vn", "dps.media", "dpsmedia.vn",
    "guestpost.vn", "guestpost.com.vn", "bookbaopr.vn", "seodo.vn", "brando.vn",
    "solanndigital.com", "backlink.solanndigital.com", "seotop.vn", "seotoro.vn",
    "buffseo.com", "hapodigital.com", "dichvuentity.vn", "vutruso.com", "tungphat.com",
    "ecpmedia.vn", "atpsoftware.vn", "setupota.vn", "newtop.vn", "headle.net",
}


# Dau bao NCC da bao DUNG ban -> khong bao gio dua len web, ke ca khi dot quet sau
# vo tinh nap lai. Hieu chot 2026-07-20: "go".
DA_DUNG_BAN = {
    "quangninh.gov.vn",           # Media Viet Nam tab GOV danh dau "(Dung)"
    "kinhtedothi.vn",             # Media Viet Nam tab textlink sidebar danh dau "(Dung)"
    "thitruongtaichinh.kinhtedothi.vn",
    "tieudung.kinhtedothi.vn",
    "giaothonghanoi.kinhtedothi.vn",
}


def is_gov_edu(r):
    """Domain co quan nha nuoc (.gov.vn) / truong hoc (.edu.vn) -> KHONG BAO GIO len web
    (Hieu chot 2026-07-20).

    Ly do: dat link quang cao tra tien tren cong thong tin dien tu cua co quan nha nuoc /
    truong hoc la HANH VI VI PHAM PHAP LUAT, khong phai nghiep vu SEO. Thang 8/2024 mot Pho
    Chanh Van phong UBND tinh Quang Tri da bi bat tam giam vi chen link quang cao vao cac
    ten mien .gov.vn/.edu.vn de thu tien (2019-2024) - xem bai /back-link-gov/ tren site.
    Truoc khi chot rule nay, bang gia dang publish 9 dong loai nay, trong do co
    vietnamtourism.gov.vn (Cuc Du lich Quoc gia) gia 7,1-10,3 trieu - da draft het.

    KHONG go rule nay ke ca khi NCC chao hang lai. Neu can mo lai phai co y kien Hieu bang van ban."""
    # KHONG split("/") trong o day: dau_bao co the la "https://vietnamtourism.gov.vn/ Tong cuc
    # du lich" -> split se cat con "https:" va lot bo loc (da dinh loi nay 2026-07-20).
    # Quet tren TOAN CHUOI, cong them vi_tri/quy_cach de bat cac dong mo ta kieu "42 site gov".
    hay = " ".join(fold(r.get(k, "")) for k in ("dau_bao", "vi_tri", "quy_cach"))
    return (".gov.vn" in hay or ".edu.vn" in hay
            or ".gov/" in hay or ".edu/" in hay
            or hay.rstrip("/ ").endswith(".gov") or hay.rstrip("/ ").endswith(".edu")
            or "site gov" in hay or "site edu" in hay)


def is_khong_ro_noi_dang(r):
    """Dong KHONG show duoc dang bao nao / dang o dau -> KHONG dua len web (Hieu 2026-07-16).
    Gom: (1) goi/combo/social entity khong co goi_sites; (2) dong chung chung khong co domain
    cu the ('Guest post DR 30+', 'Niche edit', 'Toplist tinh/quan huyen', 'credit le'...).
    Ngoai le: booking-tv (kenh VTV1/HTV7... la noi dang cu the du khong co dau cham).
    Khi NCC cong bo list site (dien goi_sites) thi dong do duoc xuat lai."""
    d = fold(r["dau_bao"])
    if d.split("/")[0].strip() in DA_DUNG_BAN:
        return True
    # Domain cua chinh NCC -> KHONG BAO GIO len web, du co goi_sites: lo Digicom lay hang
    # o dau (rule "an danh tinh nha cung cap"). Phat hien 2026-07-20: 3 dong entity
    # "Famemedia.vn / Goi B150-B300" lot qua bo loc cu vi dau_bao co dau cham.
    if d.split("/")[0].strip() in NCC_DOMAIN:
        return True
    if r.get("goi_sites", "").strip():
        return False
    # "Goi B300" nam o vi_tri (khong phai dau_bao) van la goi an danh -> chan luon.
    v = fold(r["vi_tri"])
    for x in (d, v):
        if x.startswith("goi") or x.startswith("combo") or x.startswith("social entity"):
            return True
    if r["dich_vu"] == "booking-tv":
        return False
    return "." not in d  # khong co domain cu the -> chung chung

n_gov = len(rows)
rows = [r for r in rows if not is_gov_edu(r)]
if n_gov - len(rows):
    print(f"Loai {n_gov - len(rows)} dong .gov.vn/.edu.vn (co quan nha nuoc / truong hoc) - rule 2026-07-20, KHONG duoc go.\n")

n0 = len(rows)
rows = [r for r in rows if not is_khong_ro_noi_dang(r)]
print(f"Bo qua {n0 - len(rows)} dong khong ro noi dang (goi an danh / khong domain cu the) - rule 2026-07-16.\n")

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
    best = min(g, key=web_gia)
    gia_all = sorted(web_gia(x) for x in g)
    web.append({
        "dich_vu": best["dich_vu"],
        "dau_bao": domain(best["dau_bao"]) or best["dau_bao"],
        "hang_muc": TIER_VN.get(key[2], key[2]),
        "vi_tri": best["vi_tri"],
        "gia": web_gia(best),
        "so_link": best["so_link"],
        "quy_cach": best["quy_cach"],
        "so_ncc": len(g),                              # noi bo
        "gia_cao_nhat_thi_truong": gia_all[-1],        # noi bo - de biet bien do
        "ngay_cap_nhat": best["ngay_cap_nhat"],
        "ma_ncc": NCC_MA.get(fold(best["nha_cung_cap"]), ""),  # noi bo - AN danh, chi Hieu tra
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
