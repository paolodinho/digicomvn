<?php
/**
 * Template trang Ve DigicomVN (slug "ve-digicom").
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<div class="wrap"><nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a><span class="sep">/</span> Về DigicomVN</nav></div>

<section class="page-hero">
	<div class="wrap" style="max-width:820px">
		<span class="eyebrow">Về chúng tôi</span>
		<h1>DigicomVN - đối tác off-page SEO của doanh nghiệp</h1>
		<p class="lead">Chuyên Textlink, Backlink, Guest Post và Booking báo &amp; PR - đồng hành cùng doanh nghiệp xây dựng hệ thống liên kết chất lượng và hiện diện trên báo chí.</p>
	</div>
</section>

<section class="sec">
	<div class="wrap page-content">
		<?php if ( get_the_content() ) : the_content(); else : ?>
			<p>DigicomVN là thương hiệu dịch vụ số trực thuộc Công ty TNHH Dịch vụ Truyền thông Digito Combat. Chúng tôi tập trung 4 dịch vụ off-page SEO: mua Textlink, dịch vụ Backlink, Guest Post và Booking đăng bài PR trên báo điện tử.</p>
			<p>DigicomVN chọn lọc site và đầu báo theo chỉ số thật, hướng tới sự minh bạch về giá, quy trình rõ ràng và bàn giao kèm báo cáo sau khi hoàn thành.</p>
		<?php endif; ?>
	</div>
</section>

<section class="sec" style="background:#fff;border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:30px"><span class="eyebrow">Lĩnh vực</span><h2>Chúng tôi làm gì</h2></div>
		<div class="feat-row">
			<div class="feat"><h3>Mua Textlink</h3><p>Chèn link vào bài viết có sẵn, chọn site theo DR/traffic.</p></div>
			<div class="feat"><h3>Dịch vụ Backlink</h3><p>Hệ thống backlink chất lượng, tự nhiên, đa nguồn.</p></div>
			<div class="feat"><h3>Guest Post</h3><p>Viết bài và đăng trên site đúng chủ đề, link dofollow.</p></div>
			<div class="feat"><h3>Booking báo &amp; PR</h3><p>Đặt lịch đăng bài PR trên báo điện tử theo yêu cầu.</p></div>
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
		<p class="form-note" style="margin-top:14px">Ảnh đội ngũ và văn phòng sẽ được bổ sung (cần ảnh thật từ DigicomVN).</p>
	</div>
</section>

<section class="sec-tight"><div class="wrap"><div class="cta-band">
	<div><h2>Hợp tác cùng DigicomVN</h2><p>Liên hệ để được tư vấn giải pháp số phù hợp doanh nghiệp của bạn.</p></div>
	<div class="cta-actions"><a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a><a class="btn btn-navy" href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">Liên hệ</a></div>
</div></div></section>

<?php get_footer(); ?>
