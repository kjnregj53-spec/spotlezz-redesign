<?php
/**
 * Sluit <main> af (geopend in header.php — samen zijn dit de enige twee
 * plekken in het theme waar dat tag voorkomt, harde regel 4) en rendert de
 * footer, exact één keer per pagina (harde regel 2).
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
</main>

<footer class="site-footer">
	<div class="footer-overlay"></div>
	<div class="footer-container">
		<div class="footer-col">
			<div class="footer-logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Naar de homepage', 'spotlezz' ); ?>">
					<?php
					if ( has_custom_logo() ) {
						the_custom_logo();
					} else {
						bloginfo( 'name' );
					}
					?>
				</a>
			</div>
			<p class="footer-desc"><?php esc_html_e( 'Het beste schoonmaakbedrijf in', 'spotlezz' ); ?><br><?php esc_html_e( 'Almere en omgeving!', 'spotlezz' ); ?></p>
			<div class="footer-nap">
				<?php
				$street   = spotlezz_get_option( 'address_street' );
				$postcode = spotlezz_get_option( 'address_postcode' );
				$city     = spotlezz_get_option( 'address_city' );
				$hours    = spotlezz_get_option( 'opening_hours' );
				$kvk      = spotlezz_get_option( 'kvk' );
				?>
				<?php if ( '' !== $street || '' !== $city ) : ?>
					<span><?php echo esc_html( trim( $street . ', ' . $postcode . ' ' . $city, ', ' ) ); ?></span>
				<?php endif; ?>
				<?php if ( '' !== $hours ) : ?>
					<span><?php echo esc_html( $hours ); ?></span>
				<?php endif; ?>
				<?php if ( '' !== $kvk ) : ?>
					<span><?php echo esc_html( 'KVK ' . $kvk ); ?></span>
				<?php endif; ?>
			</div>
			<?php
			$social_instagram = spotlezz_get_option( 'social_instagram' );
			$social_linkedin  = spotlezz_get_option( 'social_linkedin' );
			?>
			<?php if ( '' !== $social_instagram || '' !== $social_linkedin ) : ?>
				<div class="social-icons">
					<?php if ( '' !== $social_instagram ) : ?>
						<a href="<?php echo esc_url( $social_instagram ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
							<svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" focusable="false"><path fill="currentColor" d="M12 2.2c3.2 0 3.6 0 4.8.1 1.2.1 2 .2 2.5.4a5 5 0 0 1 1.8 1.2 5 5 0 0 1 1.2 1.8c.2.5.4 1.3.4 2.5.1 1.2.1 1.6.1 4.8s0 3.6-.1 4.8c-.1 1.2-.2 2-.4 2.5a5 5 0 0 1-1.2 1.8 5 5 0 0 1-1.8 1.2c-.5.2-1.3.4-2.5.4-1.2.1-1.6.1-4.8.1s-3.6 0-4.8-.1c-1.2-.1-2-.2-2.5-.4a5 5 0 0 1-1.8-1.2 5 5 0 0 1-1.2-1.8c-.2-.5-.4-1.3-.4-2.5C2.2 15.6 2.2 15.2 2.2 12s0-3.6.1-4.8c.1-1.2.2-2 .4-2.5a5 5 0 0 1 1.2-1.8 5 5 0 0 1 1.8-1.2c.5-.2 1.3-.4 2.5-.4C8.4 2.2 8.8 2.2 12 2.2zm0 3.5A6.3 6.3 0 1 0 12 18.3 6.3 6.3 0 0 0 12 5.7zm0 10.4a4.1 4.1 0 1 1 0-8.3 4.1 4.1 0 0 1 0 8.3zm6.5-10.7a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"></path></svg>
						</a>
					<?php endif; ?>
					<?php if ( '' !== $social_linkedin ) : ?>
						<a href="<?php echo esc_url( $social_linkedin ); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
							<svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" focusable="false"><path fill="currentColor" d="M20.4 20.4h-3.5v-5.6c0-1.3 0-3-1.9-3s-2.1 1.4-2.1 2.9v5.7H9.4V9h3.4v1.6h.1c.5-.9 1.6-1.9 3.4-1.9 3.6 0 4.3 2.4 4.3 5.5v6.2zM5.3 7.4a2 2 0 1 1 0-4 2 2 0 0 1 0 4zM7 20.4H3.6V9H7v11.4z"></path></svg>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>

		<?php $diensten_nav_groups = spotlezz_diensten_nav_groups(); ?>
		<div class="footer-col">
			<h3><?php esc_html_e( 'Voor wie', 'spotlezz' ); ?></h3>
			<ul class="footer-links">
				<?php foreach ( $diensten_nav_groups['voor_wie'] as $pillar ) : ?>
					<li><a href="<?php echo esc_url( get_permalink( $pillar ) ); ?>"><?php echo esc_html( get_the_title( $pillar ) ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div class="footer-col">
			<h3><?php esc_html_e( 'Wat we doen', 'spotlezz' ); ?></h3>
			<ul class="footer-links">
				<?php foreach ( $diensten_nav_groups['wat_we_doen'] as $pillar ) : ?>
					<li><a href="<?php echo esc_url( get_permalink( $pillar ) ); ?>"><?php echo esc_html( get_the_title( $pillar ) ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div class="footer-col">
			<h3><?php esc_html_e( 'Werkgebied', 'spotlezz' ); ?></h3>
			<ul class="footer-links">
				<?php
				$werkgebied_slugs = array( 'almere', 'lelystad', 'amsterdam', 'amersfoort' );
				foreach ( $werkgebied_slugs as $slug ) :
					$locatie = get_page_by_path( $slug, OBJECT, 'locatie' );
					if ( $locatie && 'publish' === $locatie->post_status ) :
						?>
						<li><a href="<?php echo esc_url( get_permalink( $locatie ) ); ?>"><?php echo esc_html( sprintf( __( 'Schoonmaakbedrijf %s', 'spotlezz' ), get_the_title( $locatie ) ) ); ?></a></li>
						<?php
					endif;
				endforeach;
				?>
				<li><a href="<?php echo esc_url( get_post_type_archive_link( 'locatie' ) ?: home_url( '/locaties/' ) ); ?>"><?php esc_html_e( 'Alle locaties', 'spotlezz' ); ?></a></li>
			</ul>
		</div>

		<div class="footer-col">
			<h3><?php esc_html_e( 'Over Spotlezz', 'spotlezz' ); ?></h3>
			<ul class="footer-links">
				<li><a href="<?php echo esc_url( home_url( '/over-ons/' ) ); ?>"><?php esc_html_e( 'Over ons', 'spotlezz' ); ?></a></li>
				<li><a href="<?php echo esc_url( get_post_type_archive_link( 'case' ) ?: home_url( '/klantcases/' ) ); ?>"><?php esc_html_e( 'Klantcases', 'spotlezz' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/reviews/' ) ); ?>"><?php esc_html_e( 'Reviews', 'spotlezz' ); ?></a></li>
				<li><a href="<?php echo esc_url( get_post_type_archive_link( 'vraag' ) ?: home_url( '/veelgestelde-vragen/' ) ); ?>"><?php esc_html_e( 'Veelgestelde vragen', 'spotlezz' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/vacatures/' ) ); ?>"><?php esc_html_e( 'Vacatures', 'spotlezz' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact', 'spotlezz' ); ?></a></li>
			</ul>
			<div class="footer-contact">
				<?php $phone_raw = spotlezz_get_option( 'phone_raw' ); ?>
				<?php if ( '' !== $phone_raw ) : ?>
					<span><span class="footer-contact-label"><?php esc_html_e( 'T:', 'spotlezz' ); ?></span> <a href="tel:<?php echo esc_attr( $phone_raw ); ?>"><?php echo esc_html( spotlezz_get_option( 'phone' ) ); ?></a></span>
				<?php endif; ?>
				<?php $email = spotlezz_get_option( 'email' ); ?>
				<?php if ( '' !== $email ) : ?>
					<span><span class="footer-contact-label"><?php esc_html_e( 'E:', 'spotlezz' ); ?></span> <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></span>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="footer-bottom">
		<div class="copyright">
			<?php
			printf(
				/* translators: %s: huidig jaar */
				esc_html__( 'Copyright © %s Spotlezz B.V. Alle rechten voorbehouden.', 'spotlezz' ),
				esc_html( gmdate( 'Y' ) )
			);
			?>
		</div>
		<div class="footer-bottom-links">
			<?php
			$privacy_id = get_page_by_path( 'privacybeleid' );
			if ( $privacy_id ) :
				?>
				<a href="<?php echo esc_url( get_permalink( $privacy_id ) ); ?>"><?php esc_html_e( 'Privacybeleid', 'spotlezz' ); ?></a>
			<?php endif; ?>
			<?php $terms_pdf_url = spotlezz_get_option( 'terms_pdf_url' ); ?>
			<?php if ( '' !== $terms_pdf_url ) : ?>
				<a href="<?php echo esc_url( $terms_pdf_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Algemene voorwaarden', 'spotlezz' ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</footer>

<div class="mobile-sticky-cta">
	<?php $phone_raw = spotlezz_get_option( 'phone_raw' ); ?>
	<?php if ( '' !== $phone_raw ) : ?>
		<a href="tel:<?php echo esc_attr( $phone_raw ); ?>" class="btn btn-outline-dark"><?php esc_html_e( 'Bellen', 'spotlezz' ); ?></a>
	<?php endif; ?>
	<a href="<?php echo esc_url( home_url( '/offerte-aanvragen/' ) ); ?>" class="btn btn-orange"><?php esc_html_e( 'Offerte aanvragen', 'spotlezz' ); ?></a>
</div>

<?php wp_footer(); ?>
</body>
</html>
