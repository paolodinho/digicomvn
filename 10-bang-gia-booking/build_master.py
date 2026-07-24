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

# Quy tac gia (chot 2026-07-14, sau phan hoi cua Hieu):
# gia_ban_digicom = GIA CUOI cua NCC = gia ho THUC BAN.
#   - Co gia khuyen mai/chiet khau -> lay gia do (gia_ncc_km).
#   - Chi co 1 gia -> lay gia do (gia_ncc_goc).
# KHONG lay gia goc niem yet (gia gach ngang) - se dat hon chinh NCC.

def num(s):
    if not s: return ""
    s = re.sub(r"[^\d]", "", str(s).strip())
    return int(s) if s else ""

rows = []
def add(**kw):
    """gia_ban_digicom luon = GIA CUOI: uu tien gia_ncc_km (gia KM/CK), khong co thi lay gia_ncc_goc."""
    kw["gia_ban_digicom"] = kw.get("gia_ncc_km") or kw.get("gia_ncc_goc") or ""
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
            quy_cach=r[3].strip(),
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
            gia_ncc_goc=gia, so_link=r[3].strip(),
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
            gia_ncc_goc=gia, quy_cach=r[3].strip(),
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
                    gia_ncc_goc=g, so_link="1 link",
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
        gia_ncc_goc=gg, gia_ncc_km=gkm, so_link=mota,
        quy_cach="Dat tren 30-37 trang bao, tang 200 link free",
        ghi_chu="Goi A - 3 thang", nguon="Sheet DanaSEO - Texlink Bao", ngay_cap_nhat=TODAY)
for goi, mota, gg, gkm in GOI_B:
    add(nha_cung_cap="DanaSEO", dich_vu="textlink", dau_bao=f"Goi {goi} - textlink bao sidebar",
        nhom="Textlink bao (goi)", vi_tri="Sidebar bai viet - 6 thang",
        gia_ncc_goc=gg, gia_ncc_km=gkm, so_link=mota,
        quy_cach="Dat tren 30-37 trang bao, tang 200 link free",
        ghi_chu="Goi B - 6 thang", nguon="Sheet DanaSEO - Texlink Bao", ngay_cap_nhat=TODAY)

# ============ DanaSEO: Dich vu entity (social entity) ============
ENTITY = [("Goi 1", "120 Social chat luong loc ky", 2_000_000),
          ("Goi 2", "250 Social chat luong loc ky", 2_990_000),
          ("Goi 3", "300 Social chat luong loc ky", 4_000_000)]
for goi, mota, gia in ENTITY:
    add(nha_cung_cap="DanaSEO", dich_vu="entity", dau_bao=f"Social entity - {goi}",
        nhom="Social entity", vi_tri=mota, gia_ncc_goc=gia, quy_cach="Ban giao sau 3 ngay, file bao cao day du, ho tro nap index >85%, ho tro Schema",
        ghi_chu="Combo Trangvang giam 10-100%; kem GG Map giam 5-15%",
        nguon="Sheet DanaSEO - Dich vu entity", ngay_cap_nhat=TODAY)

# ============ DanaSEO: Toplist (cho thue) ============
add(nha_cung_cap="DanaSEO", dich_vu="toplist", dau_bao="Toplist local (HN/TPHCM/DN + 25 tinh)",
    nhom="Cho thue toplist", vi_tri="Bai top - gia khoi diem", gia_ncc_goc=300_000,
    gia_ban_digicom=300_000, quy_cach="Gia/thang",
    ghi_chu="Tu 300k/thang, gia theo tung site + tung tu khoa - can hoi lai NCC",
    nguon="Sheet DanaSEO - Toplist", ngay_cap_nhat=TODAY)

# ============ Cac NCC khac (nap tu raw/ncc-khac.csv + Rise-Media.csv, phan cach |) ============
# Cot: nha_cung_cap|dich_vu|dau_bao|nhom|vi_tri|gia_vnd|so_link|quy_cach|ghi_chu|nguon_url
# gia_vnd co the la dai "6000000-7500000" hoac "tu 9000000" -> lay MUC THAP NHAT.
# Rise-Media.csv: gia_vnd DA nhan san 1.1 (theo yeu cau Hieu 2026-07-24) khi parse tu sheet goc,
# vi vay gia_ban_digicom = gia_vnd (khong nhan them lan nua).
for EXTRA in (os.path.join(RAW, "ncc-khac.csv"), os.path.join(RAW, "Rise-Media.csv")):
  if os.path.exists(EXTRA):
    with open(EXTRA) as f:
        for line in f:
            line = line.strip()
            if not line or line.startswith("#"): continue
            p = [x.strip() for x in line.split("|")]
            if len(p) < 10: continue
            ncc, dv, bao, nhom, vt, gia_raw, slink, qc, ghi, url = p[:10]
            gias = [num(x) for x in re.split(r"[-–]", gia_raw) if num(x)]
            if not gias: continue
            gia = min(gias)
            # Neu ghi chu co "Gia CK cua NCC: <so>" -> do la GIA CUOI cua ben do
            m_ck = re.search(r"Gia CK cua NCC:\s*([\d.,]+)", ghi)
            gia_km = num(m_ck.group(1)) if m_ck else ""
            if len(gias) > 1:
                dai = " - ".join(f"{g:,}".replace(",", ".") for g in gias)
                ghi = (ghi + " | " if ghi else "") + f"Dai gia NCC: {dai} d (lay muc thap nhat)"
            add(nha_cung_cap=ncc, dich_vu=dv, dau_bao=bao, nhom=nhom, vi_tri=vt,
                gia_ncc_goc=gia, gia_ncc_km=gia_km, so_link=slink, quy_cach=qc,
                ghi_chu=ghi, nguon=url, ngay_cap_nhat=TODAY)

out = os.path.join(BASE, "bang-gia-master.csv")
with open(out, "w", newline="") as f:
    w = csv.writer(f)
    w.writerow(COLS)
    w.writerows(rows)

print("Tong dong:", len(rows))
print("Theo NCC:", dict(Counter(r[0] for r in rows)))
print("Theo dich vu:", dict(Counter(r[1] for r in rows)))
