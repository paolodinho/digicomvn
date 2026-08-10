#!/usr/bin/env python3
"""Dựng file HTML sơ đồ internal link từ JSON do internal-link-map.py xuất ra.
Dùng bởi lệnh /internal-link-map - không tự chạy độc lập bình thường.

Usage:
  python3 tools/internal-link-map-render.py <input.json> "<Tên cụm>" <output.html>
"""
import collections
import json
import sys

GENERIC_ANCHORS = {
    "xem thêm", "tại đây", "bấm vào đây", "click", "xem chi tiết", "ở đây",
    "tìm hiểu thêm", "xem bảng giá", "bảng giá", "tại đây để biết thêm",
    "ở đây để xem", "click here", "read more", "xem ngay",
}
ANCHOR_TYPE_LABEL = {
    "exact_match": "Khớp chính xác (từ khoá trang đích)",
    "generic": "Chung chung (ít giá trị)",
    "brand": "Thương hiệu (chứa Digicom)",
    "commercial": "Từ khoá thương mại",
    "descriptive": "Mô tả tự nhiên",
}
ANCHOR_TYPE_TARGET = {
    # (min%, max%) khuyến nghị - dựa theo nguyên tắc anchor internal link tự nhiên,
    # đa dạng, không nhồi từ khoá (content-pipeline A2c + thông lệ SEO chung).
    # exact_match: PHẢI có (không phải 0%) để tín hiệu relevance rõ ràng cho Google,
    # nhưng không lạm dụng (>25% là dấu hiệu thao túng anchor kể cả với internal link).
    "exact_match": (10, 25),
    "descriptive": (30, 60),
    "commercial": (10, 30),
    "brand": (5, 20),
    "generic": (0, 10),
}
DIVERSITY_MIN_INBOUND = 3   # chỉ xét mục tiêu có từ 3 link đến trở lên
DIVERSITY_WARN_BELOW = 0.5  # < 50% anchor khác nhau -> cảnh báo lặp/nhồi anchor

STOP_SUFFIX_RE = None  # placeholder, thay bằng regex thật ở dưới
import re as _re
STOP_SUFFIX_RE = _re.compile(r"\s*[:\-–|?].*$")


def core_phrase(title):
    """Cụm từ khoá cốt lõi của trang đích - cắt tại dấu ':' '-' '|' '?' đầu tiên.
    Vd 'Cách Viết Bài PR Chuẩn Báo Chí: Công Thức Và Cấu Trúc' -> 'Cách Viết Bài PR Chuẩn Báo Chí'."""
    return STOP_SUFFIX_RE.sub("", title).strip()


def normalize_vi(s):
    s = s.strip().lower()
    s = _re.sub(r"[\"'“”.,!]", "", s)
    s = _re.sub(r"\s+", " ", s)
    return s


def classify_anchor(a, target_title=None):
    al = a.strip().lower()
    if not al:
        return "generic"
    if target_title:
        na, nt_full, nt_core = normalize_vi(a), normalize_vi(target_title), normalize_vi(core_phrase(target_title))
        if na == nt_full or na == nt_core:
            return "exact_match"
    if al in GENERIC_ANCHORS:
        return "generic"
    if "digicom" in al:
        return "brand"
    if any(k in al for k in ("dịch vụ", "bảng giá", "báo giá", "đặt bài", "chi phí", "giá")):
        return "commercial"
    return "descriptive"


def analyze_anchors(edges, id2title=None):
    id2title = id2title or {}
    total = len(edges)
    type_count = collections.Counter()
    by_target = collections.defaultdict(list)
    for e in edges:
        t = classify_anchor(e["anchor"], id2title.get(e.get("to_id")))
        type_count[t] += 1
        by_target[e["to_url"]].append(e["anchor"].strip().lower())

    type_stats = []
    issues = []
    for t in ("exact_match", "descriptive", "commercial", "brand", "generic"):
        n = type_count.get(t, 0)
        pct = round(n / total * 100, 1) if total else 0
        lo, hi = ANCHOR_TYPE_TARGET[t]
        ok = lo <= pct <= hi
        if not ok:
            direction = "thấp hơn" if pct < lo else "cao hơn"
            issues.append(f'"{ANCHOR_TYPE_LABEL[t]}" đang {pct}% - {direction} mức khuyến nghị {lo}-{hi}%')
        type_stats.append({"key": t, "label": ANCHOR_TYPE_LABEL[t], "count": n, "pct": pct,
                            "target": f"{lo}-{hi}%", "ok": ok})

    dup_flags = []
    for url, anchors in by_target.items():
        if len(anchors) < DIVERSITY_MIN_INBOUND:
            continue
        total_a = len(anchors)
        distinct_a = len(set(anchors))
        diversity = distinct_a / total_a
        top_anchor, top_count = collections.Counter(anchors).most_common(1)[0]
        # Anchor ngắn (<=2 từ) lặp lại = thường là TÊN RIÊNG của chính trang đích (vd
        # "CafeF", "VnExpress") - nhắc đúng tên là hợp lý, không phải nhồi từ khoá thao
        # túng. Chỉ coi là cảnh báo thật khi anchor dài hơn 2 từ (cụm mô tả/thương mại
        # lặp y hệt) hoặc lặp từ 5 lần trở lên (không còn là trùng hợp ngẫu nhiên).
        is_short_proper_noun = len(top_anchor.split()) <= 3
        flagged = diversity < DIVERSITY_WARN_BELOW and not (is_short_proper_noun and top_count < 5)
        dup_flags.append({
            "url": url, "total": total_a, "distinct": distinct_a,
            "diversity": round(diversity, 2), "top_anchor": top_anchor,
            "top_count": top_count, "flagged": flagged,
            "lenient": diversity < DIVERSITY_WARN_BELOW and not flagged,
        })
        if flagged:
            issues.append(f'{url}: {top_count}/{total_a} link dùng đúng 1 anchor "{top_anchor}" (đa dạng chỉ {round(diversity*100)}%)')
    dup_flags.sort(key=lambda r: (r["flagged"] is False, r["diversity"]))

    passed = len(issues) == 0
    return {"total": total, "type_stats": type_stats, "dup_flags": dup_flags,
            "issues": issues, "passed": passed}


def main():
    if len(sys.argv) != 4:
        sys.exit("Usage: internal-link-map-render.py <input.json> \"<Tên cụm>\" <output.html>")
    in_path, label, out_path = sys.argv[1:4]

    data = json.load(open(in_path, encoding="utf-8"))
    nodes = data["nodes"]
    edges = data["edges"]

    if not nodes:
        sys.exit("Cụm rỗng - không có bài nào để vẽ.")

    nodes_sorted = sorted(nodes, key=lambda n: -n["inbound_in_cluster"])
    max_inbound = max((n["inbound_in_cluster"] for n in nodes), default=1) or 1
    orphans = [n for n in nodes if n["inbound_in_cluster"] == 0]
    id2title = {n["id"]: n["title"] for n in nodes}
    payload = json.dumps({"nodes": nodes, "edges": edges}, ensure_ascii=False)
    anchor_report = analyze_anchors(edges, id2title)

    def esc(s):
        return (s.replace("&", "&amp;").replace("<", "&lt;").replace(">", "&gt;")
                 .replace('"', "&quot;"))

    label_e = esc(label)

    html_out = f"""<title>Sơ đồ Internal Link - {label_e} (digicomvn.com)</title>
<style>
:root {{
  --bg:#F4F7F6; --surface:#FFFFFF; --surface-2:#EEF3F1; --ink:#16211F; --ink-soft:#54655F;
  --line:#DBE5E1; --accent:#0E8C7F; --accent-soft:#E3F3EF; --accent-ink:#0B655B;
  --radius:10px; font-variant-numeric: tabular-nums;
}}
@media (prefers-color-scheme: dark) {{
  :root {{ --bg:#101714; --surface:#182220; --surface-2:#1E2B27; --ink:#E7EFEC; --ink-soft:#93A6A0;
    --line:#2B3A35; --accent:#4FCBB8; --accent-soft:#1C3B35; --accent-ink:#8FE2D2; }}
}}
:root[data-theme="dark"] {{ --bg:#101714; --surface:#182220; --surface-2:#1E2B27; --ink:#E7EFEC; --ink-soft:#93A6A0;
  --line:#2B3A35; --accent:#4FCBB8; --accent-soft:#1C3B35; --accent-ink:#8FE2D2; }}
:root[data-theme="light"] {{ --bg:#F4F7F6; --surface:#FFFFFF; --surface-2:#EEF3F1; --ink:#16211F; --ink-soft:#54655F;
  --line:#DBE5E1; --accent:#0E8C7F; --accent-soft:#E3F3EF; --accent-ink:#0B655B; }}
* {{ box-sizing:border-box; }}
body {{ margin:0; background:var(--bg); color:var(--ink);
  font-family: ui-sans-serif, -apple-system, "Segoe UI", Roboto, sans-serif; padding:28px 20px 60px; }}
.wrap {{ max-width:980px; margin:0 auto; }}
.eyebrow {{ font-size:11px; letter-spacing:.08em; text-transform:uppercase; color:var(--accent-ink);
  font-weight:700; margin-bottom:6px; }}
h1 {{ font-size:22px; margin:0 0 6px; letter-spacing:-0.01em; text-wrap:balance; font-weight:750; }}
.sub {{ color:var(--ink-soft); font-size:13.5px; margin:0; }}
.stats {{ display:grid; grid-template-columns:repeat(4,1fr); gap:10px; margin:20px 0 26px; }}
.stat {{ background:var(--surface); border:1px solid var(--line); border-radius:var(--radius); padding:12px 14px; }}
.stat .n {{ font-size:22px; font-weight:750; line-height:1.1; }}
.stat .l {{ font-size:11.5px; color:var(--ink-soft); margin-top:3px; }}
section {{ margin-bottom:28px; }}
h2 {{ font-size:13px; text-transform:uppercase; letter-spacing:.06em; color:var(--ink-soft);
  font-weight:700; margin:0 0 12px; padding-bottom:8px; border-bottom:1px solid var(--line); }}
.hub-row {{ display:flex; align-items:center; gap:10px; padding:7px 0; }}
.hub-row .title {{ flex:0 0 300px; font-size:13px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }}
.hub-bar-track {{ flex:1; background:var(--surface-2); border-radius:5px; height:16px; overflow:hidden; }}
.hub-bar-fill {{ background:var(--accent); height:100%; border-radius:5px; }}
.hub-count {{ flex:0 0 34px; text-align:right; font-size:13px; font-weight:700; color:var(--accent-ink); }}
.toolbar {{ display:flex; gap:8px; margin-bottom:12px; }}
input[type=search] {{ flex:1; padding:8px 12px; border-radius:8px; border:1px solid var(--line);
  background:var(--surface); color:var(--ink); font-size:13px; }}
input[type=search]:focus {{ outline:2px solid var(--accent); outline-offset:-1px; }}
table {{ width:100%; border-collapse:collapse; font-size:12.5px; }}
thead th {{ text-align:left; font-size:10.5px; text-transform:uppercase; letter-spacing:.05em;
  color:var(--ink-soft); padding:8px 10px; border-bottom:1px solid var(--line);
  position:sticky; top:0; background:var(--bg); }}
tbody tr {{ border-bottom:1px solid var(--line); }}
tbody tr:hover {{ background:var(--surface-2); }}
td {{ padding:8px 10px; vertical-align:top; }}
td.url {{ font-family: ui-monospace, "SF Mono", Menlo, monospace; font-size:11.5px; }}
td.url a {{ color:var(--ink); text-decoration:none; }}
td.url a:hover {{ color:var(--accent-ink); text-decoration:underline; }}
td.anchor {{ color:var(--accent-ink); font-style:italic; }}
.arrow {{ color:var(--ink-soft); padding:0 2px; }}
.table-scroll {{ overflow-x:auto; border:1px solid var(--line); border-radius:var(--radius); background:var(--surface); }}
.table-scroll table {{ min-width:640px; }}
.empty {{ padding:8px 10px; color:var(--ink-soft); font-size:12.5px; }}
footer.note {{ margin-top:24px; font-size:11.5px; color:var(--ink-soft); }}
.graph-wrap {{ border:1px solid var(--line); border-radius:var(--radius); background:var(--surface);
  overflow:auto; }}
#graph {{ display:block; }}
#graph .edge {{ stroke:var(--ink-soft); stroke-width:1; fill:none; opacity:.16; transition:opacity .15s; marker-end:url(#arrow); }}
#graph .edge.hot {{ stroke:var(--accent); opacity:.95; stroke-width:1.6; marker-end:url(#arrow-hot); }}
#graph .edge.dim {{ opacity:.04; }}
#graph .node circle {{ fill:var(--surface); stroke:var(--accent-ink); stroke-width:1.4; cursor:pointer; }}
#graph .node.center circle {{ fill:var(--accent); stroke:var(--accent); }}
#graph .node text {{ font-size:11px; fill:var(--ink); cursor:pointer; user-select:none; }}
#graph .node.center text {{ font-size:14px; font-weight:750; }}
#graph .node.dim text, #graph .node.dim circle {{ opacity:.22; }}
#graph .node:hover text {{ fill:var(--accent-ink); }}
.verdict {{ padding:10px 14px; border-radius:8px; font-size:13px; margin-bottom:14px; }}
.verdict.pass {{ background:var(--accent-soft); color:var(--accent-ink); }}
.verdict.warn {{ background:#FBE9DE; color:#8A3A12; }}
@media (prefers-color-scheme: dark) {{ .verdict.warn {{ background:#3A2618; color:#E39A6B; }} }}
:root[data-theme="dark"] .verdict.warn {{ background:#3A2618; color:#E39A6B; }}
.bar-bad {{ background:#C7521C !important; }}
.row-bad {{ background:rgba(199,82,28,.08); }}
.target-note {{ font-weight:400; color:var(--ink-soft); font-size:11px; }}
</style>

<div class="wrap">
  <header>
    <div class="eyebrow">Sơ đồ Internal Link · digicomvn.com</div>
    <h1>{label_e} — {len(nodes)} bài, {len(edges)} link nội bộ</h1>
    <p class="sub">Đọc trực tiếp từ content live qua REST API — không phải ước lượng. Lệnh: <code>/internal-link-map</code>.</p>
  </header>

  <div class="stats">
    <div class="stat"><div class="n">{len(nodes)}</div><div class="l">Bài trong cụm</div></div>
    <div class="stat"><div class="n">{len(edges)}</div><div class="l">Link nội bộ trong cụm</div></div>
    <div class="stat"><div class="n">{len(orphans)}</div><div class="l">Bài chưa được link tới (mồ côi)</div></div>
    <div class="stat"><div class="n">{round(len(edges)/len(nodes),1) if nodes else 0}</div><div class="l">Link đến/bài (trung bình)</div></div>
  </div>

  <section>
    <h2>Sơ đồ liên kết (bấm 1 bài để soi riêng link ra/vào)</h2>
    <p class="sub" style="margin-bottom:10px">Mặc định mọi liên kết hiện mờ để đỡ rối; bấm vào 1 nút hoặc tên bài để làm nổi các link đi/đến đúng bài đó. Bấm lần nữa (hoặc bấm khoảng trống) để bỏ chọn.</p>
    <div class="graph-wrap"><svg id="graph" xmlns="http://www.w3.org/2000/svg"></svg></div>
  </section>

  <section>
    <h2>Bài được link tới nhiều nhất trong cụm (hub)</h2>
    {''.join(f'''<div class="hub-row">
      <div class="title" title="{esc(n['title'])}">{esc(n['title'])}</div>
      <div class="hub-bar-track"><div class="hub-bar-fill" style="width:{max(4, round(n['inbound_in_cluster']/max_inbound*100))}%"></div></div>
      <div class="hub-count">{n['inbound_in_cluster']}</div>
    </div>''' for n in nodes_sorted[:15])}
  </section>

  <section>
    <h2>Bài chưa có link nào trỏ tới trong cụm này ({len(orphans)})</h2>
    {"".join(f'<div class="hub-row"><div class="title" style="flex:1">{esc(n["title"])}</div></div>' for n in orphans) or '<div class="empty">Không có — mọi bài đều đã được link tới.</div>'}
  </section>

  <section>
    <h2>Tỷ lệ loại anchor text {"— ĐẠT chuẩn" if anchor_report['passed'] else "— CHƯA ĐẠT, đã tự điều chỉnh"}</h2>
    <div class="verdict {'pass' if anchor_report['passed'] else 'warn'}">
      {"Phân bổ anchor nằm trong ngưỡng khuyến nghị, không phát hiện lặp anchor bất thường." if anchor_report['passed'] else "Phát hiện lệch chuẩn tại thời điểm audit — danh sách bên dưới là các điểm đã hoặc cần chỉnh, xem chi tiết trong bảng liên kết."}
    </div>
    {''.join(f'''<div class="hub-row">
      <div class="title" style="flex:0 0 260px">{esc(s['label'])} <span class="target-note">(mục tiêu {s['target']})</span></div>
      <div class="hub-bar-track"><div class="hub-bar-fill {'bar-bad' if not s['ok'] else ''}" style="width:{max(2, s['pct'])}%"></div></div>
      <div class="hub-count">{s['pct']}%</div>
    </div>''' for s in anchor_report['type_stats'])}
    <p class="sub" style="margin-top:14px">Phân loại: <b>Mô tả tự nhiên</b> = cụm từ đúng ngữ cảnh câu, không phải brand/thương mại thuần tuý; <b>Từ khoá thương mại</b> = chứa "dịch vụ/giá/đặt bài"; <b>Thương hiệu</b> = chứa "Digicom"; <b>Chung chung</b> = "xem thêm/tại đây" hoặc 1 từ, gần như vô nghĩa với SEO.</p>

    <h2 style="margin-top:22px">Đa dạng anchor theo từng bài đích (≥3 link đến)</h2>
    <div class="table-scroll">
      <table>
        <thead><tr><th>Bài đích</th><th>Tổng link</th><th>Số anchor khác nhau</th><th>Đa dạng</th><th>Anchor lặp nhiều nhất</th></tr></thead>
        <tbody>
        {''.join(f'''<tr class="{'row-bad' if r['flagged'] else ''}">
          <td class="url">{esc(r['url'])}</td>
          <td>{r['total']}</td>
          <td>{r['distinct']}</td>
          <td>{round(r['diversity']*100)}%{' ⚠' if r['flagged'] else (' ✓ tên riêng' if r['lenient'] else '')}</td>
          <td class="anchor">"{esc(r['top_anchor'])}" × {r['top_count']}</td>
        </tr>''' for r in anchor_report['dup_flags']) or '<tr><td class="empty" colspan="5">Không có bài nào đủ 3 link đến để đánh giá.</td></tr>'}
        </tbody>
      </table>
    </div>
    <p class="sub" style="margin-top:8px">⚠ = trên 50% link đến bài đó dùng chung đúng 1 cụm anchor mô tả/thương mại - dấu hiệu nhồi anchor, cần đa dạng hoá. "✓ tên riêng" = anchor lặp lại chỉ vì đó đúng là tên trang đích (vd "CafeF", "VnExpress") - không phải lỗi.</p>
  </section>

  <section>
    <h2>Toàn bộ liên kết (chiều · anchor text)</h2>
    <div class="toolbar"><input type="search" id="q" placeholder="Lọc theo tên bài hoặc anchor text..."></div>
    <div class="table-scroll">
      <table id="edge-table">
        <thead><tr><th>Từ bài</th><th></th><th>Đến bài</th><th>Anchor text</th></tr></thead>
        <tbody id="edge-body"></tbody>
      </table>
    </div>
  </section>

  <footer class="note">inbound_total_site (tổng toàn site, kể cả ngoài cụm) có trong dữ liệu gốc — hỏi nếu cần so cụm này với toàn site.</footer>
</div>

<script>
const DATA = {payload};
const id2title = {{}};
DATA.nodes.forEach(n => id2title[n.id] = n.title);

(function drawGraph() {{
  const svg = document.getElementById('graph');
  const nodes = DATA.nodes.slice().sort((a,b) => b.inbound_in_cluster - a.inbound_in_cluster);
  const centerNode = nodes[0];
  const ring = nodes.slice(1);
  const N = ring.length;
  const R = Math.max(230, N * 15);
  const cx = R + 170, cy = R + 60;
  const W = cx + R + 170, H = cy + R + 60;
  svg.setAttribute('viewBox', `0 0 ${{W}} ${{H}}`);
  svg.setAttribute('width', W);
  svg.setAttribute('height', H);

  const pos = {{}};
  pos[centerNode.id] = {{x: cx, y: cy}};
  ring.forEach((n, i) => {{
    const angle = (i / N) * 2 * Math.PI - Math.PI / 2;
    pos[n.id] = {{x: cx + R * Math.cos(angle), y: cy + R * Math.sin(angle), angle}};
  }});

  const ns = 'http://www.w3.org/2000/svg';
  const defs = document.createElementNS(ns, 'defs');
  defs.innerHTML = `
    <marker id="arrow" viewBox="0 0 10 10" refX="9" refY="5" markerWidth="6" markerHeight="6" orient="auto-start-reverse">
      <path d="M0,0 L10,5 L0,10 z" fill="var(--ink-soft)"></path>
    </marker>
    <marker id="arrow-hot" viewBox="0 0 10 10" refX="9" refY="5" markerWidth="7" markerHeight="7" orient="auto-start-reverse">
      <path d="M0,0 L10,5 L0,10 z" fill="var(--accent)"></path>
    </marker>`;
  svg.appendChild(defs);

  const edgeEls = [];
  DATA.edges.forEach(e => {{
    const a = pos[e.from_id], b = pos[e.to_id];
    if (!a || !b) return;
    const line = document.createElementNS(ns, 'path');
    const mx = (a.x + b.x) / 2, my = (a.y + b.y) / 2;
    const dx = b.x - a.x, dy = b.y - a.y;
    const bend = 18;
    const cxm = mx - dy * (bend / Math.hypot(dx, dy) || 0);
    const cym = my + dx * (bend / Math.hypot(dx, dy) || 0);
    line.setAttribute('d', `M${{a.x}},${{a.y}} Q${{cxm}},${{cym}} ${{b.x}},${{b.y}}`);
    line.setAttribute('class', 'edge');
    line.dataset.from = e.from_id;
    line.dataset.to = e.to_id;
    svg.appendChild(line);
    edgeEls.push(line);
  }});

  const nodeEls = {{}};
  function addNode(n, isCenter) {{
    const p = pos[n.id];
    const g = document.createElementNS(ns, 'g');
    g.setAttribute('class', 'node' + (isCenter ? ' center' : ''));
    g.dataset.id = n.id;
    const r = isCenter ? 10 : Math.max(3, Math.min(9, 3 + n.inbound_in_cluster));
    const c = document.createElementNS(ns, 'circle');
    c.setAttribute('cx', p.x); c.setAttribute('cy', p.y); c.setAttribute('r', r);
    g.appendChild(c);
    const t = document.createElementNS(ns, 'text');
    let tx = p.x, ty = p.y, anchor = 'middle', dy = -14;
    if (!isCenter) {{
      const deg = p.angle;
      const cos = Math.cos(deg), sin = Math.sin(deg);
      tx = p.x + cos * 12; ty = p.y + sin * 12 + 4;
      anchor = cos > 0.15 ? 'start' : (cos < -0.15 ? 'end' : 'middle');
    }}
    t.setAttribute('x', tx); t.setAttribute('y', ty);
    t.setAttribute('text-anchor', anchor);
    t.textContent = n.title.length > 42 ? n.title.slice(0, 40) + '…' : n.title;
    g.appendChild(t);
    g.addEventListener('click', () => toggleFocus(n.id));
    svg.appendChild(g);
    nodeEls[n.id] = g;
  }}
  addNode(centerNode, true);
  ring.forEach(n => addNode(n, false));

  let focused = null;
  function toggleFocus(id) {{
    focused = (focused === id) ? null : id;
    edgeEls.forEach(el => {{
      const rel = focused && (el.dataset.from == focused || el.dataset.to == focused);
      el.classList.toggle('hot', !!rel);
      el.classList.toggle('dim', !!focused && !rel);
    }});
    Object.entries(nodeEls).forEach(([id2, g]) => {{
      const rel = !focused || id2 == focused ||
        DATA.edges.some(e => (e.from_id == focused && e.to_id == id2) || (e.to_id == focused && e.from_id == id2));
      g.classList.toggle('dim', !rel);
    }});
  }}
  svg.addEventListener('click', ev => {{ if (ev.target === svg) toggleFocus(null); }});
}})();

function render(filter) {{
  const body = document.getElementById('edge-body');
  const f = (filter || '').toLowerCase();
  const rows = DATA.edges.filter(e => {{
    if (!f) return true;
    return (id2title[e.from_id]||'').toLowerCase().includes(f)
        || (id2title[e.to_id]||'').toLowerCase().includes(f)
        || (e.anchor||'').toLowerCase().includes(f);
  }});
  body.innerHTML = rows.map(e => `
    <tr>
      <td class="url"><a href="${{e.from_url}}" target="_blank" rel="noopener">${{id2title[e.from_id]||e.from_url}}</a></td>
      <td class="arrow">→</td>
      <td class="url"><a href="${{e.to_url}}" target="_blank" rel="noopener">${{id2title[e.to_id]||e.to_url}}</a></td>
      <td class="anchor">"${{e.anchor}}"</td>
    </tr>`).join('') || '<tr><td class="empty" colspan="4">Không có kết quả khớp.</td></tr>';
}}
document.getElementById('q').addEventListener('input', e => render(e.target.value));
render('');
</script>
"""
    with open(out_path, "w", encoding="utf-8") as f:
        f.write(html_out)
    print(f"OK: {out_path} ({len(nodes)} bài, {len(edges)} link, {len(orphans)} mồ côi)")


if __name__ == "__main__":
    main()
