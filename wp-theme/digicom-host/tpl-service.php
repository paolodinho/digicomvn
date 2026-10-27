<?php
/**
 * Template Name: Dich vu (bao gia)
 * Dung cho: Lap trinh website, SEO/GEO, Backlink & PR, Google Ads, Automation.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
$svc_name = get_the_title();
$nhom     = dgc_current_nhom();
?>
<div class="wrap"><nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a><span class="sep">/</span> <?php echo esc_html( $svc_name ); ?></nav></div>

<?php
$dgc_h = $nhom ? dgc_svc_hero_data( $nhom['slug'] ) : array( 'count' => 0, 'rows' => array() );
/* Truyen hinh + phat thanh: don vi la "kenh", ban giao lich phat song thay vi link (2026-10-24). */
$dgc_media = $nhom && in_array( $nhom['slug'], array( 'booking-truyen-hinh', 'quang-cao-phat-thanh' ), true );
$dgc_unit  = ( $nhom && 'booking-bao-pr' === $nhom['slug'] ) ? 'đầu báo' : ( $dgc_media ? 'kênh' : 'website' );
?>
<section class="page-hero svc3d-hero" data-svc3d-hero>
	<div class="svc3d-glow" aria-hidden="true"></div>
	<div class="wrap">
	<div class="hero-grid">
	<div class="hero-copy">
		<span class="eyebrow">Dịch vụ</span>
		<h1><?php echo esc_html( $svc_name ); ?></h1>
		<?php if ( has_excerpt() ) : ?><p class="lead"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
		<?php /* Toi da 2 nut: 1 chinh + 1 phu (Hieu 2026-07-15). */ ?>
		<div class="hero-actions">
			<?php if ( $nhom ) : ?>
				<a class="btn btn-primary" href="#bang-gia">Xem bảng giá</a>
			<?php else : ?>
				<a class="btn btn-primary" href="#lien-he">Nhận báo giá</a>
			<?php endif; ?>
			<a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a>
		</div>
		<?php if ( $nhom && 'booking-bao-pr' === $nhom['slug'] ) : ?>
			<p style="margin-top:14px"><a href="#lien-he" style="font-size:13.5px;font-weight:600;text-decoration:underline">Hoặc để lại thông tin, DigicomVN tư vấn &amp; báo giá ngay →</a></p>
		<?php endif; ?>
		<?php if ( ! empty( $dgc_h['count'] ) ) : ?>
		<dl class="svc3d-stats">
			<div><dt><?php echo esc_html( $dgc_unit ); ?> có giá công khai</dt><dd data-count="<?php echo (int) $dgc_h['count']; ?>"><?php echo (int) $dgc_h['count']; ?></dd></div>
			<?php if ( ! empty( $dgc_h['min'] ) ) : ?><div><dt>Giá chỉ từ</dt><dd><?php echo esc_html( dgc_svc_money( $dgc_h['min'] ) ); ?></dd></div><?php endif; ?>
			<?php if ( ! empty( $dgc_h['maxdr'] ) ) : ?><div><dt>DR cao nhất (Ahrefs)</dt><dd data-count="<?php echo (int) $dgc_h['maxdr']; ?>"><?php echo (int) $dgc_h['maxdr']; ?></dd></div><?php endif; ?>
		</dl>
		<?php endif; ?>
	</div>

	<div class="svc3d-stage" aria-hidden="<?php echo empty( $dgc_h['rows'] ) ? 'false' : 'true'; ?>">
		<?php if ( ! empty( $dgc_h['rows'] ) ) : ?>
		<div class="svc3d-board" data-svc3d-board>
			<div class="svc3d-board-head"><span>Bảng giá đang áp dụng</span><span class="svc3d-live">Cập nhật <?php echo esc_html( wp_date( 'd/m/Y' ) ); ?></span></div>
			<ol class="svc3d-rows">
				<?php foreach ( $dgc_h['rows'] as $i => $r ) : ?>
				<li style="--i:<?php echo (int) $i; ?>">
					<span class="svc3d-name"><?php echo esc_html( $r['name'] ); ?></span>
					<?php if ( $r['dr'] > 0 ) : ?><span class="svc3d-dr">DR <?php echo (int) $r['dr']; ?></span><?php else : ?><span></span><?php endif; ?>
					<span class="svc3d-price"><small>từ</small> <?php echo esc_html( number_format( $r['price'], 0, ',', '.' ) ); ?>đ</span>
				</li>
				<?php endforeach; ?>
			</ol>
			<div class="svc3d-board-foot">+ <?php echo (int) max( 0, $dgc_h['count'] - count( $dgc_h['rows'] ) ); ?> <?php echo esc_html( $dgc_unit ); ?> khác trong bảng giá</div>
			<div class="svc3d-chip svc3d-chip-a"><b>VAT</b> Xuất hoá đơn đầy đủ</div>
			<?php if ( $dgc_media ) : ?><div class="svc3d-chip svc3d-chip-b"><b>Lịch</b> Bàn giao lịch phát sóng</div><?php else : ?><div class="svc3d-chip svc3d-chip-b"><b>Link</b> Bàn giao bài đã đăng</div><?php endif; ?>
		</div>
		<?php else : ?>
		<aside class="hero-panel" aria-label="Cam kết làm việc">
			<h2>Cam kết làm việc</h2>
			<ul>
				<li>Báo giá rõ ràng theo phạm vi công việc</li>
				<li>Xuất hoá đơn VAT đầy đủ</li>
				<li>Cập nhật tiến độ ở từng bước</li>
				<li>Tư vấn miễn phí, không ràng buộc</li>
			</ul>
		</aside>
		<?php endif; ?>
	</div>
	</div>
	</div>
</section>

<?php if ( $nhom ) : ?>
<section class="svc3d-trust" aria-label="Cam kết làm việc">
	<div class="wrap">
		<ul>
			<li><b>Giá công khai</b><span>Niêm yết trên từng vị trí đăng, không báo giá mập mờ</span></li>
			<li><b>Hoá đơn VAT</b><span>Xuất đầy đủ cho doanh nghiệp</span></li>
			<?php if ( $dgc_media ) : ?><li><b>Lịch phát sóng</b><span>Gửi lịch phát và file phát sóng để bạn đối chiếu</span></li><?php else : ?><li><b>Bàn giao link</b><span>Gửi link bài đã lên để bạn tự kiểm tra</span></li><?php endif; ?>
			<li><b>Tư vấn miễn phí</b><span>Chọn đúng <?php echo esc_html( $dgc_unit ); ?> theo ngành và ngân sách</span></li>
		</ul>
	</div>
</section>
<?php endif; ?>

<?php
/* Khoi dinh nghia dich vu ("... la gi") ngay duoi hero - bat intent thong tin + GEO.
   Chi render neu option svc_intros co dong khop slug hien tai (sua o WP Admin). */
include get_template_directory() . '/inc/svc-intro.php';

/* Khoi uu dai (promo-band) DA BO khoi trang dich vu (Hieu 2026-07-15).
   Bat guard som de footer.php cung KHONG render lai o cuoi trang. Trang chu van hien qua
   front-page.php; popup uu dai + nut Zalo van con. */
$GLOBALS['dgc_promo_done'] = true;

/* Bang gia len NGAY DUOI hero, tren moi noi dung khac (Hieu 2026-07-14). */
if ( $nhom ) {
	include get_template_directory() . '/inc/service-pricing.php';
	/* Ngay sau bang gia: 4 buoc dat hang + loi moi goi hotline/Zalo neu chua biet chon bao nao. */
	$dgc_og_ctx = $svc_name;
	include get_template_directory() . '/inc/order-guide.php';
}
?>

<?php if ( get_the_content() ) : ?>
<section class="sec"><div class="wrap page-content svc-body"><?php the_content(); ?></div></section>
<?php endif; ?>

<?php /* Trang co bang gia da co "Huong dan dat hang" 4 buoc -> khong lap quy trinh chung nua.
         Chi hien quy trinh chung cho trang dich vu KHONG co bang gia. */ ?>
<?php if ( ! $nhom ) :
	/* Booking mang xa hoi (fanpage, KOL/KOC - mo 2026-10-24) co quy trinh rieng, khong dung ban chung. */
	$dgc_social = in_array( get_post_field( 'post_name', get_the_ID() ), array( 'booking-fanpage', 'booking-kol-koc' ), true );
	$dgc_steps  = $dgc_social ? array(
		array( 'Nhận brief', 'Mục tiêu, sản phẩm, tệp khách và ngân sách dự kiến.' ),
		array( 'Đề xuất danh sách', 'Gửi danh sách kèm số liệu tương tác để bạn chọn và báo giá.' ),
		array( 'Duyệt nội dung', 'Kịch bản, bài đăng có nhãn quảng cáo được bạn duyệt trước khi lên.' ),
		array( 'Đăng &amp; báo cáo', 'Bàn giao link, ảnh chụp và số liệu sau khi đăng.' ),
	) : array(
		array( 'Khảo sát', 'Tìm hiểu mục tiêu, hiện trạng và yêu cầu của bạn.' ),
		array( 'Đề xuất &amp; báo giá', 'Lên phương án, phạm vi công việc và báo giá minh bạch.' ),
		array( 'Triển khai', 'Thực hiện theo kế hoạch, cập nhật tiến độ thường xuyên.' ),
		array( 'Bàn giao &amp; bảo hành', 'Nghiệm thu, hướng dẫn sử dụng và hỗ trợ sau bàn giao.' ),
	);
?>
<section class="sec" style="background:var(--surface-2);border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:34px"><span class="eyebrow">Quy trình</span><h2>Cách DigicomVN triển khai</h2></div>
		<ol class="proc">
			<?php foreach ( $dgc_steps as $st ) : ?>
			<li class="step"><h3><?php echo wp_kses_post( $st[0] ); ?></h3><p><?php echo esc_html( $st[1] ); ?></p></li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
<?php endif; ?>

<?php
/* KHONG cắm cac block dung chung trang chu (vi sao chon / dau bao / testimonials / FAQ) vao day
   nua (Hieu 2026-07-16): 8 trang dich vu lap y het nhau -> trung lap/boilerplate, loang do doc nhat.
   Trang dich vu chi giu noi dung RIENG: hero + "... la gi" + bang gia + noi dung bai + form.
   Cac block dung chung van song o trang chu (front-page.php). */
?>

<?php
/* FAQ RIENG cho dich vu nay (option svc_faqs, khop slug hien tai) - dat truoc form bao gia
   de giai dap ban khoan roi moi moi de lai thong tin. Co schema FAQPage. Trang khong co
   dong svc_faqs khop slug -> khong render (khong boilerplate). */
include get_template_directory() . '/inc/svc-faq.php';
?>

<section class="sec">
	<div class="wrap">
		<div class="row" style="gap:30px;align-items:flex-start">
			<div class="col">
				<img
					src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/agency-team-' . ( ( get_the_ID() % 6 ) + 1 ) . '-800.jpg' ); ?>"
					alt="Nhóm làm việc tại văn phòng agency truyền thông"
					width="800" height="533"
					style="width:100%;height:auto;border-radius:var(--r-md);box-shadow:var(--sh-low);display:block;margin-bottom:22px"
					loading="lazy"
				>
				<span class="eyebrow">Báo giá</span>
				<h2>Nhận tư vấn &amp; báo giá <?php echo esc_html( mb_strtolower( $svc_name ) ); ?></h2>
				<p class="muted">Mỗi dự án có nhu cầu khác nhau. Để lại thông tin, DigicomVN sẽ tư vấn giải pháp và gửi báo giá phù hợp.</p>
				<ul class="page-content" style="font-size:15.5px"><li>Tư vấn miễn phí, không ràng buộc.</li><li>Báo giá rõ ràng theo phạm vi công việc.</li><li>Đội ngũ chuyên môn, có cam kết tiến độ.</li></ul>
			</div>
			<div class="col"><?php
				$dgc_form_title   = 'Nhận báo giá';
				$dgc_form_btn     = 'Gửi yêu cầu báo giá';
				$dgc_form_service = '';
				$dgc_cur_path = trailingslashit( wp_parse_url( get_permalink(), PHP_URL_PATH ) );
				foreach ( dgc_service_links() as $sl ) {
					if ( $sl[1] === $dgc_cur_path ) { $dgc_form_service = $sl[0]; break; }
				}
				include get_template_directory() . '/inc/form-lead.php';
			?></div>
		</div>
	</div>
</section>

<section class="sec-tight"><div class="wrap"><div class="cta-band">
	<div><h2>Bắt đầu cùng DigicomVN</h2><p>Liên hệ ngay để được tư vấn giải pháp phù hợp doanh nghiệp của bạn.</p></div>
	<div class="cta-actions"><a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a><a class="btn btn-navy" href="#lien-he">Nhận báo giá</a></div>
</div></div></section>

<?php get_footer(); ?>
