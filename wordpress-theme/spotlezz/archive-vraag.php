<?php
/**
 * FAQ-hub (/veelgestelde-vragen/) — WORDPRESS-BUILD-PLAN.md §3.5 /
 * PHASE-4C-PLAN.md §1.4 / §3, wireframe-3-faq-FINAL.html rij 2. Groepeert
 * alle gepubliceerde vragen per `thema`-term, met een client-side
 * zoekveld (assets/js/theme.js) en thema-pills als anker-navigatie.
 *
 * Schema: `FAQPage` op de hub (de detailpagina's krijgen `QAPage`, zie
 * single-vraag.php — dat onderscheid staat vast in het bouwplan).
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<div class="hub-page-header">
	<h1><?php esc_html_e( 'Veelgestelde vragen', 'spotlezz' ); ?></h1>

	<div class="faq-search">
		<label class="screen-reader-text" for="faqSearch"><?php esc_html_e( 'Zoek een vraag', 'spotlezz' ); ?></label>
		<input type="search" id="faqSearch" placeholder="<?php esc_attr_e( 'Zoek een vraag…', 'spotlezz' ); ?>">
	</div>

<?php
$themas = get_terms(
	array(
		'taxonomy'   => 'thema',
		'hide_empty' => true,
	)
);
if ( is_wp_error( $themas ) ) {
	$themas = array();
}
?>
<?php if ( ! empty( $themas ) ) : ?>
	<div class="faq-theme-pills">
		<a href="#" class="pill faq-theme-pill-all"><?php esc_html_e( 'Alles', 'spotlezz' ); ?></a>
		<?php foreach ( $themas as $thema ) : ?>
			<a href="#thema-<?php echo esc_attr( $thema->slug ); ?>" class="pill"><?php echo esc_html( $thema->name ); ?></a>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
</div>

<?php
$faq_schema_items = array();
$ongegroepeerd    = get_posts(
	array(
		'post_type'      => 'vraag',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'title',
		'order'          => 'ASC',
		'no_found_rows'  => true,
		'tax_query'      => array(
			array(
				'taxonomy' => 'thema',
				'operator' => 'NOT EXISTS',
			),
		),
	)
);
?>

<?php if ( ! empty( $themas ) ) : ?>
	<?php foreach ( $themas as $thema ) : ?>
		<?php
		$vragen = get_posts(
			array(
				'post_type'      => 'vraag',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'orderby'        => 'title',
				'order'          => 'ASC',
				'no_found_rows'  => true,
				'tax_query'      => array(
					array(
						'taxonomy' => 'thema',
						'field'    => 'term_id',
						'terms'    => $thema->term_id,
					),
				),
			)
		);
		if ( empty( $vragen ) ) {
			continue;
		}
		?>
		<section class="faq-theme-group" id="thema-<?php echo esc_attr( $thema->slug ); ?>">
			<h2><?php echo esc_html( $thema->name ); ?></h2>
			<div class="faq-list">
				<?php foreach ( $vragen as $vraag ) : ?>
					<?php
					$kort_antwoord = spotlezz_field( 'kort_antwoord', $vraag->ID, '' );
					$antwoord      = $kort_antwoord ? $kort_antwoord : get_the_excerpt( $vraag );
					$heeft_detail  = $kort_antwoord ? true : false;
					?>
					<details class="faq-item" data-search-text="<?php echo esc_attr( mb_strtolower( get_the_title( $vraag ) ) ); ?>">
						<summary>
							<span><?php echo esc_html( get_the_title( $vraag ) ); ?></span>
							<?php if ( $heeft_detail ) : ?>
								<i>&#8594; <?php esc_html_e( 'volledig antwoord', 'spotlezz' ); ?></i>
							<?php else : ?>
								<i>+</i>
							<?php endif; ?>
						</summary>
						<?php if ( $antwoord ) : ?>
							<p><?php echo esc_html( $antwoord ); ?></p>
						<?php endif; ?>
						<?php if ( $heeft_detail ) : ?>
							<a class="faq-item-link" href="<?php echo esc_url( get_permalink( $vraag ) ); ?>"><?php esc_html_e( 'Lees het volledige antwoord', 'spotlezz' ); ?></a>
						<?php endif; ?>
					</details>
					<?php
					if ( $antwoord ) {
						$faq_schema_items[] = array(
							'@type'          => 'Question',
							'name'           => wp_strip_all_tags( get_the_title( $vraag ) ),
							'acceptedAnswer' => array(
								'@type' => 'Answer',
								'text'  => wp_strip_all_tags( $antwoord ),
							),
						);
					}
					?>
				<?php endforeach; ?>
			</div>
		</section>
	<?php endforeach; ?>
<?php endif; ?>

<?php if ( ! empty( $ongegroepeerd ) ) : ?>
	<section class="faq-theme-group" id="thema-overig">
		<?php if ( ! empty( $themas ) ) : ?>
			<h2><?php esc_html_e( 'Overig', 'spotlezz' ); ?></h2>
		<?php endif; ?>
		<div class="faq-list">
			<?php foreach ( $ongegroepeerd as $vraag ) : ?>
				<?php
				$kort_antwoord = spotlezz_field( 'kort_antwoord', $vraag->ID, '' );
				$antwoord      = $kort_antwoord ? $kort_antwoord : get_the_excerpt( $vraag );
				$heeft_detail  = $kort_antwoord ? true : false;
				?>
				<details class="faq-item" data-search-text="<?php echo esc_attr( mb_strtolower( get_the_title( $vraag ) ) ); ?>">
					<summary>
						<span><?php echo esc_html( get_the_title( $vraag ) ); ?></span>
						<?php if ( $heeft_detail ) : ?>
							<i>&#8594; <?php esc_html_e( 'volledig antwoord', 'spotlezz' ); ?></i>
						<?php else : ?>
							<i>+</i>
						<?php endif; ?>
					</summary>
					<?php if ( $antwoord ) : ?>
						<p><?php echo esc_html( $antwoord ); ?></p>
					<?php endif; ?>
					<?php if ( $heeft_detail ) : ?>
						<a class="faq-item-link" href="<?php echo esc_url( get_permalink( $vraag ) ); ?>"><?php esc_html_e( 'Lees het volledige antwoord', 'spotlezz' ); ?></a>
					<?php endif; ?>
				</details>
				<?php
				if ( $antwoord ) {
					$faq_schema_items[] = array(
						'@type'          => 'Question',
						'name'           => wp_strip_all_tags( get_the_title( $vraag ) ),
						'acceptedAnswer' => array(
							'@type' => 'Answer',
							'text'  => wp_strip_all_tags( $antwoord ),
						),
					);
				}
				?>
			<?php endforeach; ?>
		</div>
	</section>
<?php endif; ?>

<?php if ( empty( $themas ) && empty( $ongegroepeerd ) && current_user_can( 'edit_theme_options' ) ) : ?>
	<p class="placeholder-note content-placeholder"><?php esc_html_e( 'Nog geen vragen gepubliceerd.', 'spotlezz' ); ?></p>
<?php endif; ?>

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

spotlezz_next_hop(
	array(
		array(
			'label' => __( 'Omhoog', 'spotlezz' ),
			'title' => __( 'Naar de homepage', 'spotlezz' ),
			'url'   => home_url( '/' ),
		),
		array(
			'label' => __( 'Zijwaarts', 'spotlezz' ),
			'title' => __( 'Bekijk onze diensten', 'spotlezz' ),
			'url'   => get_post_type_archive_link( 'pillar' ) ?: home_url( '/diensten/' ),
		),
		array(
			'label' => __( 'Conversie', 'spotlezz' ),
			'title' => __( 'Offerte op maat aanvragen', 'spotlezz' ),
			'url'   => home_url( '/offerte-aanvragen/' ),
		),
	)
);

get_footer();
