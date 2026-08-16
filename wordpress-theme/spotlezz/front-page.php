<?php
/**
 * Homepage — fase 4B.
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

		<h1><?php echo esc_html( spotlezz_field( 'hero_h1', $page_id, __( 'Schoonmaakbedrijf in Almere', 'spotlezz' ) ) ); ?></h1>
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
<?php if ( $branche_axis || $dienst_axis ) : ?>
<section class="services-block" id="diensten">
	<?php if ( $branche_axis ) : ?>
		<h3 class="services-axis-title services-axis-branche"><?php esc_html_e( 'Voor wie (branche)', 'spotlezz' ); ?></h3>
		<div class="services-grid">
			<?php foreach ( $branche_axis as $pillar ) : ?>
				<a class="service-tile" href="<?php echo esc_url( get_permalink( $pillar ) ); ?>">
					<?php $thumb_url = get_the_post_thumbnail_url( $pillar, 'spotlezz-card' ); ?>
					<?php if ( $thumb_url ) : ?>
						<img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( spotlezz_post_thumbnail_alt( $pillar->ID, get_the_title( $pillar ) ) ); ?>" loading="lazy" decoding="async">
					<?php endif; ?>
					<span class="service-tile-label"><?php echo esc_html( get_the_title( $pillar ) ); ?></span>
				</a>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php if ( $dienst_axis ) : ?>
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
	<?php endif; ?>
</section>
<?php else : ?>
	<?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
		<p class="placeholder-note content-placeholder"><?php esc_html_e( 'Nog geen diensten (pillar-posts) gepubliceerd. Dit blok verschijnt automatisch zodra dat wel zo is.', 'spotlezz' ); ?></p>
	<?php endif; ?>
<?php endif; ?>

<?php
/* ==================================================================
 * 4b. Werkgebied — GEEN ACF, automatisch uit gepubliceerde locatie-
 *     posts. Elke pill is altijd een echte link (repareert de audit-
 *     bevinding dat deze pills op de huidige site dode <span>'s zijn).
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
<section class="work-area-block" id="locaties">
	<h2><?php esc_html_e( 'Werkgebied', 'spotlezz' ); ?></h2>
	<div class="location-pills">
		<?php foreach ( $all_locations as $locatie ) : ?>
			<a class="pill" href="<?php echo esc_url( get_permalink( $locatie ) ); ?>"><?php echo esc_html( get_the_title( $locatie ) ); ?></a>
		<?php endforeach; ?>
	</div>
</section>
<?php elseif ( current_user_can( 'edit_theme_options' ) ) : ?>
	<p class="placeholder-note content-placeholder"><?php esc_html_e( 'Nog geen locaties gepubliceerd. Dit blok verschijnt automatisch zodra dat wel zo is.', 'spotlezz' ); ?></p>
<?php endif; ?>

<?php
/* ==================================================================
 * 5. Eigen fotografie
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
					<img src="<?php echo esc_url( $photo['sizes']['spotlezz-card'] ?? $photo['url'] ); ?>" alt="<?php echo esc_attr( spotlezz_image_alt( $photo, $caption ) ); ?>" loading="lazy" decoding="async">
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
 * 6. Reviewblok — gedeeld met pillar/locatie sinds fase 4C, bron is Site
 *    Options, niet meer een homepage-specifiek ACF-veld (WORDPRESS-BUILD-
 *    PLAN §5-beslissing 1, APPROVED). Zichtbare uitvoer ongewijzigd t.o.v.
 *    fase 4B — zie inc/components.php voor de gedeelde implementatie.
 * ================================================================== */
spotlezz_reviews_block();

/* ==================================================================
 * 7. Klantcases — RELATIONSHIP, alleen bestaande, gepubliceerde cases
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
	<section class="cases-block">
		<h2><?php esc_html_e( 'Klantcases', 'spotlezz' ); ?></h2>
		<div class="cases-grid">
			<?php foreach ( $featured_cases as $case ) : ?>
				<a class="case-card" href="<?php echo esc_url( get_permalink( $case ) ); ?>">
					<?php $thumb_url = get_the_post_thumbnail_url( $case, 'spotlezz-card' ); ?>
					<?php if ( $thumb_url ) : ?>
						<img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( spotlezz_post_thumbnail_alt( $case->ID, get_the_title( $case ) ) ); ?>" loading="lazy" decoding="async">
					<?php endif; ?>
					<div class="case-card-body">
						<h3><?php echo esc_html( get_the_title( $case ) ); ?></h3>
						<?php $excerpt = get_the_excerpt( $case ); ?>
						<?php if ( $excerpt ) : ?>
							<p><?php echo esc_html( $excerpt ); ?></p>
						<?php endif; ?>
					</div>
				</a>
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
 * 8. Oprichter — persoonskaart + Person-schema in één aanroep
 * ================================================================== */
$founder_photo = spotlezz_field( 'founder_photo', $page_id, null );
$founder_name  = spotlezz_field( 'founder_name', $page_id, '' );
if ( $founder_name ) :
	?>
	<section class="founder-block">
		<h2><?php esc_html_e( 'Oprichter aan het woord', 'spotlezz' ); ?></h2>
		<?php
		spotlezz_person_card(
			array(
				'id_suffix' => 'founder',
				'name'      => $founder_name,
				'job_title' => spotlezz_field( 'founder_role', $page_id, __( 'Oprichter', 'spotlezz' ) ),
				'quote'     => spotlezz_field( 'founder_quote', $page_id, '' ),
				'linkedin'  => spotlezz_field( 'founder_linkedin', $page_id, '' ),
				'image_url' => is_array( $founder_photo ) ? ( $founder_photo['url'] ?? '' ) : '',
			)
		);
		?>
	</section>
	<?php
endif;

/* ==================================================================
 * 9. FAQ — RELATIONSHIP, gedeelde renderfunctie sinds fase 4C (zichtbare
 *    uitvoer ongewijzigd t.o.v. fase 4B) — zie inc/components.php.
 * ================================================================== */
spotlezz_faq_block( $page_id );

/* ==================================================================
 * 10. Zachte conversie (lead magnet) — precies één instantie
 * ================================================================== */
$lead_title = spotlezz_field( 'lead_magnet_title', $page_id, __( 'De Spotlezz-check', 'spotlezz' ) );
$lead_desc  = spotlezz_field( 'lead_magnet_description', $page_id, __( 'Ontdek in 1 minuut of je huidige schoonmaak de juiste is.', 'spotlezz' ) );
$lead_cta   = spotlezz_field( 'lead_magnet_cta_label', $page_id, __( 'Ontvang de checklist', 'spotlezz' ) );
?>
<section class="lead-magnet-block">
	<h2><?php echo esc_html( $lead_title ); ?></h2>
	<?php if ( $lead_desc ) : ?>
		<p><?php echo esc_html( $lead_desc ); ?></p>
	<?php endif; ?>
	<a class="btn btn-orange" href="<?php echo esc_url( home_url( '/checklist/' ) ); ?>"><?php echo esc_html( $lead_cta ); ?></a>
</section>

<?php
/* ==================================================================
 * 11. Next-hop bar — locked, theme-controlled, exact 3 routes
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
