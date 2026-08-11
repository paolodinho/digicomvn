#!/usr/bin/env python3
"""QA: phat hien khoi card (badge so, dl-card, <strong> tieu de) dang nam trong <div>
phang thay vi <ol>/<ul> - vi pham content-diagram-explain.md muc "The doi co thu tu".
Chi PHAT HIEN, KHONG tu sua (sua tu dong da gay 1 lan hong trang live 2026-08-10 do bug
danh dau tag luc de quy - xem LOG.md). Phat hien loi -> sua tay theo mau trong rule.

Chay: python3 tools/list-semantic-qa.py            # quet toan bo bai/trang publish
      python3 tools/list-semantic-qa.py <id>        # quet 1 post id
Can .claude/secrets/wp_app.json (app password) de doc content.raw qua REST context=edit.
"""
import json, os, re, sys, urllib.request, base64

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
CRED_PATH = os.path.join(ROOT, '.claude', 'secrets', 'wp_app.json')
VOID = {'img', 'br', 'hr', 'input', 'meta', 'link', 'area', 'base', 'col', 'embed', 'source', 'track', 'wbr'}
TAG_RE = re.compile(r'<(/?)([a-zA-Z0-9]+)([^>]*?)(/?)>')


def load_cred():
    c = json.load(open(CRED_PATH))
    return c['site'].rstrip('/'), c['username'], c['app_password']


def api(url, user, pw):
    req = urllib.request.Request(url)
    token = base64.b64encode(f'{user}:{pw}'.encode()).decode()
    req.add_header('Authorization', 'Basic ' + token)
    return json.loads(urllib.request.urlopen(req, timeout=30).read())


def top_level_children(html):
    toks = list(TAG_RE.finditer(html))
    depth = 0
    stack = []
    children = []
    cur = None
    for t in toks:
        closing, name, _, selfclose = t.group(1), t.group(2).lower(), t.group(3), t.group(4)
        is_void = name in VOID or selfclose == '/'
        if not closing:
            if depth == 0:
                cur = {'tag': name, 'start': t.start(), 'open_end': t.end()}
            if not is_void:
                depth += 1
                stack.append(name)
        else:
            if not is_void:
                if stack and stack[-1] == name:
                    stack.pop()
                depth -= 1
                if depth == 0 and cur is not None:
                    cur['end'] = t.end()
                    cur['close_start'] = t.start()
                    cur['inner'] = html[cur['open_end']:cur['close_start']]
                    children.append(cur)
                    cur = None
    return children


def is_card_text(text):
    if 'border-radius:50%' in text or 'dl-card' in text:
        return True
    stripped = text.strip()
    if '<div' not in stripped:
        if stripped.startswith('<strong'):
            return True
        if re.match(r'^<p\b[^>]*font-weight:7', stripped):
            return True
    badge_m = re.match(r'^<div\b[^>]*style="([^"]*)"', stripped)
    if badge_m:
        style = badge_m.group(1)
        has_wh = (re.search(r'(?:^|;)(?:min-)?width:(\d{2})px;height:\1px', style)
                  or re.search(r'(?:^|;)height:(\d{2})px;(?:min-)?width:\1px', style))
        if has_wh and 'border-radius' in style:
            return True
    return False


def block_has_candidates(block):
    if re.match(r'^\s*<(ol|ul)\b', block):
        return False
    if 'border-radius:50%' in block or block.count('dl-card') >= 2:
        return True
    if block.count('<strong') >= 2:
        return True
    if block.count('border-radius') >= 3:
        return True
    if len(re.findall(r'<p\b[^>]*font-weight:7', block)) >= 2:
        return True
    return False


def find_unwrapped_lists(inner, depth=0, path='root'):
    """Recursively find any div whose direct children are >=2 divs, all div,
    >=2 of which look like cards - i.e. should be <ol>/<ul> but isn't."""
    hits = []
    children = top_level_children(inner)
    for c in children:
        if c['tag'] == 'div':
            hits += find_unwrapped_lists(c['inner'], depth + 1, path + '>div')
    div_children = [c for c in children if c['tag'] == 'div']
    if (len(children) >= 2 and len(div_children) == len(children)
            and sum(1 for c in div_children if is_card_text(c['inner'])) >= 2):
        sample = re.sub(r'<[^>]+>', ' ', div_children[0]['inner']).strip()[:60]
        hits.append((depth, len(div_children), sample))
    return hits


def check_post(raw):
    findings = []
    for m in re.finditer(r'<!-- wp:html -->\n(.*?)\n<!-- /wp:html -->', raw, re.S):
        block = m.group(1)
        if not block_has_candidates(block):
            continue
        stripped = block.strip()
        top = top_level_children(stripped)
        for t in top:
            if t['tag'] == 'div':
                findings += find_unwrapped_lists(t['inner'])
    return findings


def main():
    site, user, pw = load_cred()
    if len(sys.argv) > 1:
        items = [(sys.argv[1], 'posts')]
    else:
        items = []
        for kind in ('posts', 'pages'):
            page = 1
            while True:
                url = f'{site}/wp-json/wp/v2/{kind}?per_page=100&page={page}&status=publish&_fields=id,slug'
                res = api(url, user, pw)
                if not res:
                    break
                items += [(p['id'], kind) for p in res]
                if len(res) < 100:
                    break
                page += 1

    total_findings = 0
    for pid, kind in items:
        url = f'{site}/wp-json/wp/v2/{kind}/{pid}?context=edit&_fields=content,link'
        res = api(url, user, pw)
        raw = res.get('content', {}).get('raw', '')
        link = res.get('link', pid)
        if not raw:
            continue
        findings = check_post(raw)
        if findings:
            total_findings += len(findings)
            print(f'LOI  {link}')
            for depth, n, sample in findings:
                print(f'      - depth={depth} {n} the card chua boc ol/ul (mau: "{sample}...")')
    print(f'\n=== {len(items)} URL | {total_findings} khoi chua boc list ===')


if __name__ == '__main__':
    main()
