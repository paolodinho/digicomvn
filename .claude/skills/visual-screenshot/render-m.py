#!/usr/bin/env python3
"""render-m.py - render infographic BAN DOC cho mobile.
Cach dung: python3 render-m.py <in.html> <out_basename> [css_width=480]
- Mo trang o be ngang css_width (mac dinh 480), chieu cao TU DO theo noi dung, DPR 3.
- Output: <out>.webp (1080px ngang neu width 480 -> 1440; resize ve 1080) + <out>@2x.png de QA.
- In ra kich thuoc thuc te (w x h) de dien width/height vao <source>.
"""
import sys, asyncio, subprocess, os
from playwright.async_api import async_playwright
async def main(inp, out, w):
    async with async_playwright() as p:
        b = await p.chromium.launch()
        pg = await b.new_page(viewport={'width': w, 'height': 800}, device_scale_factor=3)
        await pg.goto('file://' + os.path.abspath(inp), wait_until='networkidle')
        await pg.evaluate('document.fonts.ready')
        await pg.wait_for_timeout(300)
        h = await pg.evaluate('Math.ceil(document.querySelector(".card").getBoundingClientRect().height)')
        await pg.set_viewport_size({'width': w, 'height': h})
        await pg.screenshot(path=out + '@2x.png', clip={'x': 0, 'y': 0, 'width': w, 'height': h})
        await b.close()
    tmp = out + '-1080.png'
    subprocess.run(['cp', out + '@2x.png', tmp]); subprocess.run(['sips', '--resampleWidth', '1080', tmp], capture_output=True)
    subprocess.run(['cwebp', '-q', '88', tmp, '-o', out + '.webp'], capture_output=True); os.remove(tmp)
    H = round(h * 1080 / w)
    print(f'OK -> {out}.webp 1080x{H} ({os.path.getsize(out + ".webp")} bytes) | QA: {out}@2x.png')
asyncio.run(main(sys.argv[1], sys.argv[2], int(sys.argv[3]) if len(sys.argv) > 3 else 480))
