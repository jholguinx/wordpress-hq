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
        add_shortcode('hq_bakery_motors_reservation_form', array($this, 'content'));
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
                "name" => __("HQ - Turbo - Vertical Search Form", "turbo"),
                "base" => "hq_turbo_search_vertical",
                "category" => __('Turbo Shortcode', 'turbo'),
                "icon" => HQRentalsAssetsHandler::getHQLogo(),
                "params" => array(
                    array(
                        "type" => "textfield",
                        "admin_label" => true,
                        "heading" => __("Search Form Title", "turbo"),
                        "param_name" => "search_form_title",
                    ),
                    array(
                        "type" => "textarea_html",
                        "admin_label" => true,
                        "heading" => __("Search Form Description", "turbo"),
                        "param_name" => "content",
                        "description" => __("Enter Search Form Description", "turbo")
                    ),
                    array(
                        "type" => "dropdown",
                        'heading' => __('Choose reactive builder shortcode', 'turbo'),
                        'param_name' => 'reactive_builder_shortcode',
                        "admin_label" => true,
                        'save_always' => true,
                        "value" => turbo_vc_get_posts('reactive_builder'),
                        "description" => __('Choose reactive builder shortcode to render the search form', 'turbo'),
                    ),
                    array(
                        "type" => "attach_image",
                        "admin_label" => true,
                        "heading" => __("Background Image", "turbo"),
                        "param_name" => "background_image_id",
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Customize Block', 'turbo'),
                        'param_name' => 'bg_css',
                        'group' => __('Design options', 'turbo'),
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
            <div id='hq-turbo-reservation-form' class='header turbo-vertical-search-wrapper index-two-header'>
                <div class='header-body' style='background: url(https://ecoscooters.test/wp-content/uploads/2022/02/Banner_01_v3.jpg) top center no-repeat; background-size: 100% auto;'>
                    <div class='container'>
                        <div class='turbo-vertical-search-area'>
                            <div class='search-header'>
                                <h3>Make Your Ride</h3>
                                <p>Best bike rental in Tulum</p>
                            </div>
                            <div class='turbo-obb-vertical-search-form'>
                                <div class='turbo-horizontal-search-oob'>
                                    <div>
                                        <div>
                                            <label for=''></label>
                                        </div>
                                        <div>
                                            <select name='' id=''>
                                                {$locations_options}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ";
    }
}