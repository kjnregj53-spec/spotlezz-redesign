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

	/*
	 * Werkgebied-tekst hier al ophalen en in tweeën knippen: de eerste
	 * alinea verhuist naar de hero (tussen de usp-pills en de knoppen),
	 * zodat de hero niet meer zo kaal oogt — de rest blijft verderop
	 * staan in "Ons werkgebied" (rij 6), nu wat korter i.p.v. de eerste
	 * alinea daar te dupliceren.
	 */
	$werkgebied_full  = spotlezz_field( 'werkgebied_tekst', $post_id, '' );
	$werkgebied_intro = '';
	$werkgebied_rest  = $werkgebied_full;
	if ( $werkgebied_full && preg_match( '/^(.*?<\/p>)(.*)$/s', trim( $werkgebied_full ), $matches ) ) {
		$werkgebied_intro = $matches[1];
		$werkgebied_rest  = trim( $matches[2] );
	}

	$locatie_titel = sprintf(
		/* translators: %s: plaatsnaam */
		__( 'Schoonmaakbedrijf %s', 'spotlezz' ),
		get_the_title()
	);
	spotlezz_page_hero( $locatie_titel, spotlezz_get_option( 'page_hero_locaties' ) );
	?>
	<article <?php post_class( 'locatie-single' ); ?> id="post-<?php the_ID(); ?>">

		<!-- Rij 2: hero, kaart, NAP -->
		<header class="locatie-hero">
			<div class="locatie-hero-main">
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

				<?php if ( $werkgebied_intro ) : ?>
					<div class="locatie-hero-intro"><?php echo wp_kses_post( $werkgebied_intro ); ?></div>
				<?php endif; ?>

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
					<h2><?php esc_html_e( 'Gegevens en werkgebied', 'spotlezz' ); ?></h2>
					<ul class="nap-list">
						<li><strong><?php esc_html_e( 'Naam', 'spotlezz' ); ?></strong> <?php echo esc_html( spotlezz_get_option( 'org_name' ) ); ?></li>
						<?php if ( $phone ) : ?>
							<li><strong><?php esc_html_e( 'Telefoon', 'spotlezz' ); ?></strong> <a href="tel:<?php echo esc_attr( spotlezz_get_option( 'phone_intl' ) ); ?>"><?php echo esc_html( $phone ); ?></a></li>
						<?php endif; ?>
						<?php $email = spotlezz_get_option( 'email' ); ?>
						<?php if ( '' !== $email ) : ?>
							<li><strong><?php esc_html_e( 'E-mail', 'spotlezz' ); ?></strong> <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
						<?php endif; ?>
						<?php $hours = spotlezz_get_option( 'opening_hours' ); ?>
						<?php if ( '' !== $hours ) : ?>
							<li><strong><?php esc_html_e( 'Openingstijden', 'spotlezz' ); ?></strong> <?php echo esc_html( $hours ); ?></li>
						<?php endif; ?>
						<li><strong><?php esc_html_e( 'Werkgebied', 'spotlezz' ); ?></strong> <?php echo esc_html( get_the_title() ); ?> <?php esc_html_e( 'en omgeving', 'spotlezz' ); ?></li>
						<li><strong><?php esc_html_e( 'Bezoekadres', 'spotlezz' ); ?></strong> <?php echo esc_html( trim( spotlezz_get_option( 'address_street' ) . ', ' . spotlezz_get_option( 'address_city' ), ', ' ) ); ?></li>
					</ul>
				</div>
			</div>
		</header>

		<!-- Rij 3: antwoordblok -->
		<?php
		/*
		 * Geen "zie FAQ"-stat + prijsfactoren-link meer hier — op
		 * klantfeedback verwijderd (locatiepagina's mogen niet meer
		 * doorlinken naar FAQ-artikelen).
		 */
		$antwoord_stats = array();
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
		<?php if ( ! empty( $antwoord_stats ) ) : ?>
			<section class="locatie-antwoordblok">
				<?php spotlezz_stat_block( $antwoord_stats ); ?>
			</section>
		<?php endif; ?>

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
		$review_quote    = spotlezz_field( 'lokale_review_quote', $post_id, '' );
		$review_naam     = spotlezz_field( 'lokale_review_naam', $post_id, '' );
		$review_rol      = spotlezz_field( 'lokale_review_rol', $post_id, '' );
		$review_foto     = spotlezz_field( 'lokale_review_foto', $post_id, null );
		$review_linkedin = spotlezz_field( 'lokale_review_linkedin', $post_id, '' );
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
						<?php
						$case      = reset( $lokale_case );
						$case_logo = spotlezz_field( 'logo', $case->ID, null );
						?>
						<a class="case-card" href="<?php echo esc_url( get_permalink( $case ) ); ?>">
							<?php if ( is_array( $case_logo ) && ! empty( $case_logo['url'] ) ) : ?>
								<div class="case-card-logo">
									<img src="<?php echo esc_url( $case_logo['url'] ); ?>" alt="<?php echo esc_attr( spotlezz_image_alt( $case_logo, get_the_title( $case ) ) ); ?>" loading="lazy" decoding="async">
								</div>
							<?php endif; ?>
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
									<?php if ( $review_linkedin ) : ?>
										<a class="review-linkedin" href="<?php echo esc_url( $review_linkedin ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'LinkedIn-profiel', 'spotlezz' ); ?></a>
									<?php endif; ?>
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
		<?php else : ?>
			<?php
			/*
			 * Eerlijke, publiek zichtbare overgangstekst i.p.v. de sectie
			 * volledig verbergen — op klantverzoek zichtbaar voor iedere
			 * bezoeker, maar zonder ooit een naam, quote, foto of case te
			 * verzinnen (blijft de harde regel van dit theme). Zodra er
			 * één echt bewijsstuk binnenkomt, toont de sectie hierboven
			 * dat automatisch i.p.v. deze tekst.
			 */
			?>
			<section class="locatie-bewijs locatie-bewijs-pending">
				<h2><?php esc_html_e( 'Lokale klanten', 'spotlezz' ); ?></h2>
				<p>
					<?php
					printf(
						/* translators: %s: plaatsnaam */
						esc_html__( 'Wij bouwen ons klantennetwerk in %s op dit moment op. Zodra wij hier een vaste klant hebben, delen wij die case met naam en toenaam — geen verzonnen reviews.', 'spotlezz' ),
						esc_html( get_the_title() )
					);
					?>
				</p>
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
		<?php
		/*
		 * Ook dit resterende blok (na de eerste alinea die al in de hero
		 * staat) is nog lang — op klantfeedback knippen we het verder: de
		 * eerstvolgende alinea blijft direct zichtbaar, de rest gaat achter
		 * een "Lees meer"-toggle (<details>, geen JS nodig).
		 */
		$werkgebied_visible = $werkgebied_rest;
		$werkgebied_more    = '';
		if ( $werkgebied_rest && preg_match( '/^(.*?<\/p>)(.*)$/s', trim( $werkgebied_rest ), $rest_matches ) ) {
			$werkgebied_visible = $rest_matches[1];
			$werkgebied_more    = trim( $rest_matches[2] );
		}
		?>
		<?php if ( $werkgebied_visible ) : ?>
			<section class="locatie-werkgebied">
				<h2><?php esc_html_e( 'Ons werkgebied', 'spotlezz' ); ?></h2>
				<div class="werkgebied-tekst"><?php echo wp_kses_post( $werkgebied_visible ); ?></div>
				<?php if ( $werkgebied_more ) : ?>
					<details class="werkgebied-more">
						<summary><?php esc_html_e( 'Lees meer', 'spotlezz' ); ?></summary>
						<div class="werkgebied-tekst"><?php echo wp_kses_post( $werkgebied_more ); ?></div>
					</details>
				<?php endif; ?>
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
		$team_naam = spotlezz_field( 'lokaal_team_naam', $post_id, '' );
		$team_foto = spotlezz_field( 'lokaal_team_foto', $post_id, null );
		$team_rol  = spotlezz_field( 'lokaal_team_rol', $post_id, '' );
		$team_quote = spotlezz_field( 'lokaal_team_quote', $post_id, '' );
		if ( $team_naam && $team_quote ) :
			/*
			 * Zelfde tekst+foto-splitsectie als over-ons.php's "Medewerker
			 * aan het woord" (.medewerker-split) — op klantfeedback een
			 * echte foto rechts i.p.v. alleen de initiaal-avatar. Geen
			 * bevestigde teamfoto per locatie, dus terugval op de al
			 * bevestigde "team aan het werk"-foto van de homepage (zelfde
			 * hergebruik-patroon als elders in dit theme), nooit een
			 * verzonnen/stockfoto.
			 */
			$team_photo_url = is_array( $team_foto ) ? ( $team_foto['url'] ?? '' ) : '';
			if ( ! $team_photo_url ) {
				$home_photo_1   = spotlezz_field( 'photo_1', get_option( 'page_on_front' ), null );
				$team_photo_url = is_array( $home_photo_1 ) ? ( $home_photo_1['url'] ?? '' ) : '';
			}
			?>
			<section class="medewerker-block">
				<h2><?php esc_html_e( 'Het team in deze regio', 'spotlezz' ); ?></h2>
				<div class="medewerker-split">
					<div class="medewerker-split-text">
						<div class="medewerker-split-name">
							<span class="person-avatar" aria-hidden="true"><?php echo esc_html( mb_substr( $team_naam, 0, 1 ) ); ?></span>
							<span>
								<?php echo esc_html( $team_naam ); ?>
								<?php if ( $team_rol ) : ?><br><span class="medewerker-split-role"><?php echo esc_html( $team_rol ); ?></span><?php endif; ?>
							</span>
						</div>
						<blockquote><?php echo esc_html( $team_quote ); ?></blockquote>
					</div>
					<?php if ( $team_photo_url ) : ?>
						<div class="medewerker-split-photo" style="background-image:url('<?php echo esc_url( $team_photo_url ); ?>')" role="img" aria-label="<?php echo esc_attr( spotlezz_image_alt( is_array( $team_foto ) ? $team_foto : null, $team_naam ) ); ?>"></div>
					<?php endif; ?>
				</div>
			</section>
		<?php elseif ( ! $team_naam ) : ?>
			<?php
			/*
			 * Zelfde eerlijke overgangstekst als bij "Lokale klanten" —
			 * nooit een verzonnen teamlid tonen, wel de sectie zichtbaar
			 * houden i.p.v. hem te verbergen.
			 */
			?>
			<section class="medewerker-block medewerker-block-pending">
				<h2><?php esc_html_e( 'Het team in deze regio', 'spotlezz' ); ?></h2>
				<p>
					<?php
					printf(
						/* translators: %s: plaatsnaam */
						esc_html__( 'Wij stellen op dit moment een vast team samen voor %s. Zodra dat rond is, maken wij hier kennis met de teamleider — met een echte naam en foto.', 'spotlezz' ),
						esc_html( get_the_title() )
					);
					?>
				</p>
			</section>
		<?php endif; ?>

		<!-- Rij 9: lokale FAQ -->
		<?php spotlezz_faq_block( $post_id, 'lokale_faqs', false ); ?>

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
	/*
	 * Zwevende snelofferte-popup — zelfde component als dienstpagina's
	 * (spotlezz_sticky_snelofferte() in inc/components.php), op
	 * klantfeedback ook hier toegevoegd.
	 */
	spotlezz_sticky_snelofferte( $post_id );
	?>

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
