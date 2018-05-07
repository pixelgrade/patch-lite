<?php
/**
 * Patch Theme Customizer
 *
 * @package Patch
 * @since Patch 1.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function patch_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	// Rename the label to "Display Site Title & Tagline" in order to make this option clearer.
	$wp_customize->get_control( 'display_header_text' )->label = __( 'Display Site Title &amp; Tagline', 'patch' );

	$wp_customize->add_section( 'title_tagline' , array(
		'title'		=> __( 'Site Title &amp; Logo', 'patch' ),
		'priority'	=> 20,
	));

	$wp_customize->get_control( 'blogname' )->priority = 1;
	$wp_customize->get_control( 'blogdescription' )->priority = 1;
	$wp_customize->get_control( 'header_text' )->priority = 1;
	$wp_customize->get_control( 'custom_logo' )->description = __('Upload a logo image to replace the Site Title and personalize it with your branding. Use the Header section to adjust its size.', 'patch');


	/*
	 * Add custom settings
	 */

	$wp_customize->add_section( 'patch_theme_options', array(
		'title'             => __( 'Theme', 'patch' ),
		'priority'          => 30,
	) );

	$wp_customize->add_setting( 'patch_hide_author_bio', array(
		'default'           => '',
		'sanitize_callback' => 'patch_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'patch_hide_author_bio', array(
		'label'             => __( 'Hide the author bio on single posts.', 'patch' ),
		'section'           => 'patch_theme_options',
		'type'              => 'checkbox',
	) );

	$wp_customize->add_control( 'patch_footer_copyright', array(
		'label'             => __( 'Additional Copyright Text', 'patch' ),
		'description' => '',
		'section'           => 'patch_theme_options',
		'type'              => 'text',
	) );

}

add_action( 'customize_register', 'patch_customize_register' );

/**
 * Sanitize the checkbox.
 *
 * @param boolean $input.
 * @return boolean true if is 1 or '1', false if anything else
 */
function patch_sanitize_checkbox( $input ) {
	if ( 1 == $input ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function patch_customize_preview_js() {
	wp_enqueue_script( 'patch_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20180101', true );
}

add_action( 'customize_preview_init', 'patch_customize_preview_js' );
