<?php
/**
 * Template Name: Booking bao & PR (trang rieng)
 * Trang PILLAR /booking-bao-pr/ - phien ban thiet ke rieng (khac tpl-service.php dung
 * chung cho 7 trang dich vu con lai). Ep dung qua filter template_include trong
 * functions.php (khong phu thuoc template dang gan trong DB) - xem cum "TEMPLATE RIENG
 * /booking-bao-pr/" trong functions.php.
 *
 * Thu tu section (redesign 2026-08-14, dua tren nghien cuu SERP + do-dont.md):
 * Hero -> dinh nghia (svc-intro, that) -> BANG GIA NGAY (giu nguyen rule Hieu 2026-07-14,
 * khong duoc day xuong duoi) -> huong dan dat hang 4 buoc -> MOI: goi y chon bao theo muc
 * tieu (giup dieu huong hang tram dong gia) -> MOI: day du dau bao hop tac (dang bi thieu -
 * front-page.php da hua "xem day du tai trang Booking bao & PR" nhung tpl-service.php
 * truoc day KHONG include blk-press-partners.php) -> MOI: vi sao chon DigicomVN -> noi dung
 * trang (WP Admin) -> FAQ -> form bao gia -> CTA.
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
		<div class="hero-actions">
			<a class="btn btn-primary" href="#bang-gia">Xem bảng giá</a>
			<a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a>
		</div>
		<p style="margin-top:14px"><a href="#lien-he" style="font-size:13.5px;font-weight:600;color:var(--action);text-decoration:underline">Hoặc để lại thông tin, DigicomVN tư vấn & báo giá ngay →</a></p>
	</div>
</section>

<?php
/* Khoi dinh nghia "Booking bao PR la gi" - noi dung that, sua o WP Admin > muc 2. */
include get_template_directory() . '/inc/svc-intro.php';

$GLOBALS['dgc_promo_done'] = true; // khoi uu dai khong hien o trang dich vu (rule cu)
?>

<?php
/* Bang gia NGAY DUOI dinh nghia, TRUOC moi noi dung khac - rule cung Hieu 2026-07-14,
   khong duoc doi vi tri trong ban thiet ke lai nay. */
include get_template_directory() . '/inc/service-pricing.php';
$dgc_og_ctx = $svc_name;
include get_template_directory() . '/inc/order-guide.php';
?>

<?php
/* ==========================================================================
   MOI: Goi y chon dau bao theo muc tieu - giup dinh huong hang tram dong gia
   phia tren, gan dung 4 muc tieu nguoi dat bao thuc te hay co (SEO/thu hang,
   xay thuong hieu, dung dau doc gia dung nganh, xu ly khung hoang). Dung thuat
   ngu that da co san trong chinh bang gia (link dofollow/nofollow, DR - Domain
   Rating, bo loc Nhom bao theo nganh) - khong bia so lieu moi.
   ========================================================================== */
$dgc_goals = array(
	array(
		'title' => 'Tăng thứ hạng từ khoá (SEO)',
		'body'  => 'Ưu tiên các vị trí gắn <strong>link dofollow</strong> - loại link truyền sức mạnh liên kết trực tiếp về website, và chọn báo có <strong>DR (Domain Rating)</strong> cao trong đúng lĩnh vực bài viết.',
		'hint'  => 'Trong bảng giá phía trên: lọc "Loại link" → Link dofollow.',
		'icon'  => 'M13 2 3 14h7l-1 8 11-14h-7z',
	),
	array(
		'title' => 'Xây dựng thương hiệu, tạo uy tín',
		'body'  => 'Ưu tiên báo lớn, lượng độc giả đông, vị trí nổi bật. Link <strong>nofollow</strong> vẫn có giá trị ở mục tiêu này - Google vẫn ghi nhận đây là tín hiệu ngữ cảnh cho E-E-A-T dù không truyền trực tiếp sức mạnh liên kết như dofollow.',
		'hint'  => 'Kết hợp nhiều đầu báo lớn cùng lúc để tăng độ phủ thương hiệu.',
		'icon'  => 'M12 2 4 6v6c0 5 3.4 8.4 8 10 4.6-1.6 8-5 8-10V6z',
	),
	array(
		'title' => 'Đúng tệp độc giả theo ngành',
		'body'  => 'Ưu tiên chọn báo/chuyên mục đúng lĩnh vực (bất động sản, tài chính, công nghệ, làm đẹp...) thay vì chỉ nhìn chỉ số DR - độc giả đúng ngành mới là người có khả năng chuyển đổi thành khách hàng.',
		'hint'  => 'Trong bảng giá phía trên: lọc theo cột Nhóm báo/lĩnh vực bên trái.',
		'icon'  => 'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75',
	),
	array(
		'title' => 'Xử lý khủng hoảng truyền thông',
		'body'  => 'Ưu tiên tốc độ đăng bài, đăng đồng thời trên nhiều đầu báo lớn để đẩy các kết quả tích cực lên trang tìm kiếm. Trường hợp này cần tư vấn trực tiếp thay vì tự chọn qua bảng giá, vì danh sách báo và thứ tự đăng cần cân nhắc theo tình huống cụ thể.',
		'hint'  => 'Gọi hotline để được tư vấn danh sách đăng nhanh trong ngày.',
		'icon'  => 'M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z',
	),
);
?>
<section class="sec bk-goals-sec">
	<div class="wrap">
		<div class="center" style="margin-bottom:26px">
			<span class="eyebrow">Chọn báo</span>
			<h2>Nên ưu tiên tiêu chí nào khi chọn báo?</h2>
			<p class="muted" style="max-width:640px;margin:8px auto 0">Bảng giá phía trên có nhiều đầu báo và vị trí khác nhau - dễ rối nếu chưa rõ mục tiêu. Bốn mục tiêu phổ biến nhất và cách chọn tương ứng:</p>
		</div>
		<div class="bk-goals">
			<?php foreach ( $dgc_goals as $gi => $g ) : ?>
			<div class="bk-goal">
				<span class="bk-goal-ic bk-goal-ic-<?php echo esc_attr( $gi % 2 === 0 ? 'a' : 'b' ); ?>"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="<?php echo esc_attr( $g['icon'] ); ?>"/></svg></span>
				<h3><?php echo esc_html( $g['title'] ); ?></h3>
				<p><?php echo wp_kses_post( $g['body'] ); ?></p>
				<p class="bk-goal-hint"><?php echo esc_html( $g['hint'] ); ?></p>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
/* MOI: day du dau bao hop tac - dung block chung voi trang chu (blk-press-partners.php),
   truoc day CHUA duoc include o trang nay du front-page.php da dan link "xem day du" ve day. */
include get_template_directory() . '/inc/blk-press-partners.php';
?>

<?php
/* ==========================================================================
   MOI: Vi sao chon DigicomVN cho booking bao & PR - 4 ly do, deu la fact da co
   that trong he thong (gia cong khai trong CPT dgc_gia, loc theo DR/nganh, quy
   trinh 4 buoc o order-guide.php, bien tap theo tung toa soan) - khong bia so lieu.
   ========================================================================== */
$dgc_bk_reasons = array(
	array( 'title' => 'Giá công khai, không giấu giá', 'body' => 'Mọi vị trí đăng bài hiện giá thật ngay trong bảng giá phía trên - không cần để lại thông tin mới biết giá, không có mức "giá ẩn" báo riêng qua tin nhắn.', 'icon' => 'M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6' ),
	array( 'title' => 'Lọc theo DR &amp; lĩnh vực minh bạch', 'body' => 'Mỗi đầu báo hiển thị chỉ số DR (Domain Rating) và gắn đúng lĩnh vực - dễ đối chiếu, không phải đoán mò trước khi chọn.', 'icon' => 'M20 6 9 17l-5-5' ),
	array( 'title' => 'Biên tập theo đúng chuẩn từng toà soạn', 'body' => 'Mỗi báo có quy định riêng về độ dài, số ảnh, số link cho phép - bài được biên tập khớp yêu cầu của đúng toà soạn trước khi gửi duyệt, giảm rủi ro bị từ chối đăng.', 'icon' => 'M12 20h9M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z' ),
	array( 'title' => 'Quy trình 4 bước, không hợp đồng dài dòng', 'body' => 'Từ lúc chọn báo đến khi nhận link bài đã đăng đi qua đúng 4 bước rõ ràng (xem chi tiết ở mục "Hướng dẫn đặt hàng" phía trên) - theo dõi được tiến độ ở từng bước.', 'icon' => 'M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z' ),
);
?>
<section class="sec-tight bk-reasons-sec" style="background:var(--surface-2);border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:22px">
			<span class="eyebrow">Vì sao DigicomVN</span>
			<h2>Đặt booking báo &amp; PR tại DigicomVN khác gì?</h2>
		</div>
		<div class="promos bk-reasons">
			<?php foreach ( $dgc_bk_reasons as $ri => $r ) : ?>
			<div class="promo">
				<span class="pico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="<?php echo esc_attr( $r['icon'] ); ?>"/></svg></span>
				<div class="pt"><?php echo wp_kses_post( $r['title'] ); ?></div>
				<div class="pd"><?php echo esc_html( $r['body'] ); ?></div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php if ( get_the_content() ) : ?>
<section class="sec"><div class="wrap page-content"><?php the_content(); ?></div></section>
<?php endif; ?>

<?php include get_template_directory() . '/inc/svc-faq.php'; ?>

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
				<p class="muted">Mỗi chiến dịch có mục tiêu khác nhau (SEO, xây thương hiệu, đúng tệp độc giả, xử lý khủng hoảng). Để lại thông tin, DigicomVN tư vấn danh sách báo phù hợp và gửi báo giá.</p>
				<ul class="page-content" style="font-size:15.5px"><li>Tư vấn miễn phí, không ràng buộc.</li><li>Báo giá rõ ràng theo từng vị trí đăng.</li><li>Đội ngũ biên tập nắm quy định từng toà soạn.</li></ul>
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
	<div><h2>Bắt đầu cùng DigicomVN</h2><p>Liên hệ ngay để được tư vấn danh sách đầu báo phù hợp mục tiêu và ngân sách của bạn.</p></div>
	<div class="cta-actions"><a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a><a class="btn btn-navy" href="#lien-he">Nhận báo giá</a></div>
</div></div></section>

<?php get_footer(); ?>
