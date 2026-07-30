<?php
/**
 * 3 lua chon xem bang gia (Hieu 2026-07-30): (1) tai PDF tong hop, (2) xem live tren
 * Google Sheet (chi doc, dong bo tu dong tu 10-bang-gia-booking/sync-google-sheet.py),
 * (3) khong lam gi ca -> cuon xuong xem ngay tren trang. Include ngay sau .page-hero
 * cua page-bang-gia.php.
 *
 * CONG CHAN LEAD (2026-07-30): (1) va (2) KHONG con href tinh - phai qua modal nhap
 * ho ten/SDT/email, gui AJAX (dgc_handle_gate_lead trong functions.php) luu lead + bao
 * email cho Digicom, roi moi tra link that de mo. (3) van mien phi, khong gate.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$pvo_sheet = trim( (string) dgc( 'sheet_view_url' ) );
?>
<section class="sec-tight">
	<div class="wrap">
		<div class="price-view-opts">
			<div class="pvo-label">Bạn muốn xem bảng giá theo cách nào?</div>
			<div class="pvo-choices">
				<button type="button" class="pvo-choice pvo-primary" data-gate-open="pdf">
					<span class="pvo-ic" aria-hidden="true">&#8681;</span>
					<span><strong>Tải PDF tổng hợp</strong><small>Toàn bộ bảng giá, xem offline</small></span>
				</button>
				<?php if ( $pvo_sheet ) : ?>
				<button type="button" class="pvo-choice pvo-teal" data-gate-open="sheet">
					<span class="pvo-ic" aria-hidden="true">&#128200;</span>
					<span><strong>Xem live trên Google Sheet</strong><small>Cập nhật tự động, chỉ xem không tải/copy được</small></span>
				</button>
				<?php endif; ?>
				<a class="pvo-choice pvo-plain" href="#bang-gia-chi-tiet">
					<span class="pvo-ic" aria-hidden="true">&#8595;</span>
					<span><strong>Xem ngay trên trang này</strong><small>Lọc, sắp xếp, tick chọn gửi yêu cầu</small></span>
				</a>
			</div>
		</div>
	</div>
</section>

<!-- Modal cong chan lead - dung chung cho ca 2 nut PDF/Sheet -->
<div class="pvo-modal" id="pvoModal" hidden>
	<div class="pvo-modal-box" role="dialog" aria-modal="true" aria-labelledby="pvoModalTitle">
		<button type="button" class="pvo-modal-close" aria-label="Đóng">&times;</button>
		<h3 id="pvoModalTitle">Nhận link ngay</h3>
		<p class="pvo-modal-sub">Để lại thông tin, DigicomVN gửi link cho bạn ngay lập tức.</p>
		<form id="pvoForm">
			<input type="hidden" name="target" id="pvoTarget" value="">
			<label class="fl" for="pvoName">Họ và tên <span class="req">*</span></label>
			<input type="text" id="pvoName" name="name" required>
			<label class="fl" for="pvoPhone">Số điện thoại <span class="req">*</span></label>
			<input type="tel" id="pvoPhone" name="phone" required>
			<label class="fl" for="pvoEmail">Email <span class="req">*</span></label>
			<input type="email" id="pvoEmail" name="email" required>
			<button type="submit" class="btn btn-primary" style="width:100%;margin-top:10px">Nhận link</button>
			<p class="pvo-modal-err" id="pvoErr" hidden></p>
		</form>
	</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
	'use strict';
	/* DGC_GATE duoc wp_localize_script in ra o wp_footer - script inline nay lai nam TRUOC do
	   trong luong HTML, nen phai doi DOMContentLoaded (chay sau khi toan bo trang, ke ca footer,
	   da parse xong) thay vi doc DGC_GATE ngay khi the <script> nay chay. */
	if (typeof DGC_GATE === 'undefined') return;
	var modal   = document.getElementById('pvoModal');
	var form    = document.getElementById('pvoForm');
	var errBox  = document.getElementById('pvoErr');
	var targetIn= document.getElementById('pvoTarget');
	var openBtns= document.querySelectorAll('[data-gate-open]');
	var closeBtn= modal.querySelector('.pvo-modal-close');

	function openModal(target){
		targetIn.value = target;
		errBox.hidden = true;
		modal.hidden = false;
	}
	function closeModal(){ modal.hidden = true; }

	openBtns.forEach(function(btn){
		btn.addEventListener('click', function(){ openModal(btn.getAttribute('data-gate-open')); });
	});
	closeBtn.addEventListener('click', closeModal);
	modal.addEventListener('click', function(e){ if (e.target === modal) closeModal(); });

	form.addEventListener('submit', function(e){
		e.preventDefault();
		errBox.hidden = true;
		var submitBtn = form.querySelector('button[type="submit"]');
		submitBtn.disabled = true;
		submitBtn.textContent = 'Đang gửi...';

		var fd = new FormData(form);
		fd.append('action', 'dgc_gate_lead');
		fd.append('nonce', DGC_GATE.nonce);

		fetch(DGC_GATE.url, { method: 'POST', body: fd, credentials: 'same-origin' })
			.then(function(r){ return r.json(); })
			.then(function(res){
				submitBtn.disabled = false;
				submitBtn.textContent = 'Nhận link';
				if (res.success && res.data.url) {
					window.open(res.data.url, '_blank', 'noopener');
					closeModal();
					form.reset();
				} else {
					errBox.textContent = (res.data && res.data.message) || 'Có lỗi xảy ra, vui lòng thử lại.';
					errBox.hidden = false;
				}
			})
			.catch(function(){
				submitBtn.disabled = false;
				submitBtn.textContent = 'Nhận link';
				errBox.textContent = 'Không kết nối được, vui lòng thử lại.';
				errBox.hidden = false;
			});
	});
});
</script>
