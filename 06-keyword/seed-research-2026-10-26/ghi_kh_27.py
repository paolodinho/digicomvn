# Ghi khối kế hoạch theo TRANG ĐÍCH cho 26 cụm đo thêm (27/10) xuống dưới tab KH. Chạy: /usr/bin/python3 ghi_kh_27.py [--dry]
import json, sys
from sheet_common import *
DRY = '--dry' in sys.argv
C = json.load(open('../serp-top10-2026-10-26/clusters.json'))
by = {x['loi']: x for x in C}
B = 'https://digicomvn.com/'
# (url, loại, hướng làm, trạng thái, [cụm lõi...])
PLAN = [
 ('booking-kol-la-gi/', 'Bài mới', 'Viết mới: định nghĩa + quy trình + hợp đồng + nghĩa vụ pháp lý (đang viết 27/10)', 'Đang viết', ['booking kol la gì']),
 ('gia-booking-kol/', 'Bài mới', 'Viết mới: yếu tố quyết định giá + công thức + khung giá tham khảo có nguồn, không nêu giá Digicom (đang viết 27/10)', 'Đang viết', ['giá booking kols', 'giá booking kol tiktok']),
 ('micro-kol-la-gi/', 'Bài mới', 'Viết mới: ngưỡng follower, ưu nhược, cách thẩm định (đang viết 27/10)', 'Đang viết', ['micro kol là gì']),
 ('pr-va-quang-cao-khac-nhau/', 'Bài mới', 'Viết mới thay vì thêm H2 vào bai-pr-la-gi (cụm 250 lượt, top 10 là bài so sánh riêng); bai-pr-la-gi giữ, link sang (đang viết 27/10)', 'Đang viết', ['quảng cáo pr là gì']),
 ('backlink-bao-chi/', 'Bài mới', 'Viết mới thay vì tối ưu mua-backlink-bao-la-gi (SERP "backlink báo chí" là bài hướng dẫn riêng); mua-backlink-bao-la-gi giữ, link sang (đang viết 27/10)', 'Đang viết', ['backlink báo chí']),
 ('pbn-la-gi/', 'Bài mới', 'Viết mới: PBN là gì + rủi ro theo chính sách spam Google; Digicom không bán PBN (chờ viết)', 'Kế hoạch', ['pbn backlinks']),
 ('bao-mang-dien-tu-la-gi/', 'Bài mới', 'Viết mới: định nghĩa theo Luật Báo chí 2016, phân biệt báo điện tử / trang thông tin điện tử (chờ viết)', 'Kế hoạch', ['báo mạng điện tử là gì']),
 ('social-entity-la-gi/', 'Bài mới', 'Viết mới (blog định nghĩa, 9/9 bài viết top 10); trang dịch vụ backlink-social-entity giữ làm money page (chờ viết)', 'Kế hoạch', ['social entity']),
 ('guest-post-la-gi/', 'Bài có sẵn', 'Tối ưu bài cũ: kiểm định nghĩa đầu bài + FAQ theo PAA (kho từ gán nhầm guest-post-forbes)', 'Kế hoạch', ['guest posts']),
 ('dich-vu-guest-post-gia-bao-nhieu/', 'Bài có sẵn', 'Tối ưu: tiêu đề có "dịch vụ guest post", mở bằng cách tính giá', 'Kế hoạch', ['dịch vụ guest post']),
 ('kol-la-gi/', 'Bài mới (đã hẹn giờ 30/10)', 'Thêm 1 H2 + FAQ "KOL và KOC khác nhau thế nào" sau khi bài lên (cụm 260 lượt, SERP riêng)', 'Kế hoạch', ['kol là gì koc là gì']),
 ('booking-kol-koc/', 'Trang dịch vụ có sẵn', 'Tối ưu trang dịch vụ: top 10 trộn trang dịch vụ + việc làm; bổ sung đoạn "dịch vụ booking KOC". Từ "nhân viên booking" là tìm việc: không làm', 'Kế hoạch', ['booking kol koc', 'dịch vụ booking koc', 'nhân viên booking kol koc']),
 ('domain-authority/', 'Bài có sẵn', 'Giữ, kiểm FAQ theo PAA', 'Kế hoạch', ['domain authority']),
 ('domain-rating/', 'Bài có sẵn', 'Giữ, kiểm FAQ theo PAA', 'Kế hoạch', ['domain rating']),
 ('seo-offpage-la-gi/', 'Bài có sẵn', 'Tối ưu: thêm từ "seo off page" (viết tách) vào H2/FAQ; top 10 toàn bài viết', 'Kế hoạch', ['seo off page']),
 ('mua-textlink-la-gi/', 'Bài có sẵn', 'Cùng URL với cụm "text link" ở trên, thêm "mua textlink" vào H2 + FAQ giá', 'Kế hoạch', ['mua textlink']),
 ('backlink/', 'Bài có sẵn', 'Cùng URL "backlink là gì", thêm "backlink seo" vào H2', 'Kế hoạch', ['backlink seo']),
 ('backlink-indexer/', 'Bài có sẵn', 'Giữ', 'Kế hoạch', ['backlink indexer']),
 ('backlink-dofollow-va-nofollow/', 'Bài có sẵn', 'Giữ, kiểm H2 trả lời "là gì"', 'Kế hoạch', ['dofollow và nofollow là gì']),
 ('mo-hinh-race-pr/', 'Bài có sẵn', 'Giữ (đang top 3)', 'Kế hoạch', ['mô hình race trong pr']),
 ('dich-vu-toplist/', 'Trang dịch vụ có sẵn', 'Giữ, kiểm tiêu đề có "dịch vụ toplist"', 'Kế hoạch', ['dịch vụ toplist']),
 ('backlink-quoc-te/', 'Trang dịch vụ có sẵn', 'Giữ (0 lượt, giữ vì có intent riêng)', 'Kế hoạch', ['backlink quốc tế']),
 ('booking-fanpage/', 'Trang dịch vụ có sẵn', 'Giữ; 10 lượt/tháng, chưa có bảng giá NCC', 'Kế hoạch', ['booking fanpage']),
 ('bao-gia-dang-bai-pr-theo-dau-bao/', 'Bài có sẵn', 'Cùng URL với các cụm giá đăng bài ở trên, thêm "đăng báo" + "giá book báo" vào H2', 'Kế hoạch', ['đăng báo']),
 (None, 'Chưa có trang', 'Hiếu quyết: chưa có trang dịch vụ "viết bài PR" (top 10 toàn trang dịch vụ, 9/10 tiêu đề có "dịch vụ"). Khuyến nghị: gộp vào /booking-bao-pr/ bằng 1 mục, không tách trang', 'Chờ Hiếu', ['dịch vụ viết bài pr']),
 (None, '(chưa gán: điều hướng / không làm)', 'Không làm: top 10 là trang chủ các báo giáo dục (tìm tên báo cụ thể)', 'Bỏ', ['báo điện tử giáo dục']),
]
rows = []
used = set()
for url, loai, huong, tt, keys in PLAN:
    cl = [by[k] for k in keys]; used |= set(keys)
    tot = sum(x['tong'] for x in cl)
    import collections
    dt = collections.Counter()
    for x in cl: dt.update(x['dang_trang'])
    head = ['N11-URL', (B + url) if url else '(chưa gán)', f'Tổng {tot}/tháng, {len(cl)} cụm SERP', ', '.join(f'{a} {b}' for a, b in dt.most_common()),
            '', loai, '', '', 'Top 10 đo ẩn danh 26-27/10', huong, tt, '']
    rows.append(('H', head))
    for x in cl:
        rows.append(('S', ['', '', ' | '.join(f'{a} {b}' for a, b in x['tu']), ' ; '.join(t[:70] for t in x['tieu_de'][:3]), '', 'cụm SERP: ' + x['loi']]))
left = [x['loi'] for x in C]
t = 'KH từ khoá dịch vụ (KP 24/10)'
sid = tabs(s := svc())[t]
cur = s.values().get(spreadsheetId=SID, range=f"'{t}'!A1:A400").execute().get('values', [])
start = 110
print('ghi từ dòng', start, '-', len(rows) + start, '| cụm chưa vào kế hoạch (đã có ở khối trên):', len([k for k in left if k not in used]))
if DRY: sys.exit()
title = f'Bổ sung 27/10: 26 cụm đo thêm (đo 72 từ ẩn danh, hết 10:32), xếp theo TRANG ĐÍCH. Tổng cộng đã đo 132 từ -> 65 cụm.'
fmt_h = {'wrapStrategy': 'WRAP', 'textFormat': {'fontSize': 14, 'bold': True}}
fmt_s = {'wrapStrategy': 'WRAP', 'textFormat': {'fontSize': 14}}
def cell(v, f, link=None):
    tf = dict(f['textFormat'])
    if link: tf['link'] = {'uri': link}
    return {'userEnteredValue': {'stringValue': v}, 'userEnteredFormat': {**f, 'textFormat': tf}}
rd = [{'values': [cell(title, {'textFormat': {'fontSize': 14, 'bold': True}})]}]
for k, r in rows:
    f = fmt_h if k == 'H' else fmt_s
    vs = []
    for i, v in enumerate(r + [''] * (13 - len(r))):
        vs.append(cell(v, f, v if (k == 'H' and i == 1 and v.startswith('http')) else None))
    rd.append({'values': vs})
s.batchUpdate(spreadsheetId=SID, body={'requests': [{'updateCells': {'range': {'sheetId': sid, 'startRowIndex': start - 1, 'startColumnIndex': 0, 'endColumnIndex': 13}, 'rows': rd, 'fields': 'userEnteredValue,userEnteredFormat'}}]}).execute()
json.dump({'start': start, 'n': len(rd)}, open('kh_27_written.json', 'w'))
print('xong', len(rd), 'dòng')
