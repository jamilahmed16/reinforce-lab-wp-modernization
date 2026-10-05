<?php
/**
 * Plugin Name: Reinforce Lab - Agent hero visuals (8)
 * Description: One hero visual per Search Authority OS agent (D-115), each showing that agent's own job, replacing the shared inputs / agent / review / outputs diagram. Used by saos/reinforce-agent-pages.php through rl_agv_svg(). Same panel, viewBox (520 x 392) and 10 s loop for all 8; reduced motion shows the complete drawing with every highlight on; the animation reveals the highlights step by step. Illustrative only: no numbers, no client data.
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

/* ---------- drawing helpers (viewBox units) ---------- */
function rl_agv_cls($cls, $s) { return $cls . ($s === null ? '' : ' v-k v-s' . $s); }
function rl_agv_r($x, $y, $w, $h, $cls = 'v-b', $s = null) { return '<rect class="' . rl_agv_cls($cls, $s) . '" x="' . $x . '" y="' . $y . '" width="' . $w . '" height="' . $h . '"/>'; }
function rl_agv_t($x, $y, $t, $cls = 'v-t', $a = 'start', $s = null) { return '<text class="' . rl_agv_cls($cls, $s) . '" x="' . $x . '" y="' . $y . '"' . ($a !== 'start' ? ' text-anchor="' . $a . '"' : '') . '>' . esc_html($t) . '</text>'; }
function rl_agv_l($x1, $y1, $x2, $y2, $cls = 'v-l', $s = null) { return '<line class="' . rl_agv_cls($cls, $s) . '" x1="' . $x1 . '" y1="' . $y1 . '" x2="' . $x2 . '" y2="' . $y2 . '"/>'; }
function rl_agv_c($cx, $cy, $r, $cls = 'v-dot', $s = null) { return '<circle class="' . rl_agv_cls($cls, $s) . '" cx="' . $cx . '" cy="' . $cy . '" r="' . $r . '"/>'; }
/* a path that draws itself on step $s (drawn in the static view) */
function rl_agv_dw($d, $s, $cls = 'v-lr') { return '<path class="' . $cls . ' v-dw v-d' . $s . '" pathLength="100" d="' . $d . '"/>'; }
function rl_agv_tick($x, $y, $s = null) { return '<path class="' . rl_agv_cls('v-tick', $s) . '" d="M' . $x . ' ' . ($y + 4) . ' l3 3 l6 -7"/>'; }
function rl_agv_foot($left, $id) {
    return rl_agv_l(0, 350, 520, 350, 'v-l2') . rl_agv_t(0, 372, $left, 'v-lab') . rl_agv_t(520, 372, $id . ' · REVIEWED BY A PERSON', 'v-lab', 'end');
}

/* ---------- per agent: caption (right side of the panel cap), description, drawing ---------- */
function rl_agv_meta() {
    return [
        'seo-intelligence' => ['Value vs difficulty', 'Keywords plotted by business value and difficulty; the high-value, lower-difficulty corner is marked as quick wins and becomes a ranked page plan.'],
        'content-research' => ['Topic coverage', 'A grid of what the top-ranking pages cover; subtopics none of them answer well are marked as gaps and become a research brief with sources.'],
        'evidence-verification' => ['Claim ledger', 'Claims in a draft are matched to sources and given a confidence level; a claim with no source is flagged for human review.'],
        'aeo-geo-optimization' => ['Answer readiness', 'Sections of a page are made answer-ready and tracked across ChatGPT, Perplexity, Gemini and Google AI Overviews: mentioned, cited and described accurately.'],
        'social-sentiment' => ['Customer voice', 'Comments from forums, reviews and social posts are grouped into objections, confusions and questions, then turned into FAQ topics and new angles.'],
        'competitor-intelligence' => ['Coverage radar', 'A radar compares topic coverage of rivals and your site; the gaps are marked, and rival changes arrive as alerts with target pages.'],
        'content-qa' => ['Quality gate', 'A draft passes SEO, AEO and GEO, and evidence checks; a failed check goes to a fix list, and the page is approved with an audit trail.'],
        'search-performance' => ['Detect · diagnose · fix', 'A drop in search clicks is detected, five likely causes are checked, the root cause is found, and a recovery plan follows.'],
    ];
}

function rl_agv_svg($slug, $a) {
    $m = rl_agv_meta();
    if (!isset($m[$slug])) return '';
    $fn = 'rl_agv_' . str_replace('-', '_', $slug);
    $id = 'rlAgv' . substr(md5($slug), 0, 6);
    $title = esc_html($a['name'] . ' Agent: ' . $m[$slug][1]);
    /* desktop drawing, plus a simpler phone drawing with fewer, larger labels (shown at 560 px and below) */
    return '<svg class="agv-d" viewBox="0 0 520 392" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="' . $id . '"><title id="' . $id . '">' . $title . '</title>' . $fn() . '</svg>'
        . '<svg class="agv-m" viewBox="0 0 320 392" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="' . $id . 'm"><title id="' . $id . 'm">' . $title . '</title>' . call_user_func($fn . '_m') . '</svg>';
}
function rl_agv_cap($slug) { $m = rl_agv_meta(); return isset($m[$slug]) ? $m[$slug][0] : ''; }

/* A-01 SEO Intelligence: opportunity map -> page plan */
function rl_agv_seo_intelligence() {
    $s = rl_agv_t(0, 14, 'BUSINESS VALUE', 'v-lab') . rl_agv_l(30, 22, 30, 300, 'v-l2') . rl_agv_l(30, 300, 292, 300, 'v-l2') . rl_agv_t(292, 316, 'DIFFICULTY', 'v-lab', 'end');
    $s .= rl_agv_l(161, 22, 161, 300, 'v-dash') . rl_agv_l(30, 161, 292, 161, 'v-dash');
    $s .= rl_agv_r(31, 23, 129, 137, 'v-bh', 1) . rl_agv_t(38, 36, 'QUICK WINS', 'v-tr') . rl_agv_t(285, 36, 'WORTH BUILDING', 'v-lab', 'end') . rl_agv_t(38, 292, 'LOW VALUE', 'v-lab') . rl_agv_t(285, 292, 'LONG SHOTS', 'v-lab', 'end');
    foreach ([[70, 70], [112, 52], [96, 118], [140, 92], [200, 60], [246, 98], [226, 140], [62, 214], [104, 250], [150, 196], [214, 232], [258, 200], [270, 268], [190, 276]] as $p) $s .= rl_agv_c($p[0], $p[1], 3.2);
    foreach ([[70, 70], [112, 52], [140, 92], [96, 118]] as $i => $p) $s .= rl_agv_c($p[0], $p[1], 7, 'v-ring', 2 + $i) . rl_agv_c($p[0], $p[1], 3.4, 'v-dotr', 2 + $i);
    $s .= rl_agv_t(320, 14, 'PAGE PLAN', 'v-lab');
    $rows = [['P1', 'QUICK WIN', 'EXISTING PAGE'], ['P2', 'NEW PAGE', 'HIGH INTENT'], ['P3', 'REFRESH', 'NEAR PAGE ONE'], ['P4', 'MERGE', 'PAGES COMPETE'], ['P5', 'LATER', 'LOW VALUE']];
    foreach ($rows as $i => $r) {
        $y = 24 + $i * 56;
        $s .= rl_agv_r(320, $y, 200, 44) . ($i < 4 ? rl_agv_r(320, $y, 200, 44, 'v-bh', 7 + $i) : '') . rl_agv_t(332, $y + 19, $r[0], $i < 4 ? 'v-tr' : 'v-lab') . rl_agv_t(356, $y + 19, $r[1], 'v-tb') . rl_agv_t(356, $y + 33, $r[2], 'v-t');
    }
    $s .= rl_agv_dw('M74 70 C200 40 250 46 320 46', 6) . rl_agv_dw('M116 52 C220 80 260 100 320 102', 7) . rl_agv_dw('M144 92 C230 130 270 150 320 158', 8) . rl_agv_dw('M100 118 C220 190 260 210 320 214', 9);
    return $s . rl_agv_foot('INTENT · VALUE · DIFFICULTY · POSITION', 'A-01');
}

/* A-02 Content Research: coverage grid -> gaps -> brief */
function rl_agv_content_research() {
    $s = rl_agv_t(0, 14, 'WHAT THE TOP PAGES COVER', 'v-lab');
    $topics = ['DEFINITION', 'HOW IT WORKS', 'COST', 'COMPARISON', 'RISKS', 'REAL QUESTIONS'];
    $cov = [[1, 1, 1, 1], [1, 1, 0, 1], [0, 0, 0, 0], [1, 0, 1, 0], [0, 0, 0, 0], [0, 1, 0, 0]];
    foreach (['R1', 'R2', 'R3', 'R4'] as $j => $c) $s .= rl_agv_t(128 + $j * 34, 36, $c, 'v-lab', 'middle');
    $s .= rl_agv_t(264, 36, 'GAP', 'v-tr', 'middle');
    foreach ($topics as $i => $t) {
        $y = 48 + $i * 44;
        $gap = array_sum($cov[$i]) === 0;
        $s .= rl_agv_r(0, $y, 282, 34, 'v-b') . ($gap ? rl_agv_r(0, $y, 282, 34, 'v-bh', 4 + ($i === 4 ? 1 : 0)) : '') . rl_agv_t(10, $y + 21, $t, $gap ? 'v-tb' : 'v-t');
        foreach ($cov[$i] as $j => $v) $s .= rl_agv_r(120 + $j * 34, $y + 9, 16, 16, $v ? 'v-cell' : 'v-cell0', $v ? $i % 3 : null);
        if ($gap) $s .= rl_agv_r(256, $y + 9, 16, 16, 'v-cellr');
    }
    $s .= rl_agv_t(330, 14, 'RESEARCH BRIEF', 'v-lab') . rl_agv_r(330, 24, 190, 302, 'v-b') . rl_agv_t(344, 46, 'H1 · TOPIC', 'v-tb');
    $lines = [[64, 150, null], [76, 120, null], [104, 0, null], [124, 140, 8], [136, 110, 8], [164, 0, null], [184, 150, 9], [196, 96, 9], [224, 0, null]];
    $s .= rl_agv_t(344, 98, 'H2 · COST', 'v-tr', 'start', 6) . rl_agv_t(344, 158, 'H2 · RISKS', 'v-tr', 'start', 7) . rl_agv_t(344, 218, 'SOURCES', 'v-lab');
    foreach ($lines as $l) if ($l[1]) $s .= rl_agv_r(344, $l[0], $l[1], 4, 'v-line', $l[2]);
    foreach ([0, 1, 2] as $i) $s .= rl_agv_r(344 + $i * 42, 230, 34, 18, 'v-b') . rl_agv_t(361 + $i * 42, 243, '[' . ($i + 1) . ']', 'v-t', 'middle') . rl_agv_r(344 + $i * 42, 230, 34, 18, 'v-bh', 10 + $i);
    $s .= rl_agv_t(344, 276, 'OUTLINE · ANGLES', 'v-lab') . rl_agv_r(344, 286, 120, 4, 'v-line') . rl_agv_r(344, 298, 90, 4, 'v-line');
    $s .= rl_agv_dw('M282 153 C306 153 306 94 330 94', 5) . rl_agv_dw('M282 241 C306 241 306 154 330 154', 6);
    return $s . rl_agv_foot('SEARCH RESULTS · QUESTIONS · RIVAL PAGES', 'A-02');
}

/* A-03 Evidence Verification: draft claims -> ledger */
function rl_agv_evidence_verification() {
    $s = rl_agv_t(0, 14, 'DRAFT', 'v-lab') . rl_agv_r(0, 24, 210, 302);
    $s .= rl_agv_r(14, 40, 120, 6, 'v-line2');
    $para = [[64, 0, 182], [78, 0, 150], [100, 0, 176], [114, 0, 120], [136, 0, 182], [150, 0, 160], [172, 0, 140], [194, 0, 182], [208, 0, 110], [230, 0, 170], [252, 0, 182], [266, 0, 130], [288, 0, 160]];
    foreach ($para as $p) $s .= rl_agv_r(14, $p[0], min($p[2], 160), 4, 'v-line');
    $claims = [[60, 40, 100], [132, 60, 90], [190, 24, 110], [262, 50, 90]];
    foreach ($claims as $i => $c) $s .= rl_agv_r(14 + $c[1], $c[0] - 2, $c[2], 8, 'v-claim') . rl_agv_t(196, $c[0] + 5, 'C' . ($i + 1), 'v-tr', 'end');
    $s .= rl_agv_t(240, 14, 'CLAIM', 'v-lab') . rl_agv_t(276, 14, 'SOURCE', 'v-lab') . rl_agv_t(372, 14, 'CONFIDENCE', 'v-lab') . rl_agv_t(520, 14, 'STATUS', 'v-lab', 'end');
    $rows = [['PEER-REVIEWED', 5, 'VERIFIED', 'ok'], ['REGULATOR', 5, 'VERIFIED', 'ok'], ['TRADE SOURCE', 3, 'CHECK DATE', 'warn'], ['NONE FOUND', 0, 'TO A PERSON', 'flag']];
    foreach ($rows as $i => $r) {
        $y = 30 + $i * 74;
        $s .= rl_agv_r(232, $y, 288, 60) . rl_agv_r(232, $y, 288, 60, $r[3] === 'flag' ? 'v-bflag' : 'v-bh', 3 + $i * 2) . rl_agv_t(244, $y + 34, 'C' . ($i + 1), 'v-tr') . rl_agv_t(276, $y + 34, $r[0], $r[3] === 'flag' ? 'v-tr' : 'v-tb');
        for ($k = 0; $k < 5; $k++) $s .= rl_agv_r(372 + $k * 12, $y + 26, 9, 10, $k < $r[1] ? 'v-cell' : 'v-cell0', $k < $r[1] ? 4 + $i * 2 : null);
        $s .= rl_agv_t(512, $y + 34, $r[2], $r[3] === 'ok' ? 'v-tb' : 'v-tr', 'end');
        if ($r[3] === 'ok') $s .= rl_agv_tick(436, $y + 25, 4 + $i * 2);
    }
    foreach ($claims as $i => $c) $s .= rl_agv_dw('M196 ' . ($c[0] + 2) . ' C214 ' . ($c[0] + 2) . ' 214 ' . (60 + $i * 74) . ' 232 ' . (60 + $i * 74), 2 + $i * 2);
    $s .= rl_agv_r(232, 326, 288, 0, 'v-l2');
    return $s . rl_agv_foot('NO EVIDENCE, NO CLAIM', 'A-03');
}

/* A-04 AEO / GEO: page blocks made answer-ready -> AI engines */
function rl_agv_aeo_geo_optimization() {
    $s = rl_agv_t(0, 14, 'YOUR PAGE', 'v-lab') . rl_agv_r(0, 24, 150, 302);
    $blocks = ['DEFINITION', 'STEPS', 'FAQ', 'KEY FACTS', 'SCHEMA'];
    foreach ($blocks as $i => $b) { $y = 38 + $i * 56; $s .= rl_agv_r(12, $y, 126, 42, 'v-b') . rl_agv_r(12, $y, 126, 42, 'v-bh', 1 + $i) . rl_agv_t(22, $y + 17, $b, 'v-tb') . rl_agv_r(22, $y + 26, 90, 3, 'v-line') . rl_agv_r(22, $y + 33, 64, 3, 'v-line'); }
    $s .= rl_agv_t(180, 14, 'ANSWER-READY', 'v-lab');
    foreach (['ANSWER FIRST', 'ONE IDEA EACH', 'ENTITIES NAMED', 'FACTS MATCH', 'MARKED UP'] as $i => $t) { $y = 48 + $i * 56; $s .= rl_agv_tick(180, $y + 2, 1 + $i) . rl_agv_c(184, $y + 6, 7, 'v-ring0') . rl_agv_t(198, $y + 10, $t, 'v-t'); }
    $s .= rl_agv_t(340, 14, 'AI ENGINE', 'v-lab') . rl_agv_t(466, 14, 'M', 'v-lab', 'middle') . rl_agv_t(488, 14, 'C', 'v-lab', 'middle') . rl_agv_t(510, 14, 'A', 'v-lab', 'middle');
    foreach (['CHATGPT', 'PERPLEXITY', 'GEMINI', 'AI OVERVIEWS'] as $i => $e) {
        $y = 30 + $i * 70;
        $s .= rl_agv_r(332, $y, 188, 52) . rl_agv_t(344, $y + 30, $e, 'v-tb');
        foreach ([0, 1, 2] as $k) $s .= rl_agv_r(460 + $k * 22, $y + 20, 12, 12, 'v-cell0') . rl_agv_r(460 + $k * 22, $y + 20, 12, 12, 'v-cellr', 7 + $k + ($i % 2));
    }
    foreach ([0, 1, 2, 3] as $i) $s .= rl_agv_dw('M310 ' . (78 + $i * 56) . ' C322 ' . (78 + $i * 56) . ' 320 ' . (56 + $i * 70) . ' 332 ' . (56 + $i * 70), 6 + $i);
    $s .= rl_agv_t(520, 310, 'M MENTIONED · C CITED', 'v-lab', 'end') . rl_agv_t(520, 324, 'A DESCRIBED ACCURATELY', 'v-lab', 'end');
    return $s . rl_agv_foot('YOUR PAGES · ENTITY FACTS · AI ANSWERS', 'A-04');
}

/* A-05 Social Sentiment: voices -> themes -> outputs */
function rl_agv_social_sentiment() {
    $s = '';
    $src = ['FORUMS', 'REVIEWS', 'SOCIAL POSTS'];
    foreach ($src as $i => $t) {
        $y = 24 + $i * 104;
        $s .= rl_agv_t(0, $y - 6 + 0, $t, 'v-lab');
        foreach ([0, 1] as $k) {
            $by = $y + $k * 42; $w = $k ? 120 : 140;
            $s .= rl_agv_r(0, $by, $w, 30, 'v-b') . '<path class="v-b" d="M14 ' . ($by + 30) . ' l6 8 l6 -8"/>' . rl_agv_r(10, $by + 9, $w - 30, 3, 'v-line') . rl_agv_r(10, $by + 17, $w - 60, 3, 'v-line') . rl_agv_r(0, $by, $w, 30, 'v-bh', $i * 2 + $k);
        }
    }
    $themes = [['OBJECTION', 'PRICE AND VALUE'], ['CONFUSION', 'HOW TO START'], ['QUESTION', 'CAN WE TRUST IT']];
    $s .= rl_agv_t(196, 14, 'THEMES', 'v-lab');
    foreach ($themes as $i => $t) {
        $y = 30 + $i * 104;
        $s .= rl_agv_r(196, $y, 150, 70) . rl_agv_r(196, $y, 150, 70, 'v-bh', 6 + $i) . rl_agv_t(208, $y + 22, $t[0], 'v-tr') . rl_agv_t(208, $y + 38, $t[1], 'v-tb');
        for ($k = 0; $k < 6 - $i; $k++) $s .= rl_agv_r(208 + $k * 12, $y + 50, 8, 8, 'v-cell', 6 + $i);
    }
    foreach ([[0, 0], [1, 0], [2, 1], [3, 1], [4, 2], [5, 2]] as $p) { $sy = 24 + intdiv($p[0], 2) * 104 + ($p[0] % 2) * 42 + 15; $ty = 30 + $p[1] * 104 + 35; $sx = ($p[0] % 2) ? 120 : 140; $s .= rl_agv_dw('M' . $sx . ' ' . $sy . ' C170 ' . $sy . ' 172 ' . $ty . ' 196 ' . $ty, 2 + $p[1] * 2); }
    $s .= rl_agv_t(380, 14, 'OUTPUTS', 'v-lab');
    foreach (['FAQ TOPICS', 'NEW ANGLES', 'THEIR WORDS IN COPY'] as $i => $t) { $y = 42 + $i * 104; $s .= rl_agv_r(380, $y, 140, 46) . rl_agv_r(380, $y, 140, 46, 'v-bh', 10 + $i) . rl_agv_t(392, $y + 28, $t, 'v-tb'); $s .= rl_agv_dw('M346 ' . (65 + $i * 104) . ' H380', 9 + $i); }
    $s .= rl_agv_t(0, 340, 'TONE', 'v-lab') . rl_agv_r(40, 333, 120, 8, 'v-neg') . rl_agv_r(162, 333, 140, 8, 'v-mid') . rl_agv_r(304, 333, 216, 8, 'v-pos');
    return $s . rl_agv_foot('FORUMS · REVIEWS · SOCIAL POSTS', 'A-05');
}

/* A-06 Competitor Intelligence: coverage radar + alerts */
function rl_agv_competitor_intelligence() {
    $cx = 156; $cy = 170; $R = 100;
    $ax = ['PRICING', 'GUIDES', 'COMPARISONS', 'TOOLS', 'CASE STUDIES', 'FAQ'];
    $pt = function ($i, $f) use ($cx, $cy, $R) { $a = deg2rad(-90 + $i * 60); return round($cx + cos($a) * $R * $f, 1) . ',' . round($cy + sin($a) * $R * $f, 1); };
    $s = rl_agv_t(0, 14, 'TOPIC COVERAGE', 'v-lab');
    foreach ([0.33, 0.66, 1] as $f) { $p = []; for ($i = 0; $i < 6; $i++) $p[] = $pt($i, $f); $s .= '<polygon class="v-grid" points="' . implode(' ', $p) . '"/>'; }
    for ($i = 0; $i < 6; $i++) { list($x, $y) = explode(',', $pt($i, 1)); $s .= rl_agv_l($cx, $cy, $x, $y, 'v-grid'); list($lx, $ly) = explode(',', $pt($i, 1.16)); $s .= rl_agv_t($lx, (float) $ly + 3, $ax[$i], 'v-lab', 'middle'); }
    $riv = [0.9, 0.8, 0.95, 0.55, 0.7, 0.85]; $you = [0.75, 0.85, 0.3, 0.6, 0.35, 0.8];
    $p = []; foreach ($riv as $i => $f) $p[] = $pt($i, $f); $s .= '<polygon class="v-riv" points="' . implode(' ', $p) . '"/>';
    $p = []; foreach ($you as $i => $f) $p[] = $pt($i, $f); $s .= '<polygon class="v-you v-dw v-d1" pathLength="100" points="' . implode(' ', $p) . '"/>';
    foreach ([2, 4] as $k => $i) { list($x, $y) = explode(',', $pt($i, 0.62)); $s .= rl_agv_c($x, $y, 12, 'v-ring', 3 + $k) . rl_agv_t($x, (float) $y + 3, 'GAP', 'v-tr', 'middle'); }
    $s .= rl_agv_r(0, 318, 10, 4, 'v-rivk') . rl_agv_t(16, 322, 'RIVALS', 'v-lab') . rl_agv_r(76, 318, 10, 4, 'v-youk') . rl_agv_t(92, 322, 'YOU', 'v-lab');
    $s .= rl_agv_t(326, 14, 'ALERTS', 'v-lab');
    foreach (['NEW COMPARISON PAGE', 'CITED IN AN AI ANSWER', 'PRICING PAGE UPDATED'] as $i => $t) { $y = 24 + $i * 52; $s .= rl_agv_r(326, $y, 194, 40) . rl_agv_r(326, $y, 194, 40, 'v-bh', 5 + $i) . rl_agv_t(338, $y + 16, 'RIVAL', 'v-tr') . rl_agv_t(338, $y + 30, $t, 'v-tb'); }
    $s .= rl_agv_t(326, 200, 'TARGET PAGES', 'v-lab');
    foreach (['COMPARISON HUB', 'CASE STUDY SET'] as $i => $t) { $y = 210 + $i * 52; $s .= rl_agv_r(326, $y, 194, 40) . rl_agv_r(326, $y, 194, 40, 'v-bh', 9 + $i) . rl_agv_t(338, $y + 25, 'BUILD · ' . $t, 'v-tb'); }
    return $s . rl_agv_foot('RIVAL RANKINGS · RIVAL CONTENT · AI CITATIONS', 'A-06');
}

/* A-07 Content QA: three check lanes -> fix list / approval */
function rl_agv_content_qa() {
    $s = rl_agv_t(0, 14, 'DRAFT', 'v-lab') . rl_agv_r(0, 24, 84, 120);
    foreach ([40, 52, 70, 82, 94, 112, 124] as $k => $y) $s .= rl_agv_r(10, $y, $k % 3 ? 54 : 64, 4, $k === 0 ? 'v-line2' : 'v-line');
    $lanes = [['SEO', ['TITLE', 'INTENT', 'LINKS', 'SCHEMA']], ['AEO / GEO', ['ANSWER FIRST', 'ENTITIES', 'Q AND A', 'CITABLE']], ['EVIDENCE', ['SOURCES', 'DATES', 'CLAIMS', 'FLAGS']]];
    foreach ($lanes as $i => $ln) {
        $y = 24 + $i * 100;
        $s .= rl_agv_t(108, $y - 2 + 0, $ln[0] . ' CHECK', 'v-lab') . rl_agv_r(108, $y + 6, 260, 76);
        foreach ($ln[1] as $k => $c) {
            $x = 118 + ($k % 2) * 124; $cy = $y + 22 + intdiv($k, 2) * 30;
            $fail = ($i === 2 && $k === 1);
            $s .= rl_agv_r($x, $cy - 8, 12, 12, 'v-cell0') . ($fail ? rl_agv_r($x, $cy - 8, 12, 12, 'v-cellr', 2 + $i * 3 + $k) . '<path class="v-x" d="M' . ($x + 3) . ' ' . ($cy - 5) . ' l6 6 m0 -6 l-6 6"/>' : rl_agv_tick($x + 1, $cy - 8, 1 + $i * 3 + intdiv($k, 2))) . rl_agv_t($x + 20, $cy + 2, $c, $fail ? 'v-tr' : 'v-t');
        }
        $s .= rl_agv_dw('M84 84 C96 84 96 ' . ($y + 44) . ' 108 ' . ($y + 44), $i);
    }
    $s .= rl_agv_t(392, 14, 'FIX LIST', 'v-lab') . rl_agv_r(392, 24, 128, 96) . rl_agv_r(392, 24, 128, 96, 'v-bflag', 9) . rl_agv_t(404, 50, 'EVIDENCE', 'v-tr') . rl_agv_t(404, 66, 'UPDATE OLD DATE', 'v-tb') . rl_agv_r(404, 80, 90, 4, 'v-line') . rl_agv_r(404, 92, 70, 4, 'v-line');
    $s .= rl_agv_dw('M368 268 C380 268 380 72 392 72', 8);
    $s .= rl_agv_t(392, 150, 'GATE', 'v-lab') . rl_agv_r(392, 160, 128, 70) . rl_agv_r(392, 160, 128, 70, 'v-bh', 11) . rl_agv_t(456, 192, 'APPROVED', 'v-stamp', 'middle', 11) . rl_agv_t(456, 214, 'BY A PERSON', 'v-lab', 'middle');
    $s .= rl_agv_t(392, 256, 'AUDIT TRAIL', 'v-lab');
    foreach ([266, 280, 294, 308] as $k => $y) $s .= rl_agv_r(392, $y, $k % 2 ? 100 : 124, 4, 'v-line', 10 + intdiv($k, 2));
    return $s . rl_agv_foot('DRAFT · STANDARDS · EVIDENCE LOG', 'A-07');
}

/* A-08 Search Performance: drop detected -> causes -> recovery */
function rl_agv_search_performance() {
    $s = rl_agv_t(0, 14, 'SEARCH CLICKS', 'v-lab') . rl_agv_l(20, 24, 20, 280, 'v-l2') . rl_agv_l(20, 280, 316, 280, 'v-l2') . rl_agv_t(316, 296, 'WEEKS', 'v-lab', 'end');
    foreach ([80, 140, 200] as $y) $s .= rl_agv_l(20, $y, 316, $y, 'v-dash');
    $s .= '<path class="v-line3" d="M20 96 L48 90 L76 100 L104 88 L132 94 L160 86 L188 96 L204 160 L226 196 L254 204 L282 200 L316 206"/>';
    $s .= rl_agv_dw('M282 200 C296 170 304 130 316 110', 9, 'v-lrd');
    $s .= rl_agv_c(204, 160, 6, 'v-ring', 1) . rl_agv_r(150, 216, 108, 26, 'v-bh', 2) . rl_agv_t(204, 233, 'DROP DETECTED', 'v-tr', 'middle', 2) . rl_agv_t(310, 104, 'RECOVERY', 'v-tr', 'end', 10);
    $s .= rl_agv_t(340, 14, 'DIAGNOSE', 'v-lab');
    $c = ['SEARCH RESULTS CHANGED', 'INTENT SHIFTED', 'CONTENT DECAYED', 'PAGES COMPETE', 'TECHNICAL ISSUE'];
    foreach ($c as $i => $t) {
        $y = 24 + $i * 44; $root = ($i === 2);
        $s .= rl_agv_r(340, $y, 180, 34) . rl_agv_r(340, $y, 180, 34, $root ? 'v-bflag' : 'v-bdim', 3 + $i) . rl_agv_t(352, $y + 21, $t, $root ? 'v-tb' : 'v-t');
    }
    $s .= rl_agv_t(512, 133, 'ROOT CAUSE', 'v-tr', 'end', 8);
    $s .= rl_agv_t(340, 262, 'RECOVERY PLAN', 'v-lab') . rl_agv_r(340, 272, 180, 54) . rl_agv_r(340, 272, 180, 54, 'v-bh', 9) . rl_agv_t(352, 294, 'REFRESH THE PAGE', 'v-tb') . rl_agv_t(352, 310, 'RE-CHECK IN 2 WEEKS', 'v-t');
    $s .= rl_agv_dw('M258 229 C300 229 300 129 340 129', 7);
    return $s . rl_agv_foot('SEARCH CONSOLE · GA4 · AI VISIBILITY', 'A-08');
}

/* ---------- phone drawings (viewBox 320 x 392, labels 11 px) ---------- */
function rl_agv_mfoot($id) { return rl_agv_l(0, 360, 320, 360, 'v-l2') . rl_agv_t(0, 382, $id . ' · REVIEWED BY A PERSON', 'm-lab'); }

function rl_agv_seo_intelligence_m() {
    $s = rl_agv_t(0, 12, 'BUSINESS VALUE', 'm-lab') . rl_agv_l(20, 20, 20, 160, 'v-l2') . rl_agv_l(20, 160, 300, 160, 'v-l2') . rl_agv_t(300, 176, 'DIFFICULTY', 'm-lab', 'end');
    $s .= rl_agv_l(160, 20, 160, 160, 'v-dash') . rl_agv_l(20, 90, 300, 90, 'v-dash') . rl_agv_r(21, 21, 138, 68, 'v-bh', 1) . rl_agv_t(28, 38, 'QUICK WINS', 'm-tr');
    foreach ([[200, 50], [250, 74], [60, 124], [110, 140], [210, 120], [270, 140]] as $p) $s .= rl_agv_c($p[0], $p[1], 3.5);
    foreach ([[60, 66], [104, 54], [136, 76]] as $i => $p) $s .= rl_agv_c($p[0], $p[1], 8, 'v-ring', 2 + $i) . rl_agv_c($p[0], $p[1], 4, 'v-dotr', 2 + $i);
    $s .= rl_agv_t(0, 204, 'PAGE PLAN', 'm-lab');
    foreach ([['P1', 'QUICK WIN · EXISTING PAGE'], ['P2', 'NEW PAGE · HIGH INTENT'], ['P3', 'REFRESH · NEAR PAGE ONE']] as $i => $r) { $y = 214 + $i * 46; $s .= rl_agv_r(0, $y, 320, 38) . rl_agv_r(0, $y, 320, 38, 'v-bh', 5 + $i) . rl_agv_t(12, $y + 24, $r[0], 'm-tr') . rl_agv_t(44, $y + 24, $r[1], 'm-tb'); }
    return $s . rl_agv_mfoot('A-01');
}
function rl_agv_content_research_m() {
    $s = rl_agv_t(0, 12, 'WHAT THE TOP PAGES COVER', 'm-lab');
    foreach (['R1', 'R2', 'R3', 'R4'] as $j => $c) $s .= rl_agv_t(168 + $j * 30, 32, $c, 'm-lab', 'middle');
    $s .= rl_agv_t(296, 32, 'GAP', 'm-tr', 'middle');
    $cov = [['DEFINITION', [1, 1, 1, 1]], ['COST', [0, 0, 0, 0]], ['COMPARISON', [1, 0, 1, 0]], ['RISKS', [0, 0, 0, 0]]];
    foreach ($cov as $i => $r) {
        $y = 40 + $i * 42; $gap = array_sum($r[1]) === 0;
        $s .= rl_agv_r(0, $y, 320, 34) . ($gap ? rl_agv_r(0, $y, 320, 34, 'v-bh', 2 + ($i > 1 ? 1 : 0)) : '') . rl_agv_t(10, $y + 22, $r[0], $gap ? 'm-tb' : 'm-t');
        foreach ($r[1] as $j => $v) $s .= rl_agv_r(160 + $j * 30, $y + 9, 16, 16, $v ? 'v-cell' : 'v-cell0');
        if ($gap) $s .= rl_agv_r(288, $y + 9, 16, 16, 'v-cellr');
    }
    $s .= rl_agv_t(0, 226, 'RESEARCH BRIEF', 'm-lab') . rl_agv_r(0, 236, 320, 108) . rl_agv_t(12, 262, 'H2 · COST', 'm-tr', 'start', 4) . rl_agv_t(12, 286, 'H2 · RISKS', 'm-tr', 'start', 5);
    foreach ([0, 1, 2] as $i) $s .= rl_agv_r(12 + $i * 46, 304, 38, 26) . rl_agv_t(31 + $i * 46, 321, '[' . ($i + 1) . ']', 'm-t', 'middle') . rl_agv_r(12 + $i * 46, 304, 38, 26, 'v-bh', 6 + $i);
    $s .= rl_agv_t(308, 321, 'SOURCES', 'm-lab', 'end');
    return $s . rl_agv_mfoot('A-02');
}
function rl_agv_evidence_verification_m() {
    $s = rl_agv_t(0, 12, 'DRAFT', 'm-lab') . rl_agv_r(0, 20, 320, 96);
    foreach ([34, 47, 60, 73, 86, 99] as $k => $y) $s .= rl_agv_r(12, $y, $k % 2 ? 230 : 270, 4, 'v-line');
    foreach ([[33, 40, 120, 'C1'], [59, 90, 110, 'C2'], [85, 30, 130, 'C3']] as $c) $s .= rl_agv_r(12 + $c[1], $c[0] - 2, $c[2], 8, 'v-claim') . rl_agv_t(310, $c[0] + 5, $c[3], 'm-tr', 'end');
    $s .= rl_agv_t(0, 138, 'CLAIM LEDGER', 'm-lab');
    foreach ([['PEER-REVIEWED', 5, 'VERIFIED', 'ok'], ['TRADE SOURCE', 3, 'CHECK DATE', 'warn'], ['NONE FOUND', 0, 'TO A PERSON', 'flag']] as $i => $r) {
        $y = 148 + $i * 66;
        $s .= rl_agv_r(0, $y, 320, 56) . rl_agv_r(0, $y, 320, 56, $r[3] === 'flag' ? 'v-bflag' : 'v-bh', 2 + $i * 2) . rl_agv_t(12, $y + 22, 'C' . ($i + 1), 'm-tr') . rl_agv_t(44, $y + 22, $r[0], $r[3] === 'flag' ? 'm-tr' : 'm-tb');
        for ($k = 0; $k < 5; $k++) $s .= rl_agv_r(44 + $k * 14, $y + 32, 10, 10, $k < $r[1] ? 'v-cell' : 'v-cell0');
        $s .= rl_agv_t(308, $y + 42, $r[2], $r[3] === 'ok' ? 'm-tb' : 'm-tr', 'end');
        if ($r[3] === 'ok') $s .= rl_agv_tick(120, $y + 31, 3 + $i * 2);
    }
    return $s . rl_agv_mfoot('A-03');
}
function rl_agv_aeo_geo_optimization_m() {
    $s = rl_agv_t(0, 12, 'PAGE SECTIONS MADE ANSWER-READY', 'm-lab');
    foreach (['DEFINITION', 'FAQ', 'KEY FACTS'] as $i => $c) $s .= rl_agv_r($i * 108, 22, 100, 34) . rl_agv_r($i * 108, 22, 100, 34, 'v-bh', 1 + $i) . rl_agv_t($i * 108 + 50, 43, $c, 'm-tb', 'middle');
    $s .= rl_agv_t(0, 86, 'AI ENGINE', 'm-lab');
    foreach (['M', 'C', 'A'] as $k => $l) $s .= rl_agv_t(236 + $k * 26, 86, $l, 'm-lab', 'middle');
    foreach (['CHATGPT', 'PERPLEXITY', 'GEMINI', 'AI OVERVIEWS'] as $i => $e) {
        $y = 96 + $i * 56;
        $s .= rl_agv_r(0, $y, 320, 46) . rl_agv_t(12, $y + 28, $e, 'm-tb');
        foreach ([0, 1, 2] as $k) $s .= rl_agv_r(228 + $k * 26, $y + 15, 16, 16, 'v-cell0') . rl_agv_r(228 + $k * 26, $y + 15, 16, 16, 'v-cellr', 4 + $k + ($i % 2));
    }
    $s .= rl_agv_t(0, 340, 'M MENTIONED · C CITED · A ACCURATE', 'm-lab');
    return $s . rl_agv_mfoot('A-04');
}
function rl_agv_social_sentiment_m() {
    $s = rl_agv_t(0, 12, 'WHERE CUSTOMERS TALK', 'm-lab');
    foreach (['FORUMS', 'REVIEWS', 'SOCIAL'] as $i => $c) $s .= rl_agv_r($i * 108, 22, 100, 32) . rl_agv_r($i * 108, 22, 100, 32, 'v-bh', $i) . rl_agv_t($i * 108 + 50, 42, $c, 'm-tb', 'middle');
    $s .= rl_agv_t(0, 82, 'THEMES', 'm-lab');
    foreach ([['OBJECTION', 'PRICE AND VALUE', 6], ['CONFUSION', 'HOW TO START', 5], ['QUESTION', 'CAN WE TRUST IT', 4]] as $i => $t) {
        $y = 92 + $i * 58;
        $s .= rl_agv_r(0, $y, 320, 48) . rl_agv_r(0, $y, 320, 48, 'v-bh', 3 + $i) . rl_agv_t(12, $y + 20, $t[0], 'm-tr') . rl_agv_t(12, $y + 38, $t[1], 'm-tb');
        for ($k = 0; $k < $t[2]; $k++) $s .= rl_agv_r(300 - $k * 13, $y + 30, 9, 9, 'v-cell');
    }
    $s .= rl_agv_t(0, 278, 'OUTPUTS', 'm-lab');
    foreach (['FAQ TOPICS', 'NEW ANGLES'] as $i => $c) $s .= rl_agv_r($i * 166, 288, 154, 40) . rl_agv_r($i * 166, 288, 154, 40, 'v-bh', 7 + $i) . rl_agv_t($i * 166 + 77, 313, $c, 'm-tb', 'middle');
    return $s . rl_agv_mfoot('A-05');
}
function rl_agv_competitor_intelligence_m() {
    $cx = 160; $cy = 122; $R = 78;
    $ax = ['PRICING', 'GUIDES', 'COMPARE', 'TOOLS', 'CASES', 'FAQ'];
    $pt = function ($i, $f) use ($cx, $cy, $R) { $a = deg2rad(-90 + $i * 60); return round($cx + cos($a) * $R * $f, 1) . ',' . round($cy + sin($a) * $R * $f, 1); };
    $s = rl_agv_r(0, 6, 10, 5, 'v-rivk') . rl_agv_t(16, 12, 'RIVALS', 'm-lab') . rl_agv_r(0, 22, 10, 5, 'v-youk') . rl_agv_t(16, 28, 'YOU', 'm-lab');
    foreach ([0.5, 1] as $f) { $p = []; for ($i = 0; $i < 6; $i++) $p[] = $pt($i, $f); $s .= '<polygon class="v-grid" points="' . implode(' ', $p) . '"/>'; }
    for ($i = 0; $i < 6; $i++) { list($x, $y) = explode(',', $pt($i, 1)); $s .= rl_agv_l($cx, $cy, $x, $y, 'v-grid'); list($lx, $ly) = explode(',', $pt($i, 1.24)); $s .= rl_agv_t($lx, (float) $ly + 4, $ax[$i], 'm-lab', 'middle'); }
    $p = []; foreach ([0.9, 0.8, 0.95, 0.55, 0.7, 0.85] as $i => $f) $p[] = $pt($i, $f); $s .= '<polygon class="v-riv" points="' . implode(' ', $p) . '"/>';
    $p = []; foreach ([0.75, 0.85, 0.3, 0.6, 0.35, 0.8] as $i => $f) $p[] = $pt($i, $f); $s .= '<polygon class="v-you v-dw v-d1" pathLength="100" points="' . implode(' ', $p) . '"/>';
    foreach ([2, 4] as $k => $i) { list($x, $y) = explode(',', $pt($i, 0.62)); $s .= rl_agv_c($x, $y, 13, 'v-ring', 2 + $k) . rl_agv_t($x, (float) $y + 4, 'GAP', 'm-tr', 'middle'); }
    $s .= rl_agv_t(0, 240, 'ALERTS', 'm-lab');
    foreach (['NEW COMPARISON PAGE', 'CITED IN AN AI ANSWER'] as $i => $t) { $y = 250 + $i * 48; $s .= rl_agv_r(0, $y, 320, 40) . rl_agv_r(0, $y, 320, 40, 'v-bh', 4 + $i) . rl_agv_t(12, $y + 25, 'RIVAL', 'm-tr') . rl_agv_t(66, $y + 25, $t, 'm-tb'); }
    return $s . rl_agv_mfoot('A-06');
}
function rl_agv_content_qa_m() {
    $s = rl_agv_t(0, 12, 'DRAFT CHECKED IN THREE LANES', 'm-lab');
    foreach ([['SEO CHECK', -1], ['AEO / GEO CHECK', -1], ['EVIDENCE CHECK', 1]] as $i => $ln) {
        $y = 22 + $i * 58;
        $s .= rl_agv_r(0, $y, 320, 48) . rl_agv_t(12, $y + 18, $ln[0], 'm-lab');
        for ($k = 0; $k < 4; $k++) { $x = 12 + $k * 30; $s .= rl_agv_r($x, $y + 25, 14, 14, 'v-cell0') . ($k === $ln[1] ? rl_agv_r($x, $y + 25, 14, 14, 'v-cellr', 2 + $i * 2) . '<path class="v-x" d="M' . ($x + 4) . ' ' . ($y + 29) . ' l6 6 m0 -6 l-6 6"/>' : rl_agv_tick($x + 2, $y + 26, 1 + $i * 2)); }
        $s .= rl_agv_t(308, $y + 36, $ln[1] < 0 ? 'PASS' : 'FIX NEEDED', $ln[1] < 0 ? 'm-tb' : 'm-tr', 'end');
    }
    $s .= rl_agv_r(0, 206, 154, 84) . rl_agv_r(0, 206, 154, 84, 'v-bflag', 7) . rl_agv_t(12, 230, 'FIX LIST', 'm-tr') . rl_agv_t(12, 252, 'UPDATE OLD DATE', 'm-tb') . rl_agv_r(12, 266, 110, 4, 'v-line');
    $s .= rl_agv_r(166, 206, 154, 84) . rl_agv_r(166, 206, 154, 84, 'v-bh', 9) . rl_agv_t(243, 248, 'APPROVED', 'v-stamp', 'middle', 9) . rl_agv_t(243, 272, 'BY A PERSON', 'm-lab', 'middle');
    $s .= rl_agv_t(0, 316, 'AUDIT TRAIL', 'm-lab');
    foreach ([326, 338] as $k => $y) $s .= rl_agv_r(0, $y, $k ? 200 : 280, 4, 'v-line', 10 + $k);
    return $s . rl_agv_mfoot('A-07');
}
function rl_agv_search_performance_m() {
    $s = rl_agv_t(0, 12, 'SEARCH CLICKS', 'm-lab') . rl_agv_l(10, 20, 10, 150, 'v-l2') . rl_agv_l(10, 150, 310, 150, 'v-l2') . rl_agv_l(10, 85, 310, 85, 'v-dash');
    $s .= '<path class="v-line3" d="M10 50 L40 46 L70 54 L100 44 L130 50 L150 48 L170 96 L190 120 L220 126 L250 122 L280 128"/>' . rl_agv_dw('M280 128 C292 110 300 86 310 64', 9, 'v-lrd');
    $s .= rl_agv_c(170, 96, 7, 'v-ring', 1) . rl_agv_t(182, 92, 'DROP DETECTED', 'm-tr', 'start', 2) . rl_agv_t(306, 58, 'RECOVERY', 'm-tr', 'end', 10);
    $s .= rl_agv_t(0, 180, 'LIKELY CAUSES', 'm-lab');
    foreach (['INTENT SHIFTED', 'CONTENT DECAYED', 'PAGES COMPETE'] as $i => $t) {
        $y = 190 + $i * 46; $root = ($i === 1);
        $s .= rl_agv_r(0, $y, 320, 38) . rl_agv_r(0, $y, 320, 38, $root ? 'v-bflag' : 'v-bdim', 3 + $i) . rl_agv_t(12, $y + 24, $t, $root ? 'm-tb' : 'm-t');
    }
    $s .= rl_agv_t(308, 260, 'ROOT CAUSE', 'm-tr', 'end', 6);
    return $s . rl_agv_mfoot('A-08');
}

/* ---------- CSS + keyframes (printed inside the agent page's style block) ---------- */
function rl_agv_css() {
    $k = '';
    for ($i = 0; $i < 13; $i++) {
        $on = 4 + $i * 5;
        $k .= "@keyframes rlvS$i{0%,{$on}%{opacity:0}" . ($on + 3) . "%,92%{opacity:1}97%,100%{opacity:0}}.rl-ag .v-s$i{animation-name:rlvS$i}\n";
        $k .= "@keyframes rlvD$i{0%,{$on}%{stroke-dashoffset:100;opacity:1}" . ($on + 8) . "%,92%{stroke-dashoffset:0;opacity:1}97%,100%{stroke-dashoffset:0;opacity:0}}.rl-ag .v-d$i{animation-name:rlvD$i}\n";
    }
    return '.rl-ag .agf{display:flex;flex-direction:column}.rl-ag .agf>svg{margin-block:auto}
.rl-ag .v-b{fill:var(--bg);stroke:rgba(243,237,230,.14);stroke-width:.8}
.rl-ag .v-bh{fill:rgba(153,0,0,.10);stroke:rgba(226,59,59,.7);stroke-width:.8}
.rl-ag .v-bflag{fill:rgba(153,0,0,.2);stroke:var(--red-2);stroke-width:1.2}
.rl-ag .v-bdim{fill:rgba(243,237,230,.04);stroke:rgba(243,237,230,.3);stroke-width:.8}
.rl-ag .v-t{font-family:var(--f-mono);font-size:8px;letter-spacing:.08em;fill:var(--ink-dim)}
.rl-ag .v-tb{font-family:var(--f-mono);font-size:8px;letter-spacing:.08em;fill:var(--ink)}
.rl-ag .v-tr{font-family:var(--f-mono);font-size:8px;letter-spacing:.1em;fill:var(--red-3)}
.rl-ag .v-lab{font-family:var(--f-mono);font-size:7.5px;letter-spacing:.18em;fill:var(--ink-faint)}
.rl-ag .v-stamp{font-family:var(--f-display);font-weight:600;font-size:16px;letter-spacing:.12em;fill:var(--ink)}
.rl-ag .v-l{stroke:rgba(243,237,230,.14);stroke-width:.8}
.rl-ag .v-l2{stroke:var(--line-2);stroke-width:1}
.rl-ag .v-dash{stroke:rgba(243,237,230,.12);stroke-width:.8;stroke-dasharray:3 4}
.rl-ag .v-lr,.rl-ag .v-lrd{fill:none;stroke:var(--red-3);stroke-width:1.2;stroke-linecap:round}
.rl-ag .v-lrd{stroke-width:1.6}
.rl-ag .v-line{fill:rgba(243,237,230,.16)}.rl-ag .v-line2{fill:rgba(243,237,230,.4)}
.rl-ag .v-line3{fill:none;stroke:var(--ink-dim);stroke-width:1.6;stroke-linejoin:round}
.rl-ag .v-claim{fill:rgba(153,0,0,.28)}
.rl-ag .v-dot{fill:rgba(243,237,230,.4)}.rl-ag .v-dotr{fill:var(--red-2)}
.rl-ag .v-ring{fill:none;stroke:var(--red-2);stroke-width:1}.rl-ag .v-ring0{fill:none;stroke:rgba(243,237,230,.25);stroke-width:.8}
.rl-ag .v-cell{fill:rgba(243,237,230,.45)}.rl-ag .v-cell0{fill:none;stroke:rgba(243,237,230,.22);stroke-width:.8}.rl-ag .v-cellr{fill:var(--red-2)}
.rl-ag .v-tick{fill:none;stroke:var(--ok,#5fb37a);stroke-width:1.6;stroke-linecap:round;stroke-linejoin:round}
.rl-ag .v-x{fill:none;stroke:#fff;stroke-width:1.4;stroke-linecap:round}
.rl-ag .v-grid{fill:none;stroke:rgba(243,237,230,.12);stroke-width:.8}
.rl-ag .v-riv{fill:rgba(243,237,230,.08);stroke:rgba(243,237,230,.45);stroke-width:1}
.rl-ag .v-you{fill:rgba(153,0,0,.16);stroke:var(--red-3);stroke-width:1.4}
.rl-ag .v-rivk{fill:rgba(243,237,230,.45)}.rl-ag .v-youk{fill:var(--red-3)}
.rl-ag .v-neg{fill:rgba(153,0,0,.55)}.rl-ag .v-mid{fill:rgba(243,237,230,.25)}.rl-ag .v-pos{fill:rgba(243,237,230,.5)}
/* highlights are visible by default; the keyframes hide them until their step, so reduced motion shows the complete drawing */
.rl-ag .v-dw{stroke-dasharray:100;stroke-dashoffset:0}
.rl-ag .v-k,.rl-ag .v-dw{animation-duration:10s;animation-iteration-count:infinite;animation-timing-function:cubic-bezier(.45,0,.2,1);animation-fill-mode:both}
.rl-ag .m-t{font-family:var(--f-mono);font-size:11px;letter-spacing:.04em;fill:var(--ink-dim)}.rl-ag .m-tb{font-family:var(--f-mono);font-size:11px;letter-spacing:.04em;fill:var(--ink)}.rl-ag .m-tr{font-family:var(--f-mono);font-size:11px;letter-spacing:.06em;fill:var(--red-3)}.rl-ag .m-lab{font-family:var(--f-mono);font-size:9px;letter-spacing:.12em;fill:var(--ink-faint)}
.rl-ag .agf svg.agv-m{display:none}
@media(max-width:560px){.rl-ag .agf svg.agv-d{display:none}.rl-ag .agf svg.agv-m{display:block}.rl-ag .agf .cap span+span{display:none}.rl-ag .agf{padding:16px 12px 10px}}
' . $k;
}
