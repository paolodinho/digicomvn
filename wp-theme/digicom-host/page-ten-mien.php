<?php
/**
 * Template trang Ten mien (gan tu dong cho page slug "ten-mien").
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<div class="wrap"><nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a><span class="sep">/</span> Tên miền</nav></div>

<section class="page-hero">
	<div class="wrap" style="max-width:820px">
		<span class="eyebrow">Tên miền</span>
		<h1><?php echo esc_html( get_the_title() ?: 'Đăng ký tên miền giá tốt' ); ?></h1>
		<p class="lead">Kiểm tra và đăng ký tên miền .com, .vn và nhiều đuôi khác. Quản lý DNS dễ dùng, hỗ trợ chuyển về miễn phí.</p>
		<div class="search-card" style="margin-top:26px">
			<form class="search-box" onsubmit="window.open('https://www.pavietnam.vn/','_blank');return false;">
				<input type="text" placeholder="Nhập tên miền bạn muốn tìm..." aria-label="Tên miền">
				<button type="submit">Kiểm tra</button>
			</form>
			<p class="muted" style="font-size:12.5px;margin:10px 2px 0">Đăng ký qua đối tác PA Việt Nam - DigicomVN hỗ trợ tư vấn và kỹ thuật.</p>
		</div>
	</div>
</section>

<section class="sec">
	<div class="wrap">
		<div class="center" style="margin-bottom:30px"><span class="eyebrow">Bảng giá</span><h2>Giá tên miền phổ biến</h2></div>
		<table class="price-table">
			<thead><tr><th>Đuôi tên miền</th><th>Đăng ký mới (/năm)</th><th>Đăng ký</th></tr></thead>
			<tbody>
			<?php foreach ( dgc_lines( 'domain_tlds' ) as $d ) :
				$tld = $d[0] ?? ''; $price = $d[1] ?? ''; if ( $tld === '' ) continue; ?>
				<tr><td class="tld"><?php echo esc_html( $tld ); ?></td>
					<td class="p"><?php echo esc_html( $price ); ?></td>
					<td><a class="btn btn-ghost btn-sm" href="https://www.pavietnam.vn/" target="_blank" rel="noopener">Đăng ký</a></td></tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<p class="form-note" style="text-align:center;margin-top:14px">Giá đã bao gồm quản lý DNS. Liên hệ để biết giá gia hạn và các đuôi khác.</p>
	</div>
</section>

<section class="sec" style="background:var(--surface-2);border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:30px"><span class="eyebrow">Vì sao chọn DigicomVN</span><h2>Đăng ký tên miền an tâm</h2></div>
		<div class="feat-row">
			<div class="feat"><div class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M5 12h14M13 6l6 6-6 6"/></svg></div><h3>Chuyển về miễn phí</h3><p>Hỗ trợ chuyển tên miền từ nhà cung cấp khác, không gián đoạn.</p></div>
			<div class="feat"><div class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M12 8v4l3 2M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg></div><h3>Kích hoạt tức thì</h3><p>Tên miền sẵn sàng ngay sau khi thanh toán.</p></div>
			<div class="feat"><div class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M12 3l7 4v5c0 4-3 7-7 8-4-1-7-4-7-8V7z"/></svg></div><h3>Bảo mật DNS</h3><p>Quản lý bản ghi DNS trực quan, hỗ trợ khóa tên miền.</p></div>
			<div class="feat"><div class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div><h3>Hỗ trợ 24/7</h3><p>Đội ngũ kỹ thuật hỗ trợ qua hotline, Zalo, email.</p></div>
		</div>
	</div>
</section>

<?php if ( get_the_content() ) : ?>
<section class="sec"><div class="wrap page-content"><?php the_content(); ?></div></section>
<?php endif; ?>

<section class="sec" style="background:var(--surface)">
	<div class="wrap">
		<div class="center" style="margin-bottom:30px"><span class="eyebrow">Hỗ trợ</span><h2>Câu hỏi thường gặp</h2></div>
		<div class="faq">
			<?php foreach ( dgc_lines( 'faqs' ) as $f ) : ?>
				<details><summary><?php echo esc_html( $f[0] ?? '' ); ?></summary><div class="a"><?php echo esc_html( $f[1] ?? '' ); ?></div></details>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="sec-tight"><div class="wrap"><div class="cta-band">
	<div><h2>Cần tư vấn chọn tên miền?</h2><p>DigicomVN hỗ trợ chọn và đăng ký tên miền phù hợp thương hiệu của bạn.</p></div>
	<div class="cta-actions"><a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a><a class="btn btn-navy" href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">Liên hệ</a></div>
</div></div></section>

<?php get_footer(); ?>
