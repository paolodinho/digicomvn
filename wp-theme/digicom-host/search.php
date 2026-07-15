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
			<ul class="srch-posts">
				<?php while ( $dgc_posts->have_posts() ) : $dgc_posts->the_post(); ?>
				<li>
					<a href="<?php the_permalink(); ?>">
						<h3><?php the_title(); ?></h3>
						<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 28 ) ); ?></p>
						<span class="srch-post-date"><?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?></span>
					</a>
				</li>
				<?php endwhile; wp_reset_postdata(); ?>
			</ul>
		</div>
		<?php endif; ?>

	</div>
</section>

<?php get_footer(); ?>
