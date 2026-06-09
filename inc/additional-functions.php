<?php
/**
 * Theme Additional Function and Definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package    WordPress
 * @subpackage Theme_Name
 * @since      1.0
 */

/**
 * Upload SVG files.
 *
 * @param array $mimes Data types.
 * @return array Return updated mimes file types.
 */
function theme_prefix_svg_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'theme_prefix_svg_mime_types' );

/**
 * Disable the big image size threshold. (Optional)
 */
add_filter( 'big_image_size_threshold', '__return_false' );

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
add_action( 'wp_enqueue_scripts', 'theme_prefix_themes_scripts' );

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

/**
 * Theme Parse blocks.
 *
 * @param array $block_name Block name.
 * @param array $attributes Attribute list.
 */
function theme_prefix_generate_css_from_attributes( $block_name, $attributes ) {

	$xl = array();
	$lg = array();
	$sm = array();

	$css = array();
	foreach ( $attributes as $key => $value ) {
		// Add more conditions for specific attribute handling as needed.
		switch ( $key ) {
			case 'blockId':
				$section = '.section-' . $value;
				$heading = '.heading-' . $value;
				$paragra = '.paragraph-' . $value;
				break;
			// Heading.
			case 'xl_fontsize':
				$xl[] = "font-size: $value;";
				break;
			case 'xl_textalign':
				$xl[] = "text-align: $value;";
				break;
			case 'xl_color':
				$xl[] = "color: $value;";
				break;
			case 'fontweight':
				$xl[] = ( isset( $value ) && ! empty( $value ) ) ? 'font-weight:' . esc_attr( $value ) . ';' : '';
				break;
			case 'lg_fontsize':
				$lg[] = "font-size: $value;";
				break;
			case 'lg_color':
				$lg[] = "color: $value;";
				break;
			case 'lg_textalign':
				$lg[] = "text-align: $value;";
				break;
			case 'tb_fontsize':
				$tb[] = "font-size: $value;";
				break;
			case 'tb_color':
				$tb[] = "color: $value;";
				break;
			case 'tb_textalign':
				$tb[] = "text-align: $value;";
				break;
			case 'sm_fontsize':
				$sm[] = "font-size: $value;";
				break;
			case 'sm_color':
				$sm[] = "color: $value;";
				break;
			case 'sm_textalign':
				$sm[] = "text-align: $value;";
				break;

			// paragraph.
			case 'xl_p_fontsize':
				$xlp[] = "font-size: $value;";
				break;
			case 'xl_p_textalign':
				$xlp[] = "text-align: $value;";
				break;
			case 'xl_p_color':
				$xlp[] = "color: $value !important;";
				break;
			case 'lg_p_fontsize':
				$lgp[] = "font-size: $value;";
				break;
			case 'lg_p_color':
				$lgp[] = "color: $value !important; ";
				break;
			case 'lg_p_textalign':
				$lgp[] = "text-align: $value;";
				break;
			case 'tb_p_fontsize':
				$tbp[] = "font-size: $value;";
				break;
			case 'tb_p_color':
				$tbp[] = "color: $value !important;";
				break;
			case 'tb_p_textalign':
				$tbp[] = "text-align: $value;";
				break;
			case 'sm_p_fontsize':
				$smp[] = "font-size: $value;";
				break;
			case 'sm_p_color':
				$smp[] = "color: $value !important;";
				break;
			case 'sm_p_textalign':
				$smp[] = "text-align: $value;";
				break;
			// Padding & Margin.
			case 'xl_padding':
				if ( ! empty( $value ) ) :
					$pxp[] = ( isset( $value['top'] ) && ! empty( $value['top'] ) ) ? 'padding-top:' . esc_attr( $value['top'] ) . ';' : '';
					$pxp[] = ( isset( $value['right'] ) && ! empty( $value['right'] ) ) ? 'padding-right:' . esc_attr( $value['right'] ) . ';' : '';
					$pxp[] = ( isset( $value['bottom'] ) && ! empty( $value['bottom'] ) ) ? 'padding-bottom:' . esc_attr( $value['bottom'] ) . ';' : '';
					$pxp[] = ( isset( $value['left'] ) && ! empty( $value['left'] ) ) ? 'padding-top:' . esc_attr( $value['left'] ) . ';' : '';
				endif;
				break;
			case 'xl_margin':
				if ( ! empty( $value ) ) :
					$mxl[] = ( isset( $value['top'] ) && ! empty( $value['top'] ) ) ? 'margin-top:' . esc_attr( $value['top'] ) . ';' : '';
					$mxl[] = ( isset( $value['right'] ) && ! empty( $value['right'] ) ) ? 'margin-right:' . esc_attr( $value['right'] ) . ';' : '';
					$mxl[] = ( isset( $value['bottom'] ) && ! empty( $value['bottom'] ) ) ? 'margin-bottom:' . esc_attr( $value['bottom'] ) . ';' : '';
					$mxl[] = ( isset( $value['left'] ) && ! empty( $value['left'] ) ) ? 'margin-top:' . esc_attr( $value['left'] ) . ';' : '';
				endif;
				break;
			case 'lg_padding':
				if ( ! empty( $value ) ) :
					$plp[] = ( isset( $value['top'] ) && ! empty( $value['top'] ) ) ? 'padding-top:' . esc_attr( $value['top'] ) . ';' : '';
					$plp[] = ( isset( $value['right'] ) && ! empty( $value['right'] ) ) ? 'padding-right:' . esc_attr( $value['right'] ) . ';' : '';
					$plp[] = ( isset( $value['bottom'] ) && ! empty( $value['bottom'] ) ) ? 'padding-bottom:' . esc_attr( $value['bottom'] ) . ';' : '';
					$plp[] = ( isset( $value['left'] ) && ! empty( $value['left'] ) ) ? 'padding-top:' . esc_attr( $value['left'] ) . ';' : '';
				endif;
				break;
			case 'lg_margin':
				if ( ! empty( $value ) ) :
					$mlg[] = ( isset( $value['top'] ) && ! empty( $value['top'] ) ) ? 'margin-top:' . esc_attr( $value['top'] ) . ';' : '';
					$mlg[] = ( isset( $value['right'] ) && ! empty( $value['right'] ) ) ? 'margin-right:' . esc_attr( $value['right'] ) . ';' : '';
					$mlg[] = ( isset( $value['bottom'] ) && ! empty( $value['bottom'] ) ) ? 'margin-bottom:' . esc_attr( $value['bottom'] ) . ';' : '';
					$mlg[] = ( isset( $value['left'] ) && ! empty( $value['left'] ) ) ? 'margin-top:' . esc_attr( $value['left'] ) . ';' : '';
				endif;
				break;
			case 'tb_padding':
				if ( ! empty( $value ) ) :
					$ptb[] = ( isset( $value['top'] ) && ! empty( $value['top'] ) ) ? 'padding-top:' . esc_attr( $value['top'] ) . ';' : '';
					$ptb[] = ( isset( $value['right'] ) && ! empty( $value['right'] ) ) ? 'padding-right:' . esc_attr( $value['right'] ) . ';' : '';
					$ptb[] = ( isset( $value['bottom'] ) && ! empty( $value['bottom'] ) ) ? 'padding-bottom:' . esc_attr( $value['bottom'] ) . ';' : '';
					$ptb[] = ( isset( $value['left'] ) && ! empty( $value['left'] ) ) ? 'padding-top:' . esc_attr( $value['left'] ) . ';' : '';
				endif;
				break;
			case 'tb_margin':
				if ( ! empty( $value ) ) :
					$mtb[] = ( isset( $value['top'] ) && ! empty( $value['top'] ) ) ? 'margin-top:' . esc_attr( $value['top'] ) . ';' : '';
					$mtb[] = ( isset( $value['right'] ) && ! empty( $value['right'] ) ) ? 'margin-right:' . esc_attr( $value['right'] ) . ';' : '';
					$mtb[] = ( isset( $value['bottom'] ) && ! empty( $value['bottom'] ) ) ? 'margin-bottom:' . esc_attr( $value['bottom'] ) . ';' : '';
					$mtb[] = ( isset( $value['left'] ) && ! empty( $value['left'] ) ) ? 'margin-top:' . esc_attr( $value['left'] ) . ';' : '';
				endif;
				break;
			case 'sm_padding':
				if ( ! empty( $value ) ) :
					$psm[] = ( isset( $value['top'] ) && ! empty( $value['top'] ) ) ? 'padding-top:' . esc_attr( $value['top'] ) . ';' : '';
					$psm[] = ( isset( $value['right'] ) && ! empty( $value['right'] ) ) ? 'padding-right:' . esc_attr( $value['right'] ) . ';' : '';
					$psm[] = ( isset( $value['bottom'] ) && ! empty( $value['bottom'] ) ) ? 'padding-bottom:' . esc_attr( $value['bottom'] ) . ';' : '';
					$psm[] = ( isset( $value['left'] ) && ! empty( $value['left'] ) ) ? 'padding-top:' . esc_attr( $value['left'] ) . ';' : '';
				endif;
				break;
			case 'sm_margin':
				if ( ! empty( $value ) ) :
					$msm[] = ( isset( $value['top'] ) && ! empty( $value['top'] ) ) ? 'margin-top:' . esc_attr( $value['top'] ) . ';' : '';
					$msm[] = ( isset( $value['right'] ) && ! empty( $value['right'] ) ) ? 'margin-right:' . esc_attr( $value['right'] ) . ';' : '';
					$msm[] = ( isset( $value['bottom'] ) && ! empty( $value['bottom'] ) ) ? 'margin-bottom:' . esc_attr( $value['bottom'] ) . ';' : '';
					$msm[] = ( isset( $value['left'] ) && ! empty( $value['left'] ) ) ? 'margin-top:' . esc_attr( $value['left'] ) . ';' : '';
				endif;
				break;
			// No need for a default case if you don't want to reset the arrays.
		}
	}

	$general = '';
	$large   = '';
	$tablet  = '';
	$small   = '';

	$pxp = ! empty( $pxp ) ? $pxp : array();
	$mxl = ! empty( $mxl ) ? $mxl : array();
	$plp = ! empty( $plp ) ? $plp : array();
	$mlg = ! empty( $mlg ) ? $mlg : array();
	$ptb = ! empty( $ptb ) ? $ptb : array();
	$mtb = ! empty( $mtb ) ? $mtb : array();
	$psm = ! empty( $psm ) ? $psm : array();
	$msm = ! empty( $msm ) ? $msm : array();

	// Desktop Size CSS.
	$general .= ( ! empty( $xl ) && ! empty( $heading ) ) ? esc_html( $heading ) . '{ ' . wp_kses_post( implode( "\n", $xl ) ) . ' }' : '';
	$general .= ( ! empty( $xlp ) && ! empty( $paragra ) ) ? esc_html( $paragra ) . '{ ' . wp_kses_post( implode( "\n", $xlp ) ) . ' }' : '';
	$general .= ( ( ! empty( $pxp ) || ! empty( $mxl ) ) && ! empty( $section ) ) ? esc_html( $section ) . '{ ' . wp_kses_post( implode( ' ', $pxp ) ) . '' . wp_kses_post( implode( ' ', $mxl ) ) . '}' : '';

	// Large Size CSS.
	$large .= ( ! empty( $lg ) ) ? esc_html( $heading ) . '{ ' . wp_kses_post( implode( "\n", $lg ) ) . ' }' : '';
	$large .= ( ! empty( $lgp ) ) ? esc_html( $paragra ) . '{ ' . wp_kses_post( implode( "\n", $lgp ) ) . ' }' : '';
	$large .= ( ( ! empty( $plp ) || ! empty( $mlg ) ) && ! empty( $section ) ) ? esc_html( $section ) . '{ ' . wp_kses_post( implode( ' ', $plp ) ) . '' . wp_kses_post( implode( ' ', $mlg ) ) . '}' : '';

	// Tablet Size CSS.
	$tablet .= ( ! empty( $tb ) ) ? esc_html( $heading ) . '{ ' . wp_kses_post( implode( "\n", $tb ) ) . ' }' : '';
	$tablet .= ( ! empty( $tbp ) ) ? esc_html( $paragra ) . '{ ' . wp_kses_post( implode( "\n", $tbp ) ) . ' }' : '';
	$tablet .= ( ( ! empty( $ptb ) || ! empty( $mtb ) ) && ! empty( $section ) ) ? esc_html( $section ) . '{ ' . wp_kses_post( implode( ' ', $ptb ) ) . '' . wp_kses_post( implode( ' ', $mtb ) ) . '}' : '';

	// Mobile Size CSS.
	$small .= ( ! empty( $sm ) ) ? esc_html( $heading ) . '{ ' . wp_kses_post( implode( "\n", $sm ) ) . ' }' : '';
	$small .= ( ! empty( $smp ) ) ? esc_html( $paragra ) . '{ ' . wp_kses_post( implode( "\n", $smp ) ) . ' }' : '';
	$small .= ( ( ! empty( $psm ) || ! empty( $msm ) ) && ! empty( $section ) ) ? esc_html( $section ) . '{ ' . wp_kses_post( implode( ' ', $psm ) ) . '' . wp_kses_post( implode( ' ', $msm ) ) . '}' : '';

	return array(
		'general' => $general,
		'large'   => $large,
		'tablet'  => $tablet,
		'small'   => $small,
	);
}

/**
 * Theme Parse blocks.
 */
function theme_prefix_generated_block_styles() {
	// Get all block types.
	$blocks        = theme_prefix_blocks_parse_blocks();
	$generated_css = array();
	$general       = '';
	$large         = '';
	$tablet        = '';
	$small         = '';

	foreach ( $blocks as $key => $block_data ) :
		if ( $block_data ) :
			$generated_css = theme_prefix_generate_css_from_attributes( $block_data['blockName'], $block_data['attrs'] );
			$general      .= $generated_css['general'];
			$large        .= $generated_css['large'];
			$tablet       .= $generated_css['tablet'];
			$small        .= $generated_css['small'];
		endif;
	endforeach;

	ob_start();
	echo ! empty( $general ) ? wp_kses_post( $general ) : '';
	echo ( ! empty( $large ) ) ? '@media only screen and (max-width:1200px) {' . wp_kses_post( $large ) . '}' : '';
	echo ( ! empty( $tablet ) ) ? '@media only screen and (max-width:1024px) {' . wp_kses_post( $tablet ) . '}' : '';
	echo ( ! empty( $small ) ) ? '@media only screen and (max-width:767px) {' . wp_kses_post( $small ) . '}' : '';
	$css = ob_get_clean();

	// Add the dynamically generated CSS.
	wp_add_inline_style( 'theme-prefix-style', $css ); // Ensure 'theme-prefix-style' is the handle of your main stylesheet.
}
add_action( 'wp_enqueue_scripts', 'theme_prefix_generated_block_styles' );


/**
 * Theme Parse blocks.
 *
 * @return array theme block array.
 */
function theme_prefix_blocks_parse_blocks() {

	global $post;
	$ks_blocks = array(
		'theme-slug/card-repeater', // Add your custom block names here.
	);

	$block_data = array();
	if ( $post ) {
		$blocks = isset( $post->post_content ) ? parse_blocks( $post->post_content ) : array();
		foreach ( $blocks as $block ) {
			// Check theme block in array.
			if ( in_array( $block['blockName'], $ks_blocks, true ) ) {
				$block_data[] = $block;
			}
		}
	}
	return $block_data;
}
