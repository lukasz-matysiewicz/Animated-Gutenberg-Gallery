<?php
/**
 * @package    AnimateGutenbergGallery
 * @author     Matysiewicz Studio <support@matysiewicz.studio>
 * @copyright  Copyright (c) 2024 Matysiewicz Studio
 */

namespace AGG\Core;

class AGG_Gallery {
    public function __construct() {
        add_filter('render_block', [$this, 'modify_gallery_block'], 10, 2);
    }

    public function modify_gallery_block($block_content, $block) {
        if ($block['blockName'] !== 'core/gallery') {
            return $block_content;
        }

        // Add size-large class to individual images
        $block_content = preg_replace(
            '/<figure class="wp-block-image/',
            '<figure class="wp-block-image size-large',
            $block_content
        );

        return $block_content;
    }
}