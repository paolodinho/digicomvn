# Bao gia booking bao PR - khai truong co so chinh Dailyve (chi Thuc Quyen, Zalo) - 04/11/2026
# Khach xin 2 phuong an 20tr va 10tr. Nguon Goodcom con hieu luc: tab 28.10 (het 07/11), 31.10 (het 10/11).
# Gia ban = thanh tien Goodcom x1,1 lam tron len nghin. Ngan sach tinh GOM VAT 8%.
import math, random
from openpyxl import Workbook
from openpyxl.styles import Font, PatternFill, Alignment, Border, Side
from openpyxl.utils import get_column_letter
OUT = "/Volumes/Extreme SSD/Projects/digicom/11-bao-gia-khach/"
NAME = "Bao-Gia-Booking-Bao-Khai-Truong-Dailyve-2026-11-04.xlsx"
NOIBO = "NOIBO-" + NAME
ISSUE, EXP = "04/11/2026", "07/11/2026"
T28, T31 = "28.10 (het han 07/11)", "31.10 (het han 10/11)"
# key: (nhom, dau bao, vi tri, hien thi, quy cach, gia von, tab)
B = {
 "24h": ("Báo tin tức tổng hợp", "24h.com.vn", "Bài PR loại 2 - mục Kinh doanh / Thị trường tiêu dùng", "Hiển thị tại box Tin tức thị trường trong mục và trang bài viết", "1.000 từ, 5 ảnh, 3 link", 4200000, T28),
 "vnn": ("Báo tin tức tổng hợp", "Vietnamnet.vn", "Top 6 trở xuống tiểu mục Kinh doanh", "Bài hiển thị từ top 6 trở xuống trong tiểu mục", "1.000 từ, 5 ảnh, link tĩnh", 4440000, T28),
 "tp": ("Báo tin tức tổng hợp", "Tienphong.vn", "Chuyên mục Kinh tế", "Bài hiển thị trong chuyên mục Kinh tế", "1.000 từ, 3 ảnh, 1 link .vn", 3944444, T28),
 "dddn": ("Báo kinh tế - doanh nghiệp", "Diendandoanhnghiep.vn", "Mục Doanh nghiệp - Thị trường", "Bài hiển thị trong chuyên mục Doanh nghiệp - Thị trường", "1.000 từ, 3-5 ảnh, 1 link", 2250000, T31),
 "vbiz": ("Báo kinh tế - doanh nghiệp", "Vietnambiz.vn", "Mục Góc doanh nghiệp", "Bài hiển thị trong mục Góc doanh nghiệp", "1.000 từ, 3 ảnh, link tĩnh", 2040000, T28),
 "dlvn": ("Báo du lịch", "Dulichvietnam.com.vn", "Bài PR trang chủ", "Bài hiển thị tại trang chủ và trong mục phù hợp", "1.000 từ, 4 ảnh, 2 link", 1980000, T31),
 "dlt": ("Báo du lịch", "Dulichtoday.vn", "Bài review / PR", "Bài hiển thị trong mục phù hợp", "1.000 từ, 3 ảnh, 1 link", 2550000, T31),
 "bdt": ("Báo kinh tế - doanh nghiệp", "Baodautu.vn", "Box Thông tin doanh nghiệp - trang chủ", "Bài hiển thị tại box Thông tin doanh nghiệp ngoài trang chủ", "900 từ, 2 ảnh, link tĩnh", 3150000, T31),
 "vtc": ("Báo tin tức tổng hợp", "Vtcnews.vn", "Mục Doanh nghiệp - Doanh nhân", "Bài hiển thị trong mục Doanh nghiệp - Doanh nhân", "1.000 từ, 5 ảnh, 1 link", 3250000, T31),
 "nsvne": ("Báo tin tức tổng hợp", "Ngoisao.vnexpress.net", "Top 4 trở xuống mục Thương trường", "Bài hiển thị từ top 4 trở xuống trong mục Thương trường", "1.000 từ, 3 ảnh, 1 link", 3650000, T31),
 "cbiz": ("Báo kinh tế - doanh nghiệp", "Cafebiz.vn", "Chuyên mục phù hợp", "Bài hiển thị trong mục phù hợp", "1.500 từ, 5 ảnh, 1 link", 4100000, T28),
 "cafef": ("Báo kinh tế - doanh nghiệp", "Cafef.vn", "Loại 9 - Thông cáo báo chí", "Bài trong box Thông cáo báo chí trên trang chủ 1 ngày, lưu mục phù hợp", "1.500 từ, 5 ảnh, 1 link", 4920000, T28),
 "vtv": ("Báo tin tức tổng hợp", "Vtv.vn", "Chuyên mục phù hợp", "Bài hiển thị trong chuyên mục phù hợp", "1.000 từ, 5 ảnh, không link", 4980000, T31),
 "tt": ("Báo tin tức tổng hợp", "Tuoitre.vn", "Mục Cần biết", "Bài hiển thị trong mục Cần biết", "600-1.000 từ, 5 ảnh, link tĩnh", 5250000, T31),
 "tn": ("Báo tin tức tổng hợp", "Thanhnien.vn", "Box Bạn cần biết - trang chủ", "Bài hiển thị tại box Bạn cần biết ngoài trang chủ", "800 từ, 4 ảnh, 1 link", 6296296, T28),
}
OPT20 = ["24h", "vnn", "tp", "dddn", "dlvn"]
OPT10 = ["24h", "vbiz", "dlvn"]
ALT = [k for k in B if k not in OPT20 + OPT10] + []
random.seed(20261104)
P = {}
for k, r in B.items():
    sell = int(math.ceil(round(r[5] * 1.1) / 1000) * 1000)
    ck = random.choice(range(20, 30))
    ny = int(round(sell / (1 - ck / 100) / 10000) * 10000)
    P[k] = r + (sell, ck, ny)
def tot(keys):
    s = sum(P[k][7] for k in keys); return s, round(s * 0.08), s + round(s * 0.08)
for nm, ks in (("20tr", OPT20), ("10tr", OPT10)): print(nm, tot(ks), sum(P[k][5] for k in ks))
TNR = "Times New Roman"
thin = Side(style="thin", color="D5DCE4")
BD = Border(left=thin, right=thin, top=thin, bottom=thin)
def F(**k): return Font(name=TNR, size=k.pop("size", 12), **k)

def banner(ws, ncol, title, color, warn=None):
    r = 1
    if warn:
        ws.merge_cells(start_row=r, start_column=1, end_row=r, end_column=ncol)
        c = ws.cell(r, 1, warn); c.font = F(bold=True, size=14, color="FFFFFF")
        c.fill = PatternFill("solid", fgColor="B91C1C"); c.alignment = Alignment(horizontal="center")
        ws.row_dimensions[r].height = 26; r += 1
    for txt, kw in [(title, dict(bold=True, size=14, color="FFFFFF")),
                    ("DigicomVN - Công ty TNHH Dịch vụ Truyền thông Digito Combat - Hotline 0988 769 317 - sales@digicomvn.com", dict(color="FFFFFF")),
                    (f"Ngày phát hành: {ISSUE} - Hiệu lực đến hết: {EXP} - Giá chưa gồm VAT 8%", dict(color="FFFFFF"))]:
        ws.merge_cells(start_row=r, start_column=1, end_row=r, end_column=ncol)
        c = ws.cell(r, 1, txt); c.font = F(**kw); c.fill = PatternFill("solid", fgColor=color)
        c.alignment = Alignment(horizontal="left", vertical="center", wrap_text=True)
        ws.row_dimensions[r].height = 30; r += 1
    return r + 1

def table(ws, start, headers, rows, widths, money_cols, hdr_color):
    for j, h in enumerate(headers, 1):
        c = ws.cell(start, j, h); c.font = F(bold=True, color="FFFFFF")
        c.fill = PatternFill("solid", fgColor=hdr_color); c.border = BD
        c.alignment = Alignment(horizontal="center", vertical="center", wrap_text=True)
    ws.row_dimensions[start].height = 34
    r = start + 1; group = None
    for row in rows:
        if row[0] != group:
            group = row[0]
            ws.merge_cells(start_row=r, start_column=1, end_row=r, end_column=len(headers))
            c = ws.cell(r, 1, group.upper()); c.font = F(bold=True, color="0E8C7F")
            c.fill = PatternFill("solid", fgColor="EAF6F4"); r += 1
        for j, v in enumerate(row[1:], 1):
            c = ws.cell(r, j, v); c.font = F(bold=(j in money_cols[-1:]))
            c.border = BD; c.alignment = Alignment(vertical="top", wrap_text=True)
            if j in money_cols: c.number_format = "#,##0"; c.alignment = Alignment(horizontal="right", vertical="top")
        r += 1
    for j, w in enumerate(widths, 1): ws.column_dimensions[get_column_letter(j)].width = w
    ws.freeze_panes = ws.cell(start + 1, 1)
    return r

def notes(ws, r, ncol, lines):
    for t in lines:
        ws.merge_cells(start_row=r, start_column=1, end_row=r, end_column=ncol)
        c = ws.cell(r, 1, t); c.font = F(italic=t.startswith("-")); c.alignment = Alignment(wrap_text=True, vertical="top")
        ws.row_dimensions[r].height = 32; r += 1
    return r

NOTE = ["Ghi chú:",
 "- Giá tính theo bài, chưa gồm VAT 8% và phí biên tập lại của toà soạn (nếu có). Toà soạn có thể biên tập lại bài theo quy định của báo.",
 "- Bài sức khoẻ/sản phẩm cho mẹ và bé cần nội dung đúng quy định quảng cáo; toà soạn có thể yêu cầu giấy tờ sản phẩm trước khi duyệt.",
 "- Hỗ trợ tư vấn chọn báo, chọn chuyên mục miễn phí. Viết bài theo yêu cầu: báo giá riêng.",
 "- Phụ phí phóng viên đến tận nơi (nếu cần): 1.000.000 đ/buổi."]

def info_sheet(ws, color):
    ws.column_dimensions["A"].width = 26; ws.column_dimensions["B"].width = 78
    items = [("1. Thông tin bên bán", None),
     ("Tên công ty", "CÔNG TY TNHH DỊCH VỤ TRUYỀN THÔNG DIGITO COMBAT"), ("Mã số thuế", "0109816406"),
     ("Địa chỉ giao dịch", "Số nhà 200, Đường 3.1, Khu đô thị Gamuda Garden, Phường Hoàng Mai, TP. Hà Nội"),
     ("Hotline", "0988 769 317"), ("Email", "sales@digicomvn.com"), ("Website", "digicomvn.com"),
     ("2. Thông tin thanh toán", None), ("Số tài khoản", "567898838"), ("Ngân hàng", "Ngân hàng TMCP Quân đội (MB Bank)"),
     ("Chủ tài khoản", "CONG TY TNHH DVTT DIGITO COMBAT"),
     ("Nội dung chuyển khoản", "[Số báo giá/mã đơn] + [Họ tên người chuyển]"),
     ("Hình thức thanh toán", "Thanh toán 100% giá trị đơn hàng trước khi triển khai đăng bài. Đơn giá trị lớn có thể đặt cọc 50% - liên hệ để thống nhất trước khi đặt."),
     ("3. Hiệu lực báo giá", None), ("Ngày phát hành", ISSUE), ("Hiệu lực đến hết", EXP),
     ("Lưu ý", "Sau thời hạn trên, giá có thể thay đổi theo chính sách của toà soạn - vui lòng liên hệ để xác nhận lại giá trước khi đặt.")]
    for i, (a, b) in enumerate(items, 1):
        ca = ws.cell(i, 1, a)
        if b is None:
            ws.merge_cells(start_row=i, start_column=1, end_row=i, end_column=2)
            ca.font = F(bold=True, color="FFFFFF"); ca.fill = PatternFill("solid", fgColor=color)
        else:
            ca.font = F(bold=True); cb = ws.cell(i, 2, b); cb.font = F()
            cb.alignment = Alignment(wrap_text=True, vertical="top")


def total_rows(ws, r, ncol, money_col, keys):
    s, v, t = tot(keys)
    for lab, val, bold in (("Tạm tính (chưa VAT)", s, False), ("VAT 8%", v, False), ("TỔNG CỘNG (đã gồm VAT)", t, True)):
        ws.merge_cells(start_row=r, start_column=1, end_row=r, end_column=money_col - 1)
        a = ws.cell(r, 1, lab); a.font = F(bold=True); a.alignment = Alignment(horizontal="right")
        c = ws.cell(r, money_col, val); c.number_format = "#,##0"; c.font = F(bold=bold, color="0E8C7F" if bold else "000000")
        c.border = BD; r += 1
    return r

NOTE = ["Ghi chú:",
 "- Hai phương án đã tính vừa ngân sách gồm cả VAT 8%. Có thể đổi bất kỳ báo nào trong phương án sang báo ở sheet \"Báo có thể thay thế\", tổng tiền tính lại theo giá từng báo.",
 "- Giá tính theo bài, chưa gồm phí biên tập lại của toà soạn (nếu có). Toà soạn có thể biên tập bài theo quy định của báo.",
 "- Lịch đăng: bài lên trong ngày 14/11 hoặc ngay sau sự kiện khai trương; cần gửi bài + ảnh trước ít nhất 2 ngày làm việc để toà soạn duyệt. Đặt trước ngày hết hiệu lực báo giá để giữ giá.",
 "- Viết bài PR khai trương: báo giá riêng theo số bài. Phụ phí phóng viên đến tận nơi đưa tin sự kiện (nếu cần): 1.000.000 đ/buổi."]

HD = ["STT", "Đầu báo", "Vị trí đăng", "Hiển thị", "Quy cách bài", "Giá niêm yết (đ)", "Chiết khấu", "Giá ưu đãi (đ, chưa VAT)"]
W = [6, 22, 30, 40, 22, 16, 11, 18]
wb = Workbook(); first = True
for title, keys, head in (("Phương án 20 triệu", OPT20, "PHƯƠNG ÁN 1 - NGÂN SÁCH 20 TRIỆU (5 BÁO)"),
                          ("Phương án 10 triệu", OPT10, "PHƯƠNG ÁN 2 - NGÂN SÁCH 10 TRIỆU (3 BÁO)"),
                          ("Báo có thể thay thế", ALT, "CÁC BÁO KHÁC PHÙ HỢP - CÓ THỂ THAY THẾ HOẶC ĐẶT THÊM")):
    ws = wb.active if first else wb.create_sheet(); first = False
    ws.title = title; ws.sheet_properties.tabColor = "0E8C7F"
    r = banner(ws, len(HD), "BÁO GIÁ ĐĂNG BÀI PR KHAI TRƯƠNG CƠ SỞ CHÍNH DAILYVE - " + head + " - Kính gửi: Chị Thục Quyên", "1C2035")
    rows = sorted([(P[k][0], 0, P[k][1], P[k][2], P[k][3], P[k][4], P[k][9], f"{P[k][8]}%", P[k][7]) for k in keys], key=lambda x: x[0])
    rows = [(x[0], i) + x[2:] for i, x in enumerate(rows, 1)]
    r = table(ws, r, HD, rows, W, [6, 8], "0E8C7F")
    if title != "Báo có thể thay thế": r = total_rows(ws, r, len(HD), 8, keys)
    notes(ws, r + 1, len(HD), NOTE)
ws2 = wb.create_sheet("Thông tin & Thanh toán"); ws2.sheet_properties.tabColor = "0E8C7F"; info_sheet(ws2, "0E8C7F")
wb.save(OUT + NAME)

wb = Workbook(); ws = wb.active; ws.title = "NOIBO giá vốn"; ws.sheet_properties.tabColor = "B91C1C"
hd = ["STT", "Đầu báo", "Vị trí đăng", "Phương án", "Quy cách", "NCC", "Tab nguồn (hiệu lực)", "Giá vốn Goodcom", "Giá bán (x1,1)", "Lãi", "Niêm yết hiển thị", "CK hiển thị"]
r = banner(ws, len(hd), "NOIBO - Báo giá khai trương Dailyve - Chị Thục Quyên - 04/11/2026", "7F1D1D", warn="FILE NỘI BỘ - TUYỆT ĐỐI KHÔNG GỬI KHÁCH")
def pa(k): return "PA 20tr + PA 10tr" if k in OPT20 and k in OPT10 else "PA 20tr" if k in OPT20 else "PA 10tr" if k in OPT10 else "Thay thế"
rows = [(P[k][0], i, P[k][1], P[k][2], pa(k), P[k][4], "Goodcom (Ms Thu)", P[k][6], P[k][5], P[k][7], P[k][7] - P[k][5], P[k][9], f"{P[k][8]}%") for i, k in enumerate(B, 1)]
r = table(ws, r, hd, rows, [6, 20, 26, 14, 18, 14, 18, 14, 14, 12, 14, 9], [8, 9, 10, 11], "B91C1C")
s20, s10 = tot(OPT20), tot(OPT10)
c20 = sum(P[k][5] for k in OPT20); c10 = sum(P[k][5] for k in OPT10)
notes(ws, r + 1, len(hd), [
 f"PA 20tr: vốn {c20:,.0f} - bán {s20[0]:,.0f} chưa VAT ({s20[2]:,.0f} gồm VAT) - lãi {s20[0]-c20:,.0f}.",
 f"PA 10tr: vốn {c10:,.0f} - bán {s10[0]:,.0f} chưa VAT ({s10[2]:,.0f} gồm VAT) - lãi {s10[0]-c10:,.0f}.",
 "Nguồn: Drive 'Báo giá booking Combat_ 2026.xlsx' (Goodcom), tab 28.10 (hết hạn 07/11) + tab 31.10 (hết hạn 10/11). Mỗi báo lấy tab rẻ hơn. Báo giá khách hạn 07/11 theo tab hết hạn sớm nhất.",
 "Sự kiện 14/11 sau hạn NCC: khách chốt thì hỏi lại Goodcom giữ giá + lịch 14/11 trước khi nhận tiền."])
wb.save(OUT + NOIBO)
