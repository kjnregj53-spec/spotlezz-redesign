<?php
/**
 * Fallback-template. Vangt elke request op die geen specifieker sjabloon
 * heeft in de template hierarchy.
 *
 * @package Spotlezz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="content-wrap">
	<?php if ( have_posts() ) : ?>
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
	<?php else : ?>
		<p><?php esc_html_e( 'Geen content gevonden.', 'spotlezz' ); ?></p>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
