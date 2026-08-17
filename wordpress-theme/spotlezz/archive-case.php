<?php
/**
 * Klantcases — samengevoegd op één pagina (/klantcases/), op expliciet
 * verzoek: geen aparte hub met alleen kaartjes die naar losse pagina's
 * doorlinken, maar het volledige verhaal van elke case na elkaar op
 * dezelfde pagina. De losse single-case.php-pagina's (bv.
 * /klantcases/kobelco/) blijven wél bestaan — die worden nog steeds
 * gebruikt als deep-link/schema-doel vanuit next-hop-bars, het
 * homepage-portfolio en /reviews/ — dit bestand hergebruikt gewoon
 * dezelfde velden/markup-aanpak, maar dan voor alle cases achter elkaar.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
spotlezz_page_hero(
	__( 'Klantcases', 'spotlezz' ),
	spotlezz_get_option( 'page_hero_diensten_cases' ),
	__( 'Bewijs van onze kwaliteit', 'spotlezz' ),
	__( 'Ontdek hoe wij voor bedrijven in de regio Almere, Lelystad en Amsterdam zorgen voor een streeploos schoon resultaat.', 'spotlezz' )
);

$cases = get_posts(
	array(
		'post_type'      => 'case',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'title',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	)
);
?>

<?php if ( ! empty( $cases ) ) : ?>
	<?php foreach ( $cases as $index => $case ) : ?>
		<?php
		$post_id  = $case->ID;
		$headline = spotlezz_field( 'headline', $post_id, get_the_title( $case ) );
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
		?>
		<article <?php echo 0 === $index ? '' : 'style="border-top:1px solid var(--spotlezz-border);"'; // phpcs:ignore -- static, no user input ?> class="case-single case-merged" id="case-<?php echo esc_attr( $post_id ); ?>">

			<header class="case-hero">
				<div class="case-hero-main">
					<?php if ( is_array( $logo ) && ! empty( $logo['url'] ) ) : ?>
						<img class="case-logo" src="<?php echo esc_url( $logo['url'] ); ?>" alt="<?php echo esc_attr( spotlezz_image_alt( $logo, get_the_title( $case ) ) ); ?>" loading="lazy" decoding="async">
					<?php endif; ?>
					<h2><?php echo esc_html( $headline ); ?></h2>
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

			<?php if ( $star_situatie || $star_uitdaging || $star_aanpak || $star_resultaat ) : ?>
				<section class="case-star">
					<?php if ( $star_situatie ) : ?>
						<div class="star-block">
							<h3><?php esc_html_e( 'De situatie', 'spotlezz' ); ?></h3>
							<p><?php echo esc_html( $star_situatie ); ?></p>
						</div>
					<?php endif; ?>
					<?php if ( $star_uitdaging ) : ?>
						<div class="star-block">
							<h3><?php esc_html_e( 'De uitdaging', 'spotlezz' ); ?></h3>
							<p><?php echo esc_html( $star_uitdaging ); ?></p>
						</div>
					<?php endif; ?>
					<?php if ( $star_aanpak ) : ?>
						<div class="star-block">
							<h3><?php esc_html_e( 'Onze aanpak', 'spotlezz' ); ?></h3>
							<p><?php echo esc_html( $star_aanpak ); ?></p>
						</div>
					<?php endif; ?>
					<?php if ( $star_resultaat ) : ?>
						<div class="star-block">
							<h3><?php esc_html_e( 'Het resultaat', 'spotlezz' ); ?></h3>
							<p><?php echo esc_html( $star_resultaat ); ?></p>
						</div>
					<?php endif; ?>
				</section>
			<?php endif; ?>

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
							'id_suffix' => 'case-merged-' . $post_id . '-contact',
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

			<?php if ( ! empty( $gebruikte_diensten ) ) : ?>
				<section class="case-diensten">
					<h3><?php esc_html_e( 'Gebruikte diensten', 'spotlezz' ); ?></h3>
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
			add_filter(
				'spotlezz_schema_graph',
				function ( $graph ) use ( $headline, $post_id ) {
					$graph[] = array(
						'@type'    => 'Article',
						'headline' => wp_strip_all_tags( $headline ),
						'url'      => get_permalink( $post_id ),
					);
					return $graph;
				}
			);
			?>
		</article>
	<?php endforeach; ?>
<?php elseif ( current_user_can( 'edit_theme_options' ) ) : ?>
	<p class="placeholder-note content-placeholder"><?php esc_html_e( 'Nog geen klantcases gepubliceerd.', 'spotlezz' ); ?></p>
<?php endif; ?>

<?php
spotlezz_next_hop(
	array(
		array(
			'label' => __( 'Omhoog', 'spotlezz' ),
			'title' => __( 'Bekijk onze diensten', 'spotlezz' ),
			'url'   => get_post_type_archive_link( 'pillar' ) ?: home_url( '/diensten/' ),
		),
		array(
			'label' => __( 'Zijwaarts', 'spotlezz' ),
			'title' => __( 'Bekijk onze locaties', 'spotlezz' ),
			'url'   => get_post_type_archive_link( 'locatie' ) ?: home_url( '/locaties/' ),
		),
		array(
			'label' => __( 'Conversie', 'spotlezz' ),
			'title' => __( 'Offerte aanvragen', 'spotlezz' ),
			'url'   => home_url( '/offerte-aanvragen/' ),
		),
	)
);

get_footer();
