#!/bin/bash
# Bao Google Search Console cho digicomvn.com. Cach dung:
#   ./submit-sitemap.sh                    -> submit toan bo sitemap (bao Google doc lai)
#   ./submit-sitemap.sh toan trang         -> giong tren
#   ./submit-sitemap.sh cum seo-tu-khoa    -> ep index toan bo bai PUBLISH trong 1 category (slug)
#   ./submit-sitemap.sh mua-textlink dich-vu-backlink   -> ep index tung URL/slug rieng le
#   ./submit-sitemap.sh https://digicomvn.com/mua-textlink/   -> ep index 1 URL day du
ARGS=""
for a in "$@"; do
	ARGS="$ARGS $(printf '%q' "$a")"
done
ssh -p 65002 -i ~/.ssh/id_ed25519 u704250056@145.79.26.63 \
	"cd /home/u704250056/domains/digicomvn.com/public_html && wp eval-file wp-content/themes/digicom-host/tools/gsc-cli.php $ARGS --allow-root"
