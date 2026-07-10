<?php
/**
 * Template trang hub Dich vu (page slug "dich-vu") - liet ke 4 dich vu chinh,
 * dan link ra tung trang pillar. Xem sitemap trong .claude/rules/pivot-2026-07.md.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

$dgc_dich_vu_list = array(
	array(
		'icon'  => 'tag',
		'title' => 'Mua Textlink',
		'desc'  => 'Chèn link vào bài viết có sẵn, chọn site theo DR/traffic phù hợp ngành hàng.',
		'url'   => home_url( '/dich-vu/mua-textlink/' ),
	),
	array(
		'icon'  => 'layers',
		'title' => 'Dịch vụ Backlink',
		'desc'  => 'Hệ thống backlink chất lượng, đa nguồn - có gói riêng cho ngách bất động sản.',
		'url'   => home_url( '/dich-vu/dich-vu-backlink/' ),
	),
	array(
		'icon'  => 'edit',
		'title' => 'Guest Post',
		'desc'  => 'Viết bài đúng chủ đề và đăng trên site liên quan, link dofollow tự nhiên.',
		'url'   => home_url( '/dich-vu/guest-post/' ),
	),
	array(
		'icon'  => 'mail',
		'title' => 'Booking báo & PR',
		'desc'  => 'Đặt lịch đăng bài PR trên các đầu báo điện tử, báo giá theo từng đầu báo.',
		'url'   => home_url( '/dich-vu/booking-bao-pr/' ),
	),
);
?>
<div class="wrap"><nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a><span class="sep">/</span> Dịch vụ</nav></div>

<section class="page-hero">
	<div class="wrap" style="max-width:820px">
		<span class="eyebrow">Dịch vụ</span>
		<h1><?php echo esc_html( get_the_title() ?: 'Dịch vụ off-page SEO của Digicom' ); ?></h1>
		<p class="lead">Digicom tập trung 4 dịch vụ off-page SEO cốt lõi - chọn dịch vụ bên dưới để xem chi tiết, bảng giá và cách đặt.</p>
	</div>
</section>

<section class="sec">
	<div class="wrap">
		<div class="serv-grid">
			<?php foreach ( $dgc_dich_vu_list as $sv ) : ?>
			<a class="serv" href="<?php echo esc_url( $sv['url'] ); ?>">
				<span class="ico"><?php echo dgc_icon( $sv['icon'] ); ?></span>
				<h3><?php echo esc_html( $sv['title'] ); ?></h3>
				<p><?php echo esc_html( $sv['desc'] ); ?></p>
			</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="sec" style="background:var(--surface);border-top:1px solid var(--line)">
	<div class="wrap center">
		<h2>Chưa rõ nên chọn dịch vụ nào?</h2>
		<p class="muted" style="max-width:520px;margin:0 auto 20px">Xem bảng giá chi tiết theo từng báo/site, hoặc gửi yêu cầu để Digicom tư vấn trực tiếp.</p>
		<div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
			<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/bang-gia/' ) ); ?>">Xem bảng giá</a>
			<a class="btn btn-ghost" href="<?php echo esc_url( home_url( '/dat-bai/' ) ); ?>">Gửi yêu cầu tư vấn</a>
		</div>
	</div>
</section>

<?php if ( get_the_content() ) : ?>
<section class="sec"><div class="wrap page-content"><?php the_content(); ?></div></section>
<?php endif; ?>

<?php get_footer(); ?>
