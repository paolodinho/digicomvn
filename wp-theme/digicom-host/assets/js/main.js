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
		var subEl      = bar.querySelector('.sel-bar-sub-num');
		var discBox    = bar.querySelector('.sel-bar-disc');
		var discPctEl  = bar.querySelector('.sel-bar-disc-pct');
		var discNumEl  = bar.querySelector('.sel-bar-disc-num');
		var nudgeEl    = bar.querySelector('.sel-bar-nudge');
		var listToggle = bar.querySelector('.sel-bar-list-toggle');
		var listEl     = bar.querySelector('.sel-bar-list');
		var cta        = bar.querySelector('.sel-bar-cta');
		var ctaBaseHref = cta ? cta.getAttribute('href') : '';

		// Bac chiet khau combo: [{min: so muc, pct: % giam}] - cau hinh o WP Admin (dgc_combo_tiers).
		var tiers = [];
		try { tiers = JSON.parse(bar.getAttribute('data-tiers') || '[]') || []; } catch (err) { tiers = []; }
		tiers.sort(function (a, b) { return a.min - b.min; });

		function formatVND(n) {
			return Math.round(n).toLocaleString('vi-VN');
		}

		function pctText(p) {
			return (Math.round(p * 10) / 10).toString().replace('.', ',') + '%';
		}

		// Bac cao nhat ma so muc da tick dat duoc (0 neu chua du dieu kien).
		function tierFor(count) {
			var pct = 0;
			tiers.forEach(function (t) { if (count >= t.min) pct = t.pct; });
			return pct;
		}

		// Bac tiep theo chua dat -> dung de goi y "chon them N muc de duoc giam X%".
		function nextTier(count) {
			for (var i = 0; i < tiers.length; i++) {
				if (count < tiers[i].min) return tiers[i];
			}
			return null;
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
			var picked   = collect();
			var subtotal = picked.reduce(function (s, p) { return s + p.price; }, 0);
			var pct      = tierFor(picked.length);
			var discount = Math.round(subtotal * pct / 100);
			var total    = subtotal - discount;

			bar.classList.toggle('has-picks', picked.length > 0);
			document.body.classList.toggle('sel-bar-fixed', picked.length > 0);
			if (picked.length) {
				requestAnimationFrame(function () {
					document.documentElement.style.setProperty('--selbar-h', bar.offsetHeight + 'px');
				});
			}

			if (countEl) countEl.textContent = picked.length;
			if (subEl)   subEl.textContent   = formatVND(subtotal) + 'đ';
			if (totalEl) totalEl.textContent = formatVND(total);

			if (discBox) {
				discBox.hidden = !(pct > 0 && picked.length);
				if (discPctEl) discPctEl.textContent = pctText(pct);
				if (discNumEl) discNumEl.textContent = '-' + formatVND(discount) + 'đ';
			}

			// Goi y bac ke tiep: con thieu bao nhieu muc de len muc giam cao hon.
			if (nudgeEl) {
				var nt = picked.length ? nextTier(picked.length) : null;
				if (nt) {
					var need = nt.min - picked.length;
					nudgeEl.hidden = false;
					nudgeEl.textContent = 'Chọn thêm ' + need + ' mục nữa để được giảm ' + pctText(nt.pct) +
						' (tiết kiệm ~' + formatVND(subtotal * nt.pct / 100) + 'đ).';
				} else {
					nudgeEl.hidden = true;
				}
			}

			if (listToggle) listToggle.disabled = picked.length === 0;
			if (!picked.length && listEl) listEl.classList.remove('open');
			renderList(picked);

			if (cta) {
				if (picked.length) {
					var summary = picked.map(function (p) { return p.name; }).join(', ');
					var sep = ctaBaseHref.indexOf('?') === -1 ? '?' : '&';
					cta.setAttribute('href', ctaBaseHref + sep + 'selected=' + encodeURIComponent(summary) +
						'&subtotal=' + Math.round(subtotal) + '&discount=' + Math.round(discount) +
						'&discount_pct=' + pct + '&total=' + Math.round(total));
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

	// Bang gia: tim kiem + sap xep + loc nganh + "xem them" cho MOI khoi bang gia
	// ([data-price-panel]). Dung chung cho trang Bang gia (5 tab) va bang gia nhung
	// trong tung trang dich vu (inc/service-pricing.php).
	document.querySelectorAll('[data-price-panel]').forEach(function (panel) {
		var input     = panel.querySelector('.tab-search-input');
		var tbody     = panel.querySelector('.price-table-cpt tbody');
		var rows      = Array.prototype.slice.call(panel.querySelectorAll('.price-table-cpt tbody tr[data-name]'));
		var shownEl   = panel.querySelector('.tab-count-shown');
		var totalEl   = panel.querySelector('.tab-count-total');
		var sortBtns  = panel.querySelectorAll('.sort-btn');
		var nganhBtns = panel.querySelectorAll('.nganh-btn');
		var moreBtn   = panel.querySelector('.price-more-btn');
		var limit     = parseInt(panel.getAttribute('data-limit') || '0', 10);
		var curNganh  = '';
		var expanded  = false;
		if (!rows.length) return;

		function applyFilter() {
			var q = (input ? input.value : '').trim().toLowerCase();
			var matched = rows.filter(function (r) {
				var okQ = !q || r.getAttribute('data-name').indexOf(q) !== -1;
				var okN = !curNganh || (' ' + r.getAttribute('data-nganh') + ' ').indexOf(' ' + curNganh + ' ') !== -1;
				return okQ && okN;
			});
			// Chi thu gon khi dang xem mac dinh (khong tim kiem, khong loc, chua bam "xem them").
			var collapse = limit > 0 && !expanded && !q && !curNganh && matched.length > limit;
			var visible  = collapse ? matched.slice(0, limit) : matched;

			rows.forEach(function (r) { r.style.display = 'none'; });
			visible.forEach(function (r) { r.style.display = ''; });

			if (shownEl) shownEl.textContent = visible.length;
			if (totalEl) totalEl.textContent = rows.length;
			if (moreBtn) {
				moreBtn.style.display = collapse ? '' : 'none';
				moreBtn.textContent = 'Xem thêm ' + (matched.length - limit) + ' mục';
			}
		}

		if (input) {
			var t;
			input.addEventListener('input', function () {
				clearTimeout(t);
				t = setTimeout(applyFilter, 120);
			});
		}

		nganhBtns.forEach(function (btn) {
			btn.addEventListener('click', function () {
				curNganh = btn.getAttribute('data-nganh') || '';
				nganhBtns.forEach(function (b) { b.classList.toggle('active', b === btn); });
				applyFilter();
			});
		});

		sortBtns.forEach(function (btn) {
			btn.addEventListener('click', function () {
				var dir = btn.getAttribute('data-dir') === 'asc' ? 1 : -1;
				sortBtns.forEach(function (b) { b.classList.toggle('active', b === btn); });
				rows.sort(function (a, b) {
					var pa = parseFloat(a.getAttribute('data-price')) || 0;
					var pb = parseFloat(b.getAttribute('data-price')) || 0;
					return (pa - pb) * dir;
				});
				rows.forEach(function (r) { tbody.appendChild(r); });
				applyFilter();
			});
		});

		if (moreBtn) {
			moreBtn.addEventListener('click', function () {
				expanded = true;
				applyFilter();
			});
		}

		applyFilter();
	});

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
