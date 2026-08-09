<?php
/**
 * Sidebar trai (so do noi dung ca cum, dang accordion theo category) cho single blog post.
 * Kieu SEONGON: cot trai dieu huong cum chu de + link dich vu, cot phai la muc luc (toc.php).
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Dich vu Digicom lien quan toi tung category. Category khong khai o day -> fallback
 * ve section dich vu tren trang chu (khong con trang tong hop /bang-gia/, 2026-08-09).
 */
function dgc_cat_service_links( $slug ) {
	$map = array(
		'booking-bao-pr'   => array(
			array( 'label' => 'Booking báo & PR', 'url' => home_url( '/booking-bao-pr/' ) ),
		),
		'backlink-offpage'  => array(
			array( 'label' => 'Mua Textlink', 'url' => home_url( '/mua-textlink/' ) ),
			array( 'label' => 'Dịch vụ Backlink', 'url' => home_url( '/dich-vu-backlink/' ) ),
			array( 'label' => 'Guest Post', 'url' => home_url( '/guest-post/' ) ),
		),
	);
	if ( isset( $map[ $slug ] ) ) {
		return $map[ $slug ];
	}
	return array( array( 'label' => 'Xem tất cả dịch vụ', 'url' => home_url( '/#services' ) ) );
}

/**
 * Render cot trai: toan bo category (accordion), cum cua bai dang doc tu mo + highlight bai hien tai.
 */
function dgc_render_cluster_sidebar( $current_post_id ) {
	$cats = get_categories( array( 'hide_empty' => true, 'orderby' => 'name', 'exclude' => array(1) ) );
	if ( ! $cats ) return;
	$current_cat_ids = wp_get_post_categories( $current_post_id );
	?>
	<div class="post-side-left">
		<div class="post-side-left__title">Sơ đồ nội dung</div>
		<?php foreach ( $cats as $cat ) :
			$is_current_cluster = in_array( $cat->term_id, $current_cat_ids, true );
			$posts = get_posts( array(
				'cat'            => $cat->term_id,
				'posts_per_page' => -1,
				'orderby'        => array( 'menu_order' => 'ASC', 'ID' => 'ASC' ),
			) );
			if ( ! $posts ) continue;
			$svc_links = dgc_cat_service_links( $cat->slug );
			?>
			<details class="cluster-cat"<?php echo $is_current_cluster ? ' open' : ''; ?>>
				<summary><?php echo esc_html( $cat->name ); ?></summary>
				<ul class="cluster-list">
					<?php foreach ( $posts as $p ) :
						$is_current = ( (int) $p->ID === (int) $current_post_id );
						?>
						<li class="<?php echo $is_current ? 'is-current' : ''; ?>">
							<?php if ( $is_current ) : ?>
								<span aria-current="page"><?php echo esc_html( get_the_title( $p ) ); ?></span>
							<?php else : ?>
								<a href="<?php echo esc_url( get_permalink( $p ) ); ?>"><?php echo esc_html( get_the_title( $p ) ); ?></a>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
				<?php if ( $svc_links ) : ?>
					<div class="cluster-svc">
						<?php foreach ( $svc_links as $sl ) : ?>
							<a href="<?php echo esc_url( $sl['url'] ); ?>"><?php echo esc_html( $sl['label'] ); ?> &rarr;</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</details>
		<?php endforeach; ?>
	</div>
	<?php
}
