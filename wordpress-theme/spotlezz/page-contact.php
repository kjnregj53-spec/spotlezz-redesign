<?php
/**
 * Contact — bestond nog niet als WordPress-pagina, terwijl de hoofdnavigatie
 * er al wel naar linkt. Tekst 1-op-1 overgenomen uit
 * docs/content/spotlezz_content_inventory.md, sectie "Contact Us". Zelfde
 * regel als page-offerte-aanvragen.php: visueel formulier, geen
 * `action`/`method`, verstuurt niets (PHASE-4C-PLAN.md beslissing 5).
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	/*
	 * Kicker + intro-alinea 1-op-1 van de referentie's contact-hero
	 * ("We horen graag van je" + de intro die hier eerder in een losse
	 * .offerte-lead-sectie ná de hero stond) — nu in de hero zelf, zodat
	 * de sectie dezelfde hoogte/verhouding krijgt als in de referentie.
	 */
	spotlezz_page_hero(
		__( 'Neem contact met ons op', 'spotlezz' ),
		spotlezz_get_option( 'page_hero_diensten_cases' ),
		__( 'We horen graag van je', 'spotlezz' ),
		__( 'Heb jij interesse in onze diensten of een vraag? Neem vrijblijvend contact met ons op. We helpen je graag en snel verder.', 'spotlezz' )
	);
	?>
	<article <?php post_class( 'contact-single' ); ?> id="post-<?php the_ID(); ?>">

		<?php
		/*
		 * 1-op-1 van de referentie's contact-layout: links een infokolom
		 * ("Kom in contact" + 3 iconkaarten telefoon/e-mail/werkgebied),
		 * rechts een witte formulierkaart — i.p.v. de eerdere donkere
		 * .offerte-side-kaart die hier niet in de referentie staat.
		 */
		$phone_raw = spotlezz_get_option( 'phone_raw' );
		$phone     = spotlezz_get_option( 'phone' );
		$email     = spotlezz_get_option( 'email' );
		$page_id   = get_the_ID();
		?>
		<div class="contact-layout">
			<div class="contact-info">
				<h2><?php echo esc_html( spotlezz_field( 'contact_info_heading', $page_id, __( 'Kom in contact', 'spotlezz' ) ) ); ?></h2>
				<p><?php echo esc_html( spotlezz_field( 'contact_info_intro', $page_id, __( 'Of je nu vragen hebt over onze diensten, een afspraak wilt inplannen of gewoon even wilt sparren over de mogelijkheden voor jouw kantoor, wij staan voor je klaar.', 'spotlezz' ) ) ); ?></p>

				<div class="contact-info-cards">
					<?php if ( '' !== $phone_raw ) : ?>
						<a class="contact-info-card" href="tel:<?php echo esc_attr( $phone_raw ); ?>">
							<span class="contact-info-icon" aria-hidden="true">
								<svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.6 10.8c1.4 2.7 3.6 5 6.4 6.4l2.1-2.1c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.5.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.9 21 3 13.1 3 3.4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.2.2 2.4.6 3.5.1.4 0 .8-.2 1L6.6 10.8z"></path></svg>
							</span>
							<span>
								<span class="contact-info-card-label"><?php esc_html_e( 'Bel ons', 'spotlezz' ); ?></span>
								<span class="contact-info-card-value"><?php echo esc_html( $phone ); ?></span>
							</span>
						</a>
					<?php endif; ?>
					<?php if ( '' !== $email ) : ?>
						<a class="contact-info-card" href="mailto:<?php echo esc_attr( $email ); ?>">
							<span class="contact-info-icon" aria-hidden="true">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="M3 7l9 6 9-6"></path></svg>
							</span>
							<span>
								<span class="contact-info-card-label"><?php esc_html_e( 'E-mail ons', 'spotlezz' ); ?></span>
								<span class="contact-info-card-value"><?php echo esc_html( $email ); ?></span>
							</span>
						</a>
					<?php endif; ?>
					<div class="contact-info-card">
						<span class="contact-info-icon" aria-hidden="true">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s-7-6.1-7-11a7 7 0 1 1 14 0c0 4.9-7 11-7 11z"></path><circle cx="12" cy="10" r="2.5"></circle></svg>
						</span>
						<span>
							<span class="contact-info-card-label"><?php esc_html_e( 'Werkgebied', 'spotlezz' ); ?></span>
							<span class="contact-info-card-value"><?php echo esc_html( spotlezz_field( 'contact_werkgebied', $page_id, __( 'Almere, Lelystad, Amsterdam en Amersfoort', 'spotlezz' ) ) ); ?></span>
						</span>
					</div>
				</div>
			</div>

			<div class="contact-form-wrap">
				<div class="contact-form-card">
					<h3><?php echo esc_html( spotlezz_field( 'contact_form_heading', $page_id, __( 'Stuur een bericht', 'spotlezz' ) ) ); ?></h3>
					<form class="contact-form" onsubmit="return false;">
						<div class="contact-form-row">
							<div>
								<label for="contact-naam"><?php esc_html_e( 'Naam', 'spotlezz' ); ?></label>
								<input type="text" id="contact-naam" name="naam" autocomplete="name" placeholder="<?php esc_attr_e( 'Volledige naam', 'spotlezz' ); ?>" required>
							</div>
							<div>
								<label for="contact-bedrijf"><?php esc_html_e( 'Bedrijfsnaam', 'spotlezz' ); ?></label>
								<input type="text" id="contact-bedrijf" name="bedrijf" autocomplete="organization" placeholder="<?php esc_attr_e( 'Jouw bedrijf', 'spotlezz' ); ?>" required>
							</div>
						</div>
						<div class="contact-form-row">
							<div>
								<label for="contact-email"><?php esc_html_e( 'E-mailadres', 'spotlezz' ); ?></label>
								<input type="email" id="contact-email" name="email" autocomplete="email" placeholder="<?php esc_attr_e( 'naam@bedrijf.nl', 'spotlezz' ); ?>" required>
							</div>
							<div>
								<label for="contact-telefoon"><?php esc_html_e( 'Telefoonnummer', 'spotlezz' ); ?></label>
								<input type="tel" id="contact-telefoon" name="telefoon" autocomplete="tel" placeholder="06 12345678" required>
							</div>
						</div>
						<label for="contact-bericht"><?php esc_html_e( 'Bericht', 'spotlezz' ); ?></label>
						<textarea id="contact-bericht" name="bericht" rows="4" placeholder="<?php esc_attr_e( 'Waar kunnen wij mee helpen?', 'spotlezz' ); ?>" required></textarea>

						<label class="contact-form-consent">
							<input type="checkbox" id="contact-akkoord" name="akkoord" required>
							<?php
							printf(
								/* translators: %s: link naar privacybeleid */
								esc_html__( 'Ik ga akkoord met het %s en met het opnemen van contact over deze aanvraag.', 'spotlezz' ),
								'<a href="' . esc_url( home_url( '/privacybeleid/' ) ) . '">' . esc_html__( 'privacybeleid', 'spotlezz' ) . '</a>'
							);
							?>
						</label>

						<button type="submit" class="btn btn-orange"><?php esc_html_e( 'Versturen', 'spotlezz' ); ?></button>
					</form>
				</div>
			</div>
		</div>

		<div class="contact-map-placeholder content-placeholder">
			<?php esc_html_e( '[ Google Maps integratie Almere / Flevoland ]', 'spotlezz' ); ?>
		</div>

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
			'title' => __( 'Veelgestelde vragen', 'spotlezz' ),
			'url'   => get_post_type_archive_link( 'vraag' ) ?: home_url( '/veelgestelde-vragen/' ),
		),
		array(
			'label' => __( 'Conversie', 'spotlezz' ),
			'title' => __( 'Vraag een offerte aan', 'spotlezz' ),
			'url'   => home_url( '/offerte-aanvragen/' ),
		),
	)
);

get_footer();
