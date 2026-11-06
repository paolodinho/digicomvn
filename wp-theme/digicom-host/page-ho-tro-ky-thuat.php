<?php
/**
 * Template trang Ho tro ky thuat (slug "ho-tro-ky-thuat"). Xu ly gui o inc/support-ticket.php.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
$sent = sanitize_text_field( wp_unslash( $_GET['sent'] ?? '' ) );
$ma   = sanitize_text_field( wp_unslash( $_GET['ma'] ?? '' ) );
$dv   = sanitize_text_field( wp_unslash( $_GET['dv'] ?? '' ) );
$tm   = sanitize_text_field( wp_unslash( $_GET['tm'] ?? '' ) );
?>
<div class="wrap"><nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a><span class="sep">/</span> Hỗ trợ kỹ thuật</nav></div>

<section class="page-hero">
	<div class="wrap" style="max-width:860px">
		<span class="eyebrow">Hỗ trợ kỹ thuật</span>
		<h1>Hỗ trợ dịch vụ DigicomVN</h1>
		<p class="lead">Báo lỗi tên miền, hosting, email, website hoặc vấn đề với bài báo, backlink đã đặt. Phiếu được chuyển ngay tới đội phụ trách dịch vụ đó, bạn nhận mã phiếu qua email để theo dõi.</p>
	</div>
</section>

<section class="sec" id="ho-tro">
	<div class="wrap" style="max-width:860px">
		<div class="form-card">
			<?php if ( 'ok' === $sent ) : ?>
				<div class="alert alert-ok">Đã nhận yêu cầu<?php echo $ma ? ' (mã phiếu <b>' . esc_html( $ma ) . '</b>)' : ''; ?>. Đội kỹ thuật đang kiểm tra và sẽ phản hồi sớm nhất. Việc gấp, gọi hotline <a href="tel:<?php echo esc_attr( dgc_tel() ); ?>"><?php echo esc_html( dgc( 'hotline' ) ); ?></a>.</div>
			<?php elseif ( 'err' === $sent ) : ?>
				<div class="alert" style="background:#fdecea;border:1px solid #f5c6c0;color:#a3271b">Vui lòng nhập họ tên, số điện thoại, tên miền và mô tả lỗi (ít nhất 10 ký tự).</div>
			<?php endif; ?>
			<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" enctype="multipart/form-data">
				<input type="hidden" name="action" value="dgc_support">
				<input type="hidden" name="dgc_t" value="<?php echo esc_attr( time() ); ?>">
				<?php wp_nonce_field( 'dgc_support', 'dgc_nonce' ); ?>
				<div style="position:absolute;left:-9999px" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
				<div class="row2">
					<div><label class="fl" for="sp_name">Họ và tên <span class="req" aria-hidden="true">*</span></label>
						<input type="text" id="sp_name" name="sp_name" required autocomplete="name"></div>
					<div><label class="fl" for="sp_phone">Số điện thoại <span class="req" aria-hidden="true">*</span></label>
						<input type="tel" id="sp_phone" name="sp_phone" required inputmode="tel" autocomplete="tel"></div>
				</div>
				<div class="row2">
					<div><label class="fl" for="sp_service">Dịch vụ</label>
						<select id="sp_service" name="sp_service"><?php foreach ( dgc_sp_catalog() as $gl => $grp ) { echo '<optgroup label="' . esc_attr( $gl ) . '">'; foreach ( $grp as $o => $c ) printf( '<option%s>%s</option>', selected( $dv, $o, false ), esc_html( $o ) ); echo '</optgroup>'; } ?></select></div>
					<div><label class="fl" for="sp_kind">Loại vấn đề</label>
						<select id="sp_kind" name="sp_kind"></select></div>
				</div>
				<div class="row2">
					<div><label class="fl" for="sp_domain">Tên miền hoặc website liên quan <span class="req" aria-hidden="true">*</span></label>
						<input type="text" id="sp_domain" name="sp_domain" required placeholder="vidu.com" value="<?php echo esc_attr( $tm ); ?>" autocapitalize="off"></div>
					<div><label class="fl" for="sp_order">Mã đơn hàng (nếu có)</label>
						<input type="text" id="sp_order" name="sp_order" placeholder="Trong email xác nhận đơn" autocapitalize="characters"></div>
				</div>
				<label class="fl" for="sp_email">Email nhận phản hồi <span class="req" aria-hidden="true">*</span></label>
				<input type="email" id="sp_email" name="sp_email" autocomplete="email" required>
				<label class="fl" for="sp_issue">Mô tả lỗi <span class="req" aria-hidden="true">*</span></label>
				<textarea id="sp_issue" name="sp_issue" rows="5" required minlength="10" placeholder="Lỗi xảy ra từ khi nào, thông báo lỗi hiện ra là gì, bạn đã thử làm gì. Với bài báo, backlink: ghi link bài."></textarea>
				<label class="fl" for="sp_files">Ảnh chụp màn hình lỗi (nên có, tối đa 4 ảnh)</label>
				<input type="file" id="sp_files" name="sp_files[]" accept="image/*" multiple>
				<p class="form-hint" style="margin-top:6px">Chụp đúng màn hình đang báo lỗi, thấy được thông báo lỗi và địa chỉ trang. Mỗi ảnh tối đa 8MB.</p>
				<label class="fl" for="sp_shot">Hoặc link video, thư mục ảnh (nếu có)</label>
				<input type="url" id="sp_shot" name="sp_shot" placeholder="https://drive.google.com/...">
				<label style="display:flex;gap:8px;align-items:center;margin-top:14px;font-size:14px"><input type="checkbox" name="sp_urgent" value="1" style="width:auto"> Website hoặc email đang ngừng hoạt động</label>
				<p class="form-hint" style="margin-top:12px">* Bắt buộc. Không gửi mật khẩu qua phiếu, đội kỹ thuật chỉ cần tên miền.</p>
				<button type="submit" class="btn btn-primary">Gửi yêu cầu hỗ trợ</button>
			</form>
		</div>
	</div>
</section>
<script>(function(){var fi=document.getElementById('sp_files');if(fi)fi.addEventListener('change',function(){if(fi.files.length>4){alert('Chọn tối đa 4 ảnh.');fi.value='';}});})();(function(){var m=<?php $km=array(); foreach ( dgc_sp_flat() as $k => $c ) $km[ $k ] = array_merge( $c['v'], array( 'Khác' ) ); echo wp_json_encode( $km ); ?>,s=document.getElementById('sp_service'),k=document.getElementById('sp_kind');if(!s||!k)return;function f(){k.innerHTML='';(m[s.value]||['Khác']).forEach(function(v){var o=document.createElement('option');o.textContent=v;k.appendChild(o);});}s.addEventListener('change',f);f();})();</script>
<?php get_footer(); ?>
