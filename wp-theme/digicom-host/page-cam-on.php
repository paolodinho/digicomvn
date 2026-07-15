<?php
/**
 * Trang cam on (slug "cam-on") - khach duoc chuyen toi day sau khi gui form lien he/bao gia
 * (xem dgc_handle_lead() trong functions.php). Noindex: day la trang ket qua, khong SEO.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

$dgc_ty_svc = isset( $_GET['dv'] ) ? sanitize_text_field( wp_unslash( $_GET['dv'] ) ) : '';
?>
<section class="page-hero">
	<div class="wrap" style="max-width:760px">
		<span class="eyebrow">Đã gửi thành công</span>
		<h1>Cảm ơn bạn đã liên hệ DigicomVN</h1>
		<p class="lead">Chúng tôi đã nhận được yêu cầu<?php echo $dgc_ty_svc ? ' về <b>' . esc_html( $dgc_ty_svc ) . '</b>' : ''; ?>. Chuyên viên sẽ liên hệ lại trong giờ làm việc (Thứ 2 - Thứ 6, 8:00 - 18:00). Ngoài giờ, yêu cầu được xử lý vào đầu buổi làm việc kế tiếp.</p>
		<p style="margin-top:20px">
			<a class="btn btn-primary" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi ngay <?php echo esc_html( dgc( 'hotline' ) ); ?></a>
			<?php if ( dgc( 'zalo' ) ) : ?><a class="btn btn-ghost" href="https://zalo.me/<?php echo esc_attr( preg_replace( '/[^0-9]/', '', dgc( 'zalo' ) ) ); ?>" target="_blank" rel="noopener">Nhắn Zalo</a><?php endif; ?>
		</p>
	</div>
</section>

<section class="sec">
	<div class="wrap">
		<div class="center" style="margin-bottom:22px">
			<span class="eyebrow">Tiếp theo</span>
			<h2>Ba bước kể từ lúc bạn gửi yêu cầu</h2>
		</div>
		<?php /* KHONG dat grid-template-columns inline: style inline de len ca media query
		         -> mobile van 3 cot, chu bi bop con 2 tu/dong (Hieu 2026-07-14). Dung class .proc-3. */ ?>
		<div class="proc proc-3">
			<div class="step"><h3>Xác nhận yêu cầu</h3><p>Chuyên viên gọi hoặc nhắn Zalo để nắm rõ ngành hàng, từ khoá và ngân sách của bạn.</p></div>
			<div class="step"><h3>Đề xuất danh sách báo / site</h3><p>Bạn nhận danh sách phù hợp kèm chỉ số DR, quy cách bài và giá từng đầu mục - miễn phí, không ràng buộc.</p></div>
			<div class="step"><h3>Triển khai và báo cáo</h3><p>Chốt đơn, DigicomVN đăng bài đúng tiến độ, gửi báo cáo link/bài đã lên khi hoàn thành.</p></div>
		</div>
	</div>
</section>

<section class="sec" style="background:var(--surface-2);border-top:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:18px">
			<span class="eyebrow">Trong lúc chờ</span>
			<h2>Xem thêm để chuẩn bị trước cuộc trao đổi</h2>
		</div>
		<div class="pillar-links">
			<div class="pillar-card">
				<h3>Bảng giá chi tiết theo từng báo</h3>
				<p class="muted">Lọc theo nhóm ngành, loại link dofollow/nofollow, số ảnh và độ dài bài - tự ước tính chi phí trước khi trao đổi.</p>
				<div class="pillar-actions"><a class="btn btn-primary btn-sm" href="<?php echo esc_url( home_url( '/bang-gia/' ) ); ?>">Xem bảng giá</a></div>
			</div>
			<div class="pillar-card">
				<h3>Kiến thức SEO off-page</h3>
				<p class="muted">Cách chọn báo theo ngành, đọc chỉ số DR/Traffic và phân biệt textlink, guest post, booking PR.</p>
				<div class="pillar-actions"><a class="btn btn-ghost btn-sm" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">Đọc blog</a></div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
