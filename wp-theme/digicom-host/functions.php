<?php
/**
 * DigicomVN Host - theme functions
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'DGC_VER', '1.9.4' );

/* ---------------------------------------------------------------------------
 * Theme setup
 * ------------------------------------------------------------------------- */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array(
		'height'      => 48,
		'width'       => 180,
		'flex-width'  => true,
		'flex-height' => true,
	) );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	register_nav_menus( array(
		'primary' => 'Menu chinh (header)',
		'footer'  => 'Menu footer',
	) );
} );

/* ---------------------------------------------------------------------------
 * Assets
 * ------------------------------------------------------------------------- */
add_action( 'wp_enqueue_scripts', function () {
	// Redesign 2026-07-06 theo giao dien GrowMark: Roboto (display) + Montserrat (body),
	// ca hai deu co subset vietnamese.
	wp_enqueue_style(
		'dgc-fonts',
		'https://fonts.googleapis.com/css2?family=Roboto:wght@500;700&family=Montserrat:wght@400;500;600&family=Lora:wght@600;700&display=swap',
		array(), null
	);
	wp_enqueue_style( 'owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css', array(), '2.3.4' );
	wp_enqueue_style( 'owl-theme', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css', array( 'owl-carousel' ), '2.3.4' );
	wp_enqueue_style( 'dgc-main', get_template_directory_uri() . '/assets/css/main.css', array( 'dgc-fonts', 'owl-theme' ), DGC_VER );

	wp_enqueue_script( 'owl-carousel-js', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array( 'jquery' ), '2.3.4', true );
	wp_enqueue_script( 'dgc-main-js', get_template_directory_uri() . '/assets/js/main.js', array( 'jquery', 'owl-carousel-js' ), DGC_VER, true );

	// Chat AI (DeepSeek) - cung cap ajaxurl + nonce cho JS (key van o server, khong lo).
	if ( function_exists( 'dgc_ai_enabled' ) && dgc_ai_enabled() ) {
		wp_localize_script( 'dgc-main-js', 'DGC_AI', array(
			'url'   => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'dgc_ai' ),
		) );
	}
} );

/* ---------------------------------------------------------------------------
 * Editable content (WP Admin -> menu "DigicomVN")
 * Tat ca lien he + gia sua duoc tu Admin, khong cham PHP.
 * ------------------------------------------------------------------------- */
require_once get_template_directory() . '/inc/options.php';
require_once get_template_directory() . '/inc/cpt-gia.php';
require_once get_template_directory() . '/inc/vitri-images.php';
require_once get_template_directory() . '/inc/dr-chart.php';
require_once get_template_directory() . '/inc/widgets-blog.php';
require_once get_template_directory() . '/inc/case-study.php';
require_once get_template_directory() . '/inc/ai-chat.php';
require_once get_template_directory() . '/inc/glossary.php';
require_once get_template_directory() . '/inc/toc.php';

/**
 * Helper doc 1 option.
 */
function dgc( $key, $default = '' ) {
	$o = wp_parse_args( get_option( 'dgc_settings', array() ), dgc_defaults() );
	return isset( $o[ $key ] ) && $o[ $key ] !== '' ? $o[ $key ] : $default;
}

/**
 * Han chot dot uu dai (timestamp, gio VN). Doc option 'promo_deadline' (yyyy-mm-dd);
 * de TRONG -> tu lay 23:59 ngay cuoi thang hien tai, nen uu dai khong bao gio hien "da het han"
 * neu Hieu quen cap nhat. Han da qua -> tra ve 0 (an dong dem nguoc, khong hien so am).
 */
function dgc_promo_deadline_ts() {
	$raw = trim( (string) dgc( 'promo_deadline' ) );
	$now = current_time( 'timestamp' );
	if ( $raw === '' ) {
		return strtotime( wp_date( 'Y-m-t', $now ) . ' 23:59:59' );
	}
	$ts = strtotime( $raw . ' 23:59:59' );
	return ( $ts && $ts > $now ) ? $ts : 0;
}

/**
 * Parse textarea dang "a | b | c" moi dong thanh mang.
 */
function dgc_lines( $key ) {
	$raw = dgc( $key, '' );
	$out = array();
	foreach ( preg_split( '/\r\n|\r|\n/', (string) $raw ) as $line ) {
		$line = trim( $line );
		if ( $line === '' ) continue;
		$out[] = array_map( 'trim', explode( '|', $line ) );
	}
	return $out;
}

/**
 * Parse option 'services' thanh cac nhom.
 * Dong "# Ten nhom" mo nhom moi; dong khac "ten | mo ta" la dich vu.
 * Tra ve: array( array('title'=>..., 'items'=>array(array('name','desc'))) )
 */
function dgc_service_groups() {
	$raw    = dgc( 'services', '' );
	$groups = array();
	$cur    = null;
	foreach ( preg_split( '/\r\n|\r|\n/', (string) $raw ) as $line ) {
		$line = trim( $line );
		if ( $line === '' ) continue;
		if ( $line[0] === '#' ) {
			if ( $cur ) $groups[] = $cur;
			$cur = array( 'title' => trim( ltrim( $line, '#' ) ), 'items' => array() );
		} else {
			if ( ! $cur ) $cur = array( 'title' => '', 'items' => array() );
			$parts          = array_map( 'trim', explode( '|', $line ) );
			$cur['items'][] = array( 'name' => $parts[0] ?? '', 'desc' => $parts[1] ?? '' );
		}
	}
	if ( $cur ) $groups[] = $cur;
	return $groups;
}

/** Nhan dien ten bao/nguon tu URL (dung cho case study). */
function dgc_source_label( $url ) {
	$host = strtolower( wp_parse_url( $url, PHP_URL_HOST ) ?: '' );
	$host = preg_replace( '/^www\./', '', $host );
	$map  = array(
		'e.vnexpress.net'       => 'VnExpress (EN)',
		'vnexpress.net'         => 'VnExpress',
		'vietnamnet.vn'         => 'VietnamNet',
		'suckhoedoisong.vn'     => 'Sức khỏe & Đời sống',
		'hanoimoi.vn'           => 'Hànộimới',
		'diendandoanhnghiep.vn' => 'Diễn đàn Doanh nghiệp',
		'baophutho.vn'          => 'Báo Phú Thọ',
		'youtube.com'           => 'YouTube',
		'youtu.be'              => 'YouTube',
		'hfh.com.vn'            => 'BV Việt Pháp',
		'tuoitre.vn'            => 'Tuổi Trẻ',
		'vienktxh.hanoi.gov.vn' => 'Viện KTXH Hà Nội',
	);
	return $map[ $host ] ?? $host;
}

/** tel: link sach tu hotline */
function dgc_tel() {
	return preg_replace( '/[^0-9+]/', '', dgc( 'hotline', '0988769317' ) );
}

function dgc_tel2() {
	return preg_replace( '/[^0-9+]/', '', dgc( 'hotline2', '' ) );
}

/** 8 trang dich vu pillar (label | path o goc). Dung cho bottom-sheet "Dich vu" mobile.
 *  Slug co dinh theo sitemap (flatten 2026-07-16). */
function dgc_service_links() {
	return array(
		array( 'Mua Textlink',           '/mua-textlink/' ),
		array( 'Dịch vụ Backlink',       '/dich-vu-backlink/' ),
		array( 'Guest Post',             '/guest-post/' ),
		array( 'Booking báo & PR',       '/booking-bao-pr/' ),
		array( 'Dịch vụ Toplist',        '/dich-vu-toplist/' ),
		array( 'Backlink Social Entity', '/backlink-social-entity/' ),
		array( 'Backlink quốc tế',       '/backlink-quoc-te/' ),
		/* 4 nhom media tam an (Hieu 2026-07-16): booking-truyen-hinh, quang-cao-loa-phuong,
		   quang-cao-phat-thanh, quang-cao-man-led - du lieu gia da luu (draft), mo lai sau. */
	);
}

/** Category archive -> money page tuong ung (label | URL). Chi cum co dich vu moi tra ve. */
function dgc_cat_money_link( $cat ) {
	if ( ! $cat || empty( $cat->slug ) ) return null;
	$map = array(
		'booking-bao-pr'  => array( 'Xem dịch vụ Booking báo & PR và nhận báo giá', '/booking-bao-pr/' ),
		'backlink-offpage' => array( 'Xem dịch vụ Backlink & Off-page', '/dich-vu-backlink/' ),
	);
	if ( empty( $map[ $cat->slug ] ) ) return null;
	return array( $map[ $cat->slug ][0], home_url( $map[ $cat->slug ][1] ) );
}

/** Icon SVG thuan (thay emoji &#xxxx; - render khac nhau tuy OS, nhin re tien). */
function dgc_icon( $name ) {
	$paths = array(
		'phone' => 'M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z',
		'mail'  => 'M4 4h16v16H4zM4 4l8 8 8-8',
		'pin'   => 'M12 21s7-6.5 7-12a7 7 0 1 0-14 0c0 5.5 7 12 7 12z M12 11a2 2 0 1 0 0-4 2 2 0 0 0 0 4z',
		'clock' => 'M12 8v4l3 3M12 3a9 9 0 1 0 .01 0z',
		'home'  => 'M3 11l9-8 9 8M5 10v10h14V10',
		'layers' => 'M12 3l9 5-9 5-9-5 9-5zM3 13l9 5 9-5M3 8l9 5 9-5',
		'tag'   => 'M12 2H4v8l10 10 8-8L12 2zM7 7h.01',
		'edit'  => 'M12 20h9M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z',
		'share' => 'M18 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM6 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM18 22a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM8.6 13.5l6.8 4M15.4 6.5l-6.8 4',
		'star'  => 'M12 2l2.6 6.3 6.8.5-5.2 4.4 1.7 6.6L12 16.9 6.3 20.3l1.7-6.6-5.2-4.4 6.8-.5z',
		'globe' => 'M12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18zM3 12h18M12 3c2.5 2.5 3.8 5.6 3.8 9s-1.3 6.5-3.8 9c-2.5-2.5-3.8-5.6-3.8-9S9.5 5.5 12 3z',
		'tv'    => 'M3 7h18v12H3zM8 3l4 4 4-4',
		'facebook' => 'M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z',
		'linkedin' => 'M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6zM2 9h4v12H2zM4 6a2 2 0 1 1 0-4 2 2 0 0 1 0 4z',
	);
	if ( empty( $paths[ $name ] ) ) return '';
	return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="' . esc_attr( $paths[ $name ] ) . '"/></svg>';
}

/** URL logo dang dung (site logo). Tra '' neu chua co -> dung wordmark chu. */
function dgc_logo_url() {
	$id = (int) ( get_theme_mod( 'custom_logo' ) ?: get_option( 'site_logo' ) );
	return $id ? (string) wp_get_attachment_image_url( $id, 'full' ) : '';
}

/** URL logo ban trang/am ban - dung cho nen toi (footer...). Fallback ve logo mau neu chua co. */
function dgc_logo_url_light() {
	$id = (int) get_option( 'dgc_logo_light_id' );
	return $id ? (string) wp_get_attachment_image_url( $id, 'full' ) : dgc_logo_url();
}

/* ---------------------------------------------------------------------------
 * Form lien he / bao gia -> luu CPT "dgc_lead" + gui email (best effort)
 * ------------------------------------------------------------------------- */
add_action( 'init', function () {
	register_post_type( 'dgc_lead', array(
		'labels'   => array( 'name' => 'Yeu cau lien he', 'singular_name' => 'Yeu cau' ),
		'public'   => false,
		'show_ui'  => true,
		'menu_icon'=> 'dashicons-email-alt',
		'supports' => array( 'title' ),
	) );
} );

function dgc_handle_lead() {
	$nonce = isset( $_POST['dgc_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['dgc_nonce'] ) ) : '';
	$ref   = wp_get_referer() ?: home_url( '/' );
	if ( ! wp_verify_nonce( $nonce, 'dgc_lead' ) ) {
		wp_safe_redirect( add_query_arg( 'sent', 'err', $ref ) ); exit;
	}
	$name  = sanitize_text_field( wp_unslash( $_POST['dgc_name'] ?? '' ) );
	$phone = sanitize_text_field( wp_unslash( $_POST['dgc_phone'] ?? '' ) );
	$email = sanitize_email( wp_unslash( $_POST['dgc_email'] ?? '' ) );
	$svc   = sanitize_text_field( wp_unslash( $_POST['dgc_service'] ?? '' ) );
	$msg   = sanitize_textarea_field( wp_unslash( $_POST['dgc_message'] ?? '' ) );

	if ( $name === '' || ( $phone === '' && $email === '' ) ) {
		wp_safe_redirect( add_query_arg( 'sent', 'err', $ref ) ); exit;
	}

	$body = "Ho ten: $name\nDien thoai: $phone\nEmail: $email\nDich vu: $svc\nNoi dung:\n$msg";
	$id   = wp_insert_post( array(
		'post_type'   => 'dgc_lead',
		'post_status' => 'private',
		'post_title'  => $name . ' - ' . ( $svc ?: 'Lien he' ) . ' - ' . current_time( 'd/m/Y H:i' ),
		'post_content'=> $body,
	) );

	wp_mail( dgc( 'lead_email', get_option( 'admin_email' ) ),
		'[DigicomVN] Yeu cau moi tu ' . $name,
		$body );

	// Gui thanh cong -> trang cam on rieng (/cam-on/), khong quay lai form nua: khach biet chac
	// da gui xong, va do la moc de do chuyen doi (Analytics/Ads). Loi -> ve lai form nhu cu.
	if ( $id ) {
		$ty = dgc_thankyou_url();
		if ( $ty ) {
			wp_safe_redirect( $svc ? add_query_arg( 'dv', rawurlencode( $svc ), $ty ) : $ty );
			exit;
		}
	}
	wp_safe_redirect( add_query_arg( 'sent', $id ? 'ok' : 'err', remove_query_arg( 'sent', $ref ) . '#lien-he' ) );
	exit;
}

/* ---------------------------------------------------------------------------
 * Tim kiem: cuon vo han cho nhom "Bai viet" (Hieu 2026-07-15: 124 bai nhung chi hien 20).
 * Render 1 <li> dung CHUNG cho search.php + AJAX load them.
 * ------------------------------------------------------------------------- */
function dgc_search_post_li() {
	ob_start(); ?>
	<li>
		<a href="<?php the_permalink(); ?>">
			<h3><?php the_title(); ?></h3>
			<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 28 ) ); ?></p>
			<span class="srch-post-date"><?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?></span>
		</a>
	</li>
	<?php return ob_get_clean();
}

/* AJAX: tra ve trang tiep theo cua ket qua bai viet (append vao danh sach). */
function dgc_search_more() {
	$q     = isset( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : '';
	$paged = max( 2, (int) ( $_GET['paged'] ?? 2 ) );
	$query = new WP_Query( array(
		'post_type'      => array( 'post', 'page' ),
		's'              => $q,
		'posts_per_page' => 20,
		'paged'          => $paged,
		'post_status'    => 'publish',
	) );
	$html = '';
	while ( $query->have_posts() ) { $query->the_post(); $html .= dgc_search_post_li(); }
	wp_reset_postdata();
	wp_send_json_success( array( 'html' => $html, 'max' => (int) $query->max_num_pages ) );
}
add_action( 'wp_ajax_dgc_search_more', 'dgc_search_more' );
add_action( 'wp_ajax_nopriv_dgc_search_more', 'dgc_search_more' );

/** URL trang cam on - rong neu page chua ton tai (khi do form giu cach bao cu tai cho). */
function dgc_thankyou_url() {
	$p = get_page_by_path( 'cam-on' );
	return ( $p && 'publish' === $p->post_status ) ? get_permalink( $p ) : '';
}

/* Tao san trang "Cam on" (slug cam-on) neu chua co - template page-cam-on.php tu nhan theo slug. */
add_action( 'init', function () {
	if ( get_page_by_path( 'cam-on' ) ) return;
	wp_insert_post( array(
		'post_type'    => 'page',
		'post_status'  => 'publish',
		'post_title'   => 'Cảm ơn',
		'post_name'    => 'cam-on',
		'post_content' => '',
	) );
}, 30 );

/* Trang cam on la trang ket qua, khong co gia tri tim kiem -> noindex. */
add_action( 'wp_head', function () {
	if ( is_page( 'cam-on' ) ) echo '<meta name="robots" content="noindex,follow">' . "\n";
}, 1 );
add_action( 'admin_post_dgc_lead', 'dgc_handle_lead' );
add_action( 'admin_post_nopriv_dgc_lead', 'dgc_handle_lead' );

/* ---------------------------------------------------------------------------
 * Trang tac gia: them Facebook/LinkedIn vao ho so user (WP Admin > Ho so),
 * sua duoc khong can cham code (rule wordpress-non-code-editable).
 * ------------------------------------------------------------------------- */
add_action( 'show_user_profile', 'dgc_author_social_fields' );
add_action( 'edit_user_profile', 'dgc_author_social_fields' );
function dgc_author_social_fields( $user ) {
	wp_enqueue_media();
	$avatar_id  = (int) get_user_meta( $user->ID, 'dgc_avatar_id', true );
	$avatar_url = $avatar_id ? wp_get_attachment_image_url( $avatar_id, 'thumbnail' ) : '';
	?>
	<h2>Trang tác giả (hiển thị ở /author/...)</h2>
	<table class="form-table">
		<tr>
			<th><label for="dgc_avatar_id">Ảnh đại diện thật</label></th>
			<td>
				<img id="dgc-avatar-preview" src="<?php echo esc_url( $avatar_url ); ?>" style="max-width:96px;height:auto;border-radius:50%;display:<?php echo $avatar_url ? 'block' : 'none'; ?>;margin-bottom:8px" />
				<input type="hidden" name="dgc_avatar_id" id="dgc_avatar_id" value="<?php echo esc_attr( $avatar_id ); ?>" />
				<button type="button" class="button" id="dgc-avatar-pick">Chọn ảnh</button>
				<button type="button" class="button" id="dgc-avatar-clear" style="display:<?php echo $avatar_url ? 'inline-block' : 'none'; ?>">Bỏ ảnh</button>
				<p class="description">Dùng ảnh chân dung thật, không dùng ảnh mẫu/stock (rule chống AI-slop).</p>
			</td>
		</tr>
		<tr>
			<th><label for="dgc_facebook">Facebook</label></th>
			<td><input type="url" name="dgc_facebook" id="dgc_facebook" value="<?php echo esc_attr( get_user_meta( $user->ID, 'dgc_facebook', true ) ); ?>" class="regular-text" placeholder="https://web.facebook.com/..." /></td>
		</tr>
		<tr>
			<th><label for="dgc_linkedin">LinkedIn</label></th>
			<td><input type="url" name="dgc_linkedin" id="dgc_linkedin" value="<?php echo esc_attr( get_user_meta( $user->ID, 'dgc_linkedin', true ) ); ?>" class="regular-text" placeholder="https://www.linkedin.com/in/..." /></td>
		</tr>
	</table>
	<script>
	jQuery(function ($) {
		var frame;
		$('#dgc-avatar-pick').on('click', function (e) {
			e.preventDefault();
			if (frame) { frame.open(); return; }
			frame = wp.media({ title: 'Chọn ảnh đại diện', multiple: false, library: { type: 'image' } });
			frame.on('select', function () {
				var att = frame.state().get('selection').first().toJSON();
				$('#dgc_avatar_id').val(att.id);
				$('#dgc-avatar-preview').attr('src', att.sizes && att.sizes.thumbnail ? att.sizes.thumbnail.url : att.url).show();
				$('#dgc-avatar-clear').show();
			});
			frame.open();
		});
		$('#dgc-avatar-clear').on('click', function (e) {
			e.preventDefault();
			$('#dgc_avatar_id').val('');
			$('#dgc-avatar-preview').hide();
			$(this).hide();
		});
	});
	</script>
	<?php
}
add_action( 'personal_options_update', 'dgc_save_author_social_fields' );
add_action( 'edit_user_profile_update', 'dgc_save_author_social_fields' );
function dgc_save_author_social_fields( $user_id ) {
	if ( ! current_user_can( 'edit_user', $user_id ) ) return;
	if ( isset( $_POST['dgc_facebook'] ) ) update_user_meta( $user_id, 'dgc_facebook', esc_url_raw( wp_unslash( $_POST['dgc_facebook'] ) ) );
	if ( isset( $_POST['dgc_linkedin'] ) ) update_user_meta( $user_id, 'dgc_linkedin', esc_url_raw( wp_unslash( $_POST['dgc_linkedin'] ) ) );
	if ( isset( $_POST['dgc_avatar_id'] ) ) update_user_meta( $user_id, 'dgc_avatar_id', absint( $_POST['dgc_avatar_id'] ) );
}

/** Lay initial (chu cai dau) tu display_name de lam avatar mac dinh khi chua co anh that. */
function dgc_author_initials( $name ) {
	$parts = preg_split( '/\s+/', trim( (string) $name ) );
	$parts = array_filter( $parts );
	if ( ! $parts ) return '?';
	$first = mb_substr( reset( $parts ), 0, 1 );
	$last  = count( $parts ) > 1 ? mb_substr( end( $parts ), 0, 1 ) : '';
	return mb_strtoupper( $first . $last );
}

/* Bo em dash o noi dung hien thi (rule global). */
function dgc_no_dash( $s ) {
	return is_string( $s ) ? str_replace(
		array( '—', '–', '&#8212;', '&#8211;', '&#x2014;', '&#x2013;', '&mdash;', '&ndash;' ), '-', $s
	) : $s;
}
foreach ( array( 'the_content', 'the_title', 'the_excerpt', 'single_post_title', 'widget_text', 'document_title' ) as $h ) {
	add_filter( $h, 'dgc_no_dash', 20 );
}

/* ---------------------------------------------------------------------------
 * SEO title theo tung page/post (RankMath chua bat) - dat <title> khac label menu.
 * Map: post_id => tieu de <title> mong muon (khong doi post_title/label menu).
 * Vi du money page 475 giu label "Booking bao & PR" nhung <title> nham head-term
 * thuong mai "Agency Booking Bao Chi" (khop intent SERP thuong mai).
 * ------------------------------------------------------------------------- */
function dgc_seo_title_map() {
	return array(
		475 => 'Agency Booking Báo Chí Uy Tín - Bảng Giá 2026',
	);
}
add_filter( 'document_title_parts', function ( $parts ) {
	if ( is_singular() ) {
		$map = dgc_seo_title_map();
		$id  = get_queried_object_id();
		if ( ! empty( $map[ $id ] ) ) {
			$parts['title'] = $map[ $id ];
		}
	}
	return $parts;
}, 5 );

/* ---------------------------------------------------------------------------
 * So bai/trang cho category archive = 12 (chia het 3 cot desktop & 2 cot tablet)
 * -> luoi blog luon du hang, khong con hang cuoi le 1 the ("khuyet 2 the").
 * ------------------------------------------------------------------------- */
add_action( 'pre_get_posts', function ( $q ) {
	if ( ! is_admin() && $q->is_main_query() && $q->is_category() ) {
		$q->set( 'posts_per_page', 12 );
	}
} );

/* ---------------------------------------------------------------------------
 * 301 URL danh muc cu "/danh-muc/..." (category base tu theme/site cu, khong
 * con dung) sang cau truc hien tai "/category/...". Khong co redirect nay,
 * WP tu doan (redirect_guess_404_permalink) chuyen lung tung sang trang khong
 * lien quan (vd /danh-muc/blog/ -> trang "Blog" tinh) hoac 404 thang o trang 2+,
 * gay cam giac loi/gop noi dung nham.
 * ------------------------------------------------------------------------- */
add_action( 'template_redirect', function () {
	$uri  = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
	$path = parse_url( $uri, PHP_URL_PATH );
	if ( $path && strpos( $path, '/danh-muc/' ) === 0 ) {
		$target = home_url( '/category/' . substr( $path, strlen( '/danh-muc/' ) ) );
		wp_safe_redirect( $target, 301 );
		exit;
	}
}, 5 );

/* ---------------------------------------------------------------------------
 * 301 cau truc CU "/dich-vu/<pillar>/..." -> cau truc MOI o goc "/<pillar>/..."
 * (Hieu 2026-07-16: bo trang hub /dich-vu/, dua 8 pillar len goc).
 * CHI fire khi is_404() -> tu tuan tu: truoc khi doi post_parent (trang cu con song)
 * KHONG 404 nen KHONG redirect; sau khi doi parent, URL cu 404 -> redirect sang URL moi.
 * => Deploy code truoc hay sau buoc doi DB deu an toan, khong tao vong lap.
 * Mot handler generic phu het: 8 pillar + 15 trang con dau bao + bat-dong-san + hub.
 * ------------------------------------------------------------------------- */
add_action( 'template_redirect', function () {
	if ( ! is_404() ) return;
	$uri  = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
	$path = parse_url( $uri, PHP_URL_PATH );
	if ( ! $path ) return;

	/* Trang con dau bao cu /booking-bao-pr/<bao>/ -> bai blog "book-bao-<bao>" (chuyen doi
	   2026-07-16: bao gia booking le tung bao chuyen thanh bai blog + shortcode bang gia).
	   Chi fire khi trang cu da draft (404). Khong co bai -> ve pillar. */
	if ( preg_match( '#^/booking-bao-pr/([a-z0-9-]+)/?$#', $path, $m ) ) {
		$dgc_bb_post = get_page_by_path( 'book-bao-' . $m[1], OBJECT, 'post' );
		if ( $dgc_bb_post && 'publish' === $dgc_bb_post->post_status ) {
			wp_safe_redirect( get_permalink( $dgc_bb_post ), 301 );
		} else {
			wp_safe_redirect( home_url( '/booking-bao-pr/' ), 301 );
		}
		exit;
	}

	if ( strpos( $path, '/dich-vu/' ) !== 0 && $path !== '/dich-vu' ) return;

	$rest = trim( substr( $path, strlen( '/dich-vu' ) ), '/' ); // '' cho chinh /dich-vu/
	if ( $rest !== '' && get_page_by_path( $rest ) ) {
		wp_safe_redirect( home_url( '/' . $rest . '/' ), 301 ); // pillar/con da chuyen len goc
	} else {
		wp_safe_redirect( home_url( '/' ), 301 ); // hub cu -> trang chu (da liet ke dich vu)
	}
	exit;
}, 5 );

/**
 * Nut chuyen che do ban ngay / ban dem.
 * Mac dinh site la giao dien SANG (header.php). Khach bam nut moi doi sang toi, lua chon luu
 * trong localStorage cho lan sau.
 */
function dgc_theme_toggle() {
	?>
	<button class="theme-toggle" type="button" aria-label="Chuyển chế độ ban ngày / ban đêm" title="Chuyển chế độ sáng / tối" onclick="dgcToggleTheme(this)">
		<svg class="ico-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M2 12h2M20 12h2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M19.1 4.9l-1.4 1.4M6.3 17.7l-1.4 1.4"/></svg>
		<svg class="ico-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/></svg>
	</button>
	<?php
}

/** Script doi che do - in o footer, khong phu thuoc file js ngoai. */
function dgc_theme_toggle_script() {
	?>
	<script>
	function dgcToggleTheme(){
		var cur = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
		document.documentElement.setAttribute('data-theme', cur);
		try { localStorage.setItem('dgc-theme', cur); } catch (e) {}
	}
	</script>
	<?php
}
add_action( 'wp_footer', 'dgc_theme_toggle_script', 5 );
