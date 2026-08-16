# Fase 4B — Homepage: validatierapport

Scope: alleen de homepage (`front-page.php` + `inc/acf-homepage.php` +
CSS + de kleine CPT-aanpassing in `inc/post-types.php`). Pillar-, case-,
locatie- en FAQ-templates zijn niet aangeraakt, zoals gevraagd.

## Wat is gebouwd

Alle 12 gevraagde secties, in wireframe-volgorde, gevoed door de
homepage-ACF-veldgroep (`group_spotlezz_homepage`) of — waar het bouwplan
dat voorschrijft — automatisch uit gepubliceerde `pillar`/`locatie`-posts:

1. Full-bleed hero (ongewijzigd concept, APPROVED §5.1)
2. Trust/antwoordblok (4 stats via repeater + optionele introzin)
3. Diensten twee-assen — **geen ACF**, automatisch uit `pillar`-posts,
   as-onderscheid via de `branche`-taxonomie
4. Werkgebied — **geen ACF**, automatisch uit `locatie`-posts, elke pill
   een echte link
5. Eigen fotografie (repeater, 3 foto's + bijschrift)
6. Reviews (repeater, 3 reviews + Review-schema)
7. Klantcases — **relationship**, alleen bestaande gepubliceerde cases
8. Oprichter — persoonskaart + Person-schema in één aanroep
9. FAQ — **relationship**, alleen bestaande gepubliceerde vragen +
   FAQPage-schema
10. Zachte conversie / lead magnet (precies één instantie)
11. Next-hop bar (locked, ongewijzigd uit fase 4A)
12. Footer (locked, ongewijzigd uit fase 4A)

## Resultaten

| # | Check | Resultaat |
| --- | --- | --- |
| 1 | PHP-lint op alle gewijzigde bestanden | **PASS** — 26/26 bestanden in de theme, `php -l`, geen syntaxfouten (inclusief een parse-fout die tijdens het bouwen zelf al is gevonden en gefixt — zie Bevindingen) |
| 2 | ACF-veldnamen tegen de specificatie | **PASS** — elke `spotlezz_field()`-aanroep in `front-page.php` (17 unieke veldnamen, incl. `hero_h1`/`hero_h2`) komt exact overeen met een `'name' =>` in `inc/acf-homepage.php`; alle repeater-subvelden (`stat_value`, `stat_label`, `photo`, `caption`, `quote`, `reviewer_name`, `reviewer_role`, `reviewer_photo`) geverifieerd tegen hun `sub_fields`-definitie |
| 3 | Alt-tekst op elke bewerkbare afbeelding | **PASS** — alle 6 `<img>`-tags die de homepage kan renderen gaan door `spotlezz_image_alt()` (ACF-afbeeldingen) of `spotlezz_post_thumbnail_alt()` (native uitgelichte afbeeldingen), met een niet-lege fallback (bijschrift, naam of posttitel); de hero-achtergrond is CSS `background-image` (decoratief, geen `<img>`, geen alt nodig) |
| 4 | Elke relationship lost op naar een echt WP-object | **PASS** — `featured_cases` en `featured_faqs` worden na ophalen gefilterd op `instanceof WP_Post && post_status === 'publish'`; diensten- en werkgebiedblok zijn geen relationship maar een live `get_posts()`-query met `post_status => publish`, dus kunnen per definitie nooit naar een niet-bestaand of ongepubliceerd item wijzen |
| 5 | Exact één `<main>` | **PASS** — precies één `<main id="main">` (header.php:81) en één `</main>` (footer.php:14) in de hele theme |
| 6 | Exact één header/footer | **PASS**, met een tussentijdse fix — zie Bevindingen |
| 7 | Exact één next-hop bar, exact 3 routes | **PASS** — `front-page.php` roept `spotlezz_next_hop()` één keer aan met 3 routes (geteld, niet aangenomen); ook op de vijf overige templates (archive/pillar/case/locatie/vraag) nog steeds 3/3, ongewijzigd |
| 8 | Schema dupliceert Yoast niet | **PASS**, met een tussentijdse fix — zie Bevindingen |

## Bevindingen tijdens het bouwen (gevonden én al opgelost)

Dit rapport toont ook wat er onderweg mis ging, niet alleen het eindresultaat —
dat hoort bij "werk incrementeel, verifieer elke stage."

1. **PHP-parsefout (gevonden bij lint, direct gefixt).** In de FAQ-sectie
   stond een curly-brace `if(){ }` direct vóór een `elseif(...):`
   (alternatieve syntax). PHP staat het mengen van die twee stijlen in
   dezelfde if-keten niet toe — `unexpected token ":"` op regel 431. Fix:
   het hele blok omgezet naar consistente curly-brace-stijl. Her-lint: PASS.

2. **`<footer>` binnen een review-quote (gevonden bij check 6, gefixt).**
   Het review-blok gebruikte `<footer class="review-author">` voor de
   naam/functie-toeschrijving onder een quote. Dat is geldige, standaard
   HTML5 (een `<footer>` binnen een `<blockquote>` is zelfs het
   schoolvoorbeeld uit de spec) en telt niet als een landmark-footer — maar
   om elke twijfel bij "exact één footer" weg te nemen is het element
   vervangen door een gewone `<div class="review-author">`. Geen
   functionele of visuele wijziging; de CSS-selector was al class-based.

3. **Dubbele Person-schema-bron voor de oprichter (gevonden bij check 8,
   gefixt — de belangrijkste bevinding van deze fase).** `inc/schema.php`
   bevatte sinds fase 4A een generieke oprichter-Person-node die las uit
   een Site Option `founder_name` — een veld dat nooit geregistreerd is
   (`inc/site-options.php` kent alleen `linkedin_founder`, niet
   `founder_name`), dus die code vuurde in de praktijk nooit. Maar de
   nieuwe homepage-oprichterskaart (`spotlezz_person_card()` met
   `id_suffix => 'founder'`) gebruikt **dezelfde** `@id`
   (`home_url('/#founder')`). Was die Site Option ooit alsnog gevuld
   geraakt, dan had de `@graph` twee Person-objecten met identiek `@id`
   bevat — ongeldige/conflicterende JSON-LD. Fix: de dode, dubbele
   registratie in `inc/schema.php` verwijderd; de homepage-veldgroep is nu
   de enige bron voor de oprichter-Person-node. Gedocumenteerd in de code
   zodat een toekomstig paginatype nooit per ongeluk óók `id_suffix =>
   'founder'` hergebruikt.

   Los daarvan, ter bevestiging: de nieuwe homepage-schema-toevoegingen
   (Review, Person via de oprichterskaart, FAQPage) lopen allemaal via het
   `spotlezz_schema_graph`-filter, dat — anders dan Organization/WebSite/
   Breadcrumb — niet uitgeschakeld wordt zodra Yoast actief is. Dat is
   correct: Yoast genereert die drie nodes niet automatisch (FAQPage alleen
   als iemand het Yoast-FAQ-blok in de inhoud zet, wat hier niet gebeurt —
   dit is een PHP-template, geen blok-content), dus er is geen
   overlappende output om te dupliceren.

## Wat bewust nog placeholder is

- **Hero-achtergrondfoto**: leeg veld → gedocumenteerde gradient-placeholder
  (`.hero-placeholder`), geen vervangende stockfoto.
- **Oprichtersportret**: leeg veld → initiaal-avatar via
  `spotlezz_person_card()`. Geen bestand is hardcoded als iemands portret
  (WORDPRESS-BUILD-PLAN §5.2, APPROVED).
- **Diensten/werkgebied/klantcases/FAQ**: als er nog geen gepubliceerde
  `pillar`/`locatie`/`case`/`vraag`-posts of geselecteerde relaties zijn,
  toont de homepage een discrete, alleen-voor-beheerders-zichtbare
  placeholder-melding in plaats van het blok leeg of kapot te tonen.

## Niet gebouwd in deze fase (ongewijzigd sinds 4A)

`single-pillar.php`, `single-case.php`, `single-locatie.php`,
`single-vraag.php` en `archive.php` blijven de eenvoudige 4A-stubs
(titel + "volgt in een latere fase" + de bijbehorende next-hop). De
homepage linkt er nu wel echt naartoe (via de queries/relationships
hierboven), maar de inhoud van die pagina's zelf is niet aangepast.
