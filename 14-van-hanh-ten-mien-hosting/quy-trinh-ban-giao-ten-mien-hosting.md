# Quy trình bàn giao tên miền, hosting cho khách (DigicomVN)

Cập nhật 29/10/2026. Áp cho mọi đơn tên miền (thanh toán QR trên /ten-mien/) và đơn hosting (form báo giá trên /hosting/).

## 1. Đơn tên miền (khách tự thanh toán trên web)

1. Khách thanh toán -> đơn chuyển "Đã thanh toán, đang đăng ký" (tự động khi có key SePay, chưa có thì Hiếu xác nhận tay trong WP Admin > Đơn tên miền). Khách tự nhận email "đã nhận thanh toán".
2. Hiếu đăng ký tên miền ở trang đại lý, đứng tên đúng chủ thể khách đã khai (tên, CCCD/MST, địa chỉ trong đơn). Đuôi .vn: hoàn thiện bản khai/định danh chủ thể theo yêu cầu của nhà đăng ký.
3. Áp quà tặng của đơn (ghi trong email đơn hàng) bằng mã khuyến mãi bán lẻ lúc đăng ký.
4. Đăng ký xong: mở đơn trong WP Admin, chọn trạng thái "Đã đăng ký xong" -> Cập nhật. Khách tự nhận email "đã đăng ký xong" kèm hướng dẫn quản trị tên miền.
5. Nếu khách cần trỏ DNS ngay: bấm "Gửi email bàn giao quản trị" trong đơn, điền ngày hết hạn + nameserver đang dùng, gửi.

## 2. Đơn hosting (khách gửi form, chốt qua điện thoại/Zalo)

1. Báo giá, nhận chuyển khoản vào MB 567898838 (nội dung: tên miền + tên khách).
2. Tạo gói hosting ở trang đại lý, áp quà tặng đúng điều kiện gói (khối "Quà tặng khi đăng ký hosting mới" trên /hosting/).
3. Lấy thông tin quản trị đại lý cấp: đường dẫn cPanel, tên đăng nhập, mật khẩu, IP máy chủ, nameserver.
4. Nếu tên miền mua cùng DigicomVN: trỏ nameserver về hosting luôn. Tên miền của khách ở nơi khác: gửi khách nameserver/IP để họ tự trỏ.
5. Cài sẵn nếu khách yêu cầu: WordPress, SSL miễn phí, email theo tên miền.
6. WP Admin > Đơn tên miền > **Bàn giao dịch vụ**: điền email khách, gói, cPanel, mật khẩu, IP, nameserver, ngày hết hạn -> Gửi email bàn giao.

## 3. Nguyên tắc

- Mật khẩu chỉ gửi trong email bàn giao, không lưu trên web, không gửi qua Zalo nhóm. Nhắc khách đổi mật khẩu sau lần đăng nhập đầu.
- Không nhắc tên nhà cung cấp/đại lý với khách. Khách chỉ làm việc với DigicomVN.
- Tên miền luôn đứng tên khách (không đứng tên DigicomVN), để khách sở hữu thật.
- Hỗ trợ kỹ thuật: khách chỉ cần báo tên miền, DigicomVN không xin lại mật khẩu cPanel của khách.
- Ghi ngày hết hạn tên miền/hosting của từng khách để nhắc gia hạn (hiện chưa có nhắc tự động).

## 4. Cổng quản trị cho khách cuối

Kiểm trên trang đại lý 29/10/2026 (chỉ xem, chưa đổi cài đặt nào):

- **Có cổng quản trị tên miền mang thương hiệu riêng** (Thông tin tài khoản > Cấu hình Control Panel > "Cấu hình Control Panel riêng"): trỏ 1 tên miền phụ (vd quanly.digicomvn.com) CNAME về máy chủ của đại lý, đặt logo, tên, favicon, nameserver riêng. Khách đăng nhập vào đó để tự sửa DNS, xem ngày hết hạn. Hiện đang TẮT.
- **Tài khoản khách cuối**: mục "Tạo khách hàng mới" (cá nhân/tổ chức, email, CCCD, địa chỉ, điện thoại). Đăng ký dịch vụ cho đúng tài khoản khách đó thì khách thấy dịch vụ của mình trong cổng.
- **Email tự động từ hệ thống đại lý**: "Gửi mail thông báo đến khách hàng sau khi đăng ký, gia hạn" đang BẬT; mẫu email (Quản lý Template: Hosting Linux cPanel, Domain Email...) đang dùng mẫu mặc định; có "Email Footer" và "Cấu hình SMTP" để gửi bằng email của Digicom. Rủi ro: email mặc định có thể mang thương hiệu đại lý tới khách.
- Whois quốc tế hiển thị thông tin đại lý: đang Tắt. Email xác thực tên miền quốc tế: dùng email đại lý.

Hiếu duyệt 29/10/2026. Trạng thái:
1. ĐÃ LÀM: tắt "Gửi mail thông báo đến khách hàng sau khi đăng ký, gia hạn" (Không). Email Footer đổi sang DigicomVN (pháp nhân, địa chỉ, hotline, sales@, website). Tên Control Panel Domain + Tổng Đài = DigicomVN.
2. ĐÃ ĐIỀN SMTP (chưa lưu, thiếu mật khẩu): host smtp.larksuite.com, cổng 465 SSL, user + From Mail sales@digicomvn.com, From Name DigicomVN. Hiếu tạo mật khẩu ứng dụng trong Lark Mail (Cài đặt > IMAP/SMTP), dán vào ô Password ở trang đại lý > Cấu hình SMTP, bấm Lưu cấu hình, rồi gửi thử bằng mục "Kiểm tra chức năng gửi email".
3. ĐÃ LÀM 29/10 11:30: Hiếu thêm CNAME quanly -> mr.pavietnam.vn ở Namecheap (đã lan ra DNS). Đã bật Control Panel riêng = Có, http://quanly.digicomvn.com, tiêu đề 'DigicomVN - Quản lý tên miền', logo https://digicomvn.com/wp-content/uploads/2026/07/logo-digicomvn-300x85.png, nameserver ns1-3.dotvndns.vn (cùng máy chủ với nameserver đại lý nhưng không mang tên đại lý). Còn kiểm trang cổng hiển thị đúng thương hiệu (máy chủ cổng chưa trả lời từ Mac lúc 11:35, có thể đang khởi tạo). (Bản ghi ban đầu: ở Namecheap (digicomvn.com > Advanced DNS): CNAME, Host `quanly`, Value `mr.pavietnam.vn`, TTL Automatic. CNAME `quanly` -> `mr.pavietnam.vn`.)
4. Mẫu email: giữ "template mặc định". Đã đọc cả 16 mẫu: mẫu tên miền VN/quốc tế, hosting cPanel, gia hạn tên miền/hosting, cảnh báo hết hạn chỉ dùng biến [RESELLERNAME], [DOMAINURL], [EMAILFOOTER] (tự lấy thông tin Digicom), không ghi tên đại lý. Chỉ 3 mẫu dịch vụ Digicom KHÔNG bán có ghi cứng tên đại lý: Colocation, Dedicated-Windows, Mailserver (link kb của đại lý). Khi nào bán các dịch vụ này thì chuyển "Customize template" và sửa 3 mẫu đó.
5. Bật lại "Gửi mail thông báo đến khách hàng" sau khi xong bước 2 và 3 (để [DOMAINURL] trỏ về quanly.digicomvn.com, mail gửi từ sales@).
6. Mỗi đơn: tạo tài khoản khách cuối trước, đăng ký dịch vụ dưới tài khoản đó, gửi email bàn giao kèm đường dẫn cổng quanly.digicomvn.com.
