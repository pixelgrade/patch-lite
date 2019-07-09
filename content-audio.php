<?php
/**
 * The template for displaying the audio post format on archives.
 *
 * @package Patch Lite
 * @since Patch Lite 1.1.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

//get the media objects from the content and bring up only the first one
$media   = patch_lite_audio_attachment();
?>

<div class="grid__item">

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<div class="entry-meta"><?php patch_lite_card_meta(); ?></div><!-- .entry-meta -->

		<?php if ( ! empty( $media ) ) : ?>

			<div class="entry-media entry-image entry-image--landscape">

				<?php echo $media; ?>

			</div><!-- .entry-media -->

		<?php endif; ?>

		<header <?php patch_lite_post_title_class(); ?>>

			<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

		</header><!-- .entry-header -->

		<div <?php patch_lite_post_excerpt_class(); ?>>

			<?php if ( true === pixelgrade_option( 'blog_items_excerpt_visibility' ) ) {
				the_excerpt();
			}

			wp_link_pages( array(
				'before' => '<div class="page-links"><span class="pagination-title">' . esc_html__( 'Pages:', 'patch' ),
				'after'  => '</span></div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'patch' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) ); ?>

		</div><!-- .entry-content -->

		<footer class="entry-footer">

			<?php patch_entry_footer(); ?>

		</footer><!-- .entry-footer -->

	</article><!-- #post-## -->

</div><!-- .grid__item -->
