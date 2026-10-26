"""Sau mỗi lượt Keyword Planner: tick 'Đã xuất' các nhóm mà mọi từ đã nằm trong file đã tải lên (kp-raw/*/upload-*.csv),
tô xanh từ đã có volume > 0 trong kho, ghi volume vào ghi chú ô. Không đổi thứ tự nhóm. Dùng: /usr/bin/python3 refresh_kho.py"""
import glob
from sheet_common import *
s = svc(); kho = Kho(KW); tid = tabs(s)[T]
up = set()
for f in glob.glob(os.path.join(KW, 'kp-raw', '*', 'upload-*.csv')):
    up |= {n(x) for x in open(f, encoding='utf-8').read().splitlines()[1:] if x.strip()}
v = s.values().get(spreadsheetId=SID, range=f"'{T}'!A1:D3000", valueRenderOption='UNFORMATTED_VALUE').execute().get('values', [])
groups = {}
for i, r in enumerate(v):
    if r and str(r[0]).startswith('Nhóm ') and len(r) > 1 and r[1]:
        groups.setdefault(str(r[0]).split(' - ')[0].strip(), []).append((i, r[1], len(r) > 3 and r[3] in (True, False)))
req, xanh, tick = [], 0, 0
GREEN = {'red': .85, 'green': .94, 'blue': .83}
for g, rows in groups.items():
    if all(n(w) in up for _, w, _ in rows):
        i0 = next(i for i, _, f in rows if f)
        req.append({'updateCells': {'range': {'sheetId': tid, 'startRowIndex': i0, 'endRowIndex': i0 + 1, 'startColumnIndex': 3, 'endColumnIndex': 4},
                    'rows': [{'values': [{'userEnteredValue': {'boolValue': True}}]}], 'fields': 'userEnteredValue'}}); tick += 1
    for i, w, _ in rows:
        if kho.co_volume(w):
            vol = kho.tu[norm(w)]['vol']
            req.append({'updateCells': {'range': {'sheetId': tid, 'startRowIndex': i, 'endRowIndex': i + 1, 'startColumnIndex': 1, 'endColumnIndex': 2},
                        'rows': [{'values': [{'userEnteredFormat': {'backgroundColor': GREEN}, 'note': f'Đã có volume: {vol}/tháng'}]}], 'fields': 'userEnteredFormat.backgroundColor,note'}}); xanh += 1
for k in range(0, len(req), 400):
    s.batchUpdate(spreadsheetId=SID, body={'requests': req[k:k + 400]}).execute()
print('tick', tick, '/', len(groups), 'nhóm; tô xanh', xanh, 'từ có volume')
