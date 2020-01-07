<?php

namespace HQRentalsPlugin\HQRentalsAssets;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesWorkspotLocations;
use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesBrands;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesLocations;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesVehicleClasses;


class HQRentalsAssetsHandler
{
	public static $count = 0;

	protected $brandsGlobalFrontName = 'hqRentalsBrands';
    protected $locationsGlobalFrontName = 'hqRentalsLocations';
    protected $vehiclesGlobalFrontName = 'hqRentalsVehicles';
    protected $frontDateFormatFrontName = 'hqRentalsFrontEndDateformat';
    protected $systemDateFormatFrontName = 'hqRentalsSystemDateformat';
    protected $workspotLocationsDataName = 'hqWorkspotLocations';
    protected $workspotLocationDataForShortcodeName = 'hqWorkspotLocationsShortcodes';
    protected $tenantDatetimeFormatFrontName = 'hqRentalsTenantDatetimeFormat';
    protected $pluginVersion = '1.3.4';

    public function __construct()
    {
	    static::$count++;
        $this->brandQueries = new HQRentalsQueriesBrands();
        $this->locationQueries = new HQRentalsQueriesLocations();
        $this->vehicleQueries = new HQRentalsQueriesVehicleClasses();
        $this->settings = new HQRentalsSettings();
        $this->workspotQuery = new HQRentalsQueriesWorkspotLocations();
	    if (static::$count === 1) {
		    add_action('wp_enqueue_scripts', array( $this, 'registerPluginAssets' ), 10);
            add_action('wp_enqueue_scripts', array($this, 'registerAndEnqueueFrontEndGlobalVariables'), 20);
            add_action('admin_enqueue_scripts', array($this, 'registerAdminAssets'), 20);
	    }
    }
    public function registerPluginAssets()
    {
        wp_register_style('hq-wordpress-iframe-styles', plugin_dir_url(__FILE__) . 'css/hq-rentals.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_style('hq-wordpress-workspot-styles', plugin_dir_url(__FILE__) . 'css/hq-workspot-styles.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_style('hq-wordpress-openlayer-styles', plugin_dir_url(__FILE__) . 'css/ol.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_script( 'hq-iframe-resizer-script', plugin_dir_url(__FILE__) . 'js/iframeResizer.min.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script( 'hq-moment', plugin_dir_url(__FILE__) . 'js/moment.min.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script( 'hq-wordpress-openlayer-js', plugin_dir_url(__FILE__) . 'js/ol.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script( 'hq-wordpress-workspot-js', plugin_dir_url(__FILE__) . 'js/hq-workspot-maps.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script( 'hq-resize-script', plugin_dir_url(__FILE__) . 'js/hq-resize.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script( 'hq-scroll-script', plugin_dir_url(__FILE__) . 'js/hq-scroll-to-top.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script( 'hq-submit-script', plugin_dir_url(__FILE__) . 'js/hq-submit.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script( 'hq-dummy-script', plugin_dir_url(__FILE__) . 'js/hq-dummy.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script( 'hq-workspot-sc-script', plugin_dir_url(__FILE__) . 'js/hq-workspot-map-shortcode.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script( 'hq-karzoom-form-script', plugin_dir_url(__FILE__) . 'js/hq-karzoom-booking-form.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script( 'hq-karzoom-contact-form-script', plugin_dir_url(__FILE__) . 'js/hq-karzoom-contact-form.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_enqueue_script('hq-dummy-script');
    }
    public function getIframeResizerAssets()
    {
        wp_enqueue_script('hq-iframe-resizer-script');
        wp_enqueue_script( 'hq-resize-script');
        wp_enqueue_style('hq-wordpress-iframe-styles');
    }
    public function loadScrollScript(){
        wp_enqueue_script("hq-scroll-script");
    }

    public function getFirstStepShortcodeAssets()
    {
        $this->getIframeResizerAssets();
        wp_enqueue_script('hq-submit-script');
    }


    public function loadWorkspotAssetsForShortcodes()
    {
        wp_enqueue_style('hq-wordpress-openlayer-styles');
        wp_enqueue_style('hq-wordpress-workspot-styles');
        wp_enqueue_script("hq-wordpress-openlayer-js");
        wp_enqueue_script("hq-workspot-sc-script");
    }
    public function registerAndEnqueueFrontEndGlobalVariables()
    {
        $site = get_site_url();
	    wp_localize_script('hq-dummy-script', $this->brandsGlobalFrontName, $this->brandQueries->allToFrontEnd());
	    wp_localize_script('hq-dummy-script', $this->locationsGlobalFrontName, $this->locationQueries->allToFrontEnd());
	    wp_localize_script('hq-dummy-script', $this->vehiclesGlobalFrontName, $this->vehicleQueries->allToFrontEnd());
		wp_localize_script('hq-dummy-script', $this->frontDateFormatFrontName, $this->settings->getFrontEndDatetimeFormat());
		wp_localize_script('hq-dummy-script', $this->systemDateFormatFrontName, $this->settings->getHQDatetimeFormat());
		wp_localize_script( 'hq-dummy-script', $this->tenantDatetimeFormatFrontName, $this->settings->getTenantDatetimeFormat());
		/*
		 * Just for Workspot
		 * */
        if($site == 'http://workspot.test' or $site == 'https://workspot.nu'){
            wp_localize_script('hq-dummy-script', $this->workspotLocationsDataName, $this->workspotQuery->getLocationsToFrontEnd());
        }
    }
    public function loadKarzoomFormAssets()
    {
        wp_enqueue_script("hq-karzoom-form-script");
    }
    public function loadKarzoomContactAssets()
    {
        wp_enqueue_script("hq-karzoom-contact-form-script");
    }
    public function registerAdminAssets()
    {
        wp_register_script('hq-admin-tooltip-js', plugin_dir_url(__FILE__) . 'js/tooltip.min.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-admin-poper-js', plugin_dir_url(__FILE__) . 'js/popper.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-admin-admin-js', plugin_dir_url(__FILE__) . 'js/admin.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
    }
    public function loadAssetsForAdmin()
    {
        wp_enqueue_script('hq-admin-poper-js');
        wp_enqueue_script('hq-admin-tooltip-js');
        wp_enqueue_script('hq-admin-admin-js');
    }
}
