import { SelectControl, __experimentalVStack as VStack } from '@wordpress/components';

const HeadingToolbar = ({ attributes, setAttributes, prefix }) => {
  return (
    <div style={{ width: '100%' }} >
      <VStack spacing={0}>
        <SelectControl
            label="Heading Tag"
            value={ attributes.headingTag }
            options={ [
              { label: 'Heading 1', value: 'h1' },
              { label: 'Heading 2', value: 'h2' },
              { label: 'Heading 3', value: 'h3' },
              { label: 'Heading 4', value: 'h4' },
              { label: 'Heading 5', value: 'h5' },
              { label: 'Heading 6', value: 'h6' },
            ] }
            onChange={ ( headingTag ) => setAttributes( { headingTag  } ) }
        />
      </VStack>
      <VStack spacing={0}>
          <SelectControl
            label="Heading Font-Weight"
            value={attributes.fontweight}
            options={[
                { label: '100', value: '100' },
                { label: '200', value: '200' },
                { label: '300', value: '300' },
                { label: '400', value: '400' },
                { label: '500', value: '500' },
                { label: '600', value: '600' },
                { label: '700 (Bold)', value: '700' },
                { label: '800', value: '800' },
                { label: '900', value: '900' },
            ]}
            onChange={(value) => setAttributes({ fontweight: value })}
        />
      </VStack>
    </div>
  );
};

export default HeadingToolbar;
