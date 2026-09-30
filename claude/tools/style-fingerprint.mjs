import { chromium } from '/opt/node22/lib/node_modules/playwright/index.mjs';
import fs from 'fs'; import crypto from 'crypto';
const tag=process.argv[2];
const pages={svc:['services/','.rl-svc'],aiso:['services/ai-search-optimization/','.rl-aiso'],geo:['services/generative-engine-optimization/','.rl-geo'],llm:['services/llm-optimization/','.rl-llm'],tseo:['services/technical-seo-services/','.rl-tseo'],intl:['services/international-seo/','.rl-intl'],local:['services/local-seo/','.rl-local'],audit:['services/seo-ai-search-audit/','.rl-audit'],ent:['services/enterprise-seo-strategy/','.rl-ent'],pr:['services/press-release-services/','.rl-pr'],seo:['services/best-search-engine-optimization-services/','.rl-seo'],sc:['services/seo-content-systems/','.rl-sc'],ma:['services/marketing-automation/','.rl-ma'],lg:['services/lead-generation-systems/','.rl-lg'],aw:['services/ai-workflow-automation/','.rl-aw'],ex:['services/executive-ai-consulting/','.rl-ex'],wpd:['services/wordpress-website-design-service/','.rl-wpd'],ecd:['services/ecommerce-website-design-service/','.rl-ec']};
const props=['display','position','width','height','margin','padding','font-family','font-size','font-weight','line-height','letter-spacing','text-transform','color','background-color','background-image','border','border-left','box-shadow','grid-template-columns','gap','justify-content','align-items','opacity','text-align','max-width','flex-direction','list-style-type','backdrop-filter','outline','fill','stroke','stroke-width','animation-name','transform','white-space','overflow-x'];
const b = await chromium.launch({proxy:{server:process.env.HTTPS_PROXY}});
const ctx = await b.newContext({ignoreHTTPSErrors:true,reducedMotion:'reduce'});
await ctx.route('**/*', async route => {
  const req=route.request(), url=req.url();
  if (/stats\.wp\.com|pixel\.wp\.com/.test(url)) return route.abort();
  const fresh = req.resourceType()==='document' || /reinforce-kit\.css/.test(url);
  const key='rcache/'+crypto.createHash('md5').update(url.replace(/[?&]nc=\d+/,'')).digest('hex');
  if (!fresh && fs.existsSync(key+'.b')) { const m=JSON.parse(fs.readFileSync(key+'.h')); return route.fulfill({status:m.s,headers:m.h,body:fs.readFileSync(key+'.b')}); }
  for (let t=0;t<6;t++) { try { const r=await route.fetch({timeout:30000}); const body=await r.body(); if (r.status()<500) { if(!fresh){fs.writeFileSync(key+'.b',body);fs.writeFileSync(key+'.h',JSON.stringify({s:r.status(),h:r.headers()}));} return route.fulfill({response:r,body}); } } catch(e){} }
  return route.abort();
});
const out={};
for (const [k,[path,sel]] of Object.entries(pages)) for (const vw of [1440,390]) {
  let ok=false;
  for (let t=0;t<4&&!ok;t++){ try{
    const p = await ctx.newPage(); await p.setViewportSize({width:vw,height:900});
    await p.goto('https://reinforcelab.online/'+path+'?nc='+Date.now(),{waitUntil:'load',timeout:120000}); await p.evaluate(()=>document.fonts.ready); await p.waitForTimeout(400);
    out[k+'@'+vw]=await p.evaluate(([sel,props])=>{const root=document.querySelector(sel);const els=[root,...root.querySelectorAll('*')];return els.map((e,i)=>{const cs=getComputedStyle(e);const r=e.getBoundingClientRect();return [i,e.tagName+'.'+(e.getAttribute('class')||'').replace(/\brl-page\b ?/,''),props.map(p=>cs.getPropertyValue(p)).join('|'),Math.round(r.x)+','+Math.round(r.y)+','+Math.round(r.width)+','+Math.round(r.height)];});},[sel,props]);
    if (k==='svc'&&vw===1440) out.kit=await p.evaluate(()=>[...document.querySelectorAll('link[rel=stylesheet]')].map(l=>l.id+' '+l.href).filter(h=>/kit/.test(h)));
    await p.close(); ok=true; } catch(e){ console.log('retry',k,vw,e.message.slice(0,60)); } }
  console.log(k,vw,ok?out[k+'@'+vw].length:'FAIL');
}
fs.writeFileSync('fp-'+tag+'.json',JSON.stringify(out)); await b.close();
