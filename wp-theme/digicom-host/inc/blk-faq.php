<?php
/**
 * Block FAQ + schema FAQPage - dung chung trang chu + trang dich vu.
 * Doc option 'faqs'. Schema giup Google/AI trich dan dung cau tra loi.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$dgc_faqs = array_filter( dgc_lines( 'faqs' ), fn( $f ) => ! empty( $f[0] ) && ! empty( $f[1] ) );
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
<?php
$dgc_faq_ld = array(
	'@context'   => 'https://schema.org',
	'@type'      => 'FAQPage',
	'mainEntity' => array_values( array_map(
		fn( $f ) => array(
			'@type'          => 'Question',
			'name'           => wp_strip_all_tags( $f[0] ),
			'acceptedAnswer' => array( '@type' => 'Answer', 'text' => wp_strip_all_tags( $f[1] ) ),
		),
		$dgc_faqs
	) ),
);
?>
<script type="application/ld+json"><?php echo wp_json_encode( $dgc_faq_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ); ?></script>
