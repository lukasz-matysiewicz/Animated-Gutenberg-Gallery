<?php
/**
 * @package    AnimateGutenbergGallery
 * @author     Matysiewicz Studio <support@matysiewicz.studio>
 * @copyright  Copyright (c) 2024 Matysiewicz Studio
 */

namespace AGG\Admin;

class AGG_Admin {
    public function __construct() {
        add_action('admin_menu', [$this, 'add_plugin_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function add_plugin_admin_menu() {
        add_menu_page(
            __('AG Gallery', 'animate-gutenberg-gallery'),
            __('AG Gallery', 'animate-gutenberg-gallery'),
            'manage_options',
            'animate-gutenberg-gallery',
            [$this, 'display_plugin_admin_page'],
            'dashicons-format-gallery',
            30
        );
    }

    public function register_settings() {
        register_setting('agg_options', 'agg_settings');
    }

    public function display_plugin_admin_page() {
        require_once AGG_PLUGIN_DIR . 'includes/admin/views/view-agg-admin.php';
    }
}