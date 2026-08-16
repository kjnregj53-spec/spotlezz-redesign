<?php
/**
 * Herbruikbare componenten.
 *
 * Deze functies zijn de enige plek waar terugkerende wireframe-blokken
 * (next-hop bar, statenblok, persoonskaart) gerenderd worden. Elk
 * paginatype in fase 4B/4C roept dezelfde functie aan i.p.v. eigen markup
 * te dupliceren — dat is precies wat de oude static build niet deed, en
 * waardoor daar dubbele next-hop bars konden ontstaan (WIREFRAME-AUDIT §0).
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Next-hop bar. Harde regel 5/8: exact 3 routes, elk met een geldige href.
 * Renderen met een afwijkend aantal is geen degradatie-optie — de functie
 * weigert te renderen en logt het probleem, zodat een misconfiguratie
 * opvalt in plaats van stilzwijgend een kapotte of onvolledige bar te tonen.
 *
 * @param array<int,array{label:string,title:string,url:string}> $routes Precies 3 items:
 *        index 0 = omhoog, index 1 = zijwaarts, index 2 = conversie.
 */
function spotlezz_next_hop( array $routes ) {
	if ( 3 !== count( $routes ) ) {
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			error_log(
				sprintf(
					'Spotlezz: next-hop bar genegeerd, kreeg %d routes i.p.v. exact 3 (regel 5).',
					count( $routes )
				)
			);
		}
		return;
	}

	foreach ( $routes as $route ) {
		if ( empty( $route['url'] ) ) {
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				error_log( 'Spotlezz: next-hop bar genegeerd, een route mist een geldige url (regel 8).' );
			}
			return;
		}
	}

	$variants = array( 'up', 'side', 'cta' );
	?>
	<nav class="next-hop-bar" aria-label="<?php esc_attr_e( 'Verder lezen', 'spotlezz' ); ?>">
		<?php foreach ( $routes as $index => $route ) : ?>
			<a href="<?php echo esc_url( $route['url'] ); ?>" class="next-hop-card next-hop-<?php echo esc_attr( $variants[ $index ] ); ?>">
				<span class="hop-kind"><?php echo esc_html( $route['label'] ); ?></span>
				<span class="hop-title"><?php echo esc_html( $route['title'] ); ?></span>
			</a>
		<?php endforeach; ?>
	</nav>
	<?php
}

/**
 * Antwoordblok: het terugkerende "4 statistieken direct onder de hero"-
 * patroon (homepage rij 3, pillar rij 3, locatie rij 3).
 *
 * @param array<int,array{value:string,label:string}> $stats Exact 4 items verwacht;
 *        méér/minder wordt gerenderd maar is een contentfout, geen technische —
 *        anders dan next-hop is dit blok qua wireframe niet overal hard op 4
 *        vastgezet (sommige varianten tonen er incidenteel 3), dus geen harde block.
 */
function spotlezz_stat_block( array $stats ) {
	if ( empty( $stats ) ) {
		return;
	}
	?>
	<div class="stat-block">
		<?php foreach ( $stats as $stat ) : ?>
			<div class="stat">
				<b><?php echo esc_html( $stat['value'] ); ?></b>
				<span><?php echo esc_html( $stat['label'] ); ?></span>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
}

/**
 * Persoonskaart: het "medewerker/oprichter aan het woord"-blok dat op vier
 * van de vijf wireframes terugkomt. Rendert de zichtbare kaart EN registreert
 * in dezelfde aanroep de bijbehorende Person-schema-node — zo kunnen kaart en
 * schema nooit uit elkaar lopen (regel 9), en kan een leeg naam-veld nooit
 * per ongeluk toch een Person-node opleveren.
 *
 * @param array{name:string,job_title?:string,quote?:string,image_url?:string,linkedin?:string,id_suffix?:string} $person
 */
function spotlezz_person_card( array $person ) {
	$name = isset( $person['name'] ) ? trim( $person['name'] ) : '';
	if ( '' === $name ) {
		return; // Geen naam, geen kaart, geen schema — nooit een verzonnen identiteit tonen.
	}

	add_filter(
		'spotlezz_schema_graph',
		function ( $graph ) use ( $person ) {
			$node = spotlezz_schema_person( $person );
			if ( $node ) {
				$graph[] = $node;
			}
			return $graph;
		}
	);
	?>
	<div class="person-card">
		<?php if ( ! empty( $person['image_url'] ) ) : ?>
			<img class="person-photo" src="<?php echo esc_url( $person['image_url'] ); ?>" alt="<?php echo esc_attr( $name ); ?>" loading="lazy" decoding="async">
		<?php else : ?>
			<span class="person-avatar" aria-hidden="true"><?php echo esc_html( mb_substr( $name, 0, 1 ) ); ?></span>
		<?php endif; ?>
		<div class="person-info">
			<span class="person-name"><?php echo esc_html( $name ); ?></span>
			<?php if ( ! empty( $person['job_title'] ) ) : ?>
				<span class="person-role"><?php echo esc_html( $person['job_title'] ); ?></span>
			<?php endif; ?>
			<?php if ( ! empty( $person['linkedin'] ) ) : ?>
				<a class="person-linkedin" href="<?php echo esc_url( $person['linkedin'] ); ?>" target="_blank" rel="noopener noreferrer">
					<?php esc_html_e( 'LinkedIn-profiel', 'spotlezz' ); ?>
				</a>
			<?php endif; ?>
			<?php if ( ! empty( $person['quote'] ) ) : ?>
				<p class="person-quote">&ldquo;<?php echo esc_html( $person['quote'] ); ?>&rdquo;</p>
			<?php endif; ?>
		</div>
	</div>
	<?php
}

/**
 * Alt-tekst-resolver voor ACF-afbeeldingsvelden (return_format 'array').
 * Elke editable foto in de theme haalt zijn alt-tekst hierdoorheen, zodat
 * er nooit een `<img>` zonder alt gerenderd wordt: eerst de alt-tekst die
 * in de media-bibliotheek is ingevuld, anders de meegegeven fallback
 * (bv. de naam van de persoon of het bijschrift van de foto) — nooit een
 * lege string.
 *
 * @param array|null $image    ACF image-array (['url'=>..., 'alt'=>...]) of null.
 * @param string     $fallback Fallback-tekst als de media-alt leeg is.
 * @return string
 */
function spotlezz_image_alt( $image, $fallback = '' ) {
	if ( is_array( $image ) && ! empty( $image['alt'] ) ) {
		return $image['alt'];
	}
	return $fallback;
}

/**
 * Alt-tekst voor een native WordPress uitgelichte afbeelding (geen ACF-
 * veld, bv. de featured image van een pillar/case-post). Zelfde
 * fallback-logica als spotlezz_image_alt(), maar dan uitgaande van een
 * attachment-ID i.p.v. een ACF-array.
 *
 * @param int    $post_id  Post met de uitgelichte afbeelding.
 * @param string $fallback Fallback-tekst, meestal de posttitel.
 * @return string
 */
function spotlezz_post_thumbnail_alt( $post_id, $fallback = '' ) {
	$thumb_id = get_post_thumbnail_id( $post_id );
	if ( ! $thumb_id ) {
		return $fallback;
	}
	$alt = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
	return ! empty( $alt ) ? $alt : $fallback;
}

/**
 * Reviewscore-badge (ster + cijfer + aantal), gebruikt in de topbar en de
 * hero op alle paginatypes. Eén bron (Site Options) zodat het cijfer nooit
 * per pagina kan afwijken.
 */
function spotlezz_review_badge() {
	$score = spotlezz_get_option( 'review_score' );
	$count = spotlezz_get_option( 'review_count' );
	if ( '' === $score || '' === $count ) {
		return;
	}
	?>
	<span class="review-badge">
		<span class="review-stars" aria-hidden="true">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
		<?php
		printf(
			/* translators: 1: reviewscore, 2: aantal reviews */
			esc_html__( '%1$s/5 · %2$s beoordelingen', 'spotlezz' ),
			esc_html( $score ),
			esc_html( $count )
		);
		?>
	</span>
	<?php
}

/**
 * Reviewblok — gedeeld tussen homepage, elke pillar en elke locatiepagina
 * (WORDPRESS-BUILD-PLAN §5-beslissing 1, APPROVED). Bron is altijd Site
 * Options (`review_1_quote` t/m `review_3_photo`), nooit per-pagina content
 * — er is precies één plek waar deze drie reviews bewerkt worden.
 *
 * Geëxtraheerd uit front-page.php (fase 4B) toen fase 4C dit ook op
 * pillar-pagina's nodig had; de homepage-uitvoer is bewust pixel-identiek
 * gebleven — alleen de databron veranderde van paginaveld naar Site Option.
 *
 * Let op: `review_N_photo` is hier een kale URL (Site Options ondersteunt
 * geen ACF-afbeeldingsveld zonder Options Page/ACF Pro), geen ACF-array
 * zoals de oude per-pagina-versie — vandaar `esc_url()` + `esc_attr($name)`
 * i.p.v. `spotlezz_image_alt()`.
 */
function spotlezz_reviews_block() {
	$reviews = array();
	foreach ( array( 1, 2, 3 ) as $i ) {
		$reviews[] = array(
			'quote'  => spotlezz_get_option( "review_{$i}_quote" ),
			'name'   => spotlezz_get_option( "review_{$i}_name" ),
			'role'   => spotlezz_get_option( "review_{$i}_role" ),
			'photo'  => spotlezz_get_option( "review_{$i}_photo" ),
		);
	}

	$has_any_review = false;
	foreach ( $reviews as $review ) {
		if ( '' !== $review['quote'] || '' !== $review['name'] ) {
			$has_any_review = true;
			break;
		}
	}
	if ( ! $has_any_review ) {
		return;
	}
	?>
	<section class="reviews-block">
		<div class="reviews-grid">
			<?php foreach ( $reviews as $review ) : ?>
				<?php
				$quote = $review['quote'];
				$name  = $review['name'];
				$role  = $review['role'];
				$photo = $review['photo'];
				if ( '' === $quote && '' === $name ) {
					continue; // Lege set overslaan, niets verzinnen.
				}
				?>
				<blockquote class="review-card">
					<span class="review-stars" aria-hidden="true">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
					<p><?php echo esc_html( $quote ); ?></p>
					<div class="review-author">
						<?php if ( ! empty( $photo ) ) : ?>
							<img src="<?php echo esc_url( $photo ); ?>" alt="<?php echo esc_attr( $name ); ?>" loading="lazy" decoding="async">
						<?php endif; ?>
						<span>
							<b><?php echo esc_html( $name ); ?></b>
							<?php if ( $role ) : ?><span class="review-role"><?php echo esc_html( $role ); ?></span><?php endif; ?>
						</span>
					</div>
				</blockquote>
				<?php
				add_filter(
					'spotlezz_schema_graph',
					function ( $graph ) use ( $quote, $name ) {
						if ( '' === $quote || '' === $name ) {
							return $graph;
						}
						$graph[] = array(
							'@type'        => 'Review',
							'reviewBody'   => wp_strip_all_tags( $quote ),
							'author'       => array(
								'@type' => 'Person',
								'name'  => wp_strip_all_tags( $name ),
							),
							'itemReviewed' => array( '@id' => home_url( '/#organization' ) ),
						);
						return $graph;
					}
				);
				?>
			<?php endforeach; ?>
		</div>
		<p class="reviews-footnote">
			<?php spotlezz_review_badge(); ?>
			· <a href="<?php echo esc_url( home_url( '/reviews/' ) ); ?>"><?php esc_html_e( 'Bekijk alle reviews', 'spotlezz' ); ?></a>
		</p>
	</section>
	<?php
}

/**
 * FAQ-blok — gedeeld tussen homepage en elke pillar. Leest het
 * `featured_faqs`-relationship-veld van de meegegeven post (elk paginatype
 * heeft zijn eigen veldgroep, maar hetzelfde veldnaam-patroon), rendert de
 * accordion en hangt een `FAQPage`-schema-node op met exact de zichtbare
 * vragen — nooit meer of minder dan wat er staat.
 *
 * Geëxtraheerd uit front-page.php (fase 4B); homepage-uitvoer blijft
 * pixel-identiek.
 *
 * @param int    $post_id    Post met het relationship-veld.
 * @param string $field_name Veldnaam van het relationship-veld — homepage
 *                            en pillar gebruiken `featured_faqs`, locatie
 *                            gebruikt het eigen `lokale_faqs` (fase 4C).
 */
function spotlezz_faq_block( $post_id, $field_name = 'featured_faqs' ) {
	$featured_faqs = spotlezz_field( $field_name, $post_id, array() );
	$featured_faqs = array_filter(
		is_array( $featured_faqs ) ? $featured_faqs : array(),
		function ( $faq ) {
			return $faq instanceof WP_Post && 'publish' === $faq->post_status;
		}
	);

	if ( empty( $featured_faqs ) ) {
		if ( current_user_can( 'edit_theme_options' ) ) {
			?>
			<p class="placeholder-note content-placeholder"><?php esc_html_e( 'Nog geen vragen geselecteerd in het veld "Vijf vragen" / "FAQ".', 'spotlezz' ); ?></p>
			<?php
		}
		return;
	}

	$faq_schema_items = array();
	?>
	<section class="faq-block">
		<h2><?php esc_html_e( 'Veelgestelde vragen', 'spotlezz' ); ?></h2>
		<div class="faq-list">
			<?php foreach ( $featured_faqs as $faq ) : ?>
				<?php $answer = get_the_excerpt( $faq ); ?>
				<details class="faq-item">
					<summary><?php echo esc_html( get_the_title( $faq ) ); ?></summary>
					<?php if ( $answer ) : ?>
						<p><?php echo esc_html( $answer ); ?></p>
					<?php endif; ?>
				</details>
				<?php
				if ( $answer ) {
					$faq_schema_items[] = array(
						'@type'          => 'Question',
						'name'           => wp_strip_all_tags( get_the_title( $faq ) ),
						'acceptedAnswer' => array(
							'@type' => 'Answer',
							'text'  => wp_strip_all_tags( $answer ),
						),
					);
				}
				?>
			<?php endforeach; ?>
		</div>
		<p class="faq-more">
			<a href="<?php echo esc_url( get_post_type_archive_link( 'vraag' ) ?: home_url( '/veelgestelde-vragen/' ) ); ?>">
				<?php esc_html_e( 'Bekijk alle veelgestelde vragen', 'spotlezz' ); ?>
			</a>
		</p>
	</section>
	<?php
	if ( ! empty( $faq_schema_items ) ) {
		add_filter(
			'spotlezz_schema_graph',
			function ( $graph ) use ( $faq_schema_items ) {
				$graph[] = array(
					'@type'      => 'FAQPage',
					'mainEntity' => $faq_schema_items,
				);
				return $graph;
			}
		);
	}
}

/**
 * Werkwijze (4 stappen) + vergelijkingstabel — gedeeld over elke pillar-
 * pagina (WORDPRESS-BUILD-PLAN §3.2, PHASE-4C-PLAN.md beslissing 3,
 * APPROVED). Identieke tekst op elke pillar, dus één bron in Site Options
 * i.p.v. 10× dezelfde tekst kopiëren. Geen WYSIWYG — bewust simpele
 * tekstvelden, structuur en lay-out staan vast in dit component.
 */
function spotlezz_werkwijze_vergelijking_block() {
	$stappen = array();
	for ( $i = 1; $i <= 4; $i++ ) {
		$titel = spotlezz_get_option( "stap_{$i}_titel" );
		$tekst = spotlezz_get_option( "stap_{$i}_tekst" );
		if ( '' === $titel && '' === $tekst ) {
			continue;
		}
		$stappen[] = array( 'titel' => $titel, 'tekst' => $tekst );
	}

	$spotlezz_rows = array();
	$anderen_rows  = array();
	for ( $i = 1; $i <= 5; $i++ ) {
		$s = spotlezz_get_option( "vgl_spotlezz_{$i}" );
		$a = spotlezz_get_option( "vgl_anderen_{$i}" );
		if ( '' !== $s ) {
			$spotlezz_rows[] = $s;
		}
		if ( '' !== $a ) {
			$anderen_rows[] = $a;
		}
	}

	if ( empty( $stappen ) && empty( $spotlezz_rows ) && empty( $anderen_rows ) ) {
		return;
	}
	?>
	<section class="werkwijze-block">
		<?php if ( ! empty( $stappen ) ) : ?>
			<h2><?php esc_html_e( 'Zo werkt het', 'spotlezz' ); ?></h2>
			<div class="werkwijze-steps">
				<?php foreach ( $stappen as $index => $stap ) : ?>
					<div class="werkwijze-step">
						<b class="werkwijze-step-num"><?php echo (int) ( $index + 1 ); ?></b>
						<?php if ( $stap['titel'] ) : ?><h3><?php echo esc_html( $stap['titel'] ); ?></h3><?php endif; ?>
						<?php if ( $stap['tekst'] ) : ?><p><?php echo esc_html( $stap['tekst'] ); ?></p><?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $spotlezz_rows ) || ! empty( $anderen_rows ) ) : ?>
			<div class="compare-grid">
				<div class="compare-col compare-col-spotlezz">
					<h3><?php esc_html_e( 'Spotlezz', 'spotlezz' ); ?></h3>
					<ul>
						<?php foreach ( $spotlezz_rows as $row ) : ?>
							<li><?php echo esc_html( $row ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="compare-col">
					<h3><?php esc_html_e( 'Andere bedrijven', 'spotlezz' ); ?></h3>
					<ul>
						<?php foreach ( $anderen_rows as $row ) : ?>
							<li><?php echo esc_html( $row ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		<?php endif; ?>

		<div class="werkwijze-cta">
			<a href="<?php echo esc_url( home_url( '/offerte-aanvragen/' ) ); ?>" class="btn btn-orange"><?php esc_html_e( 'Vraag een offerte aan', 'spotlezz' ); ?></a>
			<span class="mini"><?php esc_html_e( 'Vrijblijvend · reactie binnen 12 uur', 'spotlezz' ); ?></span>
		</div>
	</section>
	<?php
}

/**
 * Conversieblok Variant A ("e-mailmagneet") op de FAQ-detailpagina —
 * WORDPRESS-BUILD-PLAN §3.5, PHASE-4C-PLAN.md beslissing 5 (APPROVED):
 * deze fase bouwt alleen de VISUELE component (velden, styling), geen
 * werkende verzending. Er bestaat op dit moment geen FORM_ENDPOINT-laag
 * in dit theme, dus het formulier heeft bewust geen `action`/`method` en
 * verstuurt niets — de verzendlaag (echte POST, foutafhandeling) is een
 * aparte, latere stap zoals afgesproken, geen halve/stille implementatie.
 *
 * Vast theme-component, geen ACF-veld: de velden (m², frequentie, branche,
 * e-mail) en de tekst liggen structureel vast, zoals het wireframe ze
 * beschrijft — dit is geen content die per vraag verschilt.
 */
function spotlezz_conversion_variant_a() {
	?>
	<section class="conversion-variant-a">
		<span class="lbl" style="color:var(--spotlezz-blue);"><?php esc_html_e( 'Variant A · e-mailmagneet', 'spotlezz' ); ?></span>
		<form class="variant-a-form" onsubmit="return false;">
			<div class="variant-a-grid">
				<label class="screen-reader-text" for="variant-a-m2"><?php esc_html_e( 'Oppervlakte in m²', 'spotlezz' ); ?></label>
				<input type="number" id="variant-a-m2" name="m2" placeholder="<?php esc_attr_e( 'Oppervlakte (m²)', 'spotlezz' ); ?>" min="0">

				<label class="screen-reader-text" for="variant-a-frequentie"><?php esc_html_e( 'Frequentie', 'spotlezz' ); ?></label>
				<select id="variant-a-frequentie" name="frequentie">
					<option value=""><?php esc_html_e( 'Frequentie', 'spotlezz' ); ?></option>
					<option value="1x-per-week"><?php esc_html_e( '1x per week', 'spotlezz' ); ?></option>
					<option value="2-3x-per-week"><?php esc_html_e( '2-3x per week', 'spotlezz' ); ?></option>
					<option value="dagelijks"><?php esc_html_e( 'Dagelijks', 'spotlezz' ); ?></option>
				</select>

				<label class="screen-reader-text" for="variant-a-branche"><?php esc_html_e( 'Branche', 'spotlezz' ); ?></label>
				<input type="text" id="variant-a-branche" name="branche" placeholder="<?php esc_attr_e( 'Branche', 'spotlezz' ); ?>">
			</div>
			<label class="screen-reader-text" for="variant-a-email"><?php esc_html_e( 'E-mailadres', 'spotlezz' ); ?></label>
			<input type="email" id="variant-a-email" name="email" class="variant-a-email" placeholder="<?php esc_attr_e( 'E-mailadres', 'spotlezz' ); ?>">
			<button type="submit" class="btn btn-orange variant-a-submit"><?php esc_html_e( 'Ontvang je indicatie per mail', 'spotlezz' ); ?></button>
			<p class="mini"><?php esc_html_e( 'De uitkomst gaat naar de inbox · levert een lead op, ook als de bezoeker nog niet wil bellen.', 'spotlezz' ); ?></p>
			<?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
				<p class="placeholder-note content-placeholder"><?php esc_html_e( 'Visuele component (fase 4C). Verzendlaag volgt in een aparte stap — dit formulier verstuurt nu niets. Alleen zichtbaar voor ingelogde beheerders.', 'spotlezz' ); ?></p>
			<?php endif; ?>
		</form>
	</section>
	<?php
}
