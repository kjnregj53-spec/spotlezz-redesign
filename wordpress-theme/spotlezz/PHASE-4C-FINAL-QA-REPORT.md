# Fase 4C — Finale volledige QA + homepage-regressiecheck

Deze check dekt alle 9 templates die in fase 4C gebouwd zijn (5
single-templates + 4 hub-templates), plus een gerichte regressiecontrole
van de bevroren fase-4B-homepage, in één samenhangende pass — bovenop de
per-stap-QA die na Publish-gate, Pillar, Case, Locatie, FAQ en
Hub-templates al apart is gerapporteerd en goedgekeurd.

## 1. Volledige lint — hele theme

- **PHP**: 34/34 bestanden, `php -l`, **0 fouten**
- **JS**: `assets/js/theme.js`, `node --check`, **geldig**

## 2. Structuursweep — alle 9 templates in één pass

| Template | Status | `<main>` | next-hop bar | schema `<script>` | noindex-tag |
| --- | --- | --- | --- | --- | --- |
| Homepage (`front-page.php`) | 200 | 1 | 1 | 1 | — |
| Pillar (`single-pillar.php`) | 200 | 1 | 1 | 1 | — |
| Case (`single-case.php`) | 200 | 1 | 1 | 1 | — |
| Locatie — Almere, ≥3 bewijs (`single-locatie.php`) | 200 | 1 | 1 | 1 | afwezig (indexeerbaar, correct) |
| Locatie — Lelystad, <3 bewijs | 200 | 1 | 1 | 1 | **aanwezig** (noindex, correct) |
| FAQ-detail (`single-vraag.php`) | 200 | 1 | 1 | 1 | — |
| Diensten-hub (`archive-pillar.php`) | 200 | 1 | 1 | 1 | — |
| Klantcases-hub (`archive-case.php`) | 200 | 1 | 1 | 1 | — |
| Locaties-hub (`archive-locatie.php`) | 200 | 1 | 1 | 1 | — |
| FAQ-hub (`archive-vraag.php`) | 200 | 1 | 1 | 1 | — |

Alle 10 rijen (9 templates + de tweede locatie-testcase) exact zoals
vereist: nooit 0 of 2+ van iets dat precies 1 moet zijn, en de noindex-gate
onderscheidt de twee locatiepagina's correct op basis van echt bewijs.

## 3. Schema — types en `@id`-uniciteit per pagina

Geëxtraheerd en machinaal gecontroleerd (geen duplicate `@id`'s binnen één
`@graph`, geen aannames):

| Pagina | Schema-types aanwezig | Dubbele `@id`'s |
| --- | --- | --- |
| Homepage | Organization+CleaningService, WebSite, FAQPage | geen |
| Pillar | + BreadcrumbList, FAQPage, **Service** | geen |
| Case | + BreadcrumbList, **Person, Review, Organization (klant), Article** | geen |
| Locatie | + BreadcrumbList, **Review, Person, FAQPage, LocalBusiness+CleaningService** | geen |
| FAQ-detail | + BreadcrumbList, **QAPage** | geen |
| FAQ-hub | + BreadcrumbList, **FAQPage** | geen |
| Overige 3 hubs | Organization+CleaningService, WebSite, BreadcrumbList | geen |

Elke paginatype-specifieke node die in de losse stap-rapporten beloofd is
(Service op pillar, Article/Review/Person/Organization op case,
LocalBusiness/Review/Person/FAQPage op locatie, QAPage op FAQ-detail,
FAQPage op de FAQ-hub) staat er ook echt — dit is de eerste keer dat alle
negen templates in één pass tegelijk gecontroleerd zijn, niet alleen los
per stap.

## 4. Linkintegriteit — alle interne links op alle 9 templates

57 unieke interne links geëxtraheerd uit alle negen pagina's en elk met
een HEAD-request gecontroleerd. **47 daadwerkelijke contentlinks: allemaal
200/301/302.** De overige 10 "gebroken" resultaten zijn WordPress-kern se
eigen automatisch gegenereerde oEmbed-discovery-`<link>`-tags in `<head>`
(niet uit theme-templates, niet zichtbaar/klikbaar voor bezoekers) — een
bekende WP-kern-eigenaardigheid bij een kale HEAD-request zonder de juiste
headers, geen echte kapotte link.

## 5. Viewport-overflow — alle 9 templates, alle 3 breekpunten

| Template | 390px | 430px | 1440px |
| --- | --- | --- | --- |
| Homepage | PASS | PASS | PASS |
| Pillar | PASS | PASS | PASS |
| Case | PASS | PASS | PASS |
| Locatie | PASS | PASS | PASS |
| FAQ-detail | PASS | PASS | PASS |
| Diensten-hub | PASS | PASS | PASS |
| Klantcases-hub | PASS | PASS | PASS |
| Locaties-hub | PASS | PASS | PASS |
| FAQ-hub | PASS | PASS | PASS |

27/27 metingen: `scrollWidth` exact gelijk aan `clientWidth` (of exact
verklaard door de scrollbar-breedte bij 1440px). Nul horizontale overflow,
nergens.

## 6. Homepage-regressie — gerichte herhaalcontrole

De homepage is tweemaal aangeraakt in fase 4C (reviews/FAQ-extractie naar
gedeelde componenten in de Pillar-stap, en de `wp_head`→`wp_footer`-
schemafix die ook de homepage raakte). Beide keren al apart goedgekeurd,
hier nogmaals bevestigd in dezelfde pass als de rest:

- 1 `<main>`, 1 next-hop bar, 1 schema-`<script>`, 0 dubbele `@id`'s
- Review-badge nog aanwezig en gevuld (topbar)
- **Mobiel menu opnieuw klik-getest** (niet aangenomen): open-knop
  ingedrukt → menu zichtbaar + `aria-expanded="true"`; sluit-knop
  ingedrukt → menu weer verborgen + `aria-expanded="false"`
- 0 overflow op 390/430/1440px

Geen regressie gevonden.

## Samenvatting

| Categorie | Resultaat |
| --- | --- |
| PHP-lint | PASS (34/34) |
| JS-syntax | PASS |
| Structuur (main/next-hop/schema-script) | PASS (10/10 gecontroleerde pagina's) |
| Noindex-gate, met echt tegengesteld bewijs | PASS |
| Schema-types + geen dubbele `@id`'s | PASS (9/9 templates) |
| Linkintegriteit | PASS (47/47 echte contentlinks) |
| Viewport-overflow | PASS (27/27 metingen) |
| Homepage-regressie | PASS, inclusief herhaald klik-getest mobiel menu |

**Geen openstaande bugs.** Fase 4C is hiermee volledig afgerond: Pillar,
Case, Locatie, FAQ (detail + hub) en de vier hub-templates zijn gebouwd,
elk apart gevalideerd en gerapporteerd, en nu ook gezamenlijk
gecontroleerd op onderlinge regressie — inclusief de bevroren fase-4B-
homepage, die intact blijft.

## Screenshot

- `local-preview/screenshots/final-homepage-regression-1440.png` —
  homepage, 1440px, na alle fase-4C-wijzigingen.

## Openstaande, bewust uitgestelde punten (geen bugs, wel te plannen)

Overgenomen uit `PHASE-4C-PLAN.md §7`, nog steeds van toepassing:

1. **Contentvolume**: 10 pillars + 8 locaties + 3 cases + 25+ vragen
   moeten nog met echte, door de klant aangeleverde content gevuld worden
   — dat is nu structureel mogelijk (alle velden bestaan en zijn getest),
   maar is redactioneel werk, geen bouwwerk.
2. **Variant-A-verzendlaag**: het FAQ-conversieblok is bewust alleen
   visueel (beslissing 5). Een echte POST/e-mail-verzendlaag is een
   aparte, later te plannen stap.
3. **Echte fotografie**: alle afbeeldingen in deze preview zijn
   gegenereerde placeholders, zoals steeds afgesproken — nooit als
   verzonnen echte productfoto's gepresenteerd.
