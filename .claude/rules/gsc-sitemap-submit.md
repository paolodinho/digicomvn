# Auto-submit sitemap len Google Search Console (chot 2026-08-10)

> File nguon: `wp-theme/digicom-host/inc/gsc-sitemap-submit.php`. Chi tiet qua trinh dung/sua
> loi xem LOG.md 2026-08-10.

## Co che
Moi khi post/page/dgc_case chuyen sang `publish` -> tu goi Search Console API
(`sitemaps.submit`) bao Google doc lai `https://digicomvn.com/wp-sitemap.xml` (sitemap goc
WP core). Rate-limit 5 phut/lan, chay lech 10s qua `wp_schedule_single_event` de khong lam
cham thao tac dang bai.

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
`search-console@digicom-price-sync.iam.gserviceaccount.com`, quyen **Full user** (KHONG can
Owner - da test thanh cong voi Full) tren property `https://digicomvn.com/`. Key JSON that luu
tai `~/gsc-secret/service-account.json` tren host (NGOAI `public_html`, chmod 600) - khong bao
gio dua file nay vao ma nguon theme hay Google Drive project (rui ro lo qua git/auto-push).

## 2 cam bay ky thuat da gap (dung lap lai)
1. **PUT thieu `Content-Length`** -> Google tra 411 Length Required. `wp_remote_request` KHONG
   tu them header nay cho body rong -> phai truyen tuong minh `body=>''` va
   `headers['Content-Length']=>'0'`.
2. **`feedpath` phai la URL DAY DU** cua sitemap (`https://digicomvn.com/wp-sitemap.xml`),
   KHONG phai duong dan tuong doi (`wp-sitemap.xml`) - truyen sai se ra 400 invalidParameter.

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