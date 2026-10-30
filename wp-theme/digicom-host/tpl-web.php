<?php
/**
 * Template Name: Dich vu website
 * Nhom dich vu website (2026-10-30): thiet ke web, cham soc web, dang ky Bo Cong Thuong, email doanh nghiep,
 * SSL, cloud server. Noi dung + bang gia theo slug trong inc/web-svc.php; gia sua o WP Admin > DigicomVN > muc 12.
 * Dat qua form lead. KHONG hien ten nha cung cap.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
$dgc_ws   = get_post_field( 'post_name', get_the_ID() );
$dgc_wc   = dgc_web_svc_conf( $dgc_ws );
$dgc_wl   = dgc_web_svc_list();
$dgc_wn   = $dgc_wl[ $dgc_ws ] ?? get_the_title();
$dgc_wr   = dgc_web_rows( $dgc_ws );
?>
<section class="sg-phero sg-phero--solo">
	<div class="wrap">
		<nav class="sg-crumb" aria-label="Breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a> / <a href="<?php echo esc_url( home_url( '/thiet-ke-website/' ) ); ?>">Website</a> / <span><?php echo esc_html( $dgc_wn ); ?></span></nav>
		<span class="sg-eyebrow"><?php echo esc_html( $dgc_wc['eyebrow'] ?? 'Website' ); ?></span>
		<h1><?php echo esc_html( get_the_title() ); ?></h1>
		<?php if ( ! empty( $dgc_wc['lead'] ) ) : ?><p class="sg-lead"><?php echo esc_html( $dgc_wc['lead'] ); ?></p><?php endif; ?>
		<div class="sg-hero-cta">
			<?php if ( $dgc_wr ) : ?><a class="sg-btn sg-btn--light" href="#bang-gia"><?php echo dgc_arrow(); ?>Xem bảng giá</a><?php endif; ?>
			<a class="sg-btn <?php echo $dgc_wr ? 'sg-btn--line' : 'sg-btn--light'; ?>" href="#lien-he" data-svc="<?php echo esc_attr( $dgc_wn ); ?>" data-order="Cần tư vấn: <?php echo esc_attr( $dgc_wn ); ?>"><?php echo dgc_arrow(); ?><?php echo $dgc_wr ? 'Nhờ tư vấn chọn gói' : 'Nhận báo giá'; ?></a>
		</div>
	</div>
</section>

<?php if ( ! empty( $dgc_wc['benefits'] ) ) : ?>
<section class="sec hg-trust-sec">
	<div class="wrap">
		<div class="hg-offer-head"><span class="eyebrow">Bạn nhận được gì</span><h2><?php echo esc_html( $dgc_wn ); ?> tại DigicomVN</h2></div>
		<ul class="hg-trust">
			<?php foreach ( $dgc_wc['benefits'] as $b ) : ?><li><b><?php echo esc_html( $b[0] ); ?></b><span><?php echo esc_html( $b[1] ); ?></span></li><?php endforeach; ?>
		</ul>
	</div>
</section>
<?php endif; ?>

<?php if ( $dgc_wr ) : ?>
<section class="sec" id="bang-gia">
	<div class="wrap">
		<div class="center" style="margin-bottom:24px"><span class="eyebrow">Bảng giá</span><h2><?php echo esc_html( $dgc_wc['price_h'] ?: 'Bảng giá' ); ?></h2>
			<p class="muted" style="max-width:720px;margin:8px auto 0">Giá chưa gồm VAT. Đăng ký kỳ hạn dài hoặc nhiều người dùng: gửi yêu cầu để nhận báo giá trọn kỳ.</p></div>
		<?php if ( count( $dgc_wr ) > 1 ) : ?>
		<nav class="hg-tabs" aria-label="Nhóm gói">
			<?php $i = 0; foreach ( array_keys( $dgc_wr ) as $g ) : ?><a href="#wg-<?php echo (int) $i++; ?>"><?php echo esc_html( $g ); ?></a><?php endforeach; ?>
		</nav>
		<?php endif; ?>
		<?php $gi = 0; foreach ( $dgc_wr as $g => $rows ) : ?>
		<div class="hg-group" id="wg-<?php echo (int) $gi++; ?>">
			<?php if ( count( $dgc_wr ) > 1 ) : ?><h3><?php echo esc_html( $g ); ?></h3><?php endif; ?>
			<div class="hg-grid">
			<?php foreach ( $rows as $r ) : $pct = ( $r['goc'] > $r['gia'] && $r['gia'] ) ? (int) round( 100 - $r['gia'] * 100 / $r['goc'] ) : 0; ?>
				<div class="hg-card">
					<div class="hg-name"><?php echo esc_html( $r['goi'] ); ?><?php if ( $pct >= 5 ) : ?><em class="hg-pct">Giảm <?php echo (int) $pct; ?>%</em><?php endif; ?></div>
					<?php if ( $r['gia'] ) : ?>
					<div class="hg-price"><b><?php echo esc_html( dgc_vnd( $r['gia'] ) ); ?></b><span><?php echo esc_html( $r['dv'] ); ?></span></div>
					<?php if ( $r['goc'] > $r['gia'] ) : ?><div class="hg-old"><s><?php echo esc_html( dgc_vnd( $r['goc'] ) ); ?></s></div><?php endif; ?>
					<?php else : ?>
					<div class="hg-price"><b style="font-size:20px">Báo giá theo hồ sơ</b></div>
					<?php endif; ?>
					<?php if ( $r['spec'] ) : ?><ul class="ws-spec"><?php foreach ( $r['spec'] as $s ) : ?><li><?php echo esc_html( $s ); ?></li><?php endforeach; ?></ul><?php endif; ?>
					<a class="btn btn-ghost btn-sm" href="#lien-he" data-svc="<?php echo esc_attr( $dgc_wn ); ?>" data-order="Đăng ký <?php echo esc_attr( $r['goi'] ); ?> (<?php echo esc_attr( $g ); ?>)">Chọn gói này</a>
				</div>
			<?php endforeach; ?>
			</div>
		</div>
		<?php endforeach; ?>
		<?php include get_template_directory() . '/inc/price-note.php'; ?>
	</div>
</section>
<?php endif; ?>

<?php if ( ! empty( $dgc_wc['body'] ) ) : ?>
<section class="sec" style="background:var(--surface-2);border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap" style="max-width:960px">
		<div class="center" style="margin-bottom:28px"><span class="eyebrow">Tư vấn</span><h2><?php echo esc_html( $dgc_wc['h2'] ); ?></h2></div>
		<div class="page-content"><?php echo wp_kses_post( $dgc_wc['body'] ); ?></div>
		<?php if ( ! empty( $dgc_wc['steps'] ) ) : ?>
		<ol class="tm-steps">
			<?php foreach ( $dgc_wc['steps'] as $s ) : ?><li><b><?php echo esc_html( $s[0] ); ?></b><span><?php echo esc_html( $s[1] ); ?></span></li><?php endforeach; ?>
		</ol>
		<?php endif; ?>
	</div>
</section>
<?php endif; ?>

<?php if ( trim( get_post_field( 'post_content', get_the_ID() ) ) ) : ?>
<section class="sec"><div class="wrap page-content" style="max-width:960px"><?php the_content(); ?></div></section>
<?php endif; ?>

<section class="sec">
	<div class="wrap">
		<div class="hg-offer-head"><span class="eyebrow">Dịch vụ website khác</span><h2>Trọn bộ cho một website vận hành tốt</h2></div>
		<ul class="ws-links">
			<?php foreach ( $dgc_wl as $s => $n ) : if ( $s === $dgc_ws ) continue; ?><li><a href="<?php echo esc_url( home_url( '/' . $s . '/' ) ); ?>"><?php echo esc_html( $n ); ?></a></li><?php endforeach; ?>
			<li><a href="<?php echo esc_url( home_url( '/ten-mien/' ) ); ?>">Tên miền</a></li>
			<li><a href="<?php echo esc_url( home_url( '/hosting/' ) ); ?>">Hosting</a></li>
		</ul>
	</div>
</section>

<?php include get_template_directory() . '/inc/svc-faq.php'; ?>

<section class="sec">
	<div class="wrap" style="max-width:720px">
		<?php
		$dgc_form_title   = ( $dgc_wr ? 'Đăng ký: ' : 'Nhận báo giá: ' ) . $dgc_wn;
		$dgc_form_btn     = 'Gửi yêu cầu';
		$dgc_form_service = $dgc_wn;
		include get_template_directory() . '/inc/form-lead.php';
		?>
	</div>
</section>
<?php include get_template_directory() . '/inc/order-prefill.php'; ?>
<?php get_footer(); ?>
