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
    protected $tenantDatetimeFormatFrontName = 'hqRentalsTenantDatetimeFormat';
    protected $site = 'hqSite';
    protected $spinner = 'hqSpinner';

    public function __construct()
    {
        static::$count++;
        $this->brandQueries = new HQRentalsQueriesBrands();
        $this->locationQueries = new HQRentalsQueriesLocations();
        $this->vehicleQueries = new HQRentalsQueriesVehicleClasses();
        $this->settings = new HQRentalsSettings();
        $this->workspotQuery = new HQRentalsQueriesWorkspotLocations();
        if (static::$count === 1) {
            add_action('wp_enqueue_scripts', array($this, 'registerPluginAssets'), 10);
            add_action('wp_enqueue_scripts', array($this, 'registerAndEnqueueFrontEndGlobalVariables'), 20);
            add_action('wp_enqueue_scripts', array($this, 'shortcodesRegistration'), 30);
            add_action('admin_enqueue_scripts', array($this, 'registerAdminAssets'), 20);
            add_action('admin_enqueue_scripts', array($this, 'adminSectionAssetResolver'), 50);
        }
    }

    public function registerPluginAssets()
    {
        wp_register_style('hq-wordpress-iframe-styles', plugin_dir_url(__FILE__) . 'css/hq-rentals.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_style('hq-wordpress-workspot-styles', plugin_dir_url(__FILE__) . 'css/hq-workspot-styles.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_style('hq-availability-grip-styles', plugin_dir_url(__FILE__) . 'css/availability-grid.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_style('hq-wordpress-openlayer-styles', plugin_dir_url(__FILE__) . 'css/ol.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_style('r-suite-default-style', plugin_dir_url(__FILE__) . 'css/rsuite/rsuite-default.min.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_style('r-suite-dark-style', plugin_dir_url(__FILE__) . 'css/rsuite/rsuite-dark.min.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_style('r-suite-dark-rtl-style', plugin_dir_url(__FILE__) . 'css/rsuite/rsuite-dark-rtl.min.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_style('hq-datepicker-style', plugin_dir_url(__FILE__) . 'css/jquery.datetimepicker.min.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_style('r-suite-default-rtl-style', plugin_dir_url(__FILE__) . 'css/rsuite/rsuite-default-rtl.min.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_style('hq-map-form-style', plugin_dir_url(__FILE__) . 'css/hq-gcar-map.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_script('hq-iframe-resizer-script', plugin_dir_url(__FILE__) . 'js/iframeResizer.min.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-moment', plugin_dir_url(__FILE__) . 'js/moment.min.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-datepicker-js', plugin_dir_url(__FILE__) . 'js/jquery.datetimepicker.full.min.js', array('jquery'), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-wordpress-openlayer-js', plugin_dir_url(__FILE__) . 'js/ol.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-wordpress-workspot-js', plugin_dir_url(__FILE__) . 'js/hq-workspot-maps.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-resize-script', plugin_dir_url(__FILE__) . 'js/hq-resize.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-scroll-script', plugin_dir_url(__FILE__) . 'js/hq-scroll-to-top.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-submit-script', plugin_dir_url(__FILE__) . 'js/hq-submit.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-dummy-script', plugin_dir_url(__FILE__) . 'js/hq-dummy.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-wordpress-dates-js', plugin_dir_url(__FILE__) . 'js/hq-dates-pickers.js', array('jquery'), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-workspot-sc-script', plugin_dir_url(__FILE__) . 'js/hq-workspot-map-shortcode.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-map-form-script', plugin_dir_url(__FILE__) . 'js/hq-map-booking-form.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-map-contact-form-script', plugin_dir_url(__FILE__) . 'js/hq-map-contact-form.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-availability-grip-script', plugin_dir_url(__FILE__) . 'js/hq-availability-grid.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hg-gcar-vehicle-filter-js', plugin_dir_url(__FILE__) . 'js/hq-gcar-vehicle-filter.js', array(), HQ_RENTALS_PLUGIN_VERSION . '1', true);
        wp_register_script('hq-reservation-form-setup', plugin_dir_url(__FILE__) . 'js/hq-reservation-form-setup.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_enqueue_script('hq-dummy-script');
        global $post;
        $theme = wp_get_theme();
        if (is_single() and $post->post_type === 'hqwp_veh_classes' and $theme->stylesheet === 'grandcarrental') {
            $this->datePickersAssets();
        }
    }

    public function getIframeResizerAssets()
    {
        wp_enqueue_script('hq-iframe-resizer-script');
        wp_enqueue_script('hq-resize-script');
        wp_enqueue_style('hq-wordpress-iframe-styles');
    }

    public function loadScrollScript()
    {
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
        wp_localize_script('hq-dummy-script', $this->tenantDatetimeFormatFrontName, $this->settings->getTenantDatetimeFormat());
        wp_localize_script('hq-dummy-script', $this->site, $site . '/');
        wp_localize_script('hq-dummy-script', $this->spinner, plugins_url('hq-rental-software/includes/assets/img/screen-spinner.gif'));
        /*
         * Just for Workspot
         * */
        if ($site == 'http://workspot.test' or $site == 'https://workspot.nu') {
            wp_localize_script('hq-dummy-script', $this->workspotLocationsDataName, $this->workspotQuery->getLocationsToFrontEnd());
        }
    }

    public function loadMapFormAssets()
    {
        wp_enqueue_style('hq-map-form-style');
        wp_enqueue_script("hq-map-form-script");
    }

    public function loadMapContactAssets()
    {
        wp_enqueue_script("hq-map-contact-form-script");
    }

    public function registerAdminAssets()
    {
        /*Setting Screen*/
        wp_register_style('hq-admin-settings-styles', plugin_dir_url(__FILE__) . 'css/hq-admin.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_script('hq-admin-tippy-js', plugin_dir_url(__FILE__) . 'js/tippy.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-admin-popper-js', plugin_dir_url(__FILE__) . 'js/popper.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-admin-admin-js', plugin_dir_url(__FILE__) . 'js/admin.js', array('jquery'), HQ_RENTALS_PLUGIN_VERSION, true);
        /*Brand Edit Screen*/
        wp_register_script('hq-admin-brand-edit-js', plugin_dir_url(__FILE__) . 'js/hq-admin-brand-edit.js', array('jquery'), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_style('hq-admin-brand-css', plugin_dir_url(__FILE__) . 'css/hq-brand.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
    }

    public function loadAssetsForAdminSettingPage()
    {
        wp_enqueue_style('hq-admin-settings-styles');
        wp_enqueue_script('hq-admin-popper-js');
        wp_enqueue_script('hq-admin-tippy-js');
        wp_enqueue_script('hq-admin-admin-js');
        wp_localize_script('hq-admin-admin-js', "hqWebsiteURL", home_url());
    }

    public function adminSectionAssetResolver($hook)
    {
        if ($hook == 'edit.php') {
            if ($_GET['post_type'] == 'hqwp_brands') {
                $query = new HQRentalsQueriesBrands();
                $brands = $query->getAllBrands();
                $data = [];
                foreach ($brands as $brand) {
                    $data[$brand->id]['reservation'] = $brand->snippetReservations;
                    $data[$brand->id]['quote'] = $brand->snippetQuotes;
                    $data[$brand->id]['package'] = $brand->snippetPackageQuote;
                    $data[$brand->id]['payment'] = $brand->snippetPaymentRequest;
                }
                wp_enqueue_style('hq-admin-brand-css');
                wp_enqueue_script('hq-admin-popper-js');
                wp_enqueue_script('hq-admin-tippy-js');
                wp_enqueue_script('hq-admin-brand-edit-js');
                wp_localize_script('hq-admin-brand-edit-js', 'hqBrandSnippets', $data);
            }
        }
    }

    public function shortcodesRegistration()
    {
        wp_register_style('hq-fancy-box-css', plugin_dir_url(__FILE__) . 'css/jquery.fancybox.min.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_style('hq-betheme-sc-vehicle-grid-styles', plugin_dir_url(__FILE__) . 'css/style.betheme.blue.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_style('hq-owl-carousel-css', plugin_dir_url(__FILE__) . 'css/owl.carousel.min.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_style('hq-owl-carousel-theme-css', plugin_dir_url(__FILE__) . 'css/owl.theme.default.min.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_script('hq-fancy-box-js', plugin_dir_url(__FILE__) . 'js/jquery.fancybox.min.js', array('jquery'), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-owl-carousel-js', plugin_dir_url(__FILE__) . 'js/owl.carousel.min.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        /*Inits*/
        wp_register_script('hq-betheme-vehicle-grid-js', plugin_dir_url(__FILE__) . 'js/hq-betheme-vehicle-grid.js', array('jquery'), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-betheme-vehicle-carousel-js', plugin_dir_url(__FILE__) . 'js/hq-betheme-vehicle-carousel.js', array('jquery'), HQ_RENTALS_PLUGIN_VERSION, true);
    }

    public function loadAssetsForAvailabilityGrid()
    {
        wp_enqueue_style('hq-availability-grip-styles');
        wp_enqueue_style('r-suite-default-style');
        wp_enqueue_script('hq-availability-grip-script');

    }

    public function loadDatePickersReservationAssets()
    {
        wp_enqueue_style('hq-datepicker-style');
        wp_enqueue_script('hq-moment');
        wp_enqueue_script('hq-datepicker-js');
        wp_enqueue_script('hq-reservation-form-setup');
        $data = array(
            'HQFormatDate' => $this->settings->getFrontEndDatetimeFormat()
        );
        wp_localize_script('hq-reservation-form-setup', 'HQReservationFormData', $data);
    }

    public function gCarVehicleFilterAssets()
    {
        wp_enqueue_script('hg-gcar-vehicle-filter-js');
    }

    public function datePickersAssets()
    {
        wp_enqueue_style('hq-datepicker-style');
        wp_enqueue_script('hq-datepicker-js');
        wp_enqueue_script('hq-moment');
        wp_enqueue_script('hq-wordpress-dates-js');
    }

    public static function getHQFontAwesome()
    {
        echo '<link rel="stylesheet" href="https://caag.caagcrm.com/assets/font-awesome">';
    }
    public static function getHQLogo()
    {
        return plugin_dir_url(__FILE__) . 'img/logo.png';
    }
}
