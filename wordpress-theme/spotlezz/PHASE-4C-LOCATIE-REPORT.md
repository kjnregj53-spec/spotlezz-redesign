# Fase 4C — Locatiepagina: validatierapport

## Bestanden gewijzigd

| Bestand | Wat |
| --- | --- |
| `inc/acf-locatie.php` | **nieuw** — locatie-veldgroep, 6 tabs, 29 velden, 3 relationships |
| `single-locatie.php` | **volledig vervangen** (was de 4A-stub met alleen de noindex-gate-aanroep) — alle 11 wireframe-rijen |
| `inc/components.php` | `spotlezz_faq_block()` uitgebreid met een optioneel `$field_name`-argument (default `featured_faqs`, ongewijzigd voor homepage/pillar), zodat locatie zijn eigen `lokale_faqs`-veld kan hergebruiken zonder de functie te dupliceren |
| `functions.php` | `inc/acf-locatie.php` geregistreerd |
| `assets/css/theme.css` | locatie-secties toegevoegd (~75 regels), hergebruikt bewust bestaande classes (`.pill`, `.location-pills`, `.case-card`, `.photography-grid`, `.review-card`) i.p.v. nieuwe duplicaten |

`inc/publish-gate.php` is **niet** opnieuw gewijzigd deze stap — de
veldnamen die de gate al aannam (`logo_1`..`logo_6`, `lokale_case`,
`lokale_review_quote`, `lokaal_team_naam`) zijn exact de namen die
`inc/acf-locatie.php` nu registreert, dus de gate werkte meteen goed
zonder aanpassing (zie QA-check 1 hieronder).

## Velden toegevoegd (`inc/acf-locatie.php`, 29 velden, 6 tabs)

- **Hero**: `kaart_afbeelding`, `stat_reactietijd_value`, `stat_teams_value`
- **Lokaal bewijs**: `logo_1..6`, `lokale_case` (relationship → case, max 1), `lokale_review_quote/_naam/_rol/_foto`, `lokaal_team_naam/_rol/_quote/_foto/_linkedin`
- **Diensten**: `diensten_top3` (relationship → pillar, min 3 max 3)
- **Werkgebied**: `werkgebied_tekst` (wysiwyg, enige wysiwyg-veld in het hele theme — bewust, voor de vrije 500+ woorden lokale tekst)
- **Eigen fotografie**: `photo_1/_caption` … `photo_3/_caption`
- **FAQ**: `lokale_faqs` (relationship → vraag, min 3 max 5)

Geen repeater, geen gallery. `areaServed`/wijken/"andere locaties" zijn
bewust géén ACF-veld — automatisch via `post_parent` resp. alle overige
gepubliceerde `locatie`-posts, zelfde patroon als het werkgebiedblok op de
homepage.

## Secties geïmplementeerd (wireframe-4-locatiepagina-FINAL, alle 11 rijen)

1. Nav/breadcrumb — geërfd van `header.php`, ongewijzigd (inclusief wijk-in-breadcrumb-logica die al in `inc/breadcrumbs.php` stond)
2. Hero + kaart + NAP-blok
3. Antwoordblok (4 stats: prijsfactoren-link, reactietijd, teams, beoordelingen)
4. **Lokaal bewijs** — 6-logo grid, lokale case-kaart, lokale review met correcte `&#9733;`-HTML-entity-sterren (de audit noemde dit blok "maakt of breekt de pagina" én meldde corrupte `â˜…`-tekens op de oude static build — hier onmogelijk: sterren staan al als HTML-entity in het component, nooit als losse UTF-8-tekens in de brondata)
5. Diensten top-3 + wijken (`post_parent`-query)
6. Werkgebiedtekst (wysiwyg, per plaats echt anders)
7. Eigen fotografie (3 foto's + bijschrift)
8. Lokaal team (`spotlezz_person_card()`)
9. Lokale FAQ (gedeelde `spotlezz_faq_block()`, nu met `lokale_faqs` als bron)
10. Locatie-carrousel ("andere locaties", automatische query, sluit de huidige uit)
11. Next-hop bar (3 routes; "zijwaarts" wijst naar de lokale case als die er is, anders naar de dienstenhub)

## Twee audit-bevindingen hier expliciet geadresseerd

- **Ontbrekend 6-logo klantgrid** (grootste bevinding van dit paginatype — zelfs op de vlaggenschip-locatie in de audit): het veld bestaat nu als 6 losse, individueel optionele image-velden en rendert alleen tegels die daadwerkelijk gevuld zijn — geen placeholder-tegels.
- **Corrupte sterren-encoding** (`â˜…â˜…â˜…â˜…â˜…` i.p.v. echte sterren): het reviewblok gebruikt hier dezelfde `&#9733;`-HTML-entity-aanpak als het gedeelde `spotlezz_reviews_block()`-component — een encodingfout van dat type kan hier structureel niet meer optreden, want er wordt nergens een los UTF-8-sterretje in de brondata of template getypt.

## Schema toegevoegd

- `LocalBusiness`/`CleaningService` met `areaServed` = deze plaats/wijk, eigen `@id` (`{permalink}#localbusiness`) en `parentOrganization` verwijzend naar de generieke Organization-node — dus geen duplicaat-Organization, wel een eigen, specifieke node per locatie
- `Review` voor de lokale review (zelfde structuur als het gedeelde reviewblok)
- `Person` voor het lokale team (via `spotlezz_person_card()`, eigen `id_suffix` `locatie-{id}-team` — geen `@id`-botsing met pillar-medewerkers of de homepage-oprichter)
- `FAQPage` uit de lokale FAQ's (gedeelde functie)
- `BreadcrumbList` — al bestaand, inclusief wijk-parent in het pad

## QA-resultaten

| # | Check | Resultaat |
| --- | --- | --- |
| 1 | **Noindex-gate, met de gecorrigeerde veldnamen — twee testlocaties, tegengesteld bewijs** | **PASS** — TEST Almere (4/4 bewijsvormen) heeft géén `<meta name="robots">`-tag (indexeerbaar); TEST Lelystad (1/4 bewijsvormen: alleen lokaal team, bewust geen logo's/case/review) heeft wél `<meta name="robots" content="noindex, follow">`. De gate onderscheidt de twee gevallen correct, niet aangenomen maar echt getest. |
| 2 | PHP-lint | **PASS** — 29/29 bestanden |
| 3 | ACF-velddefinities in de admin | **PASS** — 6 tabs, 29 velden (12 image, 9 text, 2 textarea, 1 url, 1 wysiwyg, 3 relationship), **0 repeaters, 0 galleries** |
| 4 | Relationship-selecties correct opgeslagen/gelezen | **PASS** — `lokale_case` (1), `diensten_top3` (3), `lokale_faqs` (3), allemaal exact zoals ingevoerd |
| 5 | Alt-tekst op editable afbeeldingen | **PASS** — `spotlezz_image_alt()` hergebruikt voor kaart/logo's/reviewfoto/teamfoto/foto's |
| 6 | Exact één `<main>` | **PASS** |
| 7 | Exact één next-hop bar, 3 routes | **PASS** |
| 8 | Wijken en "andere locaties" tonen echte links, geen vrije tekst | **PASS** — 4 wijk-pills (Almere Stad/Buiten/Haven/Poort via `post_parent`) + 3 andere-locaties-pills (Lelystad/Amsterdam/Amersfoort), alle met echte `get_permalink()`-hrefs |
| 9 | 390px | **PASS** — `scrollWidth: 390`, 0 overflow |
| 10 | 430px | **PASS** — `scrollWidth: 430`, 0 overflow |
| 11 | 1440px | **PASS** — `scrollWidth: 1425` (= viewport − scrollbar), 0 overflow |
| 12 | Schema — geen dubbele `@id`'s | **PASS** — `LocalBusiness`-node heeft een eigen `@id` per locatie, `Person`-node voor het team heeft `#locatie-{id}-team`, nooit een generieke suffix |
| 13 | Geen PHP-warnings/-notices/-fatals | **PASS** — volledige sessie gecontroleerd |
| 14 | Homepage-regressie | **PASS** — FAQPage-schema aanwezig, 1 `<main>`, 1 next-hop |
| 15 | Pillar-regressie | **PASS** — Service + FAQPage-schema aanwezig, 1 `<main>`, 1 next-hop |
| 16 | Case-regressie | **PASS** — Article-schema aanwezig, 1 `<main>`, 1 next-hop |

## Bug gevonden en meteen gefixt tijdens deze stap (klein, geen schema-impact)

Tijdens de eerste render toonde het lokale-case-kaartje ("Lees de case: …")
de titel en het onderschrift op één regel zonder duidelijke scheiding,
omdat de markup `<b>`/`<span>` gebruikte terwijl de al bestaande
`.case-card-body`-CSS (hergebruikt van de klantcase-hub-stijl) specifiek
`<h3>`/`<p>` verwacht. Gefixt door de markup aan te passen naar `<h3>`/`<p>`
— zuiver een opmaakfix in `single-locatie.php`, geen ACF-, schema- of
databronwijziging. Geverifieerd met een herrenderde screenshot.

## Screenshot

- `local-preview/screenshots/locatie-desktop-1440.png` — TEST Almere
  (volledig bewijs), 1440px, met testcontent (duidelijk gemarkeerd `TEST —`).

## Geen verzonnen content

Alle testtekst gemarkeerd `TEST —`. Logo's/kaart/foto's/portretten zijn
gegenereerde placeholder-afbeeldingen (blauw vlak met label-tekst), geen
verzonnen echte productfoto's. Lelystad is bewust ondergevuld gehouden
(alleen een teamnaam, geen logo's/case/review) — dat is de hele opzet van
deze QA-stap (bewijzen dat de gate onderscheid maakt), geen halve
implementatie die per ongeluk zo bleef staan.

---

Klaar voor **FAQ** zodra je akkoord geeft.
