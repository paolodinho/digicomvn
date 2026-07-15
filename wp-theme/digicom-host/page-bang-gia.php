<?php
/**
 * Template trang Bang gia tong hop (slug "bang-gia").
 * Bang gia rut gon (tu options) + bang gia chi tiet 209 dong tu CPT dgc_gia,
 * chia 4 tab theo dgc_nhom, co tim kiem/sap xep + tool uoc tinh chi phi.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

$dgc_nhom_list = array(
	'booking-bao-pr'         => 'Booking báo & PR',
	'guest-post'             => 'Guest Post',
	'dich-vu-backlink'       => 'Dịch vụ Backlink',
	'mua-textlink'           => 'Mua Textlink',
	'backlink-social-entity' => 'Backlink Social Entity',
	'dich-vu-toplist'        => 'Dịch vụ Toplist',
	'backlink-quoc-te'       => 'Backlink quốc tế',
	'booking-truyen-hinh'    => 'Booking truyền hình',
);

// Gom du lieu 1 lan, dung lai cho bang chi tiet + cong cu tick chon.
$dgc_gia_theo_nhom = array();
foreach ( $dgc_nhom_list as $slug => $label ) {
	$dgc_gia_theo_nhom[ $slug ] = dgc_get_gia( $slug );
}
// dgc_gia_to_number() dung ban chung trong inc/cpt-gia.php (dung ca cho tpl-service.php).
?>
<div class="wrap"><nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a><span class="sep">/</span> Bảng giá</nav></div>

<section class="page-hero">
	<div class="wrap" style="max-width:820px">
		<span class="eyebrow">Bảng giá</span>
		<h1>Bảng giá dịch vụ DigicomVN</h1>
		<p class="lead">Tra cứu giá cụ thể theo từng báo, site và gói dịch vụ - Textlink, Backlink, Guest Post, Booking báo &amp; PR, Backlink Social Entity. Lọc, sắp xếp và ước tính chi phí ngay bên dưới.</p>
	</div>
</section>


<!-- Bang gia chi tiet theo tab + cong cu tick chon (ghim dau khu vuc nay) -->
<section class="sec" id="bang-gia-chi-tiet" style="background:var(--surface-2);border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:18px"><span class="eyebrow">Chi tiết</span><h2>Tra cứu giá theo từng báo / site</h2>
		</div>

		<?php include get_template_directory() . '/inc/sel-bar.php'; ?>

		<div class="tab-bar" role="tablist">
			<?php $first = true; foreach ( $dgc_nhom_list as $slug => $label ) : ?>
			<button type="button" class="tab-btn<?php echo $first ? ' active' : ''; ?>" data-tab="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $label ); ?></button>
			<?php $first = false; endforeach; ?>
		</div>

		<?php $first = true; foreach ( $dgc_nhom_list as $slug => $label ) :
			$items = $dgc_gia_theo_nhom[ $slug ];
			$nganh_used = array();
			foreach ( $items as $it ) { foreach ( dgc_gia_nganh_tags( $it->meta['nganh'] ?? '' ) as $n ) { $nganh_used[ $n ] = true; } }
			$has_nganh_filter = count( $nganh_used ) > 1;
			// Nhom Social Entity ban theo goi, khong theo dau bao -> doi nhan cot/o tim kiem.
			$is_goi    = ( 'backlink-social-entity' === $slug );
			$col_name  = $is_goi ? 'Tên gói' : 'Tên báo / site';
			$col_pos   = $is_goi ? 'Quy mô gói' : 'Vị trí';
			$ph_search = $is_goi ? 'Tìm theo tên gói...' : 'Tìm theo tên báo/site...';
		?>
		<div class="tab-panel<?php echo $first ? ' active' : ''; ?>" data-panel="<?php echo esc_attr( $slug ); ?>">
			<?php /* data-limit: hien 12 dong dau, cuon toi cuoi bang tu nap them (cuon vo han - main.js). */ ?>
			<div class="price-layout" data-price-panel data-limit="12">
			<div class="price-main">
			<?php
			$pf_items      = $items;
			$pf_show_nganh = $has_nganh_filter;
			include get_template_directory() . '/inc/price-filter.php';
			?>
			<div class="tab-toolbar">
				<div class="tab-search">
					<input type="text" class="tab-search-input" placeholder="<?php echo esc_attr( $ph_search ); ?>" aria-label="Tìm kiếm trong <?php echo esc_attr( $label ); ?>">
				</div>
				<div class="tab-sort">
					<button type="button" class="sort-btn" data-key="price" data-dir="asc">Giá thấp → cao</button>
					<button type="button" class="sort-btn" data-key="price" data-dir="desc">Giá cao → thấp</button>
					<?php if ( ! $is_goi ) : ?><button type="button" class="sort-btn active" data-key="dr" data-dir="desc">DR cao → thấp</button><?php endif; ?>
				</div>
			</div>
			<p class="tab-count"><span class="tab-count-shown"><?php echo count( $items ); ?></span>/<span class="tab-count-total"><?php echo count( $items ); ?></span> kết quả</p>

			<div class="price-table-wrap">
				<table class="price-table price-table-cpt">
					<thead>
						<tr>
							<th class="col-site"><?php echo esc_html( $col_name ); ?></th>
							<th class="col-spec"><?php echo $is_goi ? 'Quy mô gói' : 'Quy cách đăng'; ?></th>
							<th class="col-price">Giá</th>
							<th class="col-action"></th>
						</tr>
					</thead>
					<tbody>
					<?php if ( empty( $items ) ) : ?>
						<tr><td colspan="4">Đang cập nhật dữ liệu.</td></tr>
					<?php endif; ?>
					<?php foreach ( $items as $it ) {
						echo dgc_gia_row_html( $it, array(
							'nhom_slug' => $slug,
							'ctx'       => $label,
							'col_name'  => $col_name,
						) );
					} ?>
					</tbody>
				</table>
			</div>

			<?php if ( count( $items ) > 12 ) : ?>
			<p class="center" style="margin-top:18px">
				<button type="button" class="btn btn-ghost btn-sm price-more-btn">Xem thêm mục</button>
			</p>
			<?php endif; ?>
			</div>
			</div>
		</div>
		<?php $first = false; endforeach; ?>

		<?php /* Ghi chu "gia tham khao" - dat cuoi bang, dong chu nho, khong CTA (Hieu 2026-07-15). */ ?>
		<?php include get_template_directory() . '/inc/price-note.php'; ?>
	</div>
</section>

<?php include get_template_directory() . '/inc/order-guide.php'; ?>

<!-- Link ra 4 pillar -->
<section class="sec">
	<div class="wrap">
		<div class="pillar-links">
			<div class="pillar-card">
				<h3>Mua Textlink &amp; Dịch vụ Backlink</h3>
				<p class="muted">Chèn link vào bài có sẵn hoặc xây hệ thống backlink chất lượng, theo dõi index, có báo cáo.</p>
				<div class="pillar-actions">
					<a class="btn btn-ghost btn-sm" href="<?php echo esc_url( home_url( '/dich-vu/mua-textlink/' ) ); ?>">Xem Textlink</a>
					<a class="btn btn-ghost btn-sm" href="<?php echo esc_url( home_url( '/dich-vu/dich-vu-backlink/' ) ); ?>">Xem Backlink</a>
				</div>
			</div>
			<div class="pillar-card">
				<h3>Guest Post &amp; Booking báo PR</h3>
				<p class="muted">Viết bài đăng trên site đúng chủ đề, hoặc booking đăng bài PR trên báo điện tử theo yêu cầu.</p>
				<div class="pillar-actions">
					<a class="btn btn-ghost btn-sm" href="<?php echo esc_url( home_url( '/dich-vu/guest-post/' ) ); ?>">Xem Guest Post</a>
					<a class="btn btn-ghost btn-sm" href="<?php echo esc_url( home_url( '/dich-vu/booking-bao-pr/' ) ); ?>">Xem Booking PR</a>
				</div>
			</div>
		</div>
	</div>
</section>

<?php if ( get_the_content() ) : ?>
<section class="sec" style="background:var(--surface)"><div class="wrap page-content"><?php the_content(); ?></div></section>
<?php endif; ?>

<section class="sec-tight"><div class="wrap"><div class="cta-band">
	<div><h2>Cần báo giá chi tiết?</h2><p>Liên hệ DigicomVN để được tư vấn gói phù hợp và ưu đãi tốt nhất.</p></div>
	<div class="cta-actions"><a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a><a class="btn btn-navy" href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">Liên hệ</a></div>
</div></div></section>

<script>
(function(){
	'use strict';

	/* ---- Tabs ---- */
	var tabBtns   = document.querySelectorAll('.tab-btn');
	var tabPanels = document.querySelectorAll('.tab-panel');
	tabBtns.forEach(function(btn){
		btn.addEventListener('click', function(){
			var target = btn.getAttribute('data-tab');
			tabBtns.forEach(function(b){ b.classList.toggle('active', b === btn); });
			tabPanels.forEach(function(p){ p.classList.toggle('active', p.getAttribute('data-panel') === target); });
		});
	});

	/* Tim kiem / sap xep / loc nganh: xu ly chung trong assets/js/main.js
	   (bind theo [data-price-panel] - dung chung voi bang gia trong trang dich vu). */

	/* ---- Kich hoat dung tab (+ tim kiem san) khi tu trang dich vu link toi #nhom hoac #nhom:tu-khoa ---- */
	var rawHash = decodeURIComponent( ( location.hash || '' ).replace( '#', '' ) );
	if ( rawHash ) {
		var hashParts = rawHash.split( ':' );
		var hashNhom  = hashParts[0];
		var hashQuery = hashParts[1] || '';
		var hashBtn = null, hashPanel = null;
		tabBtns.forEach(function(b){ if (b.getAttribute('data-tab') === hashNhom) hashBtn = b; });
		tabPanels.forEach(function(p){ if (p.getAttribute('data-panel') === hashNhom) hashPanel = p; });
		if ( hashBtn ) {
			hashBtn.click();
			if ( hashQuery && hashPanel ) {
				var hashInput = hashPanel.querySelector('.tab-search-input');
				if ( hashInput ) {
					hashInput.value = hashQuery;
					hashInput.dispatchEvent(new Event('input'));
				}
			}
			var anchorEl = document.getElementById('bang-gia-chi-tiet');
			if ( anchorEl ) { setTimeout(function(){ anchorEl.scrollIntoView({ behavior: 'smooth', block: 'start' }); }, 30); }
		}
	}
})();
</script>

<?php get_footer(); ?>
