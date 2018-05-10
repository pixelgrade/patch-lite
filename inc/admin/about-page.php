<?php
/**
 * Patch Lite Theme About Page logic.
 *
 * @package Patch Lite
 */

function patchlite_admin_setup() {
	/**
	 * Load the About page class
	 */
	require_once 'ti-about-page/class-ti-about-page.php';

	/*
	* About page instance
	*/
	$config = array(
		// Menu name under Appearance.
		'menu_name'               => esc_html__( 'About Patch Lite', 'patch-lite' ),
		// Page title.
		'page_name'               => esc_html__( 'About Patch Lite', 'patch-lite' ),
		// Main welcome title
		'welcome_title'         => sprintf( esc_html__( 'Welcome to %s! - Version ', 'patch-lite' ), 'Patch Lite' ),
		// Main welcome content
		'welcome_content'       => esc_html__( ' Patch Lite is a free magazine-style theme with clean type, smart layouts and a design flexibility that makes it perfect for publishers of all kinds.', 'patch-lite' ),
		/**
		 * Tabs array.
		 *
		 * The key needs to be ONLY consisted from letters and underscores. If we want to define outside the class a function to render the tab,
		 * the will be the name of the function which will be used to render the tab content.
		 */
		'tabs'                    => array(
			'getting_started'  => esc_html__( 'Getting Started', 'patch-lite' ),
			'recommended_actions' => esc_html__( 'Recommended Actions', 'patch-lite' ),
			'recommended_plugins' => esc_html__( 'Useful Plugins','patch-lite' ),
			'support'       => esc_html__( 'Support', 'patch-lite' ),
			'changelog'        => esc_html__( 'Changelog', 'patch-lite' ),
			'free_pro'         => esc_html__( 'Free VS PRO', 'patch-lite' ),
		),
		// Support content tab.
		'support_content'      => array(
			'first' => array (
				'title' => esc_html__( 'Contact Support','patch-lite' ),
				'icon' => 'dashicons dashicons-sos',
				'text' => __( 'We want to make sure you have the best experience using Patch Lite. If you <strong>do not have a paid upgrade</strong>, please post your question in our community forums.','patch-lite' ),
				'button_label' => esc_html__( 'Contact Support','patch-lite' ),
				'button_link' => esc_url( 'https://wordpress.org/support/theme/patch-lite' ),
				'is_button' => true,
				'is_new_tab' => true
			),
			'second' => array(
				'title' => esc_html__( 'Documentation','patch-lite' ),
				'icon' => 'dashicons dashicons-book-alt',
				'text' => esc_html__( 'Need more details? Please check our full documentation for detailed information on how to use Patch Lite.','patch-lite' ),
				'button_label' => esc_html__( 'Read The Documentation','patch-lite' ),
				'button_link' => 'https://pixelgrade.com/patch-lite-documentation/',
				'is_button' => false,
				'is_new_tab' => true
			)
		),
		// Getting started tab
		'getting_started' => array(
			'first' => array(
				'title' => esc_html__( 'Go to Customizer','patch-lite' ),
				'text' => esc_html__( 'Using the WordPress Customizer you can easily customize every aspect of the theme.','patch-lite' ),
				'button_label' => esc_html__( 'Go to Customizer','patch-lite' ),
				'button_link' => esc_url( admin_url( 'customize.php' ) ),
				'is_button' => true,
				'recommended_actions' => false,
				'is_new_tab' => true
			),
			'second' => array (
				'title' => esc_html__( 'Recommended actions','patch-lite' ),
				'text' => esc_html__( 'We have compiled a list of steps for you, to take make sure the experience you will have using one of our products is very easy to follow.','patch-lite' ),
				'button_label' => esc_html__( 'Recommended actions','patch-lite' ),
				'button_link' => esc_url( admin_url( 'themes.php?page=patch-lite-welcome&tab=recommended_actions' ) ),
				'button_ok_label' => esc_html__( 'You are good to go!','patch-lite' ),
				'is_button' => false,
				'recommended_actions' => true,
				'is_new_tab' => false
			),
			'third' => array(
				'title' => esc_html__( 'Read the documentation','patch-lite' ),
				'text' => esc_html__( 'Need more details? Please check our full documentation for detailed information on how to use Patch Lite.','patch-lite' ),
				'button_label' => esc_html__( 'Documentation','patch-lite' ),
				'button_link' => 'https://pixelgrade.com/patch-lite-documentation/',
				'is_button' => false,
				'recommended_actions' => false,
				'is_new_tab' => true
			)
		),
		// Free vs pro array.
		'free_pro'                => array(
			'free_theme_name'     => 'Patch Lite',
			'pro_theme_name'      => 'Patch PRO',
			'pro_theme_link'      => 'https://pixelgrade.com/themes/patch-lite/?utm_source=patch-lite-clients&utm_medium=about-page&utm_campaign=patch-lite#pro',
			'get_pro_theme_label' => sprintf( __( 'View %s', 'patch-lite' ), 'Patch Pro' ),
			'features'            => array(
				array(
					'title'       => esc_html__( 'Daring Design for Devoted Readers', 'patch-lite' ),
					'description' => esc_html__( 'With a unique grid layout, balanced range of diverse post layouts, and thoughtful choice of type and whitespace, Patch has a sharp and lightweight look. Precise animations set the right tone for your stories.', 'patch-lite' ),
					'is_in_lite'  => 'true',
					'is_in_pro'   => 'true',
				),
				array(
					'title'       => esc_html__( 'Mobile-Ready For All Devices', 'patch-lite' ),
					'description' => esc_html__( 'Patch makes room for your readers to enjoy your articles on the go, no matter the device their using. We lend a hand by showcasing it beautifully to your audience.', 'patch-lite' ),
					'is_in_lite'  => 'true',
					'is_in_pro'   => 'true',
				),
				array(
					'title'       => esc_html__( 'Widgetized Sidebar To Keep Attention', 'patch-lite' ),
					'description' => esc_html__( 'Patch allows you to add your favorite widgets to the right side of your articles. Newsletter, categories, comments, you have them all at your fingertips.', 'patch-lite' ),
					'is_in_lite'  => 'true',
					'is_in_pro'   => 'true',
				),
				array(
					'title'       => esc_html__( 'Social Icons for Stronger Bonds', 'patch-lite' ),
					'description' => esc_html__( 'Patch\'s your go-to product if you really care about being easy to found on social media. By using them you could efficiently direct your audience towards your social activity where they can connect with you and become loyal followers.', 'patch-lite' ),
					'is_in_lite'  => 'false',
					'is_in_pro'   => 'true',
				),
				array(
					'title'       => esc_html__( 'Smart Layouts For Your Content', 'patch-lite' ),
					'description' => esc_html__( 'Based on a smart grid, a well balanced range of diverse post layouts, and a thoughtful choice of type and whitespace, Patch assures a harmonious and clean look that your readers will thank you for.', 'patch-lite' ),
					'is_in_lite'  => 'false',
					'is_in_pro'   => 'true',
				),
				array(
					'title'       => esc_html__( 'Adaptive Layouts For Your Posts', 'patch-lite' ),
					'description' => esc_html__( 'Patch adjusts the post layout so that you can display the featured image in portrait and landscape mode by the blink of an eye. This way, you can always make the most out of your visual look-and-feel.', 'patch-lite' ),
					'is_in_lite'  => 'false',
					'is_in_pro'   => 'true',
				),
				array(
					'title'       => esc_html__( 'Post Formats for Those Special Moments', 'patch-lite' ),
					'description' => esc_html__( 'Patch makes the most out of the wide range of post formats to help you pack your stories beautifully. Text, image, video, audio, everything works flawlessly.', 'patch-lite' ),
					'is_in_lite'  => 'false',
					'is_in_pro'   => 'true',
				),
				array(
					'title'       => esc_html__( 'Advanced Text Styles', 'patch-lite' ),
					'description' => esc_html__( 'Style your content even more with type options for dropcaps, pull quotes, highlight text or leading paragraph.', 'patch-lite' ),
					'is_in_lite'  => 'false',
					'is_in_pro'   => 'true',
				),
				array(
					'title'       => esc_html__( 'Premium Support and Assistance', 'patch-lite' ),
					'description' => esc_html__( 'We offer customer support and assistance to help you get the best results in due time. We know our products inside-out and we can lend a hand to help you save resources of all kinds.','patch-lite' ),
					'is_in_lite'  => 'false',
					'is_in_pro'   => 'true',
				),
				array(
					'title'       => esc_html__( 'Friendly Self-Service', 'patch-lite' ),
					'description' => esc_html__( 'We give you full access to an in-depth documentation to get the job done as quickly as possible. We don\'t stay in your way because we know you can make it too.', 'patch-lite' ),
					'is_in_lite'  => 'false',
					'is_in_pro'   => 'true',
				),
				array(
					'title'       => esc_html__( 'No Credit Footer Link', 'patch-lite' ),
					'description' => esc_html__( 'You can easily remove the “Theme: Patch Lite by Pixelgrade” copyright from the footer area and make the theme yours from start to finish.', 'patch-lite' ),
					'is_in_lite'  => 'false',
					'is_in_pro'   => 'true',
				)
			),
		),
		// Plugins array.
		'recommended_plugins'        => array(
			'already_activated_message' => esc_html__( 'Already activated', 'patch-lite' ),
			'version_label' => esc_html__( 'Version: ', 'patch-lite' ),
			'install_label' => esc_html__( 'Install and Activate', 'patch-lite' ),
			'activate_label' => esc_html__( 'Activate', 'patch-lite' ),
			'deactivate_label' => esc_html__( 'Deactivate', 'patch-lite' ),
			'content'                   => array(
				array(
					'slug' => 'jetpack'
				),
				array(
					'slug' => 'wordpress-seo'
				),
//				array(
//					'slug' => 'gridable'
//				)
			),
		),
		// Required actions array.
		'recommended_actions'        => array(
			'install_label' => esc_html__( 'Install and Activate', 'patch-lite' ),
			'activate_label' => esc_html__( 'Activate', 'patch-lite' ),
			'deactivate_label' => esc_html__( 'Deactivate', 'patch-lite' ),
			'content'            => array(
				'jetpack' => array(
					'title'       => 'Jetpack',
					'description' => __( 'It is highly recommended that you install Jetpack so you can enable the <b>Portfolio</b> content type for adding and managing your projects. Plus, Jetpack provides a whole host of other useful things for you site.', 'patch-lite' ),
					'check'       => defined( 'JETPACK__VERSION' ),
					'plugin_slug' => 'jetpack',
					'id' => 'jetpack'
				),
			),
		),
	);
	TI_About_Page::init( $config );
}
add_action('after_setup_theme', 'patchlite_admin_setup');
