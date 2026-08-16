# Fase 4C — Pillar: validatierapport

## Bestanden gewijzigd

| Bestand | Wat |
| --- | --- |
| `inc/publish-gate.php` | (stap 1, al gerapporteerd) |
| `inc/site-options.php` | +24 gedeelde velden: `review_1..3_*` (12) en `stap_1..4_titel/tekst` + `vgl_spotlezz_1..5` + `vgl_anderen_1..5` (18) — zie hieronder |
| `inc/components.php` | +2 gedeelde renderfuncties: `spotlezz_reviews_block()`, `spotlezz_faq_block($post_id)` (geëxtraheerd uit `front-page.php`) en `spotlezz_werkwijze_vergelijking_block()` (nieuw) |
| `front-page.php` | **enige aanraking van bevroren fase 4B** — de inline reviews- en FAQ-secties vervangen door aanroepen van de nieuwe gedeelde functies. Zichtbare uitvoer, CSS-classes en schema-gedrag ongewijzigd; alleen de databron voor reviews verhuisde van een homepage-ACF-veld naar Site Options |
| `inc/acf-homepage.php` | de 12 `review_1..3_*`-velden en hun tab verwijderd (nu in Site Options) |
| `inc/acf-pillar.php` | **nieuw** — pillar-veldgroep, 48 velden, 7 tabs |
| `single-pillar.php` | **volledig vervangen** — alle 12 wireframe-rijen |
| `functions.php` | `inc/acf-pillar.php` geregistreerd |
| `assets/css/theme.css` | pillar-secties toegevoegd (~90 regels) |
| `inc/schema.php` | **bugfix, zie "Onderweg gevonden" hieronder** — raakt ook de bevroren homepage, maar wijzigt geen zichtbare HTML/CSS/velden |

## Velden toegevoegd

**Site Options (gedeeld, `inc/site-options.php`):** `review_1_quote/_name/_role/_photo`, `review_2_*`, `review_3_*` (12) · `stap_1_titel/_tekst` … `stap_4_titel/_tekst` (8) · `vgl_spotlezz_1..5`, `vgl_anderen_1..5` (10).

**Pillar (`inc/acf-pillar.php`, 48 velden, 7 tabs):** `hero_kicker/_h1/_intro`, `usp_1..3` · `answer_intro`, `stat_frequentie_value/_label`, `stat_reactietijd_value/_label` · `task_1_label/_pillar` … `task_8_label/_pillar` (16, relationship) · `photo_1/_caption` … `photo_3/_caption` (6) · `medewerker_naam/_functie/_quote/_foto/_linkedin` (5) · `featured_cases` (relationship, min2 max2) · `featured_faqs` (relationship, min5 max8).

Geen repeater, geen gallery, geen ACF Options Page-afhankelijkheid.

## Secties geïmplementeerd (wireframe-1-dienst-detail-FINAL, alle 12 rijen)

1. Nav/breadcrumb — geërfd van `header.php`, ongewijzigd
2. Hero + snelofferte-kaart (visuele CTA-kaart, **geen** embedded formulier — conform beslissing 5)
3. Antwoordblok (4 stats: prijsfactoren-link, frequentie, regio, reactietijd)
4. Werkzaamheden-raster (tot 8 tegels, elk optioneel een echte link naar een andere pillar)
5. Werkwijze (4 stappen) + vergelijkingstabel + CTA — gedeeld via Site Options
6. Eigen fotografie (3 foto's + placeholder-fallback)
7. Reviews — gedeeld via Site Options (leeg = geen sectie, zoals homepage)
8. Medewerker aan het woord — persoonskaart + Person-schema, leeg naamveld = geen kaart
9. Klantcases (exact 2, relationship)
10. Regioblok (alle gepubliceerde locaties, automatisch, elke pill een echte link)
11. FAQ (5–8, relationship, gedeelde renderfunctie)
12. Next-hop bar (3 routes; "zijwaarts" wijst naar de eerste gekoppelde case, geen handmatige URL)

## Schema toegevoegd

- `Service` (naam, URL, `provider`, `areaServed`)
- `Person` voor de medewerker (via `spotlezz_person_card()`, alleen als naam gevuld is — geen node bij lege placeholder)
- `FAQPage` uit de geselecteerde vragen (gedeelde functie, zelfde als homepage)
- `BreadcrumbList` — al bestaand vanuit fase 4A, werkt automatisch voor elk paginatype

## Relationships / interne links

`featured_cases`, `featured_faqs`, `task_N_pillar` zijn alle relationship-velden — geen vrije tekst. Getest: een taak gekoppeld aan Hygiëneservice/Vloeronderhoud/Glasbewassing rendert als een echte link naar die pillar; ongekoppelde taken renderen als platte tegel, nooit als kapotte link. Regioblok is query-gebaseerd (geen ACF), zelfde patroon als homepage.

## QA-resultaten

| # | Check | Resultaat |
| --- | --- | --- |
| 1 | PHP-lint | **PASS** — 27/27 bestanden |
| 2 | ACF-velddefinities in de admin | **PASS** — 48 velden, 7 tabs, 10 relationship-velden, **0 repeaters, 0 galleries** |
| 3 | Relationship-selecties correct opgeslagen/gelezen | **PASS** — 3× task-pillar-koppeling, 2× featured_cases, 5× featured_faqs, allemaal exact zoals ingevoerd |
| 4 | Alt-tekst op editable afbeeldingen | **PASS** — zelfde `spotlezz_image_alt()`/`spotlezz_post_thumbnail_alt()`-patroon hergebruikt, geen kale `<img>` |
| 5 | Exact één `<main>` | **PASS** |
| 6 | Exact één next-hop bar, 3 routes | **PASS** — "zijwaarts" toont dynamisch de eerste gekoppelde case i.p.v. een vaste hub-link |
| 7 | 390px | **PASS** — `scrollWidth: 390`, 0 overflow |
| 8 | 430px | **PASS** — `scrollWidth: 430`, 0 overflow |
| 9 | 1440px | **PASS** — `scrollWidth: 1425` (= viewport − scrollbar), 0 overflow |
| 10 | Geen PHP-warnings/-notices/-fatals | **PASS** — volledige sessie gecontroleerd (velden opslaan, pagina laden, admin-scherm) |
| 11 | Homepage-regressie | **PASS** — 4B ongewijzigd zichtbaar, reviews-sectie terecht leeg (geen data), FAQ werkt via de nieuwe gedeelde functie, 1 `<main>`, 1 next-hop, 0 overflow bij 390px |

## Onderweg gevonden: een bug die ook de bevroren fase-4B-homepage al raakte

**`spotlezz_output_schema()` hing aan `wp_head`, dat vuurt vóórdat de
hoofdinhoud van een template geladen wordt.** Elke `add_filter(
'spotlezz_schema_graph', ...)`-aanroep die dieper in een template-loop
staat — het FAQ-schema, het Review-schema, en nu ook het nieuwe
Service-schema — kwam daardoor structureel te laat: de graph was al
samengesteld en uitgevoerd voordat die filters ooit geregistreerd werden.

**Dit gold al voor de goedgekeurde homepage.** Concreet: de FAQPage-node
die de fase-4B-QA als aanwezig rapporteerde, stond feitelijk nooit echt in
de output — mijn eerdere validatie controleerde wel de Organization-
velden (telefoon, adres, rating — die komen uit het niet-loop-afhankelijke
deel van de functie en werkten dus wél), maar heb ik toen niet apart op
het `FAQPage`-type zelf gegrept. Dat is bij deze Pillar-QA alsnog gedaan
en bracht het gat aan het licht.

**Fix:** `spotlezz_output_schema()` van `wp_head` naar `wp_footer`
verplaatst. JSON-LD is voor Google net zo geldig vlak vóór `</body>` als
in `<head>` — er verandert niets aan zichtbare HTML, CSS of veldstructuur,
alleen het moment waarop het ene `<script>`-blok wordt geprint.

**Geverifieerd na de fix:**
- Homepage: `FAQPage`-node nu daadwerkelijk aanwezig (was 0, nu 1).
- Pillar: `Service`-node en `FAQPage`-node beide aanwezig, nog steeds
  precies één `<script type="application/ld+json">`-blok (geen
  duplicatie).
- Homepage-regressie hierna opnieuw volledig gecontroleerd (zie tabel
  hierboven) — geen andere verandering dan de nu wél werkende schema-nodes.

Dit is dus strikt genomen een bugfix op iets dat al in fase 4B stond, niet
een gedragswijziging van fase 4B zelf — geraakt bestand is `inc/schema.php`
(theme-brede infrastructuur), niet `front-page.php` of
`inc/acf-homepage.php`.

## Screenshots

- `local-preview/screenshots/pillar-desktop-1440.png` — volledige
  pillar-pagina, 1440px, met testcontent (duidelijk gemarkeerd `TEST —`).

## Geen verzonnen content

Medewerker-naam bewust leeg gelaten tijdens het testen (geen kaart, geen
Person-schema — correct empty-state-gedrag, precies zoals bij de
oprichter op de homepage). Alle testcases/testvragen/testfoto-bijschriften
zijn hergebruikt uit de al bestaande `TEST —`-content van eerdere fases;
er is niets nieuws verzonnen.

---

Klaar voor **Case** zodra je akkoord geeft.
