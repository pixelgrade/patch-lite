<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Patch
 * @since Patch 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
		</div><!-- .container -->
	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php pixelgrade_footer_the_copyright(); ?>
	</footer><!-- #colophon -->
</div><!-- #page -->

<div class="mobile-header">
	<div class="mobile-header-wrapper">
		<button class="navigation__trigger  js-nav-trigger">
			<i class="fa fa-bars"></i><span class="screen-reader-text"><?php _e( 'Menu', 'patch-lite' ); ?></span>
		</button>
		<button class="nav__item--search  search__trigger">
			<i class="fa fa-search"></i>
		</button>
	</div>
</div>

<?php wp_footer(); ?>

</body>
</html>