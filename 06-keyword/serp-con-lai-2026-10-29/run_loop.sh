#!/bin/bash
# Chạy đo top 10, tự chạy tiếp (resume từ partial) nếu tiến trình chết giữa chừng, tối đa 8 lần.
S="$(cd "$(dirname "$0")" && pwd)"; T="/Volumes/Extreme SSD/Projects/ICD/08-tools/keyword-tools"
for i in 1 2 3 4 5 6 7 8; do
  N=$(grep -c '"keyword"' "$S/serp.csv.partial.jsonl" 2>/dev/null); [ "${N:-0}" -ge 170 ] && break
  echo "$(date '+%F %T') | LOOP lần $i, đã đo $N/170" >> "$S/serp.log"
  cd "$T"; ALLINTITLE_DIRECT=1 SERP_ONLY=1 SERP_PAGES=1 /opt/anaconda3/bin/python3 allintitle_scrape.py --keywords "$S/kw.txt" --out "$S/serp.csv" --serp --delay 20 --wait-lock 1440 >> "$S/serp.log" 2>&1
  echo "$(date '+%F %T') | LOOP exit code $?" >> "$S/serp.log"; sleep 30
done
echo "$(date '+%F %T') | LOOP_XONG" >> "$S/serp.log"
