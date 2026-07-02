<?php
/**
 * Template trang Bang gia tong hop (slug "bang-gia").
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<div class="wrap"><nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a><span class="sep">/</span> Bảng giá</nav></div>

<section class="page-hero">
	<div class="wrap" style="max-width:820px">
		<span class="eyebrow">Bảng giá</span>
		<h1>Bảng giá dịch vụ Digicom</h1>
		<p class="lead">Textlink, Backlink, Guest Post và Booking báo &amp; PR - giá cụ thể theo yêu cầu, site/báo và khối lượng. Liên hệ để nhận báo giá chi tiết.</p>
	</div>
</section>

<!-- Bang gia rut gon 4 dich vu -->
<section class="sec">
	<div class="wrap">
		<div class="center" style="margin-bottom:26px"><span class="eyebrow">Tổng quan</span><h2>4 dịch vụ off-page SEO</h2></div>
		<table class="price-table">
			<thead><tr><th>Dịch vụ</th><th>Giá</th><th></th></tr></thead>
			<tbody><?php foreach ( dgc_lines( 'domain_tlds' ) as $d ) { if ( empty( $d[0] ) ) continue;
				echo '<tr><td class="tld">' . esc_html( $d[0] ) . '</td><td class="p">' . esc_html( $d[1] ?? '' ) . '</td><td><a class="btn btn-ghost btn-sm" href="' . esc_url( home_url( '/lien-he/' ) ) . '#lien-he">Nhận báo giá</a></td></tr>';
			} ?></tbody>
		</table>
	</div>
</section>

<!-- Chi tiet goi -->
<section class="sec" style="background:#fff;border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:26px"><span class="eyebrow">Chi tiết</span><h2>Nội dung từng gói dịch vụ</h2></div>
		<table class="price-table">
			<thead><tr><th>Gói</th><th>Giá</th><th>Bao gồm</th><th></th></tr></thead>
			<tbody><?php foreach ( dgc_lines( 'hosting_plans' ) as $h ) { if ( empty( $h[0] ) ) continue;
				$feats = implode( ', ', array_slice( array_filter( array_map( 'trim', explode( ';', $h[2] ?? '' ) ) ), 0, 3 ) );
				echo '<tr><td class="tld">' . esc_html( $h[0] ) . '</td><td class="p">' . esc_html( $h[1] ?? '' ) . '</td><td>' . esc_html( $feats ) . '</td><td><a class="btn btn-ghost btn-sm" href="' . esc_url( home_url( '/lien-he/' ) ) . '#lien-he">Nhận tư vấn</a></td></tr>';
			} ?></tbody>
		</table>
	</div>
</section>

<!-- Link ra 4 pillar -->
<section class="sec">
	<div class="wrap">
		<div class="row" style="gap:24px">
			<div class="col card">
				<h3 style="margin-top:0">Mua Textlink &amp; Dịch vụ Backlink</h3>
				<p class="muted" style="font-size:14.5px">Chèn link vào bài có sẵn hoặc xây hệ thống backlink chất lượng, theo dõi index, có báo cáo.</p>
				<a class="btn btn-navy btn-sm" href="<?php echo esc_url( home_url( '/dich-vu/mua-textlink/' ) ); ?>">Xem Textlink</a>
				<a class="btn btn-ghost btn-sm" href="<?php echo esc_url( home_url( '/dich-vu/dich-vu-backlink/' ) ); ?>">Xem Backlink</a>
			</div>
			<div class="col card">
				<h3 style="margin-top:0">Guest Post &amp; Booking báo PR</h3>
				<p class="muted" style="font-size:14.5px">Viết bài đăng trên site đúng chủ đề, hoặc booking đăng bài PR trên báo điện tử theo yêu cầu.</p>
				<a class="btn btn-navy btn-sm" href="<?php echo esc_url( home_url( '/dich-vu/guest-post/' ) ); ?>">Xem Guest Post</a>
				<a class="btn btn-ghost btn-sm" href="<?php echo esc_url( home_url( '/dich-vu/booking-bao-pr/' ) ); ?>">Xem Booking PR</a>
			</div>
		</div>
	</div>
</section>

<?php if ( get_the_content() ) : ?>
<section class="sec" style="background:var(--surface)"><div class="wrap page-content"><?php the_content(); ?></div></section>
<?php endif; ?>

<section class="sec-tight"><div class="wrap"><div class="cta-band">
	<div><h2>Cần báo giá chi tiết?</h2><p>Liên hệ Digicom để được tư vấn gói phù hợp và ưu đãi tốt nhất.</p></div>
	<div class="cta-actions"><a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a><a class="btn btn-navy" href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">Liên hệ</a></div>
</div></div></section>

<?php get_footer(); ?>
