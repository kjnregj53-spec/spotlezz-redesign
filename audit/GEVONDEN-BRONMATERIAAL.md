# Gevonden brondocumenten buiten `final/` — wat ze wél en niet oplossen

Tijdens deze sessie bleek er buiten de map `final/` (waar dit hele
WordPress-traject in gebouwd is) nog een bredere projectstructuur te
bestaan: `docs/`, `new/`, `archive/`, `website/`. Drie documenten daarin
zijn direct relevant voor de open vragen in `VRAGENLIJST-VOOR-KLANT.md`.
Hieronder staat precies wat ze bevestigen en wat ze juist **tegenspreken**
van wat er al gebouwd is — dat laatste is te belangrijk om te negeren.

---

## 1. `docs/content/Teksten nieuwe services Spotlezz.txt` (12 juli)

Volledig uitgeschreven, blijkbaar al eerder becommentarieerde tekst voor
de nieuwe diensten. Bevat inline reviewer-opmerkingen (bijvoorbeeld: "Is
het handig om alleen almere te benoemen. Dit is eigenlijk mijn enige
opmerking voor de rest lijkt mij alles meegenomen" — een teken dat de rest
al akkoord was).

**Bevat volledige, klaar-geschreven content voor:** Schoonmaakonderhoud
(basis), **Glasbewassing**, **Vloeronderhoud**, **Dieptereiniging**,
**Specialistische reiniging** (met daarin als voorbeelden: gevelreiniging,
graffitiverwijdering, **opleveringsschoonmaak na een verbouwing**).

**Belangrijk:** "Hygiëneservice" komt in dit hele document **nergens**
voor. "Opleveringsschoonmaak" is hier geen zelfstandige dienst maar één
voorbeeld ónder "Specialistische reiniging".

## 2. `docs/content/spotlezz_content_inventory.md` (12 juli)

Een volledige scrape van de toen-live site plus twee pagina's expliciet
gelabeld **"(New Service)" / "(Proposed)"**: `Dieptereiniging` en
`Specialistische reiniging` — dezelfde twee als in punt 1, nu met een
voorgestelde URL. Bevestigt verder exact dezelfde 6 klantlogo's en dezelfde
schrijfwijze "Thirza Mac Donald" die ik zelf al onafhankelijk vond.

## 3. `new/Spotlezz wireframes - Feedback .pdf` (26 juli)

Dit is echte, inhoudelijke klantfeedback op de wireframes (ondertekend
met "Reilly" als betrokken partij). Twee punten hierin wijken **af** van
wat er inmiddels gebouwd is:

### a) De dienstenlijst die hier genoemd wordt
> "Diensten: Schoonmaak onderhoud, Vloeronderhoud, Specialistisch
> Onderhoud, Dieptereiniging, Glasbewassing"

Dit bevestigt nogmaals: **geen "Hygiëneservice", geen zelfstandige
"Opleveringsschoonmaak"**. De consistente naam voor de vier nieuwe
pillars zou moeten zijn: **Vloeronderhoud, Specialistisch(e) Onderhoud/
reiniging, Dieptereiniging, Glasbewassing** — twee van de vier kloppen al
in het huidige theme (Vloeronderhoud, Glasbewassing), twee zijn nu onder
de verkeerde naam gebouwd (Opleveringsschoonmaak, Hygiëneservice) waar het
Dieptereiniging en Specialistisch(e) Onderhoud/reiniging hadden moeten
zijn.

### b) De locatielijst — dit is de grootste afwijking
> "Daarnaast de focus op voornamelijk Amsterdam, maar laten we hier later
> ook Almere en Utrecht aan toevoegen."

> "is dit ook relevant als we flevoland, weesp, diemen en amsterdam en
> utrecht omlijnen? **Ik zal deze niet met wijken doen, enkel losse
> steden.**"

Dit noemt **Weesp, Diemen, Utrecht en Flevoland** — geen van deze staat
in het huidige theme. **Amersfoort en Lelystad, die wél gebouwd zijn,
worden in dit document niet genoemd.** En expliciet: de nieuwe steden
zouden **geen wijken-onderverdeling** krijgen (de vier Almere-wijken zelf
worden elders in hetzelfde document wel met een vraagteken, maar niet
afgekeurd, besproken — dus die lijken te blijven staan).

**Dit is een echte tegenstrijdigheid tussen twee documenten, geen kwestie
van "had ik moeten weten."** `audit/WORDPRESS-BUILD-PLAN.md` (15 augustus
— drie weken later, en het document waar dit hele theme tegen gebouwd is,
inclusief de APPROVED-beslissingen van de klant) noemt alleen Almere,
Lelystad, Amsterdam, Amersfoort en de wijken — **niet** Weesp, Diemen,
Utrecht of Flevoland. Het meest logische is dat de locatiekeuze na 26 juli
is bijgesteld en dat `WORDPRESS-BUILD-PLAN.md` de nieuwere, geldende
versie is — maar dat is een aanname, geen zekerheid. Dit moet gewoon
bevestigd worden, het is geen fout van het huidige traject.

---

## Wat dit concreet betekent voor de vragenlijst

| Open vraag | Voor dit onderzoek | Na dit onderzoek |
| --- | --- | --- |
| Zijn "Opleveringsschoonmaak"/"Hygiëneservice" de juiste namen? | Onbekend | **Waarschijnlijk niet** — de echte dienstenlijst uit twee onafhankelijke documenten is Vloeronderhoud, Glasbewassing, Dieptereiniging, Specialistisch(e) Onderhoud/reiniging. Vraag wordt: bevestig dat de laatste twee namen (i.p.v. Opleveringsschoonmaak/Hygiëneservice) gebruikt moeten worden, en welke exacte schrijfwijze ("Specialistisch onderhoud" vs "Specialistische reiniging"). |
| Zijn Amersfoort/Het Gooi echte werkgebieden? | Onbekend | **Nog steeds onbekend, maar nu met een extra complicatie**: een eerder feedbackdocument noemt een heel andere stedenlijst (Weesp, Diemen, Utrecht, Flevoland) zonder Amersfoort of Lelystad te noemen. Vraag wordt breder: is de huidige locatielijst (Almere/Lelystad/Amsterdam/Amersfoort + wijken) nog steeds de geldende, of is die stedenlijst uit de latere fase (WORDPRESS-BUILD-PLAN.md) een bewuste aanpassing t.o.v. de eerdere Amsterdam/Weesp/Diemen/Utrecht-focus? |

Geen van deze twee punten is met de code zelf op te lossen of te
verifiëren — dit zijn scope-beslissingen die alleen de klant (of wie de
locatiekeuze na 26 juli heeft bijgesteld) kan bevestigen.

## Wat dit niet verandert

Alle andere open vragen (reviews-toestemming, 87-vs-11, medewerkersfoto's,
casefoto's) blijven precies zoals ze in `VRAGENLIJST-VOOR-KLANT.md` staan
— dit onderzoek raakte alleen de dienst- en locatienamen.

**Er is geen code gewijzigd naar aanleiding hiervan.** Dit is puur
inventarisatie, zoals steeds afgesproken.
