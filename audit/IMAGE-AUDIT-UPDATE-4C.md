# Beeldaudit — update na fase 4C (live spotlezz.nl vs. nieuwe ACF-veldstructuur)

Vervolg op `IMAGE-AUDIT.md` (die vergeleek de oude static build met
spotlezz.nl). Deze update crawlt spotlezz.nl **opnieuw**, maar toetst nu
tegen de daadwerkelijke ACF-veldstructuur die in fase 4C gebouwd is
(`inc/acf-pillar.php`, `inc/acf-case.php`, `inc/acf-locatie.php`,
`inc/site-options.php`) — dus concreet: welk veld heeft al een bruikbare
bron op de live site, en welk veld heeft nog he niets.

Geen enkele afbeelding hierbij gedownload, hergebruikt of vervangen —
alleen inventarisatie, zoals steeds afgesproken.

---

## 1. Belangrijkste nieuwe bevinding: Thirza's foto nu structureel bevestigd

De vorige audit kon niet bevestigen of `professional-cleaning.jpg` echt
Thirza is. Op de **live** contactpagina (`spotlezz.nl/contact/`) staat die
foto in **hetzelfde Elementor-blok** als de tekst:

> Thirza Mac Donald — Oprichter — 036-785 7028 — info@spotlezz.nl

Dat is sterker bewijs dan pagina-co-existentie: het is dezelfde
structurele container. Twee dingen om nog wel te bevestigen bij de klant
voordat dit als vaststaand feit gebruikt wordt:

1. **Naamspelling-verschil**: eerdere projectdocumenten schreven "Thirza
   Mac **Donder**", de live site schrijft "Thirza Mac **Donald**" — welke
   is correct?
2. Elementor-pairing is een sterke aanwijzing, geen mondelinge
   bevestiging — bij twijfel alsnog navragen.

Zodra bevestigd: `professional-cleaning.jpg` (bron:
`spotlezz.nl/wp-content/uploads/2026/02/professional-cleaning.jpg`) is
bruikbaar voor de homepage-oprichterskaart (`spotlezz_person_card()` in
`front-page.php`) — precies het veld dat nu bewust leeg staat.

---

## 2. Pillar-foto's (`photo_1/2/3` in `inc/acf-pillar.php`) — 6 van de 10 hebben iets, 4 hebben niets

Van de 10 pillar-posts in het theme bestaan er live maar **6** als
echte dienstpagina op spotlezz.nl:

| Pillar (theme) | Live URL | Eigen echte foto's gevonden |
| --- | --- | --- |
| Kantoor schoonmaak | `/diensten/kantoor-schoonmaak/` | 3: `IMG_9839...jpg`, `231003-ff-528901...jpg` (echte cameraopnames, geen stock), `image00009...jpeg` |
| Hotel schoonmaak | `/diensten/hotel-schoonmaak/` | 2: `Hospitality-11-2-1-1.jpg`, `Hospitality-11-1-2.jpg` |
| Showroom schoonmaak | `/diensten/showroom-schoonmaak/` | 2: `Showroom-11-1.jpg`, `showroom-11-2.png` |
| Sportschool schoonmaak | `/diensten/fitnesscentrum-schoonmaak/` | 2: `Gym-11-2-1.jpg`, `Hospitality-11-1.jpg` (**let op: dit is dezelfde foto als hotel** — live site hergebruikt hem al, geen nieuwe fout van ons) |
| Kinderopvang schoonmaak | `/diensten/kinderopvang-schoonmaak/` | 1: `image00009-scaled...jpeg` (zelfde bestand als op de kantoorpagina) |
| VvE schoonmaak | `/diensten/vve-schoonmaak/` | 2: `VVE-1-1.jpg`, `VVE-2.png` |
| **Opleveringsschoonmaak** | geen live pagina | **0 — geen bron** |
| **Hygiëneservice** | geen live pagina | **0 — geen bron** |
| **Vloeronderhoud** | geen live pagina | **0 — geen bron** |
| **Glasbewassing** | geen live pagina | **0 — geen bron** |

Ook op de homepage (niet aan een specifieke pillar gekoppeld) staan 6
extra dienst-achtige foto's: `sr1.jpg` t/m `sr6.jpg`
(`wp-content/uploads/2026/03/sr1-1024x665.jpg` etc., alt-teksten "Hotel
Schoonmaak", "Showroom Schoonmaak", "sport school Schoonmaak",
"kinderopvang Schoonmaak", "schoonmaakpartner", en één zonder duidelijke
dienstkoppeling) — mogelijk bruikbaar als extra `photo_3` waar een pillar
er nu maar 1-2 heeft, maar dat moet de klant bevestigen (zijn dit
sfeerbeelden of specifiek voor die dienst bedoeld?).

**Concreet gat**: zelfs de 6 bestaande diensten hebben zelden alle 3
foto-slots gevuld — meestal 1-2, nooit meer dan 3. De 4 nieuwe diensten
hebben helemaal niets.

---

## 3. Klantcase-velden (`inc/acf-case.php`) — logo's ruimer beschikbaar dan gedacht, foto's/quotes nergens

### Logo's — meer gevonden dan de vorige audit meldde

Behalve de al bekende Kobelco/KuchenTreff/Arena Gym (zie
`IMAGE-AUDIT.md §1`) staan er nu ook deze logo's live, verspreid over
verschillende dienstpagina's:

| Klant | Bron-URL |
| --- | --- |
| Kersvers | `wp-content/uploads/2026/01/kersvers-logo-2.png` |
| Wilmar (Afbouw) | `wp-content/uploads/2026/01/logo-1.png` |
| Alliance | `wp-content/uploads/2026/01/image002_edited.jpg` |
| Flor | `wp-content/uploads/2026/02/image-28-1.png` |
| innovally | `wp-content/uploads/2026/02/image6.png` |
| logisnext | `wp-content/uploads/2026/02/image2.png` |
| Mitsubishi (Heavy Industries) | `wp-content/uploads/2026/02/image4.png` |
| Burgman | `wp-content/uploads/2026/02/Group-1597880404.png` |
| Woonstudio Joy | `wp-content/uploads/2026/02/Mask-group.png` / `WoonstudioJoy_diap-1.png` |
| Het Event Atelier | `wp-content/uploads/2026/02/Group-1597880406.png` |
| powervibe | `wp-content/uploads/2026/02/Group-1597880405.png` |

Dit is ruim genoeg om de **al goedgekeurde scope van 3 cases** (Kobelco,
KuchenTreff, Arena Gym — beslissing uit fase 3, ongewijzigd) volledig te
onderbouwen. **Geen scope-wijziging voorgesteld** — puur ter info voor
een eventuele latere uitbreiding.

### hero_foto / quote_foto — geen bron gevonden

Op spotlezz.nl bestaat **geen losse klantcase-detailpagina** (geen
`/klantcases/kobelco/` o.i.d.) — de logo's staan alleen in de
reviewcarrousel en op dienstpagina's. Er is dus geen "foto op locatie,
team in actie" (`hero_foto`) en geen contactpersoon-portret
(`quote_foto`) voor Kobelco, KuchenTreff of Arena Gym. **Volledig gat**,
niet alleen een kwestie van overtypen — dit moet echt nieuw materiaal
worden, of de klant moet bevestigen dat deze cases zonder eigen foto's
gepubliceerd mogen worden (dan blijven `hero_foto`/`quote_foto` leeg,
wat het theme al correct als lege state afhandelt).

---

## 4. Locatie-velden (`inc/acf-locatie.php`) — vrijwel volledig gat

Dit is de grootste bevinding van deze update. **spotlezz.nl is een
single-locatie bedrijf in Almere** — het navigatiemenu bevat geen
"Locaties", er bestaan geen stad- of wijkpagina's. De acht
locatie-posts in het theme (Almere, Lelystad, Amsterdam, Amersfoort +
4 Almere-wijken) zijn een **nieuwe informatie-architectuur** die niet op
de huidige site bestaat.

Concreet betekent dit voor elk van de 8 locatie-posts:

| Veld | Bron op spotlezz.nl |
| --- | --- |
| `kaart_afbeelding` | geen — geen enkele kaartafbeelding gevonden op de hele site |
| `logo_1..6` | alleen voor **Almere** te vullen met de al bekende klantlogo's (§3); voor de andere 7 locaties: geen |
| `lokale_review_foto` | geen — zie §5 |
| `lokaal_team_foto` | alleen Thirza (§1), en die is de oprichter, niet per se "het team in [stad]" |
| `photo_1/2/3` | voor Almere deels te vullen met de generieke Spotlezz-foto's (IMG_9839 etc.); voor de andere 7: geen |

**Voor Lelystad, Amsterdam, Amersfoort en de vier Almere-wijken bestaat
op dit moment geen enkel bruikbaar beeldmateriaal.** Dat is precies
waarom de publish-gate (`inc/publish-gate.php`) deze pagina's terecht op
noindex zet zolang er geen 3 van de 4 bewijsvormen zijn — dit bevestigt
dat die regel niet theoretisch is, maar een reëel, actueel probleem
afdekt.

---

## 5. Site Options — reviewfoto's (`review_1_photo`..`review_3_photo`)

De reviewcarrousel op spotlezz.nl toont **klantlogo's + sterren**, geen
portretfoto's van de reviewer zelf. Er is dus geen bronmateriaal voor
`review_1_photo`/`review_2_photo`/`review_3_photo` — deze velden blijven
leeg tot de klant echte reviewer-foto's aanlevert (of akkoord geeft om
zonder foto te publiceren; `spotlezz_reviews_block()` handelt een lege
foto al netjes af, geen `<img>` zonder bron).

---

## Samenvatting: concreet te doen per veldgroep

| Veldgroep | Status | Actie |
| --- | --- | --- |
| Homepage-oprichterskaart | **Bijna klaar** | Naamspelling bevestigen (Donald vs. Donder), dan `professional-cleaning.jpg` gebruiken |
| Pillar `photo_1/2/3` — 6 bestaande diensten | **Deels gevuld** | Foto's overnemen zodra gewenst; ontbrekende 3e slot per dienst navragen (zijn `sr1..sr6.jpg` daarvoor bedoeld?) |
| Pillar `photo_1/2/3` — 4 nieuwe diensten | **Leeg** | Nieuwe fotografie nodig (Opleveringsschoonmaak, Hygiëneservice, Vloeronderhoud, Glasbewassing) |
| Case `logo` | **Klaar** | 3 bevestigde bronnen (Kobelco/KuchenTreff/Arena Gym), ruim voldoende extra's beschikbaar voor eventuele latere uitbreiding |
| Case `hero_foto`/`quote_foto` | **Leeg** | Geen bron — nieuwe fotografie of akkoord voor lege state nodig |
| Locatie — Almere | **Deels gevuld** | Logo's en generieke foto's herbruikbaar |
| Locatie — overige 7 (Lelystad/Amsterdam/Amersfoort + 4 wijken) | **Vrijwel volledig leeg** | Nieuwe fotografie nodig, of bewust op noindex laten staan (de gate doet dit al automatisch) |
| Site Options reviewfoto's | **Leeg** | Nieuwe aanlevering nodig, of zonder foto publiceren (al veilig afgehandeld) |

Geen van deze gaten blokkeert het theme zelf — elk leeg veld valt al
aantoonbaar netjes terug op een lege state (geen kapotte `<img>`, geen
verzonnen naam/foto-combinatie). Dit is puur een content-checklist voor
de klant, zoals eerder afgesproken dat fase 4 niet zou blokkeren op
ontbrekende echte fotografie.
