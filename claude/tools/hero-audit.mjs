// Hero audit (F-024): measures each page's hero (H1 size, case, lines, padding, text column vs visual panel edges).
//   node claude/tools/hero-audit.mjs <paths.txt> <out.json> [width=1440] [shot-dir]
// paths.txt: one page path per line ('' = home), e.g. from claude/data/online-snapshot/pages.json.
import { chromium } from '/opt/node22/lib/node_modules/playwright/index.mjs';
import fs from 'fs'; import crypto from 'crypto'; import path from 'path'; import { fileURLToPath } from 'url';
const SITE = 'https://reinforcelab.online/';
const CACHE = path.join(path.dirname(fileURLToPath(import.meta.url)), '.cache');
const [listFile, outFile, W = '1440', shotDir = ''] = process.argv.slice(2);
const paths = fs.readFileSync(listFile, 'utf8').split('\n');
const b = await chromium.launch({ proxy: process.env.HTTPS_PROXY ? { server: process.env.HTTPS_PROXY } : undefined });
const ctx = await b.newContext({ ignoreHTTPSErrors: true, viewport: { width: +W, height: 900 }, deviceScaleFactor: 1, reducedMotion: 'reduce' });
await ctx.route('**/*', async route => {
  const req = route.request(), url = req.url();
  if (/stats\.wp\.com|pixel\.wp\.com/.test(url)) return route.abort();
  const fresh = req.resourceType() === 'document';
  const key = path.join(CACHE, crypto.createHash('md5').update(url.replace(/[?&]nc=\d+/, '')).digest('hex'));
  if (!fresh && fs.existsSync(key + '.b')) { const m = JSON.parse(fs.readFileSync(key + '.h')); return route.fulfill({ status: m.s, headers: m.h, body: fs.readFileSync(key + '.b') }); }
  for (let t = 0; t < 6; t++) { try { const r = await route.fetch({ timeout: 30000 }); const body = await r.body(); if (r.status() < 500) { if (!fresh) { fs.writeFileSync(key + '.b', body); fs.writeFileSync(key + '.h', JSON.stringify({ s: r.status(), h: r.headers() })); } return route.fulfill({ response: r, body }); } } catch (e) {} }
  return route.abort();
});
const p = await ctx.newPage();
const res = [];
for (const pth of paths) {
  let ok = false;
  for (let t = 0; t < 3 && !ok; t++) { try { await p.goto(SITE + (pth ? pth + '/' : '') + '?nc=' + Date.now(), { waitUntil: 'load', timeout: 120000 }); await p.evaluate(() => document.fonts.ready); await p.waitForTimeout(900); ok = true; } catch (e) {} }
  if (!ok) { res.push({ path: pth, error: 'load' }); continue; }
  const m = await p.evaluate(() => {
    const R = e => { if (!e) return null; const r = e.getBoundingClientRect(); return { x: Math.round(r.left), y: Math.round(r.top + scrollY), w: Math.round(r.width), h: Math.round(r.height) }; };
    const cs = (e, k) => e ? getComputedStyle(e)[k] : null;
    const hero = document.querySelector('.rl-page .hero') || document.querySelector('section.hero') || document.querySelector('[class*=hero]');
    const h1 = document.querySelector('h1');
    const grid = hero && (hero.querySelector('.hero-grid') || hero.querySelector('[class*=grid]'));
    const kids = grid ? [...grid.children].filter(c => c.getBoundingClientRect().height > 20) : [];
    const textCol = kids.find(c => c.contains(h1)) || null;
    const viz = kids.find(c => c !== textCol) || null;
    const lede = hero && (hero.querySelector('.lede') || (h1 && h1.parentElement.querySelector('p')));
    const ey = hero && hero.querySelector('.ey');
    const cta = hero && hero.querySelector('.cta-row, .hero-cta');
    const btn = cta && cta.querySelector('a');
    const crumbs = document.querySelector('.crumbs');
    const logo = document.querySelector('header a img, header .logo, .rl-header a');
    const header = document.querySelector('header, .rl-header');
    return {
      heroClass: hero ? hero.className : null, hero: R(hero), heroPadT: cs(hero, 'paddingTop'), heroPadB: cs(hero, 'paddingBottom'),
      header: R(header), crumbs: R(crumbs),
      h1: R(h1), h1fs: cs(h1, 'fontSize'), h1lh: cs(h1, 'lineHeight'), h1ls: cs(h1, 'letterSpacing'), h1ff: (cs(h1, 'fontFamily') || '').split(',')[0], h1fw: cs(h1, 'fontWeight'), h1tt: cs(h1, 'textTransform'), h1mt: cs(h1, 'marginTop'), h1text: h1 ? h1.innerText.replace(/\s+/g, ' ').slice(0, 80) : null,
      ey: R(ey), eyText: ey ? ey.innerText.replace(/\s+/g, ' ') : null,
      lede: R(lede), ledefs: cs(lede, 'fontSize'), ledelh: cs(lede, 'lineHeight'), ledeMax: cs(lede, 'maxWidth'), ledeMt: cs(lede, 'marginTop'),
      cta: R(cta), btn: R(btn), btnfs: cs(btn, 'fontSize'),
      gridCols: cs(grid, 'gridTemplateColumns'), gridAlign: cs(grid, 'alignItems'), gridGap: cs(grid, 'columnGap'),
      text: R(textCol), viz: R(viz), vizClass: viz ? (viz.className || viz.tagName) : null,
      wrapX: (() => { const w = hero && hero.querySelector('.wrap'); return w ? Math.round(w.getBoundingClientRect().left + parseFloat(getComputedStyle(w).paddingLeft)) : null; })(),
      scrollW: document.documentElement.scrollWidth,
    };
  });
  res.push({ path: pth, ...m });
  if (shotDir) { const hero = await p.$('.rl-page .hero, section.hero'); if (hero) await hero.screenshot({ path: `${shotDir}/${(pth || 'home').replace(/\//g, '_')}.jpg`, type: 'jpeg', quality: 60 }).catch(() => {}); }
  process.stdout.write('.');
}
fs.writeFileSync(outFile, JSON.stringify(res, null, 1)); console.log('\n', res.length); await b.close();
