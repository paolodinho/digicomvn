# LOG - digicomvn.com

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
