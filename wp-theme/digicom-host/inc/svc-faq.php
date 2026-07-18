<?php
/**
 * Block FAQ RIENG tung trang dich vu - hien duoi noi dung bai, tren form bao gia.
 * Doc option 'svc_faqs'. Moi dong: slug | Cau hoi | Cau tra loi.
 * 1 slug co the co NHIEU dong (nhieu cau hoi). Slug khop $nhom['slug'] hien tai.
 * KHONG phai block dung chung: chi render cau hoi rieng cua dich vu do (Hieu 2026-07-16
 * bo block boilerplate lap y het nhau) -> moi trang mot bo FAQ khac nhau.
 * Sinh schema FAQPage giup Google/AI trich dan dung cau tra loi (GEO).
 * Sua noi dung tu WP Admin > DigicomVN > muc 2, KHONG cham PHP.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$dgc_sf_nhom = isset( $nhom ) && $nhom ? $nhom : dgc_current_nhom();
if ( ! $dgc_sf_nhom ) return;
$dgc_sf_slug = $dgc_sf_nhom['slug'];

$dgc_sf = array();
foreach ( dgc_lines( 'svc_faqs' ) as $row ) {
	if ( isset( $row[0] ) && trim( $row[0] ) === $dgc_sf_slug && ! empty( $row[1] ) && ! empty( $row[2] ) ) {
		$dgc_sf[] = array( trim( $row[1] ), trim( $row[2] ) );
	}
}
if ( ! $dgc_sf ) return;
?>
<section class="sec" id="faq" style="background:var(--surface-2);border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:34px">
			<span class="eyebrow">Hỗ trợ</span>
			<h2>Câu hỏi thường gặp</h2>
			<p class="muted" style="max-width:620px;margin:8px auto 0">Giải đáp nhanh trước khi bạn đặt dịch vụ. Chưa thấy câu trả lời cần tìm? Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?> để được tư vấn trực tiếp.</p>
		</div>
		<div class="faq">
			<?php foreach ( $dgc_sf as $f ) : ?>
				<details>
					<summary><?php echo esc_html( $f[0] ); ?></summary>
					<div class="a"><?php echo esc_html( $f[1] ); ?></div>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php
$dgc_sf_ld = array(
	'@context'   => 'https://schema.org',
	'@type'      => 'FAQPage',
	'mainEntity' => array_values( array_map(
		fn( $f ) => array(
			'@type'          => 'Question',
			'name'           => wp_strip_all_tags( $f[0] ),
			'acceptedAnswer' => array( '@type' => 'Answer', 'text' => wp_strip_all_tags( $f[1] ) ),
		),
		$dgc_sf
	) ),
);
?>
<script type="application/ld+json"><?php echo wp_json_encode( $dgc_sf_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ); ?></script>
