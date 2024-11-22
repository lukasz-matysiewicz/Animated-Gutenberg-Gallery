<?php
/**
 * @package    AnimatedGutenbergGallery
 * @author     Matysiewicz Studio <support@matysiewicz.studio>
 * @copyright  Copyright (c) 2024 Matysiewicz Studio
 * 
 * This is a commercial plugin, licensed under CodeCanyon's Regular/Extended License.
 * For full license details see: https://codecanyon.net/licenses/terms/regular
 */

namespace AGG\Core;

class AGG_Gallery {
    public function __construct() {
        add_filter('render_block', [$this, 'modify_gallery_block'], 10, 2);
        add_filter('block_editor_settings_all', [$this, 'add_editor_settings']);
        add_action('enqueue_block_editor_assets', [$this, 'enqueue_editor_assets']);
    }

    public function modify_gallery_block($block_content, $block) {
        if ($block['blockName'] !== 'core/gallery') {
            return $block_content;
        }

        $attrs = $block['attrs'] ?? [];
        $lightbox = $attrs['aggLightbox'] ?? true;  // Default ON
        $animations = $attrs['aggAnimations'] ?? true;  // Default ON

        $classes = ['agg-gallery'];
        if ($lightbox) $classes[] = 'agg-lightbox';
        if ($animations) $classes[] = 'agg-animated';

        // Add classes to gallery wrapper
        $block_content = preg_replace(
            '/(wp-block-gallery\s[^"]*)"/',
            '$1 ' . implode(' ', $classes) . '"',
            $block_content
        );

        return $block_content;
    }

    public function add_editor_settings($settings) {
        $settings['aggSettingsUrl'] = admin_url('admin.php?page=animated-gutenberg-gallery');
        return $settings;
    }

    public function enqueue_editor_assets() {
        wp_enqueue_script(
            'agg-editor',
            AGG_PLUGIN_URL . 'assets/js/agg-editor.js',
            ['wp-blocks', 'wp-element', 'wp-components', 'wp-block-editor', 'wp-compose'],
            AGG_VERSION,
            true
        );

        wp_localize_script('agg-editor', 'aggEditorSettings', [
            'aggSettingsUrl' => admin_url('admin.php?page=animated-gutenberg-gallery')
        ]);
    }
}