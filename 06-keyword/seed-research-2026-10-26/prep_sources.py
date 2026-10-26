"""Làm sạch nguồn từ (Suggest mới + Suggest/autocomplete 24/10 + 13/10) -> sources-clean.txt cho run_batches.sh.
Bỏ: từ toàn chữ Latin có token lạ (tiếng Anh/Indo), 'pr' nghĩa khác (Premiere, y khoa...), booking.com, cụm cắt dở."""
import json, re, csv, unicodedata, os, sys
W = os.path.dirname(os.path.abspath(__file__)); O = os.path.join(W, '..', 'seed-research-2026-10-24')
def n(t): return re.sub(r'\s+', ' ', unicodedata.normalize('NFC', str(t).lower())).strip()
pool = {}
def add(k, src):
    k = n(k)
    if k and k not in pool: pool[k] = src
for f, src in ((os.path.join(W, 'suggest.jsonl'), 'Suggest 26/10'), (os.path.join(O, 'suggest.jsonl'), 'Suggest 24/10')):
    for l in open(f, encoding='utf-8'):
        try: d = json.loads(l)
        except ValueError: continue
        for s in d.get('s', []): add(s, src)
for l in open(os.path.join(O, 'ac_core.txt'), encoding='utf-8'): add(l, 'Autocomplete 24/10')
with open(os.path.join(W, '..', 'kp-raw', '2026-10-13', 'kt-gs-autocomplete.csv'), encoding='utf-8') as fh:
    for r in csv.reader(fh):
        if r: add(r[0], 'Autocomplete 13/10')
ACC = re.compile(r'[àáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ]')
LAT_OK = set('''backlink backlinks back link links textlink text guest post posts dofollow nofollow toplist top list entity social seo
pr kol koc booking book tvc vtv vtv1 vtv3 htv htv7 htv9 vtc vov voh anchor fanpage ahrefs da dr pa tf cf offpage off page onpage
domain rating authority blog web website site 2.0 pbn edu gov mua ban gia re la gi cach dich vu cong ty uy tin tot nhat chat luong
bao chi tin vnexpress kenh14 dantri cafef cafebiz znews 24h soha afamily eva vietnamnet tuoitre thanhnien hcm tphcm 2024 2025 2026'''.split())
PR_OK = re.compile(r'báo|bài|viết|booking|book|thông cáo|doanh nghiệp|thương hiệu|dịch vụ|giá|chi phí|quảng cáo|truyền thông|marketing|là gì|sự kiện|sản phẩm|công ty|agency|cá nhân|bất động sản|online|seo|chiến dịch|khủng hoảng|nội dung|content|tiếng anh|viết tắt|ngành|nghề|nhân viên|chuyên viên|ví dụ|mẫu|cách|kế hoạch|hiệu quả|chuyên nghiệp')
BAD2 = re.compile(r'pr trong (code|kinh thánh|nhập cư|y khoa|y tế|khách sạn|kinh tế vĩ mô|kinh tế|xe|game)|cos è|o que é|jelentése|adalah|betekenis|bedeutung|thông cáo báo chí (ngày làm việc|thi hành án|ubkttw|tuyên quang|ussh|trường|hội nghị|bộ |chính phủ|kỳ họp|phiên)|thông cáo báo chí (?!(mẫu|cách|là|gồm|cấu trúc|ví dụ|tiếng anh|trong tiếng anh|sự kiện|ra mắt|khai trương|doanh nghiệp|công ty|của công ty|của doanh nghiệp|dịch vụ|giá|đăng|phát hành|viết|gửi|chuẩn|ngắn|quy|dùng|nghĩa|boilerplate|triển lãm|lễ|sản phẩm|trình bày|tin|có|hay|khác|online|file|word|gì|j\b|bao|như|để|thường|và))|tvc quảng cáo (?!(giá|bao nhiêu|là gì|là|làm|sản xuất|chi phí|thương hiệu|truyền hình|công ty|dịch vụ|ngắn|online|hiệu quả|trên))|quảng cáo truyền hình (19|20)\d\d|quảng cáo truyền hình (của|k\+|bằng logo)|cách cắt video|in pr trên')
BAD = re.compile(r'premiere|adobe|chỉnh màu|chống rung|ecg|điện tim|monitor|visa|karaoke|truyện|\bfb\b|booking\.?com|trên booking|quảng cáo (trên )?booking|tứ báo thủ|technical seo|kịch bản|giọng|\bclip\b|doanh thu|truyền hình cáp|world cup|công ty (cổ phần|tnhh|cp)|\bpr (là|của) (gì )?(trong )?(y|bệnh|thuốc|xe|game)|pr dài|khoảng pr|sóng p|nhịp|pr (code|request|github)|pull request|\bppr\b|personal record|thường trú|permanent residen')
keep = []
for k, src in pool.items():
    toks = k.split()
    if len(toks) < 2: continue
    if not ACC.search(k) and any(t not in LAT_OK for t in toks): continue
    if re.search(r'\bpr\b', k) and not PR_OK.search(k): continue
    if BAD.search(k) or BAD2.search(k): continue
    keep.append(k)
keep += [n(l) for l in open(os.path.join(W, 'old-tabs.txt'), encoding='utf-8') if n(l) and n(l) not in keep]  # gộp từ 2 tab cũ (Copy vào tool 24/10, Seed toàn site 26/10)
open(os.path.join(W, 'sources-clean.txt'), 'w', encoding='utf-8').write('\n'.join(keep) + '\n')
print(len(pool), '->', len(keep))
