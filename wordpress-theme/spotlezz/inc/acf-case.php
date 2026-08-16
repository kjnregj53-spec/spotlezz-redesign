<?php
/**
 * Klantcase ACF-veldgroep — WORDPRESS-BUILD-PLAN.md §3.3 / PHASE-4C-PLAN.md
 * §2.2, wireframe-2-klantcase-FINAL.html.
 *
 * ACF Free, zelfde regels als pillar/homepage:
 *  - geen repeater, geen gallery
 *  - relationship voor de gebruikte diensten (regel: elke tegel linkt naar
 *    zijn EIGEN pillar-URL, nooit naar de hub — repareert de Kobelco-bug
 *    uit de audit waar 2 van de 3 diensten naar /diensten/ wezen)
 *  - `logo` is verplicht (regel 11 — voorkomt de "LOGO Kobelco"-placeholder)
 *  - `headline` is het ENE brondata-veld voor zowel de zichtbare H1 als
 *    Article.headline (regel 10) — repareert de bug waar H1 "Schoonmaak
 *    voor Kobelco" zei en de schema-headline een andere, betere
 *    resultaatzin bevatte.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function spotlezz_register_acf_case_fields() {
	acf_add_local_field_group(
		array(
			'key'      => 'group_spotlezz_case',
			'title'    => __( 'Klantcase', 'spotlezz' ),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'case',
					),
				),
			),
			'fields'   => array(

				// ---------- Hero (wireframe rij 2) ----------
				array( 'key' => 'field_spotlezz_cs_hero_tab', 'label' => __( 'Hero', 'spotlezz' ), 'type' => 'tab' ),
				array(
					'key'           => 'field_spotlezz_cs_logo',
					'label'         => __( 'Klantlogo', 'spotlezz' ),
					'name'          => 'logo',
					'type'          => 'image',
					'return_format' => 'array',
					'required'      => 1,
					'instructions'  => __( 'Verplicht — voorkomt een lege of placeholder-logo-tegel (regel 11).', 'spotlezz' ),
				),
				array(
					'key'          => 'field_spotlezz_cs_headline',
					'label'        => __( 'Headline (resultaatzin)', 'spotlezz' ),
					'name'         => 'headline',
					'type'         => 'text',
					'required'     => 1,
					'instructions' => __( 'Dit is zowel de zichtbare H1 als de Article.headline in de schema — bv. "Nul klachten in achttien maanden bij [klant] in [plaats]". Geen generieke titel als "Schoonmaak voor [klant]".', 'spotlezz' ),
				),
				array( 'key' => 'field_spotlezz_cs_branche', 'label' => __( 'Branche', 'spotlezz' ), 'name' => 'branche', 'type' => 'text' ),
				array( 'key' => 'field_spotlezz_cs_locatie', 'label' => __( 'Locatie', 'spotlezz' ), 'name' => 'locatie', 'type' => 'text' ),
				array( 'key' => 'field_spotlezz_cs_klant_sinds', 'label' => __( 'Klant sinds', 'spotlezz' ), 'name' => 'klant_sinds', 'type' => 'text' ),
				array(
					'key'           => 'field_spotlezz_cs_hero_foto',
					'label'         => __( 'Herofoto (op locatie, team in actie)', 'spotlezz' ),
					'name'          => 'hero_foto',
					'type'          => 'image',
					'return_format' => 'array',
				),

				// ---------- Feitenbalk (rij 3) ----------
				array( 'key' => 'field_spotlezz_cs_feiten_tab', 'label' => __( 'Feitenbalk', 'spotlezz' ), 'type' => 'tab' ),
				array(
					'key'          => 'field_spotlezz_cs_feiten_note',
					'label'        => '',
					'name'         => '',
					'type'         => 'message',
					'message'      => __( 'De 4 harde cijfers — verplicht vóór publicatie, dit is het meetbare bewijs waar de hele case op leunt.', 'spotlezz' ),
				),
				array( 'key' => 'field_spotlezz_cs_feit_vloer', 'label' => __( 'Vloeroppervlak', 'spotlezz' ), 'name' => 'feit_vloeroppervlak', 'type' => 'text', 'required' => 1, 'placeholder' => '4.500 m²' ),
				array( 'key' => 'field_spotlezz_cs_feit_freq', 'label' => __( 'Frequentie', 'spotlezz' ), 'name' => 'feit_frequentie', 'type' => 'text', 'required' => 1, 'placeholder' => '5x per week' ),
				array( 'key' => 'field_spotlezz_cs_feit_prod', 'label' => __( 'Producten', 'spotlezz' ), 'name' => 'feit_producten', 'type' => 'text', 'required' => 1, 'placeholder' => '100% eco' ),
				array( 'key' => 'field_spotlezz_cs_feit_klachten', 'label' => __( 'Klachten', 'spotlezz' ), 'name' => 'feit_klachten', 'type' => 'text', 'required' => 1, 'placeholder' => '0 klachten in 18 maanden' ),

				// ---------- STAR-structuur (rij 4) ----------
				array( 'key' => 'field_spotlezz_cs_star_tab', 'label' => __( 'STAR-structuur', 'spotlezz' ), 'type' => 'tab' ),
				array( 'key' => 'field_spotlezz_cs_star_situatie', 'label' => __( 'De situatie', 'spotlezz' ), 'name' => 'star_situatie', 'type' => 'textarea', 'rows' => 3 ),
				array( 'key' => 'field_spotlezz_cs_star_uitdaging', 'label' => __( 'De uitdaging', 'spotlezz' ), 'name' => 'star_uitdaging', 'type' => 'textarea', 'rows' => 3 ),
				array( 'key' => 'field_spotlezz_cs_star_aanpak', 'label' => __( 'Onze aanpak', 'spotlezz' ), 'name' => 'star_aanpak', 'type' => 'textarea', 'rows' => 3 ),
				array( 'key' => 'field_spotlezz_cs_star_resultaat', 'label' => __( 'Het resultaat', 'spotlezz' ), 'name' => 'star_resultaat', 'type' => 'textarea', 'rows' => 3 ),

				// ---------- Klantquote (rij 5) ----------
				array( 'key' => 'field_spotlezz_cs_quote_tab', 'label' => __( 'Klantquote', 'spotlezz' ), 'type' => 'tab' ),
				array( 'key' => 'field_spotlezz_cs_quote_tekst', 'label' => __( 'Quote', 'spotlezz' ), 'name' => 'quote_tekst', 'type' => 'textarea', 'rows' => 3 ),
				array( 'key' => 'field_spotlezz_cs_quote_naam', 'label' => __( 'Naam contactpersoon', 'spotlezz' ), 'name' => 'quote_naam', 'type' => 'text' ),
				array( 'key' => 'field_spotlezz_cs_quote_functie', 'label' => __( 'Functie', 'spotlezz' ), 'name' => 'quote_functie', 'type' => 'text' ),
				array(
					'key'           => 'field_spotlezz_cs_quote_foto',
					'label'         => __( 'Portretfoto', 'spotlezz' ),
					'name'          => 'quote_foto',
					'type'          => 'image',
					'return_format' => 'array',
					'instructions'  => __( 'Alleen invullen met een door de klant bevestigd portret.', 'spotlezz' ),
				),
				array(
					'key'          => 'field_spotlezz_cs_quote_linkedin',
					'label'        => __( 'LinkedIn-profiel contactpersoon (echte URL)', 'spotlezz' ),
					'name'         => 'quote_linkedin',
					'type'         => 'url',
					'instructions' => __( 'Leeg = geen link en geen sameAs in de schema. Nooit een generieke of onbevestigde LinkedIn-URL.', 'spotlezz' ),
				),

				// ---------- Gebruikte diensten (rij 6) — RELATIONSHIP, 1-3 ----------
				array( 'key' => 'field_spotlezz_cs_diensten_tab', 'label' => __( 'Gebruikte diensten', 'spotlezz' ), 'type' => 'tab' ),
				array(
					'key'           => 'field_spotlezz_cs_gebruikte_diensten',
					'label'         => __( 'Een tot drie diensten', 'spotlezz' ),
					'name'          => 'gebruikte_diensten',
					'type'          => 'relationship',
					'post_type'     => array( 'pillar' ),
					'filters'       => array( 'search' ),
					'min'           => 1,
					'max'           => 3,
					'return_format' => 'object',
					'instructions'  => __( 'Elke tegel linkt straks naar de eigen pillar-URL van de geselecteerde dienst, nooit naar de dienstenhub — repareert de audit-bug waar 2 van de 3 diensten op de Kobelco-case naar /diensten/ wezen.', 'spotlezz' ),
				),
			),
		)
	);
}
add_action( 'spotlezz_register_acf_field_groups', 'spotlezz_register_acf_case_fields' );
