// Renders on-brand post cover images (1200x630 JPEG) from a JSON job list. Development use only (D-251).
//   node claude/tools/covers.mjs <jobs.json> <outdir>
// jobs.json: [{ "id": 355, "eyebrow": "GUIDE", "white": "Social media management", "red": "What it is and how to do it" }]
// Design: dark #121011 ground, red glow, dashed rails, white logo, Oswald title (last part in red), mono eyebrow,
// a row of thin cells along the bottom with two red tiles placed from the post id. No photos, no emoji, no dashes.
import { chromium } from '/opt/node22/lib/node_modules/playwright/index.mjs';
import fs from 'fs';
import path from 'path';

const [jobsFile, outDir] = process.argv.slice(2);
const jobs = JSON.parse(fs.readFileSync(jobsFile, 'utf8'));
fs.mkdirSync(outDir, { recursive: true });
const SITE = 'https://reinforcelab.online/wp-content/uploads/reinforce-fonts/';
const FONTS = [
  ['Oswald', '200 700', 'oswald-latin.woff2'],
  ['IBM Plex Sans', '100 700', 'ibm-plex-sans-latin.woff2'],
  ['IBM Plex Mono', '400', 'ibm-plex-mono-latin-400.woff2'],
];

const b = await chromium.launch({ proxy: process.env.HTTPS_PROXY ? { server: process.env.HTTPS_PROXY } : undefined });
const ctx0 = await b.newContext({ ignoreHTTPSErrors: true });
let css = '';
for (const [fam, wt, file] of FONTS) {
  const r = await ctx0.request.get(SITE + file);
  if (!r.ok()) throw new Error('font ' + file + ' ' + r.status());
  css += `@font-face{font-family:'${fam}';font-weight:${wt};font-style:normal;src:url(data:font/woff2;base64,${(await r.body()).toString('base64')}) format('woff2')}\n`;
}
const lr = await ctx0.request.get('https://reinforcelab.online/wp-content/uploads/2026/09/Official-Reinforce-Logo-White-Version.png.webp');
const logo = 'data:image/webp;base64,' + (await lr.body()).toString('base64');
await ctx0.close();

const esc = s => String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/\S+-\S+/g, m => `<span class="nb">${m}</span>`);
function cells(id) {
  const n = 14, a = (id * 7) % n, c = (id * 11 + 5) % n;
  let h = '';
  for (let i = 0; i < n; i++) h += `<i class="${i === a || i === c ? 'r' : ''}"></i>`;
  return h;
}
function html(j) {
  const A = j.accent || { c: '#c11414', e: '#e85050', t: '#990000', g: '153,0,0' };
  return `<!doctype html><html><head><meta charset="utf-8"><style>${css}
*{box-sizing:border-box;margin:0}
body{width:1200px;height:630px;background:#121011;color:#f3ede6;font-family:'IBM Plex Sans',sans-serif;position:relative;overflow:hidden}
.glow{position:absolute;right:-180px;top:-220px;width:720px;height:720px;background:radial-gradient(circle,rgba(${A.g},${j.glow ?? .42}),rgba(${A.g},0) 65%)}
.rail{position:absolute;left:56px;top:0;bottom:0;border-left:1px dashed #3a3130}.rail2{position:absolute;right:56px;top:0;bottom:0;border-left:1px dashed #3a3130}
.logo{position:absolute;left:96px;top:44px;height:34px}
.ey{position:absolute;left:96px;top:122px;font-family:'IBM Plex Mono',monospace;font-size:20px;letter-spacing:.18em;color:${A.e};text-transform:uppercase}
h1{position:absolute;left:96px;top:168px;width:1010px;height:330px;font-family:'Oswald',sans-serif;font-weight:600;text-transform:uppercase;line-height:1.04;letter-spacing:.005em;overflow:hidden}
h1 span.r{color:${A.c};display:block}
h1 span.k{color:${A.c}}
h1 .nb{white-space:nowrap}
h1,h1 span.r{text-wrap:balance}
.row{position:absolute;left:96px;right:96px;bottom:52px;height:34px;display:flex;gap:6px}
.row i{flex:1;border:1px solid #3a3130;background:#1a1516}
.row i.r{background:${A.t};border-color:${A.t}}
</style></head><body><div class="glow"></div><div class="rail"></div><div class="rail2"></div>
<img class="logo" src="${logo}"><div class="ey">[ ${esc(j.eyebrow)} ]</div>
<h1 id="t">${j.mono ? esc(j.white + (j.red ? ': ' + j.red : '')) : j.hl ? esc(j.white + (j.red ? ': ' + j.red : '')).replace(esc(j.hl), `<span class="k">${esc(j.hl)}</span>`) : esc(j.white) + (j.red ? `<span class="r">${esc(j.red)}</span>` : '')}</h1>
<div class="row">${cells(j.id)}</div></body></html>`;
}

const c = await b.newContext({ ignoreHTTPSErrors: true, viewport: { width: 1200, height: 630 }, deviceScaleFactor: 1 });
const p = await c.newPage();
for (const j of jobs) {
  await p.setContent(html(j), { waitUntil: 'load' });
  await p.evaluate(() => document.fonts.ready);
  const size = await p.evaluate(() => { const t = document.getElementById('t'); let s = 100; t.style.fontSize = s + 'px';
    while (t.scrollHeight > t.clientHeight && s > 40) { s -= 3; t.style.fontSize = s + 'px'; } return s; });
  await p.waitForTimeout(150);
  const out = path.join(outDir, `cover-${j.id}.jpg`);
  await p.screenshot({ path: out, type: 'jpeg', quality: 88 });
  console.log(j.id, 'font', size, out);
}
await b.close();
