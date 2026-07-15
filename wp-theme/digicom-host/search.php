<?php
/**
 * Ket qua tim kiem TOAN TRANG - phan lam 2 nhom (Hieu 2026-07-14):
 *   1. BANG GIA  - cac dong dgc_gia khop ten bao/site (tim theo khoa da nen: "Báo Thanh Niên",
 *                  "thanh niên", "thanhnien.vn" deu ra cung ket qua - xem dgc_gia_search_terms()).
 *   2. BAI VIET  - post/page thuong, dung ket qua WP mac dinh.
 *
 * Gia hien o day chi de tham khao; bam vao dong se sang trang bang gia day du de tick chon.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

$dgc_q     = get_search_query();
$dgc_gia_r = dgc_search_gia( $dgc_q );

/* Bai viet / trang - loai bo CPT bang gia khoi ket qua thuong (da tach nhom rieng). */
$dgc_posts = new WP_Query( array(
	'post_type'      => array( 'post', 'page' ),
	's'              => $dgc_q,
	'posts_per_page' => 20,
	'post_status'    => 'publish',
) );

$dgc_n_gia  = count( $dgc_gia_r );
$dgc_n_post = (int) $dgc_posts->found_posts;
?>

<div class="wrap"><nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a><span class="sep">/</span> Tìm kiếm</nav></div>

<section class="page-hero">
	<div class="wrap" style="max-width:760px">
		<span class="eyebrow">Tìm kiếm</span>
		<h1>Kết quả cho &ldquo;<?php echo esc_html( $dgc_q ); ?>&rdquo;</h1>
		<p class="lead">Tìm thấy <b><?php echo (int) $dgc_n_gia; ?></b> mục trong bảng giá và <b><?php echo (int) $dgc_n_post; ?></b> bài viết.</p>
		<form class="srch-form srch-form-lg" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input type="search" name="s" value="<?php echo esc_attr( $dgc_q ); ?>" placeholder="Tên báo, tên trang hoặc từ khoá..." aria-label="Tìm kiếm">
			<button type="submit" class="btn btn-primary">Tìm</button>
		</form>
	</div>
</section>

<section class="sec">
	<div class="wrap">

		<?php if ( ! $dgc_n_gia && ! $dgc_n_post ) : ?>
			<div class="srch-empty">
				<h2>Không tìm thấy kết quả</h2>
				<p class="muted">Thử tìm bằng tên báo/trang (ví dụ <i>thanh niên</i>, <i>vnexpress</i>) hoặc xem toàn bộ <a href="<?php echo esc_url( home_url( '/bang-gia/' ) ); ?>">bảng giá</a>.</p>
			</div>
		<?php endif; ?>

		<?php if ( $dgc_n_gia ) : ?>
		<div class="srch-group">
			<div class="srch-group-head">
				<h2>Bảng giá <span class="srch-count"><?php echo (int) $dgc_n_gia; ?></span></h2>
				<a class="btn-text-link" href="<?php echo esc_url( home_url( '/bang-gia/' ) ); ?>">Xem bảng giá đầy đủ &rarr;</a>
			</div>
			<ul class="srch-gia">
				<?php foreach ( array_slice( $dgc_gia_r, 0, 20 ) as $dgc_r ) : ?>
				<li>
					<a href="<?php echo esc_url( $dgc_r['url'] ); ?>">
						<span class="srch-gia-name"><?php echo esc_html( $dgc_r['title'] ); ?></span>
						<span class="srch-gia-meta">
							<span class="srch-tag"><?php echo esc_html( $dgc_r['nhom_label'] ); ?></span>
							<?php if ( $dgc_r['vi_tri'] ) : ?><span class="srch-gia-pos"><?php echo esc_html( $dgc_r['vi_tri'] ); ?></span><?php endif; ?>
						</span>
						<span class="srch-gia-price"><?php echo esc_html( $dgc_r['gia'] ); ?></span>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
			<?php if ( $dgc_n_gia > 20 ) : ?>
			<p class="muted srch-more">Còn <?php echo (int) ( $dgc_n_gia - 20 ); ?> mục nữa - xem tại <a href="<?php echo esc_url( home_url( '/bang-gia/' ) ); ?>">bảng giá</a>.</p>
			<?php endif; ?>
			<?php include get_template_directory() . '/inc/price-note.php'; ?>
		</div>
		<?php endif; ?>

		<?php if ( $dgc_n_post ) : ?>
		<div class="srch-group">
			<div class="srch-group-head">
				<h2>Bài viết <span class="srch-count"><?php echo (int) $dgc_n_post; ?></span></h2>
			</div>
			<?php /* Cuon vo han: hien 20 dau, cuon toi cuoi tu nap tiep (Hieu 2026-07-15). */ ?>
			<ul class="srch-posts" data-search-more data-q="<?php echo esc_attr( $dgc_q ); ?>" data-paged="1" data-max="<?php echo (int) $dgc_posts->max_num_pages; ?>">
				<?php while ( $dgc_posts->have_posts() ) : $dgc_posts->the_post(); echo dgc_search_post_li(); endwhile; wp_reset_postdata(); ?>
			</ul>
			<?php if ( (int) $dgc_posts->max_num_pages > 1 ) : ?>
			<p class="center" style="margin-top:20px">
				<button type="button" class="btn btn-ghost btn-sm srch-more-btn">Xem thêm bài viết</button>
			</p>
			<?php endif; ?>
		</div>
		<?php endif; ?>

	</div>
</section>

<script>
(function(){
	'use strict';
	var ul = document.querySelector('[data-search-more]');
	if (!ul) return;
	var btn   = document.querySelector('.srch-more-btn');
	var ajax  = '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>';
	var paged = parseInt(ul.getAttribute('data-paged'), 10) || 1;
	var max   = parseInt(ul.getAttribute('data-max'), 10) || 1;
	var busy  = false;

	function load(){
		if (busy || paged >= max) return;
		busy = true;
		if (btn) btn.textContent = 'Đang tải...';
		var url = ajax + '?action=dgc_search_more&q=' + encodeURIComponent(ul.getAttribute('data-q')) + '&paged=' + (paged + 1);
		fetch(url).then(function(r){ return r.json(); }).then(function(res){
			if (res && res.success && res.data && res.data.html) {
				ul.insertAdjacentHTML('beforeend', res.data.html);
				paged++;
				ul.setAttribute('data-paged', paged);
			}
			busy = false;
			if (paged >= max) { if (btn) btn.remove(); }
			else if (btn) btn.textContent = 'Xem thêm bài viết';
		}).catch(function(){
			busy = false;
			if (btn) btn.textContent = 'Xem thêm bài viết';
		});
	}

	if (btn) btn.addEventListener('click', load);
	// Tu nap khi nut vao tam nhin (cuon vo han), nut van la fallback neu khong co observer.
	if (btn && 'IntersectionObserver' in window) {
		new IntersectionObserver(function(entries){
			entries.forEach(function(e){ if (e.isIntersecting) load(); });
		}, { rootMargin: '250px 0px' }).observe(btn);
	}
})();
</script>

<?php get_footer(); ?>
