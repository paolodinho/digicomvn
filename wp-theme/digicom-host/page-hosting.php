<?php
/**
 * Template trang Hosting (page slug "hosting"). Viet lai 2026-10-27 khi mo dich vu hosting.
 * Gia doc tu option 'hosting_gia' (inc/domain-hosting.php). Dat qua form lead.
 * KHONG hien ten nha cung cap (rule dich-vu.md).
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
$dgc_hg = dgc_hosting_rows();
$dgc_hg_desc = array(
	'Hosting giá rẻ'                  => 'Website giới thiệu, blog cá nhân, landing page ít truy cập.',
	'Hosting phổ thông (Business)'    => 'Website doanh nghiệp nhỏ, cần nhiều tên miền trên một gói.',
	'Hosting WordPress Business'      => 'Website WordPress nhỏ, blog, landing page: cài WordPress sẵn, chạy LiteSpeed.',
	'Hosting WordPress'               => 'Tối ưu riêng cho WordPress: CPU và RAM cao hơn, chạy nhanh với plugin SEO, WooCommerce.',
	'Hosting doanh nghiệp (Enterprise)' => 'Website bán hàng, tin tức có lượng truy cập trung bình đến lớn.',
	'Hosting hiệu năng cao (Super)'   => 'Hệ thống nhiều website, lượng truy cập cao, cần tài nguyên riêng mạnh.',
	'Hosting WordPress hiệu năng cao' => 'Nhiều website WordPress lớn chạy trên cùng một gói tài nguyên mạnh.',
);
?>
<section class="sg-phero sg-phero--solo">
	<div class="wrap">
		<nav class="sg-crumb" aria-label="Breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a> / <a href="<?php echo esc_url( home_url( '/ten-mien/' ) ); ?>">Tên miền, hosting &amp; công cụ</a> / <span>Hosting</span></nav>
		<h1><?php echo esc_html( get_the_title() ?: 'Hosting giá rẻ, tốc độ cao' ); ?></h1>
		<p class="sg-lead">Hosting chạy LiteSpeed, chứng chỉ SSL miễn phí, có sao lưu dữ liệu, giá từ 16.000đ/tháng. DigicomVN tư vấn chọn gói đúng nhu cầu, cài đặt WordPress, trỏ tên miền và cấu hình tốc độ tải trang cho SEO.</p>
		<div class="sg-hero-cta"><a class="sg-btn sg-btn--light" href="#bang-gia"><?php echo dgc_arrow(); ?>Xem bảng giá hosting</a><a class="sg-btn sg-btn--line" href="#lien-he" data-order="Cần tư vấn chọn gói hosting" data-svc="Hosting"><?php echo dgc_arrow(); ?>Nhờ tư vấn chọn gói</a></div>
	</div>
</section>

<?php $dgc_hof = dgc_hg_offers(); if ( $dgc_hof ) : ?>
<section class="sec hg-offer-sec">
	<div class="wrap">
		<div class="hg-offer-head"><span class="eyebrow">Ưu đãi đang áp dụng</span><h2>Quà tặng khi đăng ký hosting mới</h2>
			<p class="muted">Giá trên bảng đã là giá ưu đãi. Ngoài ra, mỗi đơn hosting mới còn nhận thêm các quà tặng dưới đây theo điều kiện từng gói.</p></div>
		<ul class="hg-offers">
			<?php foreach ( $dgc_hof as $o ) : ?><li><b><?php echo esc_html( $o[0] ); ?></b><?php if ( $o[1] ) : ?><span><?php echo esc_html( $o[1] ); ?></span><?php endif; ?></li><?php endforeach; ?>
		</ul>
		<p class="hg-offer-note">Quà tặng áp dụng theo chương trình đang chạy tại thời điểm đăng ký, DigicomVN xác nhận quà cụ thể khi chốt đơn.</p>
	</div>
</section>
<?php endif; ?>

<?php $dgc_hg_on = function_exists( 'dgc_hg_online' ) ? dgc_hg_online() : array(); ?>
<section class="sec" id="bang-gia">
	<div class="wrap">
		<div class="center" style="margin-bottom:24px"><span class="eyebrow">Bảng giá</span><h2>Bảng giá hosting</h2>
			<p class="muted" style="max-width:720px;margin:8px auto 0">Giá/tháng là giá ưu đãi khi đăng ký theo kỳ hạn ghi dưới mỗi gói, dòng "Trọn N năm" là tổng tiền của kỳ hạn đó. "Đăng ký 1 năm" là tổng tiền khi chỉ đăng ký 12 tháng. Giá chưa gồm VAT.</p></div>
		<nav class="hg-tabs" aria-label="Nhóm gói hosting">
			<?php foreach ( array_keys( $dgc_hg ) as $i => $g ) : ?><a href="#hg-<?php echo (int) $i; ?>"><?php echo esc_html( $g ); ?></a><?php endforeach; ?>
		</nav>
		<?php foreach ( $dgc_hg as $g => $rows ) : $gi = array_search( $g, array_keys( $dgc_hg ), true ); ?>
		<div class="hg-group" id="hg-<?php echo (int) $gi; ?>">
			<h3><?php echo esc_html( $g ); ?></h3>
			<?php if ( ! empty( $dgc_hg_desc[ $g ] ) ) : ?><p class="muted"><?php echo esc_html( $dgc_hg_desc[ $g ] ); ?></p><?php endif; ?>
			<div class="hg-grid">
			<?php foreach ( $rows as $r ) : ?>
				<div class="hg-card">
					<?php $dgc_pct = ( (float) $r['goc'] > (float) $r['thang'] && (float) $r['goc'] ) ? (int) round( 100 - $r['thang'] * 100 / $r['goc'] ) : 0; ?>
					<div class="hg-name"><?php echo esc_html( $r['goi'] ); ?><?php if ( $dgc_pct >= 5 ) : ?><em class="hg-pct">Giảm <?php echo (int) $dgc_pct; ?>%</em><?php endif; ?></div>
					<div class="hg-price"><b><?php echo esc_html( dgc_vnd( $r['thang'] ) ); ?></b><span>/tháng</span></div>
					<?php if ( (float) $r['goc'] > (float) $r['thang'] ) : ?><div class="hg-old"><s><?php echo esc_html( dgc_vnd( $r['goc'] ) ); ?></s><?php if ( $r['ky'] ) : ?> khi đăng ký <?php echo esc_html( $r['ky'] ); ?> năm<?php endif; ?></div><?php endif; ?>
					<dl class="hg-spec">
						<div><dt>Dung lượng SSD</dt><dd><?php echo esc_html( $r['dl'] ); ?></dd></div>
						<div><dt>Số website</dt><dd><?php echo esc_html( $r['web'] ); ?></dd></div>
						<?php if ( $r['cpu'] ) : ?><div><dt>CPU / RAM</dt><dd><?php echo esc_html( $r['cpu'] ); ?></dd></div><?php endif; ?>
						<?php if ( (int) $r['ky'] > 0 && (float) $r['thang'] ) : ?><div><dt>Trọn <?php echo (int) $r['ky']; ?> năm</dt><dd><?php echo esc_html( dgc_vnd( $r['thang'] * 12 * (int) $r['ky'] ) ); ?></dd></div><?php endif; ?>
						<?php if ( (float) $r['nam'] ) : ?><div><dt>Đăng ký 1 năm</dt><dd><?php echo esc_html( dgc_vnd( $r['nam'] ) ); ?></dd></div><?php endif; ?>
					</dl>
					<?php $dgc_hk = dgc_hg_key( $r['goi'] ); $dgc_ho = $dgc_hg_on[ $dgc_hk ] ?? null; ?>
					<?php if ( $dgc_ho ) : $dgc_hm = max( array_keys( $dgc_ho['p'] ) ); ?>
					<div class="hg-buy"><button type="button" class="btn btn-primary btn-sm" data-hg-add="<?php echo esc_attr( $dgc_hk ); ?>" data-m="<?php echo (int) $dgc_hm; ?>">Mua ngay</button><a class="hg-ask" href="#lien-he" data-svc="Hosting" data-order="Tư vấn hosting gói <?php echo esc_attr( $r['goi'] ); ?> (<?php echo esc_attr( $g ); ?>)">Cần tư vấn</a></div>
					<?php else : ?>
					<a class="btn btn-ghost btn-sm" href="#lien-he" data-svc="Hosting" data-order="Đăng ký hosting gói <?php echo esc_attr( $r['goi'] ); ?> (<?php echo esc_attr( $g ); ?>)">Chọn gói này</a>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
			</div>
		</div>
		<?php endforeach; ?>
		<p class="muted" style="text-align:center;margin-top:10px">Mọi gói: băng thông không giới hạn, chứng chỉ SSL miễn phí. Cần cấu hình riêng (VPS, máy chủ riêng): <a href="#lien-he" data-svc="Hosting" data-order="Cần báo giá VPS / cấu hình hosting riêng">gửi yêu cầu báo giá</a>.</p>
		<?php include get_template_directory() . '/inc/price-note.php'; ?>
	</div>
</section>

<section class="sec hg-trust-sec">
	<div class="wrap">
		<div class="hg-offer-head"><span class="eyebrow">Đăng ký tại DigicomVN</span><h2>Mua hosting rõ ràng, có người hỗ trợ</h2></div>
		<ul class="hg-trust">
			<li><b>Hợp đồng, hoá đơn từ pháp nhân</b><span>Công ty TNHH Dịch vụ Truyền thông Digito Combat, MST 0109816406. Xuất hoá đơn theo thông tin doanh nghiệp của bạn.</span></li>
			<li><b>Thanh toán vào tài khoản công ty</b><span>Chuyển khoản MB Bank 567898838, chủ tài khoản Công ty TNHH DVTT Digito Combat.</span></li>
			<li><b>Hạ tầng tốc độ cao</b><span>Ổ NVMe, máy chủ web LiteSpeed bản quyền, chứng chỉ SSL miễn phí và trang quản trị cPanel.</span></li>
			<li><b>Cài đặt giúp bạn</b><span>Cài WordPress, trỏ tên miền, bật SSL và cấu hình tốc độ tải trang cho SEO. Hỗ trợ qua hotline <a href="tel:0988769317">0988&nbsp;769&nbsp;317</a> và Zalo.</span></li>
		</ul>
	</div>
</section>

<section class="sec" style="background:var(--surface-2);border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap" style="max-width:960px">
		<div class="center" style="margin-bottom:28px"><span class="eyebrow">Tư vấn</span><h2>Hosting ảnh hưởng tới SEO thế nào?</h2></div>
		<div class="page-content">
			<p>Google dùng chỉ số trải nghiệm trang (Core Web Vitals) làm một trong các tín hiệu xếp hạng. Trong đó thời gian máy chủ phản hồi (TTFB) phụ thuộc trực tiếp vào hosting: máy chủ đặt xa người dùng hoặc thiếu tài nguyên làm trang tải chậm, người dùng rời đi trước khi đọc nội dung. Khách hàng chủ yếu ở Việt Nam thì nên chọn máy chủ đặt gần người dùng Việt Nam.</p>
			<p>Hosting không thay được nội dung tốt và liên kết uy tín, nhưng hosting yếu sẽ kéo lùi mọi công sức SEO khác. Cách chọn nhanh: website giới thiệu dưới 10 trang dùng gói giá rẻ; website WordPress có nhiều plugin, bán hàng hoặc đăng bài hằng ngày dùng nhóm WordPress hoặc Enterprise; chạy nhiều website vệ tinh thì chọn gói nhiều tên miền thay vì mua lẻ.</p>
			<p>Tham khảo thêm: <a href="https://developers.google.com/search/docs/appearance/page-experience" target="_blank" rel="noopener">tài liệu Page Experience của Google</a>. Cần làm SEO trọn gói cho website mới: xem <a href="<?php echo esc_url( home_url( '/dich-vu-seo/' ) ); ?>">dịch vụ SEO</a>; chưa có tên miền: <a href="<?php echo esc_url( home_url( '/ten-mien/' ) ); ?>">đăng ký tên miền</a>.</p>
		</div>
		<ol class="tm-steps">
			<li><b>Chọn gói</b><span>Bấm "Mua ngay" ở gói phù hợp, chọn thời hạn và tên miền dùng cho hosting.</span></li>
			<li><b>Điền thông tin</b><span>Nhập thông tin chủ thể dịch vụ trong giỏ hàng, hệ thống tạo đơn ngay.</span></li>
			<li><b>Thanh toán</b><span>Quét mã QR chuyển khoản, hệ thống tự xác nhận khi tiền về.</span></li>
			<li><b>Kích hoạt</b><span>Hosting tự khởi tạo, thông tin đăng nhập quản trị gửi qua email. DigicomVN hỗ trợ cài WordPress và trỏ tên miền.</span></li>
		</ol>
	</div>
</section>

<?php if ( trim( get_post_field( 'post_content', get_the_ID() ) ) ) : ?>
<section class="sec"><div class="wrap page-content" style="max-width:960px"><?php the_content(); ?></div></section>
<?php endif; ?>

<?php include get_template_directory() . '/inc/svc-faq.php'; ?>

<section class="sec">
	<div class="wrap" style="max-width:720px">
		<?php
		$dgc_form_title   = 'Đăng ký hosting';
		$dgc_form_btn     = 'Gửi yêu cầu đăng ký';
		$dgc_form_service = 'Hosting';
		include get_template_directory() . '/inc/form-lead.php';
		?>
	</div>
</section>
<?php include get_template_directory() . '/inc/order-prefill.php'; ?>
<script>
document.addEventListener('click',function(e){
	var b=e.target.closest('[data-hg-add]'); if(!b) return;
	var c=[]; try{ c=JSON.parse(localStorage.getItem('dgc_tm_cart')||'[]'); }catch(x){}
	var k=b.getAttribute('data-hg-add'), i=c.findIndex(function(x){ return x.t==='h' && x.k===k && !x.d; });
	if(i<0) c.push({t:'h',k:k,m:+b.getAttribute('data-m'),d:''});
	try{ localStorage.setItem('dgc_tm_cart',JSON.stringify(c)); }catch(x){}
	location.href='<?php echo esc_js( home_url( '/thanh-toan-ten-mien/' ) ); ?>';
});
</script>
<?php get_footer(); ?>
