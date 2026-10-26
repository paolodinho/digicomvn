import os, sys, json, re, unicodedata, warnings
warnings.filterwarnings("ignore")
sys.path.insert(0, os.path.expanduser('~/Claude-Workspace/_shared/skills/content-audit-write/scripts'))
from kho_tu import Kho, norm
from google.oauth2 import service_account
from googleapiclient.discovery import build

ROOT = '/Volumes/Extreme SSD/Projects/digicom'
C = json.load(open(os.path.join(ROOT, '.claude/tong-quan.json')))
SID = C['sheet_id']; T = 'Từ khoá'
KW = os.path.join(ROOT, '06-keyword')
W = os.path.dirname(os.path.abspath(__file__))
URL = f'https://docs.google.com/spreadsheets/d/{SID}/edit'


def svc():
    cr = service_account.Credentials.from_service_account_file(C['credentials'], scopes=['https://www.googleapis.com/auth/spreadsheets'])
    return build('sheets', 'v4', credentials=cr, cache_discovery=False).spreadsheets()


def tabs(s):
    return {x['properties']['title']: x['properties']['sheetId'] for x in s.get(spreadsheetId=SID).execute()['sheets']}


def n(t):
    return re.sub(r'\s+', ' ', unicodedata.normalize('NFC', str(t).lower())).strip()
