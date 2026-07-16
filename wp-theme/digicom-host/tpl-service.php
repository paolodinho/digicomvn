<?php
/**
 * Template Name: Dich vu (bao gia)
 * Dung cho: Lap trinh website, SEO/GEO, Backlink & PR, Google Ads, Automation.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
$svc_name = get_the_title();
$nhom     = dgc_current_nhom();
?>
<div class="wrap"><nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a><span class="sep">/</span> <?php echo esc_html( $svc_name ); ?></nav></div>

<section class="page-hero">
	<div class="wrap" style="max-width:840px">
		<span class="eyebrow">Dịch vụ</span>
		<h1><?php echo esc_html( $svc_name ); ?></h1>
		<?php if ( has_excerpt() ) : ?><p class="lead"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
		<?php /* Toi da 2 nut: 1 chinh + 1 phu (Hieu 2026-07-15 "nhieu loai nut qua").
		         Bo "Nhan bao gia" - trung muc dich voi bang gia (co san nut gui yeu cau) va voi nut Goi. */ ?>
		<div class="hero-actions">
			<?php if ( $nhom ) : ?>
				<a class="btn btn-primary" href="#bang-gia">Xem bảng giá</a>
				<a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a>
			<?php else : ?>
				<a class="btn btn-primary" href="#lien-he">Nhận báo giá</a>
				<a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php
/* Khoi dinh nghia dich vu ("... la gi") ngay duoi hero - bat intent thong tin + GEO.
   Chi render neu option svc_intros co dong khop slug hien tai (sua o WP Admin). */
include get_template_directory() . '/inc/svc-intro.php';

/* Khoi uu dai (promo-band) DA BO khoi trang dich vu (Hieu 2026-07-15).
   Bat guard som de footer.php cung KHONG render lai o cuoi trang. Trang chu van hien qua
   front-page.php; popup uu dai + nut Zalo van con. */
$GLOBALS['dgc_promo_done'] = true;

/* Bang gia len NGAY DUOI hero, tren moi noi dung khac (Hieu 2026-07-14). */
if ( $nhom ) {
	include get_template_directory() . '/inc/service-pricing.php';
	/* Ngay sau bang gia: 4 buoc dat hang + loi moi goi hotline/Zalo neu chua biet chon bao nao. */
	$dgc_og_ctx = $svc_name;
	include get_template_directory() . '/inc/order-guide.php';
}
?>

<?php if ( get_the_content() ) : ?>
<section class="sec"><div class="wrap page-content"><?php the_content(); ?></div></section>
<?php endif; ?>

<?php /* Trang co bang gia da co "Huong dan dat hang" 4 buoc -> khong lap quy trinh chung nua.
         Chi hien quy trinh chung cho trang dich vu KHONG co bang gia. */ ?>
<?php if ( ! $nhom ) : ?>
<section class="sec" style="background:var(--surface-2);border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:34px"><span class="eyebrow">Quy trình</span><h2>Cách DigicomVN triển khai</h2></div>
		<div class="proc">
			<div class="step"><h3>Khảo sát</h3><p>Tìm hiểu mục tiêu, hiện trạng và yêu cầu của bạn.</p></div>
			<div class="step"><h3>Đề xuất &amp; báo giá</h3><p>Lên phương án, phạm vi công việc và báo giá minh bạch.</p></div>
			<div class="step"><h3>Triển khai</h3><p>Thực hiện theo kế hoạch, cập nhật tiến độ thường xuyên.</p></div>
			<div class="step"><h3>Bàn giao &amp; bảo hành</h3><p>Nghiệm thu, hướng dẫn sử dụng và hỗ trợ sau bàn giao.</p></div>
		</div>
	</div>
</section>
<?php endif; ?>

<?php
/* KHONG cắm cac block dung chung trang chu (vi sao chon / dau bao / testimonials / FAQ) vao day
   nua (Hieu 2026-07-16): 8 trang dich vu lap y het nhau -> trung lap/boilerplate, loang do doc nhat.
   Trang dich vu chi giu noi dung RIENG: hero + "... la gi" + bang gia + noi dung bai + form.
   Cac block dung chung van song o trang chu (front-page.php). */
?>

<section class="sec">
	<div class="wrap">
		<div class="row" style="gap:30px;align-items:flex-start">
			<div class="col">
				<span class="eyebrow">Báo giá</span>
				<h2>Nhận tư vấn &amp; báo giá <?php echo esc_html( mb_strtolower( $svc_name ) ); ?></h2>
				<p class="muted">Mỗi dự án có nhu cầu khác nhau. Để lại thông tin, DigicomVN sẽ tư vấn giải pháp và gửi báo giá phù hợp.</p>
				<ul class="page-content" style="font-size:15.5px"><li>Tư vấn miễn phí, không ràng buộc.</li><li>Báo giá rõ ràng theo phạm vi công việc.</li><li>Đội ngũ chuyên môn, có cam kết tiến độ.</li></ul>
			</div>
			<div class="col"><?php
				$dgc_form_title   = 'Nhận báo giá';
				$dgc_form_btn     = 'Gửi yêu cầu báo giá';
				$dgc_form_service = $svc_name;
				include get_template_directory() . '/inc/form-lead.php';
			?></div>
		</div>
	</div>
</section>

<section class="sec-tight"><div class="wrap"><div class="cta-band">
	<div><h2>Bắt đầu cùng DigicomVN</h2><p>Liên hệ ngay để được tư vấn giải pháp phù hợp doanh nghiệp của bạn.</p></div>
	<div class="cta-actions"><a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a><a class="btn btn-navy" href="#lien-he">Nhận báo giá</a></div>
</div></div></section>

<?php get_footer(); ?>
