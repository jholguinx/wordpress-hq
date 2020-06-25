<?php
namespace HQRentalsPlugin\HQRentalsShortcodes;
use HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use HQRentalsPlugin\HQRentalsHelpers\HQRentalsFrontHelper;
use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings;

class HQGCarVehicleFilterShortcode
{
    public function __construct()
    {
        $this->assets = new HQRentalsAssetsHandler();
        $this->settings = new HQRentalsSettings();
        add_shortcode('hq_gcar_vehicles_filter' , array ($this, 'renderShortcode'));
    }
    public function renderShortcode( $atts = [] )
    {
        $this->assets->gCarVehicleFilterAssets();
        $atts = shortcode_atts(
            array(
                'baseURL'               =>  get_site_url() . '/',
            ), $atts
        );
        $dataToJS = array(
            'baseURL' => get_site_url() . '/',
        );
        wp_localize_script('hq-gcar-vehicle-filter-js', 'HQGCarVehicleFilter', $dataToJS );

        ?>
        <div id="hq-gcar-vehicle-filter"></div>
        <?php
    }
}
