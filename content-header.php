<?php
/**
 * The template for displaying the header area (logo, site title, tagline, primary menu and social menu
 *
 * @package Patch
 * @since Patch 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php if ( ! is_singular() && ! is_404() && have_posts() ) { echo '<div class="grid__item">'; } ?>

<header id="masthead" class="site-header" role="banner">
	<div class="site-branding">

		<?php if ( function_exists( 'jetpack_the_site_logo' ) ) { // display the Site Logo if present
			jetpack_the_site_logo();
		} else {
			the_custom_logo();
		} ?>

		<?php
		// on the front page and home page we use H1 for the title
		echo ( is_front_page() && is_home() ) ? '<h1 class="site-title">' : '<div class="site-title">'; ?>

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<?php bloginfo( 'name' ); ?>
		</a>

		<?php echo ( is_front_page() && is_home() ) ? '</h1>' : '</div>'; ?>

		<?php
		$description = get_bloginfo( 'description', 'display' );
		if ( $description || is_customize_preview() ) : ?>

			<div class="site-description">
				<span class="site-description-text"><?php bloginfo( 'description' ); ?></span>
			</div>

		<?php endif; ?>

	</div><!-- .site-branding -->

	<nav id="site-navigation" class="main-navigation" role="navigation">

		<?php
		//the primary menu
		wp_nav_menu( array(
			'theme_location' => 'primary',
			'container'      => '',
			'menu_class'     => 'nav nav--main',
			'fallback_cb' => false,
		) ); ?>

	</nav><!-- #site-navigation -->

</header><!-- #masthead -->

<?php
if ( ! is_singular() && ! is_404() && have_posts() ) { echo '</div>'; }
