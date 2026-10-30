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
		<h1>Về DigicomVN</h1>
		<p class="lead">DigicomVN là thương hiệu dịch vụ của Công ty TNHH Dịch vụ Truyền thông Digito Combat, hoạt động từ tháng 11/2021 tại Hà Nội.</p>
	</div>
</section>

<section class="sec">
	<div class="wrap page-content">
		<?php if ( get_the_content() ) : the_content(); else : ?>
			<p>Dịch vụ chính là SEO website: audit, nghiên cứu từ khoá, sửa lỗi kỹ thuật, viết nội dung và xây liên kết. Đi kèm là booking bài PR trên báo điện tử, textlink, guest post, tên miền, hosting và các dịch vụ website.</p>
			<p>Giá booking báo, textlink và guest post được niêm yết theo từng đầu báo, từng site trên trang dịch vụ. Sau khi đăng, khách nhận danh sách link bài để tự kiểm tra.</p>
		<?php endif; ?>
	</div>
</section>

<section class="sec" style="background:var(--surface-2);border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<h2>Dịch vụ</h2>
		<ul class="ws-links">
			<?php foreach ( array( array( 'Dịch vụ SEO', '/dich-vu-seo/' ), array( 'Booking báo & PR', '/booking-bao-pr/' ), array( 'Mua Textlink', '/mua-textlink/' ), array( 'Guest Post', '/guest-post/' ), array( 'Dịch vụ Backlink', '/dich-vu-backlink/' ), array( 'Tên miền', '/ten-mien/' ), array( 'Hosting', '/hosting/' ), array( 'Thiết kế website', '/thiet-ke-website/' ) ) as $sl ) : if ( function_exists( 'dgc_page_live' ) && ! dgc_page_live( $sl[1] ) ) continue; ?>
			<li><a href="<?php echo esc_url( home_url( $sl[1] ) ); ?>"><?php echo esc_html( $sl[0] ); ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="sec-tight">
	<div class="wrap" style="max-width:1000px">
		<img
			src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/team-about-1200.jpg' ); ?>"
			alt="Đội ngũ DigicomVN tại văn phòng"
			width="1200" height="800"
			style="width:100%;height:auto;border-radius:var(--r-lg);box-shadow:var(--sh-high);display:block"
			loading="lazy"
		>
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
					Hotline: <a href="tel:<?php echo esc_attr( dgc_tel() ); ?>" style="color:var(--action);font-weight:600"><?php echo esc_html( dgc( 'hotline' ) ); ?></a><?php if ( dgc( 'hotline2' ) ) : ?> · <a href="tel:<?php echo esc_attr( dgc_tel2() ); ?>" style="color:var(--action);font-weight:600"><?php echo esc_html( dgc( 'hotline2' ) ); ?></a><?php endif; ?><br>
					Email: <?php echo esc_html( dgc( 'email' ) ); ?><br>
					<?php if ( dgc( 'address2' ) ) : ?>Văn phòng giao dịch: <?php echo esc_html( dgc( 'address2' ) ); ?><br><?php endif; ?>
					Giờ làm việc: <?php echo esc_html( dgc( 'working_hours' ) ); ?>
				</p>
			</div>
		</div>
	</div>
</section>

<section class="sec-tight"><div class="wrap"><div class="cta-band">
	<div><h2>Liên hệ DigicomVN</h2><p>Gọi hotline hoặc gửi yêu cầu, chúng tôi trả lời trong giờ làm việc.</p></div>
	<div class="cta-actions"><a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a><a class="btn btn-navy" href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">Liên hệ</a></div>
</div></div></section>

<?php get_footer(); ?>
