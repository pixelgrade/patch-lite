<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Patch Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_template_part( 'content', 'header' ); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<section class="no-results not-found">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'patch-lite' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content">

				<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

					<p><?php
						/* translators: %s: The new post URL. */
						printf( wp_kses_post( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'patch-lite' ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

				<?php elseif ( is_search() ) : ?>

					<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'patch-lite' ); ?></p>
					<?php get_search_form(); ?>

				<?php else : ?>

					<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'patch-lite' ); ?></p>
					<?php get_search_form(); ?>

				<?php endif; ?>

			</div><!-- .page-content -->
		</section><!-- .no-results -->

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar();
