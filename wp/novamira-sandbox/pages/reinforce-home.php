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
.rl-home .ge .cap span{font-family:var(--f-mono);font-size:12px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
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
        return '<g class="' . $cls . '"><rect class="ge-n" x="' . $x . '" y="' . $y . '" width="150" height="40"/><rect class="ge-fill" x="' . $x . '" y="' . $y . '" width="150" height="40"/><rect class="ge-nl" x="' . $x . '" y="' . $y . '" width="150" height="40"/>'
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
    $s .= '<g class="ge-L ge-L-edges">' . $edges . '<path class="ge-fb" d="' . $fb . '"/><path class="ge-p ge-pf" pathLength="100" d="' . $fb . '"/>'
        . '<text class="ge-fbl" x="270" y="338" text-anchor="middle">OUTCOMES FEED THE NEXT CYCLE</text><text class="ge-fbl-on" x="270" y="338" text-anchor="middle">OUTCOMES FEED THE NEXT CYCLE</text><g class="ge-pk"></g></g>';
    $s .= '<g class="ge-L ge-L-in">'; foreach ($d['in'] as $i => $l) $s .= $node(0, 20 + 54 * $i, $l, 'ge-i' . $i); $s .= '</g>';
    $s .= '<g class="ge-L ge-L-out">'; foreach ($d['out'] as $i => $l) $s .= $node(390, 20 + 54 * $i, $l, 'ge-o' . $i); $s .= '</g>';
    $s .= '<g class="ge-L ge-L-core"><rect class="ge-c" x="200" y="93" width="140" height="110"/><rect class="ge-cg" x="196" y="89" width="148" height="118"/><path class="ge-trace" pathLength="100" d="M200 93 H340 V203 H200 Z"/>'
        . '<text class="ge-ct" x="270" y="128" text-anchor="middle">AI Growth</text><text class="ge-ct" x="270" y="148" text-anchor="middle">System</text>';
    foreach ($d['st'] as $j => $t) {
        $x = 214 + $j * 23;
        $s .= '<text class="ge-st ge-t' . $j . '" x="270" y="172" text-anchor="middle">' . $h(strtoupper($t)) . '</text>'
            . '<rect class="ge-sb" x="' . $x . '" y="184" width="20" height="3"/><rect class="ge-sl ge-s' . $j . '" x="' . $x . '" y="184" width="20" height="3"/>';
    }
    return $s . '</g></svg>';
}

add_action('wp_head', 'rl_home_css', 22);
function rl_home_css() {
    if (!is_front_page() && !is_page('home')) return; ?>
<style id="rl-home-css">
.rl-home .src{font-family:var(--f-mono);font-size:12px;letter-spacing:.02em;line-height:1.7;color:var(--ink-faint);margin:16px 0 0}
.rl-home .src a{color:var(--ink-dim);border-bottom:1px solid var(--red-line);text-decoration:none}
/* full-bleed breakout of theme container + kill content padding on home */
.rl-home{position:relative;width:100vw;margin-left:calc(50% - 50vw);overflow-x:clip}
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
.rl-home h1,.rl-home h2,.rl-home h3,.rl-home h4{font-family:var(--f-display);font-weight:600;text-transform:uppercase;margin:0;line-height:1.02;letter-spacing:.01em;text-wrap:balance}.rl-home p,.rl-home li{text-wrap:pretty}
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
.rl-home .engine .cap span{font-family:var(--f-mono);font-size:12px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase}
.rl-home .core{border:1px solid var(--red-line);background:linear-gradient(180deg,rgba(153,0,0,.11),rgba(153,0,0,.03));padding:20px 16px;text-align:center;box-shadow:0 0 40px -14px var(--red-glow)}
.rl-home .core b{font-family:var(--f-display);text-transform:uppercase;font-weight:600;font-size:15px;display:block;letter-spacing:.04em}
.rl-home .core small{font-family:var(--f-mono);font-size:12px;color:var(--ink-faint);letter-spacing:.12em}
/* cards */
.rl-home .cols{display:grid;gap:16px}
.rl-home .cols.c2{grid-template-columns:repeat(2,1fr)}.rl-home .cols.c3{grid-template-columns:repeat(3,1fr)}.rl-home .cols.c4{grid-template-columns:repeat(4,1fr)}
@media(max-width:900px){.rl-home .cols.c3,.rl-home .cols.c4{grid-template-columns:repeat(2,1fr)}}
@media(max-width:560px){.rl-home .cols.c2,.rl-home .cols.c3,.rl-home .cols.c4{grid-template-columns:1fr}}
.rl-home .cell{background:var(--glass);backdrop-filter:blur(16px);border:1px solid var(--glass-line);padding:26px;box-shadow:inset 0 1px 0 var(--glass-hi),0 24px 60px -40px rgba(0,0,0,.9);transition:.2s;display:block}
.rl-home .cell:hover{border-color:var(--red-line);background:var(--glass-2)}
.rl-home .cell .n{font-family:var(--f-mono);font-size:12px;color:var(--red-3);letter-spacing:.1em}
.rl-home .cell h3{font-size:20px;margin:12px 0 8px}.rl-home .cell p{color:var(--ink-dim);font-size:16px}
.rl-home .pmeta{font-family:var(--f-mono);font-size:12px;color:var(--red-3);letter-spacing:.08em;text-transform:uppercase;margin-bottom:10px}
.rl-home .pcard{padding:0;overflow:hidden;display:flex;flex-direction:column}
.rl-home .pcard .pthumb{aspect-ratio:16/9;width:100%;background-size:cover;background-position:center;background-color:#0f0c0d;border-bottom:1px solid var(--red-line);position:relative}
.rl-home .pcard .pthumb.ph-wash{background-image:radial-gradient(120% 130% at 100% 0%,rgba(153,0,0,.42),transparent 62%)}
.rl-home .pcard .pthumb .ptag{position:absolute;left:16px;bottom:12px;font-family:var(--f-display);text-transform:uppercase;font-size:clamp(20px,2.4vw,30px);font-weight:700;color:rgba(255,255,255,.92);letter-spacing:.01em;text-shadow:0 2px 20px rgba(0,0,0,.6)}
.rl-home .pcard .pbody{padding:24px}
/* outcomes */
.rl-home .outcome{background:var(--glass);backdrop-filter:blur(16px);border:1px solid var(--glass-line);padding:32px 28px;box-shadow:inset 0 1px 0 var(--glass-hi);text-align:left}
.rl-home .outcome .k{font-family:var(--f-mono);font-size:12px;color:var(--red-3);letter-spacing:.14em}
.rl-home .outcome h3{font-size:20px;margin:14px 0 10px}.rl-home .outcome p{color:var(--ink-dim);font-size:16px}
/* pains */
.rl-home .pains{display:grid;grid-template-columns:1fr 1fr;gap:14px}@media(max-width:640px){.rl-home .pains{grid-template-columns:1fr}}
.rl-home .pain{background:var(--glass);backdrop-filter:blur(16px);border:1px solid var(--glass-line);padding:22px 24px;display:flex;gap:16px;box-shadow:inset 0 1px 0 var(--glass-hi)}
.rl-home .pain .x{color:var(--red-3);font-family:var(--f-mono);flex:none;margin-top:2px}.rl-home .pain p{color:var(--ink-dim);font-size:16px}.rl-home .pain b{color:var(--ink)}
/* steps */
.rl-home .steps{display:grid;grid-template-columns:repeat(4,1fr);gap:16px}@media(max-width:900px){.rl-home .steps{grid-template-columns:repeat(2,1fr)}}@media(max-width:520px){.rl-home .steps{grid-template-columns:1fr}}
.rl-home .step{background:var(--glass);backdrop-filter:blur(16px);border:1px solid var(--glass-line);padding:24px;box-shadow:inset 0 1px 0 var(--glass-hi)}
.rl-home .step .k{font-family:var(--f-display);font-size:34px;color:var(--red-3);font-weight:700;opacity:.8}.rl-home .step h3,.rl-home .step h4{font-size:20px;margin:8px 0}.rl-home .step p{color:var(--ink-dim);font-size:16px}
/* industries */
.rl-home .icp .who{font-family:var(--f-mono);font-size:12px;color:var(--ink-faint);letter-spacing:.12em;text-transform:uppercase;margin-bottom:10px}
.rl-home .icp h3{font-size:20px}.rl-home .icp p{color:var(--ink-dim);font-size:16px;margin-top:8px}
/* flagship callout */
.rl-home .flagship{border:1px solid var(--red-line);background:linear-gradient(120deg,rgba(153,0,0,.07),transparent 55%),var(--panel);padding:clamp(32px,5vw,56px);display:grid;grid-template-columns:minmax(0,1.4fr) minmax(0,1fr);gap:36px;align-items:center;box-shadow:0 24px 60px -46px rgba(0,0,0,.85)}
@media(max-width:940px){.rl-home .flagship{grid-template-columns:minmax(0,1fr)}}
.rl-home .flagship .tag{font-family:var(--f-mono);font-size:12px;letter-spacing:.16em;color:var(--red-3);text-transform:uppercase}
.rl-home .flagship h2{font-size:clamp(26px,3.6vw,40px);margin:12px 0 14px}
/* D-169 hero diagram direction ("one cycle of growth", core/reinforce-motion.js heroSystem): new layers are invisible
   until the script takes over (.ge-gs), so without JavaScript or with reduced motion the diagram looks exactly as before */
.rl-home .ge-fill{fill:rgba(153,0,0,.22);opacity:0}
.rl-home .ge-trace{fill:none;stroke:var(--red-3);stroke-width:1.6;stroke-dasharray:14 86;stroke-linecap:square;opacity:0}
.rl-home .ge.ge-gs .ge-nl,.rl-home .ge.ge-gs .ge-p,.rl-home .ge.ge-gs .ge-cg,.rl-home .ge.ge-gs .ge-st,.rl-home .ge.ge-gs .ge-sl,.rl-home .ge.ge-gs .ge-fbl-on{animation:none!important}
.rl-home .ge.ge-gs .ge-tx{transition:fill .5s}
.rl-home .ge-L{transition:transform .9s cubic-bezier(.22,1,.36,1)}
.rl-home .ge.ge-gs .ge-L-in>g,.rl-home .ge.ge-gs .ge-L-out>g{cursor:default}
/* D-167 diagnostic scan behind the closing call to action (desktop WebGL, reinforce-scan.js); above the panel's glow, below its text */
.rl-home .final .scan-cv{position:absolute;inset:0;width:100%;height:100%;z-index:1;pointer-events:none;opacity:0;transition:opacity 1.4s}
.rl-home .final .scan-cv.on{opacity:1}
/* D-165 signal field behind "One system. Three outcomes": the CSS dotted floor is the still version (phones, reduced motion, no WebGL); the WebGL canvas fades in over it on desktop */
.rl-home .sig-sec{overflow:hidden;padding-bottom:clamp(56px,15vw,220px)}
.rl-home .sig-sec>.wrap{position:relative;z-index:2}
.rl-home .sig-bg,.rl-home .sig-cv{position:absolute;left:0;right:0;bottom:0;height:78%;pointer-events:none;z-index:1}
.rl-home .sig-bg{background-image:radial-gradient(rgba(232,80,80,.32) 1px,transparent 1.4px);background-size:22px 22px;transform:perspective(520px) rotateX(58deg);transform-origin:50% 100%;-webkit-mask-image:linear-gradient(to top,#000 10%,transparent 85%);mask-image:linear-gradient(to top,#000 10%,transparent 85%);opacity:.55;transition:opacity 1.2s}
.rl-home .sig-cv{width:100%;opacity:0;transition:opacity 1.4s;-webkit-mask-image:linear-gradient(to top,#000 45%,transparent 80%);mask-image:linear-gradient(to top,#000 45%,transparent 80%)}
.rl-home .sig-cv.on{opacity:1}.rl-home .sig-sec:has(.sig-cv.on) .sig-bg{opacity:0}
/* Search Authority OS stage list (D-163): plain list without JavaScript; the motion script lights the stages in turn */
.rl-home .os-steps{list-style:none;margin:14px 0 0;padding:0;display:grid;gap:6px}
.rl-home .os-steps li{display:grid;grid-template-columns:34px 92px minmax(0,1fr);align-items:center;gap:12px;margin:0;padding:9px 12px;border:1px solid var(--line);background:rgba(255,255,255,.01)}
.rl-home .os-steps .os-n{width:34px;height:24px;display:grid;place-items:center;border:1px solid var(--line-2);font-family:var(--f-mono);font-size:12px;color:var(--ink-faint)}
.rl-home .os-steps b{font-family:var(--f-display);text-transform:uppercase;font-weight:600;font-size:16px;letter-spacing:.04em;color:var(--ink-dim)}
.rl-home .os-steps li>span:last-child{font-size:16px;color:var(--ink-dim);line-height:1.35}
@media(max-width:560px){.rl-home .os-steps li{grid-template-columns:30px minmax(0,1fr)}.rl-home .os-steps li>span:last-child{grid-column:2}}
/* D-160 layout variety, the rest. Outcomes: three statements, no boxes */
.rl-home .oc{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:0}
.rl-home .oc-i{padding:6px clamp(20px,3vw,40px) 6px clamp(20px,3vw,40px);border-left:1px solid var(--red-line)}
.rl-home .oc-i:first-child{padding-left:0;border-left:0}
.rl-home .oc-i .k{font-family:var(--f-mono);font-size:12px;letter-spacing:.14em;color:var(--red-3)}
.rl-home .oc-i h3{font-size:clamp(28px,3vw,40px);line-height:1.02;margin:16px 0 16px}
.rl-home .oc-i h3 span{display:block;color:var(--red-3)}
.rl-home .oc-i p{margin:0;color:var(--ink-dim);font-size:16px;max-width:38ch}
@media(max-width:900px){.rl-home .oc{grid-template-columns:1fr;gap:28px}.rl-home .oc-i,.rl-home .oc-i:first-child{padding:0 0 0 22px;border-left:1px solid var(--red-line)}}
/* Problem: heading held on the left, problems as a list on the right */
.rl-home .pr-split{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1.15fr);gap:clamp(40px,7vw,120px);align-items:start}
.rl-home .pr-split .head{position:sticky;top:110px;margin-bottom:0}
.rl-home .pr-split .pains{grid-template-columns:1fr;gap:0;border-top:1px solid var(--line-2)}
.rl-home .pr-split .pain{background:none;backdrop-filter:none;box-shadow:none;border:0;border-bottom:1px solid var(--line-2);padding:28px 0;gap:22px;align-items:flex-start}
.rl-home .pr-split .pain .x{width:36px;height:36px;display:grid;place-items:center;border:1px solid var(--red-line);background:rgba(153,0,0,.10);margin-top:0}
.rl-home .pr-split .pain p{font-size:16px;line-height:1.6}.rl-home .pr-split .pain b{display:block;font-family:var(--f-display);font-weight:600;text-transform:uppercase;font-size:20px;line-height:1.15;margin-bottom:6px;letter-spacing:.01em}
@media(max-width:900px){.rl-home .pr-split{grid-template-columns:1fr;gap:32px}.rl-home .pr-split .head{position:static}}
/* Industries: two-column list with drawn icons */
.rl-home .ind{list-style:none;margin:0;padding:0;display:grid;grid-template-columns:repeat(2,minmax(0,1fr));column-gap:clamp(24px,4vw,64px);border-top:1px solid var(--line-2)}
.rl-home .ind li{margin:0;border-bottom:1px solid var(--line-2)}
.rl-home .ind a{display:grid;grid-template-columns:48px minmax(0,1fr) 24px;gap:6px 20px;align-items:center;padding:22px 4px;transition:background .25s}
.rl-home .ind .ic{grid-row:1/span 2;width:48px;height:48px;display:grid;place-items:center;border:1px solid var(--line-2);color:var(--red-3);transition:all .25s}
.rl-home .ind .t{display:flex;align-items:baseline;gap:12px;flex-wrap:wrap}
.rl-home .ind h3{font-size:20px;margin:0;transition:color .2s}
.rl-home .ind .who{font-family:var(--f-mono);font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--ink-faint)}
.rl-home .ind p{grid-column:2;margin:0;color:var(--ink-dim);font-size:16px}
.rl-home .ind .ar2{grid-column:3;grid-row:1/span 2;color:var(--ink-faint);transition:all .25s}
.rl-home .ind a:hover{background:linear-gradient(90deg,rgba(153,0,0,.10),transparent 75%)}
.rl-home .ind a:hover .ic{border-color:var(--red);background:var(--red);color:#fff}.rl-home .ind a:hover h3{color:var(--red-3)}.rl-home .ind a:hover .ar2{color:var(--red-3);transform:translateX(4px)}
@media(max-width:900px){.rl-home .ind{grid-template-columns:1fr}}
/* Clients + recognition in one section */
.rl-home .rec-sub{margin-top:clamp(56px,7vw,88px);padding-top:clamp(32px,4vw,44px);border-top:1px solid var(--line-2);display:grid;grid-template-columns:minmax(0,1fr);gap:12px;justify-items:start;margin-bottom:28px}
.rl-home .rec-sub h3{font-size:clamp(24px,2.6vw,32px);line-height:1.1;margin:0}
.rl-home .rec-sub p{margin:0;color:var(--ink-dim);font-size:16px;max-width:60ch}
.rl-home .rec .tile{height:160px}
/* HackerNoon award, featured above the badges (D-161); text from rl_awards_data() on /awards/ */
.rl-home .hn{display:grid;grid-template-columns:auto minmax(0,1.3fr) minmax(0,1fr);gap:clamp(24px,4vw,56px);align-items:center;padding:clamp(28px,4vw,44px);margin-bottom:24px;border:1px solid var(--red-line);background:linear-gradient(120deg,rgba(153,0,0,.18),var(--panel) 60%);box-shadow:0 0 90px -40px var(--red-glow)}
.rl-home .hn .cup{width:96px;height:96px;display:grid;place-items:center;border:1px solid var(--red-line);background:rgba(153,0,0,.12);color:var(--red-3)}
.rl-home .hn .by{display:block;font-family:var(--f-mono);font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:var(--red-3);margin-bottom:10px}
.rl-home .hn h4{font-family:var(--f-display);text-transform:uppercase;font-weight:700;font-size:clamp(26px,3vw,38px);line-height:1.05;margin:0 0 12px;color:var(--ink)}
.rl-home .hn p{margin:0;color:var(--ink-dim);font-size:16px;max-width:56ch}
.rl-home .hn .src-l{display:inline-block;margin-top:16px;color:var(--ink);border-bottom:1px solid var(--red-line);font-size:16px}
.rl-home .hn .src-l:hover{color:var(--red-3)}
.rl-home .hn ul{list-style:none;margin:0;padding:0;border-left:1px solid var(--red-line)}
.rl-home .hn li{margin:0;padding:12px 0 12px 22px;border-bottom:1px solid var(--line)}.rl-home .hn li:last-child{border-bottom:0}
.rl-home .hn li a{display:block;color:var(--ink);font-size:16px;line-height:1.35}.rl-home .hn li a:hover{color:var(--red-3)}
.rl-home .hn li small{display:block;font-family:var(--f-mono);font-size:12px;letter-spacing:.1em;text-transform:uppercase;color:var(--ink-faint);margin-top:4px}
@media(max-width:1000px){.rl-home .hn{grid-template-columns:auto minmax(0,1fr)}.rl-home .hn ul{grid-column:1/-1}}
@media(max-width:560px){.rl-home .hn{grid-template-columns:1fr}.rl-home .hn .cup{width:72px;height:72px}}
/* Blog: heading and button left, posts right as wide cards */
/* D-185: blog section: heading row across the width, then three equal article cards (same card language as /blog/) */
.rl-home .bl-top{margin-bottom:clamp(28px,4vw,44px)}
.rl-home .bl-cta{margin-top:clamp(28px,3.5vw,40px)}
.rl-home .bl-posts{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:clamp(16px,2vw,24px)}
.rl-home .bl-posts .pcard{display:flex;flex-direction:column;padding:0;border:1px solid var(--line-2);background:var(--bg-2);text-decoration:none;transition:border-color .2s}
.rl-home .bl-posts .pcard:hover{border-color:var(--red-line)}
.rl-home .bl-posts .pthumb{aspect-ratio:16/9;height:auto;min-height:0;border-bottom:1px solid var(--line-2)}
.rl-home .bl-posts .pthumb.ph{display:flex;flex-direction:column;justify-content:flex-end;gap:8px;padding:22px;background:radial-gradient(80% 90% at 85% 10%,rgba(153,0,0,.28),transparent 60%),linear-gradient(180deg,var(--panel),var(--bg-2))}
.rl-home .bl-posts .pthumb.ph::before{content:"";position:absolute;left:22px;top:22px;width:44px;height:2px;background:var(--red-2)}
.rl-home .bl-posts .pthumb.ph span{font-family:var(--f-mono);font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:var(--red-3)}
.rl-home .bl-posts .pthumb.ph b{font-family:var(--f-display);font-size:clamp(22px,2.2vw,28px);text-transform:uppercase;line-height:1.05;color:var(--ink);font-weight:600}
.rl-home .bl-posts .pbody{padding:22px;display:flex;flex-direction:column;gap:10px;flex:1}
.rl-home .bl-posts .pmeta{font-family:var(--f-mono);font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--ink-faint);margin:0}
.rl-home .bl-posts .pmeta .t{color:var(--ink)}.rl-home .bl-posts .pmeta .c{color:var(--red-3)}
.rl-home .bl-posts h3{font-size:20px;line-height:1.15;margin:0;color:var(--ink)}
.rl-home .bl-posts p{color:var(--ink-dim);font-size:16px;margin:0}
.rl-home .bl-posts .more{margin-top:auto;padding-top:6px;font-family:var(--f-display);text-transform:uppercase;letter-spacing:.05em;font-size:14px;color:var(--ink)}
.rl-home .bl-posts .pcard:hover .more{color:var(--red-3)}
@media(max-width:1000px){.rl-home .bl-posts{grid-template-columns:repeat(2,minmax(0,1fr))}.rl-home .bl-posts .pcard:nth-child(3){display:none}}
@media(max-width:600px){.rl-home .bl-posts{grid-template-columns:minmax(0,1fr)}.rl-home .bl-posts .pcard:nth-child(3){display:flex}}
/* D-158 layout variety (the split headings of step 1 were taken back at Jamil's request, D-159: intro stays under the heading) */
/* (2) What we do: a numbered index, one row per service */
.rl-home .ix{list-style:none;margin:0;padding:0;border-top:1px solid var(--line-2);counter-reset:ix}
.rl-home .ix li{margin:0;border-bottom:1px solid var(--line-2)}
.rl-home .ix a{display:grid;grid-template-columns:72px minmax(0,1.15fr) minmax(0,1.5fr) 48px;gap:24px;align-items:center;padding:26px 8px;position:relative;transition:background .25s}
.rl-home .ix a::before{content:"";position:absolute;left:0;top:-1px;bottom:-1px;width:2px;background:var(--red);transform:scaleY(0);transform-origin:top;transition:transform .25s}
.rl-home .ix a:hover{background:linear-gradient(90deg,rgba(153,0,0,.10),transparent 70%)}
.rl-home .ix a:hover::before{transform:scaleY(1)}
.rl-home .ix .no{font-family:var(--f-display);font-size:34px;font-weight:700;line-height:1;color:transparent;-webkit-text-stroke:1px var(--red-2);padding-left:14px}
.rl-home .ix .tg{display:block;font-family:var(--f-mono);font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:var(--red-3);margin-bottom:6px}
.rl-home .ix h3{font-size:24px;line-height:1.15;margin:0;transition:color .2s}
.rl-home .ix p{margin:0;color:var(--ink-dim);font-size:16px;max-width:60ch}
.rl-home .ix .go{justify-self:end;width:40px;height:40px;display:grid;place-items:center;border:1px solid var(--line-2);color:var(--ink-dim);transition:all .25s}
.rl-home .ix a:hover h3{color:var(--red-3)}.rl-home .ix a:hover .go{border-color:var(--red);background:var(--red);color:#fff;transform:translateX(4px)}
@media(max-width:900px){.rl-home .ix a{grid-template-columns:52px minmax(0,1fr) 40px;row-gap:8px;padding:22px 4px}.rl-home .ix .no{font-size:26px;padding-left:8px;grid-row:1/span 2}.rl-home .ix p{grid-column:2;grid-row:2}.rl-home .ix .go{grid-column:3;grid-row:1/span 2}}
/* (3) How it works: four stages on one rail */
.rl-home .tline{list-style:none;margin:0;padding:0;display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:0 clamp(20px,3vw,40px);position:relative}
.rl-home .tline::before{content:"";position:absolute;left:0;right:0;top:9px;height:1px;background:linear-gradient(90deg,var(--line-2),var(--red-2) 60%,var(--red))}
.rl-home .tline li{position:relative;margin:0;padding-top:44px}
.rl-home .tline .nd{position:absolute;top:0;left:0;width:19px;height:19px;border:1px solid var(--red-2);background:var(--bg);display:grid;place-items:center}
.rl-home .tline .nd::after{content:"";width:7px;height:7px;background:var(--red-2)}
.rl-home .tline li:last-child .nd{background:var(--red);border-color:var(--red);box-shadow:0 0 24px -2px var(--red-glow)}.rl-home .tline li:last-child .nd::after{background:#fff}
.rl-home .tline .k{font-family:var(--f-display);font-size:clamp(56px,6vw,88px);font-weight:700;line-height:.85;color:transparent;-webkit-text-stroke:1px var(--line-2);letter-spacing:-.02em;margin-bottom:18px;transition:-webkit-text-stroke-color .3s}
.rl-home .tline li:hover .k{-webkit-text-stroke-color:var(--red-2)}
.rl-home .tline h3{font-size:20px;margin:0 0 10px}
.rl-home .tline p{margin:0;color:var(--ink-dim);font-size:16px}
@media(max-width:900px){.rl-home .tline{grid-template-columns:1fr;gap:34px}.rl-home .tline::before{left:9px;right:auto;top:10px;bottom:10px;width:1px;height:auto;background:linear-gradient(180deg,var(--line-2),var(--red))}.rl-home .tline li{padding:0 0 0 46px}.rl-home .tline .k{font-size:48px;margin-bottom:10px}}
/* clients (D-156, motion D-157): the 24 logos from production's home in two rows that scroll right to left; each row holds its logos twice
   (second copy aria-hidden) and moves by half its width, so the loop has no seam. Hover pauses; reduced motion shows a still, wrapped row. */
.rl-home .cl-rows{display:grid;gap:14px;-webkit-mask-image:linear-gradient(90deg,transparent,#000 8%,#000 92%,transparent);mask-image:linear-gradient(90deg,transparent,#000 8%,#000 92%,transparent)}
.rl-home .cl-row{overflow:hidden;border-top:1px solid var(--line);border-bottom:1px solid var(--line)}
.rl-home .cl-track{display:flex;width:max-content;animation:rl-cl-scroll 60s linear infinite}
.rl-home .cl-row.r2 .cl-track{animation-duration:72s}
.rl-home .cl-row:hover .cl-track{animation-play-state:paused}
.rl-home .cl-set{display:flex;margin:0;padding:0;list-style:none}
.rl-home .cl-set li{flex:none;width:220px;height:112px;display:grid;place-items:center;padding:18px 26px;margin:0;border-right:1px solid var(--line)}
.rl-home .cl-set img{max-width:100%;max-height:60px;width:auto;height:auto;object-fit:contain;opacity:.86;transition:opacity .2s}
.rl-home .cl-set li:hover img{opacity:1}
@keyframes rl-cl-scroll{from{transform:translateX(0)}to{transform:translateX(-50%)}}
@media(max-width:760px){.rl-home .cl-set li{width:150px;height:84px;padding:12px 16px}.rl-home .cl-set img{max-height:42px}.rl-home .cl-track{animation-duration:45s}.rl-home .cl-row.r2 .cl-track{animation-duration:54s}}
@media(prefers-reduced-motion:reduce){.rl-home .cl-rows{-webkit-mask-image:none;mask-image:none}.rl-home .cl-track{animation:none;width:auto}.rl-home .cl-set{flex-wrap:wrap}.rl-home .cl-set[aria-hidden]{display:none}}
.rl-home .cl-more{margin-top:22px}
/* recognition (D-152): badges on light tiles, because two badges have dark text; class "rec", not "badge" (Bootstrap 4 styles .badge) */
.rl-home .recs{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:16px;list-style:none;margin:0;padding:0}@media(max-width:1100px){.rl-home .recs{grid-template-columns:repeat(3,minmax(0,1fr))}}@media(max-width:560px){.rl-home .recs{grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}}
.rl-home .rec{display:flex;flex-direction:column;height:100%;border:1px solid var(--glass-line);background:var(--panel);transition:border-color .2s}
.rl-home .rec:hover{border-color:var(--red-line)}
.rl-home .rec .tile{background:#f4f4f4;display:flex;align-items:center;justify-content:center;height:200px;padding:20px;box-sizing:border-box;overflow:hidden}@media(max-width:560px){.rl-home .rec .tile{height:160px;padding:16px}}
.rl-home .rec img{display:block;max-width:100%;max-height:100%;width:auto;height:auto;object-fit:contain}
.rl-home .rec .cap{padding:14px 14px 16px;display:flex;flex-direction:column;gap:4px;flex:1}
.rl-home .rec .who{font-family:var(--f-mono);font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3)}
.rl-home .rec .what{font-size:16px;line-height:1.35;color:var(--ink-dim)}
.rl-home .rec:hover .what{color:var(--ink)}
/* testimonials (D-153): client words as published on production, square photos, no star ratings (no rating source) */
.rl-home .quotes{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px}@media(max-width:820px){.rl-home .quotes{grid-template-columns:minmax(0,1fr)}}
.rl-home .quote{margin:0;display:flex;flex-direction:column;gap:24px;padding:clamp(24px,3vw,36px);background:var(--panel);border:1px solid var(--glass-line);box-shadow:inset 0 1px 0 var(--glass-hi)}
.rl-home .quote blockquote{margin:0;padding:0;border:0;position:relative}
.rl-home .quote blockquote::before{content:"\201C";display:block;font-family:var(--f-display);font-size:56px;line-height:.8;color:var(--red-2);margin-bottom:6px}
.rl-home .quote blockquote p{margin:0;font-size:16px;line-height:1.65;color:var(--ink);max-width:62ch}
.rl-home .quote figcaption{margin-top:auto;display:flex;align-items:center;gap:16px;padding-top:20px;border-top:1px solid var(--line);min-width:0}.rl-home .quote figcaption>span{min-width:0;overflow-wrap:anywhere}
.rl-home .quote img{width:64px;height:64px;object-fit:cover;flex:none;display:block;border:1px solid var(--line-2)}
.rl-home .quote .nm{font-family:var(--f-display);text-transform:uppercase;font-size:20px;line-height:1.15;color:var(--ink);display:block}
.rl-home .quote .rl{font-family:var(--f-mono);font-size:12px;letter-spacing:.1em;text-transform:uppercase;color:var(--ink-faint);display:block;margin-top:6px}
/* packages teaser (D-154): text left, ladder of the three levels right; class "rung", not "step" (the kit styles .step) */
.rl-home .pk-split{display:grid;grid-template-columns:minmax(0,1.05fr) minmax(0,1fr);gap:clamp(32px,6vw,96px);align-items:center}@media(max-width:960px){.rl-home .pk-split{grid-template-columns:1fr}}
.rl-home .pk-split .head{margin-bottom:0}
.rl-home .ladder{list-style:none;margin:0;padding:0;position:relative;display:grid;gap:12px}
.rl-home .ladder::before{content:"";position:absolute;left:23px;top:28px;bottom:28px;width:1px;background:linear-gradient(180deg,var(--line-2),var(--red-2))}
.rl-home .ladder .rung{position:relative}
.rl-home .ladder .rung>a{display:grid;grid-template-columns:48px minmax(0,1fr);column-gap:16px;row-gap:4px;padding:18px 22px 18px 0;border:1px solid var(--glass-line);background:var(--panel);transition:border-color .2s,transform .2s}
.rl-home .ladder .rung.diag>a{border-style:dashed;background:transparent}
.rl-home .ladder .rung>a:hover{border-color:var(--red-line);transform:translateX(4px)}
.rl-home .ladder .rung.feat>a{border-color:var(--red-line);background:linear-gradient(90deg,rgba(153,0,0,.16),var(--panel) 70%);box-shadow:0 0 60px -30px var(--red-glow)}
.rl-home .ladder .dot{grid-row:1/span 3;justify-self:center;align-self:center;width:13px;height:13px;border:1px solid var(--red-2);background:var(--bg);position:relative;z-index:1}
.rl-home .ladder .feat .dot,.rl-home .ladder .rung:last-child .dot{background:var(--red)}
.rl-home .ladder .tl{font-family:var(--f-mono);font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--red-3)}
.rl-home .ladder .tl em{font-style:normal;color:var(--ink);border:1px solid var(--red-line);padding:1px 6px;margin-left:6px}
.rl-home .ladder .nm{font-family:var(--f-display);text-transform:uppercase;font-size:20px;line-height:1.15;color:var(--ink)}
.rl-home .ladder .pr{font-size:16px;color:var(--ink-dim)}.rl-home .ladder .pr b{color:var(--ink);font-weight:600}
@media(max-width:560px){.rl-home .ladder .rung>a{grid-template-columns:36px minmax(0,1fr);column-gap:10px;padding-right:14px}.rl-home .ladder::before{left:17px}}
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
.rl-home .faq p{padding:0 24px 22px;color:var(--ink-dim);font-size:16px;max-width:65ch}
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

/* Clients (D-156): production home's "Companies we've worked with", same 24 and same order (slugs from rl_clients_list() on /clients/) */
function rl_home_client_slugs() {
    return ['accesstel', 'bikroy-com', 'united-international-university', 'hp', 'nz-group', 'iba-alumni-association',
        'union-properties', 'accesstutor', 'ja-directives', 'paperleaf', 'faculty-of-business-studies-university-of-dhaka', 'panorama-property-management',
        'inpace', 'crizonix', 'tnt-global-sourcing', 'dipto-health', 'mrco-international', 'microinspire',
        'eco-fast-fashion', 'pro-tennis-academy-dhaka', 'mint-bangladesh', 'beacon-pharmaceuticals', 'we-connect', 'sofosvel'];
}

/* Recognition badges (D-152), the six from production's home page. Files are served from uploads/reinforce-badges/ (copies in claude/data/award-badges/), never hotlinked.
 * The two GoodFirms Bangladesh badges are cut from Jamil's screenshot: production's own copies return 404 (11 Oct 2026); replace with the originals from GoodFirms when Jamil has them. */
function rl_home_badges() {
    $gf = 'https://www.goodfirms.co/company/reinforce-lab-limited';
    return [
        ['file' => 'goodfirms-research-partner.svg', 'w' => 209, 'h' => 260, 'who' => 'GoodFirms', 'what' => 'Research partner', 'alt' => 'GoodFirms research partner badge', 'url' => 'https://www.goodfirms.co/resources/ai-adoption-statistics'],
        ['file' => 'goodfirms-top-seo-services-bangladesh.png', 'w' => 221, 'h' => 190, 'who' => 'GoodFirms', 'what' => 'Top SEO services company, Bangladesh', 'alt' => 'GoodFirms badge: Top SEO Services Company Bangladesh', 'url' => $gf],
        ['file' => 'goodfirms-top-digital-marketing.svg', 'w' => 140, 'h' => 146, 'who' => 'GoodFirms', 'what' => 'Top digital marketing company', 'alt' => 'GoodFirms badge: Top Digital Marketing Company', 'url' => 'https://www.goodfirms.co/directory/country/top-digital-marketing-companies/bangladesh'],
        ['file' => 'findbestfirms-wordpress-development-aug-2024.png', 'w' => 560, 'h' => 560, 'who' => 'FindBestFirms', 'what' => 'Top WordPress development, August 2024', 'alt' => 'FindBestFirms badge: Top WordPress Development, August 2024', 'url' => 'https://findbestfirms.com/company/reinforce-lab-limited/'],
        ['file' => 'goodfirms-top-branding-bangladesh.png', 'w' => 221, 'h' => 190, 'who' => 'GoodFirms', 'what' => 'Top branding company, Bangladesh', 'alt' => 'GoodFirms badge: Top Branding Company Bangladesh', 'url' => $gf],
        ['file' => 'designrush-top-content-marketing.png', 'w' => 432, 'h' => 474, 'who' => 'DesignRush', 'what' => 'Top content marketing agencies', 'alt' => 'DesignRush badge: Top Content Marketing Agencies', 'url' => 'https://www.designrush.com/agency/profile/reinforce-lab-ltd'],
    ];
}
function rl_home_upload($rel) { $up = wp_upload_dir(); return trailingslashit($up['baseurl']) . $rel; }
function rl_home_badge_src($file) { return rl_home_upload('reinforce-badges/' . $file); }

/* Testimonials (D-153): text copied word for word from production's home page (read 11 Oct 2026). One sentence left out of the second
 * quote (it uses a word on the copy-rules list, D-072); not marked, at Jamil's request (D-155). Photos: production's files, cropped square (copies in claude/data/testimonials/).
 * No Review or AggregateRating schema: Google does not show reviews a business publishes about itself. */
function rl_home_testimonials() {
    return [
        ['name' => 'Md. Arifin Hussain', 'role' => 'Head of Marketing, Bikroy', 'photo' => 'arifin-hussain-bikroy-240.jpg',
         'quote' => 'We hereby certify that Reinforce Lab Ltd. is working as our Content Partner since June 2022 till date. During the above tenure, its performance seems great and they have achieved all the assigned work that is provided to them. We wish them success in the coming future.'],
        ['name' => 'Mohammad Mozammal Haque', 'role' => 'Managing Director, Mrco International', 'photo' => 'mozammal-haque-mrco-240.jpg',
         'quote' => 'We are extremely pleased with the exceptional WordPress Web Design & Development service provided by Reinforce Lab. Their team\'s professionalism and expertise exceeded our expectations. The tailored solution they offered perfectly captured our brand identity. We\'re thrilled with the results and look forward to future collaborations. Happy to stay with Reinforce Lab.'],
    ];
}

/* scroll motion on the home page only (D-163) */
add_filter('rl_motion_active', function ($on) { return $on || is_front_page(); });

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
          <a class="btn p" href="<?php echo esc_url($diag); ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
          <a class="btn g" href="<?php echo esc_url($svcs); ?>">Explore Services</a>
        </div>
        <p class="microtrust">Built for <b>Pharmaceutical &amp; Life Sciences · Healthcare · B2B SaaS · E-commerce · Manufacturing · Technology · Professional Services · Education</b></p>
      </div>
      <figure class="ge rl-anim"><div class="cap" aria-hidden="true"><span>Inputs</span><span>Engine</span><span>Outcomes</span></div><?php echo rl_home_ge_svg(); ?><?php if (function_exists('rl_ph')) echo rl_ph([['label' => 'Inputs', 'kind' => 'chips', 'items' => ['Search & SERP data', 'Content & website', 'Competitor research', 'Customer & social signals', 'AI-search visibility']], ['label' => 'Engine', 'kind' => 'core', 'title' => 'AI Growth System', 'sub' => 'Verify · build · automate · monitor'], ['label' => 'Outcomes', 'kind' => 'rows', 'items' => ['Automated operations', 'Content that ranks', 'Cited in AI search', 'Qualified pipeline', ['Increased revenue', 'hi']]]], 'Outcomes feed the next cycle'); ?></figure>
    </div>
  </section>

  <!-- OUTCOMES (3D signal field behind, D-165: decorative canvas, CSS dotted field as the still version) -->
  <section class="band alt sig-sec">
    <div class="sig-bg" aria-hidden="true"></div>
    <canvas class="sig-cv" aria-hidden="true"></canvas>
    <div class="wrap">
      <div class="head"><span class="ey"><b>[</b>&nbsp;Why AI Growth Systems&nbsp;<b>]</b></span><h2>One system. Three outcomes that move the business.</h2></div>
      <div class="oc">
        <div class="oc-i"><div class="k">01</div><h3>Automate <span>Operations</span></h3><p>Replace manual, disconnected marketing and research work with AI workflows that run continuously and scale without more headcount.</p></div>
        <div class="oc-i"><div class="k">02</div><h3>Improve <span>Search Visibility</span></h3><p>Win on Google <em>and</em> AI search: SEO, GEO and AEO working together so you're found and cited where buyers now look.</p></div>
        <div class="oc-i"><div class="k">03</div><h3>Increase <span>Revenue</span></h3><p>Turn visibility into qualified pipeline with content and systems engineered to convert intent, measured by business impact, not vanity metrics.</p></div>
      </div>
    </div>
  </section>

  <!-- WHAT WE DO -->
  <section>
    <div class="wrap">
      <div class="head"><span class="ey"><b>[</b>&nbsp;What We Do&nbsp;<b>]</b></span><h2>The capabilities behind the engine.</h2><p class="lede">Adopt the full system, or start with the piece where the pain is sharpest. Each links to a deeper page.</p></div>
      <ol class="ix">
        <li><a href="<?php echo esc_url($u('services/ai-search-optimization')); ?>"><span class="no" aria-hidden="true">01</span><div><span class="tg">SEARCH</span><h3>AI Search Optimization &amp; SEO</h3></div><p>Enterprise, technical, international and local SEO plus AI Search Optimization, engineered as one strategy.</p><span class="go" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="square" focusable="false"><path d="M3 8h9M8.5 4l4 4-4 4"/></svg></span></a></li>
        <li><a href="<?php echo esc_url($u('services/generative-engine-optimization')); ?>"><span class="no" aria-hidden="true">02</span><div><span class="tg">AI SEARCH</span><h3>GEO &amp; LLM Optimization</h3></div><p>Be the source AI engines cite: Generative Engine Optimization and LLM optimization for ChatGPT, Perplexity, AI Overviews.</p><span class="go" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="square" focusable="false"><path d="M3 8h9M8.5 4l4 4-4 4"/></svg></span></a></li>
        <li><a href="<?php echo esc_url($u('services/seo-content-systems')); ?>"><span class="no" aria-hidden="true">03</span><div><span class="tg">CONTENT</span><h3>SEO Content Systems</h3></div><p>Research-led, evidence-verified content produced and QA'd as a system, not a one-off quota.</p><span class="go" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="square" focusable="false"><path d="M3 8h9M8.5 4l4 4-4 4"/></svg></span></a></li>
        <li><a href="<?php echo esc_url($u('services/ai-workflow-automation')); ?>"><span class="no" aria-hidden="true">04</span><div><span class="tg">AUTOMATE</span><h3>AI Workflow &amp; Marketing Automation</h3></div><p>Automate repetitive operations and marketing processes with reliable, monitored AI workflows.</p><span class="go" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="square" focusable="false"><path d="M3 8h9M8.5 4l4 4-4 4"/></svg></span></a></li>
        <li><a href="<?php echo esc_url($u('services/lead-generation-systems')); ?>"><span class="no" aria-hidden="true">05</span><div><span class="tg">GROWTH</span><h3>Lead Generation Systems</h3></div><p>Scalable systems that turn organic visibility into qualified, trackable pipeline.</p><span class="go" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="square" focusable="false"><path d="M3 8h9M8.5 4l4 4-4 4"/></svg></span></a></li>
        <li><a href="<?php echo esc_url($u('services/executive-ai-consulting')); ?>"><span class="no" aria-hidden="true">06</span><div><span class="tg">ADVISORY</span><h3>Executive AI Consulting</h3></div><p>Architect the system, define what matters, and run the plays, with human judgment in the loop.</p><span class="go" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="square" focusable="false"><path d="M3 8h9M8.5 4l4 4-4 4"/></svg></span></a></li>
      </ol>
      <div class="cta-row"><a class="btn g" href="<?php echo esc_url($svcs); ?>">See all services <span class="ar">&rarr;</span></a></div>
    </div>
  </section>

  <!-- PROBLEM -->
  <section class="band alt">
    <div class="wrap pr-split">
      <div class="head"><span class="ey"><b>[</b>&nbsp;The Problem&nbsp;<b>]</b></span><h2>Why does growth stall when marketing, search and operations run apart?</h2><p class="lede">Your website, content, search visibility, CRM and team workflows each live in their own tool. Every hand-off is manual, every report is stitched together by hand, and nobody can see which effort actually produces revenue.</p></div>
      <div>
      <div class="pains">
        <div class="pain"><span class="x" aria-hidden="true"><svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" focusable="false"><path d="M4 4l8 8M12 4l-8 8"/></svg></span><p><b>Manual work eats the week.</b> Reporting, briefs, follow-ups and publishing still run on copy-paste. That is time your team should spend on decisions.</p></div>
        <div class="pain"><span class="x" aria-hidden="true"><svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" focusable="false"><path d="M4 4l8 8M12 4l-8 8"/></svg></span><p><b>Search visibility is fragmenting.</b> Buyers now research in Google, ChatGPT, Perplexity and AI Overviews. Most growth plans still measure only one of them.</p></div>
        <div class="pain"><span class="x" aria-hidden="true"><svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" focusable="false"><path d="M4 4l8 8M12 4l-8 8"/></svg></span><p><b>Leads leak between systems.</b> Traffic arrives and forms get filled, then nothing connects the visit to the pipeline or the next action.</p></div>
        <div class="pain"><span class="x" aria-hidden="true"><svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" focusable="false"><path d="M4 4l8 8M12 4l-8 8"/></svg></span><p><b>Reports describe activity, not revenue.</b> Rankings and traffic charts say little about what is actually growing the business.</p></div>
      </div>
      <p class="src">Sources: <a href="https://developers.google.com/search/docs/appearance/ai-features" rel="noopener" target="_blank">Google Search Central: AI features and your website</a> · <a href="https://platform.openai.com/docs/bots" rel="noopener" target="_blank">OpenAI: crawlers and user agents</a> · <a href="https://docs.perplexity.ai/guides/bots" rel="noopener" target="_blank">Perplexity: crawlers</a></p>
      </div>
    </div>
  </section>

  <!-- SYSTEM / HOW -->
  <section>
    <div class="wrap">
      <div class="head"><span class="ey"><b>[</b>&nbsp;How it works&nbsp;<b>]</b></span><h2>How is an AI Growth System built?</h2><p class="lede">Every system connects four layers: your data, AI models, automated workflows and a revenue dashboard. We build it in four stages, run as one loop, whether we start with search, content, automation or lead generation. <a class="inl" href="<?php echo esc_url($u('services/ai-growth-systems')); ?>">See the systems we build</a>.</p></div>
      <ol class="tline">
        <li><span class="nd" aria-hidden="true"></span><div class="k" aria-hidden="true">01</div><h3>Diagnose</h3><p>Map your website, search visibility, content, workflows and funnel. Find where time, traffic and revenue are being lost.</p></li>
        <li><span class="nd" aria-hidden="true"></span><div class="k" aria-hidden="true">02</div><h3>Architect</h3><p>Design the system: which workflows to automate, which searches to own, and which data feeds which decision.</p></li>
        <li><span class="nd" aria-hidden="true"></span><div class="k" aria-hidden="true">03</div><h3>Build &amp; Automate</h3><p>Implement the workflows, pages, content engines and integrations, with human approval where it matters.</p></li>
        <li><span class="nd" aria-hidden="true"></span><div class="k" aria-hidden="true">04</div><h3>Measure &amp; Improve</h3><p>Track business outcomes: hours saved, qualified pipeline, visibility in Google and AI search, and tune the system every cycle.</p></li>
      </ol>
    </div>
  </section>

  <!-- INDUSTRIES -->
  <section class="band alt icp">
    <div class="wrap">
      <div class="head"><span class="ey"><b>[</b>&nbsp;Industries&nbsp;<b>]</b></span><h2>Built around how your industry buys.</h2><p class="lede">The same system, configured for your market's buyers, regulations and sales cycle.</p></div>
      <ul class="ind">
        <li><a href="<?php echo esc_url($u('industries/pharmaceutical')); ?>"><span class="ic" aria-hidden="true"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="miter" focusable="false"><path d="M9 3h6M10 3v6l-5 10.5V21h14v-1.5L14 9V3M7.5 15h9"/></svg></span><div class="t"><h3>Pharmaceutical &amp; Life Sciences</h3><span class="who">Regulated</span></div><p>Compliant content and automated workflows for long, evidence-driven buying cycles.</p><span class="ar2" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="square" focusable="false"><path d="M3 8h9M8.5 4l4 4-4 4"/></svg></span></a></li>
        <li><a href="<?php echo esc_url($u('industries/healthcare')); ?>"><span class="ic" aria-hidden="true"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="miter" focusable="false"><path d="M9 4h6v5h5v6h-5v5H9v-5H4V9h5z"/></svg></span><div class="t"><h3>Healthcare</h3><span class="who">Trust</span></div><p>Visibility for patient- and provider-facing search, with review workflows built in.</p><span class="ar2" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="square" focusable="false"><path d="M3 8h9M8.5 4l4 4-4 4"/></svg></span></a></li>
        <li><a href="<?php echo esc_url($u('industries/b2b-saas')); ?>"><span class="ic" aria-hidden="true"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="miter" focusable="false"><path d="M12 3l9 5-9 5-9-5 9-5zM3 12.5l9 5 9-5M3 17l9 5 9-5"/></svg></span><div class="t"><h3>B2B SaaS</h3><span class="who">Pipeline</span></div><p>Search, content and lead routing connected to trial, demo and revenue data.</p><span class="ar2" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="square" focusable="false"><path d="M3 8h9M8.5 4l4 4-4 4"/></svg></span></a></li>
        <li><a href="<?php echo esc_url($u('industries/ecommerce')); ?>"><span class="ic" aria-hidden="true"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="miter" focusable="false"><path d="M4 8h16l-1.5 12h-13L4 8zM9 8V4h6v4"/></svg></span><div class="t"><h3>E-commerce</h3><span class="who">Conversion</span></div><p>Catalog content and search visibility measured against orders, not traffic.</p><span class="ar2" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="square" focusable="false"><path d="M3 8h9M8.5 4l4 4-4 4"/></svg></span></a></li>
        <li><a href="<?php echo esc_url($u('industries/manufacturing')); ?>"><span class="ic" aria-hidden="true"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="miter" focusable="false"><path d="M3 21V11l6 3.5V11l6 3.5V5h6v16H3zM7 17h2M12 17h2"/></svg></span><div class="t"><h3>Manufacturing</h3><span class="who">Technical</span></div><p>Make technical capability findable and route RFQs to the right team faster.</p><span class="ar2" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="square" focusable="false"><path d="M3 8h9M8.5 4l4 4-4 4"/></svg></span></a></li>
        <li><a href="<?php echo esc_url($u('industries/technology')); ?>"><span class="ic" aria-hidden="true"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="miter" focusable="false"><path d="M7 7h10v10H7zM10 3v4M14 3v4M10 17v4M14 17v4M3 10h4M3 14h4M17 10h4M17 14h4"/></svg></span><div class="t"><h3>Technology</h3><span class="who">Complex sale</span></div><p>Content and lead systems for multi-stakeholder buying committees.</p><span class="ar2" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="square" focusable="false"><path d="M3 8h9M8.5 4l4 4-4 4"/></svg></span></a></li>
        <li><a href="<?php echo esc_url($u('industries/professional-services')); ?>"><span class="ic" aria-hidden="true"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="miter" focusable="false"><path d="M3 8h18v12H3zM9 8V4h6v4M3 13h18"/></svg></span><div class="t"><h3>Professional Services</h3><span class="who">Referral</span></div><p>Authority and lead capture for firms, including finance, legal and consulting.</p><span class="ar2" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="square" focusable="false"><path d="M3 8h9M8.5 4l4 4-4 4"/></svg></span></a></li>
        <li><a href="<?php echo esc_url($u('industries/education')); ?>"><span class="ic" aria-hidden="true"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="miter" focusable="false"><path d="M2 9l10-5 10 5-10 5L2 9zM6 11v5.5l6 3 6-3V11M22 9v6"/></svg></span><div class="t"><h3>Education</h3><span class="who">Enrollment</span></div><p>Program visibility and enquiry automation across the full enrollment cycle.</p><span class="ar2" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="square" focusable="false"><path d="M3 8h9M8.5 4l4 4-4 4"/></svg></span></a></li>
      </ul>
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
          <div class="core" style="margin-top:6px"><b>Search Authority OS</b></div>
          <ol class="os-steps">
            <li><span class="os-n" aria-hidden="true">01</span><b>Research</b><span>Your market, buyers and competitors</span></li>
            <li><span class="os-n" aria-hidden="true">02</span><b>Verify</b><span>Every claim against real evidence</span></li>
            <li><span class="os-n" aria-hidden="true">03</span><b>Write</b><span>High-value content people search for</span></li>
            <li><span class="os-n" aria-hidden="true">04</span><b>Audit</b><span>Quality checks before anything goes live</span></li>
            <li><span class="os-n" aria-hidden="true">05</span><b>Monitor</b><span>Visibility in Google and AI search</span></li>
          </ol>
          <span class="os-bar" aria-hidden="true"><i></i></span>
          <p class="microtrust" style="margin-top:14px">We architect the system, define what matters, and run the search plays for you.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- PROOF removed until there are real results (D-162) -->

  <!-- CLIENTS (D-156) -->
  <?php $white = (array) get_option('rl_client_logos_white', []); $names = function_exists('rl_clients_list') ? array_flip(rl_clients_list()) : []; ?>
  <section id="clients">
    <div class="wrap">
      <div class="head"><span class="ey"><b>[</b>&nbsp;Clients&nbsp;<b>]</b></span><h2>Companies we've worked with.</h2><p class="lede">Universities, pharmaceutical companies, online marketplaces, property firms and growing brands.</p></div>
      <?php $rows = array_chunk(array_values(array_filter(rl_home_client_slugs(), function ($sl) use ($white) { return !empty($white[$sl]); })), 12); ?>
      <div class="cl-rows">
        <?php foreach ($rows as $ri => $row) { $set = function ($hidden) use ($row, $white, $names) { ?>
          <ul class="cl-set"<?php echo $hidden ? ' aria-hidden="true"' : ''; ?>>
            <?php foreach ($row as $slug) { $nm = isset($names[$slug]) ? $names[$slug] : $slug; ?>
            <li title="<?php echo esc_attr($nm); ?>"><?php echo wp_get_attachment_image($white[$slug], 'full', false, ['alt' => $hidden ? '' : $nm . ' logo', 'loading' => 'lazy', 'decoding' => 'async']); ?></li>
            <?php } ?>
          </ul>
        <?php }; ?>
        <div class="cl-row r<?php echo $ri + 1; ?>"><div class="cl-track"><?php $set(false); $set(true); ?></div></div>
        <?php } ?>
      </div>
      <p class="cl-more"><a class="more" href="<?php echo esc_url($u('clients')); ?>">See all <?php echo $names ? count($names) : 46; ?> clients &rarr;</a></p>
      <!-- RECOGNITION (D-152, merged into Clients D-160): each badge links to the page on the directory's own site -->
      <div class="rec-sub" id="recognition"><span class="ey"><b>[</b>&nbsp;Recognition&nbsp;<b>]</b></span><h3>Awards and recognition.</h3><p>A startup award decided by public vote, and rankings by GoodFirms, FindBestFirms and DesignRush. Each one links to the page on its own site. <a class="inl" href="<?php echo esc_url($u('awards')); ?>">See all awards</a>.</p></div>
      <?php if (function_exists('rl_awards_data')) { $ad = rl_awards_data(); $ft = $ad['feature']; $hnx = array_values(array_filter($ad['awards'], function ($a) { return $a[0] === 'HackerNoon'; })); /* D-161 */ ?>
      <div class="hn">
        <span class="cup" aria-hidden="true"><svg width="48" height="48" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="square" stroke-linejoin="miter" focusable="false"><path d="M15 7h18v11c0 5-4 9-9 9s-9-4-9-9V7z"/><path d="M15 11H8v3c0 4 3 7 7 7M33 11h7v3c0 4-3 7-7 7"/><path d="M24 27v7M17 41h14M19 34h10v7H19z"/><path d="M21 14l3-3 3 3"/></svg></span>
        <div><span class="by"><?php echo esc_html($ft['by']); ?></span><h4><?php echo esc_html($ft['title']); ?></h4><p><?php echo esc_html($ft['text']); ?></p><a class="src-l" href="<?php echo esc_url($ft['url']); ?>" target="_blank" rel="noopener"><?php echo esc_html($ft['link']); ?> &rarr;</a></div>
        <ul>
          <?php foreach ($hnx as $a) { ?><li><a href="<?php echo esc_url($a[4]); ?>" target="_blank" rel="noopener"><?php echo esc_html($a[2]); ?><small><?php echo esc_html($a[0] . ', ' . $a[1]); ?></small></a></li><?php } ?>
        </ul>
      </div>
      <?php } ?>
      <ul class="recs">
        <?php foreach (rl_home_badges() as $b) { ?>
        <li><a class="rec" href="<?php echo esc_url($b['url']); ?>" target="_blank" rel="noopener"><span class="tile"><img src="<?php echo esc_url(rl_home_badge_src($b['file'])); ?>" alt="<?php echo esc_attr($b['alt']); ?>" width="<?php echo (int) $b['w']; ?>" height="<?php echo (int) $b['h']; ?>" loading="lazy" decoding="async"></span><span class="cap"><span class="who"><?php echo esc_html($b['who']); ?></span><span class="what"><?php echo esc_html($b['what']); ?></span></span></a></li>
        <?php } ?>
      </ul>
    </div>
  </section>

  <!-- TESTIMONIALS (D-153): words as the clients wrote them on production's home page; one sentence left out of the second (D-155) -->
  <section class="band alt" id="testimonials">
    <div class="wrap">
      <div class="head"><span class="ey"><b>[</b>&nbsp;Testimonials&nbsp;<b>]</b></span><h2>What clients say.</h2><p class="lede">In their own words.</p></div>
      <div class="quotes">
        <?php foreach (rl_home_testimonials() as $t) { ?>
        <figure class="quote">
          <blockquote><p><?php echo esc_html($t['quote']); ?></p></blockquote>
          <figcaption><img src="<?php echo esc_url(rl_home_upload('reinforce-testimonials/' . $t['photo'])); ?>" alt="<?php echo esc_attr($t['name']); ?>" width="64" height="64" loading="lazy" decoding="async"><span><span class="nm"><?php echo esc_html($t['name']); ?></span><span class="rl"><?php echo esc_html($t['role']); ?></span></span></figcaption>
        </figure>
        <?php } ?>
      </div>
    </div>
  </section>

  <!-- PACKAGES (teaser: detail lives on /packages/ and /search-authority-os/) -->
  <section>
    <div class="wrap pk-split">
      <div class="head"><span class="ey"><b>[</b>&nbsp;Packages&nbsp;<b>]</b></span><h2>Start with a diagnostic. Scale when it's working.</h2><p class="lede">Three engagement levels: <b style="color:var(--ink)">Foundation</b>, <b style="color:var(--ink)">Growth OS</b> and <b style="color:var(--ink)">Enterprise</b>, from a focused starting system to full enterprise governance. Every engagement begins with a diagnostic, and pricing is set to scope. Engagements start from $5,000 setup.</p>
        <div class="cta-row"><a class="btn p" href="<?php echo esc_url($pkg); ?>">Compare packages <span class="ar">&rarr;</span></a><a class="btn g" href="<?php echo esc_url($diag); ?>">Get your free diagnostic</a></div>
      </div>
      <?php if (function_exists('rl_pkg_plans')) { /* D-154: the three levels as a ladder, from the single source on /packages/ */ ?>
      <ol class="ladder">
        <li class="rung diag"><a href="<?php echo esc_url($diag); ?>"><span class="dot" aria-hidden="true"></span><span class="tl">Step 0 · Free</span><span class="nm">Search Authority Diagnostic</span><span class="pr">Your baseline, gaps and first fixes</span></a></li>
        <?php foreach (rl_pkg_plans() as $p) { $t = explode(' · ', $p['tier']); ?>
        <li class="rung<?php echo $p['feat'] ? ' feat' : ''; ?>"><a href="<?php echo esc_url($pkg); ?>"><span class="dot" aria-hidden="true"></span><span class="tl"><?php echo esc_html($t[0] . ' · ' . $t[1]); ?><?php if (!empty($t[2])) { ?> <em><?php echo esc_html($t[2]); ?></em><?php } ?></span><span class="nm"><?php echo esc_html($p['name']); ?></span><span class="pr"><b><?php echo esc_html($p['price']); ?></b> <?php echo esc_html($p['monthly']); ?></span></a></li>
        <?php } ?>
      </ol>
      <?php } ?>
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
      <div class="head bl-top"><span class="ey"><b>[</b>&nbsp;Insights&nbsp;<b>]</b></span><h2>From the blog.</h2><p class="lede">Field notes on AI Search, GEO, evidence-based content, and building growth systems that keep improving.</p></div>
      <div class="bl-posts">
        <?php
        $bq = new WP_Query(array('post_type'=>'post','posts_per_page'=>3,'post_status'=>'publish','ignore_sticky_posts'=>true));
        if ($bq->have_posts()) {
          while ($bq->have_posts()) { $bq->the_post();
            $thumb = get_the_post_thumbnail_url(get_the_ID(), 'large');
            $tl = function_exists('rl_post_data') ? rl_post_data(get_the_ID())['type_label'] : '';
            $mc = function_exists('rl_post_main_cat') ? rl_post_main_cat(get_the_ID()) : null;
            $mcn = ($mc && (int) $mc->term_id !== (int) get_option('default_category')) ? $mc->name : ''; ?>
          <a class="cell pcard" href="<?php the_permalink(); ?>">
            <?php if ($thumb) { ?><div class="pthumb" style="background-image:url(<?php echo esc_url($thumb); ?>)"></div>
            <?php } else { ?><div class="pthumb ph" aria-hidden="true"><span><?php echo esc_html($tl ?: 'Article'); ?></span><b><?php echo esc_html($mcn ?: 'Reinforce Lab'); ?></b></div><?php } ?>
            <div class="pbody">
              <p class="pmeta"><?php if ($tl) echo '<span class="t">' . esc_html($tl) . '</span> · '; ?><?php echo esc_html(get_the_date('j M Y')); ?><?php if ($mcn) echo ' · <span class="c">' . esc_html($mcn) . '</span>'; ?></p>
              <h3><?php echo esc_html(get_the_title()); ?></h3>
              <p><?php echo esc_html(wp_trim_words(wp_strip_all_tags(get_the_excerpt()),22)); ?></p>
              <span class="more">Read article &rarr;</span>
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
            <div class="pthumb ph-wash"><span class="ptag"><?php echo $p[0]; ?></span></div>
            <div class="pbody">
              <div class="pmeta"><?php echo $p[0]; ?> &middot; Coming soon</div>
              <h3><?php echo $p[1]; ?></h3>
              <p><?php echo $p[2]; ?></p>
            </div>
          </div>
          <?php }
        } ?>
      </div>
      <div class="cta-row bl-cta"><a class="btn g" href="<?php echo esc_url(rl_url_by_path('blog')); ?>">Read the blog <span class="ar">&rarr;</span></a></div>
    </div>
  </section>

  <!-- FINAL CTA -->
  <section>
    <div class="wrap">
      <div class="final">
        <canvas class="scan-cv" aria-hidden="true"></canvas>
        <span class="ey"><b>[</b>&nbsp;Start here&nbsp;<b>]</b></span>
        <h2>Find out what's limiting your growth.</h2>
        <p class="lede center">A data-backed diagnostic of your Google visibility, AI-search presence, content authority, competitors and demand, with a clear 90-day plan. No generic scorecard.</p>
        <div class="cta-row">
          <a class="btn p" href="<?php echo esc_url($diag); ?>">Get your free diagnostic <span class="ar">&rarr;</span></a>
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
