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

<section class="page-hero">
	<div class="wrap" style="max-width:840px">
		<span class="eyebrow">Dịch vụ</span>
		<h1><?php echo esc_html( $svc_name ); ?></h1>
		<?php if ( has_excerpt() ) : ?><p class="lead"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
		<?php /* Toi da 2 nut: 1 chinh + 1 phu (Hieu 2026-07-15 "nhieu loai nut qua").
		         Bo "Nhan bao gia" - trung muc dich voi bang gia (co san nut gui yeu cau) va voi nut Goi. */ ?>
		<div class="hero-actions">
			<?php if ( $nhom ) : ?>
				<a class="btn btn-primary" href="#bang-gia">Xem bảng giá</a>
				<a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a>
			<?php else : ?>
				<a class="btn btn-primary" href="#lien-he">Nhận báo giá</a>
				<a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a>
			<?php endif; ?>
		</div>
		<?php /* Link phu duoi CTA, rieng trang booking-bao-pr (Hieu 2026-08-05): dua duong dan
		         toi form dat lich len gan Hero hon ma khong pha rule toi da 2 nut hero. */ ?>
		<?php if ( $nhom && 'booking-bao-pr' === $nhom['slug'] ) : ?>
			<p style="margin-top:14px"><a href="#lien-he" style="font-size:13.5px;font-weight:600;color:var(--action);text-decoration:underline">Hoặc để lại thông tin, DigicomVN tư vấn & báo giá ngay →</a></p>
		<?php endif; ?>
	</div>
</section>

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

/* Khoi "Vi sao chon DigicomVN" + cum bai lien quan - rieng trang booking-bao-pr (2026-08-17).
   4 su that da xac nhan trong du an (khong bia): 15+ dau bao lon hop tac that (pivot-2026-07.md),
   gia cong khai tu DanaSEO + 5% (bang-gia-booking.md), dofollow theo tung vi tri (field so_link
   CPT dgc_gia), xuat VAT (da noi trong order-guide.php). Hardcode PHP giong dung pattern cac
   buoc order-guide.php/proc o tren (khong phai noi dung sua thuong xuyen qua WP Admin). */
/* dgc_current_nhom() tra ve slug 'booking-bao-pr' cho CA trang hub LAN cac trang con theo
   dau bao (ke thua qua chuoi ancestor) - phai kiem post_name CUA CHINH trang hien tai, khong
   phai $nhom['slug'], neu khong khoi nay se lap lai tren ca 15 trang con (dung rule "khong
   boilerplate" da ghi ngay ben duoi). */
if ( $nhom && 'booking-bao-pr' === $nhom['slug'] && 'booking-bao-pr' === get_post_field( 'post_name', get_the_ID() ) ) :
	$dgc_bao_why = array(
		array(
			'title' => '15+ đầu báo lớn hợp tác trực tiếp',
			'desc'  => 'VnExpress, Kênh14, Dân Trí, 24h, CafeF, VietNamNet, Thanh Niên, Tuổi Trẻ... và mọi báo điện tử Việt Nam khác theo yêu cầu (trừ .gov.vn/.edu.vn).',
		),
		array(
			'title' => 'Giá công khai ngay trong bảng giá',
			'desc'  => 'Không giấu giá, không báo giá "tuỳ trường hợp". Xem giá từng đầu báo, chọn nhiều mục cùng lúc ngay phía trên.',
		),
		array(
			'title' => 'Hỗ trợ dofollow theo từng vị trí',
			'desc'  => 'Mỗi đầu báo ghi rõ loại link (dofollow/nofollow/không chèn link) ngay trong bảng giá - chọn đúng mục tiêu SEO trước khi đặt.',
		),
		array(
			'title' => 'Xuất hoá đơn VAT đầy đủ',
			'desc'  => 'Có hoá đơn VAT cho doanh nghiệp cần đối soát chi phí, đúng quy trình mua bán rõ ràng.',
		),
	);
	?>
	<section class="sec">
		<div class="wrap">
			<div class="center" style="margin-bottom:26px"><span class="eyebrow">Vì sao chọn DigicomVN</span><h2>Booking báo PR minh bạch, đúng đầu báo bạn cần</h2></div>
			<div class="feat-row">
				<?php foreach ( $dgc_bao_why as $w ) : ?>
				<div class="feat">
					<div class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/></svg></div>
					<h3><?php echo esc_html( $w['title'] ); ?></h3>
					<p><?php echo esc_html( $w['desc'] ); ?></p>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
	$dgc_bao_cum = array(
		array( 'slug' => 'booking-bao-la-gi', 'title' => 'Booking Báo Chí Là Gì?', 'desc' => 'Định nghĩa, quy trình đặt bài PR chi tiết cho người mới bắt đầu.' ),
		array( 'slug' => 'so-sanh-booking-bao-pr-va-quang-cao-bao', 'title' => 'So Sánh Booking Báo PR &amp; Quảng Cáo Báo', 'desc' => 'Khác nhau về chi phí, độ tin cậy, SEO và thời gian tồn tại nội dung.' ),
		array( 'slug' => 'bao-gia-dang-bai-pr-theo-dau-bao', 'title' => 'Báo Giá Đăng Bài PR Theo Đầu Báo', 'desc' => 'Bảng giá từng đầu báo và cách chọn đầu báo phù hợp ngân sách.' ),
		array( 'slug' => 'cach-viet-bai-pr-chuan-bao-chi', 'title' => 'Cách Viết Bài PR Chuẩn Báo Chí', 'desc' => 'Công thức tháp ngược, mô hình 5W1H và mẫu bài PR tham khảo.' ),
		array( 'slug' => 'hieu-lam-booking-bao-chi', 'title' => 'Hiểu Lầm Thường Gặp Khi Booking', 'desc' => 'Những sai lầm khiến chiến dịch booking báo không đạt hiệu quả.' ),
		array( 'slug' => 'booking-bao-tinh', 'title' => 'Booking Báo Tỉnh', 'desc' => 'Đặt bài PR trên báo địa phương - quy trình và mức giá tham khảo.' ),
		array( 'slug' => 'agency-booking-bao-chi', 'title' => 'Agency Booking Báo Chí: 7 Tiêu Chí', 'desc' => 'Cách chọn đúng đơn vị booking báo uy tín, tránh mất tiền oan.' ),
		array( 'slug' => 'chien-dich-pr-an-tuong-viet-nam', 'title' => 'Case Study Chiến Dịch PR Ấn Tượng', 'desc' => 'Phân tích chiến dịch PR thực tế, bài học cho doanh nghiệp SME.' ),
	);
	?>
	<section class="sec" style="background:var(--surface-2);border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
		<div class="wrap">
			<div class="center" style="margin-bottom:26px"><span class="eyebrow">Tìm hiểu thêm</span><h2>Kiến thức booking báo &amp; PR</h2></div>
			<div class="svc-links">
				<?php foreach ( $dgc_bao_cum as $c ) : ?>
				<a class="svc-link" href="<?php echo esc_url( home_url( '/' . $c['slug'] . '/' ) ); ?>">
					<div class="svc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg></div>
					<h3><?php echo $c['title']; // phpcs:ignore - chuoi tinh, co entity &amp; ?></h3>
					<p><?php echo esc_html( $c['desc'] ); ?></p>
					<span class="svc-more">Đọc bài →</span>
				</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
endif;
?>

<?php if ( get_the_content() ) : ?>
<section class="sec"><div class="wrap page-content"><?php the_content(); ?></div></section>
<?php endif; ?>

<?php /* Trang co bang gia da co "Huong dan dat hang" 4 buoc -> khong lap quy trinh chung nua.
         Chi hien quy trinh chung cho trang dich vu KHONG co bang gia. */ ?>
<?php if ( ! $nhom ) : ?>
<section class="sec" style="background:var(--surface-2);border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:34px"><span class="eyebrow">Quy trình</span><h2>Cách DigicomVN triển khai</h2></div>
		<ol class="proc">
			<li class="step"><h3>Khảo sát</h3><p>Tìm hiểu mục tiêu, hiện trạng và yêu cầu của bạn.</p></li>
			<li class="step"><h3>Đề xuất &amp; báo giá</h3><p>Lên phương án, phạm vi công việc và báo giá minh bạch.</p></li>
			<li class="step"><h3>Triển khai</h3><p>Thực hiện theo kế hoạch, cập nhật tiến độ thường xuyên.</p></li>
			<li class="step"><h3>Bàn giao &amp; bảo hành</h3><p>Nghiệm thu, hướng dẫn sử dụng và hỗ trợ sau bàn giao.</p></li>
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
					src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/team-service-800.jpg' ); ?>"
					alt="Đội ngũ DigicomVN"
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
				$dgc_form_service = $svc_name;
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
