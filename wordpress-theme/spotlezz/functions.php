<?php
/**
 * Theme bootstrap.
 *
 * Fase 4A (foundation): laadt alleen de bouwstenen op uit audit/WORDPRESS-BUILD-PLAN.md
 * §1-§4 — structuur, schema-architectuur, Site Options-fundament en component-
 * architectuur. Geen paginacontent, geen volledige ACF-veldgroepen per paginatype
 * (dat is fase 4B/4C). Zie inc/README-verwijzing onderaan dit bestand.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access is not allowed.
}

define( 'SPOTLEZZ_THEME_VERSION', '0.1.0' );
define( 'SPOTLEZZ_THEME_DIR', get_template_directory() );
define( 'SPOTLEZZ_THEME_URI', get_template_directory_uri() );

/**
 * Foundation includes. Volgorde is bewust: setup en escaping-conventies eerst,
 * dan site-options (want schema en components lezen daaruit), dan de rest.
 */
$spotlezz_includes = array(
	'inc/setup.php',           // theme supports, menus, image sizes, content width
	'inc/enqueue.php',         // CSS/JS laden
	'inc/site-options.php',    // gecentraliseerde NAP-bron (hard regel 14)
	'inc/post-types.php',      // pillar / case / locatie / vraag — voor de template hierarchy
	'inc/acf-fields.php',      // basis ACF-integratie, guarded — geen volledige veldgroepen per type
	'inc/acf-homepage.php',    // fase 4B: homepage-veldgroep (WORDPRESS-BUILD-PLAN §3.1)
	'inc/acf-pillar.php',      // fase 4C: dienst-pillar-veldgroep (WORDPRESS-BUILD-PLAN §3.2)
	'inc/acf-case.php',        // fase 4C: klantcase-veldgroep (WORDPRESS-BUILD-PLAN §3.3)
	'inc/acf-locatie.php',     // fase 4C: locatie-veldgroep (WORDPRESS-BUILD-PLAN §3.4)
	'inc/acf-vraag.php',       // fase 4C: FAQ-detail-veldgroep (WORDPRESS-BUILD-PLAN §3.5)
	'inc/acf-standalone-pages.php', // veldgroepen voor Contact/Over ons/Checklist/Vacatures/Offerte/Reviews
	'inc/schema.php',          // JSON-LD architectuur (Organization, Person, BreadcrumbList, ...)
	'inc/breadcrumbs.php',     // kruimelpad-component + schema
	'inc/components.php',      // herbruikbare component-functies (next-hop bar, etc.)
	'inc/seo-yoast.php',       // Yoast-compatibiliteit
	'inc/publish-gate.php',    // locatiepagina noindex-gate (hard regel 12 / §5.4)
);

foreach ( $spotlezz_includes as $spotlezz_include ) {
	$spotlezz_include_path = SPOTLEZZ_THEME_DIR . '/' . $spotlezz_include;
	if ( file_exists( $spotlezz_include_path ) ) {
		require_once $spotlezz_include_path;
	}
}
unset( $spotlezz_includes, $spotlezz_include, $spotlezz_include_path );
