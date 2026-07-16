<?php
/**
 * Block "Tai sao chon DigicomVN" (reasons) - dung chung trang chu + trang dich vu.
 * Doc option 'reasons'. Nguon that su duy nhat cho section nay.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$why_items = dgc_lines( 'reasons' );
if ( ! $why_items ) return;
?>
<section class="sec why-sec" id="tai-sao" style="background:var(--surface);border-bottom:1px solid var(--line)">
	<div class="wrap">
		<div class="why-split">
			<div class="why-intro">
				<span class="eyebrow">Tại sao chọn DigicomVN</span>
				<h2>Off-page SEO làm đúng, nguồn thật, minh bạch</h2>
				<p class="muted">Textlink, backlink, guest post và booking báo PR triển khai trên nguồn chọn lọc có uy tín thật - báo giá rõ ràng, bàn giao kèm bằng chứng để bạn kiểm chứng.</p>
				<div class="why-intro-actions">
					<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/bang-gia/' ) ); ?>">Xem bảng giá</a>
					<a class="btn btn-ghost" href="tel:<?php echo esc_attr( dgc_tel() ); ?>">Gọi <?php echo esc_html( dgc( 'hotline' ) ); ?></a>
				</div>
			</div>
			<ol class="why-list">
				<?php $wi = 0; foreach ( $why_items as $r ) : $wi++; ?>
				<li class="why-item">
					<span class="why-num"><?php echo esc_html( str_pad( $wi, 2, '0', STR_PAD_LEFT ) ); ?></span>
					<div>
						<h3><?php echo esc_html( $r[0] ?? '' ); ?></h3>
						<p><?php echo esc_html( $r[1] ?? '' ); ?></p>
					</div>
				</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</div>
</section>
