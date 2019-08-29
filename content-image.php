<?php
/**
 * The template for displaying the image post format on archives.
 *
 * @package Patch Lite
 * @since Patch Lite 1.1.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<div class="grid__item">

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<div class="entry-meta"><?php patch_lite_card_meta(); ?></div><!-- .entry-meta -->

		<?php if ( has_post_thumbnail() ) : ?>

			<a class="entry-image entry-image--landscape" href="<?php the_permalink(); ?>">

				<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
					<span class="sticky-post"></span>
				<?php endif; ?>

				<div class="entry-image-wrapper">
				<?php the_post_thumbnail( 'patch-masonry-image' ); ?>
				</div>

			</a>

		<?php  else : // we need to search in the content for an image - maybe we find one
			$first_image = patch_lite_get_post_format_first_image();

			if ( ! empty( $first_image ) ) :

				//we need to determine if this is a linked image
				$linked = ( false === strpos( $first_image, '</a>' ) ) ? false : true ;

				if ( $linked ) : ?>

					<div class="entry-image entry-image--landscape">

						<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
							<span class="sticky-post"></span>
						<?php endif; ?>

						<div class="entry-image-wrapper">
						<?php echo $first_image; ?>
						</div>

					</div>

				<?php else : ?>

					<a class="entry-image entry-image--landscape" href="<?php the_permalink(); ?>">

						<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
							<span class="sticky-post"></span>
						<?php endif; ?>

						<div class="entry-image-wrapper">
						<?php echo $first_image; ?>
						</div>

					</a>

			<?php endif;
			endif;
		endif; ?>

		<header <?php patch_lite_post_title_class(); ?>>

			<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

		</header><!-- .entry-header -->

		<footer class="entry-footer">

			<?php patch_lite_entry_footer(); ?>

		</footer><!-- .entry-footer -->

	</article><!-- #post-## -->

</div><!-- .grid__item -->
