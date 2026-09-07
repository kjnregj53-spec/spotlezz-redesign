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
<?php $diensten_nav_groups = spotlezz_diensten_nav_groups(); ?>
<nav class="main-navigation" aria-label="<?php esc_attr_e( 'Hoofdnavigatie', 'spotlezz' ); ?>">
	<ul class="primary-menu">
		<li class="dropdown">
			<a href="<?php echo esc_url( get_post_type_archive_link( 'pillar' ) ?: home_url( '/diensten/' ) ); ?>" class="dropbtn<?php echo esc_attr( spotlezz_nav_is_current( 'diensten' ) ); ?>">
				<?php esc_html_e( 'Diensten', 'spotlezz' ); ?>
				<svg class="icon-caret" viewBox="0 0 12 8" width="10" height="7" aria-hidden="true" focusable="false"><path d="M1 1l5 5 5-5" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linecap="round" stroke-linejoin="round"></path></svg>
			</a>
			<?php if ( $diensten_nav_groups['voor_wie'] || $diensten_nav_groups['wat_we_doen'] ) : ?>
				<div class="dropdown-content">
					<?php if ( $diensten_nav_groups['voor_wie'] ) : ?>
						<span class="dropdown-heading"><?php esc_html_e( 'Voor wie', 'spotlezz' ); ?></span>
						<?php foreach ( $diensten_nav_groups['voor_wie'] as $pillar ) : ?>
							<a href="<?php echo esc_url( get_permalink( $pillar ) ); ?>"<?php echo is_singular( 'pillar' ) && get_queried_object_id() === $pillar->ID ? ' class="is-current"' : ''; ?>><?php echo esc_html( get_the_title( $pillar ) ); ?></a>
						<?php endforeach; ?>
					<?php endif; ?>
					<?php if ( $diensten_nav_groups['wat_we_doen'] ) : ?>
						<span class="dropdown-heading"><?php esc_html_e( 'Wat we doen', 'spotlezz' ); ?></span>
						<?php foreach ( $diensten_nav_groups['wat_we_doen'] as $pillar ) : ?>
							<a href="<?php echo esc_url( get_permalink( $pillar ) ); ?>"<?php echo is_singular( 'pillar' ) && get_queried_object_id() === $pillar->ID ? ' class="is-current"' : ''; ?>><?php echo esc_html( get_the_title( $pillar ) ); ?></a>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</li>
		<li><a href="<?php echo esc_url( get_post_type_archive_link( 'case' ) ?: home_url( '/klantcases/' ) ); ?>" class="<?php echo esc_attr( ltrim( spotlezz_nav_is_current( 'klantcases' ) ) ); ?>"><?php esc_html_e( 'Klantcases', 'spotlezz' ); ?></a></li>
		<li><a href="<?php echo esc_url( get_post_type_archive_link( 'locatie' ) ?: home_url( '/locaties/' ) ); ?>" class="<?php echo esc_attr( ltrim( spotlezz_nav_is_current( 'locaties' ) ) ); ?>"><?php esc_html_e( 'Locaties', 'spotlezz' ); ?></a></li>
		<li><a href="<?php echo esc_url( get_post_type_archive_link( 'vraag' ) ?: home_url( '/veelgestelde-vragen/' ) ); ?>" class="<?php echo esc_attr( ltrim( spotlezz_nav_is_current( 'faq' ) ) ); ?>"><?php esc_html_e( 'Veelgestelde vragen', 'spotlezz' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/over-ons/' ) ); ?>" class="<?php echo esc_attr( ltrim( spotlezz_nav_is_current( 'over-ons' ) ) ); ?>"><?php esc_html_e( 'Over ons', 'spotlezz' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="<?php echo esc_attr( ltrim( spotlezz_nav_is_current( 'contact' ) ) ); ?>"><?php esc_html_e( 'Contact', 'spotlezz' ); ?></a></li>
	</ul>
</nav>
