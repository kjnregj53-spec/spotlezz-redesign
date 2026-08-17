<?php
/**
 * Klantcase — WORDPRESS-BUILD-PLAN.md §3.3 / PHASE-4C-PLAN.md §3,
 * wireframe-2-klantcase-FINAL.html. Velden komen uit inc/acf-case.php.
 *
 * Regel 10 (hard): H1 en Article.headline delen hetzelfde brondata-veld
 * (`headline`) — dat was al zo in de fase-4A-stub en blijft ongewijzigd.
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

	$headline = spotlezz_field( 'headline', $post_id, get_the_title() );
	$logo     = spotlezz_field( 'logo', $post_id, null );
	$branche  = spotlezz_field( 'branche', $post_id, '' );
	$locatie  = spotlezz_field( 'locatie', $post_id, '' );
	$sinds    = spotlezz_field( 'klant_sinds', $post_id, '' );
	$hero_foto = spotlezz_field( 'hero_foto', $post_id, null );

	$feit_vloer     = spotlezz_field( 'feit_vloeroppervlak', $post_id, '' );
	$feit_freq      = spotlezz_field( 'feit_frequentie', $post_id, '' );
	$feit_producten = spotlezz_field( 'feit_producten', $post_id, '' );
	$feit_klachten  = spotlezz_field( 'feit_klachten', $post_id, '' );

	$star_situatie  = spotlezz_field( 'star_situatie', $post_id, '' );
	$star_uitdaging = spotlezz_field( 'star_uitdaging', $post_id, '' );
	$star_aanpak    = spotlezz_field( 'star_aanpak', $post_id, '' );
	$star_resultaat = spotlezz_field( 'star_resultaat', $post_id, '' );

	$quote_tekst    = spotlezz_field( 'quote_tekst', $post_id, '' );
	$quote_naam     = spotlezz_field( 'quote_naam', $post_id, '' );
	$quote_functie  = spotlezz_field( 'quote_functie', $post_id, '' );
	$quote_foto     = spotlezz_field( 'quote_foto', $post_id, null );
	$quote_linkedin = spotlezz_field( 'quote_linkedin', $post_id, '' );

	$gebruikte_diensten = spotlezz_field( 'gebruikte_diensten', $post_id, array() );
	$gebruikte_diensten = array_filter(
		is_array( $gebruikte_diensten ) ? $gebruikte_diensten : array(),
		function ( $pillar ) {
			return $pillar instanceof WP_Post && 'publish' === $pillar->post_status;
		}
	);

	spotlezz_page_hero( $headline, spotlezz_get_option( 'page_hero_diensten_cases' ) );
	?>
	<article <?php post_class( 'case-single' ); ?> id="post-<?php the_ID(); ?>">

		<!-- Rij 2: hero met harde feiten, H1 = resultaatzin -->
		<header class="case-hero">
			<div class="case-hero-main">
				<?php if ( is_array( $logo ) && ! empty( $logo['url'] ) ) : ?>
					<img class="case-logo" src="<?php echo esc_url( $logo['url'] ); ?>" alt="<?php echo esc_attr( spotlezz_image_alt( $logo, get_the_title() ) ); ?>" loading="lazy" decoding="async">
				<?php endif; ?>
				<?php if ( $branche || $locatie || $sinds ) : ?>
					<?php
					$hero_stats = array();
					if ( $branche ) {
						$hero_stats[] = array( 'value' => $branche, 'label' => __( 'Branche', 'spotlezz' ) );
					}
					if ( $locatie ) {
						$hero_stats[] = array( 'value' => $locatie, 'label' => __( 'Locatie', 'spotlezz' ) );
					}
					if ( $sinds ) {
						$hero_stats[] = array( 'value' => $sinds, 'label' => __( 'Klant sinds', 'spotlezz' ) );
					}
					spotlezz_stat_block( $hero_stats );
					?>
				<?php endif; ?>
			</div>
			<?php if ( is_array( $hero_foto ) && ! empty( $hero_foto['url'] ) ) : ?>
				<div class="case-hero-photo">
					<img src="<?php echo esc_url( $hero_foto['url'] ); ?>" alt="<?php echo esc_attr( spotlezz_image_alt( $hero_foto, $headline ) ); ?>" loading="lazy" decoding="async">
				</div>
			<?php endif; ?>
		</header>

		<!-- Rij 3: feitenbalk -->
		<?php if ( $feit_vloer || $feit_freq || $feit_producten || $feit_klachten ) : ?>
			<?php
			$feiten = array();
			if ( $feit_vloer ) {
				$feiten[] = array( 'value' => $feit_vloer, 'label' => __( 'Vloeroppervlak', 'spotlezz' ) );
			}
			if ( $feit_freq ) {
				$feiten[] = array( 'value' => $feit_freq, 'label' => __( 'Frequentie', 'spotlezz' ) );
			}
			if ( $feit_producten ) {
				$feiten[] = array( 'value' => $feit_producten, 'label' => __( 'Producten', 'spotlezz' ) );
			}
			if ( $feit_klachten ) {
				$feiten[] = array( 'value' => $feit_klachten, 'label' => __( 'Klachten', 'spotlezz' ) );
			}
			?>
			<section class="case-feitenbalk">
				<?php spotlezz_stat_block( $feiten ); ?>
			</section>
		<?php endif; ?>

		<!-- Rij 4: STAR-structuur -->
		<?php if ( $star_situatie || $star_uitdaging || $star_aanpak || $star_resultaat ) : ?>
			<section class="case-star">
				<?php if ( $star_situatie ) : ?>
					<div class="star-block">
						<h2><?php esc_html_e( 'De situatie', 'spotlezz' ); ?></h2>
						<p><?php echo esc_html( $star_situatie ); ?></p>
					</div>
				<?php endif; ?>
				<?php if ( $star_uitdaging ) : ?>
					<div class="star-block">
						<h2><?php esc_html_e( 'De uitdaging', 'spotlezz' ); ?></h2>
						<p><?php echo esc_html( $star_uitdaging ); ?></p>
					</div>
				<?php endif; ?>
				<?php if ( $star_aanpak ) : ?>
					<div class="star-block">
						<h2><?php esc_html_e( 'Onze aanpak', 'spotlezz' ); ?></h2>
						<p><?php echo esc_html( $star_aanpak ); ?></p>
					</div>
				<?php endif; ?>
				<?php if ( $star_resultaat ) : ?>
					<div class="star-block">
						<h2><?php esc_html_e( 'Het resultaat', 'spotlezz' ); ?></h2>
						<p><?php echo esc_html( $star_resultaat ); ?></p>
					</div>
				<?php endif; ?>
			</section>
		<?php endif; ?>

		<!-- Rij 5: klantquote -->
		<?php if ( $quote_tekst && $quote_naam ) : ?>
			<section class="case-quote">
				<blockquote class="quote-large">
					<p>&ldquo;<?php echo esc_html( $quote_tekst ); ?>&rdquo;</p>
				</blockquote>
				<?php
				spotlezz_person_card(
					array(
						'name'      => $quote_naam,
						'job_title' => $quote_functie,
						'image_url' => is_array( $quote_foto ) ? ( $quote_foto['url'] ?? '' ) : '',
						'linkedin'  => $quote_linkedin,
						'id_suffix' => 'case-' . $post_id . '-contact',
					)
				);
				?>
			</section>
			<?php
			add_filter(
				'spotlezz_schema_graph',
				function ( $graph ) use ( $quote_tekst, $quote_naam ) {
					$graph[] = array(
						'@type'        => 'Review',
						'reviewBody'   => wp_strip_all_tags( $quote_tekst ),
						'author'       => array(
							'@type' => 'Person',
							'name'  => wp_strip_all_tags( $quote_naam ),
						),
						'itemReviewed' => array( '@id' => home_url( '/#organization' ) ),
					);
					return $graph;
				}
			);
			?>
		<?php endif; ?>

		<!-- Rij 6: gebruikte diensten — elke tegel naar zijn EIGEN pillar -->
		<?php if ( ! empty( $gebruikte_diensten ) ) : ?>
			<section class="case-diensten">
				<h2><?php esc_html_e( 'Gebruikte diensten', 'spotlezz' ); ?></h2>
				<div class="case-diensten-grid">
					<?php foreach ( $gebruikte_diensten as $pillar ) : ?>
						<a class="dienst-tile" href="<?php echo esc_url( get_permalink( $pillar ) ); ?>">
							<?php echo esc_html( get_the_title( $pillar ) ); ?>
						</a>
					<?php endforeach; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php
		if ( $branche && $locatie ) {
			add_filter(
				'spotlezz_schema_graph',
				function ( $graph ) use ( $branche, $locatie, $post_id ) {
					$graph[] = array(
						'@type' => 'Organization',
						'@id'   => get_permalink( $post_id ) . '#klant',
						'name'  => get_the_title( $post_id ),
					);
					return $graph;
				}
			);
		}

		add_filter(
			'spotlezz_schema_graph',
			function ( $graph ) use ( $headline ) {
				$graph[] = array(
					'@type'    => 'Article',
					'headline' => wp_strip_all_tags( $headline ),
					'url'      => get_permalink(),
				);
				return $graph;
			}
		);
		?>
	</article>
	<?php

	// Rij 7: next-hop — omhoog naar de eerste gekoppelde dienst-pillar
	// (regel: minimaal één eigen dienst-pillar-URL, nooit de hub),
	// zijwaarts naar een andere, willekeurige gepubliceerde case.
	$eerste_dienst = ! empty( $gebruikte_diensten ) ? reset( $gebruikte_diensten ) : null;
	$omhoog_url    = $eerste_dienst ? get_permalink( $eerste_dienst ) : ( get_post_type_archive_link( 'pillar' ) ?: home_url( '/diensten/' ) );
	$omhoog_titel  = $eerste_dienst ? get_the_title( $eerste_dienst ) : __( 'Bekijk de diensten', 'spotlezz' );

	$andere_case = get_posts(
		array(
			'post_type'      => 'case',
			'posts_per_page' => 1,
			'post__not_in'   => array( $post_id ),
			'orderby'        => 'rand',
		)
	);
	if ( ! empty( $andere_case ) ) {
		$zijwaarts_url   = get_permalink( $andere_case[0] );
		$zijwaarts_titel = get_the_title( $andere_case[0] );
	} else {
		$zijwaarts_url   = get_post_type_archive_link( 'case' ) ?: home_url( '/klantcases/' );
		$zijwaarts_titel = __( 'Bekijk alle klantcases', 'spotlezz' );
	}

	spotlezz_next_hop(
		array(
			array(
				'label' => __( 'Omhoog', 'spotlezz' ),
				'title' => $omhoog_titel,
				'url'   => $omhoog_url,
			),
			array(
				'label' => __( 'Zijwaarts', 'spotlezz' ),
				'title' => sprintf( /* translators: %s: titel van de volgende case */ __( 'Volgende case · %s', 'spotlezz' ), $zijwaarts_titel ),
				'url'   => $zijwaarts_url,
			),
			array(
				'label' => __( 'Conversie', 'spotlezz' ),
				'title' => __( 'Ook zo\'n resultaat? Offerte aanvragen', 'spotlezz' ),
				'url'   => home_url( '/offerte-aanvragen/' ),
			),
		)
	);

endwhile;

get_footer();
