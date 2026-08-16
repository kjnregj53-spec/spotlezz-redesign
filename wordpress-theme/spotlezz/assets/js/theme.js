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

		function openNav() {
			nav.hidden = false;
			openBtn.setAttribute( 'aria-expanded', 'true' );
			document.body.style.overflow = 'hidden';
		}

		function closeNav() {
			nav.hidden = true;
			openBtn.setAttribute( 'aria-expanded', 'false' );
			document.body.style.overflow = '';
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

		var groups = document.querySelectorAll( '.faq-theme-group' );

		function applyFilter() {
			var query = searchInput.value.trim().toLowerCase();

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
			} );
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
