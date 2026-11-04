# Bao gia guest post nganh phan mem, kinh doanh, ho kinh doanh - 03/11/2026
# Nguon: Google Sheet "[KH ANH HIEU] GP" (19uZ8UHbmQI0rvvSyIWCwuoKjIoSge6M8VEUs_GSf-aQ), tab Trang tinh1.
# Gia NCC da gom VAT 8%. Gia ban = gia NCC x 1,1 (Hieu chot 03/11), lam tron nghin. Hien thi: niem yet anchor + CK 20-29%.
# Loc 03/11: kiem song (DNS + HTTP) + doc trang chu tung site. Chi giu site con song, dung nganh.
import math, random
from openpyxl import Workbook
from openpyxl.styles import Font, PatternFill, Alignment, Border, Side
from openpyxl.utils import get_column_letter

OUT = "/Volumes/Extreme SSD/Projects/digicom/11-bao-gia-khach/"
NAME = "Bao-Gia-Guest-Post-Phan-Mem-Kinh-Doanh-2026-11-03.xlsx"
NOIBO = "NOIBO-" + NAME
ISSUE, EXP = "03/11/2026", "10/11/2026"
G1, G2 = "Phần mềm - Công nghệ - Ứng dụng", "Kinh doanh - Thương hiệu - Hộ kinh doanh"
# (nhom, site, chu de site (doc trang chu 03/11), DR, traffic, gia NCC gom VAT)
ROWS = [
 (G1, "sum.vn", "Công cụ, phần mềm trực tuyến (sản phẩm của VIK Solution)", 68, "9.4K", 1026000),
 (G1, "ghichu.vn", "Ứng dụng ghi chú trực tuyến, có chuyên mục blog Phần mềm - Công cụ", 29, "40.8K", 950400),
 (G1, "netup.vn", "Công ty dịch vụ app mobile, blog công nghệ - ứng dụng", "", "8.6K", 460000),
 (G1, "taiungdung.vn", "Kho phần mềm, ứng dụng; kiến thức công nghệ thông tin", "", "49", 648000),
 (G1, "cmcdistribution.com.vn", "Blog công nghệ, phần mềm (có bài phần mềm quản trị doanh nghiệp)", 35, "223", 650000),
 (G2, "chonthuonghieu.com", "Tổng hợp, đề xuất thương hiệu, dịch vụ và cửa hàng địa phương", 55, "1K", 650000),
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
                    (f"Ngày phát hành: {ISSUE} - Hiệu lực đến hết: {EXP} - Giá đã gồm VAT 8%, có xuất hoá đơn", dict(color="FFFFFF"))]:
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
 "- Giá tính theo 1 bài guest post, đã gồm VAT 8%, có xuất hoá đơn.",
 "- Nội dung bài cần đúng chủ đề của site; site có thể yêu cầu chỉnh sửa trước khi đăng. Loại link và thời gian lên bài xác nhận khi đặt đơn.",
 "- Hỗ trợ tư vấn chọn site và viết bài chuẩn SEO theo yêu cầu: báo giá riêng.",
 "- Danh sách site có thể thay đổi; Digicom xác nhận lại tình trạng nhận bài trước khi triển khai."]

wb = Workbook(); ws = wb.active; ws.title = "Bảng giá guest post"; ws.sheet_properties.tabColor = "0E8C7F"
hd = ["STT", "Site", "Chủ đề site", "DR", "Traffic/tháng", "Giá niêm yết (đ)", "Chiết khấu", "Giá ưu đãi (đ, gồm VAT)"]
r = banner(ws, len(hd), "BÁO GIÁ GUEST POST - NGÀNH PHẦN MỀM, KINH DOANH, HỘ KINH DOANH", "1C2035")
rows = [(d[0], i, d[1], d[2], d[3], d[4], d[8], f"{d[7]}%", d[6]) for i, d in enumerate(data, 1)]
r = table(ws, r, hd, rows, [6, 24, 46, 7, 13, 16, 11, 18], [6, 8], "0E8C7F")
notes(ws, r + 1, len(hd), NOTE)
ws2 = wb.create_sheet("Thông tin & Thanh toán"); ws2.sheet_properties.tabColor = "0E8C7F"; info_sheet(ws2, "0E8C7F")
wb.save(OUT + NAME)

wb = Workbook(); ws = wb.active; ws.title = "NOIBO giá vốn"; ws.sheet_properties.tabColor = "B91C1C"
hd = ["STT", "Site", "Chủ đề site", "DR", "Traffic", "Giá NCC (gồm VAT)", "Giá bán (x1,1)", "Lãi", "Niêm yết hiển thị", "CK hiển thị"]
r = banner(ws, len(hd), "NOIBO - Guest post phần mềm, kinh doanh - 03/11/2026", "7F1D1D", warn="FILE NỘI BỘ - TUYỆT ĐỐI KHÔNG GỬI KHÁCH")
rows = [(d[0], i, d[1], d[2], d[3], d[4], d[5], d[6], d[6] - d[5], d[8], f"{d[7]}%") for i, d in enumerate(data, 1)]
r = table(ws, r, hd, rows, [6, 22, 40, 7, 10, 16, 16, 12, 16, 9], [6, 7, 8, 9], "B91C1C")
r = notes(ws, r + 1, len(hd), ["Nguồn: Google Sheet '[KH ANH HIẾU] GP' https://docs.google.com/spreadsheets/d/19uZ8UHbmQI0rvvSyIWCwuoKjIoSge6M8VEUs_GSf-aQ (tab Trang tính1, 58 site). Giá bán = giá NCC x 1,1.",
 "Loại khi kiểm 03/11 (DNS + HTTP + đọc trang chủ): tên miền hết hạn (trang VNNIC): random.com.vn, hoclamweb.com.vn, cachthietkeweb.vn, buonbantenmien.vn, bkcare.vn, gachmenthanhtung.vn.",
 "Không còn DNS: remove.vn, chatfuel.vn, kinhdoanhzalo.net, socialmarketing.vn, phanmemmienphi.vn, danhgiaphanmem.vn, internetmarketing.vn, banhangzalo.com, afu.vn, fjn.vn, gemstech.com.vn, vetranhtuongviet.vn.",
 "Máy chủ không truy cập được (194.233.85.9): quantrinhansu.vn, coder.com.vn, dichvuquangcao.vn, nganhangsimso.vn. livestream.vn lỗi 404, workshop.vn chuyển sang trang bán tên miền, social.vn đang dựng, kenhraovat.vn chưa có web.",
 "Còn sống nhưng lệch ngành: tangfollow.vn (dịch vụ tăng follow), giaitri.vn, apk.vn (game MOD), lapcamerahanoi.com (camera), linhkienhanoi.com, tinhocduykhang.com (phần cứng), fpthcm.com.vn (lắp mạng), 22 site nội thất - xây dựng.",
 "Trước khi chốt đơn: hỏi lại NCC site còn nhận bài và giá còn giữ không (nhiều site trong file đã chết)."])
wb.save(OUT + NOIBO)
for d in data: print(d[1], d[5], d[6], d[7], d[8])
