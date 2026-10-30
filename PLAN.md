# PLAN - 27/10 18:40 Ảnh bài blog: Hiếu chốt dùng minh hoạ Storyset. XONG thay ảnh stock bằng Storyset trên 135 bài digicomvn + credit, gửi lại GSC 156 URL (danh sách: scratchpad edited-urls.tsv). Backup ~/Claude-Workspace/_backups/edits/2026-10-27/digicom-anh-stock/. LOA: 10 agent đang viết lại 98 bài (out/ trong scratchpad loa/), Tiếp theo: kiểm mẫu, đăng qua SSH wp-cli, purge cache, GSC, ghi file tổng quan LOA.
- digicomvn.com (Textlink, Backlink, Guest Post, Booking báo & PR)

## Đang làm dở (checkpoint)
- 30/10 10:55 Dịch vụ website ĐÃ LIVE (DGC_VER 3.21.0): 6 trang mẫu tpl-web.php + inc/web-svc.php: /thiet-ke-website/ (218, báo giá theo yêu cầu), /cham-soc-website/ (7789), /dang-ky-website-bo-cong-thuong/ (7790), /email-doanh-nghiep/ (7791, Email Pro + Google Workspace + Microsoft 365), /chung-chi-ssl/ (7792), /cloud-server/ (7793). Giá = niêm yết bán lẻ (nhóm chiết khấu >=10% x1,02, nhóm 2-3% x1,08 để lãi >=10%), sửa ở WP Admin > DigicomVN mục 12 (web_gia_*). Menu 'Website & Hosting' (7682) thêm 6 mục; trang chủ nhóm 'Website'; footer; 15 FAQ svc_faqs; gỡ 2 dòng 301 cũ trong .htaccess. QA 375px: 0 tràn, 0 chữ mồ côi. Backup ~/Claude-Workspace/_backups/routines/2026-10-30/web-svc/. Giá vốn nội bộ: 10-bang-gia-booking/NOIBO-gia-von-dich-vu-web-2026-10-30.csv. Tiếp theo: CHỜ Hiếu - mức giá thiết kế website để niêm yết (hiện báo giá theo yêu cầu); chưa đo SERP 6 từ khoá trang.
- 30/10 Hiếu ok: FAQ bài 1261 /bao-gia-dang-bai-pr-theo-dau-bao/ sửa giá trung vị 1.760.000 -> 1.472.000 (live, đã purge, backup host ~/backups/2026-10-30/p1261.html). XONG.
- 30/10 09:05 Lãi 10% ĐÃ LIVE: sàn giá vốn x1,1 cho mọi kỳ hạn hosting + giá gia hạn tên miền (inc/domain-hosting.php dgc_floor10, option dgc_tm_cost); giữ KM năm đầu tên miền. Hosting tăng giá 21 kỳ hạn (vd Unlimited 1 444k->684k, Business 1 3 năm 972k->1.332k). Backup ~/Claude-Workspace/_backups/routines/2026-10-30/san-lai-10/. Tiếp theo: CHỜ Hiếu - nếu giá đại lý gia hạn tên miền đổi thì cập nhật option dgc_tm_cost.
- 29/10 22:00 W30 hosting mua online ĐÃ LIVE (DGC_VER 3.20.1): /hosting/ nút Mua ngay (27 gói có kỳ hạn không lỗ), giỏ chung /thanh-toan-ten-mien/, tiền về -> register_hosting tự động (đã thử cổng test đại lý: OK; API bắt buộc ownerDistrict -> điền tên phường), email khách có cPanel + mật khẩu + quanly.digicomvn.com. Backup live ~/Claude-Workspace/_backups/routines/2026-10-29/hosting-order/. 30/10: Hiếu chốt bán đúng giá bán lẻ cả kỳ hạn lỗ -> đã bỏ chặn lỗ, live 31 gói. Tiếp theo: CHỜ khách - đơn hosting thật đầu tiên (chưa có đơn); khi có thì kiểm email bàn giao.
- 29/10 21:15 Đo top 10 XONG 170/170 từ (132 + 38 đo bù, file serp-bu.csv trong 06-keyword/serp-con-lai-2026-10-29). Đã báo agent nền pipeline gom cụm đủ 170 từ, viết, Jett QA, hẹn giờ. Tiếp theo: CHỜ agent nền pipeline báo xong; phiên này kiểm URL, lịch, dòng N11 rồi báo Hiếu. Cập nhật lúc: 2026-10-29 21:15
- 29/10 20:40 Hiếu ok 2 việc: byline Hiếu Đỗ (đã đúng trên mọi bài hẹn giờ), gia-booking-kol để báo giá theo brief (đã đúng). Ghi DECISIONS.
- 29/10 20:30 Pipeline SEO: vòng đo top 10 dừng ở 132/170 từ (run_loop.sh đếm cả dòng lặp nên báo LOOP_XONG sai). Đang đo bù 38 từ (06-keyword/serp-con-lai-2026-10-29/kw.miss.txt -> serp-bu.csv, xong khi serp.log có BU_XONG). Agent pipeline đã gọi làm tiếp: gom cụm 132 từ, viết 2 bài (bao-mang-dien-tu-la-gi, social-entity-la-gi, hẹn 03/11), lịch tối ưu 11 trang content/toi-uu-2026-10-29/lich.tsv. Tiếp theo: CHỜ agent nền pipeline (đang chạy) và đo bù 38 từ; agent báo xong thì phiên này kiểm URL, lịch, dòng N11.
- 29/10 Goodcom Social: ĐÃ LƯU báo giá fanpage (11) + TikTok (6) ngày 28/10 vào 10-bang-gia-booking/raw/Goodcom-Social-2026-10-28.csv + ghi nguon.md (nội bộ, không lên web). Phần báo điện tử của file Goodcom chưa nạp. Tiếp theo: CHỜ Hiếu nói có nạp phần báo điện tử/đưa fanpage-TikTok vào trang /booking-fanpage/ không.
- Báo giá Hannah (EPC, báo link dofollow) 29/10: XONG 2 Google Sheet (khách 12RSUQ8-GlJE2aUg1o0yknXPpuZfSStytF2UvNIHvX80, NOIBO 1HmWfRahzj3Am7BT1NGbDwc-Yj0vNSXdGEMzEvHbAVPY), xlsx ở 11-bao-gia-khach/*Hannah-2026-10-29.xlsx. Đã so thêm nhanh.vn 29/10 (không báo nào rẻ hơn). Thêm nhóm BÁO LỚN TOÀN QUỐC (19 vị trí: VnExpress, Thanh Niên, Dân Trí, VietNamNet, Tiền Phong, 24h, CafeF, CafeBiz, VnEconomy, Người Quan Sát) + Doanhnghiepvn dofollow; mỗi vị trí so Goodcom x1,10 với kho DanaSEO 29/07, lấy rẻ hơn (giá kho DanaSEO cần xác nhận lại). Tiếp theo: CHỜ Hiếu gửi khách + hỏi giá tapchicongthuong.vn.
- 29/10 14:55 Task 7b: HĐ booking Win Win Corp (MST 0801322577, Diễn đàn Doanh nghiệp 2.480.000 + VAT 8% = 2.678.400) ĐÃ ĐIỀN: 15-hop-dong/Hop-dong-Booking-Bao-PR-WinWinCorp-2026-10-29.docx (mẫu giữ nguyên). Còn trống tô vàng: số HĐ, ngày ký, % phí hủy 10.2, các mốc mặc định chờ Hiếu duyệt. Tiếp theo: CHỜ Hiếu duyệt + chọn dofollow/nofollow + phương án thanh toán 1/2.
- Task 1: báo giá PR khách Hannah (EPC điện mặt trời) - ĐÃ SOẠN XONG 28/10. Tiếp theo: CHỜ Hiếu gửi khách; hỏi Goodcom giá Tạp chí Công Thương rồi bổ sung. File: 11-bao-gia-khach/(NOIBO-)Bao-Gia-PR-Tong-Thau-EPC-Dien-Mat-Troi-2026-10-28.xlsx, Sheet khách https://docs.google.com/spreadsheets/d/17s_MMDs4lf6P5tuUrLTpOx-dcjPB3OcOtvtqv9QGNPU/edit
- Task 2 (W17 file tổng quan): Google giữ tiêu đề rác cờ bạc từ hack 22/10 ("TKP303 Situs Game Online x Guest Post", "RRQ88 ... Backlink quốc tế"). 28/10: web thật sạch (quét 229 URL), đã đẩy 41 URL crawl 22-23/10 qua Indexing API (OK) + sitemap + hàng đợi gsc_index --force. Danh sách: scratchpad hack_urls.txt (cũng trong hàng đợi gsc_index site digicom).
- Tiếp theo: CHỜ Google crawl lại (3-7 ngày) - từ 01/11 kiểm "site:digicomvn.com" ở trình duyệt không đăng nhập; còn tiêu đề rác thì Hiếu bấm Yêu cầu lập chỉ mục tay 2 trang /guest-post/, /backlink-quoc-te/.
- Task 3 (W28): GA4 traffic tăng - đã xong, phần lớn người thật VN (431 user/28 ngày), nghi bot ~13%. GSC: trang tăng mạnh nhất /thong-cao-bao-chi-xu-ly-khung-hoang/, /case-study/, /chien-dich-pr-an-tuong-viet-nam/; hiển thị tăng chủ yếu do từ cờ bạc (hack). ICD GA4 user ảo đã giao phiên ICD - SEO (fork).
- Task 4 (N10): 29/10 05:58 chạy nền đo top 10 ẩn danh 170 từ còn thiếu của đợt 24/10 (248 từ, đợt đó dừng ở 13/248; 78 từ đã có SERP ở đợt khác). Thư mục 06-keyword/serp-con-lai-2026-10-29/ (kw.txt, run_loop.sh, serp.log, loop.pid). Dùng IP máy (ALLINTITLE_DIRECT=1), KHÔNG cần key proxy xoay; xếp hàng sau LOA/ICD bằng --wait-lock. Tiếp theo: đo xong gom cụm (mẫu serp-kp43-2026-10-24/gom_cum.py), ghi tab KH, tối ưu 16 trang có sẵn (N11).
- Task 5 (T1-T7 tab KH, Hiếu duyệt 29/10): ĐÃ đổi tiêu đề live 29/10: /booking-bao-pr/ (475 seo title 'Dịch Vụ Book Báo, Booking Báo Chí PR - Bảng Giá 2026'), /bao-gia-dang-bai-pr-theo-dau-bao/ (1261 title+H1 'Báo Giá Đăng Bài PR 2026: Bảng Giá Từng Đầu Báo'), /booking-truyen-hinh/ (2107), /quang-cao-phat-thanh/ (2440); backup host ~/backups/titles-2026-10-29.tsv + post-1261-2026-10-29.html; GSC hàng đợi --force. Tiếp theo: nội dung theo cột J tab KH (T1 H2 book báo là gì, T2 mở bằng bảng giá, T3 H2 phóng sự, T5/T6 bảng giá VOV + H2 hình thức, T4 bài bảng giá QC VTV mới, T7 chờ SERP 'quảng cáo tvc'). | 29/10 07:10: NỘI DUNG T1-T3, T5, T6 ĐÃ XONG trên live (H2 book báo là gì /booking-bao-pr/; bảng giá 14 vị trí 9 báo mở đầu /bao-gia-dang-bai-pr-theo-dau-bao/, bỏ bảng giá cũ; H2 phóng sự /booking-truyen-hinh/; H2 hình thức QC /quang-cao-phat-thanh/), backup ~/Claude-Workspace/_backups/routines/2026-10-29/noi-dung-T1-T5/, overflow 0/4, đã add GSC. Tiếp theo: T4 viết bài mới 'Bảng Giá Quảng Cáo Truyền Hình VTV 2026 Theo Khung Giờ' từ 30 dòng dgc_gia booking-truyen-hinh (wp post list --post_type=dgc_gia), Jett QA rồi đăng; T7 chờ SERP 'quảng cáo tvc'.
- Task 6 (W30): Giỏ + thanh toán QR tên miền ĐÃ LÊN LIVE 29/10 09:10 (DGC_VER 3.17.0): /ten-mien/ nút Thêm vào giỏ -> /thanh-toan-ten-mien/ (form chủ thể + mã QR VietQR MB 567898838, mã đơn DGCxxxxxx), webhook https://digicomvn.com/wp-json/dgc/v1/sepay tự xác nhận khi tiền về (đã test Local đủ: sai key 401, thiếu tiền, trùng id, đủ tiền). File: wp-theme/digicom-host/inc/domain-order.php, page-thanh-toan-ten-mien.php. Đơn ở WP Admin > Đơn tên miền. Backup live ~/Claude-Workspace/_backups/routines/2026-10-29/domain-checkout-live/. Tiếp theo: CHỜ Hiếu - tạo tài khoản SePay nối MB, webhook API Key -> thêm define('DGC_SEPAY_KEY','...') vào wp-config live; gửi tài liệu lệnh đăng ký của API đại lý + whitelist IP 145.79.26.63 để viết dgc_tm_pa_register() rồi bật DGC_PA_REG_ON; quyết VAT (option tm_vat đang 0). Chưa có key thì đơn vẫn tạo được nhưng không tự xác nhận - Hiếu xác nhận tay trong WP Admin.
- Task 6b (W30) 29/10 10:00: /hosting/ ĐÃ LÊN LIVE 3.19.0 - khối Quà tặng (4 ưu đãi, option hosting_uu_dai), khối tin cậy (pháp nhân, TK công ty, hạ tầng, cài đặt), nhãn Giảm X%, dòng Trọn N năm; thêm 3 gói WordPress Business 1-3; giá hosting đồng bộ hằng ngày từ bảng bán lẻ (inc/hg-offers.php, 31 gói khớp, không đổi giá). Backup ~/Claude-Workspace/_backups/routines/2026-10-29/hosting-offers-deploy/. Tiếp theo: CHỜ Hiếu chọn cách giao quyền quản trị tên miền/hosting cho khách sau khi mua.
- Task 6c (W30) 29/10 10:40: ĐÃ LIVE trang WP Admin > Đơn tên miền > Bàn giao dịch vụ (inc/handover.php: gửi email bàn giao tên miền/cPanel, mật khẩu không lưu, có nhật ký; nút trong từng đơn; email 'đã đăng ký xong' kèm hướng dẫn quản trị). Đã gửi thử tới sales@digicomvn.com OK. Quy trình: 14-van-hanh-ten-mien-hosting/quy-trinh-ban-giao-ten-mien-hosting.md. Kiểm trang đại lý: có cổng quản trị white-label (CNAME mr.pavietnam.vn, đang tắt), tạo tài khoản khách cuối, mẫu email + SMTP; 'gửi mail thông báo đến khách' đang BẬT với mẫu mặc định. Tiếp theo: CHỜ Hiếu duyệt bật cổng quanly.digicomvn.com + SMTP/mẫu email Digicom (hoặc tắt mail đại lý gửi khách).
- 29/10 09:30: sửa lỗi 'Chưa kiểm tra được' khi Hiếu đăng nhập (nonce trong trang cache lệch phiên -> 403): bỏ bắt buộc nonce ở dgc_domain_check + dgc_tm_order, đã live.
- 29/10 10:00: /ten-mien/ làm lại kiểu bán lẻ (thẻ tên miền chính + combo .xyz/.site/.click 30.000đ, nhãn Có ưu đãi, quà tặng .vn/.com, giá năm đầu theo số năm tối thiểu, giỏ hiện tiết kiệm + quà). Giá tự đồng bộ bảng giá bán lẻ nhà cung cấp hằng ngày 01:15 (inc/tm-offers.php, DGC_TM_SYNC_URL trong wp-config live, nút Đồng bộ ngay ở WP Admin muc 11). DGC_VER 3.18.0 ĐÃ LIVE. Backup ~/Claude-Workspace/_backups/routines/2026-10-29/tm-offers-deploy/. Tiếp theo: CHỜ Hiếu whitelist IP 145.79.26.63 ở API đại lý (đuôi .vn trên live đang 'cần kiểm tra thủ công' do API timeout); trang /hosting/ chưa làm khối ưu đãi.
- Task 6d (W30) 29/10 11:05: Hiếu duyệt. Trang đại lý: ĐÃ tắt 'gửi mail thông báo đến khách', footer + tên Control Panel = DigicomVN. SMTP đã điền (smtp.larksuite.com:465 SSL, sales@) nhưng CHƯA lưu, chờ Hiếu dán mật khẩu ứng dụng Lark + Lưu + gửi thử. Mẫu email: giữ mặc định (mẫu tên miền/hosting/gia hạn sạch, chỉ Colocation/Dedicated-Windows/Mailserver ghi cứng tên đại lý, không bán). Tiếp theo: CHỜ Hiếu thêm CNAME quanly -> mr.pavietnam.vn ở Namecheap (Chrome chưa đăng nhập Namecheap); có bản ghi thì Claude bật Control Panel riêng + logo, rồi bật lại mail gửi khách. Chi tiết: 14-van-hanh-ten-mien-hosting/quy-trinh-ban-giao-ten-mien-hosting.md mục 4.
- Task 6e 29/10 11:35: CNAME quanly đã chạy; đã bật Control Panel riêng quanly.digicomvn.com + logo + tiêu đề DigicomVN, nameserver ns1-3.dotvndns.vn. Tiếp theo: kiểm trang quanly.digicomvn.com hiển thị (lúc 11:35 máy chủ chưa trả lời từ Mac, Chrome mất kết nối); CHỜ Hiếu dán mật khẩu ứng dụng Lark vào Cấu hình SMTP đại lý + Lưu; sau đó bật lại 'gửi mail thông báo đến khách'.
- Task 6f 29/10 12:10: SMTP đại lý XONG (Hiếu dán mã ủy quyền Lark, lưu OK), gửi thử tới hieudx3107@gmail.com nhận được từ sales@digicomvn.com. Cổng quanly.digicomvn.com chưa mở được: máy chủ 222.255.121.227 (mr.pavietnam.vn) không nhận kết nối 80/443 kể cả địa chỉ gốc -> lỗi phía đại lý; API check_whois cũng timeout từ IP 145.79.26.63. Tiếp theo: CHỜ Hiếu duyệt gửi ticket kỹ thuật (gộp 2 lỗi); cổng chạy được thì bật lại 'gửi mail thông báo đến khách'.
- 29/10 12:30: đồng bộ giá tên miền + hosting đổi từ 1 ngày/lần sang 6 giờ/lần (hook dgc_tm_sync_daily, lịch dgc_6h, inc/tm-offers.php), ĐÃ LIVE, lượt đầu chạy ~12:40. Ticket API: kỹ thuật đại lý bảo thêm IP nhưng 145.79.26.63 đã có ở ô IP 1, kiểm lại vẫn timeout -> CHỜ Hiếu trả lời ticket kèm ảnh.
- 11:56 29/10: Hiếu đổi CNAME quanly -> access.dotvndns.vn (theo kỹ thuật đại lý). Cổng http://quanly.digicomvn.com/dang-nhap CHẠY (tiêu đề DigicomVN). Đã tải logo+favicon lên cấu hình (bỏ link logo dán tay), BẬT LẠI 'gửi mail thông báo đến khách'. Còn: cổng vẫn hiện logo vỡ + favicon đại lý (lỗi giao diện phía đại lý) -> Hiếu báo thêm trên ticket; API check_whois chờ kỹ thuật kiểm tường lửa. Tiếp theo: CHỜ đại lý; khi họ báo xong thì kiểm lại logo cổng + chạy check_whois từ live.
- Task 7 29/10 14:20: Hiếu xin mẫu HĐ booking báo gửi khách. XONG mẫu docx (7 trang, ô cần điền tô vàng, Phụ lục 01 brief bài): 15-hop-dong/Mau-Hop-dong-Booking-Bao-PR-DigicomVN-2026-10-29.docx. Không lộ NCC/giá vốn. Tiếp theo: CHỜ Hiếu duyệt các mốc mặc định (lưu bài 12 tháng, đăng dự kiến 3-7 ngày LV, thanh toán 100% trước hoặc cọc 50%, phạt chậm 0,05%/ngày, phí hủy trước khi gửi toà soạn) rồi đổ thông tin khách và gửi. Chưa ghi file tổng quan Sheet.
- 29/10 chiều: đại lý mở IP 145.79.26.63, API check_whois từ live chạy (1,2s, đúng .com/.vn/.com.vn), ô tra tên miền dùng API thật. Còn: lỗi logo/favicon cổng quanly + SSL (Hiếu báo đại lý), key SePay, VAT.
- 29/10 14:20 (phiên rà site): vòng đo SERP N10 chết ở 93/170 lúc 08:10 (máy nghỉ) -> đã chạy lại nền 14:15 (06-keyword/serp-con-lai-2026-10-29/loop.pid, serp.log), có CAPTCHA rải rác do IP máy dùng chung với LOA. Agent nền đang viết bài T4 'Bảng Giá Quảng Cáo Truyền Hình VTV 2026 Theo Khung Giờ' (backup ~/Claude-Workspace/_backups/routines/2026-10-29/bai-vtv-T4/). Tiếp theo: đo xong gom cụm (mẫu serp-kp43-2026-10-24/gom_cum.py), ghi tab KH; QA bài T4 + ghi file tổng quan.
- 29/10 14:45: T4 ĐÃ ĐĂNG https://digicomvn.com/bang-gia-quang-cao-vtv/ (post 7754, 2.499 từ, 13 dòng giá VTV, QA list-semantic 0 + overflow 0, đã add GSC); bài /quang-cao-truyen-hinh/ (7032) thêm đoạn trỏ sang bài mới, bỏ 2 từ VTV khỏi json bài cũ. Sửa 28 alt ảnh bị lưu dạng \u (ID 7011-7052) + hen_gio.py ensure_ascii=False. Dòng N10 file tổng quan đã cập nhật. Tiếp theo: vòng SERP (PID 89168) chạy xong (serp.log có LOOP_XONG) thì gom cụm ghi tab KH, T7 theo SERP 'quảng cáo tvc'. Hiếu chốt giữ nguyên giá booking VTV.
- 29/10 15:13: SSL free cho quanly: cổng đại lý có ô dán Certificate/Private Key/CA (cpanelform, chọn https://). Đã xin chứng chỉ Let's Encrypt bằng acme.sh (home ~/Claude-Workspace/digicom/ssl-quanly/acme, DNS manual). CHỜ Hiếu thêm TXT _acme-challenge.quanly = 79_W13n9S8OU40Jqm1sfKyF_Bv9ZS1Yyept3f86ieDY ở Namecheap, rồi chạy: acme.sh --home ~/Claude-Workspace/digicom/ssl-quanly/acme --server letsencrypt --renew -d quanly.digicomvn.com --ecc --yes-I-know-dns-manual-mode-enough-go-ahead-please, dán cert vào cpanelform. Logo/favicon cổng: đại lý đã sửa, OK.
- 29/10 15:25: đã dán chứng chỉ Let's Encrypt (hạn 27/01/2027) + chọn https ở cpanelform, đại lý báo 'kích hoạt trong 24h'. Tiếp theo: CHỜ đại lý kích hoạt SSL (24h), 30/10 kiểm https://quanly.digicomvn.com/dang-nhap; đã đặt lịch digicom-gia-han-ssl-quanly 20/12. GIA HẠN trước 27/12/2026: chạy acme.sh --home ~/Claude-Workspace/digicom/ssl-quanly/acme --server letsencrypt --renew -d quanly.digicomvn.com --ecc --force --yes-I-know-dns-manual-mode-enough-go-ahead-please, Hiếu sửa TXT _acme-challenge.quanly ở Namecheap, chạy lại --renew, dán 3 ô ở cpanelform.
- 29/10 15:40 Task 6g (W30) TỰ ĐỘNG HOÁ: (2) đăng ký tên miền qua API đại lý ĐÃ LIVE + BẬT (DGC_PA_REG_ON trong wp-config live, backup ~/wp-config.bak-20261029-regon trên host): đơn sang 'Đã thanh toán' (SePay hoặc Hiếu chọn tay) -> 5 giây sau tự đăng ký từng tên miền (register_domain_quocte/_vietnam), lưu mật khẩu quản trị + mã giao dịch trong chi tiết đơn, lỗi -> 'Đăng ký lỗi' + email Hiếu, chọn lại 'Đã thanh toán' để thử lại (không đăng ký trùng). Form thanh toán thêm tỉnh/phường (34 tỉnh, assets/data/dvhc.json), giới tính, CCCD + ngày sinh người đại diện. Đã chạy cổng thử đại lý (interface_test, không trừ tiền) đủ .com/.vn/.com.vn/.net cá nhân + công ty: OK. (1) SePay: thêm ô 'Khoa API SePay' ở WP Admin > DigicomVN (mục tên miền), giả lập webhook trên live OK (sai khoá 401, thiếu tiền, đủ tiền -> tự hẹn đăng ký), đã dọn đơn thử + trả cài đặt về nguyên bản. DGC_VER 3.19.1. Backup ~/Claude-Workspace/_backups/routines/2026-10-29/tm-auto-register/. Tiếp theo: CHỜ Hiếu tạo tài khoản SePay nối MB 567898838 + webhook, dán khoá vào ô WP Admin; nạp số dư tài khoản đại lý đủ cho đơn.
- 29/10 20:40 SePay: Hiếu đã tạo tài khoản. Claude: khoá webhook sinh ngẫu nhiên, đặt DGC_SEPAY_KEY trong wp-config live (backup ~/wp-config.bak-20261029-sepay trên host), bản local ~/.config/digicom/sepay_key (chmod 600); curl thử: đúng khoá success true, sai khoá false. Form webhook SePay đã điền (tên 'Digicom - don ten mien', URL https://digicomvn.com/wp-json/dgc/v1/sepay, tiền vào, JSON, gửi lại khi lỗi, mọi tài khoản, dùng xác thực thanh toán, kiểu API Key). Tiếp theo: CHỜ Hiếu dán khoá (đã copy vào clipboard máy Mac) vào ô API Key rồi bấm Tiếp/Lưu; CHỜ Hiếu nối MB 567898838 ở my.sepay.vn/bankaccount/connect (Doanh nghiệp: STK, MST, SĐT, rồi duyệt liên kết API trên MB) - Claude không nhập số tài khoản thay.
- 29/10 21:00 SePay XONG cấu hình: MB 567898838 'Đã kết nối API', webhook 'Digicom - don ten mien' kích hoạt. Chưa chạy thử giao dịch thật (Hiếu: thử sau). Tiếp theo: khi Hiếu muốn thử -> tạo đơn thử 2.000đ không có tên miền (_tm_lines rỗng, email sales@), Hiếu chuyển khoản nội dung = mã đơn, kiểm đơn sang Đã thanh toán + lịch sử gửi webhook SePay, rồi xoá đơn thử.
- 29/10 16:30 N12 (agent nền, chốt Hiếu chạy hết pipeline): 2 bài mới HẸN GIỜ: /bao-mang-dien-tu-la-gi/ (7764, Luật Báo chí 126/2025, Jett 88, 03/11 01:30 UTC) + /social-entity-la-gi/ (7765, Jett 91, 03/11 08:30 UTC), thumbnail + GSC xong, file content/n12-bai-2026-10-29/. Tối ưu 10 trang cũ: bản chỉ cộng thêm ở content/toi-uu-2026-10-29/<slug>.html, lịch lich.tsv (30/10-05/11, tối đa 2 trang/ngày), TỰ ÁP bằng LaunchAgent com.hieu.toi-uu-lich (9:10/14:10/20:10, script ~/Claude-Workspace/_global/scripts/toi-uu-lich/apply_lich.py: so md5 live với bản gốc, khác thì bỏ qua + báo; backup + manifest + purge + GSC; log ~/Claude-Workspace/_state/toi-uu-lich/run.log). /bai-pr-la-gi/ chờ /pr-va-quang-cao-khac-nhau/ đăng 02/11. Tiếp theo: vòng SERP (06-keyword/serp-con-lai-2026-10-29, PID trong loop.pid) có LOOP_XONG thì chạy gom_cum_n13.py cùng thư mục, ghi khối mới tab KH theo trang đích, viết bài cụm chưa có trang (hẹn từ 04/11 01:30 UTC, 2 bài/ngày), cụm có trang thì thêm vào lich.tsv.
- 29/10 21:10 N13: 3 bài mới HẸN GIỜ (Jett 86-87, thumbnail, meta SEO, GSC xong): /influencer-la-gi/ (7774, 04/11 01:30 UTC), /koc-la-gi/ (7776, 04/11 08:30 UTC), /xu-ly-khung-hoang-truyen-thong/ (7777, 05/11 01:30 UTC), file content/n13-bai-2026-10-29/. Gom cụm 132/170 từ (gom_cum_n13.py) -> tab KH khối 'Bổ sung 29/10' dòng 167-272 theo trang đích. Tối ưu đợt 2 (BRIEF-2.md): thêm lich.tsv pr-la-gi 04/11, quang-cao-tvc-la-gi 05/11, backlink-social-entity 06/11; mở rộng bản soạn dich-vu-backlink + booking-kol-koc. Tiếp theo: (1) agent soạn guest-post.html (goc đã tải, md5 cdd364b2...) rồi thêm dòng lich.tsv 07/11; (2) serp.log có BU_XONG thì chạy lại gom_cum_n13.py, cụm mới chưa có trong khối 'Bổ sung 29/10' thì thêm; (3) host digicom quá tải 29/10 tối (load ~19), SSH chạy nền có retry, sync_content_maps.py digicom chạy lại nếu lỗi.
- 29/10 21:20: đo bù xong 170/170 từ, gom lại (clusters.json, bản 132 từ: clusters.132.json); tab KH khối 'Bổ sung 29/10' dòng 167-295 theo trang đích; 38 từ mới đều về trang có sẵn hoặc 3 bài N13, không cụm nào cần bài mới. guest-post.html soạn xong, lich.tsv thêm 07/11. sync_content_maps.py digicom lỗi do host quá tải (SSH timeout), LaunchAgent tự chạy lại 4 lần/ngày. Task N13: xong.
- Cập nhật lúc: 2026-10-29 21:20

## Mục tiêu tổng
Website digicomvn.com tập trung 4 dịch vụ off-page SEO (Mua Textlink, Dịch vụ Backlink,
Guest Post, Booking báo & PR), chạy trên WP Local, demo gửi khách. Mở rộng thiết kế
web/tên miền/hosting ở giai đoạn 2.

## Milestones
- [x] M1 - Wireframe trang chủ - 2026-06-27
- [x] M2 - Chốt design system + wireframe trang con
- [x] M3 - Build theme WP trên Local (định hướng tên miền/hosting ban đầu)
- [x] M3b - PIVOT sang 4 dịch vụ Textlink/Backlink/Guest Post/Booking báo PR - 2026-07-02
- [x] M3c - Đảo lại lần 2: bỏ hẳn tên miền/hosting (Hiếu đổi ý), phục hồi backlink-focus - 2026-07-02/03
- [x] M4a - Audit internal link (attractor), draft 73 bài kiến thức SEO không liên quan,
      giữ 23 bài cluster Backlink, sửa link chết - 2026-07-03
- [x] M4b - Bảng giá đầy đủ 209 dòng (CPT `dgc_gia`) + tool tra cứu/ước tính trên `/bang-gia/` - 2026-07-03
- [x] M4c - Đối chiếu 6 file từ khoá thật, viết + đăng 12 bài blog mới cho 4 dịch vụ
      (4 P0 + 8 P1/P2), sửa lỗi trùng H1 toàn site - 2026-07-03
- [x] M4d - Xác nhận đầu báo hợp tác thật (Hiếu confirm), publish 5 trang con booking-bao-pr,
      thêm mục "Đầu báo hỗ trợ đặt bài" trên trang chủ với 16 logo thật (15 tải trực tiếp từ
      website báo, 1 từ Wikimedia Commons vì laodong.vn chặn bot) - 2026-07-03
- [x] M5 - Duyệt giá, gắn ảnh 12 bài blog, build lại template blog/single, fix CSS demo tĩnh,
      re-export + push gh-pages, QA mobile - 2026-07-03

- [x] M6 - Thêm 10 trang con booking-bao-pr (Vietnamnet, Thanh Niên, Tuổi Trẻ, Znews, Soha,
      Afamily, Eva, CafeBiz, Webtretho, Báo Đầu Tư - tổng 15 trang con), fix trang pillar
      booking-bao-pr mồ côi (thêm link tới cả 15 trang con), gắn thumbnail cho 23 bài blog cũ
      còn lại (35/35 bài blog đều có ảnh thật) - 2026-07-03

- [x] M7 - Redesign toàn bộ giao diện theme digicom-host theo template GrowMark (màu xanh dương
      #4761FF, font Roboto+Montserrat, icon tròn, testimonial carousel, nút back-to-top) -
      2026-07-06. Backup theme cũ trước khi sửa.

- [x] M8 - Marquee logo báo chạy vô hạn + thêm 5 đầu báo thật (Afamily, Eva, CafeBiz, Webtretho,
      Báo Đầu Tư); xoá hub `/dich-vu/` không style (chuyển menu thành dropdown-only, không xoá
      dữ liệu) - 2026-07-06.
- [x] M9 - Đẩy bảng giá lên từng trang dịch vụ + tool ước tính chi phí (`inc/service-pricing.php`,
      `dgc_current_nhom()`), định dạng giá có phân cách hàng nghìn (`dgc_format_price()`), chuyển
      calculator từ giá trung bình (mean) sang trung vị (median) sau khi phát hiện nhóm Dịch vụ
      Backlink chỉ có gói cao cấp làm mean bị lệch - 2026-07-06.
- [x] M10 - Viết đầy đủ Điều khoản sử dụng + Chính sách bảo mật (chuẩn EEAT), gắn link footer
      (trước đó là text không bấm được); phát hiện và dọn 2 trang trùng lặp do tạo nhầm - 2026-07-06.
- [x] M11 - Republish 73 bài kiến thức SEO tổng quát đã draft trước đó, dọn dẹp category trùng
      lặp từ phiên làm việc cũ, tổ chức lại theo cụm chủ đề (category.php mới: tab-bar chuyển cụm
      + CTA cuối trang), thêm block "Bài viết liên quan" + CTA off-page SEO trên single.php - 2026-07-06.
- [x] M12 - Thay icon emoji (phông chữ hệ điều hành, trông rẻ tiền) trong contact-info bằng SVG
      inline riêng (`dgc_icon()`) - 2026-07-06.
- [x] M13 - Dọn trang chủ theo feedback: bỏ hero quick-link chips, bỏ 2 section liệt kê giá/gói
      trùng với `/bang-gia/`, gộp "Chúng tôi là ai" vào section "Vì sao chọn Digicom", fix
      khoảng cách contact-info box - 2026-07-06.
- [x] M14 - Phát hiện + gỡ ảnh đội ngũ SAI (watermark "Integrity" của công ty khác, sót lại từ
      placeholder GrowMark) khỏi hero + section "Chúng tôi là ai", thay bằng placeholder trung
      tính chờ ảnh thật; thêm chú thích "ví dụ minh hoạ" cho tên trong testimonial (theo lựa
      chọn của Hiếu, tránh vi phạm rule content-professional); dựng khung tab "Case study"
      (rỗng, chờ Hiếu gửi số liệu thật); thêm hiệu ứng đèn flash phóng viên toàn site (tắt khi
      trình duyệt bật prefers-reduced-motion) - 2026-07-06.
- [x] M15 - Bảng giá Booking báo & PR (118 dòng) thêm sidebar lọc theo nhóm báo: Báo lớn (23),
      Báo tỉnh (23), Đài truyền hình (8), Kinh tế - Tài chính (19), Giải trí - Đời sống (20),
      Công nghệ - Ô tô (9), An ninh - Pháp luật (6), Bất động sản - Xây dựng (4), Y tế (2),
      Giáo dục (2), Thể thao (2) - phân loại thủ công dựa trên bản chất thật của từng đầu báo
      (không đoán/bịa), lưu vào postmeta `nganh` sửa được qua WP Admin. Thêm hiệu ứng con trỏ
      chuột hình ngòi bút nhà báo toàn site (SVG inline, không ảnh hưởng UX) - 2026-07-06.

### Sắp làm
- [x] Case study: dựng CPT `dgc_case` (5 bài độc lập, archive `/case-study/` kiểu blog-card),
      mở rộng mỗi bài lên ~1800-1965 chữ, giữ fact + nguồn báo thật - 2026-07-14.
- [x] Section trang chủ: logo khách hàng (7 KH thật) + "Tại sao chọn DigicomVN" + "Báo chí nói về
      DigicomVN" (logo wall 10 báo: 2 bài thật có link, 8 logo chờ link) - 2026-07-14. Đều sửa từ WP Admin.
- [ ] Hiếu gửi FILE LOGO khách hàng (uploads/client-logos/) + gắn LINK bài thật cho 8 logo báo
      trong "Báo chí nói về DigicomVN" (hoặc bỏ báo chưa từng đăng để đúng E-E-A-T) - 2026-07-14.
- [ ] Hiếu tự submit sitemap `https://digicomvn.com/wp-sitemap.xml` lên Google Search Console
      (Sitemaps > Add a new sitemap) - Claude không có kết nối GSC trong phiên này nên không
      submit hộ được. Đã dọn xong 25 trang thừa (draft + 301) trước khi submit - 2026-07-11.
- [x] Hiếu xác nhận 15 đầu báo trong `/dich-vu/booking-bao-pr/[bao]/` (vnexpress, kenh14,
      dan-tri, 24h, cafef, vietnamnet, thanh-nien, tuoi-tre, znews, soha, afamily, eva,
      cafebiz, webtretho, bao-dau-tu) là hợp tác THẬT - giữ nguyên publish, không cần draft
      lại. Ghi chú này thay thế cảnh báo trong pivot-2026-07.md (M4 đã xong) - 2026-07-11.
- [ ] Internal-link audit (skill `/internal-link-audit`): phát hiện ~89 bài cũ đang link về URL
      cũ dạng blog (`/dich-vu-backlink/`, `/pr-bao-chi/`...) thay vì money page thật
      (`/dich-vu/[slug]/`) - CHƯA sửa, cần crawl Screaming Frog để xác nhận trước khi fix hàng loạt.
- [ ] Gửi ảnh đội ngũ Digicom THẬT để thay placeholder hero + "Chúng tôi là ai" (ảnh cũ dùng
      nhầm là ảnh stock có watermark công ty khác, đã gỡ 2026-07-06).
- [ ] Xác nhận vị trí file logo khách hàng thật (Hiếu nói đã gửi nhưng chưa tìm thấy trong WP
      media/Downloads) để dựng section logo giữa phần "Đầu báo" và "Testimonial".
- [ ] Gửi nội dung/số liệu case study thật để điền vào tab Case study (khung đã dựng sẵn, đang rỗng).
- [ ] Hiếu tự mở digicom.local kiểm tra giao diện mới, xác nhận màu #4761FF ưng ý.
- [ ] Hiếu gửi file logo mới có chữ "DigicomVN" (logo hiện tại - logo-digicom.png - nung
      sẵn chữ "Digicom" trong ảnh, đã đổi hết text trên site sang DigicomVN nhưng riêng
      file logo/favicon này cần ảnh mới mới thay được) - 2026-07-11.
- [x] External link E-E-A-T (`.claude/rules/external-link-eeat.md`): quét 130 bài + 17 trang live
      tìm mention luật/quy định - chỉ 2 bài khớp (post 3848, 3869, cùng chủ đề Thông cáo báo chí).
      Đã gắn link ra Luật Báo chí 2016 + Luật BVQLNTD 2023 (congbao/vanban.chinhphu.vn), đồng thời
      phát hiện + sửa luôn Nghị định 13/2023/NĐ-CP đã HẾT HIỆU LỰC (01/01/2026) -> cập nhật thành
      Nghị định 356/2025/NĐ-CP (văn bản thay thế). Backup:
      `~/Claude-Workspace/_backups/routines/2026-07-19/digicom-glossary-content/`. 2026-07-19.
- [x] Component icon "i" + popup giải thích thuật ngữ cho NỘI DUNG BÀI VIẾT (khác cơ chế
      `.intro-toggle` chỉ dùng trong bảng giá): shortcode `[thuatngu hien="..."]định nghĩa[/thuatngu]`
      trong `inc/glossary.php`, tái dùng modal `.intro-pop` có sẵn. Đã deploy live (DGC_VER 1.9.2),
      test OK. 2026-07-19.
- [x] Áp icon "i" cho 12 thuật ngữ chuyên ngành (DR, DA, Anchor Text, dofollow, nofollow, E-E-A-T,
      Core Web Vitals, Schema Markup, canonical, GEO, crawl budget, referring domain, topical
      authority) trên TOÀN BỘ 130 bài + 17 trang live - 115 bài có ít nhất 1 thuật ngữ (5 pillar +
      110 blog), lần nhắc đầu tiên/bài, loại trừ 8 bài mà chủ đề CHÍNH là định nghĩa thuật ngữ đó
      (tránh tự-giải-thích-chính-mình). 2026-07-19.
      - ⚠️ Sự cố quy trình: `rm -rf` server chạy trước khi kịp scp backup 110 bài về máy -> mất
        backup gốc batch này. Đã verify phục hồi 100% được bằng gỡ ngược shortcode (transform chỉ
        chèn thêm, không xoá) - xem `~/Claude-Workspace/_backups/routines/2026-07-19/digicom-glossary-posts/ROLLBACK-README.md`.
        Các batch sau đã cẩn thận copy backup về TRƯỚC khi dọn server.
      - Phát hiện 2 bug khi rải: (1) 23 bài bị shortcode lọt vào trong thẻ heading `<h2>/<h3>`,
        làm hỏng mục lục tự động (id neo bị garble, TOC hiện chữ thô) - đã gỡ sạch. (2) 4 bài
        (geo-generative-engine-optimization, ai-overview, bert-seo, viet-bai-seo) kích hoạt 1 BUG
        CÓ SẴN trong `inc/toc.php` (không phải do glossary gây ra) khiến 1 đoạn văn bị RENDER
        TRÙNG 2 LẦN (1 bản thô + 1 bản đã xử lý shortcode) - đã gỡ shortcode ở 4 bài này để né bug,
        NHƯNG bug gốc trong toc.php vẫn còn tồn tại, có thể tái phát với nội dung khác. **Cần Hiếu
        xác nhận ưu tiên sửa `inc/toc.php` (dgc_toc_process, priority 9 trên `the_content`) ở
        session riêng** - chưa rõ nguyên nhân chính xác gây trùng nội dung, cần điều tra kỹ hơn.
- [x] Sửa 2 vấn đề Hiếu phát hiện qua ảnh chụp (popup E-E-A-T trống) - 2026-07-19:
      1. **Bug popup rỗng**: đổi cơ chế lưu định nghĩa từ `<span hidden>` sang `data-gloss-def`
         attribute trên nút bấm - một số extension trình duyệt tự rỗng hoá nội dung element có
         `hidden` (nghi hidden-text/cloaking), giờ không còn element nào bị đánh dấu hidden.
         Verify bằng browser thật (Claude Chrome) - popup hiện đúng nội dung + screenshot xác nhận.
      2. **Ưu tiên link nội bộ hơn icon "i"**: 10/12 thuật ngữ đã có bài viết riêng trên site
         (DR, DA, E-E-A-T, Core Web Vitals, canonical, GEO, crawl budget, Schema Markup, dofollow,
         nofollow) -> chuyển 219 lượt từ icon "i" sang link nội bộ thẳng tới bài đó (98 bài đổi).
         Còn 3 thuật ngữ giữ icon "i" (chưa có bài riêng): Anchor Text, referring domain,
         topical authority. Rule cập nhật: `.claude/rules/external-link-eeat.md`.
- [x] Sửa lỗi Hiếu chụp ảnh báo (không liên quan glossary): bài `/backlink-dofollow-va-nofollow/`
      (post 231) có đoạn ví dụ code chứa markdown thô trong href: `<a href="[https://website-cua-ban.com](https://website-cua-ban.com)">`
      - bấm vào link này khiến trình duyệt điều hướng URL bị vỡ (đúng như ảnh chụp của Hiếu). Lỗi
      có sẵn từ khi viết bài (không phải do đợt sửa glossary), phát hiện được vì bài này vừa được
      219 link nội bộ trỏ tới nên lộ ra. Đã quét toàn site (130 bài + 17 trang) - chỉ 1 bài dính lỗi
      này. Sửa href về URL sạch, purge cache, verify lại link hoạt động đúng. Backup:
      `~/Claude-Workspace/_backups/routines/2026-07-19/digicom-markdown-leak-fix/`. 2026-07-19.

Ngoài ra không còn việc gấp - 4 dịch vụ đã đủ nội dung, giá, demo. Tiếp theo tuỳ Hiếu quyết định
khi nào chuyển sang giai đoạn 2 bên dưới.

- [x] Audit toàn bộ site (134 bài blog + 7 money page, không tính cụm Booking báo & PR đã xong
      riêng) qua 9 agent research song song, xác định gap so đối thủ + đề xuất phân lại cụm chủ đề
      - 2026-07-27. Kết quả: `content/audit-toanbo-2026-07-27.csv` (117 dòng chi tiết) +
      `content/audit-toanbo-2026-07-27-cum-de-xuat.md` (đề xuất 16 cụm mới + việc ưu tiên). Đây là
      RESEARCH thuần, CHƯA sửa bài nào - dùng làm cơ sở cho các đợt sửa tiếp theo.

### Backlog rút ra từ audit toàn site 2026-07-27 (chưa làm, chờ ưu tiên)
- [ ] Bổ sung trust signal (MST, năm hoạt động, testimonial thật) cho 7/7 money page - ưu tiên
      cao nhất, ảnh hưởng trực tiếp chuyển đổi.
- [ ] Quyết định số phận `/dich-vu-backlink-tong-quan/` (trang bán hàng ẩn trong category kiến
      thức, giá 3 gói không khớp `dgc_gia`) - gộp vào pillar hay xoá/redirect.
- [ ] Sửa cannibalization xác nhận: `/cach-viet-thong-cao-bao-chi-chuan/` ↔ `/thong-cao-bao-chi-la-gi/`.
- [ ] Sửa số liệu lỗi thời: `/ai-overview/` (tỷ lệ AI Overview), `/semrush/` + `/ahrefs-vs-semrush/`
      (giá gói Semrush One 2026), `/keyword-research/` (giá Ahrefs $129), `/thuat-toan-google/` +
      `/google-core-update/` (thiếu Core Update 5/2026 + Spam Update 6/2026).
- [ ] Sửa `/crawl-budget/` (ngưỡng sai lệch 10-1.000 lần + trích dẫn bịa gán cho Google).
- [ ] Sửa case study không kiểm chứng được ở `/technical-seo/` (lệch phạm vi dịch vụ thật).
- [ ] Áp dụng phân cụm mới (16 cụm) theo `content/audit-toanbo-2026-07-27-cum-de-xuat.md` khi
      làm lại sitemap/menu blog.

### Đợt viết bài lấp gap toàn site 2026-07-27 (tiếp, theo yêu cầu Hiếu "làm trên sheet, viết nốt bài chưa viết")
- Gap-scan 5 file từ khoá gốc (backlink 3752, guest-post 334, pr-báo 370, pr broad-match 14351
  dòng CHƯA từng khai thác, mua-textlink 7) + 3 file mới Hiếu thêm sáng nay (booking/pr/báo chí,
  không volume) đối chiếu 135 bài live -> phát hiện **gap lớn nhất dự án**: cụm "PR (Quan hệ công
  chúng) tổng quát" chưa có bài nào, riêng từ khoá "pr là gì" volume ~8.100 (đơn từ khoá lớn nhất
  từng thấy ở site này). Chi tiết: `content/plan-pr-tongquat-2026-07-27.md`.
- Danh sách 12 bài mới cần viết (ưu tiên booking/PR/báo chí theo yêu cầu): 4 bài cụm PR tổng quát
  (P1-P4) + 1 bài Booking báo Tiền Phong (T1, mã R16 đã ghi trong pivot-2026-07.md) + 5 bài cụm
  Backlink (B1-B5: Audit/Profile, Indexer, Disavow, Loại backlink, Social backlink) + 2 bài Guest
  Post (G1-G2). Sổ cái cụm mới: `content/cluster-pr-tongquat.md`.
- [x] Toàn bộ 12/12 bài ĐÃ ĐĂNG LIVE - 2026-07-27: P1 `/pr-la-gi/` (4722), P2 `/cac-loai-hinh-pr/`
      (4728), P3 `/case-study-chien-dich-pr/` (4732), P4 `/mo-hinh-race-pr/` (4737), T1
      `/book-bao-tien-phong/` (4720, cụm booking-báo 22/22), B1 `/backlink-audit/` (4739), B2
      `/backlink-indexer/` (4751), B3 `/disavow-backlink/` (4749), B4 `/cac-loai-backlink/`
      (4746), B5 `/backlink-mang-xa-hoi/` (4759), G1 `/guest-post-forbes/` (4763), G2
      `/pitch-guest-post/` (4761). Sổ cái: `content/cluster-pr-tongquat.md` (4/4),
      `content/cluster-backlink-gap.md` (5/5), `content/cluster-guest-post-gap.md` (2/2).
- [ ] Submit Google Search Console cho các bài chưa submit được (phần lớn B1-B5, G1-G2, T1 -
      phiên trình duyệt agent không có session Google đăng nhập sẵn) - Hiếu tự đăng nhập rồi
      submit tay, hoặc chờ sitemap tự crawl.
- [ ] Site-wide: KHÔNG có thẻ `<meta name="description">`/Open Graph ở bất kỳ trang nào (RankMath
      không active) - phát hiện khi viết P1, đã spawn task riêng cho Hiếu, chưa xử lý.

### Backlog (giai đoạn 2 - sau khi 4 dịch vụ ổn định)
- [ ] Mở lại Thiết kế website / Tên miền / Hosting / Bản quyền phần mềm (trang đang draft, giữ nguyên)
- [ ] Cổng đăng ký/thanh toán thật
- [ ] Client area / quản lý dịch vụ

### Schema toàn site (2026-07-27) - ĐÃ XONG
- [x] Dựng `inc/schema.php` - 1 khối @graph/trang, 0 lỗi trên validator.schema.org (169 URL).
- [x] Gỡ 108 khối JSON-LD nhúng trong 58 bài, chuyển 197 câu FAQ sang meta có ô sửa ở WP Admin.
- [x] Offer giá thật theo từng đầu báo (18 bài), OfferCatalog hạng mục phổ biến, fix @id trùng
      giữa trang phân trang và trang 1.
- [x] `inc/seo-meta.php`: meta description + Open Graph + Twitter Card + canonical trang lưu trữ +
      ô "SEO & Schema" sửa tiêu đề/mô tả từng bài trong WP Admin. QA 171 URL = 0 lỗi.
- [x] `tools/schema-vocab-check.py` - kiểm định theo từ vựng schema.org chính thức, quét cả site
      (thay cho validator.schema.org bị giới hạn 429). Bắt được lỗi `inLanguage` trên EntryPoint.
- [ ] **Cần Hiếu làm:** thiết kế 1 ảnh chia sẻ 1200x630 của DigicomVN rồi điền vào WP Admin >
      DigicomVN > mục 0 > "Anh chia se mac dinh". Hiện đang fallback về logo (1278x363) nên khi
      share Facebook/Zalo bị viền trên dưới. (KHÔNG dùng `ogimagedn.jpg` ở thư mục gốc - đó là
      logo Báo Đà Nẵng, không phải của Digicom.)
- [ ] Bật Review/AggregateRating khi có đánh giá khách hàng thật (tên + nội dung khách viết).

### Trang /cau-hoi-thuong-gap/ (2026-07-29) - ĐÃ DỰNG CODE, CHỜ VERIFY
- [x] `inc/faq-page.php`, `page-cau-hoi-thuong-gap.php`, hook auto-tạo page trong `functions.php`,
      option `faq_page_extra` (12 câu research SERP/PAA), schema FAQPage, link footer/menu.
- [ ] Hiếu mở Local, Start site "digicom" (session này không có công cụ điều khiển desktop để tự
      bấm) -> trang tự tạo ở lần load đầu -> mở `http://digicom.local/cau-hoi-thuong-gap/` xem
      thực tế (chỉ mới lint PHP, chưa xem trình duyệt).
- [ ] Chạy `tools/schema-qa.py` + `tools/meta-qa.py` sau khi site chạy được.
- [ ] Nếu site dùng WP Admin > Giao diện > Menu (custom nav menu) thay vì menu fallback trong
      code -> thêm link "Câu hỏi thường gặp" vào đó (menu code fallback chỉ áp dụng khi CHƯA có
      custom menu).
- [ ] Rà trùng lặp giữa `faqs`/`faq_page_extra` (mới) và nội dung `svc_faqs` hiện có trên live/DB
      thật (session này không truy cập được DB để đối chiếu).

### Audit "vị trí đăng" báo (2026-07-29) - 1 lỗi đã fix, 1 lỗi lớn hơn đang chờ quyết định
- [x] Fix lỗi gộp vị trí booking-pr (`export-web.py` KEY_CHI_TIET) - booking-pr 303 -> 568 dòng.
- [x] Wire nút "V" (ảnh minh hoạ vị trí thật) vào bảng giá - tính năng có sẵn từ 2026-07-18
      nhưng chưa từng hoạt động (chưa render ở đâu).
- [x] Xây bảng alias 123 tên báo -> domain thật (113 tự động đối chiếu với domain có sẵn trong
      data, 10 verify qua WebSearch) - khôi phục thêm 382 dòng. Tiện fix luôn bug `fold()` gốc
      (no-op "đ"->"d") ảnh hưởng mọi bộ lọc trong export-web.py.
- [x] Kết quả cuối: booking-pr 303 -> **950 dòng** (x3.1), tổng gia-web.csv 1190 -> 1837 dòng.
      Vnexpress.net: 1 -> 22 vị trí. ~40 tên còn mơ hồ (Molistar, Wow, Otofun...) CỐ Ý chưa
      alias, vẫn bị loại - an toàn hơn đoán sai domain giá.
- [x] Deploy 10 file theme + đẩy dữ liệu giá lên LIVE (digicomvn.com) - 2026-07-29.
      Backup DB + theme trước khi làm: `~/Claude-Workspace/_backups/routines/2026-07-29/
      live-deploy-vitri-fix/` (db-BEFORE.sql, theme-BEFORE.tar.gz).
      Sự cố nhỏ: thiếu `inc/post-sidebars.php` trên live gây Fatal Error ~1-2 phút, đã deploy
      nốt file và khắc phục ngay.
      Kết quả: dgc_gia publish 1175 -> 1625 (176 cập nhật giá + 450 tạo mới, 369 giữ nguyên vì
      khớp bản ghi đang draft - không hồi sinh oan, 20 mơ hồ giữ nguyên). VnExpress.net 1 -> 18 bài.
      Trang `/cau-hoi-thuong-gap/` sống (37 câu hỏi), nút "V" hiện 190 lần trên `/bang-gia/`.
- [x] Batch 2 (2026-07-30): đẩy nốt 13 alias mới xác minh lên live. Phát hiện + fix bug
      `recover-vitri.py` (nhiều dòng CSV khác quy_cách bị gộp nhầm vào 1 ID live, ghi đè giá
      cho nhau) - sau fix: 57 update sạch (không trùng ID) + 170 tạo mới. dgc_gia publish
      1625 -> 1795.
- [x] Đồng bộ dữ liệu giá vào Local WP (dev site) - dùng lại pipeline recover-vitri (bản
      local, dump qua wp-cli trực tiếp không cần SSH). Local từ 209 -> **2001 bài publish**
      (1792 tạo mới + 2 cập nhật giá), khớp dữ liệu với live để test theme đáng tin cậy hơn.
- [x] Batch 3 (2026-07-30): xác minh qua WebSearch 8/8 tên còn lại có thể xác định được domain
      thật - Sài gòn giải phóng (sggp.org.vn), Molistar (molistar.com), Viez (viez.vn),
      Phunusuckhoe (phunusuckhoe.vn), Sinh viên việt nam (svvn.tienphong.vn), Yacht Style
      (yachtstyle.vn), Men's Folio (mensfolio.vn), Wow (worldofwatches.vn - KHÔNG phải
      Wowweekend, xác minh qua cùng batch LUXUO MEDIA với Yacht Style/Men's Folio). Còn lại
      thật sự không xác định được (Blogtamsu mơ hồ 4 domain, Vnmedia đã tạm dừng, "Mua bán nhà
      đất" quá chung chung) - vẫn giữ nguyên KHÔNG alias theo rule an toàn.
      gia-web.csv 1868 -> 1880 dòng. Đẩy live: dgc_gia publish 1795 -> **1830** (35 dòng, loại
      6 dòng booking-truyen-hinh khỏi batch - phát hiện nhóm TV "tạm ẩn" theo pivot 2026-07-16
      đã bị batch đầu vô tình publish 19/33 dòng, không mở rộng thêm sai lệch này).
      Đồng bộ Local: 2001 -> **2036** bài.
- [x] Bảng giá quá dài (1212 dòng booking-bao-pr) - Hiếu chọn: đếm giới hạn theo ĐẦU BÁO
      (không theo dòng vị trí con) + thêm bộ lọc Excel (Khoảng giá, Điểm DR) cạnh bộ lọc có
      sẵn (ngành/loại link/số ảnh/độ dài). Sửa `inc/cpt-gia.php` (dgc_facet_value + 2 nhóm lọc
      mới, mode max/range) + `assets/js/main.js` (applyFilter đếm theo topRows, không mồ côi
      dòng con). Sự cố deploy: quyền file `700` sau `mv` từ thư mục scp tạm -> main.js 403,
      đã `chmod 644` + purge cache. Verify qua Browser thật: mặc định 10 báo (trước 1212),
      lọc "vnexpress" còn 2 báo, lọc "Trên 20 triệu" còn 10 báo/52 dòng - đúng thiết kế.
      DGC_VER 2.1.8 -> 2.1.9. Đã đồng bộ live + Local WP.
- [x] Đổi cây vị trí sang MẶC ĐỊNH THU GỌN (đảo ngược quyết định 2026-07-29 theo yêu cầu
      Hiếu) + thêm cột khoảng giá trên dòng gốc (min-max cả nhóm) + bộ lọc mới "Vị trí đăng"
      (Trang chủ/Chuyên mục/Tiểu mục/Doanh nghiệp viết). Verify: mặc định 10 dòng = 10 báo,
      bấm "Mở rộng vị trí" xổ đủ, lọc vị trí hoạt động đúng. DGC_VER 2.1.9 -> 2.2.0.
- [x] Nút "Xem thêm" tự nạp khi cuộn (bỏ IntersectionObserver không chắc chắn -> scroll
      listener + setTimeout). DGC_VER -> 2.2.2. Verify: cuộn tự nạp liên tục 10 -> 418/418 báo.
- [x] Fix bug bộ lọc Khoảng giá: dòng gốc hardcode data-price="0" vô tình khớp mọi filter
      "dưới X triệu" -> đổi thành giá thấp nhất thật trong nhóm. DGC_VER -> 2.2.3.
- [x] Tách "Nhóm báo" ra cột dọc trái (`inc/price-sidebar.php`, mới) + gọn thanh lọc ngang
      (bỏ dropdown nganh, thu nhỏ padding) + mở rộng Khoảng giá (6 mức, có "Dưới 1 triệu") và
      Điểm DR (thêm "Dưới 10"). Verify: sidebar 26 mục, lọc đúng, "Dưới 1 triệu" = 197 báo.
      DGC_VER -> 2.3.0.
- [x] Fix bug phân loại "Loại hình báo": bao-tinh chỉ gán 2/446 báo (nhãn NCC quá thưa) - đổi
      sang nhận diện theo tên miền `bao<tỉnh>.vn`, gán thêm 183 dòng. Gỡ nhầm `bao-lon` khỏi
      `wiki.batdongsan.com.vn` (không phải báo). Thêm icon mũi tên xoay vào nút "Mở rộng vị
      trí". Sửa `gan-nganh.py` để áp tự động cho báo/site mới. DGC_VER -> 2.3.1.
- [x] To cot "Nhom bao" (200->260px, chu 13.5->15.5px) + lam gon thanh cuon (thin, mau nhat).
      DGC_VER -> 2.3.10.
- [x] 3 lua chon xem bang gia (`inc/price-view-options.php`, moi) tren `/bang-gia/`: (1) Tai
      PDF tong hop 7 nhom dang publish, (2) Xem live Google Sheet (option moi `sheet_view_url`,
      WP Admin > DigicomVN > muc 3 - nut tu an neu de trong), (3) xem ngay tren trang (anchor
      xuong bang chi tiet). DGC_VER -> 2.3.11.
- [x] Hoan tat dong bo Google Sheet (2026-07-31): Hieu tao service account
      (`digicom-sheet-sync@digicom-price-sync.iam.gserviceaccount.com`) + tao sheet trong tu
      share Editor (service account KHONG co dung luong Drive rieng - storageQuota=0, khong
      tu tao file duoc, day la gioi han chuan cua Google, khong phai loi cau hinh). Da fix
      script `sync-google-sheet.py`: bo qua key `_meta` trong publish-gia.json (gay
      KeyError 'label'), doi logic tu "tu tao spreadsheet" sang "dung spreadsheet_id co san
      trong google-sheet-config.json", set quyen "anyone-with-link xem" thanh cong (rieng
      quyen khoa tai/copy chi owner (Hieu) moi doi duoc - service account la Editor khong du
      quyen, da boc try/except khong dung script). Chay sync lan dau: 7 tab, 1811 dong (Booking
      bao&PR 1212, Guest Post 225, Mua Textlink 335, Toplist 21, Backlink quoc te 18; Dich vu
      Backlink + Social Entity dang 0 dong vi CPT dang draft toan bo, dung theo pivot). Da set
      option `sheet_view_url` tren live qua wp eval + purge cache - nut "Xem live tren Google
      Sheet" da hien tren `/bang-gia/`. Link:
      https://docs.google.com/spreadsheets/d/1qF7o6WYno1PJCtUFQ5Sv-I3RQGB7tx3SxogMcc2Wxaw/edit
      Da noi vao
      routine tuan `digicom-gia-doi-tac-tuan` (buoc 5b) de tu cap nhat PDF+Sheet moi tuan.
- [x] Watermark + chong "an cap" bang gia PDF (Hieu 2026-07-30): thay `generate-pdf.py` (Chrome
      CLI, watermark loi - position:fixed KHONG lap lai theo trang khi in) bang
      `10-bang-gia-booking/generate-pdf.js` (Node + puppeteer-core, ket noi Chrome co san khong
      tai Chromium rieng). PDF gio co: watermark "DIGICOMVN.COM" lap deu MOI trang (background
      SVG tile tren `<body>`, khong dung position:fixed), header/footer LAP LAI that su moi
      trang (CDP `page.pdf({headerTemplate,footerTemplate})`) ghi ro hotline/email/website +
      dong ban quyen "vui long khong sao chep/phat tan". Contact lay tu `dgc()` qua `_meta`
      trong `publish-gia.json` (sua `dump-publish-gia.php` them block `_meta`), khong hardcode.
- [x] Cong chan lead truoc khi nhan PDF/Sheet (Hieu 2026-07-30, doi y giua chung): nut (1) va
      (2) khong con href tinh - bam mo modal (`#pvoModal`) bat nhap Ho ten/SDT/Email, submit
      AJAX (`dgc_gate_lead`, `functions.php`) luu CPT `dgc_lead` + `wp_mail` bao ve
      `lead_email`, tra ve link that qua JSON roi JS moi `window.open`. DGC_VER -> 2.3.13.
      Da QA: submit thu tren live, lead luu dung (`wp post list --post_type=dgc_lead`), AJAX
      tra dung URL PDF - da xoa lead test. Bug da gap+sua: CSS `.pvo-modal{display:flex}` de
      luon hien de cho ca khi co attribute `hidden` (thieu selector `[hidden]`) - lam modal
      che kin trang ngay luc tai; va script doc bien `DGC_GATE` (localize o wp_footer) qua
      SOM lam listener khong gan duoc - da boc trong `DOMContentLoaded`.
      **Con thieu**: chi moi gui EMAIL, CHUA gui Zalo tu dong (can Zalo OA + API rieng, chua
      setup - hoi Hieu co muon lam tiep khong).
- [x] Thiết kế lại bảng giá thành "thẻ" to/rõ ràng, giữ nguyên table/JS lọc-sắp xếp-tick chọn
      (Hiếu 2026-07-31: "to, rõ ràng từng báo, xem toàn cục được mà xem chi tiết từng báo cũng
      dc, tạo cảm giác tương tác gần gũi dễ chịu"). CHỈ sửa CSS (`main.css`, khối cuối file,
      bọc trong `@media(min-width:641px)` để không đụng layout card mobile <=640px đã có sẵn)
      + 1 đoạn JS nhỏ (`main.js` hàm `regroup()`).
      - `border-collapse:separate;border-spacing:0 10px` - mỗi báo/site cách nhau 1 khoảng
        trống thay vì dòng kẻ sát nhau; mỗi dòng có nền + bo góc + đổ bóng nhẹ, bóng đậm hơn
        khi hover (cảm giác "thẻ" tương tác được).
      - Chữ to hơn: tên báo 17px đậm (trước ~14-15px), giá 21px đậm (trước 16.5px), logo 36px
        (trước 28px), chip DR to/đậm hơn.
      - Nút "Mở rộng vị trí" đổi thành nút bo tròn đầy đủ, tô màu brand khi đang thu gọn (rõ
        ràng hơn là còn có thể bấm xem thêm).
      - Dòng vị trí con (sau khi mở rộng) tách biệt: nền nhạt hơn + viền trái màu teal thay
        cho đường kẻ "cây" nối liền cũ (không còn hợp vì có khoảng cách giữa các dòng).
      - Thêm hiệu ứng mờ dần (`.row-anim`, `@keyframes dgcRowIn`) khi 1 dòng vị trí vừa hiện ra
        - JS gắn/gỡ class ngay lúc chuyển từ ẩn sang hiện trong `regroup()`.
      - Verify qua JS trên live: border-spacing/bo góc/font-size đúng thiết
        kế; bấm "Mở rộng vị trí" ra đúng `row-anim` + nền/viền dòng con; dark mode tự đổi màu
        đúng (dùng biến `--surface-2`/`--heading`, không hardcode); mobile 375px vẫn giữ nguyên
        layout card lưới cũ (`display:grid`, bo góc 14px) - không bị đè bởi CSS desktop mới.
      DGC_VER 2.3.13 -> 2.4.0. Đồng bộ live.
- [x] Tối ưu hiệu năng + sửa lỗi hiển thị mobile bảng giá (Hiếu 2026-07-31: "bản di động vẫn
      lỗi hiển thị nhiều lắm" + "trang cũng đang bị nặng quá, hay đơ lag"):
      - Nguyên nhân nặng: cả 7 tab (2168 dòng, 57.000 node DOM, 1390 ảnh) tải sẵn cùng lúc dù
        chỉ 1 tab hiện. Sửa bằng "lazy hydrate" - tab chưa mở nằm trong `<template>` (trình
        duyệt không dựng/tải ảnh), bấm mở mới bơm nội dung thật + gọi `dgcInitPricePanel()`
        (tách hàm riêng trong `main.js` để gọi lại được). Còn 38.595 node lúc tải trang (-32%).
        Đã test kỹ: chuyển tab qua lại, tìm kiếm, tick chọn nhiều báo khác tab đều hoạt động
        đúng (rủi ro cao nhất của đợt sửa này).
      - Fix 2 lỗi hiển thị mobile: (1) nút Zalo nổi đè lên thẻ "Tải PDF tổng hợp" ngay lần tải
        đầu - `.price-view-opts{margin-right:60px}` ở mobile để chừa chỗ. (2) Nút "Mở rộng vị
        trí" (đợt làm to cho desktop trước) đè lên số giá cạnh bên trên mobile - hạ kích thước
        riêng cho mobile.
      - Làm đẹp khối "Bạn muốn xem bảng giá theo cách nào?" theo yêu cầu Hiếu: to hơn, icon có
        bóng đổ màu, nhấc lên khi hover/chạm.
      - DGC_VER 2.4.0 -> 2.4.3. Đồng bộ live, verify bằng JS đo toạ độ phần tử trực tiếp trên
        live (ảnh chụp trình duyệt không ổn định trong phiên này).
- [x] Sửa lỗi bộ lọc "Điểm DR" + phân biệt thẻ mẹ/con khi mở rộng (Hiếu "làm đi" + góp ý thêm
      2026-07-31). `inc/cpt-gia.php`: dòng gộp lấy DR CAO NHẤT cả nhóm (không chỉ vị trí đầu),
      truyền DR này xuống CẢ dòng con (trước đó dòng con giữ DR riêng thường =0, khiến JS
      fallback vẫn lọt bộ lọc sai dù dòng gốc đã đúng). Verify: "DR dưới 10"/"DR 70 trở lên"
      ra đúng nhóm báo tương ứng; số nhóm có chip DR tăng 5/228 -> 44/194. Thêm CSS phân biệt
      `.bao-group-cont` cho MOBILE (trước chỉ có ở desktop, quên áp mobile khiến thẻ mẹ/con
      giống hệt nhau trên điện thoại): nền tinted nhạt, viền trái teal 3px, thụt lề, bỏ đổ
      bóng. DGC_VER -> 2.4.4.
- [x] Làm lại bảng giá thành lưới cuộn ảo "kiểu Excel" (Hiếu 2026-08-01: "số lượng dữ liệu
      quá lớn hiển thị kiểu này thì ko ăn thua, bị nặng máy và ko nhìn được tổng quan").
      - Dựng mockup (Artifact) trước, Hiếu duyệt + góp ý (nút xổ chi tiết cạnh tên báo, mặc
        định giao diện sáng) rồi mới làm bản thật.
      - Kiến trúc: server xuất JSON gọn/tab (tên/DR/khoảng giá/facet lọc) thay bảng HTML đầy
        đủ; `assets/js/price-grid.js` chỉ vẽ ~19-27 dòng trong khung nhìn (virtual scroll),
        cuộn tới đâu vẽ tới đó. Mở 1 báo -> AJAX lấy chi tiết, tái dùng 100% hàm PHP cũ
        (`inc/price-grid.php`), không mất tính năng (bảng giá nhiều bậc, "gói gồm gì", ảnh
        vị trí thật, giới thiệu báo).
      - Sửa giỏ hàng (`main.js`): `collect()` cũ quét checkbox đang có trong DOM - với lưới ảo
        dòng đã tick có thể bị gỡ khỏi DOM lúc cuộn nên rớt khỏi tổng tiền. Đổi sang "sổ đăng
        ký" theo key, độc lập với việc dòng có đang hiển thị hay không (áp cho cả bảng cũ).
      - QA trên live qua JS: tìm kiếm/lọc/sắp xếp/mở chi tiết/tick chọn/lưu localStorage qua
        lần tải lại/chuyển 7 tab đều đúng. Fix 3 lỗi phát hiện lúc test (reset cuộn khi đổi bộ
        lọc, bộ lọc giá cho báo nhiều vị trí, tab mới mở lần đầu chưa tự khởi động lưới).
      - Kết quả: HTML trang 4,6MB -> 456KB (giảm 10 lần), số dòng thực sự nằm trong DOM lúc
        xem giảm từ ~2168 xuống ~19-27 dòng bất kể cuộn tới đâu. DGC_VER 2.4.4 -> 2.5.6.
      - Đánh đổi: crawler không chạy JS chỉ thấy noscript rút gọn (tên+giá), chi tiết phong
        phú chỉ hiện khi bấm mở + có JS - đánh đổi đã được Hiếu chấp nhận từ đợt lazy-load
        trước, không phải điểm mới.
- [x] Internal link audit toàn site (2026-08-13) - skill mới `.claude/skills/internal-link-audit/SKILL.md`
      (chuyển thể từ ICD, dùng REST API thay Screaming Frog):
      1. Task 1+2 (link chết/redirect chain, money page mồ côi) - xong trước đó (2026-08-12).
      2. Task 3 - giảm anchor over-optimization `booking-bao-pr` (118 inlink) + `dich-vu-backlink`
         (40 inlink, giảm từ 42 sau khi xoá link dư): tạo `tools/internal-link-anchor-check.py` +
         `tools/diversify-anchor.py`, đa dạng hoá anchor qua nhiều đợt (round 1-3), max anchor còn
         lại 7.5% (dưới ngưỡng 8%). Backup: `~/Claude-Workspace/_backups/routines/2026-08-13/
         anchor-diversify/` + `anchor-diversify-round2/`.
      3. Rule mới chốt Hiếu 2026-08-13: **1 bài KHÔNG được link quá 1 lần tới cùng 1 đích** - quét
         thấy 167 cặp (bài, đích) vi phạm trên 95 bài (230 link dư, đa số CTA lặp `/dat-bai/` hoặc
         cụm SEO thuật ngữ nhắc lại nhiều đoạn). Đã dọn hết bằng script tự động (giữ link đầu tiên
         xuất hiện, xoá wrapper `<a>` các lần lặp sau, giữ nguyên text) - verify bằng diff ký tự
         trên bài mẫu trước khi push cả 95 bài. Backup:
         `~/Claude-Workspace/_backups/routines/2026-08-13/dedupe-onelink-per-post/`.
      4. Re-audit sau cùng: 0 vi phạm anchor over-optimization ở 2 pillar chính, 0 vi phạm
         "1 link/bài" toàn site. Các URL chỉ 1-2 inlink báo "100%" trong anchor-check là artifact
         số lượng nhỏ, không phải lỗi thật - không cần xử lý.
- [ ] Việc còn lại (không khẩn, cần Hiếu quyết định):
      1. 33 dòng `booking-truyen-hinh` hiện có 19 publish/14 draft không nhất quán trên live -
         chọn draft lại 19 dòng đó (giữ đúng quyết định "tạm ẩn") hay chính thức mở nhóm TV.
      2. Blogtamsu/Vnmedia/"Mua bán nhà đất" - chỉ alias nếu Hiếu cung cấp domain xác nhận.
      3. Nối sync Google Sheet vào routine tuần `digicom-gia-doi-tac-tuan` để tự đồng bộ
         (LƯU Ý: nút "Xem live trên Google Sheet" + option `sheet_view_url` đã xoá cùng
         `/bang-gia/` 2026-08-09 - nếu nối lại sync, cần tìm nơi hiển thị mới, không phải
         `inc/price-view-options.php` nữa vì file đó đã xoá).
      4. ~~Tab "Guest Post/Dịch vụ Backlink/..." trên /bang-gia/ giờ chỉ render khi bấm mở~~ -
         HẾT HIỆU LỰC: `/bang-gia/` đã bỏ hẳn (xem mục 2026-08-09 bên dưới), việc còn lại là
         đảm bảo mọi trang dịch vụ pillar tự index đủ giá của chính nó (đã vậy từ trước).
- [x] Bỏ hẳn trang tổng hợp `/bang-gia/` - mọi trang dịch vụ là money page riêng (Hiếu 2026-08-09:
      "T ko muốn gg hiểu nhầm đích đến là trang bảng giá, các trang dịch vụ sẽ là money page").
      - Xoá `page-bang-gia.php` + `inc/price-view-options.php` (cổng chặn tải PDF/Google Sheet
        tổng hợp giá) + handler `dgc_handle_gate_lead`/`DGC_GATE`/option `sheet_view_url` liên quan
        trong `functions.php`/`inc/options.php` - không giữ để rollback (đây chính là nguồn gây
        hiểu nhầm, không phải tính năng cần bảo lưu).
      - Thêm `template_redirect` ưu tiên 1 trong `functions.php`: `is_page('bang-gia')` -> 301 về
        trang chủ, phòng khi Hiếu chưa kịp chuyển page "bang-gia" trong DB sang Draft/Trash.
      - Đổi hướng toàn bộ CTA/link từng trỏ `/bang-gia/` trên header, footer, bottom-nav, hero
        trang chủ, popup/ribbon ưu đãi, blk-reasons, budget calc, agency-check, offpage-quiz,
        press-partners, FAQ trang dịch vụ, sidebar bài blog, trang cảm ơn, trang câu hỏi thường
        gặp, AI chat, search.php, service-pricing.php - đích mới tuỳ ngữ cảnh: `/dat-bai/`
        (form gửi yêu cầu, đa số trường hợp), `#bang-gia` (cuộn tới bảng giá của CHÍNH trang
        dịch vụ đang xem), hoặc `/#services` (link sang các dịch vụ khác).
      - Cập nhật rule: `.claude/rules/uu-dai-cta.md` (mục mới), `bang-gia-booking.md`, `ui-mau-sac.md`
        (qua bang-gia-booking.md), `schema-markup.md` (bỏ CollectionPage cho `/bang-gia/`),
        `pivot-2026-07.md` (sitemap + theme files).
      - CHƯA LÀM (cần Hiếu, không đụng được DB từ phiên code này): vào WP Admin > Trang, chuyển
        page "Bảng giá" (slug `bang-gia`) sang Draft hoặc Trash, gỡ khỏi menu điều hướng nếu WP
        Admin có tạo menu item riêng cho nó (header.php chỉ dùng menu fallback khi CHƯA có menu
        `primary` trong WP Admin - nếu Hiếu đã tạo menu thật thì mục "Bảng giá" nằm trong đó,
        code không sửa được). Cũng nên xoá noindex/sitemap cache liên quan nếu có.
