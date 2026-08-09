<?php
/**
 * Bang gia chi tiet TRONG tung trang dich vu (tpl-service.php) - moi trang dich vu la
 * mot money page rieng (khong con trang tong hop /bang-gia/, 2026-08-09): tim kiem,
 * sap xep, loc nhom bao, tick chon tinh tong tam tinh.
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

// Loc EXACT domain (shortcode [dgc_bang_gia] trong bai blog) - chinh xac hon keyword,
// tranh over-match kieu "24h" trung ca bongda24h.vn / nghean24h.vn.
if ( ! empty( $dgc_sp_domains ) ) {
	$dgc_sp_doms = array_map( 'strtolower', array_map( 'trim', (array) $dgc_sp_domains ) );
	$filtered    = array_values( array_filter( $dgc_sp_items, function ( $it ) use ( $dgc_sp_doms ) {
		return in_array( strtolower( trim( $it->post_title ) ), $dgc_sp_doms, true );
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
	: ( $dgc_sp_is_outlet
		? 'Bảng giá ' . mb_strtolower( $svc_name ) // 1 dau bao cu the -> khong ghi "theo tung bao"
		: 'Bảng giá ' . mb_strtolower( $svc_name ) . ' theo từng ' . $dgc_sp_dv );
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
	<div class="wrap wrap-wide">
		<div class="center" style="margin-bottom:18px">
			<span class="eyebrow">Bảng giá</span>
			<h2><?php echo esc_html( $dgc_sp_heading ); ?></h2>
			<p class="muted" style="font-size:14.5px"><?php echo esc_html( $dgc_sp_sub ); ?></p>
		</div>

		<?php include get_template_directory() . '/inc/sel-bar.php'; ?>

		<div class="price-layout" data-price-panel data-limit="<?php echo esc_attr( $dgc_sp_limit ); ?>">
			<?php
			$pf_items      = $dgc_sp_items;
			$pf_show_nganh = $dgc_sp_has_nganh;
			include get_template_directory() . '/inc/price-sidebar.php';
			?>
			<div class="price-main">
				<?php include get_template_directory() . '/inc/price-filter.php'; ?>
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

				<?php if ( function_exists( 'dgc_gia_items_have_vitri' ) && dgc_gia_items_have_vitri( $dgc_sp_items ) ) : ?>
				<p class="vitri-hint"><span class="vitri-hint-ic">V</span> Bấm chữ "V" cạnh vị trí đăng để xem ảnh chụp thực tế trên báo/site đó.</p>
				<?php endif; ?>

				<?php
				/* Luoi ao (giong /bang-gia/, Hieu 2026-08-05: trang dich vu don dung bang HTML
				   day du - vd booking-bao-pr 1212 dong - nang toi 3,3MB, tai rat cham). Chi ve
				   ~20-30 dong dang trong khung nhin thay vi nhet het vao DOM. */
				$dgc_sp_grid_rows = dgc_gia_grid_rows( $dgc_sp_items, array(
					'nhom_slug' => $nhom['slug'],
					'ctx'       => $svc_name,
					'col_name'  => $dgc_sp_col_name,
				) );
				?>
				<div class="price-grid" data-price-grid data-nhom="<?php echo esc_attr( $nhom['slug'] ); ?>" data-ctx="<?php echo esc_attr( $svc_name ); ?>" data-col-name="<?php echo esc_attr( $dgc_sp_col_name ); ?>" data-is-goi="<?php echo $dgc_sp_is_goi ? '1' : '0'; ?>" data-don-vi="<?php echo esc_attr( $dgc_sp_dv ); ?>"></div>
				<script type="application/json" class="price-grid-data"><?php echo wp_json_encode( $dgc_sp_grid_rows, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP ); ?></script>

				<?php /* Du phong cho trinh duyet tat JS / crawler khong chay JS - danh sach thuan text, nhe. */ ?>
				<noscript>
					<table class="price-table-noscript">
						<?php foreach ( $dgc_sp_items as $dgc_sp_ns_it ) :
							$dgc_sp_ns_vt = trim( (string) ( $dgc_sp_ns_it->meta['vi_tri'] ?? '' ) );
						?>
						<tr><td><?php echo esc_html( $dgc_sp_ns_it->post_title ); ?><?php if ( $dgc_sp_ns_vt !== '' ) : ?> - <?php echo esc_html( $dgc_sp_ns_vt ); ?><?php endif; ?></td><td><?php echo esc_html( dgc_format_price( $dgc_sp_ns_it->meta['gia_km'] ?? '' ) ); ?></td></tr>
						<?php endforeach; ?>
					</table>
				</noscript>

				<?php /* Ghi chu "gia tham khao" - cuoi bang, dong chu nho, khong CTA (Hieu 2026-07-15). */ ?>
				<?php include get_template_directory() . '/inc/price-note.php'; ?>
			</div>
		</div>

		<?php if ( ! $dgc_sp_is_goi ) : ?>
		<p class="center" style="margin-top:16px;font-size:14px">
			<a class="link-more" href="<?php echo esc_url( home_url( '/#services' ) ); ?>">Xem các dịch vụ khác của DigicomVN &rarr;</a>
		</p>
		<?php endif; ?>
	</div>
</section>
