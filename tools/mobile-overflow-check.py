#!/usr/bin/env python3
"""Quet toan site o vien port mobile (390px) tim phan tu gay overflow ngang.
Dung Playwright (Chromium headless) - do trong browser thuc, khong doan tu HTML.
Usage: python3 tools/mobile-overflow-check.py [url_list_file]
"""
import sys, json, time
from playwright.sync_api import sync_playwright

URL_FILE = sys.argv[1] if len(sys.argv) > 1 else "/tmp/all-urls.txt"

JS_CHECK = """
() => {
  const docW = document.documentElement.clientWidth;
  const scrollW = document.documentElement.scrollWidth;
  if (scrollW <= docW + 2) return null;
  // tim phan tu cu the gay overflow: quet tat ca element, tim cai co right edge > docW
  const all = document.querySelectorAll('body *');
  const offenders = [];
  for (const el of all) {
    const r = el.getBoundingClientRect();
    if (r.right > docW + 3 && r.width > 5) {
      offenders.push({
        tag: el.tagName,
        cls: (el.className || '').toString().slice(0,80),
        width: Math.round(r.width),
        right: Math.round(r.right),
        html: el.outerHTML.slice(0, 200)
      });
    }
  }
  // sap xep theo do "tho" (right lon nhat truoc), lay top 5 element LA (khong chua offender khac)
  offenders.sort((a,b) => b.right - a.right);
  return { docW, scrollW, overflowPx: scrollW - docW, offenders: offenders.slice(0, 5) };
}
"""

def main():
    urls = [u.strip() for u in open(URL_FILE) if u.strip()]
    results = []
    with sync_playwright() as p:
        browser = p.chromium.launch()
        page = browser.new_page(viewport={"width": 390, "height": 844})
        for i, url in enumerate(urls):
            try:
                page.goto(url, wait_until="networkidle", timeout=20000)
                page.wait_for_timeout(300)
                r = page.evaluate(JS_CHECK)
                if r:
                    print(f"[{i+1}/{len(urls)}] OVERFLOW {r['overflowPx']}px  {url}")
                    results.append({"url": url, **r})
                else:
                    print(f"[{i+1}/{len(urls)}] ok  {url}")
            except Exception as e:
                print(f"[{i+1}/{len(urls)}] ERROR {url}: {e}")
        browser.close()
    with open("/tmp/mobile-overflow-report.json", "w") as f:
        json.dump(results, f, ensure_ascii=False, indent=1)
    print(f"\n=== {len(results)}/{len(urls)} URL bi overflow. Chi tiet: /tmp/mobile-overflow-report.json ===")

if __name__ == "__main__":
    main()
