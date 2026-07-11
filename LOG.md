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
