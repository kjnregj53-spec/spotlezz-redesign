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
 * CSS-class voor het hoofdnavigatie-item van de sectie waar de bezoeker nu
 * in zit — 1-op-1 van de referentie (`nav a.is-current { color: var(
 * --accent-orange) }`). Een los stuk zodat header + mobiele nav nooit uit
 * de pas kunnen lopen over welke pagina's bij welke hub horen.
 *
 * @param string $section Een van: diensten, klantcases, locaties, faq, over-ons, contact.
 * @return string ' is-current' (met voorloop-spatie) of ''.
 */
function spotlezz_nav_is_current( $section ) {
	switch ( $section ) {
		case 'diensten':
			$active = is_post_type_archive( 'pillar' ) || is_singular( 'pillar' );
			break;
		case 'klantcases':
			$active = is_post_type_archive( 'case' ) || is_singular( 'case' );
			break;
		case 'locaties':
			$active = is_post_type_archive( 'locatie' ) || is_singular( 'locatie' );
			break;
		case 'faq':
			$active = is_post_type_archive( 'vraag' ) || is_singular( 'vraag' );
			break;
		case 'over-ons':
			$active = is_page( 'over-ons' );
			break;
		case 'contact':
			$active = is_page( 'contact' );
			break;
		default:
			$active = false;
	}
	return $active ? ' is-current' : '';
}

/**
 * De twee pillar-groepen ("Voor wie" / "Wat we doen") voor het Diensten-
 * dropdownmenu (header + mobiele nav). Vaste slug-groepering — zelfde reden
 * als in footer.php: de branche-taxonomie garandeert geen 1-op-1 scheiding
 * "branche vs. taak", terwijl deze indeling exact de referentie volgt. Eén
 * plek zodat header, mobiele nav en footer nooit uit de pas kunnen lopen.
 * Elk item is alleen een echte, gepubliceerde pillar-post (harde regel 7/8).
 *
 * @return array{voor_wie: WP_Post[], wat_we_doen: WP_Post[]}
 */
function spotlezz_diensten_nav_groups() {
	$slug_groups = array(
		'voor_wie'    => array( 'kantoor-schoonmaak', 'hotel-schoonmaak', 'showroom-schoonmaak', 'sportschool-schoonmaak', 'kinderopvang-schoonmaak', 'vve-schoonmaak' ),
		'wat_we_doen' => array( 'glasbewassing', 'vloeronderhoud', 'opleveringsschoonmaak', 'hygieneservice' ),
	);

	$groups = array();
	foreach ( $slug_groups as $group_key => $slugs ) {
		$groups[ $group_key ] = array();
		foreach ( $slugs as $slug ) {
			$pillar = get_page_by_path( $slug, OBJECT, 'pillar' );
			if ( $pillar && 'publish' === $pillar->post_status ) {
				$groups[ $group_key ][] = $pillar;
			}
		}
	}
	return $groups;
}

/**
 * Page-hero: de volle-breedte foto-band met donkere overlay, met de
 * breadcrumb en de witte H1 er bínnen — gebruikt op elk subpagina-type
 * (pillar/case/locatie/vraag + hubs). Zelfde patroon als op spotlezz.nl
 * (elk paginatype deelt daar één vaste achtergrondfoto per type, geen
 * losse foto per post).
 *
 * De breadcrumb en de H1 renderen altijd, met of zonder foto — dit is de
 * enige plek waar dit paginatype zijn H1 en zijn navigatie krijgt, dus
 * die mogen nooit stilzwijgend verdwijnen als de Site-Option-foto ooit
 * leeg raakt. Zonder foto valt de sectie terug op een effen donkere band
 * (zelfde overlay-kleur), in plaats van niets te tonen.
 *
 * @param string $title    H1-tekst (meestal de posttitel).
 * @param string $image_url Volledige URL van de achtergrondfoto (optioneel).
 * @param string $kicker   Optioneel klein label boven de H1.
 * @param string $intro    Optionele introzin onder de H1 — 1-op-1 van de
 *        referentie, die op elke subpagina behalve de dienst-detail ook een
 *        intro-alinea in de hero heeft staan (niet alleen breadcrumb+H1).
 *        Zonder deze alinea bleef de sectie hier korter dan daar, waardoor
 *        dezelfde achtergrondfoto krapper gecropt werd en er bovenin een
 *        hoofd kon worden afgesneden — geen CSS-crop-bug, gewoon te weinig
 *        inhoud om de foto de ruimte te geven die hij in de referentie krijgt.
 */
function spotlezz_page_hero( $title, $image_url = '', $kicker = '', $intro = '' ) {
	$style = $image_url ? ' style="background-image:url(' . esc_url( $image_url ) . ')"' : '';
	?>
	<section class="page-hero<?php echo $image_url ? '' : ' page-hero-fallback'; ?>"<?php echo $style; // phpcs:ignore -- $style is built with esc_url() above. ?>>
		<div class="page-hero-overlay"></div>
		<div class="page-hero-content">
			<?php spotlezz_breadcrumb(); ?>
			<?php if ( $kicker ) : ?>
				<p class="page-hero-kicker"><?php echo esc_html( $kicker ); ?></p>
			<?php endif; ?>
			<h1><?php echo esc_html( $title ); ?></h1>
			<?php if ( $intro ) : ?>
				<p class="page-hero-intro"><?php echo esc_html( $intro ); ?></p>
			<?php endif; ?>
		</div>
	</section>
	<?php
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
 * @param bool $overlap Voeg de "over de hero-foto heen schuiven"-modifier toe
 *        (.stat-block-overlap, negative margin-top). Alleen `true` doorgeven
 *        op plekken waar met zekerheid niets anders vóór dit blok in dezelfde
 *        sectie staat — anders schuift de kaart over die inhoud heen i.p.v.
 *        over de hero.
 */
function spotlezz_stat_block( array $stats, $overlap = false ) {
	if ( empty( $stats ) ) {
		return;
	}
	$class = $overlap ? 'stat-block stat-block-overlap' : 'stat-block';
	?>
	<div class="<?php echo esc_attr( $class ); ?>">
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
						<?php elseif ( '' !== $name ) : ?>
							<span class="review-avatar" aria-hidden="true"><?php echo esc_html( mb_substr( $name, 0, 1 ) ); ?></span>
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
	<?php
	/*
	 * 1-op-1 van de referentie's .faq-section/.faq-container (tweekoloms:
	 * kop+intro+CTA links, accordion-kaarten rechts, oranje rand-accent op
	 * de open vraag) — verving de eerdere platte lijst. Blijft <details>/
	 * <summary> (geen JS nodig) en blijft binnen .faq-block scoped zodat
	 * dit de FAQ-hub (archive-vraag.php, die .faq-item ook gebruikt) niet
	 * raakt.
	 */
	?>
	<section class="faq-block">
		<div class="faq-container">
			<div class="faq-left">
				<h2><?php esc_html_e( 'Veelgestelde vragen', 'spotlezz' ); ?></h2>
				<p><?php esc_html_e( 'Heb je nog vragen? Kijk dan bij onze veelgestelde vragen. Staat jouw vraag er niet bij? Neem dan gerust contact met ons op!', 'spotlezz' ); ?></p>
				<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-orange"><?php esc_html_e( 'Neem contact met ons op', 'spotlezz' ); ?></a>
			</div>
			<div class="faq-right">
				<?php foreach ( $featured_faqs as $faq ) : ?>
					<?php
					$kort_antwoord = spotlezz_field( 'kort_antwoord', $faq->ID, '' );
					$answer        = $kort_antwoord ? $kort_antwoord : get_the_excerpt( $faq );
					?>
					<details class="faq-item">
						<summary>
							<span><?php echo esc_html( get_the_title( $faq ) ); ?></span>
							<span class="faq-icon" aria-hidden="true"></span>
						</summary>
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
				<p class="faq-more">
					<a href="<?php echo esc_url( get_post_type_archive_link( 'vraag' ) ?: home_url( '/veelgestelde-vragen/' ) ); ?>">
						<?php esc_html_e( 'Bekijk alle veelgestelde vragen', 'spotlezz' ); ?>
					</a>
				</p>
			</div>
		</div>
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
	<?php
	/*
	 * 1-op-1 van .ks-hiw-cards: elke stap krijgt een echte foto als
	 * achtergrond i.p.v. een genummerde cirkel op wit. Dit blok is gedeeld
	 * over alle pillar-pagina's (zelfde tekst overal), dus ook de foto's
	 * zijn generiek/gedeeld — vier al bevestigde, echte Spotlezz-foto's
	 * uit de mediabibliotheek, niets nieuws verzonnen.
	 */
	$step_photo_ids = array( 173, 114, 104, 172 ); // kantooroverleg, branche-kantoor-schoon, team-aan-het-werk-schoon, materiaal (stoomdweil)
	?>
	<section class="werkwijze-block">
		<?php if ( ! empty( $stappen ) ) : ?>
			<h2><?php esc_html_e( 'Zo werkt het', 'spotlezz' ); ?></h2>
			<div class="werkwijze-steps">
				<?php foreach ( $stappen as $index => $stap ) : ?>
					<?php
					$step_photo_url = isset( $step_photo_ids[ $index ] ) ? wp_get_attachment_image_url( $step_photo_ids[ $index ], 'spotlezz-card' ) : '';
					$step_style     = $step_photo_url ? ' style="background-image:url(' . esc_url( $step_photo_url ) . ')"' : '';
					?>
					<div class="werkwijze-step"<?php echo $step_style; // phpcs:ignore -- $step_style is built with esc_url() above. ?>>
						<div class="werkwijze-step-content">
							<b class="werkwijze-step-num"><?php echo (int) ( $index + 1 ); ?></b>
							<?php if ( $stap['titel'] ) : ?><h3><?php echo esc_html( $stap['titel'] ); ?></h3><?php endif; ?>
							<?php if ( $stap['tekst'] ) : ?><p><?php echo esc_html( $stap['tekst'] ); ?></p><?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $spotlezz_rows ) || ! empty( $anderen_rows ) ) : ?>
			<?php
			/*
			 * 1-op-1 van de homepage's .comparison-grid/.compare-card —
			 * verving hier de oudere, losstaande .compare-grid/.compare-col
			 * (donkere kaart, ander design) zodat de vergelijkingskaart er
			 * op elke pillar-pagina hetzelfde uitziet als op de homepage en
			 * in de referentie (waar dezelfde classnamen overal terugkomen).
			 * De kop hieronder ontbrak eerder — de referentie's .ks-
			 * comparison heeft er wél één ("Spotlezz versus andere
			 * bedrijven"), en zonder kop oogde de vergelijkingskaart alsof
			 * hij zomaar tegen de stappen erboven aan geplakt zat.
			 */
			?>
			<h2 class="comparison-subheading"><?php esc_html_e( 'Spotlezz versus andere bedrijven', 'spotlezz' ); ?></h2>
			<div class="comparison-grid">
				<div class="compare-card compare-spotlezz">
					<h3><?php esc_html_e( 'Spotlezz', 'spotlezz' ); ?></h3>
					<ul class="compare-list">
						<?php foreach ( $spotlezz_rows as $row ) : ?>
							<li><?php echo esc_html( $row ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="compare-card compare-others">
					<h3><?php esc_html_e( 'Andere bedrijven', 'spotlezz' ); ?></h3>
					<ul class="compare-list">
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
 * Vier "tekst + foto"-secties tussen de trust-bar en het takenraster —
 * 1-op-1 van de referentie's .ks-text-image/.ks-importance op elke
 * dienst-pagina (intro, "waarom is dit belangrijk", "waarom Spotlezz",
 * "het verschil zit in de details").
 *
 * Belangrijk: in de referentie zelf is dit al gedeelde, letterlijk
 * identieke tekst op alle 10 dienst-pagina's (geverifieerd: kantoor-,
 * hotel- en vve-schoonmaak bevatten woord-voor-woord dezelfde alinea's,
 * inclusief een verwijzing naar "kantoorreiniging" op de VvE-pagina). Dit
 * is dus geen nieuw verzonnen tekst maar 1-op-1 overgenomen, gedeelde
 * referentie-copy — zelfde aanpak als spotlezz_werkwijze_vergelijking_
 * block(). Alleen de H2-titel is hier dynamisch op de pilaarnaam gezet
 * (i.p.v. altijd "kantoorreiniging" te tonen zoals de referentie doet),
 * dat is een verbetering t.o.v. de referentie, geen contentwijziging.
 *
 * Foto's: de eigen, al bevestigde foto's van déze pillar-post
 * (photo_1/2/3 — dezelfde drie die verderop ook "Eigen foto's" vullen),
 * dus geen nieuwe generieke foto's nodig.
 *
 * @param int    $post_id      De huidige pillar-post.
 * @param string $pillar_title De diensttitel (voor de dynamische H2's).
 */
function spotlezz_pillar_narrative_blocks( $post_id, $pillar_title ) {
	$photo_1 = spotlezz_field( 'photo_1', $post_id, null );
	$photo_2 = spotlezz_field( 'photo_2', $post_id, null );
	$photo_3 = spotlezz_field( 'photo_3', $post_id, null );

	$photo_1_url = is_array( $photo_1 ) ? ( $photo_1['url'] ?? '' ) : '';
	$photo_2_url = is_array( $photo_2 ) ? ( $photo_2['url'] ?? '' ) : '';
	$photo_3_url = is_array( $photo_3 ) ? ( $photo_3['url'] ?? '' ) : '';
	?>
	<?php if ( $photo_1_url ) : ?>
		<section class="ks-text-image">
			<div class="ks-ti-image">
				<img src="<?php echo esc_url( $photo_1_url ); ?>" alt="<?php echo esc_attr( spotlezz_image_alt( $photo_1, $pillar_title ) ); ?>" loading="lazy" decoding="async">
			</div>
			<div class="ks-ti-content">
				<h2><?php echo esc_html( $pillar_title ); ?></h2>
				<p><strong><?php esc_html_e( 'Een schone omgeving is een productieve omgeving.', 'spotlezz' ); ?></strong></p>
				<p><?php esc_html_e( 'Een schone werkplek is een productieve werkplek. Het is veel meer dan alleen een werkplek: een plek waar ideeën ontstaan, waar teams samenwerken en waar klanten een eerste indruk krijgen. Daarom is het niet zomaar een ruimte; het is een tweede thuis: fris, goed onderhouden en uitnodigend.', 'spotlezz' ); ?></p>
			</div>
		</section>
	<?php endif; ?>

	<section class="ks-importance">
		<div class="ks-importance-top">
			<h2><?php echo wp_kses_post( sprintf( /* translators: %s: dienstnaam */ __( 'Waarom is een goede %s zo belangrijk?', 'spotlezz' ), '<span class="text-blue">' . esc_html( $pillar_title ) . '</span>' ) ); ?></h2>
			<p><?php esc_html_e( 'Een schone omgeving biedt tal van voordelen. Uit onderzoek blijkt dat mensen productiever zijn en zich beter kunnen concentreren in een schone, goed onderhouden ruimte. Het draagt bij aan een vermindering van stress en ziekteverzuim, doordat bacteriën en allergenen structureel worden verwijderd.', 'spotlezz' ); ?></p>
		</div>
		<div class="ks-importance-boxes">
			<div class="ks-box">&#10003; <?php esc_html_e( '100% ecologische schoonmaak', 'spotlezz' ); ?></div>
			<div class="ks-box">&#10003; <?php esc_html_e( 'Vast en getraind personeel', 'spotlezz' ); ?></div>
			<div class="ks-box">&#10003; <?php esc_html_e( 'Altijd bereikbaar, 24/7 service', 'spotlezz' ); ?></div>
		</div>
	</section>

	<?php if ( $photo_2_url ) : ?>
		<section class="ks-text-image ks-reverse">
			<div class="ks-ti-image">
				<img src="<?php echo esc_url( $photo_2_url ); ?>" alt="<?php echo esc_attr( spotlezz_image_alt( $photo_2, __( 'Waarom Spotlezz', 'spotlezz' ) ) ); ?>" loading="lazy" decoding="async">
			</div>
			<div class="ks-ti-content">
				<h2><?php esc_html_e( 'Waarom Spotlezz?', 'spotlezz' ); ?></h2>
				<p><?php esc_html_e( 'We begrijpen dat de hygiëne van jouw bedrijf niet zomaar een taak is, maar een essentieel onderdeel van jouw uitstraling en werkcultuur. Bij Spotlezz gaan we verder dan oppervlakkig schoonmaken. Wij werken uitsluitend met milieuvriendelijke producten en navulverpakkingen om onze ecologische voetafdruk te minimaliseren.', 'spotlezz' ); ?></p>
				<ul class="ks-checklist">
					<li>&#10003; <?php esc_html_e( 'Altijd een persoonlijk schoonmaakplan op maat', 'spotlezz' ); ?></li>
					<li>&#10003; <?php esc_html_e( 'Oog voor detail en liefde voor ons vak', 'spotlezz' ); ?></li>
					<li>&#10003; <?php esc_html_e( 'Flexibel, geruisloos en efficiënt', 'spotlezz' ); ?></li>
				</ul>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( $photo_3_url ) : ?>
		<section class="ks-text-image">
			<div class="ks-ti-image">
				<img src="<?php echo esc_url( $photo_3_url ); ?>" alt="<?php echo esc_attr( spotlezz_image_alt( $photo_3, __( 'Schoonmaak details', 'spotlezz' ) ) ); ?>" loading="lazy" decoding="async">
			</div>
			<div class="ks-ti-content">
				<h2><?php esc_html_e( 'Het verschil zit in de details', 'spotlezz' ); ?></h2>
				<p><?php esc_html_e( 'Bij Spotlezz kijken we verder dan wat op het eerste gezicht zichtbaar is. Wij werken volgens strikte werkprogramma\'s en voeren regelmatig kwaliteitscontroles uit, zodat de hoge standaard altijd gewaarborgd blijft.', 'spotlezz' ); ?></p>
				<p><?php esc_html_e( 'We zorgen ervoor dat gedeelde faciliteiten, zoals toiletten en keukens, niet alleen schoon ogen, maar ook hygiënisch zijn. Van het bijvullen van dispensers tot het streeploos reinigen van glaswerk: wij nemen alles uit handen.', 'spotlezz' ); ?></p>
			</div>
		</section>
	<?php endif; ?>
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
