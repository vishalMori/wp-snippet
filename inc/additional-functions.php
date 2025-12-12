<?php
/**
 * Theme Prefix Additional Functions and Definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Theme_Name
 * @since 1.0.0
 */

/**
 * Allow SVG file uploads.
 *
 * @param array $mimes Existing MIME types.
 * @return array Modified MIME types.
 */
function theme_prefix_svg_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'theme_prefix_svg_mime_types' );

/**
 * Enqueue theme scripts and styles.
 *
 * @since 1.0.0
 * @return void
 */
function theme_prefix_themes_scripts() {
	wp_register_style(
		'theme-prefix-style',
		THEME_TEMP_URI . 'style.css',
		array(),
		filemtime( THEME_TEMP_DIR . 'style.css' )
	);
	wp_enqueue_style( 'theme-prefix-style' );

	wp_register_script(
		'theme-prefix-script',
		THEME_TEMP_URI . 'assets/js/script.js',
		array(),
		filemtime( THEME_TEMP_DIR . 'assets/js/script.js' ),
		true
	);
	wp_enqueue_script( 'theme-prefix-script' );
}
add_action( 'wp_enqueue_scripts', 'theme_prefix_themes_scripts' );

/**
 * Deregister block library style.
 *
 * @since 1.0.0
 * @return void
 */
function theme_prefix_deregister_scripts() {

	// Deregister unwanted styles for optimization.
	wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'wp-emoji-styles' );
	wp_dequeue_style( 'classic-theme-styles' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_deregister_style( 'wp-block-library' );

	if ( ! is_user_logged_in() ) {
		wp_dequeue_style( 'dashicons' );
	}
}
add_action( 'wp_enqueue_scripts', 'theme_prefix_deregister_scripts', 20 );

/**
 * Register widget areas.
 *
 * @since 1.0.0
 * @return void
 */
function theme_prefix_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Your widgets', 'theme-textdomain' ),
			'id'            => 'your-widgets',
			'description'   => __( 'Widgets description.', 'theme-textdomain' ),
			'before_widget' => '',
			'after_widget'  => '',
		)
	);
}
add_action( 'widgets_init', 'theme_prefix_widgets_init' );

/**
 * Disable auto paragraph formatting in Contact Form 7.
 */
add_filter( 'wpcf7_autop_or_not', '__return_false' );
