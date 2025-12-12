/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
/**
 * Internal dependencies
 */
import Edit from "./edit";
import save from "./save";
import metadata from "./block.json";
import sectionAttributes from "../../inspector-setting/sectionAttributes";
import fontAttributes from "../../inspector-setting/fontAttributes";
import { partner } from '../../inspector-setting/components/svg-loader';

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */

const block_attr = {
	blockId: {
		type: "string",
		default: "",
	},
	headingTag:{
		type: 'string',
		default: 'h2',
	},
	partner_card: {
		type: "array",
		default: [
			{
				image: {
					imgURL: "https://placehold.co/200x90",
					altText: "partner-logo",
				},
				name: "",
				description: "",
			},
		],
	},
};
const mergedAttributes = {
	...sectionAttributes.general,
	...sectionAttributes.desktop,
	...sectionAttributes.large,
	...sectionAttributes.tablet,
	...sectionAttributes.mobile,
	...fontAttributes.heading,
	...fontAttributes.paragraph,
	...block_attr,
};

registerBlockType(metadata.name, {
	icon: {
		src: partner
	},
	attributes: mergedAttributes,
	/**
	 * @see ./edit.js
	 */
	edit: Edit,

	/**
	 * @see ./save.js
	 */
	save,
});
