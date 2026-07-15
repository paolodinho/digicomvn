<?php
/**
 * Huong dan dat hang chi tiet - dung CHUNG cho trang /bang-gia/ va tung trang dich vu
 * (tpl-service.php). Dat NGAY DUOI bang gia: khach vua xem gia xong biet lam gi tiep.
 * Kem loi moi goi hotline / nhan Zalo khi khach chua biet chon bao nao (Hieu 2026-07-14).
 *
 * Bien tuy chon truoc khi include:
 *   $dgc_og_ctx - ten dich vu de goi ten dung ngu canh (VD "Guest Post"). De trong = chung.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$dgc_og_ctx  = isset( $dgc_og_ctx ) && $dgc_og_ctx ? mb_strtolower( $dgc_og_ctx ) : '';
$dgc_og_zalo = preg_replace( '/[^0-9]/', '', dgc( 'zalo' ) );
$dgc_og_steps = array(
	array(
		'title' => 'Chọn mục cần đặt',
		'desc'  => 'Tick chọn báo, site hoặc gói ngay trong bảng giá phía trên. Có thể chọn nhiều mục cùng lúc - tổng chi phí tạm tính hiện ngay ở thanh dưới màn hình, đặt càng nhiều mục giá càng tốt.',
	),
	array(
		'title' => 'Gửi yêu cầu đặt bài',
		'desc'  => 'Bấm "Đặt ngay" để sang trang đặt bài. Điền link trang cần đẩy, từ khoá (anchor text) muốn gắn và cho biết bạn đã có sẵn nội dung hay cần DigicomVN viết bài.',
	),
	array(
		'title' => 'Nhận báo giá &amp; xác nhận',
		'desc'  => 'DigicomVN kiểm tra yêu cầu, xác nhận báo/site còn nhận bài và gửi lại báo giá chính thức. Xuất hoá đơn VAT đầy đủ nếu doanh nghiệp bạn cần.',
	),
	array(
		'title' => 'Đăng bài &amp; bàn giao',
		'desc'  => 'Bài được biên tập theo yêu cầu của từng toà soạn rồi tiến hành đăng. Bàn giao đường link bài đã lên, bạn kiểm tra lại link và vị trí đặt trước khi kết thúc đơn.',
	),
);
?>
<section class="sec" id="huong-dan-dat" style="background:var(--surface-2);border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:26px">
			<span class="eyebrow">Hướng dẫn đặt hàng</span>
			<h2>Đặt <?php echo esc_html( $dgc_og_ctx ?: 'dịch vụ' ); ?> tại DigicomVN thế nào?</h2>
			<p class="muted" style="font-size:14.5px">Bốn bước, không cần hợp đồng dài dòng. Bạn theo dõi được tiến độ ở từng bước.</p>
		</div>

		<ol class="order-steps">
			<?php foreach ( $dgc_og_steps as $i => $s ) : ?>
			<li class="order-step">
				<span class="order-step-num"><?php echo (int) ( $i + 1 ); ?></span>
				<div>
					<h3><?php echo $s['title']; // phpcs:ignore - chuoi tinh, co entity &amp; ?></h3>
					<p><?php echo $s['desc']; // phpcs:ignore ?></p>
				</div>
			</li>
			<?php endforeach; ?>
		</ol>

		<div class="order-help">
			<div class="order-help-txt">
				<h3>Chưa biết nên chọn báo hay gói nào?</h3>
				<p>Mỗi ngành, mỗi mục tiêu (đẩy top từ khoá, xây thương hiệu, xử lý truyền thông) cần bộ báo và bộ site khác nhau. Gọi hotline hoặc nhắn Zalo, DigicomVN tư vấn miễn phí danh sách phù hợp với ngân sách của bạn.</p>
			</div>
			<div class="order-help-actions">
				<a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a>
				<a class="btn btn-zalo" href="https://zalo.me/<?php echo esc_attr( $dgc_og_zalo ); ?>" target="_blank" rel="noopener">Nhắn Zalo</a>
			</div>
		</div>
	</div>
</section>
