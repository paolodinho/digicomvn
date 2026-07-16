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
					<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/bang-gia/' ) ); ?>">Nhận báo giá</a>
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

<?php /* 02b. Chat AI tu van (DeepSeek) - SECTION 2, ngay duoi hero o trang chu (Hieu 2026-07-15).
        Chi hien khi da bat + co key (dgc_ai_enabled), nguoc lai khong render gi. */ ?>
<?php if ( function_exists( 'dgc_ai_chat_box' ) ) dgc_ai_chat_box(); ?>

<?php /* 03. UU DAI: da chuyen thanh pill noi (promo-fab) tren moi trang - khong con khoi to (Hieu 2026-07-15). */ ?>

<!-- 06. DICH VU - list gon + link toi trang dich vu (Hieu 2026-07-15: section chi can liet ke + link) -->
<?php
/* Danh sach pillar dich vu theo sitemap da chot (pivot-2026-07). Slug co dinh -> link truc tiep.
   8 dich vu = luoi 4x2 can doi; link "Tat ca dich vu" chuyen thanh dong chu duoi luoi. */
$dgc_services = array(
	array( 'Mua Textlink',           '/mua-textlink/',           'Chèn link vào bài có sẵn, chọn site theo DR &amp; traffic.',        'M13.5 6.5L17 3a4 4 0 1 1 5.5 5.5L19 12M10.5 17.5L7 21a4 4 0 1 1-5.5-5.5L5 12M8 16l8-8' ),
	array( 'Dịch vụ Backlink',       '/dich-vu-backlink/',       'Hệ thống backlink chất lượng, đa nguồn, an toàn.',                  'M4 19V10M10 19V5M16 19v-6M20 19H3' ),
	array( 'Guest Post',             '/guest-post/',             'Viết bài &amp; đăng trên site đúng chủ đề, link dofollow.',          'M4 4h16v16H4zM8 9h8M8 13h8M8 17h5' ),
	array( 'Booking báo &amp; PR',   '/booking-bao-pr/',         'Đặt bài PR trên báo điện tử uy tín, theo từng đầu báo.',            'M12 3l7 4v5c0 4-3 7-7 8-4-1-7-4-7-8V7z' ),
	array( 'Dịch vụ Toplist',        '/dich-vu-toplist/',        'Đưa thương hiệu vào bài xếp hạng "Top uy tín" đúng lĩnh vực.',       'M12 2l2.6 6.3 6.8.5-5.2 4.4 1.7 6.6L12 16.9 6.3 20.3l1.7-6.6-5.2-4.4 6.8-.5z' ),
	array( 'Backlink Social Entity', '/backlink-social-entity/', 'Hồ sơ social chuẩn NAP, nội dung độc bản, làm thủ công.',           'M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM4 20a8 8 0 0 1 16 0' ),
	array( 'Backlink quốc tế',       '/backlink-quoc-te/',       'Guest post, niche edit &amp; PR báo quốc tế theo tầng DR/DA.',       'M12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18zM3 12h18M12 3c2.5 2.5 3.8 5.6 3.8 9s-1.3 6.5-3.8 9c-2.5-2.5-3.8-5.6-3.8-9S9.5 5.5 12 3z' ),
	array( 'Booking truyền hình',    '/booking-truyen-hinh/',    'TVC, phóng sự &amp; talkshow trên VTV, HTV.',                       'M3 7h18v12H3zM8 3l4 4 4-4' ),
	array( 'Quảng cáo loa phường',   '/quang-cao-loa-phuong/',   'Phát thông báo trên loa truyền thanh xã phường theo khu vực.',      'M3 10v4h4l6 5V5l-6 5H3zM16 9a5 5 0 0 1 0 6' ),
	array( 'Quảng cáo phát thanh',   '/quang-cao-phat-thanh/',   'Spot radio trên VOV, VOH &amp; đài tỉnh theo khung giờ.',            'M4 11a8 8 0 0 1 16 0v7a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zM8 20v-6M16 20v-6' ),
	array( 'Quảng cáo màn LED',      '/quang-cao-man-led/',      'Màn hình LED toà nhà &amp; LCD thang máy theo vị trí.',              'M3 5h18v11H3zM9 21h6M12 16v5' ),
);
?>
<section class="sec" id="services" style="background:var(--surface-2);border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:40px">
			<span class="eyebrow">Dịch vụ của DigicomVN</span>
			<h2>Off-page SEO trọn gói cho doanh nghiệp</h2>
			<p class="muted">Từ mua textlink, backlink, guest post đến booking đăng bài PR trên báo điện tử.</p>
		</div>
		<div class="svc-links">
			<?php foreach ( $dgc_services as $s ) : ?>
				<a class="svc-link" href="<?php echo esc_url( home_url( $s[1] ) ); ?>">
					<span class="svc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="<?php echo esc_attr( $s[3] ); ?>"/></svg></span>
					<h3><?php echo esc_html( html_entity_decode( $s[0], ENT_QUOTES ) ); ?></h3>
					<p><?php echo wp_kses_post( $s[2] ); ?></p>
					<span class="svc-more">Xem chi tiết &rarr;</span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 06b. TAI SAO CHON DIGICOMVN (partial dung chung voi trang dich vu) -->
<?php include get_template_directory() . '/inc/blk-reasons.php'; ?>

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

<!-- 07a. DAU BAO CO THE DAT BAI (partial dung chung) -->
<?php include get_template_directory() . '/inc/blk-press-partners.php'; ?>

<!-- 07b. TESTIMONIALS + CASE STUDY (partial dung chung) -->
<?php include get_template_directory() . '/inc/blk-testimonials.php'; ?>

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
				<a class="btn btn-zalo" href="https://zalo.me/<?php echo esc_attr( preg_replace( '/[^0-9]/', '', dgc( 'zalo' ) ) ); ?>">Chat Zalo</a>
			</div>
		</div>
	</div>
</section>

<!-- 09. FAQ (partial dung chung + schema FAQPage) -->
<?php include get_template_directory() . '/inc/blk-faq.php'; ?>

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
