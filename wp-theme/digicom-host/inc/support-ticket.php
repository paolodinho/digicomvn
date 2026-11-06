<?php
/**
 * Phieu ho tro ky thuat ten mien / hosting / email (Hieu giao 05/11/2026).
 * Trang /ho-tro-ky-thuat/ (template page-ho-tro-ky-thuat.php). Khach dien -> email tu dong toi doi ky thuat dai ly
 * (option support_to, WP Admin > DigicomVN muc 11), CC lead_email; khach nhan email xac nhan tu DigicomVN.
 * Email gui dai ly: Reply-To sales@digicomvn.com (dai ly tra loi qua DigicomVN). Trang khong ghi ten nha cung cap.
 * Luu ban ghi vao dgc_lead (private) de tra cuu.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/** Doan huong dan bao su co gan vao moi email gui khach (Hieu 06/11/2026): moi su co gui qua trang /ho-tro-ky-thuat/. */
function dgc_support_line() {
	return "\n\nBÁO SỰ CỐ KỸ THUẬT\nKhi tên miền, hosting, email hoặc SSL gặp sự cố (web không truy cập được, không gửi nhận được email, lỗi SSL...), vui lòng gửi phiếu tại:\n" . home_url( '/ho-tro-ky-thuat/' ) . "\nGhi rõ tên miền, dịch vụ, mô tả lỗi và ảnh chụp màn hình nếu có. Phiếu được chuyển thẳng tới đội kỹ thuật, bạn nhận mã phiếu qua email để theo dõi. Sự cố gấp, gọi thêm hotline " . dgc( 'hotline', '0988 769 317' ) . '.';
}

/**
 * Danh muc dich vu + loai van de (Hieu 06/11/2026: phai du moi dich vu Digicom ban).
 * 'pa' => true: dich vu lay tu dai ly -> phieu chuyen support_to (ky thuat dai ly). Con lai: chi gui Hieu (Digicom tu xu ly).
 */
function dgc_sp_catalog() {
	$mail = array( 'Không gửi được email', 'Không nhận được email', 'Email vào thư rác (spam)', 'Cài đặt trên Outlook, điện thoại', 'Tạo, xoá hộp thư, đổi mật khẩu', 'Hộp thư đầy dung lượng', 'Gia hạn, nâng gói' );
	$web  = array( 'Website không truy cập được', 'Lỗi giao diện, chức năng', 'Sửa, cập nhật nội dung', 'Lỗi form liên hệ, đơn hàng', 'Website bị hack, nhiễm mã độc', 'Website chậm' );
	return array(
		'Tên miền, hosting, email, máy chủ' => array(
			'Tên miền'                => array( 'pa' => true, 'v' => array( 'Tên miền không truy cập được', 'Xác thực định danh chủ thể (eKYC)', 'Trỏ tên miền, sửa bản ghi DNS', 'Chuyển tên miền về hoặc đi', 'Đổi chủ thể, cập nhật hồ sơ tên miền', 'Gia hạn, tên miền hết hạn', 'Không đăng nhập được trang quản lý tên miền' ) ),
			'Hosting'                 => array( 'pa' => true, 'v' => array( 'Website không truy cập được (lỗi 500, 503...)', 'Website chậm', 'Không đăng nhập được cPanel', 'Hết dung lượng, tài nguyên', 'Lỗi upload, cơ sở dữ liệu', 'Sao lưu, khôi phục dữ liệu', 'Website nhiễm mã độc', 'Gia hạn, nâng gói' ) ),
			'Email doanh nghiệp'      => array( 'pa' => true, 'v' => $mail ),
			'Google Workspace'        => array( 'pa' => true, 'v' => $mail ),
			'Microsoft 365'           => array( 'pa' => true, 'v' => array_merge( $mail, array( 'Kích hoạt, đăng nhập Office' ) ) ),
			'Chứng chỉ SSL'           => array( 'pa' => true, 'v' => array( 'Cài đặt chứng chỉ', 'Trình duyệt báo "Không an toàn"', 'Chứng chỉ hết hạn, gia hạn' ) ),
			'Cloud server, VPS'       => array( 'pa' => true, 'v' => array( 'Không truy cập được máy chủ (SSH, Remote Desktop)', 'Máy chủ chậm, quá tải', 'Cài hệ điều hành, phần mềm', 'Nâng cấp cấu hình', 'Sao lưu, khôi phục', 'Gia hạn' ) ),
		),
		'Website' => array(
			'Thiết kế website'        => array( 'v' => $web ),
			'Chăm sóc website'        => array( 'v' => $web ),
			'Đăng ký website Bộ Công Thương' => array( 'v' => array( 'Tình trạng hồ sơ', 'Bổ sung, sửa hồ sơ', 'Gắn logo đã thông báo lên website' ) ),
		),
		'Báo chí, SEO, mạng xã hội' => array(
			'Booking báo, PR'         => array( 'v' => array( 'Bài chưa lên đúng lịch', 'Bài bị gỡ hoặc đổi đường dẫn', 'Sửa nội dung bài đã đăng', 'Link trong bài bị gỡ, đổi nofollow', 'Báo cáo, nghiệm thu' ) ),
			'Guest post, textlink, backlink' => array( 'v' => array( 'Link bị gỡ, mất', 'Link bị đổi sang nofollow', 'Bài chưa được Google index', 'Báo cáo danh sách link' ) ),
			'Booking fanpage, KOL/KOC' => array( 'v' => array( 'Bài chưa đăng đúng lịch', 'Sửa hoặc gỡ bài', 'Báo cáo kết quả' ) ),
			'SEO, phần mềm SEO'       => array( 'v' => array( 'Không đăng nhập được tài khoản phần mềm', 'Gia hạn tài khoản', 'Báo cáo SEO, thứ hạng' ) ),
		),
		'Khác' => array( 'Khác' => array( 'v' => array() ) ),
	);
}
function dgc_sp_flat() {
	$f = array();
	foreach ( dgc_sp_catalog() as $g ) foreach ( $g as $k => $c ) $f[ $k ] = $c;
	return $f;
}
function dgc_sp_services() { return array_keys( dgc_sp_flat() ); }

/* Trang ho tro chi gui cho khach qua link: khong index. */
add_filter( 'wp_robots', function ( $r ) {
	if ( is_page( 'ho-tro-ky-thuat' ) ) { $r['noindex'] = true; $r['follow'] = true; unset( $r['index'], $r['max-image-preview'] ); }
	return $r;
} );

/* Form co nonce: khong cache trang (nonce cu het han sau 24 gio). */
add_action( 'template_redirect', function () {
	if ( is_page( 'ho-tro-ky-thuat' ) ) { do_action( 'litespeed_control_set_nocache', 'dgc support form' ); nocache_headers(); }
} );

/**
 * Luu anh khach tai len (toi da 4 anh, moi anh <= 8MB, chi jpg/png/webp/gif/heic) vao uploads/dgc-support/<thang>/ ten ngau nhien,
 * tra ve danh sach duong dan de dinh kem email. Thu muc co index.html, khong liet ke.
 */
function dgc_sp_save_shots( $code ) {
	$out = array();
	if ( empty( $_FILES['sp_files']['name'] ) || ! is_array( $_FILES['sp_files']['name'] ) ) return $out;
	$ok  = array( 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'webp' => 'image/webp', 'gif' => 'image/gif', 'heic' => 'image/heic', 'heif' => 'image/heif' );
	$up  = wp_upload_dir();
	$dir = trailingslashit( $up['basedir'] ) . 'dgc-support/' . wp_date( 'Y-m' );
	if ( ! wp_mkdir_p( $dir ) ) return $out;
	if ( ! file_exists( $dir . '/index.html' ) ) @file_put_contents( $dir . '/index.html', '' );
	foreach ( $_FILES['sp_files']['name'] as $i => $n ) {
		if ( count( $out ) >= 4 ) break;
		$tmp = $_FILES['sp_files']['tmp_name'][ $i ] ?? '';
		if ( UPLOAD_ERR_OK !== (int) ( $_FILES['sp_files']['error'][ $i ] ?? 1 ) || ! is_uploaded_file( $tmp ) ) continue;
		if ( (int) $_FILES['sp_files']['size'][ $i ] > 8 * MB_IN_BYTES ) continue;
		$chk = wp_check_filetype_and_ext( $tmp, $n, $ok );
		$ext = $chk['ext'] ?: strtolower( pathinfo( $n, PATHINFO_EXTENSION ) );
		if ( ! isset( $ok[ $ext ] ) ) continue;
		if ( ! in_array( $ext, array( 'heic', 'heif' ), true ) && false === @getimagesize( $tmp ) ) continue;
		$dst = $dir . '/' . $code . '-' . ( $i + 1 ) . '-' . wp_generate_password( 6, false ) . '.' . $ext;
		if ( @move_uploaded_file( $tmp, $dst ) ) $out[] = $dst;
	}
	return $out;
}

add_action( 'admin_post_nopriv_dgc_support', 'dgc_sp_handle' );
add_action( 'admin_post_dgc_support', 'dgc_sp_handle' );
function dgc_sp_handle() {
	$back = home_url( '/ho-tro-ky-thuat/' );
	$go   = function ( $s, $code = '' ) use ( $back ) { wp_safe_redirect( add_query_arg( array_filter( array( 'sent' => $s, 'ma' => $code ) ), $back ) . '#ho-tro' ); exit; };
	$p    = function ( $k ) { return sanitize_text_field( wp_unslash( $_POST[ $k ] ?? '' ) ); };

	if ( ! wp_verify_nonce( $p( 'dgc_nonce' ), 'dgc_support' ) ) $go( 'err' );
	/* Chan rac: o bay, gui duoi 3 giay, qua 3 lan / 10 phut / IP -> bao thanh cong gia, khong gui gi. */
	$ip  = sanitize_text_field( $_SERVER['REMOTE_ADDR'] ?? '' );
	$rk  = 'dgc_sp_' . md5( $ip );
	$cnt = (int) get_transient( $rk );
	if ( '' !== $p( 'website' ) || ( time() - (int) $p( 'dgc_t' ) ) < 3 || $cnt >= 3 ) $go( 'ok' );

	$name   = $p( 'sp_name' );
	$phone  = preg_replace( '/[^\d+]/', '', $p( 'sp_phone' ) );
	$email  = sanitize_email( wp_unslash( $_POST['sp_email'] ?? '' ) );
	$domain = strtolower( preg_replace( '#^https?://|/.*$#i', '', $p( 'sp_domain' ) ) );
	$flat   = dgc_sp_flat();
	$svc    = isset( $flat[ $p( 'sp_service' ) ] ) ? $p( 'sp_service' ) : 'Khác';
	$kind   = in_array( $p( 'sp_kind' ), $flat[ $svc ]['v'], true ) ? $p( 'sp_kind' ) : 'Khác';
	$order  = $p( 'sp_order' );
	$is_pa  = ! empty( $flat[ $svc ]['pa'] );
	$issue  = sanitize_textarea_field( wp_unslash( $_POST['sp_issue'] ?? '' ) );
	$shot   = esc_url_raw( wp_unslash( $_POST['sp_shot'] ?? '' ) );
	$urg    = $p( 'sp_urgent' ) ? 'Gấp: website/email đang ngừng hoạt động' : 'Bình thường';
	if ( '' === $name || ! is_email( $email ) || strlen( $phone ) < 9 || '' === $domain || mb_strlen( $issue ) < 10 ) $go( 'err' );
	set_transient( $rk, $cnt + 1, 10 * MINUTE_IN_SECONDS );

	$code = 'HT' . wp_date( 'ymd' ) . strtoupper( wp_generate_password( 3, false ) );
	$att  = dgc_sp_save_shots( $code );
	$body = "Mã phiếu: $code\nTên miền / website: $domain\nDịch vụ: $svc\nLoại vấn đề: $kind\n" . ( $order ? "Mã đơn hàng: $order\n" : '' ) . "Mức độ: $urg\n\nMô tả lỗi:\n$issue\n"
		. ( $shot ? "\nLink ảnh/video lỗi: $shot\n" : '' )
		. ( $att ? "\nẢnh chụp lỗi: " . count( $att ) . " ảnh đính kèm email này.\n" : '' )
		. "\nNgười báo: $name\nĐiện thoại: $phone\nEmail: " . ( $email ?: '(không có)' )
		. "\nGửi lúc: " . wp_date( 'd/m/Y H:i' );

	wp_insert_post( array( 'post_type' => 'dgc_lead', 'post_status' => 'private', 'post_title' => "[Hỗ trợ] $code - $domain - $svc", 'post_content' => $body ) );

	$own = dgc( 'lead_email', get_option( 'admin_email' ) );
	$to  = array_filter( array_map( 'trim', preg_split( '/[\s,;]+/', (string) dgc( 'support_to', '' ) ) ), 'is_email' );
	$sub = ( 'Bình thường' === $urg ? '' : '[GẤP] ' ) . "[Hỗ trợ DigicomVN] $code - $domain - $svc";
	$hdr = array( 'Reply-To: DigicomVN <sales@digicomvn.com>' );
	if ( ! $is_pa ) {
		/* Dich vu Digicom tu lam (booking bao, SEO, website...): chi gui Hieu. */
		wp_mail( $own, $sub, "Phiếu hỗ trợ dịch vụ DigicomVN tự xử lý (không chuyển đại lý):\n\n" . $body, $email ? array( 'Reply-To: ' . $name . ' <' . $email . '>' ) : array(), $att );
	} elseif ( $to ) {
		wp_mail( array_values( $to ), $sub, "Đại lý DigicomVN (Digito Combat) nhờ đội kỹ thuật xử lý giúp phiếu sau:\n\n" . $body . "\n\nVui lòng trả lời email này (sales@digicomvn.com), giữ nguyên mã phiếu $code trong tiêu đề. Nội dung trả lời sẽ được chuyển nguyên văn cho người dùng cuối, nên xin viết hướng dẫn trực tiếp cho khách và không cần ký tên đơn vị.", array_merge( $hdr, array( 'Cc: ' . $own ) ), $att );
	} else {
		wp_mail( $own, '[CHƯA CÓ EMAIL ĐẠI LÝ] ' . $sub, "Chưa điền 'Email kỹ thuật đại lý' ở WP Admin > DigicomVN mục 11, phiếu chưa chuyển đi:\n\n" . $body, array(), $att );
	}
	if ( $email ) {
		wp_mail( $email, "DigicomVN đã nhận yêu cầu hỗ trợ $code", "Chào $name,\n\nDigicomVN đã nhận yêu cầu hỗ trợ cho $domain ($svc - $kind), mã phiếu $code. Đội phụ trách đang kiểm tra và sẽ phản hồi sớm nhất.\n\nNội dung bạn gửi:\n$issue\n\nDigicomVN\nHotline: " . dgc( 'hotline', '0988 769 317' ) . "\nEmail: sales@digicomvn.com", $hdr );
	}
	$go( 'ok', $code );
}

/**
 * Tra phieu cho may chuyen tiep tren VPS (P.A tra loi ve sales@ -> tu gui khach, an ten dai ly).
 * GET /wp-json/dgc/v1/ticket/HT261106ABC, header X-DGC-Key = hang DGC_TICKET_KEY trong wp-config (khong commit).
 */
add_action( 'rest_api_init', function () {
	register_rest_route( 'dgc/v1', '/ticket/(?P<code>HT\d{6}[A-Za-z0-9]{3})', array(
		'methods'             => 'GET',
		'permission_callback' => function ( $r ) {
			return defined( 'DGC_TICKET_KEY' ) && strlen( DGC_TICKET_KEY ) >= 24 && hash_equals( DGC_TICKET_KEY, (string) $r->get_header( 'x_dgc_key' ) );
		},
		'callback'            => function ( $r ) {
			do_action( 'litespeed_control_set_nocache', 'dgc ticket lookup' );
			nocache_headers();
			$code = strtoupper( $r['code'] );
			$q    = get_posts( array( 'post_type' => 'dgc_lead', 'post_status' => 'any', 's' => $code, 'numberposts' => 5 ) );
			foreach ( $q as $p ) {
				if ( 0 !== strpos( $p->post_title, "[Hỗ trợ] $code " ) ) continue;
				$f = array();
				foreach ( array( 'name' => 'Người báo', 'phone' => 'Điện thoại', 'email' => 'Email', 'domain' => 'Tên miền / website', 'service' => 'Dịch vụ' ) as $k => $lb ) {
					$f[ $k ] = preg_match( '/^' . preg_quote( $lb, '/' ) . ':\s*(.*)$/mu', $p->post_content, $m ) ? trim( $m[1] ) : '';
				}
				if ( ! is_email( $f['email'] ) ) $f['email'] = '';
				$f['code'] = $code;
				$res = new WP_REST_Response( $f );
				$res->header( 'Cache-Control', 'no-store, private' );
				return $res;
			}
			return new WP_Error( 'not_found', 'Khong co phieu', array( 'status' => 404 ) );
		},
	) );
} );
