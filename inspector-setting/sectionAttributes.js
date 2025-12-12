// Define section attributes object.
const sectionAttributes = {
    // General attributes applicable to all screen sizes.
    general: {
        // Background type (image, color, gradient).
        bg_type: {
            type: 'string',
            default: 'image',
        },
        // Background color.
        bg_color: {
            type: 'string',
            default: 'transparent',
        },
        // Background image URL.
        bg_image: {
            type: 'string',
            default: '',
        },
        // Background gradient CSS value.
        bg_gradient: {
            type: 'string',
            default: 'radial-gradient(88.12% 88.12% at 50% 11.88%, #e9ffde 0%, #fff 100%)',
        },
        // Responsive type (extra-large by default).
        res_type: {
            type: 'string',
            default: 'xl',
        }
    },
    // Desktop-specific attributes.
    desktop: {
        // Extra-large padding.
        xl_padding: {
            top: '',
            left: '',
            right: '',
            bottom: '',
        },
        // Extra-large margin.
        xl_margin: {
            top: '',
            left: '',
            right: '',
            bottom: '',
        },
    },
    // Large-screen specific attributes.
    large: {
        // Large padding
        lg_padding: {
            top: '',
            left: '',
            right: '',
            bottom: '',
        },
        // Large margin
        lg_margin: {
            top: '',
            left: '',
            right: '',
            bottom: '',
        },
    },
    // Tablet-specific attributes.
    tablet: {
        // Tablet padding
        tb_padding: {
            top: '',
            left: '',
            right: '',
            bottom: '',
        },
        // Tablet margin
        tb_margin: {
            top: '',
            left: '',
            right: '',
            bottom: '',
        },
    },
    // Mobile-specific attributes.
    mobile: {
        // Small screen padding.
        sm_padding: {
            top: '',
            left: '',
            right: '',
            bottom: '',
        },
        // Small screen margin.
        sm_margin: {
            top: '',
            left: '',
            right: '',
            bottom: '',
        },
    }
};

// Export section attributes object.
export default sectionAttributes;
