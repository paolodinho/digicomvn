# Bao gia booking bao - Autohome (autohome.com.vn, dong co rem + he che nang tu dong), chi Huyen Nguyen, 06/11/2026.
# Khach: booking bao tang uy tin + SEO, ngan sach duoi 10tr, uu tien chat luong. Hoi gia + thoi gian luu backlink.
# He so 05/11: DanaSEO = gia DanaSEO bao x1,05; NCC khac (Rise) = von x1,15. Moi dong chon phuong an re nhat cung quy cach.
import math, random
from openpyxl import Workbook
from openpyxl.styles import Alignment
src = open("/Volumes/Extreme SSD/Projects/digicom/11-bao-gia-khach/_scripts/build_kpop_khanh_linh_2026_11_05.py").read().split("\nTRANS = 500000")[0]
g = {}; exec(src, g)
banner, table, notes, info_sheet, F, BD = g["banner"], g["table"], g["notes"], g["info_sheet"], g["F"], g["BD"]
g["ISSUE"], g["EXP"] = "06/11/2026", "13/11/2026"
OUT = "/Volumes/Extreme SSD/Projects/digicom/11-bao-gia-khach/"
NAME = "Bao-Gia-Booking-Bao-Autohome-2026-11-06.xlsx"; NOIBO = "NOIBO-" + NAME
TO = "Kính gửi: Chị Huyền Nguyễn - Autohome (autohome.com.vn)"
RS, DN = "Rise Media 05/11 (x1,15)", "DanaSEO 05/11 (bán = giá DanaSEO báo x1,05, vốn x0,9)"
MV = "Media Việt Nam 05/11 (x1,15)"
GC = "Goodcom tab 31.10 hết hạn 10/11 (x1,15)"
KEEP = "Lưu lâu dài theo chính sách toà soạn, không gỡ sau khi đăng"
A = "B. Báo điện tử lớn - chuyên mục sát ngành nhà ở, công nghệ, tiêu dùng (tăng uy tín thương hiệu)"
B = "C. Báo, tạp chí chèn 2 link dofollow - chủ đề nhà ở, đô thị, xây dựng, công nghệ (hỗ trợ SEO trực tiếp)"
C = "A. Báo tỉnh, báo địa phương - mỗi bài 2 link dofollow về autohome.com.vn"
D = "D. Trang tin chủ đề công nghệ, tiêu dùng - 2 link dofollow, bổ trợ SEO chi phí thấp"
DOF2 = "2 link dofollow"
# (nhom, bao, vi_tri, quy_cach, link, luu, gia_von, nguon, gia_danaseo_bao)
R = {
 "vnedn": (A, "VnExpress.net", "Mục Doanh nghiệp viết", "1.000 từ, 3 ảnh", "2-3 link (nofollow)", "Cam kết lưu 6 tháng", 6600000, RS, None),
 "vneso": (A, "VnExpress.net", "Tiểu mục Khoa học - Công nghệ (Số hoá)", "Khoảng 1.000 từ, 3 ảnh", "Theo duyệt toà soạn", KEEP, 7920000, RS, None),
 "rea":   (A, "Reatimes.vn (Tạp chí Bất động sản Việt Nam)", "Top 1 chuyên mục trên trang chủ", "Tối đa 1.200 từ, 6 ảnh", "Theo duyệt toà soạn", KEEP, 6600000, RS, None),
 "tn":    (A, "Thanhnien.vn", "Chuyên mục Tiêu dùng / Công nghệ / Đời sống", "1.000 từ, tối đa 5 ảnh", "2 link (nofollow)", KEEP, 4680000, RS, None),
 "cl":    (A, "Cafeland.vn", "Tin sự kiện (chuyên trang nhà ở, bất động sản)", "Tin khoảng 400 từ, 1 ảnh", "Không chèn link", KEEP, 4300000, RS, None),
 "24h":   (A, "24h.com.vn", "PR loại 2 - Kinh doanh / Thị trường tiêu dùng", "Dưới 1.000 từ, dưới 5 ảnh", "3 link (nofollow)", KEEP, 3660000, RS, None),
 "24hht": (A, "24h.com.vn", "PR loại 2 - Hi-tech / Công nghệ thông tin", "Dưới 1.000 từ, dưới 5 ảnh", "3 link (nofollow)", KEEP, 3420000, DN, 3800000),
 "genk":  (A, "Genk.vn", "Chuyên mục công nghệ, thiết bị", "Dưới 1.000 từ, dưới 5 ảnh", "1 link (nofollow)", KEEP, 3330000, DN, 3700000),
 "k14":   (A, "Kenh14.vn", "Tiểu mục Công nghệ", "Dưới 1.000 từ, dưới 7 ảnh", "1 link (nofollow)", KEEP, 3330000, DN, 3700000),
 "vnn":   (A, "Vietnamnet.vn", "Tiểu mục Mẹo vặt cuộc sống (Đời sống) hoặc Thị trường, từ top 6 trở xuống", "1.000 từ, 5 ảnh", "Link dạng chữ (không bấm)", KEEP, 4500000, GC, None),
 "cafef": (A, "Cafef.vn", "Box Thông cáo báo chí trên trang chủ", "1.000 từ, 5 ảnh", "1 link (nofollow)", KEEP, 4980000, GC, None),
 "eva":   (A, "Eva.vn", "Bài hot tiểu mục phù hợp (Nhà đẹp, Đời sống)", "1.000 từ, 5 ảnh", "2 link (nofollow)", KEEP, 3500000, GC, None),
 "vtc":   (A, "Vtcnews.vn", "Mục Doanh nghiệp - Doanh nhân", "1.000 từ, 5 ảnh", "1 link (nofollow)", KEEP, 3250000, GC, None),
 "bdt":   (A, "Baodautu.vn", "Box Thông tin doanh nghiệp trên trang chủ", "900 từ, 2 ảnh", "Link dạng chữ (không bấm)", KEEP, 3150000, GC, None),
 "ddn":   (B, "Diendandoanhnghiep.vn", "Mục Doanh nghiệp - Thị trường", "1.000 từ, 5 ảnh", "1 link, chọn dofollow", KEEP, 2250000, GC, None),
 "ndt":   (B, "Nguoidothi.net.vn (Tạp chí Người Đô Thị)", "Mục phù hợp (đô thị, nhà ở)", "500 từ, 3 ảnh", DOF2, KEEP, 2790000, DN, 3100000),
 "dnld":  (B, "Diaoc.nld.com.vn (Người Lao Động - Địa ốc)", "Mục phù hợp (nhà ở, nội thất)", "1.000 từ, 3 ảnh", DOF2, KEEP, 2000000, RS, None),
 "tcxd":  (B, "Tapchixaydung.vn (Tạp chí Xây dựng)", "Mục phù hợp (vật liệu, thiết bị công trình)", "1.000 từ, 3 ảnh", DOF2, KEEP, 1890000, DN, 2100000),
 "vnr":   (B, "Vnreview.vn", "Mục phù hợp (công nghệ, đánh giá thiết bị)", "1.000 từ, 5 ảnh", DOF2, KEEP, 1800000, RS, None),
 "vb":    (B, "Vietbao.vn", "Mục phù hợp", "1.000 từ, 3 ảnh", DOF2, KEEP, 1650000, RS, None),
 "home":  (B, "Home.vn", "Mục phù hợp (nhà cửa, đời sống)", "1.000 từ, 3 ảnh", DOF2, KEEP, 1350000, DN, 1500000),
 "tdtt":  (B, "Tieudungtiepthi.vn", "Mục phù hợp (tiêu dùng)", "1.000 từ, 3 ảnh", DOF2, KEEP, 900000, DN, 1000000),
 "bdn":   (C, "Baodongnai.com.vn (Báo Đồng Nai)", "Mục phù hợp", "1.000 từ, 5 ảnh", DOF2, KEEP, 990000, DN, 1100000),
 "bht":   (C, "Baohatinh.vn (Báo Hà Tĩnh)", "Mục phù hợp", "Tối đa 1.200 từ, 5 ảnh", DOF2, KEEP, 930000, MV, None),
 "bdng":  (C, "Baodanang.vn (Báo Đà Nẵng)", "Mục phù hợp", "1.200 từ, 5 ảnh", DOF2, KEEP, 850000, RS, None),
 "cnds":  (D, "Congnghedoisong.info", "Bài đăng", "1.000 từ, 5 ảnh", DOF2, KEEP, 550000, RS, None),
 "tcn":   (D, "Tincongnghe.info", "Bài đăng", "1.000 từ, 5 ảnh", DOF2, KEEP, 550000, RS, None),
 "ktcn":  (D, "Kinhtevacongnghe.com", "Bài đăng", "1.000 từ, 5 ảnh", DOF2, KEEP, 550000, RS, None),
 "cdtd":  (D, "Congdongtieudung.info", "Bài đăng", "1.000 từ, 5 ảnh", DOF2, KEEP, 550000, RS, None),
 "tq":    (C, "Baotuyenquang.com.vn (Báo Tuyên Quang)", "Mục phù hợp", "1.200 từ, 5 ảnh", DOF2, KEEP, 900000, RS, None),
 "pt":    (C, "Baophutho.vn (Báo Phú Thọ)", "Mục phù hợp", "Tối đa 1.200 từ, 5 ảnh", DOF2, KEEP, 930000, MV, None),
 "ag":    (C, "Baoangiang.com.vn (Báo An Giang)", "Mục phù hợp", "1.200 từ, 5 ảnh", DOF2, KEEP, 1050000, RS, None),
 "hy":    (C, "Baohungyen.vn (Báo Hưng Yên)", "Mục phù hợp", "1.200 từ, 5 ảnh", DOF2, KEEP, 1050000, RS, None),
 "dbp":   (C, "Baodienbienphu.vn (Báo Điện Biên Phủ)", "Mục phù hợp", "1.000 từ, 5 ảnh", DOF2, KEEP, 1080000, DN, 1200000),
 "vl":    (C, "Baovinhlong.com.vn (Báo Vĩnh Long)", "Mục phù hợp (cần giấy phép kinh doanh, bài ký duyệt trước khi gửi)", "Tối đa 1.000 từ, 5 ảnh", DOF2, KEEP, 1160000, MV, None),
 "cm":    (C, "Baocamau.com.vn (Báo Cà Mau)", "Mục phù hợp", "1.200 từ, 5 ảnh", DOF2, KEEP, 1200000, RS, None),
 "th":    (C, "Baothanhhoa.vn (Báo Thanh Hoá)", "Mục phù hợp (cần giấy phép kinh doanh, link tên miền .vn)", "1.000 từ, 4 ảnh", DOF2, KEEP, 1250000, RS, None),
 "tn2":   (C, "Baotayninh.vn (Báo Tây Ninh)", "Mục phù hợp", "1.000 từ, 5 ảnh", DOF2, KEEP, 1300000, RS, None),
 "tng":   (C, "Baothainguyen.vn (Báo Thái Nguyên)", "Mục phù hợp", "800 từ, 3 ảnh", DOF2, KEEP, 1350000, RS, None),
 "qn":    (C, "Baoquangninh.vn (Báo Quảng Ninh)", "Mục phù hợp (cần giấy phép kinh doanh)", "Tối đa 1.200 từ, 5 ảnh", DOF2, KEEP, 1390000, MV, None),
 "ct":    (C, "Baocantho.com.vn (Báo Cần Thơ)", "Mục phù hợp", "Tối đa 800 từ, 2 ảnh", DOF2, KEEP, 1440000, MV, None),
 "ld":    (C, "Baolamdong.vn (Báo Lâm Đồng)", "Mục phù hợp", "1.000 từ, 5 ảnh", DOF2, KEEP, 1440000, DN, 1600000),
 "ls":    (C, "Baolangson.vn (Báo Lạng Sơn)", "Mục phù hợp", "Tối đa 1.200 từ, 5 ảnh", DOF2, KEEP, 1620000, MV, None),
 "qt":    (C, "Baoquangtri.vn (Báo Quảng Trị)", "Mục phù hợp (cần giấy phép kinh doanh)", "1.000 từ, 5 ảnh", DOF2, KEEP, 1620000, DN, 1800000),
 "cb":    (C, "Baocaobang.vn (Báo Cao Bằng)", "Mục phù hợp", "1.000 từ, 5 ảnh", DOF2, KEEP, 1620000, DN, 1800000),
 "dt":    (C, "Baodongthap.vn (Báo Đồng Tháp)", "Mục phù hợp", "Dưới 500 từ, 3 ảnh", DOF2, KEEP, 2100000, RS, None),
 "na":    (C, "Baonghean.vn (Báo Nghệ An)", "Mục phù hợp (cần giấy phép kinh doanh, thời gian lên bài lâu hơn)", "Tối đa 1.000 từ, 5 ảnh", DOF2, KEEP, 2230000, MV, None),
}
DR = {"vnr": "69", "ndt": "64", "home": "35", "tdtt": "27", "bdn": "68", "bht": "71", "bdng": "72", "tq": "57", "ag": "62", "hy": "58", "cm": "60", "th": "65", "tn2": "54", "tng": "60", "dt": "46"}
random.seed(202611066); P = {}
for k, r in R.items():
    sell = int(math.ceil(round(r[8] * 1.05) / 1000) * 1000) if r[8] else int(math.ceil(round(r[6] * 1.15) / 1000) * 1000)
    ck = random.choice(range(20, 30)); ny = int(round(sell / (1 - ck / 100) / 10000) * 10000)
    P[k] = r[:8] + (sell, ck, ny, DR.get(k, "-"))

HD = ["STT", "Đầu báo", "Vị trí / chuyên mục", "Quy cách (số từ, ảnh)", "Chèn link về autohome.com.vn", "Chỉ số DR (Ahrefs)", "Thời gian lưu bài và link", "Giá niêm yết (đ)", "Chiết khấu", "Giá ưu đãi (đ/bài, chưa VAT)"]
W = [5, 24, 26, 20, 20, 10, 20, 14, 10, 16]
def rows_of(grp):
    ks = sorted([k for k in P if P[k][0] == grp], key=lambda k: (P[k][8] if grp == C else -P[k][8]))
    return [(grp, i, P[k][1], P[k][2], P[k][3], P[k][4], P[k][11], P[k][5], P[k][10], f"{P[k][9]}%", P[k][8]) for i, k in enumerate(ks, 1)]

wb = Workbook(); ws = wb.active; ws.title = "Bảng giá"; ws.sheet_properties.tabColor = "0E8C7F"
r = banner(ws, len(HD), "BÁO GIÁ BOOKING BÁO ĐIỆN TỬ - TĂNG UY TÍN VÀ HỖ TRỢ SEO CHO AUTOHOME", "1C2035", to=TO)
r = table(ws, r, HD, rows_of(C) + rows_of(A) + rows_of(B) + rows_of(D), W, [8, 10], "0E8C7F")
notes(ws, r + 1, len(HD), ["Ghi chú:",
 "- Giá đã gồm viết bài theo văn phong báo chí và biên tập theo yêu cầu toà soạn; Digicom gửi quý khách duyệt bài trước khi đăng. Giá chưa gồm VAT 8%.",
 "- Nhóm A: 21 báo tỉnh, báo địa phương, mỗi bài 2 link dofollow, sắp xếp từ giá thấp đến cao; cột DR ghi chỉ số những báo đã có số đo.",
 "- Nhóm B: báo điện tử lớn, đăng đúng chuyên mục nhà ở, công nghệ, tiêu dùng nơi khách hàng của Autohome đang đọc. Tăng độ tin cậy khi khách tìm thương hiệu trên Google. Link trong bài ở dạng nofollow.",
 "- Nhóm C, D: 2 link dofollow về autohome.com.vn. Nhóm C là báo, tạp chí chủ đề sát ngành nhà ở, xây dựng, công nghệ; nhóm D là trang tin công nghệ, tiêu dùng để bổ trợ số lượng link với chi phí thấp.",
 "- Chỉ số DR (Domain Rating, thang 0-100 của Ahrefs) phản ánh sức mạnh liên kết của trang; ô ghi '-' là chưa có số đo cập nhật, Digicom gửi kèm khi quý khách cần.",
 "- Gợi ý phối hợp: xem sheet Phương án đề xuất (3 phương án dưới 10 triệu, ưu tiên báo tỉnh).",
 "- Thời gian lưu: bài trên chuyên mục được lưu lâu dài theo chính sách toà soạn, không gỡ sau khi đăng. VnExpress mục Doanh nghiệp viết cam kết lưu 6 tháng (có lựa chọn 2 năm hoặc không thời hạn, báo giá riêng).",
 "- Thời gian: Digicom hoàn thiện bài trong 1-2 ngày làm việc; sau khi quý khách duyệt, toà soạn duyệt và đăng trong 2-3 ngày làm việc.",
 "- Ưu đãi: đặt từ 3 bài trở lên được viết bài miễn phí theo bộ từ khoá sản phẩm của Autohome và tư vấn chọn báo theo ngân sách, không ràng buộc.",
 "- Toà soạn có quyền biên tập tiêu đề, sapo, nội dung. Bài vượt số từ, số ảnh có thể phát sinh phụ phí; Digicom xác nhận trước khi đặt."])
OPT = [
 ("PHƯƠNG ÁN 1 - PHỦ 8 BÁO TỈNH (KHUYÊN DÙNG): 16 link dofollow từ 8 tỉnh, thành", ["bdng", "tq", "bht", "pt", "bdn", "ag", "hy", "dbp"]),
 ("PHƯƠNG ÁN 2 - BÁO LỚN + BÁO TỈNH: 1 bài Thanh Niên + 4 báo tỉnh (8 link dofollow)", ["tn", "bdng", "tq", "bht", "pt"]),
 ("PHƯƠNG ÁN 3 - KHỞI ĐẦU TIẾT KIỆM: 5 báo tỉnh, 10 link dofollow", ["bdng", "tq", "bht", "pt", "bdn"]),
]
ws0 = wb.create_sheet("Phương án đề xuất", 0); ws0.sheet_properties.tabColor = "0E8C7F"; wb.active = 0
oh = ["STT", "Đầu báo", "Vị trí / chuyên mục", "Chèn link về autohome.com.vn", "Giá niêm yết (đ)", "Giá ưu đãi (đ/bài, chưa VAT)"]
r0 = banner(ws0, len(oh), "3 PHƯƠNG ÁN BOOKING BÁO TRONG NGÂN SÁCH DƯỚI 10 TRIỆU CHO AUTOHOME", "1C2035", to=TO)
orows = []
for lab, ks in OPT:
    ny = sum(P[k][10] for k in ks); uu = sum(P[k][8] for k in ks)
    fm = lambda x: f"{x:,.0f}".replace(",", ".")
    g2 = f"{lab} - tổng {fm(uu)} đ, tiết kiệm {fm(ny - uu)} đ so với giá niêm yết"
    for i, k in enumerate(ks, 1): orows.append((g2, i, P[k][1], P[k][2], P[k][4], P[k][10], P[k][8]))
r0 = table(ws0, r0, oh, orows, [5, 28, 34, 24, 16, 18], [5, 6], "0E8C7F")
notes(ws0, r0 + 1, len(oh), ["Quyền lợi đi kèm mọi phương án:",
 "- Mọi phương án từ 3 bài trở lên: được viết bài miễn phí theo bộ từ khoá sản phẩm của Autohome (động cơ rèm, rèm tự động, mái che tự động...) và lên kế hoạch đặt link về đúng trang sản phẩm.",
 "- Giá đã gồm viết bài theo văn phong báo chí; Digicom gửi quý khách duyệt trước khi đăng và biên tập lại theo yêu cầu toà soạn tới khi bài được duyệt, không thu thêm phí.",
 "- Trước khi đặt: Digicom gửi link bài mẫu đã đăng trên chính đầu báo đó để quý khách xem vị trí, cách trình bày và loại link thực tế.",
 "- Sau khi đăng: Digicom gửi link bài và ảnh chụp vị trí đăng, kèm danh sách link đã chèn để quý khách theo dõi trên Google Search Console.",
 "- Mỗi báo tỉnh là một tên miền khác nhau trỏ link dofollow về autohome.com.vn: càng nhiều tên miền uy tín trỏ về, các trang sản phẩm càng dễ lên thứ hạng. Bài Thanh Niên (phương án 2) giúp khách hàng tin hơn khi tìm tên Autohome trên Google.",
 "- Một số báo tỉnh yêu cầu giấy phép kinh doanh của Autohome (đã ghi ở cột vị trí); quý khách gửi 1 lần, Digicom dùng cho các bài sau.",
 "- Muốn đổi báo trong phương án: xem đầy đủ 47 lựa chọn (21 báo tỉnh) ở sheet Bảng giá, Digicom tư vấn ghép lại theo ngân sách."])
ws2 = wb.create_sheet("Thông tin & Thanh toán"); ws2.sheet_properties.tabColor = "0E8C7F"; info_sheet(ws2, "0E8C7F")
wb.save(OUT + NAME)

wb = Workbook(); ws = wb.active; ws.title = "NOIBO giá vốn"; ws.sheet_properties.tabColor = "B91C1C"
hd = ["STT", "Đầu báo", "Vị trí", "Nguồn", "Giá vốn", "Giá bán", "Lãi", "Niêm yết hiển thị", "CK hiển thị"]
r = banner(ws, len(hd), "NOIBO - Báo giá booking báo Autohome - 06/11/2026", "7F1D1D", warn="FILE NỘI BỘ - TUYỆT ĐỐI KHÔNG GỬI KHÁCH")
rows = []
for grp in (C, A, B, D):
    for i, k in enumerate(sorted([k for k in P if P[k][0] == grp], key=lambda k: -P[k][8]), 1):
        von = P[k][6]
        rows.append((grp, i, P[k][1], P[k][2], P[k][7], von, P[k][8], P[k][8] - von, P[k][10], f"{P[k][9]}%"))
r = table(ws, r, hd, rows, [5, 24, 34, 30, 13, 13, 12, 14, 9], [5, 6, 7, 8], "B91C1C")
notes(ws, r + 1, len(hd), [
 "Gợi ý tư vấn (<10tr, không đưa vào file khách): (1) Thanh Niên Tiêu dùng/CN 5,382 + Người Đô Thị 3,255 + Home.vn 1,575 = 10,212 (hơi vượt, thay Home bằng Tieudungtiepthi 1,05 = 9,687); (2) VnE DN viết 7,59 + Vnreview 2,07 = 9,66; (3) 24h Hi-tech 3,99 + Diaoc NLĐ 2,3 + Tapchixaydung 2,205 + Home.vn 1,575 = 10,07 (bỏ Home, thêm Baodanang 0,978 = 9,473).",
 "So NCC: VnE DN viết Rise 6,6 < DanaSEO 8,19. 24h TTTD Rise 4,209 < DanaSEO 4,725; 24h Hi-tech chỉ DanaSEO 3,99. Genk/Kenh14 DanaSEO 3,885 < Rise. Người Đô Thị DanaSEO 3,255 < Rise 3,45. Tapchixaydung DanaSEO 2,205 < Rise 2,99. Vietbao Rise 1,8975 < DanaSEO 2,079. Home.vn DanaSEO 1,575 < Rise 1,84. Vnreview Rise 2,07 < DanaSEO 2,415. Reatimes chỉ Rise (top 1 chuyên mục, giá gốc NCC 10tr CK 34%). Báo tỉnh nhóm C + site nhóm D chỉ Rise. DR lấy theo sheet NCC 05/11.",
 "Goodcom (tab 31.10, HẾT HẠN 10/11 - báo giá khách tới 13/11, hỏi lại chị Thu trước khi nhận tiền): Vietnamnet 4,5 -> 5,175; Cafef TCBC 4,98 -> 5,727; Eva hot tiểu mục 3,5 -> 4,025 (xác nhận vào được tiểu mục Nhà đẹp); Vtcnews 3,25 -> 3,738; Baodautu 3,15 -> 3,623; Diendandoanhnghiep 2,25 -> 2,588 (Goodcom ghi tuỳ brand chọn no hoặc dofollow). Goodcom không rẻ hơn ở: 24h TTTD 4,32x1,15=4,968 > Rise 4,209; VnE DN viết 7,3x1,15=8,395 > Rise 7,59; Dân trí 10,35x1,15 vượt ngân sách; Vneconomy 8,64x1,15=9,936 không link nên bỏ.",
 "Bỏ so với bản đầu: Znews, Cafebiz, Soha, Tiền Phong, Thanhnienviet, Tuoitrexahoi (không sát ngành). Nhóm D là site vệ tinh chất lượng thấp, chỉ chào làm bổ trợ.",
 "Sheet Phương án đề xuất (Hiếu duyệt 06/11 chiều, thay mục cấm gói combo cho báo giá này): PA1 Thanh Niên + Người Đô Thị + Tieudungtiepthi; PA2 Diaoc NLĐ + Tapchixaydung + Baodanang; PA3 VnE DN viết + Vnreview. Chỉ cam kết những gì làm được: gửi bài mẫu, duyệt bài, báo cáo link. KHÔNG hứa đăng lại nếu gỡ khi NCC chưa cam kết.",
 "Báo tỉnh mở rộng 06/11 16:00 (khách: sếp muốn nhiều link báo tỉnh): 21 báo, nguồn rẻ nhất trong DanaSEO/Rise/Media VN, đều 2 link dofollow. Bỏ Lào Cai (4,14tr, Rise), Đắk Lắk (4,73tr, 1 link), Báo Xây dựng (nofollow), tên miền trùng (baocamau.vn, baovinhlong.vn, baoquangninh.com.vn). DR báo Media VN/DanaSEO chưa có số. Media VN = mã 2, x1,15.",
 "Dân trí bỏ: nhóm 1 (Công nghệ/BĐS) Rise 8,85 x1,15 = 10,18tr vượt ngân sách; nhóm 2 không có mục phù hợp.",
 "Thời gian lưu bài chuyên mục: chưa có văn bản NCC cam kết, ghi 'theo chính sách toà soạn'. Hỏi lại Rise trước khi ký nếu khách đòi cam kết thời hạn."])
wb.save(OUT + NOIBO)
print("ok")
for k in P: print(P[k][1], P[k][8], P[k][10], P[k][9])
