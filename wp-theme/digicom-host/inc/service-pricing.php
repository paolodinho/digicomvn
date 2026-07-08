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

$dgc_sp_show_all  = count( $dgc_sp_items ) <= 8;
$dgc_sp_show_rows = $dgc_sp_show_all ? $dgc_sp_items : array_slice( $dgc_sp_items, 0, 8 );
?>
<section class="sec" style="background:#fff;border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:18px">
			<span class="eyebrow">Bảng giá</span>
			<h2>Giá <?php echo esc_html( mb_strtolower( $svc_name ) ); ?> theo từng site/báo</h2>
			<p class="muted" style="font-size:14.5px">Tick chọn báo/site/gói bạn quan tâm - tổng chi phí tạm tính (chưa gồm VAT) hiện ngay bên cạnh.</p>
		</div>

		<?php include get_template_directory() . '/inc/sel-bar.php'; ?>
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
					$m         = $it->meta;
					$gia_km    = $m['gia_km']; $gia_goc = $m['gia_goc'];
					$price_num = dgc_gia_to_number( $gia_km );
					$hot       = ( '1' === $m['noi_bat'] );
					$ghi_chu   = trim( implode( ' - ', array_filter( array( $m['so_link'], $m['yeu_cau'] ) ) ) );
				?>
					<tr class="<?php echo $hot ? 'hot' : ''; ?>" data-price="<?php echo esc_attr( $price_num ); ?>">
						<td data-label="Tên báo/site">
							<label class="row-check-wrap">
								<input type="checkbox" class="row-check" data-label="<?php echo esc_attr( $it->post_title . ' (' . $svc_name . ')' ); ?>">
								<?php echo dgc_row_logo_html( $m['url_bao'], $it->post_title ); ?>
								<span>
									<span class="row-name"><?php echo esc_html( $it->post_title ); ?></span>
									<?php if ( $hot ) : ?><span class="badge-hot">Phổ biến</span><?php endif; ?>
								</span>
							</label>
						</td>
						<?php if ( 'mua-textlink' !== $nhom['slug'] ) : ?>
						<td data-label="Vị trí"><?php echo esc_html( $m['vi_tri'] ); ?></td>
						<?php endif; ?>
						<?php
						$has_real_old = ( $gia_goc && $gia_goc !== $gia_km );
						$show_fake    = ! $has_real_old && preg_match( '/^[0-9]+$/', trim( $gia_km ) );
						if ( $show_fake ) { $fake_pct = dgc_fake_discount_percent( $it->ID ); $fake_old = dgc_fake_original_price( $price_num, $fake_pct ); }
						?>
						<td data-label="Giá" class="cell-price">
							<?php if ( $show_fake ) : ?>
								<span class="price-old-line">
									<span class="price-old"><?php echo esc_html( number_format( $fake_old, 0, ',', '.' ) . 'đ' ); ?></span>
									<span class="price-discount-badge">-<?php echo (int) $fake_pct; ?>%</span>
								</span>
							<?php endif; ?>
							<span class="price-now"><?php echo esc_html( dgc_format_price( $gia_km ) ); ?></span>
							<?php if ( $has_real_old ) : ?><span class="price-old"><?php echo esc_html( dgc_format_price( $gia_goc ) ); ?></span><?php endif; ?>
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
