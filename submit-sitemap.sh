#!/bin/bash
# Submit thu cong sitemap len Google Search Console (digicomvn.com).
# Dung khi khong muon cho publish bai moi tu dong trigger, hoac muon kiem tra ngay lap tuc.
ssh -p 65002 -i ~/.ssh/id_ed25519 u704250056@145.79.26.63 "cd /home/u704250056/domains/digicomvn.com/public_html && wp eval '
\$ok = dgc_gsc_submit_sitemap();
echo \$ok ? \"OK: da bao Google doc lai sitemap.\" : \"THAT BAI:\";
echo PHP_EOL;
if (!\$ok) print_r(get_option(\"dgc_gsc_last_result\"));
' --allow-root"
