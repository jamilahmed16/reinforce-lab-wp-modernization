/*!
 * Reinforce Lab signal field (D-165). A hand-written WebGL background for the home page's second section:
 * a perspective field of small square points in the brand reds that rolls in slow waves, with three brighter
 * pulses travelling toward the three outcomes. No library (about 5 KB).
 * Rules: decorative only (canvas is aria-hidden, all text stays HTML above it); starts after page load when
 * the browser is idle and only when the section is near the screen; the render loop stops when the section
 * leaves the screen or the tab is hidden; pixel ratio capped at 1.5; never runs on small screens, with
 * prefers-reduced-motion, with Save-Data, or without WebGL (the CSS dotted field underneath stays instead).
 */
(function () {
  'use strict';
  var canvas = document.querySelector('.rl-home .sig-cv');
  if (!canvas) return;
  var sec = canvas.closest('section');
  var mq = window.matchMedia;
  if (!mq || !mq('(min-width: 768px)').matches || mq('(prefers-reduced-motion: reduce)').matches) return;
  if (navigator.connection && navigator.connection.saveData) return;
  if (navigator.deviceMemory && navigator.deviceMemory < 4) return;

  var VS = [
    'attribute vec2 a;',
    'uniform float t; uniform vec2 m; uniform float s; uniform float asp; uniform float dpr;',
    'varying float vNear; varying float vGlow;',
    'void main(){',
    '  float x = (a.x * 2.0 - 1.0) * 1.7;',
    '  float z = mix(6.5, 1.15, a.y);',
    '  float h = 0.16 * sin(x * 2.1 + t * 0.55 + z * 0.8) + 0.10 * sin(z * 2.4 - t * 0.75) + 0.05 * sin(x * 5.0 - t * 0.9);',
    '  float p = 0.0;',
    '  for (int i = 0; i < 3; i++) {',
    '    float fi = float(i);',
    '    float lx = (fi - 1.0) * 1.12;',
    '    float ph = fract(t * 0.09 + fi * 0.333);',
    '    float pz = mix(6.5, 1.15, ph);',
    '    vec2 d = vec2((x - lx) * 1.4, z - pz);',
    '    p += exp(-dot(d, d) * 5.0) * 0.30 * smoothstep(0.0, 0.15, ph) * (1.0 - smoothstep(0.85, 1.0, ph));',
    '  }',
    '  float y = -0.80 + h + p;',
    '  float px = x + m.x * 0.35 / z;',
    '  float py = y + 0.08 - s * 0.22 + m.y * 0.06;',
    '  gl_Position = vec4(px / z * 1.9 / asp, py / z * 1.9, 0.0, 1.0);',
    '  gl_PointSize = dpr * mix(1.1, 3.4, a.y) * (1.0 + p * 1.8);',
    '  vNear = a.y; vGlow = p * 2.2 + max(h, 0.0) * 1.2;',
    '}'
  ].join('\n');

  var FS = [
    'precision mediump float;',
    'varying float vNear; varying float vGlow; uniform float fade;',
    'void main(){',
    '  float al = (0.07 + 0.30 * vNear) * (0.55 + clamp(vGlow, 0.0, 1.6)) * fade;',
    '  vec3 c = mix(vec3(0.60, 0.0, 0.0), vec3(0.91, 0.31, 0.31), clamp(vGlow, 0.0, 1.0));',
    '  gl_FragColor = vec4(c * al, al);',
    '}'
  ].join('\n');

  var gl, prog, U = {}, n = 0, raf = 0, on = false, t0 = 0, fade = 0;
  var mx = 0, my = 0, tmx = 0, tmy = 0, sc = 0;

  function sh(type, src) {
    var o = gl.createShader(type); gl.shaderSource(o, src); gl.compileShader(o);
    return gl.getShaderParameter(o, gl.COMPILE_STATUS) ? o : null;
  }

  function init() {
    gl = canvas.getContext('webgl', { alpha: true, premultipliedAlpha: true, antialias: false, depth: false, stencil: false, powerPreference: 'low-power' });
    if (!gl) return false;
    var v = sh(gl.VERTEX_SHADER, VS), f = sh(gl.FRAGMENT_SHADER, FS);
    if (!v || !f) return false;
    prog = gl.createProgram(); gl.attachShader(prog, v); gl.attachShader(prog, f); gl.linkProgram(prog);
    if (!gl.getProgramParameter(prog, gl.LINK_STATUS)) return false;
    gl.useProgram(prog);
    var cols = 150, rows = 48, pts = new Float32Array(cols * rows * 2), k = 0;
    for (var j = 0; j < rows; j++) for (var i = 0; i < cols; i++) { pts[k++] = i / (cols - 1); pts[k++] = j / (rows - 1); }
    n = cols * rows;
    gl.bindBuffer(gl.ARRAY_BUFFER, gl.createBuffer()); gl.bufferData(gl.ARRAY_BUFFER, pts, gl.STATIC_DRAW);
    var loc = gl.getAttribLocation(prog, 'a'); gl.enableVertexAttribArray(loc); gl.vertexAttribPointer(loc, 2, gl.FLOAT, false, 0, 0);
    ['t', 'm', 's', 'asp', 'dpr', 'fade'].forEach(function (u) { U[u] = gl.getUniformLocation(prog, u); });
    gl.enable(gl.BLEND); gl.blendFunc(gl.ONE, gl.ONE_MINUS_SRC_ALPHA);
    gl.clearColor(0, 0, 0, 0);
    return true;
  }

  function size() {
    var d = Math.min(window.devicePixelRatio || 1, 1.5), w = canvas.clientWidth, h = canvas.clientHeight;
    canvas.width = Math.max(1, Math.round(w * d)); canvas.height = Math.max(1, Math.round(h * d));
    gl.viewport(0, 0, canvas.width, canvas.height);
    gl.uniform1f(U.asp, w / Math.max(1, h)); gl.uniform1f(U.dpr, d);
  }

  function frame(now) {
    if (!on) { raf = 0; return; }
    if (!t0) t0 = now;
    mx += (tmx - mx) * 0.05; my += (tmy - my) * 0.05; fade = Math.min(1, fade + 0.02);
    var r = sec.getBoundingClientRect(), vh = window.innerHeight;
    sc = Math.max(0, Math.min(1, (vh - r.top) / (vh + r.height)));
    gl.clear(gl.COLOR_BUFFER_BIT);
    gl.uniform1f(U.t, (now - t0) / 1000); gl.uniform2f(U.m, mx, my); gl.uniform1f(U.s, sc); gl.uniform1f(U.fade, fade);
    gl.drawArrays(gl.POINTS, 0, n);
    raf = requestAnimationFrame(frame);
  }

  function start() { if (!on && !document.hidden) { on = true; if (!raf) raf = requestAnimationFrame(frame); } }
  function stop() { on = false; }

  function boot() {
    if (!init()) return;
    size();
    canvas.classList.add('on');
    if (window.ResizeObserver) new ResizeObserver(size).observe(canvas); else window.addEventListener('resize', size);
    new IntersectionObserver(function (es) { es[0].isIntersecting ? start() : stop(); }, { rootMargin: '150px 0px' }).observe(sec);
    document.addEventListener('visibilitychange', function () { document.hidden ? stop() : (sec.getBoundingClientRect().top < window.innerHeight && start()); });
    sec.addEventListener('pointermove', function (e) { var r = sec.getBoundingClientRect(); tmx = (e.clientX - r.left) / r.width * 2 - 1; tmy = (e.clientY - r.top) / r.height * 2 - 1; }, { passive: true });
    sec.addEventListener('pointerleave', function () { tmx = tmy = 0; });
  }

  /* after load, when the browser is idle: never competes with the first paint */
  function later() { (window.requestIdleCallback || function (cb) { setTimeout(cb, 300); })(boot, { timeout: 2000 }); }
  if (document.readyState === 'complete') later(); else window.addEventListener('load', later);
})();
