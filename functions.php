<?php
/**
 * Theme functions and definitions.
 *
 * @package Theme_Name
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define Theme Constants.
 */
if ( ! defined( 'THEME_VERSION' ) ) {
	define( 'THEME_VERSION', '1.0' );
}
if ( ! defined( 'THEME_TEMP_URI' ) ) {
	define( 'THEME_TEMP_URI', get_template_directory_uri() );
}
if ( ! defined( 'THEME_TEMP_DIR' ) ) {
	define( 'THEME_TEMP_DIR', get_template_directory() );
}

// Asset version: cached filemtime so the filesystem stat doesn't run on every request.
$_theme_prefix_asset_version = get_transient( 'theme_prefix_asset_version' );
if ( false === $_theme_prefix_asset_version ) {
	$_theme_prefix_asset_version = filemtime( THEME_TEMP_DIR . '/assets/css/style.css' );
	set_transient( 'theme_prefix_asset_version', $_theme_prefix_asset_version, DAY_IN_SECONDS );
}
define( 'THEME_ASSET_VERSION', $_theme_prefix_asset_version );
unset( $_theme_prefix_asset_version );

/**
 * Theme Setup
 */
function theme_prefix_theme_setup() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// Register Navigation Menus.
	register_nav_menus(
		array(
			'primary'         => esc_html__( 'Primary Menu', 'theme-textdomain' ),
			'footer_products' => esc_html__( 'Footer Products', 'theme-textdomain' ),
			'footer_services' => esc_html__( 'Footer Services', 'theme-textdomain' ),
			'footer_industry' => esc_html__( 'Footer Industry', 'theme-textdomain' ),
			'footer_about'    => esc_html__( 'Footer About', 'theme-textdomain' ),
			'footer_bottom'   => esc_html__( 'Footer Bottom', 'theme-textdomain' ),
		)
	);
}
add_action( 'after_setup_theme', 'theme_prefix_theme_setup' );


/**
 * Remove jQuery Migrate.
 *
 * @param object $scripts Array of script handles.
 */
function theme_prefix_remove_jquery_migrate( $scripts ) {
	if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
		$scripts->registered['jquery']->deps = array_diff(
			$scripts->registered['jquery']->deps,
			array( 'jquery-migrate' )
		);
	}
}
add_action( 'wp_default_scripts', 'theme_prefix_remove_jquery_migrate' );

/**
 * Add preconnect resource hints for Google Fonts.
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed for.
 */
function theme_prefix_google_fonts_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.googleapis.com',
		);
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'theme_prefix_google_fonts_resource_hints', 10, 2 );

/**
 * Load Google Fonts non-blocking via preload + onload swap.
 * Avoids render-blocking external stylesheet request.
 */
function theme_prefix_google_fonts_preload() {
	if ( is_admin() ) {
		return;
	}
	$font_url = 'https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap';
	?>
	<link rel="preload" as="style" href="<?php echo esc_url( $font_url ); ?>" onload="this.onload=null;this.rel='stylesheet'">
	<noscript><link rel="stylesheet" href="<?php echo esc_url( $font_url ); ?>"></noscript><?php //phpcs:ignore ?>
	<?php
}
add_action( 'wp_head', 'theme_prefix_google_fonts_preload', 5 );

/**
 * Make fancybox CSS non-blocking using the preload/onload swap pattern.
 * Fancybox styles are only needed after user interaction, not on initial render.
 *
 * @param string $html   The link tag HTML.
 * @param string $handle The stylesheet handle.
 * @return string Modified tag for deferred handles, original otherwise.
 */
function theme_prefix_deferred_style_loader_tag( $html, $handle ) {
	$deferred_handles = array();
	if ( ! in_array( $handle, $deferred_handles, true ) ) {
		return $html;
	}
	// Replace rel="stylesheet" with preload + onload swap.
	$preload = str_replace( "rel='stylesheet'", "rel='preload' as='style' onload=\"this.onload=null;this.rel='stylesheet'\"", $html );
	// Noscript fallback for users/bots without JS.
	$noscript = '<noscript>' . $html . '</noscript>';
	return $preload . "\n" . $noscript;
}
add_filter( 'style_loader_tag', 'theme_prefix_deferred_style_loader_tag', 10, 2 );

/**
 * Enqueue Block Editor Assets
 */
function theme_prefix_enqueue_block_editor_assets() {
	// Enqueue editor styles.
	wp_enqueue_style( 'theme-textdomain-editor-style', THEME_TEMP_URI . '/assets/css/style.css', array(), '1.0.0' );
	wp_enqueue_style( 'theme-textdomain-editor-custom', THEME_TEMP_URI . '/assets/css/editor.css', array(), '1.0.0' );
}
add_action( 'enqueue_block_editor_assets', 'theme_prefix_enqueue_block_editor_assets' );


/**
 * ACF Options Page
 */
if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page(
		array(
			'page_title' => 'Theme Settings',
			'menu_title' => 'Theme Settings',
			'menu_slug'  => 'theme-general-settings',
			'capability' => 'manage_options',
			'redirect'   => false,
		)
	);
}

/**
 * Disable Contact Form 7 Auto <p> Tag
 */
add_filter( 'wpcf7_autop_or_not', '__return_false' );

/**
 * Disable WordPress emoji conversion (ACF WYSIWYG safe).
 */
function theme_prefix_acf_disable_wp_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'theme_prefix_acf_disable_wp_emojis' );

require THEME_TEMP_DIR . '/inc/acf-blocks.php';

require THEME_TEMP_DIR . '/inc/additional-functions.php';

require THEME_TEMP_DIR . '/inc/security-enhancements';
