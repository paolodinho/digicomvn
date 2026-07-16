#!/bin/bash
# ---------------------------------------------------------------------------
# Flatten cau truc: bo hub /dich-vu/, dua 8 pillar len goc.
# CU:  /dich-vu/<pillar>/            MOI: /<pillar>/
#      /dich-vu/booking-bao-pr/<bao>/     /booking-bao-pr/<bao>/  (tu dong theo cha)
#      /dich-vu/dich-vu-backlink/bat-dong-san/  -> /dich-vu-backlink/bat-dong-san/
#
# Chay TU thu muc goc WordPress:
#   - Local:  cd <duong-dan-site-local>/app/public && WP="wp" bash migrate.sh
#   - Live :  cd ~/domains/digicomvn.com/public_html && WP="wp --allow-root" bash migrate.sh
#
# An toan: export DB truoc; hub chuyen DRAFT (khong xoa han) -> rollback duoc.
# 301 da xu ly trong theme (functions.php, fire khi 404) -> KHONG can plugin redirect.
# ---------------------------------------------------------------------------
set -euo pipefail
WP="${WP:-wp}"
PILLARS="mua-textlink dich-vu-backlink guest-post booking-bao-pr dich-vu-toplist backlink-social-entity backlink-quoc-te booking-truyen-hinh"

echo "== 0. Backup DB truoc khi doi cau truc =="
DB=$($WP config get DB_NAME); U=$($WP config get DB_USER); P=$($WP config get DB_PASSWORD); H=$($WP config get DB_HOST); mysqldump --no-tablespaces -h"$H" -u"$U" -p"$P" "$DB" > "backup-truoc-flatten-$(date +%Y%m%d-%H%M%S).sql"  

echo "== 1. Reparent 8 pillar ve goc (post_parent = 0) =="
for slug in $PILLARS; do
  id=$($WP post list --post_type=page --name="$slug" --field=ID --posts_per_page=1 2>/dev/null | head -1)
  if [ -n "${id:-}" ]; then
    cur=$($WP post get "$id" --field=post_parent)
    if [ "$cur" != "0" ]; then
      $WP post update "$id" --post_parent=0 >/dev/null
      echo "  reparented $slug (ID $id): parent $cur -> 0"
    else
      echo "  $slug (ID $id) da o goc, bo qua"
    fi
  else
    echo "  WARN: khong tim thay page slug '$slug'"
  fi
done

echo "== 2. Hub 'dich-vu' -> draft (giai phong URL /dich-vu/ cho 301; rollback = doi lai publish) =="
hub=$($WP post list --post_type=page --name="dich-vu" --field=ID --posts_per_page=1 2>/dev/null | head -1)
if [ -n "${hub:-}" ]; then
  $WP post update "$hub" --post_status=draft >/dev/null
  echo "  hub dich-vu (ID $hub) -> draft"
else
  echo "  khong thay hub 'dich-vu' (co the da xu ly truoc do)"
fi

echo "== 3. Menu chinh: kiem tra item tro toi hub (xu ly tay neu la custom link) =="
echo "  Danh sach menu (go item 'Dich vu' tro /dich-vu/ neu con, trong WP Admin > Menus):"
$WP menu list --format=table 2>/dev/null || echo "  -> mo WP Admin > Giao dien > Menu de kiem tra"

echo "== 4. Flush rewrite rules =="
$WP rewrite flush >/dev/null
echo "  done."

echo "== 5. Verify nhanh =="
for u in "booking-bao-pr" "mua-textlink" "dich-vu-backlink/bat-dong-san"; do
  echo "  /$u/  -> $($WP eval "echo get_permalink(get_page_by_path('$u') ? get_page_by_path('$u')->ID : 0);" 2>/dev/null)"
done
echo "XONG. Kiem tra tren trinh duyet:"
echo "  200: https://digicomvn.com/booking-bao-pr/"
echo "  301: https://digicomvn.com/dich-vu/booking-bao-pr/  -> /booking-bao-pr/"
echo "  301: https://digicomvn.com/dich-vu/                 -> /"
