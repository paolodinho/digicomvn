<?php
/**
 * Thanh cong cu tick chon bao/site/goi + tong tien tam tinh (chua VAT) + chiet khau combo
 * bac thang (cang tick nhieu muc cang giam - bac cau hinh o WP Admin, xem dgc_combo_tiers()).
 * Ghim (sticky) dau khu vuc bang gia; dung chung cho page-bang-gia.php va inc/service-pricing.php.
 * Khong nhan bien dau vao - JS trong main.js tu quet moi checkbox ".row-check" tren trang.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$dgc_tiers      = dgc_combo_tiers();
$dgc_tiers_text = dgc_combo_tiers_text();
?>
<div class="sel-bar" data-sel-bar data-tiers="<?php echo esc_attr( wp_json_encode( $dgc_tiers ) ); ?>">
	<p class="sel-bar-hint">Tick chọn báo/site để xem tổng chi phí &amp; gửi yêu cầu báo giá.</p>
	<div class="sel-bar-info">
		<span class="sel-bar-count">Đã chọn: <b class="sel-bar-count-num">0</b> mục</span>

		<div class="sel-bar-line sel-bar-sub">
			<span class="sel-bar-line-label">Tạm tính</span>
			<span class="sel-bar-line-num sel-bar-sub-num">0đ</span>
		</div>

		<div class="sel-bar-line sel-bar-disc" hidden>
			<span class="sel-bar-line-label">Ưu đãi combo <b class="sel-bar-disc-pct">0%</b></span>
			<span class="sel-bar-line-num sel-bar-disc-num">-0đ</span>
		</div>

		<div class="sel-bar-total-wrap">
			<span class="sel-bar-total-label">Còn lại</span>
			<span class="sel-bar-total"><span class="sel-bar-total-num">0</span><span class="vnd">đ</span></span>
		</div>
		<span class="sel-bar-vat-note">(chưa gồm VAT)</span>
		<button type="button" class="sel-bar-list-toggle" disabled>Xem danh sách</button>
		<div class="sel-bar-list"></div>
	</div>
	<div class="sel-bar-actions">
		<button type="button" class="btn btn-ghost btn-sm sel-bar-reset" hidden>Chọn lại</button>
		<a class="btn btn-primary btn-sm sel-bar-cta" href="<?php echo esc_url( home_url( '/dat-bai/' ) ); ?>">Gửi yêu cầu báo giá</a>
	</div>
	<?php if ( $dgc_tiers ) : ?><p class="sel-bar-nudge" hidden></p><?php endif; ?>
</div>
<?php if ( $dgc_tiers_text ) : ?>
<p class="sel-bar-combo-note">Ưu đãi combo tự động: <b><?php echo esc_html( $dgc_tiers_text ); ?></b> trên tổng đơn (chưa gồm VAT).</p>
<?php endif; ?>
