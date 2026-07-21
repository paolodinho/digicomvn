#!/bin/bash
# render.sh - dung HTML dashboard/report -> anh webp sac net, nhe, cho digicomvn.com
# Cach dung: ./render.sh <input.html> <out_basename> [width] [height]
#   width/height = kich thuoc thiet ke (px, mac dinh 1200 x auto-detect that bai -> 700).
# Output: <out_basename>.webp (1600px chieu rong, q88) + <out_basename>@2x.png (goc 2x, de QA).
# Yeu cau: Google Chrome (headless), sips (macOS), cwebp (brew install webp).
set -e
IN="$1"; OUT="$2"; W="${3:-1200}"; H="${4:-700}"
CHROME="/Applications/Google Chrome.app/Contents/MacOS/Google Chrome"
[ -f "$IN" ] || { echo "Khong thay file HTML: $IN"; exit 1; }
[ -x "$CHROME" ] || { echo "Khong thay Google Chrome"; exit 1; }
DIR="$(cd "$(dirname "$IN")" && pwd)"; BASE="$(basename "$IN")"
"$CHROME" --headless=new --disable-gpu --hide-scrollbars \
  --force-device-scale-factor=2 --window-size="$W,$H" \
  --screenshot="$OUT@2x.png" "file://$DIR/$BASE" 2>/dev/null
# resize ban 2x xuong 1600px chieu rong (du sac net cho khung noi dung ~760px, retina 2x)
cp "$OUT@2x.png" "$OUT-1600.png"
sips -Z 1600 "$OUT-1600.png" >/dev/null 2>&1
cwebp -q 88 "$OUT-1600.png" -o "$OUT.webp" >/dev/null 2>&1
rm -f "$OUT-1600.png"
echo "OK -> $OUT.webp ($(wc -c < "$OUT.webp") bytes) | QA: $OUT@2x.png"
