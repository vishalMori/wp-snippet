/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, RichText } from "@wordpress/block-editor";
import { fieldsAttribute } from "../../inspector-setting/components/additional-fun";
/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {Element} Element to render.
 */
export default function save({ attributes }) {
	const { section_bg } = fieldsAttribute(attributes);
	return (
		<>
			<div
				{...useBlockProps.save({
					className: `py-32 xl:py-24 lg:py-14 section-${attributes.blockId}`,
				})}
			>
				<div className="container" style={{ ...section_bg }}>
					<ul className={`flex flex-wrap -mx-4 partners-list justify-center`}>
						{attributes.partner_card?.map((item, index) => (
							<li data-aos="fade-up" data-aos-delay="300" key={index}>
								<div className="bg-white rounded-xl overflow-hidden h-full">
									<div className="border-b border-solid border-misty text-center px-4">
										<img
											src={item.image.imgURL}
											className="mx-auto"
											width="231"
											height="104"
											alt={item.image.altText}
										/>
									</div>
									<div className="pt-6 pb-7 px-6 text-center">
										<RichText.Content
											tagName={attributes.headingTag}
											value={item.name}
											className={`h6 text-black pb-6 heading-${attributes.blockId}`}
										/>
										<RichText.Content
											tagName="p"
											value={item.description}
											className={`text-base text-black paragraph-${attributes.blockId}`}
										/>
									</div>
								</div>
							</li>
						))}
					</ul>
				</div>
			</div>
		</>
	);
}
