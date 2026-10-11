/*!
 * Reinforce Lab scroll motion (D-163). Needs GSAP + ScrollTrigger (loaded before this file, all deferred).
 * Phase 1 (D-163): three moments on the home page.
 *   1. How it works: the rail draws itself with scroll and each stage lights up as the line reaches it.
 *   2. Search Authority OS: the section holds for a moment (desktop) while the five stages light up in turn.
 *   3. Packages: the ladder steps rise one after another and the rail fills.
 * Phase 2 (D-164): section headings reveal line by line (SplitText, undone afterwards so the heading HTML is
 * exactly as served), services and industries rows fade up in turn, a thin red reading-progress bar, and the
 * closing call-to-action glows as it comes into view. (The slimmer header is sitewide, in core/reinforce-header.php.)
 * Phase 3 (D-165): outcome statements rise in turn over the 3D signal field (core/reinforce-signal.js); award
 * badges and testimonial cards rise with a slight 3D turn; the HackerNoon trophy draws itself and its results
 * follow; testimonial quote marks drop in; cards tilt toward the pointer with a soft sheen (desktop, fine pointer).
 * Rules: nothing is hidden before this script runs, the hero is never touched, only transform/opacity animate,
 * and visitors with prefers-reduced-motion get no motion at all (gsap.matchMedia reverts everything).
 */
(function () {
  'use strict';
  if (!window.gsap || !window.ScrollTrigger) return;
  var gsap = window.gsap, ScrollTrigger = window.ScrollTrigger;
  var SplitText = window.SplitText;
  gsap.registerPlugin(ScrollTrigger);
  if (SplitText) gsap.registerPlugin(SplitText);

  var EASE = 'power3.out';
  var root = document.documentElement;

  /* Adds a decorative element once (rail fills); harmless if motion is later switched off. */
  function ensure(parent, cls, tag) {
    var el = parent.querySelector(':scope > .' + cls);
    if (!el) { el = document.createElement(tag || 'span'); el.className = cls; el.setAttribute('aria-hidden', 'true'); parent.appendChild(el); }
    return el;
  }

  /* 1. How it works: rail scrubbed to scroll, stages switch on as the fill passes their node. */
  function timeline(wide) {
    var ol = document.querySelector('.rl-home .tline');
    if (!ol) return;
    var fill = ensure(ol, 'tl-fill');
    var items = [].slice.call(ol.querySelectorAll(':scope > li'));
    var at = function (li) { return wide ? li.offsetLeft / ol.offsetWidth : li.offsetTop / ol.offsetHeight; };
    var marks = items.map(at);

    gsap.timeline({
      scrollTrigger: {
        trigger: ol, start: 'top 75%', end: wide ? 'bottom 55%' : 'bottom 65%', scrub: 0.8,
        onRefresh: function () { marks = items.map(at); },
        onUpdate: function (self) { items.forEach(function (li, i) { li.classList.toggle('on', self.progress > 0.01 && self.progress >= marks[i]); }); }
      }
    }).fromTo(fill, wide ? { scaleX: 0 } : { scaleY: 0 }, wide ? { scaleX: 1, ease: 'none' } : { scaleY: 1, ease: 'none' });

    /* titles and text of each stage rise in once, one after another */
    gsap.from(items.map(function (li) { return li.querySelectorAll('h3, p'); }), {
      y: 28, opacity: 0, duration: 1, ease: EASE, stagger: 0.12,
      scrollTrigger: { trigger: ol, start: 'top 80%', once: true }
    });
  }

  /* 2. Search Authority OS: pinned on desktop, stages light up cumulatively with a progress bar. */
  function osEngine(wide) {
    var box = document.querySelector('.rl-home .flagship');
    var list = box && box.querySelector('.os-steps');
    if (!list) return;
    var lis = [].slice.call(list.querySelectorAll('li'));
    var bar = box.querySelector('.os-bar i');
    var section = box.closest('section') || box;

    gsap.timeline({
      scrollTrigger: {
        trigger: wide ? section : list,
        start: wide ? 'center center' : 'top 75%',
        end: wide ? '+=' + Math.round(window.innerHeight * 0.9) : 'bottom 35%',
        scrub: 0.6, pin: wide ? section : false, anticipatePin: 1,
        onUpdate: function (self) {
          var n = Math.min(lis.length - 1, Math.floor(self.progress * lis.length));
          lis.forEach(function (li, i) { li.classList.toggle('on', self.progress > 0.02 && i <= n); });
        }
      }
    }).fromTo(bar, { scaleX: 0 }, { scaleX: 1, ease: 'none' });
  }

  /* 3. Packages ladder: steps rise in turn, rail fills behind them. */
  function ladder() {
    var ol = document.querySelector('.rl-home .ladder');
    if (!ol) return;
    var fill = ensure(ol, 'lad-fill');
    gsap.timeline({ scrollTrigger: { trigger: ol, start: 'top 78%', once: true } })
      .from(ol.querySelectorAll(':scope > .rung'), { y: 40, opacity: 0, duration: 1, ease: EASE, stagger: 0.15 })
      .fromTo(fill, { scaleY: 0 }, { scaleY: 1, duration: 1.2, ease: 'power2.inOut' }, 0.2);
  }


  /* 4. Section headings (never the hero): lines slide up from a mask, once; the split is reverted when done. */
  function headings() {
    if (!SplitText) return;
    var hs = document.querySelectorAll('.rl-home section:not(.hero) h2, .rl-home .rec-sub h3');
    hs.forEach(function (h) {
      SplitText.create(h, {
        type: 'lines', mask: 'lines', autoSplit: true,
        onSplit: function (self) {
          return gsap.from(self.lines, {
            yPercent: 105, duration: 1.1, ease: 'expo.out', stagger: 0.09,
            scrollTrigger: { trigger: h, start: 'top 88%', once: true },
            onComplete: function () { self.revert(); }
          });
        }
      });
    });
  }

  /* 5. Services index and industries list: rows fade up in turn as they enter. */
  function rows() {
    var items = document.querySelectorAll('.rl-home .ix > li, .rl-home .ind > li');
    if (!items.length) return;
    gsap.set(items, { opacity: 0, y: 26 });
    ScrollTrigger.batch(items, {
      start: 'top 90%', once: true,
      onEnter: function (batch) { gsap.to(batch, { opacity: 1, y: 0, duration: 0.9, ease: EASE, stagger: 0.08, overwrite: true }); }
    });
  }

  /* 6. Reading progress: a 2px red bar across the top of the window. */
  function progress() {
    var bar = document.querySelector('.rl-progress');
    if (!bar) { bar = document.createElement('div'); bar.className = 'rl-progress'; bar.setAttribute('aria-hidden', 'true'); document.body.appendChild(bar); }
    gsap.to(bar, { scaleX: 1, ease: 'none', scrollTrigger: { trigger: document.documentElement, start: 'top top', end: 'bottom bottom', scrub: 0.3 } });
    return bar;
  }

  /* 7. Closing call-to-action: the red glow builds up as the panel comes into view. */
  function glow() {
    var fin = document.querySelector('.rl-home .final');
    if (!fin) return;
    gsap.fromTo(fin, { '--glow': 0.2 }, { '--glow': 1, ease: 'none', scrollTrigger: { trigger: fin, start: 'top bottom', end: 'center 55%', scrub: 0.6 } });
  }


  /* 8. Outcomes: the three statements rise in turn as the section enters. */
  function outcomes() {
    var it = document.querySelectorAll('.rl-home .oc > .oc-i');
    if (!it.length) return;
    gsap.from(it, { y: 40, opacity: 0, duration: 1.1, ease: 'expo.out', stagger: 0.14, scrollTrigger: { trigger: it[0].parentNode, start: 'top 82%', once: true } });
  }

  /* 9. Cards rise into place with a slight 3D turn: award badges, testimonials. */
  function cardsIn() {
    [['.rl-home .recs > li', 0.08], ['.rl-home .quotes > .quote', 0.15]].forEach(function (g) {
      var els = document.querySelectorAll(g[0]);
      if (!els.length) return;
      gsap.from(els, { y: 60, rotationX: -14, opacity: 0, transformPerspective: 900, transformOrigin: '50% 100%', duration: 1.1, ease: 'expo.out', stagger: g[1],
        scrollTrigger: { trigger: els[0].parentNode, start: 'top 85%', once: true } });
    });
    /* testimonial quote marks drop in after their card */
    var qs = document.querySelectorAll('.rl-home .quote');
    if (qs.length) gsap.fromTo(qs, { '--q': 0 }, { '--q': 1, duration: 0.9, ease: EASE, stagger: 0.15, delay: 0.35,
      scrollTrigger: { trigger: qs[0].parentNode, start: 'top 85%', once: true } });
  }

  /* 10. HackerNoon award: the trophy outline draws itself, then the three results follow. */
  function award() {
    var hn = document.querySelector('.rl-home .hn');
    if (!hn) return;
    var paths = [].slice.call(hn.querySelectorAll('.cup path'));
    paths.forEach(function (p) { var L = p.getTotalLength ? p.getTotalLength() : 100; p.style.strokeDasharray = L; p.style.strokeDashoffset = L; });
    gsap.timeline({ scrollTrigger: { trigger: hn, start: 'top 80%', once: true } })
      .to(paths, { strokeDashoffset: 0, duration: 1.4, ease: 'power2.inOut', stagger: 0.15 })
      .from(hn.querySelectorAll('ul > li'), { x: 30, opacity: 0, duration: 0.9, ease: EASE, stagger: 0.12 }, 0.3);
    return paths;
  }

  /* 11. Pointer tilt with a light sheen (desktop with a mouse only). */
  function tilt() {
    if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches) return [];
    var els = [].slice.call(document.querySelectorAll('.rl-home .rec, .rl-home .quote, .rl-home .bl-posts .pcard, .rl-home .hn'));
    var offs = [];
    els.forEach(function (el) {
      var big = el.classList.contains('hn'), max = big ? 2.5 : 6;
      var sh = el.querySelector(':scope > .sheen');
      if (!sh) { sh = document.createElement('span'); sh.className = 'sheen'; sh.setAttribute('aria-hidden', 'true'); el.appendChild(sh); }
      gsap.set(el, { transformPerspective: 900 });
      var rx = gsap.quickTo(el, 'rotationX', { duration: 0.6, ease: EASE }), ry = gsap.quickTo(el, 'rotationY', { duration: 0.6, ease: EASE });
      function move(e) { var r = el.getBoundingClientRect(), px = (e.clientX - r.left) / r.width, py = (e.clientY - r.top) / r.height;
        ry((px - 0.5) * max * 2); rx((0.5 - py) * max * 2); el.style.setProperty('--sx', (px * 100).toFixed(1) + '%'); el.style.setProperty('--sy', (py * 100).toFixed(1) + '%'); el.classList.add('tilting'); }
      function leave() { rx(0); ry(0); el.classList.remove('tilting'); }
      el.addEventListener('pointermove', move); el.addEventListener('pointerleave', leave);
      offs.push(function () { el.removeEventListener('pointermove', move); el.removeEventListener('pointerleave', leave); el.classList.remove('tilting'); if (sh.parentNode) sh.parentNode.removeChild(sh); });
    });
    return offs;
  }

  var mm = gsap.matchMedia();
  mm.add({ motion: '(prefers-reduced-motion: no-preference)', wide: '(min-width: 901px)' }, function (ctx) {
    if (!ctx.conditions.motion) return;
    root.classList.add('rl-mo');
    timeline(ctx.conditions.wide);
    osEngine(ctx.conditions.wide);
    ladder();
    headings();
    rows();
    var bar = progress();
    glow();
    outcomes();
    cardsIn();
    var cup = award();
    var offs = ctx.conditions.wide ? tilt() : [];
    return function () {
      offs.forEach(function (f) { f(); });
      if (cup) cup.forEach(function (p) { p.style.strokeDasharray = ''; p.style.strokeDashoffset = ''; });
      root.classList.remove('rl-mo');
      if (bar && bar.parentNode) bar.parentNode.removeChild(bar);
      document.querySelectorAll('.rl-home .tline li.on, .rl-home .os-steps li.on').forEach(function (li) { li.classList.remove('on'); });
    };
  });

  /* lazy images and web fonts change heights after load: measure again so triggers sit in the right place */
  window.addEventListener('load', function () { ScrollTrigger.refresh(); });
  if (document.fonts && document.fonts.ready) document.fonts.ready.then(function () { ScrollTrigger.refresh(); });
})();
