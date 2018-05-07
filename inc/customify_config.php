<?php
/**
 * Add extra controls in the Customizer
 *
 * @package Patch
 */

/**
 * Hook into the Customify's fields and settings.
 *
 * The config can turn to be complex so is best to visit:
 * https://github.com/pixelgrade/customify
 *
 * @param array $options Contains the plugin's options array right before they are used, so edit with care
 *
 * @return array The returned options are required, if you don't need options return an empty array
 */
add_filter( 'customify_filter_fields', 'patch_add_customify_options', 11, 1 );
add_filter( 'customify_filter_fields', 'pixelgrade_add_customify_style_manager_section', 12, 1 );

add_filter( 'customify_filter_fields', 'patch_modify_customify_options', 20 );

function patch_add_customify_options( $options ) {
	$options['opt-name'] = 'patch_options';

	//start with a clean slate - no Customify default sections
	$options['sections'] = array();

	return $options;
}

/**
 * Add the Style Manager cross-theme Customizer section.
 *
 * @param array $options
 *
 * @return array
 */
function pixelgrade_add_customify_style_manager_section( $options ) {
	// If the theme hasn't declared support for style manager, bail.
	if ( ! current_theme_supports( 'customizer_style_manager' ) ) {
		return $options;
	}

	if ( ! isset( $options['sections']['style_manager_section'] ) ) {
		$options['sections']['style_manager_section'] = array();
	}

	// The section might be already defined, thus we merge, not replace the entire section config.
	$options['sections']['style_manager_section'] = array_replace_recursive( $options['sections']['style_manager_section'], array(
		'options' => array(
			'sm_color_primary' => array(
				'connected_fields' => array(
					'accent_color',
					'patch_header_links_active_color',
					'main_content_body_link_color',
				),
			),
			'sm_dark_primary' => array(
				'connected_fields' => array(
					'main_content_body_link_default_color',
					'patch_header_navigation_links_color',
					'blog_item_title_color',
					'main_content_page_title_color',
					'main_content_heading_1_color',
					'main_content_heading_2_color',
					'main_content_heading_3_color',
					'main_content_heading_4_color',
					'main_content_heading_5_color',
					'main_content_heading_6_color',
					'main_content_border_color',
				),
			),
			'sm_dark_secondary' => array(
				'connected_fields' => array(
					'main_content_body_text_color',
				),
			),
			'sm_dark_tertiary' => array(
				'connected_fields' => array(

				),
			),
			'sm_light_primary' => array(
				'connected_fields' => array(
					'main_content_body_background_color',
					'patch_footer_body_text_color',
					'patch_footer_links_color'
				),
			),
			'sm_light_secondary' => array(
				'connected_fields' => array(
					
				),
			),
		),
	) );

	return $options;
}

function patch_modify_customify_options( $options ) {

	// Recommended Fonts List - Headings
	$recommended_fonts = apply_filters( 'pixelgrade_header_customify_recommended_headings_fonts',
		array(
			'Oswald',
			'Roboto',
			'Playfair Display',
			'Lato',
			'Open Sans',
			'Exo',
			'PT Sans',
			'Ubuntu',
			'Vollkorn',
			'Lora',
			'Arvo',
			'Josefin Slab',
			'Crete Round',
			'Kreon',
			'Bubblegum Sans',
			'The Girl Next Door',
			'Pacifico',
			'Handlee',
			'Satify',
			'Pompiere'
		)
	);

	/**
	 * COLORS - This section will handle different elements colors (eg. links, headings)
	 */
	$options['sections'] = array_replace_recursive( $options['sections'], array(
		'presets_section' => array(
			'title'    => __( 'Style Presets', 'patch' ),
			'options' => array(
				'theme_style'   => array(
					'type'      => 'preset',
					'label'     => __( 'Select a style:', 'patch' ),
					'desc' => __( 'Conveniently change the design of your site with built-in style presets. Easy as pie.', 'patch' ),
					'default'   => 'patch',
					'choices_type' => 'awesome',
					'choices'  => array(
						'patch' => array(
							'label' => __( 'Patch', 'patch' ),
							'preview' => array(
								'color-text' => '#ffffff',
								'background-card' => '#121012',
								'background-label' => '#fee900',
								'font-main' => 'Oswald',
								'font-alt' => 'Roboto',
							),
							'options' => array(
								'accent_color'                    => '#ffeb00',
                                'patch_header_links_active_color' => '#ffeb00',
                                'main_content_body_link_color'    => '#ffeb00',

								'main_content_body_text_color'    => '#3d3e40',

								'blog_item_title_color'           => '#171617',
								'main_content_page_title_color'   => '#171617',

                                'main_content_heading_1_color'    => '#171617',
								'main_content_heading_2_color'    => '#171617',
								'main_content_heading_3_color'    => '#171617',
								'main_content_heading_4_color'    => '#171617',
								'main_content_heading_5_color'    => '#171617',
								'main_content_heading_6_color'    => '#171617',

								'patch_header_links_font'         => 'Oswald',
								'main_content_page_title_font'    => 'Oswald',
								'main_content_quote_block_font'   => 'Oswald',
								'blog_item_title_font'            => 'Oswald',
                                'main_content_heading_1_font'     => 'Oswald',
								'main_content_heading_2_font'     => 'Oswald',
								'main_content_heading_3_font'     => 'Oswald',
								'main_content_heading_4_font'     => 'Oswald',
								'main_content_heading_5_font'     => 'Roboto',
								'main_content_heading_6_font'     => 'Roboto',
								'main_content_body_text_font'     => 'Roboto',
							)
						),


						'adler' => array(
							'label' => __( 'Adler', 'patch' ),
							'preview' => array(
								'color-text' => '#fff',
								'background-card' => '#0e364f',
								'background-label' => '#000000',
								'font-main' => 'Permanent Marker',
								'font-alt' => 'Droid Sans Mono',
							),
							'options' => array(
//								'headings_caps' => true,

                                'accent_color'                    => '#68f3c8',
                                'patch_header_links_active_color' => '#68f3c8',
                                'main_content_body_link_color'    => '#68f3c8',

								'main_content_body_text_color'    => '#45525a',

								'blog_item_title_color'           => '#0e364f',
								'main_content_page_title_color'   => '#0e364f',

                                'main_content_heading_1_color'    => '#0e364f',
								'main_content_heading_2_color'    => '#0e364f',
								'main_content_heading_3_color'    => '#0e364f',
								'main_content_heading_4_color'    => '#0e364f',
								'main_content_heading_5_color'    => '#0e364f',
								'main_content_heading_6_color'    => '#0e364f',

								'patch_header_links_font'         => 'Permanent Marker',
								'main_content_page_title_font'    => 'Permanent Marker',
								'main_content_quote_block_font'   => 'Permanent Marker',
								'blog_item_title_font'            => 'Permanent Marker',
                                'main_content_heading_1_font'     => 'Permanent Marker',
								'main_content_heading_2_font'     => 'Permanent Marker',
								'main_content_heading_3_font'     => 'Permanent Marker',
								'main_content_heading_4_font'     => 'Permanent Marker',
								'main_content_heading_5_font'     => 'Droid Sans Mono',
								'main_content_heading_6_font'     => 'Droid Sans Mono',
								'main_content_body_text_font'     => 'Droid Sans Mono',
							)
						),

						'royal' => array(
							'label' => __( 'Royal', 'patch' ),
							'preview' => array(
								'color-text' => '#ffffff',
								'background-card' => '#615375',
								'background-label' => '#46414c',
								'font-main' => 'Abril Fatface',
								'font-alt' => 'PT Serif',
							),
							'options' => array(
//								'headings_caps' => false,

								'accent_color'                    => '#8eb2c5',
								'patch_header_links_active_color' => '#8eb2c5',
								'main_content_body_link_color'    => '#8eb2c5',

								'main_content_body_text_color'    => '#6f8089',

								'blog_item_title_color'           => '#725c92',
								'main_content_page_title_color'   => '#725c92',

								'main_content_heading_1_color'    => '#725c92',
								'main_content_heading_2_color'    => '#725c92',
								'main_content_heading_3_color'    => '#725c92',
								'main_content_heading_4_color'    => '#725c92',
								'main_content_heading_5_color'    => '#725c92',
								'main_content_heading_6_color'    => '#725c92',

								'patch_header_links_font'         => 'Abril Fatface',
								'main_content_page_title_font'    => 'Abril Fatface',
								'main_content_quote_block_font'   => 'Abril Fatface',
								'blog_item_title_font'            => 'Abril Fatface',
								'main_content_heading_1_font'     => 'Abril Fatface',
								'main_content_heading_2_font'     => 'Abril Fatface',
								'main_content_heading_3_font'     => 'Abril Fatface',
								'main_content_heading_4_font'     => 'Abril Fatface',
								'main_content_heading_5_font'     => 'PT Serif',
								'main_content_heading_6_font'     => 'PT Serif',
								'main_content_body_text_font'     => 'PT Serif',
							)
						),

						'queen' => array(
							'label' => __( 'Queen', 'patch' ),
							'preview' => array(
								'color-text' => '#fbedec',
								'background-card' => '#a33b61',
								'background-label' => '#41212a',
								'font-main' => 'Playfair Display',
								'font-alt' => 'Merriweather',
							),
							'options' => array(
//								'headings_caps' => false,

								'accent_color'                    => '#c17390',
								'patch_header_links_active_color' => '#c17390',
								'main_content_body_link_color'    => '#c17390',

								'main_content_body_text_color'    => '#403b3c',

								'blog_item_title_color'           => '#a33b61',
								'main_content_page_title_color'   => '#a33b61',

								'main_content_heading_1_color'    => '#a33b61',
								'main_content_heading_2_color'    => '#a33b61',
								'main_content_heading_3_color'    => '#a33b61',
								'main_content_heading_4_color'    => '#a33b61',
								'main_content_heading_5_color'    => '#a33b61',
								'main_content_heading_6_color'    => '#a33b61',

								'patch_header_links_font'         => 'Playfair Display',
								'main_content_page_title_font'    => 'Playfair Display',
								'main_content_quote_block_font'   => 'Playfair Display',
								'blog_item_title_font'            => 'Playfair Display',
								'main_content_heading_1_font'     => 'Playfair Display',
								'main_content_heading_2_font'     => 'Playfair Display',
								'main_content_heading_3_font'     => 'Playfair Display',
								'main_content_heading_4_font'     => 'Playfair Display',
								'main_content_heading_5_font'     => 'Merriweather',
								'main_content_heading_6_font'     => 'Merriweather',
								'main_content_body_text_font'     => 'Merriweather',
							)
						),
						'carrot' => array(
							'label' => __( 'Carrot', 'patch' ),
							'preview' => array(
								'color-text' => '#ffffff',
								'background-card' => '#df421d',
								'background-label' => '#85210a',
								'font-main' => 'Oswald',
								'font-alt' => 'PT Sans Narrow',
							),
							'options' => array(
//								'headings_caps' => false,

								'accent_color'                    => '#df421d',
								'patch_header_links_active_color' => '#df421d',
								'main_content_body_link_color'    => '#df421d',

								'main_content_body_text_color'    => '#7e7e7e',

								'blog_item_title_color'           => '#df421d',
								'main_content_page_title_color'   => '#df421d',

								'main_content_heading_1_color'    => '#df421d',
								'main_content_heading_2_color'    => '#df421d',
								'main_content_heading_3_color'    => '#df421d',
								'main_content_heading_4_color'    => '#df421d',
								'main_content_heading_5_color'    => '#df421d',
								'main_content_heading_6_color'    => '#df421d',

								'patch_header_links_font'         => 'Oswald',
								'main_content_page_title_font'    => 'Oswald',
								'main_content_quote_block_font'   => 'Oswald',
								'blog_item_title_font'            => 'Oswald',
								'main_content_heading_1_font'     => 'Oswald',
								'main_content_heading_2_font'     => 'Oswald',
								'main_content_heading_3_font'     => 'Oswald',
								'main_content_heading_4_font'     => 'Oswald',
								'main_content_heading_5_font'     => 'PT Sans Narrow',
								'main_content_heading_6_font'     => 'PT Sans Narrow',
								'main_content_body_text_font'     => 'PT Sans Narrow',
							)
						),
						'velvet' => array(
							'label' => __( 'Velvet', 'patch' ),
							'preview' => array(
								'color-text' => '#ffffff',
								'background-card' => '#282828',
								'background-label' => '#000000',
								'font-main' => 'Pinyon Script',
								'font-alt' => 'Josefin Sans',
							),
							'options' => array(
//								'headings_caps' => false,

								'accent_color'                    => '#000000',
								'patch_header_links_active_color' => '#000000',
								'main_content_body_link_color'    => '#000000',

								'main_content_body_text_color'    => '#000000',

								'blog_item_title_color'           => '#000000',
								'main_content_page_title_color'   => '#000000',

								'main_content_heading_1_color'    => '#000000',
								'main_content_heading_2_color'    => '#000000',
								'main_content_heading_3_color'    => '#000000',
								'main_content_heading_4_color'    => '#000000',
								'main_content_heading_5_color'    => '#000000',
								'main_content_heading_6_color'    => '#000000',

								'patch_header_links_font'         => 'Pinyon Script',
								'main_content_page_title_font'    => 'Pinyon Script',
								'main_content_quote_block_font'   => 'Pinyon Script',
								'blog_item_title_font'            => 'Pinyon Script',
								'main_content_heading_1_font'     => 'Pinyon Script',
								'main_content_heading_2_font'     => 'Pinyon Script',
								'main_content_heading_3_font'     => 'Pinyon Script',
								'main_content_heading_4_font'     => 'Pinyon Script',
								'main_content_heading_5_font'     => 'Josefin Sans',
								'main_content_heading_6_font'     => 'Josefin Sans',
								'main_content_body_text_font'     => 'Josefin Sans',
							)
						),

					)
				),
			)
		),


		// Header
		'header_section' => array(
			'title'    => __( 'Header', 'patch' ),
			'options' => array(
				'patch_header_options_customizer_tabs'        => array(
					'type' => 'html',
					'html' => '<nav class="section-navigation  js-section-navigation">
							<a href="#section-title-header-layout">' . esc_html__( 'Layout', 'patch' ) . '</a>
							<a href="#section-title-header-colors">' . esc_html__( 'Colors', 'patch' ) . '</a>
							<a href="#section-title-header-fonts">' . esc_html__( 'Fonts', 'patch' ) . '</a>
							</nav>',
				),
				// [Section] Layout
				'patch_header_title_layout_section'    => array(
					'type' => 'html',
					'html' => '<span id="section-title-header-layout" class="separator section label large">&#x1f4d0; ' . esc_html__( 'Layout', 'patch' ) . '</span>',
				),
				'patch_header_logo_height'              => array(
					'type'        => 'range',
					'label'       => esc_html__( 'Logo Height', 'patch' ),
					'desc'        => esc_html__( 'Adjust the max height of your logo container.', 'patch' ),
					'live'        => true,
					'default'     => 36,
					'input_attrs' => array(
						'min'          => 20,
						'max'          => 200,
						'step'         => 1,
						'data-preview' => true,
					),
					'css'         => array(
						array(
							'property' => 'max-height',
							'selector' => '.site-logo img, .custom-logo-link img',
							'unit'     => 'px',
						),
						array(
							'property' => 'font-size',
							'selector' => '.site-title',
							'unit'     => 'px',
						),
					),
				),
				'patch_navigation_items_spacing' => array(
					'type'        => 'range',
					'label'       => esc_html__( 'Navigation Items Spacing', 'patch' ),
					'live'        => true,
					'default'     => 10,
					'input_attrs' => array(
						'min'          => 0,
						'max'          => 40,
						'step'         => 1
					),
					'css'         => array(
						array(
							'property' => 'margin-bottom',
							'selector' => '.no-valid-selector-here',
							'unit'     => 'px',
							'callback_filter' => 'patch_navigation_items_spacing_cb'
						),
					),
				),
				'patch_disable_search_in_social_menu' => array(
					'type'    => 'checkbox',
					'label'   => esc_html__( 'Hide search button in Social Menu.', 'patch' ),
					'default' => false,
				),
				// [Section] COLORS
				'patch_header_title_colors_section'    => array(
					'type' => 'html',
					'html' => '<span id="section-title-header-colors" class="separator section label large">&#x1f3a8; ' . esc_html__( 'Colors', 'patch' ) . '</span>',
				),
				'patch_header_navigation_links_color' => array(
					'type'    => 'color',
					'label'   => esc_html__( 'Navigation Links Color', 'patch' ),
					'live'    => true,
					'default' => '#000000',
					'css'     => array(
						array(
							'property' => 'color',
							'selector' => '.site-header a, .nav--social a:before, div#infinite-handle span, :first-child:not(input) ~ .form-submit #submit',
						),
					),
				),
				'patch_header_links_active_color'     => array(
					'type'    => 'color',
					'label'   => esc_html__( 'Links Active Color', 'patch' ),
					'live'    => true,
					'default' => '#ffeb00',
					'css'     => array(
						array(
							'property' => 'background-color',
							'selector' => '.nav--main li:hover > a, .nav--social.nav--social a:hover:before',
						),
					),
				),
				// [Section] FONTS
				'patch_header_title_fonts_section'    => array(
					'type' => 'html',
					'html' => '<span id="section-title-header-fonts" class="separator section label large">&#x1f4dd;  ' . esc_html__( 'Fonts', 'patch' ) . '</span>',
				),
				'patch_header_links_font' => array(
					'type'     			=> 'font',
					'label'            => esc_html__( 'Navigation Text', 'patch' ),
					'desc'             => esc_html__( '', 'patch' ),
					'selector'         => '.nav--main a',

					// Set the defaults
					'default'  => array(
						'font-family'    => 'Oswald',
						'font-weight'    => '300',
						'letter-spacing' => 0.06,
						'text-transform' => 'uppercase'
					),

					// List of recommended fonts defined by theme
					'recommended' => $recommended_fonts,
					// Sub Fields Configuration (optional)
					'fields'   => array(
						'letter-spacing'  => array( -1, 2, 0.01, 'em' ),
						'text-align'      => false,                           // Disable sub-field (False by default)
						'text-transform'  => true,
						'text-decoration' => false
					)
				),
			)
		),


		// Main Content
		'main_content_section' => array(
			'title'    => __( 'Main Content', 'patch' ),
			'options' => array(
				'main_content_options_customizer_tabs'              => array(
					'type' => 'html',
					'html' => '<nav class="section-navigation  js-section-navigation">
							<a href="#section-title-main-layout">' . esc_html__( 'Layout', 'patch' ) . '</a>
							<a href="#section-title-main-colors">' . esc_html__( 'Colors', 'patch' ) . '</a>
							<a href="#section-title-main-fonts">' . esc_html__( 'Fonts', 'patch' ) . '</a>
							</nav>',
				),

				// [Section] Layout
				'main_content_title_layout_section'    => array(
					'type' => 'html',
					'html' => '<span id="section-title-main-layout" class="separator section label large">&#x1f4d0; ' . esc_html__( 'Layout', 'patch' ) . '</span>',
				),
				'content_width' => array(
					'type' => 'range',
					'label' => esc_html__( 'Content Width', 'patch' ),
					'desc' => esc_html__( 'Decrease the width of your content to create an inset area for your text. The inset size will be the space between Site Container and Content.', 'patch' ),
					'live' => true,
					'default' => 620,
					'input_attrs' => array(
						'min' => 480,
						'max' => 1240,
						'step' => 10,
						'data-preview' => true
					),
					'css' => array(
						array(
							'property' => 'max-width',
							'selector' =>
								'.single .hentry,
								.single .comments-area,
								.single .nocomments, 
								.single #respond.comment-respond, 
								.page:not(.entry-card) .hentry, 
								.page:not(.entry-card) .comments-area, 
								.page:not(.entry-card) .nocomments, 
								.page:not(.entry-card) #respond.comment-respond, 
								.attachment-navigation, .nav-links',
							'unit' => 'px'
						)
					)
				),
				'content_sides_spacing' => array(
					'type' => 'range',
					'label' => esc_html__( 'Content Sides Spacing', 'patch' ),
					'live' => true,
					'default' => 180,
					'input_attrs' => array(
						'min' => 0,
						'max' => 400,
						'step' => 10,
						'data-preview' => true
					),
					'css' => array(
						array(
							'property' => 'no-valid-property-here',
							'selector' => '.no-valid-selector-here',
							'unit' => 'px',
							'callback_filter' => 'patch_content_sides_spacing'
						),
					)
				),
				'container_sides_spacing' => array(
					'type' => 'range',
					'label' => esc_html__( 'Container Sides Spacing', 'patch' ),
					'desc'  => esc_html__( 'Adjust the space separating the site content and the sides of the browser.', 'patch' ),
					'live' => true,
					'default' => 60,
					'input_attrs' => array(
						'min' => 20,
						'max' => 200,
						'step' => 10,
						'data-preview' => true
					),
					'css' => array(
						array(
							'media' => 'only screen and (min-width: 1260px)',
							'property' => 'padding',
							'selector' =>
								'.single .site-content, 
								.page:not(.entry-card) .site-content, 
								.no-posts .site-content',
							'unit' => 'px'
						),
					)
				),
				'main_content_border_width'             => array(
					'type'        => 'range',
					'label'       => esc_html__( 'Site Border Width', 'patch' ),
					'desc'        => esc_html__( '', 'patch' ),
					'live'        => true,
					'default'     => 18,
					'input_attrs' => array(
						'min'          => 0,
						'max'          => 120,
						'step'         => 1,
						'data-preview' => true,
					),
					'css'         => array(
						array(
							'property' => 'border-width',
							'selector' => 'body',
							'unit'     => 'px',
						),
						array(
							'property' => 'height',
							'selector' => 'body:before',
							'unit'     => 'px',
						),
					),
				),

				// [Section] COLORS
				'main_content_border_color' => array(
					'type'    => 'color',
					'label'   => esc_html__( 'Site Border Color', 'patch' ),
					'live'    => true,
					'default' => '#000000',
					'css'     => array(
						array(
							'property' => 'border-color',
							'selector' => 'body',
						),
						array(
							'property' => 'background-color',
							'selector' => 'body:before, .site-footer',
						),
					),
				),
				'main_content_title_colors_section' => array(
					'type' => 'html',
					'html' => '<span id="section-title-main-colors" class="separator section label large">&#x1f3a8; ' . esc_html__( 'Colors', 'patch' ) . '</span>',
				),
				'main_content_page_title_color'         => array(
					'type'    => 'color',
					'label'   => esc_html__( 'Page Title Color', 'patch' ),
					'live'    => true,
					'default' => '#171617',
					'css'     => array(
						array(
							'property' => 'color',
							'selector' => '.single .entry-title, .page .entry-title, .dropcap,
											.comment-number,
											.overlay--search .search-field',
						),
						array(
							'property' => 'background-color',
							'selector' => '.comment-number.comment-number--dark, .comment-reply-title:before',
						),
					),
				),
				'main_content_body_text_color'          => array(
					'type'    => 'color',
					'label'   => esc_html__( 'Body Text Color', 'patch' ),
					'live'    => true,
					'default' => '#3d3e40',
					'css'     => array(
						array(
							'property' => 'color',
							'selector' => 'body',
						),
						array(
							'property' => 'background-color',
							'selector' => '.entry-card .entry-image',
						),
					),
				),
				'main_content_body_background_color'                                => array(
					'type'    => 'color',
					'label'   => esc_html__( 'Body Background Color', 'hive_txtd' ),
					'live'    => true,
					'default' => '#ffffff',
					'css'     => array(
						array(
							'selector' => 'body, .entry-card,
                                .comment-number,
                                textarea,
                                .mobile-header-wrapper,
                                .main-navigation,
                                .overlay--search,
                                .overlay--search .search-field,
                                .sharing-hidden .inner,
                                .nav--main ul,
                                input',
							'property' => 'background-color',
						),
						array(
							'selector' => '.entry-card--text .entry-title, 
                                .site-footer a[rel="designer"], 
                                .comments-area:after, 
                                .comment-number.comment-number--dark, 
                                .comment-reply-title:before, 
                                .add-comment .add-comment__button',
							'property' => 'color',
						),
						array(
							'selector' => '.search-form .search-submit',
							'property' => 'border-color',
						),
						array(
							'selector' => '#arrow',
							'property' => 'fill',
						),
						array(
							'selector' => '.sharing-hidden .inner:after',
							'property' => 'border-bottom-color',
						),
						array(
							'selector' => 'body',
							'property' => '--box-shadow-color',
						),
						array(
							'selector' => '.not-really-a-selector',
							'property' => 'box-shadow',
                            'callback_filter' => 'patch_links_box_shadow_cb'
						),
					),
				),
				'main_content_body_link_default_color'          => array(
					'type'    => 'color',
					'label'   => esc_html__( 'Body Link Color', 'patch' ),
					'live'    => true,
					'default' => '#000000',
					'css'     => array(
						array(
							'property' => 'color',
							'selector' => 'a',
						),
					),
				),
				'main_content_body_link_color'          => array(
					'type'    => 'color',
					'label'   => esc_html__( 'Body Link Active Color', 'patch' ),
					'live'    => true,
					'default' => '#ffeb00',
					'css'     => array(
						array(
							'property' => 'background-color',
							'selector' => '.single .entry-content a, .page .entry-content a',
						),
					),
				),
				'accent_color'   => array(
					'type'      => 'color',
					'label'     => __( 'Accent Color', 'patch' ),
					'live' => true,
					'default'   => '#ffeb00',
					'css'  => array(
						array(
							'property' => 'text-shadow',
							'selector' => '.dropcap',
							'callback_filter' => 'patch_dropcap_text_shadow'
						),
						array(
							'property' => 'box-shadow',
							'selector' => '.entry-card.format-quote .entry-content a',
							'callback_filter' => 'patch_link_box_shadow'
						),

						array(
							'property' => 'color',
							'selector' =>
								'h1 a,
								.site-title a,
								h2 a,
								h3 a,
								.entry-card.format-quote .entry-content a:hover,
								.bypostauthor .comment__author-name:before,
								.site-footer a:hover, .test',
						),

						array(
							'property' => 'fill',
							'selector' => '#bar'
						),
						array(
							'property' => 'background-color',
							'selector' =>
								'.smart-link,
								.edit-link a,
								.author-info__link,
								.comments_add-comment,
								.comment .comment-reply-title a,
								.page-links a,
								:first-child:not(input) ~ .form-submit #submit,
								.sidebar .widget a:hover,
								.nav--main li[class*="current-menu"] > a,
								.highlight,
								.sticky .sticky-post,
								.nav--social a:hover:before,
								.jetpack_subscription_widget input[type="submit"],
								.widget_blog_subscription input[type="submit"],
								.search-form .search-submit,
								div#infinite-handle span:after,
								.cat-links,
								.entry-format',
						),
						array(
							'property' => 'background-color',
							'selector' => '::-moz-selection'
						),
						array(
							'property' => 'background-color',
							'selector' => '::selection'
						),
						array(
							'property' => 'border-top-color',
							'selector' => '.sticky .sticky-post:before,
								.sticky .sticky-post:after'
						)
					),
				),

				// [Sub Section] Headings Color
				'main_content_title_headings_color_section'              => array(
					'type' => 'html',
					'html' => '<span class="separator sub-section label">' . esc_html__( 'Headings Color', 'patch' ) . '</span>',
				),
				'main_content_heading_1_color'          => array(
					'type'    => 'color',
					'label'   => esc_html__( 'Heading 1', 'patch' ),
					'live'    => true,
					'default' => '#171617',
					'css'     => array(
						array(
							'property' => 'color',
							'selector' => 'h1, .site-title a',
						),
					),
				),
				'main_content_heading_2_color'          => array(
					'type'    => 'color',
					'label'   => esc_html__( 'Heading 2', 'patch' ),
					'live'    => true,
					'default' => '#171617',
					'css'     => array(
						array(
							'property' => 'color',
							'selector' => 'h2, blockquote',
						),
					),
				),
				'main_content_heading_3_color'          => array(
					'type'    => 'color',
					'label'   => esc_html__( 'Heading 3', 'patch' ),
					'live'    => true,
					'default' => '#171617',
					'css'     => array(
						array(
							'property' => 'color',
							'selector' => 'h3'
						),
					),
				),
				'main_content_heading_4_color'          => array(
					'type'    => 'color',
					'label'   => esc_html__( 'Heading 4', 'patch' ),
					'live'    => true,
					'default' => '#171617',
					'css'     => array(
						array(
							'property' => 'color',
							'selector' => 'h4',
						),
					),
				),
				'main_content_heading_5_color'          => array(
					'type'    => 'color',
					'label'   => esc_html__( 'Heading 5', 'patch' ),
					'live'    => true,
					'default' => '#171617',
					'css'     => array(
						array(
							'property' => 'color',
							'selector' => 'h5',
						),
					),
				),
				'main_content_heading_6_color'          => array(
					'type'    => 'color',
					'label'   => esc_html__( 'Heading 6', 'patch' ),
					'live'    => true,
					'default' => '#171617',
					'css'     => array(
						array(
							'property' => 'color',
							'selector' => 'h6',
						),
					),
				),

				// [Section] FONTS
				'main_content_title_fonts_section'             => array(
					'type' => 'html',
					'html' => '<span id="section-title-main-fonts" class="separator section label large">&#x1f4dd;  ' . esc_html__( 'Fonts', 'patch' ) . '</span>',
				),

				'main_content_page_title_font' => array(
					'type'     => 'font',
					'label'    => esc_html__( 'Page Title Font', 'patch' ),
					'desc'     => esc_html__( '', 'patch' ),
					'selector' => '.single .entry-title, .page .entry-title',

					// Set the defaults
					'default'  => array(
						'font-family'    => 'Oswald',
						'font-weight'    => 'regular',
						'letter-spacing' => 0.04,
						'text-transform' => 'uppercase'
					),

					// List of recommended fonts defined by theme
					'recommended' => $recommended_fonts,


					// Sub Fields Configuration (optional)
					'fields'   => array(
						'letter-spacing'  => array( -1, 2, 0.01, 'em' ),
						'text-align'      => false,                           // Disable sub-field (False by default)
						'text-transform'  => true,
						'text-decoration' => false
					)
				),

				'main_content_body_text_font' => array(
					'type'     => 'font',
					'label'    => esc_html__( 'Body Text Font', 'patch' ),
					'desc'     => esc_html__( '', 'patch' ),
					'selector' => 'body',

					// Set the defaults
					'default'  => array(
						'font-family'    => 'Roboto',
						'font-weight'    => '300',
						'letter-spacing' => 0,
						'text-transform' => 'none'
					),

					// List of recommended fonts defined by theme
					'recommended' => $recommended_fonts,

					// Sub Fields Configuration (optional)
					'fields'   => array(
						'letter-spacing'  => array( -1, 2, 0.01, 'em' ),
						'text-align'      => false,                           // Disable sub-field (False by default)
						'text-transform'  => true,
						'text-decoration' => false
					)
				),

				'main_content_quote_block_font' => array(
					'type'     => 'font',
					'label'    => esc_html__( 'Quote Block Font', 'patch' ),
					'desc'     => esc_html__( '', 'patch' ),
					'selector' => 'blockquote',

					// Set the defaults
					'default'  => array(
						'font-family'    => 'Oswald',
						'font-weight'    => '500',
						'letter-spacing' => 0,
						'text-transform' => 'uppercase'
					),

					// List of recommended fonts defined by theme
					'recommended' => $recommended_fonts,

					// Sub Fields Configuration (optional)
					'fields'   => array(
						'letter-spacing'  => array( -1, 2, 0.01, 'em' ),
						'text-align'      => false,                           // Disable sub-field (False by default)
						'text-transform'  => true,
						'text-decoration' => false
					)
				),

				// [Sub Section] Headings Fonts
				'main_content_title_headings_fonts_section'     => array(
					'type' => 'html',
					'html' => '<span class="separator sub-section label">' . esc_html__( 'Headings Fonts', 'patch' ) . '</span>',
				),

				'main_content_heading_1_font' => array(
					'type'     => 'font',
					'label'    => esc_html__( 'Heading 1', 'patch' ),
					'desc'     => esc_html__( '', 'patch' ),
					'selector' => 'h1',

					// Set the defaults
					'default'  => array(
						'font-family'    => 'Oswald',
						'font-weight'    => '500',
						'letter-spacing' => 0.04,
						'text-transform' => 'uppercase'
					),

					// List of recommended fonts defined by theme
					'recommended' => $recommended_fonts,
					// Sub Fields Configuration (optional)
					'fields'   => array(
						'letter-spacing'  => array( -1, 2, 0.01, 'em' ),
						'text-align'      => false,                           // Disable sub-field (False by default)
						'text-transform'  => true,
						'text-decoration' => false
					)
				),

				'main_content_heading_2_font' => array(
					'type'     => 'font',
					'label'    => esc_html__( 'Heading 2', 'patch' ),
					'desc'     => esc_html__( '', 'patch' ),
					'selector' => 'h2',

					// Set the defaults
					'default'  => array(
						'font-family'    => 'Oswald',
						'font-weight'    => '500',
						'letter-spacing' => 0.04,
						'text-transform' => 'uppercase'
					),

					// List of recommended fonts defined by theme
					'recommended' => $recommended_fonts,

					// Sub Fields Configuration (optional)
					'fields'   => array(
						'letter-spacing'  => array( -1, 2, 0.01, 'em' ),
						'text-align'      => false,                           // Disable sub-field (False by default)
						'text-transform'  => true,
						'text-decoration' => false
					)
				),

				'main_content_heading_3_font' => array(
					'type'     => 'font',
					'label'    => esc_html__( 'Heading 3', 'patch' ),
					'desc'     => esc_html__( '', 'patch' ),
					'selector' => 'h3',

					// Set the defaults
					'default'  => array(
						'font-family'    => 'Oswald',
						'font-weight'    => '200',
						'letter-spacing' => 0,
						'text-transform' => 'none'
					),

					// List of recommended fonts defined by theme
					'recommended' => $recommended_fonts,

					// Sub Fields Configuration (optional)
					'fields'   => array(
						'letter-spacing'  => array( -1, 2, 0.01, 'em' ),
						'text-align'      => false,                           // Disable sub-field (False by default)
						'text-transform'  => true,
						'text-decoration' => false
					)
				),

				'main_content_heading_4_font' => array(
					'type'     => 'font',
					'label'    => esc_html__( 'Heading 4', 'patch' ),
					'desc'     => esc_html__( '', 'patch' ),
					'selector' => 'h4',

					// Set the defaults
					'default'  => array(
						'font-family'    => 'Oswald',
						'font-weight'    => '500',
						'letter-spacing' => 0.1,
						'text-transform' => 'uppercase'
					),

					// List of recommended fonts defined by theme
					'recommended' => $recommended_fonts,

					// Sub Fields Configuration (optional)
					'fields'   => array(
						'letter-spacing'  => array( -1, 2, 0.01, 'em' ),
						'text-align'      => false,                           // Disable sub-field (False by default)
						'text-transform'  => true,
						'text-decoration' => false
					)
				),

				'main_content_heading_5_font' => array(
					'type'     => 'font',
					'label'    => esc_html__( 'Heading 5', 'patch' ),
					'desc'     => esc_html__( '', 'patch' ),
					'selector' => 'h5',

					// Set the defaults
					'default'  => array(
						'font-family'    => 'Roboto',
						'font-weight'    => '500',
						'letter-spacing' => 0.02,
						'text-transform' => 'uppercase'
					),

					// List of recommended fonts defined by theme
					'recommended' => $recommended_fonts,

					// Sub Fields Configuration (optional)
					'fields'   => array(
						'letter-spacing'  => array( -1, 2, 0.01, 'em' ),
						'text-align'      => false,                           // Disable sub-field (False by default)
						'text-transform'  => true,
						'text-decoration' => false
					)
				),

				'main_content_heading_6_font' => array(
					'type'     => 'font',
					'label'    => esc_html__( 'Heading 6', 'patch' ),
					'desc'     => esc_html__( '', 'patch' ),
					'selector' => '.entry-content h6, h6, .h6',
					'callback' => 'typeline_font_cb',

					// Set the defaults
					'default'  => array(
						'font-family'    => 'Roboto',
						'font-weight'    => '500',
						'letter-spacing' => 0.03,
						'text-transform' => 'none'
					),

					// List of recommended fonts defined by theme
					'recommended' => $recommended_fonts,

					// Sub Fields Configuration (optional)
					'fields'   => array(
						'letter-spacing'  => array( -1, 2, 0.01, 'em' ),
						'text-align'      => false,                           // Disable sub-field (False by default)
						'text-transform'  => true,
						'text-decoration' => false
					)
				),
			)
		),


		// Footer
		'footer_section' => array(
			'title'    => __( 'Footer', 'patch' ),
			'options' => array(
				'patch_footer_options_customizer_tabs'    => array(
					'type' => 'html',
					'html' => '<nav class="section-navigation  js-section-navigation">
							<a href="#section-title-footer-layout">' . esc_html__( 'Layout', 'patch' ) . '</a>
							<a href="#section-title-footer-colors">' . esc_html__( 'Colors', 'patch' ) . '</a>
							</nav>',
				),
				// [Section] Layout
				'patch_footer_title_layout_section'    => array(
					'type' => 'html',
					'html' => '<span id="section-title-footer-layout" class="separator section label large">&#x1f4d0; ' . esc_html__( 'Layout', 'patch' ) . '</span>',
				),
				'patch_footer_copyright_text' => array(
					'type'              => 'textarea',
					'label'             => esc_html__( 'Copyright Text', 'patch' ),
					'desc'              => esc_html__( 'Set the text that will appear in the footer area. Use %year% to display the current year.', 'patch' ),
					'default'           => esc_html__( '&copy; %year% %site-title%.', 'patch' ),
					'sanitize_callback' => 'wp_kses_post',
					'live'              => array( '.site-info' ),
				),
				'patch_footer_top_spacing' => array(
					'type'        => 'range',
					'label'       => esc_html__( 'Top Spacing', 'patch' ),
					'live'        => true,
					'default'     => 12,
					'input_attrs' => array(
						'min'          => 0,
						'max'          => 120,
						'step'         => 12,
						'data-preview' => true,
					),
					'css'         => array(
						array(
							'property' => 'padding-top',
							'selector' => '.site-footer',
							'unit'     => 'px',
						),
					),
				),
				'patch_footer_bottom_spacing' => array(
					'type'        => 'range',
					'label'       => esc_html__( 'Bottom Spacing', 'patch' ),
					'live'        => true,
					'default'     => 12,
					'input_attrs' => array(
						'min'          => 0,
						'max'          => 120,
						'step'         => 12,
						'data-preview' => true,
					),
					'css'         => array(
						array(
							'property' => 'padding-bottom',
							'selector' => '.site-footer',
							'unit'     => 'px',
						),
					),
				),
				'patch_hide_back_to_top' => array(
					'type'	=> 'checkbox',
					'default' => false,
					'label' => __( 'Hide Back To Top Link', 'patch' ),
					'css' => array(
						array(
							'property' => 'display',
							'selector' => '.back-to-top-button',
							'callback_filter' => 'patch_hide_back_to_top'
						)
					)
				),
				'footer_hide_credits'            => array(
					'type'    => 'checkbox',
					'label'   => esc_html__( 'Hide Pixelgrade Credits', 'patch' ),
					'default' => false,
				),
				// [Section] COLORS
				'patch_footer_title_colors_section'    => array(
					'type' => 'html',
					'html' => '<span id="section-title-footer-colors" class="separator section label large">&#x1f3a8; ' . esc_html__( 'Colors', 'patch' ) . '</span>',
				),
				'patch_footer_body_text_color'       => array(
					'type'    => 'color',
					'label'   => esc_html__( 'Text Color', 'patch' ),
					'live'    => true,
					'default' => '#b5b5b5',
					'css'     => array(
						array(
							'property' => 'color',
							'selector' => '.site-footer',
						),
					),
				),
				'patch_footer_links_color'           => array(
					'type'    => 'color',
					'label'   => esc_html__( 'Links Color', 'patch' ),
					'live'    => true,
					'default' => '#b5b5b5',
					'css'     => array(
						array(
							'property' => 'color',
							'selector' => '.site-footer a',
						),
					),
				),
			)
		),


		// Blog
		'blog_grid_section' => array(
			'title'    => __( 'Blog Grid Items', 'patch' ),
			'options' => array(
				'blog_grid_options_customizer_tabs' => array(
					'type' => 'html',
					'html' => '<nav class="section-navigation  js-section-navigation">
								<a href="#section-title-blog-layout">' . esc_html__( 'Layout', 'patch' ) . '</a>
								<a href="#section-title-blog-colors">' . esc_html__( 'Colors', 'patch' ) . '</a>
								<a href="#section-title-blog-fonts">' . esc_html__( 'Fonts', 'patch' ) . '</a>
								</nav>',
				),


				// [Section] Layout
				'blog_grid_title_layout_section'    => array(
					'type' => 'html',
					'html' => '<span id="section-title-blog-layout" class="separator section label large">&#x1f4d0; ' . esc_html__( 'Layout', 'patch' ) . '</span>',
				),
				'blog_container_max_width' => array(
					'type' => 'range',
					'label'       => esc_html__( 'Blog Grid Max Width', 'patch' ),
					'desc'        => esc_html__( 'Adjust the max width of the blog area.', 'patch' ),
					'live' => true,
					'default' => 1850,
					'input_attrs' => array(
						'min' => 1000,
						'max' => 2000,
						'step' => 10,
						'data-preview' => true
					),
					'css' => array(
						array(
							'media' => 'only screen and (min-width: 1260px)',
							'property' => 'max-width',
							'selector' => '.grid, .pagination',
							'unit' => 'px'
						),
					)
				),
				'blog_container_sides_spacing' => array(
					'type' => 'range',
					'label'       => esc_html__( 'Container Sides Spacing', 'patch' ),
					'desc'        => esc_html__( 'Adjust the space separating the site content and the sides of the browser.', 'patch' ),
					'live' => true,
					'default' => 60,
					'input_attrs' => array(
						'min' => 20,
						'max' => 200,
						'step' => 10,
						'data-preview' => true
					),
					'css' => array(
						array(
							'media' => 'only screen and (min-width: 1260px)',
							'property' => 'padding-left',
							'selector' => '.layout-grid .site-content',
							'unit' => 'px'
						),
						array(
							'media' => 'only screen and (min-width: 1260px)',
							'property' => 'padding-right',
							'selector' => '.layout-grid .site-content',
							'unit' => 'px'
						),
					)
				),
				'blog_grid_title_items_grid_section' => array(
					'type' => 'html',
					'html' => '<span class="separator sub-section label">' . esc_html__( 'Items Grid', 'patch' ) . '</span>',
				),
				'blog_items_per_row' => array(
					'type'        => 'range',
					'label'       => esc_html__( 'Items per Row', 'patch' ),
					'desc'        => esc_html__( 'Set the desktop-based number of columns you want and we automatically make it right for other screen sizes.', 'patch' ),
					'live'        => false,
					'default'     => 4,
					'input_attrs' => array(
						'min'  => 1,
						'max'  => 6,
						'step' => 1,
					),
				),


				// [Sub Section] Items Excerpt
				'blog_grid_title_items_excerpt_section' => array(
					'type' => 'html',
					'html' => '<span class="separator sub-section label">' . esc_html__( 'Items Excerpt', 'patch' ) . '</span>',
				),
				// Excerpt Visiblity
				// Title + Checkbox
				'blog_items_excerpt_visibility_title' => array(
					'type' => 'html',
					'html' => '<span class="customize-control-title">' . esc_html__( 'Excerpt Visibility', 'patch' ) . '</span><span class="description customize-control-description">' . esc_html__( 'Select whether to show or hide the summary.', 'patch' ) . '</span>',
				),
				'blog_items_excerpt_visibility'       => array(
					'type'    => 'checkbox',
					'label'   => esc_html__( 'Show Excerpt Text', 'patch' ),
					'default' => true,
				),


				// [Sub Section] Items Meta
				'blog_grid_title_items_meta_section' => array(
					'type' => 'html',
					'html' => '<span class="separator sub-section label">' . esc_html__( 'Items Meta', 'patch' ) . '</span>',
				),
				'blog_items_primary_meta' => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Primary Meta Section', 'patch' ),
					'desc'    => esc_html__( 'Set the meta info that display around the title. ', 'patch' ),
					'default' => 'category',
					'choices' => array(
						'none'     => esc_html__( 'None', 'patch' ),
						'category' => esc_html__( 'Category', 'patch' ),
						'author'   => esc_html__( 'Author', 'patch' ),
						'date'     => esc_html__( 'Date', 'patch' ),
						'tag'     => esc_html__( 'Tags', 'patch' ),
						'comments' => esc_html__( 'Comments', 'patch' ),
					),
				),
				'blog_items_secondary_meta'         => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Secondary Meta Section', 'patch' ),
					'desc'    => esc_html__( '', 'patch' ),
					'default' => 'author_date',
					'choices' => array(
						'none'                    => esc_html__( 'None', 'patch' ),
						'category_secondary'      => esc_html__( 'Category', 'patch' ),
						'author_secondary'        => esc_html__( 'Author', 'patch' ),
						'date_secondary'          => esc_html__( 'Date', 'patch' ),
						'author_date'             => esc_html__( 'Author & Date', 'patch' ),
						'tag_secondary'          => esc_html__( 'Tags', 'patch' ),
						'comments_secondary'      => esc_html__( 'Comments', 'patch' ),
					),
				),


				// [Section] COLORS
				'blog_grid_title_colors_section'        => array(
					'type' => 'html',
					'html' => '<span id="section-title-blog-colors" class="separator section label large">&#x1f3a8; ' . esc_html__( 'Colors', 'patch' ) . '</span>',
				),
				'blog_item_title_color' => array(
					'type'    => 'color',
					'label'   => esc_html__( 'Item Title Color', 'patch' ),
					'live'    => true,
					'default' => '#000000',
					'css'     => array(
						array(
							'property' => 'color',
							'selector' => '.entry-card:not(.entry-card--text) .entry-title, .byline, .posted-on',
						),
						array(
							'property' => 'background-color',
							'selector' => '.entry-card--text .entry-header',
						),
					),
				),


				// [Section] FONTS
				'blog_grid_title_fonts_section' => array(
					'type' => 'html',
					'html' => '<span id="section-title-blog-fonts" class="separator section label large">&#x1f4dd;  ' . esc_html__( 'Fonts', 'patch' ) . '</span>',
				),
				'blog_item_title_font' => array(
					'type'     => 'font',
					'label'    => esc_html__( 'Item Title Font', 'patch' ),
					'desc'     => esc_html__( '', 'patch' ),
					'selector' => '.entry-card .entry-title',

					// Set the defaults
					'default'  => array(
						'font-family'    => 'Oswald',
						'font-weight'    => 'regular',
						'letter-spacing' => 0.04,
						'text-transform' => 'uppercase'
					),

					// List of recommended fonts defined by theme
					'recommended' => $recommended_fonts,

					// Sub Fields Configuration (optional)
					'fields'   => array(
						'letter-spacing'  => array( -1, 2, 0.01, 'em' ),
						'text-align'      => false,                           // Disable sub-field (False by default)
						'text-transform'  => true,
						'text-decoration' => false
					)
				),
			)
		),
//		'colors_section' => array(
//			'title'    => __( 'Colors', 'patch' ),
//			'options' => array(
//				'headings_color' => array(
//					'type'      => 'color',
//					'label'     => __( 'Headings Color', 'patch' ),
//					'live' => true,
//					'default'   => '#171617',
//					'css'  => array(
//						array(
//							'property' => 'color',
//							'selector' => '.site-title a, h1, h2, h3, h4, h5, h6',
//						)
//					)
//				),
//			)
//		),
	) );

	return $options;
}

function patch_capitalize_headings( $value, $selector, $property, $unit ) {

	$result = $value ? 'uppercase' : 'none';

	$output = $selector .'{
		text-transform: ' . $result . ";\n" .
	"}\n";

	return $output;
}

function patch_navigation_items_spacing_cb( $value, $selector, $property, $unit ) {

	$output = '';

	$output .= '.nav--main li' . '{ ' . $property . ': ' . $value . $unit . '; }';

	$output .= '@media only screen and (min-width: 900px) { ';
	$output .= '.single .nav--main > li,
				.page .nav--main > li,
				.no-posts .nav--main > li' . '{ ' . $property . ': ' . 2 * $value . $unit . '; }';
	$output .= '}';

	return $output;
}

function patch_navigation_items_spacing_cb_customizer_preview() {
	$js = '';

	$js .= "
function patch_navigation_items_spacing_cb( value, selector, property, unit ) {

			var css = '',
				style = document.getElementById('patch_navigation_items_spacing_cb_style_tag'),
				head = document.head || document.getElementsByTagName('head')[0];

			css += '.nav--main li { margin-bottom: ' + value + unit + '; }';

			css += '@media not screen and (min-width: 900px) {';
			css += '.nav--main ul { margin-top: ' + value + unit + '; }';
			css += '}';

			css += '@media only screen and (min-width: 900px) { ';
			css += '.single .nav--main > li, .page .nav--main > li, .no-posts .nav--main > li' + '{ margin-bottom: ' + 2 * value + unit + '; }';
			css += '}';

			if ( style !== null ) {
				style.innerHTML = css;
			} else {
				style = document.createElement('style');
				style.setAttribute('id', 'patch_navigation_items_spacing_cb_style_tag');

				style.type = 'text/css';
				if ( style.styleSheet ) {
					style.styleSheet.cssText = css;
				} else {
					style.appendChild(document.createTextNode(css));
				}

				head.appendChild(style);
			}
		}" . PHP_EOL;

	wp_add_inline_script( 'customify-previewer-scripts', $js );
}
add_action( 'customize_preview_init', 'patch_navigation_items_spacing_cb_customizer_preview', 20 );

function patch_hide_back_to_top( $value, $selector, $property, $unit ) {

	$output = '';

	if ( $value ) {
		$output = $selector . '{ display: none }';
	}

	return $output;
}

function patch_content_sides_spacing( $value, $selector, $property, $unit ) {

	$output = '';

	$output .= '@media only screen and (min-width: 1260px) {';

	$output .=
		'.single .site-main, 
		.page:not(.entry-card) .site-main,
		.no-posts .site-main { ' .
			'padding-left: ' . $value . $unit . ';' .
			'padding-right: ' . $value . $unit . ';' .
		'}';

	$output .=
		'.single .entry-image--portrait .entry-featured,
		.single .entry-image--tall .entry-featured, 
		.page:not(.entry-card) .entry-image--portrait .entry-featured, 
		.page:not(.entry-card) .entry-image--tall .entry-featured { ' .
			'margin-left: ' . (-1 * $value) . $unit . ';' .
        '}';

	$output .= '.single .entry-image--landscape .entry-featured,
				.single .entry-image--wide .entry-featured,
				.page:not(.entry-card) .entry-image--landscape .entry-featured,
				.page:not(.entry-card) .entry-image--wide .entry-featured { ' .
		           'margin-left: ' . (-1 * $value) . $unit . ';' .
		           'margin-right: ' . (-1 * $value) . $unit . ';' .
           ' }';

	$output .= '}';

	return $output;
}

/**
 * Outputs the inline JS code used in the Customizer for the aspect ratio live preview.
 */
function patch_content_sides_spacing_customizer_preview() {
	$js = '';

	$js .= "
function patch_content_sides_spacing( value, selector, property, unit ) {

			var css = '',
				style = document.getElementById('patch_content_sides_spacing_style_tag'),
				head = document.head || document.getElementsByTagName('head')[0];

			css += '@media only screen and (min-width: 1260px) {';

			css += '.single .site-main,' +
			       '.page:not(.entry-card) .site-main,' +
			       '.no-posts .site-main { ' +
			            'padding-left: ' + value + unit + ';' +
						'padding-right: ' + value + unit + ';' +
			       '}';

			css += '.single .entry-image--portrait .entry-featured,' +
			       '.single .entry-image--tall .entry-featured,' +
			       '.page:not(.entry-card) .entry-image--portrait .entry-featured,' +
			       '.page:not(.entry-card) .entry-image--tall .entry-featured { ' +
			            'margin-left: ' + (-1 * value) + unit + ';' +
			       ' }';

			css += '.single .entry-image--landscape .entry-featured,' +
		           '.single .entry-image--wide .entry-featured,' +
			       '.page:not(.entry-card) .entry-image--landscape .entry-featured,' +
			       '.page:not(.entry-card) .entry-image--wide .entry-featured { ' +
						'margin-left: ' + (-1 * value) + unit + ';' +
						'margin-right: ' + (-1 * value) + unit + ';' +
					' }';

			css += '}';

			if ( style !== null ) {
				style.innerHTML = css;
			} else {
				style = document.createElement('style');
				style.setAttribute('id', 'patch_content_sides_spacing_style_tag');

				style.type = 'text/css';
				if ( style.styleSheet ) {
					style.styleSheet.cssText = css;
				} else {
					style.appendChild(document.createTextNode(css));
				}

				head.appendChild(style);
			}
		}" . PHP_EOL;

	wp_add_inline_script( 'customify-previewer-scripts', $js );
}
add_action( 'customize_preview_init', 'patch_content_sides_spacing_customizer_preview', 20 );


if ( ! function_exists('patch_dropcap_text_shadow') ) {
	function patch_dropcap_text_shadow( $value, $selector, $property, $unit ) {
		$output = $selector . '{
			text-shadow: 2px 2px 0 var(--box-shadow-color), 4px 4px 0 ' . $value . ";\n".
		          "}\n";
		return $output;
	}

	function patch_dropcap_text_shadow_customizer_preview() { ?>
        <script type="text/javascript">
			function patch_dropcap_text_shadow( value, selector, property, unit ) {

				var css = '',
					style = document.getElementById('patch_dropcap_text_shadow_style_tag'),
					head = document.head || document.getElementsByTagName('head')[0];

				css += selector + ' { text-shadow: 2px 2px 0 var(--box-shadow-color), 4px 4px 0  ' + value + '; } ';

				if ( style !== null ) {
					style.innerHTML = css;
				} else {
					style = document.createElement('style');
					style.setAttribute('id', 'patch_dropcap_text_shadow_style_tag');

					style.type = 'text/css';
					if ( style.styleSheet ) {
						style.styleSheet.cssText = css;
					} else {
						style.appendChild(document.createTextNode(css));
					}

					head.appendChild(style);
				}
			}
        </script>
	<?php }
	add_action( 'customize_preview_init', 'patch_dropcap_text_shadow_customizer_preview' );
}

if ( ! function_exists('patch_link_box_shadow') ) {
	function patch_link_box_shadow( $value, $selector, $property, $unit ) {
		$output = $selector . '{
			box-shadow: inset 0 -3px 0 ' . $value . ";\n".
		          "}\n";
		return $output;
	}
}

if ( ! function_exists('patch_links_box_shadow_cb') ) {
	function patch_links_box_shadow_cb( $value, $selector, $property, $unit ) {

        $output = '.single .entry-content a, .page:not(.entry-card) .entry-content a {
            box-shadow: ' . $value . " 0 0.85em inset;\n" .
        "}\n" .

        $output = '.nav--main li[class*="current-menu"] > a, .nav--main li:hover > a {
            box-shadow: ' . $value . " 0 24px inset;\n" .
        "}\n" .

        "@media only screen and (min-width: 900px) {" .
            '.nav--main ul li[class*="current-menu"] > a, .nav--main ul li:hover > a {
                box-shadow: ' . $value . " 0 16px inset;\n" .
            "}\n" .
        "}\n";
		return $output;
	}
}

if ( ! function_exists('patch_links_box_shadow_cb_customizer_preview') ) {
	function patch_links_box_shadow_cb_customizer_preview() {
		$js = '';

		$js .= "
function patch_links_box_shadow_cb(value, selector, property, unit) {

                var css = '',
                    style = document.getElementById('patch_links_box_shadow_cb_style_tag'),
                    head = document.head || document.getElementsByTagName('head')[0];

                css += '.single .entry-content a, .page:not(.entry-card) .entry-content a { box-shadow: ' + value + ' 0 0.85em inset; } ';
                css += '.nav--main li[class*=\"current-menu\"] > a, .nav--main li:hover > a { box-shadow: ' + value + ' 0 24px inset; } ';
                css += '@media only screen and (min-width: 900px) {';
                css += '.nav--main ul li[class*=\"current-menu\"] > a, .nav--main ul li:hover > a { box-shadow: ' + value + ' 0 16px inset; } ';
                css += '}';

                if (style !== null) {
                    style.innerHTML = css;
                } else {
                    style = document.createElement('style');
                    style.setAttribute('id', 'patch_links_box_shadow_cb_style_tag');

                    style.type = 'text/css';
                    if (style.styleSheet) {
                        style.styleSheet.cssText = css;
                    } else {
                        style.appendChild(document.createTextNode(css));
                    }

                    head.appendChild(style);
                }
            }" . PHP_EOL;

		wp_add_inline_script( 'customify-previewer-scripts', $js );
	}
}
add_action( 'customize_preview_init', 'patch_links_box_shadow_cb_customizer_preview', 20 );
