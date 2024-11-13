<?php
/**
 * @package    AnimateGutenbergGallery
 * @author     Matysiewicz Studio <support@matysiewicz.studio>
 * @copyright  Copyright (c) 2024 Matysiewicz Studio
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get plugin settings with defaults
$settings = get_option('agg_settings', array(
    'animation_type' => 'fade-up',
    'animation_duration' => 1,
    'animation_stagger' => 0.2
));
?>

<div class="wrap">
    <div class="agg-admin-header">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    </div>

    <form method="post" action="options.php" id="agg-settings-form" class="agg-settings-form">
        <?php
        settings_fields('agg_options');
        do_settings_sections('agg_options');
        ?>

        <div class="agg-settings-group">
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row">
                        <?php esc_html_e('Animation Effect', 'animate-gutenberg-gallery'); ?>
                    </th>
                    <td>
                        <select name="agg_settings[animation_type]">
                            <option value="fade" <?php selected($settings['animation_type'], 'fade'); ?>>
                                <?php esc_html_e('Fade In', 'animate-gutenberg-gallery'); ?>
                            </option>
                            <option value="fade-up" <?php selected($settings['animation_type'], 'fade-up'); ?>>
                                <?php esc_html_e('Fade Up', 'animate-gutenberg-gallery'); ?>
                            </option>
                            <option value="fade-left" <?php selected($settings['animation_type'], 'fade-left'); ?>>
                                <?php esc_html_e('Fade Left', 'animate-gutenberg-gallery'); ?>
                            </option>
                            <option value="zoom" <?php selected($settings['animation_type'], 'zoom'); ?>>
                                <?php esc_html_e('Zoom In', 'animate-gutenberg-gallery'); ?>
                            </option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php esc_html_e('Animation Duration (seconds)', 'animate-gutenberg-gallery'); ?>
                    </th>
                    <td>
                        <input 
                            type="number" 
                            name="agg_settings[animation_duration]" 
                            value="<?php echo esc_attr($settings['animation_duration']); ?>"
                            step="0.1"
                            min="0.1"
                            max="3"
                        >
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php esc_html_e('Stagger Delay (seconds)', 'animate-gutenberg-gallery'); ?>
                    </th>
                    <td>
                        <input 
                            type="number" 
                            name="agg_settings[animation_stagger]" 
                            value="<?php echo esc_attr($settings['animation_stagger']); ?>"
                            step="0.1"
                            min="0"
                            max="1"
                        >
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php esc_html_e('Hover Effect', 'animate-gutenberg-gallery'); ?>
                    </th>
                    <td>
                        <select name="agg_settings[hover_effect]">
                            <option value="none" <?php selected($settings['hover_effect'], 'none'); ?>>
                                <?php esc_html_e('None', 'animate-gutenberg-gallery'); ?>
                            </option>
                            <option value="zoom" <?php selected($settings['hover_effect'], 'zoom'); ?>>
                                <?php esc_html_e('Zoom', 'animate-gutenberg-gallery'); ?>
                            </option>
                            <option value="lift" <?php selected($settings['hover_effect'], 'lift'); ?>>
                                <?php esc_html_e('Lift Up', 'animate-gutenberg-gallery'); ?>
                            </option>
                            <option value="tilt" <?php selected($settings['hover_effect'], 'tilt'); ?>>
                                <?php esc_html_e('Tilt', 'animate-gutenberg-gallery'); ?>
                            </option>
                        </select>
                    </td>
                </tr>
            </table>
        </div>

        <?php submit_button(); ?>
    </form>
</div>