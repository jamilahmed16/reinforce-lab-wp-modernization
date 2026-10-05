<?php
/**
 * Plugin Name: Reinforce Lab - Phone hero diagrams
 * Description: rl_ph() renders a phone version of a hero diagram as real HTML text (12.5 px labels) inside the hero's .rl-anim figure (D-116). At 560 px and below the figure's SVG is hidden and this version shows; above 560 px it is hidden. Same look as the drawings: boxes, red highlights, a 10 s step-by-step reveal, paused off-screen and static for reduced motion (both via .rl-anim in reinforce-header.php).
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

/* $groups: list of groups, each ['label' => '', 'kind' => 'chips|rows|steps|core', 'items' => [...]] or, for 'core', ['title' => '', 'sub' => ''].
   An item is a string or [text, flag] with flag 'hi' (red), 'ok' (tick), 'x' (failed) or 'dim'. Groups are joined by a down arrow unless 'join' => false. */
function rl_ph($groups, $foot = '') {
    $n = 0;
    $step = function () use (&$n) { return ' ph-k ph-s' . min($n++, 15); };
    $h = '<div class="rl-ph">';
    foreach ($groups as $gi => $g) {
        $kind = isset($g['kind']) ? $g['kind'] : 'rows';
        if ($gi > 0 && (!isset($g['join']) || $g['join'])) $h .= '<div class="ph-ar" aria-hidden="true"></div>';
        $h .= '<div class="ph-g">' . (!empty($g['label']) ? '<p class="ph-l">' . esc_html($g['label']) . '</p>' : '');
        if ($kind === 'core') {
            $h .= '<div class="ph-core' . $step() . '"><b>' . esc_html($g['title']) . '</b>' . (!empty($g['sub']) ? '<span>' . esc_html($g['sub']) . '</span>' : '') . '</div>';
        } else {
            $h .= '<ul class="ph-' . $kind . '">';
            foreach ($g['items'] as $it) {
                $t = is_array($it) ? $it[0] : $it; $f = is_array($it) ? ' ph-' . $it[1] : '';
                $h .= '<li class="ph-i' . $f . $step() . '">' . esc_html($t) . '</li>';
            }
            $h .= '</ul>';
        }
        $h .= '</div>';
    }
    return $h . ($foot !== '' ? '<p class="ph-f">' . esc_html($foot) . '</p>' : '') . '</div>';
}

add_action('wp_head', function () {
    $k = '';
    for ($i = 0; $i < 16; $i++) { $on = round(3 + $i * 4.4, 1); $k .= "@keyframes rlPh$i{0%,{$on}%{opacity:.28}" . ($on + 3) . "%,92%{opacity:1}97%,100%{opacity:.28}}.rl-ph .ph-s$i{animation-name:rlPh$i}"; } ?>
<style id="rl-ph-css">
.rl-ph{display:none}
@media(max-width:560px){.rl-anim:has(>.rl-ph)>:not(.rl-ph):not(.cap){display:none!important}.rl-ph{display:block}}
.rl-ph{font-family:var(--f-mono);text-align:left}
.rl-ph .ph-l{font-size:10px;letter-spacing:.16em;color:var(--ink-faint);text-transform:uppercase;margin:0 0 8px}
.rl-ph ul{list-style:none;margin:0;padding:0}
.rl-ph .ph-i{border:1px solid rgba(243,237,230,.16);background:var(--bg);color:var(--ink);font-size:12.5px;line-height:1.35;letter-spacing:.04em;text-transform:uppercase;padding:8px 10px;margin:0}
.rl-ph .ph-chips{display:flex;flex-wrap:wrap;gap:6px}
.rl-ph .ph-rows{display:grid;gap:6px}
.rl-ph .ph-steps{display:flex;flex-wrap:wrap;gap:6px 18px}
.rl-ph .ph-steps .ph-i{position:relative}
.rl-ph .ph-steps .ph-i+.ph-i::before{content:"\2192";position:absolute;left:-15px;top:50%;transform:translateY(-50%);color:var(--red-3);font-size:12px}
.rl-ph .ph-hi{border-color:var(--red-2);background:rgba(153,0,0,.18)}
.rl-ph .ph-dim{color:var(--ink-dim)}
.rl-ph .ph-x{border-color:var(--red-2);color:var(--red-3)}
.rl-ph .ph-ok::before{content:"";display:inline-block;width:9px;height:4px;border-left:2px solid #5fb37a;border-bottom:2px solid #5fb37a;transform:rotate(-45deg);margin:0 9px 3px 1px}
.rl-ph .ph-core{border:1px solid var(--red-2);background:linear-gradient(180deg,rgba(153,0,0,.2),var(--bg));padding:12px 14px}
.rl-ph .ph-core b{display:block;font-family:var(--f-display);font-weight:600;font-size:18px;letter-spacing:.05em;text-transform:uppercase;color:var(--ink);line-height:1.2}
.rl-ph .ph-core span{display:block;font-size:11px;letter-spacing:.12em;color:var(--red-3);text-transform:uppercase;margin-top:5px}
.rl-ph .ph-ar{height:24px;position:relative}
.rl-ph .ph-ar::before{content:"";position:absolute;left:18px;top:3px;bottom:3px;width:1px;background:var(--red-line)}
.rl-ph .ph-ar::after{content:"";position:absolute;left:14px;bottom:4px;width:7px;height:7px;border-right:1px solid var(--red-3);border-bottom:1px solid var(--red-3);transform:rotate(45deg)}
.rl-ph .ph-f{margin:14px 0 0;padding-top:10px;border-top:1px solid var(--line-2);font-size:10px;line-height:1.5;letter-spacing:.14em;color:var(--ink-faint);text-transform:uppercase}
.rl-ph .ph-k{animation-duration:10s;animation-iteration-count:infinite;animation-timing-function:cubic-bezier(.45,0,.2,1);animation-fill-mode:both}
<?php echo $k; ?>

</style>
<?php }, 21);
