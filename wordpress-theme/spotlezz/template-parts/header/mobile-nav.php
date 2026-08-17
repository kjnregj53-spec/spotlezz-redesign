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
	<?php $diensten_nav_groups = spotlezz_diensten_nav_groups(); ?>
	<div class="mobile-nav-links">
		<a href="<?php echo esc_url( get_post_type_archive_link( 'pillar' ) ?: home_url( '/diensten/' ) ); ?>" class="<?php echo esc_attr( ltrim( spotlezz_nav_is_current( 'diensten' ) ) ); ?>"><?php esc_html_e( 'Diensten', 'spotlezz' ); ?></a>
		<?php foreach ( array_merge( $diensten_nav_groups['voor_wie'], $diensten_nav_groups['wat_we_doen'] ) as $pillar ) : ?>
			<a href="<?php echo esc_url( get_permalink( $pillar ) ); ?>" class="sub-link"><?php echo esc_html( get_the_title( $pillar ) ); ?></a>
		<?php endforeach; ?>
		<a href="<?php echo esc_url( get_post_type_archive_link( 'case' ) ?: home_url( '/klantcases/' ) ); ?>" class="<?php echo esc_attr( ltrim( spotlezz_nav_is_current( 'klantcases' ) ) ); ?>"><?php esc_html_e( 'Klantcases', 'spotlezz' ); ?></a>
		<a href="<?php echo esc_url( get_post_type_archive_link( 'locatie' ) ?: home_url( '/locaties/' ) ); ?>" class="<?php echo esc_attr( ltrim( spotlezz_nav_is_current( 'locaties' ) ) ); ?>"><?php esc_html_e( 'Locaties', 'spotlezz' ); ?></a>
		<a href="<?php echo esc_url( get_post_type_archive_link( 'vraag' ) ?: home_url( '/veelgestelde-vragen/' ) ); ?>" class="<?php echo esc_attr( ltrim( spotlezz_nav_is_current( 'faq' ) ) ); ?>"><?php esc_html_e( 'Veelgestelde vragen', 'spotlezz' ); ?></a>
		<a href="<?php echo esc_url( home_url( '/over-ons/' ) ); ?>" class="<?php echo esc_attr( ltrim( spotlezz_nav_is_current( 'over-ons' ) ) ); ?>"><?php esc_html_e( 'Over ons', 'spotlezz' ); ?></a>
		<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="<?php echo esc_attr( ltrim( spotlezz_nav_is_current( 'contact' ) ) ); ?>"><?php esc_html_e( 'Contact', 'spotlezz' ); ?></a>
	</div>
	<div class="mobile-nav-ctas">
		<a href="<?php echo esc_url( home_url( '/offerte-aanvragen/' ) ); ?>" class="btn btn-orange">
			<?php esc_html_e( 'Offerte aanvragen', 'spotlezz' ); ?>
		</a>
	</div>
</div>
