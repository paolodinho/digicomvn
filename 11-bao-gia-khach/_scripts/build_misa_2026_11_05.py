# Bao gia guest post MISA - 05/11/2026
# Gia ban do Hieu chot 05/11: vjst.vn 5.500.000 (Hiếu hạ từ 9tr 05/11) (1 bai muc Chuyen doi so), saigonreview.vn 1.200.000, topaz.vn 1.200.000.
# Nguon von: DanaSEO guest post (topaz, saigonreview 1.200.000, CK ngam 10% -> von 1.080.000); vjst.vn Rise Media khong co gia (ghi 0) -> von chua xac nhan.
# Gia chua VAT 8%. Hien thi: niem yet anchor + CK 20-29%.
import math, random
from openpyxl import Workbook
from openpyxl.styles import Font, PatternFill, Alignment, Border, Side
from openpyxl.utils import get_column_letter

OUT = "/Volumes/Extreme SSD/Projects/digicom/11-bao-gia-khach/"
NAME = "Bao-Gia-Guest-Post-MISA-2026-11-05.xlsx"
NOIBO = "NOIBO-" + NAME
ISSUE, EXP = "05/11/2026", "12/11/2026"
G1, G2, G3 = "Tạp chí khoa học - công nghệ", "Site review, xếp hạng", "Báo pháp luật - LuatVietnam.vn"
LV = "LuatVietnam chính chủ (Hiếu báo 05/11: vị trí thấp nhất vốn 5tr)"
# (nhom, site, chu de/vi tri, quy cach, gia ban, gia von or None, nguon von)
ROWS = [
 (G1, "vjst.vn", "Tạp chí Khoa học và Công nghệ Việt Nam - 1 bài đăng chuyên mục Chuyển đổi số", "Bài dưới 1.000 từ, 3 ảnh, 1 link", 5500000, None, "Rise Media (sheet ghi giá 0, chưa có giá vốn) - Hiếu hạ giá bán 5,5tr 05/11"),
 (G2, "saigonreview.vn", "Sài Gòn Review - nền tảng xếp hạng, đánh giá dịch vụ tại TP.HCM", "1.000 từ, 3-5 ảnh, 2 link dofollow", 1200000, 1080000, "DanaSEO 1.200.000, CK ngầm 10%"),
 (G2, "topaz.vn", "topAZ Review - đánh giá, xếp hạng toplist", "1.000 từ, 3-5 ảnh, 2 link nofollow", 1200000, 1080000, "DanaSEO 1.200.000, CK ngầm 10%"),
 (G3, "luatvietnam.vn", "Bài PR tin tức pháp luật - vị trí cơ bản", "Tối đa 5 ảnh, 1 link", 5500000, 5000000, LV),
]
random.seed(20261105)
data = []
for r in ROWS:
    ck = random.choice([20, 21, 22, 23, 24, 25, 26, 27, 28, 29])
    ny = int(round(r[4] / (1 - ck / 100) / 10000) * 10000)
    data.append(r + (ck, ny))
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
                    (f"Ngày phát hành: {ISSUE} - Hiệu lực đến hết: {EXP} - Giá chưa gồm VAT 8%, có xuất hoá đơn", dict(color="FFFFFF"))]:
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
     ("Lưu ý", "Sau thời hạn trên, giá có thể thay đổi theo chính sách của site - vui lòng liên hệ để xác nhận lại giá trước khi đặt.")]
    for i, (a, b) in enumerate(items, 1):
        ca = ws.cell(i, 1, a)
        if b is None:
            ws.merge_cells(start_row=i, start_column=1, end_row=i, end_column=2)
            ca.font = F(bold=True, color="FFFFFF"); ca.fill = PatternFill("solid", fgColor=color)
        else:
            ca.font = F(bold=True); cb = ws.cell(i, 2, b); cb.font = F()
            cb.alignment = Alignment(wrap_text=True, vertical="top")


NOTE = ["Ghi chú:",
 "- Giá tính theo 1 bài guest post, chưa gồm VAT 8%, có xuất hoá đơn.",
 "- vjst.vn là tạp chí khoa học: nội dung bài cần đúng chủ đề chuyên mục Chuyển đổi số, toà soạn biên tập và duyệt trước khi đăng.",
 "- Nội dung khách cung cấp hoặc Digicom viết theo yêu cầu (báo giá riêng). Loại link và thời gian lên bài xác nhận khi đặt đơn.",
 "- LuatVietnam.vn: giá áp dụng cho vị trí cơ bản; vị trí ghim trang chủ báo giá riêng khi quý khách cần. Bài lên tối đa 2 ngày làm việc sau khi ký hợp đồng. Dịch vụ thêm: thêm 1 link 1.100.000 đ; Digicom viết bài 1.100.000 đ; bài PR dàn trang (layout) cộng 5.500.000 đ; bài đánh giá/top cộng 2.200.000 đ.",
 "- Digicom xác nhận lại tình trạng nhận bài của từng site trước khi triển khai."]

wb = Workbook(); ws = wb.active; ws.title = "Bảng giá guest post"; ws.sheet_properties.tabColor = "0E8C7F"
hd = ["STT", "Site", "Chủ đề, vị trí đăng", "Quy cách bài", "Giá niêm yết (đ)", "Chiết khấu", "Giá ưu đãi (đ)"]
r = banner(ws, len(hd), "BÁO GIÁ GUEST POST - MISA", "1C2035")
rows = [(d[0], i, d[1], d[2], d[3], d[8], f"{d[7]}%", d[4]) for i, d in enumerate(data, 1)]
r = table(ws, r, hd, rows, [6, 20, 46, 26, 16, 11, 16], [5, 7], "0E8C7F")
r += 1
ws.merge_cells(start_row=r, start_column=2, end_row=r, end_column=6)
c0 = ws.cell(r, 2, "Tổng 3 site (vjst.vn + saigonreview.vn + topaz.vn)"); c0.font = F(bold=True); c0.alignment = Alignment(horizontal="right")
c = ws.cell(r, 7, sum(d[4] for d in data if d[0] != G3)); c.font = F(bold=True); c.number_format = "#,##0"
notes(ws, r + 2, len(hd), NOTE)
ws2 = wb.create_sheet("Thông tin & Thanh toán"); ws2.sheet_properties.tabColor = "0E8C7F"; info_sheet(ws2, "0E8C7F")
wb.save(OUT + NAME)

wb = Workbook(); ws = wb.active; ws.title = "NOIBO giá vốn"; ws.sheet_properties.tabColor = "B91C1C"
hd = ["STT", "Site", "Quy cách", "Nguồn vốn", "Giá vốn thật", "Giá bán", "Lãi", "Niêm yết hiển thị", "CK hiển thị"]
r = banner(ws, len(hd), "NOIBO - Guest post MISA - 05/11/2026", "7F1D1D", warn="FILE NỘI BỘ - TUYỆT ĐỐI KHÔNG GỬI KHÁCH")
rows = [(d[0], i, d[1], d[3], d[6], d[5] if d[5] else "Chưa có", d[4], (d[4] - d[5]) if d[5] else "Chưa tính", d[8], f"{d[7]}%") for i, d in enumerate(data, 1)]
r = table(ws, r, hd, rows, [6, 18, 26, 30, 14, 14, 12, 16, 9], [5, 6, 7, 8], "B91C1C")
notes(ws, r + 1, len(hd), ["Giá bán do Hiếu chốt 05/11/2026. vjst.vn: sheet Rise Media dòng 112 (ICTvietnam.vn / vjst.vn, tiểu mục) ghi giá 0 - phải hỏi Rise giá vốn mục Chuyển đổi số trước khi nhận đơn.",
 "topaz.vn, saigonreview.vn: DanaSEO guest post 1.200.000 (chưa VAT), CK ngầm 10% -> vốn 1.080.000, lãi 120.000/bài.",
 "LuatVietnam.vn: Hiếu sửa 05/11 chiều - vị trí thấp nhất vốn 5.000.000, bán 5.500.000 (rate card 2025 loại 2-4 giá 3-4tr đã cũ, bỏ). Vị trí cao hơn chưa có giá mới -> không chào. Dịch vụ thêm vốn: link +1tr, viết bài +1tr, layout +5tr, đánh giá/top +2tr -> bán x1,1."])
wb.save(OUT + NOIBO)
for d in data: print(d[1], d[4], d[7], d[8])
