# Lokale preview — fase 4B homepage visuele QA

Doel: alleen visuele controle vóór goedkeuring van fase 4C. Geen productie
aangeraakt, niets gedeployed, geen wireframes gewijzigd.

---

## 1. Lokale URL

**http://localhost:8890/**

Admin: **http://localhost:8890/wp-admin/**
Gebruiker: `previewadmin` · Wachtwoord: `Preview-Local-QA-2026!`
(alleen geldig binnen deze lokale, tijdelijke database — geen relatie met
enig echt account)

---

## 2. Hoe starten / stoppen

De map `local-preview/` bevat twee scripts (Git Bash):

```bash
cd "local-preview"
./start.sh   # start MariaDB (poort 3307) + PHP-server (poort 8890)
./stop.sh    # stopt beide weer
```

**Let op bij `stop.sh`:** dit script gebruikt `taskkill /IM php.exe` en
`taskkill /IM mariadbd.exe`, wat *elk* proces met die exacte naam op de
machine beëindigt, niet alleen deze preview. Bij het opstellen van dit
rapport draaide er verder geen andere PHP- of MariaDB/MySQL-instantie —
maar controleer dat zelf as je tussentijds iets anders bent gestart.

Handmatig starten kan ook, zie de commando's in `start.sh`.

---

## 3. Wat er is opgezet

Geen Docker beschikbaar op deze machine (gecontroleerd via zowel Bash als
PowerShell — niet geïnstalleerd). In plaats daarvan:

| Onderdeel | Wat | Waar |
| --- | --- | --- |
| Webserver | PHP 8.1 ingebouwde server | poort 8890 |
| Database | Lokaal reeds geïnstalleerde **MariaDB 12.3**, in een volledig geïsoleerde datadir (niet de standaard/systeem-datadir), niet-standaardpoort | poort 3307, datadir buiten het projectpad (zie §7) |
| Theme | **Symlink** naar `wordpress-theme/spotlezz/` (geen kopie — wijzigingen aan de theme-broncode zijn na een refresh direct zichtbaar in de preview) | `local-preview/wordpress/wp-content/themes/spotlezz` |
| Plugins | **Advanced Custom Fields (gratis, 6.8.7)**, echt van wordpress.org gedownload en geactiveerd — geen ACF-gedrag nagebootst | `wp-content/plugins/` |
| Elementor | **Niet geïnstalleerd**, zoals gevraagd | — |

Eerste poging was WordPress + SQLite (geen MySQL-server nodig), maar de
officiële SQLite-integratieplugin vereist SQLite ≥3.37.0 en deze
PHP-installatie heeft SQLite 3.36.0 ingebouwd — incompatibel. Overgestapt
op de al op deze machine aanwezige MariaDB-installatie, in een aparte,
weggooibare datadir.

---

## 4. Wat er is aangemaakt (content)

Alle content is **duidelijk gemarkeerd met het voorvoegsel "TEST —"** en
bevat expliciete "voorbeeld/testcontent"-teksten. Er is geen enkele echte
klantnaam, medewerkersnaam, review of bedrijfsfeit verzonnen:

- **1 statische voorpagina** ("Home") — nodig omdat het ACF-veldgroep
  `page_type == front_page` alleen aan een echte, als-voorpagina-ingestelde
  Pagina kan hangen. Zonder deze stap zou de homepage wel renderen (dankzij
  `front-page.php`), maar geen enkel ACF-veld zou ooit een waarde kunnen
  krijgen.
- **10 pillar-posts**: 6 met een `branche`-term (Kantoor, Hotel, Showroom,
  Sportschool, Kinderopvang, VvE) en 4 zonder (Glasbewassing,
  Vloeronderhoud, Opleveringsschoonmaak, Hygiëneservice) — dit dekt precies
  het onderscheid dat de homepage-code gebruikt om de twee assen te
  splitsen.
- **8 locatie-posts**: 4 steden + 4 Almeerse wijken als child-pagina van
  "TEST — Almere".
- **4 klantcase-posts**, waarvan de eerste 3 geselecteerd zijn in het
  homepage-veld "Drie klantcases" (relationship-veld, echte selectie via
  `update_field()` — geen los getypte tekst).
- **6 FAQ-posts**, waarvan de eerste 5 geselecteerd in "Vijf vragen".

**Bewust leeg gelaten:** het oprichter-blok (`founder_name`) en het
reviewblok (`reviews`-repeater). Beide vereisen een naam die aan een echt
persoon toegeschreven wordt — dat verzin je niet voor een preview. De
homepage toont daardoor terecht *geen* oprichterskaart en *geen*
reviewsectie; dat is het juiste, ontworpen gedrag bij lege velden, niet een
bug.

**Niet gevuld (technische beperking, geen contentkeuze):** `trust_stats`
en `photography_gallery` zijn ACF-**repeater**-velden. Repeater is een
Pro-only veldtype in de gratis versie van ACF — het veld verschijnt niet
eens in de admin-UI zonder ACF Pro. Beide blokken vallen daardoor terug op
hun gedocumenteerde fallback (de vier standaardstatistieken, drie
placeholder-fotokaders) — precies het pad dat instructie 7 vroeg te testen.

---

## 5. Screenshots

- `local-preview/screenshots/homepage-desktop-1440.png` — volledige pagina, 1440px
- `local-preview/screenshots/homepage-mobile-390.png` — volledige pagina, 390px

Beide bijgevoegd bij dit bericht.

---

## 6. Bevindingen

### PASS

- Alle 12 secties uit fase 4B renderen zonder PHP-fouten, -warnings,
  -notices of -deprecations (serverlog volledig gecontroleerd over de hele
  sessie: installatie, thema-activatie, ACF-activatie, content aanmaken,
  beide viewport-loads).
- Twee-assen dienstenblok: 6/6 branche-tegels en 4/4 dienst-tegels
  gerenderd, elk als echte link.
- Werkgebied: alle 8 locaties als klikbare pill.
- Klantcases: precies de 3 geselecteerde cases, met excerpt.
- FAQ: precies de 5 geselecteerde vragen, accordion werkt (native
  `<details>/<summary>`, geen JS-afhankelijkheid).
- Next-hop bar: exact 3 routes, éénmalig.
- Lege-staat-gedrag correct: oprichter- en reviewblok tonen niets in plaats
  van iets te verzinnen; de drie foto-secties tonen hun gedocumenteerde
  placeholder in plaats van een vervangende stockfoto.
- Full-bleed hero blijft full-bleed, met kicker/H1/H2/CTA's/reviewbadge-
  slot, zoals in §5.1 vastgelegd.

### ISSUES GEVONDEN

1. **Reviewbadge (topbalk + hero) rendert leeg.** `spotlezz_review_badge()`
   toont niets omdat `review_score`/`review_count` in Site Options nog
   nooit zijn opgeslagen — ACF schrijft een `default_value` pas naar de
   database zodra het optionsscherm één keer bewaard wordt; tot die tijd
   geeft `get_field()` niets terug. Zichtbaar in beide screenshots: het
   topbalk-gebied naast "Jarenlange ervaring" en het badge-pilletje
   linksboven in de hero zijn leeg. **Niet gefixt** (buiten scope van deze
   preview-taak) — twee opties voor later: (a) een admin bezoekt en bewaart
   de Site Options-pagina één keer, of (b) de theme zet bij activatie
   sensible defaults weg via `register_activation_hook`.

2. **Horizontale overflow op mobiel (390px).** Zichtbaar in
   `homepage-mobile-390.png`: de tekst "94% VERLENGT CONTI…" in het
   statenblok en "TEST — Showroom schoonmaak" in het dienstenblok worden
   afgekapt aan de rechterrand — dit is geen normale tekstterugloop maar
   content die breder is dan de 390px-viewport. Waarschijnlijke oorzaak:
   `.stat-block` en `.services-grid` gebruiken `grid-template-columns:
   repeat(2, 1fr)` resp. `repeat(auto-fill, minmax(180px, 1fr))` op mobiel
   zonder dat de celinhoud (padding + tekst) daarbinnen past bij lange
   labels. **Niet gefixt** — aanbevolen voor de volgende iteratie: `gap`/
   `padding` verkleinen of `minmax()`-ondergrens verlagen in
   `assets/css/theme.css`.

3. **Mobiel hamburger-menu-icoon niet zichtbaar.** Op 390px toont de
   header alleen de merknaam, geen zichtbaar menu-icoon (de knop
   `.mobile-menu-btn` zelf lijkt aanwezig maar het `☰`-teken erin is niet
   te onderscheiden in de screenshot — mogelijk een kleur/grootte-probleem
   in de huidige CSS). Niet functioneel getest (geen klik-QA gedaan in deze
   ronde) — puur visuele constatering. **Niet gefixt.**

Geen van deze drie is projectblokkerend voor de beoordeling van de
contentstructuur zelf, maar alle drie zijn concrete, reproduceerbare
bevindingen voor de volgende iteratie.

---

## 7. Wat is er verder aangemaakt op de machine (voor volledige transparantie)

- `local-preview/wordpress/` — WordPress-kern + plugins (nieuw gedownload)
- `local-preview/wordpress/wp-content/themes/spotlezz` — **symlink** naar
  `wordpress-theme/spotlezz/` (geen kopie)
- MariaDB-datadir: buiten het projectpad, in de sessie-scratchdirectory
  (`...AppData\Local\Temp\claude\...\scratchpad\wp-preview-mysql-data`) —
  bewust niet in het projectpad gezet
- Niets hiervan raakt de bestaande MariaDB-installatie, een eventuele
  productie-WordPress, `spotlezz.vercel.app/`, `build/` of `wireframes/`

Alles hierboven is met `stop.sh` te stoppen en de hele `local-preview/`-map
(plus de scratch-datadir) kan zonder gevolgen verwijderd worden als de
preview niet langer nodig is.
