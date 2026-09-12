# Spotlezz WordPress theme — SEO fix brief

Self-contained brief. Everything below was measured on the live dev environment
(`spotlezz.freedev.app`) on 4 September 2026 and verified against the theme
source on branch `fix/wireframe-implementatie`.

Theme lives at `wordpress-theme/spotlezz/`.

**Context you need:** this is a Dutch B2B commercial cleaning company. The single
most important ranking target for the whole project is "schoonmaakbedrijf Almere"
(590 searches/month). The site is currently on `noindex, nofollow` because it is
a staging environment.

---

## What is already correct — do not "fix" these

Verify before changing anything in these areas; they are deliberate.

- **The theme renders no `<title>`, meta description, canonical or Open Graph.**
  This is by design and documented in `inc/seo-yoast.php`. It delegates to Yoast.
  Do **not** add these to the theme.
- **Location pages are genuinely unique.** Measured 3–5% text similarity between
  Almere, Amsterdam and Amersfoort with city names masked. Do not templatise them.
- **The `locatie` post type is hierarchical** (`/locaties/almere/almere-buiten/`).
  Intentional.
- **H1s carry the keyword** ("Schoonmaakbedrijf Almere Buiten"). Correct.
- **The schema graph is well built:** Organization + CleaningService, WebSite,
  BreadcrumbList, Review, FAQPage, LocalBusiness + CleaningService with
  `areaServed` and `parentOrganization`.
- No dead links, no empty sections, alt text largely present.

---

## Task 1 — Install and configure Yoast SEO (highest impact)

**Problem.** Measured across 12 pages: 0 have a meta description, 0 have any
Open Graph tag, and 4 archive pages have no canonical. Title tags fall back to
the raw post title, so the homepage `<title>` is literally `Spotlezz` (8
characters) and a location page is `Almere Buiten – Spotlezz` while its H1 is
`Schoonmaakbedrijf Almere Buiten`.

**Cause.** The theme deliberately delegates all of this to Yoast
(`inc/seo-yoast.php`), and Yoast is not installed. The compatibility layer is
already written and waiting.

**Do this.**

1. Install and activate Yoast SEO (free is sufficient).
2. Under SEO → Search Appearance, set title templates per post type:

| Post type | Title template |
| --- | --- |
| Homepage | `Schoonmaakbedrijf in Almere voor kantoren, hotels en VvE %%sep%% %%sitename%%` |
| `locatie` | `Schoonmaakbedrijf %%title%% %%sep%% %%sitename%%` |
| `pillar` (dienst) | `%%title%% in Almere, Lelystad en Amsterdam %%sep%% %%sitename%%` |
| `case` | `Klantcase %%title%% %%sep%% %%sitename%%` |
| `vraag` (FAQ) | `%%title%% %%sep%% %%sitename%%` |

3. Set a default OG image (1200×630) under Social.
4. Write meta descriptions for the homepage, the four hubs and the three primary
   location pages. The rest can use a template initially.

**Watch out for this.** `inc/seo-yoast.php` disables the theme's own
Organization and BreadcrumbList schema nodes as soon as `WPSEO_VERSION` is
defined, because Yoast emits its own. Confirm after activation that the
following still appear in the graph, since Yoast does not produce them
automatically:

- `identifier` with the KVK number
- `areaServed` on the per-location LocalBusiness node
- `parentOrganization` linking location → organisation

Run the homepage and `/locaties/almere/` through Google's Rich Results Test
before and after, and diff the output. If Yoast's Organization node drops the
KVK or `areaServed`, keep the theme's node instead by filtering
`spotlezz_schema_output_organization` back to `true`.

**Done when:** every page has a unique title under 60 characters, a meta
description, an `og:image`, and a canonical — archives included.

---

## Task 2 — Fix the business address (needs a client answer first)

**Problem.** The `Organization` node currently outputs:

```json
"address": {
  "streetAddress": "Spinnakerplantsoen 38",
  "postalCode": "1319 DG",
  "addressLocality": "Amsterdam"
}
```

Street and postcode are the Almere address. Postcode 1319 is Almere. The city
says Amsterdam. This mixed state is on every page of the site.

**This is not an oversight.** `inc/site-options.php` (around lines 121–140)
documents it: the client said they moved to Amsterdam, but never supplied the
new street and postcode, so only the city was changed.

**Do this.** Ask the client one question: are you actually at an Amsterdam
address, and if so what is the street and postcode? Then:

- If Amsterdam is correct → fill in the real street and postcode.
- If they are still in Almere → set `address_city` back to `Almere`.

Either way, copy the values character-for-character from the Google Business
Profile. A NAP that differs from the profile costs local visibility, and local
visibility is the entire point of this project.

Values live in `inc/site-options.php` as the defaults for `address_street`,
`address_postcode` and `address_city`. They are consumed by
`spotlezz_schema_organization()` in `inc/schema.php`.

**Done when:** the address in the schema, in the visible NAP block and in the
Google Business Profile are identical, and the postcode matches the city.

---

## Task 3 — Add `reviewRating` to Review nodes

**Problem.** The three `Review` nodes have `reviewBody`, `author` and
`itemReviewed` but no `reviewRating`. A Review without a rating is invalid for
rich results, so these are currently ignored.

Secondary: `author` is emitted as `{"@type": "Person", "name": "Kobelco"}`.
Kobelco is a company, so this should be `Organization`.

**Do this** in `inc/schema.php`:

- Add `reviewRating` with `@type: Rating`, `ratingValue`, `bestRating: 5`,
  `worstRating: 1`. Source the value from the review data rather than
  hardcoding 5.
- Choose the author `@type` based on whether the reviewer is a person or a
  company. If the data does not distinguish, add a field for it rather than
  guessing.

**Done when:** the Rich Results Test reports the Review nodes as valid.

---

## Task 4 — Give images intrinsic dimensions

**Problem.** 48 of 51 images on the homepage have no `width`/`height`
attributes; 15 of 18 on `/reviews/`, 8 of 11 on `/over-ons/`. This causes layout
shift and counts against Core Web Vitals.

**Cause.** The theme contains 37 hand-written `<img>` tags across 10 template
files and zero calls to `wp_get_attachment_image()`.

**Do this.** Replace the hand-written tags with `wp_get_attachment_image()`,
which emits `width`, `height`, `srcset`, `sizes` and `loading` automatically.
Affected files:

```
front-page.php          single-locatie.php      page-over-ons.php
single-pillar.php       single-case.php         page-reviews.php
archive-pillar.php      archive-case.php        page-checklist.php
inc/components.php
```

Keep the existing alt text; it is mostly good. Seven images on the homepage have
no alt attribute at all — fill those in while you are there.

**Done when:** every `<img>` on the front end has `width` and `height`, and
below-the-fold images have `loading="lazy"`.

---

## Task 5 — Launch checklist

- Remove `noindex` (see `inc/publish-gate.php`, which filters `wpseo_robots`
  once Yoast is active). Verify with a live fetch that the tag is gone.
- Confirm a sitemap is served. `/wp-sitemap.xml` and `/sitemap_index.xml` both
  return 404 today; Yoast will provide one at `/sitemap_index.xml`.
- Reference the sitemap from `robots.txt`.
- Register the property in Google Search Console and submit the sitemap.

---

## Open decision, not a bug

URLs are currently `/locaties/almere/` and `/locaties/almere/almere-buiten/`.
The agreed SEO architecture specifies `/locaties/schoonmaakbedrijf-almere/` and
`/locaties/schoonmaakbedrijf-almere/almere-buiten/`, where the slug carries the
keyword.

Nothing is indexed yet, so changing this today costs nothing. After launch it
costs redirects on exactly the pages the project is built to rank. Decide before
go-live. See `SEO-ARCHITECTUUR-GAP.md`.

---

## Suggested order

1. Task 2 question to the client (blocks nothing, longest lead time)
2. Task 1 Yoast (resolves the largest number of issues)
3. Task 3 and 4 (independent of the Yoast decision, can run in parallel)
4. URL decision
5. Task 5 at go-live
