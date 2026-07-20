path = "/Volumes/Extreme SSD/CÔNG VIỆC CỦA TÔI/Projects/digicom/tools/224-raw4.html"
with open(path, encoding="utf-8") as f:
    html = f.read()

iframe_block = '''<h2>Kiểm tra backlink miễn phí ngay tại đây</h2>
<p>Không cần cài đặt hay đăng ký, thử ngay công cụ bên dưới - nhập domain của bạn hoặc đối thủ để xem danh sách backlink thật.</p>
<div style="margin:20px 0 8px;border:1px solid #E2E8F0;border-radius:8px;overflow:hidden;">
<iframe src="https://neilpatel.com/backlinks/" title="Công cụ kiểm tra backlink miễn phí" style="width:100%;height:900px;border:0;display:block;" loading="lazy" sandbox="allow-scripts allow-same-origin allow-forms allow-popups allow-popups-to-escape-sandbox"></iframe>
</div>
<p style="font-size:.85rem;color:#94a3b8;">Công cụ do <a href="https://neilpatel.com/backlinks/" target="_blank" rel="nofollow noopener">Ubersuggest / Neil Patel</a> cung cấp, hiển thị ngay trên trang này để bạn dùng thử miễn phí.</p>

'''
marker = '<h2>Top 5 công cụ hỗ trợ kiểm tra backlink tốt nhất 2026</h2>'
assert marker in html
html = html.replace(marker, iframe_block + marker, 1)

out_path = "/Volumes/Extreme SSD/CÔNG VIỆC CỦA TÔI/Projects/digicom/tools/224-iframe-final.html"
with open(out_path, "w", encoding="utf-8") as f:
    f.write(html)
print("OK, len=", len(html))
