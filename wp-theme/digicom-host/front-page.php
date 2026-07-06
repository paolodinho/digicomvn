<?php
/**
 * Trang chu Digicom - dich vu Textlink, Backlink, Guest Post, Booking bao & PR.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>

<!-- 02. HERO -->
<section class="hero hero-split" id="dich-vu">
	<div class="wrap">
		<div class="hero-grid">
			<div class="hero-copy">
				<span class="eyebrow">Textlink &middot; Backlink &middot; Guest Post &middot; Booking báo &amp; PR</span>
				<h1><?php echo esc_html( dgc( 'hero_title' ) ); ?></h1>
				<p class="lead"><?php echo esc_html( dgc( 'hero_sub' ) ); ?></p>

				<div class="hero-cta-row">
					<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/dat-bai/' ) ); ?>">Nhận báo giá</a>
					<a class="btn-text-link" href="#services">Xem dịch vụ &rarr;</a>
				</div>

				<div class="trust-row">
					<div class="t"><b>Site</b> chọn lọc theo chỉ số</div>
					<div class="t"><b>Báo giá</b> minh bạch</div>
					<div class="t"><b>Hỗ trợ</b> tư vấn tận tình</div>
				</div>
			</div>
			<div class="hero-media">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/team-photo.jpg' ); ?>" alt="Đội ngũ Digicom" loading="eager" width="720" height="480">
			</div>
		</div>

		<div class="search-card">
			<div class="tld-row" style="justify-content:center">
				<a class="tld-chip" href="<?php echo esc_url( home_url( '/dich-vu/mua-textlink/' ) ); ?>">Mua Textlink</a>
				<a class="tld-chip" href="<?php echo esc_url( home_url( '/dich-vu/dich-vu-backlink/' ) ); ?>">Dịch vụ Backlink</a>
				<a class="tld-chip" href="<?php echo esc_url( home_url( '/dich-vu/guest-post/' ) ); ?>">Guest Post</a>
				<a class="tld-chip" href="<?php echo esc_url( home_url( '/dich-vu/booking-bao-pr/' ) ); ?>">Booking báo &amp; PR</a>
			</div>
		</div>
	</div>
</section>

<!-- 03. PROMOS -->
<?php
$promo_icons = array(
	'M20 6 9 17l-5-5',
	'M12 2 4 6v6c0 5 3.4 8.4 8 10 4.6-1.6 8-5 8-10V6z',
	'M12 8v4l3 3M12 3a9 9 0 1 0 .01 0z',
	'M3 12h4l3 8 4-16 3 8h4',
);
?>
<section class="sec-tight">
	<div class="wrap">
		<div class="promos">
			<?php $pi = 0; foreach ( dgc_lines( 'promos' ) as $p ) : ?>
				<div class="promo">
					<span class="pico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="<?php echo esc_attr( $promo_icons[ $pi % count( $promo_icons ) ] ); ?>"/></svg></span>
					<div class="pt"><?php echo esc_html( $p[0] ?? '' ); ?></div>
					<div class="pd"><?php echo esc_html( $p[1] ?? '' ); ?></div>
				</div>
			<?php $pi++; endforeach; ?>
		</div>
	</div>
</section>

<!-- 04. BANG GIA DICH VU (rut gon) -->
<section class="sec">
	<div class="wrap">
		<div class="center" style="margin-bottom:36px">
			<span class="eyebrow">Bảng giá dịch vụ</span>
			<h2>4 dịch vụ off-page SEO chính</h2>
			<p class="muted">Giá cụ thể theo yêu cầu, site/báo và khối lượng - liên hệ để nhận báo giá chi tiết.</p>
		</div>
		<div class="dom-grid">
			<?php foreach ( dgc_lines( 'domain_tlds' ) as $d ) :
				$name = $d[0] ?? ''; $price = $d[1] ?? ''; $badge = $d[2] ?? '';
				if ( $name === '' ) continue; ?>
				<div class="dom-card">
					<div class="tld"><?php echo esc_html( $name ); ?></div>
					<div class="badge"><?php echo esc_html( $badge ); ?></div>
					<div class="price"><?php echo esc_html( $price ); ?></div>
					<a class="btn btn-ghost btn-sm" href="#lien-he">Nhận báo giá</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 05. GOI DICH VU CHI TIET -->
<section class="sec" id="goi-dich-vu" style="background:#fff;border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:42px">
			<span class="eyebrow">Chi tiết gói</span>
			<h2>Digicom triển khai như thế nào</h2>
			<p class="muted">Mỗi dịch vụ có quy trình chọn lọc site/báo và bàn giao riêng, đảm bảo minh bạch.</p>
		</div>
		<div class="host-grid">
			<?php foreach ( dgc_lines( 'hosting_plans' ) as $h ) :
				$name = $h[0] ?? ''; $price = $h[1] ?? ''; $feats = $h[2] ?? ''; $feat = ( ( $h[3] ?? '0' ) === '1' );
				if ( $name === '' ) continue; ?>
				<div class="host-card<?php echo $feat ? ' feat' : ''; ?>">
					<?php if ( $feat ) : ?><span class="tag-feat">Được chọn nhiều nhất</span><?php endif; ?>
					<div class="pname"><?php echo esc_html( $name ); ?></div>
					<div class="pprice"><?php echo esc_html( $price ); ?></div>
					<ul>
						<?php foreach ( array_filter( array_map( 'trim', explode( ';', $feats ) ) ) as $f ) : ?>
							<li><?php echo esc_html( $f ); ?></li>
						<?php endforeach; ?>
					</ul>
					<a class="btn <?php echo $feat ? 'btn-primary' : 'btn-navy'; ?>" href="#lien-he">Nhận tư vấn</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 06. DICH VU THEO NHOM -->
<?php
$svc_meta = array(
	'Mua Textlink'          => array( 'eyebrow' => 'Textlink', 'path' => 'M13.5 6.5L17 3a4 4 0 1 1 5.5 5.5L19 12M10.5 17.5L7 21a4 4 0 1 1-5.5-5.5L5 12M8 16l8-8' ),
	'Dịch vụ Backlink'      => array( 'eyebrow' => 'Backlink', 'path' => 'M4 19V10M10 19V5M16 19v-6M20 19H3' ),
	'Guest Post'            => array( 'eyebrow' => 'Guest Post', 'path' => 'M4 4h16v16H4zM8 9h8M8 13h8M8 17h5' ),
	'Booking báo & PR'      => array( 'eyebrow' => 'Booking PR', 'path' => 'M12 3l7 4v5c0 4-3 7-7 8-4-1-7-4-7-8V7z' ),
);
?>
<section class="sec" id="services" style="background:#fff;border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:40px">
			<span class="eyebrow">Dịch vụ của Digicom</span>
			<h2>Off-page SEO trọn gói cho doanh nghiệp</h2>
			<p class="muted">Từ mua textlink, backlink, guest post đến booking đăng bài PR trên báo điện tử.</p>
		</div>
		<div class="svc-groups">
			<?php foreach ( dgc_service_groups() as $g ) :
				$meta = $svc_meta[ $g['title'] ] ?? array( 'eyebrow' => '', 'path' => 'M5 12h14' ); ?>
				<div class="svc-group">
					<div class="svc-ghead">
						<span class="svc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="<?php echo esc_attr( $meta['path'] ); ?>"/></svg></span>
						<h3><?php echo esc_html( $g['title'] ); ?></h3>
					</div>
					<ul class="svc-list">
						<?php foreach ( $g['items'] as $it ) : ?>
							<li>
								<span class="svc-name"><?php echo esc_html( $it['name'] ); ?></span>
								<span class="svc-desc"><?php echo esc_html( $it['desc'] ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 07. REASONS -->
<section class="sec band-navy">
	<div class="wrap">
		<div class="center">
			<span class="eyebrow">Vì sao chọn Digicom</span>
			<h2>Site chọn lọc, báo giá minh bạch</h2>
		</div>
		<div class="reason-grid">
			<?php $i = 1; foreach ( dgc_lines( 'reasons' ) as $r ) : ?>
				<div class="reason">
					<div class="rnum">0<?php echo $i++; ?></div>
					<h3><?php echo esc_html( $r[0] ?? '' ); ?></h3>
					<p><?php echo esc_html( $r[1] ?? '' ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 07a. DAU BAO CO THE DAT BAI -->
<section class="sec press-strip">
	<div class="wrap">
		<div class="center" style="margin-bottom:22px">
			<span class="eyebrow">Mạng lưới báo chí</span>
			<h2>Đầu báo Digicom hỗ trợ đặt bài, booking PR</h2>
			<p class="muted" style="max-width:600px;margin:8px auto 0">Danh sách rút gọn, xem đầy đủ tại <a href="<?php echo esc_url( home_url( '/bang-gia/' ) ); ?>" style="color:var(--action);font-weight:600">Bảng giá</a>.</p>
		</div>
		<div class="press-grid">
			<?php foreach ( dgc_lines( 'press_partners' ) as $pp ) : if ( empty( $pp[0] ) ) continue;
				$logo_file = trim( $pp[1] ?? '' );
				$logo_url  = $logo_file ? content_url( 'uploads/press-logos/' . $logo_file ) : '';
			?>
				<div class="press-chip">
					<?php if ( $logo_url ) : ?>
						<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $pp[0] ); ?>" loading="lazy">
					<?php endif; ?>
					<span><?php echo esc_html( $pp[0] ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 07b. TESTIMONIALS -->
<section class="sec" id="danh-gia">
	<div class="wrap">
		<div class="center" style="margin-bottom:38px">
			<span class="eyebrow">Khách hàng</span>
			<h2>Khách hàng nói về Digicom</h2>
		</div>
		<div class="tm-carousel owl-carousel">
			<?php foreach ( dgc_lines( 'testimonials' ) as $t ) :
				$quote = $t[0] ?? ''; $who = $t[1] ?? ''; $svc = $t[2] ?? '';
				if ( $quote === '' ) continue;
				$initial = function_exists( 'mb_substr' ) ? mb_strtoupper( mb_substr( $who, 0, 1 ) ) : strtoupper( substr( $who, 0, 1 ) ); ?>
				<figure class="tm">
					<div class="tm-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
					<blockquote><?php echo esc_html( $quote ); ?></blockquote>
					<figcaption>
						<span class="tm-avatar" aria-hidden="true"><?php echo esc_html( $initial ); ?></span>
						<span>
							<span class="tm-who"><?php echo esc_html( $who ); ?></span>
							<?php if ( $svc ) : ?><span class="tm-svc"><?php echo esc_html( $svc ); ?></span><?php endif; ?>
						</span>
					</figcaption>
				</figure>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 08. CTA BAND -->
<section class="sec-tight">
	<div class="wrap">
		<div class="cta-band">
			<div>
				<h2>Chưa biết chọn dịch vụ nào?</h2>
				<p>Để đội ngũ Digicom tư vấn miễn phí gói Textlink, Backlink, Guest Post hoặc Booking báo PR phù hợp.</p>
			</div>
			<div class="cta-actions">
				<a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a>
				<a class="btn btn-navy" href="https://zalo.me/<?php echo esc_attr( preg_replace( '/[^0-9]/', '', dgc( 'zalo' ) ) ); ?>">Chat Zalo</a>
			</div>
		</div>
	</div>
</section>

<!-- 09. FAQ -->
<section class="sec" id="faq">
	<div class="wrap">
		<div class="center" style="margin-bottom:34px">
			<span class="eyebrow">Hỗ trợ</span>
			<h2>Câu hỏi thường gặp</h2>
		</div>
		<div class="faq">
			<?php foreach ( dgc_lines( 'faqs' ) as $f ) : ?>
				<details>
					<summary><?php echo esc_html( $f[0] ?? '' ); ?></summary>
					<div class="a"><?php echo esc_html( $f[1] ?? '' ); ?></div>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 10. TIN TUC & SU KIEN -->
<?php
$news = new WP_Query( array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => 3,
	'ignore_sticky_posts' => 1,
) );
if ( $news->have_posts() ) : ?>
<section class="sec" id="tin-tuc" style="background:#fff;border-top:1px solid var(--line)">
	<div class="wrap">
		<div class="news-head">
			<div>
				<span class="eyebrow">Tin tức &amp; sự kiện</span>
				<h2>Tin mới từ Digicom</h2>
			</div>
			<a class="btn btn-ghost btn-sm" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ) ); ?>">Xem tất cả</a>
		</div>
		<div class="news-grid">
			<?php while ( $news->have_posts() ) : $news->the_post(); ?>
				<article class="news">
					<a class="news-thumb" href="<?php the_permalink(); ?>">
						<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'medium_large' ); else : ?>
							<span class="news-thumb-ph">Digicom</span>
						<?php endif; ?>
					</a>
					<div class="news-body">
						<time class="news-date"><?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?></time>
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
					</div>
				</article>
			<?php endwhile; ?>
		</div>
	</div>
</section>
<?php endif; wp_reset_postdata(); ?>

<?php get_footer(); ?>
