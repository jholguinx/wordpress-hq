<?php

use HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use HQRentalsPlugin\HQRentalsHelpers\HQRentalsFrontHelper;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsDBQueriesLocations;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsDBQueriesVehicleClasses;

new HQRentalBakeryTurboReservationForm();

class HQRentalBakeryTurboReservationForm extends WPBakeryShortCode
{
    private $query;
    private $reservationURL;
    private $minimumRentalPeriod;

    public function __construct()
    {
        add_action('vc_before_init', array($this, 'setParams'));
        add_shortcode('hq_turbo_reservation_form', array($this, 'content'));
        $this->query = new HQRentalsDBQueriesVehicleClasses();
        $this->queryLocations = new HQRentalsDBQueriesLocations();
        $this->assets = new HQRentalsAssetsHandler();
        $this->helper = new HQRentalsFrontHelper();
    }

    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'reservation_page_url' => '',
            'minimum_rental_period' => 1
        ), $atts));
        $this->reservationURL = $atts['reservation_page_url'];
        $this->minimumRentalPeriod = $atts['minimum_rental_period'];
        echo $this->renderShortcode();
    }

    public function setParams()
    {
        vc_map(
            array(
                "name" => __("HQ - Turbo - Vertical Search Form", "hq-wordpress"),
                "base" => "hq_turbo_reservation_form",
                "category" => __('Turbo Shortcode', 'hq-wordpress'),
                "icon" => HQRentalsAssetsHandler::getHQLogo(),
                "params" => array(
                    array(
                        "type" => "textfield",
                        "admin_label" => true,
                        "heading" => __("Search Form Title", "hq-wordpress"),
                        "param_name" => "search_form_title",
                    ),
                    array(
                        "type" => "textfield",
                        "admin_label" => true,
                        "heading" => __("Search Form Description", "hq-wordpress"),
                        "param_name" => "content",
                        "description" => __("Enter Search Form Description", "hq-wordpress")
                    ),
                    array(
                        "type" => "textfield",
                        "admin_label" => true,
                        "heading" => __("Reservation Page Screen", "hq-wordpress"),
                        "param_name" => "action_url",
                        "description" => __("Enter the URL from the Reservation Engine Page", "hq-wordpress")
                    ),
                    array(
                        "type" => "attach_image",
                        "admin_label" => true,
                        "heading" => __("Background Image", "hq-wordpress"),
                        "param_name" => "background_image_id",
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Customize Block', 'hq-wordpress'),
                        'param_name' => 'bg_css',
                        'group' => __('Design options', 'hq-wordpress'),
                    ),
                )
            )
        );
    }

    public function renderShortcode()
    {
        $this->assets->loadDatePickersReservationAssets();
        $locations = $this->queryLocations->allLocations();
        $locations_options = $this->helper->getLocationOptions($locations);
        return HQRentalsAssetsHandler::getHQFontAwesome() . "
            <style>
                .hq-turbo-label{
                    display: block;
                    color: #2d3748;
                    font-size: 16px;
                    font-weight: 600;
                    text-transform: uppercase;
                    margin-bottom: 0;
                }
                .hq-turbo-input-group-wrapper{
                    padding-bottom: 20px;
                }
                #hq-turbo-reservation-form select,
                #hq-turbo-reservation-form input{
                    width: 100%;
                    max-width: 100% !important;
                }
                .hq-turbo-input-label-wrapper{
                    padding-bottom: 10px;
                }
                .hq-turbo-submit-button{
                    width: 100%;
                    max-width: 100%;
                    font-size: 14px;
                    font-weight: 700;
                    color: #fdfdfd;
                    display: inline-block;
                    background: none;
                    text-align: center;
                    background-color: #454545;
                    padding: 0 30px;
                    height: 42px;
                    line-height: 42px;
                    outline: 0;
                    border: 0;
                    cursor: pointer;
                    text-decoration: none;
                }
            </style>
            <div id='hq-turbo-reservation-form' class='header turbo-vertical-search-wrapper index-two-header'>
                <div class='header-body' style='background: url(https://ecoscooters.test/wp-content/uploads/2022/02/Banner_01_v3.jpg) top center no-repeat; background-size: 100% auto;'>
                    <div class='container'>
                        <div class='turbo-vertical-search-area'>
                            <div class='search-header'>
                                <h3>Make Your Ride</h3>
                                <p>Best bike rental in Tulum</p>
                            </div>
                            <form action='get' method='get'>
                                <div class='turbo-obb-vertical-search-form'>
                                    <div class='turbo-horizontal-search-oob'>
                                        <div class='hq-turbo-input-group-wrapper'>
                                            <div class='hq-turbo-input-label-wrapper'>
                                                <label class='hq-turbo-label' for=''>PICK UP LOCATION</label>
                                            </div>
                                            <div class='hq-turbo-input-wrapper'>
                                                <select name='' id=''>
                                                    {$locations_options}
                                                </select>
                                            </div>
                                        </div>
                                        <div class='hq-turbo-input-group-wrapper'>
                                            <div class='hq-turbo-input-label-wrapper'>
                                                <label for='' class='hq-turbo-label'>DROP OFF LOCATION</label>
                                            </div>
                                            <div class='hq-turbo-input-wrapper'>
                                                <select name='' id=''>
                                                    {$locations_options}
                                                </select>
                                            </div>
                                        </div>
                                        <div class='hq-turbo-input-group-wrapper'>
                                            <div class='hq-turbo-input-label-wrapper'>
                                                <label for='' class='hq-turbo-label'>CHOOSE DATE</label>
                                            </div>
                                            <div class='hq-turbo-input-wrapper'>
                                                <select name='' id=''>
                                                    {$locations_options}
                                                </select>
                                            </div>
                                        </div>
                                        <div class='hq-turbo-input-group-wrapper'>
                                            <div class='hq-turbo-input-label-wrapper'>
                                               <button type='button' class='hq-turbo-submit-button'>Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        ";
    }
}