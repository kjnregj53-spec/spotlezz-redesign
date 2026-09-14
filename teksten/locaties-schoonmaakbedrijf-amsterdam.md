# Schoonmaakbedrijf Amsterdam

**URL:** `/locaties/schoonmaakbedrijf-amsterdam/`
**Primair zoekwoord:** schoonmaakbedrijf amsterdam (880/mnd, CPC €13,40, concurrentie-index 52)
**Paginatype:** Locatiepagina volgens wireframe-4

---

## Wat de data zegt

**Hoogste commerciële waarde van alle locatiepagina's.** 880 zoekopdrachten per
maand tegen een CPC van €13,40, ruim het dubbele van Almere (€5,13). Adverteerders
betalen hier het meest van alle locatietermen.

**Maar ook de zwaarste concurrentie.** Index 52 tegenover 12 in Almere. In Almere
is Spotlezz gevestigd en concurreert het met lokale partijen; in Amsterdam
concurreert het met iedereen.

**Dezelfde intentievervuiling als in Almere, maar erger.** De PAA gaat over "Wat
kost 1 uur huishoudelijke hulp?", "Wat kan een schoonmaakster in 3 uur?" en "Wat
is het uurloon van een zwarte schoonmaakster?". De gerelateerde zoekwoorden:
`schoonmaakbedrijf particulieren` 480, `schoonmaker inhuren thuis` 210,
`schoonmaakster amsterdam` 210.

**Eén bruikbare vraag springt eruit:** "Wat zijn de top 3 schoonmaakbedrijven?" en
"Welk schoonmaakbedrijf is het beste?". Dat is vergelijkingsintentie van iemand
die aan het kiezen is. Daar hoort de vergelijkingstabel en het reviewblok hoog op
de pagina.

**Belangrijk voorbehoud.** Volgens de doorway-regel uit wireframe-4 mag deze
pagina pas gepubliceerd worden bij minimaal drie van de vier vormen van lokaal
bewijs. Voor Amsterdam is dat er nu niet: geen lokale klant, geen lokale case,
geen lokaal team. Met 880 zoekopdrachten is de verleiding groot, maar een dunne
pagina op een concurrerende term levert niets op.

**Wel relevant:** Spotlezz heeft een adres in Amsterdam (Kiekstraat 59, 1087 BR).
Dat is de enige stad buiten Almere waar een fysiek adres bestaat. Als er ergens
een tweede Google Bedrijfsprofiel kan komen, is het hier.

[[ INVULLEN: is de Kiekstraat een bezoekadres, een postadres of een
werklocatie? Dat bepaalt of er een Bedrijfsprofiel mag komen. Google eist een
bemande locatie. ]]

---

## Meta

**Title:** Schoonmaakbedrijf Amsterdam voor kantoren, hotels en VvE | Spotlezz
**Meta description:** Zakelijk schoonmaakbedrijf in Amsterdam. Kantoren, hotels en VvE-complexen, met vaste teams en één aanspreekpunt. Binnen 12 uur een afspraak.

---

## 1. Hero

**H1:** Schoonmaakbedrijf Amsterdam

**Intro:**
Spotlezz werkt in Amsterdam voor kantoren, hotels en VvE-complexen. Wij zijn
zakelijk: voor particuliere huishoudelijke hulp kunt u niet bij ons terecht.

> Die tweede zin is hier nog belangrijker dan in Almere. De zoekdata laat zien
> dat de meerderheid van de bezoekers op dit zoekwoord particulier is.

---

## 2. Antwoordblok

Spotlezz is een zakelijk schoonmaakbedrijf dat in Amsterdam werkt voor kantoren,
hotels, showrooms en VvE-complexen. Wij werken met vaste teams en één
aanspreekpunt per klant. Binnen 12 uur na uw aanvraag staat er een afspraak.

| Waarde | Label |
|---|---|
| Zakelijk | Geen particulieren |
| < 12 uur | Reactietijd |
| [[ INVULLEN: routedagen of vaste bezetting? ]] | Planning |
| 87 | Beoordelingen |

---

## 3. Lokaal bewijs

[[ INVULLEN: dit blok is leeg en dat is het probleem. Er is geen Amsterdamse
klant, case of review. Zonder dit blok is de pagina volgens de eigen doorway-regel
niet publicabel. ]]

Opties zolang dat zo is:
1. De pagina op `noindex` zetten tot er lokaal bewijs is
2. Amsterdam als stadsblok binnen `/locaties/` houden in plaats van als eigen pagina
3. Publiceren met het bewijs uit Almere, expliciet als zodanig benoemd

Optie 3 is het minst goed maar wel eerlijk: "Onze cases komen uit Almere, waar wij
gevestigd zijn." Beter dan een review uit Almere presenteren alsof hij uit
Amsterdam komt, wat in de huidige gegenereerde versie feitelijk gebeurt.

---

## 4. Veelgevraagde diensten in Amsterdam

1. Kantoorschoonmaak
2. Hotelschoonmaak (Amsterdam is de enige stad waar dit hout snijdt)
3. VvE-schoonmaak

---

## 5. Waarom bedrijven in Amsterdam voor ons kiezen

> Vervangt het werkgebiedblok. In Almere kan dat over bedrijventerreinen en
> aanrijtijden gaan omdat Spotlezz daar echt rijdt. Voor Amsterdam zou dat
> verzonnen zijn. Dus dit blok gaat over de vergelijkingsvraag uit de PAA:
> "Welk schoonmaakbedrijf is het beste?"

[[ INVULLEN: waarom zou een Amsterdams bedrijf voor Spotlezz kiezen boven een
lokale partij? Wat is de eerlijke reden? Zonder antwoord hierop hoort deze pagina
niet te bestaan. ]]

Mogelijke invalshoeken die Spotlezz moet bevestigen:
- Vaste teams in plaats van wisselende invallers, wat in Amsterdam met de krappe
  arbeidsmarkt schaars is
- Eén aanspreekpunt in plaats van een servicedesk
- Kleiner bedrijf, dus de eigenaar is bereikbaar

---

## 6. Andere locaties

Almere · Lelystad · Amersfoort

---

## 7. Next-hop

Omhoog: alle locaties · Zijwaarts: kantoorschoonmaak, hotelschoonmaak ·
Conversie: offerte voor Amsterdam. Plus een prominente belknop.

---

## Schema

`LocalBusiness` van het type `CleaningService` met `areaServed` Amsterdam.

**Let op:** in de huidige gegenereerde site draagt deze pagina
`{"@type":"WebPage","name":"Onze Diensten"}`, gekopieerd van de dienstenpagina.
Dat moet hoe dan ook worden gecorrigeerd, ongeacht wat er met de tekst gebeurt.

Geen `address` opnemen met het Almeerse adres. Als de Kiekstraat een echte
locatie is, hoort die hier; zo niet, dan helemaal geen adres op deze pagina.
