/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import {
	useBlockProps,
	RichText,
	InspectorControls,
	MediaUpload,
} from "@wordpress/block-editor";
import { Panel, PanelRow, PanelBody, Button } from "@wordpress/components";
import {
	SpacingSetting,
	Responsive,
	BackgroundSection,
} from "../../inspector-setting/sectionSetting";
import Heading from "../../inspector-setting/heading";
import FontSetting from "../../inspector-setting/fontSetting";
import { fieldsAttribute } from "../../inspector-setting/components/additional-fun";

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import "./editor.scss";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({ attributes, setAttributes, clientId }) {
	setAttributes({ blockId: clientId });
	const { section_bg, heading, paragraph, sectionAttr, labels } =
		fieldsAttribute(attributes);
	const handleInputField = (value, index, fieldname) => {
		const newValues = [...attributes.partner_card];
		newValues[index][fieldname] = value;
		setAttributes({ partner_card: newValues });
	};
	const addItem = () => {
		const newValues = [
			...attributes.partner_card,
			{
				image: {
					imgURL: "https://placehold.co/200x90",
					altText: "partner-logo",
				},
				name: "",
				description: "",
			},
		];
		setAttributes({ partner_card: newValues });
	};
	const removeItem = (index) => {
		const newValues = [...attributes.partner_card];
		newValues.splice(index, 1);
		setAttributes({ partner_card: newValues });
	};
	return (
		<>
			<InspectorControls>
				<Panel header={__("Setting", "theme")}>
					<React.Fragment key=".0">
						<PanelBody
							className="theme-head"
							title={__("Genaral", "theme")}
						>
							<PanelRow>
								<BackgroundSection
									attributes={attributes}
									setAttributes={setAttributes}
									prefix={"xl"}
								/>
							</PanelRow>
							<PanelRow>
								<Heading
									attributes={attributes}
									setAttributes={setAttributes}
								/>
							</PanelRow>

							<PanelRow>
								<Responsive
									attributes={attributes}
									setAttributes={setAttributes}
								/>
							</PanelRow>
						</PanelBody>
						<PanelBody
							className="theme-spacing"
							title={`${labels[attributes.res_type]} Dimensions`}
						>
							<PanelRow>
								<SpacingSetting
									attributes={attributes}
									setAttributes={setAttributes}
									prefix={attributes.res_type}
								/>
							</PanelRow>
						</PanelBody>
						<PanelBody
							className="theme-head"
							title={`${labels[attributes.res_type]} Typography`}
						>
							<PanelRow>
								<FontSetting
									attributes={attributes}
									setAttributes={setAttributes}
									prefix={attributes.res_type}
									fieldlabel={"Heading"}
								/>
							</PanelRow>
							<PanelRow>
								<FontSetting
									attributes={attributes}
									setAttributes={setAttributes}
									prefix={`${attributes.res_type}_p`}
									fieldlabel={"Paragraph"}
									asParagraph={true}
								/>
							</PanelRow>
						</PanelBody>
					</React.Fragment>
				</Panel>
			</InspectorControls>
			<div {...useBlockProps({ className: "py-32 xl:py-24 lg:py-14" })}>
				<div className="container" style={{ ...section_bg, ...sectionAttr }}>
					<ul className={`flex flex-wrap -mx-4 partners-list justify-center`}>
						{attributes.partner_card?.map((partner, index) => (
							<li key={index} className="px-4 mb-4">
								<div className="bg-white rounded-xl overflow-hidden h-full">
									<div className="relative border-b border-solid border-misty text-center px-4">
										<Button
											isDestructive
											className="delete-btn-blk"
											variant="primary"
											onClick={() => removeItem(index)}
										>
											X
										</Button>
										<MediaUpload
											onSelect={(media) => {
												handleInputField(
													{
														imgURL: media.sizes.full.url,
														altText: media.title,
													},
													index,
													"image"
												);
											}}
											allowedTypes="image"
											render={({ open }) => {
												return (
													attributes.partner_card[index].image && (
														<img
															onClick={open}
															draggable={true}
															alt={partner.image?.altText}
															className="mx-auto"
															width={231}
															height={104}
															src={partner.image?.imgURL}
														/>
													)
												);
											}}
										/>
									</div>
									<div className="pt-6 pb-7 px-6 text-center">
										<RichText
											tagName="h3"
											placeholder={__("Partner Name", "theme")}
											value={partner.name}
											style={{ ...heading }}
											onChange={(value) =>
												handleInputField(value, index, "name")
											}
											className="h6 text-black pb-6 richtext-border"
										/>
										<RichText
											tagName="p"
											value={partner.description}
											placeholder={__("Description", "theme")}
											style={{ ...paragraph }}
											onChange={(value) =>
												handleInputField(value, index, "description")
											}
											className="text-base text-black richtext-border"
										/>
									</div>
								</div>
							</li>
						))}
					</ul>
					<div style={{ textAlign: "center", paddingTop: "50px" }}>
						<Button isPressed variant="primary" onClick={addItem}>
							{__("Add Partner", "theme")}
						</Button>
					</div>
				</div>
			</div>
		</>
	);
}
