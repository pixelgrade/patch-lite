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
	require_once 'pixcare-notice/class-notice.php'; // phpcs:ignore
	PatchLite_PixelgradeCare_DownloadNotice::init();
}
add_action('after_setup_theme', 'patch_lite_admin_setup' );
