/*!
 * Reinforce Lab hero scan (D-168). The hero diagram (Inputs -> Engine -> Outcomes, a 10 s CSS cycle) gets a
 * scan beam behind it in the style of the closing call to action's scan (reinforce-scan.js): a grid of small
 * square points in the brand reds and a vertical beam that sweeps left to right in step with the diagram,
 * reaching the inputs as they light, moving slowly through the engine while its stages run, then crossing the
 * outcomes, and fading at the reset. The beam reads the diagram's own animation clock every frame, so it never
 * drifts and it stops when the diagram is paused off screen.
 * One fragment shader, no library (about 2 KB). Decorative: the canvas is aria-hidden and sits behind the SVG.
 * Same rules as the other scenes: desktop only, boots on the first interaction (never in the page-load window),
 * draws only while on screen and the tab is visible, pixel ratio capped at 1.5, no reduced motion / Save-Data /
 * low memory / missing WebGL.
 */
(function () {
  'use strict';
  var canvas = document.querySelector('.rl-home .ge-cv');
  if (!canvas) return;
  var fig = canvas.parentNode, clockEl = fig.querySelector('.ge-cg');
  var mq = window.matchMedia;
  if (!mq || !mq('(min-width: 768px)').matches || mq('(prefers-reduced-motion: reduce)').matches) return;
  if (navigator.connection && navigator.connection.saveData) return;
  if (navigator.deviceMemory && navigator.deviceMemory < 4) return;

  /* beam position (0..1 across the diagram) and strength for a phase of the 10 s cycle, matched to the keyframes
     in rl_home_ge_kf(): inputs 0-18 %, engine 18-57 %, outcomes 58-83 %, feedback to 91 %, fade 92-97 % */
  var KEYS = [[0, 0.02, 0], [0.03, 0.05, 1], [0.18, 0.31, 1], [0.22, 0.37, 1], [0.57, 0.63, 1], [0.70, 0.80, 1], [0.83, 0.98, 1], [0.91, 1.02, 0.6], [0.95, 1.05, 0], [1, 1.05, 0]];
  function beamAt(ph) {
    for (var i = 1; i < KEYS.length; i++) if (ph <= KEYS[i][0]) {
      var a = KEYS[i - 1], b = KEYS[i], k = (ph - a[0]) / Math.max(1e-6, b[0] - a[0]);
      return [a[1] + (b[1] - a[1]) * k, a[2] + (b[2] - a[2]) * k];
    }
    return [1.05, 0];
  }

  var VS = 'attribute vec2 a; void main(){ gl_Position = vec4(a, 0.0, 1.0); }';
  var FS = [
    'precision mediump float;',
    'uniform vec2 res; uniform float dpr; uniform float bx; uniform float ba; uniform float t; uniform float fade;',
    'float hash(vec2 p){ return fract(sin(dot(p, vec2(127.1, 311.7))) * 43758.5453); }',
    'void main(){',
    '  vec2 p = gl_FragCoord.xy;',
    '  float cell = 16.0 * dpr;',
    '  vec2 id = floor(p / cell);',
    '  vec2 g = p - (id + 0.5) * cell;',
    '  float dotm = step(max(abs(g.x), abs(g.y)), 1.1 * dpr);',
    '  float x = (id.x + 0.5) * cell / res.x;',
    '  float behind = bx - x;',
    '  float trail = behind >= 0.0 ? exp(-behind * 9.0) : exp(behind * 160.0) * 0.4;',
    '  float line = exp(-abs(behind) * res.x / (6.0 * dpr)) * 0.5;',
    '  float find = step(0.965, hash(id + floor(t * 0.1))) * (behind >= 0.0 ? exp(-behind * 4.0) : 0.0);',
    '  float edge = smoothstep(0.0, 0.08, p.y / res.y) * smoothstep(0.0, 0.08, 1.0 - p.y / res.y);',
    '  float al = (dotm * (0.10 + 0.75 * trail + 1.1 * find) + line * 0.35) * ba * edge * fade;',
    '  al = clamp(al, 0.0, 0.85);',
    '  vec3 c = mix(vec3(0.60, 0.0, 0.0), vec3(0.95, 0.38, 0.36), clamp(trail + find, 0.0, 1.0));',
    '  gl_FragColor = vec4(c * al, al);',
    '}'
  ].join('\n');

  var gl, U = {}, raf = 0, on = false, fade = 0, t0 = 0;

  function sh(type, src) { var s = gl.createShader(type); gl.shaderSource(s, src); gl.compileShader(s); return gl.getShaderParameter(s, gl.COMPILE_STATUS) ? s : null; }

  function init() {
    gl = canvas.getContext('webgl', { alpha: true, premultipliedAlpha: true, antialias: false, depth: false, stencil: false, powerPreference: 'low-power' });
    if (!gl) return false;
    var v = sh(gl.VERTEX_SHADER, VS), f = sh(gl.FRAGMENT_SHADER, FS);
    if (!v || !f) return false;
    var pr = gl.createProgram(); gl.attachShader(pr, v); gl.attachShader(pr, f); gl.linkProgram(pr);
    if (!gl.getProgramParameter(pr, gl.LINK_STATUS)) return false;
    gl.useProgram(pr);
    gl.bindBuffer(gl.ARRAY_BUFFER, gl.createBuffer());
    gl.bufferData(gl.ARRAY_BUFFER, new Float32Array([-1, -1, 1, -1, -1, 1, 1, 1]), gl.STATIC_DRAW);
    var loc = gl.getAttribLocation(pr, 'a'); gl.enableVertexAttribArray(loc); gl.vertexAttribPointer(loc, 2, gl.FLOAT, false, 0, 0);
    ['res', 'dpr', 'bx', 'ba', 't', 'fade'].forEach(function (u) { U[u] = gl.getUniformLocation(pr, u); });
    gl.enable(gl.BLEND); gl.blendFunc(gl.ONE, gl.ONE_MINUS_SRC_ALPHA); gl.clearColor(0, 0, 0, 0);
    return true;
  }

  function size() {
    var d = Math.min(window.devicePixelRatio || 1, 1.5);
    canvas.width = Math.max(1, Math.round(canvas.clientWidth * d)); canvas.height = Math.max(1, Math.round(canvas.clientHeight * d));
    gl.viewport(0, 0, canvas.width, canvas.height);
    gl.uniform2f(U.res, canvas.width, canvas.height); gl.uniform1f(U.dpr, d);
  }

  /* the diagram's own clock: the core glow's CSS animation (10 s, paused off screen by the D-039 script) */
  function phase(now) {
    var an = clockEl && clockEl.getAnimations ? clockEl.getAnimations()[0] : null;
    var ms = an && an.currentTime != null ? an.currentTime : now;
    return (ms % 10000) / 10000;
  }

  function frame(now) {
    if (!on) { raf = 0; return; }
    if (!t0) t0 = now;
    fade = Math.min(1, fade + 0.03);
    var b = beamAt(phase(now));
    gl.clear(gl.COLOR_BUFFER_BIT);
    gl.uniform1f(U.bx, b[0]); gl.uniform1f(U.ba, b[1]); gl.uniform1f(U.t, (now - t0) / 1000); gl.uniform1f(U.fade, fade);
    gl.drawArrays(gl.TRIANGLE_STRIP, 0, 4);
    raf = requestAnimationFrame(frame);
  }
  function start() { if (!on && !document.hidden) { on = true; if (!raf) raf = requestAnimationFrame(frame); } }
  function stop() { on = false; }

  function boot() {
    if (!init()) return;
    size();
    canvas.classList.add('on');
    if (window.ResizeObserver) new ResizeObserver(size).observe(canvas); else window.addEventListener('resize', size);
    new IntersectionObserver(function (es) { es[0].isIntersecting ? start() : stop(); }).observe(fig);
    document.addEventListener('visibilitychange', function () { document.hidden ? stop() : (fig.getBoundingClientRect().bottom > 0 && start()); });
  }

  var booted = false, evs = ['scroll', 'pointermove', 'touchstart', 'keydown', 'wheel'];
  function go() {
    if (booted) return; booted = true;
    evs.forEach(function (e) { window.removeEventListener(e, go, true); });
    (window.requestIdleCallback || function (cb) { setTimeout(cb, 1); })(boot, { timeout: 1200 });
  }
  evs.forEach(function (e) { window.addEventListener(e, go, { capture: true, passive: true }); });
})();
