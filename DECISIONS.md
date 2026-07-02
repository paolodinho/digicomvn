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
