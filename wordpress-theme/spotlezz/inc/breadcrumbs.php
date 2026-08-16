<?php
/**
 * Breadcrumb-component.
 *
 * Elke wireframe eist een breadcrumb direct onder de vaste navigatie
 * (rij 1 in alle vijf de wireframes) — "de goedkoopste anti-pogo maatregel
 * die er is." De homepage is de enige uitzondering: daar blijft de
 * kruimelruimte leeg (wireframe-5 rij 1).
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Bouwt het kruimelpad als array van ['name' => ..., 'url' => ...],
 * los van de HTML-weergave, zodat inc/schema.php dezelfde data kan
 * hergebruiken voor de BreadcrumbList-node (één bron, geen risico dat
 * zichtbare en schema-breadcrumb uit elkaar lopen).
 *
 * @return array<int,array{name:string,url:string}>
 */
function spotlezz_get_breadcrumb_trail() {
	if ( is_front_page() ) {
		return array();
	}

	$trail   = array();
	$trail[] = array(
		'name' => __( 'Home', 'spotlezz' ),
		'url'  => home_url( '/' ),
	);

	if ( is_singular( 'pillar' ) ) {
		$trail[] = array(
			'name' => __( 'Diensten', 'spotlezz' ),
			'url'  => get_post_type_archive_link( 'pillar' ),
		);
		$trail[] = array(
			'name' => get_the_title(),
			'url'  => get_permalink(),
		);
	} elseif ( is_singular( 'case' ) ) {
		$trail[] = array(
			'name' => __( 'Klantcases', 'spotlezz' ),
			'url'  => get_post_type_archive_link( 'case' ),
		);
		$trail[] = array(
			'name' => get_the_title(),
			'url'  => get_permalink(),
		);
	} elseif ( is_singular( 'locatie' ) ) {
		$trail[] = array(
			'name' => __( 'Locaties', 'spotlezz' ),
			'url'  => get_post_type_archive_link( 'locatie' ),
		);
		$parent_id = wp_get_post_parent_id( get_the_ID() );
		if ( $parent_id ) {
			$trail[] = array(
				'name' => get_the_title( $parent_id ),
				'url'  => get_permalink( $parent_id ),
			);
		}
		$trail[] = array(
			'name' => get_the_title(),
			'url'  => get_permalink(),
		);
	} elseif ( is_singular( 'vraag' ) ) {
		$trail[] = array(
			'name' => __( 'Veelgestelde vragen', 'spotlezz' ),
			'url'  => get_post_type_archive_link( 'vraag' ),
		);
		$themas = get_the_terms( get_the_ID(), 'thema' );
		if ( $themas && ! is_wp_error( $themas ) ) {
			$thema   = reset( $themas );
			$trail[] = array(
				'name' => $thema->name,
				'url'  => get_term_link( $thema ),
			);
		}
		$trail[] = array(
			'name' => get_the_title(),
			'url'  => get_permalink(),
		);
	} elseif ( is_post_type_archive() ) {
		$trail[] = array(
			'name' => post_type_archive_title( '', false ),
			'url'  => get_post_type_archive_link( get_query_var( 'post_type' ) ),
		);
	} elseif ( is_page() ) {
		$trail[] = array(
			'name' => get_the_title(),
			'url'  => get_permalink(),
		);
	} elseif ( is_404() ) {
		$trail[] = array(
			'name' => __( 'Pagina niet gevonden', 'spotlezz' ),
			'url'  => '',
		);
	}

	return apply_filters( 'spotlezz_breadcrumb_trail', $trail );
}

/**
 * Print de zichtbare breadcrumb-nav. Geeft niets uit op de homepage.
 * Escaping: esc_html voor labels, esc_url voor hrefs — geen ongefilterde
 * output, conform de escaping-conventie in inc/README (zie functions.php-
 * commentaar).
 */
function spotlezz_breadcrumb() {
	$trail = spotlezz_get_breadcrumb_trail();
	if ( empty( $trail ) ) {
		return;
	}

	$last_index = count( $trail ) - 1;
	?>
	<nav class="breadcrumb" aria-label="<?php esc_attr_e( 'Kruimelpad', 'spotlezz' ); ?>">
		<ol>
			<?php foreach ( $trail as $index => $crumb ) : ?>
				<li>
					<?php if ( $index === $last_index || empty( $crumb['url'] ) ) : ?>
						<span aria-current="page"><?php echo esc_html( $crumb['name'] ); ?></span>
					<?php else : ?>
						<a href="<?php echo esc_url( $crumb['url'] ); ?>"><?php echo esc_html( $crumb['name'] ); ?></a>
						<span class="breadcrumb-sep" aria-hidden="true">&rsaquo;</span>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ol>
	</nav>
	<?php
}
