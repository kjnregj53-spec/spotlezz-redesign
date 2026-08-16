# SEO-architectuur: stand van zaken

Vergelijking tussen `Spotlezz_SEO-architectuur_pogostick.xlsx` en wat er nu in
dit repo staat. Er is naar aanleiding van dit document niets gebouwd of
hernoemd; het is een inventarisatie plus een voorstel voor de volgorde.

Bijgewerkt: 15 augustus 2026

---

## 1. Advies over de timing

Het plan was om de SEO-architectuur pas bij de livegang door te voeren. Voor de
**content** is dat prima. Voor de **URL-structuur** raad ik het af, en dat is de
enige plek waar ik van het voorstel afwijk.

De reden is dat die twee verschillende kosten hebben.

**URL's veranderen kost nu niets.** De vercel.app-omgeving staat op `noindex`,
dus er is niets geïndexeerd, er is geen autoriteit opgebouwd en er zijn geen
externe links. Een pagina hernoemen is op dit moment een regel in de build.

**Bij de livegang is er sowieso al één verhuizing.** De huidige spotlezz.nl
heeft URL's die verdwijnen: `/sectoren/*`, `/quote/`, `/contact-us/`,
`/over-ons-1/`, `/diensten-1/`, `/kantoorschoonmaak-1/`. Die moeten allemaal
301'en naar het nieuwe adres. Die map staat al in `vercel.json`.

Als de huidige, afwijkende URL's meegaan naar productie, krijg je daarna een
**tweede** verhuizing: dertien pagina's die net begonnen zijn met ranken worden
opnieuw hernoemd. Dat gebeurt dan precies in de periode waarin Google de hele
site opnieuw beoordeelt. Het raakt bovendien juist de pagina's waar het hele
traject om draait, want `/locaties/almere/` moet `schoonmaakbedrijf almere`
gaan winnen.

Concreet:

| | Nu hernoemen | Bij of na livegang hernoemen |
| --- | --- | --- |
| Redirects nodig | Geen | 13 |
| Verlies van autoriteit | Geen | Beperkt maar reëel |
| Aantal migraties | 1 (oud spotlezz.nl naar nieuw) | 2 |
| Werk | Buildconfiguratie, geen tekst | Zelfde werk plus redirectbeheer |

**Advies: zet de URL-structuur vast voordat er iets geïndexeerd wordt, en laat
de contentfasen wachten tot na de livegang.**

Eén voorwaarde daarbij. Dit werkt alleen als de URL-structuur in het werkboek
definitief is. Twee keer hernoemen is slechter dan één keer laat hernoemen. Ligt
de structuur nog open bij Spotlezz, rond dat dan eerst af. De echte
afhankelijkheid is niet de livegang maar de vraag of deze URL's vaststaan.

---

## 2. De stand per URL

60 URL's in het werkboek. 21 staan op het juiste adres, 13 bestaan onder een
andere URL, 26 ontbreken.

### Setup

| Status | URL uit de architectuur | Primair zoekwoord | Type |
| --- | --- | --- | --- |
| Staat er | `/` | schoonmaakbedrijf almere | Homepage |
| Staat er | `/contact/` | contact spotlezz | Conversiepagina |
| Staat er | `/offerte-aanvragen/` | offerte schoonmaakbedrijf | Conversiepagina |
| Staat er | `/checklist/` | schoonmaak checklist bedrijf | Conversiepagina |

### Fase 1

| Status | URL uit de architectuur | Primair zoekwoord | Type |
| --- | --- | --- | --- |
| Staat er | `/diensten/` | schoonmaakdiensten bedrijven | Overzicht / hub |
| Staat er | `/diensten/kantoor-schoonmaak/` | kantoorschoonmaak | Pillar |
| Staat er | `/diensten/hotel-schoonmaak/` | hotelschoonmaak | Pillar |
| Staat er | `/diensten/showroom-schoonmaak/` | showroom schoonmaak | Pillar |
| Staat er | `/diensten/fitnesscentrum-schoonmaak/` | sportschool schoonmaak | Pillar |
| Staat er | `/diensten/kinderopvang-schoonmaak/` | kinderopvang schoonmaak | Pillar |
| Staat er | `/diensten/vve-schoonmaak/` | vve schoonmaak | Pillar |
| Staat er | `/klantcases/` | klantcases schoonmaakbedrijf | Overzicht / hub |
| Andere URL: `/klantcases/kobelco/` | `/klantcases/kobelco-kantoorschoonmaak-almere/` | kantoorschoonmaak almere referentie | Detailpagina |
| Andere URL: `/klantcases/kuchentreff/` | `/klantcases/kuchentreff-showroomschoonmaak/` | showroomschoonmaak referentie | Detailpagina |
| Andere URL: `/klantcases/arena-gym/` | `/klantcases/arena-gym-sportschoolschoonmaak/` | sportschoolschoonmaak referentie | Detailpagina |
| **Ontbreekt** | `/klantcases/event-atelier-vergaderlocatie/` | schoonmaak vergaderlocatie | Detailpagina |
| **Ontbreekt** | `/klantcases/woonstudio-joy-opleveringsschoonmaak/` | opleveringsschoonmaak referentie | Detailpagina |
| **Ontbreekt** | `/klantcases/burgman-duurzame-kantoorschoonmaak/` | kantoorschoonmaak duurzaam referentie | Detailpagina |
| Staat er | `/veelgestelde-vragen/` | veelgestelde vragen schoonmaakbedrijf | Overzicht / hub |
| **Ontbreekt** | `/veelgestelde-vragen/wat-kost-een-schoonmaakbedrijf-in-almere/` | wat kost een schoonmaakbedrijf in almere | Detailpagina |
| **Ontbreekt** | `/veelgestelde-vragen/wat-kost-een-schoonmaakbedrijf-per-uur/` | wat kost een schoonmaakbedrijf per uur | Detailpagina |
| Staat er | `/veelgestelde-vragen/hoe-kies-je-een-schoonmaakbedrijf/` | hoe kies je een schoonmaakbedrijf | Detailpagina |
| Andere URL: `.../hoe-vaak-moet-een-kantoor-schoongemaakt-worden/` | `/veelgestelde-vragen/hoe-vaak-kantoor-schoonmaken/` | hoe vaak kantoor schoonmaken | Detailpagina |
| Staat er | `/locaties/` | werkgebied schoonmaakbedrijf | Overzicht / hub |
| Andere URL: `/locaties/almere/` | `/locaties/schoonmaakbedrijf-almere/` | schoonmaakbedrijf almere | Locatiepagina |
| Andere URL: `/locaties/almere-stad/` | `/locaties/schoonmaakbedrijf-almere/almere-stad/` | schoonmaakbedrijf almere stad | Sub-locatiepagina |
| Andere URL: `/locaties/almere-buiten/` | `/locaties/schoonmaakbedrijf-almere/almere-buiten/` | schoonmaakbedrijf almere buiten | Sub-locatiepagina |
| Andere URL: `/locaties/almere-haven/` | `/locaties/schoonmaakbedrijf-almere/almere-haven/` | schoonmaakbedrijf almere haven | Sub-locatiepagina |
| Andere URL: `/locaties/almere-poort/` | `/locaties/schoonmaakbedrijf-almere/almere-poort/` | schoonmaakbedrijf almere poort | Sub-locatiepagina |
| Staat er | `/over-ons/` | over spotlezz | Vertrouwenspagina |
| **Ontbreekt** | `/over-ons/team/` | team spotlezz | Vertrouwenspagina |
| Staat er | `/reviews/` | spotlezz reviews | Vertrouwenspagina |
| Staat er | `/vacatures/` | vacatures schoonmaak almere | Detailpagina |

### Fase 2

| Status | URL uit de architectuur | Primair zoekwoord | Type |
| --- | --- | --- | --- |
| Staat er | `/diensten/glasbewassing/` | glasbewassing | Pillar |
| Staat er | `/diensten/vloeronderhoud/` | vloeronderhoud | Pillar |
| Staat er | `/diensten/opleveringsschoonmaak/` | opleveringsschoonmaak | Pillar |
| Andere URL: `/diensten/hygieneservice/` | `/diensten/sanitair-en-hygieneservice/` | hygieneservice | Pillar |
| **Ontbreekt** | `/diensten/dieptereiniging/` | dieptereiniging | Pillar |
| **Ontbreekt** | `/diensten/tapijtreiniging/` | tapijtreiniging | Pillar |
| **Ontbreekt** | `/diensten/eenmalige-schoonmaak/` | eenmalige schoonmaak | Pillar |
| **Ontbreekt** | `/veelgestelde-vragen/schoonmaak-uitbesteden-of-zelf-in-dienst/` | schoonmaak uitbesteden | Detailpagina |
| **Ontbreekt** | `/veelgestelde-vragen/wat-is-een-schoonmaakprogramma/` | schoonmaakprogramma | Detailpagina |
| **Ontbreekt** | `/veelgestelde-vragen/werken-ecologische-schoonmaakmiddelen-echt/` | ecologische schoonmaakmiddelen | Detailpagina |
| Andere URL: `/locaties/amsterdam/` | `/locaties/schoonmaakbedrijf-amsterdam/` | schoonmaakbedrijf amsterdam | Locatiepagina |
| Andere URL: `/locaties/lelystad/` | `/locaties/schoonmaakbedrijf-lelystad/` | schoonmaakbedrijf lelystad | Locatiepagina |
| Andere URL: `/locaties/amersfoort/` | `/locaties/schoonmaakbedrijf-amersfoort/` | schoonmaakbedrijf amersfoort | Locatiepagina |
| **Geblokkeerd** | `/locaties/schoonmaakbedrijf-amsterdam/kantoorschoonmaak/` | kantoorschoonmaak amsterdam | Dienst x locatie |
| **Geblokkeerd** | `/locaties/schoonmaakbedrijf-amsterdam/hotelschoonmaak/` | hotelschoonmaak amsterdam | Dienst x locatie |
| **Geblokkeerd** | `/locaties/schoonmaakbedrijf-amsterdam/vve-schoonmaak/` | vve schoonmaak amsterdam | Dienst x locatie |
| **Geblokkeerd** | `/locaties/schoonmaakbedrijf-lelystad/kantoorschoonmaak/` | kantoorschoonmaak lelystad | Dienst x locatie |
| **Geblokkeerd** | `/locaties/schoonmaakbedrijf-lelystad/hotelschoonmaak/` | hotelschoonmaak lelystad | Dienst x locatie |
| **Geblokkeerd** | `/locaties/schoonmaakbedrijf-lelystad/vve-schoonmaak/` | vve schoonmaak lelystad | Dienst x locatie |
| **Geblokkeerd** | `/locaties/schoonmaakbedrijf-amersfoort/kantoorschoonmaak/` | kantoorschoonmaak amersfoort | Dienst x locatie |
| **Geblokkeerd** | `/locaties/schoonmaakbedrijf-amersfoort/hotelschoonmaak/` | hotelschoonmaak amersfoort | Dienst x locatie |
| **Geblokkeerd** | `/locaties/schoonmaakbedrijf-amersfoort/vve-schoonmaak/` | vve schoonmaak amersfoort | Dienst x locatie |

### Fase 3

| Status | URL uit de architectuur | Primair zoekwoord | Type |
| --- | --- | --- | --- |
| **Ontbreekt** | `/veelgestelde-vragen/opzegtermijn-schoonmaakcontract/` | opzegtermijn schoonmaakcontract | Detailpagina |
| **Ontbreekt** | `/locaties/schoonmaakbedrijf-hilversum/` | schoonmaakbedrijf hilversum | Locatiepagina |
| **Ontbreekt** | `/locaties/schoonmaakbedrijf-zeewolde/` | schoonmaakbedrijf zeewolde | Locatiepagina |
| **Ontbreekt** | `/locaties/schoonmaakbedrijf-utrecht/` | schoonmaakbedrijf utrecht | Locatiepagina |
| **Ontbreekt** | `/locaties/schoonmaakbedrijf-diemen/` | schoonmaakbedrijf diemen | Locatiepagina |

---

## 3. De negen dienst x locatie pagina's staan bewust stil

Deze zijn niet vergeten. Het werkboek verbiedt ze op dit moment:

> "Harde regel: publiceer een dienst x locatie pagina pas als er minimaal drie
> van deze vier zijn: (1) een echte klant in die stad in die branche, (2) een
> citeerbare quote of case, (3) een lokaal team of vaste schoonmaker, (4) een
> concrete lokale invalshoek zoals een bedrijventerrein of wijk. Zonder dat
> blijft het een stadsblok binnen de bestaande locatiepagina."

Voor Amsterdam, Lelystad en Amersfoort is op dit moment geen van die vier
aantoonbaar aanwezig. Ze blijven dus stadsblokken binnen de bestaande
locatiepagina tot dat verandert.

Diezelfde regel raakt trouwens vijf pagina's die al wél gebouwd zijn: Amersfoort
en de vier Almeerse wijken. Die zijn op verzoek gemaakt zonder lokaal bewijs.
Zie punt 6 van `build/TE-CONTROLEREN.md`.

---

## 4. Als de URL-structuur wordt doorgevoerd

Dertien hernoemingen. Zolang dat vóór de livegang gebeurt zijn er geen
redirects nodig, alleen een aanpassing in de build.

```
/locaties/almere/              -> /locaties/schoonmaakbedrijf-almere/
/locaties/almere-stad/         -> /locaties/schoonmaakbedrijf-almere/almere-stad/
/locaties/almere-buiten/       -> /locaties/schoonmaakbedrijf-almere/almere-buiten/
/locaties/almere-haven/        -> /locaties/schoonmaakbedrijf-almere/almere-haven/
/locaties/almere-poort/        -> /locaties/schoonmaakbedrijf-almere/almere-poort/
/locaties/amsterdam/           -> /locaties/schoonmaakbedrijf-amsterdam/
/locaties/lelystad/            -> /locaties/schoonmaakbedrijf-lelystad/
/locaties/amersfoort/          -> /locaties/schoonmaakbedrijf-amersfoort/
/klantcases/kobelco/           -> /klantcases/kobelco-kantoorschoonmaak-almere/
/klantcases/kuchentreff/       -> /klantcases/kuchentreff-showroomschoonmaak/
/klantcases/arena-gym/         -> /klantcases/arena-gym-sportschoolschoonmaak/
/diensten/hygieneservice/      -> /diensten/sanitair-en-hygieneservice/
/veelgestelde-vragen/hoe-vaak-moet-een-kantoor-schoongemaakt-worden/
                               -> /veelgestelde-vragen/hoe-vaak-kantoor-schoonmaken/
```

Twee gevolgen om te weten:

1. De wijkpagina's komen een niveau dieper te liggen. De breadcrumb wordt dan
   Home, Locaties, Schoonmaakbedrijf Almere, Almere Stad. Dat is vier niveaus en
   dat is precies wat het werkboek bedoelt met "sub-locatiepagina".
2. `/veelgestelde-vragen/wat-bepaalt-de-prijs-van-schoonmaak/` bestaat wel bij
   ons maar niet in de architectuur. Die pagina is ontstaan toen we besloten geen
   bedrag te noemen. Het werkboek heeft twee prijspagina's:
   `wat-kost-een-schoonmaakbedrijf-in-almere` en
   `wat-kost-een-schoonmaakbedrijf-per-uur`. De bestaande tekst over de zes
   prijsfactoren past onder de tweede; de eerste is dan nog nieuw te schrijven.

---

## 5. Voorgestelde volgorde

**Voor de livegang**

1. Bevestigen dat de URL-structuur in het werkboek definitief is.
2. De dertien hernoemingen doorvoeren, inclusief de nesting van de wijken.
3. De redirectmap in `vercel.json` controleren tegen de definitieve URL's.

**Bij de livegang**

4. `noindex` vervalt automatisch omdat die alleen op `*.vercel.app` staat.
5. Sitemap indienen, oude spotlezz.nl-URL's 301'en.

**Na de livegang, Fase 1 afmaken**

6. Drie klantcases: Het Event Atelier, Woonstudio Joy, Burgman.
7. Twee prijs-FAQ's.
8. `/over-ons/team/`.

**Fase 2**

9. Drie dienst-pillars: dieptereiniging, tapijtreiniging, eenmalige schoonmaak.
10. Drie FAQ-detailpagina's.
11. De negen dienst x locatie pagina's, maar alleen per stad zodra het lokale
    bewijs er is.

**Fase 3**

12. Hilversum, Zeewolde, Utrecht, Diemen, en de opzegtermijn-FAQ.

---

## 6. Wat er niet in de architectuur staat maar wel op de site

- `/blog/` met drie lege kaarten. Het werkboek laat de blog er bewust buiten:
  "op verzoek buiten de structuur gelaten". Blijft voorlopig staan zoals het is.
- `/privacybeleid/`. Juridische pagina, valt buiten de zoekwoordstructuur.
- `/veelgestelde-vragen/wat-bepaalt-de-prijs-van-schoonmaak/`. Zie punt 4.
