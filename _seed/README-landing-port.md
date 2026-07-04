# Port 4 trang landing redesign vao WP Local

4 page template standalone (khop demo /preview/ tren gh-pages):
`tpl-landing-backlink.php`, `tpl-landing-textlink.php`, `tpl-landing-guestpost.php`, `tpl-landing-booking.php`.

## Cach ap (tren may Local, thu muc goc WordPress)
1. Pull theme: `git pull origin claude/work-summary-twy7kd` (hoac copy 4 file .php + assets/).
2. Chay: `bash _seed/assign-landing-templates.sh`
   - Copy 22 logo khach + 4 anh doi ngu vao `wp-content/uploads/`.
   - Gan template cho 4 trang theo slug (dich-vu-backlink, mua-textlink, guest-post, booking-bao-pr).
3. Mo 4 trang kiem tra.

## Luu y
- Template standalone: tu render header/footer (dung design moi), KHONG dung header.php/footer.php cu.
- Noi dung (chu, gia) nam trong file .php — sua truc tiep, hoac bao toi tach ra field/CPT sau.
- Gia trong bang: Textlink = mau theo tier; Guest Post & Booking = so THAT tu file content da chuan bi.
- Rollback 1 trang: `wp post meta update <ID> _wp_page_template ''` (ve template mac dinh).
