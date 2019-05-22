<?php
/**
 * The template for displaying the post content on single post view
 *
 * @package Patch Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

//get the post thumbnail aspect ratio specific class
if ( has_post_thumbnail() ) {
	$ar_class = patch_lite_get_post_thumbnail_aspect_ratio_class();
} ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( has_post_thumbnail() && ( 'tall' == $ar_class || 'portrait' == $ar_class ) ) : ?>

		<div class="entry-featured  entry-thumbnail">

			<?php the_post_thumbnail( 'patch-single-image' ); ?>

		</div>

	<?php endif; ?>

	<header class="entry-header">
		<div class="entry-meta">

			<?php patch_lite_cats_list(); ?>

			<div class="clearfix">

				<?php patch_lite_posted_on(); ?>

			</div>

		</div><!-- .entry-meta -->

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

	</header><!-- .entry-header -->

	<?php if ( has_post_thumbnail() && ! ( 'tall' == $ar_class || 'portrait' == $ar_class ) ) : ?>

		<div class="entry-featured  entry-thumbnail">

			<?php the_post_thumbnail( 'patch-single-image' ); ?>

		</div>

	<?php endif; ?>

	<div class="entry-content">

		<?php the_content(); ?>

		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'patch-lite' ),
			'after'  => '</div>',
		) ); ?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php patch_single_entry_footer(); ?>

	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
