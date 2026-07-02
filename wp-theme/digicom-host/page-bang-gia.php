<?php
/**
 * Template trang Bang gia tong hop (slug "bang-gia").
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<div class="wrap"><nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a><span class="sep">/</span> Bảng giá</nav></div>

<section class="page-hero">
	<div class="wrap" style="max-width:820px">
		<span class="eyebrow">Bảng giá</span>
		<h1>Bảng giá dịch vụ Digicom</h1>
		<p class="lead">Giá tham khảo, chưa gồm VAT. Liên hệ để nhận ưu đãi theo kỳ hạn và số lượng.</p>
	</div>
</section>

<!-- Ten mien -->
<section class="sec">
	<div class="wrap">
		<div class="center" style="margin-bottom:26px"><span class="eyebrow">Tên miền</span><h2>Giá tên miền</h2></div>
		<table class="price-table">
			<thead><tr><th>Đuôi</th><th>Đăng ký (/năm)</th><th></th></tr></thead>
			<tbody><?php foreach ( dgc_lines( 'domain_tlds' ) as $d ) { if ( empty( $d[0] ) ) continue;
				echo '<tr><td class="tld">' . esc_html( $d[0] ) . '</td><td class="p">' . esc_html( $d[1] ?? '' ) . '</td><td><a class="btn btn-ghost btn-sm" href="' . esc_url( home_url( '/ten-mien/' ) ) . '">Đăng ký</a></td></tr>';
			} ?></tbody>
		</table>
	</div>
</section>

<!-- Hosting -->
<section class="sec" style="background:#fff;border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:26px"><span class="eyebrow">Hosting</span><h2>Giá Web Hosting</h2></div>
		<table class="price-table">
			<thead><tr><th>Gói</th><th>Giá</th><th>Cấu hình</th><th></th></tr></thead>
			<tbody><?php foreach ( dgc_lines( 'hosting_plans' ) as $h ) { if ( empty( $h[0] ) ) continue;
				$feats = implode( ', ', array_slice( array_filter( array_map( 'trim', explode( ';', $h[2] ?? '' ) ) ), 0, 3 ) );
				echo '<tr><td class="tld">' . esc_html( $h[0] ) . '</td><td class="p">' . esc_html( $h[1] ?? '' ) . '</td><td>' . esc_html( $feats ) . '</td><td><a class="btn btn-ghost btn-sm" href="' . esc_url( home_url( '/hosting/' ) ) . '">Chọn</a></td></tr>';
			} ?></tbody>
		</table>
	</div>
</section>

<!-- Ban quyen + Dich vu -->
<section class="sec">
	<div class="wrap">
		<div class="row" style="gap:24px">
			<div class="col card">
				<h3 style="margin-top:0">Bản quyền phần mềm</h3>
				<p class="muted" style="font-size:14.5px">Google Workspace từ 83.000đ/người/tháng. Office 365, Windows 11 và phần mềm khác báo giá theo nhu cầu.</p>
				<a class="btn btn-navy btn-sm" href="<?php echo esc_url( home_url( '/google-workspace/' ) ); ?>">Xem chi tiết</a>
			</div>
			<div class="col card">
				<h3 style="margin-top:0">Dịch vụ (báo giá theo dự án)</h3>
				<p class="muted" style="font-size:14.5px">Lập trình website, SEO/GEO, Backlink &amp; PR, Google Ads, Automation - báo giá theo phạm vi công việc.</p>
				<a class="btn btn-navy btn-sm" href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">Nhận báo giá</a>
			</div>
		</div>
	</div>
</section>

<?php if ( get_the_content() ) : ?>
<section class="sec" style="background:var(--surface)"><div class="wrap page-content"><?php the_content(); ?></div></section>
<?php endif; ?>

<section class="sec-tight"><div class="wrap"><div class="cta-band">
	<div><h2>Cần báo giá chi tiết?</h2><p>Liên hệ Digicom để được tư vấn gói phù hợp và ưu đãi tốt nhất.</p></div>
	<div class="cta-actions"><a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a><a class="btn btn-navy" href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">Liên hệ</a></div>
</div></div></section>

<?php get_footer(); ?>
