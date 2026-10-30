<?php
/**
 * Template Name: Dich vu (bao gia)
 * Landing dich vu (backlink, textlink, guest post, toplist, booking truyen hinh/fanpage/KOL,
 * phan mem SEO, khoa hoc...). Giao dien sg.css (seongon) dong bo voi tpl-seo.php - 2026-10-28.
 * Thu tu: hero (the bang gia/cam ket) -> cam ket -> "... la gi" -> bang gia -> huong dan dat /
 * quy trinh -> FAQ rieng -> dich vu cung nhom -> form -> kien thuc (thu gon).
 * Noi dung sua o WP Admin (excerpt, noi dung trang, svc_intros, svc_faqs, CPT Bang gia).
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
$svc_name = get_the_title();
$nhom     = dgc_current_nhom();
$dgc_slug = get_post_field( 'post_name', get_the_ID() );
$dgc_path = trailingslashit( wp_parse_url( get_permalink(), PHP_URL_PATH ) );

$dgc_h     = $nhom ? dgc_svc_hero_data( $nhom['slug'] ) : array( 'count' => 0, 'rows' => array() );
/* Truyen hinh + phat thanh: don vi la "kenh", ban giao lich phat song thay vi link (2026-10-24). */
$dgc_media = $nhom && in_array( $nhom['slug'], array( 'booking-truyen-hinh', 'quang-cao-phat-thanh' ), true );
$dgc_unit  = ( $nhom && 'booking-bao-pr' === $nhom['slug'] ) ? 'đầu báo' : ( $dgc_media ? 'kênh' : 'website' );
$dgc_social = in_array( $dgc_slug, array( 'booking-fanpage', 'booking-kol-koc' ), true );

/* Nhom dich vu (eyebrow + dich vu cung nhom) lay tu cay dich vu dung chung. */
$dgc_group = 'Dịch vụ';
$dgc_sibs  = array();
foreach ( dgc_svc_tree() as $g ) {
	foreach ( $g[2] as $it ) {
		if ( $it[1] === $dgc_path ) { $dgc_group = $g[0]; $dgc_sibs = $g[2]; break 2; }
	}
}
$dgc_rel = array();
foreach ( $dgc_sibs as $it ) {
	if ( $it[1] !== $dgc_path && dgc_page_live( $it[1] ) ) $dgc_rel[] = $it;
}

$dgc_trust = array(
	array( $nhom ? 'Giá công khai' : 'Báo giá rõ ràng', $nhom ? 'Giá niêm yết theo từng vị trí đăng.' : 'Báo giá theo phạm vi công việc trước khi triển khai.' ),
	array( 'Hoá đơn VAT', 'Xuất hoá đơn đầy đủ cho doanh nghiệp.' ),
	$dgc_media ? array( 'Lịch phát sóng', 'Gửi lịch phát và file phát sóng để bạn đối chiếu.' )
		: ( $nhom ? array( 'Bàn giao link', 'Gửi link bài đã lên để bạn tự kiểm tra.' ) : array( 'Cập nhật tiến độ', 'Báo cáo ở từng bước, có đầu mối phụ trách.' ) ),
	array( 'Tư vấn miễn phí', $nhom ? 'Chọn đúng ' . $dgc_unit . ' theo ngành và ngân sách.' : 'Chỉ triển khai sau khi bạn đồng ý báo giá.' ),
);
$dgc_faqs  = dgc_svc_faq_items( $nhom ? $nhom['slug'] : ( function_exists( 'dgc_svc_slug' ) ? ( dgc_svc_slug() ?: $dgc_slug ) : $dgc_slug ) );
$dgc_check = '<span class="sg-ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5 9-10"/></svg></span>';

/* Khoi uu dai (promo-band) khong render lai o footer trang dich vu. */
$GLOBALS['dgc_promo_done'] = true;
?>

<!-- HERO -->
<section class="sg-phero">
	<div class="wrap">
		<nav class="sg-crumb" aria-label="Breadcrumb">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a> /
			<?php if ( $dgc_sibs && $dgc_sibs[0][1] !== $dgc_path && dgc_page_live( $dgc_sibs[0][1] ) ) : ?><a href="<?php echo esc_url( home_url( $dgc_sibs[0][1] ) ); ?>"><?php echo esc_html( $dgc_sibs[0][0] ); ?></a> /<?php endif; ?>
			<span><?php echo esc_html( $svc_name ); ?></span>
		</nav>
		<div class="sg-phero-row">
			<div>
				<span class="sg-eyebrow"><?php echo esc_html( $dgc_group ); ?></span>
				<h1><?php $dgc_h1 = trim( (string) get_post_meta( get_the_ID(), 'dgc_h1', true ) ); echo esc_html( $dgc_h1 !== '' ? $dgc_h1 : $svc_name ); ?></h1>
				<?php if ( has_excerpt() ) : ?><p class="sg-lead"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
				<div class="sg-hero-cta">
					<?php if ( $nhom ) : ?>
						<a class="sg-btn sg-btn--light" href="#bang-gia"><?php echo dgc_arrow(); ?>Xem bảng giá</a>
					<?php else : ?>
						<a class="sg-btn sg-btn--light" href="#lien-he"><?php echo dgc_arrow(); ?>Nhận báo giá</a>
					<?php endif; ?>
					<a class="sg-btn sg-btn--line" href="tel:<?php echo esc_attr( dgc_tel() ); ?>"><?php echo dgc_arrow(); ?>Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a>
				</div>
			</div>
			<?php if ( ! empty( $dgc_h['rows'] ) ) : ?>
			<aside class="sg-phero-card sg-pboard" aria-label="Bảng giá đang áp dụng">
				<h2>Bảng giá đang áp dụng</h2>
				<dl class="sg-pboard-stats">
					<div><dt><?php echo esc_html( ucfirst( $dgc_unit ) ); ?> có giá</dt><dd><?php echo (int) $dgc_h['count']; ?></dd></div>
					<?php if ( ! empty( $dgc_h['min'] ) ) : ?><div><dt>Giá chỉ từ</dt><dd><?php echo esc_html( dgc_svc_money( $dgc_h['min'] ) ); ?></dd></div><?php endif; ?>
					<?php if ( ! empty( $dgc_h['maxdr'] ) ) : ?><div><dt>DR cao nhất</dt><dd><?php echo (int) $dgc_h['maxdr']; ?></dd></div><?php endif; ?>
				</dl>
				<ol class="sg-pboard-rows">
					<?php foreach ( array_slice( $dgc_h['rows'], 0, 5 ) as $r ) : ?>
					<li><span class="n"><?php echo esc_html( $r['name'] ); ?></span><?php if ( $r['dr'] > 0 ) : ?><span class="dr">DR <?php echo (int) $r['dr']; ?></span><?php else : ?><span></span><?php endif; ?><span class="p">từ <?php echo esc_html( number_format( $r['price'], 0, ',', '.' ) ); ?>đ</span></li>
					<?php endforeach; ?>
				</ol>
				<p class="sg-pboard-foot">Cập nhật <?php echo esc_html( wp_date( 'd/m/Y' ) ); ?> &middot; <a href="#bang-gia">Xem đủ <?php echo (int) $dgc_h['count']; ?> <?php echo esc_html( $dgc_unit ); ?></a></p>
			</aside>
			<?php else : ?>
			<aside class="sg-phero-card" aria-label="Cam kết làm việc">
				<h2>Cam kết làm việc</h2>
				<dl>
					<?php foreach ( $dgc_trust as $t ) : ?><div><dt><?php echo esc_html( $t[0] ); ?></dt><dd><?php echo esc_html( $t[1] ); ?></dd></div><?php endforeach; ?>
				</dl>
			</aside>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php
require_once get_template_directory() . '/inc/svc-story.php';
$dgc_wc = dgc_svc_story_conf( $dgc_path );
if ( $dgc_wc ) : /* Hieu 30/10: thay 4 the cam ket bang doan giai thich tu bang gia that */
	$dgc_im = $dgc_wc['img'] ?? array(); ?>
<section class="sec ws-story-sec">
	<div class="wrap ws-story<?php echo empty( $dgc_im ) ? ' ws-story--solo' : ''; ?>">
		<div class="ws-story-text">
			<span class="eyebrow"><?php echo esc_html( $dgc_wc['story_eyebrow'] ?? '' ); ?></span>
			<h2><?php echo esc_html( $dgc_wc['story_h'] ); ?></h2>
			<div class="page-content"><?php echo wp_kses_post( $dgc_wc['story'] ); ?></div>
		</div>
		<?php if ( $dgc_im ) : ?>
		<figure class="ws-story-fig">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/' . $dgc_im['src'] ); ?>" width="<?php echo (int) $dgc_im['w']; ?>" height="<?php echo (int) $dgc_im['h']; ?>" alt="<?php echo esc_attr( $dgc_im['alt'] ); ?>" loading="lazy" decoding="async">
			<?php if ( ! empty( $dgc_im['cap'] ) ) : ?><figcaption><?php echo esc_html( $dgc_im['cap'] ); ?></figcaption><?php endif; ?>
		</figure>
		<?php endif; ?>
	</div>
</section>
<?php if ( ! empty( $dgc_wc['extra'] ) ) : ?>
<section class="sec ws-extra-sec">
	<div class="wrap" style="max-width:1000px">
		<div class="ws-extra-head"><span class="eyebrow"><?php echo esc_html( $dgc_wc['extra_eyebrow'] ?? '' ); ?></span><h2><?php echo esc_html( $dgc_wc['extra_h'] ); ?></h2></div>
		<div class="page-content ws-extra"><?php echo wp_kses_post( $dgc_wc['extra'] ); ?></div>
	</div>
</section>
<?php endif; ?>
<?php elseif ( ! empty( $dgc_h['rows'] ) ) : /* the hero da la bang gia -> cam ket dua xuong day */ ?>
<!-- CAM KET -->
<section class="sg-sec sg-sec--tight sg-sec--cyan">
	<div class="wrap">
		<div class="sg-benefits sg-benefits--4 sg-benefits--light">
			<?php foreach ( $dgc_trust as $t ) : ?>
				<div class="sg-card"><?php echo $dgc_check; // phpcs:ignore ?><h3><?php echo esc_html( $t[0] ); ?></h3><p><?php echo esc_html( $t[1] ); ?></p></div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<div class="sg-inc">
<?php
/* "... la gi" (option svc_intros) -> bang gia -> huong dan dat 4 buoc. Cac file inc dung chung
   voi trang booking; giao dien sg ap qua .sg-inc trong sg.css. */
include get_template_directory() . '/inc/svc-intro.php';
if ( '/dich-vu-backlink/' === $dgc_path && empty( $dgc_h['count'] ) ) {
	include get_template_directory() . '/inc/backlink-price-overview.php';
}
if ( $nhom ) {
	include get_template_directory() . '/inc/service-pricing.php';
	$dgc_og_ctx = $svc_name;
	include get_template_directory() . '/inc/order-guide.php';
}
?>
</div>

<?php if ( ! $nhom ) :
	$dgc_steps = $dgc_social ? array(
		array( 'Nhận brief', 'Mục tiêu, sản phẩm, tệp khách và ngân sách dự kiến.' ),
		array( 'Đề xuất danh sách', 'Gửi danh sách kèm số liệu tương tác để bạn chọn và báo giá.' ),
		array( 'Duyệt nội dung', 'Kịch bản, bài đăng có nhãn quảng cáo được bạn duyệt trước khi lên.' ),
		array( 'Đăng và báo cáo', 'Bàn giao link, ảnh chụp và số liệu sau khi đăng.' ),
	) : array(
		array( 'Khảo sát', 'Tìm hiểu mục tiêu, hiện trạng và yêu cầu của bạn.' ),
		array( 'Đề xuất và báo giá', 'Lên phương án, phạm vi công việc và báo giá minh bạch.' ),
		array( 'Triển khai', 'Thực hiện theo kế hoạch, cập nhật tiến độ thường xuyên.' ),
		array( 'Bàn giao và hỗ trợ', 'Nghiệm thu, hướng dẫn sử dụng và hỗ trợ sau bàn giao.' ),
	);
?>
<!-- QUY TRINH -->
<section class="sg-sec sg-sec--cyan">
	<div class="wrap">
		<div class="sg-head sg-head--c">
			<span class="sg-eyebrow">Quy trình</span>
			<h2 class="sg-h">Cách DigicomVN <em>triển khai</em></h2>
		</div>
		<ol class="sg-steps sg-steps--4">
			<?php foreach ( $dgc_steps as $n => $st ) : ?>
				<li><span class="sg-num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $n + 1 ) ); ?></span><h3><?php echo esc_html( $st[0] ); ?></h3><p><?php echo esc_html( $st[1] ); ?></p></li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
<?php endif; ?>

<!-- FAQ -->
<?php if ( $dgc_faqs ) : ?>
<section class="sg-sec" id="faq">
	<div class="wrap sg-head--split" style="align-items:start">
		<div>
			<span class="sg-eyebrow">Hỏi đáp</span>
			<h2 class="sg-h">Câu hỏi <em>thường gặp</em></h2>
			<p class="sg-lead">Chưa thấy câu trả lời bạn cần? Gọi <a href="tel:<?php echo esc_attr( dgc_tel() ); ?>" style="color:var(--sg-blue);font-weight:700"><?php echo esc_html( dgc( 'hotline' ) ); ?></a> hoặc gửi yêu cầu ở cuối trang.</p>
		</div>
		<div class="sg-faq">
			<?php foreach ( $dgc_faqs as $f ) : ?>
				<details><summary><?php echo esc_html( $f[0] ); ?></summary><div class="a"><?php echo esc_html( $f[1] ); ?></div></details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- DICH VU CUNG NHOM -->
<?php if ( $dgc_rel ) : ?>
<section class="sg-sec sg-sec--tight sg-sec--grey">
	<div class="wrap">
		<div class="sg-head">
			<span class="sg-eyebrow"><?php echo esc_html( $dgc_group ); ?></span>
			<h2 class="sg-h">Dịch vụ <em>liên quan</em></h2>
		</div>
		<div class="sg-related">
			<?php foreach ( array_slice( $dgc_rel, 0, 4 ) as $s ) : ?>
				<a class="sg-card" href="<?php echo esc_url( home_url( $s[1] ) ); ?>">
					<h3><?php echo esc_html( $s[0] ); ?></h3>
					<span class="sg-more">Xem chi tiết <?php echo dgc_arrow(); ?></span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- LIEN HE -->
<section class="sg-sec" id="lien-he">
	<div class="wrap">
		<div class="sg-contact">
			<div class="sg-contact-media" style="background-image:url('<?php echo esc_url( get_template_directory_uri() . '/assets/images/agency-team-' . ( ( get_the_ID() % 6 ) + 1 ) . '-800.webp' ); ?>')">
				<span class="sg-eyebrow">Báo giá</span>
				<h2>Nhận tư vấn và <em>báo giá</em> <?php echo esc_html( mb_strtolower( $svc_name ) ); ?></h2>
				<p>Để lại thông tin, DigicomVN tư vấn phương án phù hợp và gửi báo giá chi tiết theo phạm vi công việc. Tư vấn miễn phí, không ràng buộc.</p>
				<p>Hotline: <a href="tel:<?php echo esc_attr( dgc_tel() ); ?>"><strong><?php echo esc_html( dgc( 'hotline' ) ); ?></strong></a></p>
			</div>
			<div class="sg-contact-form"><?php
				$dgc_form_title   = 'Nhận báo giá';
				$dgc_form_btn     = 'Gửi yêu cầu báo giá';
				$dgc_form_service = '';
				foreach ( dgc_service_links() as $sl ) {
					if ( $sl[1] === $dgc_path ) { $dgc_form_service = $sl[0]; break; }
				}
				include get_template_directory() . '/inc/form-lead.php';
			?></div>
		</div>
	</div>
</section>

<?php if ( get_the_content() ) : /* Hieu 27/10: bai kien thuc dua xuong cuoi, thu gon, bam de doc tiep */ ?>
<section class="sg-sec sg-sec--cyan svc-knowledge"><div class="wrap">
	<div class="sg-head"><span class="sg-eyebrow">Tìm hiểu thêm</span><h2 class="sg-h">Kiến thức về <em><?php echo esc_html( mb_strtolower( $svc_name ) ); ?></em></h2></div>
	<div class="page-content sg-article svc-body is-clamped" id="svc-knowledge-body"><?php the_content(); ?></div>
	<div class="svc-knowledge-more"><button type="button" class="btn btn-ghost" data-knowledge-toggle aria-controls="svc-knowledge-body" aria-expanded="false">Đọc toàn bộ hướng dẫn</button></div>
</div></section>
<?php endif; ?>

<?php get_footer(); ?>
