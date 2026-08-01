/**
 * Luoi bang gia "kieu Excel" (cuon ao) cho /bang-gia/ (Hieu 2026-08-01: du lieu qua lon hien
 * thi kieu bang day du bi nang may, khong xem duoc tong quan). Chi ve ~20-30 dong dang trong
 * khung nhin thay vi nhet ca tram/nghin dong vao DOM - xem mockup da duyet + inc/price-grid.php
 * (nguon du lieu JSON + AJAX chi tiet).
 */
(function () {
	'use strict';
	if (!window.DGC_GRID) return; // trang khong phai /bang-gia/ - script khong duoc enqueue nen khong toi day, phong hu

	var ROW_H    = 46;   // 1 dong bao/site thu gon
	var DETAIL_H = 300;  // panel "mo rong" - cao co dinh, cuon rieng ben trong neu noi dung dai
	var LOAD_H   = 46;   // dong "Dang tai..."
	var BUFFER   = 8;    // so dong du them ngoai khung nhin (2 phia) de cuon muot, khong giat trang

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

		var state = { q: '', qKey: '', nganh: '', facets: {}, sortKey: 'dr', sortDir: -1, openIds: {} };
		var detailCache = {}; // key -> 'loading' | htmlString

		function facetOk(d) {
			for (var key in state.facets) {
				var f = state.facets[key];
				// Bao co nhieu vi tri (d.count>1) khong co "d.price" rieng (moi vi tri 1 gia
				// khac nhau) - dung GIA THAP NHAT trong nhom (d.priceMin) lam dai dien, dung
				// y nhu ban bang cu (data-price="$lo" tren dong dau, xem dgc_gia_group_head_html()
				// trong inc/price-grid.php) - "nhom nay CO IT NHAT 1 vi tri khop khoang gia".
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

		/* ---------- flatten (loc + sap xep + chen panel chi tiet dang mo) ---------- */
		function buildFlat() {
			var list = DATA.filter(rowOk);
			list.sort(function (a, b) {
				var dir = state.sortDir;
				if (state.sortKey === 'price') return ((a.priceMin || 0) - (b.priceMin || 0)) * dir;
				if (state.sortKey === 'dr') return ((a.dr || 0) - (b.dr || 0)) * dir;
				return 0;
			});
			var flat = [];
			list.forEach(function (d) {
				flat.push({ type: 'row', d: d });
				if (state.openIds[d.key]) {
					var cached = detailCache[d.key];
					if (cached === 'loading') flat.push({ type: 'loading', d: d });
					else if (typeof cached === 'string') flat.push({ type: 'detail', d: d, html: cached });
				}
			});
			return { flat: flat, total: list.length };
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

		/* ---------- virtual scroll ---------- */
		var scroller = document.createElement('div');
		scroller.className = 'grid-scroll';
		var head = document.createElement('div');
		head.className = 'grid-head';
		head.innerHTML =
			'<div class="gh-name">' + esc(colName) + '</div>' +
			(isGoi ? '' : '<div class="gh-dr">DR</div>') +
			'<div class="gh-price">Giá</div>';
		var viewport = document.createElement('div');
		viewport.className = 'viewport';
		var win = document.createElement('div');
		win.className = 'rows-window';
		viewport.appendChild(win);
		scroller.appendChild(head);
		scroller.appendChild(viewport);
		container.innerHTML = '';
		container.appendChild(scroller);
		container.classList.toggle('price-grid-goi', isGoi);

		var layout = { offsets: [], total: 0 };

		function computeLayout(flat) {
			var offsets = [], y = 0;
			flat.forEach(function (item) {
				var h = item.type === 'detail' ? DETAIL_H : (item.type === 'loading' ? LOAD_H : ROW_H);
				offsets.push({ top: y, h: h, item: item });
				y += h;
			});
			return { offsets: offsets, total: y };
		}

		function rowHtml(d) {
			var picked = d.count === 1 && window.dgcCartIsPicked && window.dgcCartIsPicked(d.key);
			var open = !!state.openIds[d.key];
			var fav = faviconUrl(d.url, d.name);
			var rangeTxt = (d.priceMin === d.priceMax)
				? fmtVnd(d.priceMin) + 'đ'
				: fmtVnd(d.priceMin) + 'đ<span class="sep">-</span>' + fmtVnd(d.priceMax) + 'đ';
			return '' +
				'<div class="row' + (open ? ' is-open' : '') + '" data-key="' + esc(d.key) + '" style="height:' + ROW_H + 'px">' +
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
			return '<div class="row row-loading" style="height:' + LOAD_H + 'px"><div class="r-name grid-col-name">Đang tải chi tiết...</div></div>';
		}

		function detailHtml(d, html) {
			return '<div class="grid-detail-wrap" style="height:' + DETAIL_H + 'px"><div class="grid-detail">' + html + '</div></div>';
		}

		function paintItem(it) {
			if (it.type === 'row') return rowHtml(it.d);
			if (it.type === 'loading') return loadingHtml();
			return detailHtml(it.d, it.html);
		}

		function findStart(offsets, y) {
			var lo = 0, hi = offsets.length - 1, ans = 0;
			while (lo <= hi) {
				var mid = (lo + hi) >> 1;
				if (offsets[mid].top + offsets[mid].h >= y) { ans = mid; hi = mid - 1; } else lo = mid + 1;
			}
			return ans;
		}

		function paint() {
			var scrollTop = scroller.scrollTop;
			var viewH = scroller.clientHeight || 560;
			var startY = Math.max(0, scrollTop - BUFFER * ROW_H);
			var endY   = scrollTop + viewH + BUFFER * ROW_H;

			var startIdx = layout.offsets.length ? findStart(layout.offsets, startY) : 0;
			var endIdx = startIdx;
			while (endIdx < layout.offsets.length && layout.offsets[endIdx].top < endY) endIdx++;

			var visible = layout.offsets.slice(startIdx, endIdx);
			var top = visible.length ? visible[0].top : 0;
			win.style.transform = 'translateY(' + top + 'px)';
			win.innerHTML = visible.map(function (o) { return paintItem(o.item); }).join('');
		}

		function render(resetScroll) {
			var res = buildFlat();
			layout = computeLayout(res.flat);
			viewport.style.height = layout.total + 'px';
			// Doi bo loc/tim kiem/sap xep -> ve lai tu dau danh sach, tranh truong hop dang cuon
			// sau (vd 3000px) roi loc con it dong hon -> khung nhin "treo" ngoai vung co du lieu,
			// tuong nhu bang trong (Hieu se gap neu khong xu ly, phat hien khi QA tim kiem).
			if (resetScroll) scroller.scrollTop = 0;
			// Phong khi danh sach vua ngan lai sau khi mo/dong 1 panel chi tiet (khong chu dich
			// reset) ma scroll dang o qua vi tri hop le - keo ve diem hop le gan nhat.
			var maxScroll = Math.max(0, layout.total - (scroller.clientHeight || 560));
			if (scroller.scrollTop > maxScroll) scroller.scrollTop = maxScroll;
			paint();
			if (shownEl) shownEl.textContent = res.total;
			if (totalEl) totalEl.textContent = DATA.length;
		}

		var paintTicking = false;
		scroller.addEventListener('scroll', function () {
			if (paintTicking) return;
			paintTicking = true;
			requestAnimationFrame(function () { paint(); paintTicking = false; });
		});

		win.addEventListener('click', function (e) {
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
