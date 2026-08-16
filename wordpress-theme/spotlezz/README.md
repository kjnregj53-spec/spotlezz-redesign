# Spotlezz — WordPress theme (fase 4A: foundation)

Bouwblauwdruk: `audit/WORDPRESS-BUILD-PLAN.md` (fase 3, APPROVED).
Deze map is **niet geïnstalleerd of gedeployed** — puur lokale theme-code,
nog niet verbonden met een WordPress-installatie of de productiesite.

## Wat is er gebouwd (fase 4A)

Alleen de structurele fundering, zoals afgesproken. Geen paginacontent,
geen volledige ACF-veldgroepen per paginatype, geen visueel herontwerp.

| Bestand(en) | Doel |
| --- | --- |
| `style.css` | verplichte theme-header (naam, versie, text domain) |
| `functions.php` | bootstrap, laadt `inc/*.php` in vaste volgorde |
| `inc/setup.php` | theme supports, nav-menu's, image sizes, content width |
| `inc/enqueue.php` | CSS/JS-registratie, fonts, `wp_localize_script` voor het form-endpoint |
| `inc/site-options.php` | gecentraliseerde NAP/contact/reviewscore — werkt met ACF Options Page **of**, als ACF nog niet actief is, een native Settings API-pagina met dezelfde velden |
| `inc/post-types.php` | CPT's `pillar`, `case`, `locatie` (hiërarchisch, voor wijken), `vraag`; taxonomieën `thema`, `branche` |
| `inc/acf-fields.php` | `spotlezz_acf_active()` + `spotlezz_field()`-wrapper; **geen** veldgroepen per paginatype (dat is 4B/4C) |
| `inc/schema.php` | JSON-LD-architectuur: één `@graph` per pagina, Organization/CleaningService, WebSite, Person (alleen bij een naam), BreadcrumbList |
| `inc/breadcrumbs.php` | kruimelpad-data + HTML, hergebruikt door `inc/schema.php` zodat zichtbare en schema-breadcrumb nooit uit elkaar kunnen lopen |
| `inc/components.php` | `spotlezz_next_hop()` (weigert te renderen bij ≠3 routes of een ontbrekende url), `spotlezz_stat_block()`, `spotlezz_person_card()` (rendert kaart + registreert Person-schema in één aanroep), `spotlezz_review_badge()` |
| `inc/seo-yoast.php` | schakelt de theme's eigen Organization/Breadcrumb-schema uit zodra Yoast actief is, zodat er geen dubbele nodes ontstaan; theme rendert zelf nooit een `<title>` of meta description |
| `inc/publish-gate.php` | noindex-afdwinging op `locatie`-posts zonder voldoende lokaal bewijs (§5.4) — werkt met of zonder Yoast, plus een admin-notice |
| `header.php` / `footer.php` | de enige twee plekken met skip-link/`<header>`/`<main>`/`<footer>` |
| `template-parts/header/navigation.php`, `mobile-nav.php` | menu-rendering, WordPress-menu-gestuurd met een fallback-menu zolang er nog niets is aangemaakt |
| `index.php`, `page.php`, `single.php`, `archive.php`, `404.php` | generieke fallbacks |
| `front-page.php` | homepage: full-bleed hero (APPROVED §5.1) + antwoordblok + placeholder + next-hop |
| `single-pillar.php`, `single-case.php`, `single-locatie.php`, `single-vraag.php` | per-CPT-templates: titel + placeholder-sectie + paginatype-specifieke next-hop-routes |
| `assets/css/theme.css` | herbruikt de bestaande merktokens (`--primary-blue #0f8bfd`, `--vuur #ff9100`, Poppins/Montserrat) uit de huidige static build; alleen de schaal die nodig is voor header/footer/hero/next-hop/breadcrumb/statenblok |
| `assets/js/theme.js` | alleen het mobiele-menu-gedrag |

## Wat bewust NIET is gebouwd in 4A

- Geen homepage-, pillar-, case-, locatie- of FAQ-ACF-veldgroepen
  (WORDPRESS-BUILD-PLAN §3.1–§3.5) — dat is fase 4B/4C.
- Geen daadwerkelijke content-migratie vanuit de static build.
- Geen visueel herontwerp — de CSS herbruikt de bestaande, goedgekeurde
  tokens en verandert niets aan de merkidentiteit.
- Geen ACF-plugin-installatie. Alle ACF-aanroepen zijn geguard met
  `function_exists()` / `spotlezz_acf_active()`; zonder ACF actief blijft
  de site functioneel met placeholder-defaults, met ACF actief pakt de
  Options-pagina het automatisch over van de native fallback.
- Geen Elementor (uitgesloten in fase 3).
- Geen wijziging aan `spotlezz.vercel.app/`, `build/`, of `wireframes/`.
- Geen deploy, geen koppeling aan de productie-WordPress-installatie.

## Hoe de vier fase-3-besluiten terugkomen in de code

1. **Full-bleed hero (§5.1)** — `front-page.php` + `.hero-full-bleed` in
   `assets/css/theme.css`. Bevat al een overlay-gradient voor
   leesbaarheid en een responsive breakpoint; geen split-layout.
2. **Thirza-portret (§5.2)** — `spotlezz_person_card()` toont een
   initiaal-avatar zodra `image_url` leeg is; er is nergens in de code
   een specifiek bestand (zoals `professional-cleaning.jpg`) hardcoded
   als iemands portret.
3. **Case-scope blijft 3 (§5.3)** — geen extra content aangemaakt; het
   `case`-CPT ondersteunt uitbreiding zonder theme-wijziging, mocht dat
   later gewenst zijn.
4. **Locatie-noindex-gate (§5.4)** — `inc/publish-gate.php`, actief
   ongeacht of de locatie-ACF-velden al bestaan (ontbrekende velden =
   `proof_count = 0` = noindex, een veilige default).

## Validatie uitgevoerd

- `php -l` op alle 25 PHP-bestanden: geen syntaxfouten.
- Exact één `<main id="main">` (header.php) en één `</main>` (footer.php)
  in de hele theme; geverifieerd dat overige `<main`-treffers alleen in
  documentatiecommentaar voorkomen.
- Exact één `<header`- en één `<footer`-tag in de hele theme.
- Exact één skip-link-implementatie (header.php).
- Elk top-level template roept `get_header()` en `get_footer()` precies
  één keer aan (10/10 templates geverifieerd).
- `spotlezz_next_hop()` wordt vanuit 6 templates aangeroepen, elke
  aanroep met exact 3 routes (geteld, niet aangenomen).
- Geen enkele template-file roept `get_field()` rechtstreeks aan buiten
  de drie geautoriseerde wrapper-bestanden (`inc/acf-fields.php`,
  `inc/site-options.php`, `inc/publish-gate.php`).
- Geen onge-escapte `echo $variabele`-patronen buiten de daarvoor
  gedocumenteerde, bewust veilige uitzondering (`$hero_style`, zelf
  opgebouwd met `esc_url()`).
- Functie-inventarisatie van alle aangeroepen functies doorlopen: geen
  verzonnen/niet-bestaande WordPress- of ACF-functies; alle
  ACF-aanroepen zijn `function_exists()`-geguard.

## ACF Free — niet ACF Pro (vastgelegd besluit)

Dit project koopt **geen** ACF Pro. Dat heeft twee concrete gevolgen voor de
theme-architectuur, allebei al verwerkt:

1. **Geen repeater-velden.** ACF Free kent het `repeater`-veldtype niet.
   De homepage-veldgroep (`inc/acf-homepage.php`) gebruikt daarom losse,
   genummerde velden voor de vier statistieken (`stat_1_value` t/m
   `stat_4_label`), de drie foto's (`photo_1` t/m `photo_3_caption`) en de
   drie reviews (`review_1_quote` t/m `review_3_photo`) — nooit een
   repeater. Relationship-velden (klantcases, FAQ's) blijven wel gewoon
   werken: `relationship` is een gratis ACF-veldtype.
2. **Geen ACF Options Page.** `acf_add_options_page()` bestaat alleen in
   ACF Pro. `inc/site-options.php` gebruikt die route daarom alleen als hij
   er daadwerkelijk is; zonder ACF Pro (de normale situatie hier) valt
   alles terug op een eigen, native instellingenpagina onder **Instellingen
   → Site Options** die naar gewone `wp_options`-rijen schrijft
   (`spotlezz_review_score`, `spotlezz_phone`, enzovoort).

### Site Options: geen verplichte init-stap

`spotlezz_get_option()` valt terug op de standaardwaarde uit
`spotlezz_site_option_fields()` zodra een waarde nog niet is opgeslagen.
Dat betekent dat het reviewblok, de topbalk, het NAP-blok etc. **meteen na
activatie de juiste standaardtekst tonen**, ook voordat iemand ooit de
instellingenpagina heeft geopend — er is dus geen verplichte "eerst
opslaan"-stap.

**Wanneer bewaren dan wel nodig is:** zodra een waarde moet afwijken van de
standaard (bijvoorbeeld de echte postcode invullen, of de reviewscore
bijwerken na nieuwe beoordelingen), moet een beheerder naar **Instellingen
→ Site Options** en daar opslaan. Dat schrijft naar dezelfde
`spotlezz_{key}`-optie die de theme uitleest — er is precies één opslagpad,
niet twee die elkaar kunnen missen.

*(Dit was tot de fase-4B-preview stuk: `spotlezz_get_option()` controleerde
alleen of `get_field()` bestond — waar is in zowel ACF Free als Pro — en
probeerde dan altijd de ACF-Options-opslag te lezen, ook zonder Options
Page. Resultaat: een reviewbadge die altijd leeg bleef, ongeacht wat er op
de instellingenpagina stond, omdat lezen en schrijven twee verschillende,
nooit-verbonden plekken waren. Gefixt door de ACF-Options-route alleen te
nemen als `acf_add_options_page` er echt is.)*

## Openstaand voor fase 4B (niet nu bouwen, alleen ter oriëntatie)

- ACF-veldgroepen per paginatype exact zoals WORDPRESS-BUILD-PLAN §3.
- Werkelijke sectie-opbouw van elk paginatype (op dit moment: titel +
  "volgt in fase 4B"-placeholder + next-hop).
- Hub-templates (archive-pillar.php etc.) met de echte wireframe-lay-out
  (filters, thema-groepering) i.p.v. de generieke lijst in `archive.php`.
- FAQ Variant-A-conversiecomponent (regel 13).
- Klantlogo als verplicht veld op `case`-posts (regel 11) — het `case`-CPT
  bestaat al, het veld nog niet.
