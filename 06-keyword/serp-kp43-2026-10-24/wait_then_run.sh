#!/bin/zsh
# Chờ khoá allintitle trống (phiên ICD đang đo) rồi mới đo 138 từ KP 43 lô.
while pgrep -f allintitle_scrape.py >/dev/null || pgrep -f "serp_resume.sh.*k24" >/dev/null; do sleep 300; done
echo "$(date) khoa trong, bat dau"
DELAY=40 ~/Claude-Workspace/_shared/skills/content-audit-write/scripts/serp_resume.sh "/Volumes/Extreme SSD/Projects/digicom/06-keyword/serp-kp43-2026-10-24" serp:kw.txt
