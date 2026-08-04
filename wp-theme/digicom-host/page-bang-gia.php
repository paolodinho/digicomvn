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
	/* 4 nhom media tam an (Hieu 2026-07-16), du lieu draft cho mo lai:
	   'booking-truyen-hinh' => 'Booking truyền hình', 'quang-cao-loa-phuong' => 'QC loa phường',
	   'quang-cao-phat-thanh' => 'QC phát thanh', 'quang-cao-man-led' => 'QC màn LED', */
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

<section class="sec-tight">
	<div class="wrap" style="max-width:1000px">
		<img
			src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/team-service-800.jpg' ); ?>"
			alt="Đội ngũ DigicomVN"
			width="800" height="479"
			style="width:100%;height:auto;border-radius:var(--r-lg);box-shadow:var(--sh-high);display:block"
			loading="lazy"
		>
	</div>
</section>

<?php include get_template_directory() . '/inc/price-view-options.php'; ?>

<!-- Bang gia chi tiet theo tab + cong cu tick chon (ghim dau khu vuc nay) -->
<section class="sec" id="bang-gia-chi-tiet" style="background:var(--surface-2);border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap wrap-wide">
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
			<?php
			/* Tab KHONG phai mac dinh -> dung khoi noi dung nang (hang tram dong gia,
			   logo, checkbox...) vao 1 <template> "tro" (khong render/khong tai anh, JS
			   chua dung toi) THAY VI de thang trong DOM nhu truoc - trang bang-gia truoc
			   day render san CA 7 tab (2168 <tr>, 57.000 node DOM, 1390 <img> logo) dan
			   toi trang nang/giat lag tren dien thoai (Hieu 2026-07-31: "trang dang bi
			   nang qua, hay do lag"). Tab dau tien (mac dinh mo) van render binh thuong
			   de co noi dung ngay khi tai trang (khong phu thuoc JS). Cac tab con lai chi
			   "hydrate" (nhet noi dung that vao DOM + goi dgcInitPricePanel()) dung 1 lan,
			   luc nguoi dung bam mo tab do lan dau (xem script cuoi file). */
			if ( ! $first ) : ?>
			<template data-lazy-panel="<?php echo esc_attr( $slug ); ?>">
			<?php endif; ?>
			<?php /* data-limit: hien 12 dong dau, cuon toi cuoi bang tu nap them (cuon vo han - main.js). */ ?>
			<div class="price-layout" data-price-panel data-limit="12">
			<?php
			$pf_items      = $items;
			$pf_show_nganh = $has_nganh_filter;
			include get_template_directory() . '/inc/price-sidebar.php';
			?>
			<div class="price-main">
			<?php include get_template_directory() . '/inc/price-filter.php'; ?>
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

			<?php if ( function_exists( 'dgc_gia_items_have_vitri' ) && dgc_gia_items_have_vitri( $items ) ) : ?>
			<p class="vitri-hint"><span class="vitri-hint-ic">V</span> Bấm chữ "V" cạnh vị trí đăng để xem ảnh chụp thực tế trên báo/site đó.</p>
			<?php endif; ?>

			<?php
			/* Luoi "kieu Excel" (Hieu 2026-08-01): thay bang <table> day du 200-300 dong/tab
			   (nguon chinh khien /bang-gia/ nang 4,6MB, xem LOG.md) bang 1 goi JSON GON (chi
			   ten/DR/khoang gia/facet loc - khong logo/khong markup lap) + JS chi ve ~30 dong
			   dang trong khung nhin luc cuon (assets/js/price-grid.js). Bam mo rong 1 bao moi
			   goi AJAX lay chi tiet (quy cach/gia/nut chon) - tai su dung dung ham PHP cu
			   (inc/price-grid.php), khong mat tinh nang (bang gia nhieu bac, "goi gom gi",
			   anh vi tri, gioi thieu bao...). */
			$grid_rows = empty( $items ) ? array() : dgc_gia_grid_rows( $items, array(
				'nhom_slug' => $slug,
				'ctx'       => $label,
				'col_name'  => $col_name,
			) );
			?>
			<div class="price-grid" data-price-grid data-nhom="<?php echo esc_attr( $slug ); ?>" data-ctx="<?php echo esc_attr( $label ); ?>" data-col-name="<?php echo esc_attr( $col_name ); ?>" data-is-goi="<?php echo $is_goi ? '1' : '0'; ?>" data-don-vi="<?php echo esc_attr( dgc_nhom_don_vi( $slug ) ); ?>">
				<?php if ( empty( $items ) ) : ?><p class="price-empty-row">Đang cập nhật dữ liệu.</p><?php endif; ?>
			</div>
			<script type="application/json" class="price-grid-data"><?php echo wp_json_encode( $grid_rows, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP ); ?></script>

			<?php /* Du phong cho trinh duyet tat JS / crawler khong chay JS - danh sach thuan text, nhe. */ ?>
			<noscript>
				<table class="price-table-noscript">
					<?php foreach ( $items as $ns_it ) :
						$ns_vt = trim( (string) ( $ns_it->meta['vi_tri'] ?? '' ) );
					?>
					<tr><td><?php echo esc_html( $ns_it->post_title ); ?><?php if ( $ns_vt !== '' ) : ?> - <?php echo esc_html( $ns_vt ); ?><?php endif; ?></td><td><?php echo esc_html( dgc_format_price( $ns_it->meta['gia_km'] ?? '' ) ); ?></td></tr>
					<?php endforeach; ?>
				</table>
			</noscript>
			</div>
			</div>
			<?php if ( ! $first ) : ?>
			</template>
			<?php endif; ?>
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
					<a class="btn btn-ghost btn-sm" href="<?php echo esc_url( home_url( '/mua-textlink/' ) ); ?>">Xem Textlink</a>
					<a class="btn btn-ghost btn-sm" href="<?php echo esc_url( home_url( '/dich-vu-backlink/' ) ); ?>">Xem Backlink</a>
				</div>
			</div>
			<div class="pillar-card">
				<h3>Guest Post &amp; Booking báo PR</h3>
				<p class="muted">Viết bài đăng trên site đúng chủ đề, hoặc booking đăng bài PR trên báo điện tử theo yêu cầu.</p>
				<div class="pillar-actions">
					<a class="btn btn-ghost btn-sm" href="<?php echo esc_url( home_url( '/guest-post/' ) ); ?>">Xem Guest Post</a>
					<a class="btn btn-ghost btn-sm" href="<?php echo esc_url( home_url( '/booking-bao-pr/' ) ); ?>">Xem Booking PR</a>
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

	/* Tab chua mo lan nao -> noi dung nang (hang tram dong gia) dang "ngu" trong 1
	   <template> (xem page-bang-gia.php) de khong lam trang nang luc tai. Lan dau
	   bam vao tab do -> nhet noi dung that vao DOM roi goi dgcInitPricePanel()
	   (ham dung chung trong main.js) de bat loc/sap xep/tick chon cho tab do. */
	function dgcHydratePanel(panel) {
		var tpl = panel.querySelector('template[data-lazy-panel]');
		if (!tpl) return; // da hydrate roi, hoac la tab dau (khong dung template)
		panel.appendChild(document.importNode(tpl.content, true));
		tpl.remove();
		var pp = panel.querySelector('[data-price-panel]');
		if (pp && window.dgcInitPricePanel) window.dgcInitPricePanel(pp);
		var pg = panel.querySelector('[data-price-grid]');
		if (pg && window.dgcInitPriceGrid) window.dgcInitPriceGrid(pg);
	}

	tabBtns.forEach(function(btn){
		btn.addEventListener('click', function(){
			var target = btn.getAttribute('data-tab');
			tabBtns.forEach(function(b){ b.classList.toggle('active', b === btn); });
			tabPanels.forEach(function(p){
				var active = p.getAttribute('data-panel') === target;
				p.classList.toggle('active', active);
				if (active) dgcHydratePanel(p);
			});
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
