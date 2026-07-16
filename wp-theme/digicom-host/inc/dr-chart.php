<?php
/**
 * Bieu do so sanh DR (Domain Rating) giua cac bao - dung trong bai /book-bao-<bao>/.
 * Shortcode: [dgc_dr_chart bao="vnexpress.net"] - "bao" = domain dang duoc highlight.
 * DR doc LIVE tu CPT dgc_gia (meta "dr", nhom booking-bao-pr) -> routine cap nhat gia/DR
 * thi bieu do tu cap nhat, khong chon so cung vao bai.
 * Interactive: thanh chay animation khi cuon toi (JS trong main.js), hover highlight,
 * bam 1 hang -> sang bai book-bao tuong ung.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/** 15 bao co bai bao gia le: domain => [nhan hien thi, slug bai blog]. */
function dgc_dr_chart_outlets() {
	return array(
		'vnexpress.net'   => array( 'VnExpress', 'book-bao-vnexpress' ),
		'thanhnien.vn'    => array( 'Thanh Niên', 'book-bao-thanh-nien' ),
		'vietnamnet.vn'   => array( 'VietNamNet', 'book-bao-vietnamnet' ),
		'tuoitre.vn'      => array( 'Tuổi Trẻ', 'book-bao-tuoi-tre' ),
		'dantri.com.vn'   => array( 'Dân Trí', 'book-bao-dan-tri' ),
		'24h.com.vn'      => array( '24h', 'book-bao-24h' ),
		'kenh14.vn'       => array( 'Kenh14', 'book-bao-kenh14' ),
		'cafef.vn'        => array( 'CafeF', 'book-bao-cafef' ),
		'znews.vn'        => array( 'Znews', 'book-bao-znews' ),
		'soha.vn'         => array( 'Soha', 'book-bao-soha' ),
		'afamily.vn'      => array( 'aFamily', 'book-bao-afamily' ),
		'eva.vn'          => array( 'Eva', 'book-bao-eva' ),
		'cafebiz.vn'      => array( 'CafeBiz', 'book-bao-cafebiz' ),
		'webtretho.com'   => array( 'Webtretho', 'book-bao-webtretho' ),
		'baodautu.vn'     => array( 'Báo Đầu Tư', 'book-bao-bao-dau-tu' ),
	);
}

/** Map domain => DR lon nhat tim thay trong CPT (cache 1h). */
function dgc_dr_chart_data() {
	$cached = get_transient( 'dgc_dr_chart_data' );
	if ( is_array( $cached ) && $cached ) return $cached;

	$dr_map = array();
	foreach ( dgc_get_gia( 'booking-bao-pr' ) as $it ) {
		$dom = strtolower( trim( $it->post_title ) );
		$dr  = (int) ( $it->meta['dr'] ?? 0 );
		if ( $dr > 0 && ( ! isset( $dr_map[ $dom ] ) || $dr > $dr_map[ $dom ] ) ) $dr_map[ $dom ] = $dr;
	}
	set_transient( 'dgc_dr_chart_data', $dr_map, HOUR_IN_SECONDS );
	return $dr_map;
}

add_shortcode( 'dgc_dr_chart', function ( $atts ) {
	$a       = shortcode_atts( array( 'bao' => '' ), $atts, 'dgc_dr_chart' );
	$current = strtolower( trim( $a['bao'] ) );
	$dr_map  = dgc_dr_chart_data();
	$outlets = dgc_dr_chart_outlets();

	$rows = array();
	foreach ( $outlets as $dom => $info ) {
		if ( empty( $dr_map[ $dom ] ) ) continue;
		$rows[] = array(
			'dom'   => $dom,
			'label' => $info[0],
			'slug'  => $info[1],
			'dr'    => $dr_map[ $dom ],
			'cur'   => ( $dom === $current ),
		);
	}
	if ( count( $rows ) < 3 ) return '';
	usort( $rows, function ( $x, $y ) { return $y['dr'] <=> $x['dr']; } );

	$cur_label = '';
	foreach ( $rows as $r ) if ( $r['cur'] ) $cur_label = $r['label'];

	ob_start(); ?>
<div class="dr-chart" data-dr-chart>
	<p class="dr-chart-title">Độ mạnh tên miền (DR) - <?php echo $cur_label ? esc_html( $cur_label ) . ' so với các báo phổ biến' : 'so sánh các báo phổ biến'; ?></p>
	<div class="dr-chart-rows">
	<?php foreach ( $rows as $r ) :
		$w = max( 4, min( 100, $r['dr'] ) ); ?>
		<a class="dr-row<?php echo $r['cur'] ? ' is-current' : ''; ?>"
			href="<?php echo esc_url( home_url( '/' . $r['slug'] . '/' ) ); ?>"
			title="<?php echo esc_attr( $r['label'] . ' - DR ' . $r['dr'] . '/100 (Ahrefs). Xem bảng giá.' ); ?>"
			<?php echo $r['cur'] ? 'aria-current="true"' : ''; ?>>
			<span class="dr-row-name"><?php echo esc_html( $r['label'] ); ?><?php echo $r['cur'] ? '<span class="dr-row-badge">bài này</span>' : ''; ?></span>
			<span class="dr-row-track"><span class="dr-row-bar" style="--dr-w:<?php echo (int) $w; ?>%"></span></span>
			<span class="dr-row-val">DR <?php echo (int) $r['dr']; ?></span>
		</a>
	<?php endforeach; ?>
	</div>
	<p class="dr-chart-note">DR (Domain Rating) theo dữ liệu Ahrefs mà DigicomVN theo dõi, thang 0-100. Bấm vào từng báo để xem bảng giá tương ứng.</p>
</div>
<?php
	return ob_get_clean();
} );
