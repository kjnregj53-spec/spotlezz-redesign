/**
 * Spotlezz - centrale sitedata en gedeelde HTML-blokken.
 *
 * Alles wat op meer dan een pagina voorkomt staat hier. De losse pagina's in
 * spotlezz.vercel.app/ worden door build.mjs bijgewerkt met deze blokken, zodat
 * navigatie, footer, head en formulieren nooit meer uit elkaar kunnen lopen.
 */

/* ------------------------------------------------------------------ */
/* Basisgegevens                                                       */
/* ------------------------------------------------------------------ */

export const SITE = {
  // Domein waar deze site uiteindelijk op komt te staan. De canonical wijst
  // hiernaar. De vercel.app-preview krijgt via vercel.json een noindex-header,
  // zodat de preview nooit met dit domein concurreert.
  origin: 'https://spotlezz.nl',
  name: 'Spotlezz',
  legalName: 'Spotlezz B.V.',
  phone: '036-785 7028',
  phoneRaw: '0367857028',
  phoneIntl: '+31367857028',
  email: 'info@spotlezz.nl',
  rating: '4,8',
  ratingSchema: '4.8',
  reviewCount: '87',
  googleMaps: 'https://maps.app.goo.gl/7RzGUeLmPhhdLbwo7',
  terms: 'https://spotlezz.nl/wp-content/uploads/2026/07/Algemene-voorwaarden-Spotlezz-BV.pdf',
  address: {
    street: 'Kiekstraat 59',
    postalCode: '1087 BR',
    city: 'Amsterdam',
    country: 'NL',
  },
  openingHours: 'Ma t/m vr 08:00 tot 18:00',
  year: 2026,
};

/* ------------------------------------------------------------------ */
/* Diensten: twee assen                                                */
/* ------------------------------------------------------------------ */

/** As 1: voor wie (branche). Deze pagina's bestonden al. */
export const BRANCHES = [
  { slug: 'kantoor-schoonmaak', nav: 'Kantoor schoonmaak', short: 'Kantoor',
    h1: 'Kantoorschoonmaak in Almere, Lelystad en Amsterdam',
    service: 'Kantoorschoonmaak',
    title: 'Kantoorschoonmaak Almere, Lelystad en Amsterdam | Spotlezz',
    description: 'Kantoorschoonmaak met een vast team, wekelijkse controles en 100% ecologische producten. Binnen 12 uur een afspraak in Almere, Lelystad en Amsterdam.' },
  { slug: 'hotel-schoonmaak', nav: 'Hotel schoonmaak', short: 'Hotel',
    h1: 'Hotelschoonmaak in Almere, Lelystad en Amsterdam',
    service: 'Hotelschoonmaak',
    title: 'Hotelschoonmaak Almere, Lelystad en Amsterdam | Spotlezz',
    description: 'Hotelschoonmaak met vaste teams voor kamers, publieke ruimtes en sanitair. Werkbaar rond check-in en check-out. Binnen 12 uur een afspraak.' },
  { slug: 'showroom-schoonmaak', nav: 'Showroom schoonmaak', short: 'Showroom',
    h1: 'Showroomschoonmaak in Almere, Lelystad en Amsterdam',
    service: 'Showroomschoonmaak',
    title: 'Showroomschoonmaak Almere, Lelystad en Amsterdam | Spotlezz',
    description: 'Streeploze showrooms, schone glaspartijen en representatieve vloeren. Showroomschoonmaak met een vast team in Almere, Lelystad en Amsterdam.' },
  { slug: 'fitnesscentrum-schoonmaak', nav: 'Fitnesscentrum schoonmaak', short: 'Sportschool',
    h1: 'Schoonmaak voor sportscholen in Almere, Lelystad en Amsterdam',
    service: 'Fitnesscentrumschoonmaak',
    title: 'Sportschool schoonmaken Almere, Lelystad en Amsterdam | Spotlezz',
    description: 'Dieptereiniging van sportapparatuur, kleedkamers en douches. Schoonmaak voor sportscholen met vaste teams en dagelijkse desinfectie.' },
  { slug: 'kinderopvang-schoonmaak', nav: 'Kinderopvang schoonmaak', short: 'Kinderopvang',
    h1: 'Kinderopvangschoonmaak in Almere, Lelystad en Amsterdam',
    service: 'Kinderopvangschoonmaak',
    title: 'Kinderopvang schoonmaak Almere, Lelystad en Amsterdam | Spotlezz',
    description: 'Schoonmaak voor kinderdagverblijven met kindveilige, ecologische producten en vaste gezichten. Binnen 12 uur een afspraak.' },
  { slug: 'vve-schoonmaak', nav: 'VvE schoonmaak', short: 'VvE',
    h1: 'VvE-schoonmaak in Almere, Lelystad en Amsterdam',
    service: 'VvE-schoonmaak',
    title: 'VvE schoonmaak Almere, Lelystad en Amsterdam | Spotlezz',
    description: 'Schoonmaak van trappenhuizen, galerijen, liften en bergingen voor VvE en beheerder. Vast team, vaste dag, een aanspreekpunt.' },
];

/** As 2: wat we doen (dienst). Deze pagina's zijn nieuw. */
export const SERVICES = [
  { slug: 'glasbewassing', nav: 'Glasbewassing', short: 'Glasbewassing',
    h1: 'Glasbewassing in Almere, Lelystad en Amsterdam',
    service: 'Glasbewassing',
    title: 'Glasbewassing Almere, Lelystad en Amsterdam | Spotlezz',
    description: 'Glasbewassing binnen en buiten, met vaste rondes en werken op hoogte volgens de richtlijnen. Vraag een offerte aan voor uw pand.' },
  { slug: 'vloeronderhoud', nav: 'Vloeronderhoud', short: 'Vloeronderhoud',
    h1: 'Vloeronderhoud in Almere, Lelystad en Amsterdam',
    service: 'Vloeronderhoud',
    title: 'Vloeronderhoud Almere, Lelystad en Amsterdam | Spotlezz',
    description: 'Vloeronderhoud voor pvc, linoleum, beton en tapijt. Periodiek schrobben, kristalliseren en dieptereiniging door een vast team.' },
  { slug: 'opleveringsschoonmaak', nav: 'Opleveringsschoonmaak', short: 'Oplevering',
    h1: 'Opleveringsschoonmaak in Almere, Lelystad en Amsterdam',
    service: 'Opleveringsschoonmaak',
    title: 'Opleveringsschoonmaak Almere, Lelystad en Amsterdam | Spotlezz',
    description: 'Bouw- en opleveringsschoonmaak voor nieuwbouw, verbouwing en einde huur. Op afgesproken datum bezemschoon of sleutelklaar opgeleverd.' },
  { slug: 'hygieneservice', nav: 'Hygiëneservice', short: 'Hygiëneservice',
    h1: 'Hygiëneservice in Almere, Lelystad en Amsterdam',
    service: 'Hygiëneservice',
    title: 'Hygiëneservice Almere, Lelystad en Amsterdam | Spotlezz',
    description: 'Sanitaire voorzieningen, dispensers en verbruiksartikelen in beheer. Nooit meer een lege zeepdispenser of toiletrol.' },
];

export const ALL_SERVICES = [...BRANCHES, ...SERVICES];

/* ------------------------------------------------------------------ */
/* Locaties                                                            */
/* ------------------------------------------------------------------ */

export const CITIES = [
  { slug: 'almere', name: 'Almere', type: 'stad' },
  { slug: 'lelystad', name: 'Lelystad', type: 'stad' },
  { slug: 'amsterdam', name: 'Amsterdam', type: 'stad' },
  { slug: 'amersfoort', name: 'Amersfoort', type: 'stad' },
  { slug: 'almere-stad', name: 'Almere Stad', type: 'wijk', parent: 'almere' },
  { slug: 'almere-buiten', name: 'Almere Buiten', type: 'wijk', parent: 'almere' },
  { slug: 'almere-haven', name: 'Almere Haven', type: 'wijk', parent: 'almere' },
  { slug: 'almere-poort', name: 'Almere Poort', type: 'wijk', parent: 'almere' },
];

/* ------------------------------------------------------------------ */
/* Klantcases                                                          */
/* ------------------------------------------------------------------ */

export const CASES = [
  { slug: 'kobelco', client: 'Kobelco', branche: 'Kantoor', city: 'Almere',
    logo: '/images/kobelco.png',
    h1: 'Nul klachten in achttien maanden bij Kobelco in Almere',
    teaser: 'Lees hoe wij het Europese hoofdkantoor in Almere dagelijks van een streeploos resultaat voorzien.',
    services: ['kantoor-schoonmaak', 'glasbewassing', 'hygieneservice'] },
  { slug: 'kuchentreff', client: 'KuchenTreff', branche: 'Showroom', city: 'Almere',
    logo: '/images/floor.png',
    h1: 'Een streeploze showroom bij KuchenTreff, ook op zaterdag',
    teaser: 'Streeploze showroom en schone werkplekken voor medewerkers en klanten.',
    services: ['showroom-schoonmaak', 'glasbewassing', 'vloeronderhoud'] },
  { slug: 'arena-gym', client: 'Arena Gym', branche: 'Sportschool', city: 'Almere',
    logo: '/images/logisnext.png',
    h1: 'Van klachten over de kleedkamers naar een 8,7 bij Arena Gym',
    teaser: 'Dagelijkse dieptereiniging van sportapparatuur, kleedkamers en douches.',
    services: ['fitnesscentrum-schoonmaak', 'hygieneservice', 'vloeronderhoud'] },
];

/* ------------------------------------------------------------------ */
/* Reviews                                                             */
/* ------------------------------------------------------------------ */

export const REVIEWS = [
  { initial: 'M', name: 'Martijn van den Berg', role: 'Office Manager', city: 'Almere',
    branche: 'kantoor-schoonmaak',
    text: 'Sinds Spotlezz bij ons de kantoorschoonmaak verzorgt is het eindelijk consequent schoon. Ze reageren snel en de vaste schoonmaakster is een verademing.' },
  { initial: 'S', name: 'Sarah de Wit', role: 'Facility Manager', city: 'Lelystad',
    branche: 'kantoor-schoonmaak',
    text: 'Heel fijn team dat goed meedenkt. We hebben nooit meer klachten over de toiletten of de keuken. Een echte aanrader voor elk kantoor.' },
  { initial: 'J', name: 'Jan-Willem Peters', role: 'Directeur', city: 'Amsterdam',
    branche: 'showroom-schoonmaak',
    text: 'Topkwaliteit en altijd netjes op tijd. Onze medewerkers werken een stuk prettiger in een schoon kantoor. Ga zo door Spotlezz!' },
  { initial: 'R', name: 'Rianne Bakker', role: 'Vestigingsmanager', city: 'Almere',
    branche: 'fitnesscentrum-schoonmaak',
    text: 'De kleedkamers en douches zijn elke ochtend fris. Onze leden merken het en dat zien we terug in de beoordelingen van de club.' },
  { initial: 'P', name: 'Peter Vermeulen', role: 'Bestuurder VvE', city: 'Almere',
    branche: 'vve-schoonmaak',
    text: 'Vaste dag, vaste schoonmaker en een logboek in de hal. Voor het eerst hoeven wij als bestuur er niet meer achteraan te bellen.' },
  { initial: 'L', name: 'Linda Hoekstra', role: 'Locatiemanager', city: 'Almere',
    branche: 'kinderopvang-schoonmaak',
    text: 'Ze werken met producten die veilig zijn voor de kinderen en houden zich aan ons protocol. De GGD-inspectie had geen enkele opmerking.' },
];

/* ------------------------------------------------------------------ */
/* Hulpfuncties                                                        */
/* ------------------------------------------------------------------ */

export const esc = (s) =>
  String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');

export const jsonld = (obj) =>
  `<script type="application/ld+json">\n${JSON.stringify(obj, null, 2)}\n</script>`;

/** Vaste organisatie-node waar alle andere schema naar verwijst. */
export const ORG_ID = `${SITE.origin}/#organization`;
export const FOUNDER_ID = `${SITE.origin}/#thirza`;

export function organizationNode() {
  return {
    '@type': ['Organization', 'CleaningService'],
    '@id': ORG_ID,
    name: SITE.name,
    legalName: SITE.legalName,
    url: SITE.origin + '/',
    logo: SITE.origin + '/images/2027.png',
    image: SITE.origin + '/images/Container-1.jpg',
    telephone: SITE.phoneIntl,
    email: SITE.email,
    priceRange: '$$',
    address: {
      '@type': 'PostalAddress',
      streetAddress: SITE.address.street,
      postalCode: SITE.address.postalCode,
      addressLocality: SITE.address.city,
      addressCountry: SITE.address.country,
    },
    openingHoursSpecification: [{
      '@type': 'OpeningHoursSpecification',
      dayOfWeek: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
      opens: '08:00',
      closes: '18:00',
    }],
    areaServed: CITIES.filter((c) => c.type === 'stad').map((c) => ({
      '@type': 'City', name: c.name,
    })),
    founder: { '@id': FOUNDER_ID },
    sameAs: [SITE.googleMaps],
  };
}

export function founderNode() {
  return {
    '@type': 'Person',
    '@id': FOUNDER_ID,
    name: 'Thirza Mac Donald',
    jobTitle: 'Oprichter',
    worksFor: { '@id': ORG_ID },
  };
}

/**
 * AggregateRating hoort bij het ding dat beoordeeld wordt en heeft
 * bijbehorende reviews nodig. Deze node wordt alleen meegegeven op pagina's
 * waar de reviews ook echt zichtbaar staan.
 */
export function ratingWithReviews(reviews = REVIEWS.slice(0, 3)) {
  return {
    aggregateRating: {
      '@type': 'AggregateRating',
      ratingValue: SITE.ratingSchema,
      reviewCount: SITE.reviewCount,
      bestRating: '5',
      worstRating: '1',
    },
    review: reviews.map((r) => ({
      '@type': 'Review',
      author: { '@type': 'Person', name: r.name },
      reviewRating: { '@type': 'Rating', ratingValue: '5', bestRating: '5' },
      reviewBody: r.text,
    })),
  };
}

export function breadcrumbNode(trail) {
  return {
    '@type': 'BreadcrumbList',
    itemListElement: trail.map((t, i) => ({
      '@type': 'ListItem',
      position: i + 1,
      name: t.label,
      item: SITE.origin + t.href,
    })),
  };
}

/* ------------------------------------------------------------------ */
/* Gedeelde HTML-blokken                                               */
/* ------------------------------------------------------------------ */

/** Alles in <head> behalve de paginaspecifieke JSON-LD. */
export function head({ title, description, path, noindex = false, ogImage = '/images/Container-1.jpg' }) {
  const canonical = SITE.origin + path;
  return `<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>${esc(title)}</title>
<meta name="description" content="${esc(description)}">
<link rel="canonical" href="${canonical}">${noindex ? '\n<meta name="robots" content="noindex, follow">' : ''}
<meta name="theme-color" content="#0D0D1A">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/images/2027.png">
<meta property="og:type" content="website">
<meta property="og:locale" content="nl_NL">
<meta property="og:site_name" content="Spotlezz">
<meta property="og:title" content="${esc(title)}">
<meta property="og:description" content="${esc(description)}">
<meta property="og:url" content="${canonical}">
<meta property="og:image" content="${SITE.origin}${ogImage}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="${esc(title)}">
<meta name="twitter:description" content="${esc(description)}">
<meta name="twitter:image" content="${SITE.origin}${ogImage}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&amp;family=Montserrat:wght@400;600;700&amp;display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.2/src/regular/style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.2/src/fill/style.css">
<link rel="stylesheet" href="/style.css">`;
}

export const skipLink =
  `<a class="skip-link" href="#main">Naar de inhoud</a>`;

export function topBar() {
  return `<div class="top-bar">
  <div class="usp">
    <span>Innovatief en flexibel</span>
    <span>Jarenlange ervaring</span>
    <a href="${SITE.googleMaps}" target="_blank" rel="noopener noreferrer" class="top-bar-review-link">
      <i class="ph-fill ph-google-logo" aria-hidden="true" style="color: #4285F4;"></i> Beoordeeld met ${SITE.rating}/5 sterren door ${SITE.reviewCount} klanten <span aria-hidden="true" style="color:#FBBC04; margin-left:5px;">★★★★★</span>
    </a>
  </div>
  <div class="contact-info">
    <a href="tel:${SITE.phoneRaw}"><span style="font-weight: 600; margin-right: 4px;">T:</span> ${SITE.phone}</a>
    <a href="mailto:${SITE.email}"><span style="font-weight: 600; margin-right: 4px;">E:</span> ${SITE.email}</a>
  </div>
</div>`;
}

export function header() {
  const branche = BRANCHES.map(
    (s) => `        <a href="/diensten/${s.slug}/">${esc(s.nav)}</a>`).join('\n');
  const dienst = SERVICES.map(
    (s) => `        <a href="/diensten/${s.slug}/">${esc(s.nav)}</a>`).join('\n');
  return `<header>
  <div class="logo">
    <a href="/" aria-label="Spotlezz, naar de homepage"><img src="/images/2027.png" alt="Spotlezz" width="291" height="39"></a>
  </div>
  <nav aria-label="Hoofdnavigatie">
    <div class="dropdown">
      <a href="/diensten/" class="dropbtn">Diensten <i class="ph ph-caret-down" aria-hidden="true" style="font-size: 12px; margin-left:4px;"></i></a>
      <div class="dropdown-content">
        <span class="dropdown-heading">Voor wie</span>
${branche}
        <span class="dropdown-heading">Wat we doen</span>
${dienst}
      </div>
    </div>
    <a href="/klantcases/">Klantcases</a>
    <a href="/locaties/">Locaties</a>
    <a href="/veelgestelde-vragen/">Veelgestelde vragen</a>
    <a href="/over-ons/">Over ons</a>
    <a href="/contact/">Contact</a>
  </nav>
  <div class="header-ctas">
    <a href="/offerte-aanvragen/" class="btn btn-orange">Offerte aanvragen</a>
  </div>
  <button type="button" class="mobile-menu-btn" aria-label="Menu openen" aria-expanded="false" aria-controls="mobileNav" onclick="toggleMobileMenu()"><i class="ph ph-list" aria-hidden="true"></i></button>
</header>`;
}

export function mobileNav() {
  const branche = BRANCHES.map(
    (s) => `    <a href="/diensten/${s.slug}/" class="sub-link">${esc(s.nav)}</a>`).join('\n');
  const dienst = SERVICES.map(
    (s) => `    <a href="/diensten/${s.slug}/" class="sub-link">${esc(s.nav)}</a>`).join('\n');
  return `<div class="mobile-nav-overlay" id="mobileNav" hidden>
  <div class="mobile-nav-header">
    <img src="/images/2027.png" alt="Spotlezz" width="291" height="39">
    <button type="button" class="close-menu-btn" aria-label="Menu sluiten" onclick="toggleMobileMenu()"><i class="ph ph-x" aria-hidden="true"></i></button>
  </div>
  <div class="mobile-nav-links">
    <a href="/diensten/">Diensten</a>
${branche}
${dienst}
    <a href="/klantcases/">Klantcases</a>
    <a href="/locaties/">Locaties</a>
    <a href="/veelgestelde-vragen/">Veelgestelde vragen</a>
    <a href="/over-ons/">Over ons</a>
    <a href="/contact/">Contact</a>
    <a href="/offerte-aanvragen/" class="btn btn-orange" style="margin-top:16px;">Offerte aanvragen</a>
  </div>
</div>`;
}

/**
 * Breadcrumb plus reviewscore en telefoonnummer. Volgens wireframe de
 * goedkoopste anti-pogo maatregel: een zijwaartse uitweg in plaats van de
 * terugknop.
 */
export function breadcrumb(trail) {
  const last = trail[trail.length - 1];
  const items = trail
    .slice(0, -1)
    .map((t) => `<a href="${t.href}">${esc(t.label)}</a>`)
    .join('<span class="crumb-sep" aria-hidden="true">›</span>');
  return `<div class="crumb-bar">
  <nav class="crumb" aria-label="Kruimelpad">
    ${items}<span class="crumb-sep" aria-hidden="true">›</span><span aria-current="page">${esc(last.label)}</span>
  </nav>
  <div class="crumb-proof">
    <span class="crumb-stars" aria-hidden="true">★★★★★</span>
    <span>${SITE.rating}/5 uit ${SITE.reviewCount} beoordelingen</span>
    <a href="tel:${SITE.phoneRaw}">${SITE.phone}</a>
  </div>
</div>`;
}

/** Next-hop bar: exact drie routes. Omhoog, zijwaarts, conversie. */
export function nextHop({ up, side, cta }) {
  return `<section class="next-hop-section" aria-label="Verder lezen">
  <a href="${up.href}" class="next-hop-card">
    <span class="hop-kind">Omhoog</span>
    <h3>${esc(up.label)}</h3>
    <span class="arrow" aria-hidden="true"></span>
  </a>
  <a href="${side.href}" class="next-hop-card">
    <span class="hop-kind">Zijwaarts</span>
    <h3>${esc(side.label)}</h3>
    <span class="arrow" aria-hidden="true"></span>
  </a>
  <a href="${cta.href}" class="next-hop-card next-hop-cta">
    <span class="hop-kind">Offerte</span>
    <h3>${esc(cta.label)}</h3>
    <span class="arrow" aria-hidden="true"></span>
  </a>
</section>`;
}

export function footer() {
  const branche = BRANCHES.map(
    (s) => `        <li><a href="/diensten/${s.slug}/">${esc(s.nav)}</a></li>`).join('\n');
  const dienst = SERVICES.map(
    (s) => `        <li><a href="/diensten/${s.slug}/">${esc(s.nav)}</a></li>`).join('\n');
  const steden = CITIES.filter((c) => c.type === 'stad').map(
    (c) => `        <li><a href="/locaties/${c.slug}/">Schoonmaakbedrijf ${esc(c.name)}</a></li>`).join('\n');
  return `<footer class="site-footer">
  <div class="footer-overlay"></div>
  <div class="footer-container">
    <div class="footer-col">
      <div class="footer-logo">
        <a href="/" aria-label="Spotlezz, naar de homepage"><img src="/images/2027.png" alt="Spotlezz" width="291" height="39"></a>
      </div>
      <p class="footer-desc">Het beste schoonmaakbedrijf in<br>Almere en omgeving!</p>
      <div class="footer-nap">
        <span>${esc(SITE.address.street)}, ${esc(SITE.address.postalCode)} ${esc(SITE.address.city)}</span>
        <span>${esc(SITE.openingHours)}</span>
      </div>
    </div>

    <div class="footer-col">
      <h3>Voor wie</h3>
      <ul class="footer-links">
${branche}
      </ul>
    </div>

    <div class="footer-col">
      <h3>Wat we doen</h3>
      <ul class="footer-links">
${dienst}
      </ul>
    </div>

    <div class="footer-col">
      <h3>Werkgebied</h3>
      <ul class="footer-links">
${steden}
        <li><a href="/locaties/">Alle locaties</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h3>Over Spotlezz</h3>
      <ul class="footer-links">
        <li><a href="/over-ons/">Over ons</a></li>
        <li><a href="/klantcases/">Klantcases</a></li>
        <li><a href="/reviews/">Reviews</a></li>
        <li><a href="/veelgestelde-vragen/">Veelgestelde vragen</a></li>
        <li><a href="/vacatures/">Vacatures</a></li>
        <li><a href="/blog/">Blog</a></li>
        <li><a href="/contact/">Contact</a></li>
      </ul>
      <div class="footer-contact">
        <span><span style="font-weight: 600; margin-right: 4px;">T:</span> <a href="tel:${SITE.phoneRaw}">${SITE.phone}</a></span>
        <span><span style="font-weight: 600; margin-right: 4px;">E:</span> <a href="mailto:${SITE.email}">${SITE.email}</a></span>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    <div class="copyright">
      Copyright © ${SITE.year} ${esc(SITE.legalName)}. Alle rechten voorbehouden.
    </div>
    <div class="footer-bottom-links">
      <a href="/privacybeleid/">Privacybeleid</a> |
      <a href="${SITE.terms}" target="_blank" rel="noopener">Algemene voorwaarden</a>
    </div>
  </div>
</footer>`;
}

export function stickyCta() {
  return `<div class="mobile-sticky-cta">
  <a href="tel:${SITE.phoneRaw}" class="btn btn-outline-dark"><i class="ph-fill ph-phone" aria-hidden="true"></i> Bellen</a>
  <a href="/offerte-aanvragen/" class="btn btn-orange">Offerte aanvragen</a>
</div>`;
}

export function scripts() {
  return `<script src="/main.js" defer></script>`;
}

/* ------------------------------------------------------------------ */
/* Formulieren                                                         */
/* ------------------------------------------------------------------ */

/**
 * Elk veld heeft een name, een zichtbaar label en een autocomplete-waarde.
 * De verzendlogica zit in main.js en leest data-form. Zolang FORM_ENDPOINT in
 * main.js leeg is valt het formulier terug op een voorgevulde mail, zodat er
 * geen aanvraag verloren gaat.
 */
export function contactForm({ id = 'contactForm', heading = 'Een bericht verzenden', submit = 'Versturen', compact = false } = {}) {
  return `<form class="sp-form" id="${id}" data-form="contact" novalidate>
  ${heading ? `<h3>${esc(heading)}</h3>` : ''}
  <div class="form-row">
    <div class="form-group">
      <label for="${id}-naam">Naam <span aria-hidden="true">*</span></label>
      <input type="text" id="${id}-naam" name="naam" autocomplete="name" placeholder="Volledige naam" required>
    </div>
    <div class="form-group">
      <label for="${id}-bedrijf">Bedrijfsnaam <span aria-hidden="true">*</span></label>
      <input type="text" id="${id}-bedrijf" name="bedrijf" autocomplete="organization" placeholder="Jouw bedrijf" required>
    </div>
  </div>
  <div class="form-row">
    <div class="form-group">
      <label for="${id}-email">E-mailadres <span aria-hidden="true">*</span></label>
      <input type="email" id="${id}-email" name="email" autocomplete="email" placeholder="naam@bedrijf.nl" required>
    </div>
    <div class="form-group">
      <label for="${id}-telefoon">Telefoonnummer <span aria-hidden="true">*</span></label>
      <input type="tel" id="${id}-telefoon" name="telefoon" autocomplete="tel" placeholder="06 12345678" required>
    </div>
  </div>
  ${compact ? '' : `<div class="form-group">
    <label for="${id}-bericht">Bericht <span aria-hidden="true">*</span></label>
    <textarea id="${id}-bericht" name="bericht" rows="4" placeholder="Waar kunnen wij mee helpen?" required></textarea>
  </div>`}
  <div class="form-consent">
    <input type="checkbox" id="${id}-akkoord" name="akkoord" required>
    <label for="${id}-akkoord">Ik ga akkoord met het <a href="/privacybeleid/">privacybeleid</a> en met het opnemen van contact over deze aanvraag.</label>
  </div>
  <p class="form-hp" aria-hidden="true"><label for="${id}-website">Laat dit veld leeg</label><input type="text" id="${id}-website" name="website" tabindex="-1" autocomplete="off"></p>
  <button type="submit" class="btn-submit">${esc(submit)}</button>
  <p class="form-status" role="status" aria-live="polite"></p>
</form>`;
}

/** Korte offerteaanvraag voor in de hero van een dienstpagina. */
export function quickQuoteForm({ id = 'snelofferte', dienst = '' } = {}) {
  const opties = ALL_SERVICES.map(
    (s) => `      <option value="${esc(s.service)}"${s.service === dienst ? ' selected' : ''}>${esc(s.service)}</option>`).join('\n');
  return `<form class="sp-form quick-quote" id="${id}" data-form="offerte" novalidate>
  <p class="quick-quote-title">Snelofferte</p>
  <div class="form-group">
    <label for="${id}-dienst">Welke dienst</label>
    <select id="${id}-dienst" name="dienst">
${opties}
    </select>
  </div>
  <div class="form-group">
    <label for="${id}-oppervlakte">Oppervlakte in m²</label>
    <input type="number" id="${id}-oppervlakte" name="oppervlakte" min="1" inputmode="numeric" placeholder="Bijvoorbeeld 450">
  </div>
  <div class="form-group">
    <label for="${id}-email">E-mailadres <span aria-hidden="true">*</span></label>
    <input type="email" id="${id}-email" name="email" autocomplete="email" placeholder="naam@bedrijf.nl" required>
  </div>
  <div class="form-consent">
    <input type="checkbox" id="${id}-akkoord" name="akkoord" required>
    <label for="${id}-akkoord">Akkoord met het <a href="/privacybeleid/">privacybeleid</a>.</label>
  </div>
  <p class="form-hp" aria-hidden="true"><label for="${id}-website">Laat dit veld leeg</label><input type="text" id="${id}-website" name="website" tabindex="-1" autocomplete="off"></p>
  <button type="submit" class="btn btn-orange btn-block">Offerte binnen 24 uur</button>
  <p class="form-status" role="status" aria-live="polite"></p>
  <p class="quick-quote-foot">Vrijblijvend. Reactie binnen 12 uur op werkdagen.</p>
</form>`;
}

/** E-mailmagneet voor de Spotlezz-check. */
export function checklistForm({ id = 'checklistForm' } = {}) {
  return `<form class="sp-form checklist-form" id="${id}" data-form="checklist" novalidate>
  <div class="form-group">
    <label for="${id}-email">E-mailadres</label>
    <input type="email" id="${id}-email" name="email" autocomplete="email" placeholder="naam@bedrijf.nl" required>
  </div>
  <div class="form-consent">
    <input type="checkbox" id="${id}-akkoord" name="akkoord" required>
    <label for="${id}-akkoord">Akkoord met het <a href="/privacybeleid/">privacybeleid</a>.</label>
  </div>
  <p class="form-hp" aria-hidden="true"><label for="${id}-website">Laat dit veld leeg</label><input type="text" id="${id}-website" name="website" tabindex="-1" autocomplete="off"></p>
  <button type="submit" class="btn btn-orange">Vraag de checklist aan</button>
  <p class="form-status" role="status" aria-live="polite"></p>
</form>`;
}

/* ------------------------------------------------------------------ */
/* Herbruikbare contentblokken                                         */
/* ------------------------------------------------------------------ */

/**
 * Antwoordblok. Korte alinea van 40 tot 60 woorden plus vier harde feiten.
 * Er staat bewust geen bedrag in: de prijs hangt af van zes factoren en die
 * worden uitgelegd op de FAQ-pagina waar dit blok naartoe linkt.
 */
export function answerBlock({ paragraph, facts }) {
  const tiles = facts.map((f) => `    <div class="answer-stat">
      <b>${esc(f.value)}</b>
      <span>${esc(f.label)}</span>
    </div>`).join('\n');
  return `<section class="answer-block" aria-label="Het korte antwoord">
  <div class="answer-inner">
    <p class="answer-lead">${paragraph}</p>
    <div class="answer-stats">
${tiles}
    </div>
    <p class="answer-price">
      <i class="ph ph-calculator" aria-hidden="true"></i>
      Wat kost het? De prijs hangt af van zes factoren.
      <a href="/veelgestelde-vragen/wat-bepaalt-de-prijs-van-schoonmaak/">Bekijk waar een offerte uit is opgebouwd</a>
    </p>
  </div>
</section>`;
}

/** Reviewblok met drie citaten. Wordt altijd samen met Review-schema gebruikt. */
export function reviewBlock(reviews = REVIEWS.slice(0, 3)) {
  const cards = reviews.map((r) => `    <figure class="review-card">
      <div class="review-stars" aria-label="5 van de 5 sterren">★★★★★</div>
      <blockquote><p>${esc(r.text)}</p></blockquote>
      <figcaption>
        <span class="review-avatar" aria-hidden="true">${esc(r.initial)}</span>
        <span>
          <span class="review-name">${esc(r.name)}</span>
          <span class="review-role">${esc(r.role)}, ${esc(r.city)}</span>
        </span>
      </figcaption>
    </figure>`).join('\n');
  return `<section class="review-section" aria-label="Wat klanten zeggen">
  <div class="review-grid">
${cards}
  </div>
  <p class="review-foot">Gemiddeld ${SITE.rating} uit 5 op basis van ${SITE.reviewCount} beoordelingen. <a href="/reviews/">Bekijk alle reviews</a></p>
</section>`;
}

/** FAQ-accordion. Vragen zijn knoppen, met aria-expanded en toetsenbordbediening. */
export function faqAccordion(items, { idPrefix = 'faq' } = {}) {
  const rows = items.map((q, i) => `  <div class="faq-item">
    <h3 class="faq-question-wrap">
      <button type="button" class="faq-question" id="${idPrefix}-q${i}" aria-expanded="false" aria-controls="${idPrefix}-a${i}">
        <span>${esc(q.q)}</span>
        <span class="faq-icon" aria-hidden="true"></span>
      </button>
    </h3>
    <div class="faq-answer" id="${idPrefix}-a${i}" role="region" aria-labelledby="${idPrefix}-q${i}" hidden>
      <div class="faq-answer-inner"><p>${q.a}</p></div>
    </div>
  </div>`).join('\n');
  return `<div class="faq-list">\n${rows}\n</div>`;
}

export function faqSchema(items) {
  return {
    '@type': 'FAQPage',
    mainEntity: items.map((q) => ({
      '@type': 'Question',
      name: q.q,
      acceptedAnswer: { '@type': 'Answer', text: q.a.replace(/<[^>]+>/g, '') },
    })),
  };
}

/** Regioblok: koppelt de dienst-as aan de locatie-as. */
export function regionBlock(dienstNaam) {
  const pills = CITIES.map(
    (c) => `    <a href="/locaties/${c.slug}/" class="pill">${esc(c.name)}</a>`).join('\n');
  return `<section class="region-block" aria-label="Werkgebied">
  <h2>In welke regio leveren wij ${esc(dienstNaam.toLowerCase())}?</h2>
  <p>Wij werken met vaste teams vanuit Almere. Klik op een plaats voor de lokale pagina met werkgebied, teams en klanten.</p>
  <div class="pill-row">
${pills}
  </div>
</section>`;
}
