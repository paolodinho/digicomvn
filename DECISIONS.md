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
