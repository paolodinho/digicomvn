<?php
/**
 * Trang chu Digicom - ban ten mien & hosting.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>

<!-- 02. HERO + DOMAIN SEARCH (tam diem trang chu, luon o man hinh dau) -->
<section class="hero" id="domains">
	<div class="wrap hero-inner">
		<span class="eyebrow">Website &middot; Tên miền &middot; Hosting &middot; Bản quyền phần mềm &middot; SEO</span>
		<h1><?php echo esc_html( dgc( 'hero_title' ) ); ?></h1>
		<p class="lead"><?php echo esc_html( dgc( 'hero_sub' ) ); ?></p>

		<div class="search-card">
			<form class="search-box" onsubmit="window.open('https://www.pavietnam.vn/','_blank');return false;">
				<input type="text" placeholder="Nhập tên miền bạn muốn tìm..." aria-label="Tên miền">
				<button type="submit">Kiểm tra</button>
			</form>
			<div class="tld-row">
				<?php foreach ( dgc_lines( 'domain_tlds' ) as $d ) :
					$tld   = $d[0] ?? '';
					$price = $d[1] ?? '';
					if ( $tld === '' ) continue; ?>
					<span class="tld-chip"><?php echo esc_html( $tld ); ?> <b><?php echo esc_html( $price ); ?></b></span>
				<?php endforeach; ?>
			</div>
			<p class="muted" style="font-size:12.5px;margin:10px 2px 0">Đăng ký tên miền và hosting qua đối tác PA Việt Nam - Digicom hỗ trợ tư vấn và kỹ thuật.</p>
		</div>

		<div class="trust-row">
			<div class="t"><b>Kích hoạt</b> tức thì</div>
			<div class="t"><b>SSL</b> miễn phí</div>
			<div class="t"><b>Hỗ trợ</b> 24/7</div>
		</div>
	</div>
</section>

<!-- 03. PROMOS -->
<section class="sec-tight">
	<div class="wrap">
		<div class="promos">
			<?php foreach ( dgc_lines( 'promos' ) as $p ) : ?>
				<div class="promo">
					<div class="pt"><?php echo esc_html( $p[0] ?? '' ); ?></div>
					<div class="pd"><?php echo esc_html( $p[1] ?? '' ); ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 04. DOMAIN PRICING -->
<section class="sec">
	<div class="wrap">
		<div class="center" style="margin-bottom:36px">
			<span class="eyebrow">Bảng giá tên miền</span>
			<h2>Chọn đuôi tên miền phù hợp</h2>
			<p class="muted">Giá đã bao gồm quản lý DNS và hỗ trợ chuyển về miễn phí.</p>
		</div>
		<div class="dom-grid">
			<?php foreach ( dgc_lines( 'domain_tlds' ) as $d ) :
				$tld = $d[0] ?? ''; $price = $d[1] ?? ''; $badge = $d[2] ?? '';
				if ( $tld === '' ) continue; ?>
				<div class="dom-card">
					<div class="tld"><?php echo esc_html( $tld ); ?></div>
					<div class="badge"><?php echo esc_html( $badge ); ?></div>
					<div class="price"><?php echo esc_html( $price ); ?></div>
					<div class="per">/ năm</div>
					<a class="btn btn-ghost btn-sm" href="https://www.pavietnam.vn/" target="_blank" rel="noopener">Đăng ký</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 05. HOSTING PLANS -->
<section class="sec" id="hosting" style="background:#fff;border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:42px">
			<span class="eyebrow">Web Hosting</span>
			<h2>Gói hosting tốc độ cao</h2>
			<p class="muted">Ổ cứng SSD, LiteSpeed, SSL miễn phí. Phù hợp từ website cá nhân đến doanh nghiệp.</p>
		</div>
		<div class="host-grid">
			<?php foreach ( dgc_lines( 'hosting_plans' ) as $h ) :
				$name = $h[0] ?? ''; $price = $h[1] ?? ''; $feats = $h[2] ?? ''; $feat = ( ( $h[3] ?? '0' ) === '1' );
				if ( $name === '' ) continue; ?>
				<div class="host-card<?php echo $feat ? ' feat' : ''; ?>">
					<?php if ( $feat ) : ?><span class="tag-feat">Phổ biến nhất</span><?php endif; ?>
					<div class="pname"><?php echo esc_html( $name ); ?></div>
					<div class="pprice"><?php echo esc_html( $price ); ?></div>
					<ul>
						<?php foreach ( array_filter( array_map( 'trim', explode( ';', $feats ) ) ) as $f ) : ?>
							<li><?php echo esc_html( $f ); ?></li>
						<?php endforeach; ?>
					</ul>
					<a class="btn <?php echo $feat ? 'btn-primary' : 'btn-navy'; ?>" href="https://www.pavietnam.vn/" target="_blank" rel="noopener">Chọn gói</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 06. DICH VU THEO NHOM -->
<?php
$svc_meta = array(
	'Hạ tầng & Website'    => array( 'eyebrow' => 'Hạ tầng', 'path' => 'M3 7h18M5 7v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7M9 11h6' ),
	'Bản quyền phần mềm'   => array( 'eyebrow' => 'License', 'path' => 'M12 3l7 4v5c0 4-3 7-7 8-4-1-7-4-7-8V7z' ),
	'Marketing & SEO'      => array( 'eyebrow' => 'Marketing', 'path' => 'M4 19V10M10 19V5M16 19v-6M20 19H3' ),
	'Tự động hóa'          => array( 'eyebrow' => 'Automation', 'path' => 'M12 8V4m0 0H8m4 0h4M6 12a6 6 0 1 0 12 0 6 6 0 0 0-12 0M12 12l3 2' ),
);
?>
<section class="sec" id="services" style="background:#fff;border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:40px">
			<span class="eyebrow">Dịch vụ của Digicom</span>
			<h2>Giải pháp số trọn gói cho doanh nghiệp</h2>
			<p class="muted">Từ hạ tầng website, bản quyền phần mềm đến marketing và tự động hóa.</p>
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
			<h2>Hạ tầng vững, hỗ trợ thật</h2>
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

<!-- 07b. TESTIMONIALS -->
<section class="sec" id="danh-gia">
	<div class="wrap">
		<div class="center" style="margin-bottom:38px">
			<span class="eyebrow">Khách hàng</span>
			<h2>Khách hàng nói về Digicom</h2>
		</div>
		<div class="tm-grid">
			<?php foreach ( dgc_lines( 'testimonials' ) as $t ) :
				$quote = $t[0] ?? ''; $who = $t[1] ?? ''; $svc = $t[2] ?? '';
				if ( $quote === '' ) continue; ?>
				<figure class="tm">
					<div class="tm-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
					<blockquote><?php echo esc_html( $quote ); ?></blockquote>
					<figcaption>
						<span class="tm-who"><?php echo esc_html( $who ); ?></span>
						<?php if ( $svc ) : ?><span class="tm-svc"><?php echo esc_html( $svc ); ?></span><?php endif; ?>
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
				<h2>Chưa biết chọn gói nào?</h2>
				<p>Để đội ngũ Digicom tư vấn miễn phí gói tên miền và hosting phù hợp với bạn.</p>
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
