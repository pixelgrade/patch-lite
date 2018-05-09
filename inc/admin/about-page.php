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
					'title'       => esc_html__( 'Exquisite Design', 'patch-lite' ),
					'description' => esc_html__( 'Design is a great way to share appealing stories. Patch helps you to become a better storyteller into the digital world. Thanks to a very human approach in terms of interaction, a gentle and eye-candy typography and stylish details, you can definitely reach the right audience.', 'patch-lite' ),
					'is_in_lite'  => 'true',
					'is_in_pro'   => 'true',
				),
				array(
					'title'       => esc_html__( 'Steady SEO', 'patch-lite' ),
					'description' => esc_html__( 'We’ve made everything it requires in terms of SEO practices so that you can have a proper start. In the end, everyone has a thing for how they show up in search engines.', 'patch-lite' ),
					'is_in_lite'  => 'true',
					'is_in_pro'   => 'true',
				),
				array(
					'title'       => esc_html__( 'Mobile-Ready and Responsive for All Devices', 'patch-lite' ),
					'description' => esc_html__( 'One of the perks of living these days is the tremendous chance to stay connected with everything you love without boundaries. That’s why HIVE is mobile-ready and facilitates your users to easily enjoy your content, no matter the device they like to use on a daily basis.', 'patch-lite' ),
					'is_in_lite'  => 'true',
					'is_in_pro'   => 'true',
				),
				array(
					'title'       => esc_html__( 'Smart and Customizable Type', 'patch-lite' ),
					'description' => esc_html__( 'Patch‘s elements all fit together seamlessly, and we’ve created a way to emphasize specific portions of your post and page titles.', 'patch-lite' ),
					'is_in_lite'  => 'true',
					'is_in_pro'   => 'true',
				),
				array(
					'title'       => esc_html__( 'Social Integration', 'patch-lite' ),
					'description' => esc_html__( 'Let your voice be heard by the right people. Aim to build a strong community around your fashion blog and start a smart dialogue with those who admire your work. Facebook, Twitter, Instagram, you name it, but be aware that all can boost your content and increase awareness.', 'patch-lite' ),
					'is_in_lite'  => 'false',
					'is_in_pro'   => 'true',
				),
				array(
					'title'       => esc_html__( 'Personalize to Match Your Style', 'patch-lite' ),
					'description' => esc_html__( 'Having different tastes and preferences might be tricky for users, but not with Patch onboard. It has an intuitive and catchy interface which allows you to change fonts, colors or layout sizes in a blink of an eye.', 'patch-lite' ),
					'is_in_lite'  => 'false',
					'is_in_pro'   => 'true',
				),
				array(
					'title'       => esc_html__( 'Adaptive Layouts For Your Posts', 'patch-lite' ),
					'description' => esc_html__( 'We offer you the freedom to mix-and-match portrait images or long titles to bring extra value. Whether your featured image is in portrait or landscape mode, Patch takes care of it by changing the post layout to provide the right fit.', 'patch-lite' ),
					'is_in_lite'  => 'false',
					'is_in_pro'   => 'true',
				),
				array(
					'title'       => esc_html__( 'Post Formats', 'patch-lite' ),
					'description' => esc_html__( 'Make room for a wide range of post formats to pack your engaging stories so that people will enjoy sharing. Text, image, video, audio—you name it, and you’re covered.', 'patch-lite' ),
					'is_in_lite'  => 'false',
					'is_in_pro'   => 'true',
				),
				array(
					'title'       => __( 'Support Best-In-Business', 'patch-lite' ),
					'description' => __( 'You will benefit by priority support from a caring and devoted team, eager to help and to spread happiness. We work hard to provide a flawless experience for those who vote us with trust and choose to be our special clients.','patch-lite' ),
					'is_in_lite'  => 'false',
					'is_in_pro'   => 'true',
				),
				array(
					'title'       => esc_html__( 'Comprehensive Help Guide', 'patch-lite' ),
					'description' => esc_html__( 'Extensive documentation that will help you get your site up quickly and seamlessly.', 'patch-lite' ),
					'is_in_lite'  => 'false',
					'is_in_pro'   => 'true',
				),
				array(
					'title'       => esc_html__( 'No credit footer link', 'patch-lite' ),
					'description' => esc_html__( 'Remove "Theme: Patch Lite by Pixelgrade" copyright from the footer area.', 'patch-lite' ),
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
