<?php
/**
 * Beveiliging tegen een bevestigde InfinityFree-specifieke bug: hun
 * beveiligingslaag (WAF) vervangt soms een `%`-teken in wp-admin-HTML door
 * een placeholder in de vorm `{32-cijferige-hex-hash}` — puur een
 * weergaveprobleem op het moment van laden, maar als een redacteur daarna
 * op "Bijwerken" klikt, wordt die kapotte weergavewaarde als de ECHTE
 * waarde opgeslagen en overschrijft hij de correcte data permanent (al
 * gebeurd bij `usp_3`, `feit_klachten`, `permalink_structure` en
 * `address_city` — zie project-geschiedenis). Een redacteur zonder
 * technische kennis kan dit onmogelijk zelf herkennen.
 *
 * Deze guard blokkeert elke database-schrijfactie (ACF-postmeta én
 * wp_options) waarvan de nieuwe waarde het kapotte patroon bevat: de oude,
 * echte waarde blijft dan gewoon staan i.p.v. overschreven te worden.
 * Puur een vangnet — lost de onderliggende hostingbug niet op (dat kan
 * alleen InfinityFree zelf, of overstappen naar een andere host), maar
 * voorkomt permanente dataverlies terwijl die bug er nog is.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Detecteert het specifieke corruptiepatroon `{32 hex-tekens}` dat de
 * InfinityFree-WAF achterlaat waar een `%XX` hoorde te staan. Werkt
 * recursief door arrays/objecten heen, zodat ook ACF-subvelden en
 * geserialiseerde waarden gedekt zijn.
 *
 * @param mixed $value Te controleren waarde.
 * @return bool True als het corruptiepatroon ergens in $value voorkomt.
 */
function spotlezz_value_is_corrupted( $value ) {
	if ( is_string( $value ) ) {
		return (bool) preg_match( '/\{[0-9a-f]{16,}\}/i', $value );
	}
	if ( is_array( $value ) || is_object( $value ) ) {
		foreach ( (array) $value as $item ) {
			if ( spotlezz_value_is_corrupted( $item ) ) {
				return true;
			}
		}
	}
	return false;
}

/**
 * Logt één keer per request-cyclus een duidelijke waarschuwing in het
 * PHP-errorlog zodat een ontwikkelaar het kan terugvinden, zonder de
 * redacteur zelf iets te tonen (die kan er toch niets mee).
 */
function spotlezz_log_blocked_corruption( $context ) {
	error_log( '[Spotlezz data-integrity-guard] Geblokkeerde schrijfactie met corrupt %-patroon: ' . $context );
}

/**
 * ACF-postmeta-guard: dekt elk ACF-veld op elk paginatype (pillar, case,
 * locatie, vraag, homepage, losstaande pagina's). Draait vóór ACF de
 * waarde daadwerkelijk opslaat.
 */
add_filter(
	'acf/update_value',
	function ( $value, $post_id, $field ) {
		if ( spotlezz_value_is_corrupted( $value ) ) {
			spotlezz_log_blocked_corruption( 'ACF-veld "' . ( $field['name'] ?? '?' ) . '" op post ' . $post_id );
			// Bestaande, echte waarde behouden i.p.v. de kapotte versie op te slaan.
			return get_field( $field['name'], $post_id );
		}
		return $value;
	},
	5,
	3
);

/**
 * wp_options-guard: dekt zowel de Site Options-pagina (spotlezz_*-
 * opties) als WordPress-kernopties zoals permalink_structure die via een
 * ander scherm bewerkt worden. Draait vóór elke option-update, ongeacht
 * de bron.
 */
add_filter(
	'pre_update_option',
	function ( $value, $option, $old_value ) {
		if ( spotlezz_value_is_corrupted( $value ) ) {
			spotlezz_log_blocked_corruption( 'wp_options "' . $option . '"' );
			return $old_value;
		}
		return $value;
	},
	5,
	3
);
