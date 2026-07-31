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

# Cot: STT | Ten bao/trang | DR | Vi tri dang | Gia (VND) | Yeu cau bai viet
HEADERS = ['STT', 'Tên báo / trang', 'DR', 'Vị trí đăng', 'Giá (VNĐ)', 'Yêu cầu bài viết']
N_COLS  = len(HEADERS)
HEADER_ROW_IDX = 4  # 0-index cua dong tieu de cot: sau 3 dong info (0,1,2) + 1 dong trong (3)

# Mau brand Digicom (teal) - phong cach bo cuc "khoi header + dai uu dai + header mau + cot gia
# to sang" hoc theo sheet DanaSEO, nhung dung mau brand rieng (khong nhai mau hong/magenta cua ho).
C_TEAL       = {'red': 0.055, 'green': 0.549, 'blue': 0.498}   # #0E8C7F
C_TEAL_LIGHT = {'red': 0.882, 'green': 0.969, 'blue': 0.957}   # #E1F7F4
C_NAVY       = {'red': 0.110, 'green': 0.125, 'blue': 0.208}   # #1C2035
C_AMBER      = {'red': 1.0,   'green': 0.894, 'blue': 0.612}   # #FFE49C
C_WHITE      = {'red': 1, 'green': 1, 'blue': 1}


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
        # Service account KHONG co dung luong Drive rieng (storageQuota=0, gioi han chuan cua
        # Google) -> khong tu tao file moi duoc. Hieu phai tu tao sheet trong + share Editor cho
        # email service account, roi dan spreadsheet_id vao day (xem HUONG-DAN-SERVICE-ACCOUNT.md).
        print('LOI: chua co spreadsheet_id trong google-sheet-config.json.')
        print('Hieu can tu tao 1 Google Sheet trong, share quyen Editor cho email service account,')
        print('roi dien spreadsheet_id (lay tu URL sheet) vao google-sheet-config.json.')
        sys.exit(1)

    # Set quyen "anyone with link - Viewer", khoa tai/copy/in - chay MOI lan (idempotent, khong
    # loi neu da set roi). Boc try/except vi service account chi la Editor (khong phai owner) co
    # the khong sua duoc sharing settings tuy cau hinh Drive cua Hieu.
    try:
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
    except Exception as e:
        print(f'Canh bao: khong sua duoc quyen chia se (bo qua, khong dung script): {e}')

    # Lay danh sach sheet (tab) hien co trong spreadsheet
    meta = sheets.spreadsheets().get(spreadsheetId=spreadsheet_id).execute()
    existing_sheets = {s['properties']['title']: s['properties']['sheetId'] for s in meta['sheets']}

    requests = []
    now_str = datetime.datetime.now().strftime('%d/%m/%Y %H:%M')
    dgc_meta = data.get('_meta', {})

    for slug, block in data.items():
        if slug == '_meta':
            continue
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
        if slug == '_meta':
            continue
        tab_title = block['label']
        rows = block['rows']
        sheet_id = existing_sheets[tab_title]

        # --- Khoi header 3 dong (giong bo cuc sheet DanaSEO: ten cong ty / MST+STK+email+hotline
        # / dai uu dai) + 1 dong trong ngan cach + dong tieu de cot mau. ---
        company = dgc_meta.get('company', '')
        contact = ' | '.join(x for x in [
            f"MST: {dgc_meta.get('mst','')}" if dgc_meta.get('mst') else '',
            dgc_meta.get('bank', ''),
            f"Email: {dgc_meta.get('email','')}" if dgc_meta.get('email') else '',
            f"Hotline: {dgc_meta.get('hotline','')}" if dgc_meta.get('hotline') else '',
        ] if x)
        promo = dgc_meta.get('promo_note', '')

        values = [
            [company] + [''] * (N_COLS - 1),
            [contact] + [''] * (N_COLS - 1),
            [promo] + [''] * (N_COLS - 1),
            [''] * N_COLS,
            HEADERS,
        ]
        first_data_row = len(values)  # 0-index dong du lieu dau tien (ngay sau header, = 5)
        for r in rows:
            gia = r.get('gia', '')
            try:
                gia_num = int(float(gia)) if str(gia).strip() not in ('', 'None') else ''
            except (ValueError, TypeError):
                gia_num = gia
            ten = r.get('ten', '')
            url_bao = (r.get('url_bao') or '').strip()
            ten_cell = f'=HYPERLINK("{url_bao}","{ten}")' if url_bao else ten
            dr = r.get('dr') or ''
            values.append([len(values) - HEADER_ROW_IDX, ten_cell, dr, r.get('vi_tri', ''), gia_num, r.get('yeu_cau', '')])

        if not rows:
            values.append(['', 'Chưa có dữ liệu công khai cho nhóm này.', '', '', '', ''])
        last_data_row = len(values)  # 0-index (exclusive) dong ket thuc du lieu

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

        def band(row_idx, color, text_color=C_NAVY, bold=True, size=11):
            return {
                'repeatCell': {
                    'range': {'sheetId': sheet_id, 'startRowIndex': row_idx, 'endRowIndex': row_idx + 1, 'startColumnIndex': 0, 'endColumnIndex': N_COLS},
                    'cell': {'userEnteredFormat': {
                        'backgroundColor': color,
                        'textFormat': {'bold': bold, 'foregroundColor': text_color, 'fontSize': size},
                        'horizontalAlignment': 'CENTER',
                    }},
                    'fields': 'userEnteredFormat(backgroundColor,textFormat,horizontalAlignment)',
                }
            }

        fmt_requests = [
            # Dong 1 - ten cong ty: nen teal nhat, chu navy dam
            band(0, C_TEAL_LIGHT, C_NAVY, True, 12),
            # Dong 2 - MST/STK/email/hotline
            band(1, C_TEAL_LIGHT, C_NAVY, False, 10),
            # Dong 3 - dai uu dai: nen teal dam, chu trang
            band(2, C_TEAL, C_WHITE, True, 11),
            # Dong 5 (header cot): nen navy, chu trang
            band(HEADER_ROW_IDX, C_NAVY, C_WHITE, True, 10),
            # Merge tung dong header thanh 1 o (giong sheet mau)
            {'mergeCells': {'range': {'sheetId': sheet_id, 'startRowIndex': 0, 'endRowIndex': 1, 'startColumnIndex': 0, 'endColumnIndex': N_COLS}, 'mergeType': 'MERGE_ALL'}},
            {'mergeCells': {'range': {'sheetId': sheet_id, 'startRowIndex': 1, 'endRowIndex': 2, 'startColumnIndex': 0, 'endColumnIndex': N_COLS}, 'mergeType': 'MERGE_ALL'}},
            {'mergeCells': {'range': {'sheetId': sheet_id, 'startRowIndex': 2, 'endRowIndex': 3, 'startColumnIndex': 0, 'endColumnIndex': N_COLS}, 'mergeType': 'MERGE_ALL'}},
            # Cot GIA (index 4) to sang mau amber tren ca header + du lieu - diem nhan gia nhu
            # sheet mau (ho dung vang cho header gia, o day to sang ca cot de de nhin gia).
            {
                'repeatCell': {
                    'range': {'sheetId': sheet_id, 'startRowIndex': HEADER_ROW_IDX, 'endRowIndex': HEADER_ROW_IDX + 1, 'startColumnIndex': 4, 'endColumnIndex': 5},
                    'cell': {'userEnteredFormat': {'backgroundColor': C_AMBER, 'textFormat': {'bold': True, 'foregroundColor': C_NAVY}, 'horizontalAlignment': 'CENTER'}},
                    'fields': 'userEnteredFormat(backgroundColor,textFormat,horizontalAlignment)',
                }
            },
            {
                'repeatCell': {
                    'range': {'sheetId': sheet_id, 'startRowIndex': first_data_row, 'endRowIndex': last_data_row, 'startColumnIndex': 4, 'endColumnIndex': 5},
                    'cell': {'userEnteredFormat': {'backgroundColor': C_TEAL_LIGHT, 'numberFormat': {'type': 'NUMBER', 'pattern': '#,##0'}}},
                    'fields': 'userEnteredFormat(backgroundColor,numberFormat)',
                }
            },
            # Freeze 5 dong dau (khoi thong tin + header) - luon thay du khi cuon
            {
                'updateSheetProperties': {
                    'properties': {'sheetId': sheet_id, 'gridProperties': {'frozenRowCount': HEADER_ROW_IDX + 1}},
                    'fields': 'gridProperties.frozenRowCount',
                }
            },
            {
                'autoResizeDimensions': {
                    'dimensions': {'sheetId': sheet_id, 'dimension': 'COLUMNS', 'startIndex': 0, 'endIndex': N_COLS}
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
