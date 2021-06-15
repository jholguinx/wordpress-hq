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
        add_shortcode('hq_bakery_motors_vehicle_grid', array($this, 'content'));
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
                'name' => __('HQ Reservation Form', 'hq-wordpress'),
                'base' => 'hq_bakery_motors_reservation_form',
                'content_element' => true,
                "category" => __('HQ Rental Software - Motors Theme'),
                'show_settings_on_create' => true,
                'description' => __('HQ Reservation Form', 'hq-wordpress'),
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
        extract( shortcode_atts( array(
            'pick_up_location_label'	        =>	'',
            'pick_up_location_placeholder'	    =>	'',
            'pick_up_date_label'	            =>	'',
            'pick_up_date_placeholder'	        =>	'',
            'return_date_label'		            =>	'',
            'return_date_placeholder'	        =>	'',
            'button_text'                       =>  '',
            'alignment'                         =>  'text-left',
            'action_link'	                    =>	'',
            'pickup_locations'                  =>  '',
            'return_locations'                  =>  '',
            'return_location_label'             =>  '',
            'return_location_placeholder'       =>  '',
            'delivery_location_label'           =>  '',
            'delivery_location_placeholder'     =>  '',
            'collection_location_label'         =>  '',
            'collection_location_placeholder'   =>  '',
            'multiple_brands'                   =>  false,
            'brands_links'                      =>  [],
            'pick_brand_label'                  =>  '',
            'pick_brand_placeholder'            =>  ''
        ), $atts ) );
        $this->assets->loadDatePickersReservationAssets();
        $locations_options = $this->helper->getLocationOptions();
        echo HQRentalsAssetsHandler::getHQFontAwesome() . "
            <div class='stm_rent_car_form_wrapper caag-book-form-style style_1 <?php echo alignment; ?>'>
                <div class='stm_rent_car_form'>
                        <form id='caag-book-form' action='<?php echo action_link; ?>' method='post'>
                            <h4>Pickup Location</h4>
                            <div class='stm_rent_form_fields'>
                                <div class='stm_pickup_location'>
                                    <i class='stm-service-icon-pin'></i>
                                    <select id='hq-pick-up-location' name='pick_up_location' data-class='stm_rent_location' tabindex='-1' class='select2-hidden-accessible' aria-hidden='true'>
                                        <option value=''>Select Location</option>
                                        ". $locations_options ."
                                    </select>
                                </div>
                            </div>
                            <h4>Return Location</h4>
                            <div class='stm_rent_form_fields'>
                                <div class='stm_pickup_location'>
                                    <i class='stm-service-icon-pin'></i>
                                    <select id='hq-return-location' name='return_location' data-class='stm_rent_location' tabindex='-1' class='select2-hidden-accessible' aria-hidden='true'>
                                        <option value=''>Select Location</option>
                                        ". $locations_options ."
                                    </select>
                                </div>
                                <h4>Pickup Date</h4>
                                <div class='stm_date_time_input'>
                                    <div class='stm_date_input'>
                                        <input type='text' id='hq_pick_up_date' class=' active' name='pick_up_date' placeholder='Today' required='' readonly=''>
                                        <i class='stm-icon-date'></i>
                                    </div>
                                </div>
                            </div>
                            <h4>Return Date</h4>
                            <div class='stm_rent_form_fields stm_rent_form_fields-drop'>
                                <div class='stm_date_time_input'>
                                    <div class='stm_date_input'>
                                        <input type='text' id='hq_return_date' class=' active' name='return_date' placeholder='Tomorrow' required='' readonly=''>
                                        <i class='stm-icon-date'></i>
                                    </div>
                                </div>
                            </div>
                            <button type='submit'>Book<i class='fa fa-arrow-right'></i></button>
                        </form>
                </div>
            </div>
            <style>
                .stm-template-car_rental .stm_rent_location .select2-dropdown{
                    min-height: 0px;
                }
                #hq-delivery-location-wrapper, #hq-collection-location-wrapper {
                    display: none;
                }
                .hq-text-fields{
                    padding-left: 37px;
                    height: 40px;
                    line-height: 40px;
                    background-color: #fff;
                    border: 0;
                }
            </style>
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