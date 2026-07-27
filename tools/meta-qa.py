#!/usr/bin/env python3
# QA meta SEO toan site: moi URL phai co meta description (50-320 ky tu),
# du og:title/url/image/type/description, twitter:card, va DUNG 1 canonical tro dung chinh no.
# Chay: python3 tools/meta-qa.py
import re,urllib.request,concurrent.futures as cf
UA={'User-Agent':'Mozilla/5.0 (meta-qa)'}
def get(u): return urllib.request.urlopen(urllib.request.Request(u,headers=UA),timeout=45).read().decode('utf-8','ignore')
urls=[]
for sm in ['posts-post-1','posts-page-1','posts-dgc_case-1','taxonomies-category-1','users-1']:
    urls+=re.findall(r'<loc>([^<]+)</loc>',get(f'https://digicomvn.com/wp-sitemap-{sm}.xml'))
urls=[u for u in sorted(set(urls)) if '/cam-on/' not in u]
def chk(u):
    e=[]
    try: h=get(u)
    except Exception as ex: return u,['FETCH '+str(ex)]
    d=re.search(r'<meta name="description" content="([^"]*)"',h)
    if not d or len(d.group(1))<50: e.append(f'description {"thieu" if not d else "qua ngan ("+str(len(d.group(1)))+")"}')
    elif len(d.group(1))>320: e.append(f'description qua dai ({len(d.group(1))})')
    for t in ['og:title','og:url','og:image','og:type','og:description']:
        if f'property="{t}"' not in h: e.append('thieu '+t)
    if 'name="twitter:card"' not in h: e.append('thieu twitter:card')
    c=re.findall(r'<link rel="canonical" href="([^"]+)"',h)
    if len(c)!=1: e.append(f'canonical = {len(c)} (phai = 1)')
    elif c[0].rstrip('/')!=u.rstrip('/'): e.append(f'canonical lech: {c[0]}')
    if h.count('property="og:title"')>1: e.append('og:title lap')
    return u,e
bad=0
with cf.ThreadPoolExecutor(6) as ex:
    for u,e in ex.map(chk,urls):
        if e: bad+=1; print('LOI ',u); [print('      -',x) for x in e]
print(f'\n=== {len(urls)} URL | {bad} URL thieu/sai meta ===')
