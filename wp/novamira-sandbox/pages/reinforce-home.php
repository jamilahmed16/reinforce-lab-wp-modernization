<?php
/**
 * Plugin Name: Reinforce Lab - Homepage (Systems Grid)
 * Description: Long-form landing homepage for Reinforce Lab. Provides [reinforce_home]. Relies on tokens/chrome from reinforce-header.php.
 * Version: 1.1
 */
if (!defined('ABSPATH')) exit;

/* ---------- Hero animation: Growth engine (D-039, Home) ----------
   Inputs pulse into the core; the core runs its five stages; outcomes light in turn; a
   return pulse feeds outcomes back into inputs. 10 s loop, soft fade 92-97 %, reset.
   Transform/opacity/stroke-dashoffset only; keyframes generated per element. */
function rl_home_ge_data() {
    return [
        'in'  => [['Search &', 'SERP data'], ['Content &', 'website'], ['Competitor', 'research'], ['Customer &', 'social signals'], ['AI-search', 'visibility']],
        'out' => [['Automated', 'operations'], ['Content', 'that ranks'], ['Cited in', 'AI search'], ['Qualified', 'pipeline'], ['Increased', 'revenue']],
        'st'  => ['Research', 'Verify', 'Build', 'Automate', 'Monitor'],
    ];
}
function rl_home_ge_kf() {
    $lit = function ($n, $s, $r, $f1 = 92, $f2 = 97) { return "@keyframes $n{0%,{$s}%{opacity:0}{$r}%,{$f1}%{opacity:1}{$f2}%,100%{opacity:0}}\n"; };
    $pul = function ($n, $s, $e) { return "@keyframes $n{0%,{$s}%{stroke-dashoffset:10;opacity:0}" . ($s + 1) . "%{opacity:1}" . ($e - 1) . "%{opacity:1}{$e}%,100%{stroke-dashoffset:-100;opacity:0}}\n"; };
    $k = '';
    for ($i = 0; $i < 5; $i++) {
        $s = $i * 3;
        $k .= $lit("rlgI$i", $s, $s + 3) . $pul("rlgPI$i", $s + 2, $s + 14);
        $k .= ".rl-home .ge-i$i .ge-nl{animation-name:rlgI$i}.rl-home .ge-pi$i{animation-name:rlgPI$i}\n";
        $o = 58 + $i * 2.5;
        $k .= $pul("rlgPO$i", $o, $o + 12) . $lit("rlgO$i", $o + 10, $o + 13);
        $k .= ".rl-home .ge-po$i{animation-name:rlgPO$i}.rl-home .ge-o$i .ge-nl{animation-name:rlgO$i}\n";
        $t = 22 + $i * 7;
        $k .= $lit("rlgS$i", $t, $t + 2);
        $k .= $i < 4 ? "@keyframes rlgT$i{0%,{$t}%{opacity:0}" . ($t + 2) . "%," . ($t + 6) . "%{opacity:1}" . ($t + 7.5) . "%,100%{opacity:0}}\n" : $lit("rlgT$i", $t, $t + 2);
        $k .= ".rl-home .ge-s$i{animation-name:rlgS$i}.rl-home .ge-t$i{animation-name:rlgT$i}\n";
    }
    $k .= $lit('rlgCore', 18, 22) . $pul('rlgFB', 78, 91) . $lit('rlgFBL', 78, 82);
    return $k;
}
function rl_home_ge_css() {
    return '.rl-home .ge{margin:0;border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:20px 20px 12px;box-shadow:0 30px 80px -50px var(--red-glow);display:flex;flex-direction:column}
.rl-home .ge>svg{width:100%;height:auto;margin-block:auto}
.rl-home .ge .cap{display:flex;justify-content:space-between;margin-bottom:12px}
.rl-home .ge .cap span{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
.rl-home .ge-n{fill:var(--bg);stroke:var(--line-2);stroke-width:1}
.rl-home .ge-nl{fill:rgba(153,0,0,.10);stroke:var(--red-2);stroke-width:1;opacity:0}
.rl-home .ge-tx{font-family:var(--f-mono);font-size:10px;letter-spacing:.05em;text-transform:uppercase;fill:var(--ink-dim)}
.rl-home .ge-e{fill:none;stroke:var(--line-2);stroke-width:1}
.rl-home .ge-p{fill:none;stroke:var(--red-3);stroke-width:1.6;stroke-linecap:round;stroke-dasharray:10 100;stroke-dashoffset:10;opacity:0}
.rl-home .ge-c{fill:url(#rlgCoreG);stroke:var(--red-line);stroke-width:1}
.rl-home .ge-cg{fill:none;stroke:var(--red-2);stroke-width:1;opacity:0;animation-name:rlgCore}
.rl-home .ge-ct{font-family:var(--f-display);font-weight:600;font-size:17px;letter-spacing:.04em;text-transform:uppercase;fill:var(--ink)}
.rl-home .ge-st{font-family:var(--f-mono);font-size:9px;letter-spacing:.2em;text-transform:uppercase;fill:var(--red-3);opacity:0}
.rl-home .ge-sb{fill:rgba(255,255,255,.08)}
.rl-home .ge-sl{fill:var(--red-2);opacity:0}
.rl-home .ge-fb{fill:none;stroke:var(--line-2);stroke-width:1;stroke-dasharray:3 4}
.rl-home .ge-fbl{font-family:var(--f-mono);font-size:8.5px;letter-spacing:.18em;fill:var(--ink-faint)}
.rl-home .ge-fbl-on{font-family:var(--f-mono);font-size:8.5px;letter-spacing:.18em;fill:var(--ink);opacity:0;animation-name:rlgFBL}
.rl-home .ge-pf{animation-name:rlgFB;stroke-dasharray:6 100}
.rl-home .ge-nl,.rl-home .ge-p,.rl-home .ge-cg,.rl-home .ge-st,.rl-home .ge-sl,.rl-home .ge-fbl-on{animation-duration:10s;animation-iteration-count:infinite;animation-timing-function:cubic-bezier(.45,0,.2,1);animation-fill-mode:both}
.rl-home .ge-p{animation-timing-function:ease-in-out}
@media(max-width:560px){.rl-home .ge-tx{font-size:12.5px;letter-spacing:0}.rl-home .ge-fbl,.rl-home .ge-fbl-on{font-size:11px;letter-spacing:.06em}.rl-home .ge-st{font-size:11px;letter-spacing:.1em}.rl-home .ge{padding:16px 10px 8px}}
' . rl_home_ge_kf();
}
function rl_home_ge_svg() {
    $d = rl_home_ge_data(); $h = 'esc_html';
    $node = function ($x, $y, $l, $cls) use ($h) {
        return '<g class="' . $cls . '"><rect class="ge-n" x="' . $x . '" y="' . $y . '" width="150" height="40"/><rect class="ge-nl" x="' . $x . '" y="' . $y . '" width="150" height="40"/>'
            . '<text class="ge-tx" x="' . ($x + 12) . '" y="' . ($y + 17) . '">' . $h(strtoupper($l[0])) . '</text><text class="ge-tx" x="' . ($x + 12) . '" y="' . ($y + 30) . '">' . $h(strtoupper($l[1])) . '</text></g>';
    };
    $s = '<svg viewBox="0 0 540 346" role="img" aria-labelledby="rlGeT"><title id="rlGeT">AI Growth System: five inputs (search and SERP data, content and website, competitor research, customer and social signals, AI-search visibility) feed one engine that researches, verifies, builds, automates and monitors, producing automated operations, content that ranks, citations in AI search, qualified pipeline and increased revenue, and the outcomes feed the next cycle.</title>'
        . '<defs><linearGradient id="rlgCoreG" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#990000" stop-opacity=".16"/><stop offset="1" stop-color="#990000" stop-opacity=".03"/></linearGradient></defs>';
    $edges = '';
    for ($i = 0; $i < 5; $i++) {
        $cy = 40 + 54 * $i;
        $pi = 'M150 ' . $cy . ' C178 ' . $cy . ' 176 148 200 148';
        $po = 'M340 148 C364 148 362 ' . $cy . ' 390 ' . $cy;
        $edges .= '<path class="ge-e" d="' . $pi . '"/><path class="ge-e" d="' . $po . '"/>'
            . '<path class="ge-p ge-pi' . $i . '" pathLength="100" d="' . $pi . '"/><path class="ge-p ge-po' . $i . '" pathLength="100" d="' . $po . '"/>';
    }
    $fb = 'M465 276 V306 Q465 318 453 318 H87 Q75 318 75 306 V276';
    $s .= $edges . '<path class="ge-fb" d="' . $fb . '"/><path class="ge-p ge-pf" pathLength="100" d="' . $fb . '"/>'
        . '<text class="ge-fbl" x="270" y="338" text-anchor="middle">OUTCOMES FEED THE NEXT CYCLE</text><text class="ge-fbl-on" x="270" y="338" text-anchor="middle">OUTCOMES FEED THE NEXT CYCLE</text>';
    foreach ($d['in'] as $i => $l) $s .= $node(0, 20 + 54 * $i, $l, 'ge-i' . $i);
    foreach ($d['out'] as $i => $l) $s .= $node(390, 20 + 54 * $i, $l, 'ge-o' . $i);
    $s .= '<rect class="ge-c" x="200" y="93" width="140" height="110"/><rect class="ge-cg" x="196" y="89" width="148" height="118"/>'
        . '<text class="ge-ct" x="270" y="128" text-anchor="middle">AI Growth</text><text class="ge-ct" x="270" y="148" text-anchor="middle">System</text>';
    foreach ($d['st'] as $j => $t) {
        $x = 214 + $j * 23;
        $s .= '<text class="ge-st ge-t' . $j . '" x="270" y="172" text-anchor="middle">' . $h(strtoupper($t)) . '</text>'
            . '<rect class="ge-sb" x="' . $x . '" y="184" width="20" height="3"/><rect class="ge-sl ge-s' . $j . '" x="' . $x . '" y="184" width="20" height="3"/>';
    }
    return $s . '</svg>';
}

add_action('wp_head', 'rl_home_css', 22);
function rl_home_css() {
    if (!is_front_page() && !is_page('home')) return; ?>
<style id="rl-home-css">
.rl-home .src{font-family:var(--f-mono);font-size:11px;letter-spacing:.06em;line-height:1.7;color:var(--ink-faint);margin:16px 0 0}
.rl-home .src a{color:var(--ink-dim);border-bottom:1px solid var(--red-line);text-decoration:none}
/* full-bleed breakout of theme container + kill content padding on home */
.rl-home{position:relative;width:100vw;margin-left:calc(50% - 50vw)}
body.home .fl-page-content,body.home .fl-content,body.home .fl-post-content{padding:0!important;margin:0!important;max-width:none!important}
body.home .fl-post-header,body.home .fl-post-thumb{display:none!important}
.rl-home *{box-sizing:border-box}
.rl-home a{text-decoration:none;color:inherit}
.rl-home a.inl{color:var(--ink);border-bottom:1px solid var(--red-line)}.rl-home a.inl:hover{color:var(--red-3)}
.rl-home .wrap{max-width:var(--maxw);margin:0 auto;padding-inline:var(--gutter)}
.rl-home section{position:relative;padding-block:clamp(56px,8vw,96px)}
.rl-home .band{border-top:1px solid var(--line)}
.rl-home .band.alt{background:radial-gradient(90% 60% at 15% 0%,rgba(153,0,0,.10),transparent 55%),var(--bg-2)}
.rl-home .ey{font-family:var(--f-mono);font-size:12px;letter-spacing:.18em;text-transform:uppercase;color:var(--ink-faint);display:inline-flex;gap:.5em;align-items:center}
.rl-home .ey b{color:var(--red-2);font-weight:500}
.rl-home h1,.rl-home h2,.rl-home h3,.rl-home h4{font-family:var(--f-display);font-weight:600;text-transform:uppercase;margin:0;line-height:1.02;letter-spacing:.01em}
.rl-home .lede{color:var(--ink-dim);font-size:clamp(16px,1.6vw,19px);max-width:60ch}
.rl-home .head{max-width:64ch;margin-bottom:clamp(32px,5vw,52px)}
.rl-home .head h2{font-size:clamp(28px,4.2vw,48px);margin-top:14px}.rl-home .head p{margin-top:18px}
.rl-home .btn{font-family:var(--f-display);text-transform:uppercase;font-weight:600;letter-spacing:.05em;font-size:14px;padding:15px 26px;display:inline-flex;align-items:center;gap:.55em;border:1px solid transparent;cursor:pointer;transition:.2s;border-radius:0}
.rl-home .btn::before{content:"+";font-family:var(--f-mono);font-weight:500;color:var(--red-3);font-size:1.15em;line-height:0}
.rl-home .btn.p{background:linear-gradient(180deg,#241a1c,#120e0f);color:#fff;border-color:var(--red-line);box-shadow:14px 0 44px -14px var(--red-glow),inset 0 1px 0 var(--glass-hi)}
.rl-home .btn.p:hover{border-color:var(--red-2);transform:translateY(-1px)}
.rl-home .btn.g{background:var(--glass);backdrop-filter:blur(8px);color:var(--ink);border-color:var(--glass-line)}
.rl-home .btn.g::before{color:var(--ink-faint)}.rl-home .btn.g:hover{border-color:var(--red-line);color:#fff}
.rl-home .ar{transition:transform .2s}.rl-home .btn:hover .ar{transform:translateX(4px)}
.rl-home .cta-row{display:flex;flex-wrap:wrap;gap:14px;margin-top:26px}
/* hero */
/* hero matches the kit hero on every other page (F-024): padding, grid; the engine panel stretches to the text column */
.rl-home .hero{padding-block:clamp(36px,6vw,80px)}
.rl-home .hero-grid{display:grid;grid-template-columns:1.02fr .98fr;gap:clamp(28px,4vw,56px);align-items:stretch}
@media(max-width:940px){.rl-home .hero-grid{grid-template-columns:1fr;gap:36px}}
/* capitals like every other H1 (Jamil, 5 Oct); smaller than 64px because the locked core message is long */
.rl-home .h1{font-size:clamp(30px,4vw,52px);font-weight:700;letter-spacing:-.01em;line-height:1.02;margin-top:14px}
.rl-home .h1 .r{color:var(--red-2)}
.rl-home .hero .lede{margin-top:18px}
.rl-home .microtrust{margin-top:20px;font-family:var(--f-mono);font-size:12px;color:var(--ink-faint);letter-spacing:.04em;line-height:1.9}.rl-home .microtrust b{color:var(--ink-dim);font-weight:500}
/* engine diagram */
.rl-home .engine{border:1px solid var(--red-line);background:linear-gradient(180deg,var(--panel),var(--bg-2));padding:22px}
.rl-home .engine .cap{display:flex;justify-content:space-between;margin-bottom:14px}
.rl-home .engine .cap span{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
.rl-home .core{border:1px solid var(--red-line);background:linear-gradient(180deg,rgba(153,0,0,.11),rgba(153,0,0,.03));padding:20px 16px;text-align:center;box-shadow:0 0 40px -14px var(--red-glow)}
.rl-home .core b{font-family:var(--f-display);text-transform:uppercase;font-weight:600;font-size:15px;display:block;letter-spacing:.04em}
.rl-home .core small{font-family:var(--f-mono);font-size:10px;color:var(--ink-faint);letter-spacing:.12em}
/* cards */
.rl-home .cols{display:grid;gap:16px}
.rl-home .cols.c2{grid-template-columns:repeat(2,1fr)}.rl-home .cols.c3{grid-template-columns:repeat(3,1fr)}.rl-home .cols.c4{grid-template-columns:repeat(4,1fr)}
@media(max-width:900px){.rl-home .cols.c3,.rl-home .cols.c4{grid-template-columns:repeat(2,1fr)}}
@media(max-width:560px){.rl-home .cols.c2,.rl-home .cols.c3,.rl-home .cols.c4{grid-template-columns:1fr}}
.rl-home .cell{background:var(--glass);backdrop-filter:blur(16px);border:1px solid var(--glass-line);padding:26px;box-shadow:inset 0 1px 0 var(--glass-hi),0 24px 60px -40px rgba(0,0,0,.9);transition:.2s;display:block}
.rl-home .cell:hover{border-color:var(--red-line);background:var(--glass-2)}
.rl-home .cell .n{font-family:var(--f-mono);font-size:12px;color:var(--red-3);letter-spacing:.1em}
.rl-home .cell h3{font-size:19px;margin:12px 0 8px}.rl-home .cell p{color:var(--ink-dim);font-size:14.5px}
.rl-home .pmeta{font-family:var(--f-mono);font-size:11px;color:var(--red-3);letter-spacing:.08em;text-transform:uppercase;margin-bottom:10px}
.rl-home .pcard{padding:0;overflow:hidden;display:flex;flex-direction:column}
.rl-home .pcard .pthumb{aspect-ratio:16/9;width:100%;background-size:cover;background-position:center;background-color:#0f0c0d;border-bottom:1px solid var(--red-line);position:relative}
.rl-home .pcard .pthumb.ph-grid{background-image:linear-gradient(var(--grid-fine) 1px,transparent 1px),linear-gradient(90deg,var(--grid-fine) 1px,transparent 1px),radial-gradient(120% 130% at 100% 0%,rgba(153,0,0,.42),transparent 62%);background-size:20px 20px,20px 20px,100% 100%}
.rl-home .pcard .pthumb .ptag{position:absolute;left:16px;bottom:12px;font-family:var(--f-display);text-transform:uppercase;font-size:clamp(20px,2.4vw,30px);font-weight:700;color:rgba(255,255,255,.92);letter-spacing:.01em;text-shadow:0 2px 20px rgba(0,0,0,.6)}
.rl-home .pcard .pbody{padding:24px}
/* outcomes */
.rl-home .outcome{background:var(--glass);backdrop-filter:blur(16px);border:1px solid var(--glass-line);padding:32px 28px;box-shadow:inset 0 1px 0 var(--glass-hi);text-align:left}
.rl-home .outcome .k{font-family:var(--f-mono);font-size:12px;color:var(--red-3);letter-spacing:.14em}
.rl-home .outcome h3{font-size:22px;margin:14px 0 10px}.rl-home .outcome p{color:var(--ink-dim);font-size:15px}
/* pains */
.rl-home .pains{display:grid;grid-template-columns:1fr 1fr;gap:14px}@media(max-width:640px){.rl-home .pains{grid-template-columns:1fr}}
.rl-home .pain{background:var(--glass);backdrop-filter:blur(16px);border:1px solid var(--glass-line);padding:22px 24px;display:flex;gap:16px;box-shadow:inset 0 1px 0 var(--glass-hi)}
.rl-home .pain .x{color:var(--red-3);font-family:var(--f-mono);flex:none;margin-top:2px}.rl-home .pain p{color:var(--ink-dim);font-size:15px}.rl-home .pain b{color:var(--ink)}
/* steps */
.rl-home .steps{display:grid;grid-template-columns:repeat(4,1fr);gap:16px}@media(max-width:900px){.rl-home .steps{grid-template-columns:repeat(2,1fr)}}@media(max-width:520px){.rl-home .steps{grid-template-columns:1fr}}
.rl-home .step{background:var(--glass);backdrop-filter:blur(16px);border:1px solid var(--glass-line);padding:24px;box-shadow:inset 0 1px 0 var(--glass-hi)}
.rl-home .step .k{font-family:var(--f-display);font-size:34px;color:var(--red-3);font-weight:700;opacity:.8}.rl-home .step h3,.rl-home .step h4{font-size:16px;margin:8px 0}.rl-home .step p{color:var(--ink-dim);font-size:14px}
/* industries */
.rl-home .icp .who{font-family:var(--f-mono);font-size:11px;color:var(--ink-faint);letter-spacing:.12em;text-transform:uppercase;margin-bottom:10px}
.rl-home .icp h3{font-size:19px}.rl-home .icp p{color:var(--ink-dim);font-size:14px;margin-top:8px}
/* flagship callout */
.rl-home .flagship{border:1px solid var(--red-line);background:linear-gradient(120deg,rgba(153,0,0,.07),transparent 55%),var(--panel);padding:clamp(32px,5vw,56px);display:grid;grid-template-columns:1.4fr 1fr;gap:36px;align-items:center;box-shadow:0 24px 60px -46px rgba(0,0,0,.85)}
@media(max-width:820px){.rl-home .flagship{grid-template-columns:1fr}}
.rl-home .flagship .tag{font-family:var(--f-mono);font-size:11px;letter-spacing:.16em;color:var(--red-3);text-transform:uppercase}
.rl-home .flagship h2{font-size:clamp(26px,3.6vw,40px);margin:12px 0 14px}
/* proof */
.rl-home .proof{border:1px dashed var(--line-2);background:var(--panel);padding:28px;display:grid;grid-template-columns:repeat(4,1fr);gap:24px}@media(max-width:760px){.rl-home .proof{grid-template-columns:repeat(2,1fr)}}@media(max-width:420px){.rl-home .proof{grid-template-columns:1fr}}
.rl-home .stat .fig{font-family:var(--f-display);font-size:30px;font-weight:700;color:var(--ink)}.rl-home .stat .lab{font-family:var(--f-mono);font-size:11.5px;color:var(--ink-faint);letter-spacing:.08em;text-transform:uppercase;margin-top:6px}
.rl-home .ph{font-family:var(--f-mono);font-size:11px;color:var(--red-3);border:1px solid var(--red);padding:2px 7px;display:inline-block;letter-spacing:.08em;text-transform:uppercase}
/* packages */
.rl-home .pkgs{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}@media(max-width:900px){.rl-home .pkgs{grid-template-columns:1fr}}
.rl-home .pkg{background:var(--glass);backdrop-filter:blur(16px);border:1px solid var(--glass-line);padding:30px 26px;display:flex;flex-direction:column;gap:16px;box-shadow:inset 0 1px 0 var(--glass-hi),0 24px 60px -40px rgba(0,0,0,.9)}
.rl-home .pkg.feat{background:linear-gradient(180deg,rgba(153,0,0,.14),var(--glass-2));border-color:var(--red-line);box-shadow:inset 0 1px 0 var(--glass-hi),0 0 70px -26px var(--red-glow)}
.rl-home .pkg .tier{font-family:var(--f-mono);font-size:11px;letter-spacing:.14em;color:var(--red-3);text-transform:uppercase}
.rl-home .pkg h3{font-size:22px}.rl-home .pkg .price{font-family:var(--f-display);font-size:24px;font-weight:600}
.rl-home .pkg .price small{display:block;font-family:var(--f-mono);font-size:12px;color:var(--ink-faint);font-weight:400;margin-top:6px;text-transform:none;letter-spacing:.03em}
.rl-home .pkg ul{list-style:none;margin:4px 0;padding:0;display:grid;gap:10px}.rl-home .pkg li{font-size:14px;color:var(--ink-dim);display:flex;gap:10px}.rl-home .pkg li::before{content:"+";color:var(--red-2);font-family:var(--f-mono)}
.rl-home .pkg .btn{margin-top:auto;justify-content:center}
/* faq */
.rl-home .faq details{border:1px solid var(--glass-line);background:var(--glass);backdrop-filter:blur(14px);margin-bottom:12px;box-shadow:inset 0 1px 0 var(--glass-hi)}
.rl-home .faq summary{cursor:pointer;padding:20px 24px;font-family:var(--f-display);text-transform:uppercase;font-size:16px;list-style:none;display:flex;justify-content:space-between;gap:16px;align-items:center}
.rl-home .faq summary::-webkit-details-marker{display:none}.rl-home .faq summary::after{content:"+";color:var(--red-2);font-family:var(--f-mono);font-size:20px}.rl-home .faq details[open] summary::after{content:"\2212"}
.rl-home .faq p{padding:0 24px 22px;color:var(--ink-dim);font-size:15px;max-width:75ch}
/* final */
.rl-home .final{position:relative;overflow:hidden;border:1px solid var(--red-line);background:#0b090a;padding:clamp(48px,7vw,92px) clamp(24px,5vw,64px);text-align:center;box-shadow:inset 0 1px 0 var(--glass-hi),0 0 130px -46px var(--red-glow)}
.rl-home .final::before{content:"";position:absolute;inset:0;pointer-events:none;background:radial-gradient(58% 96% at 50% 128%,rgba(226,59,59,.6),rgba(153,0,0,.28) 38%,transparent 70%),linear-gradient(180deg,transparent 40%,rgba(153,0,0,.10))}
.rl-home .final::after{content:"";position:absolute;inset:0;pointer-events:none;background:linear-gradient(102deg,#0b090a 0%,rgba(11,9,10,.55) 28%,transparent 47%),linear-gradient(258deg,#0b090a 0%,rgba(11,9,10,.55) 28%,transparent 47%)}
.rl-home .final>*{position:relative;z-index:2}.rl-home .final h2{font-size:clamp(30px,5vw,56px)}.rl-home .final .lede{margin:20px auto 0}.rl-home .final .cta-row{justify-content:center}
.rl-home .center{text-align:center;margin-inline:auto}
<?php echo rl_home_ge_css(); ?></style>
<?php }

/* ---------- FAQ data (markup + FAQPage schema share one source) ---------- */
function rl_home_faqs() {
    return [
        ['What is an AI Growth System?', 'An AI Growth System connects your data, AI models, automated workflows and reporting so research, content, search visibility and lead follow-up run as one loop, with people approving what matters. <a class="inl" href="' . esc_url(home_url('/what-is-an-ai-growth-system/')) . '">Read the full explanation</a>.'],
        ['How is an AI Growth System different from hiring an agency or buying AI tools?', 'An agency bills for hours and deliverables, and each new AI tool adds another disconnected subscription. An AI Growth System is infrastructure: the research, content, search and lead workflows are built once, connected to your data, and keep improving, so your people spend their time on strategy, review and relationships instead of repetitive work.'],
        ['What is Reinforce Lab?', 'Reinforce Lab builds AI Growth Systems that connect your website, content and organic search visibility into one growth engine, combining AI automation, AI search optimization, SEO and data-driven workflows. We run our own website, content and search operations on the same systems we build for clients.'],
        ['Who founded Reinforce Lab?', 'Reinforce Lab was founded by <a href="https://www.linkedin.com/in/ahmedjamil16/" rel="noopener" target="_blank">Jamil Ahmed</a>, a pharmacist and Semrush Ambassador.'],
        ['Where is Reinforce Lab based?', 'Reinforce Lab has offices in Dhaka, Bangladesh and Katy, Texas, USA, and works with clients remotely.'],
        ['How do we start working together?', 'With a diagnostic of your visibility, content, workflows and demand, followed by a prioritized plan. Book a strategy call and we’ll scope it with you.'],
    ];
}
add_filter('wpseo_schema_graph', function ($graph) {
    if (!is_front_page() || !is_array($graph)) return $graph;
    $url = home_url('/');
    $graph[] = [
        '@type' => 'FAQPage',
        '@id' => $url . '#faq',
        'isPartOf' => ['@id' => $url],
        'mainEntity' => array_map(function ($f) {
            return ['@type' => 'Question', 'name' => $f[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => wp_strip_all_tags($f[1])]];
        }, rl_home_faqs()),
    ];
    return $graph;
}, 20);

add_shortcode('reinforce_home', 'rl_render_home');
function rl_render_home() {
    $u = 'rl_url_by_path';
    $diag = function_exists('rl_url_by_path') ? rl_url_by_path('search-authority-diagnostic') : '#';
    $svcs = function_exists('rl_url_by_path') ? rl_url_by_path('services') : '#';
    $os   = function_exists('rl_url_by_path') ? rl_url_by_path('search-authority-os') : '#';
    $pkg  = function_exists('rl_url_by_path') ? rl_url_by_path('packages') : '#';
    $inds = function_exists('rl_url_by_path') ? rl_url_by_path('industries') : '#';
    ob_start(); ?>
<div class="rl-home">

  <!-- HERO -->
  <section class="hero">
    <div class="wrap hero-grid">
      <div>
        <span class="ey"><b>[</b>&nbsp;AI Growth Systems&nbsp;<b>]</b></span>
        <h1 class="h1">Build <span class="r">AI Growth Systems</span> to automate operations, improve search visibility, and increase revenue.</h1>
        <p class="lede">Reinforce Lab connects your website, content, and organic search visibility into one growth engine: data-driven SEO, AI Search, and content systems built for growth-stage founders and ambitious B2B brands, engineered for measurable results.</p>
        <div class="cta-row">
          <a class="btn p" href="<?php echo esc_url($diag); ?>">Book a Strategy Call <span class="ar">&rarr;</span></a>
          <a class="btn g" href="<?php echo esc_url($svcs); ?>">Explore Services</a>
        </div>
        <p class="microtrust">Built for <b>Pharmaceutical &amp; Life Sciences · Healthcare · B2B SaaS · E-commerce · Manufacturing · Technology · Professional Services · Education</b></p>
      </div>
      <figure class="ge rl-anim"><div class="cap" aria-hidden="true"><span>Inputs</span><span>Engine</span><span>Outcomes</span></div><?php echo rl_home_ge_svg(); ?><?php if (function_exists('rl_ph')) echo rl_ph([['label' => 'Inputs', 'kind' => 'chips', 'items' => ['Search & SERP data', 'Content & website', 'Competitor research', 'Customer & social signals', 'AI-search visibility']], ['label' => 'Engine', 'kind' => 'core', 'title' => 'AI Growth System', 'sub' => 'Verify · build · automate · monitor'], ['label' => 'Outcomes', 'kind' => 'rows', 'items' => ['Automated operations', 'Content that ranks', 'Cited in AI search', 'Qualified pipeline', ['Increased revenue', 'hi']]]], 'Outcomes feed the next cycle'); ?></figure>
    </div>
  </section>

  <!-- OUTCOMES -->
  <section class="band alt">
    <div class="wrap">
      <div class="head"><span class="ey"><b>[</b>&nbsp;Why AI Growth Systems&nbsp;<b>]</b></span><h2>One system. Three outcomes that move the business.</h2></div>
      <div class="cols c3">
        <div class="outcome"><div class="k">01</div><h3>Automate Operations</h3><p>Replace manual, disconnected marketing and research work with AI workflows that run continuously and scale without more headcount.</p></div>
        <div class="outcome"><div class="k">02</div><h3>Improve Search Visibility</h3><p>Win on Google <em>and</em> AI search: SEO, GEO and AEO working together so you're found and cited where buyers now look.</p></div>
        <div class="outcome"><div class="k">03</div><h3>Increase Revenue</h3><p>Turn visibility into qualified pipeline with content and systems engineered to convert intent, measured by business impact, not vanity metrics.</p></div>
      </div>
    </div>
  </section>

  <!-- WHAT WE DO -->
  <section>
    <div class="wrap">
      <div class="head"><span class="ey"><b>[</b>&nbsp;What We Do&nbsp;<b>]</b></span><h2>The capabilities behind the engine.</h2><p class="lede">Adopt the full system, or start with the piece where the pain is sharpest. Each links to a deeper page.</p></div>
      <div class="cols c3">
        <a class="cell" href="<?php echo esc_url($u('services/ai-search-optimization')); ?>"><div class="n">SEARCH</div><h3>AI Search Optimization &amp; SEO</h3><p>Enterprise, technical, international and local SEO plus AI Search Optimization, engineered as one strategy.</p></a>
        <a class="cell" href="<?php echo esc_url($u('services/generative-engine-optimization')); ?>"><div class="n">AI SEARCH</div><h3>GEO &amp; LLM Optimization</h3><p>Be the source AI engines cite: Generative Engine Optimization and LLM optimization for ChatGPT, Perplexity, AI Overviews.</p></a>
        <a class="cell" href="<?php echo esc_url($u('services/seo-content-systems')); ?>"><div class="n">CONTENT</div><h3>SEO Content Systems</h3><p>Research-led, evidence-verified content produced and QA'd as a system, not a one-off quota.</p></a>
        <a class="cell" href="<?php echo esc_url($u('services/ai-workflow-automation')); ?>"><div class="n">AUTOMATE</div><h3>AI Workflow &amp; Marketing Automation</h3><p>Automate repetitive operations and marketing processes with reliable, monitored AI workflows.</p></a>
        <a class="cell" href="<?php echo esc_url($u('services/lead-generation-systems')); ?>"><div class="n">GROWTH</div><h3>Lead Generation Systems</h3><p>Scalable systems that turn organic visibility into qualified, trackable pipeline.</p></a>
        <a class="cell" href="<?php echo esc_url($u('services/executive-ai-consulting')); ?>"><div class="n">ADVISORY</div><h3>Executive AI Consulting</h3><p>Architect the system, define what matters, and run the plays, with human judgment in the loop.</p></a>
      </div>
      <div class="cta-row"><a class="btn g" href="<?php echo esc_url($svcs); ?>">See all services <span class="ar">&rarr;</span></a></div>
    </div>
  </section>

  <!-- PROBLEM -->
  <section class="band alt">
    <div class="wrap">
      <div class="head"><span class="ey"><b>[</b>&nbsp;The Problem&nbsp;<b>]</b></span><h2>Why does growth stall when marketing, search and operations run apart?</h2><p class="lede">Your website, content, search visibility, CRM and team workflows each live in their own tool. Every hand-off is manual, every report is stitched together by hand, and nobody can see which effort actually produces revenue.</p></div>
      <div class="pains">
        <div class="pain"><span class="x" aria-hidden="true"><svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" focusable="false"><path d="M4 4l8 8M12 4l-8 8"/></svg></span><p><b>Manual work eats the week.</b> Reporting, briefs, follow-ups and publishing still run on copy-paste. That is time your team should spend on decisions.</p></div>
        <div class="pain"><span class="x" aria-hidden="true"><svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" focusable="false"><path d="M4 4l8 8M12 4l-8 8"/></svg></span><p><b>Search visibility is fragmenting.</b> Buyers now research in Google, ChatGPT, Perplexity and AI Overviews. Most growth plans still measure only one of them.</p></div>
        <div class="pain"><span class="x" aria-hidden="true"><svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" focusable="false"><path d="M4 4l8 8M12 4l-8 8"/></svg></span><p><b>Leads leak between systems.</b> Traffic arrives and forms get filled, then nothing connects the visit to the pipeline or the next action.</p></div>
        <div class="pain"><span class="x" aria-hidden="true"><svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" focusable="false"><path d="M4 4l8 8M12 4l-8 8"/></svg></span><p><b>Reports describe activity, not revenue.</b> Rankings and traffic charts say little about what is actually growing the business.</p></div>
      </div>
      <p class="src">Sources: <a href="https://developers.google.com/search/docs/appearance/ai-features" rel="noopener" target="_blank">Google Search Central: AI features and your website</a> · <a href="https://platform.openai.com/docs/bots" rel="noopener" target="_blank">OpenAI: crawlers and user agents</a> · <a href="https://docs.perplexity.ai/guides/bots" rel="noopener" target="_blank">Perplexity: crawlers</a></p>
    </div>
  </section>

  <!-- SYSTEM / HOW -->
  <section>
    <div class="wrap">
      <div class="head"><span class="ey"><b>[</b>&nbsp;How it works&nbsp;<b>]</b></span><h2>How is an AI Growth System built?</h2><p class="lede">Every system connects four layers: your data, AI models, automated workflows and a revenue dashboard. We build it in four stages, run as one loop, whether we start with search, content, automation or lead generation. <a class="inl" href="<?php echo esc_url($u('services/ai-growth-systems')); ?>">See the systems we build</a>.</p></div>
      <ol class="steps" style="list-style:none;margin:0;padding:0">
        <li class="step"><div class="k" aria-hidden="true">01</div><h3>Diagnose</h3><p>Map your website, search visibility, content, workflows and funnel. Find where time, traffic and revenue are being lost.</p></li>
        <li class="step"><div class="k" aria-hidden="true">02</div><h3>Architect</h3><p>Design the system: which workflows to automate, which searches to own, and which data feeds which decision.</p></li>
        <li class="step"><div class="k" aria-hidden="true">03</div><h3>Build &amp; Automate</h3><p>Implement the workflows, pages, content engines and integrations, with human approval where it matters.</p></li>
        <li class="step"><div class="k" aria-hidden="true">04</div><h3>Measure &amp; Improve</h3><p>Track business outcomes: hours saved, qualified pipeline, visibility in Google and AI search, and tune the system every cycle.</p></li>
      </ol>
    </div>
  </section>

  <!-- INDUSTRIES -->
  <section class="band alt icp">
    <div class="wrap">
      <div class="head"><span class="ey"><b>[</b>&nbsp;Industries&nbsp;<b>]</b></span><h2>Built around how your industry buys.</h2><p class="lede">The same system, configured for your market's buyers, regulations and sales cycle.</p></div>
      <div class="cols c4">
        <a class="cell" href="<?php echo esc_url($u('industries/pharmaceutical')); ?>"><div class="who">Regulated</div><h3>Pharmaceutical &amp; Life Sciences</h3><p>Compliant content and automated workflows for long, evidence-driven buying cycles.</p></a>
        <a class="cell" href="<?php echo esc_url($u('industries/healthcare')); ?>"><div class="who">Trust</div><h3>Healthcare</h3><p>Visibility for patient- and provider-facing search, with review workflows built in.</p></a>
        <a class="cell" href="<?php echo esc_url($u('industries/b2b-saas')); ?>"><div class="who">Pipeline</div><h3>B2B SaaS</h3><p>Search, content and lead routing connected to trial, demo and revenue data.</p></a>
        <a class="cell" href="<?php echo esc_url($u('industries/ecommerce')); ?>"><div class="who">Conversion</div><h3>E-commerce</h3><p>Catalog content and search visibility measured against orders, not traffic.</p></a>
        <a class="cell" href="<?php echo esc_url($u('industries/manufacturing')); ?>"><div class="who">Technical</div><h3>Manufacturing</h3><p>Make technical capability findable and route RFQs to the right team faster.</p></a>
        <a class="cell" href="<?php echo esc_url($u('industries/technology')); ?>"><div class="who">Complex sale</div><h3>Technology</h3><p>Content and lead systems for multi-stakeholder buying committees.</p></a>
        <a class="cell" href="<?php echo esc_url($u('industries/professional-services')); ?>"><div class="who">Referral</div><h3>Professional Services</h3><p>Authority and lead capture for firms, including finance, legal and consulting.</p></a>
        <a class="cell" href="<?php echo esc_url($u('industries/education')); ?>"><div class="who">Enrollment</div><h3>Education</h3><p>Program visibility and enquiry automation across the full enrollment cycle.</p></a>
      </div>
    </div>
  </section>

  <!-- FLAGSHIP OS -->
  <section>
    <div class="wrap">
      <div class="flagship">
        <div>
          <div class="tag">[ Flagship Product ]</div>
          <h2>Search Authority OS</h2>
          <p class="lede">Our flagship AI system that continuously researches your market, verifies every claim against real evidence, produces high-value content, and monitors your visibility across Google and AI search, then improves itself over time.</p>
          <div class="cta-row">
            <a class="btn p" href="<?php echo esc_url($os); ?>">Explore Search Authority OS <span class="ar">&rarr;</span></a>
            <a class="btn g" href="<?php echo esc_url($pkg); ?>">See packages</a>
          </div>
        </div>
        <div class="engine" style="background:linear-gradient(180deg,var(--panel-2,#211a1b),var(--bg-2))">
          <div class="cap"><span>Reinforce Lab OPS</span><span>Human Judgment</span></div>
          <div class="core" style="margin-top:6px"><b>Search Authority OS</b><small>RESEARCH · VERIFY · WRITE · AUDIT · MONITOR</small></div>
          <p class="microtrust" style="margin-top:14px">We architect the system, define what matters, and run the search plays for you.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- PROOF -->
  <section class="band alt">
    <div class="wrap">
      <div class="head"><span class="ey"><b>[</b>&nbsp;Proof&nbsp;<b>]</b></span><h2>We run this system on ourselves.</h2><p class="lede">Reinforce Lab is its own R&amp;D lab. Your diagnostic establishes your real baseline: no borrowed numbers, no invented results.</p></div>
      <div class="proof">
        <div class="stat"><div class="fig"><span class="ph">Your baseline</span></div><div class="lab">Organic visibility today</div></div>
        <div class="stat"><div class="fig"><span class="ph">Your gap</span></div><div class="lab">AI-search presence</div></div>
        <div class="stat"><div class="fig"><span class="ph">Your opportunity</span></div><div class="lab">Uncaptured demand</div></div>
        <div class="stat"><div class="fig"><span class="ph">Your plan</span></div><div class="lab">90-day priorities</div></div>
      </div>
      <p class="microtrust" style="margin-top:20px">Case studies and metrics are added only when verified. Placeholders above are replaced by your own diagnostic data.</p>
    </div>
  </section>

  <!-- PACKAGES (teaser: detail lives on /packages/ and /search-authority-os/) -->
  <section>
    <div class="wrap">
      <div class="head"><span class="ey"><b>[</b>&nbsp;Packages&nbsp;<b>]</b></span><h2>Start with a diagnostic. Scale when it's working.</h2><p class="lede">Three engagement levels: <b style="color:var(--ink)">Foundation</b>, <b style="color:var(--ink)">Growth OS</b> and <b style="color:var(--ink)">Enterprise</b>, from a focused starting system to full enterprise governance. Every engagement begins with a diagnostic, and pricing is set to scope. Engagements start from $5,000 setup.</p>
        <div class="cta-row"><a class="btn p" href="<?php echo esc_url($pkg); ?>">Compare packages <span class="ar">&rarr;</span></a><a class="btn g" href="<?php echo esc_url($diag); ?>">Get your diagnostic</a></div>
      </div>
    </div>
  </section>

  <!-- FAQ (company + category level; product FAQs live on /search-authority-os/) -->
  <section class="band alt faq">
    <div class="wrap" style="max-width:900px">
      <div class="head"><span class="ey"><b>[</b>&nbsp;Questions&nbsp;<b>]</b></span><h2>What should you know about AI Growth Systems?</h2></div>
      <?php foreach (rl_home_faqs() as $k => $f) { ?>
      <details<?php echo $k === 0 ? ' open' : ''; ?>><summary><h3 style="font:inherit;letter-spacing:inherit;margin:0"><?php echo esc_html($f[0]); ?></h3></summary><p><?php echo $f[1]; ?></p></details>
      <?php } ?>
    </div>
  </section>

  <!-- BLOG -->
  <section>
    <div class="wrap">
      <div class="head"><span class="ey"><b>[</b>&nbsp;Insights&nbsp;<b>]</b></span><h2>From the blog.</h2><p class="lede">Field notes on AI Search, GEO, evidence-based content, and building growth systems that keep improving.</p></div>
      <div class="cols c3">
        <?php
        $bq = new WP_Query(array('post_type'=>'post','posts_per_page'=>3,'post_status'=>'publish','ignore_sticky_posts'=>true));
        if ($bq->have_posts()) {
          while ($bq->have_posts()) { $bq->the_post();
            $thumb = get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>
          <a class="cell pcard" href="<?php the_permalink(); ?>">
            <div class="pthumb<?php echo $thumb ? '' : ' ph-grid'; ?>"<?php echo $thumb ? ' style="background-image:url('.esc_url($thumb).')"' : ''; ?>></div>
            <div class="pbody">
              <div class="pmeta"><?php echo esc_html(get_the_date()); ?></div>
              <h3><?php echo esc_html(get_the_title()); ?></h3>
              <p><?php echo esc_html(wp_trim_words(wp_strip_all_tags(get_the_excerpt()),24)); ?></p>
            </div>
          </a>
          <?php }
          wp_reset_postdata();
        } else {
          $ph = array(
            array('AI Search','How to get cited by ChatGPT, Perplexity &amp; AI Overviews','The playbook for showing up inside AI answers: the structure, evidence and entity signals that get you referenced as well as ranked.'),
            array('GEO','GEO vs SEO: what actually changes for 2026','Generative Engine Optimization is not a rebrand of SEO. What changes, what stays the same, and where to put your effort first.'),
            array('Evidence','Building an evidence layer for regulated content','Why "no source, no claim" is now the standard for regulated content, and how to check every claim without slowing the team down.'),
          );
          foreach ($ph as $p) { ?>
          <div class="cell pcard">
            <div class="pthumb ph-grid"><span class="ptag"><?php echo $p[0]; ?></span></div>
            <div class="pbody">
              <div class="pmeta"><?php echo $p[0]; ?> &middot; Coming soon</div>
              <h3><?php echo $p[1]; ?></h3>
              <p><?php echo $p[2]; ?></p>
            </div>
          </div>
          <?php }
        } ?>
      </div>
      <div class="cta-row"><a class="btn g" href="<?php echo esc_url(rl_url_by_path('blog')); ?>">Read the blog <span class="ar">&rarr;</span></a></div>
    </div>
  </section>

  <!-- FINAL CTA -->
  <section>
    <div class="wrap">
      <div class="final">
        <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
        <h2>Find out what's limiting your growth.</h2>
        <p class="lede center">A data-backed diagnostic of your Google visibility, AI-search presence, content authority, competitors and demand, with a clear 90-day plan. No generic scorecard.</p>
        <div class="cta-row">
          <a class="btn p" href="<?php echo esc_url($diag); ?>">Book a Strategy Call <span class="ar">&rarr;</span></a>
          <a class="btn g" href="<?php echo esc_url($pkg); ?>">Compare packages</a>
        </div>
        <p class="microtrust" style="margin-top:24px">For selected businesses and organizations · Confidential · No purchased lists</p>
      </div>
    </div>
  </section>

</div>
<?php
    return ob_get_clean();
}
