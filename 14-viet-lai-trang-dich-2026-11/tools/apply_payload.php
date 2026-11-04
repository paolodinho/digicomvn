<?php
/* wp eval-file apply_payload.php <payload.json> <backup.json> [dry] - ghi noi dung nhap len trang, backup truoc. */
$in = $args[0]; $bk = $args[1]; $dry = ! empty( $args[2] );
$items = json_decode( file_get_contents( $in ), true );
if ( ! $items ) { echo "payload loi\n"; return; }
$set = get_option( 'dgc_settings' );
$back = array( 'svc_faqs' => $set['svc_faqs'] ?? '', 'pages' => array() );
foreach ( $items as $it ) {
	$p = get_post( $it['id'] );
	if ( ! $p || $p->post_name !== basename( str_replace( '_', '/', $it['slug'] ) ) ) { echo "SAI ID {$it['slug']}\n"; return; }
	$back['pages'][ $it['id'] ] = array( 'post_content' => $p->post_content, 'post_excerpt' => $p->post_excerpt,
		'dgc_h1' => get_post_meta( $p->ID, 'dgc_h1', true ), 'dgc_seo_title' => get_post_meta( $p->ID, 'dgc_seo_title', true ),
		'dgc_seo_desc' => get_post_meta( $p->ID, 'dgc_seo_desc', true ) );
}
file_put_contents( $bk, wp_json_encode( $back, JSON_UNESCAPED_UNICODE ) );
echo "backup: $bk (" . filesize( $bk ) . " bytes)\n";
if ( $dry ) return;
kses_remove_filters();
$lines = preg_split( "/\r?\n/", (string) ( $set['svc_faqs'] ?? '' ) );
foreach ( $items as $it ) {
	$u = array( 'ID' => $it['id'], 'post_content' => $it['content'] );
	if ( ! empty( $it['excerpt'] ) ) $u['post_excerpt'] = $it['excerpt'];
	$r = wp_update_post( wp_slash( $u ), true );
	if ( is_wp_error( $r ) ) { echo "LOI {$it['slug']}: " . $r->get_error_message() . "\n"; continue; }
	foreach ( array( 'h1' => 'dgc_h1', 'seo_title' => 'dgc_seo_title', 'seo_desc' => 'dgc_seo_desc' ) as $k => $m ) {
		if ( ! empty( $it[ $k ] ) ) update_post_meta( $it['id'], $m, $it[ $k ] );
	}
	if ( $it['faqkey'] && $it['faqs'] ) {
		$lines = array_values( array_filter( $lines, function ( $l ) use ( $it ) { return trim( explode( '|', $l )[0] ) !== $it['faqkey']; } ) );
		foreach ( $it['faqs'] as $f ) $lines[] = $it['faqkey'] . ' | ' . $f[0] . ' | ' . $f[1];
	}
	echo "OK {$it['slug']} ({$it['id']})\n";
}
$set['svc_faqs'] = implode( "\n", array_filter( $lines, 'strlen' ) );
update_option( 'dgc_settings', $set );
echo "svc_faqs dong: " . count( array_filter( $lines, 'strlen' ) ) . "\n";
