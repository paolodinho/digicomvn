<?php
/**
 * Block FAQ (hien thi) - doc option 'faqs' qua dgc_faq_items().
 * SCHEMA FAQPage KHONG con sinh o day: da gop vao khoi @graph duy nhat trong
 * inc/schema.php (dung chung nguon du lieu dgc_faq_items()) de tranh 2 khoi JSON-LD
 * roi rac tren cung 1 trang.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$dgc_faqs = dgc_faq_items();
if ( ! $dgc_faqs ) return;
?>
<section class="sec" id="faq">
	<div class="wrap">
		<div class="center" style="margin-bottom:34px">
			<span class="eyebrow">Hỗ trợ</span>
			<h2>Câu hỏi thường gặp</h2>
			<p class="muted" style="max-width:620px;margin:8px auto 0">Giải đáp về DigicomVN và bốn dịch vụ Textlink, Backlink, Guest Post, Booking báo &amp; PR. Chưa thấy câu trả lời bạn cần? Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?>.</p>
		</div>
		<div class="faq">
			<?php foreach ( $dgc_faqs as $f ) : ?>
				<details>
					<summary><?php echo esc_html( $f[0] ); ?></summary>
					<div class="a"><?php echo esc_html( $f[1] ); ?></div>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
