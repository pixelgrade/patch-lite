<?php
/**
 * The template for displaying single video post format posts.
 *
 * @package Patch Lite
 * @since Patch Lite 1.1.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

//get the media objects from the content and bring up only the first one
$media   = patch_lite_video_attachment(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<div class="entry-meta">

			<?php patch_lite_cats_list(); ?>

			<?php patch_lite_post_format_link(); ?>

			<div class="clearfix">

				<?php patch_lite_posted_on(); ?>

			</div>

		</div><!-- .entry-meta -->

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

	</header><!-- .entry-header -->

	<?php if ( ! empty( $media ) ) : ?>

		<div class="entry-featured entry-media">

			<?php echo $media; ?>

		</div><!-- .entry-media -->

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

		<?php patch_lite_single_entry_footer(); ?>

	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
