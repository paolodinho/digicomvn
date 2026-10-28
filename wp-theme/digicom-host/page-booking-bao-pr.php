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
				<span class="sg-eyebrow">Booking báo &amp; truyền thông</span>
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

<section class="sg-sec sg-sec--tight sg-sec--cyan">
	<div class="wrap">
		<div class="sg-benefits sg-benefits--4 sg-benefits--light">
			<?php $bbp_chk = '<span class="sg-ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5 9-10"/></svg></span>'; ?>
			<div class="sg-card"><?php echo $bbp_chk; // phpcs:ignore ?><h3><?php echo esc_html( $bbp_outlets ); ?>+ đầu báo</h3><p>Báo điện tử, tạp chí hợp tác trên toàn quốc.</p></div>
			<div class="sg-card"><?php echo $bbp_chk; // phpcs:ignore ?><h3><?php echo esc_html( $bbp_count ); ?> vị trí có giá</h3><p>Giá niêm yết công khai theo từng chuyên mục.</p></div>
			<div class="sg-card"><?php echo $bbp_chk; // phpcs:ignore ?><h3>Dofollow / nofollow</h3><p>Ghi rõ loại link theo từng chuyên mục.</p></div>
			<div class="sg-card"><?php echo $bbp_chk; // phpcs:ignore ?><h3>Hoá đơn VAT</h3><p>Hợp đồng, hoá đơn đầy đủ cho doanh nghiệp.</p></div>
		</div>
	</div>
</section>

<!-- ============ 2. DAI LOGO DAU BAO THAT ============ -->
<?php include get_template_directory() . '/inc/blk-press-partners.php'; ?>

<!-- ============ 3. BOOKING BAO CHI LA GI ============ -->
<section class="sec bbp-concept">
	<div class="wrap bbp-concept-grid">
		<div class="bbp-concept-copy">
			<span class="eyebrow">Khái niệm</span>
			<h2>Booking báo chí là gì?</h2>
			<p><b>Booking báo chí</b> (đặt bài PR trên báo) là hình thức trả phí để đăng một bài viết mang thông điệp thương hiệu lên báo điện tử, tạp chí hoặc trang tin đã được cấp phép. Bài nằm trong <b>chuyên mục</b> hoặc <b>tiểu mục</b> phù hợp, mang tên tác giả toà soạn, và thường được gắn <b>link dofollow</b> hoặc nofollow trỏ về website của doanh nghiệp.</p>
			<p>Khác với <b>quảng cáo hiển thị</b> (banner biến mất khi hết ngân sách) hay bài đăng fanpage, một bài <b>advertorial</b> đặt trên báo tồn tại lâu dài, được Google lập chỉ mục và trở thành tài sản truyền thông - nguồn dẫn khi báo chí, AI Overview hay ChatGPT trích dẫn về thương hiệu (tín hiệu E-E-A-T, GEO).</p>
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

<!-- ============ 4. VI SAO CHON DIGICOM ============ -->
<section class="sec bbp-benefits" style="background:var(--surface-2);border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap bbp-why">
		<div class="center bbp-why-head">
			<span class="eyebrow">Vì sao chọn DigicomVN</span>
			<h2>Booking báo &amp; PR trọn gói, minh bạch từ giá tới link bàn giao</h2>
			<p class="muted">Một đầu mối cho toàn bộ mạng lưới báo điện tử - thay vì liên hệ, thương lượng và theo dõi từng toà soạn riêng lẻ.</p>
		</div>
		<dl class="bbp-why-list">
				<div class="bbp-why-row">
					<dt><span class="bbp-why-ic"><?php echo $bbp_ic( '<path d="M4 7h16M4 12h16M4 17h10"/>' ); ?></span>Bảng giá công khai từng đầu báo</dt>
					<dd><?php echo esc_html( $bbp_count ); ?> vị trí niêm yết theo chuyên mục, DR và loại link - lọc theo ngành, khoảng giá, so sánh ngay không cần chờ báo giá.</dd>
				</div>
				<div class="bbp-why-row">
					<dt><span class="bbp-why-ic"><?php echo $bbp_ic( '<path d="M12 20V10M6 20V4M18 20v-7"/>' ); ?></span>Chọn báo theo mục tiêu</dt>
					<dd>Đẩy top từ khoá, ra mắt sản phẩm, tuyển dụng hay xử lý khủng hoảng truyền thông - mỗi mục tiêu cần bộ đầu báo và chuyên mục khác nhau.</dd>
				</div>
				<div class="bbp-why-row">
					<dt><span class="bbp-why-ic"><?php echo $bbp_ic( '<path d="M4 19V5a2 2 0 0 1 2-2h9l5 5v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2Z"/><path d="M8 12h8M8 16h6"/>' ); ?></span>Viết bài đúng văn phong toà soạn</dt>
					<dd>Đội biên tập viết theo chuẩn từng báo (tiêu đề, sapo, độ dài, cách nhắc thương hiệu) để bài được duyệt nhanh và đọc tự nhiên.</dd>
				</div>
				<div class="bbp-why-row">
					<dt><span class="bbp-why-ic"><?php echo $bbp_ic( '<path d="M20 6 9 17l-5-5"/>' ); ?></span>Bàn giao link, theo dõi tiến độ</dt>
					<dd>Xác nhận báo còn nhận bài trước khi chốt, cập nhật trạng thái từng bước, bàn giao đường link bài đã lên kèm ảnh chụp vị trí.</dd>
				</div>
				<div class="bbp-why-row">
					<dt><span class="bbp-why-ic"><?php echo $bbp_ic( '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>' ); ?></span>Tài sản truyền thông lâu dài</dt>
					<dd>Bài PR trên báo còn index nhiều năm, tạo backlink từ tên miền uy tín và nguồn dẫn khi AI, báo chí nói về thương hiệu.</dd>
				</div>
				<div class="bbp-why-row">
					<dt><span class="bbp-why-ic"><?php echo $bbp_ic( '<path d="M9 12h6m-6 4h6M6 4h9l5 5v9a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"/>' ); ?></span>Hoá đơn VAT, hợp đồng rõ ràng</dt>
					<dd>Xuất hoá đơn đầy đủ, hợp đồng dịch vụ minh bạch - phù hợp doanh nghiệp cần chứng từ cho ngân sách marketing.</dd>
				</div>
		</dl>
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
