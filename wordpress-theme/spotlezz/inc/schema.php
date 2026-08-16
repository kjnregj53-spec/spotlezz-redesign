<?php
/**
 * JSON-LD schema-architectuur.
 *
 * Elke wireframe eindigt met een vaste "Schema en regels"-sectie
 * (Organization, LocalBusiness/CleaningService, Person, BreadcrumbList,
 * FAQPage, Review, AggregateRating, Article). Fase 4A bouwt de
 * architectuur waarmee die nodes worden samengesteld en uitgevoerd; de
 * paginatype-specifieke nodes (Service, Article, FAQPage, Review) worden
 * per template toegevoegd zodra die templates in 4B/4C gevuld worden.
 *
 * Harde regels uit fase 3 die hier bewust worden afgedwongen:
 *  - regel 9: een Person-node bestaat alleen als er een zichtbare,
 *    genoemde persoon bij hoort (geen naam = geen schema-node).
 *  - regel 10: H1 en schema-headline delen hetzelfde brondata-veld waar
 *    dat is afgesproken (case-pagina's, fase 4B).
 *  - regel 15: geen rauwe mojibake-tekens — alle schema-tekst gaat door
 *    wp_strip_all_tags()/sanitatie voordat hij in JSON terechtkomt.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Verzamelt alle schema-nodes voor de huidige request in één @graph en
 * print ze als precies één <script type="application/ld+json">-blok.
 * Andere code voegt nodes toe via het filter 'spotlezz_schema_graph'.
 *
 * BUGFIX (gevonden tijdens de fase-4C-pillar-QA, gold ook al voor de
 * bevroren fase-4B-homepage): deze functie hing aan 'wp_head', dat in
 * <head> vuurt — dus vóórdat de hoofdinhoud van welk template dan ook
 * geladen is. Elke `add_filter('spotlezz_schema_graph', ...)`-aanroep
 * diep in een template-loop (FAQ-schema, Review-schema, Service-schema)
 * kwam daardoor altijd te laat: de `apply_filters()` hieronder had het
 * @graph allang samengesteld en uitgevoerd voordat die filters ooit
 * geregistreerd werden. Resultaat: FAQPage/Review/Service-nodes stonden
 * nooit echt in de output, op geen enkele pagina, ook niet op de
 * goedgekeurde homepage — alleen de Organization/WebSite/Breadcrumb-nodes
 * (die niets uit de loop nodig hebben) werkten wel.
 *
 * Fix: uitvoeren op 'wp_footer' i.p.v. 'wp_head'. JSON-LD is voor Google
 * net zo geldig ergens vóór `</body>` als in `<head>` — er verandert niets
 * aan zichtbare HTML, CSS of veldstructuur, alleen het moment waarop dit
 * ene `<script>`-blok wordt geprint.
 */
function spotlezz_output_schema() {
	$graph = array();

	if ( apply_filters( 'spotlezz_schema_output_organization', true ) ) {
		$graph[] = spotlezz_schema_organization();
		$graph[] = spotlezz_schema_website();
	}

	/**
	 * Let op: er is BEWUST geen generieke "oprichter"-Person-node meer op
	 * dit niveau. Fase 4A had hier ooit een fallback op een nooit-
	 * geregistreerde Site Option ('founder_name'), die altijd leeg was en
	 * dus nooit vuurde — maar bij hergebruik van dezelfde @id
	 * (home_url('/#founder')) had dat kunnen botsen met de homepage-
	 * oprichterskaart uit front-page.php (spotlezz_person_card(),
	 * WORDPRESS-BUILD-PLAN §3.1), die dezelfde @id gebruikt met de echte
	 * ACF-data. Eén bron van waarheid: de homepage-veldgroep. Zodra een
	 * ander paginatype ook een oprichter/medewerker toont, gebruikt die
	 * gewoon spotlezz_person_card() met een eigen id_suffix, nooit 'founder'.
	 */

	if ( apply_filters( 'spotlezz_schema_output_breadcrumb', true ) ) {
		$breadcrumb = spotlezz_schema_breadcrumb( spotlezz_get_breadcrumb_trail() );
		if ( $breadcrumb ) {
			$graph[] = $breadcrumb;
		}
	}

	/**
	 * Paginatype-specifieke templates (single-pillar.php, single-case.php, ...)
	 * hangen hier in fase 4B/4C hun eigen nodes aan: Service, Article, Review,
	 * FAQPage, AggregateRating, Person (medewerker/team).
	 */
	$graph = apply_filters( 'spotlezz_schema_graph', $graph );

	if ( empty( $graph ) ) {
		return;
	}

	$document = array(
		'@context' => 'https://schema.org',
		'@graph'   => array_values( array_filter( $graph ) ),
	);

	echo '<script type="application/ld+json">' .
		wp_json_encode( $document, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) .
		'</script>' . "\n";
}
add_action( 'wp_footer', 'spotlezz_output_schema' );

/**
 * Organization + CleaningService (LocalBusiness), gebouwd uit Site Options
 * zodat NAP-gegevens nooit los van inc/site-options.php bestaan (regel 14).
 */
function spotlezz_schema_organization() {
	$street   = spotlezz_get_option( 'address_street' );
	$postcode = spotlezz_get_option( 'address_postcode' );
	$city     = spotlezz_get_option( 'address_city' );

	$node = array(
		'@type'       => array( 'Organization', 'CleaningService' ),
		'@id'         => home_url( '/#organization' ),
		'name'        => spotlezz_get_option( 'org_name', get_bloginfo( 'name' ) ), // bewuste override: WP-sitetitel als extra fallback, niet alleen de registry-default.
		'legalName'   => spotlezz_get_option( 'org_legal_name' ),
		'url'         => home_url( '/' ),
		'telephone'   => spotlezz_get_option( 'phone_intl' ),
		'email'       => spotlezz_get_option( 'email' ),
		'address'     => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => $street,
			'postalCode'      => $postcode,
			'addressLocality' => $city,
			'addressCountry'  => 'NL',
		),
	);

	$kvk = spotlezz_get_option( 'kvk' );
	if ( '' !== $kvk ) {
		$node['identifier'] = array(
			'@type'      => 'PropertyValue',
			'propertyID' => 'KVK',
			'value'      => $kvk,
		);
	}

	$maps_url = spotlezz_get_option( 'google_maps_url' );
	if ( '' !== $maps_url ) {
		$node['sameAs'] = array( $maps_url );
	}

	$review_count = spotlezz_get_option( 'review_count' );
	$review_score = spotlezz_get_option( 'review_score_raw' );
	if ( '' !== $review_count && '' !== $review_score ) {
		$node['aggregateRating'] = array(
			'@type'       => 'AggregateRating',
			'ratingValue' => $review_score,
			'reviewCount' => $review_count,
			'bestRating'  => '5',
			'worstRating' => '1',
		);
	}

	return $node;
}

/**
 * WebSite-node, nodig voor de sitelinks-searchbox-kandidatuur en om de
 * Organization-node aan iets te koppelen dat niet zelf een pagina is.
 */
function spotlezz_schema_website() {
	return array(
		'@type'      => 'WebSite',
		'@id'        => home_url( '/#website' ),
		'url'        => home_url( '/' ),
		'name'       => spotlezz_get_option( 'org_name', get_bloginfo( 'name' ) ),
		'publisher'  => array( '@id' => home_url( '/#organization' ) ),
		'inLanguage' => 'nl-NL',
	);
}

/**
 * Person-node. Geeft bewust false terug (dus geen node) zolang er geen
 * naam is — regel 9: "Person schema must correspond to a visible, named
 * person." Voorkomt dat een leeg medewerker-placeholderveld straks alsnog
 * een lege of verzonnen Person-node in de schema oplevert.
 *
 * @param array{id_suffix:string,name:string,job_title?:string,linkedin?:string,image_url?:string} $args
 * @return array|false
 */
function spotlezz_schema_person( $args ) {
	$name = isset( $args['name'] ) ? trim( wp_strip_all_tags( $args['name'] ) ) : '';
	if ( '' === $name ) {
		return false;
	}

	$id_suffix = isset( $args['id_suffix'] ) && '' !== $args['id_suffix']
		? sanitize_title( $args['id_suffix'] )
		: sanitize_title( $name );

	$node = array(
		'@type'    => 'Person',
		'@id'      => home_url( '/#' . $id_suffix ),
		'name'     => $name,
		'worksFor' => array( '@id' => home_url( '/#organization' ) ),
	);

	if ( ! empty( $args['job_title'] ) ) {
		$node['jobTitle'] = wp_strip_all_tags( $args['job_title'] );
	}

	// sameAs alleen zetten bij een echte, bevestigde LinkedIn-URL — nooit
	// naar '#' of de generieke linkedin.com-homepage (zie IMAGE-AUDIT §2 en
	// WORDPRESS-BUILD-PLAN §5.2: geen niet-bevestigde identiteit tonen).
	if ( ! empty( $args['linkedin'] ) && filter_var( $args['linkedin'], FILTER_VALIDATE_URL ) ) {
		$host = wp_parse_url( $args['linkedin'], PHP_URL_HOST );
		if ( $host && false !== strpos( $host, 'linkedin.com' ) && '/' !== rtrim( wp_parse_url( $args['linkedin'], PHP_URL_PATH ) ?? '/', '' ) ) {
			$node['sameAs'] = array( esc_url_raw( $args['linkedin'] ) );
		}
	}

	if ( ! empty( $args['image_url'] ) ) {
		$node['image'] = esc_url_raw( $args['image_url'] );
	}

	return $node;
}

/**
 * BreadcrumbList-node vanuit een kruimelpad-array (zie inc/breadcrumbs.php).
 *
 * @param array<int,array{name:string,url:string}> $trail
 * @return array|false
 */
function spotlezz_schema_breadcrumb( $trail ) {
	if ( empty( $trail ) ) {
		return false;
	}

	$items = array();
	foreach ( $trail as $position => $crumb ) {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $position + 1,
			'name'     => wp_strip_all_tags( $crumb['name'] ),
			'item'     => esc_url_raw( $crumb['url'] ),
		);
	}

	return array(
		'@type'           => 'BreadcrumbList',
		'itemListElement' => $items,
	);
}
