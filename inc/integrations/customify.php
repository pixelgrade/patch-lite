<?php
/**
 * Add extra controls in the Customizer
 *
 * @package Patch Lite
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
add_filter( 'customify_filter_fields', 'patch_lite_add_customify_options', 11, 1 );
add_filter( 'customify_filter_fields', 'patch_lite_add_customify_style_manager_section', 12, 1 );

add_filter( 'customify_filter_fields', 'patch_lite_fill_customify_options', 20 );

// Color Constants
define( 'PATCHLITE_SM_COLOR_PRIMARY', '#ffeb00' );
define( 'PATCHLITE_SM_COLOR_SECONDARY', '#cae00f' );
define( 'PATCHLITE_SM_COLOR_TERTIARY', '#bbd916' );

define( 'PATCHLITE_SM_DARK_PRIMARY', '#161a03' );
define( 'PATCHLITE_SM_DARK_SECONDARY', '#2a2c29' );
define( 'PATCHLITE_SM_DARK_TERTIARY', '#7e8073' );

define( 'PATCHLITE_SM_LIGHT_PRIMARY', '#ffffff' );
define( 'PATCHLITE_SM_LIGHT_SECONDARY', '#fcfcf5' );
define( 'PATCHLITE_SM_LIGHT_TERTIARY', '#f4f7e6' );


function patch_lite_add_customify_options( $options ) {
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
function patch_lite_add_customify_style_manager_section( $options ) {
	// If the theme hasn't declared support for style manager, bail.
	if ( ! current_theme_supports( 'customizer_style_manager' ) ) {
		return $options;
	}

	if ( ! isset( $options['sections']['style_manager_section'] ) ) {
		$options['sections']['style_manager_section'] = array();
	}

	$new_config = array(
		'options' => array(

			// Color Palettes Assignment.
			'sm_color_primary'   => array(
				'connected_fields' => array(
					'accent_color',
					'patch_header_links_active_color',
					'main_content_body_link_color',
				),
				'default'          => PATCHLITE_SM_COLOR_PRIMARY
			),
			'sm_color_secondary' => array(
				'default' => PATCHLITE_SM_COLOR_SECONDARY
			),
			'sm_color_tertiary'  => array(
				'default' => PATCHLITE_SM_COLOR_TERTIARY
			),
			'sm_dark_primary'    => array(
				'connected_fields' => array(
					// medium
					'main_content_border_color',
					'main_content_body_link_default_color',

					// high
					'main_content_page_title_color',
					'main_content_heading_1_color',
					'blog_item_title_color',

					// striking
					'main_content_heading_2_color',
					'main_content_heading_3_color',
					'main_content_heading_4_color',

					// always dark
					'main_content_heading_5_color',
					'main_content_heading_6_color',
					'patch_header_navigation_links_color',
				),
				'default'          => PATCHLITE_SM_DARK_PRIMARY,
			),
			'sm_dark_secondary'  => array(
				'connected_fields' => array(
					// always dark
					'main_content_body_text_color',
				),
				'default'          => PATCHLITE_SM_DARK_SECONDARY,
			),
			'sm_dark_tertiary'   => array(
				'connected_fields' => array(),
				'default'          => PATCHLITE_SM_DARK_TERTIARY,
			),
			'sm_light_primary'   => array(
				'connected_fields' => array(
					'main_content_body_background_color',
					'patch_footer_body_text_color',
					'patch_footer_links_color',
				),
				'default'          => PATCHLITE_SM_LIGHT_PRIMARY,
			),
			'sm_light_secondary' => array(
				'default' => PATCHLITE_SM_LIGHT_SECONDARY,
			),
			'sm_light_tertiary'  => array(
				'default' => PATCHLITE_SM_LIGHT_TERTIARY,
			),
		),
	);

	// The section might be already defined, thus we merge, not replace the entire section config.
	if ( class_exists( 'Customify_Array' ) && method_exists( 'Customify_Array', 'array_merge_recursive_distinct' ) ) {
		$options['sections']['style_manager_section'] = Customify_Array::array_merge_recursive_distinct( $options['sections']['style_manager_section'], $new_config );
	} else {
		$options['sections']['style_manager_section'] = array_merge_recursive( $options['sections']['style_manager_section'], $new_config );
	}

	return $options;
}

/**
 * Fill the Customify config.
 *
 * @param array $options The whole Customify config.
 *
 * @return array The modified Customify config.
 */
function patch_lite_fill_customify_options( $options ) {

	$new_config = array(

		// Header
		'header_section' => array(
			'title'    => '',
			'type'    => 'hidden',
			'options' => array(
				// [Section] COLORS
				'patch_header_navigation_links_color' => array(
					'type'    => 'hidden_control',
					'live'    => true,
					'default' => PATCHLITE_SM_DARK_PRIMARY,
					'css'     => array(
						array(
							'property' => 'color',
							'selector' => '.site-header a, .nav--social a:before, div#infinite-handle span, :first-child:not(input) ~ .form-submit #submit',
						),
					),
				),
				'patch_header_links_active_color'     => array(
					'type'    => 'hidden_control',
					'live'    => true,
					'default' => PATCHLITE_SM_COLOR_PRIMARY,
					'css'     => array(
						array(
							'property' => 'background-color',
							'selector' => '
							    .nav--main li:hover > a, 
							    .nav--social.nav--social a:hover:before, 
                                .nav--main li[class*="current-menu"] > a',
						),
					),
				),
			)
		),


		// Main Content
		'main_content_section' => array(
			'title'    => '',
			'type'    => 'hidden',
			'options' => array(
				// [Section] COLORS
				'main_content_border_color' => array(
					'type'    => 'hidden_control',
					'live'    => true,
					'default' => PATCHLITE_SM_DARK_PRIMARY,
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
				'main_content_page_title_color'         => array(
					'type'    => 'hidden_control',
					'live'    => true,
					'default' => PATCHLITE_SM_DARK_PRIMARY,
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
					'type'    => 'hidden_control',
					'live'    => true,
					'default' => PATCHLITE_SM_DARK_SECONDARY,
					'css'     => array(
						array(
							'property' => 'color',
							'selector' => 'body,
							               .pagination a, 
							               .pagination span,
							               .pagination span.current,
							               .pagination a:hover,
							               .page-numbers.prev, 
							               .page-numbers.next',
						),
						array(
							'property' => 'background-color',
							'selector' => '.entry-card .entry-image',
						),

						array(
							'property' => 'border-color',
							'selector' => '.pagination span.current,
							               .pagination a:hover',
						),
					),
				),
				'main_content_body_background_color'                                => array(
					'type'    => 'hidden_control',
					'live'    => true,
					'default' => PATCHLITE_SM_LIGHT_PRIMARY,
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
                                .add-comment .add-comment__button,
                                :first-child:not(input) ~ .form-submit #submit:hover,
                                .comments_add-comment:hover,
                                .entry-card:hover .cat-links a,
                                .cat-links a',
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
					'type'    => 'hidden_control',
					'live'    => true,
					'default' => PATCHLITE_SM_DARK_PRIMARY,
					'css'     => array(
						array(
							'property' => 'color',
							'selector' => 'a, .recentcomments a',
						),
					),
				),
				'main_content_body_link_color'          => array(
					'type'    => 'hidden_control',
					'live'    => true,
					'default' => PATCHLITE_SM_COLOR_PRIMARY,
					'css'     => array(
						array(
							'property' => 'background-color',
							'selector' => '.single .entry-content a:not([class]), 
							    .page .entry-content a:not([class])',
						),
					),
				),
				'accent_color'   => array(
					'type'    => 'hidden_control',
					'live' => true,
					'default'   => PATCHLITE_SM_COLOR_PRIMARY,
					'css'  => array(
						array(
							'property' => 'text-shadow',
							'selector' => '.dropcap',
							'callback_filter' => 'patch_dropcap_text_shadow'
						),
						array(
							'property' => 'box-shadow',
							'selector' => '.entry-card.format-quote .entry-content a:not([class])',
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
								.highlight,
								.sticky .sticky-post,
								.nav--social a:hover:before,
								.jetpack_subscription_widget input[type="submit"],
								.jetpack_subscription_widget button[type="submit"],
								.widget_blog_subscription input[type="submit"],
								.widget_blog_subscription button[type="submit"],
								.search-form .search-submit,
								div#infinite-handle span:after,
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
							'property' => 'background-color',
							'selector' => '.cat-links',
							'callback_filter' => 'patch_color_contrast',
						),
						array(
							'property' => 'border-top-color',
							'selector' => '.sticky .sticky-post:before,
								.sticky .sticky-post:after'
						)
					),
				),

				// [Sub Section] Headings Color
				'main_content_heading_1_color'          => array(
					'type'    => 'hidden_control',
					'live'    => true,
					'default' => PATCHLITE_SM_DARK_PRIMARY,
					'css'     => array(
						array(
							'property' => 'color',
							'selector' => 'h1, .site-title a',
						),
					),
				),
				'main_content_heading_2_color'          => array(
					'type'    => 'hidden_control',
					'live'    => true,
					'default' => PATCHLITE_SM_DARK_PRIMARY,
					'css'     => array(
						array(
							'property' => 'color',
							'selector' => 'h2, blockquote',
						),
					),
				),
				'main_content_heading_3_color'          => array(
					'type'    => 'hidden_control',
					'live'    => true,
					'default' => PATCHLITE_SM_DARK_PRIMARY,
					'css'     => array(
						array(
							'property' => 'color',
							'selector' => 'h3'
						),
					),
				),
				'main_content_heading_4_color'          => array(
					'type'    => 'hidden_control',
					'live'    => true,
					'default' => PATCHLITE_SM_DARK_PRIMARY,
					'css'     => array(
						array(
							'property' => 'color',
							'selector' => 'h4',
						),
					),
				),
				'main_content_heading_5_color'          => array(
					'type'    => 'hidden_control',
					'live'    => true,
					'default' => PATCHLITE_SM_DARK_PRIMARY,
					'css'     => array(
						array(
							'property' => 'color',
							'selector' => 'h5',
						),
					),
				),
				'main_content_heading_6_color'          => array(
					'type'    => 'hidden_control',
					'live'    => true,
					'default' => PATCHLITE_SM_DARK_PRIMARY,
					'css'     => array(
						array(
							'property' => 'color',
							'selector' => 'h6',
						),
					),
				),
			)
		),


		// Footer
		'footer_section' => array(
			'title'    => '',
			'type'    => 'hidden',
			'options' => array(

				// [Section] COLORS
				'patch_footer_body_text_color'       => array(
					'type'    => 'hidden_control',
					'live'    => true,
					'default' => PATCHLITE_SM_LIGHT_PRIMARY,
					'css'     => array(
						array(
							'property' => 'color',
							'selector' => '.site-footer',
						),
					),
				),
				'patch_footer_links_color'           => array(
					'type'    => 'hidden_control',
					'live'    => true,
					'default' => PATCHLITE_SM_LIGHT_PRIMARY,
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
			'title'    => '',
			'type'    => 'hidden',
			'options' => array(

				// [Section] COLORS
				'blog_item_title_color' => array(
					'type'    => 'hidden_control',
					'live'    => true,
					'default' => PATCHLITE_SM_DARK_PRIMARY,
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
			)
		),
	);

	if ( class_exists( 'Customify_Array' ) && method_exists( 'Customify_Array', 'array_merge_recursive_distinct' ) ) {
		$options['sections'] = Customify_Array::array_merge_recursive_distinct( $options['sections'], $new_config );
	} else {
		$options['sections'] = array_merge_recursive( $options['sections'], $new_config );
	}

	return $options;
}


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

        $output = '
        .single .entry-content a:not([class]), 
        .page:not(.entry-card) .entry-content a:not([class]) {
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
		$js = "
            function patch_links_box_shadow_cb(value, selector, property, unit) {

                var css = '',
                    style = document.getElementById('patch_links_box_shadow_cb_style_tag'),
                    head = document.head || document.getElementsByTagName('head')[0];

                css += '.single .entry-content a:not([class]), .page:not(.entry-card) .entry-content a:not([class]) { box-shadow: ' + value + ' 0 0.85em inset; } ';
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


// https://stackoverflow.com/questions/3942878/how-to-decide-font-color-in-white-or-black-depending-on-background-color
if ( ! function_exists( 'patch_color_contrast' ) ) {
	function patch_color_contrast( $value, $selector, $property, $unit ) {

		// Get our color
		if( empty($value) || ! preg_match('/^#[a-f0-9]{6}$/i', $value)) {
			return '';
		}

		$color = $value;
		// Calculate straight from RGB
		$r = hexdec( $color[0].$color[1] );
		$g = hexdec( $color[2].$color[3] );
		$b = hexdec( $color[4].$color[5] );

		$uicolors = array( $r / 255, $g / 255, $b / 255 );

		$c = array_map( function( $col ) {
		    if ( $col <= 0.03928 ) {
		        return $col / 12.92;
            }
            return pow( ( $col + 0.055 ) / 1.055, 2.4 );
        }, $uicolors );

		$L = ( 0.2126 * $c[0] ) + ( 0.7152 * $c[1] ) + ( 0.0722 * $c[2] );
        $color = ( $L > 0.179 ) ? '#000' : '#FFF';

		// if it is not a dark color, just go for the default way
		$output = $selector . ' {
			  color: ' . $color .';
			  background-color: ' . $value . ';
        }';

		return $output;
	}
}

if ( ! function_exists('patch_color_contrast_customizer_preview') ) {
    function patch_color_contrast_customizer_preview() {
		$js = "
            function patch_color_contrast(value, selector, property, unit) {
            
                var css = '',
                    style = document.getElementById( 'patch_color_contrast_style_tag' ),
                    head = document.head || document.getElementsByTagName('head')[0];
                    
                var hex = value.substring( 1 );  // strip #
                var rgb = parseInt( hex, 16 );   // convert rrggbb to decimal
                var r = ( rgb >> 16 ) & 0xff;  // extract red
                var g = ( rgb >>  8 ) & 0xff;  // extract green
                var b = ( rgb >>  0 ) & 0xff;  // extract blue
                var uicolors = [r / 255, g / 255, b / 255];
                
                var c = uicolors.map( function(col) {
                    if ( col <= 0.03928 ) {
                        return col / 12.92;
                    }
                    return Math.pow( ( col + 0.055 ) / 1.055, 2.4 );
                } );
                
                var L = ( 0.2126 * c[0] ) + ( 0.7152 * c[1] ) + ( 0.0722 * c[2] );
                var color = ( L > 0.179 ) ? '#000' : '#FFF';
                
                css = selector + ' { ' +
                    'color: ' + color + '; ' +
                    'background-color: ' + value + '; ' +
                '}'; 
                
                if ( style !== null ) {
                    style.innerHTML = css;
                } else {
                    style = document.createElement( 'style' );
                    style.setAttribute( 'id', 'patch_color_contrast_style_tag' );

                    style.type = 'text/css';
                    if ( style.styleSheet ) {
                        style.styleSheet.cssText = css;
                    } else {
                        style.appendChild( document.createTextNode( css ) );
                    }

                    head.appendChild( style );
                }
            }" . PHP_EOL;

		wp_add_inline_script( 'customify-previewer-scripts', $js );
	}
}
add_action( 'customize_preview_init', 'patch_color_contrast_customizer_preview', 20 );

function patch_lite_add_default_color_palette( $color_palettes ) {

	$color_palettes = array_merge(array(
		'default' => array(
			'label' => esc_html__( 'Theme Default', 'patch-lite' ),
			'preview' => array(
				'background_image_url' => 'https://cloud.pixelgrade.com/wp-content/uploads/2018/05/patch-theme-palette.jpg',
			),
			'options' => array(
				'sm_color_primary' => PATCHLITE_SM_COLOR_PRIMARY,
				'sm_color_secondary' => PATCHLITE_SM_COLOR_SECONDARY,
				'sm_color_tertiary' => PATCHLITE_SM_COLOR_TERTIARY,
				'sm_dark_primary' => PATCHLITE_SM_DARK_PRIMARY,
				'sm_dark_secondary' => PATCHLITE_SM_DARK_SECONDARY,
				'sm_dark_tertiary' => PATCHLITE_SM_DARK_TERTIARY,
				'sm_light_primary' => PATCHLITE_SM_LIGHT_PRIMARY,
				'sm_light_secondary' => PATCHLITE_SM_LIGHT_SECONDARY,
				'sm_light_tertiary' => PATCHLITE_SM_LIGHT_TERTIARY,
			),
		),
	), $color_palettes);

	return $color_palettes;
}
add_filter( 'customify_get_color_palettes', 'patch_lite_add_default_color_palette', 10, 1 );

