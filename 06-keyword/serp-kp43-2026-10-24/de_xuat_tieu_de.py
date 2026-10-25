# Ghi tab "KH từ khoá dịch vụ (KP 24/10)" vào file tổng quan digicom. Chạy lại = ghi đè tab (giữ gid, giữ cột Ý kiến Hiếu).
import json
from google.oauth2 import service_account
from googleapiclient.discovery import build
cfg=json.load(open("/Volumes/Extreme SSD/Projects/digicom/.claude/tong-quan.json"))
SID=cfg["sheet_id"]; TAB="KH từ khoá dịch vụ (KP 24/10)"
cr=service_account.Credentials.from_service_account_file(cfg["credentials"],scopes=["https://www.googleapis.com/auth/spreadsheets"])
sh=build("sheets","v4",credentials=cr,cache_discovery=False).spreadsheets()
B="https://digicomvn.com"
H=["Mã","Cụm (từ chính)","Từ khoá trong cụm (lượt tìm/tháng KP)","Google đang ưu tiên (top 10 thật, ẩn danh 24/10)","Người tìm muốn gì","Trang đích","Tiêu đề hiện tại","Tiêu đề đề xuất","Căn cứ (GSC 90 ngày, KP)","Hướng làm","Trạng thái","Ý kiến của Hiếu"]
R=[
["T1","Booking báo PR (book báo)","book báo chí 90 | book báo 70 | book báo pr 30 | booking bài pr 30 | agency booking báo chí 20 | dịch vụ booking báo chí 20 | book báo viết bài 20 | dịch vụ book báo 10 | book báo điện tử 10 (KP gộp 'booking ...' vào 'book ...')",
 "4 từ booking báo / book báo / booking báo pr / dịch vụ booking báo chí trùng 4-6 URL -> 1 cụm. 7/9 là trang DỊCH VỤ của agency. Tiêu đề top: 'Dịch vụ Booking Báo Chí...', 'Book Báo Điện Tử - Booking bài PR lên 1000+ Báo Giá Rẻ', 'Bảng Giá Book Báo Điện Tử...【2026】'; hay có số đầu báo, 'uy tín', 'giá rẻ', năm 2026.",
 "Thuê đơn vị đặt bài PR lên báo, xem ngay giá từng đầu báo.",
 B+"/booking-bao-pr/","Dịch Vụ Booking Báo Chí, Đăng Bài PR Uy Tín - Bảng Giá 2026 - DigicomVN (73 ký tự, bị cắt)",
 "Dịch Vụ Book Báo, Booking Báo Chí PR - Bảng Giá 2026 - DigicomVN",
 "GSC: dịch vụ booking báo chí 12 lượt hiện vị trí 28; booking báo online 11 / vị trí 14; booking báo chí 9 / vị trí 38; book báo pr 4 / vị trí 30. Tiêu đề hiện tại thiếu 'book báo' (biến thể lượt tìm cao nhất) và dài quá 60 ký tự.",
 "Đổi tiêu đề (cùng dạng trang, chỉ thêm 'book báo', giữ 'booking báo chí' và 'dịch vụ'). H1 giữ nguyên. Thêm 1 H2 'Book báo là gì, khác booking báo thế nào' (câu hỏi Suggest: book báo là gì 10, book bài là gì 50).","Chờ Hiếu duyệt",""],
["T2","Báo giá đăng bài PR","giá đăng bài trên báo 20 | bảng giá book báo 10 | giá book báo 10 | chi phí book báo 10 | chi phí book bài báo 10 | giá đăng bài pr 10",
 "'giá đăng bài pr' và 'báo giá đăng bài báo' trùng 6 URL -> 1 cụm, trùng < 3 với cụm T1 -> TÁCH riêng. Top là trang BẢNG GIÁ: bảng giá chính chủ của báo (baogia.24h.com.vn, banggia.thanhnien.vn, quangcao.tuoitre.vn) + bảng giá agency. Tiêu đề: 'Báo giá PR - Dân trí, VnExpress, Zing...', 'Bảng giá bài PR trên báo... 2026', 'Báo giá Đăng bài PR'.",
 "So giá đăng 1 bài PR trên từng báo trước khi quyết.",
 B+"/bao-gia-dang-bai-pr-theo-dau-bao/","Giá Booking Báo 2026: Báo Giá PR Theo Từng Đầu Báo - DigicomVN",
 "Báo Giá Đăng Bài PR 2026: Bảng Giá Từng Đầu Báo - DigicomVN",
 "GSC: chỉ 9 lượt hiện (báo giá viết bài pr vị trí 24, báo giá pr vnexpress vị trí 30) -> đổi tiêu đề rủi ro thấp. Tiêu đề hiện tại chưa có cụm 'đăng bài' mà 3/10 tiêu đề top có.",
 "Đổi tiêu đề; mở bài bằng bảng giá (top 10 đều mở bằng giá). Giữ trang này cho intent giá, trang T1 cho intent thuê dịch vụ, 2 trang link qua lại.","Chờ Hiếu duyệt",""],
["T3","Booking truyền hình","booking truyền hình (đo SERP) | công ty quảng cáo chương trình truyền hình 110 (chờ đo) | book quảng cáo truyền hình 10 | dịch vụ quảng cáo truyền hình 10",
 "Top 10 'booking truyền hình': 7/9 trang DỊCH VỤ agency. Tiêu đề: 'Báo giá dịch vụ booking truyền hình', 'Booking Quảng Cáo Truyền Hình' (3 trang), 'Dịch vụ booking TVC quảng cáo truyền hình', 'Booking Phóng sự truyền hình trọn gói 2026'.",
 "Thuê đơn vị đặt TVC/phóng sự trên VTV, HTV và biết giá.",
 B+"/booking-truyen-hinh/","Booking truyền hình - DigicomVN",
 "Booking Quảng Cáo Truyền Hình VTV, HTV: Báo Giá 2026 - DigicomVN",
 "GSC: trang chưa có lượt hiện nào (mới mở lại 24/10) -> đổi tiêu đề không mất gì. 4/9 tiêu đề top dùng đúng cụm 'booking quảng cáo truyền hình'.",
 "Đổi tiêu đề + H1. Thêm H2 phóng sự truyền hình doanh nghiệp (SERP 'làm phóng sự truyền hình doanh nghiệp' là trang báo giá phóng sự).","Chờ Hiếu duyệt",""],
["T4","Bảng giá quảng cáo truyền hình VTV","quảng cáo trên vtv 50 | giá quảng cáo trên vtv 30 | bảng giá quảng cáo truyền hình 10 | báo giá quảng cáo truyền hình 10 | chi phí quảng cáo trên vtv / vtv3 / htv 10 | giá quảng cáo giờ vàng trên vtv 10",
 "'bảng giá quảng cáo truyền hình' và 'giá quảng cáo trên vtv' trùng 4 URL, KHÔNG trùng cụm T3 -> trang riêng. Top là trang BẢNG GIÁ: bảng giá đài tự công bố (thvl.vn, vtv9.vtv.vn, huetv, dnrt) + agency '[Cập nhật] Bảng giá quảng cáo truyền hình VTV năm 2026'.",
 "Xem giá 1 spot quảng cáo theo kênh, khung giờ.",
 "Chưa có trang (viết mới)","-",
 "Bảng Giá Quảng Cáo Truyền Hình VTV 2026 Theo Khung Giờ - DigicomVN",
 "KP cụm ~150 lượt/tháng; T3 không đáp ứng được vì Google tách 2 intent.",
 "Viết mới bài bảng giá (số liệu từ 33 dòng giá truyền hình đã có + bảng giá đài công bố, ghi nguồn), link về /booking-truyen-hinh/.","Chờ Hiếu duyệt",""],
["T5","Quảng cáo radio, VOV Giao Thông","quảng cáo vov giao thông 50 | quảng cáo radio 40 | quảng cáo vov 20 | quảng cáo trên radio 20 | giá quảng cáo trên vov giao thông 10 | báo giá quảng cáo vov 10",
 "'giá quảng cáo radio' và 'bảng giá quảng cáo vov giao thông' trùng 3 URL: trang BẢNG GIÁ (radiovietnam.com.vn, quangcaovovgiaothong.com, brandcom 'Bảng giá quảng cáo VOV Giao Thông năm 2026').",
 "Đặt spot trên VOV Giao Thông/VOH, xem giá theo khung giờ.",
 B+"/quang-cao-phat-thanh/","Quảng cáo phát thanh - DigicomVN",
 "Quảng Cáo Radio VOV Giao Thông, VOH: Bảng Giá 2026 - DigicomVN",
 "GSC: trang chưa có lượt hiện. Từ có lượt tìm cao nhất nhóm là 'quảng cáo vov giao thông' 50 và 'quảng cáo radio' 40, cả 2 chưa có trong tiêu đề.",
 "Đổi tiêu đề + H1 (giữ slug). Mở bằng bảng giá VOV GT, VOH.","Chờ Hiếu duyệt",""],
["T6","Quảng cáo phát thanh là gì (kiến thức)","quảng cáo phát thanh 10 | quảng cáo trên đài phát thanh | các hình thức quảng cáo trên radio 10",
 "'quảng cáo phát thanh' và 'quảng cáo trên đài phát thanh' trùng 6 URL; top là BÀI KIẾN THỨC: 'Quảng cáo phát thanh là gì? Các hình thức...', 'Lợi ích và chi phí'.",
 "Hiểu quảng cáo phát thanh là gì, có những hình thức nào.",
 "/quang-cao-phat-thanh/ (H2) hoặc bài mới","-","(không đổi tiêu đề trang dịch vụ)",
 "Lượt tìm thấp (10-20), dạng bài khác trang dịch vụ.",
 "Không ép vào tiêu đề T5. Thêm H2 'Các hình thức quảng cáo trên đài phát thanh' vào trang T5; chỉ viết bài riêng nếu Hiếu muốn phủ kiến thức.","Kế hoạch",""],
["T7","Quảng cáo truyền hình / TVC là gì (kiến thức)","quảng cáo truyền hình 110 | quảng cáo tvc 90 (chờ đo) | quảng cáo tvc là gì 50 | quảng cáo trên truyền hình 50",
 "Top 'quảng cáo truyền hình': 6/8 BÀI KIẾN THỨC ('Quảng cáo truyền hình là gì? Các hình thức, lợi ích').",
 "Hiểu khái niệm, hình thức, chi phí.",
 "Chưa có trang","-","Quảng Cáo Truyền Hình Là Gì? Hình Thức, Chi Phí 2026 - DigicomVN",
 "KP 110 + 50; chưa có bài nào trên site.",
 "Viết mới bài kiến thức sau khi đo xong SERP 'quảng cáo tvc' (đang xếp hàng), link về T3 và T4.","Chờ đo SERP",""],
["T8","Booking báo tỉnh","(trang có sẵn, không có từ trong 43 lô)",
 "Trùng 3 URL với cụm T1 nhưng top có trang riêng 'Dịch Vụ Booking Báo Tỉnh' (seodo, solannseo).","Đặt bài trên báo địa phương.",
 B+"/booking-bao-tinh/","Booking Báo Tỉnh: Bảng Giá 22 Đầu Báo Địa Phương Thật 2026 - DigicomVN","Giữ nguyên",
 "Tiêu đề đã đúng dạng top 10.","Không đổi.","Đã xong",""],
["T9","Trang từng đầu báo (/book-bao-<tên>/)","book báo vnexpress 20 | giá book báo vnexpress 20 | báo giá đăng bài pr trên vnexpress / kenh14 10 ...",
 "Chưa đo xong (đang xếp hàng). GSC cho thấy người tìm gõ 'báo giá <tên báo>': báo giá dân trí 48 lượt hiện vị trí 9, báo giá znews vị trí 4, báo giá thanh niên vị trí 9, báo giá vietnamnet vị trí 8.",
 "Xem giá đăng bài trên 1 báo cụ thể.","/book-bao-dan-tri/, /book-bao-vnexpress/, ...","Book Báo <Tên>: Bảng Giá PR & Cách Đăng Bài 2026 - DigicomVN","Tạm giữ nguyên",
 "Tiêu đề đã có 'Bảng Giá PR'; các trang đang ở vị trí 4-10 -> không đổi khi chưa có SERP của 'báo giá <báo>'.",
 "Đo SERP 'báo giá <báo>' cho 5 báo có lượt hiện, nếu top dùng 'Báo giá' thì đề xuất lại.","Chờ đo SERP",""],
]
meta=sh.get(spreadsheetId=SID,fields="sheets.properties").execute()
gid=next((s["properties"]["sheetId"] for s in meta["sheets"] if s["properties"]["title"]==TAB),None)
old={}
if gid is None:
    r=sh.batchUpdate(spreadsheetId=SID,body={"requests":[{"addSheet":{"properties":{"title":TAB,"index":1,"gridProperties":{"frozenRowCount":3}}}}]}).execute()
    gid=r["replies"][0]["addSheet"]["properties"]["sheetId"]
else:
    v=sh.values().get(spreadsheetId=SID,range=f"'{TAB}'!A4:L200").execute().get("values",[])
    old={x[0]:x[11] for x in v if len(x)>11 and x[11]}
for x in R: x[11]=old.get(x[0],x[11])
top=[["Kế hoạch từ khoá trang dịch vụ - bộ KP 43 lô (24/10/2026) - CHỜ DUYỆT. Top 10 đo ẩn danh (Chrome không đăng nhập, IP Việt Nam). Cụm = trùng >= 3 URL top 10. Hiếu ghi duyệt vào cột L."],
     ["138 từ dài còn lại đang xếp hàng đo SERP (chạy tự động khi phiên ICD đo xong), có kết quả sẽ bổ sung cụm kiến thức + trang đầu báo."]]
sh.values().clear(spreadsheetId=SID,range=f"'{TAB}'!A1:L200").execute()
sh.values().update(spreadsheetId=SID,range=f"'{TAB}'!A1",valueInputOption="RAW",body={"values":top+[H]+R}).execute()
req=[{"repeatCell":{"range":{"sheetId":gid,"startRowIndex":2,"endRowIndex":3},"cell":{"userEnteredFormat":{"textFormat":{"bold":True,"foregroundColor":{"red":1,"green":1,"blue":1}},"backgroundColor":{"red":0.11,"green":0.13,"blue":0.21},"wrapStrategy":"WRAP"}},"fields":"userEnteredFormat"}},
     {"repeatCell":{"range":{"sheetId":gid,"startRowIndex":3,"endRowIndex":3+len(R)},"cell":{"userEnteredFormat":{"wrapStrategy":"WRAP","verticalAlignment":"TOP"}},"fields":"userEnteredFormat(wrapStrategy,verticalAlignment)"}},
     {"repeatCell":{"range":{"sheetId":gid,"startRowIndex":0,"endRowIndex":1},"cell":{"userEnteredFormat":{"textFormat":{"bold":True,"fontSize":12}}},"fields":"userEnteredFormat.textFormat"}},
     {"repeatCell":{"range":{"sheetId":gid,"startRowIndex":3,"endRowIndex":3+len(R),"startColumnIndex":7,"endColumnIndex":8},"cell":{"userEnteredFormat":{"textFormat":{"bold":True},"backgroundColor":{"red":1,"green":0.95,"blue":0.8},"wrapStrategy":"WRAP","verticalAlignment":"TOP"}},"fields":"userEnteredFormat"}}]
for i,w in enumerate([50,170,260,330,180,200,220,240,260,280,110,200]):
    req.append({"updateDimensionProperties":{"range":{"sheetId":gid,"dimension":"COLUMNS","startIndex":i,"endIndex":i+1},"properties":{"pixelSize":w},"fields":"pixelSize"}})
# link bấm được cho cột F
for i,x in enumerate(R):
    if x[5].startswith("http"):
        req.append({"updateCells":{"range":{"sheetId":gid,"startRowIndex":3+i,"endRowIndex":4+i,"startColumnIndex":5,"endColumnIndex":6},"rows":[{"values":[{"userEnteredValue":{"stringValue":x[5]},"textFormatRuns":[{"startIndex":0,"format":{"link":{"uri":x[5]}}}]}]}],"fields":"userEnteredValue,textFormatRuns"}})
sh.batchUpdate(spreadsheetId=SID,body={"requests":req}).execute()
for x in R: print(x[0],len(x[7]),x[7])
print("GID",gid)
