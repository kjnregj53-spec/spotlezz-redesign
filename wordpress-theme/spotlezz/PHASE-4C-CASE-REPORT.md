# Fase 4C — Klantcase: validatierapport

## Bestanden gewijzigd

| Bestand | Wat |
| --- | --- |
| `inc/acf-case.php` | **nieuw** — klantcase-veldgroep, 5 tabs, 21 velden, 1 relationship |
| `single-case.php` | **volledig vervangen** (was de 4A-stub) — alle 7 wireframe-rijen |
| `functions.php` | `inc/acf-case.php` geregistreerd |
| `assets/css/theme.css` | case-secties toegevoegd (~55 regels) |

Geen enkele aanraking van `front-page.php`, `inc/acf-homepage.php`,
`inc/acf-pillar.php`, `single-pillar.php` of `inc/schema.php` — de
homepage en de pillar-pagina blijven exact zoals na de vorige stap.

## Velden toegevoegd (`inc/acf-case.php`, 21 velden, 5 tabs)

- **Hero**: `logo` (afbeelding, **verplicht**), `headline` (tekst, **verplicht**, resultaatzin = H1 = Article.headline), `branche`, `locatie`, `klant_sinds`, `hero_foto`
- **Feitenbalk**: `feit_vloeroppervlak`, `feit_frequentie`, `feit_producten`, `feit_klachten` (alle 4 verplicht — het meetbare bewijs)
- **STAR-structuur**: `star_situatie`, `star_uitdaging`, `star_aanpak`, `star_resultaat`
- **Klantquote**: `quote_tekst`, `quote_naam`, `quote_functie`, `quote_foto`, `quote_linkedin`
- **Gebruikte diensten**: `gebruikte_diensten` (relationship → `pillar`, min 1 max 3)

Geen repeater, geen gallery.

## Secties geïmplementeerd (wireframe-2-klantcase-FINAL, alle 7 rijen)

1. Nav/breadcrumb — geërfd van `header.php`, ongewijzigd
2. Hero met harde feiten: logo, H1 = resultaatzin, 3 stats (branche/locatie/klant sinds), herofoto
3. Feitenbalk (4 harde cijfers, via `spotlezz_stat_block()`)
4. STAR-structuur (situatie/uitdaging/aanpak/resultaat, elk alleen zichtbaar als ingevuld)
5. Klantquote (groot citaat + `spotlezz_person_card()` voor de contactpersoon)
6. Gebruikte diensten — elke tegel linkt naar zijn **eigen** pillar-URL (relationship, geen vrije tekst)
7. Next-hop bar (3 routes; "omhoog" wijst naar de eerste gekoppelde dienst-pillar, "zijwaarts" naar een andere, willekeurige gepubliceerde case)

## Bug uit de audit hier expliciet gerepareerd

De audit signaleerde op de bestaande Kobelco-case twee concrete fouten die
dit paginatype rechtstreeks aanpakt:
- **H1/schema-mismatch**: de zichtbare titel zei iets anders dan de
  `Article.headline` in de schema. Hier is `headline` het ENE brondata-veld
  voor beide — kan structureel niet meer uit elkaar lopen.
- **Dode links in "gebruikte diensten"**: 2 van de 3 diensten-tegels
  linkten naar de generieke `/diensten/`-hub in plaats van hun eigen
  pillar. Hier is `gebruikte_diensten` een relationship-veld — elke tegel
  rendert `get_permalink($pillar)` van de daadwerkelijk gekoppelde pillar,
  dus dit kan technisch niet meer misgaan (getest, zie hieronder).

## Schema toegevoegd

- `Article` (headline = `headline`-veld, deelt exact dezelfde tekst als de zichtbare H1)
- `Review` (quote-velden, alleen als zowel quote als naam gevuld zijn)
- `Person` voor de contactpersoon (via `spotlezz_person_card()`, `sameAs` alleen bij een bevestigde LinkedIn-URL, eigen `id_suffix` per case zodat er nooit een `@id`-botsing met de pillar-medewerker of de homepage-oprichter kan ontstaan)
- `Organization` voor de klant zelf (naam = posttitel, alleen als branche + locatie beide gevuld zijn)
- `BreadcrumbList` — al bestaand vanuit fase 4A, werkt automatisch

## QA-resultaten

| # | Check | Resultaat |
| --- | --- | --- |
| 1 | PHP-lint | **PASS** — 28/28 bestanden |
| 2 | ACF-velddefinities in de admin | **PASS** — 5 tabs, 21 velden (3 image, 10 text, 5 textarea, 1 url, 1 relationship), **0 repeaters, 0 galleries** |
| 3 | Relationship-selectie correct opgeslagen/gelezen | **PASS** — 2 gekoppelde diensten, exact zoals ingevoerd |
| 4 | Diensten-tegels linken naar eigen pillar-URL, niet de hub | **PASS** — beide `<a class="dienst-tile">`-hrefs wijzen naar `/?pillar=test-kantoor-schoonmaak` resp. `/?pillar=test-glasbewassing`, geen enkele naar `/diensten/` |
| 5 | Alt-tekst op editable afbeeldingen | **PASS** — `spotlezz_image_alt()` hergebruikt voor logo/herofoto |
| 6 | Exact één `<main>` | **PASS** |
| 7 | Exact één next-hop bar, 3 routes | **PASS** — "omhoog" toont dynamisch de eerste gekoppelde dienst i.p.v. een vaste hub-link, "zijwaarts" toont een andere, willekeurige case |
| 8 | H1 = Article.headline (regel 10) | **PASS** — beide lezen exact hetzelfde `headline`-veld, geen aparte titel mogelijk |
| 9 | 390px | **PASS** — `scrollWidth: 390`, 0 overflow |
| 10 | 430px | **PASS** — `scrollWidth: 430`, 0 overflow |
| 11 | 1440px | **PASS** — `scrollWidth: 1425` (= viewport − scrollbar), 0 overflow |
| 12 | Schema — geen dubbele `@id`'s | **PASS** — `Person`-node krijgt `#case-{id}-contact`, nooit `#founder` of de pillar-medewerker-suffix |
| 13 | Geen PHP-warnings/-notices/-fatals | **PASS** — volledige sessie gecontroleerd (velden opslaan, pagina laden, admin-scherm) |
| 14 | Homepage-regressie | **PASS** — FAQPage-schema nog aanwezig, 1 `<main>`, 1 next-hop |
| 15 | Pillar-regressie | **PASS** — Service + FAQPage-schema nog aanwezig, 1 `<main>`, 1 next-hop |

Geen nieuwe bugs gevonden tijdens deze stap — de schema-hook-bug uit de
vorige stap (`wp_head` → `wp_footer`) blijft opgelost en is hier
opnieuw bevestigd te werken voor het Article/Review/Person/Organization-
schema van dit paginatype.

## Screenshot

- `local-preview/screenshots/case-desktop-1440.png` — volledige
  case-pagina, 1440px, met testcontent (duidelijk gemarkeerd `TEST —`).

## Geen verzonnen content

Alle testtekst is gemarkeerd `TEST —`. Het logo/herofoto/portretfoto in de
preview is een gegenereerde placeholder-afbeelding (blauw vlak met de tekst
"TEST PLACEHOLDER"), niet een verzonnen echte productfoto — de media-
bibliotheek van deze lokale preview was leeg, dus er was geen bestaande
echte afbeelding om te hergebruiken. De LinkedIn-URL is een niet-bestaand
placeholder-pad (`/in/test-placeholder-profile`), niet een echt profiel.
Geen van deze testdata verlaat de lokale preview-omgeving.

---

Klaar voor **Locatie** zodra je akkoord geeft.
