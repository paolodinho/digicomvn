# Bao gia booking bao PR - khach resort (Zalo, 04/11/2026): 3 bai 1.200 chu, 1 bao pho thong (VnExpress/Tuoi Tre/Thanh Nien),
# 1 bao lifestyle, 1 bao gioi tre/Gen Z, khong can link, dang tuan sau.
# Nguon Goodcom file "Bao gia booking Combat_ 2026.xlsx". Gia ban = thanh tien x1,1 lam tron len nghin.
import math, random
from openpyxl import Workbook
from openpyxl.styles import Font, PatternFill, Alignment, Border, Side
from openpyxl.utils import get_column_letter
OUT = "/Volumes/Extreme SSD/Projects/digicom/11-bao-gia-khach/"
NAME = "Bao-Gia-Booking-Bao-PR-Resort-2026-11-04.xlsx"
NOIBO = "NOIBO-" + NAME
ISSUE, EXP = "04/11/2026", "07/11/2026"
T28, T31, TYT, T26 = "28.10 (het han 07/11)", "31.10 (het han 10/11)", "Y te 27.10 (het han 06/11)", "'2026' (KHONG ghi ngay - phai hoi lai)"
G1, G2, G3 = "Nhóm 1 - Báo phổ thông", "Nhóm 2 - Báo lifestyle, du lịch", "Nhóm 3 - Báo giới trẻ, Gen Z"
B = {
 "vne": (G1, "Vnexpress.net", "Tiểu mục Doanh nghiệp viết - duy trì 6 tháng", "Bài trong tiểu mục Doanh nghiệp viết, đồng thời lên box Thông tin doanh nghiệp tại trang chủ (lùi dần khi có bài mới)", "1.000 từ, 3 ảnh", 7300000, T28),
 "tt": (G1, "Tuoitre.vn", "Mục Cần biết", "Bài hiển thị trong mục Cần biết", "600-1.000 từ, 5 ảnh", 5250000, T31),
 "tn": (G1, "Thanhnien.vn", "Mục Bạn cần biết", "Bài hiển thị trong mục Bạn cần biết", "800 từ, 3 ảnh", 6296296, T31),
 "zn": (G2, "Znews.vn", "Chuyên trang Lifestyle (gói Basic 2.2)", "Top 3 trang con Lifestyle: vị trí #2 mục Mới nhất của chuyên trang", "1.000 từ, 5 ảnh", 7000000, TYT),
 "nsvne": (G2, "Ngoisao.vnexpress.net", "Mục Thương trường (top 4 trở xuống)", "Bài hiển thị từ top 4 trở xuống trong mục Thương trường", "1.000 từ, 3 ảnh", 3650000, T31),
 "eva": (G2, "Eva.vn", "Bài hot tiểu mục", "Đính 1 trong 2 bài hot của tiểu mục trong 2 giờ; hiển thị tại box Tin tức thị trường trên trang chuyên mục và trang bài viết", "1.000 từ, 5 ảnh", 3500000, T31),
 "dlvn": (G2, "Dulichvietnam.com.vn", "Bài PR trang chủ", "Bài hiển thị tại trang chủ và trong mục phù hợp", "1.000 từ, 4 ảnh", 1980000, T31),
 "dlt": (G2, "Dulichtoday.vn", "Bài review / PR", "Bài hiển thị trong mục phù hợp", "1.000 từ, 3 ảnh", 2550000, T31),
 "k14": (G3, "Kenh14.vn", "Mục Xem - Ăn - Chơi", "Bài hiển thị tại mục Xem - Ăn - Chơi ngoài trang chủ trong 2 giờ rồi lùi dần", "1.500 từ, 10 ảnh", 6640000, T26),
 "hht": (G3, "Hoahoctro.tienphong.vn", "Chuyên mục phù hợp", "Bài hiển thị trong mục phù hợp", "1.000 từ, 3 ảnh", 2100000, T31),
 "tiin": (G3, "Tiin.vn", "Mục Sành", "Bài hiển thị trong mục Sành", "1.000 từ, 3 ảnh", 2340000, T31),
}
RM = "Rise Media - bang gia 29/07 (CU, phai hoi lai)"
GK = "Theo yêu cầu"
B.update({
 "k_vnn": (GK, "Vietnamnet.vn", "Bài 1 - Mục Đời sống (tiểu mục Du lịch / Mẹo vặt cuộc sống, theo duyệt của toà soạn)", "Bài hiển thị từ top 6 trở xuống trong tiểu mục", "1.000 từ, 5 ảnh", 4500000, T31),
 "k_afa": (GK, "Afamily.vn", "Bài 2 - Chuyên mục Gia đình / Du lịch", "Bài hiển thị trong chuyên mục phù hợp", "1.000 từ, 5 ảnh", 3320000, T31),
 "k_vne": (GK, "Vnexpress.net", "Bài 3 (phương án A) - Tiểu mục Doanh nghiệp viết, duy trì 6 tháng", "Bài hiển thị trong tiểu mục Doanh nghiệp viết 6 tháng, đồng thời lên box Thông tin doanh nghiệp ở trang chủ (lùi dần khi có bài mới)", "1.000 từ, 3 ảnh", 7300000, T28),
 "k_dt": (GK, "Dantri.com.vn", "Bài 3 (phương án B) - Tiểu mục thuộc Đời sống (đề xuất Du lịch, theo duyệt của toà soạn)", "Bài hiển thị trong tiểu mục phù hợp của Đời sống", "1.000 từ, 5 ảnh", 10350000, T28),
})
random.seed(20261104 + 7)
P = {}
for k, r in B.items():
    sell = int(math.ceil(round(r[5] * 1.1) / 1000) * 1000)
    ck = random.choice(range(20, 30))
    ny = int(round(sell / (1 - ck / 100) / 10000) * 10000)
    P[k] = r + (sell, ck, ny)
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



NOTE = ["Ghi chú:",
 "- Mỗi nhóm chọn 1 báo (tổng 3 bài). Giá tính theo bài, không chèn link, chưa gồm VAT 8%.",
 "- Bài 1.200 từ: phần lớn gói báo quy định 800-1.000 từ (riêng Kenh14 tới 1.500 từ). Phần vượt có thể phát sinh phụ phí hoặc toà soạn biên tập rút gọn; Digicom xác nhận với toà soạn trước khi đặt.",
 "- Toà soạn có thể biên tập lại bài theo quy định của báo. Bài quảng bá resort cần thông tin, hình ảnh đúng thực tế; toà soạn có thể yêu cầu giấy tờ cơ sở lưu trú trước khi duyệt.",
 "- Lịch đăng tuần sau: gửi bài + ảnh trước ít nhất 2 ngày làm việc để toà soạn duyệt. Đặt trước ngày hết hiệu lực báo giá để giữ giá.",
 "- Hỗ trợ tư vấn chọn báo, chọn chuyên mục miễn phí. Viết bài theo yêu cầu: báo giá riêng. Phụ phí phóng viên đến tận nơi (nếu cần): 1.000.000 đ/buổi."]

HD = ["STT", "Đầu báo", "Vị trí đăng", "Hiển thị", "Quy cách gói", "Giá niêm yết (đ)", "Chiết khấu", "Giá ưu đãi (đ, chưa VAT)"]
W = [6, 22, 28, 40, 18, 16, 11, 18]
wb = Workbook(); ws = wb.active; ws.title = "3 báo theo yêu cầu"; ws.sheet_properties.tabColor = "0E8C7F"
KS = ["k_vnn", "k_afa", "k_vne", "k_dt"]
r = banner(ws, len(HD), "BÁO GIÁ 3 BÀI PR RESORT THEO ĐẦU BÁO QUÝ KHÁCH CHỌN - Kính gửi: Quý khách hàng", "1C2035")
rows = [(GK, i, P[k][1], P[k][2], P[k][3], P[k][4], P[k][9], f"{P[k][8]}%", P[k][7]) for i, k in enumerate(KS, 1)]
r = table(ws, r, HD, rows, W, [6, 8], "0E8C7F")
for lab, b3 in (("Tổng 3 bài nếu Bài 3 đăng VnExpress", "k_vne"), ("Tổng 3 bài nếu Bài 3 đăng Dân trí", "k_dt")):
    sub = P["k_vnn"][7] + P["k_afa"][7] + P[b3][7]
    for l2, val, bold in ((lab + " - chưa VAT", sub, False), (lab + " - đã gồm VAT 8%", sub + round(sub * 0.08), True)):
        ws.merge_cells(start_row=r, start_column=1, end_row=r, end_column=7)
        a = ws.cell(r, 1, l2); a.font = F(bold=True); a.alignment = Alignment(horizontal="right")
        c = ws.cell(r, 8, val); c.number_format = "#,##0"; c.font = F(bold=bold, color="0E8C7F" if bold else "000000"); c.border = BD; r += 1
notes(ws, r + 1, len(HD), ["Ghi chú:",
 "- Bài 3 chọn 1 trong 2 phương án: VnExpress (tiểu mục Doanh nghiệp viết, bài duy trì 6 tháng) hoặc Dân trí (tiểu mục thuộc Đời sống). Dạng bài ảnh/tin nhanh vẫn tính theo giá bài PR tiểu mục.",
 "- Các gói báo quy định dưới 1.000 từ; bài 1.200 từ có thể phát sinh phụ phí hoặc toà soạn biên tập rút gọn. Digicom xác nhận với toà soạn trước khi đặt.",
 "- Tiêu đề, góc tiếp cận (angle) do toà soạn duyệt và có thể chỉnh theo quy định của báo. Tiểu mục đăng cụ thể do toà soạn xếp theo nội dung bài.",
 "- Giá không chèn link, chưa gồm VAT 8%. Lịch đăng tuần sau: gửi bài + ảnh trước ít nhất 2 ngày làm việc. Sheet \"Bảng giá\" có thêm các báo khác để tham khảo."])
ws = wb.create_sheet("Bảng giá"); ws.sheet_properties.tabColor = "0E8C7F"
r = banner(ws, len(HD), "BÁO GIÁ ĐĂNG BÀI PR QUẢNG BÁ RESORT - 3 NHÓM BÁO (PHỔ THÔNG, LIFESTYLE, GIỚI TRẺ) - Kính gửi: Quý khách hàng", "1C2035")
rows = []
for g in (G1, G2, G3):
    ks = [k for k in B if B[k][0] == g and not k.startswith("k_")]
    for i, k in enumerate(ks, 1):
        rows.append((g, i, P[k][1], P[k][2], P[k][3], P[k][4], P[k][9], f"{P[k][8]}%", P[k][7]))
r = table(ws, r, HD, rows, W, [6, 8], "0E8C7F")
notes(ws, r + 1, len(HD), NOTE)
ws2 = wb.create_sheet("Thông tin & Thanh toán"); ws2.sheet_properties.tabColor = "0E8C7F"; info_sheet(ws2, "0E8C7F")
wb.save(OUT + NAME)

wb = Workbook(); ws = wb.active; ws.title = "NOIBO giá vốn"; ws.sheet_properties.tabColor = "B91C1C"
hd = ["STT", "Đầu báo", "Vị trí đăng", "Quy cách", "NCC", "Tab nguồn (hiệu lực)", "Giá vốn Goodcom", "Giá bán (x1,1)", "Lãi", "Niêm yết hiển thị", "CK hiển thị"]
r = banner(ws, len(hd), "NOIBO - Báo giá PR resort - 04/11/2026", "7F1D1D", warn="FILE NỘI BỘ - TUYỆT ĐỐI KHÔNG GỬI KHÁCH")
rows = []
for g in (GK, G1, G2, G3):
    for i, k in enumerate([k for k in B if B[k][0] == g], 1):
        rows.append((g, i, P[k][1], P[k][2], P[k][4], "Rise Media" if P[k][6] == RM else "Goodcom (Ms Thu)", P[k][6], P[k][5], P[k][7], P[k][7] - P[k][5], P[k][9], f"{P[k][8]}%"))
r = table(ws, r, hd, rows, [6, 22, 28, 16, 16, 24, 14, 14, 12, 14, 9], [7, 8, 9, 10], "B91C1C")
cheap = sum(min(P[k][7] for k in B if B[k][0] == g) for g in (G1, G2, G3))
cA = sum(P[k][5] for k in ("k_vnn", "k_afa", "k_vne")); sA = sum(P[k][7] for k in ("k_vnn", "k_afa", "k_vne"))
cB = sum(P[k][5] for k in ("k_vnn", "k_afa", "k_dt")); sB = sum(P[k][7] for k in ("k_vnn", "k_afa", "k_dt"))
notes(ws, r + 1, len(hd), [
 f"3 báo khách chọn - PA VnExpress: vốn {cA:,.0f}, bán {sA:,.0f}, lãi {sA-cA:,.0f}. PA Dân trí: vốn {cB:,.0f}, bán {sB:,.0f}, lãi {sB-cB:,.0f}.",
 "Cả 3 báo khách chọn lấy Goodcom (Hiếu chốt 04/11). Goodcom KHÔNG có VnExpress mục Du lịch -> dùng gói Doanh nghiệp viết 6 tháng (tab 28.10). Dân trí tab 28.10 tiểu mục Kinh doanh/Đời sống - hỏi Goodcom vào được Du lịch không. Vietnamnet tab 31.10 mục Đời sống.",
 "Vietnamnet: gói Goodcom 31.10 ghi 'Mẹo vặt cuộc sống/Đời sống' - hỏi Goodcom vào được tiểu mục Du lịch không.",
 f"Combo rẻ nhất (Tuổi Trẻ + Dulichvietnam + Hoa Học Trò): bán {cheap:,.0f} chưa VAT.",
 "Nguồn: Drive 'Báo giá booking Combat_ 2026.xlsx' (Goodcom). Tab 28.10 hết 07/11 (VnExpress), 31.10 hết 10/11, Y tế 27.10 hết 06/11 (Znews).",
 "Kenh14 Xem-Ăn-Chơi lấy từ tab '2026' KHÔNG ghi ngày (tab 12.10 chỉ có mục Bản tin/Học đường, đã hết hạn). Khách chọn Kenh14 => hỏi lại Goodcom giá trước khi chốt.",
 "Khách cần 1.200 từ: hỏi Goodcom phụ phí vượt chữ từng báo (Thanh Niên gói 800 từ, Tuổi Trẻ 600-1.000). Đăng tuần sau, sau hạn NCC => hỏi lại giá + lịch trước khi nhận tiền."])
wb.save(OUT + NOIBO)
print("ok")
