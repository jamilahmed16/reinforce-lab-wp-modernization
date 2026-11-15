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
