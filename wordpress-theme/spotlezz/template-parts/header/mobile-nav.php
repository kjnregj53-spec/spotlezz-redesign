<?php
/**
 * Mobiele navigatie-overlay. Hergebruikt hetzelfde 'primary'-menu als
 * template-parts/header/navigation.php, zodat er nooit twee menu's
 * onderhouden hoeven te worden.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="mobile-nav-overlay" id="mobileNav" hidden>
	<div class="mobile-nav-header">
		<?php
		if ( has_custom_logo() ) {
			the_custom_logo();
		} else {
			bloginfo( 'name' );
		}
		?>
		<button type="button" class="close-menu-btn" aria-label="<?php esc_attr_e( 'Menu sluiten', 'spotlezz' ); ?>">
			<svg class="icon-close" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true" focusable="false">
				<line x1="4" y1="4" x2="20" y2="20" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"></line>
				<line x1="20" y1="4" x2="4" y2="20" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"></line>
			</svg>
		</button>
	</div>
	<div class="mobile-nav-links">
		<?php
		if ( has_nav_menu( 'primary' ) ) {
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'mobile-menu',
					'depth'          => 2,
				)
			);
		} else {
			/**
			 * Fallback zolang er nog geen menu is aangemaakt — dezelfde vijf
			 * hubs als de desktop-fallback in
			 * template-parts/header/navigation.php. Ontbrak hier eerder:
			 * zonder geregistreerd menu toonde de mobiele overlay nul
			 * navigatielinks (alleen de offerte-knop) — gevonden tijdens het
			 * klik-testen van het mobiele menu in de fase-4B-preview.
			 */
			?>
			<ul class="mobile-menu mobile-menu-fallback">
				<li><a href="<?php echo esc_url( get_post_type_archive_link( 'pillar' ) ?: home_url( '/diensten/' ) ); ?>"><?php esc_html_e( 'Diensten', 'spotlezz' ); ?></a></li>
				<li><a href="<?php echo esc_url( get_post_type_archive_link( 'case' ) ?: home_url( '/klantcases/' ) ); ?>"><?php esc_html_e( 'Klantcases', 'spotlezz' ); ?></a></li>
				<li><a href="<?php echo esc_url( get_post_type_archive_link( 'locatie' ) ?: home_url( '/locaties/' ) ); ?>"><?php esc_html_e( 'Locaties', 'spotlezz' ); ?></a></li>
				<li><a href="<?php echo esc_url( get_post_type_archive_link( 'vraag' ) ?: home_url( '/veelgestelde-vragen/' ) ); ?>"><?php esc_html_e( 'Veelgestelde vragen', 'spotlezz' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/over-ons/' ) ); ?>"><?php esc_html_e( 'Over ons', 'spotlezz' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact', 'spotlezz' ); ?></a></li>
			</ul>
			<?php
		}
		?>
		<a href="<?php echo esc_url( home_url( '/offerte-aanvragen/' ) ); ?>" class="btn btn-orange">
			<?php esc_html_e( 'Offerte aanvragen', 'spotlezz' ); ?>
		</a>
	</div>
</div>
