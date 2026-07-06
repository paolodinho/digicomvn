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

/** Tach so tu chuoi gia (VD "Home: 1.200.000đ" -> 1200000) de sort/tinh trung binh. Dung chung cho page-bang-gia.php + tpl-service.php. */
function dgc_gia_to_number( $s ) {
	if ( $s === '' ) return 0;
	preg_match( '/[\d.,]+/', $s, $m );
	if ( empty( $m[0] ) ) return 0;
	$raw = str_replace( '.', '', $m[0] );
	$raw = str_replace( ',', '.', $raw );
	return (float) $raw;
}

/** Hien gia de doc: so thuan (VD "1700000") -> "1.700.000đ". Chuoi da co dinh dang san (VD "Tu 300.000đ/link", "Home: 1.500.000đ · CM:...") thi giu nguyen. */
function dgc_format_price( $s ) {
	$s = trim( (string) $s );
	if ( $s === '' ) return '';
	if ( preg_match( '/^[0-9]+$/', $s ) ) {
		return number_format( (float) $s, 0, ',', '.' ) . 'đ';
	}
	return $s;
}

/** Trung vi (median) - it bi lech boi gia tri qua cao/thap so voi trung binh cong, phu hop khi 1 nhom co ca goi re va goi cao cap. */
function dgc_median( $values ) {
	$values = array_values( array_filter( $values, fn( $v ) => $v > 0 ) );
	$n = count( $values );
	if ( ! $n ) return 0;
	sort( $values );
	$mid = intdiv( $n, 2 );
	return ( $n % 2 ) ? $values[ $mid ] : ( $values[ $mid - 1 ] + $values[ $mid ] ) / 2;
}

/**
 * Xac dinh nhom gia (dgc_nhom) tuong ung voi trang dich vu hien tai, di theo cay post_parent.
 * Neu la trang con truc tiep cua "booking-bao-pr" (tung dau bao), tra them tu khoa de loc rieng bao do.
 */
function dgc_current_nhom( $post_id = 0 ) {
	$post_id = $post_id ?: get_the_ID();
	if ( ! $post_id ) return null;

	$known = array(
		'mua-textlink'     => 'Mua Textlink',
		'dich-vu-backlink' => 'Dịch vụ Backlink',
		'guest-post'       => 'Guest Post',
		'booking-bao-pr'   => 'Booking báo & PR',
	);

	$slug = get_post_field( 'post_name', $post_id );
	if ( isset( $known[ $slug ] ) ) {
		return array( 'slug' => $slug, 'label' => $known[ $slug ], 'outlet_keyword' => '' );
	}

	$chain = array_merge( array( $post_id ), get_post_ancestors( $post_id ) );
	foreach ( $chain as $i => $id ) {
		$id_slug = get_post_field( 'post_name', $id );
		if ( isset( $known[ $id_slug ] ) ) {
			$direct_child = $chain[ max( 0, $i - 1 ) ];
			$is_direct_outlet_child = ( $id_slug === 'booking-bao-pr' && (int) get_post_field( 'post_parent', $direct_child ) === (int) $id );
			$keyword = $is_direct_outlet_child ? str_replace( '-', '', get_post_field( 'post_name', $direct_child ) ) : '';
			return array( 'slug' => $id_slug, 'label' => $known[ $id_slug ], 'outlet_keyword' => $keyword );
		}
	}
	return null;
}
