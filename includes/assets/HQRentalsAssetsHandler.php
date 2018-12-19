<?php

namespace HQRentalsPlugin\HQRentalsAssets;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsBrand;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsLocation;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsVehicleClass;

class HQRentalsAssetsHandler
{
    protected $brandsGlobalFrontName = 'hqRentalsBrands';
    protected $locationsGlobalFrontName = ' hqRentalsLocations';
    protected $vehiclesGlobalFrontName = 'hqRentalsVehicles';

    public function __construct()
    {
        $this->brands = new HQRentalsModelsBrand();
        $this->locations = new HQRentalsModelsLocation();
        $this->vehicleClasses = new HQRentalsModelsVehicleClass();
        add_action('wp_enqueue_scripts', array( $this, 'registerPluginAssets' ), 10);
        add_action('wp_enqueue_scripts', array($this, 'registerAndEnqueueFrontEndGlobalVariables'), 20);
    }
    public function registerPluginAssets()
    {
        wp_register_style('hq-wordpress-iframe-styles', plugin_dir_url(__FILE__) . 'css/hq-rentals.css', array(), '1.0.1', 'all');
        wp_register_script( 'hq-iframe-resizer-script', plugin_dir_url(__FILE__) . 'js/iframeSizer.min.js', array(), '1.0.0', true);
        wp_register_script( 'hq-moment-script', plugin_dir_url(__FILE__) . 'js/moment.js', array(), '1.0.0', true);
        wp_register_script( 'hq-resize-script', plugin_dir_url(__FILE__) . 'js/hq-resize.js', array(), '1.0.1', true);
        wp_register_script( 'hq-submit-script', plugin_dir_url(__FILE__) . 'js/hq-submit.js', array(), '1.0.0', true);
        wp_register_script( 'hq-dummy-script', plugin_dir_url(__FILE__) . 'js/hq-dummy.js', array(), '1.0.0', true);
        //wp_enqueue_script('hq-dummy-script');
    }
    public function getIframeResizerAssets()
    {
        wp_enqueue_script('hq-iframe-resizer-script');
        wp_enqueue_script( 'hq-resize-script');
        wp_enqueue_style('hq-wordpress-iframe-styles');
    }
    public function getFirstStepShortcodeAssets()
    {
        $this->getIframeResizerAssets();
        wp_enqueue_script('hq-submit-script');
    }
    public function registerAndEnqueueFrontEndGlobalVariables()
    {
        $brands = $this->brands->allToFront();
        wp_localize_script('hq-dummy-script', $this->brandsGlobalFrontName, $brands);
    }
}
