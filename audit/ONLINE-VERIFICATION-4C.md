# Online verificatie na de beeldaudit-update — wat bevestigd is, wat niet

Vervolg op `IMAGE-AUDIT-UPDATE-4C.md`. Voor elk open punt daaruit is
gezocht naar publieke, betrouwbare bronnen (LinkedIn-bedrijfspagina, het
officiële KVK-Handelsregister, het Google Bedrijfsprofiel). Alles hieronder
komt van openbare bronnen — geen inloggen, geen omzeilen van
toegangscontrole, geen privégegevens opgevraagd.

---

## 1. Bevestigd — direct te gebruiken

### Naamspelling oprichter: "Thirza Mac Donald" (niet "Mac Donder")

Twee onafhankelijke bronnen bevestigen dezelfde spelling:
- De live contactpagina zelf (`spotlezz.nl/contact/`)
- De officiële LinkedIn-bedrijfspagina van Spotlezz, sectie "Employees at
  Spotlezz" — noemt haar met exact dezelfde spelling

Eerdere projectdocumenten in dit traject schreven "Mac **Donder**" — dat
was dus fout. **Aanbeveling: overal in het theme en de documentatie
"Mac Donald" aanhouden.** Geen enkele plek in de huidige theme-code bevat
op dit moment een hardgecodeerde naam (de founder-kaart staat bewust leeg
tot bevestigd), dus er hoeft nergens iets gecorrigeerd te worden — dit is
puur een correctie voor het moment dat de naam wél ingevuld wordt.

### KVK-gegevens: volledig bevestigd, één gat opgevuld

Het officiële KVK-Handelsregister (kvk.nl, KVK-nummer 42089069)
bevestigt:

| Veld | Wat er al in `inc/site-options.php` stond | KVK-bevestiging |
| --- | --- | --- |
| Statutaire naam | Spotlezz B.V. | **exact match** |
| KVK-nummer | 42089069 | **exact match** |
| Straat + huisnummer | Spinnakerplantsoen 38 | **exact match** |
| Plaats | Almere | **exact match** |
| Postcode | *(leeg)* | **1319DG** — nu ingevuld |

**Toegepast**: `address_postcode` in `inc/site-options.php` had geen
default-waarde — dat was het enige echte gat in de NAP-gegevens. Nu
gevuld met `1319 DG`, rechtstreeks uit het officiële Handelsregister.
Verder geen wijzigingen nodig; alle andere NAP-velden waren al correct.

Extra, niet eerder vastgelegde informatie uit het Handelsregister: naast
"Spotlezz" en "Spotlezz B.V." staat ook **"Spotless Cleaning Facilities"**
geregistreerd als handelsnaam. Niet meteen relevant voor de huidige
velden, maar goed om te weten als de klant ooit naar merknaamgebruik
vraagt.

### Woman-owned business — geverifieerd Google-label

Het Google Bedrijfsprofiel van Spotlezz toont het geverifieerde label
"Identified as a woman-owned business". Dit is een sterk, extern
geverifieerd EEAT-signaal dat nergens in het huidige contentplan
gebruikt wordt — de moeite waard om te bespreken met de klant of dit
ergens (bijv. het "Over ons"-verhaal) benoemd mag worden.

---

## 2. Bevestigd, maar met een discrepantie die de klant moet ophelderen

### Aantal reviews: 87 (site) vs. 11 (Google Maps zelf)

`spotlezz.nl` toont overal "4,8/5 · 87 beoordelingen" — en dat cijfer
staat ook al als default in `inc/site-options.php` (`review_count`).
Het **Google Bedrijfsprofiel zelf** (waar de site naar linkt) toont
echter maar **11** reviews, wel met dezelfde score van 4,8/5.

Dit is geen theme-bug — het cijfer 87 staat consistent overal, ook op de
live site zelf. Waarschijnlijke verklaring: 87 is een opgeteld cijfer
over meerdere platformen (Google + Facebook + eigen enquêtes o.i.d.), niet
alleen Google. **Vraag aan de klant: waar komt het cijfer 87 vandaan, en
mag dat zo blijven staan als het cijfer bij het AggregateRating-schema
(dat leest specifiek Google-achtige "reviewCount"-semantiek)?** Dit raakt
schema.org-correctheid, dus de moeite waard om zeker te weten in plaats
van aan te nemen.

---

## 3. Kon niet (volledig) online bevestigd worden — vraag het de klant

### Reviewfoto's en -teksten voor `review_1..3_*` (Site Options)

Het Google Bedrijfsprofiel toont wél **echte, met naam genoemde
reviewers** die relevant zijn voor specifieke pillars:
- **"Esvi advies"** (Local Guide) — VvE-klant, al 3+ jaar wekelijkse
  schoonmaak van gemeenschappelijke ruimtes — one-to-one bruikbaar voor
  de `vve-schoonmaak`-pillar
- **"Burgman schoonmaak groothandel"** — kantoorklant, en Burgman's logo
  staat al bevestigd op de site (zie `IMAGE-AUDIT-UPDATE-4C.md §3) — dit
  is dus een klant met zowel een logo als een publieke review
- **"marcel Brummelhaus"** — noemt "Thirza en haar collega" met naam in
  een review over stofoverlast na een badkamer-/vloerrenovatie

**Dit kan ik niet zelf overnemen als contentbron.** Het gaat om
privégebruikers/bedrijven die een review op Google achterlieten, niet om
materiaal dat de klant zelf heeft aangeleverd of goedgekeurd voor
hergebruik op de eigen site. **Vraag aan de klant: mogen deze (of andere)
Google-reviews met naam en tekst hergebruikt worden in
`review_1_quote`/`review_1_name`/etc.? Zo ja, welke drie?** Reviewfoto's
(profielfoto's van de reviewers) zijn sowieso niet zomaar te gebruiken
zonder toestemming van de betreffende personen — dat blijft een apart
gat, zoals al gemeld.

### Foto's voor de 4 nieuwe pillars, case-`hero_foto`/`quote_foto`, en 7 van de 8 locatie-posts

Geen enkele publieke bron (site, LinkedIn, Google-profiel, KVK) bevat
foto's van Opleveringsschoonmaak, Hygiëneservice, Vloeronderhoud of
Glasbewassing, van de klantcases zelf (los van hun logo), of van
Lelystad/Amsterdam/Amersfoort/de Almere-wijken. Dit blijft zoals in de
vorige audit gemeld: **nieuwe fotografie nodig, of bewuste keuze om
zonder te publiceren** (het theme handelt lege velden al veilig af).

### Locatie-uitbreiding zelf — is dit een bewuste bedrijfskeuze?

Het Google-profiel en het KVK-register bevestigen één vestiging in
Almere. Er is nergens online een aanwijzing dat Spotlezz al actief is in
Lelystad, Amsterdam of Amersfoort. **Vraag aan de klant: is de
locatiepagina-uitbreiding naar deze drie steden een geplande, echte
uitbreiding van het werkgebied, of was dit alleen een structuur-voorbeeld
uit de wireframes?** Dat antwoord bepaalt of deze acht locatie-posts
serieus met content gevuld moeten worden, of dat de scope teruggebracht
moet worden naar (voorlopig) alleen Almere.

---

## Samenvatting van acties

| Wat | Status |
| --- | --- |
| Postcode NAP | **Opgelost** — `1319 DG` toegevoegd aan `inc/site-options.php`, uit het officiële KVK-register |
| Naamspelling oprichter | **Opgehelderd** — "Mac Donald", niet "Mac Donder"; nog niet ergens gebruikt, dus geen code-wijziging nodig |
| Reviewcount 87 vs. 11 | **Aan de klant**: bron van het cijfer 87 bevestigen |
| Reviewteksten/-namen | **Aan de klant**: mogen deze drie (of andere) Google-reviews hergebruikt worden, en van wie mogen we een foto gebruiken? |
| Locatie-uitbreiding (Lelystad/Amsterdam/Amersfoort) | **Aan de klant**: is dit een echte, geplande uitbreiding? |
| Fotografie: 4 nieuwe pillars, case hero/quote, 7 van de 8 locaties | **Aan de klant**: nieuwe fotografie plannen, of bewust leeg laten |
