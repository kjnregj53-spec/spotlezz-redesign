/* =====================================================================
   Spotlezz - frontend
   ===================================================================== */

/* ---------------------------------------------------------------------
   1. FORMULIEREN

   Vul hieronder het endpoint in waar de aanvragen naartoe moeten. Het werkt
   met elke dienst die een POST met JSON accepteert, bijvoorbeeld Formspree,
   Web3Forms of een eigen serverless functie.

   Zolang dit leeg is valt elk formulier terug op een voorgevulde e-mail naar
   info@spotlezz.nl. Zo verdwijnt er in de tussentijd geen enkele aanvraag,
   wat wel gebeurde toen de formulieren nergens naartoe stuurden.
   --------------------------------------------------------------------- */

var FORM_ENDPOINT = '';

var FORM_LABELS = {
  contact: 'Contactaanvraag via de website',
  offerte: 'Offerteaanvraag via de website',
  checklist: 'Aanvraag Spotlezz-checklist'
};

function serialiseForm(form) {
  var data = {};
  new FormData(form).forEach(function (value, key) {
    if (key === 'website') return;              // honeypot
    if (key === 'akkoord') { data[key] = 'ja'; return; }
    data[key] = value;
  });
  return data;
}

function setStatus(form, message, state) {
  var el = form.querySelector('.form-status');
  if (!el) return;
  el.textContent = message;
  el.className = 'form-status' + (state ? ' is-' + state : '');
}

function firstInvalid(form) {
  var fields = form.querySelectorAll('input, textarea, select');
  for (var i = 0; i < fields.length; i++) {
    if (!fields[i].checkValidity()) return fields[i];
  }
  return null;
}

function mailtoFallback(form, kind, data) {
  var subject = FORM_LABELS[kind] || 'Aanvraag via de website';
  var lines = Object.keys(data).map(function (k) {
    return k.charAt(0).toUpperCase() + k.slice(1) + ': ' + data[k];
  });
  lines.push('', 'Verstuurd vanaf ' + window.location.href);
  window.location.href = 'mailto:info@spotlezz.nl'
    + '?subject=' + encodeURIComponent(subject)
    + '&body=' + encodeURIComponent(lines.join('\n'));
  setStatus(form, 'Uw mailprogramma wordt geopend met de aanvraag erin. Liever bellen? 036-785 7028.', 'ok');
}

function handleSubmit(event) {
  var form = event.target;
  if (!form.matches || !form.matches('form[data-form]')) return;
  event.preventDefault();

  // Honeypot: gevuld betekent een bot. Doe alsof het gelukt is.
  var hp = form.querySelector('[name="website"]');
  if (hp && hp.value) {
    setStatus(form, 'Bedankt, wij nemen contact op.', 'ok');
    return;
  }

  if (!form.checkValidity()) {
    var bad = firstInvalid(form);
    setStatus(form, 'Controleer de gemarkeerde velden.', 'error');
    if (bad) { bad.focus(); bad.setAttribute('aria-invalid', 'true'); }
    return;
  }

  var kind = form.getAttribute('data-form');
  var data = serialiseForm(form);
  data._onderwerp = FORM_LABELS[kind] || 'Aanvraag';
  data._pagina = window.location.pathname;

  var button = form.querySelector('button[type="submit"]');
  var original = button ? button.textContent : '';

  if (!FORM_ENDPOINT) {
    mailtoFallback(form, kind, data);
    return;
  }

  if (button) { button.disabled = true; button.textContent = 'Bezig met verzenden...'; }
  setStatus(form, '', '');

  fetch(FORM_ENDPOINT, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
    body: JSON.stringify(data)
  })
    .then(function (res) {
      if (!res.ok) throw new Error('status ' + res.status);
      form.reset();
      setStatus(form, 'Bedankt. Wij nemen binnen 12 uur op werkdagen contact met u op.', 'ok');
    })
    .catch(function () {
      setStatus(form, 'Verzenden lukte niet. Bel ons op 036-785 7028 of mail naar info@spotlezz.nl.', 'error');
    })
    .then(function () {
      if (button) { button.disabled = false; button.textContent = original; }
    });
}

/* ---------------------------------------------------------------------
   2. MOBIELE NAVIGATIE

   Het overlay-paneel stond eerder buiten het scherm geparkeerd zonder dat de
   pagina dat afving, waardoor het hele document 830px breed werd op een
   telefoon van 375px. Nu wordt het paneel echt verborgen met hidden.
   --------------------------------------------------------------------- */

function toggleMobileMenu() {
  var nav = document.getElementById('mobileNav');
  if (!nav) return;
  var button = document.querySelector('.mobile-menu-btn');
  var open = !nav.hasAttribute('hidden');

  if (open) {
    nav.setAttribute('hidden', '');
    document.body.classList.remove('nav-open');
    if (button) { button.setAttribute('aria-expanded', 'false'); button.focus(); }
  } else {
    nav.removeAttribute('hidden');
    document.body.classList.add('nav-open');
    if (button) button.setAttribute('aria-expanded', 'true');
    var first = nav.querySelector('a, button');
    if (first) first.focus();
  }
}
window.toggleMobileMenu = toggleMobileMenu;

/* ---------------------------------------------------------------------
   3. FAQ-ACCORDION
   Vragen zijn knoppen met aria-expanded, dus bedienbaar met het toetsenbord.
   --------------------------------------------------------------------- */

function initAccordion() {
  document.addEventListener('click', function (e) {
    var button = e.target.closest ? e.target.closest('.faq-question') : null;
    if (!button) return;
    var panel = document.getElementById(button.getAttribute('aria-controls'));
    if (!panel) return;
    var open = button.getAttribute('aria-expanded') === 'true';

    // Binnen dezelfde lijst de rest sluiten
    var list = button.closest('.faq-list, .faq-theme');
    if (list && !open) {
      Array.prototype.forEach.call(
        list.querySelectorAll('.faq-question[aria-expanded="true"]'),
        function (other) {
          other.setAttribute('aria-expanded', 'false');
          var op = document.getElementById(other.getAttribute('aria-controls'));
          if (op) op.setAttribute('hidden', '');
        }
      );
    }

    button.setAttribute('aria-expanded', String(!open));
    if (open) panel.setAttribute('hidden', '');
    else panel.removeAttribute('hidden');
  });
}

/* ---------------------------------------------------------------------
   4. FAQ-HUB: zoeken en filteren
   --------------------------------------------------------------------- */

function initFaqHub() {
  var hub = document.querySelector('.faq-hub');
  if (!hub) return;

  var search = document.getElementById('faqSearch');
  var filters = document.querySelectorAll('.faq-filter');
  var empty = hub.querySelector('.faq-empty');
  var count = document.querySelector('.faq-search-count');
  var activeTheme = 'alles';

  function apply() {
    var term = ((search && search.value) || '').trim().toLowerCase();
    var visible = 0;

    Array.prototype.forEach.call(hub.querySelectorAll('.faq-theme'), function (section) {
      var themeOk = activeTheme === 'alles' || section.getAttribute('data-theme') === activeTheme;
      var shown = 0;

      Array.prototype.forEach.call(section.querySelectorAll('.faq-item'), function (item) {
        var text = item.textContent.toLowerCase();
        var match = themeOk && (!term || text.indexOf(term) !== -1);
        item.hidden = !match;
        if (match) shown++;
      });

      section.hidden = shown === 0;
      visible += shown;
    });

    if (empty) empty.hidden = visible !== 0;
    if (count) {
      count.textContent = term
        ? visible + (visible === 1 ? ' vraag gevonden' : ' vragen gevonden')
        : '';
    }
  }

  if (search) search.addEventListener('input', apply);
  Array.prototype.forEach.call(filters, function (btn) {
    btn.addEventListener('click', function () {
      Array.prototype.forEach.call(filters, function (b) { b.classList.remove('is-active'); });
      btn.classList.add('is-active');
      activeTheme = btn.getAttribute('data-theme');
      apply();
    });
  });
}

/* ---------------------------------------------------------------------
   5. SCROLL REVEAL, met respect voor prefers-reduced-motion
   --------------------------------------------------------------------- */

/**
 * De bestaande stylesheet verbergt .reveal met opacity 0 en maakt het weer
 * zichtbaar via de class `active`. De nieuwe componenten gebruiken
 * `is-visible`. Beide moeten gezet worden, anders blijft een halve pagina
 * onzichtbaar en zie je alleen witruimte.
 */
function show(el) {
  el.classList.add('active');
  el.classList.add('is-visible');
}

function initReveal() {
  var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var items = document.querySelectorAll('.reveal, .work-tile, .proof-card, .step-card, .factor-card');
  if (reduce || !('IntersectionObserver' in window)) {
    Array.prototype.forEach.call(items, show);
    return;
  }
  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        show(entry.target);
        io.unobserve(entry.target);
      }
    });
  }, { threshold: 0, rootMargin: '300px 0px 300px 0px' });
  Array.prototype.forEach.call(items, function (el) { io.observe(el); });

  // Vangnet. Content mag nooit onzichtbaar blijven doordat een observer om
  // welke reden dan ook niet afvuurt.
  window.setTimeout(function () {
    Array.prototype.forEach.call(items, show);
  }, 2500);
}

/* ---------------------------------------------------------------------
   6. Actieve navigatielink markeren
   --------------------------------------------------------------------- */

function markActiveNav() {
  var here = window.location.pathname.replace(/index\.html$/, '');
  Array.prototype.forEach.call(
    document.querySelectorAll('nav a, .mobile-nav-links a'),
    function (link) {
      if (link.classList.contains('dropbtn')) return;
      var href = link.getAttribute('href');
      if (!href || href.charAt(0) !== '/') return;
      if (href === here) {
        link.classList.add('is-current');
        link.setAttribute('aria-current', 'page');
      }
    }
  );
}

/* ---------------------------------------------------------------------
   Start
   --------------------------------------------------------------------- */

document.addEventListener('DOMContentLoaded', function () {
  document.addEventListener('submit', handleSubmit);
  initAccordion();
  initFaqHub();
  initReveal();
  markActiveNav();

  // Menu sluiten na het klikken op een link
  var nav = document.getElementById('mobileNav');
  if (nav) {
    nav.addEventListener('click', function (e) {
      if (e.target.closest && e.target.closest('a')) toggleMobileMenu();
    });
  }

  document.addEventListener('keydown', function (e) {
    if (e.key !== 'Escape') return;
    var n = document.getElementById('mobileNav');
    if (n && !n.hasAttribute('hidden')) toggleMobileMenu();
  });
});
