<?php
/**
 * Ban giao ten mien / hosting cho khach (2026-10-29, Hieu: "khach mua xong can vao duoc trang quan tri").
 *  - WP Admin > Don ten mien > Ban giao dich vu: dien thong tin quan tri -> gui 1 email ban giao cho khach.
 *  - Mat khau chi di trong email, KHONG luu vao CSDL. Lich su chi ghi ai gui, gui cho ai, dich vu gi.
 *  - Don ten mien chuyen "Da dang ky xong": email tu dong da kem huong dan quan tri (dgc_hd_domain_guide).
 *  - Khong ghi ten nha cung cap trong email.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/** Huong dan ngan ve quan tri ten mien, dung chung cho email tu dong + email ban giao. */
function dgc_hd_domain_guide() {
	return "Quản trị tên miền:\n"
		. "- Tên miền đứng tên chủ thể đã khai khi đặt mua. DigicomVN quản lý kỹ thuật (DNS, gia hạn) giúp bạn.\n"
		. "- Muốn trỏ tên miền về hosting, email hoặc dịch vụ khác: gửi DigicomVN nameserver hoặc bản ghi DNS cần thêm, DigicomVN cập nhật trong giờ làm việc.\n"
		. "- Muốn chuyển tên miền sang nhà cung cấp khác: DigicomVN hỗ trợ thủ tục chuyển (đuôi quốc tế dùng mã chuyển auth code, đuôi .vn làm theo thủ tục của nhà đăng ký).\n"
		. "- Gia hạn trước ngày hết hạn để tránh gián đoạn: tên miền quá hạn sẽ ngừng hoạt động và có thể bị thu hồi.\n";
}

function dgc_hd_footer() {
	return "\n\nCần hỗ trợ, trả lời email này hoặc gọi " . dgc( 'hotline', '0988 769 317' ) . ".\n\nDigicomVN\nHotline: " . dgc( 'hotline', '0988 769 317' ) . "\nEmail: sales@digicomvn.com";
}

/** Noi dung email ban giao tu du lieu form. Tra ve array( subject, body ). */
function dgc_hd_build_mail( $f ) {
	$has_d = ! empty( $f['domain'] );
	$has_h = ! empty( $f['cp_url'] ) || ! empty( $f['cp_user'] );
	$what  = $has_d && $has_h ? 'tên miền và hosting' : ( $has_h ? 'hosting' : 'tên miền' );
	$sub   = 'Bàn giao ' . $what . ( $has_d ? ' ' . $f['domain'] : '' ) . ' - DigicomVN';
	$m     = 'Chào ' . ( $f['name'] ?: 'bạn' ) . ",\n\nDigicomVN gửi bạn thông tin quản trị " . $what . ( $f['code'] ? ' (đơn ' . $f['code'] . ')' : '' ) . ".\n\n";
	if ( $has_d ) {
		$m .= "TÊN MIỀN\n- Tên miền: " . $f['domain'] . "\n";
		if ( $f['exp'] ) $m .= '- Ngày hết hạn: ' . $f['exp'] . "\n";
		if ( $f['ns'] ) $m .= '- Nameserver đang dùng: ' . $f['ns'] . "\n";
		$m .= "\n" . dgc_hd_domain_guide() . "\n";
	}
	if ( $has_h ) {
		$m .= "HOSTING\n";
		if ( $f['plan'] ) $m .= '- Gói: ' . $f['plan'] . "\n";
		if ( $f['cp_url'] ) $m .= '- Trang quản trị (cPanel): ' . $f['cp_url'] . "\n";
		if ( $f['cp_user'] ) $m .= '- Tên đăng nhập: ' . $f['cp_user'] . "\n";
		if ( $f['cp_pass'] ) $m .= '- Mật khẩu: ' . $f['cp_pass'] . "\n";
		if ( $f['ip'] ) $m .= '- IP máy chủ: ' . $f['ip'] . "\n";
		if ( $f['h_ns'] ) $m .= '- Nameserver của hosting: ' . $f['h_ns'] . "\n";
		if ( $f['exp_h'] ) $m .= '- Ngày hết hạn hosting: ' . $f['exp_h'] . "\n";
		$m .= "\nLưu ý bảo mật:\n- Đăng nhập lần đầu xong, đổi mật khẩu trong cPanel (mục Password & Security) và xoá email này hoặc lưu ở nơi an toàn.\n"
			. "- Không chia sẻ tài khoản cPanel. Cần DigicomVN hỗ trợ kỹ thuật, bạn chỉ cần báo tên miền, không cần gửi mật khẩu.\n"
			. "- Trong cPanel có sẵn: cài WordPress (Softaculous hoặc WordPress Manager), tạo email theo tên miền, sao lưu, quản lý SSL.\n";
	}
	if ( $f['note'] ) $m .= "\nGhi chú: " . $f['note'] . "\n";
	return array( $sub, $m . dgc_hd_footer() );
}

add_action( 'admin_menu', function () {
	add_submenu_page( 'edit.php?post_type=dgc_don_tm', 'Bàn giao dịch vụ', 'Bàn giao dịch vụ', 'edit_posts', 'dgc-ban-giao', 'dgc_hd_page' );
} );

function dgc_hd_fields() {
	return array(
		'email'   => array( 'Email khách *', 'email', '' ),
		'name'    => array( 'Tên khách', 'text', '' ),
		'code'    => array( 'Mã đơn (nếu có)', 'text', 'VD DGC123456 - có mã đơn tên miền thì đơn tự chuyển "Đã đăng ký xong".' ),
		'domain'  => array( 'Tên miền', 'text', 'Bỏ trống nếu chỉ bàn giao hosting.' ),
		'exp'     => array( 'Ngày hết hạn tên miền', 'text', 'dd/mm/yyyy' ),
		'ns'      => array( 'Nameserver tên miền đang dùng', 'text', '' ),
		'plan'    => array( 'Gói hosting', 'text', 'Bỏ trống cả nhóm hosting nếu chỉ bàn giao tên miền.' ),
		'cp_url'  => array( 'Đường dẫn cPanel', 'text', 'VD https://ten-mien.vn:2083' ),
		'cp_user' => array( 'Tên đăng nhập cPanel', 'text', '' ),
		'cp_pass' => array( 'Mật khẩu cPanel', 'password', 'Chỉ gửi trong email, KHÔNG lưu trên web.' ),
		'ip'      => array( 'IP máy chủ', 'text', '' ),
		'h_ns'    => array( 'Nameserver của hosting', 'text', '' ),
		'exp_h'   => array( 'Ngày hết hạn hosting', 'text', 'dd/mm/yyyy' ),
		'note'    => array( 'Ghi chú thêm', 'textarea', '' ),
	);
}

function dgc_hd_read_post() {
	$f = array();
	foreach ( dgc_hd_fields() as $k => $d ) {
		$v = wp_unslash( $_POST[ 'hd_' . $k ] ?? '' );
		$f[ $k ] = 'textarea' === $d[1] ? sanitize_textarea_field( $v ) : ( 'cp_pass' === $k ? trim( (string) $v ) : sanitize_text_field( $v ) );
	}
	$f['email']  = sanitize_email( $f['email'] );
	$f['cp_url'] = esc_url_raw( $f['cp_url'] );
	return $f;
}

function dgc_hd_page() {
	if ( ! current_user_can( 'edit_posts' ) ) return;
	$msg = ''; $pre = array();
	if ( isset( $_POST['dgc_hd_n'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['dgc_hd_n'] ) ), 'dgc_hd' ) ) {
		$f = dgc_hd_read_post();
		if ( ! is_email( $f['email'] ) || ( ! $f['domain'] && ! $f['cp_url'] && ! $f['cp_user'] ) ) {
			$msg = '<div class="notice notice-error"><p>Cần email khách hợp lệ và ít nhất tên miền hoặc thông tin cPanel.</p></div>';
			$pre = $f; $pre['cp_pass'] = '';
		} else {
			list( $sub, $body ) = dgc_hd_build_mail( $f );
			$cc = isset( $_POST['hd_cc'] ) ? array( 'Bcc: ' . dgc( 'lead_email', get_option( 'admin_email' ) ) ) : array();
			$ok = wp_mail( $f['email'], $sub, $body, array_merge( array( 'Reply-To: DigicomVN <sales@digicomvn.com>' ), $cc ) );
			$log = (array) get_option( 'dgc_hd_log', array() );
			array_unshift( $log, array( 't' => current_time( 'mysql' ), 'u' => wp_get_current_user()->user_login, 'to' => $f['email'], 'd' => $f['domain'], 'h' => $f['plan'] ?: ( $f['cp_user'] ? 'hosting' : '' ), 'ok' => $ok ? 1 : 0 ) );
			update_option( 'dgc_hd_log', array_slice( $log, 0, 200 ), false );
			if ( $ok && $f['code'] && function_exists( 'dgc_tm_find_order' ) ) {
				$oid = dgc_tm_find_order( $f['code'] );
				if ( $oid ) {
					dgc_tm_log( $oid, 'Đã gửi email bàn giao tới ' . $f['email'] );
					if ( 'da_dk' !== get_post_meta( $oid, '_tm_status', true ) ) dgc_tm_set_status( $oid, 'da_dk', 'bàn giao bởi ' . wp_get_current_user()->user_login );
				}
			}
			$msg = $ok ? '<div class="notice notice-success"><p>Đã gửi email bàn giao tới ' . esc_html( $f['email'] ) . '.</p></div>' : '<div class="notice notice-error"><p>Gửi email lỗi. Kiểm tra cấu hình gửi mail của site.</p></div>';
		}
	} elseif ( ! empty( $_GET['don'] ) && function_exists( 'dgc_tm_find_order' ) ) {
		$oid = absint( $_GET['don'] );
		if ( $oid && 'dgc_don_tm' === get_post_type( $oid ) ) {
			$o = (array) get_post_meta( $oid, '_tm_owner', true );
			$l = (array) get_post_meta( $oid, '_tm_lines', true );
			$pre = array( 'email' => $o['email'] ?? '', 'name' => $o['name'] ?? '', 'code' => get_post_meta( $oid, '_tm_code', true ), 'domain' => implode( ', ', wp_list_pluck( $l, 'd' ) ) );
		}
	}
	echo '<div class="wrap"><h1>Bàn giao tên miền, hosting cho khách</h1>' . $msg;
	echo '<p style="max-width:760px">Điền thông tin quản trị rồi bấm Gửi: khách nhận 1 email có tên miền, ngày hết hạn, đường dẫn cPanel, tài khoản, hướng dẫn trỏ DNS và lưu ý bảo mật. Mật khẩu chỉ nằm trong email gửi đi, không lưu trên web. Quy trình đầy đủ: xem tài liệu "Quy trình bàn giao tên miền, hosting".</p>';
	echo '<form method="post"><table class="form-table" role="presentation"><tbody>';
	wp_nonce_field( 'dgc_hd', 'dgc_hd_n' );
	foreach ( dgc_hd_fields() as $k => $d ) {
		$v = $pre[ $k ] ?? '';
		echo '<tr><th scope="row"><label for="hd_' . esc_attr( $k ) . '">' . esc_html( $d[0] ) . '</label></th><td>';
		if ( 'textarea' === $d[1] ) echo '<textarea class="large-text" rows="3" id="hd_' . esc_attr( $k ) . '" name="hd_' . esc_attr( $k ) . '">' . esc_textarea( $v ) . '</textarea>';
		else echo '<input class="regular-text" type="' . esc_attr( $d[1] ) . '" id="hd_' . esc_attr( $k ) . '" name="hd_' . esc_attr( $k ) . '" value="' . esc_attr( $v ) . '" autocomplete="off">';
		if ( $d[2] ) echo '<p class="description">' . esc_html( $d[2] ) . '</p>';
		echo '</td></tr>';
	}
	echo '<tr><th scope="row">Bản sao</th><td><label><input type="checkbox" name="hd_cc" value="1"> Gửi bản sao ẩn (Bcc) về email nhận lead</label><p class="description">Bản sao có chứa mật khẩu, chỉ bật khi cần lưu đối chiếu.</p></td></tr>';
	echo '</tbody></table>';
	submit_button( 'Gửi email bàn giao' );
	echo '</form>';
	$log = (array) get_option( 'dgc_hd_log', array() );
	if ( $log ) {
		echo '<h2>Đã bàn giao gần đây</h2><table class="widefat striped" style="max-width:900px"><thead><tr><th>Thời gian</th><th>Người gửi</th><th>Khách</th><th>Tên miền</th><th>Hosting</th><th>Kết quả</th></tr></thead><tbody>';
		foreach ( array_slice( $log, 0, 30 ) as $r ) echo '<tr><td>' . esc_html( $r['t'] ) . '</td><td>' . esc_html( $r['u'] ) . '</td><td>' . esc_html( $r['to'] ) . '</td><td>' . esc_html( $r['d'] ) . '</td><td>' . esc_html( $r['h'] ) . '</td><td>' . ( $r['ok'] ? 'Đã gửi' : 'Lỗi' ) . '</td></tr>';
		echo '</tbody></table>';
	}
	echo '</div>';
}
