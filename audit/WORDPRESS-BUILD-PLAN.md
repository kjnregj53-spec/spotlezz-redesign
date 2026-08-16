# Bouwplan fase 3 → 4: van wireframe naar custom WordPress-theme

Dit document sluit fase 3 af (de technische beslissing) en legt vast wat de
custom theme + ACF-implementatie (fase 4) precies moet bevatten. Het bouwt
op de vijf FINAL-wireframes en de twee audit-rapporten
(`WIREFRAME-AUDIT.md`, `IMAGE-AUDIT.md`). Er is nog geen theme-code
geschreven — dit is de blauwdruk waarmee dat straks in één keer goed kan.

---

## 1. Uitgangspunt: wat de klant wel en niet mag bewerken

Zoals afgesproken: de klant bewerkt **tekst en afbeeldingen**, niets anders.
Dat vertaalt zich naar een harde regel voor de theme-bouw:

- **ACF-velden** = tekst en afbeeldingen die per pagina kunnen verschillen
  (een H1, een quote, een foto, een cijfer).
- **Theme-code, geen ACF-veld** = alles wat structuur, volgorde, styling of
  interne links bepaalt (de navigatie, de next-hop bar, welke pagina's naar
  welke andere pagina's linken, de schema-output).
- **Relationship-velden, geen los tekstveld**, overal waar de wireframes
  "linkt naar" zeggen. Dat is een bewuste keuze om de kapotte links uit de
  huidige static build (zie §3) structureel onmogelijk te maken: een
  redacteur kan geen tekst "Kersvers" typen die nergens naartoe wijst, want
  hij kan alleen een bestaande case *selecteren* uit een lijst van
  bestaande cases.

---

## 2. Content-modellen (custom post types)

| Post type | Komt overeen met | Aantal nu |
| --- | --- | --- |
| `pillar` | dienst-detailpagina (branche + dienst) | 10 |
| `case` | klantcase | 3 (+3 potentieel, zie IMAGE-AUDIT §4) |
| `locatie` | locatiepagina (stad of wijk) | 8 |
| `vraag` | FAQ-item (hub-accordion of eigen detailpagina) | 25 |
| Taxonomie `thema` | FAQ-thema (Kosten, Werkwijze, Kwaliteit, ...) | — |
| Taxonomie `branche` | koppelt cases/pillars aan een sector | — |

Vaste pagina's (homepage, over-ons, contact, offerte-aanvragen) blijven
gewone WordPress-pagina's met hun eigen ACF-veldgroep.

---

## 3. Velden per paginatype

### 3.1 Homepage (wireframe-5-homepage-FINAL)

| Sectie | Veldtype | Notitie |
| --- | --- | --- |
| Hero kicker + H1 + H2 | tekst | H1 blijft vast "Schoonmaakbedrijf in Almere" tenzij bewust gewijzigd — overweeg dit te vergrendelen, niet vrij bewerkbaar, want het is de kern van de SEO-strategie |
| Hero foto | afbeelding | **APPROVED:** full-bleed achtergrond, zoals de huidige bouw — bevestigde bedrijfseis, niet vervangen door de split-teamfoto-layout uit het oorspronkelijke wireframe. De implementatie moet de compositie, leesbaarheid, hiërarchie en het responsive gedrag van dit full-bleed concept verbeteren, niet het concept zelf wijzigen. Zie §5.1. |
| Antwoordblok (4 stats) | 4× tekst (label + waarde) | |
| Dienstenblok (10 tegels) | **geen ACF** | automatisch gegenereerd: alle gepubliceerde `pillar`-posts, gegroepeerd op branche/dienst-taxonomie. Voorkomt dat een tegel ooit zonder link kan staan. |
| Werkgebied (8 pills) | **geen ACF** | automatisch: alle gepubliceerde `locatie`-posts |
| Eigen fotografie (3) | 3× afbeelding + alt-tekst | |
| Reviewblok | relationship (3× review) | uit een `review`-repeater in Opties, of eigen CPT als het er meer dan ~10 worden |
| Klantcases (3) | relationship (3× case) | **APPROVED:** scope blijft vast op de drie bestaande cases (Kobelco, KuchenTreff, Arena Gym). Dropdown toont alleen bestaande, gepubliceerde cases; het contentmodel ondersteunt uitbreiding naar meer cases later, maar dat wordt nu niet gebouwd. Zie §5.3. |
| Oprichter | tekst (naam, functie, quote) + afbeelding + URL (LinkedIn) | **APPROVED:** portretveld verplicht aanwezig in de theme, maar gevuld met een gedocumenteerde tijdelijke placeholder (initiaal-avatar) totdat de klant expliciet bevestigt dat `professional-cleaning.jpg` (of een andere foto) Thirza voorstelt. Nooit een andere, niet-bevestigde medewerkersfoto onder haar naam tonen. Zie §5.2. |
| FAQ (5) | relationship (5× vraag) | |
| Lead magnet | tekst (titel, beschrijving) — **precies één instantie**, geen los tweede CTA-blok toegestaan | |
| Next-hop bar | **geen ACF** | vast: omhoog → /diensten/, zijwaarts → /klantcases/ + /locaties/, conversie → /offerte-aanvragen/ |

### 3.2 Dienst-pillar (wireframe-1-dienst-detail-FINAL)

| Sectie | Veldtype | Notitie |
| --- | --- | --- |
| H1 + intro | tekst | moet zoekwoord + regio bevatten (redactionele richtlijn, niet technisch afdwingbaar) |
| USP-pills (3) | repeater tekst | |
| Antwoordblok | tekst (40-60 wrd) + 4 stats | prijs-stat blijft een link naar de FAQ-detailpagina, geen bedrag |
| Werkzaamheden-raster | repeater (label + optionele relationship naar andere pillar) | |
| Werkwijze 4 stappen + vergelijkingstabel | **Site Options, niet per pillar** | deze tekst is nu al identiek op elke pillar-pagina; geen reden om hem 10× los bewerkbaar te maken |
| 3 foto's | 3× afbeelding + alt | |
| Reviews (3) | relationship | |
| Medewerker | tekst (naam, functie, quote) + afbeelding + URL (LinkedIn) | **verplicht veld, geen lege staat toegestaan in productie** — genereert automatisch een `Person`-schema-node; dit repareert de audit-bevinding dat medewerkers nu geen schema hebben |
| Klantcases (exact 2) | relationship, dropdown = alleen bestaande cases | repareert de "Kersvers"-bug structureel |
| Regioblok (8 pills) | **geen ACF** | automatisch alle `locatie`-posts, altijd een echte link |
| FAQ (5-8) | relationship | |
| Next-hop | **geen ACF** | vast per type: omhoog → /diensten/, zijwaarts → gekoppelde case, conversie → offerte |

### 3.3 Klantcase (wireframe-2-klantcase-FINAL)

| Sectie | Veldtype | Notitie |
| --- | --- | --- |
| Klantlogo | afbeelding | verplicht veld — voorkomt de "LOGO Kobelco"-placeholder die nu op alle 3 casepagina's live staat (zie IMAGE-AUDIT §1) |
| H1 (resultaatzin) | **één tekstveld, hergebruikt voor zowel de zichtbare H1 als `Article.headline` in de schema** | repareert de audit-bevinding dat deze twee nu uit elkaar liepen op Kobelco |
| Branche / locatie / klant sinds | 3× tekst | |
| Hero-foto | afbeelding | |
| Feitenbalk (4 cijfers) | 4× tekst | verplicht voordat een case gepubliceerd wordt — anders blijft het marketing i.p.v. bewijs, zoals de wireframe zelf stelt |
| STAR (4 blokken) | 4× WYSIWYG/textarea | |
| Klantquote | tekst + naam + functie + afbeelding + URL (LinkedIn) | |
| Gebruikte diensten | relationship (1-3× pillar) | dropdown = alleen bestaande pillars, repareert de dode links naar `/diensten/` |
| Next-hop | **geen ACF** | vast: omhoog → gekoppelde pillar, zijwaarts → volgende case + locatiepagina, conversie → offerte |

### 3.4 Locatiepagina (wireframe-4-locatiepagina-FINAL)

| Sectie | Veldtype | Notitie |
| --- | --- | --- |
| Stad/wijk naam | tekst | H1 auto = "Schoonmaakbedrijf {naam}" |
| Kaart | afbeelding of embed | |
| NAP-blok | **geen ACF, Site Options** | adres/telefoon/openingstijden komen uit één centrale bron, nooit per locatiepagina los ingevoerd — voorkomt NAP-afwijkingen tussen pagina's |
| Antwoordblok | 4× tekst | |
| **Lokaal bewijs** | relationship: min. 3 klantlogo's + 1 lokale case + 1 lokale review, elk gefilterd op deze stad | **APPROVED, publicatie-gate:** als deze drie niet allemaal gevuld zijn, blijft de pagina concept/`noindex` — geen uitzondering, ook niet voor Almere zelf. Dit is de belangrijkste regel uit de hele wireframe-set en wordt in de theme technisch afgedwongen (niet alleen als redactionele afspraak). Zie §5.4. |
| Diensten top 3 | relationship (3× pillar) | |
| Wijken | **geen ACF** | automatisch: child-`locatie`-posts |
| Werkgebied-tekst | WYSIWYG, min. 500 woorden | redactionele richtlijn, niet technisch afdwingbaar — wel een woordenteller in de admin-UI is aan te raden |
| 3 foto's | 3× afbeelding + alt | |
| Lokaal team | tekst + afbeelding + URL (LinkedIn) | |
| Lokale FAQ (3-5) | relationship | |
| Andere locaties | **geen ACF** | automatisch alle overige `locatie`-posts |
| Next-hop | **geen ACF** | vast |

### 3.5 FAQ hub + detail (wireframe-3-faq-FINAL)

| Sectie | Veldtype | Notitie |
| --- | --- | --- |
| Hub | **geen ACF** | automatisch gegenereerd uit alle `vraag`-posts, gegroepeerd op `thema`-taxonomie, met een clientside zoekveld |
| Vraag (titel) | tekst | |
| Kort antwoord (40-60 wrd) | tekst | |
| Verdieping (optioneel) | WYSIWYG + optionele 6-factor-repeater + foto | alleen gebruikt op de vragen met een eigen detailpagina |
| **Conversieblok** | **vast theme-component, geen los ACF-veld** | Variant A (m² + frequentie + branche → indicatie per mail) — één herbruikbare component, zodat er nooit meer een generiek contactformulier verschijnt waar de calculator hoort te staan (zie WIREFRAME-AUDIT §4) |
| Gerelateerde pillar | relationship, **exact 1** | |
| Next-hop | **geen ACF** | vast |

### 3.6 Site Options (één keer, geldt overal)

NAP-gegevens, telefoonnummer, reviewscore + aantal, `FORM_ENDPOINT`,
werkwijze-4-stappen, vergelijkingstabel Spotlezz-vs-anderen,
social/LinkedIn van de oprichter.

---

## 4. Checklist: bugs die de nieuwe theme NIET mag overerven

Verzameld uit `WIREFRAME-AUDIT.md` en `IMAGE-AUDIT.md`. Dit is geen
losstaand werk — de veldstructuur in §3 lost de meeste hiervan al
structureel op. Deze lijst is de acceptatietoets voordat fase 4 als klaar
geldt.

- [ ] **Geen dubbele chrome.** Header/footer/skip-link/`<main>` worden
      precies één keer per pagina gerenderd. (Was: 18 van 37 pagina's met
      4-5× dubbele `<main>`-tags — ontstond doordat de oude build-scripts
      chrome injecteerden zonder te checken of hij al bestond. In een
      theme met `get_header()`/`get_footer()` kan dit alleen nog gebeuren
      door een verkeerde template-include — expliciet op testen.)
- [ ] **Precies één next-hop bar per pagina, exact 3 routes**, altijd
      via het vaste theme-component uit §3, nooit los content-blok.
- [ ] **Geen enkele link naar een niet-bestaande post.** Afgedwongen door
      relationship-velden i.p.v. vrije tekst (zie "Kersvers"-case en de
      case→pillar dead links op Kobelco).
- [ ] **Geen tegel/pill zonder `href`.** Dienstenblok, werkgebied-pills en
      regioblok zijn altijd automatisch gegenereerde links (§3.1, §3.2),
      nooit statische tekst.
- [ ] **Elke medewerker/oprichter met een gevuld naam-veld genereert een
      `Person`-schema-node.** Geen persoon zonder schema, geen schema
      zonder zichtbare persoon.
- [ ] **H1 en schema-headline komen uit hetzelfde veld**, nooit twee
      aparte teksten die uit elkaar kunnen lopen (case-pagina's).
- [ ] **Klantlogo is een verplicht afbeeldingsveld op case-posts** — geen
      placeholder-`<div>` met tekst "LOGO [Klant]" kan meer live gaan,
      want zonder gevuld logo-veld publiceert de post niet compleet.
- [ ] **Locatiepagina met onvolledig "lokaal bewijs"-blok blijft
      concept/noindex** tot minimaal 3 van de 4 bewijsvormen gevuld zijn.
- [ ] **FAQ-conversieblok is de echte Variant-A-calculator**, geen
      generiek contactformulier.
- [ ] **Sterrenrating en andere speciale tekens worden via een
      icon-font of HTML-entity gerenderd, nooit als rauw UTF-8-teken in
      de database** — voorkomt de `â˜…â˜…â˜…â˜…â˜…`-mojibake die nu in de
      locatiepagina's zit.
- [ ] **NAP-gegevens komen uit Site Options, nooit per pagina
      overgetypt** — voorkomt toekomstige NAP-afwijkingen tussen
      pagina's en het Google Bedrijfsprofiel.

---

## 5. Beslissingen (goedgekeurd)

Status: **APPROVED**. Vastgelegd zodat fase 4 hier niet opnieuw over hoeft
te beslissen of op hoeft te wachten.

### 5.1 Homepage hero — APPROVED

**Besluit:** full-bleed achtergrond-hero, zoals de huidige bouw. Dit is een
bevestigde bedrijfseis. De split-layout met een eigen teamfoto naast de H1
(het oorspronkelijke wireframe-voorstel) wordt **niet** gebouwd.

**Wat dit voor de implementatie betekent:** het full-bleed concept blijft
staan, maar de uitvoering ervan moet verbeteren t.o.v. de huidige bouw op:
- **Compositie** — het beeld moet de tekst niet verdrukken; focal point en
  overlay-contrast zijn onderdeel van de theme-implementatie.
- **Leesbaarheid** — kicker, H1, H2 en de twee CTA's moeten op elke
  achtergrondfoto voldoende contrast houden (theme-niveau, niet per foto
  handmatig bij te stellen).
- **Hiërarchie** — dezelfde volgorde als nu (kicker → H1 → H2 → CTA's →
  reviewscore), maar met duidelijkere visuele gewichtsverdeling.
- **Responsive gedrag** — expliciet toetsen op mobiel: de huidige bouw is
  hier nog niet apart op gecontroleerd.

Dit blijft binnen "verbeter de compositie", niet "verander het concept" —
dus geen visueel herontwerp op dit moment, alleen een uitvoeringsrichtlijn
voor wanneer fase 4 dit blok bouwt.

### 5.2 Thirza's portret — APPROVED

**Besluit:** `professional-cleaning.jpg` wordt **niet** gebruikt als
Thirza's portret tenzij de klant expliciet bevestigt dat zij op die foto
staat. Tot die bevestiging er is, krijgt het oprichter-blok een duidelijk
gedocumenteerde tijdelijke placeholder (bijv. een initiaal-avatar) in
plaats van een niet-bevestigde of verkeerd toegeschreven medewerkersfoto —
zoals nu het geval is met `pand-interieur-schoon.jpg` en
`materiaal-producten.jpg` op de homepage (zie IMAGE-AUDIT §2).

**Wat dit voor de implementatie betekent:** het portretveld in de
oprichter-veldgroep (§3.1, §3.2) is verplicht aanwezig in de theme-structuur,
maar mag in fase 4 met een placeholder-waarde opgeleverd worden. Dit blokkeert
de bouw niet — zie §6.

### 5.3 Klantcase-scope — APPROVED

**Besluit:** scope blijft op de drie bestaande, gepubliceerde cases
(Kobelco, KuchenTreff, Arena Gym). Geen uitbreiding naar Burgman, Woonstudio
Joy of Het Event Atelier in deze fase, ook al zijn hun logo's al beschikbaar
(IMAGE-AUDIT §4). Het `case`-contentmodel (§2, §3.3) ondersteunt uitbreiding
zonder herontwerp, mocht dat in een latere fase alsnog gewenst zijn.

### 5.4 Locatiepagina's zonder lokaal bewijs — APPROVED

**Besluit:** een locatiepagina zonder voldoende lokaal bewijs (minimaal 3
van de 4 vormen — klantlogo's, lokale case, lokale review, lokaal team) mag
niet indexeerbaar zijn. Dit blijft concept/`noindex` tot het bewijs er is —
geen uitzondering voor Amersfoort, de vier Almeerse wijken, of enige andere
pagina, inclusief Almere zelf zolang het logo-blok daar ontbreekt (zie
WIREFRAME-AUDIT §5, IMAGE-AUDIT-bevinding op locatiepagina's).

**Wat dit voor de implementatie betekent:** dit is geen redactionele
afspraak maar een technische publicatie-gate in de theme (§3.4, §4) — de
pagina kan simpelweg niet op "gepubliceerd + indexeerbaar" staan zonder dat
de drie velden gevuld zijn.

---

## 6. Volgorde vanaf hier

**Belangrijk:** echte klantfotografie blokkeert fase 4 niet. De theme wordt
gebouwd met de hierboven afgesproken tijdelijke, gedocumenteerde
placeholders (met name §5.2) en de echte assets worden later verwisseld
zodra ze binnenkomen — dat is een contentwissel, geen nieuwe bouwronde.

1. Fase 4 start nu: custom theme + ACF-veldgroepen exact zoals in §3,
   met de checklist in §4 als acceptatietoets per paginatype, en de vier
   besluiten uit §5 als vaste kaders (niet als aannames).
2. Zodra echte foto's binnenkomen: contentwissel in de bestaande velden,
   geen theme-wijziging nodig.
3. Fase 5: QA tegen dezelfde checklist, plus de originele
   pogo-stick-regels uit elke wireframe, op alle uiteindelijke pagina's.
