<?php
namespace AGG\Core;

class AGG_Updater {
    private $plugin_slug;
    private $version;
    private $cache_key;
    private $cache_allowed;

    public function __construct() {
        $this->plugin_slug = AGG_PLUGIN_BASENAME;
        $this->version = AGG_VERSION;
        $this->cache_key = 'agg_updater';
        $this->cache_allowed = true;

        add_filter('pre_set_site_transient_update_plugins', [$this, 'check_update']);
        add_filter('plugins_api', [$this, 'plugin_info'], 10, 3);
        add_action('upgrader_process_complete', [$this, 'purge'], 10, 2);
    }

    public function check_update($transient) {
        if (empty($transient->checked)) {
            return $transient;
        }

        // Get cached info
        $cached = get_transient($this->cache_key);
        if (false !== $cached && $this->cache_allowed) {
            return $cached;
        }

        $info = $this->get_remote_info();
        if (false !== $info && is_object($info) && version_compare($this->version, $info->version, '<')) {
            $transient->response[$this->plugin_slug] = $info;
            set_transient($this->cache_key, $transient, 12 * HOUR_IN_SECONDS);
        }

        return $transient;
    }

    private function get_remote_info() {
        // Replace with your actual update server URL
        $request = wp_remote_get('https://your-update-server.com/updates/animate-gutenberg-gallery/info.json');

        if (!is_wp_error($request) && wp_remote_retrieve_response_code($request) === 200) {
            return json_decode(wp_remote_retrieve_body($request));
        }

        return false;
    }

    public function plugin_info($result, $action, $args) {
        // Check if this request is for our plugin
        if ('plugin_information' !== $action || $this->plugin_slug !== $args->slug) {
            return $result;
        }

        $info = $this->get_remote_info();
        if (false !== $info) {
            return $info;
        }

        return $result;
    }

    public function purge($upgrader, $options) {
        if ('update' === $options['action'] && 'plugin' === $options['type']) {
            delete_transient($this->cache_key);
        }
    }
}