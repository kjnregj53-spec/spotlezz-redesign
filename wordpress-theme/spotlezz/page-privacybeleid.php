<?php
/**
 * Privacybeleid — bestond nog niet; footer.php verwijst al naar de slug
 * "privacybeleid" (zie get_page_by_path hierboven in footer.php). Volledige
 * tekst 1-op-1 overgenomen uit spotlezz.vercel.app/privacybeleid/index.html
 * — een echt, specifiek document (bewaartermijnen, KVK-context), geen
 * generieke placeholdertekst.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<div class="content-wrap" style="max-width:760px;margin:0 auto;padding:40px 5%;">
		<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<h1><?php esc_html_e( 'Privacybeleid', 'spotlezz' ); ?></h1>
			<p class="mini"><?php esc_html_e( 'Laatst bijgewerkt: maart 2025', 'spotlezz' ); ?></p>
			<p><?php esc_html_e( 'Spotlezz hecht veel waarde aan de bescherming van uw persoonsgegevens. In dit privacybeleid geven wij heldere en transparante informatie over hoe wij omgaan met persoonsgegevens.', 'spotlezz' ); ?></p>

			<h2><?php esc_html_e( '1. Persoonsgegevens die wij verwerken', 'spotlezz' ); ?></h2>
			<p><?php esc_html_e( 'Spotlezz verwerkt uw persoonsgegevens doordat u gebruik maakt van onze diensten en/of omdat u deze zelf aan ons verstrekt, bijvoorbeeld via het contact- of offerteformulier op deze website. Hieronder vindt u een overzicht van de persoonsgegevens die wij mogelijk verwerken:', 'spotlezz' ); ?></p>
			<ul>
				<li><?php esc_html_e( 'Voor- en achternaam', 'spotlezz' ); ?></li>
				<li><?php esc_html_e( 'Bedrijfsnaam (indien van toepassing)', 'spotlezz' ); ?></li>
				<li><?php esc_html_e( 'Telefoonnummer', 'spotlezz' ); ?></li>
				<li><?php esc_html_e( 'E-mailadres', 'spotlezz' ); ?></li>
				<li><?php esc_html_e( 'Overige persoonsgegevens die u actief verstrekt (bijvoorbeeld in berichten of tijdens correspondentie)', 'spotlezz' ); ?></li>
			</ul>

			<h2><?php esc_html_e( '2. Met welk doel wij persoonsgegevens verwerken', 'spotlezz' ); ?></h2>
			<p><?php esc_html_e( 'Wij verwerken uw persoonsgegevens voor de volgende doelen:', 'spotlezz' ); ?></p>
			<ul>
				<li><?php esc_html_e( 'Om u te kunnen bellen of e-mailen indien dit nodig is om onze dienstverlening uit te kunnen voeren (bijvoorbeeld het sturen van een offerte).', 'spotlezz' ); ?></li>
				<li><?php esc_html_e( 'Om diensten bij u af te leveren en afspraken in te plannen.', 'spotlezz' ); ?></li>
				<li><?php esc_html_e( 'Het afhandelen van uw betalingen.', 'spotlezz' ); ?></li>
			</ul>

			<h2><?php esc_html_e( '3. Hoe lang we persoonsgegevens bewaren', 'spotlezz' ); ?></h2>
			<p><?php esc_html_e( 'Spotlezz bewaart uw persoonsgegevens niet langer dan strikt nodig is om de doelen te realiseren waarvoor uw gegevens worden verzameld. Gegevens verkregen voor een offerteaanvraag worden maximaal 1 jaar bewaard, tenzij hieruit een overeenkomst volgt, dan geldt de wettelijke bewaartermijn van 7 jaar (voor de Belastingdienst).', 'spotlezz' ); ?></p>

			<h2><?php esc_html_e( '4. Delen van persoonsgegevens met derden', 'spotlezz' ); ?></h2>
			<p><?php esc_html_e( 'Spotlezz verkoopt uw gegevens niet aan derden en verstrekt deze uitsluitend indien dit nodig is voor de uitvoering van onze overeenkomst met u of om te voldoen aan een wettelijke verplichting. Met bedrijven die uw gegevens verwerken in onze opdracht (zoals ons boekhoudprogramma), sluiten wij een verwerkersovereenkomst om te zorgen voor eenzelfde niveau van beveiliging en vertrouwelijkheid.', 'spotlezz' ); ?></p>

			<h2><?php esc_html_e( '5. Cookies, of vergelijkbare technieken', 'spotlezz' ); ?></h2>
			<p><?php esc_html_e( 'Spotlezz gebruikt uitsluitend technische en functionele cookies, evenals analytische cookies (zoals Google Analytics) die geen inbreuk maken op uw privacy. Een cookie is een klein tekstbestand dat bij het eerste bezoek aan deze website wordt opgeslagen op uw computer, tablet of smartphone.', 'spotlezz' ); ?></p>

			<h2><?php esc_html_e( '6. Gegevens inzien, aanpassen of verwijderen', 'spotlezz' ); ?></h2>
			<p>
				<?php
				printf(
					/* translators: %s: e-mailadres */
					esc_html__( 'U heeft het recht om uw persoonsgegevens in te zien, te corrigeren of te verwijderen. Daarnaast heeft u het recht om uw eventuele toestemming voor de gegevensverwerking in te trekken of bezwaar te maken tegen de verwerking van uw persoonsgegevens door Spotlezz. U kunt een verzoek tot inzage, correctie of verwijdering sturen naar %s.', 'spotlezz' ),
					'<a href="mailto:' . esc_attr( spotlezz_get_option( 'email' ) ) . '">' . esc_html( spotlezz_get_option( 'email' ) ) . '</a>'
				);
				?>
			</p>

			<h2><?php esc_html_e( '7. Hoe wij persoonsgegevens beveiligen', 'spotlezz' ); ?></h2>
			<p>
				<?php
				printf(
					/* translators: %s: e-mailadres */
					esc_html__( 'Spotlezz neemt de bescherming van uw gegevens serieus en neemt passende maatregelen om misbruik, verlies, onbevoegde toegang, ongewenste openbaarmaking en ongeoorloofde wijziging tegen te gaan. Als u de indruk heeft dat uw gegevens niet goed beveiligd zijn of er aanwijzingen zijn van misbruik, neem dan contact op via %s.', 'spotlezz' ),
					'<a href="mailto:' . esc_attr( spotlezz_get_option( 'email' ) ) . '">' . esc_html( spotlezz_get_option( 'email' ) ) . '</a>'
				);
				?>
			</p>
		</article>
	</div>
	<?php
endwhile;

get_footer();
