<?php

namespace HQRentalsPlugin\HQRentalsElementor;

class HQRentalsElementorAssetsHandler
{


    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'registerPluginAssets'), 10);
    }

    public function registerPluginAssets()
    {
        wp_register_style('hq-elementor-vehicle-grid-widget-css', plugin_dir_url(__FILE__) . 'assets/css/hq-elementor-vehicle-grid-widget.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
    }
    public static function loadVehicleGridAssets()
    {
        wp_enqueue_style('hq-elementor-vehicle-grid-widget-css');
    }
}
