#!/bin/bash
# Ghi tiến độ việc nền (Suggest / đo SERP) vào dòng N11 file tổng quan mỗi 15 phút; xong báo macOS.
# Dùng: nohup bash progress_n11.sh suggest|serp <file todo/log> > progress.log 2>&1 &
W="$(cd "$(dirname "$0")" && pwd)"; KIND=$1
while true; do
  if [ "$KIND" = suggest ]; then
    SEC=1; TOT=$(head -1 "$W/suggest.log" | grep -o '^[0-9]*'); DONE=$(wc -l < "$W/suggest.jsonl" | tr -d ' ')
    ALIVE=$(kill -0 "$(cat "$W/suggest.pid")" 2>/dev/null && echo 1)
    FIN=$(grep -c XONG_SUGGEST "$W/suggest.log"); BLK=$(grep -c "BỊ CHẶN" "$W/suggest.log")
  else
    TOT=$(wc -l < "$2" | tr -d ' '); DONE=$(cat "$3" 2>/dev/null | grep -c '"keyword"'); SEC=60; ALIVE=$(kill -0 "$(cat "$(dirname "$2")/loop.pid" 2>/dev/null)" 2>/dev/null && echo 1); FIN=0; BLK=0
  fi
  NOW=$(date +%H:%M); ETA=$(/usr/bin/python3 -c "import datetime as d;r=max(int('$TOT')-int('$DONE'),0);print((d.datetime.now()+d.timedelta(seconds=r*$SEC)).strftime('%H:%M'))")
  if [ "$FIN" -gt 0 ] || { [ -z "$ALIVE" ] && [ "$DONE" -ge "$TOT" ]; }; then MSG="$KIND XONG $DONE/$TOT lúc $NOW"; END=1
  elif [ -z "$ALIVE" ]; then MSG="$KIND DỪNG ở $DONE/$TOT lúc $NOW (bị chặn=$BLK), Claude chạy lại"; END=1
  elif [ "$KIND" = serp ] && [ "$DONE" = 0 ]; then MSG="đo top 10 ($TOT từ) đang xếp hàng chờ các dự án khác đo xong (dùng chung 1 lượt Google), cập nhật $NOW"; END=0
  else MSG="$KIND đang chạy nền: $DONE/$TOT, cập nhật $NOW, dự kiến xong ~$ETA"; END=0; fi
  /usr/bin/python3 "$W/tq.py" N11 --trang-thai "Đang làm" --tiep "Claude: $MSG. Tiếp: gom cụm theo top 10, ghi dưới tab KH từ khoá dịch vụ." >/dev/null 2>&1
  echo "$MSG"
  if [ "$END" = 1 ]; then osascript -e "display notification \"$MSG\" with title \"digicom N11\""; exit; fi
  sleep 900
done
