import html as _h
TEAL="#0E8C7F"; TINT="#F1FAF8"; BORDER="rgba(14,140,127,.22)"; INK="#3F4A5A"; HEAD="#1C2035"
def summary(items):
    li="".join(f"<li><strong>{a}:</strong> {b}</li>" for a,b in items)
    return f'<div class="dgc-summary">\n<p>Tóm tắt nhanh</p>\n<ul>{li}</ul>\n</div>\n'
def h2(i,t): return f'<h2 id="{i}">{t}</h2>\n'
def h3(t): return f'<h3>{t}</h3>\n'
def lead(t): return f'<p class="dgc-lead"><strong>{t}</strong></p>\n'
def p(*ts): return "".join(f"<p>{t}</p>\n" for t in ts)
def ul(items): return "<ul>"+"".join(f"<li>{x}</li>" for x in items)+"</ul>\n"
def _card(t,d,num=None,bg=TINT):
    n=f'<div aria-hidden="true" style="width:32px;height:32px;border-radius:50%;background:{TEAL};color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;margin-bottom:10px">{num}</div>' if num is not None else ""
    return (f'<li style="flex:1 1 260px;max-width:100%;background:{bg};border:1px solid {BORDER};border-radius:12px;padding:16px 18px;color:{INK}">'
            f'{n}<dl class="dl-card" style="margin:0"><dt style="font-weight:700;color:{HEAD};margin-bottom:4px">{t}</dt>'
            f'<dd style="font-size:13.5px;color:{INK};margin:0">{d}</dd></dl></li>\n')
def steps(items, ordered=True, cap=None):
    tag="ol" if ordered else "ul"
    out=f'<{tag} style="display:flex;flex-wrap:wrap;gap:14px;margin:20px 0;list-style:none;padding:0">\n'
    for k,(t,d) in enumerate(items,1): out+=_card(t,d,k if ordered else None)
    out+=f"</{tag}>\n"
    if cap: out+=f'<p style="font-size:13px;color:#5B6675;margin-top:-6px">{cap}</p>\n'
    return out
def cards(items, cap=None): return steps(items, ordered=False, cap=cap)
def tiers(items, cap=None):
    n=len(items); out='<ol style="list-style:none;padding:0;margin:20px 0;display:flex;flex-direction:column;align-items:center;gap:10px">\n'
    shades=["#E3F4F1","#C9EAE5","#A9DDD5","#86CFC4","#63C0B3"]
    for k,(t,d) in enumerate(items):
        w=int(55+45*k/max(1,n-1))
        out+=(f'<li style="width:{w}%;min-width:240px;max-width:100%;box-sizing:border-box;background:{shades[k%5]};border:1px solid {BORDER};border-radius:10px;padding:12px 16px;text-align:center;color:{HEAD}">'
              f'<dl class="dl-card" style="margin:0"><dt style="font-weight:700;margin-bottom:4px">{t}</dt><dd style="font-size:13.5px;color:{INK};margin:0">{d}</dd></dl></li>\n')
    out+="</ol>\n"
    if cap: out+=f'<p style="font-size:13px;color:#5B6675;margin-top:-6px;text-align:center">{cap}</p>\n'
    return out
def compare(a_title,a_items,b_title,b_items,cap=None):
    def col(t,items,bg,bc):
        li="".join(f'<li style="margin:0 0 6px">{x}</li>' for x in items)
        return (f'<div style="flex:1 1 280px;max-width:100%;box-sizing:border-box;background:{bg};border:1px solid {bc};border-radius:12px;padding:16px 18px;color:{INK}">'
                f'<p style="font-weight:700;color:{HEAD};margin:0 0 8px">{t}</p><ul style="margin:0;padding-left:18px;font-size:14px">{li}</ul></div>\n')
    out='<div style="display:flex;flex-wrap:wrap;gap:14px;margin:20px 0">\n'+col(a_title,a_items,"#FFFFFF","#E2E8F0")+col(b_title,b_items,TINT,BORDER)+"</div>\n"
    if cap: out+=f'<p style="font-size:13px;color:#5B6675;margin-top:-6px">{cap}</p>\n'
    return out
def table(caption, heads, rows):
    th="".join(f"<th>{x}</th>" for x in heads)
    body=""
    for r in rows:
        body+="<tr>"+"".join(f'<td data-label="{_h.escape(heads[i],quote=True)}">{c}</td>' for i,c in enumerate(r))+"</tr>\n"
    return ('<figure class="wp-block-table dgc-data-table">\n<table>\n'
            '<caption style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0">'
            f'{caption}</caption>\n<thead><tr>{th}</tr></thead>\n<tbody>\n{body}</tbody>\n</table>\n</figure>\n')
def ext(url,text,rel="noopener"): return f'<a href="{url}" target="_blank" rel="{rel}">{text}</a>'
def a(url,text): return f'<a href="{url}">{text}</a>'
