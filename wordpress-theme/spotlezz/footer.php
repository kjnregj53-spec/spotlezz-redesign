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
	<div class="footer-container">
		<div class="footer-col footer-col-brand">
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
		</div>

		<div class="footer-col">
			<?php
			if ( has_nav_menu( 'footer' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'menu_class'     => 'footer-links',
						'depth'          => 1,
					)
				);
			}
			?>
		</div>

		<div class="footer-col footer-col-contact">
			<?php $phone_raw = spotlezz_get_option( 'phone_raw' ); ?>
			<?php if ( '' !== $phone_raw ) : ?>
				<a href="tel:<?php echo esc_attr( $phone_raw ); ?>"><?php echo esc_html( spotlezz_get_option( 'phone' ) ); ?></a>
			<?php endif; ?>
			<?php $email = spotlezz_get_option( 'email' ); ?>
			<?php if ( '' !== $email ) : ?>
				<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
			<?php endif; ?>
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
