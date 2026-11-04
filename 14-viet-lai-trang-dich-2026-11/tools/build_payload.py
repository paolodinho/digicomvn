#!/usr/bin/env python3
"""Dung payload dang nhap len WP tu nhap/<slug>.html.
Dung: build_payload.py <out.json> slug=id[:faqkey] ...   (faqkey '-' = giu FAQ trong than bai)"""
import re, sys, json, html, os
BASE = os.path.join(os.path.dirname(os.path.abspath(__file__)), '..', 'nhap')

def hdr(head, key):
    m = re.search(r'^' + re.escape(key) + r'[^:\n]*:\s*(.+)$', head, re.M)
    return m.group(1).strip() if m else None

def txt(h):
    t = re.sub(r'<[^>]+>', '', h)
    t = html.unescape(t)
    return re.sub(r'\s+', ' ', t).strip().replace('|', ',')

def build(slug, pid, faqkey):
    s = open(os.path.join(BASE, slug + '.html'), encoding='utf-8').read()
    m = re.match(r'\s*<!--(.*?)-->', s, re.S)
    head = m.group(1); body = s[m.end():]
    body = re.sub(r'<!--\s*(GIU KHOI THEME|GHI CHU).*?-->\s*\n?', '', body, flags=re.S)
    faqs = []
    if faqkey != '-':
        mm = re.search(r'<!-- wp:heading -->\s*<h2[^>]*>\s*Câu hỏi thường gặp\s*</h2>\s*<!-- /wp:heading -->', body)
        if mm:
            rest = body[mm.end():]
            nx = re.search(r'<!-- wp:heading -->\s*<h2', rest)
            sec = rest[:nx.start()] if nx else rest
            body = body[:mm.start()] + (rest[nx.start():] if nx else '')
            for q, a in re.findall(r'<h3[^>]*>(.*?)</h3>\s*<!-- /wp:heading -->(.*?)(?=<!-- wp:heading|\Z)', sec, re.S):
                faqs.append([txt(q), txt(a)])
    body = re.sub(r'\n{3,}', '\n\n', body).strip() + '\n'
    bad = [c for c in ('—', '–') if c in body + json.dumps(faqs, ensure_ascii=False)]
    assert not bad, (slug, 'dash')
    assert 'GHI CHU' not in body and 'GIU KHOI' not in body, slug
    return dict(slug=slug, id=int(pid), content=body,
                excerpt=hdr(head, 'Mô tả hero'), h1=hdr(head, 'H1'),
                seo_title=hdr(head, 'SEO title'), seo_desc=hdr(head, 'Meta description'),
                faqkey=None if faqkey == '-' else faqkey, faqs=faqs)

out = sys.argv[1]; items = []
for a in sys.argv[2:]:
    slug, rest = a.split('=')
    pid, _, fk = rest.partition(':')
    it = build(slug, pid, fk or slug.split('_')[-1])
    print(f"{slug}: h1={bool(it['h1'])} title={len(it['seo_title'] or '')} desc={len(it['seo_desc'] or '')} excerpt={bool(it['excerpt'])} faqs={len(it['faqs'])} words={len(re.sub('<[^>]+>',' ',it['content']).split())}")
    items.append(it)
json.dump(items, open(out, 'w'), ensure_ascii=False)
