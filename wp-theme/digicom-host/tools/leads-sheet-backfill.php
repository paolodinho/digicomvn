<?php
/**
 * Ke het khach dang ky (CPT dgc_lead) tu truoc toi nay vao Google Sheet, theo dung
 * thu tu thoi gian (cu -> moi). Chay 1 LAN sau khi bat leads-sheet-sync.
 *
 * Cach chay (SSH, tren host, trong thu muc public_html):
 *   wp eval-file wp-content/themes/digicom-host/tools/leads-sheet-backfill.php --allow-root
 */
if ( ! function_exists( 'dgc_leads_sheet_enabled' ) || ! dgc_leads_sheet_enabled() ) {
	echo "Chua bat leads-sheet-sync (thieu Sheet ID / toggle / key) - dung lai.\n";
	return;
}

dgc_leads_sheet_ensure_header();

$posts = get_posts( array(
	'post_type'      => 'dgc_lead',
	'post_status'    => 'any',
	'posts_per_page' => -1,
	'orderby'        => 'date',
	'order'          => 'ASC',
) );

echo count( $posts ) . " ban ghi tim thay.\n";

$ok = 0; $fail = 0;
foreach ( $posts as $p ) {
	$body = $p->post_content;
	preg_match( '/^Ho ten:\s*(.*)$/m', $body, $m1 );
	preg_match( '/^Dien thoai:\s*(.*)$/m', $body, $m2 );
	preg_match( '/^Email:\s*(.*)$/m', $body, $m3 );
	preg_match( '/^Dich vu:\s*(.*)$/m', $body, $m4 );
	preg_match( '/Noi dung:\n([\s\S]*)$/', $body, $m5 );

	$row = array(
		get_the_date( 'Y-m-d H:i:s', $p ),
		trim( $m1[1] ?? '' ),
		trim( $m2[1] ?? '' ),
		trim( $m3[1] ?? '' ),
		trim( $m4[1] ?? '' ),
		trim( $m5[1] ?? '' ),
	);

	if ( dgc_leads_sheet_append( $row ) ) {
		$ok++;
	} else {
		$fail++;
		echo "LOI post {$p->ID}: {$p->post_title}\n";
	}
	usleep( 300000 ); // ~3 request/giay, tranh dinh rate-limit Google Sheets API
}

echo "Xong: {$ok} thanh cong, {$fail} loi.\n";
