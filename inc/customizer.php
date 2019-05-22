<?php
/**
 * Patch Lite Theme Customizer
 * @package Patch Lite
 */


/**
 * Change some default texts and add our own custom settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function patch_lite_customize_register( $wp_customize ) {

	/*
	 * Change defaults
	 */

	// Add postMessage support for site title and tagline and title color.
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	// Rename the label to "Display Site Title & Tagline" in order to make this option clearer.
	$wp_customize->get_control( 'display_header_text' )->label = esc_html__( 'Display Site Title &amp; Tagline', 'patch-lite' );

	// Add a pretty icon to Site Identity
	$wp_customize->get_section( 'title_tagline' )->title = '&#x1f465; ' . esc_html__( 'Site Identity', 'patch-lite' );

	// View Pro
	$wp_customize->add_section( 'pro__section', array(
		'title'       => '' . esc_html__( 'View PRO Version', 'patch-lite' ),
		'priority'    => 2,
		'description' => sprintf(
			/* translators: %s: The theme pro link. */
			__( '<div class="upsell-container">
					<h2>Need More? Go PRO</h2>
					<p>Take it to the next level. See the features below:</p>
					<ul class="upsell-features">
                            <li>
                            	<h4>Personalize to Match Your Style</h4>
                            	<div class="description">Having different tastes and preferences might be tricky for users, but not with Patch onboard. It has an intuitive and catchy interface which allows you to change <strong>fonts, colors or layout sizes</strong> in a blink of an eye.</div>
                            </li>

                            <li>
                            	<h4>Post Formats</h4>
                            	<div class="description">Make room for a wide range of post formats to pack your engaging stories so that people will enjoy sharing. Text, image, video, audio—you name it, and you\'re covered.</div>
                            </li>

                            <li>
                            	<h4>Adaptive Layouts For Your Posts</h4>
                            	<div class="description">Whether your featured image is in portrait or landscape mode, Patch takes care of it by changing the post layout to provide the right fit.</div>
                            </li>

                            <li>
                            	<h4>Premium Customer Support</h4>
                            	<div class="description">You will benefit by priority support from a caring and devoted team, eager to help and to spread happiness. We work hard to provide a flawless experience for those who vote us with trust and choose to be our special clients.</div>
                            </li>
                            
                    </ul> %s </div>', 'patch-lite' ),
			sprintf( '<a href="%1$s" target="_blank" class="button button-primary">%2$s</a>', esc_url( patch_lite_get_pro_link() ), esc_html__( 'View Patch PRO', 'patch-lite' ) )
		),
	) );

	$wp_customize->add_setting( 'patch_lite_style_view_pro_desc', array(
		'default'           => '',
		'sanitize_callback' => '__return_true',
	) );
	$wp_customize->add_control( 'patch_lite_style_view_pro_desc', array(
		'section' => 'pro__section',
		'type'    => 'hidden',
	) );
}
add_action( 'customize_register', 'patch_lite_customize_register', 15 );

/**
 * Sanitize the Site Title Outline value.
 *
 * @param string $outline Outline thickness.
 *
 * @return string Filtered outline (0|1|2|3).
 */
function patch_lite_sanitize_site_title_outline( $outline ) {
	if ( ! in_array( $outline, array( '0', '1.2', '3', '5', '10' ) ) ) {
		$outline = '3';
	}

	return $outline;
}

/**
 * Assets that will be loaded for the customizer sidebar
 */
function patch_lite_customizer_assets() {
	wp_enqueue_style( 'patch_lite-customizer-style', get_template_directory_uri() . '/inc/admin/css/customizer.css', null, '1.1.1', false );

	wp_enqueue_script( 'patch_lite-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'jquery' ), '1.1.1', false );
}
add_action( 'customize_controls_enqueue_scripts', 'patch_lite_customizer_assets' );

/**
 * Generate a link to the Patch Lite info page.
 */
function patch_lite_get_pro_link() {
	return 'https://pixelgrade.com/themes/blogging/patch-lite?utm_source=patch-lite-clients&utm_medium=customizer&utm_campaign=patch-lite#pro';
}

function patch_lite_add_customify_options( $config ) {

	$config['sections'] = array();
	$config['panels']   = array();

	return $config;
}
add_filter( 'customify_filter_fields', 'patch_lite_add_customify_options' );
