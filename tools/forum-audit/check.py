import socket, urllib.request, ssl, csv, concurrent.futures

ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE

def check(line):
    line = line.strip()
    if not line or "|" not in line:
        return None
    domain, nganh = line.split("|", 1)
    domain = domain.strip()
    host = domain.split("/")[0]
    try:
        socket.gethostbyname(host)
    except Exception:
        return (domain, nganh, "DEAD_DNS", "")
    for scheme in ("https", "http"):
        try:
            req = urllib.request.Request(
                f"{scheme}://{domain}",
                headers={"User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120 Safari/537.36"},
            )
            with urllib.request.urlopen(req, timeout=12, context=ctx) as r:
                return (domain, nganh, "OK", str(r.status))
        except urllib.error.HTTPError as e:
            if e.code in (403, 429, 503):
                return (domain, nganh, "BLOCKED", str(e.code))
            return (domain, nganh, "HTTP_LOI", str(e.code))
        except Exception:
            continue
    return (domain, nganh, "LOI_KET_NOI", "")

with open("candidates.txt", encoding="utf-8") as f:
    lines = f.readlines()

rows = []
with concurrent.futures.ThreadPoolExecutor(max_workers=15) as ex:
    for r in ex.map(check, lines):
        if r:
            rows.append(r)

with open("status.csv", "w", newline="", encoding="utf-8") as f:
    w = csv.writer(f)
    w.writerow(["domain", "nganh", "trang_thai", "http"])
    w.writerows(rows)

from collections import Counter
print(Counter(r[2] for r in rows))
for r in rows:
    if r[2] not in ("OK", "BLOCKED"):
        print("  LOAI:", r[0], r[2], r[3])
