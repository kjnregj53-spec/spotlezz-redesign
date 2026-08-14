# Te controleren voordat dit live gaat

Deze lijst staat los van de techniek. Het zijn bedrijfsfeiten en teksten die ik
niet kan verifiëren en die Spotlezz zelf moet bevestigen of aanleveren.

## 1. Formulieren: endpoint invullen (blokkerend)

In `spotlezz.vercel.app/main.js` staat bovenaan:

```js
var FORM_ENDPOINT = '';
```

Zolang die leeg is, opent een verzonden formulier het mailprogramma van de
bezoeker met de aanvraag er voorgevuld in. Er gaat dus niets verloren, maar het
is geen nette conversie. Vul de URL in van de dienst die de aanvragen ontvangt
en test daarna één echte verzending per formuliertype.

De formulieren posten JSON met deze velden:

| Formulier | Velden |
| --- | --- |
| contact | `naam`, `bedrijf`, `email`, `telefoon`, `bericht`, `akkoord`, `_onderwerp`, `_pagina` |
| offerte | `dienst`, `oppervlakte`, `email`, `akkoord`, `_onderwerp`, `_pagina` |
| checklist | `email`, `akkoord`, `_onderwerp`, `_pagina` |

## 2. Prijs

De placeholder `€ xx/uur` stond live op alle dienst- en locatiepagina's. Die is
overal weggehaald. In plaats daarvan verwijst het antwoordblok naar
`/veelgestelde-vragen/wat-bepaalt-de-prijs-van-schoonmaak/`, waar de zes
prijsfactoren worden uitgelegd zonder een bedrag te noemen.

Zodra er een vanaf-tarief is dat Spotlezz kan waarmaken, kan dat alsnog als
vijfde tegel in het antwoordblok. Geef het door, dan zet ik het erin inclusief
`priceRange` in het Service-schema.

## 3. Namen van medewerkers

Op de nieuwe dienst- en locatiepagina's staat een blok "medewerker aan het
woord" met een naam, functie en citaat. Die zijn door mij ingevuld als
voorbeeld en **moeten vervangen worden door echte mensen** voordat de site live
gaat. Het gaat om:

| Pagina | Naam nu | Functie |
| --- | --- | --- |
| glasbewassing | Ramon de Vries | Glasbewasser, regio Almere |
| vloeronderhoud | Marek Nowak | Specialist vloeronderhoud |
| opleveringsschoonmaak | Stefan Bakker | Voorman opleveringen |
| hygieneservice | Fatima El Amrani | Coördinator hygiëneservice |
| locaties/almere (+ wijken) | Sanne Verhoeven | Teamleider Almere |
| locaties/lelystad | Dennis Kok | Teamleider Lelystad |
| locaties/amsterdam | Youssef Ait Bella | Teamleider Amsterdam |

Deze staan in `build/content-services.mjs` en `build/content-locations.mjs`.

## 3b. Postcode van de hoofdvestiging

Het adres staat nu overal als **Spinnakerplantsoen 38, Almere**, met KVK
42089069, en Almere is als hoofdvestiging aangemerkt. Wat nog ontbreekt is de
postcode. Die staat bewust nergens ingevuld in plaats van geraden.

Geef de postcode door, dan komt hij in `build/site.mjs` bij `SITE.address` en
verschijnt hij automatisch in het NAP-blok, de footer en het LocalBusiness-schema.

Controleer daarbij of de gegevens exact overeenkomen met het Google
Bedrijfsprofiel. Een NAP die op een teken afwijkt van het profiel kost lokale
zichtbaarheid.

## 4. LinkedIn-profielen en de portretfoto

De LinkedIn-links stonden op `#` en op het algemene `https://linkedin.com`. Die
zijn verwijderd in plaats van dat ze naar niets blijven wijzen. Lever de echte
profiel-URL's aan van Thirza en de contactpersonen, dan zet ik ze terug met
`sameAs` in het Person-schema.

Belangrijker: de foto die als portret van Thirza Mac Donald werd gebruikt was
`professional-cleaning.jpg`, hetzelfde generieke beeld dat elders op de pagina
als decoratie stond. Dat is nu vervangen door een initiaal-avatar. **Er is een
echte portretfoto nodig.** Een blok dat moet bewijzen dat er een mens achter het
bedrijf zit, met een stockfoto erin, doet precies het tegenovergestelde.

## 5. Lokale claims per stad

De locatieteksten noemen bedrijventerreinen, reistijden en werkwijzen per stad.
De geografie klopt, maar deze uitspraken moet Spotlezz bevestigen:

- "Vier teams in de regio" op de Almere-pagina
- Aanrijtijd onder 20 minuten binnen Almere
- Reistijd 30 minuten naar Lelystad en 45 minuten naar Amersfoort
- Vaste routedagen voor Lelystad, Amsterdam en Amersfoort
- Bij calamiteiten binnen twee uur ter plaatse in Almere
- Opzegtermijn van een maand (staat in de vergelijkingstabel en de FAQ)

## 6. Doorway-regel voor Amersfoort en de wijkpagina's

Op verzoek is de volledige locatielaag gebouwd: vier steden plus vier Almeerse
wijken. Elke pagina heeft eigen tekst, eigen bedrijventerreinen en eigen vragen,
dus het is geen zoek-en-vervang meer.

Wel het volgende: de wireframe stelt als eis dat een locatiepagina pas
gepubliceerd wordt bij minimaal drie van de vier vormen van lokaal bewijs, en
voor Amersfoort en de vier wijken is dat er nu niet. De review en de klantcase
op die pagina's komen uit een andere plaats. Zodra er een echte klant of case in
die plaats is, moet die daar staan. Tot die tijd is het risico dat Google deze
pagina's als dun beoordeelt.

Wil je dat risico niet lopen, dan kunnen de vier wijkpagina's en Amersfoort op
`noindex` tot er lokaal bewijs is. Dat is één regel per pagina.

## 7. Cijfers in de klantcases

De drie klantcases zijn qua opbouw compleet, maar de feitenbalk met vier harde
cijfers (vloeroppervlak, frequentie, producten, klachten) uit de wireframe kon
ik niet vullen. Zonder die cijfers blijft een case marketing in plaats van
bewijs. Lever per case aan:

- Vloeroppervlak in m²
- Frequentie per week
- Klant sinds welk jaar
- Een meetbaar resultaat

## 8. Blogartikelen

De blogpagina toont drie kaarten die nog geen artikel hebben. Op spotlezz.nl
staan vier echte artikelen. Die zijn nog niet overgezet omdat de wireframe de
blog buiten de structuur laat. De blog staat nu alleen in de footer en niet in
de hoofdnavigatie.

Keuze: overzetten van die vier artikelen, of de blog helemaal uitzetten. Nu is
het een halve hub.
