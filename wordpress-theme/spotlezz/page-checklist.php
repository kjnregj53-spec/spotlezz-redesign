<?php
/**
 * De Spotlezz-check — lead magnet, bestond nog niet als pagina terwijl de
 * homepage-CTA ("Doe de Spotlezz-check") en de header/mobiele nav er al wel
 * naar linken (/checklist/). Tekst 1-op-1 overgenomen uit
 * docs/content/spotlezz_content_inventory.md, sectie "De Spotlezz-check".
 *
 * Zelfde regel als spotlezz_conversion_variant_a() (PHASE-4C-PLAN.md
 * beslissing 5): visueel formulier, geen `action`/`method`, verstuurt niets.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	/* Intro-alinea 1-op-1 van de referentie's checklist-hero, verplaatst
	   van een losse sectie ná de hero naar de hero zelf. */
	spotlezz_page_hero(
		__( 'Is jouw bedrijf Spotlezz? Doe de check!', 'spotlezz' ),
		spotlezz_get_option( 'page_hero_diensten_cases' ),
		'',
		__( 'Ontdek welke details vaak over het hoofd worden gezien, en waarom wij altijd een stapje extra zetten voor het ultieme eindresultaat.', 'spotlezz' )
	);
	?>
	<article <?php post_class( 'checklist-single' ); ?> id="post-<?php the_ID(); ?>">

		<?php
		/*
		 * 1-op-1 van de referentie's checklist-pagina: twee tekst+foto-rijen
		 * (uitleg + oranje offset-kader, dan voorbeeldfoto + echt formulier)
		 * i.p.v. de eerdere platte tekst + los mini-formuliertje. Beide
		 * foto's (#118 checklist-achtergrond, #117 checklist-preview) zijn
		 * dezelfde, al bevestigde echte foto's als in de referentie.
		 */
		$img_uitleg  = wp_get_attachment_image_url( 118, 'large' );
		$img_preview = wp_get_attachment_image_url( 117, 'large' );
		$content_id  = get_the_ID();
		?>
		<section class="ks-text-image">
			<div class="ks-ti-content">
				<h2><?php echo esc_html( spotlezz_field( 'checklist_uitleg_heading', $content_id, __( 'Wat is de Spotlezz-checklist?', 'spotlezz' ) ) ); ?></h2>
				<p><?php echo esc_html( spotlezz_field( 'checklist_uitleg_p1', $content_id, __( 'De Spotlezz-checklist is de dagelijkse kwaliteitscontrole die onze schoonmakers uitvoeren bij onze klanten. Door de check te doen zie je in één oogopslag het verschil tussen schoon en Spotlezz.', 'spotlezz' ) ) ); ?></p>
				<p><?php echo esc_html( spotlezz_field( 'checklist_uitleg_p2', $content_id, __( 'Het zijn de details die een groot verschil maken, en die ontdek je pas als je er met een scherp oog naar kijkt. Denk aan prullenbakken, stoelpoten, toetsenborden of lichtschakelaars.', 'spotlezz' ) ) ); ?></p>
				<p><strong><?php echo esc_html( spotlezz_field( 'checklist_uitleg_bold', $content_id, __( 'Want schoon kan altijd schoner.', 'spotlezz' ) ) ); ?></strong></p>
			</div>
			<?php if ( $img_uitleg ) : ?>
				<div class="ks-ti-image ks-ti-image-offset">
					<img src="<?php echo esc_url( $img_uitleg ); ?>" alt="<?php esc_attr_e( 'Spotlezz Checklist', 'spotlezz' ); ?>" loading="lazy" decoding="async">
				</div>
			<?php endif; ?>
		</section>

		<section class="ks-text-image ks-reverse">
			<div class="ks-ti-content">
				<h2><?php echo esc_html( spotlezz_field( 'checklist_form_heading', $content_id, __( 'Doe nu de Spotlezz-check', 'spotlezz' ) ) ); ?></h2>
				<p><?php echo esc_html( spotlezz_field( 'checklist_form_intro', $content_id, __( 'Kijk met onze frisse blik naar jouw bedrijfsschoonmaak. Vul je e-mailadres in en ontvang de checklist binnen 1 minuut in je inbox.', 'spotlezz' ) ) ); ?></p>
				<ul class="ks-checklist checklist-steps">
					<li>
						<strong><?php echo esc_html( spotlezz_field( 'checklist_step1_title', $content_id, __( 'Kijk door de ogen van onze schoonmakers', 'spotlezz' ) ) ); ?></strong>
						<span><?php echo esc_html( spotlezz_field( 'checklist_step1_text', $content_id, __( 'Kijk met onze frisse blik naar jouw bedrijfsschoonmaak', 'spotlezz' ) ) ); ?></span>
					</li>
					<li>
						<strong><?php echo esc_html( spotlezz_field( 'checklist_step2_title', $content_id, __( 'Ontdek of jouw bedrijf Spotlezz is', 'spotlezz' ) ) ); ?></strong>
						<span><?php echo esc_html( spotlezz_field( 'checklist_step2_text', $content_id, __( 'Bekijk je score en ontdek of je bedrijf voldoet aan onze standaard.', 'spotlezz' ) ) ); ?></span>
					</li>
				</ul>
				<div class="checklist-form-box">
					<form class="sp-form" onsubmit="return false;">
						<div class="form-group">
							<label for="checklist-email"><?php esc_html_e( 'E-mailadres', 'spotlezz' ); ?></label>
							<input type="email" id="checklist-email" name="email" autocomplete="email" placeholder="<?php esc_attr_e( 'naam@bedrijf.nl', 'spotlezz' ); ?>" required>
						</div>
						<div class="form-consent">
							<input type="checkbox" id="checklist-akkoord" name="akkoord" required>
							<label for="checklist-akkoord"><?php echo wp_kses_post( sprintf( /* translators: %s: link naar privacybeleid */ __( 'Akkoord met het %s.', 'spotlezz' ), '<a href="' . esc_url( home_url( '/privacybeleid/' ) ) . '">' . esc_html__( 'privacybeleid', 'spotlezz' ) . '</a>' ) ); ?></label>
						</div>
						<button type="submit" class="btn btn-orange"><?php esc_html_e( 'Vraag de checklist aan', 'spotlezz' ); ?></button>
					</form>
				</div>
			</div>
			<?php if ( $img_preview ) : ?>
				<div class="ks-ti-image">
					<img src="<?php echo esc_url( $img_preview ); ?>" alt="<?php esc_attr_e( 'Doe de check', 'spotlezz' ); ?>" loading="lazy" decoding="async">
				</div>
			<?php endif; ?>
		</section>

		<section class="prose-block">
			<h2><?php echo esc_html( spotlezz_field( 'checklist_approach_heading', $content_id, __( 'Schoon kan altijd schoner', 'spotlezz' ) ) ); ?></h2>
			<p><?php echo esc_html( spotlezz_field( 'checklist_approach_p1', $content_id, __( 'De belangrijkste reden voor het succes van Spotlezz is onze unieke aanpak. Want bedrijfsschoonmaak mag nooit routine worden. Jouw bedrijfspand verdient elke dag opnieuw dezelfde liefde en aandacht. Door onze checklist te delen helpen wij ondernemers, facilitair managers en vastgoedbeheerders om met onze frisse blik naar bedrijfsschoonmaak te kijken. Want schoon kan altijd schoner.', 'spotlezz' ) ) ); ?></p>
			<p><?php echo esc_html( spotlezz_field( 'checklist_approach_p2', $content_id, __( 'Ben je klaar voor de overtreffende trap van schoon? Vraag vandaag nog een offerte aan en wij nemen zo snel mogelijk contact met je op.', 'spotlezz' ) ) ); ?></p>
			<a href="<?php echo esc_url( home_url( '/offerte-aanvragen/' ) ); ?>" class="btn btn-orange"><?php esc_html_e( 'Offerte aanvragen', 'spotlezz' ); ?></a>
			<blockquote class="quote-large">
				<p>&ldquo;<?php echo esc_html( spotlezz_field( 'checklist_quote', $content_id, __( 'Als je denkt dat gewoon schoon ook schoon is, dan heb je het mis.', 'spotlezz' ) ) ); ?>&rdquo;</p>
			</blockquote>
		</section>

		<section class="checklist-cta-banner">
			<h2><?php echo esc_html( spotlezz_field( 'checklist_cta_heading', $content_id, __( 'De Spotlezz-check', 'spotlezz' ) ) ); ?></h2>
			<p><?php echo esc_html( spotlezz_field( 'checklist_cta_text', $content_id, __( 'Spotlezz zijn is één ding, maar Spotlezz blijven is misschien nog wel belangrijker. Daarom voeren we regelmatig verschillende controles uit en hebben we onze Spotlezz-checklist ontwikkeld. Benieuwd of jouw bedrijf Spotlezz is? Doe de check!', 'spotlezz' ) ) ); ?></p>
			<a href="#checklist-email" class="btn btn-orange"><?php esc_html_e( 'Ontvang de Spotlezz-checklist', 'spotlezz' ); ?></a>
			<p class="mini"><?php esc_html_e( '*Binnen 1 minuut in je inbox', 'spotlezz' ); ?></p>
		</section>

		<section class="faq-block checklist-faq">
			<div class="faq-container">
				<div class="faq-left">
					<h2><?php echo esc_html( spotlezz_field( 'checklist_faq_heading', $content_id, __( 'Veelgestelde vragen', 'spotlezz' ) ) ); ?></h2>
					<p><?php echo esc_html( spotlezz_field( 'checklist_faq_intro', $content_id, __( 'Heeft je nog vragen? Lees dan onze veelgestelde vragen hieronder. Staat jouw vraag er niet bij? Neem dan gerust contact met ons op!', 'spotlezz' ) ) ); ?></p>
					<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-orange"><?php esc_html_e( 'Neem contact met ons op', 'spotlezz' ); ?></a>
				</div>
				<div class="faq-right">
					<?php
					$faq_defaults = array(
						1 => array(
							'q' => __( 'Mijn bedrijf valt in geen van uw categorieën. Wat nu?', 'spotlezz' ),
							'a' => __( 'Geen probleem! We streven ernaar om zoveel mogelijk bedrijven SPOTLEZZ-vriendelijk te maken en helpen u graag verder. Neem contact met ons op via de contactpagina!', 'spotlezz' ),
						),
						2 => array(
							'q' => __( 'Verricht u ook schoonmaakwerkzaamheden voor particulieren?', 'spotlezz' ),
							'a' => __( 'SPOTLEZZ richt zich volledig op zakelijke klanten. Hierdoor kunnen wij onze kwaliteit, planning en service optimaal afstemmen op bedrijven en organisaties.', 'spotlezz' ),
						),
						3 => array(
							'q' => __( 'Zou u ook af en toe willen schoonmaken?', 'spotlezz' ),
							'a' => __( 'Geen probleem! Wij bieden ook eenmalige of incidentele schoonmaak aan, bijvoorbeeld bij evenementen, verhuizingen of extra onderhoudsmomenten.', 'spotlezz' ),
						),
						4 => array(
							'q' => __( 'Ruiken uw ecologische schoonmaakproducten net zo lekker?', 'spotlezz' ),
							'a' => __( 'Zeker! Onze ecologische schoonmaakmiddelen hebben een frisse, natuurlijke geur en bevatten geen schadelijke stoffen, wat zorgt voor een prettige en gezonde werkomgeving.', 'spotlezz' ),
						),
						5 => array(
							'q' => __( 'Maakt u ook buiten kantooruren schoon?', 'spotlezz' ),
							'a' => __( 'Geen probleem! Wij maken ook buiten kantooruren schoon, zodat uw dagelijkse werkzaamheden ongestoord kunnen doorgaan en uw bedrijf altijd schoon blijft.', 'spotlezz' ),
						),
					);
					for ( $i = 1; $i <= 5; $i++ ) :
						$vraag_tekst    = spotlezz_field( "checklist_faq_q{$i}", $content_id, $faq_defaults[ $i ]['q'] );
						$antwoord_tekst = spotlezz_field( "checklist_faq_a{$i}", $content_id, $faq_defaults[ $i ]['a'] );
						if ( '' === $vraag_tekst ) {
							continue;
						}
						?>
						<details class="faq-item">
							<summary>
								<span><?php echo esc_html( $vraag_tekst ); ?></span>
								<span class="faq-icon" aria-hidden="true"></span>
							</summary>
							<?php if ( '' !== $antwoord_tekst ) : ?>
								<p><?php echo esc_html( $antwoord_tekst ); ?></p>
							<?php endif; ?>
						</details>
					<?php endfor; ?>
				</div>
			</div>
		</section>

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
			'title' => __( 'Bekijk onze diensten', 'spotlezz' ),
			'url'   => get_post_type_archive_link( 'pillar' ) ?: home_url( '/diensten/' ),
		),
		array(
			'label' => __( 'Conversie', 'spotlezz' ),
			'title' => __( 'Vraag een offerte aan', 'spotlezz' ),
			'url'   => home_url( '/offerte-aanvragen/' ),
		),
	)
);

get_footer();
