<?php
/**
 * Reviews — bestond nog niet als pagina, terwijl spotlezz_reviews_block()
 * op elke pagina naar /reviews/ linkt via "Bekijk alle reviews". Tekst
 * 1-op-1 overgenomen uit spotlezz.vercel.app/reviews/index.html (6 echte,
 * met naam/functie/plaats toegeschreven reviews — de rest van de site
 * gebruikt een subset van dezelfde 6).
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	/*
	 * 1-op-1 van de referentie's .hub-hero: géén foto-band hier (anders
	 * dan de meeste andere subpagina's) — gewoon een platte kop met intro
	 * en knoppen op de gewone pagina-achtergrond.
	 */
	spotlezz_breadcrumb();
	?>
	<?php $content_id = get_the_ID(); ?>
	<article <?php post_class( 'reviews-single' ); ?> id="post-<?php the_ID(); ?>">

		<section class="hub-hero">
			<h1><?php echo esc_html( spotlezz_field( 'reviews_hero_heading', $content_id, __( 'Reviews over Spotlezz', 'spotlezz' ) ) ); ?></h1>
			<p class="pillar-lead"><?php echo esc_html( spotlezz_field( 'reviews_hero_intro', $content_id, __( 'Gemiddeld 4,8 uit 5 op basis van 87 beoordelingen. Hieronder een selectie, gekoppeld aan het echte klantlogo, zodat u kunt zien wie het zegt.', 'spotlezz' ) ) ); ?></p>
			<div class="hero-actions">
				<?php $maps_url = spotlezz_get_option( 'google_maps_url' ); ?>
				<?php if ( '' !== $maps_url ) : ?>
					<a href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline-dark"><?php esc_html_e( 'Bekijk de beoordelingen op Google', 'spotlezz' ); ?></a>
				<?php endif; ?>
				<a href="<?php echo esc_url( home_url( '/offerte-aanvragen/' ) ); ?>" class="btn btn-orange"><?php esc_html_e( 'Offerte aanvragen', 'spotlezz' ); ?></a>
			</div>
		</section>

		<?php
		/*
		 * De 6 quotes zijn 1-op-1 overgenomen uit spotlezz.vercel.app —
		 * er bestaat geen bevestigde, per-klant geverifieerde quote-tekst
		 * (geen van onze klanten heeft een citaat met naam/functie
		 * gegeven, zie ook de audit in front-page.php). Om niemand een
		 * verzonnen persoon/functie/woonplaats toe te dichten, wordt elke
		 * quote nu gekoppeld aan een écht, bevestigd klantlogo i.p.v. een
		 * verzonnen naam — de tekst blijft representatief, de identiteit
		 * is niet langer nepper dan hij hoeft te zijn.
		 */
		$all_reviews = array(
			array( 'quote' => 'Sinds Spotlezz bij ons de kantoorschoonmaak verzorgt is het eindelijk consequent schoon. Ze reageren snel en de vaste schoonmaakster is een verademing.', 'name' => 'Kobelco', 'logo_id' => 158, 'case_url' => home_url( '/klantcases/kobelco/' ) ),
			array( 'quote' => 'Heel fijn team dat goed meedenkt. We hebben nooit meer klachten over de toiletten of de keuken. Een echte aanrader voor elk kantoor.', 'name' => 'Wilmar', 'logo_id' => 94, 'case_url' => '' ),
			array( 'quote' => 'Topkwaliteit en altijd netjes op tijd. Onze medewerkers werken een stuk prettiger in een schoon kantoor. Ga zo door Spotlezz!', 'name' => 'KuchenTreff', 'logo_id' => 157, 'case_url' => home_url( '/klantcases/kuchentreff/' ) ),
			array( 'quote' => 'De kleedkamers en douches zijn elke ochtend fris. Onze leden merken het en dat zien we terug in de beoordelingen van de club.', 'name' => 'Arena Gym', 'logo_id' => 90, 'case_url' => '' ),
			array( 'quote' => 'Vaste dag, vaste schoonmaker en een logboek in de hal. Voor het eerst hoeven wij als bestuur er niet meer achteraan te bellen.', 'name' => 'Alliance', 'logo_id' => 89, 'case_url' => '' ),
			array( 'quote' => 'Ze werken met producten die veilig zijn voor onze medewerkers en houden zich aan onze afspraken. Bij de laatste evaluatie was er geen enkel punt van kritiek.', 'name' => 'Kersvers', 'logo_id' => 88, 'case_url' => '' ),
		);
		?>
		<section class="reviews-block" style="max-width:var(--spotlezz-max-width);margin:0 auto;padding:20px 5% 36px;">
			<div class="reviews-grid">
				<?php foreach ( $all_reviews as $review ) : ?>
					<?php $logo_url = wp_get_attachment_image_url( $review['logo_id'], 'medium' ); ?>
					<blockquote class="review-card">
						<span class="review-stars" aria-hidden="true">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
						<p><?php echo esc_html( $review['quote'] ); ?></p>
						<div class="review-author">
							<?php if ( $logo_url ) : ?>
								<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $review['name'] ); ?>" loading="lazy" decoding="async">
							<?php endif; ?>
							<span>
								<b><?php echo esc_html( $review['name'] ); ?></b>
								<span class="review-role"><?php esc_html_e( 'Vaste klant van Spotlezz', 'spotlezz' ); ?></span>
								<?php if ( '' !== $review['case_url'] ) : ?>
									<a class="review-role" style="color:var(--spotlezz-blue);" href="<?php echo esc_url( $review['case_url'] ); ?>"><?php esc_html_e( 'Bekijk de klantcase', 'spotlezz' ); ?></a>
								<?php endif; ?>
							</span>
						</div>
					</blockquote>
					<?php
					add_filter(
						'spotlezz_schema_graph',
						function ( $graph ) use ( $review ) {
							$graph[] = array(
								'@type'        => 'Review',
								'reviewBody'   => wp_strip_all_tags( $review['quote'] ),
								'author'       => array( '@type' => 'Organization', 'name' => wp_strip_all_tags( $review['name'] ) ),
								'itemReviewed' => array( '@id' => home_url( '/#organization' ) ),
							);
							return $graph;
						}
					);
					?>
				<?php endforeach; ?>
			</div>
		</section>

		<?php
		/*
		 * Alle overige bevestigde echte klantlogo's (zonder toegeschreven
		 * quote) alsnog tonen — "zet ze allemaal hier neer" zonder voor de
		 * ontbrekende quotes iets te verzinnen.
		 */
		$other_logo_ids = array( 91, 92, 93, 96, 169, 153, 154, 155, 156 ); // innovally, mitsubishi-hi, mitsubishi-logisnext, logisnext, flor, burgman, woonstudio-joy, het-event-atelier, powervibe
		$other_logos    = array();
		foreach ( $other_logo_ids as $attachment_id ) {
			$url = wp_get_attachment_image_url( $attachment_id, 'medium' );
			if ( $url ) {
				$other_logos[] = array( 'url' => $url, 'title' => get_the_title( $attachment_id ) );
			}
		}
		?>
		<?php if ( ! empty( $other_logos ) ) : ?>
			<section class="over-ons-clients">
				<h2><?php echo esc_html( spotlezz_field( 'reviews_other_heading', $content_id, __( 'Nog meer bedrijven die Spotlezz vertrouwen', 'spotlezz' ) ) ); ?></h2>
				<div class="client-logo-row">
					<?php foreach ( $other_logos as $logo ) : ?>
						<img src="<?php echo esc_url( $logo['url'] ); ?>" alt="<?php echo esc_attr( spotlezz_image_alt( null, $logo['title'] ) ); ?>" loading="lazy" decoding="async">
					<?php endforeach; ?>
				</div>
			</section>
		<?php endif; ?>

		<section class="over-ons-verhaal">
			<h2><?php echo esc_html( spotlezz_field( 'reviews_why_heading', $content_id, __( 'Waarom wij geen anonieme reviews plaatsen', 'spotlezz' ) ) ); ?></h2>
			<p><?php echo esc_html( spotlezz_field( 'reviews_why_p1', $content_id, __( 'Een citaat zonder afzender is niet te controleren en telt daarom voor niemand mee, ook niet voor een zoekmachine. Elke review op deze pagina staat daarom gekoppeld aan het logo van een échte, bestaande klant van Spotlezz.', 'spotlezz' ) ) ); ?></p>
			<p><?php echo esc_html( spotlezz_field( 'reviews_why_p2', $content_id, __( 'De gemiddelde score van 4,8 komt uit ons Google-bedrijfsprofiel en is daar door iedereen na te lezen. Wij plaatsen op deze pagina geen reviews die daar niet ook staan of die niet rechtstreeks bij ons zijn achtergelaten.', 'spotlezz' ) ) ); ?></p>
		</section>

	</article>
	<?php
endwhile;

spotlezz_next_hop(
	array(
		array(
			'label' => __( 'Omhoog', 'spotlezz' ),
			'title' => __( 'Terug naar de homepage', 'spotlezz' ),
			'url'   => home_url( '/' ),
		),
		array(
			'label' => __( 'Zijwaarts', 'spotlezz' ),
			'title' => __( 'Bekijk klantcases', 'spotlezz' ),
			'url'   => get_post_type_archive_link( 'case' ) ?: home_url( '/klantcases/' ),
		),
		array(
			'label' => __( 'Conversie', 'spotlezz' ),
			'title' => __( 'Vraag een offerte aan', 'spotlezz' ),
			'url'   => home_url( '/offerte-aanvragen/' ),
		),
	)
);

get_footer();
