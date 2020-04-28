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
			'primary' 	=> esc_html__( 'Primary Menu', 'patch-lite' ),
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

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'gallery',
			'image',
			'audio',
			'video',
			'quote',
			'link',
		) );

		/*
		 * Enable support for custom logo.
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 500,
			'width'       => 1000,
			'flex-height' => true,
			'header-text' => array(
				'site-title',
				'site-description-text',
			)
		) );

		add_image_size( 'patch-site-logo', 1000, 500, false );

		/*
		 * Add editor custom style to make it look more like the frontend
		 * Also enqueue the custom Google Fonts also
		 */
		add_editor_style( array( 'editor-style.css', patch_lite_fonts_url() ) );

		/**
		 * Enable support for the Style Manager Customizer section (via Customify).
		 */
		add_theme_support( 'customizer_style_manager' );
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
		'name'          => esc_html__( 'Sidebar', 'patch-lite' ),
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
	$theme = wp_get_theme( get_template() );

	// FontAwesome Stylesheet
	wp_register_style( 'patch-lite-font-awesome-style', get_template_directory_uri() . '/assets/css/font-awesome.css', array(), '4.3.0' );

	// Main Stylesheet
	wp_enqueue_style( 'patch-style', get_template_directory_uri() . '/style.css', array( 'patch-lite-font-awesome-style' ), $theme->get( 'Version' ) );
	wp_style_add_data( 'patch-style', 'rtl', 'replace' );

	// Default Fonts
	wp_enqueue_style( 'patch-fonts', patch_lite_fonts_url(), array(), null );

	// Register Velocity.js plugin
	wp_register_script( 'patch-lite-velocity', get_template_directory_uri() . '/assets/js/velocity.js', array(), '1.2.2', true );

	// Register Magnific Popup plugin
	wp_register_script( 'patch-lite-magnificpopup', get_template_directory_uri() . '/assets/js/magnificpopup.js', array(), '1.0.0', true );

	// Enqueue Patch Custom Scripts
	wp_enqueue_script( 'patch-scripts', get_template_directory_uri() . '/assets/js/main.js', array(
		'jquery',
		'masonry',
		'imagesloaded',
		'patch-lite-velocity',
		'patch-lite-magnificpopup',
	), $theme->get( 'Version' ), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'patch_lite_scripts' );

function patch_lite_gutenberg_styles() {
	wp_enqueue_style( 'patch-lite-gutenberg', get_theme_file_uri( '/editor.css' ), false );

	wp_enqueue_style( 'patch-lite-google-fonts', patch_lite_fonts_url() );
}

add_action( 'enqueue_block_editor_assets', 'patch_lite_gutenberg_styles' );

/**
 * MB string functions for when the MB library is not available
 */
require_once trailingslashit( get_template_directory() ) . 'inc/mb_compat.php';

/**
 * Custom template tags for this theme.
 */
require_once trailingslashit( get_template_directory() ) . 'inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require_once trailingslashit( get_template_directory() ) . 'inc/extras.php';

/**
 * Load the Hybrid Media Grabber class
 */
require_once trailingslashit( get_template_directory() ) . 'inc/hybrid-media-grabber.php';

/**
 * Customizer additions.
 */
require_once trailingslashit( get_template_directory() ) . 'inc/customizer.php';

/**
 * Load various plugin integrations
 */
require_once trailingslashit( get_template_directory() ) . 'inc/integrations.php';

/**
 * Admin dashboard related logic.
 */
require_once trailingslashit( get_template_directory() ) . 'inc/admin.php';
