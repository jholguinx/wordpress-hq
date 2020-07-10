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
                width: 60% !important;
            }
            .car_attribute_price{
                width: 40% !important;
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
            .button:hover {
                background: #6699cc !important;
                border-color: #6699cc !important;
            }
            .four_cols.gallery .element{
                width: calc(33.33% - 22.5px) !important;
            }
            .four_cols.gallery .element:nth-child(3n){
                float: right !important;
                margin-right: 0 !important;
            }
        </style>
        <script src="https://kit.fontawesome.com/d2b6c51265.js" crossorigin="anonymous"></script>
        <div id="hq-gcar-vehicle-filter"></div>
        <?php
    }
}
