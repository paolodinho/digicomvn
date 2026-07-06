<?php
/**
 * Bang gia + tool uoc tinh chi phi rieng cho 1 trang dich vu (tpl-service.php).
 * Include file - can bien $nhom (tu dgc_current_nhom()) truoc khi require.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
if ( empty( $nhom ) ) return;

$dgc_sp_items = dgc_get_gia( $nhom['slug'] );

if ( ! empty( $nhom['outlet_keyword'] ) ) {
	$kw = $nhom['outlet_keyword'];
	$filtered = array_values( array_filter( $dgc_sp_items, function ( $it ) use ( $kw ) {
		return stripos( str_replace( '-', '', $it->post_title ), $kw ) !== false;
	} ) );
	if ( $filtered ) $dgc_sp_items = $filtered;
}

if ( empty( $dgc_sp_items ) ) return;

$dgc_sp_sum = 0; $dgc_sp_n = 0;
foreach ( $dgc_sp_items as $it ) {
	$v = dgc_gia_to_number( $it->meta['gia_km'] );
	if ( $v > 0 ) { $dgc_sp_sum += $v; $dgc_sp_n++; }
}
$dgc_sp_avg = $dgc_sp_n ? round( $dgc_sp_sum / $dgc_sp_n ) : 0;

$dgc_sp_show_all  = count( $dgc_sp_items ) <= 8;
$dgc_sp_show_rows = $dgc_sp_show_all ? $dgc_sp_items : array_slice( $dgc_sp_items, 0, 8 );
?>
<section class="sec" style="background:var(--surface)">
	<div class="wrap">
		<div class="calc-box">
			<div class="calc-decor" aria-hidden="true"></div>
			<div class="calc-inner calc-inner-single">
				<div class="calc-form">
					<span class="eyebrow">Công cụ</span>
					<h2>Ước tính chi phí nhanh</h2>
					<p class="muted" style="font-size:14.5px;margin-top:-6px">Nhập số lượng bài/link để xem chi phí tham khảo cho <?php echo esc_html( mb_strtolower( $svc_name ) ); ?>.</p>
					<div class="calc-fields">
						<label class="calc-field calc-field-num">
							<span>Số lượng bài / link</span>
							<input type="number" id="spCalcQty" min="1" value="1" inputmode="numeric">
						</label>
					</div>
					<a class="btn btn-navy" href="<?php echo esc_url( home_url( '/dat-bai/' ) ); ?>">Nhận báo giá chi tiết</a>
				</div>
				<div class="calc-result">
					<span class="calc-result-label">Chi phí ước tính</span>
					<div class="calc-result-num"><span id="spCalcResult">0</span><span class="calc-vnd">đ</span></div>
					<p class="calc-note">Giá trung bình từ <?php echo (int) $dgc_sp_n; ?> site/báo đang niêm yết - giá thực tế xem bảng bên dưới hoặc liên hệ để được báo giá chính xác.</p>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="sec" style="background:#fff;border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:22px">
			<span class="eyebrow">Bảng giá</span>
			<h2>Giá <?php echo esc_html( mb_strtolower( $svc_name ) ); ?> theo từng site/báo</h2>
		</div>
		<div class="price-table-wrap">
			<table class="price-table price-table-cpt">
				<thead>
					<tr>
						<th>Tên báo / site</th>
						<?php if ( 'mua-textlink' !== $nhom['slug'] ) : ?><th>Vị trí</th><?php endif; ?>
						<th>Giá</th>
						<th>Ghi chú</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ( $dgc_sp_show_rows as $it ) :
					$m       = $it->meta;
					$gia_km  = $m['gia_km']; $gia_goc = $m['gia_goc'];
					$hot     = ( '1' === $m['noi_bat'] );
					$ghi_chu = trim( implode( ' - ', array_filter( array( $m['so_link'], $m['yeu_cau'] ) ) ) );
				?>
					<tr class="<?php echo $hot ? 'hot' : ''; ?>">
						<td data-label="Tên báo/site">
							<span class="row-name"><?php echo esc_html( $it->post_title ); ?></span>
							<?php if ( $hot ) : ?><span class="badge-hot">Phổ biến</span><?php endif; ?>
						</td>
						<?php if ( 'mua-textlink' !== $nhom['slug'] ) : ?>
						<td data-label="Vị trí"><?php echo esc_html( $m['vi_tri'] ); ?></td>
						<?php endif; ?>
						<td data-label="Giá" class="cell-price">
							<span class="price-now"><?php echo esc_html( $gia_km ); ?></span>
							<?php if ( $gia_goc && $gia_goc !== $gia_km ) : ?><span class="price-old"><?php echo esc_html( $gia_goc ); ?></span><?php endif; ?>
						</td>
						<td data-label="Ghi chú"><?php echo esc_html( $ghi_chu ); ?></td>
						<td data-label=""><a class="btn btn-navy btn-sm" href="<?php echo esc_url( home_url( '/dat-bai/' ) ); ?>">Đặt ngay</a></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<?php if ( ! $dgc_sp_show_all ) : ?>
			<p class="center" style="margin-top:18px">
				<a class="btn btn-ghost btn-sm" href="<?php echo esc_url( home_url( '/bang-gia/' ) ); ?>">Xem đầy đủ <?php echo count( $dgc_sp_items ); ?> site/báo tại Bảng giá &rarr;</a>
			</p>
		<?php endif; ?>
	</div>
</section>

<script>
(function(){
	'use strict';
	var unit = <?php echo (float) $dgc_sp_avg; ?>;
	var qtyEl = document.getElementById('spCalcQty');
	var resEl = document.getElementById('spCalcResult');
	if (!qtyEl || !resEl) return;

	function formatVND(n){ return Math.round(n).toLocaleString('vi-VN'); }

	function animateTo(target){
		var start = 0, startTime = null, duration = 600;
		function step(ts){
			if (!startTime) startTime = ts;
			var progress = Math.min((ts - startTime) / duration, 1);
			var eased = 1 - Math.pow(1 - progress, 3);
			resEl.textContent = formatVND(start + (target - start) * eased);
			if (progress < 1) requestAnimationFrame(step);
			else resEl.textContent = formatVND(target);
		}
		requestAnimationFrame(step);
	}

	function recalc(){
		var qty = Math.max(1, parseInt(qtyEl.value, 10) || 1);
		animateTo(qty * unit);
	}
	qtyEl.addEventListener('input', recalc);
	recalc();
})();
</script>
