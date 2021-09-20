<?php

use HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsDBQueriesBrands;
use \HQRentalsPlugin\HQRentalsShortcodes\HQRentalsPlacesReservationForm;


class HQRentalsBakeryPlacesReservationForm extends WPBakeryShortCode{
    public function __construct()
    {
        $this->query = new HQRentalsDBQueriesBrands();
        add_action('vc_before_init', array($this, 'setParams'));
        add_shortcode('hq_bakery_places_reservation_form', array($this, 'content'));
    }

    public function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
            'reservation_url_places_form' => 	'',
            'orientation_places_form'   =>	'horizontal',
            'title' => ''
        ), $atts ) );
        $shortcode = new HQRentalsPlacesReservationForm($atts);
        return $shortcode->renderShortcode();
    }
    public function setParams(){
        vc_map(
            array(
                'name'                    => __( 'HQRS Places Reservation Form', 'hq-wordpress' ),
                'base'                    => 'hq_bakery_places_reservation_form',
                'content_element'         => true,
                "category" => __('HQ Rental Software'),
                'show_settings_on_create' => true,
                'description'             => __( 'Reservation Form with Google Maps Support', 'hq-wordpress'),
                'icon'					  =>	HQRentalsAssetsHandler::getHQLogo(),
                'params' => array(
                    array(
                        'type'        => 'textfield',
                        'heading'     => __( 'Reservation URL', 'hq-wordpress' ),
                        'param_name'  => 'reservation_url_places_form',
                        'value'       => ''
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __( 'Title', 'hq-wordpress' ),
                        'param_name'  => 'title',
                        'value'       => ''
                    ),
                    array(
                        'type'        => 'checkbox',
                        'heading'     => __( 'Support for Custom Location', 'hq-wordpress' ),
                        'param_name'  => 'support_for_custom_location',
                        'value'       => 'yes'
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __( 'Custom Location Label', 'hq-wordpress' ),
                        'param_name'  => 'custom_location_label',
                        'value'       => ''
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __( 'Orientation', 'hq-wordpress' ),
                        'param_name'  => 'orientation_places_form',
                        'value' => ['', 'horizontal', 'vertical']
                    ),
                )
            )
        );
    }
}
new HQRentalsBakeryPlacesReservationForm();