# Fase 4B homepage — fix-ronde: validatierapport

Reactie op de vier bevindingen uit `PREVIEW-REPORT.md`. Alle vier zijn
opgelost. Onderweg zijn twee extra, nieuwe bugs gevonden en ook opgelost —
zie §2 en §3, die zijn belangrijker dan de oorspronkelijke bevindingen zelf.

## 1. ACF Free-compatibiliteit — DONE

`trust_stats`, `photography_gallery` en `reviews` (repeaters, Pro-only) zijn
vervangen door losse, genummerde velden in `inc/acf-homepage.php`:

- **Statistieken:** `stat_1_value` … `stat_4_label` (8 velden, nog steeds
  exact 4 feiten — niets ingekort).
- **Foto's:** `photo_1`/`photo_1_caption` … `photo_3`/`photo_3_caption`
  (6 velden, nog steeds exact 3 foto's).
- **Reviews:** `review_1_quote`/`review_1_name`/`review_1_role`/
  `review_1_photo` … `review_3_*` (12 velden, nog steeds tot 3 reviews).

**Architectuurkeuze voor reviews** (zoals gevraagd, hieronder toegelicht
i.p.v. alleen geïmplementeerd): overwogen tussen (a) een `review`-CPT met
een relationship-veld, zoals cases/FAQ, of (b) losse velden per vaste slot.
Gekozen voor (b) — kleinste wijziging, consistent met de statistieken/foto's
hierboven, en reviews zijn hier drie vaste, homepage-specifieke slots, geen
herbruikbare content zoals cases/FAQ dat wel zijn. Optie (a) blijft de juiste
keuze als reviews ooit op meer dan de homepage moeten verschijnen — dat is nu
niet de situatie, dus niet gebouwd.

`featured_cases` en `featured_faqs` blijven ongewijzigd `relationship`-velden
— dat veldtype zit wel in ACF Free.

**Geverifieerd in de admin (wp-admin/post.php?post=6&action=edit):** 8 tabs,
50 losse veldlabels, **0 repeater-UI's**, de 2 relationship-velden tonen
correct hun eerder geselecteerde 3 cases en 5 vragen.

## 2. Mobiele horizontale overflow — DONE, andere oorzaak dan aangenomen

**Belangrijk:** de oorspronkelijke bevinding wees naar het statenblok en het
dienstenblok. Dat bleek een *symptoom*, niet de bron. De daadwerkelijke bron
was de admin-only hero-placeholder-tekst
(`.placeholder-note`, "Tijdelijke placeholder: hero-achtergrondfoto
ontbreekt nog…"): die stond als los element ná `.hero-content` binnen
`.hero-full-bleed`, en `.hero-full-bleed` is een flex-container
(`display:flex`, standaard `flex-direction:row`). Daardoor ging de note
NAAST `.hero-content` staan in plaats van eronder, en trok de hele hero —
en daarmee de hele pagina — 86px breder dan de viewport. Alles daaronder
(statenblok, dienstenblok, de sticky mobiele CTA-balk) leek daardoor zelf
over te lopen, terwijl die blokken op zichzelf prima pasten.

Gevonden door systematisch elementen te verbergen en `scrollWidth` te meten
na elke stap (niet door te raden) — zie de sectie hieronder over de
meetmethode.

**Fix:** de placeholder-note verplaatst näar bínnen `.hero-content`
(`front-page.php`), waar hij gewoon in de normale block-flow onder de
knoppen valt. Daarnaast, als verdedigingslinie op de plekken die
oorspronkelijk verdacht leken:
- `.stat`, `.service-tile`, `.photography-item`, `.review-card`,
  `.case-card`, `.next-hop-card`: `min-width: 0` + `overflow-wrap:
  break-word` toegevoegd (de klassieke grid/flex "min-content trap" —
  bleek hier niet de oorzaak, maar is een reële, andere categorie bug die
  dit voorkomt mocht een label ooit lang genoeg worden).
- `.mobile-sticky-cta`: `width: 100%` i.p.v. `left:0;right:0`, plus
  `min-width: 0` op de knoppen.
- `.pill`: `max-width: 100%; overflow-wrap: break-word`.

Nergens `overflow-x: hidden` gebruikt.

**Root-cause-methode (niet aannames):** headless Chrome via `--window-size`
bleek op deze machine onbetrouwbaar onder ~500px (verzoeken voor 390/430px
werden stil opgehoogd naar ~504px), wat aanvankelijk foutieve metingen
opleverde. De browserpaneel-tool kon geen screenshot maken in deze sessie
("Browser pane is not displayed"). Betrouwbare metingen kwamen van de
CDP-viewport-emulatie (`document.documentElement.clientWidth` correct
bevestigd op 390/430), gecombineerd met een element-voor-element
`getBoundingClientRect()`-scan en een gerichte hide/measure-binary-search
door de paginasecties heen.

**Geverifieerd na de fix, exacte metingen (geen admin-bar meegerekend,
want die zien echte bezoekers nooit):**

| Viewport | `scrollWidth` | Overflowende elementen |
| --- | --- | --- |
| 390px | 390 | 0 |
| 430px | 430 | 0 |
| 1440px | 1425 (= 1440 − scrollbar) | 0 |

## 3. Mobiele navigatie — DONE, plus een tweede bug gevonden bij het klik-testen

- Hamburger- en sluitknop zijn nu inline SVG (drie `<rect>`-balken resp.
  een `×` van twee `<line>`-elementen) i.p.v. Unicode-tekens (`&#9776;`,
  `&times;`), met een expliciete 44×44px knop, achtergrondkleur en
  `color: var(--spotlezz-ink)` — niet langer afhankelijk van of de browser
  toevallig een font met dat glyph kiest.
- **Gevonden, apart van de gevraagde fix:** `.close-menu-btn` had al sinds
  fase 4A geen enkele CSS-regel die hem zichtbaar maakte (`display:none`
  in de basisregel, en alleen `.mobile-menu-btn` kreeg `display:flex`
  terug in de media query — de sluitknop nooit). Rechtgezet: de sluitknop
  hoort bij `.mobile-nav-overlay`, die zelf al `[hidden]` is tot hij
  geopend wordt, dus die knop krijgt nu gewoon standaard `display:flex`
  zonder een aparte viewport-gate.
- **Gevonden tijdens het klik-testen zelf, grotere bug:** de mobiele
  overlay had geen fallback-menu. Zonder een aangemaakt WordPress-menu
  (de situatie in deze preview) toonde `template-parts/header/mobile-nav.php`
  helemaal geen navigatielinks — alleen de offerte-knop — terwijl de
  desktopnavigatie (`navigation.php`) wél een fallback met de vijf hubs
  heeft. Op mobiel kwam een bezoeker dus nergens, ook al werkte de knop
  zelf prima. Dezelfde fallback-lijst nu ook in `mobile-nav.php`
  toegevoegd.

**Klik-test uitgevoerd** (echte `.click()`-aanroep op de knoppen, niet
alleen CSS-inspectie — dit vuurt de daadwerkelijke `addEventListener`-
handler in `assets/js/theme.js`):

| Stap | Verwacht | Gemeten |
| --- | --- | --- |
| Vóór openen | overlay `hidden`, knop 44×44px, SVG aanwezig | ✅ |
| Na klik op hamburger | `hidden`-attribuut weg, `aria-expanded="true"`, `body.style.overflow="hidden"` | ✅ |
| Overlay-inhoud | 7 links (Diensten, Klantcases, Locaties, Veelgestelde vragen, Over ons, Contact, Offerte aanvragen) | ✅ (was 1 vóór de fallback-fix) |
| Na klik op sluitknop | `hidden`-attribuut terug, `aria-expanded="false"`, scroll-lock opgeheven | ✅ |

## 4. Reviewbadge / Site Options — DONE, root cause was dieper dan "eerst opslaan"

De daadwerkelijke oorzaak (zie ook README.md, sectie "ACF Free — niet ACF
Pro"): `spotlezz_get_option()` gebruikte de ACF-Options-opslag zodra
`get_field()` bestond — maar dat bestaat ook in gratis ACF, terwijl de
Options-Page-opslag zelf Pro-only is. Met alleen gratis ACF (permanente
situatie, ACF Pro wordt niet aangeschaft) las de functie dus altijd van een
plek die nooit gevuld kon worden, terwijl de native fallback-instellingen-
pagina naar een heel andere plek schreef. Twee opslagpaden die elkaar nooit
zagen.

**Fix, twee delen:**
1. De ACF-Options-route wordt alleen nog genomen als `acf_add_options_page`
   er daadwerkelijk is (dus met ACF Pro). Zonder ACF Pro leest de functie
   uitsluitend de native optie — dezelfde plek waar de instellingenpagina
   ook naar schrijft.
2. `spotlezz_get_option()` valt terug op de default uit
   `spotlezz_site_option_fields()` zelf zodra de aanroeper geen eigen
   default meegeeft. Daardoor tonen alle Site Options **meteen na
   activatie** de juiste waarde, zonder dat iemand ooit de instellingen-
   pagina hoeft te openen of op te slaan. Alle ~20 aanroepen door de hele
   theme die eerder hun eigen lege string (`''`) als default meegaven — wat
   dat automatische terugval-mechanisme blokkeerde — zijn aangepast om de
   parameter weg te laten.
2b. Ontbrekend geregistreerd veld `phone_intl` alsnog toegevoegd (werd al
   gebruikt in `inc/schema.php`, stond nooit in de veldenlijst — dus ook
   nooit zichtbaar of bewerkbaar in de instellingenpagina).

**"Verplichte save"-vraag, direct beantwoord:** die stap is er niet meer.
Gedocumenteerd in `README.md`: bewaren op **Instellingen → Site Options** is
alleen nog nodig om een waarde te *wijzigen* (bv. de echte postcode
invullen), niet om de defaults te laten verschijnen.

**Geverifieerd, live op de preview (uitgelogde bezoekersweergave):**

| Element | Vóór de fix | Na de fix |
| --- | --- | --- |
| Topbalk reviewbadge | leeg | "★★★★★ 4,8/5 · 87 beoordelingen" |
| Hero reviewbadge-pill | leeg | "★★★★★ 4,8/5 · 87 beoordelingen" |
| Topbalk telefoon/e-mail | leeg | "036-785 7028" / "info@spotlezz.nl" |
| Footer NAP | leeg | adres, openingstijden, KVK |
| JSON-LD `telephone` | ontbrak | `"+31367857028"` |
| JSON-LD `streetAddress` | ontbrak | `"Spinnakerplantsoen 38"` |
| JSON-LD `aggregateRating.ratingValue` | ontbrak | `"4.8"` |

**Kleine, niet-blokkerende opmerking gevonden tijdens het verifiëren:** de
footer-NAP-regel toont een dubbele spatie ("Spinnakerplantsoen 38,  Almere")
omdat de postcode bewust leeg is (nog niet bekend, zie `TE-CONTROLEREN.md`).
Cosmetisch, geen functioneel probleem, niet gefixt in deze ronde — pas
vanzelf zodra de echte postcode wordt ingevuld.

---

## Eindresultaten (gevraagde checklist)

| # | Check | Resultaat |
| --- | --- | --- |
| 1 | PHP-lint | **PASS** — 26/26 bestanden, geen syntaxfouten (inclusief na elke tussentijdse wijziging opnieuw gecontroleerd) |
| 2 | ACF-velddefinities | **PASS** — 8 tabs, 50 losse velden, 0 repeaters, geverifieerd in de echte admin-UI; de 2 relationship-velden tonen hun eerder opgeslagen selectie correct |
| 3 | Homepage-rendering | **PASS** — geen PHP-warnings/-notices/-fatals over de volledige sessie (installatie, thema-activatie, ACF-activatie, content aanmaken, alle viewport-tests) |
| 4 | 390px | **PASS** — `scrollWidth: 390`, 0 overflowende elementen |
| 5 | 430px | **PASS** — `scrollWidth: 430`, 0 overflowende elementen |
| 6 | 1440px | **PASS** — `scrollWidth: 1425` (= viewport − scrollbar), 0 overflowende elementen |
| 7 | Klik-test mobiele navigatie | **PASS** — open/dicht-cyclus met echte `.click()`-aanroepen geverifieerd, inclusief de gevonden en gefixte fallback-menu-bug |
| 8 | Reviewbadge na Site Options-save | **PASS**, met een sterkere uitkomst dan gevraagd — geen save meer nodig voor de defaults; wijzigen van een waarde werkt nog steeds via de instellingenpagina, geverifieerd door de onderliggende opslagfunctie te repareren i.p.v. alleen te documenteren |
| 9 | Geen horizontale overflow | **PASS** — zie 4-6, met de exacte oorzaak gevonden en gefixt (niet gemaskeerd) |

## WARNING (niet-blokkerend, ter info)

- Dubbele spatie in de footer-NAP zolang de postcode leeg is (zie §4) —
  cosmetisch, lost zichzelf op zodra de echte postcode bekend is.
- Kon geen pixel-screenshot maken exact op 390/430px: headless Chrome
  handhaaft op deze machine een minimumvenster van ~500px via
  `--window-size`, en de browserpaneel-tool kon in deze sessie niet
  screenshotten ("Browser pane is not displayed"). Geverifieerd is daarom
  met exacte DOM-metingen (CDP-viewport-emulatie, bevestigd kloppend
  `clientWidth`) in plaats van met een afbeelding — strenger dan een
  screenshot, maar geen visueel bewijs beschikbaar voor deze twee breedtes.
  Wel bijgevoegd: een echte 1440px-screenshot (`final-desktop-1440.png`).

Geen Phase 4C gestart. Wacht op goedkeuring.
