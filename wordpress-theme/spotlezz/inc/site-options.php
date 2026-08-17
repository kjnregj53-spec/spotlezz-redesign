<?php
/**
 * Gecentraliseerde Site Options: NAP-gegevens, telefoonnummer, reviewscore,
 * form-endpoint, etc. — WORDPRESS-BUILD-PLAN.md §3.6 en harde regel 14
 * ("NAP data must come from the centralized Site Options").
 *
 * Werkt met of zonder ACF: als ACF (Pro, voor Options Pages) actief is,
 * gebruiken we een ACF Options-pagina. Is ACF niet actief, dan valt dit
 * bestand terug op een kleine, native Settings API-pagina met dezelfde
 * velden, zodat er nooit een moment is waarop NAP-gegevens alsnog per
 * pagina overgetypt zouden moeten worden. Er wordt geen ACF-gedrag
 * gesimuleerd — dit is gewoon WordPress core.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * De enige plek waar Site Options uitgelezen worden. Alle andere theme-code
 * (header, footer, schema, NAP-blok op locatiepagina's) roept deze functie
 * aan — nooit rechtstreeks get_option()/get_field(), zodat de ACF/no-ACF-
 * vertakking op één plek blijft.
 *
 * BELANGRIJKE FIX (na de fase-4B-preview): eerder controleerde deze functie
 * alleen `function_exists('get_field')` om te bepalen of de ACF-Options-
 * route gebruikt moest worden. Dat klopt niet: `get_field()` bestaat ook in
 * de GRATIS versie van ACF, maar de Options-Page-opslag (`get_field($key,
 * 'option')`) hoort bij `acf_add_options_page()`, en dát is een Pro-only
 * functie. Met alleen gratis ACF actief — de permanente situatie hier,
 * ACF Pro wordt niet aangeschaft — las deze functie dus altijd van een
 * ACF-opslaglocatie die nooit gevuld kon worden, terwijl de native
 * fallback-instellingenpagina (zie hieronder) intussen wél gewoon naar
 * `spotlezz_{key}` in de standaard wp_options-tabel schreef. Twee
 * verschillende opslagplekken die elkaar nooit zagen — dat verklaarde de
 * lege reviewbadge in de preview.
 *
 * Fix: de ACF-Options-route wordt alleen nog gebruikt als
 * `acf_add_options_page` daadwerkelijk bestaat (dus met ACF Pro). Zonder
 * ACF Pro — de huidige en verwachte situatie — leest deze functie
 * uitsluitend uit de native optie, exact dezelfde plek waar de
 * fallback-instellingenpagina naar schrijft.
 *
 * Daarnaast: als de aanroeper geen eigen $default meegeeft, valt deze
 * functie terug op de default uit spotlezz_site_option_fields() zelf, in
 * plaats van op een lege string. Daardoor tonen o.a. de reviewbadge en de
 * overige Site Options meteen hun ingestelde standaardwaarde, ook voordat
 * een beheerder de instellingenpagina ooit heeft geopend of bewaard — er is
 * dus geen verplichte "eerst opslaan"-stap meer nodig voor de defaults.
 * Bewaren is alleen nodig om een waarde daadwerkelijk te WIJZIGEN.
 *
 * @param string $key     Optienaam zonder prefix, bv. 'phone', 'address_street'.
 * @param mixed  $default Terugvalwaarde. Laat weg (null) om de geregistreerde
 *                         default uit spotlezz_site_option_fields() te gebruiken.
 * @return mixed
 */
function spotlezz_get_option( $key, $default = null ) {
	if ( null === $default ) {
		$fields  = spotlezz_site_option_fields();
		$default = isset( $fields[ $key ]['default'] ) ? $fields[ $key ]['default'] : '';
	}

	// Alleen de ACF-Options-route gebruiken als ACF Pro's Options Page er
	// daadwerkelijk is — anders bestaat er niets om uit te lezen, ook al
	// bestaat get_field() zelf wel in de gratis versie.
	if ( function_exists( 'acf_add_options_page' ) && function_exists( 'get_field' ) ) {
		$value = get_field( $key, 'option' );
		if ( null !== $value && '' !== $value ) {
			return $value;
		}
		return $default;
	}

	$value = get_option( 'spotlezz_' . $key, null );
	return ( null !== $value && '' !== $value ) ? $value : $default;
}

/**
 * Vaste lijst van site-optie-velden. Eén bron van waarheid voor zowel de
 * ACF-veldgroep als de native-fallback-pagina, zodat de twee nooit uit
 * elkaar kunnen lopen.
 *
 * @return array<string,array{label:string,type:string,default:string}>
 */
function spotlezz_site_option_fields() {
	return array(
		'org_name'         => array(
			'label'   => __( 'Bedrijfsnaam', 'spotlezz' ),
			'type'    => 'text',
			'default' => 'Spotlezz',
		),
		'org_legal_name'   => array(
			'label'   => __( 'Statutaire naam', 'spotlezz' ),
			'type'    => 'text',
			'default' => 'Spotlezz B.V.',
		),
		'phone'            => array(
			'label'   => __( 'Telefoonnummer (weergave)', 'spotlezz' ),
			'type'    => 'text',
			'default' => '036-785 7028',
		),
		'phone_raw'        => array(
			'label'   => __( 'Telefoonnummer (tel: link, alleen cijfers)', 'spotlezz' ),
			'type'    => 'text',
			'default' => '0367857028',
		),
		'phone_intl'       => array(
			'label'   => __( 'Telefoonnummer (internationaal formaat, voor schema)', 'spotlezz' ),
			'type'    => 'text',
			'default' => '+31367857028',
		),
		'email'            => array(
			'label'   => __( 'E-mailadres', 'spotlezz' ),
			'type'    => 'email',
			'default' => 'info@spotlezz.nl',
		),
		'address_street'   => array(
			'label'   => __( 'Straat + huisnummer', 'spotlezz' ),
			'type'    => 'text',
			'default' => 'Spinnakerplantsoen 38',
		),
		'address_postcode' => array(
			'label'   => __( 'Postcode', 'spotlezz' ),
			'type'    => 'text',
			'default' => '1319 DG',
		),
		'address_city'     => array(
			'label'   => __( 'Plaats (hoofdvestiging)', 'spotlezz' ),
			'type'    => 'text',
			'default' => 'Almere',
		),
		'kvk'              => array(
			'label'   => __( 'KVK-nummer', 'spotlezz' ),
			'type'    => 'text',
			'default' => '42089069',
		),
		'opening_hours'    => array(
			'label'   => __( 'Openingstijden', 'spotlezz' ),
			'type'    => 'text',
			'default' => 'Ma t/m vr 08:00 tot 18:00',
		),
		'review_score'     => array(
			'label'   => __( 'Reviewscore (weergave, bv. 4,8)', 'spotlezz' ),
			'type'    => 'text',
			'default' => '4,8',
		),
		'review_score_raw' => array(
			'label'   => __( 'Reviewscore (schema, bv. 4.8)', 'spotlezz' ),
			'type'    => 'text',
			'default' => '4.8',
		),
		'review_count'     => array(
			'label'   => __( 'Aantal beoordelingen', 'spotlezz' ),
			'type'    => 'number',
			'default' => '87',
		),
		'google_maps_url'  => array(
			'label'   => __( 'Google Bedrijfsprofiel-URL', 'spotlezz' ),
			'type'    => 'url',
			'default' => 'https://maps.app.goo.gl/7RzGUeLmPhhdLbwo7',
		),
		'linkedin_founder' => array(
			'label'   => __( "LinkedIn-profiel oprichter (leeg = geen link tonen)", 'spotlezz' ),
			'type'    => 'url',
			'default' => '',
		),
		'social_instagram' => array(
			'label'   => __( 'Instagram-URL (leeg = geen icoon tonen)', 'spotlezz' ),
			'type'    => 'url',
			'default' => 'https://www.instagram.com/spotlezz.nl/',
		),
		'social_linkedin'  => array(
			'label'   => __( 'LinkedIn-bedrijfspagina-URL (leeg = geen icoon tonen)', 'spotlezz' ),
			'type'    => 'url',
			'default' => 'https://www.linkedin.com/company/spotlezz/',
		),
		'terms_pdf_url'    => array(
			'label'   => __( 'Algemene voorwaarden — PDF-URL', 'spotlezz' ),
			'type'    => 'url',
			'default' => 'https://spotlezz.nl/wp-content/uploads/2026/07/Algemene-voorwaarden-Spotlezz-BV.pdf',
		),
		'form_endpoint'    => array(
			'label'   => __( 'Form-endpoint (leeg = mailto-terugval)', 'spotlezz' ),
			'type'    => 'url',
			'default' => '',
		),

		/**
		 * Page-hero-achtergronden (spotlezz_page_hero() in
		 * inc/components.php): één gedeelde foto per paginatype, zelfde
		 * patroon als op spotlezz.nl zelf — daar deelt elke dienst-
		 * detailpagina, elke locatiepagina, en de klantcase-laag ook al
		 * telkens één vaste achtergrondfoto, geen aparte foto per post.
		 * Defaults wijzen naar de bevestigde, echte foto's die daar nu al
		 * voor gebruikt worden; zodra dit op spotlezz.nl zelf draait is
		 * dat same-origin, geen externe afhankelijkheid meer.
		 */
		'page_hero_pillar'         => array(
			'label'   => __( "Page-hero — dienst-detailpagina's", 'spotlezz' ),
			'type'    => 'url',
			'default' => 'https://spotlezz.nl/wp-content/uploads/2026/01/66cf9f5b0c337de9e5a2c919_image1.webp-4-scaled.jpg',
		),
		'page_hero_diensten_cases' => array(
			'label'   => __( "Page-hero — dienstenhub, klantcases-hub en klantcase-detailpagina's", 'spotlezz' ),
			'type'    => 'url',
			/*
			 * De oude default (sr4-1024x665.jpg) bleek een kaart-thumbnail
			 * met ingebakken tekst ("Kinderopvang schoonmaak →") en een
			 * eigen afgeronde rand/schaduw te zijn — bedoeld als klein
			 * branche-kaartje, niet als full-bleed hero-achtergrond. Op
			 * checklist/offerte/contact/vacatures/klantcases zag je dus
			 * die ingebakken rand als een "afgesneden" foto, plús een
			 * tweede, verkeerde titel onder onze eigen H1. Vervangen door
			 * dezelfde schone, ongecropte foto als page_hero_locaties.
			 */
			'default' => 'https://spotlezz.nl/wp-content/uploads/2026/02/professionele-schoonmaak.jpg',
		),
		'page_hero_locaties'       => array(
			'label'   => __( "Page-hero — locatiepagina's en locatiehub", 'spotlezz' ),
			'type'    => 'url',
			'default' => 'https://spotlezz.nl/wp-content/uploads/2026/02/professionele-schoonmaak.jpg',
		),
		'page_hero_vragen'         => array(
			'label'   => __( 'Page-hero — FAQ-hub en FAQ-detailpagina\'s', 'spotlezz' ),
			'type'    => 'url',
			'default' => 'https://spotlezz.nl/wp-content/uploads/2026/01/we-visit-your-office.jpg',
		),

		/**
		 * Gedeelde reviews (fase 4C, WORDPRESS-BUILD-PLAN §5-beslissing 1,
		 * APPROVED): dezelfde 3 reviews op homepage, elke pillar en elke
		 * locatiepagina — één keer invullen, overal hergebruikt via
		 * spotlezz_reviews_block() in inc/components.php. Was tot fase 4C
		 * een los ACF-veldenset per homepage (group_spotlezz_homepage);
		 * verplaatst hierheen zodat andere paginatypes ze niet hoeven te
		 * dupliceren. Bewust leeg als default — een review verzin je niet.
		 */
		/*
		 * Foto-URL toont het klantlogo (Kobelco/Wilmar/Arena Gym) i.p.v.
		 * een portret — er is geen bevestigd echt portret per reviewer,
		 * wél een bevestigd echt klantlogo. Naam/functie staan daarom ook
		 * op het bedrijf i.p.v. een persoonsnaam, zodat naam en getoonde
		 * afbeelding bij elkaar passen. Bewust lege defaults — de echte
		 * waarden staan in de database (Site Options-scherm), niet
		 * hardcoded hier.
		 */
		'review_1_quote'   => array( 'label' => __( 'Review 1 — quote', 'spotlezz' ), 'type' => 'text', 'default' => '' ),
		'review_1_name'    => array( 'label' => __( 'Review 1 — naam', 'spotlezz' ), 'type' => 'text', 'default' => '' ),
		'review_1_role'    => array( 'label' => __( 'Review 1 — functie / bedrijf', 'spotlezz' ), 'type' => 'text', 'default' => '' ),
		'review_1_photo'   => array( 'label' => __( 'Review 1 — foto-URL (optioneel)', 'spotlezz' ), 'type' => 'url', 'default' => '' ),
		'review_2_quote'   => array( 'label' => __( 'Review 2 — quote', 'spotlezz' ), 'type' => 'text', 'default' => '' ),
		'review_2_name'    => array( 'label' => __( 'Review 2 — naam', 'spotlezz' ), 'type' => 'text', 'default' => '' ),
		'review_2_role'    => array( 'label' => __( 'Review 2 — functie / bedrijf', 'spotlezz' ), 'type' => 'text', 'default' => '' ),
		'review_2_photo'   => array( 'label' => __( 'Review 2 — foto-URL (optioneel)', 'spotlezz' ), 'type' => 'url', 'default' => '' ),
		'review_3_quote'   => array( 'label' => __( 'Review 3 — quote', 'spotlezz' ), 'type' => 'text', 'default' => '' ),
		'review_3_name'    => array( 'label' => __( 'Review 3 — naam', 'spotlezz' ), 'type' => 'text', 'default' => '' ),
		'review_3_role'    => array( 'label' => __( 'Review 3 — functie / bedrijf', 'spotlezz' ), 'type' => 'text', 'default' => '' ),
		'review_3_photo'   => array( 'label' => __( 'Review 3 — foto-URL (optioneel)', 'spotlezz' ), 'type' => 'url', 'default' => '' ),

		/**
		 * Gedeelde werkwijze + vergelijkingstabel (fase 4C, beslissing 3,
		 * APPROVED): identiek op elke pillar-pagina, dus hier één keer i.p.v.
		 * per pillar. Defaults zijn de al bestaande, goedgekeurde teksten
		 * van de huidige site (spotlezz.vercel.app) — niet verzonnen, alleen
		 * hierheen overgenomen zodat de pagina nooit leeg is.
		 */
		'stap_1_titel'     => array( 'label' => __( 'Werkwijze stap 1 — titel', 'spotlezz' ), 'type' => 'text', 'default' => 'Wij bezoeken je bedrijf' ),
		'stap_1_tekst'     => array( 'label' => __( 'Werkwijze stap 1 — tekst', 'spotlezz' ), 'type' => 'text', 'default' => 'Het begint met een bezoek aan jouw bedrijf. We bespreken samen de wensen, frequentie en maken een schoonmaakplan.' ),
		'stap_2_titel'     => array( 'label' => __( 'Werkwijze stap 2 — titel', 'spotlezz' ), 'type' => 'text', 'default' => 'Je ontvangt een offerte op maat' ),
		'stap_2_tekst'     => array( 'label' => __( 'Werkwijze stap 2 — tekst', 'spotlezz' ), 'type' => 'text', 'default' => 'Op basis van jouw wensen ontvang je van ons een offerte op maat. Daarin staat heel helder wat je van ons mag verwachten.' ),
		'stap_3_titel'     => array( 'label' => __( 'Werkwijze stap 3 — titel', 'spotlezz' ), 'type' => 'text', 'default' => 'We gaan voor je aan de slag' ),
		'stap_3_tekst'     => array( 'label' => __( 'Werkwijze stap 3 — tekst', 'spotlezz' ), 'type' => 'text', 'default' => 'Jouw eigen vaste schoonmaakteam gaat voor je aan de slag. Met frisse energie en onze unieke Spotlezz-aanpak.' ),
		'stap_4_titel'     => array( 'label' => __( 'Werkwijze stap 4 — titel', 'spotlezz' ), 'type' => 'text', 'default' => 'Je ziet het verschil' ),
		'stap_4_tekst'     => array( 'label' => __( 'Werkwijze stap 4 — tekst', 'spotlezz' ), 'type' => 'text', 'default' => 'Al na de eerste schoonmaakbeurt zie je het verschil: constante kwaliteit, oog voor detail en een vlekkeloze werkplek.' ),
		'vgl_spotlezz_1'   => array( 'label' => __( 'Vergelijking — Spotlezz, regel 1', 'spotlezz' ), 'type' => 'text', 'default' => 'Toegewijd en vast team' ),
		'vgl_spotlezz_2'   => array( 'label' => __( 'Vergelijking — Spotlezz, regel 2', 'spotlezz' ), 'type' => 'text', 'default' => 'Eén vast aanspreekpunt' ),
		'vgl_spotlezz_3'   => array( 'label' => __( 'Vergelijking — Spotlezz, regel 3', 'spotlezz' ), 'type' => 'text', 'default' => 'Wekelijkse kwaliteitscontroles' ),
		'vgl_spotlezz_4'   => array( 'label' => __( 'Vergelijking — Spotlezz, regel 4', 'spotlezz' ), 'type' => 'text', 'default' => 'Spotlezz-checklist' ),
		'vgl_spotlezz_5'   => array( 'label' => __( 'Vergelijking — Spotlezz, regel 5', 'spotlezz' ), 'type' => 'text', 'default' => '24/7 bereikbaar' ),
		'vgl_anderen_1'    => array( 'label' => __( 'Vergelijking — Andere bedrijven, regel 1', 'spotlezz' ), 'type' => 'text', 'default' => 'Wisselend personeel' ),
		'vgl_anderen_2'    => array( 'label' => __( 'Vergelijking — Andere bedrijven, regel 2', 'spotlezz' ), 'type' => 'text', 'default' => 'Onduidelijke communicatie' ),
		'vgl_anderen_3'    => array( 'label' => __( 'Vergelijking — Andere bedrijven, regel 3', 'spotlezz' ), 'type' => 'text', 'default' => 'Geen meetbare kwaliteit' ),
		'vgl_anderen_4'    => array( 'label' => __( 'Vergelijking — Andere bedrijven, regel 4', 'spotlezz' ), 'type' => 'text', 'default' => 'Routinematig schoonmaakwerk' ),
		'vgl_anderen_5'    => array( 'label' => __( 'Vergelijking — Andere bedrijven, regel 5', 'spotlezz' ), 'type' => 'text', 'default' => 'Alleen beschikbaar tijdens kantooruren' ),
	);
}

/**
 * ACF-pad: registreer een Options Page + veldgroep, maar alleen als ACF Pro
 * (met acf_add_options_page) daadwerkelijk actief is. Geen simulatie.
 */
function spotlezz_register_acf_site_options() {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	acf_add_options_page(
		array(
			'page_title' => __( 'Site Options', 'spotlezz' ),
			'menu_title' => __( 'Site Options', 'spotlezz' ),
			'menu_slug'  => 'spotlezz-site-options',
			'capability' => 'manage_options',
			'redirect'   => false,
			'icon_url'   => 'dashicons-admin-generic',
		)
	);

	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$fields = array();
	foreach ( spotlezz_site_option_fields() as $key => $config ) {
		$fields[] = array(
			'key'           => 'field_spotlezz_option_' . $key,
			'label'         => $config['label'],
			'name'          => $key,
			'type'          => 'text' === $config['type'] ? 'text' : $config['type'],
			'default_value' => $config['default'],
		);
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_spotlezz_site_options',
			'title'    => __( 'Site Options (NAP, contact, schema)', 'spotlezz' ),
			'fields'   => $fields,
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'spotlezz-site-options',
					),
				),
			),
		)
	);
}
add_action( 'acf/init', 'spotlezz_register_acf_site_options' );

/**
 * Native fallback-pad: alleen actief als ACF er niet is, zodat NAP-beheer
 * nooit ontbreekt in de periode voordat ACF geïnstalleerd wordt.
 */
function spotlezz_register_native_options_page() {
	if ( function_exists( 'acf_add_options_page' ) ) {
		return; // ACF is er — geen dubbele pagina.
	}

	add_menu_page(
		__( 'Spotlezz Site Options', 'spotlezz' ),
		__( 'Site Options', 'spotlezz' ),
		'manage_options',
		'spotlezz-site-options',
		'spotlezz_render_native_options_page',
		'dashicons-admin-generic',
		61
	);
}
add_action( 'admin_menu', 'spotlezz_register_native_options_page' );

function spotlezz_register_native_option_settings() {
	if ( function_exists( 'acf_add_options_page' ) ) {
		return;
	}
	foreach ( spotlezz_site_option_fields() as $key => $config ) {
		register_setting( 'spotlezz_site_options', 'spotlezz_' . $key );
	}
}
add_action( 'admin_init', 'spotlezz_register_native_option_settings' );

/**
 * Render de native fallback-pagina. Simpele Settings API — geen ACF-look,
 * bewust géén poging om ACF na te bootsen.
 */
function spotlezz_render_native_options_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Spotlezz Site Options', 'spotlezz' ); ?></h1>
		<p>
			<?php
			esc_html_e(
				'Tijdelijke instellingenpagina zolang ACF nog niet actief is. Zodra ACF Pro geïnstalleerd wordt, verschijnt dezelfde inhoud automatisch als ACF Options-pagina en kan deze pagina vervallen.',
				'spotlezz'
			);
			?>
		</p>
		<form method="post" action="options.php">
			<?php settings_fields( 'spotlezz_site_options' ); ?>
			<table class="form-table" role="presentation">
				<?php foreach ( spotlezz_site_option_fields() as $key => $config ) : ?>
					<tr>
						<th scope="row">
							<label for="spotlezz_<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $config['label'] ); ?></label>
						</th>
						<td>
							<input
								type="<?php echo esc_attr( $config['type'] ); ?>"
								id="spotlezz_<?php echo esc_attr( $key ); ?>"
								name="spotlezz_<?php echo esc_attr( $key ); ?>"
								value="<?php echo esc_attr( get_option( 'spotlezz_' . $key, $config['default'] ) ); ?>"
								class="regular-text"
							/>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
