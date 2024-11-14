<?php
/**
 * @package    AnimateGutenbergGallery
 * @author     Matysiewicz Studio <support@matysiewicz.studio>
 * @copyright  Copyright (c) 2024 Matysiewicz Studio
 */

if (!defined('ABSPATH')) {
    exit;
}

$settings = get_option('agg_settings', array(
    'animation_type' => 'zoom',
    'animation_duration' => 1,
    'animation_stagger' => 0.2,
    'hover_effect' => 'zoom'
));
?>

<div class="wrap agg-admin-wrap">
    <h1 class="agg-admin-title"><?php echo esc_html(get_admin_page_title()); ?></h1>

    <form method="post" action="options.php">
        <?php settings_fields('agg_options'); ?>

        <div class="agg-settings-content">
            <div class="agg-main-settings">
                <div class="agg-section">
                    <h2 class="agg-section-title"><?php esc_html_e('Animation Effects', 'animate-gutenberg-gallery'); ?></h2>
                    <div class="agg-button-group">
                        <?php
                        $effects = [
                            'none' => 'None',
                            'fade' => 'Fade In',
                            'fade-up' => 'Fade Up',
                            'fade-left' => 'Fade Left',
                            'zoom' => 'Zoom In'
                        ];
                        foreach ($effects as $value => $label) : ?>
                            <button type="button" 
                                    class="agg-button <?php echo $settings['animation_type'] === $value ? 'active' : ''; ?>"
                                    data-value="<?php echo esc_attr($value); ?>">
                                <?php echo esc_html($label); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                    <input type="hidden" name="agg_settings[animation_type]" id="animation_type" value="<?php echo esc_attr($settings['animation_type']); ?>">

                    <h2 class="agg-section-title"><?php esc_html_e('Animation Timing', 'animate-gutenberg-gallery'); ?></h2>
                    <div class="agg-input-group">
                        <label class="agg-input-label">
                            <?php esc_html_e('Duration (seconds)', 'animate-gutenberg-gallery'); ?>
                        </label>
                        <input type="number" 
                               class="agg-input"
                               name="agg_settings[animation_duration]" 
                               value="<?php echo esc_attr($settings['animation_duration']); ?>"
                               step="0.1"
                               min="0.1"
                               max="3">
                        <span class="agg-input-hint">Min: 0.1s, Max: 3s</span>
                    </div>

                    <div class="agg-input-group">
                        <label class="agg-input-label">
                            <?php esc_html_e('Stagger Delay', 'animate-gutenberg-gallery'); ?>
                        </label>
                        <input type="number"
                               class="agg-input"
                               name="agg_settings[animation_stagger]" 
                               value="<?php echo esc_attr($settings['animation_stagger']); ?>"
                               step="0.1"
                               min="0"
                               max="1">
                        <span class="agg-input-hint">Min: 0s, Max: 1s</span>
                    </div>
                </div>

                <div class="agg-section">
                    <h2 class="agg-section-title"><?php esc_html_e('Hover Effects', 'animate-gutenberg-gallery'); ?></h2>
                    <div class="agg-button-group">
                        <?php
                        $hover_effects = [
                            'none' => 'None',
                            'zoom' => 'Zoom',
                            'lift' => 'Lift Up',
                            'tilt' => '3D Tilt'
                        ];
                        foreach ($hover_effects as $value => $label) : ?>
                            <button type="button" 
                                    class="agg-button <?php echo $settings['hover_effect'] === $value ? 'active' : ''; ?>"
                                    data-value="<?php echo esc_attr($value); ?>">
                                <?php echo esc_html($label); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                    <input type="hidden" name="agg_settings[hover_effect]" id="hover_effect" value="<?php echo esc_attr($settings['hover_effect']); ?>">
                </div>

                <?php submit_button(); ?>
            </div>

            <div class="agg-preview-section">
                <h2 class="agg-section-title"><?php esc_html_e('Live Preview', 'animate-gutenberg-gallery'); ?></h2>
                <div class="agg-preview-flex">
                    <div class="agg-preview-item" id="preview-1">
                        <img src="<?php echo esc_url(AGG_PLUGIN_URL . 'assets/images/preview.webp'); ?>" alt="Preview 1">
                    </div>
                    <div class="agg-preview-item" id="preview-2">
                        <img src="<?php echo esc_url(AGG_PLUGIN_URL . 'assets/images/preview2.webp'); ?>" alt="Preview 2">
                    </div>
                </div>
                <button type="button" class="agg-button agg-preview-button">
                    <?php esc_html_e('Play Animation', 'animate-gutenberg-gallery'); ?>
                </button>
            </div>
        </div>
    </form>

    <footer class="agg-footer">
        <p>
            <?php esc_html_e('Need help? Contact support at', 'animate-gutenberg-gallery'); ?>
            <a href="mailto:support@matysiewicz.studio">support@matysiewicz.studio</a>
        </p>
    </footer>
</div>