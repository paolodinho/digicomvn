<?php
/**
 * Template trang "Cau hoi thuong gap" tong hop (page slug "cau-hoi-thuong-gap").
 * Noi dung gom tu inc/faq-page.php (dgc_faq_page_groups()) - sua o WP Admin > DigicomVN
 * muc 5 (FAQ chung + FAQ bo sung) va muc 2 (FAQ rieng tung dich vu), khong cham file nay.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

$dgc_faq_groups = dgc_faq_page_groups();
$dgc_faq_total  = dgc_faq_page_count();
?>
<div class="wrap"><nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a><span class="sep">/</span> Câu hỏi thường gặp</nav></div>

<section class="page-hero">
	<div class="wrap" style="max-width:820px">
		<span class="eyebrow">Hỗ trợ</span>
		<h1><?php echo esc_html( get_the_title() ?: 'Câu hỏi thường gặp' ); ?></h1>
		<p class="lead">
			<?php if ( $dgc_faq_total > 0 ) : ?>
				Tổng hợp <?php echo (int) $dgc_faq_total; ?> câu hỏi về Mua Textlink, Dịch vụ Backlink, Guest Post, Booking báo &amp; PR và các dịch vụ off-page SEO&nbsp;khác của&nbsp;DigicomVN.
			<?php else : ?>
				Giải đáp thắc mắc về dịch vụ Textlink, Backlink, Guest Post, Booking báo &amp; PR của&nbsp;DigicomVN.
			<?php endif; ?>
			Chưa thấy câu trả lời cần tìm? Gọi <a href="tel:<?php echo esc_attr( dgc_tel() ); ?>" style="color:#fff;text-decoration:underline"><?php echo esc_html( dgc( 'hotline' ) ); ?></a>.
		</p>
	</div>
</section>

<?php if ( $dgc_faq_groups ) : ?>

<section class="sec" style="padding-bottom:0">
	<div class="wrap">
		<div class="tab-bar" role="navigation" aria-label="Chuyển nhanh tới nhóm câu hỏi">
			<?php foreach ( $dgc_faq_groups as $g ) : ?>
				<a class="tab-btn" href="#faq-<?php echo esc_attr( $g['anchor'] ); ?>"><?php echo esc_html( $g['title'] ); ?></a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php foreach ( $dgc_faq_groups as $gi => $g ) : ?>
<section class="sec" id="faq-<?php echo esc_attr( $g['anchor'] ); ?>" style="<?php echo ( $gi % 2 === 1 ) ? 'background:var(--surface-2)' : ''; ?>">
	<div class="wrap">
		<div class="center" style="margin-bottom:28px">
			<h2><?php echo esc_html( $g['title'] ); ?></h2>
			<?php if ( ! empty( $g['url'] ) ) : ?>
				<p class="muted" style="margin-top:6px">Xem đầy đủ tại trang <a href="<?php echo esc_url( home_url( $g['url'] ) ); ?>"><?php echo esc_html( $g['title'] ); ?></a>.</p>
			<?php endif; ?>
		</div>
		<div class="faq">
			<?php foreach ( $g['items'] as $f ) : ?>
				<details>
					<summary><?php echo esc_html( $f[0] ); ?></summary>
					<div class="a"><?php echo esc_html( $f[1] ); ?></div>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endforeach; ?>

<?php else : ?>
<section class="sec"><div class="wrap center"><p class="muted">Nội dung câu hỏi thường gặp đang được cập nhật. Điền tại WP Admin &gt; DigicomVN &gt; mục 5 (FAQ chung/bổ sung) và mục 2 (FAQ theo dịch vụ).</p></div></section>
<?php endif; ?>

<section class="sec" style="background:var(--surface-2);border-top:1px solid var(--line)">
	<div class="wrap center">
		<h2>Vẫn còn thắc mắc?</h2>
		<p class="muted" style="max-width:560px;margin:8px auto 20px">Gọi hotline, nhắn Zalo hoặc gửi yêu cầu để đội ngũ DigicomVN tư vấn chọn dịch vụ và báo giá phù&nbsp;hợp.</p>
		<div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
			<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/dat-bai/' ) ); ?>">Gửi yêu cầu tư vấn</a>
			<a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a>
			<a class="btn btn-ghost" href="<?php echo esc_url( home_url( '/bang-gia/' ) ); ?>">Xem bảng giá</a>
		</div>
	</div>
</section>

<?php if ( get_the_content() ) : ?>
<section class="sec"><div class="wrap page-content"><?php the_content(); ?></div></section>
<?php endif; ?>

<?php get_footer(); ?>
