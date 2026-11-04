# Bao gia booking bao PR - me va be - chi Dieu Lien - 03/11/2026
# Nguon: Goodcom (file "Bao gia booking Combat_ 2026.xlsx"), chi lay tab con hieu luc 10 ngay:
#   tab "May khuech tan tinh dau- 31.10." (het han 10/11), tab "Y te" (27/10, het han 06/11)
# Gia ban = thanh tien Goodcom x 1,1 (lam tron nghin). Hien thi: niem yet anchor + CK 20-29%.
import math, random
from openpyxl import Workbook
from openpyxl.styles import Font, PatternFill, Alignment, Border, Side
from openpyxl.utils import get_column_letter

OUT = "/Volumes/Extreme SSD/Projects/digicom/11-bao-gia-khach/"
NAME = "Bao-Gia-Booking-Bao-Me-Va-Be-Dieu-Lien-2026-11-03.xlsx"
NOIBO = "NOIBO-" + NAME
ISSUE, EXP = "03/11/2026", "06/11/2026"

# (nhom, dau bao, vi tri, hien thi, quy cach, thanh tien NCC, tab nguon)
T31, TYT = "31.10 (het han 10/11)", "Y te 27.10 (het han 06/11)"
ROWS = [
 ("Gia đình - Phụ nữ - Mẹ và bé", "Afamily.vn", "Chuyên mục phù hợp (Mẹ & bé / Gia đình)", "Bài hiển thị trong chuyên mục phù hợp", "1.000 từ, 5 ảnh, 1 link", 3320000, T31),
 ("Gia đình - Phụ nữ - Mẹ và bé", "Eva.vn", "Bài hot tiểu mục", "Đính vào 1 trong 2 bài hot của tiểu mục trong 2 giờ; hiển thị tại box Tin tức thị trường trên trang chuyên mục và trang bài viết", "1.000 từ, 5 ảnh, 2 link", 3500000, T31),
 ("Gia đình - Phụ nữ - Mẹ và bé", "Giadinh.suckhoedoisong.vn", "Chuyên mục phù hợp", "Bài hiển thị trong chuyên mục phù hợp", "1.000 từ, 3 ảnh, 1 link", 2160000, T31),
 ("Gia đình - Phụ nữ - Mẹ và bé", "Giadinhmoi.vn", "Chuyên mục phù hợp", "Bài hiển thị trong chuyên mục phù hợp", "1.000 từ, 3 ảnh, 1 link", 1050000, T31),
 ("Sức khoẻ", "Suckhoedoisong.vn", "Chuyên mục phù hợp", "Bài hiển thị trong chuyên mục phù hợp", "1.000 từ, 3 ảnh, 1 link", 3500000, TYT),
 ("Sức khoẻ", "Alobacsi.com", "Chuyên mục phù hợp", "Bài hiển thị trong chuyên mục phù hợp", "1.000 từ, 3 ảnh, 1 link", 1700000, TYT),
 ("Sức khoẻ", "24h.com.vn", "Bài PR loại 2 - mục Sức khoẻ đời sống", "Hiển thị tại box Tin tức thị trường, trang chuyên mục 8 giờ, trang bài viết 8 giờ", "1.000 từ, 5 ảnh, 2 link", 3500000, TYT),
 ("Sức khoẻ", "Vietnamnet.vn", "Top 6 trở xuống tiểu mục Sức khoẻ", "Bài hiển thị từ top 6 trở xuống trong tiểu mục", "1.000 từ, 5 ảnh, link tĩnh", 4500000, TYT),
 ("Sức khoẻ", "Tienphong.vn", "Chuyên mục Sức khoẻ", "Bài hiển thị trong chuyên mục Sức khoẻ", "1.000 từ, 3 ảnh, 1 link .vn", 4055556, TYT),
 ("Sức khoẻ", "Vtc.vn", "Chuyên mục Sức khoẻ", "Bài hiển thị trong chuyên mục Sức khoẻ", "1.000 từ, 5 ảnh, 1 link", 3720000, TYT),
 ("Báo lớn - mục Đời sống, Tiêu dùng", "Vietnamnet.vn", "Top 6 trở xuống mục Mẹo vặt cuộc sống / Đời sống", "Bài hiển thị từ top 6 trở xuống trong tiểu mục phù hợp", "1.000 từ, 5 ảnh, link tĩnh", 4500000, T31),
 ("Báo lớn - mục Đời sống, Tiêu dùng", "24h.com.vn", "Bài PR loại 2 - mục Thị trường tiêu dùng", "Trang chuyên mục 8 giờ, trang bài viết 8 giờ", "1.000 từ, 5 ảnh, 2 link", 4320000, T31),
 ("Báo lớn - mục Đời sống, Tiêu dùng", "Tuoitre.vn", "Mục Cần biết", "Bài hiển thị trong mục Cần biết", "600-1.000 từ, 5 ảnh, link tĩnh", 5250000, T31),
 ("Báo lớn - mục Đời sống, Tiêu dùng", "Tuoitre.vn", "Box Cần biết ngoài trang chủ", "Bài hiển thị tại box Cần biết ngoài trang chủ", "1.000 từ, 5 ảnh, không link", 7600000, TYT),
 ("Báo lớn - mục Đời sống, Tiêu dùng", "Thanhnien.vn", "Mục Bạn cần biết", "Bài hiển thị trong mục Bạn cần biết", "800 từ, 3 ảnh, 2 link", 6296296, T31),
 ("Báo lớn - mục Đời sống, Tiêu dùng", "Vtv.vn", "Chuyên mục phù hợp", "Bài hiển thị trong chuyên mục phù hợp", "1.000 từ, 5 ảnh, không link", 4980000, T31),
 ("Báo lớn - mục Đời sống, Tiêu dùng", "Znews.vn", "Basic 2.2 - chuyên trang Lifestyle", "Top 3 subpage: vị trí #2 mục Mới nhất của chuyên trang Lifestyle hoặc tiểu mục phù hợp", "1.000 từ, 5 ảnh, 1 link", 7000000, TYT),
]

random.seed(20261103)
data = []
for r in ROWS:
    sell = int(math.ceil(round(r[5] * 1.1) / 1000) * 1000)
    ck = random.choice([20, 21, 22, 23, 24, 25, 26, 27, 28, 29])
    ny = int(round(sell / (1 - ck / 100) / 10000) * 10000)
    data.append(r + (sell, ck, ny))

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

# ---- file gui khach
wb = Workbook(); ws = wb.active; ws.title = "Bảng giá báo mẹ và bé"; ws.sheet_properties.tabColor = "0E8C7F"
hd = ["STT", "Đầu báo", "Vị trí đăng", "Hiển thị", "Quy cách bài", "Giá niêm yết (đ)", "Chiết khấu", "Giá ưu đãi (đ, chưa VAT)"]
r = banner(ws, len(hd), "BÁO GIÁ ĐĂNG BÀI PR TRÊN BÁO - NHÓM MẸ VÀ BÉ, GIA ĐÌNH, SỨC KHOẺ - Kính gửi: Chị Diệu Liên", "1C2035")
rows = [(d[0], i, d[1], d[2], d[3], d[4], d[9], f"{d[8]}%", d[7]) for i, d in enumerate(data, 1)]
r = table(ws, r, hd, rows, [6, 22, 30, 40, 22, 16, 11, 18], [6, 8], "0E8C7F")
notes(ws, r + 1, len(hd), NOTE)
ws2 = wb.create_sheet("Thông tin & Thanh toán"); ws2.sheet_properties.tabColor = "0E8C7F"; info_sheet(ws2, "0E8C7F")
wb.save(OUT + NAME)

# ---- file noi bo
wb = Workbook(); ws = wb.active; ws.title = "NOIBO giá vốn"; ws.sheet_properties.tabColor = "B91C1C"
hd = ["STT", "Đầu báo", "Vị trí đăng", "Hiển thị", "Quy cách", "NCC", "Tab nguồn (hiệu lực)", "Giá vốn Goodcom (thành tiền)", "Giá bán (x1,1)", "Lãi", "Niêm yết hiển thị", "CK hiển thị"]
r = banner(ws, len(hd), "NOIBO - Báo giá mẹ và bé - Chị Diệu Liên - 03/11/2026", "7F1D1D", warn="FILE NỘI BỘ - TUYỆT ĐỐI KHÔNG GỬI KHÁCH")
rows = [(d[0], i, d[1], d[2], d[3], d[4], "Goodcom (Ms Thu)", d[6], d[5], d[7], d[7] - d[5], d[9], f"{d[8]}%") for i, d in enumerate(data, 1)]
r = table(ws, r, hd, rows, [6, 20, 26, 30, 18, 14, 20, 16, 14, 12, 14, 9], [8, 9, 10, 11], "B91C1C")
notes(ws, r + 1, len(hd), ["Nguồn: Drive 'Báo giá booking Combat_ 2026.xlsx' (Goodcom), tab 31.10 + tab Y tế (27/10). Hiệu lực Goodcom 10 ngày => báo giá khách đặt hạn 06/11 (theo tab Y tế hết hạn sớm nhất).",
 "Bỏ tab 23.10 (hết hạn 02/11) và tab '2026' (không ghi ngày báo giá). Giá DanaSEO trong kho là bản 29/07 nên không dùng.",
 "Giá bán = thành tiền Goodcom x 1,1 (rule bang-gia-booking.md mục Goodcom). Trước khi chốt đơn: hỏi lại Goodcom giá còn giữ không."])
wb.save(OUT + NOIBO)
for d in data: print(d[1], d[2][:30], d[5], d[7], d[8], d[9])
