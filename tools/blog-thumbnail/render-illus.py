#!/usr/bin/env python3
import sys, os, subprocess, json, re, unicodedata
from illus_lib import LIB

WD = os.path.dirname(os.path.abspath(__file__))
CHROME = "/Applications/Google Chrome.app/Contents/MacOS/Google Chrome"
TPL = open(os.path.join(WD, "template-illus.html")).read()
LOGO = "data:image/png;base64," + open(os.path.join(WD, "logo-real.b64")).read().replace("\n","")

BLUE="#4761FF"; TEAL="#12B39C"

# (badge, accent, illus-key) theo tu khoa tieu de. Thu tu uu tien tu tren xuong.
def classify(title):
    t = title.lower()
    def has(*ks): return any(k in t for k in ks)
    if has("textlink"):                         return ("TEXTLINK", BLUE, "TEXTLINK")
    if has("guest post"):                        return ("GUEST POST", BLUE, "CONTENT")
    if has("backlink","liên kết","link building","internal link","referring","anchor"):
        return ("BACKLINK", TEAL, "BACKLINK")
    if has("booking","báo pr","báo chí","đầu báo","vnexpress","kenh14","dân trí","cafef","pr "," pr","press") or re.search(r'\bpr\b', t):
        return ("BOOKING PR", TEAL, "PR")
    if has("local","địa phương","maps","gbp","google my business","citation","nap"):
        return ("LOCAL SEO", TEAL, "LOCAL")
    if has("keyword","từ khóa","research","intent","clustering","long tail"):
        return ("KEYWORD", BLUE, "KEYWORD")
    if has("analytics","traffic","gsc","search console","ga4","impression","ctr","organic","rank tracker","thứ hạng"):
        return ("ANALYTICS", BLUE, "ANALYTICS")
    if has("technical","crawl","sitemap","robots","https","redirect","schema","canonical","core web vitals","tốc độ","mobile","screaming frog","index"):
        return ("TECHNICAL", BLUE, "TECH")
    if has("content","nội dung","viết bài","title","meta","heading","h1 h2","pillar","topic cluster","thin content","duplicate","e-e-a-t","eeat"):
        return ("CONTENT", BLUE, "CONTENT")
    if has("google","thuật toán","algorithm","panda","penguin","rankbrain","bert","sge","ai overview","update","spambrain","helpful content","geo","featured snippet"):
        return ("SEO", BLUE, "IDEA")
    if has("tool","công cụ","ahrefs","semrush","majestic","phần mềm"):
        return ("TOOLS", TEAL, "TECH")
    return ("SEO", BLUE, "SEO")

def slug(s):
    s = unicodedata.normalize("NFKD", s).encode("ascii","ignore").decode()
    return re.sub(r"[^a-zA-Z0-9]+","-",s).strip("-").lower()[:46]

def render(pid, title, force=None):
    label, accent, key = classify(title)
    if force:
        label, accent, key = force
    svg = LIB.get(key, LIB["SEO"])
    boot = (f"<script>window.__T={json.dumps(title)};window.__L={json.dumps(label)};"
            f"window.__A={json.dumps(accent)};window.__LOGO={json.dumps(LOGO)};</script>")
    doc = TPL.replace("<!--SVG-->", svg).replace("<script>\n  document.getElementById('title')", boot+"\n<script>\n  document.getElementById('logo').src=window.__LOGO;\n  document.getElementById('title')")
    tmp = os.path.join(WD, f"_i_{pid}.html"); open(tmp,"w").write(doc)
    out = os.path.join(WD, "out", f"v2-{pid}-{slug(title)}.png")
    subprocess.run([CHROME,"--headless","--disable-gpu","--hide-scrollbars",
        "--force-device-scale-factor=1","--window-size=1200,675",
        f"--screenshot={out}","--virtual-time-budget=2500",f"file://{tmp}"],
        stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
    os.remove(tmp)
    return out, label, key

if __name__ == "__main__":
    posts = json.loads(sys.stdin.read() or "[]")
    for pid, title in posts:
        out, label, key = render(pid, title)
        print(f"{pid}\t{label}\t{key}\t{out}")
