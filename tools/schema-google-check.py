#!/usr/bin/env python3
"""
Kiem TOAN SITE theo YEU CAU BAT BUOC CUA GOOGLE cho tung loai rich result,
+ tinh toan ven cua tham chieu @id trong do thi thuc the.

Vi sao co file nay: validator.schema.org chan 429 rat som (~10-15 luot/gio) nen khong the
dung de quet ca site. Bo ba script tu kiem thay the no:
  - schema-qa.py          : cau truc chung (1 khoi/trang, JSON hop le, khong truong rong)
  - schema-vocab-check.py : @type + thuoc tinh co that va dung domainIncludes (schema.org)
  - schema-google-check.py: (file nay) thuoc tinh BAT BUOC theo tai lieu Google + @id khong treo

Chay: python3 tools/schema-google-check.py
"""
import json, re, sys, urllib.request, concurrent.futures as cf

SITE = 'https://digicomvn.com'
UA = {'User-Agent': 'Mozilla/5.0 (schema-google-check)'}


def get(url, timeout=60):
    return urllib.request.urlopen(urllib.request.Request(url, headers=UA), timeout=timeout).read().decode('utf-8', 'ignore')


def types_of(node):
    t = node.get('@type')
    if t is None:
        return []
    return t if isinstance(t, list) else [t]


def has(node, key):
    v = node.get(key)
    return v not in (None, '', [], {})


def check_graph(graph, url):
    """Tra ve (loi_bat_buoc, tham_chieu_@id_ngoai_do_thi)."""
    errs, refs = [], set()
    by_id = {n['@id']: n for n in graph if isinstance(n, dict) and n.get('@id')}

    def collect_refs(x):
        """Node chi co DUY NHAT khoa @id = mot tham chieu, khong phai dinh nghia."""
        if isinstance(x, list):
            for i in x:
                collect_refs(i)
        elif isinstance(x, dict):
            if set(x.keys()) == {'@id'}:
                refs.add(x['@id'])
            for v in x.values():
                collect_refs(v)

    collect_refs(graph)

    for n in graph:
        if not isinstance(n, dict):
            continue
        ts = types_of(n)

        # --- Organization / LocalBusiness (Google: name + url; LocalBusiness them address) ---
        if 'Organization' in ts:
            for k in ('name', 'url'):
                if not has(n, k):
                    errs.append(f'Organization thieu {k} (Google bat buoc)')
            if any(t in ts for t in ('LocalBusiness', 'ProfessionalService')):
                if not has(n, 'address'):
                    errs.append('LocalBusiness/ProfessionalService thieu address (Google bat buoc)')
                for k in ('telephone', 'image', 'priceRange'):
                    if not has(n, k):
                        errs.append(f'LocalBusiness nen co {k} (Google khuyen nghi)')

        # --- Article ---
        if 'Article' in ts or 'BlogPosting' in ts:
            for k in ('headline', 'image', 'datePublished', 'author', 'publisher'):
                if not has(n, k):
                    errs.append(f'Article thieu {k} (Google bat buoc)')
            if len(str(n.get('headline', ''))) > 110:
                errs.append('Article.headline > 110 ky tu (Google cat bot)')

        # --- BreadcrumbList ---
        if 'BreadcrumbList' in ts:
            items = n.get('itemListElement') or []
            if len(items) < 2:
                errs.append('BreadcrumbList < 2 muc (Google bo qua)')
            for i, it in enumerate(items):
                if it.get('position') != i + 1:
                    errs.append('BreadcrumbList.position khong lien tuc tu 1')
                if not has(it, 'name'):
                    errs.append('ListItem thieu name (Google bat buoc)')
                if i < len(items) - 1 and not has(it, 'item'):
                    errs.append('ListItem giua chuoi thieu item (Google bat buoc)')

        # --- FAQPage ---
        if 'FAQPage' in ts:
            me = n.get('mainEntity')
            me = me if isinstance(me, list) else ([me] if me else [])
            qs = [q for q in me if isinstance(q, dict) and q.get('@type') == 'Question']
            if not qs:
                errs.append('FAQPage khong co Question nao (Google bat buoc)')
            for q in qs:
                if not has(q, 'name'):
                    errs.append('Question thieu name')
                if not (q.get('acceptedAnswer') or {}).get('text'):
                    errs.append('Question thieu acceptedAnswer.text')

        # --- ProfilePage (Google: mainEntity la Person/Organization co name) ---
        if 'ProfilePage' in ts:
            me = n.get('mainEntity')
            if not me:
                errs.append('ProfilePage thieu mainEntity (Google bat buoc)')

        # --- Offer / AggregateOffer ---
        if 'Offer' in ts:
            for k in ('price', 'priceCurrency'):
                if not has(n, k):
                    errs.append(f'Offer thieu {k} (Google bat buoc)')
        if 'AggregateOffer' in ts:
            for k in ('lowPrice', 'priceCurrency'):
                if not has(n, k):
                    errs.append(f'AggregateOffer thieu {k} (Google bat buoc)')
            try:
                if float(n.get('lowPrice', 0)) > float(n.get('highPrice', n.get('lowPrice', 0))):
                    errs.append('AggregateOffer lowPrice > highPrice')
            except (TypeError, ValueError):
                errs.append('AggregateOffer gia khong phai so')

        # --- SearchAction (sitelinks searchbox) ---
        if 'SearchAction' in ts:
            tpl = ((n.get('target') or {}).get('urlTemplate')) if isinstance(n.get('target'), dict) else n.get('target')
            if not tpl or '{search_term_string}' not in str(tpl):
                errs.append('SearchAction.target thieu {search_term_string}')
            if 'query-input' not in n:
                errs.append('SearchAction thieu query-input (Google bat buoc)')

    ngoai = {r for r in refs if r not in by_id}
    return errs, ngoai


def check(url):
    try:
        html = get(url)
    except Exception as e:
        return url, [f'FETCH: {e}'], set()
    blocks = re.findall(r'<script type="application/ld\+json">(.*?)</script>', html, re.S)
    if not blocks:
        return url, ['khong co JSON-LD'], set()
    try:
        data = json.loads(blocks[0])
    except Exception as e:
        return url, [f'JSON loi: {e}'], set()
    graph = data.get('@graph', [data])
    e, ngoai = check_graph(graph, url)
    return url, e, ngoai


def main():
    urls = sys.argv[1:]
    if not urls:
        for sm in ['posts-post-1', 'posts-page-1', 'posts-dgc_case-1', 'taxonomies-category-1', 'users-1']:
            try:
                urls += re.findall(r'<loc>([^<]+)</loc>', get(f'{SITE}/wp-sitemap-{sm}.xml'))
            except Exception:
                pass
        urls = sorted(set(urls))
    print(f'Kiem tra {len(urls)} URL theo yeu cau Google...')

    bad, all_refs = 0, set()
    # Toi da 3 luong (nhieu hon -> host qua tai -> HTTP 500 -> loi gia).
    with cf.ThreadPoolExecutor(3) as ex:
        for u, e, ngoai in ex.map(check, urls):
            all_refs |= ngoai
            if e:
                bad += 1
                print('LOI ', u)
                for x in sorted(set(e)):
                    print('      -', x)

    # Tham chieu @id tro sang trang KHAC la hop le, nhung trang do phai ton tai that.
    print(f'\nTham chieu @id ra ngoai do thi cua trang: {len(all_refs)} dinh danh - kiem tra ton tai...')
    treo = []
    for r in sorted(all_refs):
        base = r.split('#')[0]
        if not base.startswith(SITE):
            continue
        try:
            urllib.request.urlopen(urllib.request.Request(base, headers=UA), timeout=30).read(1)
        except Exception as ex2:
            treo.append(f'{r}  ->  {ex2}')
    for t in treo:
        print('  TREO:', t)

    print(f'\n=== {len(urls)} URL | {bad} URL loi yeu cau Google | {len(treo)} tham chieu @id treo ===')
    return 1 if (bad or treo) else 0


if __name__ == '__main__':
    sys.exit(main())
