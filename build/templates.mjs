/**
 * Sjablonen voor de pagina's die nieuw gebouwd worden.
 * Elk sjabloon volgt de blokvolgorde uit het bijbehorende wireframe.
 */

import {
  SITE, BRANCHES, SERVICES, ALL_SERVICES, CITIES, CASES, REVIEWS,
  esc, jsonld, organizationNode, founderNode, ratingWithReviews, breadcrumbNode,
  ORG_ID, FOUNDER_ID, addressLine, postalAddress,
  head, skipLink, topBar, header, mobileNav, breadcrumb, nextHop, footer,
  stickyCta, scripts, contactForm, quickQuoteForm, checklistForm,
  answerBlock, reviewBlock, faqAccordion, faqSchema, regionBlock,
} from './site.mjs';

import { SERVICE_CONTENT, SERVICE_CASES } from './content-services.mjs';
import { LOCATION_CONTENT } from './content-locations.mjs';
import { FAQ_THEMES, ALL_FAQ, FAQ_DETAILS, faqForService } from './content-faq.mjs';

const svc = (slug) => ALL_SERVICES.find((s) => s.slug === slug);
const city = (slug) => CITIES.find((c) => c.slug === slug);
const kase = (slug) => CASES.find((c) => c.slug === slug);

/** Casusd rechthoek met foto, titel en doorklik. */
function caseCard(c) {
  return `    <article class="proof-card">
      <a href="/klantcases/${c.slug}/" class="proof-media" tabindex="-1" aria-label="Klantcase ${esc(c.client)}">
        <img src="${c.image}" alt="Spotlezz aan het werk bij ${esc(c.client)}, ${esc(c.branche.toLowerCase())} in ${esc(c.city)}" loading="lazy">
      </a>
      <div class="proof-body">
        <span class="proof-meta">${esc(c.branche)} &middot; ${esc(c.city)}</span>
        <h3><a href="/klantcases/${c.slug}/">${esc(c.client)}</a></h3>
        <p>${esc(c.teaser)}</p>
        <a class="proof-link" href="/klantcases/${c.slug}/">Lees de case over ${esc(c.client)}</a>
      </div>
    </article>`;
}

function photoRow(items) {
  return `<section class="photo-row" aria-label="Beeld">
  <div class="photo-grid">
${items.map((p) => `    <figure class="photo-item">
      <img src="${p.src}" alt="${esc(p.alt)}" loading="lazy">
      <figcaption>${esc(p.caption)}</figcaption>
    </figure>`).join('\n')}
  </div>
</section>`;
}

function employeeBlock(e, photo) {
  return `<section class="person-block" aria-label="Medewerker aan het woord">
  <div class="person-card">
    <div class="person-head">
      <span class="person-avatar" aria-hidden="true">${esc(e.name.charAt(0))}</span>
      <div>
        <p class="person-name">${esc(e.name)}</p>
        <p class="person-role">${esc(e.role)}</p>
      </div>
    </div>
    <blockquote><p>${esc(e.quote)}</p></blockquote>
  </div>
  <figure class="person-photo">
    <img src="${photo}" alt="Medewerkers van Spotlezz aan het werk" loading="lazy">
  </figure>
</section>`;
}

function page({ meta, ld, body }) {
  return `<!DOCTYPE html>
<html lang="nl">
<head>
${head(meta)}
${ld}
</head>
<body>
${skipLink}
${topBar()}
${header()}
${mobileNav()}
${body}
${footer()}
${stickyCta()}
${scripts()}
</body>
</html>
`;
}

/* ================================================================== */
/* Dienstpagina (pillar)                                              */
/* ================================================================== */

export function servicePage(slug) {
  const s = svc(slug);
  const c = SERVICE_CONTENT[slug];
  const faq = faqForService(slug);
  const cases = (SERVICE_CASES[slug] || []).map(kase).filter(Boolean);
  const path = `/diensten/${slug}/`;

  const trail = [
    { label: 'Home', href: '/' },
    { label: 'Diensten', href: '/diensten/' },
    { label: s.service, href: path },
  ];

  const tiles = c.tiles.map((t) => {
    const inner = `<h3>${esc(t.t)}</h3><p>${esc(t.d)}</p>${t.link ? '<span class="tile-link" aria-hidden="true">Bekijk de dienst</span>' : ''}`;
    return t.link
      ? `    <a class="work-tile work-tile-link" href="${t.link}">${inner}</a>`
      : `    <div class="work-tile">${inner}</div>`;
  }).join('\n');

  const steps = c.steps.map((st, i) => `    <li class="step-card">
      <span class="step-num" aria-hidden="true">${i + 1}</span>
      <h3>${esc(st.t)}</h3>
      <p>${esc(st.d)}</p>
    </li>`).join('\n');

  const prose = c.sections.map((sec) => `  <section class="prose-block">
    <h2>${esc(sec.h)}</h2>
${sec.p.map((p) => `    <p>${esc(p)}</p>`).join('\n')}
  </section>`).join('\n');

  const ld = jsonld({
    '@context': 'https://schema.org',
    '@graph': [
      organizationNode(),
      founderNode(),
      breadcrumbNode(trail),
      {
        '@type': 'Service',
        '@id': SITE.origin + path + '#service',
        name: s.service,
        description: s.description,
        url: SITE.origin + path,
        serviceType: s.service,
        provider: { '@id': ORG_ID },
        areaServed: CITIES.filter((x) => x.type === 'stad').map((x) => ({ '@type': 'City', name: x.name })),
        hasOfferCatalog: {
          '@type': 'OfferCatalog',
          name: `Onderdelen van ${s.service.toLowerCase()}`,
          itemListElement: c.tiles.map((t) => ({
            '@type': 'Offer', itemOffered: { '@type': 'Service', name: t.t },
          })),
        },
        ...ratingWithReviews(REVIEWS.slice(0, 3)),
      },
      faqSchema(faq),
    ],
  });

  const body = `<main id="main">
${breadcrumb(trail)}

<section class="pillar-hero">
  <div class="pillar-hero-copy">
    <h1>${esc(s.h1)}</h1>
    <p class="pillar-lead">${esc(c.intro)}</p>
    <ul class="usp-pills">
      <li>Afspraak binnen 12 uur</li>
      <li>Vast aanspreekpunt</li>
      <li>94% verlengt het contract</li>
    </ul>
    <div class="hero-actions">
      <a href="/offerte-aanvragen/" class="btn btn-orange">Offerte aanvragen</a>
      <a href="tel:${SITE.phoneRaw}" class="btn btn-outline-dark">Bel ${SITE.phone}</a>
    </div>
  </div>
  <aside class="pillar-hero-form">
${quickQuoteForm({ id: `sq-${slug}`, dienst: s.service })}
  </aside>
</section>

${answerBlock({ paragraph: esc(c.answer), facts: c.facts })}

<section class="work-block">
  <h2>Wat wij precies doen bij ${esc(s.service.toLowerCase())}</h2>
  <div class="work-grid">
${tiles}
  </div>
</section>

${prose}

<section class="steps-block">
  <h2>Hoe het werkt in vier stappen</h2>
  <ol class="steps-grid">
${steps}
  </ol>
</section>

<section class="compare-block">
  <h2>Spotlezz vergeleken met andere bedrijven</h2>
  <div class="compare-grid">
    <div class="compare-card compare-spotlezz">
      <h3>Spotlezz</h3>
      <ul class="compare-list">
        <li>Altijd een vaste schoonmaker</li>
        <li>Reactie binnen 12 uur</li>
        <li>Wekelijkse kwaliteitscontroles</li>
        <li>100% ecologische producten</li>
        <li>Opzegtermijn van een maand</li>
      </ul>
    </div>
    <div class="compare-card compare-others">
      <h3>Andere bedrijven</h3>
      <ul class="compare-list compare-list-negative">
        <li>Wisselende gezichten</li>
        <li>Trage communicatie</li>
        <li>Geen vastgelegde controles</li>
        <li>Standaard chemische middelen</li>
        <li>Jaarcontract met stilzwijgende verlenging</li>
      </ul>
    </div>
  </div>
  <div class="compare-cta">
    <a href="/offerte-aanvragen/" class="btn btn-orange btn-lg">Vraag een offerte aan</a>
    <p>Vrijblijvend. Reactie binnen 12 uur op werkdagen.</p>
  </div>
</section>

${photoRow([
  { src: '/images/stap-team-start.jpg', alt: `Twee medewerkers van Spotlezz aan het werk tijdens ${s.service.toLowerCase()}`, caption: 'Ons team aan het werk' },
  { src: '/images/kantoor-detail.jpg', alt: `Detailwerk tijdens ${s.service.toLowerCase()} door Spotlezz`, caption: 'Het verschil zit in het detail' },
  { src: '/images/materiaal-producten.jpg', alt: 'Medewerker van Spotlezz met microvezeldoek en ecologische reiniger', caption: 'Materiaal en producten' },
])}

${reviewBlock(REVIEWS.slice(0, 3))}

${employeeBlock(c.employee, '/images/stap-resultaat.jpg')}

<section class="proof-block">
  <h2>Klantcases</h2>
  <div class="proof-grid">
${cases.map(caseCard).join('\n')}
  </div>
</section>

${regionBlock(s.service)}

<section class="faq-block">
  <h2>Veelgestelde vragen over ${esc(s.service.toLowerCase())}</h2>
${faqAccordion(faq, { idPrefix: `faq-${slug}` })}
  <p class="faq-more"><a href="/veelgestelde-vragen/">Bekijk alle veelgestelde vragen</a></p>
</section>

${nextHop({
  up: { href: '/diensten/', label: 'Alle diensten' },
  side: { href: `/klantcases/${cases[0] ? cases[0].slug : ''}/`, label: `Klantcase ${cases[0] ? cases[0].client : ''}` },
  cta: { href: '/offerte-aanvragen/', label: 'Vraag je offerte aan' },
})}
</main>`;

  return page({
    meta: { title: s.title, description: s.description, path },
    ld,
    body,
  });
}

/* ================================================================== */
/* Locatiepagina                                                      */
/* ================================================================== */

export function locationPage(slug) {
  const ct = city(slug);
  const c = LOCATION_CONTENT[slug];
  const path = `/locaties/${slug}/`;
  const isWijk = ct.type === 'wijk';
  const cs = kase(c.caseSlug);

  const trail = isWijk
    ? [{ label: 'Home', href: '/' }, { label: 'Locaties', href: '/locaties/' },
       { label: 'Almere', href: '/locaties/almere/' }, { label: ct.name, href: path }]
    : [{ label: 'Home', href: '/' }, { label: 'Locaties', href: '/locaties/' },
       { label: ct.name, href: path }];

  const top3 = c.topServices.map(svc).filter(Boolean).map((s) => `    <a class="work-tile work-tile-link" href="/diensten/${s.slug}/">
      <h3>${esc(s.service)} ${esc(ct.name)}</h3>
      <p>${esc(s.description.split('.')[0])}.</p>
      <span class="tile-link" aria-hidden="true">Bekijk de dienst</span>
    </a>`).join('\n');

  const wijken = CITIES.filter((x) => x.parent === 'almere');
  const wijkBlok = slug === 'almere' ? `
  <h3 class="sub-heading">Wijken in Almere</h3>
  <div class="pill-row">
${wijken.map((w) => `    <a href="/locaties/${w.slug}/" class="pill">${esc(w.name)}</a>`).join('\n')}
  </div>` : '';

  const andere = CITIES.filter((x) => x.slug !== slug && (isWijk ? true : x.type === 'stad' || x.parent === 'almere'));

  // De hoofdvestiging staat in Almere. Op de Almeerse pagina's is dat het
  // bezoekadres, elders benoemen wij het als hoofdvestiging waar de teams
  // vandaan rijden. Nooit hetzelfde adres tonen alsof het een lokaal filiaal is.
  const adres = esc(addressLine());
  const isAlmere = slug === 'almere' || ct.parent === 'almere';
  const napAdres = isAlmere
    ? `<li><strong>Bezoekadres</strong> ${adres}</li>`
    : `<li><strong>Hoofdvestiging</strong> ${adres}. Onze teams rijden vanuit Almere naar ${esc(ct.name)}.</li>`;

  const ld = jsonld({
    '@context': 'https://schema.org',
    '@graph': [
      organizationNode(),
      founderNode(),
      breadcrumbNode(trail),
      {
        '@type': 'CleaningService',
        '@id': SITE.origin + path + '#localbusiness',
        name: `Spotlezz ${ct.name}`,
        description: c.description,
        url: SITE.origin + path,
        parentOrganization: { '@id': ORG_ID },
        telephone: SITE.phoneIntl,
        email: SITE.email,
        priceRange: '$$',
        image: SITE.origin + '/images/og-deelafbeelding.jpg',
        address: postalAddress(),
        areaServed: { '@type': isWijk ? 'Place' : 'City', name: ct.name },
        openingHoursSpecification: [{
          '@type': 'OpeningHoursSpecification',
          dayOfWeek: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
          opens: '08:00', closes: '18:00',
        }],
        makesOffer: c.topServices.map(svc).filter(Boolean).map((s) => ({
          '@type': 'Offer',
          itemOffered: { '@type': 'Service', name: `${s.service} ${ct.name}` },
        })),
        ...ratingWithReviews([{ ...c.reviewer, text: c.review }]),
      },
      faqSchema(c.faq),
    ],
  });

  const body = `<main id="main">
${breadcrumb(trail)}

<section class="loc-hero">
  <div class="loc-hero-copy">
    <h1>${esc(c.h1)}</h1>
    <p class="pillar-lead">${esc(c.intro)}</p>
    <ul class="usp-pills">
      <li>Binnen 12 uur een afspraak</li>
      <li>Vaste teams in de regio</li>
      <li>${SITE.rating}/5 uit ${SITE.reviewCount} beoordelingen</li>
    </ul>
    <div class="hero-actions">
      <a href="/offerte-aanvragen/" class="btn btn-orange">Offerte voor ${esc(ct.name)}</a>
      <a href="tel:${SITE.phoneRaw}" class="btn btn-outline-dark">Bel ${SITE.phone}</a>
    </div>
  </div>
  <aside class="loc-hero-side">
    <figure class="loc-map">
      <img src="/images/werkgebied-kaart.svg" alt="Kaart van het werkgebied van Spotlezz rond ${esc(ct.name)}" width="640" height="360" loading="lazy">
    </figure>
    <div class="nap-block">
      <h2>Gegevens en werkgebied</h2>
      <ul class="nap-list">
        <li><strong>Naam</strong> ${esc(SITE.legalName)}</li>
        <li><strong>Telefoon</strong> <a href="tel:${SITE.phoneRaw}">${SITE.phone}</a></li>
        <li><strong>E-mail</strong> <a href="mailto:${SITE.email}">${SITE.email}</a></li>
        <li><strong>Openingstijden</strong> ${esc(SITE.openingHours)}</li>
        <li><strong>Werkgebied</strong> ${esc(ct.name)} en omgeving</li>
        ${napAdres}
      </ul>
    </div>
  </aside>
</section>

${answerBlock({ paragraph: esc(c.answer), facts: c.facts })}

<section class="proof-block">
  <h2>Lokaal bewijs uit ${esc(ct.name)}</h2>
  <div class="local-proof">
${caseCard(cs)}
    <figure class="review-card review-card-local">
      <div class="review-stars" aria-label="5 van de 5 sterren">â˜…â˜…â˜…â˜…â˜…</div>
      <blockquote><p>${esc(c.review)}</p></blockquote>
      <figcaption>
        <span class="review-avatar" aria-hidden="true">${esc(c.reviewer.initial)}</span>
        <span>
          <span class="review-name">${esc(c.reviewer.name)}</span>
          <span class="review-role">${esc(c.reviewer.role)}, ${esc(c.reviewer.city)}</span>
        </span>
      </figcaption>
    </figure>
  </div>
</section>

<section class="work-block">
  <h2>Veelgevraagde diensten in ${esc(ct.name)}</h2>
  <div class="work-grid work-grid-3">
${top3}
  </div>${wijkBlok}
</section>

<section class="prose-block">
  <h2>${esc(c.areaHeading)}</h2>
${c.area.map((p) => `  <p>${esc(p)}</p>`).join('\n')}
</section>

${photoRow([
  { src: '/images/stap-team-start.jpg', alt: 'Twee medewerkers van Spotlezz aan het werk in een kantoor', caption: 'Ons team aan het werk' },
  { src: '/images/branche-kantoor-schoon.jpg', alt: 'Kantoorpand uit het werkgebied van Spotlezz', caption: 'Een pand uit ons werkgebied' },
  { src: '/images/materiaal-producten.jpg', alt: 'Medewerker van Spotlezz met microvezeldoek en ecologische reiniger', caption: 'Materiaal en producten' },
])}

${employeeBlock(c.team, '/images/stap-resultaat.jpg')}

<section class="faq-block">
  <h2>Veelgestelde vragen over schoonmaak in ${esc(ct.name)}</h2>
${faqAccordion(c.faq, { idPrefix: `faq-${slug}` })}
  <p class="faq-more"><a href="/veelgestelde-vragen/">Bekijk alle veelgestelde vragen</a></p>
</section>

<section class="region-block">
  <h2>Andere plaatsen in ons werkgebied</h2>
  <div class="pill-row">
${andere.map((x) => `    <a href="/locaties/${x.slug}/" class="pill">${esc(x.name)}</a>`).join('\n')}
  </div>
</section>

${nextHop({
  up: { href: '/locaties/', label: 'Alle locaties' },
  side: { href: `/klantcases/${cs.slug}/`, label: `Klantcase ${cs.client}` },
  cta: { href: '/offerte-aanvragen/', label: `Offerte voor ${ct.name}` },
})}
</main>`;

  return page({
    meta: { title: c.title, description: c.description, path },
    ld,
    body,
  });
}

/* ================================================================== */
/* Locatie-hub                                                        */
/* ================================================================== */

export function locationsHub() {
  const path = '/locaties/';
  const trail = [{ label: 'Home', href: '/' }, { label: 'Locaties', href: path }];
  const steden = CITIES.filter((c) => c.type === 'stad');
  const wijken = CITIES.filter((c) => c.type === 'wijk');

  const cards = steden.map((c) => {
    const lc = LOCATION_CONTENT[c.slug];
    return `    <a class="loc-card" href="/locaties/${c.slug}/">
      <h3>Schoonmaakbedrijf ${esc(c.name)}</h3>
      <p>${esc(lc.intro.split('.')[0])}.</p>
      <span class="tile-link" aria-hidden="true">Bekijk ${esc(c.name)}</span>
    </a>`;
  }).join('\n');

  const ld = jsonld({
    '@context': 'https://schema.org',
    '@graph': [
      organizationNode(),
      founderNode(),
      breadcrumbNode(trail),
      {
        '@type': 'CollectionPage',
        '@id': SITE.origin + path + '#page',
        name: 'Locaties',
        url: SITE.origin + path,
        about: { '@id': ORG_ID },
        hasPart: CITIES.map((c) => ({
          '@type': 'WebPage',
          name: `Schoonmaakbedrijf ${c.name}`,
          url: `${SITE.origin}/locaties/${c.slug}/`,
        })),
      },
    ],
  });

  const body = `<main id="main">
${breadcrumb(trail)}

<section class="hub-hero">
  <h1>Ons werkgebied</h1>
  <p class="pillar-lead">Wij werken met vaste teams vanuit Almere. Op elke locatiepagina staat wat wij daar precies doen, welke bedrijventerreinen wij bedienen en hoe snel wij er kunnen zijn.</p>
  <div class="hero-actions">
    <a href="/offerte-aanvragen/" class="btn btn-orange">Offerte aanvragen</a>
    <a href="tel:${SITE.phoneRaw}" class="btn btn-outline-dark">Bel ${SITE.phone}</a>
  </div>
</section>

<section class="work-block">
  <h2>Steden</h2>
  <div class="loc-grid">
${cards}
  </div>
</section>

<section class="work-block">
  <h2>Stadsdelen in Almere</h2>
  <p>Almere is te groot om vanuit een punt te bedienen. Wij rijden vier routes, een per stadsdeel.</p>
  <div class="pill-row">
${wijken.map((w) => `    <a href="/locaties/${w.slug}/" class="pill">${esc(w.name)}</a>`).join('\n')}
  </div>
</section>

<section class="prose-block">
  <h2>Waarom wij niet overal werken</h2>
  <p>Een schoonmaakbedrijf dat zegt landelijk te werken, rijdt in de praktijk met wisselend personeel en lange reistijden. Wij houden ons werkgebied bewust beperkt tot de plaatsen waar wij een vast team kunnen neerzetten en waar wij bij een calamiteit binnen enkele uren kunnen zijn.</p>
  <p>Dat betekent Almere en de vier stadsdelen als kern, en Lelystad, Amsterdam en Amersfoort op vaste routedagen. Op die routedagen bundelen wij alle afspraken in dezelfde plaats, zodat de reistijd niet in uw tarief terechtkomt en een spoedmelding dezelfde dag nog opgepakt kan worden.</p>
  <p>Krijgen wij een aanvraag van buiten dit gebied, dan zeggen wij dat eerlijk. Liever dat dan een contract waarbij de schoonmaker een uur onderweg is en de eerste de beste ochtendspits al roet in het eten gooit.</p>
</section>

${nextHop({
  up: { href: '/', label: 'Naar de homepage' },
  side: { href: '/diensten/', label: 'Bekijk onze diensten' },
  cta: { href: '/offerte-aanvragen/', label: 'Vraag je offerte aan' },
})}
</main>`;

  return page({
    meta: {
      title: 'Werkgebied: Almere, Lelystad, Amsterdam en Amersfoort | Spotlezz',
      description: 'Het werkgebied van Spotlezz: Almere met vier stadsdelen, plus Lelystad, Amsterdam en Amersfoort op vaste routedagen. Bekijk de locatiepagina van uw plaats.',
      path,
    },
    ld,
    body,
  });
}

/* ================================================================== */
/* FAQ-hub                                                            */
/* ================================================================== */

export function faqHub() {
  const path = '/veelgestelde-vragen/';
  const trail = [{ label: 'Home', href: '/' }, { label: 'Veelgestelde vragen', href: path }];

  const filters = `  <div class="faq-filters" role="group" aria-label="Filter op thema">
    <button type="button" class="faq-filter is-active" data-theme="alles">Alles</button>
${FAQ_THEMES.map((t) => `    <button type="button" class="faq-filter" data-theme="${t.slug}">${esc(t.label)}</button>`).join('\n')}
  </div>`;

  const themes = FAQ_THEMES.map((t) => {
    const rows = t.items.map((q, i) => {
      const id = `${t.slug}-${i}`;
      const detailLink = q.detail
        ? `<p class="faq-detail-link"><a href="/veelgestelde-vragen/${q.detail}/">Lees het volledige antwoord</a></p>`
        : '';
      return `    <div class="faq-item">
      <h3 class="faq-question-wrap">
        <button type="button" class="faq-question" id="q-${id}" aria-expanded="false" aria-controls="a-${id}">
          <span>${esc(q.q)}</span>
          <span class="faq-icon" aria-hidden="true"></span>
        </button>
      </h3>
      <div class="faq-answer" id="a-${id}" role="region" aria-labelledby="q-${id}" hidden>
        <div class="faq-answer-inner"><p>${esc(q.a)}</p>${detailLink}</div>
      </div>
    </div>`;
    }).join('\n');
    return `  <section class="faq-theme" data-theme="${t.slug}">
    <h2 id="thema-${t.slug}">${esc(t.label)}</h2>
${rows}
  </section>`;
  }).join('\n');

  const ld = jsonld({
    '@context': 'https://schema.org',
    '@graph': [
      organizationNode(), founderNode(), breadcrumbNode(trail),
      faqSchema(ALL_FAQ),
    ],
  });

  const body = `<main id="main">
${breadcrumb(trail)}

<section class="hub-hero">
  <h1>Veelgestelde vragen</h1>
  <p class="pillar-lead">Alle vragen die wij krijgen over schoonmaak, offertes en samenwerken, gegroepeerd per thema. Staat uw vraag er niet bij, bel ons dan gerust.</p>
  <div class="faq-search">
    <label for="faqSearch">Zoek een vraag</label>
    <input type="search" id="faqSearch" placeholder="Bijvoorbeeld: prijs, avond, vast team" autocomplete="off">
    <p class="faq-search-count" role="status" aria-live="polite"></p>
  </div>
${filters}
</section>

<div class="faq-hub">
${themes}
  <p class="faq-empty" hidden>Geen vraag gevonden. Probeer een ander woord of <a href="/contact/">stel uw vraag rechtstreeks</a>.</p>
</div>

${nextHop({
  up: { href: '/', label: 'Naar de homepage' },
  side: { href: '/diensten/kantoor-schoonmaak/', label: 'Kantoorschoonmaak' },
  cta: { href: '/offerte-aanvragen/', label: 'Offerte op maat aanvragen' },
})}
</main>`;

  return page({
    meta: {
      title: 'Veelgestelde vragen over schoonmaak | Spotlezz',
      description: 'Antwoord op vragen over prijs, frequentie, vaste teams, duurzaamheid en het kiezen van een schoonmaakbedrijf. Gegroepeerd per thema.',
      path,
    },
    ld,
    body,
  });
}

/* ================================================================== */
/* FAQ-detailpagina                                                   */
/* ================================================================== */

export function faqDetailPage(d) {
  const path = `/veelgestelde-vragen/${d.slug}/`;
  const trail = [
    { label: 'Home', href: '/' },
    { label: 'Veelgestelde vragen', href: '/veelgestelde-vragen/' },
    { label: d.theme, href: `/veelgestelde-vragen/#thema-${d.themeSlug}` },
    { label: d.h1, href: path },
  ];
  const p = svc(d.pillar);

  const factors = d.factors.map((f, i) => `    <li class="factor-card">
      <span class="factor-num" aria-hidden="true">${i + 1}</span>
      <h3>${esc(f.title)}</h3>
      <p>${esc(f.body)}</p>
    </li>`).join('\n');

  const ld = jsonld({
    '@context': 'https://schema.org',
    '@graph': [
      organizationNode(), founderNode(), breadcrumbNode(trail),
      {
        '@type': 'QAPage',
        '@id': SITE.origin + path + '#qapage',
        mainEntity: {
          '@type': 'Question',
          name: d.h1,
          text: d.h1,
          answerCount: 1,
          acceptedAnswer: {
            '@type': 'Answer',
            text: d.short,
            url: SITE.origin + path,
          },
        },
      },
    ],
  });

  const body = `<main id="main">
${breadcrumb(trail)}

<article class="qa-page">
  <h1>${esc(d.h1)}</h1>

  <section class="short-answer">
    <h2 class="short-answer-label">Het korte antwoord</h2>
    <p>${esc(d.short)}</p>
  </section>

  <section class="factor-block">
    <h2>Waar het van afhangt</h2>
    <ol class="factor-grid">
${factors}
    </ol>
  </section>

  <section class="qa-cta">
    <div class="qa-cta-copy">
      <h2>Wilt u het precies weten voor uw eigen pand?</h2>
      <p>Wij komen langs, meten per ruimtetype en sturen binnen 24 uur een offerte waarin u per regel ziet waar het bedrag vandaan komt. Vrijblijvend, en zonder dat u eerst een jaarcontract moet tekenen.</p>
      <ul class="usp-pills">
        <li>Reactie binnen 12 uur</li>
        <li>Offerte binnen 24 uur</li>
        <li>Opzegtermijn van een maand</li>
      </ul>
    </div>
    <div class="qa-cta-form">
${contactForm({ id: 'qaForm', heading: 'Vraag een offerte aan', submit: 'Offerte aanvragen', compact: true })}
    </div>
  </section>
</article>

${nextHop({
  up: { href: '/veelgestelde-vragen/', label: 'Alle veelgestelde vragen' },
  side: { href: `/diensten/${p.slug}/`, label: p.service },
  cta: { href: '/offerte-aanvragen/', label: 'Offerte op maat aanvragen' },
})}
</main>`;

  return page({
    meta: { title: d.title, description: d.description, path },
    ld,
    body,
  });
}

/* ================================================================== */
/* Reviewspagina                                                      */
/* ================================================================== */

export function reviewsPage() {
  const path = '/reviews/';
  const trail = [{ label: 'Home', href: '/' }, { label: 'Reviews', href: path }];

  const cards = REVIEWS.map((r) => {
    const s = svc(r.branche);
    return `    <figure class="review-card">
      <div class="review-stars" aria-label="5 van de 5 sterren">â˜…â˜…â˜…â˜…â˜…</div>
      <blockquote><p>${esc(r.text)}</p></blockquote>
      <figcaption>
        <span class="review-avatar" aria-hidden="true">${esc(r.initial)}</span>
        <span>
          <span class="review-name">${esc(r.name)}</span>
          <span class="review-role">${esc(r.role)}, ${esc(r.city)}</span>
        </span>
      </figcaption>
      ${s ? `<a class="review-tag" href="/diensten/${s.slug}/">${esc(s.service)}</a>` : ''}
    </figure>`;
  }).join('\n');

  const ld = jsonld({
    '@context': 'https://schema.org',
    '@graph': [
      { ...organizationNode(), ...ratingWithReviews(REVIEWS) },
      founderNode(),
      breadcrumbNode(trail),
    ],
  });

  const body = `<main id="main">
${breadcrumb(trail)}

<section class="hub-hero">
  <h1>Reviews over Spotlezz</h1>
  <p class="pillar-lead">Gemiddeld ${SITE.rating} uit 5 op basis van ${SITE.reviewCount} beoordelingen. Hieronder een selectie met naam, functie en plaats erbij, zodat u kunt zien wie het zegt.</p>
  <div class="hero-actions">
    <a href="${SITE.googleMaps}" class="btn btn-outline-dark" target="_blank" rel="noopener">Bekijk de beoordelingen op Google</a>
    <a href="/offerte-aanvragen/" class="btn btn-orange">Offerte aanvragen</a>
  </div>
</section>

<section class="review-section">
  <div class="review-grid review-grid-full">
${cards}
  </div>
</section>

<section class="prose-block">
  <h2>Waarom wij geen anonieme reviews plaatsen</h2>
  <p>Een citaat zonder naam is niet te controleren en telt daarom voor niemand mee, ook niet voor een zoekmachine. Elke review op deze pagina staat er met naam, functie en plaats, en is afkomstig van een klant die daar toestemming voor heeft gegeven.</p>
  <p>De gemiddelde score van ${SITE.rating} komt uit ons Google-bedrijfsprofiel en is daar door iedereen na te lezen. Wij plaatsen op deze pagina geen reviews die daar niet ook staan of die niet rechtstreeks bij ons zijn achtergelaten.</p>
</section>

${nextHop({
  up: { href: '/', label: 'Naar de homepage' },
  side: { href: '/klantcases/', label: 'Bekijk de klantcases' },
  cta: { href: '/offerte-aanvragen/', label: 'Vraag je offerte aan' },
})}
</main>`;

  return page({
    meta: {
      title: `Reviews: ${SITE.rating}/5 uit ${SITE.reviewCount} beoordelingen | Spotlezz`,
      description: `Lees wat klanten van Spotlezz zeggen. Gemiddeld ${SITE.rating} uit 5 op basis van ${SITE.reviewCount} beoordelingen, met naam, functie en plaats.`,
      path,
    },
    ld,
    body,
  });
}
