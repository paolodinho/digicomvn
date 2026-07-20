<?php
/**
 * Trang tac gia = LANDING gioi thieu ca nhan (khong phai ban sao cua /blog/).
 *
 * Truoc day trang nay chi liet ke TOAN BO bai viet -> trung lap voi /blog/ va
 * cac trang chuyen muc. Nay doi thanh trang xay dung uy tin ca nhan (E-E-A-T):
 * ho so, mang chuyen mon, hanh trinh, bai TIEU BIEU (toi da 6) va cac cum chu
 * de dam nhiem. Muon xem het bai -> dan sang /blog/ + trang chuyen muc.
 *
 * MOI noi dung sua duoc o WP Admin > Thanh vien > Ho so (khong cham code).
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

$dgc_author = get_queried_object();
$dgc_id     = (int) $dgc_author->ID;
$dgc_name   = $dgc_author->display_name;
$dgc_bio    = get_the_author_meta( 'description', $dgc_id );
$dgc_url    = get_author_posts_url( $dgc_id );

$dgc_m = function ( $k ) use ( $dgc_id ) { return get_user_meta( $dgc_id, $k, true ); };

$dgc_role     = $dgc_m( 'dgc_role_title' ) ?: 'Founder DigicomVN';
$dgc_tagline  = $dgc_m( 'dgc_tagline' );
$dgc_bio_long = $dgc_m( 'dgc_bio_long' );
$dgc_year     = (int) $dgc_m( 'dgc_year_start' );
$dgc_expert   = dgc_author_pairs( $dgc_m( 'dgc_expertise' ) );
$dgc_miles    = dgc_author_pairs( $dgc_m( 'dgc_milestones' ) );
$dgc_wins     = dgc_author_pairs( $dgc_m( 'dgc_achievements' ) );
$dgc_creds    = dgc_author_pairs( $dgc_m( 'dgc_credentials' ) );
$dgc_fb       = $dgc_m( 'dgc_facebook' );
$dgc_li       = $dgc_m( 'dgc_linkedin' );

$dgc_avatar_id = (int) $dgc_m( 'dgc_avatar_id' );
$dgc_avatar    = $dgc_avatar_id ? wp_get_attachment_image_url( $dgc_avatar_id, 'medium' ) : '';

/* --- So lieu that, dem tu CSDL (khong nhap tay -> khong bao gio lech) --- */
$dgc_count = (int) count_user_posts( $dgc_id, 'post', true );
$dgc_cats  = array_values( array_filter( get_categories( array( 'hide_empty' => true ) ), function ( $c ) {
	return $c->count > 0 && 'uncategorized' !== $c->slug;
} ) );

/* --- Bai tieu bieu: theo lua chon cua tac gia, neu trong thi tu lay bai moi
       nhat cua moi cum chu de (dai dien do rong, khong lap lai danh sach blog). */
$dgc_feat_ids = array();
foreach ( array_filter( array_map( 'trim', explode( ',', (string) $dgc_m( 'dgc_featured_posts' ) ) ) ) as $ref ) {
	$p = ctype_digit( $ref ) ? get_post( (int) $ref ) : get_page_by_path( $ref, OBJECT, 'post' );
	if ( $p && 'publish' === $p->post_status ) $dgc_feat_ids[] = $p->ID;
}
if ( ! $dgc_feat_ids ) {
	foreach ( $dgc_cats as $c ) {
		$q = get_posts( array( 'numberposts' => 1, 'category' => $c->term_id, 'author' => $dgc_id, 'fields' => 'ids' ) );
		if ( $q ) $dgc_feat_ids[] = $q[0];
	}
}
$dgc_feat_ids = array_slice( array_unique( $dgc_feat_ids ), 0, 6 );

/* --- Schema Person day du (danh tinh + linh vuc am hieu + ho so mang xa hoi) --- */
$dgc_schema = array(
	'@context' => 'https://schema.org',
	'@type'    => 'Person',
	'name'     => $dgc_name,
	'url'      => $dgc_url,
	'jobTitle' => $dgc_role,
	'worksFor' => array( '@type' => 'Organization', 'name' => 'DigicomVN', 'url' => home_url( '/' ) ),
);
if ( $dgc_bio )    $dgc_schema['description'] = wp_strip_all_tags( $dgc_bio );
if ( $dgc_avatar ) $dgc_schema['image']       = $dgc_avatar;
if ( $dgc_expert ) {
	$dgc_schema['knowsAbout'] = array_map( function ( $e ) { return $e[0]; }, $dgc_expert );
} elseif ( $dgc_cats ) {
	$dgc_schema['knowsAbout'] = array_map( function ( $c ) { return $c->name; }, $dgc_cats );
}
$dgc_same = array_values( array_filter( array( $dgc_fb, $dgc_li ) ) );
if ( $dgc_same ) $dgc_schema['sameAs'] = $dgc_same;
if ( $dgc_creds ) {
	$dgc_schema['hasCredential'] = array_map( function ( $c ) {
		return array( '@type' => 'EducationalOccupationalCredential', 'name' => $c[0], 'credentialCategory' => $c[1] );
	}, $dgc_creds );
}
?>
<script type="application/ld+json"><?php echo wp_json_encode( $dgc_schema ); ?></script>

<div class="wrap"><nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a><span class="sep">/</span> Tác giả</nav></div>

<section class="page-hero author-hero">
	<div class="wrap" style="max-width:900px">
		<div class="author-hero__row">
			<?php if ( $dgc_avatar ) : ?>
				<img class="author-avatar" src="<?php echo esc_url( $dgc_avatar ); ?>" alt="Ảnh chân dung <?php echo esc_attr( $dgc_name ); ?>" width="112" height="112">
			<?php else : ?>
				<span class="author-avatar author-avatar--fallback" aria-hidden="true"><?php echo esc_html( dgc_author_initials( $dgc_name ) ); ?></span>
			<?php endif; ?>
			<div>
				<span class="eyebrow">Tác giả</span>
				<h1><?php echo esc_html( $dgc_name ); ?></h1>
				<p class="lead" style="margin-bottom:14px"><?php echo esc_html( $dgc_tagline ?: $dgc_role ); ?></p>
				<div class="author-social">
					<?php if ( $dgc_fb ) : ?><a href="<?php echo esc_url( $dgc_fb ); ?>" target="_blank" rel="noopener me"><?php echo dgc_icon( 'facebook' ); ?><span>Facebook</span></a><?php endif; ?>
					<?php if ( $dgc_li ) : ?><a href="<?php echo esc_url( $dgc_li ); ?>" target="_blank" rel="noopener me"><?php echo dgc_icon( 'linkedin' ); ?><span>LinkedIn</span></a><?php endif; ?>
					<a href="tel:<?php echo esc_attr( dgc_tel() ); ?>"><span><?php echo esc_html( dgc( 'hotline' ) ); ?></span></a>
				</div>
			</div>
		</div>

		<div class="author-stats">
			<div class="author-stat"><strong><?php echo esc_html( number_format_i18n( $dgc_count ) ); ?></strong><span>bài viết đã xuất bản</span></div>
			<div class="author-stat"><strong><?php echo esc_html( count( $dgc_cats ) ); ?></strong><span>cụm chủ đề phụ trách</span></div>
			<?php if ( $dgc_year && $dgc_year >= 1990 ) : ?>
				<div class="author-stat"><strong><?php echo esc_html( max( 1, (int) gmdate( 'Y' ) - $dgc_year ) ); ?>+</strong><span>năm làm nghề</span></div>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php if ( $dgc_bio || $dgc_bio_long ) : ?>
<section class="sec-tight">
	<div class="wrap page-content" style="max-width:820px">
		<h2>Về <?php echo esc_html( $dgc_name ); ?></h2>
		<?php
		if ( $dgc_bio ) echo '<p class="lead">' . esc_html( wp_strip_all_tags( $dgc_bio ) ) . '</p>';
		if ( $dgc_bio_long ) echo wp_kses_post( wpautop( esc_html( $dgc_bio_long ) ) );
		?>
	</div>
</section>
<?php endif; ?>

<?php if ( $dgc_expert || $dgc_cats ) : ?>
<section class="sec" style="background:var(--surface-2);border-top:1px solid var(--line)">
	<div class="wrap" style="max-width:900px">
		<div class="center" style="margin-bottom:26px"><span class="eyebrow">Chuyên môn</span><h2>Mảng công việc trực tiếp phụ trách</h2></div>
		<div class="author-expertise">
			<?php if ( $dgc_expert ) : ?>
				<?php foreach ( $dgc_expert as $e ) : ?>
					<div class="author-exp-card">
						<h3><?php echo esc_html( $e[0] ); ?></h3>
						<?php if ( $e[1] ) : ?><p><?php echo esc_html( $e[1] ); ?></p><?php endif; ?>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<?php foreach ( array_slice( $dgc_cats, 0, 6 ) as $c ) : ?>
					<div class="author-exp-card">
						<h3><a href="<?php echo esc_url( get_category_link( $c ) ); ?>"><?php echo esc_html( $c->name ); ?></a></h3>
						<p><?php echo esc_html( $c->description ? wp_trim_words( $c->description, 20 ) : $c->count . ' bài viết đã xuất bản trong cụm này.' ); ?></p>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( $dgc_wins ) : ?>
<section class="sec-tight">
	<div class="wrap" style="max-width:900px">
		<div class="center" style="margin-bottom:26px"><span class="eyebrow">Kết quả</span><h2>Những con số đã tạo ra cho khách hàng</h2></div>
		<div class="author-wins">
			<?php foreach ( $dgc_wins as $w ) : ?>
				<div class="author-win"><strong><?php echo esc_html( $w[0] ); ?></strong><span><?php echo esc_html( $w[1] ); ?></span></div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( $dgc_miles ) : ?>
<section class="sec-tight">
	<div class="wrap" style="max-width:760px">
		<div class="center" style="margin-bottom:26px"><span class="eyebrow">Hành trình</span><h2>Các cột mốc</h2></div>
		<ol class="author-timeline">
			<?php foreach ( $dgc_miles as $mi ) : ?>
				<li><span class="author-timeline__year"><?php echo esc_html( $mi[0] ); ?></span><span class="author-timeline__text"><?php echo esc_html( $mi[1] ); ?></span></li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
<?php endif; ?>

<?php if ( $dgc_creds ) : ?>
<section class="sec-tight">
	<div class="wrap" style="max-width:820px">
		<div class="center" style="margin-bottom:22px"><span class="eyebrow">Đào tạo</span><h2>Chứng chỉ &amp; khoá học chuyên môn</h2></div>
		<ul class="author-creds">
			<?php foreach ( $dgc_creds as $cr ) : ?>
				<li><strong><?php echo esc_html( $cr[0] ); ?></strong><?php if ( $cr[1] ) : ?><span><?php echo esc_html( $cr[1] ); ?></span><?php endif; ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
<?php endif; ?>

<?php if ( $dgc_feat_ids ) : ?>
<section class="sec" style="background:var(--surface-2);border-top:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:30px"><span class="eyebrow">Nội dung tiêu biểu</span><h2>Bài viết chọn lọc</h2></div>
		<div class="blog-grid">
			<?php foreach ( $dgc_feat_ids as $pid ) : $dgc_p = get_post( $pid ); ?>
				<article class="blog-card">
					<a href="<?php echo esc_url( get_permalink( $pid ) ); ?>" class="blog-card__thumb">
						<?php if ( has_post_thumbnail( $pid ) ) : ?>
							<?php echo get_the_post_thumbnail( $pid, 'medium_large' ); ?>
						<?php else : ?>
							<div class="blog-card__thumb-placeholder"></div>
						<?php endif; ?>
					</a>
					<div class="blog-card__body">
						<time class="blog-card__date"><?php echo esc_html( get_the_date( 'd/m/Y', $pid ) ); ?></time>
						<h3 class="blog-card__title"><a href="<?php echo esc_url( get_permalink( $pid ) ); ?>"><?php echo esc_html( get_the_title( $pid ) ); ?></a></h3>
						<p class="blog-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt( $dgc_p ), 22 ) ); ?></p>
						<a href="<?php echo esc_url( get_permalink( $pid ) ); ?>" class="blog-card__more">Đọc tiếp &rarr;</a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>

		<?php if ( $dgc_cats ) : ?>
		<div class="author-topics">
			<p class="author-topics__label">Xem toàn bộ nội dung theo cụm chủ đề:</p>
			<div class="author-topics__list">
				<?php foreach ( $dgc_cats as $c ) : ?>
					<a class="author-topic-chip" href="<?php echo esc_url( get_category_link( $c ) ); ?>"><?php echo esc_html( $c->name ); ?> <em><?php echo (int) $c->count; ?></em></a>
				<?php endforeach; ?>
				<a class="author-topic-chip author-topic-chip--all" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">Tất cả bài viết &rarr;</a>
			</div>
		</div>
		<?php endif; ?>
	</div>
</section>
<?php endif; ?>

<section class="sec-tight"><div class="wrap"><div class="cta-band">
	<div><h2>Cần triển khai off-page SEO thực tế?</h2><p>DigicomVN hỗ trợ Textlink, Backlink, Guest Post và Booking báo &amp; PR cho doanh nghiệp của bạn.</p></div>
	<div class="cta-actions"><a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a><a class="btn btn-navy" href="<?php echo esc_url( home_url( '/bang-gia/' ) ); ?>">Xem bảng giá</a></div>
</div></div></section>

<?php get_footer(); ?>
