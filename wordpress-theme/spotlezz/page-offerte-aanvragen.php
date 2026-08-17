<?php
/**
 * Offerte aanvragen — de belangrijkste conversiepagina van de site: elke
 * CTA-knop in het theme (header, mobile-sticky-cta, pillar-hero-cta-card,
 * werkwijze-cta, next-hop) linkt hierheen via home_url('/offerte-aanvragen/').
 * Tot nu toe bestond deze pagina niet, dus die link gaf een 404.
 *
 * Zelfde regel als spotlezz_conversion_variant_a() (PHASE-4C-PLAN.md
 * beslissing 5, APPROVED): dit is de VISUELE snelofferte-kaart die al op
 * elke pillar-pagina staat, hier uitgewerkt tot volwaardig formulier. Geen
 * `action`/`method`, verstuurt niets — er bestaat nog geen FORM_ENDPOINT-
 * laag in dit theme. De echte verzendlaag is een aparte, latere stap.
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

	/*
	 * 1-op-1 van de referentie's offerte-aanvragen-pagina: géén foto-hero
	 * hier — een platte, gecentreerde kop op wit, met daaronder oranje
	 * kengetallen links en het formulier in een lichtgrijze kaart rechts
	 * (i.p.v. de eerdere .stat-block boven het formulier).
	 */
	spotlezz_breadcrumb();
	?>
	<article <?php post_class( 'offerte-single' ); ?> id="post-<?php the_ID(); ?>">

		<section class="offerte-hero-plain">
			<h1>
				<?php echo esc_html( spotlezz_field( 'offerte_hero_prefix', $post_id, __( 'Ontvang een', 'spotlezz' ) ) ); ?>
				<span><?php echo esc_html( spotlezz_field( 'offerte_hero_highlight', $post_id, __( 'offerte op maat', 'spotlezz' ) ) ); ?></span>
				<?php echo esc_html( spotlezz_field( 'offerte_hero_suffix', $post_id, __( 'voor jouw bedrijf', 'spotlezz' ) ) ); ?>
			</h1>
		</section>

		<div class="offerte-split">
			<div class="offerte-kengetallen">
				<?php
				$kengetallen = array(
					array( 'value' => spotlezz_get_option( 'review_score' ) . '/5', 'label' => __( 'Recensies op Google', 'spotlezz' ) ),
					array( 'value' => spotlezz_get_option( 'review_count' ) . '+', 'label' => __( 'Tevreden klanten', 'spotlezz' ) ),
					array( 'value' => '94%', 'label' => __( 'Klanten verlengen hun contract', 'spotlezz' ) ),
				);
				foreach ( $kengetallen as $item ) :
					?>
					<div class="offerte-kengetal">
						<div class="offerte-kengetal-value"><?php echo esc_html( $item['value'] ); ?></div>
						<div class="offerte-kengetal-label"><?php echo esc_html( $item['label'] ); ?></div>
					</div>
				<?php endforeach; ?>
			</div>
			<form class="offerte-form" onsubmit="return false;">
				<h2><?php esc_html_e( 'Jouw gegevens', 'spotlezz' ); ?></h2>

				<label for="offerte-naam"><?php esc_html_e( 'Naam', 'spotlezz' ); ?></label>
				<input type="text" id="offerte-naam" name="naam" autocomplete="name" required>

				<label for="offerte-bedrijf"><?php esc_html_e( 'Bedrijfsnaam', 'spotlezz' ); ?></label>
				<input type="text" id="offerte-bedrijf" name="bedrijf" autocomplete="organization">

				<div class="offerte-form-row">
					<div>
						<label for="offerte-email"><?php esc_html_e( 'E-mailadres', 'spotlezz' ); ?></label>
						<input type="email" id="offerte-email" name="email" autocomplete="email" required>
					</div>
					<div>
						<label for="offerte-telefoon"><?php esc_html_e( 'Telefoonnummer', 'spotlezz' ); ?></label>
						<input type="tel" id="offerte-telefoon" name="telefoon" autocomplete="tel">
					</div>
				</div>

				<div class="offerte-form-row">
					<div>
						<label for="offerte-m2"><?php esc_html_e( 'Oppervlakte (m²)', 'spotlezz' ); ?></label>
						<input type="number" id="offerte-m2" name="m2" min="0">
					</div>
					<div>
						<label for="offerte-frequentie"><?php esc_html_e( 'Gewenste frequentie', 'spotlezz' ); ?></label>
						<select id="offerte-frequentie" name="frequentie">
							<option value=""><?php esc_html_e( 'Kies een frequentie', 'spotlezz' ); ?></option>
							<option value="1x-per-week"><?php esc_html_e( '1x per week', 'spotlezz' ); ?></option>
							<option value="2-3x-per-week"><?php esc_html_e( '2-3x per week', 'spotlezz' ); ?></option>
							<option value="4-5x-per-week"><?php esc_html_e( '4-5x per week', 'spotlezz' ); ?></option>
							<option value="dagelijks"><?php esc_html_e( 'Dagelijks', 'spotlezz' ); ?></option>
						</select>
					</div>
				</div>

				<label for="offerte-branche"><?php esc_html_e( 'Type bedrijfsruimte', 'spotlezz' ); ?></label>
				<select id="offerte-branche" name="branche">
					<option value=""><?php esc_html_e( 'Kies een type', 'spotlezz' ); ?></option>
					<?php
					$pillars = get_posts(
						array(
							'post_type'      => 'pillar',
							'post_status'    => 'publish',
							'posts_per_page' => -1,
							'orderby'        => 'menu_order title',
							'order'          => 'ASC',
							'no_found_rows'  => true,
						)
					);
					foreach ( $pillars as $pillar ) :
						?>
						<option value="<?php echo esc_attr( $pillar->post_name ); ?>"><?php echo esc_html( get_the_title( $pillar ) ); ?></option>
					<?php endforeach; ?>
				</select>

				<label for="offerte-bericht"><?php esc_html_e( 'Toelichting (optioneel)', 'spotlezz' ); ?></label>
				<textarea id="offerte-bericht" name="bericht" rows="4"></textarea>

				<button type="submit" class="btn btn-orange"><?php esc_html_e( 'Offerte aanvragen', 'spotlezz' ); ?></button>
				<p class="mini offerte-form-note"><?php esc_html_e( 'Vrijblijvend. Je ontvangt binnen 12 uur reactie van ons team.', 'spotlezz' ); ?></p>
			</form>
		</div>

		<?php
		/*
		 * 1-op-1 van de referentie's "Liever even snel bellen?"-sectie:
		 * volle breedte, gecentreerd, i.p.v. een 3e kolom naast het
		 * formulier (waar in de referentie geen ruimte voor was).
		 */
		$phone_raw = spotlezz_get_option( 'phone_raw' );
		?>
		<?php if ( '' !== $phone_raw ) : ?>
			<section class="offerte-bel-cta">
				<div class="offerte-bel-cta-card">
					<h2><?php echo esc_html( spotlezz_field( 'offerte_bel_heading', $post_id, __( 'Liever even snel bellen?', 'spotlezz' ) ) ); ?></h2>
					<p><?php echo esc_html( spotlezz_field( 'offerte_bel_text', $post_id, __( 'Krijg direct antwoord op al uw vragen.', 'spotlezz' ) ) ); ?></p>
					<a href="tel:<?php echo esc_attr( $phone_raw ); ?>" class="btn btn-orange"><?php echo esc_html( spotlezz_get_option( 'phone' ) ); ?></a>
				</div>
			</section>
		<?php endif; ?>

		<?php spotlezz_werkwijze_vergelijking_block(); ?>

		<?php spotlezz_reviews_block(); ?>

	</article>
	<?php
endwhile;

spotlezz_next_hop(
	array(
		array(
			'label' => __( 'Omhoog', 'spotlezz' ),
			'title' => __( 'Alle diensten', 'spotlezz' ),
			'url'   => get_post_type_archive_link( 'pillar' ) ?: home_url( '/diensten/' ),
		),
		array(
			'label' => __( 'Zijwaarts', 'spotlezz' ),
			'title' => __( 'Bekijk klantcases', 'spotlezz' ),
			'url'   => get_post_type_archive_link( 'case' ) ?: home_url( '/klantcases/' ),
		),
		array(
			'label' => __( 'Conversie', 'spotlezz' ),
			'title' => __( 'Bel direct', 'spotlezz' ),
			'url'   => ( '' !== spotlezz_get_option( 'phone_raw' ) ) ? 'tel:' . spotlezz_get_option( 'phone_raw' ) : home_url( '/contact/' ),
		),
	)
);

get_footer();
