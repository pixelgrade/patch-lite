<?php
/**
 * The template for displaying the archives loop content.
 *
 * @package Patch
 * @since Patch 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<div id="posts" <?php patch_blog_class( '' ); ?>>

	<?php get_template_part( 'content', 'header' ); ?>

	<?php patch_the_secondary_page_title(); ?>

	<?php
	/* Start the Loop */
	while ( have_posts() ) : the_post(); ?>

		<?php
			/* Include the Post-Format-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
			 */
		get_template_part( 'content', get_post_format() ); ?>

	<?php endwhile; ?>

</div><!-- .archive__grid -->