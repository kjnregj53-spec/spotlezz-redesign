<?php
/**
 * FAQ-detailpagina ACF-veldgroep — WORDPRESS-BUILD-PLAN.md §3.5 /
 * PHASE-4C-PLAN.md §2.4, wireframe-3-faq-FINAL.html.
 *
 * ACF Free: geen repeater (prijsfactoren → 6 losse optionele slots), geen
 * gallery. `kort_antwoord` is een apart veld i.p.v. het native excerpt
 * (PHASE-4C-PLAN.md beslissing 4, APPROVED) — het excerpt blijft
 * onafhankelijk beschikbaar voor de homepage/pillar/locatie-FAQ-teasers
 * (`spotlezz_faq_block()` leest `get_the_excerpt()`), zodat een korte
 * teaser en een uitgebreider detail-antwoord nooit gedwongen dezelfde
 * lengte moeten hebben.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function spotlezz_register_acf_vraag_fields() {
	acf_add_local_field_group(
		array(
			'key'      => 'group_spotlezz_vraag',
			'title'    => __( 'FAQ-detail', 'spotlezz' ),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'vraag',
					),
				),
			),
			'fields'   => array(

				// ---------- Kort antwoord (wireframe rij 3) ----------
				array( 'key' => 'field_spotlezz_vr_kort_tab', 'label' => __( 'Kort antwoord', 'spotlezz' ), 'type' => 'tab' ),
				array(
					'key'          => 'field_spotlezz_vr_kort_antwoord',
					'label'        => __( 'Het korte antwoord (40-60 woorden)', 'spotlezz' ),
					'name'         => 'kort_antwoord',
					'type'         => 'textarea',
					'rows'         => 3,
					'instructions' => __( 'Met een concreet getal of bandbreedte. Los van het excerpt — het excerpt blijft de korte teaser op homepage/pillar/locatie, dit veld is het volledige antwoord bovenaan de detailpagina.', 'spotlezz' ),
				),

				// ---------- Verdieping (rij 4) — optioneel, alleen bij eigen detailpagina ----------
				array( 'key' => 'field_spotlezz_vr_verdieping_tab', 'label' => __( 'Verdieping', 'spotlezz' ), 'type' => 'tab' ),
				array(
					'key'          => 'field_spotlezz_vr_verdieping',
					'label'        => __( 'Verdiepingstekst', 'spotlezz' ),
					'name'         => 'verdieping',
					'type'         => 'wysiwyg',
					'media_upload' => 0,
					'instructions' => __( 'Optioneel — alleen invullen voor de ~3 vragen met een eigen, uitgewerkte detailpagina.', 'spotlezz' ),
				),
				array(
					'key'          => 'field_spotlezz_vr_verdieping_note',
					'label'        => '',
					'name'         => '',
					'type'         => 'message',
					'message'      => __( 'De zes prijsfactoren hieronder alleen invullen op de prijs-FAQ ("Wat bepaalt de prijs?"). Renderen als 2 rijen van 3 tegels (grid), niet als lijst — dat kostte scanbaarheid in de audit.', 'spotlezz' ),
				),
				array( 'key' => 'field_spotlezz_vr_factor1', 'label' => __( 'Factor 1', 'spotlezz' ), 'name' => 'factor_1_label', 'type' => 'text', 'placeholder' => 'Oppervlakte in m²' ),
				array( 'key' => 'field_spotlezz_vr_factor2', 'label' => __( 'Factor 2', 'spotlezz' ), 'name' => 'factor_2_label', 'type' => 'text', 'placeholder' => 'Frequentie per week' ),
				array( 'key' => 'field_spotlezz_vr_factor3', 'label' => __( 'Factor 3', 'spotlezz' ), 'name' => 'factor_3_label', 'type' => 'text', 'placeholder' => 'Type ruimte' ),
				array( 'key' => 'field_spotlezz_vr_factor4', 'label' => __( 'Factor 4', 'spotlezz' ), 'name' => 'factor_4_label', 'type' => 'text', 'placeholder' => 'Bezettingsgraad' ),
				array( 'key' => 'field_spotlezz_vr_factor5', 'label' => __( 'Factor 5', 'spotlezz' ), 'name' => 'factor_5_label', 'type' => 'text', 'placeholder' => 'Tijdstip (dag of avond)' ),
				array( 'key' => 'field_spotlezz_vr_factor6', 'label' => __( 'Factor 6', 'spotlezz' ), 'name' => 'factor_6_label', 'type' => 'text', 'placeholder' => 'Extra werkzaamheden' ),
				array(
					'key'           => 'field_spotlezz_vr_verdieping_foto',
					'label'         => __( 'Foto (situatie op locatie)', 'spotlezz' ),
					'name'          => 'verdieping_foto',
					'type'          => 'image',
					'return_format' => 'array',
				),

				// ---------- Gerelateerde pillar (next-hop, regel: precies 1) ----------
				array( 'key' => 'field_spotlezz_vr_relatie_tab', 'label' => __( 'Gerelateerde dienst', 'spotlezz' ), 'type' => 'tab' ),
				array(
					'key'           => 'field_spotlezz_vr_gerelateerde_pillar',
					'label'         => __( 'Gerelateerde pillar', 'spotlezz' ),
					'name'          => 'gerelateerde_pillar',
					'type'          => 'relationship',
					'post_type'     => array( 'pillar' ),
					'filters'       => array( 'search' ),
					'min'           => 1,
					'max'           => 1,
					'return_format' => 'object',
					'instructions'  => __( 'Precies één pillar — deze vraag linkt omhoog naar één specifieke dienst, niet naar de hub of naar drie diensten tegelijk.', 'spotlezz' ),
				),
			),
		)
	);
}
add_action( 'spotlezz_register_acf_field_groups', 'spotlezz_register_acf_vraag_fields' );
