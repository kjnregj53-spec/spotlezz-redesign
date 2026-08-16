# Contentstatus — geverifieerd vs. wachtend op de klant

Bijgewerkt na de online-verificatieronde. Regel: **alleen bevestigde,
echte feiten worden ingevuld — alles onbevestigd blijft leeg (Pending),
nooit met verzonnen tekst of een placeholder-foto opgevuld.** Dit
document is de enige plek waar de status per veld/onderdeel bijgehouden
wordt, zodat er geen giswerk ontstaat over wat al klaar is.

---

## Al ingevuld (in de lokale preview, met echte data)

| Onderdeel | Veld | Waarde | Bron |
| --- | --- | --- | --- |
| Homepage — oprichterskaart | `founder_name` | Thirza Mac Donald | Contactpagina spotlezz.nl + LinkedIn-bedrijfspagina (twee onafhankelijke bronnen) |
| Homepage — oprichterskaart | `founder_role` | Oprichter | Zelfde bronnen |
| Site Options | `address_postcode` | 1319 DG | Officieel KVK-Handelsregister (KVK-nr. 42089069) |

`founder_photo` is **bewust leeg gelaten** — de kaart valt automatisch
terug op een initiaal-avatar ("T"), geen foto, geen risico op een
verkeerde toeschrijving. Dit is in lijn met de al goedgekeurde fase-3-regel
("geen onbevestigde Thirza-foto") — de naamspelling is nu wel bevestigd,
de foto nog niet expliciet.

---

## Bevestigd als feit, maar nog geen inhoud om in te vullen

Deze zijn *waar*, maar er bestaat geen tekst/foto die we zomaar kunnen
overnemen — dus ook hier: niets ingevuld, wél Pending i.p.v. TEST-content.

| Onderdeel | Status | Wat ontbreekt |
| --- | --- | --- |
| Locatie Amsterdam | Echt werkgebied (bevestigd) | Geen stad-specifieke tekst, foto's, logo's, review of team gevonden — alle bewijsvorm-velden blijven leeg, pagina blijft dus terecht op noindex |
| Locatie Lelystad | Echt werkgebied (bevestigd) | Zelfde als Amsterdam |
| Pillar Glasbewassing | Echte dienst (bevestigd) | Geen foto's, geen eigen paginatekst gevonden |
| Pillar Vloeronderhoud | Echte dienst (bevestigd) | Zelfde als Glasbewassing |

**Belangrijk:** deze vier blijven in de lokale preview op hun huidige
`TEST —`-testcontent staan (uit eerdere QA-stappen) — dat is
QA-materiaal, geen "klaar voor productie"-content. Zodra er echte tekst/
foto's zijn, vervangt dat de testcontent; tot die tijd wordt er niets
verzonnen ter overbrugging.

---

## Nog volledig onbevestigd — hier wordt niets aan gedaan tot de klant reageert

| Onderdeel | Reden |
| --- | --- |
| Locatie "Het Gooi" | Niet gevonden op de site zelf, ondanks een eerdere claim dat het er zou staan |
| Locatie Amersfoort | Nog steeds geen enkele bron |
| Pillar "Opleveringsschoonmaak" | Naam niet gevonden op de live site |
| Pillar "Hygiëneservice" | Naam niet gevonden op de live site |
| Pillar "Gevelreiniging" (nieuw ontdekt) | Wél bevestigd als bestaande dienst, maar nog geen besluit of dit een 11e pillar-pagina wordt |
| Case-scope 3 vs. 5 (Kersvers/Wilmar Afbouw) | Logo's bevestigd, case-tekst op de live site zelf nog Lorem Ipsum — scope-beslissing ligt bij de klant |
| Reviews (Esvi advies, Burgman, e.a.) | Publiek zichtbaar op Google, maar hergebruik-toestemming niet gegeven |
| `review_count` (87 vs. 11) | Discrepantie nog niet verklaard |

Zie `VRAGENLIJST-VOOR-KLANT.md` (en de gepubliceerde Artifact-versie) voor
de exacte vragen die deze lijst leeg houden.

---

## Wat er technisch NIET is gewijzigd

Geen enkele wijziging in deze ronde raakte theme-structuur, ACF-
veldgroepen, schema-architectuur of CSS — puur databasewaarden in de
lokale preview (`founder_name`/`founder_role`) plus één config-default
(`address_postcode` in `inc/site-options.php`, al eerder toegepast).
Alle 34 PHP-bestanden blijven lint-schoon.
