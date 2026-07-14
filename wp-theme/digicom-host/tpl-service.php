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
<div class="wrap"><nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a><span class="sep">/</span> Dịch vụ <span class="sep">/</span> <?php echo esc_html( $svc_name ); ?></nav></div>

<section class="page-hero">
	<div class="wrap" style="max-width:840px">
		<span class="eyebrow">Dịch vụ</span>
		<h1><?php echo esc_html( $svc_name ); ?></h1>
		<?php if ( has_excerpt() ) : ?><p class="lead"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
		<div style="margin-top:22px">
			<?php if ( $nhom ) : ?><a class="btn btn-primary" href="#bang-gia">Xem bảng giá</a> <?php endif; ?>
			<a class="btn <?php echo $nhom ? 'btn-ghost' : 'btn-primary'; ?>" href="#lien-he">Nhận báo giá</a>
			<a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a>
		</div>
	</div>
</section>

<?php if ( get_the_content() ) : ?>
<section class="sec"><div class="wrap page-content"><?php the_content(); ?></div></section>
<?php endif; ?>

<?php
/* Bang gia chi tiet ngay tren trang dich vu (moi dich vu deu co - Hieu 2026-07-14). */
if ( $nhom ) {
	include get_template_directory() . '/inc/service-pricing.php';
}
?>

<?php /* Social Entity co quy trinh rieng 7 buoc trong noi dung trang -> khong lap quy trinh chung. */ ?>
<?php if ( ! $nhom || 'backlink-social-entity' !== $nhom['slug'] ) : ?>
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
