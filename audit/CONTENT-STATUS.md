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

## Beslist: dienst- en locatiestructuur bijgewerkt naar de juli-feedback

Op basis van `audit/GEVONDEN-BRONMATERIAAL.md` (feedbackdocument van de
klant, 26 juli — ouder dan `WORDPRESS-BUILD-PLAN.md` maar bewust als
leidend aangemerkt) is de structuur bijgewerkt:

**Pillars** — de twee niet-bevestigde namen zijn vervangen door de wél
bevestigde namen uit de juli-feedback en de bijbehorende, al geschreven
tekst uit `docs/content/Teksten nieuwe services Spotlezz.txt`:

| Was (post-ID) | Is nu | Bron van de tekst |
| --- | --- | --- |
| Opleveringsschoonmaak (#15) | **Dieptereiniging** | Reeds geschreven, becommentarieerde tekst |
| Hygiëneservice (#16) | **Specialistische reiniging** | Idem — inclusief gevelreiniging/opleveringsschoonmaak als voorbeelden daarbinnen |

Glasbewassing (#13) en Vloeronderhoud (#14) waren al correct, ongewijzigd.

**Locaties** — vervangen naar de in de feedback genoemde steden, plat
(geen wijken meer, op verzoek):

| Verwijderd | Toegevoegd | Behouden |
| --- | --- | --- |
| Lelystad, Amersfoort, Almere Stad/Buiten/Haven/Poort (4 wijken) | Utrecht, Weesp, Diemen, **Flevoland** | Almere, Amsterdam |

**Let op — Flevoland is een provincie, geen stad.** De feedback noemt
het letterlijk zo tussen de vier andere (wél echte) steden. Dit is
overgenomen zoals aangeleverd, maar is de moeite waard om te bevestigen:
bedoelt de klant hiermee een aparte, regio-brede locatiepagina, of een
specifieke plaats binnen Flevoland (bijvoorbeeld Lelystad, die nu net is
verwijderd)?

Alle nieuwe locatie- en pillar-posts staan met `TEST —`-titels en lege
bewijsvormvelden in de lokale preview — de publish-gate zet ze
automatisch op noindex tot er echt lokaal bewijs is, exact zoals bij elke
eerdere locatie.

---

## Bevestigd als feit, maar nog geen inhoud om in te vullen

Deze zijn *waar*, maar er bestaat geen tekst/foto die we zomaar kunnen
overnemen — dus ook hier: niets ingevuld, wél Pending i.p.v. TEST-content.

| Onderdeel | Status | Wat ontbreekt |
| --- | --- | --- |
| Locatie Amsterdam | Echt werkgebied (bevestigd) | Geen stad-specifieke tekst, foto's, logo's, review of team gevonden — alle bewijsvorm-velden blijven leeg, pagina blijft dus terecht op noindex |
| Locatie Utrecht, Weesp, Diemen, Flevoland | Genoemd in de juli-feedback | Nog geen enkele stad-specifieke tekst/foto/bewijs — alles Pending |
| Pillar Glasbewassing, Vloeronderhoud | Echte dienst (bevestigd) | Geen foto's, geen eigen paginatekst gevonden |
| Pillar Dieptereiniging, Specialistische reiniging | Echte dienst + geschreven tekst beschikbaar | Tekst is nu ingevuld (TEST-gemarkeerd); nog geen eigen foto's |

**Belangrijk:** deze blijven in de lokale preview op hun huidige
`TEST —`-testcontent staan (uit eerdere QA-stappen, nu bijgewerkt) — dat
is QA-materiaal, geen "klaar voor productie"-content. Zodra er echte
tekst/foto's zijn, vervangt dat de testcontent; tot die tijd wordt er
niets verzonnen ter overbrugging.

---

## Nog volledig onbevestigd — hier wordt niets aan gedaan tot de klant reageert

| Onderdeel | Reden |
| --- | --- |
| "Flevoland" als locatiepagina | Provincie, geen stad — bevestigen wat precies bedoeld is (zie hierboven) |
| Pillar "Gevelreiniging" als eigen pagina | Bevestigd als onderdeel van "Specialistische reiniging", nog geen besluit of dit óók een eigen 11e pillar-pagina wordt |
| Case-scope 3 vs. 5 (Kersvers/Wilmar Afbouw) | Logo's bevestigd, case-tekst op de live site zelf nog Lorem Ipsum — scope-beslissing ligt bij de klant |
| Reviews (Esvi advies, Burgman, e.a.) | Publiek zichtbaar op Google, maar hergebruik-toestemming niet gegeven |
| `review_count` (87 vs. 11) | Discrepantie nog niet verklaard |

Zie `VRAGENLIJST-VOOR-KLANT.md` (en de gepubliceerde Artifact-versie) voor
de exacte vragen die deze lijst leeg houden — die twee bestanden zijn nog
niet bijgewerkt met de nieuwe dienst-/locatiestructuur, dat is de
logische vervolgstap.

---

## Wat er technisch NIET is gewijzigd

Geen enkele wijziging in deze ronde raakte theme-structuur, ACF-
veldgroepen, schema-architectuur of CSS — puur databasewaarden in de
lokale preview (`founder_name`/`founder_role`) plus één config-default
(`address_postcode` in `inc/site-options.php`, al eerder toegepast).
Alle 34 PHP-bestanden blijven lint-schoon.
