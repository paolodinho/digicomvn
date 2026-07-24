# Nguồn báo giá booking báo & PR - trạng thái thu thập

> Cập nhật 2026-07-14. Task hàng ngày `booking-price-daily` quét lại các nguồn trạng thái ĐÃ CÓ + thử lại nhóm CHƯA LẤY ĐƯỢC.

## ĐÃ CÓ BẢNG GIÁ CHI TIẾT

| Bên | Nguồn | Số dòng | Cách lấy |
|---|---|---|---|
| **DanaSEO** | [Google Sheet](https://docs.google.com/spreadsheets/d/1-g7qY-e2d6c555zVSOqKuVCm0e-Restes2ikSX7az9E/edit) - 10 tab | 157 | Chrome đã đăng nhập Google -> fetch `gviz/tq?tqx=out:csv&sheet=<tên tab>`. Drive API/curl KHÔNG lấy được (file bị chặn generative-AI + không public). |
| **Fame Media** | https://famemedia.vn/bao-online/ | 23 | WebFetch. Bảng vị trí premium trang chủ (giá 15-230tr), khác phân khúc DanaSEO. Ngân sách tối thiểu 50tr/tháng. |
| **ECP Media** | https://ecpmedia.vn/bang-gia-dang-bai-pr-tren-bao-24h-com-vn.html | 20 | WebFetch (nạp 2026-07-20). CHỈ trang 24h.com.vn có giá dạng text: 5 nhóm chuyên mục x 4 vị trí (Đầu CM / Giữa CM / Loại 1 / Loại 2), 3-20tr, chưa gồm **10% VAT**. Các trang ECP khác (VnExpress, VietnamNet, VnEconomy, BaoMoi...) vẫn chỉ có link PDF -> chưa bóc được. |
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

> Quét lại 2026-07-20: **ECP Media đã CHUYỂN sang mục "ĐÃ CÓ"** (trang 24h.com.vn có giá text,
> 20 dòng). 4 bên còn lại vẫn KHÔNG công bố giá từng đầu báo: PR Báo Chí (chỉ khoảng giá chung
> 10-50tr + hotline), Brands Vietnam (chỉ điều khoản VAT/deadline, báo giá qua email media@brvn.net),
> Brandcom (bảng giá nhúng dạng ảnh ở cả 3 trang Dân Trí/Kênh14/Zing), Vietquangcao (shortcode
> `[table id=5]` không render).


| Bên | URL | Vướng gì |
|---|---|---|
| Brandcom | https://brandcom.vn/ (có trang riêng từng báo: vnexpress, dantri, kenh14, zing) | Bảng giá nhúng dưới dạng ẢNH -> WebFetch không đọc được text. Cần OCR hoặc xin file. |
| Vietquangcao | https://vietquangcao.org/quang-cao-tren-bao-dien-tu-bao-gia-booking-pr-banner/ | Bảng để shortcode `[table id=5]` không render. Chỉ nói dải 1-8tr, CK 10-35%. |
| MicCreative | https://miccreative.vn/bao-gia-bai-pr-vnexpress/ | Chỉ có dải giá (VnExpress 15-50tr), không chi tiết từng mục. |
| Đất Việt Media | datvietbrand.com | Domain không phân giải (chết/đổi tên). |
| Dr POS / opp.vn | https://opp.vn/bang-gia-booking-cac-bao/ | 404. |
| ECP Media | https://ecpmedia.vn/bang-gia-dang-bai-viet-pr-tren-bao-vnexpress.html | ĐÃ CHUYỂN lên mục "ĐÃ CÓ" (2026-07-20) - trang 24h có giá text; riêng trang VnExpress vẫn chỉ là PDF Rate Card 2023. |
| PR Báo Chí | https://prbaochi.com/category/bao-gia-pr/ | Quét 2026-07-20: chỉ nêu khoảng giá chung (10-50tr báo lớn / 1-3tr báo nhỏ), không gắn đầu báo cụ thể; đòi liên hệ hotline. |
| Brands Vietnam | https://help.brandsvietnam.com/vi/article/bao-gia-dang-bai-pr-7i6lbx/ | Quét 2026-07-20: trang chỉ có điều khoản (VAT, deadline, huỷ bài); báo giá gửi riêng qua email media@brvn.net. |

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

## Cập nhật 2026-07-20 (routine tuần)

### Admicro - 10/14 file rate card đã bóc (+5 file tuần này)
Đã bóc: genk, gamek, autopro, vtv, skds (2026-07-18) + **giadinhnet (may2025), infonet (jul2024),
2sao (jul2024), vietnambiz (apr2024), vietnammoi (apr2024)** (2026-07-20, +36 dòng).
**Mỗi báo có tháng phát hành RIÊNG** - không dùng chung 1 tháng, phải dò `<bao>_admicro_prs_<thang><nam>.pdf`.

| Trạng thái | Đầu báo |
|---|---|
| CHƯA bóc, URL SỐNG (bản mới nhất jan2026) | cafef, nld, cafebiz, dantri, thanhnien, vietnamnet, vnenconomy |
| CHƯA bóc, URL sống (apr2025) | kenh14, soha, afamily |
| KHÔNG tìm được URL | **phunuvietnam** - đã thử ~35 URL (`phunuvietnam_`/`pnvn_` x 12 tháng x 2023-2026), tất cả 404 |

**Cần Hiếu hỗ trợ**: mở admicro.vn/baogia bằng trình duyệt (trang render JS, WebFetch không đọc
được link thật) -> copy URL PDF của phunuvietnam. Hoặc xin thẳng sale Admicro (PRSolution@admicro.vn).
Lưu ý: vietnambiz/vietnammoi bản apr2024, infonet/2sao bản jul2024 - cũ 1-2 năm, giá 2026 có thể đã tăng.

### Social Entity - KHÔNG bên nào công bố list nền tảng (quét 9 NCC, 2026-07-20)
Solann Digital, Tùng Phát, SEOTOP, SEOTORO, BuffSEO, dichvuentity.vn, Vutruso, KingNCT (403),
Khoahocseotop (từ chối kết nối) - tất cả chỉ mô tả chung ("300 social DA/DR > 50"), không liệt kê site.

**Xác định được NCC gốc của 4 gói Digicom đang bán = Solann Digital** (cấu trúc gói trùng khớp
chính xác): https://backlink.solanndigital.com/dich-vu-social-entity - 50 Socials VIP 539.000 /
100 Socials VIP 1.049.000 / 200+15 GStack 1.990.000 / 300+15 GStack 2.890.000. Solann chỉ mô tả
quy trình ("lọc 2.500 domain còn ~330 trang traffic >10k"), KHÔNG công bố list.

List 300+ nền tảng CÓ công khai trên blog chia sẻ miễn phí (hapodigital.com/danh-sach-300-mang-xa-hoi-chat-luong,
headle.net/list-social-entity, maitrungkien.com/danh-sach-300-social-entity) nhưng **KHÔNG dùng được**:
đó là list của bên khác, không phải cam kết của Solann với gói Digicom đang bán -> dán vào là bịa gián tiếp.

**Cần Hiếu hỗ trợ**: xin thẳng Solann danh sách nền tảng trong gói. Đây là cách DUY NHẤT có list
đúng. Nếu xin được -> điền `goi_sites`, 4 gói entity tự publish lại (hiện đang draft).

### Toplist - quét thêm 2026-07-20
| Bên | URL | Kết quả |
|---|---|---|
| ATP Software | https://atpsoftware.vn/dich-vu-toplist/ | Combo 5/8/15 site 1,8-4tr, nofollow, 12 tháng (đã có trong master dưới tên "ATP Media") |
| BookBaoPR | https://bookbaopr.vn/dich-vu-toplist-review/ | 11 site có domain (toplist.vn, top10tphcm.com, topaz.vn, danangaz.com, tophaiphong.com...) nhưng giá đều "từ 1.000.000đ" -> GIÁ MỀM, loại |
| SetupOTA | https://setupota.vn/book-bao-pr-toplist/ | Giá cứng + dofollow (hiếm) nhưng không nêu site -> "không rõ nơi đăng" |
| DanaSEO | https://danaseo.net/dich-vu-toplist | Bảng đầy đủ nhất (5 vị trí x 3 thời hạn x 4 nhóm khu vực) nhưng chỉ theo khu vực/ngành, KHÔNG domain -> không lên web |
| Newtop.vn | https://newtop.vn/dich-vu-toplist/ | Giá mới 8 bậc Top1-Top10 (350k-1tr/năm), không domain |
| Brando | https://brando.vn/dich-vu-toplist/ | "từ 3.000.000đ/năm" -> giá mềm |
| btmkt.vn | - | URL 404 |
| toplistvietnam.vn, top1review.vn | - | Có bán vị trí nhưng chỉ hotline, không công bố giá |
| atpholdings.vn | - | Lỗi SSL |

Domain toplist mới ghi nhận (chưa có giá cứng): toplist.vn, top10tphcm.com, topaz.vn,
bangxephang.com.vn, brands.vn, xehay.com.vn, topuni.vn, topdichvu.vn.

### Rà lại 2 nguồn chính 2026-07-20
- **Media Việt Nam**: 6/6 tab lấy được qua gviz CSV, **0 dòng đổi giá**, không có tab mới. Bổ sung 1
  dòng sót: Vnexpress.net mục "Công Nghệ" 9.880.000 chưa VAT (tab gid=1090550234). Lưu ý tab PR báo
  lớn có 13 dòng **để trống ô giá** ("báo lớn hay thay đổi, liên hệ sale") - muốn có giá phải hỏi sale.
  2 dòng đánh dấu "(Dừng)": quangninh.gov.vn, kinhtedothi.vn (textlink sidebar) - **Hiếu chốt 2026-07-20: GỠ**.
  Kiểm tra live: cả 2 CHƯA từng lên bảng bán (0 post dgc_gia), 3 subdomain kinhtedothi (thitruongtaichinh/
  tieudung/giaothonghanoi) đã ở trạng thái draft sẵn -> không phải gỡ gì. Đã thêm set `DA_DUNG_BAN`
  trong `export-web.py` chặn vĩnh viễn 5 tên miền này, phòng đợt quét sau nạp lại.
- **Fame Media: SITE DOWN** (2026-07-20). famemedia.vn trả `ECONNREFUSED :443` / HTTP 000 với mọi cách
  (curl, WebFetch, HTTP/80, www.), kiểm 2 lần cách nhau 20 phút. 948 dòng Fame Media trong master
  CHƯA rà được lần này. Các URL bảng giá khác tìm được qua search nhưng chưa đọc được nội dung:
  /quang-cao-vtv/, /backlink-bao/, /gia-quang-cao-khung-gio-vang-vtv/, /quang-cao-tren-truyen-hinh/,
  /tin-260/. **Cần rà lại khi site sống** - đây là 1 trong 3 NCC được lên web.

## Rise Media (Pinnexa Rise Media) - Google Sheet 1 tab (2026-07-24, Hiếu gửi)

Sheet: https://docs.google.com/spreadsheets/d/1uOvzvsZ-3clQR0bCPtr2JoCPJ3RyuTGF/edit?gid=1867970395
(public "chỉ xem", lấy qua `gviz/tq?tqx=out:csv&gid=1867970395`, không cần login).

- 196 đầu báo, 279 dòng giá (vị trí/tiểu mục), cột NIÊM YẾT + CHIẾT KHẤU + THÀNH TIỀN (giá sau CK).
- **Giá web = THÀNH TIỀN (đã chiết khấu) x 1.1** - theo yêu cầu Hiếu 2026-07-24 (khác quy tắc "giá cuối
  không markup" mặc định của `bang-gia-master.csv` - markup 1.1 đã bake sẵn vào `gia_ban_digicom` ở
  bước nạp, KHÔNG áp thêm markup NCC-khác (x1.20) của `export-web.py` nữa lên NCC này).
- Giá CHƯA gồm VAT 8% (ghi rõ trong sheet gốc).
- Script nạp: `parse-rise-media.py` (đọc `rise-media-raw.csv` -> ghi `raw/Rise-Media.csv` dạng pipe)
  -> `build_master.py` (đọc `raw/Rise-Media.csv` cùng nhánh với `ncc-khac.csv`).
- **CHƯA lên web**: `export-web.py` có `CHI_NCC = {danaseo, media viet nam, fame media}` (rule
  "CHỈ 3 NCC LÊN WEB" trong `bang-gia-booking.md`) - Rise Media hiện chỉ lưu trong
  `bang-gia-master.csv` làm dữ liệu tham khảo, KHÔNG xuất ra `gia-web.csv`/site. Muốn đẩy lên web
  phải thêm `"rise media"` vào `CHI_NCC` (và cân nhắc `NCC_MA`) rồi chạy lại export + import-wp.
- 13 dòng bị loại khi nạp (không có giá THÀNH TIỀN cụ thể - vd Elleman, Banner Vnexpress): giữ trong
  `rise-media-raw.csv` gốc, không đưa vào master.
