<?php
/**
 * Trang thanh toan ten mien (slug thanh-toan-ten-mien, tu tao trong inc/domain-order.php). 2026-10-29.
 * Khong co ?don: gio hang (localStorage dgc_tm_cart) + form chu the -> AJAX dgc_tm_order.
 * Co ?don=&k=: hien VietQR + thong tin chuyen khoan, hoi trang thai moi 5 giay cho toi khi da thanh toan.
 * noindex (wp_head trong inc/domain-order.php).
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
$dgc_oid  = dgc_tm_order_from_request();
$dgc_bank = dgc_tm_bank();
?>
<section class="sg-phero sg-phero--solo tmc-hero">
	<div class="wrap">
		<nav class="sg-crumb" aria-label="Breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a> / <a href="<?php echo esc_url( home_url( '/ten-mien/' ) ); ?>">Tên miền</a> / <span>Thanh toán</span></nav>
		<h1><?php echo $dgc_oid ? 'Thanh toán đơn tên miền' : 'Giỏ tên miền'; ?></h1>
	</div>
</section>

<section class="sec tmc">
	<div class="wrap" style="max-width:1040px">
<?php if ( $dgc_oid ) :
	$code   = get_post_meta( $dgc_oid, '_tm_code', true );
	$total  = (int) get_post_meta( $dgc_oid, '_tm_total', true );
	$status = get_post_meta( $dgc_oid, '_tm_status', true );
	$lines  = (array) get_post_meta( $dgc_oid, '_tm_lines', true );
	$vat    = (int) get_post_meta( $dgc_oid, '_tm_vat', true );
	$qr     = add_query_arg( array( 'amount' => $total, 'addInfo' => $code, 'accountName' => $dgc_bank['own'] ), 'https://img.vietqr.io/image/' . rawurlencode( $dgc_bank['bank'] ) . '-' . rawurlencode( $dgc_bank['acc'] ) . '-compact2.png' );
	$paid   = in_array( $status, array( 'da_tt', 'da_dk' ), true );
	?>
		<div class="tmc-pay" data-tmc-pay data-don="<?php echo esc_attr( $code ); ?>" data-k="<?php echo esc_attr( sanitize_text_field( wp_unslash( $_GET['k'] ?? '' ) ) ); ?>">
			<div class="tmc-qr">
				<div class="tmc-paid"<?php echo $paid ? '' : ' hidden'; ?>>
					<b>Đã nhận thanh toán</b>
					<p>DigicomVN đang đăng ký tên miền và sẽ gửi email xác nhận cho bạn. Có thể đóng trang này.</p>
				</div>
				<div class="tmc-wait"<?php echo $paid ? ' hidden' : ''; ?>>
					<img src="<?php echo esc_url( $qr ); ?>" width="320" height="380" alt="Mã QR chuyển khoản <?php echo esc_attr( dgc_vnd( $total ) ); ?> cho đơn <?php echo esc_attr( $code ); ?>">
					<p class="tmc-hint">Mở ứng dụng ngân hàng, quét mã. Số tiền và nội dung đã điền sẵn.</p>
					<p class="tmc-live" aria-live="polite"><span class="tmc-dot"></span><span data-tmc-msg><?php echo 'thieu_tien' === $status ? 'Đã nhận một phần, vui lòng chuyển nốt số còn thiếu hoặc gọi hotline.' : 'Đang chờ thanh toán, trang tự cập nhật khi tiền về.'; ?></span></p>
				</div>
			</div>
			<div class="tmc-info">
				<h2>Đơn <?php echo esc_html( $code ); ?></h2>
				<table class="tmc-sum">
					<tbody>
					<?php foreach ( $lines as $l ) : ?>
						<tr><td><?php echo esc_html( $l['d'] ); ?> <small><?php echo (int) $l['y']; ?> năm</small><?php if ( ! empty( $l['gifts'] ) ) : ?><ul class="tmc-gifts"><?php foreach ( $l['gifts'] as $g ) echo '<li>' . esc_html( $g ) . '</li>'; ?></ul><?php endif; ?></td><td><?php echo esc_html( dgc_vnd( $l['amount'] ) ); ?></td></tr>
					<?php endforeach; ?>
					<?php if ( $vat ) : ?><tr><td>VAT</td><td><?php echo esc_html( dgc_vnd( $vat ) ); ?></td></tr><?php endif; ?>
					</tbody>
					<tfoot><tr><td>Tổng thanh toán</td><td><?php echo esc_html( dgc_vnd( $total ) ); ?></td></tr></tfoot>
				</table>
				<dl class="tmc-bank">
					<dt>Ngân hàng</dt><dd><?php echo esc_html( $dgc_bank['name'] ); ?></dd>
					<dt>Số tài khoản</dt><dd><b><?php echo esc_html( $dgc_bank['acc'] ); ?></b> <button type="button" class="tmc-copy" data-copy="<?php echo esc_attr( $dgc_bank['acc'] ); ?>">Sao chép</button></dd>
					<dt>Chủ tài khoản</dt><dd><?php echo esc_html( $dgc_bank['own'] ); ?></dd>
					<dt>Số tiền</dt><dd><b><?php echo esc_html( dgc_vnd( $total ) ); ?></b> <button type="button" class="tmc-copy" data-copy="<?php echo esc_attr( $total ); ?>">Sao chép</button></dd>
					<dt>Nội dung</dt><dd><b><?php echo esc_html( $code ); ?></b> <button type="button" class="tmc-copy" data-copy="<?php echo esc_attr( $code ); ?>">Sao chép</button></dd>
				</dl>
				<p class="tmc-note">Chuyển khoản thủ công thì ghi đúng nội dung <b><?php echo esc_html( $code ); ?></b> để hệ thống tự nhận. Cần hoá đơn VAT hoặc hỗ trợ, gọi <a href="tel:<?php echo esc_attr( preg_replace( '/\D/', '', dgc( 'hotline', '0988769317' ) ) ); ?>"><?php echo esc_html( dgc( 'hotline', '0988 769 317' ) ); ?></a>.</p>
			</div>
		</div>
<?php else :
	$dgc_prices = array();
	$dgc_gifts  = dgc_tm_gifts_map();
	foreach ( dgc_tm_price_map() as $t => $p ) {
		$f = dgc_tm_num( $p['gia'] );
		/* [nam dau, gia han, gia goc, so nam toi thieu, qua tang] */
		if ( $f ) $dgc_prices[ $t ] = array( $f, dgc_tm_num( $p['han'] ) ?: $f, max( $f, dgc_tm_num( $p['goc'] ) ), dgc_tm_min_years( $p ), $dgc_gifts[ $t ] ?? array() );
	}
	$dgc_combo = dgc_tm_combo();
	?>
		<div class="tmc-grid" data-tmc-cart data-prices="<?php echo esc_attr( wp_json_encode( $dgc_prices ) ); ?>" data-combo="<?php echo esc_attr( wp_json_encode( $dgc_combo ?: null ) ); ?>" data-vat="<?php echo esc_attr( dgc_tm_vat_pct() ); ?>">
			<div class="tmc-cart">
				<h2>Tên miền đã chọn</h2>
				<ul class="tmc-items" data-tmc-items></ul>
				<p class="tmc-empty" data-tmc-empty hidden>Giỏ đang trống. <a href="<?php echo esc_url( home_url( '/ten-mien/' ) ); ?>">Kiểm tra tên miền</a> để thêm vào giỏ.</p>
				<table class="tmc-sum" data-tmc-sum>
					<tfoot>
						<tr data-tmc-saverow hidden class="tmc-save"><td>Bạn tiết kiệm</td><td data-tmc-save></td></tr>
						<tr data-tmc-vatrow hidden><td>VAT</td><td data-tmc-vat></td></tr>
						<tr><td>Tổng thanh toán</td><td data-tmc-total></td></tr>
					</tfoot>
				</table>
				<p class="tmc-note">Đăng ký nhiều năm để giữ giá ưu đãi năm đầu và tiết kiệm hơn. Năm thứ hai trở đi tính theo giá gia hạn. Tên miền được kiểm tra lại lúc tạo đơn.</p>
			</div>
			<form class="tmc-form" data-tmc-form novalidate>
				<h2>Thông tin chủ thể tên miền</h2>
				<p class="tmc-note">Theo quy định của VNNIC, thông tin chủ thể phải chính xác và trùng giấy tờ. Tên miền sẽ đứng tên chủ thể này.</p>
				<div class="tmc-type" role="radiogroup" aria-label="Loại chủ thể">
					<label><input type="radio" name="type" value="person" checked> Cá nhân</label>
					<label><input type="radio" name="type" value="org"> Doanh nghiệp, tổ chức</label>
				</div>
				<label class="tmc-f"><span data-l-person>Họ và tên</span><span data-l-org hidden>Tên doanh nghiệp, tổ chức</span><input name="name" required autocomplete="name"></label>
				<div class="tmc-2">
					<label class="tmc-f"><span data-l-person>Số CCCD</span><span data-l-org hidden>Mã số thuế</span><input name="idno" required inputmode="numeric"></label>
					<label class="tmc-f" data-only="person"><span>Ngày sinh</span><input name="dob" type="date" required></label>
					<label class="tmc-f" data-only="org" hidden><span>Người đại diện</span><input name="rep"></label>
				</div>
				<div class="tmc-2" data-only="org" hidden>
					<label class="tmc-f"><span>Số CCCD người đại diện</span><input name="rep_idno" inputmode="numeric"></label>
					<label class="tmc-f"><span>Ngày sinh người đại diện</span><input name="rep_dob" type="date"></label>
				</div>
				<div class="tmc-2">
					<label class="tmc-f"><span data-l-person>Giới tính</span><span data-l-org hidden>Giới tính người đại diện</span><select name="gender" required><option value="Nam">Nam</option><option value="Nữ">Nữ</option></select></label>
					<label class="tmc-f"><span>Điện thoại</span><input name="phone" type="tel" required autocomplete="tel"></label>
				</div>
				<label class="tmc-f"><span>Số nhà, tên đường</span><input name="addr" required autocomplete="street-address" placeholder="Ví dụ: 200 Đường 3.1"></label>
				<div class="tmc-2" data-dvhc="<?php echo esc_url( get_template_directory_uri() . '/assets/data/dvhc.json?ver=' . DGC_VER ); ?>">
					<label class="tmc-f"><span>Tỉnh, thành phố</span><select name="city" required><option value="">Chọn tỉnh, thành phố</option></select></label>
					<label class="tmc-f"><span>Phường, xã</span><select name="ward" required disabled><option value="">Chọn phường, xã</option></select></label>
				</div>
				<label class="tmc-f"><span>Email nhận thông tin quản trị</span><input name="email" type="email" required autocomplete="email"></label>
				<label class="tmc-f"><span>Ghi chú (không bắt buộc)</span><input name="note"></label>
				<input type="text" name="website" class="sr-only" tabindex="-1" autocomplete="off" aria-hidden="true">
				<label class="tmc-agree"><input type="checkbox" name="agree" value="1" required> Tôi xác nhận thông tin chủ thể là chính xác và đồng ý để DigicomVN đăng ký tên miền theo thông tin này.</label>
				<p class="tmc-err" data-tmc-err role="alert" hidden></p>
				<button type="submit" class="sg-btn tmc-submit">Tạo đơn và thanh toán</button>
			</form>
		</div>
<?php endif; ?>
	</div>
</section>
<script>
(function(){
	var ajax='<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>';
	function vnd(n){ return Math.round(n).toString().replace(/\B(?=(\d{3})+(?!\d))/g,'.')+'đ'; }
	function esc(t){ return String(t).replace(/[&<>"]/g,function(c){return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c];}); }
	document.addEventListener('click',function(e){
		var b=e.target.closest('.tmc-copy'); if(!b) return;
		var v=b.getAttribute('data-copy'); if(navigator.clipboard){ navigator.clipboard.writeText(v); }
		var t=b.textContent; b.textContent='Đã chép'; setTimeout(function(){ b.textContent=t; },1500);
	});
	var pay=document.querySelector('[data-tmc-pay]');
	if(pay){
		var wait=pay.querySelector('.tmc-wait'), done=pay.querySelector('.tmc-paid');
		if(!wait.hidden){
			try{ localStorage.removeItem('dgc_tm_cart'); }catch(x){}
			var poll=setInterval(function(){
				var fd=new FormData(); fd.append('action','dgc_tm_status'); fd.append('don',pay.dataset.don); fd.append('k',pay.dataset.k);
				fetch(ajax,{method:'POST',body:fd,credentials:'same-origin'}).then(function(r){return r.json();}).then(function(j){
					if(j.s==='da_tt'||j.s==='da_dk'){ wait.hidden=true; done.hidden=false; clearInterval(poll); }
					else if(j.s==='thieu_tien'){ pay.querySelector('[data-tmc-msg]').textContent='Đã nhận một phần, vui lòng chuyển nốt số còn thiếu hoặc gọi hotline.'; }
				}).catch(function(){});
			},5000);
			setTimeout(function(){ clearInterval(poll); },30*60*1000);
		}
		return;
	}
	var box=document.querySelector('[data-tmc-cart]'); if(!box) return;
	var prices=JSON.parse(box.dataset.prices||'{}'), cmb=JSON.parse(box.dataset.combo||'null'), vatPct=parseFloat(box.dataset.vat)||0;
	var list=box.querySelector('[data-tmc-items]'), form=box.querySelector('[data-tmc-form]'), err=box.querySelector('[data-tmc-err]');
	function load(){ try{ return JSON.parse(localStorage.getItem('dgc_tm_cart')||'[]'); }catch(x){ return []; } }
	function save(c){ try{ localStorage.setItem('dgc_tm_cart',JSON.stringify(c)); }catch(x){} }
	function tldOf(d){ var best=''; for(var t in prices){ if(d.slice(-t.length)===t && t.length>best.length) best=t; } return best; }
	/* Gia combo nam dau: chi khi du ca bo cung ten, giong dgc_tm_combo_lines() phia server. */
	function comboMap(c){
		var m={}; if(!cmb) return m; var by={}, n=cmb.tlds.length, each=Math.floor(cmb.price/n);
		c.forEach(function(x){ if(!x.c) return; cmb.tlds.forEach(function(t){ if(x.d.slice(-t.length)===t){ var k=x.d.slice(0,-t.length); (by[k]=by[k]||{})[t]=x.d; } }); });
		for(var k in by){ if(Object.keys(by[k]).length<n) continue; cmb.tlds.forEach(function(t,i){ m[by[k][t]]= i===n-1 ? cmb.price-each*(n-1) : each; }); }
		return m;
	}
	function quote(x,cm){
		var p=prices[tldOf(x.d)]; if(!p) return {a:0,l:0,g:[]};
		var first=x.y<p[3]?p[2]:p[0]; if(cm[x.d]) first=cm[x.d];
		return {a:first+(x.y-1)*p[1], l:(cm[x.d]?p[0]:p[2])+(x.y-1)*p[1], g:p[4]||[], min:p[3]};
	}
	function render(){
		var c=load().filter(function(x){ return tldOf(x.d); }); save(c);
		box.querySelector('[data-tmc-empty]').hidden=!!c.length; form.hidden=!c.length; box.querySelector('[data-tmc-sum]').hidden=!c.length;
		var sub=0, saved=0, cm=comboMap(c);
		list.innerHTML=c.map(function(x,i){
			var q=quote(x,cm); sub+=q.a; saved+=Math.max(0,q.l-q.a); var opt='';
			for(var y=1;y<=5;y++){ opt+='<option value="'+y+'"'+(y==x.y?' selected':'')+'>'+y+' năm</option>'; }
			var tip=cm[x.d] ? '<em class="tmc-tip">Giá combo năm đầu</em>' : (q.min>1 && x.y<q.min ? '<em class="tmc-tip is-warn">Chọn từ '+q.min+' năm để được giá ưu đãi năm đầu</em>' : (q.l>q.a ? '<em class="tmc-tip">Tiết kiệm '+vnd(q.l-q.a)+'</em>' : ''));
			var gifts=q.g.length ? '<ul class="tmc-gifts">'+q.g.map(function(g){ return '<li>'+esc(g)+'</li>'; }).join('')+'</ul>' : '';
			return '<li><b>'+esc(x.d)+'</b><span>'+(q.l>q.a?'<s>'+vnd(q.l)+'</s>':'')+vnd(q.a)+'</span><select data-i="'+i+'" aria-label="Số năm đăng ký '+esc(x.d)+'">'+opt+'</select><button type="button" data-rm="'+i+'" aria-label="Bỏ '+esc(x.d)+' khỏi giỏ">Bỏ</button>'+tip+gifts+'</li>';
		}).join('');
		var vat=Math.round(sub*vatPct/100);
		box.querySelector('[data-tmc-saverow]').hidden=!saved; box.querySelector('[data-tmc-save]').textContent=vnd(saved);
		box.querySelector('[data-tmc-vatrow]').hidden=!vat; box.querySelector('[data-tmc-vat]').textContent=vnd(vat);
		box.querySelector('[data-tmc-total]').textContent=vnd(sub+vat);
	}
	list.addEventListener('change',function(e){ var s=e.target.closest('select'); if(!s) return; var c=load(); c[+s.dataset.i].y=+s.value; save(c); render(); });
	list.addEventListener('click',function(e){ var b=e.target.closest('[data-rm]'); if(!b) return; var c=load(); c.splice(+b.dataset.rm,1); save(c); render(); });
	form.addEventListener('change',function(e){
		if(e.target.name!=='type') return; var org=e.target.value==='org';
		form.querySelectorAll('[data-l-person]').forEach(function(n){ n.hidden=org; });
		form.querySelectorAll('[data-l-org]').forEach(function(n){ n.hidden=!org; });
		form.querySelectorAll('[data-only="person"]').forEach(function(n){ n.hidden=org; }); form.dob.required=!org;
		form.querySelectorAll('[data-only="org"]').forEach(function(n){ n.hidden=!org; }); form.rep.required=org; form.rep_idno.required=org; form.rep_dob.required=org;
	});
	/* Tinh, phuong theo dia gioi moi (34 tinh); ten phai khop dung danh muc dang ky ten mien. */
	var dv=form.querySelector('[data-dvhc]'), selP=form.city, selW=form.ward, dvhc=[];
	function fillW(){ var p=dvhc.filter(function(x){ return x[0]===selP.value; })[0]; selW.innerHTML='<option value="">Chọn phường, xã</option>'+(p?p[1].map(function(w){ return '<option>'+esc(w)+'</option>'; }).join(''):''); selW.disabled=!p; }
	fetch(dv.dataset.dvhc).then(function(r){return r.json();}).then(function(j){ dvhc=j; selP.insertAdjacentHTML('beforeend',j.map(function(p){ return '<option>'+esc(p[0])+'</option>'; }).join('')); }).catch(function(){});
	selP.addEventListener('change',fillW);
	form.addEventListener('submit',function(e){
		e.preventDefault(); err.hidden=true;
		if(!form.reportValidity()) return;
		var btn=form.querySelector('.tmc-submit'); btn.disabled=true; btn.textContent='Đang kiểm tra tên miền...';
		var fd=new FormData(form); fd.append('action','dgc_tm_order'); fd.append('n','<?php echo esc_js( wp_create_nonce( 'dgc_tmo' ) ); ?>'); fd.append('items',JSON.stringify(load()));
		fetch(ajax,{method:'POST',body:fd,credentials:'same-origin'}).then(function(r){return r.json();}).then(function(j){
			if(j.ok){ location.href=j.url; return; }
			err.textContent=j.msg||'Chưa tạo được đơn, vui lòng thử lại.'; err.hidden=false;
			btn.disabled=false; btn.textContent='Tạo đơn và thanh toán';
		}).catch(function(){ err.textContent='Mất kết nối, vui lòng thử lại.'; err.hidden=false; btn.disabled=false; btn.textContent='Tạo đơn và thanh toán'; });
	});
	render();
})();
</script>
<?php get_footer(); ?>
