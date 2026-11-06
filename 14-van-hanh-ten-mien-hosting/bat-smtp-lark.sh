#!/bin/bash
# Bat gui email web digicomvn.com qua SMTP Lark (sales@digicomvn.com). Hieu chay tay, tu dan ma uy quyen.
# Ma khong hien tren man hinh, khong luu tren Mac, chi ghi vao wp-config.php tren hosting (da sao luu truoc).
set -e
H="u704250056@145.79.26.63"; SSH="ssh -o ConnectTimeout=25 -p 65002 -i $HOME/.ssh/id_ed25519"
echo "Lay ma: app Lark > Cai dat > Email > Dang nhap may khach ben thu ba (ma uy quyen cua sales@digicomvn.com)."
read -r -s -p "Dan ma uy quyen Lark roi Enter: " CODE; echo
[ -n "$CODE" ] || { echo "Chua nhap ma."; exit 1; }
B64=$(printf '%s' "$CODE" | base64)
$SSH "$H" "B64='$B64' bash -s" <<'REMOTE'
set -e
CODE=$(printf '%s' "$B64" | base64 -d)
cd ~/domains/digicomvn.com/public_html
cp wp-config.php ~/backups/wp-config.php.bak-smtp-$(date +%Y%m%d-%H%M%S)
sed -i "/DGC_SMTP_PASS/d" wp-config.php
ESC=$(printf '%s' "$CODE" | sed "s/[\\\\']/\\\\&/g")
sed -i "/That's all, stop editing/i define( 'DGC_SMTP_PASS', '$ESC' );" wp-config.php
grep -q "DGC_SMTP_PASS" wp-config.php || { echo "Khong tim thay cho chen trong wp-config.php"; exit 1; }
php -l wp-config.php >/dev/null
cat > /tmp/smtp-test.php <<'EOF'
<?php
add_action( 'wp_mail_failed', function ( $e ) { echo "LOI: ", $e->get_error_message(), "\n"; } );
$ok = wp_mail( 'hieudx3107@gmail.com', 'DigicomVN - thu gui qua Lark', 'Email thu: web digicomvn.com da gui qua sales@digicomvn.com.' );
echo $ok ? "Gui thu OK toi hieudx3107@gmail.com\n" : "Gui thu THAT BAI\n";
EOF
wp eval-file /tmp/smtp-test.php; rm -f /tmp/smtp-test.php
REMOTE
