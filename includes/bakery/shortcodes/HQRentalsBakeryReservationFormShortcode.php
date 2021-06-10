<?php
use \HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use \HQRentalsPlugin\HQRentalsQueries\HQRentalsDBQueriesBrands;
use \HQRentalsPlugin\HQRentalsShortcodes\HQRentalsReservationFormSnippetShortcode;
new HQRentalsBakeryReservationFormShortcode();

class HQRentalsBakeryReservationFormShortcode extends WPBakeryShortCode{
    private $query;
    public function __construct()
    {
        add_action('vc_before_init', array($this, 'setParams'));
        add_shortcode('hq_bakery_reservation_form', array($this, 'content'));
        $this->query = new HQRentalsDBQueriesBrands();
    }

    public function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
            'id' => 	'',
        ), $atts ) );

        $shortcode = new HQRentalsReservationFormSnippetShortcode($atts);
        echo $shortcode->renderShortcode();
    }
    public function setParams(){
        vc_map(
            array(
                'name'                    => __( 'HQ Reservation Form', 'hq-wordpress' ),
                'base'                    => 'hq_bakery_reservation_form',
                'content_element'         => true,
                "category" => __('HQ Rental Software'),
                'show_settings_on_create' => true,
                'description'             => __( 'Reservation Form', 'hq-wordpress'),
                'icon'					  =>	HQRentalsAssetsHandler::getHQLogo(),
                'params' => array(
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Brands', 'hq-wordpress' ),
                        'param_name'  => 'id',
                        'value' => $this->query->getBrandsForBakery()
                    ),

                )
            )
        );
    }
}