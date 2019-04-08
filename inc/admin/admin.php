<?php
/**
 * Patch Lite Theme admin logic.
 *
 * @package Patch Lite
 */

function patch_lite_admin_setup() {

	/**
	 * Load and initialize Pixelgrade Care notice logic.
	 */
	require_once 'pixcare-notice/class-notice.php';
	PixelgradeCare_Install_Notice::init();
}
add_action('after_setup_theme', 'patch_lite_admin_setup' );

function patch_lite_admin_assets() {
	wp_enqueue_style( 'patchlite_admin_style', get_template_directory_uri() . '/inc/admin/css/admin.css', null, '1.1.1', false );
}
add_action( 'admin_enqueue_scripts', 'patch_lite_admin_assets' );
