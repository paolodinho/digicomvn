<?php
/**
 * Bao gia backlink theo loai - cho trang tong /dich-vu-backlink/ (nhom gia rieng dang trong).
 * SERP "bao gia backlink" (do 28/10/2026): 8/10 ket qua la trang dich vu co bang gia ->
 * trang nay can bang gia that. So lieu doc tu CPT dgc_gia qua dgc_svc_hero_data() (cache 6h),
 * loai nao chua co dong gia publish thi tu an. Moi dong dan sang trang dich vu co bang chi tiet.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$dgc_bpo_types = array(
	array( 'mua-textlink', 'Textlink', 'Chèn link vào bài viết có sẵn trên site đã chọn lọc', '/mua-textlink/', 'site' ),
	array( 'guest-post', 'Guest post', 'Viết bài mới đúng chủ đề, đăng kèm link dofollow', '/guest-post/', 'site' ),
	array( 'booking-bao-pr', 'Backlink báo PR', 'Bài PR trên báo điện tử, link về website', '/booking-bao-pr/', 'báo', 'Bảng giá báo PR' ),
	array( 'dich-vu-toplist', 'Toplist', 'Vị trí trong bài toplist đang có thứ hạng', '/dich-vu-toplist/', 'site' ),
	array( 'backlink-quoc-te', 'Backlink quốc tế', 'Guest post và bài PR trên site, báo nước ngoài', '/backlink-quoc-te/', 'site' ),
);
$dgc_bpo_rows = array();
foreach ( $dgc_bpo_types as $t ) {
	$d = dgc_svc_hero_data( $t[0] );
	if ( empty( $d['count'] ) || empty( $d['min'] ) || ! dgc_page_live( $t[3] ) ) continue;
	$dgc_bpo_rows[] = array( $t, $d );
}
if ( ! $dgc_bpo_rows ) return;
?>
<section class="sg-sec" id="bang-gia">
	<div class="wrap">
		<div class="sg-head">
			<h2 class="sg-h">Báo giá backlink theo từng loại</h2>
			<p class="sg-lead">Giá thấp nhất đang niêm yết cho mỗi loại backlink, cập nhật <?php echo esc_html( wp_date( 'd/m/Y' ) ); ?>. Bấm vào từng loại để xem giá chi tiết theo từng site, báo.</p>
		</div>
		<figure class="wp-block-table dgc-data-table">
			<table>
				<caption style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0">Báo giá backlink theo loại: số site, DR cao nhất, giá từ</caption>
				<thead><tr><th>Loại backlink</th><th>Hình thức</th><th>Số site, báo</th><th class="col-dr">DR cao nhất</th><th>Giá từ</th><th>Chi tiết</th></tr></thead>
				<tbody>
				<?php foreach ( $dgc_bpo_rows as $r ) : list( $t, $d ) = $r; ?>
					<tr>
						<td data-label="Loại backlink"><strong><?php echo esc_html( $t[1] ); ?></strong></td>
						<td data-label="Hình thức" class="col-kho"><?php echo esc_html( $t[2] ); ?></td>
						<td data-label="Số site, báo"><?php echo (int) $d['count'] . ' ' . esc_html( $t[4] ); ?></td>
						<td data-label="DR cao nhất" class="col-dr"><?php echo $d['maxdr'] ? (int) $d['maxdr'] : 'Theo từng site'; ?></td>
						<td data-label="Giá từ"><strong><?php echo esc_html( dgc_svc_money( $d['min'] ) ); ?></strong></td>
						<td data-label="Chi tiết"><a href="<?php echo esc_url( home_url( $t[3] ) ); ?>"><?php echo esc_html( $t[5] ?? 'Bảng giá ' . mb_strtolower( $t[1] ) ); ?></a></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</figure>
		<p class="price-foot-note">Giá tham khảo, chưa gồm VAT, có thể thay đổi theo chính sách từng site. Cần gói kết hợp nhiều loại backlink, gửi yêu cầu ở cuối trang để được báo giá trọn gói.</p>
	</div>
</section>
