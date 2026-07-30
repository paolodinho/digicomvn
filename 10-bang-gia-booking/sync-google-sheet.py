#!/usr/bin/env python3
"""
Dong bo bang gia (publish-gia.json, xuat tu dump-publish-gia.php tren live) len 1 Google
Sheet - moi nhom dich vu = 1 tab, giong cach hien thi tren /bang-gia/.

Lan dau chay (chua co google-sheet-config.json) -> tu tao spreadsheet moi, set quyen
"Anyone with link - Viewer" + KHOA tai xuong/copy/in (copyRequiresWriterPermission), luu
spreadsheet_id vao config de lan sau ghi de len chinh sheet do (khong tao sheet moi moi lan).

Yeu cau: 10-bang-gia-booking/service-account.json (xem HUONG-DAN-SERVICE-ACCOUNT.md)

Chay: python3 sync-google-sheet.py [duong-dan-publish-gia.json]
"""
import json
import sys
import os
import datetime

from google.oauth2 import service_account
from googleapiclient.discovery import build

BASE = os.path.dirname(os.path.abspath(__file__))
KEY_FILE = os.path.join(BASE, 'service-account.json')
CONFIG_FILE = os.path.join(BASE, 'google-sheet-config.json')
DATA_FILE = sys.argv[1] if len(sys.argv) > 1 else os.path.join(BASE, 'publish-gia.json')
SPREADSHEET_TITLE = 'Bảng giá Digicom - cập nhật tự động'

SCOPES = ['https://www.googleapis.com/auth/spreadsheets', 'https://www.googleapis.com/auth/drive']

HEADERS = ['Tên báo / trang', 'Vị trí đăng', 'Giá (VNĐ)', 'Số link / loại link', 'Yêu cầu bài viết']


def load_config():
    if os.path.exists(CONFIG_FILE):
        with open(CONFIG_FILE, encoding='utf-8') as f:
            return json.load(f)
    return {}


def save_config(cfg):
    with open(CONFIG_FILE, 'w', encoding='utf-8') as f:
        json.dump(cfg, f, ensure_ascii=False, indent=2)


def main():
    if not os.path.exists(KEY_FILE):
        print(f'LOI: chua co {KEY_FILE} - xem HUONG-DAN-SERVICE-ACCOUNT.md truoc khi chay script nay.')
        sys.exit(1)

    with open(DATA_FILE, encoding='utf-8') as f:
        data = json.load(f)

    creds = service_account.Credentials.from_service_account_file(KEY_FILE, scopes=SCOPES)
    sheets = build('sheets', 'v4', credentials=creds)
    drive = build('drive', 'v3', credentials=creds)

    cfg = load_config()
    spreadsheet_id = cfg.get('spreadsheet_id')

    if not spreadsheet_id:
        print('Chua co spreadsheet - tao moi...')
        body = {'properties': {'title': SPREADSHEET_TITLE}}
        ss = sheets.spreadsheets().create(body=body, fields='spreadsheetId').execute()
        spreadsheet_id = ss['spreadsheetId']
        cfg['spreadsheet_id'] = spreadsheet_id
        save_config(cfg)
        print(f'Da tao spreadsheet moi: {spreadsheet_id}')

        # Cho phep "anyone with link" xem, KHONG cho tai/copy/in
        drive.permissions().create(
            fileId=spreadsheet_id,
            body={'type': 'anyone', 'role': 'reader'},
            fields='id',
        ).execute()
        drive.files().update(
            fileId=spreadsheet_id,
            body={'copyRequiresWriterPermission': True},
        ).execute()
        print('Da set quyen: anyone-with-link xem duoc, khong tai/copy/in duoc.')

    # Lay danh sach sheet (tab) hien co trong spreadsheet
    meta = sheets.spreadsheets().get(spreadsheetId=spreadsheet_id).execute()
    existing_sheets = {s['properties']['title']: s['properties']['sheetId'] for s in meta['sheets']}

    requests = []
    now_str = datetime.datetime.now().strftime('%d/%m/%Y %H:%M')

    for slug, block in data.items():
        tab_title = block['label']
        rows = block['rows']

        if tab_title not in existing_sheets:
            requests.append({'addSheet': {'properties': {'title': tab_title}}})

    if requests:
        sheets.spreadsheets().batchUpdate(
            spreadsheetId=spreadsheet_id, body={'requests': requests}
        ).execute()
        meta = sheets.spreadsheets().get(spreadsheetId=spreadsheet_id).execute()
        existing_sheets = {s['properties']['title']: s['properties']['sheetId'] for s in meta['sheets']}

    # Xoa tab mac dinh "Sheet1" neu con va da co tab khac thay the
    if 'Sheet1' in existing_sheets and len(existing_sheets) > 1:
        sheets.spreadsheets().batchUpdate(
            spreadsheetId=spreadsheet_id,
            body={'requests': [{'deleteSheet': {'sheetId': existing_sheets['Sheet1']}}]},
        ).execute()
        del existing_sheets['Sheet1']

    for slug, block in data.items():
        tab_title = block['label']
        rows = block['rows']
        sheet_id = existing_sheets[tab_title]

        values = [HEADERS]
        for r in rows:
            gia = r.get('gia', '')
            try:
                gia_num = int(float(gia)) if str(gia).strip() not in ('', 'None') else ''
            except (ValueError, TypeError):
                gia_num = gia
            values.append([r.get('ten', ''), r.get('vi_tri', ''), gia_num, r.get('so_link', ''), r.get('yeu_cau', '')])

        if not rows:
            values.append(['Chưa có dữ liệu công khai cho nhóm này.', '', '', '', ''])

        values.append([])
        values.append([f'Cập nhật lúc {now_str} - Giá tham khảo, có thể thay đổi. Xem đầy đủ tại digicomvn.com/bang-gia'])

        # Xoa noi dung cu + ghi de
        sheets.spreadsheets().values().clear(
            spreadsheetId=spreadsheet_id, range=f"'{tab_title}'!A1:Z5000"
        ).execute()
        sheets.spreadsheets().values().update(
            spreadsheetId=spreadsheet_id,
            range=f"'{tab_title}'!A1",
            valueInputOption='USER_ENTERED',
            body={'values': values},
        ).execute()

        # Dinh dang: header dam + freeze row 1 + auto-resize cot
        fmt_requests = [
            {
                'repeatCell': {
                    'range': {'sheetId': sheet_id, 'startRowIndex': 0, 'endRowIndex': 1},
                    'cell': {'userEnteredFormat': {'textFormat': {'bold': True}, 'backgroundColor': {'red': 0.93, 'green': 0.96, 'blue': 0.96}}},
                    'fields': 'userEnteredFormat(textFormat,backgroundColor)',
                }
            },
            {
                'updateSheetProperties': {
                    'properties': {'sheetId': sheet_id, 'gridProperties': {'frozenRowCount': 1}},
                    'fields': 'gridProperties.frozenRowCount',
                }
            },
            {
                'autoResizeDimensions': {
                    'dimensions': {'sheetId': sheet_id, 'dimension': 'COLUMNS', 'startIndex': 0, 'endIndex': 5}
                }
            },
        ]
        sheets.spreadsheets().batchUpdate(spreadsheetId=spreadsheet_id, body={'requests': fmt_requests}).execute()
        print(f'  - {tab_title}: {len(rows)} dong')

    url = f'https://docs.google.com/spreadsheets/d/{spreadsheet_id}/edit?usp=sharing'
    print(f'\nXong. Link xem (view-only, khong tai/copy/in duoc): {url}')

    # Ghi lai link vao config de site/PHP doc duoc
    cfg['spreadsheet_id'] = spreadsheet_id
    cfg['view_url'] = url
    cfg['updated_at'] = now_str
    save_config(cfg)


if __name__ == '__main__':
    main()
