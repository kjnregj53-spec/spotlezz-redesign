<?php
/**
 * Locatiepagina ACF-veldgroep — WORDPRESS-BUILD-PLAN.md §3.4 /
 * PHASE-4C-PLAN.md §2.3, wireframe-4-locatiepagina-FINAL.html.
 *
 * ACF Free, zelfde regels als pillar/case:
 *  - geen repeater (klantlogo's → 6 losse genummerde slots), geen gallery
 *  - relationship voor herbruikbare content (lokale case, top-3 diensten,
 *    lokale FAQ's)
 *
 * De veldnamen hier (`logo_1`..`logo_6`, `lokale_case`,
 * `lokale_review_quote`, `lokaal_team_naam`) zijn de EXACTE namen die
 * inc/publish-gate.php al aanneemt (fase-4C-stap-1, vóór dit bestand
 * gebouwd en al geverifieerd tegen live testposts) — de bewijs-gate telt
 * hierop, dus een naamswijziging hier zou de gate stil breken.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function spotlezz_register_acf_locatie_fields() {
	acf_add_local_field_group(
		array(
			'key'      => 'group_spotlezz_locatie',
			'title'    => __( 'Locatiepagina', 'spotlezz' ),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'locatie',
					),
				),
			),
			'fields'   => array(

				// ---------- Hero + kaart + NAP (wireframe rij 2-3) ----------
				array( 'key' => 'field_spotlezz_lc_hero_tab', 'label' => __( 'Hero', 'spotlezz' ), 'type' => 'tab' ),
				array(
					'key'           => 'field_spotlezz_lc_kaart',
					'label'         => __( 'Kaart (werkgebied en klanten)', 'spotlezz' ),
					'name'          => 'kaart_afbeelding',
					'type'          => 'image',
					'return_format' => 'array',
					'instructions'  => __( 'Statische afbeelding, geen embed — voorkomt een externe iframe/cookie-afhankelijkheid.', 'spotlezz' ),
				),
				array( 'key' => 'field_spotlezz_lc_stat_react', 'label' => __( 'Reactietijd', 'spotlezz' ), 'name' => 'stat_reactietijd_value', 'type' => 'text', 'default_value' => '< 12 uur' ),
				array( 'key' => 'field_spotlezz_lc_stat_teams', 'label' => __( 'Aantal teams in de regio', 'spotlezz' ), 'name' => 'stat_teams_value', 'type' => 'text', 'placeholder' => '4 teams' ),

				// ---------- Lokaal bewijs (rij 4) — "dit blok maakt of breekt de pagina" ----------
				array( 'key' => 'field_spotlezz_lc_bewijs_tab', 'label' => __( 'Lokaal bewijs', 'spotlezz' ), 'type' => 'tab' ),
				array(
					'key'          => 'field_spotlezz_lc_bewijs_note',
					'label'        => '',
					'name'         => '',
					'type'         => 'message',
					'message'      => __( 'Minimaal 3 van de 4 bewijsvormen (6 klantlogo\'s, lokale case, lokale review, lokaal team) zijn vereist voordat deze pagina indexeerbaar wordt — zie inc/publish-gate.php. Zonder voldoende bewijs blijft de pagina automatisch op noindex.', 'spotlezz' ),
				),
				array( 'key' => 'field_spotlezz_lc_logo1', 'label' => __( 'Klantlogo 1', 'spotlezz' ), 'name' => 'logo_1', 'type' => 'image', 'return_format' => 'array' ),
				array( 'key' => 'field_spotlezz_lc_logo2', 'label' => __( 'Klantlogo 2', 'spotlezz' ), 'name' => 'logo_2', 'type' => 'image', 'return_format' => 'array' ),
				array( 'key' => 'field_spotlezz_lc_logo3', 'label' => __( 'Klantlogo 3', 'spotlezz' ), 'name' => 'logo_3', 'type' => 'image', 'return_format' => 'array' ),
				array( 'key' => 'field_spotlezz_lc_logo4', 'label' => __( 'Klantlogo 4', 'spotlezz' ), 'name' => 'logo_4', 'type' => 'image', 'return_format' => 'array' ),
				array( 'key' => 'field_spotlezz_lc_logo5', 'label' => __( 'Klantlogo 5', 'spotlezz' ), 'name' => 'logo_5', 'type' => 'image', 'return_format' => 'array' ),
				array( 'key' => 'field_spotlezz_lc_logo6', 'label' => __( 'Klantlogo 6', 'spotlezz' ), 'name' => 'logo_6', 'type' => 'image', 'return_format' => 'array' ),
				array(
					'key'           => 'field_spotlezz_lc_lokale_case',
					'label'         => __( 'Lokale klantcase', 'spotlezz' ),
					'name'          => 'lokale_case',
					'type'          => 'relationship',
					'post_type'     => array( 'case' ),
					'filters'       => array( 'search' ),
					'max'           => 1,
					'return_format' => 'object',
				),
				array(
					'key'          => 'field_spotlezz_lc_review_quote',
					'label'        => __( 'Lokale review — quote', 'spotlezz' ),
					'name'         => 'lokale_review_quote',
					'type'         => 'textarea',
					'rows'         => 3,
					'instructions' => __( 'Een echte review specifiek voor deze plaats — geen kopie van een andere locatiepagina met alleen de plaatsnaam aangepast (audit-bevinding Amersfoort).', 'spotlezz' ),
				),
				array( 'key' => 'field_spotlezz_lc_review_naam', 'label' => __( 'Lokale review — naam', 'spotlezz' ), 'name' => 'lokale_review_naam', 'type' => 'text' ),
				array( 'key' => 'field_spotlezz_lc_review_rol', 'label' => __( 'Lokale review — rol/bedrijf', 'spotlezz' ), 'name' => 'lokale_review_rol', 'type' => 'text' ),
				array( 'key' => 'field_spotlezz_lc_review_linkedin', 'label' => __( 'Lokale review — LinkedIn-URL (leeg = geen link)', 'spotlezz' ), 'name' => 'lokale_review_linkedin', 'type' => 'url' ),
				array(
					'key'           => 'field_spotlezz_lc_review_foto',
					'label'         => __( 'Lokale review — foto', 'spotlezz' ),
					'name'          => 'lokale_review_foto',
					'type'          => 'image',
					'return_format' => 'array',
				),
				array(
					'key'          => 'field_spotlezz_lc_team_naam',
					'label'        => __( 'Lokaal team — naam', 'spotlezz' ),
					'name'         => 'lokaal_team_naam',
					'type'         => 'text',
					'instructions' => __( 'Leeg laten tot bevestigd — een leeg naamveld toont bewust geen kaart en geen Person-schema (regel 9). Telt ook mee als bewijsvorm voor de noindex-gate.', 'spotlezz' ),
				),
				array( 'key' => 'field_spotlezz_lc_team_rol', 'label' => __( 'Lokaal team — rol', 'spotlezz' ), 'name' => 'lokaal_team_rol', 'type' => 'text' ),
				array( 'key' => 'field_spotlezz_lc_team_quote', 'label' => __( 'Lokaal team — quote', 'spotlezz' ), 'name' => 'lokaal_team_quote', 'type' => 'textarea', 'rows' => 2 ),
				array(
					'key'           => 'field_spotlezz_lc_team_foto',
					'label'         => __( 'Lokaal team — foto', 'spotlezz' ),
					'name'          => 'lokaal_team_foto',
					'type'          => 'image',
					'return_format' => 'array',
				),
				array( 'key' => 'field_spotlezz_lc_team_linkedin', 'label' => __( 'Lokaal team — LinkedIn-URL (leeg = geen link)', 'spotlezz' ), 'name' => 'lokaal_team_linkedin', 'type' => 'url' ),

				// ---------- Diensten top-3 (rij 5) — RELATIONSHIP, exact 3 ----------
				array( 'key' => 'field_spotlezz_lc_diensten_tab', 'label' => __( 'Diensten', 'spotlezz' ), 'type' => 'tab' ),
				array(
					'key'           => 'field_spotlezz_lc_diensten_top3',
					'label'         => __( 'Top 3 diensten in deze plaats', 'spotlezz' ),
					'name'          => 'diensten_top3',
					'type'          => 'relationship',
					'post_type'     => array( 'pillar' ),
					'filters'       => array( 'search' ),
					'min'           => 3,
					'max'           => 3,
					'return_format' => 'object',
					'instructions'  => __( 'Top 3, niet alle diensten — regel uit het wireframe.', 'spotlezz' ),
				),

				// ---------- Werkgebied (rij 6) ----------
				array( 'key' => 'field_spotlezz_lc_werkgebied_tab', 'label' => __( 'Werkgebied', 'spotlezz' ), 'type' => 'tab' ),
				array(
					'key'          => 'field_spotlezz_lc_werkgebied_tekst',
					'label'        => __( 'Werkgebiedtekst', 'spotlezz' ),
					'name'         => 'werkgebied_tekst',
					'type'         => 'wysiwyg',
					'media_upload' => 0,
					'instructions' => __( 'Unieke tekst per plaats: bedrijventerreinen, wijken, reistijd, avondroosters. Richtlijn 500+ woorden — geen generieke tekst die op elke locatiepagina hetzelfde is.', 'spotlezz' ),
				),

				// ---------- Eigen fotografie (rij 7) ----------
				array( 'key' => 'field_spotlezz_lc_photo_tab', 'label' => __( 'Eigen fotografie', 'spotlezz' ), 'type' => 'tab' ),
				array( 'key' => 'field_spotlezz_lc_photo1', 'label' => __( 'Foto 1 (team in deze stad)', 'spotlezz' ), 'name' => 'photo_1', 'type' => 'image', 'return_format' => 'array' ),
				array( 'key' => 'field_spotlezz_lc_photo1_c', 'label' => __( 'Foto 1 — bijschrift', 'spotlezz' ), 'name' => 'photo_1_caption', 'type' => 'text' ),
				array( 'key' => 'field_spotlezz_lc_photo2', 'label' => __( 'Foto 2 (herkenbaar pand of bedrijventerrein)', 'spotlezz' ), 'name' => 'photo_2', 'type' => 'image', 'return_format' => 'array' ),
				array( 'key' => 'field_spotlezz_lc_photo2_c', 'label' => __( 'Foto 2 — bijschrift', 'spotlezz' ), 'name' => 'photo_2_caption', 'type' => 'text' ),
				array( 'key' => 'field_spotlezz_lc_photo3', 'label' => __( 'Foto 3 (klant in deze stad)', 'spotlezz' ), 'name' => 'photo_3', 'type' => 'image', 'return_format' => 'array' ),
				array( 'key' => 'field_spotlezz_lc_photo3_c', 'label' => __( 'Foto 3 — bijschrift', 'spotlezz' ), 'name' => 'photo_3_caption', 'type' => 'text' ),

				// ---------- Lokale FAQ (rij 9) — RELATIONSHIP, 3-5 ----------
				array( 'key' => 'field_spotlezz_lc_faq_tab', 'label' => __( 'FAQ', 'spotlezz' ), 'type' => 'tab' ),
				array(
					'key'           => 'field_spotlezz_lc_lokale_faqs',
					'label'         => __( 'Drie tot vijf lokale vragen', 'spotlezz' ),
					'name'          => 'lokale_faqs',
					'type'          => 'relationship',
					'post_type'     => array( 'vraag' ),
					'filters'       => array( 'search' ),
					'min'           => 3,
					'max'           => 5,
					'return_format' => 'object',
				),
			),
		)
	);
}
add_action( 'spotlezz_register_acf_field_groups', 'spotlezz_register_acf_locatie_fields' );
