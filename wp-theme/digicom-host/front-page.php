<?php
/**
 * Trang chu Digicom - gioi thieu cong ty va dich vu.
 * Tra cuu/bang gia ten mien va hosting nam o trang /ten-mien/ va /hosting/.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>

<!-- 01. HERO - GIOI THIEU CONG TY -->
<section class="hero">
	<div class="wrap hero-inner">
		<span class="eyebrow">Tên miền &middot; Hosting &middot; Marketing &amp; SEO</span>
		<h1><?php echo esc_html( dgc( 'hero_title' ) ); ?></h1>
		<p class="lead"><?php echo esc_html( dgc( 'hero_sub' ) ); ?></p>

		<div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap;margin-top:6px">
			<a class="btn btn-primary" href="#services">Xem dịch vụ</a>
			<a class="btn btn-ghost" href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">Liên hệ</a>
		</div>

		<div class="trust-row" style="margin-top:38px">
			<?php foreach ( dgc_lines( 'about_stats' ) as $s ) :
				$num = $s[0] ?? ''; $label = $s[1] ?? ''; if ( $num === '' ) continue; ?>
				<div class="t"><b style="font-size:20px"><?php echo esc_html( $num ); ?></b> <?php echo esc_html( $label ); ?></div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 02. VE DIGICOM - TEASER -->
<section class="sec-tight">
	<div class="wrap">
		<div class="center" style="max-width:760px;margin:0 auto">
			<span class="eyebrow">Về Digicom</span>
			<p class="muted" style="font-size:16.5px;line-height:1.75"><?php echo esc_html( dgc( 'about_teaser' ) ); ?></p>
			<a class="btn btn-ghost btn-sm" href="<?php echo esc_url( home_url( '/ve-digicom/' ) ); ?>" style="margin-top:12px">Tìm hiểu thêm về Digicom</a>
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

<!-- 04. DICH VU THEO NHOM -->
<?php
$svc_meta = array(
	'Tên miền & Hosting'   => array( 'path' => 'M3 7h18M5 7v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7M9 11h6', 'url' => home_url( '/ten-mien/' ), 'cta' => 'Xem tên miền & hosting' ),
	'Marketing & SEO'      => array( 'path' => 'M4 19V10M10 19V5M16 19v-6M20 19H3', 'url' => home_url( '/dich-vu/' ), 'cta' => 'Xem dịch vụ marketing' ),
);
?>
<section class="sec" id="services" style="background:#fff;border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:40px">
			<span class="eyebrow">Dịch vụ của Digicom</span>
			<h2>Giải pháp số trọn gói cho doanh nghiệp</h2>
			<p class="muted">Tên miền, hosting và các dịch vụ marketing off-page SEO.</p>
		</div>
		<div class="svc-groups" style="grid-template-columns:repeat(2,1fr);max-width:900px;margin:0 auto">
			<?php foreach ( dgc_service_groups() as $g ) :
				$meta = $svc_meta[ $g['title'] ] ?? array( 'path' => 'M5 12h14', 'url' => home_url( '/lien-he/' ), 'cta' => 'Tìm hiểu thêm' ); ?>
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
					<a class="btn btn-navy btn-sm" href="<?php echo esc_url( $meta['url'] ); ?>" style="margin:14px 0 16px;width:100%;justify-content:center"><?php echo esc_html( $meta['cta'] ); ?></a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 05. REASONS -->
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

<!-- 05b. BAO CHI NOI VE CHUNG TOI (demo - cho logo/ten bao that) -->
<section class="sec-tight">
	<div class="wrap">
		<div class="center" style="margin-bottom:22px">
			<span class="eyebrow">Báo chí nói về chúng tôi</span>
		</div>
		<div style="display:flex;gap:14px;flex-wrap:wrap;justify-content:center;opacity:.55">
			<?php foreach ( dgc_lines( 'press_logos' ) as $pr ) :
				$name = $pr[0] ?? ''; if ( $name === '' ) continue; ?>
				<div style="border:1px dashed var(--line-2);border-radius:var(--r-sm);padding:14px 26px;
					font-family:var(--font-display);font-weight:600;color:var(--ink-soft);font-size:14px">
					<?php echo esc_html( $name ); ?>
				</div>
			<?php endforeach; ?>
		</div>
		<p class="muted center" style="font-size:12.5px;margin-top:14px">Khu vực demo - cập nhật logo báo chí thật khi có bài đăng chính thức.</p>
	</div>
</section>

<!-- 06. TESTIMONIALS -->
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

<!-- 07. CTA BAND -->
<section class="sec-tight">
	<div class="wrap">
		<div class="cta-band">
			<div>
				<h2>Sẵn sàng hợp tác cùng Digicom?</h2>
				<p>Để lại thông tin, đội ngũ Digicom sẽ tư vấn giải pháp phù hợp cho doanh nghiệp của bạn.</p>
			</div>
			<div class="cta-actions">
				<a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a>
				<a class="btn btn-navy" href="https://zalo.me/<?php echo esc_attr( preg_replace( '/[^0-9]/', '', dgc( 'zalo' ) ) ); ?>">Chat Zalo</a>
			</div>
		</div>
	</div>
</section>

<!-- 08. FAQ -->
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

<!-- 09. TIN TUC & SU KIEN -->
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
