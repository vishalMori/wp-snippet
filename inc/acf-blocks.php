<?php
/**
 * ACF Blocks Registration
 *
 * Register all ACF block types for the theme.
 *
 * @package Theme_Name
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register ACF blocks.
 *
 * @return void
 */
function theme_prefix_register_acf_blocks(): void {
	if ( ! function_exists( 'acf_register_block_type' ) ) {
		return;
	}

	$blocks = array(
		array(
			'name'            => 'banner',
			'title'           => __( 'Banner', 'theme-textdomain' ),
			'description'     => __( 'Inner page banner with breadcrumbs.', 'theme-textdomain' ),
			'render_template' => 'template-parts/blocks/banner.php',
			'category'        => 'theme-textdomain',
			'icon'            => 'cover-image',
			'keywords'        => array( 'banner', 'hero', 'breadcrumbs' ),
			'supports'        => array(
				'align' => false,
			),
			'example'         => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'_is_preview'   => true,
						'preview_image' => THEME_TEMP_URI . '/assets/images/blocks/banner.webp',
					),
				),
			),
		),
	);

	foreach ( $blocks as $block ) {
		acf_register_block_type( $block );
	}
}

add_action( 'acf/init', 'theme_prefix_register_acf_blocks' );

/**
 * Register custom block category for BattMech.
 *
 * @param array $categories Existing block categories.
 * @return array
 */
function theme_prefix_block_categories( $categories ) {
	return array_merge(
		array(
			array(
				'slug'  => 'theme-textdomain',
				'title' => __( 'Theme_Title', 'theme-textdomain' ),
			),
		),
		$categories
	);
}

add_filter( 'block_categories_all', 'theme_prefix_block_categories' );
