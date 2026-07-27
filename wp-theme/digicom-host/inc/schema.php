<?php
/**
 * Schema.org JSON-LD - MOT khoi @graph duy nhat cho toan site.
 *
 * Nguyen tac:
 * - Chi 1 the <script type="application/ld+json"> moi trang (khong rai rac nhieu khoi roi
 *   nhu truoc: FAQPage o blk-faq/svc-faq, Person o author.php) -> cac node lien ket nhau
 *   bang @id, Google/AI doc duoc 1 do thi thuc the thong nhat thay vi cac manh roi.
 * - MOI so lieu deu lay tu du lieu THAT (option WP Admin, CPT dgc_gia, CSDL bai viet).
 *   KHONG bia rating/review/so lieu (rule content-professional + quality-bar).
 * - Khong emit Review/AggregateRating vi testimonial hien la noi dung mau, chua phai
 *   danh gia that co danh tinh -> emit se la du lieu sai su that va vi pham policy Google.
 *
 * Sua noi dung (ten, dia chi, hotline, gio lam viec, FAQ...) o WP Admin -> schema tu doi.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ===========================================================================
 * 1. Helper chung
 * ========================================================================= */

/** @id tuyet doi theo goc site, vd https://digicomvn.com/#organization */
function dgc_sch_id( $frag ) {
	return home_url( '/' ) . '#' . $frag;
}

/** Lam sach chuoi cho JSON-LD: bo tag, giai ma entity, gom khoang trang, cat do dai. */
function dgc_sch_txt( $s, $max = 0 ) {
	$s = wp_strip_all_tags( (string) $s, true );
	$s = html_entity_decode( $s, ENT_QUOTES, 'UTF-8' );
	$s = trim( preg_replace( '/\s+/u', ' ', $s ) );
	if ( $max > 0 && function_exists( 'mb_strlen' ) && mb_strlen( $s ) > $max ) {
		$s = rtrim( mb_substr( $s, 0, $max ) ) . '...';
	}
	return $s;
}

/** URL chuan cua request hien tai (dung lam goc @id cho node cua trang). */
function dgc_sch_url() {
	if ( is_front_page() ) return home_url( '/' );
	if ( is_singular() ) {
		$u = function_exists( 'wp_get_canonical_url' ) ? wp_get_canonical_url() : '';
		return $u ? $u : (string) get_permalink();
	}
	if ( is_category() || is_tag() || is_tax() ) {
		$l = get_term_link( get_queried_object() );
		return is_wp_error( $l ) ? home_url( '/' ) : $l;
	}
	if ( is_author() )   return get_author_posts_url( get_queried_object_id() );
	if ( is_home() )     return get_permalink( (int) get_option( 'page_for_posts' ) ) ?: home_url( '/' );
	if ( is_search() )   return home_url( '/?s=' . rawurlencode( get_search_query() ) );
	if ( is_post_type_archive() ) {
		$l = get_post_type_archive_link( (string) get_query_var( 'post_type' ) );
		return $l ? $l : home_url( '/' );
	}
	return home_url( '/' );
}

/**
 * URL cua trang hien tai CO tinh phan trang.
 * Bat buoc: /category/x/page/2/ la mot trang KHAC voi /category/x/ (danh sach bai khac han).
 * Neu dung chung @id thi 2 trang cung khai la mot thuc the nhung noi dung mau thuan nhau.
 */
function dgc_sch_url_paged() {
	$u     = dgc_sch_url();
	$paged = (int) get_query_var( 'paged' );
	if ( ! is_singular() && $paged > 1 ) {
		$l = get_pagenum_link( $paged );
		if ( $l ) return $l;
	}
	return $u;
}

/** So dien thoai dang E.164 (+84...) - dinh dang Google khuyen dung. */
function dgc_sch_phone( $raw ) {
	$d = preg_replace( '/[^0-9]/', '', (string) $raw );
	if ( $d === '' ) return '';
	if ( strpos( $d, '84' ) === 0 && strlen( $d ) >= 11 ) return '+' . $d;
	return '+84' . ltrim( $d, '0' );
}

/** Node ImageObject day du (co kich thuoc that neu la attachment cua site). */
function dgc_sch_image( $url, $id_frag = '', $caption = '' ) {
	if ( ! $url ) return null;
	$node = array( '@type' => 'ImageObject', 'url' => $url, 'contentUrl' => $url );
	if ( $id_frag ) $node['@id'] = dgc_sch_id( $id_frag );
	$att_id = attachment_url_to_postid( $url );
	if ( $att_id ) {
		$meta = wp_get_attachment_metadata( $att_id );
		if ( ! empty( $meta['width'] ) )  $node['width']  = (int) $meta['width'];
		if ( ! empty( $meta['height'] ) ) $node['height'] = (int) $meta['height'];
		$alt = get_post_meta( $att_id, '_wp_attachment_image_alt', true );
		if ( $alt && ! $caption ) $caption = $alt;
	}
	if ( $caption ) $node['caption'] = dgc_sch_txt( $caption, 160 );
	return $node;
}

/** Bo cac khoa rong khoi node (tranh "name": "" lam ban do thi). */
function dgc_sch_prune( $arr ) {
	foreach ( $arr as $k => $v ) {
		if ( is_array( $v ) ) {
			$v = dgc_sch_prune( $v );
			$arr[ $k ] = $v;
		}
		if ( $v === '' || $v === null || $v === array() ) unset( $arr[ $k ] );
	}
	return $arr;
}

/** Tach chuoi dia chi 1 dong thanh PostalAddress (street + tinh/thanh + quoc gia). */
function dgc_sch_address( $raw ) {
	$raw = dgc_sch_txt( $raw );
	if ( $raw === '' ) return null;
	$cities = array( 'Hà Nội', 'TP. Hồ Chí Minh', 'Hồ Chí Minh', 'Đà Nẵng', 'Hải Phòng', 'Cần Thơ' );
	$street = $raw;
	$city   = '';
	foreach ( $cities as $c ) {
		if ( mb_substr( $raw, -mb_strlen( $c ) ) === $c ) {
			$city   = $c;
			$street = rtrim( mb_substr( $raw, 0, mb_strlen( $raw ) - mb_strlen( $c ) ), " ,\t" );
			break;
		}
	}
	return dgc_sch_prune( array(
		'@type'           => 'PostalAddress',
		'streetAddress'   => $street,
		'addressLocality' => $city,
		'addressRegion'   => $city,
		'addressCountry'  => 'VN',
	) );
}

/**
 * Gio lam viec -> OpeningHoursSpecification.
 * Doc option 'working_hours' dang "Thứ 2 - Thứ 6, 8:00 - 18:00". Khong parse duoc -> tra null
 * (KHONG doan bua gio mo cua).
 */
function dgc_sch_hours( $raw ) {
	$raw = dgc_sch_txt( $raw );
	if ( ! preg_match( '/(\d{1,2})[:h](\d{2})\s*-\s*(\d{1,2})[:h](\d{2})/u', $raw, $t ) ) return null;
	$map = array( 2 => 'Monday', 3 => 'Tuesday', 4 => 'Wednesday', 5 => 'Thursday', 6 => 'Friday', 7 => 'Saturday' );
	$days = array();
	if ( preg_match( '/thứ\s*(\d)\s*-\s*(?:thứ\s*)?(\d)/ui', $raw, $d ) ) {
		for ( $i = (int) $d[1]; $i <= (int) $d[2]; $i++ ) {
			if ( isset( $map[ $i ] ) ) $days[] = $map[ $i ];
		}
	}
	if ( preg_match( '/chủ\s*nhật/ui', $raw ) ) $days[] = 'Sunday';
	if ( ! $days ) $days = array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' );
	return array(
		'@type'     => 'OpeningHoursSpecification',
		'dayOfWeek' => $days,
		'opens'     => sprintf( '%02d:%s', (int) $t[1], $t[2] ),
		'closes'    => sprintf( '%02d:%s', (int) $t[3], $t[4] ),
	);
}

/* ===========================================================================
 * 2. Doc gia THAT tu CPT dgc_gia -> AggregateOffer
 * ========================================================================= */

/**
 * Boc moi con so tien trong 1 chuoi gia (loc nhieu: chi lay >= 50.000d de khong dinh
 * "3 tháng", "1000 từ"; chan tren 5 ty de khong dinh so rac).
 */
function dgc_sch_prices_from( $s ) {
	$out = array();
	if ( ! preg_match_all( '/\d[\d.,]*/u', (string) $s, $m ) ) return $out;
	foreach ( $m[0] as $num ) {
		$n = (float) str_replace( array( '.', ',', ' ' ), '', $num );
		if ( $n >= 50000 && $n <= 5000000000 ) $out[] = $n;
	}
	return $out;
}

/**
 * AggregateOffer cho 1 nhom dich vu (slug taxonomy dgc_nhom).
 * Cache 12h (transient) vi phai quet hang tram dong gia.
 * Khong co dong gia hop le -> tra null (KHONG bia khoang gia).
 */
function dgc_sch_agg_offer( $nhom_slug ) {
	$key   = 'dgc_sch_offer_' . md5( (string) $nhom_slug );
	$cache = get_transient( $key );
	if ( is_array( $cache ) ) return $cache ? $cache : null;

	$prices = array();
	$count  = 0;
	if ( function_exists( 'dgc_get_gia' ) ) {
		foreach ( dgc_get_gia( $nhom_slug ) as $row ) {
			$p = dgc_sch_prices_from( $row->meta['gia_km'] ?? '' );
			if ( $p ) { $prices = array_merge( $prices, $p ); $count++; }
		}
	}
	if ( ! $prices ) {
		set_transient( $key, array(), 12 * HOUR_IN_SECONDS );
		return null;
	}
	$node = array(
		'@type'         => 'AggregateOffer',
		'priceCurrency' => 'VND',
		'lowPrice'      => (string) (int) min( $prices ),
		'highPrice'     => (string) (int) max( $prices ),
		'offerCount'    => $count,
		'availability'  => 'https://schema.org/InStock',
		'seller'        => array( '@id' => dgc_sch_id( 'organization' ) ),
	);
	set_transient( $key, $node, 12 * HOUR_IN_SECONDS );
	return $node;
}

/** dgc_get_gia() nhung nho ket qua trong 1 request (tranh query lai khi vua dung o head vua o body). */
function dgc_sch_gia( $nhom_slug ) {
	static $memo = array();
	if ( ! isset( $memo[ $nhom_slug ] ) ) {
		$memo[ $nhom_slug ] = function_exists( 'dgc_get_gia' ) ? dgc_get_gia( $nhom_slug ) : array();
	}
	return $memo[ $nhom_slug ];
}

/**
 * 1 dong bang gia -> node Offer (gia don) hoac AggregateOffer (dong co bang bac thang gia).
 * Chi dung cho dong CO hien tren chinh trang do (policy: schema phai khop noi dung nhin thay).
 */
function dgc_sch_offer_node( $row, $page_url, $nhom_label ) {
	$m      = isset( $row->meta ) ? $row->meta : array();
	$prices = dgc_sch_prices_from( $m['gia_km'] ?? '' );
	if ( ! $prices ) return null;

	$ten   = dgc_sch_txt( $row->post_title );
	$vitri = dgc_sch_txt( $m['vi_tri'] ?? '' );
	$node  = array(
		'@type'         => 'Offer',
		'name'          => $vitri ? $ten . ' - ' . $vitri : $ten,
		'priceCurrency' => 'VND',
		'availability'  => 'https://schema.org/InStock',
		'url'           => $page_url,
		'category'      => $nhom_label,
		'description'   => dgc_sch_txt( trim( ( $m['yeu_cau'] ?? '' ) . ' ' . ( $m['so_link'] ?? '' ) ), 300 ),
		'seller'        => array( '@id' => dgc_sch_id( 'organization' ) ),
		'itemOffered'   => array(
			'@type'       => 'Service',
			'name'        => $nhom_label . ' - ' . $ten,
			'serviceType' => $nhom_label,
			'provider'    => array( '@id' => dgc_sch_id( 'organization' ) ),
		),
	);

	if ( count( $prices ) === 1 ) {
		$node['price'] = (string) (int) $prices[0];
	} else {
		// Dong co nhieu muc (vd textlink theo 3/6/12 thang) -> khong the ep ve 1 con so.
		$node['@type']      = 'AggregateOffer';
		$node['lowPrice']   = (string) (int) min( $prices );
		$node['highPrice']  = (string) (int) max( $prices );
		$node['offerCount'] = count( $prices );
	}
	return dgc_sch_prune( $node );
}

/**
 * Bai viet co nhung bang gia 1 dau bao ([dgc_bang_gia bao="..." domain="..."]) -> emit
 * Service + Offer GIA THAT cua chinh dau bao do. Day la thu tra loi truc tiep truy van
 * kieu "book bao VnExpress gia bao nhieu" tren Google/AI, thay vi chi co khoang gia chung.
 * Loc dong theo DUNG logic cua inc/service-pricing.php de schema khop bang hien tren trang.
 */
function dgc_sch_outlet_service() {
	if ( ! is_singular( 'post' ) ) return null;

	$content = (string) get_post_field( 'post_content', get_the_ID() );
	if ( strpos( $content, '[dgc_bang_gia' ) === false ) return null;
	if ( ! preg_match( '/\[dgc_bang_gia([^\]]*)\]/', $content, $mm ) ) return null;

	$atts    = shortcode_parse_atts( $mm[1] );
	$bao     = isset( $atts['bao'] ) ? trim( (string) $atts['bao'] ) : '';
	$domains = array_filter( array_map( 'trim', explode( ',', isset( $atts['domain'] ) ? (string) $atts['domain'] : '' ) ) );
	$slug    = sanitize_title( isset( $atts['nhom'] ) ? $atts['nhom'] : 'booking-bao-pr' );
	if ( '' === $bao && ! $domains ) return null;

	$rows = dgc_sch_gia( $slug );
	if ( $domains ) {
		$d    = array_map( 'strtolower', $domains );
		$rows = array_values( array_filter( $rows, function ( $it ) use ( $d ) {
			return in_array( strtolower( trim( $it->post_title ) ), $d, true );
		} ) );
	} else {
		$kw   = str_replace( '-', '', sanitize_title( $bao ) );
		$rows = array_values( array_filter( $rows, function ( $it ) use ( $kw ) {
			return stripos( str_replace( '-', '', $it->post_title ), $kw ) !== false;
		} ) );
	}
	if ( ! $rows ) return null;

	$label  = function_exists( 'dgc_current_nhom' ) ? 'Booking báo & PR' : 'Booking báo & PR';
	$url    = dgc_sch_url();
	$offers = array();
	foreach ( $rows as $r ) {
		$o = dgc_sch_offer_node( $r, $url, $label );
		if ( $o ) $offers[] = $o;
	}
	if ( ! $offers ) return null;

	return dgc_sch_prune( array(
		'@type'            => 'Service',
		'@id'              => $url . '#service',
		'name'             => $bao ? 'Đăng bài PR trên ' . $bao : dgc_sch_txt( get_the_title() ),
		'serviceType'      => $label,
		'url'              => $url,
		'provider'         => array( '@id' => dgc_sch_id( 'organization' ) ),
		'areaServed'       => array( '@type' => 'Country', 'name' => 'Việt Nam' ),
		'offers'           => count( $offers ) === 1 ? $offers[0] : $offers,
		'mainEntityOfPage' => array( '@id' => $url . '#webpage' ),
		'termsOfService'   => dgc_sch_terms_url(),
	) );
}

/** URL trang dieu khoan (neu co that) - dung cho Service.termsOfService. */
function dgc_sch_terms_url() {
	$p = get_page_by_path( 'dieu-khoan-su-dung' );
	return ( $p && 'publish' === $p->post_status ) ? get_permalink( $p ) : '';
}

/** Xoa cache khoang gia khi sua/them/xoa 1 dong bang gia. */
add_action( 'save_post_dgc_gia', 'dgc_sch_flush_offer_cache' );
add_action( 'deleted_post', 'dgc_sch_flush_offer_cache_deleted', 10, 2 );
function dgc_sch_flush_offer_cache_deleted( $post_id, $post = null ) {
	if ( $post && isset( $post->post_type ) && 'dgc_gia' !== $post->post_type ) return;
	dgc_sch_flush_offer_cache();
}
function dgc_sch_flush_offer_cache() {
	foreach ( dgc_sch_nhom_slugs() as $slug ) {
		delete_transient( 'dgc_sch_offer_' . md5( $slug ) );
	}
	delete_transient( 'dgc_sch_price_range' );
}

/** Danh sach slug nhom dich vu dang hien tren web (khop dgc_service_links). */
function dgc_sch_nhom_slugs() {
	$out = array();
	if ( ! function_exists( 'dgc_service_links' ) ) return $out;
	foreach ( dgc_service_links() as $sl ) {
		$out[] = trim( $sl[1], '/' );
	}
	return $out;
}

/* ===========================================================================
 * 3. FAQ dung chung cho block hien thi + schema (mot nguon du lieu duy nhat)
 * ========================================================================= */

/** FAQ chung (option 'faqs') - dung o trang chu. */
function dgc_faq_items() {
	if ( ! function_exists( 'dgc_lines' ) ) return array();
	return array_values( array_filter( dgc_lines( 'faqs' ), function ( $f ) {
		return ! empty( $f[0] ) && ! empty( $f[1] );
	} ) );
}

/** FAQ rieng cua 1 nhom dich vu (option 'svc_faqs': slug | hoi | dap). */
function dgc_svc_faq_items( $slug ) {
	$out = array();
	if ( ! $slug || ! function_exists( 'dgc_lines' ) ) return $out;
	foreach ( dgc_lines( 'svc_faqs' ) as $row ) {
		if ( isset( $row[0] ) && trim( $row[0] ) === $slug && ! empty( $row[1] ) && ! empty( $row[2] ) ) {
			$out[] = array( trim( $row[1] ), trim( $row[2] ) );
		}
	}
	return $out;
}

/**
 * FAQ rieng cua 1 bai viet/trang - luu o meta 'dgc_faqs' (mang [cau hoi, cau tra loi]).
 * Nguon: da chuyen tu cac khoi <script ld+json> tung bi chen thang vao than bai
 * (tools/migrate-inline-schema.php). Sua duoc o WP Admin -> o "FAQ cho schema".
 */
function dgc_post_faq_items( $post_id = 0 ) {
	$post_id = $post_id ?: get_the_ID();
	$raw     = $post_id ? get_post_meta( $post_id, 'dgc_faqs', true ) : '';
	if ( ! is_array( $raw ) ) return array();
	$out = array();
	foreach ( $raw as $f ) {
		if ( ! empty( $f[0] ) && ! empty( $f[1] ) ) $out[] = array( $f[0], $f[1] );
	}
	return $out;
}

/** FAQ ap dung cho request hien tai (bai viet -> FAQ rieng; trang chu -> FAQ chung; dich vu -> FAQ dich vu). */
function dgc_sch_page_faqs() {
	if ( is_singular() ) {
		$own = dgc_post_faq_items();
		if ( $own ) return $own;
	}
	if ( is_front_page() ) return dgc_faq_items();
	if ( is_page() && function_exists( 'dgc_current_nhom' ) ) {
		$nhom = dgc_current_nhom();
		if ( $nhom ) return dgc_svc_faq_items( $nhom['slug'] );
	}
	return array();
}

/* ===========================================================================
 * 4. Node Organization / WebSite / Person
 * ========================================================================= */

/** Tai khoan WP dung lam nguoi sang lap (co khai chuc danh trong ho so). */
function dgc_sch_founder_id() {
	$cached = wp_cache_get( 'dgc_sch_founder', 'dgc' );
	if ( $cached !== false ) return (int) $cached;
	$id = 0;
	$us = get_users( array( 'meta_key' => 'dgc_role_title', 'meta_compare' => 'EXISTS', 'number' => 1, 'fields' => 'ID' ) );
	if ( $us ) {
		$id = (int) $us[0];
	} else {
		$us = get_users( array( 'role' => 'administrator', 'number' => 1, 'fields' => 'ID' ) );
		if ( $us ) $id = (int) $us[0];
	}
	wp_cache_set( 'dgc_sch_founder', $id, 'dgc' );
	return $id;
}

/** Node Person day du tu ho so WP Admin (khong bia thanh tich - trong thi bo qua). */
function dgc_sch_person( $user_id ) {
	$user_id = (int) $user_id;
	if ( ! $user_id ) return null;
	$u = get_userdata( $user_id );
	if ( ! $u ) return null;

	$m = function ( $k ) use ( $user_id ) { return get_user_meta( $user_id, $k, true ); };

	$avatar_id  = (int) $m( 'dgc_avatar_id' );
	$avatar_url = $avatar_id ? wp_get_attachment_image_url( $avatar_id, 'medium' ) : '';

	$node = array(
		'@type'       => 'Person',
		'@id'         => dgc_sch_id( 'person-' . $user_id ),
		'name'        => dgc_sch_txt( $u->display_name ),
		'url'         => get_author_posts_url( $user_id ),
		'jobTitle'    => dgc_sch_txt( $m( 'dgc_role_title' ) ),
		'description' => dgc_sch_txt( $m( 'dgc_bio_long' ) ?: $u->description, 500 ),
		'worksFor'    => array( '@id' => dgc_sch_id( 'organization' ) ),
		'image'       => $avatar_url ? dgc_sch_image( $avatar_url, '', 'Ảnh chân dung ' . $u->display_name ) : null,
	);

	// Linh vuc am hieu: uu tien khai bao trong ho so, khong co thi lay cum chu de that.
	$knows = array();
	if ( function_exists( 'dgc_author_pairs' ) ) {
		foreach ( dgc_author_pairs( $m( 'dgc_expertise' ) ) as $e ) {
			if ( ! empty( $e[0] ) ) $knows[] = dgc_sch_txt( $e[0] );
		}
	}
	if ( ! $knows ) {
		foreach ( get_categories( array( 'hide_empty' => true ) ) as $c ) {
			if ( 'uncategorized' !== $c->slug ) $knows[] = $c->name;
		}
	}
	$node['knowsAbout'] = array_values( array_unique( $knows ) );

	$same = array_values( array_filter( array( $m( 'dgc_facebook' ), $m( 'dgc_linkedin' ) ) ) );
	if ( $same ) $node['sameAs'] = $same;

	if ( function_exists( 'dgc_author_pairs' ) ) {
		$creds = array();
		foreach ( dgc_author_pairs( $m( 'dgc_credentials' ) ) as $c ) {
			if ( empty( $c[0] ) ) continue;
			$creds[] = dgc_sch_prune( array(
				'@type'              => 'EducationalOccupationalCredential',
				'name'               => dgc_sch_txt( $c[0] ),
				'credentialCategory' => dgc_sch_txt( $c[1] ?? '' ),
			) );
		}
		if ( $creds ) $node['hasCredential'] = $creds;
	}

	return dgc_sch_prune( $node );
}

/** Node Organization + ProfessionalService (doanh nghiep that, dia chi + MST that). */
function dgc_sch_organization() {
	$logo = function_exists( 'dgc_logo_url' ) ? dgc_logo_url() : '';
	$desc = dgc_sch_txt( dgc( 'hero_sub' ) ?: get_bloginfo( 'description' ), 300 );

	$node = array(
		'@type'         => array( 'Organization', 'ProfessionalService' ),
		'@id'           => dgc_sch_id( 'organization' ),
		'name'          => 'DigicomVN',
		'legalName'     => 'Công ty TNHH Dịch vụ Truyền thông Digito Combat',
		'alternateName' => array( 'Digicom VN', 'Digicom' ),
		'url'           => home_url( '/' ),
		'description'   => $desc,
		'telephone'     => dgc_sch_phone( dgc( 'hotline' ) ),
		'email'         => dgc_sch_txt( dgc( 'email' ) ),
		'address'       => dgc_sch_address( dgc( 'address' ) ),
		'vatID'         => '0109816406',
		'taxID'         => '0109816406',
		'identifier'    => array(
			'@type' => 'PropertyValue',
			'name'  => 'Mã số thuế',
			'value' => '0109816406',
		),
		'foundingDate'  => '2021-11-12',
		'areaServed'    => array( '@type' => 'Country', 'name' => 'Việt Nam' ),
		// KHONG dat 'inLanguage' o day: schema.org chi cho phep tren CreativeWork,
		// validator.schema.org bao UNKNOWN_FIELD cho Organization (da kiem 2026-07-27).
		'knowsAbout'    => array(
			'Booking báo chí', 'Đăng bài PR trên báo điện tử', 'Guest Post', 'Mua Textlink',
			'Dịch vụ Backlink', 'Backlink Social Entity', 'Backlink quốc tế', 'SEO off-page',
			'Truyền thông thương hiệu',
		),
	);

	if ( $logo ) {
		$node['logo']  = dgc_sch_image( $logo, 'logo', 'DigicomVN' );
		$node['image'] = array( '@id' => dgc_sch_id( 'logo' ) );
	}

	$hours = dgc_sch_hours( dgc( 'working_hours' ) );
	if ( $hours ) $node['openingHoursSpecification'] = array( $hours );

	// Khoang gia THAT: gia thap nhat / cao nhat dang niem yet tren toan bang gia.
	$range = dgc_sch_price_range();
	if ( $range ) $node['priceRange'] = $range;

	// Kenh lien he
	$tel = dgc_sch_phone( dgc( 'hotline' ) );
	if ( $tel ) {
		$node['contactPoint'] = array( dgc_sch_prune( array(
			'@type'             => 'ContactPoint',
			'contactType'       => 'customer service',
			'telephone'         => $tel,
			'email'             => dgc_sch_txt( dgc( 'email' ) ),
			'areaServed'        => 'VN',
			'availableLanguage' => array( 'Vietnamese', 'vi' ),
		) ) );
	}

	// Ho so mang xa hoi that (khong bia link)
	$same = array();
	if ( dgc( 'facebook' ) ) $same[] = dgc( 'facebook' );
	$zalo = preg_replace( '/[^0-9]/', '', (string) dgc( 'zalo' ) );
	if ( $zalo ) $same[] = 'https://zalo.me/' . $zalo;
	if ( $same ) $node['sameAs'] = $same;

	// Nguoi sang lap (lay tu ho so WP, khong hardcode)
	$fid = dgc_sch_founder_id();
	if ( $fid ) $node['founder'] = array( '@id' => dgc_sch_id( 'person-' . $fid ) );

	// Danh muc dich vu dang ban
	$cat = array();
	if ( function_exists( 'dgc_service_links' ) ) {
		foreach ( dgc_service_links() as $sl ) {
			$cat[] = array(
				'@type'       => 'Offer',
				'itemOffered' => array(
					'@type'    => 'Service',
					'@id'      => home_url( $sl[1] ) . '#service',
					'name'     => dgc_sch_txt( $sl[0] ),
					'url'      => home_url( $sl[1] ),
					'provider' => array( '@id' => dgc_sch_id( 'organization' ) ),
				),
			);
		}
	}
	if ( $cat ) {
		$node['hasOfferCatalog'] = array(
			'@type'           => 'OfferCatalog',
			'@id'             => dgc_sch_id( 'offercatalog' ),
			'name'            => 'Dịch vụ off-page SEO của DigicomVN',
			'itemListElement' => $cat,
		);
	}

	// Bao chi da viet ve DigicomVN (chi lay dong CO URL that trong option press_mentions).
	$subject = array();
	if ( function_exists( 'dgc_lines' ) ) {
		foreach ( dgc_lines( 'press_mentions' ) as $pm ) {
			if ( empty( $pm[1] ) || strpos( $pm[1], 'http' ) !== 0 ) continue;
			$subject[] = dgc_sch_prune( array(
				'@type'     => 'NewsArticle',
				'url'       => esc_url_raw( $pm[1] ),
				'publisher' => array( '@type' => 'Organization', 'name' => dgc_sch_txt( $pm[0] ) ),
			) );
		}
	}
	if ( $subject ) $node['subjectOf'] = $subject;

	return dgc_sch_prune( $node );
}

/** Khoang gia toan site (dung cho priceRange cua Organization). Cache 12h. */
function dgc_sch_price_range() {
	$cache = get_transient( 'dgc_sch_price_range' );
	if ( $cache !== false ) return $cache ? $cache : '';

	$lo = null; $hi = null;
	foreach ( dgc_sch_nhom_slugs() as $slug ) {
		$agg = dgc_sch_agg_offer( $slug );
		if ( ! $agg ) continue;
		$l = (float) $agg['lowPrice']; $h = (float) $agg['highPrice'];
		$lo = ( $lo === null ) ? $l : min( $lo, $l );
		$hi = ( $hi === null ) ? $h : max( $hi, $h );
	}
	$out = ( $lo && $hi ) ? number_format( $lo, 0, ',', '.' ) . 'đ - ' . number_format( $hi, 0, ',', '.' ) . 'đ' : '';
	set_transient( 'dgc_sch_price_range', $out ? $out : '', 12 * HOUR_IN_SECONDS );
	return $out;
}

/** Node WebSite + hanh dong tim kiem noi bo (search.php co that). */
function dgc_sch_website() {
	return dgc_sch_prune( array(
		'@type'           => 'WebSite',
		'@id'             => dgc_sch_id( 'website' ),
		'url'             => home_url( '/' ),
		'name'            => dgc_sch_txt( get_bloginfo( 'name' ) ),
		'alternateName'   => 'DigicomVN',
		'description'     => dgc_sch_txt( get_bloginfo( 'description' ), 300 ),
		'inLanguage'      => 'vi-VN',
		'publisher'       => array( '@id' => dgc_sch_id( 'organization' ) ),
		'potentialAction' => array( array(
			'@type'       => 'SearchAction',
			'target'      => array(
				'@type'       => 'EntryPoint',
				'urlTemplate' => home_url( '/?s={search_term_string}' ),
			),
			'query-input' => 'required name=search_term_string',
		) ),
	) );
}

/* ===========================================================================
 * 5. BreadcrumbList - dung theo dung duong dan hien thi tren giao dien
 * ========================================================================= */

function dgc_sch_breadcrumb() {
	$items = array( array( 'Trang chủ', home_url( '/' ) ) );
	$blog  = get_permalink( (int) get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' );

	if ( is_singular( 'post' ) ) {
		$items[] = array( 'Blog', $blog );
		$cats = get_the_category();
		if ( $cats ) $items[] = array( $cats[0]->name, get_category_link( $cats[0] ) );
		$items[] = array( get_the_title(), get_permalink() );

	} elseif ( is_singular( 'dgc_case' ) ) {
		$arch = get_post_type_archive_link( 'dgc_case' );
		if ( $arch ) $items[] = array( 'Case study', $arch );
		$items[] = array( get_the_title(), get_permalink() );

	} elseif ( is_page() ) {
		if ( is_front_page() ) return null;
		foreach ( array_reverse( get_post_ancestors( get_the_ID() ) ) as $anc ) {
			$items[] = array( get_the_title( $anc ), get_permalink( $anc ) );
		}
		$items[] = array( get_the_title(), get_permalink() );

	} elseif ( is_category() ) {
		$items[] = array( 'Blog', $blog );
		$term = get_queried_object();
		foreach ( array_reverse( get_ancestors( $term->term_id, 'category' ) ) as $anc ) {
			$t = get_term( $anc, 'category' );
			if ( $t && ! is_wp_error( $t ) ) $items[] = array( $t->name, get_category_link( $t ) );
		}
		$items[] = array( $term->name, get_category_link( $term ) );

	} elseif ( is_home() ) {
		$items[] = array( 'Blog', $blog );

	} elseif ( is_author() ) {
		// Khop dung breadcrumb hien tren giao dien: Trang chu / <ten tac gia>.
		$items[] = array( get_the_author_meta( 'display_name', get_queried_object_id() ), dgc_sch_url() );

	} elseif ( is_post_type_archive( 'dgc_case' ) ) {
		$items[] = array( 'Case study', dgc_sch_url() );

	} elseif ( is_search() ) {
		$items[] = array( 'Kết quả tìm kiếm', dgc_sch_url() );

	} else {
		return null;
	}

	if ( count( $items ) < 2 ) return null;

	$list = array();
	foreach ( $items as $i => $it ) {
		$list[] = array(
			'@type'    => 'ListItem',
			'position' => $i + 1,
			'name'     => dgc_sch_txt( $it[0], 120 ),
			'item'     => $it[1],
		);
	}
	return array(
		'@type'           => 'BreadcrumbList',
		'@id'             => dgc_sch_url_paged() . '#breadcrumb',
		'itemListElement' => $list,
	);
}

/* ===========================================================================
 * 6. Node cua TRANG hien tai (WebPage + bien the) va thuc the chinh
 * ========================================================================= */

/** Kieu WebPage phu hop tung loai trang. */
function dgc_sch_page_type() {
	if ( is_front_page() )               return array( 'WebPage' );
	if ( is_singular( 'post' ) )         return array( 'WebPage' );
	if ( is_author() )                   return array( 'ProfilePage' );
	if ( is_search() )                   return array( 'SearchResultsPage' );
	if ( is_home() || is_category() || is_post_type_archive() ) return array( 'CollectionPage' );
	if ( is_page( 'lien-he' ) )          return array( 'ContactPage' );
	if ( is_page( 've-digicom' ) )       return array( 'AboutPage' );
	if ( is_page( 'bang-gia' ) )         return array( 'CollectionPage' );
	return array( 'WebPage' );
}

/** Anh dai dien cua trang (featured image) -> primaryImageOfPage. */
function dgc_sch_primary_image() {
	if ( ! is_singular() ) return null;

	if ( has_post_thumbnail() ) {
		$u = get_the_post_thumbnail_url( get_the_ID(), 'full' );
		if ( $u ) return dgc_sch_image( $u, '', get_the_title() );
	}

	// Nhieu bai khong dat anh dai dien nhung co anh minh hoa that trong than bai.
	// Lay anh do (bo hau to kich thuoc de tra ra ban goc co width/height) thay vi
	// de Article thieu 'image' - thuoc tinh Google can de hien rich result.
	$html = (string) get_post_field( 'post_content', get_the_ID() );
	if ( preg_match( '/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $m ) ) {
		$full = preg_replace( '/-\d+x\d+(\.[a-z]{3,4})$/i', '$1', $m[1] );
		return dgc_sch_image( attachment_url_to_postid( $full ) ? $full : $m[1], '', get_the_title() );
	}
	return null;
}

/** ItemList cho cac trang danh sach (blog, chuyen muc, case study, bang gia). */
function dgc_sch_item_list() {
	$items = array();

	if ( is_page( 'bang-gia' ) ) {
		if ( function_exists( 'dgc_service_links' ) ) {
			foreach ( dgc_service_links() as $sl ) {
				$items[] = array( $sl[0], home_url( $sl[1] ) );
			}
		}
	} elseif ( is_home() ) {
		foreach ( get_categories( array( 'hide_empty' => true ) ) as $c ) {
			$items[] = array( $c->name, get_category_link( $c ) );
		}
	} elseif ( is_category() || is_post_type_archive() ) {
		global $wp_query;
		if ( ! empty( $wp_query->posts ) ) {
			foreach ( $wp_query->posts as $p ) {
				$items[] = array( get_the_title( $p ), get_permalink( $p ) );
			}
		}
	}

	if ( ! $items ) return null;

	$list = array();
	foreach ( $items as $i => $it ) {
		$list[] = array(
			'@type'    => 'ListItem',
			'position' => $i + 1,
			'name'     => dgc_sch_txt( $it[0], 160 ),
			'url'      => $it[1],
		);
	}
	return array(
		'@type'           => 'ItemList',
		'@id'             => dgc_sch_url_paged() . '#itemlist',
		'numberOfItems'   => count( $list ),
		'itemListOrder'   => 'https://schema.org/ItemListOrderAscending',
		'itemListElement' => $list,
	);
}

/** Node Service cho 8 trang dich vu pillar (kem khoang gia that tu bang gia). */
function dgc_sch_service() {
	if ( ! is_page() || ! function_exists( 'dgc_current_nhom' ) ) return null;
	$nhom = dgc_current_nhom();
	if ( ! $nhom ) return null;

	$url       = dgc_sch_url();
	$is_pillar = ( get_post_field( 'post_name', get_the_ID() ) === $nhom['slug'] );

	// Trang con theo NGACH (vd /dich-vu-backlink/bat-dong-san/) van la mot dich vu, nhung
	// khong co bang gia rieng -> emit Service KHONG kem gia, tro ve dich vu cha bang
	// isRelatedTo. Trang con theo DAU BAO lai la bai viet (post), khong vao nhanh nay.
	if ( ! $is_pillar && ! wp_get_post_parent_id( get_the_ID() ) ) return null;

	$desc = dgc_sch_txt( get_the_excerpt() ?: ( $is_pillar ? dgc_sch_svc_intro( $nhom['slug'] ) : '' ), 400 );

	$node = array(
		'@type'       => 'Service',
		'@id'         => $url . '#service',
		'name'        => dgc_sch_txt( get_the_title() ),
		'serviceType' => dgc_sch_txt( $nhom['label'] ),
		'url'         => $url,
		'description' => $desc,
		'provider'    => array( '@id' => dgc_sch_id( 'organization' ) ),
		'areaServed'  => array( '@type' => 'Country', 'name' => 'Việt Nam' ),
		'category'    => 'SEO off-page',
		'mainEntityOfPage' => array( '@id' => $url . '#webpage' ),
		'termsOfService'   => dgc_sch_terms_url(),
		// Buoc tiep theo ro rang cho ca nguoi dung lan tac tu AI: dat bai o dau.
		'potentialAction'  => array(
			'@type'  => 'OrderAction',
			'name'   => 'Đặt bài',
			'target' => array(
				'@type'       => 'EntryPoint',
				'urlTemplate' => home_url( '/dat-bai/' ),
				'inLanguage'  => 'vi-VN',
			),
		),
	);

	if ( $is_pillar ) {
		$agg = dgc_sch_agg_offer( $nhom['slug'] );
		if ( $agg ) $node['offers'] = $agg;

		// Cac hang muc danh dau "pho bien nhat" - deu HIEN trong bang gia cua chinh trang nay,
		// nen dua gia cu the vao schema la hop le va tra loi truy van gia truc tiep hon
		// khoang gia tong. Chan 20 dong de khong phinh JSON.
		$feat = array();
		foreach ( dgc_sch_gia( $nhom['slug'] ) as $r ) {
			if ( empty( $r->meta['noi_bat'] ) ) continue;
			$o = dgc_sch_offer_node( $r, $url, $nhom['label'] );
			if ( $o ) $feat[] = $o;
			if ( count( $feat ) >= 20 ) break;
		}
		if ( $feat ) {
			$node['hasOfferCatalog'] = array(
				'@type'           => 'OfferCatalog',
				'@id'             => $url . '#offercatalog',
				'name'            => 'Hạng mục phổ biến - ' . dgc_sch_txt( get_the_title() ),
				'itemListElement' => $feat,
			);
		}
	} else {
		$node['isRelatedTo'] = array( '@id' => home_url( '/' . $nhom['slug'] . '/' ) . '#service' );
	}

	return dgc_sch_prune( $node );
}

/** Doan dinh nghia "... la gi" cua dich vu (option svc_intros) - lam description du phong. */
function dgc_sch_svc_intro( $slug ) {
	if ( ! function_exists( 'dgc_lines' ) ) return '';
	foreach ( dgc_lines( 'svc_intros' ) as $row ) {
		if ( isset( $row[0] ) && trim( $row[0] ) === $slug && ! empty( $row[2] ) ) return $row[2];
	}
	return '';
}

/** Node Article cho bai blog + case study. */
function dgc_sch_article() {
	if ( ! is_singular( array( 'post', 'dgc_case' ) ) ) return null;

	$url = dgc_sch_url();
	// KHONG dung get_the_author_meta() o day: ham do doc global $authordata chi duoc set
	// trong vong lap the_post(), con schema chay o wp_head -> luon rong -> Article mat
	// thuoc tinh author (bat buoc voi rich result). Doc thang tu post_author.
	$aid = (int) get_post_field( 'post_author', get_the_ID() );

	$node = array(
		'@type'            => is_singular( 'post' ) ? array( 'Article', 'BlogPosting' ) : array( 'Article' ),
		'@id'              => $url . '#article',
		'headline'         => dgc_sch_txt( get_the_title(), 110 ),
		'name'             => dgc_sch_txt( get_the_title() ),
		'description'      => dgc_sch_txt( get_the_excerpt(), 300 ),
		'url'              => $url,
		'datePublished'    => get_the_date( DATE_W3C ),
		'dateModified'     => get_the_modified_date( DATE_W3C ),
		'inLanguage'       => 'vi-VN',
		'isAccessibleForFree' => true,
		// Case study duoc tao bang script nen post_author = 0 (khong co byline ca nhan).
		// Truong hop do ghi tac gia la chinh DigicomVN - dung ban chat (cong ty tu cong bo
		// du an cua minh), thay vi gan bua ten mot ca nhan.
		'author'           => array( '@id' => ( $aid && get_userdata( $aid ) ) ? dgc_sch_id( 'person-' . $aid ) : dgc_sch_id( 'organization' ) ),
		'publisher'        => array( '@id' => dgc_sch_id( 'organization' ) ),
		'mainEntityOfPage' => array( '@id' => $url . '#webpage' ),
		'isPartOf'         => array( '@id' => $url . '#webpage' ),
	);

	$img = dgc_sch_primary_image();
	if ( $img ) $node['image'] = $img;

	$cats = get_the_category();
	if ( $cats ) {
		$node['articleSection'] = dgc_sch_txt( $cats[0]->name );
		$node['isPartOf']       = array( '@id' => $url . '#webpage' );
	}

	$kw = array();
	foreach ( $cats as $c ) $kw[] = dgc_sch_txt( $c->name );
	foreach ( (array) get_the_tags() as $t ) { if ( ! empty( $t->name ) ) $kw[] = dgc_sch_txt( $t->name ); }
	if ( $kw ) $node['keywords'] = array_values( array_unique( $kw ) );

	// Bai thuoc cum chu de co trang dich vu tuong ung -> noi bai voi thuc the dich vu do
	// (giup Google/AI hieu bai nay noi ve dich vu nao, khong chi la bai kien thuc roi).
	if ( $cats && function_exists( 'dgc_cat_money_link' ) ) {
		$money = dgc_cat_money_link( $cats[0] );
		if ( $money ) $node['about'] = array( '@id' => trailingslashit( $money[1] ) . '#service' );
	}

	// Dem tu chuan Unicode (str_word_count lam theo byte -> sai voi tieng Viet co dau).
	$wc = preg_match_all( '/[\p{L}\p{N}]+/u', wp_strip_all_tags( strip_shortcodes( (string) get_post_field( 'post_content', get_the_ID() ) ) ) );
	if ( $wc > 0 ) $node['wordCount'] = (int) $wc;

	return dgc_sch_prune( $node );
}

/* ===========================================================================
 * 7. Rap @graph va xuat ra <head>
 * ========================================================================= */

function dgc_sch_graph() {
	$url   = dgc_sch_url_paged();
	$graph = array();

	$graph[] = dgc_sch_organization();
	$graph[] = dgc_sch_website();

	// --- WebPage ---
	$types = dgc_sch_page_type();
	$faqs  = dgc_sch_page_faqs();
	if ( $faqs ) $types[] = 'FAQPage';

	$page = array(
		'@type'      => count( $types ) === 1 ? $types[0] : $types,
		'@id'        => $url . '#webpage',
		'url'        => $url,
		'name'       => dgc_sch_txt( wp_get_document_title(), 160 ),
		'isPartOf'   => array( '@id' => dgc_sch_id( 'website' ) ),
		'inLanguage' => 'vi-VN',
	);

	if ( is_singular() ) {
		$page['datePublished'] = get_the_date( DATE_W3C );
		$page['dateModified']  = get_the_modified_date( DATE_W3C );
		$ex = dgc_sch_txt( get_the_excerpt(), 300 );
		if ( $ex ) $page['description'] = $ex;
	} elseif ( is_front_page() ) {
		$page['description'] = dgc_sch_txt( dgc( 'hero_sub' ) ?: get_bloginfo( 'description' ), 300 );
		$page['about']       = array( '@id' => dgc_sch_id( 'organization' ) );
	} elseif ( is_category() ) {
		$t = get_queried_object();
		if ( ! empty( $t->description ) ) $page['description'] = dgc_sch_txt( $t->description, 300 );
	}

	$img = dgc_sch_primary_image();
	if ( $img ) $page['primaryImageOfPage'] = $img;

	$bc = dgc_sch_breadcrumb();
	if ( $bc ) {
		$page['breadcrumb'] = array( '@id' => $bc['@id'] );
		$graph[]            = $bc;
	}

	// Thuc the chinh cua trang
	$main = array();

	if ( $faqs ) {
		foreach ( $faqs as $f ) {
			$main[] = array(
				'@type'          => 'Question',
				'name'           => dgc_sch_txt( $f[0] ),
				'acceptedAnswer' => array( '@type' => 'Answer', 'text' => dgc_sch_txt( $f[1] ) ),
			);
		}
	}

	$service = dgc_sch_service();
	if ( ! $service ) $service = dgc_sch_outlet_service(); // bai co bang gia 1 dau bao
	if ( $service ) {
		$graph[]       = $service;
		$page['about'] = array( '@id' => $service['@id'] );
		if ( ! $main ) $main[] = array( '@id' => $service['@id'] );
	}

	$article = dgc_sch_article();
	if ( $article ) {
		// Bai co bang gia rieng cua 1 dau bao -> tro 'about' ve dich vu CU THE tren chinh
		// trang nay, thay vi dich vu chung cua cum (chinh xac hon cho Google/AI).
		if ( $service && $service['@id'] === $url . '#service' ) {
			$article['about'] = array( '@id' => $service['@id'] );
		}
		$graph[] = $article;
		if ( ! $main ) $main[] = array( '@id' => $article['@id'] );
	}

	$list = dgc_sch_item_list();
	if ( $list ) {
		$graph[] = $list;
		if ( ! $main ) $main[] = array( '@id' => $list['@id'] );
	}

	// Trang tac gia: ProfilePage bat buoc co mainEntity la Person.
	if ( is_author() ) {
		$p = dgc_sch_person( get_queried_object_id() );
		if ( $p ) {
			$graph[] = $p;
			$main    = array( array( '@id' => $p['@id'] ) );
		}
	}

	// Trang Lien he / Ve DigicomVN noi ve chinh doanh nghiep -> tro thang ve node Organization.
	if ( ! $main && ( is_page( 'lien-he' ) || is_page( 've-digicom' ) ) ) {
		$main[]        = array( '@id' => dgc_sch_id( 'organization' ) );
		$page['about'] = array( '@id' => dgc_sch_id( 'organization' ) );
	}

	if ( $main ) $page['mainEntity'] = count( $main ) === 1 ? $main[0] : $main;

	array_splice( $graph, 2, 0, array( dgc_sch_prune( $page ) ) );

	// --- Cac Person can thiet (tac gia bai viet + nguoi sang lap) ---
	$people = array();
	if ( is_singular( array( 'post', 'dgc_case' ) ) ) {
		$a = (int) get_post_field( 'post_author', get_the_ID() );
		if ( $a && get_userdata( $a ) ) $people[] = $a;
	}
	$people[] = dgc_sch_founder_id();

	$have = array();
	foreach ( $graph as $n ) { if ( ! empty( $n['@id'] ) ) $have[] = $n['@id']; }

	foreach ( array_unique( array_filter( $people ) ) as $pid ) {
		if ( in_array( dgc_sch_id( 'person-' . $pid ), $have, true ) ) continue;
		$p = dgc_sch_person( $pid );
		if ( $p ) $graph[] = $p;
	}

	return array( '@context' => 'https://schema.org', '@graph' => array_values( $graph ) );
}

/* ===========================================================================
 * 8. WP Admin: sua FAQ cua tung bai (khong phai cham code - rule non-code-editable)
 * ========================================================================= */

add_action( 'add_meta_boxes', function () {
	foreach ( array( 'post', 'page', 'dgc_case' ) as $pt ) {
		add_meta_box( 'dgc_faqs_box', 'SEO & Schema', 'dgc_faqs_box_html', $pt, 'normal', 'default' );
	}
} );

function dgc_faqs_box_html( $post ) {
	wp_nonce_field( 'dgc_faqs_save', 'dgc_faqs_nonce' );
	// Tieu de SEO + mo ta SEO (inc/seo-meta.php cam vao day de chi co MOT o duy nhat).
	do_action( 'dgc_seo_box_fields', $post );
	echo '<p><strong>FAQ cho schema (Câu hỏi thường gặp)</strong></p>';
	$lines = array();
	foreach ( dgc_post_faq_items( $post->ID ) as $f ) {
		$lines[] = $f[0] . ' | ' . $f[1];
	}
	echo '<p class="description">Mỗi dòng một câu: <code>Câu hỏi | Câu trả lời</code>. Nội dung này được đưa vào schema FAQPage của trang.<br>
	<strong>Lưu ý:</strong> chỉ ghi câu hỏi/câu trả lời <strong>thực sự có hiển thị trong bài</strong> - Google yêu cầu dữ liệu có cấu trúc phải khớp nội dung người đọc nhìn thấy. Để trống = bài không có FAQPage.</p>';
	echo '<textarea name="dgc_faqs_raw" rows="8" style="width:100%" class="large-text code">' . esc_textarea( implode( "\n", $lines ) ) . '</textarea>';
}

add_action( 'save_post', function ( $post_id ) {
	if ( ! isset( $_POST['dgc_faqs_nonce'] ) || ! wp_verify_nonce( $_POST['dgc_faqs_nonce'], 'dgc_faqs_save' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	$raw  = isset( $_POST['dgc_faqs_raw'] ) ? (string) wp_unslash( $_POST['dgc_faqs_raw'] ) : '';
	$out  = array();
	foreach ( preg_split( '/\r\n|\r|\n/', $raw ) as $line ) {
		$line = trim( $line );
		if ( $line === '' ) continue;
		$parts = array_map( 'trim', explode( '|', $line, 2 ) );
		if ( count( $parts ) === 2 && $parts[0] !== '' && $parts[1] !== '' ) {
			$out[] = array( sanitize_text_field( $parts[0] ), sanitize_text_field( $parts[1] ) );
		}
	}
	if ( $out ) update_post_meta( $post_id, 'dgc_faqs', $out );
	else delete_post_meta( $post_id, 'dgc_faqs' );

	do_action( 'dgc_seo_box_save', $post_id );
} );

/** Xuat 1 khoi JSON-LD duy nhat trong <head>. */
function dgc_sch_output() {
	if ( is_404() || is_feed() || is_robots() ) return;
	// Trang cam on da noindex -> khong can do thi thuc the.
	if ( is_page( 'cam-on' ) ) return;

	$graph = dgc_sch_graph();
	if ( empty( $graph['@graph'] ) ) return;

	echo "\n<!-- DigicomVN schema -->\n";
	echo '<script type="application/ld+json">'
		. wp_json_encode( $graph, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES )
		. "</script>\n";
}
add_action( 'wp_head', 'dgc_sch_output', 5 );
