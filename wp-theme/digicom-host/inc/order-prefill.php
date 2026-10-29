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
			var d=b.getAttribute('data-add'), y=+(b.getAttribute('data-y')||1), c=cart(), i=c.findIndex(function(x){ return x.d===d; });
			if(i<0){ c.push({d:d,y:y}); } else { c.splice(i,1); }
			setCart(c); syncBtns(); return;
		}
		var cb=e.target.closest('[data-combo]'); if(cb){
			var ds=cb.getAttribute('data-combo').split(','), c2=cart(), has=ds.every(function(d){ return c2.some(function(x){ return x.d===d&&x.c; }); });
			c2=c2.filter(function(x){ return ds.indexOf(x.d)<0; });
			if(!has) ds.forEach(function(d){ c2.push({d:d,y:1,c:1}); });
			setCart(c2); syncBtns(); return;
		}
		var g=e.target.closest('[data-gift-toggle]'); if(g){ var r=g.closest('.tm-row'); r.classList.toggle('is-open'); g.setAttribute('aria-expanded',r.classList.contains('is-open')); return; }
		var t=e.target.closest('[data-tld]'); if(t){
			e.preventDefault(); form.d.value=''; form.d.placeholder='Nhập tên, ví dụ: thuonghieu'+t.getAttribute('data-tld');
			form.scrollIntoView({behavior:'smooth',block:'center'}); setTimeout(function(){ form.d.focus({preventScroll:true}); },400);
		}
	});
	paintBar();
	function esc(t){ return String(t).replace(/[&<>"]/g,function(c){return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c];}); }
	function inCart(d){ return cart().some(function(c){ return c.d===d; }); }
	function syncBtns(){
		out.querySelectorAll('[data-add]').forEach(function(b){ var on=inCart(b.getAttribute('data-add')); b.classList.toggle('is-added',on); b.textContent=on?'Đã thêm vào giỏ':'Thêm vào giỏ'; });
		out.querySelectorAll('[data-combo]').forEach(function(b){ var c=cart(), on=b.getAttribute('data-combo').split(',').every(function(d){ return c.some(function(x){ return x.d===d&&x.c; }); }); b.classList.toggle('is-added',on); b.textContent=on?'Đã thêm cả bộ':'Thêm cả bộ vào giỏ'; });
	}
	function cond(x){ return x.min>1 ? 'Giá năm đầu khi đăng ký từ '+x.min+' năm' : (x.han ? 'Gia hạn '+esc(x.han)+'/năm' : ''); }
	function gifts(x){ return x.gifts&&x.gifts.length ? '<ul class="tm-gifts">'+x.gifts.map(function(g){ return '<li>'+esc(g)+'</li>'; }).join('')+'</ul>' : ''; }
	function addBtn(x,cls){
		var d=esc(x.d);
		if(x.s==='free') return x.gia ? '<button type="button" class="sg-btn tm-buy '+(cls||'')+'" data-add="'+d+'" data-y="'+(x.min||1)+'">Thêm vào giỏ</button>' : '<a href="#dat-ten-mien" class="sg-btn tm-buy '+(cls||'')+'" data-svc="Tên miền" data-order="Đăng ký tên miền '+d+'">Đăng ký</a>';
		if(x.s==='manual') return '<a href="#dat-ten-mien" class="tm-ask" data-svc="Tên miền" data-order="Kiểm tra và đăng ký tên miền '+d+'">Gửi yêu cầu</a>';
		return '';
	}
	function hero(x){
		var st={free:'Có thể đăng ký tên miền này',taken:'Tên miền đã có người đăng ký',manual:'Cần kiểm tra thủ công'}[x.s]||'';
		var dot=x.d.indexOf('.'), nm=esc(x.d.slice(0,dot)), tl=esc(x.d.slice(dot));
		var price=x.s!=='taken'&&x.gia ? '<p class="tm-hprice"><b>'+esc(x.gia)+'</b><small>/năm đầu</small>'+(x.goc?' <s>'+esc(x.goc)+'</s>':'')+'</p><p class="tm-cond">'+cond(x)+'</p>' : '';
		return '<div class="tm-hero is-'+x.s+'"><span class="tm-badge">'+st+'</span><p class="tm-hname">'+nm+'<span>'+tl+'</span></p>'+(x.s==='taken'?'<p class="tm-cond">Chọn một đuôi còn trống bên dưới, hoặc thử tên khác.</p>':'')+price+addBtn(x,'tm-hbtn')+(x.s!=='taken'?gifts(x):'')+'</div>';
	}
	function combo(c){
		if(!c) return '';
		return '<div class="tm-combo"><span class="tm-badge">'+esc(c.label)+' '+c.pct+'%</span><p class="tm-cname">'+esc(c.name)+' '+c.tlds.map(function(t){ return '<i>'+esc(t)+'</i>'; }).join('<em>+</em>')+'</p><p class="tm-hprice"><b>'+esc(c.gia)+'</b><small>/năm đầu cả bộ</small> <s>'+esc(c.goc)+'</s></p><p class="tm-cond">Giữ trọn tên thương hiệu trên nhiều đuôi, chống người khác đăng ký trùng.</p><button type="button" class="sg-btn tm-buy tm-hbtn" data-combo="'+esc(c.doms.join(','))+'">Thêm cả bộ vào giỏ</button></div>';
	}
	function row(x){
		var d=esc(x.d), st={free:'Còn trống',taken:'Đã có người đăng ký',manual:'Cần kiểm tra thủ công'}[x.s]||'';
		var hasG=x.s==='free'&&x.gifts&&x.gifts.length;
		var badge=x.s==='free'&&x.promo ? '<span class="tm-tag">Có ưu đãi</span>' : '';
		var price=x.gia ? '<span class="tm-price">'+(x.goc?'<s>'+esc(x.goc)+'</s> ':'')+'<b>'+esc(x.gia)+'</b><small>'+(x.min>1?'năm đầu, khi đăng ký từ '+x.min+' năm':'năm đầu'+(x.han?' · gia hạn '+esc(x.han):''))+'</small></span>' : '<span class="tm-price"><small>Liên hệ</small></span>';
		return '<li class="tm-row is-'+x.s+'"><span class="tm-d">'+d+badge+'<em>'+st+(hasG?' · <button type="button" class="tm-gt" data-gift-toggle aria-expanded="false">Xem quà tặng</button>':'')+'</em></span>'+(x.s==='taken'?'':price)+addBtn(x)+(hasG?'<div class="tm-rgifts">'+gifts(x)+'</div>':'')+'</li>';
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
				j.list.sort(function(a,b){ return rank[a.s]-rank[b.s] || (b.promo?1:0)-(a.promo?1:0); });
				out.className='tm-result';
				out.innerHTML='<div class="tm-top'+(j.combo?'':' is-solo')+'">'+hero(q)+combo(j.combo)+'</div><ul class="tm-list">'+j.list.map(row).join('')+'</ul><p class="tm-note">Giá chưa gồm VAT. Quà tặng áp dụng khi tên miền được đăng ký thành công. Kết quả tra cứu có thể thay đổi đến khi tên miền được đăng ký chính thức.</p>';
				syncBtns();
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
