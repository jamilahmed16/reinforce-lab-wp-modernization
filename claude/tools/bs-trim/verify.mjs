import { chromium } from '/opt/node22/lib/node_modules/playwright/index.mjs';
import fs from 'fs'; import crypto from 'crypto'; import pathMod from 'path';
const CACHE = new URL('../.cache', import.meta.url).pathname; fs.mkdirSync(CACHE, { recursive: true });
const urls = fs.readFileSync(process.argv[2] || new URL('urls.txt', import.meta.url).pathname, 'utf8').trim().split('\n');
const FULL = { 'reinforce-bootstrap-lean': 'https://reinforcelab.online/wp-content/themes/bb-theme/css/bootstrap-4.min.css?ver=1.7.20', 'reinforce-skin-lean': 'https://reinforcelab.online/wp-content/uploads/bb-theme/skin-6aba2a89c9195.css?ver=1.7.20' };
const b = await chromium.launch({ proxy: process.env.HTTPS_PROXY ? { server: process.env.HTTPS_PROXY } : undefined });
const PROPS = ['display','position','top','left','float','clear','color','background-color','background-image','font-family','font-size','font-weight','font-style','line-height','letter-spacing','text-transform','text-align','text-decoration-line','text-decoration-color','text-underline-offset','margin-top','margin-right','margin-bottom','margin-left','padding-top','padding-right','padding-bottom','padding-left','width','height','max-width','border-top-width','border-top-color','border-top-style','border-bottom-width','border-bottom-color','border-left-width','border-left-color','border-right-width','opacity','visibility','box-shadow','list-style-type','cursor','vertical-align','overflow-x','overflow-y','white-space','z-index','box-sizing','outline-style','outline-color','outline-width','outline-offset','fill','stroke','grid-template-columns','gap','flex-direction','justify-content','align-items','content'];
let total = 0;
for (const w of [1440, 390]) {
  const ctx = await b.newContext({ ignoreHTTPSErrors: true, viewport: { width: w, height: 900 }, reducedMotion: 'reduce' });
  await ctx.route('**/*', async route => {
    const req = route.request(), url = req.url();
    if (/stats\.wp\.com|pixel\.wp\.com|googletagmanager/.test(url)) return route.abort();
    const fresh = req.resourceType() === 'document';
    const key = pathMod.join(CACHE, crypto.createHash('md5').update(url.replace(/[?&]nc=\d+/, '')).digest('hex'));
    if (!fresh && fs.existsSync(key + '.b')) { const m = JSON.parse(fs.readFileSync(key + '.h')); return route.fulfill({ status: m.s, headers: m.h, body: fs.readFileSync(key + '.b') }); }
    for (let t = 0; t < 6; t++) { try { const r = await route.fetch({ timeout: 30000 }); const body = await r.body(); if (r.status() < 500) { if (!fresh) { fs.writeFileSync(key + '.b', body); fs.writeFileSync(key + '.h', JSON.stringify({ s: r.status(), h: r.headers() })); } return route.fulfill({ response: r, body }); } } catch (e) {} }
    return route.abort();
  });
  const p = await ctx.newPage();
  for (const u of urls) {
    for (let t = 0; t < 4; t++) { try { await p.goto('https://reinforcelab.online' + u + (u.includes('?') ? '&' : '?') + 'nc=' + Date.now(), { waitUntil: 'load', timeout: 120000 }); break; } catch (e) {} }
    await p.waitForTimeout(300);
    const snap = () => p.evaluate((PROPS) => { const out = []; const els = document.querySelectorAll('body *');
      els.forEach((el, i) => { for (const pe of ['', '::before', '::after']) { const cs = getComputedStyle(el, pe || null); if (pe && (cs.content === 'none' || cs.content === 'normal')) continue; out.push(i + pe + '|' + PROPS.map(k => cs.getPropertyValue(k)).join('|')); } });
      return out; }, PROPS);
    const a = await snap();
    await p.evaluate(async (FULL) => { const ps = []; for (const id in FULL) { const st = document.getElementById(id); if (!st) continue; const l = document.createElement('link'); l.rel = 'stylesheet'; l.href = FULL[id]; ps.push(new Promise(r => { l.onload = r; l.onerror = r; })); st.replaceWith(l); } await Promise.all(ps); }, FULL);
    await p.waitForTimeout(300);
    const bb = await snap();
    const diffs = [];
    if (a.length !== bb.length) diffs.push('count ' + a.length + ' vs ' + bb.length);
    for (let i = 0; i < Math.min(a.length, bb.length) && diffs.length < 6; i++) if (a[i] !== bb[i]) {
      const x = a[i].split('|'), y = bb[i].split('|'); const idx = x[0];
      const desc = await p.evaluate(n => { const el = document.querySelectorAll('body *')[parseInt(n)]; return el.tagName.toLowerCase() + '.' + [...el.classList].join('.'); }, idx);
      diffs.push(desc + ' ' + idx + ' ' + PROPS.map((k, j) => x[j + 1] !== y[j + 1] ? k + ': trimmed=' + x[j + 1] + ' full=' + y[j + 1] : '').filter(Boolean).join('; '));
    }
    total += diffs.length;
    if (diffs.length) console.log(w, u, JSON.stringify(diffs, null, 1));
  }
  await ctx.close();
}
console.log('pages x widths checked', urls.length * 2, 'with differences', total); await b.close();
