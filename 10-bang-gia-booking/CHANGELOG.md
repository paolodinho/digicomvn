# CHANGELOG - Biến động giá booking báo & PR

> Ghi tự động bởi scheduled task `booking-price-daily` (8h05 mỗi ngày).
> So sánh master hôm nay với backup hôm trước. Chỉ ghi thay đổi giá/thêm/gỡ.

## 2026-07-15
- Không biến động. (DanaSEO 3 tab PR báo lớn / Báo tỉnh / Link dofollow giữ nguyên; ECP Media, PR Báo Chí, Brands Vietnam vẫn chỉ công bố dải giá / yêu cầu liên hệ, không thêm được dòng chi tiết.)

## 2026-07-15
- Thêm 15 site TOPLIST từ SEODO (sheet gid 899451809): golook.vn, ohay.vn, travelist.vn, ubeauty.vn,
  toplistdanang/hanoi/cantho/saigon.com, topdongnai/tophaiphong/topbinhduong.com, danangaz.com,
  hanoi/hcm.inhat.vn, inhat.vn. Giá 1.000.000đ (inhat.vn 1.700.000đ), 2 link dofollow, 1000 từ 3-5 ảnh.
- Master: 1302 -> 1317 dòng. Toplist trên web: 20 -> 35 site. Đã import live (dgc_gia 673 -> 688).
- Thêm 55 outlet booking-pr MỚI từ SEODO (gid 600512532 booking báo + gid 71216803 báo tỉnh):
  46 báo lớn (elle.vn 36tr, vietnamfinance 16tr, brandsvietnam, sggp.org.vn, cand.com.vn, theleader,
  gov/tourism, 24hmoney...) + 9 báo tỉnh 24h (haiphong/vinh/danang/cantho 24h, hatinh24h...).
  Giá = THÀNH TIỀN (sau CK) của SEODO. Chỉ thêm outlet CHƯA có trên live (0 trùng, không đụng giá cũ).
  booking-bao-pr trên web: 228 -> 283 site. dgc_gia: 688 -> 743.
- Lỗi regex domain đa cấp (.gov.vn/.org.vn bị cắt thành .vn/.org) đã sửa: sggp.org.vn, vietnamtourism.gov.vn đúng.
