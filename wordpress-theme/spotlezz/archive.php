<?php
/**
 * Generieke archief-/hub-template voor pillar, case, locatie en vraag.
 * Fase 4A: eenvoudige lijst zodat elke hub-URL (/diensten/, /klantcases/,
 * /locaties/, /veelgestelde-vragen/) al werkt en linkbaar is. De echte
 * hub-lay-outs per wireframe (filters, thema-groepering, kaartgrids) zijn
 * fase 4B/4C-werk.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="content-wrap">
	<h1><?php echo esc_html( post_type_archive_title( '', false ) ); ?></h1>

	<?php if ( have_posts() ) : ?>
		<ul class="archive-list">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<li>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</li>
				<?php
			endwhile;
			?>
		</ul>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'Nog geen content in deze sectie.', 'spotlezz' ); ?></p>
	<?php endif; ?>
</div>

<?php
spotlezz_next_hop(
	array(
		array(
			'label' => __( 'Omhoog', 'spotlezz' ),
			'title' => __( 'Terug naar home', 'spotlezz' ),
			'url'   => home_url( '/' ),
		),
		array(
			'label' => __( 'Zijwaarts', 'spotlezz' ),
			'title' => __( 'Bekijk onze diensten', 'spotlezz' ),
			'url'   => get_post_type_archive_link( 'pillar' ) ?: home_url( '/diensten/' ),
		),
		array(
			'label' => __( 'Conversie', 'spotlezz' ),
			'title' => __( 'Offerte aanvragen', 'spotlezz' ),
			'url'   => home_url( '/offerte-aanvragen/' ),
		),
	)
);

get_footer();
