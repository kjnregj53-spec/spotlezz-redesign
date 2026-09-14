# SEO-controle op de WordPress-build

Gecontroleerd op `spotlezz.freedev.app`, 4 september 2026. Twaalf pagina's
nagelopen op de live dev-omgeving, plus de schema-output en de interne links.

Dit is geen advies op basis van de screenshots maar een meting op de echte site.

---

## Wat al goed staat

Belangrijk om te benoemen, want dit is het lastige deel en dat is gelukt.

**De locatiepagina's zijn echt uniek.** Gemeten met de stadsnamen weggefilterd
komen Almere, Amsterdam en Amersfoort op 3 tot 5 procent overeenkomst. Ter
vergelijking: op de oude opzet was dat 100 procent. De doorway-val is vermeden.

**De hiërarchie klopt.** De wijken hangen onder Almere, dus
`/locaties/almere/almere-buiten/` in plaats van een platte lijst. De breadcrumb
volgt dat mee.

**De H1's dragen het zoekwoord.** "Schoonmaakbedrijf Almere Buiten" in plaats van
"Almere Buiten". Dat is precies goed.

**De schema-graph is degelijk.** Organization plus CleaningService met adres,
KVK-nummer, telefoon en aggregateRating; WebSite; BreadcrumbList; Review;
FAQPage; en per locatie een LocalBusiness met `areaServed` en
`parentOrganization`. Dit is beter dan wat er in de statische opzet stond.

**Geen dode links, geen lege secties.** Vijfentwintig interne links
gecontroleerd, allemaal 200. Het thema verbergt secties waarvan het ACF-veld
leeg is, dus je krijgt geen koppen zonder inhoud.

**De dev-omgeving staat op `noindex, nofollow`.** Precies goed.

---

## Blokkerend, dit eerst

### 1. Het bedrijfsadres staat in het schema op Amsterdam

```json
"address": {
  "streetAddress": "Spinnakerplantsoen 38",
  "postalCode": "1319 DG",
  "addressLocality": "Amsterdam"
}
```

Postcode 1319 hoort bij **Almere**, niet bij Amsterdam. Dit staat in de
Organization-node en die wordt op elke pagina uitgeserveerd.

Dit is de ernstigste vondst. Het hele traject draait om ranken op
"schoonmaakbedrijf Almere", en de gestructureerde data vertelt Google dat het
bedrijf in Amsterdam zit. Het botst bovendien met het Google Bedrijfsprofiel, en
een NAP die niet matcht kost lokale zichtbaarheid.

**Actie:** `addressLocality` op Almere zetten en daarna letterlijk vergelijken
met het Bedrijfsprofiel, teken voor teken.

### 2. Geen enkele pagina heeft een meta description

Nul van de twaalf gecontroleerde pagina's. Google stelt dan zelf een snippet
samen uit de body.

**Actie:** ACF-veld per CPT en per pagina, met een fallback in het thema.
Reken op 140 tot 160 tekens.

### 3. De title tags gebruiken de post-titel, niet het zoekwoord

| Pagina | Nu | Zou moeten zijn |
| --- | --- | --- |
| Home | `Spotlezz` (8 tekens) | `Schoonmaakbedrijf in Almere voor kantoren, hotels en VvE \| Spotlezz` |
| Almere Buiten | `Almere Buiten – Spotlezz` | `Schoonmaakbedrijf Almere Buiten \| Spotlezz` |
| Amsterdam | `Amsterdam – Spotlezz` | `Schoonmaakbedrijf Amsterdam voor kantoren en VvE \| Spotlezz` |
| Diensten | `Diensten – Spotlezz` | `Schoonmaakdiensten voor bedrijven in Almere e.o. \| Spotlezz` |

De H1 is overal wél goed. De title tag, het sterkste on-page signaal dat er is,
staat op de kale posttitel. De homepage-title is acht tekens lang.

**Actie:** apart ACF-veld voor de title tag, met als fallback niet
`the_title()` maar de H1-waarde.

### 4. Geen Open Graph tags

Nul OG-tags op alle twaalf pagina's. Elke link die in WhatsApp, LinkedIn of een
mailclient wordt gedeeld toont een kale URL zonder titel of afbeelding.

**Actie:** `og:title`, `og:description`, `og:image`, `og:url`, `og:type` en een
Twitter-card in de header van het thema. Eén standaard deelafbeelding van
1200x630 volstaat om te beginnen.

### 5. Er is geen sitemap

`/wp-sitemap.xml` en `/sitemap_index.xml` geven allebei 404. De ingebouwde
WordPress-sitemap lijkt uitgezet zonder dat er iets voor in de plaats is
gekomen. Er is ook geen SEO-plugin actief die het overneemt.

`robots.txt` is de standaard WordPress-versie en verwijst niet naar een sitemap.

**Actie:** de core-sitemap weer aanzetten of er zelf een genereren, en de
verwijzing in robots.txt opnemen.

### 6. Zet `noindex` uit bij de livegang

Nu staat het goed. Maar dit is de klassieke manier om een lancering te
verprutsen: de site gaat live en blijft weken op noindex staan.

**Actie:** op de opleverchecklist zetten, en na livegang controleren via
Search Console.

---

## Middelgroot

### 7. Canonical ontbreekt op de vier hubs

Aanwezig op alle losse pagina's, maar niet op `/locaties/`, `/diensten/`,
`/klantcases/` en `/veelgestelde-vragen/`. Dat zijn juist de archieven waar
WordPress makkelijk varianten van maakt.

### 8. De Review-objecten missen een rating

De drie Review-nodes hebben wel `reviewBody`, `author` en `itemReviewed`, maar
geen `reviewRating`. Zonder dat veld is een Review ongeldig voor rich results.

Daarbij: `author` is nu `{"@type": "Person", "name": "Kobelco"}`. Kobelco is een
bedrijf, dus dat hoort `Organization` te zijn.

### 9. Bijna alle afbeeldingen missen afmetingen

Op de homepage 48 van de 51. Op de locatiepagina's 4 van de 7, op Over ons 8 van
de 11, op Reviews 15 van de 18. Zonder `width` en `height` verspringt de layout
tijdens het laden, en dat telt mee in Core Web Vitals.

De alt-teksten zijn wél grotendeels ingevuld. Alleen op de homepage missen er 7.

### 10. Twee hubs zijn dun

`/diensten/` heeft 270 woorden en `/klantcases/` 374. Dat zijn de
instappagina's van twee van de vijf hubs. De FAQ-hub doet het met 2.895 woorden
juist goed, en `/locaties/` zit met 585 in orde.

### 11. Kleine markup-rommel

De H1 op `/offerte-aanvragen/` bevat harde tabs en regeleindes:
`"Ontvang een\t\t\t\tofferte op maat\n\t\t\t\tvoor jouw bedrijf"`. Werkt, maar
ruim het op.

---

## Beslissingen, geen fouten

### 12. De URL-structuur wijkt af van de architectuur

Nu: `/locaties/almere/` en `/locaties/almere/almere-buiten/`
Werkboek: `/locaties/schoonmaakbedrijf-almere/` en
`/locaties/schoonmaakbedrijf-almere/almere-buiten/`

In dit model draagt de slug het zoekwoord. Zolang er niets geïndexeerd is kost
wijzigen niets; na de livegang kost het redirects op precies de pagina's waar
het traject om draait.

Dit is nu het moment om het te besluiten, niet later. Zie
`SEO-ARCHITECTUUR-GAP.md`.

### 13. De wijkpagina's en Amersfoort hebben geen lokaal bewijs

Vier Almeerse wijken plus Amersfoort staan gepubliceerd. De teksten zijn uniek,
dus het is geen doorway in de klassieke zin, maar de klantcase en de review op
die pagina's komen uit een andere plaats.

Samen mikken de vier wijken op ongeveer 20 zoekopdrachten per maand. De vraag is
of ze dat waard zijn, of dat ze beter op `noindex` kunnen tot er een echte klant
in die wijk is.

### 14. Onderhoud

- WordPress 7.0.4, versie 7.1 staat klaar
- Zes items in de prullenbak bij Locaties, twee concepten
- Er is geen SEO-plugin. Dat is een verdedigbare keuze bij een eigen thema, maar
  het betekent wel dat titels, descriptions, OG-tags en de sitemap allemaal uit
  het thema moeten komen. Op dit moment doet het thema daarvan alleen de titel,
  en die is niet goed.

---

## Volgorde

**Deze week**

1. `addressLocality` naar Almere en NAP vergelijken met het Bedrijfsprofiel
2. Title tags: ACF-veld plus fallback op de H1
3. Meta descriptions: ACF-veld plus fallback
4. Open Graph in de theme-header
5. Sitemap aanzetten en in robots.txt zetten

**Voor de livegang**

6. Canonical op de vier hubs
7. `reviewRating` toevoegen, author van Kobelco naar Organization
8. `width` en `height` op afbeeldingen
9. Besluit over de URL-structuur
10. `noindex` eraf en Search Console inrichten

**Daarna**

11. Diensten- en klantcases-hub uitbreiden
12. Besluit over de wijkpagina's
13. WordPress bijwerken en de prullenbak legen
