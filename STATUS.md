# Status

Wat er is gedaan aan de Spotlezz-site, waarom, en hoe de wireframes zijn
vertaald naar code. Bedoeld als overdracht: wie dit leest weet daarna wat er
staat, welke keuzes zijn gemaakt en wat er nog open ligt.

Bijgewerkt: 15 augustus 2026
Branch: `fix/wireframe-implementatie`

---

## 1. Uitgangspunt

Het repo bevatte 24 losse HTML-bestanden zonder buildstap. Navigatie, head en
footer stonden in elk bestand opnieuw, met onderlinge verschillen. De site
draaide op `spotlezzzvercel.vercel.app` en haalde alle afbeeldingen van de
productie-WordPress op `spotlezz.nl`.

Voor de bouw is eerst een audit gedaan tegen de vijf wireframes en tegen de
gebruikelijke technische eisen. Dat leverde 64 bevindingen op: 6 blokkerend,
28 hoog, 30 middel.

De zes blokkerende:

1. Alle zes branchepagina's hadden een lege `<title>`.
2. Geen enkel formulier verzond iets. Geen `action`, geen `name` op de velden,
   geen submit-handler. Elke ingevulde offerte verdween.
3. Wireframe-placeholders stonden live: `€ xx/uur`, `EIGEN FOTO · HET PAND`,
   `Klantquote (groot)`, `Next-hop bar · exact 3 routes`.
4. Op mobiel was het document 830 pixels breed bij een viewport van 375.
5. `/reviews/` gaf 404 en werd vanaf de homepage en elke pillar gelinkt.
6. De vercel.app-omgeving was volledig indexeerbaar zonder canonical, terwijl de
   JSON-LD op diezelfde pagina's `spotlezz.nl` als identiteit opgaf.

---

## 2. Hoe de wireframes zijn gebruikt

De vijf wireframes zijn rij voor rij als bouwspecificatie gebruikt. Per
wireframe staat hieronder wat is overgenomen en waar bewust van is afgeweken.

### Wireframe 1: dienst detail (pillar)

Toegepast op tien pagina's: de zes bestaande branches en de vier nieuwe
specialismen.

| Rij | Wireframe | Status |
| --- | --- | --- |
| 1 | Navigatie, breadcrumb, reviewscore, telefoonnummer | Gebouwd |
| 2 | Hero met zoekwoord in H1, snelofferte ernaast | Gebouwd, formulier staat sticky in de rechterkolom |
| 3 | Antwoordblok van 40 tot 60 woorden plus vier feiten | Gebouwd, met afwijking op de prijstegel, zie hieronder |
| 4 | Werkzaamheden als raster, elk blok linkt naar een dienst-pillar | Gebouwd |
| 5 | Werkwijze in vier stappen, vergelijkingstabel, CTA eronder | Gebouwd |
| 6 | Drie eigen foto's | Gebouwd, beeld nog niet locatie-eigen |
| 7 | Reviewblok met AggregateRating | Gebouwd |
| 8 | Medewerker aan het woord met foto, LinkedIn en Person-schema | Structuur gebouwd, namen zijn voorbeelden |
| 9 | Klantcases, exact twee | Gebouwd |
| 10 | Regioblok met pills naar de locatiepagina's | Gebouwd |
| 11 | FAQ-sectie van vijf tot acht vragen met FAQPage | Gebouwd |
| 12 | Next-hop bar met exact drie routes | Gebouwd |

**Afwijking op rij 3.** De wireframe vraagt een vanafprijs. Die is er niet, en
een bedrag verzinnen dat Spotlezz niet kan waarmaken is erger dan geen bedrag.
De tegel is vervangen door een verwijzing naar
`/veelgestelde-vragen/wat-bepaalt-de-prijs-van-schoonmaak/`, waar de zes
prijsfactoren uit wireframe 3 worden uitgelegd. Zodra er een tarief is, kan het
er alsnog in, inclusief `priceRange` in het Service-schema.

### Wireframe 2: klantcase

Toegepast op drie pagina's: Kobelco, KuchenTreff en Arena Gym.

Alle zeven rijen zijn gebouwd: hero met klantlogo en resultaatzin, STAR-indeling,
grote klantquote met gezicht en functie, gebruikte diensten die omhoog linken
naar de pillars, en de next-hop bar.

**Openstaand.** De feitenbalk van rij 3 vraagt vier harde cijfers per case
(vloeroppervlak, frequentie, producten, klachten). Die cijfers zijn er niet. De
balk staat er wel, maar zolang hij niet gevuld is blijft een case marketing in
plaats van bewijs. Zie `build/TE-CONTROLEREN.md`, punt 7.

### Wireframe 3: FAQ hub en detail

De hub telt 25 vragen, gegroepeerd per thema, met zoekveld en filters. Drie
vragen met eigen zoekvolume hebben een detailpagina gekregen:

- `wat-bepaalt-de-prijs-van-schoonmaak`
- `hoe-vaak-moet-een-kantoor-schoongemaakt-worden`
- `hoe-kies-je-een-schoonmaakbedrijf`

De rest blijft accordion op de hub, precies zoals de wireframe voorschrijft:
een eigen pagina alleen bij aantoonbaar zoekvolume.

**Keuze op rij 5.** De wireframe biedt twee conversievarianten: een
e-mailmagneet of een vanafprijs per m² met disclaimer. Variant A is gekozen,
omdat variant B een bedrag vereist dat er niet is. De bezoeker vult oppervlakte
en dienst in en krijgt de indicatie per mail.

Dit lost meteen de ergste pogo-trigger op de oude site op. Daar werd
"Wat kost schoonmaak per uur?" beantwoord met "Neem contact met ons op voor een
offerte op maat", wat precies de bezoeker wegstuurt die de vraag stelde.

### Wireframe 4: locatiepagina

Toegepast op acht pagina's: vier steden (Almere, Lelystad, Amsterdam,
Amersfoort) en vier Almeerse wijken (Stad, Buiten, Haven, Poort).

Alle elf rijen zijn gebouwd, inclusief het NAP-blok met LocalBusiness-schema,
het lokale bewijsblok, de top drie diensten per stad, het unieke
werkgebiedblok, de lokale FAQ en de locatiecarrousel.

**De belangrijkste inhoudelijke ingreep.** De drie oude locatiepagina's waren
woord voor woord identiek, alleen de stadsnaam verschilde. Gemeten kwamen ze op
100 procent overeen, bij 332 woorden per pagina tegenover de 800 tot 1200 die
de wireframe eist. Dat is exact het doorway-patroon dat de wireframe verbiedt.

Elke pagina heeft nu eigen tekst met eigen bedrijventerreinen, eigen reistijden
en eigen vragen. De Almere-pagina noemt Gooisekant, De Vaart en Veluwsekant, de
Amersfoort-pagina noemt De Hoef, Calveen, Vathorst en De Isselt, enzovoort.

**Openstaand risico.** De wireframe stelt dat een locatiepagina pas gepubliceerd
wordt bij minimaal drie van de vier vormen van lokaal bewijs. Voor Amersfoort en
de vier wijken is dat er niet: de review en de case op die pagina's komen uit een
andere plaats. Op verzoek is de volledige laag toch gebouwd. Wil je het risico
op een dun-oordeel niet lopen, dan kunnen die vijf pagina's op `noindex` tot er
lokaal bewijs is. Dat is een regel per pagina.

### Wireframe 5: homepage

Alle twaalf rijen zijn gebouwd. De H1 was al geoptimaliseerd voor het
hoofdzoekwoord met het merk in de H2 eronder, dus dat kon blijven staan.

**De grootste structurele winst zat in rij 4.** Het dienstenblok toont twee
assen: branche en dienst. De vier tegels van de dienst-as (glasbewassing,
vloeronderhoud, opleveringsschoonmaak, hygiëneservice) waren geen links en de
pagina's bestonden niet. Daardoor scoorde de site op geen van die termen. Die
vier pagina's zijn nu gebouwd volgens wireframe 1 en de tegels linken erheen.

Op spotlezz.nl bestaan wel `/sectoren/`-pagina's met die namen, maar die bleken
alle zes identieke kopieën van de kinderopvangpagina, met dezelfde H1
"Professionele kinderopvang schoonmaak" en dezelfde 1911 woorden. Er viel dus
niets over te zetten. De teksten zijn nieuw geschreven. Er staan wel 301's van
de oude sectoren-URL's naar de nieuwe dienstpagina's.

### De drie pogo-regels

Deze staan onderaan elke wireframe en zijn overal toegepast:

1. **Intent-match binnen vijf seconden.** Boven de vouw staan het zoekwoord,
   de regio, de reviewscore en de reactietijd.
2. **Volledigheid op de pagina zelf.** Frequentie, regio en reactietijd worden
   op de pagina beantwoord. Prijs is de uitzondering, zie hierboven.
3. **Gestuurde volgende hop.** Alle 37 pagina's hebben precies één next-hop bar
   met exact drie routes: omhoog, zijwaarts, conversie.

---

## 3. Wat er nu staat

37 pagina's, tegen 24 aan het begin.

```
/                                    homepage
/diensten/                           hub
  kantoor, hotel, showroom,          zes branches (bestond al)
  fitnesscentrum, kinderopvang, vve
  glasbewassing, vloeronderhoud,     vier specialismen (nieuw)
  opleveringsschoonmaak, hygieneservice
/klantcases/                         hub + drie cases
/locaties/                           hub (nieuw)
  almere, lelystad, amsterdam,       vier steden
  amersfoort
  almere-stad, -buiten, -haven,      vier wijken (nieuw)
  -poort
/veelgestelde-vragen/                hub met 25 vragen + drie detailpagina's
/reviews/                            nieuw, gaf eerst 404
/offerte-aanvragen/                  verplaatst vanaf /quote/
/over-ons/ /contact/ /checklist/
/blog/ /vacatures/ /privacybeleid/
```

### Techniek

De HTML wordt gegenereerd door `build/` en is gecommit. Vercel serveert dus
gewoon bestanden en draait geen build. Dat is bewust: de gedeelde onderdelen
stonden in 24 bestanden los van elkaar en liepen uiteen, en met 37 pagina's is
dat met de hand niet meer bij te houden.

Wat de build oplost:

- Eén head, navigatie, breadcrumb, next-hop en footer voor alle pagina's.
- Alle interne links root-relatief. Dat sloot in één keer elf bevindingen,
  waaronder de zes kapotte links op de FAQ-hub en de footerlinks die op de
  locatiepagina's naar `/locaties/blog/` wezen.
- Titel, beschrijving, canonical, Open Graph en JSON-LD per pagina.
- `sitemap.xml` en `robots.txt`, beide ontbraken.

In `vercel.json` staan 16 redirects (waaronder `/quote/` naar
`/offerte-aanvragen/` en `/contact-us/` naar `/contact/`), `cleanUrls`, en een
`X-Robots-Tag: noindex` die alleen op `*.vercel.app` geldt. Het productiedomein
wordt gewoon geïndexeerd.

### Schema

`Organization`, `LocalBusiness` van het type `CleaningService`, `Service`,
`FAQPage`, `QAPage`, `Article`, `Review`, `AggregateRating`, `Person` en
`BreadcrumbList`. De FAQ-markup wordt gegenereerd uit de vragen die op de pagina
staan, zodat de twee niet meer uit elkaar kunnen lopen. Op de oude homepage
stonden twee vragen in de markup terwijl er twintig zichtbaar waren, en geen van
die twee kwam letterlijk op de pagina voor.

---

## 4. Beeldmateriaal

Hier zat een probleem dat ik eerst verkeerd heb beoordeeld, dus dat staat er
expliciet bij.

Op screenshots was te zien dat branchekaarten hun opschrift dubbel toonden. Ik
concludeerde eerst dat dit een artefact van de schermafdruk was, omdat de DOM
maar één label bevatte. Dat klopte niet. **De tekst zat in de JPEG gebrand.**

De zes `sr`-bestanden van spotlezz.nl zijn geen foto's maar voorgerenderde
branchekaarten, met opschrift, pijl-icoon, gradient en afgeronde hoeken in de
pixels. In het branchegrid is dat precies goed. Overal daarbuiten niet, en ze
stonden op ruim zestig plekken:

- De homepage-hero toonde "Showroom schoonmaak".
- De Kobelco-case, een industrieel hoofdkantoor, toonde "Showroom schoonmaak".
- De KuchenTreff-case, een keukenshowroom, toonde "Hotel schoonmaak".
- De Arena Gym-case, een sportschool, toonde "Kinderopvang schoonmaak".

`build/prepare-images.ps1` snijdt tekst, gradient en hoeken weg en levert zeven
schone varianten. De originelen blijven staan voor het grid. Beeld wordt nu per
rol gekozen in plaats van per bestandsnaam, dus elke case krijgt de branche van
die klant.

Twee dingen kwamen bij dezelfde controle boven water:

**Geen van de vier klantlogo's had de juiste naam**, en die verkeerde naam stond
ook in de alt-tekst. `kobelco.png` is het logo van Mitsubishi Heavy Industries,
`floor.png` is ARENAGYM, `kersvers.png` is Mitsubishi Logisnext Europe en
`logisnext.png` is Innovally. Je noemde je klanten dus verkeerd tegen
schermlezers en zoekmachines. Alles staat nu onder de werkelijke merknaam.

**Een klantlogo werd als pasfoto gebruikt.** Bij het medewerkerscitaat op de zes
branchepagina's stond het ALLIANCE-logo in een ronde uitsnede van 50 pixels, en
op `/over-ons/` het Spotlezz-logo zelf. Vervangen door een neutrale initiaal tot
er echte portretten zijn.

Verder was `og:image` een staand portret van 984x1528 dat in elke deelkaart
onherkenbaar werd bijgesneden. Nu een uitsnede van 1.91:1.

---

## 5. Beslissingen die zijn genomen

| Vraag | Keuze |
| --- | --- |
| Vanafprijs | Tegel weg, verwijzing naar de uitleg van de prijsfactoren |
| Formulieren | Endpoint wordt aangeleverd, tot die tijd een mailto-terugval |
| Nieuwe dienst-pillars | Teksten nu geschreven, worden later vervangen |
| Locatielaag | Volledig gebouwd: vier steden plus vier wijken |

---

## 6. Wat nog open ligt

De volledige lijst staat in [`build/TE-CONTROLEREN.md`](build/TE-CONTROLEREN.md).
De twee die livegang blokkeren:

1. **`FORM_ENDPOINT` in `build/main.js` is leeg.** Formulieren openen nu het
   mailprogramma met de aanvraag voorgevuld, dus er gaat niets verloren, maar het
   is geen nette conversie.
2. **De namen bij de medewerkerscitaten zijn door mij verzonnen als voorbeeld.**
   Zeven stuks, op de dienst- en locatiepagina's. Die moeten weg of vervangen
   worden door echte mensen voordat dit publiek gaat.

Daarnaast vraagt een aantal dingen echte fotografie: een portret van Thirza,
portretten van de medewerkers, en lokaal beeld per stad. Een blok dat moet
bewijzen dat er mensen achter het bedrijf zitten werkt averechts met een
generieke foto erin.

---

## 7. Commits

```
64121f7  Haal de ingebakken opschriften uit de foto's en zet elk beeld op de juiste rol
7001a01  Rustiger reveal-animatie en geen caching in de dev-server
21f12c4  Herstel lege secties, afgeknipte tekst en het bedrijfsadres
9f884c1  Gebruik de 1024-variant voor materiaal-producten.jpg
944d2f5  Implementeer wireframes en herstel de 64 auditbevindingen
```

Bij de laatste build gecontroleerd over alle 37 pagina's: geen verwijzingen meer
naar een foto met ingebakken tekst of naar een oude logonaam, 283 afbeeldingen
zonder ontbrekende bestanden, en op 375 en 1280 pixels geen horizontale overflow,
geen onzichtbare secties en overal precies één next-hop bar.
