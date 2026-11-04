<?php
/* wp eval-file apply_nhom4.php <payload.json> <backup.json> [dry] - ghi nhom 4, backup content/excerpt/meta + svc_faqs truoc. */
$in = $args[0]; $bk = $args[1]; $dry = ! empty( $args[2] );
$items = json_decode( file_get_contents( $in ), true );
if ( ! $items ) { echo "payload loi\n"; return; }
$metas = array( 'dgc_h1', 'dgc_seo_title', 'dgc_seo_desc', 'dgc_price_h', 'dgc_price_intro', 'dgc_price_note' );
$set = get_option( 'dgc_settings' );
$back = array( 'svc_faqs' => $set['svc_faqs'] ?? '', 'pages' => array() );
foreach ( $items as $it ) {
	$p = get_post( $it['id'] );
	if ( ! $p || $p->post_name !== $it['slug'] ) { echo "SAI ID {$it['slug']}\n"; return; }
	$b = array( 'post_content' => $p->post_content, 'post_excerpt' => $p->post_excerpt );
	foreach ( $metas as $m ) $b[ $m ] = get_post_meta( $p->ID, $m, true );
	$back['pages'][ $it['id'] ] = $b;
}
file_put_contents( $bk, wp_json_encode( $back, JSON_UNESCAPED_UNICODE ) );
chmod( $bk, 0600 );
echo "backup: $bk (" . filesize( $bk ) . " bytes)\n";
if ( $dry ) return;
kses_remove_filters();
$lines = preg_split( "/\r?\n/", (string) ( $set['svc_faqs'] ?? '' ) );
foreach ( $items as $it ) {
	$r = wp_update_post( wp_slash( array( 'ID' => $it['id'], 'post_content' => $it['content'], 'post_excerpt' => $it['excerpt'] ) ), true );
	if ( is_wp_error( $r ) ) { echo "LOI {$it['slug']}: " . $r->get_error_message() . "\n"; continue; }
	$map = array( 'h1' => 'dgc_h1', 'seo_title' => 'dgc_seo_title', 'seo_desc' => 'dgc_seo_desc',
		'price_h' => 'dgc_price_h', 'price_intro' => 'dgc_price_intro', 'price_note' => 'dgc_price_note' );
	foreach ( $map as $k => $m ) {
		if ( (string) $it[ $k ] !== '' ) update_post_meta( $it['id'], $m, $it[ $k ] );
		elseif ( in_array( $m, array( 'dgc_price_h', 'dgc_price_intro', 'dgc_price_note' ), true ) ) delete_post_meta( $it['id'], $m );
	}
	if ( $it['faqs'] ) {
		$lines = array_values( array_filter( $lines, function ( $l ) use ( $it ) { return trim( explode( '|', $l )[0] ) !== $it['faqkey']; } ) );
		foreach ( $it['faqs'] as $f ) $lines[] = $it['faqkey'] . ' | ' . $f[0] . ' | ' . $f[1];
	}
	echo "OK {$it['slug']} ({$it['id']})\n";
}
$set['svc_faqs'] = implode( "\n", array_filter( $lines, 'strlen' ) );
update_option( 'dgc_settings', $set );
echo "svc_faqs dong: " . count( array_filter( $lines, 'strlen' ) ) . "\n";
