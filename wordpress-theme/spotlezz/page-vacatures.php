<?php
/**
 * Vacatures — bestond nog niet als WordPress-pagina, terwijl Contact en de
 * footer er al wel naar linken. Tekst 1-op-1 overgenomen uit
 * docs/content/spotlezz_content_inventory.md, sectie "Vacancies". Geen
 * concrete openstaande vacatures bekend/bevestigd, dus geen vacaturelijst
 * verzonnen — alleen de bevestigde wervingstekst en een sollicitatie-CTA.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	spotlezz_page_hero(
		__( 'Bouw je carrière op met Spotlezz', 'spotlezz' ),
		spotlezz_get_option( 'page_hero_diensten_cases' ),
		__( 'Vacatures', 'spotlezz' ),
		__( 'Bij Spotlezz geloven we dat geweldige schoonmaak begint met geweldige mensen. We zijn een groeiend, professioneel schoonmaakbedrijf waar kwaliteit, teamwork en passie voorop staan.', 'spotlezz' )
	);
	?>
	<?php $content_id = get_the_ID(); ?>
	<article <?php post_class( 'vacatures-single' ); ?> id="post-<?php the_ID(); ?>">

		<section class="over-ons-intro" style="text-align:center;">
			<a href="<?php echo esc_url( home_url( '/over-ons/' ) ); ?>" class="btn btn-outline-dark"><?php esc_html_e( 'Leer meer over ons', 'spotlezz' ); ?></a>
		</section>

		<section class="tasks-block">
			<h2><?php echo esc_html( spotlezz_field( 'vacatures_why_heading', $content_id, __( 'Waarom werken bij Spotlezz', 'spotlezz' ) ) ); ?></h2>
			<div class="tasks-grid">
				<div class="task-tile task-tile-static"><?php echo esc_html( spotlezz_field( 'vacatures_why_1', $content_id, __( 'Meetbare kwaliteit', 'spotlezz' ) ) ); ?></div>
				<div class="task-tile task-tile-static"><?php echo esc_html( spotlezz_field( 'vacatures_why_2', $content_id, __( 'Getraind personeel', 'spotlezz' ) ) ); ?></div>
				<div class="task-tile task-tile-static"><?php echo esc_html( spotlezz_field( 'vacatures_why_3', $content_id, __( 'Duurzame schoonmaakproducten', 'spotlezz' ) ) ); ?></div>
				<div class="task-tile task-tile-static"><?php echo esc_html( spotlezz_field( 'vacatures_why_4', $content_id, __( 'Flexibele service', 'spotlezz' ) ) ); ?></div>
			</div>
		</section>

		<section class="over-ons-verhaal" style="text-align:center;">
			<h2><?php echo esc_html( spotlezz_field( 'vacatures_job_heading', $content_id, __( 'Vind vandaag nog je nieuwe baan', 'spotlezz' ) ) ); ?></h2>
			<p><?php echo esc_html( spotlezz_field( 'vacatures_job_intro', $content_id, __( 'Er wachten je talloze nieuwe kansen en mogelijkheden.', 'spotlezz' ) ) ); ?></p>
		</section>

		<?php
		/*
		 * Geen concrete, bevestigde openstaande vacatures (zie bestandskop)
		 * — dus geen vacaturelijst tonen. Eerder stond hier per ongeluk een
		 * lijst met twee volledig verzonnen functies (locatie, uren,
		 * "auto van de zaak", enz.) die precies het tegenovergestelde deed
		 * van wat deze kop beloofde — iemand had erop kunnen solliciteren
		 * voor een baan die niet bestaat. Open sollicitatie i.p.v. een
		 * gefingeerde lijst.
		 */
		?>
		<section class="cases-block" style="max-width:var(--spotlezz-max-width);margin:0 auto;padding:0 5% 36px;">
			<h2><?php echo esc_html( spotlezz_field( 'vacatures_novacancy_heading', $content_id, __( 'Op dit moment geen specifieke vacatures online', 'spotlezz' ) ) ); ?></h2>
			<p style="color:#4b5563;max-width:65ch;"><?php echo esc_html( spotlezz_field( 'vacatures_novacancy_text', $content_id, __( 'We hebben nu geen vacatures met een vaste functie-inhoud online staan, maar we zijn altijd geïnteresseerd om kennis te maken met gemotiveerde mensen. Stuur ons een open sollicitatie en we nemen contact met je op zodra er een passende plek is.', 'spotlezz' ) ) ); ?></p>
		</section>

		<div class="offerte-split">
			<div class="offerte-form">
				<h2><?php echo esc_html( spotlezz_field( 'vacatures_apply_heading', $content_id, __( 'Geïnteresseerd om met ons samen te werken?', 'spotlezz' ) ) ); ?></h2>
				<p style="color:#6b7280;font-size:13.5px;margin-bottom:12px;"><?php echo esc_html( spotlezz_field( 'vacatures_apply_note', $content_id, __( 'Upload je cv, sollicitatiebrief of portfolio.', 'spotlezz' ) ) ); ?></p>
				<?php $email = spotlezz_get_option( 'email' ); ?>
				<?php if ( '' !== $email ) : ?>
					<a href="mailto:<?php echo esc_attr( $email ); ?>" class="btn btn-orange"><?php esc_html_e( 'Stuur je sollicitatie', 'spotlezz' ); ?></a>
					<p class="mini offerte-form-note"><?php echo esc_html( sprintf( /* translators: %s: e-mailadres */ __( 'Mail je cv naar %s — we reageren binnen 12 uur.', 'spotlezz' ), $email ) ); ?></p>
				<?php endif; ?>
			</div>
			<div class="offerte-side">
				<div class="offerte-side-card">
					<h2><?php echo esc_html( spotlezz_field( 'vacatures_questions_heading', $content_id, __( 'Liever eerst wat vragen?', 'spotlezz' ) ) ); ?></h2>
					<?php $phone_raw = spotlezz_get_option( 'phone_raw' ); ?>
					<?php if ( '' !== $phone_raw ) : ?>
						<a class="btn btn-outline-dark" href="tel:<?php echo esc_attr( $phone_raw ); ?>"><?php echo esc_html( __( 'Bel', 'spotlezz' ) . ' ' . spotlezz_get_option( 'phone' ) ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<?php spotlezz_reviews_block(); ?>

	</article>
	<?php
endwhile;

spotlezz_next_hop(
	array(
		array(
			'label' => __( 'Omhoog', 'spotlezz' ),
			'title' => __( 'Terug naar de homepage', 'spotlezz' ),
			'url'   => home_url( '/' ),
		),
		array(
			'label' => __( 'Zijwaarts', 'spotlezz' ),
			'title' => __( 'Meer over Spotlezz', 'spotlezz' ),
			'url'   => home_url( '/over-ons/' ),
		),
		array(
			'label' => __( 'Conversie', 'spotlezz' ),
			'title' => __( 'Neem contact op', 'spotlezz' ),
			'url'   => home_url( '/contact/' ),
		),
	)
);

get_footer();
