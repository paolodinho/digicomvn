<?php
/**
 * Form lien he / nhan bao gia dung chung.
 * Bien $dgc_form_service (string) + $dgc_form_title + $dgc_form_btn co the set truoc khi include.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$dgc_form_title = $dgc_form_title ?? 'Gửi yêu cầu tư vấn';
$dgc_form_btn   = $dgc_form_btn ?? 'Gửi yêu cầu';
$dgc_form_service = $dgc_form_service ?? '';
$sent = isset( $_GET['sent'] ) ? sanitize_text_field( wp_unslash( $_GET['sent'] ) ) : '';
?>
<div class="form-card" id="lien-he">
	<div class="order-summary" id="dgc-order-summary" hidden>
		<div class="order-summary-title">Bạn đang yêu cầu báo giá cho</div>
		<ul class="order-summary-list"></ul>
		<div class="order-summary-total">Tổng tạm tính: <b></b> <span>(chưa gồm VAT)</span></div>
	</div>
	<h3 style="margin-top:0"><?php echo esc_html( $dgc_form_title ); ?></h3>
	<?php if ( $sent === 'ok' ) : ?>
		<div class="alert alert-ok">Đã nhận yêu cầu của bạn. Digicom sẽ liên hệ lại sớm nhất.</div>
	<?php elseif ( $sent === 'err' ) : ?>
		<div class="alert" style="background:#fdecea;border:1px solid #f5c6c0;color:#a3271b">Vui lòng nhập họ tên và số điện thoại hoặc email.</div>
	<?php endif; ?>
	<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
		<input type="hidden" name="action" value="dgc_lead">
		<?php wp_nonce_field( 'dgc_lead', 'dgc_nonce' ); ?>
		<label class="fl" for="dgc_name">Họ và tên</label>
		<input type="text" id="dgc_name" name="dgc_name" required>
		<div class="row2">
			<div><label class="fl" for="dgc_phone">Số điện thoại</label>
				<input type="tel" id="dgc_phone" name="dgc_phone"></div>
			<div><label class="fl" for="dgc_email">Email</label>
				<input type="email" id="dgc_email" name="dgc_email"></div>
		</div>
		<label class="fl" for="dgc_service">Dịch vụ quan tâm</label>
		<select id="dgc_service" name="dgc_service">
			<?php
			$opts = array( 'Mua Textlink', 'Dịch vụ Backlink', 'Guest Post', 'Booking báo & PR', 'Khác / chưa rõ' );
			foreach ( $opts as $o ) {
				printf( '<option%s>%s</option>', selected( $dgc_form_service, $o, false ), esc_html( $o ) );
			}
			?>
		</select>
		<label class="fl" for="dgc_message">Nội dung</label>
		<textarea id="dgc_message" name="dgc_message" rows="4"></textarea>
		<button type="submit" class="btn btn-primary"><?php echo esc_html( $dgc_form_btn ); ?></button>
		<p class="form-note">Hoặc gọi ngay <a href="tel:<?php echo esc_attr( dgc_tel() ); ?>" style="color:var(--action);font-weight:600"><?php echo esc_html( dgc( 'hotline' ) ); ?></a></p>
	</form>
</div>
<script>
(function(){
	var params = new URLSearchParams(location.search);
	var selected = params.get('selected');
	var total    = params.get('total');
	if (!selected) return;
	var msg = document.getElementById('dgc_message');
	if (msg && !msg.value) {
		msg.value = 'Tôi quan tâm: ' + selected +
			(total ? '. Tổng tạm tính: ' + Math.round(total).toLocaleString('vi-VN') + 'đ (chưa gồm VAT).' : '.');
	}
	var box = document.getElementById('dgc-order-summary');
	if (box) {
		var list = box.querySelector('.order-summary-list');
		selected.split(',').forEach(function(name){
			name = name.trim();
			if (!name) return;
			var li = document.createElement('li');
			li.textContent = name;
			list.appendChild(li);
		});
		if (total) box.querySelector('.order-summary-total b').textContent = Math.round(total).toLocaleString('vi-VN') + 'đ';
		else box.querySelector('.order-summary-total').style.display = 'none';
		box.hidden = false;
	}
})();
</script>
