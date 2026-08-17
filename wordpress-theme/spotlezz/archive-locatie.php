<?php
/**
 * Locaties-hub (/locaties/) — 1-op-1 van spotlezz.vercel.app/locaties/:
 * .hub-hero (al goed), daarna een tekstkaarten-grid van de hoofdlocaties
 * (`.loc-grid`/`.loc-card`, geen foto's — de referentie gebruikt hier
 * bewust tekstkaarten, niet de foto-tegels van .services-grid), een
 * pillenrij naar de stadsdelen van elke hoofdlocatie die er één heeft, en
 * de "Waarom wij niet overal werken"-alinea (1-op-1 overgenomen tekst).
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
spotlezz_breadcrumb();
?>
<section class="hub-hero">
	<h1><?php esc_html_e( 'Ons werkgebied', 'spotlezz' ); ?></h1>
	<p class="pillar-lead"><?php esc_html_e( 'Wij werken met vaste teams vanuit Almere. Op elke locatiepagina staat wat wij daar precies doen, welke bedrijventerreinen wij bedienen en hoe snel wij er kunnen zijn.', 'spotlezz' ); ?></p>
	<div class="hero-actions">
		<a href="<?php echo esc_url( home_url( '/offerte-aanvragen/' ) ); ?>" class="btn btn-orange"><?php esc_html_e( 'Offerte aanvragen', 'spotlezz' ); ?></a>
		<?php $phone_raw = spotlezz_get_option( 'phone_raw' ); ?>
		<?php if ( '' !== $phone_raw ) : ?>
			<a href="tel:<?php echo esc_attr( $phone_raw ); ?>" class="btn btn-outline-dark"><?php echo esc_html( sprintf( /* translators: %s: telefoonnummer */ __( 'Bel %s', 'spotlezz' ), spotlezz_get_option( 'phone' ) ) ); ?></a>
		<?php endif; ?>
	</div>
</section>
<?php
$steden = get_posts(
	array(
		'post_type'      => 'locatie',
		'post_status'    => 'publish',
		'post_parent'    => 0,
		'posts_per_page' => -1,
		'orderby'        => 'title',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	)
);
?>
<?php if ( ! empty( $steden ) ) : ?>
	<section class="work-block">
		<h2><?php esc_html_e( 'Steden', 'spotlezz' ); ?></h2>
		<div class="loc-grid">
			<?php foreach ( $steden as $stad ) : ?>
				<?php $werkgebied_tekst = wp_strip_all_tags( spotlezz_field( 'werkgebied_tekst', $stad->ID, '' ) ); ?>
				<a class="loc-card" href="<?php echo esc_url( get_permalink( $stad ) ); ?>">
					<h3><?php echo esc_html( get_the_title( $stad ) ); ?></h3>
					<?php if ( $werkgebied_tekst ) : ?>
						<p><?php echo esc_html( wp_trim_words( $werkgebied_tekst, 18 ) ); ?></p>
					<?php endif; ?>
					<span class="tile-link" aria-hidden="true">
						<?php
						printf(
							/* translators: %s: plaatsnaam */
							esc_html__( 'Bekijk %s', 'spotlezz' ),
							esc_html( get_the_title( $stad ) )
						);
						?>
					</span>
				</a>
			<?php endforeach; ?>
		</div>
	</section>

	<?php
	/*
	 * Stadsdelen — dynamisch: elke hoofdlocatie die zelf kind-locaties heeft
	 * (in de praktijk alleen Almere) krijgt hier een eigen pillenrij, i.p.v.
	 * "Almere" hard te coderen zoals de referentie doet.
	 */
	foreach ( $steden as $stad ) :
		$wijken = get_posts(
			array(
				'post_type'      => 'locatie',
				'post_status'    => 'publish',
				'post_parent'    => $stad->ID,
				'posts_per_page' => -1,
				'orderby'        => 'title',
				'order'          => 'ASC',
				'no_found_rows'  => true,
			)
		);
		if ( empty( $wijken ) ) {
			continue;
		}
		?>
		<section class="work-block">
			<h2>
				<?php
				printf(
					/* translators: %s: plaatsnaam */
					esc_html__( 'Stadsdelen in %s', 'spotlezz' ),
					esc_html( get_the_title( $stad ) )
				);
				?>
			</h2>
			<p>
				<?php
				printf(
					/* translators: %s: plaatsnaam */
					esc_html__( '%s is te groot om vanuit één punt te bedienen. Wij rijden vaste routes, één per stadsdeel.', 'spotlezz' ),
					esc_html( get_the_title( $stad ) )
				);
				?>
			</p>
			<div class="pill-row">
				<?php foreach ( $wijken as $wijk ) : ?>
					<a href="<?php echo esc_url( get_permalink( $wijk ) ); ?>" class="pill"><?php echo esc_html( get_the_title( $wijk ) ); ?></a>
				<?php endforeach; ?>
			</div>
		</section>
	<?php endforeach; ?>
<?php elseif ( current_user_can( 'edit_theme_options' ) ) : ?>
	<p class="placeholder-note content-placeholder"><?php esc_html_e( 'Nog geen locaties gepubliceerd.', 'spotlezz' ); ?></p>
<?php endif; ?>

<section class="prose-block">
	<h2><?php esc_html_e( 'Waarom wij niet overal werken', 'spotlezz' ); ?></h2>
	<p><?php esc_html_e( 'Een schoonmaakbedrijf dat zegt landelijk te werken, rijdt in de praktijk met wisselend personeel en lange reistijden. Wij houden ons werkgebied bewust beperkt tot de plaatsen waar wij een vast team kunnen neerzetten en waar wij bij een calamiteit binnen enkele uren kunnen zijn.', 'spotlezz' ); ?></p>
	<p><?php esc_html_e( 'Dat betekent Almere en de vier stadsdelen als kern, en Lelystad, Amsterdam en Amersfoort op vaste routedagen. Op die routedagen bundelen wij alle afspraken in dezelfde plaats, zodat de reistijd niet in uw tarief terechtkomt en een spoedmelding dezelfde dag nog opgepakt kan worden.', 'spotlezz' ); ?></p>
	<p><?php esc_html_e( 'Krijgen wij een aanvraag van buiten dit gebied, dan zeggen wij dat eerlijk. Liever dat dan een contract waarbij de schoonmaker een uur onderweg is en de eerste de beste ochtendspits al roet in het eten gooit.', 'spotlezz' ); ?></p>
</section>

<?php
spotlezz_next_hop(
	array(
		array(
			'label' => __( 'Omhoog', 'spotlezz' ),
			'title' => __( 'Bekijk onze diensten', 'spotlezz' ),
			'url'   => get_post_type_archive_link( 'pillar' ) ?: home_url( '/diensten/' ),
		),
		array(
			'label' => __( 'Zijwaarts', 'spotlezz' ),
			'title' => __( 'Bekijk onze klantcases', 'spotlezz' ),
			'url'   => get_post_type_archive_link( 'case' ) ?: home_url( '/klantcases/' ),
		),
		array(
			'label' => __( 'Conversie', 'spotlezz' ),
			'title' => __( 'Offerte aanvragen', 'spotlezz' ),
			'url'   => home_url( '/offerte-aanvragen/' ),
		),
	)
);

get_footer();
