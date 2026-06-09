<?php
/**
 * Theme Prefix functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package    WordPress
 * @subpackage Theme_Name
 * @since      1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'THEME_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'THEME_VERSION', '1.0' );
}

define( 'THEME_TEMP_URI', get_template_directory_uri() );
define( 'THEME_TEMP_DIR', get_template_directory() );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function theme_prefix_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */

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
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'header-menu' => esc_html__( 'Header Menu', 'theme-textdomain' ),
		)
	);

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
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

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	// Registers custom image sizes to use throughout the theme.
	add_image_size( 'custom-thumb', 400, 300, true );
	add_image_size( 'banner-full', 1600, 600, true );

	add_theme_support( 'wp-block-styles' );
}
add_action( 'after_setup_theme', 'theme_prefix_setup' );

/**
 * Set the content width in pixels, ahbaed on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function theme_prefix_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'theme_prefix_content_width', 1400 );
}
add_action( 'after_setup_theme', 'theme_prefix_content_width', 0 );


/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/#comment-6248
 */
function theme_prefix_block_init() {
	$build_dir = __DIR__ . '/build';

	if ( is_dir( $build_dir ) ) {
		$blocks = scandir( $build_dir );

		if ( false !== $blocks ) {
			foreach ( $blocks as $block ) {
				$block_location = $build_dir . '/' . $block;

				if ( is_dir( $block_location ) && ! in_array( $block, array( '.', '..' ), true ) ) {
					register_block_type( $block_location );
				}
			}
		}
	}
}
add_action( 'init', 'theme_prefix_block_init' );

/**
 * Adding new (custom) block categories.
 *
 * @param array $block_categories Array of categories for block types.
 * @return array Modified array of categories for block types.
 */
function theme_prefix_register_layout_category( $block_categories ) {
	$new_categories = array(
		array(
			'slug'  => 'custom-blocks',
			'title' => esc_html__( 'General Section', 'theme-textdomain' ),
		),
	);

	return array_merge( $new_categories, $block_categories );
}
add_filter( 'block_categories_all', 'theme_prefix_register_layout_category', 10, 1 );

/**
 * Include additional custom theme functions.
 */
$additional_functions = THEME_TEMP_DIR . '/inc/additional-functions.php';
$security_enhancement = THEME_TEMP_DIR . '/inc/security-enhancement.php';
if ( file_exists( $additional_functions ) ) {
	require_once $additional_functions;
}
if ( file_exists( $security_enhancement ) ) {
	require_once $security_enhancement;
}
