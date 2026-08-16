<?php
/**
 * Theme supports, navigation menus, image sizes, content width.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Core theme setup. Hooked on after_setup_theme so translations, image sizes
 * and nav menus are registered before WordPress needs them.
 */
function spotlezz_setup() {
	// Vertaalbaarheid.
	load_theme_textdomain( 'spotlezz', SPOTLEZZ_THEME_DIR . '/languages' );

	// title-tag: laat WordPress (of Yoast, zie inc/seo-yoast.php) de <title> beheren.
	// De theme rendert zelf nooit een eigen <title>-tag.
	add_theme_support( 'title-tag' );

	// Uitgelichte afbeeldingen, nodig voor hero-, case- en locatiefoto's.
	add_theme_support( 'post-thumbnails' );

	// html5-markup voor formulieren, zoeken, captions, galerijen etc.
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);

	// Automatische feed-links laten we uit; deze site heeft geen blog-centrale rol
	// (zie STATUS.md — blog staat bewust buiten de hoofdstructuur).
	remove_theme_support( 'automatic-feed-links' );

	// Custom logo, zodat het merkbeeld (2027.png) via de Customizer/Site Options
	// beheerd kan worden i.p.v. hardcoded in header.php.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 39,
			'width'       => 291,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// Responsive embeds (Google Maps-embed op locatiepagina's, wireframe-4 rij 2).
	add_theme_support( 'responsive-embeds' );

	// Eén hoofdnavigatie, precies zoals in alle vijf de wireframes: vijf hubs
	// plus de offerte-CTA. Geen tweede, los geregistreerd menu nodig.
	register_nav_menus(
		array(
			'primary' => __( 'Hoofdnavigatie', 'spotlezz' ),
			'footer'  => __( 'Footer', 'spotlezz' ),
		)
	);
}
add_action( 'after_setup_theme', 'spotlezz_setup' );

/**
 * Content width, voor oEmbeds en block-editor breedteberekening.
 */
function spotlezz_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'spotlezz_content_width', 1200 );
}
add_action( 'after_setup_theme', 'spotlezz_content_width', 0 );

/**
 * Custom image sizes.
 *
 * Eén set die de drie meest voorkomende beeldrollen dekt uit de wireframes:
 * hero (full-bleed, zie WORDPRESS-BUILD-PLAN §5.1), kaart-teaser (cases/
 * diensten-tegels) en portret (medewerker/oprichter-blokken).
 */
function spotlezz_image_sizes() {
	add_image_size( 'spotlezz-hero', 1920, 1080, true );
	add_image_size( 'spotlezz-card', 800, 520, true );
	add_image_size( 'spotlezz-portrait', 400, 400, true );
}
add_action( 'after_setup_theme', 'spotlezz_image_sizes' );

/**
 * Zet custom image sizes ook in de "Afbeeldingsgrootte"-keuze van de
 * media-library, zodat een redacteur ze desnoods handmatig kan kiezen.
 */
function spotlezz_custom_image_size_names( $sizes ) {
	return array_merge(
		$sizes,
		array(
			'spotlezz-hero'      => __( 'Hero (full-bleed)', 'spotlezz' ),
			'spotlezz-card'      => __( 'Kaart', 'spotlezz' ),
			'spotlezz-portrait'  => __( 'Portret', 'spotlezz' ),
		)
	);
}
add_filter( 'image_size_names_choose', 'spotlezz_custom_image_size_names' );
