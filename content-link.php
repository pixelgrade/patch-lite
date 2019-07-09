<?php
/**
 * The template for displaying the link post format on archives.
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

			<a href="<?php patch_lite_get_post_format_link_url(); ?>" <?php patch_lite_post_thumbnail_class( 'entry-image' ); ?>>

				<?php the_post_thumbnail( 'patch-masonry-image' ); ?>

			</a>

		<?php else : ?>

			<header <?php patch_lite_post_title_class(); ?>>

				<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark"><span class="link__text">', esc_url( patch_lite_get_post_format_link_url() ) ), '</span>&nbsp;<i class="link__icon  fa fa-external-link"></i></a></h1>' ); ?>

			</header><!-- .entry-header -->

		<?php endif; ?>

		<footer class="entry-footer">

			<?php patch_entry_footer(); ?>

		</footer><!-- .entry-footer -->

	</article><!-- #post-## -->

</div><!-- .grid__item -->
