<?php
/**
 * 404. Geen next-hop bar hier met de standaard 3-routes-eis — een 404 is
 * per definitie geen wireframe-paginatype, dus deze pagina valt bewust
 * buiten harde regel 5. Wel duidelijke uitwegen, want dat is exact het
 * pogo-stick-principe.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="content-wrap not-found">
	<h1><?php esc_html_e( 'Pagina niet gevonden', 'spotlezz' ); ?></h1>
	<p><?php esc_html_e( 'De pagina die je zoekt bestaat niet (meer). Probeer een van onderstaande routes.', 'spotlezz' ); ?></p>
	<ul>
		<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Terug naar de homepage', 'spotlezz' ); ?></a></li>
		<li><a href="<?php echo esc_url( get_post_type_archive_link( 'pillar' ) ?: home_url( '/diensten/' ) ); ?>"><?php esc_html_e( 'Bekijk onze diensten', 'spotlezz' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Neem contact op', 'spotlezz' ); ?></a></li>
	</ul>
</div>

<?php get_footer(); ?>
