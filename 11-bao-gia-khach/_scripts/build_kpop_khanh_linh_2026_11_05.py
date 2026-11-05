# Bao gia PR ra mat nghe si K-pop Khanh Linh - cong ty 바다와하늘처럼 (Han Quoc), CEO Wooram Lee, media@likebaha.com, 05/11/2026.
# Cap nhat 05/11 trua: ghi dung ten khach + nguoi nhan, them ban tieng Anh cho bang 3 bao + sheet tra loi (khach Han viet email tieng Anh).
# 2 thong cao (24/11, 27/11), toi thieu 3 bai, linh vuc giai tri/K-pop, ngan sach 10-15tr. Noi dung goc tieng Anh.
# Nguon: Goodcom tab "May khuech tan tinh dau- 31.10." (het han 10/11) -> gia ban = thanh tien x1,1.
#        DanaSEO (kho 29/07, can hoi lai) -> gia ban = gia DanaSEO bao (von that x0,9). Moi bao lay phuong an re hon.
import math, random
from openpyxl import Workbook
from openpyxl.styles import Font, PatternFill, Alignment, Border, Side
from openpyxl.utils import get_column_letter
OUT = "/Volumes/Extreme SSD/Projects/digicom/11-bao-gia-khach/"
NAME = "Bao-Gia-PR-Ra-Mat-Nghe-Si-KPop-Khanh-Linh-2026-11-05.xlsx"
NOIBO = "NOIBO-" + NAME
ISSUE, EXP = "05/11/2026", "12/11/2026"
GC, DN = "Goodcom tab 31.10 (hết hạn 10/11)", "DanaSEO kho 29/07 (CŨ - hỏi lại)"
RS = "Rise Media sheet 05/11 (x1,1)"
GT = "Goodcom (chị Thu) 05/11: niêm yết trừ CK 24% (x1,1)"
SP = "Khoảng 1.000 từ, 3 ảnh (xác nhận khi đặt)"
G1, G2 = "Nhóm 1 - Báo giải trí, giới trẻ", "Nhóm 2 - Báo đời sống có chuyên mục giải trí"
# key: (nhom, bao, vi_tri, hien_thi, quy_cach, gia_von, nguon, gia_ban)
B = {
 "k14": (G1, "Kenh14.vn", "Tiểu mục Âm nhạc / Sao (theo duyệt toà soạn)", "Bài hiển thị trong tiểu mục phù hợp của Kenh14", "Dưới 1.000 từ, dưới 7 ảnh", 3330000, DN, 3700000),
 "ss":  (G1, "Saostar.vn", "Chuyên mục phù hợp (Âm nhạc / Sao)", "Bài hiển thị trong chuyên mục phù hợp", SP, 2800000, RS, None),
 "tiin":(G1, "Tiim.com.vn (trước là Tiin.vn)", "Mục Nhạc", "Vị trí trong mục Nhạc", SP, 3040000, GT, None),
 "ns":  (G1, "Ngoisao.vn", "Chuyên mục phù hợp", "Bài hiển thị trong chuyên mục phù hợp", SP, 2280000, RS, None),
 "nsv": (G1, "Ngoisao.vnexpress.net", "Mục Thương trường (top 4 trở xuống)", "Bài hiển thị từ top 4 trở xuống trong mục Thương trường", "1.000 từ, 3 ảnh", 3650000, GC, None),
 "hht": (G1, "Hoahoctro.tienphong.vn", "Chuyên mục phù hợp", "Bài hiển thị trong mục phù hợp", "1.000 từ, 3 ảnh", 2100000, GC, None),
 "yan": (G1, "Yan.vn", "Chuyên mục phù hợp", "Bài hiển thị trong chuyên mục phù hợp", "Dưới 1.000 từ, dưới 3 ảnh", 4050000, DN, 4500000),
 "eva": (G2, "Eva.vn", "Bài hot tiểu mục", "Đính 1 trong 2 bài hot của tiểu mục trong 2 giờ, hiển thị tại box Tin tức thị trường", "Dưới 1.000 từ, dưới 5 ảnh", 3330000, DN, 3700000),
 "afa": (G2, "Afamily.vn", "Chuyên mục phù hợp", "Bài hiển thị trong chuyên mục phù hợp", SP, 3040000, RS, None),
 "vtv": (G2, "Vtv.vn", "Chuyên mục phù hợp", "Bài hiển thị trong chuyên mục phù hợp", "1.000 từ, 5 ảnh", 4980000, GC, None),
}
GA = "A. Vị trí khác trên các báo đã chào / Other sections on the same outlets"
GB = "B. Báo giải trí, giới trẻ khác / Other entertainment and youth outlets"
GX = "C. Báo lớn tổng hợp, chuyên mục giải trí / Major news outlets, entertainment section"
DS = "Dưới 1.000 từ, dưới 7 ảnh"
S = {
 "k14hp": (GA, "Kenh14.vn", "Trang chủ", "Bài hiển thị trên trang chủ Kenh14", DS, 9180000, DN, 10200000),
 "k14x":  (GA, "Kenh14.vn", "Xem - Ăn - Chơi", "Bài trong mục Xem - Ăn - Chơi (giải trí, lifestyle)", DS, 5490000, DN, 6100000),
 "tiisao": (GA, "Tiim.com.vn (trước là Tiin.vn)", "Mục Sao", "Vị trí trong mục Sao", SP, 3800000, GT, None),
 "tiisanh": (GA, "Tiim.com.vn (trước là Tiin.vn)", "Mục Sành", "Bài hiển thị trong mục Sành", SP, 2310000, RS, None),
 "nscm":  (GA, "Ngoisao.vn", "Chuyên mục", "Bài hiển thị trong chuyên mục", SP, 3420000, RS, None),
 "nshp":  (GA, "Ngoisao.vn", "Trang chủ", "Bài hiển thị trên trang chủ", SP, 5700000, RS, None),
 "nsvhp": (GA, "Ngoisao.vnexpress.net", "Trang chủ", "Bài hiển thị trên trang chủ", SP, 8160000, RS, None),
 "hhthp": (GA, "Hoahoctro.tienphong.vn", "Trang chủ - Tiêu điểm", "Box Tiêu điểm trang chủ, từ top 2 trở xuống", SP, 3600000, RS, None),
 "afa3":  (GA, "Afamily.vn", "Box chuyên mục / Stream 2", "Bài loại 3: box chuyên mục, luồng tin thứ 2", SP, 5320000, RS, None),
 "afa2":  (GA, "Afamily.vn", "Nổi bật mục", "Bài loại 2: vị trí nổi bật của mục", SP, 9120000, RS, None),
 "2s12":  (GB, "2sao.vn", "Chuyên mục (top 12 trở xuống)", "Bài trong chuyên mục, từ top 12 trở xuống", SP, 1675000, RS, None),
 "2s6":   (GB, "2sao.vn", "Chuyên mục (top 6-11)", "Bài trong chuyên mục, vị trí top 6-11", SP, 2010000, RS, None),
 "2s1":   (GB, "2sao.vn", "Top 1 box chuyên mục trang chủ", "Top 1 box chuyên mục hiển thị tại trang chủ", SP, 4020000, RS, None),
 "24h2":  (GB, "24h.com.vn", "PR loại 2 - Giải trí", "Bài trong chuyên mục Giải trí", SP, 3050000, RS, None),
 "24h1":  (GB, "24h.com.vn", "PR loại 1 - Giải trí", "2 giờ trên trang chủ, sau đó về chuyên mục Giải trí", "Dưới 1.000 từ, dưới 5 ảnh", 4680000, DN, 5200000),
 "soha":  (GB, "Soha.vn", "Chuyên mục", "Bài trong chuyên mục phù hợp", SP, 3800000, RS, None),
 "sohahp":(GB, "Soha.vn", "Stream trang chủ", "Bài trong luồng tin trang chủ", "Dưới 1.000 từ, dưới 5 ảnh", 4140000, DN, 4600000),
 "vtc":   (GB, "Vtcnews.vn", "Chuyên mục Trẻ", "Bài trong chuyên mục Trẻ", SP, 2800000, RS, None),
 "ptd":   (GB, "Phunutoday.vn", "Trang trong, mục phù hợp", "Bài trong mục phù hợp", SP, 3300000, RS, None),
 "vnn":   (GX, "Vietnamnet.vn", "Tiểu mục phù hợp (top 6 trở xuống)", "Bài trong tiểu mục, từ top 6 trở xuống", SP, 4020000, RS, None),
 "zn":    (GX, "Znews.vn", "Tiểu mục phù hợp", "Bài trong tiểu mục phù hợp", SP, 6600000, RS, None),
 "dt":    (GX, "Dantri.com.vn", "Tiểu mục phù hợp (nhóm 2)", "Bài trong tiểu mục phù hợp", "Dưới 1.000 từ, dưới 3 ảnh", 8280000, DN, 9200000),
 "vne":   (GX, "Vnexpress.net", "Tiểu mục phù hợp", "Bài trong tiểu mục phù hợp", SP, 9900000, RS, None),
}
random.seed(20261105)
P = {}
for k, r in list(B.items()) + list(S.items()):
    sell = r[7] if r[7] else int(math.ceil(round(r[5] * 1.1) / 1000) * 1000)
    ck = random.choice(range(20, 30))
    ny = int(round(sell / (1 - ck / 100) / 10000) * 10000)
    P[k] = r[:7] + (sell, ck, ny)
TNR = "Times New Roman"
thin = Side(style="thin", color="D5DCE4")
BD = Border(left=thin, right=thin, top=thin, bottom=thin)
def F(**k): return Font(name=TNR, size=k.pop("size", 12), **k)
TO = "Kính gửi / To: Mr. Wooram Lee - CEO, 바다와하늘처럼 (media@likebaha.com)"
def banner(ws, ncol, title, color, warn=None, to=None):
    r = 1
    if warn:
        ws.merge_cells(start_row=r, start_column=1, end_row=r, end_column=ncol)
        c = ws.cell(r, 1, warn); c.font = F(bold=True, size=14, color="FFFFFF")
        c.fill = PatternFill("solid", fgColor="B91C1C"); c.alignment = Alignment(horizontal="center")
        ws.row_dimensions[r].height = 26; r += 1
    lines = [(title, dict(bold=True, size=14, color="FFFFFF"))] + ([(to, dict(bold=True, color="FFFFFF"))] if to else []) + [

                    ("DigicomVN - Công ty TNHH Dịch vụ Truyền thông Digito Combat - Hotline 0988 769 317 - sales@digicomvn.com", dict(color="FFFFFF")),
                    (f"Ngày phát hành: {ISSUE} - Hiệu lực đến hết: {EXP} - Giá chưa gồm VAT 8% / Prices exclude 8% VAT", dict(color="FFFFFF"))]
    for txt, kw in lines:
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



TRANS = 500000
HD = ["STT / No.", "Đầu báo / Outlet", "Vị trí đăng / Section", "Hiển thị / Placement", "Quy cách / Spec", "Giá niêm yết (đ) / List price (VND)", "Chiết khấu / Discount", "Giá ưu đãi (đ, chưa VAT) / Offer price (VND, excl. VAT)"]
W = [6, 22, 28, 40, 18, 16, 11, 18]
def rows_of(keys, grp):
    return [(grp, i, P[k][1], P[k][2], P[k][3], P[k][4], P[k][9], f"{P[k][8]}%", P[k][7]) for i, k in enumerate(keys, 1)]

wb = Workbook(); ws = wb.active; ws.title = "3 báo quý khách quan tâm"; ws.sheet_properties.tabColor = "0E8C7F"
r = banner(ws, len(HD), "BÁO GIÁ PR RA MẮT NGHỆ SĨ K-POP KHÁNH LINH - 3 ĐẦU BÁO QUÝ KHÁCH QUAN TÂM / PR QUOTATION - K-POP ARTIST KHANH LINH DEBUT", "1C2035", to=TO)
TOP = ["k14", "ss", "tiin"]
r = table(ws, r, HD, rows_of(TOP, "Kenh14 - SaoStar - Tiim (Tiin)"), W, [6, 8], "0E8C7F")
sub = sum(P[k][7] for k in TOP)
for lab, val, bold in (("Tổng 3 bài - chưa VAT / Total 3 articles excl. VAT", sub, False), ("Thuế VAT 8% / VAT 8%", round(sub * 0.08), False), ("Tổng 3 bài - đã gồm VAT 8% / Total incl. VAT", sub + round(sub * 0.08), True)):
    ws.merge_cells(start_row=r, start_column=1, end_row=r, end_column=7)
    a = ws.cell(r, 1, lab); a.font = F(bold=True); a.alignment = Alignment(horizontal="right")
    c = ws.cell(r, 8, val); c.number_format = "#,##0"; c.font = F(bold=bold, color="0E8C7F" if bold else "000000"); c.border = BD; r += 1
notes(ws, r + 1, len(HD), ["Ghi chú:",
 "- Phương án đề xuất: Thông cáo 1 (24/11) đăng Kenh14 + Tiim (mục Nhạc), Thông cáo 2 (27/11) đăng SaoStar. Có thể đổi thứ tự theo nội dung từng thông cáo.",
 "- Cùng một thông cáo đăng trên 2 báo: Digicom biên tập lại tiêu đề, sapo và cách diễn đạt cho mỗi báo để toà soạn duyệt và tránh trùng lặp nội dung.",
 "- Dịch thuật Anh - Việt và biên tập theo văn phong báo chí: MIỄN PHÍ cho đơn từ 3 bài (giá lẻ 500.000 đ/bản dịch, tối đa 1.000 từ).",
 "- Sheet \"Bảng giá báo giải trí\" có thêm các đầu báo khác; sheet \"Gợi ý thêm mục, báo khác\" có vị trí trang chủ, mục nổi bật và 23 lựa chọn khác để quý khách thay thế hoặc bổ sung.",
 "Notes (English):",
 "- Proposed plan: Press release 1 (24 Nov) on Kenh14 + Tiim (Music section), press release 2 (27 Nov) on SaoStar. The order can be swapped to fit each release.",
 "- When one release runs on 2 outlets, Digicom rewrites the headline, lead and wording for each outlet so both editors approve it and the articles are not duplicates.",
 "- English-Vietnamese translation and press-style editing: FREE for orders of 3 articles or more (normally 500,000 VND per release, up to 1,000 words).",
 "- The sheet \"Bảng giá báo giải trí\" lists more entertainment outlets; the sheet \"Gợi ý thêm mục, báo khác\" adds homepage and featured placements plus 23 more options you can swap in or add."])

ws = wb.create_sheet("Bảng giá báo giải trí"); ws.sheet_properties.tabColor = "0E8C7F"
r = banner(ws, len(HD), "BẢNG GIÁ ĐĂNG BÀI PR LĨNH VỰC ÂM NHẠC, GIẢI TRÍ, K-POP / ENTERTAINMENT OUTLET PRICE LIST", "1C2035", to=TO)
rows = []
for g in (G1, G2):
    rows += rows_of([k for k in B if B[k][0] == g], g)
r = table(ws, r, HD, rows, W, [6, 8], "0E8C7F")
notes(ws, r + 1, len(HD), ["Ghi chú:",
 "- Giá tính theo bài, chưa gồm VAT 8%. Vị trí và tiểu mục cụ thể do toà soạn xếp theo nội dung bài.",
 "- Toà soạn có quyền biên tập tiêu đề, sapo, nội dung theo quy định của báo. Thông tin về nghệ sĩ, sản phẩm âm nhạc cần chính xác; toà soạn có thể yêu cầu tư liệu xác minh trước khi duyệt.",
 "- Quy cách gói (số từ, số ảnh) là giới hạn của từng báo; bài vượt quy cách có thể phát sinh phụ phí hoặc được biên tập rút gọn. Digicom xác nhận trước khi đặt."])

ws = wb.create_sheet("Gợi ý thêm mục, báo khác"); ws.sheet_properties.tabColor = "0E8C7F"
r = banner(ws, len(HD), "GỢI Ý THÊM VỊ TRÍ VÀ ĐẦU BÁO CHO CHIẾN DỊCH K-POP / MORE SECTIONS AND OUTLETS FOR THE K-POP CAMPAIGN", "1C2035", to=TO)
rows = []
for g in (GA, GB, GX):
    rows += rows_of([k for k in S if S[k][0] == g], g)
r = table(ws, r, HD, rows, W, [6, 8], "0E8C7F")
notes(ws, r + 1, len(HD), ["Gợi ý sử dụng:",
 "- Muốn tăng độ phủ cho ngày ra mắt: thêm 1 vị trí trang chủ (Kenh14, Ngoisao.vn, 2sao.vn top 1 box trang chủ) cho thông cáo 1.",
 "- Ngân sách trên 10 triệu: thêm 2sao.vn hoặc Vtcnews.vn chuyên mục Trẻ (dưới 3,1 triệu/bài) để có 4-5 bài với cùng 2 thông cáo.",
 "- Nhóm C phù hợp khi muốn bài nằm trên báo lớn tổng hợp, độc giả rộng hơn nhóm báo giải trí.",
 "- Giá chưa VAT 8%. Vị trí và tiểu mục cụ thể do toà soạn xếp theo nội dung bài; Digicom xác nhận lịch trống trước khi đặt.",
 "Suggestions (English):",
 "- For a stronger debut day: add one homepage placement (Kenh14, Ngoisao.vn, or 2sao.vn top-1 homepage box) for release 1.",
 "- With a budget above 10 million VND: add 2sao.vn or the Vtcnews.vn \"Trẻ\" (youth) section (under 3.1 million per article) to reach 4-5 articles from the same 2 releases.",
 "- Group C suits placements on large general news sites with a wider readership than entertainment outlets.",
 "- Prices exclude 8% VAT. Editors decide the exact section based on the content; Digicom confirms availability before booking."])

# Sheet tra loi 5 cau hoi
ws = wb.create_sheet("Trả lời yêu cầu"); ws.sheet_properties.tabColor = "0E8C7F"
ws.column_dimensions["A"].width = 26; ws.column_dimensions["B"].width = 60; ws.column_dimensions["C"].width = 60
for j, h in enumerate(["Câu hỏi / Question", "Trả lời (tiếng Việt)", "Answer (English)"], 1):
    c = ws.cell(1, j, h); c.font = F(bold=True, color="FFFFFF"); c.fill = PatternFill("solid", fgColor="1C2035")
QA = [
 ("1. Danh sách báo và giá", "Xem sheet \"3 báo quý khách quan tâm\" (Kenh14, SaoStar, Tiim - trước là Tiin) và sheet \"Bảng giá báo giải trí\" (10 đầu báo), sheet \"Gợi ý thêm mục, báo khác\" (23 vị trí và đầu báo khác)."),
 ("2. Bảo đảm tối thiểu 3 bài với 2 nội dung", "Digicom cam kết tối thiểu 3 bài đăng cho 2 thông cáo: Thông cáo 1 (24/11) đăng 2 báo, Thông cáo 2 (27/11) đăng 1 báo, hoặc ngược lại. Trường hợp một toà soạn không duyệt bài, Digicom chuyển sang đầu báo cùng nhóm có giá tương đương sau khi quý khách đồng ý, hoặc hoàn tiền bài đó."),
 ("3. Chi phí dịch thuật Anh - Việt", "Dịch và biên tập theo văn phong báo chí Việt Nam: 500.000 đ/bản dịch (tối đa 1.000 từ). Ưu đãi: MIỄN PHÍ khi đặt từ 3 bài. Bản dịch gửi quý khách duyệt trước khi chuyển toà soạn."),
 ("4. Thời gian xử lý", "Bản dịch: 1-2 ngày làm việc sau khi nhận bản tiếng Anh và ảnh. Toà soạn duyệt: 2-3 ngày làm việc. Để đăng đúng 24/11 và 27/11, quý khách vui lòng gửi nội dung lần lượt trước 17/11 và 20/11/2026."),
 ("4. Nghiệm thu", "Digicom gửi link bài đăng và ảnh chụp màn hình trong vòng 24 giờ sau khi bài lên. Kết thúc chiến dịch có biên bản nghiệm thu tổng hợp toàn bộ link."),
 ("5. Phương thức thanh toán", "Chuyển khoản quốc tế (SWIFT) bằng VND hoặc USD theo tỷ giá thống nhất trong hợp đồng, vào tài khoản MB Bank của Digito Combat (SWIFT: MSCBVNVX). Phí chuyển khoản ngân hàng do bên chuyển chịu. Thanh toán 100% trước khi triển khai, hoặc đặt cọc 50% khi ký hợp đồng và 50% còn lại trước ngày đăng bài thứ nhất."),
 ("5. Hoá đơn, chứng từ", "Digicom ký hợp đồng dịch vụ song ngữ Việt - Anh, xuất hoá đơn điện tử GTGT theo tên, địa chỉ, mã số doanh nghiệp tại Hàn Quốc, kèm biên bản nghiệm thu có danh sách link bài đăng."),
]
EN = [
 "1. Outlets and prices: see sheet \"3 báo quý khách quan tâm\" (Kenh14, SaoStar, Tiim - trước là Tiin) and sheet \"Bảng giá báo giải trí\" (10 outlets) and sheet \"Gợi ý thêm mục, báo khác\" (23 more sections and outlets).",
 "2. Guarantee of 3 articles with 2 contents: Digicom guarantees at least 3 published articles for the 2 releases: release 1 (24 Nov) on 2 outlets, release 2 (27 Nov) on 1 outlet, or the other way round. If an editor rejects an article, Digicom moves it to an outlet of similar price in the same group after your approval, or refunds that article.",
 "3. Translation fee: English-Vietnamese translation and press-style editing costs 500,000 VND per release (up to 1,000 words), FREE when you book 3 articles or more. You approve the translation before it goes to the editors.",
 "4. Timeline: translation takes 1-2 working days after we receive the English text and photos; editor approval takes 2-3 working days. To publish on 24 Nov and 27 Nov, please send the content by 17 Nov and 20 Nov 2026.",
 "4. Acceptance: Digicom sends each article link and a screenshot within 24 hours of publication. At the end of the campaign we issue an acceptance report listing all links.",
 "5. Payment: international transfer (SWIFT) in VND, or in USD at the rate agreed in the contract, to Digito Combat's MB Bank account (SWIFT: MSCBVNVX). Bank fees are paid by the sender. Either 100% before work starts, or 50% deposit at signing and 50% before the first article goes live.",
 "5. Invoice and documents: Digicom signs a bilingual Vietnamese-English service contract, issues a VAT e-invoice under your company's name, address and business number in Korea, and provides an acceptance report with all article links.",
]
for i, ((a, b), e) in enumerate(zip(QA, EN), 2):
    ce = ws.cell(i, 3, e); ce.font = F(); ce.alignment = Alignment(wrap_text=True, vertical="top")
    ca = ws.cell(i, 1, a); ca.font = F(bold=True, color="FFFFFF"); ca.fill = PatternFill("solid", fgColor="0E8C7F")
    ca.alignment = Alignment(wrap_text=True, vertical="top")
    cb = ws.cell(i, 2, b); cb.font = F(); cb.alignment = Alignment(wrap_text=True, vertical="top")

ws2 = wb.create_sheet("Thông tin & Thanh toán"); ws2.sheet_properties.tabColor = "0E8C7F"; info_sheet(ws2, "0E8C7F")
n = ws2.max_row + 1
for a, b in (("SWIFT code (MB Bank)", "MSCBVNVX"), ("Địa chỉ ngân hàng", "Ngân hàng TMCP Quân đội (MB Bank), 18 Lê Văn Lương, Trung Hoà, Cầu Giấy, Hà Nội")):
    ws2.cell(n, 1, a).font = F(bold=True); c = ws2.cell(n, 2, b); c.font = F(); c.alignment = Alignment(wrap_text=True, vertical="top"); n += 1
wb.save(OUT + NAME)

wb = Workbook(); ws = wb.active; ws.title = "NOIBO giá vốn"; ws.sheet_properties.tabColor = "B91C1C"
hd = ["STT", "Đầu báo", "Vị trí đăng", "Quy cách", "Nguồn (hiệu lực)", "Giá vốn", "Giá bán", "Lãi", "Niêm yết hiển thị", "CK hiển thị"]
r = banner(ws, len(hd), "NOIBO - Báo giá PR K-pop Khánh Linh (바다와하늘처럼, CEO Wooram Lee) - 05/11/2026", "7F1D1D", warn="FILE NỘI BỘ - TUYỆT ĐỐI KHÔNG GỬI KHÁCH")
rows = []
for g in (G1, G2, GA, GB, GX):
    for i, k in enumerate([k for k in P if P[k][0] == g], 1):
        rows.append((g, i, P[k][1], P[k][2], P[k][4], P[k][6], P[k][5], P[k][7], P[k][7] - P[k][5], P[k][9], f"{P[k][8]}%"))
r = table(ws, r, hd, rows, [6, 22, 28, 18, 26, 14, 14, 12, 14, 9], [6, 7, 8, 9], "B91C1C")
cost = sum(P[k][5] for k in TOP)
notes(ws, r + 1, len(hd), [
 f"3 báo khách quan tâm (Kenh14 + SaoStar + Tiin): vốn {cost:,.0f}, bán {sub:,.0f}, lãi {sub-cost:,.0f} chưa VAT; khách trả {sub+round(sub*0.08):,.0f} gồm VAT - nằm trong ngân sách 10-15tr.",
 "05/11 10h: Tiin đổi tên Tiim.com.vn. Goodcom (chị Thu) báo vị trí thấp nhất: Mục Sao 5tr, Mục Nhạc 4tr, CK 24% -> vốn 3,8tr / 3,04tr, bán x1,1. Dòng chính dùng Mục Nhạc (hợp nghệ sĩ K-pop); Mục Sao + Mục Sành (Rise 2,31tr, rẻ hơn) để ở sheet gợi ý.",
 "05/11 chiều: đổi SaoStar, Ngoisao.vn, Afamily sang Rise Media (sheet 05/11, x1,1) vì rẻ hơn Goodcom/DanaSEO; Rise không ghi quy cách -> hỏi lại số từ/ảnh khi đặt. Goodcom (x1,1, tab 31.10 hết hạn 10/11): Ngoisao VnExpress, Hoa Học Trò, VTV. DanaSEO (bán = giá DanaSEO báo, vốn x0,9): Kenh14, Yan, Eva, 24h loại 1, Soha stream, Dân Trí - hỏi lại DanaSEO trước khi chốt.",
 "Gợi ý thêm (sheet khách 'Gợi ý thêm mục, báo khác'): 23 dòng, mỗi báo lấy NCC rẻ nhất trong master 05/11 (Rise x1,1 hoặc DanaSEO giữ giá).",
 "Kenh14: Goodcom chỉ có Bản tin/Học đường (tab 12.10, đã hết hạn) 4,2tr và Xem-Ăn-Chơi 6,64tr (tab '2026' không ngày) - DanaSEO 3,7tr rẻ hơn. SaoStar, Yan: Goodcom không có.",
 "Dịch Anh-Việt: giá lẻ 500k/bản (tự đặt), miễn phí từ 3 bài = chi phí nhân sự Digicom. Đăng 24/11 + 27/11 sau hạn NCC => hỏi lại giá + lịch trước khi nhận tiền.",
 "Khách nước ngoài: dịch vụ đăng báo tiêu dùng tại VN => vẫn chịu VAT 8%, xuất HĐ điện tử theo tên DN Hàn. Phí SWIFT bên chuyển chịu (OUR). Kiểm lại với kế toán nếu khách đòi 0%."])
wb.save(OUT + NOIBO)
print("ok", sub, sub + round(sub*0.08))
