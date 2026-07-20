# CHANGELOG - Biến động giá booking báo & PR

> Ghi tự động bởi scheduled task `booking-price-daily` (8h05 mỗi ngày).
> So sánh master hôm nay với backup hôm trước. Chỉ ghi thay đổi giá/thêm/gỡ.

## 2026-07-20 (routine tuần digicom-gia-doi-tac-tuan - đã đẩy LIVE)

**Kho master: 2.679 -> 2.715 dòng (+36) / 90 NCC / 7 dịch vụ.**

- **Admicro (VCCorp) +36 dòng, 5 rate card PDF mới bóc** (40 -> 76 dòng): giadinhnet.suckhoedoisong.vn
  (may2025, 6 vị trí 3-20tr), infonet.vietnamnet.vn (jul2024, 6 vị trí 4-20tr), 2sao.vn (jul2024,
  8 vị trí 2,5-10tr), vietnambiz.vn (apr2024, 8 vị trí 3-80tr), vietnammoi.vn (apr2024, 8 vị trí
  3-50tr). Mỗi báo phát hành rate card theo tháng RIÊNG - không dùng chung jan2026/apr2025, phải
  dò từng tháng. Admicro không thuộc 3 NCC lên web -> dữ liệu tham chiếu thị trường, không ra site.
  - Chưa lấy được: **phunuvietnam** (đã thử ~35 URL `phunuvietnam_`/`pnvn_` x 12 tháng x 2023-2026,
    đều 404). Cần Hiếu lấy link PDF thật từ admicro.vn/baogia (trang render JS).
  - Tìm thêm 14 URL rate card SỐNG chưa bóc: cafef/nld/cafebiz/dantri/thanhnien/vietnamnet/
    vnenconomy jan2026 (bản mới nhất), kenh14/soha/afamily apr2025.
  - Lưu ý: vietnambiz + vietnammoi là bản apr2024, infonet + 2sao bản jul2024 - đã cũ 1-2 năm.

- **ĐẨY LÊN LIVE: dgc_gia publish 849 -> 855.** Bảng giá /bang-gia/ 965 -> 971 dòng.
  - **6 đầu mục MỚI**: booking-bao-pr 2 (24h.com.vn "Bài PR loại 2 - Mục còn lại" 3.811.000;
    alobacsi.com "Bài loại 7 trang chuyên mục" 2.060.000), dich-vu-toplist 4 (cotrang.org Top 1
    7.200.000; quangninhcogi.vn Top 2-3 5.400.000; danhgiathuonghieu.vn Top 3 2.160.000;
    hcmtoplist.com bài khách tự gửi 960.000).
  - **6 dòng SỬA GIÁ** (đối chiếu tay từng dòng, đều là vị trí "Mục phù hợp" cùng tầng sản phẩm
    giữa 3 NCC chính): vietstock.vn 2.626.000->2.059.000, vietbao.vn 2.369.000->1.772.000,
    bienphong.com.vn 2.112.000->1.442.000, thethaovanhoa.vn 2.493.000->2.060.000,
    tuoitrexahoi.vn 1.648.000->1.236.000, lamchame.vn 1.442.000->1.854.000 (TĂNG).
  - Dry-run khớp (6 cập nhật / 6 tạo mới) trước khi ghi thật. Purge LiteSpeed. Verify curl.

- **KHÔNG áp 13 thay đổi giá khác - đối chiếu tay phát hiện sai sản phẩm** (đúng 3 cạm bẫy rule):
  - **6 dòng truyền hình: bẫy TVC 15 giây vs 30 giây** (cạm bẫy #2 - cùng vị trí khác quy cách).
    vtv1 khung giờ vàng 19h55 live 108.202.000 (TVC 30s) vs export 64.921.000 (TVC 15s);
    vtv1 6h20 41.241.000 (30s) vs 24.745.000 (15s); vtv3 Cà phê Sáng 20.621.000 (30s) vs
    12.372.000 (15s); htv9 Nhịp sống doanh nghiệp + htv7 Nhịp sống trẻ 24.720.000 vs 20.085.000
    (2 mức phóng sự khác nhau); htv9 Thời sự trưa 21.630.000 (tự giới thiệu 90 giây) vs
    12.360.000 (60 giây). Áp xuống = bán TVC 30 giây bằng giá 15 giây, dưới giá vốn.
  - **1 dòng diendandoanhnghiep.vn** 3.090.000 -> 2.781.000: giá rẻ hơn là của bài **700 từ**
    (DanaSEO), giá đang bán là bài **1000 từ** (Media Việt Nam) - khác quy cách, giữ nguyên.
  - **2 dòng toplist DR<=5** (rule lọc chất lượng 2026-07-19): itoplist.vn (DR 0,1),
    top10riviu.com (DR 4,8) - có trong gia-web.csv nhưng KHÔNG đẩy lên live.

- **SỬA LỖI RÒ TÊN NHÀ CUNG CẤP trong `export-web.py`** (phát hiện khi đối chiếu live):
  3 dòng entity `Famemedia.vn / Gói B150-B200-B300` lọt qua bộ lọc `is_khong_ro_noi_dang()` vì
  `dau_bao` có dấu chấm nên bị coi là domain hợp lệ. Nếu đẩy lên web thì bảng giá Digicom sẽ hiện
  thẳng tên miền nhà cung cấp - vi phạm rule "ẩn danh tính NCC", đồng thời là gói không có list
  site. Đã thêm set `NCC_DOMAIN` (25 tên miền NCC) chặn tuyệt đối + chặn cả trường hợp chữ
  "Gói"/"Combo" nằm ở `vi_tri` thay vì `dau_bao`. gia-web.csv 1.167 -> 1.164 dòng, entity về 0.
  Verify: grep tên 11 NCC trên gia-web.csv và trên HTML /bang-gia/ live = 0 kết quả.

- **goi_sites: vẫn để TRỐNG cho toàn bộ gói** (quét 9 NCC entity: Solann Digital, Tùng Phát,
  SEOTOP, SEOTORO, BuffSEO, dichvuentity.vn, Vutruso, KingNCT, Khoahocseotop). **Không bên nào
  công bố danh sách nền tảng trong gói** - chỉ nói chung chung "300 social DA/DR > 50". Xác định
  được NCC gốc của 4 gói Digicom đang bán là **Solann Digital** (cấu trúc gói trùng khớp: 50 /
  100 / 200+15 GStack / 300+15 GStack, giá gốc 539k / 1.049k / 1,99tr / 2,89tr) nhưng Solann
  cũng không công bố list. Danh sách 300+ nền tảng CÓ công khai trên blog chia sẻ miễn phí
  (HapoDigital, Headle, Mai Trung Kiên) nhưng đó là list của bên khác, KHÔNG phải cam kết của
  Solann -> dán vào trang bán là bịa gián tiếp, KHÔNG dùng. 4 gói entity giữ nguyên trạng thái
  draft. Cách duy nhất mở khoá: xin thẳng list từ Solann.

- **Rà lại 2 nguồn chính**:
  - **Media Việt Nam (6/6 tab Google Sheet): 0 dòng đổi giá** - đối chiếu số học toàn bộ 30 báo tỉnh,
    31 PR báo lớn, 31 site x 9 mốc textlink trang chủ, 30 gói sidebar, 13 guest-post du lịch, 2 GOV -
    100% khớp master. Không có tab mới ngoài 6 gid đã biết.
    - Quét thô báo "25 site mới" nhưng **kiểm chứng tay lại: 5 dòng báo tỉnh (baodanang.vn,
      baothainguyen.vn, nghean24h.vn, nguoihanoi.vn, baodaklak.vn) ĐÃ CÓ sẵn cả trong master lẫn
      trên live** - báo nhầm do so khớp thiếu. Không đẩy, tránh tạo dòng trùng.
    - 13/25 dòng còn lại **để trống ô giá trong sheet** (tab PR báo lớn ghi "báo lớn hay thay đổi,
      liên hệ sale") -> không có số thật, không đưa vào kho.
    - Thật sự sót 1 dòng: **Vnexpress.net mục "Công Nghệ" 9.880.000 chưa VAT** (2 link nofollow) -
      đã bổ sung vào master (2.715 -> 2.716 dòng). KHÔNG lên web vì cùng tầng chuyên mục vnexpress
      đã có dòng rẻ hơn (8.034.000) thắng giá.
    - 2 dòng nguồn đánh dấu "(Dừng)": quangninh.gov.vn, kinhtedothi.vn (tab textlink sidebar) -
      cần Hiếu xác nhận có gỡ khỏi bảng bán không.
  - **Fame Media: KHÔNG rà được - site đang DOWN.** famemedia.vn từ chối kết nối (`ECONNREFUSED :443`,
    HTTP 000), thử cả HTTP/80 và `www.`, cả curl lẫn WebFetch, kiểm lại 2 lần cách nhau ~20 phút đều
    hỏng. Đây là 1 trong 3 NCC được lên web (948 dòng master) -> cần rà lại khi site sống.

- **Toplist - quét thêm đối tác**: ATP Software (combo 5/8/15 site, 1,8-4tr, nofollow, 12 tháng -
  đã có trong master dưới tên ATP Media), Brando (chỉ "từ 3tr/năm" - giá mềm), BookBaoPR (11 site
  có domain nhưng cột giá đều "từ 1.000.000đ" -> giá mềm, loại), SetupOTA + DanaSEO + Newtop
  (giá cứng nhưng không nêu site nào -> rule "không rõ nơi đăng", không lên web). Domain mới ghi
  nhận nhưng chưa mua được giá cứng: toplist.vn, top10tphcm.com, topaz.vn, bangxephang.com.vn,
  brands.vn, xehay.com.vn, topuni.vn, topdichvu.vn. Không lấy được giá: btmkt.vn (404),
  toplistvietnam.vn + top1review.vn (chỉ hotline), atpholdings.vn (lỗi SSL).

## 2026-07-20 (booking-price-daily)
- Giá đổi: không có. DanaSEO (3 tab: PR báo lớn, Báo tỉnh, Link dof) trùng hash byte-for-byte
  với bản 2026-07-19; toàn bộ 2.659 dòng master cũ giữ nguyên giá.
- Thêm mới: **ECP Media - 20 dòng** (24h.com.vn, PR Desktop, 5 nhóm chuyên mục x 4 vị trí
  Đầu CM / Giữa CM / Loại 1 / Loại 2, giá 3.000.000 - 20.000.000, chưa gồm 10% VAT).
  Đây là nguồn MỚI so với 2026-07-19 - trang `bang-gia-dang-bai-pr-tren-bao-24h-com-vn.html`
  công bố giá dạng text (các trang ECP khác vẫn chỉ có PDF/ảnh).
- Gỡ bỏ: không có.
- Vẫn không lấy được: PR Báo Chí (chỉ khoảng giá chung + hotline), Brands Vietnam (chỉ điều
  khoản, báo giá qua email), Brandcom (bảng giá nhúng dạng ảnh), Vietquangcao (shortcode
  `[table id=5]` không render).
- Master: 2.679 dòng / 85 NCC / 7 dịch vụ (+20 dòng, +1 NCC).

## 2026-07-19
- Không biến động. DanaSEO (3 tab: PR báo lớn, Báo tỉnh, Link dof) không đổi so với 2026-07-18.
- Không thu được nguồn mới: ECP Media (PDF), PR Báo Chí (PDF/liên hệ), Brands Vietnam (liên hệ),
  Brandcom (ảnh), Vietquangcao (shortcode ẩn) vẫn không công bố giá từng đầu báo.
- Master: 2659 dòng / 84 NCC / 7 dịch vụ (không đổi).

## 2026-07-18 (Hiếu chốt: Media Việt Nam KHÔNG markup, như DanaSEO)
- Hiếu: "riêng giá từ DanaSEO và Media Việt Nam thì giữ; còn các bên khác cứ nhân 1,2".
  Cập nhật `export-web.py` (`KHONG_MARKUP = {"danaseo","media viet nam"}`) + rule
  `bang-gia-booking.md`. Export lại `gia-web.csv`.
- Backup DB lần 3: `~/backups/2026-07-18/db-before-mediavn-unmarkup.sql`.
- Đối chiếu lại (đã refresh live-now.json cho khớp state mới nhất, tránh so với bản cũ):
  **46 dòng hạ giá về đúng giá gốc Media VN/DanaSEO** (không markup nữa) - toàn bộ đã kiểm tra
  hợp lý trước khi ghi. Gồm: Cafebiz.vn, Laodong.vn, huengaynay.vn, vietnamtourism.gov.vn,
  nhahangbachkim.com.vn, 4 site textlink (baodongthap.vn/phunumoi.net.vn/kinhtemoitruong.vn/
  doanhnghiepkinhtexanh.vn, mỗi site nhiều mức giá), + vài đầu báo khác (24h.com.vn, kenh14.vn,
  Vietnamnet.vn, Techz.vn, tuoitre.vn) nơi giá Media VN không-markup giờ thắng thầu rẻ nhất.
- Dry-run khớp trước khi ghi thật. Đã ghi qua import-wp.php, purge cache, verify curl /bang-gia/.
  dgc_gia publish vẫn 607 (chỉ đổi giá, không thêm/xoá).

## 2026-07-18 (fix thiếu markup 20% - Hiếu duyệt riêng)
- Backup DB live lần 2: `~/backups/2026-07-18/db-before-markup-fix.sql`.
- 68 đầu báo/gói đang bán THIẾU mức markup x1.20 (lỗi cũ, phát hiện khi rà giá Media VN, không
  liên quan trực tiếp) - đã kiểm tra cả 68 dòng đúng tỷ lệ 1.19-1.21x (không dòng bất thường)
  trước khi ghi. Vd: elle.vn 36tr->43,2tr, vietnamfinance.vn 16tr->19,2tr, brandsvietnam.com,
  otosaigon.com, advertisingvietnam.com, sggp.org.vn, cand.com.vn, reatimes.vn, vir.com.vn...
  + 14 site toplist (golook/ohay/travelist/toplistdanang...) 1tr->1,2tr.
- Dry-run khớp (68 cập nhật, 0 tạo mới) trước khi ghi thật. Đã ghi qua import-wp.php, purge
  cache, verify curl /bang-gia/ elle.vn = 43.200.000. dgc_gia publish vẫn 607 (chỉ đổi giá).

## 2026-07-18 (Media Việt Nam - đã đẩy LIVE, Hiếu duyệt)
- Backup DB live trước khi ghi: `~/backups/2026-07-18/db-before-mediavn-import.sql` (host).
- Đối chiếu tay 417 dòng Media Việt Nam với 570 post live hiện có (không tin máy chọn giá rẻ
  nhất tự động, vì nhiều đầu báo Media VN ghi title kèm ghi chú "(BÁO MỚI VỀ)", "- Không nhận
  bài", "Tăng giá ngày..." làm domain không khớp tự động với bản sạch đã có trên live -> soát
  tay từng dòng để không tạo trùng lặp):
  - **5 dòng SỬA GIÁ** (đầu báo đã có, Media VN rẻ hơn): Cafebiz.vn Trang chủ 10,5tr->8,76tr,
    Laodong.vn Thông tin doanh nghiệp 6tr->5,88tr, huengaynay.vn 1,8tr->1,56tr,
    vietnamtourism.gov.vn 10tr->8,34tr, vietstock.vn 1,999tr->1,776tr.
  - **10 dòng LOẠI** (Vneconomy "Không nhận bài", Afamily/Eva/24h/baonghean/Thethaovanhoa/
    baocaobang/truyenhinhnghean/Baotayninh "BÁO MỚI VỀ"...): đều là đầu báo ĐÃ có trên live,
    giá live hiện tại đã rẻ hơn hoặc bằng Media VN -> giữ nguyên, không đăng trùng.
  - **37 dòng THẬT SỰ MỚI** đã tạo: 36 dòng textlink theo site (baodongthap.vn, phunumoi.net.vn,
    kinhtemoitruong.vn, doanhnghiepkinhtexanh.vn - mỗi site 9 mức giá: 3 loại link x 3 thời hạn)
    + 1 dòng guest-post nhahangbachkim.com.vn (720k/1 năm - khác domain .com đã có sẵn).
- Đã ghi live qua `import-wp.php` (dry-run khớp trước khi ghi thật): dgc_gia publish 570 -> 607.
  Purge cache LiteSpeed. Verify curl /bang-gia/: baodongthap.vn, nhahangbachkim, vietstock đều lên.
- KHÔNG áp 68 dòng "tăng giá +20%" mà `cap-nhat-gia.py` phát hiện cùng lúc (elle.vn, vietnamfinance...) -
  đây là lỗi thiếu markup CŨ từ trước (không liên quan Media VN), cần Hiếu xác nhận riêng trước khi
  sửa hàng loạt giá đang bán (xem mục cảnh báo cuối phiên).

## 2026-07-18 (routine tuần digicom-gia-doi-tac-tuan - đã đẩy LIVE)
- Quét 6 tab SEODO chưa tích hợp (gviz CSV công khai): booking PR (gid 600512532), báo tỉnh
  (71216803), guest post (604318967), bài PR (1903168453), textlink gói (570329285), toplist
  ngành (490006843).
- Đối chiếu tay với 936 post live: **6 outlet booking-bao-pr MỚI** (chưa có trên live), giá =
  THÀNH TIỀN sau CK của SEODO, markup x1.20 (SEODO không phải DanaSEO):
  giadinhonline.vn (5.040.000), suckhoe.vtv.vn (4.800.000), giadinh.suckhoedoisong.vn
  (3.120.000, 1 nofollow), svvn.tienphong.vn (3.120.000), hoahoctro.tienphong.vn (3.120.000),
  pasgo.vn (4.320.000, 1 nofollow, cam kết TOP10). Gán ngành y-te cho 2 dòng sức khỏe.
- Đã ĐẨY LIVE (import-wp merge, 0 trùng): dgc_gia publish 564 -> 570. Purge cache LiteSpeed.
  Verify curl /bang-gia/: cả 6 hiện, chính tả có dấu chuẩn.
- 14 file Admicro PDF "chưa bóc" trong nguon.md: đã tải 5 (genk/gamek/autopro/vtv/skds) - tất cả
  domain ĐÃ có trên live rồi (không thêm outlet mới). Báo tỉnh/guest-post/toplist tab: 0 outlet
  mới (đã có / generic không domain / không cột giá).
- KHÔNG đẩy 417 dòng Media Việt Nam (guest-post) - đang chờ Hiếu duyệt (xem block dưới), tránh
  mass-publish chưa verify (rule publish-volume-warning).
- Master: 1790 -> 1796 dòng. `gia-web.csv`: 912 dòng (gồm cả backlog Media VN chưa lên live).

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

## 2026-07-18 (batch 2) - Bo sung Fame Media, gioi han web chi 3 NCC
- Nap Fame Media tu Google Sheet moi (gid nhieu tab: Bao PR 369 dong, Bao Tinh Link Dofollow 46,
  Backlink Entity 3, Guestpost VN 396, Guestpost Global 100, Textlink goi RelevantLink 15) = 929
  dong moi. Xoa 3 block Fame Media cu (loi thoi, tu 14/07) de tranh trung/xung dot du lieu.
- export-web.py: them "fame media" vao KHONG_MARKUP (cung DanaSEO, Media Viet Nam). Them
  CHI_NCC = {danaseo, media viet nam, fame media} - CHI 3 ben nay len web, con lai luu trong
  master nhung an khoi site. Ngoai le: Toplist + Backlink quoc te van dung MOI NCC (co markup)
  vi 3 ben tren khong co du lieu 2 nhom nay - Hieu xac nhan qua AskUserQuestion.
- Don du lieu ban: 2 dong "Khong nhan bai / Ngung nhan" (Vneconomy.vn qua Media Viet Nam,
  baodanang.vn qua Fame Media) bi loai khoi web.
- Dong bo live: draft 375 ban ghi dgc_gia khong con thuoc 3 NCC, tao moi 943 ban ghi, sua gia 7.
  Backup day du tai ~/Claude-Workspace/_backups/routines/2026-07-18/famemedia-pricing/.
