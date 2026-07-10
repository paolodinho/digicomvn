<?php
/**
 * Digicom Host - theme functions
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'DGC_VER', '0.7.3' );

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
} );

/* ---------------------------------------------------------------------------
 * Editable content (WP Admin -> menu "Digicom")
 * Tat ca lien he + gia sua duoc tu Admin, khong cham PHP.
 * ------------------------------------------------------------------------- */
require_once get_template_directory() . '/inc/options.php';
require_once get_template_directory() . '/inc/cpt-gia.php';

/**
 * Helper doc 1 option.
 */
function dgc( $key, $default = '' ) {
	$o = wp_parse_args( get_option( 'dgc_settings', array() ), dgc_defaults() );
	return isset( $o[ $key ] ) && $o[ $key ] !== '' ? $o[ $key ] : $default;
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

/** tel: link sach tu hotline */
function dgc_tel() {
	return preg_replace( '/[^0-9+]/', '', dgc( 'hotline', '0988769317' ) );
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
	);
	if ( empty( $paths[ $name ] ) ) return '';
	return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="' . esc_attr( $paths[ $name ] ) . '"/></svg>';
}

/** URL logo dang dung (site logo). Tra '' neu chua co -> dung wordmark chu. */
function dgc_logo_url() {
	$id = (int) ( get_theme_mod( 'custom_logo' ) ?: get_option( 'site_logo' ) );
	return $id ? (string) wp_get_attachment_image_url( $id, 'full' ) : '';
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
		'[Digicom] Yeu cau moi tu ' . $name,
		$body );

	wp_safe_redirect( add_query_arg( 'sent', $id ? 'ok' : 'err', remove_query_arg( 'sent', $ref ) . '#lien-he' ) );
	exit;
}
add_action( 'admin_post_dgc_lead', 'dgc_handle_lead' );
add_action( 'admin_post_nopriv_dgc_lead', 'dgc_handle_lead' );

/* Bo em dash o noi dung hien thi (rule global). */
function dgc_no_dash( $s ) {
	return is_string( $s ) ? str_replace(
		array( '—', '–', '&#8212;', '&#8211;', '&#x2014;', '&#x2013;', '&mdash;', '&ndash;' ), '-', $s
	) : $s;
}
foreach ( array( 'the_content', 'the_title', 'the_excerpt', 'single_post_title', 'widget_text', 'document_title' ) as $h ) {
	add_filter( $h, 'dgc_no_dash', 20 );
}
