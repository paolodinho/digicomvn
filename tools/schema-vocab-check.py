#!/usr/bin/env python3
"""
Kiem dinh JSON-LD toan site theo TU VUNG SCHEMA.ORG CHINH THUC (tai truc tiep tu schema.org).

Vi sao can: validator.schema.org gioi han so luot goi (HTTP 429) nen khong quet duoc ca site.
Script nay lam dung phan quan trong nhat cua no, chay offline sau khi tai tu vung 1 lan:

  1. Moi @type dung tren site co that trong schema.org khong?
  2. Moi thuoc tinh co that khong?
  3. Thuoc tinh co HOP LE voi kieu cua node do khong (domainIncludes, tinh ca lop cha)?
     -> Day chinh la loi da dinh 2026-07-27: "inLanguage" tren Organization.

Chay: python3 tools/schema-vocab-check.py
"""
import json, re, sys, urllib.request, os, concurrent.futures as cf

SITE = 'https://digicomvn.com'
VOCAB_URL = 'https://schema.org/version/latest/schemaorg-current-https.jsonld'
CACHE = os.path.join(os.path.dirname(os.path.abspath(__file__)), '.schemaorg-vocab.jsonld')
UA = {'User-Agent': 'Mozilla/5.0 (schema-vocab-check)'}

# Khoa cua JSON-LD, khong phai thuoc tinh schema.org -> bo qua khi kiem tra.
JSONLD_KEYS = {'@context', '@type', '@id', '@graph', '@value', '@language', '@list', '@set'}

# Phan mo rong CHINH THUC cua Google, khong nam trong tu vung loi schema.org nhung
# BAT BUOC phai co theo tai lieu Sitelinks Searchbox. Khong phai loi.
GOOGLE_EXTRA = {'query-input'}


def get(url, timeout=60):
    return urllib.request.urlopen(urllib.request.Request(url, headers=UA), timeout=timeout).read().decode('utf-8', 'ignore')


def short(x):
    """
    Rut gon dinh danh ve ten tran.
    Luu y: file tu vung dung dang RUT GON ("schema:Person"), khong phai URL day du.
    Phai cat ca tien to namespace, neu khong se so "schema:Person" voi "Person" -> bao loi gia.
    Tra '' cho cac vocab khac (bibo:, dcterms:...) de khong lan voi schema.org.
    """
    if isinstance(x, dict):
        x = x.get('@id', '')
    x = str(x).rsplit('/', 1)[-1].rsplit('#', 1)[-1]
    if ':' in x:
        pre, name = x.split(':', 1)
        return name if pre == 'schema' else ''
    return x


def load_vocab():
    if not os.path.exists(CACHE):
        open(CACHE, 'w', encoding='utf-8').write(get(VOCAB_URL))
    graph = json.load(open(CACHE, encoding='utf-8'))['@graph']

    parents, classes, props = {}, set(), {}
    for n in graph:
        nid = short(n.get('@id'))
        if not nid:
            continue
        types = n.get('@type', [])
        types = types if isinstance(types, list) else [types]
        if 'rdfs:Class' in types:
            classes.add(nid)
            sup = n.get('rdfs:subClassOf', [])
            sup = sup if isinstance(sup, list) else [sup]
            parents[nid] = [short(s) for s in sup]
        if 'rdf:Property' in types:
            dom = n.get('schema:domainIncludes', [])
            dom = dom if isinstance(dom, list) else [dom]
            props[nid] = {short(d) for d in dom}
    return classes, parents, props


def ancestors(t, parents, seen=None):
    seen = seen or set()
    if t in seen:
        return seen
    seen.add(t)
    for p in parents.get(t, []):
        ancestors(p, parents, seen)
    return seen


def sitemap_urls():
    out = []
    for sm in ['posts-post-1', 'posts-page-1', 'posts-dgc_case-1', 'taxonomies-category-1', 'users-1']:
        try:
            out += re.findall(r'<loc>([^<]+)</loc>', get(f'{SITE}/wp-sitemap-{sm}.xml'))
        except Exception:
            pass
    return sorted(set(out))


def walk(node, classes, parents, props, errs, path='$'):
    """Duyet de quy 1 node JSON-LD, kiem type + tung thuoc tinh."""
    if isinstance(node, list):
        for i, x in enumerate(node):
            walk(x, classes, parents, props, errs, f'{path}[{i}]')
        return
    if not isinstance(node, dict):
        return

    types = node.get('@type')
    types = [] if types is None else (types if isinstance(types, list) else [types])
    for t in types:
        if t not in classes:
            errs.append(f'{path}: @type khong ton tai trong schema.org -> "{t}"')

    # Tap hop moi lop cha cua tat ca kieu cua node -> de doi chieu domainIncludes.
    allowed = set()
    for t in types:
        allowed |= ancestors(t, parents)

    for k, v in node.items():
        if k in JSONLD_KEYS or k in GOOGLE_EXTRA:
            pass
        elif k not in props:
            errs.append(f'{path}: thuoc tinh khong ton tai -> "{k}"')
        elif types and props[k] and not (props[k] & allowed):
            errs.append(f'{path}: "{k}" khong hop le voi {"+".join(types)} '
                        f'(chi dung cho: {", ".join(sorted(props[k]))})')
        walk(v, classes, parents, props, errs, f'{path}.{k}')


def check(url, classes, parents, props):
    try:
        html = get(url)
    except Exception as e:
        return url, [f'FETCH: {e}']
    errs = []
    for blk in re.findall(r'<script type="application/ld\+json">(.*?)</script>', html, re.S):
        try:
            data = json.loads(blk)
        except Exception as e:
            errs.append(f'JSON khong parse duoc: {e}')
            continue
        walk(data.get('@graph', data), classes, parents, props, errs)
    return url, errs


def main():
    classes, parents, props = load_vocab()
    print(f'Tu vung schema.org: {len(classes)} lop, {len(props)} thuoc tinh')
    urls = sys.argv[1:] or sitemap_urls()
    print(f'Kiem tra {len(urls)} URL...')
    bad = 0
    # Toi da 3 luong: nhieu hon lam host qua tai -> HTTP 500 -> bao loi gia.
    with cf.ThreadPoolExecutor(3) as ex:
        for u, e in ex.map(lambda x: check(x, classes, parents, props), urls):
            if e:
                bad += 1
                print('LOI ', u)
                for x in sorted(set(e)):
                    print('      -', x)
    print(f'\n=== {len(urls)} URL | {bad} URL co loi tu vung ===')
    return 1 if bad else 0


if __name__ == '__main__':
    sys.exit(main())
