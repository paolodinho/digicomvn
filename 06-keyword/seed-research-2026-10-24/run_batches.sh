#!/bin/bash
# Lọc + chia lô 10 từ cho digicom (chạy lại được). Dùng: bash run_batches.sh [--sheet]
S=~/Claude-Workspace/_shared/skills/tu-khoa-den-dang-bai/scripts/seed_expand.py
W="$(cd "$(dirname "$0")" && pwd)"
python3 $S batches --work "$W" \
  --sources "$W/seeds.txt,$W/suggest.jsonl,$W/ac_core.txt,$W/../kp-raw/kt-gs-autocomplete.csv" \
  --ok "booking|\bbook\b|đăng bài|đăng báo|bài pr|\bpr\b|báo điện tử|báo chí|báo mạng|quảng cáo (trên )?báo|truyền hình|\btvc\b|\bvtv|\bhtv|\bvtc\b|\bvov|\bvoh|phát thanh|\bradio\b|đài (truyền|phát|tiếng|tỉnh)|thông cáo|tiếng nói việt nam" \
  --exclude "facebook|\bfb\b|google|tiktok|zalo|youtube|shopee|lazada|instagram|ngoài trời|billboard|pano|taxi|xe buýt|\bled\b|loa|thang máy|màn hình|\bkol\b|koc|\bseo\b|website|báo giấy|tuyển dụng|việc làm|lương|thực tập|học|giáo trình|tiểu luận|luận văn|\bpdf\b|\bppt\b|đề thi|lịch phát sóng|xem trực tiếp|trực tiếp|xổ số|bóng đá|phim|tập [0-9]|hôm nay|tin tức|mới nhất|\bmp3\b|nghe đài|tần số|\bfm [0-9]|vé|net\\.vn|\\.com|\\.vn|thông cáo\\.? ?báo chí (?!(mẫu|cách|viết|là|gửi|cấu trúc|ví dụ|sự kiện|ra mắt|khai trương|doanh nghiệp|công ty|dịch vụ|giá|đăng|phát hành|tiếng anh|trong tiếng anh|nghĩa|tiếng việt|hay|chuẩn|ngắn|gồm|có))|hội nghị|trung ương|chính phủ|bộ y tế|thi hành án|xăng|dầu|giá điện|\\bgas\\b|nhiên liệu|làng " \
  --group "Booking báo PR, đăng bài PR=booking báo|book báo|đăng bài|đăng báo|bài pr|\bpr\b|booking bài|book bài|thông cáo|báo điện tử|báo chí|báo mạng|quảng cáo (trên )?báo" \
  --group "Truyền hình, TVC=truyền hình|\btvc\b|\bvtv|\bhtv|\bvtc\b" \
  --group "Phát thanh, radio, VOV, VOH=phát thanh|\bradio\b|\bvov|\bvoh|đài|tiếng nói" \
  --group "Booking quảng cáo chung=booking|\bbook\b" \
  --known "$W/../kp-raw/kp-*.csv" --size 10
[ "$1" = "--sheet" ] && python3 $S sheet --project "$W/../.." --work "$W"
