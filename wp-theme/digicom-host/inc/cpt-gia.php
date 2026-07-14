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
		'backlink-social-entity' => 'Backlink Social Entity',
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

/* Nhom nganh de loc trong bang gia Booking bao & PR (co the dung chung cho nhom khac neu can). */
function dgc_nganh_options() {
	return array(
		''              => '(Chưa phân loại)',
		'bao-lon'       => 'Báo lớn (trung ương)',
		'bao-tinh'      => 'Báo tỉnh - địa phương',
		'truyen-hinh'   => 'Đài truyền hình - phát thanh',
		'kinh-te'       => 'Kinh tế - Tài chính',
		'bds-xd'        => 'Bất động sản - Xây dựng',
		'y-te'          => 'Y tế - Sức khoẻ',
		'giai-tri'      => 'Giải trí - Đời sống',
		'cong-nghe-oto' => 'Công nghệ - Ô tô',
		'an-ninh-pl'    => 'An ninh - Pháp luật',
		'giao-duc'      => 'Giáo dục',
		'the-thao'      => 'Thể thao',
	);
}

/** Tach chuoi nganh luu dang "bao-lon,kinh-te" thanh mang slug (tuong thich nguoc voi du lieu cu chi co 1 gia tri, khong dau phay). */
function dgc_gia_nganh_tags( $meta_nganh ) {
	return array_values( array_filter( array_map( 'trim', explode( ',', (string) $meta_nganh ) ), fn( $v ) => $v !== '' ) );
}

function dgc_gia_meta_fields() {
	return array(
		'vi_tri'  => array( 'label' => 'Vi tri dang / loai goi', 'type' => 'text' ),
		'gia_goc' => array( 'label' => 'Gia goc (de trong neu khong co)', 'type' => 'text' ),
		'gia_km'  => array( 'label' => 'Gia ban / khuyen mai (bat buoc, gia hien thi chinh)', 'type' => 'text' ),
		'so_link' => array( 'label' => 'So link / ghi chu ky thuat', 'type' => 'text' ),
		'yeu_cau' => array( 'label' => 'Yeu cau bai viet', 'type' => 'text' ),
		'url_bao' => array( 'label' => 'Link toi site/bao (khong bat buoc)', 'type' => 'url' ),
		'noi_bat' => array( 'label' => 'Danh dau "pho bien nhat"', 'type' => 'checkbox' ),
		'nganh'   => array( 'label' => 'Nhom nganh (de loc trong bang gia) - tich nhieu neu bao dang duoc nhieu nganh', 'type' => 'checkbox_group', 'options' => dgc_nganh_options() ),
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
		} elseif ( $f['type'] === 'checkbox_group' ) {
			$selected = array_filter( array_map( 'trim', explode( ',', (string) $val ) ) );
			foreach ( $f['options'] as $ov => $ol ) {
				if ( $ov === '' ) continue; // "(Chua phan loai)" - khong tich gi la ngam dinh nhom nay
				echo '<label style="display:inline-block;margin:0 16px 6px 0"><input type="checkbox" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $ov ) . '" ' . checked( in_array( $ov, $selected, true ), true, false ) . '> ' . esc_html( $ol ) . '</label>';
			}
			echo '<p class="description">Tich nhieu nganh neu bao dang duoc da linh vuc (vd bao lon nhu VnExpress) - se hien o moi bo loc da tich.</p>';
		} elseif ( $f['type'] === 'select' ) {
			echo '<select id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '">';
			foreach ( $f['options'] as $ov => $ol ) {
				echo '<option value="' . esc_attr( $ov ) . '" ' . selected( $val, $ov, false ) . '>' . esc_html( $ol ) . '</option>';
			}
			echo '</select>';
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
		} elseif ( $f['type'] === 'checkbox_group' ) {
			$vals = isset( $_POST[ $key ] ) && is_array( $_POST[ $key ] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST[ $key ] ) ) : array();
			update_post_meta( $post_id, $key, implode( ',', $vals ) );
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
	// Chuoi ghep nhieu muc gia (VD "Home: 700000-900000-1100000đ · CM: ...") - chen dau
	// phan cach hang nghin vao TUNG cum so >= 4 chu so, giu nguyen nhan/dau cach/don vi khac.
	return preg_replace_callback( '/\d{4,}/', function ( $m ) {
		return number_format( (float) $m[0], 0, ',', '.' );
	}, $s );
}

/**
 * HTML logo nho cho 1 dong bao/site trong bang gia - dung favicon that cua chinh site do
 * (qua Google s2 favicon service) de bang nhin sinh dong nhu "di cho chon bao" thay vi
 * bang chu nham chan. Uu tien domain tu url_bao; da so ten bao (post_title) trong CPT
 * chinh la domain (vd "Angiangtv.vn") nen dung luon lam fallback truoc khi phai ve avatar
 * chu cai (chi khi ten khong giong domain, vd "VnExpress - Trang chu").
 */
function dgc_row_logo_html( $url_bao, $post_title ) {
	$domain = '';
	if ( $url_bao ) {
		$host = wp_parse_url( $url_bao, PHP_URL_HOST );
		if ( $host ) $domain = preg_replace( '/^www\./', '', $host );
	}
	if ( ! $domain && preg_match( '/^[a-z0-9-]+(\.[a-z0-9-]+)+$/i', trim( $post_title ) ) ) {
		$domain = trim( $post_title );
	}
	if ( $domain ) {
		$src = 'https://www.google.com/s2/favicons?domain=' . rawurlencode( $domain ) . '&sz=64';
		return '<img class="row-logo" src="' . esc_url( $src ) . '" alt="" loading="lazy" width="28" height="28">';
	}
	$hue    = crc32( $post_title ) % 360;
	$letter = mb_strtoupper( mb_substr( trim( $post_title ), 0, 1 ) );
	return '<span class="row-logo row-logo-fallback" style="background:hsl(' . (int) $hue . ',55%,88%);color:hsl(' . (int) $hue . ',45%,32%)">' . esc_html( $letter ) . '</span>';
}

/**
 * % chiet khau hien thi cho bang gia hap dan hon (theo yeu cau Hieu 2026-07-08) -
 * KHONG phai gia goc/khuyen mai that, chi dung khi dong gia CHUA co gia_goc rieng.
 * On dinh theo post_id (khong doi moi lan tai trang de tranh lo lieu), da dang 8-30%.
 */
function dgc_fake_discount_percent( $post_id ) {
	$h = crc32( 'dgcdisc-' . (int) $post_id );
	return 8 + ( $h % 23 ); // 8..30
}

/** Gia "goc" suy nguoc tu gia hien thi + %, lam tron len boi 10.000 cho tu nhien. */
function dgc_fake_original_price( $price_num, $pct ) {
	if ( $price_num <= 0 ) return 0;
	$old = $price_num / ( 1 - $pct / 100 );
	return (int) ( ceil( $old / 10000 ) * 10000 );
}

/**
 * Bac chiet khau combo (tick cang nhieu bao cang giam) - sua o WP Admin, muc "Bang gia".
 * Moi dong option `combo_discount`: <so muc toi thieu>|<% giam>. Tra ve mang [min, pct] sap xep tang dan.
 */
function dgc_combo_tiers() {
	$raw   = (string) dgc( 'combo_discount' );
	$tiers = array();
	foreach ( preg_split( '/\r\n|\r|\n/', $raw ) as $line ) {
		$parts = array_map( 'trim', explode( '|', $line ) );
		if ( count( $parts ) < 2 ) continue;
		$min = (int) $parts[0];
		$pct = (float) str_replace( ',', '.', rtrim( $parts[1], '% ' ) );
		if ( $min >= 2 && $pct > 0 ) $tiers[] = array( 'min' => $min, 'pct' => $pct );
	}
	usort( $tiers, fn( $a, $b ) => $a['min'] <=> $b['min'] );
	return $tiers;
}

/** Cau mo ta bac chiet khau cho khach doc (VD "2 báo giảm 3% - 4 báo giảm 5%..."). */
function dgc_combo_tiers_text() {
	$parts = array();
	foreach ( dgc_combo_tiers() as $t ) {
		$parts[] = 'từ ' . $t['min'] . ' mục giảm ' . rtrim( rtrim( number_format( $t['pct'], 1, ',', '' ), '0' ), ',' ) . '%';
	}
	return $parts ? implode( ' - ', $parts ) : '';
}

/**
 * Tach "quy cach dang" cua 1 dong gia thanh cac the chip ngan (so tu, so anh, so link...)
 * de cot Quy cach doc duoc ngay thay vi 1 chuoi dai. Chi tach o " - " (khong tach dau phay,
 * vi dau phay thuong nam trong 1 y: "duoi 1000 tu, duoi 3 anh").
 */
function dgc_gia_specs( $meta ) {
	$out = array();
	foreach ( array( $meta['so_link'] ?? '', $meta['yeu_cau'] ?? '' ) as $src ) {
		foreach ( preg_split( '/\s+-\s+|\s*;\s*/u', (string) $src ) as $chunk ) {
			$chunk = trim( $chunk, " \t\n\r\0\x0B-" );
			if ( $chunk !== '' ) $out[] = $chunk;
		}
	}
	return $out;
}

/**
 * HTML 1 dong bang gia - dung CHUNG cho trang /bang-gia/ va bang gia trong tung trang dich vu,
 * de 2 noi luon giong nhau (cot: Bao/site | Quy cach dang | Gia | Dat ngay).
 * $args: nhom_slug, ctx (nhan hien trong danh sach da chon), col_name, col_pos.
 */
function dgc_gia_row_html( $it, $args ) {
	$m         = $it->meta;
	$slug      = $args['nhom_slug'];
	$gia_km    = $m['gia_km'];
	$gia_goc   = $m['gia_goc'];
	$price_num = dgc_gia_to_number( $gia_km );
	$hot       = ( '1' === $m['noi_bat'] );
	$row_link  = $m['url_bao'] ? $m['url_bao'] : '';
	$specs     = dgc_gia_specs( $m );
	$vi_tri    = trim( (string) $m['vi_tri'] );
	$show_pos  = ( 'mua-textlink' !== $slug && $vi_tri !== '' );

	$has_real_old = ( $gia_goc && $gia_goc !== $gia_km );
	$show_fake    = ! $has_real_old && preg_match( '/^[0-9]+$/', trim( $gia_km ) );
	$fake_pct     = $show_fake ? dgc_fake_discount_percent( $it->ID ) : 0;
	$fake_old     = $show_fake ? dgc_fake_original_price( $price_num, $fake_pct ) : 0;

	$cb_id = 'pick-' . (int) $it->ID;

	ob_start(); ?>
	<tr class="<?php echo $hot ? 'hot' : ''; ?>" data-price="<?php echo esc_attr( $price_num ); ?>" data-name="<?php echo esc_attr( mb_strtolower( $it->post_title ) ); ?>" data-nganh="<?php echo esc_attr( implode( ' ', dgc_gia_nganh_tags( $m['nganh'] ?? '' ) ) ); ?>">
		<td data-label="<?php echo esc_attr( $args['col_name'] ); ?>" class="cell-site">
			<label class="row-check-wrap">
				<input type="checkbox" id="<?php echo esc_attr( $cb_id ); ?>" class="row-check" data-label="<?php echo esc_attr( $it->post_title . ' (' . $args['ctx'] . ')' ); ?>">
				<?php echo dgc_row_logo_html( $row_link, $it->post_title ); ?>
				<span>
					<span class="row-name"><?php echo esc_html( $it->post_title ); ?></span>
					<?php if ( $hot ) : ?><span class="badge-hot">Phổ biến</span><?php endif; ?>
					<?php if ( $row_link ) : ?><a class="row-link" href="<?php echo esc_url( $row_link ); ?>" target="_blank" rel="noopener nofollow">Xem site</a><?php endif; ?>
				</span>
			</label>
		</td>
		<td data-label="Quy cách đăng" class="cell-spec">
			<?php if ( $show_pos ) : ?><span class="spec-chip spec-chip-pos"><?php echo esc_html( $vi_tri ); ?></span><?php endif; ?>
			<?php foreach ( $specs as $sp ) : ?><span class="spec-chip"><?php echo esc_html( $sp ); ?></span><?php endforeach; ?>
			<?php if ( ! $show_pos && ! $specs ) : ?><span class="spec-empty">Liên hệ để nhận quy cách chi tiết</span><?php endif; ?>
		</td>
		<td data-label="Giá" class="cell-price">
			<?php if ( $show_fake || $has_real_old ) : ?>
				<span class="price-old-line">
					<span class="price-old"><?php echo esc_html( $show_fake ? number_format( $fake_old, 0, ',', '.' ) . 'đ' : dgc_format_price( $gia_goc ) ); ?></span>
					<?php if ( $show_fake ) : ?><span class="price-discount-badge">-<?php echo (int) $fake_pct; ?>%</span><?php endif; ?>
				</span>
			<?php endif; ?>
			<span class="price-now"><?php echo esc_html( dgc_format_price( $gia_km ) ); ?></span>
		</td>
		<td data-label="" class="cell-action">
			<a class="btn btn-navy btn-sm order-now" href="<?php echo esc_url( home_url( '/dat-bai/' ) ); ?>">Đặt ngay</a>
			<?php /* Mobile: nut toggle chon thay cho checkbox nho + nut Dat ngay (CSS an o desktop). */ ?>
			<label class="pick-btn" for="<?php echo esc_attr( $cb_id ); ?>">
				<span class="pick-add">+ Chọn báo này</span>
				<span class="pick-on">Đã chọn</span>
			</label>
		</td>
	</tr>
	<?php
	return ob_get_clean();
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
		'backlink-social-entity' => 'Backlink Social Entity',
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
