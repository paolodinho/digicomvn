<?php
/**
 * Chat AI tu van (DeepSeek) - widget web tren trang chu, dat ngay duoi ribbon (Hieu 2026-07-15).
 * DeepSeek tuong thich OpenAI API. Key giu PHIA SERVER (constant DGC_DEEPSEEK_KEY trong wp-config
 * hoac option ai_key), KHONG bao gio lo ra JS. Con AI hieu dich vu + bang gia Digicom, khong bia
 * gia/dau bao, chot gia day ve hotline/Zalo (bam rule content-professional + bang-gia-booking).
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/** Lay DeepSeek API key: uu tien constant trong wp-config, sau do option ai_key. */
function dgc_ai_key() {
	if ( defined( 'DGC_DEEPSEEK_KEY' ) && DGC_DEEPSEEK_KEY ) return DGC_DEEPSEEK_KEY;
	$k = trim( (string) dgc( 'ai_key' ) );
	return $k;
}

/** Bat chat AI khi: option ai_chat_on bat VA co key. */
function dgc_ai_enabled() {
	$on = trim( (string) dgc( 'ai_chat_on' ) );
	$on = ( $on !== '' && $on !== '0' && strtolower( $on ) !== 'off' );
	return $on && dgc_ai_key() !== '';
}

/** Model DeepSeek (mac dinh deepseek-chat = V3, re). Sua o option ai_model neu can. */
function dgc_ai_model() {
	$m = trim( (string) dgc( 'ai_model' ) );
	return $m !== '' ? $m : 'deepseek-chat';
}

/** Tom tat khoang gia theo nhom dich vu (cache 1h) - de bot noi khoang gia tham khao, khong bia. */
function dgc_ai_price_brief() {
	$cached = get_transient( 'dgc_ai_price_brief' );
	if ( is_string( $cached ) && $cached !== '' ) return $cached;

	$nhom = array(
		'mua-textlink'            => 'Mua Textlink',
		'dich-vu-backlink'        => 'Dich vu Backlink',
		'guest-post'              => 'Guest Post',
		'booking-bao-pr'          => 'Booking bao & PR',
		'backlink-social-entity'  => 'Backlink Social Entity',
		'backlink-quoc-te'        => 'Backlink quoc te',
		'booking-truyen-hinh'     => 'Booking truyen hinh',
		'dich-vu-toplist'         => 'Dich vu Toplist',
	);
	$lines = array();
	foreach ( $nhom as $slug => $label ) {
		$q = new WP_Query( array(
			'post_type'      => 'dgc_gia',
			'post_status'    => 'publish',
			'posts_per_page' => 300,
			'tax_query'      => array( array( 'taxonomy' => 'dgc_nhom', 'field' => 'slug', 'terms' => $slug ) ),
			'fields'         => 'ids',
			'no_found_rows'  => true,
		) );
		if ( ! $q->have_posts() ) continue;
		$prices = array();
		foreach ( $q->posts as $pid ) {
			$raw = (string) get_post_meta( $pid, 'gia_km', true );
			if ( preg_match( '/[\d.,]{4,}/', $raw, $mm ) ) {
				$n = (int) preg_replace( '/[^\d]/', '', $mm[0] );
				if ( $n >= 100000 ) $prices[] = $n;
			}
		}
		$cnt = count( $q->posts );
		if ( $prices ) {
			sort( $prices );
			$lo = $prices[0];
			$hi = $prices[ count( $prices ) - 1 ];
			$fmt = function ( $v ) { return number_format( $v / 1000000, $v % 1000000 ? 1 : 0, ',', '.' ) . ' trieu'; };
			$lines[] = '- ' . $label . ': ' . $cnt . ' lua chon, gia tham khao tu ' . $fmt( $lo ) . ' den ' . $fmt( $hi ) . ' (chua VAT).';
		} else {
			$lines[] = '- ' . $label . ': ' . $cnt . ' lua chon (gia theo bao gia).';
		}
	}
	$out = $lines ? implode( "\n", $lines ) : '';
	set_transient( 'dgc_ai_price_brief', $out, HOUR_IN_SECONDS );
	return $out;
}

/** System prompt: kien thuc Digicom + rang buoc khong bia. */
function dgc_ai_system_prompt() {
	$hotline = dgc( 'hotline' );
	$zalo    = dgc( 'zalo' );
	$email   = dgc( 'email' );
	$price   = dgc_ai_price_brief();
	$extra   = trim( (string) dgc( 'ai_kb' ) );

	$sp  = "Ban la tro ly tu van cua DigicomVN (digicomvn.com) - dich vu SEO off-page cho doanh nghiep va agency o Viet Nam. ";
	$sp .= "Tra loi bang tieng Viet, ngan gon, than thien, dung chuyen mon, KHONG loi noi thua.\n\n";
	$sp .= "DICH VU DIGICOMVN:\n";
	$sp .= "1. Mua Textlink (/mua-textlink/): chen link vao bai viet co san tren site chat luong, chon theo DR/traffic.\n";
	$sp .= "2. Dich vu Backlink (/dich-vu-backlink/): he thong backlink chat luong, da nguon, an toan; co ngach Bat dong san.\n";
	$sp .= "3. Guest Post (/guest-post/): viet bai + dang tren site dung chu de, link dofollow.\n";
	$sp .= "4. Booking bao & PR (/booking-bao-pr/): dat bai PR tren bao dien tu uy tin (VnExpress, Dan Tri, CafeF, Kenh14, 24h...).\n";
	$sp .= "5. Backlink Social Entity (/backlink-social-entity/): ho so social chuan NAP, noi dung doc ban, lam thu cong; ban theo goi.\n";
	$sp .= "6. Backlink quoc te (/backlink-quoc-te/): guest post/niche edit va PR bao quoc te theo tang DR/DA.\n";
	$sp .= "7. Booking truyen hinh (/booking-truyen-hinh/): TVC, phong su, talkshow tren VTV, HTV.\n\n";
	$sp .= "CACH TU VAN CHON DICH VU (goi y ngan theo nhu cau khach):\n";
	$sp .= "- Can tang uy tin/thuong hieu nhanh, PR: Booking bao & PR hoac Truyen hinh.\n";
	$sp .= "- Can keo tang thu hang tu khoa on dinh: Guest Post + Dich vu Backlink + Textlink.\n";
	$sp .= "- Can nen tang thuong hieu/entity cho GEO (AI Overview, ChatGPT): Backlink Social Entity.\n";
	$sp .= "- Thi truong nuoc ngoai: Backlink quoc te.\n\n";
	if ( $price ) {
		$sp .= "KHOANG GIA THAM KHAO (chua VAT, co the thay doi):\n" . $price . "\n\n";
	}
	$sp .= "QUY TAC BAT BUOC:\n";
	$sp .= "- KHONG bia ten dau bao da hop tac, case study, so lieu, cam ket thu hang cu the.\n";
	$sp .= "- Gia chi la THAM KHAO; khi khach hoi bao gia chinh xac cho don cu the -> huong dan xem trang Bang gia (/bang-gia/) va lien he de chot gia dung.\n";
	$sp .= "- Khuyen khich khach de lai nhu cau (dich vu quan tam, nganh, so luong) va lien he: hotline " . $hotline;
	if ( $zalo ) $sp .= " / Zalo " . $zalo;
	if ( $email ) $sp .= " / email " . $email;
	$sp .= ".\n";
	$sp .= "- Neu cau hoi ngoai pham vi dich vu Digicom -> tra loi lich su va keo ve dich vu phu hop hoac de nghi lien he.\n";
	if ( $extra !== '' ) {
		$sp .= "\nTHONG TIN BO SUNG (do quan tri vien cung cap):\n" . $extra . "\n";
	}
	return $sp;
}

/** Gioi han theo IP: chong spam dot credit. */
function dgc_ai_rate_ok() {
	$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? preg_replace( '/[^0-9a-f:.]/i', '', $_SERVER['REMOTE_ADDR'] ) : 'na';
	$key = 'dgc_ai_rl_' . md5( $ip );
	$n   = (int) get_transient( $key );
	if ( $n >= 30 ) return false; // toi da 30 luot / gio / IP
	set_transient( $key, $n + 1, HOUR_IN_SECONDS );
	return true;
}

/** AJAX handler: nhan lich su chat, goi DeepSeek, tra ve cau tra loi. */
function dgc_ai_chat_handler() {
	if ( ! dgc_ai_enabled() ) {
		wp_send_json_error( array( 'msg' => 'Chat AI dang tam nghi. Vui long lien he hotline.' ), 503 );
	}
	if ( ! check_ajax_referer( 'dgc_ai', 'nonce', false ) ) {
		wp_send_json_error( array( 'msg' => 'Phien khong hop le, tai lai trang giup toi.' ), 403 );
	}
	if ( ! dgc_ai_rate_ok() ) {
		wp_send_json_error( array( 'msg' => 'Ban da nhan qua nhieu. Vui long goi hotline ' . dgc( 'hotline' ) . ' de duoc ho tro nhanh.' ), 429 );
	}

	$raw   = isset( $_POST['messages'] ) ? wp_unslash( $_POST['messages'] ) : '';
	$hist  = json_decode( is_string( $raw ) ? $raw : '', true );
	if ( ! is_array( $hist ) ) $hist = array();

	// Lam sach + gioi han: chi role user/assistant, 12 luot gan nhat, moi tin <= 1500 ky tu.
	$msgs = array();
	foreach ( array_slice( $hist, -12 ) as $m ) {
		$role = ( isset( $m['role'] ) && $m['role'] === 'assistant' ) ? 'assistant' : 'user';
		$txt  = isset( $m['content'] ) ? trim( (string) $m['content'] ) : '';
		if ( $txt === '' ) continue;
		$txt  = mb_substr( wp_strip_all_tags( $txt ), 0, 1500 );
		$msgs[] = array( 'role' => $role, 'content' => $txt );
	}
	if ( ! $msgs ) {
		wp_send_json_error( array( 'msg' => 'Ban muon hoi gi ve dich vu cua DigicomVN?' ), 400 );
	}

	$payload = array(
		'model'       => dgc_ai_model(),
		'messages'    => array_merge(
			array( array( 'role' => 'system', 'content' => dgc_ai_system_prompt() ) ),
			$msgs
		),
		'temperature' => 0.4,
		'max_tokens'  => 700,
		'stream'      => false,
	);

	$resp = wp_remote_post( 'https://api.deepseek.com/chat/completions', array(
		'timeout' => 30,
		'headers' => array(
			'Content-Type'  => 'application/json',
			'Authorization' => 'Bearer ' . dgc_ai_key(),
		),
		'body'    => wp_json_encode( $payload ),
	) );

	if ( is_wp_error( $resp ) ) {
		wp_send_json_error( array( 'msg' => 'Ket noi tro ly gap su co. Vui long goi hotline ' . dgc( 'hotline' ) . '.' ), 502 );
	}
	$code = wp_remote_retrieve_response_code( $resp );
	$body = json_decode( wp_remote_retrieve_body( $resp ), true );
	if ( $code < 200 || $code >= 300 || empty( $body['choices'][0]['message']['content'] ) ) {
		wp_send_json_error( array( 'msg' => 'Tro ly dang ban. Vui long lien he hotline ' . dgc( 'hotline' ) . ' hoac Zalo.' ), 502 );
	}
	$reply = trim( (string) $body['choices'][0]['message']['content'] );
	wp_send_json_success( array( 'reply' => $reply ) );
}
add_action( 'wp_ajax_dgc_ai_chat', 'dgc_ai_chat_handler' );
add_action( 'wp_ajax_nopriv_dgc_ai_chat', 'dgc_ai_chat_handler' );

/** Render hop chat tren trang (goi trong front-page.php). */
function dgc_ai_chat_box() {
	if ( ! dgc_ai_enabled() ) return;
	$intro = trim( (string) dgc( 'ai_intro' ) );
	if ( $intro === '' ) $intro = 'Xin chao! Toi la tro ly cua DigicomVN. Ban dang can textlink, backlink, guest post hay booking bao PR? Mo ta nhu cau, toi goi y dich vu va gia tham khao phu hop.';
	$sugg = array_filter( array_map( 'trim', explode( '|', (string) dgc( 'ai_suggestions' ) ) ) );
	if ( ! $sugg ) $sugg = array( 'Nen chon dich vu nao de len top Google?', 'Booking bao PR gia bao nhieu?', 'Tu van backlink cho website ban le' );
	?>
	<section class="ai-chat-sec" id="ai-chat" aria-label="Tro ly AI tu van dich vu">
		<div class="wrap">
			<div class="ai-chat-box" data-ai-chat>
				<div class="ai-chat-head">
					<span class="ai-chat-avatar" aria-hidden="true">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="8" width="18" height="12" rx="3"/><path d="M12 8V4M8 2h8"/><circle cx="9" cy="14" r="1"/><circle cx="15" cy="14" r="1"/></svg>
					</span>
					<div>
						<strong class="ai-chat-title">Tro ly AI DigicomVN</strong>
						<span class="ai-chat-sub">Tu van dich vu &amp; gia tham khao trong vai giay</span>
					</div>
				</div>
				<div class="ai-chat-log" data-ai-log>
					<div class="ai-msg ai-bot"><?php echo esc_html( $intro ); ?></div>
				</div>
				<div class="ai-chat-sugg" data-ai-sugg>
					<?php foreach ( array_slice( $sugg, 0, 4 ) as $s ) : ?>
						<button type="button" class="ai-sugg-btn"><?php echo esc_html( $s ); ?></button>
					<?php endforeach; ?>
				</div>
				<form class="ai-chat-form" data-ai-form>
					<input type="text" class="ai-chat-input" data-ai-input maxlength="500" autocomplete="off"
						placeholder="Nhap cau hoi cua ban..." aria-label="Nhap cau hoi cho tro ly AI">
					<button type="submit" class="ai-chat-send btn btn-primary" aria-label="Gui">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2 11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
					</button>
				</form>
				<p class="ai-chat-note">Tro ly AI co the sai sot - vui long xac nhan lai voi nhan vien khi chot don.</p>
			</div>
		</div>
	</section>
	<?php
}
