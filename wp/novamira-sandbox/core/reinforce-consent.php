<?php
/**
 * Plugin Name: Reinforce Lab - Cookie choice and analytics
 * Description: The cookie choice the Privacy Policy describes (F-028 C7): on the first visit a bar asks whether the visitor accepts analytics cookies (Google Analytics 4). Nothing analytics-related loads until "Accept"; "Decline" sets nothing and removes any _ga cookies. A Global Privacy Control signal counts as decline. "Cookie settings" in the footer reopens the choice. The choice is kept in local storage (rl_consent) for 6 months, then asked again. GA4 loads only when the option rl_ga4_id holds a measurement ID (G-XXXXXXX). Jetpack Stats is not affected: it sets no cookies and runs on legitimate interest, as the policy says. No plugin, no external script until consent; fixed position, so no layout shift.
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_ga4_id() {
    $id = trim((string) get_option('rl_ga4_id', ''));
    return preg_match('/^G-[A-Z0-9]{4,16}$/', $id) ? $id : '';
}

add_action('wp_footer', function () {
    if (is_admin() || is_feed() || (function_exists('is_customize_preview') && is_customize_preview())) return;
    $privacy = function_exists('rl_url_by_path') ? rl_url_by_path('privacy-policy', home_url('/privacy-policy/')) : home_url('/privacy-policy/'); ?>
<style id="rl-consent-css">
.rl-consent{position:fixed;left:16px;right:16px;bottom:16px;z-index:9999;max-width:860px;margin:0 auto;display:grid;grid-template-columns:minmax(0,1fr) auto;gap:16px 24px;align-items:center;padding:18px 20px;background:rgba(18,16,17,.94);backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);border:1px solid var(--red-line,#5a1a1a);box-shadow:0 24px 60px -20px rgba(0,0,0,.9);font-family:var(--f-body,'IBM Plex Sans',sans-serif);color:var(--ink-dim,#bcb2a9);font-size:14.5px;line-height:1.55}
.rl-consent[hidden]{display:none}
.rl-consent b{display:block;font-family:var(--f-display,Oswald,sans-serif);text-transform:uppercase;letter-spacing:.04em;font-weight:600;font-size:15px;color:var(--ink,#f3ede6);margin-bottom:4px}
.rl-consent p{margin:0}
.rl-consent a{color:var(--ink,#f3ede6);border-bottom:1px solid var(--red-line,#5a1a1a)}
.rl-consent .gpc{display:block;margin-top:6px;font-family:var(--f-mono,'IBM Plex Mono',monospace);font-size:12px;letter-spacing:.06em;color:var(--red-3,#e85050)}
.rl-consent .gpc[hidden]{display:none}
.rl-consent .act{display:flex;gap:10px;flex-wrap:wrap}
.rl-consent button{font-family:var(--f-display,Oswald,sans-serif);text-transform:uppercase;letter-spacing:.05em;font-weight:600;font-size:14px;padding:13px 20px;min-height:44px;border:1px solid var(--line-2,#3a3130);background:transparent;color:var(--ink,#f3ede6);cursor:pointer;border-radius:0}
.rl-consent button:hover,.rl-consent button:focus-visible{border-color:var(--red-2,#c11414);color:#fff}
@media(max-width:640px){.rl-consent{grid-template-columns:1fr;left:10px;right:10px;bottom:10px;padding:16px}.rl-consent .act button{flex:1}}
</style>
<div class="rl-consent" id="rl-consent" role="region" aria-label="Cookie choice" hidden>
  <p><b>Analytics cookies</b>We would like to use Google Analytics cookies to see how this website is used, in totals. They are set only if you accept, and the website works the same either way. <a href="<?php echo esc_url($privacy); ?>#cookies">Privacy policy</a><span class="gpc" hidden>Your browser sends a Global Privacy Control signal, so analytics stay off unless you accept here.</span></p>
  <div class="act"><button type="button" data-rl-choice="denied">Decline</button><button type="button" data-rl-choice="granted">Accept analytics</button></div>
</div>
<script>
(function(){
  var K='rl_consent', MAX=182*864e5, GA=<?php echo wp_json_encode(rl_ga4_id()); ?>, bar=document.getElementById('rl-consent');
  if(!bar) return;
  var gpc=navigator.globalPrivacyControl===true;
  function get(){try{var v=localStorage.getItem(K),t=+localStorage.getItem(K+'_at');return v&&t&&Date.now()-t<MAX?v:null}catch(e){return null}}
  function put(v){try{localStorage.setItem(K,v);localStorage.setItem(K+'_at',String(Date.now()))}catch(e){}}
  function loadGa(){
    if(!GA||window.__rlGa) return; window.__rlGa=1;
    window.dataLayer=window.dataLayer||[]; window.gtag=function(){dataLayer.push(arguments)};
    gtag('js',new Date()); gtag('config',GA,{anonymize_ip:true});
    var s=document.createElement('script'); s.async=true; s.src='https://www.googletagmanager.com/gtag/js?id='+encodeURIComponent(GA); document.head.appendChild(s);
  }
  function dropGa(){
    var host=location.hostname, root=host.split('.').slice(-2).join('.');
    document.cookie.split(';').forEach(function(c){var n=c.split('=')[0].trim(); if(!/^_ga/.test(n)) return;
      ['', ';domain='+host, ';domain=.'+root].forEach(function(d){document.cookie=n+'=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/'+d});});
  }
  function show(){bar.querySelector('.gpc').hidden=!gpc; bar.hidden=false;}
  function choose(v){put(v); bar.hidden=true; if(v==='granted') loadGa(); else dropGa();}
  bar.addEventListener('click',function(e){var b=e.target.closest('[data-rl-choice]'); if(b) choose(b.getAttribute('data-rl-choice'));});
  document.addEventListener('click',function(e){var o=e.target.closest('[data-rl-consent-open]'); if(o){e.preventDefault(); show(); var f=bar.querySelector('button'); if(f) f.focus();}});
  document.addEventListener('keydown',function(e){if(e.key==='Escape'&&!bar.hidden&&get()) bar.hidden=true;});
  var v=get();
  if(v==='granted') loadGa();
  else if(!v){ if(gpc) put('denied'); else show(); }
})();
</script>
<?php
}, 50);
