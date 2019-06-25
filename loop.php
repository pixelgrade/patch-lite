<?php
/**
 * The template for displaying the archives loop content.
 *
 * @package Patch Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<div id="posts" <?php patch_lite_blog_class( '' ); ?>>

	<?php
	get_template_part( 'content', 'header' );

	patch_lite_the_secondary_page_title();

	/* Start the Loop */
	while ( have_posts() ) : the_post();

		/* Include the Post-Format-specific template for the content.
		 * If you want to override this in a child theme, then include a file
		 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
		 */
		get_template_part( 'content', get_post_format() );

	endwhile; ?>

</div><!-- .archive__grid -->
