/*!
 * Reinforce Lab diagnostic scan (D-167). Hand-written WebGL background for the home page's closing call to
 * action ("Find out what's limiting your growth."): a flat grid of small square points in the brand reds and a
 * radar-style beam that sweeps out from the red glow at the bottom of the panel. Points light up as the beam
 * passes and fade behind it; a few "findings" flash brighter. Same visual language as the signal field
 * (reinforce-signal.js), a different idea: the field shows a system in motion, the scan shows a diagnosis.
 * One fragment shader over the panel, no library (about 2 KB).
 * Same rules as the signal field: decorative (aria-hidden, text stays HTML above it, dimmed behind the text),
 * boots on the visitor's first interaction, runs only while the panel is on screen and the tab is visible,
 * pixel ratio capped at 1.5, never on small screens, reduced motion, Save-Data, low memory or without WebGL.
 */
(function () {
  'use strict';
  var canvas = document.querySelector('.rl-home .scan-cv');
  if (!canvas) return;
  var box = canvas.parentNode;
  var mq = window.matchMedia;
  if (!mq || !mq('(min-width: 768px)').matches || mq('(prefers-reduced-motion: reduce)').matches) return;
  if (navigator.connection && navigator.connection.saveData) return;
  if (navigator.deviceMemory && navigator.deviceMemory < 4) return;

  var VS = 'attribute vec2 a; void main(){ gl_Position = vec4(a, 0.0, 1.0); }';
  var FS = [
    'precision mediump float;',
    'uniform vec2 res; uniform float t; uniform float dpr; uniform float mx; uniform float fade;',
    'float hash(vec2 p){ return fract(sin(dot(p, vec2(127.1, 311.7))) * 43758.5453); }',
    'void main(){',
    '  vec2 p = gl_FragCoord.xy;',
    '  float cell = 24.0 * dpr;',
    '  vec2 id = floor(p / cell);',
    '  vec2 g = p - (id + 0.5) * cell;',
    '  float dotm = step(max(abs(g.x), abs(g.y)), 1.5 * dpr);',
    '  vec2 o = vec2(res.x * (0.5 + mx * 0.04), -res.y * 0.06);',
    '  vec2 d = (id + 0.5) * cell - o;',
    '  float ang = atan(d.y, d.x);',
    '  float beam = 3.14159 * (1.0 - fract(t * 0.1));',
    '  float behind = ang - beam; if (behind < 0.0) behind += 6.28318;',
    '  float trail = exp(-behind * 2.2);',
    '  float r = length(d) / res.y;',
    '  float reach = smoothstep(1.75, 0.15, r);',
    '  vec2 uv = p / res;',
    '  float text = smoothstep(0.36, 0.18, abs(uv.x - 0.5)) * smoothstep(0.22, 0.42, uv.y);',
    '  float find = step(0.975, hash(id)) * exp(-behind * 0.9);',
    '  float lit = 0.14 + 0.95 * trail + 1.4 * find;',
    '  float line = exp(-behind * 160.0) * 0.28 * reach;',
    '  float al = clamp((dotm * lit * reach * (1.0 - 0.6 * text) + line * (1.0 - 0.75 * text)) * fade, 0.0, 0.9);',
    '  vec3 c = mix(vec3(0.60, 0.0, 0.0), vec3(0.95, 0.38, 0.36), clamp(trail * 0.8 + find, 0.0, 1.0));',
    '  gl_FragColor = vec4(c * al, al);',
    '}'
  ].join('\n');

  var gl, U = {}, raf = 0, on = false, t0 = 0, fade = 0, mx = 0, tmx = 0;

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
    ['res', 't', 'dpr', 'mx', 'fade'].forEach(function (u) { U[u] = gl.getUniformLocation(pr, u); });
    gl.enable(gl.BLEND); gl.blendFunc(gl.ONE, gl.ONE_MINUS_SRC_ALPHA); gl.clearColor(0, 0, 0, 0);
    return true;
  }

  function size() {
    var d = Math.min(window.devicePixelRatio || 1, 1.5);
    canvas.width = Math.max(1, Math.round(canvas.clientWidth * d)); canvas.height = Math.max(1, Math.round(canvas.clientHeight * d));
    gl.viewport(0, 0, canvas.width, canvas.height);
    gl.uniform2f(U.res, canvas.width, canvas.height); gl.uniform1f(U.dpr, d);
  }

  function frame(now) {
    if (!on) { raf = 0; return; }
    if (!t0) t0 = now;
    mx += (tmx - mx) * 0.05; fade = Math.min(1, fade + 0.02);
    gl.clear(gl.COLOR_BUFFER_BIT);
    gl.uniform1f(U.t, (now - t0) / 1000); gl.uniform1f(U.mx, mx); gl.uniform1f(U.fade, fade);
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
    new IntersectionObserver(function (es) { es[0].isIntersecting ? start() : stop(); }, { rootMargin: '150px 0px' }).observe(box);
    document.addEventListener('visibilitychange', function () { document.hidden ? stop() : (box.getBoundingClientRect().top < window.innerHeight && start()); });
    box.addEventListener('pointermove', function (e) { var r = box.getBoundingClientRect(); tmx = (e.clientX - r.left) / r.width * 2 - 1; }, { passive: true });
    box.addEventListener('pointerleave', function () { tmx = 0; });
  }

  /* boot on the first interaction, never in the page-load window */
  var booted = false, evs = ['scroll', 'pointermove', 'touchstart', 'keydown', 'wheel'];
  function go() {
    if (booted) return; booted = true;
    evs.forEach(function (e) { window.removeEventListener(e, go, true); });
    (window.requestIdleCallback || function (cb) { setTimeout(cb, 1); })(boot, { timeout: 1200 });
  }
  evs.forEach(function (e) { window.addEventListener(e, go, { capture: true, passive: true }); });
})();
