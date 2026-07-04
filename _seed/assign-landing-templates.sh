#!/usr/bin/env bash
# Chay tren WP Local (thu muc goc WordPress) sau khi da pull theme.
# 1) Copy assets vao uploads (press-logos da co san):
cp -rn _seed/uploads/client-logos wp-content/uploads/ 2>/dev/null || true
mkdir -p wp-content/uploads/team && cp -n _seed/uploads/team/*.png wp-content/uploads/team/ 2>/dev/null || true

# 2) Gan page template cho 4 trang pillar (theo slug):
declare -A MAP=(
  [dich-vu-backlink]=tpl-landing-backlink.php
  [mua-textlink]=tpl-landing-textlink.php
  [guest-post]=tpl-landing-guestpost.php
  [booking-bao-pr]=tpl-landing-booking.php
)
for slug in "${!MAP[@]}"; do
  ID=$(wp post list --post_type=page --name="$slug" --field=ID --posts_per_page=1 2>/dev/null | head -1)
  if [ -n "$ID" ]; then
    wp post meta update "$ID" _wp_page_template "${MAP[$slug]}" >/dev/null && echo "OK  $slug (ID $ID) -> ${MAP[$slug]}"
  else
    echo "SKIP $slug: khong tim thay trang (kiem tra slug)"
  fi
done
echo "Xong. Mo 4 trang de kiem tra. Rollback: wp post meta update <ID> _wp_page_template ''"
