<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Patch
 * @since Patch 1.0
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function patch_jetpack_setup() {
	/**
	 * Add theme support for Infinite Scroll
	 * See: http://jetpack.me/support/infinite-scroll/
	 */
	add_theme_support( 'infinite-scroll', array(
		'type'           => 'scroll',
		'container'      => 'posts',
		'wrapper'        => false,
		'footer'         => 'page',
	) );

	/**
	 * Add theme support for Jetpack responsive videos
	 */
	add_theme_support( 'jetpack-responsive-videos' );
}
add_action( 'after_setup_theme', 'patch_jetpack_setup' );

/**
 * Detect if the footer menu is active and if it is
 * switch Infinite Scroll to click mode
 */
function patch_switch_infinite_scroll_mode() {

	if ( has_nav_menu( 'footer' ) ) {
		return true;
	} else {
		return false;
	}
}
add_filter( 'infinite_scroll_has_footer_widgets', 'patch_switch_infinite_scroll_mode' );

function patch_jetpack_responsive_videos_should_wrap_videopress_also( $video_patterns ) {
	$video_patterns[] = 'https?://(.+\.)?videopress\.com/';

	return $video_patterns;
}
add_filter ( 'jetpack_responsive_videos_oembed_videos', 'patch_jetpack_responsive_videos_should_wrap_videopress_also');
