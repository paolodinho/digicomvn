#!/usr/bin/env python3
"""Payload nhom 4 (trang ha tang dung tpl-web / page-ten-mien / page-hosting).
Dung: build_nhom4.py <out.json>
- Doan dau (truoc H2 dau tien) -> excerpt (hero lead), bo khoi than bai.
- Muc H2 'Bang gia ...' quanh marker GIU KHOI bang gia -> thay bang <!-- dgc:bang-gia -->;
  H2 -> meta dgc_price_h, doan truoc marker -> dgc_price_intro, doan sau marker -> dgc_price_note.
  Marker khong nam trong muc 'Bang gia' -> giu vi tri, doan ngay sau marker -> dgc_price_note.
- FAQ -> svc_faqs (key = slug)."""
import re, sys, json, html, os
BASE = os.path.join(os.path.dirname(os.path.abspath(__file__)), '..', 'nhap')
PAGES = {'ten-mien': 472, 'hosting': 473, 'cloud-server': 7793, 'thiet-ke-website': 218,
         'cham-soc-website': 7789, 'email-doanh-nghiep': 7791, 'chung-chi-ssl': 7792,
         'dang-ky-website-bo-cong-thuong': 7790}
H1 = {'thiet-ke-website': 'Thiết kế website chuẩn SEO theo yêu cầu',
      'cloud-server': 'Cloud server (VPS) giá rẻ, tốc độ cao',
      'cham-soc-website': 'Dịch vụ chăm sóc website trọn gói',
      'email-doanh-nghiep': 'Email doanh nghiệp theo tên miền riêng',
      'chung-chi-ssl': 'Chứng chỉ SSL bảo mật website',
      'dang-ky-website-bo-cong-thuong': 'Đăng ký website Bộ Công Thương: thủ tục mới từ 01/7/2026'}
PARA = r'<!-- wp:paragraph -->\s*(<p>.*?</p>)\s*<!-- /wp:paragraph -->\s*'
H2 = r'<!-- wp:heading -->\s*<h2[^>]*>(.*?)</h2>\s*<!-- /wp:heading -->\s*'

def txt(h):
    return re.sub(r'\s+', ' ', html.unescape(re.sub(r'<[^>]+>', '', h))).strip()

def build(slug, pid):
    s = open(os.path.join(BASE, slug + '.html'), encoding='utf-8').read()
    m = re.match(r'\s*<!--(.*?)-->', s, re.S)
    head, body = m.group(1), s[m.end():]
    hdr = lambda k: (re.search(r'^' + re.escape(k) + r'[^:\n]*:\s*(.+)$', head, re.M) or [None, None])[1]
    MK = '\x00MK\x00'
    body = re.sub(r'<!--\s*GIU KHOI THEME:\s*(bang gia|tab nhom goi)[^>]*-->\s*', MK, body, flags=re.I)
    body = re.sub(r'(' + re.escape(MK) + r')+', MK, body)
    body = re.sub(r'<!--\s*(GIU KHOI THEME|GHI CHU).*?-->\s*', '', body, flags=re.S)
    body = body.lstrip()
    lead = ''
    lm = re.match(PARA, body, re.S)
    if lm:
        lead = txt(lm.group(1)); body = body[lm.end():]
    price_h = price_intro = price_note = ''
    if MK in body:
        i = body.index(MK)
        hs = [h for h in re.finditer(H2, body) if h.start() < i]
        nxt = re.search(H2, body[i:])
        end = i + (nxt.start() if nxt else len(body) - i)
        after_mk = body[i + len(MK):end]
        price_note = ' '.join(txt(p) for p in re.findall(PARA, after_mk, re.S))
        if hs and txt(hs[-1].group(1)).startswith('Bảng giá'):
            h = hs[-1]; price_h = txt(h.group(1))
            price_intro = ' '.join(txt(p) for p in re.findall(PARA, body[h.end():i], re.S))
            body = body[:h.start()] + '<!-- dgc:bang-gia -->\n' + body[end:]
        else:
            body = body[:i] + '<!-- dgc:bang-gia -->\n' + body[end:]
    faqs = []
    mm = re.search(r'<!-- wp:heading -->\s*<h2[^>]*>\s*Câu hỏi thường gặp\s*</h2>\s*<!-- /wp:heading -->', body)
    if mm:
        rest = body[mm.end():]
        nx = re.search(r'<!-- wp:heading -->\s*<h2', rest)
        sec = rest[:nx.start()] if nx else rest
        body = body[:mm.start()] + (rest[nx.start():] if nx else '')
        for q, a in re.findall(r'<h3[^>]*>(.*?)</h3>\s*<!-- /wp:heading -->(.*?)(?=<!-- wp:heading|\Z)', sec, re.S):
            faqs.append([txt(q).replace('|', ','), txt(a).replace('|', ',')])
    body = re.sub(r'\n{3,}', '\n\n', body).strip() + '\n'
    allt = body + lead + price_h + price_intro + price_note + json.dumps(faqs, ensure_ascii=False)
    assert '—' not in allt and '–' not in allt, slug
    assert MK not in body and 'GIU KHOI' not in body and 'GHI CHU' not in body, slug
    assert re.search(r'toà soạn|tòa soạn|nhà đài|pavietnam|P\.A', allt, re.I) is None, slug
    return dict(slug=slug, id=pid, content=body, excerpt=lead, h1=H1.get(slug, ''),
                seo_title=hdr('SEO title'), seo_desc=hdr('Meta description'),
                price_h=price_h, price_intro=price_intro, price_note=price_note,
                faqkey=slug, faqs=faqs)

items = [build(k, v) for k, v in PAGES.items()]
for it in items:
    print(f"{it['slug']}: lead={len(it['excerpt'])} mark={'dgc:bang-gia' in it['content']} ph='{it['price_h']}' intro={len(it['price_intro'])} note={len(it['price_note'])} faqs={len(it['faqs'])} words={len(txt(it['content']).split())}")
json.dump(items, open(sys.argv[1], 'w'), ensure_ascii=False)
