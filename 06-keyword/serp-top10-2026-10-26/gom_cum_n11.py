# Gom cum N11 26/10: gop SERP do 24/10 + 26/10, tu volume lon nhat lam loi,
# tu khac trung >=3 URL top 10 (chuan hoa) voi loi thi vao cum. Ghi clusters.json.
import json, glob, csv, re, collections, os, sys
B = os.path.dirname(os.path.abspath(__file__)); K = os.path.dirname(B)
sys.path.insert(0, os.path.expanduser('~/Claude-Workspace/_shared/skills/content-audit-write/scripts'))
from kho_tu import Kho, norm as kn

vol = {}
for f in glob.glob(K + '/kp-raw/**/kp-*.csv', recursive=True):
    if '/_' in f.replace(K + '/kp-raw', ''): continue
    try: rows = list(csv.reader(open(f, encoding='utf-8-sig')))
    except UnicodeDecodeError: continue
    for i0, h in enumerate(rows[:4]):
        if 'Avg. monthly searches' in h:
            c = h.index('Avg. monthly searches')
            for r in rows[i0 + 1:]:
                if len(r) > c and r[c].strip().isdigit():
                    k = kn(r[0]); vol[k] = max(vol.get(k, 0), int(r[c]))
            break
kho = Kho(K)

def nu(u):
    u = re.sub(r'[?#].*', '', u.strip().lower()); u = re.sub(r'^https?://(www\.)?', '', u); return u.rstrip('/')

S = {}
for f in [K + '/serp-kp43-2026-10-24/serp.csv.partial.jsonl',
          K + '/serp-truyen-hinh-phat-thanh-2026-10-24/serp.csv.partial.jsonl',
          B + '/serp.csv.partial.jsonl']:
    if not os.path.exists(f): continue
    for l in open(f):
        try: d = json.loads(l)
        except Exception: continue
        if d.get('status') != 'ok': continue
        try: p = json.loads(d.get('serp_pages') or '{}')
        except Exception: p = {}
        pages = p.get('pages') or []
        urls = [nu(x.get('url') or x.get('serp_url')) for x in pages if (x.get('url') or x.get('serp_url'))]
        if not urls: urls = [nu(u) for u in d.get('serp_urls', '').split(' | ') if u.startswith('http')]
        if urls:
            S[kn(d['keyword'])] = dict(kw=d['keyword'], urls=urls[:10], pages=pages, paa=d.get('paa', ''),
                                    ai=(p.get('ai_overview') or '')[:300], blocks=p.get('blocks', {}),
                                    src=os.path.basename(os.path.dirname(f)))
V = lambda k: vol.get(k, (kho.tu.get(k) or {}).get('vol') or 0)
kws = sorted(S, key=lambda k: -V(k)); used = set(); out = []
for k in kws:
    if k in used: continue
    core = set(S[k]['urls']); mem = [k]; used.add(k)
    for o in kws:
        if o not in used and len(core & set(S[o]['urls'])) >= 3: mem.append(o); used.add(o)
    pg = S[k]['pages']; tc = collections.Counter(x.get('type', '?') for x in pg)
    tit = [x.get('title') or x.get('serp_title', '') for x in pg]
    feat = {f: sum(1 for t in tit if re.search(r, t.lower())) for f, r in
            [('giá', r'giá'), ('câu hỏi', r'là gì|\?|bao nhiêu|cách|như thế nào'),
             ('top/số', r'top|\d+\+? (đầu báo|báo|cách|mẫu|bước|loại|công cụ)'), ('năm', r'20\d\d'), ('dịch vụ', r'dịch vụ')]}
    dg = [(i + 1, u) for m in mem for i, u in enumerate(S[m]['urls']) if 'digicomvn.com' in u]
    kho_url = sorted({(kho.tu.get(m) or {}).get('url') or '' for m in mem} - {''})
    out.append(dict(loi=S[k]['kw'], tu=[(S[m]['kw'], V(m)) for m in mem], tong=sum(V(m) for m in mem),
                    dang_trang=dict(tc), dac_diem_tieu_de=feat, tieu_de=tit[:8], paa=S[k]['paa'][:400], ai=S[k]['ai'],
                    blocks=S[k]['blocks'], digicom=dg, kho_url=kho_url, urls=S[k]['urls'], nguon=S[k]['src']))
out.sort(key=lambda c: -c['tong'])
json.dump(out, open(B + '/clusters.json', 'w'), ensure_ascii=False, indent=1)
print(len(S), 'tu da do ->', len(out), 'cum')
for c in out: print(c['tong'], '|', ' ; '.join(f'{a} {b}' for a, b in c['tu'])[:120], '|', c['dang_trang'], '| dg', c['digicom'][:2], c['kho_url'][:2])
