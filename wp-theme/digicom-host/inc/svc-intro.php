<?php
/**
 * Block dinh nghia dich vu ("... la gi") - hien ngay duoi hero trang dich vu.
 * Bat intent thong tin ("booking bao chi la gi") + giup Google/AI trich dan (GEO).
 * Doc option 'svc_intros'. Moi dong: slug | Tieu de | Doan dinh nghia (2-4 cau).
 * Slug khop $nhom['slug'] hien tai; khong khop -> khong render gi.
 * Sua noi dung tu WP Admin > DigicomVN > muc 2, KHONG cham PHP.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$dgc_si_nhom = isset( $nhom ) && $nhom ? $nhom : dgc_current_nhom();
if ( ! $dgc_si_nhom ) return;
$dgc_si_slug = $dgc_si_nhom['slug'];

$dgc_si = null;
foreach ( dgc_lines( 'svc_intros' ) as $row ) {
	if ( isset( $row[0] ) && trim( $row[0] ) === $dgc_si_slug && ! empty( $row[2] ) ) {
		$dgc_si = $row;
		break;
	}
}
if ( ! $dgc_si ) return;

$dgc_si_head = trim( $dgc_si[1] ?? '' );
$dgc_si_body = trim( $dgc_si[2] );
?>
<section class="sec-tight svc-intro-sec">
	<div class="wrap">
		<div class="svc-intro">
			<span class="eyebrow">Khái niệm</span>
			<?php if ( $dgc_si_head ) : ?><h2><?php echo esc_html( $dgc_si_head ); ?></h2><?php endif; ?>
			<p><?php echo esc_html( $dgc_si_body ); ?></p>
		</div>
	</div>
</section>
