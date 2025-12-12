import {
    ColorPalette, 
    FontSizePicker,
	__experimentalDivider as Divider,
	__experimentalVStack as VStack,
    __experimentalToggleGroupControl as ToggleGroupControl,
	__experimentalToggleGroupControlOption as ToggleGroupControlOption,
} from '@wordpress/components';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function fontSetting( { attributes, setAttributes, prefix, fieldlabel, asParagraph } ) {
    const atfontsize = `${prefix}_fontsize`;
    const atcolor = `${prefix}_color`;
    const attextalign = `${prefix}_textalign`;
	return (
		<div style={{ width: '100%' }} className='theme-head'>
            <VStack spacing={0}>
                <h5 style={{paddingBottom:'15px'}}>{ fieldlabel } Setting</h5>
                { asParagraph ? 
                    (<FontSizePicker
                            __nextHasNoMarginBottom
                            fontSizes={
                                [ { name: 'Small', size: '14px', slug: 'small' },
                                { name: 'Normal', size: '16px', slug: 'normal' },
                                { name: 'Big', size: '18px', slug: 'big' },
                                { name: 'X Big', size: '20px', slug: 'xbig' }, ]}
                            onChange={ ( shfontsize ) => setAttributes( { [atfontsize]: shfontsize  } ) }
                            units={[ 'px', 'em', 'rem' ]}
                            value={ attributes[atfontsize] }
                        /> ) : ( <FontSizePicker
                            __nextHasNoMarginBottom
                            fontSizes={
                                [ { name: 'Small', size: '32px', slug: 'small' },
                                { name: 'Normal', size: '36px', slug: 'normal' },
                                { name: 'Big', size: '48px', slug: 'big' },
                                { name: 'X Big', size: '60px', slug: 'xbig' }, ]}
                            onChange={ ( shfontsize ) => setAttributes( { [atfontsize]: shfontsize  } ) }
                            units={[ 'px', 'em', 'rem' ]}
                            value={ attributes[atfontsize] }
                        />
                    )
                }
                <Divider />
                <ToggleGroupControl label={`${fieldlabel} Text Align`} value={ attributes[attextalign] } isBlock onChange={(shalign) => setAttributes({ [attextalign]: shalign })}>
                    <ToggleGroupControlOption value="left" label="Left" />
                    <ToggleGroupControlOption value="center" label="Center" />
                    <ToggleGroupControlOption value="right" label="Right" />
                </ToggleGroupControl>
                <ColorPalette
                __experimentalIsRenderedInSidebar
                    colors={
                        [ { color: '#213745', name: 'Primary' },
                        { color: '#97A7B1', name: 'Primary 50' },
                        { color: '#9AABB3', name: 'Primary 100'},
                        { color: '#7D8C93', name: 'Primary 200'},
                        { color: '#657278', name: 'Primary 300' },
                        { color: '#597182', name: 'Primary 400' },
                        { color: '#2F4E63', name: 'Primary 500'},
                        { color: '#000000', name: 'Black'}, 
                        { color: '#EFEFEF', name: 'Black 100'},
                        { color: '#EDF3F5', name: 'Black 200'},
                        { color: '#D4D9D5', name: 'Misty'},
                        { color: '#dddfdd', name: 'Misty 50'}, ]
                    }
                    onChange={ ( shcolor ) => setAttributes( { [atcolor] : shcolor } ) }
                    value={ attributes[atcolor] }
                />
                <Divider />
            </VStack>
        </div>
	);
}