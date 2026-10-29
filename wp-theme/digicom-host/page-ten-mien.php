<?php
/**
 * Template trang Ten mien (page slug "ten-mien"). Viet lai 2026-10-27 khi mo dich vu ten mien.
 * Gia doc tu option 'ten_mien_gia' (inc/domain-hosting.php). Tu 2026-10-29: gio hang + thanh toan QR (inc/domain-order.php),
 * form lead chi con cho ten mien chua co gia/kiem tra thu cong.
 * KHONG hien ten nha cung cap (rule dich-vu.md).
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
$dgc_vn = dgc_ten_mien_rows( 'vn' );
$dgc_qt = dgc_ten_mien_rows( 'qt' );
$dgc_tm_table = function ( $rows, $caption ) {
	?>
	<div class="tm-table-wrap">
	<table class="price-table tm-table">
		<caption class="sr-only"><?php echo esc_html( $caption ); ?></caption>
		<thead><tr><th>Tên miền</th><th>Đăng ký năm đầu</th><th>Gia hạn/năm</th><th class="col-note">Lưu ý</th><th></th></tr></thead>
		<tbody>
		<?php foreach ( $rows as $r ) :
			$gia = (float) $r['gia']; $goc = (float) $r['goc']; ?>
			<tr>
				<td class="tld" data-label="Tên miền"><?php echo esc_html( $r['duoi'] ); ?></td>
				<td data-label="Năm đầu"><b class="tm-now"><?php echo esc_html( dgc_vnd( $gia ) ); ?></b><?php if ( $goc > $gia ) : ?> <s class="tm-old"><?php echo esc_html( dgc_vnd( $goc ) ); ?></s><?php endif; ?></td>
				<td data-label="Gia hạn"><?php echo esc_html( dgc_vnd( $r['han'] ) ); ?></td>
				<td class="col-note" data-label="Lưu ý"><?php echo esc_html( $r['note'] ); ?></td>
				<td><a class="btn btn-ghost btn-sm" href="#tm-check" data-tld="<?php echo esc_attr( $r['duoi'] ); ?>">Đăng ký</a></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	</div>
	<?php
};
?>
<section class="sg-phero sg-phero--solo">
	<div class="wrap">
		<nav class="sg-crumb" aria-label="Breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a> / <span>Tên miền</span></nav>
		<span class="sg-eyebrow">Tên miền</span>
		<h1><?php echo esc_html( get_the_title() ?: 'Đăng ký tên miền' ); ?></h1>
		<p class="sg-lead">Kiểm tra tên miền còn trống, đăng ký .vn, .com.vn, .com và hơn 40 đuôi khác. DigicomVN tư vấn chọn tên miền phù hợp thương hiệu và kế hoạch SEO, hỗ trợ trỏ DNS, gắn hosting và chuyển tên miền về quản lý.</p>
		<div class="search-card tm-search" style="margin-top:24px">
			<form class="search-box" id="tm-check" autocomplete="off">
				<input type="text" name="d" placeholder="Nhập tên miền, ví dụ: thuonghieu.vn" aria-label="Tên miền cần kiểm tra" required>
				<button type="submit">Kiểm tra</button>
			</form>
			<p class="tm-result" id="tm-result" aria-live="polite" hidden></p>
			<a class="tm-bar" data-tm-bar href="<?php echo esc_url( dgc_tm_checkout_url() ); ?>" hidden>Giỏ tên miền: <b data-tm-n>0</b> <span>Thanh toán &rarr;</span></a>
		</div>
	</div>
</section>

<section class="sec" id="bang-gia">
	<div class="wrap">
		<div class="center" style="margin-bottom:28px"><span class="eyebrow">Bảng giá</span><h2>Giá tên miền Việt Nam</h2>
			<p class="muted" style="max-width:720px;margin:8px auto 0">Giá đăng ký năm đầu đã gồm lệ phí đăng ký và phí duy trì năm đầu theo quy định nhà nước. Tên miền .vn do Trung tâm Internet Việt Nam (VNNIC) quản lý, chủ thể đăng ký phải khai thông tin chính xác.</p></div>
		<?php $dgc_tm_table( $dgc_vn, 'Bảng giá tên miền Việt Nam' ); ?>

		<div class="center" style="margin:56px 0 28px"><h2>Giá tên miền quốc tế</h2>
			<p class="muted" style="max-width:720px;margin:8px auto 0">Giá năm đầu là giá ưu đãi, giá gia hạn từ năm thứ hai theo cột bên cạnh. Giá chưa gồm VAT.</p></div>
		<?php $dgc_tm_table( $dgc_qt, 'Bảng giá tên miền quốc tế' ); ?>
		<?php include get_template_directory() . '/inc/price-note.php'; ?>
	</div>
</section>

<section class="sec" style="background:var(--surface-2);border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap" style="max-width:960px">
		<div class="center" style="margin-bottom:28px"><span class="eyebrow">Tư vấn</span><h2>Chọn tên miền nào cho website làm SEO?</h2></div>
		<div class="page-content">
			<p>Tên miền không tự làm website lên top, nhưng chọn sai thì khó sửa về sau. Doanh nghiệp bán hàng trong nước nên ưu tiên <b>.vn</b> hoặc <b>.com.vn</b>: người dùng Việt quen mặt, Google hiểu website hướng tới thị trường Việt Nam. Nếu có kế hoạch ra nước ngoài, đăng ký thêm <b>.com</b> cùng tên để giữ thương hiệu.</p>
			<p>Tên ngắn, dễ đọc qua điện thoại, không gạch nối thừa. Không cần nhồi từ khoá vào tên miền: từ năm 2012 Google đã giảm ưu tiên cho tên miền chứa đúng từ khoá mà nội dung kém. Nên mua kèm các bản dễ gõ nhầm và đuôi phổ biến để tránh bị người khác chiếm dụng thương hiệu.</p>
			<p>Mua lại tên miền cũ (đã hết hạn) để lấy backlink là cách DigicomVN không khuyến khích: Google xếp việc dùng tên miền hết hạn để thao túng xếp hạng vào hành vi spam. Muốn có liên kết uy tín, xem dịch vụ <a href="<?php echo esc_url( home_url( '/booking-bao-pr/' ) ); ?>">booking báo PR</a> hoặc <a href="<?php echo esc_url( home_url( '/guest-post/' ) ); ?>">guest post</a>.</p>
		</div>
		<ol class="tm-steps">
			<li><b>Kiểm tra tên</b><span>Gõ tên miền ở ô phía trên, thêm tên còn trống vào giỏ.</span></li>
			<li><b>Gửi thông tin chủ thể</b><span>Cá nhân: họ tên, CCCD. Doanh nghiệp: tên, mã số thuế, người đại diện.</span></li>
			<li><b>Thanh toán</b><span>Quét mã QR ngay trên trang, hệ thống tự xác nhận khi tiền về. Xuất hoá đơn khi cần.</span></li>
			<li><b>Bàn giao</b><span>Gửi tài khoản quản trị, hỗ trợ trỏ DNS về hosting.</span></li>
		</ol>
	</div>
</section>

<?php if ( trim( get_post_field( 'post_content', get_the_ID() ) ) ) : ?>
<section class="sec"><div class="wrap page-content" style="max-width:960px"><?php the_content(); ?></div></section>
<?php endif; ?>

<?php include get_template_directory() . '/inc/svc-faq.php'; ?>

<section class="sec" id="dat-ten-mien">
	<div class="wrap" style="max-width:720px">
		<?php
		$dgc_form_title   = 'Đăng ký tên miền';
		$dgc_form_btn     = 'Gửi yêu cầu đăng ký';
		$dgc_form_service = 'Tên miền';
		include get_template_directory() . '/inc/form-lead.php';
		?>
	</div>
</section>
<?php include get_template_directory() . '/inc/order-prefill.php'; ?>
<?php get_footer(); ?>
