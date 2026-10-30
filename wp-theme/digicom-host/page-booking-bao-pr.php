<?php
/**
 * Template Name: Booking bao & PR (money page rieng)
 *
 * Template RIENG cho /booking-bao-pr/ (page id 475) - money page cum "booking bao".
 * Thiet ke lai 2026-09-04: nhip thoang kieu MailBluster.
 *   hero + trust strip -> dai logo bao that -> "booking bao chi la gi" (co bang so sanh) ->
 *   loi ich (luoi icon) -> bang gia (#bang-gia) -> huong dan dat 4 buoc -> [the_content(): phan
 *   loai dau bao / chon theo dau bao / kien thuc cum / case study / luu y / tai lieu] ->
 *   FAQ rieng -> form bao gia -> cta band.
 * KHONG dung tpl-service.php (dung chung 7 pillar khac) - moi section thiet ke o day, CSS scoped .bbp-*.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

$nhom     = dgc_current_nhom();          // => array slug 'booking-bao-pr'
$svc_name = get_the_title();
$GLOBALS['dgc_promo_done'] = true;        // footer.php khong render lai promo-band

/* So lieu THAT - dem tu CPT dgc_gia (khong bia). Dung chung dgc_get_gia() voi service-pricing.php. */
$bbp_items   = function_exists( 'dgc_get_gia' ) ? dgc_get_gia( 'booking-bao-pr' ) : array();
$bbp_count   = count( $bbp_items );
$bbp_names   = array();
foreach ( $bbp_items as $it ) { $bbp_names[ trim( $it->post_title ) ] = 1; }
$bbp_outlets = count( $bbp_names );
$tel  = dgc_tel();
$zalo = preg_replace( '/[^0-9]/', '', dgc( 'zalo' ) );

/* Icon SVG inline nho gon cho luoi loi ich - khong dung ky tu emoji (rule). */
$bbp_ic = function ( $p ) {
	return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $p . '</svg>';
};
?>

<!-- ============ 1. HERO (giao dien sg, 2026-10-28) ============ -->
<?php $bbp_h = dgc_svc_hero_data( 'booking-bao-pr' ); ?>
<section class="sg-phero">
	<div class="wrap">
		<nav class="sg-crumb" aria-label="Breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a> / <span><?php echo esc_html( $svc_name ); ?></span></nav>
		<div class="sg-phero-row">
			<div>
				<h1>Booking báo chí: đăng bài PR trên báo điện tử uy tín, bảng giá công khai từng đầu&nbsp;báo</h1>
				<p class="sg-lead">DigicomVN nhận booking báo chí trọn gói: tư vấn chọn đầu báo theo mục tiêu, viết bài PR đúng văn phong toà soạn, đăng và bàn giao link sau khi bài lên. Giá niêm yết theo từng chuyên mục, không giấu giá.</p>
				<div class="sg-hero-cta">
					<a class="sg-btn sg-btn--light" href="#bang-gia"><?php echo dgc_arrow(); ?>Xem bảng giá <?php echo esc_html( $bbp_count ); ?> vị trí</a>
					<a class="sg-btn sg-btn--line" href="#lien-he"><?php echo dgc_arrow(); ?>Nhận tư vấn và báo giá</a>
				</div>
				<p class="sg-hero-note"><a href="tel:<?php echo esc_attr( $tel ); ?>">Hoặc gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a> &middot; tư vấn chọn báo miễn phí, không ràng buộc</p>
			</div>
			<?php if ( ! empty( $bbp_h['rows'] ) ) : ?>
			<aside class="sg-phero-card sg-pboard" aria-label="Bảng giá đầu báo">
				<h2>Bảng giá đầu báo</h2>
				<dl class="sg-pboard-stats">
					<div><dt>Đầu báo</dt><dd><?php echo (int) $bbp_outlets; ?>+</dd></div>
					<div><dt>Vị trí có giá</dt><dd><?php echo (int) $bbp_count; ?></dd></div>
					<?php if ( ! empty( $bbp_h['min'] ) ) : ?><div><dt>Giá chỉ từ</dt><dd><?php echo esc_html( dgc_svc_money( $bbp_h['min'] ) ); ?></dd></div><?php endif; ?>
				</dl>
				<ol class="sg-pboard-rows">
					<?php foreach ( array_slice( $bbp_h['rows'], 0, 5 ) as $r ) : ?>
					<li><span class="n"><?php echo esc_html( $r['name'] ); ?></span><?php if ( $r['dr'] > 0 ) : ?><span class="dr">DR <?php echo (int) $r['dr']; ?></span><?php else : ?><span></span><?php endif; ?><span class="p">từ <?php echo esc_html( number_format( $r['price'], 0, ',', '.' ) ); ?>đ</span></li>
					<?php endforeach; ?>
				</ol>
				<p class="sg-pboard-foot">Cập nhật <?php echo esc_html( wp_date( 'd/m/Y' ) ); ?> &middot; <a href="#bang-gia">Xem đủ bảng giá</a></p>
			</aside>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php /* 4 the dau tich da bo 30/10/2026 (van mau AI) - thay bang muc phan tich gia that ben duoi */ ?>

<!-- ============ 2. DAI LOGO DAU BAO THAT ============ -->
<?php include get_template_directory() . '/inc/blk-press-partners.php'; ?>

<!-- ============ 3. BOOKING BAO CHI LA GI ============ -->
<section class="sec bbp-concept">
	<div class="wrap bbp-concept-grid">
		<div class="bbp-concept-copy">
			<span class="eyebrow">Khái niệm</span>
			<h2>Booking báo chí là gì?</h2>
			<p><b>Booking báo chí</b> (đặt bài PR trên báo) là hình thức trả phí để đăng một bài viết mang thông điệp thương hiệu lên báo điện tử, tạp chí hoặc trang tin đã được cấp phép. Bài nằm trong <b>chuyên mục</b> hoặc <b>tiểu mục</b> phù hợp, mang tên tác giả toà soạn, và thường được gắn <b>link dofollow</b> hoặc nofollow trỏ về website của doanh nghiệp.</p>
			<p>Bài PR trên báo được giữ trên trang báo sau khi đăng và được Google lập chỉ mục, nên có thể được báo chí khác, AI Overview hay ChatGPT dẫn lại khi nói về thương hiệu. Quảng cáo banner thì dừng hiển thị khi hết ngân sách.</p>
			<p class="bbp-concept-links">
				Đọc thêm:
				<a href="/booking-bao-la-gi/">Tổng quan booking báo &amp; các hình thức</a> &middot;
				<a href="/so-sanh-booking-bao-pr-va-quang-cao-bao/">So sánh với quảng cáo báo</a> &middot;
				<a href="/advertorial-la-gi/">Advertorial là gì</a> &middot;
				<a href="/thong-cao-bao-chi-la-gi/">Thông cáo báo chí</a>
			</p>
		</div>

		<figure class="dgc-data-table bbp-concept-table">
			<figcaption style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0">So sánh booking báo chí với các hình thức truyền thông khác</figcaption>
			<table>
				<thead><tr><th>Hình thức</th><th class="col-kho">Thời gian tồn tại</th><th>Giá trị SEO / GEO</th></tr></thead>
				<tbody>
					<tr><td>Booking báo (advertorial)</td><td class="col-kho" data-label="Tồn tại">Lâu dài, còn index</td><td data-label="SEO/GEO">Cao - backlink báo, nguồn trích dẫn</td></tr>
					<tr><td>Thông cáo báo chí</td><td class="col-kho" data-label="Tồn tại">Lâu dài</td><td data-label="SEO/GEO">Trung bình - phủ tin đồng loạt</td></tr>
					<tr><td>Quảng cáo banner báo</td><td class="col-kho" data-label="Tồn tại">Hết ngân sách là dừng</td><td data-label="SEO/GEO">Thấp - không để lại trang</td></tr>
					<tr><td>Đăng fanpage / KOL</td><td class="col-kho" data-label="Tồn tại">Trôi theo dòng thời gian</td><td data-label="SEO/GEO">Thấp - mạng xã hội, ít index</td></tr>
				</tbody>
			</table>
		</figure>
	</div>
</section>

<!-- ============ 4. GIA DO DAU MA CHENH (so lieu bang gia that 30/10/2026, thay luoi "Vi sao chon" van mau) ============ -->
<section class="sec ws-story-sec">
	<div class="wrap ws-story">
		<div class="ws-story-text">
			<span class="eyebrow">Bảng giá booking báo</span>
			<h2>Giá một bài PR phụ thuộc vào tên báo, vị trí và điều kiện link</h2>
			<div class="page-content">
				<p>Ngày 30/10/2026, bảng giá trên trang này có 519 vị trí đăng của 319 đầu báo. Bài rẻ nhất 440.000đ, bài đắt nhất 183,86 triệu đồng, và một nửa số vị trí có giá dưới 1,5 triệu.</p>
				<p><b>Tên báo.</b> Nhóm báo lớn như VnExpress, Dân Trí, Tuổi Trẻ, Thanh Niên, Lao Động có giá trung vị khoảng 8,6 triệu một bài, báo tỉnh quanh 1,4 triệu. Báo lớn có lượng đọc và độ tin cậy với Google cao hơn, nhưng nếu khách hàng của bạn tập trung ở một tỉnh, bài trên báo của chính tỉnh đó thường đến đúng người đọc hơn.</p>
				<p><b>Vị trí trên báo.</b> Cùng một đầu báo, bài ở tiểu mục rẻ hơn nhiều so với bài lên trang chủ: Kênh14 tiểu mục 3,52 triệu, trang chủ 9,69 triệu; Lao Động mục Thông tin doanh nghiệp 5,7 triệu, gói kết hợp trang chủ 48,15 triệu. Bài trên trang chủ chỉ nằm ở đó một thời gian rồi trôi về chuyên mục, nên nếu mục tiêu chính là SEO, có thể chọn tiểu mục đúng chủ đề để tiết kiệm chi phí.</p>
			</div>
		</div>
		<figure class="ws-story-fig">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bbp-gia-pr.webp' ); ?>" width="1600" height="853" alt="Biểu đồ giá trung vị một bài PR theo loại vị trí: báo tỉnh 1,43 triệu, báo lớn chuyên mục 6,94 triệu, báo lớn trang chủ 30 triệu" loading="lazy" decoding="async">
			<figcaption>Tính từ bảng giá DigicomVN ngày 30/10/2026, giá chưa VAT. Giá từng báo có thể đổi theo toà soạn.</figcaption>
		</figure>
	</div>
</section>

<section class="sec ws-extra-sec" style="background:var(--surface-2);border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap" style="max-width:1000px">
		<div class="ws-extra-head"><span class="eyebrow">Điều kiện đi kèm</span><h2>Loại link và điều kiện đăng ở một số báo lớn</h2></div>
		<div class="page-content ws-extra">
			<p>Phần lớn báo lớn chỉ cho link nofollow, một số mục không cho chèn link, và có báo chỉ giữ link trong một thời hạn. Trong 519 vị trí đang niêm yết, 35 vị trí ghi rõ link dofollow, 18 ghi nofollow, 20 không chèn link; vị trí chưa ghi loại link thì nên hỏi lại trước khi chốt. Bảng dưới là điều kiện của một số báo lớn.</p>
			<div class="ws-scroll">
				<table>
					<caption style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0">Giá và điều kiện link theo vị trí của một số đầu báo lớn, ngày 30/10/2026</caption>
					<thead><tr><th>Đầu báo</th><th>Vị trí</th><th>Giá (chưa VAT)</th><th>Link và điều kiện</th></tr></thead>
					<tbody>
						<tr><td data-label="Đầu báo">Kênh14</td><td data-label="Vị trí">Tiểu mục / Trang chủ</td><td data-label="Giá">3,52 / 9,69 triệu</td><td data-label="Link">1 link nofollow, thêm link 300.000đ</td></tr>
						<tr><td data-label="Đầu báo">Lao Động</td><td data-label="Vị trí">Thông tin doanh nghiệp / Top 1-4 Kinh doanh</td><td data-label="Giá">5,7 / 21,89 triệu</td><td data-label="Link">Link tính thêm 1-3 triệu mỗi link, bài dưới 600-700 từ</td></tr>
						<tr><td data-label="Đầu báo">VnExpress</td><td data-label="Vị trí">Doanh nghiệp viết</td><td data-label="Giá">7,41 triệu</td><td data-label="Link">2 link nofollow, bài tồn tại 6 tháng</td></tr>
						<tr><td data-label="Đầu báo">VietNamNet</td><td data-label="Vị trí">Tiểu mục</td><td data-label="Giá">4,75 triệu</td><td data-label="Link">Link nofollow tính 5 triệu mỗi link, giữ 3 tháng</td></tr>
						<tr><td data-label="Đầu báo">Tuổi Trẻ</td><td data-label="Vị trí">Cần biết</td><td data-label="Giá">6,18 triệu</td><td data-label="Link">Không chèn link</td></tr>
					</tbody>
				</table>
			</div>
			<p>Bài PR mua để xây thương hiệu và để AI, báo chí khác có nguồn trích dẫn thì link nofollow vẫn dùng được. Bài mua để đẩy thứ hạng từ khoá thì nên ưu tiên vị trí dofollow, hoặc kết hợp với <a href="/guest-post/">guest post</a> và <a href="/mua-textlink/">textlink</a> trên site cùng ngành, chi phí thấp hơn nhiều.</p>
		</div>
	</div>
</section>

<!-- ============ 5. BANG GIA ============ -->
<?php
if ( $nhom ) {
	include get_template_directory() . '/inc/service-pricing.php';
	$dgc_og_ctx = $svc_name;
	include get_template_directory() . '/inc/order-guide.php';
}
?>

<!-- ============ 6. NOI DUNG BAI (post_content) - phan loai bao / chon dau bao / kien thuc / case study / luu y ============ -->

<!-- ============ 7. FAQ rieng ============ -->
<?php include get_template_directory() . '/inc/svc-faq.php'; ?>

<!-- ============ 8. FORM BAO GIA ============ -->
<section class="sec bbp-form-sec">
	<div class="wrap bbp-form-grid">
		<div>
			<span class="eyebrow">Báo giá</span>
			<h2>Nhận tư vấn &amp; báo giá booking báo &amp; PR</h2>
			<p class="muted">Cho biết ngành, mục tiêu và ngân sách dự kiến - DigicomVN đề xuất danh sách đầu báo phù hợp kèm báo giá chi tiết trong 24 giờ làm việc.</p>
			<ul class="bbp-form-list">
				<li>Tư vấn chọn báo miễn phí, không ràng buộc</li>
				<li>Báo giá theo đúng chuyên mục, không phát sinh</li>
				<li>Viết bài chuẩn báo chí, chỉnh sửa tới khi duyệt</li>
				<li>Bàn giao link bài đã lên kèm ảnh chụp vị trí</li>
			</ul>
			<p class="bbp-form-alt">Hoặc gọi <a href="tel:<?php echo esc_attr( $tel ); ?>"><?php echo esc_html( dgc( 'hotline' ) ); ?></a> &middot; <a href="https://zalo.me/<?php echo esc_attr( $zalo ); ?>" target="_blank" rel="noopener">nhắn Zalo</a></p>
		</div>
		<div>
			<?php
			$dgc_form_title   = 'Nhận báo giá booking báo & PR';
			$dgc_form_btn     = 'Gửi yêu cầu báo giá';
			$dgc_form_service = 'Booking báo & PR';
			include get_template_directory() . '/inc/form-lead.php';
			?>
		</div>
	</div>
</section>

<?php /* Hieu 28/10 "lam sau, co trong diem": bo dai CTA lap ngay duoi form (nut tro nguoc len chinh form). */ ?>

<?php if ( get_the_content() ) : /* Hieu 27/10: trang dich vu la landing - bai kien thuc dua xuong cuoi, thu gon, bam de doc tiep */ ?>
<section class="sec svc-knowledge"><div class="wrap">
	<div class="svc-knowledge-head"><span class="eyebrow">Tìm hiểu thêm</span><h2>Kiến thức về booking báo &amp; PR</h2></div>
	<div class="page-content bbp-body is-clamped" id="svc-knowledge-body"><?php the_content(); ?></div>
	<div class="svc-knowledge-more"><button type="button" class="btn btn-ghost" data-knowledge-toggle aria-controls="svc-knowledge-body" aria-expanded="false">Đọc toàn bộ hướng dẫn</button></div>
</div></section>
<?php endif; ?>

<?php get_footer(); ?>
