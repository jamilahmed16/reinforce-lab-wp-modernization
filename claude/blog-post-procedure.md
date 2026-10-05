# Blog post procedure (D-134)

Binding for every post on reinforcelab.online. Set by Jamil on 5 Oct 2026: "the reading difficulty should be 8th grader for all posts .... before writing any post must analyze top 10 results in google with exa ai and find out semantics and use with in the posts for outrank the competitors".

## 1. Keyword and URL
- One primary keyword per post, recorded in the keyword map (D-130) before writing; no two pages target the same keyword.
- Post URLs follow the production pattern `/%postname%/` (D-132). A new URL needs Jamil's approval.

## 2. Top 10 analysis (before writing)
1. **Find the top 10.** Google's order comes from a Google results page (Jamil's screenshot or check); Exa cannot reproduce Google's ranking. Use Exa search to get the exact URLs, and add Exa's own top results for the same query until there are 10 or more pages.
2. **Read them.** Run `python3 claude/tools/serp-semantics.py <slug> - <url> <url> ...`. The .online server fetches each page; pages it cannot read (JavaScript-rendered, bot checks) are listed, and are read with Exa instead.
3. **Note from the report** (`claude/research/serp/<slug>/report.md`): the terms and entities 3 or more competitors use, the questions in their headings, their structure and length, and what none of them covers (the information gain the post will add: a worked example, first-hand experience, cost drivers, risks, a self-test, sources).

## 3. Write
- Answer first: a quotable definition or direct answer at the top.
- Use the common terms where they fit naturally. Never stuff.
- Answer the competitors' questions, in headings or FAQs.
- Add what they miss, and only true, sourced facts. No invented numbers, results or clients.
- First-hand experience where it exists (what Reinforce Lab actually did, with Jamil's approval).
- Reading level 8th grade: short sentences (about 12 to 14 words on average), everyday words.

## 4. Check before publishing
- `python3 claude/tools/readability.py <draft-or-url>`: grade 8.0 or lower.
- `python3 claude/tools/serp-semantics.py <slug> <draft-or-url> <same urls>`: the important topic terms are covered.
- `python3 claude/tools/copy-check.py <file>`: 0 issues.
- Every source link opened and read on the day.
- `python3 claude/tools/seo-audit.py`: title 60 characters or less, meta 140 to 160, one H1, schema, FAQ matches schema.
- Jamil approves, then publish one post at a time (F-003).
