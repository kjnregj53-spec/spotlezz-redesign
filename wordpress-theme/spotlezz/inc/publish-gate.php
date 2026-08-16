<?php
/**
 * Publicatie-gate voor locatiepagina's.
 *
 * Harde regel 12 / WORDPRESS-BUILD-PLAN.md §5.4 (APPROVED): een
 * locatiepagina zonder voldoende lokaal bewijs (minimaal 3 van de 4:
 * klantlogo's, lokale case, lokale review, lokaal team) mag niet
 * indexeerbaar zijn — geen uitzondering, ook niet voor de hoofdvestiging.
 * Dit is hier een technische afdwinging, geen redactionele afspraak.
 *
 * De velden zelf horen bij de locatie-ACF-veldgroep uit fase 4C
 * (WORDPRESS-BUILD-PLAN §3.4 / PHASE-4C-PLAN.md §2.3). Zolang die nog niet
 * bestaat, geldt: geen aantoonbaar bewijs = niet indexeerbaar. Dat is een
 * bewust veilige default, geen bug.
 *
 * VELDNAMEN (fase 4C, ACF Free — geen repeater/gallery):
 *  - logo_1 .. logo_6 (los per veld, minimaal 3 gevuld telt als bewijsvorm 1)
 *  - lokale_case (relationship naar `case`, max 1)
 *  - lokale_review_quote (tekst — aanwezigheid van een quote telt als bewijs;
 *    hoort bij het setje lokale_review_quote/_naam/_rol/_foto)
 *  - lokaal_team_naam (tekst, hoort bij het setje lokaal_team_naam/_rol/
 *    _quote/_foto/_linkedin)
 *
 * Dit bestand telde tot fase 4C een repeater-veld `lokale_klantlogos` en een
 * enkelvoudig `lokale_review`-veld — geen van beide bestaat nog, want
 * repeaters zijn Pro-only en zijn overal in dit project vervangen door losse
 * genummerde velden (zelfde patroon als de homepage-statistieken/foto's).
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Telt hoeveel van de vier bewijsvormen voor een locatie-post gevuld zijn.
 *
 * @param int $post_id
 * @return int 0-4
 */
function spotlezz_locatie_proof_count( $post_id ) {
	if ( ! spotlezz_acf_active() ) {
		return 0; // Geen ACF = geen manier om bewijs te verifiëren = veilige default.
	}

	$count = 0;

	$logo_count = 0;
	for ( $i = 1; $i <= 6; $i++ ) {
		$logo = get_field( "logo_{$i}", $post_id );
		if ( is_array( $logo ) && ! empty( $logo['url'] ) ) {
			$logo_count++;
		}
	}
	if ( $logo_count >= 3 ) {
		$count++;
	}

	if ( get_field( 'lokale_case', $post_id ) ) {
		$count++;
	}

	$review_quote = get_field( 'lokale_review_quote', $post_id );
	if ( ! empty( $review_quote ) ) {
		$count++;
	}

	$team_name = get_field( 'lokaal_team_naam', $post_id );
	if ( ! empty( $team_name ) ) {
		$count++;
	}

	return $count;
}

/**
 * Heeft deze locatie-post minimaal 3 van de 4 bewijsvormen?
 *
 * @param int $post_id
 * @return bool
 */
function spotlezz_locatie_has_local_proof( $post_id ) {
	return spotlezz_locatie_proof_count( $post_id ) >= 3;
}

/**
 * Forceert noindex op locatie-posts zonder voldoende bewijs. Werkt met of
 * zonder Yoast: met Yoast via het wpseo_robots-filter (zodat Yoast's eigen
 * robots-output leidend blijft en er geen dubbele/conflicterende meta-tag
 * ontstaat), zonder Yoast via een eigen <meta name="robots">.
 */
function spotlezz_maybe_noindex_locatie() {
	if ( ! is_singular( 'locatie' ) ) {
		return;
	}

	$post_id = get_the_ID();
	if ( spotlezz_locatie_has_local_proof( $post_id ) ) {
		return;
	}

	if ( spotlezz_yoast_active() ) {
		add_filter(
			'wpseo_robots',
			function ( $robots ) {
				return 'noindex, follow';
			}
		);
		return;
	}

	add_action(
		'wp_head',
		function () {
			echo '<meta name="robots" content="noindex, follow">' . "\n";
		},
		1
	);
}
add_action( 'template_redirect', 'spotlezz_maybe_noindex_locatie' );

/**
 * Zichtbare admin-waarschuwing op het bewerkscherm van een locatie-post
 * zonder voldoende bewijs, zodat een redacteur niet hoeft te raden waarom
 * de pagina niet in Google verschijnt.
 */
function spotlezz_locatie_proof_admin_notice() {
	$screen = get_current_screen();
	if ( ! $screen || 'locatie' !== $screen->post_type || 'post' !== $screen->base ) {
		return;
	}

	global $post;
	if ( ! $post || spotlezz_locatie_has_local_proof( $post->ID ) ) {
		return;
	}

	$proof_count = spotlezz_locatie_proof_count( $post->ID );
	?>
	<div class="notice notice-warning">
		<p>
			<?php
			printf(
				/* translators: %d: aantal ingevulde bewijsvormen van de 4 */
				esc_html__(
					'Deze locatiepagina heeft %1$d van de 4 vereiste vormen van lokaal bewijs (minimaal 3 nodig: klantlogo\'s, lokale case, lokale review, lokaal team). De pagina staat automatisch op noindex tot dit is aangevuld — zie WORDPRESS-BUILD-PLAN.md §5.4.',
					'spotlezz'
				),
				(int) $proof_count
			);
			?>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'spotlezz_locatie_proof_admin_notice' );
