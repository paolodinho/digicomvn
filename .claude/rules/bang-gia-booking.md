# Bảng giá booking / guest post / textlink - quy tắc (chốt 2026-07-14)

> Kho dữ liệu: `10-bang-gia-booking/`. Đọc `README.md` trong đó trước khi sửa.

## Giao diện bảng giá: phân trang thật, KHÔNG còn khung cuộn ảo cố định (chốt 2026-08-09)

Hiếu chê bảng bị "nhốt" trong 1 khung cao cố định (`grid-scroll{height:560px;overflow:auto}`,
bản virtual-scroll dựng 2026-08-01) và cột giá dạng khoảng ("X - Y") bị ép 1 dòng nên tràn
ra ngoài màn hình mobile. Đã thay bằng bảng trôi tự nhiên theo trang + nút phân trang
(20 dòng/trang) ở `wp-theme/digicom-host/assets/js/price-grid.js` +
`assets/css/main.css` (khối `.grid-wrap/.grid-body/.grid-pager`, DGC_VER 2.7.3). Vẫn chỉ
ve 1 trang vào DOM tại 1 thời điểm (nhẹ như bản cũ), chỉ khác ở chỗ có nút chuyển trang thay
vì tự động vẽ thêm khi cuộn. Cột tên/giá dùng `minmax(0,...)` để không còn ép tràn ngang.

## Gộp nhiều vị trí/quy cách CÙNG 1 báo trên bảng giá web (chốt 2026-07-29)

1 báo (vd Kênh14, VietNamNet, Tuổi Trẻ) có thể bán nhiều vị trí/quy cách khác nhau (Trang chủ,
Chuyên mục, Tiểu mục...), mỗi vị trí là 1 dòng CPT `dgc_gia` riêng. Trước đây các dòng cùng 1
báo không chắc nằm cạnh nhau (cùng DR thì xen kẽ giữa nhiều báo khác nhau theo menu_order/giá)
-> bảng nhìn rối, tên báo lặp lại rải rác.

- `dgc_get_gia()` (`inc/cpt-gia.php`) giờ **gom theo tên báo TRƯỚC** (nhóm có DR/menu_order
  cao hơn lên trước), rồi mới sắp theo giá tăng dần TRONG từng nhóm - đảm bảo mọi vị trí của
  cùng 1 báo luôn đứng liền nhau trong bảng mặc định.
- **Kiểu CÂY, dòng gốc CHỈ thông tin chung + khoảng giá tổng quát, MẶC ĐỊNH THU GỌN** (chốt
  2026-07-30, GHI ĐÈ quyết định "mở sẵn mặc định" của 2026-07-29 - lý do đổi: trang có tới
  1212 dòng vị trí, mở sẵn hết khiến 1 báo nhiều vị trí chiếm hết "10 mục đầu" hiển thị, không
  ai lướt hết được. Hiếu: "mặc định bảng như này đi" kèm ảnh dòng gốc thu gọn + nút "Mở rộng
  vị trí"):
  - **PHP dựng cấu trúc tĩnh** (`dgc_gia_rows_html()` trong `inc/cpt-gia.php`, dùng chung cho
    `/bang-gia/` lẫn bảng giá trang dịch vụ `inc/service-pricing.php` - sửa 1 nơi cả 2 trang
    theo). Báo có >=2 vị trí -> render 1 dòng GỐC riêng (`dgc_gia_group_head_html()`, class
    `.bao-tree-head`) có logo/tên/DR/nút "Giới thiệu"/nút "Mở rộng vị trí" - cột Quy cách ghi
    "N vị trí đăng", **cột Giá hiện khoảng giá thấp nhất - cao nhất trong nhóm** (`$prices` do
    `dgc_gia_rows_html()` tính từ `dgc_gia_to_number(gia_km)` mọi vị trí con, truyền vào
    `dgc_gia_group_head_html($it,$count,$args,$prices)`), cột Đặt ngay để trống (đặt theo
    từng vị trí sau khi mở rộng). Sau đó là N dòng vị trí thật
    (`dgc_gia_row_html($it, array('in_group'=>true, 'is_last_in_group'=>...))`, class
    `.bao-group-cont`) - MỖI dòng vẫn có checkbox + quy cách + giá + nút Đặt ngay RIÊNG, chỉ ẩn
    phần lặp lại (logo/DR/link/nút giới thiệu, vì dòng gốc đã hiện). Báo chỉ có 1 vị trí -> dòng
    bình thường như cũ (không tách gốc, không tree).
  - **Đường kẻ cây**: nối dọc liền mạch + nhánh ngang bằng `td.cell-site:before/:after` trên
    từng dòng con (dòng cuối nhóm chỉ vẽ nửa trên - class `.is-last-in-group`, do PHP gắn sẵn
    lúc render, không cần JS tính). Chỉ hiện khi đã bấm mở rộng.
  - **JS chỉ còn việc mở/đóng** (`main.js` `regroup()`): dòng gốc mặc định THU GỌN
    (`expandedGroups[key]` mặc định `false`); bấm nút `.bao-group-toggle` trên dòng gốc mới đổi
    trạng thái, "xổ ra hết" toàn bộ vị trí con của báo đó. Tra cứu "dòng con thuộc nhóm nào" bằng
    `groupChildren{}` tính 1 lần lúc load (theo `data-bao-key`, KHÔNG dò `nextElementSibling`) -
    vì nút sắp xếp giá/DR sẽ di chuyển `<tr>` qua `tbody.appendChild()`, lúc đó dòng gốc và dòng
    con có thể không còn nằm cạnh nhau nữa; dò theo vị trí DOM sẽ vỡ ngay khi người dùng bấm sắp xếp.
  - **Bug 1 đã gặp + fix**: `regroup()` bản đầu tính nhóm dựa trên `r.style.display !== 'none'`
    - dòng con đã bị ẩn (thu gọn) thì bị loại luôn khỏi phép tính lần sau, nên bấm mở KHÔNG bao
    giờ hiện lại được (gà-trứng). Fix: theo dõi trạng thái "khớp lọc/phân trang" riêng bằng
    `r.dataset.matched` (set trong `applyFilter()`), độc lập với `style.display`.
  - **Bug 2 đã gặp + fix**: nhóm theo `post_title` NGUYÊN VĂN (cả ở `dgc_get_gia()` lẫn
    `dgc_gia_rows_html()`) bị tách nhầm khi dữ liệu nhập tay không đồng nhất hoa/thường
    ("Vietnamnet.vn" vs "vietnamnet.vn") - ra 2 nhóm cho cùng 1 báo, dòng đầu vẫn còn đủ giá/nút
    (do "nhóm" 1 phần tử render như dòng thường). Fix: gom theo `dgc_search_key($post_title)`
    (khoá đã chuẩn hoá bỏ dấu/hoa-thường/đuôi tên miền) ở CẢ HAI nơi, không so nguyên văn.
- Áp dụng chung cho cả `/bang-gia/` lẫn bảng giá trong trang dịch vụ (`inc/service-pricing.php`)
  vì cùng dùng `dgc_get_gia()` + `dgc_gia_row_html()`.

## Lọc chất lượng domain (chốt 2026-07-19)

Trước khi đưa 1 domain lên bảng giá, phải đạt tối thiểu:
1. **Link không chết** - domain phải resolve DNS + trả HTTP OK (không tính 403/429 vì đó là
   site lớn chặn bot, vẫn sống - phân biệt rõ 2 loại này, xem `check-link-status.py`).
2. **Không phải trang demo/tạm dựng để nhận link** - chưa có cách tự động đáng tin, cần xem tay.
3. **Traffic tối thiểu** - KHÔNG có nguồn miễn phí đo traffic thật chính xác (Ahrefs/Semrush MCP
   đang kết nối đều báo "Insufficient plan"; SimilarWeb qua AI đọc trang tự mâu thuẫn, không tin
   cậy). Proxy đang dùng: **Domain Rating (Ahrefs, API free, không qua AI nên không bị sai lệch)**
   - domain DR<=5 (đặc biệt DR=0, chưa từng có backlink) là tín hiệu mạnh cho traffic gần 0.

**Quy trình đã chạy 2026-07-19** (script trong `10-bang-gia-booking/`):
- `check-link-status.py` - quét DNS+HTTP toàn bộ domain trong `gia-web.csv`, phân loại
  OK / DEAD_DOMAIN (không resolve DNS, tin cậy cao) / LOI_KET_NOI / HTTP_LOI / BLOCKED (403/429,
  vẫn sống). Kết quả: `report-link-status.csv`.
- Tra Domain Rating qua Ahrefs free API cho toàn bộ domain OK (giao cho agent nền theo batch
  ~100 domain/agent để không phình context chính). Kết quả: `report-dr-all.csv` (toàn bộ),
  `report-dr-low.csv` (DR<=5, danh sách nghi vấn).
- **Đã draft trên live**: 183 dòng (182 domain DEAD_DOMAIN) + 143 dòng (144 domain DR<=5, trùng
  1 domain đã draft ở bước trước). Live còn 849/1175 dòng publish. Backup ID trước khi ghi tại
  `~/Claude-Workspace/_backups/routines/2026-07-19/bang-gia-ncc-code/` (rollback: đọc JSON, set
  lại `post_status=publish` cho các ID trong đó).
- Domain DR 6-thấp còn lại CHƯA bị động tới - chỉ 2 tiêu chí (link chết + DR quá thấp) được áp
  dụng, "trang demo sơ sài" và traffic chính xác vẫn cần Hiếu xem tay hoặc nâng gói Ahrefs/Semrush.
- Muốn traffic thật chính xác: cần Hiếu tự nâng gói Ahrefs (Site Explorer) hoặc Semrush (MCP
  access) - 2 gói đang kết nối không đủ quyền.

## CHỈ 3 NCC LÊN WEB (chốt 2026-07-18, tạm thời)

Hiếu: "ngoài danaseo, vietnam media, bổ sung thêm fame media -> tạm thời bỏ các bên khác,
lưu dữ liệu thôi ko dùng. Giá để bằng ba bên này."

- **`export-web.py`** có set `CHI_NCC = {"danaseo", "media viet nam", "fame media"}` - CHỈ 3 NCC
  này được xuất ra `gia-web.csv` / lên web. Mọi NCC khác (SEODO, DPS.MEDIA, Guestpost.vn, SEOViP...)
  **vẫn nằm trong `bang-gia-master.csv`** (dữ liệu tham khảo thị trường) nhưng KHÔNG xuất ra web.
- Cả 3 NCC này đều **KHÔNG markup** (`KHONG_MARKUP` gồm cả 3) - giá web = giá gốc/giá KM của
  chính NCC, không nhân 1,2 như các bên khác.
- **Ngoại lệ: Toplist + Backlink quốc tế** (`DICH_VU_NGOAI_LE_CHI_NCC`) - 3 NCC trên không có dữ
  liệu 2 nhóm này -> **giữ hành vi CŨ** (mọi NCC, có markup 1,2x) để 2 trang không bị trống bảng giá.
  Hiếu đã xác nhận chọn phương án này khi được hỏi (thay vì để trống hoặc draft 2 trang).
- Fame Media nạp từ Google Sheet (gid nhiều tab: Báo PR, Báo Tỉnh Link Dofollow, Backlink Entity,
  Guestpost VN, Guestpost Global, Textlink gói RelevantLink) - xem `nguon.md` để có link đầy đủ.
- **Đồng bộ live khi đổi CHI_NCC**: không chỉ update giá - phải **draft** các dòng `dgc_gia` published
  không còn khớp NCC nào trong `CHI_NCC` (không phải xoá - draft để rollback được), và **tạo mới**
  các dòng NCC/vị trí chưa từng có trên web. `import-wp.php` gốc CHỈ update+create, KHÔNG tự draft -
  phải tự viết script riêng (`draft-ids.php` mẫu) để set `post_status=draft` cho danh sách ID không khớp.
  Batch 2026-07-18: draft 375, tạo mới 943, sửa giá 7 (booking-bao-pr/guest-post/mua-textlink/booking-truyen-hinh).
- Muốn mở rộng lại (thêm NCC khác vào diện hiển thị) -> sửa `CHI_NCC` trong `export-web.py`, chạy lại
  `build_master.py` -> `gan-nganh.py` -> `export-web.py`, rồi đồng bộ live theo quy trình trên.

## Quy tắc giá (SỬA 2026-07-14 sau khi Hiếu phản hồi giá bị đội)

- **Giá Digicom báo khách = GIÁ DanaSEO ĐANG BÁN THẬT** (cột `gia_ncc_km` - giá khuyến mãi), KHÔNG phải giá gốc niêm yết.
  Lý do: giá gốc chỉ là giá gạch ngang; nếu lấy giá gốc thì Digicom đắt hơn chính DanaSEO -> mất khách.
- Giá chưa bao gồm VAT 8%.
- Bên khác chỉ được dùng để hạ giá khi **chắc chắn cùng quy cách bài** (cùng số từ, số ảnh, số link, cùng vị trí).
  KHÔNG tự động so giá giữa các bên bằng script - dễ so nhầm sản phẩm (vd Thanh Niên "Tiểu mục" 1.000 từ 15,5tr
  bị so với "PR cần biết" 300 từ 4tr; CafeF chuyên mục BĐS 10,4tr bị so với chuyên mục thường 6tr).
  Muốn hạ giá dòng nào -> đối chiếu tay từng dòng.

## Quy tắc lên web (digicomvn.com)

- Cùng 1 đầu báo + **thật sự cùng quy cách bài** -> lấy giá rẻ nhất. Đối chiếu TAY, không để script tự quyết
  (bài học 2026-07-14: script so nhầm sản phẩm khác quy cách, suýt bán dưới giá vốn).
- **ẨN danh tính nhà cung cấp.** Web không được lộ Digicom lấy hàng từ DanaSEO / Fame Media / bên nào.
- Không đưa cột giá mua vào, không đưa link nguồn NCC.
- Chạy `python3 export-web.py` -> sinh `gia-web.csv` (bản đã lọc, đã ẩn) rồi mới đưa lên web.

## Bộ lọc quy cách trên web (2026-07-14)

Bảng giá (`/bang-gia/` + bảng giá trong trang dịch vụ) có **thanh lọc ngang** (`inc/price-filter.php`) gồm 4 dropdown: **Nhóm báo**, **Loại link** (dofollow / nofollow / không chèn link), **Số ảnh** (từ 3, từ 5), **Độ dài** (từ 1.000 từ). Điều kiện đang bật hiện thành chip có nút x + nút "Xoá bộ lọc". KHÔNG quay lại cột lọc dọc (Hiếu 2026-07-14: phải gọn, bảng cần bề ngang).

- Giá trị suy TỰ ĐỘNG từ 2 field `so_link` + `yeu_cau` của mỗi dòng CPT `dgc_gia` (`dgc_gia_facets()` trong `inc/cpt-gia.php`) - sửa chữ trong WP Admin là bộ lọc tự đổi theo, không có field riêng để nhập.
- Quy ước thận trọng: "dưới 1000 từ" -> 999 (KHÔNG lọt bộ lọc "từ 1.000 từ", tránh hứa quá với khách); "3-5 ảnh" -> 5.
- Muốn 1 báo lọt bộ lọc nào -> ghi rõ trong `yeu_cau`, vd `1000 từ - 5 ảnh - 2 link dofollow`.
- Nhóm dịch vụ không có dữ liệu quy cách (vd Textlink) -> bộ lọc tự ẩn.

## Phạm vi dữ liệu

5 dịch vụ: `booking-pr` (PR báo lớn / báo tỉnh / báo link dofollow), `guest-post`, `textlink` (textlink bài, textlink home), `entity` (social entity), `toplist` (thuê vị trí / đăng bài toplist).

Nhóm taxonomy `dgc_nhom` trên web: booking-bao-pr, guest-post, mua-textlink, dich-vu-backlink, backlink-social-entity, **dich-vu-toplist** (thêm 2026-07-14 - phải khai trong CẢ `page-bang-gia.php` lẫn `inc/cpt-gia.php`, nếu không sẽ không render).

## Chính tả tiếng Việt (bắt buộc)

Dữ liệu bóc từ nguồn ngoài thường chuẩn hoá về ASCII không dấu. Text hiển thị cho khách (vi_tri, so_link, yeu_cau) **phải có dấu đầy đủ** - dùng `fix-dau.php` sau mỗi lần import.

## Cập nhật

Scheduled task `booking-price-daily` chạy 8h05 mỗi ngày: quét lại nguồn, dựng lại master, ghi biến động vào `CHANGELOG.md`.
Sheet DanaSEO chỉ đọc được qua Chrome đã đăng nhập Google (Drive API chặn file, curl bị đòi login).

## CHỐT CHẶN GIÁ VỐN (rule quan trọng nhất, chốt 2026-07-14)

**Không bao giờ để giá web thấp hơn giá vốn của chính dòng đó.**

Công thức giá bán mỗi dòng: `min(các giá NCC chắc chắn cùng đầu báo + cùng tầng vị trí, mà >= giá vốn)`.

- **Loại "giá mềm"** khỏi việc định giá: dòng ghi "giá từ...", dải giá "5tr-11tr", "giá khởi điểm" (BookBaoPR, Brando, SEODO, Mic Creative, Web Media, Hapo). Chúng chỉ là mồi câu, không mua được ở mức đó. Vẫn giữ trong master để tham chiếu thị trường.
- **Phân tầng vị trí** trước khi so giá: `trang-chu` (Top 1, trang chủ, đặc biệt, nổi bật) vs `chuyen-muc` (bài PR chuyên mục thường). KHÔNG so giá chuyên mục cao cấp (CafeF BĐS/Tài chính) với chuyên mục thường - khác sản phẩm, khác giá vốn.
- Bài học: nếu bỏ 2 chốt trên, 9 hạng mục sẽ bán dưới giá vốn (CafeF lỗ 2tr/bài, Tiền Phong lỗ 1,64tr/bài).

## Import lên live

`import-wp.php` (chạy qua `wp eval-file` trên host) + payload JSON sinh từ `bang-gia-master.csv`.
Chế độ GỘP: đầu báo đã có -> giữ dòng cũ (giữ tag ngành, DR, đánh dấu phổ biến), chỉ sửa `gia_km`. Đầu báo mới -> tạo bản ghi mới.
Backup trước khi import: `~/Claude-Workspace/_backups/routines/<ngày>/bang-gia-import/dgc_gia_full.json`.

## GIÁ CUỐI (chốt 2026-07-14 - ghi đè mọi quy tắc giá phía trên)

**Giá lên site = GIÁ CUỐI của chính nhà cung cấp dòng đó** - tức giá họ THỰC BÁN:
- Có giá khuyến mãi/chiết khấu -> lấy giá đó (DanaSEO lấy cột GIÁ KHUYẾN MÃI, SEOViP lấy giá CK).
- Chỉ có 1 giá -> lấy giá đó.
- KHÔNG lấy giá gốc niêm yết (giá gạch ngang) - sẽ đắt hơn chính NCC, khách bỏ đi.

`build_master.py` tự áp: `gia_ban_digicom = gia_ncc_km or gia_ncc_goc`.

## CHỈ DANASEO + LÃI 5% (chốt 2026-08-09, GHI ĐÈ mục "GIÁ VỐN 100%" ngay dưới đây)

Hiếu: "nguồn báo giá chỉ giữ lại danaseo; giá niêm yết bằng giá danaseo + 5%, đây là mức lãi 5%".

- **Nguồn**: `CHI_NCC = {"danaseo"}` trong `export-web.py` (bỏ Media Việt Nam, Fame Media,
  Rise Media khỏi web - vẫn lưu trong `bang-gia-master.csv` làm tham khảo). Ngoại lệ
  `dich-vu-toplist` + `backlink-quoc-te` vẫn giữ mọi NCC (không có dữ liệu DanaSEO cho 2
  nhóm này, để trang không trống).
- **Giá web** = `gia_ban_digicom` (giá vốn DanaSEO) × **1,05**, làm tròn nghìn
  (`MARKUP_DANASEO` trong `export-web.py`, hàm `web_gia()`).
- **Đã đẩy live 2026-08-09**: 1837 dòng `dgc_gia` đang publish → 596 cập nhật giá (theo
  công thức mới), **959 chuyển draft** (từng thuộc NCC vừa bị loại, xác định bằng cách đối
  chiếu 2 bản `gia-web.csv` TRƯỚC/SAU khi đổi `CHI_NCC`, không dựa vào field `ma_ncc` vì
  ~745/1837 dòng chưa từng được gắn mã). 249 dòng không khớp cả 2 bản → giữ nguyên, cần xem
  tay. Script: `cap-nhat-gia-danaseo.py` (khác `cap-nhat-gia.py` cũ ở chỗ CÓ bước draft).
  Backup đầy đủ (giá + trạng thái publish của toàn bộ 1837 ID):
  `~/Claude-Workspace/_backups/routines/2026-08-09/gia-danaseo-only/live-now-BEFORE.json`.
- Muốn đổi mức lãi (vd 5% → 8%) → sửa hằng số `MARKUP_DANASEO` trong `export-web.py`, chạy
  lại `python3 export-web.py`, rồi chạy `cap-nhat-gia-danaseo.py` (cần `GIA_WEB_BEFORE` trỏ
  tới bản snapshot cũ để so sánh) và áp qua `apply-danaseo-only.php` như lần 2026-08-09.

## (LỊCH SỬ - không còn áp dụng) GIÁ VỐN 100% - KHÔNG MARKUP AI (chốt 2026-07-29)

Hiếu: "tất cả để bằng giá vốn". Đã bỏ TOÀN BỘ markup đang áp (3 NCC chính x1,03 - chốt
2026-07-19; NCC khác x1,20 - chốt 2026-07-15; Rise Media x1,1 - chốt 2026-07-24).
Giá web hiện tại = **đúng giá vốn NCC báo (gia_ban_digicom)**, không cộng thêm đồng nào.

- Sửa ở `export-web.py` (`web_gia()` chỉ trả về `gia_ban_digicom`, đã xoá hằng số MARKUP/
  MARKUP_CHINH/KHONG_MARKUP) và `parse-rise-media.py` (MARKUP 1.1 -> 1.0).
- Tiện thể sửa `build_master.py`: BASE trước hardcode đường dẫn SSD
  (`/Volumes/Extreme SSD/...`) trong khi dự án đang chạy trên Google Drive -> pipeline
  không rebuild được. Đổi về `os.path.dirname(os.path.abspath(__file__))` như các script khác.
- Đã đẩy live 2026-07-29: đối chiếu `cap-nhat-gia.py` với snapshot live mới fetch (1175 dòng)
  -> 835 dòng đổi giá (828 giảm vì bỏ markup, 7 tăng vì kho có giá mới hơn từ NCC), 303 dòng
  không khớp giữ nguyên, 30 dòng bảng nhiều mức (textlink) bỏ qua, 7 dòng mơ hồ giữ nguyên -
  đúng theo rule an toàn cũ. Backup gia_km TRƯỚC khi ghi:
  `~/Claude-Workspace/_backups/routines/2026-07-29/gia-von-full/live-now-BEFORE-PUSH.json`.
- **Ý nghĩa:** Digicom không còn biên lợi nhuận nào trên giá niêm yết trên web nữa - đây là
  quyết định kinh doanh của Hiếu, không phải lỗi. Muốn có lại biên -> phải chủ động thêm
  markup trở lại (sửa `web_gia()`), không tự ý khôi phục.

## (LỊCH SỬ - không còn áp dụng) MARKUP: 3 NCC chính x1,03, NCC khác x1,20 (chốt 2026-07-19)

**Giá web = giá vốn × 1,03 cho 3 NCC chính (DanaSEO, Media Việt Nam, Fame Media), × 1,20 cho
mọi NCC khác.** Trước đó 3 NCC chính giữ nguyên giá gốc (không markup) - Hiếu đổi 2026-07-19:
"nhân thêm 1.03 cho chắc" (có biên lợi nhuận tối thiểu, vẫn rẻ hơn hẳn NCC khác x1,20).
Áp ở `export-web.py` (`MARKUP_CHINH = 1.03`, `MARKUP = 1.20`, set `KHONG_MARKUP` giữ tên cũ
nhưng giờ nghĩa là "nhóm markup nhẹ", không phải "không markup").

### Mã NCC nội bộ (chốt 2026-07-19)

Field `ma_ncc` (WP Admin, CPT Bảng giá) gắn mã số cho từng dòng để Hiếu tra nhanh nhà cung cấp
mà không cần mở từng post: **1 = DanaSEO, 2 = Media Việt Nam, 3 = Fame Media, 9 = Khác/tham
khảo**. Field này **CHỈ hiện trong WP Admin** (meta box "Chi tiết giá" + cột riêng trong danh
sách Bảng giá) - front-end/khách hàng KHÔNG BAO GIỜ thấy (vẫn giữ nguyên tắc ẩn danh tính NCC).
`export-web.py` tự gán mã theo `nha_cung_cap` (`NCC_MA` dict) khi xuất `gia-web.csv`;
`import-wp.php` ghi mã này vào meta khi tạo dòng mới. Dòng đã publish trước 2026-07-19 (từ NCC
khác 3 bên trên, hoặc trước khi có field) chưa có mã - cần đồng bộ lại nếu muốn khớp đầy đủ.

- Markup áp ở `export-web.py` (`web_gia()`, set `KHONG_MARKUP = {"danaseo", "media viet nam"}`
  sau khi qua `fold()`), **cấp DÒNG, TRƯỚC khi chọn min giữa các NCC** -> 2 bên không markup và
  bên khác (×1,20) vẫn cạnh tranh sòng phẳng, lấy rẻ nhất. Đầu báo nào DanaSEO/Media Việt Nam có
  bán thì giá không đổi; đầu báo chỉ có ở nguồn khác mới tăng 20%.
- **Bao trùm rule cũ "truyền hình +20%"** (TV đều là NCC ngoài DanaSEO) -> đã BỎ block markup
  TV riêng trong `cap-nhat-gia.py` để tránh nhân đôi (×1,44). Rule "Giá truyền hình +20%" ở
  trên giờ chỉ là trường hợp riêng của rule tổng này.
- **Social entity** (Solann Digital, non-DanaSEO) -> ×1,20 = đúng "120% Solann" đã chốt.
- Làm tròn nghìn. Tác động lần đầu (2026-07-15): 576/1051 dòng web tăng 20%, 0 dòng giảm.
- Tác động mở rộng ngoại lệ Media Việt Nam (2026-07-18): các dòng Media VN đã lỡ lên live có
  markup (guest-post nhahangbachkim.com.vn, 4 site textlink baodongthap.vn/phunumoi.net.vn/
  kinhtemoitruong.vn/doanhnghiepkinhtexanh.vn, + 5 dòng sửa giá hôm 2026-07-18) cần hạ lại về
  giá gốc không markup - xử lý bằng `cap-nhat-gia.py` sau khi export lại `gia-web.csv`.

## Bộ lọc lĩnh vực (ngành)

Field `nganh` (CSV slug, vd `tai-chinh,doanh-nghiep`) quyết định dòng có lọt bộ lọc lĩnh vực không.
`gan-nganh.py` suy ngành từ tên miền + nhóm dịch vụ. Gói dịch vụ (Gói/Combo/Social entity/Toplist...)
KHÔNG gắn ngành - chúng không thuộc lĩnh vực cụ thể nào.

## Cách gọi đơn vị bán (2026-07-14)

Chỉ nhóm **Booking báo & PR** gọi là "**báo**". Các nhóm còn lại (guest post, textlink, backlink,
entity, toplist) gọi là "**trang**" - đó là website/blog, không phải toà soạn.
Helper: `dgc_nhom_don_vi( $slug )` trong `inc/cpt-gia.php` - dùng cho nút "+ Chọn ... này",
tiêu đề bảng, tên cột, placeholder ô tìm.

## Tìm kiếm (2026-07-14)

"Báo Thanh Niên" / "thanh niên" / "thanhnien" / "thanhnien.vn" phải ra **cùng kết quả**.
Cách làm: `dgc_gia_search_terms()` sinh 2 khoá cho mỗi dòng - `data-name` (có dấu + bỏ dấu)
và `data-key` (nén: bỏ dấu, bỏ khoảng trắng, bỏ đuôi tên miền, bỏ tiền tố "bao").
JS `nenKhoa()` trong `main.js` nén truy vấn theo đúng quy tắc đó. Sửa 1 bên phải sửa bên kia.

Tìm kiếm toàn trang: `search.php` - tách kết quả thành 2 nhóm **Bảng giá** (CPT `dgc_gia`,
dùng `dgc_search_gia()`) và **Bài viết** (post/page). Ô tìm: nút kính lúp ở header (desktop)
+ ô trong menu drawer (mobile - nút kính lúp bị ẩn vì hàng header chật, logo bị bóp).

## 2 nhóm mới mở 2026-07-14: Backlink quốc tế + Booking truyền hình

Taxonomy `dgc_nhom`: **`backlink-quoc-te`** (100 dòng) và **`booking-truyen-hinh`** (33 dòng).
Nhớ khai slug ở CẢ `page-bang-gia.php`, `inc/cpt-gia.php` (mảng `$terms`) **và** `dgc_search_gia()`.

**Chốt chặn giá vốn cho 2 nhóm này (quan trọng):** `export-web.py` có `KEY_CHI_TIET` -
với `textlink / entity / backlink-quocte / booking-tv`, khoá gộp phải kèm `nhom + vi_tri + quy_cach`.
Lý do: cùng kênh VTV1 nhưng "TVC 30 giây" (105tr) khác hẳn "phóng sự bản tin" (40tr); gộp theo tên
kênh rồi lấy giá rẻ nhất = bán TVC bằng giá phóng sự. Tương tự guest post quốc tế DR30+ vs DR60+.

**Giá mềm:** `is_soft()` loại cả `"gia mem"` và `"gia tu"` trong `ghi_chu` (không chỉ `vi_tri`).

**Quy đổi ngoại tệ:** USD x 26.000, EUR x 28.000. Ghi giá gốc ngoại tệ vào `ghi_chu`.

**Truyền hình không có link** -> để trống field `so_link` (không ghi "không áp dụng").

**Chính tả:** dữ liệu bóc về là ASCII không dấu -> `payload-2-nhom-moi.py` có từ điển phục hồi dấu.
Sau import phải quét lại, không để chuỗi mất dấu lọt lên web.

## 3 nhóm mới 2026-07-16: QC loa phường + QC phát thanh + QC màn LED

Taxonomy `dgc_nhom`: **`quang-cao-loa-phuong`** (18), **`quang-cao-phat-thanh`** (82),
**`quang-cao-man-led`** (93). Slug đã khai ở page-bang-gia.php, cpt-gia.php ($terms + nhom_labels
+ dgc_current_nhom), don_vi: khu vực/kênh/vị trí. Nhóm media (không link) dùng nhánh intro như TV.
- Nguồn: quét Google 2026-07-16 (3 agent, >=50 kết quả/từ khoá). Data gốc + payload:
  scratchpad session `qc-moi/` (loa-phuong.json, phat-thanh.json, man-led.json). NCC chính:
  Brandcom, TVC24, Tindi (loa/radio); bảng gốc VOV + VOH; Unique OOH, Trimai (LED/thang máy).
- Giá web = giá NCC x 1,20 (đúng rule markup NCC ngoài DanaSEO), làm tròn nghìn. Loại "giá từ"
  (14 dòng) + combo màn không list toà (12 dòng - rule không rõ nơi đăng).
- Loa phường: dòng cấp "quận/huyện theo miền" GIỮ (bản chất dịch vụ - khách chỉ định quận/phường
  khi đặt, đơn giá theo ngày/khu vực). Nếu Hiếu muốn siết như rule toplist thì draft sau.
- Đơn giá kèm đơn vị trong yeu_cau ("giá/ngày", "giá/lần phát", "giá/tháng", "màn/tuần") -
  KHÔNG so giá chéo đơn vị.
- Trang pillar: page 2439/2440/2441 (tpl-service.php), đã vào menu + lưới trang chủ (11 dịch vụ).
- Routine tuần `digicom-gia-doi-tac-tuan` CHƯA quét 3 nhóm này - muốn tự cập nhật thì mở rộng routine.

## Giá truyền hình: +20% (chốt 2026-07-15)

`booking-truyen-hinh`: giá web = **giá NCC x 1,20** (mọi kênh). Lý do: truyền hình cần ê-kíp,
kịch bản, duyệt hồ sơ nhà đài -> biên phải cao hơn báo điện tử. Các nhóm khác vẫn giữ quy tắc
"giá cuối rẻ nhất của NCC", không cộng thêm.

## Giá tham khảo - hiện ở MỌI nơi có giá (chốt 2026-07-15)

`inc/price-note.php` (option `price_note`, sửa ở WP Admin) - include vào **mọi** trang có giá:
`page-bang-gia.php`, `inc/service-pricing.php`, `search.php`. Thêm trang mới có giá -> include luôn.
Nội dung: giá là **giá tham khảo, có thể thay đổi vào phút chót**, kèm nút Gọi + Nhắn Zalo.

## Cạm bẫy khi cập nhật giá hàng loạt (suýt dính 2026-07-15)

1. **Dòng Textlink có giá dạng BẢNG nhiều mức** (Home/CM/Fullsite x 3-6-12 tháng) - `gia_km`
   chứa nhiều con số. Script gộp chữ số thành 1 số khổng lồ rồi ghi đè bằng 1 giá đơn -> **xoá sạch
   bảng bậc thang**. Luôn bỏ qua dòng có > 1 cụm số trong `gia_km`.
2. **Cùng vị trí nhưng khác quy cách** (HTV7 "Người Bí Ẩn" = TVC 10s/20s/30s) - khớp thiếu
   `quy_cach` sẽ gộp về giá TVC 10 giây. Khoá khớp: `(nhóm, đầu báo, vị trí)`; nếu vị trí đó có
   nhiều mức giá -> **bắt buộc** khớp thêm `quy_cach`, không khớp được thì GIỮ NGUYÊN.
3. **Tầng vị trí cao cấp** (CafeF "Chuyên mục 1 BĐS" 10,4tr, Cafebiz "Trang chủ") - kho chỉ có
   chuyên mục thường 5tr. Hạ xuống = bán dưới giá vốn. Giữ nguyên, đối chiếu tay (đúng rule cũ).

Script: `10-bang-gia-booking/cap-nhat-gia.py` (đã cài đủ 3 chốt trên).

## Giá tham khảo + Giới thiệu báo/trang (SỬA 2026-07-15)

- **Ghi chú "giá tham khảo" đổi thành DÒNG CHỮ NHỎ, đặt CUỐI bảng, KHÔNG CTA** (trước là
  thanh nổi bật kèm nút Gọi/Zalo giữa bảng - Hiếu thấy dài dòng). `inc/price-note.php` giờ chỉ
  render `<p class="price-foot-note">` (không nút). Include SAU bảng ở: `page-bang-gia.php`,
  `inc/service-pricing.php`, `search.php`. Nội dung vẫn sửa ở WP Admin (option `price_note`).
  Lời kêu gọi liên hệ đã đủ ở popup ưu đãi + nút Zalo nổi.
- **Mỗi dòng bảng giá (báo/site lẻ, KHÔNG phải gói) có dòng nhỏ "Giới thiệu báo/trang này"**
  bấm sổ ra 4 mục: Tổng quan (là gì + uy tín theo DR), Lĩnh vực phù hợp (từ tag ngành),
  Hỗ trợ SEO/GEO (theo loại link dofollow/nofollow/none), Ước tính hiệu quả (% tăng trưởng).
  Helper `dgc_gia_intro_rows()` trong `inc/cpt-gia.php` SINH TỰ ĐỘNG từ field thật (DR, nganh,
  so_link/yeu_cau, nhóm) - KHÔNG bịa số tuyệt đối; con số tăng trưởng deterministic theo post_id,
  luôn ghi "Ước tính... tuỳ ngành" (không cam kết). Toggle JS trong `main.js` (`.intro-toggle`).
  Gói (entity/combo) KHÔNG có dòng này - đã có nút "Gói gồm những gì?".

## Giới thiệu báo/trang - KHÔNG cứng nhắc, layout gọn (SỬA 2026-07-15)

- **Nội dung mục thứ 3 thích ứng theo loại dịch vụ, KHÔNG ép mọi thứ về SEO/GEO** (Hiếu:
  "truyền hình thì không cần cứ phải áp cho SEO/GEO, hiệu ứng khác về truyền thông cũng không sao").
  Truyền hình -> nhãn "Hiệu quả truyền thông" (phủ sóng/branding/nhận diện); các nhóm còn lại
  (có link) giữ nhãn "Hỗ trợ SEO / GEO" theo loại link. Mục "Ước tính hiệu quả" cũng đổi: TV nói
  "nhận biết thương hiệu tăng %", còn lại nói "tìm kiếm thương hiệu + traffic giới thiệu tăng %".
  Logic ở `dgc_gia_intro_rows()` biến `$is_tv`.
- **Layout `intro-detail` xếp DỌC** (nhãn nhỏ in hoa màu brand ở trên, nội dung ở dưới, vạch ngăn
  giữa các mục) - bỏ lưới 2 cột 120px cũ (gây vỡ chữ mỗi từ 1 dòng trên mobile, Hiếu chê xấu).

## Nút menu "Bảng giá" - ĐÃ BỎ (2026-08-09)

Mục menu "Bảng giá" (từng nổi bật nhẹ theo rule 2026-07-15) đã gỡ khỏi header/footer/bottom-nav
khi bỏ hẳn trang tổng hợp `/bang-gia/` - xem `.claude/rules/uu-dai-cta.md` mục "Bỏ hẳn trang tổng
hợp /bang-gia/ - moi trang dich vu la money page rieng". CSS `.nav>ul>li>a[href*="/bang-gia"]`
trong `main.css` giờ là dead selector (không còn link nào khớp) - vô hại, có thể xoá khi dọn CSS.

## Trang dịch vụ + routine tuần (2026-07-15)

- Đã tạo trang dịch vụ **Toplist** `/dich-vu/dich-vu-toplist/` (page id 2113, template tpl-service.php).
  8 trang dịch vụ hiện có: mua-textlink, dich-vu-backlink, guest-post, booking-bao-pr, dich-vu-toplist,
  backlink-social-entity, backlink-quoc-te, booking-truyen-hinh. Đều list ở hub `/dich-vu/` (page-dich-vu.php)
  và lưới `.svc-links` trang chủ (front-page.php).
- **Routine hàng tuần** `digicom-gia-doi-tac-tuan` (thứ Hai 10h, ~/.claude/scheduled-tasks/): quét rộng
  giá + đối tác 6 nhóm, dựng master, export ẩn NCC, ĐẨY LÊN LIVE (import-wp merge), điền goi_sites khi
  NCC công bố list. Khác `booking-price-daily` (daily, chỉ cập nhật master không đẩy web).
- **goi_sites (list site trong gói)**: cơ chế render list khi field có dữ liệu (dgc_gia_goi_sites).
  Solann/NCC KHÔNG công bố list site công khai -> chờ Hiếu gửi list hoặc routine tự quét bên nào công bố.
  KHÔNG bịa tên site/DR.

## Không rõ nơi đăng -> KHÔNG đưa lên web (rule Hiếu 2026-07-16)

Dòng giá KHÔNG show được đăng báo nào, đăng ở đâu -> KHÔNG hiển thị trên site. Gồm 2 dạng:
1. **Gói/Combo/Social Entity** không có danh sách site (`goi_sites` rỗng).
2. **Dòng chung chung không có domain cụ thể**: "Guest post DR 30+", "Niche edit", "Toplist
   tỉnh / quận huyện", "1 credit", "42 site gov", "Website authority cao"...
- Ngoại lệ: booking-truyen-hinh (kênh VTV1/HTV7 là nơi đăng cụ thể dù không có dấu chấm).
- Đã draft 110 + 37 = 147 dòng CPT dgc_gia ngày 2026-07-16 (list ID: `~/backups/goi-hidden-20260716.txt`
  trên host). Nhóm dich-vu-backlink + backlink-social-entity tạm 0 dòng -> trang dịch vụ không render bảng giá.
- `export-web.py` filter `is_khong_ro_noi_dang()` - loại khỏi gia-web.csv, routine tuần không đẩy
  lại lên web. Khi NCC công bố list site (điền goi_sites) -> dòng tự xuất lại + publish lại post.
- Lưu ý so khớp: LIKE không dấu khiến "ngoisao.net" dính "%gói%" -> phải dùng LIKE BINARY "Gói%".
  "thanhnienviet" là báo thật (đã đổi title thành thanhnienviet.vn) - đừng ẩn nhầm.

## SÀN GIÁ VỐN cho chiết khấu combo (chốt 2026-07-21, huong 3)

Sự cố: chính sách combo ladder 3/5/8/12/15% (giảm trên tổng đơn) vs markup thực tế: 92% dòng
(779/846) markup chỉ 1,03 (biên ~2,9%). Combo ≥4 mục bán DƯỚI giá vốn (bậc 15 mục lỗ ~12,5% vốn).

**Toán học bất khả kháng:** combo tối đa X% không lỗ ⟺ markup ≥ 1/(1-X). Markup 1,03 → combo an
toàn tối đa chỉ **2,9%**. Muốn combo sâu hơn (vd 15%) buộc phải nâng markup (export-web.py), không
có cách nào khác.

**Hướng đã chọn (Hiếu, hướng 3): cài SÀN GIÁ VỐN từng dòng + hạ ladder về mức thật.**
1. **Sàn vốn (main.js + cpt-gia.php):** mỗi dòng có `data-mkgain` = số tiền giảm TỐI ĐA cho phép
   (= phần markup, không ăn vào vốn). Helper `dgc_line_mkgain($price,$ma_ncc)`: markup 1,20 nếu
   `ma_ncc=9`, còn lại (1/2/3 + trống) = 1,03 (mỏng nhất = sàn an toàn nhất, không bao giờ bán dưới
   vốn kể cả dòng chưa gắn mã). JS `comboDiscount()` cap mỗi dòng tại mkgain rồi cộng → hiển thị %
   THỰC TẾ (effPct = discount/subtotal), không phải % danh nghĩa của bậc.
2. **Ladder thật (option `combo_discount`):** hạ về `2|1 / 4|2 / 8|3` (tối đa ~3% = đúng mức giao
   được với markup 1,03). Bỏ bậc tới 15% (quảng cáo sai vì floor luôn cắt về ~2,9%).
3. **`promo_saving` 25tr → 11tr** (25tr dựa trên combo 15% đã sai): đơn 15 báo ~123tr, combo ~2,9%
   = ~3,6tr + 15 bài viết free ~7,5tr = ~11tr. Note cập nhật theo.

Đồng bộ markup: nếu đổi `MARKUP_CHINH`/`MARKUP` trong export-web.py thì phải sửa `dgc_line_markup()`
trong cpt-gia.php (2 nơi hardcode hằng số 1,03/1,20). Muốn combo hấp dẫn hơn → nâng markup (hướng 2),
KHÔNG nới ladder mà không nâng markup (sẽ lỗ hoặc bị floor cắt vô hình = quảng cáo sai).

## 2 CẠM BẪY MỚI của routine tuần (chốt 2026-07-27, đã dính cả 2)

### 1. `fix-dau.php` làm hỏng chữ ĐÃ CÓ DẤU nếu chuỗi lưu dạng TỔ HỢP (NFD)

Tiếng Việt có 2 cách lưu: **dựng sẵn** (`ủ` = 1 ký tự) và **tổ hợp** (`ủ` = `u` + dấu hỏi rời).
Bộ lọc "bỏ qua dòng đã có dấu" cũ CHỈ bắt ký tự dựng sẵn -> chuỗi tổ hợp lọt qua, `strtr` khớp
phần ASCII (`chu` trong `chủ`) và thay bằng `chủ`, để lại dấu mồ côi -> **`Trang chủ̉`**.
Đã hỏng vi_tri + yeu_cau của 8 post (4366..4379), phải khôi phục từ snapshot backup.

**Chốt chặn đã cài:** `fix-dau.php` bỏ qua MỌI giá trị chứa ký tự ngoài ASCII
(`preg_match('/[^\x00-\x7F]/', $v)`) - đã có dấu ở bất kỳ dạng nào thì không đụng tới.
**Bài học chung:** đừng bao giờ dùng `str_replace`/`strtr` map "không dấu -> có dấu" trên dữ liệu
hỗn hợp mà không chuẩn hoá Unicode trước; và LUÔN chạy `dry` + soi mẫu output trước khi ghi thật.

### 2. Routine HỒI SINH các dòng đã bị draft có chủ đích

Bộ lọc chất lượng 2026-07-19 đã draft 326 dòng (link chết / DR<=5) và 2026-07-20 draft 9 dòng
gov/edu. Nhưng NCC vẫn rao bán các domain đó -> vòng export -> import kế tiếp thấy "chưa có trên
web" và **tạo lại bản ghi MỚI ở trạng thái publish**, xoá sạch công dọn dẹp.

**Quy tắc bắt buộc khi sinh payload `new`:** đối chiếu với live ở trạng thái **any** (không phải
chỉ publish). Nếu đầu báo/site đó CHỈ tồn tại dưới dạng draft -> **KHÔNG tạo mới**, ghi vào báo
cáo để Hiếu duyệt tay. Tuần 2026-07-27 đã chặn 12 dòng theo quy tắc này.

### 3. Nhớ kiểm chất lượng domain MỚI trước khi publish
Domain lần đầu xuất hiện phải qua tối thiểu **DNS + HTTP** (mục "Lọc chất lượng domain" ở trên)
trước khi lên web. 2026-07-27 phát hiện `vietnamfdi.com.vn` (Fame rao 850.000) không phân giải DNS
-> đã chặn vĩnh viễn qua `DA_DUNG_BAN`.
**Đồng thời sửa lỗi `DA_DUNG_BAN`**: cũ so khớp `d.split("/")[0]` nên `dau_bao` dạng URL đầy đủ
bị cắt còn `"https:"` và lọt bộ lọc. Giờ so khớp chuỗi con trên toàn chuỗi (giống `is_gov_edu()`).

## Phân loại "Loại hình báo" (bao-lon/bao-tinh/truyen-hinh) - đừng tin nhãn NCC (chốt 2026-07-30)

Hiếu phát hiện lọc "Báo tỉnh - địa phương" chỉ ra **2 báo** (thực tế có ~85 báo tỉnh thật trong
nhóm booking-bao-pr) và `wiki.batdongsan.com.vn` (trang wiki nội dung, không phải báo) bị gắn
nhầm `bao-lon`.

**Nguyên nhân:** `gan-nganh.py` gán bao-tinh/bao-lon dựa vào nhãn `nhom` NCC cung cấp ("Bao
tinh / bao dang", "PR bao lon"...) - nhãn này quá thưa/không đồng nhất, NCC cũng tự gắn nhầm
site không phải báo vào nhãn "PR bao lon".

**Đã sửa `gan-nganh.py`:** nhận diện `bao-tinh` theo TÊN MIỀN dạng `bao<tên tỉnh>.vn` (danh
sách 63 tỉnh/thành cũ trong code, vì domain đặt tên từ trước sáp nhập địa giới) - đáng tin hơn
nhãn NCC nhiều. Có danh sách loại trừ `KHONG_PHAI_BAO` cho domain rõ ràng không phải báo dù
tên/nhãn gây hiểu nhầm (hiện có `wiki.batdongsan.com.vn`). Áp dụng 1 lần cho dữ liệu cũ (183
dòng được gán bao-tinh, 2 dòng gỡ bao-lon) + áp dụng tự động cho báo/site MỚI từ nay.

**Bài học:** đừng tin nhãn phân loại thô từ NCC khi có tín hiệu đáng tin hơn (tên miền) để tự
suy luận - đặc biệt với dữ liệu nhập từ nhiều nguồn không đồng nhất.
