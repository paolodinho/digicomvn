# Bảng giá booking / guest post / textlink - quy tắc (chốt 2026-07-14)

> Kho dữ liệu: `10-bang-gia-booking/`. Đọc `README.md` trong đó trước khi sửa.

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

## MARKUP x1,20 cho NCC ngoài DanaSEO (chốt 2026-07-15 - GHI ĐÈ phần trên)

**Giá web = giá vốn NCC × 1,20 cho MỌI nhà cung cấp TRỪ DanaSEO.** DanaSEO giữ nguyên giá
cuối (không markup). Lý do: DanaSEO là nguồn gốc giá tốt nhất, các nguồn khác cộng biên 20%.

- Markup áp ở `export-web.py` (`web_gia()`), **cấp DÒNG, TRƯỚC khi chọn min giữa các NCC**
  -> DanaSEO (không markup) và bên khác (×1,20) vẫn cạnh tranh sòng phẳng, lấy rẻ nhất. Nên
  đầu báo nào DanaSEO có bán thì giá không đổi; đầu báo chỉ có ở nguồn khác mới tăng 20%.
- **Bao trùm rule cũ "truyền hình +20%"** (TV đều là NCC ngoài DanaSEO) -> đã BỎ block markup
  TV riêng trong `cap-nhat-gia.py` để tránh nhân đôi (×1,44). Rule "Giá truyền hình +20%" ở
  trên giờ chỉ là trường hợp riêng của rule tổng này.
- **Social entity** (Solann Digital, non-DanaSEO) -> ×1,20 = đúng "120% Solann" đã chốt.
- Làm tròn nghìn. Tác động lần đầu (2026-07-15): 576/1051 dòng web tăng 20%, 0 dòng giảm.

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

## Nút menu "Bảng giá" - nổi bật nhẹ (2026-07-15)

Menu "Bảng giá" KHÔNG tô nền đặc (trước là pill xanh, tranh nổi bật với "Đặt bài ngay" + các nút
khác). Giờ: chữ màu brand + gạch chân luôn hiện (`:after right:0`), nền trong suốt - nhấn nhẹ, không
tranh chú ý. CSS `.nav>ul>li>a[href*="/bang-gia"]`.

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

## Gói không công bố đăng ở đâu -> KHÔNG đưa lên web (rule Hiếu 2026-07-16)

Dòng giá dạng **Gói/Combo/Social Entity** mà không show được đăng báo nào, đăng ở đâu
(`goi_sites` rỗng) -> KHÔNG hiển thị trên site.
- Đã draft 110 dòng CPT dgc_gia ngày 2026-07-16 (list ID backup: `~/backups/goi-hidden-20260716.txt`
  trên host). Nhóm dich-vu-backlink + backlink-social-entity tạm 0 dòng -> trang dịch vụ không render bảng giá.
- `export-web.py` có filter `is_goi_an_danh()` - gói không có goi_sites bị loại khỏi gia-web.csv,
  routine tuần không đẩy lại lên web. Khi NCC công bố list site (điền goi_sites) -> dòng tự xuất lại,
  đồng thời publish lại post tương ứng.
- Lưu ý so khớp: LIKE không dấu khiến "ngoisao.net" dính "%gói%" -> phải dùng LIKE BINARY "Gói%".
