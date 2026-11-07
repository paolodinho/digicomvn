# Bao gia CHINH THUC (de giam doc ben mua ky) - MISA - 07/11/2026
# Goi chot: 1 GP topaz.vn + 1 GP saigonreview.vn + goi traffic user 5.000.000 (chua VAT).
# Gia lay nguyen tu 2 bao gia 05/11 (Hieu: gia da ok, khong sua). Gia von xem NOIBO cu.
from docx import Document
from docx.shared import Pt, Cm, RGBColor
from docx.enum.text import WD_ALIGN_PARAGRAPH
from docx.enum.table import WD_TABLE_ALIGNMENT, WD_CELL_VERTICAL_ALIGNMENT
from docx.oxml.ns import qn
from docx.oxml import OxmlElement

BASE = "/Volumes/Extreme SSD/Projects/digicom/"
OUT = BASE + "11-bao-gia-khach/Bao-Gia-Chinh-Thuc-MISA-2026-11-07.docx"
LOGO = BASE + "wp-theme/digicom-host/assets/images/logo-digicomvn.png"
SO, NGAY, HET = "0711/2026/BG-DGC", "07/11/2026", "14/11/2026"
NAVY, TEAL, GREY = RGBColor(0x1C, 0x20, 0x35), RGBColor(0x0E, 0x8C, 0x7F), RGBColor(0x5B, 0x66, 0x75)
FONT = "Times New Roman"

# (hang muc, quy cach, dvt, sl, don gia niem yet, ck, don gia)
ITEMS = [
    ("Guest post trên topaz.vn\n(topAZ Review - đánh giá, xếp hạng toplist)",
     "1 bài khoảng 1.000 từ, 3-5 ảnh, 2 link nofollow", "Bài", 1, 1690000, "29%", 1200000),
    ("Guest post trên saigonreview.vn\n(Sài Gòn Review - xếp hạng, đánh giá dịch vụ tại TP.HCM)",
     "1 bài khoảng 1.000 từ, 3-5 ảnh, 2 link dofollow", "Bài", 1, 1540000, "22%", 1200000),
    ("Gói traffic user hỗ trợ guest post",
     "Người dùng thật tại Việt Nam truy cập trang đích do Bên mua chọn; gói và số lượt theo Phụ lục", "Gói", 1, None, None, 5000000),
]
TRAFFIC = [  # goi, nguon, thoi gian, don gia/luot (gia khach dang giu tren Sheet 17uOM3)
    ("Truy cập, ở lại 60 giây", "Chất lượng cao", "60 giây", 3500),
    ("Truy cập, ở lại 90 giây", "Chất lượng cao", "90 giây", 3800),
    ("Truy cập, ở lại 60 giây", "Tiêu chuẩn", "60 giây", 1500),
    ("Truy cập, ở lại 90 giây", "Tiêu chuẩn", "90 giây", 1800),
    ("Truy cập + bấm thêm 1 liên kết", "Tiêu chuẩn", "60 giây, 2 trang/phiên", 2000),
    ("Truy cập + bấm thêm 1 liên kết", "Tiêu chuẩn", "90 giây, 2 trang/phiên", 2500),
]

def vnd(n): return f"{n:,.0f}".replace(",", ".")

DV = ["", "một", "hai", "ba", "bốn", "năm", "sáu", "bảy", "tám", "chín"]
def doc3(n, full):
    tr, ch, dv = n // 100, n // 10 % 10, n % 10
    s = []
    if full or tr: s.append(("không" if tr == 0 else DV[tr]) + " trăm")
    if ch == 0:
        if dv and (full or tr): s.append("lẻ")
    elif ch == 1: s.append("mười")
    else: s.append(DV[ch] + " mươi")
    if dv:
        if dv == 1 and ch > 1: s.append("mốt")
        elif dv == 5 and ch > 0: s.append("lăm")
        else: s.append(DV[dv])
    return " ".join(s)
def bang_chu(n):
    units = ["", "nghìn", "triệu", "tỷ"]; parts = []; i = 0
    groups = []
    while n: groups.append(n % 1000); n //= 1000
    for idx in range(len(groups) - 1, -1, -1):
        g = groups[idx]
        if g: parts.append(doc3(g, idx != len(groups) - 1) + (" " + units[idx] if units[idx] else ""))
    s = " ".join(parts) + " đồng"
    return s[0].upper() + s[1:]

doc = Document()
sec = doc.sections[0]
sec.page_width, sec.page_height = Cm(21), Cm(29.7)
sec.left_margin = sec.right_margin = Cm(2); sec.top_margin = Cm(1.6); sec.bottom_margin = Cm(1.8)
st = doc.styles["Normal"]; st.font.name = FONT; st.font.size = Pt(11.5)
st.element.rPr.rFonts.set(qn("w:eastAsia"), FONT)
st.paragraph_format.space_after = Pt(3); st.paragraph_format.line_spacing = 1.15

def shade(cell, hexc):
    tcPr = cell._tc.get_or_add_tcPr(); sh = OxmlElement("w:shd")
    sh.set(qn("w:val"), "clear"); sh.set(qn("w:color"), "auto"); sh.set(qn("w:fill"), hexc); tcPr.append(sh)
def borders(table, color="C9D2DC"):
    tblPr = table._tbl.tblPr; b = OxmlElement("w:tblBorders")
    for e in ("top", "left", "bottom", "right", "insideH", "insideV"):
        x = OxmlElement(f"w:{e}"); x.set(qn("w:val"), "single"); x.set(qn("w:sz"), "4"); x.set(qn("w:color"), color); b.append(x)
    tblPr.append(b)
def noborders(table):
    tblPr = table._tbl.tblPr; b = OxmlElement("w:tblBorders")
    for e in ("top", "left", "bottom", "right", "insideH", "insideV"):
        x = OxmlElement(f"w:{e}"); x.set(qn("w:val"), "nil"); b.append(x)
    tblPr.append(b)
def para(cell_or_doc, text="", bold=False, size=None, color=None, align=None, italic=False, after=None, first=True):
    p = cell_or_doc.paragraphs[0] if (first and hasattr(cell_or_doc, "paragraphs") and not hasattr(cell_or_doc, "sections") and cell_or_doc.paragraphs and not cell_or_doc.paragraphs[0].text) else cell_or_doc.add_paragraph()
    r = p.add_run(text); r.bold = bold; r.italic = italic
    if size: r.font.size = Pt(size)
    if color: r.font.color.rgb = color
    if align is not None: p.alignment = align
    if after is not None: p.paragraph_format.space_after = Pt(after)
    return p
def widths(table, ws):
    table.autofit = False
    tblPr = table._tbl.tblPr
    lay = OxmlElement("w:tblLayout"); lay.set(qn("w:type"), "fixed"); tblPr.append(lay)
    grid = table._tbl.tblGrid
    for gc, w in zip(grid.findall(qn("w:gridCol")), ws): gc.set(qn("w:w"), str(int(w * 567)))
    for col, w in zip(table.columns, ws): col.width = Cm(w)
    for row in table.rows:
        for c, w in zip(row.cells, ws): c.width = Cm(w)
def heading(text):
    p = doc.add_paragraph(); p.paragraph_format.space_before = Pt(10); p.paragraph_format.space_after = Pt(4)
    r = p.add_run(text.upper()); r.bold = True; r.font.size = Pt(11.5); r.font.color.rgb = TEAL

# --- Tieu de thu: logo + thong tin ben ban
t = doc.add_table(rows=1, cols=2); noborders(t); widths(t, [5.2, 11.8])
t.cell(0, 0).paragraphs[0].add_run().add_picture(LOGO, width=Cm(4.6))
c = t.cell(0, 1)
para(c, "CÔNG TY TNHH DỊCH VỤ TRUYỀN THÔNG DIGITO COMBAT", bold=True, size=10.5, color=NAVY, align=WD_ALIGN_PARAGRAPH.RIGHT, after=1)
for line in ["Mã số thuế: 0109816406",
             "Số nhà 200, Đường 3.1, KĐT Gamuda Garden, Phường Hoàng Mai, TP. Hà Nội",
             "Hotline: 0988 769 317 - Email: sales@digicomvn.com - Website: digicomvn.com"]:
    para(c, line, size=9.5, color=GREY, align=WD_ALIGN_PARAGRAPH.RIGHT, after=0, first=False)
p = doc.add_paragraph(); p.paragraph_format.space_after = Pt(0)
pPr = p._p.get_or_add_pPr(); bd = OxmlElement("w:pBdr"); bt = OxmlElement("w:bottom")
bt.set(qn("w:val"), "single"); bt.set(qn("w:sz"), "12"); bt.set(qn("w:color"), "0E8C7F"); bd.append(bt); pPr.append(bd)

para(doc, "BÁO GIÁ DỊCH VỤ", bold=True, size=18, color=NAVY, align=WD_ALIGN_PARAGRAPH.CENTER, after=0).paragraph_format.space_before = Pt(12)
para(doc, "Guest post và traffic user", italic=True, size=11.5, color=GREY, align=WD_ALIGN_PARAGRAPH.CENTER, after=2)
para(doc, f"Số: {SO}        Ngày phát hành: {NGAY}        Hiệu lực đến hết: {HET}", size=10.5, align=WD_ALIGN_PARAGRAPH.CENTER, after=8)

p = doc.add_paragraph(); r = p.add_run("Kính gửi: "); r.bold = True
r = p.add_run("CÔNG TY CỔ PHẦN MISA"); r.bold = True; r.font.color.rgb = NAVY
para(doc, "Công ty TNHH Dịch vụ Truyền thông Digito Combat (DigicomVN) trân trọng cảm ơn Quý công ty đã quan tâm. "
          "Theo trao đổi giữa hai bên, chúng tôi gửi báo giá chính thức cho gói dịch vụ Quý công ty đã thống nhất triển khai như sau:", after=4)

# --- 1. Bang gia
heading("1. Hạng mục và chi phí")
hdr = ["TT", "Hạng mục", "Quy cách", "ĐVT", "SL", "Đơn giá niêm yết (đ)", "Chiết khấu", "Đơn giá (đ)", "Thành tiền (đ)"]
W = [0.9, 3.6, 3.4, 1.2, 0.8, 1.9, 1.3, 1.95, 1.95]
tb = doc.add_table(rows=1, cols=len(hdr)); borders(tb); tb.alignment = WD_TABLE_ALIGNMENT.CENTER
for j, h in enumerate(hdr):
    cl = tb.rows[0].cells[j]; shade(cl, "1C2035"); cl.vertical_alignment = WD_CELL_VERTICAL_ALIGNMENT.CENTER
    para(cl, h, bold=True, size=9.5, color=RGBColor(255, 255, 255), align=WD_ALIGN_PARAGRAPH.CENTER, after=0)
sub = 0
for i, (hm, qc, dvt, sl, ny, ck, dg) in enumerate(ITEMS, 1):
    tt = sl * dg; sub += tt
    vals = [str(i), hm, qc, dvt, str(sl), vnd(ny) if ny else "-", ck or "-", vnd(dg), vnd(tt)]
    row = tb.add_row().cells
    for j, v in enumerate(vals):
        row[j].vertical_alignment = WD_CELL_VERTICAL_ALIGNMENT.CENTER
        al = WD_ALIGN_PARAGRAPH.LEFT if j in (1, 2) else (WD_ALIGN_PARAGRAPH.RIGHT if j >= 5 and j != 6 else WD_ALIGN_PARAGRAPH.CENTER)
        lines = v.split("\n")
        para(row[j], lines[0], size=9.5, align=al, after=0, bold=(j == 1))
        for ln in lines[1:]: para(row[j], ln, size=8.5, color=GREY, align=al, after=0, first=False)
vat = round(sub * 0.08); tong = sub + vat
for lab, val, strong in [("Cộng tiền dịch vụ (chưa VAT)", sub, False), ("Thuế GTGT 8%", vat, False), ("TỔNG CỘNG THANH TOÁN", tong, True)]:
    row = tb.add_row().cells; m = row[0].merge(row[7])
    para(m, lab, bold=True, size=10 if not strong else 10.5, align=WD_ALIGN_PARAGRAPH.RIGHT, after=0)
    para(row[8], vnd(val), bold=True, size=10 if not strong else 10.5, align=WD_ALIGN_PARAGRAPH.RIGHT, after=0)
    if strong:
        for cl in (m, row[8]): shade(cl, "E6F4F1")
widths(tb, W)
p = para(doc, "", after=2); p.paragraph_format.space_before = Pt(4)
r = p.add_run("Bằng chữ: "); r.bold = True
r = p.add_run(bang_chu(tong) + "."); r.italic = True

# --- 2. Pham vi
heading("2. Phạm vi và cách thức triển khai")
for b in [
    "Guest post: mỗi site 1 bài khoảng 1.000 từ, 3-5 ảnh; topaz.vn gắn 2 link nofollow, saigonreview.vn gắn 2 link dofollow. Nội dung bài do Bên mua cung cấp hoặc DigicomVN biên soạn theo yêu cầu (chi phí biên soạn báo giá riêng). Toà soạn site có quyền biên tập, duyệt nội dung trước khi đăng.",
    "Thời gian lên bài guest post và lịch chạy traffic được hai bên xác nhận bằng email hoặc tin nhắn khi Bên mua gửi nội dung và trang đích.",
    "Traffic user: tổng giá trị 5.000.000 đ (chưa VAT); Bên mua chọn một hoặc kết hợp nhiều gói ở Phụ lục, số lượt quy đổi theo đơn giá từng gói. Lượt truy cập chia đều theo ngày và khung giờ, trang đích do Bên mua chọn (có thể là chính 2 bài guest post).",
    "Số lượt truy cập được đối soát trên Google Analytics 4 của website đích; lượt thiếu được chạy bù trong tháng triển khai.",
    "Nguồn traffic là người dùng thật tại Việt Nam thực hiện nhiệm vụ truy cập theo yêu cầu, không phải khách có nhu cầu mua. Dịch vụ giúp tăng lượt truy cập và thời gian trên trang; DigicomVN không cam kết thứ hạng từ khoá, đơn hàng hay chuyển đổi. Không áp dụng cho website đặt quảng cáo Google AdSense hoặc mạng quảng cáo trả tiền theo lượt xem, lượt bấm.",
    "Bàn giao: link bài đăng của từng site và báo cáo số lượt traffic sau khi hoàn thành.",
]:
    p = doc.add_paragraph(style="List Bullet"); r = p.add_run(b); r.font.size = Pt(10.5)
    p.paragraph_format.space_after = Pt(2)

# --- 3. Thanh toan
heading("3. Điều khoản thanh toán")
for b in [
    "Bên mua thanh toán 100% giá trị đơn hàng trước khi DigicomVN triển khai, bằng chuyển khoản.",
    "Chủ tài khoản: CONG TY TNHH DVTT DIGITO COMBAT - Số tài khoản: 567898838 - Ngân hàng TMCP Quân đội (MB Bank).",
    f"Nội dung chuyển khoản: {SO} + Tên công ty Bên mua.",
    "DigicomVN xuất hoá đơn GTGT điện tử theo thông tin Bên mua cung cấp ở mục 5.",
]:
    p = doc.add_paragraph(style="List Bullet"); r = p.add_run(b); r.font.size = Pt(10.5); p.paragraph_format.space_after = Pt(2)

# --- 4. Hieu luc
heading("4. Hiệu lực báo giá")
para(doc, f"Báo giá có hiệu lực 7 ngày, từ {NGAY} đến hết {HET}. Sau thời hạn này, giá có thể thay đổi theo chính sách của site; "
          "DigicomVN sẽ xác nhận lại giá trước khi nhận đơn. Báo giá có chữ ký, đóng dấu của hai bên được dùng làm căn cứ đặt hàng và thanh toán.", size=10.5)

# --- 5. Thong tin ben mua
heading("5. Thông tin xuất hoá đơn của Bên mua")
tk = doc.add_table(rows=0, cols=2); borders(tk)
for lab in ["Tên công ty", "Mã số thuế", "Địa chỉ", "Người đại diện, chức vụ", "Email nhận hoá đơn", "Người liên hệ, điện thoại"]:
    row = tk.add_row().cells; shade(row[0], "F3F6F9")
    para(row[0], lab, bold=True, size=10, after=0)
    para(row[1], "CÔNG TY CỔ PHẦN MISA" if lab == "Tên công ty" else "", size=10, after=0)
    row[1].paragraphs[0].paragraph_format.space_before = Pt(5)
widths(tk, [5, 12])

# --- Chu ky
p = doc.add_paragraph(); p.paragraph_format.space_before = Pt(14)
sg = doc.add_table(rows=1, cols=2); noborders(sg); widths(sg, [8.5, 8.5])
for cl, a, b2, name in [(sg.cell(0, 0), "XÁC NHẬN CỦA BÊN MUA", "(Đồng ý đặt hàng theo báo giá này)", ""),
                         (sg.cell(0, 1), "ĐẠI DIỆN DIGICOMVN", "GIÁM ĐỐC", "Đỗ Xuân Hiếu")]:
    para(cl, a, bold=True, size=11, color=NAVY, align=WD_ALIGN_PARAGRAPH.CENTER, after=0)
    para(cl, b2, italic=(not name), bold=bool(name), size=10, align=WD_ALIGN_PARAGRAPH.CENTER, after=0, first=False)
    para(cl, "(Ký, ghi rõ họ tên, đóng dấu)", italic=True, size=9.5, color=GREY, align=WD_ALIGN_PARAGRAPH.CENTER, after=0, first=False)
    for _ in range(4): para(cl, "", after=0, first=False)
    para(cl, name, bold=True, size=11, align=WD_ALIGN_PARAGRAPH.CENTER, after=0, first=False)

# --- Phu luc
doc.add_page_break()
para(doc, "PHỤ LỤC: ĐƠN GIÁ VÀ SỐ LƯỢT QUY ĐỔI GÓI TRAFFIC USER 5.000.000 Đ", bold=True, size=12.5, color=NAVY, align=WD_ALIGN_PARAGRAPH.CENTER, after=2)
para(doc, f"Kèm báo giá số {SO}. Đơn giá chưa gồm VAT 8%. Bên mua chọn một gói hoặc chia ngân sách cho nhiều gói; số lượt làm tròn xuống.",
     italic=True, size=10, color=GREY, align=WD_ALIGN_PARAGRAPH.CENTER, after=6)
h2 = ["TT", "Gói", "Nguồn truy cập", "Thời gian trên trang", "Đơn giá (đ/lượt)", "Số lượt nếu dùng cả 5.000.000 đ"]
tp = doc.add_table(rows=1, cols=len(h2)); borders(tp); tp.alignment = WD_TABLE_ALIGNMENT.CENTER
for j, h in enumerate(h2):
    cl = tp.rows[0].cells[j]; shade(cl, "1C2035"); cl.vertical_alignment = WD_CELL_VERTICAL_ALIGNMENT.CENTER
    para(cl, h, bold=True, size=9.5, color=RGBColor(255, 255, 255), align=WD_ALIGN_PARAGRAPH.CENTER, after=0)
for i, (g, n, tg, dg) in enumerate(TRAFFIC, 1):
    row = tp.add_row().cells
    for j, v in enumerate([str(i), g, n, tg, vnd(dg), vnd(5000000 // dg)]):
        al = WD_ALIGN_PARAGRAPH.LEFT if j in (1,) else (WD_ALIGN_PARAGRAPH.RIGHT if j >= 4 else WD_ALIGN_PARAGRAPH.CENTER)
        para(row[j], v, size=10, align=al, after=0)
widths(tp, [1.1, 4.9, 2.8, 3.3, 2.3, 2.6])
para(doc, "", after=2)
for b in [
    "Nguồn chất lượng cao: học sinh, sinh viên, mỗi người 5-10 lượt/tháng nên tệp đa dạng, phù hợp từ khoá cạnh tranh.",
    "Nguồn tiêu chuẩn: người dùng điện thoại, mỗi người 5-7 lượt/tuần, phù hợp chạy đều dài hạn.",
    "Gói bấm thêm 1 liên kết: người dùng vào trang đích rồi bấm sang 1 trang khác cùng website (2 trang/phiên).",
]:
    p = doc.add_paragraph(style="List Bullet"); r = p.add_run(b); r.font.size = Pt(10); p.paragraph_format.space_after = Pt(2)

# footer
fp = sec.footer.paragraphs[0]; fp.alignment = WD_ALIGN_PARAGRAPH.CENTER
r = fp.add_run(f"DigicomVN - Báo giá số {SO} - Hotline 0988 769 317 - sales@digicomvn.com"); r.font.size = Pt(8.5); r.font.color.rgb = GREY

doc.save(OUT)
print(OUT, "sub", sub, "vat", vat, "tong", tong, bang_chu(tong))
