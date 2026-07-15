#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""Sinh payload import 2 nhom moi len web: Backlink quoc te + Booking truyen hinh.
Du lieu boc ve la ASCII khong dau -> phai viet lai tieng Viet CO DAU truoc khi len web
(rule bang-gia-booking.md: text hien thi cho khach phai co dau day du)."""
import csv, json, re, os

BASE = os.path.dirname(os.path.abspath(__file__))
rows = [r for r in csv.DictReader(open(os.path.join(BASE, "gia-web.csv")))
        if r["dich_vu"] in ("backlink-quocte", "booking-tv")]

# --- Ten kenh truyen hinh hien thi ---
KENH = {"vtv": "VTV (TVAd)", "vtv1": "VTV1", "vtv3": "VTV3", "htv7": "HTV7", "htv9": "HTV9"}

# --- Bo tu dien phuc hoi dau tieng Viet (cum dai truoc, ngan sau) ---
DAU = [
    # Truyen hinh - vi tri
    ("Ai la trieu phu - ngoai chuong trinh", "Ai là triệu phú - ngoài chương trình"),
    ("Ai la trieu phu - trong chuong trinh", "Ai là triệu phú - trong chương trình"),
    ("Ban tin Thoi su / Doanh nghiep va Thuong hieu", "Bản tin Thời sự / Doanh nghiệp và Thương hiệu"),
    ("Ban tin / chuyen muc doanh nghiep", "Bản tin / chuyên mục doanh nghiệp"),
    ("Ca phe Sang 6h30-7h15", "Cà phê Sáng 6h30-7h15"),
    ("Chung ket World Cup 2026", "Chung kết World Cup 2026"),
    ("Chuong trinh 12h00 - muc Tu gioi thieu", "Chương trình 12h00 - mục Tự giới thiệu"),
    ("Chuong trinh 18h00 - muc Tu gioi thieu", "Chương trình 18h00 - mục Tự giới thiệu"),
    ("Thoi su toi 20h - muc Tu gioi thieu", "Thời sự tối 20h - mục Tự giới thiệu"),
    ("Thoi su trua 11h30 - muc Tu gioi thieu", "Thời sự trưa 11h30 - mục Tự giới thiệu"),
    ("Khung gio vang ~19h55 truoc Thoi su 20h", "Khung giờ vàng ~19h55, trước Thời sự 20h"),
    ("Sau Ban tin Chao buoi sang ~6h20", "Sau Bản tin Chào buổi sáng ~6h20"),
    ("Khung sang 6h00-7h00", "Khung sáng 6h00-7h00"),
    ("Khung ban ngay", "Khung ban ngày"),
    ("Nhip song doanh nghiep (thu Tu) 16h00", "Nhịp sống doanh nghiệp (thứ Tư) 16h00"),
    ("Nhip song tre (thu Bay) 9h45", "Nhịp sống trẻ (thứ Bảy) 9h45"),
    ("Talk Show (thu Bay) 9h45", "Talk Show (thứ Bảy) 9h45"),
    ("Phim truyen VN 20h (T2-T6)", "Phim truyện VN 20h (T2-T6)"),
    ("Trong gio phat song Nguoi Bi An", "Trong giờ phát sóng Người Bí Ẩn"),
    ("Truoc gio phat song Nguoi Bi An", "Trước giờ phát sóng Người Bí Ẩn"),
    ("Truoc gameshow gio vang", "Trước gameshow giờ vàng"),
    # Truyen hinh - quy cach
    ("Phong su - ban tin 30s-120s", "Phóng sự / bản tin 30-120 giây"),
    ("Phong su / tu gioi thieu 120 giay", "Phóng sự / tự giới thiệu 120 giây"),
    ("Phong su / tu gioi thieu 180 giay", "Phóng sự / tự giới thiệu 180 giây"),
    ("Tu gioi thieu 60 giay", "Tự giới thiệu 60 giây"),
    ("Tu gioi thieu 90 giay", "Tự giới thiệu 90 giây"),
    ("Talkshow 7-8 phut", "Talkshow 7-8 phút"),
    ("TVC 10 giay", "TVC 10 giây"), ("TVC 15 giay", "TVC 15 giây"),
    ("TVC 20 giay", "TVC 20 giây"), ("TVC 30 giay", "TVC 30 giây"),
    # Quoc te - ten goi / quy cach
    ("Goi niche edit", "Gói niche edit"), ("Goi 10 guest post theo nganh", "Gói 10 guest post theo ngành"),
    ("Goi 60 guest post", "Gói 60 guest post"), ("Goi Startup", "Gói Startup"),
    ("Goi Starter", "Gói Starter"), ("Goi Growth", "Gói Growth"), ("Goi Performance", "Gói Performance"),
    ("Goi Pro", "Gói Pro"), ("Goi Spark", "Gói Spark"), ("Goi Basic US/Canada", "Gói Basic US/Canada"),
    ("Goi Basic", "Gói Basic"), ("Goi Standard", "Gói Standard"), ("Goi Advanced", "Gói Advanced"),
    ("Goi Premium2", "Gói Premium 2"), ("Goi Premium (thue bao thang)", "Gói Premium (thuê bao tháng)"),
    ("Goi Gold (thue bao thang)", "Gói Gold (thuê bao tháng)"), ("Goi Premium", "Gói Premium"),
    ("Goi Local", "Gói Local"), ("Goi National", "Gói National"), ("Goi Global Premier", "Gói Global Premier"),
    ("Goi Online", "Gói Online"), ("Goi Budget", "Gói Budget"), ("Goi Feature", "Gói Feature"),
    ("Goi Newsmaker", "Gói Newsmaker"), ("Goi Buzz Builder", "Gói Buzz Builder"), ("Goi PR Pro", "Gói PR Pro"),
    ("Goi PR Network Plus", "Gói PR Network Plus"), ("Goi SimplePost", "Gói SimplePost"),
    ("Goi Visibility Boost", "Gói Visibility Boost"), ("Goi Integrated Media Pro+", "Gói Integrated Media Pro+"),
    ("Goi Integrated Media Pro", "Gói Integrated Media Pro"), ("Goi Mass Media Visibility", "Gói Mass Media Visibility"),
    ("Goi US National (MAX)", "Gói US National (MAX)"), ("Goi Tier", "Gói Tier"),
    ("Goi Yahoo Finance + 500 outlet", "Gói Yahoo Finance + 500 đầu báo"),
    ("Goi 5 thong cao", "Gói 5 thông cáo"), ("Goi 20 thong cao", "Gói 20 thông cáo"),
    ("Goi 10 credits", "Gói 10 credit"), ("Goi 30 credits", "Gói 30 credit"), ("Goi 100 credits", "Gói 100 credit"),
    ("1 thong cao le", "1 thông cáo lẻ"), ("1 thong cao", "1 thông cáo"), ("thong cao/thang", "thông cáo/tháng"),
    ("thong cao", "thông cáo"), ("1 credit", "1 credit"),
    ("Editorial link le", "Link biên tập lẻ"),
    ("Guest post Authority", "Guest post Authority"), ("Guest post Essential", "Guest post Essential"),
    ("Guest post / blogger outreach", "Guest post / blogger outreach"),
    ("Bao lon - dai TV - newsroom", "Báo lớn - đài TV - newsroom"),
    ("Chi dang tren site 24-7", "Chỉ đăng trên site 24-7"),
    ("Business Insider - AP Mobile - circuit chuyen nganh", "Business Insider - AP Mobile - chuyên trang ngành"),
    ("bien tap bai", "biên tập bài"), ("danh sach nganh", "danh sách ngành"),
    ("kem viet bai", "kèm viết bài"), ("bai theo nganh", "bài theo ngành"),
    ("Bai PR", "Bài PR"), ("Bai dang", "Bài đăng"), ("bai/thang", "bài/tháng"),
    ("Chen link vao bai co san", "Chèn link vào bài có sẵn"),
    ("Chen vao bai roundup / best-of", "Chèn vào bài roundup / best-of"),
    ("Blogger outreach - permanent", "Blogger outreach - giữ vĩnh viễn"),
    ("Link bien tap vinh vien", "Link biên tập, giữ vĩnh viễn"),
    ("Link bien tap site", "Link biên tập, site"),
    ("Guest post site", "Guest post trên site"),
    ("bai moc moi", "bài mọc mới"), ("Managed", "Quản lý trọn gói"),
    ("Distribution", "Phân phối"), ("Phan phoi", "Phân phối"),
    ("toan cau", "toàn cầu"), ("toan quoc My", "toàn quốc Mỹ"), ("dia phuong My", "địa phương Mỹ"),
    ("My - Canada", "Mỹ - Canada"), ("Bac My", "Bắc Mỹ"), ("quoc te", "quốc tế"),
    ("khu vuc", "khu vực"), ("mo rong", "mở rộng"), ("co ban", "cơ bản"), ("cao nhat", "cao nhất"),
    ("cao cap", "cao cấp"), ("hang tram site doi tac", "hàng trăm site đối tác"),
    ("Khong gioi han so tu", "Không giới hạn số từ"), ("Ho tro logo/anh/video", "Hỗ trợ logo/ảnh/video"),
    ("Cam ket dang", "Cam kết đăng"), ("live trong", "lên sóng trong"),
    ("bao cao PDF kem link live", "báo cáo PDF kèm link bài"),
    ("Chua VAT", "Chưa gồm VAT"), ("chua VAT", "chưa gồm VAT"),
    ("Gia niem yet", "Giá niêm yết"), ("nha dai", "nhà đài"),
    ("Tron goi gom ekip ghi hinh + phat song", "Trọn gói gồm ê-kíp ghi hình + phát sóng"),
    ("Rate card TVAd su kien dac biet", "Rate card TVAd, sự kiện đặc biệt"),
    ("Rate card TVAd", "Rate card TVAd"),
    ("Khung dat nhat cua VTV1", "Khung đắt nhất của VTV1"),
    ("Muc thap nhat khung sang VTV3", "Mức thấp nhất khung sáng VTV3"),
    ("Khung dat nhat muc tu gioi thieu HTV9", "Khung đắt nhất mục tự giới thiệu HTV9"),
    ("quay tai TP.HCM", "quay tại TP.HCM"), ("chua tru chiet khau", "chưa trừ chiết khấu"),
    ("Gia niem yet HTV", "Giá niêm yết HTV"),
    ("Mang luoi quoc gia + AP", "Mạng lưới quốc gia + AP"),
    ("Mang luoi toàn cầu", "Mạng lưới toàn cầu"),
    ("Toan quoc My + AP", "Toàn quốc Mỹ + AP"),
    ("Phi thanh vien 195 usd/nam tinh rieng", "Phí thành viên 195 usd/năm tính riêng"),
    ("Khong phi thanh vien", "Không phí thành viên"),
    ("Guest post bien tap thu cong", "Guest post biên tập thủ công"),
    ("Da phuong tien - newsroom - SEO metadata", "Đa phương tiện - newsroom - SEO metadata"),
    ("Feed nganh + blogger network", "Feed ngành + mạng lưới blogger"),
    ("Bao dam thay the neu bi go", "Bảo đảm thay thế nếu bị gỡ"),
    ("Phân phối digital + truyen thong", "Phân phối digital + truyền thống"),
    ("Khong phan phoi them", "Không phân phối thêm"),
    ("Site traffic 1000+/thang", "Site traffic 1.000+/tháng"),
    ("link/thang", "link/tháng"),
    ("tai chinh", "tài chính"), ("traffic that", "traffic thật"), ("trung binh", "trung bình"),
    ("theo nganh", "theo ngành"), ("moi thang", "mỗi tháng"), ("va", "và"),
]

def co_dau(s):
    s = (s or "").strip()
    if not s:
        return ""
    for a, b in DAU:
        s = s.replace(a, b)
    return s

out = []
for r in rows:
    dv = r["dich_vu"]
    if dv == "booking-tv":
        nhom  = "booking-truyen-hinh"
        title = KENH.get(r["dau_bao"], r["dau_bao"].upper())
    else:
        nhom  = "backlink-quoc-te"
        title = r["dau_bao"]   # ten mien (forbes.com) hoac ten goi -> phuc hoi dau ben duoi
        title = co_dau(title)

    out.append({
        "nhom":    nhom,
        "title":   title,
        "vi_tri":  co_dau(r["vi_tri"]),
        "gia":     int(r["gia"]),
        "so_link": co_dau(r["so_link"]),
        "yeu_cau": co_dau(r["quy_cach"]),
    })

payload = {"updates": [], "new": out}
p = os.path.join(BASE, "payload-2-nhom-moi.json")
json.dump(payload, open(p, "w"), ensure_ascii=False, indent=1)

from collections import Counter
print("Tong dong moi:", len(out), dict(Counter(o["nhom"] for o in out)))
print("\n-- Mau Booking truyen hinh --")
for o in [x for x in out if x["nhom"] == "booking-truyen-hinh"][:6]:
    print(f"  {o['title']:<12}{o['vi_tri'][:40]:<42}{o['yeu_cau'][:26]:<28}{o['gia']:>13,}")
print("\n-- Mau Backlink quoc te --")
for o in [x for x in out if x["nhom"] == "backlink-quoc-te"][:6]:
    print(f"  {o['title']:<26}{o['vi_tri'][:20]:<22}{o['yeu_cau'][:30]:<32}{o['gia']:>13,}")

# Kiem tra con chuoi khong dau dang nghi ngo khong
import unicodedata
nghi = set()
for o in out:
    for f in ("title", "vi_tri", "yeu_cau", "so_link"):
        for w in re.findall(r"[A-Za-zÀ-ỹ]{4,}", o[f]):
            fold = "".join(c for c in unicodedata.normalize("NFD", w) if unicodedata.category(c) != "Mn")
            if w == fold and re.search(r"(ao|oa|uo|ie|ay|oi|ui|uy)", w.lower()) and w.lower() not in (
                "guest","post","link","niche","edit","outreach","credit","insider","business","yahoo",
                "media","news","press","wire","circuit","newsroom","online","basic","premium","standard",
                "advanced","local","national","global","premier","budget","feature","starter","growth",
                "performance","spark","gold","visibility","boost","integrated","simplepost","tier","pro",
                "authority","essential","blogger","permanent","talkshow","roundup","best","forbes","apnews"):
                nghi.add(w)
print("\nCon tu nghi mat dau:", sorted(nghi) if nghi else "khong")
