// Screenshots and phone-width checks for reinforcelab.online (Playwright, Chromium preinstalled).
//
//   node claude/tools/shot.mjs width <path> [<path> ...]          page width at 390 px (must equal 390), e.g. blog/ about-us/
//   node claude/tools/shot.mjs page <path> <out-prefix>           desktop (1440) + phone (390) full-page JPEGs of a live page
//   node claude/tools/shot.mjs html <file.html> <out-prefix>      same, for HTML from `rl.py preview-post` (served as if on .online)
//   node claude/tools/shot.mjs sections <path> <out-prefix> [css]  one JPEG per section (default `.rl-page > section`), desktop and phone, for review
//
// The dev-site proxy drops random assets, so every static asset is cached in claude/tools/.cache/
// on first fetch (with retries) and replayed. Only the HTML document is fetched fresh.
import { chromium } from '/opt/node22/lib/node_modules/playwright/index.mjs';
import fs from 'fs'; import crypto from 'crypto'; import path from 'path'; import { fileURLToPath } from 'url';

const SITE = 'https://reinforcelab.online/';
const CACHE = path.join(path.dirname(fileURLToPath(import.meta.url)), '.cache');
fs.mkdirSync(CACHE, { recursive: true });
const [mode, ...args] = process.argv.slice(2);
const b = await chromium.launch({ proxy: process.env.HTTPS_PROXY ? { server: process.env.HTTPS_PROXY } : undefined });
let previewHtml = null;

async function page(w, h, dsf) {
  const ctx = await b.newContext({ ignoreHTTPSErrors: true, viewport: { width: w, height: h }, deviceScaleFactor: dsf, reducedMotion: 'reduce' });
  await ctx.route('**/*', async route => {
    const req = route.request(), url = req.url();
    if (previewHtml && url === SITE + '__preview') return route.fulfill({ status: 200, contentType: 'text/html', body: previewHtml });
    if (/stats\.wp\.com|pixel\.wp\.com/.test(url)) return route.abort();
    const fresh = req.resourceType() === 'document';
    const key = path.join(CACHE, crypto.createHash('md5').update(url.replace(/[?&]nc=\d+/, '')).digest('hex'));
    if (!fresh && fs.existsSync(key + '.b')) { const m = JSON.parse(fs.readFileSync(key + '.h')); return route.fulfill({ status: m.s, headers: m.h, body: fs.readFileSync(key + '.b') }); }
    for (let t = 0; t < 6; t++) {
      try { const r = await route.fetch({ timeout: 30000 }); const body = await r.body();
        if (r.status() < 500) { if (!fresh) { fs.writeFileSync(key + '.b', body); fs.writeFileSync(key + '.h', JSON.stringify({ s: r.status(), h: r.headers() })); } return route.fulfill({ response: r, body }); }
      } catch (e) {}
    }
    return route.abort();
  });
  return ctx.newPage();
}
async function open(p, url) {
  for (let t = 0; t < 3; t++) { try { await p.goto(url, { waitUntil: 'load', timeout: 120000 }); await p.evaluate(() => document.fonts.ready); await p.waitForTimeout(600); return true; } catch (e) {} }
  return false;
}

if (mode === 'width') {
  const p = await page(390, 844, 1);
  let bad = 0;
  for (const u of args) { const ok = await open(p, SITE + u.replace(/^\//, '') + '?nc=' + Date.now()); const w = ok ? await p.evaluate(() => document.documentElement.scrollWidth) : 'err'; if (w !== 390) bad++; console.log(u, w); }
  await b.close(); process.exit(bad ? 1 : 0);
}
if (mode === 'page' || mode === 'html') {
  const [src, out] = args;
  let url = SITE + src.replace(/^\//, '') + '?nc=' + Date.now();
  if (mode === 'html') { previewHtml = fs.readFileSync(src, 'utf8'); url = SITE + '__preview'; }
  for (const [w, h, dsf, tag] of [[1440, 900, 1, 'desktop'], [390, 844, 2, 'phone']]) {
    const p = await page(w, h, dsf);
    if (!(await open(p, url))) { console.log(tag, 'load failed'); continue; }
    console.log(tag, 'width', await p.evaluate(() => document.documentElement.scrollWidth));
    await p.screenshot({ path: `${out}-${tag}.jpg`, type: 'jpeg', quality: 75, fullPage: true });
  }
  await b.close(); process.exit(0);
}
if (mode === 'sections') {
  const [src, out, sel = '.rl-page > section'] = args;
  for (const [w, h, dsf, tag] of [[1440, 900, 0.6, 'd'], [390, 844, 1, 'm']]) {
    const p = await page(w, h, dsf);
    if (!(await open(p, SITE + src.replace(/^\//, '') + '?nc=' + Date.now()))) { console.log(tag, 'load failed'); continue; }
    const s = p.locator(sel), n = await s.count();
    for (let i = 0; i < n; i++) await s.nth(i).screenshot({ path: `${out}-${tag}${i}.jpg`, type: 'jpeg', quality: 70 });
    console.log(tag, n, 'sections');
  }
  await b.close(); process.exit(0);
}
console.log('usage: node claude/tools/shot.mjs width|page|html|sections ...'); await b.close(); process.exit(2);
