<?php
/**
 * Homepage ACF-veldgroep — WORDPRESS-BUILD-PLAN.md §3.1.
 *
 * Fase 4B, homepage-only. Bevat alleen de secties die het bouwplan als
 * "tekst en afbeeldingen" (ACF) markeert. De secties die het bouwplan
 * expliciet als "geen ACF, automatisch" markeert — het dienstenblok, het
 * werkgebiedblok — hebben hier bewust GEEN velden: die worden in
 * front-page.php automatisch opgebouwd uit gepubliceerde pillar-/
 * locatie-posts, zodat een redacteur nooit een tegel kan maken die nergens
 * naartoe linkt.
 *
 * Voor "services / cases / locations / FAQ's" gebruikt het bouwplan
 * relationship-velden i.p.v. losse tekst — hier toegepast op
 * featured_cases en featured_faqs. Het dienstenblok en werkgebiedblok
 * hebben zelfs geen relationship-veld nodig: die tonen ALLE gepubliceerde
 * posts van het type, dus elke nieuwe pillar/locatie verschijnt
 * automatisch zonder dat iemand de homepage hoeft te bewerken.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registreert de homepage-veldgroep. Wordt aangeroepen via de
 * 'spotlezz_register_acf_field_groups'-hook uit inc/acf-fields.php, dus
 * alleen als ACF daadwerkelijk actief is (zie spotlezz_acf_active()).
 */
function spotlezz_register_acf_homepage_fields() {
	acf_add_local_field_group(
		array(
			'key'      => 'group_spotlezz_homepage',
			'title'    => __( 'Homepage', 'spotlezz' ),
			'location' => array(
				array(
					array(
						'param'    => 'page_type',
						'operator' => '==',
						'value'    => 'front_page',
					),
				),
			),
			'fields'   => array(

				// ---------- Hero (wireframe-5-FINAL rij 2, APPROVED §5.1: full-bleed) ----------
				array(
					'key'   => 'field_spotlezz_hp_hero_tab',
					'label' => __( 'Hero (full-bleed)', 'spotlezz' ),
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_spotlezz_hp_hero_kicker',
					'label'        => __( 'Kicker (klein label boven de H1)', 'spotlezz' ),
					'name'         => 'hero_kicker',
					'type'         => 'text',
					'default_value' => "Voor kantoren, hotels en VvE's",
				),
				array(
					'key'           => 'field_spotlezz_hp_hero_h1',
					'label'         => __( 'H1', 'spotlezz' ),
					'name'          => 'hero_h1',
					'type'          => 'text',
					'instructions'  => __( 'Kernzoekwoord van de site. Alleen wijzigen na overleg — dit is het enige blok waar het merk voor de zoekopdracht wijkt (WORDPRESS-BUILD-PLAN §3.1).', 'spotlezz' ),
					'default_value' => 'Schoonmaakbedrijf in Almere',
					'required'      => 1,
				),
				array(
					'key'           => 'field_spotlezz_hp_hero_h2',
					'label'         => __( 'H2', 'spotlezz' ),
					'name'          => 'hero_h2',
					'type'          => 'text',
					'default_value' => 'Schoon. Schoner. Spotlezz.',
				),
				array(
					'key'   => 'field_spotlezz_hp_hero_intro',
					'label' => __( 'Introzin', 'spotlezz' ),
					'name'  => 'hero_intro',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'          => 'field_spotlezz_hp_hero_bg',
					'label'        => __( 'Achtergrondfoto (full-bleed)', 'spotlezz' ),
					'name'         => 'hero_background_image',
					'type'         => 'image',
					'return_format' => 'array',
					'instructions' => __( 'Full-bleed hero-achtergrond — APPROVED, blijft altijd full-bleed (zie WORDPRESS-BUILD-PLAN §5.1). Leeg = gedocumenteerde placeholder-achtergrond, geen stockfoto.', 'spotlezz' ),
				),

				// ---------- Antwoordblok (wireframe-5-FINAL rij 3) ----------
				array(
					'key'   => 'field_spotlezz_hp_trust_tab',
					'label' => __( 'Antwoordblok', 'spotlezz' ),
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_spotlezz_hp_trust_intro',
					'label' => __( 'Korte introzin (optioneel, 1-2 zinnen)', 'spotlezz' ),
					'name'  => 'trust_intro',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				/**
				 * ACF-Free-compatibel: 4 losse velden i.p.v. een repeater.
				 * Repeater is een Pro-only veldtype — de preview toonde dat
				 * dit veld in de gratis versie niet eens verschijnt. Er
				 * worden bewust GEEN 4 stats meer verwijderd of ingekort;
				 * dit is dezelfde vier feiten, alleen als vaste velden
				 * i.p.v. herhaalbare rijen (WORDPRESS-BUILD-PLAN blijft
				 * inhoudelijk exact 4 eisen, dat verandert hier niet).
				 */
				array(
					'key'   => 'field_spotlezz_hp_stat1_value',
					'label' => __( 'Feit 1 — waarde', 'spotlezz' ),
					'name'  => 'stat_1_value',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_spotlezz_hp_stat1_label',
					'label' => __( 'Feit 1 — label', 'spotlezz' ),
					'name'  => 'stat_1_label',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_spotlezz_hp_stat2_value',
					'label' => __( 'Feit 2 — waarde', 'spotlezz' ),
					'name'  => 'stat_2_value',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_spotlezz_hp_stat2_label',
					'label' => __( 'Feit 2 — label', 'spotlezz' ),
					'name'  => 'stat_2_label',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_spotlezz_hp_stat3_value',
					'label' => __( 'Feit 3 — waarde', 'spotlezz' ),
					'name'  => 'stat_3_value',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_spotlezz_hp_stat3_label',
					'label' => __( 'Feit 3 — label', 'spotlezz' ),
					'name'  => 'stat_3_label',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_spotlezz_hp_stat4_value',
					'label' => __( 'Feit 4 — waarde', 'spotlezz' ),
					'name'  => 'stat_4_value',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_spotlezz_hp_stat4_label',
					'label' => __( 'Feit 4 — label', 'spotlezz' ),
					'name'  => 'stat_4_label',
					'type'  => 'text',
				),

				// ---------- Eigen fotografie (wireframe-5-FINAL rij 5) ----------
				array(
					'key'   => 'field_spotlezz_hp_photo_tab',
					'label' => __( 'Eigen fotografie', 'spotlezz' ),
					'type'  => 'tab',
				),
				/**
				 * ACF-Free-compatibel: 3 losse foto+bijschrift-paren i.p.v.
				 * een repeater. Nog steeds precies drie foto's — de
				 * wireframe-eis wordt hier niet ingekort, alleen het
				 * veldtype verandert.
				 */
				array(
					'key'           => 'field_spotlezz_hp_photo1',
					'label'         => __( "Foto 1 (team aan het werk)", 'spotlezz' ),
					'name'          => 'photo_1',
					'type'          => 'image',
					'return_format' => 'array',
					'instructions'  => __( 'Geen stockbeeld (WORDPRESS-BUILD-PLAN §3.1/§4). Leeg = gedocumenteerde placeholder, nooit een vervangende stockfoto.', 'spotlezz' ),
				),
				array(
					'key'   => 'field_spotlezz_hp_photo1_caption',
					'label' => __( 'Foto 1 — bijschrift', 'spotlezz' ),
					'name'  => 'photo_1_caption',
					'type'  => 'text',
				),
				array(
					'key'           => 'field_spotlezz_hp_photo2',
					'label'         => __( 'Foto 2 (het pand of de ruimte)', 'spotlezz' ),
					'name'          => 'photo_2',
					'type'          => 'image',
					'return_format' => 'array',
				),
				array(
					'key'   => 'field_spotlezz_hp_photo2_caption',
					'label' => __( 'Foto 2 — bijschrift', 'spotlezz' ),
					'name'  => 'photo_2_caption',
					'type'  => 'text',
				),
				array(
					'key'           => 'field_spotlezz_hp_photo3',
					'label'         => __( 'Foto 3 (materiaal en producten)', 'spotlezz' ),
					'name'          => 'photo_3',
					'type'          => 'image',
					'return_format' => 'array',
				),
				array(
					'key'   => 'field_spotlezz_hp_photo3_caption',
					'label' => __( 'Foto 3 — bijschrift', 'spotlezz' ),
					'name'  => 'photo_3_caption',
					'type'  => 'text',
				),

				/**
				 * Reviewblok (wireframe-5-FINAL rij 6) — VERPLAATST in fase 4C
				 * naar Site Options (WORDPRESS-BUILD-PLAN §5-beslissing 1,
				 * APPROVED), want pillar- en locatiepagina's tonen dezelfde
				 * drie reviews en dat moest niet 18× herhaald hoeven worden.
				 * Bewerken kan nu via Instellingen → Site Options
				 * (`review_1_quote` t/m `review_3_photo` in
				 * inc/site-options.php). Rendering: spotlezz_reviews_block()
				 * in inc/components.php, aangeroepen vanuit front-page.php.
				 * Geen ACF-velden hier meer voor nodig.
				 */

				// ---------- Klantcases (wireframe-5-FINAL rij 7) — RELATIONSHIP ----------
				array(
					'key'   => 'field_spotlezz_hp_cases_tab',
					'label' => __( 'Klantcases', 'spotlezz' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_spotlezz_hp_featured_cases',
					'label'         => __( 'Drie klantcases', 'spotlezz' ),
					'name'          => 'featured_cases',
					'type'          => 'relationship',
					'post_type'     => array( 'case' ),
					'filters'       => array( 'search' ),
					'min'           => 3,
					'max'           => 3,
					'return_format' => 'object',
					'instructions'  => __( 'Selecteer uit bestaande, gepubliceerde klantcases — geen vrije tekst. Voorkomt links naar niet-bestaande cases (WORDPRESS-BUILD-PLAN §4, harde regel 7).', 'spotlezz' ),
				),

				// ---------- Oprichter (wireframe-5-FINAL rij 8) ----------
				array(
					'key'   => 'field_spotlezz_hp_founder_tab',
					'label' => __( 'Oprichter', 'spotlezz' ),
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_spotlezz_hp_founder_name',
					'label' => __( 'Naam', 'spotlezz' ),
					'name'  => 'founder_name',
					'type'  => 'text',
					'instructions' => __( 'Leeg laten tot bevestigd — een leeg naamveld toont bewust geen kaart en geen Person-schema (regel 9).', 'spotlezz' ),
				),
				array(
					'key'           => 'field_spotlezz_hp_founder_role',
					'label'         => __( 'Functie', 'spotlezz' ),
					'name'          => 'founder_role',
					'type'          => 'text',
					'default_value' => 'Oprichter',
				),
				array(
					'key'   => 'field_spotlezz_hp_founder_quote',
					'label' => __( 'Quote', 'spotlezz' ),
					'name'  => 'founder_quote',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'           => 'field_spotlezz_hp_founder_photo',
					'label'         => __( 'Portretfoto', 'spotlezz' ),
					'name'          => 'founder_photo',
					'type'          => 'image',
					'return_format' => 'array',
					'instructions'  => __( 'BELANGRIJK (WORDPRESS-BUILD-PLAN §5.2, APPROVED): alleen invullen met een door de klant bevestigd portret. Nooit een andere, niet-bevestigde medewerkersfoto onder deze naam plaatsen. Leeg = initiaal-avatar, geen vervangende foto.', 'spotlezz' ),
					'required'      => 0,
				),
				array(
					'key'   => 'field_spotlezz_hp_founder_linkedin',
					'label' => __( 'LinkedIn-URL (leeg = geen link)', 'spotlezz' ),
					'name'  => 'founder_linkedin',
					'type'  => 'url',
				),
				array(
					'key'          => 'field_spotlezz_hp_founder_side_photo',
					'label'        => __( 'Grote foto naast de kaart', 'spotlezz' ),
					'name'         => 'founder_side_photo',
					'type'         => 'image',
					'return_format' => 'array',
					'instructions' => __( 'Los van "Foto 2" (die staat ook in "Spotlezz in de praktijk") — deze foto is uitsluitend voor naast de oprichterskaart, zodat één wijziging niet meteen op twee plekken tegelijk verandert. Leeg = valt terug op Foto 2.', 'spotlezz' ),
				),

				// ---------- FAQ (wireframe-5-FINAL rij 10) — RELATIONSHIP ----------
				array(
					'key'   => 'field_spotlezz_hp_faq_tab',
					'label' => __( 'FAQ', 'spotlezz' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_spotlezz_hp_featured_faqs',
					'label'         => __( 'Vijf vragen', 'spotlezz' ),
					'name'          => 'featured_faqs',
					'type'          => 'relationship',
					'post_type'     => array( 'vraag' ),
					'filters'       => array( 'search' ),
					'min'           => 5,
					'max'           => 5,
					'return_format' => 'object',
					'instructions'  => __( 'Selecteer uit bestaande, gepubliceerde vragen — geen vrije tekst.', 'spotlezz' ),
				),

				// ---------- Lead magnet (wireframe-5-FINAL rij 11) — precies één instantie ----------
				array(
					'key'   => 'field_spotlezz_hp_lead_tab',
					'label' => __( 'Zachte conversie (lead magnet)', 'spotlezz' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_spotlezz_hp_lead_title',
					'label'         => __( 'Titel', 'spotlezz' ),
					'name'          => 'lead_magnet_title',
					'type'          => 'text',
					'default_value' => 'De Spotlezz-check',
					'instructions'  => __( 'Precies één lead-magnet-blok op de homepage (sectie "De Spotlezz-check", donkere foto-achtergrond + formulier) — de eerdere kleine losstaande CTA-kaart erboven is op klantfeedback verwijderd.', 'spotlezz' ),
				),
				array(
					'key'   => 'field_spotlezz_hp_lead_description',
					'label' => __( 'Beschrijving', 'spotlezz' ),
					'name'  => 'lead_magnet_description',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'           => 'field_spotlezz_hp_lead_cta',
					'label'         => __( 'Knoptekst', 'spotlezz' ),
					'name'          => 'lead_magnet_cta_label',
					'type'          => 'text',
					'default_value' => 'Ontvang de checklist',
				),
			),
		)
	);
}
add_action( 'spotlezz_register_acf_field_groups', 'spotlezz_register_acf_homepage_fields' );
