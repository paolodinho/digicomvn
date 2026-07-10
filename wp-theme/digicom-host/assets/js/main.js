(function ($) {
	'use strict';

	// Cong cu tick chon bao/site/goi (checkbox .row-check trong bang gia) + thanh tong
	// tam tinh ghim dau trang (.sel-bar, xem inc/sel-bar.php). Dung chung cho trang
	// Bang gia (nhieu tab, tinh tong CA cac tab) va tung trang dich vu (1 bang).
	(function () {
		var bar = document.querySelector('[data-sel-bar]');
		if (!bar) return;

		var countEl    = bar.querySelector('.sel-bar-count-num');
		var totalEl    = bar.querySelector('.sel-bar-total-num');
		var listToggle = bar.querySelector('.sel-bar-list-toggle');
		var listEl     = bar.querySelector('.sel-bar-list');
		var cta        = bar.querySelector('.sel-bar-cta');
		var ctaBaseHref = cta ? cta.getAttribute('href') : '';

		function formatVND(n) {
			return Math.round(n).toLocaleString('vi-VN');
		}

		function collect() {
			var picked = [];
			document.querySelectorAll('.row-check').forEach(function (cb) {
				if (!cb.checked) return;
				var tr = cb.closest('tr');
				var price = tr ? (parseFloat(tr.getAttribute('data-price')) || 0) : 0;
				picked.push({ cb: cb, name: cb.getAttribute('data-label') || '', price: price });
			});
			return picked;
		}

		function renderList(picked) {
			if (!listEl) return;
			listEl.innerHTML = '';
			picked.forEach(function (p) {
				var row = document.createElement('div');
				row.className = 'sel-item-row';
				var nameSpan = document.createElement('span');
				nameSpan.className = 'sel-item-name';
				nameSpan.textContent = p.name;
				var priceSpan = document.createElement('span');
				priceSpan.className = 'sel-item-price';
				priceSpan.textContent = formatVND(p.price) + 'đ';
				var removeBtn = document.createElement('button');
				removeBtn.type = 'button';
				removeBtn.className = 'sel-item-remove';
				removeBtn.setAttribute('aria-label', 'Bỏ chọn ' + p.name);
				removeBtn.textContent = '×';
				removeBtn.addEventListener('click', function () {
					p.cb.checked = false;
					update();
				});
				row.appendChild(nameSpan);
				row.appendChild(priceSpan);
				row.appendChild(removeBtn);
				listEl.appendChild(row);
			});
		}

		function update() {
			var picked = collect();
			var total = picked.reduce(function (s, p) { return s + p.price; }, 0);
			bar.classList.toggle('has-picks', picked.length > 0);
			if (countEl) countEl.textContent = picked.length;
			if (totalEl) totalEl.textContent = formatVND(total);
			if (listToggle) listToggle.disabled = picked.length === 0;
			if (!picked.length && listEl) listEl.classList.remove('open');
			renderList(picked);
			if (cta) {
				if (picked.length) {
					var summary = picked.map(function (p) { return p.name; }).join(', ');
					var sep = ctaBaseHref.indexOf('?') === -1 ? '?' : '&';
					cta.setAttribute('href', ctaBaseHref + sep + 'selected=' + encodeURIComponent(summary) + '&total=' + Math.round(total));
				} else {
					cta.setAttribute('href', ctaBaseHref);
				}
			}
		}

		document.addEventListener('change', function (e) {
			if (e.target && e.target.classList && e.target.classList.contains('row-check')) update();
		});

		if (listToggle) {
			listToggle.addEventListener('click', function () {
				listEl.classList.toggle('open');
			});
		}
		document.addEventListener('click', function (e) {
			if (listEl && listEl.classList.contains('open') && !bar.contains(e.target)) {
				listEl.classList.remove('open');
			}
		});

		update();
	})();

	// Testimonial carousel (GrowMark-style: item giua highlight)
	$(function () {
		var $tm = $('.tm-carousel');
		if ($tm.length && $.fn.owlCarousel) {
			$tm.owlCarousel({
				loop: $tm.children().length > 3,
				margin: 20,
				center: $tm.children().length > 2,
				nav: false,
				dots: true,
				autoplay: true,
				autoplayTimeout: 6000,
				autoplayHoverPause: true,
				responsive: {
					0: { items: 1 },
					768: { items: 2 },
					992: { items: 3 }
				}
			});
		}
	});

	// Hieu ung den flash phong vien (chu de Booking bao & PR) - nhe, thua thot, tat khi
	// prefers-reduced-motion de khong gay kho chiu/anh huong nguoi nhay cam anh sang.
	(function () {
		if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
		var layer = document.querySelector('.press-flash-layer');
		if (!layer) return;
		function pop() {
			var flash = document.createElement('span');
			flash.className = 'press-flash';
			var size = 60 + Math.random() * 90;
			flash.style.width = size + 'px';
			flash.style.height = size + 'px';
			flash.style.left = Math.random() * 100 + 'vw';
			flash.style.top = Math.random() * 100 + 'vh';
			layer.appendChild(flash);
			setTimeout(function () { flash.remove(); }, 450);
			setTimeout(pop, 4000 + Math.random() * 4000);
		}
		setTimeout(pop, 3000 + Math.random() * 3000);
	})();

	// Watermark logo chim doc: dich chuyen cham hon trang khi cuon (parallax nhe).
	// Ap len khoi ngoai (.brand-watermark) - anh/chu ben trong da co animation "bong benh"
	// rieng (wm-float / wm-float-text), 2 transform khong dam vao nhau vi khac phan tu.
	(function () {
		if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
		var wm = document.querySelector('[data-brand-watermark]');
		if (!wm) return;
		var ticking = false;
		function update() {
			var y = window.scrollY || window.pageYOffset || 0;
			wm.style.transform = 'translateY(' + (y * -0.12) + 'px)';
			ticking = false;
		}
		window.addEventListener('scroll', function () {
			if (!ticking) { window.requestAnimationFrame(update); ticking = true; }
		}, { passive: true });
	})();

	// Do chieu cao THAT cua bottom-nav (thay vi doan cung trong CSS) de nut mui ten len +
	// nut Zalo luon nam dung phia tren, khong bi de - chinh xac tren moi may/font/zoom.
	(function () {
		var bn = document.querySelector('.bottom-nav');
		if (!bn) return;
		function sync() {
			if (getComputedStyle(bn).display === 'none') return;
			document.documentElement.style.setProperty('--bn-h', bn.offsetHeight + 'px');
		}
		sync();
		window.addEventListener('resize', sync);
		window.addEventListener('orientationchange', sync);
		if (document.fonts && document.fonts.ready) document.fonts.ready.then(sync);
	})();

	// Back to top
	var $toTop = document.querySelector('.to-top');
	if ($toTop) {
		window.addEventListener('scroll', function () {
			if (window.scrollY > 300) $toTop.classList.add('show');
			else $toTop.classList.remove('show');
		});
		$toTop.addEventListener('click', function (e) {
			e.preventDefault();
			window.scrollTo({ top: 0, behavior: 'smooth' });
		});
	}
})(jQuery);
