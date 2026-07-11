<?php
/**
 * Template trang Bang gia tong hop (slug "bang-gia").
 * Bang gia rut gon (tu options) + bang gia chi tiet 209 dong tu CPT dgc_gia,
 * chia 4 tab theo dgc_nhom, co tim kiem/sap xep + tool uoc tinh chi phi.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

$dgc_nhom_list = array(
	'booking-bao-pr'   => 'Booking báo & PR',
	'guest-post'       => 'Guest Post',
	'dich-vu-backlink' => 'Dịch vụ Backlink',
	'mua-textlink'     => 'Mua Textlink',
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
		<p class="lead">Tra cứu giá cụ thể theo từng báo, site và gói dịch vụ - Textlink, Backlink, Guest Post, Booking báo &amp; PR. Lọc, sắp xếp và ước tính chi phí ngay bên dưới.</p>
	</div>
</section>


<!-- Bang gia chi tiet theo tab + cong cu tick chon (ghim dau khu vuc nay) -->
<section class="sec" id="bang-gia-chi-tiet" style="background:#fff;border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
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
			$nganh_labels     = dgc_nganh_options();
		?>
		<div class="tab-panel<?php echo $first ? ' active' : ''; ?>" data-panel="<?php echo esc_attr( $slug ); ?>">
			<div class="price-layout<?php echo $has_nganh_filter ? ' has-filter' : ''; ?>">
			<?php if ( $has_nganh_filter ) : ?>
			<aside class="price-filter">
				<div class="price-filter-title">Lọc theo nhóm báo</div>
				<div class="price-filter-row">
					<button type="button" class="nganh-btn active" data-nganh="">Tất cả (<?php echo count( $items ); ?>)</button>
					<?php foreach ( $nganh_labels as $nslug => $nlabel ) :
						if ( $nslug === '' || empty( $nganh_used[ $nslug ] ) ) continue;
						$n_count = 0;
						foreach ( $items as $it ) { if ( in_array( $nslug, dgc_gia_nganh_tags( $it->meta['nganh'] ?? '' ), true ) ) $n_count++; }
					?>
					<button type="button" class="nganh-btn" data-nganh="<?php echo esc_attr( $nslug ); ?>"><?php echo esc_html( $nlabel ); ?> (<?php echo (int) $n_count; ?>)</button>
					<?php endforeach; ?>
				</div>
			</aside>
			<?php endif; ?>
			<div class="price-main">
			<div class="tab-toolbar">
				<div class="tab-search">
					<input type="text" class="tab-search-input" placeholder="Tìm theo tên báo/site..." aria-label="Tìm kiếm trong <?php echo esc_attr( $label ); ?>">
				</div>
				<div class="tab-sort">
					<button type="button" class="sort-btn" data-dir="asc">Giá thấp → cao</button>
					<button type="button" class="sort-btn" data-dir="desc">Giá cao → thấp</button>
				</div>
			</div>
			<p class="tab-count"><span class="tab-count-shown"><?php echo count( $items ); ?></span>/<span class="tab-count-total"><?php echo count( $items ); ?></span> kết quả</p>

			<div class="price-table-wrap">
				<table class="price-table price-table-cpt">
					<thead>
						<tr>
							<th>Tên báo / site</th>
							<?php if ( 'mua-textlink' !== $slug ) : ?><th>Vị trí</th><?php endif; ?>
							<th>Giá</th>
							<th>Ghi chú</th>
						</tr>
					</thead>
					<tbody>
					<?php if ( empty( $items ) ) : ?>
						<tr><td colspan="4">Đang cập nhật dữ liệu.</td></tr>
					<?php endif; ?>
					<?php foreach ( $items as $it ) :
						$m         = $it->meta;
						$gia_km    = $m['gia_km'];
						$gia_goc   = $m['gia_goc'];
						$price_num = dgc_gia_to_number( $gia_km );
						$hot       = ( '1' === $m['noi_bat'] );
						$ghi_chu   = trim( implode( ' - ', array_filter( array( $m['so_link'], $m['yeu_cau'] ) ) ) );
						$row_link  = $m['url_bao'] ? $m['url_bao'] : '';
					?>
						<tr class="<?php echo $hot ? 'hot' : ''; ?>" data-price="<?php echo esc_attr( $price_num ); ?>" data-name="<?php echo esc_attr( mb_strtolower( $it->post_title ) ); ?>" data-nganh="<?php echo esc_attr( implode( ' ', dgc_gia_nganh_tags( $m['nganh'] ?? '' ) ) ); ?>">
							<td data-label="Tên báo/site">
								<label class="row-check-wrap">
									<input type="checkbox" class="row-check" data-label="<?php echo esc_attr( $it->post_title . ' (' . $label . ')' ); ?>">
									<?php echo dgc_row_logo_html( $row_link, $it->post_title ); ?>
									<span>
										<span class="row-name"><?php echo esc_html( $it->post_title ); ?></span>
										<?php if ( $hot ) : ?><span class="badge-hot">Phổ biến</span><?php endif; ?>
									</span>
								</label>
								<?php if ( $row_link ) : ?><a class="row-link" href="<?php echo esc_url( $row_link ); ?>" target="_blank" rel="noopener nofollow">Xem site</a><?php endif; ?>
							</td>
							<?php if ( 'mua-textlink' !== $slug ) : ?>
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
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			</div>
			</div>
		</div>
		<?php $first = false; endforeach; ?>
	</div>
</section>

<!-- Link ra 4 pillar -->
<section class="sec">
	<div class="wrap">
		<div class="pillar-links">
			<div class="pillar-card">
				<h3>Mua Textlink &amp; Dịch vụ Backlink</h3>
				<p class="muted">Chèn link vào bài có sẵn hoặc xây hệ thống backlink chất lượng, theo dõi index, có báo cáo.</p>
				<div class="pillar-actions">
					<a class="btn btn-navy btn-sm" href="<?php echo esc_url( home_url( '/dich-vu/mua-textlink/' ) ); ?>">Xem Textlink</a>
					<a class="btn btn-ghost btn-sm" href="<?php echo esc_url( home_url( '/dich-vu/dich-vu-backlink/' ) ); ?>">Xem Backlink</a>
				</div>
			</div>
			<div class="pillar-card">
				<h3>Guest Post &amp; Booking báo PR</h3>
				<p class="muted">Viết bài đăng trên site đúng chủ đề, hoặc booking đăng bài PR trên báo điện tử theo yêu cầu.</p>
				<div class="pillar-actions">
					<a class="btn btn-navy btn-sm" href="<?php echo esc_url( home_url( '/dich-vu/guest-post/' ) ); ?>">Xem Guest Post</a>
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

	/* ---- Search + sort + loc nganh per panel ---- */
	tabPanels.forEach(function(panel){
		var input     = panel.querySelector('.tab-search-input');
		var rows      = Array.prototype.slice.call(panel.querySelectorAll('.price-table-cpt tbody tr[data-name]'));
		var tbody     = panel.querySelector('.price-table-cpt tbody');
		var shownEl   = panel.querySelector('.tab-count-shown');
		var totalEl   = panel.querySelector('.tab-count-total');
		var sortBtns  = panel.querySelectorAll('.sort-btn');
		var nganhBtns = panel.querySelectorAll('.nganh-btn');
		var curNganh  = '';

		function applyFilter(){
			var q = (input ? input.value : '').trim().toLowerCase();
			var shown = 0;
			rows.forEach(function(r){
				var matchQ = !q || r.getAttribute('data-name').indexOf(q) !== -1;
				var matchN = !curNganh || (' ' + r.getAttribute('data-nganh') + ' ').indexOf(' ' + curNganh + ' ') !== -1;
				var match = matchQ && matchN;
				r.style.display = match ? '' : 'none';
				if (match) shown++;
			});
			if (shownEl) shownEl.textContent = shown;
			if (totalEl) totalEl.textContent = rows.length;
		}

		if (input) {
			var t;
			input.addEventListener('input', function(){
				clearTimeout(t);
				t = setTimeout(applyFilter, 120);
			});
		}

		nganhBtns.forEach(function(btn){
			btn.addEventListener('click', function(){
				curNganh = btn.getAttribute('data-nganh') || '';
				nganhBtns.forEach(function(b){ b.classList.toggle('active', b === btn); });
				applyFilter();
			});
		});

		sortBtns.forEach(function(btn){
			btn.addEventListener('click', function(){
				var dir = btn.getAttribute('data-dir') === 'asc' ? 1 : -1;
				sortBtns.forEach(function(b){ b.classList.toggle('active', b === btn); });
				rows.sort(function(a, b){
					var pa = parseFloat(a.getAttribute('data-price')) || 0;
					var pb = parseFloat(b.getAttribute('data-price')) || 0;
					return (pa - pb) * dir;
				});
				rows.forEach(function(r){ tbody.appendChild(r); });
			});
		});

		applyFilter();
	});

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
