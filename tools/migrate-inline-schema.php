<?php
/**
 * Go JSON-LD nhung san trong post_content -> gom FAQ that vao post meta 'dgc_faqs'.
 *
 * Ly do: pipeline content cu chen thang <script type="application/ld+json"> vao than bai,
 * co bai lap 3 lan cung mot Article + FAQPage. Ket qua: nhieu thuc the Article khong @id,
 * mau thuan voi khoi @graph cua theme -> Google phai tu doan dau la thuc the chinh.
 *
 * Cach xu ly:
 * - Article/BlogPosting nhung trong bai: BO HAN (theme da sinh ban day du hon, co @id lien ket).
 * - FAQPage: giu lai NOI DUNG cau hoi, nhung chi giu cau nao THUC SU HIEN trong than bai
 *   (policy Google: du lieu co cau truc phai khop noi dung nguoi dung nhin thay). Cau khong
 *   hien -> bo, ghi vao bao cao.
 * - Ghi vao meta 'dgc_faqs' de inc/schema.php dua vao @graph.
 *
 * Chay:  wp eval-file migrate-inline-schema.php dry --allow-root
 *        wp eval-file migrate-inline-schema.php go  --allow-root
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$mode   = ( isset( $args[0] ) && $args[0] === 'go' ) ? 'go' : 'dry';
$stamp  = date( 'Y-m-d' );
$bakdir = getenv( 'HOME' ) . '/backups/' . $stamp . '/schema-inline';
if ( $mode === 'go' && ! is_dir( $bakdir ) ) mkdir( $bakdir, 0755, true );

global $wpdb;
$rows = $wpdb->get_results(
	"SELECT ID, post_title, post_content FROM {$wpdb->posts}
	 WHERE post_content LIKE '%application/ld+json%'
	   AND post_type IN ('post','page','dgc_case')
	   AND post_status NOT IN ('trash','auto-draft')"
);

echo "CHE DO: {$mode} | so bai co JSON-LD nhung: " . count( $rows ) . PHP_EOL;
echo str_repeat( '=', 78 ) . PHP_EOL;

$tot_script = 0; $tot_faq = 0; $tot_bo = 0; $tot_post = 0;

foreach ( $rows as $r ) {
	$c = $r->post_content;
	preg_match_all( '#<script type="application/ld\+json">(.*?)</script>#s', $c, $m );
	if ( ! $m[0] ) continue;

	$plain = wp_strip_all_tags( preg_replace( '#<script type="application/ld\+json">.*?</script>#s', '', $c ) );
	$plain = html_entity_decode( $plain, ENT_QUOTES, 'UTF-8' );

	$faqs = array(); $seen = array(); $bo = array(); $types = array();

	foreach ( $m[1] as $blk ) {
		$d = json_decode( trim( $blk ), true );
		if ( ! is_array( $d ) ) { $types[] = 'JSON-LOI'; continue; }
		$nodes = isset( $d['@graph'] ) ? $d['@graph'] : array( $d );
		foreach ( $nodes as $n ) {
			$t = $n['@type'] ?? '';
			$types[] = is_array( $t ) ? implode( '+', $t ) : $t;
			if ( $t !== 'FAQPage' || empty( $n['mainEntity'] ) ) continue;
			foreach ( $n['mainEntity'] as $q ) {
				$name = trim( (string) ( $q['name'] ?? '' ) );
				$ans  = trim( (string) ( $q['acceptedAnswer']['text'] ?? '' ) );
				if ( $name === '' || $ans === '' ) continue;
				$key = mb_strtolower( $name );
				if ( isset( $seen[ $key ] ) ) continue;
				$seen[ $key ] = 1;
				// Chi giu cau hoi HIEN THUC SU trong bai (khong tao du lieu an).
				if ( mb_strpos( $plain, $name ) === false ) { $bo[] = $name; continue; }
				$faqs[] = array( $name, $ans );
			}
		}
	}

	$new = preg_replace( '#<script type="application/ld\+json">.*?</script>#s', '', $c );
	$new = preg_replace( "#\n{3,}#", "\n\n", $new );
	$new = rtrim( $new ) . "\n";

	$tot_script += count( $m[0] );
	$tot_faq    += count( $faqs );
	$tot_bo     += count( $bo );
	$tot_post++;

	printf( "#%-6d %-52s script:%d faq-giu:%d faq-bo:%d [%s]%s",
		$r->ID, mb_substr( $r->post_title, 0, 52 ), count( $m[0] ), count( $faqs ), count( $bo ),
		implode( ',', array_unique( $types ) ), PHP_EOL );
	foreach ( $bo as $b ) echo "        BO (khong hien trong bai): " . mb_substr( $b, 0, 70 ) . PHP_EOL;

	if ( $mode === 'go' ) {
		file_put_contents( $bakdir . '/' . $r->ID . '.txt', $c );
		// Ghi thang vao CSDL: tranh bo loc kses cua wp_update_post lam bien dang HTML bai viet.
		$wpdb->update( $wpdb->posts, array( 'post_content' => $new ), array( 'ID' => $r->ID ) );
		clean_post_cache( $r->ID );
		if ( $faqs ) update_post_meta( $r->ID, 'dgc_faqs', $faqs );
		else delete_post_meta( $r->ID, 'dgc_faqs' );
	}
}

echo str_repeat( '=', 78 ) . PHP_EOL;
echo "TONG: {$tot_post} bai | {$tot_script} khoi script go bo | {$tot_faq} cau FAQ giu lai | {$tot_bo} cau bo (khong hien trong bai)" . PHP_EOL;
if ( $mode === 'go' ) echo "Backup noi dung goc: {$bakdir}" . PHP_EOL;
else echo "(dry-run - chua sua gi. Chay lai voi tham so 'go' de ghi that.)" . PHP_EOL;
