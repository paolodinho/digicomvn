<?php
/**
 * Custom Post Type "Case study" (dgc_case).
 * Archive: /case-study/  - Single: /case-study/<slug>/
 * Moi case study la 1 bai viet doc lap.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', function () {
	register_post_type( 'dgc_case', array(
		'labels' => array(
			'name'          => 'Case study',
			'singular_name' => 'Case study',
			'add_new_item'  => 'Them case study',
			'edit_item'     => 'Sua case study',
			'menu_name'     => 'Case study',
		),
		'public'       => true,
		'has_archive'  => 'case-study',
		'rewrite'      => array( 'slug' => 'case-study', 'with_front' => false ),
		'menu_icon'    => 'dashicons-awards',
		'menu_position'=> 26,
		'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		'show_in_rest' => true,
	) );

	register_post_meta( 'dgc_case', '_dgc_svc', array(
		'type' => 'string', 'single' => true, 'show_in_rest' => true,
		'sanitize_callback' => 'sanitize_text_field', 'auth_callback' => '__return_true',
	) );
	register_post_meta( 'dgc_case', '_dgc_client', array(
		'type' => 'string', 'single' => true, 'show_in_rest' => true,
		'sanitize_callback' => 'sanitize_text_field', 'auth_callback' => '__return_true',
	) );
	register_post_meta( 'dgc_case', '_dgc_sources', array(
		'type' => 'string', 'single' => true, 'show_in_rest' => true,
		'sanitize_callback' => 'sanitize_textarea_field', 'auth_callback' => '__return_true',
	) );
} );

/** Meta box don gian de nhap Dich vu / Khach hang / Nguon (link) tu WP Admin. */
add_action( 'add_meta_boxes', function () {
	add_meta_box( 'dgc_case_meta', 'Thong tin case study', function ( $post ) {
		wp_nonce_field( 'dgc_case_meta', 'dgc_case_nonce' );
		$svc     = get_post_meta( $post->ID, '_dgc_svc', true );
		$client  = get_post_meta( $post->ID, '_dgc_client', true );
		$sources = get_post_meta( $post->ID, '_dgc_sources', true );
		echo '<p><label><b>Dich vu</b> (vd: Booking bao & PR)</label><br><input type="text" name="dgc_svc" value="' . esc_attr( $svc ) . '" style="width:100%"></p>';
		echo '<p><label><b>Khach hang</b></label><br><input type="text" name="dgc_client" value="' . esc_attr( $client ) . '" style="width:100%"></p>';
		echo '<p><label><b>Nguon xuat hien</b> (moi dong 1 link, hoac cach nhau dau phay)</label><br><textarea name="dgc_sources" rows="4" style="width:100%">' . esc_textarea( $sources ) . '</textarea></p>';
	}, 'dgc_case', 'side' );
} );

add_action( 'save_post_dgc_case', function ( $post_id ) {
	if ( ! isset( $_POST['dgc_case_nonce'] ) || ! wp_verify_nonce( $_POST['dgc_case_nonce'], 'dgc_case_meta' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	foreach ( array( 'dgc_svc' => '_dgc_svc', 'dgc_client' => '_dgc_client', 'dgc_sources' => '_dgc_sources' ) as $f => $meta ) {
		if ( isset( $_POST[ $f ] ) ) {
			$val = $meta === '_dgc_sources' ? sanitize_textarea_field( wp_unslash( $_POST[ $f ] ) ) : sanitize_text_field( wp_unslash( $_POST[ $f ] ) );
			update_post_meta( $post_id, $meta, $val );
		}
	}
} );

/** Helper: doc danh sach link nguon cua 1 case (tach theo xuong dong hoac dau phay). */
function dgc_case_sources( $post_id = null ) {
	$raw = get_post_meta( $post_id ?: get_the_ID(), '_dgc_sources', true );
	$parts = preg_split( '/[\r\n,]+/', (string) $raw );
	return array_values( array_filter( array_map( 'trim', $parts ) ) );
}
