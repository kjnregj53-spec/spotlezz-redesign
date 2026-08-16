<?php
/**
 * Diensten-hub (/diensten/) — WORDPRESS-BUILD-PLAN.md §3.2 /
 * PHASE-4C-PLAN.md §1.1. Twee assen, zelfde onderscheid en markup als het
 * diensten-blok op de (bevroren) homepage: een pillar met minimaal één
 * `branche`-term hoort bij "Voor wie", een pillar zonder branche-term
 * hoort bij "Wat we doen". Bewust hier opnieuw opgebouwd i.p.v. front-
 * page.php aan te roepen — dat bestand is bevroren sinds fase 4B/4C-stap-1
 * en wordt niet nogmaals aangeraakt voor een hub-pagina die het niet zelf
 * nodig heeft.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<div class="hub-page-header"><h1><?php esc_html_e( 'Onze diensten', 'spotlezz' ); ?></h1></div>

<?php
$all_pillars  = get_posts(
	array(
		'post_type'      => 'pillar',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order title',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	)
);
$branche_axis = array();
$dienst_axis  = array();
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
<?php elseif ( current_user_can( 'edit_theme_options' ) ) : ?>
	<p class="placeholder-note content-placeholder"><?php esc_html_e( 'Nog geen diensten (pillar-posts) gepubliceerd.', 'spotlezz' ); ?></p>
<?php endif; ?>

<?php
spotlezz_next_hop(
	array(
		array(
			'label' => __( 'Omhoog', 'spotlezz' ),
			'title' => __( 'Naar de homepage', 'spotlezz' ),
			'url'   => home_url( '/' ),
		),
		array(
			'label' => __( 'Zijwaarts', 'spotlezz' ),
			'title' => __( 'Bekijk onze klantcases', 'spotlezz' ),
			'url'   => get_post_type_archive_link( 'case' ) ?: home_url( '/klantcases/' ),
		),
		array(
			'label' => __( 'Conversie', 'spotlezz' ),
			'title' => __( 'Offerte aanvragen', 'spotlezz' ),
			'url'   => home_url( '/offerte-aanvragen/' ),
		),
	)
);

get_footer();
