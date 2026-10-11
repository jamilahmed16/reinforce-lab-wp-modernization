import tinycss2, json, sys
src = open(sys.argv[1] if len(sys.argv) > 1 else 'bootstrap-4.min.css').read()  # usage: bsparse.py [input.css]
rules = tinycss2.parse_stylesheet(src, skip_comments=True, skip_whitespace=True)
def split_sel(prelude):
    parts, cur, depth = [], [], 0
    for t in prelude:
        if t.type == '() block' or t.type == '[] block': pass
        if t.type == 'literal' and t.value == ',' : parts.append(tinycss2.serialize(cur).strip()); cur = []; continue
        cur.append(t)
    parts.append(tinycss2.serialize(cur).strip()); return [p for p in parts if p]
sels = set(); kinds = {}
def walk(rs, ctx):
    for r in rs:
        if r.type == 'qualified-rule':
            for s in split_sel(r.prelude): sels.add(s)
        elif r.type == 'at-rule':
            kinds[r.lower_at_keyword] = kinds.get(r.lower_at_keyword, 0) + 1
            if r.lower_at_keyword in ('media', 'supports') and r.content is not None:
                walk(tinycss2.parse_rule_list(r.content, skip_comments=True, skip_whitespace=True), ctx)
walk(rules, None)
json.dump(sorted(sels), open('selectors.json', 'w'))
print(len(sels), 'selectors', kinds, sum(1 for r in rules if r.type=='qualified-rule'), 'top rules')
