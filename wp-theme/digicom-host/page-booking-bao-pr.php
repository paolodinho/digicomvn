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

<div class="wrap"><nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a><span class="sep">/</span> <?php echo esc_html( $svc_name ); ?></nav></div>

<!-- ============ 1. HERO ============ -->
<section class="bbp-hero svc3d-hero bbp-3d" data-svc3d-hero>
	<div class="svc3d-glow" aria-hidden="true"></div>
	<span class="bbp-blob bbp-blob-a" aria-hidden="true"></span>
	<span class="bbp-blob bbp-blob-b" aria-hidden="true"></span>
	<div class="wrap bbp-hero-grid">
		<div class="bbp-hero-copy">
			<span class="eyebrow">Dịch vụ Booking báo &amp; PR</span>
			<h1>Đăng bài PR trên báo điện tử uy tín, có bảng giá công khai từng đầu báo</h1>
			<p class="lead">DigicomVN nhận booking báo chí trọn gói: tư vấn chọn đầu báo theo mục tiêu, viết bài PR đúng văn phong toà soạn, đăng và bàn giao link sau khi bài lên. Giá niêm yết theo từng chuyên mục, không giấu giá.</p>
			<div class="bbp-hero-actions">
				<a class="btn btn-primary" href="#bang-gia">Xem bảng giá <?php echo esc_html( $bbp_count ); ?> vị trí</a>
				<a class="btn btn-ghost" href="#lien-he">Nhận tư vấn &amp; báo giá</a>
			</div>
			<p class="bbp-hero-sub"><a href="tel:<?php echo esc_attr( $tel ); ?>">Hoặc gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a> &middot; tư vấn chọn báo miễn phí, không ràng buộc</p>
		</div>

		<?php $bbp_h = dgc_svc_hero_data( 'booking-bao-pr' ); ?>
		<div class="svc3d-stage" aria-hidden="true">
			<?php if ( ! empty( $bbp_h['rows'] ) ) : ?>
			<div class="svc3d-board" data-svc3d-board>
				<div class="svc3d-board-head"><span>Bảng giá đầu báo</span><span class="svc3d-live">Cập nhật <?php echo esc_html( wp_date( 'd/m/Y' ) ); ?></span></div>
				<ol class="svc3d-rows">
					<?php foreach ( $bbp_h['rows'] as $i => $r ) : ?>
					<li style="--i:<?php echo (int) $i; ?>">
						<span class="svc3d-name"><?php echo esc_html( $r['name'] ); ?></span>
						<?php if ( $r['dr'] > 0 ) : ?><span class="svc3d-dr">DR <?php echo (int) $r['dr']; ?></span><?php else : ?><span></span><?php endif; ?>
						<span class="svc3d-price"><small>từ</small> <?php echo esc_html( number_format( $r['price'], 0, ',', '.' ) ); ?>đ</span>
					</li>
					<?php endforeach; ?>
				</ol>
				<div class="svc3d-board-foot">+ <?php echo (int) max( 0, $bbp_h['count'] - count( $bbp_h['rows'] ) ); ?> đầu báo khác trong bảng giá</div>
				<div class="svc3d-chip svc3d-chip-a"><b>VAT</b> Hợp đồng, hoá đơn đầy đủ</div>
				<div class="svc3d-chip svc3d-chip-b"><b>Link</b> Bàn giao bài đã đăng</div>
			</div>
			<?php endif; ?>
		</div>
	</div>

	<!-- Trust strip -->
	<div class="wrap">
		<ul class="bbp-trust">
			<li><b data-count="<?php echo (int) $bbp_outlets; ?>" data-suffix="+"><?php echo esc_html( $bbp_outlets ); ?>+</b><span>đầu báo, tạp chí hợp tác</span></li>
			<li><b data-count="<?php echo (int) $bbp_count; ?>"><?php echo esc_html( $bbp_count ); ?></b><span>vị trí có giá niêm yết công khai</span></li>
			<li><b>dofollow</b><span>hoặc nofollow tuỳ chuyên mục</span></li>
			<li><b>VAT</b><span>xuất hoá đơn, hợp đồng đầy đủ</span></li>
		</ul>
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
<?php if ( get_the_content() ) : ?>
<section class="sec"><div class="wrap page-content bbp-body"><?php the_content(); ?></div></section>
<?php endif; ?>

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

<section class="sec-tight"><div class="wrap"><div class="cta-band">
	<div><h2>Bắt đầu chiến dịch booking báo cùng DigicomVN</h2><p>Gửi mục tiêu truyền thông của bạn, nhận danh sách đầu báo và báo giá phù hợp ngân sách.</p></div>
	<div class="cta-actions"><a class="btn btn-ghost" href="tel:<?php echo esc_attr( $tel ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a><a class="btn btn-navy" href="#lien-he">Nhận báo giá</a></div>
</div></div></section>

<?php get_footer(); ?>
