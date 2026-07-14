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
			<?php $dgc_press_count = count( dgc_lines( 'press_partners' ) ); ?>
			<?php if ( $dgc_press_count > 0 ) : ?>
			<div class="s stat"><b><?php echo (int) $dgc_press_count; ?>+</b>đầu báo &amp; site đối tác</div>
			<?php endif; ?>
			<div class="s"><b>Site</b> chọn lọc theo chỉ số</div>
			<div class="s"><b>Báo giá</b> minh bạch</div>
			<div class="s"><b>Hỗ trợ</b> tư vấn tận tình</div>
			<div class="s"><b>Xuất VAT</b> đầy đủ</div>
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
<section class="sec" id="services" style="background:#fff;border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
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
		<div class="center" style="margin-top:56px">
			<span class="eyebrow">Vì sao chọn DigicomVN</span>
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
		<div class="press-marquee">
			<div class="press-track">
				<?php foreach ( $press_list as $pp ) : $press_chip( $pp ); endforeach; ?>
				<?php foreach ( $press_list as $pp ) : $press_chip( $pp ); endforeach; ?>
			</div>
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
		<div class="cs-tabs">
			<input type="radio" name="cs-tab" id="cs-tab-review" class="cs-tab-radio" checked>
			<input type="radio" name="cs-tab" id="cs-tab-case" class="cs-tab-radio">
			<div class="tab-bar center" style="justify-content:center">
				<label for="cs-tab-review" class="tab-btn">Đánh giá khách hàng</label>
				<label for="cs-tab-case" class="tab-btn">Case study</label>
			</div>

			<div class="cs-panel cs-panel-review">
				<p class="muted center" style="font-size:12.5px;margin-bottom:18px">Nội dung ví dụ minh hoạ dạng phản hồi thường gặp, chưa phải trích dẫn xác thực từ khách hàng cụ thể.</p>
				<div class="tm-carousel owl-carousel">
					<?php foreach ( dgc_lines( 'testimonials' ) as $t ) :
						$quote = $t[0] ?? ''; $who = $t[1] ?? ''; $svc = $t[2] ?? ''; $photo = trim( $t[3] ?? '' );
						if ( $quote === '' ) continue;
						$initial = function_exists( 'mb_substr' ) ? mb_strtoupper( mb_substr( $who, 0, 1 ) ) : strtoupper( substr( $who, 0, 1 ) ); ?>
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
			</div>

			<div class="cs-panel cs-panel-case">
				<?php $case_studies = array_filter( dgc_lines( 'case_studies' ), fn( $c ) => ! empty( $c[0] ) ); ?>
				<?php if ( $case_studies ) : ?>
					<div class="cs-grid">
						<?php foreach ( $case_studies as $c ) : ?>
							<div class="cs-card">
								<h3><?php echo esc_html( $c[0] ?? '' ); ?></h3>
								<p class="cs-result"><?php echo esc_html( $c[1] ?? '' ); ?></p>
								<div class="cs-meta">
									<?php if ( ! empty( $c[2] ) ) : ?><span class="cs-svc"><?php echo esc_html( $c[2] ); ?></span><?php endif; ?>
									<?php if ( ! empty( $c[3] ) ) : ?><span class="cs-client"><?php echo esc_html( $c[3] ); ?></span><?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php else : ?>
					<div class="center" style="padding:30px 0"><p class="muted">Case study đang được cập nhật, quay lại sau.</p></div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

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
