// /assets/js/agg-editor.js
const { createHigherOrderComponent } = wp.compose;
const { InspectorControls } = wp.blockEditor || wp.editor;
const { PanelBody, ExternalLink } = wp.components;
const { __ } = wp.i18n;

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
                        title: __('Animations', 'animate-gutenberg-gallery'),
                        initialOpen: false,
                    },
                    wp.element.createElement(
                        ExternalLink,
                        { href: aggEditorSettings.aggSettingsUrl },
                        __('AG Gallery Settings', 'animate-gutenberg-gallery')
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