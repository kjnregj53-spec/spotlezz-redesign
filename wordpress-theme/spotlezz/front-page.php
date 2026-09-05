<?php
/**
 * Homepage — fase 4B, herschikt (na-4C) om de sectievolgorde van
 * spotlezz.nl te volgen: Hero → USP → Diensten → Wat onze klanten zeggen →
 * Werkwijze/vergelijking → Spotlezz-check → Eigen foto's → Reviews →
 * Klantcases → Kwaliteit-stats → Oprichter → Werkgebied → FAQ → Contact.
 *
 * Volledige opbouw volgens wireframe-5-homepage-FINAL.html en
 * WORDPRESS-BUILD-PLAN.md §3.1. Navigatie, next-hop, schema-logica en
 * interne-link-logica blijven theme-code (locked); alleen tekst en
 * afbeeldingen komen uit ACF (inc/acf-homepage.php). Diensten- en
 * werkgebiedblok hebben bewust geen ACF-veld — die tonen automatisch alle
 * gepubliceerde pillar-/locatie-posts, zodat een tegel nooit zonder link
 * kan bestaan (harde regel 8) en nooit naar een niet-bestaande post kan
 * wijzen (harde regel 7).
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$page_id = get_the_ID();

/* ==================================================================
 * 1-2. Hero (full-bleed — APPROVED WORDPRESS-BUILD-PLAN §5.1)
 * ================================================================== */
$hero_image      = spotlezz_field( 'hero_background_image', $page_id, null );
$hero_image_url  = is_array( $hero_image ) ? ( $hero_image['url'] ?? '' ) : '';
$hero_style      = $hero_image_url ? ' style="background-image:url(' . esc_url( $hero_image_url ) . ')"' : '';
?>

<section class="hero hero-full-bleed<?php echo $hero_image_url ? '' : ' hero-placeholder'; ?>"<?php echo $hero_style; // phpcs:ignore -- $hero_style is built with esc_url() above. ?>>
	<div class="hero-overlay"></div>
	<div class="hero-content">
		<span class="trust-badge">
			<?php spotlezz_review_badge(); ?>
		</span>

		<?php $hero_kicker = spotlezz_field( 'hero_kicker', $page_id, __( "Voor kantoren, hotels en VvE's", 'spotlezz' ) ); ?>
		<?php if ( $hero_kicker ) : ?>
			<p class="hero-kicker"><?php echo esc_html( $hero_kicker ); ?></p>
		<?php endif; ?>

		<?php
		/*
		 * Laatste woord (de plaatsnaam) krijgt de referentie's blauwe
		 * accentkleur via <span> — 1-op-1 van .hero h1 span op
		 * spotlezz.vercel.app (`Schoonmaakbedrijf in <span>Almere</span>`).
		 */
		$hero_h1       = spotlezz_field( 'hero_h1', $page_id, __( 'Schoonmaakbedrijf in Almere', 'spotlezz' ) );
		$hero_h1_words = explode( ' ', trim( $hero_h1 ) );
		$hero_h1_city  = array_pop( $hero_h1_words );
		?>
		<h1>
			<?php if ( ! empty( $hero_h1_words ) ) : ?>
				<?php echo esc_html( implode( ' ', $hero_h1_words ) ); ?> <span><?php echo esc_html( $hero_h1_city ); ?></span>
			<?php else : ?>
				<?php echo esc_html( $hero_h1_city ); ?>
			<?php endif; ?>
		</h1>
		<?php $hero_h2 = spotlezz_field( 'hero_h2', $page_id, __( 'Schoon. Schoner. Spotlezz.', 'spotlezz' ) ); ?>
		<?php if ( $hero_h2 ) : ?>
			<h2><?php echo esc_html( $hero_h2 ); ?></h2>
		<?php endif; ?>

		<?php $hero_intro = spotlezz_field( 'hero_intro', $page_id, '' ); ?>
		<?php if ( $hero_intro ) : ?>
			<p class="hero-intro"><?php echo esc_html( $hero_intro ); ?></p>
		<?php endif; ?>

		<div class="hero-buttons">
			<a href="<?php echo esc_url( home_url( '/offerte-aanvragen/' ) ); ?>" class="btn btn-orange"><?php esc_html_e( 'Offerte aanvragen', 'spotlezz' ); ?></a>
			<a href="<?php echo esc_url( home_url( '/checklist/' ) ); ?>" class="btn btn-outline-white"><?php esc_html_e( 'Doe de Spotlezz-check', 'spotlezz' ); ?></a>
		</div>

		<?php if ( ! $hero_image_url && current_user_can( 'edit_theme_options' ) ) : ?>
			<?php
			/**
			 * Deze note zat voorheen als los element ná .hero-content, direct
			 * in .hero-full-bleed — dat is een flex-container (row), dus een
			 * tweede flex-item ging naast .hero-content staan i.p.v. eronder,
			 * en trok de hele pagina breder dan de viewport. Verplaatst naar
			 * bínnen .hero-content, waar hij gewoon in de normale block-flow
			 * onder de knoppen valt. Dit was de daadwerkelijke bron van de
			 * mobile-overflow-bevinding uit de fase-4B-preview — zie
			 * PREVIEW-FIXES-REPORT.md.
			 */
			?>
			<p class="placeholder-note">
				<?php esc_html_e( 'Tijdelijke placeholder: hero-achtergrondfoto ontbreekt nog (wacht op klantfotografie). Alleen zichtbaar voor beheerders.', 'spotlezz' ); ?>
			</p>
		<?php endif; ?>
	</div>

	<?php
	/**
	 * Chat-pill — 1-op-1 van .chat-widget-pill: linkt naar de echte,
	 * bestaande /contact/-pagina (geen WhatsApp-nummer bevestigd, dus geen
	 * externe link verzinnen).
	 */
	/*
	 * Deze pill linkt naar /contact/, waar Thirza het genoemde
	 * aanspreekpunt is — de avatar moet dus haar eigen bevestigde foto
	 * zijn (founder_photo), niet een anonieme teamfoto. Valt terug op de
	 * oude teamfoto als er (nog) geen founder-portret is ingevuld.
	 */
	$chat_founder_photo = spotlezz_field( 'founder_photo', $page_id, null );
	$chat_avatar_url    = is_array( $chat_founder_photo ) ? ( $chat_founder_photo['sizes']['thumbnail'] ?? $chat_founder_photo['url'] ?? '' ) : '';
	if ( ! $chat_avatar_url ) {
		$chat_avatar_url = wp_get_attachment_image_url( 122, 'thumbnail' ); // professionele-schoonmaak.jpg, fallback
	}
	?>
	<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="chat-widget-pill">
		<span class="chat-pill-text">
			<span class="chat-pill-title"><?php esc_html_e( 'Vragen?', 'spotlezz' ); ?></span>
			<span class="chat-pill-subtitle"><?php esc_html_e( 'Stuur ons een bericht', 'spotlezz' ); ?></span>
		</span>
		<span class="chat-pill-avatar">
			<?php if ( $chat_avatar_url ) : ?>
				<img src="<?php echo esc_url( $chat_avatar_url ); ?>" alt="" loading="lazy" decoding="async">
			<?php endif; ?>
			<span class="online-dot" aria-hidden="true"></span>
		</span>
	</a>
</section>

<?php
/* ==================================================================
 * 3. Antwoordblok
 * ================================================================== */
$trust_intro = spotlezz_field( 'trust_intro', $page_id, '' );

/**
 * ACF-Free-compatibel: 4 losse veldparen i.p.v. een repeater (zie
 * inc/acf-homepage.php). Nog steeds exact 4 stats, alleen de opslagvorm
 * veranderde. Elk paar valt individueel terug op zijn eigen default, zodat
 * een gedeeltelijk ingevuld veld nooit een lege tegel oplevert.
 */
$default_stats = array(
	1 => array(
		'value' => __( 'Zakelijk', 'spotlezz' ),
		'label' => __( 'Geen particulieren', 'spotlezz' ),
	),
	2 => array(
		'value' => '< 12 uur',
		'label' => __( 'Afspraak', 'spotlezz' ),
	),
	3 => array(
		'value' => spotlezz_get_option( 'address_city', 'Almere' ) . ' e.o.',
		'label' => __( 'Werkgebied', 'spotlezz' ),
	),
	4 => array(
		'value' => '94%',
		'label' => __( 'Verlengt contract', 'spotlezz' ),
	),
);
$stats_source = array();
foreach ( $default_stats as $i => $fallback ) {
	$stats_source[] = array(
		'value' => spotlezz_field( "stat_{$i}_value", $page_id, $fallback['value'] ),
		'label' => spotlezz_field( "stat_{$i}_label", $page_id, $fallback['label'] ),
	);
}
?>
<section class="answer-block">
	<?php if ( $trust_intro ) : ?>
		<p class="answer-intro"><?php echo esc_html( $trust_intro ); ?></p>
	<?php endif; ?>
	<?php spotlezz_stat_block( $stats_source ); ?>
</section>

<?php
/* ==================================================================
 * 4. Diensten · twee assen — GEEN ACF, automatisch uit gepubliceerde
 *    pillar-posts. Regel 8: elke tegel is altijd een echte link.
 *    Onderscheid tussen de twee assen: een pillar met minimaal één term
 *    in de 'branche'-taxonomie hoort bij "Voor wie"; een pillar zonder
 *    branche-term hoort bij "Wat we doen" (de vier nieuwe specialismen).
 * ================================================================== */
$all_pillars   = get_posts(
	array(
		'post_type'      => 'pillar',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order title',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	)
);
$branche_axis  = array();
$dienst_axis   = array();
foreach ( $all_pillars as $pillar ) {
	if ( has_term( '', 'branche', $pillar ) ) {
		$branche_axis[] = $pillar;
	} else {
		$dienst_axis[] = $pillar;
	}
}
?>
<?php
/* ==================================================================
 * 4c. Branche-grid — 1-op-1 overgenomen (zelfde classnamen, zelfde markup-
 *    structuur) van spotlezz.vercel.app/index.html: foto-kaart met een
 *    donkere scrim-overlay en de titel + pijl eronderop, GEEN aparte
 *    kleurvlak-tekstkolom. Dit is de referentie-aanpak waar geen kritiek
 *    op kwam; de eigen, correcte foto per dienst (niet de deels
 *    hergebruikte foto's van de referentie).
 * ================================================================== */
/**
 * Let op: de eerder gebruikte foto's (163-168, "kantoor.jpg" etc.,
 * gedownload van de live Elementor-secties) bleken een ingebakken tekst-
 * opschrift in de foto zelf te hebben — samen met dit label erbovenop gaf
 * dat zichtbaar dubbele tekst. Hier daarom de "-schoon"-varianten die de
 * referentie zelf voor dit exacte kaart-patroon gebruikt: gewone foto's
 * zonder ingebakken tekst.
 */
$branche_fotos = array(
	'kantoor-schoonmaak'      => 114, // branche-kantoor-schoon
	'hotel-schoonmaak'        => 100, // case-kuchentreff-schoon
	'showroom-schoonmaak'     => 106, // pand-interieur-schoon
	'sportschool-schoonmaak'  => 104, // team-aan-het-werk-schoon
	'kinderopvang-schoonmaak' => 102, // case-arena-gym-schoon
	'vve-schoonmaak'          => 116, // branche-vve-schoon
);
$branche_cards = array();
foreach ( $branche_fotos as $slug => $attachment_id ) {
	$pillar = get_page_by_path( $slug, OBJECT, 'pillar' );
	if ( ! $pillar || 'publish' !== $pillar->post_status ) {
		continue;
	}
	$foto_url = wp_get_attachment_image_url( $attachment_id, 'large' );
	if ( ! $foto_url ) {
		continue;
	}
	$branche_cards[] = array(
		'pillar'   => $pillar,
		'foto_url' => $foto_url,
	);
}
?>
<?php if ( ! empty( $branche_cards ) ) : ?>
<section class="services-block">
	<h3 class="services-axis-title services-axis-branche"><?php esc_html_e( 'Voor wie (branche)', 'spotlezz' ); ?></h3>
	<div class="branche-grid">
		<?php foreach ( $branche_cards as $card ) : ?>
			<a href="<?php echo esc_url( get_permalink( $card['pillar'] ) ); ?>" class="branche-card" aria-label="<?php echo esc_attr( sprintf( /* translators: %s: diensttitel */ __( 'Lees meer over %s', 'spotlezz' ), get_the_title( $card['pillar'] ) ) ); ?>">
				<img src="<?php echo esc_url( $card['foto_url'] ); ?>" alt="" class="branche-img" loading="lazy" decoding="async">
				<div class="branche-scrim"></div>
				<span class="branche-label"><?php echo esc_html( get_the_title( $card['pillar'] ) ); ?> <span class="branche-arrow" aria-hidden="true">&rarr;</span></span>
			</a>
		<?php endforeach; ?>
	</div>
</section>
<?php endif; ?>

<?php
/**
 * "Wat we doen (dienst)" tegel-grid — na de branche-grid, zoals op
 * spotlezz.vercel.app: eerst "Voor wie (branche)", dan "Wat we doen
 * (dienst)". De 4 nieuwe specialismen hebben nog geen eigen foto/rijk
 * homepage-blok, dus blijven een eenvoudige tegel-grid.
 */
?>
<?php if ( $dienst_axis ) : ?>
<section class="services-block" id="diensten">
	<h3 class="services-axis-title services-axis-dienst"><?php esc_html_e( 'Wat we doen (dienst)', 'spotlezz' ); ?></h3>
	<div class="services-grid">
		<?php foreach ( $dienst_axis as $pillar ) : ?>
			<a class="service-tile" href="<?php echo esc_url( get_permalink( $pillar ) ); ?>">
				<?php $thumb_url = get_the_post_thumbnail_url( $pillar, 'spotlezz-card' ); ?>
				<?php if ( $thumb_url ) : ?>
					<img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( spotlezz_post_thumbnail_alt( $pillar->ID, get_the_title( $pillar ) ) ); ?>" loading="lazy" decoding="async">
				<?php endif; ?>
				<span class="service-tile-label"><?php echo esc_html( get_the_title( $pillar ) ); ?></span>
			</a>
		<?php endforeach; ?>
	</div>
</section>
<?php elseif ( current_user_can( 'edit_theme_options' ) ) : ?>
	<p class="placeholder-note content-placeholder"><?php esc_html_e( 'Nog geen diensten (pillar-posts) gepubliceerd. Dit blok verschijnt automatisch zodra dat wel zo is.', 'spotlezz' ); ?></p>
<?php endif; ?>

<?php
/* ==================================================================
 * 5. Vergelijkingssectie ("Wat is het verschil tussen schoon en
 *    Spotlezz?") — 1-op-1 markup/classnamen van spotlezz.vercel.app
 *    (.comparison-section/.compare-card/.compare-spotlezz/.compare-
 *    others), i.p.v. de eerdere eigen benadering.
 * ================================================================== */
?>
<section class="comparison-section">
	<div class="comparison-header">
		<h2><?php esc_html_e( 'Wat is het', 'spotlezz' ); ?> <span><?php esc_html_e( 'verschil', 'spotlezz' ); ?></span> <?php esc_html_e( 'tussen schoon en Spotlezz?', 'spotlezz' ); ?></h2>
		<p><?php esc_html_e( 'Spotlezz is een jonge en snelgroeiende organisatie met maar één doel: Perfectie. Dat doen wij met gemotiveerd, vast personeel, duurzame producten en navulverpakkingen, en oog voor detail.', 'spotlezz' ); ?></p>
	</div>
	<div class="comparison-grid">
		<div class="compare-card compare-spotlezz">
			<h3>Spotlezz</h3>
			<ul class="compare-list">
				<li><?php esc_html_e( 'Toegewijd en vast team', 'spotlezz' ); ?></li>
				<li><?php esc_html_e( 'Eén vast aanspreekpunt', 'spotlezz' ); ?></li>
				<li><?php esc_html_e( 'Wekelijkse kwaliteitscontroles', 'spotlezz' ); ?></li>
				<li><?php esc_html_e( 'Spotlezz-checklist', 'spotlezz' ); ?></li>
				<li><?php esc_html_e( '24/7 bereikbaar', 'spotlezz' ); ?></li>
			</ul>
		</div>
		<div class="compare-card compare-others">
			<h3><?php esc_html_e( 'Andere bedrijven', 'spotlezz' ); ?></h3>
			<ul class="compare-list">
				<li><?php esc_html_e( 'Wisselend personeel', 'spotlezz' ); ?></li>
				<li><?php esc_html_e( 'Onduidelijke communicatie', 'spotlezz' ); ?></li>
				<li><?php esc_html_e( 'Geen meetbare kwaliteit', 'spotlezz' ); ?></li>
				<li><?php esc_html_e( 'Routinematig schoonmaakwerk', 'spotlezz' ); ?></li>
				<li><?php esc_html_e( 'Alleen beschikbaar tijdens kantooruren', 'spotlezz' ); ?></li>
			</ul>
		</div>
	</div>
</section>

<?php
/* ==================================================================
 * 5b. Grote checklist-banner — 1-op-1 van .lead-magnet-section
 *    (id="check") op spotlezz.vercel.app: donkere foto-achtergrond,
 *    tekst + e-mailform. Stond eerder als sectie 17 helemaal onderaan
 *    de pagina — op klantfeedback direct onder de vergelijkingssectie
 *    gezet i.p.v. verderop.
 * ================================================================== */
$check_bg_id  = 118; // checklist-achtergrond.jpg (al eerder geimporteerd, echte foto)
$check_bg_url = wp_get_attachment_image_url( $check_bg_id, 'full' );
?>
<section id="check" class="lead-magnet-section"<?php echo $check_bg_url ? ' style="background-image:url(' . esc_url( $check_bg_url ) . ')"' : ''; ?>>
	<div class="lead-magnet-overlay"></div>
	<div class="lead-magnet-content">
		<h2><?php echo esc_html( spotlezz_field( 'lead_magnet_title', $page_id, __( 'De Spotlezz-check', 'spotlezz' ) ) ); ?></h2>
		<p><?php echo esc_html( spotlezz_field( 'lead_magnet_description', $page_id, __( 'Ontdek in 1 minuut of je huidige schoonmaak de juiste is. Vul je e-mail in en ontvang de checklist in je mailbox.', 'spotlezz' ) ) ); ?></p>
		<form class="sp-form checklist-form" onsubmit="return false;">
			<div class="form-group">
				<label for="home-checklist-email"><?php esc_html_e( 'E-mailadres', 'spotlezz' ); ?></label>
				<input type="email" id="home-checklist-email" name="email" autocomplete="email" required>
			</div>
			<div class="form-consent">
				<input type="checkbox" id="home-checklist-akkoord" name="akkoord" required>
				<label for="home-checklist-akkoord">
					<?php
					printf(
						/* translators: %s: link naar privacybeleid */
						esc_html__( 'Akkoord met het %s.', 'spotlezz' ),
						'<a href="' . esc_url( home_url( '/privacybeleid/' ) ) . '">' . esc_html__( 'privacybeleid', 'spotlezz' ) . '</a>'
					);
					?>
				</label>
			</div>
			<button type="submit" class="btn btn-orange"><?php echo esc_html( spotlezz_field( 'lead_magnet_cta_label', $page_id, __( 'Vraag de checklist aan', 'spotlezz' ) ) ); ?></button>
		</form>
	</div>
</section>

<?php
/* ==================================================================
 * 9. Eigen fotografie
 * ================================================================== */
/**
 * ACF-Free-compatibel: 3 losse foto+bijschrift-velden i.p.v. een repeater
 * (zie inc/acf-homepage.php). Nog steeds exact 3 foto's — alleen de
 * opslagvorm veranderde, niet het aantal.
 */
$photo_defaults = array(
	1 => __( 'Team aan het werk', 'spotlezz' ),
	2 => __( 'Het pand of de ruimte', 'spotlezz' ),
	3 => __( 'Materiaal en producten', 'spotlezz' ),
);
$photography = array();
foreach ( $photo_defaults as $i => $default_caption ) {
	$photography[] = array(
		'photo'   => spotlezz_field( "photo_{$i}", $page_id, null ),
		'caption' => spotlezz_field( "photo_{$i}_caption", $page_id, $default_caption ),
	);
}
?>
<section class="photography-block">
	<h2><?php esc_html_e( 'Spotlezz in de praktijk', 'spotlezz' ); ?></h2>
	<div class="photography-grid">
		<?php foreach ( $photography as $item ) : ?>
			<?php
			$photo   = $item['photo'];
			$caption = $item['caption'];
			$has_photo = is_array( $photo ) && ! empty( $photo['url'] );
			?>
			<figure class="photography-item">
				<?php if ( $has_photo ) : ?>
					<?php
					/*
					 * De harde 'spotlezz-card'-crop (800x520) snijdt bij een
					 * staand bronbeeld (bv. de stoomdweil-foto, 512x640) zowel
					 * de hand bovenin als de dweilkop onderin weg — WordPress'
					 * center-crop houdt dan alleen de kale steel over. Voor
					 * die foto wordt daarom het onbewerkte beeld gebruikt met
					 * een eigen object-position (steel + dweilkop behouden,
					 * boven mag wijken) i.p.v. de vooraf hard gecropte maat.
					 */
					$is_tall_source = ( $photo['height'] ?? 0 ) > ( $photo['width'] ?? 0 );
					$img_src        = $is_tall_source ? $photo['url'] : ( $photo['sizes']['spotlezz-card'] ?? $photo['url'] );
					$img_style      = $is_tall_source ? ' style="object-position:center bottom"' : '';
					?>
					<img src="<?php echo esc_url( $img_src ); ?>"<?php echo $img_style; // phpcs:ignore -- static, no user input ?> alt="<?php echo esc_attr( spotlezz_image_alt( $photo, $caption ) ); ?>" loading="lazy" decoding="async">
					<?php if ( $caption ) : ?>
						<figcaption><?php echo esc_html( $caption ); ?></figcaption>
					<?php endif; ?>
				<?php else : ?>
					<span class="photo-placeholder-box" aria-hidden="true"></span>
					<figcaption><?php echo esc_html( $caption ); ?> <em>(<?php esc_html_e( 'placeholder, wacht op klantfotografie', 'spotlezz' ); ?>)</em></figcaption>
				<?php endif; ?>
			</figure>
		<?php endforeach; ?>
	</div>
</section>

<?php
/* ==================================================================
 * 9b. Klantlogo-ticker — 1-op-1 van .clients-ticker-section: eindeloze
 *    scrollende rij met alle bevestigde echte klantlogo's.
 * ================================================================== */
$ticker_logo_ids = array( 88, 94, 89, 91, 92, 90, 96, 158, 169, 157, 153, 154, 155, 156 ); // kersvers, wilmar, alliance, innovally, mitsubishi-hi, arenagym, logisnext, kobelco, flor, kuchentreff, burgman, woonstudio-joy, event-atelier, powervibe — alle echte klantlogo's van spotlezz.nl ("Onze vertrouwde klanten" + klantcases)
$ticker_logos    = array();
foreach ( $ticker_logo_ids as $attachment_id ) {
	$url = wp_get_attachment_image_url( $attachment_id, 'medium' );
	if ( $url ) {
		$ticker_logos[] = array( 'id' => $attachment_id, 'url' => $url, 'title' => get_the_title( $attachment_id ) );
	}
}
?>
<?php if ( ! empty( $ticker_logos ) ) : ?>
<section class="clients-ticker-section">
	<div class="ticker-header">
		<h2><?php esc_html_e( 'Vertrouwd door toonaangevende bedrijven', 'spotlezz' ); ?></h2>
	</div>
	<div style="overflow:hidden;width:100%;">
		<div class="ticker-container">
			<?php foreach ( array_merge( $ticker_logos, $ticker_logos ) as $logo ) : ?>
				<div class="ticker-logo"><img src="<?php echo esc_url( $logo['url'] ); ?>" alt="<?php echo esc_attr( $logo['title'] ); ?>" loading="lazy" decoding="async"></div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php
/* ==================================================================
 * 10. Reviewblok — gedeeld met pillar/locatie sinds fase 4C, bron is Site
 *    Options, niet meer een homepage-specifiek ACF-veld (WORDPRESS-BUILD-
 *    PLAN §5-beslissing 1, APPROVED). Zichtbare uitvoer ongewijzigd t.o.v.
 *    fase 4B — zie inc/components.php voor de gedeelde implementatie.
 * ================================================================== */
spotlezz_reviews_block();

/* ==================================================================
 * 11. Klantcases ("Onze Projecten") — RELATIONSHIP, alleen bestaande,
 *    gepubliceerde cases. Markup/classnamen 1-op-1 van .portfolio-section
 *    op spotlezz.vercel.app (staggered grid, meta-label, beschrijving,
 *    CTA-knop per kaart — i.p.v. de eerdere eigen .cases-grid opzet).
 * ================================================================== */
$featured_cases = spotlezz_field( 'featured_cases', $page_id, array() );
$featured_cases = array_filter(
	is_array( $featured_cases ) ? $featured_cases : array(),
	function ( $case ) {
		return $case instanceof WP_Post && 'publish' === $case->post_status;
	}
);
if ( ! empty( $featured_cases ) ) :
	?>
	<section id="cases" class="portfolio-section">
		<div class="portfolio-header">
			<h2><?php esc_html_e( 'Onze Projecten', 'spotlezz' ); ?></h2>
			<p><?php esc_html_e( 'Bekijk hoe wij het verschil maken bij onze opdrachtgevers met op maat gemaakte oplossingen.', 'spotlezz' ); ?></p>
		</div>
		<div class="portfolio-grid staggered-grid">
			<?php foreach ( $featured_cases as $i => $case ) : ?>
				<div class="portfolio-card<?php echo 1 === $i % 2 ? ' stagger-down' : ''; ?>">
					<?php $thumb_url = get_the_post_thumbnail_url( $case, 'spotlezz-card' ); ?>
					<?php if ( $thumb_url ) : ?>
						<div class="portfolio-img"><img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( spotlezz_post_thumbnail_alt( $case->ID, get_the_title( $case ) ) ); ?>" loading="lazy" decoding="async"></div>
					<?php endif; ?>
					<div class="portfolio-content">
						<?php $branche = spotlezz_field( 'branche', $case->ID, '' ); ?>
						<?php if ( $branche ) : ?><div class="portfolio-meta"><?php echo esc_html( $branche ); ?></div><?php endif; ?>
						<h3><?php echo esc_html( get_the_title( $case ) ); ?></h3>
						<?php $excerpt = get_the_excerpt( $case ); ?>
						<?php if ( $excerpt ) : ?><p><?php echo esc_html( $excerpt ); ?></p><?php endif; ?>
						<a href="<?php echo esc_url( get_permalink( $case ) ); ?>" class="btn btn-orange"><?php esc_html_e( 'Bekijk case', 'spotlezz' ); ?></a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</section>
	<?php
elseif ( current_user_can( 'edit_theme_options' ) ) :
	?>
	<p class="placeholder-note content-placeholder"><?php esc_html_e( 'Nog geen klantcases geselecteerd in het homepage-veld "Drie klantcases".', 'spotlezz' ); ?></p>
	<?php
endif;

/* ==================================================================
 * 12. Kwaliteitsblok — 1-op-1 van .clean-kwaliteit-section: twee
 *    kolommen, links titel/tekst/2 cijfers, rechts een foto met
 *    zwevende beoordelingsbadge.
 * ================================================================== */
?>
<section class="clean-kwaliteit-section">
	<div class="ck-container">
		<div class="ck-left">
			<h2 class="ck-title"><?php esc_html_e( 'Spotlezz staat voor kwaliteit, continuïteit en', 'spotlezz' ); ?> <span><?php esc_html_e( 'hoge klanttevredenheid', 'spotlezz' ); ?></span></h2>
			<p class="ck-desc"><?php esc_html_e( 'Spotlezz is de overtreffende trap van schoon. Met onze unieke aanpak met vaste schoonmakers, regelmatige controles en evaluaties staan wij voor duurzame en blijvende resultaten en hoge klanttevredenheid.', 'spotlezz' ); ?></p>
			<div class="ck-stats-grid">
				<div class="ck-stat">
					<div class="ck-stat-number"><?php esc_html_e( '4x per jaar', 'spotlezz' ); ?></div>
					<div class="ck-stat-text"><?php esc_html_e( 'Een diepgaand evaluatiegesprek om kwaliteit continu te borgen.', 'spotlezz' ); ?></div>
				</div>
				<div class="ck-stat">
					<div class="ck-stat-number">94%</div>
					<div class="ck-stat-text"><?php esc_html_e( 'Van onze contracten wordt succesvol verlengd door tevreden klanten.', 'spotlezz' ); ?></div>
				</div>
			</div>
		</div>
		<div class="ck-right">
			<div class="ck-image-wrapper">
				<?php $ck_photo = spotlezz_field( 'photo_3', $page_id, null ); ?>
				<?php $ck_photo_url = is_array( $ck_photo ) ? ( $ck_photo['url'] ?? '' ) : ''; ?>
				<?php $ck_is_tall = is_array( $ck_photo ) && ( $ck_photo['height'] ?? 0 ) > ( $ck_photo['width'] ?? 0 ); ?>
				<?php if ( $ck_photo_url ) : ?>
					<img src="<?php echo esc_url( $ck_photo_url ); ?>"<?php echo $ck_is_tall ? ' style="object-position:center bottom"' : ''; // phpcs:ignore -- static, no user input ?> alt="<?php esc_attr_e( 'Spotlezz kwaliteit', 'spotlezz' ); ?>" loading="lazy" decoding="async">
				<?php endif; ?>
				<div class="ck-badge">
					<div class="ck-badge-title"><?php esc_html_e( 'Klantbeoordeling', 'spotlezz' ); ?></div>
					<div class="ck-badge-value">4,8<span>/5</span></div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
/* ==================================================================
 * 13. Oprichter aan het woord — 1-op-1 van de "MENSENWERK"-sectie op
 *    spotlezz.vercel.app: witte kaart (foto, naam, rol, LinkedIn, oranje
 *    accent, quote, CTA) naast een grote foto.
 * ================================================================== */
$founder_photo   = spotlezz_field( 'founder_photo', $page_id, null );
$founder_name    = spotlezz_field( 'founder_name', $page_id, '' );
$founder_photo_url = is_array( $founder_photo ) ? ( $founder_photo['url'] ?? '' ) : '';
if ( $founder_name ) :
	$founder_linkedin = spotlezz_field( 'founder_linkedin', $page_id, '' );
	?>
	<section class="founder-section">
		<div class="founder-grid">
			<div class="founder-card">
				<div class="founder-card-head">
					<?php if ( $founder_photo_url ) : ?>
						<img src="<?php echo esc_url( $founder_photo_url ); ?>" alt="<?php echo esc_attr( $founder_name ); ?>" class="founder-avatar-photo" loading="lazy" decoding="async">
					<?php else : ?>
						<span class="person-avatar" aria-hidden="true"><?php echo esc_html( mb_substr( $founder_name, 0, 1 ) ); ?></span>
					<?php endif; ?>
					<div>
						<h3><?php echo esc_html( $founder_name ); ?></h3>
						<p><?php echo esc_html( spotlezz_field( 'founder_role', $page_id, __( 'Oprichter', 'spotlezz' ) ) ); ?></p>
						<?php if ( $founder_linkedin ) : ?>
							<a href="<?php echo esc_url( $founder_linkedin ); ?>" target="_blank" rel="noopener noreferrer" class="founder-linkedin"><?php esc_html_e( 'LinkedIn-profiel', 'spotlezz' ); ?></a>
						<?php endif; ?>
					</div>
				</div>
				<div class="founder-accent"></div>
				<?php $founder_quote = spotlezz_field( 'founder_quote', $page_id, '' ); ?>
				<?php if ( $founder_quote ) : ?>
					<p class="founder-quote">&ldquo;<?php echo esc_html( $founder_quote ); ?>&rdquo;</p>
				<?php endif; ?>
				<a href="<?php echo esc_url( home_url( '/over-ons/' ) ); ?>" class="btn btn-orange"><?php esc_html_e( 'Lees meer over ons team', 'spotlezz' ); ?></a>
			</div>
			<div class="founder-photo">
				<?php
				/*
				 * Eigen veld ("founder_side_photo"), losgekoppeld van
				 * "photo_2" — die staat óók in "Spotlezz in de praktijk",
				 * en een wijziging hier mocht niet meer automatisch ook
				 * dáár veranderen (expliciet gemeld: de foto naast Thirza
				 * is bewust vervangen, de praktijk-tegel niet). Valt terug
				 * op photo_2 zolang dit veld leeg is. Alt-tekst mag nooit
				 * $founder_name claimen (harde regel WORDPRESS-BUILD-PLAN
				 * §5.2: geen onbevestigde foto onder haar naam).
				 */
				$founder_side_photo = spotlezz_field( 'founder_side_photo', $page_id, null );
				if ( ! is_array( $founder_side_photo ) ) {
					$founder_side_photo = spotlezz_field( 'photo_2', $page_id, null );
				}
				$founder_side_url = is_array( $founder_side_photo ) ? ( $founder_side_photo['url'] ?? '' ) : '';
				?>
				<?php if ( $founder_side_url ) : ?>
					<img src="<?php echo esc_url( $founder_side_url ); ?>" alt="<?php esc_attr_e( 'Spotlezz in overleg met een klant', 'spotlezz' ); ?>" loading="lazy" decoding="async">
				<?php endif; ?>
			</div>
		</div>
		<?php
		add_filter(
			'spotlezz_schema_graph',
			function ( $graph ) use ( $founder_name, $founder_photo_url, $founder_linkedin ) {
				$node = array(
					'@type' => 'Person',
					'name'  => $founder_name,
				);
				if ( $founder_photo_url ) {
					$node['image'] = $founder_photo_url;
				}
				if ( $founder_linkedin ) {
					$node['sameAs'] = $founder_linkedin;
				}
				$graph[] = $node;
				return $graph;
			}
		);
		?>
	</section>
	<?php
endif;

/* ==================================================================
 * 14. Werkgebied — GEEN ACF, automatisch uit gepubliceerde locatie-
 *     posts. Elke pill is altijd een echte link.
 * ================================================================== */
$all_locations = get_posts(
	array(
		'post_type'      => 'locatie',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order title',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	)
);
?>
<?php if ( $all_locations ) : ?>
<section class="werkgebieden-section" id="locaties">
	<div class="werkgebied-grid">
		<div class="locations-content">
			<h2><?php esc_html_e( 'Ons Werkgebied', 'spotlezz' ); ?></h2>
			<p><?php esc_html_e( 'Wij zijn actief in heel Flevoland en omliggende gebieden. Altijd in de buurt voor de beste, snelste en meest betrouwbare service.', 'spotlezz' ); ?></p>
			<div class="location-pills">
				<?php foreach ( $all_locations as $locatie ) : ?>
					<a class="pill" href="<?php echo esc_url( get_permalink( $locatie ) ); ?>"><?php echo esc_html( get_the_title( $locatie ) ); ?></a>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
<?php elseif ( current_user_can( 'edit_theme_options' ) ) : ?>
	<p class="placeholder-note content-placeholder"><?php esc_html_e( 'Nog geen locaties gepubliceerd. Dit blok verschijnt automatisch zodra dat wel zo is.', 'spotlezz' ); ?></p>
<?php endif; ?>

<?php
/* ==================================================================
 * 15. FAQ — RELATIONSHIP, gedeelde renderfunctie sinds fase 4C (zichtbare
 *    uitvoer ongewijzigd t.o.v. fase 4B) — zie inc/components.php.
 * ================================================================== */
spotlezz_faq_block( $page_id );

/* ==================================================================
 * 16. Contactsectie — 1-op-1 van .contact-section op spotlezz.vercel.app:
 *    donkere foto-achtergrond met overlay, links tekst + oprichter-profiel,
 *    rechts een wit formulier. Ontbrak volledig op de homepage. Zelfde
 *    regel als elders (PHASE-4C-PLAN.md beslissing 5): visueel formulier,
 *    geen `action`/`method`, verstuurt niets.
 * ================================================================== */
$contact_bg_id  = 122; // professionele-schoonmaak.jpg (al eerder geimporteerd, echte foto)
$contact_bg_url = wp_get_attachment_image_url( $contact_bg_id, 'full' );
?>
<section class="contact-section"<?php echo $contact_bg_url ? ' style="background-image:url(' . esc_url( $contact_bg_url ) . ')"' : ''; ?>>
	<div class="contact-overlay"></div>
	<div class="contact-container">
		<div class="contact-left">
			<h2><?php esc_html_e( 'Neem contact met', 'spotlezz' ); ?><br><?php esc_html_e( 'ons op', 'spotlezz' ); ?></h2>
			<p><?php esc_html_e( 'Ben jij klaar voor de vlekkeloze bedrijfsschoonmaak van Spotlezz? Of heb je een andere vraag over onze diensten? Neem dan vandaag nog contact met ons op.', 'spotlezz' ); ?></p>
			<?php if ( $founder_name ) : ?>
				<div class="contact-profile">
					<?php if ( $founder_photo_url ) : ?>
						<div class="contact-profile-img"><img src="<?php echo esc_url( $founder_photo_url ); ?>" alt="<?php echo esc_attr( $founder_name ); ?>" loading="lazy" decoding="async"></div>
					<?php endif; ?>
					<div class="contact-profile-info">
						<h4><?php echo esc_html( $founder_name ); ?></h4>
						<div class="role"><?php echo esc_html( spotlezz_field( 'founder_role', $page_id, __( 'Oprichter', 'spotlezz' ) ) ); ?></div>
						<?php $phone_raw = spotlezz_get_option( 'phone_raw' ); ?>
						<?php if ( '' !== $phone_raw ) : ?>
							<div class="contact-detail"><b><?php esc_html_e( 'T:', 'spotlezz' ); ?></b> <a href="tel:<?php echo esc_attr( $phone_raw ); ?>"><?php echo esc_html( spotlezz_get_option( 'phone' ) ); ?></a></div>
						<?php endif; ?>
						<?php $email = spotlezz_get_option( 'email' ); ?>
						<?php if ( '' !== $email ) : ?>
							<div class="contact-detail"><b><?php esc_html_e( 'E:', 'spotlezz' ); ?></b> <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></div>
						<?php endif; ?>
						<a href="<?php echo esc_url( home_url( '/over-ons/' ) ); ?>" class="btn btn-orange btn-micro"><?php esc_html_e( 'Meet the team', 'spotlezz' ); ?></a>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<div class="contact-right">
			<div class="contact-form-box">
				<h3><?php esc_html_e( 'Een bericht verzenden', 'spotlezz' ); ?></h3>
				<form class="sp-form" onsubmit="return false;">
					<div class="form-row">
						<div class="form-group">
							<label for="home-contact-naam"><?php esc_html_e( 'Naam', 'spotlezz' ); ?> <span aria-hidden="true">*</span></label>
							<input type="text" id="home-contact-naam" name="naam" autocomplete="name" required>
						</div>
						<div class="form-group">
							<label for="home-contact-bedrijf"><?php esc_html_e( 'Bedrijfsnaam', 'spotlezz' ); ?> <span aria-hidden="true">*</span></label>
							<input type="text" id="home-contact-bedrijf" name="bedrijf" autocomplete="organization" required>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group">
							<label for="home-contact-email"><?php esc_html_e( 'E-mailadres', 'spotlezz' ); ?> <span aria-hidden="true">*</span></label>
							<input type="email" id="home-contact-email" name="email" autocomplete="email" required>
						</div>
						<div class="form-group">
							<label for="home-contact-telefoon"><?php esc_html_e( 'Telefoonnummer', 'spotlezz' ); ?> <span aria-hidden="true">*</span></label>
							<input type="tel" id="home-contact-telefoon" name="telefoon" autocomplete="tel" required>
						</div>
					</div>
					<div class="form-group">
						<label for="home-contact-bericht"><?php esc_html_e( 'Bericht', 'spotlezz' ); ?> <span aria-hidden="true">*</span></label>
						<textarea id="home-contact-bericht" name="bericht" rows="4" required></textarea>
					</div>
					<div class="form-consent">
						<input type="checkbox" id="home-contact-akkoord" name="akkoord" required>
						<label for="home-contact-akkoord">
							<?php
							printf(
								/* translators: %s: link naar privacybeleid */
								esc_html__( 'Ik ga akkoord met het %s en met het opnemen van contact over deze aanvraag.', 'spotlezz' ),
								'<a href="' . esc_url( home_url( '/privacybeleid/' ) ) . '">' . esc_html__( 'privacybeleid', 'spotlezz' ) . '</a>'
							);
							?>
						</label>
					</div>
					<button type="submit" class="btn-submit"><?php esc_html_e( 'Versturen', 'spotlezz' ); ?></button>
				</form>
			</div>
		</div>
	</div>
</section>

<?php
/* ==================================================================
 * 18. Next-hop bar — locked, theme-controlled, exact 3 routes
 * ================================================================== */
spotlezz_next_hop(
	array(
		array(
			'label' => __( 'Omhoog', 'spotlezz' ),
			'title' => __( 'Alle diensten', 'spotlezz' ),
			'url'   => get_post_type_archive_link( 'pillar' ) ?: home_url( '/diensten/' ),
		),
		array(
			'label' => __( 'Zijwaarts', 'spotlezz' ),
			'title' => __( 'Klantcases & locaties', 'spotlezz' ),
			'url'   => get_post_type_archive_link( 'case' ) ?: home_url( '/klantcases/' ),
		),
		array(
			'label' => __( 'Offerte', 'spotlezz' ),
			'title' => __( 'Offerte aanvragen', 'spotlezz' ),
			'url'   => home_url( '/offerte-aanvragen/' ),
		),
	)
);

get_footer();
