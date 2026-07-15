<?php
/**
 * Ghi chu "gia tham khao" - BAT BUOC hien o MOI noi co gia (Hieu 2026-07-15).
 * Gia bao/kenh thay doi theo dot, nha dai/toa soan co the chot lai vao phut chot
 * -> phai noi ro cho khach, kem loi goi hanh dong Zalo/hotline de chot gia nhanh.
 *
 * Noi dung sua o WP Admin (option 'price_note'), khong sua PHP.
 * Dung: include get_template_directory() . '/inc/price-note.php';
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$dgc_pn      = trim( (string) dgc( 'price_note' ) );
if ( '' === $dgc_pn ) return;
$dgc_pn_tel  = dgc_tel();
$dgc_pn_zalo = preg_replace( '/[^0-9]/', '', dgc( 'zalo' ) );
?>
<div class="price-note">
	<span class="price-note-ico" aria-hidden="true">
		<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 8h.01M11 12h1v4h1"/></svg>
	</span>
	<p><?php echo esc_html( $dgc_pn ); ?></p>
	<span class="price-note-cta">
		<a class="btn btn-primary btn-sm" href="tel:<?php echo esc_attr( $dgc_pn_tel ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a>
		<?php if ( $dgc_pn_zalo ) : ?>
		<a class="btn btn-zalo btn-sm" href="https://zalo.me/<?php echo esc_attr( $dgc_pn_zalo ); ?>" target="_blank" rel="noopener">Nhắn Zalo</a>
		<?php endif; ?>
	</span>
</div>
