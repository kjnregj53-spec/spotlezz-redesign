<?php
/**
 * Style- en scriptregistratie.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Front-end assets. filemtime() als versienummer zodat een browsercache nooit
 * een oude stylesheet vasthoudt na een deploy — geen handmatig ophogen nodig.
 */
function spotlezz_enqueue_assets() {
	$style_path = SPOTLEZZ_THEME_DIR . '/assets/css/theme.css';
	wp_enqueue_style(
		'spotlezz-theme',
		SPOTLEZZ_THEME_URI . '/assets/css/theme.css',
		array(),
		file_exists( $style_path ) ? filemtime( $style_path ) : SPOTLEZZ_THEME_VERSION
	);

	// Google Fonts: Poppins (body) + Montserrat (koppen), zoals de huidige
	// goedgekeurde visuele richting. Preconnect voorkomt de extra DNS-hop.
	wp_enqueue_style(
		'spotlezz-fonts',
		'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Montserrat:wght@400;600;700&display=swap',
		array(),
		null
	);

	$script_path = SPOTLEZZ_THEME_DIR . '/assets/js/theme.js';
	wp_enqueue_script(
		'spotlezz-theme',
		SPOTLEZZ_THEME_URI . '/assets/js/theme.js',
		array(),
		file_exists( $script_path ) ? filemtime( $script_path ) : SPOTLEZZ_THEME_VERSION,
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);

	// Contactformulieren (offerte/checklist/contact) hebben een submit-endpoint
	// nodig. Dat endpoint komt straks uit Site Options (zie inc/site-options.php),
	// niet uit een hardcoded JS-variabele — hier alleen de brug naar JS.
	wp_localize_script(
		'spotlezz-theme',
		'spotlezzSettings',
		array(
			'formEndpoint' => spotlezz_get_option( 'form_endpoint', '' ),
			'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'spotlezz_enqueue_assets' );

/**
 * Preconnect-hints voor de fontsbron, zelfde als de huidige static build.
 */
function spotlezz_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.googleapis.com',
		);
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => true,
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'spotlezz_resource_hints', 10, 2 );

/**
 * Admin-styling voor de ACF Options-pagina (fase 4A: alleen Site Options,
 * zie inc/site-options.php). Licht, geen framework nodig voor één pagina.
 */
function spotlezz_enqueue_admin_assets( $hook ) {
	if ( 'toplevel_page_spotlezz-site-options' !== $hook ) {
		return;
	}
	wp_enqueue_style(
		'spotlezz-admin',
		SPOTLEZZ_THEME_URI . '/assets/css/admin.css',
		array(),
		SPOTLEZZ_THEME_VERSION
	);
}
add_action( 'admin_enqueue_scripts', 'spotlezz_enqueue_admin_assets' );
