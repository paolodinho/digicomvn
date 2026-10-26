"""Ghi 1 dòng (theo mã) vào tab 'Tổng quan dự án' của file tổng quan digicom.
Dùng: tq.py <MÃ> [--after N10] [--viec ..] [--phat-hien ..] [--da-lam ..] [--trang-thai ..] [--tiep ..] [--file ..]
Chưa có mã thì chèn dòng mới ngay dưới mã --after. Ngày cập nhật tự ghi hôm nay."""
import sys, os, json, argparse, datetime, warnings
warnings.filterwarnings("ignore")
from google.oauth2 import service_account
from googleapiclient.discovery import build

ROOT = "/Volumes/Extreme SSD/Projects/digicom"
C = json.load(open(os.path.join(ROOT, ".claude/tong-quan.json")))
SID, TAB = C["sheet_id"], "Tổng quan dự án"


def svc():
    cr = service_account.Credentials.from_service_account_file(C["credentials"], scopes=["https://www.googleapis.com/auth/spreadsheets"])
    return build("sheets", "v4", credentials=cr, cache_discovery=False).spreadsheets()


def set_row(code, after="N10", **cols):
    s = svc()
    v = s.values().get(spreadsheetId=SID, range=f"'{TAB}'!A1:A400").execute().get("values", [])
    col = [(r[0] if r else "") for r in v]
    starts = [i for i, x in enumerate(col) if x == "Mã"]
    base = starts[-1] if starts else 0  # bảng chính (bỏ khối "Việc đang chờ")
    idx = next((i for i in range(base, len(col)) if col[i] == code), None)
    if idx is None:
        a = next(i for i in range(base, len(col)) if col[i] == after)
        tid = next(x["properties"]["sheetId"] for x in s.get(spreadsheetId=SID).execute()["sheets"] if x["properties"]["title"] == TAB)
        s.batchUpdate(spreadsheetId=SID, body={"requests": [{"insertDimension": {"range": {"sheetId": tid, "dimension": "ROWS", "startIndex": a + 1, "endIndex": a + 2}, "inheritFromBefore": True}}]}).execute()
        idx = a + 1
        s.values().update(spreadsheetId=SID, range=f"'{TAB}'!A{idx+1}", valueInputOption="RAW", body={"values": [[code]]}).execute()
    m = {"viec": "B", "phat_hien": "C", "da_lam": "D", "trang_thai": "E", "tiep": "F", "file": "H"}
    data = [{"range": f"'{TAB}'!{m[k]}{idx+1}", "values": [[val]]} for k, val in cols.items() if val is not None and k in m]
    data.append({"range": f"'{TAB}'!G{idx+1}", "values": [[datetime.date.today().strftime("%d/%m/%Y")]]})
    s.values().batchUpdate(spreadsheetId=SID, body={"valueInputOption": "USER_ENTERED", "data": data}).execute()
    return idx + 1


if __name__ == "__main__":
    p = argparse.ArgumentParser()
    p.add_argument("code"); p.add_argument("--after", default="N10")
    for k in ("viec", "phat-hien", "da-lam", "trang-thai", "tiep", "file"):
        p.add_argument("--" + k)
    a = p.parse_args()
    r = set_row(a.code, a.after, viec=a.viec, phat_hien=a.phat_hien, da_lam=a.da_lam, trang_thai=a.trang_thai, tiep=a.tiep, file=a.file)
    print("ghi dòng", r)
