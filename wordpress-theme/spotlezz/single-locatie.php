<?php
/**
 * Locatiepagina (stad of wijk) — WORDPRESS-BUILD-PLAN.md §3.4 /
 * PHASE-4C-PLAN.md §3, wireframe-4-locatiepagina-FINAL.html. Velden komen
 * uit inc/acf-locatie.php.
 *
 * De noindex-gate (inc/publish-gate.php, regel 12 / §5.4) draait
 * onafhankelijk van dit template via `template_redirect` — hier wordt
 * alleen de zichtbare admin-hint getoond wanneer bewijs ontbreekt.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$post_id   = get_the_ID();
	$has_proof = spotlezz_locatie_has_local_proof( $post_id );

	$kaart          = spotlezz_field( 'kaart_afbeelding', $post_id, null );
	$stat_reactietijd = spotlezz_field( 'stat_reactietijd_value', $post_id, '' );
	$stat_teams       = spotlezz_field( 'stat_teams_value', $post_id, '' );

	$review_score = spotlezz_get_option( 'review_score' );
	$review_count = spotlezz_get_option( 'review_count' );
	$phone        = spotlezz_get_option( 'phone' );
	?>
	<article <?php post_class( 'locatie-single' ); ?> id="post-<?php the_ID(); ?>">

		<!-- Rij 2: hero, kaart, NAP -->
		<header class="locatie-hero">
			<div class="locatie-hero-main">
				<h1>
					<?php
					printf(
						/* translators: %s: plaatsnaam */
						esc_html__( 'Schoonmaakbedrijf %s', 'spotlezz' ),
						esc_html( get_the_title() )
					);
					?>
				</h1>

				<?php if ( ! $has_proof && current_user_can( 'edit_theme_options' ) ) : ?>
					<p class="placeholder-note content-placeholder">
						<?php
						esc_html_e(
							'Deze pagina staat op noindex: onvoldoende lokaal bewijs (minimaal 3 van de 4 vormen — zie inc/publish-gate.php). Alleen zichtbaar voor ingelogde beheerders.',
							'spotlezz'
						);
						?>
					</p>
				<?php endif; ?>

				<div class="usp-pills">
					<span class="pill-check">&#10003; <?php esc_html_e( 'Binnen 12 uur een afspraak', 'spotlezz' ); ?></span>
					<span class="pill-check">&#10003; <?php esc_html_e( 'Vaste teams in de regio', 'spotlezz' ); ?></span>
					<?php if ( $review_score ) : ?>
						<span class="pill-check">&#9733; <?php echo esc_html( $review_score ); ?>/5</span>
					<?php endif; ?>
				</div>

				<div class="locatie-cta-row">
					<a href="<?php echo esc_url( home_url( '/offerte-aanvragen/' ) ); ?>" class="btn btn-orange">
						<?php
						printf(
							/* translators: %s: plaatsnaam */
							esc_html__( 'Offerte %s', 'spotlezz' ),
							esc_html( get_the_title() )
						);
						?>
					</a>
					<?php if ( $phone ) : ?>
						<a href="tel:<?php echo esc_attr( spotlezz_get_option( 'phone_intl' ) ); ?>" class="btn btn-outline-dark">
							<?php
							printf(
								/* translators: %s: telefoonnummer */
								esc_html__( 'Bel %s', 'spotlezz' ),
								esc_html( $phone )
							);
							?>
						</a>
					<?php endif; ?>
				</div>
			</div>

			<div class="locatie-hero-side">
				<?php if ( is_array( $kaart ) && ! empty( $kaart['url'] ) ) : ?>
					<div class="locatie-kaart">
						<img src="<?php echo esc_url( $kaart['url'] ); ?>" alt="<?php echo esc_attr( spotlezz_image_alt( $kaart, get_the_title() ) ); ?>" loading="lazy" decoding="async">
					</div>
				<?php endif; ?>
				<div class="nap-block">
					<span class="lbl"><?php esc_html_e( 'NAP-blok', 'spotlezz' ); ?></span>
					<p><?php echo esc_html( spotlezz_get_option( 'org_name' ) ); ?></p>
					<p><?php echo esc_html( spotlezz_get_option( 'address_street' ) ); ?>, <?php echo esc_html( spotlezz_get_option( 'address_postcode' ) ); ?> <?php echo esc_html( spotlezz_get_option( 'address_city' ) ); ?></p>
					<p><?php echo esc_html( $phone ); ?></p>
				</div>
			</div>
		</header>

		<!-- Rij 3: antwoordblok -->
		<?php
		$antwoord_stats = array(
			array( 'value' => __( 'zie FAQ', 'spotlezz' ), 'label' => __( 'Prijsfactoren', 'spotlezz' ) ),
		);
		if ( $stat_reactietijd ) {
			$antwoord_stats[] = array( 'value' => $stat_reactietijd, 'label' => __( 'Reactietijd', 'spotlezz' ) );
		}
		if ( $stat_teams ) {
			$antwoord_stats[] = array( 'value' => $stat_teams, 'label' => __( 'In de regio', 'spotlezz' ) );
		}
		if ( $review_count ) {
			$antwoord_stats[] = array( 'value' => $review_count, 'label' => __( 'Beoordelingen', 'spotlezz' ) );
		}
		?>
		<section class="locatie-antwoordblok">
			<?php spotlezz_stat_block( $antwoord_stats ); ?>
			<p class="answer-price-link">
				<a href="<?php echo esc_url( home_url( '/veelgestelde-vragen/wat-kost-schoonmaak/' ) ); ?>"><?php esc_html_e( 'Bekijk de prijsfactoren', 'spotlezz' ); ?></a>
			</p>
		</section>

		<!-- Rij 4: lokaal bewijs -->
		<?php
		$logos = array();
		for ( $i = 1; $i <= 6; $i++ ) {
			$logo = spotlezz_field( "logo_{$i}", $post_id, null );
			if ( is_array( $logo ) && ! empty( $logo['url'] ) ) {
				$logos[] = $logo;
			}
		}
		$lokale_case    = spotlezz_field( 'lokale_case', $post_id, array() );
		$lokale_case    = is_array( $lokale_case ) ? array_filter(
			$lokale_case,
			function ( $c ) {
				return $c instanceof WP_Post && 'publish' === $c->post_status;
			}
		) : array();
		$review_quote = spotlezz_field( 'lokale_review_quote', $post_id, '' );
		$review_naam  = spotlezz_field( 'lokale_review_naam', $post_id, '' );
		$review_rol   = spotlezz_field( 'lokale_review_rol', $post_id, '' );
		$review_foto  = spotlezz_field( 'lokale_review_foto', $post_id, null );
		?>
		<?php if ( ! empty( $logos ) || ! empty( $lokale_case ) || ( $review_quote && $review_naam ) ) : ?>
			<section class="locatie-bewijs">
				<h2><?php esc_html_e( 'Lokale klanten', 'spotlezz' ); ?></h2>
				<?php if ( ! empty( $logos ) ) : ?>
					<div class="logo-grid">
						<?php foreach ( $logos as $logo ) : ?>
							<img src="<?php echo esc_url( $logo['url'] ); ?>" alt="<?php echo esc_attr( spotlezz_image_alt( $logo, __( 'Klantlogo', 'spotlezz' ) ) ); ?>" loading="lazy" decoding="async">
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<div class="bewijs-split">
					<?php if ( ! empty( $lokale_case ) ) : ?>
						<?php $case = reset( $lokale_case ); ?>
						<a class="case-card" href="<?php echo esc_url( get_permalink( $case ) ); ?>">
							<div class="case-card-body">
								<h3><?php echo esc_html( get_the_title( $case ) ); ?></h3>
								<p>
									<?php
									printf(
										/* translators: %s: titel van de case */
										esc_html__( 'Lees de case: %s', 'spotlezz' ),
										esc_html( get_the_title( $case ) )
									);
									?>
								</p>
							</div>
						</a>
					<?php endif; ?>

					<?php if ( $review_quote && $review_naam ) : ?>
						<blockquote class="review-card">
							<span class="review-stars" aria-hidden="true">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
							<p><?php echo esc_html( $review_quote ); ?></p>
							<div class="review-author">
								<?php if ( is_array( $review_foto ) && ! empty( $review_foto['url'] ) ) : ?>
									<img src="<?php echo esc_url( $review_foto['url'] ); ?>" alt="<?php echo esc_attr( spotlezz_image_alt( $review_foto, $review_naam ) ); ?>" loading="lazy" decoding="async">
								<?php endif; ?>
								<span>
									<b><?php echo esc_html( $review_naam ); ?></b>
									<?php if ( $review_rol ) : ?><span class="review-role"><?php echo esc_html( $review_rol ); ?></span><?php endif; ?>
								</span>
							</div>
						</blockquote>
						<?php
						add_filter(
							'spotlezz_schema_graph',
							function ( $graph ) use ( $review_quote, $review_naam ) {
								$graph[] = array(
									'@type'        => 'Review',
									'reviewBody'   => wp_strip_all_tags( $review_quote ),
									'author'       => array(
										'@type' => 'Person',
										'name'  => wp_strip_all_tags( $review_naam ),
									),
									'itemReviewed' => array( '@id' => home_url( '/#organization' ) ),
								);
								return $graph;
							}
						);
						?>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<!-- Rij 5: diensten top-3 + wijken -->
		<?php
		$diensten_top3 = spotlezz_field( 'diensten_top3', $post_id, array() );
		$diensten_top3 = array_filter(
			is_array( $diensten_top3 ) ? $diensten_top3 : array(),
			function ( $p ) {
				return $p instanceof WP_Post && 'publish' === $p->post_status;
			}
		);
		$wijken = get_posts(
			array(
				'post_type'      => 'locatie',
				'post_parent'    => $post_id,
				'posts_per_page' => -1,
				'orderby'        => 'title',
				'order'          => 'ASC',
			)
		);
		?>
		<?php if ( ! empty( $diensten_top3 ) || ! empty( $wijken ) ) : ?>
			<section class="locatie-diensten">
				<?php if ( ! empty( $diensten_top3 ) ) : ?>
					<h2><?php esc_html_e( 'Diensten in deze stad', 'spotlezz' ); ?></h2>
					<div class="locatie-diensten-grid">
						<?php foreach ( $diensten_top3 as $pillar ) : ?>
							<a class="dienst-tile" href="<?php echo esc_url( get_permalink( $pillar ) ); ?>">
								<?php echo esc_html( get_the_title( $pillar ) . ' ' . get_the_title( $post_id ) ); ?>
								<span class="mini">&#8594; <?php esc_html_e( 'meer', 'spotlezz' ); ?></span>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $wijken ) ) : ?>
					<p class="lbl" style="margin-top:20px;"><?php esc_html_e( 'Wijken', 'spotlezz' ); ?></p>
					<div class="location-pills">
						<?php foreach ( $wijken as $wijk ) : ?>
							<a class="pill" href="<?php echo esc_url( get_permalink( $wijk ) ); ?>"><?php echo esc_html( get_the_title( $wijk ) ); ?></a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</section>
		<?php endif; ?>

		<!-- Rij 6: werkgebied -->
		<?php $werkgebied = spotlezz_field( 'werkgebied_tekst', $post_id, '' ); ?>
		<?php if ( $werkgebied ) : ?>
			<section class="locatie-werkgebied">
				<h2><?php esc_html_e( 'Ons werkgebied', 'spotlezz' ); ?></h2>
				<div class="werkgebied-tekst"><?php echo wp_kses_post( $werkgebied ); ?></div>
			</section>
		<?php endif; ?>

		<!-- Rij 7: eigen fotografie -->
		<?php
		$photos = array();
		for ( $i = 1; $i <= 3; $i++ ) {
			$photo = spotlezz_field( "photo_{$i}", $post_id, null );
			if ( is_array( $photo ) && ! empty( $photo['url'] ) ) {
				$photos[] = array(
					'image'   => $photo,
					'caption' => spotlezz_field( "photo_{$i}_caption", $post_id, '' ),
				);
			}
		}
		?>
		<?php if ( ! empty( $photos ) ) : ?>
			<section class="locatie-fotografie">
				<h2><?php esc_html_e( "Eigen fotografie", 'spotlezz' ); ?></h2>
				<div class="photography-grid">
					<?php foreach ( $photos as $photo ) : ?>
						<figure class="photography-item">
							<img src="<?php echo esc_url( $photo['image']['url'] ); ?>" alt="<?php echo esc_attr( spotlezz_image_alt( $photo['image'], $photo['caption'] ) ); ?>" loading="lazy" decoding="async">
							<?php if ( $photo['caption'] ) : ?>
								<figcaption><?php echo esc_html( $photo['caption'] ); ?></figcaption>
							<?php endif; ?>
						</figure>
					<?php endforeach; ?>
				</div>
			</section>
		<?php endif; ?>

		<!-- Rij 8: lokaal team -->
		<?php
		$team_naam     = spotlezz_field( 'lokaal_team_naam', $post_id, '' );
		$team_foto     = spotlezz_field( 'lokaal_team_foto', $post_id, null );
		if ( $team_naam ) :
			?>
			<section class="medewerker-block">
				<h2><?php esc_html_e( 'Het team in deze regio', 'spotlezz' ); ?></h2>
				<?php
				spotlezz_person_card(
					array(
						'name'      => $team_naam,
						'job_title' => spotlezz_field( 'lokaal_team_rol', $post_id, '' ),
						'quote'     => spotlezz_field( 'lokaal_team_quote', $post_id, '' ),
						'image_url' => is_array( $team_foto ) ? ( $team_foto['url'] ?? '' ) : '',
						'linkedin'  => spotlezz_field( 'lokaal_team_linkedin', $post_id, '' ),
						'id_suffix' => 'locatie-' . $post_id . '-team',
					)
				);
				?>
			</section>
		<?php endif; ?>

		<!-- Rij 9: lokale FAQ -->
		<?php spotlezz_faq_block( $post_id, 'lokale_faqs' ); ?>

		<!-- Rij 10: andere locaties -->
		<?php
		$andere_locaties = get_posts(
			array(
				'post_type'      => 'locatie',
				'posts_per_page' => 6,
				'post__not_in'   => array( $post_id ),
				'post_parent'    => 0,
				'orderby'        => 'title',
				'order'          => 'ASC',
			)
		);
		?>
		<?php if ( ! empty( $andere_locaties ) ) : ?>
			<section class="locatie-carrousel">
				<h2><?php esc_html_e( 'Andere locaties', 'spotlezz' ); ?></h2>
				<div class="location-pills">
					<?php foreach ( $andere_locaties as $andere ) : ?>
						<a class="pill" href="<?php echo esc_url( get_permalink( $andere ) ); ?>"><?php echo esc_html( get_the_title( $andere ) ); ?></a>
					<?php endforeach; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php
		// LocalBusiness/CleaningService met areaServed voor deze plaats/wijk —
		// aparte node t.o.v. de generieke Organization-node in inc/schema.php.
		add_filter(
			'spotlezz_schema_graph',
			function ( $graph ) use ( $post_id ) {
				$graph[] = array(
					'@type'      => array( 'LocalBusiness', 'CleaningService' ),
					'@id'        => get_permalink( $post_id ) . '#localbusiness',
					'name'       => spotlezz_get_option( 'org_name' ),
					'url'        => get_permalink( $post_id ),
					'areaServed' => get_the_title( $post_id ),
					'parentOrganization' => array( '@id' => home_url( '/#organization' ) ),
				);
				return $graph;
			}
		);
		?>
	</article>
	<?php

	// Rij 11: next-hop — zijwaarts naar de lokale case als die er is, anders
	// de dienstenhub.
	$zijwaarts_url   = get_post_type_archive_link( 'pillar' ) ?: home_url( '/diensten/' );
	$zijwaarts_titel = __( 'Bekijk onze diensten', 'spotlezz' );
	if ( ! empty( $lokale_case ) ) {
		$case            = reset( $lokale_case );
		$zijwaarts_url   = get_permalink( $case );
		$zijwaarts_titel = sprintf( /* translators: %s: titel van de case */ __( 'Case in %s', 'spotlezz' ), get_the_title( $post_id ) );
	}

	spotlezz_next_hop(
		array(
			array(
				'label' => __( 'Omhoog', 'spotlezz' ),
				'title' => __( 'Alle locaties', 'spotlezz' ),
				'url'   => get_post_type_archive_link( 'locatie' ) ?: home_url( '/locaties/' ),
			),
			array(
				'label' => __( 'Zijwaarts', 'spotlezz' ),
				'title' => $zijwaarts_titel,
				'url'   => $zijwaarts_url,
			),
			array(
				'label' => __( 'Conversie', 'spotlezz' ),
				'title' => sprintf( /* translators: %s: plaatsnaam */ __( 'Offerte voor %s', 'spotlezz' ), get_the_title( $post_id ) ),
				'url'   => home_url( '/offerte-aanvragen/' ),
			),
		)
	);

endwhile;

get_footer();
