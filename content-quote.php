<?php
/**
 * The template for displaying the quote post format on archives.
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

		<?php
		//let's see if we have a featured image
		$post_thumbnail_style = '';
		if ( has_post_thumbnail() ) {
			$post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'patch-single-image' );
			if ( isset( $post_thumbnail[0] ) ) {
				$post_thumbnail_style = 'style="background-image: url(' . esc_url( $post_thumbnail[0] ) . ');"';
			}
		} ?>

		<div class="entry-content" <?php echo $post_thumbnail_style; ?> >

			<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
				<span class="sticky-post"></span>
			<?php endif; ?>

			<?php

			/* translators: %s: Name of current post */
			$content = get_the_content(
				sprintf(
					wp_kses(
						__( 'Continue reading %s', 'patch' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					the_title( '<span class="screen-reader-text">', '</span>', false )
				)
			);

			//now we need to test for the length of the quote so we can decide on a class
			$quote_length = mb_strlen( strip_tags( $content ) );
			$quote_class = 'entry-quote--long';
			if ( $quote_length < 50 ) {
				$quote_class = 'entry-quote--short';
			} ?>

			<div class="content-quote <?php echo esc_attr( $quote_class ); ?>">
				<div class="flexbox">
					<div class="flexbox__item">

						<?php
						//test if there is a </blockquote> tag in here
						if ( false !== strpos( $content,'</blockquote>' ) ) {
							echo $content;
						} else {
							//we will wrap the whole content in blockquote since this is definitely intended as a quote
							echo '<blockquote>' . $content . '</blockquote>';
						} ?>

					</div>
				</div>
			</div>

		</div><!-- .entry-content -->

	</article><!-- #post-## -->

</div><!-- .grid__item -->
