# Competitor semantics run for hosting (15 Nov 2026)

Tool: `claude/tools/serp-semantics.py`. Reports: `claude/research/serp/<slug>/report.md`. Competitor URLs are the Firecrawl results (not confirmed Google order). The tool needs 2 or more fetched pages to compute common terms; many review sites blocked fetching, so coverage is uneven. Primary and secondary keywords with volumes still need Semrush or DataForSEO.

| Report | Pages fetched | Common terms | Usable now? |
|---|---|---|---|
| hostinger-review | 3 of 5 | 102 | Yes, partial |
| namecheap-review | 1 of 3 | 0 | Questions only |
| kinsta-review | 4 of 6 | 128 | Yes |
| cloudways-review | 4 of 4 | 247 | Yes |
| nexcess-review | 2 of 3 | 0 | Questions only |
| scalahosting-review | 1 of 4 | 0 | Headings only |
| hosting-com-review | 4 of 5 | 274 | Yes |
| domain-com-review | 1 of 4 | 0 | Headings only |
| network-solutions-review | 1 of 3 | 0 | Questions only |
| bigscoots-review | 2 of 3 | 0 | Weak (one page was a different topic) |
| liquid-web-review | 0 of 3 | 0 | No |
| inmotion-hosting-review | 1 of 4 | 0 | Headings only |
| digitalocean-review | 2 of 2 | 0 | Questions only |
| crazy-domains-review | 0 of 1 | 0 | No |
| spaceship-review | 1 of 2 | 0 | Headings only |
| name-com-review | 1 of 2 | 0 | Questions only |
| ssls-review | 1 of 2 | 0 | Headings only |
| plesk-review | 0 of 3 | 0 | No |
| black-friday-hosting-deals | 3 of 4 | 23 | Yes, partial |
| best-ai-web-hosting | 2 of 3 | 0 | Questions only |
| best-wordpress-hosting | 6 of 6 | 525 | Yes |

## Questions competitors answer in headings (reusable for FAQs)
- Hostinger: Can I host emails on Hostinger? Does Hostinger have hidden fees? Does it offer a money-back guarantee? How does it compare to Bluehost or SiteGround? How is its customer support? Is its VPS good?
- Namecheap: Is Namecheap better than GoDaddy? Good for domain registration? Good for web hosting? Is Namecheap legit? Why are Namecheap domains so cheap?
- Kinsta: How does Kinsta compare with other WordPress hosting? What do customers say about Kinsta's support? Pricing, support, staging sections.
- Cloudways: Are affiliates getting commissions withheld? How is the support? Who is a VPS right for? Is Cloudways right for everybody? Hosting types.
- Nexcess: Does Nexcess offer WordPress hosting? How do I point my domain to Nexcess nameservers? Good for e-commerce? What support channels?
- hosting.com: Are there hidden fees? Can it handle high traffic? How does it compare with A2 Hosting? How do you sign up? Is it worth it?
- Network Solutions: Who owns Network Solutions? Why is it so expensive? Network Solutions vs GoDaddy.
- Name.com: extra costs such as privacy or SSL? transfers? advanced hosting (VPS)? beginner friendly?
- DigitalOcean: Is it good for SaaS and AI applications? Does it manage backups for Droplets? DigitalOcean vs Railway.
- SSLs.com: DV vs OV vs EV, which tier? Setting up a certificate.
- Best AI web hosting: What is AI web hosting? Does AI hosting change my server automatically? Is it more expensive? Do you need an AI website builder? What counts as real AI hosting?
- Best WordPress hosting: Can I use shared hosting? How much does it cost in 2026? How to choose?
- Black Friday: Want to migrate your site this Black Friday? (comparison of deals with free domain, money-back guarantee, free SSL)

## Gaps to fix before writing
1. Re-fetch blocked pages with Exa `web_fetch_exa` (CNET, TechRadar, Website Planet) and rerun the tool for: namecheap, nexcess, scalahosting, domain-com, network-solutions, liquid-web, inmotion, digitalocean, plesk, spaceship, name-com, ssls, crazy-domains, bigscoots.
2. Get volumes, keyword difficulty, related and question keywords from Semrush or DataForSEO for each "[host] review", plus "[host] pricing", "[host] coupon", "[host] vs [other]", "is [host] good".
3. Replace the Firecrawl result order with the true Google top 10.


## Update: rerun with pages read through Exa and Firecrawl (15 Nov, later)
The tool now accepts manual pages saved in `claude/research/serp/<slug>/manual/`. Manual pages hold exact headings and an approximate key-phrase list (not full text), so term counts for those pages are indicative.

| Report | Pages | Common terms | Note |
|---|---|---|---|
| hostinger-review | 5 of 5 | 152 | good |
| hosting-com-review | 5 of 5 | 287 | good |
| namecheap-review | 3 of 3 | 18 | indicative |
| nexcess-review | 3 of 3 | 27 | indicative |
| scalahosting-review | 3 of 4 | 15 | indicative |
| bigscoots-review | 4 of 4 | 23 | two sources are old (2020, 2021) |
| inmotion-hosting-review | 3 of 4 | 16 | indicative |
| digitalocean-review | 3 of 3 | 17 | indicative |
| domain-com-review | 3 of 4 | 7 | indicative |
| network-solutions-review | 3 of 3 | 8 | indicative |
| spaceship-review | 3 of 3 | 6 | indicative |
| liquid-web-review | 2 of 3 | 0 | needs a third page |
| crazy-domains-review | 2 of 2 | 0 | too few competitor articles found |
| name-com-review | 2 of 3 | 0 | needs a third page |
| plesk-review | 1 of 3 | 0 | needs more pages; Plesk is a control panel, so the intent is different |

## What the competitor pages have in common (the standard review structure)
Verdict or "at a glance" box; pros and cons; pricing and plans with renewal prices; performance tests (speed, uptime, stress test); ease of use; security; customer support; alternatives or "X vs Y"; FAQ. Most testers use GTmetrix, Grafana, Loader.io or WebPageTest and report LCP, response time and uptime.

## Gaps that none of the top pages fill (our differentiators)
1. AI features that are real and documented (Hostinger Agent, Cloudways Copilot and AI agents, hosting.com Orbi and MCP, Namecheap AI for WordPress, Spaceship AI builder). Most reviews mention the AI builder only briefly.
2. Renewal pricing in one table, with the first-term and renewal price side by side. Reviewers warn about it but rarely tabulate it.
3. A dated "checked on" offer box with the real end date.
4. Who should avoid the host, with evidence (for example Namecheap "weak hosting", hosting.com high renewals, Hostinger not PCI compliant).
5. Ownership and brand facts (Nexcess absorbed into Liquid Web, hosting.com is A2 Hosting, Domain.com and Network Solutions share the same service).
6. Our own test results, if Jamil has accounts.
