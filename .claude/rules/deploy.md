# Deploy len live digicomvn.com (Hostinger)

> Rule 2026-07-10. Site Local (dev) va live (Hostinger) la 2 database/file rieng -
> sua o Local KHONG tu dong len live, phai deploy thu cong qua SSH.

## Ket noi
- SSH: `ssh -p 65002 -i ~/.ssh/id_ed25519 u704250056@145.79.26.63`
- Theme path live: `/home/u704250056/domains/digicomvn.com/public_html/wp-content/themes/digicom-host`
- Key `~/.ssh/id_ed25519` (macbook Hieu) da duoc dang ky san tren host - dung duoc luon,
  KHONG can tao key moi hay nhap password.

## Quy trinh deploy 1 file da sua o Local
1. Backup file goc tren live ve `~/Claude-Workspace/_backups/routines/<ngay>/` (scp ve truoc khi ghi de).
2. `scp -P 65002 -i ~/.ssh/id_ed25519 <file-local> u704250056@145.79.26.63:<duong-dan-live>`
3. **Neu sua CSS/JS: BAT BUOC bump `DGC_VER` trong `functions.php`** (vd 0.6.4 -> 0.6.5) roi deploy
   file functions.php luon. Ly do: `.htaccess` cache file tinh 7 ngay theo URL
   (`main.css?ver=X`), khong doi version -> browser/CDN van serve ban cu du da purge cache trang.
   Quen buoc nay = sua xong ma Hieu "khong thay doi gi ca".
4. Purge cache: `wp cache flush --allow-root && wp litespeed-purge all --allow-root`
   (chay tren live qua SSH, trong thu muc `public_html`).
5. Verify bang curl (khong phai chi tin browser): `curl -s "https://digicomvn.com/wp-content/themes/digicom-host/assets/css/main.css?ver=<X>" | grep <dau-hieu-vua-sua>`
6. Ghi 1 dong vao manifest backup ngay do (xem rule global `routine-backup.md`).

## Backup DB live - `wp db export` HONG tren host nay (dung mysqldump)
`wp db export` tren Hostinger nay fail EXIT 255 (thieu quyen PROCESS/tablespaces, khong in loi).
Dung mysqldump truc tiep qua creds tu wp config:
```
DB=$(wp config get DB_NAME --allow-root); U=$(wp config get DB_USER --allow-root)
P=$(wp config get DB_PASSWORD --allow-root); H=$(wp config get DB_HOST --allow-root)
mysqldump --no-tablespaces -h"$H" -u"$U" -p"$P" "$DB" > ~/backups/<ngay>/db.sql
```

## Database live (dgc_settings)
- Field `email` (hien thi cong khai) va `lead_email` (nhan lead form) la 2 field TACH RIENG -
  xem `wp option get dgc_settings --format=json --allow-root`. KHONG gop chung 2 muc dich nay lai.
