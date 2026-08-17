# URL-structuur — technische verificatie tegen SEO-ARCHITECTUUR-GAP.md

De collega's `SEO-ARCHITECTUUR-GAP.md` stelt 13 hernoemingen voor en
adviseert die **vóór livegang** door te voeren (elders is dat document
tegen de oude static build gecontroleerd, niet tegen ons WordPress-
theme). Dit is de losse, technische vraag die daaruit volgt voor het
theme zelf: **kan onze CPT/rewrite-structuur die exacte URL's überhaupt
produceren, met name de geneste wijk-URL's** (`/locaties/
schoonmaakbedrijf-almere/almere-stad/`, vier niveaus diep)?

**Antwoord: ja, zonder enige codewijziging.** Getest en bevestigd in de
lokale preview.

---

## Wat er getest is

Belangrijke ontdekking vooraf: de lokale preview draaide de hele fase
4B/4C-periode op **Plain permalinks** (`?post_type=locatie&locatie=...`)
— dat is waarom alle eerdere QA-rapporten die stijl URL's gebruiken. De
geneste, "mooie" URL-structuur die de SEO-architectuur wil is dus **nooit
eerder in dit project getest**, ook niet in de eerdere fase-4C-stappen.

Voor deze verificatie:
1. Permalinks tijdelijk omgezet naar "Post name" (`/%postname%/`)
2. Vier testposts hernoemd (alleen de slug, niet de titel — reversibel):
   - Locatie #17 (Almere) → `schoonmaakbedrijf-almere`
   - Locatie #21 (Almere Stad, kind van #17) → `almere-stad`
   - Case #25 (Kobelco) → `kobelco-kantoorschoonmaak-almere`
   - Pillar #7 (Kantoor schoonmaak) → `kantoor-schoonmaak`
3. `flush_rewrite_rules()` aangeroepen
4. Alle resulterende URL's daadwerkelijk bezocht (niet alleen
   `get_permalink()` uitgelezen)
5. Na de test: alles teruggezet naar de oorspronkelijke staat (Plain
   permalinks, oorspronkelijke `TEST —`-slugs) — geen blijvende wijziging

## Resultaat

| URL | Bereikbaar? |
| --- | --- |
| `/locaties/schoonmaakbedrijf-almere/` | **200 OK** |
| `/locaties/schoonmaakbedrijf-almere/almere-stad/` (4 niveaus diep, geneste wijk) | **200 OK** |
| `/klantcases/kobelco-kantoorschoonmaak-almere/` | **200 OK** |
| `/diensten/kantoor-schoonmaak/` | **200 OK** |
| `/locaties/`, `/klantcases/`, `/diensten/` (hubs) | **200 OK** |

Structuurchecks op de geneste wijk-pagina: exact 1 `<main>`, exact 1
next-hop bar, breadcrumb begint correct `Home › Locaties › …`, geen
PHP-fouten. De oude, nu-verlaten query-string-URL's (`?locatie=...`)
blijven ook gewoon werken naast de mooie URL's — geen regressie voor iets
dat al eerder getest is.

## Wat dit betekent

- **Geen enkele theme-wijziging nodig** om de 13 hernoemingen uit
  `SEO-ARCHITECTUUR-GAP.md` door te voeren. `inc/post-types.php`'s
  bestaande `hierarchical => true` + `rewrite => ['slug' => 'locaties']`
  produceert de geneste structuur al automatisch, zoals WordPress-kern
  dat hoort te doen voor hiërarchische CPT's.
- De hernoemingen zijn dus **zuiver een contentstap**: bij het invoeren
  van de echte, definitieve posts gewoon de juiste slug meegeven (of de
  titel zo kiezen dat de auto-gegenereerde slug al goed is). Geen aparte
  ontwikkelstap, geen risico.
- **Praktisch gevolg voor de contentvolgorde**: zodra de posts met echte
  content gevuld worden (na de klant-antwoorden), moeten de slugs uit de
  hernoemingstabel in `SEO-ARCHITECTUUR-GAP.md §4` gebruikt worden bij
  het aanmaken — dat voorkomt precies de "twee keer verhuizen"-situatie
  die dat document afraadt.
- **Losstaand van de klant-antwoorden**: deze technische verificatie was
  volledig onafhankelijk uit te voeren en hoefde niet op iets te wachten
  — dat was ook precies de reden om dit nu te doen.

## Wat nog wél op een antwoord van de klant wacht

De hernoemingstabel bevat een paar slugs die rechtstreeks een pillar-naam
bevatten die nog niet bevestigd is:
`/diensten/hygieneservice/` → `/diensten/sanitair-en-hygieneservice/` —
zolang niet duidelijk is of "Hygiëneservice" de juiste dienstnaam is (zie
`VRAGENLIJST-VOOR-KLANT.md` punt 2), kan deze ene slug niet definitief
vastgezet worden. De overige 12 hernoemingen zijn onafhankelijk daarvan
en kunnen al gepland worden.
