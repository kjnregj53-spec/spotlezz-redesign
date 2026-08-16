<?php
/**
 * Pillar (dienst-detail) ACF-veldgroep — WORDPRESS-BUILD-PLAN.md §3.2 /
 * PHASE-4C-PLAN.md §2.1, wireframe-1-dienst-detail-FINAL.html.
 *
 * Geldt voor beide assen: de zes branche-pillars én de vier dienst-
 * pillars — zelfde CPT `pillar`, zelfde veldgroep, het onderscheid zit in
 * de `branche`-taxonomie (zie front-page.php's tweeassen-query).
 *
 * ACF Free, zelfde regels als de homepage-veldgroep:
 *  - geen repeater (werkzaamheden-raster → 8 losse genummerde slots)
 *  - geen gallery
 *  - relationship voor herbruikbare content (cases, FAQ's, verwante pillar
 *    per werkzaamheid)
 *  - reviews en de werkwijze/vergelijkingstabel komen NIET hier vandaan —
 *    die zijn sinds fase 4C gedeeld via Site Options
 *    (spotlezz_reviews_block(), spotlezz_werkwijze_vergelijking_block()).
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function spotlezz_register_acf_pillar_fields() {
	acf_add_local_field_group(
		array(
			'key'      => 'group_spotlezz_pillar',
			'title'    => __( 'Dienst-pillar', 'spotlezz' ),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'pillar',
					),
				),
			),
			'fields'   => array(

				// ---------- Hero + snelofferte (wireframe rij 2) ----------
				array( 'key' => 'field_spotlezz_pl_hero_tab', 'label' => __( 'Hero', 'spotlezz' ), 'type' => 'tab' ),
				array(
					'key'          => 'field_spotlezz_pl_hero_kicker',
					'label'        => __( 'Kicker', 'spotlezz' ),
					'name'         => 'hero_kicker',
					'type'         => 'text',
				),
				array(
					'key'          => 'field_spotlezz_pl_hero_h1',
					'label'        => __( 'H1', 'spotlezz' ),
					'name'         => 'hero_h1',
					'type'         => 'text',
					'instructions' => __( 'Bevat het zoekwoord + regio, bv. "Kantoorschoonmaak in Almere".', 'spotlezz' ),
					'required'     => 1,
				),
				array(
					'key'   => 'field_spotlezz_pl_hero_intro',
					'label' => __( 'Introzin', 'spotlezz' ),
					'name'  => 'hero_intro',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array( 'key' => 'field_spotlezz_pl_usp1', 'label' => __( 'USP-pill 1', 'spotlezz' ), 'name' => 'usp_1', 'type' => 'text' ),
				array( 'key' => 'field_spotlezz_pl_usp2', 'label' => __( 'USP-pill 2', 'spotlezz' ), 'name' => 'usp_2', 'type' => 'text' ),
				array( 'key' => 'field_spotlezz_pl_usp3', 'label' => __( 'USP-pill 3', 'spotlezz' ), 'name' => 'usp_3', 'type' => 'text' ),

				// ---------- Antwoordblok (rij 3) ----------
				array( 'key' => 'field_spotlezz_pl_answer_tab', 'label' => __( 'Antwoordblok', 'spotlezz' ), 'type' => 'tab' ),
				array(
					'key'          => 'field_spotlezz_pl_answer_intro',
					'label'        => __( 'Antwoordtekst (40-60 woorden)', 'spotlezz' ),
					'name'         => 'answer_intro',
					'type'         => 'textarea',
					'rows'         => 3,
					'instructions' => __( 'Prijs-tegel is een vaste link naar de prijsfactoren-FAQ (geen veld). Regio komt uit Site Options.', 'spotlezz' ),
				),
				array( 'key' => 'field_spotlezz_pl_stat_freq_v', 'label' => __( 'Frequentie — waarde', 'spotlezz' ), 'name' => 'stat_frequentie_value', 'type' => 'text' ),
				array( 'key' => 'field_spotlezz_pl_stat_freq_l', 'label' => __( 'Frequentie — label', 'spotlezz' ), 'name' => 'stat_frequentie_label', 'type' => 'text', 'default_value' => 'Frequentie' ),
				array( 'key' => 'field_spotlezz_pl_stat_react_v', 'label' => __( 'Reactietijd — waarde', 'spotlezz' ), 'name' => 'stat_reactietijd_value', 'type' => 'text', 'default_value' => '< 12 uur' ),
				array( 'key' => 'field_spotlezz_pl_stat_react_l', 'label' => __( 'Reactietijd — label', 'spotlezz' ), 'name' => 'stat_reactietijd_label', 'type' => 'text', 'default_value' => 'Reactietijd' ),

				// ---------- Werkzaamheden-raster (rij 4) — 8 losse slots i.p.v. repeater ----------
				array( 'key' => 'field_spotlezz_pl_tasks_tab', 'label' => __( 'Werkzaamheden', 'spotlezz' ), 'type' => 'tab' ),
				array(
					'key'          => 'field_spotlezz_pl_tasks_note',
					'label'        => __( 'Raster (max. 8)', 'spotlezz' ),
					'name'         => '',
					'type'         => 'message',
					'message'      => __( 'Vul alleen de slots die je nodig hebt; lege slots worden niet getoond. Elk item kan optioneel doorlinken naar een andere pillar.', 'spotlezz' ),
				),
				array( 'key' => 'field_spotlezz_pl_task1_label', 'label' => __( 'Werkzaamheid 1 — label', 'spotlezz' ), 'name' => 'task_1_label', 'type' => 'text' ),
				array( 'key' => 'field_spotlezz_pl_task1_pillar', 'label' => __( 'Werkzaamheid 1 — link naar pillar (optioneel)', 'spotlezz' ), 'name' => 'task_1_pillar', 'type' => 'relationship', 'post_type' => array( 'pillar' ), 'max' => 1 ),
				array( 'key' => 'field_spotlezz_pl_task2_label', 'label' => __( 'Werkzaamheid 2 — label', 'spotlezz' ), 'name' => 'task_2_label', 'type' => 'text' ),
				array( 'key' => 'field_spotlezz_pl_task2_pillar', 'label' => __( 'Werkzaamheid 2 — link naar pillar (optioneel)', 'spotlezz' ), 'name' => 'task_2_pillar', 'type' => 'relationship', 'post_type' => array( 'pillar' ), 'max' => 1 ),
				array( 'key' => 'field_spotlezz_pl_task3_label', 'label' => __( 'Werkzaamheid 3 — label', 'spotlezz' ), 'name' => 'task_3_label', 'type' => 'text' ),
				array( 'key' => 'field_spotlezz_pl_task3_pillar', 'label' => __( 'Werkzaamheid 3 — link naar pillar (optioneel)', 'spotlezz' ), 'name' => 'task_3_pillar', 'type' => 'relationship', 'post_type' => array( 'pillar' ), 'max' => 1 ),
				array( 'key' => 'field_spotlezz_pl_task4_label', 'label' => __( 'Werkzaamheid 4 — label', 'spotlezz' ), 'name' => 'task_4_label', 'type' => 'text' ),
				array( 'key' => 'field_spotlezz_pl_task4_pillar', 'label' => __( 'Werkzaamheid 4 — link naar pillar (optioneel)', 'spotlezz' ), 'name' => 'task_4_pillar', 'type' => 'relationship', 'post_type' => array( 'pillar' ), 'max' => 1 ),
				array( 'key' => 'field_spotlezz_pl_task5_label', 'label' => __( 'Werkzaamheid 5 — label', 'spotlezz' ), 'name' => 'task_5_label', 'type' => 'text' ),
				array( 'key' => 'field_spotlezz_pl_task5_pillar', 'label' => __( 'Werkzaamheid 5 — link naar pillar (optioneel)', 'spotlezz' ), 'name' => 'task_5_pillar', 'type' => 'relationship', 'post_type' => array( 'pillar' ), 'max' => 1 ),
				array( 'key' => 'field_spotlezz_pl_task6_label', 'label' => __( 'Werkzaamheid 6 — label', 'spotlezz' ), 'name' => 'task_6_label', 'type' => 'text' ),
				array( 'key' => 'field_spotlezz_pl_task6_pillar', 'label' => __( 'Werkzaamheid 6 — link naar pillar (optioneel)', 'spotlezz' ), 'name' => 'task_6_pillar', 'type' => 'relationship', 'post_type' => array( 'pillar' ), 'max' => 1 ),
				array( 'key' => 'field_spotlezz_pl_task7_label', 'label' => __( 'Werkzaamheid 7 — label', 'spotlezz' ), 'name' => 'task_7_label', 'type' => 'text' ),
				array( 'key' => 'field_spotlezz_pl_task7_pillar', 'label' => __( 'Werkzaamheid 7 — link naar pillar (optioneel)', 'spotlezz' ), 'name' => 'task_7_pillar', 'type' => 'relationship', 'post_type' => array( 'pillar' ), 'max' => 1 ),
				array( 'key' => 'field_spotlezz_pl_task8_label', 'label' => __( 'Werkzaamheid 8 — label', 'spotlezz' ), 'name' => 'task_8_label', 'type' => 'text' ),
				array( 'key' => 'field_spotlezz_pl_task8_pillar', 'label' => __( 'Werkzaamheid 8 — link naar pillar (optioneel)', 'spotlezz' ), 'name' => 'task_8_pillar', 'type' => 'relationship', 'post_type' => array( 'pillar' ), 'max' => 1 ),

				// ---------- Eigen fotografie (rij 6) ----------
				array( 'key' => 'field_spotlezz_pl_photo_tab', 'label' => __( "Eigen fotografie", 'spotlezz' ), 'type' => 'tab' ),
				array( 'key' => 'field_spotlezz_pl_photo1', 'label' => __( 'Foto 1 (team aan het werk)', 'spotlezz' ), 'name' => 'photo_1', 'type' => 'image', 'return_format' => 'array' ),
				array( 'key' => 'field_spotlezz_pl_photo1_c', 'label' => __( 'Foto 1 — bijschrift', 'spotlezz' ), 'name' => 'photo_1_caption', 'type' => 'text' ),
				array( 'key' => 'field_spotlezz_pl_photo2', 'label' => __( 'Foto 2 (het pand of de ruimte)', 'spotlezz' ), 'name' => 'photo_2', 'type' => 'image', 'return_format' => 'array' ),
				array( 'key' => 'field_spotlezz_pl_photo2_c', 'label' => __( 'Foto 2 — bijschrift', 'spotlezz' ), 'name' => 'photo_2_caption', 'type' => 'text' ),
				array( 'key' => 'field_spotlezz_pl_photo3', 'label' => __( 'Foto 3 (materiaal en producten)', 'spotlezz' ), 'name' => 'photo_3', 'type' => 'image', 'return_format' => 'array' ),
				array( 'key' => 'field_spotlezz_pl_photo3_c', 'label' => __( 'Foto 3 — bijschrift', 'spotlezz' ), 'name' => 'photo_3_caption', 'type' => 'text' ),

				// ---------- Medewerker aan het woord (rij 8) ----------
				array( 'key' => 'field_spotlezz_pl_medewerker_tab', 'label' => __( 'Medewerker aan het woord', 'spotlezz' ), 'type' => 'tab' ),
				array(
					'key'          => 'field_spotlezz_pl_medewerker_naam',
					'label'        => __( 'Naam', 'spotlezz' ),
					'name'         => 'medewerker_naam',
					'type'         => 'text',
					'instructions' => __( 'Leeg laten tot bevestigd — een leeg naamveld toont bewust geen kaart en geen Person-schema (regel 9).', 'spotlezz' ),
				),
				array( 'key' => 'field_spotlezz_pl_medewerker_functie', 'label' => __( 'Functie', 'spotlezz' ), 'name' => 'medewerker_functie', 'type' => 'text' ),
				array( 'key' => 'field_spotlezz_pl_medewerker_quote', 'label' => __( 'Quote', 'spotlezz' ), 'name' => 'medewerker_quote', 'type' => 'textarea', 'rows' => 3 ),
				array(
					'key'          => 'field_spotlezz_pl_medewerker_foto',
					'label'        => __( 'Portretfoto', 'spotlezz' ),
					'name'         => 'medewerker_foto',
					'type'         => 'image',
					'return_format' => 'array',
					'instructions' => __( 'Alleen invullen met een door de klant bevestigd portret. Nooit een andere, niet-bevestigde medewerkersfoto onder deze naam plaatsen.', 'spotlezz' ),
				),
				array( 'key' => 'field_spotlezz_pl_medewerker_linkedin', 'label' => __( 'LinkedIn-URL (leeg = geen link)', 'spotlezz' ), 'name' => 'medewerker_linkedin', 'type' => 'url' ),

				// ---------- Klantcases (rij 9) — RELATIONSHIP, exact 2 ----------
				array( 'key' => 'field_spotlezz_pl_cases_tab', 'label' => __( 'Klantcases', 'spotlezz' ), 'type' => 'tab' ),
				array(
					'key'           => 'field_spotlezz_pl_featured_cases',
					'label'         => __( 'Twee klantcases', 'spotlezz' ),
					'name'          => 'featured_cases',
					'type'          => 'relationship',
					'post_type'     => array( 'case' ),
					'filters'       => array( 'search' ),
					'min'           => 2,
					'max'           => 2,
					'return_format' => 'object',
					'instructions'  => __( 'Selecteer uit bestaande, gepubliceerde klantcases — geen vrije tekst.', 'spotlezz' ),
				),

				// ---------- FAQ (rij 11) — RELATIONSHIP, 5-8 ----------
				array( 'key' => 'field_spotlezz_pl_faq_tab', 'label' => __( 'FAQ', 'spotlezz' ), 'type' => 'tab' ),
				array(
					'key'           => 'field_spotlezz_pl_featured_faqs',
					'label'         => __( 'Vijf tot acht vragen', 'spotlezz' ),
					'name'          => 'featured_faqs',
					'type'          => 'relationship',
					'post_type'     => array( 'vraag' ),
					'filters'       => array( 'search' ),
					'min'           => 5,
					'max'           => 8,
					'return_format' => 'object',
				),
			),
		)
	);
}
add_action( 'spotlezz_register_acf_field_groups', 'spotlezz_register_acf_pillar_fields' );
