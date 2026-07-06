(function ($) {
	'use strict';

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
