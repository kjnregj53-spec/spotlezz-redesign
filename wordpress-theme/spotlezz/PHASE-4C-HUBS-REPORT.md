# Fase 4C — Hub-templates: validatierapport

## Bestanden gewijzigd

| Bestand | Wat |
| --- | --- |
| `archive-pillar.php` | **nieuw** — `/diensten/`, twee-assen-indeling (branche/dienst) |
| `archive-case.php` | **nieuw** — `/klantcases/`, kaartenlijst |
| `archive-locatie.php` | **nieuw** — `/locaties/`, alleen hoofdlocaties (`post_parent = 0`) |
| `archive-vraag.php` | **nieuw** — `/veelgestelde-vragen/`, thema-groepering + zoekveld |
| `assets/js/theme.js` | FAQ-hub-zoekfilter toegevoegd (client-side, tweede losse `ready()`-blok, mobiel-menu-logica ongewijzigd) |
| `assets/css/theme.css` | hub-secties toegevoegd (~30 regels) — bewust vrijwel volledig hergebruik van bestaande classes (`.services-grid`/`.service-tile`, `.cases-grid`/`.case-card`, `.faq-list`/`.faq-item`), alleen echt nieuwe stijl voor `.hub-page-header`, `.faq-search`, `.faq-theme-pills`, `.faq-theme-group` |

Geen van deze bestanden raakt `front-page.php` of een van de vier
single-*.php-templates. `archive-pillar.php` bouwt zijn eigen kopie van de
twee-assen-query i.p.v. de homepage aan te roepen — bewust, om het
bevroren bestand niet nogmaals aan te raken voor een hub die dat niet
nodig heeft.

## Secties per hub

- **`archive-pillar.php`**: titel + twee-assen-grid (identieke query/onderscheid als de homepage: branche-taxonomie aanwezig → "Voor wie", afwezig → "Wat we doen"), next-hop (omhoog: home, zijwaarts: klantcases, conversie: offerte)
- **`archive-case.php`**: titel + kaartenlijst (thumbnail, titel, excerpt — zelfde markup als het klantcases-blok op de homepage), next-hop (omhoog: diensten, zijwaarts: locaties, conversie: offerte)
- **`archive-locatie.php`**: titel + tegelraster, **uitsluitend hoofdlocaties** (wijken blijven exclusief bereikbaar via hun stad-pagina, rij 5 van `single-locatie.php` — geen dubbele/verwarrende losse wijk-vermelding in de hub), next-hop (omhoog: diensten, zijwaarts: klantcases, conversie: offerte)
- **`archive-vraag.php`**: titel + zoekveld + thema-pills (anker-navigatie) + per-thema-groep een accordion-lijst (vragen zonder thema-term vallen in een "Overig"-groep, geen stille content-loss), next-hop (omhoog: home, zijwaarts: diensten, conversie: offerte op maat)

## Schema

- `FAQPage` op de hub (`archive-vraag.php`), samengesteld uit alle
  zichtbare vraag/antwoord-paren — bevestigt het onderscheid met de
  detailpagina's die elk hun eigen `QAPage` hebben (fase FAQ-stap)
- De andere drie hubs voegen bewust geen extra schema-node toe — dat
  hoort bij de individuele posts, niet bij de listing zelf, conform het
  bouwplan

## QA-resultaten

| # | Check | Resultaat |
| --- | --- | --- |
| 1 | PHP-lint | **PASS** — 34/34 bestanden |
| 2 | JS-syntax (`node --check`) | **PASS** |
| 3 | Exact één `<main>` — alle 4 hubs | **PASS** |
| 4 | Exact één next-hop bar, 3 routes — alle 4 hubs | **PASS** |
| 5 | Twee-assen-indeling op `archive-pillar.php` | **PASS** — 6 branche-pillars onder "Voor wie", 4 dienst-pillars onder "Wat we doen", identiek aantal en indeling als op de bevroren homepage |
| 6 | `archive-locatie.php` toont alleen hoofdlocaties | **PASS** — 4 tegels (Almere, Amersfoort, Amsterdam, Lelystad), de 4 Almere-wijken correct **niet** los in de hub |
| 7 | Thema-groepering op `archive-vraag.php` | **PASS** — 4 thema-groepen (Contract, Kosten, Kwaliteit, Werkwijze) + correcte "→ volledig antwoord"-link alleen bij de 2 vragen met een eigen `kort_antwoord` (detailpagina), "+"-icoon bij de rest |
| 8 | Zoekfilter — daadwerkelijk getest, niet aangenomen | **PASS** — zoekterm "opzegtermijn" ingevoerd: 1 vraag zichtbaar, de 3 andere thema-groepen verbergen zichzelf automatisch (0 zichtbare items); "Alles"-knop getest: reset veld en toont alle groepen weer |
| 9 | FAQPage-schema op de hub | **PASS** — `"@type":"FAQPage"` met alle zichtbare vraag/antwoord-paren, exact 1 `<script>`-blok |
| 10 | 390px — alle 4 hubs | **PASS** — `scrollWidth` = `clientWidth` op elke hub, 0 overflow |
| 11 | 430px / 1440px (FAQ-hub, meest complexe template) | **PASS** — 0 overflow op beide |
| 12 | Geen PHP-warnings/-notices/-fatals | **PASS** — volledige sessie gecontroleerd |
| 13 | Regressie: homepage, pillar, case, locatie, FAQ-detail (alle 5 single-templates) | **PASS** — allemaal nog steeds 1 `<main>` en 1 next-hop bar, geen fouten |

Geen nieuwe bugs gevonden tijdens deze stap.

## Screenshot

- `local-preview/screenshots/faq-hub-desktop-1440.png` — FAQ-hub met 4
  gevulde thema-groepen, zoekveld en pills, 1440px, testcontent
  (`TEST —`).

## Geen verzonnen content

Om de thema-groepering en de zoekfilter tegen echte gegroepeerde data te
kunnen testen (in plaats van alleen tegen de "Overig"-fallback) zijn de 5
standaard `thema`-termen aangemaakt (Kosten, Werkwijze, Kwaliteit,
Duurzaamheid, Contract — dit zijn dezelfde termen die al in
`inc/post-types.php` als voorbeeld in het codecommentaar stonden, geen
nieuwe verzinsels) en toegewezen aan de 6 bestaande `TEST —`-vraagposts.
Geen nieuwe testposts aangemaakt, geen nieuwe verzonnen tekst.

---

Dit was de laatste bouwstap van Fase 4C. Klaar voor de **finale volledige
QA + homepage-regressiecheck** zodra je akkoord geeft — daarna is Fase 4C
in zijn geheel afgerond.
