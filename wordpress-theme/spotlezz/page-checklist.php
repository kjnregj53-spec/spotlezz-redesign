<?php
/**
 * De Spotlezz-check — lead magnet, bestond nog niet als pagina terwijl de
 * homepage-CTA ("Doe de Spotlezz-check") en de header/mobiele nav er al wel
 * naar linken (/checklist/). Tekst 1-op-1 overgenomen uit
 * docs/content/spotlezz_content_inventory.md, sectie "De Spotlezz-check".
 *
 * Zelfde regel als spotlezz_conversion_variant_a() (PHASE-4C-PLAN.md
 * beslissing 5): visueel formulier, geen `action`/`method`, verstuurt niets.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	/* Intro-alinea 1-op-1 van de referentie's checklist-hero, verplaatst
	   van een losse sectie ná de hero naar de hero zelf. */
	spotlezz_page_hero(
		__( 'Is jouw bedrijf Spotlezz? Doe de check!', 'spotlezz' ),
		spotlezz_get_option( 'page_hero_diensten_cases' ),
		'',
		__( 'Ontdek welke details vaak over het hoofd worden gezien, en waarom wij altijd een stapje extra zetten voor het ultieme eindresultaat.', 'spotlezz' )
	);
	?>
	<article <?php post_class( 'checklist-single' ); ?> id="post-<?php the_ID(); ?>">

		<?php
		/*
		 * 1-op-1 van de referentie's checklist-pagina: twee tekst+foto-rijen
		 * (uitleg + oranje offset-kader, dan voorbeeldfoto + echt formulier)
		 * i.p.v. de eerdere platte tekst + los mini-formuliertje. Beide
		 * foto's (#118 checklist-achtergrond, #117 checklist-preview) zijn
		 * dezelfde, al bevestigde echte foto's als in de referentie.
		 */
		$img_uitleg  = wp_get_attachment_image_url( 118, 'large' );
		$img_preview = wp_get_attachment_image_url( 117, 'large' );
		$content_id  = get_the_ID();
		?>
		<section class="ks-text-image">
			<div class="ks-ti-content">
				<h2><?php echo esc_html( spotlezz_field( 'checklist_uitleg_heading', $content_id, __( 'Wat is de Spotlezz-checklist?', 'spotlezz' ) ) ); ?></h2>
				<p><?php echo esc_html( spotlezz_field( 'checklist_uitleg_p1', $content_id, __( 'De Spotlezz-checklist is de dagelijkse kwaliteitscontrole die onze schoonmakers uitvoeren bij onze klanten. Door de check te doen zie je in één oogopslag het verschil tussen schoon en Spotlezz.', 'spotlezz' ) ) ); ?></p>
				<p><?php echo esc_html( spotlezz_field( 'checklist_uitleg_p2', $content_id, __( 'Het zijn de details die een groot verschil maken, en die ontdek je pas als je er met een scherp oog naar kijkt. Denk aan prullenbakken, stoelpoten, toetsenborden of lichtschakelaars.', 'spotlezz' ) ) ); ?></p>
				<p><strong><?php echo esc_html( spotlezz_field( 'checklist_uitleg_bold', $content_id, __( 'Want schoon kan altijd schoner.', 'spotlezz' ) ) ); ?></strong></p>
			</div>
			<?php if ( $img_uitleg ) : ?>
				<div class="ks-ti-image ks-ti-image-offset">
					<img src="<?php echo esc_url( $img_uitleg ); ?>" alt="<?php esc_attr_e( 'Spotlezz Checklist', 'spotlezz' ); ?>" loading="lazy" decoding="async">
				</div>
			<?php endif; ?>
		</section>

		<section class="ks-text-image ks-reverse">
			<div class="ks-ti-content">
				<h2><?php echo esc_html( spotlezz_field( 'checklist_form_heading', $content_id, __( 'Doe nu de Spotlezz-check', 'spotlezz' ) ) ); ?></h2>
				<p><?php echo esc_html( spotlezz_field( 'checklist_form_intro', $content_id, __( 'Kijk met onze frisse blik naar jouw bedrijfsschoonmaak. Vul je e-mailadres in en ontvang de checklist binnen 1 minuut in je inbox.', 'spotlezz' ) ) ); ?></p>
				<div class="checklist-form-box">
					<form class="sp-form" onsubmit="return false;">
						<div class="form-group">
							<label for="checklist-email"><?php esc_html_e( 'E-mailadres', 'spotlezz' ); ?></label>
							<input type="email" id="checklist-email" name="email" autocomplete="email" placeholder="<?php esc_attr_e( 'naam@bedrijf.nl', 'spotlezz' ); ?>" required>
						</div>
						<div class="form-consent">
							<input type="checkbox" id="checklist-akkoord" name="akkoord" required>
							<label for="checklist-akkoord"><?php echo wp_kses_post( sprintf( /* translators: %s: link naar privacybeleid */ __( 'Akkoord met het %s.', 'spotlezz' ), '<a href="' . esc_url( home_url( '/privacybeleid/' ) ) . '">' . esc_html__( 'privacybeleid', 'spotlezz' ) . '</a>' ) ); ?></label>
						</div>
						<button type="submit" class="btn btn-orange"><?php esc_html_e( 'Vraag de checklist aan', 'spotlezz' ); ?></button>
					</form>
				</div>
			</div>
			<?php if ( $img_preview ) : ?>
				<div class="ks-ti-image">
					<img src="<?php echo esc_url( $img_preview ); ?>" alt="<?php esc_attr_e( 'Doe de check', 'spotlezz' ); ?>" loading="lazy" decoding="async">
				</div>
			<?php endif; ?>
		</section>

		<?php spotlezz_reviews_block(); ?>

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
			'title' => __( 'Bekijk onze diensten', 'spotlezz' ),
			'url'   => get_post_type_archive_link( 'pillar' ) ?: home_url( '/diensten/' ),
		),
		array(
			'label' => __( 'Conversie', 'spotlezz' ),
			'title' => __( 'Vraag een offerte aan', 'spotlezz' ),
			'url'   => home_url( '/offerte-aanvragen/' ),
		),
	)
);

get_footer();
