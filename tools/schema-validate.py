#!/usr/bin/env python3
# Kiem dinh schema bang validator.schema.org (cua Google) - doc lap voi schema-qa.py.
# Chay: python3 tools/schema-validate.py <url> [url...]
# Muc tieu: 0 loi, 0 canh bao.
import json,urllib.request,urllib.parse,sys
def validate(url):
    data=urllib.parse.urlencode({'url':url}).encode()
    req=urllib.request.Request('https://validator.schema.org/validate',data=data,
        headers={'User-Agent':'Mozilla/5.0','Content-Type':'application/x-www-form-urlencoded'})
    raw=urllib.request.urlopen(req,timeout=60).read().decode('utf-8','ignore')
    if raw.startswith(")]}'"): raw=raw.split('\n',1)[1]
    return json.loads(raw)
for u in sys.argv[1:]:
    try: d=validate(u)
    except Exception as e: print(u,'-> API loi:',e); continue
    print('='*68); print(u,'| LOI:',d.get('totalNumErrors'),'| CANH BAO:',d.get('totalNumWarnings'))
    for g in d.get('tripleGroups',[]):
        for n in g.get('nodes',[]):
            for p in n.get('properties',[]):
                for e in p.get('errors',[]) or []:
                    sev='LOI' if e.get('isSevere') else 'canh bao'
                    print(f"   [{sev}] {n.get('typeGroup')}.{p.get('pred')}: {e.get('errorType')} {e.get('args')}")
