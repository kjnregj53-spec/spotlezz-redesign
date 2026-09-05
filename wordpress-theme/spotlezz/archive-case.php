<?php
/**
 * Klantcases-overzicht (/klantcases/) — 1-op-1 van spotlezz.vercel.app/
 * klantcases/: een kaartenoverzicht dat naar elke case zijn EIGEN
 * detailpagina linkt (single-case.php), i.p.v. alle cases samengevoegd op
 * één lange pagina. Eerder samengevoegd op expliciet verzoek, nu op
 * klantfeedback teruggedraaid naar een overzicht — single-case.php was al
 * die hele tijd intact gebleven en blijft de bron voor elke kaart.
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
	<section class="klantcases-grid-section">
		<div class="klantcases-grid">
			<?php foreach ( $cases as $case ) : ?>
				<?php
				$post_id  = $case->ID;
				$headline = spotlezz_field( 'headline', $post_id, get_the_title( $case ) );
				$branche  = spotlezz_field( 'branche', $post_id, '' );
				$locatie  = spotlezz_field( 'locatie', $post_id, '' );
				$situatie = spotlezz_field( 'star_situatie', $post_id, '' );
				$teaser   = $situatie ? wp_trim_words( $situatie, 20 ) : '';
				$thumb    = get_the_post_thumbnail_url( $case, 'spotlezz-card' );
				if ( ! $thumb ) {
					$hero_foto = spotlezz_field( 'hero_foto', $post_id, null );
					$thumb     = is_array( $hero_foto ) ? ( $hero_foto['url'] ?? '' ) : '';
				}
				?>
				<a class="klantcase-card" href="<?php echo esc_url( get_permalink( $case ) ); ?>">
					<?php if ( $thumb ) : ?>
						<div class="klantcase-card-image">
							<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( spotlezz_post_thumbnail_alt( $post_id, $headline ) ); ?>" loading="lazy" decoding="async">
						</div>
					<?php endif; ?>
					<div class="klantcase-card-body">
						<?php if ( $branche || $locatie ) : ?>
							<div class="klantcase-card-tags">
								<?php if ( $branche ) : ?><span class="klantcase-card-tag"><?php echo esc_html( $branche ); ?></span><?php endif; ?>
								<?php if ( $locatie ) : ?><span class="klantcase-card-tag"><?php echo esc_html( $locatie ); ?></span><?php endif; ?>
							</div>
						<?php endif; ?>
						<h2><?php echo esc_html( $headline ); ?></h2>
						<?php if ( $teaser ) : ?>
							<p><?php echo esc_html( $teaser ); ?></p>
						<?php endif; ?>
						<span class="klantcase-card-link"><?php esc_html_e( 'Lees de case', 'spotlezz' ); ?> &rarr;</span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</section>
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
