<?php
/**
 * FAQ-detailpagina — WORDPRESS-BUILD-PLAN.md §3.5 / PHASE-4C-PLAN.md §3,
 * wireframe-3-faq-FINAL.html. Velden komen uit inc/acf-vraag.php.
 *
 * Schema: `QAPage` op elke detailpagina (de hub, archive-vraag.php, krijgt
 * straks `FAQPage` — dat onderscheid staat vast in het bouwplan).
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

	$kort_antwoord = spotlezz_field( 'kort_antwoord', $post_id, '' );
	$verdieping    = spotlezz_field( 'verdieping', $post_id, '' );

	$factoren = array();
	for ( $i = 1; $i <= 6; $i++ ) {
		$label = spotlezz_field( "factor_{$i}_label", $post_id, '' );
		if ( $label ) {
			$factoren[] = $label;
		}
	}
	$verdieping_foto = spotlezz_field( 'verdieping_foto', $post_id, null );

	$gerelateerde_pillar = spotlezz_field( 'gerelateerde_pillar', $post_id, array() );
	$gerelateerde_pillar = array_filter(
		is_array( $gerelateerde_pillar ) ? $gerelateerde_pillar : array(),
		function ( $p ) {
			return $p instanceof WP_Post && 'publish' === $p->post_status;
		}
	);
	?>
	<article <?php post_class( 'vraag-single' ); ?> id="post-<?php the_ID(); ?>">
		<h1><?php the_title(); ?></h1>

		<!-- Rij 3: het korte antwoord -->
		<?php if ( $kort_antwoord ) : ?>
			<div class="kort-antwoord-block">
				<span class="lbl">&#9656; <?php esc_html_e( 'Het korte antwoord', 'spotlezz' ); ?></span>
				<p><?php echo esc_html( $kort_antwoord ); ?></p>
			</div>
			<?php
			add_filter(
				'spotlezz_schema_graph',
				function ( $graph ) use ( $kort_antwoord ) {
					$graph[] = array(
						'@type'          => 'QAPage',
						'mainEntity'     => array(
							'@type'          => 'Question',
							'name'           => wp_strip_all_tags( get_the_title() ),
							'acceptedAnswer' => array(
								'@type' => 'Answer',
								'text'  => wp_strip_all_tags( $kort_antwoord ),
							),
						),
					);
					return $graph;
				}
			);
			?>
		<?php elseif ( current_user_can( 'edit_theme_options' ) ) : ?>
			<p class="placeholder-note content-placeholder"><?php esc_html_e( 'Nog geen kort antwoord ingevuld in het veld "Het korte antwoord". Alleen zichtbaar voor ingelogde beheerders.', 'spotlezz' ); ?></p>
		<?php endif; ?>

		<!-- Rij 4: verdieping, alleen bij eigen detailpagina -->
		<?php if ( $verdieping || ! empty( $factoren ) ) : ?>
			<section class="verdieping-block">
				<?php if ( $verdieping ) : ?>
					<div class="verdieping-tekst"><?php echo wp_kses_post( $verdieping ); ?></div>
				<?php endif; ?>

				<?php if ( ! empty( $factoren ) ) : ?>
					<div class="factor-grid">
						<?php foreach ( $factoren as $factor ) : ?>
							<div class="factor-tile"><?php echo esc_html( $factor ); ?></div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php if ( is_array( $verdieping_foto ) && ! empty( $verdieping_foto['url'] ) ) : ?>
					<figure class="verdieping-foto">
						<img src="<?php echo esc_url( $verdieping_foto['url'] ); ?>" alt="<?php echo esc_attr( spotlezz_image_alt( $verdieping_foto, get_the_title() ) ); ?>" loading="lazy" decoding="async">
					</figure>
				<?php endif; ?>
			</section>
		<?php endif; ?>

		<!-- Rij 5: conversieblok, Variant A (visueel, fase 4C) -->
		<?php spotlezz_conversion_variant_a(); ?>
	</article>
	<?php

	// Rij 6: next-hop — zijwaarts naar de gerelateerde pillar (precies 1,
	// regel uit het bouwplan: nooit naar de hub of naar drie diensten).
	$zijwaarts_url   = get_post_type_archive_link( 'pillar' ) ?: home_url( '/diensten/' );
	$zijwaarts_titel = __( 'Bekijk de bijbehorende dienst', 'spotlezz' );
	if ( ! empty( $gerelateerde_pillar ) ) {
		$pillar          = reset( $gerelateerde_pillar );
		$zijwaarts_url   = get_permalink( $pillar );
		$zijwaarts_titel = get_the_title( $pillar );
	}
endwhile;

spotlezz_next_hop(
	array(
		array(
			'label' => __( 'Omhoog', 'spotlezz' ),
			'title' => __( 'Alle veelgestelde vragen', 'spotlezz' ),
			'url'   => get_post_type_archive_link( 'vraag' ) ?: home_url( '/veelgestelde-vragen/' ),
		),
		array(
			'label' => __( 'Zijwaarts', 'spotlezz' ),
			'title' => $zijwaarts_titel,
			'url'   => $zijwaarts_url,
		),
		array(
			'label' => __( 'Conversie', 'spotlezz' ),
			'title' => __( 'Offerte op maat aanvragen', 'spotlezz' ),
			'url'   => home_url( '/offerte-aanvragen/' ),
		),
	)
);

get_footer();
