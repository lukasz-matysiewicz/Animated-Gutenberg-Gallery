<?php
/**
 * @package    AnimateGutenbergGallery
 * @author     Matysiewicz Studio <support@matysiewicz.studio>
 * @copyright  Copyright (c) 2024 Matysiewicz Studio
 */

namespace AGG\Core;

class AGG_Deactivator {
    public static function deactivate() {
        // Flush rewrite rules
        flush_rewrite_rules();
    }
}