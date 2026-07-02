<?php
/**
 * Template trang Ve Digicom (slug "ve-digicom").
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<div class="wrap"><nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a><span class="sep">/</span> Về Digicom</nav></div>

<section class="page-hero">
	<div class="wrap" style="max-width:820px">
		<span class="eyebrow">Về chúng tôi</span>
		<h1>Digicom - đối tác số của doanh nghiệp</h1>
		<p class="lead">Cung cấp hạ tầng website, bản quyền phần mềm, marketing và tự động hóa - đồng hành cùng doanh nghiệp trên hành trình chuyển đổi số.</p>
	</div>
</section>

<section class="sec">
	<div class="wrap page-content">
		<?php if ( get_the_content() ) : the_content(); else : ?>
			<p>Digicom là thương hiệu dịch vụ số trực thuộc Công ty TNHH Dịch vụ Truyền thông Digito Combat. Chúng tôi giúp doanh nghiệp và cá nhân xây dựng hiện diện trực tuyến trọn gói: từ tên miền, hosting, website đến phần mềm bản quyền và các giải pháp marketing.</p>
			<p>Với đội ngũ kỹ thuật và marketing nhiều kinh nghiệm, Digicom hướng tới sự minh bạch về giá, tốc độ triển khai nhanh và hỗ trợ tận tâm sau bàn giao.</p>
		<?php endif; ?>
	</div>
</section>

<section class="sec" style="background:#fff;border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:30px"><span class="eyebrow">Lĩnh vực</span><h2>Chúng tôi làm gì</h2></div>
		<div class="feat-row">
			<div class="feat"><h3>Hạ tầng &amp; Website</h3><p>Lập trình website, tên miền, hosting tốc độ cao.</p></div>
			<div class="feat"><h3>Bản quyền phần mềm</h3><p>Google Workspace, Office 365, Windows 11 và phần mềm khác.</p></div>
			<div class="feat"><h3>Marketing &amp; SEO</h3><p>SEO/GEO, backlink &amp; bài PR, Google Ads.</p></div>
			<div class="feat"><h3>Tự động hóa</h3><p>Xây dựng quy trình tự động cho doanh nghiệp.</p></div>
		</div>
	</div>
</section>

<section class="sec">
	<div class="wrap">
		<div class="row" style="gap:24px;align-items:stretch">
			<div class="col card">
				<h3 style="margin-top:0">Thông tin pháp nhân</h3>
				<p class="muted" style="font-size:14.5px;line-height:1.8">
					Công ty TNHH Dịch vụ Truyền thông Digito Combat<br>
					Mã số thuế: 0109816406<br>
					Địa chỉ: <?php echo esc_html( dgc( 'address' ) ); ?>
				</p>
			</div>
			<div class="col card">
				<h3 style="margin-top:0">Liên hệ</h3>
				<p class="muted" style="font-size:14.5px;line-height:1.8">
					Hotline: <a href="tel:<?php echo esc_attr( dgc_tel() ); ?>" style="color:var(--action);font-weight:600"><?php echo esc_html( dgc( 'hotline' ) ); ?></a><br>
					Email: <?php echo esc_html( dgc( 'email' ) ); ?><br>
					Giờ làm việc: <?php echo esc_html( dgc( 'working_hours' ) ); ?>
				</p>
			</div>
		</div>
		<p class="form-note" style="margin-top:14px">Ảnh đội ngũ và văn phòng sẽ được bổ sung (cần ảnh thật từ Digicom).</p>
	</div>
</section>

<section class="sec-tight"><div class="wrap"><div class="cta-band">
	<div><h2>Hợp tác cùng Digicom</h2><p>Liên hệ để được tư vấn giải pháp số phù hợp doanh nghiệp của bạn.</p></div>
	<div class="cta-actions"><a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a><a class="btn btn-navy" href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">Liên hệ</a></div>
</div></div></section>

<?php get_footer(); ?>
