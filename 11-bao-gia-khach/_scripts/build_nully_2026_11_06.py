# Bao gia PR 6 bao lon - Cong ty TNHH Nully Viet Nam (Han Quoc, giai tri - giao duc - thuong mai, nullylab.com), chi Mai, 05/11/2026.
# Khach can: don gia/bai, nhan hien thi, viet/bien tap, so tu/anh, chen link, thoi gian luu bai, thoi gian len bai, link mau, goi de xuat cho DN Han.
# Lam lai 06/11: he so moi 05/11 toi - DanaSEO = gia DanaSEO bao x1,05 (von x0,9); NCC khac = von x1,15. Bo sheet Goi de xuat (rule bao-gia muc 5). Moi bao lay phuong an re nhat cung quy cach.
import math, random, json, sys
sys.path.insert(0, "/Volumes/Extreme SSD/Projects/digicom/11-bao-gia-khach/_scripts")
from openpyxl import Workbook
from openpyxl.styles import Font, PatternFill, Alignment
src = open("/Volumes/Extreme SSD/Projects/digicom/11-bao-gia-khach/_scripts/build_kpop_khanh_linh_2026_11_05.py").read().split("\nTRANS = 500000")[0]
g = {}; exec(src, g)
banner, table, notes, info_sheet, F, BD = g["banner"], g["table"], g["notes"], g["info_sheet"], g["F"], g["BD"]
OUT = "/Volumes/Extreme SSD/Projects/digicom/11-bao-gia-khach/"
NAME = "Bao-Gia-PR-6-Bao-Lon-Nully-Viet-Nam-2026-11-06.xlsx"; NOIBO = "NOIBO-" + NAME
g["ISSUE"], g["EXP"] = "06/11/2026", "13/11/2026"
TO = "Kính gửi: Chị Mai - Công ty TNHH Nully Việt Nam (nullylab.com)"
INFO = json.load(open(sys.argv[1])) if len(sys.argv) > 1 else {}
LBL = INFO.get("labels", {}); SAMP = INFO.get("samples", {})
RS, DN, GC = "Rise Media 05/11 (x1,15)", "DanaSEO 05/11 (bán = giá DanaSEO báo x1,05, vốn x0,9)", "Goodcom tab 31.10 hết hạn 10/11 (x1,15)"
# key: (nhom, bao, vi_tri, quy_cach, link, luu_bai, gia_von, nguon, gia_ban_co_dinh)
M = "Bảng chính - 6 đầu báo quý khách yêu cầu (mục Giải trí / Làm đẹp / Sao)"
B = {
 "vne": (M, "VnExpress.net", "Tiểu mục Giải trí (hoặc Sức khoẻ - Làm đẹp, Đời sống)", "Khoảng 1.000 từ, 3 ảnh", "Theo duyệt toà soạn, thường không chèn link; cần link chọn mục Doanh nghiệp viết (sheet 2)", "Không cam kết thời hạn cố định (toà soạn không công bố). Cần thời hạn ghi rõ: mục Doanh nghiệp viết 6 tháng / 2 năm / không thời hạn (sheet 2)", 9900000, RS, None),
 "dt":  (M, "Dantri.com.vn", "Tiểu mục Giải trí / Đời sống (nhóm 1)", "Tối đa 1.000 từ, 5 ảnh", "Không kèm link miễn phí; thêm 1 link: 550.000đ, 3 link: 1.100.000đ (nofollow, không nhận link mạng xã hội)", "Lưu trên báo theo chính sách toà soạn, không gỡ sau đăng", 8850000, RS, None),
 "tt":  (M, "Tuoitre.vn", "Trang cấp 2 của chuyên mục Giải trí (nhóm 3)", "Khoảng 1.000 chữ, 5 ảnh", "Không chèn link (toà soạn có thể giữ link dạng chữ, không bấm được)", "Lưu trên báo theo chính sách toà soạn, không gỡ sau đăng", 11550000, RS, None),
 "tn":  (M, "Thanhnien.vn", "Chuyên mục con Giải trí / Giới trẻ / Văn hoá (nhóm 2)", "1.000 từ, tối đa 5 ảnh; tiêu đề tối đa 17 chữ, sapo tối đa 48 chữ", "2 link (nofollow); thêm link: 550.000đ/link", "Lưu trên báo theo chính sách toà soạn, không gỡ sau đăng", 3900000, RS, None),
 "k14": (M, "Kenh14.vn", "Tiểu mục Sao / Âm nhạc / Phim / Học đường", "Dưới 1.000 từ, dưới 7 ảnh", "1 link (nofollow); thêm link: 300.000đ/link", "Lưu trên báo theo chính sách toà soạn, không gỡ sau đăng", 3330000, DN, 3700000),
 "vtv": (M, "Vtv.vn", "Chuyên mục phù hợp (Văn hoá - Giải trí, Đời sống)", "1.000 từ, tối đa 5 ảnh; tiêu đề tối đa 11 từ, sapo tối đa 40 từ", "Không kèm link; thêm 1 link: 3.300.000đ", "Lưu trên báo theo chính sách toà soạn, không gỡ sau đăng", 4740000, RS, None),
}
A = "A. Vị trí khác trên 6 báo (nổi bật hơn hoặc kèm link)"
C = "B. Báo giải trí, làm đẹp, giới trẻ phù hợp doanh nghiệp Hàn Quốc"
S = {
 "vnedn6": (A, "VnExpress.net", "Mục Doanh nghiệp viết - lưu 6 tháng", "1.000 từ, 3 ảnh; tiêu đề 14 từ, sapo 32 từ", "2-3 link (nofollow)", "6 tháng", 6600000, RS, None),
 "vnedn2": (A, "VnExpress.net", "Mục Doanh nghiệp viết - lưu 2 năm", "1.000 từ, 3 ảnh", "2-3 link (nofollow)", "2 năm", 9900000, RS, None),
 "vnednv": (A, "VnExpress.net", "Mục Doanh nghiệp viết - không thời hạn", "1.000 từ, 3 ảnh", "2-3 link (nofollow)", "Không thời hạn", 13200000, RS, None),
 "nsv":   (A, "Ngoisao.vnexpress.net (chuyên trang giải trí của VnExpress)", "Mục Thương trường", "1.000 từ, 3 ảnh", "Theo duyệt toà soạn", "Lưu trên báo theo chính sách toà soạn", 3650000, GC, None),
 "tt2":   (A, "Tuoitre.vn", "Chuyên mục Giải trí (trang chính, nhóm 2)", "Khoảng 1.000 chữ, 5 ảnh", "Không chèn link", "Lưu trên báo theo chính sách toà soạn", 15400000, RS, None),
 "ttcb":  (A, "Tuoitre.vn", "Chuyên mục Cần biết (chỉ nhận PR doanh nghiệp)", "Khoảng 1.000 chữ, 5 ảnh", "Không chèn link", "Lưu trên báo theo chính sách toà soạn", 4690000, RS, None),
 "tn1":   (A, "Thanhnien.vn", "Chuyên mục con Đời sống / Tiêu dùng (nhóm 1)", "1.000 từ, tối đa 5 ảnh", "2 link (nofollow)", "Lưu trên báo theo chính sách toà soạn", 4680000, RS, None),
 "k14bf": (A, "Kenh14.vn", "Beauty & Fashion (Làm đẹp, Thời trang)", "Dưới 1.000 từ, dưới 7 ảnh", "1 link (nofollow)", "Lưu trên báo theo chính sách toà soạn", 6120000, DN, 6800000),
 "k14x":  (A, "Kenh14.vn", "Xem - Ăn - Chơi", "Dưới 1.000 từ, dưới 7 ảnh", "1 link (nofollow)", "Lưu trên báo theo chính sách toà soạn", 5490000, DN, 6100000),
 "vtv6":  (A, "Vtv.vn", "Vị trí nổi bật chuyên mục", "1.000 từ, tối đa 5 ảnh", "Thêm 1 link: 3.300.000đ", "Lưu trên báo theo chính sách toà soạn", 9480000, RS, None),
 "ss":    (C, "Saostar.vn", "Chuyên mục Sao / Âm nhạc / Làm đẹp", "Khoảng 1.000 từ, 3 ảnh", "Theo duyệt toà soạn", "Lưu trên báo theo chính sách toà soạn", 2800000, RS, None),
 "ns":    (C, "Ngoisao.vn", "Chuyên mục phù hợp", "Khoảng 1.000 từ, 3 ảnh", "Theo duyệt toà soạn", "Lưu trên báo theo chính sách toà soạn", 2280000, RS, None),
 "2s":    (C, "2sao.vn", "Chuyên mục (top 6-11)", "Khoảng 1.000 từ, 3 ảnh", "Theo duyệt toà soạn", "Lưu trên báo theo chính sách toà soạn", 2010000, RS, None),
 "afa":   (C, "Afamily.vn", "Chuyên mục Làm đẹp / Đời sống", "Khoảng 1.000 từ, 3 ảnh", "Theo duyệt toà soạn", "Lưu trên báo theo chính sách toà soạn", 3040000, RS, None),
 "eva":   (C, "Eva.vn", "Bài hot tiểu mục (Làm đẹp, Thời trang)", "Dưới 1.000 từ, dưới 5 ảnh", "Theo duyệt toà soạn", "Đính bài hot 2 giờ, sau đó lưu trong mục", 3330000, DN, 3700000),
 "yan":   (C, "Yan.vn", "Chuyên mục phù hợp", "Dưới 1.000 từ, dưới 3 ảnh", "Theo duyệt toà soạn", "Lưu trên báo theo chính sách toà soạn", 4050000, DN, 4500000),
 "vtc":   (C, "Vtcnews.vn", "Chuyên mục Trẻ", "Khoảng 1.000 từ, 3 ảnh", "Theo duyệt toà soạn", "Lưu trên báo theo chính sách toà soạn", 2800000, RS, None),
 "hht":   (C, "Hoahoctro.tienphong.vn", "Chuyên mục phù hợp", "1.000 từ, 3 ảnh", "Theo duyệt toà soạn", "Lưu trên báo theo chính sách toà soạn", 2100000, GC, None),
}
random.seed(202611063); P = {}
for k, r in list(B.items()) + list(S.items()):
    sell = int(math.ceil(round(r[8] * 1.05) / 1000) * 1000) if r[8] else int(math.ceil(round(r[6] * 1.15) / 1000) * 1000)
    ck = random.choice(range(20, 30)); ny = int(round(sell / (1 - ck / 100) / 10000) * 10000)
    P[k] = r[:8] + (sell, ck, ny)

HD = ["STT", "Đầu báo", "Vị trí / chuyên mục", "Nhãn hiển thị trên bài", "Quy cách (số từ, ảnh)", "Chèn link website", "Thời gian lưu bài", "Giá niêm yết (đ)", "Chiết khấu", "Giá ưu đãi (đ/bài, chưa VAT)"]
W = [5, 20, 26, 28, 22, 28, 18, 14, 10, 16]
def rows_of(keys, grp):
    return [(grp, i, P[k][1], P[k][2], LBL.get(P[k][1].split(" ")[0], "Theo quy định toà soạn"), P[k][3], P[k][4], P[k][5], P[k][10], f"{P[k][9]}%", P[k][8]) for i, k in enumerate(keys, 1)]

wb = Workbook(); ws = wb.active; ws.title = "Bảng giá 6 báo"; ws.sheet_properties.tabColor = "0E8C7F"
r = banner(ws, len(HD), "BÁO GIÁ ĐĂNG BÀI PR TRÊN 6 BÁO ĐIỆN TỬ LỚN - LĨNH VỰC GIẢI TRÍ, LÀM ĐẸP", "1C2035", to=TO)
r = table(ws, r, HD, rows_of(list(B), M), W, [8, 10], "0E8C7F")
sub = sum(P[k][8] for k in B)
for lab, val, bold in (("Tổng 6 bài (mỗi báo 1 bài) - chưa VAT", sub, False), ("Thuế VAT 8%", round(sub * 0.08), False), ("Tổng thanh toán - đã gồm VAT 8%", sub + round(sub * 0.08), True)):
    ws.merge_cells(start_row=r, start_column=1, end_row=r, end_column=9)
    a = ws.cell(r, 1, lab); a.font = F(bold=True); a.alignment = Alignment(horizontal="right")
    c = ws.cell(r, 10, val); c.number_format = "#,##0"; c.font = F(bold=bold, color="0E8C7F" if bold else "000000"); c.border = BD; r += 1
notes(ws, r + 1, len(HD), ["Ghi chú:",
 "- Giá đã gồm viết bài theo văn phong báo chí và biên tập theo yêu cầu của từng toà soạn. Quý khách gửi thông tin, ảnh; nội dung tiếng Hàn hoặc tiếng Anh được dịch miễn phí.",
 "- Mỗi báo đăng 1 bài riêng: Digicom viết lại tiêu đề, sapo và cách triển khai cho từng báo để toà soạn duyệt và không trùng lặp nội dung.",
 "- Thời gian: 1-2 ngày làm việc để Digicom hoàn thiện bài và gửi quý khách duyệt; sau khi quý khách duyệt, toà soạn duyệt và đăng trong 2-3 ngày làm việc. Tổng thời gian thường 3-5 ngày làm việc.",
 "- Chuyên mục cụ thể (Giải trí, Làm đẹp, Sao...) do toà soạn xếp theo nội dung bài. Toà soạn có quyền biên tập tiêu đề, sapo, nội dung và yêu cầu tư liệu xác minh.",
 "- Link chèn trong bài báo điện tử ở dạng nofollow. Bài vượt số từ, số ảnh có thể phát sinh phụ phí; Digicom xác nhận trước khi đặt.",
 "- Ưu đãi: đặt trọn 6 báo được tặng thêm 1 bài trên Saostar.vn hoặc Ngoisao.vn (lựa chọn trong sheet Gợi ý).",
 "- Sheet \"Vị trí khác, báo gợi ý\": vị trí nổi bật hơn, mục kèm link, thời hạn lưu bài cố định, và các báo giải trí, làm đẹp khác phù hợp doanh nghiệp Hàn Quốc."])

ws = wb.create_sheet("Vị trí khác, báo gợi ý"); ws.sheet_properties.tabColor = "0E8C7F"
r = banner(ws, len(HD), "VỊ TRÍ KHÁC TRÊN 6 BÁO VÀ CÁC BÁO GIẢI TRÍ, LÀM ĐẸP GỢI Ý THÊM", "1C2035", to=TO)
rows = []
for gname in (A, C): rows += rows_of([k for k in S if S[k][0] == gname], gname)
r = table(ws, r, HD, rows, W, [8, 10], "0E8C7F")
notes(ws, r + 1, len(HD), ["Ghi chú:",
 "- VnExpress mục Doanh nghiệp viết: bài có thời hạn lưu cố định (6 tháng, 2 năm hoặc không thời hạn) và được chèn 2-3 link về website - phù hợp khi cần link về nullylab.com.",
 "- Nhóm B: báo giải trí, làm đẹp, giới trẻ có lượng độc giả trẻ lớn, quan tâm văn hoá Hàn Quốc; chi phí 2-4,5 triệu/bài, dùng để tăng số bài và độ phủ.",
 "- Giá chưa VAT 8%. Digicom xác nhận lịch trống và quy cách trước khi đặt."])

ws = wb.create_sheet("Trả lời yêu cầu"); ws.sheet_properties.tabColor = "0E8C7F"
ws.column_dimensions["A"].width = 30; ws.column_dimensions["B"].width = 100
c = ws.cell(1, 1, "Nội dung quý khách cần"); c.font = F(bold=True, color="FFFFFF"); c.fill = PatternFill("solid", fgColor="1C2035")
c = ws.cell(1, 2, "Trả lời của DigicomVN"); c.font = F(bold=True, color="FFFFFF"); c.fill = PatternFill("solid", fgColor="1C2035")
QA = [
 ("1. Đơn giá đăng bài", "Xem sheet \"Bảng giá 6 báo\": giá ưu đãi từng báo, đã gồm viết và biên tập bài, chưa VAT 8%."),
 ("2. Nhãn hiển thị (Quảng cáo, Tài trợ, Bài PR)", INFO.get("label_answer", "Theo Luật Quảng cáo, bài có nội dung quảng cáo trên báo phải được phân biệt với tin tức. Mỗi toà soạn ghi nhãn theo cách riêng (xem cột \"Nhãn hiển thị trên bài\").")),
 ("3. Viết bài, biên tập", "Có. Giá đã gồm: Digicom viết bài theo văn phong báo chí từ thông tin quý khách cung cấp, gửi quý khách duyệt, sau đó biên tập theo góp ý của toà soạn đến khi bài được đăng. Nội dung tiếng Hàn, tiếng Anh được dịch sang tiếng Việt miễn phí. Quý khách tự viết bài thì Digicom biên tập lại cho đúng chuẩn từng báo."),
 ("4. Độ dài, số ảnh", "Mỗi bài khoảng 800-1.000 từ, 3-7 ảnh tuỳ báo (cột \"Quy cách\"). Ảnh là ảnh thật, không chèn chữ, không ghép, không logo lớn; tiêu đề và sapo theo giới hạn số từ của từng báo."),
 ("5. Chèn link website", "Kenh14 (1 link) và Thanh Niên (2 link) đã gồm link. Dân Trí, VTV thêm link có phí (ghi trong bảng). Tuổi Trẻ không nhận link. VnExpress tiểu mục thường không chèn link; cần link về nullylab.com thì chọn mục Doanh nghiệp viết (2-3 link). Link trên báo điện tử ở dạng nofollow."),
 ("6. Thời gian lưu bài", "Bài đăng ở chuyên mục được lưu trên báo theo chính sách toà soạn, không bị gỡ sau khi đăng. Vị trí nổi bật (bài hot, trang chủ) chỉ giữ trong thời gian cam kết (ví dụ 2 giờ) rồi về chuyên mục. Riêng VnExpress: bài ở tiểu mục Giải trí/Làm đẹp không có cam kết thời hạn cố định, toà soạn không công bố; khi cần thời hạn ghi rõ, chọn mục Doanh nghiệp viết: 6 tháng (7.590.000đ), 2 năm (11.385.000đ) hoặc không thời hạn (15.180.000đ)."),
 ("7. Thời gian từ khi nhận nội dung đến khi đăng", "Digicom hoàn thiện bài và gửi quý khách duyệt trong 1-2 ngày làm việc. Sau khi quý khách duyệt, toà soạn duyệt và đăng trong 2-3 ngày làm việc. Tổng thường 3-5 ngày làm việc; có thể đặt ngày đăng cụ thể nếu báo trước tối thiểu 7 ngày."),
 ("8. Link bài mẫu", INFO.get("sample_answer", "Xem sheet \"Bài mẫu\".")),
 ("9. Đề xuất cho doanh nghiệp Hàn Quốc", "Xem sheet \"Vị trí khác, báo gợi ý\": nhóm B gồm các báo giải trí, làm đẹp, giới trẻ có độc giả quan tâm văn hoá Hàn Quốc (Saostar, Ngoisao, 2Sao, Afamily, Eva, Yan, VTC News, Hoa Học Trò), 2,3-4,7 triệu/bài. Cần link về nullylab.com: VnExpress mục Doanh nghiệp viết (2-3 link, lưu 6 tháng đến không thời hạn). Digicom tư vấn chọn báo theo ngân sách và nội dung bài, miễn phí."),
 ("10. Nghiệm thu, hoá đơn", "Digicom gửi link bài và ảnh chụp màn hình trong 24 giờ sau khi bài lên; cuối đợt có biên bản nghiệm thu tổng hợp link. Xuất hoá đơn điện tử GTGT 8% theo thông tin Công ty TNHH Nully Việt Nam."),
]
for i, (a, b) in enumerate(QA, 2):
    ca = ws.cell(i, 1, a); ca.font = F(bold=True, color="FFFFFF"); ca.fill = PatternFill("solid", fgColor="0E8C7F"); ca.alignment = Alignment(wrap_text=True, vertical="top")
    cb = ws.cell(i, 2, b); cb.font = F(); cb.alignment = Alignment(wrap_text=True, vertical="top")

if SAMP:
    ws = wb.create_sheet("Bài mẫu"); ws.sheet_properties.tabColor = "0E8C7F"
    for col, w in zip("ABCD", [5, 18, 60, 50]): ws.column_dimensions[col].width = w
    r = banner(ws, 4, "BÀI PR MẪU TRÊN CÁC BÁO - THAM KHẢO CÁCH TRÌNH BÀY, NHÃN HIỂN THỊ", "1C2035", to=TO)
    ws.merge_cells(start_row=r, start_column=1, end_row=r, end_column=4)
    c = ws.cell(r, 1, INFO.get("sample_note", "")); c.font = F(italic=True); c.alignment = Alignment(wrap_text=True); ws.row_dimensions[r].height = 46; r += 1
    for j, h in enumerate(["STT", "Báo", "Bài mẫu (bấm để mở)", "Ghi chú"], 1):
        c = ws.cell(r, j, h); c.font = F(bold=True, color="FFFFFF"); c.fill = PatternFill("solid", fgColor="0E8C7F"); c.border = BD
    r += 1; n = 1
    for bao, items in SAMP.items():
        for it in items:
            for j, v in enumerate((n, bao, it["title"], it.get("note", "")), 1):
                c = ws.cell(r, j, v); c.font = F(); c.border = BD; c.alignment = Alignment(wrap_text=True, vertical="top")
            ws.cell(r, 3).hyperlink = it["url"]; ws.cell(r, 3).font = F(color="1D4ED8", underline="single")
            r += 1; n += 1

ws2 = wb.create_sheet("Thông tin & Thanh toán"); ws2.sheet_properties.tabColor = "0E8C7F"; info_sheet(ws2, "0E8C7F")
wb.save(OUT + NAME)

wb = Workbook(); ws = wb.active; ws.title = "NOIBO giá vốn"; ws.sheet_properties.tabColor = "B91C1C"
hd = ["STT", "Đầu báo", "Vị trí", "Nguồn", "Giá vốn", "Giá bán", "Lãi", "Niêm yết hiển thị", "CK hiển thị"]
r = banner(ws, len(hd), "NOIBO - Báo giá PR 6 báo lớn Nully Việt Nam - 06/11/2026 (làm lại theo hệ số giá 05/11)", "7F1D1D", warn="FILE NỘI BỘ - TUYỆT ĐỐI KHÔNG GỬI KHÁCH")
rows = []
for gname in (M, A, C):
    for i, k in enumerate([k for k in P if P[k][0] == gname], 1):
        rows.append((gname, i, P[k][1], P[k][2], P[k][7], P[k][6], P[k][8], P[k][8] - P[k][6], P[k][10], f"{P[k][9]}%"))
r = table(ws, r, hd, rows, [5, 22, 34, 30, 13, 13, 12, 14, 9], [5, 6, 7, 8], "B91C1C")
cost = sum(P[k][6] for k in B)
notes(ws, r + 1, len(hd), [
 f"6 báo chính: vốn {cost:,.0f}, bán {sub:,.0f}, lãi {sub-cost:,.0f} chưa VAT; khách trả {sub+round(sub*0.08):,.0f} gồm VAT.",
 "Tặng 1 bài Saostar/Ngoisao.vn khi đặt trọn 6 báo: vốn 2,28-2,8tr, vẫn lãi dương trên tổng đơn.",
 "Rise không ghi quy cách VnExpress tiểu mục, Tuổi Trẻ nhóm 3 -> hỏi lại số từ/ảnh khi đặt. Thời gian lưu bài chuyên mục: chưa có văn bản NCC xác nhận, đã ghi 'theo chính sách toà soạn'; hỏi Rise/DanaSEO trước khi ký nếu khách cần cam kết. VnE tiểu mục: Rise không ghi thời hạn -> báo khách 'không cam kết thời hạn', cần vĩnh viễn thì bán DN viết không thời hạn (vốn 13,2tr).",
 "DanaSEO (Kenh14, Eva, Yan) theo sheet 05/11. Goodcom (Ngoisao VnExpress, Hoa Học Trò) báo giá hết hạn 10/11 - hỏi lại trước khi đặt.",
 "So NCC: VnE/DT/TT/TN/VTV Rise rẻ nhất sau hệ số (DanaSEO DT nhóm 1 11,03tr, MVN VTV 6,76tr, DanaSEO VTV 6,3tr); Kenh14 DanaSEO 3,885tr rẻ hơn MVN 4,14tr, Rise 4,37tr.",
 "Thời gian lên bài 3-5 ngày: theo thông lệ Rise/Fame (duyệt 1-2 ngày) + 1-2 ngày Digicom viết."] + INFO.get("noibo_notes", []))
wb.save(OUT + NOIBO)
print("ok", sub, sub + round(sub*0.08))
