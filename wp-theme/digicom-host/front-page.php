<?php
/**
 * Trang chu DigicomVN - thiet ke lai 2026-10-28 theo phong cach seongon.com.
 * Dinh vi: SEO la dich vu chu dao; booking bao PR, ten mien + hosting, phan mem SEO la dich vu ho tro.
 * Moi chu hien thi sua o WP Admin > DigicomVN (muc 2 Hero, 2b Trang chu, 5 FAQ...).
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

$dgc_img = get_template_directory_uri() . '/assets/images/';
$dgc_ico = array(
	'M4 19V10M10 19V5M16 19v-6M20 19H3',
	'M12 3v3M12 18v3M3 12h3M18 12h3M6 6l2 2M16 16l2 2M6 18l2-2M16 8l2-2M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8z',
	'M12 21s-7-6.2-7-11a7 7 0 1 1 14 0c0 4.8-7 11-7 11zM12 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z',
	'M12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18zM3 12h18M12 3c2.5 2.5 3.8 5.6 3.8 9s-1.3 6.5-3.8 9c-2.5-2.5-3.8-5.6-3.8-9S9.5 5.5 12 3z',
	'M4 4h16v16H4zM8 9h8M8 13h8M8 17h5',
	'M13.5 6.5L17 3a4 4 0 1 1 5.5 5.5L19 12M10.5 17.5L7 21a4 4 0 1 1-5.5-5.5L5 12M8 16l8-8',
	'M2 9l10-5 10 5-10 5zM6 11v5c3 2 9 2 12 0v-5',
);
$dgc_svg = function ( $d ) {
	return '<span class="sg-ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="' . esc_attr( $d ) . '"/></svg></span>';
};
?>
<div class="sg-home">

<!-- 01. HERO -->
<section class="sg-hero" id="dich-vu">
	<div class="wrap">
		<div class="sg-hero-row">
			<div>
				<span class="sg-eyebrow"><?php echo esc_html( dgc( 'hero_kicker' ) ); ?></span>
				<h1><?php echo dgc_em( dgc( 'hero_title' ) ); // phpcs:ignore ?></h1>
				<p class="sg-lead"><?php echo esc_html( dgc( 'hero_sub' ) ); ?></p>
				<div class="sg-hero-cta">
					<a class="sg-btn sg-btn--light" href="#lien-he"><?php echo dgc_arrow(); // phpcs:ignore ?>Nhận audit SEO miễn phí</a>
					<a class="sg-btn sg-btn--line" href="<?php echo esc_url( home_url( '/dich-vu-seo/' ) ); ?>"><?php echo dgc_arrow(); // phpcs:ignore ?>Xem dịch vụ SEO</a>
				</div>
			</div>
			<div class="sg-hero-media">
				<img
					src="<?php echo esc_url( $dgc_img . 'hero-team-1280.jpg?v=2' ); ?>"
					srcset="<?php echo esc_url( $dgc_img . 'hero-team-640.jpg?v=2' ); ?> 640w, <?php echo esc_url( $dgc_img . 'hero-team-960.jpg?v=2' ); ?> 960w, <?php echo esc_url( $dgc_img . 'hero-team-1280.jpg?v=2' ); ?> 1280w"
					sizes="(max-width: 900px) 100vw, 42vw" width="1280" height="767"
					alt="Đội ngũ DigicomVN trao đổi kế hoạch SEO tại văn phòng" fetchpriority="high">
				<div class="sg-float"><b>6 hạng mục</b>mỗi dự án SEO đều có đầu ra bàn giao kiểm tra được</div>
			</div>
		</div>
		<?php $dgc_stats = array_slice( array_filter( dgc_lines( 'hero_stats' ), fn( $st ) => ! empty( $st[0] ) ), 0, 5 ); ?>
		<?php if ( $dgc_stats ) : ?>
		<div class="sg-stats">
			<?php foreach ( $dgc_stats as $st ) : ?>
				<div class="sg-stat"><b><?php echo esc_html( $st[0] ); ?></b><?php echo esc_html( $st[1] ?? '' ); ?></div>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
	</div>
</section>

<?php if ( function_exists( 'dgc_ai_chat_box' ) ) dgc_ai_chat_box(); ?>

<!-- 02. VE DIGICOMVN -->
<section class="sg-sec" id="ve-digicom">
	<div class="wrap sg-about">
		<div>
			<span class="sg-eyebrow">Về DigicomVN</span>
			<h2 class="sg-h"><?php echo dgc_em( dgc( 'home_about_title' ) ); // phpcs:ignore ?></h2>
			<p class="sg-lead"><?php echo esc_html( dgc( 'home_about_text' ) ); ?></p>
			<ul class="sg-checks">
				<?php foreach ( dgc_lines( 'home_about_points' ) as $pt ) : if ( empty( $pt[0] ) ) continue; ?>
					<li><b><?php echo esc_html( $pt[0] ); ?></b><?php echo ! empty( $pt[1] ) ? ' ' . esc_html( $pt[1] ) : ''; ?></li>
				<?php endforeach; ?>
			</ul>
			<a class="sg-btn sg-btn--ghost" href="<?php echo esc_url( home_url( '/ve-digicom/' ) ); ?>"><?php echo dgc_arrow(); // phpcs:ignore ?>Tìm hiểu về DigicomVN</a>
		</div>
		<div class="sg-about-media">
			<img src="<?php echo esc_url( $dgc_img . 'team-digicom-1400.jpg' ); ?>" width="1400" height="933" loading="lazy" alt="Đội ngũ DigicomVN">
		</div>
	</div>
</section>

<!-- 03. GIAI PHAP SEO -->
<?php
$dgc_sols = array();
foreach ( dgc_lines( 'home_solutions' ) as $s ) {
	if ( empty( $s[0] ) || empty( $s[1] ) || ! dgc_page_live( $s[1] ) ) continue;
	$dgc_sols[] = $s;
}
?>
<?php if ( $dgc_sols ) : ?>
<section class="sg-sec sg-sec--cyan" id="services">
	<div class="wrap">
		<div class="sg-head sg-head--split">
			<div>
				<span class="sg-eyebrow">Giải pháp SEO</span>
				<h2 class="sg-h">Giải pháp SEO <em>toàn diện</em> cho từng mục tiêu</h2>
			</div>
			<p class="sg-lead">Website mới cần nền tảng, website đã có lượt truy cập cần đúng nhóm từ mang doanh thu. Chọn hình thức phù hợp, DigicomVN audit miễn phí rồi đề xuất phạm vi cụ thể.</p>
		</div>
		<div class="sg-sol">
			<?php foreach ( $dgc_sols as $i => $s ) : ?>
				<?php if ( 0 === $i ) : ?>
					<a class="sg-card sg-card--feat" href="<?php echo esc_url( home_url( $s[1] ) ); ?>">
						<?php echo $dgc_svg( $dgc_ico[0] ); // phpcs:ignore ?>
						<h3><?php echo esc_html( $s[0] ); ?></h3>
						<p><?php echo esc_html( $s[2] ?? '' ); ?></p>
						<ul><li>Audit kỹ thuật</li><li>Nghiên cứu từ khoá</li><li>Tối ưu onpage</li><li>Nội dung theo cụm chủ đề</li><li>Off-page từ báo và site cùng ngành</li><li>Báo cáo tháng từ Search Console</li></ul>
						<span class="sg-more">Xem chi tiết dịch vụ</span>
					</a>
				<?php else : ?>
					<a class="sg-card" href="<?php echo esc_url( home_url( $s[1] ) ); ?>">
						<?php echo $dgc_svg( $dgc_ico[ $i % count( $dgc_ico ) ] ); // phpcs:ignore ?>
						<h3><?php echo esc_html( $s[0] ); ?></h3>
						<p><?php echo esc_html( $s[2] ?? '' ); ?></p>
						<span class="sg-more">Xem chi tiết</span>
					</a>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- 04. PHUONG TRINH SEO -->
<?php $dgc_eq = array_values( array_filter( dgc_lines( 'home_formula' ), fn( $x ) => ! empty( $x[0] ) ) ); ?>
<?php if ( count( $dgc_eq ) >= 4 ) : ?>
<section class="sg-sec">
	<div class="wrap">
		<div class="sg-head sg-head--c">
			<span class="sg-eyebrow">Cách DigicomVN làm SEO</span>
			<h2 class="sg-h">Thứ hạng bền đến từ <em>ba trụ cột</em> làm cùng lúc</h2>
		</div>
		<div class="sg-eq">
			<div class="sg-eq-total"><b><?php echo esc_html( $dgc_eq[0][0] ); ?></b><span><?php echo esc_html( $dgc_eq[0][1] ?? '' ); ?></span></div>
			<?php for ( $k = 1; $k <= 3; $k++ ) : ?>
				<div class="sg-eq-op" aria-hidden="true"><?php echo 1 === $k ? '=' : '+'; ?></div>
				<div class="sg-card"><h3><?php echo esc_html( $dgc_eq[ $k ][0] ); ?></h3><p><?php echo esc_html( $dgc_eq[ $k ][1] ?? '' ); ?></p></div>
			<?php endfor; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- 05. QUY TRINH -->
<?php $dgc_proc = array_filter( dgc_lines( 'home_process' ), fn( $x ) => ! empty( $x[0] ) ); ?>
<?php if ( $dgc_proc ) : ?>
<section class="sg-sec sg-band" id="quy-trinh">
	<div class="wrap">
		<div class="sg-head sg-head--split">
			<div>
				<span class="sg-eyebrow">Quy trình</span>
				<h2 class="sg-h">Quy trình SEO <em><?php echo esc_html( count( $dgc_proc ) ); ?> bước</em> minh bạch</h2>
			</div>
			<p class="sg-lead">Mỗi bước kết thúc bằng một tài liệu doanh nghiệp duyệt trước khi chuyển sang bước sau. Không có việc nào làm mà doanh nghiệp không biết.</p>
		</div>
		<ol class="sg-steps">
			<?php $n = 0; foreach ( $dgc_proc as $p ) : $n++; ?>
				<li><span class="sg-num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $n ) ); ?></span><h3><?php echo esc_html( $p[0] ); ?></h3><p><?php echo esc_html( $p[1] ?? '' ); ?></p></li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
<?php endif; ?>

<!-- 06. DICH VU HO TRO SEO -->
<?php
$dgc_dm_min = dgc_min_price( dgc_ten_mien_rows(), 'gia' );
$dgc_hg_min = 0;
foreach ( dgc_hosting_rows() as $dgc_rows ) { $v = dgc_min_price( $dgc_rows, 'thang' ); if ( $v && ( ! $dgc_hg_min || $v < $dgc_hg_min ) ) $dgc_hg_min = $v; }
$dgc_others = array(
	array( 'Booking báo &amp; truyền thông', array( array( 'Booking truyền hình', '/booking-truyen-hinh/' ), array( 'Quảng cáo phát thanh', '/quang-cao-phat-thanh/' ), array( 'Booking fanpage', '/booking-fanpage/' ), array( 'Booking KOL, KOC', '/booking-kol-koc/' ) ) ),
	array( 'Liên kết off-page', array( array( 'Mua Textlink', '/mua-textlink/' ), array( 'Guest Post', '/guest-post/' ), array( 'Backlink Social Entity', '/backlink-social-entity/' ), array( 'Backlink quốc tế', '/backlink-quoc-te/' ), array( 'Dịch vụ Toplist', '/dich-vu-toplist/' ) ) ),
);
?>
<section class="sg-sec sg-sec--grey" id="dich-vu-ho-tro">
	<div class="wrap">
		<div class="sg-head sg-head--split">
			<div>
				<span class="sg-eyebrow">Dịch vụ hỗ trợ SEO</span>
				<h2 class="sg-h">Truyền thông và hạ tầng <em>đi cùng SEO</em></h2>
			</div>
			<p class="sg-lead">Ba nhóm dịch vụ khách SEO hay cần thêm. Giá niêm yết công khai, đặt riêng hoặc gộp vào dự án SEO đều được.</p>
		</div>
		<div class="sg-side">
			<a class="sg-card" href="<?php echo esc_url( home_url( '/booking-bao-pr/' ) ); ?>">
				<span class="sg-tag">Booking báo</span>
				<h3>Booking báo &amp; PR</h3>
				<p>Đặt bài PR trên báo điện tử trong nước và quốc tế. Xem giá từng đầu báo, từng vị trí đăng trước khi đặt.</p>
				<span class="sg-more">Xem bảng giá đầu báo</span>
			</a>
			<div class="sg-card">
				<span class="sg-tag">Hạ tầng</span>
				<h3>Tên miền &amp; Hosting</h3>
				<?php if ( $dgc_dm_min || $dgc_hg_min ) : ?>
					<p class="sg-price"><?php if ( $dgc_dm_min ) : ?>Tên miền&nbsp;từ&nbsp;<b><?php echo esc_html( dgc_vnd( $dgc_dm_min ) ); ?></b><?php endif; ?><?php if ( $dgc_dm_min && $dgc_hg_min ) echo ' &middot; '; ?><?php if ( $dgc_hg_min ) : ?>hosting&nbsp;từ&nbsp;<b><?php echo esc_html( dgc_vnd( $dgc_hg_min ) ); ?></b>/tháng<?php endif; ?></p>
				<?php endif; ?>
				<form class="sg-dsearch" action="<?php echo esc_url( home_url( '/ten-mien/' ) ); ?>" method="get" role="search">
					<input type="text" name="d" placeholder="thuonghieu.vn" aria-label="Tên miền cần kiểm tra" required>
					<button type="submit">Kiểm tra</button>
				</form>
				<div class="sg-links2"><a href="<?php echo esc_url( home_url( '/ten-mien/' ) ); ?>">Bảng giá tên miền &rarr;</a><a href="<?php echo esc_url( home_url( '/hosting/' ) ); ?>">Bảng giá hosting &rarr;</a></div>
			</div>
			<?php if ( dgc_page_live( '/phan-mem-seo/' ) ) : ?>
			<a class="sg-card" href="<?php echo esc_url( home_url( '/phan-mem-seo/' ) ); ?>">
				<span class="sg-tag">Công cụ</span>
				<h3>Phần mềm SEO</h3>
				<p>Tài khoản Ahrefs, Semrush và công cụ SEO chính hãng, hướng dẫn dùng đúng việc cho đội SEO nội bộ.</p>
				<span class="sg-more">Xem phần mềm SEO</span>
			</a>
			<?php endif; ?>
		</div>
		<dl class="sg-others sg-others--light">
			<?php foreach ( $dgc_others as $g ) : ?>
				<div><dt><?php echo wp_kses_post( $g[0] ); ?></dt><dd>
					<?php foreach ( $g[1] as $s ) : if ( ! dgc_page_live( $s[1] ) ) continue; ?><a href="<?php echo esc_url( home_url( $s[1] ) ); ?>"><?php echo esc_html( $s[0] ); ?></a><?php endforeach; ?>
				</dd></div>
			<?php endforeach; ?>
		</dl>
	</div>
</section>

<!-- 07. KHACH HANG -->
<?php include get_template_directory() . '/inc/blk-testimonials.php'; ?>

<?php $dgc_clients = array_filter( dgc_lines( 'clients' ), fn( $c ) => ! empty( $c[0] ) ); ?>
<?php if ( $dgc_clients ) : ?>
<section class="sg-sec sg-sec--tight">
	<div class="wrap">
		<div class="sg-head sg-head--c">
			<span class="sg-eyebrow">Khách hàng &amp; đối tác</span>
			<h2 class="sg-h">Thương hiệu đã <em>tin tưởng</em> DigicomVN</h2>
		</div>
		<div class="sg-logos">
			<?php foreach ( array_slice( $dgc_clients, 0, 12 ) as $c ) : $c_file = trim( $c[1] ?? '' ); ?>
				<div class="sg-logo" title="<?php echo esc_attr( $c[0] ); ?>">
					<?php if ( $c_file ) : ?><img src="<?php echo esc_url( content_url( 'uploads/client-logos/' . $c_file ) ); ?>" alt="<?php echo esc_attr( $c[0] ); ?>" loading="lazy"><?php else : ?><span><?php echo esc_html( $c[0] ); ?></span><?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php $dgc_mentions = array_filter( dgc_lines( 'press_mentions' ), fn( $m ) => ! empty( $m[0] ) ); ?>
<?php if ( $dgc_mentions ) : ?>
<section class="sg-sec sg-sec--tight sg-sec--cyan">
	<div class="wrap">
		<div class="sg-head sg-head--c">
			<span class="sg-eyebrow">Báo chí</span>
			<h2 class="sg-h">Báo chí <em>nói về</em> DigicomVN</h2>
		</div>
		<div class="sg-press">
			<?php foreach ( $dgc_mentions as $m ) :
				$m_url = trim( $m[1] ?? '' ); $m_file = trim( $m[2] ?? '' );
				$inner = $m_file ? '<img src="' . esc_url( content_url( 'uploads/press-logos/' . $m_file ) ) . '" alt="' . esc_attr( $m[0] ) . '" loading="lazy">' : '<span>' . esc_html( $m[0] ) . '</span>';
				if ( $m_url ) : ?>
					<a href="<?php echo esc_url( $m_url ); ?>" target="_blank" rel="nofollow noopener" title="<?php echo esc_attr( $m[0] ); ?>"><?php echo $inner; // phpcs:ignore ?><small>Đọc bài &#8599;</small></a>
				<?php else : ?>
					<span title="<?php echo esc_attr( $m[0] ); ?>"><?php echo $inner; // phpcs:ignore ?></span>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- 08. FAQ -->
<?php $dgc_faqs = dgc_home_faq_items(); ?>
<?php if ( $dgc_faqs ) : ?>
<section class="sg-sec" id="faq">
	<div class="wrap sg-head--split" style="align-items:start">
		<div>
			<span class="sg-eyebrow">Hỏi đáp</span>
			<h2 class="sg-h">Câu hỏi <em>thường gặp</em></h2>
			<p class="sg-lead">Chưa thấy câu trả lời bạn cần? Gọi <a href="tel:<?php echo esc_attr( dgc_tel() ); ?>" style="color:var(--sg-blue);font-weight:700"><?php echo esc_html( dgc( 'hotline' ) ); ?></a> hoặc gửi yêu cầu ở cuối trang.</p>
			<?php $dgc_faq_pg = get_page_by_path( 'cau-hoi-thuong-gap' ); if ( $dgc_faq_pg && 'publish' === $dgc_faq_pg->post_status ) : ?>
				<a class="sg-btn sg-btn--ghost" href="<?php echo esc_url( get_permalink( $dgc_faq_pg ) ); ?>"><?php echo dgc_arrow(); ?>Xem tất cả câu hỏi</a>
			<?php endif; ?>
		</div>
		<div class="sg-faq">
			<?php foreach ( $dgc_faqs as $f ) : ?>
				<details><summary><?php echo esc_html( $f[0] ); ?></summary><div class="a"><?php echo esc_html( $f[1] ); ?></div></details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- 09. KIEN THUC SEO -->
<?php
$news = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 3, 'ignore_sticky_posts' => 1 ) );
if ( $news->have_posts() ) : ?>
<section class="sg-sec sg-sec--grey" id="tin-tuc">
	<div class="wrap">
		<div class="sg-head sg-head--split">
			<div>
				<span class="sg-eyebrow">Kiến thức</span>
				<h2 class="sg-h">Kiến thức <em>SEO và truyền thông</em></h2>
			</div>
			<p class="sg-lead"><a class="sg-btn sg-btn--ghost" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ) ); ?>"><?php echo dgc_arrow(); // phpcs:ignore ?>Xem tất cả bài viết</a></p>
		</div>
		<div class="sg-news">
			<?php while ( $news->have_posts() ) : $news->the_post(); ?>
				<article>
					<?php
					$dgc_th = has_post_thumbnail() ? get_the_post_thumbnail( null, 'medium_large', array( 'loading' => 'lazy' ) ) : '';
					if ( ! $dgc_th && preg_match( '/<img[^>]+src=["\']([^"\']+)["\']/i', get_post_field( 'post_content' ), $dgc_m ) ) {
						$dgc_th = '<img src="' . esc_url( $dgc_m[1] ) . '" alt="" loading="lazy" decoding="async">';
					}
					if ( $dgc_th ) : ?>
						<a class="th" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true"><?php echo $dgc_th; // phpcs:ignore ?></a>
					<?php endif; ?>
					<div class="bd">
						<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?></time>
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
					</div>
				</article>
			<?php endwhile; ?>
		</div>
	</div>
</section>
<?php endif; wp_reset_postdata(); ?>

<!-- 10. LIEN HE -->
<section class="sg-sec">
	<div class="wrap">
		<div class="sg-contact">
			<div class="sg-contact-media" style="background-image:url('<?php echo esc_url( $dgc_img . 'agency-team-1-800.jpg' ); ?>')">
				<span class="sg-eyebrow" style="color:var(--sg-mint)">Liên hệ</span>
				<h2>Nhận <em>audit SEO</em> miễn phí cho website của bạn</h2>
				<p>Gửi địa chỉ website và mục tiêu, DigicomVN kiểm tra hiện trạng rồi đề xuất việc nên làm trước, kèm phạm vi và chi phí.</p>
				<ul>
					<li>Hotline: <a href="tel:<?php echo esc_attr( dgc_tel() ); ?>"><?php echo esc_html( dgc( 'hotline' ) ); ?></a></li>
					<li>Email: <a href="mailto:<?php echo esc_attr( dgc( 'email' ) ); ?>"><?php echo esc_html( dgc( 'email' ) ); ?></a></li>
				</ul>
			</div>
			<div class="sg-contact-form">
				<?php
				$dgc_form_title   = 'Đăng ký audit SEO miễn phí';
				$dgc_form_btn     = 'Gửi yêu cầu audit';
				$dgc_form_service = 'Dịch vụ SEO tổng thể';
				include get_template_directory() . '/inc/form-lead.php';
				?>
			</div>
		</div>
	</div>
</section>

</div>
<?php get_footer(); ?>
