<?php
/**
 * Over ons — 1-op-1 van spotlezz.vercel.app/over-ons/: Ons Verhaal (foto-
 * split met checklist), Visie/Missie (bento-kaarten), de oprichter
 * (personal-touch sectie op de homepage-founder-velden), het
 * kwaliteitsblok (hergebruikt front-page.php's .clean-kwaliteit-section
 * 1-op-1, zelfde foto-veld), reviews, een medewerker-quote met foto, en
 * twee uitgelichte klantcases. Alle foto's komen uit de al aanwezige
 * homepage-ACF-velden (photo_1/2/3, founder_photo, founder_side_photo) —
 * geen nieuwe velden nodig, geen verzonnen content.
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
		__( 'Spotlezz is de overtreffende trap van schoon', 'spotlezz' ),
		spotlezz_get_option( 'page_hero_diensten_cases' ),
		__( 'Over ons', 'spotlezz' ),
		__( 'Onze missie is simpel: schoon kan altijd schoner. Na ons bezoek voelt jouw bedrijf écht schoon!', 'spotlezz' )
	);

	$page_id    = get_option( 'page_on_front' );
	$content_id = get_the_ID();
	?>
	<article <?php post_class( 'over-ons-single' ); ?> id="post-<?php the_ID(); ?>">

		<?php
		$verhaal_photo = spotlezz_field( 'photo_2', $page_id, null );
		$verhaal_url   = is_array( $verhaal_photo ) ? ( $verhaal_photo['url'] ?? '' ) : '';
		?>
		<section class="services-section">
			<div class="service-card">
				<div class="service-content">
					<h2 class="service-title"><?php echo esc_html( spotlezz_field( 'verhaal_heading', $content_id, __( 'Ons verhaal', 'spotlezz' ) ) ); ?></h2>
					<p class="service-desc"><?php echo esc_html( spotlezz_field( 'verhaal_p1', $content_id, __( 'Spotlezz begon als de droom van één jonge ondernemer. Inmiddels zijn we uitgegroeid tot een energiek team met één doel: elke dag een beetje schoner.', 'spotlezz' ) ) ); ?></p>
					<p class="service-desc"><?php echo esc_html( spotlezz_field( 'verhaal_p2', $content_id, __( 'Met vaste gezichten, natuurlijke producten en onze eigen Spotlezz-check zorgen we dat schoon niet zomaar schoon is. Want voor ons is schoon: Schoner. Schoon. Spotlezz.', 'spotlezz' ) ) ); ?></p>
					<ul class="service-benefits">
						<li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"></path></svg> <?php echo esc_html( spotlezz_field( 'verhaal_benefit_1', $content_id, __( 'Vaste, betrouwbare gezichten', 'spotlezz' ) ) ); ?></li>
						<li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"></path></svg> <?php echo esc_html( spotlezz_field( 'verhaal_benefit_2', $content_id, __( 'Uitsluitend natuurlijke producten', 'spotlezz' ) ) ); ?></li>
						<li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"></path></svg> <?php echo esc_html( spotlezz_field( 'verhaal_benefit_3', $content_id, __( 'De eigen Spotlezz-check kwaliteitscontrole', 'spotlezz' ) ) ); ?></li>
					</ul>
				</div>
				<?php if ( $verhaal_url ) : ?>
					<div class="service-image">
						<img src="<?php echo esc_url( $verhaal_url ); ?>" alt="<?php echo esc_attr( spotlezz_image_alt( $verhaal_photo, __( 'Ons verhaal', 'spotlezz' ) ) ); ?>" loading="lazy" decoding="async">
					</div>
				<?php endif; ?>
			</div>
		</section>

		<div class="about-values">
			<div class="about-value-card">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"></path><circle cx="12" cy="12" r="3"></circle></svg>
				<h4><?php echo esc_html( spotlezz_field( 'visie_heading', $content_id, __( 'Onze visie', 'spotlezz' ) ) ); ?></h4>
				<p><?php echo esc_html( spotlezz_field( 'visie_p1', $content_id, __( 'Wij zetten de nieuwe standaard in schoonmaak. Niet de grootste, wél de meest betrokken en vernieuwende partner.', 'spotlezz' ) ) ); ?></p>
				<p><?php echo esc_html( spotlezz_field( 'visie_p2', $content_id, __( 'Echt schoonmaken begint met oog voor detail. Van stofvrije plinten tot een bureau dat nét weer recht staat. Wij zorgen dat elke ruimte klopt, als één geheel. Samen creëren we gezonde, inspirerende werkomgevingen waar mensen zich thuis voelen en bedrijven kunnen groeien.', 'spotlezz' ) ) ); ?></p>
			</div>
			<div class="about-value-card is-orange">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4.5 16.5l-1.5 5 5-1.5L19.5 8.5a2.1 2.1 0 0 0-3-3L5 17z"></path><path d="M15 5l4 4"></path></svg>
				<h4><?php echo esc_html( spotlezz_field( 'missie_heading', $content_id, __( 'Onze missie', 'spotlezz' ) ) ); ?></h4>
				<p><?php echo esc_html( spotlezz_field( 'missie_p1', $content_id, __( 'Samen met onze klanten bouwen we aan een fijne werkplek. Wij geloven dat een schone omgeving de basis is voor werkplezier, gezondheid en succes.', 'spotlezz' ) ) ); ?></p>
				<p><?php echo esc_html( spotlezz_field( 'missie_p2', $content_id, __( 'Met oog voor detail, vaste gezichten en natuurlijke producten zorgen wij dat elke ruimte klopt tot in de kleinste hoekjes. We luisteren naar de wensen van onze klanten en denken proactief mee, zodat we altijd nét dat stapje extra zetten.', 'spotlezz' ) ) ); ?></p>
			</div>
		</div>

		<?php
		$founder_name       = spotlezz_field( 'founder_name', $page_id, '' );
		$founder_photo      = spotlezz_field( 'founder_photo', $page_id, null );
		$founder_photo_url  = is_array( $founder_photo ) ? ( $founder_photo['url'] ?? '' ) : '';
		$founder_side_photo = spotlezz_field( 'founder_side_photo', $page_id, null );
		$founder_bg_url     = is_array( $founder_side_photo ) && ! empty( $founder_side_photo['url'] ) ? $founder_side_photo['url'] : ( is_array( $verhaal_photo ) ? ( $verhaal_photo['url'] ?? '' ) : '' );
		if ( $founder_name && $founder_photo_url ) :
			?>
			<section class="personal-section"<?php echo $founder_bg_url ? ' style="background-image:url(' . esc_url( $founder_bg_url ) . ');background-size:cover;background-position:center;"' : ''; ?>>
				<div class="personal-overlay"></div>
				<div class="personal-container">
					<div class="personal-image">
						<img src="<?php echo esc_url( $founder_photo_url ); ?>" alt="<?php echo esc_attr( spotlezz_image_alt( $founder_photo, $founder_name ) ); ?>" loading="lazy" decoding="async">
					</div>
					<div class="personal-content">
						<p class="personal-subtitle"><?php esc_html_e( 'De oprichter', 'spotlezz' ); ?></p>
						<h2>
							<?php
							printf(
								/* translators: %s: naam van de oprichter */
								esc_html__( 'Aangenaam, ik ben %s', 'spotlezz' ),
								'<span>' . esc_html( strtok( $founder_name, ' ' ) ) . '</span>'
							);
							?>
						</h2>
						<p><?php echo esc_html( spotlezz_field( 'founder_intro_p1', $content_id, __( 'Als oprichter van Spotlezz ben ik elke dag bezig met het verbeteren van onze dienstverlening. Ik geloof in een persoonlijke aanpak en korte communicatielijnen. Bij Spotlezz draait alles om mensen: zowel ons eigen team als de mensen voor wie wij schoonmaken.', 'spotlezz' ) ) ); ?></p>
						<p><?php echo esc_html( spotlezz_field( 'founder_intro_p2', $content_id, __( 'Heb je vragen of wil je kennismaken? Ik kom graag bij je langs voor een kop koffie en een advies op maat.', 'spotlezz' ) ) ); ?></p>
						<div class="personal-signature">
							<div class="name"><?php echo esc_html( $founder_name ); ?></div>
							<div class="role"><?php echo esc_html( spotlezz_field( 'founder_role', $page_id, __( 'Oprichter', 'spotlezz' ) ) ); ?></div>
						</div>
						<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-orange"><?php esc_html_e( 'Stuur mij een bericht', 'spotlezz' ); ?></a>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<?php
		/*
		 * Kwaliteitsblok — 1-op-1 dezelfde .clean-kwaliteit-section als
		 * front-page.php sectie 12, zelfde foto-veld (photo_3), zodat één
		 * wijziging aan dat blok niet uit de pas kan lopen tussen de twee
		 * pagina's die het tonen (net als de referentie zelf doet).
		 */
		$ck_photo     = spotlezz_field( 'photo_3', $page_id, null );
		$ck_photo_url = is_array( $ck_photo ) ? ( $ck_photo['url'] ?? '' ) : '';
		$ck_is_tall   = is_array( $ck_photo ) && ( $ck_photo['height'] ?? 0 ) > ( $ck_photo['width'] ?? 0 );
		?>
		<section class="clean-kwaliteit-section">
			<div class="ck-container">
				<div class="ck-left">
					<h2 class="ck-title"><?php esc_html_e( 'Spotlezz staat voor kwaliteit, continuïteit en', 'spotlezz' ); ?> <span><?php esc_html_e( 'hoge klanttevredenheid', 'spotlezz' ); ?></span></h2>
					<p class="ck-desc"><?php esc_html_e( 'Spotlezz is de overtreffende trap van schoon. Met onze unieke aanpak met vaste schoonmakers, regelmatige controles en evaluaties staan wij voor duurzame en blijvende resultaten en hoge klanttevredenheid.', 'spotlezz' ); ?></p>
					<div class="ck-stats-grid">
						<div class="ck-stat">
							<div class="ck-stat-number"><?php esc_html_e( '4x per jaar', 'spotlezz' ); ?></div>
							<div class="ck-stat-text"><?php esc_html_e( 'Een diepgaand evaluatiegesprek om kwaliteit continu te borgen.', 'spotlezz' ); ?></div>
						</div>
						<div class="ck-stat">
							<div class="ck-stat-number">94%</div>
							<div class="ck-stat-text"><?php esc_html_e( 'Van onze contracten wordt succesvol verlengd door tevreden klanten.', 'spotlezz' ); ?></div>
						</div>
					</div>
				</div>
				<div class="ck-right">
					<div class="ck-image-wrapper">
						<?php if ( $ck_photo_url ) : ?>
							<img src="<?php echo esc_url( $ck_photo_url ); ?>"<?php echo $ck_is_tall ? ' style="object-position:center bottom"' : ''; // phpcs:ignore -- static, no user input ?> alt="<?php esc_attr_e( 'Spotlezz kwaliteit', 'spotlezz' ); ?>" loading="lazy" decoding="async">
						<?php endif; ?>
						<div class="ck-badge">
							<div class="ck-badge-title"><?php esc_html_e( 'Klantbeoordeling', 'spotlezz' ); ?></div>
							<div class="ck-badge-value">4,8<span>/5</span></div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<?php spotlezz_reviews_block(); ?>

		<?php
		$medewerker_photo     = spotlezz_field( 'photo_1', $page_id, null );
		$medewerker_photo_url = is_array( $medewerker_photo ) ? ( $medewerker_photo['url'] ?? '' ) : '';
		?>
		<section class="medewerker-split">
			<div class="medewerker-split-text">
				<div class="medewerker-split-name">
					<span class="person-avatar" aria-hidden="true"><?php echo esc_html( mb_substr( spotlezz_field( 'medewerker_naam', $content_id, __( 'Thomas Jansen', 'spotlezz' ) ), 0, 1 ) ); ?></span>
					<span><?php echo esc_html( spotlezz_field( 'medewerker_naam', $content_id, __( 'Thomas Jansen', 'spotlezz' ) ) ); ?></span>
				</div>
				<blockquote><?php echo esc_html( spotlezz_field( 'medewerker_quote', $content_id, __( 'Als ik een kantoor schoonmaak, zorg ik dat alles klopt. Van de werkplekken tot de pantry. Ik weet hoe belangrijk het is dat medewerkers de volgende ochtend in een frisse ruimte kunnen beginnen.', 'spotlezz' ) ) ); ?></blockquote>
			</div>
			<?php if ( $medewerker_photo_url ) : ?>
				<div class="medewerker-split-photo" style="background-image:url('<?php echo esc_url( $medewerker_photo_url ); ?>')" role="img" aria-label="<?php echo esc_attr( spotlezz_image_alt( $medewerker_photo, 'Thomas Jansen' ) ); ?>"></div>
			<?php endif; ?>
		</section>

		<section class="cases-block" style="max-width:var(--spotlezz-max-width);margin:0 auto;padding:0 5% 36px;">
			<h2><?php echo esc_html( spotlezz_field( 'impact_heading', $content_id, __( 'Ontdek onze impact', 'spotlezz' ) ) ); ?></h2>
			<div class="cases-grid">
				<?php
				foreach ( array( 25, 26 ) as $case_id ) :
					$case = get_post( $case_id );
					if ( ! $case || 'publish' !== $case->post_status ) {
						continue;
					}
					?>
					<a class="case-card" href="<?php echo esc_url( get_permalink( $case ) ); ?>">
						<?php $thumb_url = get_the_post_thumbnail_url( $case, 'spotlezz-card' ); ?>
						<?php if ( $thumb_url ) : ?>
							<img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( spotlezz_post_thumbnail_alt( $case->ID, get_the_title( $case ) ) ); ?>" loading="lazy" decoding="async">
						<?php endif; ?>
						<div class="case-card-body">
							<h3><?php echo esc_html( get_field( 'headline', $case_id ) ?: get_the_title( $case ) ); ?></h3>
						</div>
					</a>
				<?php endforeach; ?>
			</div>
		</section>

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
			'title' => __( 'Bekijk onze vacatures', 'spotlezz' ),
			'url'   => home_url( '/vacatures/' ),
		),
		array(
			'label' => __( 'Conversie', 'spotlezz' ),
			'title' => __( 'Vraag een offerte aan', 'spotlezz' ),
			'url'   => home_url( '/offerte-aanvragen/' ),
		),
	)
);

get_footer();
