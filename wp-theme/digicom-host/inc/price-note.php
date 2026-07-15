<?php
/**
 * Ghi chu "gia tham khao" - dat CUOI bang gia, dang DONG CHU NHO, KHONG CTA
 * (Hieu 2026-07-15: bo thanh noi bat + nut Goi/Zalo o giua bang cho do dai dong;
 * popup uu dai + nut Zalo noi da du keu goi lien he). Noi dung sua o WP Admin
 * (option 'price_note'), khong sua PHP. Dung: include .../inc/price-note.php sau bang.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$dgc_pn = trim( (string) dgc( 'price_note' ) );
if ( '' === $dgc_pn ) return;
?>
<p class="price-foot-note"><?php echo esc_html( $dgc_pn ); ?></p>
