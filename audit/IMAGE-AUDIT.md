# Beeldaudit — static build vs. spotlezz.nl (bron)

Scope: visuele/technische controle van alle afbeeldingen in `spotlezz.vercel.app/`,
plus een vergelijking met wat er op de live productiesite `spotlezz.nl` staat.
Doel: vaststellen wat kapot is, wat semantisch fout gebruikt wordt, en waar
er al bruikbaar echt beeldmateriaal bestaat dat nog niet is meegenomen.

Geen enkele afbeelding is hierbij vervangen of gegenereerd — dit is alleen
inventarisatie, zoals afgesproken (echte foto's komen van de klant).

---

## 0. Technische status: geen gebroken links

Alle 31 unieke afbeeldingsverwijzingen in de site (`src`, `href`, CSS
`url()`) wijzen naar bestanden die daadwerkelijk bestaan in
`spotlezz.vercel.app/images/`. **Geen 404's.** Dat weerlegt de aanname
waarmee dit onderdeel begon (dat er "kapotte" afbeeldingen zouden zijn) —
het probleem zit niet in ontbrekende bestanden, maar in **verkeerd gebruik
van bestaande, overigens prima, foto's**.

Wel 14 ongebruikte bestanden op de schijf (orphans) — zie §3.

---

## 1. Grootste bevinding: drie klantcase-pagina's tonen nog een wireframe-placeholder als logo

Dit is geen wireframe meer, dit is de live site. Toch staat er op alle drie
de casepagina's een letterlijke placeholder-box in plaats van een logo:

| Pagina | Regel | Wat er nu staat |
| --- | --- | --- |
| `klantcases/kobelco/index.html` | 286 | `<div ...>LOGO Kobelco</div>` (gestippelde rand, geen afbeelding) |
| `klantcases/kuchentreff/index.html` | 286 | `<div ...>LOGO KuchenTreff</div>` |
| `klantcases/arena-gym/index.html` | 286 | `<div ...>LOGO Arena Gym</div>` |

**Goed nieuws: de echte logo's bestaan al op spotlezz.nl** en zijn zo naar
binnen te halen zodra dat gewenst is:

| Klant | Echte bron-URL op spotlezz.nl |
| --- | --- |
| Kobelco | `wp-content/uploads/2026/03/kobelcoimg.png` — geverifieerd, is het echte blauwe Kobelco-wordmark |
| KuchenTreff | `wp-content/uploads/2026/02/image-30.png` |
| Arena Gym | `wp-content/uploads/2026/02/image3.png` |

Dit is precies de derde blokkerende bevinding uit de oorspronkelijke audit
("wireframe-placeholders stonden live") — hij is dus niet overal opgelost,
op deze drie plekken staat hij nog.

---

## 2. Semantisch misbruik: echte foto's, verkeerde persoon

De drie generieke foto's die overal als "eigen fotografie" worden ingezet
zijn **echte, merk-gebrande Spotlezz-foto's** (personeel in Spotlezz-polo,
geen stock, geen AI) — dat is beter dan de eerdere audit aannam. Het
probleem is dat een paar van die foto's worden hergebruikt **als portret
van een specifieke, met naam genoemde persoon** die ze niet voorstellen:

- **Homepage, "Oprichter aan het woord" + Contact-sectie** tonen
  `/images/pand-interieur-schoon.jpg` als portret van **Thirza Mac
  Donder**. Dat is een echte foto — een medewerkster die een showroom-balie
  schoonmaakt — maar niet van Thirza. De naam en functietekst erbij maken
  er een verkeerde toeschrijving van, niet zomaar een "wat saai beeld."
- Diezelfde pagina's gebruiken ook `/images/materiaal-producten.jpg` als
  tweede Thirza-foto ("Thirza op locatie") — weer een echte, andere
  medewerkster, weer verkeerd toegeschreven.
- **Op spotlezz.nl bestaat een foto die er specifiek als portret uitziet**
  (rechtop, lachend naar de camera, kar met schoonmaakmateriaal op de
  achtergrond) op `wp-content/uploads/2026/02/professional-cleaning.jpg`.
  Die staat *niet* in de huidige `images/`-map. `build/build.mjs:111`
  herschrijft elke verwijzing naar dat bestand automatisch naar
  `/images/professionele-schoonmaak.jpg` (een heel andere foto, iemand die
  een bureau afneemt in een kantoor) — dus zelfs als de brontekst ooit naar
  de juiste foto verwees, wordt hij nu stilzwijgend vervangen.
  **Belangrijk: dit is niet bevestigd Thirza's foto** — alleen dat hij er
  qua compositie geschikt uitziet als portret. Voordat dit ergens als
  "Thirza" gebruikt wordt, moet de klant bevestigen wie er op staat.

**Advies, ongewijzigd t.o.v. het wireframe-advies:** zolang er geen
bevestigde foto van Thirza is, geen foto tonen (initiaal-avatar) in plaats
van een andere medewerkster onder haar naam te tonen.

---

## 3. Ongebruikte bestanden (orphans) — en wat ze onthullen

14 bestanden in `images/` worden nergens gerefereerd. De meeste zijn oude
versies die terecht vervangen zijn (bijvoorbeeld de branche-kaarten met
ingebakken tekst, `branche-kantoor.jpg` i.p.v. de schone
`branche-kantoor-schoon.jpg`). Twee zijn wel het melden waard:

- **`case-kobelco-schoon.jpg` wordt nergens gebruikt.** De Kobelco-case
  heeft dus geen eigen, herkenbare locatiefoto — hij hergebruikt generieke
  kantoorfoto's die ook op tien andere pagina's staan. Zelfde geldt
  waarschijnlijk voor KuchenTreff en Arena Gym; niet elk apart
  geverifieerd, maar het patroon (drie unieke case-schoon.jpg-bestanden,
  geen ervan gebruikt) is dat wel.
- **`kersvers.png` staat als ongebruikt bestand op de schijf.** Dat is
  consistent met de wireframe-bevinding dat kantoor-schoonmaak een niet-
  bestaande case "Kersvers" noemt: er is zelfs ooit een logo voor
  klaargezet, maar geen paginabuild ervoor gemaakt, en de tekstverwijzing
  bleef achter zonder het bijbehorende beeld.

---

## 4. Drie herkomstbewijzen die al bestaan maar nergens gebruikt worden

Bij het doorzoeken van spotlezz.nl bleek een reviewkarrousel met **zes**
klantlogo's plus sterrenscore te bestaan, niet drie. Kobelco, KuchenTreff en
Arena Gym hebben elk een volledige casepagina in de huidige build. De
andere drie hebben dat niet, terwijl hun logo's en (vermoedelijk) reviews
al op de bronsite staan:

| Klant | Logo op spotlezz.nl | Status in huidige build |
| --- | --- | --- |
| Burgman | `wp-content/uploads/2026/02/Group-1597880404.png` | Geen case, geen paginavermelding |
| Woonstudio Joy | `wp-content/uploads/2026/02/Mask-group.png` | Geen case, geen paginavermelding |
| Het Event Atelier | `wp-content/uploads/2026/02/Group-1597880406.png` | Geen case, geen paginavermelding |

Dit is dezelfde lijst van zes die wireframe-2 zelf noemt als "bewijs dat al
bestaat, het moet alleen worden uitgeschreven." Voor toekomstige uitbreiding
van de klantcase-laag (buiten scope van deze fase) is dit dus geen nieuw
fotografie-werk, alleen tekstwerk plus deze drie logo's ophalen.

---

## 5. Klantlogo's: al eerder gecorrigeerd, nu bevestigd correct

STATUS.md meldde dat vier klantlogo's eerder de verkeerde merknaam droegen
(bijv. `kobelco.png` was in werkelijkheid het Mitsubishi Heavy
Industries-logo). Die fix staat overeind: het foutieve bestand
(`kobelco.png`) staat nu als ongebruikte orphan op de schijf (zie §3), en de
huidige site gebruikt de correct hernoemde bestanden
(`klant-mitsubishi-heavy-industries.png` etc.). Geen actie nodig hier.

---

## Samenvatting: wat is er nu concreet te doen (zodra gewenst)

1. **Drie regels vervangen** (kobelco/kuchentreff/arena-gym case-pagina's,
   telkens regel 286): placeholder-`<div>` vervangen door `<img>` naar het
   echte logo. Bronbestanden staan al op spotlezz.nl, hierboven gelinkt.
2. **Thirza's foto niet vervangen zonder bevestiging.** Vraag de klant:
   is `professional-cleaning.jpg` op spotlezz.nl daadwerkelijk Thirza?
   Zo ja, dat bestand ontbreekt nu lokaal en moet alsnog opgehaald worden
   (`build.mjs:111` herschrijft hem momenteel weg — die regel moet dan ook
   aangepast of verwijderd worden).
3. Geen actie nodig op logo-namen van de zes ticker-klanten — die staan
   goed.
4. Voor een latere fase (niet nu): Burgman, Woonstudio Joy en Het Event
   Atelier hebben al logo's beschikbaar als de klantcase-laag ooit wordt
   uitgebreid van 3 naar 6 cases.
