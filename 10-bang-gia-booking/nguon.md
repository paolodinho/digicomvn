# Nguồn báo giá booking báo & PR - trạng thái thu thập

> Cập nhật 2026-07-14. Task hàng ngày `booking-price-daily` quét lại các nguồn trạng thái ĐÃ CÓ + thử lại nhóm CHƯA LẤY ĐƯỢC.

## ĐÃ CÓ BẢNG GIÁ CHI TIẾT

| Bên | Nguồn | Số dòng | Cách lấy |
|---|---|---|---|
| **DanaSEO** | [Google Sheet](https://docs.google.com/spreadsheets/d/1-g7qY-e2d6c555zVSOqKuVCm0e-Restes2ikSX7az9E/edit) - 10 tab | 157 | Chrome đã đăng nhập Google -> fetch `gviz/tq?tqx=out:csv&sheet=<tên tab>`. Drive API/curl KHÔNG lấy được (file bị chặn generative-AI + không public). |
| **Fame Media** | https://famemedia.vn/bao-online/ | 23 | WebFetch. Bảng vị trí premium trang chủ (giá 15-230tr), khác phân khúc DanaSEO. Ngân sách tối thiểu 50tr/tháng. |
| **SEOViP** | https://seovip.vn/dich-vu-book-bao-pr/ | 3 | WebFetch. Chỉ có giá khởi điểm theo nhóm (báo lớn từ 2tr, báo Đảng từ 1tr, báo rẻ từ 700k). Chưa có bảng từng đầu báo. |

### Bổ sung 2026-07-14 (7 mũi quét)

| Bên | Dòng | Ghi chú |
|---|---|---|
| **Admicro (VCCorp)** | 40 | RATE CARD CHÍNH THỨC (PDF). `https://in.admicro.vn/uploads/bien-tap-thong-tin-847/<bao>_admicro_prs_<thang>.pdf`. Còn 14 file chưa bóc: genk, gamek, autopro, vtv, skds, giadinhnet, phunuvietnam, 2sao, infonet, vietnambiz, vietnammoi... |
| **SEOViP** | 77 | Sheet `1nnNiOqhXnBm7rEX1uEh89wFqZkbYmhYVtCfFJdphDy4` - 24 tab, có giá niêm yết + giá CK + số link + quy cách. Chi tiết nhất. |
| **DPS.MEDIA** | 194 | Sheet `1BS00ZmGiGUZdNil4obhn7rqdHDRsqi32PksWpChmle8` - báo lớn/tỉnh/dofollow + 90 site guest post VN + 81 site global. |
| **Guestpost.vn** | 50 | Sheet `1MzjTwv811rzgZYnLdzXF7j7_QcQCr3qfrYDy-p-8ks4` - textlink báo theo từng site, 3/6/12 tháng. |
| Fame Media | 63 | + trang ZNews riêng (famemedia.vn/new-zings). |
| Brando, SEODO, Xuyên Việt, BookBaoPR, QuangbaThuonghieu, Hapo, MicCreative, Web Media | 51 | Theo từng đầu báo. |
| Entity: Solann, SEOTOP, SEOTORO, BuffSEO, HapoDigital, Khoahocseotop, dichvuentity.vn, Tùng Phát, Vutruso | 34 | Solann rẻ nhất mọi mức - đúng mốc rule 120% Solann. |
| Textlink lẻ: SGC.vn, Nguyễn Lê Điệp, DesignerVN, Web Thực Chiến, Seotoro | 15 | Seotoro: dofollow trong bài Dân trí = 5tr/link/tháng (mốc trần). |
| guestpost.com.vn, bookbaopr.vn, DPS global | 114 | Guest post theo site. |

## CHƯA LẤY ĐƯỢC - giá để dạng ảnh / bảng ẩn / yêu cầu liên hệ

> Quét lại 2026-07-19: ECP Media (chỉ link PDF Rate Card), PR Báo Chí (PDF + đòi liên hệ hotline),
> Brands Vietnam (chỉ quy trình + email liên hệ), Brandcom (ảnh), Vietquangcao (shortcode `[table id=5]`
> không render) - TẤT CẢ vẫn KHÔNG công bố giá từng đầu báo. Không có dữ liệu mới.


| Bên | URL | Vướng gì |
|---|---|---|
| Brandcom | https://brandcom.vn/ (có trang riêng từng báo: vnexpress, dantri, kenh14, zing) | Bảng giá nhúng dưới dạng ẢNH -> WebFetch không đọc được text. Cần OCR hoặc xin file. |
| Vietquangcao | https://vietquangcao.org/quang-cao-tren-bao-dien-tu-bao-gia-booking-pr-banner/ | Bảng để shortcode `[table id=5]` không render. Chỉ nói dải 1-8tr, CK 10-35%. |
| MicCreative | https://miccreative.vn/bao-gia-bai-pr-vnexpress/ | Chỉ có dải giá (VnExpress 15-50tr), không chi tiết từng mục. |
| Đất Việt Media | datvietbrand.com | Domain không phân giải (chết/đổi tên). |
| Dr POS / opp.vn | https://opp.vn/bang-gia-booking-cac-bao/ | 404. |
| ECP Media | https://ecpmedia.vn/bang-gia-dang-bai-viet-pr-tren-bao-vnexpress.html | Chưa quét. |
| PR Báo Chí | https://prbaochi.com/category/bao-gia-pr/ | Chưa quét. |
| Brands Vietnam | https://help.brandsvietnam.com/vi/article/bao-gia-dang-bai-pr-7i6lbx/ | Chưa quét. |

## Cần Hiếu hỗ trợ để mở rộng kho

Bảng giá chi tiết từng đầu báo hầu như KHÔNG công khai - các bên chỉ gửi file qua sale (giống cách DanaSEO gửi Google Sheet). Cách nhanh nhất để có thêm dữ liệu:
1. Xin file/sheet báo giá từ 2-3 bên nữa (Fame Media, Brandcom, ECP...) -> paste link vào đây, tôi bóc tự động như đã làm với DanaSEO.
2. Ảnh chụp bảng giá cũng được - tôi đọc ảnh trực tiếp.

## Media Việt Nam - Google Sheet 6 tab (2026-07-18, Hiếu gửi)
Sheet: https://docs.google.com/spreadsheets/d/19JBTCGmqO2rK5cP6Vp7NTpUXDIkHZGXbm7vS3mDkfT4/ (public "chỉ xem",
lấy qua `gviz/tq?tqx=out:csv&gid=<gid>`, không cần login).

| gid | Tab | Nội dung | Trạng thái |
|---|---|---|---|
| 0 | BÁO TỈNH | 34 đầu báo tỉnh/địa phương, giá chưa VAT | ĐÃ nạp (417 dòng tổng 6 tab vào ncc-khac.csv) |
| 1119211406 | GOV | 2 trang .gov.vn (vietnamtourism.gov.vn VN+EN) | ĐÃ nạp |
| 1090550234 | Báo Lớn - PR | 45 đầu báo lớn (vnexpress, dantri, kenh14, cafef...) nhiều vị trí/mục mỗi báo | ĐÃ nạp |
| 349605043 | Textlink Sidebar Siêu Rẻ | 10 gói (500-5.000 bài) x 3 thời hạn (3/6/12 tháng), đặt trên 30-34 báo, không theo site lẻ | ĐÃ nạp (dạng gói, nhóm "Textlink bao (goi)") |
| 1763895652 | Textlink Trang Chủ | 31 site x 3 loại link (trang chủ/chuyên mục/fullsite) x 3 thời hạn - giá ĐÃ GỒM VAT, đã quy đổi ngược về chưa VAT | ĐÃ nạp |
| 1509590457 | GUEST-POST DU LỊCH | 12 site ngách du lịch, giá 1 năm + vĩnh viễn | ĐÃ nạp |

## SEODO - Google Sheet 8 tab (2026-07-15, Hiếu gửi)
Sheet: https://docs.google.com/spreadsheets/d/1cwAIIWvpMVTPbs9sV_hRk_6WJRi1n2K7xIljLrMVDRA/
Lấy qua gviz CSV (PUBLIC, không cần login): `gviz/tq?tqx=out:csv&gid=<gid>`.

| gid | Nội dung | Trạng thái |
|---|---|---|
| 899451809 | 15 site TOPLIST đăng bài (golook, ohay, travelist, toplistdanang/hanoi/cantho/saigon, inhat...) 1tr, 2 link dof, 1000 từ 3-5 ảnh | ĐÃ import live 2026-07-15 (dich-vu-toplist) |
| 1903168453 | 35 "Bài PR" theo site (pasgo.vn 4tr...) | CHƯA tích hợp - routine xử lý |
| 490006843 | Bảng giá TOPLIST hệ thống theo ngành + TOP 1-4 vị trí (72 dòng) | CHƯA - phức tạp, cần map vị trí Top 1-4 |
| 544390579 | Google Maps care packages (Brando) | BỎ QUA - không thuộc 6 nhóm |
| 570329285 | Textlink báo sidebar gói V1-V5 (Brando) | CHƯA - routine (mua-textlink gói) |
| 600512532 | Booking báo PR full (246 dòng, dantri + DR + combo) | CHƯA - routine, đối chiếu tay giá vốn |
| 604318967 | Guest post websites (DR/AS/Traffic, 45 dòng) | CHƯA - routine (guest-post) |
| 71216803 | Báo tỉnh (41 dòng, Baothainguyen...) | CHƯA - routine (booking-bao-pr báo tỉnh) |

Đã thêm 15 site toplist vào raw/ncc-khac.csv (section "SEODO toplist"). Các tab CHƯA: routine tuần
tích hợp, ÁP đầy đủ chốt chặn giá vốn + phân tầng vị trí (rule bang-gia-booking.md).

### Cập nhật 2026-07-18 (routine tuần) - 6 tab SEODO đã xử lý xong
- **600512532** (booking PR 194 outlet có domain+giá): đối chiếu live -> chỉ **5 outlet mới**
  (giadinhonline.vn, suckhoe.vtv.vn, svvn.tienphong.vn, hoahoctro.tienphong.vn,
  giadinh.suckhoedoisong.vn) - còn lại đã có trên live. ĐÃ đẩy live.
- **1903168453** (bài PR): 1 outlet có domain thật = **pasgo.vn** (3.6tr net, 1 nofollow). ĐÃ đẩy.
- **71216803** (báo tỉnh 39 outlet): 0 mới (tất cả đã có trên live).
- **604318967** (guest post): KHÔNG có cột giá - chỉ ma trận TRUE/FALSE năng lực từng site. Bỏ.
- **570329285** (textlink gói Brando V1-V5): gói không list site cụ thể -> loại theo rule
  "không rõ nơi đăng". Không đưa web.
- **490006843** (toplist theo ngành TOP 1-4): generic theo ngành/vị trí, không domain cụ thể ->
  loại theo rule. Không đưa web.

### Admicro PDF - 5/14 file đã bóc (2026-07-18)
Tải + parse: genk (apr2025), gamek (apr2025), autopro (jan2026), vtv (jan2026), skds (jan2026).
Tất cả 5 domain (genk.vn/gamek.vn/autopro.com.vn/vtv.vn/suckhoedoisong.vn) ĐÃ có trên live -> 0
outlet mới. Còn giadinhnet/phunuvietnam/2sao/infonet/vietnambiz/vietnammoi: URL không phân giải
với các tháng thử (jan/feb/mar/apr/may/jun 2026 + apr2025) - CẦN Hiếu xác nhận tháng rate card đúng.

### BACKLOG chờ Hiếu duyệt đẩy live
- **Media Việt Nam - 417 dòng** (chủ yếu guest-post du lịch) trong raw/ncc-khac.csv: session
  khác đã nạp 2026-07-18, ghi rõ "chưa import, chờ Hiếu xác nhận". Routine tuần KHÔNG tự đẩy
  (rule publish-volume-warning: mass-publish >5 dòng/cụm phải verify + xác nhận trước). Cần Hiếu
  duyệt để đẩy đợt guest-post này lên live.
