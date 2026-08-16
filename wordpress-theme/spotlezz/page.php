<?php
/**
 * Generieke pagina-template: over-ons, contact, offerte-aanvragen,
 * privacybeleid, checklist, vacatures. Content-invulling per pagina volgt
 * in een latere fase; dit is de structurele schaal.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="content-wrap">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<h1><?php the_title(); ?></h1>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</article>
		<?php
	endwhile;
	?>
</div>

<?php get_footer(); ?>
