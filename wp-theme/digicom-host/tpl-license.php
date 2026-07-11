<?php
/**
 * Template Name: Ban quyen phan mem
 * Dung cho: Google Workspace, Office 365, Windows 11, phan mem ban quyen khac.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
$name = get_the_title();
?>
<div class="wrap"><nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a><span class="sep">/</span> Bản quyền phần mềm <span class="sep">/</span> <?php echo esc_html( $name ); ?></nav></div>

<section class="page-hero">
	<div class="wrap" style="max-width:840px">
		<span class="eyebrow">Bản quyền phần mềm</span>
		<h1><?php echo esc_html( $name ); ?></h1>
		<?php if ( has_excerpt() ) : ?><p class="lead"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
		<div style="margin-top:22px"><a class="btn btn-primary" href="#lien-he">Mua bản quyền</a> <a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Tư vấn</a></div>
	</div>
</section>

<?php if ( get_the_content() ) : ?>
<section class="sec"><div class="wrap page-content"><?php the_content(); ?></div></section>
<?php endif; ?>

<section class="sec" style="background:#fff;border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:30px"><span class="eyebrow">Cam kết</span><h2>Vì sao mua bản quyền tại DigicomVN</h2></div>
		<div class="feat-row">
			<div class="feat"><div class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M12 3l7 4v5c0 4-3 7-7 8-4-1-7-4-7-8V7z"/></svg></div><h3>Bản quyền chính hãng</h3><p>Key/license hợp lệ, kích hoạt trực tiếp từ nhà cung cấp.</p></div>
			<div class="feat"><div class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M12 8v4l3 2M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg></div><h3>Kích hoạt nhanh</h3><p>Bàn giao và hỗ trợ kích hoạt ngay sau khi thanh toán.</p></div>
			<div class="feat"><div class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M4 4h16v12H4zM2 20h20"/></svg></div><h3>Xuất hóa đơn VAT</h3><p>Hỗ trợ xuất hóa đơn cho doanh nghiệp, hợp đồng đầy đủ.</p></div>
			<div class="feat"><div class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div><h3>Hỗ trợ kỹ thuật</h3><p>Hướng dẫn cài đặt, gia hạn và xử lý sự cố license.</p></div>
		</div>
	</div>
</section>

<section class="sec">
	<div class="wrap">
		<div class="row" style="gap:30px;align-items:flex-start">
			<div class="col">
				<span class="eyebrow">Báo giá</span>
				<h2>Nhận báo giá <?php echo esc_html( $name ); ?></h2>
				<p class="muted">Giá tùy theo số lượng người dùng và kỳ hạn. Liên hệ để nhận báo giá tốt nhất cho doanh nghiệp.</p>
			</div>
			<div class="col"><?php
				$dgc_form_title   = 'Nhận báo giá / Mua bản quyền';
				$dgc_form_btn     = 'Gửi yêu cầu';
				$dgc_form_service = 'Bản quyền phần mềm';
				include get_template_directory() . '/inc/form-lead.php';
			?></div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
