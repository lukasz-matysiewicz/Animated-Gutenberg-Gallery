const { createHigherOrderComponent } = wp.compose;
const { InspectorControls } = wp.blockEditor || wp.editor;
const { PanelBody, ExternalLink } = wp.components;

const withAGGSettings = createHigherOrderComponent((BlockEdit) => {
    return (props) => {
        if (props.name !== 'core/gallery') {
            return wp.element.createElement(BlockEdit, props);
        }

        return wp.element.createElement(
            wp.element.Fragment,
            null,
            wp.element.createElement(BlockEdit, props),
            wp.element.createElement(
                InspectorControls,
                null,
                wp.element.createElement(
                    PanelBody,
                    {
                        title: 'Animations',
                        initialOpen: false,
                    },
                    wp.element.createElement(
                        ExternalLink,
                        { href: aggEditorSettings.aggSettingsUrl },
                        'AG Gallery Settings'
                    )
                )
            )
        );
    };
}, 'withAGGSettings');

wp.hooks.addFilter(
    'editor.BlockEdit',
    'agg/with-settings',
    withAGGSettings
);
