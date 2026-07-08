<?php
/**
 * Thanh cong cu tick chon bao/site/goi + tinh tong tien tam tinh (chua VAT).
 * Ghim (sticky) dau khu vuc bang gia; dung chung cho page-bang-gia.php va
 * inc/service-pricing.php. Khong nhan bien dau vao - JS trong main.js tu quet
 * moi checkbox ".row-check" tren trang (bat ke o bang/tab nao) de tinh tong.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="sel-bar" data-sel-bar>
	<div class="sel-bar-info">
		<span class="sel-bar-count">Đã chọn: <b class="sel-bar-count-num">0</b> mục</span>
		<div class="sel-bar-total-wrap">
			<span class="sel-bar-total-label">Tổng tạm tính</span>
			<span class="sel-bar-total"><span class="sel-bar-total-num">0</span><span class="vnd">đ</span></span>
		</div>
		<span class="sel-bar-vat-note">(chưa gồm VAT)</span>
		<button type="button" class="sel-bar-list-toggle" disabled>Xem danh sách</button>
		<div class="sel-bar-list"></div>
	</div>
	<div class="sel-bar-actions">
		<a class="btn btn-navy btn-sm sel-bar-cta" href="<?php echo esc_url( home_url( '/dat-bai/' ) ); ?>">Gửi yêu cầu báo giá</a>
	</div>
</div>
<p class="sel-bar-combo-note">Đặt combo từ 2 báo/gói trở lên - liên hệ để nhận thêm ưu đãi.</p>
