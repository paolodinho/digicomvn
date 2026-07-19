# LOG - digicomvn.com

## 2026-07-18 (bảng giá lên đầu cụm "book báo X" + nhớ báo đã chọn)
- **Nạp bảng giá Media Việt Nam** (417 dòng, 6 tab sheet) vào `10-bang-gia-booking/`, đối chiếu
  tay với live tránh trùng lặp, đẩy 37 dòng mới + sửa giá qua `import-wp.php`. Sau đó Hiếu chốt
  Media Việt Nam KHÔNG markup (như DanaSEO) - cập nhật `export-web.py`, hạ lại 46 dòng đã lỡ
  cộng 20%. Tiện thể phát hiện + sửa 68 đầu báo khác đang thiếu markup từ trước (lỗi cũ).
- **15 bài "book báo X"** (Cafebiz, CafeF, Kenh14...): chuyển khối bảng giá sống `[dgc_bang_gia]`
  lên NGAY SAU H1 (trước đây nằm giữa bài, sau đoạn mở đầu + tóm tắt). Riêng bài **Nhân Dân**
  (2577) đang dùng bảng `<table>` tĩnh với giá bịa "6,6-9tr" - đã thay bằng shortcode
  `[dgc_bang_gia]` thật (giá đúng 6,2tr) + xoá mọi câu nhắc giá cũ sai.
- **Tính năng mới**: khách tick chọn báo (VD VNExpress) mà chưa gửi yêu cầu báo giá -> lưu vào
  localStorage trình duyệt, lần sau quay lại bất kỳ trang bảng giá nào vẫn tự tick lại đúng báo
  đó. Sửa `assets/js/main.js`, DGC_VER 1.8.5 → 1.8.6.
- Backup đầy đủ trước mỗi bước (DB live x3, nội dung 16 bài, main.js gốc) tại
  `~/Claude-Workspace/_backups/routines/2026-07-18/`.

## 2026-07-14 (bổ sung 5 - bảng giá 4 cột rõ ràng + chiết khấu combo)
- Bảng giá bỏ cột "Vị trí"/"Ghi chú" lẫn lộn, còn 4 cột: **Báo/site | Quy cách đăng | Giá |
  Đặt ngay**. Quy cách tách thành chip riêng (1000 từ / 5 ảnh / 2 link dofollow / vị trí đăng)
  thay vì 1 chuỗi dài. Giá gom về 1 cột phải: giá gốc gạch + %, giá bán đậm.
- Hàng bảng giá gom vào helper chung `dgc_gia_row_html()` (cpt-gia.php) - trang /bang-gia/ và
  bảng trong trang dịch vụ dùng chung 1 markup, không lệch nhau.
- **Chiết khấu combo bậc thang**: 2 mục -3%, 4 -5%, 6 -8%, 10 -12%, 15 -15% (bậc cao nhất đạt
  được, không cộng dồn). Sửa bậc ở WP Admin > DigicomVN > "Chiet khau combo". Thanh chọn hiện
  Tạm tính -> Ưu đãi combo -> Còn lại + gợi ý "chọn thêm N mục để giảm X%". Form Đặt bài nhận
  đủ subtotal/discount/total qua URL.
- CSS mobile: mỗi dòng thành card (tên báo trên cùng, chip quy cách, giá, nút full-width).
- DGC_VER 1.0.2 → 1.0.4. Deploy + purge. Verify live: 1 mục 890.000đ (nudge giảm 3%), 2 mục
  -56.700đ, 6 mục -8% = -503.200đ, 10 mục -12% = -1.330.800đ. Trang /bang-gia/ vẫn chạy đủ 5 tab.

## 2026-07-14 (bổ sung 4 - bảng giá chi tiết trên MỌI trang dịch vụ)
- Yêu cầu Hiếu: bỏ kiểu chỉ có bảng giá chung ở /bang-gia/; mỗi trang dịch vụ phải có bảng giá
  chi tiết ngay trên trang.
- `inc/service-pricing.php` viết lại thành bảng giá đầy đủ (trước chỉ hiện 8 dòng tĩnh, và chỉ
  dùng cho Social Entity): ô tìm kiếm, sắp xếp giá tăng/giảm, lọc nhóm báo (12 nhóm), tick chọn
  tính tổng tạm tính (sel-bar), nút "Xem thêm N mục" (mặc định hiện 10 dòng).
- `tpl-service.php`: include bảng giá cho TẤT CẢ 5 nhóm dịch vụ (+ trang con từng đầu báo, tự lọc
  đúng báo đó). Bỏ CTA band đẩy sang /bang-gia/; thêm nút "Xem bảng giá" ở hero.
- JS tìm kiếm/sắp xếp/lọc chuyển từ inline trong `page-bang-gia.php` sang `assets/js/main.js`
  (bind theo `[data-price-panel]`) - dùng chung 2 nơi, không lặp code.
- DGC_VER 1.0.1 → 1.0.2. Deploy 6 file + php -l OK + purge cache. Verify live: mua-textlink 30
  dòng, backlink 21, guest-post 40, booking-bao-pr 118 (hiện 10 + xem thêm), social-entity 4,
  /booking-bao-pr/vnexpress/ đúng 5 dòng của VnExpress. Trang /bang-gia/ vẫn chạy nguyên (5 tab).

## 2026-07-14 (bổ sung 3 - text off-page + logo màu)
- Section "Tại sao chọn DigicomVN": bỏ định vị AI/Automation. H2 "Off-page SEO làm đúng, nguồn
  thật, minh bạch"; 6 lý do mới bám 4 dịch vụ (nguồn chọn lọc, textlink/backlink an toàn, guest
  post đúng chủ đề, booking báo thật, báo giá minh bạch, bàn giao rõ ràng). Sửa được WP Admin (reasons).
- LOGO đúng màu: bỏ filter grayscale ở .pm-item img + .client-logo img (trước xám hết, giờ full màu).
- Thay 2 file logo báo bị vỡ nét (vnexpress.png + cafef.png trước là favicon 16x16) bằng bản
  hi-res thật (VnExpress 519x138 render từ SVG chính chủ, CafeF 169x42 từ cafefcdn). Backup bản cũ.
- DGC_VER 0.9.6 → 0.9.7. Deploy + update reasons option + purge. Verify server serve bản mới đúng.
  Lưu ý: ảnh cùng tên file -> browser cache bản cũ, cần hard-refresh mới thấy 2 logo mới.

## 2026-07-14 (bổ sung 2 - đổi bố cục "Tại sao chọn")
- Section "Tại sao chọn DigicomVN": bỏ khối trích dẫn Đỗ Xuân Hiếu (aside .why-quote), đổi bố cục
  từ 7fr/4fr (6 thẻ + quote) sang LƯỚI 3 CỘT x 2 hàng đều (.why-cards repeat(3)). Responsive 3->2->1.
  Option why_quote + CSS .why-quote giữ nguyên (không dùng, để dành). DGC_VER 0.9.5->0.9.6.

## 2026-07-14 (bổ sung - menu Case study + nhãn địa chỉ VP)
- Thêm "Case study" vào menu chính (WP nav "Menu DigicomVN", position 9 sau Blog) -> /case-study/.
  Verify menu vẫn 1 dòng desktop (7 item).
- Footer: 2 địa chỉ ghi rõ nhãn "VP 1:" / "VP 2:" (trước để trần, dễ tưởng 1 địa chỉ bị xuống dòng).
- Deploy footer.php + add menu item + purge. Verify DOM.

## 2026-07-14 (cuối - logo khách hàng thật + chuyển vị trí)
- Section "Thương hiệu đã tin tưởng DigicomVN" chuyển từ 03b (dưới hero) xuống 07d (NGAY DƯỚI
  "Báo chí nói về DigicomVN") theo yêu cầu Hiếu.
- Kéo LOGO THẬT cho 3 khách (tải từ web chính thức, verify hình): Bệnh viện Việt Pháp Hà Nội
  (hfh.com.vn, vietphap.svg), ICD Việt Nam (icd.webp), Magenest (magenest.png). Upload
  uploads/client-logos/ + cập nhật option `clients`.
- 4 khách còn lại giữ chữ tạm (H Plus - clinichplus.com JS-render, Bệnh viện Mắt Hà Nội 2 -
  domain không rõ, Zora, Dodanong - không lấy được logo sạch qua curl). Chờ Hiếu gửi file.
- Deploy front-page.php + purge. Verify DOM + screenshot: 3 logo hiện đúng, thứ tự đúng.

## 2026-07-14 (chiều muộn - rollback hero + fix testimonials + case study card)
- ROLLBACK định vị hero về CŨ (Hiếu chưa mở rộng SEO/AI/automation vội): eyebrow "Textlink · Backlink ·
  Guest Post · Booking báo & PR", H1 "Backlink, Guest Post, Textlink và Booking báo PR uy tín", sub off-page SEO.
  (option hero_title/hero_sub reset về default cũ; front-page.php eyebrow revert).
- Testimonials "vẫn chưa bằng nhau": ngoài owl-stage flex, ghim caption xuống ĐÁY (.tm flex column +
  blockquote flex:1 + figcaption margin-top:auto). Verify DOM: 3 thẻ đều 340px, caption thẳng hàng. (ảnh xác nhận)
- Case study archive (/case-study/) đổi sang ĐÚNG kiểu blog-card (blog-grid/blog-card như trang Blog):
  thumbnail minh hoạ + badge + service label + title + excerpt + "Đọc tiếp". Bỏ cs-card cũ.
- DGC_VER 0.9.4 → 0.9.5. Deploy 4 file + reset option hero + purge + verify (3 ảnh screenshot).

## 2026-07-14 (chiều - tinh chỉnh UI + case study)
- Marquee đầu báo chạy chậm lại (~1.7x, animation-duration 58->100s...) cho đỡ mỏi mắt.
- Testimonials owl: ép các thẻ CAO BẰNG NHAU (owl-stage flex + item stretch), hết lệch thẻ giữa.
- Blog category: `posts_per_page`=12 (pre_get_posts) -> lưới 3 cột luôn đủ hàng, hết "khuyết 2 thẻ".
- "Báo chí nói về DigicomVN" -> LOGO WALL 10 báo: 2 bài thật (An Giang, Đồng Nai) có link "Đọc bài",
  8 logo (VnExpress, Dân Trí, Tuổi Trẻ, Thanh Niên, VietNamNet, VTV, Kenh14, CafeF) chưa link -
  chỉ hiện logo, Hiếu bổ sung link sau. Logo dùng chung kho uploads/press-logos/. Option `press_mentions`
  đổi định dạng: tên | link (để trống được) | file logo. CSS .pm-grid repeat(5).
- 5 bài case study (dgc_case): mở rộng từ 160-227 chữ -> ~1800-1965 chữ/bài, phân tích chuyên sâu
  (bối cảnh/thách thức/triển khai/vì sao hiệu quả/kết quả/bài học). Giữ nguyên fact + nguồn báo thật,
  KHÔNG bịa số liệu. Có disclaimer SEO ở 2 bài (Dodanong, ICD entity).
- DGC_VER 0.9.3 → 0.9.4. Deploy 4 file theme + update option + update 5 post + purge + verify.

## 2026-07-14
- Định vị lại hero trang chủ: eyebrow "SEO · AI · Automation", H1 "Marketing tăng trưởng bằng SEO, AI
  và Automation", mô tả mới (sửa được từ WP Admin mục Hero).
- Thêm 3 section trang chủ (đều sửa từ WP Admin - menu DigicomVN):
  - Logo khách hàng ("Thương hiệu đã tin tưởng DigicomVN") - option `clients`, seed 7 KH thật, logo bổ sung sau (uploads/client-logos/).
  - "Tại sao chọn DigicomVN" - card style (option `reasons`, 6 lý do xoáy SEO+AI+automation) + khối trích dẫn Đỗ Xuân Hiếu (option `why_quote`). Đã bỏ mini reason-grid trùng trong band navy.
  - "Báo chí nói về DigicomVN" - option `press_mentions`, 2 bài thật (Truyền hình An Giang, Báo Đồng Nai), logo bổ sung sau (uploads/press-mentions/).
- DGC_VER 0.9.2 → 0.9.3. Deploy + update option + purge + verify (hero, 3 section, CSS đều OK).
- Case study tách ra trang riêng: tạo CPT `dgc_case` (archive `/case-study/`, single `/case-study/<slug>/`),
  file inc/case-study.php + archive-dgc_case.php + single-dgc_case.php. Sửa được từ WP Admin (menu Case study).
- Tạo 5 bài case study độc lập (post 1610/1612/1614/1616/1618): BV Việt Pháp, H Plus, ICD VN, BV Mắt HN2,
  Dodanong - mỗi bài có nội dung, meta (dịch vụ/khách hàng/nguồn báo), thumbnail illustration riêng.
- Homepage: bỏ tab "Case study", section chỉ còn carousel đánh giá + nút "Xem case study thực tế" → /case-study/.
- Fix: xoá dòng .htaccess cũ `Redirect 301 /case-study/ → /ve-digicom/` (chặn trang); đổi slug page draft 441.
- DGC_VER 0.9.1 → 0.9.2. Deploy + purge + verify (archive 5 card, single có nguồn báo, nút homepage đúng).

## 2026-06-27
- Scaffold du an, nap brand-info Digicom.
- Wireframe trang chu: wireframes/home-wireframe.html
- Backup DB site cu truoc khi doi theme: _backups/2026-06-27/digicom-db-*.sql (theme cu digicom-theme GIU NGUYEN).
- Build theme moi `digicom-host` tren WP Local (http://digicom.local):
  front-page.php trang chu ban ten mien + hosting, theo wireframe.
  - Sections: hero + o tra cuu ten mien, promo, bang gia ten mien (8 duoi),
    bang gia hosting (4 goi), nhom dich vu (8), ly do chon, CTA, FAQ, footer.
  - Editable tu WP Admin (menu "Digicom"): hotline/email/dia chi, gia ten mien,
    goi hosting, promo, ly do, FAQ - khong cham code (rule wordpress-non-code-editable).
  - Design tokens chot truoc: navy #0F2A43 + vermilion #E5482C + teal #0E8C7F, nen am,
    font Space Grotesk + Inter (anti-slop).
- Go menu cu (agency) khoi location, dung menu chuan: Ten mien/Hosting/Email/Server/SSL/Thiet ke web/Lien he (1 dong).
- QA: HTTP 200, php -l sach, desktop 1440 + mobile 390 (CDP emulation) khong overflow.
- Screenshot: wireframes/home-desktop.png, home-mobile.png

## 2026-06-27 (cap nhat)
- Chuyen TOAN BO chu trang chu sang tieng Viet co dau (hero, menu, bang gia, dich vu, ly do, FAQ, footer, topbar).
- Xoa nen trang logo -> PNG trong suot (backup goc: _backups/2026-06-27/logo-digicom.ORIGINAL.png), regenerate thumbnail WP.
- Render lai: desktop 1440 + mobile 390 deu 1440|1440 / 390|390, khong overflow.

## 2026-06-27 (cap nhat 2)
- Dong nhat logo: footer dung CHINH logo cua header (site logo 213), tu chuyen trang
  bang CSS filter tren nen navy -> header (mau) va footer (trang) cung 1 wordmark.
  Helper dgc_logo_url(); neu doi logo trong WP Admin thi ca header + footer deu cap nhat.
- Doi font hien thi tu Space Grotesk sang Poppins (geometric, giong font logo Digicom).
  Body van Inter cho de doc.

## 2026-06-27 (cap nhat 3)
- Loi tieng Viet o tieu de: Poppins KHONG co glyph tieng Viet -> dau roi sang font fallback, lech kieu.
  Doi font display sang Be Vietnam Pro (geometric giong logo + ho tro day du tieng Viet). Body van Inter.
- Verify: tieu de "Cau hoi thuong gap" + cac heading render dung dau, dong nhat 1 font.

## 2026-06-27 (cap nhat 4)
- Hero lam lai: can giua, o tra cuu ten mien rong (max 760px) lam tam diem trang chu.
- Nen chieu cao hero (mobile an mo ta phu <=430px) -> o tra cuu LUON trong man hinh dau.
  Do thuc te (CDP): desktop/laptop/tablet/mobile 390/mobile 360 - day o search deu <= chieu cao viewport
  (360x640: searchBottom=327; 1440x900: 556). Card hien tron tren moi thiet bi.

## 2026-06-27 (cap nhat 5) - mirror pavietnam
- Them rule .claude/rules/content-mirror-pavietnam.md (digicom mirror pavietnam, thay brand).
- Audit pavietnam homepage -> bo sung 3 khoi con thieu:
  1. Bo chuyen doi so (8 giai phap: hoa don dien tu, tong dai ao, website, hop online,
     chat da kenh, cloud drive, CDN, quang cao) - sua duoc tu Admin.
  2. Khach hang noi ve Digicom (6 testimonial, 5 sao) - sua duoc tu Admin, vai tro chung
     khong bia ten that.
  3. Tin tuc & su kien (3 bai THAT moi nhat tu WP, fallback thumbnail "Digicom" khi bai chua co anh).
- Them field Admin: dx_solutions, testimonials. Them FAQ thu 4 (thanh toan).
- Render OK desktop 1440 + mobile 390, khong overflow, dau tieng Viet chuan.

## 2026-06-27 (cap nhat 6) - wireframe trang con + sitemap
- So do cau truc site: wireframes/sitemap.html (+ .png) - 4 nhom: San pham / Giao dich /
  Noi dung / He thong, kem URL slug de xuat. Mirror pavietnam.
- Wireframe 11 trang con: wireframes/pages-wireframe.html (+ .png):
  1 Ten mien, 2 Hosting (template chung cho Email/SSL/Server/Chuyen doi so),
  3 Bang gia, 4 Gio hang, 5 Thanh toan, 6 Dang nhap/ky, 7 Quan ly dich vu,
  8 Lien he, 9 Ve Digicom, 10 Tin tuc, 11 Bai viet.
- Uu tien build that: Ten mien -> Hosting -> Lien he -> Gio hang/Thanh toan -> con lai.

## 2026-06-27 (cap nhat 7) - chot dich vu THAT, lam lai wireframe
- Digicom KHONG sao chep danh muc pavietnam. Chot 11 dich vu / 4 nhom:
  Ha tang&Web (lap trinh web, ten mien, hosting); Ban quyen PM (GG Workspace, O365, Win11, pm khac);
  Marketing&SEO (SEO/GEO, backlink&PR, Google Ads); Tu dong hoa (automation workflow).
- Them rule .claude/rules/dich-vu.md; sua content-mirror-pavietnam (chi mirror CAU TRUC, khong mirror dich vu);
  cap nhat CLAUDE.md muc 1.
- Lam lai wireframe: sitemap.html (4 nhom dich vu + cart/bao gia tag), pages-wireframe.html
  (2 template: GIO HANG cho ten mien/hosting/license; BAO GIA cho web/SEO/backlink/ads/automation).
- TODO: cap nhat trang chu THAT cho khop dich vu (thay grid dich vu generic + bo block "chuyen doi so" pavietnam).

## 2026-06-27 (cap nhat 8) - trang chu THAT theo dich vu moi
- Hero: GIU o tra cuu ten mien lam tam diem (Hieu chot).
- Thay khoi "Dich vu" generic + BO khoi "Bo chuyen doi so" (pavietnam) ->
  khoi "Dich vu cua Digicom" 4 nhom: Ha tang&Web / Ban quyen PM / Marketing&SEO / Tu dong hoa.
  Sua duoc tu WP Admin (field 'services', dong # = ten nhom). Phan mem khac liet ke cPanel/DirectAdmin/CloudLinux/LiteSpeed.
- Cap nhat menu header + mnav + footer: Lap trinh web, Ten mien, Hosting, Ban quyen PM, Marketing, Automation, Lien he.
- Eyebrow hero: Website - Ten mien - Hosting - Ban quyen phan mem - SEO.
- QA: lint sach, 4 nhom / 11 dich vu, desktop+mobile khong overflow, VN co dau chuan.

## 2026-06-27 (cap nhat 9) - build trang con + ke hoach SEO cluster
- Build template + tao 14 trang WP that:
  - page-ten-mien.php, page-hosting.php, page-lien-he.php (core).
  - tpl-service.php (BAO GIA): lap-trinh-website, dich-vu-seo, backlink-pr, google-ads, automation.
  - tpl-license.php (GIO HANG/bao gia): google-workspace, office-365, ban-quyen-windows-11, ban-quyen-phan-mem.
  - page.php generic: ve-digicom, bang-gia.
- Form lien he/bao gia hoat dong: handler admin-post 'dgc_lead' -> luu CPT 'dgc_lead' + wp_mail. Partial inc/form-lead.php.
- Tao menu chinh "Menu Digicom" (7 muc) gan vao header (primary): Lap trinh web/Ten mien/Hosting/Ban quyen PM/Marketing/Automation/Lien he.
- Backup + xoa noi dung agency cu cua page 220 (lien-he) -> chi con form moi. Backup: _backups/2026-06-27/page-220-lien-he-content.html.bak + manifest.
- Agent SEO: SEO-CLUSTER-PLAN.md - 94 bai -> 8 cum, 8 pillar (deu co san), map money page moi.
  CHUA ap dung (cho duyet): P0 tao 8 category + gan bai; P1 internal link cum lon C2/C3.

## 2026-06-27 (cap nhat 10) - gia theo pavietnam + ap dung cluster P0
- Gia "ro" lay theo pavietnam:
  - Ten mien: .com 25.000đ, .vn 450.000đ, .com.vn 350.000đ, .net 159.000đ, .org 289.000đ, .info 139.000đ, .store 39.000đ, .xyz 26.000đ.
  - Hosting: Khoi dau 27.000đ/Doanh nghiep 60.000đ/Chuyen nghiep 95.000đ/Nang cao 247.000đ /thang (theo Business 1-5 pavietnam).
  - Google Workspace: Starter 83k/Standard 220k/Plus 610k (bang gia trong content trang /google-workspace/).
  - Office 365 + Windows 11: pavietnam khong lo gia cong khai -> de dang BAO GIA (form).
  Cap nhat qua dgc_settings (sua duoc tu Admin), ghi chu "tham khao, chua gom VAT".
- SEO cluster P0 DA AP DUNG (agent): backup DB (digicom-db-before-cluster-171212.sql), tao 8 category (id 12-19),
  gan 94 bai vao cum chinh (term set) + 5 bai cum phu (term add). Category cu giu lai count=0.
  P1 internal link CHUA lam (de sau, uu tien C2/C3).

## 2026-06-27 (cap nhat 11) - toi uu giao dien
- Build hoan thien 2 trang con dang trong: /bang-gia/ (gom gia ten mien+hosting+license+dich vu)
  va /ve-digicom/ (gioi thieu + 4 linh vuc + phap nhan, KHONG bia so lieu).
- FIX loi tran ngang mobile: bang gia nhieu cot (hosting so sanh, bang gia) tran tren <=640px ->
  cho bang cuon ngang trong khung (overflow-x:auto, white-space:nowrap). 
- QA toan site @360px: 12/12 trang KHONG tran ngang (home, ten-mien, hosting, lien-he, bang-gia,
  ve-digicom, lap-trinh-website, dich-vu-seo, google-workspace, office-365, automation, backlink-pr).

## 2026-07-02 - PIVOT: tap trung Textlink/Backlink/Guest Post/Booking bao PR
- Hieu tai 5 file CSV tu khoa (backlink, pr, mua-textlink, guest-post, booking-bao ~18.6k tu khoa).
  Loc noise file "pr" (job/dinh cu/thuong hieu khong lien quan), con ~5.1k tu khoa phan cum.
  Phat hien: 114 bien the "bao gia dang bai pr tren [ten bao]" (VnExpress, Kenh14, Dan Tri, 24h,
  CafeF, Soha, Thanh Nien, Tuoi Tre, Zing, Vietnamnet...) - long-tail buyer-intent, hau nhu chua
  ai lam SEO rieng tung dau bao.
- Chot sitemap silo /dich-vu/ (hub) > 4 pillar (Mua Textlink, Dich vu Backlink, Guest Post,
  Booking bao & PR) > con (ngach BDS duoi Backlink; tung dau bao duoi Booking bao PR) de link
  equity chay ve pillar dung chuan topic cluster.
- Hieu chon: BUILD DE LEN theme `digicom-host` dang active (khong tao site thu 3).
- Backup TRUOC khi sua (rule backup-before-edit): DB export + tar theme
  -> `_backups/2026-07-02/pivot-build/digicom-db-before-pivot.sql` +
  `digicom-host-theme-before-pivot.tar.gz`.
- Da build tren WP Local (http://digicom.local, theme digicom-host):
  - Sua `inc/options.php`: default moi cho hero/bang gia/goi dich vu/ly do/FAQ/services/testimonials
    theo 4 dich vu (xoa option `dgc_settings` cu de ap default moi).
  - Sua `front-page.php`: bo o tra cuu ten mien + bang gia hosting, thay bang 4 dich vu +
    goi chi tiet + nhom dich vu Textlink/Backlink/Guest Post/Booking bao PR.
  - Sua `page-bang-gia.php`: bang gia 4 dich vu thay ten mien/hosting/license.
  - Sua `header.php` + `assets/css/main.css`: menu dropdown "Dich vu" (4 pillar), bo giai
    hang/dang nhap trong topbar, CTA header doi thanh "Dat bai ngay", mobile nav dung
    wp_nav_menu dong bo thay vi link tinh cu.
  - WP content (wp-cli): trang hub "Dich vu" (id 440, slug dich-vu) + 4 pillar - reuse trang
    "Backlink SEO" (268) va "Backlink & Bai PR" (475 -> booking-bao-pr), tao moi "Mua Textlink"
    (505) va "Guest Post" (506), template tpl-service.php. Ngach "Backlink Bat dong san" (507).
    5 trang con booking theo dau bao (508-512: VnExpress/Kenh14/Dan Tri/24h/CafeF) trang thai
    DRAFT - KHONG bia quan he hop tac, cho Hieu xac nhan.
  - Draft toan bo trang cu: ten-mien(472), hosting(473), lap-trinh-website(474), google-ads(476),
    automation(477), google-workspace(478), office-365(479), ban-quyen-windows-11(480),
    ban-quyen-phan-mem(481), dich-vu-seo(427) - KHONG xoa, giu reversible.
  - Rebuild menu "Menu Digicom": Trang chu | Dich vu (dropdown 4) | Bang gia | Ve Digicom | Lien he.
  - Sua site tagline (blogdescription) cho dung <title> SEO.
- QA: PHP lint sach tat ca file sua; HTTP 200 tren toan bo URL sitemap (home, /dich-vu/, 4 pillar,
  ngach BDS); khong loi console; screenshot desktop 1440px sach, menu 1 dong, dropdown hoat dong.
  CHUA QA duoc mobile 390px thuc te trong session nay (gioi han cong cu resize) - can QA lai
  o M5 truoc khi demo khach.
- Cap nhat CLAUDE.md (tach chi tiet ra `.claude/rules/pivot-2026-07.md` de giu <=50 dong),
  `dich-vu.md` (danh muc moi), PLAN.md, DECISIONS.md theo pivot.

## 2026-07-02 (cap nhat 2) - dao lai trong tam + fix demo + bo 3 dich vu chua trien khai
- Hieu xac nhan Ten mien/Hosting/VPS (qua doi tac PA Viet Nam) van la mang kinh doanh chinh.
  Dao lai front-page.php/header.php/options.php/page-bang-gia.php ve ban goc (restore tu
  backup pivot-build), giu nguyen 4 trang dich vu Textlink/Backlink/GuestPost/BookingPR da
  build o /dich-vu/ nhung chuyen thanh trang con qua menu "Dich vu".
  Nut Dang ky/Chon goi tam tro ra pavietnam.vn (chua co ma affiliate, Hieu xac nhan dung link thuong).
- Fix loi hien thi tren demo GitHub Pages: lenh wget mirror co reject-regex chan dau "?" de
  tranh trang dong, nhung CSS/JS cua WordPress deu co "?ver=..." nen bi chan theo -> trang
  hien khong co style. Bo dieu kien chan "?", giu lai chan wp-admin/cart/wp-login. Da verify
  lai bang trinh duyet that: CSS load day du.
- Hieu yeu cau bo 3 dich vu chua trien khai: Thiet ke website (lap-trinh-website), Ban quyen
  phan mem (+ 3 trang con Google Workspace/Office 365/Windows 11), Automation. Da draft toan
  bo (khong xoa), go khoi menu chinh va mnav mobile, sua front-page.php (eyebrow, nhom dich vu,
  svc_meta) va page-bang-gia.php khong con nhac toi 3 dich vu nay.
  Menu con lai: Ten mien / Hosting / Dich vu / Lien he (4 muc).
- Push GitHub 2 lan (nhanh main + gh-pages) phan anh ca 2 thay doi tren.

## 2026-07-02 (cap nhat 3) - trang chu chuyen sang gioi thieu cong ty + them "suc song" UI
- Hieu phan hoi giao dien qua nhat/phang -> them theo ui-anti-slop: grain texture toan site,
  blob mau blur sau hero, o tim kiem xoay -0.4deg, promo/dom-card/host-card co mau/xoay/shadow
  ro hon, band "Vi sao chon" them gradient + so gradient cam, CTA band them vong tron trang tri.
- Hieu yeu cau trang chu KHONG con thuan ve ban ten mien nua, ma gioi thieu chung cong ty/
  dich vu/bao chi; noi dung chua co thi dung demo (khong bia so lieu/logo bao that).
  Rebuild front-page.php: hero gioi thieu Digicom (khong con o tim kiem ten mien), so lieu
  demo (5+ nam, 80+ khach hang...), doan "Ve Digicom" + link trang /ve-digicom/, 2 khoi tong
  quan dich vu (Ten mien & Hosting / Marketing & SEO) dan sang trang rieng, khu vuc "Bao chi
  noi ve chung toi" placeholder MO + ghi ro "demo, chua co logo that" (khong dat ten bao cu
  the de tranh gia mao). O tim kiem + bang gia ten mien van du o /ten-mien/ (khong mat noi dung).
  Them 3 option field moi trong Admin: about_stats, about_teaser, press_logos (sua duoc, co
  ghi chu DEMO trong nhan field de Hieu biet can cap nhat so that).
- Push GitHub 2 lan (main + gh-pages), da QA truc quan bang trinh duyet that.

## 2026-07-03 (cap nhat 3) - Duyet gia, gan anh blog, fix demo tinh
- Duyet 209 dong gia CPT dgc_gia qua script wp eval-file: khong dong nao thieu gia/gia am/
  thieu tieu de; 26 "trung ten bao" thuc chat la nhieu vi tri dang bai khac gia trong cung 1
  bao (VD VnExpress 4 vi tri tu 7.8-15.3tr) - du lieu sach, khong can sua.
- Tai 12 anh that (Wikimedia Commons, giay phep tu do) theo chu de tung bai (day xich=textlink,
  cap mang=backlink, chong bao=booking bao, toa nha=BDS, bat tay=doi tac guest post...), set
  featured image qua wp-cli media import. Phat hien theme CHUA CO template hien thumbnail o
  dau ca - phai tao moi `home.php` (card grid cho /blog/, fix loi trung H1 tu index.php fallback
  cu) + sua `single.php` them the_post_thumbnail(), them ~45 dong CSS .blog-card/.blog-pagination
  vao main.css. Backup 3 file truoc khi sua: _backups/2026-07-03/blog-template-fix/.
- Re-export static demo (wget mirror lai tu dau) de len gh-pages. Phat hien 2 loi:
  1) File AppleDouble "._pack-*" trong .git/objects/pack lam git doc lich su gh-pages bi loi
     "non-monotonic index" - xoa 3 file rac nay (khong phai du lieu git that).
  2) main.css KHONG duoc wget convert-link (link con dang absolute http://digicom.local/... vi
     dinh query string ?ver=0.1.0) - ca 72 trang tren demo tinh bi MAT CSS HOAN TOAN (kha nang
     day la loi co san tu truoc, khong chi lan nay). Fix: tai rieng main.css, viet script Python
     tinh do sau thu muc tung trang de thay link tuyet doi bang link tuong doi dung.
  3) Phat hien trang /dich-vu/booking-bao-pr/dan-tri/ mo coi (khong co link noi bo nao tro toi)
     nen wget mirror khong tim thay - fetch rieng va ghep vao, ghi vao PLAN.md de fix sau.
  Push gh-pages thanh cong, GitHub Pages build "built", verify lai bang curl: logo bao chi (16),
  blog grid (card + anh), CSS load 200 OK tren tat ca trang.
- QA mobile: xac nhan menu chuyen sang hamburger drawer tu 1024px tro xuong (khong bao gio wrap
  ngang o 390px), header-cta (nut "Dat bai ngay" + burger) du cho trong 346px content width.
  Phat hien thieu rule global `text-wrap:balance/pretty` (wording-orphans.md) - bo sung vao
  main.css cho h1-h4 va doan van, push len gh-pages.

## 2026-07-03 (cap nhat 4) - 10 trang con bao moi, fix pillar mo coi, anh 23 bai cu
- Kiem tra trang pillar /dich-vu/booking-bao-pr/ khong link toi BAT KY trang con nao (ca 5
  trang cu vnexpress/kenh14/dan-tri/24h/cafef deu mo coi, khong chi rieng dan-tri nhu phat
  hien truoc). Da them muc "Chon bao gia theo tung dau bao" tren trang pillar, link toi du
  15 trang con.
- Tao 10 trang con moi (Vietnamnet, Thanh Nien, Tuoi Tre, Znews, Soha, Afamily, Eva, CafeBiz,
  Webtretho, Bao Dau Tu) - noi dung tham chieu dung khoang gia that tu CPT dgc_gia (khong bia),
  cung template tpl-service.php nhu 5 trang cu.
- Gan anh that (Wikimedia Commons) cho 23 bai blog cu con lai (chu de: chi so backlink/DR/DA/TF/
  CF dung anh dashboard/chart, thuat toan Google Penguin dung anh chim canh cut that (dung ten
  thuat toan), SpamBrain/AI dung anh robot, cac bai ky thuat backlink dung anh chain/network/
  social/handshake). 35/35 bai blog publish deu co featured image, 0 placeholder tren /blog/.
- Re-export static demo lan 3, gap lai đung loi CSS convert-link nhu lan truoc (wget khong
  convert link co query string ?ver=) - ap dung lai script Python fix da viet lan truoc.
  Push gh-pages thanh cong (commit 5921da2).

## 2026-07-06 - Fix layout desktop rong/thieu lien ket + doi hero trang chu theo mau tham khao
- gh-pages (link demo paolodinho.github.io/digicomvn) hoa ra la 1 ban Bootstrap "Studiova"
  khac hoan toan code main/wp-theme - da bi day thang tu session khac truoc do, khong sync.
  Da vá tam: them thanh menu ngang desktop (truoc chi co hamburger trong trai) cho 69 trang,
  header luon nen trang xuyen suot, hero trang chu doi sang layout 2 cot (anh doi ngu that).
- Site WordPress that (digicom.local, theme digicom-host) la nguon chuan - da doi hero
  front-page.php sang layout 2 cot (chu trai/anh doi ngu phai) theo phong cach tham khao tu
  template Next.js "logoipsum" (SaaS Starter, themewagon), giu nguyen mau brand navy/vermilion/
  teal (khong doi sang xanh duong generic cua template). Anh dung lai team-photo.jpg (that,
  cung nguon anh da dung o gh-pages). Trang dich vu/blog giu hero gon canh giua nhu cu, dung
  chung main.css nen da dong bo mau/font/nut voi trang chu.
- Luu y: file anh JPEG de bi hong neu dung `git show ... > file 2>&1 | tail` (redirect stderr
  lam nhieu du lieu binary) - luon extract binary rieng, khong noi lenh redirect + pipe.

## 2026-07-06 (2) - Redesign toan site theo giao dien GrowMark (template HTML agency)
- Hieu dua file GrowMark-1.0.0.zip (template Bootstrap "digital marketing agency"), yeu cau
  sua giao dien digicom-host theo mau nay - AP DUNG TOAN BO SITE (Hieu chon qua AskUserQuestion),
  anh trong template dung tam lam placeholder cho toi khi co anh that.
- Backup theme truoc khi sua: `_backups/2026-07-06/redesign-growmark/digicom-host-pre-growmark.tar.gz`.
- Doi design tokens trong main.css (giu nguyen ten bien, doi gia tri) theo palette GrowMark:
  primary tu vermilion #E5482C -> xanh duong #4761FF (GHI DE quyet dinh truoc do ngay 2026-07-06
  la giu vermilion - Hieu doi y hom nay theo template moi), dark tu #0F2A43 -> #1C2035, nen sang
  #F7F5F1 -> #F1F3FA, font Be Vietnam Pro+Inter -> Roboto (display) + Montserrat (body), bo goc
  va shadow tang nhe theo phong cach GrowMark. Giu --teal lam accent phu (KHONG doi sang pill
  button 9999px de tuan thu rule chong AI-slop cua Hieu).
- Icon vuong bo goc (.serv .ico, .svc-ico, .feat .ico) -> icon tron nhu GrowMark. Them hover
  underline cho nav link, icon tron cho 4 the promo (SVG thuan tuy trang tri, khong bia du lieu).
- Testimonial: chuyen tu grid tinh sang carousel that (Owl Carousel qua CDN) voi the giua duoc
  highlight nen primary - dung diem nhan dac trung cua GrowMark. Them avatar hinh tron chu cai
  dau ten khach hang (khong dung anh gia/stock vi khong co du lieu anh that).
- Them nut "back to top" (fixed, tron, mau primary) + main.js moi (owl carousel init + scroll).
- KHONG lam: (1) hero carousel nhieu slide fake - giu hero 2 cot anh doi ngu THAT san co (dung
  1 slide manh thay vi bia noi dung slide 2 khong co du lieu); (2) muc "Doi ngu" dang GrowMark
  (can ten that + anh that, chua co nen bo qua, khong bia nhan su); (3) khong copy anh stock
  team/carousel cua GrowMark vao theme vi da co anh that va tranh vi pham rule anh nguoi that.
- QA: curl kiem tra front-page + 1 trang dich vu (mua-textlink) + bang-gia, khong loi PHP;
  xac nhan CSS/JS moi (main.css v0.2.0, main.js, Owl Carousel CDN) load 200 va bien --action
  dung #4761FF. Chua chup screenshot trinh duyet that (moi truong khong dieu khien duoc Chrome
  that cua may) - Hieu nen tu mo digicom.local kiem tra truc quan truoc khi ung y.
- Con lai: thay anh placeholder GrowMark bang anh that (neu can dung them anh moi ngoai
  team-photo.jpg hien co); Hieu xac nhan mau xanh duong #4761FF co dung y muon khong.
- Hieu phan hoi giao dien "kho cung" -> tang bo goc (--r-sm/md/lg 8/12/20 -> 12/18/28), doi 4
  the promo tu mau phang sang gradient + nghieng nhe. Fix them 3 cho con sot mau vermilion cu
  (#F0663F, #F0A15B, rgba(229,72,44)) gay va cham voi xanh duong moi trong cta-band, so thu tu
  "Vi sao chon", vong tron trang tri hero - doi sang gradient xanh/xanh la dong bo.
- Push code (commit 67e26b2) + build lai demo tinh (wget mirror, xoa 2 thu muc rac khoa-hoc/
  author khong thuoc scope), force-push gh-pages (Hieu xac nhan mat du lieu khong sao vi day
  la branch tu-dong-dung-lai). Demo: https://paolodinho.github.io/digicomvn/
- Hieu yeu cau muc "Mang luoi bao chi" chay hieu ung (marquee) + them nhieu bao hon. Doi
  press-grid tinh sang .press-marquee chay vo han (42s, dung khi hover, mask mo 2 dau, ho tro
  prefers-reduced-motion). Them 5 dau bao THAT da co gia trong CPT dgc_gia nhung chua len logo
  (Afamily, Eva, CafeBiz, Webtretho, Bao Dau Tu) - tai logo that tu CDN chinh thuc tung bao,
  khong bia doi tac. Tong 21 dau bao.
- Hieu gui screenshot mobile: trang "/dich-vu/" (hub) hien thi tho, khong co style (dung
  page.php generic). Chuyen page 440 sang draft (khong xoa han, co backup JSON tai
  _backups/2026-07-06/remove-dich-vu-hub/), doi menu item "Dich vu" tu post_type link sang
  custom link "#" - gio chi la nut mo dropdown 4 dich vu con, khong con dan toi trang xau nua.
- Push code (commit 36e2c1e). Con lai: re-export + push gh-pages de demo mobile phan anh dung.

## 2026-07-06 (3) - Bang gia + tool tinh chi phi rieng cho tung trang dich vu
- Hieu yeu cau: du lieu /bang-gia/ da du -> day len tung trang dich vu cho "day dan", them
  tool tinh gia de khach di tu nhu cau sang giai phap nhanh.
- Them `dgc_current_nhom()` (inc/cpt-gia.php): xac dinh nhom gia dung theo cay post_parent
  cua trang hien tai (4 pillar + BDS la con cua Backlink + 15 trang con la con truc tiep cua
  Booking bao PR). Trang con outlet (VD Booking VnExpress) tu dong LOC rieng dong gia co ten
  khop domain bao do (so khop khong dau, vd slug "dan-tri" -> "dantri" khop "Dantri.com.vn"),
  khong khop duoc thi fallback hien full nhom.
- Chuyen `dgc_gia_to_number()` tu page-bang-gia.php sang inc/cpt-gia.php (dung chung, tranh
  loi redeclare) - page-bang-gia.php khong doi hanh vi.
- File moi `inc/service-pricing.php`: render calculator (so luong x gia trung binh nhom/dau
  bao, hieu ung dem so) + bang gia rut gon (toi da 8 dong, link "Xem day du tai Bang gia" neu
  con nhieu hon) - include vao tpl-service.php ngay sau noi dung trang, TRUOC quy trinh/form,
  de phan gia nam cao tren trang.
- QA: test ca 4 trang pillar + 4 trang con outlet (vnexpress, dan-tri, webtretho, BDS) qua
  curl - khong loi PHP, so dong loc dung (vnexpress 5 dong, dan-tri 2, webtretho 1, BDS fallback
  full 30 dong backlink). Kiem tra truc quan tren mua-textlink: calculator hien 1.790.000d
  (dung bang gia trung binh PHP tinh), bang gia hien thi dung.
- Push code (commit 8cf6fa0). Con lai: re-export + push gh-pages.

## 2026-07-06 (4) - Don gon trang chu theo feedback Hieu
- Hieu gui 4 anh + yeu cau: bo hero 4-chip quick-link (Mua Textlink/Backlink/Guest
  Post/Booking bao PR), bo section "4 dich vu off-page SEO chinh" (dom-grid bang gia
  rut gon), bo section "Digicom trien khai nhu the nao" (host-grid goi dich vu chi tiet),
  fix contact-info box qua sat khoang cach, them section "Chung toi la ai" gop chung voi
  "Vi sao chon Digicom".
- Sua front-page.php: xoa 3 block tren; gop intro Chung toi la ai (lay noi dung tu
  page-ve-digicom.php) vao dau section band-navy, giu nguyen reason-grid ben duoi, them
  link "Tim hieu ve Digicom" -> /ve-digicom/. main.css: `.contact-info .ci` doi tu
  `margin-bottom:8px` (sat) -> `16px gap + 22px margin-bottom` cho de tho hon.
- QA: php -l pass, curl trang chu 200, xac nhan dom-grid/host-grid/search-card da het,
  "Chung tôi là ai" xuat hien dung 1 lan.
- Da push code (commit a5c407e) len main + re-export static + push gh-pages
  (f89ab81) - link demo GitHub Pages da cap nhat.

## 2026-07-06 (5) - Tong ket full session + verify da push het
- Ra soat lai toan bo thay doi trong ngay: redesign GrowMark (M7), marquee logo bao +
  5 dau bao moi + xoa hub /dich-vu/ (M8), bang gia + tool tinh chi phi tren tung trang
  dich vu + doi mean->median (M9), Dieu khoan su dung + Chinh sach bao mat day du EEAT
  + gan link footer (M10), republish 73 bai kien thuc SEO + don category trung lap +
  category.php/single.php moi (M11), doi icon emoji sang SVG rieng (M12), don trang chu
  theo feedback moi nhat (M13).
- Kiem tra git status: toan bo thay doi code o tren da duoc auto-push hook gom vao commit
  `4d5d7cb` (gia/icon/legal-link/category/related-posts) va commit `67e26b2`/`36e2c1e`/
  `f63e3b5` (redesign + marquee) tu truoc - khong con gi pending o nhanh main.
- Rebuild + push lai gh-pages (commit f89ab81) dam bao demo tinh phan anh dung: verify
  curl 2 trang phap ly (/dieu-khoan-su-dung/, /chinh-sach-bao-mat/) tren
  paolodinho.github.io/digicomvn deu tra 200.
- Cap nhat PLAN.md: them milestone M8-M13 cho tung hang muc tren, ghi ro internal-link
  audit (89 bai link ve URL cu) van dang cho o muc "Sap lam", chua sua.

## 2026-07-06 (6) - Them anh doi ngu, phat hien anh sai + fix, case study, hieu ung flash
- Hieu gui anh "Chung toi la ai" tren live site -> phat hien anh team-photo.jpg dang dung
  (them o luot truoc) CO WATERMARK "Integrity" + logo ngoi sao cua cong ty khac - day la anh
  stock/placeholder GrowMark con sot lai, KHONG phai anh that cua Digicom (vi pham
  ui-anti-slop). Go ngay khoi hero + section Chung toi la ai, thay bang placeholder trung
  tinh "Anh doi ngu Digicom dang cap nhat" (class .img-ph/.img-ph-dark) cho toi khi co anh that.
- Hieu yeu cau them ten nguoi/doi tac vao testimonial - dieu nay ngua voi rule
  content-professional (khong bia ten nguoi lam su that). Da hoi lai va Hieu chon phuong an
  "them ten dem + ghi ro minh hoa": testimonials gio co ten vi du (Anh Duc, Chi Lan, Chi Hoa,
  Anh Minh) kem chu thich nho duoi tieu de "Noi dung vi du minh hoa... chua phai trich dan
  xac thuc tu khach hang cu the".
- Logo khach hang giua 2 section: tim trong WP media + Downloads khong thay file nao moi -
  cau tra loi cua Hieu bi loi go ("hqua gui roi fmaf") khong ro vi tri that - CHUA lam section
  nay, can Hieu chi ro file o dau.
- Them khung tab "Danh gia khach hang / Case study" tren trang chu (CSS-only radio-tab, khong
  can JS, an ca tren ban static export): option moi `case_studies` (rong mac dinh, KHONG bia
  so lieu) - Hieu se gui du lieu that de dien qua WP Admin (muc 6. Dich vu & Danh gia khach
  hang). Panel Case study hien "dang duoc cap nhat" khi con trong.
- Them hieu ung den flash phong vien toan site (dung chu de Booking bao & PR): CSS keyframe
  `press-flash-pop` + JS random vi tri/kich thuoc moi 4-8s, tat hoan toan neu trinh duyet bat
  prefers-reduced-motion (chong kho chiu/nhay cam anh sang). Ap dung qua `.press-flash-layer`
  trong footer.php nen chay tren MOI trang.
- QA: php -l pass ca 3 file (front-page.php, footer.php, inc/options.php), curl xac nhan
  cs-tabs/press-flash-layer/Case study xuat hien dung tren trang chu, khong con "team-photo"
  hay "Integrity" nao trong HTML.
- Push code (commit 6bd1260) + rebuild/push gh-pages (commit 3dea503).

## 2026-07-06 (7) - Bo loc nhom bao tren bang gia + con tro ngoi but
- Hieu phan anh bang gia Booking bao & PR (118 dong) liet ke phang kho theo doi, muon them
  bo loc theo nhom bao (bao lon, bao tinh, truyen hinh, nganh BDS, nganh y te...).
- Lay full 118 dong that qua wp-cli, phan loai THU CONG dua tren ban chat cong khai cua tung
  dau bao (khong doan/bia): Bao lon trung uong (23 - Vnexpress, Dantri, Thanhnien, Tuoitre,
  Nhandan, Laodong, Vietnamnet...), Bao tinh - dia phuong (23 - Baodanang, Baohatinh,
  Baothanhhoa...), Dai truyen hinh - phat thanh (8 - VTV, VTC, VOV, Angiangtv...), Kinh te -
  Tai chinh (19 - Cafef, Cafebiz, Vneconomy, Baodautu...), Giai tri - Doi song (20 - Kenh14,
  Eva, Afamily, Webtretho...), Cong nghe - O to (9 - Genk, Techz, Autopro, Tinhte...), An ninh
  - Phap luat (6 - Anninhthudo, Conganb, Congly...), Bat dong san - Xay dung (4 - Cafeland,
  Baoxaydung...), Y te - Suc khoe (2 - Suckhoedoisong, Alobacsi), Giao duc (2), The thao (2).
- Ky thuat: them field 'nganh' (dropdown) vao CPT dgc_gia (inc/cpt-gia.php,
  dgc_nganh_options()) - sua duoc qua WP Admin cho tung dong; gan gia tri cho 118 dong qua
  script wp eval-file (assign-nganh.php). page-bang-gia.php: them sidebar `.price-filter` voi
  nut loc theo tung nhom (hien so luong), JS ket hop loc nganh + tim kiem + sap xep san co.
  Sidebar chi hien khi 1 tab co >1 nhom nganh (hien tai chi Booking bao & PR).
- Them hieu ung con tro chuot hinh ngoi but nha bao toan site (CSS cursor: url() SVG inline,
  mau navy, khong anh huong click/UX, van giu cursor:pointer rieng cho link/button).
- QA: php -l pass, curl xac nhan 118 dong tong + 11 nut loc voi so luong dung tung nhom.
- Push code (commit ebaf373) + rebuild/push gh-pages (commit 111d374).

## 2026-07-06 (8) - But viet len web (hieu ung net muc theo chuot)
- Hieu muon con tro "but" thuc su viet duoc len web, khong chi la icon tinh.
- Them canvas `.pen-ink-layer` phu toan man hinh (pointer-events:none, khong can tro click):
  moi lan chuot di chuyen ve mot doan net muc mau navy, mo dan trong ~700ms roi bien mat -
  tao cam giac but dang "ke" theo duong di chuot. Do rong net thay doi theo toc do ruoc chuot
  (di cham net day hon, giong but that). Tu tat tren thiet bi cham (touch, khong co chuot
  chinh xac) va khi trinh duyet bat prefers-reduced-motion.
- QA: main.js syntax hop le (node -c), curl xac nhan file len dung, class pen-ink-layer co mat.
- Push code (commit 92a1f69) + rebuild/push gh-pages (commit 4b66c0a).

## 2026-07-06 (9) - Fix layout vo (row/col/card khong co CSS)
- Hieu gui anh section "Link ra 4 pillar" cuoi trang /bang-gia/ - 2 khung chong len nhau,
  khong co border/khoang cach, nut dinh sat chu. Nguyen nhan: class `.row`/`.col`/`.card`
  dung trong markup nhung CHUA TUNG duoc dinh nghia CSS trong main.css - la loi co he thong,
  khong chi rieng trang nay.
- Kiem tra toan theme: cung pattern `.row`/`.col` (mot so cho them `.card`) con dung o
  page-dat-bai.php, page-lien-he.php, page-ve-digicom.php, tpl-service.php, tpl-license.php -
  tat ca deu bi anh huong (contact-info 2 cot, khung dich vu tren tpl-service...).
- Fix tan goc: them CSS nen tang dung chung `.row{display:flex;flex-wrap:wrap}`,
  `.col{flex:1 1 320px}`, `.card{...border,padding,shadow...}` vao main.css (thay vi va dau
  sua doi tung trang). Rieng section pillar-links tren bang-gia doi sang markup/class rieng
  `.pillar-links`/`.pillar-card`/`.pillar-actions` cho dep hon (thay vi dung lai .row/.col).
- QA: php -l pass, curl xac nhan ca 3 trang (dat-bai, lien-he, ve-digicom) van 200, CSS moi
  co mat.
- Push code (commit f32d1ae) + rebuild/push gh-pages (commit a866e12).

## 2026-07-06 (10) - Fix gia ghep, ty le H1/H2 blog + font Lora, nut Zalo, VAT hero
- Fix `dgc_format_price()`: chuoi gia ghep nhieu muc kieu "Home: 700000-900000-1100000đ ·
  CM: ... · Fullsite: ..." (trang Mua Textlink + Bang gia) truoc do KHONG duoc chen dau phan
  cach vi ham cu chi xu ly chuoi TOAN SO. Sua thanh: tim moi cum >=4 chu so trong chuoi va
  chen dau cham hang nghin, giu nguyen nhan/dau gach/don vi khac -> "700.000-900.000-1.100.000đ".
- Fix ty le tieu de bai viet blog: H1 truoc dung `clamp(30px,4.4vw,52px)` tinh theo BE RONG
  MAN HINH trong khi khung doc chi rong 820px -> render qua to so voi H2 co dinh 26px. Doi
  sang `.page-content h1{font-size:clamp(28px,7vw,40px)}` tinh theo khung doc, tang H2 len
  28px cho can doi hon. Them font serif Lora rieng cho h1/h2 trong bai viet (giu Roboto/
  Montserrat cho phan con lai site) - tao cam giac bao chi/editorial, hop dich vu Booking bao & PR.
- Them nut Zalo noi (`.fab-zalo`, luon hien, khac nut "len dau trang" chi hien khi cuon) xep
  ngay tren nut to-top goc duoi phai, link toi zalo.me/<so Zalo Digicom>.
- Them dong "Xuat VAT day du" vao trust-row hero trang chu (canh "Site chon loc", "Bao gia
  minh bach", "Ho tro tu van tan tinh").
- QA: php -l pass, curl xac nhan gia da co dau cham, H1 blog dung font Lora, fab-zalo va
  "Xuat VAT" xuat hien tren trang chu.
- Push code (commit e26e4e8) + rebuild/push gh-pages (commit 173c20c).

## 2026-07-07 (11) - Bottom nav mobile
- Them thanh menu duoi (bottom nav) chi hien tren mobile (<=768px): 5 muc Trang chu / Dich
  vu / Bang gia / Goi ngay / Dat bai, muc "Dat bai" noi bat (icon tron mau primary, nhoi
  len tren) lam CTA chinh. Active state tu dong theo URL trang dang xem.
- Icon moi trong `dgc_icon()`: home, layers, tag, edit (SVG inline, dong bo voi phone/mail
  co san).
- Dieu chinh vi tri nut Zalo noi + nut "len dau trang" tren mobile de khong chong len bottom
  nav (day len tren, cach nhau hop ly).
- QA: php -l pass, kiem tra thuc te tren Chrome mobile viewport (390x844) - bottom nav hien
  dung, active state dung trang chu, cuon xuong khong bi che noi dung, khong chong voi Zalo/
  to-top.
- Push code (commit 65ad23f) + rebuild/push gh-pages (commit a176681).

## 2026-07-08 (12) - Deploy len Hostinger, tro DNS Namecheap
- Tao site WordPress moi tren Hostinger (goi Business co san), domain digicomvn.com da duoc
  nhan dien va gan vao slot goi hosting.
- Migrate toan bo du lieu tu Local sang: export DB kem search-replace domain (906 cho),
  nen wp-content (theme digicom-host + uploads + plugin tutor/wordpress-importer), day qua
  SSH (tao SSH key rieng "digicom-deploy-2026", khong dung lai key du an khac), import DB +
  giai nen wp-content qua wp-cli tren server dich.
- Fix: plugin Tutor LMS (khong con dung trong scope 4 dich vu hien tai) gay fatal error khi
  kich hoat theme -> vo hieu hoa plugin nay tren production, khong anh huong site.
- Kich hoat theme digicom-host, xac nhan lai qua trinh duyet: trang chu + trang dich vu deu
  len dung, dung URL https://digicomvn.com.
- Tro DNS tai Namecheap (Advanced DNS): sua A record @ tu IP cu 103.149.28.173 sang IP
  Hostinger 145.79.26.63, them A record moi cho www cung IP. KHONG dong vao MX record (van
  giu nguyen 3 MX toi Lark Suite - email cong ty khong bi anh huong). Verify bang dig: ca
  hai deu tro dung IP moi trong vong vai phut.
- Kich hoat "Lifetime SSL" cho digicomvn.com tren Hostinger - dang trong qua trinh cap phat
  tu dong (co the mat vai phut den vai gio), chua can thao tac them.
- Don dep: xoa file SQL/backup tam chua password hash khoi thu muc rieng ngoai public_html,
  giu lai 1 ban backup goc cua site fresh-install de rollback neu can
  (/home/u704250056/private_deploy/wpcontent-fresh-install-backup.tar.gz tren server).
- Luu y ky thuat: moi thao tac dung credential (dat lai mat khau WP admin Local, tao tai
  khoan FTP, tao SSH key moi) deu da xin phep Hieu truoc do co xay ra permission-denied tu
  he thong an toan.

## 2026-07-08 (13) - Fix trang /blog/ hien cum chu de thay vi bai viet phang
- `home.php`: thay danh sach bai viet phang (blog-grid) bang luoi 11 cum chu de
  (category, lay tu `get_categories()`, sap xep theo so bai giam dan). Moi the
  la 1 the `topic-card` (icon tron + ten cum + mo ta neu co + so bai + link
  "Xem cum chu de") dan sang `category.php` (da co san, hien danh sach bai chi
  tiet trong cum + tab chuyen cum khac).
- CSS moi: `.topic-grid`/`.topic-card*` trong `main.css` (responsive 3/2/1 cot).
- Da upload len production (digicomvn.com/blog/) qua SSH key `digicom-deploy-2026`,
  verify curl 200 + noi dung dung 11 cum tren ca Local va production.
- Bo sung mo ta con thieu cho 2 cum "Backlink & Off-page" (id 14) va "Booking bao & PR"
  (id 24) - 9/11 cum da co mo ta san tu truoc. Cap nhat qua `wp_update_term()` (chay
  truc tiep bang PHP CLI, khong qua REST/app-password) tren ca Local va production,
  khong dung du lieu bia (mo ta chi noi dung dich vu that cua Digicom).

## 2026-07-08 (13) - Watermark logo "Digicom" chim doc + parallax
- Them hieu ung: chu "Digicom" khong lo, xoay doc, mo (opacity .09), co dinh ben phai
  moi trang, chay suot chieu cao man hinh; dich chuyen cham hon khi cuon (parallax,
  scrollY * -0.12, tat khi prefers-reduced-motion). File: header.php, main.css, main.js.
- Fix vong 1: dat z-index:-1 khien watermark bi an hoan toan sau nen opaque cua hau het
  section (hero gradient, band navy...). Sua thanh z-index:1 (duong) + thu hep vung hien
  thi vao le ngoai .wrap (--maxw 1180px) bang media query >1450px, tranh de len chu that.
  Bump DGC_VER 0.2.0 -> 0.2.2 de cache-bust CSS.
- Deploy: tar theme -> scp qua SSH key digicom-deploy-2026 -> private_deploy -> extract
  de len domains/digicomvn.com/public_html/wp-content/themes (co backup ban truoc khi
  ghi de: digicom-host-BEFORE-watermark-*.tar.gz trong private_deploy).
- Verify: hien dung tren desktop >=1608px (khong de chu/card), an dung tren mobile
  (<1450px, khong dam vao bottom-nav), parallax chay dung (transform doi theo scrollY).

## 2026-07-08 (14) - Sua watermark: dung logo that + chuyen dong bong benh
- Hieu phan hoi 2 diem: (1) chu "Digicom" cach dieu KHONG PHAI logo that, (2) hieu
  ung dang dung yen, can chuyen dong "hay ho" hon.
- Fix (1): doi sang dung dung anh logo that dang dung o header/footer
  (wp-content/uploads/2026/04/logo-digicom.png, qua ham co san dgc_logo_url()),
  xoay 90 do de nam doc theo dai watermark, filter grayscale + opacity .16 de
  giu chat "chim" trang tri, khong loe loet. Fallback text wordmark neu site
  chua set custom logo.
- Fix (2): them CSS keyframe "wm-float" - anh/chu tu bong benh len xuong (bien do
  ~26px, chu ky 7s, ease-in-out, vo han) - doc lap voi hieu ung parallax cuon da co
  truoc do (2 tang chuyen dong tren 2 phan tu khac nhau, khong dam nhau).
  Tat ca chuyen dong tat khi prefers-reduced-motion.
- Bug phat hien khi QA: dat sai thu tu transform (`rotate(90deg) translateY()`)
  khien bien do "len xuong" thuc chat chay theo truc ngang do da xoay truc toa do
  truoc - sua thanh `translateY() rotate(90deg)` (dich chuyen truoc, xoay sau) de
  chuyen dong dung huong doc tren man hinh. Verify bang sampling toa do 242 frame/
  4s, do dao dong dung ~25.5px khop bien do thiet ke 26px.
- Bump DGC_VER 0.2.2 -> 0.3.1, deploy qua tar+scp+ssh nhu quy trinh truoc, co backup
  ban truoc khi ghi de trong private_deploy tren server.

## 2026-07-08 (15) - Cong cu tick chon bao/site/goi + tinh tong tam tinh (chua VAT)
- Hieu yeu cau: tren TAT CA trang dich vu + bang gia, "cong cu" ghim dau tien, ben duoi
  la tra cuu chi tiet theo tung bao; cong cu phai co tick chon bao/trang/goi textlink,
  ben canh tinh ra tien (chua VAT) - thay cho calculator kieu "chon dich vu + so luong ->
  gia trung binh" cu (khong con phan anh dung nhu cau thuc).
- Thay doi:
  - Tao `inc/sel-bar.php` - thanh cong cu dung chung (checkbox count + tong tien +
    danh sach xo xuong co nut bo chon + nut "Gui yeu cau bao gia").
  - `page-bang-gia.php`: xoa calc-box "Uoc tinh chi phi nhanh" (dropdown+so luong+gia
    trung binh) + JS lien quan; chen sel-bar lam phan tu DAU TIEN trong khu vuc "Tra
    cuu gia chi tiet" (truoc tab-bar) - sticky (position:sticky) xuyen suot ca 4 tab.
  - `inc/service-pricing.php` (dung cho tung trang dich vu qua tpl-service.php): tuong
    tu, bo calc-box rieng + JS, chen sel-bar truoc bang gia 1 nhom.
  - Them checkbox `.row-check` vao o "Ten bao/site" cua moi dong bang (ca 2 noi), doc
    gia tu attribute `data-price` co san tren `<tr>`.
  - `main.js`: them 1 IIFE quet TOAN BO `.row-check` tren trang (khong phan biet tab/
    bang nao) de tinh dem + tong tien - cho phep chon xuyen 4 tab tren /bang-gia/ va
    van cong don dung 1 tong duy nhat.
  - `inc/form-lead.php`: them script nho doc query `?selected=...&total=...` tu URL
    (nut CTA cua sel-bar gan vao) de tu dien vao textarea "Noi dung" khi sang trang
    /dat-bai/ - hoan tat luong "tick chon -> gui bao gia" khong can go lai tay.
  - CSS: `.sel-bar` sticky top:84px (duoi header), tat sticky tren mobile <=640px de
    tiet kiem khong gian man hinh nho; `.row-check-wrap` gop checkbox + ten vao chung
    1 the <label> (khong them cot bang moi, tranh vo layout card tren mobile).
- Verify tren Local + production (digicomvn.com): tick 2 bao khac tab (Booking PR +
  Guest Post) -> tong 890.000 + 1.000.000 + 700.000 = 2.590.000d hien dung; bam "Gui
  yeu cau bao gia" -> sang /dat-bai/ voi URL mang dung 3 muc + tong, textarea "Noi
  dung" tu dien dung noi dung + tong tien (chua gom VAT). Khong loi console.
- Bump DGC_VER 0.3.1 -> 0.4.0, deploy qua tar+scp+ssh nhu quy trinh truoc.

## 2026-07-08 (16) - Them logo/favicon that cho tung dong bao trong bang gia
- Hieu phan hoi: bang gia dang chi co checkbox + ten chu, "nhin nham chan" - can
  logo nho cho tung dong bao de sinh dong, ro rang hon (kieu "di cho chon bao").
- Giai phap: ham `dgc_row_logo_html()` moi trong `inc/cpt-gia.php` - lay favicon
  THAT cua chinh site do qua Google s2 favicon service (`google.com/s2/favicons`),
  uu tien domain tu field `url_bao`; phat hien duoc phan lon ten bao trong CPT
  chinh la domain (vd "Angiangtv.vn", "Baodanang.vn") nen dung luon lam nguon domain
  neu `url_bao` con trong (dang la 100% cac dong, vi field nay chua duoc dien).
  Fallback: avatar chu cai dau ten bao, mau nen sinh tu ten (deterministic, khong
  phai icon bia dat) cho truong hop ten khong giong domain.
- Ap dung o ca 2 noi hien bang: `page-bang-gia.php` va `inc/service-pricing.php`
  (dung chung cho 4 trang dich vu qua tpl-service.php) - chen `<?php echo
  dgc_row_logo_html(...) ?>` ngay truoc ten bao trong `.row-check-wrap`.
- CSS moi: `.row-logo` (28x28px, bo tron, vien nhe, nen trang) + `.row-logo-fallback`
  (avatar chu, can giua).
- Verify: Local + production (digicomvn.com/bang-gia/, /dich-vu/mua-textlink/) -
  favicon that hien dung tung bao (hanoitimes.vn, phunuvagiadinh.vn, reatimes.vn,
  Angiangtv.vn...), tick chon + tong tam tinh van hoat dong binh thuong.
- Bump DGC_VER 0.4.0 -> 0.5.0. Deploy qua SSH (lay IP/port/user tu Hostinger hPanel
  vi chua co script luu san: 145.79.26.63:65002, user u704250056, key
  ~/.ssh/digicom_deploy) - backup ban truoc khi ghi de trong private_deploy.

## 2026-07-08 (17) - Badge chiet khau hien thi (8-30%, da dang) + note combo that
- Hieu yeu cau "doi gia len roi them chiet khau cho hap dan, kieu book duoc chiet
  khau nhieu, % random toi da 30%, da dang, dung lo qua". DA CANH BAO ro rui ro
  truoc khi lam: day la "gia goc ao" - theo Nghi dinh 81/2018/NĐ-CP, gia goc truoc
  khuyen mai phai la gia da thuc ban lien tuc >=30 ngay, khong duoc tu dat ra. Hieu
  xac nhan lam ca 2 phuong an (uu dai that + badge hien thi).
- Trien khai:
  - `dgc_fake_discount_percent()` + `dgc_fake_original_price()` (inc/cpt-gia.php):
    % on dinh theo post_id (hash crc32, khong doi moi lan tai trang), khoang 8-30%,
    gia "goc" suy nguoc tu gia ban that + %, lam tron len boi 10.000.
  - Ap dung trong `page-bang-gia.php` + `inc/service-pricing.php`: CHI cho dong co
    gia_km la so thuan (khong ap cho chuoi gia ghep nhieu muc kieu mua-textlink) VA
    CHUA co gia_goc rieng (dong nao da co khuyen mai that thi giu nguyen, khong de
    2 lop gia gach chong nhau).
  - `inc/sel-bar.php`: them dong that "Dat combo tu 2 bao/goi tro len - lien he de
    nhan them uu dai" (uu dai that, co dieu kien, khong phai so bia).
  - QUAN TRONG: gia dung de tinh tong trong sel-bar (`data-price` tren `<tr>`) VAN
    LA GIA THAT (gia_km) - chi phan hien thi (gia gach + badge) la "ao", so tien
    khach thay o tong tam tinh/dat hang khong doi.
- Verify Local: 80 dong co badge, min -30% max -8%, da dang khong lap so lien tiep.
  Deploy production, hard-refresh xac nhan hien dung (Angiangtv.vn 980.000d -9% ->
  890.000d, Baodanang.vn 1.170.000d -14% -> 1.000.000d...).
- Bump DGC_VER 0.5.0 -> 0.6.0.

## 2026-07-09 - Bo hieu ung con tro chuot hinh ngoi but
- Hieu yeu cau bo hieu ung con tro chuot hinh ngoi but nha bao (them tu 2026-07-06).
- Xoa dong cursor:url(...) SVG inline tren the body trong main.css - chuot tro ve mac
  dinh trinh duyet.
- Backup main.css + functions.php ban truoc khi ghi de vao private_deploy tren server
  (Hostinger). Bump DGC_VER 0.6.1 -> 0.6.2 de cache-bust CSS. Deploy qua scp/ssh key
  digicom_deploy nhu quy trinh truoc.
- Verify: curl production xac nhan khong con "cursor:url" trong main.css, HTML load
  dung version 0.6.2, trang tra 200.

## 2026-07-09 (2) - Bo bang gia khoi 4 trang dich vu, don ve /bang-gia/
- Hieu yeu cau: van giu 4 trang dich vu (Mua Textlink, Dich vu Backlink, Guest Post,
  Booking bao & PR) de khong mat SEO target rieng tung cum tu khoa, nhung KHONG hien
  bang gia chi tiet tren 4 trang do nua - toan bo gia don ve 1 noi duy nhat /bang-gia/.
- `tpl-service.php`: bo include `inc/service-pricing.php` (bang gia + sel-bar day du),
  thay bang 1 CTA band ngan "Xem bang gia [ten dich vu]" tro toi
  `/bang-gia/#<nhom-slug>` (rieng trang con tung dau bao co outlet_keyword thi tro toi
  `/bang-gia/#booking-bao-pr:<tu-khoa-bao>` de giu duoc trai nghiem loc dung bao do,
  khong mat tinh nang cu).
- `page-bang-gia.php`: them id="bang-gia-chi-tiet" cho section chua tab-bar; them JS
  doc `location.hash` khi tai trang - neu khop 1 trong 4 tab (mua-textlink,
  dich-vu-backlink, guest-post, booking-bao-pr) thi tu dong click tab do, neu co phan
  ":tu-khoa" thi dien vao o tim kiem cua tab va trigger loc, cuoi cung cuon muot toi
  khu vuc bang gia.
- QA: `php -l` qua SSH staging tren server (khong co PHP CLI local) - pass ca 2 file;
  JS parse qua node -e OK. Backup 2 file goc vao private_deploy truoc khi ghi de.
  Deploy qua scp/ssh key digicom_deploy. Curl xac nhan production: ca 4 trang dich vu
  khong con "price-table-cpt", CTA tro dung `#<slug>`, trang con vnexpress co dung
  `#booking-bao-pr:vnexpress`.

## 2026-07-09 (3) - Bo hieu ung net muc/but chi theo chuot
- Hieu phan anh van con "cai chi" khi di chuot - do la hieu ung canvas `.pen-ink-layer`
  (them 2026-07-06, "but viet len web") ve net muc mo dan theo duong di chuot, khac voi
  icon con tro chuot da bo truoc do trong session nay.
- Xoa toan bo IIFE ve net muc trong `assets/js/main.js` (canvas, mousemove listener,
  requestAnimationFrame draw loop) va CSS `.pen-ink-layer` trong `assets/css/main.css`.
- Bump DGC_VER 0.6.2 -> 0.6.3. Backup 3 file goc vao private_deploy truoc khi ghi de,
  deploy qua scp/ssh key digicom_deploy. Verify: curl production khong con "pen-ink"
  trong ca JS lan CSS, HTML load dung version 0.6.3.

## 2026-07-09 (4) - Fix browser cache HTML 7 ngay tren Hostinger
- Hieu gui anh chup trang /dich-vu/mua-textlink/ van thay bang gia cu du server da
  sua tu truoc (turn (2) cung ngay) - kiem tra xac nhan server DA tra ve dung noi
  dung moi (curl khong thay price-table-cpt), nguyen nhan la browser cua Hieu dang
  giu ban cache cu.
- Root cause: `.htaccess` tren Hostinger co block mod_expires voi
  `ExpiresDefault "access plus 1 weeks"` ap dung cho MOI loai file khong duoc khai
  bao rieng - bao gom ca text/html (trang dong) - khien trinh duyet cache ca trang
  HTML 7 ngay, moi lan deploy sau nay Hieu se khong thay thay doi ngay tru khi hard
  refresh.
- Fix: them dong `ExpiresByType text/html "access plus 0 seconds"` ngay sau
  `ExpiresActive On` trong .htaccess (backup ban goc vao private_deploy truoc khi
  sua). CSS/JS/anh van giu cache dai binh thuong (khong doi gi khac).
- Verify: curl -I xac nhan HTML tra ve `cache-control: public, max-age=0`, CSS van
  `max-age=2592000` nhu cu, trang chu + /bang-gia/ van 200.

## 2026-07-09 (5) - Fix bang gia tran trang (nhom Mua Textlink)
- Hieu gui anh /bang-gia/ - bang bi tran ngang, cot Ghi chu/nut Dat ngay bi day/cat,
  watermark "Digicom" lo qua khe hong.
- Root cause: dong Mua Textlink co gia ghep nhieu muc "Home: ...d - CM: ...d -
  Fullsite: ...d" (~90 ky tu) nhung CSS `.price-table-cpt td.cell-price{white-space:
  nowrap}` ep khong cho xuong dong -> o gia rong bat thuong, day bang rong hon khung
  trang; `.price-table-wrap` khong co overflow-x:auto nen phan du bi body {overflow-x:
  hidden} cat mat thay vi cuon ngang.
- Fix trong main.css: `.price-table-wrap` them `overflow-x:auto` (an toan du phong
  cho bang rong bat ky), `.cell-price` doi `white-space:nowrap` -> `normal` +
  `max-width:280px` de gia ghep nhieu muc tu xuong dong gon trong o thay vi keo dai
  1 hang.
- Bump DGC_VER 0.6.3 -> 0.6.4. Backup main.css + functions.php truoc khi ghi de,
  deploy qua scp/ssh. Verify: curl production co CSS moi, version dung 0.6.4.

## 2026-07-09 (6) - Doi email nhan lead ve hieudx3107@gmail.com
- Hieu yeu cau: khach gui form (dat bai/nhan bao gia) thi mail phai den
  hieudx3107@gmail.com.
- Kiem tra: form da co san co che gui mail (`dgc_handle_lead()` trong functions.php,
  dung `wp_mail()` toi gia tri option `dgc_settings['email']` - sua duoc tu WP Admin,
  KHONG hardcode trong code, dung rule wordpress-non-code-editable). Truoc do option
  nay chua duoc luu qua Admin nen dung gia tri mac dinh info@digicomvn.com.
- Da cap nhat option `dgc_settings['email']` = hieudx3107@gmail.com qua wp-cli tren
  production (tuong duong voi vao WP Admin > Cai dat Digicom > sua o Email - Hieu co
  the tu doi lai sau ma khong can dung code).
- Test gui thu qua wp eval `wp_mail()` - ket qua tra ve true (WordPress da giao mail
  cho server gui, khong dam bao 100% toi inbox vi site khong cai plugin SMTP, dung
  ham mail() mac dinh cua PHP/hosting) - nhac Hieu kiem tra ca thu muc Spam.
- Phat hien rieng (CHUA sua, chi bao): `admin_email` goc cua WordPress (dung cho
  thong bao he thong nhu doi mat khau admin, khong phai email form) van la gia tri
  rac tu luc migrate: "dev-email@wpengine.local" - can Hieu xac nhan email that de
  doi (WP se gui link xac nhan toi email MOI, khong doi ho luc dang nhap duoc).

## 2026-07-09 (7) - Doi admin_email he thong WordPress
- Hieu xac nhan dung chung 1 email: doi luon `admin_email` (thong bao he thong WP -
  quen mat khau, canh bao core/plugin update...) tu gia rac "dev-email@wpengine.local"
  sang hieudx3107@gmail.com qua wp-cli (`wp option update admin_email`). Xac nhan lai
  gia tri da luu dung.

## 2026-07-11 - Don dep sitemap: xoa trang thua sau pivot, 301
- Check wp-sitemap.xml live: phat hien 33 trang cu (agency/LMS/tu san pham cu -
  portfolio, case-study, khoa-hoc x4, dashboard, student/instructor-registration,
  pr-bao-chi, entity-branding, thiet-ke-website, cham-soc-website, viet-bai-seo,
  google-maps-seo, chatbot-ai, ve-chung-toi, gioi-thieu trung voi ve-digicom,
  chinh-sach-cookie/hoan-tien khong lien ket noi bo, dich-vu-seo, google-ads,
  cart/checkout (khong cai WooCommerce, trang rong vo dung), + 8 trang giai doan 2
  (ten-mien, hosting, lap-trinh-website, ban-quyen-*, google-workspace, office-365,
  automation) van con publish dung le ra phai draft theo pivot-2026-07.md).
  Doi chieu menu "Menu Digicom" (dang active, 10 item) - khong trang nao trong danh
  sach tren duoc lien ket, xac nhan la mo coi.
- Backup: pages-before.csv (trang thai cu) + .htaccess.bak ->
  _backups/routines/2026-07-11/sitemap-cleanup/.
- Set 25 trang ve draft (wp post update --post_status=draft), giu nguyen noi dung
  (khong xoa vinh vien) - dung nguyen tac giong 8 trang giai doan 2 da lam truoc do.
- Them 33 dong `Redirect 301` vao dau .htaccess (block "DGC 301 REDIRECTS") tro
  moi URL cu ve trang hien hanh gan nhat (chu yeu /dich-vu/, /ve-digicom/, /blog/,
  /lien-he/). Da curl verify 301 dung dich cho 8 URL mau.
- Verify wp-sitemap-posts-page-1.xml con lai 28 URL, dung 100% pham vi pivot
  (4 dich vu + con booking-bao-pr + bang-gia/blog/ve-digicom/lien-he/dat-bai/
  chinh-sach-bao-mat/dieu-khoan-su-dung).
- CHUA lam: submit sitemap len Google Search Console (khong co GSC API/MCP ket noi
  trong phien nay - can Hieu tu vao GSC submit thu cong, xem PLAN.md).
- CO VAN DE RIENG phat hien them (chua sua, ngoai scope hom nay): cac trang con
  /dich-vu/booking-bao-pr/[bao]/ (vnexpress, kenh14, dan-tri, 24h, cafef,
  vietnamnet, thanh-nien, tuoi-tre, znews, soha, afamily, eva, cafebiz, webtretho,
  bao-dau-tu) dang publish va co trong sitemap, nhung pivot-2026-07.md ghi la
  "DRAFT, cho Hieu xac nhan danh sach bao that hop tac truoc khi publish" - can
  Hieu xac nhan da hop tac that voi cac bao nay chua, neu chua thi nen draft lai.

## 2026-07-11 (2) - Trang tac gia cho Hieu
- Doi display_name user WP tu "Do Hieu" sang "Hieu Đo" (dung ten hien thi cong khai theo
  yeu cau). Bio cu (mo ta "200 du an, Viettel/Vingroup/EVN, khach Uc/Nhat/My") la content
  agency cu, khong xac minh duoc va sai pham vi dich vu hien tai - viet lai bio moi, khiem
  ton, dung dich vu that (Textlink/Backlink/Guest Post/Booking bao PR).
- Them field Facebook/LinkedIn + anh dai dien that vao trang Ho so WP Admin (User edit) -
  sua duoc khong can code (rule wordpress-non-code-editable). Da luu:
  FB https://web.facebook.com/paolodinho/, LinkedIn .../hieu-d-193b128a/.
  CHUA co anh that (file "author_image" co san tren site la anh mau/demo, Hieu xac nhan
  KHONG phai anh that - da hoi truoc khi dung, dung avatar chu cai "HD" tam thoi).
- Tao template `author.php` (URL /author/do-hieu/): hero + avatar + bio + link MXH +
  danh sach bai da viet + Person schema JSON-LD (E-E-A-T).
- Them byline "Tac gia [ten] · ngay dang" vao dau moi bai blog (single.php).
- Phat hien + fix loi rieng: 14/108 bai blog co post_author=0 (import thieu tac gia) ->
  khong hien byline dung, trang tac gia se thieu bai. Da cap nhat ca 14 bai ve tac gia
  Hieu Đo (ID 1) - backup ID cu truoc khi sua.
- Deploy DGC_VER 0.7.8 len live, purge cache, verify byline + trang tac gia hien dung.
- CON THIEU: anh chan dung that cua Hieu - khi co, vao WP Admin > Ho so > "Chon anh" de
  thay avatar chu cai bang anh that.

## 2026-07-11 - Sua dinh vi noi dung 5 bai PR (bai-pr/2026/07/)
- Hieu chi ra dinh vi sai: 5 bai PR truoc do mo ta Digicom "lam website + automation" -
  KHONG dung voi dich-vu.md hien tai (giai doan 1 chi co Mua Textlink/Backlink/Guest
  Post/Booking bao PR; website la giai doan 2, dang draft).
- Viet lai toan bo 5 bai: trong tam dich vu truyen thong + booking bao chi, automation la
  cach Digicom van hanh (khong phai dich vu ban rieng). Nhan manh ly do booking bao chi
  quan trong trong thoi AI: la tin hieu giup thuong hieu duoc AI search (ChatGPT, Google AI
  Overview, Perplexity) va Google nhan dien - cham nhe SEO/GEO.
- Doi anh dai dien bai Angiang: tu nha may My (industrial-warehouse.jpg, sai boi canh) sang
  anh khu cong nghiep that tai Viet Nam (industrial-park.jpg, nguon Wikimedia CC BY-SA,
  khong dinh brand cu the).
- Giu nguyen: sapo, tit phu (Heading2), doan van ngan (mobile-friendly), 1 link Digicom +
  1 link ICD moi bai (rieng bai Angiang: 1 link Digicom + 1 link tac gia /author/do-hieu/,
  khong con link ICD theo yeu cau truoc).
- Da regenerate + validate + deploy ca 5 file .docx vao Downloads/PR-Digicom-5-bai/ va
  bai-pr/2026/07/.
- CON THIEU: file DKKD cho Baodanang.vn (Hieu chua gui).

## 2026-07-11 (tiep) - Fix anh 5 bai PR + loi mat anh
- Phat hien loi ky thuat: script merge lai bi ghi de rong mang "images" cho 4/5 bai (02-05)
  khi regenerate lan truoc -> file .docx Hieu nhan thuc te KHONG CO anh nao o 4 bai do.
  Day la nguyen nhan chinh cua feedback "anh van chua duoc".
- Ngoai loi mat anh, ra soat lai toan bo pool anh cu (keyboard/callcenter/desktop-calc/
  typing-analytics/ai-wordcloud) va phat hien deu la stock nuoc ngoai/lac hau: ban phim co
  ky hieu £/€ (khong phai VN), callcenter kieu My thap nien 1990 voi man hinh CRT, wordcloud
  clip-art, anh overlay bieu do gia tao - khong dat chat luong, bo toan bo.
- Thay bang anh that, xac thuc tung dia phuong (nguon Wikimedia Commons, CC BY-SA/CC0):
  Angiang -> khu cong nghiep VN + cho noi Can Tho; Danang -> skyline Da Nang (giu nguyen,
  da dung tot); Tuyen Quang -> toan canh TP Tuyen Quang; Ha Tinh -> TP Ha Tinh; Dong Nai ->
  khu cong nghiep VN + KCN Nhon Trach.
- Giam so luong anh/bai (2 anh cho 01/02/05, 1 anh cho 03/04) de uu tien chat luong that
  hon so luong anh stock gia tao - can hoi Hieu neu muon bo sung them anh cho du so luong
  toi thieu tung dau bao yeu cau.
- Da regenerate + validate + deploy lai ca 5 file vao Downloads/PR-Digicom-5-bai/ va
  bai-pr/2026/07/.

## 2026-07-11 (3) - Thong nhat thuong hieu DigicomVN
- Hieu chot: thuong hieu goi tat "DigicomVN", ten day du van la "Cong ty TNHH Dich vu
  Truyen thong Digito Combat" (khong doi).
- Backup full DB (mysqldump, 7.3MB) truoc khi sua - luu
  _backups/routines/2026-07-11/brand-digicomvn/dgc-pre-brand.sql.gz.
- Chay `wp search-replace 'Digicom' 'DigicomVN'` tren wp_posts/wp_postmeta/wp_options/
  wp_usermeta/wp_terms (dry-run truoc, xac nhan pham vi 331 cho thay the) - cap nhat
  108 bai blog, 5 trang, tieu de site (blogname), bio tac gia, cac dong FAQ/gia tri
  dgc_settings da luu tu truoc.
- Sua 18 file theme (header, footer, front-page, page-*, single, author, category,
  tpl-*, inc/options.php, inc/form-lead.php) - moi cho hien "Digicom" doc lap (logo
  text, tieu de trang, CTA, schema tac gia...) doi thanh "DigicomVN". Khong dong den
  "Digito Combat" (ten phap nhan), slug URL (/ve-digicom/...), prefix code dgc_/DGC_.
- Deploy DGC_VER 0.7.9, php -l pass ca 18 file, purge cache, verify: <title>, H1 trang
  Ve DigicomVN, footer copyright, menu, 1 bai blog mau - deu dung "DigicomVN".
- PHAT HIEN RIENG (chua sua): file logo hinh (logo-digicom.png, dung o header + favicon)
  la anh wordmark co san chu "Digicom" NUNG SAN TRONG ANH - sua text code khong doi
  duoc phan nay. Can Hieu quyet dinh: (1) gui file logo moi co chu "DigicomVN", hoac
  (2) Claude thu sua lai file anh hien co (font/mau tuong tu) - can xac nhan truoc khi
  lam vi ANH LA ASSET THUONG HIEU (rule ui-anti-slop: dung logo that, hoi truoc khi sua).

## 2026-07-11 (4) - Logo DigicomVN chinh thuc + ban am ban
- Hieu gui file logo moi (logodigicomVN.png) - crop bo vien trong suot thua, upload
  lam custom_logo chinh thuc (thay ID 213 -> 1380). Ap dung tu dong ca header va
  watermark chim vi ca 2 cung doc tu dgc_logo_url().
- Hieu gui tiep ban "am ban" (logo_digicomvn_amban.png, chu trang) - dung cho nen toi.
  Crop, upload (ID 1381), luu option `dgc_logo_light_id`, them helper
  `dgc_logo_url_light()` trong functions.php. Doi footer.php dung ham nay thay vi
  logo mau + CSS filter brightness(0) invert(1) (hack cu, kem chinh xac hon anh that).
- Deploy DGC_VER 0.8.0, verify logo trang hien dung tren nen navy footer.

## 2026-07-11 (5) - Them hotline 2 + van phong 2
- Them field `hotline2` (0775 031 895) va `address2` (Toa nha Thang Long A1, Thien Loc,
  Ha Noi) vao WP Admin > DigicomVN - sua duoc khong can code.
- Hien ca 2 hotline (cach nhau dau ·, moi so 1 link tel: rieng) o: footer, trang Lien he,
  trang Ve DigicomVN, trang Dat bai. Dia chi 2 hien them o footer + trang Ve DigicomVN
  (o "Lien he", KHONG dung vao card "Thong tin phap nhan" vi do la dia chi dang ky
  thue chinh thuc, giu nguyen rieng).
- Cac nut CTA "Goi ngay" (button don, 1 tel: link) van giu hotline 1 lam so goi chinh -
  khong nhet 2 so vao 1 nut de tranh vo giao dien/UX roi.
- Topbar tren cung header KHONG them hotline 2 (rule menu-single-line: topbar da chat
  cho email+zalo+gio lam, them so se vo dong tren mobile) - chi hien o cac trang/khu vuc
  co du cho.
- Deploy DGC_VER 0.8.1, verify hien dung tren footer/lien-he/ve-digicom.

## 2026-07-11 (6) - Fix URL danh-muc/* loi (redirect_guess gay lan noi dung)
- Nguyen nhan: "/danh-muc/" la category base CU (theme/site truoc pivot), site hien
  tai dung base "/category/" (xac nhan qua wp-sitemap-taxonomies-category-1.xml).
  URL cu khong con hop le nen WordPress tu doan (redirect_guess_404_permalink):
  trang 1 (/danh-muc/blog/) bi doan nham sang trang tinh "Blog" khong lien quan
  (nhin nhu gop noi dung), con trang 2+ (/danh-muc/blog/page/2/) thi doan that bai,
  tra ve 404 thang - hanh vi khong nhat quan gay cam giac loi.
- Fix: them redirect 301 rieng trong functions.php, chuyen toan bo "/danh-muc/*"
  sang "/category/*" tuong ung (giu nguyen slug + /page/N/), chay som (priority 5
  tren template_redirect) de chan truoc khi WP kip tu doan.
- Verify: /danh-muc/blog/ -> 301 -> /category/blog/ ; /danh-muc/blog/page/2/ -> 301
  -> /category/blog/page/2/ (category "Blog" khong co bai nen 404 dung, khong con
  loi trang khac); /danh-muc/seo-technical/ -> 301 -> /category/seo-technical/ (200).
- Khong bump DGC_VER (chi sua PHP logic server-side, khong dung CSS/JS cache).

## 2026-07-11 (7) - Audit toan bo 404/301, fix 2 bai blog that bi 404
- Crawl 149 URL trong wp-sitemap.xml + link noi bo o cac trang chinh -> phat hien
  2 URL tra 301 la /google-maps-seo/ va /viet-bai-seo/ (thay vi 200 nhu con lai).
- Dieu tra sau: KHONG phai do .htaccess (da xoa 2 dong redirect trung o do nhung
  van con 404) - root cause that su la 2 TRANG (page) DRAFT cu tu truoc pivot
  ("Dich vu Google Maps toi uu" ID 428, "Dich Vu Viet Bai Chuan SEO" ID 289) dang
  giu CHUNG slug voi 2 BAI BLOG THAT da publish (ID 361, ID 416). WordPress bi
  nham lan khi phan giai URL /%postname%/ giua page va post trung slug -> tra 404
  cho ca 2, du bai blog that su ton tai va publish binh thuong.
- Fix: doi post_name cua 2 trang draft cu sang *-old-draft (khong con dung, giu lai
  de rollback thay vi xoa - rule backup-before-edit), flush rewrite + cache.
- Verify: ca 149 URL trong sitemap deu tra 200. /google-maps-seo/ va /viet-bai-seo/
  hien dung noi dung bai blog that.
- Quet them: khong con URL /danh-muc/* nao khac gay loi (da fix redirect truoc do
  trong session), khong con collision page/post nao khac (kiem tra toan bo DB).

## 2026-07-13
- Chen anh minh hoa 3D illustration (doi ngu) vao hero banner trang chu, thay
  placeholder "Anh doi ngu DigicomVN dang cap nhat" - front-page.php hero-media.
- Resize 4 kich thuoc (640/960/1280/1600px) + srcset/sizes responsive, luu
  wp-theme/digicom-host/assets/images/hero-team-*.jpg.
- Deploy thang len live Hostinger (khong qua Local - site da air): scp file +
  bug quyen file 700->644 (upload len bi sai quyen gay 403), purge cache LiteSpeed.
  Backup front-page.php goc: _backups/routines/2026-07-13/front-page.php.bak-133700.
- Verify browser thuc te desktop/tablet/mobile (1600/768/375px) tren digicomvn.com -
  ảnh net, khong tran, srcset dung (mobile tai ban 640px 66KB thay vi ban goc 1.3MB).
- Feedback Hieu: hero "roi rac, chua sinh dong" -> sua:
  - Blob nen (.hero:before/:after) phong to, tang do dam, them animation troi nhe
    (hero-blob-float, co prefers-reduced-motion guard).
  - Them blob thu 2 sau anh (.hero-media:after, mau indigo) noi voi blob teal cu.
  - Them badge noi "21+ dau bao & site doi tac" de len goc trai-duoi anh, so lay
    THAT tu dgc_lines('press_partners') (khong bia so - rule content-professional),
    tu dong doi khi Hieu them/bot dau bao trong WP Admin.
  - Bump DGC_VER 0.8.1->0.8.2 (co sua CSS, theo rule deploy.md) tranh cache cu.
  - Deploy Hostinger: scp gop nhieu file bi loi am tham (khong bao loi nhung file
    khong thay doi tren server) - phai scp tung file rieng + verify lai bang
    grep/wc -l tren server moi chac chan.
- Hieu van thay hero "bo cuc khong on" -> draft 4 phuong an bo cuc hero khac (Artifact
  HTML, dung anh + mau brand that): A) cat cheo bat doi xung, B) nen toan canh, C) lop
  chong + chip dich vu, D) hai khoi lien ke. Hieu chon A.
  - Build lai hero that: .hero-diag-row (grid 1.2fr/1fr, khong bi gioi han boi .wrap ben
    media - anh tran het canh phai man hinh), .hero-diag-media dung clip-path polygon
    cat cheo, .hero-diag-strip la dai navy full-width thay cho trust-row + badge noi cu,
    gom ca so dau bao that (21+) va 4 muc trust cu vao 1 dai.
  - Don rac CSS chet: xoa toan bo .hero-split/.hero-grid/.hero-media/.hero-stat-badge/
    .trust-row cu (chi front-page.php dung, khong noi nao khac tham chieu - da grep xac
    nhan truoc khi xoa).
  - Bump DGC_VER 0.8.2->0.8.3, backup 3 file truoc khi ghi de, deploy + verify tren
    browser that o desktop/tablet/375px - dep, khong tran, chuyen sang layout stack +
    an clip-path chéo o duoi 992px.

## 2026-07-13 (chieu)
- Sua Google Doc 02-baodanang (1pdXU931Jt...) thanh bai gioi thieu cong ty DigicomVN: giu 2 link (DigicomVN -> digicomvn.com, ICD Viet Nam -> icdvietnam.com.vn), them muc Khach hang tieu bieu (Emmich, BV Viet Phap, BV Mat HN 2, Giong Moi, ITC Thai Binh, The News Leaders, Medlatec, BV Hong Ngoc, Tham my Thu Cuc, PK H Plus, Nghikigai). Backup ban goc: ~/Claude-Workspace/_backups/2026-07-13/digicom-gdoc-booking-danang-GOC.md

## 2026-07-14 - Hero fix + đổi phong cách section "Chúng tôi là ai"
- Fix H1 hero vỡ 8 dòng/cắt chữ ở màn rộng (bỏ max-width:520 chèn padding, h1 18ch).
- Section "Chúng tôi là ai": bỏ placeholder rỗng, dùng ảnh đội ngũ thật (lấy từ hero dichvusmsvn.com) + overlay navy + glow teal/blue theo style hero đó.
- Deploy live, DGC_VER 0.8.5, purge cache.

## 2026-07-14 (tiếp) - Template thumbnail blog + áp 108 bài
- Dựng bộ 10 illustration SVG flat (đồng bộ phong cách hero) + template render Chrome headless -> PNG 1200x675, badge+illustration tự map theo tiêu đề, logo DigicomVN thật.
- Render 108 bài, upload WP media + set featured image toàn bộ blog (0 lỗi). Pipeline lưu tại tools/blog-thumbnail/.
- Backup _thumbnail_id cũ tại _backups/2026-07-14/digicom-blog-thumbs/ (rollback được).

## 2026-07-14 (tiep) - Anh nen full section "Chung toi la ai"
- Doi anh doi ngu tu khung card sang lam NEN FULL ca section (gom ca phan Vi sao chon / 01-04), overlay navy + glow teal/blue giu chu doc ro. DGC_VER 0.8.6.

## 2026-07-14 (tiếp) - Đổi ảnh dịch vụ Textlink
- Thay ảnh trong trang /dich-vu/mua-textlink/ (page 505): ảnh xích kim loại cũ -> illustration flat xanh (dichvu_textlink.png) khớp phong cách site. Attach mới 1601, ảnh cũ 1382 giữ lại.

## 2026-07-14 (tiếp) - Favicon + section "Vì sao phải booking báo chí"
- Tạo favicon từ ký hiệu molecule g (teal) của logo trên nền navy bo góc; upload + set WP site_icon (attachment 1603). Assets lưu ở theme assets/images/.
- Thêm section "Vì sao phải booking báo chí" (4 lợi ích: uy tín/backlink/độc giả/thông điệp + CTA) ngay dưới phần Mạng lưới báo chí trên trang chủ.

## 2026-07-14 (tiếp) - 4 review khách hàng thật + ảnh chân dung
- Thêm 4 testimonial thật: Vũ Văn Luân (BV Việt Pháp/Booking PR), Lê Văn Thăng (ICD/Guest Post), Nguyễn Hoàng Vinh (Zora/Backlink) - có ảnh chân dung; Nguyễn Tuấn Hoàng (Magenest/Textlink) - avatar chữ.
- Template: hỗ trợ ảnh avatar, bỏ dòng disclaimer "ví dụ minh hoạ", initial bỏ tiền tố Ông/Anh/Chị. Câu trích là bản nháp, sửa được ở WP Admin > DigicomVN > testimonials.

## 2026-07-14 (tiếp) - Bỏ "Vì sao booking báo chí" + 3 case study thật
- Gỡ section "Vì sao phải booking báo chí" khỏi trang chủ.
- Tab Case study: thêm 3 case thật kèm link báo nguồn (chip theo tên báo): BV Việt Pháp (triển lãm tranh, VnExpress VI+EN), H Plus (ra mắt phòng khám), ICD Việt Nam (định danh thương hiệu cho AI). Card mở rộng: tag dịch vụ + mô tả + khách hàng + hàng link "Xuất hiện trên". Helper dgc_source_label() map domain->tên báo. Sửa được ở WP Admin > DigicomVN > case_studies (5 cột: tiêu đề | mô tả | dịch vụ | khách hàng | link1,link2,...).

- Thêm case study 4: Bệnh viện Mắt Hà Nội 2 (thành thương hiệu số 1 mổ cận, xây chuyên mục riêng trên SKĐS). Grid case study đổi auto-fit để 4 thẻ nằm gọn 1 hàng.

## 2026-07-14 (tiếp) - Case 5 + ảnh Hoàng + báo chí 5 hàng
- Case study 5: Dodanong.com (website review số 1 ngách sức khỏe nam giới, 2020, tới khi Google đổi thuật toán). Nguồn: Tuổi Trẻ, Viện KTXH Hà Nội.
- Thêm ảnh chân dung ông Nguyễn Tuấn Hoàng vào testimonial (Magenest).
- Phần Mạng lưới báo chí: 1 hàng -> 5 hàng logo chạy đổi chiều xen kẽ; bổ sung 13 đầu báo quốc tế (Reuters, AP News, Forbes, Yahoo, CNBC, Nasdaq, MarketWatch, Business Insider, Digital Journal, Straits Times, Bangkok Post, Tech in Asia, e27) trộn với 21 báo VN. Logo lấy qua favicon service.

## 2026-07-14 (tiếp) - Gắn 6 logo mới (5 khách hàng + 1 đài truyền hình)
- Client wall: Thu Cúc (thucuc.webp), ITC Thái Bình (itc-thaibinh.webp), The New Leaders (thenewleaders.svg - đổi tên hiển thị từ "The Leaders Asia" cho khớp logo), Yamafuji Packing (yamafuji.jpg), Siêu thị Hải Minh (haiminh.png). Còn Dodanong.com chưa có logo (hiện chữ).
- "Báo chí nói về DigicomVN": gắn logo Truyền hình An Giang (angiangtv.svg) - trước đây hiện chữ.
- Logo nguồn chuẩn hoá tên, lưu repo tại wp-uploads/client-logos/ + wp-uploads/press-logos/; upload live, chmod 644 (scp để 600 -> 403).
- Sync repo front-page.php theo bản live (live đã có marquee client wall, repo còn grid tĩnh -> deploy từ repo sẽ regress).
- Backup: ~/Claude-Workspace/_backups/routines/2026-07-14/digicom-logos/

## 2026-07-14 (tiếp) - Dịch vụ mới: Backlink Social Entity
- Trang /dich-vu/backlink-social-entity/ (page 1621, tpl-service.php): social entity là gì, vì sao cần, USP, quy trình 7 bước, cam kết (index >85%, bảo hành 6 tháng), 5 FAQ.
- 4 gói giá trong CPT dgc_gia (term mới `backlink-social-entity`, post 1622-1625), giá = 120% giá Solann Digital: 649.000 / 1.259.000 / 2.389.000 / 3.469.000đ.
- Theme: cpt-gia.php (term + nhom), tpl-service.php (hiện bảng giá ngay trên trang, ẩn quy trình chung), service-pricing.php + page-bang-gia.php (nhãn cột "Tên gói"/"Quy mô gói" cho nhóm bán theo gói), page-dich-vu.php (card thứ 5, icon share), footer.php, menu chính. DGC_VER 0.9.9.
- Backup file live trước khi ghi đè: ~/Claude-Workspace/_backups/routines/2026-07-14/digicom-social-entity/
- Bổ sung logo Dodanong.com (từ `logo dodanong.png` sẵn có trong repo): crop sát nội dung + bo góc 12px, giữ nền tối (chữ trắng nên không tách nền được). Client wall giờ 15/15 khách hàng đều có logo thật, không còn ô hiện chữ.
- Mục "Báo chí nói về DigicomVN": gắn logo Báo Đồng Nai (baodongnai.png, từ images.png) và thêm Báo Đà Nẵng (baodanang.png, từ ogimagedn.jpg) - cả 2 đã crop bỏ nền trắng thừa. Báo Đà Nẵng CHƯA có link bài, chỉ hiện logo; bổ sung link ở WP Admin > DigicomVN khi có.
- Thay logo 4 đầu báo bằng logo chữ chính thức (trước là favicon 32-48px lấy qua favicon service, bé + mờ): Dân Trí (dantri-v2.png), Thanh Niên (thanhnien-v2.png), Tuổi Trẻ (tuoitre-v2.svg), VietNamNet (vietnamnet-v2.svg). Đã tách nền trong suốt + crop sát; đặt hậu tố -v2 để tránh cache tĩnh 7 ngày. Thay ở cả press_partners lẫn press_mentions.
- Lưới "Báo chí nói về DigicomVN": đổi từ grid 5 cột cố định sang flex-wrap + justify-content:center -> hàng cuối lẻ (11 logo = 5+5+1) tự căn giữa thay vì dính mép trái. DGC_VER 0.9.9 -> 1.0.1.
- Sync repo main.css + front-page.php theo bản live trước khi sửa (live đã có marquee client wall mà repo chưa có; deploy từ repo cũ sẽ regress). Backup 2 bản cũ trong _backups/routines/2026-07-14/digicom-logos/.
- Thêm 3 khách hàng/đối tác: TrueMoney (truemoney.png), Nhựa Thành Công - Tha Co Plastic JSC (nhuathanhcong.png), 1Beauty (1beauty.png). Đã tách nền trong suốt + crop. Client wall: 18 logo, tất cả đều có logo thật.
- Hero: dải số liệu chuyển từ tự-đếm (34+ theo danh sách press_partners) sang field `hero_stats` sửa được ở WP Admin > DigicomVN > Hero (mỗi dòng: con số | nhãn, tối đa 5 dòng). Hiện: 500+ đầu báo trong nước & quốc tế / 2.000+ site guest post đa ngành / Báo giá minh bạch / Hỗ trợ tư vấn tận tình / Xuất VAT đầy đủ.
- Hero mô tả phụ: thêm định vị "mạng lưới guest post lớn bậc nhất Việt Nam cùng quan hệ booking báo trong nước và quốc tế". DGC_VER 1.0.2.

## 2026-07-14 (tiếp) - Dark mode + FAQ 20 câu + menu mobile
- **Chế độ ban ngày/ban đêm**: nút mặt trời/mặt trăng ở header (và trong menu mobile). Tự theo cài đặt hệ điều hành của khách lần đầu, sau đó nhớ lựa chọn (localStorage). Script đặt theme chạy trong <head> nên không nháy trắng khi tải trang.
  - Refactor token: tách `--heading` (chữ tiêu đề) khỏi `--navy` (vốn dùng cả làm nền tối) - 47 chỗ; đổi 32 chỗ CSS + 12 chỗ inline PHP `background:#fff` -> `var(--surface-2)`.
  - Chủ ý: ô logo báo/khách hàng GIỮ nền trắng ở dark (nhiều logo là chữ màu tối, đặt trên nền tối sẽ chìm).
- **FAQ**: 4 -> 20 câu, phủ: pháp nhân/quy mô mạng lưới DigicomVN, Textlink, Backlink (+BĐS), Guest Post, Booking báo & PR (báo quốc tế, duyệt bài, link dofollow), giá/VAT/thanh toán/bàn giao, thời gian thấy hiệu quả. Thêm schema FAQPage (20 mục) để Google + trợ lý AI trích dẫn.
- **Menu mobile**: kiểm tra thực tế bằng Playwright - burger + drawer 12 mục VẪN HOẠT ĐỘNG (không phải bug mất menu). Nguyên nhân Hiếu không thấy: nút 3 gạch mảnh, không viền, nép sát mép phải. Đã thêm viền tròn + nền để dễ nhận biết.
- DGC_VER 1.0.2 -> 1.1.1. Backup: _backups/routines/2026-07-14/digicom-darkmode/

## 2026-07-14 (tiếp) - Đẩy bảng giá lên đầu trang dịch vụ
- `tpl-service.php`: chuyển khối bảng giá (`inc/service-pricing.php`) lên NGAY DƯỚI hero, trước phần nội dung mô tả. Thứ tự mới: hero -> bảng giá -> nội dung -> quy trình -> form báo giá -> CTA. Áp cho cả 5 pillar + 15 trang con booking-bao-pr (dùng chung template).
- Trang `/bang-gia/` vốn đã có bảng ngay sau hero -> giữ nguyên.
- Chỉ sửa PHP (không đụng CSS/JS) -> không cần bump DGC_VER. Đã purge cache + verify curl 6 URL.
- Backup bản live cũ: ~/Claude-Workspace/_backups/routines/2026-07-14/digicom-pricing-top/

## 2026-07-14 (tiếp) - Hướng dẫn đặt hàng + thông số DR trong bảng giá
- **Hướng dẫn đặt hàng** (`inc/order-guide.php`, dùng chung): 4 bước (Chọn mục cần đặt -> Gửi yêu cầu đặt bài -> Nhận báo giá & xác nhận -> Đăng bài & bàn giao) + khối "Chưa biết nên chọn báo hay gói nào?" với nút Gọi hotline + Nhắn Zalo (số lấy từ WP Admin > DigicomVN, không hardcode). Đặt NGAY DƯỚI bảng giá ở cả 5 trang pillar, 15 trang con booking-bao-pr và trang /bang-gia/.
- Gỡ section "Quy trình - Cách DigicomVN triển khai" (4 bước chung chung) khỏi trang có bảng giá vì trùng lặp; chỉ còn hiện ở trang dịch vụ không có bảng giá.
- **Thông số DR (Domain Rating - Ahrefs)**: thêm meta field `dr` vào CPT dgc_gia (sửa được ở WP Admin), chip DR hiện dưới tên báo/site trong mọi bảng giá (màu theo bậc: >=70 xanh dương, 40-69 xanh teal, <40 xám). Thêm nút sắp xếp "DR cao -> thấp" (main.js: sort-btn nhận data-key=price|dr).
- Dữ liệu DR: lấy THẬT từ Ahrefs (public domain-rating API, 0 unit) cho 143 domain -> gán được 188/213 dòng giá. 25 dòng còn lại không có DR vì là gói dịch vụ (21 gói Backlink Sidebar + 4 gói Social Entity), không gắn với 1 domain cụ thể.
- DGC_VER 1.0.7 -> 1.0.9. QA Playwright: không tràn ngang ở 1440px và 390px.
- Backup: ~/Claude-Workspace/_backups/routines/2026-07-14/digicom-dr-orderguide/ (file live cũ + dump meta trước khi nạp + dr-ahrefs-2026-07-14.json)

## 2026-07-14 (tiếp) - 4 fix UX theo phản hồi Hiếu
1. **Cuộn vô hạn bảng giá dài**: main.js đổi cơ chế "Xem thêm" -> IntersectionObserver, cuộn tới cuối bảng tự nạp thêm 10 dòng (nút vẫn giữ làm fallback + mốc quan sát). Trang /bang-gia/ trước render thẳng 118 dòng -> giờ 12 dòng đầu, cuộn nạp dần. Đổi tìm kiếm/lọc -> reset về đầu danh sách.
2. **Hero 3 nút mobile**: `.hero-actions` - desktop 1 hàng, mobile xếp dọc full-width (trước là 2 nút hàng 1 + 1 nút lẻ hàng 2 lệch giữa).
3. **Textlink trình bày lại**: `dgc_gia_price_tiers()` tách chuỗi giá dài ("Home: 1500000-1800000-2500000đ · CM: ...") thành bảng vị trí × kỳ hạn (3-6-12 tháng); cột Giá chỉ hiện "Từ <rẻ nhất>". Mobile: bảng thành thẻ theo vị trí, mỗi kỳ hạn 1 dòng có nhãn. `dgc_gia_specs()` sửa chuỗi chỉ số nguồn lặp nhãn ("DA DA55" -> "DA 55"), format traffic có dấu phân cách, và BỎ "DR 57" của nhà cung cấp vì lệch với DR Ahrefs đang hiện ở chip (tránh 2 số DR đá nhau trên cùng 1 dòng).
4. **Section "Tại sao chọn DigicomVN"**: đổi từ lưới card icon (giống hệt section Dịch vụ ngay trên) sang bố cục 2 cột - trái là tiêu đề + CTA (sticky), phải là danh sách 6 lý do đánh số 01-06 có gạch phân cách. Nền đổi sang --surface để tách khỏi section trên.
- DGC_VER 1.0.9 -> 1.1.4. QA Playwright: overflow ngang = 0 ở 1440px và 390px; /bang-gia/ cuộn tới cuối nạp đủ 118/118 dòng.
- Backup: ~/Claude-Workspace/_backups/routines/2026-07-14/digicom-ux-fixes/

## 2026-07-14 (chiều tối) - Địa chỉ văn phòng giao dịch (NAP)
- Chốt: Digicom có 2 địa chỉ - **Trụ sở ĐKKD** (Gamuda Garden, Hoàng Mai, chỉ dùng hợp đồng/hoá đơn/pháp nhân) và **Văn phòng giao dịch** (Tầng 3, tòa nhà Thăng Long A1, đường Tây Cao Tốc, thôn Bầu, xã Kim Chung, huyện Đông Anh, Hà Nội - dùng chung địa chỉ với ICD Việt Nam).
- Theme digicom-host: `inc/options.php` sửa default `address2` (trước ghi sai "Toà nhà Thăng Long A1, Thiên Lộc, Hà Nội"), đổi nhãn field trong WP Admin thành "Tru so" / "Van phong giao dich". `footer.php` đổi nhãn "VP 1/VP 2" -> "Trụ sở/Văn phòng". `page-lien-he.php` + `page-ve-digicom.php` hiển thị rõ 2 nhãn.
- Deploy live (4 file PHP), purge cache, verify curl /lien-he/ hiện đúng địa chỉ Đông Anh, hết chuỗi "Thiên Lộc".
- `.claude/context/brand-info.md`: tách 2 dòng Trụ sở / Văn phòng giao dịch + ghi rõ chuỗi NAP chuẩn dùng cho GBP/citation/backlink.
- Backup: ~/Claude-Workspace/_backups/routines/2026-07-14/dgc-address/
- TODO: DB Local chưa cập nhật (Local site đang tắt) - live không ảnh hưởng vì dgc_settings live chưa lưu key address nên lấy default từ code.

## 2026-07-14 (tiếp) - Mặc định DR cao→thấp + fix bảng giá bị cắt
- **Mặc định sắp xếp DR cao -> thấp**: `dgc_get_gia()` usort theo DR giảm dần (tie: menu_order rồi giá tăng); nút "DR cao → thấp" có class `active` sẵn khi tải trang. Dòng không có DR (gói dịch vụ) xuống cuối.
- **Fix 2 lỗi giao diện làm cắt nút "Đặt ngay"**:
  1. `.brand-watermark` (logo chìm fixed bên phải) rộng cố định ~290px nên ở màn 1280-1440px nó lấn hẳn vào vùng nội dung, phủ mờ lên cột hành động. Sửa: watermark chỉ chiếm đúng dải lề ngoài `.wrap` (`width:calc((100vw - var(--maxw))/2 - 16px)`) và ẩn hẳn khi viewport <= 1560px (không còn lề).
  2. Bảng giá rộng 925px trong khung 888px (tràn 37px, nút bị cắt) do `.spec-chip{white-space:nowrap}` với chip quy cách dài ("1 link no, thêm 1 link/600k, trên 300 từ tính phí 8.000đ/từ") kéo giãn bảng. Sửa: `.price-table-cpt{table-layout:fixed}` + chip cho phép xuống dòng.
- DGC_VER 1.1.4 -> 1.1.6. QA: overflow bảng = 0 ở 1280/1440/1920 trên /bang-gia/, /mua-textlink/, /booking-bao-pr/; mobile 390px = 0.

## 2026-07-14 (tiếp) - Tiết chế màu đen
- 4 thẻ promo trang chủ: bỏ nền gradient navy/xanh/teal đậm -> nền sáng, viền nhẹ, chỉ icon mang màu brand (xanh dương / teal xen kẽ). Có bản dark mode riêng.
- Nút "Đặt ngay" trong bảng giá (lặp 12+ lần mỗi bảng): navy đen -> xanh brand `--action`.
- Giữ màu tối làm điểm nhấn hiếm: topbar, footer, band ảnh đội ngũ, hero trang dịch vụ, nút "Gửi yêu cầu báo giá".
- Ghi rule mới: `.claude/rules/ui-mau-sac.md` (khi nào được/không được dùng nền tối).
- DGC_VER 1.1.6 -> 1.1.7.

## 2026-07-14 - Google Business Profile
- Soan ho so GBP day du: `09-local-seo/google-business-profile.md` (ten, 4 danh muc, NAP van phong Dong Anh, mo ta 750 ky tu, 5 dich vu, kich ban video xac minh, post + Q&A dau tien).
- Canh bao: trung dia chi toa nha voi ICD Viet Nam -> phai ghi ro tang/phong khac nhau.
- Cho Hieu: chup anh ngoai that/noi that/doi ngu + tu dang ky tai business.google.com/create.

## 2026-07-14 (tối) - Chia nhỏ bộ lọc nhóm báo (11 -> 25 nhóm)
- `dgc_nganh_groups()` mới trong `inc/cpt-gia.php`: bộ lọc chia 5 khối - Loại hình báo (3) / Kinh doanh - Tài chính (4) / Nhà ở - Không gian sống (4: BĐS, Xây dựng - Vật liệu, Kiến trúc - Nội thất, Phong thuỷ - Tâm linh) / Tiêu dùng - Đời sống (6) / Ngành khác (8). Tách "BĐS - Xây dựng" và "Công nghệ - Ô tô" cũ thành các ngành riêng.
- Meta box WP Admin: checkbox ngành nhóm theo 5 khối (trước là 1 dãy phẳng).
- `page-bang-gia.php`: sidebar render theo khối, có tiêu đề phụ, bỏ qua khối không có báo. `main.css`: sidebar sticky tự cuộn (max-height 100vh-200px), nút nhỏ lại 13.5px. DGC_VER 1.1.7 -> 1.1.8.
- Gán lại ngành cho 118/118 dòng booking báo trên live (script `nganh-map.php`): báo lớn/đài TH gán theo chuyên mục thật, báo chuyên ngành gán đúng ngành (baoxaydung/tapchixaydung = xây dựng + kiến trúc, cafeland = BĐS + phong thuỷ, tinhte = công nghệ...), 26 báo tỉnh dùng bộ ngành mặc định (kinh tế, doanh nghiệp, BĐS, xây dựng, y tế, giáo dục, du lịch, nông nghiệp).
- Verify live: đủ 25 nút lọc, không lỗi PHP. Backup: ~/Claude-Workspace/_backups/routines/2026-07-14/dgc-nganh/
- TODO Hiếu review: các gán ngành dựa trên chuyên mục thực tế của báo, cần soát lại các báo mình biết rõ chính sách nhận bài (vd phong thuỷ chỉ 13 báo, có thể còn thiếu/thừa).

## 2026-07-14 (tiếp) - Fix thanh chọn (giỏ hàng) trên mobile
- Khi tick nhiều mục, thanh nổi dưới đáy cao ~199px (che 1/4 màn), các con số tràn 2-3 hàng lộn xộn, tổng tiền + "Xem danh sách" bị cắt mép phải (info rộng 385px trong khung 362px).
- Bố trí lại dạng lưới 2 cột cố định: trái = số mục + ưu đãi combo, phải = tổng còn lại (to) + link "Xem danh sách"; dưới là nút CTA full-width; cuối là 1 dòng gợi ý combo. Chặn tràn bằng box-sizing + minmax(0,1fr).
- Câu gợi ý combo rút ngắn riêng cho mobile ("Thêm 4 mục → giảm 12% (~6.276.000đ)") để nằm gọn 1 dòng.
- Kết quả: 163px (6 mục), 137px (20 mục), không tràn ngang ở 360px lẫn 390px.
- DGC_VER 1.1.7 -> 1.2.0.

## 2026-07-14 (tiếp) - Bỏ 4 card promo (AI-slop) -> dải giá trị liền
- Hiếu chê bản card nền sáng vẫn xấu. Nguyên nhân gốc: đó đúng là mô-típ "4-column icon-top feature grid" bị cấm trong rule global `ui-anti-slop.md`.
- Thay bằng MỘT dải liền (1 khung, 1 viền, bo góc lớn), chia 4 cột bằng vạch mảnh; icon nhỏ 22px inline (xanh dương / teal xen kẽ), bỏ nền tròn, bỏ box-shadow từng thẻ, bỏ vòng tròn trang trí, bỏ rotate lệch. Tiêu đề có min-height 2 dòng để dòng mô tả thẳng hàng giữa các cột.
- Mobile: dải xếp dọc, phân tách bằng đường ngang (không thành 4 hộp rời).
- DGC_VER 1.2.0 -> 1.2.2.

## 2026-07-14 (tiếp) - Bỏ 2 dải đen ở đầu trang
- Topbar (hotline/email trên cùng): navy đen -> nền sáng + viền dưới, chữ xám, hotline đậm màu heading.
- Dải số liệu dưới hero (500+ đầu báo...): navy đen -> gradient xanh brand (--action -> --action-2 -> teal đậm), chữ trắng.
- Còn lại dùng nền tối: hero trang dịch vụ, band ảnh đội ngũ, footer (chưa đổi - chờ Hiếu quyết).
- DGC_VER 1.2.2 -> 1.2.3.

## 2026-07-14 (tiếp) - Thanh chọn desktop nổi bật hơn
- Thanh sticky trước nhìn như 1 dòng text trong hộp trắng viền nhạt. Nay: viền trái 5px màu brand, nền gradient nhẹ, bóng đổ sâu; khi đã chọn mục thì viền + quầng sáng xanh brand ("sống" lên).
- Tổng còn lại: 26px, đậm, tách bằng vạch đứt. Ưu đãi combo: chip teal. CTA: xanh brand + mũi tên (bỏ khối đen theo rule ui-mau-sac). Lời nhắc combo: khối vàng nhạt có icon quà.
- Fix: chip ưu đãi hiện "0%" khi chưa đủ bậc (class .sel-bar-line{display:flex} đè thuộc tính [hidden]); nút CTA rơi xuống hàng 2 lệch trái khi số liệu dài -> ghim margin-left:auto + ẩn ghi chú VAT trùng lặp, cả thanh gọn 1 hàng ở 1280px.
- DGC_VER 1.2.3 -> 1.2.7. Mobile giữ nguyên bố cục đã fix (163px, không tràn).

## 2026-07-14 (tiếp) - Fix "Xem danh sách" trên mobile
- Popup danh sách báo đã chọn mở XUỐNG DƯỚI (top:100%) trong khi thanh chọn ghim đáy màn -> danh sách rơi ra ngoài viewport, chỉ thấy 1 dòng, phần còn lại bị bottom-nav che.
- Sửa: mobile popup mở LÊN TRÊN thanh (bottom: calc(100% + 12px)), rộng full thanh, max-height 46vh, cuộn được, bóng đổ hướng lên. Tên dài cắt gọn 1 dòng, nút xoá to hơn.
- Đồng thời gỡ `overflow:hidden` (thêm ở fix tràn ngang trước đó) vì nó cắt mất chính popup này; chặn tràn ngang đã lo bằng box-sizing + minmax(0,1fr).
- CTA trong thanh ở mobile: đen -> xanh brand (đồng bộ desktop + rule ui-mau-sac).
- DGC_VER 1.2.7 -> 1.3.0.

## 2026-07-14 (tiếp) - Đánh dấu trường bắt buộc trên form
- `inc/form-lead.php` (form dùng chung: /lien-he/, /dat-bai/, 5 trang dịch vụ): thêm dấu * đỏ vào Họ và tên, Số điện thoại, Email - khớp đúng logic kiểm tra ở server (tên bắt buộc + phải có ít nhất 1 trong 2 kênh liên hệ). Dịch vụ quan tâm và Nội dung không bắt buộc -> không có dấu *.
- Thêm dòng chú thích "* Bắt buộc. Điện thoại và email: nhập ít nhất một..." và validate ngay tại chỗ (setCustomValidity) - trước đây bỏ trống cả 2 thì phải submit rồi bị đá về ?sent=err, mất nội dung đã nhập.
- DGC_VER 1.3.0 -> 1.3.1.

## 2026-07-14 - Kho bao gia booking bao & PR
- Tao `10-bang-gia-booking/`: bang-gia-master.csv (183 dong, 3 NCC), tra-cuu.py, build_master.py, nguon.md, raw/.
- Boc toan bo 10 tab sheet DanaSEO qua Chrome (Drive API chan file) -> 157 dong gia.
- Quy tac gia chot: gia ban Digicom = GIA GOC niem yet cua NCC, moi ben nhu nhau, khong markup, chua VAT 8%.
- Scheduled task `booking-price-daily` 8h05 sang moi ngay: cap nhat sheet + quet nguon moi + ghi CHANGELOG.

## 2026-07-14 (bo sung) - Quet 7 mui, kho gia len 1.046 dong
- 34 NCC. Co RATE CARD CHINH THUC Admicro (VCCorp) + VTC News = gia goc tu toa bao.
- Sheet cong khai boc duoc: SEOViP (77), DPS.MEDIA (194), Guestpost.vn (50).
- export-web.py: gom theo TANG san pham (trang chu / chuyen muc / bao tinh / dofollow) -> 113 muc co nhieu ben, tu chon RE NHAT.
- Phat hien: Dan tri chinh chu ghi ro link NOFOLLOW; he VCCorp chi 1 link/bai.

## 2026-07-14 (bo sung 2) - Bo loc quy cach bai tren bang gia
- Them bo loc: Loai link (dofollow/nofollow/khong chen link), So anh (tu 3 / tu 5), Do dai (tu 1.000 tu).
- Suy TU DONG tu 2 truong `so_link` + `yeu_cau` cua tung dong gia (`dgc_gia_facets()` trong inc/cpt-gia.php)
  -> admin sua chu trong WP Admin, bo loc tu cap nhat, khong phai nhap them field.
- Quy uoc than trong: "duoi 1000 tu" -> 999 (khong lot bo loc >=1000 tu, tranh hua qua); "3-5 anh" -> 5.
- File moi `inc/price-filter.php` (cot loc dung chung cho /bang-gia/ + bang gia trong trang dich vu).
- Nhom nao khong co du lieu -> tu an bo loc (vd Textlink). Deploy live, DGC_VER 1.3.2.

## 2026-07-14 (bo sung 3) - Uu dai khan hiem, trang cam on, mac dinh sang
- Khoi uu dai moi (`inc/promo-band.php`, trang chu + moi trang dich vu): ghi ro "Viet bai chuan SEO
  mien phi" + "Tu van va chon bao mien phi"; them KHAN HIEM (con N suat) + HAN CHOT (dem nguoc ngay/gio).
  Options moi: promo_title, promo_deadline (trong = het thang hien tai), promo_slots (dat 10).
- Form gui thanh cong -> chuyen sang trang `/cam-on/` (noindex, 3 buoc tiep theo, nut goi/Zalo).
  Template page-cam-on.php + tu tao page. Loi van bao tai cho o form.
- Mac dinh giao dien SANG: header.php khong doc prefers-color-scheme nua, chi nho lua chon khach tu bam.
- Deploy live, DGC_VER 1.4.0. Rule moi: `.claude/rules/uu-dai-cta.md`.

## 2026-07-14 (bo sung 4) - Gon bo loc bang gia
- Bo cot loc doc (25+9 nut, cuon doc) -> THANH LOC NGANG: 4 dropdown (Nhom bao / Loai link /
  So anh / Do dai) + chip dieu kien dang bat (bam x de bo) + nut "Xoa bo loc".
- Bang gia rong them ~248px (888 -> 1136px o 1280). Mobile 390px: 2 dropdown/hang, khong tran ngang.
- Deploy live, DGC_VER 1.4.1. Backup: _backups/routines/2026-07-14/digicom-loc-gon/.

## 2026-07-14 (import live) - Bang gia len 525 dong
- Import 312 dau bao/site MOI + cap nhat gia 79 dong len digicomvn.com (tu 213 -> 525 ban ghi).
- Rule moi: CHOT CHAN GIA VON - khong ban duoi gia von; loai gia "mem" (gia tu.../dai gia) khoi dinh gia.
- Truoc do live ban dung = gia KM DanaSEO (lai 0d). Nay chuyen sang gia goc niem yet -> 79 dong tang gia, tao bien lai.
- Backup: ~/Claude-Workspace/_backups/routines/2026-07-14/bang-gia-import/dgc_gia_full.json (213 ban ghi goc).

## 2026-07-14 (toplist + QA) - Bang gia hoan chinh 540 dong
- Them dich vu TOPLIST: quet 8 NCC (DanaSEO, Newtop, ATP Media, iToplist, SETUPOTA, Toplist Viet, BT Marketing, BookBaoPR) -> 26 dong kho, 15 dong len web.
- Tao nhom `dich-vu-toplist` (khai trong page-bang-gia.php + inc/cpt-gia.php), deploy theme DGC_VER 1.4.2.
- Sua 284 ban ghi tieng Viet KHONG DAU -> co dau (fix-dau.php). Text hien thi cho khach phai dung chinh ta.
- LIVE: 540 ban ghi gia, 6 nhom dich vu, trang /bang-gia/ render du.

## 2026-07-14 (sua) - Tra gia ve dung gia DanaSEO dang ban
- LOI: da hieu "lay bang gia DanaSEO" thanh GIA GOC niem yet -> 179 dong bi doi gia, Digicom dat hon chinh DanaSEO.
- SUA: khoi phuc 179 dong ve dung gia cu (gia KM = gia DanaSEO ban that). Verify: VnExpress 11.8tr, CafeF 10.4tr, Kenh14 6.1tr.
- LOI 2: script sua dau lam hong chu ("Kinh doanh" -> "Kinh doảnh") do luat thay "anh"->"ảnh" an vao giua tu. Da fix 2 truong.
- RULE MOI: khong de script tu so gia giua cac NCC - de so nham san pham khac quy cach. Doi chieu tay.

## 2026-07-14 (hoan thien) - Gia cuoi + loc nganh + dark mode
- GIA CUOI: moi NCC lay dung gia ho thuc ban (DanaSEO = gia KM, SEOViP = gia CK). Sua 20 dong con lay gia goc.
- Gan NGANH cho 248 dong (guest post + bao) -> bo loc linh vuc hoat dong. 174 goi dich vu khong gan (dung).
- Sua 142 truong tieng Viet khong dau (ca post_title). Con 0 chuoi khong dau.
- Them nut "Chon lai" trong thanh tong (hien khi da tick, bam -> bo tick het).
- FIX DARK MODE: card mobile bi background:#fff cung + nut .pick-btn dung color:var(--navy) -> chu tang hinh.
  Da them block [data-theme="dark"] override. Tuong phan nut: 16.29:1 (chuan WCAG >= 4.5). DGC_VER 1.4.3.

## 2026-07-14 (tối) - Quét NCC mở rộng + tìm kiếm toàn trang + sửa dark mode

**Kho bảng giá:** 40 -> **87 NCC**, 1.071 -> **1.302 dòng**.
- VN mới: MOMD, WIFIM, SEO Center, Vua Web Digi, Backlink.com.vn, Tenmienngon, BICTweb,
  Trần Tiến Duy, WINNET, IT Sài Gòn, Seo Tips Trick, Giao Diện Giá Tốt, Đánh Giá Thương Hiệu,
  Top10Riviu, HCMtoplist, Quảng Ninh Có Gì, Cotrang.
- **Quốc tế (mới, dịch vụ `backlink-quocte`, 109 dòng):** FATJOE, Searcharoo, Loganix, Rhino Rank,
  Editorial.Link, uSERP, OutreachZ, Stellar SEO, LinkBuilder.io, Rankifyer + phân phối PR
  (PR Newswire, Business Wire, GlobeNewswire, EIN Presswire, PRWeb, eReleases, Newswire.com,
  PRUnderground, ACCESS Newswire, 24-7PressRelease, Issuewire, openPR, PRLog, MediaBoost,
  King Newswire, Baden Bower). Quy đổi USD x26.000, EUR x28.000.
- **Booking truyền hình (mới, `booking-tv`, 36 dòng):** MediaLabs, Fame Media (VTV/HTV), AE Digi,
  VSM Group, TVAd rate card. Chưa có giá số công khai cho: chạy chữ, THVL, VTC, đài tỉnh (chỉ ảnh/PDF).

**Web (DGC_VER 1.4.7):**
- Tìm kiếm bảng giá: "Báo Thanh Niên" = "thanh niên" = "thanhnien.vn" (khoá nén, bỏ dấu/tên miền/tiền tố "báo").
- Tìm kiếm toàn trang mới (`search.php`): tách kết quả **Bảng giá** / **Bài viết**.
- Ưu đãi: hiện trên MỌI trang, có số tiền "tiết kiệm tối đa 25 triệu/đơn" (tính từ giá thật), popup dẫn về bảng giá.
- Nút "Nhận báo giá" (trang chủ) -> `/bang-gia/`.
- Đơn vị bán: booking = "báo", còn lại = "trang".
- Sửa dark mode: thẻ đầu báo (chữ trắng/nền trắng), khối bảng giá trang dịch vụ (nền #fff cứng), nút Zalo.
- Sửa 3 bước trang cảm ơn bị bóp 3 cột trên mobile (style inline đè media query).
- Bỏ thuật ngữ "bài chuẩn SEO" toàn site -> "viết bài PR".

### Bổ sung cùng phiên - mở 2 nhóm dịch vụ mới lên web (DGC_VER 1.5.0)

- **Bảng giá live: 540 -> 673 dòng, 6 -> 8 tab.** Thêm `backlink-quoc-te` (100 dòng) và
  `booking-truyen-hinh` (33 dòng). Backup trước import: `~/Claude-Workspace/_backups/routines/2026-07-14/bang-gia-import/dgc_gia_truoc_2nhom.json` (540 bản ghi).
- Siết `KEY_CHI_TIET` trong `export-web.py`: 2 nhóm mới gộp theo `nhom + vi_tri + quy_cach`,
  tránh bán TVC VTV1 (105tr) bằng giá phóng sự (40tr).
- `is_soft()` chặt hơn: loại cả "gia mem"/"gia tu" trong ghi_chu (1 dòng gói bản tin VTV đã lọt lưới).
- Phục hồi dấu tiếng Việt cho toàn bộ 133 dòng mới (dữ liệu bóc về là ASCII).
- Xoá "khong ap dung" ở field so_link của 33 dòng truyền hình (truyền hình không có link).

**UI:** đếm ngược chạy tới **phút:giây**, nhảy từng giây (cả khối ưu đãi lẫn popup);
khối ưu đãi có **nền màu brand nổi bật** (gradient xanh nhạt, viền trên đậm - sáng lẫn tối);
nút CTA co theo nội dung thay vì kéo full-width để chữ dính trái.

### 2026-07-15 - 2 trang dịch vụ mới + rà soát toàn site (DGC_VER 1.5.1)

- **Trang dịch vụ mới**: `/dich-vu/backlink-quoc-te/` và `/dich-vu/booking-truyen-hinh/`
  (nội dung thật, nêu rõ hạn chế: PR quốc tế phần lớn nofollow; truyền hình KHÔNG tạo backlink).
- **Rà soát toàn site**: thêm vào menu (con của "Dịch vụ"), hub `/dich-vu/`, section dịch vụ
  trang chủ (có icon riêng), `dgc_current_nhom()` (để trang dịch vụ render được bảng giá).
- **Logo**: gán `url_bao` cho 33 dòng truyền hình -> VTV/HTV kéo được logo thật (trước rơi về chữ cái).
- **Giá truyền hình +20%** (33 dòng).
- **Rà lại TOÀN BỘ giá** theo kho mới nhất: 520/544 dòng đã đúng giá mới; sửa 3 dòng
  (Angiangtv 890k->1,1tr và baohungyen 1,2tr->2,1tr đang **bán dưới giá vốn**; baotayninh hạ còn 1,45tr).
  Giữ 21 dòng tầng cao cấp (hạ xuống = bán dưới giá vốn). Chặn 30 dòng textlink bảng bậc thang.
- **Ghi chú "giá tham khảo"** (`inc/price-note.php`) ở mọi nơi có giá + nút Gọi/Zalo.
- **Nút sổ "Gói gồm những gì?"** cho mọi dòng gói (220 nút ở bảng giá tổng hợp).
- **Rà soát hệ nút**: bỏ `btn-navy` khỏi nền sáng, thu về 3 lớp (chính/phụ/chip). Tab active
  đổi từ nền đen sang màu brand; 8 tab cuộn ngang 1 hàng trên mobile. Hero dịch vụ còn 2 nút.
- Đổi "+ Chọn báo này / trang này" -> **"+ Chọn ngay"**.

### 2026-07-15 (chiều) - Giá tham khảo gọn + Giới thiệu báo/trang (DGC_VER 1.5.2)
- Bỏ thanh "giá tham khảo" nổi bật + CTA giữa bảng, thay bằng dòng chữ nhỏ cuối bảng (popup đã đủ kêu gọi).
- Thêm dòng "Giới thiệu báo/trang này" mỗi dòng bảng giá (563 trang + 228 báo): sổ ra tổng quan/uy tín/ngành/SEO-GEO/ước tính tăng trưởng, sinh tự động từ DR+ngành+loại link.
- Deploy 8 file, lint OK, purge cache, verify curl.
- 2026-07-15: sel-bar desktop đổi sang nền xanh brand đặc + CTA trắng (tương phản hẳn) - DGC_VER 1.5.3.
- 2026-07-15: intro báo/trang gọn lại (xếp dọc) + TV không ép SEO/GEO; nút menu Bảng giá bỏ tô nền, chỉ gạch chân - DGC_VER 1.5.4.
- 2026-07-15: thiết kế lại khối ưu đãi cho mềm (badge bo tròn, pill mềm, gradient tint, bỏ vạch cứng) - DGC_VER 1.5.6.
- 2026-07-15: bỏ khối ưu đãi to, thay bằng pill nổi đếm ngược "Ưu đãi đến 25 triệu" (mọi trang) -> bấm mở popup -> ra bảng giá; popup bỏ auto-bật. DGC_VER 1.5.7.
- 2026-07-15: phân cấp lại màu nút toàn site - xanh đặc chỉ cho CTA quan trọng nhất; "Đặt ngay" mỗi dòng bảng giá hạ xuống ghost chữ xanh (bỏ xanh đặc lặp 500+ lần). DGC_VER 1.5.9.
- 2026-07-15: thiết kế lại thanh chọn nhẹ nhàng - nền sáng phớt teal, số + CTA màu teal (bỏ slab xanh dương đặc). DGC_VER 1.6.0.
- 2026-07-15: pill ưu đãi chuyển sang phải (trên nút Zalo), thu gọn, đổi sang nền trắng viền nhẹ (bỏ khối xanh nổi bật). DGC_VER 1.6.1.
- 2026-07-15: thanh chọn đổi sang dải gradient xanh->teal giống .cta-band (bỏ bản phớt teal bị chê xấu). DGC_VER 1.6.2.
- 2026-07-15: "Giới thiệu báo" đổi từ xổ dọc sang popup (không kéo dài trang); pill ưu đãi đổi màu nóng cam->đỏ. DGC_VER 1.6.4.
- 2026-07-15: pill ưu đãi cam hết + chữ trắng + thu nhỏ; nút Zalo đổi sang trắng chữ xanh. DGC_VER 1.6.5.
- 2026-07-15: Zalo đơn giản hoá - chỉ chữ "Zalo" xanh, bỏ bong bóng + nền/viền tròn. DGC_VER 1.6.6.
- 2026-07-15: pill ưu đãi -> ribbon trên cùng (bỏ pill nổi); mobile ẩn nút gửi khi chưa chọn; "Giới thiệu báo" rút còn icon "i". DGC_VER 1.6.8.

## 2026-07-15 (tiếp) - UI batch: section dịch vụ + Zalo + ribbon ghim + icon "i" (DGC_VER 1.6.9)
- Section "Off-page SEO" trang chủ: bỏ lưới nhóm-card lệch (chỉ 2 card), thay bằng lưới 4x2 **card-link** gọn, mỗi dịch vụ link thẳng tới trang dịch vụ (7 pillar + 1 ô "Tất cả dịch vụ" -> /dich-vu/). `front-page.php` + `.svc-links` CSS.
- Nút Zalo nổi: bọc lại **vòng tròn trắng, viền xanh nhạt** (#D6E4FF), chữ Zalo xanh. `.fab-zalo` 58px tròn.
- Ribbon ưu đãi trên cùng: **GHIM sticky top:0** (position:sticky+z60); JS đo chiều cao ribbon -> biến `--ribbon-h`, header + sel-bar tự đẩy xuống dưới ribbon (top:var(--ribbon-h)).
- Icon giới thiệu báo: chuyển "i" thành **superscript ngay sau tên báo** (vertical-align:super, 15px) thay vì dòng riêng bên dưới. `cpt-gia.php` đưa button vào trong `.row-name`.
- CÒN LẠI: chat AI tư vấn (connect Claude) ngay dưới ribbon - đang chờ Hiếu chốt hướng (API key + chi phí).

## 2026-07-15 (tiếp 2) - Chat AI tư vấn DeepSeek (DGC_VER 1.7.0)
- Thêm widget chat AI ở trang chủ (dưới ribbon), dùng DeepSeek (như chatbot Zalo ICD).
- Server: inc/ai-chat.php (key ở wp-config/option, endpoint admin-ajax, rate-limit 30/giờ/IP,
  system prompt nạp 7 dịch vụ + khoảng giá thật từ CPT dgc_gia, ràng buộc không bịa giá/đầu báo).
- WP Admin > DigicomVN mục 8: bật/tắt + nhập key + câu chào + gợi ý + kiến thức bổ sung.
- MẶC ĐỊNH TẮT (ai_chat_on=0, chưa key) -> chưa hiện, chưa tốn phí. Hiếu bật khi có key DeepSeek.
- Chi tiết: .claude/rules/ai-chat-deepseek.md

## 2026-07-15 (tiếp 3) - Chỉnh ảnh chân dung testimonial
- 5 ảnh testimonial (400x400) phần lớn lệch/mờ. Xử lý: cắt căn giữa mặt + upscale 600 + làm nét (UnsharpMask) + autocontrast.
  - luan, hoang: đã chuẩn, chỉ làm nét/upscale.
  - thang: bỏ vệt cung xanh (avatar cũ) ở góc trên-trái, căn giữa, thẳng.
  - vinh: mặt lệch trái -> căn giữa lại, có headroom.
- Deploy tên mới `-hd.jpg` (tránh cache tĩnh 7 ngày theo URL), update URL trong option dgc_settings.testimonials. Ảnh gốc + option backup: _backups/routines/2026-07-15/tm-portraits/.
- CHỜ HIẾU: dung.jpg (Bà Lê Phương Dung) cúi mặt/nhắm mắt - KHÔNG thể thành "góc thẳng" bằng cắt, cần thay ảnh.
- dung.jpg: THAY ảnh mới (Hiếu chọn "thay chân dung nữ chuyên nghiệp"). Nguồn Pexels id 8101987
  (nữ Việt/ĐNÁ, blazer, mắt nhìn thẳng, cười nhẹ, bối cảnh văn phòng) - license Pexels free,
  cho thương mại, không bắt ghi credit. Đã cắt cận mặt (bỏ người phía sau), làm nét, deploy dung-hd.jpg.
  -> Cả 5 testimonial giờ dùng ảnh -hd, căn giữa/góc thẳng/nét.

## 2026-07-15 (tiếp 4) - Menu/breadcrumb href, trang thừa, Đặt ngay, chi tiết gói (DGC_VER 1.7.1)
- Menu "Dịch vụ" (item 535) là custom link "#" -> đổi _menu_item_url = /dich-vu/ (link tới hub, page 440).
- Breadcrumb tpl-service.php: "Dịch vụ" giờ là link /dich-vu/ (trước là chữ trơn).
- Nút "Đặt ngay" mỗi dòng bảng giá: JS tự tick chính báo/gói đó rồi chuyển sang /dat-bai/ kèm ?selected (order-now handler trong sel-bar IIFE main.js).
- Gói (Tier 1/Basic/...): thêm field WP Admin `goi_sites` (mỗi dòng: tên site | DR | ghi chú) -> hiển thị bảng "Site trong gói + DR/DA" trong "Gói gồm những gì?". Chưa nhập -> ghi "danh sách gửi khi báo giá" (KHÔNG bịa site/DR). Dữ liệu gói hiện KHÔNG có sẵn danh sách site -> Hiếu nhập khi có từ NCC.
- Rà 65 trang: TRASH 22 trang rác/thừa/trùng (Sample Page, Cart, Checkout, Dashboard, Student/Instructor Registration, 4 trang Khóa học, Portfolio, Case Study cũ, Tài nguyên, google-maps/chatbot-ai/viet-bai *-old-draft, Về chúng tôi + Giới thiệu (trùng ve-digicom), PR Báo chí, Entity Branding, Chăm sóc website). Đưa vào THÙNG RÁC (khôi phục được), KHÔNG xoá vĩnh viễn.
  GIỮ: draft giai đoạn 2 (ten-mien/hosting/lap-trinh-website/ban-quyen-*/google-workspace/office-365/automation/google-ads/dich-vu-seo/thiet-ke-website), trang pháp lý (chinh-sach-cookie, chinh-sach-hoan-tien), front page (215).

## 2026-07-15 (tiếp 5) - Dời ô chat AI xuống section 2
- Ô chat AI (dgc_ai_chat_box) trước nằm TRÊN hero (đẩy hero xuống) -> chuyển xuống NGAY SAU hero
  (section 2), trước khối dịch vụ. Chỉ đổi vị trí trong front-page.php, không đổi style (CSS đã
  dùng biến semantic nên tự khớp giao diện sáng).
- Verify: bật tạm trên live qua wp eval -> curl xác nhận thứ tự DOM hero(189)->chat(226)->services(258)
  -> tắt lại ngay (chat vẫn OFF, chưa key). Backup: _backups/routines/2026-07-15/digicom-chat-section2/.

## 2026-07-15 (tiếp 6) - Batch: ảnh 16:9, cuộn vô hạn search, trang toplist, routine tuần
- ẢNH BÀI VIẾT: ảnh chuẩn 16:9 (1200x675) bị nhét khung 16/7 (single desktop) + 16/10 (blog card, single mobile) -> CẮT trên/dưới. Đổi tất cả về 16/9 mọi breakpoint -> hiện full ảnh. (main.css)
- CUỘN VÔ HẠN TÌM KIẾM: search.php chỉ hiện 20/124 bài. Thêm AJAX dgc_search_more (functions.php) + JS IntersectionObserver trong search.php -> nạp 20/lần khi cuộn tới cuối (max 7 trang). Verify AJAX trả 20 bài/trang.
- TRANG DỊCH VỤ TOPLIST: tạo page /dich-vu/dich-vu-toplist/ (id 2113, tpl-service.php, 15 dòng giá + thân bài 4 mục). Thêm vào lưới dịch vụ trang chủ (8 dịch vụ 4x2 + link "Xem tất cả") và hub /dich-vu/ (giờ list đủ 8 dịch vụ). Thêm 3 icon: star/globe/tv.
- ROUTINE TUẦN: tạo scheduled task `digicom-gia-doi-tac-tuan` (thứ Hai 10h) - quét rộng giá + đối tác 6 nhóm (booking báo/toplist/guest post/textlink/backlink+entity/truyền hình), dựng master, export ẩn NCC, ĐẨY LÊN LIVE (import-wp merge), log CHANGELOG. Bổ sung bước điền goi_sites (list site trong gói) từ nguồn NCC công khai.
- LIST SITE TRONG GÓI: cơ chế goi_sites đã có (render list khi field có dữ liệu). Hiện 0 gói có data; Solann (NCC Social Entity) KHÔNG công bố list site công khai -> không điền được từ web, KHÔNG bịa. Chờ Hiếu gửi list gói + routine tự quét bên nào công bố. DGC_VER 1.7.2.

## 2026-07-15 (tiếp 7) - Search auto-chọn + 15 site toplist SEODO
- SEARCH auto-chọn: bấm kết quả bảng giá -> /dat-bai/?selected=<mục>&subtotal -> trang Đặt bài TỰ điền
  mục + tạm tính (thay vì nhảy về bảng giá). Sửa dgc_search_gia() (inc/cpt-gia.php). Verify: bấm Soha ->
  đặt bài điền "Soha.vn - Bài stream trang chủ" + 4.600.000đ.
- 15 SITE TOPLIST SEODO: từ sheet Hiếu gửi (gid 899451809). Thêm vào raw/ncc-khac.csv -> build_master
  (1302->1317) -> export-web (ẩn NCC, giá rẻ nhất) -> import-wp merge (dgc_gia 673->688, 15 mới, 0 trùng).
  Toplist trên web: 20->35 site. Giá 1tr (inhat.vn 1,7tr), 2 link dofollow, 1000 từ 3-5 ảnh.
- SEODO 7 tab còn lại (booking báo 246, báo tỉnh 41, guest post 45, textlink gói, PR site 35, toplist ngành)
  -> ghi nguon.md + giao routine tuần tích hợp (đối chiếu tay giá vốn). CHANGELOG cập nhật.

## 2026-07-15 (tiếp 8) - Ghép 55 outlet booking báo/báo tỉnh SEODO
- Parse 2 tab sạch nhất của SEODO (booking báo 246 + báo tỉnh 41): lấy THÀNH TIỀN (giá thấp nhất
  trong đơn giá/thành tiền/thanh toán VAT). Chỉ thêm 55 outlet CHƯA có trên live (an toàn tuyệt đối,
  0 trùng, không refresh giá cũ -> không thể bán dưới giá vốn). booking-bao-pr 228->283, dgc_gia ->743.
- Sửa lỗi regex cắt cụt domain đa cấp (.gov.vn/.org.vn). "Cùng site 2 dịch vụ" (baogialai textlink+booking)
  KHÔNG phải trùng - giữ.
- 5 tab lộn xộn còn lại (guest post flags TRUE/FALSE, pasgo toplist ma trận, textlink gói V1-V5,
  toplist ngành TOP1-5) -> giao routine (parse cẩn thận, đối chiếu tay), đã ghi nguon.md.

## 2026-07-16 - Cau truc trang dich vu tối ưu (quét 15 site top "booking báo")
- Quét SERP google.vn cụm "booking báo chí": 15 site (kmedia, tinhhoamedia, itify, zafago,
  hunteragency, bookbaopr, seovip, chobao, songkim, peakagency, ecpmedia + 2 blog + 2 listicle).
  Fetch cấu trúc 6 trang dịch vụ mạnh nhất -> rút pattern chung.
- Phát hiện: nhiều block "thiếu" (đầu báo, vì sao chọn, testimonials, FAQ) ĐÃ có data+render ở
  front-page nhưng chưa cắm vào trang dịch vụ (tpl-service). Chỉ "... là gì" là thực sự thiếu.
- Tách 4 partial dùng chung 1 nguồn: inc/blk-reasons.php, blk-press-partners.php,
  blk-testimonials.php, blk-faq.php (front-page + tpl-service cùng include).
- Thêm block "... là gì": inc/svc-intro.php + option svc_intros (WP Admin muc 2), keyed theo slug.
  Default san cho booking-bao-pr, guest-post, mua-textlink, dich-vu-backlink. Bat intent + GEO.
- tpl-service thứ tự mới: hero -> "là gì" -> bảng giá+quy trình -> content -> đầu báo -> vì sao
  chọn -> testimonials -> FAQ -> form -> CTA. CSS .svc-intro (dark-mode ready). DGC_VER 1.7.2->1.7.3.
- Lint PHP sạch 9 file. Local đang tắt (502) -> chưa QA trực quan. Backup:
  _backups/routines/2026-07-16/digicom-service-structure/ (tpl-service, front-page, options gốc).

## 2026-07-16 (2) - FLATTEN cau truc: bo hub /dich-vu/, pillar len goc
- Hieu quyet bo trang hub /dich-vu/, dua 8 pillar len goc (/booking-bao-pr/...). Phan bo link tu trang chu.
- CODE THEME (xong, lint sach): 301 handler generic trong functions.php (fire khi is_404, strip
  /dich-vu/ -> URL moi; hub -> trang chu; tu tuan tu, khong vong lap). Sua het link cung 8 pillar
  ve goc (front-page, footer, header, page-bang-gia, ai-chat, breadcrumb tpl-service). Bo nut/hub
  card thua. dgc_is_service_page() bo phu thuoc trang hub -> dua dgc_current_nhom. page-dich-vu.php dead.
- DB (CHUA chay - can WP): script _migration/2026-07-16-flatten-dichvu/migrate.sh
  (backup DB -> reparent 8 pillar post_parent=0 -> hub draft -> flush rewrite). Local dang tat (502).
- Backup theme goc: _backups/routines/2026-07-16/digicom-service-structure/.
- CON LAI: chay migrate.sh tren Local (verify) roi deploy live, HOAC chay thang live qua SSH (co backup).
  Kiem menu WP (go item 'Dich vu' tro hub neu la custom link).

## 2026-07-16 (3) - DA THUC THI FLATTEN TREN LIVE (digicomvn.com) - XONG
- Backup live: ~/backups/flatten-20260716-135425/ (db-before.sql 9.8M mysqldump + theme-before.tar.gz 1.1M).
  Luu y: wp db export HONG tren host (EXIT 255) -> dung mysqldump truc tiep (ghi vao deploy.md).
- Deploy 15 file theme (10 sua + 5 partial moi) + main.css, DGC_VER 1.7.3. Remote php -l sach.
- DB: reparent 8 pillar (505,268,506,475,2113,1621,2106,2107) post_parent=0; hub 440 -> draft; rewrite flush.
- Menu primary (term 11): sua 3 item custom (535 Dich vu->/#services, 2108 backlink-quoc-te, 2109 booking-truyen-hinh);
  item post_type tu cap nhat URL.
- search-replace noi dung: 8 prefix pillar /dich-vu/<slug>/ -> /<slug>/ (tong 120 thay the) - sua link con 15 bao hardcode.
- Purge wp cache + litespeed. VERIFY curl: URL moi 200; URL cu (pillar/con bao/bat-dong-san/hub) 301 dung dich;
  0 link /dich-vu/ noi bo con sot; sitemap da doi URL moi. HOAN TAT.

## 2026-07-16 (4) - "Dich vu" thanh nut TRAI RA (khong dieu huong) - live, verified
- Desktop nav + drawer mobile: item cha "Dich vu" (menu-item-has-children) -> click preventDefault
  + toggle .dgc-open, KHONG chuyen trang. Drawer accordion (submenu an mac dinh, caret xoay).
- Bottom-nav mobile: "Dich vu" doi tu <a> sang <button data-svc-sheet> -> mo BOTTOM SHEET liet ke
  8 dich vu (helper dgc_service_links). Dong bang X / overlay / ESC.
- Files: functions.php (helper + DGC_VER 1.7.4), footer.php (button + sheet markup),
  main.js (2 IIFE: menu toggle + sheet), main.css (desktop .dgc-open, drawer accordion+caret, .svc-sheet*).
- Them "Dich vu Toplist" (2113) vao menu primary (truoc thieu, chi 7/8) -> dong bo 8 dich vu ca 3 mat.
- Deploy live + purge. Browser test that (375px + desktop): desktop no-nav+xo submenu OK;
  bottom sheet mo/dong (X/overlay) 8 link OK; drawer accordion an->mo->an OK. Backup theme trong tar 135425.

## 2026-07-16 (tiếp) - Chuyển 15 trang con booking báo thành bài blog
- Đăng 15 bài `/book-bao-<bao>/` (post 2189, 2192-2205), category booking-bao-pr, mỗi bài nhúng bảng giá động `[dgc_bang_gia]` (giá tự cập nhật theo CPT dgc_gia).
- 15 trang con cũ `/booking-bao-pr/<bao>/` (508-512, 1300-1309) -> draft; handler 404 tự 301 về bài mới. Verify: 15/15 bài 200, 15/15 URL cũ 301 đúng đích, bảng giá render.
- search-replace 53 link nội bộ cũ -> URL bài mới (giữ nguyên pillar /booking-bao-pr/).
- Lưu ý: /dich-vu-backlink/bat-dong-san/ KHÔNG chuyển (Hiếu thu hẹp scope chỉ các bài báo giá booking lẻ).

## 2026-07-16 (tiếp) - Mở 3 dịch vụ mới: QC loa phường / phát thanh / màn LED
- 3 agent quét Google (>=50 kết quả/từ khoá) -> 219 dòng giá thô; lọc "giá từ" + combo ẩn danh,
  phục hồi dấu (299 chuỗi), markup x1,20 -> import 193 dòng (loa phường 18, phát thanh 82, màn LED 93).
- Theme: khai 3 nhóm ở cpt-gia/page-bang-gia/front-page/functions (11 dịch vụ), intro media như TV.
- Tạo 3 trang pillar (2439-2441, tpl-service.php) + menu + lưới trang chủ. Verify: 3 trang 200
  có bảng giá, tab bảng giá 20/95/84 dòng render.
- Ẩn 147 dòng không rõ nơi đăng (110 gói + 37 chung chung) theo rule mới; filter export-web.py.
- (Hiếu quyết cùng ngày) 4 nhóm media TẠM ẨN: truyền hình + loa phường + phát thanh + màn LED.
  226 dòng giá + 4 trang pillar -> draft; gỡ menu/trang chủ/tab bảng giá. Dữ liệu lưu
  10-bang-gia-booking/qc-media-cho-mo/. Verify: 4 URL 404, bảng giá + home sạch.
- Thêm biểu đồ interactive so sánh DR vào 15 bài book-bao: shortcode [dgc_dr_chart] (inc/dr-chart.php),
  DR đọc live từ CPT (cache 1h), bar chart 15 báo sắp theo DR, báo hiện tại highlight teal + badge,
  hover + animation khi cuộn tới, bấm hàng -> sang bài báo đó. Vị trí: sau mục "có gì đáng giá",
  trước bảng giá. DGC_VER 1.7.8. Verify render trên /book-bao-eva/.
- Thêm 2 widget interactive cho bài blog (inc/widgets-blog.php, DGC_VER 1.7.9):
  [dgc_budget_calc] máy tính ngân sách (giá p25-p75 THẬT từ CPT, chọn dịch vụ/DR/số lượng, CTA
  bảng giá + đặt bài) -> 21 bài cluster backlink/booking; [dgc_offpage_quiz] quiz 6 câu chấm điểm
  off-page + gợi ý dịch vụ -> 74 bài cluster SEO kiến thức. Vị trí trước H2 thứ 3 (nghỉ mắt).
  13 bài không có H2 dạng Gutenberg chuẩn -> bỏ qua. Test JS live: calc đổi giá theo slider,
  quiz ra kết quả 4/6 đúng.
| 2026-07-17 | Content pipeline đợt 1 (cụm booking báo) | Đăng mới /agency-booking-bao-chi/ (post 2569 + thumb 2570, allintitle 108); sửa /booking-bao-la-gi/ (1260): title theo biến thể allintitle 199, thêm section 4 hình thức + quiz widget + link bài mới. Plan bản 2 đã duyệt. |
- 2026-07-17: Content pipeline cụm booking báo - sửa intent C3 (listicle Top agency), sửa C2 (title Giá Booking Báo + 6 yếu tố), viết mới C4 (booking báo quốc tế 2576) + C5 (booking báo Nhân Dân 2577), thumbnail, tracker cluster-booking-bao.md. Xong 5/5 bài lẻ, còn R1-R15 refresh + A4 internal link. GSC submit chờ Chrome reconnect.
- 2026-07-17: Content pipeline cụm booking báo HOÀN TẤT - refresh 15 bài book-bao (+lĩnh vực phù hợp +link pillar P1), A4 internal link (P1 hub -> C2/C3/C4/book-bao). Cụm 20/20 bài xong. Còn GSC submit (chờ Chrome).
- 2026-07-17: Toàn site - SAPO in đậm (font-weight 600), khối "Tóm tắt nhanh" trình bày dạng quote (viền trái + nền phớt, dark mode). CSS .summary + p[1.1em] (main.css, DGC_VER 1.8.1); convert C3/C4/C5 sang .summary. Verify screenshot OK.
- 2026-07-17: Gộp box "Bài viết liên quan" về 1 (xoá block thủ công + contact trùng khỏi 17 bài); box tự động theme giờ dẫn toàn cụm (22 bài), pillar-first (single.php orderby menu_order+ID). Typography bài ít ảnh: H2 gạch phân section, H3 thanh accent, list marker màu brand (main.css DGC_VER 1.8.2).
- 2026-07-17: Dọn toàn site (không chỉ cụm booking) - xoá box "Bài viết liên quan" thủ công (10 bài) + khối liên hệ Hotline/Email trùng (53 bài, cả 3 định dạng list/p), GIỮ author-box (81 bài). Còn 0 related-articles, 0 contact trong thân bài. Box liên quan tự động theme vẫn render (verify curl). Backup strip-all-backup.json (1.7MB, 56 bài).
- 2026-07-17: Audit + vá internal link cụm booking báo. Phát hiện pillar P1 mất link xuống bài con (do bước dọn box thủ công xoá nhầm hub). Vá bằng 1 đoạn biên tập trong P1 trỏ C2/C3/C4/C5. Cụm giờ khép kín 2 chiều: con<->pillar, mọi bài->money page, box tự động dẫn cả cụm.
- 2026-07-17: Box "Bài viết liên quan" gọn lại - hiện 6 bài + <details> "Xem thêm N bài" (native, no JS), tránh liệt kê cả 22 bài. Link trong thân bài đã có màu brand + gạch chân (1.8.3). DGC_VER 1.8.4.
- 2026-07-17: Sửa 15 bài book-bao khuyết tác giả (post_author=0 -> user 1 Hiếu Đỗ). Byline + author-box giờ hiển thị đúng. Toàn site 0 bài author=0.
- 2026-07-17: Submit GSC 2 bai moi: /booking-bao-quoc-te/ + /book-bao-nhan-dan/ (deu "Da yeu cau lap chi muc"). Resubmit sitemap wp-sitemap.xml (17/7). P1/C2/C3 da submit phien truoc. Cum booking bao: 5 bai chinh deu da vao GSC.
- 2026-07-18: Regen thumbnail C3 (agency-booking-bao-chi) khớp title mới \"Top Agency...\" (media 2680, xoá cũ 2570). Cụm booking báo hoàn tất 100- 2026-07-18: Regen thumbnail C3 (agency-booking-bao-chi) khop title moi "Top Agency..." (media 2680, xoa cu 2570). Cum booking bao hoan tat, khong con viec treo.
- 2026-07-18: Toi uu category /category/booking-bao-pr/: description 1 dong -> 2-3 cau giau keyword; them link money page (dgc_cat_money_link, category.php, DGC_VER 1.8.5). Do allintitle 5/15 bao (Google chan bot) -> content/allintitle-per-bao.md. Rule moi: bai intent gia -> day gia len dau bai (SKILL.md).

## 2026-07-18 - Ảnh minh hoạ vị trí đăng bài cho 15 bài "book báo X"
Hoàn tất toàn bộ 15 bài book-bao-X: chụp ảnh thật headless Chrome từng báo (trang chủ +
chuyên mục liên quan), khoanh vùng vị trí tương ứng giá, chèn ảnh ngay sau đoạn văn nói về
vị trí đó (không dồn 1 ảnh cuối bài), giá ghi trong caption (dễ sửa khi giá đổi). Bổ sung
đường phân tách (wp:separator) giữa khối bảng giá/ảnh minh hoạ và phần bài viết theo phản hồi
Hiếu. Danh sách: CafeBiz(2195) CafeF(2196) Kenh14(2199) VnExpress(2189) DânTrí(2197) 24h(2192)
Eva(2198) aFamily(2193) TuổiTrẻ(2202) ThanhNiên(2201) VietNamNet(2203) Soha(2200)
Webtretho(2204) Znews(2205) BáoĐầuTư(2194). Backup + manifest đầy đủ tại
~/Claude-Workspace/_backups/routines/2026-07-18/vitri-minh-hoa/ và vitri-minh-hoa-separator/.

## 2026-07-18 - Bo sung Fame Media vao bang gia, gioi han web con 3 NCC
Them Fame Media (929 dong, tu Google Sheet moi) vao raw/ncc-khac.csv, xoa du lieu Fame Media cu
loi thoi tranh trung. export-web.py gioi han CHI 3 NCC len web (DanaSEO/Media Viet Nam/Fame Media,
deu khong markup); Toplist + Backlink quoc te giu ngoai le dung moi NCC (Hieu chon qua hoi dap) vi
3 ben tren khong co du lieu 2 nhom nay. Dong bo live dgc_gia: draft 375 dong khong con thuoc 3 NCC,
tao moi 943, sua gia 7. Backup + payload day du:
~/Claude-Workspace/_backups/routines/2026-07-18/famemedia-pricing/.

## 2026-07-18 - Dao lai thu tu 15 bai book-bao-X ve form cu
Theo yeu cau Hieu: H1 -> SAPO -> Tom tat -> mo bai (2 doan) -> roi moi den cac the H2, rieng H2
dau tien la Bang gia luon (thay vi Bang gia dung dau bai nhu truoc). Bo khoi separator (khong can
nua vi Bang gia gio la 1 section H2 binh thuong). Ap dung dong bo ca 15 bai, backup truoc khi sua
tai ~/Claude-Workspace/_backups/routines/2026-07-18/reorder-form-cu/.
| 2026-07-18 | Bảng giá - anh minh hoa vi tri | Sua UI popup vitri (X khong con lot ra ngoai khi cuon), them nut kinh lup mobile o moi trang, them chi dan an chu V, fix hint text wrap loi flex | Deploy DGC_VER 1.8.9 |
| 2026-07-18 | Bảng giá - fix vitri popup | 1) Sua khop domain sai: Ngoisao.vnexpress.net (chuyen trang rieng) khong con bi gan nham anh vnexpress.net (30->26 nut V). 2) Them nut Dong du phong o cuoi popup + doi vh sang dvh phong truong hop mobile Safari tinh sai chieu cao. Deploy DGC_VER 1.9.0 |
| 2026-07-18 | Bảng giá - popup nut Dong | Sua nut Dong o cuoi popup vitri/intro bi to/full-width -> gon lai (padding nho, khong keo full width). Deploy DGC_VER 1.9.1 |
| 2026-07-18 | Ảnh vị trí đăng - đợt 2 | Chụp thật + khoanh vùng + upload alt SEO cho 12 domain giá cao nhất (booking-bao-pr): vietcetera, vietnamplus, vnreview, cand.com.vn, techrum, vov.vn, vir.com.vn, nhipcaudautu, tieudung, tinhte, genk, doanhnhan.vn. Nút V: 26->50. Sổ cái vitri-ledger.csv: 775 domain, 27 done, 6 issue (site chặn/lỗi/đóng cửa), 742 còn lại |
| 2026-07-18 | Ảnh vị trí đăng - đợt 3 | Chụp + khoanh vùng + alt SEO cho 14 domain: baophapluat.vn, autopro, tapchikientruc, ngoisao.vn, nld.com.vn, vneconomy, phunuvietnam, tinthethao, nhandan.vn, vtv.vn, gamek, wiki.batdongsan, laodong.vn, congan.com.vn. Nút V: 50->72. Phát hiện thêm: hanoitimes.vn giá tiered parse lỗi, doanhnhanonile.com.vn là lỗi chính tả (đúng: doanhnhanonline.com.vn). Sổ cái: 42 done, 14 issue, 719 còn lại |
| 2026-07-18 | Ảnh vị trí đăng - đợt 4 | Chụp + khoanh vùng + alt SEO cho 16 domain: diendandoanhnghiep, thesaigontimes, doisongphapluat, marry.vn, yan.vn, thethao247, tienphong, giadinh.suckhoedoisong, 24h.com.vn (PR loại 2), vtcnews, congluan, suckhoedoisong, thitruong.nld.com.vn, yeah1.com, phunutoday, thethaovanhoa. Nút V: 72->98. Sổ cái: 58 done, 18 issue, 699 còn lại |
| 2026-07-18 | Ảnh vị trí đăng - đợt 5 | Chụp + khoanh vùng + alt SEO cho 16 domain: phunuvagiadinh, saostar, kenhtuyensinh, doanhnghiepvn, kinhtemoitruong, danviet, baoquocte, phapluat.suckhoedoisong, suckhoecongdongonline, doisongvietnam, tiin.vn, baoxaydung, baonghean, vietq, petrotimes, nguoihanoi. Nút V: 98->117. Phát hiện megafun.vn đã đổi chủ (nội dung tiếng Anh không liên quan). Sổ cái: 74 done, 22 issue, 679 còn lại |
| 2026-07-18 | Ảnh vị trí đăng - đợt 6 | Chụp + khoanh vùng + alt SEO cho 14 domain: suckhoeviet, xahoi.com.vn, vietnammoi, doanhnhanvn, tapchixaydung, golfviet, vnfinance, xaluan, techz, baoxaydung.vn, phunusuckhoe.giadinhonline, vietnambiz, thitruongbiz, thanhnienviet. Nút V: 117->132. Sổ cái: 88 done, 28 issue, 659 còn lại |
| 2026-07-19 | Vitri-images batch 9 | +11 domain (baodaklak.vn, thethaovietnam.vn, baocamau.vn, baoangiang.com.vn, baotuyenquang.com.vn, nguoidothi.net.vn, huengaynay.vn, baolangson.vn, baothainguyen.vn, thuonghieucongluan.com.vn, doanhnghiephoinhap.vn). Nut .vitri-toggle 159->170. Ledger: done 124/775, issue 31, con lai 620. |
| 2026-07-19 | Vitri-images batch 10 | +17 domain nhom booking-bao-pr/mua-textlink (baothuathienhue.vn, vanhoavaphattrien.vn, bienphong.com.vn, baotayninh.vn, vanhoavadoisong.vn, songdep.com.vn, khoahocvacuocsong.vn, vanhoathoidai.vn, vietnamhuongsac.vn, datnuoc.com.vn, truyenthongvaphattrien.vn, phapluatvacuocsong.vn, giadinhmoi.vn, baoquangninh.vn, baothanhhoa.vn, phunumoi.net.vn, reatimes.vn). Nut .vitri-toggle 170->187. Ledger: done 141/775, issue 34, con lai 600. |

## 2026-07-19 - Muc luc (TOC) cho bai blog, follow khi cuon mobile
Them `inc/toc.php`: tu quet H2/H3 trong bai (>=3 muc moi kich hoat), gan id (giu nguyen id neu
bai da co san), render hop muc luc dong gap dau bai + nut noi "Muc luc" (bottom-sheet, scroll-spy
highlight muc dang doc) hien khi cuon qua hop dau bai - dat goc TRAI de khong dam nut Zalo/promo/
to-top ben phai. Test tren Local (digicom.local/backlink/, bai 11 H2) qua curl: 47 id sinh dung,
khong loi PHP, HTML render du postToc/tocFab/tocSheet. Deploy DGC_VER 1.8.6 (dev, CHUA len live -
can deploy theo rules/deploy.md khi Hieu duyet giao dien qua browser that.

## 2026-07-19 - Fix mục lục TOC: gỡ mục lục cứng trùng, đúng vị trí sau H1
Phát hiện bài "Backlink là gì?" (ID 235) đã có sẵn 1 khối mục lục viết tay (comment
`<!-- Table of Contents -->` + div) nằm sau đoạn mở bài -> bị trùng với mục lục tự động mới
(2 mục lục cùng lúc, gây rối). Thêm bước strip khối cũ này trong `dgc_toc_process()` trước khi
sinh mục lục mới - chỉ còn đúng 1 mục lục, đặt ngay sau H1. Verify qua curl: dòng "Table of
Contents" đã biến mất, postToc vẫn đúng vị trí dòng 180 (ngay sau h1 dòng 179). Deploy DGC_VER 1.8.8.
| 2026-07-19 | Vitri-images batch 12 (retry 35 domain loi) | Retry 25 domain (timeout/SSL/lazy-load) bang Chrome headless timeout dai + ignore-cert-errors: chi 2 thanh cong (baovanhoa.vn, angiangtv.vn) - da dang. 23 domain con lai la loi that (site chet/parked/chan bot), khong sua duoc bang headless CLI - can Browser tool that (dang tam thoi unavailable) hoac Hieu tu kiem tra thu cong. Ledger: done 161/775, issue 33 (35-2), con lai 581. |

## 2026-07-19 - Fix mục lục TOC: chèn sau khối tóm tắt (nếu bài có), truoc H2 dau
Hieu bao ban live co them khoi "Tom tat noi dung chinh" (div class="summary", content-writer
sinh ra) nam sau doan mo bai - muc luc phai xep DUOI khoi nay, TRUOC H2 dau tien, khong phai
ngay sau H1 nua. Sua dgc_toc_process(): uu tien tim div class chua "summary", chen TOC ngay sau
no; khong co khoi summary (bai cu kieu "Backlink la gi") thi fallback nhu cu (ngay sau H1). Test
tren Local bang bai tao tam co ca H1 + summary + 3 H2 - dung y muon roi xoa bai test. Deploy
DGC_VER 1.9.2 (dev, CHUA len live).

## 2026-07-19 - Deploy mục lục (TOC) lên LIVE digicomvn.com
Phat hien project dir (wp-theme/digicom-host) da LECH so voi live: thieu 2 file
inc/vitri-images.php + inc/glossary.php va phan CSS/JS lien quan (popup vi tri dang bai, nho
tick bao qua localStorage) - neu ghi de nguyen functions.php/main.css/main.js tu project se XOA
mat cac tinh nang nay tren live. Xu ly: tai file that tu live lam GOC, chi CHEN them phan TOC
(1 dong require + block CSS/JS moi, khong dung file nao khac) roi moi day len, khong ghi de
nguyen file. Backup ban goc live tai
~/Claude-Workspace/_backups/routines/2026-07-19/digicom-toc-deploy/ (functions.php.orig,
main.css.orig, main.js.orig). Da purge cache + verify qua curl tren 2 bai that: /backlink/
(khong co tom tat -> TOC ngay sau H1) va /thong-cao-bao-chi-xu-ly-khung-hoang/ (co tom tat ->
TOC dung sau khoi tom tat, truoc H2 dau). Deploy DGC_VER 1.9.3.
LUU Y CHO SESSION SAU: inc/cpt-gia.php cung dang lech (gia/nhom cap nhat truc tiep tren live qua
routine gia). inc/vitri-images.php, inc/glossary.php CHUA co trong project dir - nen dong bo
nguoc ve project 1 lan de tranh lap lai rui ro ghi de nham lan sau.

## 2026-07-19 - Đồng bộ ngược project = live (đóng phần lệch đã phát hiện ở trên)
Đã copy functions.php/main.css/main.js (bản live sau khi thêm TOC) + 2 file thiếu
inc/vitri-images.php, inc/glossary.php về project dir - project giờ khớp live (trừ
inc/cpt-gia.php vẫn lệch do routine giá cập nhật thẳng trên live, biết trước, chấp nhận được).

## 2026-07-19 - Fix mục lục: tách khối rõ ràng khỏi tóm tắt + sửa nút nổi khi cuộn
Hieu bao 2 loi: (1) hop muc luc dinh lien voi khoi "Tom tat noi dung chinh" phia tren, nhin nhu
1 khoi; (2) cuon xuong nut "Muc luc" noi theo khong xuat hien. Nguyen nhan (1): link trong muc
luc bi rule global ".page-content li a" (gach chan, xanh dam) de len vi specificity cao hon,
lam muc luc nhin giong doan van thuong thay vi 1 widget rieng - da tang specificity rule link
muc luc + them vien trai mau teal + margin-top 28px + shadow nhe de tach biet ro voi tom tat
(border trai xanh action). Nguyen nhan (2): logic dua tren IntersectionObserver co the khong on
dinh moi truong hop - doi sang scroll listener + getBoundingClientRect() truc tiep (r.bottom<0
la da cuon qua het hop), don gian va chac chan hon. Da xoa dong `fab.classList.add('show')`
thua trong nhanh else (fallback trinh duyet cu) vi logic moi khong con phu thuoc IO cho phan fab.
Deploy DGC_VER 1.9.4 len live, verify qua curl (CSS/JS moi da co tren live, ver dung 1.9.4).
