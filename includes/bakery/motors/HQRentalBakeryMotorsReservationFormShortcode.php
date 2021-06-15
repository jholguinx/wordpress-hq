<?php

use \HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use \HQRentalsPlugin\HQRentalsQueries\HQRentalsDBQueriesVehicleClasses;
use HQRentalsPlugin\HQRentalsHelpers\HQRentalsFrontHelper;

new HQRentalBakeryMotorsReservationFormShortcode();


class HQRentalBakeryMotorsReservationFormShortcode extends WPBakeryShortCode
{
    private $query;
    private $reservationURL;

    public function __construct()
    {
        add_action('vc_before_init', array($this, 'setParams'));
        add_shortcode('hq_bakery_motors_reservation_form', array($this, 'content'));
        $this->query = new HQRentalsDBQueriesVehicleClasses();
        $this->assets = new HQRentalsAssetsHandler();
        $this->helper = new HQRentalsFrontHelper();
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
                'name' => __('HQ Motors Reservation Form', 'hq-wordpress'),
                'base' => 'hq_bakery_motors_reservation_form',
                'content_element' => true,
                "category" => __('HQ Rental Software - Motors Theme'),
                'show_settings_on_create' => true,
                'description' => __('HQ Motors Reservation Form', 'hq-wordpress'),
                'icon' => HQRentalsAssetsHandler::getHQLogo(),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Reservation URL', 'hq-wordpress'),
                        'param_name' => 'reservation_page_url',
                        'value' => ''
                    )
                )
            )
        );
    }

    public function renderShortcode()
    {
        $this->assets->loadDatePickersReservationAssets();
        $locations_options = $this->helper->getLocationOptions();
        return HQRentalsAssetsHandler::getHQFontAwesome() . "
            <div class='stm_rent_car_form_wrapper style_1 text-right'>
                <div class='stm_rent_car_form'>
                        <form action='{$this->reservationURL}' method='get'>
                        <div class='hq-motors-input-wrapper'>
                            <h4>Pickup</h4>
                            <div class='stm_rent_form_fields'>
                                <div class='stm_pickup_location'>
                                    <i class='stm-service-icon-pin'></i>
                                    <select id='hq-pick-up-location' name='pick_up_location' required='required'>
                                        <option value=''>Select Location</option>
                                        ". $locations_options ."
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class='hq-motors-input-wrapper'>
                            <h4>Return</h4>
                            <div class='stm_rent_form_fields'>
                                <div class='stm_pickup_location'>
                                    <i class='stm-service-icon-pin'></i>
                                    <select id='hq-return-location' name='return_location' required='required'>
                                        <option value=''>Select Location</option>
                                        ". $locations_options ."
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class='hq-motors-input-wrapper'>
                            <h4>From</h4>
                            <div class='stm_date_time_input'>
                                <div class='stm_date_input'>
                                    <input type='text' id='hq_pick_up_date' class=' active' name='pick_up_date' placeholder='Today' readonly='' required='required'>
                                    <i class='stm-icon-date'></i>
                                </div>
                            </div>
                        </div>
                        <div class='hq-motors-input-wrapper'> 
                            <h4>Until</h4>
                            <div class='stm_date_time_input'>
                                <div class='stm_date_input'>
                                    <input type='text' id='hq_return_date' class=' active' name='return_date' placeholder='Tomorrow' readonly='' required='required'>
                                    <i class='stm-icon-date'></i>
                                </div>
                            </div>
                        </div>
                        <div class='hq-motors-input-wrapper'>
                            <button type='submit'>Book<i class='fa fa-arrow-right'></i></button>
                        </div>    
                        </form>
                </div>
            </div>
            <style>
                .stm-template-car_rental .stm_date_time_input,.stm-template-car_rental .stm_date_time_input{
                    margin-bottom: 0px !important;
                }
                .hq-motors-input-wrapper{
                    padding-top: 5px;
                    padding-bottom: 5px; 
                }
            </style>
        ";
    }
}