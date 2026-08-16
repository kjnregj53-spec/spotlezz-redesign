<?php
/**
 * Fallback voor het standaard 'post' post type (blog). De blog staat
 * bewust buiten de hoofdstructuur (zie STATUS.md / WIREFRAME-AUDIT), dit
 * template bestaat alleen zodat een directe blogpost-URL niet op een
 * onbeheerde fallback terechtkomt.
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
