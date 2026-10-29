<?php
/**
 * Nut [data-order] -> cuon toi form #lien-he, chon dich vu + dien san noi dung.
 * Kiem tra ten mien (#tm-check) qua AJAX dgc_domain_check (inc/domain-hosting.php).
 * Ten mien con trong co gia -> nut Them vao gio (localStorage dgc_tm_cart), thanh toan o /thanh-toan-ten-mien/ (inc/domain-order.php).
 * Dung chung cho trang ten mien, hosting, phan mem SEO, khoa hoc.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<script>
(function(){
	function fill(text, svc){
		var sel=document.getElementById('dgc_service'), msg=document.getElementById('dgc_message');
		if(sel && svc){
			var ok=false; for(var i=0;i<sel.options.length;i++){ if(sel.options[i].text===svc){ sel.selectedIndex=i; ok=true; } }
			if(!ok){ var o=document.createElement('option'); o.text=svc; sel.add(o,0); sel.selectedIndex=0; }
		}
		if(msg && text){ msg.value = msg.value && msg.value.indexOf(text)<0 ? msg.value+'\n'+text : text; }
		var f=document.getElementById('lien-he'); if(f){ f.scrollIntoView({behavior:'smooth',block:'start'}); }
		var n=document.getElementById('dgc_name'); if(n){ setTimeout(function(){ n.focus({preventScroll:true}); },500); }
	}
	document.addEventListener('click',function(e){
		var a=e.target.closest('[data-order]'); if(!a) return;
		e.preventDefault(); fill(a.getAttribute('data-order'), a.getAttribute('data-svc'));
	});
	var form=document.getElementById('tm-check'), out=document.getElementById('tm-result');
	if(!form) return;
	var bar=document.querySelector('[data-tm-bar]');
	if(bar) document.body.appendChild(bar); /* hero co transform -> fixed bi tinh theo hero, dua ra body */
	function cart(){ try{ return JSON.parse(localStorage.getItem('dgc_tm_cart')||'[]'); }catch(x){ return []; } }
	function setCart(c){ try{ localStorage.setItem('dgc_tm_cart',JSON.stringify(c)); }catch(x){} paintBar(); }
	function paintBar(){ if(!bar) return; var n=cart().length; bar.hidden=!n; bar.querySelector('[data-tm-n]').textContent=n; }
	document.addEventListener('click',function(e){
		var b=e.target.closest('[data-add]'); if(b){
			var d=b.getAttribute('data-add'), c=cart(), i=c.findIndex(function(x){ return x.d===d; });
			if(i<0){ c.push({d:d,y:1}); b.classList.add('is-added'); b.textContent='Đã thêm'; } else { c.splice(i,1); b.classList.remove('is-added'); b.textContent='Thêm vào giỏ'; }
			setCart(c); return;
		}
		var t=e.target.closest('[data-tld]'); if(t){
			e.preventDefault(); form.d.value=''; form.d.placeholder='Nhập tên, ví dụ: thuonghieu'+t.getAttribute('data-tld');
			form.scrollIntoView({behavior:'smooth',block:'center'}); setTimeout(function(){ form.d.focus({preventScroll:true}); },400);
		}
	});
	paintBar();
	function esc(t){ return String(t).replace(/[&<>"]/g,function(c){return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c];}); }
	function row(x){
		var d=esc(x.d), st={free:'Còn trống',taken:'Đã có người đăng ký',manual:'Cần kiểm tra thủ công'}[x.s]||'';
		var price=x.gia ? '<span class="tm-price">'+(x.goc?'<s>'+esc(x.goc)+'</s> ':'')+'<b>'+esc(x.gia)+'</b><small>năm đầu</small></span>' : '<span class="tm-price"><small>Liên hệ</small></span>';
		var inCart=cart().some(function(c){ return c.d===x.d; });
		var act=x.s==='free' ? (x.gia ? '<button type="button" class="sg-btn tm-buy'+(inCart?' is-added':'')+'" data-add="'+d+'">'+(inCart?'Đã thêm':'Thêm vào giỏ')+'</button>' : '<a href="#dat-ten-mien" class="sg-btn tm-buy" data-svc="Tên miền" data-order="Đăng ký tên miền '+d+'">Đăng ký</a>')
			: (x.s==='manual' ? '<a href="#dat-ten-mien" class="tm-ask" data-svc="Tên miền" data-order="Kiểm tra và đăng ký tên miền '+d+'">Gửi yêu cầu</a>' : '');
		return '<li class="tm-row is-'+x.s+'"><span class="tm-d">'+d+'<em>'+st+'</em></span>'+(x.s==='taken'?'':price)+act+'</li>';
	}
	form.addEventListener('submit',function(e){
		e.preventDefault();
		var d=form.d.value.trim().toLowerCase().replace(/^https?:\/\//,'').replace(/^www\./,'').replace(/\/.*$/,'').replace(/\s+/g,'');
		if(!d) return;
		out.hidden=false; out.className='tm-result is-loading'; out.textContent='Đang kiểm tra '+d+' và các đuôi phổ biến...';
		var fd=new FormData(); fd.append('action','dgc_domain_check'); fd.append('n','<?php echo esc_js( wp_create_nonce( 'dgc_dc' ) ); ?>'); fd.append('d',d);
		fetch('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>',{method:'POST',body:fd,credentials:'same-origin'}).then(function(r){return r.json();}).then(function(j){
			if(j.s==='ok'){
				var rank={free:0,manual:1,taken:2}, q=j.list.shift();
				j.list.sort(function(a,b){return rank[a.s]-rank[b.s];}); j.list.unshift(q);
				var free=j.list.filter(function(x){return x.s==='free';}).length;
				out.className='tm-result';
				out.innerHTML='<p class="tm-sum">'+(free?'Có <b>'+free+'</b> tên miền còn trống. Thêm vào giỏ rồi thanh toán bằng mã QR ngay trên trang.':'Các tên miền dưới đây chưa đăng ký được ngay. Gửi yêu cầu để DigicomVN gợi ý tên thay thế.')+'</p><ul class="tm-list">'+j.list.map(row).join('')+'</ul><p class="tm-note">Giá chưa gồm VAT. Kết quả tra cứu có thể thay đổi đến khi tên miền được đăng ký chính thức.</p>';
			}
			else if(j.s==='bad'){ out.className='tm-result is-taken'; out.textContent='Tên miền chưa đúng định dạng, ví dụ: thuonghieu hoặc thuonghieu.vn'; }
			else if(j.s==='limit'){ out.className='tm-result'; out.textContent='Bạn đã kiểm tra nhiều lần, vui lòng thử lại sau ít phút hoặc gọi hotline.'; }
			else { out.className='tm-result'; out.textContent='Chưa kiểm tra được, vui lòng gửi yêu cầu bên dưới.'; }
		}).catch(function(){ out.className='tm-result'; out.textContent='Chưa kiểm tra được, vui lòng gửi yêu cầu bên dưới.'; });
	});
	var q=new URLSearchParams(location.search).get('d');
	if(q){ form.d.value=q; form.requestSubmit ? form.requestSubmit() : form.dispatchEvent(new Event('submit',{cancelable:true})); }
})();
</script>
