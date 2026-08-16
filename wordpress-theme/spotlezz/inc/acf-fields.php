<?php
/**
 * Basis ACF-integratie (fase 4A).
 *
 * Dit bestand registreert BEWUST nog geen volledige veldgroepen per
 * paginatype (homepage, pillar, case, locatie, FAQ — WORDPRESS-BUILD-PLAN
 * §3.1 t/m §3.5). Dat is contentstructuur-werk voor fase 4B/4C, nadat de
 * foundation is goedgekeurd. Wat hier wél staat:
 *
 *  - een veilige check of ACF daadwerkelijk actief is;
 *  - een wrapper-functie zodat theme-templates nooit direct get_field()
 *    aanroepen (en dus nooit fataal breken als ACF ontbreekt);
 *  - de plek waar toekomstige acf_add_local_field_group()-registraties
 *    voor pillar/case/locatie/vraag bij komen, zodat de structuur al
 *    vaststaat.
 *
 * ACF wordt hier niet geïnstalleerd en het gedrag wordt niet nagebootst —
 * als het plugin ontbreekt, geven onderstaande functies gewoon de
 * meegegeven default terug.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Is Advanced Custom Fields (Pro) actief?
 */
function spotlezz_acf_active() {
	return function_exists( 'get_field' ) && function_exists( 'acf_add_local_field_group' );
}

/**
 * Veilige ACF-veldlezer. Elke template in dit theme haalt content op via
 * deze functie, nooit rechtstreeks via get_field(). Zo kan fase 4A al
 * volledig gebouwd en getest worden vóórdat ACF geïnstalleerd is: elk veld
 * valt terug op $default in plaats van een PHP-fout te geven.
 *
 * @param string   $selector ACF-veldnaam.
 * @param int|null $post_id  Post-ID, of null voor de huidige post in de loop.
 * @param mixed    $default  Terugvalwaarde als ACF ontbreekt of het veld leeg is.
 * @return mixed
 */
function spotlezz_field( $selector, $post_id = null, $default = '' ) {
	if ( ! spotlezz_acf_active() ) {
		return $default;
	}
	$value = get_field( $selector, $post_id );
	return ( null !== $value && '' !== $value ) ? $value : $default;
}

/**
 * Plek voor toekomstige veldgroep-registraties per paginatype. Leeg in
 * fase 4A — zie WORDPRESS-BUILD-PLAN.md §3 voor de volledige specificatie
 * die hier in fase 4B/4C wordt geïmplementeerd (pillar, case, locatie,
 * vraag, en de homepage/pagina-veldgroepen).
 */
function spotlezz_register_acf_field_groups() {
	if ( ! spotlezz_acf_active() ) {
		return;
	}

	/**
	 * Fase 4B/4C breidt dit uit met, per WORDPRESS-BUILD-PLAN.md:
	 * - group_spotlezz_homepage   (§3.1)
	 * - group_spotlezz_pillar     (§3.2)
	 * - group_spotlezz_case       (§3.3)
	 * - group_spotlezz_locatie    (§3.4, incl. de publicatie-gate uit §5.4)
	 * - group_spotlezz_vraag      (§3.5)
	 *
	 * Bewust nog niet gebouwd: dat is contentmodel-werk dat per paginatype
	 * apart geverifieerd moet worden, zoals in de fase-4A-opdracht is
	 * afgesproken ("werk incrementeel, verifieer elke stage").
	 */
	do_action( 'spotlezz_register_acf_field_groups' );
}
add_action( 'acf/init', 'spotlezz_register_acf_field_groups' );
