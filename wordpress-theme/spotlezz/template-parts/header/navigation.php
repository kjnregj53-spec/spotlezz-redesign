<?php
/**
 * Hoofdnavigatie. Gebruikt het WordPress menu-systeem (theme_location
 * 'primary') zodat de vijf hubs uit elke wireframe-rij 1 door de klant
 * zelf beheerd kunnen worden via Weergave → Menu's, zonder theme-code aan
 * te hoeven passen.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<nav class="main-navigation" aria-label="<?php esc_attr_e( 'Hoofdnavigatie', 'spotlezz' ); ?>">
	<?php
	if ( has_nav_menu( 'primary' ) ) {
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'primary-menu',
				'depth'          => 2,
			)
		);
	} else {
		// Fallback zolang er nog geen menu is aangemaakt in het admin, zodat
		// de site tijdens de bouwfase nooit een lege navigatie toont.
		?>
		<ul class="primary-menu primary-menu-fallback">
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
</nav>
