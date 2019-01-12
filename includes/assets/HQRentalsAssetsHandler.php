<?php

namespace HQRentalsPlugin\HQRentalsAssets;
use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesBrands;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesLocations;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesVehicleClasses;


class HQRentalsAssetsHandler
{
    protected $brandsGlobalFrontName = 'hqRentalsBrands';
    protected $locationsGlobalFrontName = 'hqRentalsLocations';
    protected $vehiclesGlobalFrontName = 'hqRentalsVehicles';
    protected $frontDateFormatFrontName = 'hqRentalsFrontEndDateformat';
    protected $systemDateFormatFrontName = 'hqRentalsSystemDateformat';

    public function __construct()
    {
        $this->brandQueries = new HQRentalsQueriesBrands();
        $this->locationQueries = new HQRentalsQueriesLocations();
        $this->vehicleQueries = new HQRentalsQueriesVehicleClasses();
        $this->settings = new HQRentalsSettings();
        add_action('wp_enqueue_scripts', array( $this, 'registerPluginAssets' ), 10);
        add_action('wp_enqueue_scripts', array($this, 'registerAndEnqueueFrontEndGlobalVariables'), 20);
    }
    public function registerPluginAssets()
    {
        wp_register_style('hq-wordpress-iframe-styles', plugin_dir_url(__FILE__) . 'css/hq-rentals.css', array(), '1.0.1', 'all');
        wp_register_script( 'hq-iframe-resizer-script', plugin_dir_url(__FILE__) . 'js/iframeSizer.min.js', array(), '1.0.0', true);
        wp_register_script( 'hq-moment-script', plugin_dir_url(__FILE__) . 'js/moment.js', array(), '1.0.0', true);
        wp_register_script( 'hq-resize-script', plugin_dir_url(__FILE__) . 'js/hq-resize.js', array(), '1.0.1', true);
        wp_register_script( 'hq-submit-script', plugin_dir_url(__FILE__) . 'js/hq-submit.js', array(), '1.0.1', true);
        wp_register_script( 'hq-dummy-script', plugin_dir_url(__FILE__) . 'js/hq-dummy.js', array(), '1.0.0', true);
        wp_enqueue_script('hq-dummy-script');
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
        $brands = $this->brandQueries->allToFrontEnd();
        $locations = $this->locationQueries->allLocationToFrontEnd();
        $vehicles = $this->vehicleQueries->allVehicleClassesToFrontEnd();
        $frontDateFormat = $this->settings->getFrontEndDatetimeFormat();
        $systemDateFormat = $this->settings->getHQDatetimeFormat();
        wp_localize_script('hq-dummy-script', $this->brandsGlobalFrontName, $brands);
        wp_localize_script('hq-dummy-script', $this->locationsGlobalFrontName, $locations);
        wp_localize_script('hq-dummy-script', $this->vehiclesGlobalFrontName, $vehicles);
        wp_localize_script('hq-dummy-script', $this->frontDateFormatFrontName, $frontDateFormat);
        wp_localize_script('hq-dummy-script', $this->systemDateFormatFrontName, $systemDateFormat);
    }
}
