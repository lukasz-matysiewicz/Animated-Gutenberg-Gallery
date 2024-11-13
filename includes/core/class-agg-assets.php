<?php
namespace AGG\Core;

class AGG_Assets {
    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'register_assets']);
        add_action('admin_enqueue_scripts', [$this, 'register_admin_assets']);
    }

    public function register_assets() {
        // Register GSAP
        wp_enqueue_script(
            'gsap',
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js',
            [],
            '3.12.2',
            true
        );

        // Register ScrollTrigger
        wp_enqueue_script(
            'gsap-scrolltrigger',
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js',
            ['gsap'],
            '3.12.2',
            true
        );

        // Get animation settings
        $settings = get_option('agg_settings', array(
            'animation_type' => 'fade-up',
            'animation_duration' => 1,
            'animation_stagger' => 0.2
        ));

        // Plugin CSS
        wp_enqueue_style(
            'agg-public',
            AGG_PLUGIN_URL . 'assets/css/agg-public.css',
            [],
            AGG_VERSION
        );

        // Plugin JS
        wp_enqueue_script(
            'agg-public',
            AGG_PLUGIN_URL . 'assets/js/agg-public.js',
            ['jquery', 'gsap', 'gsap-scrolltrigger'],
            AGG_VERSION,
            true
        );

        // Pass settings to JS
        wp_localize_script('agg-public', 'aggSettings', $settings);
    }

    public function register_admin_assets($hook) {
        if (strpos($hook, 'animate-gutenberg-gallery') !== false) {
            wp_enqueue_style(
                'agg-admin',
                AGG_PLUGIN_URL . 'assets/css/agg-admin.css',
                [],
                AGG_VERSION
            );
        }
    }
}