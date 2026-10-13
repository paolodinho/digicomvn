import json,time,urllib.request,urllib.parse,csv,string,os
OUT='kp-raw/kt-gs-autocomplete.csv'
seeds=[s.strip() for s in open('hat-giong.txt',encoding='utf-8') if s.strip()]
out={}
if os.path.exists(OUT):
    for r in csv.DictReader(open(OUT,encoding='utf-8')): out[r['keyword']]=r['seed']
done={v for v in out.values()}
def sug(q):
    u='https://suggestqueries.google.com/complete/search?client=firefox&hl=vi&gl=vn&q='+urllib.parse.quote(q)
    r=urllib.request.urlopen(urllib.request.Request(u,headers={'User-Agent':'Mozilla/5.0'}),timeout=15)
    return json.loads(r.read().decode('utf-8','ignore'))[1]
def save():
    with open(OUT,'w',encoding='utf-8',newline='') as f:
        w=csv.writer(f);w.writerow(['keyword','volume','trend','cpc_low','cpc_high','competition','seed'])
        for k,s in out.items(): w.writerow([k,'','','','','',s])
for s in seeds:
    if s in done: continue
    bad=0
    for suf in ['']+list(string.ascii_lowercase)+['là gì','giá','cách','dịch vụ','nên','uy tín','tốt nhất']:
        q=(s+' '+suf).strip()
        for attempt in range(3):
            try:
                for k in sug(q):
                    k=k.lower().strip()
                    if k not in out: out[k]=s
                break
            except Exception as e:
                print('err',q,e,flush=True); time.sleep(15)
        time.sleep(0.8)
    save(); print(s,len(out),flush=True)
save(); print('DONE',len(out),flush=True)
