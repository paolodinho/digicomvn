# CHANGELOG - Biến động giá booking báo & PR

> Ghi tự động bởi scheduled task `booking-price-daily` (8h05 mỗi ngày).
> So sánh master hôm nay với backup hôm trước. Chỉ ghi thay đổi giá/thêm/gỡ.

## 2026-07-18 (nạp thêm NCC mới)
- Thêm nhà cung cấp mới **Media Việt Nam** (Google Sheet Hiếu gửi, 6 tab: Báo tỉnh, GOV,
  Báo Lớn - PR, Textlink Sidebar (gói), Textlink Trang Chủ (theo site), Guest-post Du lịch).
  417 dòng giá vào `raw/ncc-khac.csv` (section riêng, cuối file).
- Giá gốc lấy cột "chưa VAT" của Media Việt Nam; tab Textlink Trang Chủ ghi "đã gồm VAT"
  nên đã quy đổi ngược (/1.08, làm tròn nghìn) để đồng nhất schema (gia_ban_digicom = chưa VAT).
- Master: 1373 -> 1790 dòng (89 nhà cung cấp). `gia-web.csv`: 906 dòng lên web (đã cạnh tranh
  giá rẻ nhất với NCC khác theo đúng rule, markup x1.20 áp cho Media Việt Nam vì không phải DanaSEO).
- CHƯA import lên WP live - đang chờ Hiếu xác nhận đẩy lên.

## 2026-07-18
- Không biến động. DanaSEO 3 tab (PR báo lớn / Báo tỉnh / Link dof) đã fetch mới qua Chrome:
  dữ liệu trùng khớp bản hôm qua (master khác nhau đúng cột ngày cập nhật, 0 dòng giá đổi/thêm/gỡ).
- Quét lại nguồn chưa có (ECP Media, PR Báo Chí, Brandcom, Vietquangcao, Brands Vietnam):
  vẫn chỉ PDF rate card / dải giá / yêu cầu liên hệ - không thêm được dòng chi tiết nào.
- Master: 1373 dòng, 88 nhà cung cấp.

## 2026-07-17
- Không biến động giá. DanaSEO chỉ đổi tên hiển thị: thanhnienviet -> thanhnienviet.vn
  (tab Link dof, giá giữ nguyên 2.000.000, DR 61) - khớp title đã sửa trên web trước đó.
- Quét lại 5 nguồn chưa có (ECP Media, PR Báo Chí, Brands Vietnam, Brandcom, Vietquangcao):
  vẫn chỉ PDF/ảnh/dải giá + yêu cầu liên hệ, không thêm được dòng chi tiết nào.
- Master: 1374 dòng, 91 nhà cung cấp.

## 2026-07-16
- DanaSEO | 24h.com.vn | PR loại 1 (2h trang chủ): DanaSEO TÁCH thành 2 tầng theo chuyên mục.
  - Nhóm KD/Thị trường tiêu dùng/Thời trang Hitech/CNTT/Ô tô/Xe máy/Sức khỏe/Đẹp: giữ giá cũ (gốc 9.000.000, KM 7.300.000).
  - Nhóm Thể thao/Giải trí/Bạn trẻ cuộc sống/Ăn - Chơi/Giáo dục: THÊM MỚI (gốc 7.000.000, KM 5.200.000) - rẻ hơn tầng trên.
  - 2 dòng "PR loại 2" đổi nhãn cho rõ chuyên mục (giá GIỮ NGUYÊN: gốc 6tr/5tr, KM 4,5tr/3,8tr).
- DanaSEO | Thethaovanhoa.vn (báo tỉnh): quy cách đổi 1 link dof -> 2 link dof (giá GIỮ NGUYÊN 2.000.000).
- Master: 1373 -> 1374 dòng (+1: tầng trang chủ 24h nhóm giải trí).
- Nguồn chưa mở được vẫn nguyên: ECP Media (chỉ có PDF rate card VnExpress, không parse được), PR Báo Chí (chỉ dải giá + yêu cầu liên hệ), Brands Vietnam. Không thêm dòng chi tiết nào.

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
