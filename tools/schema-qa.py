#!/usr/bin/env python3
# QA schema toan site digicomvn.com: quet moi URL trong sitemap, kiem tra
# - dung 1 khoi JSON-LD/trang, JSON parse duoc, co @graph
# - co Organization + WebSite + node *Page
# - Article du author/publisher/date/image/mainEntityOfPage, headline <= 110 ky tu
# - BreadcrumbList position lien tuc, ListItem du name/item
# - Service co provider, lowPrice <= highPrice; FAQPage co Question + answer
# - khong co thuoc tinh rong
# Chay: python3 tools/schema-qa.py
import re,json,urllib.request,concurrent.futures as cf
UA={'User-Agent':'Mozilla/5.0 (schema-qa)'}
def get(u):
    return urllib.request.urlopen(urllib.request.Request(u,headers=UA),timeout=45).read().decode('utf-8','ignore')
urls=[]
for sm in ['posts-post-1','posts-page-1','posts-dgc_case-1','taxonomies-category-1','users-1']:
    try:
        urls+=re.findall(r'<loc>([^<]+)</loc>',get(f'https://digicomvn.com/wp-sitemap-{sm}.xml'))
    except Exception as e: print('sitemap loi',sm,e)
urls=[u for u in sorted(set(urls)) if "/cam-on/" not in u]
print('Tong URL kiem tra:',len(urls))
REQ_ART=['headline','author','publisher','datePublished','dateModified','image','mainEntityOfPage']
def check(u):
    errs=[];warns=[]
    try: h=get(u)
    except Exception as e: return u,['FETCH: '+str(e)],[]
    b=re.findall(r'<script type="application/ld\+json">(.*?)</script>',h,re.S)
    if len(b)!=1: errs.append(f'so khoi JSON-LD = {len(b)} (phai = 1)')
    if not b: return u,errs,warns
    try: d=json.loads(b[0])
    except Exception as e: return u,errs+['JSON khong parse duoc: '+str(e)],warns
    g=d.get('@graph')
    if not g: return u,errs+['thieu @graph'],warns
    types={}
    for n in g:
        t=n.get('@type'); t=[t] if isinstance(t,str) else t
        for x in t: types.setdefault(x,[]).append(n)
        if not n.get('@id'): warns.append('node thieu @id: '+str(t))
        for k,v in n.items():
            if v=='' or v==[] or v=={}: errs.append(f'thuoc tinh rong: {t}.{k}')
    if 'Organization' not in types: errs.append('thieu Organization')
    if 'WebSite' not in types: errs.append('thieu WebSite')
    if not any(k.endswith('Page') for k in types): errs.append('thieu node *Page')
    can=re.search(r'<link rel="canonical" href="([^"]+)"',h)
    if can:
        wp=[n for n in g if str(n.get('@id','')).endswith('#webpage')]
        if wp and wp[0]['@id']!=can.group(1)+'#webpage':
            warns.append(f"@id webpage != canonical ({wp[0]['@id']} vs {can.group(1)})")
    for a in types.get('Article',[]):
        for k in REQ_ART:
            if k not in a: errs.append(f'Article thieu {k}')
        if len(a.get('headline',''))>110: errs.append('headline > 110 ky tu')
    for bc in types.get('BreadcrumbList',[]):
        for i,it in enumerate(bc.get('itemListElement',[])):
            if it.get('position')!=i+1: errs.append('BreadcrumbList position sai')
            if not it.get('name') or not it.get('item'): errs.append('ListItem thieu name/item')
    for s in types.get('Service',[]):
        if 'provider' not in s: errs.append('Service thieu provider')
        o=s.get('offers')
        if o and float(o.get('lowPrice',0))>float(o.get('highPrice',0)): errs.append('lowPrice > highPrice')
    for f in types.get('FAQPage',[]):
        me=f.get('mainEntity')
        if not me: errs.append('FAQPage thieu mainEntity')
        elif isinstance(me,list):
            for q in me:
                if q.get('@type')!='Question' or not q.get('acceptedAnswer',{}).get('text'): errs.append('Question thieu answer')
    return u,errs,warns
bad=0;warn=0
with cf.ThreadPoolExecutor(6) as ex:
    for u,e,w in ex.map(check,urls):
        if e: bad+=1; print('LOI  ',u); [print('       -',x) for x in sorted(set(e))]
        if w: warn+=1; [print('CANH BAO',u,'-',x) for x in sorted(set(w))]
print(f'\n=== {len(urls)} URL | {bad} URL co LOI | {warn} URL co canh bao ===')
