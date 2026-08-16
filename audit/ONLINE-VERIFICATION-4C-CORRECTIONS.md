# Verificatie van de aangeleverde bevindingen — wat klopt, wat niet

De vorige boodschap bevatte een lijst "bevindingen" met bronvermeldingen
die eruitzagen als AI-gegenereerde citaten (`utm_source=chatgpt.com` in
elke link). Dat soort citaten is onbetrouwbaar gebleken in andere
projecten — ze wijzen soms naar een echte pagina maar beschrijven de
inhoud verkeerd. Daarom is elk punt hieronder **zelf opnieuw bezocht en
gecontroleerd** in de browser voordat er iets aan de documentatie is
toegevoegd of gewijzigd.

---

## Bevestigd — klopt, met een eigen bron

### Amsterdam en Lelystad: echte, actuele werkgebieden

Op `spotlezz.nl/over-ons-1/` staat letterlijk:

> "Spotlezz ontstond in Almere, maar inmiddels verzorgen wij
> bedrijfsschoonmaak bij verschillende bedrijven in Amsterdam en
> Lelystad."

Dit is een directe, ondubbelzinnige bevestiging — geen interpretatie
nodig. **Amsterdam en Lelystad mogen als echte, actieve locatie-posts
behandeld worden**, niet als speculatieve uitbreiding.

### Glasbewassing en Vloeronderhoud: echte, bestaande diensten

Dezelfde pagina, in de tijdlijn bij 2024:

> "We breidden onze diensten uit naar schoonmaakonderhoud,
> **glasbewassing**, gevelreiniging, **vloeronderhoud** & levering van
> sanitaire gebruiksartikelen."

Bevestigd. **Bonus, niet eerder opgemerkt: "Gevelreiniging"
(gevelreiniging/facade-cleaning) wordt hier ook genoemd als bestaande
dienst** — die staat nog niet als pillar-post in het theme. Geen actie
nu, wel de moeite waard om aan de klant voor te leggen als mogelijke 11e
pillar in een latere contentronde.

---

## Niet bevestigd — het aangeleverde bericht had dit fout of onbewezen

### "Het Gooi" — nergens gevonden

Op `over-ons-1/` (dezelfde pagina die Amsterdam/Lelystad noemt) komt de
tekst "Het Gooi" **niet voor** — expliciet gecontroleerd met een
tekstzoekopdracht op de volledige paginatekst. Een Google-`site:`-zoekopdracht
om dit site-breed te checken werd geblokkeerd door Google's
bot-detectie (terecht niet omzeild). **Geen bevestiging gevonden voor
Het Gooi als werkgebied — behandel dit vooralsnog als onbevestigd, niet
als vaststaand feit.**

### Amersfoort — nog steeds geen bron, zoals al gemeld

Ook op deze pagina niet genoemd. Blijft een open vraag voor de klant,
zoals al eerder gerapporteerd.

### Opleveringsschoonmaak en Hygiëneservice — nog steeds geen bron

Beide namen komen letterlijk niet voor op `over-ons-1/`, `diensten/` of
`diensten-1/`. Blijft een open vraag voor de klant.

### De "3 reviews met zichtbare tekst" — dit klopt niet

Dit is de belangrijkste correctie. Het aangeleverde bericht stelde dat
Burgman, Woonstudio Joy, Het Event Atelier, Powervibe, KuchenTreff en
Kobelco elk met **zichtbare reviewtekst** op de site staan. Bij
rechtstreekse controle van de sectie "Onze vertrouwde klanten" op de
homepage (zowel de zichtbare tekst als de ruwe `innerText` van die
sectie in de DOM) bevat die sectie **uitsluitend de kop "Onze vertrouwde
klanten" plus logo-afbeeldingen — geen enkele reviewtekst, geen citaten,
geen sterrenscores per klant.** Dit is precies wat de oorspronkelijke
`IMAGE-AUDIT.md` al meldde (een logo-carrousel, geen reviewcarrousel met
tekst) en wat mijn eigen crawl eerder ook al vond.

**Conclusie: er is nog steeds geen bruikbare, kant-en-klare reviewtekst
op spotlezz.nl zelf voor `review_1..3_quote`.** De optie die wél
bevestigd bestaat is de Google Bedrijfsprofiel-review van "Esvi advies"
(VvE-klant) — maar dat blijft, zoals eerder gemeld, iets waar de klant
expliciet toestemming voor moet geven vóór hergebruik, geen materiaal dat
al "van de klant zelf" komt.

### De "cases" (Kersvers, Wilmar Afbouw) — logo's zijn echt, de case-tekst is nog Lorem Ipsum

Op `spotlezz.nl/diensten-1/` staat een sectie "Onze cases" met Kersvers
en Wilmar Afbouw, elk met een echt logo. Maar de begeleidende tekst is
letterlijk:

> "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit
> tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo."

**Dit is onafgemaakte placeholder-tekst, nog live op de productiesite.**
De knop "Bekijk case" heeft bovendien geen werkende link (`href`
ontbreekt in de DOM). Dus: logo's zijn een bevestigde, bruikbare bron
(zie `IMAGE-AUDIT-UPDATE-4C.md §3`), maar **er bestaat geen enkele echte
case-narratief, geen meetbaar resultaat, geen geverifieerde tekst** voor
Kersvers of Wilmar Afbouw — dat gat is dus niet gedicht, ondanks dat het
aangeleverde bericht het als "bevestigd" beschreef.

### Zijdelingse ontdekking: de live site heeft zelf ook onafgemaakte, dubbele pagina's

`/over-ons/` vs. `/over-ons-1/` en `/diensten/` vs. `/diensten-1/` zijn
**verschillende pagina's met deels andere content** (andere
statistieken: "87 beoordelingen" vs. "73+ tevreden klanten / 94%
verlengt contract"; andere dienst-omschrijvingen). Dat wijst erop dat de
klant zelf middenin een eigen redesign/update van de site zit, met oude
en nieuwe versies parallel live. Dit verklaart mogelijk ook de eerdere
87-vs-11-reviews-discrepantie deels (verschillende pagina's, verschillend
bijgewerkt) — nog steeds de moeite waard om dit gewoon rechtstreeks te
vragen in plaats van te proberen te reconstrueren welke pagina "de juiste"
is.

---

## Bijgewerkte openstaande-vragen-lijst voor de klant

| Vraag | Waarom |
| --- | --- |
| Is "Het Gooi" een echt werkgebied? | Niet gevonden op de site, ondanks een claim dat het er zou staan |
| Is Amersfoort een echt (gepland) werkgebied? | Nog steeds geen enkele bron |
| Zijn "Opleveringsschoonmaak" en "Hygiëneservice" echte, geplande diensten (mogelijk onder een andere naam al aangeboden)? | Niet gevonden onder deze namen |
| Is "Gevelreiniging" een dienst die een eigen pillar-pagina verdient? | Wél bevestigd als bestaande dienst, nog niet in de huidige 10 pillar-posts |
| Mogen de Kersvers-/Wilmar Afbouw-case-teksten (nu Lorem Ipsum) door de klant aangeleverd worden, of vervalt de scope-keuze van "3 cases" (Kobelco/KuchenTreff/Arena Gym) hiermee niet? | Placeholder-tekst nog live, geen scope-wijziging voorgesteld, alleen ter info |
| Welke van de twee "over ons"/"diensten"-paginaversies is de huidige/juiste? | Site heeft zelf dubbele, deels verschillende versies live |
| Mag de Google-review van "Esvi advies" (of een andere, met naam) hergebruikt worden voor `review_1..3`? | Nog steeds niet vanzelfsprekend zonder toestemming |
| 87 vs. 11 (of 73+) — welk cijfer is het juiste voor `AggregateRating`? | Discrepantie blijft, mogelijk verklaard door meerdere paginaversies |

## Wat dit niet verandert

Amsterdam en Lelystad als bevestigde werkgebieden, en Glasbewassing/
Vloeronderhoud als bevestigde diensten, zijn **echte, bruikbare
toevoegingen** aan wat we al wisten — dank voor het aandragen daarvan.
Maar de reviews- en case-tekst-gaten die in `IMAGE-AUDIT-UPDATE-4C.md`
en `ONLINE-VERIFICATION-4C.md` al gemeld waren, blijven openstaan; ze
zijn niet gedicht door wat er nu is aangeleverd.
