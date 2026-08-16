<?php
/**
 * Header: topbar, hoofdnavigatie, mobiele nav, skip-link, en de enige
 * opening van <main> in het hele theme (harde regel 3 en 4: exact één
 * skip-link, exact één <main>). footer.php sluit hem weer af.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Naar de inhoud', 'spotlezz' ); ?></a>

<div class="top-bar">
	<div class="usp">
		<span><?php esc_html_e( 'Innovatief en flexibel', 'spotlezz' ); ?></span>
		<span><?php esc_html_e( 'Jarenlange ervaring', 'spotlezz' ); ?></span>
		<?php
		$maps_url = spotlezz_get_option( 'google_maps_url' );
		if ( '' !== $maps_url ) :
			?>
			<a href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener noreferrer" class="top-bar-review-link">
				<?php spotlezz_review_badge(); ?>
			</a>
		<?php else : ?>
			<?php spotlezz_review_badge(); ?>
		<?php endif; ?>
	</div>
	<div class="contact-info">
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

<header class="site-header">
	<div class="logo">
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

	<?php get_template_part( 'template-parts/header/navigation' ); ?>

	<div class="header-ctas">
		<a href="<?php echo esc_url( home_url( '/offerte-aanvragen/' ) ); ?>" class="btn btn-orange">
			<?php esc_html_e( 'Offerte aanvragen', 'spotlezz' ); ?>
		</a>
	</div>

	<button type="button" class="mobile-menu-btn" aria-label="<?php esc_attr_e( 'Menu openen', 'spotlezz' ); ?>" aria-expanded="false" aria-controls="mobileNav">
		<?php // Inline SVG i.p.v. een Unicode-hamburgerteken (U+2630): dat teken
		// bleek in de preview niet betrouwbaar te renderen, afhankelijk van
		// welke fallback-font de browser koos. SVG heeft dat probleem niet. ?>
		<svg class="icon-burger" viewBox="0 0 24 24" width="26" height="26" aria-hidden="true" focusable="false">
			<rect x="3" y="6" width="18" height="2.4" rx="1.2" fill="currentColor"></rect>
			<rect x="3" y="11" width="18" height="2.4" rx="1.2" fill="currentColor"></rect>
			<rect x="3" y="16" width="18" height="2.4" rx="1.2" fill="currentColor"></rect>
		</svg>
	</button>
</header>

<?php get_template_part( 'template-parts/header/mobile-nav' ); ?>

<main id="main">
	<?php spotlezz_breadcrumb(); ?>
