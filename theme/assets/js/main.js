/* Liquid Landing — progressive enhancement only; the page works without this file. */
(function () {
	'use strict';

	var doc = document;

	var header = doc.querySelector('.site-header');

	/* Intro: the CSS builds the mark (bloom, split, stretch, draw); this flies it into the header
	   and tears the curtain down. Runs once per session (flag set in <head>); any input skips it. */
	var intro = doc.getElementById('intro');
	if (intro && doc.documentElement.classList.contains('intro-on')) {
		try { sessionStorage.setItem('ll_intro', '1'); } catch (e) {}
		var mark = intro.querySelector('.intro__mark');
		var target = doc.querySelector('.brand__mark');
		var finished = false;
		var finish = function (skip) {
			if (finished) { return; }
			finished = true;
			var done = function () {
				doc.documentElement.classList.remove('intro-on');
				doc.documentElement.classList.add('intro-off');
				intro.remove();
			};
			if (skip || !target) {
				intro.classList.add('intro--done');
				setTimeout(done, 260);
				return;
			}
			var from = mark.getBoundingClientRect();
			var to = target.getBoundingClientRect();
			var s = to.width / from.width;
			mark.style.setProperty('--intro-x', (to.left - from.left) + 'px');
			mark.style.setProperty('--intro-y', (to.top - from.top) + 'px');
			mark.style.setProperty('--intro-s', s.toFixed(4));
			intro.classList.add('intro--fly');
			setTimeout(function () {
				intro.classList.add('intro--done');
				setTimeout(done, 80);
			}, 380);
		};
		var skipHandler = function () { finish(true); };
		['pointerdown', 'keydown', 'wheel', 'touchstart'].forEach(function (ev) {
			window.addEventListener(ev, skipHandler, { once: true, passive: true });
		});
		/* the CSS choreography ends at 1.7 s */
		setTimeout(function () { finish(false); }, 1750);
	}

	/* Header: hairline once scrolled (L-13) */
	if (header) {
		var onScroll = function () {
			if (window.scrollY > 4) { header.setAttribute('data-scrolled', ''); }
			else { header.removeAttribute('data-scrolled'); }
		};
		onScroll();
		window.addEventListener('scroll', onScroll, { passive: true });
	}

	/* Phone menu: button toggles the nav; Esc and link clicks close it (N-10, I-03) */
	var toggle = doc.querySelector('.menu-toggle');
	var nav = doc.getElementById('site-nav');
	if (toggle && nav) {
		var openLabel = toggle.textContent.trim();
		var closeLabel = toggle.getAttribute('data-label-close') || openLabel;
		var setOpen = function (open) {
			toggle.setAttribute('aria-expanded', String(open));
			toggle.textContent = open ? closeLabel : openLabel;
			doc.documentElement.classList.toggle('nav-open', open);
			if (open) {
				nav.setAttribute('data-open', '');
				var first = nav.querySelector('a');
				if (first) { first.focus({ preventScroll: true }); }
			} else {
				nav.removeAttribute('data-open');
			}
		};
		toggle.addEventListener('click', function () {
			setOpen(toggle.getAttribute('aria-expanded') !== 'true');
		});
		nav.addEventListener('click', function (e) {
			if (e.target.closest('a')) { setOpen(false); }
		});
		doc.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
				setOpen(false);
				toggle.focus();
			}
		});
	}

	/* Header height feeds the sticky offsets */
	var setHeaderHeight = function () {
		if (header) { doc.documentElement.style.setProperty('--header-h', header.offsetHeight + 'px'); }
	};
	setHeaderHeight();
	window.addEventListener('resize', setHeaderHeight);

	/* Vision stage: the section pins while the track scrolls by; progress picks the active pillar.
	   Native scrolling is untouched; the CSS falls back to the stacked layout without .js or on short screens. */
	var track = doc.querySelector('.vision__track');
	var stage = doc.querySelector('.vision__stage');
	if (track && stage) {
		var pillars = stage.querySelectorAll('.pillar');
		var steps = stage.querySelectorAll('.vision__steps li');
		var current = 0;
		var ticking = false;
		var updateStage = function () {
			ticking = false;
			var travel = track.offsetHeight - stage.offsetHeight;
			if (travel <= 0) { return; }
			var top = track.getBoundingClientRect().top - (header ? header.offsetHeight : 0);
			var progress = Math.min(1, Math.max(0, -top / travel));
			stage.style.setProperty('--vision-progress', progress.toFixed(4));
			var next = Math.min(pillars.length - 1, Math.floor(progress * pillars.length));
			if (next !== current) {
				pillars[current].removeAttribute('data-active');
				if (steps[current]) { steps[current].removeAttribute('data-active'); }
				pillars[next].setAttribute('data-active', '');
				if (steps[next]) { steps[next].setAttribute('data-active', ''); }
				current = next;
			}
		};
		var requestStage = function () {
			if (!ticking) { ticking = true; window.requestAnimationFrame(updateStage); }
		};
		updateStage();
		window.addEventListener('scroll', requestStage, { passive: true });
		window.addEventListener('resize', requestStage);
	}

	/* Portfolio: reveal the rest of the grid, then the button retires (K-34) */
	var more = doc.getElementById('work-more');
	var grid = doc.getElementById('work-grid');
	if (more && grid) {
		var hiddenCards = grid.querySelectorAll('[data-more]');
		if (!hiddenCards.length) { more.parentElement.hidden = true; }
		more.addEventListener('click', function () {
			var first = hiddenCards[0];
			hiddenCards.forEach(function (li) { li.hidden = false; });
			grid.querySelectorAll('.work-card--tablet').forEach(function (li) { li.classList.add('is-shown'); });
			more.setAttribute('aria-expanded', 'true');
			more.parentElement.hidden = true;
			if (first) {
				var focusable = first.querySelector('a');
				(focusable || first).setAttribute('tabindex', '-1');
				(focusable || first).focus({ preventScroll: true });
			}
		});
	}

	/* Contact form: validate on blur, live once in error, all on submit (F-12); send via fetch (F-03) */
	var form = doc.getElementById('contact-form');
	if (form && window.fetch) {
		var status = form.querySelector('.contact-form__status');
		var submit = form.querySelector('button[type="submit"]');
		var label = submit.querySelector('.btn__label');
		var idleLabel = label.textContent;
		var i18n = (window.LL && LL.i18n) || {};
		var fields = ['name', 'email', 'message'].map(function (n) { return form.elements[n]; });

		var errorFor = function (field) {
			var msgEl = doc.getElementById(field.id + '-err');
			var v = field.value.trim();
			var bad = field.required && !v;
			if (!bad && field.type === 'email') { bad = !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v); }
			if (!bad && field.minLength > 0) { bad = v.length < field.minLength; }
			return bad ? (msgEl ? msgEl.dataset.msg : '') : '';
		};
		var show = function (field, msg) {
			var msgEl = doc.getElementById(field.id + '-err');
			if (msgEl) { msgEl.textContent = msg; }
			if (msg) { field.setAttribute('aria-invalid', 'true'); }
			else { field.removeAttribute('aria-invalid'); }
		};
		var setStatus = function (state, text) {
			status.dataset.state = state;
			status.textContent = text;
		};

		fields.forEach(function (f) {
			f.addEventListener('blur', function () { show(f, errorFor(f)); });
			f.addEventListener('input', function () {
				if (f.getAttribute('aria-invalid') === 'true') { show(f, errorFor(f)); }
			});
		});

		form.addEventListener('submit', function (e) {
			e.preventDefault();
			var firstBad = null;
			fields.forEach(function (f) {
				var msg = errorFor(f);
				show(f, msg);
				if (msg && !firstBad) { firstBad = f; }
			});
			if (firstBad) { firstBad.focus(); return; }
			if (submit.getAttribute('aria-busy') === 'true') { return; }

			submit.setAttribute('aria-busy', 'true');
			label.textContent = i18n.sending || idleLabel;
			setStatus('', '');

			fetch(form.action, {
				method: 'POST',
				body: new FormData(form),
				headers: { 'Accept': 'application/json' },
				credentials: 'same-origin'
			}).then(function (r) { return r.json().then(function (j) { return { ok: r.ok, body: j }; }); })
			.then(function (res) {
				var body = res.body || {};
				if (res.ok && body.ok) {
					form.reset();
					setStatus('sent', body.message || i18n.sent || '');
				} else if (body.field && form.elements[body.field]) {
					show(form.elements[body.field], body.message || '');
					form.elements[body.field].focus();
				} else {
					setStatus('error', body.message || i18n.error || '');
				}
			})
			.catch(function () { setStatus('error', i18n.error || ''); })
			.finally(function () {
				submit.removeAttribute('aria-busy');
				label.textContent = idleLabel;
			});
		});
	}
})();
