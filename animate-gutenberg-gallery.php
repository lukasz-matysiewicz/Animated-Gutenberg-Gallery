<?php
/**
 * Plugin Name: Animate Gutenberg Gallery
 * Plugin URI: https://matysiewicz.studio/animate-gutenberg-gallery
 * Description: Add beautiful GSAP animations to Gutenberg gallery blocks
 * Requires at least: 5.0
 * Requires PHP: 7.4
 * Version: 1.0.6
 * Author: Matysiewicz Studio
 * Author URI: https://matysiewicz.studio
 * License: Regular License or Extended License
 * License URI: https://codecanyon.net/licenses/standard
 * Text Domain: animate-gutenberg-gallery
 * Domain Path: /languages
 * 
 * @package AnimateGutenbergGallery
 * @author Matysiewicz Studio
 * @copyright Copyright (c) 2024, Matysiewicz Studio
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Current plugin version.
 */
define('AGG_VERSION', '1.0.0');
define('AGG_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('AGG_PLUGIN_URL', plugin_dir_url(__FILE__));
define('AGG_PLUGIN_BASENAME', plugin_basename(__FILE__));

// Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'AGG\\';
    $base_dir = AGG_PLUGIN_DIR . 'includes/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relative_class = substr($class, $len);
    $file = $base_dir;
    
    $namespace_parts = explode('\\', $relative_class);
    if (count($namespace_parts) > 1) {
        $class_name = array_pop($namespace_parts);
        $file .= strtolower(implode('/', $namespace_parts)) . '/';
    } else {
        $class_name = $relative_class;
    }
    
    $file .= 'class-agg-' . strtolower(str_replace('AGG_', '', $class_name)) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

/**
 * The code that runs during plugin activation.
 */
function activate_animate_gutenberg_gallery() {
    require_once AGG_PLUGIN_DIR . 'includes/core/class-agg-activator.php';
    AGG\Core\AGG_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_animate_gutenberg_gallery() {
    require_once AGG_PLUGIN_DIR . 'includes/core/class-agg-deactivator.php';
    AGG\Core\AGG_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_animate_gutenberg_gallery');
register_deactivation_hook(__FILE__, 'deactivate_animate_gutenberg_gallery');

/**
 * Begins execution of the plugin.
 */
function run_animate_gutenberg_gallery() {
    require_once AGG_PLUGIN_DIR . 'includes/core/class-agg-init.php';
    $plugin = new AGG\Core\AGG_Init();
    $plugin->run();
}
run_animate_gutenberg_gallery();