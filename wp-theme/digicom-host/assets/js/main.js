(function ($) {
	'use strict';

	// Chat AI tu van (DeepSeek) - goi admin-ajax dgc_ai_chat, key o server (Hieu 2026-07-15).
	(function () {
		var box = document.querySelector('[data-ai-chat]');
		if (!box || typeof window.DGC_AI === 'undefined') return;
		var log   = box.querySelector('[data-ai-log]');
		var form  = box.querySelector('[data-ai-form]');
		var input = box.querySelector('[data-ai-input]');
		var suggBox = box.querySelector('[data-ai-sugg]');
		var history = [];
		var busy = false;

		function esc(t) { var d = document.createElement('div'); d.textContent = t; return d.innerHTML; }
		function addMsg(role, text) {
			var el = document.createElement('div');
			el.className = 'ai-msg ' + (role === 'user' ? 'ai-user' : 'ai-bot');
			el.innerHTML = esc(text).replace(/\n/g, '<br>');
			log.appendChild(el);
			log.scrollTop = log.scrollHeight;
			return el;
		}
		function typing() {
			var el = document.createElement('div');
			el.className = 'ai-msg ai-bot ai-typing';
			el.innerHTML = '<span></span><span></span><span></span>';
			log.appendChild(el);
			log.scrollTop = log.scrollHeight;
			return el;
		}
		function send(text) {
			text = (text || '').trim();
			if (!text || busy) return;
			busy = true;
			if (suggBox) suggBox.style.display = 'none';
			addMsg('user', text);
			history.push({ role: 'user', content: text });
			input.value = '';
			var t = typing();
			$.ajax({
				url: window.DGC_AI.url, method: 'POST', dataType: 'json',
				data: { action: 'dgc_ai_chat', nonce: window.DGC_AI.nonce, messages: JSON.stringify(history) }
			}).done(function (res) {
				t.remove();
				if (res && res.success && res.data && res.data.reply) {
					addMsg('bot', res.data.reply);
					history.push({ role: 'assistant', content: res.data.reply });
				} else {
					addMsg('bot', (res && res.data && res.data.msg) ? res.data.msg : 'Xin loi, co su co. Vui long lien he hotline.');
				}
			}).fail(function (xhr) {
				t.remove();
				var m = 'Ket noi gap su co. Vui long lien he hotline.';
				try { var j = xhr.responseJSON; if (j && j.data && j.data.msg) m = j.data.msg; } catch (e) {}
				addMsg('bot', m);
			}).always(function () { busy = false; input.focus(); });
		}
		form.addEventListener('submit', function (e) { e.preventDefault(); send(input.value); });
		if (suggBox) {
			suggBox.addEventListener('click', function (e) {
				var b = e.target.closest('.ai-sugg-btn');
				if (b) send(b.textContent);
			});
		}
	})();

	// Ribbon uu dai GHIM sticky top:0 -> day header (va sel-bar) xuong duoi bang bien
	// --ribbon-h = chieu cao that cua ribbon (doi theo viewport/wrap dong). (Hieu 2026-07-15)
	(function () {
		var bar = document.querySelector('.promo-bar');
		var root = document.documentElement;
		function sync() {
			root.style.setProperty('--ribbon-h', bar ? bar.offsetHeight + 'px' : '0px');
		}
		if (!bar) { root.style.setProperty('--ribbon-h', '0px'); return; }
		sync();
		window.addEventListener('resize', sync);
		window.addEventListener('load', sync);
	})();

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

		// Nho bao da tick qua localStorage (Hieu 2026-07-18): khach tick VNE nhung chua gui
		// yeu cau -> lan sau quay lai (trang nay hoac trang khac co cung bang gia) van thay
		// tick san. Khoa theo tr[data-key] (on dinh, giong nhau moi noi bao do xuat hien).
		var PICK_STORE_KEY = 'dgc_picked_bao';
		function loadPickStore() {
			try { return JSON.parse(localStorage.getItem(PICK_STORE_KEY) || '[]'); } catch (err) { return []; }
		}
		function savePickStore(keys) {
			try { localStorage.setItem(PICK_STORE_KEY, JSON.stringify(keys)); } catch (err) { /* noop */ }
		}
		function persistPicks() {
			var set = {};
			loadPickStore().forEach(function (k) { set[k] = true; });
			document.querySelectorAll('.row-check').forEach(function (cb) {
				var tr = cb.closest('tr');
				var key = tr ? tr.getAttribute('data-key') : '';
				if (!key) return;
				if (cb.checked) set[key] = true; else delete set[key];
			});
			savePickStore(Object.keys(set));
		}
		function restorePicks() {
			var stored = loadPickStore();
			if (!stored.length) return;
			var set = {};
			stored.forEach(function (k) { set[k] = true; });
			document.querySelectorAll('.row-check').forEach(function (cb) {
				var tr = cb.closest('tr');
				var key = tr ? tr.getAttribute('data-key') : '';
				if (key && set[key]) cb.checked = true;
			});
		}

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
			persistPicks();
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

		// "Dat ngay" tren 1 dong -> tu tick chinh bao/goi do roi sang trang gui yeu cau (Hieu 2026-07-15).
		document.addEventListener('click', function (e) {
			var btn = e.target.closest ? e.target.closest('.order-now') : null;
			if (!btn) return;
			e.preventDefault();
			var tr = btn.closest('tr');
			var cb = tr ? tr.querySelector('.row-check') : null;
			if (cb && !cb.checked) { cb.checked = true; update(); }
			window.location.href = (cta && cta.getAttribute('href')) || btn.getAttribute('href') || '/dat-bai/';
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

		restorePicks();
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
   Popup uu dai: MO khi bam pill noi (.promo-fab / [data-pop-open]) tren moi trang;
   tu popup bam "Xem bang gia" -> trang bang gia (Hieu 2026-07-15).
   Bo tu dong bat sau 7s/cuon 35% - gio nguoi dung chu dong bam pill, gon gang hon.
   ========================================================================== */
(function () {
	var pop = document.getElementById('promoPop');
	if (!pop) return;

	var opened = false;

	function close() {
		pop.hidden = true;
		pop.setAttribute('aria-hidden', 'true');
		document.body.style.overflow = '';
		document.removeEventListener('keydown', onKey);
		opened = false;
	}

	function onKey(e) { if (e.key === 'Escape') close(); }

	function open() {
		if (opened) return;
		opened = true;
		pop.hidden = false;
		pop.setAttribute('aria-hidden', 'false');
		document.body.style.overflow = 'hidden';
		document.addEventListener('keydown', onKey);
		/* Focus vao THE, khong focus vao nut - focus ring quanh nut CTA trong nhu loi giao dien. */
		var card = pop.querySelector('.promo-pop-card');
		if (card) { card.setAttribute('tabindex', '-1'); card.focus({ preventScroll: true }); }
	}

	document.querySelectorAll('[data-pop-open]').forEach(function (el) {
		el.addEventListener('click', open);
	});
	pop.querySelectorAll('[data-pop-close]').forEach(function (el) {
		el.addEventListener('click', close);
	});
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

/* "Gioi thieu bao/trang nay" -> mo POPUP thay vi xo doc (Hieu 2026-07-15: xo doc lam trang dai,
   kho theo doi). Noi dung lay tu .intro-detail (van render an) cua dong do, do vao 1 modal chung. */
(function () {
	var modal = null;
	function build() {
		modal = document.createElement('div');
		modal.className = 'intro-pop';
		modal.hidden = true;
		modal.innerHTML =
			'<div class="intro-pop-mask" data-intro-close></div>' +
			'<div class="intro-pop-card" role="dialog" aria-modal="true" tabindex="-1">' +
			'<button type="button" class="intro-pop-x" data-intro-close aria-label="Đóng">&times;</button>' +
			'<h3 class="intro-pop-title"></h3><div class="intro-pop-body"></div>' +
			'<div class="intro-pop-foot"><button type="button" class="btn btn-ghost btn-sm" data-intro-close>Đóng</button></div></div>';
		document.body.appendChild(modal);
		modal.querySelectorAll('[data-intro-close]').forEach(function (el) {
			el.addEventListener('click', close);
		});
	}
	function close() {
		if (!modal) return;
		modal.hidden = true;
		document.body.style.overflow = '';
	}
	function onKey(e) { if (e.key === 'Escape') close(); }
	function open(title, html) {
		if (!modal) build();
		modal.querySelector('.intro-pop-title').textContent = title;
		modal.querySelector('.intro-pop-body').innerHTML = html;
		modal.hidden = false;
		document.body.style.overflow = 'hidden';
		var card = modal.querySelector('.intro-pop-card');
		if (card) card.focus({ preventScroll: true });
	}
	document.addEventListener('keydown', onKey);
	document.addEventListener('click', function (e) {
		var btn = e.target.closest ? e.target.closest('.intro-toggle') : null;
		if (!btn) return;
		e.preventDefault();
		var box  = document.getElementById(btn.getAttribute('aria-controls'));
		var row  = btn.closest('tr');
		var title;
		if (row) {
			var name = row.querySelector('.row-name');
			title = name ? name.textContent : 'Giới thiệu';
		} else {
			var label = btn.getAttribute('aria-label') || '';
			title = label.replace(/^Giải thích thuật ngữ:\s*/, '') || 'Giải thích';
		}
		open(title, box ? box.innerHTML : '');
	});
})();

/* Anh minh hoa VI TRI dang bai (Hieu 2026-07-18) -> mo POPUP anh, cung 1 kieu voi intro-pop
   nhung modal rieng (.vitri-pop) vi noi dung la anh, khong phai list chu. Noi dung lay tu
   .vitri-detail (render an) cua dong do. */
(function () {
	var modal = null;
	function build() {
		modal = document.createElement('div');
		modal.className = 'vitri-pop';
		modal.hidden = true;
		modal.innerHTML =
			'<div class="vitri-pop-mask" data-vitri-close></div>' +
			'<div class="vitri-pop-card" role="dialog" aria-modal="true" tabindex="-1">' +
			'<button type="button" class="vitri-pop-x" data-vitri-close aria-label="Đóng">&times;</button>' +
			'<h3 class="vitri-pop-title">Ảnh minh hoạ vị trí đăng</h3><div class="vitri-pop-body"></div>' +
			'<div class="vitri-pop-foot"><button type="button" class="btn btn-ghost btn-sm" data-vitri-close>Đóng</button></div></div>';
		document.body.appendChild(modal);
		modal.querySelectorAll('[data-vitri-close]').forEach(function (el) {
			el.addEventListener('click', close);
		});
	}
	function close() {
		if (!modal) return;
		modal.hidden = true;
		document.body.style.overflow = '';
	}
	function onKey(e) { if (e.key === 'Escape') close(); }
	function open(title, html) {
		if (!modal) build();
		modal.querySelector('.vitri-pop-title').textContent = title;
		modal.querySelector('.vitri-pop-body').innerHTML = html;
		modal.hidden = false;
		document.body.style.overflow = 'hidden';
		var card = modal.querySelector('.vitri-pop-card');
		if (card) card.focus({ preventScroll: true });
	}
	document.addEventListener('keydown', onKey);
	document.addEventListener('click', function (e) {
		var btn = e.target.closest ? e.target.closest('.vitri-toggle') : null;
		if (!btn) return;
		e.preventDefault();
		var box  = document.getElementById(btn.getAttribute('aria-controls'));
		var row  = btn.closest('tr');
		var name = row ? row.querySelector('.row-name') : null;
		open(name ? 'Vị trí đăng - ' + name.textContent : 'Ảnh minh hoạ vị trí đăng', box ? box.innerHTML : '');
	});
})();

/* "Dich vu" (item co submenu) = nut TRAI RA, khong dieu huong.
   Desktop nav + drawer mobile: bam item cha -> toggle mo submenu, chan chuyen trang. */
(function () {
	function isParentLink(a) {
		return a && a.parentElement && a.parentElement.classList.contains('menu-item-has-children')
			&& (a.closest('.nav') || a.closest('.mnav-list'));
	}
	document.addEventListener('click', function (e) {
		var a = e.target.closest ? e.target.closest('a') : null;
		if (isParentLink(a)) {
			e.preventDefault();
			var li = a.parentElement;
			var wasOpen = li.classList.contains('dgc-open');
			// desktop: dong cac menu cha khac cho gon
			if (a.closest('.nav')) {
				li.parentElement.querySelectorAll('.menu-item-has-children.dgc-open').forEach(function (o) {
					if (o !== li) o.classList.remove('dgc-open');
				});
			}
			li.classList.toggle('dgc-open', !wasOpen);
			return;
		}
		// bam ra ngoai -> dong dropdown desktop dang mo
		document.querySelectorAll('.nav .menu-item-has-children.dgc-open').forEach(function (o) {
			if (!o.contains(e.target)) o.classList.remove('dgc-open');
		});
	});
})();

/* Bottom sheet "Dich vu" (mobile) - mo/dong tu nut bottom-nav. */
(function () {
	var sheet = document.getElementById('svcSheet');
	if (!sheet) return;
	var ov = document.querySelector('.svc-sheet-ov');
	function setOpen(on) {
		sheet.hidden = !on;
		if (ov) ov.hidden = !on;
		document.body.style.overflow = on ? 'hidden' : '';
		var btn = document.querySelector('[data-svc-sheet]');
		if (btn) btn.setAttribute('aria-expanded', on ? 'true' : 'false');
	}
	document.addEventListener('click', function (e) {
		if (e.target.closest && e.target.closest('[data-svc-sheet]')) { e.preventDefault(); setOpen(sheet.hidden); return; }
		if (e.target.closest && e.target.closest('[data-svc-sheet-close]')) { setOpen(false); }
	});
	document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && !sheet.hidden) setOpen(false); });
})();

/* Bieu do DR trong bai book-bao: chay animation thanh khi cuon toi (nghi mat + interactive). */
(function () {
	var charts = document.querySelectorAll('[data-dr-chart]');
	if (!charts.length) return;
	if (!('IntersectionObserver' in window)) {
		charts.forEach(function (c) { c.classList.add('in-view'); });
		return;
	}
	var io = new IntersectionObserver(function (entries) {
		entries.forEach(function (e) {
			if (e.isIntersecting) { e.target.classList.add('in-view'); io.unobserve(e.target); }
		});
	}, { threshold: 0.35 });
	charts.forEach(function (c) { io.observe(c); });
})();

/* May tinh ngan sach off-page (inc/widgets-blog.php) - gia that tu CPT, format VND. */
(function () {
	document.querySelectorAll('[data-bcalc]').forEach(function (el) {
		var stats;
		try { stats = JSON.parse(el.getAttribute('data-stats')); } catch (e) { return; }
		var svc = el.querySelector('.bcalc-svc'), dr = el.querySelector('.bcalc-dr'),
			qty = el.querySelector('.bcalc-qty'), qtyVal = el.querySelector('.bcalc-qty-val'),
			num = el.querySelector('.bcalc-result-num');
		function fmt(v) {
			if (v >= 1e9) return (v / 1e9).toFixed(1).replace('.', ',') + ' tỷ';
			if (v >= 1e6) return Math.round(v / 1e5) / 10 + ' triệu';
			return Math.round(v / 1e3) + 'k';
		}
		function calc() {
			var g = stats[svc.value]; if (!g) return;
			var s = g.stat[dr.value] || g.stat.all;
			// muc DR khong co du data -> fallback "tat ca" va bao ro
			var fallback = !g.stat[dr.value];
			var n = parseInt(qty.value, 10) || 1;
			qtyVal.textContent = n;
			num.textContent = fmt(s.p25 * n) + ' - ' + fmt(s.p75 * n) + ' đ' + (fallback ? ' (mức DR này chưa đủ dữ liệu, tính theo tất cả)' : '');
		}
		[svc, dr].forEach(function (c) { c.addEventListener('change', calc); });
		qty.addEventListener('input', calc);
		calc();
	});
})();

/* Quiz suc khoe off-page: 6 cau Co/Chua -> cham diem + goi y viec lam truoc tien. */
(function () {
	document.querySelectorAll('[data-oquiz]').forEach(function (el) {
		var qs = el.querySelectorAll('.oquiz-q'), res = el.querySelector('.oquiz-result'),
			urls;
		try { urls = JSON.parse(res.getAttribute('data-urls')); } catch (e) { return; }
		var answers = {};
		function show() {
			if (Object.keys(answers).length < qs.length) return;
			var score = 0;
			for (var k in answers) score += answers[k];
			var html;
			if (score >= 5) {
				html = '<b>' + score + '/6 - Nền tảng off-page tốt.</b> Bước hợp lý tiếp theo là nâng chất nguồn: thêm bài trên báo DR cao qua <a href="' + urls.booking + '">booking báo & PR</a> hoặc <a href="' + urls.textlink + '">textlink</a> trên site mạnh đúng ngành.';
			} else if (score >= 3) {
				html = '<b>' + score + '/6 - Đã có nền, còn khoảng trống.</b> Ưu tiên lấp phần đang thiếu: <a href="' + urls.guest + '">guest post</a> đúng chủ đề để đa dạng nguồn, kèm 1-2 bài PR trên báo để có trích dẫn uy tín. Tham khảo <a href="' + urls.banggia + '">bảng giá</a> để ước tính ngân sách.';
			} else {
				html = '<b>' + score + '/6 - Mới ở điểm xuất phát.</b> Bắt đầu từ móng: dựng <a href="' + urls.entity + '">hồ sơ social entity chuẩn NAP</a> trước, rồi thêm <a href="' + urls.guest + '">guest post</a> và 1 bài PR đầu tiên trên báo phù hợp ngân sách.';
			}
			res.innerHTML = html;
			res.hidden = false;
		}
		qs.forEach(function (q) {
			q.querySelectorAll('button').forEach(function (b) {
				b.addEventListener('click', function () {
					answers[q.getAttribute('data-q')] = parseInt(b.getAttribute('data-v'), 10);
					q.querySelectorAll('button').forEach(function (x) { x.classList.remove('on'); });
					b.classList.add('on');
					show();
				});
			});
		});
	});
})();

/* Agency check: checklist 7 tieu chi cham diem agency booking bao. */
(function () {
	document.querySelectorAll('[data-acheck]').forEach(function (box) {
		var res = box.querySelector('.acheck-result'), urls = {};
		try { urls = JSON.parse(res.getAttribute('data-urls') || '{}'); } catch (e) {}
		function render() {
			var inputs = box.querySelectorAll('.acheck-item input'), n = 0;
			inputs.forEach(function (c) { if (c.checked) n++; });
			if (n === 0) { res.innerHTML = ''; return; }
			var head = '<b>' + n + '/' + inputs.length + ' tiêu chí</b> - ', html;
			if (n <= 3) {
				html = head + 'rủi ro cao. Thiếu quá nhiều điều kiện tối thiểu, nên tìm đơn vị khác trước khi chuyển tiền.';
			} else if (n <= 5) {
				html = head + 'tạm ổn nhưng cần làm rõ các mục chưa tick (đặc biệt hợp đồng, hoá đơn, quy cách bài) trước khi ký.';
			} else {
				html = head + 'đáng tin cậy theo bộ tiêu chí cơ bản. Bước tiếp theo: so giá theo cùng quy cách bài trên <a href="' + (urls.banggia || '#') + '">bảng giá tham chiếu</a>.';
			}
			res.innerHTML = html;
		}
		box.querySelectorAll('.acheck-item input').forEach(function (c) { c.addEventListener('change', render); });
	});
})();

/* Muc luc bai viet (TOC): nut noi theo khi cuon qua hop muc luc dau bai + scroll-spy. */
(function () {
	var inline = document.getElementById('postToc');
	var fab = document.getElementById('tocFab');
	if (!inline || !fab) return;
	var sheet = document.getElementById('tocSheet'), ov = document.getElementById('tocSheetOv'),
		closeBtn = document.getElementById('tocSheetClose');

	function openSheet() {
		sheet.classList.add('is-open'); ov.classList.add('is-open');
		fab.setAttribute('aria-expanded', 'true');
	}
	function closeSheet() {
		sheet.classList.remove('is-open'); ov.classList.remove('is-open');
		fab.setAttribute('aria-expanded', 'false');
	}
	fab.addEventListener('click', openSheet);
	closeBtn.addEventListener('click', closeSheet);
	ov.addEventListener('click', closeSheet);
	sheet.querySelectorAll('[data-toc-link]').forEach(function (a) {
		a.addEventListener('click', closeSheet);
	});

	// Nut noi: dung scroll listener truc tiep (khong qua IntersectionObserver) - chac chan hoat dong
	// voi moi chieu cao hop TOC, kem ca truong hop hop dong lai (details khong con "open").
	var ticking = false;
	function updateFab() {
		var r = inline.getBoundingClientRect();
		fab.classList.toggle('show', r.bottom < 0);
		ticking = false;
	}
	window.addEventListener('scroll', function () {
		if (!ticking) { ticking = true; window.requestAnimationFrame(updateFab); }
	}, { passive: true });
	window.addEventListener('resize', updateFab);
	updateFab();

	if ('IntersectionObserver' in window) {
		var links = document.querySelectorAll('[data-toc-link]');
		var headings = [];
		links.forEach(function (a) {
			var id = a.getAttribute('data-toc-id'), h = document.getElementById(id);
			if (h) headings.push(h);
		});
		function setActive(id) {
			links.forEach(function (a) {
				a.classList.toggle('is-active', a.getAttribute('data-toc-id') === id);
			});
		}
		if (headings.length) {
			var spy = new IntersectionObserver(function (entries) {
				entries.forEach(function (e) {
					if (e.isIntersecting) setActive(e.target.id);
				});
			}, { rootMargin: '-15% 0px -70% 0px', threshold: 0 });
			headings.forEach(function (h) { spy.observe(h); });
		}
	}
})();
