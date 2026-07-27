<?php
/**
 * Meta SEO + Open Graph + Twitter Card + canonical cho trang luu tru.
 *
 * Boi canh: site KHONG dung Rank Math/Yoast. Truoc file nay, toan site khong co
 * <meta name="description">, khong co og:/twitter: tag nao, va trang luu tru
 * (blog / chuyen muc / phan trang) khong co canonical -> share Facebook/Zalo ra
 * the trang tron, Google tu bia doan mo ta.
 *
 * Nguon du lieu (khong bia): meta rieng cua bai -> excerpt -> noi dung bai ->
 * option WP Admin. Anh: anh dai dien -> anh dau tien trong bai -> anh mac dinh
 * (WP Admin) -> logo.
 *
 * Sua duoc o WP Admin: o "SEO & Schema" duoi trinh soan thao (tieu de + mo ta rieng
 * tung bai) va DigicomVN > muc "SEO & chia se" (anh mac dinh + mo ta trang chu).
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ===========================================================================
 * 1. Helper
 * ========================================================================= */

/** Cat mo ta ve do dai an toan cho SERP, cat theo ranh gioi TU (khong cat giua tu). */
function dgc_seo_trim( $s, $max = 158 ) {
	$s = dgc_sch_txt( $s );
	if ( $s === '' || mb_strlen( $s ) <= $max ) return $s;
	$cut = mb_substr( $s, 0, $max );
	$sp  = mb_strrpos( $cut, ' ' );
	if ( $sp && $sp > $max * 0.6 ) $cut = mb_substr( $cut, 0, $sp );
	return rtrim( $cut, " ,.;:-" ) . '...';
}

/** Mo ta SEO cua request hien tai. Tra '' neu that su khong co gi de mo ta. */
function dgc_seo_description() {
	// Trang chu la mot PAGE tinh -> is_singular() cung dung. Phai xet is_front_page() TRUOC,
	// neu khong se roi vao nhanh bai viet, doc noi dung page 215 (rong) va tra ve chuoi rong.
	if ( is_front_page() ) {
		return dgc_seo_trim( dgc( 'meta_desc_home' ) ?: dgc( 'hero_sub' ) ?: get_bloginfo( 'description' ) );
	}
	if ( is_singular() ) {
		$id = get_the_ID();
		$own = trim( (string) get_post_meta( $id, 'dgc_seo_desc', true ) );
		if ( $own !== '' ) return dgc_seo_trim( $own );

		$ex = has_excerpt( $id ) ? get_the_excerpt( $id ) : '';
		if ( trim( (string) $ex ) === '' ) {
			$ex = get_post_field( 'post_content', $id );
			$ex = strip_shortcodes( (string) $ex );
			// Bo cac khoi ky thuat (so do HTML, bang) de khong lay nham chuoi so lam mo ta.
			$ex = preg_replace( '#<(style|script|table)[^>]*>.*?</\1>#is', ' ', $ex );
		}
		return dgc_seo_trim( $ex );
	}
	if ( is_category() || is_tax() ) {
		$t = get_queried_object();
		return dgc_seo_trim( $t && ! empty( $t->description ) ? $t->description : '' );
	}
	if ( is_home() ) {
		$pid = (int) get_option( 'page_for_posts' );
		return dgc_seo_trim( $pid ? ( get_post_meta( $pid, 'dgc_seo_desc', true ) ?: get_the_excerpt( $pid ) ) : '' );
	}
	if ( is_author() ) {
		$uid = get_queried_object_id();
		return dgc_seo_trim( get_user_meta( $uid, 'dgc_bio_long', true ) ?: get_the_author_meta( 'description', $uid ) );
	}
	if ( is_post_type_archive( 'dgc_case' ) ) {
		return dgc_seo_trim( 'Các dự án booking báo, PR và off-page SEO DigicomVN đã triển khai cho khách hàng thật.' );
	}
	return '';
}

/** Anh dai dien khi chia se (og:image). Tra array(url, w, h, alt) hoac null. */
function dgc_seo_image() {
	$id = 0;

	if ( is_singular() && has_post_thumbnail() ) {
		$id = (int) get_post_thumbnail_id();
	}
	if ( ! $id && is_singular() ) {
		// Anh dau tien trong than bai (nhieu bai khong dat anh dai dien).
		$html = (string) get_post_field( 'post_content', get_the_ID() );
		if ( preg_match( '/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $m ) ) {
			// URL anh trong bai thuong la ban resize (vd -1024x671.jpg) - attachment_url_to_postid()
			// khong nhan dang duoc -> bo hau to kich thuoc de tra ve dung anh goc (co width/height).
			$maybe = attachment_url_to_postid( preg_replace( '/-\d+x\d+(\.[a-z]{3,4})$/i', '$1', $m[1] ) );
			if ( ! $maybe ) $maybe = attachment_url_to_postid( $m[1] );
			if ( $maybe ) $id = (int) $maybe;
			else return array( esc_url_raw( $m[1] ), 0, 0, dgc_sch_txt( get_the_title() ) );
		}
	}
	if ( ! $id ) {
		// Option 'og_image' nhan CA ID anh lan URL day du (Hieu nhap kieu nao cung chay).
		$og = trim( (string) dgc( 'og_image' ) );
		if ( $og !== '' && ! ctype_digit( $og ) ) {
			return array( esc_url_raw( $og ), 0, 0, dgc_sch_txt( get_bloginfo( 'name' ) ) );
		}
		$id = (int) $og;
	}
	if ( ! $id ) $id = (int) ( get_theme_mod( 'custom_logo' ) ?: get_option( 'site_logo' ) );
	if ( ! $id ) return null;

	$src = wp_get_attachment_image_src( $id, 'full' );
	if ( ! $src ) return null;
	$alt = get_post_meta( $id, '_wp_attachment_image_alt', true );
	return array( $src[0], (int) $src[1], (int) $src[2], dgc_sch_txt( $alt ?: get_bloginfo( 'name' ) ) );
}

/** Tieu de dung cho og:title / twitter:title (bo duoi " - DigicomVN" cho gon). */
function dgc_seo_og_title() {
	$t = dgc_sch_txt( wp_get_document_title() );
	$suffix = ' - ' . get_bloginfo( 'name' );
	if ( substr( $t, -strlen( $suffix ) ) === $suffix ) {
		$t = substr( $t, 0, -strlen( $suffix ) );
	}
	return $t !== '' ? $t : get_bloginfo( 'name' );
}

/* ===========================================================================
 * 2. Xuat the meta trong <head>
 * ========================================================================= */

add_action( 'wp_head', 'dgc_seo_head', 2 );
function dgc_seo_head() {
	if ( is_feed() || is_robots() ) return;

	$out = array();

	// --- robots: trang ket qua tim kiem + phan trang tra ve khong co gia tri tim kiem ---
	if ( is_search() || is_404() ) {
		$out[] = '<meta name="robots" content="noindex,follow">';
	}

	// --- canonical cho trang luu tru (WP core chi tu sinh cho trang don) ---
	if ( ! is_singular() && ! is_404() && ! is_search() && function_exists( 'dgc_sch_url_paged' ) ) {
		$out[] = '<link rel="canonical" href="' . esc_url( dgc_sch_url_paged() ) . '">';
	}

	if ( is_404() || is_search() ) {
		echo "\n" . implode( "\n", $out ) . "\n";
		return;
	}

	$url  = function_exists( 'dgc_sch_url_paged' ) ? dgc_sch_url_paged() : home_url( '/' );
	$desc = dgc_seo_description();
	$tit  = dgc_seo_og_title();
	$img  = dgc_seo_image();

	if ( $desc ) $out[] = '<meta name="description" content="' . esc_attr( $desc ) . '">';

	// --- Open Graph ---
	$og_type = is_singular( array( 'post', 'dgc_case' ) ) ? 'article' : ( is_front_page() ? 'website' : 'website' );
	$out[] = '<meta property="og:locale" content="vi_VN">';
	$out[] = '<meta property="og:type" content="' . esc_attr( $og_type ) . '">';
	$out[] = '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">';
	$out[] = '<meta property="og:title" content="' . esc_attr( $tit ) . '">';
	$out[] = '<meta property="og:url" content="' . esc_url( $url ) . '">';
	if ( $desc ) $out[] = '<meta property="og:description" content="' . esc_attr( $desc ) . '">';
	if ( $img ) {
		$out[] = '<meta property="og:image" content="' . esc_url( $img[0] ) . '">';
		if ( $img[1] ) $out[] = '<meta property="og:image:width" content="' . (int) $img[1] . '">';
		if ( $img[2] ) $out[] = '<meta property="og:image:height" content="' . (int) $img[2] . '">';
		if ( $img[3] ) $out[] = '<meta property="og:image:alt" content="' . esc_attr( $img[3] ) . '">';
	}

	if ( 'article' === $og_type ) {
		$out[] = '<meta property="article:published_time" content="' . esc_attr( get_the_date( DATE_W3C ) ) . '">';
		$out[] = '<meta property="article:modified_time" content="' . esc_attr( get_the_modified_date( DATE_W3C ) ) . '">';
		$cats = get_the_category();
		if ( $cats ) $out[] = '<meta property="article:section" content="' . esc_attr( dgc_sch_txt( $cats[0]->name ) ) . '">';
	}

	// --- Twitter Card ---
	$out[] = '<meta name="twitter:card" content="' . ( $img ? 'summary_large_image' : 'summary' ) . '">';
	$out[] = '<meta name="twitter:title" content="' . esc_attr( $tit ) . '">';
	if ( $desc ) $out[] = '<meta name="twitter:description" content="' . esc_attr( $desc ) . '">';
	if ( $img )  $out[] = '<meta name="twitter:image" content="' . esc_url( $img[0] ) . '">';

	echo "\n" . implode( "\n", $out ) . "\n";
}

/* ===========================================================================
 * 3. Tieu de <title> rieng tung bai - sua o WP Admin thay vi hardcode trong code
 * ========================================================================= */

add_filter( 'document_title_parts', function ( $parts ) {
	if ( ! is_singular() ) return $parts;
	$own = trim( (string) get_post_meta( get_queried_object_id(), 'dgc_seo_title', true ) );
	if ( $own !== '' ) $parts['title'] = $own;
	return $parts;
}, 6 );

/* ===========================================================================
 * 4. O nhap trong WP Admin (gop chung voi o FAQ cua schema)
 * ========================================================================= */

add_action( 'dgc_seo_box_fields', function ( $post ) {
	$t = (string) get_post_meta( $post->ID, 'dgc_seo_title', true );
	$d = (string) get_post_meta( $post->ID, 'dgc_seo_desc', true );
	echo '<p><label for="dgc_seo_title"><strong>Tiêu đề SEO</strong> (thẻ &lt;title&gt; trên Google - để trống = dùng tiêu đề bài)</label><br>';
	echo '<input type="text" id="dgc_seo_title" name="dgc_seo_title" value="' . esc_attr( $t ) . '" class="large-text" maxlength="120"></p>';
	echo '<p><label for="dgc_seo_desc"><strong>Mô tả SEO</strong> (đoạn mô tả dưới tiêu đề trên Google + khi share Facebook/Zalo - để trống = tự lấy từ đầu bài, nên ~150 ký tự)</label><br>';
	echo '<textarea id="dgc_seo_desc" name="dgc_seo_desc" rows="3" class="large-text">' . esc_textarea( $d ) . '</textarea></p>';
	echo '<hr>';
} );

add_action( 'dgc_seo_box_save', function ( $post_id ) {
	foreach ( array( 'dgc_seo_title', 'dgc_seo_desc' ) as $k ) {
		$v = isset( $_POST[ $k ] ) ? sanitize_text_field( wp_unslash( $_POST[ $k ] ) ) : '';
		if ( $v !== '' ) update_post_meta( $post_id, $k, $v );
		else delete_post_meta( $post_id, $k );
	}
} );
