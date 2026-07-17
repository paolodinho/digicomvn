<?php
/**
 * Widget tuong tac cho bai blog (2026-07-16):
 * 1. [dgc_budget_calc]  - may tinh ngan sach off-page: gia THAT tu CPT dgc_gia (khong bia so),
 *                         chon dich vu + muc DR + so luong -> khoang chi phi p25-p75.
 * 2. [dgc_offpage_quiz] - quiz 6 cau cham diem suc khoe off-page, goi y dich vu phu hop.
 * JS trong main.js, CSS trong main.css. Chen vao bai qua wp:shortcode.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/** Thong ke gia (p25/p50/p75) theo (nhom, bucket DR) tu CPT - cache 1h. */
function dgc_budget_calc_data() {
	$cached = get_transient( 'dgc_budget_calc_data' );
	if ( is_array( $cached ) && $cached ) return $cached;

	$groups = array(
		'booking-bao-pr'   => 'Booking báo & PR',
		'guest-post'       => 'Guest Post',
		'mua-textlink'     => 'Mua Textlink',
		'dich-vu-toplist'  => 'Dịch vụ Toplist',
		'backlink-quoc-te' => 'Backlink quốc tế',
	);
	$out = array();
	foreach ( $groups as $slug => $label ) {
		$buckets = array( 'all' => array(), 'hi' => array(), 'mid' => array(), 'lo' => array() );
		foreach ( dgc_get_gia( $slug ) as $it ) {
			$g = dgc_gia_to_number( $it->meta['gia_km'] ?? '' );
			if ( $g <= 0 ) continue;
			$dr = (int) ( $it->meta['dr'] ?? 0 );
			$buckets['all'][] = $g;
			if ( $dr >= 70 )     $buckets['hi'][]  = $g;
			elseif ( $dr >= 40 ) $buckets['mid'][] = $g;
			elseif ( $dr > 0 )   $buckets['lo'][]  = $g;
		}
		$stat = array();
		foreach ( $buckets as $k => $vals ) {
			if ( count( $vals ) < 3 ) continue;
			sort( $vals );
			$n = count( $vals );
			$stat[ $k ] = array(
				'p25' => (int) $vals[ (int) floor( $n * .25 ) ],
				'p75' => (int) $vals[ (int) floor( $n * .75 ) ],
				'n'   => $n,
			);
		}
		if ( $stat ) $out[ $slug ] = array( 'label' => $label, 'stat' => $stat );
	}
	set_transient( 'dgc_budget_calc_data', $out, HOUR_IN_SECONDS );
	return $out;
}

add_shortcode( 'dgc_budget_calc', function () {
	$data = dgc_budget_calc_data();
	if ( ! $data ) return '';
	ob_start(); ?>
<div class="bcalc" data-bcalc data-stats="<?php echo esc_attr( wp_json_encode( $data ) ); ?>">
	<p class="bcalc-title">Ước tính ngân sách off-page của bạn</p>
	<p class="bcalc-sub">Tính từ bảng giá thật DigicomVN đang bán - kéo thử để hình dung chi phí trước khi xem bảng giá chi tiết.</p>
	<div class="bcalc-controls">
		<label class="bcalc-field">
			<span>Dịch vụ</span>
			<select class="bcalc-svc">
				<?php foreach ( $data as $slug => $g ) : ?>
				<option value="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $g['label'] ); ?></option>
				<?php endforeach; ?>
			</select>
		</label>
		<label class="bcalc-field">
			<span>Độ mạnh site (DR)</span>
			<select class="bcalc-dr">
				<option value="all">Tất cả mức</option>
				<option value="hi">DR 70+ (báo/site đầu ngành)</option>
				<option value="mid">DR 40-69</option>
				<option value="lo">DR dưới 40</option>
			</select>
		</label>
		<label class="bcalc-field bcalc-field-qty">
			<span>Số lượng bài / link: <b class="bcalc-qty-val">3</b></span>
			<input type="range" class="bcalc-qty" min="1" max="20" step="1" value="3">
		</label>
	</div>
	<div class="bcalc-result">
		<span class="bcalc-result-label">Khoảng chi phí phổ biến</span>
		<span class="bcalc-result-num" aria-live="polite">-</span>
		<span class="bcalc-result-note">Giá tham khảo chưa gồm VAT, tính theo dải giá đang bán (không phải cam kết). Đặt nhiều mục có ưu đãi combo.</span>
	</div>
	<div class="bcalc-cta">
		<a class="btn btn-primary btn-sm" href="<?php echo esc_url( home_url( '/bang-gia/' ) ); ?>">Xem bảng giá chi tiết</a>
		<a class="btn btn-ghost btn-sm" href="<?php echo esc_url( home_url( '/dat-bai/' ) ); ?>">Gửi yêu cầu báo giá</a>
	</div>
</div>
<?php
	return ob_get_clean();
} );

/**
 * 3. [dgc_agency_check] - checklist cham diem agency booking bao chi (7 tieu chi).
 * Nguoi doc tick tung tieu chi ma agency dang xem xet dap ung -> ra diem + loi khuyen.
 */
add_shortcode( 'dgc_agency_check', function () {
	$items = array(
		'Có bảng giá công khai theo từng đầu báo, ghi rõ VAT',
		'Quy cách bài (số từ, ảnh, link dofollow/nofollow) ghi bằng văn bản',
		'Ký hợp đồng và xuất hoá đơn VAT đầy đủ',
		'Cam kết thời gian đăng + phương án khi báo từ chối bài',
		'Có đội ngũ hỗ trợ viết/biên tập bài chuẩn báo chí',
		'Gửi báo cáo link bài sau đăng, đúng chuyên mục cam kết',
		'Cho xem bài mẫu thật đã đăng trên đúng báo bạn cần',
	);
	ob_start(); ?>
<div class="acheck" data-acheck>
	<p class="acheck-title">Chấm điểm agency bạn đang cân nhắc</p>
	<p class="acheck-sub">Tick những tiêu chí agency đó đáp ứng được - kết quả hiện ngay bên dưới.</p>
	<div class="acheck-list">
	<?php foreach ( $items as $i => $it ) : ?>
		<label class="acheck-item"><input type="checkbox" data-v="1"><span><?php echo esc_html( $it ); ?></span></label>
	<?php endforeach; ?>
	</div>
	<div class="acheck-result" aria-live="polite"
		data-urls="<?php echo esc_attr( wp_json_encode( array(
			'booking' => home_url( '/booking-bao-pr/' ),
			'banggia' => home_url( '/bang-gia/' ),
		) ) ); ?>"></div>
</div>
<?php
	return ob_get_clean();
} );

add_shortcode( 'dgc_offpage_quiz', function () {
	ob_start(); ?>
<div class="oquiz" data-oquiz>
	<p class="oquiz-title">Kiểm tra nhanh: off-page của website bạn đang ở mức nào?</p>
	<p class="oquiz-sub">6 câu, trả lời trung thực - kết quả kèm việc nên làm trước tiên.</p>
	<?php
	$qs = array(
		'Website có backlink từ báo điện tử hoặc site DR 70+ chưa?',
		'3 tháng gần nhất có được trang nào khác nhắc tên thương hiệu không?',
		'Anchor text trỏ về site có đa dạng (thương hiệu + từ khoá + URL trần) không?',
		'Thương hiệu có hồ sơ social / Google Business Profile chuẩn NAP không?',
		'Có theo dõi backlink mới - mất hằng tháng (GSC, Ahrefs...) không?',
		'Đã từng đăng guest post hoặc bài PR chủ động chưa?',
	); ?>
	<div class="oquiz-list">
	<?php foreach ( $qs as $i => $q ) : ?>
		<div class="oquiz-q" data-q="<?php echo (int) $i; ?>">
			<span class="oquiz-q-text"><?php echo (int) ( $i + 1 ); ?>. <?php echo esc_html( $q ); ?></span>
			<span class="oquiz-q-btns" role="group">
				<button type="button" class="oquiz-yes" data-v="1">Có</button>
				<button type="button" class="oquiz-no" data-v="0">Chưa</button>
			</span>
		</div>
	<?php endforeach; ?>
	</div>
	<div class="oquiz-result" hidden aria-live="polite"
		data-urls="<?php echo esc_attr( wp_json_encode( array(
			'booking'  => home_url( '/booking-bao-pr/' ),
			'guest'    => home_url( '/guest-post/' ),
			'entity'   => home_url( '/backlink-social-entity/' ),
			'textlink' => home_url( '/mua-textlink/' ),
			'banggia'  => home_url( '/bang-gia/' ),
		) ) ); ?>"></div>
</div>
<?php
	return ob_get_clean();
} );
