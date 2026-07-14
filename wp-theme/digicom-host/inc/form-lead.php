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
		<div class="order-summary-disc" hidden>Ưu đãi combo <b class="order-summary-disc-pct"></b>: <b class="order-summary-disc-num"></b></div>
		<div class="order-summary-total">Tổng tạm tính: <b></b> <span>(chưa gồm VAT)</span></div>
	</div>
	<h3 style="margin-top:0"><?php echo esc_html( $dgc_form_title ); ?></h3>
	<?php if ( $sent === 'ok' ) : ?>
		<div class="alert alert-ok">Đã nhận yêu cầu của bạn. DigicomVN sẽ liên hệ lại sớm nhất.</div>
	<?php elseif ( $sent === 'err' ) : ?>
		<div class="alert" style="background:#fdecea;border:1px solid #f5c6c0;color:#a3271b">Vui lòng nhập họ tên và số điện thoại hoặc email.</div>
	<?php endif; ?>
	<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
		<input type="hidden" name="action" value="dgc_lead">
		<?php wp_nonce_field( 'dgc_lead', 'dgc_nonce' ); ?>
		<?php /* Dau * = bat buoc, khop dung logic kiem tra o server (functions.php):
		         ho ten bat buoc + PHAI co it nhat 1 trong 2 (dien thoai HOAC email). */ ?>
		<label class="fl" for="dgc_name">Họ và tên <span class="req" aria-hidden="true">*</span></label>
		<input type="text" id="dgc_name" name="dgc_name" required aria-required="true">
		<div class="row2">
			<div><label class="fl" for="dgc_phone">Số điện thoại <span class="req" aria-hidden="true">*</span></label>
				<input type="tel" id="dgc_phone" name="dgc_phone" data-contact-one></div>
			<div><label class="fl" for="dgc_email">Email <span class="req" aria-hidden="true">*</span></label>
				<input type="email" id="dgc_email" name="dgc_email" data-contact-one></div>
		</div>
		<p class="form-hint">* Bắt buộc. Điện thoại và email: nhập ít nhất một để DigicomVN liên hệ lại.</p>
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
/* Bao loi ngay tai cho neu bo trong ca dien thoai lan email (thay vi de server tra ve ?sent=err
   lam mat noi dung da nhap). */
(function(){
	var form = document.querySelector('#lien-he form');
	if (!form) return;
	var phone = form.querySelector('#dgc_phone');
	var email = form.querySelector('#dgc_email');
	if (!phone || !email) return;
	function sync() {
		var ok = phone.value.trim() !== '' || email.value.trim() !== '';
		phone.setCustomValidity(ok ? '' : 'Nhập số điện thoại hoặc email để chúng tôi liên hệ lại.');
		email.setCustomValidity('');
	}
	phone.addEventListener('input', sync);
	email.addEventListener('input', sync);
	form.addEventListener('submit', sync);
	sync();
})();
(function(){
	var params   = new URLSearchParams(location.search);
	var selected = params.get('selected');
	var total    = params.get('total');
	var subtotal = params.get('subtotal');
	var discount = parseFloat(params.get('discount') || 0) || 0;
	var discPct  = parseFloat(params.get('discount_pct') || 0) || 0;
	if (!selected) return;
	function vnd(n){ return Math.round(n).toLocaleString('vi-VN') + 'đ'; }

	var msg = document.getElementById('dgc_message');
	if (msg && !msg.value) {
		msg.value = 'Tôi quan tâm: ' + selected +
			(subtotal ? '. Tạm tính: ' + vnd(subtotal) : '') +
			(discount ? '. Ưu đãi combo ' + discPct + '%: -' + vnd(discount) : '') +
			(total ? '. Tổng sau ưu đãi: ' + vnd(total) + ' (chưa gồm VAT).' : '.');
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
		if (discount > 0) {
			var d = box.querySelector('.order-summary-disc');
			d.querySelector('.order-summary-disc-pct').textContent = discPct + '%';
			d.querySelector('.order-summary-disc-num').textContent = '-' + vnd(discount);
			d.hidden = false;
		}
		if (total) box.querySelector('.order-summary-total b').textContent = vnd(total);
		else box.querySelector('.order-summary-total').style.display = 'none';
		box.hidden = false;
	}
})();
</script>
