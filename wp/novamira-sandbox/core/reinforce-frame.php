<?php
/**
 * Plugin Name: Reinforce Lab Frame Background (draft)
 * Description: DRAFT background that replaces the removed grid (D-200, D-202). Preview only: it runs when the page address has ?bg=frame, and keeps that on links inside the site so a reviewer can browse. Without it the site is unchanged. Two dashed side rails frame the content, every section join gets a full-width rule with square markers on the rails, the hero ends in a band of cells with red textured tiles, and a red line on the left rail shows reading progress. Scroll effects are off for people who turn off motion.
 */
if (!defined('ABSPATH')) exit;

function rl_frame_on() {
    return !is_admin() && isset($_GET['bg']) && $_GET['bg'] === 'frame';
}

add_action('wp_head', function () {
    if (!rl_frame_on()) return;
    // Red noise texture for the hero tiles (SVG turbulence, no image file).
    $noise = "data:image/svg+xml;utf8," . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" width="160" height="160"><filter id="n"><feTurbulence type="fractalNoise" baseFrequency=".9" numOctaves="2" stitchTiles="stitch"/><feColorMatrix values="0 0 0 0 .75  0 0 0 0 .05  0 0 0 0 .05  0 0 0 .9 0"/></filter><rect width="160" height="160" filter="url(#n)"/></svg>');
    ?>
<style id="rl-frame-css">
#rl-frame{position:absolute;left:0;top:0;right:0;height:0;pointer-events:none;z-index:3;overflow:hidden;contain:strict}
#rl-frame .fr-rail{position:absolute;top:0;bottom:0;width:0;border-left:1px dashed rgba(243,237,230,.13)}
#rl-frame .fr-h{position:absolute;left:0;right:0;height:1px;background:linear-gradient(90deg,rgba(243,237,230,.05),rgba(243,237,230,.12) 12%,rgba(243,237,230,.12) 88%,rgba(243,237,230,.05));transform:scaleX(0);transform-origin:50% 50%;transition:transform 1.1s cubic-bezier(.2,.7,.1,1)}
#rl-frame .fr-h.on{transform:scaleX(1)}
#rl-frame .fr-h::after{content:"";position:absolute;top:-1px;left:-180px;width:180px;height:3px;background:linear-gradient(90deg,rgba(180,20,20,0),var(--red-2,#b41414),rgba(180,20,20,0));opacity:0}
#rl-frame .fr-h.on::after{animation:rlFrSweep 1.8s .4s cubic-bezier(.5,0,.3,1) 1 both}
@keyframes rlFrSweep{0%{left:-180px;opacity:0}12%{opacity:1}85%{opacity:1}100%{left:100%;opacity:0}}
#rl-frame .fr-sq{position:absolute;width:9px;height:9px;margin:-4px 0 0 -4px;border:1px solid rgba(243,237,230,.3);background:var(--bg,#121011);transition:border-color .6s}
#rl-frame .fr-sq.on{border-color:var(--red-2,#b41414);animation:rlFrSq 1.4s ease-out 1 both}
@keyframes rlFrSq{0%{background:var(--bg,#121011)}18%{background:var(--red,#990000)}100%{background:var(--bg,#121011)}}
#rl-frame .fr-band{position:absolute;display:grid;border-top:1px dashed rgba(243,237,230,.13)}
#rl-frame .fr-cell{position:relative;border-left:1px dashed rgba(243,237,230,.13)}
#rl-frame .fr-cell:first-child{border-left:0}
#rl-frame .fr-tile{position:absolute;inset:10px;opacity:0;background-image:url("<?php echo $noise; ?>"),linear-gradient(135deg,rgba(153,0,0,.75),rgba(90,0,0,.35) 60%,rgba(40,0,0,.2));background-size:160px 160px,100% 100%;will-change:opacity,transform}
#rl-frame .fr-tile.k{opacity:.9}
#rl-prog{position:fixed;top:0;width:1px;height:0;pointer-events:none;z-index:1;background:linear-gradient(180deg,rgba(153,0,0,0),var(--red-2,#b41414))}
#rl-prog::after{content:"";position:absolute;left:-3px;bottom:-3px;width:7px;height:7px;background:var(--red-2,#b41414)}
@media(prefers-reduced-motion:reduce){#rl-frame .fr-h{transform:none;transition:none}#rl-frame .fr-h.on::after{animation:none}#rl-frame .fr-sq.on{animation:none}#rl-prog{display:none}}
</style>
<?php
}, 99);

add_action('wp_footer', function () {
    if (!rl_frame_on()) return;
    ?>
<script id="rl-frame-js">
(function(){
  var reduce=window.matchMedia&&matchMedia('(prefers-reduced-motion: reduce)').matches;
  // keep the preview on while browsing the site
  document.querySelectorAll('a[href^="/"],a[href*="reinforcelab.online"]').forEach(function(a){try{var u=new URL(a.href,location.href);if(u.host!==location.host||u.hash&&u.pathname===location.pathname)return;u.searchParams.set('bg','frame');a.href=u.toString();}catch(e){}});
  var root=document.createElement('div');root.id='rl-frame';root.setAttribute('aria-hidden','true');document.body.insertBefore(root,document.body.firstChild);
  var prog=document.createElement('div');prog.id='rl-prog';prog.setAttribute('aria-hidden','true');document.body.appendChild(prog);
  var joins=[],tiles=[],hero=null,heroTop=0,heroH=1,railL=0,io=null;
  function sections(){var m=document.querySelector('.rl-page,.rl-home');return m?[].slice.call(m.children).filter(function(e){return e.tagName==='SECTION'&&e.offsetHeight>0;}):[];}
  function build(){
    root.textContent='';joins=[];tiles=[];if(io)io.disconnect();
    var secs=sections();if(!secs.length)return;
    var docH=document.documentElement.scrollHeight,vw=document.documentElement.clientWidth;
    // phone: the hero has no spare room, so give it just enough for the tile band (preview only)
    if(vw<700){var h0=secs[0];if(!h0.dataset.frPb)h0.dataset.frPb=getComputedStyle(h0).paddingBottom;h0.style.paddingBottom=h0.dataset.frPb;
      var r0=h0.getBoundingClientRect(),lo=r0.top;[].slice.call(h0.querySelectorAll('.wrap > *')).forEach(function(c){var bb=c.getBoundingClientRect().bottom;if(bb>lo)lo=bb;});
      var f0=r0.bottom-lo-12;if(f0<84){h0.style.paddingBottom=(parseFloat(h0.dataset.frPb)+84-Math.max(0,f0))+'px';docH=document.documentElement.scrollHeight;}}
    var w=secs[0].querySelector('.wrap')||secs[0];var r=w.getBoundingClientRect();var cs=getComputedStyle(w);
    var inL=r.left+parseFloat(cs.paddingLeft),inR=r.right-parseFloat(cs.paddingRight);var off=Math.max(6,Math.min(28,(inL)*.45));
    railL=Math.round(inL-off);var railR=Math.round(inR+off);
    var ft=document.querySelector('.rl-footer');var endY=ft?ft.getBoundingClientRect().top+scrollY:docH;
    root.style.height=Math.round(endY)+'px';
    [railL,railR].forEach(function(x){var d=document.createElement('div');d.className='fr-rail';d.style.left=x+'px';root.appendChild(d);});
    secs.forEach(function(s,i){
      var y=Math.round(s.getBoundingClientRect().top+scrollY);
      if(i>0){var h=document.createElement('div');h.className='fr-h';h.style.top=y+'px';root.appendChild(h);
        var q=[railL,railR].map(function(x){var e=document.createElement('div');e.className='fr-sq';e.style.left=x+'px';e.style.top=y+'px';root.appendChild(e);return e;});
        var j={el:s,h:h,q:q};if(s.dataset.frOn)on(j);joins.push(j);}
    });
    // hero band: cells in the free space at the bottom of the first section
    hero=secs[0];var hr=hero.getBoundingClientRect();heroTop=hr.top+scrollY;heroH=hr.height;
    var low=hr.top;[].slice.call(hero.querySelectorAll('.wrap > *')).forEach(function(c){var b=c.getBoundingClientRect().bottom;if(b>low)low=b;});
    var free=hr.bottom-low-12;
    var bandH=Math.min(112,free);
    if(bandH>=44){
      var n=vw<700?4:6,band=document.createElement('div');band.className='fr-band';
      band.style.cssText='left:'+railL+'px;width:'+(railR-railL)+'px;top:'+Math.round(hr.bottom+scrollY-bandH)+'px;height:'+Math.round(bandH)+'px;grid-template-columns:repeat('+n+',1fr)';
      var keep=n===6?[0,5]:[0,3];
      for(var i=0;i<n;i++){var c=document.createElement('div');c.className='fr-cell';var t=document.createElement('div');t.className='fr-tile'+(keep.indexOf(i)>-1?' k':'');c.appendChild(t);band.appendChild(c);tiles.push(t);}
      root.appendChild(band);
    }
    if('IntersectionObserver' in window&&!reduce){
      io=new IntersectionObserver(function(es){es.forEach(function(e){if(!e.isIntersecting)return;joins.forEach(function(j){if(j.el===e.target){on(j);io.unobserve(e.target);}});});},{rootMargin:'0px 0px -18% 0px'});
      joins.forEach(function(j){if(!j.el.dataset.frOn)io.observe(j.el);});
    } else joins.forEach(on);
    prog.style.left=railL+'px';
    tick();
  }
  function on(j){j.el.dataset.frOn='1';j.h.classList.add('on');j.q.forEach(function(q){q.classList.add('on');});}
  var raf=false;
  function tick(){
    raf=false;
    var y=scrollY||0,max=Math.max(1,document.documentElement.scrollHeight-innerHeight);
    if(!reduce){prog.style.height=Math.round(innerHeight*Math.min(1,y/max))+'px';
      var p=Math.max(0,Math.min(1,y/Math.max(1,heroH*.8)));
      tiles.forEach(function(t,i){var n=tiles.length,wave=Math.max(0,1-Math.abs(p*(n+1)-i-.5)),k=t.classList.contains('k');
        t.style.opacity=Math.min(.95,(k?.9-p*.5:0)+wave*.85).toFixed(3);t.style.transform='translateY('+(-p*14*(i%2?1:.6)).toFixed(1)+'px)';});}
  }
  addEventListener('scroll',function(){if(!raf){raf=true;requestAnimationFrame(tick);}},{passive:true});
  var rt;function later(){clearTimeout(rt);rt=setTimeout(build,180);}
  if(document.readyState==='complete')build();else addEventListener('load',build);
  addEventListener('resize',later);
  if('ResizeObserver' in window)new ResizeObserver(later).observe(document.body);
})();
</script>
<?php
}, 99);
