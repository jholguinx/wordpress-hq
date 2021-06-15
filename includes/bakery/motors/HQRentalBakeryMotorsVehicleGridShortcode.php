<?php

use \HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use \HQRentalsPlugin\HQRentalsQueries\HQRentalsDBQueriesVehicleClasses;


new HQRentalBakeryMotorsVehicleGridShortcode();

class HQRentalBakeryMotorsVehicleGridShortcode extends WPBakeryShortCode
{
    private $query;
    private $reservationURL;

    public function __construct()
    {
        add_action('vc_before_init', array($this, 'setParams'));
        add_shortcode('hq_bakery_motors_vehicle_grid', array($this, 'content'));
        $this->query = new HQRentalsDBQueriesVehicleClasses();
    }

    public function content($atts, $content = null)
    {
        extract( shortcode_atts( array(
            'reservation_page_url'				=>	'',

        ), $atts ) );
        $this->reservationURL = $atts['reservation_page_url'];
        echo $this->renderShortcode();
    }

    public function setParams()
    {
        vc_map(
            array(
                'name' => __('HQ Vehicles Classes Grid', 'hq-wordpress'),
                'base' => 'hq_bakery_motors_vehicle_grid',
                'content_element' => true,
                "category" => __('HQ Rental Software - Motors Theme'),
                'show_settings_on_create' => true,
                'description' => __('HQ Vehicles Classes Grid', 'hq-wordpress'),
                'icon' => HQRentalsAssetsHandler::getHQLogo(),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Reservation URL', 'hq-wordpress'),
                        'param_name' => 'reservation_page_url',
                        'value' => ''
                    ),
                )
            )
        );
    }

    public function renderShortcode()
    {
        $html_loop = "";
        $vehicles = $this->query->allVehicleClasses();
        foreach ($vehicles as $vehicle) {
            $html_loop .= $this->resolveSingleVehicleCode($vehicle);
        }
        return HQRentalsAssetsHandler::getHQFontAwesome() . "
            <div class='vc_row wpb_row vc_row-fluid stm-fullwidth-with-parallax vc_custom_1612726915310 vc_row-no-padding'>
                <div class='wpb_column vc_column_container vc_col-sm-12'>
                    <div class='vc_column-inner'>
                        <div class='wpb_wrapper'>
                            <h1 style='font-size: 30px;color: #000000;line-height: 50px;text-align: center' class='vc_custom_heading vc_custom_1611635496249'>Reserve a Vehicle</h1>
                                <div class='stm_products_grid_class'>
                                    ". $html_loop ."
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        ";
    }

    public function resolveSingleVehicleCode($vehicle)
    {
        return "

        <div class='stm_product_grid_single'>
            <a href='{$this->reservationURL}' class='inner'>
                <div class='stm_top clearfix'>
                    <div class='stm_left heading-font'>
                        <h3>{$vehicle->getLabelForWebsite()}</h3>
                        <div class='s_title'></div>
                        <div class='price'>
                            <mark>From</mark>
                            <span class='woocommerce-Price-amount amount'>{$vehicle->getActiveRate()->daily_rate->amount_for_display}<span style='font-size: 12px;'>/day</span></span>
                        </div>
                    </div>
                    ". $this->renderFeatures($vehicle) ."
                </div>
                <div class='stm_image'>
                        <img width='798' height='466'
                        src='{$vehicle->getPublicImage()}' />
                    </div>
            </a>
        </div>
        ";
    }
    public function renderFeatures($vehicle)
    {
        $html = "";
        if(is_array($vehicle->getVehicleFeatures()) and count($vehicle->getVehicleFeatures())){
            foreach ($vehicle->getVehicleFeatures() as $feature){
                $html .= "
                    <div class='single_info'>
                        <i class='{$feature->icon}'></i>
                        <span>{$feature->label}</span>
                    </div>
                ";
            }
            return "<div class='stm_right'>". $html ."</div>";
        }
        return $html;
    }
}