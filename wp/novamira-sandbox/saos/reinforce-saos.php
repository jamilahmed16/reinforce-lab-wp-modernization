<?php
/**
 * Plugin Name: Reinforce Lab - Search Authority OS (Systems Grid)
 * Description: Flagship product page /search-authority-os/ (design: claude/design-previews/search-authority-os-landing.html). Provides [reinforce_saos]. Relies on tokens/chrome from reinforce-header.php.
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

function rl_is_saos() { return is_page('search-authority-os'); }

/* ---------- page data (single source for markup + schema) ---------- */
function rl_saos_faqs() {
    return [
        ['Is this just an AI writer?', 'No. AI writing is the last step. Search Authority OS researches your market, verifies claims against real evidence, and monitors performance, then produces content. The intelligence is the product; the content is the output.'],
        ['Will the content actually be accurate?', 'Every important factual claim is tied to a source with a confidence score. Weak or conflicting sources are flagged for human review. In regulated fields, this is the difference between publishable and a liability.'],
        ['Does it optimize for ChatGPT and AI Overviews as well as Google?', 'Yes. AEO and GEO are built in. The system tracks where you appear across ChatGPT, Perplexity, Gemini and AI Overviews, and structures content to be cited as well as ranked.'],
        ['Do we keep control?', 'Yes. Human approval workflows and quality gates are standard. You decide what publishes automatically and what waits for review, and you can change that at any time.'],
        ['What happens first?', 'A Search Authority Diagnostic: a data-backed read of your organic visibility, AI-search presence, content authority, competitors and demand, with a prioritized 90-day plan. It establishes your real baseline before anything is built.'],
    ];
}
define('RL_SAOS_DESC', 'Search Authority OS is an AI-powered operating system from Reinforce Lab that researches your market, verifies every claim against real evidence, produces high-value content, and monitors your visibility across Google and AI search.');

/* ---------- CSS (only on this page) ---------- */
add_filter('body_class', function ($c) { if (rl_is_saos()) $c[] = 'rl-saos-page'; return $c; });
add_action('wp_head', 'rl_saos_css', 22);
function rl_saos_css() {
    if (!rl_is_saos()) return; ?>
<style id="rl-saos-css">
.rl-saos .src{font-family:var(--f-mono);font-size:12px;letter-spacing:.06em;line-height:1.7;color:var(--ink-faint);margin:16px 0 0}
.rl-saos .src a{color:var(--ink-dim);border-bottom:1px solid var(--red-line);text-decoration:none}
/* full-bleed breakout of theme container + kill content padding */
.rl-saos{position:relative;width:100vw;margin-left:calc(50% - 50vw);--r:0px;--r-lg:0px;--pill:0px;color:var(--ink);font-family:var(--f-body);font-size:16px;line-height:1.6}
body.rl-saos-page .fl-page-content,body.rl-saos-page .fl-content,body.rl-saos-page .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
.rl-saos *{box-sizing:border-box}
.rl-saos a{text-decoration:none;color:inherit}
.rl-saos p{margin:0}
.rl-saos h1,.rl-saos h2,.rl-saos h3,.rl-saos h4{font-family:var(--f-display);font-weight:600;text-transform:uppercase;margin:0;line-height:1.02;letter-spacing:.01em;text-wrap:balance;color:var(--ink)}
.rl-saos .wrap{max-width:var(--maxw);margin:0 auto;padding-inline:var(--gutter)}
.rl-saos .band{border-top:1px solid var(--line)}
.rl-saos .band.alt{background:radial-gradient(90% 60% at 15% 0%,rgba(153,0,0,.10),transparent 55%),var(--bg-2)}
.rl-saos section{position:relative}
.rl-saos .ey{font-family:var(--f-mono);font-size:12px;letter-spacing:.18em;text-transform:uppercase;color:var(--ink-faint);display:inline-flex;gap:.5em;align-items:center}
.rl-saos .ey b{color:var(--red-2);font-weight:500}
.rl-saos .lede{color:var(--ink-dim);font-size:clamp(16px,1.6vw,19px);max-width:60ch}
.rl-saos .lede a,.rl-saos .inl{color:var(--ink);border-bottom:1px solid var(--red-line)}.rl-saos .lede a:hover,.rl-saos .inl:hover{color:var(--red-3)}
.rl-saos :focus-visible{outline:2px solid var(--red-2);outline-offset:3px}
/* breadcrumb */
.rl-saos .crumbs{padding-top:clamp(18px,2.4vw,28px);font-family:var(--f-mono);font-size:12px;letter-spacing:.1em;text-transform:uppercase;color:var(--ink-faint)}
.rl-saos .crumbs ol{list-style:none;margin:0;padding:0;display:flex;flex-wrap:wrap;gap:.6em}
.rl-saos .crumbs li+li::before{content:"/";color:var(--red-2);margin-right:.6em}
.rl-saos .crumbs a:hover{color:var(--ink)}.rl-saos .crumbs [aria-current]{color:var(--ink-dim)}
/* linked cards */
.rl-saos a.cell,.rl-saos a.agent{display:block}
.rl-saos .more{display:inline-block;margin-top:14px;font-family:var(--f-mono);font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3)}
.rl-saos .cta-row{display:flex;flex-wrap:wrap;gap:14px;margin-top:28px}
.rl-saos .sr{position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(1px,1px,1px,1px);white-space:nowrap}
/* ---- ported from design preview (scoped) ---- */
.rl-saos .btn{font-family:var(--f-display);text-transform:uppercase;font-weight:600;letter-spacing:.05em; font-size:14px;padding:15px 26px;display:inline-flex;align-items:center;gap:.55em;border:1px solid transparent;cursor:pointer;transition:.2s;border-radius:var(--pill);position:relative;overflow:hidden}
.rl-saos .btn::before{content:"+";font-family:var(--f-mono);font-weight:500;color:var(--red-3);font-size:1.15em;line-height:0}
.rl-saos .btn.p{background:linear-gradient(180deg,#241a1c,#120e0f);color:#fff;border-color:var(--red-line); box-shadow:14px 0 44px -14px var(--red-glow), inset 0 1px 0 var(--glass-hi)}
.rl-saos .btn.p:hover{border-color:var(--red-2);box-shadow:20px 0 60px -12px var(--red-glow), inset 0 1px 0 var(--glass-hi);transform:translateY(-1px)}
.rl-saos .btn.g{background:var(--glass);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px);color:var(--ink);border-color:var(--glass-line)}
.rl-saos .btn.g::before{color:var(--ink-faint)}
.rl-saos .btn.g:hover{border-color:var(--red-line);color:#fff}
.rl-saos .btn .ar{transition:transform .2s}
.rl-saos .btn:hover .ar{transform:translateX(4px)}
/* hero matches the kit hero on every other page (F-024): padding, grid, H1, lede; the loop panel stretches to the text column */
.rl-saos .hero{padding-block:clamp(36px,6vw,80px)}
.rl-saos .hero-grid{display:grid;grid-template-columns:1.02fr .98fr;gap:clamp(28px,4vw,56px);align-items:stretch;width:100%}
@media(max-width:940px){.rl-saos .hero-grid{grid-template-columns:1fr;gap:34px}}
.rl-saos .h1{font-size:clamp(34px,5.1vw,64px);font-weight:700;letter-spacing:-.01em;line-height:1.02;margin-top:14px}
.rl-saos .h1 .r{color:var(--red-2);display:block}
@media(min-width:768px){.rl-saos .h1 .r{white-space:nowrap}}
.rl-saos .hero .lede{margin-top:18px}
.rl-saos .hero-cta{display:flex;flex-wrap:wrap;gap:14px;margin-top:24px}
.rl-saos .microtrust{margin-top:18px;font-family:var(--f-mono);font-size:12px;color:var(--ink-faint);letter-spacing:.04em;line-height:1.85}
.rl-saos .microtrust b{color:var(--ink-dim);font-weight:500}
.rl-saos .engine{border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:22px}
.rl-saos .engine .cap{display:flex;justify-content:space-between;align-items:center;margin-bottom:14px}
.rl-saos .engine .cap span{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
.rl-saos .diagram{display:grid;grid-template-columns:1fr auto 1fr;gap:14px;align-items:center}
@media(max-width:520px){.rl-saos .diagram{grid-template-columns:1fr;text-align:center}}
.rl-saos .col{display:flex;flex-direction:column;gap:8px}
.rl-saos .node{border:1px solid var(--line-2);background:var(--bg);padding:9px 12px;font-family:var(--f-mono);font-size:11px;letter-spacing:.03em;color:var(--ink-dim);text-transform:uppercase}
.rl-saos .core{border:1px solid var(--red);background:linear-gradient(180deg,rgba(153,0,0,.16),rgba(153,0,0,.05)); padding:20px 16px;text-align:center;position:relative;box-shadow:0 0 46px -10px var(--red-glow)}
.rl-saos .core b{font-family:var(--f-display);text-transform:uppercase;font-weight:600;font-size:15px;display:block;letter-spacing:.04em}
.rl-saos .core small{font-family:var(--f-mono);font-size:10.5px;color:var(--ink-faint);letter-spacing:.14em}
.rl-saos .flow{position:relative;height:2px;background:var(--line-2);overflow:hidden}
.rl-saos .flow::after{content:"";position:absolute;top:0;left:-40%;width:40%;height:100%;background:linear-gradient(90deg,transparent,var(--red-2),transparent);animation:rlsaosflow 2.6s linear infinite}
@keyframes rlsaosflow{to{left:120%}}
@media(max-width:520px){.rl-saos .flow{height:22px;width:2px;margin:0 auto}
.rl-saos .flow::after{left:0;top:-40%;width:100%;height:40%;background:linear-gradient(180deg,transparent,var(--red-2),transparent);animation:rlsaosflowv 2.6s linear infinite}}
@keyframes rlsaosflowv{to{top:120%}}
@media(prefers-reduced-motion:reduce){.rl-saos .flow::after{animation:none;left:0;width:100%;opacity:.5}}
.rl-saos section{padding-block:clamp(56px,8vw,96px)}
.rl-saos .head{max-width:64ch;margin-bottom:clamp(32px,5vw,52px)}
.rl-saos .head h2{font-size:clamp(28px,4.2vw,48px);margin-top:14px}
.rl-saos .head p{margin-top:18px}
.rl-saos .cols{display:grid;gap:16px}
.rl-saos .cols.c2{grid-template-columns:repeat(2,1fr)}
.rl-saos .cols.c3{grid-template-columns:repeat(3,1fr)}
.rl-saos .cols.c4{grid-template-columns:repeat(4,1fr)}
@media(max-width:900px){.rl-saos .cols.c3,.rl-saos .cols.c4{grid-template-columns:repeat(2,1fr)}}
@media(max-width:560px){.rl-saos .cols.c2,.rl-saos .cols.c3,.rl-saos .cols.c4{grid-template-columns:1fr}}
.rl-saos .glass{background:var(--glass);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px); border:1px solid var(--glass-line);border-radius:var(--r);box-shadow:inset 0 1px 0 var(--glass-hi),0 24px 60px -40px rgba(0,0,0,.9)}
.rl-saos .cell{background:var(--glass);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px); border:1px solid var(--glass-line);border-radius:var(--r);padding:26px; box-shadow:inset 0 1px 0 var(--glass-hi),0 24px 60px -40px rgba(0,0,0,.9);transition:.2s}
.rl-saos .cell:hover{border-color:var(--red-line);background:var(--glass-2)}
.rl-saos .cell .n{font-family:var(--f-mono);font-size:12px;color:var(--red-3);letter-spacing:.1em}
.rl-saos .cell h3{font-size:20px;margin:12px 0 8px}
.rl-saos .cell p{color:var(--ink-dim);font-size:16px}
.rl-saos .pains{display:grid;grid-template-columns:1fr 1fr;gap:14px}
@media(max-width:640px){.rl-saos .pains{grid-template-columns:1fr}}
.rl-saos .pain{background:var(--glass);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid var(--glass-line);border-radius:var(--r);padding:22px 24px;display:flex;gap:16px;align-items:flex-start;box-shadow:inset 0 1px 0 var(--glass-hi)}
.rl-saos .pain .x{color:var(--red-3);font-family:var(--f-mono);flex:none;margin-top:2px}
.rl-saos .pain p{color:var(--ink-dim);font-size:16px}
.rl-saos .pain b{color:var(--ink);font-weight:600}
.rl-saos .steps{display:grid;grid-template-columns:repeat(4,1fr);gap:16px}
@media(max-width:900px){.rl-saos .steps{grid-template-columns:repeat(2,1fr)}}
@media(max-width:520px){.rl-saos .steps{grid-template-columns:1fr}}
.rl-saos .step{background:var(--glass);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid var(--glass-line);border-radius:var(--r);padding:24px;box-shadow:inset 0 1px 0 var(--glass-hi)}
.rl-saos .step .k{font-family:var(--f-display);font-size:34px;color:var(--red-3);font-weight:700;opacity:.8}
.rl-saos .step h4{font-size:16px;margin:8px 0 8px}
.rl-saos .step p{color:var(--ink-dim);font-size:16px}
.rl-saos .chain{display:flex;flex-wrap:wrap;gap:10px;align-items:stretch}
.rl-saos .chip{border:1px solid var(--glass-line);background:var(--glass);backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);border-radius:var(--r);padding:16px 18px;flex:1 1 150px;min-width:0;box-shadow:inset 0 1px 0 var(--glass-hi)}
.rl-saos .chip .t{font-family:var(--f-mono);font-size:12px;letter-spacing:.14em;color:var(--ink-faint);text-transform:uppercase}
.rl-saos .chip .v{font-family:var(--f-display);text-transform:uppercase;font-size:15px;margin-top:6px}
.rl-saos .chip.on{border-color:var(--red-2);box-shadow:inset 0 1px 0 var(--glass-hi),0 0 30px -8px var(--red-glow)}
.rl-saos .icp .cell{position:relative}
.rl-saos .icp h3{font-size:20px}
.rl-saos .icp .who{font-family:var(--f-mono);font-size:12px;color:var(--ink-faint);letter-spacing:.12em;text-transform:uppercase;margin-bottom:12px}
.rl-saos .icp ul{margin:14px 0 0;padding-left:0;list-style:none;display:grid;gap:9px}
.rl-saos .icp li{color:var(--ink-dim);font-size:16px;display:flex;gap:10px}
.rl-saos .icp li::before{content:"›";color:var(--red-2);font-family:var(--f-mono)}
.rl-saos .cmp{width:100%;border-collapse:collapse;font-size:16px}
.rl-saos .cmp th,.rl-saos .cmp td{text-align:left;padding:15px 18px;border-bottom:1px solid var(--line)}
.rl-saos .cmp thead th{font-family:var(--f-display);text-transform:uppercase;font-size:13px;letter-spacing:.05em;color:var(--ink-faint)}
.rl-saos .cmp thead th:last-child{color:var(--red-2)}
.rl-saos .cmp td:first-child{color:var(--ink-faint)}
.rl-saos .cmp td:nth-child(2){color:var(--ink-dim)}
.rl-saos .cmp td:last-child{color:var(--ink);font-weight:500}
.rl-saos .cmp-scroll{overflow-x:auto;border:1px solid var(--line)}
.rl-saos .pkgs{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
@media(max-width:900px){.rl-saos .pkgs{grid-template-columns:1fr}}
.rl-saos .pkg{background:var(--glass);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid var(--glass-line);border-radius:var(--r-lg);padding:30px 26px;display:flex;flex-direction:column;gap:16px;box-shadow:inset 0 1px 0 var(--glass-hi),0 24px 60px -40px rgba(0,0,0,.9)}
.rl-saos .pkg.feat{background:linear-gradient(180deg,rgba(153,0,0,.14),var(--glass-2));border-color:var(--red-line);box-shadow:inset 0 1px 0 var(--glass-hi),0 0 70px -26px var(--red-glow)}
.rl-saos .pkg .tier{font-family:var(--f-mono);font-size:12px;letter-spacing:.14em;color:var(--red-3);text-transform:uppercase}
.rl-saos .pkg h3{font-size:20px}
.rl-saos .pkg .price{font-family:var(--f-display);font-size:26px;font-weight:600}
.rl-saos .pkg .price small{display:block;font-family:var(--f-mono);font-size:12px;color:var(--ink-faint);font-weight:400;letter-spacing:.04em;margin-top:6px;text-transform:none}
.rl-saos .pkg ul{list-style:none;margin:4px 0;padding:0;display:grid;gap:10px}
.rl-saos .pkg li{font-size:16px;color:var(--ink-dim);display:flex;gap:10px}
.rl-saos .pkg li::before{content:"+";color:var(--red-2);font-family:var(--f-mono)}
.rl-saos .pkg .btn{margin-top:auto;justify-content:center}
.rl-saos .agent{background:var(--glass);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid var(--glass-line);border-radius:var(--r);padding:20px;box-shadow:inset 0 1px 0 var(--glass-hi);transition:.2s}
.rl-saos .agent:hover{border-color:var(--red-line);background:var(--glass-2)}
.rl-saos .agent .id{font-family:var(--f-mono);font-size:12px;color:var(--red-3);letter-spacing:.1em}
.rl-saos .agent h4{font-size:15px;margin:9px 0 6px}
.rl-saos .agent p{font-size:16px;color:var(--ink-faint)}
.rl-saos .proof{border:1px dashed var(--line-2);background:var(--panel);padding:28px;display:grid;grid-template-columns:repeat(4,1fr);gap:24px}
@media(max-width:760px){.rl-saos .proof{grid-template-columns:repeat(2,1fr)}}
@media(max-width:420px){.rl-saos .proof{grid-template-columns:1fr}}
.rl-saos .stat .fig{font-family:var(--f-display);font-size:38px;font-weight:700;color:var(--ink)}
.rl-saos .stat .lab{font-family:var(--f-mono);font-size:12px;color:var(--ink-faint);letter-spacing:.08em;text-transform:uppercase;margin-top:6px}
.rl-saos .ph{font-family:var(--f-mono);font-size:12px;color:var(--red-3);border:1px solid var(--red);padding:2px 7px;display:inline-block;letter-spacing:.08em;text-transform:uppercase}
.rl-saos .faq details{border:1px solid var(--glass-line);background:var(--glass);backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);border-radius:var(--r);margin-bottom:12px;box-shadow:inset 0 1px 0 var(--glass-hi)}
.rl-saos .faq summary{cursor:pointer;padding:20px 24px;font-family:var(--f-display);text-transform:uppercase;font-size:16px;letter-spacing:.02em;list-style:none;display:flex;justify-content:space-between;gap:16px;align-items:center}
.rl-saos .faq summary::-webkit-details-marker{display:none}
.rl-saos .faq summary::after{content:"+";color:var(--red-2);font-family:var(--f-mono);font-size:20px}
.rl-saos .faq details[open] summary::after{content:"\2212"}
.rl-saos .faq p{padding:0 24px 22px;color:var(--ink-dim);font-size:16px;max-width:75ch}
.rl-saos .final{position:relative;overflow:hidden;border:1px solid var(--red-line);border-radius:var(--r-lg); background:#0b090a;padding:clamp(48px,7vw,92px) clamp(24px,5vw,64px);text-align:center; box-shadow:inset 0 1px 0 var(--glass-hi),0 0 130px -46px var(--red-glow)}
.rl-saos .final::before{content:"";position:absolute;inset:0;pointer-events:none; background:radial-gradient(58% 96% at 50% 128%,rgba(226,59,59,.6),rgba(153,0,0,.28) 38%,transparent 70%),linear-gradient(180deg,transparent 40%,rgba(153,0,0,.10))}
.rl-saos .final::after{content:"";position:absolute;inset:0;pointer-events:none; background:linear-gradient(102deg,#0b090a 0%,rgba(11,9,10,.55) 28%,transparent 47%),linear-gradient(258deg,#0b090a 0%,rgba(11,9,10,.55) 28%,transparent 47%)}
.rl-saos .final>*{position:relative;z-index:2}
.rl-saos .final h2{font-size:clamp(30px,5vw,56px)}
.rl-saos .final .lede{margin:20px auto 0}
.rl-saos .final .hero-cta{justify-content:center}
.rl-saos .cmp tbody th{text-align:left;padding:15px 18px;border-bottom:1px solid var(--line);font-weight:400;color:var(--ink-faint)}
/* heading-level fixes: steps/agents use h3 (design used h4) */
.rl-saos .step h3{font-size:20px;margin:8px 0}
.rl-saos .agent h3{font-size:20px;margin:9px 0 6px}
.rl-saos .icp .cell h3{font-size:20px;margin:0 0 4px}
/* mobile fixes (design preview defects): eyebrow wraps as units; vertical flow line stays 2px (inline width:100% overrode it) */
.rl-saos .ey{flex-wrap:wrap;row-gap:.2em}
@media(max-width:520px){.rl-saos .flow{width:2px!important}}
/* hero visual: Authority loop (D-039) - unique to SAOS; Home keeps the engine */
.rl-saos .loop{margin:0;border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:20px 22px 14px;box-shadow:0 30px 80px -50px var(--red-glow);display:flex;flex-direction:column}
.rl-saos .loop>div:not(.cap){flex:1;display:flex;align-items:center}.rl-saos .loop svg{width:100%;height:auto}
.rl-saos .loop .cap{display:flex;justify-content:space-between;gap:12px}
.rl-saos .loop .cap span{font-family:var(--f-mono);font-size:12px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
.rl-saos .lp-ring{fill:none;stroke:var(--line-2);stroke-width:1}
.rl-saos .lp-ring2{fill:none;stroke:var(--line-2);stroke-width:1;stroke-dasharray:2 7;opacity:.7;transform-origin:260px 222px;animation:rlsSpin 60s linear infinite reverse}
.rl-saos .lp-comet{animation:rlsSpin 10s linear infinite}
.rl-saos .lp-tail{fill:none;stroke:var(--red-2);stroke-width:1.4;stroke-linecap:round;opacity:.8}
.rl-saos .lp-head{fill:#fff;filter:drop-shadow(0 0 4px rgba(226,59,59,.85))}
.rl-saos .lp-sq{fill:var(--bg);stroke:var(--line-2)}
.rl-saos .lp-lit,.rl-saos .lp-lab-on{opacity:0;animation:rlsLit 10s cubic-bezier(.45,0,.2,1) infinite both;animation-delay:var(--d)}
.rl-saos .lp-halo{opacity:0;transform-box:fill-box;transform-origin:50% 50%;animation:rlsHalo 10s ease-out infinite both;animation-delay:var(--d)}
.rl-saos .lp-lit{fill:rgba(153,0,0,.22);stroke:var(--red-2);stroke-width:1}
.rl-saos .lp-halo{fill:none;stroke:var(--red-line);stroke-width:1}
.rl-saos .lp-lab{font-family:var(--f-mono);font-size:11px;letter-spacing:.12em;fill:var(--ink-dim)}
.rl-saos .lp-lab-on{fill:#fff}
.rl-saos .lp-sub{font-family:var(--f-mono);font-size:9.5px;letter-spacing:.04em;fill:var(--ink-faint)}
.rl-saos .lp-core{fill:rgba(153,0,0,.08);stroke:var(--red-line);stroke-width:1}
.rl-saos .lp-core-t{font-family:var(--f-display);font-size:15px;letter-spacing:.05em;fill:var(--ink);font-weight:600}
.rl-saos .lp-core-s{font-family:var(--f-mono);font-size:8.5px;letter-spacing:.16em;fill:var(--ink-faint)}
.rl-saos .lp-axis{stroke:var(--line-2)}
.rl-saos .lp-auth{fill:none;stroke:var(--red-3);stroke-width:1.5;stroke-linejoin:round;stroke-linecap:round;stroke-dashoffset:0;animation:rlsAuth 10s cubic-bezier(.45,0,.2,1) infinite both}
@media(max-width:560px){.rl-saos .lp-sub,.rl-saos .loop .cap span+span{display:none}.rl-saos .lp-lab{font-size:17px;letter-spacing:.06em}.rl-saos .lp-core-t{font-size:17px}.rl-saos .loop{padding:16px 12px 8px}}
@keyframes rlsSpin{to{transform:rotate(360deg)}}
@keyframes rlsLit{0%{opacity:0}5%,15%{opacity:1}26%,100%{opacity:0}}
@keyframes rlsHalo{0%{opacity:0;transform:scale(.85)}5%{opacity:1}22%,100%{opacity:0;transform:scale(1.25)}}
@keyframes rlsAuth{0%{stroke-dashoffset:var(--L);opacity:1}80%,90%{stroke-dashoffset:0;opacity:1}97%{stroke-dashoffset:0;opacity:0}100%{stroke-dashoffset:var(--L);opacity:0}}
</style>
<?php }

/* ---------- schema: extend Yoast's graph (it already emits WebPage + BreadcrumbList + Organization) ---------- */
add_filter('wpseo_schema_graph', function ($graph) {
    if (!rl_is_saos() || !is_array($graph)) return $graph;
    $url = get_permalink(get_queried_object_id());
    $org = home_url('/') . '#organization';
    $graph[] = [
        '@type' => 'Service',
        '@id' => $url . '#service',
        'name' => 'Search Authority OS',
        'description' => RL_SAOS_DESC,
        'url' => $url,
        'serviceType' => 'SEO, AI search optimization and evidence-verified content',
        'provider' => ['@id' => $org],
        'areaServed' => 'Worldwide',
        'mainEntityOfPage' => ['@id' => $url],
    ];
    $graph[] = [
        '@type' => 'FAQPage',
        '@id' => $url . '#faq',
        'isPartOf' => ['@id' => $url],
        'mainEntity' => array_map(function ($f) {
            return ['@type' => 'Question', 'name' => $f[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]]];
        }, rl_saos_faqs()),
    ];
    return $graph;
}, 20);

/* ---------- markup ---------- */
add_shortcode('reinforce_saos', 'rl_render_saos');
function rl_render_saos() {
    $u = function ($path, $fallback = '#') { return esc_url(function_exists('rl_url_by_path') ? rl_url_by_path($path, $fallback) : $fallback); };
    $diag = $u('search-authority-diagnostic');
    $pkg  = $u('packages');
    $industries = [
        ['pharmaceutical', 'Regulated · High-stakes', 'Pharmaceutical &amp; Life Sciences', ['Claims tied to PubMed, ClinicalTrials.gov, FDA and patents', 'Content that survives medical, legal and regulatory review', 'Authority in a field where a wrong statement is a liability']],
        ['healthcare', 'Expertise · E-E-A-T', 'Healthcare', ['Evidence-backed, patient-safe content at scale', 'Structured for AI answers and featured results', 'Demonstrable expertise, not generic health copy']],
        ['b2b-saas', 'Velocity · Pipeline', 'B2B SaaS', ['Own the category before competitors define it', 'Comparison, use-case and problem-solving content that converts', 'Share of voice across Google and AI recommendation surfaces']],
        ['ecommerce', 'Conversion · Scale', 'E-commerce', ['Category and product content that ranks and sells', 'Buying guides and comparisons shoppers trust', 'Visible when shoppers ask AI what to buy']],
        ['manufacturing', 'Technical · Industrial', 'Manufacturing', ['Specs, applications and capabilities made searchable', 'Content for engineers, procurement and distributors alike', 'Rank for the niche, high-intent queries that bring RFQs']],
        ['technology', 'Complex · Technical', 'Technology', ['Turn technical depth into searchable authority', 'Content that speaks to engineers and buyers alike', 'Rank for the long, specific queries that actually convert']],
        ['professional-services', 'Reputation · Referral · incl. Finance', 'Professional Services', ['Thought leadership that reads as genuine expertise', 'Finance, legal and consulting content sourced to hold up to scrutiny', 'Be the firm AI cites when a prospect asks']],
        ['education', 'Authority · Trust', 'Education', ['Programs and expertise made discoverable', 'Accurate, sourced content for students and families', 'Visible in Google and AI answers during research season']],
    ];
    $agents = [
        ['seo-intelligence', 'Search Intelligence', 'Know exactly what to rank for.'],
        ['content-research', 'Content Research', 'Research-backed topics, not guesses.'],
        ['evidence-verification', 'Evidence Verification', 'Fact-checked, sourced content.'],
        ['aeo-geo-optimization', 'AEO / GEO Optimization', 'Show up inside AI answers.'],
        ['social-sentiment', 'Social Sentiment', 'Write from real customer voice.'],
        ['competitor-intelligence', 'Competitor Intelligence', 'See where rivals win, and don’t.'],
        ['content-qa', 'Content QA Auditor', 'A quality gate before anything ships.'],
        ['search-performance', 'Search Performance', 'Diagnose drops, recover rankings.'],
    ];
    ob_start(); ?>
<div class="rl-saos">

<nav class="crumbs wrap" aria-label="Breadcrumb"><ol>
  <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
  <li><span aria-current="page">Search Authority OS</span></li>
</ol></nav>

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="ey"><b>[</b>&nbsp;AI Growth Systems&nbsp;<b>/</b>&nbsp;Search Authority OS&nbsp;<b>]</b></span>
      <h1 class="h1">Stop publishing content.<br>Start building<br><span class="r">search authority.</span></h1>
      <p class="lede"><strong>Search Authority OS</strong> is an AI-powered operating system from Reinforce Lab that continuously researches your market, verifies every claim against real evidence, produces high-value content, and monitors your visibility across Google <em>and</em> AI search, then improves itself over time.</p>
      <div class="hero-cta">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="#system">See the system</a>
      </div>
      <p class="microtrust">Built for <b>Pharma &amp; Life Sciences · Healthcare · B2B SaaS · E-commerce · Manufacturing · Technology · Professional Services (incl. Finance) · Education</b></p>
    </div>
    <figure class="loop rl-anim" role="img" aria-label="Search Authority OS runs as one continuous loop (research, verify, write, audit and monitor) and search authority rises with every lap.">
      <div class="cap" aria-hidden="true"><span>The loop</span><span>Continuous · self-improving</span></div>
      <div aria-hidden="true"><svg viewBox="-44 0 608 452" xmlns="http://www.w3.org/2000/svg" focusable="false"><circle class="lp-ring" cx="260" cy="222" r="150"/><circle class="lp-ring2" cx="260" cy="222" r="118"/><g class="lp-comet" style="transform-origin:260px 222px"><circle class="lp-tail" cx="260" cy="222" r="150" stroke-dasharray="74 942.5" transform="rotate(-118.3 260 222)"/><circle class="lp-head" cx="260" cy="72" r="5"/></g><g class="lp-node" style="--d:0s"><rect class="lp-sq" x="252.0" y="64.0" width="16" height="16"/><rect class="lp-lit" x="252.0" y="64.0" width="16" height="16"/><rect class="lp-halo" x="243.0" y="55.0" width="34" height="34"/><text class="lp-lab" x="260.0" y="26.0" text-anchor="middle">01 RESEARCH</text><text class="lp-lab lp-lab-on" x="260.0" y="26.0" text-anchor="middle">01 RESEARCH</text><text class="lp-sub" x="260.0" y="40.0" text-anchor="middle">demand · rivals · voice</text></g><g class="lp-node" style="--d:2s"><rect class="lp-sq" x="394.7" y="167.6" width="16" height="16"/><rect class="lp-lit" x="394.7" y="167.6" width="16" height="16"/><rect class="lp-halo" x="385.7" y="158.6" width="34" height="34"/><text class="lp-lab" x="431.2" y="166.4" text-anchor="start">02 VERIFY</text><text class="lp-lab lp-lab-on" x="431.2" y="166.4" text-anchor="start">02 VERIFY</text><text class="lp-sub" x="431.2" y="180.4" text-anchor="start">source · confidence</text></g><g class="lp-node" style="--d:4s"><rect class="lp-sq" x="340.2" y="335.4" width="16" height="16"/><rect class="lp-lit" x="340.2" y="335.4" width="16" height="16"/><rect class="lp-halo" x="331.2" y="326.4" width="34" height="34"/><text class="lp-lab" x="365.8" y="377.6" text-anchor="start">03 WRITE</text><text class="lp-lab lp-lab-on" x="365.8" y="377.6" text-anchor="start">03 WRITE</text><text class="lp-sub" x="365.8" y="391.6" text-anchor="start">built for AI answers</text></g><g class="lp-node" style="--d:6s"><rect class="lp-sq" x="163.8" y="335.4" width="16" height="16"/><rect class="lp-lit" x="163.8" y="335.4" width="16" height="16"/><rect class="lp-halo" x="154.8" y="326.4" width="34" height="34"/><text class="lp-lab" x="154.2" y="377.6" text-anchor="end">04 AUDIT</text><text class="lp-lab lp-lab-on" x="154.2" y="377.6" text-anchor="end">04 AUDIT</text><text class="lp-sub" x="154.2" y="391.6" text-anchor="end">SEO · AEO · GEO gates</text></g><g class="lp-node" style="--d:8s"><rect class="lp-sq" x="109.3" y="167.6" width="16" height="16"/><rect class="lp-lit" x="109.3" y="167.6" width="16" height="16"/><rect class="lp-halo" x="100.3" y="158.6" width="34" height="34"/><text class="lp-lab" x="88.8" y="166.4" text-anchor="end">05 MONITOR</text><text class="lp-lab lp-lab-on" x="88.8" y="166.4" text-anchor="end">05 MONITOR</text><text class="lp-sub" x="88.8" y="180.4" text-anchor="end">GSC · GA4 · AI visibility</text></g><rect class="lp-core" x="172.0" y="166.0" width="176" height="112"/><text class="lp-core-t" x="260" y="196" text-anchor="middle">SEARCH AUTHORITY OS</text><line class="lp-axis" x1="192" y1="257" x2="328" y2="257"/><polyline class="lp-auth" points="192.0,256.0 198.8,256.0 204.2,247.0 219.2,247.0 226.0,247.0 231.4,238.0 246.4,238.0 253.2,238.0 258.6,229.0 273.6,229.0 280.4,229.0 285.8,220.0 300.8,220.0 307.6,220.0 313.0,211.0 328.0,211.0" style="--L:161" stroke-dasharray="161"/><text class="lp-core-s" x="260" y="214" text-anchor="middle">AUTHORITY ↑ EVERY LAP</text></svg></div>
    <?php if (function_exists('rl_ph')) echo rl_ph([['label' => '', 'kind' => 'rows', 'items' => ['01 Research · demand, rivals, voice', '02 Verify · source, confidence', '03 Write · built for AI answers', '04 Audit · SEO, AEO, GEO gates', '05 Monitor · GSC, GA4, AI visibility']], ['label' => '', 'kind' => 'core', 'title' => 'Search Authority OS', 'sub' => 'Authority rises every lap']], 'Continuous · self-improving'); ?></figure>
  </div>
</section>

<section class="band alt" id="problem">
  <div class="wrap">
    <div class="head">
      <span class="ey"><b>[</b>&nbsp;The Problem&nbsp;<b>]</b></span>
      <h2>Why does search strategy break on disconnected systems?</h2>
      <p class="lede">SEO data sits in one tool. Content research happens somewhere else. Writers don't know what customers are complaining about. Nobody is connecting the signals, and more content isn't the answer.</p>
    </div>
    <div class="pains">
      <div class="pain"><span class="x" aria-hidden="true"><svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" focusable="false"><path d="M4 4l8 8M12 4l-8 8"/></svg></span><p><b>You rank on Google but vanish in AI search.</b> ChatGPT, Perplexity and AI Overviews now answer what your pages used to. You find out from a prospect, weeks late.</p></div>
      <div class="pain"><span class="x" aria-hidden="true"><svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" focusable="false"><path d="M4 4l8 8M12 4l-8 8"/></svg></span><p><b>Your content can't prove what it claims.</b> In regulated industries, an unsupported statement isn't a nuisance; it's a liability.</p></div>
      <div class="pain"><span class="x" aria-hidden="true"><svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" focusable="false"><path d="M4 4l8 8M12 4l-8 8"/></svg></span><p><b>AI writes an article in 30 seconds.</b> That's not the problem. Thin, unverified, undifferentiated content that Google stops indexing. That's the problem.</p></div>
      <div class="pain"><span class="x" aria-hidden="true"><svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" focusable="false"><path d="M4 4l8 8M12 4l-8 8"/></svg></span><p><b>You measure output, not authority.</b> Word counts and publish cadence tell you nothing about whether you're actually winning the search.</p></div>
      <div class="pain"><span class="x" aria-hidden="true"><svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" focusable="false"><path d="M4 4l8 8M12 4l-8 8"/></svg></span><p><b>Rankings slip and no one knows why.</b> SERP shifted? Intent changed? Content decayed? Cannibalization? By the time you diagnose it, the traffic is gone.</p></div>
      <div class="pain"><span class="x" aria-hidden="true"><svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" focusable="false"><path d="M4 4l8 8M12 4l-8 8"/></svg></span><p><b>Every tool is a silo.</b> Five subscriptions, three teams, zero feedback loops. You are the integration layer, and it doesn't scale.</p></div>
    </div>
    <div class="hero-cta" style="margin-top:32px"><a class="btn g" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a></div>
    <p class="src">Sources: <a href="https://developers.google.com/search/docs/appearance/ai-features" rel="noopener" target="_blank">Google Search Central: AI features and your website</a> · <a href="https://developers.google.com/search/docs/fundamentals/creating-helpful-content" rel="noopener" target="_blank">Google Search Central: Creating helpful, reliable, people-first content</a> · <a href="https://developers.google.com/search/docs/essentials/spam-policies" rel="noopener" target="_blank">Google Search Central: Spam policies</a></p>
  </div>
</section>

<section id="system">
  <div class="wrap">
    <div class="head">
      <span class="ey"><b>[</b>&nbsp;The System&nbsp;<b>]</b></span>
      <h2>One intelligence system for everything that determines your search authority.</h2>
      <p class="lede">Not an AI writer. Search Authority OS is the flagship of Reinforce Lab's <a href="<?php echo $u('services/ai-growth-systems'); ?>">AI Growth Systems</a>: it researches before it generates, verifies before it publishes, and measures after it ships, as one continuous loop.</p>
    </div>
    <div class="cols c3">
      <div class="cell"><div class="n">01</div><h3>Search Intelligence</h3><p>Rankings, queries, SERP structure and real demand, not a static keyword list.</p></div>
      <div class="cell"><div class="n">02</div><h3>Web &amp; Competitor Intelligence</h3><p>What the market asks, what rivals cover, and the gaps worth owning.</p></div>
      <div class="cell"><div class="n">03</div><h3>Social &amp; Customer Voice</h3><p>The questions, objections and complaints in your customers' own language.</p></div>
      <div class="cell"><div class="n">04</div><h3>AI Search Intelligence</h3><p>Where you appear (or don't) across ChatGPT, Perplexity, Gemini and AI Overviews.</p></div>
      <div class="cell"><div class="n">05</div><h3>Domain Evidence</h3><p>For regulated fields: PubMed, Europe PMC, ClinicalTrials.gov, FDA, patents.</p></div>
      <div class="cell"><div class="n">06</div><h3>Performance Intelligence</h3><p>GSC, GA4 and AI visibility, read continuously, so decay is caught, not discovered.</p></div>
    </div>
    <p class="src">Sources: <a href="https://pubmed.ncbi.nlm.nih.gov/" rel="noopener" target="_blank">PubMed</a> · <a href="https://europepmc.org/" rel="noopener" target="_blank">Europe PMC</a> · <a href="https://clinicaltrials.gov/" rel="noopener" target="_blank">ClinicalTrials.gov</a> · <a href="https://www.fda.gov/" rel="noopener" target="_blank">U.S. Food and Drug Administration</a></p>
  </div>
</section>

<section class="band alt" id="how">
  <div class="wrap">
    <div class="head">
      <span class="ey"><b>[</b>&nbsp;Research before generation&nbsp;<b>]</b></span>
      <h2>Content is the output. Intelligence is the product.</h2>
    </div>
    <ol class="steps" style="list-style:none;margin:0;padding:0">
      <li class="step"><div class="k" aria-hidden="true">01</div><h3>Research</h3><p>Search data, competitors, customer voice and authoritative evidence, assembled before a word is written.</p></li>
      <li class="step"><div class="k" aria-hidden="true">02</div><h3>Verify</h3><p>Every material claim gets a source, a freshness check, a confidence score. No evidence, no claim.</p></li>
      <li class="step"><div class="k" aria-hidden="true">03</div><h3>Produce &amp; QA</h3><p>Written for Google and AI answers, then passed through SEO, AEO, GEO and evidence quality gates.</p></li>
      <li class="step"><div class="k" aria-hidden="true">04</div><h3>Measure &amp; Heal</h3><p>Published, monitored, and (when a page slips) diagnosed and corrected. The system learns.</p></li>
    </ol>
  </div>
</section>

<section id="evidence">
  <div class="wrap">
    <div class="head">
      <span class="ey"><b>[</b>&nbsp;The Evidence Layer&nbsp;<b>]</b></span>
      <h2>Every important claim carries a verifiable trail.</h2>
      <p class="lede">The difference between content that sounds authoritative and content that <em>is</em>. This is what most AI content operations skip, and what regulated buyers require.</p>
    </div>
    <ol class="chain" style="list-style:none;margin:0;padding:0" aria-label="Evidence chain">
      <li class="chip"><div class="t">Claim</div><div class="v">Statement</div></li>
      <li class="chip"><div class="t">Source</div><div class="v">Authority</div></li>
      <li class="chip"><div class="t">Evidence</div><div class="v">Support</div></li>
      <li class="chip on"><div class="t">Verification</div><div class="v">Confidence</div></li>
      <li class="chip"><div class="t">Content</div><div class="v">Published</div></li>
    </ol>
    <div class="cols c4" style="margin-top:24px">
      <div class="cell"><p><b style="color:var(--ink)">No evidence</b> → no important factual claim.</p></div>
      <div class="cell"><p><b style="color:var(--ink)">Conflicting sources</b> → investigate, don't average.</p></div>
      <div class="cell"><p><b style="color:var(--ink)">Unverified claim</b> → flagged for human review.</p></div>
      <div class="cell"><p><b style="color:var(--ink)">Weak source</b> → never load-bearing for a critical claim.</p></div>
    </div>
  </div>
</section>

<section class="band alt icp" id="industries">
  <div class="wrap">
    <div class="head">
      <span class="ey"><b>[</b>&nbsp;Built for your industry&nbsp;<b>]</b></span>
      <h2>Written for the buyers you're trying to reach.</h2>
      <p class="lede">The system adapts its evidence sources, compliance posture and content strategy to your field. The eight industries it is built for:</p>
    </div>
    <div class="cols c4">
      <?php foreach ($industries as $i) { ?>
      <a class="cell" href="<?php echo $u('industries/' . $i[0]); ?>"><div class="who"><?php echo $i[1]; ?></div><h3><?php echo $i[2]; ?></h3><ul><?php foreach ($i[3] as $li) echo '<li>' . $li . '</li>'; ?></ul><span class="more">Explore &rarr;</span></a>
      <?php } ?>
    </div>
  </div>
</section>

<section id="deliverables">
  <div class="wrap">
    <div class="head">
      <span class="ey"><b>[</b>&nbsp;What you get&nbsp;<b>]</b></span>
      <h2>A monthly authority portfolio, not a content quota.</h2>
      <p class="lede">The objective is never the number. But here's what a month can look like:</p>
    </div>
    <div class="cols c4">
      <div class="cell"><h3>Research-led</h3><p>Deeply researched articles targeting real, high-value demand.</p></div>
      <div class="cell"><h3>Commercial</h3><p>Pages engineered to convert intent into pipeline.</p></div>
      <div class="cell"><h3>Comparison</h3><p>The "vs" and "best" content buyers use to decide.</p></div>
      <div class="cell"><h3>Original data</h3><p>Proprietary research that earns citations and links.</p></div>
      <div class="cell"><h3>Case &amp; problem-solving</h3><p>Proof that turns interest into trust.</p></div>
      <div class="cell"><h3>Executive thought leadership</h3><p>Authority content in the founder's voice.</p></div>
      <div class="cell"><h3>Industry reports</h3><p>Pillar assets that define the category.</p></div>
      <div class="cell"><h3>7-day authority report</h3><p>Organic, AI visibility and business signals, every week.</p></div>
    </div>
  </div>
</section>

<section class="band alt" id="compare">
  <div class="wrap">
    <div class="head">
      <span class="ey"><b>[</b>&nbsp;The difference&nbsp;<b>]</b></span>
      <h2>How is Search Authority OS different from a content team?</h2>
    </div>
    <div class="cmp-scroll">
      <table class="cmp">
        <caption class="sr">How Search Authority OS differs from a traditional content operation</caption>
        <thead><tr><th scope="col">Dimension</th><th scope="col">Traditional</th><th scope="col">Search Authority OS</th></tr></thead>
        <tbody>
          <tr><th scope="row">Inputs</th><td>Keyword list</td><td>Live search intelligence</td></tr>
          <tr><th scope="row">Planning</th><td>Content calendar</td><td>Dynamic opportunity engine</td></tr>
          <tr><th scope="row">Production</th><td>AI writer</td><td>Research + production system</td></tr>
          <tr><th scope="row">Sourcing</th><td>Generic references</td><td>Evidence hierarchy &amp; verification</td></tr>
          <tr><th scope="row">Measurement</th><td>Monthly ranking report</td><td>Continuous search + AI visibility</td></tr>
          <tr><th scope="row">Recovery</th><td>Manual content refresh</td><td>Performance-driven self-healing</td></tr>
          <tr><th scope="row">Process</th><td>Static SOPs</td><td>A system that learns</td></tr>
          <tr><th scope="row">Outcome</th><td>More content</td><td>More authority</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<section id="agents">
  <div class="wrap">
    <div class="head">
      <span class="ey"><b>[</b>&nbsp;Modular by design&nbsp;<b>]</b></span>
      <h2>Run the whole OS, or start with one agent.</h2>
      <p class="lede">Each agent sells a specific outcome. Adopt the system, or begin where the pain is sharpest.</p>
    </div>
    <div class="cols c4">
      <?php foreach ($agents as $n => $a) { ?>
      <a class="agent" href="<?php echo $u('services/agents/' . $a[0]); ?>"><div class="id">A-0<?php echo $n + 1; ?></div><h3><?php echo esc_html($a[1]); ?></h3><p><?php echo esc_html($a[2]); ?></p></a>
      <?php } ?>
    </div>
    <div class="cta-row"><a class="btn g" href="<?php echo $u('services/agents'); ?>">See all agents <span class="ar">&rarr;</span></a></div>
  </div>
</section>

<section class="band alt" id="proof">
  <div class="wrap">
    <div class="head">
      <span class="ey"><b>[</b>&nbsp;Proof&nbsp;<b>]</b></span>
      <h2>Reinforce Lab runs this system on itself.</h2>
      <p class="lede">We are our own R&amp;D lab. Your diagnostic establishes your real baseline: no borrowed numbers, no invented results.</p>
    </div>
    <div class="proof">
      <div class="stat"><div class="fig"><span class="ph">Your baseline</span></div><div class="lab">Organic visibility today</div></div>
      <div class="stat"><div class="fig"><span class="ph">Your gap</span></div><div class="lab">AI-search presence</div></div>
      <div class="stat"><div class="fig"><span class="ph">Your opportunity</span></div><div class="lab">Uncaptured demand</div></div>
      <div class="stat"><div class="fig"><span class="ph">Your plan</span></div><div class="lab">90-day priorities</div></div>
    </div>
    <p class="microtrust" style="margin-top:20px">Case studies and metrics are added only when verified. Placeholders above are replaced by your own diagnostic data.</p>
  </div>
</section>

<section id="packages">
  <div class="wrap">
    <div class="head">
      <span class="ey"><b>[</b>&nbsp;Packages&nbsp;<b>]</b></span>
      <h2>Three ways to build authority.</h2>
      <p class="lede">Every engagement begins with a diagnostic. Pricing shown is a starting framework, finalized to scope. <a href="<?php echo $pkg; ?>">Compare packages in detail</a>.</p>
    </div>
    <div class="pkgs">
      <div class="pkg">
        <div class="tier">01 · Foundation</div>
        <h3>Search Authority Foundation</h3>
        <div class="price">$5,000 <small>setup + $1,500 to $2,500 / month</small></div>
        <ul><li>SEO + SERP intelligence</li><li>Web + social research</li><li>Evidence verification</li><li>AEO / GEO optimization</li><li>20 to 30 assets / month</li><li>GSC + GA4 + 7-day reporting</li></ul>
        <a class="btn g" href="<?php echo $diag; ?>">Start here <span class="ar">&rarr;</span></a>
      </div>
      <div class="pkg feat">
        <div class="tier">02 · Growth OS · Most chosen</div>
        <h3>Search Authority Growth OS</h3>
        <div class="price">$10,000 <small>setup + $3,500 to $5,000 / month</small></div>
        <ul><li>Everything in Foundation</li><li>40 to 60 assets / month</li><li>Competitor + AI visibility monitoring</li><li>Original-data research</li><li>Cannibalization + gap analysis</li><li>Self-improvement feedback loop</li></ul>
        <a class="btn p" href="<?php echo $diag; ?>">Get the Growth OS <span class="ar">&rarr;</span></a>
      </div>
      <div class="pkg">
        <div class="tier">03 · Enterprise</div>
        <h3>Enterprise Intelligence OS</h3>
        <div class="price">$20k to $35k+ <small>setup + $7,500 to $15,000+ / month</small></div>
        <ul><li>Everything in Growth OS</li><li>Scientific evidence connectors</li><li>Regulatory + patent intelligence</li><li>Industry evidence graph</li><li>Human approval workflows</li><li>Enterprise governance</li></ul>
        <a class="btn g" href="<?php echo $diag; ?>">Talk to us <span class="ar">&rarr;</span></a>
      </div>
    </div>
  </div>
</section>

<section class="band alt faq" id="faq">
  <div class="wrap" style="max-width:900px">
    <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>What should you know before booking a diagnostic?</h2></div>
    <?php foreach (rl_saos_faqs() as $k => $f) { ?>
    <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($f[0]); ?></h3></summary><p><?php echo esc_html($f[1]); ?></p></details>
    <?php } ?>
  </div>
</section>

<section id="diagnostic">
  <div class="wrap">
    <div class="final">
      <span class="ey"><b>[</b>&nbsp;Start with the diagnostic&nbsp;<b>]</b></span>
      <h2>Find out what's limiting your search authority.</h2>
      <p class="lede">A data-backed diagnostic of your Google visibility, AI-search presence, content authority, competitors and demand signals. No generic scorecard: what matters, what's missing, and what to do next.</p>
      <div class="hero-cta">
        <a class="btn p" href="<?php echo $diag; ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
        <a class="btn g" href="<?php echo $pkg; ?>">Compare packages</a>
      </div>
      <p class="microtrust" style="margin-top:24px">For selected businesses and organizations · Confidential · No purchased lists</p>
    </div>
  </div>
</section>

</div>
<?php
    return ob_get_clean();
}
