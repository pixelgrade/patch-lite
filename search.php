<?php
/**
 * The template for displaying search results pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Patch Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header();

if ( have_posts() ) { ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			get_template_part( 'loop' );

			patch_lite_paging_nav(); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php } else {
	get_template_part( 'content', 'none' );
}

get_footer();
