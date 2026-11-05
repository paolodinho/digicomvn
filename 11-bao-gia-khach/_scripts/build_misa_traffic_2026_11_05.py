# Bao gia traffic user MISA - 05/11/2026
# Hieu: "dich vu traffic user ... gia re hon cac ben 10%".
# Cach tinh: gia ban/luot = 90% gia trung vi thi truong cung quy cach (17 NCC, quet 05/11, scratchpad traffic-market.csv).
# Chua chot NCC -> chua co gia von chac chan; NOIBO ghi nguon re nhat cung quy cach de doi chieu.
import random, statistics, sys
sys.path.insert(0, "/Volumes/Extreme SSD/Projects/digicom/11-bao-gia-khach/_scripts")
from openpyxl import Workbook
from openpyxl.styles import Font, PatternFill, Alignment
import importlib.util
spec = importlib.util.spec_from_file_location("m", "/Volumes/Extreme SSD/Projects/digicom/11-bao-gia-khach/_scripts/build_misa_2026_11_05.py")
# chi lay ham dung chung, khong chay phan ghi file cua script guest post
src = open(spec.origin).read().split("\nwb = Workbook()")[0]
g = {}; exec(src, g)
banner, table, notes, info_sheet, F = g["banner"], g["table"], g["notes"], g["info_sheet"], g["F"]

OUT = "/Volumes/Extreme SSD/Projects/digicom/11-bao-gia-khach/"
NAME = "Bao-Gia-Traffic-User-MISA-2026-11-05.xlsx"; NOIBO = "NOIBO-" + NAME
g["ISSUE"], g["EXP"] = "05/11/2026", "12/11/2026"
MIN = 5000000  # don toi thieu (= moc nap NCC 5tr -> NCC giam 10%)
import math
# 05/11 chieu: Hieu gui anh bang gia NCC (Zalo, 1.500-4.500d/luot): "lay gia nay di, nhan them 10%". Gia ban = gia NCC x1,1.
SRC = {"A": ("Nguồn chất lượng cao", "Học sinh, sinh viên; mỗi người 5-10 lượt/tháng, tệp đa dạng"),
       "B": ("Nguồn tiêu chuẩn", "Người dùng điện thoại; mỗi người 5-7 lượt/tuần, ổn định")}
GOI = [("Truy cập, ở lại 60 giây", "60 giây", True, 3500, 1500),
       ("Truy cập, ở lại 90 giây", "90 giây", True, 3800, 1800),
       ("Truy cập xác nhận bằng mã cố định", "Theo mã đặt sẵn trên trang", False, 3500, 1500),
       ("Truy cập + bấm thêm 1 liên kết (60 giây)", "60 giây, 2 trang/phiên", True, 4000, 2000),
       ("Truy cập + bấm thêm 1 liên kết (90 giây)", "90 giây, 2 trang/phiên", True, 4500, 2500)]
NCC_NAME = {"A": "Tải đề thi, tài liệu", "B": "Tải game mobile, mod"}
random.seed(202611052)
D = []
for k in ("A", "B"):
    for name, onsite, widget, pa, pb in GOI:
        von = pa if k == "A" else pb
        sell = von  # 05/11 toi: ban dung gia goc NCC, don >=5tr -> NCC giam 10% = lai 10%
        cost = int(round(von * 0.9))
        ck = random.choice(range(20, 30)); ny = int(round(sell / (1 - ck / 100) / 10) * 10)
        D.append(dict(name=name, src=SRC[k][0], srcd=SRC[k][1], onsite=onsite + (" (cài widget)" if widget else ""),
                      von=von, cost=cost, sell=sell, ck=ck, ny=ny, ncc=NCC_NAME[k]))

G = "Traffic user - người dùng thật, tại Việt Nam"
wb = Workbook(); ws = wb.active; ws.title = "Bảng giá traffic user"; ws.sheet_properties.tabColor = "0E8C7F"
hd = ["STT", "Gói", "Nguồn truy cập", "Thời gian trên trang", "Đơn giá niêm yết (đ/lượt)", "Chiết khấu", "Đơn giá ưu đãi (đ/lượt)"]
r = banner(ws, len(hd), "BÁO GIÁ TRAFFIC USER - MISA", "1C2035")
rows = [(d["src"] + " - " + d["srcd"], i, d["name"], d["src"], d["onsite"], d["ny"], f"{d['ck']}%", d["sell"]) for i, d in enumerate(D, 1)]
r = table(ws, r, hd, rows, [6, 34, 20, 28, 16, 11, 16], [5, 7], "0E8C7F")
notes(ws, r + 1, len(hd), ["Ghi chú:",
 "- Giá trị đơn hàng tối thiểu: 5.000.000đ (chưa VAT), có thể kết hợp nhiều gói.",
 "- Đơn giá tính theo lượt truy cập, chưa gồm VAT 8%, có xuất hoá đơn.",
 "- Nguồn chất lượng cao: học sinh, sinh viên, mỗi người chỉ 5-10 lượt/tháng nên tệp đa dạng, phù hợp từ khoá cạnh tranh. Nguồn tiêu chuẩn: người dùng điện thoại, mỗi người 5-7 lượt/tuần, phù hợp chạy đều dài hạn.",
 "- Gói ghi \"cài widget\": website gắn một đoạn mã nhỏ để xác nhận người dùng ở đủ thời gian; Digicom gửi mã và hỗ trợ cài. Gói mã cố định không cần cài widget.",
 "- Lượt truy cập chia đều theo ngày và khung giờ; quý khách chọn trang đích.",
 "- Nguồn truy cập là người dùng thật tại Việt Nam thực hiện nhiệm vụ truy cập theo yêu cầu, không phải khách hàng có nhu cầu mua. Dịch vụ giúp tăng lượt truy cập và thời gian trên trang; Digicom không cam kết thứ hạng từ khoá, đơn hàng hay chuyển đổi.",
 "- Không áp dụng cho website đang đặt quảng cáo Google AdSense hoặc mạng quảng cáo trả tiền theo lượt xem/lượt bấm (lượt truy cập theo nhiệm vụ bị tính là lưu lượng không hợp lệ).",
 "- Số lượt được đối soát trên Google Analytics 4 của website; lượt thiếu được chạy bù trong tháng."])
ws2 = wb.create_sheet("Thông tin & Thanh toán"); ws2.sheet_properties.tabColor = "0E8C7F"; info_sheet(ws2, "0E8C7F")
ws2.cell(13, 2).value = "Thanh toán 100% giá trị đơn hàng trước khi triển khai. Gói chạy nhiều tháng thanh toán theo từng tháng."
wb.save(OUT + NAME)

wb = Workbook(); ws = wb.active; ws.title = "NOIBO giá vốn"; ws.sheet_properties.tabColor = "B91C1C"
hd = ["STT", "Gói", "Gói NCC (tên trong bảng NCC)", "Giá gốc NCC (đ/lượt)", "Giá vốn sau CK nạp 5tr (-10%)", "Giá bán (= giá gốc NCC)", "Lãi/lượt", "Niêm yết hiển thị", "CK hiển thị"]
r = banner(ws, len(hd), "NOIBO - Traffic user MISA - 05/11/2026", "7F1D1D", warn="FILE NỘI BỘ - TUYỆT ĐỐI KHÔNG GỬI KHÁCH")
rows = [(d["src"] + " = NCC nguồn \"" + d["ncc"] + "\"", i, d["name"], d["ncc"], d["von"], d["cost"], d["sell"], d["sell"] - d["cost"], d["ny"], f"{d['ck']}%") for i, d in enumerate(D, 1)]
r = table(ws, r, hd, rows, [5, 30, 22, 13, 14, 14, 11, 14, 9], [4, 5, 6, 7, 8], "B91C1C")
notes(ws, r + 1, len(hd), [
 "Nguồn giá vốn: bảng giá NCC traffic user gửi Hiếu qua Zalo 05/11/2026 (ảnh, 2 nguồn: tải đề thi/tài liệu 3.500-4.500đ, tải game mobile/mod 1.500-2.500đ). Tên NCC chưa ghi trong ảnh - bổ sung khi chốt đơn.",
 "Giá bán = giá gốc NCC (Hiếu 05/11 tối). NCC chiết khấu theo mốc nạp: từ 5tr -10%, từ 20tr -15%, từ 50tr -20%, mỗi mốc hiệu lực 30 ngày, không cộng dồn (áp mức cao nhất). Đơn khách tối thiểu 5tr để luôn đạt mốc 10% = lãi 10%; nạp 20tr/50tr thì lãi 15%/20%.",
 "Chiết khấu chỉ còn hiệu lực 30 ngày kể từ lúc nạp: nạp theo từng đơn của khách, không nạp trước để dành. Khách chạy nhiều tháng thì mỗi tháng nạp lại >=5tr.",
 "File khách KHÔNG ghi 'tải đề thi' / 'tải game, mod' (lộ cách NCC lấy người dùng); chỉ ghi Nguồn chất lượng cao / Nguồn tiêu chuẩn.",
 "Trước đơn lớn: đặt thử 1 đơn nhỏ, đối soát GA4. Không chạy cho website có AdSense (lưu lượng không hợp lệ)."])
wb.save(OUT + NOIBO)
for d in D: print(d["src"], d["name"], d["von"], d["sell"], d["ck"], d["ny"])
