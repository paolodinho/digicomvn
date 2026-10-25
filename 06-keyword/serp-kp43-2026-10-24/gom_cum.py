# Gom cum theo SERP: tu co volume lon nhat lam loi, tu khac trung >=3 URL top 10 voi loi thi vao cum.
import json,glob,csv,re,collections,os
B=os.path.dirname(os.path.abspath(__file__)); K=os.path.dirname(B)
vol={}
for f in glob.glob(K+'/kp-raw/kp-*.csv'):
    rows=list(csv.reader(open(f,encoding='utf-8-sig')))[2:]
    if not rows: continue
    h=rows[0]
    try: i=h.index('Avg. monthly searches')
    except ValueError: continue
    for r in rows[1:]:
        if len(r)>i and r[i].strip().isdigit(): vol[r[0]]=max(vol.get(r[0],0),int(r[i]))
def norm(u):
    u=re.sub(r'[?#].*','',u.strip().lower()); u=re.sub(r'^https?://(www\.)?','',u); return u.rstrip('/')
S={}
for l in open(B+'/serp.csv.partial.jsonl'):
    try: d=json.loads(l)
    except: continue
    try: p=json.loads(d.get('serp_pages') or '{}')
    except: p={}
    pages=p.get('pages') or []
    urls=[norm(x.get('url') or x.get('serp_url')) for x in pages if (x.get('url') or x.get('serp_url'))]
    if not urls: urls=[norm(u) for u in d.get('serp_urls','').split(' | ') if u.startswith('http')]
    S[d['keyword']]=dict(urls=urls[:10],pages=pages,paa=d.get('paa',''),ai=(p.get('ai_overview') or '')[:300],blocks=p.get('blocks',{}),titles=d.get('serp_titles',''))
kws=sorted(S,key=lambda k:-vol.get(k,0)); used=set(); out=[]
for k in kws:
    if k in used or not S[k]['urls']: continue
    core=set(S[k]['urls']); mem=[k]; used.add(k)
    for o in kws:
        if o not in used and len(core & set(S[o]['urls']))>=3: mem.append(o); used.add(o)
    pg=S[k]['pages']; tc=collections.Counter(x.get('type','?') for x in pg)
    tit=[x.get('title') or x.get('serp_title','') for x in pg]
    feat={f:sum(1 for t in tit if re.search(r,t.lower())) for f,r in [('giá',r'giá'),('câu hỏi',r'là gì|\?|bao nhiêu|cách|như thế nào'),('top/số',r'top|\d+\+? (đầu báo|báo|cách|mẫu|bước)'),('năm',r'20\d\d'),('dịch vụ',r'dịch vụ')]}
    dg=[i+1 for i,u in enumerate(S[k]['urls']) if 'digicomvn.com' in u]
    out.append(dict(loi=k,tu=[(m,vol.get(m,0)) for m in mem],tong=sum(vol.get(m,0) for m in mem),dang_trang=dict(tc),dac_diem_tieu_de=feat,tieu_de=tit[:6],paa=S[k]['paa'][:400],ai=S[k]['ai'],blocks=S[k]['blocks'],digicom_vi_tri=dg,urls=S[k]['urls']))
out.sort(key=lambda c:-c['tong'])
json.dump(out,open(B+'/clusters.json','w'),ensure_ascii=False,indent=1)
print(len(S),'tu da do ->',len(out),'cum')
for c in out[:40]: print(c['tong'],'|',' ; '.join(f'{a} {b}' for a,b in c['tu'])[:110],'|',c['dang_trang'],'| dg',c['digicom_vi_tri'])
