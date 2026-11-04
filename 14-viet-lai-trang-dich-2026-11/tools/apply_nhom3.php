<?php
/* Dang nhom 3 (trang chu + /ve-digicom/) 02/11/2026. wp eval-file apply_nhom3.php <nhom3.json> [dry] */
$a = $args; $j = json_decode( file_get_contents( $a[0] ), true ); $dry = ! empty( $a[1] );
$h = $j['home']; $p = $j['page'];
$s = get_option( 'dgc_settings' );
foreach ( array( 'hero_title', 'hero_sub', 'home_about_text', 'meta_desc_home', 'address', 'working_hours' ) as $k ) $s[ $k ] = $h[ $k ];
// FAQ chung: thay cau trung, them cau moi len dau
$match = array( 'là đơn vị nào' => 0, 'hiệu quả SEO' => 3, 'gắn link về website' => 4, 'VAT' => 5 );
$lines = preg_split( '/\r?\n/', (string) $s['faqs'] ); $out = array(); $used = array();
foreach ( $lines as $l ) {
	$q = trim( explode( '|', $l )[0] ); $rep = null;
	foreach ( $match as $k => $i ) if ( ! isset( $used[ $i ] ) && mb_stripos( $q, $k ) !== false ) { $rep = $i; break; }
	if ( null !== $rep ) { $used[ $rep ] = 1; $out[] = $h['faqs'][ $rep ][0] . ' | ' . $h['faqs'][ $rep ][1]; } else $out[] = $l;
}
array_splice( $out, 1, 0, array( $h['faqs'][1][0] . ' | ' . $h['faqs'][1][1], $h['faqs'][2][0] . ' | ' . $h['faqs'][2][1] ) );
$s['faqs'] = implode( "\n", $out );
$s['home_faq_keys'] = "là đơn vị nào\nDịch vụ SEO là gì\nChi phí dịch vụ SEO\nhiệu quả SEO\ngắn link về website\nhoá đơn VAT";
echo "faqs lines: " . count( $lines ) . " -> " . count( $out ) . ", replaced " . count( $used ) . "\n";
if ( $dry ) { echo substr( $s['faqs'], 0, 900 ); return; }
update_option( 'dgc_settings', $s );
update_post_meta( 215, 'dgc_seo_title', $h['seo_title_215'] );
kses_remove_filters();
$r = wp_update_post( array( 'ID' => 482, 'post_content' => $p['content'], 'post_excerpt' => $p['excerpt'] ), true );
update_post_meta( 482, 'dgc_seo_title', $p['seo_title'] );
update_post_meta( 482, 'dgc_seo_desc', $p['seo_desc'] );
echo is_wp_error( $r ) ? 'ERR ' . $r->get_error_message() : "OK 482\n";
