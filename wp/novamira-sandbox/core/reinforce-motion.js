/*!
 * Reinforce Lab scroll motion (D-163). Needs GSAP + ScrollTrigger (loaded before this file, all deferred).
 * Phase 1 (D-163): three moments on the home page.
 *   1. How it works: the rail draws itself with scroll and each stage lights up as the line reaches it.
 *   2. Search Authority OS: the section holds for a moment (desktop) while the five stages light up in turn.
 *   3. Packages: the ladder steps rise one after another and the rail fills.
 * Phase 2 (D-164): section headings reveal line by line (SplitText, undone afterwards so the heading HTML is
 * exactly as served), services and industries rows fade up in turn, a thin red reading-progress bar, and the
 * closing call-to-action glows as it comes into view. (The slimmer header is sitewide, in core/reinforce-header.php.)
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
    return function () {
      root.classList.remove('rl-mo');
      if (bar && bar.parentNode) bar.parentNode.removeChild(bar);
      document.querySelectorAll('.rl-home .tline li.on, .rl-home .os-steps li.on').forEach(function (li) { li.classList.remove('on'); });
    };
  });

  /* lazy images and web fonts change heights after load: measure again so triggers sit in the right place */
  window.addEventListener('load', function () { ScrollTrigger.refresh(); });
  if (document.fonts && document.fonts.ready) document.fonts.ready.then(function () { ScrollTrigger.refresh(); });
})();
