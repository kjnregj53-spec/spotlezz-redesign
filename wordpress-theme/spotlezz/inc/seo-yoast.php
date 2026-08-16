<?php
/**
 * SEO / Yoast-compatibiliteit.
 *
 * De theme rendert zelf geen <title>, meta description, canonical of Open
 * Graph-tags — dat blijft altijd Yoast's taak zodra het actief is (of
 * WordPress core via add_theme_support('title-tag') als dat niet zo is).
 * Het enige raakvlak is schema: Yoast bouwt zelf al een @graph met
 * Organization, WebSite en BreadcrumbList. Zonder ingrijpen zou de theme
 * dezelfde nodes een tweede keer uitvoeren. Dit bestand schakelt daarom de
 * overlappende theme-schema uit zodra Yoast's eigen schema-graph actief is,
 * en laat de paginatype-specifieke nodes (Person, Service, Review, FAQPage —
 * fase 4B/4C) gewoon staan, want die dekt Yoast niet automatisch.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Is Yoast SEO (of Yoast SEO Premium) actief?
 */
function spotlezz_yoast_active() {
	return defined( 'WPSEO_VERSION' );
}

/**
 * Schakel de theme's eigen Organization/WebSite-node uit zodra Yoast's
 * schema-graph dat al voor zijn rekening neemt (Yoast doet dit standaard
 * vanaf de site-wide "Kennisgraaf"-instellingen).
 */
function spotlezz_disable_duplicate_schema_with_yoast( $should_output ) {
	if ( spotlezz_yoast_active() ) {
		return false;
	}
	return $should_output;
}
add_filter( 'spotlezz_schema_output_organization', 'spotlezz_disable_duplicate_schema_with_yoast' );
add_filter( 'spotlezz_schema_output_breadcrumb', 'spotlezz_disable_duplicate_schema_with_yoast' );

/**
 * Yoast genereert zijn eigen BreadcrumbList-schema uit yoast_breadcrumb().
 * Onze zichtbare breadcrumb (inc/breadcrumbs.php) blijft in beide gevallen
 * gewoon renderen — dat is HTML/UX, geen schema, en wireframe-verplicht op
 * elke pagina behalve de homepage. Als Yoast actief is, laten we Yoast's
 * eigen kruimelpad-instellingen (indien de klant die ooit inschakelt) met
 * rust; deze theme dwingt dat niet af.
 */

/**
 * Zorgt dat WordPress' title-tag-ondersteuning (add_theme_support in
 * inc/setup.php) nooit botst met Yoast: als Yoast actief is neemt het de
 * <title>-output automatisch over via dezelfde 'wp_title'-laag, dus er is
 * hier geen extra filter nodig — dit blok documenteert alleen waarom
 * functions.php geen eigen <title>-implementatie bevat.
 */
