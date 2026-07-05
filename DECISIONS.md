# DECISIONS - digicomvn.com

## 2026-06-27
- KHONG xoa site agency cu: build theme MOI `digicom-host` tren cung WP install,
  activate de len; theme cu `digicom-theme` + DB backup giu lai de rollback.
  Ly do: site cu la chinh brand Digicom (agency PR/SEO), can reversible (rule backup-before-edit).
- Trang chu giai doan 1: dang catalog + tra cuu ten mien (UI) + form tu van.
  Cong dang ky/thanh toan that lam o giai doan sau.
- Mau action = vermilion (#E5482C), tranh purple/indigo de chong AI-slop.

## 2026-07-02 - PIVOT: tap trung Textlink/Backlink/Guest Post/Booking bao PR
- Hieu quyet dinh doi huong: website chi tap trung 4 dich vu off-page SEO (Mua Textlink,
  Dich vu Backlink, Guest Post, Booking bao & PR) truoc, sau moi mo rong sang thiet ke
  website/ten mien/hosting. Ly do: tap trung nguon luc vao mang co the trien khai ngay.
- Da tai 5 file CSV tu khoa (backlink, pr, mua-textlink, guest-post, booking-bao, ~18.6k tu khoa
  tho, ~5.1k sau loc noise). Phat hien quan trong: 114 bien the "bao gia dang bai pr tren [ten bao]"
  - long-tail exact-match, gan nhu chua doi thu SEO rieng tung dau bao -> co hoi lon nhat.
- Chot sitemap silo: /dich-vu/ (hub) > 4 pillar > con (ngach BDS duoi backlink; tung dau bao
  duoi booking-bao-pr) - de link equity chay ve pillar, khong tach rieng "kho bao" ngang menu.
- Chon BUILD DE LEN theme `digicom-host` dang co san (khong tao site thu 3), ghi de toan bo
  noi dung ten-mien/hosting cu sang draft (khong xoa, giu reversible).
- Da build 2026-07-02: hub /dich-vu/ + 4 pillar (mua-textlink, dich-vu-backlink, guest-post,
  booking-bao-pr) + ngach bat-dong-san + 5 trang con theo dau bao (VnExpress, Kenh14, Dan Tri,
  24h, CafeF) o trang thai DRAFT (chua xac nhan bao that hop tac - KHONG bia case study).
  Rebuild menu (dropdown Dich vu), front-page.php, options.php, page-bang-gia.php.
  Backup DB + theme truoc khi sua: `_backups/2026-07-02/pivot-build/`.

## 2026-07-03 - Audit internal link blog (thuat toan attractor, /internal-link-audit)
- Trich link that tu post_content 96 bai publish qua WP-CLI eval-file (629 link noi bo),
  chay thuat toan attractor (khong dem inlink tho) de tim pillar/cluster that.
- Phat hien 5 pillar that: /backlink/ (19 bai), /on-page-seo/ (16), /technical-seo/ (11),
  /schema-markup/ (6), /google-search-console/ (5). 37/96 bai (~39%) chua thuoc cluster nao.
- MISMATCH CHIEN LUOC: 91/96 bai la kho kien thuc SEO tong quat tu thoi agency cu (SEO
  onpage/technical/tool/thuat toan Google...), KHONG map vao 4 dich vu hien tai. Chi 2 bai
  moi (textlink-khac-backlink-the-nao, guest-post-la-gi) dung huong, link dung ra money page
  moi. Money page /dich-vu/booking-bao-pr/ va /dich-vu/mua-textlink/ gan nhu chua co bai
  blog nao ho tro SEO.
- LOI KY THUAT phat hien: ~89 bai cluster /backlink/ cu dang link ra URL phang
  `/dich-vu-backlink/` - day KHONG con la trang dich vu tien (da bi 1 bai blog cu, post ID 227,
  chiem slug) - trang pillar that nam o `/dich-vu/dich-vu-backlink/` (page ID 268). Link equity
  dang chay sai dich.
- Da cap nhat `.claude/context/brand-info.md` muc 4 + 7 khop pivot 2026-07-02 (ban cu tu
  2026-06-10 con mo ta cau truc agency cu, gay sai lech khi chay skill generic).
- HIEU QUYET DINH: chuyen draft NGAY 73 bai thuoc 7 category khong lien quan (On-page/
  Technical, Content/Keyword, Kien thuc SEO, Local SEO/Entity, Thuat toan Google,
  SEO E-commerce, SEO AI/GEO). Giu publish 23 bai category "Backlink & Off-page"
  (gom 2 bai moi Textlink/Guest Post).
- Da thuc thi 2026-07-03: backup DB truoc (`_backups/2026-07-03/draft-73-bai/
  digicom-db-before-draft-73.sql`), chuyen draft 73/73 bai thanh cong qua wp_update_post,
  sua 12 bai con lai co link `/dich-vu-backlink/` cu sang pillar that
  `/dich-vu/dich-vu-backlink/`, verify khong con bai publish nao link chet toi bai da draft.
  Con 23 bai publish + 2 page dich vu moi + cac trang he thong.

## 2026-07-03 - Doi chieu 6 file tu khoa that, viet 4 bai P0
- Doi chieu 18.555 tu khoa (dedup tu 6 file backlink/pr/pr-bao/mua-textlink/guest-post/
  booking-bao) voi 23 bai dang publish. Loc rieng file "pr" (14.350 tu khoa, da so nhieu:
  Canada PR, Adobe Premiere Pro, tissot PR100...) xuong 1.716 tu lien quan that bang
  regex whitelist bao chi/dang bai. Tong 6.071 tu khoa dung duoc.
- Phat hien: cum Mua Textlink chi co 6 tu khoa nhung tu chinh "mua textlink" 2.900
  volume/thang, KD 17 - tot nhung 0 bai ho tro. Cum Booking bao & PR: 1.981 tu khoa lien
  quan, 0 bai. Cum Guest Post: 333 tu khoa, 1/6 nhom chu de co bai. Cum Backlink: du noi
  dung (23 bai) nhung 2 diem hong (ngach BDS chua co bai; ~89 bai cu link sai URL da fix
  truoc do o muc audit).
- Xuat catalog dang Artifact HTML cho Hieu duyet, Hieu chon "viet ngay 4 bai P0".
- Da viet + dang 4 bai qua CONTENT-WRITER agent (song song) + WP-CLI:
  1. mua-textlink-la-gi (ID 1258, cat backlink-offpage)
  2. dich-vu-backlink-gia-bao-nhieu (ID 1259, cat backlink-offpage, thay the goc do
     "backlink" cu dang la dinh nghia bang goc do mua hang/gia)
  3. booking-bao-la-gi (ID 1260, cat MOI "booking-bao-pr" da tao term_id 24)
  4. bao-gia-dang-bai-pr-theo-dau-bao (ID 1261, cung cat booking-bao-pr, dung dung so
     gia that tu CPT dgc_gia cho Kenh14/24h/CafeF/VnExpress, KHONG bia cho Dan Tri vi
     chua co du lieu, khong khang dinh da hop tac voi bao nao - chi noi "ho tro booking").
- LOI KY THUAT phat hien khi QA: theme khong co single.php, fallback index.php tu render
  `<h1>the_title()</h1>` cho MOI single post trong khi noi dung Gutenberg cua content-writer
  skill cung luon co H1 rieng -> trung 2 the H1 tren toan bo blog (tat ca ~27-96 bai).
  Da tao `single.php` moi (bo H1-tu-title), nhung dieu nay lam LO ra 13 bai (12 bai cu +
  post 545 textlink-khac-backlink-the-nao) dang KHONG co H1 rieng trong noi dung, chi dua
  vao H1 tu dong cua theme -> da chen bo sung H1 (lay tu post_title) cho ca 13 bai qua
  script PHP, verify lai toan bo 27 bai publish dung 1 H1/bai.
- Viet tiep 8 bai P1/P2 con lai trong danh muc (8 agent CONTENT-WRITER song song), dang len
  WP qua WP-CLI (ID 1275-1282): dich-vu-guest-post-gia-bao-nhieu, backlink-bat-dong-san,
  cach-viet-bai-pr-chuan-bao-chi, top-site-guest-post-uy-tin, mua-textlink-edu-gov,
  chien-dich-pr-an-tuong-viet-nam (KHONG gan ten thuong hieu/case study cu the - viet theo
  LOAI hinh chien dich vi khong xac minh duoc so lieu that, an toan hon cho content-professional),
  quy-trinh-trien-khai-guest-post, so-sanh-booking-bao-pr-va-quang-cao-bao. Tong 35 bai dang
  publish (23 cu + 12 moi dot nay). Verify het: HTTP 200 + dung 1 H1/bai, khong em dash.
  File nguon luu tai `_content-p1/` va `_content-p2/` trong project (chua commit).

## 2026-07-03 (cap nhat 2) - Xac nhan doi tac bao chi that, publish 5 trang con
- Hieu xac nhan (truc tiep, qua AskUserQuestion) Digicom/Digito Combat THAT SU co quan he
  dat bai/booking voi cac dau bao trong bang gia CPT dgc_gia (khong phai bia) - truoc do da
  hoi lai vi nghi ngo "doi tac" vs "co the booking qua kenh trung gian" la 2 muc do khac nhau,
  Hieu chon giu nguyen tu "doi tac" vi da co quan he that.
- Chon 16 dau bao lon nhat/quen thuoc nhat trong 92 dau bao co gia (VnExpress, Dan Tri, Tuoi
  Tre, Thanh Nien, VietNamNet, Lao Dong, Tien Phong, VOV, VTV, Nhan Dan, Kenh14, 24h, CafeF,
  Zing News, Soha, Nguoi Dua Tin) -> them option field moi `press_partners` (WP Admin > Digicom
  > muc 7) + section "Dau bao Digicom ho tro dat bai, booking PR" tren trang chu (chip grid,
  khong dung logo anh vi chua co file that - chi dung text, dung rule "khong SVG/anh gia").
- Publish 5 trang con booking-bao-pr da dung san tu truoc (vnexpress, kenh14, dan-tri, 24h,
  cafef - post ID 508-512) tu draft sang publish, vi da co xac nhan hop tac that.
- Sync theme, ghi lai brand-info.md/dich-vu.md khong can sua them (danh sach dau bao van
  nam trong theme option, khong hardcode PHP).
- Hieu yeu cau tai logo that ve thay vi chi hien ten chu. Tai duoc 15/16 logo that truc tiep
  tu website chinh thuc tung bao (favicon/apple-touch-icon, mot so phai do URL CDN that tu
  HTML nguon vi favicon.ico mac dinh bi chan/404: cafef/kenh14/soha/tuoitre/vtv dung CDN
  rieng static.mediacdn.vn, kenh14cdn.com, sohanews.sohacdn.com). Rieng Lao Dong (laodong.vn)
  khong tim duoc file logo/icon nao khả dung - GIU nguyen dang chu, khong bia/ve logo gia.
  Convert ve PNG bang sips, luu tai wp-content/uploads/press-logos/, doi cau truc option
  `press_partners` thanh "ten bao | ten file logo" de sua duoc tu WP Admin.
- Tim tiep logo Lao Dong theo yeu cau Hieu: laodong.vn co bot-protection (Cloudrity, JS
  cookie-challenge) chan het favicon/apple-touch-icon qua curl. Tim thay qua Wikipedia tieng
  Viet (bai "Lao Dong (bao)") -> anh trong infobox tren Wikimedia Commons
  (upload.wikimedia.org/wikipedia/commons/5/51/Báo_Lao_Động.png, 250x62, dang logo wordmark
  that, khong phai favicon) - da xem lai anh xac nhan dung logo "LAO DONG" chu do + sao vang.
  Gio du 16/16 dau bao co logo that.

## 2026-07-04 - Redesign giao dien (chong AI-slop) + cau truc landing CVR
- Hieu che giao dien cu "bi AI": section lap nhip, blob/grain gimmick, thieu yeu to con nguoi.
  Tham chieu bo cuc + cach xu ly mau: thienkhoi.com (KHONG lay mau thien khoi).
- Chot he mau theo LOGO GOC Digicom: xanh duong #0048D8 (chinh) + teal #00AE9C (nhan),
  navy dam #0A2A66/#0B2350 cho section toi. Bo cam vermilion #E5482C cu.
- Minh hoa: SVG flat tu ve theo mau brand (loa PR, the bao, mang link) - khong stock,
  khong vuong ban quyen. Anh doi ngu that Hieu cung cap (4 anh, luu uploads/team/):
  dung TIET CHE - chi 1 section "doi ngu" (collage), khong spam; anh nen mo opacity
  ~10-16% phu mau brand khi can nen co nguoi ma khong ro mat.
- Cau truc landing pillar chot (thu tu khoa hoc, CVR cao): 1) Hero + CTA + 3 cam ket
  2) Logo khach (social proof som) 3) Khoi DICH VU noi cho toi (la gi -> loai -> tieu chi
  -> quy trinh -> cam ket) 4) Gia minh bach 5) Case study du an 6) Kinh nghiem + doi ngu
  (1 section duy nhat) 7) Testimonial 8) FAQ (xu ly phan doi) 9) CTA cuoi.
- Case study: Hieu duyet dung so lieu MAU an danh theo nganh (San BDS Ha Noi, chuoi nha khoa,
  noi that TMDT...) - KHONG gan ten thuong hieu that; sua duoc tu WP Admin. Logo khach:
  dat wordmark mau, cho Hieu gui logo khach that de thay.
- Thu tu trien khai: pillar Dich vu Backlink lam mau -> port theme + seed wp-cli -> nhan
  sang 3 pillar con lai. Noi dung SEO giao bang script wp-cli seed chay tren Local.

## 2026-07-04 (bo sung) - Design system landing + nguyen tac bien tau
- Chot palette 3 mau: den (chu #14233B) + xanh duong brand #0048D8 (gom navy dam) + teal
  #00AE9C CHI dung cho CTA. Bo cam, bo teal khoi trang tri. Nut CTA to + bong do teal.
- Pillar Backlink = mau chuan (da duyet). Cac landing quan trong khac dung CHUNG design
  system (header/footer, khoi khach hang + anh doi ngu, tuong logo khach, FAQ 2 cot, CTA band)
  NHUNG moi trang bien tau hero + 1-2 section rieng theo dac thu dich vu - TRANH nhai giong het.
- Bien tau tung pillar:
  - Mua Textlink (giao dich nhanh): hero = mock "bang chon site" (DR/traffic/gia + checkbox);
    them section so sanh textlink vs backlink; it section hon.
  - Guest Post (content-led): hero = mock bai viet/editor; section "quy trinh viet bai" + grid
    chu de/nganh; khoe mau bai.
  - Booking bao & PR (press-led): hero = mock bai bao co logo bao; NHAN MANH bang gia theo tung
    dau bao (114 long-tail "bao gia dang bai pr tren [bao]"), tuong logo bao noi bat, link trang con.

## 2026-07-05 — Bỏ section Tin tức ở homepage
Bài SEO để ở "Cẩm nang" → bỏ mục "Tin tức & sự kiện" (id=tin-tuc) trong front-page.php (theme digicom-host). Rule Hiếu.
