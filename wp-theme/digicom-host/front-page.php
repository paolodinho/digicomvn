<?php
/**
 * Trang chu DigicomVN - dich vu Textlink, Backlink, Guest Post, Booking bao & PR.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>

<!-- 02. HERO (bo cuc A: cat cheo bat doi xung) -->
<section class="hero hero-diag" id="dich-vu">
	<div class="hero-diag-row">
		<div class="hero-diag-copy">
			<div class="hero-diag-copy-in">
				<span class="eyebrow">Textlink &middot; Backlink &middot; Guest Post &middot; Booking báo &amp; PR</span>
				<h1><?php echo esc_html( dgc( 'hero_title' ) ); ?></h1>
				<p class="lead"><?php echo esc_html( dgc( 'hero_sub' ) ); ?></p>
				<div class="hero-cta-row">
					<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/dat-bai/' ) ); ?>">Nhận báo giá</a>
					<a class="btn-text-link" href="#services">Xem dịch vụ &rarr;</a>
				</div>
			</div>
		</div>
		<div class="hero-diag-media">
			<img
				src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/hero-team-1280.jpg' ); ?>"
				srcset="<?php echo esc_url( get_template_directory_uri() . '/assets/images/hero-team-640.jpg' ); ?> 640w, <?php echo esc_url( get_template_directory_uri() . '/assets/images/hero-team-960.jpg' ); ?> 960w, <?php echo esc_url( get_template_directory_uri() . '/assets/images/hero-team-1280.jpg' ); ?> 1280w, <?php echo esc_url( get_template_directory_uri() . '/assets/images/hero-team-1600.jpg' ); ?> 1600w"
				sizes="(max-width: 767px) 100vw, 44vw"
				width="1600" height="1067"
				alt="Đội ngũ DigicomVN làm việc cùng nhau"
				fetchpriority="high"
			>
		</div>
	</div>
	<div class="hero-diag-strip">
		<div class="wrap">
			<?php
			// Dai so lieu sua tu WP Admin > DigicomVN > Hero. Moi dong: con so | nhan.
			$dgc_stats = array_filter( dgc_lines( 'hero_stats' ), fn( $st ) => ! empty( $st[0] ) );
			foreach ( array_slice( $dgc_stats, 0, 5 ) as $st ) :
				$st_num   = trim( $st[0] );
				$st_label = trim( $st[1] ?? '' );
				$is_num   = (bool) preg_match( '/\d/', $st_num );
				?>
				<div class="s<?php echo $is_num ? ' stat' : ''; ?>"><b><?php echo esc_html( $st_num ); ?></b><?php echo $st_label ? ' ' . esc_html( $st_label ) : ''; ?></div>
			<?php endforeach; ?>
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


<!-- 06. DICH VU THEO NHOM -->
<?php
$svc_meta = array(
	'Mua Textlink'          => array( 'eyebrow' => 'Textlink', 'path' => 'M13.5 6.5L17 3a4 4 0 1 1 5.5 5.5L19 12M10.5 17.5L7 21a4 4 0 1 1-5.5-5.5L5 12M8 16l8-8' ),
	'Dịch vụ Backlink'      => array( 'eyebrow' => 'Backlink', 'path' => 'M4 19V10M10 19V5M16 19v-6M20 19H3' ),
	'Guest Post'            => array( 'eyebrow' => 'Guest Post', 'path' => 'M4 4h16v16H4zM8 9h8M8 13h8M8 17h5' ),
	'Booking báo & PR'      => array( 'eyebrow' => 'Booking PR', 'path' => 'M12 3l7 4v5c0 4-3 7-7 8-4-1-7-4-7-8V7z' ),
);
?>
<section class="sec" id="services" style="background:var(--surface-2);border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:40px">
			<span class="eyebrow">Dịch vụ của DigicomVN</span>
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

<!-- 06b. TAI SAO CHON DIGICOMVN -->
<?php
$why_items = dgc_lines( 'reasons' );
$why_icons = array(
	'M12 2a10 10 0 1 0 .01 0zM12 8v4l3 2',                        // process/clock
	'M4 4h16v12H4zM4 20h16M9 9h6M9 13h4',                          // report/transparency
	'M12 2 3 7v6c0 5 4 8 9 9 5-1 9-4 9-9V7z',                      // shield / SEO base
	'M3 17l6-6 4 4 7-7M14 8h5v5',                                  // growth / KPI
	'M12 3l2.5 5 5.5.8-4 3.9.9 5.5L12 21l-4.9-2.6.9-5.5-4-3.9 5.5-.8z', // star / AI cited
	'M4 7h16M4 12h16M4 17h10',                                     // automation / list
);
?>
<?php if ( $why_items ) : ?>
<section class="sec why-sec" id="tai-sao" style="background:var(--surface-2);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:40px">
			<span class="eyebrow">Tại sao chọn DigicomVN</span>
			<h2>Off-page SEO làm đúng, nguồn thật, minh bạch</h2>
			<p class="muted" style="max-width:620px;margin:10px auto 0">Textlink, backlink, guest post và booking báo PR triển khai trên nguồn chọn lọc có uy tín thật - báo giá rõ ràng, bàn giao kèm bằng chứng để bạn kiểm chứng.</p>
		</div>
		<div class="why-cards">
			<?php $wi = 0; foreach ( $why_items as $r ) :
				$path = $why_icons[ $wi % count( $why_icons ) ]; $wi++; ?>
				<div class="why-card">
					<span class="why-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="<?php echo esc_attr( $path ); ?>"/></svg></span>
					<h3><?php echo esc_html( $r[0] ?? '' ); ?></h3>
					<p><?php echo esc_html( $r[1] ?? '' ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- 07. REASONS + CHUNG TOI LA AI -->
<section class="sec band-navy whoweare-band" style="--bgimg:url('<?php echo esc_url( get_template_directory_uri() . '/assets/images/team-digicom-1400.jpg' ); ?>')">
	<div class="wrap">
		<div class="whoweare-hero">
			<div class="whoweare-hero-in">
				<span class="eyebrow">Chúng tôi là ai</span>
				<h2>DigicomVN - thương hiệu off-page SEO của Digito Combat</h2>
				<p class="lead">DigicomVN là thương hiệu dịch vụ số trực thuộc Công ty TNHH Dịch vụ Truyền thông Digito Combat, tập trung 4 dịch vụ off-page SEO: mua Textlink, dịch vụ Backlink, Guest Post và Booking đăng bài PR trên báo điện tử. DigicomVN chọn lọc site và đầu báo theo chỉ số thật, hướng tới sự minh bạch về giá, quy trình rõ ràng và bàn giao kèm báo cáo sau khi hoàn thành.</p>
				<p style="margin-top:18px"><a class="btn-text-link" href="<?php echo esc_url( home_url( '/ve-digicom/' ) ); ?>" style="color:#fff">Tìm hiểu về DigicomVN &rarr;</a></p>
			</div>
		</div>
	</div>
</section>

<!-- 07a. DAU BAO CO THE DAT BAI -->
<section class="sec press-strip">
	<div class="wrap">
		<div class="center" style="margin-bottom:22px">
			<span class="eyebrow">Mạng lưới báo chí</span>
			<h2>Đầu báo DigicomVN hỗ trợ đặt bài, booking PR</h2>
			<p class="muted" style="max-width:600px;margin:8px auto 0">Danh sách rút gọn, xem đầy đủ tại <a href="<?php echo esc_url( home_url( '/bang-gia/' ) ); ?>" style="color:var(--action);font-weight:600">Bảng giá</a>.</p>
		</div>
		<?php
		$press_list = array_filter( dgc_lines( 'press_partners' ), fn( $pp ) => ! empty( $pp[0] ) );
		$press_chip = function ( $pp ) {
			$logo_file = trim( $pp[1] ?? '' );
			$logo_url  = $logo_file ? content_url( 'uploads/press-logos/' . $logo_file ) : '';
			?>
			<div class="press-chip">
				<?php if ( $logo_url ) : ?>
					<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $pp[0] ); ?>" loading="lazy">
				<?php endif; ?>
				<span><?php echo esc_html( $pp[0] ); ?></span>
			</div>
			<?php
		};
		?>
		<div class="press-rows">
			<?php
			$dgc_press_rows = 5;
			$dgc_per        = max( 1, (int) ceil( count( $press_list ) / $dgc_press_rows ) );
			foreach ( array_chunk( $press_list, $dgc_per ) as $ri => $dgc_chunk ) :
				$rev = ( $ri % 2 === 1 ) ? ' press-track--rev' : '';
			?>
			<div class="press-marquee">
				<div class="press-track<?php echo $rev; ?>">
					<?php for ( $k = 0; $k < 4; $k++ ) : foreach ( $dgc_chunk as $pp ) : $press_chip( $pp ); endforeach; endfor; ?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 07b. TESTIMONIALS + CASE STUDY -->
<section class="sec" id="danh-gia">
	<div class="wrap">
		<div class="center" style="margin-bottom:26px">
			<span class="eyebrow">Khách hàng</span>
			<h2>Khách hàng nói về DigicomVN</h2>
		</div>
		<div class="tm-carousel owl-carousel">
			<?php foreach ( dgc_lines( 'testimonials' ) as $t ) :
				$quote = $t[0] ?? ''; $who = $t[1] ?? ''; $svc = $t[2] ?? ''; $photo = trim( $t[3] ?? '' );
				if ( $quote === '' ) continue;
				$who_clean = preg_replace( '/^(Ông|Bà|Anh|Chị|Cô|Chú|Mr|Ms|Mrs)\.?\s+/u', '', $who );
				$initial = function_exists( 'mb_substr' ) ? mb_strtoupper( mb_substr( $who_clean, 0, 1 ) ) : strtoupper( substr( $who_clean, 0, 1 ) ); ?>
				<figure class="tm">
					<div class="tm-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
					<blockquote><?php echo esc_html( $quote ); ?></blockquote>
					<figcaption>
						<span class="tm-avatar<?php echo $photo ? ' tm-avatar--img' : ''; ?>" aria-hidden="true"><?php
							if ( $photo ) {
								echo '<img src="' . esc_url( $photo ) . '" alt="' . esc_attr( $who ) . '" loading="lazy">';
							} else {
								echo esc_html( $initial );
							} ?></span>
						<span>
							<span class="tm-who"><?php echo esc_html( $who ); ?></span>
							<?php if ( $svc ) : ?><span class="tm-svc"><?php echo esc_html( $svc ); ?></span><?php endif; ?>
						</span>
					</figcaption>
				</figure>
			<?php endforeach; ?>
		</div>

		<div class="center" style="margin-top:34px">
			<a class="btn btn-navy" href="<?php echo esc_url( get_post_type_archive_link( 'dgc_case' ) ?: home_url( '/case-study/' ) ); ?>">Xem case study thực tế của DigicomVN &rarr;</a>
		</div>
	</div>
</section>

<!-- 07c. BAO CHI NOI VE DIGICOMVN -->
<?php $dgc_mentions = array_filter( dgc_lines( 'press_mentions' ), fn( $m ) => ! empty( $m[0] ) ); ?>
<?php if ( $dgc_mentions ) : ?>
<section class="sec press-mentions-sec" style="background:var(--surface-2);border-top:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:30px">
			<span class="eyebrow">Truyền thông</span>
			<h2>Báo chí nói về DigicomVN</h2>
			<p class="muted" style="max-width:600px;margin:8px auto 0">Cách DigicomVN ứng dụng AI và quy trình booking báo bài bản được các cơ quan báo chí ghi nhận.</p>
		</div>
		<div class="pm-grid">
			<?php foreach ( $dgc_mentions as $m ) :
				// Dinh dang: Ten bao | URL bai (co the de trong) | file logo
				$m_name = $m[0]; $m_url = trim( $m[1] ?? '' ); $m_file = trim( $m[2] ?? '' );
				$m_logo = $m_file ? content_url( 'uploads/press-logos/' . $m_file ) : '';
				$m_inner = $m_logo
					? '<img src="' . esc_url( $m_logo ) . '" alt="' . esc_attr( $m_name ) . '" loading="lazy">'
					: '<span class="pm-name">' . esc_html( $m_name ) . '</span>';
				if ( $m_url ) : ?>
					<a class="pm-item" href="<?php echo esc_url( $m_url ); ?>" target="_blank" rel="nofollow noopener" title="<?php echo esc_attr( $m_name ); ?>">
						<?php echo $m_inner; // phpcs:ignore ?>
						<span class="pm-read">Đọc bài &#8599;</span>
					</a>
				<?php else : ?>
					<span class="pm-item pm-item--nolink" title="<?php echo esc_attr( $m_name ); ?>">
						<?php echo $m_inner; // phpcs:ignore ?>
					</span>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- 07d. KHACH HANG / LOGO WALL (ngay duoi Bao chi noi ve) -->
<?php $dgc_clients = array_filter( dgc_lines( 'clients' ), fn( $c ) => ! empty( $c[0] ) ); ?>
<?php if ( $dgc_clients ) : ?>
<section class="sec-tight client-wall">
	<div class="wrap">
		<div class="center" style="margin-bottom:30px">
			<span class="eyebrow">Khách hàng &amp; đối tác</span>
			<h2>Thương hiệu đã tin tưởng DigicomVN</h2>
		</div>
		<?php
		$client_chip = function ( $c ) {
			$c_name = $c[0]; $c_file = trim( $c[1] ?? '' );
			$c_url  = $c_file ? content_url( 'uploads/client-logos/' . $c_file ) : ''; ?>
			<div class="client-logo" title="<?php echo esc_attr( $c_name ); ?>">
				<?php if ( $c_url ) : ?>
					<img src="<?php echo esc_url( $c_url ); ?>" alt="<?php echo esc_attr( $c_name ); ?>" loading="lazy">
				<?php else : ?>
					<span class="client-ph"><?php echo esc_html( $c_name ); ?></span>
				<?php endif; ?>
			</div>
		<?php };
		?>
		<div class="client-marquee">
			<div class="client-track">
				<?php for ( $k = 0; $k < 2; $k++ ) : foreach ( $dgc_clients as $c ) : $client_chip( $c ); endforeach; endfor; ?>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- 08. CTA BAND -->
<section class="sec-tight">
	<div class="wrap">
		<div class="cta-band">
			<div>
				<h2>Chưa biết chọn dịch vụ nào?</h2>
				<p>Để đội ngũ DigicomVN tư vấn miễn phí gói Textlink, Backlink, Guest Post hoặc Booking báo PR phù hợp.</p>
			</div>
			<div class="cta-actions">
				<a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a>
				<a class="btn btn-navy" href="https://zalo.me/<?php echo esc_attr( preg_replace( '/[^0-9]/', '', dgc( 'zalo' ) ) ); ?>">Chat Zalo</a>
			</div>
		</div>
	</div>
</section>

<!-- 09. FAQ -->
<?php $dgc_faqs = array_filter( dgc_lines( 'faqs' ), fn( $f ) => ! empty( $f[0] ) && ! empty( $f[1] ) ); ?>
<?php if ( $dgc_faqs ) : ?>
<section class="sec" id="faq">
	<div class="wrap">
		<div class="center" style="margin-bottom:34px">
			<span class="eyebrow">Hỗ trợ</span>
			<h2>Câu hỏi thường gặp</h2>
			<p class="muted" style="max-width:620px;margin:8px auto 0">Giải đáp về DigicomVN và bốn dịch vụ Textlink, Backlink, Guest Post, Booking báo &amp; PR. Chưa thấy câu trả lời bạn cần? Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?>.</p>
		</div>
		<div class="faq">
			<?php foreach ( $dgc_faqs as $f ) : ?>
				<details>
					<summary><?php echo esc_html( $f[0] ); ?></summary>
					<div class="a"><?php echo esc_html( $f[1] ); ?></div>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php
// Schema FAQPage: giup Google va cac tro ly AI trich dan dung cau tra loi cua DigicomVN.
$dgc_faq_ld = array(
	'@context'   => 'https://schema.org',
	'@type'      => 'FAQPage',
	'mainEntity' => array_values( array_map(
		fn( $f ) => array(
			'@type'          => 'Question',
			'name'           => wp_strip_all_tags( $f[0] ),
			'acceptedAnswer' => array( '@type' => 'Answer', 'text' => wp_strip_all_tags( $f[1] ) ),
		),
		$dgc_faqs
	) ),
);
?>
<script type="application/ld+json"><?php echo wp_json_encode( $dgc_faq_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ); ?></script>
<?php endif; ?>

<!-- 10. TIN TUC & SU KIEN -->
<?php
$news = new WP_Query( array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => 3,
	'ignore_sticky_posts' => 1,
) );
if ( $news->have_posts() ) : ?>
<section class="sec" id="tin-tuc" style="background:var(--surface-2);border-top:1px solid var(--line)">
	<div class="wrap">
		<div class="news-head">
			<div>
				<span class="eyebrow">Tin tức &amp; sự kiện</span>
				<h2>Tin mới từ DigicomVN</h2>
			</div>
			<a class="btn btn-ghost btn-sm" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ) ); ?>">Xem tất cả</a>
		</div>
		<div class="news-grid">
			<?php while ( $news->have_posts() ) : $news->the_post(); ?>
				<article class="news">
					<a class="news-thumb" href="<?php the_permalink(); ?>">
						<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'medium_large' ); else : ?>
							<span class="news-thumb-ph">DigicomVN</span>
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
