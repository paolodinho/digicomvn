#!/usr/bin/env python3
"""Kiem moi hyperlink trong file xlsx (hoac Google Sheet ID) qua Google Safe Browsing
(Transparency Report) TRUOC khi upload/gui khach. Link toi domain bi danh dau -> Drive
khoa file "Google se xem xet tep cua ban".

Dung: python3 tools/check-links-safebrowsing.py <file.xlsx | sheet_id>...
Thoat ma 1 neu co domain bi danh dau.
"""
import json, sys, time, urllib.request
from urllib.parse import urlparse

SA = '/Volumes/Extreme SSD/Projects/Phòng khám sản phụ khoa Alpha/08-tools/meta-leads-sync/service-account-key.json'


def links_xlsx(path):
    import openpyxl
    out = set()
    for ws in openpyxl.load_workbook(path):
        for row in ws.iter_rows():
            for c in row:
                if c.hyperlink and c.hyperlink.target:
                    out.add(c.hyperlink.target)
                if isinstance(c.value, str) and c.value.startswith('=HYPERLINK('):
                    out.add(c.value.split('"')[1])
    return out


def links_sheet(sid):
    from google.oauth2 import service_account
    from googleapiclient.discovery import build
    cr = service_account.Credentials.from_service_account_file(SA, scopes=['https://www.googleapis.com/auth/drive'])
    r = build('sheets', 'v4', credentials=cr).spreadsheets().get(
        spreadsheetId=sid, includeGridData=True, fields='sheets(data(rowData(values(hyperlink))))').execute()
    return {c['hyperlink'] for sh in r['sheets'] for d in sh.get('data', [])
            for row in d.get('rowData', []) for c in row.get('values', []) if c.get('hyperlink')}


def status(domain):
    url = f'https://transparencyreport.google.com/transparencyreport/api/v3/safebrowsing/status?site={domain}'
    for i in range(4):
        try:
            t = urllib.request.urlopen(url, timeout=20).read().decode()
            return json.loads(t.split('\n', 1)[1])[0][1]  # 1 = khong co noi dung nguy hiem
        except Exception:
            time.sleep(4 * (i + 1))
    return 'ERR'


bad = 0
for arg in sys.argv[1:]:
    links = links_xlsx(arg) if arg.endswith('.xlsx') else links_sheet(arg)
    doms = sorted({urlparse(u).netloc.lower().removeprefix('www.') for u in links if u.startswith('http')})
    for d in doms:
        st = status(d)
        if st in (2, 3):  # 2 = co trang khong an toan, 3 = khong an toan
            bad += 1
            print(f'CANH BAO {d}: Safe Browsing status={st}  ({arg})')
        elif st != 1:  # 4 = Google chua co du lieu, ERR = khong tra duoc
            print(f'Chua xac dinh {d}: status={st}  ({arg})')
        time.sleep(1.5)
    print(f'{arg}: {len(doms)} domain, xong')
sys.exit(1 if bad else 0)
