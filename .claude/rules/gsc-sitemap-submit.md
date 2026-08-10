# Auto-submit sitemap + ep index tung URL/cum bai (chot 2026-08-10)

> File nguon: `wp-theme/digicom-host/inc/gsc-sitemap-submit.php` (logic + hook tu dong) va
> `wp-theme/digicom-host/tools/gsc-cli.php` (CLI cho goi thu cong, khong require trong
> functions.php). Chi tiet qua trinh dung/sua loi xem LOG.md 2026-08-10.

## 2 co che song song

1. **Sitemap submit** (`sitemaps.submit`, scope `webmasters`) - bao Google doc lai
   `https://digicomvn.com/wp-sitemap.xml` (sitemap goc WP core). TU DONG chay moi khi
   post/page/dgc_case chuyen sang `publish`, rate-limit 5 phut/lan, chay lech 10s qua
   `wp_schedule_single_event` de khong lam cham thao tac dang bai.
2. **Indexing API** (`urlNotifications.publish`, scope `indexing`) - ep Google index NHANH
   1 URL cu the. TU DONG chay ca 2 truong hop: bai MOI publish lan dau VA bai DA publish
   san bi SUA lai (vd `entity-refresh` update content qua REST) - hook o `save_post`
   (KHONG dung `transition_post_status`, vi hook do khong fire khi status giu nguyen
   publish->publish luc chi sua noi dung, chi doi khi status THAY DOI). Rate-limit RIENG
   TUNG BAI (2 phut/post) de 1 lan sua khong bi `save_post` goi lai nhieu lan (thumbnail,
   meta box...) sinh trung request. Ham `dgc_gsc_index_urls()` / `dgc_gsc_index_category($slug)`
   dung de goi thu cong cho nhieu URL hoac ca 1 cum chu de (category).
   **LUU Y quan trong**: Google CHINH THUC chi cam ket Indexing API cho JobPosting/
   BroadcastEvent - dung cho bai blog thuong la ngoai muc dich cong bo, KHONG dam bao 100%
   hieu qua, co the bi am tham bo qua hoac gioi han quota (mac dinh 200 request/ngay/project).

## Goi thu cong - lenh `/submit-sitemap` hoac script truc tiep

```bash
./submit-sitemap.sh                    # submit toan bo sitemap
./submit-sitemap.sh cum seo-local      # ep index toan bo bai PUBLISH trong 1 category (slug)
./submit-sitemap.sh mua-textlink       # ep index 1 URL/slug rieng le (tu dong ghep home_url)
./submit-sitemap.sh https://digicomvn.com/mua-textlink/  # ep index 1 URL day du
```
Chay qua `wp eval-file tools/gsc-cli.php <arg...> --allow-root` tren host (KHONG dung `--`
truoc arg - do khong phai cu phap phan tach cua wp-cli eval-file, se bi dua thang vao `$args`
va gay loi logic - da dinh loi nay khi test lan dau 2026-08-10).

## Cau hinh (2 noi, KHONG lien quan code)
1. **wp-config.php (live, KHONG commit)**:
   ```php
   define('DGC_GSC_KEY_PATH', '/home/u704250056/gsc-secret/service-account.json');
   define('DGC_GSC_SITE_URL', 'https://digicomvn.com/');
   ```
2. **WP Admin > DigicomVN > muc 9**: toggle `gsc_submit_on` (1 = bat). Thieu constant/file key
   -> tu dong bo qua, khong loi.

## Service Account
Project Google Cloud rieng `digicom-price-sync`, service account
`search-console@digicom-price-sync.iam.gserviceaccount.com`, quyen **Chu so huu (Owner)**
tren property `https://digicomvn.com/` trong Search Console. Key JSON that luu tai
`~/gsc-secret/service-account.json` tren host (NGOAI `public_html`, chmod 600) - khong bao
gio dua file nay vao ma nguon theme hay Google Drive project (rui ro lo qua git/auto-push).

Can bat CA 2 API trong Google Cloud Console (APIs & Services > Library) cho project nay:
- **Google Search Console API** (sitemap submit) - bat luc dau du.
- **Web Search Indexing API** (`indexing.googleapis.com`) - bat sau, can them ~3-5 phut de
  Google propagate quyen truy cap moi truoc khi goi duoc (loi 403 SERVICE_DISABLED ban dau
  la binh thuong, khong phai loi cau hinh, cu doi roi thu lai).

## 3 cam bay ky thuat da gap (dung lap lai)
1. **PUT thieu `Content-Length`** -> Google tra 411 Length Required. `wp_remote_request` KHONG
   tu them header nay cho body rong -> phai truyen tuong minh `body=>''` va
   `headers['Content-Length']=>'0'`.
2. **`feedpath` phai la URL DAY DU** cua sitemap (`https://digicomvn.com/wp-sitemap.xml`),
   KHONG phai duong dan tuong doi (`wp-sitemap.xml`) - truyen sai se ra 400 invalidParameter.
3. **Indexing API can quyen Owner, quyen Full khong du** -> loi `403 Permission denied.
   Failed to verify the URL ownership.` du token/scope dung. Nang quyen service account len
   Owner trong Search Console > Settings > Users and permissions la het loi.

## Debug nhanh (SSH + WP-CLI)
```bash
wp eval '$ok = dgc_gsc_submit_sitemap(); echo $ok ? "OK" : "FAIL"; print_r(get_option("dgc_gsc_last_result"));' --allow-root
```
Ket qua luu vao option `dgc_gsc_last_result` (time, success, detail) - cung hien ngay tren
trang WP Admin > DigicomVN > muc 9 de xem lan chay gan nhat khong can SSH.

## Lien quan
- `deploy.md` - quy trinh deploy code len live (SSH, backup, purge cache).
- `seo-meta-og.md` - sitemap/canonical do theme tu sinh, khong dung plugin SEO.
- `auto-push-github.md` (global) - ly do JSON key phai chan trong `.gitignore` truoc khi lam
  gi khac (session nao cung auto-push cuoi gio).
- Skill `entity-refresh` (Che do A - BUOC 7, Che do B - BUOC B6): moi lan viet/sua bai xong
  qua `tools/wp-rest-publish.py` deu TU DONG duoc ep index qua hook `save_post` o tren,
  khong can goi rieng - trich dan chi de xac nhan ngay lap tuc thay vi cho WP-Cron.