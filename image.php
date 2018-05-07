<?php
/**
 * The template for displaying image attachments
 *
 * @package Patch
 * @since Patch 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $content_width;
//set the $content_width here as recommended by the VIP scanner
$content_width = 620; /* pixels */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'attachment' ); ?>

			<?php patch_the_image_navigation(); ?>

			<div class="entry-content">
				<nav class="nav-links">
					<a href="<?php echo esc_url( get_permalink( wp_get_post_parent_id( get_the_ID() ) ) ); ?>">
						<?php echo sprintf( _x( 'Posted in %s', 'attachment parent post', 'patch' ), get_the_title( wp_get_post_parent_id( get_the_ID() ) ) ); ?>
					</a>
				</nav>
			</div>

			<?php
			// If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif; ?>

		<?php endwhile; // End the loop. ?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php
get_sidebar();
get_footer();
