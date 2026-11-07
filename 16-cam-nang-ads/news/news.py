#!/usr/bin/env python3
"""Tin tức hằng tuần cho cẩm nang Ads + SEO (chạy trên VPS, cron thứ Hai).

Việc làm mỗi lượt:
  1. Kéo RSS/JSON từ nguồn chính thức + chuyên trang của 3 mảng: Google Ads, Meta Ads, SEO.
  2. Lọc theo từ khoá (thuật toán, chính sách, tính năng, đo lường...), bỏ tin đã thấy.
  3. Gọi OpenRouter (model free trước, rule no-claude-in-automation) chọn tin đáng biết, viết tiêu đề +
     tóm tắt + "ảnh hưởng tới mình" bằng tiếng Việt. Model lỗi thì vẫn giữ tin chính thức với tiêu đề gốc.
  4. Ghi news.json (giữ 26 tuần), đẩy lên Hostinger cạnh index.html của cẩm nang.
Tin của lượt mới nhất = "Tin mới" (nổi bật trên trang).

  python3 news.py               # chạy thật
  python3 news.py --dry         # không gọi LLM, không đẩy; in ứng viên
  python3 news.py --days 30     # lấy ứng viên 30 ngày (lần đầu)
  python3 news.py --no-push     # không đẩy lên Hostinger
"""
import argparse, datetime as dt, email.utils, hashlib, html, json, re, subprocess, sys, time, urllib.request
import xml.etree.ElementTree as ET
from pathlib import Path

HERE = Path(__file__).resolve().parent
STATE = HERE / "state.json"          # id đã thấy
OUT = HERE / "news.json"             # dữ liệu trang
KEY_FILE = Path("/root/.config/jim/openrouter_key")
REMOTE = "hostinger:/home/u704250056/domains/digicomvn.com/public_html/cam-nang-ads-f974783be693/news.json"
MODELS = ["nvidia/nemotron-3-ultra-550b-a55b:free", "google/gemma-4-31b-it:free", "google/gemini-2.5-flash-lite"]
UA = {"User-Agent": "Mozilla/5.0 (X11; Linux) cam-nang-news/1.0"}
KEEP_WEEKS = 26
MAX_CAND = 30   # ứng viên tối đa mỗi mảng gửi model
MAX_PICK = 10   # tin tối đa mỗi mảng mỗi tuần

# (tên, url, mảng, loại, lọc)  loại: official = nguồn chính thức nền tảng; industry = chuyên trang
FEEDS = [
    ("Google Ads & Commerce blog", "https://blog.google/products/ads-commerce/rss/", "google", "official", None),
    ("Google Ads Developer blog", "https://ads-developers.googleblog.com/feeds/posts/default?alt=rss", "google", "official", None),
    ("PPC Land", "https://ppc.land/rss/", "google", "industry", "ads"),
    ("Search Engine Journal - PPC", "https://www.searchenginejournal.com/category/pay-per-click/feed/", "google", "industry", "ads"),
    ("Meta Newsroom", "https://about.fb.com/news/feed/", "meta", "official", "meta"),
    ("Meta for Developers blog", "https://developers.facebook.com/blog/feed/", "meta", "official", "meta"),
    ("Engineering at Meta", "https://engineering.fb.com/feed/", "meta", "official", "meta"),
    ("Jon Loomer", "https://www.jonloomer.com/feed/", "meta", "industry", None),
    ("Social Media Today", "https://www.socialmediatoday.com/feeds/news/", "meta", "industry", "meta"),
    ("Google Search Central blog", "https://developers.google.com/search/blog/feed.xml", "seo", "official", None),
    ("Google blog - Search", "https://blog.google/products/search/rss/", "seo", "official", "seo"),
    ("Search Engine Roundtable", "https://www.seroundtable.com/index.xml", "seo", "industry", "seo"),
    ("Search Engine Journal", "https://www.searchenginejournal.com/feed/", "seo", "industry", "seo"),
]
STATUS = ("Google Search Status Dashboard", "https://status.search.google.com/incidents.json", "seo", "official")
F = {
    "ads": re.compile(r"(Google Ads|Performance Max|PMax|Demand Gen|AI Max|Smart Bidding|tCPA|tROAS|broad match|keyword|"
                      r"Quality Score|Ad Rank|responsive search|enhanced conversions|offline conversion|Consent Mode|"
                      r"Google tag|GA4|conversion|bidding|budget|policy|Merchant Center|Shopping|YouTube ads|"
                      r"auto-?apply|recommendations|suspend|invalid traffic|search terms|asset|AI Overviews? ads)", re.I),
    "meta": re.compile(r"(\bads?\b|advertis|Advantage|Andromeda|Conversions API|CAPI|pixel|dataset|lead ads?|instant form|"
                       r"Messenger|WhatsApp|click-to-message|attribution|Marketing API|campaign|creative|Reels|"
                       r"measurement|Ads Manager|Business Suite|Meta Verified|policy|restrict|health|targeting|Threads ads)", re.I),
    "seo": re.compile(r"(core update|spam update|algorithm|ranking|helpful content|reviews? update|site reputation|"
                      r"scaled content|AI Overview|AI Mode|E-E-A-T|quality rater|Search Console|structured data|schema|"
                      r"crawl|index|Googlebot|Discover|featured snippet|search results|SERP|Mueller|Sullivan|"
                      r"Search Liaison|Illyes|Splitt|ChatGPT search|Perplexity|Bing|robots|sitemap|canonical|penalt|"
                      r"manual action|local search|Business Profile)", re.I),
}
AREA_VI = {"google": "Google Ads", "meta": "Meta Ads", "seo": "SEO"}


def log(m):
    print(f"[{dt.datetime.now():%Y-%m-%d %H:%M:%S}] {m}", flush=True)


def get(url, tries=3):
    for k in range(tries):
        try:
            with urllib.request.urlopen(urllib.request.Request(url, headers=UA), timeout=30) as r:
                return r.read()
        except Exception:
            if k == tries - 1:
                raise
            time.sleep(4)


def clean(s, n=500):
    s = html.unescape(re.sub(r"<[^>]+>", " ", s or ""))
    return re.sub(r"\s+", " ", s).strip()[:n]


def parse_date(s):
    s = (s or "").strip()
    if not s:
        return None
    try:
        d = email.utils.parsedate_to_datetime(s)
    except Exception:
        try:
            d = dt.datetime.fromisoformat(s.replace("Z", "+00:00"))
        except Exception:
            return None
    if d.tzinfo is None:
        d = d.replace(tzinfo=dt.timezone.utc)
    return d


def feed_items(raw):
    root = ET.fromstring(raw)
    for it in root.iter("item"):
        yield {"title": clean(it.findtext("title"), 220), "link": (it.findtext("link") or "").strip(),
               "date": parse_date(it.findtext("pubDate") or it.findtext("{http://purl.org/dc/elements/1.1/}date")),
               "summary": clean(it.findtext("description"))}
    ns = "{http://www.w3.org/2005/Atom}"
    for it in root.iter(ns + "entry"):
        link = ""
        for l in it.findall(ns + "link"):
            if l.get("rel") in (None, "alternate"):
                link = l.get("href", "")
                break
        yield {"title": clean(it.findtext(ns + "title"), 220), "link": link,
               "date": parse_date(it.findtext(ns + "published") or it.findtext(ns + "updated")),
               "summary": clean(it.findtext(ns + "summary") or it.findtext(ns + "content"))}


def status_items(raw):
    for inc in json.loads(raw)[:20]:
        name = inc.get("external_desc") or inc.get("service_name") or "Search incident"
        upd = (inc.get("most_recent_update") or {}).get("text", "")
        end = inc.get("end")
        yield {"title": clean(name, 200) + (" (đã xong)" if end else " (đang diễn ra)"),
               "link": "https://status.search.google.com/incidents/" + inc.get("id", ""),
               "date": parse_date(inc.get("begin")), "summary": clean(upd), "key_extra": str(end)}


def collect(days, seen):
    since = dt.datetime.now(dt.timezone.utc) - dt.timedelta(days=days)
    cands, errors = {"google": [], "meta": [], "seo": []}, []
    for name, url, area, kind, flt in [STATUS + ("status",)] + FEEDS:
        try:
            raw = get(url)
            its = status_items(raw) if flt == "status" else feed_items(raw)
            n = 0
            for it in its:
                if not it["title"] or not it["link"]:
                    continue
                if it["date"] and it["date"] < since:
                    continue
                key = hashlib.sha1((it["link"] + it.get("key_extra", "")).encode()).hexdigest()[:16]
                if key in seen:
                    continue
                if flt in F and not F[flt].search(it["title"] + " " + it["summary"]):
                    continue
                cands[area].append({"key": key, "source": name, "kind": kind, "title": it["title"], "link": it["link"],
                                    "date": it["date"].date().isoformat() if it["date"] else "", "summary": it["summary"]})
                n += 1
            log(f"  {name}: {n} ứng viên")
        except Exception as e:
            errors.append(f"{name}: {type(e).__name__} {str(e)[:120]}")
            log(f"  LỖI nguồn {name}: {type(e).__name__} {str(e)[:120]}")
    for a in cands:  # chính thức trước, mới trước
        cands[a].sort(key=lambda x: (x["kind"] != "official", x["date"] or ""), reverse=False)
        off = [c for c in cands[a] if c["kind"] == "official"]
        ind = sorted([c for c in cands[a] if c["kind"] != "official"], key=lambda x: x["date"], reverse=True)
        cands[a] = (off + ind)[:MAX_CAND]
    return cands, errors


SYS = """Bạn là biên tập viên tin tức cho đội làm quảng cáo Google Ads, Meta Ads và SEO tại Việt Nam (agency nhỏ, khách là phòng khám, doanh nghiệp B2B).
Nhiệm vụ: từ danh sách tin tiếng Anh, CHỌN tin đáng biết và viết lại bằng tiếng Việt dễ hiểu.
Chọn: cập nhật thuật toán (core/spam update, thay đổi xếp hạng, Andromeda...), thay đổi chính sách, tính năng mới hoặc bị bỏ trong công cụ quảng cáo/Search Console, thay đổi đo lường/theo dõi chuyển đổi, thông báo chính thức có hạn chót.
Bỏ: tin chỉ dành cho lập trình viên (phiên bản API, SDK, thư viện, iOS/Android) trừ khi nó đổi cách chạy quảng cáo hoặc đo lường trong giao diện; nghiên cứu kỹ thuật nội bộ không có thay đổi cho người dùng; tin quảng bá chung chung, sự kiện, tuyển dụng, tin tài chính công ty, tin trùng lặp (giữ bản từ nguồn chính thức), bài hướng dẫn chung không có gì mới, tin không liên quan quảng cáo/SEO.
CHỈ dựa vào tiêu đề và mô tả được cung cấp; không bịa số liệu, ngày hay chi tiết không có trong đó. Chỗ nào chưa rõ thì nói "chi tiết xem bài gốc".
Không dùng dấu gạch dài, chỉ dùng "-". Giải thích ngắn thuật ngữ tiếng Anh trong ngoặc.
Trả về DUY NHẤT JSON: {"items":[{"i":<số thứ tự tin>,"title_vi":"tiêu đề tiếng Việt, tối đa 110 ký tự","tomtat":"2-3 câu: chuyện gì thay đổi, áp dụng từ khi nào nếu tin có nói","anhhuong":"1-2 câu: người chạy quảng cáo/làm SEO cần kiểm tra hoặc làm gì","muc":1|2|3}]}
muc: 3 = quan trọng (thuật toán, chính sách, thay đổi bắt buộc), 2 = đáng biết, 1 = tham khảo. Tối đa %d tin, xếp quan trọng trước."""


def llm_once(area, cands, key, models):
    lines = [f"[{i}] ({c['source']}, {'chính thức' if c['kind'] == 'official' else 'chuyên trang'}, {c['date']}) {c['title']}\n    {c['summary'][:350]}"
             for i, c in enumerate(cands)]
    payload = {"models": models, "temperature": 0.2, "max_tokens": 4000, "reasoning": {"effort": "low"},
               "response_format": {"type": "json_object"},
               "messages": [{"role": "system", "content": SYS % MAX_PICK},
                            {"role": "user", "content": f"MẢNG: {AREA_VI[area]}\n\n" + "\n".join(lines)}]}
    req = urllib.request.Request("https://openrouter.ai/api/v1/chat/completions", data=json.dumps(payload).encode(),
                                 headers={"Content-Type": "application/json", "Authorization": "Bearer " + key,
                                          "HTTP-Referer": "https://digicomvn.com", "X-Title": "Cam nang tin tuc"})
    with urllib.request.urlopen(req, timeout=180) as r:
        j = json.loads(r.read())
    txt = j["choices"][0]["message"]["content"]
    txt = re.sub(r"^```(?:json)?|```$", "", txt.strip(), flags=re.M)
    m = re.search(r"\{.*\}", txt, re.S)
    return json.loads(m.group(0)).get("items") or [], j.get("model", "")


def llm(area, cands, key):
    """Chia lô 15 tin; mỗi lô thử 3 lần, mỗi lần đổi model đứng đầu. Lô nào hỏng hẳn thì trả None cho lô đó."""
    picks, used_models, failed = [], set(), 0
    for off in range(0, len(cands), 15):
        chunk = cands[off:off + 15]
        got = None
        for k in range(3):
            order = MODELS[k % len(MODELS):] + MODELS[:k % len(MODELS)]
            try:
                items, model = llm_once(area, chunk, key, order)
                got = [dict(p, i=int(p["i"]) + off) for p in items if str(p.get("i", "")).strip().isdigit()]
                used_models.add(model)
                break
            except Exception as e:
                log(f"  model lỗi ({area}, lô {off // 15 + 1}, lần {k + 1}): {type(e).__name__} {str(e)[:150]}")
                time.sleep(8)
        if got is None:
            failed += 1
            got = [{"i": off + i, "title_vi": "", "tomtat": "", "anhhuong": "", "muc": 2} for i, c in enumerate(chunk) if c["kind"] == "official"]
            log(f"  ERROR lô {off // 15 + 1} mảng {area} hỏng, giữ {len(got)} tin chính thức nguyên văn")
        picks += got
    picks.sort(key=lambda p: -(int(p.get("muc") or 1) if str(p.get("muc", "")).isdigit() else 1))
    return picks, ", ".join(sorted(m for m in used_models if m))


def nodash(s):
    return re.sub("[–—]", "-", str(s or "")).strip()


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("--dry", action="store_true")
    ap.add_argument("--no-push", action="store_true")
    ap.add_argument("--days", type=int, default=10)
    a = ap.parse_args()
    st = json.loads(STATE.read_text()) if STATE.exists() else {"seen": []}
    seen = set(st["seen"])
    data = json.loads(OUT.read_text()) if OUT.exists() else {"items": [], "runs": []}
    today = dt.date.today().isoformat()
    log(f"Bắt đầu, lấy tin {a.days} ngày gần nhất")
    cands, errors = collect(a.days, seen)
    if a.dry:
        for ar, cs in cands.items():
            print(f"\n== {ar}: {len(cs)}")
            for c in cs:
                print(f"  {c['date']} [{c['kind']}] {c['source']}: {c['title'][:110]}")
        return
    key = KEY_FILE.read_text().strip()
    new, models = [], set()
    for ar, cs in cands.items():
        if not cs:
            continue
        picks, model = llm(ar, cs, key)
        models.add(model)
        used = set()
        for p in picks[:MAX_PICK]:
            try:
                c = cs[int(p["i"])]
            except Exception:
                continue
            if c["key"] in used:
                continue
            used.add(c["key"])
            new.append({"id": c["key"], "area": ar, "source": c["source"], "kind": c["kind"], "title": c["title"],
                        "title_vi": nodash(p.get("title_vi")) or c["title"], "tomtat": nodash(p.get("tomtat")),
                        "anhhuong": nodash(p.get("anhhuong")), "muc": int(p.get("muc") or 1) if str(p.get("muc", "")).isdigit() else 1,
                        "link": c["link"], "date": c["date"], "week": today})
        log(f"  {AREA_VI[ar]}: {len(cs)} ứng viên -> chọn {len(used)} ({model})")
        for c in cs:  # đã xét thì đánh dấu thấy, kể cả tin bị loại
            seen.add(c["key"])
    cut = (dt.date.today() - dt.timedelta(weeks=KEEP_WEEKS)).isoformat()
    items = new + [x for x in data["items"] if x.get("week", "") >= cut and x["id"] not in {n["id"] for n in new}]
    runs = [{"date": today, "new": len(new), "errors": len(errors)}] + [r for r in data.get("runs", []) if r["date"] != today]
    out = {"updated": dt.datetime.now().strftime("%Y-%m-%d %H:%M"), "latest_week": today, "runs": runs[:30],
           "models": sorted(m for m in models if m), "items": items}
    OUT.write_text(json.dumps(out, ensure_ascii=False, indent=1))
    STATE.write_text(json.dumps({"seen": sorted(seen)[-5000:]}))
    log(f"Ghi news.json: {len(new)} tin mới, tổng {len(items)}; lỗi nguồn {len(errors)}")
    if not a.no_push:
        r = subprocess.run(["scp", "-q", str(OUT), REMOTE], capture_output=True, text=True, timeout=120)
        log("Đẩy lên Hostinger: " + ("OK" if r.returncode == 0 else "ERROR " + r.stderr[:200]))
        if r.returncode:
            sys.exit(1)


if __name__ == "__main__":
    main()
