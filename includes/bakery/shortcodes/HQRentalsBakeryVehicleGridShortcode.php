<?php
use \HQRentalsPlugin\HQRentalsShortcodes\HQRentalsVehicleGrid;
use \HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
new HQRentalsBakeryVehicleGridShortcode();
class HQRentalsBakeryVehicleGridShortcode extends WPBakeryShortCode{
    public function __construct()
    {
        add_action('vc_before_init', array($this, 'setParams'));
        add_shortcode('hq_bakery_vehicle_grid', array($this, 'content'));
    }

    public function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
            'title' => 	'',
            'url'   =>	'',

        ), $atts ) );
        $shortcode = new HQRentalsVehicleGrid($atts);
        $shortcode->renderShortcode();
    }
    public function setParams(){
        vc_map(
            array(
                'name'                    => __( 'HQ Vehicle Grid', 'hq-wordpress' ),
                'base'                    => 'hq_bakery_vehicle_grid',
                'content_element'         => true,
                "category" => __('HQ Rental Software'),
                'show_settings_on_create' => true,
                'description'             => __( 'Vehicle Classes Grid', 'hq-wordpress'),
                'icon'					  =>	HQRentalsAssetsHandler::getHQLogo(),
                'params' => array(
                    array(
                        'type'        => 'textfield',
                        'heading'     => __( 'Reservation URL', 'hq-wordpress' ),
                        'param_name'  => 'url',
                        'value'       => ''
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __( 'Title', 'hq-wordpress' ),
                        'param_name'  => 'title',
                        'value'       => ''
                    ),
                )
            )
        );
    }
}