<?php
/**
 * Dat mua ten mien + thanh toan QR tren trang (2026-10-29, Hieu chot).
 * Luong: khach tra ten mien (#tm-check) -> them vao gio (localStorage) -> trang /thanh-toan-ten-mien/
 * -> khai thong tin chu the -> tao don (CPT dgc_don_tm, private) -> hien VietQR co san so tien + ma don
 * -> SePay goi webhook /wp-json/dgc/v1/sepay khi tien vao -> don tu chuyen "Da thanh toan"
 * -> dgc_tm_register_order() dang ky qua API dai ly (khi bat) hoac bao Hieu dang ky tay.
 *
 * wp-config.php (KHONG commit):
 *   define('DGC_SEPAY_KEY','<API key dat o SePay > Webhook > Xac thuc API Key>');
 *   define('DGC_PA_REG_ON', true);   // chi bat khi da co tai lieu lenh dang ky + IP live duoc dai ly cho phep
 * Gia luon tinh lai o server tu option ten_mien_gia, khong tin so tien tu trinh duyet.
 * KHONG hien ten nha cung cap o bat ky dau (rule dich-vu.md).
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function dgc_tm_num( $v ) { return (int) preg_replace( '/\D/', '', (string) $v ); }

function dgc_tm_bank() {
	return array(
		'bank' => dgc( 'tm_bank_bin', 'MB' ),
		'name' => dgc( 'tm_bank_label', 'MB Bank (Ngân hàng TMCP Quân đội)' ),
		'acc'  => dgc( 'tm_bank_acc', '567898838' ),
		'own'  => dgc( 'tm_bank_owner', 'CONG TY TNHH DVTT DIGITO COMBAT' ),
	);
}

function dgc_tm_vat_pct() { return max( 0, (float) dgc( 'tm_vat', '0' ) ); }

function dgc_tm_status_labels() {
	return array(
		'cho_tt'     => 'Chờ thanh toán',
		'thieu_tien' => 'Chuyển thiếu tiền',
		'da_tt'      => 'Đã thanh toán, đang đăng ký',
		'da_dk'      => 'Đã đăng ký xong',
		'loi_dk'     => 'Đăng ký lỗi, chờ xử lý',
		'huy'        => 'Đã huỷ',
	);
}

add_action( 'init', function () {
	register_post_type( 'dgc_don_tm', array(
		'label'           => 'Đơn tên miền',
		'labels'          => array( 'name' => 'Đơn tên miền', 'singular_name' => 'Đơn tên miền', 'edit_item' => 'Chi tiết đơn tên miền' ),
		'public'          => false,
		'show_ui'         => true,
		'show_in_menu'    => true,
		'menu_icon'       => 'dashicons-cart',
		'menu_position'   => 26,
		'supports'        => array( 'title' ),
		'capability_type' => 'post',
		'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
		'map_meta_cap'    => true,
	) );
	if ( ! get_page_by_path( 'thanh-toan-ten-mien' ) ) {
		wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'Thanh toán tên miền', 'post_name' => 'thanh-toan-ten-mien', 'post_content' => '' ) );
	}
}, 30 );

add_action( 'wp_head', function () {
	if ( is_page( 'thanh-toan-ten-mien' ) ) echo '<meta name="robots" content="noindex,nofollow">' . "\n";
}, 1 );

function dgc_tm_checkout_url() { return home_url( '/thanh-toan-ten-mien/' ); }

/**
 * Tinh gia 1 ten mien theo so nam. Tra ve false neu duoi chua co trong bang gia.
 * Gia nam dau uu dai chi ap khi dang ky du so nam toi thieu (dgc_tm_min_years), thieu -> nam dau tinh gia goc.
 * $combo = gia nam dau rieng cho dong thuoc bo combo (0 = khong).
 */
function dgc_tm_quote( $domain, $years, $combo = 0 ) {
	$map = dgc_tm_price_map();
	$tld = '';
	foreach ( array_keys( $map ) as $t ) {
		if ( substr( $domain, -strlen( $t ) ) === $t && strlen( $t ) > strlen( $tld ) ) $tld = $t;
	}
	if ( ! $tld ) return false;
	$p     = $map[ $tld ];
	$first = dgc_tm_num( $p['gia'] ); $gia1 = $first;
	$renew = dgc_tm_num( $p['han'] ) ?: $first;
	$list  = max( $first, dgc_tm_num( $p['goc'] ) );
	if ( ! $first ) return false;
	$years = max( 1, min( 5, (int) $years ) );
	if ( $years < dgc_tm_min_years( $p ) ) $first = $list;
	if ( $combo ) $first = $combo;
	$gifts = dgc_tm_gifts_map()[ $tld ] ?? array();
	return array( 'd' => $domain, 'tld' => $tld, 'y' => $years, 'amount' => $first + ( $years - 1 ) * $renew, 'list' => ( $combo ? $gia1 : $list ) + ( $years - 1 ) * $renew, 'gifts' => $gifts, 'combo' => $combo ? 1 : 0 );
}

/** Gia nam dau moi dong combo: chi khi du ca bo cung ten trong gio. Tra ve domain => gia. */
function dgc_tm_combo_lines( $doms ) {
	$c = dgc_tm_combo(); $out = array();
	if ( ! $c ) return $out;
	$by = array();
	foreach ( $doms as $d ) foreach ( $c['tlds'] as $t ) if ( substr( $d, -strlen( $t ) ) === $t ) $by[ substr( $d, 0, -strlen( $t ) ) ][ $t ] = $d;
	$n = count( $c['tlds'] ); $each = (int) floor( $c['price'] / $n );
	foreach ( $by as $set ) {
		if ( count( $set ) < $n ) continue;
		$i = 0;
		foreach ( $c['tlds'] as $t ) { $out[ $set[ $t ] ] = ++$i === $n ? $c['price'] - $each * ( $n - 1 ) : $each; }
	}
	return $out;
}

function dgc_tm_clean_domain( $d ) {
	$d = strtolower( trim( (string) $d ) );
	$d = preg_replace( '#^https?://|^www\.|/.*$#', '', $d );
	return preg_match( '/^[a-z0-9\p{L}][a-z0-9\-\p{L}]{0,62}(\.[a-z0-9\-]+)+$/u', $d ) ? $d : '';
}

/** Tao don. AJAX dgc_tm_order. */
function dgc_tm_order_ajax() {
	// Khong bat buoc nonce (trang co the bi cache, lech phien dang nhap). Chong spam bang honeypot + 10 don/gio/IP.
	$ip = $_SERVER['REMOTE_ADDR'] ?? '';
	$k  = 'dgc_tmo_' . md5( $ip );
	if ( (int) get_transient( $k ) >= 10 ) wp_send_json( array( 'ok' => 0, 'msg' => 'Bạn đã tạo nhiều đơn, vui lòng thử lại sau hoặc gọi hotline.' ) );
	if ( ! empty( $_POST['website'] ) ) wp_send_json( array( 'ok' => 0, 'msg' => 'Không gửi được đơn.' ) );

	$items = json_decode( wp_unslash( $_POST['items'] ?? '[]' ), true );
	if ( ! is_array( $items ) || ! $items ) wp_send_json( array( 'ok' => 0, 'msg' => 'Giỏ hàng đang trống.' ) );
	$items = array_slice( $items, 0, 10 );

	$f = array();
	foreach ( array( 'type', 'name', 'idno', 'dob', 'rep', 'addr', 'city', 'phone', 'email', 'note' ) as $key ) {
		$f[ $key ] = sanitize_text_field( wp_unslash( $_POST[ $key ] ?? '' ) );
	}
	$f['type']  = 'org' === $f['type'] ? 'org' : 'person';
	$f['email'] = sanitize_email( $f['email'] );
	$need = array( 'name', 'idno', 'addr', 'city', 'phone', 'email' );
	if ( 'org' === $f['type'] ) $need[] = 'rep'; else $need[] = 'dob';
	foreach ( $need as $key ) {
		if ( '' === $f[ $key ] ) wp_send_json( array( 'ok' => 0, 'msg' => 'Vui lòng điền đủ thông tin chủ thể.' ) );
	}
	if ( ! is_email( $f['email'] ) ) wp_send_json( array( 'ok' => 0, 'msg' => 'Email chưa đúng định dạng.' ) );
	if ( ! preg_match( '/^(\+?84|0)\d{9,10}$/', preg_replace( '/[\s.\-]/', '', $f['phone'] ) ) ) wp_send_json( array( 'ok' => 0, 'msg' => 'Số điện thoại chưa đúng.' ) );
	if ( empty( $_POST['agree'] ) ) wp_send_json( array( 'ok' => 0, 'msg' => 'Vui lòng xác nhận thông tin chủ thể là chính xác.' ) );

	$lines = array(); $doms = array();
	$cdoms = array();
	foreach ( $items as $it ) { $d = dgc_tm_clean_domain( $it['d'] ?? '' ); if ( $d && ! empty( $it['c'] ) ) $cdoms[] = $d; }
	$combo = dgc_tm_combo_lines( $cdoms );
	foreach ( $items as $it ) {
		$d = dgc_tm_clean_domain( $it['d'] ?? '' );
		if ( ! $d || isset( $lines[ $d ] ) ) continue;
		$q = dgc_tm_quote( $d, $it['y'] ?? 1, $combo[ $d ] ?? 0 );
		if ( ! $q ) wp_send_json( array( 'ok' => 0, 'msg' => $d . ' chưa có giá đăng ký trực tuyến, vui lòng gửi yêu cầu tư vấn.' ) );
		$lines[ $d ] = $q; $doms[] = $d;
	}
	if ( ! $lines ) wp_send_json( array( 'ok' => 0, 'msg' => 'Giỏ hàng đang trống.' ) );
	/* Kiem tra lai con trong ngay luc tao don (khong dung ket qua cu trong trinh duyet). */
	foreach ( $doms as $d ) delete_transient( 'dgc_tm_' . md5( $d ) );
	$st  = dgc_tm_check_many( $doms );
	$bad = array_keys( array_filter( $st, function ( $s ) { return 'free' !== $s; } ) );
	if ( $bad ) wp_send_json( array( 'ok' => 0, 'bad' => $bad, 'msg' => 'Không xác nhận được tên miền còn trống: ' . implode( ', ', $bad ) . '. Hãy bỏ khỏi giỏ hoặc gửi yêu cầu để DigicomVN kiểm tra.' ) );

	$sub   = array_sum( wp_list_pluck( $lines, 'amount' ) );
	$vat   = (int) round( $sub * dgc_tm_vat_pct() / 100 );
	$total = $sub + $vat;
	do {
		$code = 'DGC' . substr( str_replace( array( '0', 'O', '1', 'I', 'L' ), '', strtoupper( wp_generate_password( 24, false ) ) ), 0, 6 );
	} while ( dgc_tm_find_order( $code ) );
	$id = wp_insert_post( array(
		'post_type'   => 'dgc_don_tm',
		'post_status' => 'private',
		'post_title'  => $code . ' - ' . implode( ', ', $doms ),
	) );
	if ( ! $id || is_wp_error( $id ) ) wp_send_json( array( 'ok' => 0, 'msg' => 'Chưa tạo được đơn, vui lòng thử lại.' ) );
	$token = wp_generate_password( 24, false );
	update_post_meta( $id, '_tm_code', $code );
	update_post_meta( $id, '_tm_token', $token );
	update_post_meta( $id, '_tm_lines', array_values( $lines ) );
	update_post_meta( $id, '_tm_owner', $f );
	update_post_meta( $id, '_tm_sub', $sub );
	update_post_meta( $id, '_tm_vat', $vat );
	update_post_meta( $id, '_tm_total', $total );
	update_post_meta( $id, '_tm_status', 'cho_tt' );
	update_post_meta( $id, '_tm_ip', $ip );
	set_transient( $k, (int) get_transient( $k ) + 1, HOUR_IN_SECONDS );
	dgc_tm_log( $id, 'Tạo đơn, tổng ' . dgc_vnd( $total ) );
	wp_send_json( array( 'ok' => 1, 'url' => add_query_arg( array( 'don' => $code, 'k' => $token ), dgc_tm_checkout_url() ) ) );
}
add_action( 'wp_ajax_dgc_tm_order', 'dgc_tm_order_ajax' );
add_action( 'wp_ajax_nopriv_dgc_tm_order', 'dgc_tm_order_ajax' );

function dgc_tm_find_order( $code ) {
	$q = get_posts( array( 'post_type' => 'dgc_don_tm', 'post_status' => 'any', 'numberposts' => 1, 'fields' => 'ids', 'meta_key' => '_tm_code', 'meta_value' => $code ) );
	return $q ? (int) $q[0] : 0;
}

/** Lay don tu ?don=&k= (khach chi xem duoc don cua minh nho token). */
function dgc_tm_order_from_request() {
	$code = strtoupper( sanitize_text_field( wp_unslash( $_REQUEST['don'] ?? '' ) ) );
	$tok  = sanitize_text_field( wp_unslash( $_REQUEST['k'] ?? '' ) );
	if ( ! $code || ! $tok ) return 0;
	$id = dgc_tm_find_order( $code );
	return ( $id && hash_equals( (string) get_post_meta( $id, '_tm_token', true ), $tok ) ) ? $id : 0;
}

function dgc_tm_status_ajax() {
	$id = dgc_tm_order_from_request();
	if ( ! $id ) wp_send_json( array( 's' => '' ) );
	$s = get_post_meta( $id, '_tm_status', true );
	wp_send_json( array( 's' => $s, 'label' => dgc_tm_status_labels()[ $s ] ?? '' ) );
}
add_action( 'wp_ajax_dgc_tm_status', 'dgc_tm_status_ajax' );
add_action( 'wp_ajax_nopriv_dgc_tm_status', 'dgc_tm_status_ajax' );

function dgc_tm_log( $id, $msg ) {
	$log   = (array) get_post_meta( $id, '_tm_log', true );
	$log[] = wp_date( 'd/m/Y H:i' ) . ' - ' . $msg;
	update_post_meta( $id, '_tm_log', array_filter( $log ) );
}

function dgc_tm_set_status( $id, $s, $msg = '' ) {
	update_post_meta( $id, '_tm_status', $s );
	dgc_tm_log( $id, ( dgc_tm_status_labels()[ $s ] ?? $s ) . ( $msg ? ': ' . $msg : '' ) );
}

/* ---------- Webhook SePay: POST /wp-json/dgc/v1/sepay, header "Authorization: Apikey <key>" ---------- */
add_action( 'rest_api_init', function () {
	register_rest_route( 'dgc/v1', '/sepay', array(
		'methods'             => 'POST',
		'callback'            => 'dgc_tm_sepay_webhook',
		'permission_callback' => '__return_true',
	) );
} );

function dgc_tm_sepay_webhook( WP_REST_Request $req ) {
	$ok  = new WP_REST_Response( array( 'success' => true ), 200 );
	$key = defined( 'DGC_SEPAY_KEY' ) ? (string) DGC_SEPAY_KEY : '';
	$hdr = (string) $req->get_header( 'authorization' );
	if ( '' === $key || ! hash_equals( 'apikey ' . strtolower( $key ), strtolower( trim( $hdr ) ) ) ) {
		return new WP_REST_Response( array( 'success' => false ), 401 );
	}
	$p = $req->get_json_params();
	if ( ! is_array( $p ) || 'in' !== ( $p['transferType'] ?? '' ) ) return $ok;
	/* SePay gui lai cung id khi thu lai -> bo qua giao dich da xu ly. */
	$tid  = sanitize_text_field( (string) ( $p['id'] ?? '' ) );
	$seen = (array) get_option( 'dgc_sepay_seen', array() );
	if ( $tid && in_array( $tid, $seen, true ) ) return $ok;
	if ( $tid ) { $seen[] = $tid; update_option( 'dgc_sepay_seen', array_slice( $seen, -500 ), false ); }

	$text = strtoupper( ( $p['code'] ?? '' ) . ' ' . ( $p['content'] ?? '' ) . ' ' . ( $p['description'] ?? '' ) );
	if ( ! preg_match( '/DGC[A-Z2-9]{6}/', $text, $m ) ) return $ok;
	$id = dgc_tm_find_order( $m[0] );
	if ( ! $id ) return $ok;
	$amount = (int) ( $p['transferAmount'] ?? 0 );
	$paid   = (int) get_post_meta( $id, '_tm_paid', true ) + $amount;
	update_post_meta( $id, '_tm_paid', $paid );
	add_post_meta( $id, '_tm_txn', array( 'id' => $tid, 'amount' => $amount, 'ref' => sanitize_text_field( (string) ( $p['referenceCode'] ?? '' ) ), 'time' => sanitize_text_field( (string) ( $p['transactionDate'] ?? '' ) ) ) );
	$status = get_post_meta( $id, '_tm_status', true );
	if ( ! in_array( $status, array( 'cho_tt', 'thieu_tien' ), true ) ) {
		dgc_tm_log( $id, 'Nhận thêm ' . dgc_vnd( $amount ) . ' sau khi đơn đã ở trạng thái ' . $status );
		dgc_tm_notify_admin( $id, 'Đơn ' . $m[0] . ' nhận thêm tiền, cần kiểm tra' );
		return $ok;
	}
	$total = (int) get_post_meta( $id, '_tm_total', true );
	if ( $paid < $total ) {
		dgc_tm_set_status( $id, 'thieu_tien', 'đã nhận ' . dgc_vnd( $paid ) . '/' . dgc_vnd( $total ) );
		dgc_tm_notify_admin( $id, 'Đơn ' . $m[0] . ' chuyển thiếu tiền' );
		return $ok;
	}
	dgc_tm_set_status( $id, 'da_tt', 'nhận ' . dgc_vnd( $paid ) . ', mã GD ' . ( $p['referenceCode'] ?? '' ) );
	/* Tra loi SePay ngay (gioi han 30 giay), dang ky chay nen. */
	wp_schedule_single_event( time() + 5, 'dgc_tm_register', array( $id ) );
	dgc_tm_mail_customer( $id, 'paid' );
	dgc_tm_notify_admin( $id, 'Đơn ' . $m[0] . ' đã thanh toán ' . dgc_vnd( $paid ) );
	return $ok;
}

/**
 * Dang ky ten mien sau khi da thanh toan.
 * Tu dong chi chay khi DGC_PA_REG_ON = true VA da khai bao ham dgc_tm_pa_register() (lenh dang ky
 * theo tai lieu API dai ly - chua co tai lieu nen chua viet). Con lai: bao Hieu dang ky tay,
 * dang ky xong bam "Da dang ky xong" trong WP Admin > Don ten mien de gui mail cho khach.
 */
add_action( 'dgc_tm_register', 'dgc_tm_register_order' );
function dgc_tm_register_order( $id ) {
	if ( 'da_tt' !== get_post_meta( $id, '_tm_status', true ) ) return;
	if ( ! ( defined( 'DGC_PA_REG_ON' ) && DGC_PA_REG_ON && function_exists( 'dgc_tm_pa_register' ) ) ) {
		dgc_tm_log( $id, 'Chờ đăng ký tay (chưa bật đăng ký tự động)' );
		return;
	}
	$owner = (array) get_post_meta( $id, '_tm_owner', true );
	$fail  = array();
	foreach ( (array) get_post_meta( $id, '_tm_lines', true ) as $l ) {
		$r = dgc_tm_pa_register( $l['d'], $l['y'], $owner );
		if ( true === $r ) dgc_tm_log( $id, 'Đăng ký xong ' . $l['d'] );
		else $fail[] = $l['d'] . ' (' . ( is_string( $r ) ? $r : 'lỗi' ) . ')';
	}
	if ( $fail ) {
		dgc_tm_set_status( $id, 'loi_dk', implode( '; ', $fail ) );
		dgc_tm_notify_admin( $id, 'Đơn ' . get_post_meta( $id, '_tm_code', true ) . ' đăng ký lỗi' );
		return;
	}
	dgc_tm_set_status( $id, 'da_dk' );
	dgc_tm_mail_customer( $id, 'done' );
}

function dgc_tm_order_summary( $id ) {
	$out = '';
	foreach ( (array) get_post_meta( $id, '_tm_lines', true ) as $l ) {
		$out .= '- ' . $l['d'] . ' (' . $l['y'] . ' năm): ' . dgc_vnd( $l['amount'] ) . "\n";
		if ( ! empty( $l['combo'] ) ) $out .= '  (giá combo năm đầu)' . "\n";
		foreach ( (array) ( $l['gifts'] ?? array() ) as $g ) $out .= '  + ' . $g . "\n";
	}
	$vat = (int) get_post_meta( $id, '_tm_vat', true );
	if ( $vat ) $out .= 'VAT: ' . dgc_vnd( $vat ) . "\n";
	return $out . 'Tổng thanh toán: ' . dgc_vnd( get_post_meta( $id, '_tm_total', true ) ) . "\n";
}

function dgc_tm_notify_admin( $id, $subject ) {
	$o   = (array) get_post_meta( $id, '_tm_owner', true );
	$typ = 'org' === ( $o['type'] ?? '' ) ? 'Tổ chức' : 'Cá nhân';
	$msg = dgc_tm_order_summary( $id ) . "\nTrạng thái: " . ( dgc_tm_status_labels()[ get_post_meta( $id, '_tm_status', true ) ] ?? '' )
		. "\nĐã nhận: " . dgc_vnd( (int) get_post_meta( $id, '_tm_paid', true ) )
		. "\n\nChủ thể ($typ): " . ( $o['name'] ?? '' ) . "\nCCCD/MST: " . ( $o['idno'] ?? '' )
		. ( 'org' === ( $o['type'] ?? '' ) ? "\nNgười đại diện: " . ( $o['rep'] ?? '' ) : "\nNgày sinh: " . ( $o['dob'] ?? '' ) )
		. "\nĐịa chỉ: " . ( $o['addr'] ?? '' ) . ', ' . ( $o['city'] ?? '' ) . "\nĐiện thoại: " . ( $o['phone'] ?? '' ) . "\nEmail: " . ( $o['email'] ?? '' )
		. ( ! empty( $o['note'] ) ? "\nGhi chú: " . $o['note'] : '' )
		. "\n\nXem đơn: " . admin_url( 'post.php?post=' . $id . '&action=edit' );
	wp_mail( dgc( 'lead_email', get_option( 'admin_email' ) ), '[Tên miền] ' . $subject, $msg );
}

function dgc_tm_mail_customer( $id, $kind ) {
	$o = (array) get_post_meta( $id, '_tm_owner', true );
	if ( empty( $o['email'] ) ) return;
	$code = get_post_meta( $id, '_tm_code', true );
	if ( 'paid' === $kind ) {
		$sub = 'DigicomVN đã nhận thanh toán đơn ' . $code;
		$msg = 'Chào ' . $o['name'] . ",\n\nDigicomVN đã nhận thanh toán cho đơn " . $code . ":\n" . dgc_tm_order_summary( $id )
			. "\nTên miền đang được đăng ký. DigicomVN sẽ gửi email xác nhận và thông tin quản trị khi hoàn tất, thường trong ngày làm việc.";
	} else {
		$sub = 'Tên miền đơn ' . $code . ' đã đăng ký xong';
		$msg = 'Chào ' . $o['name'] . ",\n\nTên miền trong đơn " . $code . " đã được đăng ký:\n" . dgc_tm_order_summary( $id )
			. "\nCần trỏ tên miền về hosting hoặc nhận thông tin quản trị, vui lòng trả lời email này hoặc gọi " . dgc( 'hotline', '0988 769 317' ) . '.';
	}
	wp_mail( $o['email'], $sub, $msg . "\n\nDigicomVN\nHotline: " . dgc( 'hotline', '0988 769 317' ) . "\nEmail: sales@digicomvn.com" );
}

/* ---------- WP Admin: cot danh sach + hop chi tiet + doi trang thai ---------- */
add_filter( 'manage_dgc_don_tm_posts_columns', function ( $c ) {
	return array( 'cb' => $c['cb'], 'title' => 'Đơn', 'tm_total' => 'Tổng', 'tm_status' => 'Trạng thái', 'date' => $c['date'] );
} );
add_action( 'manage_dgc_don_tm_posts_custom_column', function ( $col, $id ) {
	if ( 'tm_total' === $col ) echo esc_html( dgc_vnd( (int) get_post_meta( $id, '_tm_total', true ) ) );
	if ( 'tm_status' === $col ) echo esc_html( dgc_tm_status_labels()[ get_post_meta( $id, '_tm_status', true ) ] ?? '' );
}, 10, 2 );

add_action( 'add_meta_boxes_dgc_don_tm', function () {
	add_meta_box( 'dgc_tm_box', 'Chi tiết đơn', function ( $post ) {
		$id = $post->ID;
		$o  = (array) get_post_meta( $id, '_tm_owner', true );
		$s  = get_post_meta( $id, '_tm_status', true );
		echo '<pre style="white-space:pre-wrap;font-size:13px">' . esc_html( dgc_tm_order_summary( $id ) ) . '</pre>';
		echo '<p><b>Đã nhận:</b> ' . esc_html( dgc_vnd( (int) get_post_meta( $id, '_tm_paid', true ) ) ) . '</p>';
		echo '<table class="widefat striped" style="max-width:640px"><tbody>';
		$rows = array( 'Loại' => 'org' === ( $o['type'] ?? '' ) ? 'Tổ chức' : 'Cá nhân', 'Tên chủ thể' => $o['name'] ?? '', 'CCCD/MST' => $o['idno'] ?? '', 'Ngày sinh' => $o['dob'] ?? '', 'Người đại diện' => $o['rep'] ?? '', 'Địa chỉ' => trim( ( $o['addr'] ?? '' ) . ', ' . ( $o['city'] ?? '' ), ', ' ), 'Điện thoại' => $o['phone'] ?? '', 'Email' => $o['email'] ?? '', 'Ghi chú' => $o['note'] ?? '' );
		foreach ( $rows as $k => $v ) if ( '' !== $v ) echo '<tr><th style="width:150px">' . esc_html( $k ) . '</th><td>' . esc_html( $v ) . '</td></tr>';
		echo '</tbody></table>';
		wp_nonce_field( 'dgc_tm_admin', 'dgc_tm_admin_n' );
		echo '<p style="margin-top:16px"><label><b>Trạng thái:</b> <select name="dgc_tm_status">';
		foreach ( dgc_tm_status_labels() as $k => $v ) echo '<option value="' . esc_attr( $k ) . '"' . selected( $s, $k, false ) . '>' . esc_html( $v ) . '</option>';
		echo '</select></label> <span class="description">Chọn "Đã đăng ký xong" rồi bấm Cập nhật: hệ thống gửi email báo khách.</span></p>';
		$log = (array) get_post_meta( $id, '_tm_log', true );
		if ( $log ) echo '<p><b>Lịch sử</b></p><ul style="margin:0">' . implode( '', array_map( function ( $l ) { return '<li>' . esc_html( $l ) . '</li>'; }, $log ) ) . '</ul>';
	}, 'dgc_don_tm', 'normal', 'high' );
} );

add_action( 'save_post_dgc_don_tm', function ( $id ) {
	if ( ! isset( $_POST['dgc_tm_admin_n'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['dgc_tm_admin_n'] ) ), 'dgc_tm_admin' ) ) return;
	if ( ! current_user_can( 'edit_post', $id ) ) return;
	$new = sanitize_key( wp_unslash( $_POST['dgc_tm_status'] ?? '' ) );
	$old = get_post_meta( $id, '_tm_status', true );
	if ( ! isset( dgc_tm_status_labels()[ $new ] ) || $new === $old ) return;
	dgc_tm_set_status( $id, $new, 'đổi tay bởi ' . wp_get_current_user()->user_login );
	if ( 'da_dk' === $new ) dgc_tm_mail_customer( $id, 'done' );
	if ( 'da_tt' === $new && 'cho_tt' === $old ) dgc_tm_mail_customer( $id, 'paid' );
} );
