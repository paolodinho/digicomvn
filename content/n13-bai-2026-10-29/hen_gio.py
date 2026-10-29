# Thay <!--IMG:...--> bằng figure (URL từ media.tsv), tạo bài status future qua REST, ghi meta SEO.
# Dùng: python3 hen_gio.py <slug> <YYYY-MM-DDTHH:MM:SS giờ site UTC> [category_id, mặc định 24]
import sys, json, re, subprocess, os
D = os.path.dirname(os.path.abspath(__file__)); ROOT = os.path.dirname(os.path.dirname(D))
slug, date = sys.argv[1], sys.argv[2]
cat = sys.argv[3] if len(sys.argv) > 3 else '24'
media = {l.split('|')[0]: (l.split('|')[1], l.split('|')[2].strip()) for l in open(f'{D}/media.tsv') if '|' in l}
h = open(f'{D}/{slug}.html').read(); j = json.load(open(f'{D}/{slug}.json'))

def fig(m):
    f, alt, cap = (m.group(1).split('|') + ['', ''])[:3]
    mid, url = media[f.replace('.webp', '')]
    return ('<!-- wp:html -->\n<figure class="dgc-shot"><img src="%s" alt="%s" width="1600" height="900" loading="lazy" decoding="async">'
            '<figcaption>%s</figcaption></figure>\n<!-- /wp:html -->') % (url, alt.strip(), cap.strip())
h2 = re.sub(r'<!--IMG:(.*?)-->', fig, h)
assert '<!--IMG' not in h2
out = f'{D}/{slug}.final.html'; open(out, 'w').write(h2)
r = None if os.environ.get('PID') else subprocess.run(['python3', f'{ROOT}/tools/wp-rest-publish.py', 'create', '--title', j['title'], '--slug', j['slug'],
                    '--content-file', out, '--category-id', cat, '--author-id', '1', '--status', 'future',
                    '--date', date, '--excerpt', j.get('excerpt', '')], capture_output=True, text=True)
r and print(r.stdout, r.stderr[-500:])
pid = int(os.environ['PID']) if os.environ.get('PID') else json.loads(r.stdout.strip().splitlines()[-1])['id']
cmd = ("cd domains/digicomvn.com/public_html && wp post meta update %d dgc_seo_title %s --allow-root && "
       "wp post meta update %d dgc_seo_desc %s --allow-root") % (pid, json.dumps(j['title'], ensure_ascii=False), pid, json.dumps(j['meta_desc'], ensure_ascii=False))
for f in re.findall(r'<!--IMG:([^|]+)\|([^|]*)', h):
    mid = media[f[0].replace('.webp', '')][0]
    cmd += " && wp post meta update %s _wp_attachment_image_alt %s --allow-root && wp post update %s --post_parent=%d --allow-root" % (mid, json.dumps(f[1].strip(), ensure_ascii=False), mid, pid)
open(f'{D}/cho-ssh-{slug}.sh','w').write(cmd+'\n')  # chay sau khi host do tai
open(f'{D}/da-hen-gio.tsv', 'a').write(f'{slug}\t{pid}\t{date}\n')
