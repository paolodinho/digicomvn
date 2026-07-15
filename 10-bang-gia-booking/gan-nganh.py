#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""Suy ra NGANH cho tung dong bang gia (de bo loc "linh vuc" hoat dong).

Nguon suy luan, theo thu tu uu tien:
  1. Tu khoa trong TEN MIEN / ten ban ghi (vd 'nganhang' -> tai-chinh, 'xedapdien' -> oto-xe-may).
  2. Nhom dich vu (bao tinh -> bao-tinh; bao lon -> bao-lon).
  3. Khong doan duoc -> de trong (KHONG gan bua, tranh khach loc ra roi khong dung linh vuc).

Chay: python3 gan-nganh.py  -> sinh nganh-payload.json
"""
import json, re, unicodedata, os

BASE = os.path.dirname(os.path.abspath(__file__))

def fold(s):
    s = unicodedata.normalize("NFD", (s or "").lower())
    s = "".join(c for c in s if unicodedata.category(c) != "Mn")
    return s.replace("đ", "d")

# tu khoa (trong ten mien / ten ban ghi / quy cach) -> nganh
KW = {
    "tai-chinh":    ["nganhang", "bank", "finance", "fintech", "taichinh", "chungkhoan", "vietstock",
                     "cafef", "vneconomy", "vietnambiz", "bizfinance", "vnfinance", "giavang", "baohiem",
                     "internetbanking", "taikhoan", "vay", "thebank", "dautu", "nhipcaudautu", "cophieu"],
    "bat-dong-san": ["batdongsan", "cafeland", "reatimes", "nhadat", "diaoc", "homegift", "home.vn",
                     "muabanthuenha", "nguoidothi", "propr"],
    "xay-dung":     ["xaydung", "vatlieu", "betong", "thep", "trambetong", "giathep", "dailythep", "htd"],
    "kien-truc":    ["kientruc", "noithat", "topaz", "cuanhua", "windows"],
    "cong-nghe":    ["congnghe", "tech", "phanmem", "genk", "vnreview", "techrum", "tinhte", "didong",
                     "dienthoai", "phone", "apk", "moddroid", "vpn", "camera", "laptop", "maytinh",
                     "vietnamobile", "fpttelecom", "teamvietdev", "hieugoogle", "quangcaotructuyen"],
    "oto-xe-may":   ["autopro", "autodaily", "otofun", "xedap", "xemay", "megacar", "oto.danang",
                     "pinxedapdien", "hiephoixedien", "duclinhmobile"],
    "y-te":         ["suckhoe", "yte", "benhvien", "bacsi", "alobacsi", "duoc", "camnangsuckhoe",
                     "skds", "doctor", "dentist", "medic"],
    "lam-dep":      ["lamdep", "thammy", "mypham", "beauty", "spa", "wikithammy", "tattoo", "kevinle"],
    "me-va-be":     ["mevabe", "lamchame", "webtretho", "bau.vn", "mamnon", "thieunien", "tremam"],
    "du-lich":      ["dulich", "travel", "tourism", "hotel", "khachsan", "amthuc", "nhahang", "monchay",
                     "camngot", "resort", "kichcaudulich", "disantrangan", "chuabaidinh", "suoiluong",
                     "bariavungtautourism", "dulichhatinh", "dulichsontra", "arcenciel", "nikko"],
    "giao-duc":     ["giaoduc", "edu", "hocsinh", "sinhvien", "duhoc", "vieclam", "truong", "namhocsg",
                     "anhsang", "enetviet", "khoahoc"],
    "giai-tri":     ["giaitri", "kenh14", "saostar", "ngoisao", "yan", "yeah1", "2sao", "soha",
                     "afamily", "eva", "tiin", "megateen", "cuoixastress", "ohay"],
    "the-thao":     ["thethao", "bongda", "golf", "sport"],
    "game":         ["game", "gamek"],
    "an-ninh-pl":   ["phapluat", "congan", "congly", "anninh", "toaan", "bienphong", "nguoiduatin",
                     "plo.vn", "baophapluat", "phapluatnet", "sohuutritue"],
    "nong-nghiep":  ["nongnghiep", "nongthon", "thucpham", "nongsan", "thucanh", "cacanh", "hoacanh",
                     "gianongsan", "chocanh"],
    "logistics":    ["logistics", "vantai", "giaonhan", "express", "vanchuyen", "topvantai", "bus"],
    "thoi-trang":   ["thoitrang", "fashion", "quanao", "giay"],
    "thi-truong":   ["thitruong", "tieudung", "tieudungtiepthi", "hanghoa", "sieuthi",
                     "danhgiasao", "congdongdanhgia", "bestnhat", "toptonghop", "topreview"],
    "doanh-nghiep": ["doanhnghiep", "doanhnhan", "thuonghieu", "chonthuonghieu", "cafebiz",
                     "diendandoanhnghiep", "doanhnghiepvn", "vietnamta", "chuyengia", "mentor"],
    "kinh-te":      ["kinhte", "vneconomy", "thesaigontimes", "kinhtedothi", "kinhtemoitruong"],
    "phong-thuy":   ["phongthuy", "tamlinh", "lyhoc", "phathoc", "nhantuonghoc"],
}

NHOM_NGANH = {
    "Bao tinh / bao dang": "bao-tinh",
    "PR bao lon": "bao-lon",
    "PR bao lon (vi tri premium)": "bao-lon",
    "Rate card chinh thuc": "bao-lon",
}

def nganh_for(title, nhom, quy_cach=""):
    hay = fold(title) + " " + fold(quy_cach)
    hay = re.sub(r"[^a-z0-9]", "", hay)
    tags = []
    for ng, kws in KW.items():
        if any(re.sub(r"[^a-z0-9]", "", k) in hay for k in kws):
            tags.append(ng)
    base = NHOM_NGANH.get(nhom)
    if base and base not in tags:
        tags.insert(0, base)
    return tags

if __name__ == "__main__":
    import csv
    live = json.load(open(os.path.join(BASE, "live-now.json")))
    master = list(csv.DictReader(open(os.path.join(BASE, "bang-gia-master.csv"))))
    # nhom goc cua tung dau bao (de biet bao tinh / bao lon)
    nhom_of = {}
    for r in master:
        nhom_of.setdefault(fold(r["dau_bao"]).strip(), r["nhom"])

    # Dong la GOI DICH VU (khong gan lien 1 nganh cu the) -> khong gan nganh
    GOI_PREFIX = ("goi ", "combo ", "social entity", "toplist ", "he thong", "site toplist",
                  "website authority", "blog/", "blog ", "42 site", "nhom bao", "bao cac tinh",
                  "gp tong hop")
    ups, n_skip, n_goi = [], 0, 0
    for p in live:
        if p.get("nganh"):        # da co tag (curate tay truoc do) -> khong dung toi
            n_skip += 1
            continue
        if fold(p["title"]).strip().startswith(GOI_PREFIX):
            n_goi += 1
            continue
        nhom_master = nhom_of.get(fold(p["title"]).strip(), "")
        tags = nganh_for(p["title"], nhom_master, p.get("vi_tri", ""))
        if not tags:
            continue
        ups.append({"id": p["ID"], "nganh": ",".join(tags)})

    json.dump(ups, open(os.path.join(BASE, "nganh-payload.json"), "w"), ensure_ascii=False)
    print(f"Gan nganh cho {len(ups)} dong | giu nguyen {n_skip} dong da co tag | bo qua {n_goi} goi dich vu")
    from collections import Counter
    c = Counter(t for u in ups for t in u["nganh"].split(","))
    print("Phan bo:", dict(c.most_common(12)))
    for u in ups[:10]:
        t = next(x["title"] for x in live if x["ID"] == u["id"])
        print(f"   {t[:34]:<36} {u['nganh']}")
