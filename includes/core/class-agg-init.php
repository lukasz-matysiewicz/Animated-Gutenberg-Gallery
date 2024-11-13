<?php
/**
 * @package    AnimateGutenbergGallery
 * @author     Matysiewicz Studio <support@matysiewicz.studio>
 * @copyright  Copyright (c) 2024 Matysiewicz Studio
 */

namespace AGG\Core;

class AGG_Init {
    protected $loader;

    public function __construct() {
        $this->loader = new AGG_Loader();
        $this->define_hooks();
    }

    private function define_hooks() {
        // Initialize core components
        new AGG_Assets();
        new AGG_Gallery();
        
        // Initialize admin
        if (is_admin()) {
            new \AGG\Admin\AGG_Admin();
        }
    }

    public function run() {
        $this->loader->run();
    }
}