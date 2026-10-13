// Renders company-profile.html to Reinforce-Lab-Company-Profile.pdf (A4 landscape) and page previews.
// Usage: node claude/content/company-profile/render.mjs [--png]
import { chromium } from '/opt/node22/lib/node_modules/playwright/index.mjs';
import path from 'path'; import { fileURLToPath } from 'url';
const dir = path.dirname(fileURLToPath(import.meta.url));
const b = await chromium.launch();
const p = await b.newPage({ viewport: { width: 1123, height: 794 } });
await p.goto('file://' + path.join(dir, 'company-profile.html'), { waitUntil: 'load' });
await p.evaluate(() => document.fonts.ready);
const fonts = await p.evaluate(() => [...document.fonts].filter(f => f.status === 'loaded').map(f => f.family + ' ' + f.weight));
console.log('fonts loaded:', fonts.join(', '));
const over = await p.evaluate(() => [...document.querySelectorAll('.pg')].map((s, i) => { const f = s.querySelector('.foot'); const kids = [...s.children].filter(c => c !== f); const bottom = Math.max(...kids.map(c => c.getBoundingClientRect().bottom)); return f && bottom > f.getBoundingClientRect().top + 1 ? i + 1 : null; }).filter(Boolean));
console.log('pages where content runs into the footer:', over.length ? over : 'none');
await p.pdf({ path: path.join(dir, 'Reinforce-Lab-Company-Profile.pdf'), width: '297mm', height: '210mm', printBackground: true, preferCSSPageSize: true });
if (process.argv.includes('--png')) { const n = await p.evaluate(() => document.querySelectorAll('.pg').length); for (let i = 0; i < n; i++) { const el = (await p.$$('.pg'))[i]; await el.screenshot({ path: path.join(process.env.OUT || dir, `profile-p${i + 1}.png`) }); } }
await b.close();
