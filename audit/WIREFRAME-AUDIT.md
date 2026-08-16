# Wireframe audit — 5 wireframes vs. static implementation

Scope: compare `wireframes/wireframe-1..5-*.html` against the built pages in
`spotlezz.vercel.app/`. WordPress is out of scope — this is a static-site,
wireframe-fidelity audit only. No implementation changes were made; this is
findings + a recommended homepage wireframe, per request.

Severity key: 🔴 blocking (breaks a stated goal or ships broken UX/SEO) ·
🟠 high (contradicts the wireframe or the project's own status docs) ·
🟡 medium (worth fixing, not urgent).

---

## 0. Site-wide build bug (🔴 — read this first)

`build/build.mjs`'s `applyChrome()` inserts the skip-link and the opening
`<main id="main">` unconditionally, without first stripping any that already
exist (`build/build.mjs:539-593`). It correctly removes old top-bar, header,
mobile-nav, sticky-CTA, next-hop and footer blocks before reinserting them —
but never touches a pre-existing `<main>` or skip-link. Every "existing"
page (the ones that keep hand-authored body content, per `README.md`) still
carries its own original `<main>` from before the build system existed. Each
time the chrome gets reapplied without a clean `git checkout -- spotlezz.vercel.app`
first, another skip-link + `<main>` stacks on top.

That has already happened in what's committed. Verified by counting
`<main id="main">` occurrences across the built output:

| Count | Pages affected |
| --- | --- |
| 5× | `index.html`, `diensten/index.html`, all 6 branch pillars (`kantoor-`, `hotel-`, `showroom-`, `fitnesscentrum-`, `kinderopvang-`, `vve-schoonmaak`), `klantcases/index.html` + all 3 cases, `over-ons/`, `contact/`, `blog/`, `checklist/`, `privacybeleid/`, `vacatures/` |
| 4× | `offerte-aanvragen/` |
| 1× (clean) | Every fully-templated new page: the 4 new dienst-pillars, all 8 `locaties/` pages, all `veelgestelde-vragen/` pages |

**18 of 37 pages** are affected. This is invalid HTML (multiple ARIA `main`
landmarks confuse screen readers) and, worse, on at least two pages it drags
a second copy of other chrome along with it:

- `diensten/kantoor-schoonmaak/index.html:794-807` has a **hand-built
  next-hop bar** sitting right next to the templated one at
  `:885-901` — two next-hop bars on one page.
- `klantcases/kobelco/index.html:368-384` vs. `:404-420` — same pattern.

This directly contradicts STATUS.md §7's claim that the last build was
checked "over alle 37 pagina's... overal precies één next-hop bar." That
check evidently didn't run clean, or didn't catch nested `<main>`s. Because
this undermines the reliability of every other "verified" claim in
STATUS.md, **fixing the build's idempotency and regenerating all pages is
the first thing that should happen**, before any content decisions below are
acted on — a fresh `npm run build` from a clean checkout should resolve most
of this automatically, but `applyChrome()` should also be made to strip any
pre-existing `<main>`/skip-link so it can't regress.

---

## 1. Homepage vs. `wireframe-5-homepage.html`

The homepage carries the bug above (5× duplicated chrome) plus these
content-level issues:

- 🔴 **All three "Bekijk Case" buttons in the case-studies section link to
  `/klantcases/kobelco/`** (lines 617, 626, 635) — KuchenTreff and Arena
  Gym's cards are copy-paste mislinked to Kobelco's page, even though both
  real case pages exist.
- 🔴 **The four "Wat we doen (dienst)" tiles are plain `<div>`s with no
  `href`** (lines 435-450) — Glasbewassing, Vloeronderhoud,
  Opleveringsschoonmaak and Hygiëneservice are not clickable. This is the
  opposite of what STATUS.md §2 claims ("de tegels linken erheen") and
  defeats the single change the wireframe calls "de grootste structurele
  winst" — connecting the new dienst-pillars into the site graph.
- 🟠 **Werkgebied pills are static `<span>`s, not links** (lines 718-725).
  Wireframe row 9 is explicit: "Elke pill linkt naar de locatiepagina." None
  currently do (the footer's location links work fine — this block doesn't).
- 🟠 **Thirza Mac Donald's photo is `/images/pand-interieur-schoon.jpg`** (an
  empty interior shot) used as her portrait, twice — in "Oprichter aan het
  woord" (line 686) and again in the Contact section (line 816). STATUS.md
  §4 claims this generic photo was "replaced by an initial avatar." On the
  homepage it wasn't — it's still a wrong photo standing in for a real
  person, which is precisely the EEAT problem STATUS.md flagged.
- 🟠 **Thirza's LinkedIn link is `href="https://linkedin.com"`** (line 690),
  the generic homepage, not a profile — contradicts `TE-CONTROLEREN.md` §4's
  claim that generic/placeholder LinkedIn links were removed everywhere.
- 🟠 **Two separate checklist CTAs on one page**: "Spotlezz Schoonmaak
  Checklist" mid-page (`checklist-cta-section`, line 499) and "De
  Spotlezz-check" near the bottom (`lead-magnet-section`, line 878) — same
  offer, same destination, twice. Wireframe row 11 specifies exactly one
  soft-conversion block.
- 🟡 **The 94%-contract-renewal stat appears twice**: once in the antwoordblok
  trust-bar (line 381) and again in the undocumented "Clean Kwaliteit"
  section (line 658).
- 🟡 **Undocumented sections not in wireframe-5 at all**: the "Us vs Them"
  comparison table (belongs to wireframe-1's pillar spec, not the homepage),
  a client-logo ticker, a "Clean Kwaliteit" stats block, and a full embedded
  contact form + repeated Thirza bio near the bottom. None are wrong to
  *have*, but none were speced for the homepage, and the embedded contact
  form duplicates `/contact/`'s entire purpose on a page that's supposed to
  be merch-plus-dienst, not a second contact page.
- 🟡 The wireframe's hero (row 2) specifies a split layout with "Foto eigen
  team op locatie" next to the H1. The shipped hero is a full-bleed
  background image with no team photo and a "chat widget" pill avatar that
  reuses the same interior shot as Thirza's portrait. Worth an explicit
  decision either way, not a silent drift.
- ✅ H1 ("Schoonmaakbedrijf in Almere") and H2 ("Schoon. Schoner.
  Spotlezz.") correctly match the wireframe's core SEO instruction. JSON-LD
  (`Organization`+`CleaningService`, `Person` for Thirza, `WebSite`,
  `FAQPage` matching the 5 visible questions 1:1, `AggregateRating`) is
  solid and matches the wireframe footer's schema list.

## 2. Dienst detail / pillar vs. `wireframe-1-dienst-detail.html`

Checked: `diensten/kantoor-schoonmaak/` (existing branch) and
`diensten/glasbewassing/` (new specialism).

- 🔴 Same build-duplication bug as above, plus the duplicate next-hop bar
  noted in §0.
- 🔴 **Klantcase block (row 9) references a case that doesn't exist.** The
  second card is titled "Schone bureaus bij **Kersvers**" — but only
  `kobelco`, `kuchentreff` and `arena-gym` exist under `/klantcases/`. This
  is a phantom link/404 risk, not just a "generic" link.
- 🟠 Both case cards on kantoor-schoonmaak actually link to the generic
  `/klantcases/` hub rather than to specific case pages — doesn't fulfill
  the wireframe's "elke case linkt door naar de volledige casepagina."
- 🟠 **Medewerker-aan-het-woord has no `Person` schema anywhere** in either
  page's JSON-LD `@graph` — only Thirza (founder) gets one. The wireframe
  explicitly tags this row EEAT + Schema. On kantoor-schoonmaak the avatar
  initial is also wrong: `<span class="person-avatar">S</span>` next to the
  name "Thomas Jansen." On glasbewassing, "Ramon de Vries" is named on-page
  but likewise absent from schema.
- 🟡 Regio pills are inconsistently wired: Almere-area pills are real
  `<a>` links, but Lelystad, Amsterdam and Amersfoort render as dead
  `<span class="pill">`s with no `href` — the wireframe requires every pill
  to link out.

## 3. Klantcase vs. `wireframe-2-klantcase.html`

Checked: `klantcases/kobelco/`.

- 🔴 Same build-duplication + duplicate next-hop bug.
- 🟠 **"Gebruikte diensten" (row 6) mostly doesn't link up to pillars.**
  Only "Kantoorschoonmaak" points to its real page; "Glasbewassing" and
  "Hygieneservice" both dead-end at the generic `/diensten/` hub. The
  wireframe's whole point for this row — "de case geeft linkwaarde door aan
  de pillars" — only works for one of three services shown.
- 🟠 **H1/schema mismatch.** The visible H1 is the generic "Schoonmaak voor
  Kobelco," while the JSON-LD `Article.headline` is the much stronger "Nul
  klachten in achttien maanden bij Kobelco in Almere." Wireframe row 2 is
  explicit that the H1 itself should be a result-sentence, "niet als
  klantnaam alleen" — the visible copy fails that even though the
  structured data gets it right. These two should say the same thing.
- 🟡 The feitenbalk (4 hard numbers — row 3) is actually populated on
  Kobelco (4.500 m², 5x/week, 100% eco, 0 klachten), which contradicts
  STATUS.md's claim that this block is still unfilled across all three
  cases. Worth re-checking KuchenTreff and Arena Gym individually — the
  status of this may not be uniform across the three cases.

## 4. FAQ hub + detail vs. `wireframe-3-faq.html`

Checked: `veelgestelde-vragen/` hub and
`veelgestelde-vragen/wat-bepaalt-de-prijs-van-schoonmaak/`.

- ✅ The hub is structurally clean — single `<main>`, no duplication,
  working search input, themed grouping, no obvious breakage.
- 🔴 **The conversion block on the detail page matches neither wireframe
  variant**, despite STATUS.md §Wireframe 3 explicitly stating "Variant A is
  gekozen" (an e-mail-magnet calculator: m² + frequentie + branche →
  indicative price by e-mail). What's actually there is a generic
  naam/bedrijf/e-mail/telefoon contact form with no m²/frequency capture and
  no "indicatie per mail" mechanic at all. It's not variant A, not variant
  B — it's a plain lead form mislabeled in the documentation as the chosen
  variant. This is the clearest documentation-vs-shipped-page contradiction
  found in the audit and needs an actual decision + build, not a doc fix.
- 🟡 The prijsfactoren grid (row 4) renders as a single-column list rather
  than the wireframe's two rows of 3-column tiles — a scanability
  regression, not a content gap.
- ✅ Next-hop bar is correctly singular with exactly 3 routes.

## 5. Locatiepagina vs. `wireframe-4-locatiepagina.html`

Checked: `locaties/almere/` (flagship) and `locaties/amersfoort/` (flagged
by STATUS.md as lacking local proof).

This is the **cleanest template of the four** — no build-duplication bug,
single next-hop bar on both pages checked. But:

- 🔴 **The "lokaal bewijs" block (row 4) — the one the wireframe calls "dit
  blok maakt of breekt de pagina" — is missing its required 6-client-logo
  grid entirely, on Almere too, not only on the pages STATUS.md flagged as
  risky.** Only a single case card and a single review remain. If the
  flagship location page doesn't clear this bar, none of the others will
  either.
- 🔴 **Mojibake in the local review block, not mentioned anywhere in
  STATUS.md.** Star ratings render as `â˜…â˜…â˜…â˜…â˜…` instead of `★★★★★` — a
  UTF-8 encoding break — identically on `locaties/almere/index.html:416`
  and `locaties/amersfoort/index.html:416`. This is a build/encoding
  regression that likely touches every location page's review block and is
  worth grepping for site-wide before launch.
- 🟠 **Amersfoort's borrowed local proof is worse than documented.**
  STATUS.md §6 describes it as "de review en de case op die pagina's komen
  uit een andere plaats" — true, but understates it: the Amersfoort page
  carries a **byte-for-byte duplicate** of Almere's Kobelco case and the
  exact same review body text ("Sinds Spotlezz bij ons de
  kantoorschoonmaak verzorgt...") with only the reviewer's city label
  hand-edited from "Almere" to "Amersfoort." That's not thin content, it's a
  fabricated local attribution — a materially bigger risk than "borrowed
  proof" suggests, and one Google's spam systems specifically target.

---

## Cross-cutting takeaways

1. **The build's idempotency bug is the single highest-priority fix.** It's
   silently corrupted 18 of 37 pages and makes STATUS.md's "verified"
   closing claims unreliable. Nothing else here can be confidently signed
   off until a clean rebuild is confirmed main-tag-clean across the site.
2. **Three places where the internal link graph promised by the wireframes
   doesn't exist yet**: homepage dienst tiles, homepage/pillar-page location
   pills, and case→pillar links on both the pillar and the case page. Every
   one of the wireframes' "why" notes for these rows is about link equity
   flowing between the branche/dienst/locatie axes — right now a meaningful
   chunk of that graph is dead ends.
3. **Documentation and shipped pages have already diverged in two
   material ways** (the FAQ conversion-block variant, and the "avatar
   replaced" / "LinkedIn removed" claims for Thirza on the homepage). Worth
   treating STATUS.md as a snapshot of intent rather than a verified
   ledger going forward, and re-checking its claims against the actual
   pages before the next status update.
4. **Locatiepagina is the strongest template**, dienst-detail and klantcase
   are the weakest (both still carry the old hand-authored duplication),
   and the homepage sits in between — its content is mostly right, its
   link-wiring isn't.
