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
/* Truyen hinh + phat thanh ($dgc_media set o tpl-service.php): khong co anchor/link, ban giao lich phat. */
$dgc_og_help = 'Mỗi ngành, mỗi mục tiêu (đẩy top từ khoá, xây thương hiệu, xử lý truyền thông) cần bộ báo và bộ site khác nhau. Gọi hotline hoặc nhắn Zalo, DigicomVN tư vấn miễn phí danh sách phù hợp với ngân sách của bạn.';
$dgc_og_help_h = 'Chưa biết nên chọn báo hay gói nào?';
if ( ! empty( $dgc_media ) ) {
	$dgc_og_steps[0]['desc'] = 'Tick chọn kênh và khung giờ ngay trong bảng giá phía trên. Có thể chọn nhiều khung cùng lúc, tổng chi phí tạm tính hiện ngay ở thanh dưới màn hình.';
	$dgc_og_steps[1]['title'] = 'Gửi yêu cầu đặt sóng';
	$dgc_og_steps[1]['desc'] = 'Bấm "Đặt ngay" và cho biết thời gian muốn phát, số lần phát, sản phẩm cần quảng bá và bạn đã có sẵn TVC, spot thu âm hay cần DigicomVN sản xuất.';
	$dgc_og_steps[2]['desc'] = 'DigicomVN kiểm tra lịch trống của nhà đài, hồ sơ pháp lý của sản phẩm và gửi báo giá chính thức kèm lịch phát dự kiến. Xuất hoá đơn VAT đầy đủ.';
	$dgc_og_steps[3]['title'] = 'Phát sóng &amp; bàn giao';
	$dgc_og_steps[3]['desc'] = 'Nội dung được nhà đài duyệt rồi phát theo lịch đã chốt. Bàn giao lịch phát sóng và file đối chiếu để bạn kiểm tra trước khi kết thúc đơn.';
	$dgc_og_help_h = 'Chưa biết nên chọn kênh hay khung giờ nào?';
	$dgc_og_help = 'Mỗi sản phẩm, mỗi tệp khách hàng hợp với một kênh và khung giờ khác nhau. Gọi hotline hoặc nhắn Zalo, DigicomVN tư vấn miễn phí phương án phù hợp với ngân sách của bạn.';
}
?>
<section class="sg-sec" id="huong-dan-dat">
	<div class="wrap">
		<div class="sg-head">
			<span class="sg-eyebrow">Hướng dẫn đặt hàng</span>
			<h2 class="sg-h">Đặt <?php echo esc_html( $dgc_og_ctx ?: 'dịch vụ' ); ?> tại DigicomVN thế&nbsp;nào?</h2>
			<p class="sg-lead">Bốn bước, không cần hợp đồng dài dòng. Bạn theo dõi được tiến độ ở từng bước.</p>
		</div>

		<ol class="sg-steps sg-steps--4 sg-steps--order">
			<?php foreach ( $dgc_og_steps as $i => $s ) : ?>
			<li>
				<span class="sg-stepno" aria-hidden="true"><?php echo (int) ( $i + 1 ); ?></span>
				<h3><?php echo $s['title']; // phpcs:ignore - chuoi tinh, co entity &amp; ?></h3>
				<p><?php echo $s['desc']; // phpcs:ignore ?></p>
			</li>
			<?php endforeach; ?>
		</ol>

		<div class="sg-order-help">
			<div>
				<h3><?php echo esc_html( $dgc_og_help_h ); ?></h3>
				<p><?php echo esc_html( $dgc_og_help ); ?></p>
			</div>
			<div class="sg-order-help-cta">
				<a class="sg-btn sg-btn--ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>"><?php echo dgc_arrow(); ?>Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a>
				<a class="sg-btn" href="https://zalo.me/<?php echo esc_attr( $dgc_og_zalo ); ?>" target="_blank" rel="noopener"><?php echo dgc_arrow(); ?>Nhắn Zalo</a>
			</div>
		</div>
	</div>
</section>
