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
		<?php pixelgrade_footer_the_copyright(); ?><!-- .site-info
		--><div class="back-to-top-wrapper">
			<a href="#top" class="back-to-top-button"><?php get_template_part( 'assets/svg/back-to-top' ); ?></a>
		</div><!--
		--><?php
		wp_nav_menu( array(
			'theme_location' => 'footer',
			'container'      => '',
			'menu_class'     => 'nav  nav--footer',
			'items_wrap'         => '<nav class="footer-menu"><h5 class="screen-reader-text">'.__( 'Footer navigation', 'patch' ).'</h5><ul id="%1$s" class="%2$s">%3$s</ul></nav>',
			'depth'          => 1,
			'fallback_cb'    => '',
		) ); ?>
	</footer><!-- #colophon -->
	<div class="overlay--search">
		<div class="overlay__wrapper">
			<?php get_search_form(); ?>
			<p><?php _e( 'Begin typing your search above and press return to search. Press Esc to cancel.', 'patch' ); ?></p>
		</div>
		<b class="overlay__close"></b>
	</div>
</div><!-- #page -->

<div class="mobile-header">
	<div class="mobile-header-wrapper">
		<button class="navigation__trigger  js-nav-trigger">
			<i class="fa fa-bars"></i><span class="screen-reader-text"><?php _e( 'Menu', 'patch' ); ?></span>
		</button>
		<button class="nav__item--search  search__trigger">
			<i class="fa fa-search"></i>
		</button>
	</div>
</div>

<?php wp_footer(); ?>

</body>
</html>