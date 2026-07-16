<?php
/**
 * Block "Dau bao co the dat bai" (press_partners marquee) - dung chung trang chu + trang dich vu.
 * Doc option 'press_partners'. Logo trong wp-content/uploads/press-logos/.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$press_list = array_filter( dgc_lines( 'press_partners' ), fn( $pp ) => ! empty( $pp[0] ) );
if ( ! $press_list ) return;

$press_chip = function ( $pp ) {
	$logo_file = trim( $pp[1] ?? '' );
	$logo_url  = $logo_file ? content_url( 'uploads/press-logos/' . $logo_file ) : '';
	?>
	<div class="press-chip">
		<?php if ( $logo_url ) : ?>
			<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $pp[0] ); ?>" loading="lazy">
		<?php endif; ?>
		<span><?php echo esc_html( $pp[0] ); ?></span>
	</div>
	<?php
};
?>
<section class="sec press-strip">
	<div class="wrap">
		<div class="center" style="margin-bottom:22px">
			<span class="eyebrow">Mạng lưới báo chí</span>
			<h2>Đầu báo DigicomVN hỗ trợ đặt bài, booking PR</h2>
			<p class="muted" style="max-width:600px;margin:8px auto 0">Danh sách rút gọn, xem đầy đủ tại <a href="<?php echo esc_url( home_url( '/bang-gia/' ) ); ?>" style="color:var(--action);font-weight:600">Bảng giá</a>.</p>
		</div>
		<div class="press-rows">
			<?php
			$dgc_press_rows = 5;
			$dgc_per        = max( 1, (int) ceil( count( $press_list ) / $dgc_press_rows ) );
			foreach ( array_chunk( $press_list, $dgc_per ) as $ri => $dgc_chunk ) :
				$rev = ( $ri % 2 === 1 ) ? ' press-track--rev' : '';
			?>
			<div class="press-marquee">
				<div class="press-track<?php echo $rev; ?>">
					<?php for ( $k = 0; $k < 4; $k++ ) : foreach ( $dgc_chunk as $pp ) : $press_chip( $pp ); endforeach; endfor; ?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
