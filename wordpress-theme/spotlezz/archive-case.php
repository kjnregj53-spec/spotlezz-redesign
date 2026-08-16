<?php
/**
 * Klantcases-hub (/klantcases/) — WORDPRESS-BUILD-PLAN.md §3.3 /
 * PHASE-4C-PLAN.md §1.2. Simpele lijst van alle gepubliceerde cases,
 * zelfde kaart-markup/CSS als het klantcases-blok op de (bevroren)
 * homepage (`.case-card`/`.case-card-body`), zodat er geen nieuwe
 * component-stijl bijkomt voor hetzelfde soort kaart.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<div class="hub-page-header"><h1><?php esc_html_e( 'Klantcases', 'spotlezz' ); ?></h1></div>

<?php if ( have_posts() ) : ?>
	<section class="cases-block">
		<div class="cases-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<a class="case-card" href="<?php the_permalink(); ?>">
					<?php $thumb_url = get_the_post_thumbnail_url( get_the_ID(), 'spotlezz-card' ); ?>
					<?php if ( $thumb_url ) : ?>
						<img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( spotlezz_post_thumbnail_alt( get_the_ID(), get_the_title() ) ); ?>" loading="lazy" decoding="async">
					<?php endif; ?>
					<div class="case-card-body">
						<h3><?php the_title(); ?></h3>
						<?php $excerpt = get_the_excerpt(); ?>
						<?php if ( $excerpt ) : ?>
							<p><?php echo esc_html( $excerpt ); ?></p>
						<?php endif; ?>
					</div>
				</a>
				<?php
			endwhile;
			?>
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
