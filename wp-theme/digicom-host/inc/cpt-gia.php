<?php
/**
 * CPT "dgc_gia" (Bang gia) - moi dong bao/site/goi la 1 post,
 * sua truc tiep trong WP Admin, khong cham code (rule wordpress-non-code-editable).
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/* ---------------------------------------------------------------------------
 * 1. Post type + taxonomy
 * ------------------------------------------------------------------------- */
add_action( 'init', function () {
	register_post_type( 'dgc_gia', array(
		'labels'        => array(
			'name'          => 'Bang gia',
			'singular_name' => 'Dong gia',
			'add_new_item'  => 'Them dong gia',
			'edit_item'     => 'Sua dong gia',
			'menu_name'     => 'Bang gia',
		),
		'public'        => false,
		'show_ui'       => true,
		'show_in_menu'  => 'dgc-settings',
		'supports'      => array( 'title' ),
		'menu_icon'     => 'dashicons-money-alt',
		'capability_type' => 'post',
		'map_meta_cap'  => true,
	) );

	register_taxonomy( 'dgc_nhom', 'dgc_gia', array(
		'labels'            => array(
			'name'          => 'Nhom dich vu',
			'singular_name' => 'Nhom',
		),
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'hierarchical'      => true,
		'show_in_menu'      => true,
	) );
} );

/* Tao san 4 term dung slug co dinh (idempotent). */
add_action( 'init', function () {
	if ( ! taxonomy_exists( 'dgc_nhom' ) ) return;
	$terms = array(
		'booking-bao-pr'   => 'Booking báo & PR',
		'guest-post'       => 'Guest Post',
		'mua-textlink'     => 'Mua Textlink',
		'dich-vu-backlink' => 'Dịch vụ Backlink',
	);
	foreach ( $terms as $slug => $name ) {
		if ( ! term_exists( $slug, 'dgc_nhom' ) ) {
			wp_insert_term( $name, 'dgc_nhom', array( 'slug' => $slug ) );
		}
	}
}, 20 );

/* ---------------------------------------------------------------------------
 * 2. Meta box "Chi tiet gia"
 * ------------------------------------------------------------------------- */
add_action( 'add_meta_boxes', function () {
	add_meta_box( 'dgc_gia_details', 'Chi tiet gia', 'dgc_gia_meta_box_html', 'dgc_gia', 'normal', 'high' );
} );

function dgc_gia_meta_fields() {
	return array(
		'vi_tri'  => array( 'label' => 'Vi tri dang / loai goi', 'type' => 'text' ),
		'gia_goc' => array( 'label' => 'Gia goc (de trong neu khong co)', 'type' => 'text' ),
		'gia_km'  => array( 'label' => 'Gia ban / khuyen mai (bat buoc, gia hien thi chinh)', 'type' => 'text' ),
		'so_link' => array( 'label' => 'So link / ghi chu ky thuat', 'type' => 'text' ),
		'yeu_cau' => array( 'label' => 'Yeu cau bai viet', 'type' => 'text' ),
		'url_bao' => array( 'label' => 'Link toi site/bao (khong bat buoc)', 'type' => 'url' ),
		'noi_bat' => array( 'label' => 'Danh dau "pho bien nhat"', 'type' => 'checkbox' ),
	);
}

function dgc_gia_meta_box_html( $post ) {
	wp_nonce_field( 'dgc_gia_save', 'dgc_gia_nonce' );
	echo '<table class="form-table">';
	foreach ( dgc_gia_meta_fields() as $key => $f ) {
		$val = get_post_meta( $post->ID, $key, true );
		echo '<tr><th style="width:260px"><label for="' . esc_attr( $key ) . '">' . esc_html( $f['label'] ) . '</label></th><td>';
		if ( $f['type'] === 'checkbox' ) {
			echo '<input type="checkbox" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="1" ' . checked( $val, '1', false ) . '>';
		} else {
			echo '<input type="' . esc_attr( $f['type'] ) . '" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" class="regular-text" style="width:480px">';
		}
		echo '</td></tr>';
	}
	echo '</table>';
}

add_action( 'save_post_dgc_gia', function ( $post_id ) {
	if ( ! isset( $_POST['dgc_gia_nonce'] ) || ! wp_verify_nonce( $_POST['dgc_gia_nonce'], 'dgc_gia_save' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	foreach ( dgc_gia_meta_fields() as $key => $f ) {
		if ( $f['type'] === 'checkbox' ) {
			update_post_meta( $post_id, $key, isset( $_POST[ $key ] ) ? '1' : '' );
		} elseif ( $f['type'] === 'url' ) {
			update_post_meta( $post_id, $key, isset( $_POST[ $key ] ) ? esc_url_raw( wp_unslash( $_POST[ $key ] ) ) : '' );
		} else {
			update_post_meta( $post_id, $key, isset( $_POST[ $key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) : '' );
		}
	}
} );

/* ---------------------------------------------------------------------------
 * 3. Helper de lay du lieu ra front-end
 * ------------------------------------------------------------------------- */
function dgc_get_gia( $nhom_slug ) {
	$posts = get_posts( array(
		'post_type'      => 'dgc_gia',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order title',
		'order'          => 'ASC',
		'tax_query'      => array(
			array(
				'taxonomy' => 'dgc_nhom',
				'field'    => 'slug',
				'terms'    => $nhom_slug,
			),
		),
	) );

	$items = array();
	foreach ( $posts as $p ) {
		$meta = array();
		foreach ( array_keys( dgc_gia_meta_fields() ) as $key ) {
			$meta[ $key ] = get_post_meta( $p->ID, $key, true );
		}
		$p->meta = $meta;
		$items[] = $p;
	}

	usort( $items, function ( $a, $b ) {
		if ( (int) $a->menu_order !== (int) $b->menu_order ) {
			return (int) $a->menu_order <=> (int) $b->menu_order;
		}
		$ga = (float) preg_replace( '/[^0-9.]/', '', str_replace( ',', '', $a->meta['gia_km'] ) );
		$gb = (float) preg_replace( '/[^0-9.]/', '', str_replace( ',', '', $b->meta['gia_km'] ) );
		return $ga <=> $gb;
	} );

	return $items;
}
