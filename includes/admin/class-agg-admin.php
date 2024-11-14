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
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
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
        register_setting(
            'agg_options',
            'agg_settings',
            array(
                'type' => 'array',
                'sanitize_callback' => array($this, 'sanitize_settings')
            )
        );
    }

    public function sanitize_settings($input) {
        return array(
            'animation_type' => sanitize_text_field($input['animation_type']),
            'animation_duration' => floatval($input['animation_duration']),
            'animation_stagger' => floatval($input['animation_stagger']),
            'hover_effect' => sanitize_text_field($input['hover_effect'])
        );
    }

    public function enqueue_admin_scripts($hook) {
        if (strpos($hook, 'animate-gutenberg-gallery') === false) {
            return;
        }

        wp_enqueue_script(
            'gsap',
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js',
            [],
            '3.12.2',
            true
        );

        wp_enqueue_script(
            'agg-admin',
            AGG_PLUGIN_URL . 'assets/js/agg-admin.js',
            ['jquery', 'gsap'],
            AGG_VERSION,
            true
        );

        wp_enqueue_style(
            'agg-admin',
            AGG_PLUGIN_URL . 'assets/css/agg-admin.css',
            [],
            AGG_VERSION
        );
    }

    public function display_plugin_admin_page() {
        require_once AGG_PLUGIN_DIR . 'includes/admin/views/view-agg-admin.php';
    }
}