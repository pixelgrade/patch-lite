<?php
/**
 * The default template for displaying individual posts on archives
 *
 * @package Patch Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<div class="grid__item">

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<div class="entry-meta"><?php patch_lite_card_meta(); ?></div><!-- .entry-meta -->

		<?php if ( has_post_thumbnail() ) : ?>

			<a href="<?php the_permalink(); ?>" <?php patch_lite_post_thumbnail_class( 'entry-image' ); ?>>

				<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
					<span class="sticky-post"></span>
				<?php endif; ?>

				<span class="hover" role="presentation"><?php esc_html_e( 'Read More', 'patch-lite' ); ?></span>
				<div class="entry-image-wrapper">
					<?php the_post_thumbnail( 'patch-masonry-image' ); ?>
				</div>
			</a>

		<?php endif; ?>

		<?php
		//just in case there is no title, no need for the <header>
		$temp_title = get_the_title();

		if ( ! empty( $temp_title ) ) : ?>

		<header <?php patch_lite_post_title_class(); ?>>

			<?php if ( is_sticky() && ! has_post_thumbnail() && is_home() && ! is_paged() ) : ?>
				<span class="sticky-post"></span>
			<?php endif; ?>

			<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

		</header><!-- .entry-header -->

		<?php endif; ?>

		<div <?php patch_lite_post_excerpt_class(); ?>>

			<?php patch_lite_post_excerpt();

			wp_link_pages( array(
				'before' => '<div class="page-links"><span class="pagination-title">' . esc_html__( 'Pages:', 'patch-lite' ),
				'after'  => '</span></div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'patch-lite' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) ); ?>

			<?php patch_lite_entry_footer(); ?>

		</div><!-- .entry-content -->

	</article><!-- #post-## -->

</div><!-- .grid__item -->
