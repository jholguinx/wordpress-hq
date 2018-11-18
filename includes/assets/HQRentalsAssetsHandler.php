<?php

namespace HQRentalsPlugin\HQRentalsAssets;

class HQRentalsAssetsHandler
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', array( $this, 'registerPluginAssets' ));
    }
    public function registerPluginAssets()
    {
        wp_register_style('hq-wordpress-styles', plugin_dir_url(__FILE__) . 'css/hq-rentals.css', array(), '0.0.2', true);
        wp_register_script( 'hq-iframe-resizer-script', plugin_dir_url(__FILE__) . 'js/iframeSizer.min.js', array(), '1.0.0', true);
        wp_register_script( 'hq-moment-script', plugin_dir_url(__FILE__) . 'js/moment.js', array(), '1.0.0', true);
        wp_register_script( 'hq-resize-script', plugin_dir_url(__FILE__) . 'js/hq-resize.js', array(), '1.0.0', true);
        wp_register_script( 'hq-submit-script', plugin_dir_url(__FILE__) . 'js/hq-submit.js', array(), '1.0.0', true);
        wp_register_script( 'hq-dummy-script', plugin_dir_url(__FILE__) . 'js/hq-dummy.js', array(), '1.0.0', true);
    }
}
