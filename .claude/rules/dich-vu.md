# Danh mục dịch vụ Digicom (digicomvn.com)

> PIVOT 2026-07-02: tập trung DUY NHẤT 4 dịch vụ off-page SEO dưới đây trước khi mở rộng.
> Bản danh mục 4 nhóm cũ (hạ tầng/license/marketing/automation) đã chuyển sang giai đoạn 2,
> các trang tương ứng đang draft - xem `.claude/rules/pivot-2026-07.md`.

## 5 dịch vụ chính (giai đoạn 1)

- **Mua Textlink** - `/dich-vu/mua-textlink/` - chèn link vào bài viết có sẵn, chọn site theo DR/traffic.
- **Dịch vụ Backlink** - `/dich-vu/dich-vu-backlink/` - hệ thống backlink chất lượng, đa nguồn.
  - Ngách Bất động sản - `/dich-vu/dich-vu-backlink/bat-dong-san/`
- **Guest Post** - `/dich-vu/guest-post/` - viết bài + đăng trên site đúng chủ đề, link dofollow.
- **Backlink Social Entity** - `/dich-vu/backlink-social-entity/` - hệ thống hồ sơ social chuẩn NAP,
  nội dung độc bản, làm thủ công; bán theo gói (50/100/200+GStack/300+GStack), giá = 120% giá tham chiếu
  Solann Digital (backlink.solanndigital.com/dich-vu-social-entity), chốt 2026-07-14.
- **Booking báo & PR** - `/dich-vu/booking-bao-pr/` - đặt lịch đăng bài PR trên báo điện tử.
  - Con theo từng đầu báo (DRAFT, chờ Hiếu xác nhận báo thật hợp tác trước khi publish):
    `/dich-vu/booking-bao-pr/vnexpress/`, `/kenh14/`, `/dan-tri/`, `/24h/`, `/cafef/`.

- **Backlink quốc tế** - `dich-vu/backlink-quoc-te/` - guest post / niche edit / link insertion trên
  site quốc tế (theo tầng DR/DA) + đăng bài PR báo quốc tế (Forbes, Business Insider, Yahoo Finance,
  MarketWatch...) + phân phối thông cáo (PR Newswire, EIN Presswire, PRWeb...). Mở 2026-07-14.
## Truyền hình + phát thanh ĐÃ MỞ LẠI 2026-10-24 (Hiếu duyệt hướng cô đặc)
/booking-truyen-hinh/ (2107) và /quang-cao-phat-thanh/ (2440) publish, có trong menu "Truyền hình" và nhóm "Booking truyền thông" trang chủ. Loa phường, màn LED vẫn ẩn như dưới. SEO/Google Ads/Facebook Ads: chỉ 1 dòng "Dịch vụ khác", không làm trang (DECISIONS 2026-10-24).

## 4 nhóm media TẠM ẨN (Hiếu 2026-07-16: lưu dữ liệu giá, chưa đưa lên trang, mở lại sau) - truyền hình/phát thanh nay đã mở, xem mục trên

- **Booking truyền hình** `/booking-truyen-hinh/` (page 2107) - TVC/phóng sự/talkshow VTV, HTV.
- **Quảng cáo loa phường** `/quang-cao-loa-phuong/` (page 2439) - loa truyền thanh xã phường theo khu vực.
- **Quảng cáo phát thanh** `/quang-cao-phat-thanh/` (page 2440) - spot radio VOV/VOH/đài tỉnh.
- **Quảng cáo màn LED** `/quang-cao-man-led/` (page 2441) - LED toà nhà + LCD thang máy theo vị trí.

Trạng thái: 226 dòng giá dgc_gia (33 TV + 18 + 82 + 93) và 4 trang pillar đều DRAFT; đã gỡ khỏi
menu, lưới trang chủ, tab bảng giá (comment trong front-page.php / functions.php / page-bang-gia.php).
Dữ liệu gốc: `10-bang-gia-booking/qc-media-cho-mo/` + ID backup `~/backups/media-hidden-20260716.txt`
(host). Cách mở lại: publish rows + pages, bỏ comment 3 file theme, thêm lại menu.

## Giai đoạn 2 (sau khi 4 dịch vụ trên ổn định)

Thiết kế website, Tên miền, Hosting, Bản quyền phần mềm, SEO/GEO tổng thể, Google Ads,
Automation workflow. Trang cũ giữ nguyên nội dung, đang draft, không xoá (rule
backup-before-edit). Danh mục chi tiết cũ tham khảo trong lịch sử DECISIONS.md trước
2026-07-02 nếu cần khôi phục.

## Lưu ý
- Không bịa tên đầu báo đã hợp tác / case study / số liệu (rule content-professional).
- Giai đoạn 1: form tư vấn/báo giá, KHÔNG giỏ hàng/thanh toán online.

## Booking mạng xã hội (mở 2026-10-24, xem DECISIONS)
- **Booking fanpage** `/booking-fanpage/` - đăng bài trên fanpage báo điện tử và fanpage cộng đồng lớn. Chưa có bảng giá NCC, báo giá theo yêu cầu.
- **Booking KOL/KOC** `/booking-kol-koc/` - KOL, KOC, TikToker, YouTuber, livestream, nghệ sĩ. Bắt buộc nêu nghĩa vụ theo Luật Quảng cáo 75/2025/QH15. Không làm seeding/buff tương tác.

## Tên miền + hosting (mở 2026-10-27)
Nguồn: đại lý P.A Việt Nam - TUYỆT ĐỐI không hiện tên P.A/pavietnam trên site, bảng giá, báo giá, schema (rule bao-gia-khong-lo-gia-von). Khách đặt như dịch vụ của Digicom. Từ 29/10: giỏ + thanh toán QR ngay trên trang (/thanh-toan-ten-mien/, inc/domain-order.php), SePay webhook tự xác nhận (khoá ở WP Admin > DigicomVN ô tm_sepay_key, hoặc DGC_SEPAY_KEY wp-config; chưa có khoá thì Hiếu chọn "Đã thanh toán" trong Đơn tên miền). Đơn sang "Đã thanh toán" (tự hoặc tay) -> tự đăng ký qua API đại lý (DGC_PA_REG_ON đã bật live 29/10, trừ số dư đại lý; lỗi -> "Đăng ký lỗi" + email Hiếu; sửa xong chọn lại "Đã thanh toán" để thử lại, tên miền đã đăng ký không bị đăng ký lại). Form bắt buộc tỉnh + phường theo danh mục 34 tỉnh (assets/data/dvhc.json), giới tính, CCCD + ngày sinh người đại diện nếu là tổ chức. Chạy thử không trừ tiền: define DGC_PA_TEST.
Hosting mua online (29/10, inc/hosting-order.php): nút "Mua ngay" ở /hosting/ cho vào CHUNG giỏ (item {t:'h',k,m,d}), thanh toán QR như tên miền, tiền về -> tự đăng ký register_hosting (amount=1, id gói theo kỳ hạn từ hosting_list, cache 12h) -> email khách: cPanel https://<tên miền>:2083 + mật khẩu (tài khoản trong email kích hoạt), tên miền: quanly.digicomvn.com (tài khoản = tên miền). Giá = đúng giá bán lẻ thị trường (đồng bộ hằng ngày). Hiếu 30/10 (sửa lại cùng ngày): cần lãi 10%. SÀN = giá vốn đại lý x 1,1 cho mọi kỳ hạn hosting và giá gia hạn tên miền (dgc_floor10 trong inc/domain-hosting.php; giá vốn hosting từ hosting_list, giá vốn gia hạn tên miền ở option dgc_tm_cost - nhập từ trang Bảng Giá Domain cổng đại lý, KHÔNG ghi vào code vì repo công khai). 31/10 (Hiếu: không lỗ) ĐÃ BỎ khuyến mãi dưới vốn: MỌI sản phẩm lãi >= 10% trên số tiền THỰC TRẢ đại lý gồm VAT (Hiếu 31/10 tối: "kể cả năm đầu", "mọi sp"): tên miền năm đầu và gia hạn >= thực trả x1,1; hosting/email/SSL/cloud/M365/Workspace/chăm sóc web/BCT: giá đại lý trên cổng là CHƯA VAT, thực trả = giá đại lý x1,1 (đã đối chiếu mục Xem Giao Dịch) nên giá bán >= giá đại lý x1,21. Thực trả (đối chiếu Xem Giao Dịch cổng đại lý): đăng ký đuôi .vn = giá niêm yết - toàn bộ phí dịch vụ (khuyến mãi promo vndaily hoàn lại, vd .vn 700k - 250k = 450k, .com.vn/.net.vn 350k), đã gồm VAT; đuôi quốc tế = giá bảng x1,08 VAT (.com 326k -> 352.080đ). dgc_tm_cost lưu số thực trả; combo đuôi tự tắt nếu dưới tổng vốn x1,1; bỏ quà tặng kèm (.cloud, email, tên miền tặng kèm hosting). Giá thấp nhất đối thủ ở option dgc_tm_market (đuôi => [năm đầu, gia hạn]): giá = max(vốn x1,1, min(giá bán lẻ, giá đối thủ)). So sánh: 10-bang-gia-booking/NOIBO-gia-thi-truong-2026-10-31.csv. Cập nhật dgc_tm_market khi giá đối thủ đổi. Bảng đối chiếu: 10-bang-gia-booking/NOIBO-gia-von-ten-mien-hosting-2026-10-30.csv.
Ô tra tên miền (28/10): tra nhiều đuôi 1 lần qua API whois đại lý (khoá DGC_PA_USER/DGC_PA_KEY chỉ trong wp-config, không commit), dự phòng RDAP; nút Đăng ký -> form lead -> email Hiếu, Hiếu tự đăng ký + thu tiền. Đuôi gợi ý: option tm_suggest.

## Phần mềm SEO (mở 2026-10-27)
Chỉ tài khoản chính hãng: affiliate (rel="sponsored") hoặc mua hộ gói chính hãng. KHÔNG bán tài khoản dùng chung/group buy.

## Dịch vụ website (mở 2026-10-30)
6 trang mẫu tpl-web.php (nội dung + giá mặc định ở inc/web-svc.php, giá sửa WP Admin > DigicomVN mục 12): /thiet-ke-website/ (Digicom tự làm, báo giá theo yêu cầu), /cham-soc-website/, /dang-ky-website-bo-cong-thuong/, /email-doanh-nghiep/, /chung-chi-ssl/, /cloud-server/. Nguồn đại lý (không hiện tên), đặt qua form lead. Giá vốn nội bộ: 10-bang-gia-booking/NOIBO-gia-von-dich-vu-web-2026-10-30.csv.
Mua online (30/10, inc/websvc-order.php): email doanh nghiệp, SSL, cloud server có nút "Mua ngay" vào CHUNG giỏ tên miền/hosting (item {t:'w',s,k,m,u,d}), thanh toán QR + SePay như hosting. Kỳ hạn: email /tháng 1-3 năm, Workspace/M365 12 tháng x số user, SSL 1-2 năm, cloud 1/3/6/12 tháng. Email Pro 1-10 TỰ ĐĂNG KÝ (30/10) qua lệnh register_mailserver (mã gói từ mailserver_list, cache 12h, chỉ khi giá bán >= giá đại lý x1,21 (VAT + lãi 10%); mật khẩu mail gửi khách trong email "đã đăng ký xong"). API đại lý KHÔNG có lệnh cho Google Workspace, Microsoft 365, SSL, cloud (tài liệu api_pavietnam.zip trên cổng đại lý mục API Reseller) -> tiền về thì email Hiếu "[Đơn hàng] ... cần kích hoạt tay", Hiếu kích hoạt ở cổng đại lý rồi chọn "Đã đăng ký xong" trong Đơn tên miền để mail khách. Chăm sóc web, Bộ Công Thương, thiết kế web vẫn qua form lead. Nội dung trang (de-slop 30/10): keys story/img/extra trong dgc_web_svc_conf; thủ tục website theo Nghị định 248/2026 (UBND tỉnh, không còn online.gov.vn cho website bán hàng).

## LÃI TỐI THIỂU dịch vụ đại lý tên miền/hosting (Hiếu chốt 05/11/2026 tối, ĐÈ mức 10% ở trên)
Tên miền NĂM ĐẦU: lãi >= 10% (giá bán >= vốn thực trả x1,1; đuôi .vn tính trên thực trả, .vn 495k -> 545k). MỌI thứ khác (gia hạn tên miền, hosting, email, SSL, cloud, M365, Workspace, chăm sóc web, Bộ Công Thương): lãi >= 15% = giá đại lý chưa VAT x1,1 VAT x1,15 = x1,265. Code: inc/domain-hosting.php (dgc_floor10 ..., 1.265 đặt SAU bump 5% để không hạ giá nào), inc/web-svc.php (dgc_web_rows nâng x1,265/1,21), inc/websvc-order.php (tự đăng ký email khi >= x1,265).

## Email gửi khách: luôn hướng dẫn báo sự cố qua /ho-tro-ky-thuat/ (Hiếu 06/11/2026)
Mọi email gửi khách sau khi dịch vụ đã đăng ký (email "đã đăng ký xong" của đơn, email bàn giao) có khối "BÁO SỰ CỐ KỸ THUẬT" trỏ https://digicomvn.com/ho-tro-ky-thuat/ (hàm dgc_support_line() trong inc/support-ticket.php). Trang này là link trung gian: phiếu tự chuyển tới đội kỹ thuật đại lý (option support_to, WP Admin > DigicomVN mục 11) + CC Hiếu, không lộ tên đại lý. Email mới gửi khách: gọi dgc_support_line().

## Hoá đơn đại lý tự chuyển kế toán (Hiếu 06/11/2026, chuyển lên VPS cùng ngày)
Hoá đơn điện tử đại lý tên miền/hosting (hoadon@pavietnam.vn, về sales@digicomvn.com trên Lark) tự chuyển tiếp kèm PDF + XML tới ketoan.digitocombat@gmail.com, CC hieudx3107@gmail.com. Chạy trên VPS 45.251.115.47 (24/7): cron 10 phút `/opt/pa-hoadon-forward/forward_imap.py run`, IMAP/SMTP Lark bằng mã uỷ quyền sales@ (`/root/.config/pa-hoadon-forward/lark.json`, chmod 600), log `/opt/pa-hoadon-forward/state/run.log`. Nguồn: `~/Claude-Workspace/_global/scripts/pa-hoadon-forward/`. Cài/đổi mã: Hiếu chạy `cai-vps.sh` trong thư mục đó (tự tắt bản Mac `com.hieu.pa-hoadon-forward`). Đổi người nhận: sửa TO/CC trong forward_imap.py rồi scp lên VPS.

## Phiếu hỗ trợ: đại lý trả lời -> tự gửi khách, ẩn tên đại lý (Hiếu chốt 06/11/2026)
- Form /ho-tro-ky-thuat/ bắt buộc email khách, nhận tối đa 4 ảnh (đính kèm mail). Dịch vụ đại lý -> kythuat@pavietnam.vn (option support_to), Reply-To sales@, CC Hiếu; dịch vụ Digicom tự làm -> chỉ Hiếu.
- VPS cron 5 phút `/opt/pa-hoadon-forward/support_relay.py` (nguồn `~/Claude-Workspace/_global/scripts/pa-hoadon-forward/`): thư @pavietnam.vn về sales@ có mã HTyymmddXXX -> tra phiếu qua REST `/wp-json/dgc/v1/ticket/<mã>` (header X-DGC-Key = DGC_TICKET_KEY trong wp-config live, bản sao `/root/.config/pa-hoadon-forward/ticket_key`) -> cắt trích dẫn + chữ ký, đổi tên đại lý thành DigicomVN, bỏ dòng hotline/link đại lý -> gửi khách từ sales@ (BCC Hiếu). Khách trả lời (đúng email khách, có mã) -> chuyển ngược đại lý, CC Hiếu.
- Không gửi khách được (khách không có email, lọc xong còn tên đại lý hoặc trống) -> mail Hiếu "[Cần gửi khách tay]". Log `/opt/pa-hoadon-forward/state/relay.log`. Endpoint REST phải no-cache (LiteSpeed từng cache bản có dữ liệu khách).
