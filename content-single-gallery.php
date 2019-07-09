<?php
/**
 * The template for displaying single gallery post format posts.
 *
 * @package Patch Lite
 * @since Patch Lite 1.1.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

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

	<?php
	//output the first gallery in the content - if it exists
	$gallery = get_post_gallery();

	if ( $gallery ) : ?>

		<div class="entry-featured  entry-gallery">

			<?php echo $gallery; ?>

		</div><!-- .entry-gallery -->

	<?php endif; ?>

	<div class="entry-content">

		<?php the_content(); ?>

		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'patch' ),
			'after'  => '</div>',
		) ); ?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php patch_single_entry_footer(); ?>

	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
