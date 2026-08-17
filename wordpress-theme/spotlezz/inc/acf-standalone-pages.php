<?php
/**
 * ACF-veldgroepen voor de zes losstaande pagina's (Contact, Over ons,
 * Checklist, Vacatures, Offerte aanvragen, Reviews) — hun kopteksten en
 * alinea's stonden tot nu toe hardcoded in de theme-templates, terwijl elk
 * ander paginatype (dienst, klantcase, locatie, vraag, homepage) die al via
 * ACF beheerbaar had. Elk veld valt terug op de huidige, al goedgekeurde
 * tekst als default (spotlezz_field()), dus dit verandert niets aan wat er
 * nu op de site staat — het maakt die tekst alleen redigeerbaar.
 *
 * Vorm-elementen (labels, placeholders, "Bekijk alles"-linkjes, next-hop-
 * teksten) blijven bewust hardcoded — dat is chrome, geen content, en dat
 * patroon is consistent met hoe elk ander paginatype dit al doet.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Locatieregel voor "deze ene specifieke pagina" — ACF's page_type-param
 * dekt alleen 'front_page'/'posts_page', niet "de pagina met slug X". Haalt
 * de pagina dynamisch op zodat er geen hardcoded post-ID in dit bestand
 * hoeft te staan.
 *
 * @param string $slug Pagina-slug (page-{slug}.php).
 * @return array ACF location-array, leeg als de pagina niet bestaat.
 */
function spotlezz_acf_page_location( $slug ) {
	$page = get_page_by_path( $slug );
	if ( ! $page ) {
		return array();
	}
	return array(
		array(
			array(
				'param'    => 'page',
				'operator' => '==',
				'value'    => $page->ID,
			),
		),
	);
}

function spotlezz_register_acf_standalone_pages_fields() {

	// ---------- Contact ----------
	$location = spotlezz_acf_page_location( 'contact' );
	if ( ! empty( $location ) ) {
		acf_add_local_field_group(
			array(
				'key'      => 'group_spotlezz_page_contact',
				'title'    => __( 'Contactpagina', 'spotlezz' ),
				'location' => $location,
				'fields'   => array(
					array(
						'key'           => 'field_spotlezz_contact_info_heading',
						'label'         => __( 'Kop infokolom', 'spotlezz' ),
						'name'          => 'contact_info_heading',
						'type'          => 'text',
						'default_value' => 'Kom in contact',
					),
					array(
						'key'           => 'field_spotlezz_contact_info_intro',
						'label'         => __( 'Introtekst infokolom', 'spotlezz' ),
						'name'          => 'contact_info_intro',
						'type'          => 'textarea',
						'rows'          => 3,
						'default_value' => 'Of je nu vragen hebt over onze diensten, een afspraak wilt inplannen of gewoon even wilt sparren over de mogelijkheden voor jouw kantoor, wij staan voor je klaar.',
					),
					array(
						'key'           => 'field_spotlezz_contact_werkgebied',
						'label'         => __( 'Werkgebied-tekst', 'spotlezz' ),
						'name'          => 'contact_werkgebied',
						'type'          => 'text',
						'default_value' => 'Almere, Lelystad, Amsterdam en Amersfoort',
					),
					array(
						'key'           => 'field_spotlezz_contact_form_heading',
						'label'         => __( 'Kop formulierkaart', 'spotlezz' ),
						'name'          => 'contact_form_heading',
						'type'          => 'text',
						'default_value' => 'Stuur een bericht',
					),
				),
			)
		);
	}

	// ---------- Over ons ----------
	$location = spotlezz_acf_page_location( 'over-ons' );
	if ( ! empty( $location ) ) {
		acf_add_local_field_group(
			array(
				'key'      => 'group_spotlezz_page_over_ons',
				'title'    => __( 'Over-ons-pagina', 'spotlezz' ),
				'location' => $location,
				'fields'   => array(
					array(
						'key'   => 'field_spotlezz_oo_verhaal_tab',
						'label' => __( 'Ons verhaal', 'spotlezz' ),
						'type'  => 'tab',
					),
					array(
						'key'           => 'field_spotlezz_oo_verhaal_heading',
						'label'         => __( 'Kop', 'spotlezz' ),
						'name'          => 'verhaal_heading',
						'type'          => 'text',
						'default_value' => 'Ons verhaal',
					),
					array(
						'key'           => 'field_spotlezz_oo_verhaal_p1',
						'label'         => __( 'Alinea 1', 'spotlezz' ),
						'name'          => 'verhaal_p1',
						'type'          => 'textarea',
						'rows'          => 3,
						'default_value' => 'Spotlezz begon als de droom van één jonge ondernemer. Inmiddels zijn we uitgegroeid tot een energiek team met één doel: elke dag een beetje schoner.',
					),
					array(
						'key'           => 'field_spotlezz_oo_verhaal_p2',
						'label'         => __( 'Alinea 2', 'spotlezz' ),
						'name'          => 'verhaal_p2',
						'type'          => 'textarea',
						'rows'          => 3,
						'default_value' => 'Met vaste gezichten, natuurlijke producten en onze eigen Spotlezz-check zorgen we dat schoon niet zomaar schoon is. Want voor ons is schoon: Schoner. Schoon. Spotlezz.',
					),
					array(
						'key'           => 'field_spotlezz_oo_verhaal_benefit_1',
						'label'         => __( 'Checklist-item 1', 'spotlezz' ),
						'name'          => 'verhaal_benefit_1',
						'type'          => 'text',
						'default_value' => 'Vaste, betrouwbare gezichten',
					),
					array(
						'key'           => 'field_spotlezz_oo_verhaal_benefit_2',
						'label'         => __( 'Checklist-item 2', 'spotlezz' ),
						'name'          => 'verhaal_benefit_2',
						'type'          => 'text',
						'default_value' => 'Uitsluitend natuurlijke producten',
					),
					array(
						'key'           => 'field_spotlezz_oo_verhaal_benefit_3',
						'label'         => __( 'Checklist-item 3', 'spotlezz' ),
						'name'          => 'verhaal_benefit_3',
						'type'          => 'text',
						'default_value' => 'De eigen Spotlezz-check kwaliteitscontrole',
					),

					array(
						'key'   => 'field_spotlezz_oo_visie_tab',
						'label' => __( 'Visie & missie', 'spotlezz' ),
						'type'  => 'tab',
					),
					array(
						'key'           => 'field_spotlezz_oo_visie_heading',
						'label'         => __( 'Kop visie', 'spotlezz' ),
						'name'          => 'visie_heading',
						'type'          => 'text',
						'default_value' => 'Onze visie',
					),
					array(
						'key'           => 'field_spotlezz_oo_visie_p1',
						'label'         => __( 'Visie alinea 1', 'spotlezz' ),
						'name'          => 'visie_p1',
						'type'          => 'textarea',
						'rows'          => 3,
						'default_value' => 'Wij zetten de nieuwe standaard in schoonmaak. Niet de grootste, wél de meest betrokken en vernieuwende partner.',
					),
					array(
						'key'           => 'field_spotlezz_oo_visie_p2',
						'label'         => __( 'Visie alinea 2', 'spotlezz' ),
						'name'          => 'visie_p2',
						'type'          => 'textarea',
						'rows'          => 3,
						'default_value' => 'Echt schoonmaken begint met oog voor detail. Van stofvrije plinten tot een bureau dat nét weer recht staat. Wij zorgen dat elke ruimte klopt, als één geheel. Samen creëren we gezonde, inspirerende werkomgevingen waar mensen zich thuis voelen en bedrijven kunnen groeien.',
					),
					array(
						'key'           => 'field_spotlezz_oo_missie_heading',
						'label'         => __( 'Kop missie', 'spotlezz' ),
						'name'          => 'missie_heading',
						'type'          => 'text',
						'default_value' => 'Onze missie',
					),
					array(
						'key'           => 'field_spotlezz_oo_missie_p1',
						'label'         => __( 'Missie alinea 1', 'spotlezz' ),
						'name'          => 'missie_p1',
						'type'          => 'textarea',
						'rows'          => 3,
						'default_value' => 'Samen met onze klanten bouwen we aan een fijne werkplek. Wij geloven dat een schone omgeving de basis is voor werkplezier, gezondheid en succes.',
					),
					array(
						'key'           => 'field_spotlezz_oo_missie_p2',
						'label'         => __( 'Missie alinea 2', 'spotlezz' ),
						'name'          => 'missie_p2',
						'type'          => 'textarea',
						'rows'          => 3,
						'default_value' => 'We luisteren naar de wensen van onze klanten en denken proactief mee, zodat we altijd nét dat stapje extra zetten. Onze missie is om niet alleen schoon te maken, maar écht het verschil te maken.',
					),

					array(
						'key'   => 'field_spotlezz_oo_founder_tab',
						'label' => __( 'Oprichter-quote', 'spotlezz' ),
						'type'  => 'tab',
					),
					array(
						'key'           => 'field_spotlezz_oo_founder_p1',
						'label'         => __( 'Alinea 1', 'spotlezz' ),
						'name'          => 'founder_intro_p1',
						'type'          => 'textarea',
						'rows'          => 3,
						'default_value' => 'Als oprichter van Spotlezz ben ik elke dag bezig met het verbeteren van onze dienstverlening. Ik geloof in een persoonlijke aanpak en korte communicatielijnen. Bij Spotlezz draait alles om mensen: zowel ons eigen team als de mensen voor wie wij schoonmaken.',
						'instructions'  => __( 'Naam, foto en functie van de oprichter staan op de homepage-velden (Oprichter-tab).', 'spotlezz' ),
					),
					array(
						'key'           => 'field_spotlezz_oo_founder_p2',
						'label'         => __( 'Alinea 2', 'spotlezz' ),
						'name'          => 'founder_intro_p2',
						'type'          => 'textarea',
						'rows'          => 2,
						'default_value' => 'Heb je vragen of wil je kennismaken? Ik kom graag bij je langs voor een kop koffie en een advies op maat.',
					),

					array(
						'key'   => 'field_spotlezz_oo_medewerker_tab',
						'label' => __( 'Medewerker aan het woord', 'spotlezz' ),
						'type'  => 'tab',
					),
					array(
						'key'           => 'field_spotlezz_oo_medewerker_naam',
						'label'         => __( 'Naam', 'spotlezz' ),
						'name'          => 'medewerker_naam',
						'type'          => 'text',
						'default_value' => 'Thomas Jansen',
					),
					array(
						'key'           => 'field_spotlezz_oo_medewerker_quote',
						'label'         => __( 'Quote', 'spotlezz' ),
						'name'          => 'medewerker_quote',
						'type'          => 'textarea',
						'rows'          => 3,
						'default_value' => 'Als ik een kantoor schoonmaak, zorg ik dat alles klopt. Van de werkplekken tot de pantry. Ik weet hoe belangrijk het is dat medewerkers de volgende ochtend in een frisse ruimte kunnen beginnen.',
					),

					array(
						'key'   => 'field_spotlezz_oo_impact_tab',
						'label' => __( 'Klantcases-sectie', 'spotlezz' ),
						'type'  => 'tab',
					),
					array(
						'key'           => 'field_spotlezz_oo_impact_heading',
						'label'         => __( 'Kop', 'spotlezz' ),
						'name'          => 'impact_heading',
						'type'          => 'text',
						'default_value' => 'Ontdek onze impact',
					),
				),
			)
		);
	}

	// ---------- Checklist ----------
	$location = spotlezz_acf_page_location( 'checklist' );
	if ( ! empty( $location ) ) {
		acf_add_local_field_group(
			array(
				'key'      => 'group_spotlezz_page_checklist',
				'title'    => __( 'Checklistpagina', 'spotlezz' ),
				'location' => $location,
				'fields'   => array(
					array(
						'key'           => 'field_spotlezz_ck_uitleg_heading',
						'label'         => __( 'Kop uitlegblok', 'spotlezz' ),
						'name'          => 'checklist_uitleg_heading',
						'type'          => 'text',
						'default_value' => 'Wat is de Spotlezz-checklist?',
					),
					array(
						'key'           => 'field_spotlezz_ck_uitleg_p1',
						'label'         => __( 'Alinea 1', 'spotlezz' ),
						'name'          => 'checklist_uitleg_p1',
						'type'          => 'textarea',
						'rows'          => 3,
						'default_value' => 'De Spotlezz-checklist is de dagelijkse kwaliteitscontrole die onze schoonmakers uitvoeren bij onze klanten. Door de check te doen zie je in één oogopslag het verschil tussen schoon en Spotlezz.',
					),
					array(
						'key'           => 'field_spotlezz_ck_uitleg_p2',
						'label'         => __( 'Alinea 2', 'spotlezz' ),
						'name'          => 'checklist_uitleg_p2',
						'type'          => 'textarea',
						'rows'          => 3,
						'default_value' => 'Het zijn de details die een groot verschil maken, en die ontdek je pas als je er met een scherp oog naar kijkt. Denk aan prullenbakken, stoelpoten, toetsenborden of lichtschakelaars.',
					),
					array(
						'key'           => 'field_spotlezz_ck_uitleg_bold',
						'label'         => __( 'Afsluitzin (vet)', 'spotlezz' ),
						'name'          => 'checklist_uitleg_bold',
						'type'          => 'text',
						'default_value' => 'Want schoon kan altijd schoner.',
					),
					array(
						'key'           => 'field_spotlezz_ck_form_heading',
						'label'         => __( 'Kop formulierblok', 'spotlezz' ),
						'name'          => 'checklist_form_heading',
						'type'          => 'text',
						'default_value' => 'Doe nu de Spotlezz-check',
					),
					array(
						'key'           => 'field_spotlezz_ck_form_intro',
						'label'         => __( 'Introtekst formulierblok', 'spotlezz' ),
						'name'          => 'checklist_form_intro',
						'type'          => 'textarea',
						'rows'          => 2,
						'default_value' => 'Kijk met onze frisse blik naar jouw bedrijfsschoonmaak. Vul je e-mailadres in en ontvang de checklist binnen 1 minuut in je inbox.',
					),
				),
			)
		);
	}

	// ---------- Vacatures ----------
	$location = spotlezz_acf_page_location( 'vacatures' );
	if ( ! empty( $location ) ) {
		acf_add_local_field_group(
			array(
				'key'      => 'group_spotlezz_page_vacatures',
				'title'    => __( 'Vacaturepagina', 'spotlezz' ),
				'location' => $location,
				'fields'   => array(
					array(
						'key'           => 'field_spotlezz_vac_why_heading',
						'label'         => __( 'Kop "Waarom werken bij Spotlezz"', 'spotlezz' ),
						'name'          => 'vacatures_why_heading',
						'type'          => 'text',
						'default_value' => 'Waarom werken bij Spotlezz',
					),
					array(
						'key'           => 'field_spotlezz_vac_why_1',
						'label'         => __( 'Tegel 1', 'spotlezz' ),
						'name'          => 'vacatures_why_1',
						'type'          => 'text',
						'default_value' => 'Meetbare kwaliteit',
					),
					array(
						'key'           => 'field_spotlezz_vac_why_2',
						'label'         => __( 'Tegel 2', 'spotlezz' ),
						'name'          => 'vacatures_why_2',
						'type'          => 'text',
						'default_value' => 'Getraind personeel',
					),
					array(
						'key'           => 'field_spotlezz_vac_why_3',
						'label'         => __( 'Tegel 3', 'spotlezz' ),
						'name'          => 'vacatures_why_3',
						'type'          => 'text',
						'default_value' => 'Duurzame schoonmaakproducten',
					),
					array(
						'key'           => 'field_spotlezz_vac_why_4',
						'label'         => __( 'Tegel 4', 'spotlezz' ),
						'name'          => 'vacatures_why_4',
						'type'          => 'text',
						'default_value' => 'Flexibele service',
					),
					array(
						'key'           => 'field_spotlezz_vac_job_heading',
						'label'         => __( 'Kop "Vind vandaag nog je nieuwe baan"', 'spotlezz' ),
						'name'          => 'vacatures_job_heading',
						'type'          => 'text',
						'default_value' => 'Vind vandaag nog je nieuwe baan',
					),
					array(
						'key'           => 'field_spotlezz_vac_job_intro',
						'label'         => __( 'Tekst eronder', 'spotlezz' ),
						'name'          => 'vacatures_job_intro',
						'type'          => 'text',
						'default_value' => 'Er wachten je talloze nieuwe kansen en mogelijkheden.',
					),
					array(
						'key'           => 'field_spotlezz_vac_novacancy_heading',
						'label'         => __( 'Kop "Geen specifieke vacatures"', 'spotlezz' ),
						'name'          => 'vacatures_novacancy_heading',
						'type'          => 'text',
						'default_value' => 'Op dit moment geen specifieke vacatures online',
					),
					array(
						'key'           => 'field_spotlezz_vac_novacancy_text',
						'label'         => __( 'Tekst eronder', 'spotlezz' ),
						'name'          => 'vacatures_novacancy_text',
						'type'          => 'textarea',
						'rows'          => 3,
						'default_value' => 'We hebben nu geen vacatures met een vaste functie-inhoud online staan, maar we zijn altijd geïnteresseerd om kennis te maken met gemotiveerde mensen. Stuur ons een open sollicitatie en we nemen contact met je op zodra er een passende plek is.',
					),
					array(
						'key'           => 'field_spotlezz_vac_apply_heading',
						'label'         => __( 'Kop sollicitatieblok', 'spotlezz' ),
						'name'          => 'vacatures_apply_heading',
						'type'          => 'text',
						'default_value' => 'Geïnteresseerd om met ons samen te werken?',
					),
					array(
						'key'           => 'field_spotlezz_vac_apply_note',
						'label'         => __( 'Tekst eronder', 'spotlezz' ),
						'name'          => 'vacatures_apply_note',
						'type'          => 'text',
						'default_value' => 'Upload je cv, sollicitatiebrief of portfolio.',
					),
					array(
						'key'           => 'field_spotlezz_vac_questions_heading',
						'label'         => __( 'Kop "Liever eerst wat vragen?"', 'spotlezz' ),
						'name'          => 'vacatures_questions_heading',
						'type'          => 'text',
						'default_value' => 'Liever eerst wat vragen?',
					),
				),
			)
		);
	}

	// ---------- Offerte aanvragen ----------
	$location = spotlezz_acf_page_location( 'offerte-aanvragen' );
	if ( ! empty( $location ) ) {
		acf_add_local_field_group(
			array(
				'key'      => 'group_spotlezz_page_offerte',
				'title'    => __( 'Offerte-aanvragen-pagina', 'spotlezz' ),
				'location' => $location,
				'fields'   => array(
					array(
						'key'           => 'field_spotlezz_of_hero_prefix',
						'label'         => __( 'Kop — deel vóór markering', 'spotlezz' ),
						'name'          => 'offerte_hero_prefix',
						'type'          => 'text',
						'default_value' => 'Ontvang een',
					),
					array(
						'key'           => 'field_spotlezz_of_hero_highlight',
						'label'         => __( 'Kop — gemarkeerd deel (oranje)', 'spotlezz' ),
						'name'          => 'offerte_hero_highlight',
						'type'          => 'text',
						'default_value' => 'offerte op maat',
					),
					array(
						'key'           => 'field_spotlezz_of_hero_suffix',
						'label'         => __( 'Kop — deel ná markering', 'spotlezz' ),
						'name'          => 'offerte_hero_suffix',
						'type'          => 'text',
						'default_value' => 'voor jouw bedrijf',
					),
					array(
						'key'           => 'field_spotlezz_of_bel_heading',
						'label'         => __( 'Kop belblok', 'spotlezz' ),
						'name'          => 'offerte_bel_heading',
						'type'          => 'text',
						'default_value' => 'Liever even snel bellen?',
					),
					array(
						'key'           => 'field_spotlezz_of_bel_text',
						'label'         => __( 'Tekst belblok', 'spotlezz' ),
						'name'          => 'offerte_bel_text',
						'type'          => 'text',
						'default_value' => 'Krijg direct antwoord op al uw vragen.',
					),
				),
			)
		);
	}

	// ---------- Reviews ----------
	$location = spotlezz_acf_page_location( 'reviews' );
	if ( ! empty( $location ) ) {
		acf_add_local_field_group(
			array(
				'key'      => 'group_spotlezz_page_reviews',
				'title'    => __( 'Reviewspagina', 'spotlezz' ),
				'location' => $location,
				'fields'   => array(
					array(
						'key'           => 'field_spotlezz_rv_hero_heading',
						'label'         => __( 'Kop', 'spotlezz' ),
						'name'          => 'reviews_hero_heading',
						'type'          => 'text',
						'default_value' => 'Reviews over Spotlezz',
					),
					array(
						'key'           => 'field_spotlezz_rv_hero_intro',
						'label'         => __( 'Introtekst', 'spotlezz' ),
						'name'          => 'reviews_hero_intro',
						'type'          => 'textarea',
						'rows'          => 2,
						'default_value' => 'Gemiddeld 4,8 uit 5 op basis van 87 beoordelingen. Hieronder een selectie, gekoppeld aan het echte klantlogo, zodat u kunt zien wie het zegt.',
					),
					array(
						'key'           => 'field_spotlezz_rv_other_heading',
						'label'         => __( 'Kop "Nog meer bedrijven"', 'spotlezz' ),
						'name'          => 'reviews_other_heading',
						'type'          => 'text',
						'default_value' => 'Nog meer bedrijven die Spotlezz vertrouwen',
					),
					array(
						'key'           => 'field_spotlezz_rv_why_heading',
						'label'         => __( 'Kop "Waarom geen anonieme reviews"', 'spotlezz' ),
						'name'          => 'reviews_why_heading',
						'type'          => 'text',
						'default_value' => 'Waarom wij geen anonieme reviews plaatsen',
					),
					array(
						'key'           => 'field_spotlezz_rv_why_p1',
						'label'         => __( 'Alinea 1', 'spotlezz' ),
						'name'          => 'reviews_why_p1',
						'type'          => 'textarea',
						'rows'          => 3,
						'default_value' => 'Een citaat zonder afzender is niet te controleren en telt daarom voor niemand mee, ook niet voor een zoekmachine. Elke review op deze pagina staat daarom gekoppeld aan het logo van een échte, bestaande klant van Spotlezz.',
					),
					array(
						'key'           => 'field_spotlezz_rv_why_p2',
						'label'         => __( 'Alinea 2', 'spotlezz' ),
						'name'          => 'reviews_why_p2',
						'type'          => 'textarea',
						'rows'          => 3,
						'default_value' => 'De gemiddelde score van 4,8 komt uit ons Google-bedrijfsprofiel en is daar door iedereen na te lezen. Wij plaatsen op deze pagina geen reviews die daar niet ook staan of die niet rechtstreeks bij ons zijn achtergelaten.',
					),
				),
			)
		);
	}
}
add_action( 'spotlezz_register_acf_field_groups', 'spotlezz_register_acf_standalone_pages_fields' );
