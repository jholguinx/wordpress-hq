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
        <style>
            .car_attribute_wrapper{
                width: 65% !important;
            }
            .car_attribute_price{
                width: 35% !important;
            }
            .car_attribute_price_day.four_cols .single_car_price{
                font-size: 21px !important;
            }
            .feature-wrapper{
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }
            .portfolio_filter_wrapper p{
                padding-bottom:5.0em !important;
            }
            .spinner-wrapper img{
                padding-bottom:5.0em !important;
            }
        </style>
        <script src="https://kit.fontawesome.com/d2b6c51265.js" crossorigin="anonymous"></script>
        <div id="hq-gcar-vehicle-filter"></div>
        <?php
    }
}
