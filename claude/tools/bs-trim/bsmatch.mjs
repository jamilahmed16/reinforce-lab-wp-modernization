import { chromium } from '/opt/node22/lib/node_modules/playwright/index.mjs';
import fs from 'fs'; import crypto from 'crypto'; import pathMod from 'path';
const CACHE = new URL('../.cache', import.meta.url).pathname; fs.mkdirSync(CACHE, { recursive: true });
const BS = process.cwd() + '/';
const sels = JSON.parse(fs.readFileSync(BS + 'selectors.json', 'utf8'));
const urls = fs.readFileSync(process.argv[2] || 'urls.txt', 'utf8').trim().split('\n');
const b = await chromium.launch({ proxy: process.env.HTTPS_PROXY ? { server: process.env.HTTPS_PROXY } : undefined });
const used = {}; let bad = new Set();
for (const w of [1440, 390]) {
  const ctx = await b.newContext({ ignoreHTTPSErrors: true, viewport: { width: w, height: 900 } });
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
    await p.waitForTimeout(500);
    const r = await p.evaluate((sels) => {
      const strip = sel => { let s = sel.replace(/::?-?[a-zA-Z-]+(\((?:[^()]|\([^()]*\))*\))?/g, '').trim();
        s = s.replace(/([>+~])\s*(?=[>+~]|$)/g, '$1 * ').trim(); if (!s) s = '*'; if (/^[>+~]/.test(s)) s = '* ' + s; return s; };
      const hit = [], err = [];
      for (const sel of sels) { try { if (document.querySelector(strip(sel))) hit.push(sel); } catch (e) { err.push(sel); hit.push(sel); } }
      return { hit, err };
    }, sels);
    r.hit.forEach(s => used[s] = (used[s] || 0) + 1); r.err.forEach(s => bad.add(s));
  }
  await ctx.close();
}
fs.writeFileSync(BS + 'used.json', JSON.stringify(used, null, 0));
console.log('selectors used', Object.keys(used).length, 'of', sels.length, '| unparseable (kept)', bad.size, [...bad].slice(0, 8));
await b.close();
