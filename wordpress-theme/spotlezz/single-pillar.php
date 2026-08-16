<?php
/**
 * Dienst-pillar (branche of dienst) — fase 4C.
 *
 * Volledige sectie-opbouw volgens wireframe-1-dienst-detail-FINAL.html en
 * WORDPRESS-BUILD-PLAN.md §3.2 / PHASE-4C-PLAN.md. Navigatie, breadcrumb,
 * next-hop en schema-architectuur zijn theme-code (locked, uit fase 4A);
 * reviews en de werkwijze/vergelijkingstabel komen uit de gedeelde Site
 * Options-bron (fase 4C, APPROVED) via spotlezz_reviews_block() en
 * spotlezz_werkwijze_vergelijking_block().
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	$post_id = get_the_ID();
	?>
	<article <?php post_class( 'pillar-single' ); ?> id="post-<?php the_ID(); ?>">

		<?php
		/* ==================================================================
		 * 1-2. Hero + snelofferte-kaart (geen embedded formulier — zie
		 *      PHASE-4C-PLAN.md beslissing 5: visuele CTA nu, echte
		 *      formulier-verzendlaag is een latere, aparte stap)
		 * ================================================================== */
		$hero_kicker = spotlezz_field( 'hero_kicker', $post_id, '' );
		$usps        = array_filter(
			array(
				spotlezz_field( 'usp_1', $post_id, '' ),
				spotlezz_field( 'usp_2', $post_id, '' ),
				spotlezz_field( 'usp_3', $post_id, '' ),
			)
		);
		?>
		<section class="pillar-hero">
			<div class="pillar-hero-content">
				<?php if ( $hero_kicker ) : ?>
					<p class="hero-kicker hero-kicker-light"><?php echo esc_html( $hero_kicker ); ?></p>
				<?php endif; ?>
				<h1><?php echo esc_html( spotlezz_field( 'hero_h1', $post_id, get_the_title() ) ); ?></h1>
				<?php $hero_intro = spotlezz_field( 'hero_intro', $post_id, '' ); ?>
				<?php if ( $hero_intro ) : ?>
					<p class="pillar-hero-intro"><?php echo esc_html( $hero_intro ); ?></p>
				<?php endif; ?>
				<?php if ( ! empty( $usps ) ) : ?>
					<div class="usp-pills">
						<?php foreach ( $usps as $usp ) : ?>
							<span class="pill pill-check">&#10003; <?php echo esc_html( $usp ); ?></span>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
			<div class="pillar-hero-cta-card">
				<h2><?php esc_html_e( 'Snelofferte', 'spotlezz' ); ?></h2>
				<p><?php esc_html_e( 'Vraag een offerte op maat aan. Reactie binnen 12 uur.', 'spotlezz' ); ?></p>
				<a href="<?php echo esc_url( home_url( '/offerte-aanvragen/' ) ); ?>" class="btn btn-orange"><?php esc_html_e( 'Offerte binnen 24 uur', 'spotlezz' ); ?></a>
				<?php $phone_raw = spotlezz_get_option( 'phone_raw' ); ?>
				<?php if ( '' !== $phone_raw ) : ?>
					<a href="tel:<?php echo esc_attr( $phone_raw ); ?>" class="btn btn-outline-dark"><?php echo esc_html( spotlezz_get_option( 'phone' ) ); ?></a>
				<?php endif; ?>
			</div>
		</section>

		<?php
		/* ==================================================================
		 * 3. Antwoordblok
		 * ================================================================== */
		$answer_intro = spotlezz_field( 'answer_intro', $post_id, '' );
		$stats        = array(
			array(
				'value' => __( 'zie FAQ', 'spotlezz' ),
				'label' => __( 'Prijsfactoren', 'spotlezz' ),
			),
			array(
				'value' => spotlezz_field( 'stat_frequentie_value', $post_id, '' ),
				'label' => spotlezz_field( 'stat_frequentie_label', $post_id, __( 'Frequentie', 'spotlezz' ) ),
			),
			array(
				'value' => spotlezz_get_option( 'address_city' ) . ' e.o.',
				'label' => __( 'Regio', 'spotlezz' ),
			),
			array(
				'value' => spotlezz_field( 'stat_reactietijd_value', $post_id, '< 12 uur' ),
				'label' => spotlezz_field( 'stat_reactietijd_label', $post_id, __( 'Reactietijd', 'spotlezz' ) ),
			),
		);
		?>
		<section class="answer-block">
			<?php if ( $answer_intro ) : ?>
				<p class="answer-intro"><?php echo esc_html( $answer_intro ); ?></p>
			<?php endif; ?>
			<?php spotlezz_stat_block( $stats ); ?>
			<p class="answer-price-link">
				<a href="<?php echo esc_url( home_url( '/veelgestelde-vragen/wat-bepaalt-de-prijs-van-schoonmaak/' ) ); ?>">
					<?php esc_html_e( 'Wat bepaalt de prijs? Bekijk de zes factoren', 'spotlezz' ); ?>
				</a>
			</p>
		</section>

		<?php
		/* ==================================================================
		 * 4. Werkzaamheden-raster — 8 losse slots i.p.v. repeater, elk
		 *    optioneel doorlinkend naar een andere pillar (relationship,
		 *    dus nooit een link naar een niet-bestaande pagina)
		 * ================================================================== */
		$tasks = array();
		for ( $i = 1; $i <= 8; $i++ ) {
			$label = spotlezz_field( "task_{$i}_label", $post_id, '' );
			if ( '' === $label ) {
				continue;
			}
			$linked_pillar = spotlezz_field( "task_{$i}_pillar", $post_id, array() );
			$linked_pillar = is_array( $linked_pillar ) ? reset( $linked_pillar ) : false;
			$tasks[]       = array(
				'label' => $label,
				'url'   => ( $linked_pillar instanceof WP_Post && 'publish' === $linked_pillar->post_status ) ? get_permalink( $linked_pillar ) : '',
			);
		}
		?>
		<?php if ( ! empty( $tasks ) ) : ?>
			<section class="tasks-block">
				<h2><?php esc_html_e( 'Wat wij precies doen', 'spotlezz' ); ?></h2>
				<div class="tasks-grid">
					<?php foreach ( $tasks as $task ) : ?>
						<?php if ( $task['url'] ) : ?>
							<a class="task-tile" href="<?php echo esc_url( $task['url'] ); ?>"><?php echo esc_html( $task['label'] ); ?></a>
						<?php else : ?>
							<div class="task-tile task-tile-static"><?php echo esc_html( $task['label'] ); ?></div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</section>
		<?php elseif ( current_user_can( 'edit_theme_options' ) ) : ?>
			<p class="placeholder-note content-placeholder"><?php esc_html_e( 'Nog geen werkzaamheden ingevuld.', 'spotlezz' ); ?></p>
		<?php endif; ?>

		<?php
		/* ==================================================================
		 * 5. Werkwijze + vergelijkingstabel + CTA — gedeeld (Site Options)
		 * ================================================================== */
		spotlezz_werkwijze_vergelijking_block();
		?>

		<?php
		/* ==================================================================
		 * 6. Eigen fotografie
		 * ================================================================== */
		$photo_defaults = array(
			1 => __( 'Team aan het werk', 'spotlezz' ),
			2 => __( 'Het pand of de ruimte', 'spotlezz' ),
			3 => __( 'Materiaal en producten', 'spotlezz' ),
		);
		$photography    = array();
		foreach ( $photo_defaults as $i => $default_caption ) {
			$photography[] = array(
				'photo'   => spotlezz_field( "photo_{$i}", $post_id, null ),
				'caption' => spotlezz_field( "photo_{$i}_caption", $post_id, $default_caption ),
			);
		}
		?>
		<section class="photography-block">
			<h2><?php esc_html_e( 'Eigen foto\'s', 'spotlezz' ); ?></h2>
			<div class="photography-grid">
				<?php foreach ( $photography as $item ) : ?>
					<?php
					$photo     = $item['photo'];
					$caption   = $item['caption'];
					$has_photo = is_array( $photo ) && ! empty( $photo['url'] );
					?>
					<figure class="photography-item">
						<?php if ( $has_photo ) : ?>
							<img src="<?php echo esc_url( $photo['sizes']['spotlezz-card'] ?? $photo['url'] ); ?>" alt="<?php echo esc_attr( spotlezz_image_alt( $photo, $caption ) ); ?>" loading="lazy" decoding="async">
							<?php if ( $caption ) : ?><figcaption><?php echo esc_html( $caption ); ?></figcaption><?php endif; ?>
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
		 * 7. Reviews — gedeeld (Site Options)
		 * ================================================================== */
		spotlezz_reviews_block();

		/* ==================================================================
		 * 8. Medewerker aan het woord — persoonskaart + Person-schema
		 * ================================================================== */
		$medewerker_naam = spotlezz_field( 'medewerker_naam', $post_id, '' );
		if ( $medewerker_naam ) :
			$medewerker_foto = spotlezz_field( 'medewerker_foto', $post_id, null );
			?>
			<section class="medewerker-block">
				<h2><?php esc_html_e( 'Medewerker aan het woord', 'spotlezz' ); ?></h2>
				<?php
				spotlezz_person_card(
					array(
						'id_suffix' => 'medewerker-' . $post_id,
						'name'      => $medewerker_naam,
						'job_title' => spotlezz_field( 'medewerker_functie', $post_id, '' ),
						'quote'     => spotlezz_field( 'medewerker_quote', $post_id, '' ),
						'linkedin'  => spotlezz_field( 'medewerker_linkedin', $post_id, '' ),
						'image_url' => is_array( $medewerker_foto ) ? ( $medewerker_foto['url'] ?? '' ) : '',
					)
				);
				?>
			</section>
			<?php
		endif;

		/* ==================================================================
		 * 9. Klantcases (exact 2) — RELATIONSHIP
		 * ================================================================== */
		$featured_cases = spotlezz_field( 'featured_cases', $post_id, array() );
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
								<?php if ( $excerpt ) : ?><p><?php echo esc_html( $excerpt ); ?></p><?php endif; ?>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
			</section>
			<?php
		elseif ( current_user_can( 'edit_theme_options' ) ) :
			?>
			<p class="placeholder-note content-placeholder"><?php esc_html_e( 'Nog geen klantcases geselecteerd.', 'spotlezz' ); ?></p>
			<?php
		endif;

		/* ==================================================================
		 * 10. Regioblok — GEEN ACF, automatisch alle gepubliceerde locaties
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
		<?php if ( ! empty( $all_locations ) ) : ?>
			<section class="work-area-block">
				<h2><?php esc_html_e( 'In welke regio leveren wij deze dienst?', 'spotlezz' ); ?></h2>
				<div class="location-pills">
					<?php foreach ( $all_locations as $locatie ) : ?>
						<a class="pill" href="<?php echo esc_url( get_permalink( $locatie ) ); ?>"><?php echo esc_html( get_the_title( $locatie ) ); ?></a>
					<?php endforeach; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php
		/* ==================================================================
		 * 11. FAQ — gedeeld (relationship op deze post)
		 * ================================================================== */
		spotlezz_faq_block( $post_id );
		?>

	</article>
	<?php

	/* ======================================================================
	 * Schema: Service-node + Person-node voor de medewerker (via
	 * spotlezz_person_card hierboven, als het naamveld gevuld is)
	 * ====================================================================== */
	add_filter(
		'spotlezz_schema_graph',
		function ( $graph ) use ( $post_id ) {
			$graph[] = array(
				'@type'       => 'Service',
				'name'        => get_the_title( $post_id ),
				'url'         => get_permalink( $post_id ),
				'provider'    => array( '@id' => home_url( '/#organization' ) ),
				'areaServed'  => spotlezz_get_option( 'address_city' ),
			);
			return $graph;
		}
	);

	// Bepaal de "zijwaarts"-route voor de next-hop bar: de eerste gekoppelde
	// case als die er is, anders de cases-hub — nooit een handmatig getypte URL.
	$featured_cases_for_hop = spotlezz_field( 'featured_cases', $post_id, array() );
	$first_case             = is_array( $featured_cases_for_hop ) ? reset( $featured_cases_for_hop ) : false;
	$sideways_url            = ( $first_case instanceof WP_Post ) ? get_permalink( $first_case ) : ( get_post_type_archive_link( 'case' ) ?: home_url( '/klantcases/' ) );
	$sideways_title           = ( $first_case instanceof WP_Post ) ? get_the_title( $first_case ) : __( 'Bekijk een klantcase', 'spotlezz' );

	spotlezz_next_hop(
		array(
			array(
				'label' => __( 'Omhoog', 'spotlezz' ),
				'title' => __( 'Alle diensten', 'spotlezz' ),
				'url'   => get_post_type_archive_link( 'pillar' ) ?: home_url( '/diensten/' ),
			),
			array(
				'label' => __( 'Zijwaarts', 'spotlezz' ),
				'title' => $sideways_title,
				'url'   => $sideways_url,
			),
			array(
				'label' => __( 'Conversie', 'spotlezz' ),
				'title' => __( 'Vraag je offerte aan', 'spotlezz' ),
				'url'   => home_url( '/offerte-aanvragen/' ),
			),
		)
	);

endwhile;

get_footer();
