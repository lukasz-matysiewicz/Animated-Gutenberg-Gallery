<?php
/**
 * @package    AnimateGutenbergGallery
 * @author     Matysiewicz Studio <support@matysiewicz.studio>
 * @copyright  Copyright (c) 2024 Matysiewicz Studio
 * 
 * This is a commercial plugin, licensed under CodeCanyon's Regular/Extended License.
 * For full license details see: https://codecanyon.net/licenses/terms/regular
 */

namespace AGG\Core;

class AGG_Requirements {
    const MIN_PHP_VERSION = '7.4';
    const MIN_WP_VERSION = '5.0';
    const MIN_MYSQL_VERSION = '5.6';

    public static function check() {
        $errors = [];

        if (!self::check_php_version()) {
            $errors[] = sprintf(
                __('AG Gallery requires PHP version %s or higher.', 'animate-gutenberg-gallery'),
                self::MIN_PHP_VERSION
            );
        }

        if (!self::check_wp_version()) {
            $errors[] = sprintf(
                __('AG Gallery requires WordPress version %s or higher.', 'animate-gutenberg-gallery'),
                self::MIN_WP_VERSION
            );
        }

        if (!empty($errors)) {
            deactivate_plugins(AGG_PLUGIN_BASENAME);
            wp_die(implode('<br>', $errors));
        }

        return true;
    }

    private static function check_php_version() {
        return version_compare(PHP_VERSION, self::MIN_PHP_VERSION, '>=');
    }

    private static function check_wp_version() {
        global $wp_version;
        return version_compare($wp_version, self::MIN_WP_VERSION, '>=');
    }
}