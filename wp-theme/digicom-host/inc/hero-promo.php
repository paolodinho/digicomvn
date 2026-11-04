<?php
/**
 * Trang chu (Hieu 02/11/2026: "seo la seo, hosting la hosting"):
 *  - Hero = SLIDER chuong trinh uu dai, moi slide 1 chuong trinh cua 1 dich vu (option hero_slides).
 *  - Duoi hero = cac nhom dich vu chung (option home_groups + home_group_links), thu tu theo menu.
 * Sua o WP Admin > DigicomVN > muc 2 / 2b. Gia KHONG nhap tay: lay tu bang gia that
 *  - cloud: dgc_web_rows('cloud-server') (muc 12), hosting: dgc_hosting_rows(), booking: CPT dgc_gia,
 *    tenmien: dgc_ten_mien_rows(), email: dgc_web_rows('email-doanh-nghiep').
 * Tat slider: hero_promo_on = 0 (hero chi con tieu de + mo ta).
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function dgc_hero_promo_on() {
	return '0' !== trim( (string) dgc( 'hero_promo_on', '1' ) );
}

/** Gia thap nhat dang ban: 'hosting' | 'booking' | 'tenmien' | 'email' | 'cloud' | slug nhom dgc_gia | so cu the. Cache 6 gio. */
function dgc_hero_promo_min( $src ) {
	$src = trim( (string) $src );
	if ( '' === $src ) return 0;
	if ( ctype_digit( str_replace( '.', '', $src ) ) ) return (int) str_replace( '.', '', $src );
	$key = 'dgc_hp_min_' . md5( $src );
	$v   = get_transient( $key );
	if ( false !== $v ) return (int) $v;
	$min = 0;
	if ( 'hosting' === $src && function_exists( 'dgc_hosting_rows' ) ) {
		foreach ( dgc_hosting_rows() as $rows ) {
			foreach ( $rows as $r ) {
				$p = (float) preg_replace( '/\D/', '', (string) $r['thang'] );
				if ( $p > 0 && ( ! $min || $p < $min ) ) $min = $p;
			}
		}
	} elseif ( 'tenmien' === $src && function_exists( 'dgc_ten_mien_rows' ) ) {
		$min = dgc_min_price( dgc_ten_mien_rows(), 'gia' );
	} elseif ( in_array( $src, array( 'email', 'cloud' ), true ) && function_exists( 'dgc_web_rows' ) ) {
		foreach ( dgc_web_rows( 'email' === $src ? 'email-doanh-nghiep' : 'cloud-server' ) as $rows ) {
			foreach ( $rows as $r ) {
				$p = (int) $r['gia'];
				if ( $p > 0 && ( ! $min || $p < $min ) ) $min = $p;
			}
		}
	} elseif ( function_exists( 'dgc_get_gia' ) && function_exists( 'dgc_gia_to_number' ) ) {
		$nhom = ( 'booking' === $src ) ? 'booking-bao-pr' : $src;
		foreach ( dgc_get_gia( $nhom ) as $it ) {
			$p = dgc_gia_to_number( $it->meta['gia_km'] ?? '' );
			if ( $p > 0 && ( ! $min || $p < $min ) ) $min = $p;
		}
	}
	set_transient( $key, (int) $min, 6 * HOUR_IN_SECONDS );
	return (int) $min;
}

/** Goi cloud hien trong slide cloud: dong "Ten goi | dung cho | 1" khop ten goi o bang gia cloud server. */
function dgc_hero_promo_plans() {
	$all = array();
	if ( function_exists( 'dgc_web_rows' ) ) {
		foreach ( dgc_web_rows( 'cloud-server' ) as $rows ) {
			foreach ( $rows as $r ) $all[ strtolower( $r['goi'] ) ] = $r;
		}
	}
	$out = array();
	foreach ( dgc_lines( 'hero_promo_plans' ) as $l ) {
		$k = strtolower( $l[0] ?? '' );
		if ( '' === $k || empty( $all[ $k ] ) || ! $all[ $k ]['gia'] ) continue;
		$r = $all[ $k ];
		$spec = array_slice( array_filter( $r['spec'], function ( $s ) { return false === stripos( $s, 'băng thông' ); } ), 0, 3 );
		$out[] = array(
			'goi'  => $r['goi'],
			'fit'  => $l[1] ?? '',
			'gia'  => $r['gia'],
			'dv'   => $r['dv'] ?: '/tháng',
			'spec' => implode( ', ', $spec ),
			'pick' => ! empty( $l[2] ),
		);
	}
	return $out;
}

/** Link trong site con hoat dong khong (trang/bai publish, hoac neo #). */
function dgc_home_link_live( $u ) {
	$u = trim( (string) $u );
	if ( '' === $u ) return false;
	if ( '#' === $u[0] || '/' === $u ) return true;
	$path = strtok( $u, '#' );
	if ( dgc_page_live( $path ) ) return true;
	$id = url_to_postid( home_url( $path ) );
	return $id && 'publish' === get_post_status( $id );
}

/**
 * Slide hero. Option hero_slides, moi dong:
 * nhan | tieu de | mo ta | nguon gia | don vi | duong dan | chu tren nut
 * Nguon gia: cloud (hien cac goi o hero_promo_plans), hosting, booking, tenmien, email, so cu the,
 * hoac chu (vd "Miễn phí"). De trong = khong hien gia.
 */
function dgc_hero_slides() {
	$out = array();
	foreach ( dgc_lines( 'hero_slides' ) as $l ) {
		if ( empty( $l[1] ) || empty( $l[5] ) || ! dgc_home_link_live( $l[5] ) ) continue;
		$src   = trim( $l[3] ?? '' );
		$plans = ( 'cloud' === $src ) ? dgc_hero_promo_plans() : array();
		$min   = 0; $txt = '';
		if ( '' !== $src && ! $plans ) {
			$min = in_array( $src, array( 'hosting', 'booking', 'tenmien', 'email', 'cloud' ), true ) || ctype_digit( str_replace( '.', '', $src ) ) || preg_match( '/^[a-z0-9-]+$/', $src ) ? dgc_hero_promo_min( $src ) : 0;
			if ( ! $min && ! preg_match( '/^[a-z0-9-]+$/', $src ) ) $txt = $src;
		}
		$out[] = array(
			'tag' => $l[0] ?? '', 'title' => $l[1], 'desc' => $l[2] ?? '', 'plans' => $plans,
			'min' => $min, 'txt' => $txt, 'dv' => $l[4] ?? '', 'url' => $l[5], 'btn' => ( $l[6] ?? '' ) ?: 'Xem chi tiết',
		);
	}
	return $out;
}

function dgc_hero_slider() {
	if ( ! dgc_hero_promo_on() ) return;
	$slides = dgc_hero_slides();
	if ( ! $slides ) return;
	$n = count( $slides );
	?>
	<section class="sg-hs" aria-roledescription="carousel" aria-label="<?php echo esc_attr( dgc( 'hero_promo_label', 'Chương trình ưu đãi đang áp dụng' ) ); ?>"<?php echo $n > 1 ? ' data-hs' : ''; ?>>
		<div class="wrap">
			<div class="sg-hs-track" aria-live="off">
				<?php foreach ( $slides as $i => $s ) : ?>
				<div class="sg-hs-slide<?php echo 0 === $i ? ' is-on' : ''; ?>" role="group" aria-roledescription="slide" aria-label="<?php echo esc_attr( ( $i + 1 ) . ' / ' . $n . ': ' . $s['title'] ); ?>"<?php echo 0 === $i ? '' : ' aria-hidden="true"'; ?>>
					<div class="sg-hs-copy">
						<?php if ( $s['tag'] ) : ?><p class="sg-hs-tag"><?php echo esc_html( $s['tag'] ); ?></p><?php endif; ?>
						<p class="sg-hs-title"><?php echo esc_html( $s['title'] ); ?></p>
						<?php if ( $s['desc'] ) : ?><p class="sg-hs-desc"><?php echo esc_html( $s['desc'] ); ?></p><?php endif; ?>
						<a class="sg-btn sg-btn--light" href="<?php echo esc_url( 0 === strpos( $s['url'], '#' ) ? $s['url'] : home_url( $s['url'] ) ); ?>"<?php echo 0 === $i ? '' : ' tabindex="-1"'; ?>><?php echo dgc_arrow(); // phpcs:ignore ?><?php echo esc_html( $s['btn'] ); ?></a>
					</div>
					<?php if ( $s['plans'] ) : ?>
					<ul class="sg-hs-plans">
						<?php foreach ( $s['plans'] as $p ) : ?>
						<li<?php echo $p['pick'] ? ' class="is-pick"' : ''; ?>>
							<span class="nm"><?php echo esc_html( $p['goi'] ); ?><?php if ( $p['fit'] ) : ?> <small><?php echo esc_html( $p['fit'] ); ?></small><?php endif; ?></span>
							<span class="pr"><?php echo esc_html( dgc_vnd( $p['gia'] ) ); ?><small><?php echo esc_html( $p['dv'] ); ?></small></span>
							<?php if ( $p['spec'] ) : ?><span class="sp"><?php echo esc_html( $p['spec'] ); ?></span><?php endif; ?>
						</li>
						<?php endforeach; ?>
					</ul>
					<?php elseif ( $s['min'] || $s['txt'] ) : ?>
					<div class="sg-hs-price">
						<?php if ( $s['min'] ) : ?><span class="lb">Giá từ</span><b><?php echo esc_html( dgc_vnd( $s['min'] ) ); ?></b><?php if ( $s['dv'] ) : ?><span class="dv"><?php echo esc_html( $s['dv'] ); ?></span><?php endif; ?>
						<?php else : ?><b><?php echo esc_html( $s['txt'] ); ?></b><?php if ( $s['dv'] ) : ?><span class="dv"><?php echo esc_html( $s['dv'] ); ?></span><?php endif; ?><?php endif; ?>
					</div>
					<?php endif; ?>
				</div>
				<?php endforeach; ?>
			</div>
			<?php if ( $n > 1 ) : ?>
			<div class="sg-hs-nav">
				<button type="button" class="sg-hs-arr" data-hs-prev aria-label="Chương trình trước"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 5l-7 7 7 7"/></svg></button>
				<div class="sg-hs-dots">
					<?php foreach ( $slides as $i => $s ) : ?><button type="button" data-hs-go="<?php echo (int) $i; ?>" aria-label="<?php echo esc_attr( 'Xem chương trình ' . ( $i + 1 ) . ': ' . $s['title'] ); ?>"<?php echo 0 === $i ? ' aria-current="true"' : ''; ?>></button><?php endforeach; ?>
				</div>
				<button type="button" class="sg-hs-arr" data-hs-next aria-label="Chương trình tiếp theo"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 5l7 7-7 7"/></svg></button>
				<button type="button" class="sg-hs-pause" data-hs-pause aria-label="Tạm dừng tự chuyển"><svg viewBox="0 0 24 24" aria-hidden="true"><path class="ps" d="M9 6v12M15 6v12"/><path class="pl" d="M8 5l11 7-11 7z"/></svg></button>
			</div>
			<?php endif; ?>
			<?php if ( dgc( 'hero_promo_note' ) ) : ?><p class="sg-hs-note"><?php echo esc_html( dgc( 'hero_promo_note' ) ); ?></p><?php endif; ?>
		</div>
	</section>
	<?php
}

/**
 * Nhom dich vu tren trang chu.
 * home_groups, moi dong: Ten nhom | duong dan chinh | mo ta | nguon gia (booking, tenmien+hosting, chu...) | chu tren nut
 * home_group_links, moi dong: Ten nhom | tieu de muc con | ten dich vu | duong dan
 */
function dgc_home_groups() {
	$links = array();
	foreach ( dgc_lines( 'home_group_links' ) as $l ) {
		if ( count( $l ) < 4 || '' === $l[2] || ! dgc_home_link_live( $l[3] ) ) continue;
		$links[ $l[0] ][ $l[1] ][] = array( $l[2], $l[3] );
	}
	$out = array();
	foreach ( dgc_lines( 'home_groups' ) as $g ) {
		if ( empty( $g[0] ) ) continue;
		$price = '';
		foreach ( array_filter( array_map( 'trim', explode( '+', $g[3] ?? '' ) ) ) as $src ) {
			$lbl = array( 'booking' => 'Báo PR', 'tenmien' => 'Tên miền', 'hosting' => 'Hosting', 'email' => 'Email', 'cloud' => 'Cloud server' );
			$unit = array( 'booking' => '/bài', 'hosting' => '/tháng', 'email' => '/tháng', 'cloud' => '/tháng' );
			if ( isset( $lbl[ $src ] ) ) {
				$m = dgc_hero_promo_min( $src );
				if ( $m ) $price .= ( $price ? '<br>' : '' ) . esc_html( $lbl[ $src ] ) . '&nbsp;từ&nbsp;<b>' . esc_html( dgc_vnd( $m ) ) . '</b>' . esc_html( $unit[ $src ] ?? '' );
			} else {
				$price .= ( $price ? '<br>' : '' ) . esc_html( $src );
			}
		}
		$out[] = array(
			'name' => $g[0], 'url' => ( $g[1] ?? '' ) && dgc_home_link_live( $g[1] ) ? $g[1] : '', 'desc' => $g[2] ?? '',
			'price' => $price, 'btn' => ( $g[4] ?? '' ) ?: 'Xem dịch vụ', 'subs' => $links[ $g[0] ] ?? array(),
		);
	}
	return $out;
}
