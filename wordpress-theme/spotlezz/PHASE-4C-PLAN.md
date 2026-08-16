# Fase 4C — plan (nog niet gebouwd, wacht op goedkeuring)

Scope: de vier resterende paginatypes — dienst-pillar, klantcase, locatie,
FAQ — plus hun hub-pagina's. Bron van waarheid:
`wireframe-1..4-*-FINAL.html` en `audit/WORDPRESS-BUILD-PLAN.md` §3.2–§3.5.
Fase 4B (homepage) is bevroren; niets in dit plan wijzigt
`front-page.php`, `inc/acf-homepage.php` of hun velden.

Vier plekken in dit plan vragen een keuze van jou voordat ik bouw — gemarkeerd
**BESLISSING NODIG**. De rest is een rechttoe-rechtaan toepassing van het
bouwplan plus de lessen uit fase 4B (ACF Free, geen repeaters/gallery,
relationship i.p.v. vrije tekst, geen `overflow-x:hidden`).

---

## 0. Wat fase 4B al veranderde aan de aannames van dit plan

`WORDPRESS-BUILD-PLAN.md` §3 dateert van vóór het "geen ACF Pro"-besluit.
Overal waar dat document "relationship" of een repeater voorstelt voor een
**vast aantal** items (werkzaamheden-raster, lokale klantlogo's,
prijsfactoren-verdieping), gebruikt dit plan in plaats daarvan hetzelfde
patroon als de homepage: losse, genummerde velden met een vast maximum.
Waar het bouwplan relationship voorstelt voor **variabele/herbruikbare**
content (klantcases, FAQ's, pillars) blijft relationship gewoon staan — dat
werkt al goed en kost niets extra.

---

## 1. Bestanden per paginatype

### 1.1 Dienst-pillar
| Bestand | Actie |
| --- | --- |
| `inc/acf-pillar.php` | **nieuw** — veldgroep voor CPT `pillar` |
| `single-pillar.php` | **vervangen** (nu de 4A-stub) — volledige sectie-opbouw |
| `archive-pillar.php` | **nieuw** — hub `/diensten/`, twee-assen-indeling (hergebruikt de branche/geen-branche-splitsing die al op de homepage staat) |
| `inc/publish-gate.php` | **wijzigen** (zie §7, blokkerende afhankelijkheid) |
| `assets/css/theme.css` | secties toevoegen: werkzaamheden-raster, werkwijze/vergelijkingstabel, medewerkerskaart (hergebruikt `.person-card` uit fase 4A) |

### 1.2 Klantcase
| Bestand | Actie |
| --- | --- |
| `inc/acf-case.php` | **nieuw** — veldgroep voor CPT `case` |
| `single-case.php` | **vervangen** (4A-stub, maar de H1/schema-headline-koppeling en de Article-schema-hook staan er al goed in — die blijven) |
| `archive-case.php` | **nieuw** — hub `/klantcases/` |
| `assets/css/theme.css` | secties: feitenbalk, STAR-blokken, klantquote-kaart |

### 1.3 Locatiepagina
| Bestand | Actie |
| --- | --- |
| `inc/acf-locatie.php` | **nieuw** — veldgroep voor CPT `locatie` |
| `single-locatie.php` | **vervangen** (4A-stub, de noindex-gate-aanroep blijft) |
| `archive-locatie.php` | **nieuw** — hub `/locaties/` |
| `inc/publish-gate.php` | **wijzigen** (zie §7, blokkerende afhankelijkheid) |
| `assets/css/theme.css` | secties: lokaal-bewijsblok, NAP (hergebruikt bestaande component), werkgebiedtekst |

### 1.4 FAQ
| Bestand | Actie |
| --- | --- |
| `inc/acf-vraag.php` | **nieuw** — veldgroep voor CPT `vraag` |
| `single-vraag.php` | **vervangen** (4A-stub) |
| `archive-vraag.php` | **nieuw** — hub `/veelgestelde-vragen/`, thema-groepering + zoekveld |
| `inc/components.php` | `spotlezz_conversion_variant_a()` toevoegen — het vaste Variant-A-blok (regel 13) |
| `assets/js/theme.js` | hub-zoekfilter (client-side) + submit-handler voor het Variant-A-formulier |
| `assets/css/theme.css` | secties: kort-antwoord-blok, prijsfactoren-grid, conversieblok |

### 1.5 Gedeeld
| Bestand | Actie |
| --- | --- |
| `functions.php` | de vier nieuwe `inc/acf-*.php`-bestanden registreren in `$spotlezz_includes` |
| `inc/schema.php` | geen structuurwijziging — bestaande `spotlezz_schema_graph`-filter en `spotlezz_schema_person()` worden per paginatype hergebruikt (zie §4) |
| `inc/components.php` | `spotlezz_stat_block()` en `spotlezz_person_card()` worden hergebruikt; nieuw: `spotlezz_fact_bar()` (feitenbalk/antwoordblok-varianten met vaste labels) |

**Niet aangeraakt:** `header.php`, `footer.php`, `front-page.php`,
`inc/acf-homepage.php`, `inc/site-options.php` (behalve mogelijk
uitbreiding met een gedeeld werkwijze/vergelijkingstabel-veld, zie
**BESLISSING 3**).

---

## 2. ACF-velden per paginatype (ACF Free — geen repeater, geen gallery, geen options page)

### 2.1 Pillar (`inc/acf-pillar.php`)
| Veld | Type | Notitie |
| --- | --- | --- |
| `hero_kicker`, `hero_h1`, `hero_intro` | tekst/textarea | H1 bevat zoekwoord + regio (redactioneel) |
| `usp_1`, `usp_2`, `usp_3` | tekst | de 3 pill-checkmarks in de hero |
| `answer_intro` | textarea | 40–60 woorden antwoordblok-tekst |
| `stat_frequentie_value/label`, `stat_reactietijd_value/label` | tekst | regio + prijs-tegel zijn **geen ACF** — regio komt uit Site Options, prijs is een vaste link naar de FAQ-prijspagina |
| `task_1_label` … `task_8_label` (8×) + `task_1_pillar` … `task_8_pillar` (8× relationship, optioneel, max 1) | tekst + relationship | werkzaamheden-raster, vast op 8 slots i.p.v. repeater |
| `photo_1/_caption` … `photo_3/_caption` | afbeelding + tekst | zelfde patroon als homepage |
| `medewerker_naam`, `_functie`, `_quote`, `_foto`, `_linkedin` | tekst/afbeelding/url | Person-schema via `spotlezz_person_card()`, leeg = geen kaart (regel 9) |
| `featured_cases` | relationship → `case`, min 2 max 2 | regel 7 |
| `featured_faqs` | relationship → `vraag`, min 5 max 8 | |
| `reviews_1..3_*` | zie **BESLISSING 1** | |

### 2.2 Case (`inc/acf-case.php`)
| Veld | Type | Notitie |
| --- | --- | --- |
| `logo` | afbeelding, **verplicht** | regel 11 — voorkomt de "LOGO Kobelco"-placeholder |
| `headline` | tekst | al gebruikt in `single-case.php` sinds fase 4A voor zowel H1 als `Article.headline` — nu pas echt registreren als veld |
| `branche`, `locatie`, `klant_sinds` | tekst | 3 hero-stats |
| `hero_foto` | afbeelding | |
| `feit_vloeroppervlak`, `feit_frequentie`, `feit_producten`, `feit_klachten` | tekst | de 4 harde cijfers, verplicht vóór publicatie (redactioneel afdwingbaar via `required`) |
| `star_situatie`, `star_uitdaging`, `star_aanpak`, `star_resultaat` | textarea | koppen zijn vast/hardcoded in het template, niet bewerkbaar |
| `quote_tekst`, `quote_naam`, `quote_functie`, `quote_foto`, `quote_linkedin` | tekst/afbeelding/url | Review-schema |
| `gebruikte_diensten` | relationship → `pillar`, min 1 max 3 | |

### 2.3 Locatie (`inc/acf-locatie.php`)
| Veld | Type | Notitie |
| --- | --- | --- |
| `kaart_afbeelding` | afbeelding | zie **BESLISSING 2** (kaart-implementatie) |
| `stat_reactietijd_value`, `stat_teams_value` | tekst | beoordelingen + prijs komen uit Site Options / vaste link |
| `logo_1` … `logo_6` | afbeelding (6×) | **vervangt** het in `inc/publish-gate.php` aangenomen repeater-veld `lokale_klantlogos` — zie §7 |
| `lokale_case` | relationship → `case`, max 1 | telt mee voor de bewijs-gate |
| `lokale_review_quote/_naam/_rol/_foto` | tekst/afbeelding | 1 lokale review (geen 3) |
| `diensten_top3` | relationship → `pillar`, min 3 max 3 | |
| `werkgebied_tekst` | wysiwyg | richtlijn 500+ woorden, redactioneel |
| `photo_1/_caption` … `photo_3/_caption` | afbeelding + tekst | |
| `lokaal_team_naam`, `_rol`, `_quote`, `_foto`, `_linkedin` | tekst/afbeelding/url | telt óók mee voor de bewijs-gate; naam al aangenomen door `inc/publish-gate.php` |
| `lokale_faqs` | relationship → `vraag`, min 3 max 5 | |

`areaServed`/wijken en "andere locaties" blijven **geen ACF** — automatisch
uit `post_parent`/alle overige `locatie`-posts, zelfde aanpak als het
werkgebiedblok op de homepage.

### 2.4 Vraag (`inc/acf-vraag.php`)
| Veld | Type | Notitie |
| --- | --- | --- |
| `kort_antwoord` | textarea | Het losstaande antwoordblok bovenaan (zie **BESLISSING 4** — apart veld i.p.v. het native excerpt hergebruiken) |
| `verdieping` | wysiwyg, optioneel | alleen gebruikt op de ~3 vragen met een eigen detailpagina |
| `factor_1_label` … `factor_6_label`, optioneel | tekst (6×) | prijsfactoren-grid, alleen gevuld op de prijs-FAQ |
| `verdieping_foto` | afbeelding, optioneel | |
| `gerelateerde_pillar` | relationship → `pillar`, min 1 max 1 | regel: "linkt omhoog naar precies één pillar, niet naar drie" |

Conversieblok (Variant A) is **geen ACF-veld** — vast theme-component, zie
§1.4 en **BESLISSING 5**.

---

## 3. Secties per paginatype (wireframe-rijen)

| Paginatype | Rijen die worden gebouwd |
| --- | --- |
| Pillar | 1 nav/breadcrumb (bestaat) · 2 hero+snelofferte · 3 antwoordblok · 4 werkzaamheden-raster · 5 werkwijze+vergelijkingstabel+CTA · 6 eigen foto's · 7 reviews · 8 medewerker · 9 klantcases (exact 2) · 10 regioblok (8 pills) · 11 FAQ (5–8) · 12 next-hop (bestaat) |
| Case | 1 nav/breadcrumb (bestaat) · 2 hero+feiten · 3 feitenbalk · 4 STAR · 5 klantquote · 6 gebruikte diensten · 7 next-hop (bestaat) |
| Locatie | 1 nav/breadcrumb (bestaat) · 2 hero+kaart+NAP · 3 antwoordblok · 4 lokaal bewijs · 5 diensten top-3 + wijken · 6 werkgebiedtekst · 7 eigen foto's · 8 lokaal team · 9 lokale FAQ · 10 locatie-carrousel · 11 next-hop (bestaat) |
| FAQ hub | zoekveld + thema-groepering (nieuw, `archive-vraag.php`) |
| FAQ detail | kort antwoord · verdieping (optioneel) · conversieblok (Variant A) · next-hop (bestaat) |

Next-hop bar op elk type: exact 3 routes via het bestaande, ongewijzigde
`spotlezz_next_hop()` — al correct bedraad in de 4A-stubs, blijft zo.

---

## 4. Schema per paginatype

Alles via de bestaande `spotlezz_schema_graph`-filter (fase 4A), dus geen
architectuurwijziging — alleen nieuwe hooks per template:

- **Pillar:** `Service` (naam, aanbieder=Organization, areaServed, link naar
  prijsfactoren i.p.v. `priceRange`), `Person` voor de medewerker via
  `spotlezz_person_card()`, `FAQPage` uit de 5–8 gekoppelde vragen (zelfde
  patroon als homepage).
- **Case:** `Article` (headline = `headline`-veld, al gebouwd in 4A),
  `Review` (quote-velden), `Person` voor de contactpersoon met
  `sameAs`=LinkedIn, `Organization` voor de klant zelf (naam uit posttitel).
- **Locatie:** `LocalBusiness`/`CleaningService` met `areaServed` = deze
  stad/wijk, `Person` voor het lokale team, `FAQPage` uit de lokale FAQ's,
  `AggregateRating` (hergebruikt Site Options, zelfde als homepage/pillar).
- **Vraag:** `QAPage` op elke detailpagina (regel uit het bouwplan: hub =
  `FAQPage`, detail = `QAPage`).

Yoast-dubbeling: dezelfde bewaking als fase 4A/4B — Organization/WebSite/
Breadcrumb blijven uitgeschakeld zodra Yoast actief is; de hierboven
genoemde paginatype-specifieke nodes zijn dat niet, want Yoast genereert ze
niet automatisch.

---

## 5. Relationships / interne links

Harde regel uit fase 3 (geen vrije tekst waar een relationship hoort):

| Van → naar | Veld | Type |
| --- | --- | --- |
| Pillar → 2 cases | `featured_cases` | relationship, dropdown toont alleen bestaande cases (repareert de "Kersvers"-bug uit de audit) |
| Pillar → 5–8 vragen | `featured_faqs` | relationship |
| Pillar → 8 locaties | **geen ACF**, automatisch | query, zelfde als homepage |
| Pillar → gerelateerde pillars | `task_N_pillar` (optioneel, per werkzaamheid-slot) | relationship |
| Case → 1–3 pillars | `gebruikte_diensten` | relationship (repareert de dead-link-naar-hub-bug uit de audit) |
| Locatie → 1 case | `lokale_case` | relationship |
| Locatie → 3 pillars | `diensten_top3` | relationship |
| Locatie → 3–5 vragen | `lokale_faqs` | relationship |
| Locatie → wijken/andere locaties | **geen ACF**, automatisch | `post_parent` resp. alle overige `locatie`-posts |
| Vraag → 1 pillar | `gerelateerde_pillar` | relationship |

Alle relationship-velden krijgen dezelfde defensieve check als op de
homepage: na ophalen filteren op `instanceof WP_Post && post_status ===
'publish'` vóór render.

---

## 6. QA-checks (per paginatype herhaald, zelfde discipline als 4A/4B)

1. PHP-lint op elk gewijzigd/nieuw bestand.
2. ACF-veldnamen in de admin-UI vergelijken met deze tabel (geen repeater-
   of gallery-UI aanwezig — check net als bij de homepage-veldgroep).
3. Alt-tekst op elke editable afbeelding (`spotlezz_image_alt()`/
   `spotlezz_post_thumbnail_alt()`, geen kale `<img>`).
4. Elke relationship lost op naar een bestaand, gepubliceerd object
   (dummy-testcontent per type aanmaken, zelfde aanpak als de
   fase-4B-preview: duidelijk gemarkeerd `TEST —`, geen verzonnen namen bij
   medewerker/team-velden — die blijven leeg tot bevestigd, net als de
   oprichter op de homepage).
5. Exact één `<main>`/header/footer — geërfd van `header.php`/`footer.php`,
   niet opnieuw te testen per type, wel één keer bevestigen dat de nieuwe
   templates niets extra's injecteren.
6. Exact één next-hop bar, exact 3 routes — per paginatype, 8 templates
   (4 detail + 4 hub) × geteld, niet aangenomen.
7. **Locatie-specifiek:** de noindex-gate opnieuw testen met de
   gecorrigeerde veldnamen (zie §7) — minimaal één testlocatie met <3
   bewijsvormen (moet noindex blijven) en één met ≥3 (moet indexeerbaar
   worden).
8. **Case-specifiek:** H1 en `Article.headline` komen uit hetzelfde veld —
   controleren dat er nergens per ongeluk een aparte titel ontstaat.
9. Horizontale overflow op 390/430/1440px — voor alle 8 nieuwe/vervangen
   templates. Gezien wat de vorige ronde kostte: elke sectie met vaste-
   breedte-aannames (`minmax()`-grids, flex-rijen met knoppen) krijgt
   `min-width:0` vanaf het begin, niet achteraf.
10. Klik-test: FAQ-hub zoekfilter, FAQ-accordion (al `<details>`-gebaseerd,
    geen JS nodig), het Variant-A-conversieformulier (submit-gedrag, zie
    **BESLISSING 5**).
11. Schema-validatie: geen dubbele nodes met hetzelfde `@id` (zoals de
    oprichter-bug uit fase 4B) — met name opletten bij `Person`-nodes:
    pillar-medewerker, locatie-team en case-contactpersoon moeten elk een
    eigen `id_suffix` krijgen, nooit dezelfde twee gebruiken.

---

## 7. Afhankelijkheden en risico's

1. **Blokkerend, moet eerst:** `inc/publish-gate.php` gaat uit van een
   repeater-veld `lokale_klantlogos` (`is_array($logos) && count >= 3`).
   Dat veldtype bestaat niet meer onder ACF Free. Vóór er één regel
   locatie-template gebouwd wordt, moet deze functie aangepast worden naar
   het `logo_1`…`logo_6`-patroon uit §2.3 — anders werkt de belangrijkste
   regel uit de hele wireframe-set ("dit blok maakt of breekt de pagina")
   niet.
2. **Contentvolume:** 10 pillars + 8 locaties + 3 cases + 25 vragen = 46
   posts die (deels) handmatig gevuld moeten worden zodra de velden
   bestaan. Dat is geen bouwwerk maar wel een reële vervolgstap die de
   klant moet inplannen — vergelijkbaar met de foto's.
3. **FAQ-conversieformulier (Variant A) is meer dan een template.** Er
   bestaat nu geen werkende formulier-submit-laag (alleen een
   `formEndpoint`-instelling zonder JS die hem gebruikt). Variant A bouwen
   betekent: een echt formulier (m² + frequentie + branche + e-mail) plus
   JS die het naar `FORM_ENDPOINT` stuurt of, zolang die leeg is, terugvalt
   op een mailto — zelfde patroon als de rest van de site al belooft.
   Groter dan de andere onderdelen van deze fase.
4. Geen van de bovenstaande wijzigingen raakt fase 4B; het risico op
   regressie op de homepage is daarmee laag, maar wordt sowieso
   meegenomen in de eindcontrole (homepage nogmaals laden na afloop, geen
   functionele wijziging verwacht).

---

## Beslissingen nodig vóór de bouw start

**BESLISSING 1 — reviews op pillar/locatie.** Zelfde vraag als bij de
homepage, nu voor 18 extra posts. Opties: (a) elke pillar/locatie krijgt
zijn eigen `reviews_1..3_*`-velden zoals de homepage — 18 posts × 12 velden
om te vullen; of (b) reviews worden een gedeeld blok in Site Options (3
velden-sets, één keer invullen, overal hergebruikt). (b) is minder
contentwerk maar wijkt af van het per-pagina-specifieke patroon dat de
homepage al zet. Advies: (b), tenzij per pillar/locatie echt andere reviews
gewenst zijn.

**BESLISSING 2 — kaart op de locatiepagina.** Een los afbeeldingsveld
(`kaart_afbeelding`, simpel, geen externe dependency) of een Google Maps
embed-URL (interactief, maar een externe iframe-dependency en een
cookie/privacy-afweging). Advies: afbeeldingsveld voor nu, embed kan later
als aparte, bewuste stap.

**BESLISSING 3 — werkwijze/vergelijkingstabel (pillar rij 5).** Het
bouwplan zegt expliciet "Site Options, niet per pillar" omdat de tekst nu
al overal identiek is. Zonder ACF Pro is er geen Options-Page-UI voor grote
WYSIWYG-blokken. Opties: (a) hardcoded in het template (theme-code, geen
CMS-veld — snelste, maar de klant kan de tekst dan niet zelf aanpassen
zonder een developer); (b) uitbreiden van de bestaande native
Site-Options-pagina (`inc/site-options.php`) met 4 stap-tekstvelden + een
paar vergelijkingstabel-regels, zelfde patroon als de NAP-velden daar nu al.
Advies: (b), voor consistentie met hoe de rest van de gedeelde content al
werkt.

**BESLISSING 4 — "kort antwoord" op de FAQ-detailpagina.** Los ACF-veld
(`kort_antwoord`, zoals in §2.4) of het bestaande native excerpt hergebruiken
(zoals de homepage nu al doet voor de FAQ-teasers)? Een apart veld voorkomt
dat een korte homepage-teaser en een uitgebreider detail-antwoord elkaar in
de weg zitten; hergebruik van excerpt is minder velden maar koppelt twee
dingen die soms anders lang moeten zijn. Advies: apart veld (zoals nu
opgenomen in §2.4).

**BESLISSING 5 — omvang van het Variant-A-formulier in deze fase.** Volledig
bouwen inclusief werkende verzending (zie risico 3), of eerst alleen de
visuele component (velden, styling, geen echte backend-verzending) en de
verzendlaag in een aparte, latere stap? Advies: visuele component nu,
verzendlaag apart — dat is een groter, apart te toetsen stuk werk
(endpoint-configuratie, foutafhandeling) dat niet moet vastzitten aan de
rest van fase 4C.

---

Wacht op jouw akkoord op de vier beslissingen (of jouw eigen keuzes) en op
dit plan als geheel voordat er code wordt geschreven.
