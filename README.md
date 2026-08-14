# Spotlezz

Statische site. De HTML in `spotlezz.vercel.app/` wordt gegenereerd door de
scripts in `build/` en is gecommit, zodat Vercel gewoon bestanden serveert en er
geen buildstap op de server draait.

## Werken aan de site

```bash
npm run dev      # lokale preview op http://localhost:4321
npm run build    # regenereert alles in spotlezz.vercel.app/
```

`npm run build` doet eerst `git checkout -- spotlezz.vercel.app`. Dat is met
opzet: de build werkt vanaf de originele bron en is daardoor herhaalbaar. Bewerk
dus nooit rechtstreeks een bestand in `spotlezz.vercel.app/` dat door de build
wordt aangeraakt, want dat wordt overschreven.

Eenmalig, of als er nieuwe afbeeldingen bij komen:

```bash
npm run build:assets   # haalt ontbrekende afbeeldingen op van spotlezz.nl
```

## Waar staat wat

| Bestand | Inhoud |
| --- | --- |
| `build/site.mjs` | Bedrijfsgegevens, diensten, locaties, cases, reviews en alle gedeelde HTML-blokken (head, navigatie, breadcrumb, next-hop, footer, formulieren) |
| `build/templates.mjs` | Paginasjablonen voor dienst, locatie, hubs, FAQ-detail en reviews |
| `build/content-services.mjs` | Teksten van de vier nieuwe dienst-pillars |
| `build/content-locations.mjs` | Teksten van de acht locatiepagina's |
| `build/content-faq.mjs` | Alle FAQ-vragen en de drie detailpagina's |
| `build/styles.css` | Styling voor de nieuwe componenten; wordt in `style.css` geïnjecteerd tussen markers |
| `build/main.js` | Bron van `spotlezz.vercel.app/main.js` |
| `build/build.mjs` | Orchestrator |
| `build/serve.mjs` | Lokale server die Vercel nabootst, inclusief redirects |
| `build/TE-CONTROLEREN.md` | Wat Spotlezz zelf moet aanleveren of bevestigen |

Bestaande pagina's zoals de homepage en de zes branchepagina's houden hun eigen
inhoud. De build legt daar alleen de gedeelde onderdelen overheen en repareert
links, metadata en afbeeldingen. De nieuwe pagina's worden volledig uit de
sjablonen gegenereerd.

## Structuur

Vijf hubs, zoals in de wireframes:

- `/diensten/` met zes branches en vier specialismen
- `/klantcases/` met drie cases
- `/locaties/` met vier steden en vier Almeerse wijken
- `/veelgestelde-vragen/` met 25 vragen en drie detailpagina's
- `/over-ons/`

Elke pagina heeft een breadcrumb bovenaan en een next-hop bar met exact drie
routes onderaan: omhoog, zijwaarts, conversie.

## Voor de livegang

1. Vul `FORM_ENDPOINT` in `build/main.js` en draai de build opnieuw.
2. Werk `build/TE-CONTROLEREN.md` af.
3. Zet `SITE.origin` in `build/site.mjs` op het definitieve domein als dat niet
   `https://spotlezz.nl` wordt.

De `X-Robots-Tag: noindex` in `vercel.json` geldt alleen voor `*.vercel.app`, dus
het productiedomein wordt gewoon geïndexeerd zodra de site daar staat.
