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
		var resetBtn   = bar.querySelector('.sel-bar-reset');
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
					var need   = nt.min - picked.length;
					var save   = formatVND(subtotal * nt.pct / 100);
					// Mobile: cau ngan de nam gon 1 dong trong thanh (khong bi cat duoi).
					var narrow = window.matchMedia('(max-width:640px)').matches;
					nudgeEl.hidden = false;
					nudgeEl.textContent = narrow
						? 'Thêm ' + need + ' mục → giảm ' + pctText(nt.pct) + ' (~' + save + 'đ)'
						: 'Chọn thêm ' + need + ' mục nữa để được giảm ' + pctText(nt.pct) +
						  ' (tiết kiệm ~' + save + 'đ).';
				} else {
					nudgeEl.hidden = true;
				}
			}

			// Nut "Chon lai" chi hien khi dang co muc duoc chon
			if (resetBtn) resetBtn.hidden = picked.length === 0;

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

		// "Chon lai": bo tick toan bo, dua thanh tong ve 0
		if (resetBtn) {
			resetBtn.addEventListener('click', function () {
				document.querySelectorAll('.row-check:checked').forEach(function (cb) { cb.checked = false; });
				update();
				bar.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
			});
		}

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
		var nganhSel  = panel.querySelector('.filter-nganh');
		var facetSels = panel.querySelectorAll('.filter-facet');
		var chipsBox  = panel.querySelector('.filter-chips');
		var clearBtn  = panel.querySelector('.filter-clear');
		var moreBtn   = panel.querySelector('.price-more-btn');
		var limit     = parseInt(panel.getAttribute('data-limit') || '0', 10);
		var STEP      = 10;              // moi lan cuon toi cuoi bang: nap them 10 dong
		var curNganh  = '';
		// Bo loc quy cach bai: { link: {val:'dofollow'}, anh: {val:5, mode:'min'}, ... } - ket hop AND.
		var curFacets = {};
		var shownMax  = limit > 0 ? limit : Infinity;  // so dong dang hien (cuon vo han tang dan)
		if (!rows.length) return;

		function okFacets(r) {
			for (var key in curFacets) {
				var f = curFacets[key];
				var raw = r.getAttribute('data-' + key) || '';
				if (f.mode === 'min') {
					if ((parseFloat(raw) || 0) < parseFloat(f.val)) return false;
				} else if (raw !== f.val) {
					return false;
				}
			}
			return true;
		}

		/* "Báo Thanh Niên" / "thanh niên" / "thanhnien.vn" phai ra CUNG ket qua (Hieu 2026-07-14):
		   nen truy van ve dang khong dau, khong khoang trang, bo duoi ten mien, bo tien to "bao"
		   - dung cach PHP nen data-key (xem dgc_gia_search_terms trong inc/cpt-gia.php). */
		function nenKhoa(s) {
			return s.normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/\u0111/g, 'd')
				.toLowerCase()
				.replace(/\.(com\.vn|com|vn|net|org|info|edu\.vn|gov\.vn|asia|tv)\b/g, ' ')
				.replace(/[^a-z0-9]+/g, '')
				.replace(/^bao/, '');
		}

		function applyFilter() {
			var qRaw = (input ? input.value : '').trim().toLowerCase();
			var q    = qRaw;
			var qKey = nenKhoa(qRaw);
			var matched = rows.filter(function (r) {
				var okQ = !q
					|| r.getAttribute('data-name').indexOf(q) !== -1
					|| (qKey && (r.getAttribute('data-key') || '').indexOf(qKey) !== -1);
				var okN = !curNganh || (' ' + r.getAttribute('data-nganh') + ' ').indexOf(' ' + curNganh + ' ') !== -1;
				return okQ && okN && okFacets(r);
			});
			var collapse = shownMax < matched.length;
			var visible  = collapse ? matched.slice(0, shownMax) : matched;

			rows.forEach(function (r) { r.style.display = 'none'; });
			visible.forEach(function (r) { r.style.display = ''; });

			// Khong con dong nao khop -> bao ro thay vi de bang trong.
			if (tbody) {
				var emptyRow = tbody.querySelector('.price-empty-row');
				if (!matched.length) {
					if (!emptyRow) {
						emptyRow = document.createElement('tr');
						emptyRow.className = 'price-empty-row';
						emptyRow.innerHTML = '<td colspan="4">Không có mục nào khớp bộ lọc. Bỏ bớt điều kiện hoặc liên hệ để được báo giá theo yêu cầu riêng.</td>';
						tbody.appendChild(emptyRow);
					}
					emptyRow.style.display = '';
				} else if (emptyRow) {
					emptyRow.style.display = 'none';
				}
			}

			if (shownEl) shownEl.textContent = visible.length;
			if (totalEl) totalEl.textContent = rows.length;
			if (moreBtn) {
				moreBtn.style.display = collapse ? '' : 'none';
				moreBtn.textContent = 'Xem thêm ' + Math.min(STEP, matched.length - shownMax) + ' mục';
			}
			return collapse;
		}

		// Cuon vo han: nut "Xem thêm" vua la fallback (khong JS observer) vua la moc quan sat -
		// vao tam nhin la tu nap them STEP dong, khong bat khach bam.
		function loadMore() {
			if (shownMax === Infinity) return;
			shownMax += STEP;
			applyFilter();
		}
		if (moreBtn && 'IntersectionObserver' in window) {
			new IntersectionObserver(function (entries) {
				entries.forEach(function (e) { if (e.isIntersecting) loadMore(); });
			}, { rootMargin: '200px 0px' }).observe(moreBtn);
		}

		// Doi tu khoa / doi bo loc -> quay lai xem tu dau danh sach moi.
		function resetShown() { shownMax = limit > 0 ? limit : Infinity; }

		if (input) {
			var t;
			input.addEventListener('input', function () {
				clearTimeout(t);
				t = setTimeout(function () { resetShown(); applyFilter(); }, 120);
			});
		}

		// Thanh loc ngang: 1 dropdown cho nhom bao + 1 dropdown moi nhom quy cach, AND voi nhau.
		// Dieu kien dang bat hien thanh chip co nut x de bo nhanh tung cai.
		function selLabel(sel) {
			var o = sel.options[sel.selectedIndex];
			return o ? o.textContent.replace(/\s*\(\d+\)\s*$/, '') : '';
		}

		function syncChips() {
			if (!chipsBox) return;
			var active = [];
			if (nganhSel && nganhSel.value) active.push({ sel: nganhSel, text: selLabel(nganhSel) });
			facetSels.forEach(function (s) { if (s.value) active.push({ sel: s, text: selLabel(s) }); });

			chipsBox.innerHTML = '';
			active.forEach(function (a) {
				var chip = document.createElement('button');
				chip.type = 'button';
				chip.className = 'filter-chip';
				chip.innerHTML = a.text + '<span aria-hidden="true">×</span>';
				chip.setAttribute('aria-label', 'Bỏ lọc ' + a.text);
				chip.addEventListener('click', function () {
					a.sel.value = '';
					a.sel.dispatchEvent(new Event('change'));
				});
				chipsBox.appendChild(chip);
			});
			chipsBox.hidden = !active.length;
			if (clearBtn) clearBtn.hidden = active.length < 2;
		}

		if (nganhSel) {
			nganhSel.addEventListener('change', function () {
				curNganh = nganhSel.value || '';
				resetShown();
				applyFilter();
				syncChips();
			});
		}

		facetSels.forEach(function (sel) {
			sel.addEventListener('change', function () {
				var key = sel.getAttribute('data-facet');
				var opt = sel.options[sel.selectedIndex];
				if (!sel.value) {
					delete curFacets[key];
				} else {
					curFacets[key] = { val: sel.value, mode: opt.getAttribute('data-mode') || 'eq' };
				}
				resetShown();
				applyFilter();
				syncChips();
			});
		});

		if (clearBtn) {
			clearBtn.addEventListener('click', function () {
				if (nganhSel) nganhSel.value = '';
				facetSels.forEach(function (s) { s.value = ''; });
				curNganh = '';
				curFacets = {};
				resetShown();
				applyFilter();
				syncChips();
			});
		}

		sortBtns.forEach(function (btn) {
			btn.addEventListener('click', function () {
				// data-key="price" (mac dinh) hoac "dr" - dung chung 1 co che sap xep.
				var key = btn.getAttribute('data-key') === 'dr' ? 'data-dr' : 'data-price';
				var dir = btn.getAttribute('data-dir') === 'asc' ? 1 : -1;
				sortBtns.forEach(function (b) { b.classList.toggle('active', b === btn); });
				rows.sort(function (a, b) {
					var pa = parseFloat(a.getAttribute(key)) || 0;
					var pb = parseFloat(b.getAttribute(key)) || 0;
					return (pa - pb) * dir;
				});
				rows.forEach(function (r) { tbody.appendChild(r); });
				applyFilter();
			});
		});

		if (moreBtn) {
			moreBtn.addEventListener('click', loadMore);
		}

		applyFilter();
	});

	// Dem nguoc han chot uu dai ([data-promo-end] = timestamp giay).
	// Chay toi PHUT:GIAY, nhay tung giay (Hieu 2026-07-14) - moc "N ngay X gio" khong tao suc ep.
	//   Con >= 1 ngay: "17 ngày 07:23:45"   |   Trong ngay cuoi: "07:23:45"
	// Het han: an ca dong (khong bao gio hien so am).
	document.querySelectorAll('.promo-count[data-promo-end]').forEach(function (el) {
		var end = parseInt(el.getAttribute('data-promo-end'), 10) * 1000;
		var val = el.querySelector('.promo-count-val');
		if (!end || !val) return;

		function hai(n) { return n < 10 ? '0' + n : '' + n; }

		function tick() {
			var left = end - Date.now();
			if (left <= 0) { el.style.display = 'none'; return; }
			var d = Math.floor(left / 86400000);
			var h = Math.floor(left / 3600000) % 24;
			var m = Math.floor(left / 60000) % 60;
			var s = Math.floor(left / 1000) % 60;
			var dongho = hai(h) + ':' + hai(m) + ':' + hai(s);
			val.textContent = d >= 1 ? (d + ' ngày ' + dongho) : dongho;
		}
		tick();
		setInterval(tick, 1000);
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

/* ==========================================================================
   Popup uu dai -> dan ve trang bang gia (Hieu 2026-07-14).
   Chi hien 1 lan/phien; mo sau 7s hoac khi cuon qua 35% trang - lay moc nao den truoc.
   ========================================================================== */
(function () {
	var pop = document.getElementById('promoPop');
	if (!pop) return;

	var KEY = 'dgcPromoPop';
	try { if (sessionStorage.getItem(KEY)) return; } catch (e) {}

	var opened = false, timer = null;

	function close() {
		pop.hidden = true;
		pop.setAttribute('aria-hidden', 'true');
		document.body.style.overflow = '';
		try { sessionStorage.setItem(KEY, '1'); } catch (e) {}
		document.removeEventListener('keydown', onKey);
	}

	function onKey(e) { if (e.key === 'Escape') close(); }

	function open() {
		if (opened) return;
		opened = true;
		if (timer) clearTimeout(timer);
		window.removeEventListener('scroll', onScroll);
		pop.hidden = false;
		pop.setAttribute('aria-hidden', 'false');
		document.body.style.overflow = 'hidden';
		document.addEventListener('keydown', onKey);
		/* Focus vao THE, khong focus vao nut - focus ring quanh nut CTA trong nhu loi giao dien. */
		var card = pop.querySelector('.promo-pop-card');
		if (card) { card.setAttribute('tabindex', '-1'); card.focus({ preventScroll: true }); }
	}

	function onScroll() {
		var h = document.documentElement.scrollHeight - window.innerHeight;
		if (h > 0 && window.scrollY / h > 0.35) open();
	}

	timer = setTimeout(open, 7000);
	window.addEventListener('scroll', onScroll, { passive: true });

	pop.querySelectorAll('[data-pop-close]').forEach(function (el) {
		el.addEventListener('click', close);
	});
	/* Bam nut CTA (sang trang bang gia) cung ghi nhan da xem -> khong bat lai o trang sau. */
	var go = pop.querySelector('.promo-pop-actions .btn');
	if (go) go.addEventListener('click', function () { try { sessionStorage.setItem(KEY, '1'); } catch (e) {} });
})();

/* Thanh tim kiem tren header: bam kinh lup -> mo/dong o nhap, tu focus con tro. */
(function () {
	var box = document.getElementById('hdrSearch');
	if (!box) return;
	var input   = box.querySelector('[data-search-input]');
	var toggles = document.querySelectorAll('[data-search-toggle]');
	var btn     = document.querySelector('.hdr-search-btn');

	function toggle() {
		var open = box.hidden;
		box.hidden = !open;
		if (btn) btn.setAttribute('aria-expanded', open ? 'true' : 'false');
		if (open && input) input.focus();
	}

	toggles.forEach(function (t) { t.addEventListener('click', toggle); });
	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape' && !box.hidden) toggle();
	});
})();

/* Nut "Gói gồm những gì?" - so ra chi tiet goi ngay trong dong bang gia (Hieu 2026-07-15). */
document.addEventListener('click', function (e) {
	var btn = e.target.closest ? e.target.closest('.pkg-toggle') : null;
	if (!btn) return;
	var box = document.getElementById(btn.getAttribute('aria-controls'));
	if (!box) return;
	var mo = box.hidden;
	box.hidden = !mo;
	btn.setAttribute('aria-expanded', mo ? 'true' : 'false');
	btn.querySelector('.pkg-toggle-txt').textContent = mo ? 'Thu gọn' : 'Gói gồm những gì?';
});
