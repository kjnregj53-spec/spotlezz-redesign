/**
 * Bouwscript voor spotlezz.vercel.app.
 *
 *   node build/build.mjs            volledige build
 *   node build/build.mjs --assets   ook ontbrekende afbeeldingen ophalen
 *
 * Het script doet twee dingen:
 *   1. Bestaande pagina's krijgen dezelfde head, navigatie, breadcrumb,
 *      formulieren, next-hop en footer opgelegd.
 *   2. Nieuwe pagina's worden volledig gegenereerd uit templates.mjs.
 *
 * De uitvoer wordt gecommit, zodat Vercel gewoon statische bestanden serveert
 * en er geen buildstap op de server nodig is.
 */

import { readFile, writeFile, mkdir, readdir, stat, rm } from 'node:fs/promises';
import { existsSync } from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

import {
  SITE, BRANCHES, SERVICES, ALL_SERVICES, CITIES, CASES, REVIEWS,
  esc, jsonld, organizationNode, founderNode, ratingWithReviews, breadcrumbNode,
  head, skipLink, topBar, header, mobileNav, breadcrumb, nextHop, footer,
  stickyCta, scripts, contactForm, quickQuoteForm, checklistForm,
  answerBlock, reviewBlock, faqAccordion, faqSchema,
} from './site.mjs';

import {
  servicePage, locationPage, locationsHub, faqHub, faqDetailPage, reviewsPage,
} from './templates.mjs';

import { FAQ_DETAILS, faqForService, HOME_FAQ } from './content-faq.mjs';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const ROOT = path.resolve(__dirname, '..', 'spotlezz.vercel.app');

const log = (...a) => console.log(' ', ...a);

/* ================================================================== */
/* Hulpfuncties voor HTML-chirurgie                                    */
/* ================================================================== */

/** Zoekt vanaf een openingstag de bijbehorende sluittag, met nesting. */
function blockEnd(html, startIdx, tag) {
  const open = new RegExp(`<${tag}\\b`, 'gi');
  const close = new RegExp(`</${tag}\\s*>`, 'gi');
  let depth = 0;
  let i = startIdx;
  while (i < html.length) {
    open.lastIndex = i;
    close.lastIndex = i;
    const o = open.exec(html);
    const c = close.exec(html);
    if (!c) return html.length;
    if (o && o.index < c.index) {
      depth++;
      i = o.index + 1;
    } else {
      depth--;
      i = c.index + 1;
      if (depth === 0) return c.index + c[0].length;
    }
  }
  return html.length;
}

/** Verwijdert het blok dat begint bij de eerste match van `re`. */
function cutBlock(html, re, tag) {
  const m = re.exec(html);
  if (!m) return { html, found: false, at: -1 };
  const end = blockEnd(html, m.index, tag);
  return {
    html: html.slice(0, m.index) + html.slice(end),
    found: true,
    at: m.index,
  };
}

function replaceHead(html, newHead) {
  const s = html.indexOf('<head>');
  const e = html.indexOf('</head>');
  if (s === -1 || e === -1) return html;
  return html.slice(0, s + 6) + '\n' + newHead + '\n' + html.slice(e);
}

/* ================================================================== */
/* Links, afbeeldingen en placeholders                                 */
/* ================================================================== */

const IMAGE_MAP = {
  '2027.png': '/images/2027.png',
  'image2.png': '/images/logisnext.png',
  'image-29.png': '/images/kobelco.png',
  'image-28-1.png': '/images/floor.png',
  'kersvers-logo-2.png.png': '/images/kersvers.png',
  'sr1-1024x665.jpg': '/images/pand-interieur.jpg',
  'sr2-1024x665.jpg': '/images/team-aan-het-werk.jpg',
  'sr3-1024x665.jpg': '/images/case-kuchentreff.jpg',
  'sr4-1024x665.jpg': '/images/case-arena-gym.jpg',
  'sr5-1024x665.jpg': '/images/branche-kantoor.jpg',
  'sr6-1024x665.jpg': '/images/branche-vve.jpg',
  'DSC02837.jpg': '/images/materiaal-producten.jpg',
  'professional-cleaning.jpg': '/images/pand-interieur.jpg',
  'we-visit-your-office.jpg': '/images/checklist-achtergrond.jpg',
  'Spotlezz-checkist-def.jpg': '/images/Spotlezz-checkist-def.jpg',
  'Container-1.jpg': '/images/Container-1.jpg',
  '2026.png': '/images/2027.png',
  'professionele-schoonmaak.jpg': '/images/professionele-schoonmaak.jpg',
  'Office-11-1.jpg': '/images/kantoor-werkplek.jpg',
  'Office-11-2-1.jpg': '/images/kantoor-detail.jpg',
  'logo-1.png.png': '/images/klantlogo-1.png',
  'image002_edited.jpg.png': '/images/klantlogo-2.png',
  'image6.png': '/images/klantlogo-3.png',
  'Background.jpg': '/images/achtergrond.jpg',
  'Background-1.jpg': '/images/achtergrond-2.jpg',
  'Checklist-vertical.jpg': '/images/checklist-preview.jpg',
  'Frame-2147227652-1.jpg': '/images/sfeer-1.jpg',
  'Frame-2147227723-scaled.jpg': '/images/sfeer-2.jpg',
  '66cf9f5b0c337de9e5a2c919_image1.webp-4-scaled.jpg': '/images/sfeer-3.jpg',
  'You-get-a-quote.jpg': '/images/stap-offerte.jpg',
  'Your-dedicated-team-starts-cleaning.jpg': '/images/stap-team-start.jpg',
  'You-see-the-result.jpg': '/images/stap-resultaat.jpg',
};

/**
 * Alle interne verwijzingen worden root-relatief en zonder index.html.
 * Relatieve paden worden opgelost vanaf de pagina zelf. Dat is precies waar het
 * eerder misging: `kantoor-schoonmaak/index.html` op /diensten/ werd anders
 * /kantoor-schoonmaak/ in plaats van /diensten/kantoor-schoonmaak/.
 */
function rewriteLinks(html, basePath = '/') {
  const base = 'http://x' + (basePath.endsWith('/') ? basePath : basePath + '/');

  html = html.replace(/(href|src)="([^"#][^"]*?)"/gi, (m, attr, url) => {
    if (/^(https?:|tel:|mailto:|data:|\/\/)/i.test(url)) return m;
    if (url.startsWith('/')) return m;
    let resolved;
    try { resolved = new URL(url, base).pathname; } catch { return m; }
    resolved = resolved.replace(/index\.html$/, '');
    return `${attr}="${resolved}"`;
  });

  // style.css en main.js liggen in de root
  html = html.replace(/(href|src)="\/[^"]*?(style\.css|main\.js)"/gi,
    (_m, attr, f) => `${attr}="/${f}"`);

  // Anker-navigatie op de homepage vervangen door echte hubs
  html = html.replace(/href="#cases"/g, 'href="/klantcases/"');
  html = html.replace(/href="#locaties"/g, 'href="/locaties/"');
  html = html.replace(/href="#faq"/g, 'href="/veelgestelde-vragen/"');
  html = html.replace(/href="#check"/g, 'href="/checklist/"');
  html = html.replace(/href="#diensten"/g, 'href="/diensten/"');
  html = html.replace(/href="#contact"/g, 'href="/contact/"');

  // Oude offerte-URL naar de Nederlandse variant
  html = html.replace(/href="\/quote\/"/g, 'href="/offerte-aanvragen/"');
  html = html.replace(/href="\/contact-us\/"/g, 'href="/contact/"');

  // Afbeeldingen van de WordPress-installatie naar lokale bestanden
  html = html.replace(/https:\/\/spotlezz\.nl\/wp-content\/uploads\/[0-9]{4}\/[0-9]{2}\/([^"')\s]+)/g,
    (m, file) => IMAGE_MAP[file] || m);

  // Stockfoto's van Unsplash vervangen door eigen beeld. Stock is precies het
  // EEAT-lek dat de wireframes uitsluiten, en het is ook een externe
  // afhankelijkheid die de site niet nodig heeft.
  const stock = ['/images/sfeer-1.jpg', '/images/sfeer-2.jpg', '/images/sfeer-3.jpg'];
  let stockIndex = 0;
  html = html.replace(/https:\/\/images\.unsplash\.com\/[^"')\s]+/g,
    () => stock[stockIndex++ % stock.length]);

  return html;
}

/* ------------------------------------------------------------------ */
/* Afbeeldingsafmetingen uitlezen, voor width/height op elke img       */
/* ------------------------------------------------------------------ */

const dimCache = new Map();

/** Leest de afmetingen uit de header van een PNG of JPEG. */
function readDimensions(buf) {
  // PNG
  if (buf.length > 24 && buf.readUInt32BE(0) === 0x89504e47) {
    return { w: buf.readUInt32BE(16), h: buf.readUInt32BE(20) };
  }
  // JPEG: doorloop de segmenten tot een SOF-marker
  if (buf.length > 4 && buf[0] === 0xff && buf[1] === 0xd8) {
    let i = 2;
    while (i < buf.length - 9) {
      if (buf[i] !== 0xff) { i++; continue; }
      const marker = buf[i + 1];
      const len = buf.readUInt16BE(i + 2);
      // SOF0..SOF15, met uitzondering van DHT, JPG en DAC
      if (marker >= 0xc0 && marker <= 0xcf && ![0xc4, 0xc8, 0xcc].includes(marker)) {
        return { h: buf.readUInt16BE(i + 5), w: buf.readUInt16BE(i + 7) };
      }
      i += 2 + len;
    }
  }
  return null;
}

async function dimensionsFor(src) {
  if (dimCache.has(src)) return dimCache.get(src);
  let out = null;
  if (src.startsWith('/images/')) {
    const file = path.join(ROOT, src.replace(/^\//, ''));
    if (existsSync(file)) {
      try { out = readDimensions(await readFile(file)); } catch { out = null; }
    }
  }
  dimCache.set(src, out);
  return out;
}

/**
 * Geeft elke afbeelding width, height en lazy loading. Zonder afmetingen
 * verspringt de pagina tijdens het laden, wat direct de Cumulative Layout
 * Shift raakt.
 */
async function fixImages(html) {
  const tags = html.match(/<img\b[^>]*>/gi) || [];
  for (const tag of tags) {
    const srcMatch = tag.match(/\ssrc="([^"]+)"/i);
    if (!srcMatch) continue;
    let out = tag;

    if (!/\swidth=/i.test(out) || !/\sheight=/i.test(out)) {
      const dim = await dimensionsFor(srcMatch[1]);
      if (dim) {
        out = out.replace(/\s*\/?>$/, ` width="${dim.w}" height="${dim.h}">`);
      }
    }
    if (!/\sloading=/i.test(out)) out = out.replace(/\s*\/?>$/, ' loading="lazy">');
    if (!/\sdecoding=/i.test(out)) out = out.replace(/\s*\/?>$/, ' decoding="async">');

    if (out !== tag) html = html.split(tag).join(out);
  }
  // Het logo in de header is boven de vouw en moet juist meteen laden
  html = html.replace(/(<img[^>]*\/images\/2027\.png[^>]*)\sloading="lazy"/gi, '$1 loading="eager" fetchpriority="high"');
  return html;
}

/** Verwijdert wireframe-labels die als echte tekst zijn meegeleverd. */
function stripPlaceholders(html) {
  const drops = [
    /Klantquote \(groot\)/g,
    /Next-hop bar\s*(&middot;|·)\s*exact 3 routes/g,
    /Feitenbalk/g,
    /STAR-structuur/g,
    /Hub-variant\s*(&middot;|·)[^<]*/g,
    /Detailpagina\s*(&middot;|·)[^<]*/g,
    /Conversieblok\s*(&middot;|·)[^<]*/g,
    /Antwoordblok\s*(&middot;|·)[^<]*/g,
    /Lokaal bewijs\s*(&middot;|·)[^<]*/g,
    /Eigen fotografie\s*(&middot;|·)\s*geen stockbeeld/g,
    /Snelofferte \(sticky\)/g,
    /→\s*pillar/g,
    /&#8594;\s*pillar/g,
  ];
  for (const re of drops) html = html.replace(re, '');

  // Bijschriften bij de foto's lazen als instructie aan de bouwer in plaats
  // van als tekst voor de bezoeker.
  html = html.replace(/Eigen foto\s*(?:&middot;|·)\s*team aan het werk/gi, 'Ons team aan het werk');
  html = html.replace(/Eigen foto\s*(?:&middot;|·)\s*het pand(?: of de ruimte)?/gi, 'Een pand uit ons werkgebied');
  html = html.replace(/Eigen foto\s*(?:&middot;|·)\s*materiaal(?: en producten)?/gi, 'Materiaal en producten');
  html = html.replace(/Eigen foto\s*(?:&middot;|·)\s*/gi, '');

  // De vanafprijs stond als placeholder live. Zie build/TE-CONTROLEREN.md.
  html = html.replace(/&euro;\s*xx\s*\/\s*uur/gi, 'Op maat');
  html = html.replace(/€\s*xx\s*\/\s*uur/gi, 'Op maat');
  html = html.replace(/vanaf\s*&euro;\s*x[,.]xx/gi, 'Op maat');
  html = html.replace(/>\s*Vanafprijs\s*</g, '>Prijsopbouw<');

  // Lege koppen die na het strippen overblijven
  html = html.replace(/<div class="lbl">\s*<\/div>/g, '');
  html = html.replace(/<h[23][^>]*>\s*<\/h[23]>/g, '');

  return html;
}

/** Vervangt de drie fotoplaceholders door echte afbeeldingen. */
function fixPhotoPlaceholders(html, context) {
  const map = [
    ['EIGEN FOTO · TEAM AAN HET WERK', '/images/team-aan-het-werk.jpg', `Spotlezz team aan het werk bij ${context}`],
    ['EIGEN FOTO · HET PAND', '/images/pand-interieur.jpg', `Pand waar Spotlezz ${context} verzorgt`],
    ['EIGEN FOTO · MATERIAAL', '/images/materiaal-producten.jpg', 'Ecologische schoonmaakmiddelen en materiaal van Spotlezz'],
  ];
  for (const [label, src, alt] of map) {
    const re = new RegExp(`>\\s*${label.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')}\\s*<`, 'gi');
    html = html.replace(re, `><img src="${src}" alt="${esc(alt)}" width="1024" height="665" loading="lazy"><`);
  }
  return html;
}

/* ================================================================== */
/* Chrome (topbar, header, mobiele nav, breadcrumb, footer)            */
/* ================================================================== */

function applyChrome(html, { trail, hop, mainStart = true }) {
  // Oude blokken eruit
  let r = cutBlock(html, /<div class="top-bar">/i, 'div');
  const insertAt = r.at;
  html = r.html;
  r = cutBlock(html, /<header[\s>]/i, 'header');
  html = r.html;
  r = cutBlock(html, /<div class="mobile-nav-overlay"/i, 'div');
  html = r.html;
  r = cutBlock(html, /<div class="mobile-sticky-cta">/i, 'div');
  html = r.html;
  // Bestaande next-hop weghalen; we zetten er zelf een terug
  r = cutBlock(html, /<section class="next-hop-section"/i, 'section');
  html = r.html;
  // Oude losse breadcrumb-balken
  for (let i = 0; i < 3; i++) {
    const b = cutBlock(html, /<div class="(?:crumb-bar|breadcrumb[a-z-]*)"/i, 'div');
    if (!b.found) break;
    html = b.html;
  }
  // Footer eruit
  r = cutBlock(html, /<footer[\s>]/i, 'footer');
  const footerAt = r.at;
  html = r.html;

  // Losse scripttags opruimen; die zetten we centraal terug
  html = html.replace(/<script src="[^"]*(swiper|swup|phosphor)[^"]*"[^>]*><\/script>\s*/gi, '');
  html = html.replace(/<script src="\/?main\.js"[^>]*><\/script>\s*/gi, '');

  const chrome = [skipLink, topBar(), header(), mobileNav()].join('\n');
  const crumb = trail ? breadcrumb(trail) : '';
  const openMain = mainStart ? '<main id="main">' : '';

  const at = insertAt >= 0 ? insertAt : html.indexOf('<body>') + 6;
  html = html.slice(0, at) + chrome + '\n' + openMain + '\n' + crumb + '\n' + html.slice(at);

  // Footer terug, met next-hop ervoor
  const tail = [
    hop ? nextHop(hop) : '',
    mainStart ? '</main>' : '',
    footer(),
    stickyCta(),
    scripts(),
  ].filter(Boolean).join('\n');

  const bodyEnd = html.lastIndexOf('</body>');
  html = html.slice(0, bodyEnd) + tail + '\n' + html.slice(bodyEnd);

  return html;
}

/* ================================================================== */
/* Formulieren vervangen                                               */
/* ================================================================== */

function replaceForms(html, forms) {
  let idx = 0;
  let out = html;
  for (const repl of forms) {
    const m = /<form[\s>]/i.exec(out);
    if (!m) break;
    const end = blockEnd(out, m.index, 'form');
    out = out.slice(0, m.index) + `@@FORM${idx}@@` + out.slice(end);
    idx++;
  }
  // Overgebleven formulieren verwijderen
  while (true) {
    const m = /<form[\s>]/i.exec(out);
    if (!m) break;
    const end = blockEnd(out, m.index, 'form');
    out = out.slice(0, m.index) + out.slice(end);
  }
  forms.forEach((f, i) => { out = out.replace(`@@FORM${i}@@`, f); });
  return out;
}

/* ================================================================== */
/* Paginaconfiguratie voor de bestaande pagina's                       */
/* ================================================================== */

const HUB = { href: '/', label: 'Naar de homepage' };

const EXISTING = {
  'index.html': {
    meta: {
      title: 'Schoonmaakbedrijf in Almere voor kantoren, hotels en VvE | Spotlezz',
      description: 'Zakelijk schoonmaakbedrijf in Almere, Lelystad, Amsterdam en Amersfoort. Vast team, wekelijkse controles en binnen 12 uur een afspraak.',
      path: '/',
    },
    trail: null,
    hop: {
      up: { href: '/diensten/', label: 'Alle diensten' },
      side: { href: '/klantcases/', label: 'Bekijk de klantcases' },
      cta: { href: '/offerte-aanvragen/', label: 'Offerte aanvragen' },
    },
    forms: [contactForm({ id: 'homeContact' }), checklistForm({ id: 'homeChecklist' })],
    ld: () => jsonld({
      '@context': 'https://schema.org',
      '@graph': [
        { ...organizationNode(), ...ratingWithReviews(REVIEWS.slice(0, 3)) },
        founderNode(),
        { '@type': 'WebSite', '@id': SITE.origin + '/#website', url: SITE.origin + '/', name: SITE.name, publisher: { '@id': SITE.origin + '/#organization' }, inLanguage: 'nl-NL' },
        faqSchema(HOME_FAQ),
      ],
    }),
  },

  'diensten/index.html': {
    meta: {
      title: 'Onze diensten: schoonmaak per branche en per specialisme | Spotlezz',
      description: 'Alle diensten van Spotlezz op een rij. Zes branches van kantoor tot VvE, en vier specialismen van glasbewassing tot hygiëneservice.',
      path: '/diensten/',
    },
    trail: [{ label: 'Home', href: '/' }, { label: 'Diensten', href: '/diensten/' }],
    hop: {
      up: HUB,
      side: { href: '/locaties/', label: 'Bekijk ons werkgebied' },
      cta: { href: '/offerte-aanvragen/', label: 'Vraag je offerte aan' },
    },
    forms: [checklistForm({ id: 'dienstenChecklist' })],
  },

  'klantcases/index.html': {
    meta: {
      title: 'Klantcases: bewijs uit Almere, Lelystad en Amsterdam | Spotlezz',
      description: 'Echte resultaten bij echte klanten. Lees hoe wij werken bij Kobelco, KuchenTreff en Arena Gym, met cijfers en een quote van de opdrachtgever.',
      path: '/klantcases/',
    },
    trail: [{ label: 'Home', href: '/' }, { label: 'Klantcases', href: '/klantcases/' }],
    hop: {
      up: HUB,
      side: { href: '/diensten/', label: 'Bekijk onze diensten' },
      cta: { href: '/offerte-aanvragen/', label: 'Vraag je offerte aan' },
    },
    forms: [],
  },

  'over-ons/index.html': {
    meta: {
      title: 'Over Spotlezz: het team achter de schoonmaak | Spotlezz',
      description: 'Spotlezz begon als de droom van een jonge ondernemer en groeide uit tot een team met vaste gezichten in Almere en omstreken.',
      path: '/over-ons/',
    },
    trail: [{ label: 'Home', href: '/' }, { label: 'Over ons', href: '/over-ons/' }],
    hop: {
      up: HUB,
      side: { href: '/klantcases/', label: 'Bekijk de klantcases' },
      cta: { href: '/offerte-aanvragen/', label: 'Vraag je offerte aan' },
    },
    forms: [],
  },

  'contact/index.html': {
    meta: {
      title: 'Contact opnemen met Spotlezz in Almere | Spotlezz',
      description: 'Bel 036-785 7028 of stuur een bericht. Wij reageren binnen 12 uur op werkdagen en plannen een afspraak bij u op locatie.',
      path: '/contact/',
    },
    trail: [{ label: 'Home', href: '/' }, { label: 'Contact', href: '/contact/' }],
    hop: {
      up: HUB,
      side: { href: '/veelgestelde-vragen/', label: 'Veelgestelde vragen' },
      cta: { href: '/offerte-aanvragen/', label: 'Vraag je offerte aan' },
    },
    forms: [contactForm({ id: 'contactPage' })],
  },

  'blog/index.html': {
    meta: {
      title: 'Blog over schoonmaak en hygiëne op de werkvloer | Spotlezz',
      description: 'Artikelen over schoonmaak, hygiëne en het kiezen van een schoonmaakpartner voor kantoor, hotel en VvE.',
      path: '/blog/',
    },
    trail: [{ label: 'Home', href: '/' }, { label: 'Blog', href: '/blog/' }],
    hop: {
      up: HUB,
      side: { href: '/veelgestelde-vragen/', label: 'Veelgestelde vragen' },
      cta: { href: '/offerte-aanvragen/', label: 'Vraag je offerte aan' },
    },
    forms: [checklistForm({ id: 'blogChecklist' })],
  },

  'vacatures/index.html': {
    meta: {
      title: 'Werken bij Spotlezz: vacatures in Almere en omstreken | Spotlezz',
      description: 'Werken bij een schoonmaakbedrijf met vaste teams, vaste panden en een vast aanspreekpunt. Bekijk onze vacatures.',
      path: '/vacatures/',
    },
    trail: [{ label: 'Home', href: '/' }, { label: 'Vacatures', href: '/vacatures/' }],
    hop: {
      up: HUB,
      side: { href: '/over-ons/', label: 'Over Spotlezz' },
      cta: { href: '/contact/', label: 'Neem contact op' },
    },
    forms: [],
  },

  'privacybeleid/index.html': {
    meta: {
      title: 'Privacybeleid | Spotlezz',
      description: 'Hoe Spotlezz omgaat met persoonsgegevens die via de website, offerteaanvragen en contactformulieren binnenkomen.',
      path: '/privacybeleid/',
    },
    trail: [{ label: 'Home', href: '/' }, { label: 'Privacybeleid', href: '/privacybeleid/' }],
    hop: {
      up: HUB,
      side: { href: '/contact/', label: 'Neem contact op' },
      cta: { href: '/offerte-aanvragen/', label: 'Vraag je offerte aan' },
    },
    forms: [],
  },

  'checklist/index.html': {
    meta: {
      title: 'De Spotlezz-check: gratis schoonmaakchecklist | Spotlezz',
      description: 'Ontdek in vijf minuten of uw huidige schoonmaak op orde is. Dezelfde checklist die onze eigen teams gebruiken, gratis in uw inbox.',
      path: '/checklist/',
    },
    trail: [{ label: 'Home', href: '/' }, { label: 'Spotlezz-check', href: '/checklist/' }],
    hop: {
      up: HUB,
      side: { href: '/veelgestelde-vragen/', label: 'Veelgestelde vragen' },
      cta: { href: '/offerte-aanvragen/', label: 'Vraag je offerte aan' },
    },
    forms: [checklistForm({ id: 'checklistPage' })],
  },
};

// De zes bestaande branchepagina's
for (const b of BRANCHES) {
  EXISTING[`diensten/${b.slug}/index.html`] = {
    meta: { title: b.title, description: b.description, path: `/diensten/${b.slug}/` },
    trail: [
      { label: 'Home', href: '/' },
      { label: 'Diensten', href: '/diensten/' },
      { label: b.service, href: `/diensten/${b.slug}/` },
    ],
    hop: {
      up: { href: '/diensten/', label: 'Alle diensten' },
      side: { href: '/klantcases/kobelco/', label: 'Klantcase Kobelco' },
      cta: { href: '/offerte-aanvragen/', label: 'Vraag je offerte aan' },
    },
    forms: [
      quickQuoteForm({ id: `sq-${b.slug}`, dienst: b.service }),
      checklistForm({ id: `cl-${b.slug}` }),
      contactForm({ id: `ct-${b.slug}`, compact: true }),
    ],
    branche: b,
    ld: () => jsonld({
      '@context': 'https://schema.org',
      '@graph': [
        organizationNode(),
        founderNode(),
        breadcrumbNode([
          { label: 'Home', href: '/' },
          { label: 'Diensten', href: '/diensten/' },
          { label: b.service, href: `/diensten/${b.slug}/` },
        ]),
        {
          '@type': 'Service',
          '@id': `${SITE.origin}/diensten/${b.slug}/#service`,
          name: b.service,
          description: b.description,
          url: `${SITE.origin}/diensten/${b.slug}/`,
          serviceType: b.service,
          provider: { '@id': SITE.origin + '/#organization' },
          areaServed: CITIES.filter((c) => c.type === 'stad').map((c) => ({ '@type': 'City', name: c.name })),
          ...ratingWithReviews(REVIEWS.slice(0, 3)),
        },
        faqSchema(faqForService(b.slug)),
      ],
    }),
  };
}

// De drie bestaande klantcases
for (const c of CASES) {
  EXISTING[`klantcases/${c.slug}/index.html`] = {
    meta: {
      title: `Klantcase ${c.client}: ${c.branche.toLowerCase()}schoonmaak in ${c.city} | Spotlezz`,
      description: `Lees hoe Spotlezz de schoonmaak verzorgt bij ${c.client} in ${c.city}. Situatie, aanpak en resultaat, met cijfers en een quote van de opdrachtgever.`,
      path: `/klantcases/${c.slug}/`,
    },
    trail: [
      { label: 'Home', href: '/' },
      { label: 'Klantcases', href: '/klantcases/' },
      { label: c.client, href: `/klantcases/${c.slug}/` },
    ],
    hop: {
      up: { href: `/diensten/${c.services[0]}/`, label: ALL_SERVICES.find((s) => s.slug === c.services[0]).service },
      side: { href: `/locaties/${c.city.toLowerCase()}/`, label: `Schoonmaakbedrijf ${c.city}` },
      cta: { href: '/offerte-aanvragen/', label: `Ook zo'n resultaat? Vraag een offerte aan` },
    },
    forms: [],
    ld: () => jsonld({
      '@context': 'https://schema.org',
      '@graph': [
        organizationNode(),
        founderNode(),
        breadcrumbNode([
          { label: 'Home', href: '/' },
          { label: 'Klantcases', href: '/klantcases/' },
          { label: c.client, href: `/klantcases/${c.slug}/` },
        ]),
        {
          '@type': 'Article',
          '@id': `${SITE.origin}/klantcases/${c.slug}/#article`,
          headline: c.h1,
          description: c.teaser,
          image: `${SITE.origin}/images/case-${c.slug}.jpg`,
          datePublished: '2026-02-01',
          dateModified: '2026-08-15',
          inLanguage: 'nl-NL',
          author: { '@id': SITE.origin + '/#organization' },
          publisher: { '@id': SITE.origin + '/#organization' },
          mainEntityOfPage: { '@type': 'WebPage', '@id': `${SITE.origin}/klantcases/${c.slug}/` },
          about: { '@type': 'Organization', name: c.client },
          mentions: c.services.map((s) => ({
            '@type': 'Service', name: ALL_SERVICES.find((x) => x.slug === s).service,
          })),
        },
      ],
    }),
  };
}

/* ================================================================== */
/* Bestaande pagina's bijwerken                                        */
/* ================================================================== */

async function patchExisting() {
  for (const [rel, cfg] of Object.entries(EXISTING)) {
    const file = path.join(ROOT, rel);
    if (!existsSync(file)) { log('overgeslagen (bestaat niet):', rel); continue; }

    let html = await readFile(file, 'utf8');

    // Head volledig vervangen
    const ld = cfg.ld ? cfg.ld() : jsonld({
      '@context': 'https://schema.org',
      '@graph': [organizationNode(), founderNode(),
        ...(cfg.trail ? [breadcrumbNode(cfg.trail)] : [])],
    });
    html = replaceHead(html, head(cfg.meta) + '\n' + ld);

    // Chrome
    html = applyChrome(html, { trail: cfg.trail, hop: cfg.hop });

    // Formulieren
    html = replaceForms(html, cfg.forms || []);

    // Links, afbeeldingen, placeholders
    html = rewriteLinks(html, cfg.meta.path);
    html = stripPlaceholders(html);
    if (cfg.branche) html = fixPhotoPlaceholders(html, cfg.branche.service.toLowerCase());

    // Restanten van dode links
    html = html.replace(/<a href="#"([^>]*)>([\s\S]*?)<\/a>/g, (m, attrs, inner) => {
      if (/linkedin/i.test(m)) return '';           // profiel is niet bekend
      if (/Download de Checklist/i.test(inner)) {
        return `<a href="/checklist/"${attrs}>${inner}</a>`;
      }
      if (/Meet the team/i.test(inner)) {
        return `<a href="/over-ons/"${attrs}>${inner}</a>`;
      }
      return `<span${attrs}>${inner}</span>`;
    });

    // Afmetingen en lazy loading op elke afbeelding
    html = await fixImages(html);

    // Losse pijlen en dubbele witruimte opruimen
    html = html.replace(/[ \t]+\n/g, '\n').replace(/\n{4,}/g, '\n\n\n');

    await writeFile(file, html, 'utf8');
    log('bijgewerkt:', rel);
  }
}

/* ================================================================== */
/* Nieuwe pagina's genereren                                           */
/* ================================================================== */

async function writePage(rel, html) {
  const file = path.join(ROOT, rel);
  await mkdir(path.dirname(file), { recursive: true });
  await writeFile(file, await fixImages(html), 'utf8');
  log('gegenereerd:', rel);
}

async function generateNew() {
  for (const s of SERVICES) {
    await writePage(`diensten/${s.slug}/index.html`, servicePage(s.slug));
  }
  for (const c of CITIES) {
    await writePage(`locaties/${c.slug}/index.html`, locationPage(c.slug));
  }
  await writePage('locaties/index.html', locationsHub());
  await writePage('veelgestelde-vragen/index.html', faqHub());
  for (const d of FAQ_DETAILS) {
    await writePage(`veelgestelde-vragen/${d.slug}/index.html`, faqDetailPage(d));
  }
  await writePage('reviews/index.html', reviewsPage());
}

/* ================================================================== */
/* Offertepagina verplaatsen naar de Nederlandse URL                   */
/* ================================================================== */

async function moveQuotePage() {
  const from = path.join(ROOT, 'quote', 'index.html');
  const to = path.join(ROOT, 'offerte-aanvragen', 'index.html');
  if (!existsSync(from)) return;

  let html = await readFile(from, 'utf8');
  const trail = [{ label: 'Home', href: '/' }, { label: 'Offerte aanvragen', href: '/offerte-aanvragen/' }];

  html = replaceHead(html, head({
    title: 'Vrijblijvend een offerte aanvragen | Spotlezz',
    description: 'Vraag een offerte op maat aan voor bedrijfsschoonmaak. Wij reageren binnen 12 uur en sturen binnen 24 uur een voorstel met een opbouw per regel.',
    path: '/offerte-aanvragen/',
  }) + '\n' + jsonld({
    '@context': 'https://schema.org',
    '@graph': [organizationNode(), founderNode(), breadcrumbNode(trail)],
  }));

  html = applyChrome(html, {
    trail,
    hop: {
      up: { href: '/diensten/', label: 'Alle diensten' },
      side: { href: '/veelgestelde-vragen/wat-bepaalt-de-prijs-van-schoonmaak/', label: 'Waar is een offerte uit opgebouwd?' },
      cta: { href: `tel:${SITE.phoneRaw}`, label: `Liever bellen? ${SITE.phone}` },
    },
  });
  html = replaceForms(html, [contactForm({ id: 'offerteForm', heading: 'Vraag een offerte aan', submit: 'Offerte aanvragen' })]);
  html = rewriteLinks(html, '/offerte-aanvragen/');
  html = stripPlaceholders(html);
  html = html.replace(/<a href="#"([^>]*)>([\s\S]*?)<\/a>/g, '<span$1>$2</span>');
  html = await fixImages(html);

  await mkdir(path.dirname(to), { recursive: true });
  await writeFile(to, html, 'utf8');
  await rm(path.join(ROOT, 'quote'), { recursive: true, force: true });
  log('verplaatst: /quote/ -> /offerte-aanvragen/');
}

/* ================================================================== */
/* robots.txt, sitemap.xml, vercel.json, favicon                       */
/* ================================================================== */

async function collectUrls() {
  const urls = [];
  async function walk(dir, prefix = '') {
    for (const entry of await readdir(dir)) {
      const full = path.join(dir, entry);
      const st = await stat(full);
      if (st.isDirectory()) {
        if (['images', 'vendor', 'node_modules'].includes(entry)) continue;
        await walk(full, `${prefix}/${entry}`);
      } else if (entry === 'index.html') {
        urls.push(`${prefix}/`);
      }
    }
  }
  await walk(ROOT);
  return urls.sort();
}

const PRIORITY = (u) => {
  if (u === '/') return '1.0';
  if (/^\/(diensten|locaties)\/[^/]+\/$/.test(u)) return '0.9';
  if (/^\/(diensten|locaties|klantcases|veelgestelde-vragen)\/$/.test(u)) return '0.8';
  if (/^\/klantcases\/[^/]+\/$/.test(u)) return '0.7';
  return '0.5';
};

async function writeMeta() {
  const urls = await collectUrls();
  const today = '2026-08-15';

  const sitemap = `<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
${urls.map((u) => `  <url>
    <loc>${SITE.origin}${u}</loc>
    <lastmod>${today}</lastmod>
    <priority>${PRIORITY(u)}</priority>
  </url>`).join('\n')}
</urlset>
`;
  await writeFile(path.join(ROOT, 'sitemap.xml'), sitemap, 'utf8');
  log('geschreven: sitemap.xml met', urls.length, 'url\'s');

  const robots = `# robots.txt voor ${SITE.origin}
User-agent: *
Allow: /
Disallow: /what-we-have-done.html

Sitemap: ${SITE.origin}/sitemap.xml
`;
  await writeFile(path.join(ROOT, 'robots.txt'), robots, 'utf8');
  log('geschreven: robots.txt');

  // Vercel: schone URL's, redirects en noindex op het previewdomein
  const vercel = {
    $schema: 'https://openapi.vercel.sh/vercel.json',
    cleanUrls: true,
    trailingSlash: true,
    redirects: [
      { source: '/quote', destination: '/offerte-aanvragen', permanent: true },
      { source: '/quote/:path*', destination: '/offerte-aanvragen', permanent: true },
      { source: '/contact-us', destination: '/contact', permanent: true },
      { source: '/contact-us/:path*', destination: '/contact', permanent: true },
      { source: '/sectoren/glasbewassing', destination: '/diensten/glasbewassing', permanent: true },
      { source: '/sectoren/vloeronderhoud', destination: '/diensten/vloeronderhoud', permanent: true },
      { source: '/sectoren/sanitaire-voorzieningen', destination: '/diensten/hygieneservice', permanent: true },
      { source: '/sectoren/gevelonderhoud', destination: '/diensten/glasbewassing', permanent: true },
      { source: '/sectoren/schoonmaakonderhoud', destination: '/diensten', permanent: true },
      { source: '/sectoren/specialistische-reiniging', destination: '/diensten', permanent: true },
      { source: '/sectoren', destination: '/diensten', permanent: true },
      { source: '/case-study', destination: '/klantcases', permanent: true },
      { source: '/spotlezz-check', destination: '/checklist', permanent: true },
      { source: '/diensten-1', destination: '/diensten', permanent: true },
      { source: '/kantoorschoonmaak-1', destination: '/diensten/kantoor-schoonmaak', permanent: true },
      { source: '/over-ons-1', destination: '/over-ons', permanent: true },
    ],
    headers: [
      {
        // Het previewdomein mag nooit geindexeerd worden naast spotlezz.nl.
        source: '/(.*)',
        has: [{ type: 'host', value: '(.*)\\.vercel\\.app' }],
        headers: [{ key: 'X-Robots-Tag', value: 'noindex, nofollow' }],
      },
      {
        source: '/images/(.*)',
        headers: [{ key: 'Cache-Control', value: 'public, max-age=31536000, immutable' }],
      },
      {
        source: '/vendor/(.*)',
        headers: [{ key: 'Cache-Control', value: 'public, max-age=31536000, immutable' }],
      },
      {
        source: '/(.*)',
        headers: [
          { key: 'X-Content-Type-Options', value: 'nosniff' },
          { key: 'Referrer-Policy', value: 'strict-origin-when-cross-origin' },
        ],
      },
    ],
  };
  await writeFile(path.join(ROOT, 'vercel.json'), JSON.stringify(vercel, null, 2) + '\n', 'utf8');
  log('geschreven: vercel.json');

  // Favicon: de S van Spotlezz op de merkkleur
  const favicon = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
  <rect width="64" height="64" rx="12" fill="#0D0D1A"/>
  <text x="32" y="45" font-family="Montserrat, Arial, sans-serif" font-size="40" font-weight="700" fill="#FF5500" text-anchor="middle">S</text>
</svg>
`;
  await writeFile(path.join(ROOT, 'favicon.svg'), favicon, 'utf8');
  log('geschreven: favicon.svg');
}

/* ================================================================== */
/* Aanvullende styling in style.css injecteren                         */
/* ================================================================== */

const CSS_START = '/* === SPOTLEZZ BUILD START === */';
const CSS_END = '/* === SPOTLEZZ BUILD EIND === */';

/** main.js wordt beheerd in build/ en hiernaartoe gekopieerd. */
async function writeScript() {
  const src = path.join(__dirname, 'main.js');
  const dest = path.join(ROOT, 'main.js');
  await writeFile(dest, await readFile(src, 'utf8'), 'utf8');
  log('main.js bijgewerkt');
}

async function writeStyles() {
  const target = path.join(ROOT, 'style.css');
  const additions = await readFile(path.join(__dirname, 'styles.css'), 'utf8');
  let css = await readFile(target, 'utf8');

  const block = `${CSS_START}\n${additions}\n${CSS_END}\n`;
  const s = css.indexOf(CSS_START);
  const e = css.indexOf(CSS_END);

  if (s !== -1 && e !== -1) {
    css = css.slice(0, s) + block + css.slice(e + CSS_END.length + 1);
  } else {
    css = css.trimEnd() + '\n\n' + block;
  }

  await writeFile(target, css, 'utf8');
  log('style.css bijgewerkt met het buildblok');
}

/* ================================================================== */
/* Afbeeldingen ophalen                                                */
/* ================================================================== */

const DOWNLOADS = {
  'pand-interieur.jpg': 'https://spotlezz.nl/wp-content/uploads/2026/03/sr1-1024x665.jpg',
  'team-aan-het-werk.jpg': 'https://spotlezz.nl/wp-content/uploads/2026/03/sr2-1024x665.jpg',
  'case-kuchentreff.jpg': 'https://spotlezz.nl/wp-content/uploads/2026/03/sr3-1024x665.jpg',
  'case-arena-gym.jpg': 'https://spotlezz.nl/wp-content/uploads/2026/03/sr4-1024x665.jpg',
  'branche-kantoor.jpg': 'https://spotlezz.nl/wp-content/uploads/2026/03/sr5-1024x665.jpg',
  'branche-vve.jpg': 'https://spotlezz.nl/wp-content/uploads/2026/03/sr6-1024x665.jpg',
  // Bewust de 1024-variant en niet het origineel van 2048x1365 (1,5 MB).
  'materiaal-producten.jpg': 'https://spotlezz.nl/wp-content/uploads/2026/03/DSC02837-1024x683.jpg',
  'checklist-achtergrond.jpg': 'https://spotlezz.nl/wp-content/uploads/2026/01/we-visit-your-office.jpg',
  'professionele-schoonmaak.jpg': 'https://spotlezz.nl/wp-content/uploads/2026/02/professionele-schoonmaak.jpg',
  'kantoor-werkplek.jpg': 'https://spotlezz.nl/wp-content/uploads/2026/01/Office-11-1.jpg',
  'kantoor-detail.jpg': 'https://spotlezz.nl/wp-content/uploads/2026/01/Office-11-2-1.jpg',
  'klantlogo-1.png': 'https://spotlezz.nl/wp-content/uploads/2026/01/logo-1.png.png',
  'klantlogo-2.png': 'https://spotlezz.nl/wp-content/uploads/2026/01/image002_edited.jpg.png',
  'klantlogo-3.png': 'https://spotlezz.nl/wp-content/uploads/2026/02/image6.png',
  'achtergrond.jpg': 'https://spotlezz.nl/wp-content/uploads/2026/01/Background.jpg',
  'achtergrond-2.jpg': 'https://spotlezz.nl/wp-content/uploads/2026/01/Background-1.jpg',
  'checklist-preview.jpg': 'https://spotlezz.nl/wp-content/uploads/2026/02/Checklist-vertical.jpg',
  'sfeer-1.jpg': 'https://spotlezz.nl/wp-content/uploads/2026/01/Frame-2147227652-1.jpg',
  'sfeer-2.jpg': 'https://spotlezz.nl/wp-content/uploads/2026/03/Frame-2147227723-scaled.jpg',
  'sfeer-3.jpg': 'https://spotlezz.nl/wp-content/uploads/2026/01/66cf9f5b0c337de9e5a2c919_image1.webp-4-scaled.jpg',
  'stap-offerte.jpg': 'https://spotlezz.nl/wp-content/uploads/2026/01/You-get-a-quote.jpg',
  'stap-team-start.jpg': 'https://spotlezz.nl/wp-content/uploads/2026/01/Your-dedicated-team-starts-cleaning.jpg',
  'stap-resultaat.jpg': 'https://spotlezz.nl/wp-content/uploads/2026/01/You-see-the-result.jpg',
};

async function downloadAssets() {
  const dir = path.join(ROOT, 'images');
  await mkdir(dir, { recursive: true });
  for (const [name, url] of Object.entries(DOWNLOADS)) {
    const dest = path.join(dir, name);
    if (existsSync(dest)) { log('aanwezig:', name); continue; }
    try {
      const res = await fetch(url);
      if (!res.ok) { log('mislukt', res.status, name); continue; }
      await writeFile(dest, Buffer.from(await res.arrayBuffer()));
      log('gedownload:', name);
    } catch (e) {
      log('fout bij', name, e.message);
    }
  }
  // case-kobelco is hetzelfde beeld als het interieur
  const kob = path.join(dir, 'case-kobelco.jpg');
  if (!existsSync(kob) && existsSync(path.join(dir, 'pand-interieur.jpg'))) {
    await writeFile(kob, await readFile(path.join(dir, 'pand-interieur.jpg')));
    log('gekopieerd: case-kobelco.jpg');
  }

  // Eenvoudige werkgebiedkaart, geen externe iframe nodig
  const kaart = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 360" role="img" aria-label="Kaart van het werkgebied">
  <rect width="640" height="360" fill="#EDF1F5"/>
  <path d="M0 250 Q160 210 320 240 T640 220 L640 360 L0 360 Z" fill="#DCE6EF"/>
  <circle cx="290" cy="170" r="12" fill="#FF5500"/>
  <text x="290" y="150" font-family="Montserrat,Arial,sans-serif" font-size="16" font-weight="700" fill="#0D0D1A" text-anchor="middle">Almere</text>
  <circle cx="400" cy="110" r="7" fill="#1B2EFF"/>
  <text x="400" y="95" font-family="Montserrat,Arial,sans-serif" font-size="13" fill="#0D0D1A" text-anchor="middle">Lelystad</text>
  <circle cx="150" cy="200" r="7" fill="#1B2EFF"/>
  <text x="150" y="185" font-family="Montserrat,Arial,sans-serif" font-size="13" fill="#0D0D1A" text-anchor="middle">Amsterdam</text>
  <circle cx="330" cy="290" r="7" fill="#1B2EFF"/>
  <text x="330" y="315" font-family="Montserrat,Arial,sans-serif" font-size="13" fill="#0D0D1A" text-anchor="middle">Amersfoort</text>
</svg>
`;
  await writeFile(path.join(dir, 'werkgebied-kaart.svg'), kaart, 'utf8');
  log('geschreven: werkgebied-kaart.svg');
}

/* ================================================================== */

async function main() {
  const wantAssets = process.argv.includes('--assets');
  console.log('\nSpotlezz build\n');
  if (wantAssets) { console.log('Afbeeldingen:'); await downloadAssets(); }
  console.log('\nNieuwe pagina\'s:');
  await generateNew();
  console.log('\nBestaande pagina\'s:');
  await patchExisting();
  await moveQuotePage();
  console.log('\nStyling en script:');
  await writeStyles();
  await writeScript();
  console.log('\nMeta:');
  await writeMeta();
  console.log('\nKlaar.\n');
}

main().catch((e) => { console.error(e); process.exit(1); });
