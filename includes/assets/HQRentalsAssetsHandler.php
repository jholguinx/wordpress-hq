<?php

namespace HQRentalsPlugin\HQRentalsAssets;

use HQRentalsPlugin\HQRentalsHelpers\HQRentalsDatesHelper;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsDBQueriesCarRentalSetting;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesBrands;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesLocations;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesVehicleClasses;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesWorkspotLocations;
use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings;


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
    protected $hqMomentDateFormat = 'hqMomentDateFormat';
    protected $site = 'hqSite';
    protected $spinner = 'hqSpinner';
    protected $hqCarRentalSettingDefaultPickupTime = 'hqCarRentalSettingDefaultPickupTime';
    protected $hqCarRentalSettingDefaultReturnTime = 'hqCarRentalSettingDefaultReturnTime';

    public function __construct()
    {
        static::$count++;
        $this->brandQueries = new HQRentalsQueriesBrands();
        $this->locationQueries = new HQRentalsQueriesLocations();
        $this->vehicleQueries = new HQRentalsQueriesVehicleClasses();
        $this->settings = new HQRentalsSettings();
        $this->queryCarRentalSetting = new HQRentalsDBQueriesCarRentalSetting();
        $this->helper = new HQRentalsDatesHelper();
        $this->workspotQuery = new HQRentalsQueriesWorkspotLocations();
        if (static::$count === 1) {
            add_action('wp_enqueue_scripts', array($this, 'registerPluginAssets'), 10);
            add_action('wp_enqueue_scripts', array($this, 'registerAndEnqueueFrontEndGlobalVariables'), 20);
            add_action('admin_enqueue_scripts', array($this, 'registerAdminAssets'), 20);
            add_action('admin_enqueue_scripts', array($this, 'adminSectionAssetResolver'), 50);
        }
    }

    public function registerPluginAssets()
    {
        /*
         * refactor - add static array and register everything separate
         * */
        wp_register_style('hq-wheelsberry-styles', plugin_dir_url(__FILE__) . 'css/wheelsberry/style.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_style('hq-wheelsberry-custom-styles', plugin_dir_url(__FILE__) . 'css/wheelsberry/style-custom.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_style('hq-wheelsberry-om-font-styles', plugin_dir_url(__FILE__) . 'css/wheelsberry/omFont.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_style('hq-wheelsberry-responsive-mobile', plugin_dir_url(__FILE__) . 'css/wheelsberry/responsive-mobile.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_style('hq-wheelsberry-slider-css', plugin_dir_url(__FILE__) . 'css/hq-wheelsberry-slider.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_style('hq-elementor-vehicle-grid-widget-css', plugin_dir_url(__FILE__) . 'css/hq-elementor-vehicle-grid-widget.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_style('hq-places-form-css', plugin_dir_url(__FILE__) . 'css/hq-places-form.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_style('hq-flatpickr-css', plugin_dir_url(__FILE__) . 'css/flatpickr.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
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
        wp_register_script('hq-smooth-js', plugin_dir_url(__FILE__) . 'js/smooth-scroll.min.js', array('jquery'), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-daysjs-js', plugin_dir_url(__FILE__) . 'js/dayjs.min.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-daysjs-custom-js', plugin_dir_url(__FILE__) . 'js/daysjs-customParseFormat.min.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-datepicker-js', plugin_dir_url(__FILE__) . 'js/jquery.datetimepicker.full.min.js', array('jquery'), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-flatpickr-locale-es-js', plugin_dir_url(__FILE__) . 'js/locales/es.min.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-flatpickr-locale-fr-js', plugin_dir_url(__FILE__) . 'js/locales/fr.min.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-flatpickr-js', plugin_dir_url(__FILE__) . 'js/flatpickr.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-wordpress-openlayer-js', plugin_dir_url(__FILE__) . 'js/ol.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-wordpress-workspot-js', plugin_dir_url(__FILE__) . 'js/hq-workspot-maps.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-resize-script', plugin_dir_url(__FILE__) . 'js/hq-resize.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-scroll-script', plugin_dir_url(__FILE__) . 'js/hq-scroll-to-top.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-submit-script', plugin_dir_url(__FILE__) . 'js/hq-submit.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-dummy-script', plugin_dir_url(__FILE__) . 'js/hq-dummy.js', array('jquery'), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-wordpress-dates-js', plugin_dir_url(__FILE__) . 'js/hq-dates-pickers.js', array('jquery'), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-workspot-sc-script', plugin_dir_url(__FILE__) . 'js/hq-workspot-map-shortcode.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-map-form-script', plugin_dir_url(__FILE__) . 'js/hq-map-booking-form.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-map-contact-form-script', plugin_dir_url(__FILE__) . 'js/hq-map-contact-form.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-availability-grip-script', plugin_dir_url(__FILE__) . 'js/hq-availability-grid.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hg-gcar-vehicle-filter-js', plugin_dir_url(__FILE__) . 'js/hq-gcar-vehicle-filter.js', array(), HQ_RENTALS_PLUGIN_VERSION . '1', true);
        wp_register_script('hq-reservation-form-setup', plugin_dir_url(__FILE__) . 'js/hq-reservation-form-setup.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-places-form-js', plugin_dir_url(__FILE__) . 'js/hq-places-form.js', array('jquery'), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-carousel-js', plugin_dir_url(__FILE__) . 'js/hq-carousel.js', array('jquery'), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_style('hq-fancy-box-css', plugin_dir_url(__FILE__) . 'css/jquery.fancybox.min.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_style('hq-betheme-sc-vehicle-grid-styles', plugin_dir_url(__FILE__) . 'css/style.betheme.blue.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_style('hq-owl-carousel-css', plugin_dir_url(__FILE__) . 'css/owl.carousel.min.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_style('hq-owl-carousel-theme-css', plugin_dir_url(__FILE__) . 'css/owl.theme.default.min.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_script('hq-fancy-box-js', plugin_dir_url(__FILE__) . 'js/jquery.fancybox.min.js', array('jquery'), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-owl-carousel-js', plugin_dir_url(__FILE__) . 'js/owl.carousel.min.js', array(), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_style('hq-slider-pro-css', plugin_dir_url(__FILE__) . 'css/jquery.sliderPro.min.css', array(), HQ_RENTALS_PLUGIN_VERSION, 'all');
        wp_register_script('hq-slider-pro-js', plugin_dir_url(__FILE__) . 'js/jquery.sliderPro.min.js', array('jquery'), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-aucapina-vehicle-page-js', plugin_dir_url(__FILE__) . 'js/hq-aucapina-vehicle-page.js', array('jquery'), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-aucapina-reservation-form-js', plugin_dir_url(__FILE__) . 'js/hq-aucapina-reservation-form.js', array('jquery'), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-page-vehicle-class-big-header-js', plugin_dir_url(__FILE__) . 'js/hq-page-vehicle-class-big-header.js', array('jquery'), HQ_RENTALS_PLUGIN_VERSION, true);

        /*Inits*/
        wp_register_script('hq-betheme-vehicle-grid-js', plugin_dir_url(__FILE__) . 'js/hq-betheme-vehicle-grid.js', array('jquery'), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_register_script('hq-betheme-vehicle-carousel-js', plugin_dir_url(__FILE__) . 'js/hq-betheme-vehicle-carousel.js', array('jquery'), HQ_RENTALS_PLUGIN_VERSION, true);
        wp_enqueue_script('hq-dummy-script');
        global $post;
        $theme = wp_get_theme();
        if (is_single() and $post->post_type === 'hqwp_veh_classes' and $theme->stylesheet === 'grandcarrental') {
            $this->datePickersAssets();
        }
        /*
         * @TODO : Theme Manager Class => Devices with theme are install
         * @TODO : Register Scripts if Themes are installed
         * */
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
        $pick_up_time_setting = $this->queryCarRentalSetting->getCarRentalSetting('default_pick_up_time');
        $return_time_setting = $this->queryCarRentalSetting->getCarRentalSetting('default_return_time');
        $pick_up_time_setting->transformTimeSettingToMoment();
        $return_time_setting->transformTimeSettingToMoment();
        wp_localize_script('hq-dummy-script', $this->brandsGlobalFrontName, $this->brandQueries->allToFrontEnd());
        wp_localize_script('hq-dummy-script', $this->locationsGlobalFrontName, $this->locationQueries->allToFrontEnd());
        wp_localize_script('hq-dummy-script', $this->vehiclesGlobalFrontName, $this->vehicleQueries->allToFrontEnd());
        wp_localize_script('hq-dummy-script', $this->hqCarRentalSettingDefaultPickupTime, $pick_up_time_setting->getPublicInterface());
        wp_localize_script('hq-dummy-script', $this->hqCarRentalSettingDefaultReturnTime, $return_time_setting->getPublicInterface());
        // move this for header or other place on WP
        wp_add_inline_script('hq-dummy-script', 'var ' . $this->frontDateFormatFrontName . '=' . '"' . $this->settings->getFrontEndDatetimeFormat() . '"', 'before');
        wp_add_inline_script('hq-dummy-script', 'var ' . $this->systemDateFormatFrontName . '=' . '"' . $this->settings->getHQDatetimeFormat() . '"', 'before');
        wp_add_inline_script('hq-dummy-script', 'var ' . $this->tenantDatetimeFormatFrontName . '=' . '"' . $this->settings->getTenantDatetimeFormat() . '"', 'before');
        wp_add_inline_script('hq-dummy-script', 'var ' . $this->hqMomentDateFormat . '=' . '"' . $this->helper->convertPhpToJsMomentFormat($this->settings->getTenantDatetimeFormat()) . '"', 'before');
        wp_add_inline_script('hq-dummy-script', 'var ' . $this->site. '=' . '"' . $site . '/"', 'before');
        wp_add_inline_script('hq-dummy-script', 'var ' . $this->spinner. '=' . '"' . plugins_url('hq-rental-software/includes/assets/img/screen-spinner.gif') . '"', 'before');
        /*
         * Just for Workspot
         * */
        if ($site == 'http://workspot.test' or $site == 'https://workspot.nu') {
            wp_localize_script('hq-dummy-script', $this->workspotLocationsDataName, $this->workspotQuery->getLocationsToFrontEnd());
        }
    }
    public function registerGoogleAssets()
    {
        $key = $this->settings->getGoogleAPIKey();
        wp_register_script('hq-google-js', "https://maps.googleapis.com/maps/api/js?key={$key}&libraries=places&callback=initPlacesForm", array(), HQ_RENTALS_PLUGIN_VERSION, true);
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
        wp_register_script('hq-metro-js', plugin_dir_url(__FILE__) . 'js/metro.min.js', array('jquery'), HQ_RENTALS_PLUGIN_VERSION, true);
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
        wp_enqueue_script('hq-metro-js');
        wp_enqueue_script('hq-admin-popper-js');
        wp_enqueue_script('hq-admin-tippy-js');
        wp_enqueue_script('hq-admin-admin-js');
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

    public static function getHQFontAwesome() : void
    {
        echo '<link rel="stylesheet" href="https://caag.caagcrm.com/assets/font-awesome">';
    }
    public static function getHQFontAwesomeForHTML() : string
    {
        return '<link rel="stylesheet" href="https://caag.caagcrm.com/assets/font-awesome">';
    }
    public static function getHQLogo()
    {
        return plugin_dir_url(__FILE__) . 'img/logo.png';
    }
    public static function loadVehicleGridAssets()
    {
        wp_enqueue_style('hq-flatpickr-css');
        wp_enqueue_style('hq-elementor-vehicle-grid-widget-css');
        wp_enqueue_script('hq-flatpickr-js');
    }
    public function loadPlacesReservationAssets()
    {
        $this->registerGoogleAssets();
        wp_enqueue_style('hq-places-form-css');
        wp_enqueue_style('hq-datepicker-style');
        wp_enqueue_script('hq-daysjs-custom-js');
        wp_enqueue_script('hq-daysjs-js');
        wp_enqueue_script('hq-datepicker-js');
        wp_enqueue_script('hq-places-form-js');
        wp_enqueue_script('hq-google-js');
    }
    public function loadReservationFormRentit()
    {

    }
    public function loadOwlCarouselAssets()
    {
        wp_enqueue_style('hq-owl-carousel-css');
        wp_enqueue_style('hq-fancy-box-css');
        wp_enqueue_style('hq-owl-carousel-theme-css');
        wp_enqueue_script('hq-fancy-box-js');
        wp_enqueue_script('hq-owl-carousel-js');
        wp_enqueue_script('hq-smooth-js');
        wp_enqueue_script('hq-carousel-js');

    }
    public function loadWheelsberryCSS()
    {
        wp_enqueue_style('hq-wheelsberry-styles');
        wp_enqueue_style('hq-wheelsberry-slider-css');
        wp_enqueue_style('hq-wheelsberry-custom-styles');
        wp_enqueue_style('hq-wheelsberry-om-font-styles');
        wp_enqueue_style('hq-wheelsberry-responsive-mobile');
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_style('select2');
        wp_enqueue_script('select2');
        add_action('wp_footer', function(){
            echo "
            <script>
                        jQuery('#reservation-form__pick-up-date-input').datepicker({
                            nextText: '',
                            prevText: '',
                            minDate: 0,
                            dateFormat: jQuery('#reservation-form__pick-up-date-input').data('date-format'),
                            beforeShow: function(input, dp){
                                jQuery(dp.dpDiv).css('min-width',jQuery(input).outerWidth() - 2 + 'px');
                            },
                            onSelect: function(date) {
                                jQuery('#reservation-form__drop-off-date-input').datepicker('option', 'minDate', date);
                                jQuery(this).trigger('change');
                            }
                        });
                        jQuery('#reservation-form__drop-off-date-input').datepicker({
                            nextText: '',
                            prevText: '',
                            minDate: 0,
                            dateFormat: jQuery('#reservation-form__pick-up-date-input').data('date-format'),
                            beforeShow: function(input, dp){
                                jQuery(dp.dpDiv).css('min-width',jQuery(input).outerWidth() - 2 + 'px');
                            },
                            onSelect: function(date) {
                                jQuery('#reservation-form__drop-off-date-input').datepicker('option', 'minDate', date);
                                jQuery(this).trigger('change');
                            }
                        });
                        jQuery('#reservation-form__car-select').on('change',function(){
                            if(jQuery('#reservation-form__car-select').val()){
                                jQuery('#reservation-form__car-select-label').html('');
                            }else {
                                jQuery('#reservation-form__car-select-label').html('Choose a car');
                            }
                        });
                        
                    </script>
                ";
        },100,100);
    }
    public function loadAucapinaVehiclePageAssets()
    {
        wp_enqueue_style('hq-fancy-box-css');
        wp_enqueue_style('hq-slider-pro-css');
        wp_enqueue_script('hq-fancy-box-js');
        wp_enqueue_script('hq-slider-pro-js');
        wp_enqueue_script('hq-aucapina-vehicle-page-js');
    }
    public function loadAucapinaReservationFormAssets()
    {
        wp_enqueue_style('hq-flatpickr-css');
        wp_enqueue_script('hq-flatpickr-locale-fr-js');
        wp_enqueue_script('hq-flatpickr-locale-es-js');
        wp_enqueue_script('hq-flatpickr-js');
        wp_enqueue_script('hq-daysjs-js');
        wp_enqueue_script('hq-daysjs-custom-js');
        wp_enqueue_script('hq-aucapina-reservation-form-js');
    }
    public function loadAssetsForAvailabilityGridFilter()
    {
        wp_enqueue_style('hq-availability-grip-styles');
    }
    public function loadAssetsForBigHeaderPageTemplate()
    {
        wp_enqueue_style('hq-datepicker-style');
        wp_enqueue_script('hq-daysjs-custom-js');
        wp_enqueue_script('hq-daysjs-js');
        wp_enqueue_script('hq-datepicker-js');
        wp_enqueue_script('hq-page-vehicle-class-big-header-js');
    }
    static public function getLogoForAdminArea() : string
    {
        return plugin_dir_url(__FILE__) . 'img/hq-admin-logo.svg';
    }
    static public function getLogoForAdminMenu() : string
    {
        return plugin_dir_url(__FILE__) . 'img/logo-admin.png';
    }
    static public function getDefaultMapMarkerImage() : string
    {
        return plugin_dir_url(__FILE__) . 'img/map-marker.webp';
    }
}
