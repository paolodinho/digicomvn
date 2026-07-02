<?php
/**
 * Digicom Host - theme functions
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'DGC_VER', '0.1.0' );

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
	// Google Fonts: Be Vietnam Pro (display - geometric giong logo, ho tro day du tieng Viet)
	// + Inter (body). Poppins KHONG co subset vietnamese nen da bo.
	wp_enqueue_style(
		'dgc-fonts',
		'https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap',
		array(), null
	);
	wp_enqueue_style( 'dgc-main', get_template_directory_uri() . '/assets/css/main.css', array( 'dgc-fonts' ), DGC_VER );
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

	wp_mail( dgc( 'email', get_option( 'admin_email' ) ),
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
