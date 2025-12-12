<?php
/**
 * Theme Prefix: Functions and Definitions
 *
 * @package   Theme_Name
 * @since     1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define the theme version if not already defined.
if ( ! defined( 'TH_VERSION' ) ) {
	define( 'TH_VERSION', '1.0' );
}
// Constants.
define( 'THEME_TEMP_URI', get_template_directory_uri() );
define( 'THEME_TEMP_DIR', get_template_directory() );

/**
 * Theme setup function.
 *
 * Sets up theme defaults and registers support for WordPress features.
 * Hooked into the 'after_setup_theme' action.
 *
 * @since 1.0.0
 * @return void
 */
function theme_prefix_setup() {

	// Add default RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// Enable support for <title> tag managed by WordPress.
	add_theme_support( 'title-tag' );

	// Enable support for post thumbnails (featured images).
	add_theme_support( 'post-thumbnails' );

	// Register navigation menus.
	register_nav_menus(
		array(
			'header-menu' => esc_html__( 'Header Menu', 'theme-textdomain' ),
			// Add new menu locations below if required.
		)
	);

	// Enable HTML5 markup support.
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Enable selective refresh for widgets in Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Enable support for the custom logo feature.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	// Enable support for block editor styles.
	add_theme_support( 'wp-block-styles' );

	// Registers custom image sizes to use throughout the theme.
	add_image_size( 'custom-thumb', 400, 300, true );
	add_image_size( 'banner-full', 1600, 600, true );
}
add_action( 'after_setup_theme', 'theme_prefix_setup' );

/**
 * Set the content width in pixels, based on the theme’s design.
 *
 * @since 1.0.0
 * @return void
 */
function theme_prefix_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'theme_prefix_content_width', 1400 );
}
add_action( 'after_setup_theme', 'theme_prefix_content_width', 0 );

/**
 * Include additional custom theme functions.
 */
$additional_functions  = THEME_TEMP_DIR . '/includes/additional-functions.php';
$security_enhancements = THEME_TEMP_DIR . '/includes/security-enhancements.php';
if ( file_exists( $additional_functions ) ) {
	require_once $additional_functions;
}
if ( file_exists( $security_enhancements ) ) {
	require_once $security_enhancements;
}
