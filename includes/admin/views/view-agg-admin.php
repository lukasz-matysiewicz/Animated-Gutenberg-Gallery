<?php
/**
 * @package    AnimatedGutenbergGallery
 * @author     Matysiewicz Studio <support@matysiewicz.studio>
 * @copyright  Copyright (c) 2024 Matysiewicz Studio
 * 
 * This is a commercial plugin, licensed under CodeCanyon's Regular/Extended License.
 * For full license details see: https://codecanyon.net/licenses/terms/regular
 */

if (!defined('ABSPATH') || !current_user_can('manage_options')) {
    exit;
}

// Add nonce field
wp_nonce_field('agg_settings_action', 'agg_settings_nonce');

$settings = get_option('agg_settings', array(
    'animation_type' => 'zoom',
    'animation_duration' => 1,
    'animation_stagger' => 0.2,
    'hover_effect' => 'zoom'
));
?>

<div class="wrap agg-admin-wrap">
    <div class="agg-header">
        <img src="<?php echo esc_url(AGG_PLUGIN_URL . 'assets/images/logo-agg.webp'); ?>" 
             alt="<?php echo esc_attr__('Animated Gutenberg Gallery Logo', 'animated-gutenberg-gallery'); ?>" 
             class="agg-logo">
        <h1 class="agg-admin-title">Animated Gutenberg Gallery</h1>
    </div>

    <form method="post" action="options.php">
        <?php settings_fields('agg_options'); ?>

        <div class="agg-settings-content">
            <div class="agg-main-settings">
                <div class="agg-section">
                    <h2 class="agg-section-title"><?php esc_html_e('Animation Effects', 'animated-gutenberg-gallery'); ?></h2>
                    <div class="agg-button-group">
                        <?php
                            $effects = [
                                'none' => esc_html__('None', 'animated-gutenberg-gallery'),
                                'fade' => esc_html__('Fade In', 'animated-gutenberg-gallery'),
                                'fade-up' => esc_html__('Fade Up', 'animated-gutenberg-gallery'),
                                'fade-left' => esc_html__('Fade Left', 'animated-gutenberg-gallery'),
                                'zoom' => esc_html__('Zoom In', 'animated-gutenberg-gallery'),
                                'alternate-scroll' => esc_html__('Alternate Scroll', 'animated-gutenberg-gallery')
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

                    <h2 class="agg-section-title"><?php esc_html_e('Animation Timing', 'animated-gutenberg-gallery'); ?></h2>
                    <div class="agg-input-group">
                        <label class="agg-input-label">
                            <?php esc_html_e('Duration (seconds)', 'animated-gutenberg-gallery'); ?>
                        </label>
                        <input type="number" 
                               class="agg-input"
                               name="agg_settings[animation_duration]" 
                               value="<?php echo esc_attr($settings['animation_duration']); ?>"
                               step="0.1"
                               min="0.1"
                               max="3">
                        <span class="agg-input-hint"><?php echo esc_html__('Min: 0.1s, Max: 3s', 'animated-gutenberg-gallery'); ?></span>
                    </div>
                </div>

                <div class="agg-section">
                    <h2 class="agg-section-title"><?php esc_html_e('Hover Effects', 'animated-gutenberg-gallery'); ?></h2>
                    <div class="agg-button-group">
                        <?php
                        $hover_effects = [
                            'none' => esc_html__('None', 'animated-gutenberg-gallery'),
                            'zoom' => esc_html__('Zoom', 'animated-gutenberg-gallery'),
                            'lift' => esc_html__('Lift Up', 'animated-gutenberg-gallery'),
                            'tilt' => esc_html__('3D Tilt', 'animated-gutenberg-gallery')
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

                <?php submit_button(esc_html__('Save Changes', 'animated-gutenberg-gallery')); ?>
            </div>

            <div class="agg-preview-section">
                <h2 class="agg-section-title"><?php esc_html_e('Live Preview', 'animated-gutenberg-gallery'); ?></h2>
                <div class="agg-preview-flex">
                    <div class="agg-preview-item" id="preview-1">
                        <img src="<?php echo esc_url(AGG_PLUGIN_URL . 'assets/images/preview.webp'); ?>" alt="<?php echo esc_attr__('Preview 1', 'animated-gutenberg-gallery'); ?>">
                    </div>
                    <div class="agg-preview-item" id="preview-2">
                        <img src="<?php echo esc_url(AGG_PLUGIN_URL . 'assets/images/preview2.webp'); ?>" alt="<?php echo esc_attr__('Preview 2', 'animated-gutenberg-gallery'); ?>">
                    </div>
                </div>
                <button type="button" class="agg-button agg-preview-button">
                    <?php esc_html_e('Play Animation', 'animated-gutenberg-gallery'); ?>
                </button>
            </div>
        </div>
    </form>

    <footer class="agg-footer">
        <p>
            <?php echo esc_html__('Need help? Contact support at', 'animated-gutenberg-gallery'); ?>
            <a href="mailto:support@matysiewicz.studio">support@matysiewicz.studio</a>
        </p>
    </footer>
</div>
