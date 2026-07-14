#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""Chuan hoa bang gia booking bao / guest post / textlink tu raw/ -> bang-gia-master.csv

Quy tac gia (chot 2026-07-14): gia_ban_digicom = GIA GOC niem yet cua NCC, moi ben nhu nhau.
Khong nhan markup. Gia chua VAT 8%.
Cot gia_ncc_km = gia mua vao thuc te (loi nhuan Digicom) - KHONG dua cho khach.
"""
import csv, os, re, datetime
from collections import Counter

BASE = "/Volumes/Extreme SSD/CÔNG VIỆC CỦA TÔI/Projects/digicom/10-bang-gia-booking"
RAW = os.path.join(BASE, "raw")
TODAY = datetime.date.today().isoformat()

COLS = ["nha_cung_cap","dich_vu","dau_bao","nhom","vi_tri","gia_ncc_goc","gia_ncc_km",
        "gia_ban_digicom","so_link","quy_cach","ghi_chu","nguon","ngay_cap_nhat"]

def num(s):
    if not s: return ""
    s = re.sub(r"[^\d]", "", str(s).strip())
    return int(s) if s else ""

rows = []
def add(**kw):
    rows.append([kw.get(c, "") for c in COLS])

# ============ DanaSEO: PR bao lon ============
with open(os.path.join(RAW, "PR-bao-lon.csv")) as f:
    cur = ""
    for r in list(csv.reader(f))[1:]:
        if len(r) < 8: continue
        bao = r[1].strip() or cur
        if not bao: continue
        cur = bao
        gg, gkm = num(r[3]), num(r[4])
        if not (gg or gkm): continue
        add(nha_cung_cap="DanaSEO", dich_vu="booking-pr", dau_bao=bao, nhom="PR bao lon",
            vi_tri=r[2].strip(), gia_ncc_goc=gg, gia_ncc_km=gkm, gia_ban_digicom=gg or gkm,
            so_link=r[5].strip(), quy_cach=r[7].strip(), ghi_chu=r[6].strip(),
            nguon="Sheet DanaSEO - PR bao lon", ngay_cap_nhat=TODAY)

# ============ DanaSEO: Bao tinh ============
with open(os.path.join(RAW, "Bao-tinh.csv")) as f:
    for r in list(csv.reader(f))[2:]:
        if len(r) < 4: continue
        bao, gia = r[1].strip(), num(r[2])
        if not gia or not bao or "KHÁCH HÀNG" in bao: continue
        add(nha_cung_cap="DanaSEO", dich_vu="booking-pr", dau_bao=bao,
            nhom="Bao tinh / bao dang", vi_tri="Muc phu hop", gia_ncc_goc=gia,
            gia_ban_digicom=gia, quy_cach=r[3].strip(),
            nguon="Sheet DanaSEO - Bao tinh", ngay_cap_nhat=TODAY)

# ============ DanaSEO: Bao link dofollow ============
SKIP = ("Giá đã bao","Giá chưa","Công ty","Cọc","Chỉ làm","Không quảng","Cần có",
        "Các đầu","Bài đăng","Hiện tại","Khách hàng")
with open(os.path.join(RAW, "Link-dof.csv")) as f:
    for r in list(csv.reader(f))[1:]:
        if len(r) < 5: continue
        bao, gia = r[1].strip(), num(r[2])
        if not gia or not bao or bao.startswith(SKIP): continue
        dr = r[5].strip() if len(r) > 5 else ""
        add(nha_cung_cap="DanaSEO", dich_vu="booking-pr", dau_bao=bao,
            nhom="Bao link dofollow", vi_tri=(r[12].strip() if len(r) > 12 else ""),
            gia_ncc_goc=gia, gia_ban_digicom=gia, so_link=r[3].strip(),
            quy_cach=r[4].strip(), ghi_chu=("DR " + dr) if dr else "",
            nguon="Sheet DanaSEO - Link dof", ngay_cap_nhat=TODAY)

# ============ DanaSEO: Guest Post ============
with open(os.path.join(RAW, "Guest-Post.csv")) as f:
    for r in list(csv.reader(f))[1:]:
        if len(r) < 4: continue
        site, gia = r[1].strip(), num(r[2])
        if not gia or not site: continue
        add(nha_cung_cap="DanaSEO", dich_vu="guest-post", dau_bao=site,
            nhom="Guest post", vi_tri="Bai dang tren site",
            gia_ncc_goc=gia, gia_ban_digicom=gia, quy_cach=r[3].strip(),
            ghi_chu="Ton tai theo domain, link cam ket toi thieu 2 nam",
            nguon="Sheet DanaSEO - Guest Post", ngay_cap_nhat=TODAY)

# ============ DanaSEO: Textlink home (theo tung site, 3-6-12 thang) ============
DURS = ["3 thang", "6 thang", "12 thang"]
with open(os.path.join(RAW, "Textlink-home.csv")) as f:
    for r in list(csv.reader(f))[1:]:
        if len(r) < 10: continue
        site = r[1].strip()
        if not site or not site.startswith("http"): continue
        dr = r[6].strip()
        traffic = r[3].strip()
        for col, loai in ((7, "Link trang chu"), (8, "Link chuyen muc"), (9, "Link fullsite")):
            cell = r[col].strip()
            if not cell: continue
            gias = [num(x) for x in re.split(r"[-–]", cell) if num(x)]
            for i, g in enumerate(gias[:3]):
                add(nha_cung_cap="DanaSEO", dich_vu="textlink", dau_bao=site,
                    nhom="Textlink home", vi_tri=f"{loai} - {DURS[i]}",
                    gia_ncc_goc=g, gia_ban_digicom=g, so_link="1 link",
                    quy_cach=DURS[i],
                    ghi_chu=f"DR {dr} | traffic {traffic}/thang | {r[2].strip()}",
                    nguon="Sheet DanaSEO - Textlink home", ngay_cap_nhat=TODAY)

# ============ DanaSEO: Textlink bao (goi theo so link, khong theo site) ============
# Goi A (sidebar bai viet 3 thang): gia goc / gia KM
GOI_A = [("A1","1000 link sidebar",2_000_000,1_850_000),("A2","1500 link sidebar",3_100_000,2_700_000),
         ("A3","2000 link sidebar",3_900_000,3_600_000),("A4","3000 link sidebar",5_600_000,4_500_000),
         ("A5","5000 link sidebar",8_800_000,7_200_000),("A6","10000 link sidebar",16_800_000,14_000_000),
         ("A7","15000 link sidebar",24_000_000,23_000_000)]
GOI_B = [("B1","1000 link sidebar",3_300_000,2_700_000),("B2","1500 link sidebar",5_100_000,4_000_000),
         ("B3","2000 link sidebar",6_400_000,5_400_000),("B4","3000 link sidebar",9_000_000,7_450_000),
         ("B5","5000 link sidebar",14_800_000,12_000_000),("B6","10000 link sidebar",26_800_000,22_000_000),
         ("B7","15000 link sidebar",40_000_000,35_000_000)]
for goi, mota, gg, gkm in GOI_A:
    add(nha_cung_cap="DanaSEO", dich_vu="textlink", dau_bao=f"Goi {goi} - textlink bao sidebar",
        nhom="Textlink bao (goi)", vi_tri="Sidebar bai viet - 3 thang",
        gia_ncc_goc=gg, gia_ncc_km=gkm, gia_ban_digicom=gg, so_link=mota,
        quy_cach="Dat tren 30-37 trang bao, tang 200 link free",
        ghi_chu="Goi A - 3 thang", nguon="Sheet DanaSEO - Texlink Bao", ngay_cap_nhat=TODAY)
for goi, mota, gg, gkm in GOI_B:
    add(nha_cung_cap="DanaSEO", dich_vu="textlink", dau_bao=f"Goi {goi} - textlink bao sidebar",
        nhom="Textlink bao (goi)", vi_tri="Sidebar bai viet - 6 thang",
        gia_ncc_goc=gg, gia_ncc_km=gkm, gia_ban_digicom=gg, so_link=mota,
        quy_cach="Dat tren 30-37 trang bao, tang 200 link free",
        ghi_chu="Goi B - 6 thang", nguon="Sheet DanaSEO - Texlink Bao", ngay_cap_nhat=TODAY)

# ============ Fame Media (vi tri premium trang chu) ============
FAME_URL = "https://famemedia.vn/bao-online/"
fame = [
    ("Zing News / znews.vn","Top News 1 - Trang chu",230_000_000),
    ("VnExpress.net","Top Story 5,6",150_000_000),
    ("Laodong.vn","Cum tin Under Cover",100_000_000),
    ("Vietnamnet.vn","Tieu diem Home 2-3, Top 1",85_000_000),
    ("Vneconomy.vn","Dac biet trang chu",85_000_000),
    ("Vietnambiz.vn","Bai dac biet - Home",80_000_000),
    ("CafeF.vn","Loai 1 Home - Noi bat 3",70_000_000),
    ("Dantri.com.vn","Trang chu - Link Top 1",70_000_000),
    ("Eva.vn","Dac biet - Home",60_000_000),
    ("Ngoisao.net","Top Story - Tin 2",50_000_000),
    ("Kenh14.vn","Dac biet - Trang chu",45_000_000),
    ("Tuoitre.vn","Hien thi Trang chu 4",40_000_000),
    ("Cafeland.vn","Dac biet trang chu 2",36_000_000),
    ("Techrum.vn","Tin noi bat - Trang chu",35_000_000),
    ("Otofun.net","PR1 - Tin noi bat Trang chu",30_000_000),
    ("Ngoisao.vn","Trang chu - Loai 1",30_000_000),
    ("Suckhoedoisong.vn","Trang chu Top 1",22_000_000),
    ("Vnreview.vn","Tin noi bat 1 - Trang chu",21_000_000),
    ("Phunuvietnam.vn","Bai loai 1 - Tin hot - TC",20_000_000),
    ("Batdongsan.com.vn","Bai Hot 1 - Trang chu",18_000_000),
    ("Autopro.com.vn","Trang chu loai 1",18_000_000),
    ("Afamily.vn","Trang chu dac biet",15_000_000),
]
for bao, vt, gia in fame:
    add(nha_cung_cap="Fame Media", dich_vu="booking-pr", dau_bao=bao,
        nhom="PR bao lon (vi tri premium)", vi_tri=vt, gia_ncc_goc=gia,
        gia_ban_digicom=gia, ghi_chu="Vi tri trang chu/noi bat - gia cao",
        nguon=FAME_URL, ngay_cap_nhat=TODAY)
add(nha_cung_cap="Fame Media", dich_vu="booking-pr", dau_bao="Bao cac tinh",
    nhom="Bao tinh / bao dang", vi_tri="Muc phu hop", gia_ncc_goc=1_280_000,
    gia_ban_digicom=1_280_000, so_link="Link dofollow",
    ghi_chu="Dai gia 1.280.000 - 2.750.000", nguon=FAME_URL, ngay_cap_nhat=TODAY)

# ============ SEOViP (gia khoi diem theo nhom) ============
SEOVIP_URL = "https://seovip.vn/dich-vu-book-bao-pr/"
seovip = [
    ("booking-pr","Nhom bao lon (24h, VnExpress, Eva, CafeF, Kenh14, Dan Tri, Vietnamnet, Tuoi Tre...)","PR bao lon",2_000_000),
    ("booking-pr","Nhom bao Dang/tinh (baodanang, baoquangnam, baothanhhoa...)","Bao tinh / bao dang",1_000_000),
    ("booking-pr","Nhom bao gia re (thuonghieutieudung.vn, bizfinance.vn...)","Bao link dofollow",700_000),
    ("guest-post","GP tong hop (du lich, giao duc, cong nghe, BDS, suc khoe, thoi trang, logistics)","Guest post",200_000),
]
for dv, bao, nhom, gia in seovip:
    add(nha_cung_cap="SEOViP", dich_vu=dv, dau_bao=bao, nhom=nhom,
        vi_tri="Gia khoi diem", gia_ncc_goc=gia, gia_ban_digicom=gia,
        ghi_chu="Gia khoi diem, chua co bang chi tiet tung dau bao",
        nguon=SEOVIP_URL, ngay_cap_nhat=TODAY)

out = os.path.join(BASE, "bang-gia-master.csv")
with open(out, "w", newline="") as f:
    w = csv.writer(f)
    w.writerow(COLS)
    w.writerows(rows)

print("Tong dong:", len(rows))
print("Theo NCC:", dict(Counter(r[0] for r in rows)))
print("Theo dich vu:", dict(Counter(r[1] for r in rows)))
