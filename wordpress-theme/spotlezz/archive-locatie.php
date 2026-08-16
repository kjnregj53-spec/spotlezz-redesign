<?php
/**
 * Locaties-hub (/locaties/) — WORDPRESS-BUILD-PLAN.md §3.4 /
 * PHASE-4C-PLAN.md §1.3. Toont alleen de hoofdlocaties (steden,
 * `post_parent = 0`) — wijken horen bij hun stad-pagina (rij 5 op
 * single-locatie.php), niet nogmaals los in deze hub. Hergebruikt de
 * generieke tegel-markup/CSS (`.services-grid`/`.service-tile`) i.p.v.
 * een nieuwe kaartstijl voor hetzelfde "tegel met foto en label"-patroon.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<div class="hub-page-header"><h1><?php esc_html_e( 'Onze locaties', 'spotlezz' ); ?></h1></div>

<?php
$steden = get_posts(
	array(
		'post_type'      => 'locatie',
		'post_status'    => 'publish',
		'post_parent'    => 0,
		'posts_per_page' => -1,
		'orderby'        => 'title',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	)
);
?>
<?php if ( ! empty( $steden ) ) : ?>
	<section class="services-block">
		<div class="services-grid">
			<?php foreach ( $steden as $stad ) : ?>
				<a class="service-tile" href="<?php echo esc_url( get_permalink( $stad ) ); ?>">
					<?php $thumb_url = get_the_post_thumbnail_url( $stad, 'spotlezz-card' ); ?>
					<?php if ( $thumb_url ) : ?>
						<img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( spotlezz_post_thumbnail_alt( $stad->ID, get_the_title( $stad ) ) ); ?>" loading="lazy" decoding="async">
					<?php endif; ?>
					<span class="service-tile-label"><?php echo esc_html( get_the_title( $stad ) ); ?></span>
				</a>
			<?php endforeach; ?>
		</div>
	</section>
<?php elseif ( current_user_can( 'edit_theme_options' ) ) : ?>
	<p class="placeholder-note content-placeholder"><?php esc_html_e( 'Nog geen locaties gepubliceerd.', 'spotlezz' ); ?></p>
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
