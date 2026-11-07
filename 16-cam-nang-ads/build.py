#!/usr/bin/env python3
"""Dựng cẩm nang tra cứu Google Ads + Meta Ads + SEO + Hỏi đáp diễn đàn thành trang tĩnh.
Dữ liệu: google.json, meta.json, seo.json, faq-google.json, faq-meta.json, faq-seo.json (xem SCHEMA.md).
Ra: dist/index.html (giao diện + dữ liệu nhúng), dist/data.json (chỉ mục cho ask.php), dist/ask.php, dist/.htaccess.
Đẩy: deploy.sh. Trang noindex, không link từ đâu, không có trong sitemap.
"""
import html, json, math, os, re, shutil, unicodedata
from collections import Counter

HERE = os.path.dirname(os.path.abspath(__file__))
DIST = os.path.join(HERE, "dist")
FILES = [("google", "google.json", "Google Ads"), ("meta", "meta.json", "Meta Ads"), ("seo", "seo.json", "SEO"),
         ("faq-google", "faq-google.json", "Hỏi đáp Google Ads"), ("faq-meta", "faq-meta.json", "Hỏi đáp Meta Ads"),
         ("faq-seo", "faq-seo.json", "Hỏi đáp SEO")]
STOP = set("la va co cua khong thi nao gi lam sao bi duoc toi minh em anh chi cho voi de da dang se nen hay hoac khi neu roi gio con nhu ve tu o tren trong bao nhieu the nay do ma vay a nua moi van cung rat qua".split())


def clean(s):
    return re.sub("[–—]", "-", str(s or ""))


def deep_clean(o):
    if isinstance(o, str):
        return clean(o)
    if isinstance(o, list):
        return [deep_clean(x) for x in o]
    if isinstance(o, dict):
        return {k: deep_clean(v) for k, v in o.items()}
    return o


def norm(s):
    s = unicodedata.normalize("NFD", str(s or "").lower())
    s = "".join(c for c in s if unicodedata.category(c) != "Mn").replace("đ", "d")
    return re.sub(r"[^a-z0-9\s]+", " ", s)


def count(nodes):
    return sum(1 + count(n.get("children") or []) for n in nodes)


def flatten(pane, title, groups):
    out = []

    def walk(n, g, path):
        text = " ".join([n.get("if", ""), n.get("tomtat", ""), n.get("visao", "")] + (n.get("check") or []) + (n.get("do") or []) + (n.get("avoid") or []) + (n.get("asked") or []))
        toks = [w for w in norm(text).split() if len(w) > 1]
        out.append({"id": n["id"], "pane": pane, "path": " › ".join(path), "if": n.get("if", ""), "tomtat": n.get("tomtat", ""), "visao": n.get("visao", ""), "check": n.get("check") or [],
                    "do": n.get("do") or [], "avoid": n.get("avoid") or [], "hat": n.get("hat", "white"), "evidence": n.get("evidence", ""),
                    "sources": n.get("sources") or [], "t": " ".join(toks), "tf": dict(Counter(w for w in toks if w not in STOP)), "len": len(toks)})
        for c in n.get("children") or []:
            walk(c, g, path + [n.get("if", "")[:60]])

    for g in groups:
        for n in g.get("nodes") or []:
            walk(n, g, [title, g["title"]])
    return out


def main():
    panes, flat, ids = {}, [], set()
    for key, fn, title in FILES:
        p = os.path.join(HERE, fn)
        if not os.path.exists(p):
            print(f"bỏ qua (chưa có): {fn}")
            continue
        d = deep_clean(json.load(open(p, encoding="utf-8")))
        groups = d.get("groups") or []
        for g in groups:
            for n in g.get("nodes") or []:
                pass
        total = sum(count(g.get("nodes") or []) for g in groups)
        panes[key] = {"title": title, "updated": d.get("updated", ""), "groups": groups, "total": total}
        fl = flatten(key, title, groups)
        for n in fl:
            if n["id"] in ids:
                raise SystemExit(f"ID trùng: {n['id']} ({fn})")
            ids.add(n["id"])
        flat += fl
        print(f"{fn}: {len(groups)} nhóm / {total} mục")
    df = Counter()
    for n in flat:
        df.update(n["tf"].keys())
    avglen = sum(n["len"] for n in flat) / max(1, len(flat))
    data = {"panes": panes}
    tpl = open(os.path.join(HERE, "template.html"), encoding="utf-8").read()
    ng = panes.get("google", {}).get("total", 0); nm = panes.get("meta", {}).get("total", 0); ns = panes.get("seo", {}).get("total", 0)
    nf = sum(panes.get(k, {}).get("total", 0) for k in ("faq-google", "faq-meta", "faq-seo"))
    upd = max([p["updated"] for p in panes.values()] or [""])
    out = (tpl.replace("{{DATA}}", json.dumps(data, ensure_ascii=False).replace("</", "<\\/"))
           .replace("{{NG}}", str(ng)).replace("{{NM}}", str(nm)).replace("{{NS}}", str(ns)).replace("{{NF}}", str(nf)).replace("{{UPDATED}}", clean(upd)))
    os.makedirs(DIST, exist_ok=True)
    open(os.path.join(DIST, "index.html"), "w", encoding="utf-8").write(out)
    json.dump({"nodes": flat, "df": dict(df), "avglen": avglen}, open(os.path.join(DIST, "data.json"), "w", encoding="utf-8"), ensure_ascii=False)
    shutil.copy(os.path.join(HERE, "ask.php"), os.path.join(DIST, "ask.php"))
    open(os.path.join(DIST, ".htaccess"), "w").write(
        'Header set X-Robots-Tag "noindex, nofollow, noarchive"\n'
        'Header set Cache-Control "no-cache"\n'
        'Options -Indexes\n'
        '<Files "data.json">\n  Header set X-Robots-Tag "noindex, nofollow"\n</Files>\n')
    print(f"OK: Google {ng}, Meta {nm}, SEO {ns}, Hỏi đáp {nf} -> {DIST}/index.html ({os.path.getsize(os.path.join(DIST, 'index.html'))//1024} KB)")


if __name__ == "__main__":
    main()
