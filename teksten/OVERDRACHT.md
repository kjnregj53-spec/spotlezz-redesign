# Overdracht: Spotlezz teksten en zoekwoordonderzoek

Voor de SEO-specialist. Beschrijft wat er ligt, waar het op gebaseerd is, wat
gemeten is, wat aangenomen is, en welke beslissingen nog openstaan.

Opgesteld 16 augustus 2026.

---

## 1. Wat er ligt

**Zeven paginateksten** in `teksten/`:

| Bestand | Pagina | Primair zoekwoord | Volume |
| --- | --- | --- | --- |
| `locaties-schoonmaakbedrijf-almere.md` | Almere | schoonmaakbedrijf almere | 590 |
| `locaties-schoonmaakbedrijf-amsterdam.md` | Amsterdam | schoonmaakbedrijf amsterdam | 880 |
| `diensten-vve-schoonmaak.md` | VvE-schoonmaak | vve schoonmaak | 170 |
| `diensten-kantoor-schoonmaak.md` | Kantoorschoonmaak | kantoorschoonmaak | 110 |
| `diensten-glasbewassing.md` | Glasbewassing | glasbewassing | 1.600 |
| `diensten-kinderopvang-schoonmaak.md` | Kinderopvang | kinderopvang schoonmaak | geen |
| `faq-wat-kost-een-schoonmaakbedrijf-per-uur.md` | Prijspagina | wat kost een schoonmaakbedrijf per uur | 90 |

**Drie databestanden**, de ruwe API-output:

- `_data-zoekvolumes.json` — 211 zoekwoorden met volume, CPC, concurrentie-index
- `_data-serp-1.json` — SERP, PAA en gerelateerde termen voor 3 zoekwoorden
- `_data-serp-2.json` — idem voor 18 zoekwoorden

Nog niet geschreven: hotel, sportschool, showroom, vloeronderhoud,
opleveringsschoonmaak, hygiëneservice, Lelystad, Amersfoort, de vier
Almeerse wijken, zes klantcases, vier hubs en de resterende FAQ-detailpagina's.

---

## 2. Bronnen

### 2.1 Meetbaar, opgehaald via DataForSEO

Alle calls op 16 augustus 2026, `location_code: 2528` (Nederland),
`language_code: nl`. Totale kosten $0,49.

| Endpoint | Waarvoor | Omvang |
| --- | --- | --- |
| `keywords_data/google_ads/search_volume/live` | Volume, CPC, concurrentie-index | 211 zoekwoorden, 1 request |
| `serp/google/organic/live/advanced` | Top 20 organisch, People Also Ask, SERP-features | 21 zoekwoorden, `people_also_ask_click_depth: 2` |
| `dataforseo_labs/google/related_keywords/live` | Gerelateerde termen met volume | 21 seeds, `depth: 2` |

Volume en CPC komen uit de Google Ads-lineage, dus dezelfde bron als Keyword
Planner. Concurrentie-index is de Ads-waarde 0 tot 100, **geen** keyword
difficulty.

**Niet opgehaald**, en misschien wil je dat wel:
- `bulk_keyword_difficulty` — echte KD-scores
- `search_intent` — intentielabels per zoekwoord
- Backlinkprofiel van de concurrenten
- Rank tracking, dus er is geen nulmeting

### 2.2 Bestaande projectdocumenten

- `Spotlezz_SEO-architectuur_pogostick.xlsx` — 60 URL's, primair en secundair
  zoekwoord per pagina, fasering, en de strategieregels. Dit is de basis van de
  paginastructuur.
- De vijf wireframes — bepalen welk blok op welk paginatype staat en in welke
  volgorde. De teksten volgen die indeling.
- `SEO-ARCHITECTUUR-GAP.md` — verschil tussen het werkboek en wat er gebouwd is.

### 2.3 Al gepubliceerd door Spotlezz

Overgenomen van spotlezz.nl, dus door de klant zelf naar buiten gebracht:
4,8 uit 87 beoordelingen, 94 procent contractverlenging, ecologische middelen,
vaste teams, het stappenplan in vier stappen, 24/7 bereikbaarheid,
Spinnakerplantsoen 38 Almere, KVK 42089069.

### 2.4 Algemene vakkennis

Hier zit een risico, dus lees dit stuk goed.

In de teksten staan uitspraken over regelgeving en vakpraktijk die **niet uit een
bron van Spotlezz komen en niet zijn geverifieerd bij een deskundige.** Ze komen
uit algemene kennis en zijn plausibel, maar moeten voor publicatie gecontroleerd
worden:

| Waar | Claim | Te controleren bij |
| --- | --- | --- |
| VvE-pagina | Schoonmaak voor een VvE valt onder 21 procent btw | Accountant |
| VvE-pagina | Wat gemeenschappelijk is volgens de splitsingsakte, met kozijnen en voordeur als voorbeeld | VvE-beheerder of jurist |
| Glasbewassing | Arbo-regels voor werken op hoogte, ladder alleen voor kort werk | Arbodeskundige |
| Kinderopvang | De RIVM-frequenties per ruimte en de vier punten die de GGD toetst | Actuele RIVM-richtlijn kindercentra |
| Kantoorschoonmaak | De drie schoonmaakregels en kleurcodering | Vakinhoudelijk, laag risico |
| Glasbewassing | Kalk in leidingwater als oorzaak van strepen, hardheid in Flevoland | Vitens waterhardheid, laag risico |

Regelgeving verandert. Ik heb geen ingangsdatum of versienummer kunnen
controleren.

### 2.5 Wat géén bron is

**Er is niet met Spotlezz gesproken.** Geen interview, geen werkprogramma
gezien, geen operationele gegevens. Alles wat over de werkwijze van het bedrijf
gaat, staat daarom als `[[ INVULLEN: ... ]]` in de tekst in plaats van
ingevuld.

Dat is bewust. In een eerdere versie waren die details wél ingevuld met
plausibele aannames, en dat leverde zinnen op als "wij hebben Almere in vier
routes verdeeld" en "onze ochtendploegen zijn voor zeven uur op locatie". Die
zijn eruit. Er staan ongeveer 25 INVULLEN-markeringen verspreid over de zeven
documenten.

---

## 3. De belangrijkste bevinding

**Zoekvolume is in deze markt een slechte gids.** De Nederlandse
schoonmaak-SERPs worden gedomineerd door drie groepen die geen klant worden van
een zakelijk schoonmaakbedrijf: vacaturezoekers, particulieren die
huishoudelijke hulp zoeken, en doe-het-zelvers of materiaalkopers.

Voorbeelden uit de data:

- `kantoor schoonmaken` (1.300): tweede organische resultaat is Indeed met
  "600+ vacatures". Gerelateerd: `csu vacatures` 2.900, `avond werk` 720.
- `schoonmaakbedrijf almere` (590): zeven van de acht PAA-vragen gaan over
  particuliere hulp. Gerelateerd: `asito vacatures` 2.400,
  `huishoudelijke hulp almere` 170.
- `glasbewassing` (1.600): gerelateerd `glazenwasserswinkel` 1.900,
  `osmoworks` 1.000, `telewash winkel` 880. Dat zijn glazenwassers die
  materiaal inkopen.

**CPC is hier een betere maat voor commerciële waarde dan volume.** Waar
adverteerders veel betalen bij weinig volume, zitten de gekwalificeerde kopers:

| Zoekwoord | Volume | CPC |
| --- | --- | --- |
| offerte schoonmaakbedrijf | 70 | €16,94 |
| vve schoonmaak | 170 | €13,62 |
| schoonmaakbedrijf amsterdam | 880 | €13,40 |
| kantoorschoonmaak | 110 | €8,68 |
| glasbewassing | 1.600 | €2,44 |
| dieptereiniging | 590 | €1,27 |

### Drie geplande pagina's mikken op een woord dat iets anders betekent

| Pagina uit het werkboek | Wat de PAA laat zien |
| --- | --- |
| `dieptereiniging` (590) | Gaat over **tanden en gezichtsbehandeling**. `dieptereiniging gezicht` 390. De schoonmaakbetekenis is `dieptereiniging schoonmaak`, 30 per maand |
| `showroom schoonmaak` | PAA gaat volledig over **autodetailing**: "Hoe kan ik mijn auto showroomklaar laten maken?" |
| `tapijtreiniging` (720) | Doe-het-zelvers: "Wat doet baking soda met je tapijt?", `tapijtreiniging huren` 3.600, `tapijtreiniger action` 2.400 |

Alternatief dat wél zakelijk oogt: `vloerbedekking reinigen` (1.300).
Beslissing ligt bij jou.

### De prijsvraag staat in tien van de tien PAA-sets

Bij elk onderzocht zoekwoord, elke stad, elke dienst staat een variant van
"wat kost dit". Op de huidige site wordt dat beantwoord met "Neem contact met ons
op voor een offerte op maat". Dat is de meest gevraagde content van de hele site
en tegelijk de zwakste plek.

De prijspagina die er nu ligt noemt bewust geen bedrag, omdat de klant er nog
geen heeft vastgesteld. Zodra dat er is, hoort het in het blok "Het korte
antwoord" en nergens anders.

### Wat wél schoon zakelijk is

`vve schoonmaak` is het enige zoekwoord waarvan alle acht PAA-vragen zakelijk
zijn: splitsingsakte, btw-tarief, verantwoordelijkheid voor kozijnen. Dat zijn
vragen van een bestuurslid dat tekent. Daarom heeft die pagina voorrang gekregen.

---

## 4. Openstaande beslissingen

**Voor jou:**

1. De drie zoekwoorden hierboven: ander woord kiezen, of pagina laten vervallen?
2. De URL-structuur. Dertien pagina's staan nu op een ander adres dan het
   werkboek voorschrijft. Nu wijzigen kost niets, want niets is geïndexeerd. Zie
   `SEO-ARCHITECTUUR-GAP.md`.
3. De doorway-regel. Amsterdam, Amersfoort en de vier Almeerse wijken hebben geen
   lokaal bewijs. De wijken mikken samen op ongeveer 20 zoekopdrachten per maand.
   Bouwen, `noindex`, of samenvoegen?
4. Wil je KD-scores en intentielabels? Kost ongeveer $0,02 extra.

**Voor Spotlezz:**

De 25 INVULLEN-markeringen, plus de lijst in `build/TE-CONTROLEREN.md`. Twee
daarvan blokkeren publicatie: het formulier-endpoint en de medewerkersnamen.

---

## 5. Reproduceren

De credentials staan als omgevingsvariabele `DATAFORSEO_AUTH` (base64 van
`login:password`, account `info@qlickr.nl`). De brain met endpoint- en
kostenkeuzes staat in de Obsidian-vault onder
`kennis/dataforseo-brain`, met het gevolgde recept in
`wiki/flows/play-keyword-research-workflow.md`.

Let op: DataForSEO heeft op 1 juli 2026 breed geherprijsd. De bedragen in de
brain zijn tot een her-audit indicatief.
