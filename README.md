# === Animated Gutenberg Gallery ===
Requires at least: 6.4
Tested up to: 6.7
Requires PHP: 7.0
Stable tag: 1.1.1
License: Regular License: https://codecanyon.net/licenses/terms/regular

# Animated Gutenberg Gallery

Beautiful GSAP animations for WordPress Gutenberg gallery blocks.

## Description
Add professional animations and lightbox functionality to your WordPress gallery blocks with GSAP animations.

## Actions & Filters
- `agg_animation_options` - Modify available animation options
- `agg_hover_effects` - Modify available hover effects
- `agg_gallery_settings` - Filter gallery settings before output

## Installation
1. Upload plugin zip through WordPress admin
2. Activate plugin
3. Configure settings under AG Gallery menu

## Installation
1. Upload the plugin files to `/wp-content/plugins/animated-gutenberg-gallery`
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings->AG Gallery screen to configure the plugin

## Requirements
- WordPress 5.0 or higher
- PHP 7.4 or higher
- Modern browsers supporting CSS3 animations

## Usage
1. Create a gallery block in WordPress
2. The animations will be automatically applied
3. Customize settings in the AG Gallery settings page

    ## Structure
```
animated-gutenberg-gallery/
├── assets/                 # Frontend resources
│   ├── css/                # Stylesheets
│   │   ├── agg-admin.css   # Admin styles
│   │   └── agg-public.css  # Public styles
│   ├── js/                 # JavaScript files
│   │   ├── agg-admin.js    # Admin scripts
│   │   └── agg-public.js   # Public scripts
│   │   └── agg-editor.js   # Gutenberg block scripts
│   └── images/             # Images and icons
├── includes/               # PHP classes
│   ├── admin/              # Admin functionality
│   │   ├── class-agg-admin.php
│   │   └── views/
│   ├── core/               # Core functionality
│   │   ├── class-agg-activator.php
│   │   ├── class-agg-assets.php
│   │   └── ...
│   └── frontend/           # Frontend functionality
├── languages/              # Translations
└── animated-gutenberg-gallery.php
```

## Licensing
This plugin is sold exclusively on Envato Market (CodeCanyon) under either:
- Regular License
- Extended License

For license details, see LICENSE.txt or visit:
https://codecanyon.net/licenses/standard

## Support
For support inquiries:
- Email: support@matysiewicz.studio
- Website: https://matysiewicz.studio

## Version History
- 1.1.1: Added branding
- 1.1.0: Lightbox works asynchronously with fade animations
- 1.0.9: Removed effects on single images
- 1.0.8: Added Switcher on/off to Galleries
- 1.0.7: Added lazy load animation, 
- 1.0.6: Added Compatibility with Polylang and WPML
- 1.0.5: Added CSS fixes
- 1.0.4: Added Live Preview
- 1.0.3: Added Hover Effects
- 1.0.2: Added Animation Effects
- 1.0.1: Added Lightbox Functionality
- 1.0.0: Initial release

## Credits
Created by Matysiewicz Studio
Copyright (c) 2024 Matysiewicz Studio