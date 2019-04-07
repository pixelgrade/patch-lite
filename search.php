<?php
/**
 * The template for displaying search results pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Patch
 * @since Patch 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>

	<?php if ( have_posts() ) : ?>

		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

				<?php get_template_part( 'loop' ); ?>

				<?php patch_paging_nav(); ?>

			</main><!-- #main -->
		</div><!-- #primary -->

	<?php else : ?>

		<?php get_template_part( 'content', 'none' ); ?>

	<?php endif; ?>

<?php get_footer();
