/**
 * Custom react function for attributes.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

export const fieldsAttribute = ( attributes ) => {

    var section_bg = '';
	if( 'image' === attributes.bg_type && attributes.bg_image ){
		section_bg = { 
			backgroundImage:`url(${attributes.bg_image})`,
		};
	}else if( 'gradient' === attributes.bg_type && attributes.bg_gradient ){
		section_bg = { 
			backgroundImage:attributes.bg_gradient
		};
	}else if( 'color' === attributes.bg_type && attributes.bg_color ){
		section_bg = { 
			backgroundColor:attributes.bg_color 
		};
	}

	const heading = {
		fontWeight: attributes.fontweight,
		fontSize: attributes.xl_fontsize,
		color: attributes.xl_color,
		textAlign: attributes.xl_textalign,
	};

	const paragraph = {
		fontSize: attributes.xl_p_fontsize,
		color: attributes.xl_p_color,
		textAlign: attributes.xl_p_textalign,
	};

	const sectionAttr = {
		paddingTop: attributes.xl_padding?.top,
		paddingRight: attributes.xl_padding?.right,
		paddingBottom: attributes.xl_padding?.bottom,
		paddingLeft: attributes.xl_padding?.left,
		marginTop: attributes.xl_margin?.top,
		marginRight: attributes.xl_margin?.right,
		marginBottom: attributes.xl_margin?.bottom,
		marginLeft: attributes.xl_margin?.left,
	};

	const labels = {
		xl : __( 'Desktop', 'theme' ),
		lg : __( 'Large', 'theme' ),
		tb : __( 'Tablet', 'theme' ),
		sm : __( 'Mobile', 'theme' ),
	};

    return {
		section_bg,
		heading,
		paragraph,
		sectionAttr,
		labels
	};
};