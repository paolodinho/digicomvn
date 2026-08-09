/**
 * Bang gia dang bang thuong (khong con cuon ao trong khung cao co dinh) + PHAN TRANG that
 * (Hieu 2026-08-09: "ko con co dinh trong 1 khung nua ma tran ra, ko auto load nua ma phan
 * trang"). Thay the ban virtual-scroll 2026-08-01 (grid-scroll cao 560px, cuon noi bo, ve
 * ~20-30 dong dang trong khung nhin) - ban do gay 2 van de: (1) bi "nhot" trong 1 khung cao
 * co dinh thay vi troi tu nhien theo trang, (2) cot gia dang range (vd "3.350.000d - 4.680.000d")
 * bat buoc 1 dong khong wrap -> vuot rong container tren mobile (Hieu chup man hinh 2026-08-09).
 *
 * Ban moi: chi ve dung 1 TRANG (~20 dong) vao DOM tai 1 thoi diem (van nhe nhu ban cu, khong
 * nhet ca nghin dong), nhung la <div> troi binh thuong (khong overflow:auto/height co dinh) +
 * co nut chuyen trang o duoi bang. Gia range duoc phep xuong dong (khong ep 1 dong nua).
 */
(function () {
	'use strict';
	if (!window.DGC_GRID) return; // trang khong dung luoi nay - script khong duoc enqueue nen khong toi day, phong hu

	var PAGE_SIZE = 20; // so dong/trang

	function fmtVnd(n) { return Math.round(n || 0).toLocaleString('vi-VN'); }

	function drColor(dr) {
		dr = dr || 0;
		if (dr >= 70) return 'var(--dr-hi)';
		if (dr >= 40) return 'var(--dr-mid)';
		if (dr >= 25) return 'var(--dr-lo)';
		return 'var(--dr-none)';
	}

	function initial(name) {
		var s = (name || '').trim();
		return s ? s.charAt(0).toUpperCase() : '?';
	}

	function logoColor(name) {
		var s = name || '', h = 0;
		for (var i = 0; i < s.length; i++) h = (h * 31 + s.charCodeAt(i)) % 360;
		return 'hsl(' + h + ',48%,42%)';
	}

	function faviconUrl(url, name) {
		var domain = '';
		try {
			if (url) domain = new URL(url).hostname.replace(/^www\./, '');
		} catch (err) { /* url khong hop le - bo qua */ }
		if (!domain && /^[a-z0-9-]+(\.[a-z0-9-]+)+$/i.test((name || '').trim())) domain = name.trim();
		return domain ? ('https://www.google.com/s2/favicons?domain=' + encodeURIComponent(domain) + '&sz=64') : '';
	}

	function esc(s) {
		return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
			return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
		});
	}

	// "Báo Thanh Niên" / "thanh niên" / "thanhnien.vn" phai ra CUNG ket qua - dung quy tac
	// giong PHP dgc_search_key() / ban cu trong main.js (Hieu 2026-07-14).
	function nenKhoa(s) {
		return (s || '').normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/\u0111/g, 'd')
			.toLowerCase()
			.replace(/\.(com\.vn|com|vn|net|org|info|edu\.vn|gov\.vn|asia|tv)\b/g, ' ')
			.replace(/[^a-z0-9]+/g, '')
			.replace(/^bao/, '');
	}

	function initGrid(container) {
		if (container.dataset.gridInit === '1') return;
		container.dataset.gridInit = '1';

		var panel = container.closest('.tab-panel') || container.parentNode;
		var dataScript = panel.querySelector('.price-grid-data');
		var DATA = [];
		try { DATA = JSON.parse(dataScript ? dataScript.textContent : '[]') || []; } catch (err) { DATA = []; }
		if (!DATA.length) return; // khong co du lieu - PHP da hien "Dang cap nhat du lieu"

		// Chuan hoa 1 lan: chuoi tim kiem (co dau + nen), de moi lan loc khong phai tinh lai.
		DATA.forEach(function (d) {
			d._nameLc = (d.name || '').toLowerCase();
			d._key2   = nenKhoa(d.name || '');
		});

		var nhom     = container.getAttribute('data-nhom') || '';
		var ctx      = container.getAttribute('data-ctx') || '';
		var colName  = container.getAttribute('data-col-name') || 'Tên báo / site';
		var isGoi    = container.getAttribute('data-is-goi') === '1';

		var searchInput = panel.querySelector('.tab-search-input');
		var sideItems   = panel.querySelectorAll('.side-nav-item');
		var facetSels   = panel.querySelectorAll('.filter-facet');
		var chipsBox    = panel.querySelector('.filter-chips');
		var clearBtn    = panel.querySelector('.filter-clear');
		var sortBtns    = panel.querySelectorAll('.sort-btn');
		var shownEl     = panel.querySelector('.tab-count-shown');
		var totalEl     = panel.querySelector('.tab-count-total');

		var state = { q: '', qKey: '', nganh: '', facets: {}, sortKey: 'dr', sortDir: -1, openIds: {}, page: 1 };
		var detailCache = {}; // key -> 'loading' | htmlString

		function facetOk(d) {
			for (var key in state.facets) {
				var f = state.facets[key];
				var raw = key === 'price' ? d.priceMin
					: (key === 'link' || key === 'vitri') ? (d[key] || '')
					: (d[key] || 0);
				if (f.mode === 'min') {
					if ((parseFloat(raw) || 0) < parseFloat(f.val)) return false;
				} else if (f.mode === 'max') {
					if ((parseFloat(raw) || 0) > parseFloat(f.val)) return false;
				} else if (f.mode === 'range') {
					var b = String(f.val).split('-'), rv = parseFloat(raw) || 0;
					if (!(rv >= parseFloat(b[0]) && rv < parseFloat(b[1]))) return false;
				} else if (String(raw) !== f.val) {
					return false;
				}
			}
			return true;
		}

		function rowOk(d) {
			var okQ = !state.q || d._nameLc.indexOf(state.q) !== -1 || (state.qKey && d._key2.indexOf(state.qKey) !== -1);
			var okN = !state.nganh || (d.nganh || []).indexOf(state.nganh) !== -1;
			return okQ && okN && facetOk(d);
		}

		function filteredSorted() {
			var list = DATA.filter(rowOk);
			list.sort(function (a, b) {
				var dir = state.sortDir;
				if (state.sortKey === 'price') return ((a.priceMin || 0) - (b.priceMin || 0)) * dir;
				if (state.sortKey === 'dr') return ((a.dr || 0) - (b.dr || 0)) * dir;
				return 0;
			});
			return list;
		}

		function fetchDetail(d) {
			if (detailCache[d.key]) return; // dang tai hoac da co roi
			detailCache[d.key] = 'loading';
			var ids = d.count > 1 ? d.childIds : [d.id];
			var fd = new FormData();
			fd.append('action', 'dgc_grid_detail');
			fd.append('nonce', DGC_GRID.nonce);
			fd.append('nhom', nhom);
			fd.append('ids', ids.join(','));
			fd.append('ctx', ctx);
			fd.append('col_name', colName);
			fetch(DGC_GRID.url, { method: 'POST', credentials: 'same-origin', body: fd })
				.then(function (r) { return r.json(); })
				.then(function (res) {
					detailCache[d.key] = (res && res.success && res.data && res.data.html) ? res.data.html : '<p class="gd-err">Không tải được chi tiết, thử lại sau.</p>';
					render();
				})
				.catch(function () {
					detailCache[d.key] = '<p class="gd-err">Không tải được chi tiết, thử lại sau.</p>';
					render();
				});
		}

		/* ---------- DOM: bang troi binh thuong (khong cuon noi bo) + thanh phan trang ---------- */
		var wrap = document.createElement('div');
		wrap.className = 'grid-wrap';
		var head = document.createElement('div');
		head.className = 'grid-head';
		head.innerHTML =
			'<div class="gh-name">' + esc(colName) + '</div>' +
			(isGoi ? '' : '<div class="gh-dr">DR</div>') +
			'<div class="gh-price">Giá</div>';
		var body = document.createElement('div');
		body.className = 'grid-body';
		var pager = document.createElement('div');
		pager.className = 'grid-pager';
		wrap.appendChild(head);
		wrap.appendChild(body);
		wrap.appendChild(pager);
		container.innerHTML = '';
		container.appendChild(wrap);
		container.classList.toggle('price-grid-goi', isGoi);

		function rowHtml(d) {
			var picked = d.count === 1 && window.dgcCartIsPicked && window.dgcCartIsPicked(d.key);
			var open = !!state.openIds[d.key];
			var fav = faviconUrl(d.url, d.name);
			var rangeTxt = (d.priceMin === d.priceMax)
				? fmtVnd(d.priceMin) + 'đ'
				: fmtVnd(d.priceMin) + 'đ<span class="sep">-</span>' + fmtVnd(d.priceMax) + 'đ';
			return '' +
				'<div class="row' + (open ? ' is-open' : '') + '" data-key="' + esc(d.key) + '">' +
					'<div class="r-name grid-col-name">' +
						'<span class="r-toggle" data-act="toggle" data-key="' + esc(d.key) + '"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="m9 6 6 6-6 6"/></svg></span>' +
						(fav ? '<img class="r-logo" src="' + esc(fav) + '" alt="" loading="lazy" onerror="this.outerHTML=\'<span class=&quot;r-logo r-logo-fb&quot; style=&quot;background:' + logoColor(d.name) + '&quot;>' + esc(initial(d.name)) + '</span>\'">' : '<span class="r-logo r-logo-fb" style="background:' + logoColor(d.name) + '">' + esc(initial(d.name)) + '</span>') +
						'<span class="r-name-txt">' + esc(d.name) + '</span>' +
						(d.count > 1 ? '<span class="r-count">' + d.count + ' vị trí</span>' : '') +
						(d.noiBat ? '<span class="r-hot">Phổ biến</span>' : '') +
					'</div>' +
					(isGoi ? '' : '<div class="r-dr">' + (d.dr ? '<span class="dr-chip" style="background:' + drColor(d.dr) + '">' + d.dr + '</span>' : '') + '</div>') +
					'<div class="r-price">' + rangeTxt +
						(d.count === 1 ? '<button type="button" class="grid-pick' + (picked ? ' is-picked' : '') + '" data-key="' + esc(d.key) + '" data-price="' + esc(d.price) + '" data-mkgain="' + esc(d.mkgain) + '" data-label="' + esc(d.label) + '" title="Chọn ' + esc(colName.toLowerCase()) + ' này"><span class="pick-add">+</span><span class="pick-on">✓</span></button>' : '') +
					'</div>' +
				'</div>';
		}

		function loadingHtml() {
			return '<div class="row row-loading">Đang tải chi tiết...</div>';
		}

		function detailHtml(d, html) {
			return '<div class="grid-detail-wrap"><div class="grid-detail">' + html + '</div></div>';
		}

		function pageWindow(cur, total) {
			// Toi da 5 so trang hien thi, con lai rut gon bang "…" - luon giu trang dau/cuoi.
			if (total <= 7) {
				var all = []; for (var i = 1; i <= total; i++) all.push(i); return all;
			}
			var out = [1];
			var lo = Math.max(2, cur - 1), hi = Math.min(total - 1, cur + 1);
			if (lo > 2) out.push('...');
			for (var j = lo; j <= hi; j++) out.push(j);
			if (hi < total - 1) out.push('...');
			out.push(total);
			return out;
		}

		function renderPager(totalPages) {
			if (totalPages <= 1) { pager.innerHTML = ''; pager.hidden = true; return; }
			pager.hidden = false;
			var p = state.page;
			var btns = '<button type="button" class="pg-btn pg-nav" data-pg="' + (p - 1) + '"' + (p <= 1 ? ' disabled' : '') + ' aria-label="Trang trước">‹</button>';
			pageWindow(p, totalPages).forEach(function (n) {
				if (n === '...') btns += '<span class="pg-dots">…</span>';
				else btns += '<button type="button" class="pg-btn pg-num' + (n === p ? ' active' : '') + '" data-pg="' + n + '">' + n + '</button>';
			});
			btns += '<button type="button" class="pg-btn pg-nav" data-pg="' + (p + 1) + '"' + (p >= totalPages ? ' disabled' : '') + ' aria-label="Trang sau">›</button>';
			pager.innerHTML = '<div class="pg-info">Trang ' + p + '/' + totalPages + '</div><div class="pg-btns">' + btns + '</div>';
		}

		function render(resetPage) {
			var list = filteredSorted();
			var total = list.length;
			var totalPages = Math.max(1, Math.ceil(total / PAGE_SIZE));
			if (resetPage) state.page = 1;
			if (state.page > totalPages) state.page = totalPages;
			if (state.page < 1) state.page = 1;

			var startIdx = (state.page - 1) * PAGE_SIZE;
			var pageItems = list.slice(startIdx, startIdx + PAGE_SIZE);

			if (!pageItems.length) {
				body.innerHTML = '<div class="price-empty-row">Không tìm thấy kết quả phù hợp.</div>';
			} else {
				body.innerHTML = pageItems.map(function (d) {
					var html = rowHtml(d);
					if (state.openIds[d.key]) {
						var cached = detailCache[d.key];
						if (cached === 'loading') html += loadingHtml();
						else if (typeof cached === 'string') html += detailHtml(d, cached);
					}
					return html;
				}).join('');
			}

			renderPager(totalPages);
			if (shownEl) shownEl.textContent = total;
			if (totalEl) totalEl.textContent = DATA.length;
		}

		pager.addEventListener('click', function (e) {
			var b = e.target.closest('[data-pg]');
			if (!b || b.disabled) return;
			var n = parseInt(b.getAttribute('data-pg'), 10);
			if (!n || n < 1) return;
			state.page = n;
			render();
			wrap.scrollIntoView({ behavior: 'smooth', block: 'start' });
		});

		body.addEventListener('click', function (e) {
			var t = e.target.closest('[data-act="toggle"]');
			if (!t) return;
			var key = t.getAttribute('data-key');
			state.openIds[key] = !state.openIds[key];
			if (state.openIds[key]) {
				var d = DATA.filter(function (x) { return x.key === key; })[0];
				if (d) fetchDetail(d);
			}
			render();
		});

		/* ---------- tim kiem / loc / sap xep - noi vao UI da co san (sidebar/facet/toolbar) ---------- */
		if (searchInput) {
			var t;
			searchInput.addEventListener('input', function () {
				clearTimeout(t);
				t = setTimeout(function () {
					state.q = searchInput.value.trim().toLowerCase();
					state.qKey = nenKhoa(searchInput.value.trim());
					render(true);
				}, 120);
			});
		}

		sideItems.forEach(function (btn) {
			btn.addEventListener('click', function () {
				state.nganh = btn.getAttribute('data-nganh-val') || '';
				sideItems.forEach(function (b) { b.classList.toggle('active', b === btn); });
				render(true);
			});
		});

		function selLabel(sel) {
			var o = sel.options[sel.selectedIndex];
			return o ? o.textContent.replace(/\s*\(\d+\)\s*$/, '') : '';
		}
		function syncChips() {
			if (!chipsBox) return;
			var active = [];
			facetSels.forEach(function (s) { if (s.value) active.push({ sel: s, text: selLabel(s) }); });
			chipsBox.innerHTML = '';
			active.forEach(function (a) {
				var chip = document.createElement('button');
				chip.type = 'button';
				chip.className = 'filter-chip';
				chip.innerHTML = a.text + '<span aria-hidden="true">×</span>';
				chip.addEventListener('click', function () { a.sel.value = ''; a.sel.dispatchEvent(new Event('change')); });
				chipsBox.appendChild(chip);
			});
			chipsBox.hidden = !active.length;
			if (clearBtn) clearBtn.hidden = active.length < 2;
		}
		facetSels.forEach(function (sel) {
			sel.addEventListener('change', function () {
				var key = sel.getAttribute('data-facet');
				var opt = sel.options[sel.selectedIndex];
				if (!sel.value) delete state.facets[key];
				else state.facets[key] = { val: sel.value, mode: opt.getAttribute('data-mode') || 'eq' };
				render(true);
				syncChips();
			});
		});
		if (clearBtn) {
			clearBtn.addEventListener('click', function () {
				sideItems.forEach(function (b) { b.classList.toggle('active', !b.getAttribute('data-nganh-val')); });
				state.nganh = '';
				facetSels.forEach(function (s) { s.value = ''; });
				state.facets = {};
				render(true);
				syncChips();
			});
		}
		sortBtns.forEach(function (btn) {
			btn.addEventListener('click', function () {
				state.sortKey = btn.getAttribute('data-key') === 'dr' ? 'dr' : 'price';
				state.sortDir = btn.getAttribute('data-dir') === 'asc' ? 1 : -1;
				sortBtns.forEach(function (b) { b.classList.toggle('active', b === btn); });
				render(true);
			});
		});

		render();
	}

	function boot() {
		document.querySelectorAll('[data-price-grid]').forEach(initGrid);
	}
	if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot);
	else boot();

	window.dgcInitPriceGrid = initGrid;
})();
