# Fase 4C — FAQ-detail: validatierapport

## Bestanden gewijzigd

| Bestand | Wat |
| --- | --- |
| `inc/acf-vraag.php` | **nieuw** — FAQ-detail-veldgroep, 3 tabs, 11 velden, 1 relationship |
| `single-vraag.php` | **volledig vervangen** (was de 4A-stub) — rijen 1, 3, 4, 5, 6 |
| `inc/components.php` | `spotlezz_conversion_variant_a()` toegevoegd — het vaste Variant-A-conversieblok, **visueel, geen echte verzending** (zie hieronder) |
| `functions.php` | `inc/acf-vraag.php` geregistreerd |
| `assets/css/theme.css` | FAQ-detail-secties toegevoegd (~55 regels) |

Geen enkele aanraking van `front-page.php`, `single-pillar.php`,
`single-case.php`, `single-locatie.php` of hun ACF-bestanden.
`archive-vraag.php` (de hub) is **nog niet** gebouwd — dat is de volgende
stap volgens de afgesproken volgorde (Hub-templates).

## Velden toegevoegd (`inc/acf-vraag.php`, 11 velden, 3 tabs)

- **Kort antwoord**: `kort_antwoord` (apart veld, PHASE-4C-PLAN.md beslissing 4, APPROVED — niet het native excerpt hergebruikt, zodat de korte homepage/pillar/locatie-teaser en het uitgebreide detail-antwoord onafhankelijk van elkaar blijven)
- **Verdieping**: `verdieping` (wysiwyg, optioneel), `factor_1_label` … `factor_6_label` (optioneel, alleen voor de prijs-FAQ), `verdieping_foto`
- **Gerelateerde dienst**: `gerelateerde_pillar` (relationship → pillar, min 1 max 1 — "precies één, niet naar de hub of naar drie diensten")

Geen repeater, geen gallery.

## Secties geïmplementeerd (wireframe-3-faq-FINAL, detailpagina-rijen 1/3/4/5/6)

1. Nav/breadcrumb — geërfd van `header.php`, ongewijzigd (3 niveaus diep via `inc/breadcrumbs.php`, al aanwezig sinds 4A)
3. Het korte antwoord (apart, gemarkeerd blok met `&#9656;`-icoon)
4. Verdieping — **prijsfactoren renderen als 2 rijen van 3 tegels (CSS grid)**, niet als lijst; foto optioneel; hele sectie valt weg als zowel `verdieping` als alle factoren leeg zijn (getest, zie QA)
5. Conversieblok Variant A — visuele component (zie hieronder)
6. Next-hop bar (3 routes; "zijwaarts" wijst naar de exact één gekoppelde pillar)

Rij 2 (de hub-variant) hoort bij `archive-vraag.php`, niet bij dit
bestand — komt in de Hub-stap.

## Twee audit-bevindingen hier expliciet geadresseerd

- **Prijsfactoren als enkele kolom i.p.v. 2×3-grid** (kostte scanbaarheid volgens de audit): `factor-grid` is hier een CSS grid met `grid-template-columns: repeat(3, 1fr)` (2 kolommen op mobiel), nooit een lijst.
- **Variant A "gebouwd" in de documentatie maar in werkelijkheid een generiek contactformulier zonder m²/frequentie/branche-velden**: `spotlezz_conversion_variant_a()` heeft exact de drie velden uit het wireframe (m², frequentie, branche) plus e-mailadres — geen generiek naam/telefoon-formulier.

## Variant A: bewust alleen de visuele component (beslissing 5, APPROVED)

Zoals afgesproken bouwt deze fase **alleen het zichtbare formulier**, geen
werkende verzending — er bestaat nog geen `FORM_ENDPOINT`-laag in dit
theme. Concreet:
- Het `<form>`-element heeft bewust **geen `action`/`method`** en een
  `onsubmit="return false;"`, dus er wordt technisch niets verstuurd —
  geen stille halve implementatie die eruitziet alsof hij werkt.
- Voor ingelogde beheerders staat er een expliciete hint onder het
  formulier ("Verzendlaag volgt in een aparte stap") — dezelfde conventie
  als eerdere `content-placeholder`-hints in dit theme.
- **Klik-getest** (zie QA): velden ingevuld, op de submit-knop geklikt,
  bevestigd dat de URL/pagina niet verandert en dat er geen POST-request
  naar de pagina zelf vertrekt — het formulier is aantoonbaar inert, niet
  alleen in theorie.

## Schema toegevoegd

- `QAPage` op elke FAQ-detailpagina (regel uit het bouwplan: hub =
  `FAQPage`, detail = `QAPage`) — alleen als `kort_antwoord` gevuld is
- `BreadcrumbList` — al bestaand, 3 niveaus diep

## QA-resultaten

| # | Check | Resultaat |
| --- | --- | --- |
| 1 | PHP-lint | **PASS** — 30/30 bestanden |
| 2 | ACF-velddefinities in de admin | **PASS** — 3 tabs, 11 velden (1 textarea, 1 wysiwyg, 6 text, 1 image, 1 relationship), **0 repeaters, 0 galleries** |
| 3 | Relationship-selectie correct opgeslagen/gelezen | **PASS** — `gerelateerde_pillar` exact zoals ingevoerd |
| 4 | Factorengrid rendert als 2×3-grid, niet als lijst | **PASS** — 6 `.factor-tile`-elementen in een CSS grid |
| 5 | Verdieping-sectie valt correct weg zonder content | **PASS** — testvraag #30 (alleen kort antwoord, geen verdieping/factoren) toont 0× `.verdieping-block`, wél 1× `.kort-antwoord-block` |
| 6 | Variant A-formulier is aantoonbaar inert | **PASS** — velden ingevuld, submit-knop geklikt: URL/titel ongewijzigd, geen POST-request naar de pagina in de netwerklog |
| 7 | Alt-tekst op editable afbeeldingen | **PASS** — `spotlezz_image_alt()` hergebruikt voor `verdieping_foto` |
| 8 | Exact één `<main>` | **PASS** |
| 9 | Exact één next-hop bar, 3 routes | **PASS** — "zijwaarts" toont dynamisch de titel/URL van de gekoppelde pillar, niet de hub |
| 10 | 390px | **PASS** — `scrollWidth: 390`, 0 overflow |
| 11 | 430px | **PASS** — `scrollWidth: 430`, 0 overflow |
| 12 | 1440px | **PASS** — `scrollWidth: 1425` (= viewport − scrollbar), 0 overflow |
| 13 | QAPage-schema aanwezig | **PASS** — `"@type":"QAPage"` met `mainEntity.Question/acceptedAnswer`, exact 1 `<script>`-blok |
| 14 | Geen PHP-warnings/-notices/-fatals | **PASS** — volledige sessie gecontroleerd |
| 15 | Homepage-, pillar-, case-, locatie-regressie | **PASS** — alle vier nog steeds 1 `<main>` en 1 next-hop bar, geen fouten |

Geen nieuwe bugs gevonden tijdens deze stap.

## Screenshot

- `local-preview/screenshots/faq-desktop-1440.png` — prijs-FAQ-detailpagina
  (volledig gevuld, incl. verdieping en factorengrid), 1440px, met
  testcontent (duidelijk gemarkeerd `TEST —`).

## Geen verzonnen content

Alle testtekst gemarkeerd `TEST —`. Geen echte prijzen of beweringen die
als definitief bedrijfsfeit gelden — de testcijfers (25-35 euro/uur) zijn
duidelijk gelabeld als testdata, niet als echte Spotlezz-prijzen.

---

Klaar voor de **Hub-templates** (`archive-pillar.php`, `archive-case.php`,
`archive-locatie.php`, `archive-vraag.php`) zodra je akkoord geeft — de
laatste bouwstap vóór de finale volledige QA + homepage-regressiecheck.
