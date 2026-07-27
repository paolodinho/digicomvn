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

/* Schema FAQPage KHONG con sinh o day - da gop vao khoi @graph duy nhat (inc/schema.php),
   dung chung nguon du lieu dgc_svc_faq_items() nen noi dung luon khop voi phan hien thi. */
$dgc_sf = dgc_svc_faq_items( $dgc_sf_slug );
if ( ! $dgc_sf ) return;
?>
<section class="sec" id="faq" style="background:var(--surface-2);border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:34px">
			<span class="eyebrow">Hỗ trợ</span>
			<h2>Câu hỏi thường gặp</h2>
			<p class="muted" style="max-width:620px;margin:8px auto 0">Giải đáp nhanh trước khi bạn đặt dịch vụ. Chưa thấy câu trả lời cần tìm? Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?> để được tư vấn trực tiếp.</p>
			<div class="faq-quicklinks">
				<a href="/bang-gia/">Xem bảng giá đầy đủ</a>
				<a href="/case-study/">Dự án đã triển khai</a>
				<a href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a>
			</div>
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
