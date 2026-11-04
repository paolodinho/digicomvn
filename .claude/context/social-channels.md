# Ma trận kênh + entity DigicomVN (lập 03/11/2026 theo skill multi-channel-social-post)

> Quy trình: `~/Claude-Workspace/_shared/skills/multi-channel-social-post/` (SKILL.md BƯỚC 0b,
> references/entity-nap.md, references/auto-schedule.md). NAP chuẩn: `entity-seo-checklist.md`.

## Entity (kiểm live 03/11/2026)
- Schema trang chủ: `Organization + ProfessionalService` có 6 `sameAs` (Facebook, LinkedIn công ty,
  YouTube, Pinterest, Zalo OA, Google Maps cid 2252645296724540673); `Person` Hiếu Đỗ có 2 `sameAs`
  (Facebook, LinkedIn cá nhân). Đạt.
- Còn thiếu (Hiếu tự đăng ký, nội dung soạn sẵn ở `entity-seo-checklist.md`): Bing Places,
  Crunchbase, Cylex, Hotfrog, Yellow Pages, Wikidata. Thêm URL vào `sameAs` khi có.

## Kênh đăng tự động
| Kênh | Hồ sơ | Quyền/token | Script | Trạng thái 03/11 |
|---|---|---|---|---|
| Google Maps - bài Cập nhật | Có (locations/8092429440912716524) | Có (token chung hieudx3107) | VPS `/opt/gbp-daily` site `digicom`, 10:30 + bù 13:00 | ĐANG CHẠY từ 02/11 (2 bài: micro-kol-la-gi, bao-mang-dien-tu-la-gi) |
| Google Maps - tab Ảnh | Có, 8 ảnh | Có | `gbp_media.py` (chưa đa site) | CHƯA: chưa có ảnh thật đạt (2 ảnh đội ngũ trong wp-uploads/team-photos trông như ảnh dựng AI, Google cấm ảnh không thật) |
| Zalo OA | Có (2806292509481772964) | ĐÃ cấp 03/11 | VPS `/opt/zalo-oa-daily` site `digicom` (cron đang comment #CHO-GOI-OA-20261103) | BỎ (Hiếu 03/11: không tự đăng Zalo OA; API cần gói OA trả phí) |
| Facebook Page | Có (profile.php?id=61591139212103) | CHƯA: token ICD chỉ gắn page ICD (granular target 313454468830162) | Sẽ làm bản đa site từ ICD `fb_share_new.py` (share bài web mới) | CHỜ Hiếu lấy token Graph API Explorer, app ICD AutoPoster 997316643288744, chọn page DigicomVN |
| LinkedIn | Công ty company/digicomvn + cá nhân Hiếu Đỗ | App ICD 86jntanm7rylg1 chỉ có w_member_social (đăng trang cá nhân); trang công ty cần w_organization_social (Community Management API, LinkedIn duyệt) | ICD `li_lib.py` | CHỜ Hiếu OAuth bằng LinkedIn cá nhân Hiếu Đỗ (share bài digicomvn.com) |
| YouTube @digicomvn | Có | CHƯA (token YouTube chỉ gắn kênh ICD UCwM7GwYRkIW0TvjYFQCNI4A) | ICD `youtube.py` + `yt_seo.py` | Để sau: DigicomVN chưa có nguồn video ngắn (ICD dựng từ bài fanpage) |
| Pinterest | Có | CHƯA | ICD `pinterest-daily-post` (ICD cũng chưa live) | Để sau |
| TikTok | Chưa có kênh | - | - | Để sau (ICD cũng tạm dừng) |
| Blogspot / WordPress.com / Bluesky | Chưa có | - | ICD `blogger-autopost` | Chỉ làm nếu Hiếu muốn thêm vệ tinh dẫn link |

## Không làm trùng
- Phiên digicom khác đang sửa hồ sơ Google Maps (W36) và Zalo OA (W10). Kiểm PLAN.md trước khi đụng 2 kênh này.
