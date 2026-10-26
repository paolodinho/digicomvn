#!/bin/bash
# Lọc + chia lô 10 từ cho digicom, phạm vi 4 dịch vụ + booking truyền thông (26/10). Chạy lại được.
/usr/bin/python3 "$(dirname "$0")/prep_sources.py"
S=~/Claude-Workspace/_shared/skills/tu-khoa-den-dang-bai/scripts/seed_expand.py
W="$(cd "$(dirname "$0")" && pwd)"; O="$W/../seed-research-2026-10-24"
/usr/bin/python3 $S batches --work "$W" \
  --sources "$W/sources-clean.txt" \
  --ok "booking|\bbook\b|đăng bài|đăng báo|bài pr|\bpr\b|báo điện tử|báo chí|báo mạng|quảng cáo (trên )?báo|thông cáo|truyền hình|\btvc\b|\bvtv|\bhtv|\bvtc\b|\bvov|\bvoh|phát thanh|\bradio\b|tiếng nói việt nam|backlink|back link|textlink|text link|guest ?post|\blink (báo|dofollow|nofollow|chất lượng)|anchor|dofollow|nofollow|social entity|entity|toplist|top list|\bkol\b|\bkoc\b|fanpage|seo ?off ?page|off-page|domain rating|domain authority|referring domain" \
  --exclude "thiết kế|hosting|tên miền|google ads|adwords|quảng cáo facebook|facebook ads|tiktok ads|quảng cáo (google|tiktok|youtube|zalo|cốc cốc)|shopee|lazada|ngoài trời|billboard|pano|taxi|xe buýt|\bled\b|loa|thang máy|màn hình|báo giấy|tuyển dụng|việc làm|lương|thực tập|giáo trình|tiểu luận|luận văn|\bpdf\b|\bppt\b|đề thi|lịch phát sóng|xem trực tiếp|trực tiếp|xổ số|bóng đá|phim|tập [0-9]|hôm nay|tin tức|mới nhất|\bmp3\b|nghe đài|tần số|\bfm [0-9]|\bvé\b|net\.vn|\.com|\.vn|hội nghị|trung ương|chính phủ|bộ y tế|xăng|dầu|giá điện|\bgas\b|vtv ?go|vtvcab|\bxem\b|nhạc|giám đốc|thuê bao|dailymotion|máy bay|poster|book baos|knorr|\bgov\b|\bedu\b|cờ bạc|casino|nhà cái|tải về|download|crack|wordpress plugin|^(?!.*(quảng cáo|booking|\bbook\b|tvc|giá|phóng sự|tài trợ|talkshow)).*(truyền hình|vtv|htv|vtc|phát thanh|radio|vov|voh)" \
  --group "Booking báo PR, đăng bài PR=booking báo|book báo|đăng bài|đăng báo|bài pr|\bpr\b|booking bài|book bài|thông cáo|báo điện tử|báo chí|báo mạng|quảng cáo (trên )?báo" \
  --group "Textlink=textlink|text link" \
  --group "Guest post=guest ?post" \
  --group "Social entity=entity" \
  --group "Backlink quốc tế=(backlink|link).*(quốc tế|nước ngoài)|(quốc tế|nước ngoài).*(backlink|link)" \
  --group "Toplist=toplist|top list" \
  --group "Backlink, off-page=backlink|back link|\blink\b|anchor|dofollow|nofollow|off ?page|domain rating|domain authority|referring" \
  --group "Truyền hình, TVC=truyền hình|\btvc\b|\bvtv|\bhtv|\bvtc\b" \
  --group "Phát thanh, radio=phát thanh|\bradio\b|\bvov|\bvoh|tiếng nói" \
  --group "KOL, KOC, fanpage=\bkol\b|\bkoc\b|fanpage" \
  --group "Booking quảng cáo chung=booking|\bbook\b" \
  --kw-dir "$W/.." --size 10 --own-pages "$W/crawl/digicomvn.com.jsonl" --names-file "$W/names.txt" \
  --pillar "(book|booking|đăng|giá|chi phí).*(báo|bài)=/booking-bao-pr/" --pillar "textlink|text link=/mua-textlink/" \
  --pillar "guest ?post=/guest-post/" --pillar "entity=/backlink-social-entity/" --pillar "toplist|top list=/dich-vu-toplist/" \
  --pillar "(backlink|link).*(quốc tế|nước ngoài)=/backlink-quoc-te/" --pillar "(mua|dịch vụ|giá|bán|thuê).*backlink=/dich-vu-backlink/" \
  --pillar "truyền hình|tvc|vtv|htv=/booking-truyen-hinh/" --pillar "phát thanh|radio|vov|voh=/quang-cao-phat-thanh/" \
  --pillar "\bkol\b|\bkoc\b=/booking-kol-koc/" --pillar "fanpage=/booking-fanpage/"
