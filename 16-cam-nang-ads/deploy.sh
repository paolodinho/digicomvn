#!/bin/bash
# Đẩy cẩm nang lên https://digicomvn.com/<secret-path>/ (noindex, không link, không sitemap)
set -e
cd "$(dirname "$0")"
P=$(cat .secret-path)
python3 build.py
H="u704250056@145.79.26.63"; K=~/.ssh/id_ed25519; R=/home/u704250056/domains/digicomvn.com/public_html/$P
ssh -p 65002 -i $K $H "mkdir -p $R"
scp -P 65002 -i $K dist/index.html dist/.htaccess dist/data.json dist/ask.php $H:$R/
curl -sI "https://digicomvn.com/$P/" | grep -iE "^HTTP|x-robots"
echo "https://digicomvn.com/$P/"
