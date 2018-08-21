<?php
/**
 * Patch functions and definitions
 *
 * @package Patch
 * @since Patch 1.0
 */

if ( ! function_exists( 'patch_lite_setup' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function patch_lite_setup() {

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Patch, use a find and replace
		 * to change 'patch' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'patch-lite', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		//used as featured image for posts on home page and archive pages
		add_image_size( 'patch-masonry-image', 640, 9999, false );

		//used for the single post featured image
		add_image_size( 'patch-single-image', 1024, 9999, false );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' 	=> __( 'Primary Menu', 'patch-lite' ),
		) );

		/*
		 * Switch default core markup for comment form, galleries and captions
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'comment-form',
			'gallery',
			'caption',
		) );

		if ( ! function_exists( 'the_custom_logo' ) ) {
			//in case we are on a WP version older than 4.5, try to use Jetpack's Site Logo feature
			/**
			 * Add theme support for site logo
			 *
			 * First, it's the image size we want to use for the logo thumbnails
			 * Second, the 2 classes we want to use for the "Display Header Text" Customizer logic
			 */
			add_theme_support( 'site-logo', array(
				'size'        => 'patch-site-logo',
				'header-text' => array(
					'site-title',
					'site-description-text',
				)
			) );
		}

		add_image_size( 'patch-site-logo', 1000, 500, false );

		/*
		 * Add editor custom style to make it look more like the frontend
		 * Also enqueue the custom Google Fonts also
		 */
		add_editor_style( array( 'editor-style.css', patch_lite_fonts_url() ) );
	}
endif;
add_action( 'after_setup_theme', 'patch_lite_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function patch_lite_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'patch_content_width', 980, 0 );
}
add_action( 'after_setup_theme', 'patch_lite_content_width', 0 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since Patch 1.2.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function patch_lite_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	//only do this for single posts, not the archives
	if ( is_single() ) {
		764 <= $width && $sizes = '(max-width: 620px) 100vw, (max-width: 899px) 620px, 764px';
		764 > $width && 620 <= $width && $sizes = '(max-width: 620px) 100vw, (max-width: 899px) 620px, ' . $width . 'px';
		620 > $width && $sizes = '(max-width: ' . $width . 'px) 100vw, ' . $width . 'px';
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'patch_lite_content_image_sizes_attr', 10 , 2 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @since Patch 1.2.0
 *
 * @param array $attr Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return array
 */
function patch_lite_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	//only do this for featured images, not all images
	if ( 'post-thumbnail' === $size || 'patch-single-image' === $size ) {
		$attr['sizes'] = '(max-width: 679px) 100vw, (max-width: 899px) 668px, (max-width: 1079px) 50vw, (max-width: 1259px) 620px, (max-width: 1449px) 66vw, 980px';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'patch_lite_post_thumbnail_sizes_attr', 10 , 3 );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function patch_lite_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'patch-lite' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}

add_action( 'widgets_init', 'patch_lite_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function patch_lite_scripts() {
	//FontAwesome Stylesheet
	wp_enqueue_style( 'patch-lite-font-awesome-style', get_template_directory_uri() . '/assets/css/font-awesome.css', array(), '4.3.0' );

	//Main Stylesheet
	wp_enqueue_style( 'patch-style', get_template_directory_uri() . '/style.css', array( 'patch-lite-font-awesome-style' ) );

	//Default Fonts
	wp_enqueue_style( 'patch-fonts', patch_lite_fonts_url(), array(), null );

	//Register ImagesLoaded plugin
	wp_register_script( 'patch-lite-imagesloaded', get_template_directory_uri() . '/assets/js/imagesloaded.js', array(), '3.1.8', true );

	//Register Velocity.js plugin
	wp_register_script( 'patch-lite-velocity', get_template_directory_uri() . '/assets/js/velocity.js', array(), '1.2.2', true );

	//Register Magnific Popup plugin
	wp_register_script( 'patch-lite-magnificpopup', get_template_directory_uri() . '/assets/js/magnificpopup.js', array(), '1.0.0', true );

	//Enqueue Patch Custom Scripts
	wp_enqueue_script( 'patch-scripts', get_template_directory_uri() . '/assets/js/main.js', array(
		'jquery',
		'masonry',
		'patch-lite-imagesloaded',
		'patch-lite-velocity',
		'patch-lite-magnificpopup',
	), '1.3.4', true );

	$js_url = ( is_ssl() ) ? 'https://v0.wordpress.com/js/videopress.js' : 'http://s0.videopress.com/js/videopress.js';
	wp_enqueue_script( 'videopress', $js_url, array( 'jquery', 'swfobject' ), '1.09' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'patch_lite_scripts' );


/**
 * Freemius Integration
 */
// Create a helper function for easy SDK access.
function patchlitefreemius() {
    global $patchlitefreemius;

    if ( ! isset( $patchlitefreemius ) ) {
        // Include Freemius SDK.
        require_once dirname(__FILE__) . '/freemius/start.php';

        $patchlitefreemius = fs_dynamic_init( array(
            'id'                  => '2216',
            'slug'                => 'patch-lite',
            'type'                => 'theme',
            'public_key'          => 'pk_1689bcde9c6dbd09683191af23796',
            'is_premium'          => false,
            'has_addons'          => false,
            'has_paid_plans'      => false,
            'menu'                => array(
                'slug'           => 'patch-lite-welcome',
                'account'        => false,
                'contact'        => false,
                'support'        => false,
                'parent'         => array(
                    'slug' => 'themes.php',
                ),
            ),
        ) );
    }

    return $patchlitefreemius;
}

// Init Freemius.
patchlitefreemius();
// Signal that SDK was initiated.
do_action( 'patchlitefreemius_loaded' );


/**
 * MB string functions for when the MB library is not available
 */
require get_template_directory() . '/inc/mb_compat.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Load the Hybrid Media Grabber class
 */
require get_template_directory() . '/inc/hybrid-media-grabber.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Theme About page.
 */
require get_template_directory() . '/inc/admin/about-page.php';

require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'patch_lite_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function patch_lite_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		array(
			'name'      => 'WPForms Lite',
			'slug'      => 'wpforms-lite',
			'required'  => false,
		),
	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 */
	$config = array(
		'id'           => 'patch-lite',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}

/**
 * Set the WPForms ShareASale ID.
 *
 * @param string $shareasale_id The the default ShareASale ID.
 *
 * @return string $shareasale_id
 */
function patch_lite_wpforms_shareasale_id( $shareasale_id ) {

	// If this WordPress installation already has an WPForms ShareASale ID
	// specified, use that.
	if ( ! empty( $shareasale_id ) ) {
		return $shareasale_id;
	}

	// Define the ShareASale ID to use.
	$shareasale_id = '1843354';

	// This WordPress installation doesn't have an ShareASale ID specified, so
	// set the default ID in the WordPress options and use that.
	update_option( 'wpforms_shareasale_id', $shareasale_id );

	// Return the ShareASale ID.
	return $shareasale_id;
}
add_filter( 'wpforms_shareasale_id', 'patch_lite_wpforms_shareasale_id' );

?>