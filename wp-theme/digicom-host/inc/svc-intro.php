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

/* So lieu that (khong bia): dem so dong gia + so dau bao/trang phan biet dang publish trong
   CPT dgc_gia cho dung nhom nay. Dung chung ham dgc_get_gia() voi service-pricing.php de khong
   lech so lieu giua 2 noi. Chi render khi co du lieu (Hieu 2026-07-27: lap "tin hieu tin cay"
   con thieu tren cac trang dich vu dung chung template). */
$dgc_si_items  = function_exists( 'dgc_get_gia' ) ? dgc_get_gia( $dgc_si_slug ) : array();
$dgc_si_count  = count( $dgc_si_items );
$dgc_si_names  = array();
foreach ( $dgc_si_items as $dgc_si_it ) {
	$dgc_si_names[ trim( $dgc_si_it->post_title ) ] = 1;
}
$dgc_si_unit_count = count( $dgc_si_names );
$dgc_si_unit_label = dgc_nhom_don_vi( $dgc_si_slug );
?>
<section class="sec-tight svc-intro-sec">
	<div class="wrap">
		<div class="svc-intro">
			<span class="eyebrow">Khái niệm</span>
			<?php if ( $dgc_si_head ) : ?><h2><?php echo esc_html( $dgc_si_head ); ?></h2><?php endif; ?>
			<p><?php echo esc_html( $dgc_si_body ); ?></p>
			<?php if ( $dgc_si_count > 0 ) : ?>
			<div class="svc-facts">
				<span class="chip"><b><?php echo esc_html( $dgc_si_unit_count ); ?>+</b> <?php echo esc_html( $dgc_si_unit_label ); ?> đã hợp tác</span>
				<span class="chip"><b><?php echo esc_html( $dgc_si_count ); ?></b> vị trí giá công khai, không giấu giá</span>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>
