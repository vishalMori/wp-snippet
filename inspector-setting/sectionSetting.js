import {
    ColorPalette,
    Button,
    GradientPicker,
    __experimentalDivider as Divider,
    BoxControl,
    __experimentalToggleGroupControl as ToggleGroupControl,
    __experimentalToggleGroupControlOption as ToggleGroupControlOption,
} from '@wordpress/components';

import { MediaUpload } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */

export function SpacingSetting( { attributes, setAttributes, prefix } ) {
    const atpadding = `${prefix}_padding`;
    const atmargin = `${prefix}_margin`;

    return (
		<div style={{ width: '100%' }} className='theme-spacing' >
            <BoxControl
                label={__( 'Padding Box', 'theme' )}
                values={ attributes[atpadding] }
                onChange={ (shpadding) => {
                    const updatedValues = {};
                    for (const [key, value] of Object.entries(shpadding)) {
                        if( typeof value !== "undefined" ){
                            updatedValues[key] = /px|em|%|rem|vw|vh/.test(value) ? value : value + 'px';
                        }
                    }
                    // Now you can use newValue to update state
                    setAttributes({ [atpadding]: updatedValues });
                }}
            />
             <Divider />
             <BoxControl
                label={__( 'Margin Box', 'theme' )}
                values={ attributes[atmargin] }
                onChange={ (shmargin) => {
                    const updatedValues = {};
                    for (const [key, value] of Object.entries(shmargin)) {
                        if( typeof value !== "undefined" ){
                            updatedValues[key] = /px|em|%|rem|vw|vh/.test(value) ? value : value + 'px';
                        }
                    }
                    // Now you can use newValue to update state
                    setAttributes({ [atmargin]: updatedValues });
                }}
            />
             <Divider />
        </div>
	);
}

export function Responsive( { attributes, setAttributes, prefix } ) {
    return (
		<div style={{ width: '100%' }} >
            <ToggleGroupControl label="Responsive" value={ attributes.res_type } isBlock onChange={( res_type ) => setAttributes( { res_type  } ) } >
                <ToggleGroupControlOption value="xl" label={ __( 'Desktop', 'theme' ) } />
                <ToggleGroupControlOption value="lg" label={ __( 'Large', 'theme' ) } />
                <ToggleGroupControlOption value="tb" label={ __( 'Tablet', 'theme' ) } />
                <ToggleGroupControlOption value="sm" label={  __( 'Mobile', 'theme' ) } />
            </ToggleGroupControl>
        </div>
	);
}

export function BackgroundSection( { attributes, setAttributes } ){

    return (
        <div style={{ width: '100%' }} className='theme-general'>
            <ToggleGroupControl label={ __( 'Background Type', 'theme' ) } value={attributes.bg_type} isBlock onChange={( bg_type ) => setAttributes( { bg_type  } )} >
                <ToggleGroupControlOption value="image" label={ __( 'Image', 'theme' ) } />
                <ToggleGroupControlOption value="color" label={ __( 'Color', 'theme' ) } />
                <ToggleGroupControlOption value="gradient" label={ __( 'Gradient', 'theme' ) } />
            </ToggleGroupControl>
            <Divider />
            { attributes.bg_type && 'color' === attributes.bg_type ?  ( <ColorPalette
                colors={[ { color: '#213745', name: 'Primary' },
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
                value={ attributes.bg_color }
                onChange={ ( bg_color ) => setAttributes( { bg_color  } ) }
            /> ) : attributes.bg_type && 'gradient' === attributes.bg_type ? 
                <GradientPicker
                    value={ attributes.bg_gradient }
                    __nextHasNoMarginBottom={ true }
                    onChange={ ( bg_gradient ) => setAttributes( { bg_gradient  } ) }
                    gradients={ [
                        {
                            name: 'Radial Gredient',
                            gradient: 'radial-gradient(88.12% 88.12% at 50% 11.88%,#e9ffde 0,#fff 100%)',
                            slug: 'gredient1'
                        }
                    ] }
                />
            : ( <MediaUpload
                    onSelect={(media) => {
                        if (media) {
                            setAttributes({ bg_image: media.sizes.full.url });
                        }
                    }}
                    render={ ({ open }) => {
                        return  attributes.bg_image ? <><img style={{marginBottom:'10px'}} onClick={open} src={ attributes.bg_image} /><Button className='editor-post-featured-image__toggle' variant="secondary" onClick={() => setAttributes( { bg_image:''  } )}>Reset</Button></> : <Button className='editor-post-featured-image__toggle' variant="secondary" onClick={open}>Open Media</Button>
                    }}
                /> ) }
            <Divider />
        </div>
    )
}
