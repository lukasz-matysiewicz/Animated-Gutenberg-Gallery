<?php
/**
 * @package    AnimateGutenbergGallery
 * @author     Matysiewicz Studio <support@matysiewicz.studio>
 * @copyright  Copyright (c) 2024 Matysiewicz Studio
 */

namespace AGG\Core;

class AGG_Activator {
    public static function activate() {
        // Set version
        add_option('agg_version', AGG_VERSION);

        // Clear permalinks
        flush_rewrite_rules();
    }
}