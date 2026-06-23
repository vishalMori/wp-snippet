<?php
/**
 * Additional functions for theme.
 *
 * @package Theme_Name
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
 * Enqueue Scripts and Styles
 */
function theme_prefix_enqueue_scripts() {
	// Enqueue Styles.
	if ( ! is_admin() ) {
		wp_enqueue_script(
			'theme-textdomain-setting',
			THEME_TEMP_URI . '/assets/js/setting.js',
			array( 'jquery' ),
			THEME_ASSET_VERSION,
			array(
				'strategy'  => 'defer',
				'in_footer' => true,
			)
		);

		wp_dequeue_script( 'wp-hooks' );
		wp_dequeue_script( 'wp-i18n' );
		wp_dequeue_style( 'global-styles' );
		wp_dequeue_style( 'wp-emoji-styles' );
		wp_dequeue_style( 'classic-theme-styles' );
		wp_dequeue_style( 'wp-block-library-theme' );
	}
}
add_action( 'wp_enqueue_scripts', 'theme_prefix_enqueue_scripts' );
add_action( 'enqueue_block_assets', 'theme_prefix_enqueue_scripts' );

/**
 * Handle ACF block preview rendering.
 *
 * Call this function at the beginning of block templates to handle preview mode.
 * If the block is in preview mode, it will display the preview image and return true.
 *
 * @param array $block The block data array from ACF.
 * @return bool True if preview was rendered, false otherwise.
 */
function theme_prefix_render_block_preview( $block ) {
	if ( isset( $block['data']['_is_preview'] ) && $block['data']['_is_preview'] ) {
		$preview_image = $block['data']['preview_image'] ?? THEME_TEMP_URI . '/assets/images/og-img.webp';
		echo '<img src="' . esc_url( $preview_image ) . '" alt="Block Preview" style="width:100%; height:auto;">';
		return true;
	}
	return false;
}

/**
 * Get custom scripts filtered by location.
 *
 * @param string $location The script location ('head' or 'body').
 * @return array Array of script rows matching the location.
 */
function theme_prefix_get_scripts_by_location( $location ) {
	if ( ! function_exists( 'get_field' ) ) {
		return array();
	}

	static $all_scripts = null;
	if ( null === $all_scripts ) {
		$all_scripts = get_field( 'theme_prefix_custom_scripts', 'option' );
		if ( empty( $all_scripts ) || ! is_array( $all_scripts ) ) {
			$all_scripts = array();
		}
	}

	return array_filter(
		$all_scripts,
		function ( $row ) use ( $location ) {
			return isset( $row['script_location'] ) && $location === $row['script_location'];
		}
	);
}

/**
 * Output custom scripts in the <head>, deferred until after user interaction
 * or 3 seconds (whichever comes first) to avoid blocking initial render.
 */
function theme_prefix_output_head_scripts() {
	$scripts = theme_prefix_get_scripts_by_location( 'head' );

	if ( empty( $scripts ) ) {
		return;
	}

	$output = '';
	foreach ( $scripts as $script ) {
		if ( ! empty( $script['script_code'] ) ) {
			$output .= $script['script_code'] . "\n";
		}
	}

	if ( empty( $output ) ) {
		return;
	}

	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Raw script output is intentional; content is managed by administrators only.
	echo '<script>
	(function(){
		var loaded=false;
		function loadScripts(){
			if(loaded)return;
			loaded=true;
			var html=' . wp_json_encode( $output ) . ';
			var d=document,wrapper=d.createElement("div");
			wrapper.innerHTML=html;
			// innerHTML does not execute scripts — re-create each <script> as a real DOM node so it runs.
			Array.prototype.slice.call(wrapper.childNodes).forEach(function(node){
				if(node.nodeType===1&&node.tagName==="SCRIPT"){
					var s=d.createElement("script");
					for(var i=0;i<node.attributes.length;i++){
						s.setAttribute(node.attributes[i].name,node.attributes[i].value);
					}
					if(node.textContent){s.textContent=node.textContent;}
					d.head.appendChild(s);
				}else{
					d.head.appendChild(node);
				}
			});
		}
		var events=["mouseover","keydown","touchstart","scroll"];
		events.forEach(function(e){document.addEventListener(e,loadScripts,{once:true,passive:true});});
		setTimeout(loadScripts,3000);
	})();
	</script>' . "\n";
}
add_action( 'wp_head', 'theme_prefix_output_head_scripts', 1 );

/**
 * Output custom scripts after the opening <body> tag.
 */
function theme_prefix_output_body_scripts() {
	$scripts = theme_prefix_get_scripts_by_location( 'body' );

	foreach ( $scripts as $script ) {
		if ( ! empty( $script['script_code'] ) ) {
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Raw script output is intentional; content is managed by administrators only.
			echo $script['script_code'] . "\n";
		}
	}
}
add_action( 'wp_body_open', 'theme_prefix_output_body_scripts', 1 );
