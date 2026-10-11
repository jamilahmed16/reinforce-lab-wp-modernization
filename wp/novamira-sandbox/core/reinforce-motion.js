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
 * D-169: the hero diagram plays a directed 12 s "one cycle of growth" loop (heroSystem).
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
    if (!SplitText) return [];
    /* one task per heading, so the line splitting never adds up to one long task */
    return [].slice.call(document.querySelectorAll('.rl-home section:not(.hero) h2, .rl-home .rec-sub h3')).map(function (h) {
      return function () {
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
      };
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


  /* 12. Hero diagram, "one cycle of growth" (D-169). A 12 s directed loop on the existing SVG: ingest (inputs
     ignite, packets travel into the engine), absorb (engine breathes, a light traces its border), process (the
     five stages read out and their bars fill), emit (packets fan out, outcomes fill left to right), compound
     (a comet runs the feedback loop back to the inputs), breathe. A one-off "power on" draws the connectors
     first. Desktop with a mouse adds depth (the three columns move at different rates) and hover tracing of one
     signal. Nothing is hidden at load: the script only adds light to a diagram that is already fully drawn. */
  function heroSystem(wide) {
    var fig = document.querySelector('.rl-home .ge');
    var svg = fig && fig.querySelector('svg');
    if (!svg || !svg.querySelector('.ge-trace')) return null;
    var NS = 'http://www.w3.org/2000/svg', $$ = function (s) { return [].slice.call(svg.querySelectorAll(s)); }, $ = function (s) { return svg.querySelector(s); };
    var idx = [0, 1, 2, 3, 4];
    var ins = idx.map(function (i) { return $('.ge-i' + i); }), outs = idx.map(function (i) { return $('.ge-o' + i); });
    var pin = idx.map(function (i) { return $('.ge-pi' + i); }), pout = idx.map(function (i) { return $('.ge-po' + i); });
    var edges = $$('.ge-e'), fb = $('.ge-pf'), fbl = $('.ge-fbl-on'), core = $('.ge-cg'), trace = $('.ge-trace');
    var stT = $$('.ge-st'), stB = $$('.ge-sl'), pk = $('.ge-pk');
    var txDim = getComputedStyle($('.ge-tx')).fill, txOn = '#f4efe9', red = '#e85050', edgeCol = getComputedStyle(edges[0]).stroke;
    fig.classList.add('ge-gs');
    gsap.set([$$('.ge-nl'), $$('.ge-p'), core, stT, fbl, trace, $$('.ge-fill')], { opacity: 0 });
    gsap.set($$('.ge-fill').concat(stB), { scaleX: 0, transformOrigin: '0% 50%' });
    gsap.set(stB, { opacity: 1 });

    function packet() {
      var g = document.createElementNS(NS, 'g');
      g.innerHTML = '<rect x="-7" y="-7" width="14" height="14" fill="' + red + '" opacity=".22"/><rect x="-3" y="-3" width="6" height="6" fill="' + txOn + '"/>';
      pk.appendChild(g); gsap.set(g, { opacity: 0 });
      return g;
    }
    /* a packet with its glowing tail (the existing dashed .ge-p path) travelling along one curve */
    function travel(tl, path, at, dur) {
      var g = packet(), L = path.getTotalLength(), o = { p: 0 };
      tl.set(g, { opacity: 1 }, at).set(path, { opacity: 1 }, at)
        .fromTo(o, { p: 0 }, { p: 1.1, duration: dur, ease: 'power2.inOut', immediateRender: false, onUpdate: function () {
          var pt = path.getPointAtLength(Math.min(o.p, 1) * L);
          g.setAttribute('transform', 'translate(' + pt.x.toFixed(1) + ' ' + pt.y.toFixed(1) + ')');
          path.style.strokeDashoffset = 10 - o.p * 100;
          g.style.opacity = o.p > 1 ? 0 : 1;
        } }, at)
        .set([g, path], { opacity: 0 }, at + dur);
    }
    function ignite(tl, node, at) {
      tl.to(node.querySelector('.ge-fill'), { opacity: 1, scaleX: 1, duration: 0.55, ease: 'power3.out' }, at)
        .to(node.querySelector('.ge-nl'), { opacity: 1, duration: 0.3 }, at)
        .to(node.querySelectorAll('.ge-tx'), { fill: txOn, duration: 0.3 }, at);
    }
    function settle(tl, nodes, at) {
      var f = nodes.map(function (n) { return n.querySelector('.ge-fill'); }), l = nodes.map(function (n) { return n.querySelector('.ge-nl'); });
      var t = []; nodes.forEach(function (n) { t = t.concat([].slice.call(n.querySelectorAll('.ge-tx'))); });
      tl.to(f, { opacity: 0, duration: 0.7, ease: 'power2.in' }, at).set(f, { scaleX: 0 }, at + 0.7)
        .to(l, { opacity: 0, duration: 0.7 }, at).to(t, { fill: txDim, duration: 0.7 }, at);
    }

    var T = gsap.timeline({ repeat: -1, paused: true, defaults: { ease: 'power2.out' } });
    /* 1. ingest 0 to 2.4 s */
    ins.forEach(function (g, i) { var at = i * 0.38; ignite(T, g, at); travel(T, pin[i], at + 0.2, 0.95); });
    /* 2. absorb: the engine breathes, the trace starts */
    T.to(core, { opacity: 1, duration: 0.35 }, 2.15).to(core, { opacity: 0.4, duration: 0.8 }, 2.5)
      .fromTo(trace, { opacity: 0, strokeDashoffset: 0 }, { opacity: 1, duration: 0.3 }, 2.4)
      .to(trace, { strokeDashoffset: -400, duration: 4.6, ease: 'none' }, 2.4)
      .to(trace, { opacity: 0, duration: 0.4 }, 6.9);
    settle(T, ins, 3.0);
    /* 3. process 3 to 7 s: the five stages read out, bars fill */
    stT.forEach(function (t, j) {
      var at = 3.0 + j * 0.8;
      T.to(t, { opacity: 1, duration: 0.25 }, at).to(stB[j], { scaleX: 1, duration: 0.7, ease: 'power1.inOut' }, at);
      if (j < stT.length - 1) T.to(t, { opacity: 0, duration: 0.2 }, at + 0.68); else T.to(t, { opacity: 0, duration: 0.4 }, 9.0);
    });
    /* 4. emit 7 to 9.4 s: packets fan out, outcomes fill */
    T.to(core, { opacity: 1, duration: 0.3 }, 6.9).to(core, { opacity: 0.4, duration: 0.6 }, 7.2);
    outs.forEach(function (g, i) { var at = 7.0 + i * 0.3; travel(T, pout[i], at, 0.85); ignite(T, g, at + 0.72); });
    /* 5. compound 9.4 to 11.2 s: comet on the feedback loop, label lights, inputs flicker */
    travel(T, fb, 9.5, 1.6);
    T.to(fbl, { opacity: 1, duration: 0.4 }, 9.7).to(fbl, { opacity: 0, duration: 0.6 }, 11.3)
      .to(ins.map(function (g) { return g.querySelector('.ge-nl'); }), { opacity: 0.8, duration: 0.15, stagger: 0.05, yoyo: true, repeat: 1 }, 10.95);
    /* 6. breathe 11.2 to 12 s */
    settle(T, outs, 11.2);
    T.to(stB, { scaleX: 0, duration: 0.5, ease: 'power2.in' }, 11.3).to(core, { opacity: 0, duration: 0.6 }, 11.3)
      .to({}, { duration: 0.01 }, 12);

    /* one-off "power on": every connector draws in red, then cools to its normal grey, and the loop starts */
    var intro = gsap.timeline({ paused: true, onComplete: function () { T.play(0); } });
    edges.forEach(function (e, i) {
      var L = e.getTotalLength();
      intro.fromTo(e, { strokeDasharray: L + ' ' + L, strokeDashoffset: L, stroke: red }, { strokeDashoffset: 0, duration: 0.7, ease: 'power2.inOut' }, (i % 2 ? 0.35 : 0) + Math.floor(i / 2) * 0.06)
        .to(e, { stroke: edgeCol, duration: 0.6 }, 0.9 + Math.floor(i / 2) * 0.06);
    });
    intro.to(core, { opacity: 1, duration: 0.3 }, 0.55).to(core, { opacity: 0, duration: 0.6 }, 1.0);

    /* runs only while the diagram is on screen */
    var started = false;
    var st = ScrollTrigger.create({ trigger: fig, start: 'top bottom', end: 'bottom top', onToggle: function (self) {
      if (self.isActive) { if (!started) { started = true; intro.play(0); } else if (!intro.isActive()) T.play(); }
      else { T.pause(); }
    } });
    if (st.isActive && !started) { started = true; intro.play(0); }

    var offs = [];
    if (wide && window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
      /* depth: inputs, connectors, engine and outcomes move at different rates with the pointer */
      var hero = fig.closest('section') || fig;
      var layers = [['.ge-L-in', -7, -4], ['.ge-L-edges', -2, -1], ['.ge-L-core', 3, 2], ['.ge-L-out', 8, 5]].map(function (d) {
        var el = $(d[0]); return { x: gsap.quickTo(el, 'x', { duration: 0.9, ease: EASE }), y: gsap.quickTo(el, 'y', { duration: 0.9, ease: EASE }), dx: d[1], dy: d[2] };
      });
      var mv = function (e) { var r = hero.getBoundingClientRect(), nx = (e.clientX - r.left) / r.width - 0.5, ny = (e.clientY - r.top) / r.height - 0.5;
        layers.forEach(function (l) { l.x(nx * l.dx * 2); l.y(ny * l.dy * 2); }); };
      var lv = function () { layers.forEach(function (l) { l.x(0); l.y(0); }); };
      hero.addEventListener('pointermove', mv); hero.addEventListener('pointerleave', lv);
      offs.push(function () { hero.removeEventListener('pointermove', mv); hero.removeEventListener('pointerleave', lv); });
      /* hover an input: trace its route through the engine to its outcome */
      ins.forEach(function (g, i) {
        var route = [edges[2 * i], edges[2 * i + 1]], target = outs[i].querySelector('.ge-nl');
        var on = function () { gsap.to(route, { stroke: red, duration: 0.3, overwrite: 'auto' }); gsap.to([g.querySelector('.ge-nl'), target], { opacity: 1, duration: 0.3, overwrite: 'auto' }); };
        var off = function () { gsap.to(route, { stroke: edgeCol, duration: 0.5, overwrite: 'auto' }); gsap.to([g.querySelector('.ge-nl'), target], { opacity: 0, duration: 0.5, overwrite: 'auto' }); };
        g.addEventListener('pointerenter', on); g.addEventListener('pointerleave', off);
        offs.push(function () { g.removeEventListener('pointerenter', on); g.removeEventListener('pointerleave', off); });
      });
    }
    return function () {
      T.kill(); intro.kill(); st.kill(); offs.forEach(function (f) { f(); });
      while (pk.firstChild) pk.removeChild(pk.firstChild);
      fig.classList.remove('ge-gs');
      gsap.set(svg.querySelectorAll('*'), { clearProps: 'all' });
    };
  }

  /* Setup runs after the page has loaded, one feature per task with a yield in between (D-165): on a slow
     phone no single task gets long, so the motion adds almost nothing to Total Blocking Time. */
  var idle = window.requestIdleCallback ? function (fn) { window.requestIdleCallback(fn, { timeout: 600 }); } : function (fn) { setTimeout(fn, 1); };

  function boot() {
    var mm = gsap.matchMedia();
    mm.add({ motion: '(prefers-reduced-motion: no-preference)', wide: '(min-width: 901px)' }, function (ctx) {
      if (!ctx.conditions.motion) return;
      var wide = ctx.conditions.wide, bar = null, cup = null, offs = [], live = true;
      root.classList.add('rl-mo');
      var heroOff = null;
      var tasks = [
        function () { heroOff = heroSystem(wide); },
        function () { timeline(wide); }, function () { osEngine(wide); }, ladder
      ].concat(headings(), [
        rows, function () { bar = progress(); }, glow, outcomes, cardsIn,
        function () { cup = award(); }, function () { if (wide) offs = tilt(); },
        function () { ScrollTrigger.refresh(); }
      ]);
      (function next(i) {
        if (!live || i >= tasks.length) return;
        ctx.add(tasks[i]);
        idle(function () { next(i + 1); });
      })(0);
      return function () {
        live = false;
        if (heroOff) heroOff();
        offs.forEach(function (f) { f(); });
        if (cup) cup.forEach(function (p) { p.style.strokeDasharray = ''; p.style.strokeDashoffset = ''; });
        root.classList.remove('rl-mo');
        if (bar && bar.parentNode) bar.parentNode.removeChild(bar);
        document.querySelectorAll('.rl-home .tline li.on, .rl-home .os-steps li.on').forEach(function (li) { li.classList.remove('on'); });
      };
    });
  }
  if (document.readyState === 'complete') idle(boot); else window.addEventListener('load', function () { idle(boot); });

  /* web fonts change heights: measure again so triggers sit in the right place (the last setup task also refreshes) */
  if (document.fonts && document.fonts.ready) document.fonts.ready.then(function () { ScrollTrigger.refresh(); });
})();
