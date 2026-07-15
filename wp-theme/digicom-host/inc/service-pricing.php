<?php
/**
 * Bang gia chi tiet nhung TRONG tung trang dich vu (tpl-service.php) - cung dang bang
 * voi trang /bang-gia/: tim kiem, sap xep, loc nhom bao, tick chon tinh tong tam tinh.
 * Include file - can bien $nhom (dgc_current_nhom()) va $svc_name truoc khi require.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
if ( empty( $nhom ) ) return;

$dgc_sp_items = dgc_get_gia( $nhom['slug'] );

// Trang con theo tung dau bao (vd /booking-bao-pr/vnexpress/) -> chi lay dong cua bao do.
$dgc_sp_is_outlet = false;
if ( ! empty( $nhom['outlet_keyword'] ) ) {
	$kw       = $nhom['outlet_keyword'];
	$filtered = array_values( array_filter( $dgc_sp_items, function ( $it ) use ( $kw ) {
		return stripos( str_replace( '-', '', $it->post_title ), $kw ) !== false;
	} ) );
	if ( $filtered ) {
		$dgc_sp_items     = $filtered;
		$dgc_sp_is_outlet = true;
	}
}

if ( empty( $dgc_sp_items ) ) return;

$dgc_sp_total = count( $dgc_sp_items );
$dgc_sp_limit = 10; // Mac dinh hien 10 dong, con lai an sau nut "Xem them" (JS trong main.js).

// Nhom "Backlink Social Entity" ban theo goi (khong theo dau bao/site) -> doi nhan cot cho dung.
$dgc_sp_is_goi   = ( 'backlink-social-entity' === $nhom['slug'] );
/* Booking bao & PR goi la "bao"; cac dich vu con lai goi la "trang" (Hieu 2026-07-14). */
$dgc_sp_dv       = dgc_nhom_don_vi( $nhom['slug'] );
$dgc_sp_col_name = $dgc_sp_is_goi ? 'Tên gói' : ( 'báo' === $dgc_sp_dv ? 'Tên báo' : 'Tên trang' );
$dgc_sp_col_pos  = $dgc_sp_is_goi ? 'Quy mô gói' : 'Vị trí';
$dgc_sp_heading  = $dgc_sp_is_goi
	? 'Bảng giá gói ' . mb_strtolower( $svc_name )
	: 'Bảng giá ' . mb_strtolower( $svc_name ) . ' theo từng ' . $dgc_sp_dv;
$dgc_sp_sub      = $dgc_sp_is_goi
	? 'Tick chọn gói bạn quan tâm - tổng chi phí tạm tính (chưa gồm VAT) hiện ngay bên cạnh.'
	: 'Tìm theo tên, sắp xếp theo giá và tick chọn ' . $dgc_sp_dv . ' cần đặt - tổng chi phí tạm tính (chưa gồm VAT) hiện ngay bên cạnh.';
$dgc_sp_ph       = $dgc_sp_is_goi ? 'Tìm theo tên gói...' : 'Tìm theo tên ' . $dgc_sp_dv . '...';

// Bo loc nhom nganh - chi hien khi du lieu co tu 2 nhom tro len (chu yeu Booking bao & PR).
$dgc_sp_nganh_used = array();
foreach ( $dgc_sp_items as $it ) {
	foreach ( dgc_gia_nganh_tags( $it->meta['nganh'] ?? '' ) as $n ) { $dgc_sp_nganh_used[ $n ] = true; }
}
$dgc_sp_has_nganh  = ( ! $dgc_sp_is_outlet && count( $dgc_sp_nganh_used ) > 1 );
// Trang tung dau bao (vd /booking-bao-pr/vnexpress/) van cho loc quy cach - nhieu vi tri dang
// cua cung 1 bao khac nhau ve loai link / so anh / so tu.
$dgc_sp_has_filter = ( $dgc_sp_has_nganh || dgc_has_facet_filter( $dgc_sp_items ) );
$dgc_sp_has_tools  = ( ! $dgc_sp_is_outlet && $dgc_sp_total > 4 );
?>
<section class="sec" id="bang-gia" style="background:var(--surface-2);border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:18px">
			<span class="eyebrow">Bảng giá</span>
			<h2><?php echo esc_html( $dgc_sp_heading ); ?></h2>
			<p class="muted" style="font-size:14.5px"><?php echo esc_html( $dgc_sp_sub ); ?></p>
		</div>

		<?php include get_template_directory() . '/inc/price-note.php'; ?>
		<?php include get_template_directory() . '/inc/sel-bar.php'; ?>

		<div class="price-layout" data-price-panel data-limit="<?php echo esc_attr( $dgc_sp_limit ); ?>">
			<div class="price-main">
				<?php
				$pf_items      = $dgc_sp_items;
				$pf_show_nganh = $dgc_sp_has_nganh;
				include get_template_directory() . '/inc/price-filter.php';
				?>
				<?php if ( $dgc_sp_has_tools ) : ?>
				<div class="tab-toolbar">
					<div class="tab-search">
						<input type="text" class="tab-search-input" placeholder="<?php echo esc_attr( $dgc_sp_ph ); ?>" aria-label="Tìm kiếm trong bảng giá <?php echo esc_attr( $svc_name ); ?>">
					</div>
					<div class="tab-sort">
						<button type="button" class="sort-btn" data-key="price" data-dir="asc">Giá thấp → cao</button>
						<button type="button" class="sort-btn" data-key="price" data-dir="desc">Giá cao → thấp</button>
						<?php if ( ! $dgc_sp_is_goi ) : ?><button type="button" class="sort-btn active" data-key="dr" data-dir="desc">DR cao → thấp</button><?php endif; ?>
					</div>
				</div>
				<p class="tab-count"><span class="tab-count-shown"><?php echo (int) $dgc_sp_total; ?></span>/<span class="tab-count-total"><?php echo (int) $dgc_sp_total; ?></span> kết quả</p>
				<?php endif; ?>

				<div class="price-table-wrap">
					<table class="price-table price-table-cpt">
						<thead>
							<tr>
								<th class="col-site"><?php echo esc_html( $dgc_sp_col_name ); ?></th>
								<th class="col-spec"><?php echo $dgc_sp_is_goi ? 'Quy mô gói' : 'Quy cách đăng'; ?></th>
								<th class="col-price">Giá</th>
								<th class="col-action"></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ( $dgc_sp_items as $it ) {
							echo dgc_gia_row_html( $it, array(
								'nhom_slug' => $nhom['slug'],
								'ctx'       => $svc_name,
								'col_name'  => $dgc_sp_col_name,
							) );
						} ?>
						</tbody>
					</table>
				</div>

				<?php if ( $dgc_sp_total > $dgc_sp_limit ) : ?>
				<p class="center" style="margin-top:18px">
					<button type="button" class="btn btn-ghost btn-sm price-more-btn">Xem thêm <?php echo (int) ( $dgc_sp_total - $dgc_sp_limit ); ?> mục</button>
				</p>
				<?php endif; ?>
			</div>
		</div>

		<?php if ( ! $dgc_sp_is_goi ) : ?>
		<p class="center" style="margin-top:16px;font-size:14px">
			<a class="link-more" href="<?php echo esc_url( home_url( '/bang-gia/#' . $nhom['slug'] ) ); ?>">So sánh giá với các dịch vụ khác tại Bảng giá tổng hợp &rarr;</a>
		</p>
		<?php endif; ?>
	</div>
</section>
