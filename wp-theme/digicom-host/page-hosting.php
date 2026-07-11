<?php
/**
 * Template trang Hosting (page slug "hosting").
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<div class="wrap"><nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a><span class="sep">/</span> Hosting</nav></div>

<section class="page-hero">
	<div class="wrap" style="max-width:820px">
		<span class="eyebrow">Web Hosting</span>
		<h1><?php echo esc_html( get_the_title() ?: 'Hosting tốc độ cao cho website' ); ?></h1>
		<p class="lead">Ổ cứng SSD, LiteSpeed, SSL miễn phí và sao lưu định kỳ. Phù hợp từ website cá nhân đến doanh nghiệp.</p>
	</div>
</section>

<section class="sec">
	<div class="wrap">
		<div class="center" style="margin-bottom:36px"><span class="eyebrow">Bảng giá</span><h2>Chọn gói hosting phù hợp</h2></div>
		<div class="host-grid">
			<?php foreach ( dgc_lines( 'hosting_plans' ) as $h ) :
				$name = $h[0] ?? ''; $price = $h[1] ?? ''; $feats = $h[2] ?? ''; $feat = ( ( $h[3] ?? '0' ) === '1' );
				if ( $name === '' ) continue; ?>
				<div class="host-card<?php echo $feat ? ' feat' : ''; ?>">
					<?php if ( $feat ) : ?><span class="tag-feat">Phổ biến nhất</span><?php endif; ?>
					<div class="pname"><?php echo esc_html( $name ); ?></div>
					<div class="pprice"><?php echo esc_html( $price ); ?></div>
					<ul><?php foreach ( array_filter( array_map( 'trim', explode( ';', $feats ) ) ) as $f ) : ?><li><?php echo esc_html( $f ); ?></li><?php endforeach; ?></ul>
					<a class="btn <?php echo $feat ? 'btn-primary' : 'btn-navy'; ?>" href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">Chọn gói</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="sec" style="background:#fff;border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<div class="center" style="margin-bottom:30px"><span class="eyebrow">So sánh</span><h2>Thông số các gói</h2></div>
		<table class="price-table">
			<thead><tr><th>Thông số</th>
				<?php foreach ( dgc_lines( 'hosting_plans' ) as $h ) { if ( ! empty( $h[0] ) ) echo '<th>' . esc_html( $h[0] ) . '</th>'; } ?>
			</tr></thead>
			<tbody>
			<?php
			// Lay tap dac diem theo vi tri (gia su cac goi cung so dong dac diem).
			$plans = array_filter( dgc_lines( 'hosting_plans' ), function ( $h ) { return ! empty( $h[0] ); } );
			$rows  = 0;
			foreach ( $plans as $h ) { $rows = max( $rows, count( array_filter( array_map( 'trim', explode( ';', $h[2] ?? '' ) ) ) ) ); }
			for ( $i = 0; $i < $rows; $i++ ) {
				echo '<tr><td class="tld" style="font-weight:600">Đặc điểm ' . ( $i + 1 ) . '</td>';
				foreach ( $plans as $h ) {
					$fs = array_values( array_filter( array_map( 'trim', explode( ';', $h[2] ?? '' ) ) ) );
					echo '<td>' . esc_html( $fs[ $i ] ?? '-' ) . '</td>';
				}
				echo '</tr>';
			}
			?>
			</tbody>
		</table>
		<p class="form-note" style="text-align:center;margin-top:12px">Sửa thông số từng gói trong WP Admin &rarr; DigicomVN &rarr; Gói hosting.</p>
	</div>
</section>

<?php if ( get_the_content() ) : ?>
<section class="sec"><div class="wrap page-content"><?php the_content(); ?></div></section>
<?php endif; ?>

<section class="sec" style="background:var(--surface)">
	<div class="wrap">
		<div class="center" style="margin-bottom:30px"><span class="eyebrow">Hỗ trợ</span><h2>Câu hỏi thường gặp</h2></div>
		<div class="faq"><?php foreach ( dgc_lines( 'faqs' ) as $f ) : ?><details><summary><?php echo esc_html( $f[0] ?? '' ); ?></summary><div class="a"><?php echo esc_html( $f[1] ?? '' ); ?></div></details><?php endforeach; ?></div>
	</div>
</section>

<section class="sec-tight"><div class="wrap"><div class="cta-band">
	<div><h2>Chưa biết chọn gói nào?</h2><p>Để DigicomVN tư vấn miễn phí gói hosting phù hợp nhu cầu của bạn.</p></div>
	<div class="cta-actions"><a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a><a class="btn btn-navy" href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">Liên hệ</a></div>
</div></div></section>

<?php get_footer(); ?>
