/**
 * Foundation-JS (fase 4A): alleen het mobiele menu. Sectie-specifiek
 * gedrag (FAQ-accordion, formulier-submits, lead-magnet) komt met de
 * bijbehorende content in fase 4B/4C.
 */
( function () {
	'use strict';

	function ready( fn ) {
		if ( document.readyState !== 'loading' ) {
			fn();
		} else {
			document.addEventListener( 'DOMContentLoaded', fn );
		}
	}

	ready( function () {
		var openBtn  = document.querySelector( '.mobile-menu-btn' );
		var closeBtn = document.querySelector( '.close-menu-btn' );
		var nav      = document.getElementById( 'mobileNav' );

		if ( ! openBtn || ! nav ) {
			return;
		}

		/**
		 * [hidden] wordt eerst weggehaald (display:none -> flex), en pas
		 * daarna, in het volgende frame, krijgt het paneel de .open-klasse
		 * die de CSS-transition (transform/opacity) triggert — direct
		 * .open toevoegen terwijl [hidden] nog net weg is geeft de browser
		 * geen kans om de begintoestand te schilderen, dus dan animeert er
		 * niets. Bij het sluiten precies andersom: eerst .open weghalen
		 * zodat de transition-out kan spelen, dan pas [hidden] terugzetten
		 * zodra die transition klaar is.
		 */
		function openNav() {
			nav.hidden = false;
			void nav.offsetHeight; // forceer een reflow zodat de browser de starttoestand (transform:translateX(100%)) al geschilderd heeft vóór .open de transition triggert — robuuster dan requestAnimationFrame, dat een gecomposit frame nodig heeft.
			nav.classList.add( 'open' );
			openBtn.setAttribute( 'aria-expanded', 'true' );
			document.body.style.overflow = 'hidden';
		}

		function closeNav() {
			nav.classList.remove( 'open' );
			openBtn.setAttribute( 'aria-expanded', 'false' );
			document.body.style.overflow = '';
			setTimeout( function () {
				nav.hidden = true;
			}, 400 );
		}

		openBtn.addEventListener( 'click', openNav );

		if ( closeBtn ) {
			closeBtn.addEventListener( 'click', closeNav );
		}

		nav.addEventListener( 'click', function ( event ) {
			if ( event.target === nav ) {
				closeNav();
			}
		} );

		document.addEventListener( 'keydown', function ( event ) {
			if ( 'Escape' === event.key && ! nav.hidden ) {
				closeNav();
			}
		} );
	} );

	/**
	 * Zwevende snelofferte-popup (.sticky-snelofferte): de kop is op
	 * mobiel het enige zichtbare stuk (zie CSS), tikken schuift het
	 * paneel open/dicht. Op desktop staat hij toch al open, maar de
	 * toggle blijft werken zodat een gebruiker hem ook daar kan
	 * dichtklikken. Event-delegated omdat de knop-ID per post verschilt.
	 */
	ready( function () {
		document.addEventListener( 'click', function ( event ) {
			var header = event.target.closest ? event.target.closest( '.sticky-snelofferte-header' ) : null;
			if ( ! header ) {
				return;
			}
			var panel = header.closest( '.sticky-snelofferte' );
			if ( ! panel ) {
				return;
			}
			var isOpen = panel.classList.toggle( 'open' );
			header.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
		} );
	} );

	/**
	 * Offerte-kengetallen (.offerte-kengetal): telt op naar het eindgetal
	 * en faded in met een stagger zodra de rij in beeld komt. Leest de
	 * bestaande servertekst ("4,8/5", "87+", "94%") i.p.v. aparte
	 * data-attributen, en herstelt die tekst exact na afloop zodat
	 * afronding nooit kan afwijken van de echte waarde.
	 */
	ready( function () {
		var items = document.querySelectorAll( '.offerte-kengetal' );
		if ( ! items.length ) {
			return;
		}
		var reduceMotion = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

		function animateValue( el ) {
			var text  = el.textContent.trim();
			var match = text.match( /^(\d+)(,(\d+))?/ );
			if ( ! match ) {
				return;
			}
			var suffix   = text.slice( match[0].length );
			var hasDec   = undefined !== match[3];
			var target   = hasDec ? parseFloat( match[1] + '.' + match[3] ) : parseInt( match[1], 10 );
			var duration = 900;
			var start    = null;

			function step( timestamp ) {
				if ( ! start ) {
					start = timestamp;
				}
				var progress = Math.min( ( timestamp - start ) / duration, 1 );
				var current  = target * progress;
				el.textContent = ( hasDec ? current.toFixed( 1 ).replace( '.', ',' ) : Math.round( current ) ) + suffix;
				if ( progress < 1 ) {
					requestAnimationFrame( step );
				} else {
					el.textContent = text;
				}
			}
			requestAnimationFrame( step );
		}

		if ( reduceMotion || ! ( 'IntersectionObserver' in window ) ) {
			items.forEach( function ( item ) {
				item.classList.add( 'in-view' );
			} );
			return;
		}

		var observer = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( ! entry.isIntersecting ) {
					return;
				}
				entry.target.classList.add( 'in-view' );
				var valueEl = entry.target.querySelector( '.offerte-kengetal-value' );
				if ( valueEl ) {
					animateValue( valueEl );
				}
				observer.unobserve( entry.target );
			} );
		}, { threshold: 0.4 } );

		items.forEach( function ( item ) {
			observer.observe( item );
		} );
	} );

	/**
	 * FAQ-hub zoekfilter (fase 4C, archive-vraag.php). Puur client-side
	 * tekstmatch tegen `data-search-text` op elk `.faq-item`; een
	 * `.faq-theme-group` verbergt zichzelf zodra geen van zijn vragen meer
	 * matcht, zodat er nooit een leeg thema-kopje overblijft.
	 */
	ready( function () {
		var searchInput = document.getElementById( 'faqSearch' );
		if ( ! searchInput ) {
			return;
		}

		var groups     = document.querySelectorAll( '.faq-theme-group' );
		var noResults  = document.getElementById( 'faqNoResults' );

		function applyFilter() {
			var query      = searchInput.value.trim().toLowerCase();
			var totalVisible = 0;

			groups.forEach( function ( group ) {
				var items          = group.querySelectorAll( '.faq-item' );
				var visibleInGroup = 0;

				items.forEach( function ( item ) {
					var matches = '' === query || item.dataset.searchText.indexOf( query ) !== -1;
					item.hidden = ! matches;
					if ( matches ) {
						visibleInGroup++;
					}
				} );

				group.hidden = 0 === visibleInGroup;
				totalVisible += visibleInGroup;
			} );

			if ( noResults ) {
				noResults.hidden = 0 !== totalVisible;
			}
		}

		searchInput.addEventListener( 'input', applyFilter );

		var allPill = document.querySelector( '.faq-theme-pill-all' );
		if ( allPill ) {
			allPill.addEventListener( 'click', function ( event ) {
				event.preventDefault();
				searchInput.value = '';
				applyFilter();
				groups.forEach( function ( group ) {
					group.hidden = false;
				} );
			} );
		}
	} );
}() );
