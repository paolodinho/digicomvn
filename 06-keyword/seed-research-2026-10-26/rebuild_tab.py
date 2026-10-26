"""Dựng tab 'Từ khoá' (bố cục như ICD 26/10): khối CẦN XUẤT VOLUME chia nhóm 10 từ theo chủ đề, khối ĐÃ CÓ TRONG KEYWORD
PLANNER / KHO TỪ kèm volume, rồi 3 khối tham khảo (seed quét site + đối thủ, thực thể, từ volume lớn 26/10).
Chạy lại được: giữ dấu tick 'Đã xuất' theo từ. Dùng: bash run_batches.sh && /usr/bin/python3 rebuild_tab.py [--dry]"""
import collections, datetime
from sheet_common import *

DRY = '--dry' in sys.argv
s = svc(); kho = Kho(KW)
D = json.load(open(os.path.join(W, 'copy-vao-tool.json')))
SEEDS = json.load(open(os.path.join(W, 'seeds.json')))
ENT = json.load(open(os.path.join(W, 'entities.json')))
VOL = json.load(open(os.path.expanduser('~/Claude-Workspace/_backups/edits/2026-10-26/digicom/tabs/Từ volume lớn 26-10.json')))
ORD = ['Booking báo PR, đăng bài PR', 'Textlink', 'Guest post', 'Social entity', 'Backlink quốc tế', 'Toplist', 'Backlink, off-page',
       'Truyền hình, TVC', 'Phát thanh, radio', 'KOL, KOC, fanpage', 'Booking quảng cáo chung', 'Khác']

need = collections.defaultdict(list)
for L in D['lots']:
    g, _, h = L['chu_de'].rpartition(' - ')
    for r in L['tu']:
        if kho.co_volume(r['tu_khoa']):
            continue
        dich = r['bai'] if r.get('bai') else ''
        nhan = (r.get('tieu_de_bai') or dich) if dich else 'BÀI MỚI - chưa có trang, chờ đo top 10 để chốt dạng trang + slug'
        need[g].append({'w': r['tu_khoa'], 'url': dich, 'lab': nhan})
have = collections.defaultdict(list)
seen = set()
for r in D['da_co_kho']:
    k = n(r['tu_khoa'])
    if k in seen or not kho.co_volume(k):
        continue
    seen.add(k)
    have['x'].append(k)
nn = sum(len(v) for v in need.values()); nh = len(have['x'])
print('cần xuất', nn, 'đã có', nh)
for t in ORD:
    if need[t]:
        print(' ', t, len(need[t]))
if DRY:
    sys.exit()

tid = tabs(s).get(T)
ticked = set()
if tid is not None:
    v = s.values().get(spreadsheetId=SID, range=f"'{T}'!A1:D3000", valueRenderOption='UNFORMATTED_VALUE').execute().get('values', [])
    cur = None
    for r in v:
        a = str(r[0]) if r else ''
        if a.startswith('Nhóm ') and len(r) > 3 and r[3] in (True, False):
            cur = r[3] is True
        if a.startswith('Nhóm ') and len(r) > 1 and r[1] and cur:
            ticked.add(n(r[1]))
    json.dump(v, open(os.path.expanduser(f"~/Claude-Workspace/_backups/edits/2026-10-26/digicom/tabs/Từ khoá-{datetime.datetime.now():%H%M}.json"), 'w'), ensure_ascii=False)
else:
    tn = tabs(s); pos = next(i for i, x in enumerate(s.get(spreadsheetId=SID).execute()['sheets']) if x['properties']['title'].startswith('KH từ khoá'))
    tid = s.batchUpdate(spreadsheetId=SID, body={'requests': [{'addSheet': {'properties': {'title': T, 'index': pos,
          'gridProperties': {'rowCount': 3000, 'columnCount': 6, 'frozenRowCount': 0}, 'tabColorStyle': {'rgbColor': {'red': .98, 'green': .47, 'blue': .01}}}}}]}
          ).execute()['replies'][0]['addSheet']['properties']['sheetId']

ORANGE = {'red': .98, 'green': .47, 'blue': .01}; GREEN = {'red': .16, 'green': .5, 'blue': .25}; BLUE = {'red': .2, 'green': .35, 'blue': .6}
DARK = {'red': .15, 'green': .2, 'blue': .23}; WHITE = {'red': 1, 'green': 1, 'blue': 1}; GREY = {'red': .45, 'green': .45, 'blue': .45}
BAND = {'red': .93, 'green': .96, 'blue': 1}
rows, meta = [], []
def put(vals, kind, **kw): rows.append(vals); meta.append(dict(kind=kind, **kw))
today = datetime.date.today().strftime('%d/%m/%Y')
nlot = sum((len(need[t]) + 9) // 10 for t in ORD)
comp = ', '.join(c['domain'] if isinstance(c, dict) else str(c) for c in SEEDS.get('competitors', []))
put(['TỪ KHOÁ - SEED VÀ DANH SÁCH COPY VÀO CÔNG CỤ - digicomvn.com'], 'title')
put([f'Phạm vi: 4 dịch vụ chính (Textlink, Backlink, Guest Post, Booking báo & PR) + nhóm đang bán trên site (Social entity, Backlink quốc tế, Toplist, '
     f'Booking truyền hình, phát thanh, KOL/KOC, fanpage). Loại: thiết kế web, tên miền, hosting (đang ẩn), backlink .gov/.edu (pháp lý), quảng cáo Facebook/Google. '
     f'Nguồn: quét toàn site digicomvn.com + 12 đối thủ ({comp}), Google Suggest ẩn danh, Autocomplete 13/10 và 24/10, gộp từ 4 tab cũ (Seed từ khoá, Copy vào tool, '
     f'Seed toàn site 26-10, Từ volume lớn 26-10). Cập nhật {today}.'], 'note')
put(['Mục lục: (1) CẦN XUẤT VOLUME   (2) ĐÃ CÓ TRONG KEYWORD PLANNER / KHO TỪ   (3) Tham khảo: seed quét site + đối thủ   (4) Tham khảo: thực thể từ đối thủ   (5) Từ volume lớn 26/10 (V003)'], 'toc')
put([''], 'blank')
put([f"CẦN XUẤT VOLUME - {nn} từ khoá, {nlot} nhóm 10 từ (cập nhật {today})"], 'band', color=ORANGE)
put([("Cách dùng: (1) Bôi đen 10 ô cột B của 1 nhóm, hoặc copy 1 ô cột C, dán vào Keyword Planner > Nhận thông tin dự đoán và lượng tìm kiếm (Việt Nam, tiếng Việt). "
      "(2) Tải file .csv 'Chỉ số trước đây' vào 06-keyword/kp-raw/<ngày>/. (3) Tick cột Đã xuất: nhóm tô xám. Từ đã có số liệu tự tô xanh khi chạy refresh_kho.py. "
      f"Từ đã có volume KHÔNG nằm trong nhóm, đã chuyển xuống khối 'ĐÃ CÓ TRONG KEYWORD PLANNER' ({nh} từ). "
      "Cột E: trang có sẵn gần nghĩa nhất (đào sâu trang đó, không viết bài mới) hoặc BÀI MỚI; dạng trang + slug chốt sau khi đo top 10.")], 'note')
put(['Nhóm', 'Từ khoá (copy 10 ô)', 'Cả nhóm 1 ô (copy dán thẳng)', 'Đã xuất', 'Trang đích dự kiến (bấm mở)'], 'head')
num = 0; first_lot = None
for t in ORD:
    ws = need[t]
    if not ws:
        continue
    k = (len(ws) + 9) // 10
    for i in range(k):
        num += 1; ch = ws[i * 10:(i + 1) * 10]
        if first_lot is None:
            first_lot = len(rows)
        tick = all(n(d['w']) in ticked for d in ch)
        for j, d in enumerate(ch):
            lab = f"Nhóm {num:03d} - {t} ({i + 1}/{k}, {len(ch)} từ)" if j == 0 else f"Nhóm {num:03d}"
            put([lab, d['w'], ', '.join(x['w'] for x in ch) if j == 0 else '', '', d['lab']], 'lot', band=num % 2, first=(j == 0), link=d['url'], tick=tick)
last_lot = len(rows) - 1
put([''], 'blank')
put([f"ĐÃ CÓ TRONG KEYWORD PLANNER / KHO TỪ - {nh} từ, KHÔNG xuất lại (đã có số liệu từ Keyword Planner, keywordtool hoặc Semrush)"], 'band', color=GREEN)
put(['Chủ đề', 'Từ khoá', 'Lượt tìm/tháng', 'Nguồn', 'Trang đích (nếu có)'], 'head')
def chu_de(k):
    import re as _r
    for t, p in (('Textlink', 'textlink|text link'), ('Guest post', 'guest ?post'), ('Social entity', 'entity'), ('Toplist', 'toplist|top list'),
                 ('Backlink, off-page', 'backlink|back link|anchor|dofollow|nofollow|off ?page'), ('Truyền hình, TVC', 'truyền hình|tvc|vtv|htv'),
                 ('Phát thanh, radio', 'phát thanh|radio|vov|voh'), ('KOL, KOC, fanpage', 'kol|koc|fanpage'),
                 ('Booking báo PR, đăng bài PR', 'báo|bài|pr|thông cáo')):
        if _r.search(p, k):
            return t
    return 'Booking quảng cáo chung'
for k in sorted(have['x'], key=lambda k: (ORD.index(chu_de(k)), -(kho.tu[norm(k)]['vol'] or 0), k)):
    x = kho.tu[norm(k)]
    u = x['url'] or ''
    u = re.sub(r'^(post|page|product|term|[a-z_]+):(?=/)', 'https://digicomvn.com', u)
    put([chu_de(k), k, x['vol'], x['nguon'], u], 'kho')
put([''], 'blank')
sd = [x for x in SEEDS['seeds']]
put([f"THAM KHẢO: SEED QUÉT SITE + 12 ĐỐI THỦ ({len(sd)} seed, {SEEDS.get('date', '')}) - cụm 2-4 chữ có trong tiêu đề/H1 của >= 2 đối thủ; đã lọc phạm vi trước khi đưa vào Google Suggest"], 'band', color=BLUE)
put(['STT', 'Seed', 'Số đối thủ dùng', 'Trang site mình đã có', 'Trang đối thủ mẫu'], 'head')
for i, x in enumerate(sd, 1):
    mau = (x.get('trang_doi_thu_mau') or [''])[0]
    put([i, x['seed'], x['so_doi_thu'], x.get('trang_minh') or 'chưa có', mau], 'ref', l4=x.get('trang_minh') or '', l5=mau)
put([''], 'blank')
tr = [x for x in ENT['ten_rieng'] if x['so_doi_thu'] >= 2][:150]
put([f"THAM KHẢO: THỰC THỂ TỪ ĐỐI THỦ - {len(tr)} tên riêng (đầu báo, đài, kênh) đối thủ nhắc trong tiêu đề/H1, >= 2 đối thủ"], 'band', color=BLUE)
put(['STT', 'Thực thể', 'Số đối thủ nhắc', 'Site mình đã nhắc', 'Trang đối thủ mẫu'], 'head')
for i, x in enumerate(tr, 1):
    put([i, x['thuc_the'], x['so_doi_thu'], 'có' if x['site_minh_da_nhac'] else 'CHƯA', x['trang_doi_thu_mau']], 'ref', l4='', l5=x['trang_doi_thu_mau'])
put([''], 'blank')
put(['TỪ VOLUME LỚN 26/10 (V003) - 10 từ đại diện dán vào Keyword Planner "Khám phá từ khoá mới" để lấy bộ từ nhỏ (chuyển từ tab Từ volume lớn 26-10)'], 'band', color=BLUE)
for r in VOL[1:]:
    if r and any(r):
        put([str(c) for c in r[:5]], 'head' if r[0] == 'STT' else ('note' if not str(r[0]).isdigit() else 'ref'), l4='', l5='')
N = len(rows); print('dòng', N, 'nhóm', num)

def cell(t, f, link=None):
    c = {'userEnteredFormat': f}
    if t != '' and t is not None:
        c['userEnteredValue'] = {'numberValue': t} if isinstance(t, (int, float)) else {'stringValue': str(t)}
    if link and str(t):
        c['textFormatRuns'] = [{'startIndex': 0, 'format': {'link': {'uri': link}, 'underline': True, 'foregroundColor': {'blue': .8}}}]
    return c
api = []
for vals, m in zip(rows, meta):
    k = m['kind']; cs = []
    for ci in range(5):
        t = vals[ci] if ci < len(vals) else ''
        f = {'verticalAlignment': 'MIDDLE', 'wrapStrategy': 'CLIP'}
        link = None
        if k == 'title': f.update(textFormat={'bold': True, 'fontSize': 15})
        elif k in ('note', 'toc'): f.update(wrapStrategy='WRAP', verticalAlignment='TOP')
        elif k == 'band': f.update(backgroundColor=m['color'], textFormat={'bold': True, 'fontSize': 12, 'foregroundColor': WHITE})
        elif k == 'head': f.update(backgroundColor=DARK, textFormat={'bold': True, 'foregroundColor': WHITE})
        elif k == 'lot':
            if m['band'] == 0: f['backgroundColor'] = BAND
            if ci == 0: f['textFormat'] = {'bold': True} if m['first'] else {'foregroundColor': GREY}
            if ci == 3: f['horizontalAlignment'] = 'CENTER'
            if ci == 4: link = m.get('link')
        elif k == 'kho':
            if ci == 2: f['horizontalAlignment'] = 'RIGHT'
            if ci == 4 and str(t).startswith('http'): link = t
        elif k == 'ref':
            if ci == 3 and m.get('l4', '').startswith('http'): link = m['l4']
            if ci == 4 and m.get('l5', '').startswith('http'): link = m['l5']
        c = cell(t, f, link)
        if k == 'lot' and ci == 3 and m['first']:
            c['dataValidation'] = {'condition': {'type': 'BOOLEAN'}}; c['userEnteredValue'] = {'boolValue': m['tick']}
        cs.append(c)
    api.append({'values': cs})
sh = next(x for x in s.get(spreadsheetId=SID, fields='sheets(properties,conditionalFormats,merges)').execute()['sheets'] if x['properties']['sheetId'] == tid)
req = [{'deleteConditionalFormatRule': {'sheetId': tid, 'index': i}} for i in reversed(range(len(sh.get('conditionalFormats', []))))]
req += [{'unmergeCells': {'range': {'sheetId': tid, 'startRowIndex': 0, 'endRowIndex': 3000, 'startColumnIndex': 0, 'endColumnIndex': 6}}},
        {'updateCells': {'range': {'sheetId': tid}, 'fields': '*'}},
        {'updateSheetProperties': {'properties': {'sheetId': tid, 'gridProperties': {'rowCount': max(N + 20, 100), 'columnCount': 6}}, 'fields': 'gridProperties(rowCount,columnCount)'}},
        {'updateCells': {'start': {'sheetId': tid, 'rowIndex': 0, 'columnIndex': 0}, 'rows': api, 'fields': 'userEnteredValue,userEnteredFormat,dataValidation,textFormatRuns'}}]
for i, m in enumerate(meta):
    if m['kind'] in ('title', 'band', 'note', 'toc'):
        req.append({'mergeCells': {'range': {'sheetId': tid, 'startRowIndex': i, 'endRowIndex': i + 1, 'startColumnIndex': 0, 'endColumnIndex': 5}, 'mergeType': 'MERGE_ALL'}})
    if m['kind'] == 'note':
        req.append({'updateDimensionProperties': {'range': {'sheetId': tid, 'dimension': 'ROWS', 'startIndex': i, 'endIndex': i + 1}, 'properties': {'pixelSize': 72}, 'fields': 'pixelSize'}})
for ci, px in enumerate((300, 330, 260, 90, 420)):
    req.append({'updateDimensionProperties': {'range': {'sheetId': tid, 'dimension': 'COLUMNS', 'startIndex': ci, 'endIndex': ci + 1}, 'properties': {'pixelSize': px}, 'fields': 'pixelSize'}})
a1 = first_lot + 1; a2 = last_lot + 1
req.append({'addConditionalFormatRule': {'index': 0, 'rule': {'ranges': [{'sheetId': tid, 'startRowIndex': first_lot, 'endRowIndex': last_lot + 1, 'startColumnIndex': 0, 'endColumnIndex': 5}],
            'booleanRule': {'condition': {'type': 'CUSTOM_FORMULA', 'values': [{'userEnteredValue': f'=COUNTIFS(LEFT($A${a1}:$A${a2};9);LEFT($A{a1};9);$D${a1}:$D${a2};TRUE)>0'}]},
                            'format': {'backgroundColor': {'red': .85, 'green': .85, 'blue': .85}, 'textFormat': {'strikethrough': True, 'foregroundColor': GREY}}}}}})
for k in range(0, len(req), 300):
    s.batchUpdate(spreadsheetId=SID, body={'requests': req[k:k + 300]}).execute()
json.dump({'gid': tid, 'first_lot_row': a1, 'last_lot_row': a2, 'lots': num, 'need': nn, 'have': nh}, open(os.path.join(W, 'tab-written.json'), 'w'))
print('ghi xong gid', tid, 'nhóm dòng', a1, '-', a2, f'{URL}#gid={tid}')
