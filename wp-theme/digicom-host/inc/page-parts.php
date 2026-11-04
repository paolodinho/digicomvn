<?php
/**
 * Trang dich vu ha tang (tpl-web, ten-mien, hosting) co noi dung viet lai (02/11/2026).
 * post_content chia 2 phan bang marker <!-- dgc:bang-gia --> : phan truoc in TRUOC bang gia theme,
 * phan sau in SAU bang gia. Doan dan (hero lead) = excerpt; tieu de/doan dan/ghi chu bang gia = meta
 * dgc_price_h / dgc_price_intro / dgc_price_note (sua o WP Admin > Custom Fields). post_content rong
 * -> template giu nguyen bo cuc cu.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function dgc_pp() {
	static $c = array();
	$id = get_the_ID();
	if ( isset( $c[ $id ] ) ) return $c[ $id ];
	$raw = (string) get_post_field( 'post_content', $id );
	$p   = explode( '<!-- dgc:bang-gia -->', $raw, 2 );
	$m   = function ( $k ) use ( $id ) { return trim( (string) get_post_meta( $id, $k, true ) ); };
	return $c[ $id ] = array(
		'on'          => trim( $raw ) !== '',
		'before'      => count( $p ) > 1 ? $p[0] : '',
		'after'       => count( $p ) > 1 ? $p[1] : $raw,
		'lead'        => trim( (string) get_post_field( 'post_excerpt', $id ) ),
		'h1'          => $m( 'dgc_h1' ),
		'price_h'     => $m( 'dgc_price_h' ),
		'price_intro' => $m( 'dgc_price_intro' ),
		'price_note'  => $m( 'dgc_price_note' ),
	);
}

function dgc_pp_section( $html ) {
	if ( trim( $html ) === '' ) return;
	echo '<section class="sec"><div class="wrap page-content" style="max-width:960px">' . apply_filters( 'the_content', $html ) . '</div></section>';
}
