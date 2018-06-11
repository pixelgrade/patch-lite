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
		$wp_customize->get_section('title_tagline')->title = '&#x1f465; ' . esc_html__('Site Identity', 'patch-lite');

		// View Pro
		$wp_customize->add_section( 'patchlite_style_view_pro', array(
			'title'       => '' . esc_html__( 'View PRO Version', 'patch-lite' ),
			'priority'    => 2,
			'description' => sprintf(
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
                            	<div class="description">Make room for a wide range of post formats to pack your engaging stories so that people will enjoy sharing. Text, image, video, audio—you name it, and you’re covered.</div>
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

		$wp_customize->add_setting( 'patchlite_style_view_pro_desc', array(
			'default'           => '',
			'sanitize_callback' => 'patch_lite_sanitize_checkbox',
		) );
		$wp_customize->add_control( 'patchlite_style_view_pro_desc', array(
			'section' => 'patchlite_style_view_pro',
			'type'    => 'hidden',
		) );


		// Style Presets
		$wp_customize->add_section( 'patchlite_style_presets', array(
			'title'       => '&#x1f3ad; ' . esc_html__( 'Style Presets', 'patch-lite' ),
			'priority'    => 29,
			'description' => sprintf(
				__( '<p>%s provides you hand-crafted style presets so that you never go out of trends and add some real value to the full package. You can instantly achieve a different visual approach and level up the users interest. </p><p> Our designer did his best to carefully match the colors and fonts so that you can easily refresh the overall style of your website.</p>', 'patch-lite' ),
				sprintf( '<a href="%1$s" target="_blank">%2$s</a>', esc_url( patch_lite_get_pro_link() ), esc_html__( 'Patch Pro', 'patch-lite' ) )
			)
		) );

		$wp_customize->add_setting( 'patchlite_style_presets_desc', array(
			'default'           => '',
			'sanitize_callback' => 'patch_lite_sanitize_checkbox',
		) );
		$wp_customize->add_control( 'patchlite_style_presets_desc', array(
			'section' => 'patchlite_style_presets',
			'type'    => 'hidden',
		) );


		// Colors
		$wp_customize->add_section( 'patchlite_colors', array(
			'title'       => '&#x1f3a8; ' . esc_html__( 'Colors', 'patch-lite' ),
			'priority'    => 30,
			'description' => sprintf(
				__( '<p>Play around with colors that fits your vision, your mood or both of them. You can smoothly make a design twist to quickly catch your wide preferences.</p><p>%s to switch colors and fonts in order to nurture your visual approach.</p>', 'patch-lite' ),
				sprintf( '<a href="%1$s" target="_blank">%2$s</a>', esc_url( patch_lite_get_pro_link() ), esc_html__( 'Upgrade to Patch Pro', 'patch-lite' )
				)
			)
		) );

		$wp_customize->add_setting( 'patchlite_colors_desc', array(
			'default'           => '',
			'sanitize_callback' => 'patch_lite_sanitize_checkbox',
		) );
		$wp_customize->add_control( 'patchlite_colors_desc', array(
			'section' => 'patchlite_colors',
			'type'    => 'hidden',
		) );

		// Fonts
		$wp_customize->add_section( 'patchlite_fonts', array(
			'title'       => '&#x1f4dd; ' . esc_html__( 'Fonts', 'patch-lite' ),
			'priority'    => 31,
			'description' => sprintf(
				__( '<p>Typography can make it or break it. %s gives you a generous playground to match your needs in terms of fonts and sizes.</p><p>You have full-access to 600+ Google Fonts to mingle with for fine-tuning your style.', 'patch-lite' ),
				sprintf( '<a href="%1$s" target="_blank">%2$s</a>', esc_url( patch_lite_get_pro_link() ), esc_html__( 'Patch Pro', 'patch-lite' )
				)
			)
		) );


		$wp_customize->add_setting( 'patchlite_fonts_desc', array(
			'default'           => '',
			'sanitize_callback' => 'patch_lite_sanitize_checkbox',
		) );
		$wp_customize->add_control( 'patch_lite_fonts_desc', array(
			'section' => 'patchlite_fonts',
			'type'    => 'hidden',
		) );

	}

	add_action( 'customize_register', 'patch_lite_customize_register', 15 );

	/**
	 * Sanitize the checkbox.
	 *
	 * @param boolean $input .
	 *
	 * @return boolean true if is 1 or '1', false if anything else
	 */
	function patch_lite_sanitize_checkbox( $input ) {
		if ( 1 == $input ) {
			return true;
		} else {
			return false;
		}
	}

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
	 * JavaScript that handles the Customizer AJAX logic
	 * This will be added in the preview part
	 */
	function patch_lite_customizer_preview_assets() {
		wp_enqueue_script( 'patchlite_customizer_preview', get_template_directory_uri() . '/assets/js/customizer_preview.js', array( 'customize-preview' ), '1.0.4', true );
	}

	add_action( 'customize_preview_init', 'patch_lite_customizer_preview_assets' );

	/**
	 * Assets that will be loaded for the customizer sidebar
	 */
	function patch_lite_customizer_assets() {
		wp_enqueue_style( 'patchlite-customizer-style', get_template_directory_uri() . '/assets/css/admin/customizer.css', null, '1.0.4', false );

		wp_enqueue_script( 'patchlite-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'jquery' ), '1.0.4', false );

		// uncomment this to put back your dismiss notice
		// update_user_meta( get_current_user_id(), 'patchlite_upgrade_dismissed_notice', 0 );
		if ( isset( $_GET['patchlite-upgrade-dismiss'] ) && check_admin_referer( 'patchlite-upgrade-dismiss-' . get_current_user_id() ) ) {
			update_user_meta( get_current_user_id(), 'patchlite_upgrade_dismissed_notice', 'forever' );
			return;
		}

		$dismiss_user = get_user_meta( get_current_user_id(), 'patchlite_upgrade_dismissed_notice', true );
		if ( $dismiss_user === 'forever' ) {
			return;
		} elseif ( empty( $dismiss_user ) || ( is_numeric( $dismiss_user ) && $dismiss_user < 2  ) ) {

			$value = $dismiss_user + 1;
			update_user_meta( get_current_user_id(), 'patchlite_upgrade_dismissed_notice', $value );
			return;
		}

		$localized_strings = array(
			'upsell_link'     => patch_lite_get_pro_link(),
			'upsell_label'    => esc_html__( 'Upgrade to Patch Pro', 'patch-lite' ),
			'pro_badge_label' => esc_html__( 'Pro', 'patch-lite' ) . '<span class="star"></span>',
			'dismiss_link' => esc_url( wp_nonce_url( add_query_arg( 'patchlite-upgrade-dismiss', 'forever' ), 'patchlite-upgrade-dismiss-' . get_current_user_id() ) )
		);

		wp_localize_script( 'patchlite_customizer', 'patchliteCustomizerObject', $localized_strings );
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
		$config['panels'] = array();

		return $config;
	}
	add_filter( 'customify_filter_fields', 'patch_lite_add_customify_options' );
?>