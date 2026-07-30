<?php
/**
 * Trang tong hop "Cau hoi thuong gap" (/cau-hoi-thuong-gap/).
 * Gom 3 nguon da co san (khong tao du lieu moi rieng biet, tranh trung lap):
 *   1. dgc_faq_items()        - option 'faqs'          (dang hien o trang chu)
 *   2. dgc_lines('faq_page_extra') - cau hoi CHI hien o trang nay
 *   3. dgc_svc_faq_items($slug)    - option 'svc_faqs' theo tung dich vu dang publish
 * Dung 1 nguon du lieu duy nhat cho ca hien thi (page-cau-hoi-thuong-gap.php) lan schema
 * (dgc_sch_page_faqs() trong inc/schema.php) de khong bao gio lech nhau.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Danh sach nhom FAQ cho trang tong hop. Moi nhom: 'title', 'anchor', 'url' (rong = khong link),
 * 'items' => array cua [cau hoi, tra loi]. Nhom rong (khong co cau hoi nao) tu dong bi loai.
 */
function dgc_faq_page_groups() {
	$groups = array();

	$chung = array_merge( dgc_faq_items(), dgc_lines( 'faq_page_extra' ) );
	// dgc_lines() tra ve mang [cau hoi, tra loi] tu 'faq_page_extra' (chua loc rong).
	$chung = array_values( array_filter( $chung, function ( $f ) {
		return isset( $f[0], $f[1] ) && $f[0] !== '' && $f[1] !== '';
	} ) );
	if ( $chung ) {
		$groups[] = array( 'title' => 'Câu hỏi chung', 'anchor' => 'chung', 'url' => '', 'items' => $chung );
	}

	if ( function_exists( 'dgc_service_links' ) ) {
		foreach ( dgc_service_links() as $sl ) {
			$slug  = trim( $sl[1], '/' );
			$items = dgc_svc_faq_items( $slug );
			if ( ! $items ) continue;
			$groups[] = array(
				'title'  => $sl[0],
				'anchor' => $slug,
				'url'    => $sl[1],
				'items'  => $items,
			);
		}
	}

	return $groups;
}

/** Danh sach [cau hoi, tra loi] phang, dedup theo cau hoi - dung cho schema FAQPage. */
function dgc_faq_page_flat() {
	$out  = array();
	$seen = array();
	foreach ( dgc_faq_page_groups() as $g ) {
		foreach ( $g['items'] as $f ) {
			$key = mb_strtolower( trim( $f[0] ), 'UTF-8' );
			if ( isset( $seen[ $key ] ) ) continue;
			$seen[ $key ] = true;
			$out[] = $f;
		}
	}
	return $out;
}

/** Tong so cau hoi tren toan trang - dung cho intro/hero. */
function dgc_faq_page_count() {
	return count( dgc_faq_page_flat() );
}
