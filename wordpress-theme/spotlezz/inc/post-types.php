<?php
/**
 * Custom post types en taxonomieën.
 *
 * Registratie is fase-4A-scope omdat de template hierarchy (single-pillar.php,
 * single-case.php, single-locatie.php, single-vraag.php) niet kan bestaan
 * zonder dat WordPress deze post types kent. De bijbehorende ACF-veldgroepen
 * per type (WORDPRESS-BUILD-PLAN §3.2 t/m §3.5) zijn NIET onderdeel van
 * fase 4A — zie inc/acf-fields.php voor de afbakening.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function spotlezz_register_post_types() {

	register_post_type(
		'pillar',
		array(
			'labels'       => array(
				'name'          => __( 'Diensten (pillars)', 'spotlezz' ),
				'singular_name' => __( 'Dienst-pillar', 'spotlezz' ),
				'add_new_item'  => __( 'Nieuwe dienst-pillar toevoegen', 'spotlezz' ),
			),
			'public'       => true,
			'has_archive'  => 'diensten',
			'rewrite'      => array( 'slug' => 'diensten', 'with_front' => false ),
			'menu_icon'    => 'dashicons-admin-tools',
			'supports'     => array( 'title', 'thumbnail', 'excerpt' ),
			'show_in_rest' => true,
			'hierarchical' => false,
		)
	);

	register_post_type(
		'case',
		array(
			'labels'       => array(
				'name'          => __( 'Klantcases', 'spotlezz' ),
				'singular_name' => __( 'Klantcase', 'spotlezz' ),
				'add_new_item'  => __( 'Nieuwe klantcase toevoegen', 'spotlezz' ),
			),
			'public'       => true,
			'has_archive'  => 'klantcases',
			'rewrite'      => array( 'slug' => 'klantcases', 'with_front' => false ),
			'menu_icon'    => 'dashicons-testimonial',
			'supports'     => array( 'title', 'thumbnail', 'excerpt' ),
			'show_in_rest' => true,
			'hierarchical' => false,
		)
	);

	register_post_type(
		'locatie',
		array(
			'labels'       => array(
				'name'          => __( 'Locaties', 'spotlezz' ),
				'singular_name' => __( 'Locatie', 'spotlezz' ),
				'add_new_item'  => __( 'Nieuwe locatie toevoegen', 'spotlezz' ),
			),
			'public'       => true,
			'has_archive'  => 'locaties',
			'rewrite'      => array( 'slug' => 'locaties', 'with_front' => false ),
			'menu_icon'    => 'dashicons-location',
			'supports'     => array( 'title', 'thumbnail', 'page-attributes' ),
			'show_in_rest' => true,
			// Hiërarchisch zodat wijken (Almere Stad, Buiten, Haven, Poort) een stad
			// als parent kunnen hebben — wireframe-4-FINAL rij 5 "Wijken" en rij 10
			// "Andere locaties" bouwen hierop.
			'hierarchical' => true,
		)
	);

	register_post_type(
		'vraag',
		array(
			'labels'       => array(
				'name'          => __( 'FAQ-vragen', 'spotlezz' ),
				'singular_name' => __( 'Vraag', 'spotlezz' ),
				'add_new_item'  => __( 'Nieuwe vraag toevoegen', 'spotlezz' ),
			),
			'public'       => true,
			'has_archive'  => 'veelgestelde-vragen',
			'rewrite'      => array( 'slug' => 'veelgestelde-vragen', 'with_front' => false ),
			'menu_icon'    => 'dashicons-editor-help',
			// 'excerpt' toegevoegd in fase 4B: de homepage FAQ-sectie (rij 10)
			// toont een korte antwoord-teaser via het native excerpt-veld,
			// zodat de homepage geen vraag-ACF-veldgroep nodig heeft — die
			// hoort bij de FAQ-template die in deze fase bewust niet gebouwd
			// wordt. Ontbreekt het excerpt, dan toont de homepage alleen de
			// vraag zelf, nooit verzonnen tekst.
			'supports'     => array( 'title', 'thumbnail', 'excerpt' ),
			'show_in_rest' => true,
			'hierarchical' => false,
		)
	);
}
add_action( 'init', 'spotlezz_register_post_types' );

function spotlezz_register_taxonomies() {

	// FAQ-thema: Kosten, Werkwijze, Kwaliteit, Duurzaamheid, Contract —
	// wireframe-3-faq-FINAL rij 2 (hub, gegroepeerd per thema).
	register_taxonomy(
		'thema',
		array( 'vraag' ),
		array(
			'labels'       => array(
				'name'          => __( "Thema's", 'spotlezz' ),
				'singular_name' => __( 'Thema', 'spotlezz' ),
			),
			'public'       => true,
			'hierarchical' => true,
			'rewrite'      => array( 'slug' => 'veelgestelde-vragen/thema' ),
			'show_in_rest' => true,
		)
	);

	// Branche: koppelt pillars en cases aan een sector (kantoor, hotel, ...),
	// gebruikt voor "gebruikte diensten" / "diensten in deze stad"-selecties.
	register_taxonomy(
		'branche',
		array( 'pillar', 'case' ),
		array(
			'labels'       => array(
				'name'          => __( "Branches", 'spotlezz' ),
				'singular_name' => __( 'Branche', 'spotlezz' ),
			),
			'public'       => true,
			'hierarchical' => true,
			'rewrite'      => array( 'slug' => 'branche' ),
			'show_in_rest' => true,
		)
	);
}
add_action( 'init', 'spotlezz_register_taxonomies' );
