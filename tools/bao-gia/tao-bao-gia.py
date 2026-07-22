#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""Tao bao gia Google Sheet cho khach - loc tu 10-bang-gia-booking/gia-web.csv.

Vi du:
  python3 tao-bao-gia.py --nganh suc-khoe --dich-vu booking-pr --so-luong 15
  python3 tao-bao-gia.py --nganh bat-dong-san --ngan-sach 50000000 --khach "Anh Tuan"
  python3 tao-bao-gia.py --liet-ke-nganh          # xem cac nganh dung duoc
  python3 tao-bao-gia.py ... --xem-truoc          # chi in ra man hinh, khong tao sheet

Khong truyen --nganh  -> lay bao tong hop (bao lon da nganh), hop moi linh vuc.
"""
import argparse, csv, json, os, re, sys, unicodedata, urllib.request
from datetime import date, timedelta

BASE = os.path.dirname(os.path.abspath(__file__))
CSV  = os.path.join(BASE, "..", "..", "10-bang-gia-booking", "gia-web.csv")
CFG  = os.path.join(BASE, "config.json")


def fold(s: str) -> str:
    s = unicodedata.normalize("NFD", (s or "").lower())
    s = "".join(c for c in s if unicodedata.category(c) != "Mn")
    return re.sub(r"[^a-z0-9]", "", s.replace("đ", "d"))


# Tu khoa nhan dien nganh - CHI khop tren TEN MIEN (dau_bao), khong khop quy_cach
# (vi tu "duoc"/"vay"... trong mo ta bai rat de dinh nham).
NGANH = {
    "suc-khoe":     ["suckhoe", "yte", "benhvien", "bacsi", "alobacsi", "skds", "medic", "doctor",
                     "nhathuoc", "duocpham", "camnangsuckhoe", "songkhoe", "vienyhoc"],
    "lam-dep":      ["lamdep", "thammy", "mypham", "beauty", "spa", "wikithammy", "toctet"],
    "me-va-be":     ["mevabe", "lamchame", "webtretho", "bauvn", "mamnon", "tremam", "eva"],
    "tai-chinh":    ["nganhang", "bank", "finance", "fintech", "taichinh", "chungkhoan", "vietstock",
                     "cafef", "vneconomy", "vietnambiz", "giavang", "baohiem", "thebank", "dautu"],
    "bat-dong-san": ["batdongsan", "cafeland", "reatimes", "nhadat", "diaoc", "nguoidothi"],
    "xay-dung":     ["xaydung", "vatlieu", "betong", "thep", "noithat", "kientruc"],
    "cong-nghe":    ["congnghe", "tech", "phanmem", "genk", "vnreview", "tinhte", "didong",
                     "dienthoai", "laptop", "maytinh", "camera"],
    "oto-xe-may":   ["autopro", "autodaily", "otofun", "xedap", "xemay", "oto"],
    "du-lich":      ["dulich", "travel", "tourism", "hotel", "khachsan", "amthuc", "nhahang", "resort"],
    "giao-duc":     ["giaoduc", "edu", "hocsinh", "sinhvien", "duhoc", "truong", "khoahoc"],
    "giai-tri":     ["giaitri", "kenh14", "saostar", "ngoisao", "yan", "2sao", "soha", "afamily", "tiin"],
    "the-thao":     ["thethao", "bongda", "golf", "sport"],
    "phap-luat":    ["phapluat", "congan", "congly", "anninh", "nguoiduatin", "plovn"],
    "nong-nghiep":  ["nongnghiep", "nongthon", "thucpham", "nongsan"],
    "thoi-trang":   ["thoitrang", "fashion", "quanao", "giay"],
    "doanh-nghiep": ["doanhnghiep", "doanhnhan", "thuonghieu", "cafebiz", "diendandoanhnghiep"],
}

# Bao lon da nganh - phu hop moi linh vuc, luon duoc bo sung neu con thieu suat.
# Khop theo TEN MIEN CHINH XAC (khong phai substring) de tranh dinh nham
# 'daklak24h' <- '24h', 'tuoitrexahoi' <- 'tuoitre'.
TONG_HOP = {"vnexpress.net", "dantri.com.vn", "vietnamnet.vn", "thanhnien.vn", "tuoitre.vn",
            "znews.vn", "zingnews.vn", "24h.com.vn", "laodong.vn", "nld.com.vn",
            "tienphong.vn", "vtcnews.vn", "kenh14.vn", "soha.vn", "cafef.vn",
            "cafebiz.vn", "afamily.vn", "eva.vn", "baodautu.vn", "vnexpress.vn"}

DICH_VU_TEN = {
    "booking-pr":      "Booking báo & PR",
    "guest-post":      "Guest Post",
    "textlink":        "Mua Textlink",
    "toplist":         "Toplist",
    "booking-tv":      "Booking truyền hình",
    "backlink-quocte": "Backlink quốc tế",
}

# Nguoi tao / phu trach bao gia (PIC) -> so dien thoai lien he.
# File Sheet se duoc xep vao thu muc Drive theo ten PIC (khong dau).
PIC = {
    "thang":  ("Lê Văn Thắng",       "0983 797 186"),
    "huyen":  ("Đỗ Thị Thanh Huyền", "0979 305 186"),
    "trang":  ("Đỗ Thị Thu Trang",   "0905 859 186"),
}
PIC_MAC_DINH = "thang"


def ten_mien(dau_bao: str) -> str:
    """Tach ten mien tu o 'dau_bao' (co the kem nhan: 'Kênh 14.vn', 'Baotayninh.vn (BÁO MỚI VỀ)')."""
    s = re.sub(r"\(.*?\)", " ", dau_bao or "").strip().lower()
    m = re.search(r"[a-z0-9][a-z0-9\-\.]*\.(?:vn|com|net|org|info|biz|co|io|asia)(?:\.vn)?", s)
    return m.group(0) if m else s.split()[0] if s.split() else ""


def nganh_cua(dau_bao: str):
    h = fold(dau_bao)
    return [ng for ng, kws in NGANH.items() if any(k in h for k in kws)]


def la_tong_hop(dau_bao: str) -> bool:
    d = ten_mien(dau_bao)
    return d in TONG_HOP or any(d.endswith("." + t) for t in TONG_HOP)


# Chuoi bi mat dau trong du lieu goc -> phuc hoi truoc khi gui khach
SUA_DAU = {
    "muc phu hop": "Mục phù hợp",
    "mua them link": "Mua thêm link",
    "link chuyen muc": "Link chuyên mục",
    "trang chu": "Trang chủ",
    "chuyen muc": "Chuyên mục",
    "bai viet": "Bài viết",
    "bao moi ve": "báo mới về",
}


def sach(s: str) -> str:
    """Lam sach o chu truoc khi dua vao bao gia gui khach."""
    s = re.sub(r"\s+", " ", (s or "").strip())
    low = s.lower()
    for sai, dung in SUA_DAU.items():
        if low == sai:
            return dung
        if low.startswith(sai + " "):
            s = dung + s[len(sai):]
            break
    return s


def ten_hien_thi(dau_bao: str) -> str:
    """Chi giu ten mien / ten bao, bo phan mo ta lan vao o (vd 'x.vn Bai PR loai 2 (Muc...')."""
    s = sach(dau_bao)
    d = ten_mien(s)
    if d and len(s) > len(d) + 4:
        i = s.lower().find(d)
        if i >= 0:
            return s[: i + len(d)].strip(" -|·,")
    return s


def doc_gia():
    with open(CSV, encoding="utf-8") as f:
        return [r for r in csv.DictReader(f) if (r.get("gia") or "").strip().isdigit()]


def loc(rows, nganh=None, dich_vu=None, gia_min=0, gia_max=0, so_luong=15):
    out = [r for r in rows if not dich_vu or r["dich_vu"] == dich_vu]
    if gia_min:
        out = [r for r in out if int(r["gia"]) >= gia_min]
    if gia_max:
        out = [r for r in out if int(r["gia"]) <= gia_max]

    if nganh:
        dung = [r for r in out if nganh in nganh_cua(r["dau_bao"])]
        them = [r for r in out if r not in dung and la_tong_hop(r["dau_bao"])]
    else:
        dung, them = [r for r in out if la_tong_hop(r["dau_bao"])], []
        if not dung:
            dung = out

    key = lambda r: int(r["gia"])
    chon = sorted(dung, key=key) + sorted(them, key=key)
    return chon[:so_luong]


def theo_ngan_sach(rows, tran, **kw):
    """Chon nhieu dau bao nhat co the ma tong <= tran."""
    ung = loc(rows, so_luong=10_000, **kw)
    chon, tong = [], 0
    for r in ung:
        g = int(r["gia"])
        if tong + g <= tran:
            chon.append(r)
            tong += g
    return chon


def cfg():
    if not os.path.exists(CFG):
        sys.exit("Chua co config.json. Copy config.mau.json thanh config.json va dien thong tin.")
    return json.load(open(CFG, encoding="utf-8"))


def main():
    p = argparse.ArgumentParser()
    p.add_argument("--nganh")
    p.add_argument("--dich-vu", choices=list(DICH_VU_TEN))
    p.add_argument("--so-luong", type=int, default=15)
    p.add_argument("--gia-min", type=int, default=0)
    p.add_argument("--gia-max", type=int, default=0)
    p.add_argument("--ngan-sach", type=int, default=0, help="Tran tong ngan sach (VND)")
    p.add_argument("--khach", default="", help="Ten khach hang / cong ty")
    p.add_argument("--pic", choices=list(PIC), default=PIC_MAC_DINH,
                   help="Nguoi tao bao gia: thang / huyen / trang")
    p.add_argument("--loai", default="",
                   help="Loai san pham -> ten thu muc Drive. Bo trong = lay ten dich vu")
    p.add_argument("--hieu-luc", type=int, default=7, help="So ngay bao gia con hieu luc")
    p.add_argument("--xem-truoc", action="store_true")
    p.add_argument("--liet-ke-nganh", action="store_true")
    a = p.parse_args()

    if a.liet_ke_nganh:
        print("\n".join(sorted(NGANH)))
        return

    rows = doc_gia()
    kw = dict(nganh=a.nganh, dich_vu=a.dich_vu, gia_min=a.gia_min, gia_max=a.gia_max)
    chon = theo_ngan_sach(rows, a.ngan_sach, **kw) if a.ngan_sach else loc(rows, so_luong=a.so_luong, **kw)

    if not chon:
        sys.exit("Khong tim thay dong nao khop dieu kien. Thu bo bot --nganh hoac --dich-vu.")

    cols = ["STT", "Đầu báo / Trang", "Vị trí đăng", "Quy cách bài", "Loại link", "Giá (VNĐ)"]
    data = [[i + 1, ten_hien_thi(r["dau_bao"]), sach(r["vi_tri"]),
             sach(r["quy_cach"]), sach(r["so_link"]), int(r["gia"])]
            for i, r in enumerate(chon)]
    tong = sum(int(r["gia"]) for r in chon)

    if a.xem_truoc:
        pt, ps = PIC[a.pic]
        loai_xt = a.loai.strip() or DICH_VU_TEN.get(a.dich_vu, "truyền thông")
        print(f'PIC: {pt} - {ps}   |   Thư mục Drive: {pt} / {loai_xt}\n')
        for i, r in enumerate(chon):
            print(f'{i+1:>3}. {ten_hien_thi(r["dau_bao"])[:32]:<34} '
                  f'{sach(r["vi_tri"])[:26]:<28} {int(r["gia"]):>12,}')
        print(f'{"TỔNG":>3}  {tong:>76,} VNĐ ({len(chon)} mục, chưa VAT)')
        return

    c = cfg()
    ten_dv = DICH_VU_TEN.get(a.dich_vu, "truyền thông")
    pic_ten, pic_sdt = PIC[a.pic]
    loai = a.loai.strip() or ten_dv          # ten thu muc Drive tang 2
    hom_nay = date.today()
    lien_he = f'{c["dong_lien_he"]} · Phụ trách: {pic_ten} - {pic_sdt}'
    payload = {
        "token": c["token"],
        "ten_file": f'Bao gia {ten_dv}{" - " + a.khach if a.khach else ""} {hom_nay:%d.%m.%Y}',
        "tieu_de": f'BÁO GIÁ {ten_dv.upper()}' + (f' - {a.khach.upper()}' if a.khach else ""),
        "dong_hieu_luc": f'Ngày lập: {hom_nay:%d/%m/%Y} · Báo giá có hiệu lực đến hết '
                         f'{hom_nay + timedelta(days=a.hieu_luc):%d/%m/%Y}',
        "brand": {"cong_ty": c["cong_ty"], "dong_lien_he": lien_he},
        "pic": pic_ten,    # ten thu muc Drive tang 1 (nguoi tao)
        "loai": loai,      # ten thu muc Drive tang 2 (loai san pham)
        "cols": cols,
        "rows": data,
        "widths": [45, 230, 210, 320, 150, 120],
        "ghi_chu": c["ghi_chu"],
    }

    req = urllib.request.Request(
        c["webapp_url"], data=json.dumps(payload).encode(),
        headers={"Content-Type": "application/json"})
    res = json.loads(urllib.request.urlopen(req, timeout=90).read())

    if not res.get("ok"):
        sys.exit("Loi tu Apps Script: " + str(res.get("error")))
    print(f'{len(chon)} muc · Tong {tong:,} VND (chua VAT)')
    print(res["url"])


if __name__ == "__main__":
    main()
